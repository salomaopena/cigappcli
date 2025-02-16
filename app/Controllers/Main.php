<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ApiModel;
use CodeIgniter\HTTP\ResponseInterface;

class Main extends BaseController
{

    public function init()
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

        
    }
    
    public function init_error($message = null)
    {
        if (empty($message)) {
            $message = session()->getFlashdata('error');
        }
        
        if (empty($message)) {
            echo ('Error');
            exit();
        }
        
        echo view('errors/init_error', ['error' => $message]);
        die();
    }


    public function stop(){
        session()->destroy();
        $this->init_error('Application configuration has been reseted...');
    }
    public function index()
    {
        $api = new ApiModel();
        // Call API method to get status
        echo '<pre>';
        print_r($api->get_status());
        echo '</pre>';
    }


}
