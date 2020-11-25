<div class="modal-dialog" style="margin-top:100px !important;">
    <div class="modal-content">
        <div class="modal-header">
        	<!-- <center>
            	<a href="<?php echo base_url(); ?>">
                    <img class="mdl-logo" width='100%' src="<?php echo $this->crud_model->logo('home_bottom_logo'); ?>" alt="">
                </a>
            </center> -->
			<h5 class="headermodal login_html-head"><?php echo translate('log_in');?></h5> 
			<h5 class="headermodal forget_html-head lghead-h"><?php echo translate('forgot_password');?></h5> 
            <button aria-hidden="true" data-dismiss="modal" id="close_log_modal" onclick="set_html('forget_html','login_html')" class="close" type="button">×</button>
        </div>

        <div class="modal-body">
            <div class='login_html'>
				<?php
                    echo form_open(base_url() . 'home/login/do_login/', array(
                        'class' => 'ps-form--account',
                        'method' => 'post',
                        'style' => '',
                        'id' => 'login_form'
                        ));
    					$fb_login_set = $this->crud_model->get_type_name_by_id('general_settings','51','value');
    					$g_login_set = $this->crud_model->get_type_name_by_id('general_settings','52','value');
                        ?>
                        <div class="ps-form__content">
                            <h5>Log In Your Account</h5>
                            <div class="form-group">
                                <input name="email" class="form-control" type="text" placeholder="Username or email address">
                            </div>
                            <div class="form-group form-forgot">
                                <input name="password" class="form-control" type="password" placeholder="Password">
                                <a href="#" onClick="set_html('login_html','forget_html')">Forgot?</a>
                            </div>
                            <div class="form-group ">
                                <span id="id_of_button" class="drs-btn ps-btn ps-btn--fullwidth login_btn" type="submit"> <?php echo translate('log_in');?> </span>
                            </div>
                            <div class="alert alert-danger logfail" id="fail" style="display:none">
                                 <strong>Login Failed!</strong> Try Again...! 
                            </div>
                            <p class="hvacnt">
                                <?php echo translate('do_not_have_account_?_click_');?>
                                <span style="cursor:pointer" class="colortheme"  data-dismiss="modal" onclick="register()" >
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
                        <?php
                    echo form_close();
                ?>
            </div>

            <div class='forget_html' style="display:none;">
				<?php
                    echo form_open(base_url() . 'home/login/forget/', array(
                        'class' => 'ps-form--account',
                        'method' => 'post',
                        'style' => '',
                        'id' => 'forget_form'
                        ));
                     ?>
                     <div class="ps-form__content">
                            <!--<h5><?php echo translate('forgot_password');?></h5> -->
						 	Please enter your email address below and we will send you new password.
                            <div class="form-group" style="margin-top: 1.5rem;">
                                <input name="email" class="form-control" type="text" placeholder="Email address">
                            </div>  
                            <div class="form-group ">
                                <span class="drs-btn ps-btn ps-btn--fullwidth forget_btn" type="submit"> 
									<?php echo translate('submit');?> 
								</span>
                            </div>  
                            <p class="hvacnt">
                                <span style="cursor:pointer;" class="colortheme" onClick="set_html('forget_html','login_html')">
                                    <?php echo translate('back_to_login');?>
                                </span>
                            </p>
                    </div>
                    <?php
                    echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
	#login .modal-header {
		background: #000;
	}
	.lghead-h
	{
		display:none;
	}
</style>
<script>
	function set_html(hide,show)
    {
		$('.'+show+'-head').removeClass('lghead-h');
		$('.'+hide+'-head').addClass('lghead-h');
		$('.'+show).show('fast');
		$('.'+hide).hide('fast');
        $("#fail").hide();
	}
    
    $(".lgin").click(function()
    {
        $("#fail").hide();
    });

    $("#id_of_textbox").keyup(function(event)
    {
        if(event.keyCode == 13){
            $("#id_of_button").click();
        }
    });
</script>