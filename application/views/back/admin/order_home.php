    <div>
        <div class="pull-right" style="width: 70px;">
            <a href="javascript:window.history.go(0);" id="back-btn" class="btn btn-info btn-xs btn-labeled" data-toggle="tooltip">Back </a>
        </div>
    </div>
    <div class="tab-base">
        <div class="tab-base tab-stacked-left">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#demo-stk-lft-tab-1">
						<?php echo translate('order_details');?>
                    </a>
                </li>
      <!--          <li >-->
      <!--              <a data-toggle="tab" href="#demo-stk-lft-tab-2">-->
						<!--<?php echo translate('payment_receipts');?>-->
      <!--              </a>-->
      <!--          </li>-->
                <li >
                    <a data-toggle="tab" href="#demo-stk-lft-tab-3">
                        <?php echo translate('shipping_details');?>
                    </a>
                </li><?php
                if(json_decode($sale[0]['shipping_address'])->ship_method == 'fedex_shiping'){ ?>
                <li >
                    <a data-toggle="tab" href="#demo-stk-lft-tab-4" id="fedex-label-li">
                        <?php echo translate('fedEx label');?>
                    </a>
                </li>
                
                 <li >
                     <a data-toggle="tab" href="#demo-stk-lft-tab-5" id="fedex-history-li">
                        <?php echo translate('fedEx history');?>
                    </a>
                </li>
                <?php } ?>
                 <li >
                     <a data-toggle="tab" href="#demo-stk-lft-tab-6" id="order-products-li">
                        <?php echo translate('products');?>
                    </a>
                </li>
            <!--     <li >
                    <a data-toggle="tab" href="#demo-stk-lft-tab-7">
                        <?php // echo translate('history');?>
                    </a>
                </li> -->
<!--                <li >
                    <a data-toggle="" href="<?php // echo base_url()."index.php/admin/sales/"; ?>">
                        <?php // echo translate('back to_orders');?>
                    </a>
                </li>-->
             </ul>
            <div class="tab-content">
               
                <div id="demo-stk-lft-tab-1" class="tab-pane fade active in">
               
                
             <?php    
                $weightClass    =   $this->crud_model->getWeightClass();
                $dimClass       =   $this->crud_model->getDimClass();
                foreach($sale as $row)
				{ // echo '<pre>'; print_r($row); echo '</pre>';
					$info = json_decode($row['shipping_address'],true);
					$fedexLabelHistory =   $this->crud_model->getFedexLabelHistory($row['sale_code']);
					$bcntry=$info['country'];$bstat=$info['state'];
					$billCountry  = $this->db->get_where('fed_country',array('country_id'=>$bcntry))->row()->name;
					$billState= $this->db->get_where('fed_zone',array('code'=>$bstat,'country_id'=>$bcntry))->row()->name;	
					
					$scntry=$info['s_country'];$sstat=$info['s_state'];
					$shipCountry  = $this->db->get_where('fed_country',array('country_id'=>$scntry))->row()->name;
                    $shipState=$this->db->get_where('fed_zone',array('code'=>$sstat,'country_id'=>$scntry))->row()->name; 

					$prds           =   json_decode($row['product_details']);
					$prdIds         =   array(); $prdQtys = array();
					foreach ($prds as $prd)
					{
						$prdIds[]   =   $prd->id;
						$prdQtys[]  =   $prd->qty;
					}
					$prdDetails         =   $this->crud_model->getPrdDetails($prdIds);
					$orderedProducts    =   $this->crud_model->getOrderedPrdDetails($prdIds);
                	?>
               <table class="table">
     <h4><?php echo translate('order_details'); ?></h4>
    <tbody>
      <tr class="">
        <td>Order ID</td>
        <td><?php echo $row['sale_code'];?></td>
      </tr>
        <tr class="">
        <td>Store name</td>
          <td>
              <?php 
              $delivery_status = json_decode($row['delivery_status'],true); 
                            $vendor =   $this->crud_model->get_vendor_by_id($row['vendor_id']);
                            echo $vendor->display_name;
                        //    $vendor[$dev['vendor']] =   $this->crud_model->get_vendor_by_id($dev['vendor']);
                            // $vendor =   $dev['vendor'];
                            // echo $this->crud_model->get_type_name_by_id('vendor', $dev['vendor'], 'display_name').' ('.translate('vendor').')<br>';
              ?>
          </td>
      </tr>
       
        <tr class="">
        <td>Customer</td>
          <td>
              <?php 
                     if($row['buyer']==0)
                         echo "Guest";
                     else
                echo $info['firstname'];      
               ?>
          </td>
      </tr>
      
       <tr class="">
        <td>Email</td>
          <td>
              <?php 
                     echo $info['email'];   
               ?>
          </td>
      </tr>
      
       <tr class="">
        <td>Mobile</td>
          <td>
              <?php 
                   echo $info['mobile'];    
               ?>
          </td>
      </tr>
       <tr class="">
        <td>Total</td>
          <td>
              <?php 
                  $vendor         =   $this->crud_model->get_vendor_by_id($row['vendor_id']);
                  echo $vendor->currency.' '.$this->cart->format_number($row['grand_total']); 
               ?>
          </td>
      </tr>
      
       <tr class="">
        <td>Order Status</td>
          <td>
              <?php 
                       echo $row['delivery_status'];      
               ?>
          </td>
      </tr>
      
       <tr class="">
        <td>Order Date</td>
          <td>
              <?php 
                 echo date('d,M,Y' ,strtotime($row['sale_datetime']));    
               ?>
          </td>
      </tr>
      
      
       <tr class="">
        <td></td>
          <td>
              <?php 
              
               ?>
          </td>
      </tr>
    </tbody>
  </table>
               
               <?php } ?>
                </div>
                
                
					 <div id="demo-stk-lft-tab-2" class="tab-pane fade">
						 <h4><?php echo translate('payment_receipts'); ?></h4>              
						 <div>
							 <?php
							 	$recpt_qry=$this->db->where('sale_id',$row['sale_id'])->get('sale_receipt');
							 	if($recpt_qry->num_rows()>0)
								{
									$srecpts=$recpt_qry->result();
									foreach($srecpts as $srecp)
									{
										$ext = pathinfo($srecp->receipt, PATHINFO_EXTENSION);
										if($ext=='pdf')
										{
											echo '<span id="recp-pdf"><a download=payment_receipt_'.$sale_data->sale_code.'.'.$ext.' href='.base_url().'uploads/sale_receipt/'.$srecp->receipt.'><i class="fa fa-file-pdf-o fa-5x" aria-hidden="true"></i></a></span>';
										}
										else if($ext=='docx')
										{
											echo '<span id="recp-word"><a download=payment_receipt_'.$sale_data->sale_code.'.'.$ext.' href='.base_url().'uploads/sale_receipt/'.$srecp->receipt.'><i class="fa fa-file-word-o fa-5x" aria-hidden="true"></i></a></span>';
										}
										else if($ext=='jpg' || $ext=='png' || $ext=='jpeg')
										{
											echo '<span id="recp-imag"><a download=payment_receipt_'.$sale_data->sale_code.'.'.$ext.' href='.base_url().'uploads/sale_receipt/'.$srecp->receipt.'><img src='.base_url().'uploads/sale_receipt/'.$srecp->receipt.' /></a></span>';
										}
									}
								}
							 ?>
						 </div>
					</div>
                
             <!--Shipping data -->   
                <div id="demo-stk-lft-tab-3" class="tab-pane fade">
                   <h4><?php echo translate('shipping_details'); ?></h4>              
					<table class="table">            
						<tr class="">
							<td>First name</td>
							<td><?php  echo $info['s_firstname'];  ?></td>
						</tr>

						<tr class="">
							<td>Last name</td>
							<td><?php  echo $info['s_lastname'];  ?></td>
						</tr>

						<tr class="">
							<td>Address 1</td>
							<td><?php  echo $info['s_address1'];  ?></td>
						</tr>

						<tr class="">
							<td>Address2</td>
							<td><?php  echo $info['s_address2'];  ?></td>
						</tr>

						<tr class="">
							<td>City</td>
							<td><?php  echo $info['s_city'];  ?></td>
						</tr>

						<tr class="">
							<td>Region/State</td>
							<td><?php  echo $shipState;  ?></td>
						</tr>                                                                                                                                          
						
						<tr class="">
							<td>Country</td>
							<td><?php  echo $shipCountry;  ?></td>
						</tr>                                   
					</table>              
                </div>
                               
                                
                <div id="demo-stk-lft-tab-4" class="tab-pane fade">
                    <?php  require_once 'fedex_label_new.php' ?>
<!--                    <button style="display: none;" id="create-label" type="button" class="btn btn-primary btn-labeled fa pull-left mar-lft">Create Label</button>-->
                    <?php // require_once('fedex/test.php'); ?>
                    <div id="log"></div>
                </div>
                <div id="demo-stk-lft-tab-5" class="tab-pane fade">
                    <?php require_once 'fedex_label_list.php' ?>
                </div>
                <div id="demo-stk-lft-tab-6" class="tab-pane fade">
                    <?php require_once 'order_products.php' ?>
                </div>
                <div id="demo-stk-lft-tab-7" class="tab-pane fade active in">
                 
                </div>
            
            </div>
            
       
          </div>
     </div>


<script type="text/javascript">

	$(document).ready(function() {
		$('.demo-chosen-select').chosen();
		$('.demo-cs-multiselect').chosen({
			width: '100%'
		});
        
      
	});
	
//	$(document).ready(function() {
		$("form").submit(function(e) {
			return false;
		});
		$(".sw1").each(function() {
			new Switchery(document.getElementById('ban_' + $(this).data('id')), {
				color: 'rgb(100, 189, 99)'
			});
			var changeCheckbox = document.querySelector('#ban_' + $(this).data('id'));
			changeCheckbox.onchange = function() {
				ajax_load('<?php echo base_url(); ?>index.php/admin/banner/banner_publish_set/' + $(this).data('id') + '/' + changeCheckbox.checked, 'prod', 'others');
				if (changeCheckbox.checked == true) {
					$.activeitNoty({
						type: 'success',
						icon: 'fa fa-check',
						message: '<?php echo translate('banner_published!'); ?>',
						container: 'floating',
						timer: 3000
					});
                    sound('published');
				} else {
					$.activeitNoty({
						type: 'danger',
						icon: 'fa fa-check',
						message: '<?php echo translate('banner_unpublished!'); ?>',
						container: 'floating',
						timer: 3000
					});
                    sound('unpublished');
				}
			};
		});
                $('#fedex-label-li').click(function(){
                    $('#new-label-form').fadeIn('slow');
                    $('#create-label').fadeIn('slow');
                });
                $('#fedex-history-li').click(function(){
                    $('#fedex-label-history').fadeIn('slow');
                });
                $('#order-products-li').click(function(){
                    $('#order-products').fadeIn('slow');
                });
                
                
                $('#fedex-form').on('submit', function(){
                    $('#create-label').fadeIn('slow');
                    var result  =   true;
                    $(".required").each(function(){
                        if($('#'+this.id).val() > 0){ $('#'+this.id).removeClass('error'); }
                        else{  $('#'+this.id).addClass('error'); result = false; }
                    });
                    if(result == false){ return false; }
                    $("#log").html( '<div><img src="<?php echo base_url()?>template/back/img/ajax-loader.gif" /></div>' );
               //     alert($('form').serialize());
                //    return false;
                    var orderId     = '<?php echo $row['sale_code']?>';
                    var weightDim   =   $('#fed-weight').val()+'<||>'+$('#fed-length').val()+'<||>'+$('#fed-width').val()+'<||>'+$('#fed-height').val();
                    var wdClass     =   $('#fed-weight-class').val()+'<||>'+$('#fed-dim-class').val();
                    var packCount   =   $('#pack-count').val();
                    var formData    =   JSON.stringify($('form').serializeArray());
                    var request     =   $.ajax({
                        url: "<?php echo base_url()?>fedex/fedex.php",
                        type: "POST",
                        data: {orderId : orderId, vendor : '<?php echo $vendor?>', baseurl : '<?php echo base_url()?>', currency : '<?php echo currency()?>', wd : weightDim, wdclass : wdClass, packCount : packCount, formData : formData},
                        dataType: "html"
                    });
                    request.done(function(msg) {
                        $("#log").html( msg );
                        
                    });

                    request.fail(function(jqXHR, textStatus) {
                        alert( "Request failed: " + textStatus );
                    });
                });
	// });
	
	
	$(".imgInp").change(function() 
	{
		var tar = $(this).closest('.panel-body').find('.img_show');
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				tar.attr('src', e.target.result);
			}
			reader.readAsDataURL(this.files[0]);
		}
	});
</script>

<style>
	#recp-imag 
	{
		display: block;
    	width: 120px;
    	height: 120px;
	}
	#recp-imag img
	{ 
		width: 100%;
	}
	</style>