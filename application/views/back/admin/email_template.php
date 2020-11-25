<div id="content-container">
	<div id="page-title">
		<h1 class="page-header text-overflow"><?php echo translate('manage_email_templates');?></h1>
	</div>
	<div class="tab-base">
		<div class="panel">
			<div class="panel-body">
				<div class="tab-content">
					<div class="col-md-12" style="border-bottom: 1px solid #ebebeb;padding:10px;">
						<!-- <button class="btn btn-primary btn-labeled fa fa-plus-circle pull-right" 
                        	onclick="ajax_modal('add','<?php echo translate('add_coupon'); ?>','<?php echo translate('successfully_added!');?>','coupon_add','')">
								<?php echo translate('create_coupon');?>
						</button> -->
					</div>
					<div class="tab-pane fade active in" id="list" style="border:1px solid #ebebeb; border-radius:4px;">
						<div class="panel-body" id="demo_s">
							<table id="email-table" class="table table-striped"  data-pagination="true"  data-ignorecol="0,2" data-show-toggle="true" data-show-columns="false" data-search="true" >
								<thead>
										<tr>
											<th><?php echo translate('no'); ?></th>
											<th><?php echo translate('template_name'); ?></th>
											<th><?php echo translate('title'); ?></th>
											<th class="text-right"><?php echo translate('options'); ?></th>
										</tr>
								</thead>
								<tbody>
									<?php
										$i = 0;
										foreach($all_emails as $row)
										{
											$i++;
                							?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $row['identifier']; ?></td>
												<td><?php echo $row['title']; ?></td>
												<td class="text-right">
													<a class="btn btn-success btn-xs btn-labeled fa fa-wrench" data-toggle="tooltip" href="<?php echo base_url('admin/emailtemplate/edit/'.$row['id']); ?>" data-original-title="Edit" data-container="body">
														<?php echo translate('edit');?>
													</a>
												</td>
											</tr>
											<?php
										}
									?>
								</tbody>
							</table>
    					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var base_url = '<?php echo base_url(); ?>'
	/*var user_type = 'admin';
	var module = 'countries';
	var list_cont_func = 'list';
	var dlt_cont_func = 'delete';*/
	
    $(document).ready(function()
	{
        $('#email-table').bootstrapTable({});
	});
</script>

