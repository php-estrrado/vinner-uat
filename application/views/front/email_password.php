			<?php 
				$password_template='';
				$welcome_templateqry= $this->db->get_where('email_template', array('identifier' => 'forgot-password'));
				if($welcome_templateqry->num_rows()==1)
				{
					$password_template=$welcome_templateqry->row()->description;
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
			           <strong style="color:#fff;font-family: sans-serif;">Password Reset</strong>
			        </td>
          		</tr>
          	</table>
          </td>
	      </tr>
	      <tr>
          <td class="bg_dark email-section" style="text-align:left;">
          	<div class="heading-section heading-section-white" style="background: #fff;padding: 30px;border-right: 1px solid #ddd;border-left:1px solid #ddd;min-height:250px;position: relative;">
          		<?php
					if($password_template)
					{
						
						$password_template=str_replace("{name}",ucfirst($uname),$password_template);
						$password_template=str_replace("{user_type}",ucfirst($account_type),$password_template);
						$password_template=str_replace("{password}",trim($pass),$password_template);
						echo $password_template;
					}
					else
					{
						?>
							<span style="color: #222;font-family: sans-serif;">
								Dear <?php echo $account_type?> ,
							</span>
							<p style="color: #222;font-family: sans-serif;">
								Your password is changed as you requested..
							</p>
							<p style="color: #222;font-family: sans-serif;">
								Your New Password:<b><?php echo trim($pass);?></b>
							</p>
						<?php
					}
				?>
				
				
				
          	</div>
          </td>
		    </tr>
        <tr>
          <td class="bg_white" style="text-align: center; padding-top: 0x;background: #ddd;padding: 10px 0;">
            <p><a href="<?php echo base_url(); ?>" style="color: rgba(0,0,0,.8);text-decoration: none;font-size:16px;font-family: sans-serif;">mydrsasia.com</a></p>
          </td>
        </tr>
      </table>