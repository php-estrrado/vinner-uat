<div>
	<?php
        echo form_open(base_url() . 'index.php/admin/sales/update_payment_set/' . $sale_id, array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'delivery_payment',
            'enctype' => 'multipart/form-data'
        ));
    ?>
        <div class="panel-body">
			
            <!--    <div class="form-group">-->
            <!--        <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('payment_status'); ?></label>-->
            <!--            <div class="col-sm-6"> -->
            <?php
                            //foreach (json_decode($payment_status) as $pay_status){ $payStatus = $pay_status->status; $payVendor =  $pay_status->vendor; }
                           // $options['due']    =   'Pending'; $options['processing'] = 'Processing'; $options['paid'] = 'Paid';
                            // echo form_dropdown('payment_status', $options, $payStatus, ['class' => 'demo-chosen-select', 'id' => 'payment_status']); 
                            ?>
            <!--            </div>-->
            <!--    </div>-->
            <!--<input type="hidden" name="vendorId" value="<?php echo $payVendor?>" />-->
            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('delivery_status'); ?></label>
                <div class="col-sm-6">
                	<?php 
                    	$from = array('pending','on_delivery','delivered');
						echo $this->crud_model->select_html($from,'delivery_status','','edit','demo-chosen-select',$delivery_status);
					?>
                </div>
            </div>
            
            <!--<div class="form-group">-->
            <!--    <label class="col-sm-4 control-label" for="demo-hor-3"><?php echo translate('payment_details'); ?></label>-->
            <!--    <div class="col-sm-6">-->
            <!--        <textarea name="payment_details" class="form-control" <?php if($payment_type == 'paypal' || $payment_type == 'stripe'){ ?>readonly<?php } ?> rows="10"><?php echo $payment_details; ?></textarea>-->
            <!--    </div>-->
            <!--</div>-->

        </div>
    </form>
</div>
<script type="text/javascript">

    $(document).ready(function() {
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
        total();
    });

    function total(){
        var total = Number($('#quantity').val())*Number($('#rate').val());
        $('#total').val(total);
    }

    $(".totals").change(function(){
        total();
    });
	
	$(document).ready(function() {
		$("form").submit(function(e){
			return false;
		});
	});
</script>
<div id="reserve"></div>
