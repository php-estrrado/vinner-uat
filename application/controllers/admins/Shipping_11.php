<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Shipping extends CI_Controller
{
    function __construct(){
        parent::__construct();
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');//form validate
            $this->load->library("session");
            $this->load->model('admin/shippings');
            $this->load->model('functions');
            if ($this->session->userdata('admin_login') == 'yes') { }else{ redirect('admin'); }
    }
    function operators($para1='', $para2=0){ 
        if($para1 == 'list'){
            $data['title']          =   "Shipping Operators";
            $data['page_name']      =   "shipping/operator"; 
            $data['Operators']      =   $this->shippings->getOperators();
            $this->load->view('back/admin/shipping/operator_list', $data);
        }else if($para1 == 'details'){
            $data['title']          =   'Operator Detail'; 
            $operator               =   $this->shippings->getOperatorDetails($this->input->post('id'));
            if($operator){ $cityId  =   $operator->city_id; $stateId = $operator->state_id; $countryId = $operator->country_id; }else{ $countryId = $stateId = $cityId = ''; }
            $data['operator']       =   $operator;
            $data['countries']      =   $this->functions->getDropdownData('countries','id','name','Select Country',['status'=>1]);
            $data['states']         =   $this->functions->getDropdownData('states','id','name','Select satae',['country_id'=>$countryId,'status'=>1]);
            $data['cities']         =   $this->functions->getDropdownData('cities','id','name','Select City',['state_id'=>$stateId,'status'=>1]);
            $this->load->view('back/admin/shipping/operator_detail', $data);
        }else if($para1 == 'validate'){ 
            $this->form_validation->set_rules('operator', 'Operator', 'trim|required|min_length[2]|max_length[25]');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric|min_length[7]|max_length[12]');
        //    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[shipping_operators.email]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('website', 'Website', 'required|valid_url');
            $this->form_validation->set_rules('country_id', 'Country', 'required');
            $this->form_validation->set_rules('state_id', 'State', 'required');
            $this->form_validation->set_rules('city_id', 'City', 'required');
            if($this->input->post('have_track_link') == 1){ $this->form_validation->set_rules('track_link', 'Tracking link', 'required'); }
            if ($this->form_validation->run() == FALSE){ echo json_encode($this->form_validation->error_array()); }else{ echo '{"success":"success"}'; }
        }else if($para1 == 'save'){
            $post                       =   $this->input->post();
            $id                         =   $post['id']; unset($post['id']);
            if($post['have_track_link'] ==  0){ $post['track_link'] = ''; }
            if($id > 0){ $this->db->where('id',$id)->update('shipping_operators',$post); $insId = $id; $msg = 'Updated successfully!'; }
            else{ $this->db->insert('shipping_operators',$post); $insId = $this->db->insert_id(); $msg = 'Created successfully!'; }
            if($_FILES["logo"] && $insId){
                $fileName               =   $_FILES["logo"]["name"];
                $ext                    =   end((explode(".", $fileName)));
                if(move_uploaded_file($_FILES["logo"]['tmp_name'], 'uploads/shipping_operators/logo_' . $insId . '.'.$ext)){
                    $this->db->where('id',$insId)->update('shipping_operators',['logo'=>'logo_'. $insId . '.'.$ext]);
                }
            }
            $this->session->set_flashdata('success', $msg);
            redirect('admin/shipping/operators');
        }else{
            $data['title']              =   "Shipping Operators";
            $data['page_name']          =   "shipping/operator";
            $data['Operators']          =   $this->shippings->getOperators();
            $this->load->view('back/index', $data);
        }
    }
    
    function zones($para1='', $para2=0){ 
        if($para1 == 'list'){
            $data['title']          =   "Shipping Zones";
            $data['page_name']      =   "shipping/zones"; 
            $data['zones']      =   $this->shippings->getZones();
            $this->load->view('back/admin/shipping/zone_list', $data);
        }else if($para1 == 'details'){
            $data['title']          =   'Operator Detail'; 
            $operator               =   $this->shippings->getOperatorDetails($this->input->post('id'));
            if($operator){ $cityId  =   $operator->city_id; $stateId = $operator->state_id; $countryId = $operator->country_id; }else{ $countryId = $stateId = $cityId = ''; }
            $data['operator']       =   $operator;
            $data['countries']      =   $this->functions->getDropdownData('countries','id','name','Select Country',['status'=>1]);
            $data['states']         =   $this->functions->getDropdownData('states','id','name','Select satae',['country_id'=>$countryId,'status'=>1]);
            $data['cities']         =   $this->functions->getDropdownData('cities','id','name','Select City',['state_id'=>$stateId,'status'=>1]);
            $this->load->view('back/admin/shipping/operator_detail', $data);
        }else if($para1 == 'validate'){ 
            $this->form_validation->set_rules('operator', 'Operator', 'trim|required|min_length[2]|max_length[25]');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric|min_length[7]|max_length[12]');
        //    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[shipping_operators.email]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('country_id', 'Country', 'required');
            $this->form_validation->set_rules('state_id', 'State', 'required');
            $this->form_validation->set_rules('city_id', 'City', 'required');
            if($this->input->post('have_track_link') == 1){ $this->form_validation->set_rules('track_link', 'Tracking link', 'required'); }
            if ($this->form_validation->run() == FALSE){ echo json_encode($this->form_validation->error_array()); }else{ echo '{"success":"success"}'; }
        }else if($para1 == 'save'){
            $post                       =   $this->input->post();
            $id                         =   $post['id']; unset($post['id']);
            if($post['have_track_link'] ==  0){ $post['track_link'] = ''; }
            if($id > 0){ $this->db->where('id',$id)->update('shipping_operators',$post); $insId = $id; $msg = 'Updated successfully!'; }
            else{ $this->db->insert('shipping_operators',$post); $insId = $this->db->insert_id(); $msg = 'Created successfully!'; }
            if($_FILES["logo"] && $insId){
                $fileName               =   $_FILES["logo"]["name"];
                $ext                    =   end((explode(".", $fileName)));
                if(move_uploaded_file($_FILES["logo"]['tmp_name'], 'uploads/shipping_operators/logo_' . $insId . '.'.$ext)){
                    $this->db->where('id',$insId)->update('shipping_operators',['logo'=>'logo_'. $insId . '.'.$ext]);
                }
            }
            $this->session->set_flashdata('success', $msg);
            redirect('admin/shipping/operators');
        }else{
            $data['title']              =   "Shipping Zones";
            $data['page_name']          =   "shipping/zone";
            $data['Operators']          =   $this->shippings->getZones();
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

