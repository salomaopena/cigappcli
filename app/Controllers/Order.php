<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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
        array_unshift($data['categories'],['category'=>'Todos']);

        //load products by category
        $selected_category = session()->get('selected_category');

        if(empty($selected_category)){
            $selected_category = 'Todos';
        }

       $data['selected_category'] = $selected_category;

       $products = $this->_get_products_by_category($selected_category);

       //calculate product discount, state, etc.
       $products = $this->_set_products_info($products);

       //$selected_category = 'Bebidas';
       $data['products'] = $products;

        //load products from session
        //$data = ['products' => session()->get('products')];

        //dd($data['products']);


        return view('order/main_page', $data);
    }


    private function _get_products_by_category($selected_category){
        //get all the products
            $products = session()->get('products');
            $products_by_category = [];
        //filter the products by category
        if($selected_category=='Todos'){
            $products_by_category = $products;
        }else{
            foreach ($products as $product){
                if($product['category']===$selected_category){
                    $products_by_category[] = $product;
                }
            }
        }
        return $products_by_category;
    }

    private function _set_products_info($products){
        //calculate product discount, state, etc.

        $temp = [];
        //add discount, state, etc. to each product in the array

        for ($index = 0; $index< count($products); $index++){
            
            $product = $products[$index];
            //is product available

            if($product['availability']==0 || !empty($product['deleted_at'])) continue;

            //promotion

            if ($product['promotion'] > 0){
                $product['has_promotion'] = true;
                $product['old_price'] = $product['price'];
                $product['price'] = $product['price'] - ($product['price'] * ($product['promotion'] / 100));
            }else{
                $product['has_promotion'] = false;
                $product['old_price'] = 0.0;

            }
            //state
            if($product['stock']<= $product['stock_min_limit']){
                $product['out_of_stock'] = true;  
            }else{
                $product['out_of_stock'] = false;  
            }

            $temp[] = $product;
        }

        return $temp;
    }


    public function setFilter($category){
        //decrypt category
        if(empty(Decrypt($category))){
            return redirect()->to(site_url('order'));
        }

        //if is ok, selected category
        session()->set('selected_category',Decrypt($category));

        return redirect()->to(site_url('order'));
    }

    public function cancel(){
        //check if there is an prder with, at least on item
        $order = get_order();

        if(empty($order['items'])){
            return redirect()->to(site_url('/'));
        }
        
        //show cancel confirmation
        
        return view('order/cancel_confirmation');
    }

    public function checkout(){
        //check if order is valid
        $order = get_order();
        dd($order);
        if(empty($order)){
            return redirect()->to(site_url('order'));
        }

        //do checkout
        //save order to db
        //clear session
        delete_order();
        die('Pedido realizado com sucesso!');
        //return redirect()->to(site_url('order'));
    }
}
