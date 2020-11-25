<?php
 require APPPATH .'libraries/REST_Controller.php';
class Shop extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function index(){ echo 'ddd'; die;
	 if($user = validateToken($this->input->post('access_token'))){
            $result = ['status'=>200,'message'=>'Success','data'=>$user];
         }else{
             $result = ['status'=>400,'message'=>'Invalid access token','action'=>'login'];
         }
         print_r($result);
      //  $this->response($result, REST_Controller::HTTP_OK);
    }
    
    public function registration_get()
    	{
			$result=array('status'=>'400','message'=>'failed');
			if($this->input->post())
			{
				$input = $this->input->post();
				$vemail=trim($this->input->post('email'));
				if($vemail)
				{
						$data=array();
						$data['name']               = trim($this->input->post('name'));
						$data['email']              = $vemail;
						
						$result=array('status'=>'200','message'=>'success');
				}
				else
				{
					$result['message']='enter valid email';
				}
			}
			$this->response($result, REST_Controller::HTTP_OK);
    	}
}

?>