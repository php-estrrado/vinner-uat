<div id="content-container">
	<div id="page-title">
		<h1 class="page-header text-overflow" ><?php echo translate('manage_order');?></h1>
	</div>
	
	<div class="tab-base">
		<div class="">
			<div class="panel-body">
                <div class="tab-content manage_order" id="list">
                 </div>
                
			</div>
        </div>
	</div>
</div>
<?php
    
    $ord_id =  $this->uri->segment(3);
    if(isset($ord_id))
    {
    ?>
	<a id="odr_btn" onclick="ajax_set_full('order_home','Title','Successfully Edited!','sales_view','<?php echo $ord_id;?>')">Click</a>
	<script>
        $( document ).ready(function() {
    console.log( "ready!" );
            $('#odr_btn').trigger('click');
});
</script>
	<?php
	}
    ?>
<script>
    //document.getElementById('odr_btn').click();
	var base_url = '<?php echo base_url(); ?>'
	var user_type = 'admin';
	var module = 'sales';
	var list_cont_func = 'list';
	var dlt_cont_func = 'delete';
</script>

