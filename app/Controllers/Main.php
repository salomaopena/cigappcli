<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ApiModel;
use CodeIgniter\HTTP\ResponseInterface;

class Main extends BaseController
{


    public function init(){
        // load restaurant details
        $this->_init_system();

        //set a temporary flag in session to indicate that the system has been initiated

        session()->setFlashdata('system_was_initiated',true);

        //if everythings is ok, show success page
        $this->_init_success();
    }
    private function _init_system()
    {
        try {
            // Check if file config.json exist
            //echo('Iniciação do sistema...');
            if (!file_exists(ROOTPATH . 'config.json')) {
                $this->init_error('Config file not found...');
            }

            // Read config file
            $config_file = file_get_contents(ROOTPATH . 'config.json');
            $config_data = json_decode($config_file, true);

            if (empty($config_data) || !is_array($config_data)) {
                $this->init_error('There was an error loading config file...');
            }

            //Check if config file is valid
            if (!key_exists('api_url', $config_data)) {
                $this->init_error('Config file is not valid: API URL is missing...');
            }
            if (!key_exists('project_id', $config_data)) {
                $this->init_error('Config file is not valid: PROJECT ID is missing...');
            }
            if (!key_exists('api_key', $config_data)) {
                $this->init_error('Config file is not valid: API KEY is missing...');
            }

            //check machine ID
            if (!key_exists('machine_id', $config_data)) {
                $this->init_error('Config file is not valid: MACHINE ID is missing...');
            }

            // Check if API URL is valid
            if (!filter_var($config_data['api_url'], FILTER_VALIDATE_URL)) {
                $this->init_error('Config file is not valid: URL is not a valid URL...');
            }

            //Check if PROJECT ID is a valid
            if (!is_numeric($config_data['project_id'])) {
                $this->init_error('Config file is not valid: PROJECT ID is not a valid number...');
            }
            // Check if API key is valid

            if (!preg_match('/^[a-zA-Z0-9]{32}$/', $config_data['api_key'])) {
                $this->init_error('Config file is not valid: API KEY is not a valid key...');
            }

            // Check if system has write permissions
            if (!is_writable(APPPATH)) {
                $this->init_error('System does not have write permissions...');
            }
        } catch (\Throwable $th) {
            // Something went wrong
            $this->init_error('An error occurred in file config: ' . $th->getMessage());
            exit;
        }

        // Everything is ok, set variable in session
        session()->set($config_data);

        $this->_get_restaurants();

        // if everything is ok, show success page
        //$this->_init_success();
    }

    private function _get_restaurants()
    {
        //load initial data
        $api = new ApiModel();
        // Call API method to get restaurants

        $data = $api->get_restaturants();

        if (!$this->_check_data($data)) {
            //dd($data);
            $this->init_error('System error: please contact the support');
        }

        //set initial data in session
        $restaurant_data = [
            'restaurant_details' => $data['data']['restaurant_details'],
            'products_categories' => $data['data']['products_categories'],
            'products' => $data['data']['products'],
        ];
        session()->set($restaurant_data);
    }

    private function _check_data($data)
    {
        if (
            empty($data) ||
            !is_array($data) ||
            !key_exists("status", $data) ||
            !key_exists("message", $data) ||
            $data["status"] != 200 ||
            $data["message"] != "Success"
        ) {
            return false;
        }
        return true;
    }

    private function _init_success()
    {
        //dd(session()->get());
        //prepare the datas
        $data = [
            'initiated_at'   => date('Y-m-d H:i:s'),
            'restaurant_id'  => session()->get('restaurant_details')['project_id'],
            'restaurant_name' => session()->get('restaurant_details')['name'],
            'categories'     => $this->_get_restaurant_categories(), //...
            'products'      =>   $this->_get_restaurant_products_and_stock(),
        ];

        echo view('init_success',$data);
        die();
        
    }

    private function _get_restaurant_categories()
    {
        $categories = [];
        //load categories
        foreach (session()->get('products_categories ') as $category) {
            $categories[] = $category['category'];
        }
        return $categories;
    }

    private function _get_restaurant_products_and_stock()
    {
        $products = [];
        //load products
        foreach (session()->get('products') as $product) {
            $products[] = [
                'image' => $product['image'],
                'name' => $product['name'],
                'price' => $product['price'],
                'stock' => $product['stock'],
            ];
        }
        return $products;
    }

    public function init_error($message = null)
    {
        if (empty($message)) {
            $message = session()->getFlashdata('error');
        }

        if (empty($message)) {
            echo ('System error. Please contact the support.');
            exit();
        }

        echo view('errors/init_error', ['error' => $message]);
        die();
    }


    public function stop()
    {
        session()->destroy();
        $this->init_error('Application configuration has been reseted...');
    }
    public function index()
    {
        //reset any previous order and set a new one
        init_order();

        //update the session about the restaurant if necessary
        if(empty(session()->getFlashdata('system_was_initiated'))){
            $this->_init_system();
        }
       // echo view('main');
        return view('main');
    }
}
