<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Order extends BaseController
{
    public function index()
    {
        //prepera data
        $data = [
            'categories' => session()->get('products_categories'),
            'products' => session()->get('products'),
        ];

        //add all the categories to the first page

        array_unshift($data['categories'],['category'=>'Todos']);
        echo view('order/main_page', $data);
    }
}
