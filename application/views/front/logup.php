<link rel="stylesheet" type="text/css" href="<?php echo base_url('template/front/assets/css/msdropdown/dd.css')?>" />
<script src="<?php echo base_url('template/front/assets/js/msdropdown/jquery.dd.min.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('template/front/assets/css/msdropdown/flags.css')?>" />

<style>.req_alert { color: red; position: absolute; font-size: 11px;</style>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
           <!-- <center>
                <a href="<?php echo base_url(); ?>">
                    <img class="mdl-logo" width='100%' src="<?php echo $this->crud_model->logo('home_bottom_logo'); ?>" alt="">
                </a>
            </center> -->
			<h5 class="headermodal"><?php echo translate('sign_up');?></h5> 
            <button aria-hidden="true" data-dismiss="modal" id="close_logup_modal" class="close" type="button" onclick="re();" >×</button>
        </div>

        <div class="modal-body">
            <div class="">

                <?php
                    echo form_open(base_url() . 'index.php/home/registration/add_info/', array(
                        'class' => 'ps-form--account',
                        'method' => 'post',
                        'style' => '',
                        'id' => 'logup_form'
                        ));
                        $fb_login_set   =   $this->crud_model->get_type_name_by_id('general_settings','51','value');
                        $g_login_set    =   $this->crud_model->get_type_name_by_id('general_settings','52','value');
                        $countries      =   $this->db->where(['status'=>1])->order_by('id','desc')->get('countries')->result();
                        ?> 
                        <div class="ps-form__content">
                            
                            <div class="form-group input">
                                <input type="text" placeholder="<?php echo translate('name'); ?>" name="username" class="form-control required" >
                            </div>
                               
                            <div class="form-group input">
                                <div class="row"><div class="col-md-3 col-4 pr-0">
                                    <select id="c_code1" name="c_code" class="form-control p-1" ><?php
                                        if($countries){ foreach($countries as $row){
                                            echo '<option value="'.$row->phonecode.'" data-image="'.base_url('template/front/assets/img/msdropdown/icons/blank.gif').'" data-imagecss="flag '.strtolower($row->sortname).'" data-title="'.$row->name.'">+'.$row->phonecode.'</option>';
                                        } }?>
                                    
                                    </select>
                                </div>
                                <div class="col-md-9 col-8 pl-2">   
                                    <input type="text" id="" placeholder="<?php echo translate('Mobile_number'); ?>" name="mobile" minlength="6" maxlength="10" class="form-control mobiles required only-numeric" > 
                                </div></div>
                                <div id='mobile_note' class="frm_alert col-12 pl-2 fr"></div>
                            </div>
                            
                            <div class="form-group input">
                                <input type="email" placeholder="Email address" name="email" class="form-control emails required" autocomplete="off">
                                <div id='email_note' class="frm_alert"></div>
                            </div>
                            
                            <div class="form-group input">
                                <input type="password" placeholder="<?php echo translate('password'); ?>" name="password1" class="form-control pass1 required" autocomplete="new-password" id="password1">
                                <span id="pass_error" class="req_alert"> </span>
                            </div>

                            <div class="form-group input">
                                <input type="password" placeholder="<?php echo translate('confirm_password'); ?>" name="password2" class="form-control pass2 required" id="password2">
                            </div>

                            <input type="hidden" id="mDisabled" name="mDisabled" value="0" />
                            <input type="hidden" id="eDisabled" name="eDisabled" value="0" />

                            <div class="form-group input">
                                <span id="id_of_button" class="drs-btn ps-btn ps-btn--fullwidth reg_btn logup_btn" data-ing='<?php echo translate('registering..'); ?>' type="submit"><?php echo translate('register');?> 
                                </span>
                                <input type="reset" id="re" name="" value="reset" hidden>
                            </div>

                            <p class="hvacnt">
                                <?php echo translate('already_signed Up?');?>
                                <span class="colortheme"style="cursor:pointer" data-dismiss="modal" onclick="signin()" >
                                    <?php echo translate('_click here');?>
                                </span> <?php echo translate('to_login_your_account');?>
                            </p>    
                        </div>                          
                        <?php
                    echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        
      $(".only-numeric").bind("keypress", function (e) {

          var keyCode = e.which ? e.which : e.keyCode

               

          if (!(keyCode >= 48 && keyCode <= 57)) {

            $(".error").css("display", "inline");

            return false;

          }else{

            $(".error").css("display", "none");

          }
      });
      $("#c_code1").msDropdown();
      
    });
	/*function cccode()
    { */
        $("#pcountry_code").on("change", function() 
		{
        	var a = $(this).find("option:selected").attr("value");
        	$("#pd_co").html( '+' + a);
			$("#tela").prop("readonly",false);
        	$("#teln").prop("readonly",false);
        	$("#tela").val("");
        	$("#teln").val("");
        	$("#phno_note1").html('');
        	$("#phno_note2").html('');
        	$(".reg_btn").prop("disabled", false);
        	var n = a.length;
        	//alert(n);
        	if(n == 2)
        	{
            	$("#teln").prop("maxlength",8);
        	}
        	else
        	{
            	$("#teln").prop("maxlength",7);
        	}

        });
    //}


    $("#teln").blur(function() 
    {
        var a = $(this).val();
        var phoneno =/^[0-9]{3,10}$/;
        if(a.match(phoneno))
        {
            var cc=$("#pcountry_code").val();
            var ac=$("#tela").val();
            $("#pphone").val('+'+cc+ac+a);
            $("#phno_note2").html('');
            //$(".reg_btn").removeAttr("disabled");
            var phoneno2 =/^\+?[0-9]{5,18}$/;
           if ($("#pphone").val().match(phoneno2)) 
           {
            $(".reg_btn").prop("disabled",false);
           }

        } 
        else 
        {
            $("#phno_note2").html( '<?php echo translate('Enter_valid_Ph.No(000)'); ?>' );
            $(".reg_btn").prop("disabled", true);
        }

    });

    $("#tela").blur(function() 
    {
        var a = $(this).val();
        var phoneno =/^[0-9]{1,3}$/;
        if(a.match(phoneno))
        {
            var cc=$("#pcountry_code").val();
            var ac=$("#teln").val();
            $("#pphone").val('+'+cc+a+ac);
            $("#phno_note1").html('');
            //$(".reg_btn").removeAttr("disabled");
            var phoneno2 =/^\+?[0-9]{5,18}$/;
           if ($("#pphone").val().match(phoneno2)) 
           {
            $(".reg_btn").prop("disabled",false);
           }
        } 
        else 
        {
            $("#phno_note1").html( '<?php echo translate('Enter_area_code(00)'); ?>' );
            $(".reg_btn").prop("disabled", true);
        }

    });

    function loadState1()
    {
        var x = document.getElementById("reg_country").value;
        var country_id=x;
        $.ajax({
                url: "<?php echo base_url(); ?>index.php/home/get_cities/"+country_id+"/", 
                data:country_id,
                dataType:"json",
                cache       : false,
                contentType : false,
                success: function(states)
                {
                    $('#reg_states')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">State/Province</option>')
                        ;
                    var opt = $('<option />'); 
                    $.each(states,function(idx,valu)
                    {
                        var opt = $('<option />'); 
                        opt.val(valu.code);
                        opt.text(valu.name);
                        $('#reg_states').append(opt);
                        var cCode=valu.iso_code_2;
                        $('#reg_country_code').val(cCode);
                    });
                },
            });
    }

    $(".pass2").blur(function()
    {
        var pass1 = $(".pass1").val();
        var pass2 = $(".pass2").val();
        if(pass1 !== pass2)
        {
            $("#passnote").html('<?php echo translate('password_mismatched'); ?>');
             $(".reg_btn").prop("disabled", true);
        }
        else if(pass1 == pass2)
        {
            $("#passnote").html('');
            $(".reg_btn").prop("disabled",false);
        }

    });

    

    $(".emails").blur(function()
    {
        var email = $(".emails").val(); $("#eDisabled").val(1);
        $.post("<?php echo base_url(); ?>index.php/home/exists",
        {
            <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
            email: email
        },

        function(data, status)
		{
            if(data == 'yes'){
                $("#email_note").html('* Email already registered');
                 $(".reg_btn").prop("disabled", true);
            } else if(data == 'no'){
                $("#email_note").html(''); $("#eDisabled").val(0);
                $(".reg_btn").prop("disabled", false);
            }
        });
    });
    
    $('#c_code1').on('change',function(){
        $("#mDisabled").val(1); var mobile = $(".mobiles").val();
        $.post("<?php echo base_url(); ?>index.php/home/mobile_exists",
        {
            <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
            mobile: mobile, c_code: $('#c_code1').val()
        },

        function(data, status)
        {
            if(data == 'yes'){
                $("#mobile_note").html('* Mobile already registered');
                 $(".reg_btn").prop("disabled", true);
            } else if(data == 'no'){
                $("#mobile_note").html(''); $("#mDisabled").val(0);
                $(".reg_btn").prop("disabled", false); 
            }else{
                $("#mobile_note").html(data);
                $(".reg_btn").prop("disabled", true);
                $(".mobiles").closest('div').find('.require_alert').html('');
            }
        });
    });

$(".mobiles").blur(function()
    { 
        $("#mDisabled").val(1); var mobile = $(".mobiles").val();
        $.post("<?php echo base_url(); ?>index.php/home/mobile_exists",
        {
            <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
            mobile: mobile, c_code: $('#c_code1').val()
        },

        function(data, status)
        {
            if(data == 'yes'){
                $("#mobile_note").html('* Mobile already registered');
                 $(".reg_btn").prop("disabled", true);
            } else if(data == 'no'){
                $("#mobile_note").html(''); $("#mDisabled").val(0);
                $(".reg_btn").prop("disabled", false); 
            }else{
                $("#mobile_note").html(data);
                $(".reg_btn").prop("disabled", true);
                $(".mobiles").closest('div').find('.require_alert').html('');
            }
        });
    });


    function re()
        {
           $("#re").click();
           $("#email_note").html('');
           $("#mobile_note").html('');
           $("#passnote").html('');
           $("#phno_note2").html('');
           $("#phno_note1").html('');
           $("#zipcode_note").html('');
           $("#pd_co").html('');
           $(".require_alert").remove();
           $(".required").removeAttr('style');
           $(".reg_btn").prop("disabled", false);
        }

</script>
<style type="text/css">
.frm_alert {
	color:red;  font-size: 12px;
}
.require_alert{ color:red; font-size: 12px; }
#logup_form h5 {

	font-size: 20px;
    font-weight: 400;
}
#registration .modal-header a {
	display:block;
}
#registration .modal-header {
	background: #145da2;
}
#registration .modal-header .close {
    padding: 1rem;
    margin: 0 !important;
    color: #fff;
    opacity: 1;
    font-size: 20px;
}
</style>