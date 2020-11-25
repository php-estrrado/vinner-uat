<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mclaunch extends CI_Controller
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
    function index()
    { 
        $this->load->view('front/mclaunch',$data);
    }

}

