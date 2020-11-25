<div class="panel-body sky-form" style="max-height: 275px;overflow-y: scroll;">
    <?php // echo 'ssss<pre>'; print_r($brand); echo '</pre>'; ?>
    <ul class="list-unstyled checkbox-list">
        <li>
           <label class="radio state-success">
               <input type="radio" name="vendor3"  class="check_vendor3" <?php if($brand == 0){ echo 'checked="checked"'; } ?> value="0" onclick="setFilterId('brand'); filterCat(<?php echo $cat?>,'','');" />
                <i class="rounded-x" style="font-size:30px !important;"></i>
                <?php echo translate('all_brands'); ?> 
            </label> 
        </li><?php
        if($brand > 0){ $this->db->where('brand_id',$brand); }
        $this->db->order_by("name", "asc");
        $brandss = $this->db->get('brand')->result_array();
        if(isset($text)){ if($text !== ''){ $brandInputIds  =   $this->crud_model->getBrandIds($text); } }
        foreach($brandss as $row1){
            $this->db->where('brand',$row1['brand_id'])->where('status','ok');
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
         //   if($brand >0){      $this->db->where('brand', $brand); }
            if($sub_cat >0){    $this->db->where('sub_category', $sub_cat); }
            if($equipment >0){  $this->db->where('equipment', $equipment); }
            if($vendor > 0){    $this->db->where('added_by','{"type":"vendor","id":"'.$vendor.'"}'); }
            if($searchInput != ''){ 
              //  $this->db->like('title', $searchInput, 'both');
           //     $this->db->or_like('product_code', $searchInput, 'both');  
            //    $where1 = "( `title` LIKE '%$searchInput%' OR `product_code` LIKE '%$searchInput%' OR `item_type` LIKE '%$searchInput%' OR `item_type` LIKE '%$text%' OR `tag` LIKE '%$text%')";
                if($brandInputIds){ $where1 = "( `title` LIKE '%$searchInput%'".$ptitle.$pcode.$ptype.$ptag.$pdesc.$pmodel." OR `brand` IN (".$brandInputIds."))"; }
                else{ 
                    $where1 = "( `title` LIKE '%$searchInput%'".$ptitle.$pcode.$ptype.$ptag.$pdesc.$pmodel.")"; 
                }
                $this->db->where($where1);
            }
            $brandCount =   $this->db->get('product')->num_rows();
            if($brandCount>0){ ?>
                <li>
                    <label class="radio state-success"> 
                        <input type="radio" name="vendor3"  class="check_vendor3"<?php if($row1['brand_id'] == $brand){ echo 'checked="checked"'; } ?> value="<?php echo $row1['brand_id']; ?>" onclick="setFilterId('brand'); filterCat(<?php echo $cat?>,'','');" />
                        <i class="rounded-x" style="font-size:30px !important;"></i>
                        <?php echo $row1['name']; ?> 
                    </label> 
                </li><?php
            }
        } ?>
    </ul>        
</div>
        