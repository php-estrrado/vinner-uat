<div id="content-container">
	<div id="page-title">
		<h1 class="page-header text-overflow"><?php echo translate('warehouse_product');?></h1>
	</div>
	<input type="text" id="venId" value="list" hidden>
	<div class="tab-base">
		<div class="panel">
			<div class="panel-body">
				<div class="tab-content">
					
					<div class="tab-pane fade active in" id="list" 
                    	style="border:1px solid #ebebeb; 
                        	border-radius:4px;">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	// alert($('#venId').val())
	var base_url = '<?php echo base_url(); ?>'
	var user_type = 'admin';
	var module = 'vendor_product';
	var list_cont_func = 'list/<?php echo $this->uri->segment('3')?>';
	//var list_cont_func = 'filter';
	var dlt_cont_func = 'delete';
</script>

