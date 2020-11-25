<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Email_model extends CI_Model
{
    

    function __construct()
    {
        parent::__construct();
    }
    
    
    function password_reset_email($account_type = '', $id = '', $pass = '')
    {
        $this->load->database();
        $system_name  = $this->db->get_where('general_settings', array( 'type' => 'system_name' ))->row()->value;
        $system_email = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
        
        $query = $this->db->get_where($account_type, array( $account_type . '_id' => $id));
        if ($query->num_rows() > 0) 
		{
            //$email_msg = "Your account type is : " . $account_type . "<br />";
            //$email_msg .= "Your password is : " . $pass . "<br />";

            $email_sub = "Password reset request";
            $from      = $system_email;
            $from_name = $system_name;
            $email_to  = $query->row()->email;
			
			if( $account_type == "user")
            {
            	$uname=$query->row()->username;
            }
            else
            {
            	$uname=$query->row()->name;
            }
			
            $page_data['email']=$email_to;
            $page_data['account_type']=$account_type;
            $page_data['pass']=$pass;
			$page_data['uname']=$uname;
            $email_msg=$this->load->view('front/email_password',$page_data,TRUE);
            
            $this->do_email($email_msg, $email_sub, $email_to, $from);
            return true;
        } 
		else 
		{
            return false;
        }
    }
	
    function status_email($account_type = '', $id = '')
    {
        $this->load->database();
        $system_name  = $this->db->get_where('general_settings', array(
            'type' => 'system_name'
        ))->row()->value;
        $system_email = $this->db->get_where('general_settings', array(
            'type' => 'system_email'
        ))->row()->value;
        
        $query = $this->db->get_where($account_type, array($account_type . '_id' => $id));
        if ($query->num_rows() > 0) 
		{
            $email_sub = "Account Status Change";
            $from      = $system_email;
            $from_name = $system_name;
            $email_to  = $query->row()->email;

            if( $account_type == "user")
            {
            	$uname=$query->row()->username;
            }
            else
            {
            	$uname=$query->row()->name;
            }
            
            $page_data['email']=$email_to;
            $page_data['account_type']=$account_type;
            $page_data['uname']=$uname;

            if($query->row()->status == 'approved')
			{
               $page_data['msg']= "Approved";
            } 
			else 
			{
                $page_data['msg']= "Postponed";
            }
            
            $email_msg=$this->load->view('front/email_status',$page_data,TRUE);
            $this->do_email($email_msg, $email_sub, $email_to, $from);
            return true;
        } 
		else 
		{
            return false;
        }
    }
    
    
    function membership_upgrade_email($vendor)
    {
        $this->load->database();
        $account_type = 'vendor';
        $system_name  = $this->db->get_where('general_settings', array(
            'type' => 'system_name'
        ))->row()->value;
        $system_email = $this->db->get_where('general_settings', array(
            'type' => 'system_email'
        ))->row()->value;
        
        $query = $this->db->get_where($account_type, array(
            $account_type . '_id' => $vendor
        ));
        if ($query->num_rows() > 0) {

            $page_data['vname']=$query->row()->display_name;
            $page_data['membership_id']=$query->row()->membership;
            if($query->row()->membership == '0')
            {
              //  $email_msg = "Your Membership Type is reduced to : Default <br />";
                $page_data['msg']= "Default";
            } 
            else
            {
               // $email_msg = "Your Membership Type is upgraded to : " . $this->db->get_where('membership',array('membership_id'=>$query->row()->membership))->row()->title . "<br />";
                $page_data['membershipt']= $this->db->get_where('membership',array('membership_id'=>$query->row()->membership))->row()->title;
                $page_data['product_limit']=$this->db->get_where('membership',array('membership_id'=>$query->row()->membership))->row()->product_limit;
            }

            $email_msg=$this->load->view('front/email_member_upgrade',$page_data,TRUE);
           


            $email_sub = "Membership Upgrade";
            $from      = $system_email;
            $from_name = $system_name;
            $email_to  = $query->row()->email;
            $this->do_email($email_msg, $email_sub, $email_to, $from);
            return true;
        } else {
            return false;
        }
    }
    
    
    function account_opening($account_type = '', $email = '', $pass = '',$approve)
    {
        $this->load->database();
        $system_name  = $this->db->get_where('general_settings', array(
            'type' => 'system_name'
        ))->row()->value;
        $system_email = $this->db->get_where('general_settings', array(
            'type' => 'system_email'
        ))->row()->value;
        
        $query = $this->db->get_where($account_type, array(
            'email' => $email
        ));
        
        if ($query->num_rows() > 0) 
		{
          
            $email_sub = "Account Opening";
            if ($account_type == 'admin') {
                $to_name = $query->row()->name;
            } elseif ($account_type == 'user') {
                $to_name = $query->row()->username;
            } elseif ($account_type == 'vendor') {
                $to_name = $query->row()->name;
            }
            $from      = $system_email;
            $from_name = $system_name;
            $email_to  = $email;
            /*$logo      = $this->crud_model->logo('home_top_logo');
            $apple= base_url()."uploads/others/iphone.png"; */
            $page_data['email']=$email_to;
            $page_data['account_type']=$account_type;
            $page_data['fname']=$to_name;
			$page_data['pass']=$pass;
			
            $email_msg=$this->load->view('front/welcome_email',$page_data,TRUE);
            
            
            $this->do_email($email_msg, $email_sub, $email_to, $from);
            return true;
        } else {
            return false;
        }
    }
    
    function newsletter($title = '', $text = '', $email = '', $from = '')
    {
        $this->do_email($text, $title, $email, $from);
    }
    
    
	//admin approve vendor
	function vendor_active($account_type = 'vendor', $id = '')
	{
		$this->load->database();
        $system_name  = $this->db->get_where('general_settings', array('type' => 'system_name' ))->row()->value;
        $system_email = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
        
        $query = $this->db->get_where($account_type, array($account_type . '_id' => $id));
        if ($query->num_rows() > 0) 
		{
            $email_sub = "Welcome Seller";
            $from      = $system_email;
            $from_name = $system_name;
            $email_to  = $query->row()->email;

            if( $account_type == "user")
            {
            	$uname=$query->row()->username;
            }
            else
            {
            	$uname=$query->row()->name;
            }
            
            $page_data['email']=$email_to;
            $page_data['account_type']=$account_type;
            $page_data['uname']=$uname;

            if($query->row()->status == 'approved')
			{
               $page_data['msg']= "Approved";
            } 
			else 
			{
                $page_data['msg']= "Postponed";
            }
            
            $email_msg=$this->load->view('front/email_vendor_welcome',$page_data,TRUE);
            $this->do_email($email_msg, $email_sub, $email_to, $from);
            return true;
        } 
		else 
		{
            return false;
        }
	}
	
	
    
    /***custom email sender****/
    
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
    
    
    //request emails
	function email_request($request_type,$request_id,$user_type='user')
    {
        $page_data=array('request_type'=>$request_type,'request_title'=>'Request for Demo','user_type'=>$user_type);
        $this->load->database();
        $system_name  = $this->db->get_where('general_settings', array('type' => 'system_name'))->row()->value;
        $system_email = $this->db->get_where('general_settings', array( 'type' => 'system_email'))->row()->value;
        
        $request_qry=$this->db->where('id',$request_id)->get($request_type);
        if($request_type=='request_service')
        {
            $page_data['request_title']='Request for Service';
            $request_qry=$this->db->where('request_id',$request_id)->get($request_type);
        }
         
        if($request_qry->num_rows()==1)
        {
            $request_data=$request_qry->row();

            $page_data['customer_name']=$request_data->name;
            $page_data['request_data']=$request_data;

            $email_sub = $page_data['request_title'].'-'.$system_name;
            $from      = $system_email;
            $from_name = $system_name;
            $email_msg= $this->load->view('front/email_request_user',$page_data,TRUE);
            if($user_type=='user')
            {
                $email_to  = $request_data->email;
                $this->do_email($email_msg, $email_sub, $email_to, $from);
            }
            else
            {
                $admins = $this->db->get('admin')->result_array();
                //->get_where('admin',array('role'=>'7'))
                foreach ($admins as $row) 
                {
                    $this->email_model->do_email($email_msg, $email_sub,$row['email'], $from);
                }
            }
            
        }

    }
    
    
}