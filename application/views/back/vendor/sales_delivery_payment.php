<div>	<?php 
    echo form_open(base_url() . 'index.php/vendor/sales/delivery_payment_set/' . $sale_id, array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'delivery_payment',
            'enctype' => 'multipart/form-data'
            ));
        $deliStatus = $pmtStatus = '';
        if($status_type == 'p'){ $pmtStatus = ''; $deliStatus = 'style="display: none;"'; }
        else if($status_type == 'd'){ $deliStatus = ''; $pmtStatus = 'style="display: none;"'; }
				?>
        <div class="panel-body">

            <div class="form-group" <?php echo $deliStatus?>>
                <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('delivery_status'); ?></label>
                <div class="col-sm-6">
                	<?php 
                    	$from = array('pending','on_delivery','delivered');
						echo $this->crud_model->select_html($from,'delivery_status','','edit','demo-chosen-select',$delivery_status);
					?>
                </div>
            </div>
            <div class="form-group" <?php echo $pmtStatus?>>
                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('payment_status'); ?></label>
                        <div class="col-sm-6"><?php 
                            $options['due']    =   'Pending'; $options['processing'] = 'Processing'; $options['paid'] = 'Paid';
                             echo form_dropdown('payment_status', $options, $payment_status, ['class' => 'demo-chosen-select', 'id' => 'payment_status']); ?>
                        </div>
                </div>
            <div class="form-group" <?php echo $pmtStatus?>>
                <label class="col-sm-4 control-label" for="demo-hor-3"><?php echo translate('payment_details'); ?></label>
                <div class="col-sm-6">
                    <textarea name="payment_details" class="form-control" <?php if($payment_type == 'paypal' || $payment_type == 'payfort'){ ?>readonly<?php } ?> rows="10"><?php echo $payment_details; ?></textarea>
                </div>
            </div>
        </div>
    	<?php
    echo form_close();
    ?>
</div>
<script type="text/javascript">

    $(document).ready(function() {
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
    });

	
	$(document).ready(function() {
		$("form").submit(function(e){
			return false;
		});
	});
</script>
<div id="reserve"></div>

