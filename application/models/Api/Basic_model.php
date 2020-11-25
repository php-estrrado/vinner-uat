<?php

class Basic_model extends CI_Model 
{

    function __construct()  
    { 
    	parent::__construct();
    	$this->load->helper('string');
    }
      //access_token
    public function uservalid($utoken)
    {
      if(!$utoken)
      {
        return false;
      }
      else
      {
        if($this->db->get_where('user', array('access_token' => $utoken,'status'=>'approved','is_login'=>1))->num_rows()=='1')
        {
          return true;
        }
        else
        {
          return false;
        }
      }  
    }  
    
    //get user Id
    public function get_value($table,$field,$where,$value)
    {
        $result = $this->db->query("select * from $table where $where = '$value'");
        if($result->num_rows()==1)
        {
          return $result->row()->$field;
        }
        else
        {
            return '';
        }
     }  

    public function check_existuser($table,$field,$value)
    {
        $this->db->where('status','approved');
        $this->db->where($field,$value);
        $result = $this->db->get($table);
        if($result->num_rows()>0)
        {
          return true;
        }
        else
        {
          return false;
        }
    }
    
    // FILE_VIEW

    function file_view($type, $id, $width = '100', $height = '100', $thumb = 'no', $src = 'no', $multi = '', $multi_num = '', $ext = '.jpg')
    {
        if ($multi == '') 
        {
            if (file_exists('uploads/' . $type . '_image/' . $type . '_' . $id . $ext)) 
            {
                if ($thumb == 'no') 
                {
                    $srcl = base_url() . 'uploads/' . $type . '_image/' . $type . '_' . $id . $ext;
                } 
                elseif ($thumb == 'thumb') 
                {
                    $srcl = base_url() . 'uploads/' . $type . '_image/' . $type . '_' . $id . '_thumb' . $ext;
                }
                if ($src == 'no') 
                {
                    return '<img src="' . $srcl . '" height="' . $height . '" width="' . $width . '" />';
                } 
                elseif ($src == 'src') 
                {
                    return $srcl;
                }
            }
        } 
        else if ($multi == 'multi') 
        {
            $num    = $this->crud_model->get_type_name_by_id($type, $id, 'num_of_imgs');

            //$num = 2;

            $i      = 0;

            $p      = 0;

            $q      = 0;

            $return = array();
            while ($p < $num) 
            {
                $i++;
                if (file_exists('uploads/' . $type . '_image/' . $type . '_' . $id . '_' . $i . $ext)) 
                {
                    if ($thumb == 'no') 
                    {
                        $srcl = base_url() . 'uploads/' . $type . '_image/' . $type . '_' . $id . '_' . $i . $ext;
                    } 
                    elseif ($thumb == 'thumb') 
                    {
                        $srcl = base_url() . 'uploads/' . $type . '_image/' . $type . '_' . $id . '_' . $i . '_thumb' . $ext;
                    }                   
                    if ($src == 'no') 
                    {
                        $return[] = '<img src="' . $srcl . '" height="' . $height . '" width="' . $width . '" />';
                    } 
                    elseif ($src == 'src') 
                    {
                        $return[] = $srcl;
                    }
                    $p++;
                } 
                else 
                {
                    $q++;
                    if ($q == 10) {
                        break;
                    }
                }
            }

            if (!empty($return))
            {
                if ($multi_num == 'one') 
                {
                    return $return[0];
                } 
                else if ($multi_num == 'all') 
                {
                    return $return;
                } 
                else 
                {
                    $n = $multi_num - 1;
                    unset($return[$n]);
                    return $return;
                }
            } 
            else
            {
                return false;
            }
        }
    }

}
?>