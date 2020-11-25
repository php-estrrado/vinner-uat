<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Vendor extends CI_Controller
{
    
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('paypal');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->load->library('form_validation');
        $this->load->model('functions');
        //$this->crud_model->ip_data();
        $vendor_system   =  $this->db->get_where('general_settings',array('type' => 'vendor_system'))->row()->value;
        if($vendor_system !== 'ok'){
            redirect(base_url(), 'refresh');
        }
    }
    
    /* index of the vendor. Default: Dashboard; On No Login Session: Back to login page. */
    public function index()
    { 
        if ($this->session->userdata('vendor_login') == 'yes') {
            $vendorId                   =   $this->session->userdata('vendor_id');
            $vendor                     =   $this->session->userdata('vendor');
            $page_data['page_name']     =   "dashboard";
            $page_data['vendor']        =   $vendor;
            $page_data['todaySale']     =   $this->db->select_sum('grand_total')
                                            ->where("DATE_FORMAT(sale_datetime,'%Y-%m-%d') =",date('Y-m-d'))->get_where('sale',['vendor_id'=>$vendorId])->row()->grand_total;
            $page_data['currMthSale']   =   $this->db->select_sum('grand_total')
                                            ->where("DATE_FORMAT(sale_datetime,'%Y-%m-%d') >=",date('Y-m-01'))->where("DATE_FORMAT(sale_datetime,'%Y-%m-%d') <=",date('Y-m-t'))->get_where('sale',['vendor_id'=>$vendorId])->row()->grand_total;
            $page_data['tot_products']  =   $this->db->join('vendor_prices as V','P.product_id = V.prd_id')->get_where('product as P',['V.vendor_id'=>$vendorId,'P.status'=>'ok'])->num_rows();
            $this->load->view('back/index', $page_data);
        } else {
            $page_data['control'] = "vendor";
            $this->load->view('back/login',$page_data);
        }
    }


    public function sell($para1 = '')
    {
        if ($this->session->userdata('vendor_login') == 'yes') 
        {
            $page_data['page_name'] = "dashboard";
            $this->load->view('back/index', $page_data);
        } 
        else if ($para1 == 'add') 
        {
            $page_data['control'] = "vendor";
            $this->load->view('back/vendorlogup',$page_data);
        }

         else  if($para1 == 'regsu')
        {
            $page_data['control'] = "vendor";
            $page_data['vmsg']="chekemail";
            $this->load->view('back/seller',$page_data);
        }

        else  if($para1 == 'valem')
        {
            $page_data['control'] = "vendor";
            $page_data['vmsg']="valemail";
            $this->load->view('back/seller',$page_data);
        }

        else 
        {
            $page_data['control'] = "vendor";
            $this->load->view('back/seller',$page_data);
        }
    }
    
    /* Login into vendor panel */
    function login($para1 = '')
    {
        if ($para1 == 'forget_form') {
            $page_data['control'] = 'vendor';
            $this->load->view('back/forget_password',$page_data);
        } else if ($para1 == 'forget') {
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');         
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                $query = $this->db->get_where('vendor', array(
                    'email' => $this->input->post('email')
                ));
                if ($query->num_rows() > 0) {
                    $vendor_id         = $query->row()->vendor_id;
                    $password         = substr(hash('sha512', rand()), 0, 12);
                    $data['password'] = sha1($password);
                    $this->db->where('vendor_id', $vendor_id);
                    $this->db->update('vendor', $data);
                    if ($this->email_model->password_reset_email('vendor', $vendor_id, $password)) {
                        echo 'email_sent';
                    } else {
                        echo 'email_not_sent';
                    }
                } else {
                    echo 'email_nay';
                }
            }
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                $login_data = $this->db->get_where('vendor', array(
                    'email' => $this->input->post('email'),
                    'password' => sha1($this->input->post('password'))
                ));
                if ($login_data->num_rows() > 0) {
                    $loginData          =   $login_data->row();
                    $vendor             =   $this->db->select('V.*,C.currency')->join('countries as C','V.country_code = C.id')->get_where('vendor as V',['V.vendor_id'=>$loginData->vendor_id])->row();
                    if($loginData->status == 'approved'){
                        foreach ($login_data->result_array() as $row) {
                            $this->session->set_userdata('login', 'yes');
                            $this->session->set_userdata('vendor_login', 'yes');
                            $this->session->set_userdata('vendor_id', $row['vendor_id']);
                            $this->session->set_userdata('vendor_name', $row['display_name']);
                            $this->session->set_userdata('title', 'vendor');
                            $this->session->set_userdata('vendor', $vendor);
                            echo 'lets_login';
                        }
                    } else {
                        echo 'unapproved';
                    }
                } else {
                    echo 'login_failed';
                }
            }
        }
    }
    
    
    /* Loging out from vendor panel */
    function logout()
    {
        $this->session->sess_destroy();
		redirect(base_url('vendor'), 'refresh');
        //redirect(base_url('vendor/sell'), 'refresh');
    }
    
    /*Product coupon add, edit, view, delete */
    function coupon($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->vendor_permission('coupon')) {
            redirect(base_url() . 'vendor');
        }
        if ($para1 == 'do_add') {
            $data['title'] = $this->input->post('title');
            $data['code'] = $this->input->post('code');
            $data['till'] = $this->input->post('till');
            $data['status'] = 'ok';
            $data['added_by'] = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
            $data['spec'] = json_encode(array(
                                'set_type'=>'product',
                                'set'=>json_encode($this->input->post('product')),
                                'discount_type'=>$this->input->post('discount_type'),
                                'discount_value'=>$this->input->post('discount_value'),
                                'shipping_free'=>$this->input->post('shipping_free')
                            ));
            $this->db->insert('coupon', $data);
        } else if ($para1 == 'edit') {
            $page_data['coupon_data'] = $this->db->get_where('coupon', array(
                'coupon_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/coupon_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['title'] = $this->input->post('title');
            $data['code'] = $this->input->post('code');
            $data['till'] = $this->input->post('till');
            $data['spec'] = json_encode(array(
                                'set_type'=>'product',
                                'set'=>json_encode($this->input->post('product')),
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
            $this->load->view('back/vendor/coupon_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/vendor/coupon_add');
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
        if (!$this->crud_model->vendor_permission('report')) {
            redirect(base_url() . 'vendor');
        }
        $page_data['page_name'] = "report";
        $page_data['products']  = $this->db->get('product')->result_array();
        $this->load->view('back/index', $page_data);
    }
    
    
    /*Product Wish Comparison Reports*/
    function report_wish($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('report')) {
            redirect(base_url() . 'vendor');
        }
        $page_data['page_name'] = "report_wish";
        $this->load->view('back/index', $page_data);
    }
    
    /* Product add, edit, view, delete, stock increase, decrease, discount */
    function product($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->vendor_permission('product')) {
            redirect(base_url() . 'vendor');
        }
        $vendor         =   $this->session->userdata('vendor');
        if($para1 == 'do_add') 
        {
            $options = array();
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }

            $data['title']             = $this->input->post('title');
            $data['product_code']      = trim($this->input->post('product_code'));
            $data['tag']               = $this->input->post('tag');
            $data['meta_description']  = $this->input->post('meta_description');
            //$data['item_type']         = $this->input->post('item_type');
            $data['product_type']      = $this->input->post('product_type');
            $data['category']          = $this->input->post('category');
            $data['sub_category']      = $this->input->post('sub_category');
            //$data['equipment']         = $this->input->post('equipment');
            //$data['sub_equipment' ]    = $this->input->post('sub_equipment');
            //$data['brand']             = $this->input->post('brand');
            $data['unit']              =  $this->input->post('unit');
            $data['description']       =  $this->input->post('description');
            $data['short_description'] = $this->input->post('short_description');
            $additional_fields['name'] = json_encode($this->input->post('ad_field_names'));
            $additional_fields['value']= json_encode($this->input->post('ad_field_values'));
            $data['additional_fields'] = json_encode($additional_fields);
            $data['model']             = $this->input->post('model');
            //$data['sku']               = $this->input->post('sku');
            $data['mpn']               = $this->input->post('mpn');
            //$data['dg']                = $this->input->post('dgradio');
            //$data['location']          = $this->input->post('location');
            $data['sale_price']        = $this->input->post('sale_price');
            $data['purchase_price']    = $this->input->post('purchase_price');
			$data['shipping_cost']     = $this->input->post('shipping_cost');
            $data['discount']          = $this->input->post('discount');
            $data['discount_type']     = $this->input->post('discount_type');
            $data['add_timestamp']     = time();
            $data['update_time']       = time();
            $data['featured']          = '0';
            $data['admin_approved']    =   0;
            $data['vendor_approved']   =   1;
            $data['status']            =   0;
            $data['rating_user']       = '[]';
            $data['added_by']          = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
            //$data['length']            = $this->input->post('length');
            //$data['width']             = $this->input->post('width');
            //$data['height']            = $this->input->post('height');
            //$data['length_class_id']   = $this->input->post('length_class_id');
            //$data['weight']            = $this->input->post('weight');
            //$data['weight_class_id']   = $this->input->post('weight_class_id');
            //tax adding 
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
            $data['tax_info']           = json_encode($tax_type);
            $data['tax']                = $tot_rate;
            $data['tax_type']           = "percent";
            $choice_titles              = $this->input->post('op_title');
            $choice_types               = $this->input->post('op_type');
            $choice_no                  = $this->input->post('op_no');
            if(count($choice_titles ) > 0)
            {
                foreach ($choice_titles as $i => $row) 
                {
                    $choice_options = $this->input->post('op_set'.$choice_no[$i]);
                    $options[]      =   array('no' => $choice_no[$i],
                                        'title' => $choice_titles[$i],
                                        'name' => 'choice_'.$choice_no[$i],
                                        'type' => $choice_types[$i],
                                        'option' => $choice_options );
                }
            }
            $data['options']            = json_encode($options);
            $data['related_products' ]  = json_encode($this->input->post('relatedproducts'));
            $data['shipping_info']      = $this->input->post('shipping_info');
            $data['moreinfo']           = $this->input->post('more_info');
            $data['color']              = json_encode($this->input->post('color'));
            $data['num_of_imgs']        = $num_of_imgs;
            $data['current_stock']      = $this->input->post('current_stock');
            //$data['front_image']        = $this->input->post('front_image');
            $data['type']               = $this->input->post('product_group');

            if($this->crud_model->can_add_product($this->session->userdata('vendor_id')) && $this->checkprcode())
            {
                $this->db->insert('product', $data);
                $id = $this->db->insert_id();
            	//region tax adding         
            	/*$datart['product_id'] = $id;
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
            	}*/

                $this->crud_model->file_up("images", "product", $id, 'multi');
                if($_FILES["product_brochure"]["size"] > 0)
                {
                	$namebro ='brochure_'.$id; //$_FILES['product_file']['name'];
                	move_uploaded_file($_FILES['product_brochure']['tmp_name'], 'uploads/product_brochure/'. $namebro.'.pdf');
                }

                if($this->input->post('download') == 'ok')
                {
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
            } 
			else 
			{
				if(!$this->checkprcode())
                {
                    echo 'prc_added';
                }
				else
				{
                	echo 'already uploaded maximum product';
				}
            }
            recache();
        } 
        else if ($para1 == "update") 
        {
			//print_r($this->input->post());
			//die();
            $options = array();
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $num   = $this->crud_model->get_type_name_by_id('product', $para2, 'num_of_imgs');
            $download = $this->crud_model->get_type_name_by_id('product', $para2, 'download');
            
            $data['title']             = $this->input->post('title');
            $data['product_code']      = trim($this->input->post('product_code'));
            $data['tag']               = $this->input->post('tag');
            $data['meta_description']  = $this->input->post('meta_description');
            //$data['item_type']         = $this->input->post('item_type');
            $data['product_type']      = $this->input->post('product_type');
            $data['category']          = $this->input->post('category');
            $data['sub_category']      = $this->input->post('sub_category');
            //$data['equipment']         = $this->input->post('equipment');
            //$data['sub_equipment' ]    = $this->input->post('sub_equipment');
            //$data['brand']             = $this->input->post('brand');
            $data['unit']              = $this->input->post('unit');
            $data['description']       = $this->input->post('description');
            $data['short_description'] = $this->input->post('short_description');
            $additional_fields['name'] = json_encode($this->input->post('ad_field_names'));
            $additional_fields['value']= json_encode($this->input->post('ad_field_values'));
            $data['additional_fields'] = json_encode($additional_fields);
            $data['model']             = $this->input->post('model');
            //$data['sku']               = $this->input->post('sku');
            $data['mpn']               = $this->input->post('mpn');
            //$data['dg']                = $this->input->post('dgradio');
            //$data['location']          = $this->input->post('location');
            $data['sale_price']        = $this->input->post('sale_price');
            $data['purchase_price']    = $this->input->post('purchase_price');
			$data['shipping_cost']     = $this->input->post('shipping_cost');
            $data['discount']          = $this->input->post('discount');
            $data['discount_type']     = $this->input->post('discount_type');
            $data['update_time']       = time();
            //$data['admin_approved']    =   0;
            $data['vendor_approved']   =   1;
            //$data['status']            =   0;
            $data['added_by']          = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
            //$data['length']            = $this->input->post('length');
            //$data['width']             = $this->input->post('width');
            //$data['height']            = $this->input->post('height');
            //$data['length_class_id']   = $this->input->post('length_class_id');
            //$data['weight']            = $this->input->post('weight');
            //$data['weight_class_id']   = $this->input->post('weight_class_id');
            //tax adding 
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
            $data['tax_info']           = json_encode($tax_type);
            $data['tax']                = $tot_rate;
            $data['tax_type']           = "percent";
            $choice_titles              = $this->input->post('op_title');
            $choice_types               = $this->input->post('op_type');
            $choice_no                  = $this->input->post('op_no');
            if(count($choice_titles ) > 0)
            {
                foreach ($choice_titles as $i => $row) 
                {
                    $choice_options = $this->input->post('op_set'.$choice_no[$i]);
                    $options[]      =   array('no' => $choice_no[$i],
                                        'title' => $choice_titles[$i],
                                        'name' => 'choice_'.$choice_no[$i],
                                        'type' => $choice_types[$i],
                                        'option' => $choice_options );
                }
            }
            $data['options']            = json_encode($options);
            $data['related_products' ]  = json_encode($this->input->post('relatedproducts'));
            $data['shipping_info']      = $this->input->post('shipping_info');
            $data['moreinfo']           = $this->input->post('more_info');
            $data['color']              = json_encode($this->input->post('color'));
            $data['num_of_imgs']        = $num + $num_of_imgs;
            $data['type']               = $this->input->post('product_group');
            
            $this->crud_model->file_up("images", "product", $para2, 'multi');
            if($_FILES["product_brochure"]["size"] > 0)
            {
                if (file_exists('uploads/product_brochure/brochure_'.$para2.'.pdf' ) )
                {
                 unlink('uploads/product_brochure/brochure_'.$para2.'.pdf');
                }
            	$namebro='brochure_'.$para2; 
            	move_uploaded_file($_FILES['product_brochure']['tmp_name'], 'uploads/product_brochure/'. $namebro.'.pdf');
            }
            if($download == 'ok' && $_FILES['product_file']['name'] !== '')
            {
                $rand           = substr(hash('sha512', rand()), 0, 20);
                $name           = $para2.'_'.$rand.'_'.$_FILES['product_file']['name'];
                $data['download_name'] = $name;
                $folder = $this->db->get_where('general_settings', array('type' => 'file_folder'))->row()->value;
                move_uploaded_file($_FILES['product_file']['tmp_name'], 'uploads/file_products/' . $folder .'/' . $name);
            }

            $this->db->where('product_id', $para2);
            $this->db->update('product', $data);

            //region tax updating
            $this->db->where('product_id',$para2);
            $this->db->delete('region_tax');  
            
			/*$datart['product_id'] =$para2;
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
                }*/
            //package adding
            /*if($this->input->post('product_group') =='grouped')
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
            }*/
            recache();
        } 

        elseif ($para1 == 'gp_add') 
        {
            $this->load->view('back/vendor/gp_add');
        }
        else if ($para1 == 'gp_edit') 
        {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2 ))->result_array();
            $this->load->view('back/vendor/gp_edit', $page_data);
        } 

        else if ($para1 == 'edit') {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/product_edit', $page_data);
        } else if ($para1 == 'view') {
            $page_data['vendor']    =   $vendor;
            $page_data['product_data'] = $this->db->select('P.*,V.price,V.vendor_id')->join('vendor_prices as V','P.product_id = V.prd_id')->get_where('product as P',['V.vendor_id'=>$vendor->vendor_id,'P.product_id'=>$para2])->result_array();
            $this->load->view('back/vendor/product_view', $page_data);
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('product', $para2, '.jpg', 'multi');
            if (file_exists('uploads/product_brochure/brochure_'.$para2.'.pdf' ) )
            {
            unlink('uploads/product_brochure/brochure_'.$para2.'.pdf');
            }
            $this->db->where('product_id', $para2);
            $this->db->delete('product');
            recache();
        } elseif ($para1 == 'list') 
        { 
            $this->db->where('view_front','1');
            $sort = 'update_time';
            $order = 'DESC';
            $this->db->order_by($sort,$order);  
            $page_data['vendor']        =   $vendor;
            $page_data['all_product']   =   $this->db->select('P.*,V.price,V.vendor_id')->join('vendor_prices as V','P.product_id = V.prd_id')->get_where('product as P',['V.vendor_id'=>$vendor->vendor_id])->result_array();
            $this->load->view('back/vendor/product_list', $page_data);
        } 
        elseif ($para1 == 'list_data') { 
            $limit      = $this->input->get('limit');
            $search     = $this->input->get('search');
            $order      = $this->input->get('order');
            $offset     = $this->input->get('offset');
            $sort       = $this->input->get('sort');
            if($search){
                $this->db->like('title', $search, 'both');
            }
            $total      = $this->db->get('product')->num_rows();
            $this->db->limit($limit);
            $this->db->order_by($sort,$order);
            if($search){
                $this->db->like('title', $search, 'both');
            }
            $products   = $this->db->get('product', $limit, $offset)->result_array();
            $data       = array(); 
            foreach ($products as $row) {
             //   if($this->crud_model->is_added_by('product',$row['product_id'],$this->session->userdata('vendor_id'))){
                    $res    = array(
                                 'image' => '',
                                 'title' => '',
                                 'current_stock' => '',
                                 'publish' => '',
                                 'options' => ''
                              );

                    $res['image']  = '<img class="img-sm" style="height:auto !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;" src="'.$this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one').'"  />';
                    $res['title']  = $row['title'];
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
                                <a class=\"btn btn-dark btn-xs btn-labeled fa fa-minus-square\" data-toggle=\"tooltip\" 
                                    onclick=\"ajax_modal('destroy_stock','".translate('reduce_product_quantity')."','".translate('quantity_reduced!')."','destroy_stock','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                        ".translate('destroy')."
                                </a>
                                
                                <a class=\"btn btn-success btn-xs btn-labeled fa fa-wrench\" data-toggle=\"tooltip\" 
                                    onclick=\"ajax_set_full('edit','".translate('edit_product')."','".translate('successfully_edited!')."','product_edit','".$row['product_id']."');proceed('to_list');\" data-original-title=\"Edit\" data-container=\"body\">
                                        ".translate('edit')."
                                </a>
                                
                                <a onclick=\"delete_confirm('".$row['product_id']."','".translate('really_want_to_delete_this?')."')\" 
                                    class=\"btn btn-danger btn-xs btn-labeled fa fa-trash\" data-toggle=\"tooltip\" data-original-title=\"Delete\" data-container=\"body\">
                                        ".translate('delete')."
                                </a>";
                    $data[] = $res;
            //    }
            }
            $result = array(
                             'total' => $total,
                             'rows' => $data
                           );

            echo json_encode($result);

        } else if ($para1 == 'dlt_img') {
            $a = explode('_', $para2);
            $this->crud_model->file_dlt('product', $a[0], '.jpg', 'multi', $a[1]);
            recache();
        }  
        else if ($para1 == 'dlt_bros') {
        if (file_exists('uploads/product_brochure/brochure_'.$para2.'.pdf' ) )
        {
        unlink('uploads/product_brochure/brochure_'.$para2.'.pdf');
        }
        recache();
        }
        elseif ($para1 == 'sub_by_cat') {
            echo $this->crud_model->select_html('sub_category', 'sub_category', 'sub_category_name', 'add', 'demo-chosen-select required', '', 'category', $para2, 'get_sub_res', 'vendor');
        } 
        elseif ($para1 == 'sub_by_equi') {
            echo $this->crud_model->select_html('sub_equipment', 'sub_equipment', 'sub_equipment_name', 'add', 'demo-chosen-select ', '', 'equipment', $para2, '');
        }

        elseif ($para1 == 'brand_by_cat') {
            /*echo $this->crud_model->select_html('brand', 'brand', 'name', 'add', 'demo-chosen-select', '', 'category', $para2, '', 'vendor');*/
            echo $this->crud_model->select_html('brand', 'brand', 'name', 'add', 'demo-chosen-select', '', '', '', '');
        } elseif ($para1 == 'product_by_sub') {
            echo $this->crud_model->select_html('product', 'product', 'title', 'add', 'demo-chosen-select required', '', 'sub_category', $para2, 'get_pro_res', 'vendor');
        } elseif ($para1 == 'pur_by_pro') {
            echo $this->crud_model->get_type_name_by_id('product', $para2, 'purchase_price');
        } else if ($para1 == 'sale_by_pro') {
            echo $this->crud_model->get_type_name_by_id('product', $para2, 'sale_price');
        }
        elseif ($para1 == 'name_by_pro') {
           echo $this->crud_model->get_type_name_by_id('product', $para2, 'title');
        } elseif ($para1 == 'add') {
            if($this->crud_model->can_add_product($this->session->userdata('vendor_id'))){
                $this->load->view('back/vendor/product_add');
            } else {
                $this->load->view('back/vendor/product_limit');
            }
        } elseif ($para1 == 'add_stock') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_stock_add', $data);
        } elseif ($para1 == 'destroy_stock') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_stock_destroy', $data);
        } elseif ($para1 == 'stock_report') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_stock_report', $data);
        } elseif ($para1 == 'sale_report') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_sale_report', $data);
        } elseif ($para1 == 'add_discount') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_add_discount', $data);
        } elseif ($para1 == 'product_publish_set') {
            $product = $para2;
          //  if ($para3 == 'true') {
                $this->crud_model->set_product_publishability($this->session->userdata('vendor_id'),$product);
           //     $data['status'] = 'ok';
          //  } else {
          //      $data['status'] = '0';
         //   }
            $prdStatus  =   $this->crud_model->getProductStatus($para2,$para3,'vendor');
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
        } else if ($para1 == 'changePrice'){
            $vendorId               =   $this->session->userdata('vendor_id');
            if($para2 == 0){
                $data['product']    =   false;
                $data['products']   =   $this->db->join('vendor_prices as V','P.product_id = V.prd_id')->get_where('product as P',['V.vendor_id'=>$vendorId])->result();
            }else{ $data['product'] =   $this->db->join('vendor_prices as V','P.product_id = V.prd_id')->get_where('product as P',['V.vendor_id'=>$vendorId,'P.product_id'=>$para2])->row(); }
          //  print_r($data['product']); die;
            $this->load->view('back/vendor/product/price_req_form', $data);
        }else if ($para1 == 'validateRequest'){
            $post               =   $this->input->post();
            $this->form_validation->set_rules('product', 'Product', 'required');
            $this->form_validation->set_rules('req_price', 'Request Price', 'required|numeric|greater_than[0]');
            if ($this->form_validation->run() == FALSE){ echo json_encode($this->form_validation->error_array()); }else{ echo '{"success":"success"}'; }
        }else if ($para1 == 'saveReqPrice'){
            $post               =   $this->input->post(); 
            $url                =   $post['returnUrl']; unset($post['returnUrl']); unset($post['product']);
            $post['created']    =   date('Y-m-d H:i:s');
            $insId              =   $this->functions->saveData('product_price_request',$post,0);
            if(insId){ $this->session->set_flashdata('success', 'Request Submitted Successfully!'); redirect($url); }
            else{ $this->session->set_flashdata('error', 'Some error occured. Please try after some time.'); redirect($url); }
        }else {
            $page_data['page_name']   = "product";
            $page_data['all_product'] = $this->db->get('product')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
     
    /* Product Stock add, edit, view, delete, stock increase, decrease, discount */
    function stock($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('stock')) {
            redirect(base_url() . 'vendor');
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
            $data['added_by']     = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
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
            $data['added_by']     = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
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
            $page_data['all_stock'] = $this->db->get_where('stock', array('added_by' => '{"type":"vendor","id":"'.$this->session->userdata('vendor_id').'"}'))->result_array();
         //   $page_data['all_stock'] = $this->db->get('stock')->result_array();
            $this->load->view('back/vendor/stock_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/vendor/stock_add');
        } elseif ($para1 == 'destroy') {
            $this->load->view('back/vendor/stock_destroy');
        } else {
            $page_data['page_name'] = "stock";
            $page_data['all_stock'] = $this->db->get('stock')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Managing sales by users */
    function sales($para1 = '', $para2 = '',$para3="")
    {
        if (!$this->crud_model->vendor_permission('sale')) {
            redirect(base_url() . 'vendor');
        }
        if ($para1 == 'delete') 
		{
            $carted = $this->db->get_where('stock', array(
                'sale_id' => $para2
            ))->result_array();
            foreach ($carted as $row2) {
                $this->stock('delete', $row2['stock_id']);
            }
            $this->db->where('sale_id', $para2);
            $this->db->delete('sale');
        } 
		elseif ($para1 == 'list') 
		{
            // $all = $this->db->get_where('sale',array('payment_type' => 'go'))->result_array();
            // foreach ($all as $row) {
            //     if((time()-$row['sale_datetime']) > 600){
            //         $this->db->where('sale_id', $row['sale_id']);
            //         $this->db->delete('sale');
            //     }
            // }
            
            $this->db->where('vendor_id',$this->session->userdata('vendor_id'));
            $this->db->order_by('sale_id', 'desc');
            $page_data['all_sales'] = $this->db->get('sale')->result_array();
            $this->load->view('back/vendor/sales_list', $page_data);
        } 
		elseif ($para1 == 'view') 
		{
            $data['viewed'] = 'ok';
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/sales_view', $page_data);
        } 
		elseif ($para1 == 'send_invoice') 
		{
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $text              = $this->load->view('back/includes_top', $page_data);
            $text .= $this->load->view('back/vendor/sales_view', $page_data);
            $text .= $this->load->view('back/includes_bottom', $page_data);
        }elseif ($para1 == 'delivery_payment') 
		{
            $data['viewed'] = 'ok';
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale_id']           = $para2;
            $page_data['payment_type']      = $this->db->get_where('sale', array('sale_id' => $para2))->row()->payment_type;
            $page_data['payment_details']   = $this->db->get_where('sale', array('sale_id' => $para2))->row()->payment_details;
            $page_data['delivery_status']   = $this->db->get_where('sale', array('sale_id' => $para2))->row()->delivery_status;
            $page_data['status_type']       =   $para3;
            $payment_status = json_decode($this->db->get_where('sale', array('sale_id' => $para2 ))->row()->payment_status,true);
            foreach ($payment_status as $row){
                if($row['vendor'] == $this->session->userdata('vendor_id')){
                    $page_data['payment_status'] = $row['status'];
                }
            }
            $this->load->view('back/vendor/sales_delivery_payment', $page_data);
        }else if ($para1 == 'delivery_payment_set'){
            $delivery_status    = $this->input->post('delivery_status');
            $payment_status     = json_decode($this->db->get_where('sale', array('sale_id' => $para2))->row()->payment_status,true);
            $new_payment_status = array();
            foreach ($payment_status as $row) {
                $new_payment_status[] = array('vendor'=>$this->session->userdata('vendor_id'),'status'=>$this->input->post('payment_status'));
            }
            
            $data['payment_status']  = json_encode($new_payment_status);
            $data['delivery_status'] = $delivery_status;
            $data['payment_details'] = $this->input->post('payment_details');
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
        }
		elseif ($para1 == 'add') 
		{
            $this->load->view('back/vendor/sales_add');
        } 
		elseif ($para1 == 'total') 
		{
            $sales = $this->db->get('sale')->result_array();
            $i = 0;
            foreach($sales as $row){
                if($this->crud_model->is_sale_of_vendor($row['sale_id'],$this->session->userdata('vendor_id'))){
                    $i++;
                }
            }
            echo $i;
        } 
		elseif($para1 == 'sale_receipt') 
		{
			$page_data['sale_id'] = $para2;
			$vendor        			= $this->session->userdata('vendor_id');
            $page_data['receipt']	=
				$this->db->where(array('sale_id'=>$para2,'vendor_id'=>$vendor))->get('sale_receipt')->row();
			$page_data['sale_data']	= $this->db->where(array('sale_id'=>$para2))->get('sale')->row();
            $this->load->view('back/vendor/sale_receipts', $page_data);
		}
		elseif ($para1 == 'sale_shipping') 
		{
			$page_data['sale_id'] = $para2;
			$vendor     = $this->session->userdata('vendor_id');
			$page_data['shipping_data']	=
				$this->db->where(array('sale_id'=>$para2,'vendor_id'=>$vendor))->get('sale_shipping_receipt')->row();
			$page_data['sale_data']	= $this->db->where(array('sale_id'=>$para2))->get('sale')->row();
			$this->load->view('back/vendor/sale_shipping', $page_data);
		}
		elseif ($para1 == 'add_shipping') 
		{
			$vendor      = $this->session->userdata('vendor_id');
			$sdata = array('sale_id' => $para2, 'vendor_id' => $this->session->userdata('vendor_id'), 'receipt_details' => '');
			$al_shipping = $this->db->get_where('sale_shipping_receipt', array('sale_id'=>$para2,'vendor_id'=>$vendor));
			if($al_shipping->num_rows()==1)
			{
				$shi_id=$al_shipping->row()->sale_shipping_id;
				$sdata['last_updated']=date("Y-m-d H:i:s");
				$this->db->where('sale_shipping_id',$shi_id)->update('sale_shipping_receipt', $sdata);
			}
			else
			{
				$sdata['added']	=	date("Y-m-d H:i:s");
				$sdata['last_updated']	=	date("Y-m-d H:i:s");
				$this->db->insert('sale_shipping_receipt', $sdata);
				$shi_id = $this->db->insert_id();
			}
			$upfile      =   $_FILES['img']['name'];
            $tempName    =   $_FILES['img']['tmp_name'];
            $ext         =   pathinfo($upfile,PATHINFO_EXTENSION);
			$source	     =   'shipping_receipt_'.$shi_id.'.'.$ext;
			move_uploaded_file($_FILES['img']['tmp_name'],'uploads/shipping_receipt/'.$source);
			$this->db->where('sale_shipping_id',$shi_id)->update('sale_shipping_receipt',array('receipt'=>$source));
			echo $result;
		}
		else 
		{
            $page_data['page_name']      = "sales";
            $page_data['all_categories'] = $this->db->get('sale')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Checking Login Stat */
    function is_logged()
    {
        if ($this->session->userdata('vendor_login') == 'yes') {
            echo 'yah!good';
        } else {
            echo 'nope!bad';
        }
    }
    
    /* Manage Site Settings */
    function site_settings($para1 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'warehouse');
        }
        $this->load->model('functions');
        $page_data['page_name'] = "site_settings";
        $page_data['tab_name']  = $para1;
        $vendor                 =   $this->db->get_where('vendor',['vendor_id'=>$this->session->userdata('vendor_id')])->row();
        $page_data['vendor']    =   $vendor;
        $page_data['countries'] =   $this->functions->getDropdownData('countries','id','name','Select Country',['status'=>1]);
        $page_data['states']    =   $this->functions->getDropdownData('states','id','name','Select State',['country_id'=>(int)$vendor->country_code,'status'=>1]);
        $page_data['cities']    =   $this->functions->getDropdownData('cities','id','name','Select City',['state_id'=>(int)$vendor->zone_id,'status'=>1]);
        $this->load->view('back/index', $page_data);
    }
    

    /* Manage Business Settings */
    function package($para1 = "", $para2 = "")
    {
        if ($para1 == 'upgrade') 
        {
            $method         = $this->input->post('method');
            $type           = $this->input->post('membership');
            $vendor         = $this->session->userdata('vendor_id');
            if($type !== '0')
			{
                $amount         = $this->db->get_where('membership',array('membership_id'=>$type))->row()->price;
                $amount_in_usd  = $amount/$this->db->get_where('business_settings',array('type'=>'exchange'))->row()->value;
                if ($method == 'paypal') 
				{

                    $paypal_email           = $this->db->get_where('business_settings',array('type'=>'paypal_email'))->row()->value;
                    $data['vendor']         = $vendor;
                    $data['amount']         = $amount;
                    $data['status']         = 'due';
                    $data['method']         = 'paypal';
                    $data['membership']     = $type; 
                    $data['timestamp']      = time();

                    $this->db->insert('membership_payment', $data);
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
                    $this->paypal->add_field('notify_url', base_url() . 'vendor/paypal_ipn');
                    $this->paypal->add_field('cancel_return', base_url() . 'vendor/paypal_cancel');
                    $this->paypal->add_field('return', base_url() . 'vendor/paypal_success');
                    
                    $this->paypal->submit_paypal_post();
                    // submit the fields to paypal

                }
				else if ($method == 'stripe') {
                    if($this->input->post('stripeToken')) {
                        
                        $stripe_api_key = $this->db->get_where('business_settings' , array('type' => 'stripe_secret'))->row()->value;
                        require_once(APPPATH . 'libraries/stripe-php/init.php');
                        \Stripe\Stripe::setApiKey($stripe_api_key); //system payment settings
                        $vendor_email = $this->db->get_where('vendor' , array('vendor_id' => $vendor))->row()->email;
                        
                        $vendora = \Stripe\Customer::create(array(
                            'email' => $vendor_email, // customer email id
                            'card'  => $_POST['stripeToken']
                        ));

                        $charge = \Stripe\Charge::create(array(
                            'customer'  => $vendora->id,
                            'amount'    => ceil($amount_in_usd*100),
                            'currency'  => 'USD'
                        ));

                        if($charge->paid == true){
                            $vendora = (array) $vendora;
                            $charge = (array) $charge;
                            
                            $data['vendor']         = $vendor;
                            $data['amount']         = $amount;
                            $data['status']         = 'paid';
                            $data['method']         = 'stripe';
                            $data['timestamp']      = time();
                            $data['membership']     = $type;
                            $data['details']        = "Customer Info: \n".json_encode($vendora,true)."\n \n Charge Info: \n".json_encode($charge,true);
                            
                            $this->db->insert('membership_payment', $data);
                            $this->crud_model->upgrade_membership($vendor,$type);
                            redirect(base_url() . 'vendor/package/', 'refresh');
                        } else {
                            $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                            redirect(base_url() . 'vendor/package/', 'refresh');
                        }
                        
                    } else{
                        $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                        redirect(base_url() . 'vendor/package/', 'refresh');
                    }
                } else if ($method == 'cash') 
                {
                    $data['vendor']         = $vendor;
                    $data['amount']         = $amount;
                    $data['status']         = 'due';
                    $data['method']         = 'cash';
                    $data['timestamp']      = time();
                    $data['membership']     = $type;
                    $this->db->insert('membership_payment', $data);
                    redirect(base_url() . 'vendor/package/', 'refresh');
                } else {
                    echo 'putu';
                }
            } else {
                redirect(base_url() . 'vendor/package/', 'refresh');
            }
        } 
        else 
        {
            $page_data['page_name'] = "package";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* FUNCTION: Verify paypal payment by IPN*/
    function paypal_ipn()
    {
        if ($this->paypal->validate_ipn() == true) {
            
            $data['status']         = 'paid';
            $data['details']        = json_encode($_POST);
            $invoice_id             = $_POST['custom'];
            $this->db->where('membership_payment_id', $invoice_id);
            $this->db->update('membership_payment', $data);
            $type = $this->db->get_where('membership_payment',array('membership_payment_id'=>$invoice_id))->row()->membership;
            $vendor = $this->db->get_where('membership_payment',array('membership_payment_id'=>$invoice_id))->row()->vendor;
            $this->crud_model->upgrade_membership($vendor,$type);
        }
    }
    

    /* FUNCTION: Loads after cancelling paypal*/
    function paypal_cancel()
    {
        $invoice_id = $this->session->userdata('invoice_id');
        $this->db->where('membership_payment_id', $invoice_id);
        $this->db->delete('membership_payment');
        $this->session->set_userdata('invoice_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel');
        redirect(base_url() . 'admin/package/', 'refresh');
    }
    
    /* FUNCTION: Loads after successful paypal payment*/
    function paypal_success()
    {
        $this->session->set_userdata('invoice_id', '');
        redirect(base_url() . 'vendor/package/', 'refresh');
    }
    

    /* Manage Business Settings */
    function business_settings($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->vendor_permission('business_settings')) {
            redirect(base_url() . 'vendor');
        }
        if ($para1 == "cash_set") 
        {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'cash_set' => $val
            ));
            recache();
        }
        else if ($para1 == "paypal_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'paypal_set' => $val
            ));
            recache();
        }
        else if ($para1 == "stripe_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'stripe_set' => $val
            ));
            recache();
        }
        else if ($para1 == "membership_price") {
            echo $this->db->get_where('membership',array('membership_id'=>$para2))->row()->price;
        }
        else if ($para1 == "membership_info") 
        {
            $return = '<div class="table-responsive"><table class="table table-striped">';
            if($para2 !== '0'){
                $results = $this->db->get_where('membership',array('membership_id'=>$para2))->result_array();
                foreach ($results as $row) {
                    $return .= '<tr>';
                    $return .= '<td>'.translate('title').'</td>';
                    $return .= '<td>'.$row['title'].'</td>';
                    $return .= '</tr>';

                    $return .= '<tr>';
                    $return .= '<td>'.translate('price').'</td>';
                    $return .= '<td> USD '.$row['price'].'</td>';
                    $return .= '</tr>';

                    $return .= '<tr>';
                    $return .= '<td>'.translate('timespan').'</td>';
                    $return .= '<td>'.$row['timespan'].'</td>';
                    $return .= '</tr>';

                    $return .= '<tr>';
                    $return .= '<td>'.translate('maximum_product').'</td>';
                    $return .= '<td>'.$row['product_limit'].'</td>';
                    $return .= '</tr>';
                }
            } else if($para2 == '0'){
                $return .= '<tr>';
                $return .= '<td>'.translate('title').'</td>';
                $return .= '<td>'.translate('default').'</td>';
                $return .= '</tr>';

                $return .= '<tr>';
                $return .= '<td>'.translate('price').'</td>';
                $return .= '<td>'.translate('free').'</td>';
                $return .= '</tr>';

                $return .= '<tr>';
                $return .= '<td>'.translate('timespan').'</td>';
                $return .= '<td>'.translate('lifetime').'</td>';
                $return .= '</tr>';

                $return .= '<tr>';
                $return .= '<td>'.translate('maximum_product').'</td>';
                $return .= '<td>'.$this->db->get_where('general_settings',array('type'=>'default_member_product_limit'))->row()->value.'</td>';
                $return .= '</tr>';
            }
            $return .= '</table></div>';
            echo $return;
        }
        else if ($para1 == 'set') 
        {
            $publishable    = $this->input->post('stripe_publishable');
            $secret         = $this->input->post('stripe_secret');
            $stripe         = json_encode(array('publishable'=>$publishable,'secret'=>$secret));
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'paypal_email' => $this->input->post('paypal_email')
            ));
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'stripe_details' => $stripe
            ));
            recache();
        } 
        else if ($para1 == 'set_bank') 
        {
            $bank_data=array();
            $bank_data['bank_name']     = trim($this->input->post('bank_name'));
            $bank_data['swift_code ']   = trim($this->input->post('swift_code'));
            $bank_data['account_number']= trim($this->input->post('account_number'));
            $bank_data['name_account '] = trim($this->input->post('name_account'));
            $bank_data['bank_branch']   = trim($this->input->post('bank_branch'));
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', $bank_data);
            recache();
        } 
        else 
        {
            $page_data['page_name'] = "business_settings";
            $this->load->view('back/index', $page_data);
        }
    }
    

    /* Manage vendor Settings */
    function manage_vendor($para1 = "")
    {
        if ($this->session->userdata('vendor_login') != 'yes') {
            redirect(base_url() . 'vendor');
        }
        if ($para1 == 'update_password') 
		{
            $user_data['password'] = $this->input->post('password');
            $account_data          = $this->db->get_where('vendor', array(
                'vendor_id' => $this->session->userdata('vendor_id')
            ))->result_array();
            foreach ($account_data as $row) {
                if (sha1($user_data['password']) == $row['password']) {
                    if ($this->input->post('password1') == $this->input->post('password2')) {
                        $data['password'] = sha1($this->input->post('password1'));
                        $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
                        $this->db->update('vendor', $data);
                        echo 'updated';
                    }
                } else {
                    echo 'pass_prb';
                }
            }
        } 
		else if ($para1 == 'update_profile') 
        {
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'address1' => $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'company' => $this->input->post('company'),
                'display_name' => $this->input->post('display_name'),
                'details' => $this->input->post('details'),
                //'phone' => $this->input->post('phone'),
				'mobile' => $this->input->post('mobile'),
                'lat_lang' => $this->input->post('lat_lang'),
				'country_code' => $this->input->post('country_code'),
				'ship_method' => $this->input->post('ship_method'),
				'ship_region' => $this->input->post('ship_region'),
				'drs_id' => $this->input->post('drs_id')

            ));
        } else {
            $page_data['page_name'] = "manage_vendor";
            $this->load->view('back/index', $page_data);
        }
    }

    /* Manage General Settings */
    function general_settings($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) 
        {
            redirect(base_url() . 'vendor');
        }

    }
    
    function address($para=''){
//        if (!$this->crud_model->vendor_permission('site_settings')) {
//            redirect(base_url() . 'vendor');
//        }
        if ($para1 == "set") { echo 'lll'; 
            $post       =   $this->input->post(); 
            print_r($post);
        }
    }
    /* Manage Social Links */
    function social_links($para1 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'vendor');
        }
        if ($para1 == "set") {
            $post       =   $this->input->post(); 
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'))->update('vendor',$post);
//            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
//            $this->db->update('vendor', array(
//                'facebook' => $this->input->post('facebook')
//            ));
//
//            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
//            $this->db->update('vendor', array(
//                'google_plus' => $this->input->post('google-plus')
//            ));
//
//            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
//            $this->db->update('vendor', array(
//                'twitter' => $this->input->post('twitter')
//            ));
//
//            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
//            $this->db->update('vendor', array(
//                'skype' => $this->input->post('skype')
//            ));
//
//            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
//            $this->db->update('vendor', array(
//                'pinterest' => $this->input->post('pinterest')
//            ));
//
//            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
//            $this->db->update('vendor', array(
//                'youtube' => $this->input->post('youtube')
//            ));
            recache();
            redirect(base_url() . 'vendor/site_settings/social_links/', 'refresh');
        
        }
    }

    /* Manage SEO relateds */
    function seo_settings($para1 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'vendor');
        }
        if ($para1 == "set") {
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'description' => $this->input->post('description')
            ));
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'keywords' => $this->input->post('keywords')
            ));
            recache();
        }
    }

    /* Manage Favicons */
    function vendor_images($para1 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'vendor');
        }
        move_uploaded_file($_FILES["logo"]['tmp_name'], 'uploads/vendor/logo_' . $this->session->userdata('vendor_id') . '.png');
        move_uploaded_file($_FILES["banner"]['tmp_name'], 'uploads/vendor/banner_' . $this->session->userdata('vendor_id') . '.jpg');
        recache();
    }



    //customer group add, edit, view, delete
    function customer_group($para1 = '', $para2 = '', $para3 = '')
    {
      
        if (!$this->crud_model->vendor_permission('product'))
         {
            redirect(base_url() . 'vendor');
        }

        if ($para1 == 'do_add') 

        {
            $data['title'] = $this->input->post('title');
            $data['status'] = 'ok';
            $data['added_by'] = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));

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
            $this->load->view('back/vendor/cust_group_edit', $page_data);
        }

         elseif ($para1 == "update") 

         {
            $data['title'] = $this->input->post('title');
            $data['status'] = 'ok';
            $data['added_by'] = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
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
            $this->load->view('back/vendor/cust_group_list', $page_data);
        } 

        elseif ($para1 == 'add')

         {
            $this->load->view('back/vendor/cust_group_add');
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
 
    /*Product Group add, edit, view, delete */
    function product_group($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->vendor_permission('product')) 
        {
            redirect(base_url() .'vendor');
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
            //$data['status']             =   'ok';  
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
        /*  $data['purchase_price']     =   $this->input->post('gt'); */
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
            $data['admin_approved']     =   0;
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
            $data['added_by']           =   json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
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
                      
            if(count($this->input->post('prd-id') ) > 0)
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
            $page_data['all_products'] = $this->db->get_where('product',array('type' => 'grouped'))->result_array();
            $this->load->view('back/vendor/group_list', $page_data);
        } 
        elseif ($para1 == 'add')
        {
            $this->load->view('back/vendor/group_add');
        } 

        elseif ($para1 == 'gp_add') 
        {
            $this->load->view('back/vendor/gp_add');
        }
         
        else if ($para1 == 'gp_edit') 
        {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2 ))->result_array();
            $page_data['grp_qunt']= $this->db->get_where('grouped_product', array(
                'product_id' => $para2,'grouped_id'=>$para3 ))->row()->qty;
            $this->load->view('back/vendor/gp_edit', $page_data);
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
            $data['added_by']           =   json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));

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
            $this->load->view('back/vendor/group_edit', $page_data);
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

        elseif ($para1 == 'add_stock') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_stock_add', $data);
        }

        elseif ($para1 == 'destroy_stock') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_stock_destroy', $data);
        }

        else if ($para1 == 'view') {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/product_view', $page_data);
        }

        else if ($para1 == 'product_publish_set')
        {
            $product = $para2;
            $this->crud_model->set_product_publishability($this->session->userdata('vendor_id'),$product);
            $prdStatus  =   $this->crud_model->getProductStatus($para2,$para3,'vendor');
            $data['status'] = $prdStatus['status'];
            $data['admin_approved'] = $prdStatus['admin_approved'];
            $data['vendor_approved'] = $prdStatus['vendor_approved'];
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        }else
        {
            $page_data['page_name']      = "group";
            $page_data['all_groups'] = $this->db->get_where('product', array('type' => 'grouped'))->result_array();
            $this->load->view('back/index', $page_data);
        }

    }


    /* gpproduct */
    function gp_product($para1 = '',$para2='')
    {
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

    /*Product most viewed Reports*/
    function most_viewed($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('report')) 
        {
            redirect(base_url() . 'vendor');
        }
        if ($para1 == 'list') {
            //echo "in";
            $this->db->order_by('number_of_view','desc');
                        $this->db->where('status','ok');
            $page_data['most_viewed'] = $this->db->get('product')->result_array();
            $this->load->view('back/vendor/most_viewed', $page_data);
        } elseif ($para1 == 'view') {
            $data['viewed'] = 'ok';
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/sales_view', $page_data);
        }else {
            $page_data['page_name']      = "most_viewed";
            $page_data['all_categories'] = $this->db->get('sale')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }

    /* most cuponusage Reports*/
    function report_coupon($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('report')) 
        {
            redirect(base_url() . 'vendor');
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
               $ab[]= array('title' =>$cid['title'],'code'=>$cid['code'],'status' =>$total,'coupon_id' =>$cid['coupon_id']);
          }
              $price = array();
              foreach ($ab as $key => $row)
          {
              $price[$key] = $row['status'];
          }
            array_multisort($price, SORT_DESC, $ab );
            $page_data['report_coupon'] = $ab;
            $this->load->view('back/vendor/report_coupon', $page_data);
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
        if (!$this->crud_model->vendor_permission('report')) 
        {
            redirect(base_url() . 'vendor');
        }
         if ($para1 == 'list') 
        {
           $this->db->select('product_id');
           $productid=$this->db->get('product')->result_array();
                foreach ($productid as $pid) 
                {
                    $total=0;
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
             $this->load->view('back/vendor/report_products',$page_data);
        }
        else
        {
        $page_data['page_name'] = "report_products";
        $this->load->view('back/index', $page_data);
        }
    }  

    /*Product Low Stock  Reports*/
    function report_stock($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('report')) 
        {
            redirect(base_url() . 'vendor');
        }
        if ($para1 == 'list') 
        {
            $this->db->order_by('current_stock','asc');
            $this->db->where('status','ok');
            $page_data['report_stock'] = $this->db->get('product')->result_array();
            $this->load->view('back/vendor/report_stock', $page_data);
        }
        else
        {
        $page_data['page_name'] = "report_stock";
        $this->load->view('back/index', $page_data);
        }
    }  


    /*sale total sale Reports*/
    function report_sale($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('report')) 
        {
            redirect(base_url() . 'vendor');
        }
        else if ($para1== 'list') 
        {

              $dm    =  $this->input->post('dorms');
              $date  =  $this->input->post('dats');
              $delsta=  $this->input->post('dests');            
               if ($dm == 1)
                    {                      
                     $new_date = date('m-d-y', strtotime($this->input->post('dats')));
                     redirect(base_url() . 'vendor/total_sales/list/day/'.$new_date, 'refresh');
                    }
        else if($dm == 2)
        {              
            $month =  $this->input->post('mnts'); 
            $day=01;   
            $mdate=$month."-".$day;
            $new_date = date('m-y', strtotime($mdate));                
                // $this->total_sales('list','mnt', $new_date);
            redirect(base_url() . 'vendor/total_sales/list/mnt/'.$new_date, 'refresh');
        }   
        }        
        else
        {
            $page_data['page_name'] = "report_sale";        
            $this->load->view('back/index', $page_data);
        }
    }



    /*Product total_sales invoice Reports*/
    function total_sales($para1 = '', $para2 = '',$para3 = '')
    {        
     if (!$this->crud_model->vendor_permission('report')) 
      {
        redirect(base_url() . 'vendor');
      }
     if($para1='list')
      {      
        if($para2 == 'day')
         {
            $v_in=0;
            $tsale=0;
              if( isset($saleid))
               { }
              else
                {
                 $saleid=$this->db->get('sale')->result_array();
                }
                    foreach ( $saleid as $sid) 
                      {  
                        $grand_total=0;  
                        $p_details=json_decode($sid['product_details'],true);
                        foreach ($p_details as $rowt) 
                        {
                           $p_id=$rowt['id'];
                           $p_qnt=0;
                           $p_price=0;
                           $p_tot=0;
                        if($this->crud_model->is_added_by('product',$rowt['id'],$this->session->userdata('vendor_id')))
                          {
                            $v_in=1;
                            $p_qnt=$rowt['qty'];
                            $p_price=$rowt['price'];
                            $p_tot=$p_qnt*$p_price;
                           }
                           $grand_total += $p_tot;
                        }   
                        $stime=$sid['sale_datetime'];                         
                        $tod=(date('m-d-y', $stime));
                          if($para3==$tod && $v_in==1 )
                            {
        $saleid2[]=array('sale_id'=>$sid['sale_id'],'sale_code'=>$sid['sale_code'],'buyer'=>$sid['buyer'],'grand_total'=>$grand_total,'payment_status'=>$sid['payment_status'],'delivery_status'=>$sid['delivery_status'],'sale_datetime'=>$sid['sale_datetime']);    
                        $tsale=$tsale+$grand_total;
                            } 
                      }
                    $saleid=$saleid2;  
                    $page_data['invohead']   = $para3;                  
                    $page_data['gdtotal']    = $tsale;
                    $page_data['page_name']  = "total_sales";
                    $page_data['total_sales']= $saleid;
                  $this->load->view('back/index',$page_data); 
          }
        else if($para2 == 'mnt')
          {
            $v_in=0;
            $tsale=0;
            if(isset($saleid))
                {}
            else
            {
              $saleid=$this->db->get('sale')->result_array();
            }
            foreach ( $saleid as $sid) 
            {    
                $grand_total=0;  
                $p_details=json_decode($sid['product_details'],true);
                 foreach ($p_details as $rowt) 
                    {
                     $p_qnt=0;
                     $p_price=0;
                     $p_tot=0;
                     $p_id=$rowt['id'];
                     if($this->crud_model->is_added_by('product',$rowt['id'],$this->session->userdata('vendor_id')))
                     {
                     $v_in=1;
                     $p_qnt=$rowt['qty'];
                     $p_price=$rowt['price'];
                     $p_tot=$p_qnt*$p_price;
                     }
                     $grand_total += $p_tot;
                    }
                $stime=$sid['sale_datetime'];
                $tod= (date('m-y', $stime));
                if($para3 == $tod && $v_in==1)
                 {
                  $saleid2[]=array('sale_id'=>$sid['sale_id'],'sale_code'=>$sid['sale_code'],'buyer'=>$sid['buyer'],'grand_total'=>$grand_total,'payment_status'=>$sid['payment_status'],'delivery_status'=>$sid['delivery_status'],'sale_datetime'=>$sid['sale_datetime']); 
                  $tsale=$tsale+$grand_total;
                 }                   
            }
                $saleid=$saleid2;  
                $da=$para3."-O1";
                $mnth=substr($para3,0,2);
                $yer=substr($para3,3);                    
                $monthName = date("F ", mktime(0, 0, 0, $mnth));
                $page_data['invohead']= $monthName."20".$yer;
                $page_data['gdtotal']   = $tsale;
                $page_data['page_name'] = "total_sales";
                $page_data['total_sales']=$saleid;
                $this->load->view('back/index',$page_data); 
         }
     }   
        else
         {
           $page_data['page_name'] = "total_sales";
           $this->load->view('back/index', $page_data);
         }   
    }


    /*Review List and approval*/
    function reviews($para1 = '', $para2 = '', $para3 = '')
    {
        if ($para1 == 'list') {
            $this->db->order_by('review_id', 'desc');
            $page_data['all_reviews'] = $this->db->get('reviews')->result_array();
            $this->load->view('back/vendor/review_list', $page_data);
        } 
        else if ($para1 == 'view') {
            $page_data['review_id'] = $para2;
             $user_name = $this->crud_model->get_type_name_by_id('user',$row['user_id'],'username');
            $page_data['review_data'] = $this->db->get_where('reviews', array(
                'review_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/review_view', $page_data);
        } 
        else if ($para1 == 'approval') {
            $page_data['review_id'] = $para2;
            $page_data['status'] = $this->db->get_where('reviews', array(
                                            'review_id' => $para2
                                        ))->row()->status;
            $this->load->view('back/vendor/review_approval', $page_data);
        } 
        else if ($para1 == 'approval_set') {
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
        }   
        else {
            $page_data['page_name'] = "reviews";
            $page_data['all_reviews'] = $this->db->get('reviews')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    

    /*manage quote messages*/
    function quote_message($para1 = "", $para2 = "")
    {
        if ($para1 == 'list') 
        {
            $this->db->order_by('quote_message_id', 'desc');
            $page_data['quote_messages'] = $this->db->get('quote_message')->result_array();
            $this->load->view('back/vendor/quote_message_list', $page_data);
        } 
        elseif ($para1 == 'view') {
            //$data['view']="1";
            //$this->db->where('quote_message_id', $para2);
            //$this->db->update('quote_message',$data);
            $page_data['message_data'] = $this->db->get_where('quote_message', array(
                'quote_message_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/quote_message_view', $page_data);
        }  
        else {
            $page_data['page_name']        = "quote_message";
            $page_data['contact_messages'] = $this->db->get('quote_message')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    /*manage quote messages*/



    public function productimport()
    {
        if (!$this->crud_model->vendor_permission('product')) 
            {
                redirect(base_url() . 'vendor');
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

            $this->db->order_by('brand_id', 'desc');
            $page_data['all_brands'] = $this->db->get('brand')->result_array();

            $this->db->order_by('category_id', 'desc');
            $page_data['all_categories'] = $this->db->get('category')->result_array();

            $this->db->order_by('sub_category_id', 'desc');
            $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();

            $this->db->order_by('equipment_id', 'desc');
            $page_data['all_equipments'] = $this->db->get('equipment')->result_array();

            $this->db->order_by('sub_equipment_id', 'desc');
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
                      if($first > 0 && $importdata[0] != "") {
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
            $data['vendor_approved']  = '1';
            $data['update_time']      = time();
            $this->db->where('added_by', '{"type":"vendor","id":"'.$this->session->userdata('vendor_id').'"}');
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
            $data['vendor_approved']= '1';
            $data['added_by']  = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));

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
                     $page_data['dtinsertcount'] = $ntinsert;
                     $page_data['updatecount'] = $updatei;
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



    /*manage chat messages*/
    function chat($para1 = "", $para2 = "")
    {
        if ($this->session->userdata('vendor_login') != 'yes') 
        {
            redirect('vendor/sell');
        }
        $this->load->model('chats');
        $page_data['page_name']  = "chat_home";
        $page_data['chatId']     = $para1;
        $vendor                  = $this->session->userdata('vendor_id');
        $page_data['vendor']     = $vendor;     
        $page_data['chatLists']  = $this->chats->getvendorChatList($vendor,$para1);
        $this->load->view('back/index', $page_data);
    }

    public function addChatMessage() 
    {
        $this->load->model('chats');
        if ($this->session->userdata('vendor_login')=="yes") 
         {
            $data = array('chat_id' => $this->input->get('chatId'), 'msg_from' => $this->input->get('from'), 'message' => $this->input->get('message'));
            $data = $this->chats->savevendorChatMessage();
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
        if ($this->session->userdata('vendor_login')=="yes")
        {
			$vendor_id=$this->session->userdata('vendor_id');
            $data = $this->chats->getChatMessages($chatId, $lastId);
            if($data) 
            {
				$this->db->where(array('vendor_id'=>$vendor_id,'chat_id'=>$chatId))->update('chat',array('vendor_unread'=>'0'));
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
	public function ChatImage($para1 = "", $para2 = "") 
    {
		if($para1=='add')
		{
			
			$page_data['chat_id']=$para2;
			$this->load->view('back/vendor/chat_image',$page_data);
		}
		else if($para1=='do_add')
		{
			 //$this->load->model('chats');
			$chat = $this->db->get_where('chat', array('chat_id' => $para2, 'status' => 1))->row();
			$msgTo = $chat->user_id;
			$readData = array('user_unread' => ($chat->user_unread + 1),'last_message'=>date("Y-m-d H:i:s"));
           
			$cdata = array('chat_id' => $para2, 'msg_from' => $this->session->userdata('vendor_id'), 'msg_to' => $msgTo, 'message' => '','msg_type'=>'2','created'=>date("Y-m-d H:i:s"));
            $this->db->insert('chat_messages', $cdata);
			$result = $this->db->insert_id();
		    $this->db->where('chat_id',$para2)->update('chat',$readData);
            
			$upfile      =   $_FILES['img']['name'];
            $tempName    =   $_FILES['img']['tmp_name'];
            $ext         =   pathinfo($upfile,PATHINFO_EXTENSION);
			$source	     =   'chat_file_'.$result.'.'.$ext;
			move_uploaded_file($_FILES['img']['tmp_name'],'uploads/chat_message/'.$source);
			$this->db->where('chat_messages_id',$result)->update('chat_messages',array('message'=>$source));
			echo $result;
		}
	}
	
	public function ChatCount()
	{
		$chatcnt=0;
		if ($this->session->userdata('vendor_login')== 'yes') 
        {
            $vendor = $this->session->userdata('vendor_id');
			$chats=$this->db->where(array('vendor_id'=>$vendor,'vendor_unread >'=>0))->get('chat');
			$chatcnt=$chats->num_rows();
        }
		echo $chatcnt;
	}
	
	public function checkprcode()
    {
        $product_code = trim($this->input->post('product_code'));
        $added_by     = json_encode(array('type' => 'vendor', 'id' => $this->session->userdata('vendor_id')));    
        if($product_code && $added_by) 
        {
            if ($this->db->get_where('product', array('product_code' => $product_code, 'added_by' => $added_by))->num_rows() > 0)
            {
                return false;
            } 
            else 
            {
                return true;
            }
        }
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */