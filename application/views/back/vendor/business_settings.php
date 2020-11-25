<div id="content-container"> 
    <div id="page-title">
        <h1 class="page-header text-overflow">
            <?php //echo translate('manage_payment_receiving_settings');?>
			<?php echo translate('manage_payment_bank_settings');?>
        </h1>
    </div>
    <div class="tab-base">
        <div class="tab-base tab-stacked-left">
            <?php
				$vendor_data=$this->db->get_where('vendor', array('vendor_id' => $this->session->userdata('vendor_id')
                ))->row();
                $paypal    = $vendor_data->paypal_email;
                $paypal_set= $vendor_data->paypal_set;
                $cash_set  = $vendor_data->cash_set;
                $stripe_set = $vendor_data->stripe_set;
                $stripe_details = json_decode($vendor_data->stripe_details,true);
                $stripe_publishable = $stripe_details['publishable'];
                $stripe_secret =  $stripe_details['secret'];
            ?>
            <div class="col-sm-12">
              <?php /*   
                <div class="panel panel-bordered-dark">
                    <?php
                        echo form_open(base_url() . 'index.php/vendor/business_settings/set/', array(
                            'class'     => 'form-horizontal',
                            'method'    => 'post',
                            'id'        => 'gen_set',
                            'enctype'   => 'multipart/form-data'
                        ));
                    ?>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="demo-hor-inputemail"><?php echo translate('cash_payment');?></label>
                                <div class="col-sm-6">
                                    <div class="col-sm-">
                                        <input id="cash_set" class='sw7' data-set='cash_set' type="checkbox" <?php if($cash_set == 'ok'){ ?>checked<?php } ?> />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="demo-hor-inputemail"><?php echo translate('paypal_payment');?></label>
                                <div class="col-sm-6">
                                    <div class="col-sm-">
                                        <input id="paypal_set" class='sw8' data-set='paypal_set' type="checkbox" <?php if($paypal_set == 'ok'){ ?>checked<?php } ?> />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo translate('paypal_email');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="paypal_email" value="<?php echo $paypal; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="demo-hor-inputemail"><?php echo translate('stripe_payment');?></label>
                                <div class="col-sm-6">
                                    <div class="col-sm-">
                                        <input id="stripe_set" class='sw7' data-set='stripe_set' type="checkbox" <?php if($stripe_set == 'ok'){ ?>checked<?php } ?> />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo translate('stripe_secret_key');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="stripe_secret" value="<?php echo $stripe_secret; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo translate('stripe_publishable_key');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="stripe_publishable" value="<?php echo $stripe_publishable; ?>" class="form-control">
                                </div>
                            </div>
                        
                            <div class="panel-footer text-right">
                                <span class="btn btn-info submitter" 
                                    data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>' >
                                        <?php echo translate('save');?>
                                </span>
                            </div>
                        </div>
                    <?php
                        echo form_close();
                    ?>
                </div>
                */
               ?>
                <div class="panel panel-bordered-dark">
                    <?php
                        echo form_open(base_url() . 'vendor/business_settings/set_bank/', array(
                            'class'     => 'form-horizontal',
                            'method'    => 'post',
                            'id'        => 'gen_set',
                            'enctype'   => 'multipart/form-data'
                        ));
                    ?>
                        <div class="panel-body">

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="bank_name">
                                    <?php echo translate('bank_name');?></label>
                                <div class="col-sm-6">
                                    <div class="col-sm-">
                                        <input id="bank_name" class='form-control required' type="text" name="bank_name"
											   value="<?php echo trim($vendor_data->bank_name); ?>"/>
                                    </div>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="col-sm-3 control-label" for="swift_code">
                                    <?php echo translate('SWIFT_Code');?></label>
                                <div class="col-sm-6">
                                    <div class="col-sm-">
                                        <input id="swift_code" class='form-control required' type="text" name="swift_code"
											   value="<?php echo trim($vendor_data->swift_code); ?>"/>
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <label class="col-sm-3 control-label" for="account_number">
                                    <?php echo translate('account_number');?></label>
                                <div class="col-sm-6">
                                    <div class="col-sm-">
                                        <input id="account_number" class='form-control required' type="text"
										name="account_number" value="<?php echo trim($vendor_data->account_number); ?>"/>
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <label class="col-sm-3 control-label" for="name_account">
                                    <?php echo translate('name on_account');?></label>
                                <div class="col-sm-6">
                                    <div class="col-sm-">
                                        <input id="name_account" class='form-control required' type="text"
										name="name_account" value="<?php echo trim($vendor_data->name_account); ?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="bank_info">
                                    <?php echo translate('other_information');?>
                                </label>
                                <div class="col-sm-6">
                                    <div class="col-sm-">
                                        <textarea name="bank_info" class="form-control" id="bank_info"><?php echo trim($vendor_data->bank_info); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer text-right">
                                <span class="btn btn-info submitter" 
                                    data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('info_updated!'); ?>' >
                                        <?php echo translate('save');?>
                                </span>
                            </div>
                        </div>
                    <?php
                        echo form_close();
                    ?>
                </div>

            </div>
        </div>

    </div>
</div>
<div style="display:none;" id="business"></div>

<script>
	var base_url = '<?php echo base_url(); ?>';
	var user_type = 'vendor';
	var module = 'logo_settings';
	var list_cont_func = 'show_all';
	var dlt_cont_func = 'delete_logo';

    function get_membership_info(id)
    {
        $('#mem_info').load('<?php echo base_url(); ?>index.php/vendor/business_settings/membership_info/'+id);
    }

</script>
<script src="<?php echo base_url(); ?>template/back/js/custom/business.js"></script>
