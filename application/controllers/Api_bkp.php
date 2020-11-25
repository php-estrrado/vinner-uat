<?php

require APPPATH .'libraries/REST_Controller.php';
class Api extends REST_Controller 
{
	function __construct()
	{
       parent::__construct();
   	   $this->load->database();
   	   // $this->load->library('form_validation');
       // header('Content-Type: application/json');
        $this->load->model('api/Api_user_model','Api_user_model');
    }
   
    function home_post(){ 
        $data           =   $this->shop->getHomeData();
        $result         =   ['statue'=>'successd','message'=>'Success','data'=>$data];
        $this->response($result, REST_Controller::HTTP_OK);
    }
    //profile
    public function profile_post()
    {
	  $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['status'] 	= 'error';
        $result['message']	= 'Invalid access token';
        $result['redirect']	= 'login';
        $this->response($result);
      }
      else
      {
        $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
	    $user_details = $this->db->where('user.user_id',$uid)->select('user.*,states.name')
	    ->join('states', 'states.id = user.state_id', 'left outer')->get('user')->row(); 
	   
	    if(file_exists('uploads/user_image/user_'.$user_details->user_id.'.jpg'))
	    {
	        $path  =  base_url("uploads/user_image/user_".$user_details->user_id.".jpg?".time());
	    }
	    else
	    {
	        $path  =  base_url("uploads/user_image/default.png");
	    } 
	  
	    $data      =  array('user_id'=>$user_details->user_id,'name'=>$user_details->username,'address1'=>$user_details->address1,'address2'=>$user_details->address2,'post'=>$user_details->zip,'state'=>$user_details->name,'mobile'=>$user_details->phone,'email'=>$user_details->email,'district'=>$user_details->district,'path'=>$path);
	    $result['status']   =   'success';
	    $result['message']  =   'User details';
	    $result['data']['user_details'] = $data;  
	    $this->response($result);
      }
   	}
     
     //profile update
    public function updateprofile_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['status'] 	= 'error';
        $result['message']	= 'Invalid access token';
        $result['redirect']	= 'login';
        $this->response($result);
      }
      else
      {
      $data 					= array();
      $data['username'] 		= trim($this->post("username"));
      $data['address1'] 		= $this->post("address1");
      $data['address2'] 		= $this->post("address2");
      $data['post'] 			= trim($this->post("post"));
      $data['state_id'] 		= $this->post("state_id");
      $data['mobile'] 			= trim($this->post("mobile"));
      $data['email'] 			= trim($this->post("email"));
      $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);

      $this->response($this->Api_user_model->updateprofile($uid,$data));
       	
      }
    }
   	//Registeration 
	public function register_post()
    {
      $data 					= array();
      $data['username'] 		= $this->post("username");
      $data['email']    		= trim($this->post("email"));
      $data['password'] 		= trim($this->post("password"));
      $data['confirm_password'] = trim($this->post("confirm_password"));
      $data['mobile'] 			= trim($this->post("mobile"));

	  $this->response($this->Api_user_model->register($data));
	}
           
 	//Send OTP to mobile
    public function sendotp_post()
    {
      $mobile = $this->post('mobile');
      if($mobile)
        {
          $this->response($this->Api_user_model->sendotp($mobile));
        }
      else
        {
          $r['status']  = 'error';
          $r['message'] ='mobile number required';
          $this->response($r);
        }
    }

    //Verify OTP
    public function verifyotp_post()
    {
      $data=array();
      $data['mobile'] = trim($this->post("mobile"));  
      $data['otp']    = trim($this->post("otp"));
      if($data['mobile'])
        {
    	 if($data['otp'])
	    	 {
	    	 	 $this->response($this->Api_user_model->verify_otp($data));
	    	 }
	    	 else
	    	 {
	      		$r['status'] ='error';
	      		$r['message'] ='Otp is required';
	      		$this->response($r);
	    	 }
    	
    	}
    	else
    	{
    		$r['status'] ='error';
      		$r['message'] ='Mobile number is required';
      		$this->response($r);
    	}      
    }

	//Category List
    function category_get()
    {
        	
        	$category  =   $this->db->order_by('category_id', 'desc')->where(array('status'=>1))->get('category')->result_array();
        
        
       if($category)
       {
            $result['status']           =       'success';
            $result['message']          =       'Category list';
            foreach($category as $row)
            {
                $data['category_id']            =       $row['category_id'];
                $data['category_name']          =       $row['category_name'];
                $result['data']['category'][]   =       $data;
            }
        }
        else
        {
          $result['status'] = 'error';
          $result['message']= 'No category found';
          $result['data']['category'][] = $data;
        }
        $this->response($result);
    }

    //Industry List
    function industry_get()
    {
       $industry  =   $this->db->order_by('brand_id', 'desc')->where(array('status'=>1))->get('industry')->result_array();
       if($industry)
       {
            $result['status']           =       'success';
            $result['message']          =       'Industry list';
            foreach($industry as $row)
            {
                $data['brand_id']            	=       $row['brand_id'];
                $data['brand_name']          	=       $row['name'];
                $result['data']['industries'][] =       $data;
            }
        }
        else
        {
          $result['status']  = 'error';
          $result['message'] = 'No industries found';
          $result['data']['industries'][] = $data;
        }
        $this->response($result);
    }

    //Product List
    function product_post()
    {

    	$pdata=array();
        $pdata['limit']	= $this->post("limit");
        $pdata['offset']= $this->post("offset"); 
        // $offset = $pdata['offset'] * 10;
        $this->db->select('product.*,category.*');
        $this->db->from('product');
    	$this->db->order_by("product.product_id", "desc");
    	$this->db->where(array('product.status'=>'ok'));
        $this->db->join('category', 'category.category_id = product.category','inner');
        if($pdata['limit']!='' && $pdata['offset']!='')
        {
        	  $this->db->limit($pdata['limit'], $pdata['offset']);
        }
        $query  = $this->db->get();
        $product = $query->result_array(); 
     //    else
     //    {
     //   $product  =   $this->db->order_by('product_id', 'desc')->where(array('status'=>'ok'))->get('product')->result_array();
   		// }
       if($product)
       {
            $result['status']           =       'success';
            $result['message']          =       'Product list';
            foreach($product as $row)
            {
                $data['product_id']            =       $row['product_id'];
                $data['product_code']          =       $row['product_code'];
                $data['product_title']         =       $row['title'];
                $data['product_model']         =       $row['model'];
                $data['sale_price']            =       $row['sale_price'];
                // $data['category_id']        =       $row['category'];
                $data['category_name']         =       $row['category_name'];
                $result['data']['products'][]  =       $data;
            }
        }
        else
        {
          $result['status'] = 'error';
          $result['message']= 'No product found';
          $result['data']['products'][] = $data;
        }
        $this->response($result);
    }

    //Product View
    function product_detail_post()
    {
        $prd_id = $this->input->post('product_id');
        if($prd_id)
        	{
		    $product  =   $this->db->select('product.*,category.*,product.description as desc')->where(array('product.status'=>'ok','product.product_id'=>$prd_id))->join('category', 'category.category_id = product.category','inner')->get('product')->row(); 
		   if($product)
		   {
		        $result['status']           =       'success';
		        $result['message']			= 		'Product Detail';
		        $data['product_id']         =       $product->product_id;
		        $data['product_code']       =       $product->product_code;
		        $data['product_name']       =       $product->title;
		        $data['model']              =       $product->model;
		        $data['sale_price']         =       $product->sale_price; 
		        $data['description']        =       $product->desc;
		        // $data['category_id']     =       $product->category;
		        $data['category_name']      =       $product->category_name;
		        $result['data'] 			=   	$data;
		    }
		    else
		    {
		      $result['status'] 		= 		'error';
		      $result['message']		= 		'No datas found';
		      $result['datas'] 			=   	 $data;
		    }
		    $this->response($result);
    	}
    	else
    	{
    		$result['status']  = 'error';
      		$result['message'] = 'Product id is required';
      		$this->response($result);
    	}
	}

	//Search List
    function search_post()
    {

    	$pdata=array();
        $search= $this->post("search");
       
        $this->db->select('product.*,category.*','sub_category.*');
        $this->db->from('product');
    	$this->db->order_by("product.product_id", "desc");
    	$this->db->where(array('product.status'=>'ok'));
        $this->db->join('category', 'category.category_id = product.category','inner');
        if($search != '')
        {
        	$this->db->where('product.title LIKE "%'.$search.'%" OR category.category_id LIKE "%'.$search.'%"');
        //	$this->db->where('product.title LIKE "%'.$search.'%"');
        }
        $query  = $this->db->get();
        $product = $query->result_array(); 

       if($product)
       {
            $result['status']           =        'success';
            $result['message']          =        'product List';
            foreach($product as $row)
            {
                $data['product_id']            =       $row['product_id'];
                $data['product_code']          =       $row['product_code'];
                $data['product_title']         =       $row['title'];
                $data['product_model']         =       $row['model'];
                $data['sale_price']            =       $row['sale_price'];
                // $data['category_id']        =       $row['category'];
                $data['category_name']         =       $row['category_name'];
                $result['data']['products'][]  =       $data;
            }
        }
        else
        {
          $result['status'] =  'error';
          $result['message']= 'No product found';
          $result['data']['products'][] = $data;
        }
        $this->response($result);
    }

    // Request for service
    public function reqService_post()
    {
    	//!preg_match('#^([0-9-\s]+)$#'
    	//!preg_match('#^([0-9-\s]+)$#', $_POST['phone']
    	//https://forums.cubecart.com/topic/37192-registration-telephone-numbers-must-be-numeric-only/
      $data 				= array();
      $data['product_id'] 	= $this->post("product_id");
      $data['name']    		= trim($this->post("name"));
      $data['address'] 		= trim($this->post("address"));
      $data['city'] 		= trim($this->post("city"));
      $data['country'] 		= trim($this->post("country"));
      $data['email'] 		= trim($this->post("email"));
      $data['mobile'] 		= trim($this->post("mobile"));
      $data['date'] 		= trim($this->post("date")); 
      $data['time'] 		= trim($this->post("time"));
      $data['remark'] 		= trim($this->post("remark"));
      // $this->response($this->Api_user_model->requestService($data));
      if($data['product_id'])
	    {	
	      if($data['name'])
	        {
	    	 if($data['address'])
		    	 {
		    	 	if($data['city'] ) 
		    	 	{
		    	 		if($data['country'])
		    	 		{
		    	 			if($data['email'])
		    	 			{	
	    	 					if($data['mobile'])
	    	 					{
	    	 						if($data['date'])
	    	 						{
	    	 							if($data['time'])
	    	 							{ 
	    	 								if($data['remark'])
	    	 								{
	    	 									if(preg_match('#^([0-9-\s]+)$#', $data['mobile']))
	    	 									{
	    	 										$this->response($this->Api_user_model->requestService($data));
	    	 									}
	    	 									else
	    	 									{
	    	 										$r['status']  = 'error';
					      							$r['message'] = 'Mobile number must be contain only numbers';
					      							$this->response($r);
	    	 									}
	    	 						 		}
	    	 						 		else
	    	 						 		{
	    	 						 			$r['status']  = 'error';
					      						$r['message'] = 'Remarks is required';
					      						$this->response($r);
	    	 						 		}
	    	 						 	}
	    	 						 	else
	    	 						 	{
	    	 						 		$r['status']  = 'error';
					      					$r['message'] = 'Time is required';
					      					$this->response($r);
	    	 						 	}
	    	 						}
	    	 						else
	    	 						{
	    	 							$r['status']  = 'error';
					      				$r['message'] = 'Date is required';
					      				$this->response($r);
	    	 						}
	    	 					}
	    	 					else
	    	 					{
	    	 						$r['status']  = 'error';
					      			$r['message'] = 'Mobile number is required';
					      			$this->response($r);
	    	 					}
		    	 		 	}
		    	 		 	else
		    	 		 	{
		    	 		 		$r['status']  = 'error';
					      		$r['message'] = 'Email is required';
					      		$this->response($r);
		    	 		 	}
		    	 		}
		    	 		else
		    	 		{
			    	 		$r['status']  = 'error';
				      		$r['message'] = 'Country is required';
				      		$this->response($r);
		    	 		}
		    	 	}
		    	 	else
		    	 	{
			    	 	$r['status']  = 'error';
			      		$r['message'] = 'City is required';
			      		$this->response($r);
		    	 	}
		    	 	
		    	 }
		    	 else
		    	 {
		    	 	$r['status']  = 'error';
		      		$r['message'] = 'Address is required';
		      		$this->response($r);
		    	 }
	    	
	    	}
	    	else
	    	{
	    		$r['status']  = 'error';
	      		$r['message'] = 'Name is required';
	      		$this->response($r);
	    	}
	    }
	    else
	    {
	    	$r['status']  = 'error';
	      	$r['message'] = 'Product id is required';
	      	$this->response($r);
	    }
     
	}

	// Request for demo
    public function reqDemo_post()
    {
      $data 				= array();
      $data['name']    		= trim($this->post("name"));
      $data['address'] 		= trim($this->post("address"));
      $data['city'] 		= trim($this->post("city"));
      $data['country'] 		= trim($this->post("country"));
      $data['email'] 		= trim($this->post("email"));
      $data['mobile'] 		= trim($this->post("mobile"));
      $data['date'] 		= trim($this->post("date")); 
      $data['time'] 		= trim($this->post("time"));
      $data['req_demo'] 	= trim($this->post("req_demo"));
  
  if($data['name'])
    {
	 if($data['address'])
    	 {
    	 	if($data['city'] ) 
    	 	{
    	 		if($data['country'])
    	 		{
    	 			if($data['email'])
    	 			{	
	 					if($data['mobile'])
	 					{
	 						if($data['date'])
	 						{
	 							if($data['time'])
	 							{ 
	 								if($data['req_demo'])
	 								{
	 									if(preg_match('#^([0-9-\s]+)$#', $data['mobile']))
	    	 							{
	 						 				$this->response($this->Api_user_model->requestDemo($data));
						 				}
	 									else
	 									{
	 										$r['status']  = 'error';
			      							$r['message'] = 'Mobile number must be contain only numbers';
			      							$this->response($r);
	 									}

	 						 		}
	 						 		else
	 						 		{
	 						 			$r['status']  = 'error';
			      						$r['message'] = 'Request demo field is required';
			      						$this->response($r);
	 						 		}
	 						 	}
	 						 	else
	 						 	{
	 						 		$r['status']  = 'error';
			      					$r['message'] = 'Time is required';
			      					$this->response($r);
	 						 	}
	 						}
	 						else
	 						{
	 							$r['status']  = 'error';
			      				$r['message'] = 'Date is required';
			      				$this->response($r);
	 						}
	 					}
	 					else
	 					{
	 						$r['status']  = 'error';
			      			$r['message'] = 'Mobile number is required';
			      			$this->response($r);
	 					}
    	 		 	}
    	 		 	else
    	 		 	{
    	 		 		$r['status']  = 'error';
			      		$r['message'] = 'Email is required';
			      		$this->response($r);
    	 		 	}
    	 		}
    	 		else
    	 		{
	    	 		$r['status']  = 'error';
		      		$r['message'] = 'Country is required';
		      		$this->response($r);
    	 		}
    	 	}
    	 	else
    	 	{
	    	 	$r['status']  = 'error';
	      		$r['message'] = 'City is required';
	      		$this->response($r);
    	 	}
    	 	
    	 }
    	 else
    	 {
    	 	$r['status']  = 'error';
      		$r['message'] = 'Address is required';
      		$this->response($r);
    	 }
	
	}
	else
	{
		$r['status']  = 'error';
  		$r['message'] = 'Name is required';
  		$this->response($r);
	}
	    
      
	}

	//Add Cart 
    public function add_cart_post()
    {
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['status']   = 'error';
        $result['message']  = 'Invalid access token';
        $result['redirect'] = 'login';
        $this->response($result);
      }
      else
      {
      $data=array();
      $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
      $data['location']    			= trim($this->post("location"));
      $data['product_id'] 			= trim($this->post("product_id"));  
      $data['product_price']    	= trim($this->post("product_price"));
      $data['product_qty']    		= trim($this->post("product_qty"));
      $data['product_total'] 		= trim($this->post("product_total"));  
      $data['total_amount']    		= trim($this->post("total_amount"));
      $data['total_delivery_fee']   = trim($this->post("total_delivery_fee"));
      $data['total_discount']   	= trim($this->post("total_discount"));
      $data['grand_total']    		= trim($this->post("grand_total"));

	    if($data['location'])
	    {	
	      if($data['product_id'])
	        {
	    	 if($data['product_price'])
		    	 {
		    	 	if($data['product_qty'] ) 
		    	 	{
		    	 		if($data['product_total'])
		    	 		{
		    	 			if($data['total_amount'])
		    	 			{	
	    	 					if($data['grand_total'])
	    	 					{
	    	 						$this->response($this->Api_user_model->add_cart($uid, $data));
	    	 					}
	    	 					else
	    	 					{
	    	 						$r['status']  = 'error';
					      			$r['message'] ='Grand total is required';
					      			$this->response($r);
	    	 					}
		    	 		 	}
		    	 		 	else
		    	 		 	{
		    	 		 		$r['status']  = 'error';
					      		$r['message'] ='Total amount is required';
					      		$this->response($r);
		    	 		 	}
		    	 		}
		    	 		else
		    	 		{
			    	 		$r['status']  = 'error';
				      		$r['message'] ='Product total is required';
				      		$this->response($r);
		    	 		}
		    	 	}
		    	 	else
		    	 	{
			    	 	$r['status']  = 'error';
			      		$r['message'] ='Product quantity is required';
			      		$this->response($r);
		    	 	}
		    	 	
		    	 }
		    	 else
		    	 {
		    	 	$r['status']  = 'error';
		      		$r['message'] ='Product price is required';
		      		$this->response($r);
		    	 }
	    	
	    	}
	    	else
	    	{
	    		$r['status']  = 'error';
	      		$r['message'] ='Product id is required';
	      		$this->response($r);
	    	}
	    }
	    else
	    {
	    	$r['status']  = 'error';
	      	$r['message'] ='Location is required';
	      	$this->response($r);
	    }
      } 
    }     
    
	//Update Cart 
    public function update_cart_post()
    {
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['status']	 = 'error';
        $result['message']	 = 'Invalid access token';
        $result['redirect']  = 'login';
        $this->response($result);
      }
      else
      {
      $data=array();
      $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
      $data['cart_id']    			= trim($this->post("cart_id"));
      $data['product_id'] 			= trim($this->post("product_id"));  
      $data['product_price']    	= trim($this->post("product_price"));
      $data['product_qty']    		= trim($this->post("product_qty"));
      $data['product_total'] 		= trim($this->post("product_total"));  
      $data['total_amount']    		= trim($this->post("total_amount"));
      $data['total_delivery_fee']   = trim($this->post("total_delivery_fee"));
      $data['total_discount']   	= trim($this->post("total_discount"));
      $data['grand_total']    		= trim($this->post("grand_total"));

	    if($data['cart_id'])
	    {	
	      if($data['product_id'])
	        {
	    	 if($data['product_price'])
		    	 {
		    	 	if($data['product_qty'] ) 
		    	 	{
		    	 		if($data['product_total'])
		    	 		{
		    	 			if($data['total_amount'])
		    	 			{
		    	 					
	    	 					if($data['grand_total'])
	    	 					{
	    	 						$this->response($this->Api_user_model->update_cart($uid, $data));
	    	 					}
	    	 					else
	    	 					{
	    	 						$r['status']  = 'error';
					      			$r['message'] ='Grand total is required';
					      			$this->response($r);
	    	 					}
		    	 		 		
		    	 		 	}
		    	 		 	else
		    	 		 	{
		    	 		 		$r['status']  = 'error';
					      		$r['message'] ='Total amount is required';
					      		$this->response($r);
		    	 		 	}
		    	 		}
		    	 		else
		    	 		{
			    	 		$r['status']  = 'error';
				      		$r['message'] ='error';
				      		$r['message'] ='Product total is required';
				      		$this->response($r);
		    	 		}
		    	 	}
		    	 	else
		    	 	{
			    	 	$r['status']  = 'error';
			      		$r['message'] ='Product quantity is required';
			      		$this->response($r);
		    	 	}
		    	 	
		    	 }
		    	 else
		    	 {
		    	 	$r['status']  = 'error';
		      		$r['message'] ='Product price is required';
		      		$this->response($r);
		    	 }
	    	
	    	}
	    	else
	    	{
	    		$r['status']  = 'error';
	      		$r['message'] ='Product id is required';
	      		$this->response($r);
	    	}
	    }
	    else
	    {
	    	$r['status']  = 'error';
	      	$r['message'] ='cart id is required';
	      	$this->response($r);
	    }
      } 
    }     
    
    //Delete Cart 
    public function delete_cart_post()
    {
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['status']   = 'error';
        $result['message']  = 'Invalid access token';
        $result['redirect'] = 'login';
        $this->response($result);
      }
      else
      {
      $data=array();
      $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
      $data['cart_id']    			= trim($this->post("cart_id"));
      $data['product_id'] 			= trim($this->post("product_id"));  
      $data['total_amount']    		= trim($this->post("total_amount"));
      $data['total_delivery_fee']   = trim($this->post("total_delivery_fee"));
      $data['total_discount']   	= trim($this->post("total_discount"));
      $data['grand_total']    		= trim($this->post("grand_total"));

	    if($data['cart_id'])
	    {	
	      if($data['product_id'])
	        {
	    	 
	 			if($data['total_amount'])
	 			{
 					
 					if($data['grand_total'])
 					{
 						$this->response($this->Api_user_model->delete_cart($uid, $data));
 					}
 					else
 					{
 						$r['status']  = 'error';
		      			$r['message'] ='Grand total is required';
		      			$this->response($r);
 					}
	 		 		
	 		 		
	 		 	}
	 		 	else
	 		 	{
	 		 		$r['status']  = 'error';
		      		$r['message'] ='Total amount is required';
		      		$this->response($r);
	 		 	}
	    	
	    	}
	    	else
	    	{
	    		$r['status']  = 'error';
	      		$r['message'] ='Product id is required';
	      		$this->response($r);
	    	}
	    }
	    else
	    {
	    	$r['status']  = 'error';
	      	$r['message'] ='Cart id is required';
	      	$this->response($r);
	    }
      } 
    }     

   //Empty Cart 
    public function empty_cart_post()
    {
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['status']   = 'error';
        $result['message']  = 'Invalid access token';
        $result['redirect'] = 'login';
        $this->response($result);
      }
      else
      {
      $data=array();
      $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
      $data['cart_id']    		= trim($this->post("cart_id"));

	    if($data['cart_id'])
	    {	
	  
	 		$this->response($this->Api_user_model->empty_cart($uid, $data));
	 				
	    }
	    else
	    {
	    	$r['status']  = 'error';
	      	$r['message'] ='Cart id is required';
	      	$this->response($r);
	    }
      } 
    }     

    //Cart Page 
    public function cart_page_post()
    {
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['status']   = 'error';
        $result['message']  = 'Invalid access token';
        $result['redirect'] = 'login';
        $this->response($result);
      }
      else
      {
       $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
       $cart = $this->db->where('user_id',$uid)->get('cart')->row();
       $cartId = $cart->cart_id;
       if($cart)
       {
       $result['status']            =       'success';
       $result['message']           =       'Cart Page';
       $cdata['total_amount']		=		$cart->amount;
       $cdata['total_delivery_fee'] =		$cart->delivery_fee;
       $cdata['total_discount']		=		$cart->discount;
       $cdata['grand_total']	    =		$cart->g_total;
       $result['data']['cart']		=		$cdata;

       $cart_item = $this->db->order_by('cart_item_id', 'desc')->where(array('status'=>1,'cart_id'=>$cartId))->get('cart_items')->result_array();
           
		    if($cart_item)
		    {
		           
	            foreach($cart_item as $row)
	            {
	            
	                $data['cart_item_id ']            	=       $row['cart_item_id'];
	                $data['cart_id ']          	        =       $row['cart_id'];
	                $data['product_id ']            	=       $row['product_id'];
	                $data['product_name ']            	=       $row['product_name'];
	                $data['product_quantity']          	=       $row['qty'];
	                $data['product_total ']            	=       $row['total'];
	                $result['data']['cart_items'][]		=       $data;
	            } 
	   
	          $address = $this->db
	          ->select('user_address.*,countries.name as countryname,states.name as statename,cities.name as cityname')
	          ->join('countries','countries.id = user_address.country')
	          ->join('states','states.id = user_address.state')
	          ->join('cities','cities.id = user_address.city')
	          ->where('user_address.user_id',$uid)
	          ->get('user_address')
	          ->row();
	          if($address)
	          {
			       $adata['name']				=		$address->fname;
			       $adata['address1'] 			=		$address->address1;
			       $adata['address2']			=		$address->address2;
			       $adata['country']			=		$address->countryname;
			       $adata['state']				=		$address->statename;
			       $adata['city'] 				=		$address->cityname;
			       $adata['zip']				=		$address->zip;
			       $adata['phone']	    		=		$address->phone;
			       $adata['email']	    		=		$address->email;
			       $result['data']['address']	=		$adata;
	          }
	          else
	          {
	          	  $result['status']  = 'error';
          		  $result['message'] = 'Address not found';
	          }
		    }
	        else
	        {
	          $result['status']  = 'error';
	          $result['message'] = 'No cart items found';
	          $result['data']['cart_items'][] = $data;
	        }
        }
        else
        {
          $result['status']  = 'error';
          $result['message'] = 'Cart not found';
        }
        $this->response($result);
      } 
    }

    //Order List
    function order_list_post()
    {
		$utoken = $this->post("access_token");
	  	if($this->Basic_model->uservalid($utoken)==false)
	  	{
	  	  $result['status'] 	= 'error';
	  	  $result['message']	= 'Invalid access token';
	  	  $result['redirect']	= 'login';
	  	  $this->response($result);
	  	}
	 	 else
	  	{
	        $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
	        $order  =   $this->db->order_by('sale_id', 'desc')->where(array('status'=>1,'buyer'=>$uid))->get('sale')->result_array(); 
	        
	       if($order)
	       {
	            $result['status']           =       'success';
	            $result['message']          =       'order list';
	            foreach($order as $row)
	            {
	                $data['sale_code']            =       $row['sale_code'];
	                $data['product_details']      =       json_decode($row['product_details']);
	                $data['shipping_address']     =       json_decode($row['shipping_address']);
	                $data['payment_type']         =       $row['payment_type'];
	                $data['payment_status']       =       json_decode($row['payment_status']);
	                $data['discount']    		  =       $row['discount'];
	                $data['grand_total']      	  =       $row['grand_total'];
	                $data['delivary_datetime']    =       date('Y-m-d', strtotime($row['delivary_datetime'])); 
	                $data['delivery_status']      =       json_decode($row['delivery_status']);
	                $result['data']['orders'][]   =       $data;
	            }
	        }
	        else
	        {
	          $result['status'] = 'error';
	          $result['message']= 'No order found';
	          $result['data']['order'][] = NULL;
	        }
	        $this->response($result);
    	}
    }

     //Order Detail
    function order_detail_post()
    {
		$utoken = $this->post("access_token");
	  	if($this->Basic_model->uservalid($utoken)==false)
	  	{
	  	  $result['status'] 	= 'error';
	  	  $result['message']	= 'Invalid access token';
	  	  $result['redirect']	= 'login';
	  	  $this->response($result);
	  	}
	 	 else
	  	{ 
	  		$ord_id = $this->input->post('order_id');
        	if($ord_id)
        	{
	        $uid 	= $this->Basic_model->get_value('user','user_id','access_token',$utoken);
	        $order  =   $this->db->order_by('sale_id', 'desc')->where(array('status'=>1,'buyer'=>$uid,'sale_id'=>$ord_id))->get('sale')->row(); 
	        
		       if($order)
		       {
		            $result['status']           =       'success';
		            $result['message']          =       'order list';
		            $data['sale_code']            =       $order->sale_code;
	                $data['product_details']      =       json_decode($order->product_details);
	                $data['shipping_address']     =       json_decode($order->shipping_address);
	                $data['payment_type']         =       $order->payment_type;
	                $data['payment_status']       =       json_decode($order->payment_status);
	                $data['discount']    		  =       $order->discount;
	                $data['grand_total']      	  =       $order->grand_total;
	                $data['delivary_datetime']    =       date('Y-m-d', strtotime($order->delivary_datetime)); 
	                $data['delivery_status']      =       json_decode($order->delivery_status);
	                $result['data']['orders'][]   =       $data;
	            
		        }
		        else
		        {
			        $result['status'] = 'error';
			        $result['message']= 'No order found';
			        $result['data']['order'][] = NULL;
		        }
		        $this->response($result);
	    	}
		    else
		    {
		    	$result['status'] = 'error';
			    $result['message']= 'Order id is required';
			    $this->response($result);
		    }
    	}
 	}
}

?>

