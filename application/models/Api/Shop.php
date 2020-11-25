<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends CI_Model{
    function __construct(){ 
        parent::__construct(); 
        $this->load->database();
        $this->load->model('crud_model');
    }
    
    function getHomeData($uid,$country_code){
        $data['logo']           =   $this->getLogo('home_top_logo');
        $data['banner_slider']  =   $this->getBannerSlider(); 
        $data['featured']       =   $this->getFeaturedProducts($country_code);
        $data['categories']     =   $this->getCategories();
        $data['profiledata']    =   $this->getProfiledata($uid);
        $data['regions']        =   $this->getCountries();
        $data['cartcount']      =   $this->getcartcount($uid);
        return $data;
    }
    
    function getLogo($type){
        $logo = $this->db->get_where('ui_settings', array('type' => $type))->row()->value;
        return base_url('uploads/logo_image/logo_' . $logo . '.png');
    }
    
     function getcartcount($uid){
         $cart = $this->db->where('user_id',$uid)->get('cart')->row();
         if($cart)
         {
         $cartId = $cart->cart_id;
         $cart_item = $this->db->order_by('cart_item_id', 'desc')->where(array('status'=>1,'cart_id'=>$cartId))->get('cart_items')->result_array();
         $count_items  =   count($cart_item); 
         $result =   $count_items;
         return $result;
         }
         else
         {
            $result = 0;
            return $result;
         }
         
    }
    
    function getBannerSlider(){
        $banners                =   $this->db->get('slides')->result();
        $data                   =   [];
        if($banners){ foreach($banners as $row){
            $image              =   base_url('uploads/slides_image/slides_'.$row->slides_id.'.jpg');
            $res['slider_id']   =   $row->slides_id; $res['slider_name'] = $row->name; $res['slider_image'] = $image;$image; $result[] =   (object)$res;
        } }else{ $result        =   null; }
        return $result;
    }
    
    function getFeaturedProducts($country_code)
    {

        $featured               =   $this->db->where(array('featured' => "ok",'status' => 'ok'))->order_by('product_id','desc')->limit(10,0)->get('product')->result();
        if($featured)
            { 
            foreach($featured as $row)
            {
            $image              =   $this->crud_model->file_view('product',$row->product_id,'','','thumb','src','multi','one');
            if($image){$prdImg  =   $image; }else{ $prdImg = base_url('uploads/product_image/default_product_thumb.jpg'); }

               $country_id = $this->db->where('sortname',$country_code)->where('status',1)->get('countries')->row()->id; 
             $vendor_id  = $this->db->where('country_code',$country_id)->get('vendor')->row()->vendor_id; 
             $vendor_price = $this->db->where('vendor_id',$vendor_id)->where('prd_id',$row->product_id)->get('vendor_prices')->row(); 

            $res['prd_id']      =   $row->product_id;
            $res['prd_name']    =   $row->title;
            $res['prd_image']   =   $prdImg;
            $res['qty']         =   $row->mpn;
            $res['unit']        =   $row->unit;
            $res['current_stock']        =        $row->current_stock;
            if($country_id)
            {
                if($vendor_id)
                {
                    if($vendor_price == NULL)
                    {
                        $res['price']            =       0;
                    }
                    else
                    {
                          $res['price']             =       $vendor_price->price;
                    }
                   $Curency  = $this->db->where('id',$country_id)->get('countries')->row()->currency;
                   $res['currency']              =       $Curency;
                }
            }
            else
            {
               $res['price']    =  "";
               $res['currency'] =  "";
            }
            $r_total =  $row->rating_total;
            $r_num = $row->rating_num;
            $rating = bcdiv($r_total, $r_num, 1);
            if($rating != NULL)
            {
              $res['rating']      =   $rating;
            }
            else
            {
              $res['rating']      =   "";
            }
            $result[]           =   (object)$res;
        }
        $result               =   $result; 
    }
    else
        { 
            $result = null; 
        }
        return $result;
    }
    
    function getCategories(){
        $query                  =   $this->db->order_by('category_id','asc')->get('category')->result();
        if($query){ foreach($query as $row){
           // $image              =   base_url('uploads/others/photo_default.png');
           if(file_exists('uploads/category_image/'.$row->image))
                  {
                      $image  =  base_url('uploads/category_image/'.$row->image);
                  }
                  else
                  {
                      $image     =       base_url("uploads/category_image/category_default.png");
                  } 
            $res['category_id'] =  $row->category_id; $res['category_name']=  $row->category_name; $res['category_image']   =   $image; $result[] =   (object)$res;
        } $result               =   $result; }else{ $result = null; }
        return $result;
    }
    
     function getProfiledata($uid){
        $query                  =   $this->db->where('user_id',$uid)->get('user')->row();
        
     if(file_exists('uploads/user_image/user_'.$uid.'.png'))
      {
          $path  =  base_url("uploads/user_image/user_".$uid.".png");
      }
      else
      {
          $path  =  base_url("uploads/user_image/default.png");
      } 
      $result['name']       = $query->username;
      $result['email']      = $query->email;
      $result['mobile']     = $query->mobile;
      $result['address1']   = ($query->address1==null)?'':$query->address1;
      $result['address2']   = ($query->address2==null)?'':$query->address2;
      $result['post']       = ($query->zip==null)?'':$query->zip;
      $result['state']      = ($query->state==null)?'':$query->state;
      $result['district']   = ($query->district==null)?'':$query->district;
      $result['image']      = $path;
        return $result;
    }
    
    function getCountries()
    {
      $data = array();
       $country  =   $this->db->where(array('status'=>1))->get('countries')->result_array();
       if($country)
       {
            foreach($country as $row)
            {
                
                $data['country_id']    =       $row['id'];
                $data['country_code']  =       $row['sortname'];
                $data['country_name']  =       $row['name'];
                $result[]       =       $data;
            }
        }
        else
        {
          $result       = null;
        }
       return $result;
    } 
            
    function do_email($msg = NULL, $sub = NULL, $to = NULL, $from = NULL)
    {
        $this->load->database();
        $system_name = $this->db->get_where('general_settings', array(
            'type' => 'system_name'
        ))->row()->value;
        if ($from == NULL)
            $from = $this->db->get_where('general_settings', array(
                'type' => 'system_email'
            ))->row()->value;
        
        
        // Always set content-type when sending HTML email
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . $system_name . '<' . $from . '>' . "\r\n";
        $headers .= "Reply-To: " . $system_name . '<' . $from . '>' . "\r\n";
        $headers .= "Return-Path: " . $system_name . '<' . $from . '>' . "\r\n";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
        $headers .= "Organization: " . $system_name . "\r\n";
		
        @mail($to, $sub, $msg, $headers, "-f " . $from);
        
        
    }
    
    function saveReview($user,$post){
        $data['user_id']        =   $user->user_id;         $data['product_id'] =   $post->product_id;
        $data['review_title']   =   $post->title;           $data['review']     =   $post->review;
        $data['rating']         =   $post->rating;          $data['review_date']=   date('Y-m-d H:i:s');
        $data['status']         =   2;
        $product                =   $this->db->get_where('product',['product_id'=>$post->product_id])->row();
        if($product){ 
           if(in_array($user->user_id, json_decode($product->rating_user))){
                return ['httpcode'=>400,'status'=>'error','message'=>'Already reviewed','data'=>['error'=>'You already reviewwd this product']];
            }else{ $this->db->insert('reviews',$data); $insId  =   $this->db->insert_id(); }
        }
        else{ return ['httpcode'=>400,'status'=>'error','message'=>'Invalid product ID','data'=>['error'=>'Invalid product ID']]; }
        if($insId){ 
            $rating_user                =   json_decode($product->rating_user); array_push($rating_user,$user->user_id);
            $prdData['rating_num']      =   ($product->rating_num+1);
            $prdData['rating_user']     =   json_encode($rating_user)   ;
            $prdData['rating_total']    =   ($product->rating_total+$post->rating);
            $this->db->where('product_id',$post->product_id)->update('product',$prdData);
            return ['httpcode'=> 200,'status'=>'success','message'=>'Review submitted','data'=>['review_id'=>$insId]]; 
        }else{ return ['httpcode'=>400,'status'=>'error','message'=>'Somthing went wrong','data'=>['error'=>'Somthing went wrong, please try after some times']]; }
    }
    
    function viewReview($user,$post){
        $review         =   $this->db->get_where('reviews',['review_id'=>$post->review_id,'user_id'=>$user->user_id])->row();
        if($review){ return ['httpcode'=> 200,'status'=>'success','message'=>'Review','data'=>['review'=>$review]]; }
        else{ return ['httpcode'=>400,'status'=>'error','message'=>'Invalid review ID','data'=>['error'=>'Invalid review ID']]; }
    }
    
    function getCurrentVersion(){
        $version    =   $this->db->get_where('app_version',['app_name'=>'vinner'])->row();
        if($version){ return ['httpcode'=> 200,'status'=>'success','message'=>'version','data'=>$version]; }
        else{ return ['httpcode'=> 400,'status'=>'error','message'=>'Invalid version','data'=>['errors' =>['version_error'=>'Invalid version']]]; }
    }
    
    
    
}