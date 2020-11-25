<div id="content-container">
	<div id="page-title">
		<h1 class="page-header text-overflow"><?php echo translate('manage_email_templates');?></h1>
	</div>
	<div class="tab-base">
		<div class="panel">
			<div class="panel-body">
				<div class="tab-content">
					<h3><?php echo translate('edit_email_template');?></h3>
					<div class="tab-pane fade active in"  style="border:1px solid #ebebeb; border-radius:4px;">
						<div class="panel-body" id="demo_s">
							<?php
								//print_r($email_data);
							?>
							<?php
								echo form_open(base_url() .'admin/emailtemplate/process/'.$id, array(
									'class' => 'form-horizontal',
									'method' => 'post',
									'id' => 'email_process',
									'enctype' => 'multipart/form-data',
									'onSubmit'=>'return emform()'
									));
									
									?>
										<div class="form-group ">
											<label class="col-sm-2 control-label" for="title">
												<?php echo "Email Title";?>
											</label>
											<div class="col-sm-10">
												<input type="text" name="title" required placeholder="<?php echo "title";?>" class="form-control" value="<?php echo $email_data->title; ?>">
											</div>
                            			</div>
										<div class="form-group ">
											<label class="col-sm-2 control-label" for="identifier">
												<?php echo "Email Identifier";?>
											</label>
											<div class="col-sm-10">
												<input disabled type="text" required name="identifier"  placeholder="<?php echo "title";?>" class="form-control" value="<?php echo $email_data->identifier; ?>">
											</div>
                            			</div>
										
										 <div class="form-group ">
											<label class="col-sm-2 control-label" >
												<?php echo "Email Data";?>
											</label>
											<div class="col-sm-10">
												<textarea class="col-sm-10" disabled  name='description' id='temp-html'><?php echo $email_data->description; ?></textarea>
											</div>
                            			</div> 
							
										<div class="form-group ">
											<div class="col-sm-12" >
												<!--<button style='float: right;' type='submit' class='btn btn-success '>Submit</button>-->
												<a style='float: right;margin-right: 10px;' href="<?php echo base_url('admin/emailtemplate'); ?>" class="btn btn-warning">Back</a>
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
	</div>
</div>

<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> 
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>'
	/*var user_type = 'admin';
	var module = 'countries';
	var list_cont_func = 'list';
	var dlt_cont_func = 'delete';*/
	function set_summer()
    {
        $('.summernotes').each(function() 
        {
            var now = $(this);
            var h = now.data('height');
            var n = now.data('name');
            now.closest('div').append('<input type="hidden" class="val" name="'+n+'">');
            now.summernote({
                height: h,
                onChange: function() {
                    now.closest('div').find('.val').val(now.code());
                }
            });
			now.closest('div').find('.val').val(now.code());
        });
	}
	$(document).ready(function() 
	{
		new nicEditor({fullPanel : true}).panelInstance('temp-html');
		//set_summer();
		//$("#email_process").find('[data-original-title="Video"]').addClass('hidden');
		//$("#email_process").find('[data-original-title="Picture"]').addClass('hidden');
		//$("#email_process").find('[data-original-title="Full Screen"]').addClass('hidden');
		
		
	});
	
	function emform()
	{
		/*$('.summernotes').each(function() 
		{
            var now = $(this);
            now.closest('div').find('.val').val(now.code());
        });*/
		//alert('false');
		return true;
	}
	
</script>
<style>
	.hidden
	{
		display:none;
	}
</style>
