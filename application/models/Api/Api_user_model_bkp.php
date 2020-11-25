<?php


class Api_user_model_bkp extends CI_Model 
{

    function __construct()  
    { 
    	parent::__construct();
    	$this->load->helper('string');
      $this->load->model('api/Basic_model','Basic_model');
        
    }
   

    //User Registration
    public function register($data)
    {
      if($this->Api_user_model->registervalidate($data)=='true')
      {
        $acess_token            = rand(100000,999999);        
        $Udata['username']      = $data['username'];
        $Udata['email']         = $data['email'];
        $Udata['mobile']        = $data['mobile'];
        $Udata['is_login']      = 1;
        $Udata['password']      = md5($data['password']);
        $Udata['access_token']  = $acess_token;
        $insertDatas = $this->db->insert('user',$Udata);
        // if($insertDatas)
        // {
        //   $to_email=$Udata['email']; 
        //   $subject="Vinner Password";
        //   $message="Hi : <b>".$Udata['username']."</b>"; 
        //   $message = 'Your registertion in successfully processed';
        //   $this->send_mail($to_email,$subject,$message);
        // }
        $result['status']       = 'success';
        $result['message']      = 'Registerd Successfully';
        $result['redirect']     = 'Dashboard';
        $result['data']['access_token'] = $acess_token;
        $result['data']['username']     = $Udata['username'];
        $result['data']['email']        = $Udata['email'];
        $result['data']['mobile']       = $Udata['mobile'];
        return $result;
      }
      else
      {
        $result['status']  = 'failed';
        $result['message'] = $this->Api_user_model->registervalidate($data);
        return $result;
      }

    }

 
   //User Register validate
  public function registervalidate($data)
    {
      $valid='true';
      $error=array();
      if($data['mobile'])
      {
          if($this->Basic_model->check_existuser('user','mobile',$data['mobile']))
          {
            $valid='false';
            $error='Mobile number already registerd';
          }
          else
          {
            if($data['email'])
            {
              if($this->Basic_model->check_existuser('user','email',$data['email']))
                {
                  $valid='false';
                  $error='Email id already registerd';
                }
              else
                { 
                  if($data['password'])
                  {
                    if(strlen($data['password'])<'6')
                    {
                      $valid='false';
                      $error='Password must be at least 6 characters in length';
                    }
                    else if($data['password'] != $data['confirm_password'])
                    {
                      $valid='false';
                      $error='Password and confirm password must be same';
                    }
                    else
                    {
                      if($data['username'] ==  NULL)
                      {
                        $valid='false';
                        $error='The user name field is required';
                      }
                    }
                  }
                  else
                  {
                    $valid='false';
                    $error='Password is required';
                  }
                } 
            }
            else
            {
              $valid='false';
              $error='Email id required';
            }
          } 
      }
      else
      {
        $valid='false';
        $error='Mobile number required';
      }

      if($valid=='true')
      {
        return $valid;
      }
      else
      {
        return $error;
      }
    } 


  // public function send_mail($to_email,$subject='',$message) 
  // { 
  //   $from_email = "admin@vinner.com"; 
  //   //$to_email   = "ajith@estrrado.com"; 
   
  //   $this->load->library('email'); 
   
  //   $this->email->from($from_email, 'Vinner'); 
  //   $this->email->reply_to('no_replay@vinner.com','no_replay');
  //   $this->email->to($to_email);
  //   $this->email->subject($subject); 
  //   $this->email->message($message); 
  //   $this->email->set_mailtype('html');
         
  //   if($this->email->send()) 
  //     return 1;
  //   else 
  //    return 0;
    
  // }  

    //Send OTP to mobile
    public function sendotp($mobileno)
        {
          $this->db->where('mobile',$mobileno)->delete('otp_verification');
          $otp = $this->Api_user_model->otpgenrate($mobileno);
          $data['mobile'] = $mobileno;
          $data['otp'] = $otp; 
          $this->db->insert('otp_verification',$data);
          $r['status']  = 'success';
          $r['message'] ='OTP sent in your mobile number';
          $r['data']['otp']=$otp;
          return $r;
        }

     //OTP getrate
    public function otpgenrate($mobile)
    {
        $pin = rand(1000, 9999);
        $pin =1234;
       // $this->Api_user_model->mobilesendotp($mobile,$pin);
        return $pin;
    }
 
  //Mobile OTP
    public function mobilesendotp($mobile,$otp)
    {
        $message=urlencode('[#] Vinner OTP:'.$otp .' LWHd46bGqgG');//ZFALNc+3wue
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://sms.estrrado.com/sendsms?uname=Poetrl&pwd=sms4poetrl&senderid=Poetrl&to=$mobile&msg=$message&route=T",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        )); 
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl); print_r($response);
        if ($err) 
        {
        return "cURL Error #:" . $err;
        } 
        else 
        {
        return $response;
        }
    }

    //Verify OTP
    public function verify_otp($data)
        {
           
            $user = $this->db->where('mobile',$data['mobile'])->get('otp_verification'); 
            if($user->num_rows() > 0)
            {
                $user_data = $user->row();
                if($user_data->otp==$data['otp'])
                {
                    $acess_token =   $user_data->id.rand(100000,999999);//.rand(1000,9999);
                    $userData    =   ['otp'=>NULL];
                    $this->db->where('mobile',$data['mobile'])->update('otp_verification',$userData);
                    $reg_user = $this->db->where('mobile',$data['mobile'])->get('user')->row(); 
                    if($reg_user)
                    {
                    $this->db->set(array('access_token'=>$acess_token,'is_login'=>1))->where('mobile',$data['mobile'])->update('user');
                    $r['status']        =  'success';
                    $r['message']       = 'OTP verified successfully! Login Successfully!';
                    $r['redirect']      = 'Dashboard';
                    $r['data']['access_token']  = $acess_token;
                    $r['data']['username']      = $reg_user->username;
                    $r['data']['email']         = $reg_user->email;
                    $r['data']['mobile']        = $reg_user->mobile;
                    return $r;
                  }
                  else
                  {
                    $r['status']    =  'success';
                    $r['message']   = 'OTP verified successfully! Please register your account.';
                    $r['redirect']  = 'Registeration';
                    $r['data']['mobile']    =   $data['mobile'];
                    return $r;
                  }
                }
                else
                {
                  $r['status']  =  'failed';
                  $r['message'] = 'The OTP entered is incorrect. Please try again or try resend the OTP.';
                  return $r;
              
                }
            }
            else
            { 
                 $r['status']    =  'failed';
                 $r['message']   = 'We cannot find a user with that phone number ';
                return $r;
            }
        
        }
         //profile update
    public function updateprofile($uid,$data)
    {
       if($this->Api_user_model->updatevalidate($uid,$data)=='true')
      {
        // $profilepic='';
        // unset($data['utoken']);
        // $profilepic=$data['profile_pic'];
        // unset($data['profile_pic']);
        $this->db->where('user_id',$uid)->update('user',$data);
        // if($profilepic)
        // {
        //   define('UPLOAD_DIR', 'uploads/user_image/');
        //   $decoded=base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$profilepic));
        //   $file = UPLOAD_DIR .'user_'.$uid.'.png';
        //   file_put_contents($file,$decoded);
        // }
               
           $result['status']  = 200;
           $result['message'] = 'success';
           $result['display'] = 'profile updated';
           $result['data']['action']= 'profile';
           return $result;
       }
      else
      {
        $result['status']  = 400;
        $result['message'] = 'failed';
        $result['display'] = $this->Api_user_model->updatevalidate($uid,$data);
        return $result;
      } 
    }

    function updatevalidate($uid,$data)
    {
      $valid='true';
      $error=array();
      if($data['mobile'])
      {
          $checkmobile = $this->db->get_where('user',array('user_id !=' => $uid,'mobile'=>$data['mobile'],'status'=>1))->num_rows();
          if($checkmobile > 0)
          {
            $valid='false';
            $error='Mobile number already registerd';
          }
          else
          {
            if($data['email'])
            {
              $checkemail=$this->db->get_where('user',array('user_id !=' => $uid,'email'=>$data['email'],'status !='=>1))->num_rows();
              if($checkemail > 0)
                {
                  $valid='false';
                  $error='Email id already registerd';
                }
              /*else
                {
                  if($data['code'])
                  {
                    $checkcode = $this->db->get_where('user',array('id !=' => $uid,'code'=>$data['code']))->num_rows();
                    if($checkcode > 0)
                    {
                      $valid='false';
                      $error='Subscriber code already registerd';
                    }
                  }
                  else
                  {
                    $valid='false';
                    $error='Subscriber code required';
                  }
                } */
            }
            else
            {
              $valid='false';
              $error='Email id required';
            }
          } 
      }
      else
      {
        $valid='false';
        $error='Mobile number required';
      }

      if($valid=='true')
      {
        return $valid;
      }
      else
      {
        return $error;
      }
    }
    //Request for service
    public function requestService($data)
    {
        $Udata['product']      = $data['product_id'];
        $Udata['name']         = $data['name'];
        $Udata['address']      = $data['address'];
        $Udata['city']         = $data['city'];
        $Udata['country']      = $data['country'];
        $Udata['email']        = $data['email'];
        $Udata['mobile']       = $data['mobile'];
        $Udata['date']         = date('Y-m-d', strtotime($data['date'])); 
        $Udata['time']         = date("H:i", strtotime($data['time']));
        $Udata['remark']       = $data['remark'];

        $insertDatas = $this->db->insert('request_service',$Udata);
       
        $result['status']  = 'success';
        $result['message'] = 'Service request sent successfully';
        $result['data']['product']      = $Udata['product'];
        $result['data']['name']         = $Udata['name'];
        $result['data']['address']      = $Udata['address'];
        $result['data']['city']         = $Udata['city'];
        $result['data']['country']      = $Udata['country'];
        $result['data']['email']        = $Udata['email'];
        $result['data']['mobile']       = $Udata['mobile'];
        $result['data']['date']         = $Udata['date'];
        $result['data']['time']         = $Udata['time'];
        $result['data']['remark']       = $Udata['remark'];
        return $result;
    }

     //Request for demo
    public function requestDemo($data)
    {
        $Udata['name']         = $data['name'];
        $Udata['address']      = $data['address'];
        $Udata['city']         = $data['city']; 
        $Udata['country']      = $data['country'];
        $Udata['email']        = $data['email'];
        $Udata['mobile']       = $data['mobile'];
        $Udata['date']         = date('Y-m-d', strtotime($data['date'])); 
        $Udata['time']         = date("H:i", strtotime($data['time']));
        $Udata['req_demo']     = $data['req_demo'];

        $insertDatas = $this->db->insert('request_demo',$Udata);
       
        $result['status']  = 'success';
        $result['message'] = 'Demo request sent successfully';
        $result['data']['name']         = $Udata['name'];
        $result['data']['address']      = $Udata['address'];
        $result['data']['city']         = $Udata['city'];
        $result['data']['country']      = $Udata['country'];
        $result['data']['email']        = $Udata['email'];
        $result['data']['mobile']       = $Udata['mobile'];
        $result['data']['date']         = $Udata['date'];
        $result['data']['time']         = $Udata['time'];
        $result['data']['req_demo']     = $Udata['req_demo'];
        return $result;
    }

     //Add cart
    public function add_cart($uId,$data)
    {
        $ndata['user_id'] = $ndata['vendor_id'] = $ndata['amount'] = $ndata['discount'] = $ndata['g_total'] = '';
        $this->db->insert('cart',$ndata);
        $insert_id = $this->db->insert_id(); 
        $product_name = $this->db->where('product_id',$data['product_id'])->get('product')->row()->title;

        $cidata['cart_id']        = $insert_id;
        $cidata['product_id']     = $data['product_id'];
        $cidata['product_name']   = $product_name;
        $cidata['qty']            = $data['product_qty'];
        $cidata['price']          = $data['product_price'];
        $cidata['total']          = $data['product_total'];
        $this->db->insert('cart_items',$cidata);

        $cdata['user_id']        = $uId;
        $cdata['vendor_id']      = $data['location'];
        $cdata['amount']         = $data['total_amount'];
        $cdata['delivery_fee']   = $data['total_delivery_fee'];
        $cdata['discount']       = $data['total_discount'];
        $cdata['g_total']        = $data['grand_total'];

        $this->db->where('cart_id',$insert_id)->update('cart',$cdata);
       
        $result['status']  = 'success';
        $result['message'] = 'Product added successfully';
        $result['data']['location']       = $cdata['vendor_id'];
        $result['data']['ptoduct_id']     = $cidata['product_id'];
        $result['data']['product_name']   = $cidata['product_name'];
        $result['data']['product_qty']    = $cidata['qty'];
        $result['data']['product_price']  = $cidata['price'];
        $result['data']['product_total']  = $cidata['total'];
        $result['data']['total_amount']   = $cdata['amount'];
        $result['data']['delivery_fee']   = $cdata['delivery_fee'];
        $result['data']['total_discount'] = $cdata['discount'];
        $result['data']['grand_total']    = $cdata['g_total'];
        return $result;
    }

      //Add cart
    public function update_cart($uId,$data)
    {
        
        $cart = $this->db->where('cart_id',$data['cart_id'])->get('cart')->row();
        if($cart)
        {
          if($this->db->where('cart_id',$data['cart_id'])->where('product_id',$data['product_id'])->get('cart_items')->row())
            {
               $cidata['qty']    = $data['product_qty'];
               $cidata['total']  = $data['product_total'];
               $this->db->where('cart_id',$data['cart_id'])->where('product_id',$data['product_id'])->update('cart_items',$cidata);

                $cdata['amount']         = $data['total_amount'];
                $cdata['delivery_fee']   = $data['total_delivery_fee'];
                $cdata['discount']       = $data['total_discount'];
                $cdata['g_total']        = $data['grand_total'];
                $this->db->where('cart_id',$data['cart_id'])->update('cart',$cdata);

               $result['status']  = 'success';
               $result['message'] = 'Product updated successfully';
               $result['data']['product_qty']    = $cidata['qty'];
               $result['data']['product_total']  = $cidata['total'];
               $result['data']['total_amount']   = $cdata['amount'];
               $result['data']['delivery_fee']   = $cdata['delivery_fee'];
               $result['data']['total_discount'] = $cdata['discount'];
               $result['data']['grand_total']    = $cdata['g_total'];
               return $result;
            }
            else
            {

                $product_name = $this->db->where('product_id',$data['product_id'])->get('product')->row()->title;
                $cidata['cart_id']        = $data['cart_id'];  
                $cidata['product_id']     = $data['product_id']; 
                $cidata['product_name']   = $product_name;
                $cidata['qty']            = $data['product_qty'];
                $cidata['price']          = $data['product_price'];
                $cidata['total']          = $data['product_total'];  
                $this->db->insert('cart_items',$cidata);

                $cdata['amount']         = $data['total_amount'];
                $cdata['discount']       = $data['total_discount'];
                $cdata['delivery_fee']   = $data['total_delivery_fee'];
                $cdata['g_total']        = $data['grand_total'];
                $this->db->where('cart_id',$data['cart_id'])->update('cart',$cdata);

                $result['status']  = 'success';
                $result['message'] = 'Product added successfully';
                $result['data']['cart_id']        = $cidata['cart_id'];
                $result['data']['ptoduct_id']     = $cidata['product_id'];
                $result['data']['product_name']   = $cidata['product_name'];
                $result['data']['product_qty']    = $cidata['qty'];
                $result['data']['product_price']  = $cidata['price'];
                $result['data']['product_total']  = $cidata['total'];
                $result['data']['total_amount']   = $cdata['amount'];
                $result['data']['delivery_fee']   = $cdata['delivery_fee'];
                $result['data']['total_discount'] = $cdata['discount'];
                $result['data']['grand_total']    = $cdata['g_total'];
                return $result;
          }
      }
      else
      {
        $result['status']  = 'error';
        $result['message'] = 'Cart not found';
        return $result;
      }
    }

     //Delete cart
    public function delete_cart($uId,$data)
    {
        $product = $this->db->where('product_id',$data['product_id'])->where('cart_id',$data['cart_id'])->get('cart_items')->row();
        if($product)
        {
          $this->db->where('product_id',$data['product_id'])->where('cart_id',$data['cart_id'])->delete('cart_items');
          $cdata['amount']         = $data['total_amount'];
          $cdata['delivery_fee']   = $data['total_delivery_fee'];
          $cdata['discount']       = $data['total_discount'];
          $cdata['g_total']        = $data['grand_total'];
          $this->db->where('cart_id',$data['cart_id'])->update('cart',$cdata);

          $result['status']        = 'success';
          $result['message']       = 'Product deleted successfully';
          $rdata['total_amount']   = $cdata['amount'];
          $rdata['delivery_fee']   = $cdata['delivery_fee'];
          $rdata['total_discount'] = $cdata['discount'];  
          $rdata['grand_total']    = $cdata['g_total']; 
          $result['data']          = $rdata;
          return $result;
        } 
        else
        {
          $result['status']  = 'error';
          $result['message'] = 'Product not found';
          return $result;
        }
      
    }

     //Empty cart
    public function empty_cart($uId,$data)
    {
        $cart = $this->db->where('cart_id',$data['cart_id'])->get('cart')->row();
        if($cart)
        {
         $this->db->where('cart_id',$data['cart_id'])->delete('cart_items');

         $ndata['amount'] = $ndata['delivery_fee'] = $ndata['discount'] = $ndata['g_total'] = '';

         $this->db->where('cart_id',$data['cart_id'])->update('cart',$ndata);
          $result['status']        = 'success';
          $result['message']       = 'Cart cleared successfully';
          return $result;
        }
        else
        {
          $result['status']  = 'error';
          $result['message'] = 'Cart not found';
          return $result;
        }
      
    }
}
?>