<?php

    foreach($group_data as $row){

?>
<div>
    <?php
        echo form_open(base_url() . 'index.php/admin/customer_group/update/'. $row['group_id'], array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'custgroup_edit',
            'enctype' => 'multipart/form-data'
        ));
    ?>



        <div class="panel-body">

            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('customer_group_title');?></label>
                <div class="col-sm-6">
                    <input type="text" name="title" id="demo-hor-1" 
                        placeholder="<?php echo translate('title'); ?>" class="form-control required" value="<?php echo $row['title']; ?>">
                </div>
            </div>

            
                <?php

                     $cu_list = json_decode($row['customer_list'],true);

                    echo($cu_list['cid'])  ;
                ?> 

            <div class="form-group product" style=";">
                <label class="col-sm-4 control-label"><?php echo translate('add_customer');?></label>
                <div class="col-sm-6">
                    <?php 
                        
                            $by = json_decode($row['customer_list'],true);
                            
                            //echo $by['cid'];
                           
                               $row3="[\"";
                           foreach ($by as $row2) 
                            {

                            $row3=$row3.$row2['cid']."\",\"";

                            }   

                          $row3=$row3."\"]";
                          
                          echo $this->crud_model->select_html('user','user','username','edit','demo-cs-multiselect',$row3);
                                          
                    ?>
                        
                </div>
            </div>

   
            
 <div class="form-group">

                    <label class="col-sm-4 control-label"><?php echo translate('discount_type');?></label>

                    <div class="col-sm-6">

                        <?php

                            $array = array('percent','amount');

                            echo $this->crud_model->select_html($array,'discount_type','','edit','demo-chosen-select required',$row['discount_type']); 

                        ?>

                    </div>

                </div>



                <div class="form-group">

                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('discount_value');?></label>

                    <div class="col-sm-6">

                        <input type="number" name="discount_value" id="demo-hor-1"  value="<?php echo $row['discount']; ?>"

                            placeholder="<?php echo translate('discount_value'); ?>" class="form-control required">

                    </div>

                </div>

            </div>

         <div class="panel-footer">
                <div class="row">
                    <div class="col-md-11">
                        <span class="btn btn-purple btn-labeled fa fa-refresh pro_list_btn pull-right" 
                            onclick="ajax_set_full('edit','<?php echo translate('edit_customer_group'); ?>','<?php echo translate('successfully_edited!'); ?>','cust_group_edit','<?php echo $row['group_id']; ?>') "><?php echo translate('reset');?>
                        </span>
                    </div>
                    
                    <div class="col-md-1">
                        <span class="btn btn-success btn-md btn-labeled fa fa-upload pull-right" onclick="form_submit('custgroup_edit','<?php echo translate('group_has_been_uploaded!'); ?>');proceed('to_add');" ><?php echo translate('update');?></span>
                    </div>
                </div>
            </div>
    
    </form>
</div>


<?php
}
?>

<script src="<?php echo base_url(); ?>template/back/js/custom/brand_form.js"></script>


<!-- <script type="text/javascript">
    $('.chos').on('change',function(){
        var a = $(this).val();
        $('.product').hide('slow');
        $('.category').hide('slow');
        $('.sub_category').hide('slow');
        $('.'+a).show('slow');
    });
</script>
 -->