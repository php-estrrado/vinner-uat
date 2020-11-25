


	<div class="ps-page--my-account">
      
		<div class="ps-breadcrumb">
        <div class="container">
          <!--
		  <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
             <li>Login</li> 
          </ul>
		  -->	
        </div>
      </div>


      <div class="ps-my-account">
		  <?php
		  	if($this->session->flashdata('welcome_msg'))
			{
				?>
				<div class="container alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<center>
						<strong>Success! Your email has been verified successfully ...! </strong>
					</center>
				</div>
		  		<?php
			}
		  ?>
		  
        <div class="container login_page" >
            <?php
                echo form_open(base_url() . 'home/login/do_login/page', array(
                        'class' => 'ps-form--account log-reg-v3',
                        'method' => 'post',
                        'style' => '',
                        'id' => 'page-login'
                        ));
    					$fb_login_set = $this->crud_model->get_type_name_by_id('general_settings','51','value');
    					$g_login_set = $this->crud_model->get_type_name_by_id('general_settings','52','value');
                        ?>
                   	<ul class="ps-tab-list">
              			<li class="active"><a href="#sign-in">Login</a></li>
            		</ul>

            		<div class="ps-tabs">
						<?php
							//echo $this->input->get('page', TRUE);
						?>
						<input type="text" hidden readonly name="redirect" value="<?php echo $this->input->get('page', TRUE);?>" >
              			<div class="ps-tab active" id="sign-in">
	                        <div class="ps-form__content">
	                            <h5>Log In Your Account</h5>
	                            <div class="form-group">
	                                <input name="email" required class="form-control" type="text" placeholder="Username or email address">
	                            </div>
	                            <div class="form-group form-forgot">
	                                <input name="password" required id="page_pass_button" class="form-control" type="password" placeholder="Password">
	                                <a href="#" onClick="set_html('login_page','forget_page')">Forgot?</a>
	                            </div>
	                            <div class="form-group ">
	                                <!-- <span id="page_sub_button" class="drs-btn ps-btn ps-btn--fullwidth login_btn" type="submit"> <?php echo translate('log_in');?> </span> -->
									<button type="submit" class="ps-btn ps-btn--fullwidth">Login
	                                </button>
	                            </div>
	                            
	                                 <?php 
										if($this->session->flashdata('frm_error'))
            							{ ?>
											<div class="alert alert-danger " id="logp_fail" style="">
												<?php echo $this->session->flashdata('frm_error'); ?>
											</div>
											<?php
										}
									?>
	                            
	                            <p>
	                                <?php echo translate('do_not_have_account_?_click_');?>
	                                <span class="click-toreg"  data-dismiss="modal" onclick="register()" >
	                                    <?php echo translate('here');?>
	                                </span>
	                                <?php echo translate('to_registration_.');?>
	                            </p>
	                        </div>
	                        <?php 
	                        	/*
	                            if($fb_login_set == 'ok' || $g_login_set == 'ok')
	                                {
	                                ?>
	                                    <div class="ps-form__footer">
	                                        <p>Login with:</p>
	                                        <ul class="ps-list--social">
	                                            <li>
	                                                <a class="facebook" href="#"><i class="fa fa-facebook"></i></a>
	                                            </li>
	                                            <li>
	                                                <a class="google" href="#"><i class="fa fa-google-plus"></i></a>
	                                            </li>
	                                        </ul>
	                                    </div>
	                                <?php
	                                 }  
	                        	*/
	                        ?>
              			</div>
            		</div>
            		<?php
                echo form_close();
            ?>
        </div>    
        <div class='container forget_page' style="display:none;">
				<?php
                    echo form_open(base_url() . 'home/login/forget/', array(
                        'class' => 'ps-form--account log-reg-v3',
                        'method' => 'post',
                        'style' => '',
                        'id' => 'page-foget'
                        ));
                     ?>
                     <ul class="ps-tab-list">
              			<li class="active"><a href="#frg-get"><?php echo translate('forgot_password');?></a>
              			</li>
            		 </ul>
            		 <div class="ps-tabs">
              			<div class="ps-tab active" id="frg-get">
	                     	<div class="ps-form__content">
								Please enter your email address below and we will send you new password.
	                            <div class="form-group" style="margin-top: 1.5rem;">
	                                <input name="email" required class="form-control" type="text" placeholder="Email address">
	                            </div>  
	                            <div class="form-group ">
	                                <span class="drs-btn ps-btn ps-btn--fullwidth forget_btn" type="submit"> <?php echo translate('submit');?> </span>
	                            </div>  
	                            <p>
	                                <span class="click-toreg" onClick="set_html('forget_page','login_page')">
	                                    <?php echo translate('back_to_login');?>
	                                </span>
	                            </p>
	                    	</div>
	                    </div>
	                 </div>
                     <?php
                    echo form_close();
                ?>
        </div>
        
      </div>
    </div>

<style>
	.ps-block--user-header
	{
		display:none;
	}
	
	.click-toreg
	{
		cursor: pointer;
		color: #e22626;
		font-weight: 500;
	}
</style>
 <script>
	function set_html(hide,show)
    {
		$('.'+show).show('fast');
		$('.'+hide).hide('fast');
        $("#logp_fail").hide();
	}
    
    $(".lgin").click(function()
    {
        $("#logp_fail").hide();
    });

    $("#page_pass_button").keyup(function(event)
    {
        if(event.keyCode == 13){
            $("#page_sub_button").click();
        }
    });
</script>