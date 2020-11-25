    <?php
        // print_r($members_array);
        foreach($coupon_data as $row)
        {

            ?>

            <div>
                <?php
                    echo form_open(base_url() . 'index.php/admin/abandon_group/update/' . $row['coupon_id'], array(
                        'class' => 'form-horizontal','method' => 'post','id' => 'abandon_group_edit','enctype' => 'multipart/form-data'
                        ));
                        ?>
                            
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="grp_title"><?php echo translate('abandon_group_title');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="title" id="grp_title" value="<?php echo $row['title']; ?>"  placeholder="<?php echo translate('title'); ?>" class="form-control required">
                                </div>
                            </div>
                            <?php
                                $spec = json_decode($row['spec'],true);
                                $spr_id=str_replace("[",'',$spec['set']);$spr_id=str_replace('"','',$spr_id);$spr_id=str_replace("]",'',$spr_id); 
                                
                                $grprduct=$this->crud_model->get_type_name_by_id('product',$spr_id,'title');
                            ?>               
                            <input type="text" name="cupn_product"  value="<?php echo ucfirst($spr_id); ?>" hidden/>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="grp_product"><?php echo translate('abandon_group_product');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="grp_product" id="grp_product" value="<?php echo ucfirst($grprduct); ?>" class="form-control" disabled>
                                </div>
                            </div>  

                            <div class="form-group">
                                <label class="col-sm-4 control-label " for="from_cart"><?php echo translate('cart_date_range');?></label>
                                <div class="col-sm-3 ">
                                    <input type="text" name="grpfrom_cart"  value="<?php echo $crt_from; ?>" hidden/>
                                    <input type="text" name="from_cart" id="from_cart" value="<?php echo date('d-m-Y',strtotime($crt_from)); ?>" value="" class="form-control " placeholder="From date" disabled>
                                </div>
                                <div class="col-sm-3 ">
                                    <input type="text" name="grpto_cart"  value="<?php echo $crt_to; ?>" hidden/>
                                    <input type="text" name="to_cart" id="to_cart"  value="<?php echo date('d-m-Y',strtotime($crt_to));  ?>" value="" class="form-control " placeholder="To date" disabled>
                                </div>
                            </div>              
                                            
                            <div class="form-group product">
                                <label class="col-sm-4 control-label"><?php echo translate('group_members');?></label>
                                <div class="col-sm-6" >
                                    <?php 
                                        $cartcustomers=array();
                                        $crt_custmr= $this->db->query("SELECT DISTINCT user_id FROM cart_added_items where prd_id='$spr_id' and (date(added_on)>='$crt_from' and date(added_on)<='$crt_to')")->result_array();
                                        $arr = array_map (function($value){
                                            return $value['user_id'];
                                        } , $crt_custmr);
                                        
                                        if(count($arr)>0)
                                        {
                                            $this->db->select('user_id,username,mobile')->where(array('status'=>'approved'))->where_in('user_id', $arr);
                                            $productids=$this->db->order_by('username')->get('user')->result();
                                            foreach($productids as $prrow)
                                            {
                                                $cartcustomers[$prrow->user_id]=ucfirst($prrow->username).'('.$prrow->mobile.')';
                                            }
                                        }
                                        echo form_dropdown('group_customer[]', $cartcustomers,$members_array,'class="demo-cs-multiselect required" required multiple data-placeholder="Select Customer" ');  
                                    
                                        //echo $this->crud_model->select_html( $cartcustomers,'group_customer','','edit','demo-cs-multiselect required',$members_array); 
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="grpccode"><?php echo translate('coupon_code');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="code" id="grpccode"  value="<?php echo $row['code']; ?>" placeholder="<?php echo translate('code'); ?>" class="form-control required">
                                </div>
                            </div>
                                            
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo translate('discount_type');?></label>
                                <div class="col-sm-6">
                                   <?php
                                        $array = array('percent','amount');
                                        echo $this->crud_model->select_html($array,'discount_type','','edit','demo-chosen-select required',$spec['discount_type']); 
                                    ?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="discount_value"><?php echo translate('discount_value');?></label>
                                <div class="col-sm-6">
                                    <input type="number" name="discount_value" id="discount_value"  value="<?php echo $spec['discount_value']; ?>"
                                         placeholder="<?php echo translate('discount_value'); ?>" class="form-control required">
                                </div>
                            </div>
                                            
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="till"><?php echo translate('valid_till');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="till" id="till" value="<?php echo $row['till']; ?>" class="form-control">
                                </div>
                            </div>
                                            
                        </div>
                            
                        <?php 
                    echo form_close();
                ?>
            </div>
            <?php

	    }

    ?>



<script src="<?php echo base_url(); ?>template/back/js/custom/brand_form.js"></script>
<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">
    
$('#till').datepicker({
dayOfWeekStart : 1,
lang:'en',
timepicker:false,
format:'yyyy-mm-dd',
startDate:  '2017/01/05'
});
$("#edgroup_customer").chosen();
</script>




