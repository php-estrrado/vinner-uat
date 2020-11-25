<div id="content-container"> 
    <div id="page-title">
        <h1 class="page-header text-overflow"><?php echo translate('manage_inventory_settings');?></h1>
    </div>
    <div class="tab-base">
        <div class="tab-base tab-stacked-left">
            <?php
            
 $low_stock_status= $this->db->get_where('inventory', array('type' => 'low_stock_status'))->row()->value;
 $out_stock_status= $this->db->get_where('inventory', array('type' => 'out_stock_status'))->row()->value;
 $low_stock_threshold= $this->db->get_where('inventory', array('type' => 'low_stock_threshold'))->row()->value;
 $out_stock_threshold= $this->db->get_where('inventory', array('type' => 'out_stock_threshold'))->row()->value;
 $out_stock_visibility= $this->db->get_where('inventory', array('type' => 'out_stock_visibility'))->row()->value;
    
           ?>
            <div class="col-sm-12">
            <div class="panel panel-bordered-dark">
                <?php
                    echo form_open(base_url() . 'index.php/admin/inventory/set/', array(
                        'class'     => 'form-horizontal',
                        'method'    => 'post',
                        'id'        => 'gen_set',
                        'enctype'   => 'multipart/form-data'
                    ));
                ?>
                    <div class="panel-body">
                    <div class="form-group">
                            <label class="col-sm-3 control-label" for="demo-hor-inputemail"><?php echo translate('Enable low stock notifications');?></label>
                            <div class="col-sm-6">
                                <div class="col-sm-">
                                    <input id="low_stock_status"  name="low_stock_status" data-set='low_stock_status' type="checkbox" <?php if($low_stock_status == 'on'){ ?>checked<?php } ?> />
                                </div>
                            </div>
                           
                        </div>
                    
                        
                         <div class="form-group">
                            <label class="col-sm-3 control-label" for="demo-hor-inputemail"><?php echo translate('Enable out of stock notifications');?></label>
                            <div class="col-sm-6">
                                <div class="col-sm-">
                                    <input id="out_stock_status" name="out_stock_status" data-set='out_stock_status' type="checkbox" <?php if($out_stock_status == 'on'){ ?>checked<?php } ?> />
                                </div>
                            </div>
                           
                        </div>
                        
                        
                       <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo translate('low_stock_threshold');?></label>
                            <div class="col-sm-6">
                                <input type="text" name="low_stock_threshold" value="<?php echo $low_stock_threshold; ?>" class="">
                            </div>
                        </div>
                       
                       
                       <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo translate('out of stock_threshold');?></label>
                            <div class="col-sm-6">
                                <input type="text" name="out_stock_threshold" value="<?php echo $out_stock_threshold; ?>" class="">
                            </div>
                        </div>
                        
                        
                       <div class="form-group">
                            <label class="col-sm-3 control-label" for="demo-hor-inputemail"><?php echo translate('Out of stock visibility');?></label>
                            <div class="col-sm-6">
                                <div class="col-sm-">
                                    <input id="out_stock_visibility" name="out_stock_visibility" data-set='out_stock_visibility' type="checkbox" <?php if($out_stock_visibility == 'on'){ ?>checked<?php } ?> />
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    
                    <div class="panel-footer text-right">
<!--
                    <button type="submit" value="Save" data-msg='<?php echo translate('settings_updated!'); ?>'>Save</button>
-->
                        <span class="btn btn-info submitter" 
                        	data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>' >
								<?php echo translate('save');?>
                        </span>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
<!--<div style="display:none;" id="business"></div>-->
<script>
	var base_url = '<?php echo base_url(); ?>';
	var user_type = 'admin';
	var module = 'logo_settings';
	var list_cont_func = 'add';
	var dlt_cont_func = 'delete_logo';

    $("#more_btn").click(function(){
        $("#more_additional_fields").append(''
            +'<div class="form-group">'
            +'    <div class="col-sm-4">'
            +'        <input type="text" name="f_q[]" class="form-control"  placeholder="<?php echo translate('question'); ?>">'
            +'    </div>'
            +'    <div class="col-sm-5">'
            +'          <textarea name="f_a[]" class="form-control"  placeholder="<?php echo translate('answer'); ?>"></textarea>'
            +'    </div>'
            +'    <div class="col-sm-2">'
            +'        <span class="remove_it_v rms btn btn-danger btn-icon btn-circle icon-lg fa fa-times" onclick="delete_row(this)"></span>'
            +'    </div>'
            +'</div>'
        );
    });
    function delete_row(e)
    {
        e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
    }   

</script>
<!--<script src="<?php /*echo base_url();*/ ?>template/back/js/custom/business.js"></script>-->
