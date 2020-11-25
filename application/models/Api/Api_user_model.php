<?php

class Api_user_model extends CI_Model 
{
    function __construct()  
    { 
    	parent::__construct();
    	$this->load->helper('string');
      $this->load->model('Api/Basic_model','Basic_model');
        
    }
   
    //User Registration
    public function register($data)
    {
        $acess_token            = rand(100000,999999);        
        $Udata['username']      = $data['name'];
        $Udata['email']         = $data['email'];
        $Udata['c_code']        = $data['c_code'];
        $Udata['mobile']        = $data['mobile'];
        $Udata['creation_date']  = time();
        $Udata['is_login']      = 1;
        $Udata['password']      = md5($data['password']);
        $Udata['access_token']  = $acess_token;
        $Udata['status']        = 'approved';
        $insertDatas = $this->db->insert('user',$Udata);
        if($insertDatas)
        {
        $result['httpcode']         =  200;
        $result['status']       = 'success';
        $result['message']      = 'Registered Successfully';
        $result['data']['access_token'] = $acess_token;
        $result['data']['name']         = $Udata['username'];
        $result['data']['email']        = $Udata['email'];
        $result['data']['mobile']       = $Udata['mobile'];
        $result['data']['redirect']     = 'Dashboard';
        return $result;
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
      //    $otp = rand(1000, 9999);
            $otp = 1234;
          $data['mobile'] = $mobileno;
          $data['otp'] = $otp; 
    //      $this->functions->sendOtp((int)$mobileno,$otp);
          $this->db->insert('otp_verification',$data);
          $r['httpcode']       =   200;
          $r['status']     = 'success';
          $r['message']    = 'OTP sent to your mobile number';
          $r['data']['otp']=$otp;
          return $r;
        }
        
    //Verify OTP
    public function verify_otp($data)
        {
            $errors = array();
            $user = $this->db->where('mobile',$data['c_code'].$data['mobile'])->get('otp_verification'); 
            if($user->num_rows() > 0)
            {
                $user_data = $user->row();
                if($user_data->otp==$data['otp'])
                {
                    $acess_token =   $user_data->id.rand(100000,999999);//.rand(1000,9999);
                    // $userData    =   ['otp'=>NULL];
                    // $this->db->where('mobile',$data['mobile'])->update('otp_verification',$userData);
                    $this->db->where('mobile',$data['mobile'])->delete('otp_verification');
                    $reg_user = $this->db->where(['c_code'=>$data['c_code'],'mobile'=>$data['mobile']])->get('user')->row(); 
                    if($reg_user){
                        if($reg_user->status == 'approved'){
                            $this->db->set(array('access_token'=>$acess_token,'is_login'=>1))->where('mobile',$data['mobile'])->update('user');
                            $r['httpcode']          =   200;
                            $r['status']            =  'success';
                            $r['user_status']       =  'verified';
                            $r['message']           = 'OTP verified successfully! Login Successfully!';
                            $r['data']['access_token']  = $acess_token;
                            $r['data']['username']      = $reg_user->username;
                            $r['data']['email']         = $reg_user->email;
                            $r['data']['mobile']        = $reg_user->mobile;
                            $r['data']['redirect']      = 'Dashboard';
                            return $r;
                        }else{
                            $erMsg  =   'Your account has been diabled. Please contact admin.';
                            return ['httpcode'=>400,'status'=>'error','message'=>$erMsg,'data'=>['account_disabled'=>$erMsg]];
                        }
                    }
                    else
                    {
                        $r['httpcode']          =   200;
                        $r['status']            =  'success';
                        $r['user_status']       =  'register';
                        $r['message']           = 'OTP verified successfully! Please register your account.';
                        $r['data']['mobile']    =   $data['mobile'];
                        $r['data']['redirect']  =  'Registeration';
                        return $r;
                    }
                }
                else
                {
                   $errors['incorrect_otp'] = 'The OTP entered is incorrect. Please try again or try resend the OTP.';
                   $r['httpcode']           =   400;
                   $r['status']             =  'error';
                   $r['message']            = reset($errors);
                   $r['data']               =  $errors;
                   return $r;
              
                }
            }
            else
            { 
                $errors['wrong_mobile'] =  'We cannot find a user with that phone number.';
                $r['httpcode']          =   400;
                $r['status']            =  'error';
                $r['message']           =  reset($errors);
                $r['data']              =  $errors;
                return $r;
            }
        
        }
        
    //profile update
    public function updateprofile($uid,$data)
    {
   
      $udata['username']      =   $data['username'];    
      $udata['address1']      =   $data['address1'];
      $udata['address2']      =   $data['address2'];
      $udata['zip']           =   $data['post'];
      $udata['state']         =   $data['state'];
      $udata['mobile']        =   $data['mobile'];  
      $udata['email']         =   $data['email']; 
      $udata['district']      =   $data['district']; 
      $update = $this->db->where('user_id',$uid)->update('user',$udata);

      // if($_FILES['profile_pic']['tmp_name'])
       //  {
       //    $this->crud_model->file_up("profile_pic", "user", $uid, '', '', '.png'); 
       //  }
        $profilepic = $data['profile_pic'];
        if($profilepic)
           {
             define('UPLOAD_DIR', 'uploads/user_image/');
             $decoded=base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$profilepic));
             $file = UPLOAD_DIR .'user_'.$uid.'.png';
             file_put_contents($file,$decoded);
           }

          if($update)
          {
           $result['httpcode']        =   200;
           $result['status']          = 'success';
           $result['message']         = 'Profile updated successfully';
           $result['data']['redirect']= 'profile';
           return $result;
            }
    }
    
    //profile update for andriod
    public function updateprofiledata($uid,$data)
    {
      $udata['username']      =   $data['username'];    
      $udata['address1']      =   $data['address1'];
      $udata['address2']      =   $data['address2'];
      $udata['zip']           =   $data['post'];
      $udata['state']         =   $data['state'];
      $udata['mobile']        =   $data['mobile'];  
      $udata['email']         =   $data['email']; 
      $udata['district']      =   $data['district']; 
      $update = $this->db->where('user_id',$uid)->update('user',$udata);

       if($_FILES['profile_pic']['tmp_name'])
        {
          $this->crud_model->file_up("profile_pic", "user", $uid, '', '', '.png'); 
        }    
        if($update)
        {
           $result['httpcode']    =   200;
           $result['status']  = 'success';
           $result['message'] = 'profile updated';
           $result['data']['action']= 'profile';
           return $result;
        }
    }
    
    //Request for service
    public function requestService($data)
    {
        $Udata['service_category']  = $data['service_category'];
        $Udata['service_type']      = $data['service_type'];
        $Udata['name']              = $data['name'];
        $Udata['address']           = $data['address'];
        $Udata['city']              = $data['city'];
        $Udata['country']           = $data['country'];
        $Udata['email']             = $data['email'];
        $Udata['mobile']            = $data['mobile'];
        $Udata['date']              = date('Y-m-d', strtotime($data['date'])); 
        $Udata['time']              = date("H:i", strtotime($data['time']));
        $Udata['remark']            = $data['remark'];
        $Udata['type_detail']       = $data['type_detail'];
        $insertDatas = $this->db->insert('request_service',$Udata);
       
        if($insertDatas)
        {
            $result['httpcode']             =   200;
            $result['status']               = 'success';
            $result['message']              = 'Service request sent successfully';
            return $result;
        }
    }

        //Request for demo
    public function requestDemo($data)
    {
        $Udata['name']         = $data['name'];
        $Udata['product_id']   = $data['product_id'];
        $Udata['city']         = $data['city']; 
        $Udata['country']      = $data['country'];
        $Udata['email']        = $data['email'];
        $Udata['mobile']       = $data['mobile'];
        $Udata['date']         = date('Y-m-d', strtotime($data['date'])); 
        $Udata['time']         = date("H:i", strtotime($data['time']));
        $Udata['remarks']      = $data['remarks'];

        $insertDatas = $this->db->insert('request_demo',$Udata);
       if($insertDatas)
       {
        $result['httpcode']                 =   200;
        $result['status']               = 'success';
        $result['message']              = 'Demo request sent successfully';
        // $result['data']['name']         = $Udata['name'];
        // $result['data']['address']      = $Udata['address'];
        // $result['data']['city']         = $Udata['city'];
        // $result['data']['country']      = $Udata['country'];
        // $result['data']['email']        = $Udata['email'];
        // $result['data']['mobile']       = $Udata['mobile'];
        // $result['data']['date']         = $Udata['date'];
        // $result['data']['time']         = $Udata['time'];
        // $result['data']['req_demo']     = $Udata['req_demo'];
        return $result;
       }
    }

    //Add cart
    public function add_cart($uId,$data)
    {
         $exist = $this->db->where('user_id',$uId)->get('cart')->row(); 
         if($exist)
         {
           $prd_exist = $this->db->where('cart_id',$exist->cart_id)->where('product_id',$data['product_id'])->get('cart_items')->row();
           if($prd_exist)
           {
               $qty = ($prd_exist->qty + 1);
               $vendor_price = $this->db->where('vendor_id',$exist->vendor_id)->where('prd_id',$data['product_id'])->get('vendor_prices')->row()->price; 
                  if($vendor_price == NULL)
                    {
                      $price             = 0;
                    }
                    else
                    {
                         $price           =  $vendor_price;
                    }
               $total  = ($qty * $price);
               $c_i_data['price']  = $price;
               $c_i_data['qty']    = $qty;
               $c_i_data['total']  = $total; 
               $this->db->where('cart_id',$exist->cart_id)->where('product_id',$data['product_id'])->update('cart_items',$c_i_data);
                $sum = $this->db->select_sum('total')->get_where('cart_items',array('cart_id'=>$exist->cart_id))->row()->total; 

                $c_data['amount']         = $sum;
                $c_data['delivery_fee']   = 0;
                $c_data['discount']       = 0;
                $c_data['g_total']        = $sum;
                $this->db->where('cart_id',$exist->cart_id)->update('cart',$c_data);

               $result['httpcode']               =   200;
               $result['status']                 = 'success';
               $result['message']                = 'Product updated successfully';
               $result['data']['product_qty']    = $c_i_data['qty'];
               $result['data']['product_total']  = (string) $c_i_data['total'];
               $result['data']['total_amount']   = $c_data['amount'];
               $result['data']['grand_total']    = $c_data['g_total'];
               return $result;
           }
           else
           {
             $product_name = $this->db->where('product_id',$data['product_id'])->get('product')->row()->title;
             if($exist->vendor_id != 0)
             {
                $vId = $exist->vendor_id;
             }
             else
             {
               $country_id = $this->db->where('sortname',$data['country_code'])->get('countries')->row()->id; 
                $vId  = $this->db->where('country_code',$country_id)->get('vendor')->row()->vendor_id;
             }
                $vendor_price = $this->db->where('vendor_id',$vId)->where('prd_id',$data['product_id'])->get('vendor_prices')->row()->price; 
                  if($vendor_price == NULL)
                    {
                      $price             = 0;
                    }
                    else
                    {
                         $price           =  $vendor_price;
                    }
                $qty                      = $data['product_qty'];
                // $prd_total                = ($qty * $price);
                $cartdata['cart_id']        = $exist->cart_id;  
                $cartdata['product_id']     = $data['product_id']; 
                $cartdata['product_name']   = $product_name;
                $cartdata['qty']            = 1;
                $cartdata['price']          = $price;
                $cartdata['total']          = $price;  
                $this->db->insert('cart_items',$cartdata);

                $totsum = $this->db->select_sum('total')->get_where('cart_items',array('cart_id'=>$exist->cart_id))->row()->total; 
                if($exist->vendor_id == 0)
                {
                  $country_id = $this->db->where('sortname',$data['country_code'])->get('countries')->row()->id; 
                  $veId  = $this->db->where('country_code',$country_id)->get('vendor')->row()->vendor_id;
                  $ca_data['vendor_id']         = $veId;
                }
                $ca_data['amount']         = $totsum;
                $ca_data['discount']       = 0;
                $ca_data['delivery_fee']   = 0;
                $ca_data['g_total']        = $totsum;
                $this->db->where('cart_id',$exist->cart_id)->update('cart',$ca_data);

                $result['httpcode']               =   200;
                $result['status']                 = 'success';
                $result['message']                = 'Product added successfully';
                $result['data']['cart_id']        = $cartdata['cart_id'];
                $result['data']['ptoduct_id']     = $cartdata['product_id'];
                $result['data']['product_name']   = $cartdata['product_name'];
                $result['data']['product_qty']    = $cartdata['qty'];
                $result['data']['product_price']  = (string) $cartdata['price'];
                $result['data']['product_total']  = (string) $cartdata['total'];
                $result['data']['total_amount']   = $ca_data['amount'];
                $result['data']['grand_total']    = $ca_data['g_total'];

                      $prdId = $data['product_id'];
              if($this->db->get_where('cart_added_items',['user_id'=>$uId,'prd_id'=>$prdId,'status'=>1])->num_rows() > 0)
              {
                  $this->db->where(['user_id'=>$uId,'prd_id'=>$prdId,'status'=>1])->update('cart_added_items',['removed'=>0]);
              }
              else
              {
                $this->db->insert('cart_added_items',['user_id'=>$uId,'prd_id'=>$prdId,'added_on'=>date('Y-m-d H:i:s')]);  
              }
              
              $this->db->insert('cart_added_items_log',['user_id'=>$uId,'prd_id'=>$prdId,'added_on'=>date('Y-m-d H:i:s')]); 

                return $result;
           }
          }
          else
          {
         $country_id = $this->db->where('sortname',$data['country_code'])->get('countries')->row()->id; 
        $vendor_id  = $this->db->where('country_code',$country_id)->get('vendor')->row()->vendor_id; 
        if($vendor_id)
        {
          $ndata['user_id'] = $ndata['vendor_id'] = $ndata['amount'] = $ndata['discount'] = $ndata['g_total'] = '';
        $this->db->insert('cart',$ndata);
        $insert_id = $this->db->insert_id(); 
        $product_data = $this->db->where('product_id',$data['product_id'])->get('product')->row();
        $vendor_price = $this->db->where('vendor_id',$vendor_id)->where('prd_id',$data['product_id'])->get('vendor_prices')->row()->price; 
        if($vendor_price == NULL)
        {
           $price             =       0;
        }
        else
        {
             $price          =       $vendor_price;
        }

        $cidata['cart_id']        = $insert_id;
        $cidata['product_id']     = $data['product_id'];
        $cidata['product_name']   = $product_data->title;
        $cidata['qty']            = 1;
        $cidata['price']          = $price;
        $cidata['total']          = $price;
        $this->db->insert('cart_items',$cidata);

        $cdata['user_id']        = $uId;
        $cdata['vendor_id']      = $vendor_id;
        $cdata['amount']         = $price;
        $cdata['delivery_fee']   = 0;
        $cdata['discount']       = 0;
        $cdata['g_total']        = $price;

        $this->db->where('cart_id',$insert_id)->update('cart',$cdata);
       
        $result['httpcode']               =   200;
        $result['status']                 = 'success';
        $result['message']                = 'Product added successfully';
        $result['data']['cart_id']        = $insert_id;
        $result['data']['vendor_id']      = $cdata['vendor_id'];
        $result['data']['ptoduct_id']     = $cidata['product_id'];
        $result['data']['product_name']   = $cidata['product_name'];
        $result['data']['product_qty']    = (string) $cidata['qty'];
        $result['data']['product_price']  = (string) $cidata['price'];
        $result['data']['product_total']  = (string) $cidata['total'];
        $result['data']['total_amount']   = (string) $cdata['amount'];
        // $result['data']['delivery_fee']   = $cdata['delivery_fee'];
        // $result['data']['total_discount'] = $cdata['discount'];
        $result['data']['grand_total']    = (string) $cdata['g_total'];
        
        $prdId = $data['product_id'];
        if($this->db->get_where('cart_added_items',['user_id'=>$uId,'prd_id'=>$prdId,'status'=>1])->num_rows() > 0)
        {
            $this->db->where(['user_id'=>$uId,'prd_id'=>$prdId,'status'=>1])->update('cart_added_items',['removed'=>0]);
        }
        else
        {
          $this->db->insert('cart_added_items',['user_id'=>$uId,'prd_id'=>$prdId,'added_on'=>date('Y-m-d H:i:s')]);  
        }

        $this->db->insert('cart_added_items_log',['user_id'=>$uId,'prd_id'=>$prdId,'added_on'=>date('Y-m-d H:i:s')]); 
        
        return $result;
          }
          else
          {
                $result['httpcode']               =   400;
                $result['status']                 = 'error';
                $result['message']                = 'warehouse not found';
                return $result;
          }
        }
    }

      //Add cart
    public function update_cart($uId,$data)
    {
        
        $cart = $this->db->where('cart_id',$data['cart_id'])->get('cart')->row();
        if($cart)
        {
          $prd_exist = $this->db->where('cart_id',$data['cart_id'])->where('product_id',$data['product_id'])->get('cart_items')->row();
         
          if($prd_exist)
            {  
               $qty = $data['product_qty'];
               $price = $prd_exist->price; 
               $total  = ($qty * $price);
               $cidata['qty']    = $qty;
               $cidata['total']  = $total; 
               $this->db->where('cart_id',$data['cart_id'])->where('product_id',$data['product_id'])->update('cart_items',$cidata);
                $sum = $this->db->select_sum('total')->get_where('cart_items',array('cart_id'=>$data['cart_id']))->row()->total; 

                $cdata['amount']         = $sum;
                $cdata['delivery_fee']   = 0;
                $cdata['discount']       = 0;
                $cdata['g_total']        = $sum;
                $this->db->where('cart_id',$data['cart_id'])->update('cart',$cdata);

               $result['httpcode']               =   200;
               $result['status']                 = 'success';
               $result['message']                = 'Product updated successfully';
               $result['data']['product_qty']    = $cidata['qty'];
               $result['data']['product_total']  = (string) $cidata['total'];
               $result['data']['total_amount']   = $cdata['amount'];
               $result['data']['grand_total']    = $cdata['g_total'];
               return $result;
            }
            else
            {
               $result['httpcode']     =   400;
               $result['status']       = 'error';
               $result['message']      = 'Product not found';
               return $result;
          }
      }
      else
      {
        $result['httpcode']    =   400;
        $result['status']      = 'error';
        $result['message']     = 'Cart not found';
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

          $totsum = $this->db->select_sum('total')->get_where('cart_items',array('cart_id'=>$data['cart_id']))->row()->total;

          $cdata['amount']         = $totsum;
          $cdata['g_total']        = $totsum;
          $this->db->where('cart_id',$data['cart_id'])->update('cart',$cdata);

          $result['httpcode']          =  200;
          $result['status']        = 'success';
          $result['message']       = 'Product removed successfully';
          $rdata['total_amount']   = $cdata['amount'];
          // $rdata['delivery_fee']   = $cdata['delivery_fee'];
          // $rdata['total_discount'] = $cdata['discount'];  
          $rdata['grand_total']    = $cdata['g_total']; 
          $result['data']          = $rdata;
          $prdId = $data['product_id'];
          $this->db->where(['user_id'=>$uId,'prd_id'=>$prdId,'status'=>1])->update('cart_added_items',['removed'=>1,'removed_on'=>date('Y-m-d H:i:s')]);
          $this->db->where(['user_id'=>$uId,'prd_id'=>$prdId,'status'=>1])->update('cart_added_items_log',['removed_on'=>date('Y-m-d H:i:s')]);
          return $result;
        } 
        else
        {
          $result['httpcode']    =  400;
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

         $ndata['amount'] = $ndata['delivery_fee'] = $ndata['tax'] = $ndata['discount'] = $ndata['g_total'] = '';

         $this->db->where('cart_id',$data['cart_id'])->update('cart',$ndata);
         
        $this->db->where(['user_id'=>$uId,'removed'=>0,'status'=>1])->update('cart_added_items',['removed_on'=>date('Y-m-d H:i:s'),'removed'=>1]);
        $this->db->where(['user_id'=>$uId,'status'=>1])->update('cart_added_items_log',['removed_on'=>date('Y-m-d H:i:s')]);

          $result['httpcode']          =   200;
          $result['status']        = 'success';
          $result['message']       = 'Cart cleared successfully';
          return $result;
        }
        else
        {
          $result['httpcode']    =   400;
          $result['status']  = 'error';
          $result['message'] = 'Cart not found';
          return $result;
        }
    }

     //Clear cart
    public function clear_cart($uId,$data)
    {
        $cart = $this->db->where('cart_id',$data['cart_id'])->get('cart')->row();
        if($cart)
        {
         $this->db->where('cart_id',$data['cart_id'])->delete('cart_items');

         $ndata['amount'] = $ndata['tax'] = $ndata['g_total'] = '';
         $ndata['delivery_fee'] = $ndata['discount'] = '0.00';
         $ndata['vendor_id']='0';

         $this->db->where('cart_id',$data['cart_id'])->update('cart',$ndata);
         
        $this->db->where(['user_id'=>$uId,'removed'=>0,'status'=>1])->update('cart_added_items',['removed_on'=>date('Y-m-d H:i:s'),'removed'=>1]);
        $this->db->where(['user_id'=>$uId,'status'=>1])->update('cart_added_items_log',['removed_on'=>date('Y-m-d H:i:s')]);

          $result['httpcode']          =   200;
          $result['status']        = 'success';
          $result['message']       = 'Cart cleared successfully';
          return $result;
        }
        else
        {
          $result['httpcode']    =   400;
          $result['status']      =  'error';
          $result['message']     =  'Not yet you didnot add any item';
          return $result;
        }
    }
    
    //address add
    public function address($uid,$data)
    {
        $Udata['user_id']        = $uid;
        $Udata['fname']          = $data['name'];
        $Udata['address_label']  = $data['address_type'];
        $Udata['address1']       = $data['house_flat'];
        $Udata['road_name']      = $data['road_name'];
        $Udata['zip']            = $data['zipcode'];
        $Udata['landmark']       = $data['landmark'];
        $Udata['city']           = $data['city'];
        $Udata['country']        = $data['country_code'];
        $exist = $this->db->where('user_id',$uid)->where('status',1)->get('user_address')->row();
        if($exist)
        { 
           $default = $data['default']; 
           if($default == 1)
            {
              $aaa = $this->db->set('default_addr',0)->where('user_id',$uid)->where('default_addr',1)->where('status',1)->update('user_address'); 
              $Udata['default_addr']   = 1;
            }
            else
            {
              $Udata['default_addr']   = 0;
            }
        }
        else
        {
           $Udata['default_addr']   = 1;
        }
        $insertDatas = $this->db->insert('user_address',$Udata);
       
        if($insertDatas)
        {
            $result['httpcode']             =   200;
            $result['status']               = 'success';
            $result['message']              = 'Address saved successfully';
            return $result;
        }
    }
    
    //address add
    public function address_edit($uid,$data)
    { 
        $Udata['user_id']        = $uid;
        $Udata['fname']          = $data['name'];
        $Udata['address_label']  = $data['address_type'];
        $Udata['address1']       = $data['house_flat'];
        $Udata['road_name']      = $data['road_name'];
        $Udata['zip']            = $data['zipcode'];
        $Udata['landmark']       = $data['landmark'];
        $Udata['city']           = $data['city'];
        $Udata['country']        = $data['country_code'];
        $default = $data['default']; 
        if($default == 1)
        {
          $aaa = $this->db->set('default_addr',0)->where('user_id',$uid)->where('default_addr',1)->where('status',1)->update('user_address'); 
          $Udata['default_addr']   = 1;
        }
        else
        {
          $Udata['default_addr']   = 0;
        }

        $updateDatas = $this->db->where('adrs_id',$data['address_id'])->update('user_address',$Udata);
       
        if($updateDatas)
        {
            $result['httpcode']             =   200;
            $result['status']               = 'success';
            $result['message']              = 'Address updated successfully';
            return $result;
        }
    }

     //Delivery fee based on shipping address
    public function delivery_fee($uId,$data)
    {
        $cart = $this->db->where('user_id',$uId)->get('cart')->row();
        if($cart)
        {
         $vendorId = $cart->vendor_id;
         $contry_id = $this->db->where('vendor_id',$vendorId)->get('vendor')->row()->country_code;
         $Curency   = $this->db->where('id',$contry_id)->get('countries')->row()->currency;
         $cart_items = $this->db->where('cart_id',$cart->cart_id)->get('cart_items')->result_array();
         $result['httpcode']      =  200;
         $result['status']        = 'success';
         $result['message']       = 'Delivery Fee';
         if($cart_items)
         {
              foreach ($cart_items as $cart_item) 
                { 
                  $product_weight = $this->db->where('product_id',$cart_item['product_id'])->get('product')->row()->weight;
                   $prd_qty = $cart_item['qty'];
                  $weight = ($product_weight * $prd_qty);  
                  $all_prd_weight += $weight; 
                }
                $ship_cost =$this->db
                ->where('operator_id',$data['operator_id'])
                ->where('country_id',$contry_id)
                 ->where('min_weight <=',$all_prd_weight)
                 ->where('max_weight >=',$all_prd_weight)
                ->get('shipping_zones')->row(); 
                 $Date = date('Y-m-d'); 
                $days = $ship_cost->max_days;
                $delivery_date = date('Y-m-d', strtotime($Date. ' + '.$days.' days -1 day'));
                if($ship_cost)
                {
                   $deliver_fee            = $ship_cost->cost;
                   $tot_amount             = ($cart->amount + $deliver_fee);
                   $rdata['total_weight'] = $all_prd_weight;
                   $rdata['price']        = $cart->amount;
                   $rdata['delivery_fee'] = $deliver_fee;
                   $rdata['sub_total']    = (string) $tot_amount;
                   $rdata['total_amount'] = (string) $tot_amount;
                   $rdata['currency']     = $Curency;
                   $rdata['delivery_exp_date'] = $delivery_date;
                   $result['data']        = $rdata;
                }
                else
                { 
                    // $rdata = array();
                    $result['httpcode']      =  400;
                    $result['status']        = 'error';
                    $result['message']       = 'Total weight of shipment exceeds the maximum limit allowed in your area.';
                    $result['data']['total_weight'] = $all_prd_weight;
                    // $result['delivery_fee'] = $rdata;
                }
        }
        else
        {
            $result['httpcode']   = 400;
            $result['status']     = 'error';
            $result['message']    = 'Items not found';
        }
       
        }
        else
        {
            $result['httpcode']   = 400;
            $result['status']     = 'error';
            $result['message']    = 'Cart not found';
        }
       return $result;
    }
    //Payment
    public function payment($uid,$data)
    { 
        $r = array();
       
         

        $cart = $this->db->where('user_id',$uid)->get('cart')->row();
        $user_data = $this->db->where('user_id',$uid)->get('user')->row();
        $cart_items =  $this->db->where('cart_id',$cart->cart_id)->get('cart_items')->result();
        $zone_id = $this->db->where('vendor_id',$cart->vendor_id)->get('vendor')->row()->country_code;
        $ship_det = $this->db->where('country_id',$zone_id)->where('operator_id',$data['operator_id'])->get('shipping_zones')->row();
         $product_array = array();
        $shipping_array = array();
        $payment_array = array();
        $delivey_array = array();
        $shipping_detail = array();
        if($cart_items)
        {
           $s_data['sale_code']  =  $s_data['buyer']  = $s_data['product_details']  = $s_data['shipping_address'] = $s_data['shipping_detail']  = $s_data['shipping']  = $s_data['payment_type']  = $s_data['payment_status']  = $s_data['total_amount']  = $s_data['discount']  =  $s_data['grand_total']  =  $s_data['delivary_datetime']  =  $s_data['delivery_status']  =  '';
           $this->db->insert('sale',$s_data);  
           $sale_id = $this->db->insert_id();
           foreach ($cart_items as $items) 
           {
             if ($this->Basic_model->file_view('product',$items->product_id,'','','thumb','src','multi','one'))
              {
                  $path     =       $this->Basic_model->file_view('product',$items->product_id,'','','thumb','src','multi','one');
              }
              else
              {
                  $path     =       base_url("uploads/product_image/default_product_thumb.jpg");
              } 
           $product_array[]  = array(
          'id'=>$items->product_id,
          'qty'=>$items->qty,
          'option'=>'',
          'price'=>$items->price,
          'name'=>$items->product_name,
          'shipping'=> 0,
          'tax'=> 0,
          'image'=>$path,
          'coupon'=>'',
          'shippingtax'=>'',
          'coupon_discount'=>'',
          'rowid'=>'',
          'subtotal'=>$items->total); 
          }
        
         $shipping_array  = array(
          'firstname'=>$data['name'],
          'lastname'=>'',
          'email'=> $user_data->email,
          'address_type'=>$data['address_type'],
          'mobile'=>$user_data->mobile,
          'address1'=>$data['housename'],
          'address2'=>$data['roadname'],
          'address3'=>$data['landmark'],
          'country'=>$data['country'],
          'state'=>$user_data->state_code,
          'city'=>$data['city'],
          'zip'=>$data['pincode'],
          's_firstname'=>$user_data->username,
          's_lastname'=>$user_data->surname,
          's_email'=>$user_data->email,
          's_address_type'=>$data['address_type'],
          's_mobile'=>$user_data->mobile,
          's_address1'=>$data['housename'],
          's_address2'=>$data['roadname'],
          's_address3'=>$data['landmark'],
          's_country'=>$data['country'],
          's_state'=>$user_data->state_code,
          's_city'=>$data['city'],
          's_zip'=>$data['pincode'],
          'ventotal_80'=>'',
          'payment_type'=>$data['payment_method']
        ); 
        $Date = date('Y-m-d'); 
        $days = $ship_det->max_days;
         $shipping_detail  = array(
          'operator_id'=>$data['operator_id'],
          'zone_id'=>$ship_det->id,
          'delivery_from'=>$ship_det->min_days,
          'delivery_to'=>$ship_det->max_days,
          'shipping_fee'=>$ship_det->cost,
          'expected_date'=>date('Y-m-d', strtotime($Date. ' + '.$days.' days -1 day')) 
         );
        
        $payment_array[]  = array('vendor'=>$cart->vendor_id,'status'=>$data['payment_status']);
        $grand = ($ship_det->cost + $cart->g_total);

        $saledata['sale_code']              = date('ymd').substr(sprintf("%04d", $sale_id),-2);       
        $saledata['buyer']                  = $uid;
        $saledata['product_details']        = json_encode($product_array);
        $saledata['vendor_id']              = $cart->vendor_id;
        $saledata['shipping_address']       = json_encode($shipping_array);
        $saledata['shipping_detail']        = json_encode($shipping_detail);
        $saledata['shipping']               = $ship_det->cost;
        $saledata['payment_type']           = $data['payment_method'];
        $saledata['payment_status']         = json_encode($payment_array);
        $saledata['total_amount']           = $cart->g_total;
        $saledata['grand_total']            =  $grand;  
         $saledata['delivery_status']        = 'pending';
       
        $insertDatas = $this->db->where('sale_id',$sale_id)->update('sale',$saledata);
        if($insertDatas)
        {
        $this->db->where('cart_id',$cart->cart_id)->delete('cart_items');
         $ndata['amount'] = $ndata['tax'] = $ndata['g_total'] = '';
         $ndata['delivery_fee'] = $ndata['discount'] = '0.00';
         $this->db->where('cart_id',$cart->cart_id)->update('cart',$ndata);
         $this->db->where('user_id',$uid)->delete('cart_added_items');
         $this->db->where('user_id',$uid)->delete('cart_added_items_log');
        $result['httpcode']         =  200;
        $result['status']       = 'success';
        $result['message']      = 'Payment Successfully';
        return $result;
       }
       }
       else
       {
        $result['httpcode']     =  200;
        $result['status']       = 'success';
        $result['message']      = 'No cart items';
         return $result;
       }
    }
}

?>