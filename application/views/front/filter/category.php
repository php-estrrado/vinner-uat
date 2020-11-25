<?php $subCatArray  =   explode('-',$sub_cat);  ?>   
<div class="panel-body sky-form">
    <ul class="list-unstyled checkbox-list"><?php 
        if($allCat == 1){ ?>
            <li class="all-cat">
               <label class="radio state-success">
                    <input type="radio" name="checkbox" <?php if($cat == 0){ echo 'checked="checked"'; } ?> onclick="sub_clear(); setFilterId('category'); filterCat(<?php echo $cat?>,'','');"  class="check_category"
                            value="0" />
                    <i class="rounded-x" style="font-size:30px !important;"></i>
                    <?php echo translate('all_categories'); ?> 
                </label> 
            </li><?php  
        }
        if(isset($text)){ if($text !== ''){ $brandInputIds  =   $this->crud_model->getBrandIds($text); } }
        foreach($all_category as $row){ $catPrdCount = 0;  
            $this->db->where('category',$row['category_id'])->where('status','ok');
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
         //   if($cat >0){        $this->db->where('category', $cat); } 
            if($sub_cat >0){    $this->db->where('sub_category', $sub_cat); }
            if($brand >0){      $this->db->where('brand', $brand); }
            if($equipment >0){  $this->db->where('equipment', $equipment); }
            if($vendor > 0){    $this->db->where('added_by','{"type":"vendor","id":"'.$vendor.'"}'); }
            if($searchInput != ''){ 
           //  $query =    $this->db->like('title', $searchInput, 'both');
            //    $this->db->or_like('product_code', $searchInput, 'both');  
                if($brandInputIds){ $where1 = "( `title` LIKE '%$searchInput%'".$ptitle.$pcode.$ptype.$ptag.$pdesc.$pmodel." OR `brand` IN (".$brandInputIds."))"; }
                else{ 
                    $where1 = "( `title` LIKE '%$searchInput%'".$ptitle.$pcode.$ptype.$ptag.$pdesc.$pmodel.")"; 
                }
                $this->db->where($where1);
            }
            $catPrdCount    =   $this->db->get('product')->num_rows();
            if($catPrdCount > 0){
            ?>
                <li>
                   <label class="radio state-success">
                       <input type="radio" name="checkbox"id="check_category_<?php echo $row['category_id']?>"  class="check_category" <?php if($row['category_id'] == $cat){ echo 'checked="checked"'; } ?> onclick="sub_clear(); toggle_subs(<?php echo $row['category_id']; ?>); setFilterId('category'); filterCat(<?php echo $cat?>,'','');" value="<?php echo $row['category_id']; ?>" />
                        <i class="rounded-x" style="font-size:30px !important;"></i>
                        <?php echo $row['category_name']; ?> 
                        
                    </label> 
                </li><?php
            } ?>
            <li>
                <ul class="list-unstyled checkbox-list sub_cat" style="" id="subs_<?php echo $row['category_id']; ?>"><?php
//                    if($sub_cat>0 || $sub_cat!= ''){
//                        $this->db->where_in('sub_category_id',$subCatArray)->where('sub_category',$row['category_id'])->get('sub_category')->result_array();
//                    }else{
//                        $sub_category = $this->db->get_where('sub_category',array('category'=>$row['category_id']))->result_array();
//                    }
                    $sub_category = $this->db->get_where('sub_category',array('category'=>$row['category_id']))->result_array();
                    foreach($sub_category as $row1){ 
                        $this->db->where('sub_category',$row1['sub_category_id'])->where('status','ok');
                        $searchInput    =   $text;
                        if($cat >0){        $this->db->where('category', $cat); } 
                    //    if($sub_cat >0){    $this->db->where('sub_category', $sub_cat); }
                        if($brand >0){      $this->db->where('brand', $brand); }
                        if($equipment >0){  $this->db->where('equipment', $equipment); }
                        if($vendor > 0){    $this->db->where('added_by','{"type":"vendor","id":"'.$vendor.'"}'); }
                        if($searchInput != ''){ $this->db->like('title',$searchInput); }
                        $subCatPrdCount =   $this->db->get('product')->num_rows();
                        if($subCatPrdCount > 0){  ?>  
                            <li><?php if(in_array($row1['sub_category_id'], $subCatArray)){ $checked = 'checked="checked"'; }else{ echo $checked=''; } ?>
                                <label class="checkbox state-success">
                                    <input type="checkbox" name="check_<?php echo $row['category_id']; ?>" class="check_sub_category" <?php echo $checked ?> onclick="filter('click','none','none','0'); setFilterId('category');" value="<?php echo $row1['sub_category_id']; ?>" />
                                    <i class="square-x"></i>
                                    <?php echo $row1['sub_category_name']; ?> 
                                    
                                </label>
                            </li><?php 
                        } 
                } ?>
                </ul>
            </li><?php
        } ?>
    </ul>        
</div>

