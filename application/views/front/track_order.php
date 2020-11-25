
    <div class="ps-page--single" id="contact-us">
	    
	    <div class="ps-breadcrumb">
	        <div class="container">
	          <ul class="breadcrumb">
	            <li><a href="<?php base_url(); ?>"><?php echo translate('home'); ?></a></li>
	            <li><?php echo translate('track_order'); ?></li>
	          </ul>
	        </div>
	    </div>
	    
	    <div class="ps-contact-form">
	        <div class="container">
	         	<?php
	      			echo form_open(base_url() . 'home/trackorder/track', array(
	      				'class' => 'ps-form--contact-us',
	      				'method' => 'get',
	      				'enctype' => 'multipart/form-data',
	      				'id' => ''
		      			));
		    		    ?>    
		            	<h3><?php echo translate('track_order');?></h3>
						<div class="form-group--nest col-md-6 offset-md-3">
				            <input class="form-control" required type="text" name="sale_id" placeholder="Sale Order Id">
				            <button  type="submit" class="ps-btn">Track</button>
				        </div>
						<div class="form-group--nest col-md-6 offset-md-3 track-msg">
							<?php
								if($this->session->flashdata('track_alert'))
								{
									echo $this->session->flashdata('track_alert');
								}
							?>
						</div>
		          		<?php
				    echo form_close();
			     ?>
				<div class="col-md-10 offset-md-1 mt-5 track-data">
					<?php 
						if($order_data)
						{
							?>
							<div class='track-code-date'>
								<span class="text-bold">
									<b>Sale Code : <?php echo $order_data->sale_code; ?></b>
								</span>
								<span  class="text-bold" style="float:right">
									<b>Sale Date : <?php echo date('d-m-Y',$order_data->sale_datetime); ?></b>
								</span>
							</div>
							<div class="table-responsive">
								<table class="table ps-table--shopping-cart">
									<thead>
										<tr><th>Product</th><th>Seller</th><th>Delivery Status</th></tr>
									 </thead>
									 <tbody>
										 <?php
											$product_details = json_decode($order_data->product_details, true);
											foreach ($product_details as $items) 
											  {
												?>
												<tr>
													<td><?php echo $items['name']; ?></td>
													<td>
														<?php 
															echo $this->crud_model->product_by($items['id']); 
														?>
													</td>
													<td>
														<b>
														<?php
															$tvendor_id= $this->crud_model->product_by($items['id'],'id');
															$tvendor_stat=0;
															$delivery_status = json_decode($order_data->delivery_status,true); 
															foreach ($delivery_status as $dev) 
															{
																if(isset($dev['vendor']))
																{
																	if($dev['vendor']==$tvendor_id)
																	{
																		echo translate($dev['status']);
																		$tvendor_stat=1;
																	}
																}
															}
															if($tvendor_stat==0)
															{
																echo translate('pending');
															}

														?>
														</b>
													</td>
												</tr>
												<?php
											  }
										 ?>
									</tbody>
								</table>
							</div>
							<?php
						}
					?>
					
				</div>
	        </div>
      	</div>
	</div>

	<style>
		.track-msg
		{
			color:red;
		}
		.track-data
		{
			min-height: 250px;
		}
	</style>