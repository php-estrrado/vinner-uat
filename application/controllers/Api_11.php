<?php

require APPPATH .'libraries/REST_Controller.php';
class Api extends REST_Controller{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('Api/Shop','shop');
       // header('Content-Type: application/json');
    }
    function home_post(){ 
        $data           =   $this->shop->getHomeData();
        $result         =   ['statue'=>'200','message'=>'success','data'=>$data];
        $this->response($result, REST_Controller::HTTP_OK);
    }
    function cart(){
        $post           =   (object) $this->input->post();
        
    }
}

?>