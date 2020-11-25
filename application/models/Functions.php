<?php

class Functions extends CI_Model 
{

    function __construct() 
    {
        parent::__construct();
    }

   function getDropdownData($table,$value,$label,$placeholder='',$where=[]){
        if(count($where) > 0){ $this->db->where($where); } $query = $this->db->get($table)->result();
        $res    =   [''=>$placeholder];
        if($query){ foreach($query as $row){ $res[$row->$value] = $row->$label; } return $res; }
    }
    
    function saveData($table,$data,$id){
        if($id > 0){ $this->db->where('id',$id)->update($table,$data); $insId = $id; }
        else{ $this->db->insert($table,$data); $insId = $this->db->insert_id(); }
        return $insId;
    }
    
    function sendOtp($phone,$otp){ 
        $message            =   urlencode('[#] Vinner OTP:'.$otp);//ZFALNc+3wue
        $user               =   sms()->username;
        $pass               =   sms()->password; 
        $curl               =   curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL         => "https://api.smsglobal.com/http-api.php?action=sendsms&user=$user&password=$pass&from=Vinner&to=$phone&text=$message",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING    =>  "",
            CURLOPT_MAXREDIRS   =>  10,
            CURLOPT_TIMEOUT     =>  30,
            CURLOPT_HTTP_VERSION=>  CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST=> "GET",
        )); 
        $response               =   curl_exec($curl);
        $err                    =   curl_error($curl);
        curl_close($curl);
        if($response){ return true; }else{ return false; }
    }
}
