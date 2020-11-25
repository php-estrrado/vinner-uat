<div id="content-container">
	<div id="page-title">
		<h1 class="page-header text-overflow"><?php echo 'Total Sales Invoice of '. $invohead;?></h1>
	</div>
	<div class="tab-base">
		<div class="panel">
			<div class="panel-body">
				<div class="tab-content">
                    <div class="tab-pane fade active in" id="list" style="border:1px solid #ebebeb; border-radius:4px;">
						<div class="panel-body" id="demo_s">
							<table id="tsale-table" class="table table-striped"  data-pagination="true"  >
								<thead>
									<tr>
										<th style="width:4ex"><?php echo translate('no');?></th>
										<th><?php echo translate('order_id');?></th>
										<th><?php echo translate('customer');?></th>
										<th > <?php echo translate('delivery_status');?>    </th>
										<th><?php echo translate('payment_status');?> </th>
										<th><?php echo translate('total');?></th>
										<th><?php echo translate('date_added');?></th>
									</tr>
        						</thead>
								<tbody>
									<?php
										$i = 0;
										foreach($total_sales as $row)
										{
											$i++; 
        									?>
											<tr>
												<td><?php echo $i; ?></td>
												<td>#<?php echo $row['sale_code']; ?></td>
												<td>
													<?php
														if($row['buyer']==0)
														{
															echo "Guest User";
														}
														else
														{
														echo 
														$this->crud_model->get_type_name_by_id('user',$row['buyer'],'username'); 
														}      
													 ?>
												</td>
												<td>
													<?php 
														$delivery_status = json_decode($row['delivery_status'],true); 
														foreach ($delivery_status as $dev) 
														{
															?>

															<div class="label label-<?php if($dev['status'] == 'delivered'){ ?>purple<?php } else { ?>danger<?php } ?>">
															 <?php
																if(isset($dev['vendor']))
																{
																	echo $this->crud_model->get_type_name_by_id('vendor', $dev['vendor'], 'display_name').' ('.translate('vendor').') : '.$dev['status'].'<br>';
																} 
																else if(isset($dev['admin'])) 
																{
																	echo translate('admin').' : '.$dev['status'];
																}
															 ?>
															</div>
															<?php
														}
													?>
            									</td>
												<td>
													<?php 
														$payment_status = json_decode($row['payment_status'],true); 
														foreach ($payment_status as $dev) 
														{
															?>

															<div class="label label-<?php if($dev['status'] == 'paid'){ ?>purple<?php } else { ?>danger<?php } ?>">
																<?php
																if(isset($dev['vendor']))
																	{
																		echo $this->crud_model->get_type_name_by_id('vendor', $dev['vendor'], 'display_name').' ('.translate('vendor').') : '.$dev['status'].'<br>';
																	} 
																else if(isset($dev['admin'])) 
																	{
																		echo translate('admin').' : '.$dev['status'];
																	}
																?>
															</div>
															<?php
														}
													?>
												</td>
												<td class="">
													<?php echo currency().$this->cart->format_number($row['grand_total']); ?>
												</td>
												<td>
													<?php echo date('d-m-Y',$row['sale_datetime']); ?>
												</td>
											</tr>
											<?php
										}
									?>
								</tbody>
								<tfoot>
     							  <tr>
									  <td colspan="5" align="center"><b>Total Sales Amount</b></td>
									  <td colspan="2"> 
										  <b><?php echo currency().$this->cart->format_number($gdtotal);  ?> </b>
									  </td>
								  </tr>
								</tfoot>
							</table>
						</div>
						<div class="fixed-table-toolbar" align="center">
							<div class="">
								<button class="btn btn-info btn-labeled fa fa-download " type="button" title="PDF" onclick="export_it('pdf');">
									PDF
								</button>
								<a  class=" btn btn-info btn-labeled fa fa-arrow-left" type="button" href="<?php echo base_url()."admin/report_sale/"; ?>" > 
									Back 
								</a>
							</div> 
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
	var base_url = '<?php echo base_url(); ?>'
	var user_type = 'admin';
	var module = 'total_sales';
	//var list_cont_func = 'list';
	//var dlt_cont_func = 'delete';
</script>

<script>
	$(document).ready(function()
	{
        $('#tsale-table').bootstrapTable({});
	});
</script>


<div id='export-div'>
        <h2 style="display:none;"><?php echo 'Total Sales Invoice of '. $invohead;?></h2>
        <table id="export-table" data-name='Total Sales Invoice' data-orientation='p' data-width='1000' style="display:none;">
			<col width="50">
			<col width="200">
			<col width="200">
			<col width="250">
			<col width="250">
			<col width="200">
			<col width="200">
                <thead>
                    <tr>
                <th><?php echo translate('no');?></th>
                <th><?php echo translate('order_id');?></th>
                <th><?php echo translate('customer');?></th>
                <th > <?php echo translate('delivery_status');?>    </th>
                <th><?php echo translate('payment_status');?> </th>
                <th><?php echo translate('total');?></th>
                <th><?php echo translate('date_added');?></th>
                    </tr>
                </thead>
               <tbody>      
               <?php
            $i = 0;
        
            foreach($total_sales as $row){
                $i++; 
        ?>
        <tr>
             <td ><?php echo $i; ?></td>
            <td >#<?php echo $row['sale_code']; ?></td>
            <td ><?php
            if($row['buyer']==0)
            {
                echo "Guest User";
            }
            else
            {
             echo $this->crud_model->get_type_name_by_id('user',$row['buyer'],'username'); 
         }?>
                
            </td>
             
             <td >
                <?php 
                    $this->benchmark->mark_time();
                    $delivery_status = json_decode($row['delivery_status'],true); 
                    foreach ($delivery_status as $dev) {
                ?>

                
                <?php
                        if(isset($dev['vendor'])){
                            echo $this->crud_model->get_type_name_by_id('vendor', $dev['vendor'], 'display_name').' ('.translate('vendor').') : '.$dev['status'].'<br>';
                        } else if(isset($dev['admin'])) {
                            echo translate('admin').' : '.$dev['status'];
                        }
                ?>
               
                <?php
                    }
                ?>
            </td>
             <td >

                <?php 
                    $payment_status = json_decode($row['payment_status'],true); 
                    foreach ($payment_status as $dev) {
                ?>

                
                <?php
                        if(isset($dev['vendor'])){
                            echo $this->crud_model->get_type_name_by_id('vendor', $dev['vendor'], 'display_name').' ('.translate('vendor').') : '.$dev['status'].'<br>';
                        } else if(isset($dev['admin'])) {
                            echo translate('admin').' : '.$dev['status'];
                        }
                ?>
              
                <?php
                    }
                ?>
            </td>
             <td class="pull-left" ><?php echo currency().$this->cart->format_number($row['grand_total']); ?></td>
            <td ><?php echo date('d-m-Y',$row['sale_datetime']); ?></td>
            
             </tr>
        <?php
            }
        ?>
       <?php /* <tr><th colspan="5" width="800" align="center"><b>Total Sales Amount</b></th><th width="200"> <b><?php echo currency().$this->cart->format_number($gdtotal);  ?> </b></th></tr> */?>
         
                </tbody>

        </table>
	<div style="display:none;" align="center">
    	<h4>Total Sales :<?php echo $i;  ?> </h4><br/>
    	<h4>Total Sales Amount :<?php echo currency().$this->cart->format_number($gdtotal);  ?> </h4>
    </div>

<style>
    .highlight{
        background-color: #E7F4FA;
    }
	.fixed-table-toolbar {
		margin-bottom: 40px;
	}
</style>