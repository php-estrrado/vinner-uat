<?php
 require APPPATH .'libraries/REST_Controller.php';
class Shop extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function index(){ 
	 if($user = validateToken($this->input->get('access_token'))){
            $result = ['status'=>200,'message'=>'Success','data'=>$user];
         }else{
             $result = ['status'=>400,'message'=>'Invalid access token','action'=>'login'];
         }
         print_r($result);
      //  $this->response($result, REST_Controller::HTTP_OK);
    }
}

?>