<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ApiModel;
use CodeIgniter\HTTP\ResponseInterface;

class Order extends BaseController
{
    public function index()
    {
        //prepera data

        $data = [];

        //load categories and products from session
        $data['categories'] = session()->get('products_categories');

        //add all the categories to the first page
        array_unshift($data['categories'], ['category' => 'Todos']);

        //load products by category
        $selected_category = session()->get('selected_category');

        if (empty($selected_category)) {
            $selected_category = 'Todos';
        }

        $data['selected_category'] = $selected_category;

        $products = $this->_get_products_by_category($selected_category);

        //calculate product discount, state, etc.
        $products = $this->_set_products_info($products);

        //$selected_category = 'Bebidas';
        $data['products'] = $products;


        //calculate total items in the order
        $data['total_items'] = get_order_total_items();

        $data['total_price'] = get_order_total_price();



        return view('order/main_page', $data);
    }


    private function _get_products_by_category($selected_category)
    {
        //get all the products
        $products = session()->get('products');
        $products_by_category = [];
        //filter the products by category
        if ($selected_category == 'Todos') {
            $products_by_category = $products;
        } else {
            foreach ($products as $product) {
                if ($product['category'] === $selected_category) {
                    $products_by_category[] = $product;
                }
            }
        }
        return $products_by_category;
    }

    private function _set_products_info($products)
    {
        //calculate product discount, state, etc.

        $temp = [];
        //add discount, state, etc. to each product in the array

        for ($index = 0; $index < count($products); $index++) {

            $product = $products[$index];

            //is product available?

            if ($product['availability'] == 0 || !empty($product['deleted_at'])) continue;

            //promotion?
            $this->check_product_promotion($product);

            //stock avalability?

            $this->_check_product_availability($product);


            $temp[] = $product;
        }

        return $temp;
    }


    public function setFilter($category)
    {
        //decrypt category
        if (empty(Decrypt($category))) {
            return redirect()->to(site_url('order'));
        }

        //if is ok, selected category
        session()->set('selected_category', Decrypt($category));

        return redirect()->to(site_url('order'));
    }

    private function check_product_promotion(&$product)
    {
        if ($product['promotion'] > 0) {
            $product['has_promotion'] = true;
            $product['old_price'] = $product['price'];
            $product['price'] = $product['price'] - ($product['price'] * ($product['promotion'] / 100));
        } else {
            $product['has_promotion'] = false;
            $product['old_price'] = 0.0;
        }
    }

    private function _check_product_availability(&$product)
    {
        //stock availability
        //update product availability in session
        if ($product['stock'] <= $product['stock_min_limit']) {
            $product['out_of_stock'] = true;
        } else {
            $product['out_of_stock'] = false;
        }
    }

    public function cancel()
    {
        //check if there is an prder with, at least on item
        $order = get_order();

        if (empty($order['items'])) {
            return redirect()->to(site_url('/'));
        }

        $data['total_items'] = get_order_total_items();


        //show cancel confirmation

        return view('order/cancel_confirmation', $data);
    }

    public function add($enc_id)
    {
        $id = Decrypt($enc_id);
        //check if id is decrypted
        if (empty($id)) {
            return redirect()->to(site_url('order'));
        }

        $product = $this->_get_product_by_id($id);

        if (empty($product)) {
            return redirect()->to(site_url('order'));
        }

        //check if product has promotion

        $this->check_product_promotion($product);

        //check if product is already in the order and get the quantity
        $quantity = get_quantity_in_order($id);


        //if the product does not exists, set quantity to 1

        if (empty($quantity)) {
            $quantity = 1;
        }

        //display page to add product 
        $data['product'] = $product;
        $data['quantity'] = $quantity;

        //redirect to order page
        return view('/order/add', $data);
    }

    public function remove($enc_id)
    {
        $id = Decrypt($enc_id);
        //check if id is decrypted
        if (empty($id)) {
            return redirect()->to(site_url('/order'));
        }

        //remove product from order
        update_order($id, 0, 0.0);

        //redirect to order checkout page
        return redirect()->to(site_url('/order/checkout'));
    }

    private function _get_product_by_id($id)
    {
        //get product from session
        $products = session()->get('products');

        foreach ($products as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }

        return null;
    }


    public function add_confirm($enc_id, $quantity)
    {

        $id = Decrypt($enc_id);
        //check if id  and quantity are valid
        if (empty($id)) {
            return redirect()->to(site_url('/order'));
        }

        //check if quantity is valid
        if ($quantity < 0 || $quantity > MAX_QUANTITY_PER_PRODUCT) {
            return redirect()->to(site_url("/order"));
        }

        //get product from session
        $product = $this->_get_product_by_id($id);

        //check if product has promotion
        $this->check_product_promotion($product);

        //update the order
        update_order($id, $quantity, $product['price']);

        return redirect()->to(site_url('/order'));
    }

    public function checkout()
    {
        //check if order is valid
        $order = get_order();

        //prepare data to display
        $data['total_products'] = get_order_total_items();
        $data['total_price'] = get_order_total_price();

        $order_products = [];

        foreach ($order['items'] as $id_product => $item) {
            $product = $this->_get_product_by_id($id_product);

            //adicional product datails based on the order
            $product['quantity'] = $item['quantity'];

            //calculate total price for each product in the order
            $this->check_product_promotion($product);

            $product['total_price'] = $item['quantity'] * $item['price'];

            //add product to the list
            $order_products[] = $product;
        }

        $data['order_products'] = $order_products;

        return view('/order/checkout', $data);
    }

    public function order_checkout_payment(){
        //check if order is valid
        $order = get_order();

        //prepare data to display
        $data['total_products'] = get_order_total_items();
        $data['total_price'] = get_order_total_price();

        $order_products = [];

        foreach ($order['items'] as $id_product => $item) {
            $product = $this->_get_product_by_id($id_product);

            //adicional product datails based on the order
            $product['quantity'] = $item['quantity'];

            //calculate total price for each product in the order
            $this->check_product_promotion($product);

            $product['total_price'] = $item['quantity'] * $item['price'];

            //add product to the list
            $order_products[] = $product;
        }

        $data['order_products'] = $order_products;

        return view('/order/checkout_payment', $data);
    }

    public function order_payment_process(){
        //validate payment
        $data['total_price'] = get_order_total_price();

        //fake pin number
        $data['pin_number'] =strval(random_int(1000,9999));

        //check if there was an error

        $data['error'] = session()->getFlashdata('error');
        
        //display checkout page (payment simulation)
        return view('/order/payment_process', $data);
    }

    public function checkout_payment_confirm(){
        //get PIN value
        $pin_value = Decrypt($this->request->getPost('pin_value'));
        $pin_number = $this->request->getPost('pin_number');

        //check if PIN is valid
        if(empty($pin_number)){
            return redirect()->back()->with('error','Aconteceu um erro com o PIN. Tente novamente');
        }

        if(empty($pin_number) || !preg_match("/^\d{4}$/",$pin_number) || $pin_number != $pin_value){
            return redirect()->back()->with('error','PIN inválido');
        }

        //prepare data to send the request to the CigBackofi BO API

        $data = [
            'restaurant_id' =>session()->get('restaurant_details')['project_id'],
            'order' => get_order(),
            'machine_id' => session()->get('machine_id')
        ];

        //send request to CigBackofi BO API
        $api = new ApiModel();
        $response = $api->request_checkout($data);

    }
}
