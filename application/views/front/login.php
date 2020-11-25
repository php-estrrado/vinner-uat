<link rel="stylesheet" type="text/css" href="<?php echo base_url('template/front/assets/css/msdropdown/dd.css')?>" />
<script src="<?php echo base_url('template/front/assets/js/msdropdown/jquery.dd.min.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('template/front/assets/css/msdropdown/flags.css')?>" />

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
                        <h5 class="headermodal otp_html-head lghead-h"><?php echo translate('OTP_verification');?></h5>
            <button aria-hidden="true" data-dismiss="modal" id="close_log_modal" onclick="set_html('forget_html','login_html','otp_html')" class="close" type="button">×</button>
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
                                        $countries      =   $this->db->where(['status'=>1])->order_by('id','desc')->get('countries')->result();
                        ?>
                <div id="login_content" class="ps-form__content">
                            <h5>Log In Your Account</h5>
                            <div class="form-group">
                                <input name="email" class="form-control" type="text" placeholder="Email Address">
                            </div>
                            <div class="form-group form-forgot">
                                <input name="password" class="form-control" type="password" placeholder="Password">
                                <a href="#" onClick="set_html('login_html','forget_html','')">Forgot?</a>
                            </div>
                            <div class="form-group ">
                                <span id="id_of_button" class="drs-btn ps-btn ps-btn--fullwidth login_btn" type="submit"> <?php echo translate('log_in');?> </span>
                            </div>
                            <div class="alert alert-danger logfail" id="fail" style="display:none">
                                 <strong>Login Failed!</strong> Try Again...! 
                            </div>
                            
                            <div class="row col-12 partition">
                                <h2 class="partition-line mt-2 mb-2">
                                    <p class="partition-circle">OR</p>
                                </h2>
                            </div>
                            
                            <h5><?php echo translate('mobile_number')?> </h5>
                            <div class="form-group">
                                <div class="row"><div class="col-md-3 col-4 pr-0">
                                    <select id="c_code" name="c_code" class="form-control p-1" ><?php
                                        if($countries){ foreach($countries as $row){
                                            echo '<option value="'.$row->phonecode.'" data-image="'.base_url('template/front/assets/img/msdropdown/icons/blank.gif').'" data-imagecss="flag '.strtolower($row->sortname).'" data-title="'.$row->name.'">+'.$row->phonecode.'</option>';
                                        } }?>
                                    
                                    </select>
                                </div>
                                <div class="col-md-9 col-8 pl-2">
                                    <input name="mobile" id="mobile" class="form-control numberonly" type="text" placeholder="Mobile Number">
                                </div></div>
                                <div class="clr"></div>
                            </div>
                                <div class="alert alert-danger" id="mobile_error" style="display:none">
                            </div>
                            <div class="form-group ">
                                <button id="verify_mobile" class="drs-btn ps-btn ps-btn--fullwidth " type="button"> <?php echo translate('send_OTP');?> </button>
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
                    <div id="login_forgot" class="ps-form__content">
                            <!--<h5><?php echo translate('forgot_password');?></h5> -->
						 	Please enter your email address below and we will send you new password.
                            <div class="form-group" style="margin-top: 1.5rem;">
                                <input name="email" class="form-control" type="text" placeholder="Email address">
                            </div>  
                            <div class="form-group ">
                                <button class="drs-btn ps-btn ps-btn--fullwidth forget_btn" type="submit"> 
									<?php echo translate('submit');?> 
								</button>
                            </div>  
                            <p class="hvacnt">
                                <span style="cursor:pointer;" class="colortheme" onClick="set_html('forget_html','login_html','')">
                                    <?php echo translate('back_to_login');?>
                                </span>
                            </p>
                    </div>
                    <?php
                echo form_close();
                ?>
                
            </div>
            <div id="otp_html" class="otp_html ps-form__content" style="display: none;">
                <h5 class="">OTP</h5>
                    <div class="ps-form__content"><?php
                        echo form_open(base_url() . 'home/login/do_login/', array('class' => 'ps-form--account', 'method' => 'post', 'style' => '', 'id' => 'otp_form')); ?>
                        <div class="row">
                            <div class="form-group col-7 fl">
                                <input name="otp" id="otp" class="form-control" type="text" placeholder="Enter OTP">
                                <input type="hidden" id="otp_mobile" name="mobile" value="" /><input type="hidden" id="token" name="token" value="" />
                            </div>
                            <div class="form-group col-5 fl">
                                <button id="verify_otp" class="drs-btn ps-btn ps-btn--fullwidth " type="button"> <?php echo translate('verify');?> </button>
                            </div>
                            <div class="alert alert-danger" id="otp_error" style="display:none"></div>
                            <p class="hvacnt">
                                <span style="cursor:pointer;" class="colortheme" onClick="set_html('otp_html','login_html','')">
                                    <?php echo translate('back_to_login');?>
                                </span>
                            </p>
                        </div><?php
                        form_close() ?>
                    </div> 
                <div class="clr"></div>
                </div>
        </div>
    </div>
</div>
<style type="text/css">
	#login .modal-header {
		background: #145da2;
	}
	.lghead-h
	{
		display:none;
	}
</style>
<script>
    $(document).ready(function(){
        $('#verify_mobile').on('click',function(){ 
            $('#mobile_error').hide(); $('#verify_mobile').attr('disabled',true); $('#verify_mobile').text('Validating...')
           $.ajax({
                type: "POST",
                url: '<?php echo base_url('api/sendotp')?>',
                data: {mobile: $('#mobile').val(), c_code: $('#c_code').val()},
                success: function (data) {
                    $('#verify_mobile').attr('disabled',false); $('#verify_mobile').text('Send OTP')
                   if(data.httpcode == 400){
                        $('#mobile_error').text(data.message); $('#mobile_error').show(); 
                    }else if(data.httpcode == 200){ 
                        $('#mobile_error').text(''); $('#otp_error').text(''); $('#mobile_error').hide(); 
                        set_html('login_html','otp_html','');
                    }
                } 
            });
        });
        
        $('#verify_otp').on('click',function(){ 
            $('#otp_error').hide(); $('#verify_otp').attr('disabled',true); $('#verify_otp').text('Verifying...');
           $.ajax({
                type: "POST",
                url: '<?php echo base_url('api/verifyotp')?>',
                data: {c_code: $('#c_code').val(),mobile: $('#mobile').val(),otp: $('#otp').val()},
                success: function (data) {
                   if(data.httpcode == 400){
                        $('#otp_error').text(data.message); $('#otp_error').show();
                         $('#verify_otp').attr('disabled',false); $('#verify_otp').text('Verify');
                    }else if(data.httpcode == 200){ 
                        $('#otp_error').text(''); $('#otp_error').hide(); 
                        if(data.user_status == 'register'){ 
                            $('#verify_otp').attr('disabled',false); $('#verify_otp').text('Verify');
                            set_html('otp_html','login_html',''); signin($('#mobile').val()); 
                            setTimeout(function(){ register(); },500);
                        }else if(data.user_status == 'verified'){ 
                            $('#verify_otp').text('Authenticating...')
                            doLogin(data.data.mobile,data.data.access_token);
                        }
                       $.each( data.data, function( key, value ) {
                        //   alert(value);
                        });
                    }
                } 
            });
        });
        $('#close_log_modal').on('click',function(){ $('.modal-dialog').modal('hide'); });
        $("#c_code").msDropdown();
    });
	function set_html(hide,show,hide1)
    {
		$('.'+show+'-head').removeClass('lghead-h');
		$('.'+hide+'-head').addClass('lghead-h');
                $('.'+hide1+'-head').removeClass('lghead-h');
		$('.'+show).show('fast'); $('.'+hide).hide('fast'); $('.'+hide1).hide('fast');
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
    
    function doLogin(mobile,token){
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
            $('#otp_mobile').val(mobile); $('#token').val(token);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('home/login/do_login/')?>',
            data: $('#otp_form').serialize(),
            success: function (data) {
                if(data == 'done'){ window.location.reload(); }
                else{ 
                    $('#mobile_error').text(data); $('#mobile_error').show(); set_html('otp_html','login_html','');
                }
            }});
    }
</script>