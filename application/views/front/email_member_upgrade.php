
      <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;max-width:684px;width:90%;">
      	<tr>
          <td valign="top" class="bg_light" style="padding: 0.5em 1em 0.5em 1em;background: #000;">
          	<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
          		<tr>
          			<td class="logo" style="text-align: center;">
			            <h1 style="text-align: left;margin: 0;padding:0;">
							<a class="navbar-brand" href="<?php echo base_url(); ?>" style="display: block;width:120px;height:40px;">
								<img id="logo-header" class="img-responsive" src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="Logo" style="width:100%;height:100%;">
							</a>
						</h1>
					</td>
					<td class="logo" style="text-align: right;">
			           <strong style="color:#fff;font-family: sans-serif;">
						   Membership <?php echo ($membership_id<= '0')? 'Degrade':'Upgrade';  ?>
						</strong>
			        </td>
          		</tr>
          	</table>
          </td>
	      </tr>
	      <tr>
			  <td class="bg_dark email-section" style="text-align:left;">
				<div class="heading-section heading-section-white" style="background: #fff;padding: 30px;border-right: 1px solid #ddd;border-left:1px solid #ddd;min-height:250px;position: relative;">
					<span style="color: #222;font-family: sans-serif;margin-top:10px;">
						Dear Vendor <?php echo ucfirst($vname); ?> ,
					</span>
					<p style="color: #222;font-family: sans-serif;">
						<?php 
							if ($membership_id== '0') 
							{ ?>
							  Your Membership type is reduced to : Default <br />
							  <?php  
							} 
							else 
							{  ?>
							   Your Membership is upgraded to : <b> <?php echo $membershipt; ?></b>.<br/>
							   Now you can add up to <b><?php echo $product_limit; ?></b> products to your store.<br/>
							   <?php 
							}  
						?>
					</p>

				</div>
			  </td>
		</tr>
        <tr>
          <td class="bg_white" style="text-align: center; padding-top: 0x;background: #ddd;padding: 10px 0;">
            <p><a href="<?php echo base_url(); ?>" style="color: rgba(0,0,0,.8);text-decoration: none;font-size:16px;font-family: sans-serif;">mydrsasia.com</a></p>
          </td>
        </tr>
      </table>