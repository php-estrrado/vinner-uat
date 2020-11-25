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
                        $fb_login_set = $this->crud_model->get_type_name_by_id('general_settings','51','value');
                        $g_login_set = $this->crud_model->get_type_name_by_id('general_settings','52','value');
                        ?> 
                        <div class="ps-form__content">
                            
                            <div class="form-group input">
                                <input type="text" placeholder="<?php echo translate('name'); ?>" name="username" class="form-control required" >
                            </div>
                                
                            <div class="form-group input">
                                <input type="text" id="" placeholder="<?php echo translate('Mobile_number'); ?>" name="mobile" class="form-control mobiles required" > 
                                <div id='mobile_note' class="frm_alert"></div>
                            </div>
                            
                            <div class="form-group input">
                                <input type="email" placeholder="Email address" name="email" class="form-control emails required" autocomplete="off">
                                <div id='email_note' class="frm_alert"></div>
                            </div>
                            
                            <div class="form-group input">
                                <input type="password" placeholder="<?php echo translate('password'); ?>" name="password1" class="form-control pass1 required" autocomplete="new-password">
                            </div>

                            <div class="form-group input">
                                <input type="password" placeholder="<?php echo translate('confirm_password'); ?>" name="password2" class="form-control pass2 required" >
                            </div>

                            

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
        	$(".reg_btn").removeAttr("disabled");
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
            $(".reg_btn").removeAttr("disabled");
           }

        } 
        else 
        {
            $("#phno_note2").html( '<?php echo translate('Enter_valid_Ph.No(000)'); ?>' );
            $(".reg_btn").attr("disabled", "disabled");
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
            $(".reg_btn").removeAttr("disabled");
           }
        } 
        else 
        {
            $("#phno_note1").html( '<?php echo translate('Enter_area_code(00)'); ?>' );
            $(".reg_btn").attr("disabled", "disabled");
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
             $(".reg_btn").attr("disabled", "disabled");
        }
        else if(pass1 == pass2)
        {
            $("#passnote").html('');
            $(".reg_btn").removeAttr("disabled");
        }

    });

    

    $(".emails").blur(function()
    {
        var email = $(".emails").val();
        $.post("<?php echo base_url(); ?>index.php/home/exists",
        {
            <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
            email: email
        },

        function(data, status)
		{
            if(data == 'yes'){
                $("#email_note").html('* Email already registered');
                 $(".reg_btn").attr("disabled", "disabled");
            } else if(data == 'no'){
                $("#email_note").html('');
                $(".reg_btn").removeAttr("disabled");
            }
        });
    });

$(".mobiles").blur(function()
    {
        var mobile = $(".mobiles").val();
        $.post("<?php echo base_url(); ?>index.php/home/mobile_exists",
        {
            <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
            mobile: mobile
        },

        function(data, status)
        {
            if(data == 'yes'){
                $("#mobile_note").html('* Mobile already registered');
                 $(".reg_btn").attr("disabled", "disabled");
            } else if(data == 'no'){
                $("#mobile_note").html('');
                $(".reg_btn").removeAttr("disabled");
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
           $(".reg_btn").removeAttr("disabled");
        }

</script>
<style type="text/css">
.frm_alert {
	color:red;
}
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