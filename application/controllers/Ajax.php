<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."libraries/REST_Controller.php";


class Ajax extends CI_Controller {

    #send get request -> API
    function get($controller, $action = 'index')
    {
        $response = $this->_api->get($controller.'/'.$action, $this->input->get());
        $this->response($response);



    }

    #send post request -> API
    function post($controller, $action = 'index')
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $response = $this->_api->post($controller.'/'.$action, $data);
        $this->response($response);


    }

    #return json respons

    private function response($response)
    {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}