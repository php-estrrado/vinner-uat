<?php

require APPPATH .'libraries/REST_Controller.php';
class Api extends REST_Controller 
{
	function __construct()
	{
       parent::__construct();
   	   $this->load->database();
   	   $this->load->library('form_validation');
       // header('Content-Type: application/json');
        $this->load->model('Api/Api_user_model','Api_user_model');
        $this->load->model('api/Basic_model','Basic_model');
        $this->load->model('Api/Shop','shop');
        $this->load->model('functions');
    }
    
    function home_post(){ 
      $utoken = $this->post("access_token");
      $errors = array();
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']           = 400;
        $result['status']             = 'error';
        $result['message']            = 'Invalid access token';
        $result['data']['error']      = 'Invalid access token';
        $result['data']['redirect']   = 'login';
        $this->response($result);
      }
      else
      {
        $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
        $country_code = $this->post("country_code"); 
        if(!$country_code)
        {
           $errors['country_code']   = 'Country code is required';
         }
        if($errors)
        {
            $result['httpcode']      =  400;
            $result['status']        =  'error';
            $result['message']       =  reset($errors);
            $result['data']          =  $errors;
            $this->response($result);
        }
        else
        {
           $data           =   $this->shop->getHomeData($uid,$country_code);
           $result         =   ['httpcode'=>200,'status'=>'success','message'=>'Home Page','data'=>$data];
           $this->response($result, REST_Controller::HTTP_OK);
        }
      }
    }
    
    //profile
    public function profile_post()
    {
    $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']           = 400;
        $result['status']               = 'error';
        $result['message']            = 'Invalid access token';
        $result['data']['error']      = 'Invalid access token';
        $result['data']['redirect']     = 'login';
        $this->response($result);
      }
      else
      {
        $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
        $user_details = $this->db->where('user_id',$uid)->get('user')->row(); 
     
      if(file_exists('uploads/user_image/user_'.$uid.'.png'))
      {
          $path  =  base_url("uploads/user_image/user_".$uid.".png");
      }
      else
      {
          $path  =  base_url("uploads/user_image/default.png");
      } 
    
      $data      =  array('user_id'=>$user_details->user_id,'name'=>$user_details->username,'address1'=>$user_details->address1,'address2'=>$user_details->address2,'post'=>$user_details->zip,'state'=>$user_details->state,'mobile'=>$user_details->mobile,'email'=>$user_details->email,'district'=>$user_details->district,'path'=>$path);
      $data['address1']   = ($user_details->address1==null)?'':$user_details->address1;
      $data['address2']   = ($user_details->address2==null)?'':$user_details->address2;
      $data['post']       = ($user_details->zip==null)?'':$user_details->zip;
      $data['state']      = ($user_details->state==null)?'':$user_details->state;
      
      $result['httpcode'] =    200;
      $result['status']   =   'success';
      $result['message']  =   'User details';
      $result['data']     =   $data;  
      $this->response($result);
      }
    }
     
     //profile update
    public function updateprofile_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']         = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
      else
      {
      $data                 = array();
      $errors               = array();
      $data['username']     = trim($this->post("name"));
      $data['address1']     = trim($this->post("address1"));
      $data['address2']     = trim($this->post("address2"));
      $data['post']         = trim($this->post("post"));
      $data['state']        = trim($this->post("state"));
      $data['mobile']       = trim($this->post("mobile"));
      $data['email']        = trim($this->post("email"));
      $data['district']     = trim($this->post("district"));
      $data['profile_pic']  = trim($this->post("profile_pic"));
      $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);

      if(!$data['username'])
      {
        $errors['username']             = 'Name is required';
      }
      if(!$data['address1'])
      {
        $errors['address1']            = 'House Name / Door No are required';
      }
      if(!$data['address2'])
      {
        $errors['address2']            = 'Area / Location /Street are required';
      }
      if(!$data['post'])
      {
        $errors['post']                = 'Post is required';
      }   
      if(!$data['state'])
      {
        $errors['state']               = 'State is required';
      }
      if(!$data['mobile'])
      {
        $errors['mobile']              = 'Mobile is required';
      }
      if(!$data['email'])
      {
        $errors['email']               ='Email is required';
      }
      if($data['mobile'])
      {
          $checkmobile = $this->db->get_where('user',array('user_id !=' => $uid,'mobile'=>$data['mobile'],'status'=>'approved'))->num_rows();
          if($checkmobile > 0)
          {
            $errors['mobile_reg']   ='Mobile number already registered';
          }
          else if(strlen($data['mobile'])<'8') 
          {
            $errors['mobile_length'] = 'Mobile number must be at least 8 characters in length';
          }
          else if(!preg_match('#^([0-9-\s]+)$#', $data['mobile']))
          {
            $errors['mobile_no']     = 'Mobile number must contain only numbers';
          } 
      }
      if($data['email'])
      {
        $checkemail=$this->db->get_where('user',array('user_id !=' => $uid,'email'=>$data['email'],'status'=>'approved'))->num_rows();
        if($checkemail > 0)
          {
            $errors['email_reg']      = 'Email id already registered';
          }
          else if(!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', $data['email']))
          {
            $errors['email']          = 'Enter valid email';
          }
        }
        if($errors)
        {
            $r['httpcode']        = 400;
            $r['status']          = 'error';
            $r['message']         = reset($errors);
            $r['data']            = $errors;
            $this->response($r);
        }
         else
         {
            $this->response($this->Api_user_model->updateprofile($uid,$data));
         }  
      }
    }
    
     //profile update for andriod
    public function updateprofiledata_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']         = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
      else
      {
      $data                 = array();
      $errors               = array();
      $data['username']     = trim($this->post("name"));
      $data['address1']     = trim($this->post("address1"));
      $data['address2']     = trim($this->post("address2"));
      $data['post']         = trim($this->post("post"));
      $data['state']        = trim($this->post("state"));
      $data['mobile']       = trim($this->post("mobile"));
      $data['email']        = trim($this->post("email"));
      $data['district']     = trim($this->post("district"));
      $data['profile_pic']  = trim($this->post("profile_pic"));
      $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);

      if(!$data['username'])
      {
        $errors['username']             = 'Name is required';
      }
      if(!$data['address1'])
      {
        $errors['address1']            = 'House Name / Door No are required';
      }
      if(!$data['address2'])
      {
        $errors['address2']            = 'Area / Location /Street are required';
      }
      if(!$data['post'])
      {
        $errors['post']                = 'Post is required';
      }   
      if(!$data['state'])
      {
        $errors['state']               = 'State is required';
      }
      if(!$data['mobile'])
      {
        $errors['mobile']              = 'Mobile is required';
      }
      if(!$data['email'])
      {
        $errors['email']               ='Email is required';
      }
      if($data['mobile'])
      {
          $checkmobile = $this->db->get_where('user',array('user_id !=' => $uid,'mobile'=>$data['mobile'],'status'=>'approved'))->num_rows();
          if($checkmobile > 0)
          {
            $errors['mobile_reg']   ='Mobile number already registered';
          }
          else if(strlen($data['mobile'])<'8') 
          {
            $errors['mobile_length'] = 'Mobile number must be at least 8 characters in length';
          }
          else if(!preg_match('#^([0-9-\s]+)$#', $data['mobile']))
          {
            $errors['mobile_no']     = 'Mobile number must contain only numbers';
          } 
      }
      if($data['email'])
      {
        $checkemail=$this->db->get_where('user',array('user_id !=' => $uid,'email'=>$data['email'],'status'=>'approved'))->num_rows();
        if($checkemail > 0)
          {
            $errors['email_reg']      = 'Email id already registered';
          }
          else if(!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', $data['email']))
          {
            $errors['email']          = 'Enter valid email';
          }
        }
        if($errors)
        {
            $r['httpcode']        = 400;
            $r['status']          = 'error';
            $r['message']         = reset($errors);
            $r['data']            = $errors;
            $this->response($r);
        }
         else
         {
            $this->response($this->Api_user_model->updateprofiledata($uid,$data));
         }  
      }
    }
    
   		//Registeration 
	public function register_post()
    {
      $data 					     = array();
      $data['name'] 		         = $this->post("name");
      $data['email']    		     = trim($this->post("email"));
      $data['password'] 		     = trim($this->post("password"));
      $data['confirm_password']      = trim($this->post("confirm_password"));
      $data['mobile'] 			     = trim($this->post("mobile"));
      $data['c_code']                = trim($this->post("c_code"));

      if(!$data['name'])
      {
        $errors['name']             = 'Name is required';
      }
      if(!$data['email'])
      {
        $errors['email']            = 'Email is required';
      }
      if(!$data['mobile'])
      {
        $errors['mobile']           = 'Mobile number required';
      }
      if(!$data['password'])
      {
        $errors['password']         = 'Password is required';
      }
      if(!$data['confirm_password'])
      {
        $errors['confirm_password'] ='Confirm password required';
      }
      if($data['mobile'])
      {
          if($this->Basic_model->check_existuser('user','mobile',$data['mobile']))
          {
            $errors['mobile_reg']   ='Mobile number already registered';
          }
          else if(strlen($data['mobile'])<'8') 
          {
            $errors['mobile_length'] = 'Mobile number must be at least 8 characters in length';
          }
          else if(!preg_match('#^([0-9-\s]+)$#', $data['mobile']))
          {
            $errors['mobile_no']     = 'Mobile number must contain only numbers';
          } 
      }
      if($data['email'])
      {
        if($this->Basic_model->check_existuser('user','email',$data['email']))
          {
            $errors['email_reg']      = 'Email id already registered';
          }
          else if(!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', $data['email']))
          {
            $errors['email']          = 'Enter valid email';
          }
        }
        if($data['password'])
          {
            if(strlen($data['password'])<'6')
            {
              $errors['password_length'] ='Password must be at least 6 characters in length';
            }
            else if($data['password'] != $data['confirm_password'])
            {
              $errors['password_same']  ='Password and confirm password must be same';
            }
          }
        if($errors)
        {
            $r['httpcode']        = 400;
            $r['status']          = 'error';
            $r['message']         = reset($errors);
            $r['data']            = $errors;
            $this->response($r);
        }
	       else
         {
             $this->response($this->Api_user_model->register($data));
         }  
	}
           
 	//Send OTP to mobile
    public function sendotp_post()
    {
        $cCode    =   '';
        if($this->post('c_code')){
            $cCode  =   $this->post('c_code');
        }
      $mobile = $this->post('mobile');
      $errors=array();
      if(!$mobile)
      	{
      		$errors['mobile']			= 'Mobile number is required';
      	}
      	if($mobile)
	    {
	    	if(strlen($mobile)<'8')	
		    {
		    	$errors['mobile_length'] = 'Mobile number must be at least 8 characters in length';
		    }
		    else if(!preg_match('#^([0-9-\s]+)$#', $mobile))
		    {
		    	$errors['mobile_no']	= 'Mobile number must contain only numbers';
		    } 
	    }
        if($errors)
        {
            $r['httpcode']         	= 400;
            $r['status']     		='error';
            $r['message']     		= reset($errors);
            $r['data']          	= $errors;
            $this->response($r);
        }
         else
        {
          $this->response($this->Api_user_model->sendotp($cCode.$mobile));
        }
    }

    //Verify otp
    public function verifyotp_post()
    {
      $data=array();
      $data['c_code']       =   '';
      if($this->post("c_code")){
          $data['c_code']   =   trim($this->post("c_code"));
      }
      $data['mobile'] = trim($this->post("mobile"));
      $data['otp']    = trim($this->post("otp"));
      $errors=array();
       if(!$data['mobile'])
        {
         	$errors['mobile']			= 'Mobile number is required';
        }
      if(!$data['otp'])
        {
             $errors['otp']			    =   'Otp is required';
        }
       
        if($data['mobile'])
	    {
	    	if(strlen($data['mobile'])<'8')	
		    {
		    	$errors['mobile_length'] = 'Mobile number must be at least 8 characters in length';
		    }
		    else if(!preg_match('#^([0-9-\s]+)$#', $data['mobile']))
		    {
		    	$errors['mobile_no']	= 'Mobile number must contain only numbers';
		    } 
	    }
        if($errors)
        {
            $r['httpcode']         	= 400;
            $r['status']     		='error';
            $r['message']     		= reset($errors);
            $r['data']          	= $errors;
            $this->response($r);
        }
         else
        {
                  $this->response($this->Api_user_model->verify_otp($data));
        }  
    }

	//Category List
    function category_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
      	$result['httpcode'] 	        = 400;
        $result['status'] 	            = 'error';
        $result['message']      	    = 'Invalid access token';
        $result['data']['error']    	= 'Invalid access token';
        $result['data']['redirect']	    = 'login';
        $this->response($result);
      }
      else
      {
        $data = array();
        $category  =  $this->db->order_by('category_id', 'desc')->where(array('status'=>1))->get('category')->result_array();
        
       if($category)
        {
       		$result['httpcode'] 		= 	200;
            $result['status']           = 	'success';
            $result['message']          =   'Category list';
            foreach($category as $row)
            {
                 if(file_exists('uploads/category_image/'.$row['image']))
                  {
                      $path  =  base_url('uploads/category_image/'.$row['image']);
                  }
                  else
                  {
                      $path     =       base_url("uploads/category_image/category_default.png");
                  } 
                $data['category_id']    =   $row['category_id'];
                $data['category_name']  =   $row['category_name'];
                $data['category_image'] =   $path;
                $result['data'][]     =   $data;
            }
        }
        else
        {
          $result['httpcode'] 		= 400;
          $result['status'] 	= 'error';
          $result['message']	= 'No category found';
          $result['data'] 		=  $data;
        }
        $this->response($result);
      }
    }

    //Industry List
    function industry_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
      	$result['httpcode'] 	        = 400;
        $result['status'] 	            = 'error';
        $result['message']      	    = 'Invalid access token';
        $result['data']['error']    	= 'Invalid access token';
        $result['data']['redirect']	    = 'login';
        $this->response($result);
      }
      else
      {
       $data = array();
       $industry  =   $this->db->order_by('brand_id', 'desc')->where(array('status'=>1))->get('brand')->result_array();
       if($industry)
       {
       		$result['httpcode'] 		= 	200;
            $result['status']           =   'success';
            $result['message']          =   'Industry list';
            foreach($industry as $row)
            {
                if ($this->Basic_model->file_view('brand',$row['brand_id'],'100','','thumb','src','','','.png'))
                  {
                      $path     =       $this->Basic_model->file_view('brand',$row['brand_id'],'100','','thumb','src','','','.png');
                  }
                  else
                  {
                      $path     =       base_url("uploads/brand_image/brand_default.png");
                  } 
                $data['industry_id']    =       $row['brand_id'];
                $data['industry_name']  =       $row['name'];
                $data['industry_image'] =       $path;
                $result['data'][]       =       $data;
            }
        }
        else
        {
          $result['httpcode'] 	= 400;
          $result['status']  	= 'error';
          $result['message']    = 'No industries found';
          $result['data'] 		= $data;
        }
        $this->response($result);
      }
    }
    
    //Country List
    function countries_get()
    {
      $data = array();
       $country  =   $this->db->where(array('status'=>1))->get('countries')->result_array();
       if($country)
       {
          $result['httpcode']           =   200;
            $result['status']           =   'success';
            $result['message']          =   'Countries list';
            foreach($country as $row)
            {
                
                $data['country_id']    =       $row['id'];
                $data['country_name']  =       $row['name'];
                $data['country_code']  =       $row['sortname'];
                $result['data'][]       =       $data;
            }
        }
        else
        {
          $result['httpcode']   = 400;
          $result['status']     = 'error';
          $result['message']    = 'No countries found';
          $result['data']       = $data;
        }
        $this->response($result);
    } 

    //Cities List
    function cities_get()
    {
      $data = array();
       $country  =   $this->db->where(array('status'=>1))->get('cities')->result_array();
       if($country)
       {
          $result['httpcode']           =   200;
            $result['status']           =   'success';
            $result['message']          =   'Cities list';
            foreach($country as $row)
            {
                
                $data['city_id']      =       $row['id'];
                $data['city_name']    =       $row['name'];
                $data['state_id']     =       $row['state_id'];
                $result['data'][]     =       $data;
            }
        }
        else
        {
          $result['httpcode']   = 400;
          $result['status']     = 'error';
          $result['message']    = 'No cities found';
          $result['data']       = $data;
        }
        $this->response($result);
    }

    //States List
    function states_get()
    {
      $data = array();
       $states  =   $this->db->where(array('status'=>1))->get('states')->result_array();
       if($states)
       {
          $result['httpcode']           =   200;
            $result['status']           =   'success';
            $result['message']          =   'Cities list';
            foreach($states as $row)
            {
                
                $data['state_id']      =       $row['id'];
                $data['state_name']    =       $row['name'];
                $data['country_id']    =       $row['country_id'];
                $result['data'][]      =       $data;
            }
        }
        else
        {
          $result['httpcode']   = 400;
          $result['status']     = 'error';
          $result['message']    = 'No cities found';
          $result['data']       = $data;
        }
        $this->response($result);
    }

    //Product List
    function product_post()   
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']         = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
      else
      {
        $data = array();
        $pdata=array();
        $pdata['limit']       = $this->post("limit");
        $pdata['offset']      = $this->post("offset"); 
        $pdata['country_code']= $this->post("country_code"); 
        if($pdata['country_code'])
        {
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
       if($product)
       { 
           $result['httpcode']          =   200;
            $result['status']           =   'success';
            $result['message']          =   'Product list';
            foreach($product as $row)
            { 
              $country_id = $this->db->where('sortname',$pdata['country_code'])->get('countries')->row()->id; 
              $vendor_id  = $this->db->where('country_code',$country_id)->get('vendor')->row()->vendor_id; 
              $vendor_price = $this->db->where('vendor_id',$vendor_id)->where('prd_id',$row['product_id'])->get('vendor_prices')->row()->price; 
               if ($this->Basic_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one'))
                    {
                        $path     =       $this->Basic_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one');
                    }
                    else
                    {
                        $path     =       base_url("uploads/product_image/default_product_thumb.jpg");
                    } 
                $data['product_id']            =       $row['product_id'];
                $data['product_title']         =       $row['title'];
                $data['qty']                   =       $row['mpn'];
                $data['unit']                  =       $row['unit'];
                $data['current_stock']        =        $row['current_stock'];
                if($vendor_id)
                {
                    if($vendor_price == NULL)
                    {
                       $data['price']             =       0;
                    }
                    else
                    {
                         $data['price']             =       $vendor_price;
                    }
                $Curency  = $this->db->where('id',$country_id)->get('countries')->row()->currency;
                $data['currency']              =       $Curency;
                }
                else
                {
                   $data['price']    =  "";
                   $data['currency'] =  "";
                }
                $data['product_image']         =       $path;
                $r_total =  $row['rating_total'];
                $r_num   =  $row['rating_num'];
                $rating  =  bcdiv($r_total, $r_num, 1);
                if($rating != NULL)
                {
                  $data['rating']      =   $rating;
                }
                else
                {
                  $data['rating']      =   "";
                }   
                $data['category']              =       $row['category_name'];
                $result['data'][]              =       $data;
            }
        }
        else
        {
          $result['httpcode']   =  400;
          $result['status']     = 'error';
          $result['message']    = 'No product found';
          $result['data']       =  $data;
        }
        $this->response($result);
      }
      else
      {
        $result['httpcode']                 = 400;
        $result['status']                   = 'error';
        $result['message']                  = 'Country code is required';
        $result['data']['country_code']     = 'Country code is required';
        $this->response($result);
      }
    }
  }

  //Product View
    function product_detail_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']           = 400;
        $result['status']             = 'error';
        $result['message']            = 'Invalid access token';
        $result['data']['error']      = 'Invalid access token';
        $result['data']['redirect']   = 'login';
        $this->response($result);
      }
      else
      {
      $rdata      = array();
      $pdata      = array();
      $errors     = array();
      $prd_id     = $this->input->post('product_id');
       $country_code = $this->post("country_code"); 
      if(!$prd_id)
      {
        $errors['product_id']   = 'Product id is required';
      }
      if(!$country_code)
      {
        $errors['country_code']   = 'Country code is required';
      }
      if($errors)
      {
          $result['httpcode']      =  400;
          $result['status']        =  'error';
          $result['message']       =  reset($errors);
          $result['data']          =  $errors;
          $this->response($result);
      }
      else
      {
        $product  =   $this->db->select('product.*,category.*,product.description as desc')->where(array('product.status'=>'ok','product.product_id'=>$prd_id))->join('category', 'category.category_id = product.category','inner')->get('product')->row(); 
       if($product)
        {
              $country_id = $this->db->where('sortname',$country_code)->get('countries')->row()->id; 
              $vendor_id  = $this->db->where('country_code',$country_id)->get('vendor')->row()->vendor_id; 
              $vendor_price = $this->db->where('vendor_id',$vendor_id)->where('prd_id',$prd_id)->get('vendor_prices')->row()->price; 

           if ($this->Basic_model->file_view('product',$product->product_id,'','','no','src','multi','all')) 
                    {
                        $path     =       $this->Basic_model->file_view('product',$product->product_id,'','','no','src','multi','all'); 
                    }
                    else
                    {
                        $path     =       base_url("uploads/product_image/default_product.jpg");
                    } 
            $result['httpcode']         =       200;
            $result['status']           =       'success';
            $result['message']          =       'Product Detail';
            $data['product_id']         =       $product->product_id;
            $data['product_name']       =       $product->title;
            if($vendor_id)
                {
                    if($vendor_price == NULL)
                    {
                       $data['price']             =       0;
                    }
                    else
                    {
                         $data['price']             =       $vendor_price;
                    }
                $Curency  = $this->db->where('id',$country_id)->get('countries')->row()->currency;
                $data['currency']              =       $Curency;
                }
            else
            {
               $data['price']    =  "";
               $data['currency'] =  "";
            }
            $data['qty']                =       $product->mpn;
            $data['unit']               =       $product->unit; 
            $data['current_stock']      =       $product->current_stock;
            $data['return_policy']      =       $product->return_policy;
            // $data['currency']           =       Currency();
            $r_total  =  $product->rating_total;
            $r_num    = $product->rating_num;
            $rating   = bcdiv($r_total, $r_num, 1);
            if($rating != NULL)
            {
              $data['rating']      =   $rating;
            }
            else
            {
              $data['rating']      =   "";
            } 
            $data['reated_customers']   =       $product->rating_num;
            $data['description']        =       $product->desc;
            $data['category']           =       $product->category_name;
             foreach($path as $img)
            { 
                $images[]                   =       $img;
                $data['product_image']      =       $images;
            }
            $result['data']['product']  =       $data;

            $reviews = $this->db->where('product_id',$prd_id)->where('status',1)->get('reviews')->result_array(); 
            if($reviews)
            {
              foreach ($reviews as $review) 
              {
              $usr_name = $this->db->where('user_id',$review['user_id'])->get('user')->row()->username;
              $rdata['user']                = $usr_name;
              $rdata['review_title']        = $review['review_title'];
              $rdata['review']              = $review['review'];
              $rdata['rating']              = $review['rating'];
              $rdata['review_date']         = date('d F Y', strtotime($review['review_date']));
              $result['data']['reviews'][]  = $rdata;
              }
            }
            else
            {
               $result['data']['reviews']  = $rdata;
            }
            $related_prd  =  $this->db->where('product_id',$prd_id)->get('product')->row()->related_products;
            $rel_prd    = json_decode($related_prd); 
             foreach ($rel_prd as $key => $rel) 
             {
                $prdss = $this->db->where('product_id',$rel)->get('product')->result_array(); 
                if($prdss) 
                {
                foreach ($prdss as $key => $prds) 
                {
                  $country_id = $this->db->where('sortname',$country_code)->get('countries')->row()->id; 
                  $vendor_id  = $this->db->where('country_code',$country_id)->get('vendor')->row()->vendor_id; 
                  $vendor_price = $this->db->where('vendor_id',$vendor_id)->where('prd_id',$prds['product_id'])->get('vendor_prices')->row()->price; 

                  if ($this->Basic_model->file_view('product',$prds['product_id'],'','','thumb','src','multi','one'))
                    {
                        $path_img     =       $this->Basic_model->file_view('product',$prds['product_id'],'','','thumb','src','multi','one');
                    }
                    else
                    {
                        $path_img    =       base_url("uploads/product_image/default_product_thumb.jpg");
                    } 
                  $pdata['product_id']            =       $prds['product_id'];
                  $pdata['product_title']         =       $prds['title'];
                  $pdata['prd_qty']               =       $prds['mpn'];
                  $pdata['unit']                  =       $prds['unit'];
                  if($vendor_id)
                  {
                    if($vendor_price == NULL)
                    {
                       $pdata['price']             =       0;
                    }
                    else
                    {
                         $pdata['price']             =       $vendor_price;
                    }
                         $Curency  = $this->db->where('id',$country_id)->get('countries')->row()->currency;
                         $pdata['currency']              =       $Curency;
                    }
                else
                {
                   $pdata['price']    =  "";
                   $pdata['currency'] =  "";
                }
                  $pdata['product_image']         =       $path_img;
                  $r_total  =  $prds['rating_total'];
                  $r_num    = $prds['rating_num'];
                  $rating   = bcdiv($r_total, $r_num, 1);
                  if($rating != NULL)
                  {
                    $pdata['rating']      =   $rating;
                  }
                  else
                  {
                    $pdata['rating']      =   "";
                  } 
                  $result['data']['related_products'][]  = $pdata;
                }
              }
             else
             {
                 $result['data']['related_products']  = $pdata;
             }
          }
        }
        else
        {
          $result['httpcode']     =     400;
          $result['status']       =     'error';
          $result['message']      =     'No datas found';
          //   $result['datas']   =      NULL;
        }
        $this->response($result);
       }
      }
    }

	//Search List
    function search_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']           = 400;
        $result['status']             = 'error';
        $result['message']            = 'Invalid access token';
        $result['data']['error']      = 'Invalid access token';
        $result['data']['redirect']   = 'login';
        $this->response($result);
      }
      else
      {
      $pdata=array();
      $search= $this->post("search");
      $country_code =$this->post("country_code");
      if($country_code)
      {

      $this->db->select('product.*,category.*','sub_category.*');
      $this->db->from('product');
      $this->db->order_by("product.product_id", "desc");
      $this->db->where(array('product.status'=>'ok'));
        $this->db->join('category', 'category.category_id = product.category','inner');
        if($search != '')
        {
          $this->db->where('product.title LIKE "%'.$search.'%" OR category.category_id LIKE "%'.$search.'%"');
        //  $this->db->where('product.title LIKE "%'.$search.'%"');
        }
        $query  = $this->db->get();
        $product = $query->result_array(); 

       if($product)
       {
            $result['httpcode']     =   200;
            $result['status']           =   'success';
            $result['message']          =   'product List';
            foreach($product as $row)
            {
               $country_id = $this->db->where('sortname',$country_code)->get('countries')->row()->id; 
              $vendor_id  = $this->db->where('country_code',$country_id)->get('vendor')->row()->vendor_id; 
              $vendor_price = $this->db->where('vendor_id',$vendor_id)->where('prd_id',$row['product_id'])->get('vendor_prices')->row()->price;

                if ($this->Basic_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one'))
                    {
                        $path     =       $this->Basic_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one');
                    }
                    else
                    {
                        $path     =       base_url("uploads/product_image/default_product_thumb.jpg");
                    }  
                $data['product_id']            =       $row['product_id'];
                $data['product_title']         =       $row['title'];
                $data['prd_qty']               =       $row['mpn'];
                $data['unit']                  =       $row['unit'];
                $data['current_stock']        =        $row['current_stock'];
                if($vendor_id)
                {
                    if($vendor_price == NULL)
                    {
                       $data['price']             =       0;
                    }
                    else
                    {
                         $data['price']             =       $vendor_price;
                    }
                 $Curency  = $this->db->where('id',$country_id)->get('countries')->row()->currency;
                 $data['currency']              =       $Curency;
                }
                else
                {
                   $data['price']    =  "";
                   $data['currency'] =  "";
                }
                $data['product_image']         =       $path;
                $r_total =  $row['rating_total'];
                $r_num   =  $row['rating_num'];
                $rating  =  bcdiv($r_total, $r_num, 1);
                if($rating != NULL)
                {
                  $data['rating']      =   $rating;
                }
                else
                {
                  $data['rating']      =   "";
                } 
                $data['category']              =       $row['category_name'];
                $result['data'][]              =       $data;
            }
        }
        else
        {
          $result['httpcode']   =   400;
          $result['status']   =  'error';
          $result['message']  =  'No product found';
           $result['data']    =   $data;
        }
        $this->response($result);
      }
      else
      {
        $result['httpcode']               = 400;
        $result['status']                 = 'error';
        $result['message']                = 'Country code is required';
        $result['data']['country_code']   = 'Country code is required';
        $this->response($result);
      }
    }
  }


    // Request for service
    public function reqService_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
      	$result['httpcode'] 	        = 400;
        $result['status'] 	            = 'error';
        $result['message']      	    = 'Invalid access token';
        $result['data']['error']    	= 'Invalid access token';
        $result['data']['redirect']	    = 'login';
        $this->response($result);
      }
      else
      {
      $data                       = array();
      $data['service_category']   = $this->post("service_category");
      $data['service_type']       = $this->post("service_type");
      $data['type_detail']        = trim($this->post("vehicle_type"));
      $data['name']               = trim($this->post("name"));
      $data['address']            = trim($this->post("address"));
      $data['city']               = trim($this->post("city"));
      $data['country']            = trim($this->post("country"));
      $data['email']              = trim($this->post("email"));
      $data['mobile']             = trim($this->post("mobile"));
      $data['date']               = trim($this->post("date")); 
      $data['time']               = trim($this->post("time"));
      $data['remark']             = trim($this->post("remark"));

      $errors=array();
      if(!$data['service_category'])
      { 
        $errors['service_category'] = 'Service category is required';
      }
      if(!$data['service_type'])
      { 
        $errors['service_type'] = 'Type of service is required';
      }
      if(!$data['name'])
      { 
        $errors['name']     = 'Name is required';
      }
      if(!$data['address'])
      { 
        $errors['address']    = 'Address is required';
      }
      if(!$data['city'])
      { 
        $errors['city']     = 'City is required';
      }
      if(!$data['country'])
      { 
        $errors['country']    = 'Country is required';
      }
      if(!$data['email'])
      { 
        $errors['email']    = 'Email is required';
      }
      if(!$data['mobile'])
      { 
        $errors['mobile']   = 'Mobile number is required';
      }
      if(!$data['date'])
      { 
        $errors['date']     = 'Date is required';
      }
      if(!$data['time'])
      { 
        $errors['time']     = 'Time is required';
      }
      if(!$data['remark'])
      { 
        $errors['remark']   = 'Remarks is required';
      }
      if($data['mobile'])
      {
        if(strlen($data['mobile'])<'8') 
        {
          $errors['mobile_length'] = 'Mobile number must be at least 8 characters in length';
        }
        else if(!preg_match('#^([0-9-\s]+)$#', $data['mobile']))
        {
          $errors['mobile_no']  = 'Mobile number must contain only numbers';
        } 
      }
      if($data['email'])
      {
        if(!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', $data['email']))
            {
              $errors['email']  = 'Enter valid email';
            }
      }   
      if($errors)
        {
            $r['httpcode']          =  400;
            $r['status']            = 'error';
            $r['message']           =  reset($errors);
            $r['data']              =  $errors;
            $this->response($r);
        }
        else
        {
          $this->response($this->Api_user_model->requestService($data));
        }
     }
  }
  
	// Request for demo
    public function reqDemo_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
      	$result['httpcode'] 	        = 400;
        $result['status'] 	            = 'error';
        $result['message']      	    = 'Invalid access token';
        $result['data']['error']    	= 'Invalid access token';
        $result['data']['redirect']	    = 'login';
        $this->response($result);
      }
      else
      {
      $data                 = array();
      $data['name']         = trim($this->post("name"));
      $data['email']        = trim($this->post("email"));
      $data['mobile']       = trim($this->post("mobile"));
      $data['city']         = trim($this->post("city"));
      $data['country']      = trim($this->post("country"));
      $data['date']         = trim($this->post("date")); 
      $data['time']         = trim($this->post("time"));
      $data['product_id']   = trim($this->post("product_id"));
      $data['remarks']      = trim($this->post("remarks"));
      
      $errors=array();
     
      if(!$data['name'])
      { 
        $errors['name']           = 'Name is required';
      }
      if(!$data['email'])
      { 
        $errors['email']           = 'Email is required';
      }
      if(!$data['mobile'])
      { 
        $errors['mobile']          = 'Mobile number is required';
      }
      if(!$data['city'])
      { 
        $errors['city']            = 'City is required';
      }
      if(!$data['country'])
      { 
        $errors['country']         = 'Country is required';
      }
      if(!$data['date'])
      { 
        $errors['date']            = 'Date is required';
      }
      if(!$data['time'])
      { 
        $errors['time']           = 'Time is required';
      }
      if(!$data['product_id'])
      { 
        $errors['product_id']     = 'Product id is required';
      }
      if(!$data['remarks'])
      { 
        $errors['remarks']        = 'Remarks field is required';
      }
      if($data['mobile'])
      {
        if(strlen($data['mobile'])<'8') 
        {
          $errors['mobile_length'] = 'Mobile number must be at least 8 characters in length';
        }
        else if(!preg_match('#^([0-9-\s]+)$#', $data['mobile']))
        {
          $errors['mobile_no']  = 'Mobile number must contain only numbers';
        } 
      }
      if($data['email'])
      {
        if(!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', $data['email']))
            {
              $errors['email']  = 'Enter valid email';
            }
      }
      if($errors)
        {
            $r['httpcode']          =  400;
            $r['status']        = 'error';
            $r['message']         = reset($errors);
            $r['data']            =  $errors;
            $this->response($r);
        }
        else
        {
          $this->response($this->Api_user_model->requestDemo($data));
        }
      }
    }
    
    //Product for demo list
    function demo_product_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
      	$result['httpcode'] 	        = 400;
        $result['status'] 	            = 'error';
        $result['message']      	    = 'Invalid access token';
        $result['data']['error']    	= 'Invalid access token';
        $result['data']['redirect']	    = 'login';
        $this->response($result);
      }
      else
      {
        $data = array();
        $pdata=array();
        $product = $this->db->order_by('product_id', 'desc')->where('status','ok')->where('request_demo',1)->get('product')->result_array();
       if($product)
       {
            $result['httpcode']     =   200;
            $result['status']           =   'success';
            $result['message']          =   'Demo product list';
            foreach($product as $row)
            {
               if ($this->Basic_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one'))
                    {
                        $path     =       $this->Basic_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one');
                    }
                    else
                    {
                        $path     =       base_url("uploads/product_image/default_product_thumb.jpg");
                    } 
                $data['product_id']            =       $row['product_id'];
                $data['product_title']         =       $row['title'];
                // $data['unit']                  =       $row['unit'];
                // $data['price']                 =       $row['sale_price'];
                // $data['product_image']         =       $path;
                // $data['currency']              =       Currency();
                // $data['rating']                =       $row['rating_num'];
                $result['data'][]              =       $data;
            }
        }
        else
        {
          $result['httpcode']   =  400;
          $result['status']   = 'error';
          $result['message']  = 'No product found';
          $result['data']     =  $data;
        }
        $this->response($result);
      }
    }
    
   //Add Cart 
    public function add_cart_post()
    {
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']       = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']  = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
      else
      {
      $data=array();
      $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
      $data['country_code']       = trim($this->post("country_code"));
      $data['product_id']         = trim($this->post("product_id"));  
      $errors = array();
       if(!$data['country_code'])
      { 
        $errors['country_code']       =  'Country code is required';
      }
      if(!$data['product_id'])
      { 
        $errors['product_id']       = 'Product id is required';
      }
      if($errors)
        {
            $r['httpcode']          =  400;
            $r['status']            =  'error';
            $r['message']           =  reset($errors);
            $r['data']              =  $errors;
            $this->response($r);
        }
        else
        {
          $this->response($this->Api_user_model->add_cart($uid, $data));
        }
      }     
  }
   public function update_cart_post()
    {
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']         = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result); 
      }
      else
      {
      $data=array();
      $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
      $data['cart_id']          = trim($this->post("cart_id"));
      $data['product_id']       = trim($this->post("product_id"));  
      $data['product_qty']        = trim($this->post("product_qty"));
      $errors = array();  
      if(!$data['cart_id'])
      { 
        $errors['cart_id']      = 'Cart id is required';
      }
      if(!$data['product_id'])
      { 
        $errors['product_id']   = 'Product id is required';
      }
      if(!$data['product_qty'])
      { 
        $errors['product_qty']  = 'Product quantity is required';
      }
      if($errors)
        {
            $r['httpcode']          =  400;
            $r['status']            =  'error';
            $r['message']           =  reset($errors);
            $r['data']              =  $errors;
            $this->response($r);
        }
        else
        {

          $this->response($this->Api_user_model->update_cart($uid, $data));
        }
      }
    }     

    //Delete Cart 
    public function delete_cart_post()
    {
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']         = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
      else
      {
      $data=array();
      $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
      $data['cart_id']          = trim($this->post("cart_id"));
      $data['product_id']       = trim($this->post("product_id"));  
       $errors = array();
       if(!$data['cart_id'])
      { 
        $errors['cart_id']      = 'Cart id is required';
      }
      if(!$data['product_id'])
      { 
        $errors['product_id']   = 'Product id is required';
      }
      if($errors)
        {
            $r['httpcode']        =  400;
            $r['status']          = 'error';
            $r['message']         = reset($errors);
            $r['data']            =  $errors;
            $this->response($r);
        }
        else
        {
          $this->response($this->Api_user_model->delete_cart($uid, $data));
        }
      }
    }  

   //Empty Cart 
    public function empty_cart_post()
    {
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
      	$result['httpcode'] 	    = 400;
        $result['status'] 	        = 'error';
        $result['message']	        = 'Invalid access token';
        $result['data']['error']	= 'Invalid access token';
        $result['data']['redirect']	= 'login';
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
	    	$r['httpcode'] 	  		= 400;
	    	$r['status']  		    = 'error';
	    	$r['message'] 		    = 'Cart id is required';
	      	$r['data']['cart_id']   = 'Cart id is required';
	      	$this->response($r);
	    }
      } 
    }     

       //clear Cart 
    public function clear_cart_post()
    {
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']         = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
      else
      {
      $data=array();
      $uid   = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
      $cart = $this->db->where('user_id',$uid)->get('cart'); 
      if($cart->num_rows() > 0)
      {
        $cartId = $cart->row()->cart_id;
        $data['cart_id']        = $cartId;
      }
      else
      {
        $data['cart_id']        = 0;
      }
      $this->response($this->Api_user_model->clear_cart($uid, $data)); 
      } 
    }     

     //Cart Page 
    public function cart_page_post()
    { 
        $data = array(); $adata = array();
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
      	$result['httpcode'] 	    = 400;
        $result['status'] 	        = 'error';
        $result['message']	        = 'Invalid access token';
        $result['data']['error']	= 'Invalid access token';
        $result['data']['redirect']	= 'login';
        $this->response($result);
      }
      else
      {
        $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
        $cart = $this->db->where('user_id',$uid)->get('cart')->row();
       
        $result['httpcode'] 	=		 200;
        $result['status']       =       'success';
        $result['message']      =       'Cart Page';
        $result['data']['cart']=array('total_amount'=>'0','grand_total'=>'0','currency'=>Currency());
        $result['data']['cart_items'] = null;
        $errors = array();
        if($cart)
        {
           $cartId = $cart->cart_id;
           $vendorId = $cart->vendor_id;
           $contry_id = $this->db->where('vendor_id',$vendorId)->get('vendor')->row()->country_code;
           $Curency   = $this->db->where('id',$contry_id)->get('countries')->row()->currency;
           $cdata['total_amount']		    =		$cart->amount;
           $cdata['grand_total']	        =		$cart->g_total;
           $cdata['currency']               =       $Curency;
           $result['data']['cart']		    =		$cdata;

            $cart_item = $this->db->order_by('cart_item_id', 'desc')->where(array('status'=>1,'cart_id'=>$cartId))->get('cart_items')->result_array();
           
		    if($cart_item)
		    {
		         $count_items                    =   count($cart_item); 
                 $result['data']['items_total']  =   $count_items;  
	            foreach($cart_item as $row)
	            {
	                $category = $this->db->where('product_id',$row['product_id'])->get('product')->row()->category; 
                    $category_name = $this->db->where('category_id',$category)->get('category')->row()->category_name;
                     if ($this->Basic_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one'))
                    {
                        $path     =       $this->Basic_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one');
                    }
                    else
                    {
                        $path     =       base_url("uploads/product_image/default_product_thumb.jpg");
                    } 
	            
	                $data['cart_item_id']            	  =       $row['cart_item_id'];
	                $data['cart_id']          	        =       $row['cart_id'];
	                $data['product_id']            	    =       $row['product_id'];
	                $data['product_name']            	  =       $row['product_name'];
	                $data['product_price']              =       $row['price'];
	                $data['product_quantity']          	=       $row['qty'];
	                $data['product_total']            	=       $row['total'];
	                $data['currency']                   =       $Curency;
                  $data['category_name']              =       $category_name;
                  $data['product_image']              =       $path;
                  $data['delivery']                   =       '';
	                $result['data']['cart_items'][]		=       $data;
	            } 
	   
		    }
	        else
	        {
	          $result['data']['cart_items'] = null;//$data;
	        }
            
            
        }
        
        $result['data']['address'] = null;
        $address = $this->db->where('user_id',$uid)->where('status',1)->where('default_addr',1)->get('user_address')->row(); 
        if($address)
        {
                 $country_name = $this->db->where('sortname',$address->country)->get('countries')->row()->name; 
                 $adata['address_id']         =   $address->adrs_id;
                 $adata['address_type']       =   $address->address_label;
                 $adata['name']               =   $address->fname;
                 $adata['house_flat']         =   $address->address1;
                 $adata['zip']                =   $address->zip;
                 $adata['road_name']          =   $address->road_name;
                 $adata['landmark']           =   $address->landmark;
                 $adata['city']               =   $address->city;
                 $adata['country']            =   $country_name;
                 $adata['default']            =   $address->default_addr;
                 $result['data']['address']   =   $adata;
        }
        // else
        // {
        //   $errors['cart'] = 'Cart not found';
        // }
        if($errors)
        {
        $result['httpcode']    = 400;
        $result['status']      = 'error';
        $result['message']     = reset($errors);
        $result['data']        = $errors;
        }
       
        $this->response($result);
      } 
    }


    //Order List
    function order_list_post()
    {
        $data = array();
    $utoken = $this->post("access_token");
    $post   =   (object)$this->input->post();
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']      = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']  = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
     else
      {
          $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
         $this->db->where(array('status'=>1,'buyer'=>$uid));
          if($post->search_orderId){ $this->db->like('sale_code',$post->search_orderId); }
        //  if($post->search_date){ $this->db->where('sale_datetime >=',strtotime($post->search_date.' 00:00:00'))->where('sale_datetime <=',strtotime($post->search_date.' 23:59:59')); }
          $order  =   $this->db->order_by('sale_id', 'desc')->get('sale')->result_array(); 
          
         if($order)
         {
              $result['httpcode']       =     200;
              $result['status']           =       'success';
              $result['message']          =       'order list';
              foreach($order as $row)
              {
                  $show = true;
                  if($post->search_date){ if(date('Y-m-d',strtotime($row['sale_datetime'])) != $post->search_date){ $show = false; } }
                  if($show){
                   $data['sale_id']    =       $row['sale_id'];
                   $product_datas      =       json_decode($row['product_details']);
                   $product_details= array(); 
                   foreach($product_datas as $pdata)
                   { 
                      $prod = array();
                      $rate = $this->db->where('product_id',$pdata->id)->where('user_id',$uid)->get('reviews')->row()->rating; 
                      $prod['id']                 =     $pdata->id;
                      $prod['name']               =     $pdata->name;
                      $prod['image']              =     $pdata->image;
                      if($row['delivery_status'] == 'delivered')
                      {
                         if($rate == NULL)
                           {
                              $prod['rating']      =       0;
                           }
                           else
                           {
                              $prod['rating']    =       $rate;
                          }
                    }
                      $product_details[]          =     $prod;
                   }
                   $data['product_details']  =     $product_details;
                   $del_status                =     $row['delivery_status'];
                  
                    if($del_status == 'delivered')
                    {
                         $data['delivery_status'] = 'delivered';
                        $data['delivary_datetime']    =   'Delivered on '.date('d M Y', strtotime($row['delivary_datetime']));
                    }
                   else if($del_status == 'on_delivery')
                    {
                         $ship_detail   =    json_decode($row['shipping_detail'],true); 
                         $exp           =    $ship_detail['expected_date']; 
                         $data['delivery_status'] = 'on-delivery';
                         $data['delivary_datetime']     =   'Delivery expected on '.date('d M Y', strtotime($exp));
                    }
                    else
                    {
                       $ship_detail   =    json_decode($row['shipping_detail'],true); 
                       $exp           =    $ship_detail['expected_date']; 
                       $data['delivery_status'] = 'pending';
                       $data['delivary_datetime']     =   'Delivery expected on '.date('d M Y', strtotime($exp));
                    }
                  
                  $result['data'][]       =       $data;
              } }
          }
          else
          {
            $result['httpcode']       =  400;
            $result['status']         = 'error';
            $result['message']        = 'No order found';
            $result['data']           = $data;
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
        $result['httpcode']         = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }

     else
      { 
        $ord_id = $this->input->post('order_id');
          if($ord_id)
          {
          $uid  =   $this->Basic_model->get_value('user','user_id','access_token',$utoken);
          $order  =   $this->db->order_by('sale_id', 'desc')->where(array('status'=>1,'buyer'=>$uid,'sale_id'=>$ord_id))->get('sale')->row(); 
          
           if($order)
           {      
                  $vendorId = $order->vendor_id;
                  $contry_id = $this->db->where('vendor_id',$vendorId)->get('vendor')->row()->country_code;
                  $Curency   = $this->db->where('id',$contry_id)->get('countries')->row()->currency;
                  $result['httpcode']         =        200;
                  $result['status']           =       'success';
                  $result['message']          =       'order detail';
                  $data['order_date']         =       date('d-M-Y', strtotime($order->sale_datetime));
                  $data['order_id']           =       $order->sale_code; 
                  $data['order_total']        =       number_format($order->grand_total,2);  

                   $product_datas      =       json_decode($order->product_details); 
                   $product_details= array(); 

                   foreach($product_datas as $pdata)
                   { 
                      $prod = array();
                       $rate = $this->db->where('product_id',$pdata->id)->where('user_id',$uid)->get('reviews')->row()->rating; 
                      $prod['id']                 =     $pdata->id;
                      $prod['name']               =     $pdata->name;
                      $prod['image']              =     $pdata->image;
                      $prod['price']              =     $pdata->price;
                       if($order->delivery_status == 'delivered')
                      {
                        if($rate == NULL)
                         {
                            $prod['rating']      =       0;
                         }

                         else
                         {
                            $prod['rating']    =       $rate;
                          }
                      }
                      $prod['qty']              =     $pdata->qty;
                      $prod['subtotal']         =     $pdata->subtotal;
                      $product_details[]        =     $prod;
                   }
                   $items_count = count($product_details); 
                  $data['items_count']        =        $items_count;
                  $data['product_details']    =        $product_details;
                  $data['currency']           =        $Curency;
                  $data['ordered']            =       date('l, d M Y', strtotime($order->sale_datetime));
                   $del_status                 =       $order->delivery_status;

                    if($del_status == 'delivered')
                    {
                        $data['delivery_status'] = 'delivered';
                        $data['delivered']    =   date('D, d M Y', strtotime($order->delivary_datetime));
                    }
                    else if($del_status == 'on_delivery')
                    {
                       $ship_detail   =    json_decode($order->shipping_detail,true); 
                       $exp           =    $ship_detail['expected_date']; 
                       $data['delivery_status'] = 'on-delivery';
                       $data['delivered']     =   date('D, d M Y', strtotime($exp));
                    }
                    else
                    {
                       $ship_detail   =    json_decode($order->shipping_detail,true); 
                       $exp           =    $ship_detail['expected_date']; 
                       $data['delivery_status'] = 'pending';
                       $data['delivered']     =   date('D, d M Y', strtotime($exp));
                    }
                  $data['payment_method']     =    $order->payment_type;
                  $shipping_addr              =    json_decode($order->shipping_address,true); 
                  $bdata['address_type']      =    $shipping_addr['address_type'];
                  $bdata['house_flat']        =    $shipping_addr['address1'];
                  $bdata['road_name']         =    $shipping_addr['address2'];
                  $bdata['landmark']          =    $shipping_addr['address3'];
                  $bdata['zip']               =    $shipping_addr['zip'];
                   $data['billing_address'][] =       $bdata;

                  $sdata['s_address_type']     =    $shipping_addr['s_address_type'];
                  $sdata['s_house_flat']       =    $shipping_addr['s_address1'];
                  $sdata['s_road_name']        =    $shipping_addr['s_address2'];
                  $sdata['s_landmark']         =    $shipping_addr['s_address3'];
                  $sdata['s_zip']              =    $shipping_addr['zip'];
                  $data['shipping_address'][]  =    $sdata;

                  $data['payment_status']     =       json_decode($order->payment_status);
                  $data['total_amount']       =       number_format($order->total_amount,2);
                  $data['shipping_cost']      =       number_format($order->shipping,2);
                  $data['tax']                =       "";
                  $data['grand_total']        =       number_format($order->grand_total,2); 
                  $result['data']   =       $data;
            }

            else
            {
              $result['httpcode'] =  400;
              $result['status']   = 'error';
              $result['message']  = 'No order found';
              $result['data']   = NULL;
            }
            $this->response($result);
        }
        else
        {
          $result['httpcode']     =  400;
          $result['status']       = 'error';
          $result['message']      = 'Order id is required';
          $result['data']['order_id'] = 'Order id is required';
          $this->response($result);
        }
      }
  }
    
    // Address add
    public function address_post()
    {
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
       $result['httpcode']          = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
     else
      {
      $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
      $data                       = array();
      $data['name']               = trim($this->post("name"));
      $data['address_type']       = trim($this->post("address_type"));
      $data['house_flat']         = trim($this->post("house_flat"));
      $data['zipcode']            = trim($this->post("zipcode"));
      $data['road_name']          = trim($this->post("road_name"));
      $data['landmark']           = trim($this->post("landmark"));
      $data['country_code']       = trim($this->post("country_code"));
      $data['city']               = trim($this->post("city"));
      $data['default']            = trim($this->post("default"));

      $errors=array();
      if(!$data['name'])
      { 
        $errors['name']         = 'Name is required';
      }
      if(!$data['address_type'])
      { 
        $errors['address_type'] = 'Address type is required';
      }
      if(!$data['house_flat'])
      { 
        $errors['house_flat'] = 'House / Flat / Block no is required';
      }
      if(!$data['zipcode'])
      { 
        $errors['zipcode']    = 'Zipcode is required';
      }
      if(!$data['road_name'])
      { 
        $errors['road_name']    = 'Road name is required';
      }
      if(!$data['landmark'])
      { 
        $errors['landmark']     = 'Landmark is required';
      }
      if(!$data['country_code'])
      { 
        $errors['country_code']  = 'Country code is required';
      }
       if(!$data['city'])
      { 
        $errors['city']          = 'City code is required';
      }
      if($errors)
        {
            $r['httpcode']          =  400;
            $r['status']            = 'error';
            $r['message']           =  reset($errors);
            $r['data']              =  $errors;
            $this->response($r);
        }
        else
        {
          $this->response($this->Api_user_model->address($uid,$data));
        }
    }
  }
  
   // Address edit
    public function address_edit_post()
    {
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
       $result['httpcode']          = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
     else
      {
      $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
      $data                       = array();
      $data['name']               = trim($this->post("name"));
      $data['address_id']         = trim($this->post("address_id"));
      $data['address_type']       = trim($this->post("address_type"));
      $data['house_flat']         = trim($this->post("house_flat"));
      $data['zipcode']            = trim($this->post("zipcode"));
      $data['road_name']          = trim($this->post("road_name"));
      $data['landmark']           = trim($this->post("landmark"));
      $data['country_code']       = trim($this->post("country_code"));
      $data['city']               = trim($this->post("city"));
      $data['default']            = trim($this->post("default"));

      $errors=array();
      if(!$data['name'])
      { 
        $errors['name']         = 'Name is required';
      }
      if(!$data['address_id'])
      { 
        $errors['address_id'] = 'Address id is required';
      }
      if(!$data['address_type'])
      { 
        $errors['address_type'] = 'Address label is required';
      }
      if(!$data['house_flat'])
      { 
        $errors['house_flat'] = 'House / Flat / Block no is required';
      }
      if(!$data['zipcode'])
      { 
        $errors['zipcode']    = 'Zipcode is required';
      }
      if(!$data['road_name'])
      { 
        $errors['road_name']    = 'Road name is required';
      }
      if(!$data['landmark'])
      { 
        $errors['landmark']     = 'Landmark is required';
      }
      if(!$data['country_code'])
      { 
        $errors['country_code']  = 'Country code is required';
      }
       if(!$data['city'])
      { 
        $errors['city']          = 'City code is required';
      }
      if($errors)
        {
            $r['httpcode']          =  400;
            $r['status']            = 'error';
            $r['message']           =  reset($errors);
            $r['data']              =  $errors;
            $this->response($r);
        }
        else
        {
          $this->response($this->Api_user_model->address_edit($uid,$data));
        }
    }
  }

    // Address delete
    public function address_delete_post()
    {
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
       $result['httpcode']          = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
     else
      {
      $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
      $data                       = array();
      $data['address_id']         = trim($this->post("address_id"));
      $errors=array();
      if(!$data['address_id'])
      { 
        $errors['address_id'] = 'Address id is required';
      }
      if($errors)
        {
            $result['httpcode']          =  400;
            $result['status']            = 'error';
            $result['message']           =  reset($errors);
            $result['data']              =  $errors;
            $this->response($result);
        }
        else
        {
           $default_addr = $this->db->where('adrs_id',$data['address_id'])->where('user_id',$uid)->get('user_address')->row();
           $addr = $default_addr->default_addr; 
           if($addr == 1)
           {
               $exist = $this->db->where('user_id',$uid)->where('status',1)->get('user_address')->row();
               if($exist)
               {
                $this->db->set('default_addr',1)->where('adrs_id',$exist->adrs_id)->update('user_address');
               }
               $deietedata = $this->db->where('adrs_id',$data['address_id'])->where('user_id',$uid)->delete('user_address');
           }
           else
           {
             $deietedata = $this->db->where('adrs_id',$data['address_id'])->where('user_id',$uid)->delete('user_address');
           }
           
            if($deietedata)
            {
              $result['httpcode']           =   200;
              $result['status']             = 'success';
              $result['message']            = 'Address deleted successfully';
              $this->response($result);
            }
        }
    }
  }
  
    //Address List
    function address_list_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
       $result['httpcode']          = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
     else
      {
        $uid  = $this->Basic_model->get_value('user','user_id','access_token',$utoken); 
        $data = array(); $datas = array();
        $datas['country_code']  = trim($this->post("country_code"));
        $errors=array();
       
          $addr  =   $this->db->where(array('status'=>1,'user_id'=>$uid))->get('user_address')->result_array();
         if($addr)
         {
              $result['httpcode']         =   200;
              $result['status']           =   'success';
              $result['message']          =   'Address list';
              foreach($addr as $row)
              {
                $country_name = $this->db->where('sortname',$row['country'])->get('countries')->row()->name; 
                $data['adrs_id']            =   $row['adrs_id'];
                $data['name']               =   $row['fname'];
                $data['address_type']       =   $row['address_label'];
                $data['house_flat']         =   $row['address1'];
                $data['zip']                =   $row['zip'];
                $data['road_name']          =   $row['road_name'];
                $data['landmark']           =   $row['landmark'];
                $data['city']               =   $row['city'];
                $data['country']            =   $country_name;
                $data['default']            =   $row['default_addr'];
                $result['data'][]           =   $data;
              }
          }
          else
          {
            $result['httpcode']   = 400;
            $result['status']     = 'error';
            $result['message']    = 'No address found';
            $result['data']       = $data;
          }
          $this->response($result);
      }
    }

    //Checkout Address List
    function checkout_address_list_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
       $result['httpcode']          = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
     else
      {
        $uid  = $this->Basic_model->get_value('user','user_id','access_token',$utoken); 
        $data = array(); $datas = array();
        $datas['country_code']  = trim($this->post("country_code"));
        $errors=array();
        if(!$datas['country_code'])
        { 
          $errors['country_code'] = 'Country code is required';
        }
        if($errors)
        {
              $result['httpcode']          =  400;
              $result['status']            = 'error';
              $result['message']           =  reset($errors);
              $result['data']              =  $errors;
              $this->response($result);
        }
        else
        {
          $addr  =   $this->db->where(array('status'=>1,'user_id'=>$uid,'country'=>$datas['country_code']))->get('user_address')->result_array();
         if($addr)
         {
              $result['httpcode']         =   200;
              $result['status']           =   'success';
              $result['message']          =   'Address list';
              foreach($addr as $row)
              {
                $country_name = $this->db->where('sortname',$row['country'])->get('countries')->row()->name; 
                $data['adrs_id']            =   $row['adrs_id'];
                $data['name']               =   $row['fname'];
                $data['address_type']       =   $row['address_label'];
                $data['house_flat']         =   $row['address1'];
                $data['zip']                =   $row['zip'];
                $data['road_name']          =   $row['road_name'];
                $data['landmark']           =   $row['landmark'];
                $data['city']               =   $row['city'];
                $data['country']            =   $country_name;
                $data['default']            =   $row['default_addr'];
                $result['data'][]           =   $data;
              }
          }
          else
          {
            $result['httpcode']   = 400;
            $result['status']     = 'error';
            $result['message']    = 'No address found';
            $result['data']       = $data;
          }
          $this->response($result);
        }
      }
    }

    //Search address
    function search_address_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
       $result['httpcode']          = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
     else
      {
      $uid  = $this->Basic_model->get_value('user','user_id','access_token',$utoken); 
      $datas = array(); $data = array();
      // $datas['country_code']  = trim($this->post("country_code"));
      // $errors=array();
      // if(!$datas['country_code'])
      // { 
      //   $errors['country_code'] = 'Country code is required';
      // }
      // if($errors)
      // {
      //       $result['httpcode']          =  400;
      //       $result['status']            = 'error';
      //       $result['message']           =  reset($errors);
      //       $result['data']              =  $errors;
      //       $this->response($result);
      // }
      // else
      // {
      $search= $this->post("search");
      // $this->db->select('user_address.*');
      $this->db->from('user_address');
      $this->db->where('status',1);
      $this->db->where('user_id',$uid);
      if($search != '')
      {
        $this->db->where("(address_label LIKE '%".$search."%' OR address1 LIKE '%".$search."%' OR road_name LIKE '%".$search."%' OR landmark LIKE '%".$search."%' OR zip LIKE '%".$search."%'OR city LIKE '%".$search."%')", NULL, FALSE);
      }
      $query  = $this->db->get();
      $addr  = $query->result_array(); 
      if($addr)
      {
            $result['httpcode']         =   200;
            $result['status']           =   'success';
            $result['message']          =   'Address list';
            foreach($addr as $row)
            {
                $country_name = $this->db->where('sortname',$row['country'])->get('countries')->row()->name; 
                $data['adrs_id']            =   $row['adrs_id'];
                $data['name']               =   $row['fname'];
                $data['address_type']       =   $row['address_label'];
                $data['house_flat']         =   $row['address1'];
                $data['zip']                =   $row['zip'];
                $data['road_name']          =   $row['road_name'];
                $data['landmark']           =   $row['landmark'];
                $data['city']               =   $row['city'];
                $data['country']            =   $country_name;
                $data['default']            =   $row['default_addr'];
                $result['data'][]           =   $data;
            }
        }
        else
        {
          $result['httpcode']   = 400;
          $result['status']     = 'error';
          $result['message']    = 'No address found';
          $result['data']       = $data;
        }
        $this->response($result);
       // }
      }
    }
  
  //Checkout Search address
    function checkout_search_address_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
       $result['httpcode']          = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
     else
      {
      $uid  = $this->Basic_model->get_value('user','user_id','access_token',$utoken); 
      $datas = array(); $data = array();
      $datas['country_code']  = trim($this->post("country_code"));
      $errors=array();
      if(!$datas['country_code'])
      { 
        $errors['country_code'] = 'Country code is required';
      }
      if($errors)
      {
            $result['httpcode']          =  400;
            $result['status']            = 'error';
            $result['message']           =  reset($errors);
            $result['data']              =  $errors;
            $this->response($result);
      }
      else
      {
      $search= $this->post("search");
      // $this->db->select('user_address.*');
      $this->db->from('user_address');
      $this->db->where('status',1);
      $this->db->where('user_id',$uid);
      $this->db->where('country',$datas['country_code']);
      if($search != '')
      {
        $this->db->where("(address_label LIKE '%".$search."%' OR address1 LIKE '%".$search."%' OR road_name LIKE '%".$search."%' OR landmark LIKE '%".$search."%' OR zip LIKE '%".$search."%'OR city LIKE '%".$search."%')", NULL, FALSE);
      }
      $query  = $this->db->get();
      $addr  = $query->result_array(); 
      if($addr)
      {
            $result['httpcode']         =   200;
            $result['status']           =   'success';
            $result['message']          =   'Address list';
            foreach($addr as $row)
            {
                $country_name = $this->db->where('sortname',$row['country'])->get('countries')->row()->name; 
                $data['adrs_id']            =   $row['adrs_id'];
                $data['address_type']       =   $row['address_label'];
                $data['name']               =   $row['fname'];
                $data['house_flat']         =   $row['address1'];
                $data['zip']                =   $row['zip'];
                $data['road_name']          =   $row['road_name'];
                $data['landmark']           =   $row['landmark'];
                $data['city']               =   $row['city'];
                $data['country']            =   $country_name;
                $data['default']            =   $row['default_addr'];
                $result['data'][]           =   $data;
            }
        }
        else
        {
          $result['httpcode']   = 400;
          $result['status']     = 'error';
          $result['message']    = 'No address found';
          $result['data']       = $data;
        }
        $this->response($result);
       }
      }
    }
	 
	 //Shipping operators List
    function shipping_operators_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']           = 400;
        $result['status']             = 'error';
        $result['message']            = 'Invalid access token';
        $result['data']['error']      = 'Invalid access token';
        $result['data']['redirect']   = 'login';
        $this->response($result);
      }
      else
      {
       $data = array();
       $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
       $cart = $this->db->where('user_id',$uid)->get('cart')->row();
       if($cart)
       {
         $vendor_id = $cart->vendor_id;
       $contry_id = $this->db->where('vendor_id',$vendor_id)->get('vendor')->row()->country_code;  
       $shipping_operators  =   $this->db
      ->select('shipping_operators.id as ship_operate_id,shipping_operators.operator')
      ->join('shipping_zones','shipping_operators.id = shipping_zones.operator_id','inner')
      ->where('shipping_zones.country_id',$contry_id)
      ->where('shipping_operators.status',1)
      ->get('shipping_operators')
      ->result_array(); 
       if($shipping_operators)
       {
            $result['httpcode']         =   200;
            $result['status']           =   'success';
            $result['message']          =   'Shipping operators list';
            foreach($shipping_operators as $row)
            { 
                $data['shipping_operator_id']   = $row['ship_operate_id'];
                $data['operator']               = $row['operator'];
                $result['data'][]               = $data;
            }
        }
        else
        {
          $result['httpcode']   = 400;
          $result['status']   = 'error';
          $result['message']    = 'No shipping operators found';
          $result['data']     = $data;
        }
        $this->response($result);
       } 
       else
       {
         $result['httpcode']   = 400;
         $result['status']     = 'error';
         $result['message']    = 'Cart not found';
          $this->response($result);
       }
      }
    }

    //Delivery fee based on shipping operator 
    public function delivery_fee_post()
    {
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']       = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']  = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
      else
      {
      $data=array();
      $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
      $data['operator_id']          = trim($this->post("operator_id")); 
       $errors = array();
       if(!$data['operator_id'])
      { 
        $errors['operator_id']      = 'Operator id is required';
      }
      if($errors)
        {
            $r['httpcode']          =  400;
            $r['status']        = 'error';
            $r['message']         = reset($errors);
            $r['data']            =  $errors;
            $this->response($r);
        }
        else
        {
          $this->response($this->Api_user_model->delivery_fee($uid, $data));
        }
      }
    }  

      //Signout
    public function signout_post()
    {
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']       = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
      else
      {
        $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
        $data['access_token'] = NULL;
        $data['is_login'] = 0;
        $this->db->where('user_id',$uid)->update('user',$data);
        $result['httpcode'] =    200;
        $result['status']   =   'success';
        $result['message']  =   'Signout successfully';
      $this->response($result);
      }
    }  
    
    //Product List based on category 
    function browse_category_post()   
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']         = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
      else
      {
        $data = array();
        $pdata=array();
        $errors = array();
        $pdata['country_code']= $this->post("country_code"); 
        $pdata['category_id']= $this->post("category_id");
        if(!$pdata['country_code'])
        { 
          $errors['country_code']      = 'Country code is required';
        }
        if(!$pdata['category_id'])
        { 
          $errors['category_id']      = 'Category id is required';
        }
        if($errors)
        {
            $r['httpcode']          =  400;
            $r['status']        = 'error';
            $r['message']         = reset($errors);
            $r['data']            =  $errors;
            $this->response($r);
        }
        else
        {

        $this->db->select('product.*,category.*');
        $this->db->from('product');
        $this->db->order_by("product.product_id", "desc");
        $this->db->where(array('product.status'=>'ok','product.category'=>$pdata['category_id']));
        $this->db->join('category', 'category.category_id = product.category','inner');
        $query  = $this->db->get();
        $product = $query->result_array();
       if($product)
       { 
           $result['httpcode']          =   200;
            $result['status']           =   'success';
            $result['message']          =   'Product list';
            foreach($product as $row)
            { 
              $country_id = $this->db->where('sortname',$pdata['country_code'])->get('countries')->row()->id; 
              $vendor_id  = $this->db->where('country_code',$country_id)->get('vendor')->row()->vendor_id; 
              $vendor_price = $this->db->where('vendor_id',$vendor_id)->where('prd_id',$row['product_id'])->get('vendor_prices')->row()->price; 
               if ($this->Basic_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one'))
                    {
                        $path     =       $this->Basic_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one');
                    }
                    else
                    {
                        $path     =       base_url("uploads/product_image/default_product_thumb.jpg");
                    } 
                $data['product_id']            =       $row['product_id'];
                $data['product_title']         =       $row['title'];
                $data['qty']                   =       $row['mpn'];
                $data['unit']                  =       $row['unit'];
                $data['current_stock']        =        $row['current_stock'];
                if($vendor_id)
                {
                    if($vendor_price == NULL)
                    {
                       $data['price']             =       0;
                    }
                    else
                    {
                         $data['price']             =       $vendor_price;
                    }
                    $Curency  = $this->db->where('id',$country_id)->get('countries')->row()->currency;   
                    $data['currency']              =       $Curency;
                }
                else
                {
                   $data['price']    =  "";
                   $data['currency'] =  "";
                }
                $data['product_image']         =       $path;
                $r_total =  $row['rating_total'];
                $r_num = $row['rating_num'];
                $rating = bcdiv($r_total, $r_num, 1);
                if($rating != NULL)
                {
                  $data['rating']      =   $rating;
                }
                else
                {
                  $data['rating']      =   "";
                } 
                $data['category']              =       $row['category_name'];
                $result['data'][]              =       $data;
            }
        }
        else
        {
          $result['httpcode']   =  400;
          $result['status']     = 'error';
          $result['message']    = 'No product found';
          $result['data']       =  $data;
        }
        $this->response($result);
      }
    }
  }  

   //Product List based on industry 
    function browse_industry_post()   
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']         = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']    = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
      else
      {
        $data = array();
        $errors = array();
        $pdata['country_code']= $this->post("country_code"); 
        $pdata['industry_id']= $this->post("industry_id");
        if(!$pdata['country_code'])
        { 
          $errors['country_code']      = 'Country code is required';
        }
        if(!$pdata['industry_id'])
        { 
          $errors['industry_id']      = 'Industry id is required';
        }
        if($errors)
        {
            $r['httpcode']          =  400;
            $r['status']        = 'error';
            $r['message']         = reset($errors);
            $r['data']            =  $errors;
            $this->response($r);
        }
        else
        {  
        $this->db->select('product.*,category.*');
        $this->db->from('product');
        $this->db->order_by("product.product_id", "desc");
        $this->db->where('product.status','ok');
        $this->db->join('category', 'category.category_id = product.category','inner');
        $query  = $this->db->get();
        $product = $query->result_array();
       if($product)
       {    
            $result['httpcode']         =   200;
            $result['status']           =   'success';
            $result['message']          =   'Product list';
            $result['data']             = array();
            $product_list=array();
            foreach($product as $row)
            { 
              $brand    = $row['brand'];
              $sbrand   = explode(",",$brand); 
               if(in_array($pdata['industry_id'],$sbrand))
               {
               // $data['brand']                  =       $row['brand'];
                $country_id = $this->db->where('sortname',$pdata['country_code'])->get('countries')->row()->id; 
              $vendor_id  = $this->db->where('country_code',$country_id)->get('vendor')->row()->vendor_id; 
              $vendor_price = $this->db->where('vendor_id',$vendor_id)->where('prd_id',$row['product_id'])->get('vendor_prices')->row()->price; 
               if ($this->Basic_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one'))
                    {
                        $path     =       $this->Basic_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one');
                    }
                    else
                    {
                        $path     =       base_url("uploads/product_image/default_product_thumb.jpg");
                    } 
                $data['product_id']            =       $row['product_id'];
                $data['product_title']         =       $row['title'];
                $data['qty']                   =       $row['mpn'];
                $data['unit']                  =       $row['unit'];
                $data['current_stock']        =        $row['current_stock'];
                if($vendor_id)
                {
                    if($vendor_price == NULL)
                    {
                       $data['price']             =       0;
                    }
                    else
                    {
                         $data['price']             =       $vendor_price;
                    }
                    $Curency  = $this->db->where('id',$country_id)->get('countries')->row()->currency;   
                    $data['currency']              =       $Curency;
                }
                else
                {
                   $data['price']    =  "";
                   $data['currency'] =  "";
                }
                $data['product_image']         =       $path;
                $r_total =  $row['rating_total'];
                $r_num = $row['rating_num'];
                $rating = bcdiv($r_total, $r_num, 1);
                if($rating != NULL)
                {
                  $data['rating']      =   $rating;
                }
                else
                {
                  $data['rating']      =   "";
                }  
                $data['category']              =       $row['category_name'];
                
                $product_list[]              =       $data;
              }  
            }

             $result['data']       =$product_list;
        }
        else
        {
          $result['httpcode']   =  400;
          $result['status']     = 'error';
          $result['message']    = 'No product found';
          $result['data']       =  $data;
        }
        $this->response($result);
      }
    }
  } 

   //Service Category List
    function service_category_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']           = 400;
        $result['status']             = 'error';
        $result['message']            = 'Invalid access token';
        $result['data']['error']      = 'Invalid access token';
        $result['data']['redirect']   = 'login';
        $this->response($result);
      }
      else
      {
       $data = array();
       $industry  =   $this->db->order_by('service_category_id', 'desc')->where(array('status'=>1))->get('service_category')->result_array();
       if($industry)
       {
          $result['httpcode']           =   200;
            $result['status']           =   'success';
            $result['message']          =   'Service category list';
            foreach($industry as $row)
            {
                
                $data['service_category_id']    =       $row['service_category_id'];
                $data['service_category_name']  =       $row['name'];
                $result['data'][]       =       $data;
            }
        }
        else
        {
          $result['httpcode']   = 400;
          $result['status']   = 'error';
          $result['message']    = 'No service category found';
          $result['data']     = $data;
        }
        $this->response($result);
      }
    }


   //Service Type List
    function service_type_post()
    {
      $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']           = 400;
        $result['status']             = 'error';
        $result['message']            = 'Invalid access token';
        $result['data']['error']      = 'Invalid access token';
        $result['data']['redirect']   = 'login';
        $this->response($result);
      }
      else
      {
       $data = array();
       $industry  =   $this->db->order_by('service_type_id', 'desc')->where(array('status'=>1))->get('service_type')->result_array();
       if($industry)
       {
          $result['httpcode']           =   200;
            $result['status']           =   'success';
            $result['message']          =   'Service type list';
            foreach($industry as $row)
            {
                
                $data['service_type_id']    =       $row['service_type_id'];
                $data['service_type']       =       $row['type'];
                $result['data'][]           =       $data;
            }
        }
        else
        {
          $result['httpcode']   = 400;
          $result['status']   = 'error';
          $result['message']    = 'No service type found';
          $result['data']     = $data;
        }
        $this->response($result);
      }
    }
    
     //Payment  
    public function payment_post()
    {
       $utoken = $this->post("access_token");
      if($this->Basic_model->uservalid($utoken)==false)
      {
        $result['httpcode']       = 400;
        $result['status']           = 'error';
        $result['message']          = 'Invalid access token';
        $result['data']['error']  = 'Invalid access token';
        $result['data']['redirect'] = 'login';
        $this->response($result);
      }
      else
      {
      $data=array();
      $uid = $this->Basic_model->get_value('user','user_id','access_token',$utoken);
     // $data['cart_id']        = trim($this->post("cart_id"));
      $data['name']             = trim($this->post("name"));
      $data['address_type']     = trim($this->post("address_type"));
      $data['housename']        = trim($this->post("housename"));
      $data['roadname']         = trim($this->post("roadname"));
      $data['landmark']         = trim($this->post("landmark"));
      $data['pincode']          = trim($this->post("pincode"));
      $data['city']             = trim($this->post("city"));
      $data['country']          = trim($this->post("country_name"));
      $data['payment_status']   = trim($this->post("payment_status"));
      $data['payment_method']   = trim($this->post("payment_method"));
      $data['operator_id']      = trim($this->post("operator_id"));    
      
      $errors = array();
       if(!$data['name'])
      { 
        $errors['name']             = 'Name is required';
      }
      if(!$data['address_type'])
      { 
        $errors['address_type']       = 'Address type is required';
      }
      if(!$data['housename'])
      { 
        $errors['housename']          = 'Housename is required';
      }
      if(!$data['landmark'])
      { 
        $errors['landmark']            =  'Landmark is required';
      }
      if(!$data['roadname'])
      { 
        $errors['roadname']            =  'Roadname is required';
      }
      if(!$data['pincode'])
      { 
        $errors['pincode']             = 'Pincode is required';
      }
      if(!$data['city'])
      { 
        $errors['city']                = 'City is required';
      }
      if(!$data['country'])
      { 
        $errors['country']             =  'Country name is required';
      }
      if(!$data['payment_status'])
      { 
        $errors['payment_status']      = 'Payment status is required';
      }
      if(!$data['payment_method'])
      { 
        $errors['payment_method']      = 'Payment method is required';
      }
      if(!$data['operator_id'])
      { 
        $errors['operator_id']         =  'Operator id is required';
      }
      if($errors)
        {
            $r['httpcode']   =  400;
            $r['status']     =  'error';
            $r['message']    =  reset($errors);
            $r['data']       =  $errors;
            $this->response($r);
        }
        else
        {
             $this->response($this->Api_user_model->payment($uid, $data));
        }
      }     
  }
  
  public function saveReview_post(){ 
        if($user = validateToken($this->input->post('access_token'))){
            $this->form_validation->set_rules('product_id', 'Product ID', 'required|numeric');
            $this->form_validation->set_rules('rating', 'Rating', 'required|numeric');
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('review', 'Review', 'required');
            if ($this->form_validation->run() == FALSE){
                $errors     =   $this->form_validation->error_array();
                $result     =   ['httpcode'=>400,'status'=>'error','message'=>array_values($errors)[0],'data'=>['error'=>$errors]];
            }else{ $result  =   $this->shop->saveReview($user,(object)$this->input->post()); }
        }else{ $result      =   tokenErrorResponse(); }
        $this->response($result);
    }
    
    public function viewReview_post(){ 
        if($user = validateToken($this->input->post('access_token'))){
            $this->form_validation->set_rules('review_id', 'Review ID', 'required|numeric');
            if ($this->form_validation->run() == FALSE){
                $errors     =   $this->form_validation->error_array();
                $result     =   ['httpcode'=>400,'status'=>'error','message'=>array_values($errors)[0],'data'=>['error'=>$errors]];
            }else{ $result  =   $this->shop->viewReview($user,(object)$this->input->post()); }
        }else{ $result      =   tokenErrorResponse(); }
        $this->response($result);
    }
  
   public function version_get(){ 
        $this->response($this->shop->getCurrentVersion());
    }
}
?>