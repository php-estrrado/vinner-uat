<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Product extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');//form validate
        $this->load->library("session");
        $this->load->model('warehouse/products');
        $this->load->model('functions');
        if ($this->session->userdata('vendor_login') == 'yes') { }else{ redirect('warehouse'); }
    }
    function priceChange($para1='', $para2=0){ 
        if($para1 == 'list'){
            $data['title']          =   "Price Change Requests";
            $data['page_name']      =   "product/price_requests"; 
            $data['products']       =   $this->products->getPriceChangeRequests();
            $this->load->view('back/index', $data);
        }else if($para1 == 'cancel'){
            $this->db->where('id',$para2)->delete('shipping_operators');
        }else{
            $data['title']              =   "Price Change Requests";
            $data['page_name']          =   "product/price_requests"; 
            $data['products']       =   $this->products->getPriceChangeRequests((int)$para2);
        //    echo '<pre>'; print_r($data['products']); echo '</pre>';
        //    die;
            $this->load->view('back/index', $data);
        }
    }
    function getData($para1='', $para2=0){
        $post                       =   (object)$this->input->post(); $res = '';
        $data                       =   $this->functions->getDropdownData($para1,'id','name','Select '.$post->label  ,[$post->id=>$para2,'status'=>1]);
        if($data){ foreach($data    as  $k=>$row){ 
            $res                    .=  '<option value="'.$k.'">'.$row.'</option>';
        } } echo $res;
    }
    
}

