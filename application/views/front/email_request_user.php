			
      <table  role="presentation" cellspacing="0" cellpadding="0"  width="100%" style="border: 1px solid #ddd;margin: auto;max-width:684px;width:90%;">
      	<tr>
          <td valign="top" class="bg_light" style="padding: 0.5em 1em 0.5em 1em;border-bottom: 1px solid #dddddd;">
          	<table role="presentation"  cellpadding="0" cellspacing="0" width="100%">
          		<tr>
          			<td class="logo" style="text-align: center;">
			            <h1 style="text-align: left;margin: 0;padding:0;">
							<a class="navbar-brand" href="<?php echo base_url(); ?>" style="display: block;width:120px;height:40px;">
								<img id="logo-header" class="img-responsive" src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="Logo" style="width:100%;height:100%;">
							</a>
						</h1>
					</td>
					<td class="logo" style="text-align: right;">
			           <strong style="color:#145DA2;font-family: sans-serif;"><?php echo $request_title; ?></strong>
			        </td>
          		</tr>
          	</table>
          </td>
	    </tr>
	    <tr>
			<td class="bg_dark email-section" style="text-align:left;">
					<div class="heading-section heading-section-white" style="background: #fff;padding: 30px;min-height:250px;position: relative;">
						<?php
						
							if($user_type=='user')
							{
								echo 'Hi '.ucfirst($customer_name).',';
								echo '<p>Your '.strtolower($request_title).' has been sent successfully.</p>';
								
							}
							else
							{
								echo 'Hi ,';
								echo '<p>You have received a '.strtolower($request_title).' from '.ucfirst($customer_name).'.</p>';
							 
								if($request_type=='request_service')
								{
									echo '<b>Service Request Deatils</b><br/>';
									
									$seCategory = $this->db->get_where('service_category',array('service_category_id'=>$request_data->service_category))->row()->name;
									$seType = $this->db->get_where('service_type',array('service_type_id'=>$request_data->service_type))->row()->type;
									?>
										<table>
											<tr>
											<td>Service Category</td><td>:</td><td><?php echo $seCategory; ?></td>
											</tr><tr>
											<td>Service Type</td><td>:</td><td><?php echo $seType; ?></td>
											</tr><tr><td>Customer Name</td><td>:</td><td><?php echo $request_data->name;?></td>
											</tr>
											<tr>
											<td>Email</td><td>:</td><td><?php echo $request_data->email; ?></td></tr>
											<tr>
											<td>Contact Number</td><td>:</td><td><?php echo $request_data->mobile; ?></td>
											</tr>
										</table>
									<?php
									//print_r($request_data);
								}
								else
								{
									echo '<b>Demo Request Deatils</b><br/>';
									$seproduct = $this->db->get_where('product',array('product_id'=>$request_data->product_id))->row()->title;
									?>
										<table>
											<tr>
												<td>Product Name</td><td>:</td><td><?php echo $seproduct; ?> </td></tr>
											<tr>
												<td>Customer Name</td><td>:</td><td><?php echo $request_data->name; ?></td></tr>
											<tr>
												<td>Email</td><td>:</td><td><?php echo $request_data->email; ?></td></tr>
											<tr>
												<td>Contact Number</td><td>:</td><td><?php echo $request_data->mobile; ?></td>
											</tr>
										</table>
									<?php
									//print_r($request_data);
								}
							}

						?>
						
						
						
					</div>
			</td>
		</tr>
        <tr>
          	<td class="bg_white" style="text-align: center; padding-top: 0x;background: #ddd;padding: 10px 0;">
            <p> <a href="<?php echo base_url(); ?>" style="color: rgba(0,0,0,.8);text-decoration: none;font-size:16px;font-family: sans-serif;">vinshopify.com</a></p>
          	</td>
        </tr>
      </table>