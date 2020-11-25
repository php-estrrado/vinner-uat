
        <div class="panel-body sky-form">
            <ul class="list-unstyled checkbox-list">
                <li>
                    <label class="radio state-success">
                        <input type="radio" name="vendor" <?php if($vendor == 0){ echo 'checked="checked"'; } ?> class="check_vendor" value="0" onclick="setFilterId('vendor'); filterCat(<?php echo $cat?>,'','');" />
                        <i class="rounded-x" style="font-size:30px !important;"></i>
                        <?php echo translate('all_vendors'); ?> 
                    </label> 
                </li><?php
                if($vendor > 0){ $this->db->where('vendor_id',$vendor); }
                $vendors = $this->db->get_where('vendor',array('status'=>'approved'))->result_array();
                if(isset($text)){ if($text !== ''){ $brandInputIds  =   $this->crud_model->getBrandIds($text); } }
                foreach($vendors as $row){
                    $this->db->where('added_by','{"type":"vendor","id":"'.$row['vendor_id'].'"}');
                    $this->db->where('status','ok');
                    $text               =   str_replace(","," ",$text);
                    $text               =   str_replace("'","",$text);
                    $text               =   str_replace('"','',$text);
                    $searchInput        =   $text;
                    $textInput          =   explode(' ',$text);
                    if(count($textInput)>1){ 
                        foreach ($textInput as $txtIn){
                            $ptitle     =   $ptitle." OR `title` LIKE '%$txtIn%' ";
                            $pcode      =   $pcode." OR `product_code` LIKE '%$txtIn%' ";
                            $ptype      =   $ptype." OR `item_type` LIKE '%$txtIn%' ";
                            $ptag       =   $ptag." OR `tag` LIKE '%$txtIn%' ";
                            $pdesc      =   $pdesc." OR `description` LIKE '%$txtIn%' ";
                            $pmodel     =   $pmodel." OR `model` LIKE '%$txtIn%' ";
                        }
                    }else{ 
                        $ptitle         =   ""; 
                        $pcode          =   " OR `product_code` LIKE '%$text%' ";
                        $ptype          =   " OR `item_type` LIKE '%$text%' ";
                        $ptag           =   " OR `tag` LIKE '%$text%' ";
                        $pdesc          =   " OR `description` LIKE '%$text%' ";
                        $pmodel         =   " OR `model` LIKE '%$text%' ";
                    }
                    if($cat >0){        $this->db->where('category', $cat); }
                    if($sub_cat >0){    $this->db->where('sub_category', $sub_cat); }
                    if($brand >0){      $this->db->where('brand', $brand); }
                    if($equipment >0){  $this->db->where('equipment', $equipment); }
                    if($searchInput != ''){ 
                    //    $this->db->like('title',$searchInput); 
                        if($brandInputIds){ $where1 = "( `title` LIKE '%$searchInput%'".$ptitle.$pcode.$ptype.$ptag.$pdesc.$pmodel." OR `brand` IN (".$brandInputIds."))"; }
                        else{ 
                            $where1 = "( `title` LIKE '%$searchInput%'".$ptitle.$pcode.$ptype.$ptag.$pdesc.$pmodel.")"; 
                        }
                        $this->db->where($where1);
                    }
                    $vendorCount    =   $this->db->get('product')->num_rows();
                  //  $bg=$this->db->get_where('product',array('added_by'=>'{"type":"vendor","id":"'.$row['vendor_id'].'"}','status'=>'ok'))->num_rows();
                    if($vendorCount>0)
                    {
                    ?>
                    <li>
                        <label class="radio state-success">
                            <input type="radio" name="vendor"  class="check_vendor" <?php if($row['vendor_id'] == $vendor){ echo 'checked="checked"'; } ?> value="<?php echo $row['vendor_id']; ?>" onclick="setFilterId('vendor'); filterCat(<?php echo $cat?>,'','');" />
                            <i class="rounded-x" style="font-size:30px !important;"></i>
                            <?php echo $row['display_name']; ?> 
                           
                        </label> 
                    </li><?php
                }
                }?>
            </ul>        
        </div>
