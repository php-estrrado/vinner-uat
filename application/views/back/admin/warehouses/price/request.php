<div id="content-container">
	<div id="page-title">
		<h1 class="page-header text-overflow"><?php echo translate('price_change_requests');?></h1>
	</div>
	<div class="tab-base">
		<div class="panel">
			<div class="panel-body">
				<div class="tab-content">
                                    <div class="col-md-12">
                                    </div>
					<br>
                    <!-- LIST -->
                    <?php // echo '<pre>'; print_r($products); echo '</pre>';  ?>
                    <div class="tab-pane fade active in" id="list" style="border:1px solid #ebebeb; border-radius:4px;">
                        <?php  include 'request_list.php' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var base_url = '<?php echo base_url(); ?>';
    var timer = '<?php $this->benchmark->mark_time(); ?>';

//
//    var user_type = 'admin';
//
//    var module = 'shippingOperator';
//
//    var list_cont_func = 'list';
//
//    var dlt_cont_func = 'delete';
    
    $(document).ready(function(){
       $('body').on('click','#operators-table .apBtn',function(){
           var id       =   this.id.replace('ap_',''); 
           del_confirm(id,'Are You Sure?','admins/warehouse','priceChange','approve')
       });
       
       $('body').on('click','#operators-table .dnBtn',function(){
           var id       =   this.id.replace('dn_',''); 
           del_confirm(id,'Are You Sure?','admins/warehouse','priceChange','reject')
       });
    });
       
</script>
