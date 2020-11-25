		<?php
			$welcome_template='';
			$system_name  = $this->db->get_where('general_settings', array('type' => 'system_name'))->row()->value;
			$welcome_templateqry= $this->db->get_where('email_template', array('identifier' => 'user-signup'));//->row()->value;
			if($welcome_templateqry->num_rows()==1)
			{
				$welcome_template=$welcome_templateqry->row()->description;
			}
		?>
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
			           <strong style="color:#fff;font-family: sans-serif;">Welcome to <?php echo $system_name;?></strong>
			        </td>
          		</tr>
          	</table>
          </td>
	      </tr>
	      <tr>
			  
          <td class="bg_dark email-section" style="text-align:left;">
			  <?php
			  if($account_type == '')
              {
				  	$activelink=urlencode(base_url().'home/email_approve/'.sha1($email));
					$activation_button='Please activate your account.<br>
					<a target="_blank" href='.urldecode($activelink).' style="background: #e22626;border-radius: 5px;height:35px;width: 120px;text-align: center;margin: 0 auto;display: block;color:#fff;line-height: 32px;text-decoration: none;">Activate</a>';
					if($welcome_template)
					{
						$welcome_template=str_replace("{name}",ucfirst($fname),$welcome_template);
						$welcome_template=str_replace("{logindata}",$activation_button,$welcome_template);
						echo '<div style="background: #fff;padding: 30px 0;">'.$welcome_template.'</div>';
					}
				  	else
					{
						?>
			  			<div class="heading-section heading-section-white" style="background: #fff;padding: 30px;border-right: 1px solid #ddd;border-left:1px solid #ddd;min-height:250px;position: relative;">
							<span style="color: #222;font-family: sans-serif;">
								Dear <?php echo ucfirst($fname);?> ,
							</span>
							<p style="margin-bottom: 50px;color: #222;font-family: sans-serif;">
								We are excited you are here! <br/>
								To learn more about <?php echo $system_name;?> Please activate your new 
								account.<br/>
								After activation you can login to our site.
							</p>
							<p style="text-align: center;position: absolute;bottom: 30px;right:0;left: 0;margin:0 auto;">
								<a target="_blank" href="<?php echo base_url(); ?>home/email_approve/<?php  echo sha1($email)."/";?>" style="background: #e22626;border-radius: 5px;height:35px;width: 120px;text-align: center;margin: 0 auto;display: block;color:#fff;line-height: 32px;text-decoration: none;">Activate</a>
							</p>
          				</div>
			  			<?php
					}
			  }
			  else if($account_type == 'vendor')
              {		
				    $vwelcome_template='';
				  	$vwelcome_templateqry= $this->db->get_where('email_template', array('identifier' => 'supplier-signup'));
					if($vwelcome_templateqry->num_rows()==1)
					{
						$vwelcome_template=$vwelcome_templateqry->row()->description;
					}
				  	if($vwelcome_template)
					{
						$vwelcome_template=str_replace("{name}",ucfirst($fname),$vwelcome_template);
						echo '<div style="background: #fff;padding: 30px 0;">'.$vwelcome_template.'</div>';
					}
				  	else
					{
					
			  			?>
						<p style="margin-bottom: 50px;color: #222;font-family: sans-serif;">
								 We are excited you are here! <br/>
								 Please Wait for the approval mail from <?php echo $system_name;?>..<br/>
								 Account type: <?php echo $account_type; ?>
						</p>
			  			<?php
					}
			  }
			  else if($account_type == 'admin')
			  {	
			  	?>
			  		<div style="margin: 0 auto;color: #222;font-family: sans-serif;padding: 30px 0;margin-left: 30px;min-height: 200px;">
						Hi <?php echo $fname; ?>,
						<p style="margin-left: 14px;">
								Your MyDrsAsia - Admin Account Details <br/><br/>
						Account Email	  :<?php echo $email; ?><br/>
						Account Password  : <?php echo $pass; ?><br/>
						</p>
					</div>
			  	<?php
			  }
			  ?>
			  <?php /*
          	<div class="heading-section heading-section-white" style="background: #fff;padding: 30px;border-right: 1px solid #ddd;border-left:1px solid #ddd;min-height:250px;position: relative;">
          		<span style="color: #222;font-family: sans-serif;">
					Dear <?php echo ucfirst($fname);?> ,
				</span>
				<?php 
					if($account_type == '')
                    {
                      ?>
						<p style="margin-bottom: 50px;color: #222;font-family: sans-serif;">
							We are excited you are here! <br/>
							To learn more about <?php echo $system_name;?> please activate your new 
							account.<br/>
							After activation you can login to our site.
						</p>
						<p style="text-align: center;position: absolute;bottom: 30px;right:0;left: 0;margin:0 auto;">
							<a target="_blank" href="<?php echo base_url(); ?>home/email_approve/<?php  echo sha1($email)."/";?>" style="background: #e22626;border-radius: 5px;height:35px;width: 120px;text-align: center;margin: 0 auto;display: block;color:#fff;line-height: 32px;text-decoration: none;">Activate</a>
						</p>
					  <?php
					}
					else if($account_type == 'vendor')
                    {
						?>
						<p style="margin-bottom: 50px;color: #222;font-family: sans-serif;">
							 We are excited you are here! <br/>
                             Please Wait for the approval mail from <?php echo $system_name;?>..<br/>
                             Account type: <?php echo $account_type; ?>
						</p>
						<?php
					}
				?>
				
          	</div>
			  */ ?>
          </td>
			  
		    </tr>
        <tr>
          <td class="bg_white" style="text-align: center; padding-top: 0x;background: #ddd;padding: 10px 0;">
            <p><a href="<?php echo base_url(); ?>" style="color: rgba(0,0,0,.8);text-decoration: none;font-size:16px;font-family: sans-serif;">mydrsasia.com</a></p>
          </td>
        </tr>
      </table>