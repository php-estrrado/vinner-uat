<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Crud_model extends CI_Model

{

    function __construct()

    {

        parent::__construct();

    }

    

    function clear_cache()

    {

        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

        $this->output->set_header('Pragma: no-cache');

    }

    

    /////////GET NAME BY TABLE NAME AND ID/////////////

    function get_type_name_by_id($type, $type_id = '', $field = 'name')

    {

        if ($type_id != '') {

            $l = $this->db->get_where($type, array(

                $type . '_id' => $type_id

            ));

            $n = $l->num_rows();

            if ($n > 0) {

                return $l->row()->$field;

            }

        }

    }
    
    //Get name by table id

    function get_type_name_by_ids($type, $type_id = '', $field = 'name')

    {

        if ($type_id != '') {

            $l = $this->db->get_where($type, array('id' => $type_id

            ));

            $n = $l->num_rows();

            if ($n > 0) {

                return $l->row()->$field;

            }

        }

    }
    

    /////////Filter One/////////////

    function filter_one($table, $type, $value)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($type, $value);
        return $this->db->get()->result_array();
    }

    

    // FILE_UPLOAD

    function img_product($type, $id, $ext = '.jpg', $width = '400', $height = '400')
    {
        $this->load->library('image_lib');
        ini_set("memory_limit", "-1");
        $config1['image_library']  = 'gd2';
        $config1['maintain_ratio'] = TRUE;
        $config1['width']          = $width;
        $config1['height']         = $height;
        $config1['source_image']   = 'uploads/' . $type . '_image/' . $type . '_' . $id . $ext;
        $this->image_lib->initialize($config1);
        $this->image_lib->resize();
        $this->image_lib->clear();
    }
    
    function img_thumb($type, $id, $ext = '.jpg', $width = '120', $height = '120')
    {
        $this->load->library('image_lib');
        ini_set("memory_limit", "-1");
        $config1['image_library']  = 'gd2';
        $config1['create_thumb']   = TRUE;
        $config1['maintain_ratio'] = TRUE;
        $config1['width']          = $width;
        $config1['height']         = $height;
        $config1['source_image']   = 'uploads/' . $type . '_image/' . $type . '_' . $id . $ext;
        $this->image_lib->initialize($config1);
        $this->image_lib->resize();
        $this->image_lib->clear();
    }

    

    // FILE_UPLOAD

    function file_up($name, $type, $id, $multi = '', $no_thumb = '', $ext = '.jpg'){
        if($type == 'certificates'){
            $ext = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION); $fileName = time();
            if(move_uploaded_file($_FILES[$name]['tmp_name'], 'uploads/' . $type . '/'. $fileName.'.'. $ext)){ return $fileName.'.'.$ext; }else{ return false; }
        }else{
            if ($multi == '') {
    
                move_uploaded_file($_FILES[$name]['tmp_name'], 'uploads/' . $type . '_image/' . $type . '_' . $id . $ext);
                if($type == 'product'){ $this->crud_model->img_product($type, $id, $ext); } 
                if ($no_thumb == '') {
                    if($type == 'product'){ $this->crud_model->img_thumb($type, $id, $ext,120,120); }
                    else{ $this->crud_model->img_thumb($type, $id, $ext,400,400); }
    
                }
    
            } elseif ($multi == 'multi') {
    
                $ib = 1;
    
                foreach ($_FILES[$name]['name'] as $i => $row) {
    
                    $ib = $this->file_exist_ret($type, $id, $ib);
    
                    move_uploaded_file($_FILES[$name]['tmp_name'][$i], 'uploads/' . $type . '_image/' . $type . '_' . $id . '_' . $ib . $ext);
                    if($type == 'product'){ $this->crud_model->img_product($type, $id . '_' . $ib, $ext); }
                    if ($no_thumb == '') {
                        if($type == 'product'){ $this->crud_model->img_thumb($type, $id . '_' . $ib, $ext,120,120); }
                       else{  $this->crud_model->img_thumb($type, $id . '_' . $ib, $ext); }
    
                    }
    
                }
                return $ib;
            }
        }
    }

    

    // FILE_UPLOAD : EXT :: FILE EXISTS

    function file_exist_ret($type, $id, $ib, $ext = '.jpg')

    {

        if (file_exists('uploads/' . $type . '_image/' . $type . '_' . $id . '_' . $ib . $ext)) {

            $ib = $ib + 1;

            $ib = $this->file_exist_ret($type, $id, $ib);

            return $ib;

        } else {

            return $ib;

        }

    }

    

    

    // FILE_VIEW

    function file_view($type, $id, $width = '100', $height = '100', $thumb = 'no', $src = 'no', $multi = '', $multi_num = '', $ext = '.jpg')

    {

        if ($multi == '') {

            if (file_exists('uploads/' . $type . '_image/' . $type . '_' . $id . $ext)) {

                if ($thumb == 'no') {

                    $srcl = base_url() . 'uploads/' . $type . '_image/' . $type . '_' . $id . $ext;

                } elseif ($thumb == 'thumb') {

                    $srcl = base_url() . 'uploads/' . $type . '_image/' . $type . '_' . $id . '_thumb' . $ext;

                }

                

                if ($src == 'no') {

                    return '<img src="' . $srcl . '" height="' . $height . '" width="' . $width . '" />';

                } elseif ($src == 'src') {

                    return $srcl;

                }

            }

            

        } else if ($multi == 'multi') {

            $num    = $this->crud_model->get_type_name_by_id($type, $id, 'num_of_imgs');

            //$num = 2;

            $i      = 0;

            $p      = 0;

            $q      = 0;

            $return = array();
            
            if (file_exists('uploads/' . $type . '_image/' . $type . '_' . $id . $ext) && $type=='product') 
                {

                    if ($thumb == 'no') {

                        $srcl = base_url() . 'uploads/' . $type . '_image/' . $type . '_' . $id.$ext.'?'.time();

                    } elseif ($thumb == 'thumb') {

                        $srcl = base_url() . 'uploads/' . $type . '_image/' . $type . '_' . $id .'_thumb' . $ext.'?'.time();

                    }
                    if ($src == 'no') {

                        $return[] = '<img src="' . $srcl . '" height="' . $height . '" width="' . $width . '" />';

                    } elseif ($src == 'src') {

                        $return[] = $srcl;

                    }
                }

            while ($p < $num) {

                $i++;

                if (file_exists('uploads/' . $type . '_image/' . $type . '_' . $id . '_' . $i . $ext)) {

                    if ($thumb == 'no') {

                        $srcl = base_url() . 'uploads/' . $type . '_image/' . $type . '_' . $id . '_' . $i . $ext.'?'.time();

                    } elseif ($thumb == 'thumb') {

                        $srcl = base_url() . 'uploads/' . $type . '_image/' . $type . '_' . $id . '_' . $i . '_thumb' . $ext.'?'.time();

                    }

                    

                    if ($src == 'no') {

                        $return[] = '<img src="' . $srcl . '" height="' . $height . '" width="' . $width . '" />';

                    } elseif ($src == 'src') {

                        $return[] = $srcl;

                    }

                    $p++;

                } else {

                    $q++;

                    if ($q == 10) {

                        break;

                    }

                }

                

            }

            if (!empty($return)) {

                if ($multi_num == 'one') {

                    return $return[0];

                } else if ($multi_num == 'all') {

                    return $return;

                } else {

                    $n = $multi_num - 1;

                    unset($return[$n]);

                    return $return;

                }

            } else {

                return false;

            }

        }

    }

    

    

    // FILE_VIEW

    function file_dlt($type, $id, $ext = '.jpg', $multi = '', $m_sin = '')

    {

        if ($multi == '') {

            if (file_exists('uploads/' . $type . '_image/' . $type . '_' . $id . $ext)) {

                unlink("uploads/" . $type . "_image/" . $type . "_" . $id . $ext);

            }

            if (file_exists("uploads/" . $type . "_image/" . $type . "_" . $id . "_thumb" . $ext)) {

                unlink("uploads/" . $type . "_image/" . $type . "_" . $id . "_thumb" . $ext);

            }

            

        } else if ($multi == 'multi') {

            $num = $this->crud_model->get_type_name_by_id($type, $id, 'num_of_imgs');

            if ($m_sin == '') {

                $i = 0;

                $p = 0;

                while ($p < $num) {

                    $i++;

                    if (file_exists('uploads/' . $type . '_image/' . $type . '_' . $id . '_' . $i . $ext)) {

                        unlink("uploads/" . $type . "_image/" . $type . "_" . $id . '_' . $i . $ext);

                        $p++;

                        $data['num_of_imgs'] = $num - 1;

                        $this->db->where($type . '_id', $id);

                        $this->db->update($type, $data);

                    }

                    

                    if (file_exists("uploads/" . $type . "_image/" . $type . "_" . $id . '_' . $i . "_thumb" . $ext)) {

                        unlink("uploads/" . $type . "_image/" . $type . "_" . $id . '_' . $i . "_thumb" . $ext);

                    }

                    if ($i > 50) {

                        break;

                    }

                }

            } else {

                if (file_exists('uploads/' . $type . '_image/' . $type . '_' . $id . '_' . $m_sin . $ext)) {

                    unlink("uploads/" . $type . "_image/" . $type . "_" . $id . '_' . $m_sin . $ext);

                }

                if (file_exists("uploads/" . $type . "_image/" . $type . "_" . $id . '_' . $m_sin . "_thumb" . $ext)) {

                    unlink("uploads/" . $type . "_image/" . $type . "_" . $id . '_' . $m_sin . "_thumb" . $ext);

                }

                $data['num_of_imgs'] = $num - 1;

                $this->db->where($type . '_id', $id);

                $this->db->update($type, $data);

            }

        }

    }

    

    //DELETE MULTIPLE ITEMS	

    function multi_delete($type, $ids_array)

    {

        foreach ($ids_array as $row) {

            $this->file_dlt($type, $row);

            $this->db->where($type . '_id', $row);

            $this->db->delete($type);

        }

    }

    

    //DELETE SINGLE ITEM	

    function single_delete($type, $id)

    {

        $this->file_dlt($type, $id);

        $this->db->where($type . '_id', $id);

        $this->db->delete($type);

    }

    

    //GET PRODUCT LINK

    function product_link($product_id,$quick='')

    {

		if($quick=='quick'){

			return base_url() . 'home/quick_view/' . $product_id;

		} else {

			$name = url_title($this->crud_model->get_type_name_by_id('product', $product_id, 'title'));
        	return base_url() . 'home/product_view/' . $product_id . '/' . $name;

            //return base_url() . $name . '/p/' .$product_id ;
		}

    }

    function brand_link($b_id)
     {
        $name = url_title($this->crud_model->get_type_name_by_id('brand', $b_id, 'name'));
        return base_url() .'brand/'.$name . '/' . $b_id;
     }
    

    //GET PRODUCT LINK

    function blog_link($blog_id)

    {

		$name = url_title($this->crud_model->get_type_name_by_id('blog', $blog_id, 'title'));

		return base_url() . 'home/blog_view/' . $blog_id . '/' . $name;

    }



    //GET PRODUCT LINK

    function vendor_link($vendor_id)

    {

        $name = url_title($this->crud_model->get_type_name_by_id('vendor', $vendor_id, 'display_name'));

        return base_url() . 'home/vendor/' . $vendor_id . '/' . $name;

    }



    /////////GET CHOICE TITLE////////

    function choice_title_by_name($product,$name)

    {

        $return = '';

        $options = json_encode($this->get_type_name_by_id('product',$product_id,'options'),true);

        foreach ($options as $row) {

            if($row['name'] == $name){

                $return = $row['title'];

            }

        }

        return $return;

    }



    /////////SELECT HTML/////////////

    function select_html($from, $name, $field, $type, $class, $e_match = '', $condition = '', $c_match = '', $onchange = '', $emptyLabel='',$emptyVal='')

    {

        $return = '';

        $other  = '';

        $multi  = 'no';

        if($emptyLabel == ''){ $phrase = 'Choose ' . $name; }else{ $phrase = $emptyLabel; }

        if ($class == 'demo-cs-multiselect') {

            $other = 'multiple';

            $name  = $name . '[]';

            if ($type == 'edit') {

                $e_match = json_decode($e_match);

                if ($e_match == NULL) {

                    $e_match = array();

                }

                $multi = 'yes';

            }

        }

        $return = '<select name="' . $name . '" onChange="' . $onchange . '(this.value)" class="' . $class . '" ' . $other . '  data-placeholder="' . $phrase . '" tabindex="2" >';

        if (!is_array($from)) {

            if ($condition == '') {

                $all = $this->db->order_by($field, 'asc')->get($from)->result_array();

            } else if ($condition !== '') {

                $all = $this->db->order_by($field, 'asc')->get_where($from, array(

                    $condition => $c_match

                ))->result_array();

            }

            

            $return .= '<option value="'.$emptyVal.'">Choose one</option>';

            

            foreach ($all as $row):

                if ($type == 'add') {

                    $return .= '<option value="' . $row[$from . '_id'] . '">' . $row[$field] . '</option>';

                } else if ($type == 'edit') {

                    $return .= '<option value="' . $row[$from . '_id'] . '" ';

                    if ($multi == 'no') {

                        if ($row[$from . '_id'] == $e_match) {

                            $return .= 'selected=."selected"';

                        }

                    } else if ($multi == 'yes') {

                        if (in_array($row[$from . '_id'], $e_match)) {

                            $return .= 'selected=."selected"';

                        }

                    }

                    $return .= '>' . $row[$field] . '</option>';

                }

            endforeach;

        } else {

            $all = $from;

            $return .= '<option value="">Choose one</option>';

            foreach ($all as $row):

                if ($type == 'add') {

                    $return .= '<option value="' . $row . '">';

                    if ($condition == '') {

                        $return .= ucfirst(str_replace('_', ' ', $row));

                    } else {

                        $return .= $this->crud_model->get_type_name_by_id($condition, $row, $c_match);

                    }

                    $return .= '</option>';

                } else if ($type == 'edit') {

                    $return .= '<option value="' . $row . '" ';

                    if ($row == $e_match) {

                        $return .= 'selected=."selected"';

                    }

                    $return .= '>';

                    

                    if ($condition == '') {

                        $return .= ucfirst(str_replace('_', ' ', $row));

                    } else {

                        $return .= $this->crud_model->get_type_name_by_id($condition, $row, $c_match);

                    }

                    

                    $return .= '</option>';

                }

            endforeach;

        }

        $return .= '</select>';

        return $return;

    }

    //Select html data
   function select_html_data($from, $name, $field, $type, $class, $e_match = '', $condition = '', $c_match = '', $onchange = '', $vendor='',$emptyVal='')

    { 

        $return = '';

        $other  = '';

        $multi  = 'no';

        $phrase = 'Choose a ' . $name;

        if ($class == 'demo-cs-multiselect') {

            $other = 'multiple';

            $name  = $name . '[]';

            if ($type == 'edit') {

                $e_match = json_decode($e_match); 

                if ($e_match == NULL) {

                    $e_match = array();

                }

                $multi = 'yes';

            }

        }

        $return = '<select name="' . $name . '" onChange="' . $onchange . '(this.value)" class="' . $class . '" ' . $other . '  data-placeholder="' . $phrase . '" tabindex="2" >';

        if (!is_array($from)) {

            if ($condition == '') {

                $all = $this->db->order_by($field, 'asc')->where('status',1)->get($from)->result_array();

            } else if ($condition !== '' && $vendor == 'vendor' && $from == 'product') {

                $all = $this->db->get_where($from, array(

                    $condition => $c_match, 'added_by' => '{"type":"vendor","id":"'.$this->session->userdata('vendor_id').'"}'

                ))->result_array();

            } else if ($condition !== '') {

                $all = $this->db->order_by($field, 'asc')->get_where($from, array(

                    $condition => $c_match

                ))->result_array();

            }

            

            $return .= '<option value="'.$emptyVal.'">Choose one</option>';

            

            foreach ($all as $row):

                if ($type == 'add') {

                    $return .= '<option value="' . $row['id'] . '">' . $row[$field] . '</option>';

                } else if ($type == 'edit') {

                    $return .= '<option value="' . $row['id'] . '" ';

                    if ($multi == 'no') {
                                               
                        if ($row['id'] == $e_match) {

                            $return .= 'selected=."selected"';

                        }

                    } else if ($multi == 'yes') {

                        if (in_array($row['id'], $e_match)) {

                            $return .= 'selected=."selected"';

                        }

                    }

                    $return .= '>' . $row[$field] . '</option>'; 

                }

            endforeach;

        } else {

            $all = $from;

            $return .= '<option value="">Choose one</option>';

            foreach ($all as $row):

                if ($type == 'add') {

                    $return .= '<option value="' . $row . '">';

                    if ($condition == '') {

                        $return .= ucfirst(str_replace('_', ' ', $row));

                    } else {

                        $return .= $this->crud_model->get_type_name_by_id($condition, $row, $c_match);

                    }

                    $return .= '</option>';

                } else if ($type == 'edit') {

                    $return .= '<option value="' . $row . '" ';

                    if ($row == $e_match) {

                        $return .= 'selected=."selected"';

                    }

                    $return .= '>';

                    

                    if ($condition == '') {

                        $return .= ucfirst(str_replace('_', ' ', $row));

                    } else {

                        $return .= $this->crud_model->get_type_name_by_id($condition, $row, $c_match);

                    }

                    

                    $return .= '</option>';

                }

            endforeach;

        }

        $return .= '</select>';

        return $return;

    }

    //CHECK IF PRODUCT EXISTS IN TABLE

    function exists_in_table($table, $field, $val)

    {

        $ret = '';

        $res = $this->db->get($table)->result_array();

        foreach ($res as $row) {

            if ($row[$field] == $val) {

                $ret = $row[$table . '_id'];

            }

        }

        if ($ret == '') {

            return false;

        } else {

            return $ret;

        }

        

    }

    

    //FORM FIELDS

    function form_fields($array)

    {

        $return = '';

        foreach ($array as $row) {

            $return .= '<div class="form-group">';

            $return .= '    <label class="col-sm-4 control-label" for="demo-hor-inputpass">' . $row . '</label>';

            $return .= '    <div class="col-sm-6">';

            $return .= '       <input type="text" name="ad_field_values[]" id="demo-hor-inputpass" class="form-control">';

            $return .= '       <input type="hidden" name="ad_field_names[]" value="' . $row . '" >';

            $return .= '    </div>';

            $return .= '</div>';

        }

        return $return;

    }

    

    // PAGINATION

    function pagination($type, $per, $link, $f_o, $f_c, $other, $current, $seg = '3', $ord = 'desc')

    {

        $t   = explode('#', $other);

        $t_o = $t[0];

        $t_c = $t[1];

        $c   = explode('#', $current);

        $c_o = $c[0];

        $c_c = $c[1];

        

        $this->load->library('pagination');

        $this->db->order_by($type . '_id', $ord);

        $config['total_rows']  = $this->db->count_all_results($type);

        $config['base_url']    = base_url() . $link;

        $config['per_page']    = $per;

        $config['uri_segment'] = $seg;

        

        $config['first_link']      = '&laquo;';

        $config['first_tag_open']  = $t_o;

        $config['first_tag_close'] = $t_c;

        

        $config['last_link']      = '&raquo;';

        $config['last_tag_open']  = $t_o;

        $config['last_tag_close'] = $t_c;

        

        $config['prev_link']      = '&lsaquo;';

        $config['prev_tag_open']  = $t_o;

        $config['prev_tag_close'] = $t_c;

        

        $config['next_link']      = '&rsaquo;';

        $config['next_tag_open']  = $t_o;

        $config['next_tag_close'] = $t_c;

        

        $config['full_tag_open']  = $f_o;

        $config['full_tag_close'] = $f_c;

        

        $config['cur_tag_open']  = $c_o;

        $config['cur_tag_close'] = $c_c;

        

        $config['num_tag_open']  = $t_o;

        $config['num_tag_close'] = $t_c;

        $this->pagination->initialize($config);

        

        $this->db->order_by($type . '_id', $ord);

        return $this->db->get($type, $config['per_page'], $this->uri->segment($seg))->result_array();

    }

    

    //IF PRODUCT ADDED TO CART

    function is_added_to_cart($product_id, $set = '', $op = '')

    {

        $carted = $this->cart->contents();

        //var_dump($carted);

        if (count($carted) > 0) {

            foreach ($carted as $items) {

                if ($items['id'] == $product_id) {

                    

                    if ($set == '') {

                        return true;

                    } else {

                        if($set == 'option'){

                            $option = json_decode($items[$set],true);

                            return $option[$op]['value'];

                        } else {

                            return $items[$set];

                        }

                    }

                }

            }

        } else {

            return false;

        }

    }

    

    //TOTALING OF CART ITEMS BY TYPE
    function cart_total_it($type)
    {
        $carted = $this->cart->contents();
        $ret    = 0;
        if(count($carted) > 0) 
		{
            foreach ($carted as $items) 
			{
                $ret += $items[$type] * $items['qty'];
            }
            return $ret;
        } 
		else 
		{
            return false;
        }
    }





    //SALE WISE TOTAL BY TYPE

    function db_sale_total_it($sale_id, $type)

    {

        $carted = json_decode($this->db->get_where('sale', array(

            'sale_id' => $sale_id

        ))->row()->product_details, true);

        $ret    = 0;

        if (count($carted) > 0) {

            foreach ($carted as $items) {

                $ret += $items[$type] * $items['qty'];

            }

            return $ret;

        } else {

            return false;

        }

    }

    

    

    //GETTING ADDITIONAL FIELDS FOR PRODUCT ADD

    function get_additional_fields($product_id)

    {

        $additional_fields = $this->crud_model->get_type_name_by_id('product', $product_id, 'additional_fields');

        $ab                = json_decode($additional_fields);

        foreach ($ab as $i => $row) {

            

            if ($i == 'name') {

                $name = json_decode($row);

            }

            

            if ($i == 'value') {

                $value = json_decode($row);

            }

            

        }

        if ($name == false || $value == false) {

            return array();

        }

        foreach ($name as $n => $row) {

            $final[] = array(

                'name' => $row,

                'value' => $value[$n]

            );

        }

        

        return $final;

    }

    

    //DECREASEING PRODUCT QUANTITY

    function decrease_quantity($product_id, $quantity, $sale_id = '')

    {

        $prev_quantity          = $this->crud_model->get_type_name_by_id('product', $product_id, 'current_stock');

        $data1['current_stock'] = $prev_quantity - $quantity;

        if ($data1['current_stock'] < 0) {

            $data1['current_stock'] = 0;

        }

        $this->db->where('product_id', $product_id);

        $this->db->update('product', $data1);

    }

    

    //INCREASEING PRODUCT QUANTITY

    function increase_quantity($product_id, $quantity, $sale_id = '')

    {

        $prev_quantity          = $this->crud_model->get_type_name_by_id('product', $product_id, 'current_stock');

        $data1['current_stock'] = $prev_quantity + $quantity;

        if ($data1['current_stock'] < 0) {

            $data1['current_stock'] = 0;

        }

        $this->db->where('product_id', $product_id);

        $this->db->update('product', $data1);

    }

    

    //IF PRODUCT IS IN SALE

    function product_in_sale($sale_id, $product_id, $field)

    {

        $return          = 0;

        $product_details = json_decode($this->get_type_name_by_id('sale', $sale_id, 'product_details'), true);

        foreach ($product_details as $row) {

            if ($row['id'] == $product_id) {

                $return = $row[$field];

            }

        }

//        if ($return == 0) {
//
//            return false;
//
//        } else {

            return $return;

     //   }

    }

    

    //GETTING IDS OF A TABLE FILTERING SPECIFIC TYPE OF VALUE RANGE

    function ids_between_values($table, $value_type, $up_val, $down_val)

    {

        $this->db->order_by($table . '_id', 'desc');

        return $this->db->get_where($table, array(

            $value_type . ' <=' => $up_val,

            $value_type . ' >=' => $down_val

        ))->result_array();

    }

    

    //DAYS START-END TIMESTAMP

    function date_timestamp($date, $type)

    {

        $date = explode('-', $date);

        $d    = $date[2];

        $m    = $date[1];

        $y    = $date[0];

        if ($type == 'start') {

            return mktime(0, 0, 0, $m, $d, $y);

        }

        if ($type == 'end') {

            return mktime(0, 0, 0, $m, $d + 1, $y);

        }

    }

    

    //GETTING STOCK REPORT

    function stock_report($product_id)

    {

        $report = array();

        $start  = $this->get_type_name_by_id('product', $product_id, 'add_timestamp');

        $end    = time();

        $stock  = 0;

        

        $diff = 86400;

        $days = array();

        while ($end > $start) {

            $date = date('Y-m-d', $start);

            $start += $diff;

            $dstart     = $this->date_timestamp($date, 'start');

            $dend       = $this->date_timestamp($date, 'end');

            $all_stocks = $this->ids_between_values('stock', 'datetime', $dend, $dstart);

            

            $all_stocks = array_reverse($all_stocks);

            

            foreach ($all_stocks as $row) {

                if ($row['product'] == $product_id) {

                    if ($row['type'] == 'add') {

                        $stock += $row['quantity'];

                    } else if ($row['type'] == 'destroy') {

                        $stock -= $row['quantity'];

                    }

                }

            }

            $report[] = array(

                'date' => $date,

                'stock' => $stock

            );

        }

        //return array_reverse($report);

        return $report;

    }

    

    //GETTING ALL SALE DATES

    function all_sale_date($product_id)

    {

        $dates = array();

        $sales = $this->db->get('sale')->result_array();

        foreach ($sales as $i => $row) {

            if ($this->product_in_sale($row['sale_id'], $product_id, 'id')) {

                $date = $this->get_type_name_by_id('sale', $row['sale_id'], 'sale_datetime');

                $date = date('Y-m-d', $date);

                if (!in_array($date, $dates)) {

                    array_push($dates, $date);

                }

            }

        }

        return $dates;

    }

    

    //GETTING ALL SALE DATES

    function all_sale_date_n($product_id)
    {
        $dates      = array();
        $first_date = '';
        $sales      = $this->db->get('sale')->result_array();
        foreach ($sales as $i => $row) 
		{
            if($this->session->userdata('title') !== 'vendor' || $this->is_sale_of_vendor($row['sale_id'],$this->session->userdata('vendor_id')))
			{
                if ($this->product_in_sale($row['sale_id'], $product_id, 'id')) 
				{
                    $first_date = $this->get_type_name_by_id('sale', $row['sale_id'], 'sale_datetime');
                    break;
                }
            }
        }

        if ($first_date !== '') 
		{
            $current = $first_date;
            $last    = time();
            while ($current <= $last) 
			{
                $dates[] = date('Y-m-d', $current);
                $current = strtotime('+1 day', $current);
            }
        }

        return $dates;
    }

    

    //GETTING SALE DETAILS BY PRODUCT DAYS

    function sale_details_by_product_date($product_id, $date, $type)

    {

        

        $return   = 0;

        $up_val   = $this->date_timestamp($date, 'end');

        $down_val = $this->date_timestamp($date, 'start');

        $sales    = $this->ids_between_values('sale', 'sale_datetime', $up_val, $down_val);

        foreach ($sales as $i => $row) {

            if ($a = $this->product_in_sale($row['sale_id'], $product_id, $type)) {

                $return += $a;

            }

        }

        return $return;

    }

    

    //GETTING TOTAL OF A VALUE TYPE IN SALES

    function total_sale($product_id, $field = 'qty')

    {

        $return = 0;

        $sales  = $this->db->get('sale')->result_array();

        foreach ($sales as $row) {

            if ($a = $this->product_in_sale($row['sale_id'], $product_id, $field)) {

                $return += $a;

            }

        }

        return $return;

    }

    

    //GETTING MOST SOLD PRODUCTS

    function most_sold_products()

    {

        $result  = array();

        $product = $this->db->get('product')->result_array();

        foreach ($product as $row) {

            $result[] = array(

                'id' => $row['product_id'],

                'sale' => $this->total_sale($row['product_id'])

            );

        }

        if (!function_exists('compare_lastname')) {

            function compare_lastname($a, $b)

            {

                return strnatcmp($b['sale'], $a['sale']);

            }

        }

        

        usort($result, 'compare_lastname');

        return $result;

    }

    

    

    

    //GETTING BOOTSTRAP COLUMN VALUE

    function boot($num)

    {

        return (12 / $num);

    }

    

    //GETTING LIMITING CHARECTER

    function limit_chars($string, $char_limit)

    {

        $length = 0;

        $return = array();

        $words  = explode(" ", $string);

        foreach ($words as $row) {

            $length += strlen($row);

            $length += 1;

            if ($length < $char_limit) {

                array_push($return, $row);

            } else {

                array_push($return, '...');

                break;

            }

        }

        

        return implode(" ", $return);

    }

    

    //GETTING LOGO BY TYPE

    function logo($type)

    {

        $logo = $this->db->get_where('ui_settings', array(

            'type' => $type

        ))->row()->value;

        return base_url() . 'uploads/logo_image/logo_' . $logo . '.png';

    }

    

    //GETTING PRODUCT PRICE CALCULATING DISCOUNT

    function get_product_price($product_id)

    {

        // $price         = (float) $this->get_type_name_by_id('product', $product_id, 'sale_price');

        // $discount      = (float)$this->get_type_name_by_id('product', $product_id, 'discount');

        // $discount_type = (float)$this->get_type_name_by_id('product', $product_id, 'discount_type');

        // if ($discount_type == 'amount') {

        //     $number = ($price - $discount);

        // }

        // if ($discount_type == 'percent') {

        //     $number = ($price - ($discount * $price / 100));

        // }
        $number = $this->getVendorPrice($product_id,wh_country()->code);
        return number_format((float) $number, 2, '.', '');

    }
    function getVendorPrice($prdId,$whCode){
        $result     =   $this->db->select('P.*')
                        ->join('vendor as V','P.vendor_id = V.vendor_id')->join('countries as C','V.country_code = C.id')
                        ->get_where('vendor_prices as P',['P.prd_id'=>$prdId,'C.sortname'=>$whCode])->row();
        if($result){ $price = $result->price; }else{ $price = 0; } return $price;
    }

    

    //GETTING SHIPPING COST

    function get_shipping_cost($product_id)
    {
        //$price              = $this->get_type_name_by_id('product', $product_id, 'sale_price');
        $shipping           = $this->get_type_name_by_id('product', $product_id, 'shipping_cost');
        $shipping_cost_type = $this->get_type_name_by_id('business_settings', '3', 'value');
        if ($shipping_cost_type == 'product_wise') 
		{
            if($shipping == '')
			{
                return 0;
            } 
			else 
			{
                return ($shipping);                
            }
        }

        if ($shipping_cost_type == 'fixed') 
		{
            return 0;
        }
    }

    

    //GETTING PRODUCT TAX

    function get_product_tax($product_id)

    {

        $price    = $this->get_type_name_by_id('product', $product_id, 'sale_price');

        $tax      = $this->get_type_name_by_id('product', $product_id, 'tax');

        $tax_type = $this->get_type_name_by_id('product', $product_id, 'tax_type');

        if ($tax_type == 'amount') {

            if($tax == ''){

                return 0;

            } else {

                return $tax;                

            }

        }

        if ($tax_type == 'percent') {

            if($tax == ''){

                $tax = 0;

            }

            return ($tax * $price / 100);

        }

    }

    

    

    //GETTING MONTH'S TOTAL BY TYPE

    function month_total($type, $filter1 = '', $filter_val1 = '', $filter2 = '', $filter_val2 = '', $notmatch = '', $notmatch_val = '')

    {

        $ago = time() - (86400 * 30);

        $a   = 0;

        if ($type == 'sale') {

            $result = $this->db->get_where('sale', array(

                'sale_datetime >= ' => $ago,

                'sale_datetime <= ' => time()

            ))->result_array();

            foreach ($result as $row) {

                if($this->session->userdata('title') == 'admin'){

                    if($this->sale_payment_status($row['sale_id'],'admin') == 'fully_paid'){

                        //make version for vendor

                        $res_cat = $this->db->get_where('product', array(

                            'category' => $filter_val1

                        ))->result_array();

                        foreach ($res_cat as $row1) {

                            if ($p = $this->product_in_sale($row['sale_id'], $row1['product_id'], 'subtotal')) {

                                $a += $p;

                            }

                        }

                    }

                }

                if($this->session->userdata('title') == 'vendor'){

                    if($this->sale_payment_status($row['sale_id'],'vendor',$this->session->userdata('vendor_id')) == 'fully_paid'){

                        //make version for vendor

                        $res_cat = $this->db->get_where('product', array(

                            'category' => $filter_val1

                        ))->result_array();

                        foreach ($res_cat as $row1) {

                            if ($p = $this->vendor_share_in_sale($row['sale_id'],$this->session->userdata('vendor_id'),'paid')) {

                                $p = $p['total'];

                                $a += $p;

                            }

                        }

                    }

                }

            } 

        } else if ($type == 'stock') {

            $result = $this->db->get_where('stock', array(

                'datetime >= ' => $ago,

                'datetime <= ' => time()

            ))->result_array();

            foreach ($result as $row) {

                if ($row[$filter2] == $filter_val2) {

                    if ($row[$filter1] == $filter_val1) {

                        if ($notmatch == '') {

                            $a += $row['total'];

                        } else {

                            if ($row[$notmatch] !== $notmatch_val) {

                                $a += $row['total'];

                            }

                        }

                    }

                }

            }

        }

        return $a;

    }

    

    function email_invoice($sale_id){
	    $is_guest = $this->db->get_where('sale', array('sale_id' => $sale_id))->row()->buyer;
        if ($is_guest == "guest") {
            $info = json_decode($this->db->get_where('sale', array('sale_id' => $sale_id))->row()->shipping_address, true);
            $email = $info['email'];
        } else {
            $email = $this->get_type_name_by_id('user', $this->get_type_name_by_id('sale', $sale_id, 'buyer'), 'email');
        }
        $sale_code = '#'.$this->get_type_name_by_id('sale', $sale_id, 'sale_code');

        $from = $this->db->get_where('general_settings', array( 'type' => 'system_email'))->row()->value;

        $page_data['sale_id'] = $sale_id;

        $text = $this->load->view('front/invoice_email', $page_data, TRUE);

        $this->email_model->do_email($text, 'Sale Invoice '.$sale_code, $email, $from);

        /*
		$admins = $this->db->get_where('admin',array('role'=>'7'))->result_array();
		
        foreach ($admins as $row) 
		{
            $salehead='New Sale ('.$sale_code.')';
            $this->email_model->do_email($text, $salehead, $row['email'], $from);
        }
           */        
		$sellers=$this->vendors_in_sale($sale_id);
		foreach ($sellers as $row2) 
        {
          $page_data['vendorid']=$row2;
          $text = $this->load->view('front/vendor_invoice', $page_data, TRUE);
          $salehead='New Sale ('.$sale_code.')';
          $vemail=$this->get_type_name_by_id('vendor', $row2, 'email');
          $this->email_model->do_email($text, $salehead, $vemail, $from);
        }
    }
    
    
    
    
    
    function account_opening($account_type = '', $email = '', $pass = '',$approve, $fname)
    {
        //$this->load->database();
        $system_name  = $this->db->get_where('general_settings', array(
            'type' => 'system_name'
        ))->row()->value;
        $system_email = $this->db->get_where('general_settings', array(
            'type' => 'system_email'
        ))->row()->value;
        
        $query = $this->db->get_where($account_type, array(
            'email' => $email
        ));
        
        if ($query->num_rows() > 0) {
          
            $email_sub = "Account Opening";
            if ($account_type == 'admin') {
                $to_name = $query->row()->name;
            } elseif ($account_type == 'user') {
                $to_name = $query->row()->username;
            } elseif ($account_type == 'user') {
                $to_name = $query->row()->dispaly_name;
            }
            $from      = $system_email;
            $from_name = $system_name;
            $email_to  = $email;
            /*$logo      = $this->crud_model->logo('home_top_logo');
            $apple= base_url()."uploads/others/iphone.png"; */
            $page_data['email']=$email_to;
	    $page_data['fname']=$fname;
            $email_msg=$this->load->view('front/welcome_email',$page_data,TRUE);
            
            
            $this->email_model->do_email($email_msg, $email_sub, $email_to, $from);
            return true;
        } else {
            return false;
        }
    }



/*quote_template*/

function quote_template($sub = '', $email = '', $msg = '',$phone='',$from_name='',$fromemail='',$pr_id)
    {
    
        $email_sub = 'REQUEST FOR QUOTE';
        $email_to  = $email;
        $message=$msg;
        $phone_num=$phone;
        $from_nm=$from_name;
        $frmmail=$fromemail;
            $page_data['sub']=$email_sub;
            $page_data['msg']=$message;
            $page_data['phn']=$phone_num;
            $page_data['frm_nm']= $from_nm;
            $page_data['from_email']= $fromemail;
            $page_data['prid']= $pr_id;
            $page_data['prname']=$this->crud_model->get_type_name_by_id('product', $pr_id, 'title');
            $page_data['prcde']=$this->crud_model->get_type_name_by_id('product', $pr_id, 'product_code');
            
            //$page_data['to']=$email_to;
            $email_msg=$this->load->view('front/quotetemp_email',$page_data,TRUE);
            
            
            $this->email_model->do_email($email_msg, $email_sub, $email_to, $from);
            return true;
        
    }


/*ends quote template*/



/*service_request_template*/

function service_template($vs_name='', $eq_make='', $eq_model='', $sl_no='', $po_of_cal='', $eta='', $agnt_detail='', $invc_add='', $email23='', $con_name='', $tel_co='', $pr_dec='',$email)
    {
    
       
           $page_data['q_vs_name']=$vs_name;
           $page_data['q_eq_make']=$eq_make;
           $page_data['q_eq_model']=$eq_model;
           $page_data['q_sl_no']=$sl_no;
           $page_data['q_po_of_cal']=$po_of_cal;
           $page_data['q_eta']=$eta;
           $page_data['q_agnt_detail']=$agnt_detail;
           $page_data['q_invc_add']=$invc_add;
           $page_data['q_email23']=$email23;
           $page_data['q_con_name']=$con_name;
           $page_data['q_tel_co']=$tel_co;
           $page_data['q_pr_dec']=$pr_dec;
          
           $email_to  = $email;
           
        $email_sub="Request For service";
            //$page_data['to']=$email_to;
            $email_msg=$this->load->view('front/servicetemp_email',$page_data,TRUE);
            
            
            $this->email_model->do_email($email_msg, $email_sub, $email_to, $from);
            return true;
        
    }


/*ends service_request_template template*/



    //GETTING VENDOR PERMISSION

    function vendor_permission($codename)

    {

        if ($this->session->userdata('vendor_login') !== 'yes') {

            return false;

        } else {

            return true;

        }

    }



    function is_added_by($type,$id,$user_id,$user_type = 'vendor')

    {

        $added_by = json_decode($this->db->get_where($type,array($type.'_id'=>$id))->row()->added_by,true);

        if($user_type == 'admin'){

            $user_id = $added_by['id'];

        }

		$this->benchmark->mark_time();

        if($added_by['type'] == $user_type && $added_by['id'] == $user_id){

            return true;

        } else {

            return false;

        }

    }

 function is_added_bygrp($type,$id,$user_id,$user_type = 'vendor')
    {
        $added_by = json_decode($this->db->get_where($type,array('group_id'=>$id))->row()->added_by,true);
        if($user_type == 'admin'){
            $user_id = $added_by['id'];
        }
        $this->benchmark->mark_time();
        if($added_by['type'] == $user_type && $added_by['id'] == $user_id){
            return true;
        } else {
            return false;
        }
    }



    //SALE WISE TOTAL BY TYPE

    function product_by($product_id,$with_link='')
    {
        $added_by = json_decode($this->db->get_where('product',array('product_id'=>$product_id))->row()->added_by,true);
        if($added_by['type'] == 'admin')
		{
            $name = $this->db->get_where('general_settings',array('type'=>'system_name'))->row()->value;
            if($with_link == '')
			{
                return $name;
            } 
			else if($with_link == 'with_link') 
			{
                return '<a href="'.base_url().'">'.$name.'</a>';
            }
			else if($with_link == 'link_only') 
            {
                return base_url();
            }
			else if($with_link == 'id') 
            {
                return '';
            }
        } 
		else if($added_by['type'] == 'vendor')
		{
            $name = $this->db->get_where('vendor',array('vendor_id'=>$added_by['id']))->row()->display_name;
            if($with_link == '')
			{
                return $name;
            } 
			else if($with_link == 'with_link') 
			{
                return '<a href="'.$this->vendor_link($added_by['id']).'">'.$name.'</a>';
            }
			else if($with_link == 'link_only') 
            {
                return $this->vendor_link($added_by['id']);
            }
			else if($with_link == 'id') 
            {
                return $added_by['id'];
            }
        }
    }



    function is_sale_of_vendor($sale_id,$vendor_id)

    {

        $return          = array();

        $product_details = json_decode($this->get_type_name_by_id('sale', $sale_id, 'product_details'), true);

        foreach ($product_details as $row) {

            if ($this->is_added_by('product',$row['id'],$vendor_id)) {

                $return[] = $row['id'];

            }

        }

        if (empty($return)) {

            return false;

        } else {

            return $return;

        }

    }



    function is_admin_in_sale($sale_id)

    {

        $return          = array();

        $product_details = json_decode($this->get_type_name_by_id('sale', $sale_id, 'product_details'), true);

        foreach ($product_details as $row) {

            if ($this->is_added_by('product',$row['id'],0,'admin')) {

                $return[] = $row['id'];

            }

        }

        if (empty($return)) {

            return false;

        } else {

            return $return;

        }

    }



    function vendors_in_sale($sale_id){

        $vendors = $this->db->get('vendor')->result_array();

        $return = array();

        foreach ($vendors as $row) {

            if($this->is_sale_of_vendor($sale_id,$row['vendor_id'])){

                $return[] = $row['vendor_id'];

            }

        }

        return $return;

    }



    function vendor_share_in_sale($sale_id,$vendor_id,$pay='',$pay_type=''){

        $product_price = 0;

        $tax = 0;

        $shipping = 0;

        $total = 0;

        if($pay == 'paid'){

            $pay = 'fully_paid';

        }

        if($this->sale_payment_status($sale_id,'vendor',$vendor_id) == $pay || $pay == ''){

            if($this->db->get_where('sale',array('sale_id'=>$sale_id))->row()->payment_type == $pay_type || $pay_type == ''){

                if($products = $this->is_sale_of_vendor($sale_id,$vendor_id)){

                    $products_in_sale = json_decode($this->get_type_name_by_id('sale', $sale_id, 'product_details'), true);

                    foreach ($products_in_sale as $row) {

                        if(in_array($row['id'], $products)){

                            $product_price  += $row['subtotal'];

                            $tax            += $row['tax'];

                            $shipping       += $row['shipping'];

                            $total          += $row['subtotal']+$row['tax']+$row['shipping'];

                        }

                    }

                }

            }

        }

        return array('price'=>$product_price,'tax'=>$tax,'shipping'=>$shipping,'total'=>$total);

    }



    function vendor_share_total($vendor_id,$pay='',$pay_type=''){

        $product_price = 0;

        $tax = 0;

        $shipping = 0;

        $total = 0;

        $sales = $this->db->get('sale')->result_array();

        foreach ($sales as $row) {

            $share = $this->vendor_share_in_sale($row['sale_id'],$vendor_id,$pay,$pay_type);

            $product_price  += $share['price'];

            $tax            += $share['tax'];

            $shipping       += $share['shipping'];

            $total          += $share['price']+$share['tax']+$share['shipping'];

        }

        return array('price'=>$product_price,'tax'=>$tax,'shipping'=>$shipping,'total'=>$total);

    }



    function paid_to_vendor($vendor_id){

        $total = 0;

        $vendor_invoice = $this->db->get_where('vendor_invoice',array('vendor_id'=>$vendor_id,'status'=>'paid'))->result_array();

        foreach ($vendor_invoice as $row) {

            $total += $row['amount'];

        }

        return $total;

    }



    function sale_payment_status($sale_id,$type='',$id=''){

        $payment_status = json_decode($this->db->get_where('sale', array(

            'sale_id' => $sale_id

        ))->row()->payment_status,true);

        $paid = '';

        $unpaid = '';

        foreach ($payment_status as $row) {

            if($type == ''){

                if($row['status'] == 'paid'){

                    $paid = 'yes';

                }

                if($row['status'] == 'due'){

                    $unpaid = 'yes';

                }

            } else {

                if(isset($row[$type])){

                    if($type == 'vendor'){

                        if($row[$type] == $id){

                            if($row['status'] == 'paid'){

                                $paid = 'yes';

                            }

                            if($row['status'] == 'due'){

                                $unpaid = 'yes';

                            }

                        }

                    } else if($type == 'admin'){

                        if($row['status'] == 'paid'){

                            $paid = 'yes';

                        }

                        if($row['status'] == 'due'){

                            $unpaid = 'yes';

                        }

                    }

                }

            }

        }

        if($paid == 'yes' && $unpaid == ''){

            return 'fully_paid';

        }

        else if($paid == 'yes' && $unpaid == 'yes'){

            return 'partially_paid';

        }

        else if($paid == '' && $unpaid == 'yes'){

            return 'due';

        }

        if($paid == '' && $unpaid == ''){

            return 'due';

        }

    }



    function is_category_of_vendor($category,$vendor_id){

        $product = $this->db->get_where('product',array('category'=>$category))->result_array();

        $p = 'no';

        foreach ($product as $row) {

            if($this->is_added_by('product',$row['product_id'],$vendor_id,'vendor')){

                $p = 'yes';

            }

        }

		$this->config->cache_query();

        if($p == 'yes'){

            return true;

        } else {

            return false;

        }

        

    }



    function is_sub_cat_of_vendor($sub_cat,$vendor_id){

        $product = $this->db->get_where('product',array('sub_category'=>$sub_cat))->result_array();

        $p = 'no';

        foreach ($product as $row) {

            if($this->is_added_by('product',$row['product_id'],$vendor_id,'vendor')){

                $p = 'yes';

            }

        }

        if($p == 'yes'){

            return true;

        } else {

            return false;

        }

    }



    function can_add_product($vendor){

        $membership = $this->db->get_where('vendor',array('vendor_id'=>$vendor))->row()->membership;

        $expire = $this->db->get_where('vendor',array('vendor_id'=>$vendor))->row()->member_expire_timestamp;

        $already = $this->db->get_where('product',array('added_by'=>'{"type":"vendor","id":"'.$vendor.'"}','status'=>'ok'))->num_rows();

        if($membership == '0'){

            $max = $this->db->get_where('general_settings',array('type'=>'default_member_product_limit'))->row()->value;

        } else {

            $max = $this->db->get_where('membership',array('membership_id'=>$membership))->row()->product_limit;

        }

        

		if($expire > time() || $membership == '0'){

			if($max <= $already){

				return false;

			} else if($max > $already){

				return true;

			}

		} else {

			return false;

		}

    }



    function is_publishable($product_id){

        //maximum product + membership change

        $by = json_decode($this->db->get_where('product',array('product_id'=>$product_id))->row()->added_by,true);

        if($by['type'] == 'admin'){

            return true;

        } else if($by['type'] == 'vendor'){

            $vendor_status = $this->db->get_where('vendor',array('vendor_id'=>$by['id']))->row()->status;

            if ($vendor_status == 'approved') {

                return true;

            } else {

                return false;

            }

        }

    }



    function set_product_publishability($vendor,$except=''){

        $membership = $this->db->get_where('vendor',array('vendor_id'=>$vendor))->row()->membership;

        $this->db->order_by('product_id','desc');

        $approved_products = $this->db->get_where('product',array('added_by'=>'{"type":"vendor","id":"'.$vendor.'"}','status'=>'ok'));

        $already = $approved_products->num_rows();        

        if($membership == '0'){

            $max = $this->db->get_where('general_settings',array('type'=>'default_member_product_limit'))->row()->value;

        } else {

            $max = $this->db->get_where('membership',array('membership_id'=>$membership))->row()->product_limit; 

        }

        if($max <= $already){

            $approved_products = $approved_products->result_array();

            $i = 0;

            foreach ($approved_products as $row) {

                $i++;

                if($row['product_id'] !== $except){

                    if($i < $max){

                        $data['status'] = 'ok';

                    } else {

                        $data['status'] = '0';

                    }

                    $this->db->where('product_id', $row['product_id']);

                    $this->db->update('product', $data);

                }

            }

        }

    }



    function check_vendor_mambership(){

        //interval loop check for end membership + email terminsation

        $vendors = $this->db->get('vendor')->result_array();

        foreach ($vendors as $row) {

            if($row['membership'] !== '0'){

                if($row['member_expire_timestamp'] < time()){

                    $data['membership'] = '0';

                    $this->db->where('vendor_id', $row['vendor_id']);

                    $this->db->update('vendor', $data);

                    $this->set_product_publishability($row['vendor_id']);

                    $this->email_model->membership_upgrade_email($row['vendor_id']);

                }

            }

        } 

    }



    function upgrade_membership($vendor,$membership){

        $vendor_cur         = $this->db->get_where('vendor',array('vendor_id'=>$vendor));

        $cur_membership     = $vendor_cur->row()->membership;

        $cur_expire         = $vendor_cur->row()->member_expire_timestamp;

        $membership_spec    =  $this->db->get_where('membership',array('membership_id'=>$membership));

        $timespan           = $membership_spec->row()->timespan;

        //$new_expire       = $cur_expire+($timespan*24*60*60);

        $new_expire         = time()+($timespan*24*60*60);

        $data['member_expire_timestamp'] = $new_expire;

        $data['membership'] = $membership;

        $this->db->where('vendor_id', $vendor);

        $this->db->update('vendor', $data);

        $this->email_model->membership_upgrade_email($vendor);

    }

    

    //GETTING ADMIN PERMISSION

    function admin_permission($codename)

    {

        if ($this->session->userdata('admin_login') != 'yes') {

            return false;

        }

        $admin_id   = $this->session->userdata('admin_id');

        $admin      = $this->db->get_where('admin', array(

            'admin_id' => $admin_id

        ))->row();

		$this->benchmark->mark_time();

        $permission = $this->db->get_where('permission', array(

            'codename' => $codename

        ))->row()->permission_id;

        if ($admin->role == 1) {

            return true;

        } else {

            $role             = $admin->role;

            $role_permissions = json_decode($this->crud_model->get_type_name_by_id('role', $role, 'permission'));

            if (in_array($permission, $role_permissions)) {

                return true;

            } else {

                return false;

            }

        }

    }

    

    

    //GETTING USER TOTAL

    function user_total($last_days = 0)

    {

        if ($last_days == 0) {

            $time = 0;

        } else {

            $time = time() - (24 * 60 * 60 * $last_days);

        }

        $sales  = $this->db->get_where('sale', array(

            'buyer' => $this->session->userdata('user_id'),
            'sale_datetime >=' => $time

        ))->result_array();

        $return = 0;

        foreach ($sales as $row) {

           $payment_status=json_decode($row['payment_status'],true) ;   
                
            foreach ($payment_status as $dev) 
            {

                if($dev['status'] == 'paid')
                {
                    $return += $row['grand_total'];
                }
            }

        }

        return number_format((float) $return, 2, '.', '');

    }

    

    

    //GETTING NUMBER OF WISHED PRODUCTS BY CURRENT USER

    function user_wished()

    {

        $user = $this->session->userdata('user_id');

        return count(json_decode($this->get_type_name_by_id('user', $user, 'wishlist')));

    }

    

    //ADDING PRODUCT TO WISHLIST

    function add_wish($product_id)

    {

        $user = $this->session->userdata('user_id');

        if ($this->get_type_name_by_id('user', $user, 'wishlist') !== 'null') {

            $wished = json_decode($this->get_type_name_by_id('user', $user, 'wishlist'));

        } else {

            $wished = array();

        }

        if ($this->is_wished($product_id) == 'no') {

            array_push($wished, $product_id);

            $this->db->where('user_id', $user);

            $this->db->update('user', array(

                'wishlist' => json_encode($wished)

            ));

        }

    }

    

    //REMOVING PRODUCT FROM WISHLIST

    function remove_wish($product_id)

    {

        $user = $this->session->userdata('user_id');

        if ($this->get_type_name_by_id('user', $user, 'wishlist') !== 'null') {

            $wished = json_decode($this->get_type_name_by_id('user', $user, 'wishlist'));

        } else {

            $wished = array();

        }

        $wished_new = array();

        foreach ($wished as $row) {

            if ($row !== $product_id) {

                $wished_new[] = $row;

            }

        }

        $this->db->where('user_id', $user);

        $this->db->update('user', array(

            'wishlist' => json_encode($wished_new)

        ));

    }

    

    

    //NUMBER OF WISHED PRODUCTS

    function wished_num()

    {

        $user = $this->session->userdata('user_id');

        if ($this->get_type_name_by_id('user', $user, 'wishlist') !== '') {

            return count(json_decode($this->get_type_name_by_id('user', $user, 'wishlist')));

        } else {

            return 0;

        }

    }

    

    

    //IF PRODUCT IS ADDED TO CURRENT USER'S WISHLIST

    function is_wished($product_id)

    {

        if ($this->session->userdata('user_login') == 'yes') {

            $user = $this->session->userdata('user_id');

            //$wished = array('0');

            if ($this->get_type_name_by_id('user', $user, 'wishlist') !== '') {

                $wished = json_decode($this->get_type_name_by_id('user', $user, 'wishlist'));

            } else {

                $wished = array(

                    '0'

                );

            }

            if (in_array($product_id, $wished)) {

                return 'yes';

            } else {

                return 'no';

            }

        } else {

            return 'no';

        }

    }

    

    //GETTING TOTAL WISHED PRODUCTT BY USER

    function total_wished($product_id)

    {

        $num   = 0;

        $users = $this->db->get('user')->result_array();

        foreach ($users as $row) {

            $wishlist = json_decode($row['wishlist']);

            if (is_array($wishlist)) {

                if (in_array($product_id, $wishlist)) {

                    $num++;

                }

            }

            

        }

        return $num;

    }

    

    //GETTING MOST WISHED PRODUCTS

    function most_wished()

    {

        $result  = array();

        $product = $this->db->get('product')->result_array();

        foreach ($product as $row) {

            $result[] = array(

                'title' => $row['title'],

                'wish_num' => $this->total_wished($row['product_id']),

                'id' => $row['product_id']

            );

        }

        if (!function_exists('compare_lastname')) {

            function compare_lastname($a, $b)

            {

                return strnatcmp($b['wish_num'], $a['wish_num']);

            }

        }

        usort($result, 'compare_lastname');

        return $result;

    }

    

    //RATING

    function rating($product_id)

    {

        $total = $this->get_type_name_by_id('product', $product_id, 'rating_total');

        $num   = $this->get_type_name_by_id('product', $product_id, 'rating_num');

        if ($num > 0) {

            $number = $total / $num;

            return number_format((float) $number, 2, '.', '');

        } else {

            return 0;

        }

    }

    

    //IF CURRENT USER RATED THE PRODUCT

    function is_rated($product_id)

    {

        if ($this->session->userdata('user_login') == 'yes') {

            $user = $this->session->userdata('user_id');

            if ($this->get_type_name_by_id('product', $product_id, 'rating_user') !== '') {

                $rating_user = json_decode($this->get_type_name_by_id('product', $product_id, 'rating_user'));

            } else {

                $rating_user = array(

                    '0'

                );

            }

            if (in_array($user, $rating_user)) {

                return 'yes';

            } else {

                return 'no';

            }

        } else {

            return 'no';

        }

    }

    

    //SETTING RATING

    function set_rating($product_id, $rating)

    {

        if ($this->is_rated($product_id) == 'yes') {

            return 'no';

        }

        

        $total = $this->get_type_name_by_id('product', $product_id, 'rating_total');

        $num   = $this->get_type_name_by_id('product', $product_id, 'rating_num');

        $user  = $this->session->userdata('user_id');

        $total = $total + $rating;

        $num   = $num + 1;

        

        $rating_user = json_decode($this->get_type_name_by_id('product', $product_id, 'rating_user'));

        if (!is_array($rating_user)) {

            $rating_user = array();

        }

        array_push($rating_user, $user);

        

        $this->db->where('product_id', $product_id);

        $this->db->update('product', array(

            'rating_user' => json_encode($rating_user)

        ));

        $this->db->where('product_id', $product_id);

        $this->db->update('product', array(

            'rating_total' => $total

        ));

        $this->db->where('product_id', $product_id);

        $this->db->update('product', array(

            'rating_num' => $num

        ));

        

        return 'yes';

    }

    

     //SETTING Review

    function set_review($product_id, $rating)

    {

        if ($this->is_rated($product_id) == 'yes') {

            return 'no';

        }

        

        $total = $this->get_type_name_by_id('product', $product_id, 'rating_total');

        $num   = $this->get_type_name_by_id('product', $product_id, 'rating_num');

        $user  = $this->session->userdata('user_id');

        $total = $total + $rating;

        $num   = $num + 1;

        

        $rating_user = json_decode($this->get_type_name_by_id('product', $product_id, 'rating_user'));

        if (!is_array($rating_user)) {

            $rating_user = array();

        }

        array_push($rating_user, $user);

        

        $this->db->where('product_id', $product_id);

        $this->db->update('product', array(

            'rating_user' => json_encode($rating_user)

        ));

        $this->db->where('product_id', $product_id);

        $this->db->update('product', array(

            'rating_total' => $total

        ));

        $this->db->where('product_id', $product_id);

        $this->db->update('product', array(

            'rating_num' => $num

        ));

        

        return 'yes';

    }

    

     //RATING

    function user_rating($product_id)

    {

        $total = $this->get_type_name_by_id('product', $product_id, 'rating_total');

        $num   = $this->get_type_name_by_id('product', $product_id, 'rating_num');

        if ($num > 0) {

            $number = $total / $num;

            return number_format((float) $number, 2, '.', '');

        } else {

            return 0;

        }

    }

    

    

    //GETTING IP DATA OF PEOPLE BROWING THE SYSTEM

    function ip_data()

    {

        if(!$this->input->is_ajax_request()){

            $this->session->set_userdata('timestamp', time());

            //$user_data = $this->session->userdata('surfer_info');

            $ip        = $_SERVER['REMOTE_ADDR'];

            /*if (!$user_data) {

                if ($_SERVER['HTTP_HOST'] !== 'localhost') {

                    $ip_data = file_get_contents("http://ip-api.com/json/" . $ip);

                    $this->session->set_userdata('surfer_info', $ip_data);

                }

            }*/

        }

    }

    

    

    //GETTING TOTAL PURCHASE

    function total_purchase($user_id)

    {

        $return = 0;

        $sales  = $this->db->get('sale')->result_array();

        foreach ($sales as $row) {

            if ($row['buyer'] == $user_id) {

                $return += $row['grand_total'];

            }

        }

        return $this->cart->format_number($return);

    }





    function seo_stat($type='') {

        try {

            $url = base_url();

            $seostats = new \SEOstats\SEOstats;

            if ($seostats->setUrl($url)) {



                if($type == 'facebook'){

                    return SEOstats\Services\Social::getFacebookShares();

                }

                elseif ($type == 'gplus') {

                    return SEOstats\Services\Social::getGooglePlusShares();

                }

                elseif ($type == 'twitter') {

                    return SEOstats\Services\Social::getTwitterShares();

                }

                elseif ($type == 'linkedin') {

                    return SEOstats\Services\Social::getLinkedInShares();

                }

                elseif ($type == 'pinterest') {

                    return SEOstats\Services\Social::getPinterestShares();

                }



                elseif ($type == 'alexa_global') {

                    return SEOstats\Services\Alexa::getGlobalRank();

                }

                elseif ($type == 'alexa_country') {

                    return SEOstats\Services\Alexa::getCountryRank();

                }



                elseif ($type == 'alexa_bounce') {

                    return SEOstats\Services\Alexa::getTrafficGraph(5);

                }

                elseif ($type == 'alexa_time') {

                    return SEOstats\Services\Alexa::getTrafficGraph(4);

                }

                elseif ($type == 'alexa_traffic') {

                    return SEOstats\Services\Alexa::getTrafficGraph(1);

                }

                elseif ($type == 'alexa_pageviews') {

                    return SEOstats\Services\Alexa::getTrafficGraph(2);

                }



                elseif ($type == 'google_siteindex') {

                    return SEOstats\Services\Google::getSiteindexTotal();

                }

                elseif ($type == 'google_back') {

                    return SEOstats\Services\Google::getBacklinksTotal();

                }

                elseif ($type == 'search_graph_1') {

                    return SEOstats\Services\SemRush::getDomainGraph(1);

                }

                elseif ($type == 'search_graph_2') {

                    return SEOstats\Services\SemRush::getDomainGraph(2);

                }



            }

        }

        catch(\Exception $e) {

            echo 'Caught SEOstatsException: ' . $e->getMessage();

        }

    }

	

	

    //ADDING PRODUCT TO compare
    function add_compare($product_id)
    {
		$compared=$this->session->userdata('compare');
		if (in_array($product_id, $compared))
		{
			return 'already';
		}
		else
		{
			if(count($compared)>=3)
			{
				return 'cat_full';
			}
			if(!count($compared))
			{
				$compared=array();
			}
			
			array_push($compared, $product_id);
        	$this->session->set_userdata('compare',$compared);
        	return json_encode($this->session->userdata('compare'));
		}
    }



    //REMOVING PRODUCT FROM Compare list
    function remove_compare($product_id)
    {
		$compared=$this->session->userdata('compare');
		if(($key = array_search($product_id, $compared)) !== false) 
		{
    		unset($compared[$key]);
		}
		$this->session->set_userdata('compare',$compared);
		return json_encode($this->session->userdata('compare'));
    }    


    //NUMBER OF compared PRODUCTS
    function compared_num()
    {
        return count($this->session->userdata('compare'));
    }    


    //IF PRODUCT IS ADDED TO CURRENT USER'S WISHLIST
    function is_compared($product_id)
    {  
		$compared=$this->session->userdata('compare');
            if($compared && count($compared) > 0){
		if (in_array($product_id, $compared))
		{
			return 'yes';
		}
            }   
        return 'no';
    } 



    //IF PRODUCT IS ADDED TO CURRENT USER'S WISHLIST

    function compared_shower()

    {        

        if($this->session->userdata('compare') == ''){

            $this->session->set_userdata('compare','[]');

        }

        $compared = json_decode($this->session->userdata('compare'),true);

        $cats = array();

        $products = array();

        $result = array();

        foreach ($compared as $row) {

            $cat = $this->db->get_where('product',array('product_id'=>$row))->row()->category;

            $cats[] = $cat;

            $products[] = array('c'=>$cat,'p'=>$row);

        }

        $cats   = array_unique($cats);

        foreach ($cats as $row) {

            $ps     = array();

            foreach ($products as $r) {

                if($r['c'] == $row){

                    $ps[] = $r['p'];

                }

            }

            $result[] = array('category'=>$row,'products'=>$ps);

        }

        return $result;

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



    /* FUNCTION: Regarding Digital*/

    function is_digital($id){

        if($this->db->get_where('product',array('product_id'=>$id))->row()->download == 'ok'){

            return true;

        } else {

            return false;

        }

    }



    function download_product($id){

        if($this->can_download($id)){

            $this->load->helper('download');

            $name       = $this->db->get_where('product',array('product_id'=>$id))->row()->download_name;

            $folder     = $this->db->get_where('general_settings', array('type' => 'file_folder'))->row()->value;

            $link       = 'uploads/file_products/' . $folder .'/' . $name;

            force_download($link, NULL);

            echo 'ok';

        } else {

            echo 'not';

        }

    }



    function digital_to_customer($sale_id){

        $carted = json_decode($this->db->get_where('sale', array(

                    'sale_id' => $sale_id

                ))->row()->product_details, true);

        $user = $this->db->get_where('sale', array(

                    'sale_id' => $sale_id

                ))->row()->buyer;

        $downloads = $this->db->get_where('user', array(

                    'user_id' => $user

                    ))->row()->downloads;

        $result = array();

        foreach ($carted as $row) {

            if($this->is_digital($row['id'])){

                $result[] = array('sale'=>$sale_id,'product'=>$row['id']);

            }

        }

        if($downloads !== ''){

            $downloads = json_decode($downloads,true);

        } else if($downloads == ''){

            $downloads = json_decode('[]',true);

        }

        $data['downloads'] = json_encode(array_merge($downloads,$result));

        $this->db->where('user_id',$user);

        $this->db->update('user',$data);

    }



    function can_download($product){

        if($this->session->userdata('admin_login') == 'yes'){

            return true;

        }

        if($this->session->userdata('vendor_login') == 'yes'){

            if($this->is_added_by('product',$product,$this->session->userdata('vendor_id'),'vendor')){

                return true;

            } else {

                return false;

            }

        }

        if($this->session->userdata('user_login') == 'yes'){

            $user = $this->session->userdata('user_id');

            $downloads = $this->db->get_where('user', array(

                        'user_id' => $user

                        ))->row()->downloads;

            $ok = 'no';

            if($downloads !== ''){

                $downloads = json_decode($downloads,true);

            } else if($downloads == ''){

                $downloads = json_decode('[]',true);

            }

			print_r($downloads);

            foreach ($downloads as $row) {

                if($row['product'] == $product){

                    $by = json_decode($this->db->get_where('product', array(

                                'product_id' => $product

                              ))->row()->added_by,true);

                    $type = $by['type'];

                    $id = $by['id'];

                    $status = json_decode($this->db->get_where('sale', array(

                                'sale_id' => $row['sale']

                              ))->row()->payment_status,true);

                    $fs = '';

                    foreach ($status as $t) {

                        if($type == 'vendor'){

                            if($t[$type] == $id){

                                $fs = $t['status'];

                            }

                        } else if($type == 'admin'){

                            $fs = $t['status'];

                        }

                    }

					echo $fs;

                    if($fs == 'paid'){

                        $ok = 'yes';

                    }

                }

            }

            if($ok == 'yes'){

                return true;

            } else {

                return false;

            }

        } else {

            return false;

        }



    }


/*Search terms */
        function search_terms($term)
        {   
             //$term='wq';
             $sid=$this->db->get_where('search_terms',array('term'=>$term))->result_array();
             $id="";
                foreach ($sid as $pid) 
                {
                    $id=$pid['id'];
                    $count=$pid['count'];
                }


                if ($id > 0)
                    {
                       // echo $pid['id'].":".$pid['count'];
                        $count=$count+1;
                        $sql = "UPDATE search_terms SET count=".$count." WHERE id=".$id;
                        $this->db->query($sql);
                        //echo $count;
                    }

                    else
                    {
                        $data['id']     = "";
                        $data['term']   = $term;
                        $data['count']  = 1;
                        $this->db->insert('search_terms',$data);  
                    }
        }

// Captcha 
function captcha($term)
{
    $this->load->helper('captcha');
    $this->load->library('image_lib');

    if($term=="new")
    {
        // Captcha configuration
        $config = array(
            'img_path'      => 'captcha_images/',
            'img_url'       => base_url().'captcha_images/',
            'img_width'     => '150',
            'img_height'    => 50,
            'word_length'   => 5,
            'font_path'  => 'template/fonts/Dink.ttf',
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
        
        // Send captcha image to view
        echo $captcha['image'];
    }

    else if($term=="refresh")
    {
        // Captcha configuration
        $config = array(
            'img_path'      => 'captcha_images/',
            'img_url'       => base_url().'captcha_images/',
            'img_width'     => '150',
            'img_height'    => 50,
            'word_length'   => 5,
            'font_path'  => 'template/fonts/Dink.ttf',
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
}
    function get_vendor_by_id($id)
    { 
        $vendor = $this->db->join('countries as C','V.country_code = C.id')->get_where('vendor as V',['V.vendor_id'=>$id])->row();
        return $vendor;
    }
    
    function getFedexLabelHistory($id)
    { 
        $data = $this->db->get_where('fed_labels',array('order_id'=>$id))->result_array();
        return $data;
    }
    
    function getPrdDetails($ids)
    {
        $data = $this->db->query("select SUM(`weight`) AS weight, SUM(`sale_price`) AS price, weight_class_id, length_class_id, SUM(`length`) as length, SUM(`width`) as width, SUM(`height`) as height from `product` where `product_id` IN (".implode(',', $ids).")")->row();
        return $data;
    }
    function getOrderedPrdDetails($ids)
    {
        $data = $this->db->query("select * from `product` where `product_id` IN (".implode(',', $ids).")")->result_array();
        return $data;
    }
    function getWeightClass()
    {
        $data = $this->db->get('fed_weight_class_description')->result_array();
        return $data;
    }
    function getDimClass()
    {
        $data = $this->db->get('fed_length_class_description')->result_array();
        return $data;
    }
    function get_groupProucts_by_id($id)
    {
        $data = $this->db->get_where('grouped_product',array( 'grouped_id' => $id))->result_array();
        return $data;
    }
    function get_groupProuctCount_by_id($id)
    {
        return $this->db->get_where('grouped_product',array( 'grouped_id' => $id))->num_rows();
    }

    /*function getRelatedProducts($model='', $subCat=0)
    {
        $query = $this->db->like('model',$model)->where('status',"ok")->limit(3)->get('product');
        if($query->num_rows() > 0){ return $query->result_array(); }
        else{ 
            $query = $this->db->where('sub_category',$subCat)->where('status',"ok")->limit(3)->get('product');
            return $query->result_array();
        }
    }*/

    function getLatestProduct()
    {
        $sql = 'SELECT P.* FROM product AS P WHERE P.status = "ok" AND P.latest = "ok" AND P.current_stock > 0 AND P.vendor_approved ="1" ORDER BY P.product_id DESC LIMIT 25';
        $query = $this->db->query($sql);
        if($query->num_rows() > 0)
		{
            return $query->result_array();
        }else{ return false; }
    }
	
    function getFeaturedProduct()
    {
        $sql    =   'SELECT P.* FROM product AS P WHERE P.status = "ok" AND P.featured = "ok" AND P.current_stock > 0 AND P.vendor_approved ="1" ORDER BY P.product_id DESC LIMIT 25';
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{ return false; }
    }
    function getHomeBrands()
    {
        $brandIds   =   json_decode($this->crud_model->get_type_name_by_id('ui_settings','13','value'));
        $query      =   $this->db->where_in('brand_id',$brandIds)->get('brand');
        if($query->num_rows() > 0){ return $query->result_array(); }else{ return false; }
    }
    function getCountryName($id){ 
        $data = $this->db->get_where('fed_country',array( 'country_id' => $id))->row();
        return $data;
    }
    function getStateName($cid, $id){ 
        $data = $this->db->get_where('fed_zone',array('country_id' => $cid, 'code' => $id))->row();
        return $data->name;
    }
    function getProductDescription($id){
        $data = $this->db->get_where('product',array('product_id' => $id))->row();
        return $data->description;
    }

    function getRecentProduct()
    {

    $criteria = (isset($_SESSION["lastviewed"])?implode(", ",$_SESSION["lastviewed"]):"-1");
    $sql = "SELECT p.*,b.name FROM product p , brand b WHERE b.brand_id = p.brand and p.product_id IN ($criteria) and p.status = 'ok' ";

        $query = $this->db->query($sql);
        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
            { return false; }      
    }
    function changePasswordEmail(){
        $subject    =   'Password Changed';
        $user       =   $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row();
        $from       =   $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
	$data['user']=  $user;
	$text       =   $this->load->view('front/resetpass_email', $data, TRUE);
        $this->email_model->do_email($text, $subject, $user->email, $from);
	return true;
    }


    //ajith 

function getRelatedProductsrp($model='', $subCat=0,$rpid)
    {
        $query = $this->db->like('model',$model, 'after')->where('status',"ok")->where('product_id !=',$rpid)->limit(4)->get('product'); 
        if($query->num_rows() > 0)
            {
             return $query->result_array(); 
            }
        else
        { 
            $query = $this->db->where('sub_category',$subCat)->where('status',"ok")->limit(3)->get('product');
            return $query->result_array();
        }
    }

    function getBrandIds($name){
        $textInput      =   explode(' ',$name); $bName      =   ""; 
        if(count($textInput)>1){ foreach ($textInput as $txtIn){ if($txtIn != '' && $txtIn != ' '){ $bName  =   $bName." OR `name` LIKE '%$txtIn%' "; } } }
        $sql = " SELECT `brand_id` FROM `brand` WHERE `name` = '$name' ".$bName;
        $query = $this->db->query($sql);
     //   $query = $this->db->select('brand_id')->like('name', $name, 'both')->get('brand');
        if($query->num_rows() > 0){ 
            $n=0;
            foreach ($query->result_array() as $row){ if($n==0){ $ids = $row['brand_id']; }else{ $ids = $ids.','.$row['brand_id']; } $n++; }
            return $ids;
        }else{ return false; }
    }


function getRelatedProducts($rpid)
{
	$product_data  = $this->db->get_where('product', array('product_id' => $rpid,'status' => 'ok'));
 	if($product_data->num_rows() > 0)
    {
		return  $product_data->result_array();
    }
}

function getRelatedProducts_model($model='',$subCat=0,$rpid) 
{
    $rid='"'.$rpid.'"';
    $query = $this->db->like('related_products',$rid, 'both')->where('status',"ok")->where('product_id !=',$rpid)->where('current_stock >',0)->limit(3)->get('product'); //
    if($query->num_rows() > 0)
    {
     return $query->result_array(); 
    }
}
    function getProductStatus($id, $status, $user_type){
        $data               =   array();
        $product            =   $this->db->get_where('product', array('product_id' => $id))->row();
        $data['vendor_approved']    =   $product->vendor_approved;
        $data['admin_approved']     =   $product->admin_approved;
        $data['status']             =   $product->status;
        if($user_type == 'admin'){
            if($status       == 'true'){
                if($product->vendor_approved == 1){ 
                    $data['status'] =   'ok';
                }
                $data['admin_approved'] =   1;
            }else{
                $data['status'] =   0;
                $data['admin_approved'] =   0;
            }
        }else{
            if($status       == 'true'){
                if($product->admin_approved == 1){ 
                    $data['status'] =   'ok';
                }
                $data['vendor_approved'] =   1;
            }else{
                $data['status'] =   0;
                $data['vendor_approved'] =   0;
            }
        }
        return $data;
    }


function update_erp_tables($sale_id)
{

$sale_details   = $this->db->get_where('sale', array('sale_id' => $sale_id))->row();
$shipping_address = json_decode($sale_details->shipping_address,true);
$products         = json_decode($sale_details->product_details,true);
$sale_code        = $sale_details->sale_code;
$payment_type     = $sale_details->payment_type;

$shipping_charge  = $sale_details->shipping;
$vat_tax          = $sale_details->vat;
$coupon_discount  = $sale_details->discount;

$order_date       = $sale_details->sale_datetime;
$payment_status   = json_decode($sale_details->payment_status,true);
                    foreach ($payment_status as $dev) 
                    {
                        if(isset($dev['vendor']))
                        {
                           $pstatus = $dev['status'];
                        }
                        else if(isset($dev['admin'])) 
                        {
                           $pstatus = $dev['status'];
                        }
                    }
$cust_name = $shipping_address['sfirstname'].".".$shipping_address['slastname'];
$ship_addr1= $shipping_address['saddress1'];
$ship_addr2= $shipping_address['saddress2'];
$ship_city = $shipping_address['scity'];
$ship_postcode= $shipping_address['szip'];
$ship_cntry= $this->crud_model->getCountryName($shipping_address['scountry']);
$ship_state= $this->crud_model->getStateName($ship_cntry->country_id, $shipping_address['sstate']);
$ship_cntry_name=$ship_cntry->name;

    //insert table so_head
    
    $data['order_number']       = $sale_code;
    $data['cust_name']          = $cust_name;
    $data['ship_address1']      = $ship_addr1;
    $data['ship_address2']      = $ship_addr2;
    $data['ship_city']          = $ship_city;
    $data['ship_state']         = $ship_state;
    $data['ship_country']       = $ship_cntry_name;
    $data['ship_postcode']      = $ship_postcode;
    $data['phone_no']           = $shipping_address['sphone'];
    $data['email']              = $shipping_address['semail'];
    $data['shipment_mode']      = $shipping_address['ship_method'];
    $data['shipment_charge']    = $shipping_charge;
    $data['total_tax']          = $vat_tax;
    $data['coupon_discount']    = $coupon_discount;
    $data['payment_method']     = $payment_type;
    $data['payment_status']     = $pstatus;  
    $data['order_date']         = date("Y/m/d",$order_date);
    $this->db->insert('so_head',$data); 

    //end

        if (count($products) > 0) 
        {
            foreach ($products as $items) 
            {
            $p_id= $items['id'];
            $pr_unitprice= $this->get_type_name_by_id('product',$p_id,'sale_price');
            $pr_code = $this->get_type_name_by_id('product',$p_id,'product_code');
            $pr_discount = $this->get_type_name_by_id('product',$p_id,'discount');
            $pr_name = $this->get_type_name_by_id('product',$p_id,'title');
            $pr_quantity  = $items['qty']; 
            $pr_unitprice_sel = $items['price'];  
            $pr_total= $pr_unitprice_sel*$pr_quantity;

                //insert table so_item
                $data1['order_number']  = $sale_code; 
                $data1['item_code']     = $pr_code;
                $data1['item_name']     = $pr_name;
                $data1['quanity']       = $pr_quantity;
                $data1['unit_price']    = $pr_unitprice;
                $data1['discount_value']= $pr_discount;
                $data1['total_price']   = $pr_total;
                $this->db->insert('so_item',$data1);
                //end        
            }
        }
}

    function isGroupedPrd($id,$qty=''){ 
        if($this->db->get_where('product',array('product_id'=>$id))->row()->type == 'grouped'){ 
            $grouped    =   $this->db->get_where('grouped_product',array('grouped_id'=>$id));
            if($grouped->num_rows() > 0){ 
                return $grouped->result();
            }else{ return false; }
        }else{ return false; }
    }

// check dimension null for non digital stocked product
    function check_sndpd($ndpid)
    {
       $pdata=$this->db->get_where('product',array('product_id'=>$ndpid))->row();

if( $pdata->type =='single' && $pdata->shipping_status == '1' && $pdata->download !='ok' && $pdata->current_stock >0 )
    {
     if (($pdata->weight==0 || $pdata->weight=='' ) || ($pdata->length ==0|| $pdata->length=='') || ($pdata->width==0 || $pdata->width=='' ) || ($pdata->height==0 || $pdata->height=='' ) || ($pdata->request_quote=='ok') ) 
       {
        return 1; 
       }
     else
       {
        return 0;
       }
    }
    else if($pdata->request_quote=='ok')
    {
        return 1;
    }
  else
    {
     return 0;
    }
    
    }



function check_ltime()
    {
        date_default_timezone_set('Asia/Dubai');
        $now = new DateTime();
        $dtwo = new DateTime('2017-11-13 03:30:00');
        $diffSeconds = $dtwo->getTimestamp() - $now->getTimestamp() ;
        return $diffSeconds;
    }

function product_dimensionsclass($product_id,$dimension)
{
 $classid=$this->crud_model->get_type_name_by_id('product', $product_id, $dimension.'_class_id');
 $classs= $this->db->get_where('fed_'.$dimension.'_class_description',array($dimension.'_class_id'=>$classid))->row()->unit;   
 return $classs;
}

//region tax calculation for to cart
function region_tax($product_id,$region,$pprice)
{
  $regiontax=0;  
 $regiontaxid=$this->db->get_where('region_tax',array('product_id'=>$product_id,'country_id'=>$region))->row()->tax_amount;
 if($regiontaxid>0)
 {
    $regiontax= $pprice*($regiontaxid/100);
 }
 return $regiontax;
}

//Shipping Cost tax
function ship_tax($cost,$shipcntry)
{
  $regiontax=0;  
  $regiontaxid=$this->db->get_where('region_stax',array('country_id'=>$shipcntry))->row()->tax_amount;
  if($regiontaxid>0)
  {
    $regiontax= $cost*($regiontaxid/100);
  }
 return $regiontax;
}


//GET PRODUCT PRICE WITH UAE VAT TAX
function uae_product_price($product_id,$price)
{
 $uaetax=0;
 //$price   = $this->get_type_name_by_id('product', $product_id, 'sale_price');
 $uaetax  = $this->db->get_where('region_tax', array('product_id' => $product_id,'country_id' =>'221' ))->row()->tax_amount;
 if($uaetax>0)
 {
    $price+= $price*($uaetax/100);
 }
 return $price;
}

	//15-10-2019
	function getsortbrand($cat='')
    {
        $sort_brands=array();
        if($cat>0)
        {
            $sort_brands=$this->db->query("select distinct(b.brand_id),b.name from brand as b,product as p where p.category='".$cat."' and b.brand_id=p.brand and p.status='ok' and p.admin_approved='1' and p.vendor_approved='1' order by b.name")->result_array();
        }
        else
        {
            $sort_brands=$this->db->query("select distinct(b.brand_id),b.name from brand as b,product as p where b.brand_id=p.brand and p.status='ok' and p.admin_approved='1' and p.vendor_approved='1'  order by b.name")->result_array();
        }
        return $sort_brands;
    }

    function getrangemax($cat='')
    {
        $max_range=0;
        // if($cat>0)
        // {
        //     $max_range=$this->db->query("select COALESCE(max(sale_price),0) as max from product where category='".$cat."' and status='ok' and admin_approved='1' ")->row()->max;
        // }
        // else
        // {
        //     $max_range=$this->db->query("select COALESCE(max(sale_price),0) from product where  status='ok' and admin_approved='1'")->row()->max;
        // }
        
        $vendor = $this->db->join('countries as C','V.country_code = C.id')->get_where('vendor as V',['C.sortname'=>wh_country()->code])->row();
        if($vendor && $cat>0){
            $max_range=$this->db->query("select V.price from product as P join vendor_prices as V on P.product_id = V.prd_id where P.category='".$cat."' and P.status='ok' and P.admin_approved='1' and V.vendor_id = $vendor->vendor_id order by V.price desc limit 1")->row()->price;
        }else if($vendor){
            $max_range=$this->db->query("select V.price from product as P join vendor_prices as V on P.product_id = V.prd_id where  P.status='ok' and P.admin_approved='1' and V.vendor_id = $vendor->vendor_id order by V.price desc limit 1")->row()->price;
        }
        return $max_range;
    }
	
	function getLowStockProducts(){
		$query				=	$this->db->join('category as C','P.category = C.category_id')->where(['P.status'=>'ok'])->get('product as P')->result();
		$res				=	array();
		if($query){ foreach(	$query	as $row){ if($row->min_alert >= $row->current_stock ){ $res[]	=	$row; } } }
		return $res;
	}
	
    function getWherehouseProducts($vId){
        $products                   =   $this->db->select('*,V.status as vStatus,P.status as pStatus')->join('vendor_prices as V','P.product_id = V.prd_id')->where('V.vendor_id',$vId)
                                        ->order_by('P.update_time','desc')->get('product as P')->result();
        return $products;
    }
    
    function addPrdBrands($prdId, $brands){
        $this->db->where('product_id',$prdId)->delete('product_brands');
        if(count($brands) > 0){ foreach($brands as $brand){
            $this->db->insert('product_brands',['product_id'=>$prdId,'brand_id'=>$brand]);
        } }
    }
    
    
    function changeRegion($cCode='AE'){
        $country        =   $this->db->get_where('countries',['sortname'=>$cCode,'status'=>1])->row();
        if($country){ 
            $cntry      =   ['code'=>$country->sortname,'name'=>$country->name];
            $this->session->set_userdata('currency',$country->currency); 
            $this->session->set_userdata('country',(object)$cntry);
        }else{ 
            $cntry      =   ['code'=>'AE','name'=>'UAE'];
            $this->session->set_userdata('currency','AED'); 
            $this->session->set_userdata('country',(object)$cntry);
        }
        $this->db->where('user_id',$this->session->userdata('user_id'))->update('user',['shop_region'=>$this->session->userdata('country')->code]);
        $this->cart->destroy(); $this->clearCart('clear');  return $cCode;
        
    }

    function getIndusProducts($condition,$where=[]){
        if($condition->count    ==  'all_rec'){
            $res                =   $this->db->join('product as P','B.product_id = P.product_id')->get_where('product_brands as B',$where);
            $result['count']    =   $res->num_rows();
            $result['data']     =   $res->result_array();
        }else{
            $this->db->join('product as P','B.product_id = P.product_id');
            if(count($where)    >   0){ $this->db->where($where); }
            $res                =   $this->db->limit($condition->per_page,$condition->start)->get('product_brands as B');
            $result['count']    =   $res->num_rows();
            $result['data']     =   $res->result_array();
        }
        return $result;
    }
    
    function clearCart($type='sale'){
        $userId         =   $this->session->userdata('user_id');
        $cart           =   $this->db->get_where('cart',['user_id'=>$userId])->row();
        if($cart){
            $cartata    =   ['amount'=>0,'tax'=>0,'g_total'=>0,'modified_on'=>date('Y-m-d H:i:s'),'status'=>0];
            $this->db->where('user_id',$userId)->update('cart',$cartata);
            if($type    ==  'sale'){
                $items  =   $this->db->get_where('cart_items',['cart_id'=>$cart->cart_id])->result();
                if($items){ foreach($items as $row){
                    $this->db->where(['user_id'=>$userId,'prd_id'=>$row->product_id,'status'=>1])->delete('cart_added_items');
                    $this->db->where(['user_id'=>$userId,'prd_id'=>$row->product_id])->delete('cart_added_items_log');
                } }
            }else{
                $this->db->where(['user_id'=>$userId,'removed'=>0,'status'=>1])->update('cart_added_items',['removed_on'=>date('Y-m-d H:i:s'),'removed'=>1]);
                $this->db->where(['user_id'=>$userId,'status'=>1])->update('cart_added_items_log',['removed_on'=>date('Y-m-d H:i:s')]);
            }
            $this->db->where('cart_id',$cart->cart_id)->delete('cart_items');
        }
    }
    
    //shipping operators
    function shipping_operators($type='')
    {
            $shpping_operators=array(''=>'No shipping operator found in your region'); 
            $cc_code    = wh_country()->code;
            $ccqry=$this->db->get_where('countries', array('sortname'=>$cc_code))->row();
            if($ccqry)
            {
                $rcontry_id=$ccqry->id;
                $shi_oper = $this->db->select('SO.*')->join('shipping_zones as SZ','SO.id = SZ.operator_id')->where(array('SZ.country_id'=>$rcontry_id,'SZ.status'=>'1','SO.status'=>'1'))->get('shipping_operators as SO');
                if($shi_oper->num_rows()>0)
                { 
                    $shpping_operators=array(''=>'Select a shipping operator'); 
                    $shi_opers=$shi_oper->result();
                    foreach($shi_opers as $row)
                    { 
                        $shpping_operators[$row->id]  = $row->operator;
                    }
                }
            }
            return $shpping_operators;
    }
}













