<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="300">
    <title><?php echo translate('login');?> | <?php echo $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;?></title>
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,700,300,500" rel="stylesheet" type="text/css">
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
     <img src="<?php echo $this->crud_model->logo('admin_login_logo'); ?>" class="log_iconvr" style="margin: 20px;">
    <div class="log_iconvrs"><h3 >Sellers</h3></div>
</div>


<div class="row content ">
      <center>
      <div class="col-sm-6 signupcont">
            <!--Reg Block-->
            <div class="">
                <div class="reg-block-header">
                    <h2><?php echo translate('be_a_seller');?></h2>
                    <p style="font-weight:300 !important;"><?php echo translate('already_a_seller?');?> <?php echo translate('click'); ?> <a class="color-purple" href="<?php echo base_url(); ?>index.php/vendor/sell" ><?php echo translate('sign_in');?></a> 
                    <?php echo translate('to_login_your_account');?></p>
                </div>

        <?php
                    echo form_open(base_url() . 'index.php/home/vendor_logup/add_info/', array(
                        'class' => 'log-reg-v3 sky-form vlogup',
                        'method' => 'post',
                        'style' => 'padding:30px !important;',
                        'id' => 'login_form',
                        'name' =>vlog
                    ));
                ?>                            

                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" placeholder="<?php echo translate('name'); ?>" name="name" class="form-control" >
                            </div>
                        </label>
                    </section>                   

                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-university"></i></span>
                                <input type="text" placeholder="<?php echo translate('company'); ?>" name="company" class="form-control" >
                            </div>
                        </label>
                    </section>                     

                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" placeholder="<?php echo translate('email_address'); ?>" name="email" class="form-control" >
                            </div>
                        </label>
                    </section>

                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="password" placeholder="<?php echo translate('password'); ?>" id="pass1" name="password1" class="form-control" >
                                <span class="input-group-addon" style="cursor: pointer;" >
                                <i title = "show password" class="fa fa-eye" onclick="shpas()" id="shp"></i></span>
                            </div>    
                        </label>
                    </section>

                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="password" placeholder="<?php echo translate('confirm_password'); ?>" name="password2" class="form-control" >
                            </div>    
                        <div id='pass_note'></div> 
                        </label>
                    </section>   

                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-desktop"></i></span>
                                <input type="text" placeholder="<?php echo translate('display_name'); ?>" name="display_name" class="form-control" >
                            </div>    
                        </label>
                    </section>

  <input type='hidden'   placeholder="Contact Number" name="tel" id="tel" class="form-control" required  value="" >
<section>
 <div class="">
<label>
<div class="row phca " >

    <div class="col col-sm-5">  
<span class="input-group-addon" style="float: left; padding: 8px;"><i class="fa fa-phone"></i></span>
<select id="phcountry_code" name="phcountryc" class="form-control col-sm-3 pr" onchange="crtph()" style="font-size:12px;font-weight: 400; float: left; width: 74%">
    <option value="">Country Code</option>
           <?php
            $cntryp=$this->db->get_where('country')->result_array();
                foreach($cntryp as $cntryp_details)
                    {
        echo "<option data-dialcode=".$cntryp_details[id]." data-countrycode=".$cntryp_details[iso]." value='".$cntryp_details[phonecode]."'>".$cntryp_details[name]."</option>";
                    }
            ?>
</select>
</div>
        <div class="col col-sm-2">
        <input type="text" class=" form-control " id="d_co" readonly="readonly" value="+XX"></div>
<!-- </div> -->
<div class=" col col-sm-2"  ><input type="text" placeholder="XX" maxlength="2" name="pharcode" id="telacrt" class="form-control pr required  readonly="readonly" ></div>
<div class="col col-sm-3" ><input type="text" placeholder="XXXXXXX" maxlength="7" name="ph" id="telncrt" class="form-control pr"  readonly="readonly" ></div>
</div>
<div class="row phca">
<div class="col col-sm-5" ></div>
<div class="col col-sm-4" style="color:red; text-align: right;" id='phno_note1crt'></div>
<div class="col col-sm-3" style="color:red;" id='phno_note2crt'></div>
</div>

</label>
  </div> </section>
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

<!--  <div class="row"> -->
           <section class="">
                <label class="input login-input no-border-top">
                   <input type="text" placeholder="Captcha" name="captcha" id="captcha" class="form-control " required >  
                </label>    
              <label class="input " >
                      <font id="captImg"><?php echo $this->crud_model->captcha("new"); ?></font>
                      <a href="javascript:void(0);" onclick="refre()" class=" fa fa-refresh refreshCaptcha fa-2x" style="margin-left: 10px;color: #2da5da;" ></a>
              </label>    
          </section>
           <!--  <section class="">
              <label class="input" style="margin-top: 20px;">
                 <font id="captImg"><?php echo $this->crud_model->captcha("new"); ?></font>
                 <a href="javascript:void(0);" class=" fa fa-refresh refreshCaptcha fa-2x" style="margin-left: 10px;color: #2da5da;" ></a>
              </label>
            </section>
          <div id="captImg"><?php echo $this->crud_model->captcha("new"); ?></div>
                 <a href="javascript:void(0);" id="refreshCaptcha" class=" fa fa-refresh refreshCaptcha fa-2x" style="margin-left: 10px;color: #2da5da;" ></a>
             -->

<!-- </div> -->

<script>
    var base_url = '<?php echo base_url(); ?>';

      function refre()
      {
        $.ajax({
            url: base_url+'index.php/home/captcha_refresh',
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

                <!--  <div class="row margin-bottom-5">
                        <div class="col-xs-8"></div>
                        <div class="col-xs-4 text-right">
                            <div class="btn-u btn-u-cust btn-block margin-bottom-20 reg_btn v_logup_btn"  onclick="regsubmit()" data-ing='<?php echo translate('registering..'); ?>' data-msg="" type="submit">
                              <?php echo translate('join_now');?>
                            </div>
                        </div>
                    </div> -->


      <div class="registration-button-block">
       <span type="submit" class="btn-u btn-u-cust btn-block reg_btn v_logup_btn" style="cursor: pointer;"  data-ing='<?php echo translate('registering..'); ?>' >Register Now</span>

      </div>

      <!-- <button type="Submit">Submit</button> -->
                </form>

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
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
      background-color: #458FD2;
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
     /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
    
.log_iconvr
  {
    width: 240px;
    float: left;
    margin-left: 38px;
    margin-top: 3px;
  }
.log_iconvrs
  {
  float: left;
    margin-left: -12px;
    margin-top: 14px;
    color: #fff;
  }

.signupcont
{
  margin: 25px !important;;
 float: none !important;
}

.registration-button-block 
{
  max-width: 270px;
  margin: 20px auto;
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
  float: left;
  font-size: 14px;
}

 .registration-button-block span {
  width: 178px;
  background: #458FD2;
  border-radius: 3px;
  font-size: 16px;
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


$(".v_logup_btn").click(function(){
        var here = $(this); // alert div for show alert message
        var form = here.closest('form');
        var can = '';
        var ing = here.data('ing');
        var msg = here.data('msg');
        var prv = here.html();
        var formdata = false;
        if (window.FormData){
            formdata = new FormData(form[0]);
        }
         
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

                  window.location.replace(base_url+'index.php/vendor/sell/regsu');

                   $("#topcontrol4").fadeout();
                    //notify(logup_success,'success','bottom','right'); 
                    $('#suss').fadein();
                    sound('successful_logup');      
                } else {
                    //$("#topcontrol4").fadein();
                    $("#topcontrol4").fadeIn();
                    $("#alertmesg").html(data);
                    sound('unsuccessful_logup');
                    $("#topcontrol4").fadeout("0");
                }
            },
            error: function(e) {
                console.log(e)
            }
        });

});


 
 
</script>


 <script>
          function   cuph()   
          {
            $('.phca').show();
            $('#tel').hide();
            $("#bt_submit").css("pointer-events", "none");
            $(".pr").addClass("requried");
            $(".pr").attr("requried", "requried");

          }         
    function crtph()
    {
       // $("#phcountry_code").on("change", function() {
        var a = $("#phcountry_code").find("option:selected").attr("value");
        if(a != "")
      {
        $("#d_co").val( '+' + a);
        $("#telacrt").val("");
        $("#telncrt").val("");
        $("#tel").val("");
        $("#phno_note1crt").html('');
        $("#phno_note2crt").html('');
        $("#bt_submit").css("pointer-events", "none");
        $("#telacrt").prop("readonly",false);
        $("#telncrt").prop("readonly",false);
        var n = a.length;
        //alert(n);
        if(n == 2)
        {
            $("#telncrt").prop("maxlength",8);
        }
        else
        {
            $("#telncrt").prop("maxlength",7);
        }
      }
      else
      {
        $("#d_co").val( '+XX');
        $("#telacrt").val("");
        $("#telncrt").val("");
        $("#telacrt").prop("readonly",true);
        $("#telncrt").prop("readonly",true);
      }
    //  });
    }
    $("#telncrt").blur(function() {
        var a = $(this).val();
        //alert(a);
        var phoneno =/^[0-9]{3,10}$/;
        if(a.match(phoneno))
        {
            var cc=$("#phcountry_code").val();
            var ac=$("#telacrt").val();
            $("#tel").val(cc+ac+a);
            $("#phno_note2crt").html('');
           // $(".reg_btn").removeAttr("disabled");
           var phoneno2 =/^[0-9]{5,15}$/;
           if ($("#tel").val().match(phoneno2)) 
           {
           $("#v_logup_btn").css("pointer-events", "auto");
           }

        } 
        else 
        {
            $("#phno_note2crt").html( '<?php echo translate('Enter_valid_Ph.No(000)'); ?>' );
            //$(".reg_btn").attr("disabled", "disabled");
            $("#v_logup_btn").css("pointer-events", "none");
        }

    });
        $("#telacrt").change(function() {
        var a = $(this).val();
        //alert(a);
        var phoneno =/^[0-9]{1,3}$/;
        if(a.match(phoneno))
        {
            var cc=$("#phcountry_code").val();
            var ac=$("#telncrt").val();
            $("#tel").val(cc+a+ac);
            $("#phno_note1crt").html('');
            //$(".reg_btn").removeAttr("disabled");
            var phoneno2 =/^[0-9]{5,15}$/;
           if ($("#tel").val().match(phoneno2)) 
           {
           $("#v_logup_btn").css("pointer-events", "auto");
           }

    var maxLength = $("#telacrt").attr('maxlength');
    if($("#telacrt").val().length == maxLength) 
    {
         $("#telncrt").focus();
    }
        } 
        else 
        {
            $("#phno_note1crt").html( '<?php echo translate('Enter_valid_Area.code(00)'); ?>' );
            //$(".reg_btn").attr("disabled", "disabled");
            $("#v_logup_btn").css("pointer-events", "none");
        }

    });
 
   </script>