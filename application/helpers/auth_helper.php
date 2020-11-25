<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('validateToken')){
    function validateToken($token){ 
        $CI=& get_instance(); 
        $CI->load->database();
        $user      =   $CI->db->get_where('user', array('access_token' => $token,'status'=>'approved','is_login'=>1))->row(); 
        if($user){ return $user; }else{ return false; }
    }
}if ( ! function_exists('tokenErrorResponse')){
    function tokenErrorResponse(){ 
        $errMsg    	= 'Invalid access token';
        return ['httpcode'=>400,'status'=>'error','message'=>$errMsg,'data'=>['error'=>$errMsg,'redirect'=>'login']];
    }
}if ( ! function_exists('sms')){
    function sms(){ 
        $CI=& get_instance(); $CI->load->database(); 
        $user      =   $CI->db->get_where('business_settings', array('type' => 'sms_username','status'=>1))->row(); 
        if($user){ $res['username'] = $user->value; }else{ $res['username'] = ''; }
        $pass      =   $CI->db->get_where('business_settings', array('type' => 'sms_password','status'=>1))->row(); 
        if($pass){ $res['password'] = $pass->value; }else{ $res['password'] = ''; }
        return (object) $res;
    }
}if ( ! function_exists('ipData')){
    function ipData(){ 
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { $ip = $_SERVER['HTTP_CLIENT_IP']; } 
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){ $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];} 
        else{ $ip = $_SERVER['REMOTE_ADDR']; } 
        return @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
    }
}if(!function_exists('wh_currency')){
    function wh_currency(){ 
        $CI=& get_instance();
        if($CI->session->userdata("currency")){ return $CI->session->userdata("currency"); }
        else{  
            $currency = ipData()->geoplugin_currencyCode;
            $CI->session->set_userdata('currency',$currency); return $currency;
        }
    }
}if ( ! function_exists('wh_country')){
    function wh_country(){ 
        $CI=& get_instance();
        if($CI->session->userdata("country")){ return $CI->session->userdata("country"); }
        else{  
            $ipData     =   ipData();
            $country    =   ['name'=>$ipData->geoplugin_countryName,'code'=>$ipData->geoplugin_countryCode];
            $CI->session->set_userdata('country',(object)$country); return (object)$country;
        }
    }
}if ( ! function_exists('countries')){
    function countries(){ 
        $CI=& get_instance(); $CI->load->database();
        return $CI->db->get_where('countries',['status'=>1])->result();
    }
}


