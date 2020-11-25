<div id="content-container">
	<div id="page-title">
		<h1 class="page-header text-overflow" ><?php echo translate('quote/service_recepients')?></h1>
	</div>
	<div class="tab-base">
		<!--Tabs Content-->
		<div class="panel">
		<!--Panel heading-->
			<div class="panel-body">
				<div class="tab-content">
					<div class="tab-pane fade active in" id="lista">
						<div class="panel-body" id="demo_s">
							<?php
                                echo form_open(base_url() . 'index.php/admin/quote_recepients/send/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post'
                                ));
                            ?>
		                        <div class="row">
			                        <?php
				                        $user_list = array();
				                        $subscribers_list = array();
				                        foreach ($users as $row) {
				                        	$user_list[] = $row['quote_email'];
				                        }
				                        foreach ($subscribers as $row) {
				                        	$subscribers_list[] = $row['request_email'];
				                        }
			                        	$user_list = join(',',$user_list);
			                        	$subscribers_list = join(',',$subscribers_list);
			                        ?>
	                            	<h3 class="panel-title"><?php echo translate('e-mails_(Quote_request_receivers)')?></h3>
					                <div class="form-group btm_border">
					                    <div class="col-sm-12">
					                        <input type="text" name="quote_receiver" data-role="tagsinput" 
					                        	placeholder="<?php echo translate('e-mails_(Quote_request_receivers)')?>" class="form-control"
					                        		value="<?php echo $user_list; ?>">
					                    </div>
					                </div>
	                            	<h3 class="panel-title"><?php echo translate('e-mails_(Service_request_receivers)')?></h3>
					                <div class="form-group btm_border">
					                    <div class="col-sm-12">
					                        <input type="text" name="service_receiver" data-role="tagsinput" 
					                        	placeholder="<?php echo translate('e-mails_(Service_request_receivers)')?>" class="form-control required"
					                        		value="<?php echo $subscribers_list; ?>">
					                    </div>
					                </div>
					               
	                            		
	                            	                 </div>
	                            <div class="panel-footer text-right">
	                                <span class="btn btn-info submitter"  data-ing='<?php echo translate('updateing'); ?>' data-msg='<?php echo translate('updated!'); ?>'>
										<?php echo translate('update')?>
                                        	</span>
	                            </div>
	                        </form>
	                    </div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script>
	$(document).ready(function() {
			var now = $(this);
			var h = now.data('height');
			var n = now.data('name');
			now.closest('div').append('<input type="hidden" class="val" name="' + n + '">');
			now.summernote({
				height: h,
				onChange: function() {
					now.closest('div').find('.val').val(now.code());
				}
			});
			now.closest('div').find('.val').val(now.code());
		});
	});
	
	var base_url = '<?php echo base_url(); ?>';
	var user_type = 'admin';
	var module = 'newsletter';
	var list_cont_func = 'list';
	var dlt_cont_func = 'delete';
</script>