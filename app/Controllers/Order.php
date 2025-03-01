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

       //$selected_category = 'Bebidas';
       $data['products'] = $this->_get_products_by_category($selected_category);

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


    public function setFilter($category){
        //decrypt category
        if(empty(Decrypt($category))){
            return redirect()->to(site_url('order'));
        }

        //if is ok, selected category
        session()->set('selected_category',Decrypt($category));

        return redirect()->to(site_url('order'));
    }
}
