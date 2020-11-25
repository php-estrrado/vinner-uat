<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Login extends CI_Controller
{
    function __construct(){
        parent::__construct();
        {
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');//form validate
            $this->load->library("session");
        }
    }
    function index(){ 
        $this->load->view('front/siteLogin');
    }
    function siteLogin(){ 
        $this->form_validation->set_rules('username', 'username','trim|required');
        $this->form_validation->set_rules('password', 'password','trim|required|callback_check_login');
        if($this->form_validation->run() == FALSE)
        { $this->load->view('front/siteLogin'); }
        else{ redirect(base_url('home/')); }
    }
    function check_login($password){
       $username = $this->input->post('username');
       if($username == 'admin@marinecart' && $password == 'marine@cart#321'){
            $this->session->set_userdata('site_login', 'yes');
            return TRUE;
       }else{
            $this->form_validation->set_message('check_login', 'Invalid username or password');
            return false;
       }
    }
}

