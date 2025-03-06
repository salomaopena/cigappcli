<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiModel extends Model
{
    private $api_url;
    private $project_id;
    private $api_key;

    public function __construct()
    {
        parent::__construct();

        //load config data from session
        $this->api_url = session()->get('api_url');
        $this->project_id = session()->get('project_id');
        $this->api_key = session()->get('api_key');
    }

    private function _api($endpoint, $method = 'GET', $post_data = [])
    {

        $curl = curl_init();

        //set the complete url for the api request

        $endpoint = $this->api_url . $endpoint;

        curl_setopt_array($curl, [
            CURLOPT_URL             => $endpoint,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => "",
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 30,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => strtoupper($method),
            CURLOPT_POSTFIELDS      => json_encode($post_data),
            CURLOPT_HTTPHEADER      => [
                "ContentType: application/json",
                "X-API-CREDENCIALS: ". $this->_set_credentials()
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return null;
        } else {
            return json_decode($response,true) ?? null ;
        }
    }

    private function _set_credentials(){
        //concat project_id and api_key
        $data = json_encode([
            "project_id" => $this->project_id,
            "api_key" => $this->api_key,
        ]);

        $encrypter = \Config\Services::encrypter();
        $encrypted_data = bin2hex($encrypter->encrypt($data));

        return $encrypted_data;
    }

    public function get_status(){
        return $this->_api('status');
    }

    public function get_restaturants(){
        return $this->_api('restaurant');
    }

    public function request_checkout($data){
        return $this->_api('checkout', 'POST', $data);
    }

    public function request_final_confirmation($data){
        return $this->_api('final_confirmation', 'POST', $data);
    }
}
