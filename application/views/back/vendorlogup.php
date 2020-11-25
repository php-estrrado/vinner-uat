<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="300">
    <title><?php echo translate('login');?> | <?php echo $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,300,500" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>template/back/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>template/back/css/activeit.min.css" rel="stylesheet">  
    <!--Font Awesome [ OPTIONAL ]-->
    <link href="<?php echo base_url(); ?>template/back/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!--Demo [ DEMONSTRATION ]-->
    <link href="<?php echo base_url(); ?>template/back/css/demo/activeit-demo.min.css" rel="stylesheet">
    <!--SCRIPT-->
    <!--Page Load Progress Bar [ OPTIONAL ]-->
    <link href="<?php echo base_url(); ?>template/back/plugins/pace/pace.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>template/back/plugins/pace/pace.min.js"></script>
    <?php $ext =  $this->db->get_where('ui_settings',array('type' => 'fav_ext'))->row()->value; $this->benchmark->mark_time();?>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>uploads/others/favicon.<?php echo $ext; ?>">
</head>

<body >
<div id="container" class="" style="">
        <div id="bg-overlay"></div>
<div class="row navbar container-fluid " >
     <img src="<?php echo $this->crud_model->logo('admin_login_logo'); ?>" class="log_iconvr" style="margin: 10px;">
    <div class="log_iconvrs"><h3 >Sellers</h3></div>
</div>

<div class="row content ">
      <center>
      <div class="col-sm-5 signupcont">
            <!--Reg Block-->
            <div class="pagesignup col-lg-12">
                <div class="reg-block-header">
                    <h2><?php echo translate('be_a_seller');?></h2>
                    <p style="font-weight:300 !important;"><?php echo translate('already_a_seller?');?> <?php echo translate('click'); ?> <a class="color-purple" href="<?php echo base_url(); ?>index.php/vendor/sell" ><?php echo translate('sign_in');?></a> 
                    <?php echo translate('to_login_your_account');?></p>
					<div class="clear"></div>
                </div>
        <?php
                    echo form_open(base_url() . 'index.php/home/vendor_logup/add_info/', array(
                        'class' => 'log-reg-v3 sky-form vlogup formbox',
                        'method' => 'post',
                        /*'style' => 'padding:30px',*/
                        'id' => 'login_form',
                        'name' =>'vlog'
                    ));
        ?>                            
                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" placeholder="<?php echo translate('name'); ?>" name="name" class="form-control required" >
                            </div>
                        </label>
                    </section>                   

                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-university"></i></span>
                                <input type="text" placeholder="<?php echo translate('company'); ?>" name="company" class="form-control required" >
                            </div>
                        </label>
                    </section>                     

                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" placeholder="<?php echo translate('email_address'); ?>" name="email" class="form-control required" >
                            </div>
                        </label>
                    </section>

                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="password" placeholder="<?php echo translate('password'); ?>" id="pass1" name="password1" class="form-control required" >
                                <span class="input-group-addon" style="cursor: pointer;" >
                                <i title = "show password" class="fa fa-eye" onclick="shpas()" id="shp"></i></span>
                            </div>    
                        </label>
                    </section>

                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="password" placeholder="<?php echo translate('confirm_password'); ?>" name="password2" class="form-control required" >
                            </div>    
                        <div id='pass_note'></div> 
                        </label>
                    </section>   

                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-desktop"></i></span>
                                <input type="text" placeholder="<?php echo translate('display_name'); ?>" name="display_name" class="form-control required" >
                            </div>    
                        </label>
                    </section>  


                  
				  <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                        		<input type="text" id="mobile" placeholder="<?php echo translate('Mobile_number'); ?>" name="mobile" class="form-control required" >
                            </div> 
                        </label>
                  </section>
                    


                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                <input type="text" placeholder="<?php echo translate('address_line_1'); ?>" name="address1" class="form-control required" >
                            </div>    
                        </label>
                    </section>

                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                <input type="text" placeholder="<?php echo translate('address_line_2'); ?>" name="address2" class="form-control">
                            </div>    
                        </label>
                    </section>
					
					<section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-globe"></i></span>
								<select id="country" name="country_code" class="required form-control" placeholder="<?php echo translate('Country'); ?>">
										<option value=""><?php echo translate('select_country'); ?></option>
										  <?php
											$cntry=$this->db->get_where('fed_country',array('status'=>'1'))->result_array();
											foreach($cntry as $cntry_details)
											  {
												echo "<option value='".$cntry_details[country_id]."' ".$sel.">".$cntry_details[name]."</option>";
											  }
										  ?>
								</select>
							</div>    
                        </label>
                    </section>

<!--  <div class="row"> -->
           <section class="captcha-box">
           <div class="wrap">
                <label class="input login-input no-border-top captcha-text">
                   <input type="text" placeholder="Captcha" name="captcha" id="captcha" class="form-control required"  >  
                </label>    
              <label class="input captcha-img">
                      <font id="captImg"><?php echo $this->crud_model->captcha("new"); ?></font>
                      <a href="javascript:void(0);" onclick="refre()" class=" fa fa-refresh refreshCaptcha fa-2x" style="color: #2da5da;" ></a>
              </label>   
              <div class="clear"></div> 
              </div>
          </section>
          

<script>
    var base_url = '<?php echo base_url(); ?>';

      function refre()
      {
        $.ajax({
            url: base_url+'home/captcha_refresh',
            success: function(data) {
              $('#captImg').html(data);
              console.log(data);
            },
            error: function(e) {
                console.log(e)
            }
        }); 
      }
</script>                     



					  <div class="registration-button-block">
					   <span type="submit" class="btn-u btn-u-cust btn-block reg_btn v_logup_btn" style="cursor: pointer;" data-ing='<?php echo translate('registering..'); ?>' >Register Now</span>

					  </div>

     
                <?php echo form_close(); ?>
		  <div class="clear"></div>
            </div>

        </div>

</center>

</div>
</div>

<div class="alert alert-success fade in alert-dismissable" id="suss" title="" style="position: fixed; bottom: 5px; right: 5px; opacity: 1; display:none;">
 <div id="alertmesgsu"><?php echo translate('registration_successful!'); ?> <?php echo translate('please_check_your_email_inbox'); ?>
</div>
</div>

<div class="alert alert-danger alert-dismissable" id="topcontrol4" title="" style="position: fixed; bottom: 5px; right: 5px; opacity: 1;display:none; ">
<!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
 -->
 <div id="alertmesg">
</div>
</div>
    
    <!--jQuery [ REQUIRED ]-->

    <script src="<?php echo base_url(); ?>template/back/js/jquery-2.1.1.min.js"></script>
    <!--BootstrapJS [ RECOMMENDED ]-->
    <script src="<?php echo base_url(); ?>template/back/js/bootstrap.min.js"></script>
    <!--Activeit Admin [ RECOMMENDED ]-->
    <script src="<?php echo base_url(); ?>template/back/js/activeit.min.js"></script>
    <!--Background Image [ DEMONSTRATION ]-->
    <script src="<?php echo base_url(); ?>template/back/js/demo/bg-images.js"></script>
    <!--Bootbox Modals [ OPTIONAL ]-->
    <script src="<?php echo base_url(); ?>template/back/plugins/bootbox/bootbox.min.js"></script>
    <!--Demo script [ DEMONSTRATION ]-->
    <script src="<?php echo base_url(); ?>template/back/js/ajax_login.js"></script>
    <script src="<?php echo base_url(); ?>template/front/assets/js/ajax_method.js"></script>
    <script>
    var telerr=1;
    var mblerr=0;
        var base_url = '<?php echo base_url(); ?>'
        var cancdd = '<?php echo translate('cancelled'); ?>'
        var req = '<?php echo translate('this_field_is_required'); ?>'
        var sing = '<?php echo translate('signing_in...'); ?>';
        var nps = '<?php echo translate('new_password_sent_to_your_email'); ?>';
        var lfil = '<?php echo translate('login_failed!'); ?>';
        var wrem = '<?php echo translate('wrong_e-mail_address!_try_again'); ?>';
        var lss = '<?php echo translate('login_successful!'); ?>';
        var sucss = '<?php echo translate('SUCCESS!'); ?>';
        var rpss = "<?php echo translate('reset_password'); ?>";
        
        var mbe = "<?php echo translate("must_be_a_valid_email_address"); ?>";

        var user_type = '<?php echo $control; ?>';
        var module = 'login';
    var unapproved = '<?php echo translate('account_not_approved._wait_for_approval.'); ?>';
$("#id_admin_login").keyup(function(event){
    if(event.keyCode == 13){
        $("#btn_login").click();
    }
});
    </script>

    
</body>



</html>

<style>
.clear{
    clear: both;
    margin: 0;
    padding: 0;
}
.pagesignup {
	background: #fff;
	margin-bottom: 30px;
}
.captcha-box .wrap{
    max-width: 300px;
    margin: 0 auto;
}
.formbox label{
    width: 100%;
}
.formbox .captcha-text{
    float: left;
}
.formbox .captcha-text input{
    height: 40px;
}
.formbox .captcha-img
{
    float: right;
}
.formbox .captcha-img #captImg{
    float: left;
    width: 80%;
}
.formbox .captcha-img #captImg img{
    width: 100%;
}
.formbox .captcha-img .refreshCaptcha{
    float: right;
    width: 16%;
    margin: 10px 0 0 2%;
}
.formbox .captcha-text,
.formbox .captcha-img
{
    width: 48%;
}
.require_alert,
.phno_note2crt,
#phno_note2crt {
    float: right;
    color: red;
	font-size: 11px;
}

    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
      background-color: #000;
    }
    .navbar-inverse
    {
    background-color: #458FD2;
    border-color: #458FD2;
    }
    .navbar-brand
    {
        padding: 15px 44px 44px;
        background-color: #458FD2;
    }
     
    
.log_iconvr
  {
    width: 120px;
    float: left;
  }
.log_iconvrs {
   float: left;
    margin-left: 0;
    margin-top: 2px;
    color: #fff;
  }
.log_iconvrs h3 {
	margin-top:12px;
}
.signupcont
{
  margin: 25px !important;;
 float: none !important;
}

.registration-button-block 
{
  width: 100%;
  margin: 20px auto;
  float: left;
  text-align: center;
}

.registration-button-block a,
.registration-button-block span {
  display: inline-block;
  text-align: center;
  padding: 10px;
  color: #fff;
  min-height: 45px;
}

.registration-button-block span {
  width: 92px;
  background: #458FD2;
  border-radius: 3px;
  font-size: 14px;
}

 .registration-button-block span {
    width: 220px;
    background: #e22626;
    border-radius: 3px;
    font-size: 16px;
    padding: 10px;
    height: 45px;
}
.vlogup  .input-group .form-control
.phca .form-control {
	height: 45px;
}
.phca .input-group-addon {
	height: 45px; 
	line-height: 30px;
}
.log-reg-v3.sky-form.vlogup {
	padding: 5px;
}
.reg-block-header {
	float:left;
	width: 100%;
}
	/* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {
		  height:auto;
		} 
		.log-reg-v3.sky-form.vlogup {
			padding: 0;
		}
		.reg-block-header h2 {
			font-size: 22px;
		}
    }
</style>

<script>

function shpas()
{
    //alert("yes");
if($("#shp").hasClass("fa-eye"))
{
    $("#shp").removeClass("fa-eye");
    $("#shp").addClass("fa-eye-slash");
    $("#pass1").prop("type", "text");
    $("#shp").attr('title', "hide password"); 
}
else if($("#shp").hasClass("fa-eye-slash"))
{
    $("#shp").removeClass("fa-eye-slash");
    $("#shp").addClass("fa-eye");
    $("#pass1").prop("type", "password");
    $("#shp").attr('title', "show password");
}
}

    var logup_success = '<?php echo translate('registration_successful!'); ?> <?php echo translate('please_check_your_email_inbox'); ?>';
 /*   $('body').on('click','.v_logup_btn',*/


   $(".v_logup_btn").click(function()
   {
        var here = $(this); // alert div for show alert message
        var form = here.closest('form');
        var can = '';
        var ing = here.data('ing');
        var msg = here.data('msg');
        var prv = here.html();
        var required= 'Required';

        var formdata = false;
        if (window.FormData){
            formdata = new FormData(form[0]);
        }
         var a = 0;

        var take = '';

        form.find(".required").each(function()
        {
          var txt = '* '+req;
            a++;
            if(a == 1)
            {
                take = 'scroll';
            }
            var here = $(this);
            if(here.val() == '')
            {
                if(!here.is('select'))
                {
                    here.css({borderColor: 'red'});

                    if(here.attr('type') == 'number')
                    {
                        txt = '* '+mbn;
                    }
                    if(here.closest('.input').find('.require_alert').length)
                    {

                    } 
					else 
					{
                        here.closest('.input').append(''
                            +'  <span id="'+take+'" class="require_alert" >'
                            +'      '+txt
                            +'  </span>'
                        );
                    }
                } 
                else if(here.is('select'))
                {
                    here.closest('div').find('.chosen-single').css({borderColor: 'red'});
                    if(here.closest('.input').find('.require_alert').length)
                    {
                    } else 
                    {
                        here.closest('.input').append(''
                            +'  <span id="'+take+'" class="require_alert" >'
                            +'      '+txt
                            +'  </span>'
                        );
                    }
                }
                /*var topp = 100;
                $('html, body').animate({
              scrollTop: $("#scroll").offset().top - topp }, 500);*/
                can = 'no';
            }
			else
			{
				if (here.attr('type') == 'email')
				{
					if(!isValidEmailAddress(here.val()))
					{
						here.css({borderColor: 'red'});
						if(here.closest('.input').find('.require_alert').length)
						{
							here.closest('.input').find('.require_alert').html(' * '+mbe);
						} 
						else 
						{
							here.closest('.input').append(''
								+'  <span id="'+take+'" class="require_alert" >'
								+'      * '+mbe
								+'  </span>'
							);
						}
						can = 'no';
					}
			    }
				if (here.attr('id') == 'mobile')
				{
					var phone = here.val();
					var phoneno = /^[0-9]{9,11}$/;
					if(phone.match(phoneno))
					{
					} 
					else 
					{
						if(here.closest('.input').find('.require_alert').length)
						{
							here.closest('.input').find('.require_alert').html(' * Enter valid mobile number ');
                    	} 
						else 
						{
							here.closest('.input').append(''
								+'  <span id="'+take+'" class=" require_alert" >'
								+'   * Enter valid mobile number ( must be 9 to 11 numbers) '
								+'  </span>'
							);
						}
						can = 'no';
					}
				}
			}
            take = '';
        });


		if(can !== 'no')
		{
			$.ajax({
				url: form.attr('action'), // form action url
				type: 'POST', // form submit method get/post
				dataType: 'html', // request type html/json/xml
				data: formdata ? formdata : form.serialize(), // serialize form data 
				cache       : false,
				contentType : false,
				processData : false,
				beforeSend: function() {
					here.html(ing); // change submit button text
				},
				success: function(data) {
				  //alert(data);
					here.fadeIn();
					here.html(prv);
					if(data == 'done'){

					  window.location.replace(base_url+'vendor/sell/regsu');

					   $("#topcontrol4").fadeout();
						//notify(logup_success,'success','bottom','right'); 
						$('#suss').fadein();

					} 
					else 
					{
						$("#topcontrol4").fadeIn();
						$("#alertmesg").html(data);
						$("#captcha").val('');
						refre();
					   // $("#topcontrol4").fadeOut(2000);
					}
				},
				error: function(e) {
					console.log(e)
				}
			});
		}
		else
		{
			return false;
		}
    });


  	function isValidEmailAddress(emailAddress) 
	{
    	var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);

    	return pattern.test(emailAddress);
   };  

 
</script>


 <script>
          function cuph()   
          {
            $('.phca').show();
            $('#tel').hide();
            $("#bt_submit").css("pointer-events", "none");
            $(".pr").addClass("requried");
            $(".pr").attr("requried", "requried");
          }         

    function crtph()
    {
      var a = $("#phcountry_code").find("option:selected").attr("value");
      if(a != "")
      {
        telerr=1;
        $("#d_co").val( '+' + a);
        $("#telacrt").val("");
        $("#telncrt").val("");
        $("#tel").val("");
        $("#phno_note1crt").html('');
        $("#phno_note2crt").html('');
        $("#bt_submit").css("pointer-events", "none");
        $("#telacrt").prop("readonly",false);
        $("#telncrt").prop("readonly",true);
        $("#telacrt").focus();
        var n = a.length;
  
        if(n == 2)
        {
            $("#telncrt").prop("maxlength",8);
        }
        else
        {
            $("#telncrt").prop("maxlength",7);
        }
        $("#cco").text('+' + a);
        $("#cco").show();
        $("#mobile_cc").prop("readonly",false);
        $("#mobile_cc").val('');
        $("#mobile").val('');
      }
      else
      {
        $("#cco").text('+XX');
        $("#cco").hide();
        $("#mobile_cc").val('');
        $("#mobile_cc").prop("readonly",true);
        $("#mobile").val('');

        $("#d_co").val( '+XX');
        $("#telacrt").val("");
        $("#telncrt").val("");
        $("#telacrt").prop("readonly",true);
        $("#telncrt").prop("readonly",true);
        telerr=1;
      }
  
    }
    $("#telncrt").blur(function() 
	{
        var a = $(this).val();
        var phoneno =/^[0-9]{3,10}$/;
        if(a.match(phoneno))
        {
            var cc=$("#phcountry_code").val();
            var ac=$("#telacrt").val();
            $("#tel").val(cc+ac+a);
            $("#phno_note2crt").html('');
           var phoneno2 =/^[0-9]{5,15}$/;
           if ($("#tel").val().match(phoneno2)) 
           {
           $("#v_logup_btn").css("pointer-events", "auto");
           telerr=0;
           }
           else
           {
            telerr=1;
           }
        } 
        else 
        {
            $("#phno_note2crt").html( '<?php echo translate('Enter_valid_Ph.No(000)'); ?>' );
            $("#v_logup_btn").css("pointer-events", "none");
            telerr=1;
        }

    });
        

  $("#telacrt").blur(function() 
    {
        var a = $(this).val();
        var phoneno =/^[0-9]{1,3}$/;
        if(a.match(phoneno))
        {
            var cc=$("#phcountry_code").val();
            var ac=$("#telncrt").val();
            $("#tel").val(cc+a+ac);
            $("#phno_note1crt").html('');
            $("#telncrt").focus();
            $("#telncrt").prop("readonly",false);
            var phoneno2 =/^[0-9]{5,15}$/;
           if ($("#tel").val().match(phoneno2)) 
           {
           $("#v_logup_btn").css("pointer-events", "auto");
          // telerr=0;
           }
           else
           {
            telerr=1;
           }

        var maxLength = $("#telacrt").attr('maxlength');
        if($("#telacrt").val().length == maxLength) 
          {
            $("#telncrt").focus();
            $("#telncrt").prop("readonly",false);
          }
        } 
      else 
        {
            $("#phno_note1crt").html( '<?php echo translate('Enter_valid_Area.code(00)'); ?>' );
            $("#v_logup_btn").css("pointer-events", "none");
            telerr=1;
            $("#telncrt").prop("readonly",true);
        }

    });
 
   </script>


   <script type="text/javascript">


      $("#mobile_cc").blur(function() 
        {
        var mle=$("#phcountry_code").find("option:selected").attr("value");
        var mbl ='+'+mle+$(this).val();
        var mble = mle+$(this).val();
        var mbleno = /^(\+[0-9]{2,}[0-9]{4,}[0-9]*)(x?[0-9]{1,})?$/;///^[0-9]{10,12}$/;
        if( mbl.match(mbleno))
        {
          $("#mble_note1").html('');
          $("#mobile").val(mble);
          mblerr=0;
        } 
        else 
        {
          mblerr=1;
          $("#mobile").val();
          var txt1='<?php echo "Enter valid mobile number.";?>';
          if($("#mobile_cc").closest('.input').find('.require_alert').length)
                    {

                    } else {

                        $("#mobile_cc").closest('.input').append(''

                            +'  <div  class="require_alert" >'

                            +'      '+txt1

                            +'  </span>'

                        );

                    }  
        }
    });

</script>