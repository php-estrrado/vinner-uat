<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Admin extends CI_Controller
{
    
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('paypal');
    	//$this->load->library('fedex/fedex/fedex-common.php');
        /*cache control*/
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('encryption');
        $this->load->library("session");
        $this->load->helper('email');
        
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->crud_model->ip_data();
	//	$this->config->cache_query();
    }
    
    /* index of the admin. Default: Dashboard; On No Login Session: Back to login page. */
    public function index()
    {
        if ($this->session->userdata('admin_login') == 'yes') {
            $page_data['page_name'] = "dashboard";
            $page_data['low_stocks'] = $this->crud_model->getLowStockProducts();
          //  echo '<pre>'; print_r($page_data['low_stocks'][0]->title); echo '</pre>'; die;
            $this->load->view('back/index', $page_data);
        } else {
            $page_data['control'] = "admin";
            $this->load->view('back/login',$page_data);
        }
    }
    
    /*Product Category add, edit, view, delete */
    function category($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('category')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') 
		{

			/*cate name check if exists*/
            
          /* $cat_name = $this->input->post('category_name');
        	$admin  = $this->db->get_where('category', array(
                'category_name' => $cat_name
            ))->result_array();
              foreach ($admin as $row) {
            if ($row['category_name'] != $cat_name) {
                
              $data['category_name'] = $this->input->post('category_name');
            
            $this->db->insert('category', $data);
            recache();  
              
            }
            else
                echo "exists";
        }*/
            
            /* endscate name check if exists*/
            

            $data['category_name'] = $this->input->post('category_name');
            $data['description'] = $this->input->post('description');
            $this->db->insert('category', $data);
            recache();
        } else if ($para1 == 'edit') {
            $page_data['category_data'] = $this->db->get_where('category', array(
                'category_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/category_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['category_name'] = $this->input->post('category_name');
            $data['description']   = $this->input->post('description');
            $this->db->where('category_id', $para2);
            $this->db->update('category', $data);
            recache();
        } elseif ($para1 == 'delete') {
            $this->db->where('category_id', $para2);
            $this->db->delete('category');
            recache();
        } elseif ($para1 == 'list') {
            $this->db->order_by('category_id', 'desc');
            $page_data['all_categories'] = $this->db->get('category')->result_array();
            $this->load->view('back/admin/category_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/category_add');
        } else {
            $page_data['page_name']      = "category";
            $page_data['all_categories'] = $this->db->get('category')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Product blog_category add, edit, view, delete */
    function blog_category($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('blog')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['name'] = $this->input->post('name');
            $this->db->insert('blog_category', $data);
            recache();
        } else if ($para1 == 'edit') {
            $page_data['blog_category_data'] = $this->db->get_where('blog_category', array(
                'blog_category_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/blog_category_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['name'] = $this->input->post('name');
            $this->db->where('blog_category_id', $para2);
            $this->db->update('blog_category', $data);
            recache();
        } elseif ($para1 == 'delete') {
            $this->db->where('blog_category_id', $para2);
            $this->db->delete('blog_category');
            recache();
        } elseif ($para1 == 'list') {
            $this->db->order_by('blog_category_id', 'desc');
            $page_data['all_categories'] = $this->db->get('blog_category')->result_array();
            $this->load->view('back/admin/blog_category_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/blog_category_add');
        } else {
            $page_data['page_name']      = "blog_category";
            $page_data['all_categories'] = $this->db->get('blog_category')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    

    /*Product slides add, edit, view, delete */
    function slides($para1 = '', $para2 = '')
    {
       /* if (!$this->crud_model->admin_permission('slides')) {
            redirect(base_url() . 'index.php/admin');
        }*/
        if ($para1 == 'do_add') {
            $type                = 'slides';
            $data['name']        = $this->input->post('name');
            $data['sl_link']     = $this->input->post('hr_link');
            $data['vl_link']     = $this->input->post('video_link');
            $data['type']        = $this->input->post('sl_type');
            $data['alt_text']    = $this->input->post('alt_text');
            $this->db->insert('slides', $data);
            $id = $this->db->insert_id();
            if($data['type']=='Image'){
            $this->crud_model->file_up("img", "slides", $id, '', '', '.jpg');}
            recache();
        } elseif ($para1 == "update") {
            $data['name']        = $this->input->post('name');
            $data['sl_link']     = $this->input->post('hr_link');
            $data['vl_link']     = $this->input->post('video_link');
            $data['type']        = $this->input->post('sl_type');
            $data['alt_text']    = $this->input->post('alt_text');
            $this->db->where('slides_id', $para2);
            $this->db->update('slides', $data);
            $this->crud_model->file_up("img", "slides", $para2, '', '', '.jpg');
            recache();
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('slides', $para2, '.jpg');
            $this->db->where('slides_id', $para2);
            $this->db->delete('slides');
            recache();
        } elseif ($para1 == 'multi_delete') {
            $ids = explode('-', $param2);
            $this->crud_model->multi_delete('slides', $ids);
        } else if ($para1 == 'edit') {
            $page_data['slides_data'] = $this->db->get_where('slides', array(
                'slides_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/slides_edit', $page_data);
        } elseif ($para1 == 'list') {
            $this->db->order_by('slides_id', 'desc');
            $page_data['all_slidess'] = $this->db->get('slides')->result_array();
            $this->load->view('back/admin/slides_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/slides_add');
        } else {
            $page_data['page_name']  = "slides";
            $page_data['all_slidess'] = $this->db->get('slides')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Product Category add, edit, view, delete */
    function blog($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('blog')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['title']          = $this->input->post('title');
            $data['date']           = $this->input->post('date');
            $data['author']         = $this->input->post('author');
            $data['summery']        = $this->input->post('summery');
            $data['blog_category']  = $this->input->post('blog_category');
            $data['description']    = $this->input->post('description');
            $this->db->insert('blog', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("img", "blog", $id, '', '', '.jpg');
            recache();
        } else if ($para1 == 'edit') {
            $page_data['blog_data'] = $this->db->get_where('blog', array(
                'blog_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/blog_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['title']          = $this->input->post('title');
            $data['date']           = $this->input->post('date');
            $data['author']         = $this->input->post('author');
            $data['summery']        = $this->input->post('summery');
            $data['blog_category']  = $this->input->post('blog_category');
            $data['description']    = $this->input->post('description');
            $this->db->where('blog_id', $para2);
            $this->db->update('blog', $data);
            $this->crud_model->file_up("img", "blog", $para2, '', '', '.jpg');
            recache();
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('blog', $para2, '.jpg');
            $this->db->where('blog_id', $para2);
            $this->db->delete('blog');
            recache();
        } elseif ($para1 == 'list') {
            $this->db->order_by('blog_id', 'desc');
            $page_data['all_blogs'] = $this->db->get('blog')->result_array();
            $this->load->view('back/admin/blog_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/blog_add');
        } else {
            $page_data['page_name']      = "blog";
            $page_data['all_blogs'] = $this->db->get('blog')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Product Sub-category add, edit, view, delete */
    function sub_category($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('sub_category')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['sub_category_name'] = $this->input->post('sub_category_name');
            $data['category']          = $this->input->post('category');
            $this->db->insert('sub_category', $data);
            recache();
        } else if ($para1 == 'edit') {
            $page_data['sub_category_data'] = $this->db->get_where('sub_category', array(
                'sub_category_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/sub_category_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['sub_category_name'] = $this->input->post('sub_category_name');
            $data['category']          = $this->input->post('category');
            $this->db->where('sub_category_id', $para2);
            $this->db->update('sub_category', $data);
            redirect(base_url() . 'index.php/admin/sub_category/', 'refresh');
            recache();
        } elseif ($para1 == 'delete') {
            $this->db->where('sub_category_id', $para2);
            $this->db->delete('sub_category');
            recache();
        } elseif ($para1 == 'list') {
            $this->db->order_by('sub_category_id', 'desc');
            $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
            $this->load->view('back/admin/sub_category_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/sub_category_add');
        } else {
            $page_data['page_name']        = "sub_category";
            $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Product Brand add, edit, view, delete */
    function brand($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('brand')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $type                = 'brand';
            $data['name']        = $this->input->post('name');
            $data['category']    = $this->input->post('category');
            $data['logo_alt']    = $this->input->post('logo_alt');
            $data['banner_alt']  = $this->input->post('banner_alt');
            $this->db->insert('brand', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("img", "brand", $id, '', '', '.png');
            $this->crud_model->file_up("img1", "brand_banner", $id, '', '', '.png');
            recache();
        } elseif ($para1 == "update") {
            $data['name']        = $this->input->post('name');
            $data['category']    = $this->input->post('category');
            $data['logo_alt']    = $this->input->post('logo_alt');
            $data['banner_alt']  = $this->input->post('banner_alt');
            $this->db->where('brand_id', $para2);
            $this->db->update('brand', $data);
            $this->crud_model->file_up("img", "brand", $para2, '', '', '.png');
            $this->crud_model->file_up("img1", "brand_banner", $para2, '', '', '.png');
            recache();
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('brand', $para2, '.png');
            $this->db->where('brand_id', $para2);
            $this->db->delete('brand');
            recache();
        } elseif ($para1 == 'multi_delete') {
            $ids = explode('-', $param2);
            $this->crud_model->multi_delete('brand', $ids);
        } else if ($para1 == 'edit') {
            $page_data['brand_data'] = $this->db->get_where('brand', array(
                'brand_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/brand_edit', $page_data);
        } elseif ($para1 == 'list') {
            $this->db->order_by('brand_id', 'desc');
            $page_data['all_brands'] = $this->db->get('brand')->result_array();
            $this->load->view('back/admin/brand_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/brand_add');
        } else {
            $page_data['page_name']  = "brand";
            $page_data['all_brands'] = $this->db->get('brand')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    

 function existsbrand()
    {
        $email  = $this->input->post('email');
        $user   = $this->db->get('brand')->result_array();
        $exists = 'no';
        foreach ($user as $row) {
            if ($row['name'] == $email) {
                $exists = 'yes';
            }
        }
        echo $exists;
    }


 /*tax management*/
    function tax($para1 = "", $para2 = "")
    {
       

        if ($para1 == 'do_add') {
            // echo "in";
            $data['tax_type'] = $this->input->post('title');
            $data['tax_status'] = $this->input->post('till');
            
            $this->db->insert('tax', $data);
        } else if ($para1 == 'edit') {
            $page_data['tax_data'] = $this->db->get_where('tax', array(
                'tax_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/tax_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['tax_type'] = $this->input->post('title');
            $data['tax_status'] = $this->input->post('till');
          
            $this->db->where('tax_id', $para2);
            $this->db->update('tax', $data);
        } elseif ($para1 == 'delete') {
            $this->db->where('tax_id', $para2);
            $this->db->delete('tax');
        } elseif ($para1 == 'list') {
            $this->db->order_by('tax_id', 'desc');
            $page_data['all_tax'] = $this->db->get('tax')->result_array();
            $this->load->view('back/admin/tax_list', $page_data);
        } elseif ($para1 == 'add') {
            
            $this->load->view('back/admin/tax_add');
        } else {
            $page_data['page_name']      = "tax";
            $page_data['all_tax'] = $this->db->get('tax')->result_array();
            $this->load->view('back/index', $page_data);
        }
        
    }
    /*/tax management*/

/* stax management */
function stax($para1 = "", $para2 = "")
    {
        if ($para1 == 'do_add') 
        {
            $data['tax_type']   = $this->input->post('title');
            $data['country_id'] = $this->input->post('scountry');
            $data['tax_amount'] = $this->input->post('stax');
            $data['tax_details']= $this->input->post('detail');
            $this->db->insert('region_stax', $data);
        } 
        else if ($para1 == 'edit') 
        {
            $page_data['tax_data'] = $this->db->get_where('region_stax', array(
                'stax_id' => $para2))->result_array();
            $this->load->view('back/admin/stax_edit', $page_data);
        } 
        elseif ($para1 == "update") 
        {
            $data['tax_type']   = $this->input->post('title');
            $data['country_id'] = $this->input->post('scountry');
            $data['tax_amount'] = $this->input->post('stax');
            $data['tax_details']= $this->input->post('detail');
            $this->db->where('stax_id', $para2);
            $this->db->update('region_stax', $data);
        } 
        elseif ($para1 == 'delete') 
        {
            $this->db->where('stax_id', $para2);
            $this->db->delete('region_stax');
        } elseif ($para1 == 'list') 
        {
            //$this->db->order_by('stax_id', 'desc');
            $page_data['all_tax'] = $this->db->get('region_stax')->result_array();
            $this->load->view('back/admin/stax_list', $page_data);
        } 
        elseif ($para1 == 'add') 
        {
            $this->load->view('back/admin/stax_add');
        } 
        else 
        {
            $page_data['page_name']      = "stax";
            $page_data['all_tax']         = $this->db->get('region_stax')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
/* stax management */
function existstax()
    {
        $email  = $this->input->post('email');
        $user   = $this->db->get('region_stax')->result_array();
        $exists = 'no';
        foreach ($user as $row) 
        {
            if ($row['country_id'] == $email) 
            {
                $exists = 'yes';
            }
        }
        echo $exists;
    }




 /*service request*/

    function service($para1 = '', $para2 = '', $para3 = '')
     {
        /*if (!$this->crud_model->admin_permission('review_list')) {
            redirect(base_url() . 'index.php/admin');
        }*/
    
        if ($para1 == 'delete') {
            $this->db->where('request_id', $para2);
            $this->db->delete('request_service');
            recache();
        } else if ($para1 == 'list') {
          //  echo "in1";
            $this->db->order_by('request_id', 'desc');
         $page_data['all_service'] = $this->db->get('request_service')->result_array();
           $this->load->view('back/admin/service_list', $page_data);
        } else if ($para1 == 'view') {
            $page_data['request_id'] = $para2;
          //   $user_name = $this->crud_model->get_type_name_by_id('service_request',$row['request_id'],'username');
            $page_data['request_data'] = $this->db->get_where('request_service', array(
                'request_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/service_view', $page_data);
        } else if($para1 == 'approval') {
            $page_data['request_id'] = $para2;
            $page_data['processed_status'] = $this->db->get_where('request_service', array('request_id' => $para2))->row()->processed_status;           
            $this->load->view('back/admin/service_approval', $page_data);
        } /*else if ($para1 == 'add') {
            $this->load->view('back/admin/vendor_add');
        }*/ else if ($para1 == 'approval_set') {
            $vendor = $para2;
            $approval = $this->input->post('approval');
            if ($approval == 'ok') {

                $data['processed_status'] = 'yes';
                
            } else {
                
                $data['processed_status'] = 'no';
            }
            $this->db->where('request_id', $vendor);
            $this->db->update('request_service', $data);
           // $this->email_model->status_email('reviews', $vendor);
            recache();
        }   else {
            $page_data['page_name'] = "service";
            $page_data['all_service'] = $this->db->get('request_service')->result_array();
            $this->load->view('back/index', $page_data);
        }
     }
  
    /*//service request*/



 /*inventory managemant*/
    function inventory($para1 = "", $para2 = ""){
     

        if ($para1 == "cash_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('type', "cash_set");
            $this->db->update('inventory', array(
                'value' => $val
            ));
            recache();
        }
        if ($para1 == 'set') {
            
            /*PAYFORT*/
            
              $this->db->where('type', "low_stock_status");
            $this->db->update('inventory', array(
                'value' => $this->input->post('low_stock_status')
            )); 
            $this->db->where('type', "out_stock_status");
            $this->db->update('inventory', array(
                'value' => $this->input->post('out_stock_status')
            )); 
            $this->db->where('type', "low_stock_threshold");
            $this->db->update('inventory', array(
                'value' => $this->input->post('low_stock_threshold')
            )); 
            $this->db->where('type', "out_stock_threshold");
            $this->db->update('inventory', array(
                'value' => $this->input->post('out_stock_threshold')
            ));
            $this->db->where('type', "out_stock_visibility");
            $this->db->update('inventory', array(
                'value' => $this->input->post('out_stock_visibility')
            ));
            /*/payfort*/
                   
                    recache();
           // redirect(base_url() . 'index.php/admin/inventory');
        }
        
        else {
          
            $page_data['page_name'] = "inventory";
            $this->load->view('back/index', $page_data);
        }
        
        
    }
    
    /*/inventory management*/


    /*promotional pop up*/
    function promo_popup($para1 = '', $para2 = '')
    {
   
    if ($para1 == 'do_add') {
            $type                = 'slides';
            $data['popup_name']  = $this->input->post('name');
            $data['status']      = "0";
            $this->db->insert('promo_popup', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("img", "popup", $id, '', '', '.jpg');
            recache();
        } elseif ($para1 == "update") {
            $data['popup_name']  = $this->input->post('name');
            $this->db->where('popup_id', $para2);
            $this->db->update('promo_popup', $data);
            $this->crud_model->file_up("img", "promo_popup", $para2, '', '', '.jpg');
            recache();
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('promo_popup', $para2, '.jpg');
            $this->db->where('popup_id', $para2);
            $this->db->delete('promo_popup');
            recache();
        } elseif ($para1 == 'multi_delete') {
            $ids = explode('-', $param2);
            $this->crud_model->multi_delete('promo_popup', $ids);
        } else if ($para1 == 'edit') {
            $page_data['popup_data'] = $this->db->get_where('promo_popup', array(
                'popup_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/promo_popup_edit', $page_data);
        } elseif ($para1 == 'list') {
          $this->db->order_by('popup_id', 'desc');
            $page_data['all_popups'] =$this->db->get('promo_popup')->result_array();
            $this->load->view('back/admin/promo_popup_list', $page_data);
         } elseif ($para1 == 'add') {
            $this->load->view('back/admin/promo_popup_add');
        }
        else if ($para1 == 'approval') {
            $page_data['popup_id'] = $para2;
            $page_data['status'] = $this->db->get_where('promo_popup', array(
											'popup_id' => $para2
										))->row()->status;
            $this->load->view('back/admin/promo_popup_approval', $page_data);
        }
            else if ($para1 == 'approval_set') {
            $vendor = $para2;
			$approval = $this->input->post('approval');
            if ($approval == 'ok') {
                $data['status'] = '1';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('popup_id', $vendor);
            $this->db->update('promo_popup', $data);
           // $this->email_model->status_email('reviews', $vendor);
            recache();
        }   
        
        
        else {
            $page_data['page_name']  = "promo_popup";
            $page_data['all_popups'] = $this->db->get('promo_popup')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*/promotional pop up*/



    /*Product coupon add, edit, view, delete */
    function coupon($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('coupon')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['title'] = $this->input->post('title');
            $data['code'] = $this->input->post('code');
            $data['till'] = $this->input->post('till');
            $data['status'] = 'ok';
            $data['added_by'] = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['spec'] = json_encode(array(
                                'set_type'=>$this->input->post('set_type'),
                                'set'=>json_encode($this->input->post($this->input->post('set_type'))),
                                'discount_type'=>$this->input->post('discount_type'),
                                'discount_value'=>$this->input->post('discount_value'),
                                'shipping_free'=>$this->input->post('shipping_free')
                            ));
            $this->db->insert('coupon', $data);
        } else if ($para1 == 'edit') {
            $page_data['coupon_data'] = $this->db->get_where('coupon', array(
                'coupon_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/coupon_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['title'] = $this->input->post('title');
            $data['code'] = $this->input->post('code');
            $data['till'] = $this->input->post('till');
            $data['spec'] = json_encode(array(
                                'set_type'=>$this->input->post('set_type'),
                                'set'=>json_encode($this->input->post($this->input->post('set_type'))),
                                'discount_type'=>$this->input->post('discount_type'),
                                'discount_value'=>$this->input->post('discount_value'),
                                'shipping_free'=>$this->input->post('shipping_free')
                            ));
            $this->db->where('coupon_id', $para2);
            $this->db->update('coupon', $data);
        } elseif ($para1 == 'delete') {
            $this->db->where('coupon_id', $para2);
            $this->db->delete('coupon');
        } elseif ($para1 == 'list') {
            $this->db->order_by('coupon_id', 'desc');
            $page_data['all_coupons'] = $this->db->get('coupon')->result_array();
            $this->load->view('back/admin/coupon_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/coupon_add');
        } elseif ($para1 == 'publish_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('coupon_id', $product);
            $this->db->update('coupon', $data);
        } else {
            $page_data['page_name']      = "coupon";
            $page_data['all_coupons'] = $this->db->get('coupon')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Product Sale Comparison Reports*/
    function report($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('report')) {
            redirect(base_url() . 'admin');
        }
        $page_data['page_name'] = "report";
        $page_data['products']  = $this->db->get('product')->result_array();
        $this->load->view('back/index', $page_data);
    }
    
       /*Product most viewed Reports*/
    function most_viewed($para1 = '', $para2 = '')
    {
        
        if (!$this->crud_model->admin_permission('report')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'list') {
            //echo "in";
            $this->db->order_by('number_of_view','desc');
						$this->db->where('status','ok');
						//$most_viewed = $this->db->get('product')->result_array();
            $page_data['most_viewed'] = $this->db->get('product')->result_array();
          
            $this->load->view('back/admin/mostviewed', $page_data);
        } elseif ($para1 == 'view') {
            $data['viewed'] = 'ok';
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/sales_view', $page_data);
        }else {
            $page_data['page_name']      = "mostviewed";
            $page_data['all_categories'] = $this->db->get('sale')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    

    /* most cuponusage Reports*/
    function report_coupon($para1 = '', $para2 = '')
    {
        
        if (!$this->crud_model->admin_permission('report')) 
        {
            redirect(base_url() . 'index.php/admin');
        }

         if ($para1 == 'list') 
        {
           
          $couponid=$this->db->get('coupon')->result_array();
          foreach ($couponid as $cid) 
          {
              $total=0;
              $this->db->select('product_details');
              $row=$this->db->get('sale')->result_array();
              foreach ($row as $product_details) 
              {
                   $productdetails = json_decode($product_details['product_details'], true);
                   foreach ($productdetails as $row1)
                  {
                       if($row1['coupon']==$cid['coupon_id'])
                       {
                       $total=$total+1;
                       }
                   }
              }
               $ab[]= array('title' =>$cid['title'],'code'=>$cid['code'],'status' =>$total);
          }
              $price = array();
              foreach ($ab as $key => $row)
          {
              $price[$key] = $row['status'];
          }
            array_multisort($price, SORT_DESC, $ab );

            $page_data['report_coupon'] = $ab;

            //$this->db->order_by('coupon_id', 'desc');
            //$page_data['report_coupon'] = $this->db->get('coupon')->result_array();
            
            $this->load->view('back/admin/report_coupon', $page_data);
        }
        
        else
        {
        $page_data['page_name'] = "report_coupon";
        
        $this->load->view('back/index', $page_data);
        }
    }
    
       /*Best Purchased Products Report  Reports*/
    function report_products($para1 = '', $para2 = '')
    {
        
        if (!$this->crud_model->admin_permission('report')) 
        {
            redirect(base_url() . 'index.php/admin');
        }

         if ($para1 == 'list') 
        {
           
           $this->db->select('product_id');
            $productid=$this->db->get('product')->result_array();
                foreach ($productid as $pid) 
                {
                    $total=0;
                   // echo $pid['product_id']."<br/>";
                    $this->db->select('product_details');
                    $row=$this->db->get('sale')->result_array();
                    foreach ($row as $product_details) 
                    {
                       $productdetails = json_decode($product_details['product_details'], true);
                         foreach ($productdetails as $row1)
                        {
                            if($row1['id']==$pid['product_id'])
                            {
                            $total=$total+$row1['qty'];
                            }
                        }
                        //$page_data['report_products']=$a;   
                    }
                    $ab[]= array('product_id' => $pid['product_id'],'total' =>$total);
                   
                    
                }
                    $price = array();
                 foreach ($ab as $key => $row)
                {
                    $price[$key] = $row['total'];
                }
                array_multisort($price, SORT_DESC, $ab );
     
             $page_data['report_products']=$ab;
             $this->load->view('back/admin/report_products',$page_data);
               
        }
        
        else
        {
        $page_data['page_name'] = "report_products";
        $this->load->view('back/index', $page_data);
        }
    }



    /*Product review  Reports*/
    function report_review($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('report')) 
        {
            redirect(base_url() . 'index.php/admin');
        }
        
        if ($para1 == 'list') 
        {
           
            $this->db->select('R.product_id, COUNT(R.review_id) as total');
            $this->db->from('reviews as R');
            $this->db->join('product as P', 'P.product_id = R.product_id');
            $this->db->group_by('R.product_id'); 
            $this->db->order_by('total', 'desc');
            $page_data['report_review'] = $this->db->get()->result_array();

            $this->load->view('back/admin/report_review', $page_data);
        }
        
        else
        {
        $page_data['page_name'] = "report_review";
        
        $this->load->view('back/index', $page_data);
        }
    }

    /*Search Terms  Reports */
    function report_searchterm($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('report')) 
        {
            redirect(base_url() . 'index.php/admin');
        }
        
        if ($para1 == 'list') 
        {
            //$this->db->select('term','count');
            $this->db->order_by('count','desc');
            $page_data['report_searchterm'] = $this->db->get('search_terms')->result_array();

            $this->load->view('back/admin/report_searchterm', $page_data);
        }
        
        else
        {
        $page_data['page_name'] = "report_searchterm";
        
        $this->load->view('back/index', $page_data);
        }
    }
      




    /*Product Low Stock  Reports*/
    function report_stock($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('report')) {
            redirect(base_url() . 'index.php/admin');
        }
        
        if ($para1 == 'list') {
           
            $this->db->order_by('current_stock','asc');
						$this->db->where('status','ok');
						//$most_viewed = $this->db->get('product')->result_array();
            $page_data['report_stock'] = $this->db->get('product')->result_array();
              
            $this->load->view('back/admin/report_stock', $page_data);
        }
        
        
        else{
        $page_data['page_name'] = "report_stock";
        
        $this->load->view('back/index', $page_data);
        }
    }


  /*Product total_sales invoice Reports*/
function total_sales($para1 = '', $para2 = '',$para3 = '')
    {        
        if (!$this->crud_model->admin_permission('report')) 
        {
            redirect(base_url() . 'index.php/admin');
        }
     if($para1='list')
     {      
               if($para2 == 'day')
           {

             $tsale=0;
                 if( isset($saleid))
                {
                   
                }
                else{
                    $saleid=$this->db->get('sale')->result_array();
                }
                        foreach ( $saleid as $sid) 
                      {                 
                              
                         $stime=$sid['sale_datetime'];                         
                          $tod=(date('m-d-y', $stime));
                            if($para3==$tod)
                            {
$saleid2[]=array('sale_id'=>$sid['sale_id'],'sale_code'=>$sid['sale_code'],'buyer'=>$sid['buyer'],'grand_total'=>$sid['grand_total'],'payment_status'=>$sid['payment_status'],'delivery_status'=>$sid['delivery_status'],'sale_datetime'=>$sid['sale_datetime']);    
                            $tsale=$tsale+$sid['grand_total'];
                            }                    
                     
                      }
                       $saleid=$saleid2;  
                    $page_data['invohead']= $para3;                  
                    $page_data['gdtotal']   = $tsale;
                    $page_data['page_name'] = "total_sales";
                    $page_data['total_sales']=$saleid;
                // $this->load->view('back/admin/total_sales',$page_data);
                  $this->load->view('back/index',$page_data); 
                    }

   else if($para2 == 'mnt')
        {
            $tsale=0;
             if(isset($saleid))
                {                    
                }
                else{
                    $saleid=$this->db->get('sale')->result_array();
                }
             foreach ( $saleid as $sid) 
            {                 
              //echo $new_date."<br/>";
                $stime=$sid['sale_datetime'];
                $tod= (date('m-y', $stime));
               // echo $tod."<br/>";
                if($para3 == $tod)
                 {
                  $saleid2[]=array('sale_id'=>$sid['sale_id'],'sale_code'=>$sid['sale_code'],'buyer'=>$sid['buyer'],'grand_total'=>$sid['grand_total'],'payment_status'=>$sid['payment_status'],'delivery_status'=>$sid['delivery_status'],'sale_datetime'=>$sid['sale_datetime']); 
                  $tsale=$tsale+$sid['grand_total'];
                 }                   
             
            }//echo $tsale;
                    $saleid=$saleid2;  
                    $da=$para3."-O1";
                    $mnth=substr($para3,0,2);
                    $yer=substr($para3,3);                    
                   // $monthName = date( 'F Y', mktime(0, 0, 0, $mnth, "20".$yer) );
                    $monthName = date("F ", mktime(0, 0, 0, $mnth));
                    $page_data['invohead']= $monthName."20".$yer;
                    $page_data['gdtotal']   = $tsale;
                    $page_data['page_name'] = "total_sales";
                    $page_data['total_sales']=$saleid;
                     //$this->load->view('back/admin/total_sales', $page_data);
                    $this->load->view('back/index',$page_data); 
        }
     }   
        else
       {
        $page_data['page_name'] = "total_sales";
        $this->load->view('back/index', $page_data);
        }   
}




 /*sale total sale Reports*/
 function report_sale($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('report')) 
        {
            redirect(base_url() . 'index.php/admin');
        } 
        elseif ($para1== 'list') {

              $dm    =  $this->input->post('dorms');
              $date  =  $this->input->post('dats');
              $delsta=  $this->input->post('dests');            
               if ($dm == 1)
                    {                      
                         $new_date = date('m-d-y', strtotime($this->input->post('dats')));                        
                         //$this->total_sales('list','day', $new_date);                                     
                         redirect(base_url() . 'index.php/admin/total_sales/list/day/'.$new_date, 'refresh');
                    }
   else if($dm == 2)
        {              
                $month =  $this->input->post('mnts'); 
                $day=01;   
                $mdate=$month."-".$day;
                $new_date = date('m-y', strtotime($mdate));                
                // $this->total_sales('list','mnt', $new_date);
                 redirect(base_url() . 'index.php/admin/total_sales/list/mnt/'.$new_date, 'refresh');
        }   
        }        
        else
        {
        $page_data['page_name'] = "report_sale";        
        $this->load->view('back/index', $page_data);
        }
    }





    
    /*Product Wish Comparison Reports*/
    function report_wish($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('report')) {
            redirect(base_url() . 'index.php/admin');
        }
        $page_data['page_name'] = "report_wish";
        $this->load->view('back/index', $page_data);
    }
    
    /* Product add, edit, view, delete, stock increase, decrease, discount */
    function product($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('product')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $options = array();
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $data['title']              = $this->input->post('title');
            $data['category']           = $this->input->post('category');
            $data['description']        = $this->input->post('description');
            $data['short_description']  = $this->input->post('short_description');
            $data['meta_description']   = $this->input->post('meta_description');
            $data['product_type']       = $this->input->post('product_type');
            $data['sub_category']       = $this->input->post('sub_category');
            $data['sale_price']         = $this->input->post('sale_price');
            $data['purchase_price']     = $this->input->post('purchase_price');
            $data['restricted_country'] = json_encode($this->input->post('restricted_countries'));
            $data['add_timestamp']      = time();
            $data['update_time']        =   time();
            $data['featured']           = '0';
            $data['status']             = 'ok';
            $data['rating_user']        = '[]';
            $data['product_code']       = $this->input->post('product_code');
            $data['location']           = $this->input->post('location');
            
            $data['equipment']       = $this->input->post('equipment');
            $data['sub_equipment' ]  = $this->input->post('sub_equipment');
            $data['item_type']       = $this->input->post('item_type');
            $data['shipping_info']   = $this->input->post('shipping_info');
            $data['moreinfo']        = $this->input->post('more_info');
            $data['type']            = $this->input->post('product_group');
            $data['alt_text']        = $this->input->post('alt_text');

            
            $tax_type=$this->input->post('taxcap');
            $tot_rate=0;
            foreach($tax_type as $type)
            {
                $tot_rate=$tot_rate+$type['taxrate'];
                
            }
            if($tot_rate=='')
            {
                $tot_rate=0;
            }

            $data['tax_info']           =json_encode($tax_type);
            /*$data['tax']                = $this->input->post('tax');*/
            $data['tax']                = $tot_rate;

            $data['discount']           = $this->input->post('discount');
            $data['discount_type']      = $this->input->post('discount_type');
            $data['tax_type']           = "percent";
            /*$data['tax_type']           = $this->input->post('tax_type');*/
//            $data['shipping_cost']      = $this->input->post('shipping_cost');
            $data['shipping_cost']      = 0;
            $data['tag']                = $this->input->post('tag');
            $data['color']              = json_encode($this->input->post('color'));
            $data['num_of_imgs']        = $num_of_imgs;
            $data['current_stock']      = $this->input->post('current_stock');
            $data['front_image']        = $this->input->post('front_image');
            $additional_fields['name']  = json_encode($this->input->post('ad_field_names'));
            $additional_fields['value'] = json_encode($this->input->post('ad_field_values'));
            $data['additional_fields']  = json_encode($additional_fields);
            $data['brand']              = $this->input->post('brand');
            $data['unit']               = $this->input->post('unit');
                $data['shipping_status']               = $this->input->post('optradio');
                $data['model']             = $this->input->post('model');
                $data['sku']               = $this->input->post('sku');
                $data['mpn']               = $this->input->post('mpn');
                $data['length']            = $this->input->post('length');
                $data['width']             = $this->input->post('width');
                $data['height']            = $this->input->post('height');
                $data['length_class_id']   = $this->input->post('length_class_id');
                $data['weight']            = $this->input->post('weight');
                $data['weight_class_id']   = $this->input->post('weight_class_id');
                $data['admin_approved']    =   1;
                $data['vendor_approved']   =   1;
                $data['request_quote']     = $this->input->post('request_quote');
                $data['dg']                = $this->input->post('dgradio');
                /*$data['view_front']       = $this->input->post('showfrnt');*/
            
            $choice_titles              = $this->input->post('op_title');
            $choice_types               = $this->input->post('op_type');
            $choice_no                  = $this->input->post('op_no');
			$data['added_by']           = json_encode(array('type'=>'vendor','id'=>'1'));
			if(count($choice_titles ) > 0){
				foreach ($choice_titles as $i => $row) {
					$choice_options         = $this->input->post('op_set'.$choice_no[$i]);
					$options[]              =   array(
													'no' => $choice_no[$i],
													'title' => $choice_titles[$i],
													'name' => 'choice_'.$choice_no[$i],
													'type' => $choice_types[$i],
													'option' => $choice_options
												);
				}
			}
            $data['options']            = json_encode($options);
            $data['related_products'] =json_encode($this->input->post('relatedproducts'));

            $this->db->insert('product', $data);
            $id = $this->db->insert_id();

            if($this->input->post('product_group') =='grouped')
            {
                $qty          =   $this->input->post('quantity');  
                $prdName      =   $this->input->post('p'); 
                foreach ($this->input->post('prd-id')  as $i => $prdId) 
                {
                  $productlist = array( 'grouped_id' => $id,'product_id' => $prdId,'product_name' => $prdName[$i],'qty' => $qty[$i]);
                  $this->db->insert('grouped_product', $productlist);
                }
            }

/*            $data1['country_id']= $this->input->post('scountry');
            $data1['tax_amount']= $this->input->post('tax1');
            $data1['product_id']=$id;
            $this->db->insert('region_tax', $data1);*/

            $datart['product_id'] = $id;
            $rid = $this->input->post('rid');
            $trate  = $this->input->post('trate');            
            if(count($rid ) > 0)
                {
                 foreach ($rid  as $i => $row) 
                    {
                $datart['country_id'] = $rid[$i];
                $datart['tax_amount'] = $trate[$i];
                $this->db->insert('region_tax', $datart);
                     }
                }



			$this->benchmark->mark_time();
            $this->crud_model->file_up("images", "product", $id, 'multi');

            if($_FILES["product_brochure"]["size"] > 0)
            {
            $namebro='brochure_'.$id; //$_FILES['product_file']['name'];
            move_uploaded_file($_FILES['product_brochure']['tmp_name'], 'uploads/product_brochure/'. $namebro.'.pdf');
            }

            if($this->input->post('download') == 'ok'){
                $rand           = substr(hash('sha512', rand()), 0, 20);
                $name           = $id.'_'.$rand.'_'.$_FILES['product_file']['name'];
                $da['download_name'] = $name;
                $da['download'] = 'ok';
                $folder = $this->db->get_where('general_settings', array('type' => 'file_folder'))->row()->value;
                move_uploaded_file($_FILES['product_file']['tmp_name'], 'uploads/file_products/' . $folder .'/' . $name);
            } else {
                $da['download'] = 'no';
            }
            $this->db->where('product_id', $id);
            $this->db->update('product', $da);
            recache();
        } 
        elseif ($para1 == 'gp_add') 
        {
            $this->load->view('back/admin/gp_add');
        }
        else if ($para1 == 'gp_edit') 
        {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2 ))->result_array();
            $this->load->view('back/admin/gp_edit', $page_data);
        }
        else if ($para1 == "update") {
            $options = array();
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $num                        = $this->crud_model->get_type_name_by_id('product', $para2, 'num_of_imgs');
            $download                   = $this->crud_model->get_type_name_by_id('product', $para2, 'download');
            $data['update_time']        =   time();
            $data['title']              = $this->input->post('title');
            $data['category']           = $this->input->post('category');
            $data['description']        = $this->input->post('description');
            $data['short_description']  = $this->input->post('short_description');
            $data['meta_description']   = $this->input->post('meta_description');
            $data['sub_category']       = $this->input->post('sub_category');
            $data['sale_price']         = $this->input->post('sale_price');
            $data['purchase_price']     = $this->input->post('purchase_price');
            $data['restricted_country'] = json_encode($this->input->post('restricted_countries'));
            $data['featured']           = $this->input->post('featured');
            $tax_type=$this->input->post('taxcap');
            $tot_rate=0;
            foreach($tax_type as $type)
            {
                $tot_rate=$tot_rate+$type['taxrate'];
            }
            $data['product_code']       = $this->input->post('product_code');
            $data['tax_info']           =json_encode($tax_type);
            $data['tax']                = $tot_rate;
            //$data['tax']                = $this->input->post('tax');
            $data['discount']           = $this->input->post('discount');
            $data['discount_type']      = $this->input->post('discount_type');
            $data['tax_type']           = "percent";
            //$data['tax_type']           = $this->input->post('tax_type');
            $data['shipping_cost']      = $this->input->post('shipping_cost');
            $data['tag']                = $this->input->post('tag');
            $data['color']              = json_encode($this->input->post('color'));
            $data['num_of_imgs']        = $num + $num_of_imgs;
            $data['front_image']        = $this->input->post('front_image');
            $additional_fields['name']  = json_encode($this->input->post('ad_field_names'));
            $additional_fields['value'] = json_encode($this->input->post('ad_field_values'));
            $data['additional_fields']  = json_encode($additional_fields);
            $data['brand']              = $this->input->post('brand');
            $data['unit']               = $this->input->post('unit');
            $data['location']           = $this->input->post('location');
            
            $data['equipment']          = $this->input->post('equipment');
            $data['sub_equipment' ]     = $this->input->post('sub_equipment');
            $data['item_type']          = $this->input->post('item_type');
            $data['alt_text']           = $this->input->post('alt_text');
            
                $data['shipping_status']   = $this->input->post('optradio');
                $data['model']             = $this->input->post('model');
                $data['sku']               = $this->input->post('sku');
                $data['mpn']               = $this->input->post('mpn');
                $data['length']            = $this->input->post('length');
                $data['width']             = $this->input->post('width');
                $data['height']            = $this->input->post('height');
                $data['length_class_id']   = $this->input->post('length_class_id');
                $data['weight']            = $this->input->post('weight');
                $data['weight_class_id']   = $this->input->post('weight_class_id');
                $data['dg']                = $this->input->post('dgradio');
                $data['status']            = $this->input->post('status');
                $data['request_quote']     = $this->input->post('request_quote');
                /*$data['view_front']       = $this->input->post('showfrnt');*/
                $data['type']              = $this->input->post('product_group');
                $data['shipping_info']     = $this->input->post('shipping_info');
                $data['moreinfo']          = $this->input->post('more_info');

            $data['related_products'] =json_encode($this->input->post('relatedproducts'));    
            
            $choice_titles              = $this->input->post('op_title');
            $choice_types               = $this->input->post('op_type');
            $choice_no                  = $this->input->post('op_no');
			if(count($choice_titles ) > 0){
				foreach ($choice_titles as $i => $row) {
					$choice_options         = $this->input->post('op_set'.$choice_no[$i]);
					$options[]              =   array(
													'no' => $choice_no[$i],
													'title' => $choice_titles[$i],
													'name' => 'choice_'.$choice_no[$i],
													'type' => $choice_types[$i],
													'option' => $choice_options
												);
				}
			}
            $data['options']            = json_encode($options);
            $this->crud_model->file_up("images", "product", $para2, 'multi');
            if($download == 'ok' && $_FILES['product_file']['name'] !== ''){
                $rand           = substr(hash('sha512', rand()), 0, 20);
                $name           = $para2.'_'.$rand.'_'.$_FILES['product_file']['name'];
                $data['download_name'] = $name;
                $folder = $this->db->get_where('general_settings', array('type' => 'file_folder'))->row()->value;
                move_uploaded_file($_FILES['product_file']['tmp_name'], 'uploads/file_products/' . $folder .'/' . $name);
            }

            if($_FILES["product_brochure"]["size"] > 0)
            {
                if (file_exists('uploads/product_brochure/brochure_'.$para2.'.pdf' ) )
                {
                 unlink('uploads/product_brochure/brochure_'.$para2.'.pdf');
                }
            $namebro='brochure_'.$para2; 
            move_uploaded_file($_FILES['product_brochure']['tmp_name'], 'uploads/product_brochure/'. $namebro.'.pdf');
            }

            $this->db->where('product_id', $para2);
            $this->db->update('product', $data);
            recache();

            if($this->input->post('product_group') =='grouped')
            {
                $this->db->where('grouped_id', $para2);
                $this->db->delete('grouped_product'); 
                $qty       =  $this->input->post('quantity');  
                $prdName   =  $this->input->post('p'); 
                foreach ($this->input->post('prd-id')  as $i => $prdId) 
                {
                  $productlist = array( 'grouped_id' => $para2,'product_id' => $prdId,'product_name' => $prdName[$i],'qty' => $qty[$i]);
                  $this->db->insert('grouped_product', $productlist);
                }
            }

            $this->db->where('product_id',$para2);
            $this->db->delete('region_tax');  
            
            $datart['product_id'] =$para2;
            $rid = $this->input->post('rid');
            $trate = $this->input->post('trate');            
            if(count($rid ) > 0)
                {
                 foreach ($rid  as $i => $row) 
                    {
                $datart['country_id'] = $rid[$i];
                $datart['tax_amount'] = $trate[$i];
                $this->db->insert('region_tax', $datart);
                     }
                }

                recache();


        } 


        else if ($para1 == 'edit') {
            if($para3 != ''){
                $this->session->set_userdata('offset', $para3);
                $curPage    =   ( $this->session->userdata('offset')/$this->session->userdata('limit'));
                $this->session->set_userdata('curPage', $curPage);
            }
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/product_edit', $page_data);
        } else if ($para1 == 'view') {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/product_view', $page_data);
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('product', $para2, '.jpg', 'multi');
            if (file_exists('uploads/product_brochure/brochure_'.$para2.'.pdf' ) )
            {
            unlink('uploads/product_brochure/brochure_'.$para2.'.pdf');
            }
            $this->db->where('product_id', $para2);
            $this->db->delete('product');
            recache();
        } elseif ($para1 == 'list') { 
            $this->db->order_by('added_by', 'desc');
            $page_data['all_product'] = $this->db->get_where('product', array('type' => 'single'))->result_array();
            $this->load->view('back/admin/product_list', $page_data);
        } elseif ($para1 == 'list_data') {
            $limit      = $this->input->get('limit');
            $search     = $this->input->get('search');
            $order      = $this->input->get('order');
            $offset     = $this->input->get('offset');
            $sessOffset =    $this->session->userdata('offset');
            $this->session->set_userdata('limit',$this->input->get('limit'));
            if($offset == 0){
                if($sessOffset){ $offset = $sessOffset;  $this->session->unset_userdata('offset'); $this->session->set_userdata('curPage',0); $currPage   =   ($offset/$limit)+1;
                }
            }
            $sort       = $this->input->get('sort');
            if($search){
                $this->db->like('title', $search, 'both');
            }
            //$this->db->where('type', 'single');
            $this->db->where('view_front','1');
            $total      = $this->db->get('product')->num_rows();
            
			if($sort == ''){
				$sort = 'update_time';
				$order = 'DESC';
			}
            else if ($sort =='publish')
            {
                $sort = 'status';
            }
            //$this->db->where('type', 'single');
            $this->db->where('view_front','1');
            if($search)
            {
                $where  = "(`title` LIKE '%".$search."%' OR `product_code` LIKE '%".$search."%')";
                $this->db->where($where);
                /*$this->db->like('title', $search, 'both');
                $this->db->or_like('product_code',$search, 'both');*/
            }
            $this->db->order_by($sort,$order);
            $this->db->limit($limit);
            $products   = $this->db->get('product', $limit, $offset)->result_array();
            $data       = array();
            foreach ($products as $row) {

                $res    = array(
                             'image' => '',
                             'title' => '',
                             'current_stock' => '',
                             'deal' => '',
                             'publish' => '',
                             'latest' => '' ,
                             'featured' => '',
                             'options' => '',
                             'category' =>''
                          );

                $res['image']  = '<img class="img-sm" style="height:auto !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;" src="'.$this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one').'"  />';
                $res['title']  = $row['title'].' ('.$row['product_code'].')'; //$row['category'].' - '.
                $res['category']  = $this->db->get_where('category',array('category_id'=>$row['category']))->row()->category_name;
                if($row['status'] == 'ok'){
                    $res['publish']  = '<input id="pub_'.$row['product_id'].'" class="sw1" type="checkbox" data-id="'.$row['product_id'].'" checked />';
                } else {
                    $res['publish']  = '<input id="pub_'.$row['product_id'].'" class="sw1" type="checkbox" data-id="'.$row['product_id'].'" />';
                }
                if($row['current_stock'] > 0){ 
                    $res['current_stock']  = $row['current_stock'].$row['unit'].'(s)';                     
                } else if($row['download'] == 'ok'){
                    $res['current_stock']  = '<span class="label label-info">'.translate('digital_product').'</span>';
                } else {
                    $res['current_stock']  = '<span class="label label-danger">'.translate('out_of_stock').'</span>';
                }
                if($row['deal'] == 'ok'){
                    $res['deal']  = '<input id="deal_'.$row['product_id'].'" class="sw3" type="checkbox" data-id="'.$row['product_id'].'" checked />';
                } else {
                    $res['deal']  = '<input id="deal_'.$row['product_id'].'" class="sw3" type="checkbox" data-id="'.$row['product_id'].'" />';
                }
                if($row['featured'] == 'ok'){
                    $res['featured'] = '<input id="fet_'.$row['product_id'].'" class="sw2" type="checkbox" data-id="'.$row['product_id'].'" checked />';
                } else {
                    $res['featured'] = '<input id="fet_'.$row['product_id'].'" class="sw2" type="checkbox" data-id="'.$row['product_id'].'" />';
                }

                if($row['latest'] == 'ok'){
                    $res['latest']  = '<input id="lat_'.$row['product_id'].'" class="swlat" type="checkbox" data-id="'.$row['product_id'].'" checked />';
                } else {
                    $res['latest']  = '<input id="lat_'.$row['product_id'].'" class="swlat" type="checkbox" data-id="'.$row['product_id'].'" />';
                }

                //add html for action
                $res['options'] = "  <a class=\"btn btn-info btn-xs btn-labeled fa fa-location-arrow\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_set_full('view','".translate('view_product')."','".translate('successfully_viewed!')."','product_view','".$row['product_id']."');proceed('to_list');\" data-original-title=\"View\" data-container=\"body\">
                                    ".translate('view')."
                            </a>
                            <a class=\"btn btn-purple btn-xs btn-labeled fa fa-tag\" data-toggle=\"tooltip\"
                                onclick=\"ajax_modal('add_discount','".translate('view_discount')."','".translate('viewing_discount!')."','add_discount','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('discount')."
                            </a>
                            <a class=\"btn btn-mint btn-xs btn-labeled fa fa-plus-square\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_modal('add_stock','".translate('add_product_quantity')."','".translate('quantity_added!')."','stock_add','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('stock')."
                            </a>
							<!-- -->
                            <a class=\"btn btn-dark btn-xs btn-labeled fa fa-minus-square\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_modal('destroy_stock','".translate('reduce_product_quantity')."','".translate('quantity_reduced!')."','destroy_stock','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('destroy')."
                            </a> 
                            
                            <a class=\"btn btn-success btn-xs btn-labeled fa fa-wrench\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_set_full('edit','".translate('edit_product')."','".translate('successfully_edited!')."','product_edit','".$row['product_id']."','".$offset."');proceed('to_list');\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('edit')."
                            
                            <a onclick=\"delete_confirm('".$row['product_id']."','".translate('really_want_to_delete_this?')."')\" 
                                class=\"btn btn-danger btn-xs btn-labeled fa fa-trash\" data-toggle=\"tooltip\" data-original-title=\"Delete\" data-container=\"body\">
                                    ".translate('delete')."
                            </a>";
                $data[] = $res;
            }
            $result = array(
                            'offset' => $offset,
                            'currPage' => $currPage,
                             'total' => $total,
                             'rows' => $data
                           );

            echo json_encode($result);

        } else if ($para1 == 'dlt_img') {
            $a = explode('_', $para2);
            $this->crud_model->file_dlt('product', $a[0], '.jpg', 'multi', $a[1]);
            recache();
        } else if ($para1 == 'dlt_bros') {
        if (file_exists('uploads/product_brochure/brochure_'.$para2.'.pdf' ) )
        {
        unlink('uploads/product_brochure/brochure_'.$para2.'.pdf');
        }
        recache();
        }

         elseif ($para1 == 'sub_by_cat') {
            echo $this->crud_model->select_html('sub_category', 'sub_category', 'sub_category_name', 'add', 'demo-chosen-select required', '', 'category', $para2, 'get_sub_res');
        } elseif ($para1 == 'brand_by_cat') {
            echo $this->crud_model->select_html('brand', 'brand', 'name', 'add', 'demo-chosen-select', '', '', '', '');
            /*echo $this->crud_model->select_html('brand', 'brand', 'name', 'add', 'demo-chosen-select', '', 'category', $para2, '');*/
        } elseif ($para1 == 'product_by_sub') {
            echo $this->crud_model->select_html('product', 'product', 'title', 'add', 'demo-chosen-select required', '', 'sub_category', $para2, 'get_pro_res','',1);
        } 
        elseif ($para1 == 'sub_by_equi') {
            echo $this->crud_model->select_html('sub_equipment', 'sub_equipment', 'sub_equipment_name', 'add', 'demo-chosen-select ', '', 'equipment', $para2, '');
        }
        elseif ($para1 == 'pur_by_pro') {
            echo $this->crud_model->get_type_name_by_id('product', $para2, 'purchase_price');
        }else if ($para1 == 'sale_by_pro') {
            echo $this->crud_model->get_type_name_by_id('product', $para2, 'sale_price');
        }
        else if ($para1 == 'name_by_pro') {
           echo $this->crud_model->get_type_name_by_id('product', $para2, 'title');
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/product_add');
        } elseif ($para1 == 'add_stock') {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_stock_add', $data);
        } elseif ($para1 == 'destroy_stock') {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_stock_destroy', $data);
        } elseif ($para1 == 'stock_report') {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_stock_report', $data);
        } elseif ($para1 == 'sale_report') {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_sale_report', $data);
        } elseif ($para1 == 'add_discount') {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_add_discount', $data);
        } elseif ($para1 == 'product_featured_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['featured'] = 'ok';
            } else {
                $data['featured'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        } 
        elseif ($para1 == 'product_latest_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['latest'] = 'ok';
            } else {
                $data['latest'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        }
        elseif ($para1 == 'product_deal_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['deal'] = 'ok';
            } else {
                $data['deal'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        } elseif ($para1 == 'product_publish_set') {
            $product = $para2;
        //    if ($para3 == 'true') {
          //      $data['status'] = 'ok';
          //  } else {
          //      $data['status'] = '0';
         //   }
                $prdStatus  =   $this->crud_model->getProductStatus($para2,$para3,'admin');
                $data['status'] = $prdStatus['status'];
                $data['admin_approved'] = $prdStatus['admin_approved'];
                $data['vendor_approved'] = $prdStatus['vendor_approved'];
                
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        } elseif ($para1 == 'add_discount_set') {
            $product               = $this->input->post('product');
            $data['discount']      = $this->input->post('discount');
            $data['discount_type'] = $this->input->post('discount_type');
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        } else {
            $page_data['page_name']   = "product";
            $page_data['all_product'] = $this->db->get('product')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
  
    /* Product Stock add, edit, view, delete, stock increase, decrease, discount */
    function stock($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('stock')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['type']         = 'add';
            $data['category']     = $this->input->post('category');
            $data['sub_category'] = $this->input->post('sub_category');
            $data['product']      = $this->input->post('product');
            $data['quantity']     = $this->input->post('quantity');
            $data['rate']         = $this->input->post('rate');
            $data['total']        = $this->input->post('total');
            $data['reason_note']  = $this->input->post('reason_note');
            $data['datetime']     = time();
            $this->db->insert('stock', $data);
            $prev_quantity          = $this->crud_model->get_type_name_by_id('product', $data['product'], 'current_stock');
            $data1['current_stock'] = $prev_quantity + $data['quantity'];
            $this->db->where('product_id', $data['product']);
            $this->db->update('product', $data1);
            recache();
        } else if ($para1 == 'do_destroy') {
            $data['type']         = 'destroy';
            $data['category']     = $this->input->post('category');
            $data['sub_category'] = $this->input->post('sub_category');
            $data['product']      = $this->input->post('product');
            $data['quantity']     = $this->input->post('quantity');
            $data['total']        = $this->input->post('total');
            $data['reason_note']  = $this->input->post('reason_note');
            $data['datetime']     = time();
            $this->db->insert('stock', $data);
            $prev_quantity = $this->crud_model->get_type_name_by_id('product', $data['product'], 'current_stock');
            $current       = $prev_quantity - $data['quantity'];
            if ($current <= 0) {
                $current = 0;
            }
            $data1['current_stock'] = $current;
            $this->db->where('product_id', $data['product']);
            $this->db->update('product', $data1);
            recache();
        } elseif ($para1 == 'delete') {
            $quantity = $this->crud_model->get_type_name_by_id('stock', $para2, 'quantity');
            $product  = $this->crud_model->get_type_name_by_id('stock', $para2, 'product');
            $type     = $this->crud_model->get_type_name_by_id('stock', $para2, 'type');
            if ($type == 'add') {
                $this->crud_model->decrease_quantity($product, $quantity);
            } else if ($type == 'destroy') {
                $this->crud_model->increase_quantity($product, $quantity);
            }
            $this->db->where('stock_id', $para2);
            $this->db->delete('stock');
            recache();
        } elseif ($para1 == 'list') {
            $this->db->order_by('stock_id', 'desc');
            $page_data['all_stock'] = $this->db->get('stock')->result_array();
            $this->load->view('back/admin/stock_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/stock_add');
        } elseif ($para1 == 'destroy') {
            $this->load->view('back/admin/stock_destroy');
        } else {
            $page_data['page_name'] = "stock";
            $page_data['all_stock'] = $this->db->get('stock')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Frontend Banner Management */
    function banner($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('banner')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "set") {
            $data['link']   = $this->input->post('link');
            $data['status'] = $this->input->post('status');
            $data['alt_text'] = $this->input->post('alt_text');
            $data['title']    = $this->input->post('title');
            $this->db->where('banner_id', $para2);
            $this->db->update('banner', $data);
            $this->crud_model->file_up("img", "banner", $para2);
            recache();
        } else if ($para1 == 'banner_publish_set') {
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else if ($para3 == 'false') {
                $data['status'] = '0';
            }
            $this->db->where('banner_id', $para2);
            $this->db->update('banner', $data);
            recache();
        } else {
            $page_data['page_name']      = "banner";
            $page_data['all_categories'] = $this->db->get('category')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Managing sales by users */
 
    
    function sales($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('sale')) {
            redirect(base_url() . 'admin');
        }
        if ($para1 == 'delete') {
            $carted = $this->db->get_where('stock', array(
                'sale_id' => $para2
            ))->result_array();
            foreach ($carted as $row2) {
                $this->stock('delete', $row2['stock_id']);
            }
            $this->db->where('sale_id', $para2);
            $this->db->delete('sale');
        } elseif ($para1 == 'list') {
            $all = $this->db->get_where('sale',array('payment_type' => 'go'))->result_array();
            foreach ($all as $row) {
                if((time()-$row['sale_datetime']) > 600){
                    $this->db->where('sale_id', $row['sale_id']);
                    $this->db->delete('sale');
                }
            }
            $this->db->order_by('sale_id', 'desc');
            $page_data['all_sales'] = $this->db->get('sale')->result_array();
            $this->load->view('back/admin/sales_list', $page_data);
        } elseif ($para1 == 'view') {
            $data['viewed'] = 'ok';
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/sales_view', $page_data);
          
        } 
        
         elseif ($para1 == 'order_home') {
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/order_home', $page_data);
        }
        
        
        
        
        elseif ($para1 == 'send_invoice') {
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $text              = $this->load->view('back/includes_top', $page_data);
            $text .= $this->load->view('back/admin/sales_view', $page_data);
            $text .= $this->load->view('back/includes_bottom', $page_data);
        } elseif ($para1 == 'delivery_payment') {
            $data['viewed'] = 'ok';
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale_id']         = $para2;
            $page_data['payment_type']    = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_type;
            $page_data['payment_details'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_details;
            $delivery_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->delivery_status,true);
            foreach ($delivery_status as $row) {
             //   if(isset($row['admin'])){
                    $page_data['delivery_status'] = $row['status'];
              //  }
            }
            $payment_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_status,true);
            foreach ($payment_status as $row) {
                if(isset($row['admin'])){
                    $page_data['payment_status'] = $row['status'];
                }
            }
            $page_data['payment_status'] = $this->db->get_where('sale', array('sale_id' => $para2))->row()->payment_status;
            $this->load->view('back/admin/sales_delivery_payment', $page_data);
        } elseif ($para1 == 'delivery_payment_set') {
            $delivery_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->delivery_status,true);
            $new_delivery_status = array();
            foreach ($delivery_status as $row) {
                if(isset($row['admin'])){
                    $new_delivery_status[] = array('admin'=>'','status'=>$this->input->post('delivery_status'),'delivery_time'=>$row['delivery_time']);
                } else {
                    $new_delivery_status[] = array('vendor'=>$row['vendor'],'status'=>$row['status'],'delivery_time'=>$row['delivery_time']);
                }
            }
            $payment_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_status,true);
            $new_payment_status = array();
            foreach ($payment_status as $row) {
                if(isset($row['admin'])) {
                    $new_payment_status[] = array('admin'=>'','status'=>$this->input->post('payment_status'));
                } else {
                    $new_payment_status[] = array('vendor'=>$row['vendor'],'status'=>$row['status']);
                }
            }
        //    $data['payment_status']  = json_encode($new_payment_status);
        //    $data['delivery_status'] = json_encode($new_delivery_status);
            $payment_status         =   array('vendor'=>$this->input->post('vendorId'),'status'=>$this->input->post('payment_status'));
            $delivery_status        =   array('vendor'=>$this->input->post('vendorId'),'status'=>$this->input->post('delivery_status'),'delivery_time'=>$deliTime);
            $data['payment_status']  = '['.json_encode($payment_status).']';
            $data['delivery_status'] = '['.json_encode($delivery_status).']';
            $data['payment_details'] = $this->input->post('payment_details');
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/sales_add');
        } elseif ($para1 == 'total') {
            echo $this->db->get('sale')->num_rows();
        } else {
            $page_data['page_name']      = "sales";
            $page_data['all_categories'] = $this->db->get('sale')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Most Viewed*/
    /* Managing sales by users */
   /* function mostviewed($para1 = '', $para2 = '')
    {
          if (!$this->crud_model->admin_permission('report')) {
            redirect(base_url() . 'index.php/admin');
        }
        
    }*/
    /*Most Viewed*/
    
    
    
    
    
    /*User Management */
    function user($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('user')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['username']    = $this->input->post('user_name');
            $data['description'] = $this->input->post('description');
            $this->db->insert('user', $data);
        } else if ($para1 == 'edit') {
            $page_data['user_data'] = $this->db->get_where('user', array(
                'user_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/user_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['username']    = $this->input->post('username');
            $data['description'] = $this->input->post('description');
            $this->db->where('user_id', $para2);
            $this->db->update('user', $data);
        } elseif ($para1 == 'delete') {
            $this->db->where('user_id', $para2);
            $this->db->delete('user');
        } elseif ($para1 == 'list') {
            $this->db->order_by('user_id', 'desc');
            $page_data['all_users'] = $this->db->get('user')->result_array();
            $this->load->view('back/admin/user_list', $page_data);
        } elseif ($para1 == 'view') {
            $page_data['user_data'] = $this->db->get_where('user', array(
                'user_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/user_view', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/user_add');
        } else {
            $page_data['page_name'] = "user";
            $page_data['all_users'] = $this->db->get('user')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    
    
    /*Guest user management*/
    
    /*User Management */
    function guest($para1 = '', $para2 = '')
    {
        /*if (!$this->crud_model->admin_permission('user')) {
            redirect(base_url() . 'index.php/admin');
        }*/
        /*if ($para1 == 'do_add') {
            $data['username']    = $this->input->post('user_name');
            $data['description'] = $this->input->post('description');
            $this->db->insert('user', $data);
        } else if ($para1 == 'edit') {
            $page_data['user_data'] = $this->db->get_where('user', array(
                'user_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/user_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['username']    = $this->input->post('username');
            $data['description'] = $this->input->post('description');
            $this->db->where('user_id', $para2);
            $this->db->update('user', $data);
        } else*if ($para1 == 'delete') {
            $this->db->where('user_id', $para2);
            $this->db->delete('sale');
        } else*/
        if ($para1 == 'list') {
            $this->db->order_by('sale_id', 'desc');
            $page_data['all_users'] = $this->db->get('sale')->result_array();
            $this->load->view('back/admin/guest_list', $page_data);
        } elseif ($para1 == 'view') {
            $page_data['guest_data'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/guest_view', $page_data);
        }  else {
            $page_data['page_name'] = "guest";
            $page_data['all_users'] = $this->db->get('sale')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }

    /*/guest user management*/
    
    /* membership_payment Management */
    function membership_payment($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('membership_payment')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'delete') {
            $this->db->where('membership_payment_id', $para2);
            $this->db->delete('membership_payment');
        } else if ($para1 == 'list') {
            $this->db->order_by('membership_payment_id', 'desc');
            $page_data['all_membership_payments'] = $this->db->get('membership_payment')->result_array();
            $this->load->view('back/admin/membership_payment_list', $page_data);
        } else if ($para1 == 'view') {
            $page_data['membership_payment_data'] = $this->db->get_where('membership_payment', array(
                'membership_payment_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/membership_payment_view', $page_data);
        } elseif ($para1 == 'upgrade') {
            if($this->input->post('status')){
                $membership = $this->db->get_where('membership_payment',array('membership_payment_id'=>$para2))->row()->membership;
                $vendor = $this->db->get_where('membership_payment',array('membership_payment_id'=>$para2))->row()->vendor;
                $data['status'] = $this->input->post('status');
                $data['details'] = $this->input->post('details');
                if($data['status'] == 'paid'){
                    $this->crud_model->upgrade_membership($vendor,$membership);
                }
                
                $this->db->where('membership_payment_id', $para2);
                $this->db->update('membership_payment', $data);
            }
        } else {
            $page_data['page_name'] = "membership_payment";
            $page_data['all_membership_payments'] = $this->db->get('membership_payment')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }

    /* Vendor Management */
    function vendor($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('vendor')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'delete') {
            $this->db->where('vendor_id', $para2);
            $this->db->delete('vendor');
            recache();
        } else if ($para1 == 'list') {
            $this->db->order_by('vendor_id', 'desc');
            $page_data['all_vendors'] = $this->db->get('vendor')->result_array();
            $this->load->view('back/admin/vendor_list', $page_data);
        } else if ($para1 == 'view') {
            $page_data['vendor_data'] = $this->db->get_where('vendor', array(
                'vendor_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/vendor_view', $page_data);
        } else if ($para1 == 'pay_form') {
            $page_data['vendor_id'] = $para2;
            $this->load->view('back/admin/vendor_pay_form', $page_data);
        } else if ($para1 == 'approval') {
            $page_data['vendor_id'] = $para2;
            $page_data['status'] = $this->db->get_where('vendor', array(
											'vendor_id' => $para2
										))->row()->status;
            $this->load->view('back/admin/vendor_approval', $page_data);
        } else if ($para1 == 'add') {
            $this->load->view('back/admin/vendor_add');
        } else if ($para1 == 'approval_set') {
            $vendor = $para2;
			$approval = $this->input->post('approval');
            if ($approval == 'ok') {
                $data['status'] = 'approved';
            } else {
                $data['status'] = 'pending';
            }
            $this->db->where('vendor_id', $vendor);
            $this->db->update('vendor', $data);
            $this->email_model->status_email('vendor', $vendor);
            recache();
        } elseif ($para1 == 'pay') {
            $vendor         = $para2;
            $method         = $this->input->post('method');
            $amount         = $this->input->post('amount');
            $amount_in_usd  = $amount/$this->db->get_where('business_settings',array('type'=>'exchange'))->row()->value;
            if ($method == 'paypal') {
                $paypal_email  = $this->crud_model->get_type_name_by_id('vendor', $vendor, 'paypal_email');
                $data['vendor_id']      = $vendor;
                $data['amount']         = $this->input->post('amount');
                $data['status']         = 'due';
                $data['method']         = 'paypal';
                $data['timestamp']      = time();

                $this->db->insert('vendor_invoice', $data);
                $invoice_id           = $this->db->insert_id();
                $this->session->set_userdata('invoice_id', $invoice_id);
                
                /****TRANSFERRING USER TO PAYPAL TERMINAL****/
                $this->paypal->add_field('rm', 2);
                $this->paypal->add_field('no_note', 0);
                $this->paypal->add_field('cmd', '_xclick');
                
                $this->paypal->add_field('amount', $this->cart->format_number($amount_in_usd));

                //$this->paypal->add_field('amount', $grand_total);
                $this->paypal->add_field('custom', $invoice_id);
                $this->paypal->add_field('business', $paypal_email);
                $this->paypal->add_field('notify_url', base_url() . 'index.php/admin/paypal_ipn');
                $this->paypal->add_field('cancel_return', base_url() . 'index.php/admin/paypal_cancel');
                $this->paypal->add_field('return', base_url() . 'index.php/admin/paypal_success');
                
                $this->paypal->submit_paypal_post();
                // submit the fields to paypal

            } else if ($method == 'stripe') {
                if($this->input->post('stripeToken')) {
                                    
                    $vendor         = $para2;
                    $method         = $this->input->post('method');
                    $amount         = $this->input->post('amount');
                    $amount_in_usd  = $amount/$this->db->get_where('business_settings',array('type'=>'exchange'))->row()->value;
                    
                    $stripe_details      = json_decode($this->db->get_where('vendor', array(
                        'vendor_id' => $vendor
                    ))->row()->stripe_details,true);
                    $stripe_publishable  = $stripe_details['publishable'];
                    $stripe_api_key      =  $stripe_details['secret'];

                    require_once(APPPATH . 'libraries/stripe-php/init.php');
                    \Stripe\Stripe::setApiKey($stripe_api_key); //system payment settings
                    $vendor_email = $this->db->get_where('vendor' , array('vendor_id' => $vendor))->row()->email;
                    
                    $vendora = \Stripe\Customer::create(array(
                        'email' => $this->db->get_where('general_settings',array('type'=>'system_email'))->row()->value, // customer email id
                        'card'  => $_POST['stripeToken']
                    ));

                    $charge = \Stripe\Charge::create(array(
                        'customer'  => $vendora->id,
                        'amount'    => ceil($amount_in_usd*100),
                        'currency'  => 'AED'
                    ));

                    if($charge->paid == true){
                        $vendora = (array) $vendora;
                        $charge = (array) $charge;
                        
                        $data['vendor_id']          = $vendor;
                        $data['amount']             = $amount;
                        $data['status']             = 'paid';
                        $data['method']             = 'stripe';
                        $data['timestamp']          = time();
                        $data['payment_details']    = "Customer Info: \n".json_encode($vendora,true)."\n \n Charge Info: \n".json_encode($charge,true);
                        
                        $this->db->insert('vendor_invoice', $data);
                        
                        redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
                    } else {
                        $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                        redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
                    }
                    
                } else{
                    $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                    redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
                }

            } else if ($method == 'cash') {
                $data['vendor_id']          = $para2;
                $data['amount']             = $this->input->post('amount');
                $data['status']             = 'due';
                $data['method']             = 'cash';
                $data['timestamp']          = time();
                $data['payment_details']    = "";
                $this->db->insert('vendor_invoice', $data);
                redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
            }
        } 
        else if ($para1 == 'edit') 
        {
           $page_data['vendor_data'] = $this->db->get_where('vendor', array(
                'vendor_id' => $para2))->result_array();
           $this->load->view('back/admin/vendor_edit', $page_data);
        }
        elseif ($para1 == "update") 
        {
            $data['display_name'] = $this->input->post('disname');
            $data['admin_disname']=1;
            $this->db->where('vendor_id', $para2);
            $this->db->update('vendor', $data);
            if($this->input->post('member_change') == 'change')
            {
             $this->crud_model->upgrade_membership($para2,$this->input->post('membership'));
            }
        }
        else {
            $page_data['page_name'] = "vendor";
            $page_data['all_vendors'] = $this->db->get('vendor')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }


    
    
    
    /*Review List and approval*/
    
    
    function reviews($para1 = '', $para2 = '', $para3 = '')
    {
        /*if (!$this->crud_model->admin_permission('review_list')) {
            redirect(base_url() . 'index.php/admin');
        }*/
    
        if ($para1 == 'delete') {
            $this->db->where('review_id', $para2);
            $this->db->delete('reviews');
            recache();
        } else if ($para1 == 'list') {
       
            $this->db->order_by('review_id', 'desc');
            $page_data['all_reviews'] = $this->db->get('reviews')->result_array();
            $this->load->view('back/admin/review_list', $page_data);
        } else if ($para1 == 'view') {
            $page_data['review_id'] = $para2;
             $user_name = $this->crud_model->get_type_name_by_id('user',$row['user_id'],'username');
            $page_data['review_data'] = $this->db->get_where('reviews', array(
                'review_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/review_view', $page_data);
        } else if ($para1 == 'approval') {
            $page_data['review_id'] = $para2;
            $page_data['status'] = $this->db->get_where('reviews', array(
											'review_id' => $para2
										))->row()->status;
            $this->load->view('back/admin/review_approval', $page_data);
        } else if ($para1 == 'add') {
            $this->load->view('back/admin/vendor_add');
        } else if ($para1 == 'approval_set') {
            $vendor = $para2;
			$approval = $this->input->post('approval');
            if ($approval == 'ok') {
                $data['status'] = '1';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('review_id', $vendor);
            $this->db->update('reviews', $data);
           // $this->email_model->status_email('reviews', $vendor);
            recache();
        }   else {
            $page_data['page_name'] = "reviews";
            $page_data['all_reviews'] = $this->db->get('reviews')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*/Review List and approval*/
    
    
    
    
    
    /* FUNCTION: Verify paypal payment by IPN*/
    function paypal_ipn()
    {
        if ($this->paypal->validate_ipn() == true) {
            
            $data['status']             = 'paid';
            $data['payment_details']    = json_encode($_POST);
            $invoice_id                 = $_POST['custom'];
            $this->db->where('vendor_invoice_id', $invoice_id);
            $this->db->update('vendor_invoice', $data);
        }
    }
    

    /* FUNCTION: Loads after cancelling paypal*/
    function paypal_cancel()
    {
        $invoice_id = $this->session->userdata('invoice_id');
        $this->db->where('vendor_invoice_id', $invoice_id);
        $this->db->delete('vendor_invoice');
        $this->session->set_userdata('vendor_invoice_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel');
        redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
    }
    
    /* FUNCTION: Loads after successful paypal payment*/
    function paypal_success()
    {
        $this->session->set_userdata('invoice_id', '');
        redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
    }
    
    /* Membership Management */
    function membership($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('membership')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['title']    = $this->input->post('title');
            $data['price']    = $this->input->post('price');
            $data['timespan']    = $this->input->post('timespan');
            $data['product_limit']    = $this->input->post('product_limit');
            $this->db->insert('membership', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("img", "membership", $id, '', '', '.png');
        } else if ($para1 == 'edit') {
            $page_data['membership_data'] = $this->db->get_where('membership', array(
                'membership_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/membership_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['title']    = $this->input->post('title');
            $data['price']    = $this->input->post('price');
            $data['timespan']    = $this->input->post('timespan');
            $data['product_limit']    = $this->input->post('product_limit');
            $this->db->where('membership_id', $para2);
            $this->db->update('membership', $data);
            $this->crud_model->file_up("img", "membership", $para2, '', '', '.png');
        } elseif ($para1 == "default_set") {
            $this->db->where('type', "default_member_product_limit");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('product_limit')
            ));
            $this->crud_model->file_up("img", "membership", 0, '', '', '.png');
        } elseif ($para1 == 'delete') {
            $this->db->where('membership_id', $para2);
            $this->db->delete('membership');
        } elseif ($para1 == 'list') {
            $this->db->order_by('membership_id', 'desc');
            $page_data['all_memberships'] = $this->db->get('membership')->result_array();
            $this->load->view('back/admin/membership_list', $page_data);
        } elseif ($para1 == 'view') {
            $page_data['membership_data'] = $this->db->get_where('membership', array(
                'membership_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/membership_view', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/membership_add');
        } elseif ($para1 == 'default') {
            $this->load->view('back/admin/membership_default');
        } elseif ($para1 == 'publish_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'approved';
            } else {
                $data['status'] = 'pending';
            }
            $this->db->where('membership_id', $product);
            $this->db->update('membership', $data);
        } else {
            $page_data['page_name'] = "membership";
            $page_data['all_memberships'] = $this->db->get('membership')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Administrator Management */
    function admins($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('admin')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['name']      = $this->input->post('name');
            $data['email']     = $this->input->post('email');
            $data['phone']     = $this->input->post('phone');
            $data['address']   = $this->input->post('address');
            $password          = substr(hash('sha512', rand()), 0, 12);
            $data['password']  = sha1($password);
            $data['role']      = $this->input->post('role');
            $data['timestamp'] = time();
            $this->db->insert('admin', $data);
            $this->email_model->account_opening('admin', $data['email'], $password);
        } else if ($para1 == 'edit') {
            $page_data['admin_data'] = $this->db->get_where('admin', array(
                'admin_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/admin_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['name']    = $this->input->post('name');
            $data['email']   = $this->input->post('email');
            $data['phone']   = $this->input->post('phone');
            $data['address'] = $this->input->post('address');
            $data['role']    = $this->input->post('role');
            $this->db->where('admin_id', $para2);
            $this->db->update('admin', $data);
        } elseif ($para1 == 'delete') {
            $this->db->where('admin_id', $para2);
            $this->db->delete('admin');
        } elseif ($para1 == 'list') {
            $this->db->order_by('admin_id', 'desc');
            $page_data['all_admins'] = $this->db->get('admin')->result_array();
            $this->load->view('back/admin/admin_list', $page_data);
        } elseif ($para1 == 'view') {
            $page_data['admin_data'] = $this->db->get_where('admin', array(
                'admin_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/admin_view', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/admin_add');
        } else {
            $page_data['page_name']  = "admin";
            $page_data['all_admins'] = $this->db->get('admin')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Account Role Management */
    function role($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('role')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['name']        = $this->input->post('name');
            $data['permission']  = json_encode($this->input->post('permission'));
            $data['description'] = $this->input->post('description');
            $this->db->insert('role', $data);
        } elseif ($para1 == "update") {
            $data['name']        = $this->input->post('name');
            $data['permission']  = json_encode($this->input->post('permission'));
            $data['description'] = $this->input->post('description');
            $this->db->where('role_id', $para2);
            $this->db->update('role', $data);
        } elseif ($para1 == 'delete') {
            $this->db->where('role_id', $para2);
            $this->db->delete('role');
        } elseif ($para1 == 'list') {
            $this->db->order_by('role_id', 'desc');
            $page_data['all_roles'] = $this->db->get('role')->result_array();
            $this->load->view('back/admin/role_list', $page_data);
        } elseif ($para1 == 'view') {
            $page_data['role_data'] = $this->db->get_where('role', array(
                'role_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/role_view', $page_data);
        } elseif ($para1 == 'add') {
            $page_data['all_permissions'] = $this->db->get('permission')->result_array();
            $this->load->view('back/admin/role_add', $page_data);
        } else if ($para1 == 'edit') {
            $page_data['all_permissions'] = $this->db->get('permission')->result_array();
            $page_data['role_data']       = $this->db->get_where('role', array(
                'role_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/role_edit', $page_data);
        } else {
            $page_data['page_name'] = "role";
            $page_data['all_roles'] = $this->db->get('role')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    
    /* Checking if email exists*/
    function load_dropzone()
    {
        $this->load->view('back/admin/dropzone');
    }

    /* Checking if email exists*/
    function exists()
    {
        $email  = $this->input->post('email');
        $admin  = $this->db->get('admin')->result_array();
        $exists = 'no';
        foreach ($admin as $row) {
            if ($row['email'] == $email) {
                $exists = 'yes';
            }
        }
        echo $exists;
    }
    
  function existscat()
    {
        $email  = $this->input->post('email');
        $user   = $this->db->get('category')->result_array();
        $exists = 'no';
        foreach ($user as $row) {
            if ($row['category_name'] == $email) {
                $exists = 'yes';
            }
        }
        echo $exists;
    }
    

  function existssubcat()
    {
        $email  = $this->input->post('email');
        $email2 = $this->input->post('email2');

        //$user   = $this->db->get('category')->result_array();

        $user = $this->db->get_where('sub_category', array('category' => $this->input->post('email2')))->result_array();

        $exists = 'no';

        foreach ($user as $row) {
            if (strcasecmp($row['sub_category_name'], $email) == 0) {
                $exists = 'yes';
            }
        }
        echo $exists;
    }
//product code exists

function pcode_exists()
{
    $prcode = $this->input->post('p_code');    
    $user = $this->db->get_where('product', array('product_code' => $prcode ));
    $exists = 'no';
    if ($user->num_rows() > 0)
    { 
    $exists = 'yes';
    }
    echo $exists;
}
    
    /* Login into Admin panel */
    function login($para1 = '')
    {
        if ($para1 == 'forget_form') 
		{
            $page_data['control'] = 'admin';
            $this->load->view('back/forget_password',$page_data);
        } 
		else if ($para1 == 'forget') 
		{
        	$this->load->library('form_validation');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');			
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
				$query = $this->db->get_where('admin', array(
					'email' => $this->input->post('email')
				));
				if ($query->num_rows() > 0) {
					$admin_id         = $query->row()->admin_id;
					$password         = substr(hash('sha512', rand()), 0, 12);
					$data['password'] = sha1($password);
					$this->db->where('admin_id', $admin_id);
					$this->db->update('admin', $data);
					if ($this->email_model->password_reset_email('admin', $admin_id, $password)) {
						echo 'email_sent';
					} else {
						echo 'email_not_sent';
					}
				} else {
					echo 'email_nay';
				}
			}
        }
		else 
		{
        	$this->load->library('form_validation');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required');
			
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
				$login_data = $this->db->get_where('admin', array(
					'email' => $this->input->post('email'),
					'password' => sha1($this->input->post('password'))
				));
				if ($login_data->num_rows() > 0) {
					foreach ($login_data->result_array() as $row) {
						$this->session->set_userdata('login', 'yes');
						$this->session->set_userdata('admin_login', 'yes');
						$this->session->set_userdata('admin_id', $row['admin_id']);
						$this->session->set_userdata('admin_name', $row['name']);
						$this->session->set_userdata('title', 'admin');
                        $login_id='a_'.$row['admin_id'];
						echo 'lets_login';
					}

                    $datas['login_id']=$login_id;
                    $this->db->delete('ci_sessions',array('login_id' => $login_id));
                    $this->db->where('id',session_id());
                    $this->db->update('ci_sessions',$datas);

				} else {
					echo 'login_failed';
				}
			}
        }
    }
    
    /* Loging out from Admin panel */
    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . 'admin', 'refresh');
    }
    
    /* Sending Newsletters */
    function newsletter($para1 = "")
    {
        if (!$this->crud_model->admin_permission('newsletter')) {
            redirect(base_url() . 'admin');
        }
        if ($para1 == "send") 
		{
            //$users       = explode(',', $this->input->post('users'));
            $subscribers = explode(',', $this->input->post('subscribers'));
            $text        = $this->input->post('text');
            $title       = $this->input->post('title');
            $from        = $this->input->post('from');
            /*
			foreach ($users as $key => $user) 
			{
                if ($user !== '') {
                    $this->email_model->newsletter($title, $text, $user, $from);
                }
            }
			*/
            foreach ($subscribers as $key => $subscriber) 
			{
                if ($subscriber !== '') 
				{
                    $this->email_model->newsletter($title, $text, $subscriber, $from);
                }
            }
			echo json_encode($this->input->post());
        } 
		else 
		{
            $page_data['users']       = array();//$this->db->get('user')->result_array();
            $page_data['subscribers'] = $this->db->get('subscribe')->result_array();
            $page_data['page_name']   = "newsletter";
            $this->load->view('back/index', $page_data);
        }
    }


/*quote_request_recepients*/
function quote_recepients($para1 = "")
    {
          if ($para1 == "send") {
            $users       = explode(',', $this->input->post('quote_receiver'));
            $subscribers = explode(',', $this->input->post('service_receiver'));
              var_dump($subscribers);  
           $this->db->empty_table('quote_mail');
           $this->db->empty_table('request_mail');
            foreach ($users as $key => $user) {
                if ($user !== '') {
                    $data['quote_email']=$user;
                     $this->db->insert('quote_mail', $data);
                  //  $this->insert->newsletter($title, $text, $user, $from);
                }
            }
            foreach ($subscribers as $key => $subscriber) {
                if ($subscriber !== '') {
                    $data1['request_email']=$subscriber;
                    $this->db->insert('request_mail', $data1);
                }
            }
        } else {
            $page_data['users']       = $this->db->get('quote_mail')->result_array();
            $page_data['subscribers'] = $this->db->get('request_mail')->result_array();
           $page_data['page_name']   = "quote_recepients";
         $this->load->view('back/index', $page_data);
        }
    }
    /*quote_request_recepients*/


    
    
    /* Add, Edit, Delete, Duplicate, Enable, Disable Sliders */
    function slider($para1 = '', $para2 = '', $para3 = '')
    {
        if ($para1 == 'list') {
            $this->db->order_by('slider_id', 'desc');
            $page_data['all_slider'] = $this->db->get('slider')->result_array();
            $this->load->view('back/admin/slider_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/slider_set');
        } elseif ($para1 == 'add_form') {
            $page_data['style_id'] = $para2;
            $page_data['style']    = json_decode($this->db->get_where('slider_style', array(
                'slider_style_id' => $para2
            ))->row()->value, true);
            $this->load->view('back/admin/slider_add_form', $page_data);
        } else if ($para1 == 'delete') { //ll
            $elements = json_decode($this->db->get_where('slider', array(
                'slider_id' => $para2
            ))->row()->elements, true);
            $style    = $this->db->get_where('slider', array(
                'slider_id' => $para2
            ))->row()->style;
            $style    = json_decode($this->db->get_where('slider_style', array(
                'slider_style_id' => $style
            ))->row()->value, true);
            $images   = $style['images'];
            if (file_exists('uploads/slider_image/background_' . $para2 . '.jpg')) {
                unlink('uploads/slider_image/background_' . $para2 . '.jpg');
            }
            foreach ($images as $row) {
                if (file_exists('uploads/slider_image/' . $para2 . '_' . $row . '.png')) {
                    unlink('uploads/slider_image/' . $para2 . '_' . $row . '.png');
                }
            }
            $this->db->where('slider_id', $para2);
            $this->db->delete('slider');
            recache();
        } else if ($para1 == 'serial') {
            $this->db->order_by('serial', 'desc');
            $this->db->order_by('slider_id', 'desc');
            $page_data['slider'] = $this->db->get_where('slider', array(
                'status' => 'ok'
            ))->result_array();
            $this->load->view('back/admin/slider_serial', $page_data);
        } else if ($para1 == 'do_serial') {
            $input  = json_decode($this->input->post('serial'), true);
            $serial = array();
            foreach ($input as $r) {
                $serial[] = $r['id'];
            }
            $serial  = array_reverse($serial);
            $sliders = $this->db->get('slider')->result_array();
            foreach ($sliders as $row) {
                $data['serial'] = 0;
                $this->db->where('slider_id', $row['slider_id']);
                $this->db->update('slider', $data);
            }
            foreach ($serial as $i => $row) {
                $data1['serial'] = $i + 1;
                $this->db->where('slider_id', $row);
                $this->db->update('slider', $data1);
            }
            recache();
        } else if ($para1 == 'slider_publish_set') {
            $slider = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
                $data['serial'] = 0;
            }
            $this->db->where('slider_id', $slider);
            $this->db->update('slider', $data);
            recache();
        } else if ($para1 == 'edit') {
            $page_data['slider_data'] = $this->db->get_where('slider', array(
                'slider_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/slider_edit_form', $page_data);
        } elseif ($para1 == 'create') {
            $data['style']  = $this->input->post('style_id');
            $data['title']  = $this->input->post('title');
            $data['serial'] = 0;
            $data['status'] = 'ok';
            $style          = json_decode($this->db->get_where('slider_style', array(
                'slider_style_id' => $data['style']
            ))->row()->value, true);
            $images         = array();
            $texts          = array();
            foreach ($style['images'] as $image) {
                if ($_FILES[$image['name']]['name']) {
                    $images[] = $image['name'];
                }
            }
            foreach ($style['texts'] as $text) {
                if ($this->input->post($text['name']) !== '') {
                    $texts[] = array(
                        'name' => $text['name'],
                        'text' => $this->input->post($text['name']),
                        'color' => $this->input->post($text['name'] . '_color'),
                        'background' => $this->input->post($text['name'] . '_background')
                    );
                }
            }
            $elements         = array(
                'images' => $images,
                'texts' => $texts
            );
            $data['elements'] = json_encode($elements);
            $this->db->insert('slider', $data);
            $id = $this->db->insert_id();
            
            move_uploaded_file($_FILES['background']['tmp_name'], 'uploads/slider_image/background_' . $id . '.jpg');
            foreach ($elements['images'] as $image) {
                move_uploaded_file($_FILES[$image]['tmp_name'], 'uploads/slider_image/' . $id . '_' . $image . '.png');
            }
            recache();
        } elseif ($para1 == 'update') {
            $data['style'] = $this->input->post('style_id');
            $data['title'] = $this->input->post('title');
            $style         = json_decode($this->db->get_where('slider_style', array(
                'slider_style_id' => $data['style']
            ))->row()->value, true);
            $images        = array();
            $texts         = array();
            foreach ($style['images'] as $image) {
                if ($_FILES[$image['name']]['name'] || $this->input->post($image['name'] . '_same') == 'same') {
                    $images[] = $image['name'];
                }
            }
            foreach ($style['texts'] as $text) {
                if ($this->input->post($text['name']) !== '') {
                    $texts[] = array(
                        'name' => $text['name'],
                        'text' => $this->input->post($text['name']),
                        'color' => $this->input->post($text['name'] . '_color'),
                        'background' => $this->input->post($text['name'] . '_background')
                    );
                }
            }
            $elements         = array(
                'images' => $images,
                'texts' => $texts
            );
            $data['elements'] = json_encode($elements);
            $this->db->where('slider_id', $para2);
            $this->db->update('slider', $data);
            
            move_uploaded_file($_FILES['background']['tmp_name'], 'uploads/slider_image/background_' . $para2 . '.jpg');
            foreach ($elements['images'] as $image) {
                move_uploaded_file($_FILES[$image]['tmp_name'], 'uploads/slider_image/' . $para2 . '_' . $image . '.png');
            }
            recache();
        } else {
            $page_data['page_name'] = "slider";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage Frontend User Interface */
    function ui_settings($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('site_settings')) 
		{
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "ui_home") {
            if ($para2 == 'update') {
                $this->db->where('type', "side_bar_pos");
                $this->db->update('ui_settings', array(
                    'value' => $this->input->post('side_bar_pos')
                ));
                $this->db->where('type', "latest_item_div");
                $this->db->update('ui_settings', array(
                    'value' => $this->input->post('latest_item_div')
                ));
                $this->db->where('type', "most_popular_div");
                $this->db->update('ui_settings', array(
                    'value' => $this->input->post('most_popular_div')
                ));
                $this->db->where('type', "most_view_div");
                $this->db->update('ui_settings', array(
                    'value' => $this->input->post('most_view_div')
                ));
                $this->db->where('type', "home_category");
                $this->db->update('ui_settings', array(
                    'value' => json_encode($this->input->post('category'))
                ));
                $this->db->where('type', "home_brand");
                $this->db->update('ui_settings', array(
                    'value' => json_encode($this->input->post('brand'))
                ));
                recache();
            }
        }
        if ($para1 == "ui_category") {
            if ($para2 == 'update') {
                $this->db->where('type', "side_bar_pos_category");
                $this->db->update('ui_settings', array(
                    'value' => $this->input->post('side_bar_pos')
                ));
                recache();
            }
        }
        $this->load->view('back/index', $page_data);
    }
    
    /* Checking Login Stat */
    function is_logged()
    {
        if ($this->session->userdata('admin_login') == 'yes') {
            echo 'yah!good';
        } else {
            echo 'nope!bad';
        }
    }
    
    /* Manage Frontend User Interface */
    function page_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $page_data['page_name'] = "page_settings";
        $page_data['tab_name']  = $para1;
        $this->load->view('back/index', $page_data);
    }
    
    /* Manage Frontend User Messages */
    function contact_message($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->admin_permission('contact_message')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'delete') {
            $this->db->where('contact_message_id', $para2);
            $this->db->delete('contact_message');
        } elseif ($para1 == 'list') {
            $this->db->order_by('contact_message_id', 'desc');
            $page_data['contact_messages'] = $this->db->get('contact_message')->result_array();
             $this->load->view('back/admin/contact_message_list', $page_data);
        } elseif ($para1 == 'reply') {
            $data['reply'] = $this->input->post('reply');
            $this->db->where('contact_message_id', $para2);
            $this->db->update('contact_message', $data);
            $this->db->order_by('contact_message_id', 'desc');
            $query = $this->db->get_where('contact_message', array(
                'contact_message_id' => $para2
            ))->row();
            $this->email_model->do_email($data['reply'], 'RE: ' . $query->subject, $query->email);
        } elseif ($para1 == 'view') {
            $page_data['message_data'] = $this->db->get_where('contact_message', array(
                'contact_message_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/contact_message_view', $page_data);
        } elseif ($para1 == 'reply_form') {
            $page_data['message_data'] = $this->db->get_where('contact_message', array(
                'contact_message_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/contact_message_reply', $page_data);
        } else {
            $page_data['page_name']        = "contact_message";
            $page_data['contact_messages'] = $this->db->get('contact_message')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage Logos */
    function logo_settings($para1 = "", $para2 = "", $para3 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "select_logo") {
            $page_data['page_name'] = "select_logo";
        } elseif ($para1 == "delete_logo") {
            if (file_exists("uploads/logo_image/logo_" . $para2 . ".png")) {
                unlink("uploads/logo_image/logo_" . $para2 . ".png");
            }
            $this->db->where('logo_id', $para2);
            $this->db->delete('logo');
            recache();
        } elseif ($para1 == "set_logo") {
            $type    = $this->input->post('type');
            $logo_id = $this->input->post('logo_id');
            $this->db->where('type', $type);
            $this->db->update('ui_settings', array(
                'value' => $logo_id
            ));
            recache();
        } elseif ($para1 == "show_all") {
            $page_data['logo'] = $this->db->get('logo')->result_array();
            if ($para2 == "") {
                $this->load->view('back/admin/all_logo', $page_data);
            }
            if ($para2 == "selectable") {
                $page_data['logo_type'] = $para3;
                $this->load->view('back/admin/select_logo', $page_data);
            }
        } elseif ($para1 == "upload_logo") {
            foreach ($_FILES["file"]['name'] as $i => $row) {
                $data['name'] = '';
                $this->db->insert("logo", $data);
                $id = $this->db->insert_id();
                move_uploaded_file($_FILES["file"]['tmp_name'][$i], 'uploads/logo_image/logo_' . $id . '.png');
            }
            return;
        } else {
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage Favicons */
    function favicon_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $name = $_FILES["fav"]["name"];
        $ext  = end((explode(".", $name)));
        move_uploaded_file($_FILES["fav"]['tmp_name'], 'uploads/others/favicon.' . $ext);
        $this->db->where('type', "fav_ext");
        $this->db->update('ui_settings', array(
            'value' => $ext
        ));
        recache();
    }
    
   /* Manage Coupon */
    function coupon_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        
        $this->db->where('type', "coupon_set");
        $this->db->update('ui_settings', array(
                'value' => $this->input->post('coupon_set')
            ));        recache();
    } 
    
    /*manage quote messages*/
    
     function quote_message($para1 = "", $para2 = "")
    {

        if ($para1 == 'delete') {
            $this->db->where('quote_message_id', $para2);
            $this->db->delete('quote_message');
        } elseif ($para1 == 'list') {
            $this->db->order_by('quote_message_id', 'desc');
            $page_data['quote_messages'] = $this->db->get('quote_message')->result_array();
            $this->load->view('back/admin/quote_message_list', $page_data);
        } elseif ($para1 == 'reply') {
            $data['reply'] = $this->input->post('reply');
            $this->db->where('quote_message_id', $para2);
            $this->db->update('quote_message', $data);
            $this->db->order_by('quote_message_id', 'desc');
            $query = $this->db->get_where('quote_message', array(
                'quote_message_id' => $para2
            ))->row();
            $this->email_model->do_email($data['reply'], 'RE: ' . $query->subject, $query->email);
        } elseif ($para1 == 'view') {
            $data['view']="1";
            $this->db->where('quote_message_id', $para2);
            $this->db->update('quote_message',$data);
            $page_data['message_data'] = $this->db->get_where('quote_message', array(
                'quote_message_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/quote_message_view', $page_data);
        } elseif ($para1 == 'reply_form') {
            $page_data['message_data'] = $this->db->get_where('quote_message', array(
                'quote_message_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/quote_message_reply', $page_data);
        } else {
            $page_data['page_name']        = "quote_message";
            $page_data['contact_messages'] = $this->db->get('quote_message')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    /*manage quote messages*/
    
    
    
    
    
    
    
    /* Manage Frontend Facebook Login Credentials */
    /*function social_login_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $this->db->where('type', "fb_appid");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('appid')
        ));
        $this->db->where('type', "fb_secret");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('secret')
        ));
        $this->db->where('type', "application_name");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('application_name')
        ));
        $this->db->where('type', "client_id");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('client_id')
        ));
        $this->db->where('type', "client_secret");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('client_secret')
        ));
        $this->db->where('type', "redirect_uri");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('redirect_uri')
        ));
        $this->db->where('type', "api_key");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('api_key')
        ));
    }*/
    
    /* Manage Frontend Facebook Login Credentials */
    /*function product_comment($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $this->db->where('type', "discus_id");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('discus_id')
        ));
        $this->db->where('type', "comment_type");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('type')
        ));
        $this->db->where('type', "fb_comment_api");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('fb_comment_api')
        ));
    }
    */
    /* Manage Frontend Captcha Settings Credentials */
    function captcha_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $this->db->where('type', "captcha_public");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('cpub')
        ));
        $this->db->where('type', "captcha_private");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('cprv')
        ));
    }
    
    /* Manage Site Settings */
    function site_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $page_data['page_name'] = "site_settings";
        $page_data['tab_name']  = $para1;
        $this->load->view('back/index', $page_data);
    }
    
    /* Manage Languages */
    function language_settings($para1 = "", $para2 = "", $para3 = "")
    {
        if (!$this->crud_model->admin_permission('language')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'add_lang') {
            $this->load->view('back/admin/language_add');
        } elseif ($para1 == 'lang_list') {
            //if($para2 !== ''){
            $this->db->order_by('word_id', 'desc');
            $page_data['words'] = $this->db->get('language')->result_array();
            $page_data['lang']  = $para2;
            $this->load->view('back/admin/language_list', $page_data);
            //}
        } elseif ($para1 == 'list_data') {
            $limit      = $this->input->get('limit');
            $search     = $this->input->get('search');
            $order      = $this->input->get('order');
            $offset     = $this->input->get('offset');
            $sort       = $this->input->get('sort');
            if($search){
                $this->db->like('word', $search, 'both');
            }
            $total      = $this->db->get('language')->num_rows();
            $this->db->limit($limit);
            if($sort == ''){
                $sort = 'word_id';
                $order = 'DESC';
            }
            $this->db->order_by($sort,$order);
            if($search){
                $this->db->like('word', $search, 'both');
            }
            $lang       = $para2;
            if ($lang == 'undefined' || $lang == '') {
                if ($lang = $this->session->userdata('language')) {
                } else {
                    $lang = $this->db->get_where('general_settings', array(
                        'type' => 'language'
                    ))->row()->value;
                }
            }
            $words      = $this->db->get('language', $limit, $offset)->result_array();
            $data       = array();
            foreach ($words as $row) {

                $res    = array(
                             'no' => '',
                             'word' => '',
                             'translation' => '',
                             'options' => ''
                          );

                $res['no']  = $row['word_id'];
                $res['word']  = str_replace('_', ' ', $row['word']);
                $res['translation']  =   form_open(base_url() . 'index.php/admin/language_settings/upd_trn/'.$row['word_id'], array(
                                            'class' => 'form-horizontal trs',
                                            'method' => 'post',
                                            'id' => $lang.'_'.$row['word_id']
                                        ));
                $res['translation']  .=      '   <div class="col-md-8">';
                $res['translation']  .=      '      <input type="text" name="translation" value="'.$row[$lang].'" class ="form-control ann" />';
                $res['translation']  .=      '      <input type="hidden" name="lang" value="'.$lang.'" />';
                $res['translation']  .=      '   </div>';
                $res['translation']  .=      '   <div class="col-md-4">';
                $res['translation']  .=      '       <span class="btn btn-success btn-xs btn-labeled fa fa-wrench submittera" data-wid="'.$lang.'_'.$row['word_id'].'"  data-ing="'.translate('saving').'" data-msg="'.translate('updated!').'" >'.translate('save').'</span>';
                $res['translation']  .=      '   </div>';
                $res['translation']  .=      '</form>';

                //add html for action
                $res['options'] = "<a onclick=\"delete_confirm('".$row['word_id']."','".translate('really_want_to_delete_this_word?')."')\" 
                                class=\"btn btn-danger btn-xs btn-labeled fa fa-trash\" data-toggle=\"tooltip\" data-original-title=\"Delete\" data-container=\"body\">
                                    ".translate('delete')."
                            </a>";
                $data[] = $res;
            }
            $result = array(
                             'total' => $total,
                             'rows' => $data
                           );

            echo json_encode($result);

        } elseif ($para1 == 'add_word') {
            $page_data['lang'] = $para2;
            $this->load->view('back/admin/language_word_add', $page_data);
            recache();
        } elseif ($para1 == 'upd_trn') {
            $word_id     = $para2;
            $translation = $this->input->post('translation');
            $language    = $this->input->post('lang');
            $word        = $this->db->get_where('language', array(
                'word_id' => $word_id
            ))->row()->word;
            add_translation($word, $language, $translation);
            recache();
        } elseif ($para1 == 'do_add_word') {
            $language = $para2;
            $word     = $this->input->post('word');
            add_lang_word($word);
            recache();
        } elseif ($para1 == 'do_add_lang') {
            $language = $this->input->post('language');
            add_language($language);
            recache();
        } elseif ($para1 == 'check_existed') {
            echo lang_check_exists($para2);
        } elseif ($para1 == 'lang_select') {
            $this->load->view('back/admin/language_select');
        } elseif ($para1 == 'dlt_lang') {
            $this->load->dbforge();
            $this->dbforge->drop_column('language', $para2);
            recache();
        } elseif ($para1 == 'dlt_word') {
            $this->db->where('word_id', $para2);
            $this->db->delete('language');
            recache();
        } else {
            $page_data['page_name'] = "language";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage Business Settings */
    function business_settings($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->admin_permission('business_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "cash_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('type', "cash_set");
            $this->db->update('business_settings', array(
                'value' => $val
            ));
            recache();
        }
        if ($para1 == "paypal_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('type', "paypal_set");
            $this->db->update('business_settings', array(
                'value' => $val
            ));
            recache();
        }
        
        
        /*payfort*/
        if ($para1 == "payfort_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('type', "payfort_set");
            $this->db->update('business_settings', array(
                'value' => $val
            ));
            recache();
        }
        /*/payfort*/
        
        if ($para1 == "stripe_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('type', "stripe_set");
            $this->db->update('business_settings', array(
                'value' => $val
            ));
            recache();
        }
        if ($para1 == 'set') {
            
            /*PAYFORT*/
            
              $this->db->where('type', "payfort_accesscode");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('payfort_accesscode')
            )); 
            $this->db->where('type', "payfort_sha_type");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('payfort_sha_type')
            )); 
            $this->db->where('type', "payfort_sha_request");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('payfort_sha_request')
            )); 
            $this->db->where('type', "payfort_sha_response");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('payfort_sha_response')
            ));
            /*/payfort*/
            
            
            $this->db->where('type', "paypal_email");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('paypal_email')
            ));
            $this->db->where('type', "paypal_type");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('paypal_type')
            ));
            $this->db->where('type', "stripe_secret");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('stripe_secret')
            ));
            $this->db->where('type', "stripe_publishable");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('stripe_publishable')
            ));
            $this->db->where('type', "currency");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('currency')
            ));
            $this->db->where('type', "currency_name");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('currency_name')
            ));
            $this->db->where('type', "exchange");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('exchange')
            ));
            $this->db->where('type', "shipping_cost_type");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('shipping_cost_type')
            ));
            $this->db->where('type', "shipping_cost");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('shipping_cost')
            ));
            $this->db->where('type', "shipment_info");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('shipment_info')
            ));
            $this->db->where('type', "shipment_method");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('shipment_method')));
            $faqs = array();
            $f_q  = $this->input->post('f_q');
            $f_a  = $this->input->post('f_a');
            foreach ($f_q as $i => $r) {
                $faqs[] = array(
                    'question' => $f_q[$i],
                    'answer' => $f_a[$i]
                );
            }
            $this->db->where('type', "faqs");
            $this->db->update('business_settings', array(
                'value' => json_encode($faqs)
            ));
            recache();
        } else {
            $page_data['page_name'] = "business_settings";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage Admin Settings */
    function manage_admin($para1 = "")
    {
        if ($this->session->userdata('admin_login') != 'yes') {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'update_password') {
            $user_data['password'] = $this->input->post('password');
            $account_data          = $this->db->get_where('admin', array(
                'admin_id' => $this->session->userdata('admin_id')
            ))->result_array();
            foreach ($account_data as $row) {
                if (sha1($user_data['password']) == $row['password']) {
                    if ($this->input->post('password1') == $this->input->post('password2')) {
                        $data['password'] = sha1($this->input->post('password1'));
                        $this->db->where('admin_id', $this->session->userdata('admin_id'));
                        $this->db->update('admin', $data);
                        echo 'updated';
                    }
                } else {
                    echo 'pass_prb';
                }
            }
        } else if ($para1 == 'update_profile') {
            $this->db->where('admin_id', $this->session->userdata('admin_id'));
            $this->db->update('admin', array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'phone' => $this->input->post('phone')
            ));
        } else {
            $page_data['page_name'] = "manage_admin";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Page Management */
    function page($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('page')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $parts             = array();
            $data['page_name'] = $this->input->post('page_name');
            $data['parmalink'] = $this->input->post('parmalink');
            $size              = $this->input->post('part_size');
            $type              = $this->input->post('part_content_type');
            $content           = $this->input->post('part_content');
            $widget            = $this->input->post('part_widget');
            var_dump($widget);
            foreach ($size as $in => $row) {
                $parts[] = array(
                    'size' => $size[$in],
                    'type' => $type[$in],
                    'content' => $content[$in],
                    'widget' => $widget[$in]
                );
            }
            $data['parts']  = json_encode($parts);
            $data['status'] = 'ok';
            $this->db->insert('page', $data);
            recache();
        } else if ($para1 == 'edit') {
            $page_data['page_data'] = $this->db->get_where('page', array(
                'page_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/page_edit', $page_data);
        } elseif ($para1 == "update") {
            $parts             = array();
            $data['page_name'] = $this->input->post('page_name');
            $data['parmalink'] = $this->input->post('parmalink');
            $size              = $this->input->post('part_size');
            $type              = $this->input->post('part_content_type');
            $content           = $this->input->post('part_content');
            $widget            = $this->input->post('part_widget');
            var_dump($widget);
            foreach ($size as $in => $row) {
                $parts[] = array(
                    'size' => $size[$in],
                    'type' => $type[$in],
                    'content' => $content[$in],
                    'widget' => $widget[$in]
                );
            }
            $data['parts'] = json_encode($parts);
            $this->db->where('page_id', $para2);
            $this->db->update('page', $data);
            recache();
        } elseif ($para1 == 'delete') {
            $this->db->where('page_id', $para2);
            $this->db->delete('page');
            recache();
        } elseif ($para1 == 'list') {
            $this->db->order_by('page_id', 'desc');
            $page_data['all_page'] = $this->db->get('page')->result_array();
            $this->load->view('back/admin/page_list', $page_data);
        } else if ($para1 == 'page_publish_set') {
            $page = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('page_id', $page);
            $this->db->update('page', $data);
            recache();
        } elseif ($para1 == 'view') {
            $page_data['page_data'] = $this->db->get_where('page', array(
                'page_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/page_view', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/page_add');
        } else {
            $page_data['page_name'] = "page";
            $page_data['all_pages'] = $this->db->get('page')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage General Settings */
    function general_settings($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "terms") {
            $this->db->where('type', "terms_conditions");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('terms')
            ));
        }
        if ($para1 == "privacy_policy") 
        {
            $this->db->where('type', "privacy_policy");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('privacy_policy')
            ));
        }

        if ($para1 == "return_policy") 
        {
            $this->db->where('type', "return_policy");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('return_policy')
            ));
        }

        if ($para1 == "warranty_terms") 
        {
            $this->db->where('type', "warranty_terms");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('warranty_terms')
            ));
        }
		if ($para1 == "shipping_handling") 
        {
            $this->db->where('type', "shipping_handling");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('shipping_handling')
            ));
        }

        if ($para1 == "set_slider") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            $this->db->where('type', "slider");
            $this->db->update('general_settings', array(
                'value' => $val
            ));
        }
        if ($para1 == "set_slides") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            $this->db->where('type', "slides");
            $this->db->update('general_settings', array(
                'value' => $val
            ));
        }
        if ($para1 == "set_admin_notification_sound") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }            $this->db->where('type', "admin_notification_sound");
            $this->db->update('general_settings', array(
                'value' => $val
            ));
        }
        if ($para1 == "set_home_notification_sound") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            $this->db->where('type', "home_notification_sound");
            $this->db->update('general_settings', array(
                'value' => $val
            ));
        }
        if ($para1 == "fb_login_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('type', "fb_login_set");
            $this->db->update('general_settings', array(
                'value' => $val
            ));
        }
        if ($para1 == "g_login_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('type', "g_login_set");
            $this->db->update('general_settings', array(
                'value' => $val
            ));
        }
        if ($para1 == "set") {
            $this->db->where('type', "system_name");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('system_name')
            ));
            $this->db->where('type', "system_email");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('system_email')
            ));

            $file_folder = $this->db->get_where('general_settings', array('type' => 'file_folder'))->row()->value;
            if(rename("uploads/file_products/".$file_folder,"uploads/file_products/".$this->input->post('file_folder'))){
                $this->db->where('type', "file_folder");
                $this->db->update('general_settings', array(
                    'value' => $this->input->post('file_folder')
                ));
            }            

            $this->db->where('type', "system_title");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('system_title')
            ));
            $this->db->where('type', "cache_time");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('cache_time')
            ));
            $this->db->where('type', "vendor_system");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('vendor_system')
            ));
//            $this->db->where('type', "language");
//            $this->db->update('general_settings', array(
//                'value' => $this->input->post('language')
//            ));
            $volume = $this->input->post('admin_notification_volume');
            $this->db->where('type', "admin_notification_volume");
            $this->db->update('general_settings', array(
                'value' => $volume
            ));
            $volume = $this->input->post('homepage_notification_volume');
            $this->db->where('type', "homepage_notification_volume");
            $this->db->update('general_settings', array(
                'value' => $volume
            ));
        }
        if ($para1 == "contact") {
            $this->db->where('type', "contact_address");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('contact_address')
            ));
            $this->db->where('type', "contact_email");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('contact_email')
            ));
            $this->db->where('type', "contact_phone");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('contact_phone')
            ));
            $this->db->where('type', "contact_website");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('contact_website')
            ));
            $this->db->where('type', "contact_about");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('contact_about')
            ));
        }
        if ($para1 == "footer") {
            $this->db->where('type', "footer_text");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('footer_text', 'chaira_de')
            ));
            $this->db->where('type', "footer_category");
            $this->db->update('general_settings', array(
                'value' => json_encode($this->input->post('footer_category'))
            ));
        }
        if ($para1 == "color") {
            $this->db->where('type', "header_color");
            $this->db->update('ui_settings', array(
                'value' => $this->input->post('header_color')
            ));
            $this->db->where('type', "footer_color");
            $this->db->update('ui_settings', array(
                'value' => $this->input->post('footer_color')
            ));
        }
        recache();
    }
    
    /* Manage Social Links */
    function social_links($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "set") {
            $this->db->where('type', "facebook");
            $this->db->update('social_links', array(
                'value' => $this->input->post('facebook')
            ));
            $this->db->where('type', "google-plus");
            $this->db->update('social_links', array(
                'value' => $this->input->post('google-plus')
            ));
            $this->db->where('type', "twitter");
            $this->db->update('social_links', array(
                'value' => $this->input->post('twitter')
            ));
            $this->db->where('type', "skype");
            $this->db->update('social_links', array(
                'value' => $this->input->post('skype')
            ));
            $this->db->where('type', "pinterest");
            $this->db->update('social_links', array(
                'value' => $this->input->post('pinterest')
            ));
            $this->db->where('type', "youtube");
            $this->db->update('social_links', array(
                'value' => $this->input->post('youtube')
            ));
            redirect(base_url() . 'index.php/admin/site_settings/social_links/', 'refresh');
        }
        recache();
    }
    
   function about()
{
    //Get the value from the form.
    $search = $this->input->post('sel1');

    //Put the value in an array to pass to the view. 
    $view_data['search'] = $search;

    //Pass to the value to the view. Access it as '$search' in the view.
    $this->load->view("about", $view_data);
}

    
    function activation(){
        if (!$this->crud_model->admin_permission('business_settings')) {
            redirect(base_url() . 'admin');
        }
        $page_data['page_name'] = "activation";
        $this->load->view('back/index', $page_data);
    }
    function payment_method(){
        if (!$this->crud_model->admin_permission('business_settings')) {
            redirect(base_url() . 'admin');
        }
        $page_data['page_name'] = "payment_method";
        $this->load->view('back/index', $page_data);
    }
    
    /* Manage SEO relateds */
    function seo_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('seo')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "set") {
            $this->db->where('type', "meta_description");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('description')
            ));
            $this->db->where('type', "meta_keywords");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('keywords')
            ));
            $this->db->where('type', "meta_author");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('author')
            ));

            $this->db->where('type', "revisit_after");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('revisit_after')
            ));
            recache();
        }
        else {
            require_once (APPPATH . 'libraries/SEOstats/bootstrap.php');
            $page_data['page_name'] = "seo";
            $this->load->view('back/index', $page_data);
        }
    }

 /*Product Group add, edit, view, delete */
    function product_group($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('product')) 
        {
            redirect(base_url() . 'index.php/admin');
        }

        if ($para1 == 'do_add') 
        {   
         // echo '<pre>'; print_r($this->input->post()); echo '</pre>'; die;
            $data['title']              =   $this->input->post('title');            
            $data['add_timestamp']      =   time();
            $data['update_time']        =   time();
            $data['featured']           =   '0';
            $data['type']               =   'grouped';
            $data['tax_type']           =   'percent';
            $data['status']             =   'ok';  
            $data['num_of_imgs']        =   1;
            $data['category']           =   $this->input->post('category');
            $data['sub_category']       =   $this->input->post('sub_category');
            $data['discount']           =   $this->input->post('discount');
            $data['brand']              =   $this->input->post('brand');
            $data['model']              =   $this->input->post('model');
            $data['product_code']       =   $this->input->post('product_code');
            $data['location']           =   $this->input->post('location');
            $data['item_type']          =   $this->input->post('item_type');
            $data['unit']               =   $this->input->post('unit');
            $data['discount_type']      =   $this->input->post('discount_type');
            $data['description']        =   $this->input->post('description');
            /*$data['purchase_price']     =   $this->input->post('gt');*/
            $data['sale_price']         =   $this->input->post('sale_price');
            $data['equipment']          =   $this->input->post('equipment');
            $data['sub_equipment' ]     =   $this->input->post('sub_equipment');
            $data['tag']                =   $this->input->post('tag');
            $additional_fields['name']  =   json_encode($this->input->post('ad_field_names'));
            $additional_fields['value'] =   json_encode($this->input->post('ad_field_values'));
            $data['additional_fields']  =   json_encode($additional_fields);
            $data['short_description']  =   $this->input->post('short_description');
            $data['sku']                =   $this->input->post('sku');
            $data['mpn']                =   $this->input->post('mpn');
            $data['dg']                 =   $this->input->post('dgradio');
            $tax_type                   =   $this->input->post('taxcap');
            $data['admin_approved']     =   1;
            $data['vendor_approved']    =   1;
            $tot_rate=0;
            foreach($tax_type as $type) 
            {  $tot_rate=$tot_rate+$type['taxrate']; 
            }
            if($tot_rate=='')
            { $tot_rate = 0; }
            $data['tax_info']           =   json_encode($tax_type);
            $data['tax']                =   $tot_rate;
            $data['shipping_status']    =   $this->input->post('optradio');
            $data['added_by']           =   json_encode(array('type'=>'vendor','id'=>'1'));    
            $qty                        =   $this->input->post('quantity');  
            $prdName                    =   $this->input->post('p'); 
            $data['related_products']   =   json_encode($this->input->post('relatedproducts'));
            $choice_titles              =   $this->input->post('op_title');
            $choice_types               =   $this->input->post('op_type');
            $choice_no                  =   $this->input->post('op_no');
            if(count($choice_titles ) > 0)
            {
              foreach ($choice_titles as $i => $row) 
                {
                  $choice_options  = $this->input->post('op_set'.$choice_no[$i]);
                  $options[]       = array(
                                    'no' => $choice_no[$i],
                                    'title' => $choice_titles[$i],
                                    'name' => 'choice_'.$choice_no[$i],
                                    'type' => $choice_types[$i],
                                    'option' => $choice_options
                                        );
                }
            }
            $data['options']            =   json_encode($options);
            $this->db->insert('product', $data);
            $group_id = $this->db->insert_id();
            if(count($this->input->post('prd-id') ) > -0)
            {
                foreach ($this->input->post('prd-id')  as $i => $prdId) 
                {
                  $productlist    =  array( 'grouped_id' => $group_id,'product_id' => $prdId,'product_name' => $prdName[$i],'qty' => $qty[$i]);
                  $this->db->insert('grouped_product', $productlist);
                }
            }
            $this->benchmark->mark_time();
            $this->crud_model->file_up("images", "product", $group_id, 'multi');
            $datart['product_id'] = $group_id;
            $rid    = $this->input->post('rid');
            $trate  = $this->input->post('trate');            
            if(count($rid ) > 0)
            {
                foreach ($rid  as $i => $row) 
                {
                $datart['country_id'] = $rid[$i];
                $datart['tax_amount'] = $trate[$i];
                $this->db->insert('region_tax', $datart);
                }
            }

            if($_FILES["product_brochure"]["size"] > 0)
            {
                $namebro='brochure_'.$group_id; 
                move_uploaded_file($_FILES['product_brochure']['tmp_name'], 'uploads/product_brochure/'. $namebro.'.pdf');
            }
            recache();  
        } 


        elseif ($para1 == 'list')
        {
            $this->db->order_by('grpr_id', 'desc');
            $page_data['all_groups'] = $this->db->get('grouped_product')->result_array();
            $this->db->order_by('update_time', 'desc');
            $page_data['all_products'] = $this->db->get_where('product',array('type' => 'grouped'))->result_array();
            $this->load->view('back/admin/group_list', $page_data);
        } 
        elseif ($para1 == 'add')
        {
            $this->load->view('back/admin/group_add');
        } 
        elseif ($para1 == 'gp_add') {
            $this->load->view('back/admin/gp_add');
        }
        else if ($para1 == 'gp_edit') 
        {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2 ))->result_array();
            $this->load->view('back/admin/gp_edit', $page_data);
        }
        else if ($para1 == 'dlt_img') {
            $a = explode('_', $para2);
            $this->crud_model->file_dlt('product', $a[0], '.jpg', 'multi', $a[1]);
            recache();
        }
         
 else if ($para1 == "update") 
        {
         
         $options = array();
           if ($_FILES["images"]['name'][0] == '') 
            {
              $num_of_imgs = 0;
            } 
           else 
            {
            $num_of_imgs = count($_FILES["images"]['name']);
            }
            $num = $this->crud_model->get_type_name_by_id('product', $para2, 'num_of_imgs');

            $data['num_of_imgs']        =   $num + $num_of_imgs;
            $data['update_time']        =   time();
            $data['type']               =   'grouped';
            $data['tax_type']           =   'percent';
            $data['title']              =   $this->input->post('title');
            $data['product_code']       =   $this->input->post('product_code');
            $data['item_type']          =   $this->input->post('item_type');
            $data['unit']               =   $this->input->post('unit');
            $data['sale_price']         =   $this->input->post('sale_price');
            $data['discount']           =   $this->input->post('discount');
            $data['discount_type']      =   $this->input->post('discount_type');
            $data['category']           =   $this->input->post('category');
            $data['sub_category']       =   $this->input->post('sub_category');
            $data['brand']              =   $this->input->post('brand');
            $data['equipment']          =   $this->input->post('equipment');
            $data['sub_equipment' ]     =   $this->input->post('sub_equipment');
            $data['short_description']  =   $this->input->post('short_description');
            $data['description']        =   $this->input->post('description');
            $additional_fields['name']  =   json_encode($this->input->post('ad_field_names'));
            $additional_fields['value'] =   json_encode($this->input->post('ad_field_values'));
            $data['additional_fields']  =   json_encode($additional_fields);
            $data['model']              =   $this->input->post('model');
            $data['sku']                =   $this->input->post('sku');
            $data['mpn']                =   $this->input->post('mpn');
            $data['dg']                 =   $this->input->post('dgradio');
            $data['shipping_status']    =   $this->input->post('optradio');
            $data['location']           =   $this->input->post('location');
            $data['tag']                =   $this->input->post('tag');
            $data['related_products']   =   json_encode($this->input->post('relatedproducts'));
            $choice_titles              =   $this->input->post('op_title');
            $choice_types               =   $this->input->post('op_type');
            $choice_no                  =   $this->input->post('op_no');
            /*$data['added_by']           =   json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));*/

            if(count($choice_titles ) > 0)
            {
                foreach ($choice_titles as $i => $row) 
                {
                    $choice_options = $this->input->post('op_set'.$choice_no[$i]);
                    $options[]      =   array(
                                        'no' => $choice_no[$i],
                                        'title' => $choice_titles[$i],
                                        'name' => 'choice_'.$choice_no[$i],
                                        'type' => $choice_types[$i],
                                        'option' => $choice_options
                                        );
                }
            }
            $data['options']            = json_encode($options);

            $tax_type=$this->input->post('taxcap');
            $tot_rate=0;
            foreach($tax_type as $type)
            {
             $tot_rate=$tot_rate+$type['taxrate'];
            }
            $data['tax_info']          = json_encode($tax_type);
            $data['tax']               = $tot_rate;

            $this->db->where('product_id', $para2);
            $this->db->update('product', $data);
            $this->crud_model->file_up("images", "product", $para2, 'multi');

             $qty              =   $this->input->post('quantity');  
             $prdName          =   $this->input->post('p'); 
            $this->db->where('grouped_id', $para2);
            $this->db->delete('grouped_product');
            if(count($this->input->post('prd-id') ) > 0)
            {
             foreach ($this->input->post('prd-id')  as $i => $prdId) 
             { 
                $productlist  = array( 'grouped_id' => $para2,'product_id' => $prdId,'product_name' => $prdName[$i],'qty' => $qty[$i]);
                $this->db->insert('grouped_product', $productlist);
             }
            }
            $this->db->where('product_id',$para2);
            $this->db->delete('region_tax');  
            $datart['product_id'] =$para2;
            $rid = $this->input->post('rid');
            $trate = $this->input->post('trate');            
            if(count($rid ) > 0)
                {
                 foreach ($rid  as $i => $row) 
                    {
                $datart['country_id'] = $rid[$i];
                $datart['tax_amount'] = $trate[$i];
                $this->db->insert('region_tax', $datart);
                    }
                }
                
        recache();
        } 

        else if ($para1 == 'edit') 
        { 
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/group_edit', $page_data);
        } 
        elseif ($para1 == 'delete') 
        {
            $this->crud_model->file_dlt('product', $para2, '.jpg', 'multi');
            if (file_exists('uploads/product_brochure/brochure_'.$para2.'.pdf' ) )
            {
            unlink('uploads/product_brochure/brochure_'.$para2.'.pdf');
            }
            $this->db->where('product_id', $para2);
            $this->db->delete('product');
        }

        elseif ($para1 == 'add_stock') 
        {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_stock_add', $data);
        }

        elseif ($para1 == 'destroy_stock') 
        {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_stock_destroy', $data);
        }

        else if ($para1 == 'view') 
        {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/product_view', $page_data);
        }

        elseif ($para1 == 'product_publish_set')
        {
            $product = $para2;
            $prdStatus            =   $this->crud_model->getProductStatus($para2,$para3,'admin');
            $data['status']          = $prdStatus['status'];
            $data['admin_approved']  = $prdStatus['admin_approved'];
            $data['vendor_approved'] = $prdStatus['vendor_approved'];
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        } 

        else if ($para1 == 'product_featured_set') 
        {
            $product = $para2;
            if ($para3 == 'true') {
                $data['featured'] = 'ok';
            } else {
                $data['featured'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        } 
        else if ($para1 == 'product_latest_set') 
        {
            $product = $para2;
            if ($para3 == 'true') {
                $data['latest'] = 'ok';
            } else {
                $data['latest'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        }        
        
        else
        {
            $page_data['page_name']      = "group";
            $page_data['all_groups'] = $this->db->get_where('product', array('type' => 'grouped'))->result_array();
            $this->load->view('back/index', $page_data);
        }

    }
/* gpproduct */
function gp_product($para1 = '',$para2='')
{
    if (!$this->crud_model->admin_permission('product')) 
    {
        redirect(base_url() . 'index.php/admin');
    }
    if ($para1 == 'do_add')
    {
        $data['title']             = $this->input->post('gp_name');
        $data['length']            = $this->input->post('gp_l');
        $data['width']             = $this->input->post('gp_w');
        $data['height']            = $this->input->post('gp_h');
        $data['length_class_id']   = $this->input->post('gp_lclass');
        $data['weight']            = $this->input->post('gp_weight');
        $data['weight_class_id']   = $this->input->post('gp_weclass');
        $data['short_description'] = $this->input->post('gp_descr');
        $data['admin_approved']    = 1;
        $data['view_front']        = 0;
        $this->db->insert('product', $data);
        $id = $this->db->insert_id();
        echo $id;
    }  
    else if ($para1 == 'edit')
    {

    }
    else if($para1 == 'update')
    {
        $data['title']             = $this->input->post('gp_name');
        $data['length']            = $this->input->post('gp_l');
        $data['width']             = $this->input->post('gp_w');
        $data['height']            = $this->input->post('gp_h');
        $data['length_class_id']   = $this->input->post('gp_lclass');
        $data['weight']            = $this->input->post('gp_weight');
        $data['weight_class_id']   = $this->input->post('gp_weclass');
        $data['short_description'] = $this->input->post('gp_descr');
        $data['admin_approved']    = 1;
        $data['view_front']        = 0;
        $this->db->where('product_id', $para2);
        $this->db->update('product', $data);
        echo $para2;
    }
    else if($para1 == 'delete')
    {
        $pid= $this->input->post('gp_id');
        $this->db->where('product_id', $pid);
        $this->db->delete('product');
        echo $pid;
    }
    else if($para1 == 'deletegroup')
    {
        $pid= $this->input->post('gp_id');
        $this->db->where('product_id', $pid);
        $this->db->delete('product');
        $this->db->where('product_id', $pid);
        $this->db->delete('grouped_product');
        echo $pid;
    }

}






/*customer group add, edit, view, delete */


    function customer_group($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('product')) 
        {
            redirect(base_url() . 'index.php/admin');
        }

        if ($para1 == 'do_add') 

        {
            $data['title'] = $this->input->post('title');
            $data['status'] = 'ok';
            $data['added_by'] = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));

            $uname    = $this->input->post('user');            
            if(count($uname ) > 0)
            {
                foreach ($uname  as $i => $row) 
                {
                 $customer_list[]   =  array(
                                           'cid' => $uname[$i]
                                            );
                }
            }


            $data['customer_list']= json_encode($customer_list);

            $data['discount_type']=$this->input->post('discount_type');
            $data['discount']=$this->input->post('discount_value');

            $this->db->insert('customer_group', $data);

        }


         else if ($para1 == 'edit') 
         {
            $page_data['group_data'] = $this->db->get_where('customer_group', array(
                'group_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/cust_group_edit', $page_data);
        }

         elseif ($para1 == "update") 

         {
            $data['title'] = $this->input->post('title');
            $data['status'] = 'ok';
            $data['added_by'] = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));

            $uname    = $this->input->post('user');            
            if(count($uname ) > 0)
            {
                foreach ($uname  as $i => $row) 
                {
                 $customer_list[]   =  array(
                                           'cid' => $uname[$i]
                                            );
                }
            }


            $data['customer_list']= json_encode($customer_list);

            $data['discount_type']=$this->input->post('discount_type');
            $data['discount']=$this->input->post('discount_value');


            $this->db->where('group_id', $para2);
            $this->db->update('customer_group', $data);
        } 

        elseif ($para1 == 'delete') {
            $this->db->where('group_id', $para2);
            $this->db->delete('customer_group');
        } 

        elseif ($para1 == 'list')
         {
            $this->db->order_by('group_id', 'desc');
            $page_data['all_customer_group'] = $this->db->get('customer_group')->result_array();
            $this->load->view('back/admin/cust_group_list', $page_data);
        } 

        elseif ($para1 == 'add')

         {
            $this->load->view('back/admin/cust_group_add');
        } 

        elseif ($para1 == 'publish_set')
        {
            $product = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('group_id', $product);
            $this->db->update('customer_group', $data);
        } 

        else
        {
            $page_data['page_name']   = "customer_group";
            $page_data['all_customer_group'] = $this->db->get('customer_group')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }




    /*Product equipment add, edit, view, delete */
    function equipment($para1 = '', $para2 = '')
    {
        /*if (!$this->crud_model->admin_permission('equipment')) {
            redirect(base_url() . 'index.php/admin');
        }*/
        if ($para1 == 'do_add') 
        {
            $data['equipment_name'] = $this->input->post('equipment_name');
           // $data['added_by']      = "";
            $this->db->insert('equipment', $data);
            recache();
        } 
        else if ($para1 == 'edit') 
        {
            $page_data['equipment_data'] = $this->db->get_where('equipment', array(
                'equipment_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/equipment_edit', $page_data);
        } 
        elseif ($para1 == "update") 
        {
            $data['equipment_name'] = $this->input->post('equipment_name');
            $this->db->where('equipment_id', $para2);
            $this->db->update('equipment', $data);
            recache();
        } 
        elseif ($para1 == 'delete') 
        {
            $ex=$this->crud_model->exists_in_table('sub_equipment','equipment',$para2); 
            $ex+=$this->crud_model->exists_in_table('product','equipment',$para2);
            if ($ex == 0)
            {
            $this->db->where('equipment_id', $para2);
            $this->db->delete('equipment');
            recache();
            }    
        } 
        elseif ($para1 == 'list') 
        {
            $this->db->order_by('equipment_id', 'desc');
            $page_data['all_equipments'] = $this->db->get('equipment')->result_array();
            $this->load->view('back/admin/equipment_list', $page_data);
        } 
        elseif ($para1 == 'add') {
            $this->load->view('back/admin/equipment_add');
        } 
        else {
            $page_data['page_name']      = "equipment";
            $page_data['all_equipments'] = $this->db->get('equipment')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }

  function existsequip()
    {
        $email  = $this->input->post('email');
        $user   = $this->db->get('equipment')->result_array();
        $exists = 'no';
        foreach ($user as $row) 
        {
            if ($row['equipment_name'] == $email) {
                $exists = 'yes';
            }
        }
        echo $exists;
    }

        /*Product Sub-equipment add, edit, view, delete */
    function sub_equipment($para1 = '', $para2 = '')
    {
       /* if (!$this->crud_model->admin_permission('sub_equipment')) 
        {
            redirect(base_url() . 'index.php/admin');
        }*/
        if ($para1 == 'do_add') 
        {
            $data['sub_equipment_name'] = $this->input->post('sub_equipment_name');
            $data['equipment']          = $this->input->post('equipment');
            $this->db->insert('sub_equipment', $data);
            recache();
        } 
        else if ($para1 == 'edit') 
        {
            $page_data['sub_equipment_data'] = $this->db->get_where('sub_equipment', array(
                'sub_equipment_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/sub_equipment_edit', $page_data);
        } 
        elseif ($para1 == "update") 
        {
            $data['sub_equipment_name'] = $this->input->post('sub_equipment_name');
            $data['equipment']          = $this->input->post('equipment');
            $this->db->where('sub_equipment_id', $para2);
            $this->db->update('sub_equipment', $data);
            redirect(base_url() . 'index.php/admin/sub_equipment/', 'refresh');
            recache();
        } 
        elseif ($para1 == 'delete') 
        {
            $this->db->where('sub_equipment_id', $para2);
            $this->db->delete('sub_equipment');
            recache();
        } 
        elseif ($para1 == 'list') 
        {
            $this->db->order_by('sub_equipment_id', 'desc');
            $page_data['all_sub_equipment'] = $this->db->get('sub_equipment')->result_array();
            $this->load->view('back/admin/sub_equipment_list', $page_data);
        } 
        elseif ($para1 == 'add') 
        {
            $this->load->view('back/admin/sub_equipment_add');
        } 
        else 
        {
            $page_data['page_name']        = "sub_equipment";
            $page_data['all_sub_equipment'] = $this->db->get('sub_equipment')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }


function existssubequi()
    {
        $email  = $this->input->post('email');
        $email2 = $this->input->post('email2');
        $user = $this->db->get_where('sub_equipment', array('equipment' => $this->input->post('email2')))->result_array();
        $exists = 'no';
        foreach ($user as $row) {
            if (strcasecmp($row['sub_equipment_name'], $email) == 0) {
                $exists = 'yes';
            }
        }
        echo $exists;
    }



/////////////////////////////////Import product csv ////////////////////////////////


public function productimport()
{
    if (!$this->crud_model->admin_permission('report')) 
        {
            redirect(base_url() . 'index.php/admin');
        } 
        elseif ($para1== 'list')
        {
        }   
        else
        {
          $page_data['page_name'] = "product_import";  
          $page_data['cond'] = 11;  
        $this->db->order_by('brand_id', 'asc');
        $page_data['all_brands'] = $this->db->get('brand')->result_array();

        $this->db->order_by('category_id', 'asc');
        $page_data['all_categories'] = $this->db->get('category')->result_array();

        $this->db->order_by('category', 'asc');
        $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();

        $this->db->order_by('equipment_id', 'asc');
        $page_data['all_equipments'] = $this->db->get('equipment')->result_array();

        $this->db->order_by('equipment', 'asc');
        $page_data['all_sub_equipment'] = $this->db->get('sub_equipment')->result_array();

        $this->load->view('back/index', $page_data);

        }
}

public function import_product()
{
  if(isset($_POST["import"]))
    {  

        $this->db->order_by('brand_id', 'asc');
        $page_data['all_brands'] = $this->db->get('brand')->result_array();

        $this->db->order_by('category_id', 'asc');
        $page_data['all_categories'] = $this->db->get('category')->result_array();

        $this->db->order_by('category', 'asc');
        $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();

        $this->db->order_by('equipment_id', 'asc');
        $page_data['all_equipments'] = $this->db->get('equipment')->result_array();

        $this->db->order_by('equipment', 'asc');
        $page_data['all_sub_equipment'] = $this->db->get('sub_equipment')->result_array();

        $insertcount=0;
        $ntinsert=0;
        $updatei=0;
        $filename=$_FILES["file"]["tmp_name"];
        
        if($_FILES["file"]["size"] > 0)
          {
            $file = fopen($filename, "r");
            $first=0;
             while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE) //, 10000, ","
             {
                 unset($data);
                if($first > 0 && $importdata[0] != "") 
                {
            $data['title']              = $importdata[0];
            $data['product_code']       = $importdata[1];
            $data['item_type']          = $importdata[2];
            $data['product_type']       = $importdata[3];
            $data['category']           = $importdata[4];
            $data['sub_category']       = $importdata[5];
            $data['equipment']          = $importdata[6];
            $data['sub_equipment' ]     = $importdata[7];
            $data['brand']              = $importdata[8];
              $data['sale_price']         = $importdata[9];
              $data['unit']               = $importdata[10];
              $data['model']              = $importdata[11];
              $data['location']           = $importdata[12];
              $data['current_stock']      = $importdata[13];
                $data['length']            = $importdata[14];
                $data['width']             = $importdata[15];
                $data['height']            = $importdata[16];
                $data['weight']            = $importdata[17];
                $data['description']       = $importdata[18];
                $data['sku']               = $importdata[19];
                $data['short_description'] = $importdata[20];
            $data['weight_class_id']  = '1';
            $data['length_class_id']  = '1';
            $data['featured']  = '0';
            

    $pcexist = $this->db->get_where('product', array('product_code' => $data['product_code'] ));
    $exists = 'no';
    if ($pcexist->num_rows() > 0)
    { 
        $data['update_time']      = time();
        $this->db->where('product_code', $data['product_code']);
        $this->db->update('product', $data);
        if($this->db->affected_rows() > 0)
        {
           $updatei++;
        }
        else
        {
            $ntinsert++;
            $dntint_pc[$ntinsert]=$data['product_code'];
        }

    } 
    else
    {
     $id_in=0;

        $data['add_timestamp']  = time();
        $data['update_time']    = time();
        $data['status']    = 'ok';
        $data['vendor_approved']='1';
        $data['admin_approved'] ='1';
        $data['added_by']  = json_encode(array('type'=>'vendor','id'=>'1'));

     $this->db->insert('product', $data);
     $id_in = $this->db->insert_id();
     if($id_in>0)
        {
         $insertcount++;
        }
      else
       {
          $ntinsert++;
          $dntint_pc[$ntinsert]=$data['product_code'];
       }
    }
              }
                 $first++;
             }  

            fclose($file);
            if($insertcount>0 || $updatei>0)
            {
                 $page_data['message'] = "1";
                 $page_data['insertcount'] = $insertcount;
                 $page_data['updatecount'] = $updatei;
                 $page_data['dtinsertcount'] = $ntinsert;
                 $page_data['dtinsertpc'] = $dntint_pc;
                 $page_data['cond'] = "11";
            $this->session->set_flashdata('message', 'Data are imported successfully..'.$insertcount);
            }
            else
            {
              $page_data['cond'] = "11";
              $this->session->set_flashdata('message', 'Data are not imported ..');
              $page_data['dtinsertcount'] = $ntinsert;
              $page_data['dtinsertpc'] = $dntint_pc;
            }
           // redirect('admin/productimport');

            $page_data['page_name'] = "product_import";  
            $this->load->view('back/index', $page_data);
          }

          else
          {
            $this->session->set_flashdata('message', 'Something went wrong..');
            $page_data['page_name'] = "product_import";  
            $this->load->view('back/index', $page_data);
          }
    }
}


/////////////////////////////////Import products ////////////////////////////////

/* Vendor Product view,  */
    function vendor_product($para1 = '', $para2 = '', $para3 = '')
    {
       if (!$this->crud_model->admin_permission('product')) 
        {
            redirect(base_url() . 'index.php/admin');
        }
        elseif ($para1 == 'list') 
        {
            $this->db->order_by('product_id', 'desc');
            $product = $para2;
            if ($para2 !='') 
            {
            $this->db->where('added_by', '{"type":"vendor","id":"'.$para2.'"}');
            $page_data['all_products'] = $this->db->get('product')->result_array();
            $page_data['all_vendor']   = $this->db->get('vendor')->result_array();
            
            $page_data['page_name']    = "vendor_product";
             $this->load->view('back/admin/vendor_product_list', $page_data);
          //  $this->load->view('back/index', $page_data);
            }
            elseif ($para2 =='')
            {

            $this->db->like('added_by', '{"type":"vendor"');
            $page_data['all_products'] = $this->db->get('product')->result_array();
            $page_data['all_vendor']   = $this->db->get('vendor')->result_array();
            $page_data['page_name']    = "vendor_product";
            $page_data['vendorId']      =   'list';
            $this->load->view('back/admin/vendor_product_list', $page_data);
            }
        } 
        elseif ($para1 == 'publish_set') 
        {
          $product = $para2;
                $prdStatus  =   $this->crud_model->getProductStatus($para2,$para3,'admin');
                $data['status'] = $prdStatus['status'];
                $data['admin_approved'] = $prdStatus['admin_approved'];
                $data['vendor_approved'] = $prdStatus['vendor_approved'];
                
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        } 
        else 
        {
          //  echo $para1; die;
            $page_data['page_name']      = "vendor_product";
            $this->db->order_by('product_id', 'desc');
            
            if($para1 > 0)
            {
                $this->db->where('added_by', '{"type":"vendor","id":"'.$para1.'"}');
            }
            else
            {
                $this->db->like('added_by', '{"type":"vendor"');
            }
            $this->db->where('added_by', '{"type":"vendor","id":"'.$para1.'"}');
            $page_data['all_products'] = $this->db->get('product')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }


	//Shipment Countries Management
  	function countries($para1 = '', $para2 = '',$para3='')
    {
        if (!$this->crud_model->admin_permission('sale')) 
        {
            redirect(base_url() . 'admin');
        }

        if ($para1 == 'list') 
        {
            $this->db->order_by('name', 'asc');
            $page_data['all_countries'] = $this->db->get('fed_country')->result_array();
            $this->load->view('back/admin/countries_list', $page_data);
        } 
        else if ($para1 == 'publish_set') 
        {
            $product = $para2;
            if ($para3 == 'true') {
                $data['status'] =1;
            } else {
                $data['status'] =0;
            }
            $this->db->where('country_id', $product);
            $this->db->update('fed_country', $data);
        }
        else 
        {
            $page_data['page_name']     = "countries";
            $page_data['all_countries'] = $this->db->get('fed_country')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
	
	//email tempates
	function emailtemplate($para1 = '', $para2 = '0')
	{
		if ($this->session->userdata('admin_login') != 'yes')
		{
			redirect(base_url('admin'));
		}
		if($para1=='edit')
		{
			$page_data['page_name']     = "email_template_edit";
			$page_data['id'] 			= $para2;
        	$page_data['email_data'] 	= $this->db->where('id',$para2)->get('email_template')->row();
        	$this->load->view('back/index', $page_data);
		}
		else if($para1=='process')
		{
			
			/*$data_email=array();
			$data_email['title']=trim($this->input->post('title'));
			$data_email['description']=trim($this->input->post('description'));
			if($para2>0)
			{
				$this->db->where('id',$para2)->update('email_template',$data_email);
				$this->session->set_flashdata('alert', 'updated');
			}
			else
			{
				$data_email['identifier']=trim($this->input->post('identifier'));
				$this->db->insert('email_template',$data_email);
				$this->session->set_flashdata('alert', 'added');
			}*/
			
			redirect(base_url('admin/emailtemplate'));
			//print_r($this->input->post());
			//die();
		}
		else
		{
			$page_data['page_name']     = "email_template";
        	$page_data['all_emails'] = $this->db->where('status','1')->get('email_template')->result_array();
        	$this->load->view('back/index', $page_data);
		}
		
	}



}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */