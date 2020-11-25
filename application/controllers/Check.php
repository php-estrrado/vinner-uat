<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Check extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
        $this->load->helper('text');
        $this->load->database();
        $this->load->library('image_lib');
        $this->load->helper('captcha');
        $this->load->library('paypal');
        $this->load->model('myapp_model');

		$cache_time	 =  $this->db->get_where('general_settings',array('type' => 'cache_time'))->row()->value;
		if(!$this->input->is_ajax_request()){
			$this->output->set_header('HTTP/1.0 200 OK');
			$this->output->set_header('HTTP/1.1 200 OK');
			$this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
			$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
			$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
			$this->output->set_header('Pragma: no-cache');
            if($this->router->fetch_method() == 'index' || 
                $this->router->fetch_method() == 'featured_item' || 
                    $this->router->fetch_method() == 'product_view' || 
                        $this->router->fetch_method() == 'blog' || 
                            $this->router->fetch_method() == 'blog_view' || 
                                $this->router->fetch_method() == 'vendor' || 
                                    $this->router->fetch_method() == 'category'){
                $this->output->cache($cache_time);
            }
		}
		$this->config->cache_query();
        $this->crud_model->ip_data();
    }
	
	
	public function index()
    {
       
       $this->db->order_by('product_id', 'desc');
       $featured_data= $this->db->get_where('product', array(
            'featured' => "ok",
            'status' => 'ok'
        ))->result_array();
        //print_r($featured_data);
		$this->load->view('front/check');
    }
}
?>