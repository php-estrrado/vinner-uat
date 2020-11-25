<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//use FedEx\RateService,FedEx\RateService\ComplexType,FedEx\RateService\SimpleType;
class Home extends CI_Controller
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
        $this->load->helper('url');
        $this->load->library('custom_pagination');
        $this->perPage = 12; 

        /*cache control*/
		//ini_set("user_agent","My-Great-Marketplace-App");
		$cache_time	 =  $this->db->get_where('general_settings',array('type' => 'cache_time'))->row()->value;
		if(!$this->input->is_ajax_request())
		{
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
    
    /* FUNCTION: Loads Homepage*/
    public function index()
    { 
        $page_data['min'] = $this->get_range_lvl('product_id !=', '', "min");
        $page_data['max'] = $this->get_range_lvl('product_id !=', '', "max");
        $this->db->order_by('product_id', 'desc');
        $page_data['featured_data'] = $this->db->get_where('product', array(
            'featured' => "ok",
            'status' => 'ok'
        ))->result_array();
        $page_data['categories']    =   $this->db->get_where('category',['status'=>1])->result();
        $page_data['brands']        =   $this->db->get_where('brand',['status'=>1])->result();        $page_data['page_name']     = "home";
        $page_data['page_title']    = translate('home');
        $this->load->view('front/index', $page_data);
    }
    public function about()

    {   $page_data['page_name']     = "about";
        $page_data['page_title']    = translate('about');
        $this->load->view('front/index', $page_data);
    }
	function currency_convert($val)
	{
    	$currency_ex =  $this->db->get_where('business_settings',array('type' => 'exchange'))->row()->value;
    	$aed    = $val * $currency_ex;
    	$aed    = round($aed, 2);
    	//$aed    = currency() . $aed;
    	return $aed;
	}

    function vendor($vendor_id)
	{
		$vendor_system	 =  $this->db->get_where('general_settings',array('type' => 'vendor_system'))->row()->value;
        if($vendor_system	 == 'ok' && 
			$this->db->get_where('vendor',array('vendor_id'=>$vendor_id))->row()->status == 'approved'){
            $min = $this->get_range_lvl('added_by', '{"type":"vendor","id":"'.$vendor_id.'"}', "min");
            $max = $this->get_range_lvl('added_by', '{"type":"vendor","id":"'.$vendor_id.'"}', "max");
            $this->db->order_by('product_id', 'desc');
            $page_data['featured_data'] = $this->db->get_where('product', array(
                'featured' => "ok", 'status' => 'ok','added_by' => '{"type":"vendor","id":"'.$vendor_id.'"}'))->result_array();
            $page_data['range']             = $min . ';' . $max;
            $page_data['all_category']      = $this->db->get('category')->result_array();
            $page_data['all_sub_category']  = $this->db->get('sub_category')->result_array();
            $page_data['page_name']         = 'vendor_home';
            $page_data['vendor']            = $vendor_id;
            $page_data['page_title']        = 		$this->db->get_where('vendor',array('vendor_id'=>$vendor_id))->row()->display_name;
			$page_data['vendor_product'] = $this->db->get_where('product', array(
                'status' => 'ok',
                'added_by' => '{"type":"vendor","id":"'.$vendor_id.'"}'
            ))->result_array();
            $this->load->view('front/index', $page_data); 
        } 
		else 
		{
             redirect(base_url(), 'refresh');
        }
    }

    /* FUNCTION: Loads Customer Profile Page */
    function profile($argu='')
    {
        if ($this->session->userdata('user_login') != "yes") 
		{
            redirect(base_url('home/login/redirect?page=profile/'.$argu));
        }
		$page_data['argu']     	   = $argu;
        $page_data['page_name']    = "profile";
        $page_data['page_title']   = translate('my_profile');
        $page_data['all_products'] = $this->db->get_where('user', array(
            'user_id' => $this->session->userdata('user_id')
        ))->result_array();
        $page_data['user_info']    = $this->db->get_where('user', array(
            'user_id' => $this->session->userdata('user_id')
        ))->result_array();
        $page_data['addresses']     =   $this->db->join('countries as C','A.country = C.id')
                                        ->get_where('user_address as A',['A.user_id'=>$this->session->userdata('user_id'), 'A.status' => 1])->result();
        $this->load->view('front/index', $page_data);
    }

    /* FUNCTION: Loads Customer Download */
    function download($id)
    {
        if ($this->session->userdata('user_login') != "yes") {
            redirect(base_url(), 'refresh');
        }
        $this->crud_model->download_product($id);
    }
	
    /* FUNCTION: Loads Customer Download Permission */
    function can_download($id)
    {
        if ($this->session->userdata('user_login') != "yes") {
            redirect(base_url(), 'refresh');
        }
        if($this->crud_model->can_download($id)){
            echo 'ok';
        } else {
            echo 'not';
        }
    }
    
    /* FUNCTION: Search Products */
    function home_search($param = '')
    {
        $category = $this->input->post('category');
        $this->session->set_userdata('searched_cat', $category);
        if ($param !== 'top') 
		{
            $sub_category = $this->input->post('sub_category');
            $range        = $this->input->post('range');
            $p            = explode(';', $range);
            redirect(base_url() . 'home/category/' . $category . '/' . $sub_category . '/' . $p[0] . '/' . $p[1], 'refresh');
        } else if ($param == 'top') {
            redirect(base_url() . 'home/category/' . $category, 'refresh');
        }
    }

    function text_search()
	{
        $type = $this->input->post('type');
        $search = $this->input->post('query');
        $this->crud_model->search_terms($search);
        if($type == 'vendor'){
            redirect(base_url() . 'home/store_locator/'.$search, 'refresh');
        } else if($type == 'product'){
            redirect(base_url() . 'home/category/0/0/0/0/'.$search, 'refresh');
        }
    }
    
    /*Function Advanced Search redirect*/
     function adv_search()
	 { 
        $type = $this->input->post('category');
        $search = $this->input->post('query');
        
        //edited on 7/1/2017 ajith
        $search = str_replace('%','%25', $search);
        $search = str_replace(',','%2C', $search);        
        $search = str_replace('&','%26', $search);
        $search = str_replace('-','%2D', $search);
        $search = str_replace('=','%3D', $search);
        $search = str_replace('(','%28', $search);
        $search = str_replace(')','%29', $search);
        $search = str_replace('+','%2B', $search);

        if($type=='brand')
		{
            $brand_id =  $this->db->get_where('brand',array('name' => "$search"))->row()->brand_id;
            redirect(base_url() . 'home/brand/'.$brand_id, 'refresh');
        }
        else
		{    
            if($type == '0')
			{
                redirect(base_url() . 'home/advance_search/0/0/0/0/'.$search, 'refresh');
            } else if($type > 0){
                redirect(base_url() . 'home/advance_search/'.$type.'/0/0/0/'.$search, 'refresh');
            }
        }
    }
    /*Function Advanced Search redirect*/


    /* FUNCTION: Check if user logged in */
    function is_logged()
    {
        if ($this->session->userdata('user_login') == 'yes') {
            echo 'yah!good';
        } else {
            echo 'nope!bad';
        }
    }
    
   
    /* FUNCTION: Loads Custom Pages */
    function store_locator($parmalink = '')
    {
        $page_data['page_name']  = 'store_locator';
        $page_data['page_title'] = translate("store_locator");
        $page_data['text'] = $parmalink;
        $page_data['vendors'] = $this->db->get_where('vendor',array('status'=>'approved'))->result_array();
        $this->load->view('front/index', $page_data);
    }
    
    
    /* FUNCTION: Loads Featured Product Page */
    function featured_item($min = '', $max = '')
    {
        $page_data['page_name']        = "featured_list";
        $page_data['page_title']       = translate('featured_products');
        $page_data['range']            = $min . ';' . $max;
        $page_data['all_category']     = $this->db->get('category')->result_array();
        $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
        $page_data['all_products']     = $this->db->get_where('product', array(
            'featured' => "ok",
            'status' => 'ok'
        ))->result_array();
        $this->load->view('front/index', $page_data);
    }
    
    /* FUNCTION: Loads Custom Pages */
    function page($parmalink = '')
    {
        $pagef = $this->db->get_where('page', array('parmalink' => $parmalink));
        $page_data['page_name']  = "page";
        $page_data['page_title'] = $parmalink;
        $page_data['page_items'] = $pagef->result_array();
        if ($this->session->userdata('admin_login') !== 'yes' && $pagef->row()->status !== 'ok') 
		{
            redirect(base_url() . 'home/', 'refresh');
        }
        $this->load->view('front/index', $page_data);
    }
    
    
    /* FUNCTION: Loads Product View Page */
    function product_view($para1 = "")
    {
        $page_data['page_name']    = "product_view";
        $product_data              = $this->db->get_where('product', array('product_id' => $para1,'status' => 'ok'));
		
        $page_data['product_data'] = $product_data->result_array();
        $page_data['page_title']   = $product_data->row()->title;
        $page_data['product_tags'] = $product_data->row()->tag;
        $page_data['ddescription']  = substr(trim(strip_tags($product_data->row()->meta_description)),0,320);
        if(!$page_data['ddescription'])
        {
         $page_data['ddescription']  = substr(trim(strip_tags($product_data->row()->short_description)),0,320);
        }

        $nov=$product_data->row()->number_of_view +1;
        $this->db->where('product_id', $para1);
        $this->db->update('product', array('number_of_view' => $nov)); 

		//Last viewed products session addedd 1-4-2017
		if(!isset($_SESSION["lastviewed"]))     
		{
		  $_SESSION["lastviewed"] = array();
		}
		$maxelements = 10;
		if (($key = array_search($para1, $_SESSION["lastviewed"])) !== false) 
		{
		 unset($_SESSION["lastviewed"][$key]);
		}
		if (count($_SESSION["lastviewed"]) >= $maxelements) {
		 $_SESSION["lastviewed"] = array_slice($_SESSION["lastviewed"],1); 
		 array_push($_SESSION["lastviewed"],$para1);
		} else {
		 array_push($_SESSION["lastviewed"],$para1);
		}
		//ending session Last viewed


        $this->load->view('front/index', $page_data);
    }
	
    /* FUNCTION: Loads Product View Page */
   	function quick_view($para1 = "")
    {
        $product_data              = $this->db->get_where('product', array(
            'product_id' => $para1,
            'status' => 'ok'
        ));
        $page_data['product_data'] = $product_data->result_array();
        $page_data['page_title']   = $product_data->row()->title;
        $page_data['product_tags'] = $product_data->row()->tag;
        
        $this->load->view('front/quick_view', $page_data);
    }
    
    /* FUNCTION: Setting Frontend Language */
    /*function set_language($lang)
    {
        $this->session->set_userdata('language', $lang);
        $page_data['page_name'] = "home";
        redirect(base_url() . 'index.php/home/', 'refresh');
    }*/
    
    /* FUNCTION: Loads Contact Page */
    function contact($para1 = "")
    {
        $this->load->library('recaptcha');
        $this->load->library('form_validation');
        if ($para1 == 'send') 
		{
            $safe = 'yes';
            $char = '';
            foreach($_POST as $row)
			{
                if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row,$match))
                {
                    $safe = 'no';
                    $char = $match[0];
                }
            }

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('subject', 'Subject', 'required');
            $this->form_validation->set_rules('message', 'Message', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            //$this->form_validation->set_rules('captcha', 'Captcha', 'callback_validate_captcha');
            //$this->form_validation->set_rules('tel', 'Phone Number', 'required|regex_match[/^[0-9]{10}$/]');

            if ($this->form_validation->run() == FALSE)
            {
                //echo validation_errors();
				$this->session->set_flashdata('contact_warning', validation_errors());
            }
            else
            {
                if($safe == 'yes')
				{
                   // $this->recaptcha->recaptcha_check_answer();
                    
                        $data['name']      = $this->input->post('name',true);
                        $data['subject']   = $this->input->post('subject');
                        $data['email']     = $this->input->post('email');
                        //$data['organization']     = $this->input->post('org');
                        //$data['time_to_call']     = $this->input->post('conv_time');
                        $data['message']   = $this->security->xss_clean(($this->input->post('message')));
                        //$data['tel']     = $this->input->post('tel');
                        
                        $data['view']      = 'no';
                        $data['timestamp'] = time();
                        $this->db->insert('contact_message', $data);
                        $this->session->set_flashdata('contact_alert', 'contact_message_sent_sucessfully!');
                     
                } 
				else 
				{
					$this->session->set_flashdata('contact_warning', 'Disallowed charecter : " '.$char.' " in the message');
                    //echo 'Disallowed charecter : " '.$char.' " in the POST';
                }
            }
		    redirect('home/contact');
        }
		else 
		{
            $page_data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
            $page_data['page_name']      = "contact";
            $page_data['page_title']     = translate('contact_us');
            $this->load->view('front/index', $page_data);
        }
    }
    
    
    /* FUNCTION: Concerning Login */
    function vendor_logup($para1 = "", $para2 = "")
    {
        if ($para1 == "add_info") 
		{
            $this->load->library('form_validation');
            $safe = 'yes';
            $char = '';
            foreach($_POST as $k=>$row){
                if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row,$match))
                {
                    if($k !== 'password1' && $k !== 'password2')
                    {
                        $safe = 'no';
                        $char = $match[0];
                    }
                }
            }

            $this->form_validation->set_rules('name', 'Your First Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'valid_email|required|is_unique[vendor.email]',array('required' => 'You have not provided %s.', 'is_unique' => 'This %s already exists.'));
            $this->form_validation->set_rules('password1', 'Password', 'required|matches[password2]');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'required');
            $this->form_validation->set_rules('address1', 'Address Line 1', 'required');
            //$this->form_validation->set_rules('address2', 'Address Line 2', 'required');
            $this->form_validation->set_rules('display_name', 'Your Display Name', 'required');
            $this->form_validation->set_rules('captcha', 'Captcha', 'callback_validate_captcha');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                if($safe == 'yes'){
                    $data['name']               = $this->input->post('name');
                    $data['email']              = $this->input->post('email');
                    $data['address1']           = $this->input->post('address1');
                    $data['address2']           = $this->input->post('address2');
                    $data['company']            = $this->input->post('company');
                    $data['display_name']       = $this->input->post('display_name');
                    $data['create_timestamp']   = time();
                    $data['approve_timestamp']  = 0;
                    $data['approve_timestamp']  = 0;
                    $data['membership']         = 0;
                    $data['status']             = 'pending';
                    //$data['phone']              = $this->input->post('tel');
                    $data['mobile']             = $this->input->post('mobile');
					$data['country_code']       = $this->input->post('country_code');
                    
                    if ($this->input->post('password1') == $this->input->post('password2')) 
					{
                        $password         = $this->input->post('password1');
                        $data['password'] = sha1($password);
                        $this->db->insert('vendor', $data);
                        $this->email_model->account_opening('vendor', $data['email'], $password);
                        echo 'done';
                    }
                } 
				else 
				{
                    echo 'Disallowed charecter : " '.$char.' " in the POST';
                }
            }
        } 
		else if($para1 == 'registration') 
		{
            $this->load->view('front/vendor_logup');
        }			if(($this->input->post('token'))){ 
                $this->form_validation->set_rules('mobile', 'Mobile', 'required');
            }else{
                $this->form_validation->set_rules('email', 'Email', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');
            }

            if ($this->form_validation->run() == FALSE)
            {
				if($para2=='page')
				{
					$this->session->set_flashdata('frm_error',validation_errors());
					redirect('home/email_approve');
				}
				else
				{
                	echo validation_errors();
				}
            }
            else
            {
                if($this->input->post('token')){
                    $signin_data = $this->db->get_where('user', array(
					'mobile' => $this->input->post('mobile'),
					'access_token' => $this->input->post('token')
				));
                }else{
    				$signin_data = $this->db->get_where('user', array(
    					'email' => $this->input->post('email'),
    					'password' => sha1($this->input->post('password'))
    				));
                }
                if ($signin_data->num_rows() > 0){
                    if($signin_data->row()->status == 'approved'){
                        foreach ($signin_data->result_array() as $row){
                            $this->session->set_userdata('user_login', 'yes');
                            $this->session->set_userdata('user_id', $row['user_id']);
                            $this->session->set_userdata('user_name', $row['username']);
                            $this->session->set_flashdata('alert', 'successful_signin');
                            $this->db->where('user_id', $row['user_id']);
                            $this->db->update('user', array(
                                    'last_login' => time()
                            ));
                            $cartItems  =   [];
                            $qry        =   $this->db->get_where('cart',['user_id'=>$row['user_id'],'status'=>1]);
                            if($qry->num_rows() > 0){ $cart = $qry->row();
                                $cartItems = $this->db->get_where('cart_items',['cart_id'=>$cart->cart_id,'status'=>1])->result();
                            }
                            $this->crud_model->changeRegion($row['shop_region']);
                            if(count($cartItems)>0){
                                $this->session->set_userdata('cart_cont',count($cartItems) );
                                foreach ($cartItems as $rw){
                                    $datact = array(
                                        'id'        =>  $rw->product_id,
                                        'qty'       =>  $rw->qty,
                                        'option'    =>  json_decode($rw->option),
                                        'price'     =>  $this->crud_model->get_product_price($rw->product_id),
                                        'name'      =>  $rw->product_name,
                                        'shipping'  =>  $this->crud_model->get_shipping_cost($rw->product_id),
                                        'tax'       =>  $this->crud_model->get_product_tax($rw->product_id),
                                        'image'     =>  $rw->image,
                                        'coupon' => '',
                                        'coupon_discount' => ''
                                    );
                                    $this->cart->insert($datact);
                                }
                                $page_data['carted'] = $this->cart->contents();
                            }

                            $datas['id']=session_id();
                            $datas['user_id']=$row['user_id'];
                            $datas['ip']=$_SERVER["REMOTE_ADDR"] ;                   
                            $this->db->insert('sessiondb',$datas);
                            if($para2=='page'){
                                if($this->input->post('redirect')){ redirect('home/'.$this->input->post('redirect')); }else{ redirect('home');}
                            }else{ echo 'done'; }
                            //echo 'done';
                        }
                    }else{
                        if($para2=='page')
                        {
                                $this->session->set_flashdata('frm_error',"Account hasn't verified yet, please verify your email address..");				
                                if($this->input->post('redirect'))
                                {
                                        redirect('home/login/redirect?page='.$this->input->post('redirect'));
                                }
                                else
                                {
                                        redirect('home/email_approve');
                                }

                        }
                        else
                        {
                                echo "Account hasn't verified yet, please verify your email address..";
                        }
                    }
                }else{
                    if($para2=='page')
                        {
                                $this->session->set_flashdata('frm_error','Login Failed,try again');
                                if($this->input->post('redirect'))
                                {
                                        redirect('home/login/redirect?page='.$this->input->post('redirect'));
                                }
                                else
                                {
                                        redirect('home/email_approve');
                                }

                        }
                        else
                        {
                                echo 'failed';
                        }
                }
            }

    }
    /* FUNCTION: Concerning Login */
    function login($para1 = "", $para2 = "")
    {
		if ($this->session->userdata('user_login') == "yes")
        {
            redirect(base_url());
        }
        $page_data['page_name'] = "login";
        $this->load->library('form_validation');
        if ($para1 == "do_login") 
		{
						if(($this->input->post('token'))){ 
                $this->form_validation->set_rules('mobile', 'Mobile', 'required');
            }else{
                $this->form_validation->set_rules('email', 'Email', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');
            }

            if ($this->form_validation->run() == FALSE)
            {
				if($para2=='page')
				{
					$this->session->set_flashdata('frm_error',validation_errors());
					redirect('home/email_approve');
				}
				else
				{
                	echo validation_errors();
				}
            }
            else
            {
                if($this->input->post('token')){
                    $signin_data = $this->db->get_where('user', array(
					'mobile' => $this->input->post('mobile'),
					'access_token' => $this->input->post('token')
				));
                }else{
    				$signin_data = $this->db->get_where('user', array(
    					'email' => $this->input->post('email'),
    					'password' => sha1($this->input->post('password'))
    				));
                }
                if ($signin_data->num_rows() > 0){
                    if($signin_data->row()->status == 'approved'){
                        foreach ($signin_data->result_array() as $row){
                            $this->session->set_userdata('user_login', 'yes');
                            $this->session->set_userdata('user_id', $row['user_id']);
                            $this->session->set_userdata('user_name', $row['username']);
                            $this->session->set_flashdata('alert', 'successful_signin');
                            $this->db->where('user_id', $row['user_id']);
                            $this->db->update('user', array(
                                    'last_login' => time()
                            ));
                            $cartItems  =   [];
                            $qry        =   $this->db->get_where('cart',['user_id'=>$row['user_id'],'status'=>1]);
                            if($qry->num_rows() > 0){ $cart = $qry->row();
                                $cartItems = $this->db->get_where('cart_items',['cart_id'=>$cart->cart_id,'status'=>1])->result();
                            }
                            $this->crud_model->changeRegion($row['shop_region']);
                            if(count($cartItems)>0){
                                $this->session->set_userdata('cart_cont',count($cartItems) );
                                foreach ($cartItems as $rw){
                                    $datact = array(
                                        'id'        =>  $rw->product_id,
                                        'qty'       =>  $rw->qty,
                                        'option'    =>  json_decode($rw->option),
                                        'price'     =>  $this->crud_model->get_product_price($rw->product_id),
                                        'name'      =>  $rw->product_name,
                                        'shipping'  =>  $this->crud_model->get_shipping_cost($rw->product_id),
                                        'tax'       =>  $this->crud_model->get_product_tax($rw->product_id),
                                        'image'     =>  $rw->image,
                                        'rowid'     =>  $rw->sess_cart_id,
                                        'coupon' => '',
                                        'coupon_discount' => ''
                                    );
                                    $this->cart->insert($datact);
                                }
                                $page_data['carted'] = $this->cart->contents();
                            }

                            $datas['id']=session_id();
                            $datas['user_id']=$row['user_id'];
                            $datas['ip']=$_SERVER["REMOTE_ADDR"] ;                   
                            $this->db->insert('sessiondb',$datas);
                            if($para2=='page'){
                                if($this->input->post('redirect')){ redirect('home/'.$this->input->post('redirect')); }else{ redirect('home');}
                            }else{ echo 'done'; }
                            //echo 'done';
                        }
                    }else{
                        if($para2=='page')
                        {
                                $this->session->set_flashdata('frm_error',"Account hasn't verified yet, please verify your email address..");				
                                if($this->input->post('redirect'))
                                {
                                        redirect('home/login/redirect?page='.$this->input->post('redirect'));
                                }
                                else
                                {
                                        redirect('home/email_approve');
                                }

                        }
                        else
                        {
                                echo "Account hasn't verified yet, please verify your email address..";
                        }
                    }
                }else{
                    if($para2=='page')
                        {
                                $this->session->set_flashdata('frm_error','Login Failed,try again');
                                if($this->input->post('redirect'))
                                {
                                        redirect('home/login/redirect?page='.$this->input->post('redirect'));
                                }
                                else
                                {
                                        redirect('home/email_approve');
                                }

                        }
                        else
                        {
                                echo 'failed';
                        }
                }
            }
        } 
		else if ($para1 == 'forget') 
		{
        	$this->load->library('form_validation');
			$this->form_validation->set_rules('email', 'Email', 'required');
			
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
				$query = $this->db->get_where('user', array('email' => $this->input->post('email')));
				if ($query->num_rows() > 0) 
				{
					$user_id          = $query->row()->user_id;
					$password         = substr(hash('sha512', rand()), 0, 12);
					$data['password'] = sha1($password);
					$this->db->where('user_id', $user_id);
					$this->db->update('user', $data);
					if ($this->email_model->password_reset_email('user', $user_id, $password)) 
					{
						echo 'email_sent';
					} 
					else 
					{
						echo 'email_not_sent';
					}
				} 
				else 
				{
					echo 'email_nay';
				}
			}
        }
		
		else if($para1 == 'redirect')
        {
            $page_data['page_name']    = "login_page";
            $page_data['page_title']   = translate('login');
            $this->load->view('front/index', $page_data);
        }
    }

	function set_currency($curr)
    {
        if($curr=='USD' || $curr=='AED')
        {
         	$this->session->set_userdata(array('currency' => $curr ));  
        }
        else
        { 
            redirect(base_url() .'index.php/home');
        }
        redirect(base_url() .'index.php/home');
    }

    
    /* FUNCTION: Setting login page with facebook and google */
    function login_set($para1 = '', $para2 = '')
    {
        $fb_login_set = $this->crud_model->get_type_name_by_id('general_settings', '51', 'value');
        $g_login_set  = $this->crud_model->get_type_name_by_id('general_settings', '52', 'value');
        $page_data    = array();
        $appid        = $this->db->get_where('general_settings', array(
            'type' => 'fb_appid'
        ))->row()->value;
        $secret       = $this->db->get_where('general_settings', array(
            'type' => 'fb_secret'
        ))->row()->value;
        $config       = array(
            'appId' => $appid,
            'secret' => $secret
        );
        $this->load->library('Facebook', $config);
        
        if ($fb_login_set == 'ok') {
            // Try to get the user's id on Facebook
            $userId = $this->facebook->getUser();
            
            // If user is not yet authenticated, the id will be zero
            if ($userId == 0) {
                // Generate a login url
                //$page_data['url'] = $this->facebook->getLoginUrl(array('scope'=>'email')); 
                $page_data['url'] = $this->facebook->getLoginUrl(array(
                    'redirect_uri' => site_url('home/login_set/back/' . $para2),
                    'scope' => array(
                        "email"
                    ) // permissions here
                ));
                //redirect($data['url']);
            } else {
                // Get user's data and print it
                $page_data['user'] = $this->facebook->api('/me');
                $page_data['url']  = site_url('home/login_set/back/' . $para2); // Logs off application
                //print_r($user);
            }
            if ($para1 == 'back') {
                $user = $this->facebook->api('/me');
                if ($user_id = $this->crud_model->exists_in_table('user', 'fb_id', $user['id'])) {
                    
                } else {
                    $data['username']      = $user['name'];
                    $data['email']         = $user['email'];
                    $data['fb_id']         = $user['id'];
                    $data['wishlist']      = '[]';
                    $data['creation_date'] = time();
                    $data['password']      = substr(hash('sha512', rand()), 0, 12);
                    
                    $this->db->insert('user', $data);
                    $user_id = $this->db->insert_id();
                }
                $this->session->set_userdata('user_login', 'yes');
                $this->session->set_userdata('user_id', $user_id);
                $this->session->set_userdata('user_name', $this->db->get_where('user', array(
                    'user_id' => $user_id
                ))->row()->username);
                $this->session->set_flashdata('alert', 'successful_signin');
                
                $this->db->where('user_id', $user_id);
                $this->db->update('user', array(
                    'last_login' => time()
                ));
                
                if ($para2 == 'cart') {
                    redirect(base_url() . 'index.php/home/cart_checkout', 'refresh');
                } else {
                    redirect(base_url() . 'index.php/home', 'refresh');
                }
            }
        }
        
        
        if ($g_login_set == 'ok') {
            $this->load->library('googleplus');
            if (isset($_GET['code'])) { //just_logged in
                $this->googleplus->client->authenticate();
                $_SESSION['token'] = $this->googleplus->client->getAccessToken();
                $g_user            = $this->googleplus->people->get('me');
                if ($user_id = $this->crud_model->exists_in_table('user', 'g_id', $g_user['id'])) {
                    
                } else {
                    $data['username']      = $g_user['displayName'];
                    $data['email']         = 'required';
                    $data['wishlist']      = '[]';
                    $data['g_id']          = $g_user['id'];
                    $data['g_photo']       = $g_user['image']['url'];
                    $data['creation_date'] = time();
                    $data['password']      = substr(hash('sha512', rand()), 0, 12);
                    $this->db->insert('user', $data);
                    $user_id = $this->db->insert_id();
                }
                $this->session->set_userdata('user_login', 'yes');
                $this->session->set_userdata('user_id', $user_id);
                $this->session->set_userdata('user_name', $this->db->get_where('user', array(
                    'user_id' => $user_id
                ))->row()->username);
                $this->session->set_flashdata('alert', 'successful_signin');
                
                $this->db->where('user_id', $user_id);
                $this->db->update('user', array('last_login' => time()));
                
                if ($para2 == 'cart') {
                    redirect(base_url() . 'home/cart_checkout', 'refresh');
                } else {
                    redirect(base_url() . 'home', 'refresh');
                }
            }
            if (@$_SESSION['token']) {
                $this->googleplus->client->setAccessToken($_SESSION['token']);
            }
            if ($this->googleplus->client->getAccessToken()) //already_logged_in
                {
                $page_data['g_user'] = $this->googleplus->people->get('me');
                $page_data['g_url']  = $this->googleplus->client->createAuthUrl();
                $_SESSION['token']   = $this->googleplus->client->getAccessToken();
            } else {
                $page_data['g_url'] = $this->googleplus->client->createAuthUrl();
            }
        }
        
        if ($para1 == 'login') {
            $this->load->view('front/login', $page_data);
        } elseif ($para1 == 'registration') {
            $this->load->view('front/logup', $page_data);
        }
    }
    
    /* FUNCTION: Logout set */
    function logout()
    {
        $appid  = $this->db->get_where('general_settings', array(
            'type' => 'fb_appid'
        ))->row()->value;
        $secret = $this->db->get_where('general_settings', array(
            'type' => 'fb_secret'
        ))->row()->value;
        $config = array(
            'appId' => $appid,
            'secret' => $secret
        );
        $this->load->library('Facebook', $config);
        
        $this->facebook->destroySession();

        $sid=session_id();
        $this->db->where('id',$sid );
        $this->db->delete('sessiondb');
        $carted = $this->cart->contents();
        foreach ($carted as $items) 
        	{                                       
        		$cartlist[] =array('id' => $items['id'],'qty' => $items['qty'],'option'=>$items['option']);
            }
        $datac['carted']  = json_encode($cartlist);
        $user_idc 		  = $this->session->userdata('user_id');
        $currency       =   $this->session->userdata('currency'); 
        $country        =   $this->session->userdata('country');
        $this->db->where('user_id',$user_idc)->update('user', $datac);
        $this->session->sess_destroy();
        $this->session->set_userdata('currency',$currency);
                $this->session->set_userdata('country',$country);
		$this->session->set_flashdata('alert', 'successful_signout');
		redirect(base_url(), 'refresh');
    }
    
    /* FUNCTION: Logout */
    function logged_out()
    {
        $this->session->set_flashdata('alert', 'successful_signout');
        redirect(base_url() . 'index.php/home/', 'refresh');
    }
    
    /* FUNCTION: Check if Email user exists */
    function exists()
    {
        $email  = $this->input->post('email');
        $user   = $this->db->get('user')->result_array();
        $exists = 'no';
        foreach ($user as $row) {
            if ($row['email'] == $email) {
                $exists = 'yes';
            }
        }
        echo $exists;
    }
    
    function mobile_exists()
    {
        $mobile  = $this->input->post('mobile'); $cCode =   $this->input->post('c_code');
        $user   = $this->db->where(['mobile'=>$mobile,'c_code'=>$cCode])->get('user')->num_rows();
        $exists = 'no';
        if($mobile != ''){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|min_length[7]|max_length[10]');
            if ($this->form_validation->run() == FALSE){
                    $error = validation_errors();
                    $error = str_replace('<p>','',$error); $error = str_replace('</p>','',$error);  echo $error; die;
            } 
        }
        if($user > 0){ $exists = 'This Number Exist'; }
        echo $exists;
    }
    
    /* FUNCTION: Newsletter Subscription */
    function subscribe()
    {
        $safe = 'yes';
        $char = '';
        foreach($_POST as $row){
            if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row,$match))
            {
                $safe = 'no';
                $char = $match[0];
            }
        }

        $this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
            if($safe == 'yes'){
    			$subscribe_num = $this->session->userdata('subscriber');
    			$email         = $this->input->post('email');
    			$subscriber    = $this->db->get('subscribe')->result_array();
    			$exists        = 'no';
    			foreach ($subscriber as $row) {
    				if ($row['email'] == $email) {
    					$exists = 'yes';
    				}
    			}
    			if ($exists == 'yes') {
    				echo 'already';
    			} else if ($subscribe_num >= 3) {
    				echo 'already_session';
    			} else if ($exists == 'no') {
    				$subscribe_num = $subscribe_num + 1;
    				$this->session->set_userdata('subscriber', $subscribe_num);
    				$data['email'] = $email;
    				$this->db->insert('subscribe', $data);
    				echo 'done';
    			}
            } else {
                echo 'Disallowed charecter : " '.$char.' " in the POST';
            }
		}
    }
    
    /* FUNCTION: Customer Registration*/
    function registration($para1 = "", $para2 = "")
    {
        $safe = 'yes';
        $char = '';
        foreach($_POST as $k=>$row){
            if (preg_match('/[\'^":()}{#~><>|=¬]/', $row,$match))
            {
                if($k !== 'password1' && $k !== 'password2')
                {
                    $safe = 'no';
                    $char = $match[0];
                }
            }
        }

        $this->load->library('form_validation');
        $page_data['page_name'] = "registration";
        if ($para1 == "add_info") 
		{
           // $this->form_validation->set_rules('username', 'Your First Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email]|valid_email',array('required' => 'You have not provided %s.', 'is_unique' => 'This %s already exists.'));
            $this->form_validation->set_rules('password1', 'Password', 'required|matches[password2]');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'required');
            $this->form_validation->set_rules('username', 'Name', 'required|alpha');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|numeric',array('required' => 'You have not provided %s.'));

            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                if($safe == 'yes'){
                    $acess_token            = rand(100000,999999);
                    $data['username']       = $this->input->post('username');
                    $data['email']          = $this->input->post('email'); 
                    $data['username']       = $this->input->post('username');
                    $data['wishlist']       = '[]';
                    $data['creation_date']  = time();
                    $data['is_login']       = 1;
                    $data['status']         = 'approved';
                    $data['access_token']   = $acess_token;
                    $data['mobile']         = $this->input->post('mobile');
                    $data['c_code']         = $this->input->post('c_code');
                    
                    if ($this->input->post('password1') == $this->input->post('password2')) 
					{
                        $password         = $this->input->post('password1');
                        $data['password'] = sha1($password);
                        $this->db->insert('user', $data);
                        //$approve= sha1($data['email']);
                        $this->crud_model->account_opening('user', $data['email'], $password,$data['status'], $data['username']);
						$subsc_qry    = $this->db->get_where('subscribe',array('email'=>trim($data['email'])));
                        if($subsc_qry->num_rows()<=0)
						{
							 $data_sub['email'] = trim($data['email']);
                    		 $this->db->insert('subscribe', $data_sub);
						}
						echo 'done';
                    }
                } else {
                    echo 'Disallowed charecter : " '.$char.' " in the POST';
                }
            }
        }
        else if ($para1 == "update_info") 
		{
            $id                  = $this->session->userdata('user_id');
            $data['username']    = $this->input->post('username');
            $data['surname']     = $this->input->post('surname');
            $data['email']       = $this->input->post('email');
            $data['address1']    = $this->input->post('address1');
            $data['address2']    = $this->input->post('address2');
            $data['c_code']      = $this->input->post('c_code');
            $data['mobile']      = $this->input->post('mobile');
            $data['city']        = $this->input->post('city');
            $data['facebook']    = $this->input->post('facebook');
            $data['zip']         = $this->input->post('zip');
            
            $this->crud_model->file_up('image', 'user', $id);
            
            $this->db->where('user_id', $id);
            $this->db->update('user', $data);
			$ubqry=$this->db->get_where('subscribe', array('email' =>$data['email']))->num_rows();
			if($this->input->post('subscribe_profile'))
			{
				if($ubqry<=0)
				{
					$this->db->insert('subscribe',array('email'=>$data['email']));
				}
			}
			else
			{
				$this->db->where(array('email' =>$data['email']))->delete('subscribe');
			}
							
			$this->session->set_flashdata('alert', 'info updated');
			echo 'infoup';
            //redirect(base_url() . 'home/profile/edit');
        }
        else if ($para1 == "update_password") 
		{
			$passresult='';
            $user_data['password'] = $this->input->post('password');
            $account_data          = $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->result_array();
            foreach ($account_data as $row) 
			{
                if (sha1($user_data['password']) == $row['password']) 
				{
                    if ($this->input->post('password1') == $this->input->post('password2')) 
					{
                        $data['password'] = sha1($this->input->post('password1'));
                        $this->db->where('user_id', $this->session->userdata('user_id'));
                        $this->db->update('user', $data);
                        $this->crud_model->changePasswordEmail();
						$sid=session_id();
						$sesson_data = $this->db->get_where('sessiondb', array('user_id' => $this->session->userdata('user_id') ));
						foreach ($sesson_data->result_array() as $rowss) 
						{
							if ($rowss['id'] != $sid ) 
							{
								session_id($rowss['id']);
								session_start();
								session_destroy();
								$this->db->where('id',$rowss['id'] );
								$this->db->delete('sessiondb');
							}
						}
						session_id($sid);
						session_start();
					    $passresult= 'passup';
                       //header(base_url() . 'home/profile/');
                    }
                } 
				else 
				{
                    $passresult='pass_prb';
                }
            }
			if($passresult)
			{
				echo $passresult;
			}
			else
			{
				redirect(base_url());
			}
        } 
		else 
		{
            $this->load->view('front/registration', $page_data);
        }
    }
    
 	function email_approve($key='')
    {
        $login_key = $this->db->get_where('user', array('status' => $key ));
        if ($login_key->num_rows() > 0) 
        {
            $data['status']="approved";
            $this->db->where('status', $key);
            $this->db->update('user', $data);
			$this->session->set_flashdata('welcome_msg','welcome');
            $page_data['page_name']    = "login_page";
            $page_data['page_title']   = translate('welcome');
            $this->load->view('front/index', $page_data);
        }
        else
        {
            //redirect(base_url(), 'refresh');
            /*$page_data['page_name']    = "login_page";
            $page_data['page_title']   = translate('Login');
            $this->load->view('front/index', $page_data);*/
        }
    }
    /* FUNCTION: EMAIL APPROVAL*/
	
    function error()
    {
        //$this->load->view('front/error');
		$page_data['page_title']   = translate('404 Not Found');
        $page_data['page_name']    = "error_page";
        $this->load->view('front/index', $page_data);
    }
    

     /*todays deal*/
    function  daily_deals($para1 = '', $para2 = '')
    {
        $para1="list";
        if ($para1 == 'list') 
        {
            $this->db->order_by('product_id', 'desc');
            $page_data['all_deals'] =  $this->db->get_where('product',array('deal'=>'ok'))->result_array();
            $this->load->view('front/daily_deals', $page_data);
        }

    }
	/*todays deal*/

    function order_track($para1 = "")
    {
        $ordid   = $para1;
        $page_data['orders'] = $this->db->get_where('sale', array(
            'buyer' => $this->session->userdata('user_id'),'sale_code'=>$ordid
             ))->result_array();
        $page_data['no']=$this->db->get_where('sale', array(
            'buyer' => $this->session->userdata('user_id'),'sale_code'=>$ordid
             ))->num_rows();
        $page_data['page_name']    = "order_track";
        $page_data['page_title']   = translate('order_track');
        $this->load->view('front/index', $page_data);
    }

    
    /* FUNCTION: Product rating*/
    function rating($product_id, $rating)
    {
        if ($this->session->userdata('user_login') != "yes") {
            redirect(base_url() . 'index.php/home/login/', 'refresh');
        }
        if ($rating <= 5) {
            if ($this->crud_model->set_rating($product_id, $rating) == 'yes') {
                echo 'success';
            } else if ($this->crud_model->set_rating($product_id, $rating) == 'no') {
                echo 'already';
            }
        } else {
            echo 'failure';
        }
    }
   
    /* FUNCTION: Concerning Compare*/
    function compare($para1 = "", $para2 = "")
    {
        if ($para1 == 'add') 
		{
            echo $this->crud_model->add_compare($para2);
        } 
		else if($para1 == 'add_web')
		{
			$this->crud_model->add_compare($para2);
			$this->session->set_flashdata('alert', 'compare_add');
			redirect(base_url('home/compare'));
		}
		else if ($para1 == 'remove') 
		{
			 echo $this->crud_model->remove_compare($para2);
        } 
		else if ($para1 == 'delete') 
		{
		   $this->crud_model->remove_compare($para2);
		   $this->session->set_flashdata('alert', 'compare_remove');
		   if(count($this->session->userdata('compare'))<=0)
		   {
              redirect(base_url());
           }
		   else
		   {
			redirect(base_url('home/compare'));
		   }
        } 
		else if ($para1 == 'num') 
		{
            echo $this->crud_model->compared_num();
        } 
		else if ($para1 == 'clear') 
		{
            $this->session->set_userdata('compare',array());
			$this->session->set_flashdata('alert', 'compare_empty');
            redirect(base_url());
        } 
		else if ($para1 == 'get_detail') 
		{
            $product = $this->db->get_where('product',array('product_id'=>$para2));
            $return = array();
            $return += array('image' => '<img src="'.$this->crud_model->file_view('product',$para2,'','','thumb','src','multi','one').'" width="100" />');
            $return += array('price' => currency().$product->row()->sale_price);
            $return += array('description' => $product->row()->description);

            if($product->row()->product_type=='0'){
                $return += array('type' => "New");
            }
             else{
                $return += array('type' => "Refurbished");
            }

            if($product->row()->brand){
                $return += array('brand' => $this->db->get_where('brand',array('brand_id'=>$product->row()->brand))->row()->name);
            }

            if($product->row()->sub_category)
			{
                $return += array('sub' => $this->db->get_where('sub_category',array('sub_category_id'=>$product->row()->sub_category))->row()->sub_category_name);
            }
            echo json_encode($return);
        } 
		else 
		{
            if(count($this->session->userdata('compare'))<=0)
			{
                redirect(base_url());
            }
			$com_prdts  = $this->session->userdata('compare');
			$scom_prdts = implode($com_prdts,',');
            $comp_data=$this->db->where_in('product_id', $com_prdts)->get('product')->result_array();
			$page_data['com_products']   = $comp_data;
			$page_data['other_products'] = $this->db->query("select product_id,title FROM product where status='ok' and admin_approved='1' and vendor_approved ='1' and product_id not in (".$scom_prdts.") order by title")->result_array();
            $page_data['page_name']  = "compare";
            $page_data['page_title'] = 'Compare';
            $this->load->view('front/index', $page_data);
        }
        
    }
	
    
    /* FUNCTION: Concering Add, Remove and Updating Cart Items*/
	function cart($para1 = '', $para2 = '', $para3 = '', $para4 = ''){
        if ($para1 == "added_list_mobile") 
		{
			$page_data['carted'] = $this->cart->contents();
            $this->load->view('front/added_list_mobile', $page_data);
		}
        if ($para1 == "add") 
		{
            $qty = $this->input->post('qty');
            $color = $this->input->post('color');
            $option = array('color'=>array('title'=>'Color','value'=>$color));
            $all_op = json_decode($this->crud_model->get_type_name_by_id('product',$para2,'options'),true);
            if($all_op)
			{
                foreach ($all_op as $ro) 
				{
                    $name = $ro['name'];
                    $title = $ro['title'];
                    $option[$name] = array('title'=>$title,'value'=>$this->input->post($name));
                }
            }

            if($para3 == 'pp') 
			{
                $carted = $this->cart->contents();
                foreach ($carted as $items) 
				{
                    if ($items['id'] == $para2) 
					{
                        $data = array(
                            'rowid' => $items['rowid'],
                            'qty' => 0
                        );
                    } else {
                        $data = array(
                            'rowid' => $items['rowid'],
                            'qty' => $items['qty']
                        );
                    }
                    $this->cart->update($data);
                }
            }
            $s_p            =   $this->crud_model->get_product_price($para2);
            $prdName        =   url_title($this->crud_model->get_type_name_by_id('product', $para2, 'title'));
            $prdImage       =   $this->crud_model->file_view('product', $para2, '', '', 'thumb', 'src', 'multi', 'one');
            $tax            =   $this->crud_model->get_product_tax($para2);
            $ship           =   $this->crud_model->get_shipping_cost($para2);
            $subTotal       =   ($s_p*$qty);
            $data = array(
                'id' => $para2, 'qty' => $qty, 'option' => json_encode($option),
                'price' => $s_p, 'name' => $prdName, 'shipping' => $ship,
                'tax' => $tax, 'image' => $prdImage, 'coupon' => '', 'shippingtax' =>'', 'coupon_discount' => ''
            );
            
            $stock = $this->crud_model->get_type_name_by_id('product', $para2, 'current_stock');
            if (!$this->crud_model->is_added_to_cart($para2) || $para3 == 'pp'){
                if ($stock >= $qty || $this->crud_model->is_digital($para2)){
                    $this->cart->insert($data);
                    if($this->session->userdata('user_login') == 'yes'){
                        $userId         =   $this->session->userdata('user_id');
                        $vendor         =   $this->db->join('vendor as V','C.id = V.country_code')->get_where('countries as C',['sortname'=>wh_country()->code])->row();
                        if($vendor){        $vendorId = $vendor->vendor_id; }else{ $vendorId = 0; }
                        $cart           =   $this->db->get_where('cart',['user_id'=>$userId])->row();
                        if($cart){ 
                            $cartId     =   $cart->cart_id; 
                            if($cart->status == 0){ $cartata = ['created_on'=>date('Y-m-d H:i:s'),'status'=>1]; }
                            else{ $cartata = ['modified_on'=>date('Y-m-d H:i:s')]; } $cartata['vendor_id'] = $vendorId;
                        }else{ 
                            $this->db->insert('cart',['user_id'=>$userId,'vendor_id'=>$vendorId]); 
                            $cartId = $this->db->insert_id(); $cartata = ['created_on'=>date('Y-m-d H:i:s')];
                        }
                     //   echo $this->db->last_query(); die;
                        $item           =   [
                                                'cart_id'=>$cartId,'product_id'=>$para2,'product_name'=>$prdName,'option'=>json_encode($option),
                                                'price'=>$s_p,'qty'=>$qty,'tax'=>$tax, 'image'=>$prdImage,'total'=>$subTotal,'created_on'=>date('Y-m-d H:i:s')
                                            ];  
                        if($this->db->get_where('cart_items',['cart_id'=>$cartId,'product_id'=>$para2])->num_rows() > 0){ 
                            $this->db->where(['cart_id'=>$cartId,'product_id'=>$para2])->update('cart_items',$item); $itemIns = false;
                        }else{ $this->db->insert('cart_items',$item); $itemIns = true; }
                        $cartata['amount']  =   $this->db->select_sum('price')->where(['cart_id'=>$cartId,'status'=>1])->get('cart_items')->row()->price;
                        $cartata['tax']     =   $this->db->select_sum('tax')->where(['cart_id'=>$cartId,'status'=>1])->get('cart_items')->row()->tax;
                        $cartata['g_total'] =   $this->db->select_sum('total')->where(['cart_id'=>$cartId,'status'=>1])->get('cart_items')->row()->total;
                        $this->db->where('cart_id',$cartId)->update('cart',$cartata);
                        if($itemIns){
                            if($this->db->get_where('cart_added_items',['user_id'=>$userId,'prd_id'=>$para2,'status'=>1])->num_rows() > 0){
                                $this->db->where(['user_id'=>$userId,'prd_id'=>$para2,'status'=>1])->update('cart_added_items',['removed'=>0]);
                            }else{
                              $this->db->insert('cart_added_items',['user_id'=>$userId,'prd_id'=>$para2,'added_on'=>date('Y-m-d H:i:s')]);  
                            }
                            $this->db->insert('cart_added_items_log',['user_id'=>$userId,'prd_id'=>$para2,'added_on'=>date('Y-m-d H:i:s')]); 
                        }
                    }


                    //echo 'added';
                    //edited on 3/01/2017
                    if ($para3 == 'pp') 
                    {
                       echo 'update';
                    }
                    else
					{
                    	echo 'added';
                    }
                } 
				else 
				{
                    echo 'shortage';
                }
            } else {
                echo 'already';
            }
          
        }
        
        if ($para1 == "added_list") 
		{
            $page_data['carted'] = $this->cart->contents();
            $this->load->view('front/added_list', $page_data);
        }
        
        if ($para1 == "empty") 
		{
            $this->cart->destroy();
            $this->session->set_userdata('couponer','');
            $this->clear_coupon();
            if($this->session->userdata('user_login') == 'yes'){
                $this->crud_model->clearCart('clear');
            }
        }
        
        if ($para1 == "quantity_update") 
		{
            //$this->session->set_userdata('ship_cost','0');
            $carted = $this->cart->contents();
            foreach ($carted as $items){
                if ($items['rowid'] == $para2){
                    $product = $items['id'];
                }
            }
            $current_quantity = $this->crud_model->get_type_name_by_id('product', $product, 'current_stock');
            $msg              = 'not_limit';
            
            foreach ($carted as $items) 
			{ 
                if ($items['rowid'] == $para2) 
				{ $qty = $para3;
                    if ($current_quantity >= $para3) 
					{
                        $data = array(
                            'rowid' => $items['rowid'],
                            'qty' => $para3
                        );
                    } 
					else 
					{ $qty = $current_quantity;
                        $msg  = $current_quantity;
                        $data = array(
                            'rowid' => $items['rowid'],
                            'qty' => $current_quantity
                        );
                    }
                } 
				else 
				{ $qty = $items['qty'];
                    $data = array(
                        'rowid' => $items['rowid'],
                        'qty' => $items['qty']
                    );
                }
                $this->cart->update($data);
                if($this->session->userdata('user_login') == 'yes'){
                    $userId         =   $this->session->userdata('user_id');
                    $cart           =   $this->db->get_where('cart',['user_id'=>$userId])->row();
                    if($cart){          $cartId = $cart->cart_id;
                        $price      =   $this->crud_model->get_product_price($product);
                        $tax        =   $this->crud_model->get_product_tax($product);
                        $total      =   ($price*$qty);
                        $itemData   =   ['price'=>$price,'tax'=>$tax,'qty'=>$qty,'total'=>$total,'updated_on'=>date('Y-m-d H:i:s')];
                        $this->db->where(['cart_id'=>$cart->cart_id,'product_id'=>$product])->update('cart_items',$itemData);
                        $cartata['amount']  =   $this->db->select_sum('price')->where(['cart_id'=>$cartId,'status'=>1])->get('cart_items')->row()->price;
                        $cartata['tax']     =   $this->db->select_sum('tax')->where(['cart_id'=>$cartId,'status'=>1])->get('cart_items')->row()->tax;
                        $cartata['g_total'] =   $this->db->select_sum('total')->where(['cart_id'=>$cartId,'status'=>1])->get('cart_items')->row()->total;
                        $cartata['modified_on'] =   date('Y-m-d H:i:s');
                        $this->db->where('cart_id',$cartId)->update('cart',$cartata);
                    }
                }
            }
            
            $return = '';
            $carted = $this->cart->contents();

            foreach ($carted as $items) 
			{
                if ($items['rowid'] == $para2) 
				{
                    $return = currency() . $items['subtotal'];
                }
            }
			$this->clear_coupon();
            $return .= '---' . $msg;
            echo $return;
        }

        if ($para1 == "remove_one") 
		{
            //$this->session->set_userdata('ship_cost','0');
            $carted = $this->cart->contents();
            foreach ($carted as $items){
                if ($items['rowid'] == $para2){
		    $prdId  =   $items['id'];	
                    $data = array(
                        'rowid' => $items['rowid'],
                        'qty' => 0
                    );
                } 
				else 
				{
                    $data = array('rowid' => $items['rowid'],'qty' => $items['qty']);
                }
                $this->cart->update($data);
            } 
                
            if($this->session->userdata('user_login') == 'yes'){
                $userId         =   $this->session->userdata('user_id');
                $cart           =   $this->db->get_where('cart',['user_id'=>$userId])->row();
                if($cart){ 
                    $cartId     =   $cart->cart_id; 
                    $this->db->where(['cart_id'=>$cartId,'product_id'=>$prdId])->delete('cart_items');
                    if($this->db->get_where('cart_items',['cart_id'=>$cartId])->num_rows() == 0){ $cartata['status'] = 0; }
                    $cartata['amount']  =   $this->db->select_sum('price')->where(['cart_id'=>$cartId,'status'=>1])->get('cart_items')->row()->price;
                    $cartata['tax']     =   $this->db->select_sum('tax')->where(['cart_id'=>$cartId,'status'=>1])->get('cart_items')->row()->tax;
                    $cartata['g_total']  =   $this->db->select_sum('total')->where(['cart_id'=>$cartId,'status'=>1])->get('cart_items')->row()->total;
                    $cartata['modified_on'] =   date('Y-m-d H:i:s');
                    $this->db->where('cart_id',$cartId)->update('cart',$cartata);
                }
                $this->db->where(['user_id'=>$userId,'prd_id'=>$prdId,'status'=>1])->update('cart_added_items',['removed'=>1,'removed_on'=>date('Y-m-d H:i:s')]);
                $this->db->where(['user_id'=>$userId,'prd_id'=>$prdId,'status'=>1])->update('cart_added_items_log',['removed_on'=>date('Y-m-d H:i:s')]);
          
            }

            $this->clear_coupon();
        }
        
        if ($para1 == 'calcs') 
		{
            $discount   =   $this->session->userdata()['cart_contents']['total_discount'];
            $total = $this->cart->total();
			$shipping=0;
			/*
            if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') 
			{
                $shipping = $this->crud_model->cart_total_it('shipping');
            } 
			elseif ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'fixed') 
			{
                $shipping = $this->crud_model->get_type_name_by_id('business_settings', '2', 'value');
            }*/
            $shipping       = $this->session->userdata('ship_cost');
            $tax            = $this->crud_model->cart_total_it('tax');
            $shipping_tax   = $this->crud_model->cart_total_it('shippingtax');
            $grand          = $total + $shipping + $tax + $shipping_tax;
            $total = $total+$discount;
            if ($para2 == 'full') 
			{
                $total = $this->cart->format_number($total);
                $ship  = $this->cart->format_number($shipping);
                $tax   = $this->cart->format_number($tax);
                $grand = $this->cart->format_number($grand);
                $count = count($this->cart->contents());
                $ship_tax = '';//$this->cart->format_number($shipping_tax);
                if ($total == '') {
                    $total = 0;
                }
                if ($ship == '') {
                    $ship = 0;
                }
                if ($tax == '') {
                    $tax = 0;
                }
                if ($grand == '') {
                    $grand = 0;
                }
                if ($ship_tax == '') {
                    $ship_tax = 0;
                }
                $total = currency() . ($total);
                $ship  = currency() . $shipping;
                $tax   = currency() . $tax;
                $grand = currency() . $grand;
                $ship_tax = currency() . $ship_tax;
                
                echo $total . '-' . $ship . '-' . $tax . '-' . $grand . '-' . $count.'-'.$ship_tax;
            }
            if ($para2 == 'prices') 
			{
                $carted = $this->cart->contents();
                $return = array();
                foreach ($carted as $row) 
				{
                    $return[] = array('id'=>$row['rowid'],'price'=>currency().$this->cart->format_number($row['price']),'subtotal'=>currency().$this->cart->format_number($row['subtotal']));
                }
                echo json_encode($return);
            }
        }
        
    }
	
    /* FUNCTION: Set Shipping Cost*/
    function ship_cost($cost,$method,$name,$shipcntry)
    { 
        $shippingtax= $this->crud_model->ship_tax($cost,$shipcntry);
        $row_id=substr($name, 2); 
        $tot_ship=0;
        $carted = $this->cart->contents();
        foreach($carted as  $item)
        { 
            if($item['rowid']==$row_id) 
            {
                $data = array(
                'rowid' =>$item['rowid'],
                'shipping' => $cost,
                'shipping_method'=>"$method",
                'shippingtax' => $shippingtax,
                );  
                $this->cart->update($data);
            }
            //$tot_ship=$tot_ship+$item['shipping'];
        }
        $carted1 = $this->cart->contents();
        foreach($carted1 as  $item1)
         {
            //  $tot_ship=$tot_ship+$item1['shipping'];
            $tot_ship=$cost;
         }
        $this->session->set_userdata(array('ship_cost'=> $tot_ship,));
        echo $tot_ship;
    }
    /* END FUNCTION: Set Shipping Cost*/
	
	//region tax
    function region_tax($region)
    { 
        //echo $region;
        $tot_shipping_tax=0;
        $carted = $this->cart->contents();
        foreach($carted as  $item)
        { 
          $prdid  = $item['id'];
          $prprice= $this->crud_model->get_product_price($prdid);
          $shippingtax=$this->crud_model->region_tax($prdid,$region,$prprice);
          $prprice=$prprice+$shippingtax; 
          $data = array('rowid' =>$item['rowid'],'price' => $prprice, );  
          $this->cart->update($data);
          $tot_shipping_tax=$tot_shipping_tax+$shippingtax; //}
        }
        //$carted1 = $this->cart->contents();
        //$this->session->set_userdata(array('shippingtax'=> $tot_shipping_tax,));
      echo $tot_shipping_tax;
    }
	
  	  //clear cart
	  function clear_cart()
	  {
		$carted = $this->cart->contents();
		foreach($carted as  $item)
		 {
			$para2= $item['id'];
			$qty  = $item['qty'];
			$custock = $this->crud_model->get_type_name_by_id('product', $para2, 'current_stock');
			if($custock < $qty)
			{
				$qty=$custock;
			}
			//$this->crud_model->is_digital($para2);
			$s_p=$this->crud_model->get_product_price($item['id']);
			$data = array(
					'rowid' =>$item['rowid'],
					'id' => $para2,
					'price' => $s_p,
					'qty' => $qty,
					'name' => $this->crud_model->get_type_name_by_id('product', $para2, 'title'),
					'shipping' => $this->crud_model->get_shipping_cost($para2),
					'tax' => $this->crud_model->get_product_tax($para2),
					'image' => $this->crud_model->file_view('product', $para2, '', '', 'thumb', 'src', 'multi', 'one'),
					'coupon' => '',
					'shippingtax' =>'',
					'coupon_discount' => ''
				);
			$this->cart->update($data);
		 }
	  }
    
    /*Cart Checkout Page*/
    function cart_checkout($para1 = "")
    {
		if ($this->session->userdata('user_login') != "yes") 
        {
            redirect(base_url('home/login/redirect?page=cart_checkout'), 'refresh');
        }
		$this->clear_cart();
		$this->clear_coupon();
        $carted = $this->cart->contents();
        if (count($carted) <= 0) 
        {
            $page_data['page_name']      = "cart_emty";
            $page_data['page_title']     = translate('my_cart');
            $this->load->view('front/index', $page_data);
        }
        else
        {
			$page_data['logger']     = $para1;
			$page_data['page_name']  = "cart";
			$page_data['page_title'] = translate('my_cart');
			$page_data['carted']     = $this->cart->contents();  
			
			
            $page_data['shpping_operators']=$this->crud_model->shipping_operators();
			
			$this->load->view('front/index', $page_data);
        }
    }
	
	//check out page
    function checkout($para1 = "")
    {
		if ($this->session->userdata('user_login') != "yes") 
        {
            redirect(base_url('home/login/redirect?page=cart_checkout'), 'refresh');
        }
        $carted = $this->cart->contents();
        if (count($carted) <= 0) 
        {
            $page_data['page_name']      = "cart_emty";
            $page_data['page_title']     = translate('my_cart');
            $this->load->view('front/index', $page_data);
        }
        else
        {
            $cc_code                 = wh_country()->code;
            $page_data['logger']     = $para1;
            $page_data['page_name']  = "check_out";
            $page_data['page_title'] = translate('checkout');
            $page_data['carted']     = $this->cart->contents();  
			$page_data['user_data']  = $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id') ))->row();
		     $country_id             = $this->db->where('sortname',$cc_code)->get('countries')->row()->id;
           $page_data['all_address'] =  $this->db->join('countries as C','A.country = C.id')
                                        ->get_where('user_address as A',['A.user_id'=>$this->session->userdata('user_id'), 'A.status' => 1,'A.country'=>$country_id])->result(); 
            $this->load->view('front/index', $page_data);
        }
    }
    
    
   	/* coupon check */
   	function coupon_check()
    {
        $para1 = $this->input->post('code');
        $carted = $this->cart->contents();
        if (count($carted) > 0) 
		{
            $discount=0;
            $p = $this->session->userdata('coupon_apply')+1;
            $this->session->set_userdata('coupon_apply',$p);
            $p = $this->session->userdata('coupon_apply');
            if($p < 10)
			{
                $c = $this->db->get_where('coupon',array('code'=>$para1,'status'=>'ok'));
                $coupon = $c->result_array();
                //echo $c->num_rows();
                //,'till <= '=>date('Y-m-d')
                if($c->num_rows() > 0)
				{
				    $abgroup=0; 
                    foreach ($coupon as $row) 
					{
                        $spec = json_decode($row['spec'],true);
                        $coupon_id = $row['coupon_id'];
                        $till = strtotime($row['till']);
                        if($row['abandoen_coupon']=='1')
                        {
                            $abuser_id=$this->session->userdata('user_id');
                            $abmember=$this->db->get_where('abandon_group_members',array('grp_coupon_id'=>$coupon_id,'member_user_id'=>$abuser_id,'grp_coupon_used'=>'0'));
                            if($abmember->num_rows()==0)
                            {
                                $abgroup=1;  
                            }
                        }
                    }
                    if($till > time() && $abgroup=='0')
					{
                        $ro = $spec;
                        $type = $ro['discount_type'];
                        $value = $ro['discount_value'];
                        $set_type = $ro['set_type'];
                        $set = json_decode($ro['set']);
                        if($set_type !== 'total_amount')
						{
                            $dis_pro = array();
                            $set_ra = array();
                            if($set_type == 'all_products')
							{
                                $set_ra[] = $this->db->get('product')->result_array();
                            } 
							else 
							{
                                foreach ($set as $p) 
								{
                                    if($set_type == 'product'){
                                        $set_ra[] = $this->db->get_where('product',array('product_id'=>$p))->result_array();
                                    } else {
                                        $set_ra[] = $this->db->get_where('product',array($set_type=>$p))->result_array();
                                    }
                                }
                            }
                            foreach ($set_ra as $set) 
							{
                                foreach ($set as $n) {
                                    $dis_pro[] = $n['product_id'];
                                }
                            }
                            $kj=0;$discnt=0;
                            foreach ($carted as $items) 
							{
                                if (in_array($items['id'], $dis_pro)) 
								{
									$discnt=0;
                                    $base_price = $this->crud_model->get_product_price($items['id']);
                                    if($type == 'percent')
									{
										$discnt=0;
                                        $cst        =   ($base_price*$items['qty']);
										$discnt		=   $cst*$value/100;
                                        $discount   =   $discount+($cst*$value/100);
                                    } 
									else if($type == 'amount') 
									{
                                        if($base_price > $value)
										{ 
											$discnt=0;
											$discnt		=   $value*$items['qty'];
											$discount   =   $discount+($value*$items['qty']); 
										}
                                    }
                                    $data = array(
                                        'rowid' => $items['rowid'],
                                        'price' => $items['price'],
										'coupon' => $coupon_id,
                                        'coupon_discount' => $discnt
                                    );

                                    $kj=1;
                                } 
								else 
								{
                                    $data = array('rowid' => $items['rowid'],'price' => $items['price'],'coupon' => '','coupon_discount'=>'');
                                }
                                $this->cart->update($data);
                            }
                            if ($kj==1) 
							{
                            	echo 'wise:-:-:'.translate('coupon_discount_activated').':-:-:'.currency().$discount;
                            }
                            else
                            {
                                   echo 'nope';
                            }
                        } 
                        else 
						{
                            $this->cart->set_discount($value);
                            echo 'total:-:-:'.translate('coupon_discount_activated').':-:-:'.currency().$value;
                        }
                        $this->cart->set_coupon($coupon_id);
                        $this->cart->set_discount($discount);
                        $this->session->set_userdata('couponer','done');
                        $this->session->set_userdata('coupon_apply',0);
                    } 
					else 
					{
                        echo 'nope';
                    }
                } 
				else 
				{
                    echo 'nope';
                }
            } 
			else 
			{
                echo 'Too many coupon request!';
            }
        }
    }
	
    function guest_check()
    {
        $gst = $this->input->post('guest_chk1');
        if($gst==1){
       $this->session->set_userdata(array(
                            'user_login'       => "yes",
                            'user_id'      => "0",
                            'user_name'       => "Guest"
                          
                    ));  
        echo "success";
        }
        else{
             $this->session->unset_userdata(array('user_login','user_id','user_name'));  
            echo "lgn";
        }
        
    }
	
    
    /* FUNCTION: Finalising Purchase*/
  	function cart_finish($para1 = "", $para2 = "")
    { 
        if ($this->session->userdata('user_login') == 'yes') 
		{
            $carted   = $this->cart->contents();
            $total    = $this->cart->total();
            $discount   =   $this->session->userdata()['cart_contents']['total_discount'];
            $exchange = $this->crud_model->get_type_name_by_id('business_settings', '8', 'value');
            $vat_per  = '';
            $vat      = $this->crud_model->cart_total_it('tax');
            $shipping_tax   = $this->crud_model->cart_total_it('shippingtax');
            /*
            if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
                $shipping = $this->crud_model->cart_total_it('shipping');
            } else {
                $shipping = $this->crud_model->get_type_name_by_id('business_settings', '2', 'value');
            } 
           */
            $shipping = $this->session->userdata('ship_cost'); 
            if($this->input->post('ship_method') == 'other_shiping')
            {
                $_POST['ship_method'] = $this->input->post('freight_agent');
                //$shipping   =   0;
            }
            $grand_total     = $total + $vat + $shipping+$shipping_tax;
            $product_details = json_encode($carted);
            
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->update('user', array('langlat' => $this->input->post('langlat')));
            
			if ($this->input->post('payment_type') == 'cash_on_delivery' || $this->input->post('payment_type') == 'manual_invoice') 
			{
                if ($para1 == 'go') 
				{
                    $data['buyer']             = $this->session->userdata('user_id');
                    $data['product_details']   = $product_details;
                    $data['shipping_address']  = json_encode($_POST);
                    $data['vat']               = $vat;
                    $data['vat_percent']       = $vat_per;
                    $data['shipp_tax']         = $shipping_tax;
                    $data['shipping']          = $shipping;
                    $data['delivery_status']   = 'pending';
                    $data['payment_type']      = $this->input->post('payment_type');
                    $data['payment_status']    = '[]';
                    $data['payment_details']   = '';
                    $data['discount']          = $discount;
                    $data['grand_total']       = $grand_total;
                    $data['sale_datetime']     = date('Y-m-d H:i:s');
                    $data['delivary_datetime'] = '';
                    $adrs_flag = $this->input->post('add_address');
                    if($adrs_flag=="on")
                    {
                        $adrs['user_id']        = $this->session->userdata('user_id');
                        $adrs['fname']          = $this->input->post('sfirstname');
                        $adrs['lname']          = $this->input->post('slastname');
                        $adrs['city']           = $this->input->post('scity');
                        $adrs['address1']       = $this->input->post('saddress1');
                        $adrs['address2']       = $this->input->post('saddress2');
                        $adrs['country_code']   = $this->input->post('scountry');
                        $adrs['state_code']     = $this->input->post('sstate');
                        $adrs['zip']            = $this->input->post('szip');
                        $adrs['phone']          = $this->input->post('sphone');
                        $adrs['email']          = $this->input->post('semail');
                        $this->db->insert('user_address', $adrs);
                    }
                    $data['delivery_status'] = 'pending';
                    $data['vendor_id']  =   $this->db->get_where('cart',['user_id'=>$this->session->userdata('user_id'),'status'=>1])->row()->vendor_id;
                    $this->db->insert('sale', $data);
                    $sale_id           = $this->db->insert_id();
                    $vendors = $this->crud_model->vendors_in_sale($sale_id);
                    $delivery_status = array();
                    $payment_status = array();
                    foreach ($vendors as $p) {
                        $delivery_status[] = array('vendor'=>$p,'status'=>'pending','delivery_time'=>'');
                        $payment_status[] = array('vendor'=>$p,'status'=>'due');
                    }
                    if($this->crud_model->is_admin_in_sale($sale_id)){
                        $delivery_status[] = array('admin'=>'','status'=>'pending','delivery_time'=>'');
                        $payment_status[] = array('admin'=>'','status'=>'due');
                    }
                    $data['sale_code'] = date('Ym', strtotime($data['sale_datetime'])) . $sale_id;
                    $data['delivery_status'] = json_encode($delivery_status);
                    $data['payment_status'] = json_encode($payment_status);
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sale', $data);
                    
                    foreach ($carted as $value) {
                        $this->crud_model->decrease_quantity($value['id'], $value['qty']);
                        $data1['type']         = 'destroy';
                        $data1['category']     = $this->db->get_where('product', array(
                            'product_id' => $value['id']
                        ))->row()->category;
                        $data1['sub_category'] = $this->db->get_where('product', array(
                            'product_id' => $value['id']
                        ))->row()->sub_category;
                        $data1['product']      = $value['id'];
                        $data1['quantity']     = $value['qty'];
                        $data1['total']        = 0;
                        $data1['reason_note']  = 'sale';
                        $data1['sale_id']      = $sale_id;
                        $data1['datetime']     = time();
                        $this->db->insert('stock', $data1);
                    }
                    $this->crud_model->digital_to_customer($sale_id);
                    $this->crud_model->email_invoice($sale_id, $this->input->post('email'));
                    $this->cart->destroy();
                    $this->session->set_userdata('couponer','');
                    //echo $sale_id;
                    $this->crud_model->update_erp_tables($sale_id);
                    redirect(base_url() . 'index.php/home/invoice/' . $sale_id, 'refresh');
                }
            } 
            else if ($this->input->post('payment_type') == 'payfort') 
			{
                if ($para1 == 'go') 
				{
                    $data['buyer']             = $this->session->userdata('user_id');
                    $data['product_details']   = $product_details;
                    $data['shipping_address']  = json_encode($_POST);
                    $data['vat']               = $vat;
                    $data['vat_percent']       = $vat_per;
                    $data['shipp_tax']         = $shipping_tax;
                    $data['shipping']          = $shipping;
                    $data['delivery_status']   = 'pending';
                    $data['payment_type']      = 'payfort';
                    $data['payment_status']    = '[]';
                    $data['payment_details']   = '';
                    $data['discount']          = $discount;
                    $data['grand_total']       = $grand_total;
                    $data['sale_datetime']     = date('Y-m-d H:i:s');
                    $data['delivary_datetime'] = '';
                    $adrs_flag = $this->input->post('add_address');
                    if($adrs_flag=="on")
                    {
                        $adrs['user_id']        = $this->session->userdata('user_id');
                        $adrs['fname']          = $this->input->post('sfirstname');
                        $adrs['lname']          = $this->input->post('slastname');
                        $adrs['city']           = $this->input->post('scity');
                        $adrs['address1']       = $this->input->post('saddress1');
                        $adrs['address2']       = $this->input->post('saddress2');
                        $adrs['country_code']   = $this->input->post('scountry');
                        $adrs['state_code']     = $this->input->post('sstate');
                        $adrs['zip']            = $this->input->post('szip');
                        $adrs['phone']          = $this->input->post('sphone');
                        $adrs['email']          = $this->input->post('semail');
                        $this->db->insert('user_address', $adrs);
                    }
                    $data['delivery_status'] = 'pending';
            $data['vendor_id']  =   $this->db->get_where('cart',['user_id'=>$this->session->userdata('user_id'),'status'=>1])->row()->vendor_id;
                    $this->db->insert('sale', $data);
                    $sale_id           = $this->db->insert_id();
                    $vendors = $this->crud_model->vendors_in_sale($sale_id);
                    $delivery_status = array();
                    $payment_status = array();
                    foreach ($vendors as $p) {
                        $delivery_status[] = array('vendor'=>$p,'status'=>'pending','delivery_time'=>'');
                        $payment_status[] = array('vendor'=>$p,'status'=>'due');
                    }
                    if($this->crud_model->is_admin_in_sale($sale_id)){
                        $delivery_status[] = array('admin'=>'','status'=>'pending','delivery_time'=>'');
                        $payment_status[] = array('admin'=>'','status'=>'due');
                    }
                    $data['sale_code'] = date('Ym', strtotime($data['sale_datetime'])) . $sale_id;
                    $data['delivery_status'] = json_encode($delivery_status);
                    $data['payment_status'] = json_encode($payment_status);
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sale', $data); 
                    $this->session->set_userdata('payfort_email', $this->input->post('email'));
                    redirect(base_url() .'payfort/?sl='.base64_encode($sale_id));
                }
             }
            
          
            
        } 
	  	else 
		{
            //echo 'nope';
            redirect(base_url() . 'home/cart_checkout/need_login', 'refresh');
        }
        
    }
    
    
    
    /*Brand list on home page*/
    function brands($para1 = '', $para2 = '')
    {
        $page_data['page_name']  = 'brands';
        //$page_data['all_brands'] = $this->db->get('brand')->result_array();
        $page_data['page_title']  = 'Brands';  
        $this->load->view('front/index', $page_data);    
    }
	
    /*Brand wise product listing*/
    function brand($para1 = '')
    {
		
        $page_data['brand_data'] = $this->db->get_where('product',array('brand'=>$para1,'status' => 'ok'))->result_array();
        if($page_data['brand_data'])
		{
			$page_data['b_id']=$para1;
        	$page_data['page_name']  = 'brand';
        	$brand_detail=$this->db->get_where('brand',array('brand_id'=>$para1))->row();
			$page_data['brand_detail']  = $brand_detail;
        	$page_data['page_title']  = translate($brand_detail->name);
        	$this->load->view('front/index', $page_data);
		}
		else
		{
			redirect('home/brands');
		}
		 
    }
    
    
    /*Advanced Search*/
    function advance_search($para1 = "", $para2 = "", $min = "", $max = "", $text ='')
    {
   		if ($para2 == "") 
		{
            $page_data['all_products'] = $this->db->get_where('product', array(
                'category' => $para1
            ))->result_array();
        } else if ($para2 != "") {
            $page_data['all_products'] = $this->db->get_where('product', array(
                'sub_category' => $para2
            ))->result_array();
        }
        $page_data['range']            = $min . ';' . $max;
        $page_data['page_name']        = "product_list";
        $page_data['page_title']       = translate('products');
        $page_data['all_category']     = $this->db->get('category')->result_array();
        $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
        $page_data['cur_sub_category'] = $para2;
        $page_data['cur_category']     = $para1;
        $page_data['text']             = $text;
        $page_data['category_data']    = $this->db->get_where('category', array(
            'category_id' => $para1
        ))->result_array();
          $this->load->view('front/advance_search', $page_data);
     }
       
    
    
    
    /* FUNCTION: Concerning wishlist*/
    function wishlist($para1 = "", $para2 = "")
    {
        if ($para1 == 'add') {
            $this->crud_model->add_wish($para2);
        } else if ($para1 == 'remove') {
            $this->crud_model->remove_wish($para2);
        } else if ($para1 == 'num') {
            echo $this->crud_model->wished_num();
        }
        
    }
    
    /* FUNCTION: Loads Contact Page */
    function blog($para1 = "")
    {
        $f_o        = '<ul class="pagination pagination-v2">';
        $f_c        = '</ul>';
        $other      = '<li>#</li>';
        $current    = '<li class="active"><a>#</a></li>';
        if($para1 == 'all'){
            $page_data['blogs'] = $this->crud_model->pagination('blog','6','home/blog/'.$para1.'/',$f_o,$f_c,$other,$current,'4','desc');
        } else {
            $page_data['blogs'] = $this->crud_model->pagination('blog','6','home/blog/'.$para1.'/',$f_o,$f_c,$other,$current,'4','desc',array('blog_category'=>$para1));
        }
        $page_data['page_name']   = 'blog';
        $page_data['page_title']  = translate('blog');
        $this->load->view('front/index.php', $page_data);   
    }
    
    /* FUNCTION: Loads Contact Page */
   function blog_view($para1 = "")
    {
        $page_data['blog']  = $this->db->get_where('blog',array('blog_id'=>$para1))->result_array();	
		
        $this->db->where('blog_id', $para1);
        $this->db->update('blog', array(
            'number_of_view' => 'number_of_view' + 1
        ));
        $page_data['page_name']  = 'blog_view';
        $page_data['page_title']  = $this->db->get_where('blog',array('blog_id'=>$para1))->row()->title;
        $this->load->view('front/index.php', $page_data);   
    }
    
    
    /* FUNCTION: Check if Customer is logged in*/
    function check_login($para1 = "")
    {
        if ($para1 == 'state') {
            if ($this->session->userdata('user_login') == 'yes') {
                echo 'hypass';
            }
            if ($this->session->userdata('user_login') !== 'yes') {
                echo 'nypose';
            }
        } else if ($para1 == 'id') {
            echo $this->session->userdata('user_id');
        } 
		else if($para1 == 'wished')
        {
            echo $this->crud_model->user_wished();
        }
        else if ($para1 == 'carted') {
            echo $this->session->userdata('cart_cont');
        }
        else 
		{
            echo $this->crud_model->get_type_name_by_id('user', $this->session->userdata('user_id'), $para1);
        }
    }
    
    /* FUNCTION: Legal pages load - terms & conditions / privacy policy*/
    function legal($type = "")
    {
        $page_data['type']       = $type;
        $page_data['page_name']  = "legal";
		$page_title=translate($type);
		$page_title=($type=='terms_conditions')?translate('terms & conditions'):$page_title;
		$page_title=($type=='shipping_handling')?translate('shipping & handling'):$page_title;
		$page_title=($type=='refund_cancellation_policy')?translate('refund_&_cancellation_policy'):$page_title;
		$page_title=($type=='cancellation_replacement_policy')?translate('cancellation_&_replacement_policy'):$page_title;
        $page_data['page_title'] = $page_title;
		
        $this->load->view('front/index', $page_data);
    }
    
    /* FUNCTION: Price Range Load by AJAX*/
    function get_ranger($by = "", $id = "", $start = '', $end = '')
    {
        $min = $this->get_range_lvl($by, $id, "min");
        $max = $this->get_range_lvl($by, $id, "max");
        if ($start == '') {
            $start = $min;
        }
        if ($end == '') {
            $end = $max;
        }
        
        $return = '' . '<input type="text" id="rangelvl" value="" name="range" />' . '<script>' . '	$("#rangelvl").ionRangeSlider({' . '		hide_min_max: false,' . '		keyboard: true,' . '		min:' . $min . ',' . '		max:' . $max . ',' . '		from:' . $start . ',' . '		to:' . $end . ',' . '		type: "double",' . '		step: 1,' . '		prefix: "'.currency().'",' . '		grid: true,' . '		onFinish: function (data) {' . "			filter('click','none','none','0');" . '		}' . '	});' . '</script>';
        return $return;
    }
    
    /* FUNCTION: Price Range Load by AJAX*/
    function get_range_lvl($by = "", $id = "", $type = "")
    {
        if ($type == "min") {
            $set = 'asc';
        } elseif ($type == "max") {
            $set = 'desc';
        }
        $this->db->limit(1);
        $this->db->order_by('sale_price', $set);
        if (count($a = $this->db->get_where('product', array(
            $by => $id
        ))->result_array()) > 0) {
            foreach ($a as $r) {
                return $r['sale_price'];
            }
        } else {
            return 0;
        }
    }
    
    /* FUNCTION: AJAX loadable scripts*/
    function others($para1 = "", $para2 = "", $para3 = "", $para4 = "")
    {
        if ($para1 == "get_sub_by_cat") {
            $return = '';
            $subs   = $this->db->get_where('sub_category', array(
                'category' => $para2
            ))->result_array();
            foreach ($subs as $row) {
                $return .= '<option  value="' . $row['sub_category_id'] . '">' . ucfirst($row['sub_category_name']) . '</option>' . "\n\r";
            }
            echo $return;
        } else if ($para1 == "get_range_by_cat") {
            if ($para2 == 0) {
                echo $this->get_ranger("product_id !=", "", $para3, $para4);
            } else {
                echo $this->get_ranger("category", $para2, $para3, $para4);
            }
        } else if ($para1 == "get_range_by_sub") {
            echo $this->get_ranger("sub_category", $para2);
        } else if($para1 == 'text_db'){
            echo $this->db->set_update('front/index', $para2);
        } else if ($para1 == "get_home_range_by_cat") {
            echo round($this->get_range_lvl("category", $para2, "min"));
            echo '-';
            echo round($this->get_range_lvl("category", $para2, "max"));
        } else if ($para1 == "get_home_range_by_sub") {
            echo round($this->get_range_lvl("sub_category", $para2, "min"));
            echo '-';
            echo round($this->get_range_lvl("sub_category", $para2, "max"));
        }
    }


	/*otp */
    function gt_otp($email)
	{
     
		 // generate OTP
				$email= urldecode($email);
			 $otp_to_mail=mt_rand(10000,1000000);
		  // create database entry for mail and OTP
      
        $data['email']=$email;
        $data['otp_in']=$otp_to_mail;
        $data['status']='inactive';
        if($data['email'] && $data['otp_in']){
      
        $this->db->insert('otp_data', $data);
           echo "inserted"; 
        
        }
        else
        {
          echo "nil";  
        }
        $subject="OTP -Service Request Mail verififcation";
        $text="<br><br>Thank you for using Marinecart Service Request System 

        <br><br>Your Mail verification OTP: ".$otp_to_mail;
         
			 $this->email_model->do_email($text, $subject, $email, $from);        
        //echo "nop";
        
    }
    /*end otp */
    
    
   function check_otp($otp_test)
   {
       $entered_otp=$otp_test;
       if($entered_otp)
	   {
          
           
			$this->db->select('otp_in,otp_id,status');
			$this->db->from('otp_data');
			$this->db->where('otp_in = '.$entered_otp);
			$query = $this->db->get();
			$otp_db= $query->result_array();
			foreach($otp_db as $otp_name)
			 {
				 $cname=$otp_name['otp_in'];
				 $cid=$otp_name['otp_id'];
			 }

			if($cname==$entered_otp)
              {
				echo "match";
				 $this->db->where('otp_id', $cid);
				$this -> db -> delete('otp_data');
           	  }
           else
               echo "mismatch";
        }
   }
    
		/*compare count*/
		function compareCount()
		{

   			$count= $this->crud_model->compared_num();
			echo $count;
		}
		/*end compare count*/




public function getUserEmail()
    {

if ( !isset($_GET['term']) )
    exit;
    $term = $_REQUEST['term'];
    $cat = $_REQUEST['cate'];
        $data = array();
     //   $rows = $this->myapp_model->getUser($term,$cat);
      //      foreach( $rows as $row )
      //      {
      //          $data[] = array(
     //               'label' => $row->title,
      //              'value' => $row->title);   // here i am taking name as value so it will display name in text field, you can change it as per your choice.
      //      }
    $prdNames   =   $this->myapp_model->getList($term,'title');
        if($prdNames){
            foreach( $prdNames as $prdName )
            {
                $data[] = array(
                    'label' => $prdName->title,
                    'value' => $prdName->title,
                    'type'  => 'product');   // here i am taking name as value so it will display name in text field, you can change it as per your choice.
            }
        }
        $itemCodes   =   $this->myapp_model->getList($term,'product_code');
        if($itemCodes){
            foreach( $itemCodes as $itemCode )
            {
                $data[] = array(
                    'label' => $itemCode->product_code,
                    'value' => $itemCode->product_code,
                    'type' => 'product');   // here i am taking name as value so it will display name in text field, you can change it as per your choice.
            }
        }
        $itemTypes   =   $this->myapp_model->getList($term,'item_type');
        if($itemTypes){
            foreach( $itemTypes as $itemType )
            {
                $data[] = array(
                    'label' => $itemType->item_type,
                    'value' => $itemType->item_type,
                    'type' => 'product');   // here i am taking name as value so it will display name in text field, you can change it as per your choice.
            }
        }
        $brands     =   $this->myapp_model->getBrands($term,$cat);
        if($brands){
            foreach($brands as $brand){
                $data[] = array(
                    'label' => $brand->name,
                    'value' => $brand->name,
                    'type'  => 'brand');
            }
        }
        echo json_encode($data);
        flush();

}

	/* Check Country Restriction */
    function check_resriction($cid)
    {
        $flag=0;
        $carted = $this->cart->contents();
        //var_dump($carted);
        foreach ($carted as $row) {
        $pid=$row['id'];
        $this->db->select("restricted_country");
        $this->db->from('product');
        $this->db->where('product_id = '.$pid);
        $query = $this->db->get();
        $country_db= $query->result_array();
            $r_contries=$country_db[0]['restricted_country'];
            if($r_contries!="")
            {
            $array=json_decode($r_contries,true);
            if (in_array("$cid", $array)) {
                $flag=1;
            }
            }
        }
        if($flag==1)
        {
            echo "nop";
        }
        else{
            echo "yep";
        }

    }
    /* Check Country Restriction */

    //GET CITIES
    function get_cities($cr_id)
	{
        
	 	$this->db->select("fed_country.iso_code_2,fed_zone.*");
	  	$this->db->from('fed_zone');
	  	$this->db->join('fed_country', 'fed_country.country_id = fed_zone.country_id');
	 	$this->db->where('fed_zone.country_id = '.$cr_id);
	  	$query = $this->db->get();
	  	$states_db= $query->result_array();
        
        //$states_db = $this->db->get_where('fed_zone',array('country_id'=>$cr_id))->result_array();
        echo json_encode($states_db);
    }
    //ENDS GET CITIES
    //SITEMAP
    /*function sitemap(){
        $otherurls = array(
                        base_url().'index.php/home/contact/',
                        base_url().'index.php/home/legal/terms_conditions',
                        base_url().'index.php/home/legal/privacy_policy'
                    );
        $producturls = array();
        $products = $this->db->get_where('product',array('status'=>'ok'))->result_array();
        foreach ($products as $row) {
            $producturls[] = $this->crud_model->product_link($row['product_id']);
        }
        $vendorurls = array();
        $vendors = $this->db->get_where('vendor',array('status'=>'approved'))->result_array();
        foreach ($vendors as $row) {
            $vendorurls[] = $this->crud_model->vendor_link($row['vendor_id']);
        }
        $page_data['otherurls']  = $otherurls;
        $page_data['producturls']  = $producturls;
        $page_data['vendorurls']  = $vendorurls;
        $this->load->view('front/sitemap', $page_data);
    }*/

	//captcha VALIDATION

    function captcha_refresh()
    {
        // Captcha configuration
        $config = array(
            'img_path'      => 'captcha_images/',
            'img_url'       => base_url().'captcha_images/',
            'img_width'     => '150',
            'img_height'    => 50,
            'word_length'   => 5,
            'font_path'  => 'uploads/product_image/Dink.ttf',
            'font_size'     =>20,
            'expiration'    =>1800,
            'colors'        => array(
                //'background' => array(0, 0, 0),
                'border' => array(0, 122, 255),#007BFF
                'text' => array(50, 50, 50),
                'grid' => array(255, 40, 40)
                )
        );
        $captcha = create_captcha($config);
        
        // Unset previous captcha and store new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode',$captcha['word']);
        
        // Display captcha image
        echo $captcha['image'];
    }

	public function validate_captcha()
    {
		if($this->input->post('captcha') != $this->session->userdata['captchaCode'])
		{

			$this->form_validation->set_message('validate_captcha', 'Wrong captcha code');
			return false;
		}else{
			return true;
		}
    }

	//review code
    function gt_code($email)
    {
        $email= urldecode($email);
        $otp_to_mail=mt_rand(10000,1000000);
        $data['email']=$email;
        $data['otp_in']=$otp_to_mail;
        $data['status']='inactive';
        if($data['email'] && $data['otp_in']){
        $this->db->insert('otp_data', $data);
           echo "inserted"; 
        }
        else
        {
          echo "nil";  
        }
        $subject="Product Review - Mail Verification Code ";
        $text="<br><br>
        Thank you for your Review ....
        <br><br>Your Mail verification Code: ".$otp_to_mail;
        $this->email_model->do_email($text, $subject, $email, $from);        
    }
	






	
	//sale place
	function sale_place(){ 
		//print_r($_POST);
		//echo 'working on';
		if ($this->session->userdata('user_login') == 'yes') 
        {
            $carted   = $this->cart->contents();
            $total    = $this->cart->total();
           // $exchange = exchange('usd');
            $exchange = 1;
            $discount = $this->session->userdata()['cart_contents']['total_discount'];
			$vat      = $this->crud_model->cart_total_it('tax');
			$shipping =0;
            /*if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') 
			{
                $shipping = $this->crud_model->cart_total_it('shipping');
            } 
			else 
			{
                $shipping = $this->crud_model->get_type_name_by_id('business_settings', '2', 'value');
            } */
            
	//		echo '<pre>'; print_r($this->input->post()); echo '</pre>'; die;
	        $shipping       = $this->session->userdata('ship_cost');
			$grand_total = ($total+$vat+$shipping);
			$min_days=$max_days=$exp_date='';
            if($this->session->userdata('ship_zone')>0)    
            {
                $shipZoneqr=$this->db->where(array('id'=>$this->session->userdata('ship_zone'),'status'=>'1'))->get('shipping_zones');
                if($shipZoneqr->num_rows()>0)
                {
                    $zonedata=$shipZoneqr->row();
                    $min_days=$zonedata->min_days;
                    $max_days=$zonedata->max_days;
                    $cuDate = date('Y-m-d'); 
                    $exp_date=date('Y-m-d', strtotime($cuDate. ' + '.$max_days.' days -1 day'));
                }
            }
            $shipping_detail  = array(
                'operator_id'=>$this->input->post('shipping_operator'),
                'zone_id'=>$this->session->userdata('ship_zone'),
                'delivery_from'=>$min_days,
                'delivery_to'=>$max_days,
                'shipping_fee'=>$this->session->userdata('ship_cost'),
                'expected_date'=>$exp_date
            );
            $product_details = json_encode($carted);
			$data=array();
			$data['buyer']             = $this->session->userdata('user_id');
            $data['product_details']   = $product_details;
            $data['shipping_address']  = json_encode($_POST);
			$data['delivery_status']   = 'pending';
			$data['payment_status']    = '[]';
			$data['payment_type']      = $this->input->post('payment_type'); 
            $data['payment_details']   = '';
			$data['discount']          = $discount;
			$data['vat']               = $vat;
            $data['shipping']          = $shipping;
            $data['shipping_detail']   = json_encode($shipping_detail);
            $data['total_amount']       = ($grand_total+$discount);
            $data['grand_total']        =   $grand_total;
            $data['sale_datetime']     = date('Y-m-d H:i:s');
            $data['delivary_datetime'] = '';
            if ($this->input->post('payment_type') == 'paypal') {
       //     if ($para1 == 'go') {

                $data['delivery_status'] = 'pending';
                $data['payment_status'] = '[]';
                $data['payment_details'] = 'none';
                $data['grand_total'] = $grand_total;
                $data['sale_datetime'] = date('Y-m-d H:i:s');
                $data['delivary_datetime'] = '';
                $paypal_email = $this->crud_model->get_type_name_by_id('business_settings', '1', 'value');
                $data['delivery_status'] = 'pending';
            $data['vendor_id']  =   $this->db->get_where('cart',['user_id'=>$this->session->userdata('user_id'),'status'=>1])->row()->vendor_id;
                $this->db->insert('sale', $data);
                $sale_id = $this->db->insert_id();

                if ($this->session->userdata('user_login') == 'yes') {
                    $data['buyer'] = $this->session->userdata('user_id');
                } else {
                    $data['buyer'] = "guest";
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < 10; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    $data['guest_id'] = $sale_id . '-' . $randomString;
                }

                $vendors = $this->crud_model->vendors_in_sale($sale_id);
                $delivery_status = array();
                $payment_status = array();
                foreach ($vendors as $p) {
                    $delivery_status[] = array('vendor' => $p, 'status' => 'pending', 'comment' => '', 'delivery_time' => '');
                    $payment_status[] = array('vendor' => $p, 'status' => 'due');
                }
                if ($this->crud_model->is_admin_in_sale($sale_id)) {
                    $delivery_status[] = array('admin' => '', 'status' => 'pending', 'comment' => '', 'delivery_time' => '');
                    $payment_status[] = array('admin' => '', 'status' => 'due');
                }
                $data['sale_code'] = date('Ym', strtotime($data['sale_datetime'])) . $sale_id;
                $data['delivery_status'] = json_encode($delivery_status);
                $data['payment_status'] = json_encode($payment_status);
                $this->db->where('sale_id', $sale_id);
                $this->db->update('sale', $data);

                $this->session->set_userdata('sale_id', $sale_id);
    
                /****TRANSFERRING USER TO PAYPAL TERMINAL****/
                $this->paypal->add_field('rm', 2);
                $this->paypal->add_field('no_note', 0);
                $this->paypal->add_field('cmd', '_cart');
                $this->paypal->add_field('upload', '1');
                $i = 0;

                // echo "<pre>";
                // print_r($carted);
                // echo "</pre>";
                // exit;

                foreach ($carted as $val) { $i++;
                    if($val['coupon_discount'] != '' && $val['coupon_discount'] > 0){ $cpDisc =   $val['coupon_discount']; }else{ $cpDisc = 0; }
                    $this->paypal->add_field('item_number_' . $i, $i);
                    $this->paypal->add_field('item_name_' . $i, $val['name']);
                    //$this->paypal->add_field('amount_' . $i, $this->cart->format_number(($val['price'] / $exchange)));
                    $this->paypal->add_field('amount_' . $i, ($val['price']-$cpDisc) / $exchange);
                    if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
                        //$this->paypal->add_field('shipping_' . $i, $this->cart->format_number((($val['shipping'] / $exchange) * $val['qty'])));
                        $this->paypal->add_field('shipping_' . $i, ($val['shipping'] / $exchange) * $val['qty']);
                    }
                    //$this->paypal->add_field('tax_' . $i, $this->cart->format_number(($val['tax'] / $exchange)));
                    $this->paypal->add_field('tax_' . $i, $val['tax'] / $exchange);
                    $this->paypal->add_field('quantity_' . $i, $val['qty']);
                    $this->paypal->add_field('discount_' . $i, $val['discount']);
                   
                }

                if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'fixed') {
                    $this->paypal->add_field('shipping_1', $this->cart->format_number(($this->crud_model->get_type_name_by_id('business_settings', '2', 'value') / $exchange)));
                }
                //$this->paypal->add_field('amount', $grand_total);
                //$this->paypal->add_field('currency_code', 'currency_code()');
                $this->paypal->add_field('custom', $sale_id);
                $this->paypal->add_field('business', $paypal_email);
                $this->paypal->add_field('notify_url', base_url() . 'home/paypal_ipn');
                $this->paypal->add_field('cancel_return', base_url() . 'home/paypal_cancel');
                $this->paypal->add_field('return', base_url() . 'home/paypal_success');
            //    echo '<pre>'; print_r($this->paypal->fields); echo '</pre>'; die;
                $this->paypal->submit_paypal_post(); 
                // submit the fields to paypal
         //   }
        }else if ($this->input->post('payment_type') == 'cod') {
            $vendor                     =   $this->db->join('countries as C','V.country_code = C.id')->get_where('vendor as V',['C.sortname'=>wh_country()->code])->row();
            if($vendor){ $vendorId      =   $vendor->vendor_id; }else{ $vendorId = 0; }
            $data['vendor_id']          =   $vendorId;
            $data['delivery_status']    =   'pending';
            $data['payment_status']     =   json_encode([['vendor'=>$vendorId,'status'=>'due']]);
            $this->db->insert('sale', $data);
            $sale_id                    =   $this->db->insert_id();
            $this->db->where('sale_id', $sale_id)->update('sale', ['sale_code'=>date('Ym', strtotime($data['sale_datetime'])) . $sale_id]);
            foreach($carted as $value){ $data1=array();
                $this->crud_model->decrease_quantity($value['id'], $value['qty']);
                $data1['type']         =   'destroy';
                $data1['category']     =   $this->db->get_where('product',['product_id' => $value['id']])->row()->category;
                $data1['product']      =   $value['id'];
                $data1['quantity']     =   $value['qty'];
                $data1['total']        =   0;
                $data1['reason_note']  =   'sale';
                $data1['sale_id']      =   $sale_id;
                $data1['datetime']     =   time();
                $this->db->insert('stock', $data1);
             }
             $this->crud_model->email_invoice($sale_id, $this->input->post('email'));
            $this->cart->destroy();
            $this->crud_model->clearCart('sale');
            $this->session->set_userdata('couponer','');
            redirect(base_url() . 'home/invoice/' . $sale_id, 'refresh');
        }else{
            if($this->input->post('pass_type') == 'ajax'){ $data['status'] = 0; }
            $data['delivery_status'] = 'pending';
            $data['vendor_id']  =   $this->db->get_where('cart',['user_id'=>$this->session->userdata('user_id'),'status'=>1])->row()->vendor_id;
			$this->db->insert('sale', $data);
            $sale_id           = $this->db->insert_id();
            $vendors = $this->crud_model->vendors_in_sale($sale_id);
            $delivery_status = array();
            $payment_status = array();
            foreach ($vendors as $p) 
            {
                $delivery_status[] = array('vendor'=>$p,'status'=>'pending','delivery_time'=>'');
                $payment_status[]  = array('vendor'=>$p,'status'=>'due');
				$sale_receipt 	   = array('vendor_id'=>$p,'sale_id'=>$sale_id,'vendor_type'=>'1');
				$sale_receipt['receipt_total']=$this->input->post('ventotal_'.$p);
				$this->db->insert('sale_receipt',$sale_receipt);
				$receipt_id        = $this->db->insert_id();
				//$this->crud_model->file_up('receipt_'.$p, 'user', $receipt_id);
				
				$upfile      =   $_FILES['receipt_'.$p]['name'];
//            	$tempName    =   $_FILES['receipt_'.$p]['tmp_name'];
//            	$ext         =   pathinfo($upfile,PATHINFO_EXTENSION);
//            	$source      =   'sale_receipt_'.$receipt_id.'.'.$ext;
//            	move_uploaded_file($_FILES['receipt_'.$p]['tmp_name'],'uploads/sale_receipt/'.$source);
//           		$this->db->where('sale_receipt_id',$receipt_id)->update('sale_receipt',array('receipt'=>$source));
            }
            if($this->crud_model->is_admin_in_sale($sale_id))
            {
                $delivery_status[] = array('admin'=>'','status'=>'pending','delivery_time'=>'');
                $payment_status[]  = array('admin'=>'','status'=>'due');
				$sale_receipt 	   = array('vendor_id'=>'0','sale_id'=>$sale_id,'vendor_type'=>'0');
				$sale_receipt['receipt_total']=$this->input->post('ventotal_0');
				$this->db->insert('sale_receipt',$sale_receipt);
				$receipt_id        = $this->db->insert_id();
				$this->crud_model->file_up('receipt_0', 'user', $receipt_id);
            }
			$data_u=array();
            $data_u['sale_code'] = date('Ym', strtotime($data['sale_datetime'])) . $sale_id;
            $data_u['delivery_status'] = json_encode($delivery_status);
            $data_u['payment_status'] = json_encode($payment_status);
            $this->db->where('sale_id', $sale_id);
            $this->db->update('sale', $data_u);
			
			foreach($carted as $value) 
              {
				 $data1=array();
                 $this->crud_model->decrease_quantity($value['id'], $value['qty']);
                 $data1['type']         = 'destroy';
                 $data1['category']     = $this->db->get_where('product', array(
                            'product_id' => $value['id']
                        ))->row()->category;
                 $data1['sub_category'] = $this->db->get_where('product', array(
                            'product_id' => $value['id']
                        ))->row()->sub_category;
                 $data1['product']      = $value['id'];
                 $data1['quantity']     = $value['qty'];
                 $data1['total']        = 0;
                 $data1['reason_note']  = 'sale';
                 $data1['sale_id']      = $sale_id;
                 $data1['datetime']     = time();
                 $this->db->insert('stock', $data1);
             }
		  
           $this->crud_model->digital_to_customer($sale_id);
           $this->crud_model->email_invoice($sale_id, $this->input->post('email'));
           $this->cart->destroy();
           $this->crud_model->clearCart('sale');
           $this->session->set_userdata('couponer','');
           //$this->crud_model->update_erp_tables($sale_id);*/
           if($this->input->post('pass_type') == 'ajax'){ redirect(base_url() .'payfort/?sl='.base64_encode($sale_id)); }
           redirect(base_url() . 'home/invoice/' . $sale_id, 'refresh');
        } }
		else
		{
			redirect(base_url(), 'refresh');
		}
	}
    function paypal_ipn()
    {
        if ($this->paypal->validate_ipn() == true) { // echo '<pre>'; print_r($_POST); echo ',/pre>'; die;

            $data['payment_details'] = json_encode($_POST);
            $data['payment_timestamp'] = strtotime(date("m/d/Y"));
            $data['payment_type'] = 'paypal';
            $sale_id = $_POST['custom'];
         //   $vendors = $this->crud_model->vendors_in_sale($sale_id);
            $vendor         =   $this->db->join('countries as C','V.country_code = C.id')->get_where('vendor as V',['C.sortname'=>wh_country()->code])->row();
            if($vendor){ $vendorId = $vendor->vendor_id; }else{ $vendorId = 0; }
            $paidStatus     =   [['vendor'=>$vendorId,'status'=>'paid']];
            $saleData       =   ['payment_status'=>json_encode($paidStatus),'payment_type'=>'paypal','delivery_status'=>'pending'];
            $data['payment_status'] = json_encode($paidStatus);
            $this->db->where('sale_id', $sale_id);
            $this->db->update('sale', $saleData);
        }
    }

    /* FUNCTION: Loads after cancelling paypal*/
    function paypal_cancel()
    {
        $sale_id = $this->session->userdata('sale_id');
        $this->db->where('sale_id', $sale_id);
        $this->db->delete('sale');
        $this->session->set_userdata('sale_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel');
        redirect(base_url() . 'home/cart_checkout/', 'refresh');
    }

    /* FUNCTION: Loads after successful paypal payment*/
    function paypal_success()
    {
        $carted = $this->cart->contents();
        $sale_id = $this->session->userdata('sale_id');
        $guest_id = $this->crud_model->get_type_name_by_id('sale', $sale_id, 'guest_id');
   //     $this->crud_model->process_affiliation($sale_id,false);
        foreach ($carted as $value) {
            $this->crud_model->decrease_quantity($value['id'], $value['qty']);
            $data1['type'] = 'destroy';
            $data1['category'] = $this->db->get_where('product', array(
                'product_id' => $value['id']
            ))->row()->category;
            $data1['sub_category'] = $this->db->get_where('product', array(
                'product_id' => $value['id']
            ))->row()->sub_category;
            $data1['product'] = $value['id'];
            $data1['quantity'] = $value['qty'];
            $data1['total'] = 0;
            $data1['reason_note'] = 'sale';
            $data1['sale_id'] = $sale_id;
            $data1['datetime'] = time();
            $this->db->insert('stock', $data1);
            
        }
        
        $vendor         =   $this->db->join('countries as C','V.country_code = C.id')->get_where('vendor as V',['C.sortname'=>wh_country()->code])->row();
        if($vendor){ $vendorId = $vendor->vendor_id; }else{ $vendorId = 0; }
        $paidStatus     =   [['vendor'=>$vendorId,'status'=>'paid']];
        $saleData       =   ['payment_status'=>json_encode($paidStatus),'payment_type'=>'paypal','delivery_status'=>'pending'];
        $this->db->where('sale_id',$sale_id)->update('sale',$saleData);
     //   $this->crud_model->digital_to_customer($sale_id);
        $this->cart->destroy();
        $this->crud_model->clearCart('sale');
        $this->session->set_userdata('couponer', '');
        $this->crud_model->email_invoice($sale_id);
        $this->session->set_userdata('sale_id', '');
        if ($this->session->userdata('user_login') == 'yes') {
            redirect(base_url() . 'home/invoice/' . $sale_id, 'refresh');
        } else {
            redirect(base_url() . 'home/guest_invoice/' . $guest_id, 'refresh');
        }
    }
	
	/* FUNCTION: Invoice showing*/
    function invoice($para1 = "", $para2 = "")
    {
        if ($this->session->userdata('user_login') != "yes"
             || $this->crud_model->get_type_name_by_id('sale', $para1, 'buyer') !==  $this->session->userdata('user_id'))
        {
            redirect(base_url());
        }

        $page_data['sale_id']    = $para1;
        $page_data['page_name']  = "invoice";
        $page_data['page_title'] = translate('invoice');
        if($para2 == 'email')
		{
            $this->load->view('front/invoice_email', $page_data);
        } 
	    else 
		{
            $this->load->view('front/index', $page_data);
        }
    }
    
	//chat page
    function chat($para1='',$para2 = "")
    {
        $this->load->model('chats');
        if ($this->session->userdata('user_login') != "yes")
        {
            redirect(base_url('home/login/redirect?page=chat/'.$para1.'/'.$para2));
        }
		$user=$this->session->userdata('user_id');;
		if($para1=='new')
		{
			$chtno=$this->db->where(array('user_id'=>$user,'vendor_id'=>$para2,'status'=>'1'))->get('chat');
			if($chtno->num_rows()==1)
			{
				redirect(base_url('home/chat/'.$chtno->row()->chat_id));
			}
			else
			{
				$new_chat=array('vendor_id'=>$para2,'user_id'=>$user,'vendor_id'=>$para2,'status'=>'1');
				if($para2==0)
				{
					$new_chat['vendor_type']='0';
				}
				$new_chat['created']=date("Y-m-d H:i:s");
				$this->db->insert('chat',$new_chat);
				$newchtid=$this->db->insert_id();
				redirect(base_url('home/chat/'.$newchtid));
			}
		}
		else
		{
			$page_data['chatId']     = $para1;
			$page_data['user']		 = $user;
			$page_data['chatLists']  = $this->chats->getChatList($user,$para1);
			$page_data['page_name']  = "chat_home";
			$page_data['page_title'] = translate('chat');
			$this->load->view('front/index', $page_data);
		}
        
    }
	
	public function addChatMessage() 
    {
        $this->load->model('chats');
        if ($this->session->userdata('user_login')=="yes") 
         {
            $data = array('chat_id' => $this->input->get('chatId'), 'msg_from' => $this->input->get('from'), 'message' => $this->input->get('message'));
            $data = $this->chats->saveChatMessage();
            if ($data) {
                echo $data;
            } else {
                echo 0;
            } die;
        } else {
            echo 0;
            die;
        }
    }

    public function getChatMessage() 
    {
        $this->load->model('chats');
        $chatId = $this->input->get('chatId');
        $lastId = $this->input->get('lastId');
        if ($this->session->userdata('user_login')=="yes")
        {
            $data = $this->chats->getChatMessages($chatId, $lastId);
            if ($data) 
            {
                echo $data;
            } 
            else 
            {
                echo 0;
            }
        } 
        else 
        {
            echo 0;
        } die;
    }
	
	
	
	

	/*FUNCTION: Loads Product List */
    function listed($para1 = "", $para2 = "", $para3 = "")
    { 
        $this->load->library('Ajax_pagination');
        if ($para1 == "click") 
        {

            $para3=$this->input->post('view_type');
            if ($this->input->post('range')) 
            {
                $range = $this->input->post('range');
            }
            if ($this->input->post('text')) 
            {
                $text = $this->input->post('text');
            }
            $category     = $this->input->post('category');
            $category     = explode(',', $category);
            $sub_category = $this->input->post('sub_category');
            $sub_category = explode(',', $sub_category);
            $brand        = trim($this->input->post('brand'));
            $brand        = explode(',', $brand);
            //print_r($brand);
            //die();

            $featured     = $this->input->post('featured');
            $fltr_flg     = $this->input->post('sort');
            $name         = '';
            $cat          = '';
            $setter       = '';
            $vendors      = array();
            
            $approved_users = $this->db->get_where('vendor',array('status'=>'approved'))->result_array();
            foreach ($approved_users as $row) 
            {
                $vendors[] = $row['vendor_id'];

            }
            
            $brand_llst=array();
            $brands_list = $this->db->get('brand')->result_array();
            foreach ($brands_list as $row1) 
            {
                $brand_llst[] = $row1['brand_id'];
            }

            $vendor = $this->db->join('countries as C','V.country_code = C.id')->get_where('vendor as V',['C.sortname'=>wh_country()->code])->row();
            if($vendor){ $vendorId = $vendor->vendor_id; }else{ $vendorId = 0; }
            $brandInputIds = false;
            $sql = " SELECT * FROM `product` as P LEFT JOIN `vendor_prices` as V ON P.`product_id` = V.`prd_id` WHERE P.`status` = 'ok' ";
            $sql1 = " SELECT * FROM `product` as P LEFT JOIN `vendor_prices` as V ON P.`product_id` = V.`prd_id` WHERE P.`status` = 'ok' ";
            
            //vendor
//            if($vendor = $this->input->post('vendor'))
//            {
//                if(in_array($vendor, $vendors)){
//                    $this->db->where('added_by', '{"type":"vendor","id":"'.$vendor.'"}');
//                    $addedBy = '{"type":"vendor","id":"'.$vendor.'"}';
//                    $vndr   =   " AND `added_by` = '$addedBy' "; 
//                } else {
//                    $this->db->where('product_id','');
//                    $vndr   =   " AND `product_id` = '' ";
//                }                
//            }
//
//            //brand
//            
//            if (count($brand) > 0) 
//            {
//                $i = 0;
//                $setterb=$brandq='';
//                foreach ($brand as $brow) 
//                {
//                    $i++;
//                    if ($brow !== "") 
//                    {
//                        if ($brow !== "0") 
//                        {
//                            $bquery[] = $brow;
//                            $setterb  = 'get';
//                        } 
//                        else 
//                        {
//                            $this->db->where('brand !=', '0');
//                            $brandq = " AND `brand` != '0' ";
//                        }
//                    }
//                }
//                if ($setterb == 'get') 
//                {
//                    $this->db->where_in('brand', $bquery);
//                    $brandq   = " AND `brand` IN (".implode(',',$bquery).") ";
//                }
//            }
            $this->db->where('P.status', 'ok');
          //  $this->db->join('vendor_prices as V','P.product_id = V.prd_id','left')->where('V.vendor_id',$vendorId)->where('P.status', 'ok');

            //featured
            if ($featured == 'ok') 
            {
                $this->db->where('P.featured', 'ok');
                $ftrd = " AND `P.featured` = 'ok' ";
            }
            else
            { $ftrd = ''; }
            
            //price range
            if (isset($range)) 
            {
                $p = explode(';', $range);
                $this->db->where('V.price >=', $p[0]);
                $this->db->where('V.price <=', $p[1]);
                $slPrice    =   " AND ( V.price >= '$p[0]' AND V.price <= '$p[1]') ";
            }
            else{ $slPrice = ''; }
            
            $query = array();

            //subcategory
//            if (count($sub_category) > 0) 
//            {
//                $i = 0;
//                foreach ($sub_category as $row) 
//                {
//                    $i++;
//                    if ($row !== "") {
//                        if ($row !== "0") 
//                        {
//                            $query[] = $row;
//                            $setter  = 'get';
//                        } 
//                        else 
//                        {
//                            $this->db->where('sub_category !=', '0');
//                            $subCat = " AND `sub_category` != '0' ";
//                        }
//                    }
//                }
//                if ($setter == 'get') {
//                    $this->db->where_in('sub_category', $query);
//                    $subCat   = " AND `sub_category` IN (".implode(',',$query).") ";
//                }
//            }
            
            //category
            if (count($category) > 0 && $setter !== 'get') 
            {
                $i = 0;
                foreach ($category as $row) 
                {
                    $i++;
                    if ($row !== "") 
                    {
                        if ($row !== "0") 
                        {
                            if ($i == 1) {
                                $this->db->where('P.category', $row);
                                $catr   = " AND P.`category` = '$row' ";
                            } 
                            else 
                            {
                                $this->db->or_where('P.category', $row);
                                $catr   .= " OR P.`category` = '$row' ";
                            }
                        } 
                        else 
                        {
                            $this->db->where('P.category !=', '0');
                            $catr   = " AND P.`category` != '0' ";
                        }
                    }
                }
            }
            

            //serach text
            if(isset($text))
            {
                if($text !== '')
                {
					$this->db->like('P.title', $text, 'both'); 
					$like  = " AND P.title LIKE '%".$text."%'";
				}
            }

            
            // pagination
            $config['total_rows'] = $this->db->count_all_results('product as P');
            $config['base_url']   = base_url() . 'home/listed/';
            if ($featured !== 'ok') 
            {
                $config['per_page'] = 12;
            } 
            else if ($featured == 'ok') 
            {
                $config['per_page'] = 12;
            }
            $config['uri_segment']  = 5;
            $config['cur_page_giv'] = $para2;
            
            $function                  = "do_product_search('0')";
            $config['first_link']      = '&laquo;';
            $config['first_tag_open']  = '<li><a  onClick="' . $function . '">';
            $config['first_tag_close'] = '</a></li>';
            
            $rr                       = ($config['total_rows'] - 1) / $config['per_page'];
            $last_start               = floor($rr) * $config['per_page'];
            $function                 = "do_product_search('" . $last_start . "')";
            $config['last_link']      = '&raquo;';
            $config['last_tag_open']  = '<li><a   onClick="' . $function . '">';
            $config['last_tag_close'] = '</a></li>';
            
            $function                 = "do_product_search('" . ($para2 - $config['per_page']) . "')";
			$config['prev_link']      = '&lsaquo;';
            $config['prev_tag_open']  = '<li><a   onClick="' . $function . '">';
            $config['prev_tag_close'] = '</a></li>';
            
            $function                 = "do_product_search('" . ($para2 + $config['per_page']) . "')";
            $config['next_link']      = '&rsaquo;';
            $config['next_tag_open']  = '<li><a   onClick="' . $function . '">';
            $config['next_tag_close'] = '</a></li>';
            
            $config['full_tag_open']  = '<ul class="pagination ">';
            $config['full_tag_close'] = '</ul>';
            
            $config['cur_tag_open']  = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';
            
            $function                = "do_product_search(((this.innerHTML-1)*" . $config['per_page'] . "))";
            $config['num_tag_open']  = '<li><a   onClick="' . $function . '">';
            $config['num_tag_close'] = '</a></li>';
            $this->ajax_pagination->initialize($config);
            
            $this->db->where('P.status', 'ok');
          //  $this->db->join('vendor_prices as V','P.product_id = V.prd_id','left')->where('V.vendor_id',$vendorId)->where('P.status', 'ok');
            if ($featured == 'ok') 
            {
                $this->db->where('P.featured', 'ok');
                $grid_items_per_row = 3;
                $name               = 'Featured';
            } 
            else 
            {
                $grid_items_per_row = 3;
            }
           
            
            if(isset($text))
            {
                if($text !== '')
                {
					$this->db->like('P.title', $text, 'both'); 
                }
            }
            

//            if($vendor = $this->input->post('vendor'))
//            {
//                if(in_array($vendor, $vendors)){
//                    $this->db->where('added_by', '{"type":"vendor","id":"'.$vendor.'"}');
//                } else {
//                    $this->db->where('product_id','');
//                }                
//            }
//
//            //brand 
//            if (count($brand) > 0) 
//            {
//                $setterb='';
//                $i = 0;
//                foreach ($brand as $brow) 
//                {
//                    $i++;
//                    if ($brow !== "") 
//                    {
//                        if ($brow !== "0") 
//                        {
//                            $bquery[] = $brow;
//                            $setterb  = 'get';
//                        } 
//                        else 
//                        {
//                            $this->db->where('brand !=', '0');
//                        }
//                    }
//                }
//                if ($setterb == 'get') 
//                {
//                    $this->db->where_in('brand', $bquery);
//                }
//            }

           
            if (isset($range)) 
            {
                $p = explode(';', $range);
                $this->db->where('V.price >=', $p[0]);
                $this->db->where("V.price <=", $p[1]);
            }
            
            $query = array();
//            if (count($sub_category) > 0) 
//            {
//                $i = 0;
//                foreach ($sub_category as $row) {
//                    $i++;
//                    if ($row !== "") {
//                        if ($row !== "0") {
//                            $query[] = $row;
//                            $setter  = 'get';
//                        } else {
//                            $this->db->where('sub_category !=', '0');
//                        }
//                    }
//                }
//                if ($setter == 'get') 
//                {
//                    $this->db->where_in('sub_category', $query);
//                    //$this->db->order_by('current_stock', 'desc');
//                }
//            }
            
            if (count($category) > 0 && $setter !== 'get') 
            {
                $i = 0;
                foreach ($category as $rowc) 
                {
                    $i++;
                    if ($rowc !== "") {
                        if ($rowc !== "0") {
                            if ($i == 1) {
                                $this->db->where("P.category", $rowc);

                            } else {
                                $this->db->or_where('P.category', $rowc);
                            }
                        } else {
                            $this->db->where('P.category >', '0');
                        }
                    }
                }
            }

            /*filter*/
            if($fltr_flg=='condition_new')
            {
                $this->db->order_by('P.add_timestamp', 'desc');
                $prdOrder   =   " ORDER BY P.`add_timestamp` DESC ";
            }
            elseif($fltr_flg=='price_low')
            {
                $this->db->order_by('V.price', 'asc');
                $prdOrder   =   " ORDER BY V.`price` ASC ";
            }
            elseif($fltr_flg=='price_high')
            {
                $this->db->order_by('V.price', 'desc');
                $prdOrder   =   " ORDER BY V.`price` DESC ";
            }
            else
            {
                $this->db->order_by('P.current_stock', 'desc');
                $this->db->order_by('P.product_id', 'desc');
                $prdOrder   =   "";
            }
            
            $page_data['all_products'] = $this->db->get('product as P', $config['per_page'], $para2)->result_array();
            $sql1 .= " $like $prdOrder LIMIT $para2, ".$config['per_page']." ";
            $custQuery  =   $this->db->query($sql1);
        //    echo $this->db->last_query();
            if(isset($text))
            {
                if($custQuery->num_rows() > 0){
                    $page_data['prd_data'] = $custQuery->result_array();
                }else{
                    $page_data['prd_data'] = $page_data['all_products'];
                }
            }
            else
            {
                $page_data['prd_data'] = $page_data['all_products'];
            }
            if ($name != '') 
            {
                $name .= ' : ';
            }
            if (isset($rowc)) 
            {
                $cat = $rowc;
            } 
            else 
            {
                if ($setter == 'get') 
                {
                    $cat = $this->crud_model->get_type_name_by_id('sub_category', $sub_category[0], 'category');
                }
            }
            if ($cat !== '') 
            {
                if ($cat !== '0') 
                {
                    $name .= $this->crud_model->get_type_name_by_id('category', $cat, 'category_name');
                } 
                else 
                {
                    $name = 'All Products';
                }
            } 
            else 
            {
                $name = 'All Products';
            }
            
        } 
        else if ($para1 == "load") 
        {
       //     $page_data['all_products']  = $this->db->join('vendor_prices as V','P.product_id = V.prd_id','left')->where('V.vendor_id',$vendorId)->get('product as P')->result_array();
      //      $page_data['prd_data']      = $this->db->join('vendor_prices as V','P.product_id = V.prd_id','left')->where('V.vendor_id',$vendorId)->get('product as P')->result_array();
            $page_data['all_products']  = $this->db->get('product as P')->result_array();
            $page_data['prd_data']      = $this->db->get('product as P')->result_array();
        }
        $page_data['vendor_system']      = $this->db->get_where('general_settings',array('type' => 'vendor_system'))->row()->value;
        $page_data['category_data']      = $category;
        $page_data['viewtype']           = $para3;
        $page_data['name']               = $name;
        $page_data['count']              = $config['total_rows'];
        $page_data['grid_items_per_row'] = 4;// $grid_items_per_row;
		$result=$this->load->view('front/listed', $page_data,true);
//		die;
        echo json_encode(array("value" => $result, "value2" => $page_data['count']));
        //$this->load->view('front/listed', $page_data);
    }
	
	/* FUNCTION: Loads Category filter page */
    function category($para1 = 0, $para2 = 0,$text ='')
    {
        if ($para2 == 0) 
        {
            $page_data['all_products'] = $this->db->get_where('product', array(
                'category' => $para1,'status'=>'ok'))->result_array();
        }
        else if ($para2 != 0) 
        {
            $page_data['all_products'] = $this->db->get_where('product', array(
                'sub_category' => $para2,'status'=>'ok'))->result_array();
        }
        
        $page_data['page_name']        = "product_list";
        $page_data['page_title']       = translate('products');
        if($para1>0)
        { 
            $page_data['meta_category']  = substr(trim($this->db->get_where('category', array('category_id' => $para1))->row()->description),0,320);
            $page_data['page_title']     = substr(trim($this->db->get_where('category', array('category_id' => $para1))->row()->category_name),0,15);
        }

        $filtCategory                  = $this->db->order_by('category_name')->get('category')->result_array(); 
        $page_data['all_category']     = $filtCategory;
        //$page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
        $page_data['all_brands']       = $this->crud_model->getsortbrand($para1); 
        $page_data['range_max']        = $this->crud_model->getrangemax($para1); 
        $page_data['cur_sub_category'] = $para2;
        $page_data['cur_category']     = $para1;
        $page_data['search_text']      = urldecode($text);
        $page_data['category_data']    = $this->db->get_where('category', array(
            'category_id' => $para1))->result_array();
      //  echo '<pre>'; print_r($page_data); echo '</pre>'; die;
        $this->load->view('front/index', $page_data);
        
    }
	
	//Main Search 
    function main_search()
    {
        $type = 0;
        $search = $this->input->post('query');

        $search = str_replace('%','%25', $search);
        $search = str_replace(',','%2C', $search);        
        $search = str_replace('&','%26', $search);
        $search = str_replace('-','%2D', $search);
        $search = str_replace('=','%3D', $search);
        $search = str_replace('(','%28', $search);
        $search = str_replace(')','%29', $search);
        $search = str_replace('+','%2B', $search);
        $search = str_replace(","," ",$search);
        $search = str_replace("'","",$search);
        //$search = str_replace(""","",$search);
        $this->crud_model->search_terms($search);
       
        if($type == '0')
        {
            redirect(base_url() .'home/category/0/0/'.$search, 'refresh');
        } 
        else if($type > 0)
        {
            redirect(base_url() .'home/category/'.$type.'/0/'.$search, 'refresh');
        }
           
    }
	//Trackorder
    function trackorder($para1='')
    {
        if ($para1=='track') 
        {
            $ordid  = $this->input->get('sale_id');
            $orderdata=$this->db->get_where('sale', array('sale_code'=>$ordid));
            if($orderdata->num_rows()==1)
            {
                $page_data['order_data']    = $orderdata->row();
                $page_data['page_name']     = "track_order";
                $page_data['page_title']    = translate('track_order');
                $this->load->view('front/index', $page_data);
            }
            else
            {
                $this->session->set_flashdata('track_alert', 'Sale Order ID Not Found..!');
                redirect('home/trackorder');
            }
        }
        else
        {
            $page_data['order_data']    = '';
            $page_data['page_name']     = "track_order";
            $page_data['page_title']    = translate('track_order');
            $this->load->view('front/index', $page_data);
        }
        
	}

	//sell with us
    function sellwithus($para1='')
    {
        if($this->session->userdata('vendor_login') == 'yes') 
        {
            redirect(base_url('vendor'));
        } 
        if($para1=='register')
        {
            $page_data['page_name']     = "seller_logup";
            $page_data['page_title']    = translate('sell_with_us');
            $this->load->view('front/index', $page_data);
        }
        else
        {
            $page_data['page_name']     = "seller_login";
            $page_data['page_title']    = translate('sell_with_us');
            $this->load->view('front/index', $page_data);
        }
    }
	
	
	//Review add and edit
    function review($para1='',$product_id)
    {
        if ($this->session->userdata('user_login') != "yes") 
        {
            redirect(base_url() . 'home/login/');
        }
		if($para1=='add')
		{
			$rating=$this->input->post('rating');
			if ($this->crud_model->set_review($product_id, $rating) == 'yes') 
            {
				$data1['user_id']=$this->session->userdata('user_id');
				$data1['product_id']=$product_id;
				$data1['review_title']=trim($this->input->post('review_title'));
				$data1['review']=trim($this->input->post('review'));
				$data1['rating']=$this->input->post('rating');
				$data1['status']=2;
				$this->db->insert('reviews', $data1);
				$this->session->set_flashdata('review_alert', 'review_added');
			}
			else if ($this->crud_model->set_review($product_id, $rating) == 'no') 
            {
               $this->session->set_flashdata('review_alert', 'review_updated');
            }
		}
		redirect(base_url('home/product_view/'.$product_id));
    }
	
	//chat_file upload
	public function ChatFile($para1 = "", $para2 = "") 
    {
        if($para1=='add')
        {
            $page_data['chat_id']=$para2;
            $this->load->view('front/chat_file',$page_data);
        }
        else if($para1=='do_add')
        {
            $chat = $this->db->get_where('chat', array('chat_id' => $para2, 'status' => 1))->row();
            $msgTo = $chat->user_id;
            $readData = array('user_unread' => ($chat->user_unread + 1),'last_message'=>date("Y-m-d H:i:s"));
           
            $cdata = array('chat_id' => $para2, 'msg_from' => $this->session->userdata('user_id'), 'msg_to' => $msgTo, 'message' => '','msg_type'=>'2','created'=>date("Y-m-d H:i:s"));
            $this->db->insert('chat_messages', $cdata);
            $result = $this->db->insert_id();
            $this->db->where('chat_id',$para2)->update('chat',$readData);
            
            $upfile      =   $_FILES['img']['name'];
            $tempName    =   $_FILES['img']['tmp_name'];
            $ext         =   pathinfo($upfile,PATHINFO_EXTENSION);
            $source      =   'chat_file_'.$result.'.'.$ext;
            move_uploaded_file($_FILES['img']['tmp_name'],'uploads/chat_message/'.$source);
            $this->db->where('chat_messages_id',$result)->update('chat_messages',array('message'=>$source));
            echo $result;
        }
    }
	
	//clear coupon
    public function clear_coupon()
    {
        $carted = $this->cart->contents();
        if (count($carted) > 0) 
        {
            foreach ($carted as $items) 
            {
                $data = array('rowid' => $items['rowid'],'price' => $items['price'],'coupon' => '','coupon_discount' => '');
                $this->cart->update($data);
            }
        }
		$this->cart->set_coupon('');
        $this->cart->set_discount('0');
        $this->session->set_userdata('coupon_apply',0);
        $this->session->set_userdata('couponer','');
        $this->session->set_userdata(array('ship_cost'=> '0','ship_operator'=>'','ship_zone'=>''));
    }
    
    //new shipping cost 24-09=2020
    function shipping_cost($operator='')
    {
        $this->session->set_userdata(array('ship_cost'=> '0','ship_operator'=>'','ship_zone'=>''));
        $cart_weight=0;
        $zoneid=0;$zonedata='';
        $operator_status='0';
        $operator_warning='Please select a shipping operator';
        $operator_success='0';
        $operator_cost=0;
        if($operator>0)
        {
            $cc_code    = wh_country()->code;
            $ccqry=$this->db->get_where('countries', array('sortname'=>$cc_code))->row();
            if($ccqry)
            {
                $rcontry_id=$ccqry->id;
                $shipZoneqr=$this->db->where(array('operator_id'=>$operator,'country_id'=>$rcontry_id,'status'=>'1'))->get('shipping_zones');
                if($shipZoneqr->num_rows()>0)
                {
                    $zonedata=$shipZoneqr->row();
                    $zoneid=$zonedata->id;
                }
            }    
            $operator_warning='Sorry, currently no shipping in your region';
            if($zoneid>0)
            {
                $carted = $this->cart->contents();
                if(count($carted) > 0) 
                {
                    foreach ($carted as $items) 
                    {
                        $item_weight=$this->crud_model->get_type_name_by_id('product',$items['id'], 'weight');
                        $cart_weight+=round($item_weight,2) * $items['qty'];
                    }
                }
                if($cart_weight < round($zonedata->min_weight,2))
                {
                    $operator_warning='Sorry, your cart is under weight for shipping';
                }
                else if($cart_weight > round($zonedata->max_weight,2))
                {
                    $operator_warning='Sorry, your cart is over weight for shipping';
                }
                else
                {
                    $operator_status='1';
                    $operator_warning='0';
                    $operator_success='Expecting delivery : with in '.trim($zonedata->day_of_delivery);
                    $operator_cost=round($zonedata->cost,2);
                    $this->session->set_userdata(array('ship_cost'=> $operator_cost,'ship_operator'=>$operator,'ship_zone'=> $zoneid));
                }

            }
        }
        
        echo $operator_status.'-'.$operator_warning.'-'.$operator_success.'-'.$operator_cost;
    }
    
    function change($para1='',$para2=''){ 
        if($para1 == 'region'){ echo $this->crud_model->changeRegion($para2); }
    }
	
	//test
	function templ()
	{
		echo $this->email_model->vendor_active('vendor','70');
		/*$account_type = 'vendor';
		$to_name ='kpp';
		$email_sub = "Account Opening";
		$email_to  = 'anukp@mailinator.com';
		$from      = 'ajith@estrrado.com';
		$page_data['email']=$email_to;
        $page_data['account_type']=$account_type;
        $page_data['fname']=$to_name;
		
		$email_msg=$this->load->view('front/welcome_email',$page_data,TRUE);
            
        echo $this->email_model->do_email($email_msg, $email_sub, $email_to,$from*/
	}
	public function testin()
	{
		echo 'hai';
		$this->crud_model->email_invoice('14', 'ajith@estrrado.com');
	}
	
	//4-09-2020 ajith
    //Request for Service 
    function servicerequest($para1='')
    {
        $country_list=array(''=>'Select Country *');
        $country  =   $this->db->where(array('status'=>1))->order_by('id','desc')->get('countries')->result_array();
        if($country)
        {
            foreach($country as $row)
            {
                $country_list[$row['id']] = $row['name'];
            }
        }

        $category_list=array(''=>'Select Service Category *');
        $categoryy  =   $this->db->where(array('status'=>1))->order_by('name')->get('service_category')->result_array();
        if($categoryy)
        {
            foreach($categoryy as $rowc)
            {
                $category_list[$rowc['service_category_id']] = $rowc['name'];
            }
        }

        $type_list=array(''=>'Select Service Type *');
        $srtypey  =   $this->db->where(array('status'=>1))->order_by('type')->get('service_type')->result_array();
        if($srtypey)
        {
            foreach($srtypey as $rowt)
            {
                $type_list[$rowt['service_type_id']] = $rowt['type'];
            }
        }

        if ($para1=='send' && $this->input->post() )
        {
            $post=$this->input->post();
            $service_data=array();
            $service_data['service_category']   =   $post['sr_category'];
            $service_data['service_type']       =   $post['sr_type'];
            $service_data['type_detail']        =   trim($post['sr_vehicle_service']);
            $service_data['name']               =   trim($post['sr_customer']);
            $service_data['address']            =   trim($post['sr_address']);
            $service_data['city']               =   trim($post['sr_city']);
            $service_data['country']            =   $post['sr_country'];
            $service_data['email']              =   trim($post['sr_cemail']);
            $service_data['mobile']             =   trim($post['sr_phone']);
            $service_data['time']               =   $post['sr_time'];
            $service_data['date']               =   $post['sr_date'];
            $service_data['remark']             =   trim($post['sr_remark']);
            $this->db->insert('request_service',$service_data);
            $requ_id=$this->db->insert_id();
            if($requ_id>0)
            {
                $this->email_model->email_request('request_service',$requ_id,'user');
                $this->email_model->email_request('request_service',$requ_id,'admin');
                //redirect('home/email_request/request_service/'.$requ_id);
                $this->session->set_flashdata('servicerequest_alert', 'Request For Service Submitted Successfully.');
            }
            else
            {
               $this->session->set_flashdata('servicerequest_warning', 'Something went wrong, Try again..!');
                
            }
            redirect('home/servicerequest');
        }
        else
        {
            $page_data['sr_country_list']    = $country_list;
            $page_data['sr_category_list']    = $category_list;
            $page_data['sr_type_list']    = $type_list;
            $page_data['page_name']     = "request_service";
            $page_data['page_title']    = translate('request_for_service');
            $this->load->view('front/index', $page_data);
        }
        
    }
    
    //Request for Demo 
    function demorequest($para1='')
    {
        $country_list=array(''=>'Select Country *');
        $country  =   $this->db->where(array('status'=>1))->order_by('id','desc')->get('countries')->result_array();
        if($country)
        {
            foreach($country as $row)
            {
                $country_list[$row['id']] = $row['name'];
            }
        }


        $type_list=array(''=>'Select Product ');
        $srtypey  =   $this->db->where(array('status'=>'ok','request_demo'=>'1','admin_approved'=>'1'))->order_by('title')->get('product')->result_array();
        if($srtypey)
        {
            foreach($srtypey as $rowt)
            {
                $type_list[$rowt['product_id']] = $rowt['title'];
            }
        }

        if ($para1=='send' && $this->input->post() )
        {
            $post=$this->input->post();
            $demo_data=array();
            
            
            $demo_data['name']               =   trim($post['dr_customer']);
            $demo_data['email']              =   trim($post['dr_cemail']);
            $demo_data['mobile']             =   trim($post['dr_phone']);
            //$demo_data['address']            =   trim($post[dr_address']);
            $demo_data['city']               =   trim($post['dr_city']);
            $demo_data['country']            =   $post['dr_country'];
            $demo_data['time']               =   $post['dr_time'];
            $demo_data['date']               =   $post['dr_date'];
            $demo_data['product_id']       =   $post['dr_product'];
            $demo_data['remarks']             =   trim($post['dr_remark']);
            $this->db->insert('request_demo',$demo_data);
            $requ_id=$this->db->insert_id();
            if($requ_id>0)
            {
                $this->email_model->email_request('request_demo',$requ_id,'user');
                $this->email_model->email_request('request_demo',$requ_id,'admin');
                //redirect('home/email_request/request_demo/'.$requ_id);
                $this->session->set_flashdata('demorequest_alert', 'Request For Demo Submitted Successfully.');
            }
            else
            {
               $this->session->set_flashdata('demorequest_warning', 'Something went wrong, Try again..!');
                
            }
            redirect('home/demorequest');
        }
        else
        {
            $page_data['dr_country_list']    = $country_list;
            $page_data['dr_product_list']    = $type_list;
            $page_data['page_name']     = "request_demo";
            $page_data['page_title']    = translate('request_for_demo');
            $this->load->view('front/index', $page_data);
        }
        
    }
    
    function email_request($request_type, $request_id,$user_type='user')
    {
        $page_data=array('request_type'=>$request_type,'request_title'=>'Request for Demo','user_type'=>$user_type);
        //$this->load->database();
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
            if($user_type=='user')
            {
                $email_to  = $request_data->email;
            }
            $this->load->view('front/email_request_user',$page_data);
        }

    }
    
    function industry($brId=0){
        $data['page_title']     =   'Industry Products';
        $data['page_name']      =   'brand_products';
        $conditions['count']    =   'all_rec'; 
        $conditions['start']    =   0;
        $conditions['per_page'] =   $this->perPage;
        $products               =   $this->crud_model->getIndusProducts((object)$conditions,['P.status'=>'ok','B.brand_id'=>$brId]); 
        $data['totalRec']       =   $products['count'];
        $totpage                =   (int)($products['count'] / $this->perPage);
        $rem                    =   $products['count'] % $this->perPage;
        if($rem > 0){ $totpage  =   ($totpage+1); }
        $data['totalpage']      =   $totpage;
        $data['currPage']       =   $brId;
        $data['products']       =   $products['data']; 
      //  echo '<pre>'; print_r($data['products']); echo '</pre>'; die;
        $data['all_brands']     =   $this->db->get_where('brand',['status'=>1])->result();
        $data['cur_brand']      =   $brId;
        // Load the list page view 
        $this->load->view('front/index', $data);
    }
    
    function ajaxPaginationData($brId=0){ 
        // Define offset 
        $post                   =   (object)$this->input->post();
        $page                   =   (int)$post->currPage; 
        if($page == 0){ $page   =   1; }
        $conditions['count']    =   ''; 
        $conditions['start']    =   ($page-1)*$this->perPage;;
        $conditions['per_page'] =   $this->perPage;
        $products               =   $this->crud_model->getIndusProducts((object)$conditions,['P.status'=>'ok','B.brand_id'=>$brId]); 
        $data['currPage']       =   $page;  
      //  $data['totalRec']       =   $products['count'];
        $data['totalpage']      =   $post->totPage;
        $data['cur_brand']      =   $brId;
        $data['products']       =   $products['data']; 
      //   echo '<pre>'; print_r($data['products']); echo '</pre>'; die;
        // Load the data list view 
        $this->load->view('front/brand_listed', $data, false); 
    } 
    //end 0-09-2020 ajith
    
    
    function address($para1='save',$para2=''){ 
        if($para1 == 'customer'){  
            $address            =   $this->db->get_where('user_address',['adrs_id'=>$para2,'user_id'=>$this->session->userdata('user_id')])->row();
            $data =[]; foreach($address as $k=>$row){ $data[$k] = $row; } 
            echo json_encode($data);
        }else if($para1 == 'save'){
            $post               =   (object) $this->input->post();
            $adrId              =   (int)$post->adrs_id;
        //    echo '<pre>';print_r($post); echo'</pre>';  die;
            if($post->valid     ==  0){ echo 'invalid'; die; }
            $data               =   $post->addr;
            $data['user_id']    =   $this->session->userdata('user_id');
            if($adrId           >   0){
                if($data['default_addr']){
                    $upd        =   $this->db->where('user_id',$data['user_id'])->update('user_address',['default_addr'=>0]);
                }
                $result         =   $this->db->where('adrs_id',$adrId)->update('user_address',$data);
            }else{ $result      =   $this->db->insert('user_address',$data); }
            if($result){      
                $data['adrSearch']  =   '';
                $data['addresses']  =   $this->db->join('countries as C','A.country = C.id')
                                        ->get_where('user_address as A',['A.user_id'=>$this->session->userdata('user_id'), 'A.status' => 1])->result();
                $this->load->view('front/user/address', $data, false); 
            }
            else{ echo'failed'; }
        }else if($para1 == 'search'){
            $data['adrSearch']  =   $para2;
            $this->db->join('countries as C','A.country = C.id');
            if($para2 != ''){
                $where          =   '(A.fname LIKE "%'.$para2.'%" OR A.address1 LIKE "%'.$para2.'%" OR A.city LIKE "%'.$para2.'%" OR A.landmark LIKE "%'.$para2.'%" OR A.zip LIKE "%'.$para2.'%" OR C.name LIKE "%'.$para2.'%")';
                $this->db->where($where);
            }
            $data['addresses']  =   $this->db->get_where('user_address as A',['A.user_id'=>$this->session->userdata('user_id'), 'A.status' => 1])->result();
            $this->load->view('front/user/address', $data, false); 
        }else{ echo 'Address'; }
    }
    
     function checkout_address($para='save'){
        $post               =   (object) $this->input->post();
        if($post->valid     ==  0){ echo 'invalid'; die; }
        $data               =   $post->addr;
        $data['user_id']    =   $this->session->userdata('user_id');
        $result             =   $this->db->insert('user_address',$data);
        if($result)
        {            
            $cc_code             = wh_country()->code;
           $country_id = $this->db->where('sortname',$cc_code)->get('countries')->row()->id;
           $data['all_address'] =  $this->db->join('countries as C','A.country = C.id')
                                        ->get_where('user_address as A',['A.user_id'=>$this->session->userdata('user_id'), 'A.status' => 1,'A.country'=>$country_id])->result(); 
        }
        else{ echo'failed'; }
    }

}



/* End of file home.php */
/* Location: ./application/controllers/home.php */