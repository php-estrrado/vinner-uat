<?php $userid=$this->session->userdata('user_id'); ?>
<!-- ==============================Contact us============================= -->

<div class="modal fade" id="addClientPop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <!--  <h4 class="modal-title" id="myModalLabel">Modal title</h4> -->
      </div>
      <div class="modal-body">
        <div class="reg-header">
                    <h2>Request a Quote</h2>
                </div>
                
                <?php
        echo form_open(base_url() . 'index.php/home/quote/send1', array(
            'class' => 'sky-form',
            'method' => 'post',
            'enctype' => 'multipart/form-data',
            'id' => 'sky-form4'
        ));
    ?>    
            
        <fieldset>                  
            <div class="row">
                <section class="col col-6">
                    <label class="label"><?php echo translate('name');?></label>
                    <label class="input">
                        <i class="icon-append fa fa-user"></i>
                        <input type="text" name="name" id="name" placeholder="Name" class='required' value=<?php  echo $this->crud_model->get_type_name_by_id('user',$userid,'username') ; ?>>
                    </label>
                </section>
                <section class="col col-6">
                    <label class="label"><?php echo translate('e-mail');?></label>
                    <label class="input">
                        <i class="icon-append fa fa-envelope-o"></i>
                        <input type="email" name="email" id="email" class='required' value=<?php  echo $this->crud_model->get_type_name_by_id('user',$userid,'email') ; ?>>
                    </label>
                </section>
            </div>
            
                <section id="conv_timeph0">
                <label class="label"><?php echo translate('Mobile_number');?></label>
                <label class="input">
                 <?php  $phetst= $this->crud_model->get_type_name_by_id('user',$userid,'phone') ; 
                      $phetst=str_replace("+","",$phetst); 
                ?>
                    <i class="icon-append fa fa-mobile-phone"></i>
                    <input type="text" name="conv_time" id="contime" readonly value=<?php echo $phetst;?> >
                </label>
            </section>

 <div class="row" id="conv_timeph" style="display:none"> 
  <section class="col col-6">    
  <label class="label"><?php echo translate('Phone_number');?></label>      
<label class="input ">
    <div class="input-group " id="pccode">
    <span class="input-group-addon"><i class=" fa fa-mobile-phone"></i></span>
    <select id="cou_code" name="pcount" class="form-control  col-xs-4 " onchange="pccod()">
            <option value="">Country Code</option>
            <?php
                 $cntryp=$this->db->get_where('country')->result_array();
                 foreach($cntryp as $cntryp_details)
                     {
               echo "<option data-dialcode=".$cntryp_details[id]." data-countrycode=".$cntryp_details[iso]." value='".$cntryp_details[phonecode]."'>".$cntryp_details[name]."</option>";
                      }
              ?>
    </select>
    <span class="input-group-addon" id="p_co">XX</span>        
    </div>
</label>
<label class="label">&nbsp;&nbsp;Country Code</label>
</section>

<section class="col col-2"> 
<label class="label"><br/></label>
<label class="input ">        
    <input type="text" placeholder="XX" maxlength="2" name="p_are" id="p_are" class="form-control col col-2"  readonly="readonly" >       
</label >
<label class="label" id="phnt1"><!-- Area.Code --></label>   
</section>

<section  class=" col col-4">  
<label class="label"><br/></label>
<label class="input ">
    <input type="text" placeholder="XXXXXXX" maxlength="7" name="p_pn" id="p_pn" class="form-control  col col-4"  readonly="readonly" >       
</label>   
<label class="label" id="phnt2"></label>                                
</section>

</div>

 <!-- <input hidden="hidden" type="text" name="conv_time" id="contime" > -->
 
 <script>
             
$("#contime").click(function()
{
    $("#conv_timeph0").hide();
    $("#conv_timeph").show();
    $("#contime").val("");
    $('#p_pn').addClass('required');
    $('#p_are').addClass('required');


});

    function pccod()
 {

    $("#cou_code").live("change", function() {
        var a = $(this).find("option:selected").attr("value");
        $("#p_co").html(a);
        $("#p_are").val("");
        $("#p_pn").val("");
        $("#contime").val("");
        $("#phnt1").html('');
        $("#phnt2").html('');
        $(".submittertt1").removeAttr("disabled");
        $("#p_are").prop("readonly",false);
        $("#p_pn").prop("readonly",false);
        var n = a.length;
        //alert(n);
        if(n == 2)
        {
            $("p_pn").prop("maxlength",8);
        }
        else
        {
            $("p_pn").prop("maxlength",7);
        }

    });
  }

    $("#p_pn").blur(function() {
        var a = $(this).val();
        //alert(a);
        var phoneno =/^[0-9]{3,10}$/;
        if(a.match(phoneno))
        {
            var cc=$("#cou_code").val();
            var ac=$("#p_are").val();
            $("#contime").val(cc+ac+a);
            $("#phnt2").html('');
            $(".submittertt1").removeAttr("disabled");
        } 
        else 
        {
            $("#phnt2").html( '<?php echo translate('Valid_Ph.No(000)'); ?>' );
            $(".submittertt1").attr("disabled", "disabled");
        }

    });

        $("#p_are").blur(function() {
        var a = $(this).val();
        //alert(a);
        var phoneno =/^[0-9]{1,3}$/;
        if(a.match(phoneno))
        {
            var cc=$("#cou_code").val();
            var ac=$("#p_pn").val();
            $("#contime").val(cc+a+ac);
            $("#phnt1").html('');
            $(".submittertt1").removeAttr("disabled");
        } 
        else 
        {
            $("#phnt1").html( '<?php echo translate('Area.Code(00)'); ?>' );
            $(".submittertt1").attr("disabled", "disabled");
        }

    });
</script>

            <section>
                <label class="label"><?php echo translate('subject');?></label>
                <label class="input">
                    <i class="icon-append fa fa-tag"></i>
                    <input type="text" name="subject" id="subject" class='required' >
                </label>
            </section>

            <section >
                    <label class="label"><?php echo translate('product_id');?></label>
                    <label class="input">
                        <i class=""></i>
                        
                        <input type="text" name="p_id" id="quote_pid" class='pid required' readonly="readonly" />
                    </label>
            </section>

            <section>
                <label class="label"><?php echo translate('quote');?></label>
                <label class="textarea">
                    <i class="icon-append fa fa-comment"></i>
                    <textarea rows="4" name="message" id="message" class='required' ></textarea>
                </label>
            </section>
      
        
        <footer>
            <span class="button submittertt1" data-ing='<?php echo translate('sending..'); ?>' ><?php echo translate('send_message');?></span>
        </footer>
    </form>
                
                
                
                
        <!--<form style="padding: 5px 0px 22px 0 !important;">
        <section>
            <label class="input login-input">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" placeholder="Name" name="name" class="form-control">
                    </div>
            </label>
        </section>

        <section>
            <label class="input login-input">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        <input type="tel" placeholder="Contact Number" name="tel"  class="form-control">
                </div>
            </label>
        </section>

        <section>
            <label class="input login-input">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="email" placeholder="Email Address"  name="email" class="form-control">
                </div>
            </label>
        </section>

        <section>
            <label class="input login-input">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                        <input type="text" placeholder="Name of Organization" name="Name of Organization" class="form-control">
                </div>
            </label>
        </section>

        <section>
            <label class="input login-input">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                        <input type="text" placeholder="Convenient Time to Call" name="name" class="form-control">
                </div>
            </label>
        </section>

        <section>
            <label class="input login-input">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-comments"></i></span>
                        <textarea class="qudesc form-control" placeholder="Remarks" rows="3"></textarea>
                </div>
            </label>
        </section>
        </form> -->
      </div>
      <!--<div class="modal-footer">
        <button type="button" id="qut" class="btn btn-primary">Submit</button>
      </div>-->
    </div>
  </div>
</div>



<!-- ==============================End Contact us============================= -->





<!-- ==============================Contact us============================= -->

<div class="modal fade" id="contactus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <!--  <h4 class="modal-title" id="myModalLabel">Modal title</h4> -->
      </div>
      <div class="modal-body">
        <div class="reg-header">
                    <h2>Contact Us</h2>
                </div>
                
                <?php
        echo form_open(base_url() . 'index.php/home/contact/send', array(
            'class' => 'sky-form',
            'method' => 'post',
            'enctype' => 'multipart/form-data',
            'id' => 'sky-form3'
        ));
    ?>    
            
        <fieldset>                  
            <div class="row">
                <section class="col col-6">
                    <label class="label"><?php echo translate('name');?></label>
                    <label class="input">
                        <i class="icon-append fa fa-user"></i>
                        <input type="text" name="name" id="name" class='required' >
                    </label>
                </section>
                <section class="col col-6">
                    <label class="label"><?php echo translate('e-mail');?></label>
                    <label class="input">
                        <i class="icon-append fa fa-envelope-o"></i>
                        <input type="email" name="email" id="email" class='required' >
                    </label>
                </section>
            </div>
            
            <section>
                <label class="label"><?php echo translate('subject');?></label>
                <label class="input">
                    <i class="icon-append fa fa-tag"></i>
                    <input type="text" name="subject" id="subject" class='required' >
                </label>
            </section>
            
            <section>
                <label class="label"><?php echo translate('Name_of_Organization');?></label>
                <label class="input">
                    <i class="icon-append fa fa-bank"></i>
                    <input type="text" name="org" id="org">
                </label>
            </section>
            <section>
                <label class="label"><?php echo translate('Convenient_Time_to_Call');?></label>
                <label class="input">
                    <i class="icon-append fa fa-clock-o"></i>
                    <input type="text" name="conv_time" id="contime" >
                </label>
            </section>
            
            <section>
                <label class="label"><?php echo translate('message');?></label>
                <label class="textarea">
                    <i class="icon-append fa fa-comment"></i>
                    <textarea rows="4" name="message" id="message" class='required' ></textarea>
                </label>
            </section>
      
      <div class="row">
                <section class="col col-6">
                    <label class="label"><?php echo translate('Captcha');?></label>
                    <label class="input">
                        <input type="text" name="captcha" id="name" class='required'>
                        <!-- <input type="text" name="name" id="name" class='required' > -->
                    </label>
                </section>
                <section class="col col-6" style=" margin-top: 10px;">
                <label class="label" ><?php echo translate('');?></label>
                    <label class="input">
    <font id="captImg"><?php echo $this->crud_model->captcha("new"); ?></font>
    <a href="javascript:void(0);" class=" fa fa-refresh refreshCaptcha fa-2x" style="margin-left: 10px;color: #2da5da; float:right;" ></a>
                    </label>
                </section>
    </div>
        
        <footer>
            <span class="button submittertt" data-ing='<?php echo translate('sending..'); ?>' ><?php echo translate('send_message');?></span>
        </footer>
    </form>
                
<script>
    var base_url = '<?php echo base_url(); ?>';
        $(document).ready(function(){                       
            $('.refreshCaptcha').on('click', function(){                                
                $.ajax({
            url: base_url+'index.php/home/captcha_refresh',
            success: function(data) {
              $('#captImg').html(data);
            },
            error: function(e) {
                console.log(e)
            }
        });                             
            });
        });
</script>                  
                
                
        <!--<form style="padding: 5px 0px 22px 0 !important;">
        <section>
            <label class="input login-input">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" placeholder="Name" name="name" class="form-control">
                    </div>
            </label>
        </section>

        <section>
            <label class="input login-input">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        <input type="tel" placeholder="Contact Number" name="tel"  class="form-control">
                </div>
            </label>
        </section>

        <section>
            <label class="input login-input">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="email" placeholder="Email Address"  name="email" class="form-control">
                </div>
            </label>
        </section>

        <section>
            <label class="input login-input">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                        <input type="text" placeholder="Name of Organization" name="Name of Organization" class="form-control">
                </div>
            </label>
        </section>

        <section>
            <label class="input login-input">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                        <input type="text" placeholder="Convenient Time to Call" name="name" class="form-control">
                </div>
            </label>
        </section>

        <section>
            <label class="input login-input">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-comments"></i></span>
                        <textarea class="qudesc form-control" placeholder="Remarks" rows="3"></textarea>
                </div>
            </label>
        </section>
        </form> -->
      </div>
      <!--<div class="modal-footer">
        <button type="button" id="qut" class="btn btn-primary">Submit</button>
      </div>-->
    </div>
  </div>
</div>
<script>
	var add_to_cart = '<?php echo translate('add_to_cart'); ?>';
	var valid_email = '<?php echo translate('must_be_a_valid_email_address'); ?>';
	var required = '<?php echo translate('required'); ?>';
	var sent = '<?php echo translate('message_sent!'); ?>';
	var incor = '<?php echo translate('incorrect_captcha!'); ?>';
	var required = '<?php echo translate('required'); ?>';
    var address = '<?php echo $contact_address; ?>';
	var base_url = '<?php echo base_url(); ?>';
</script>
<script src="<?php echo base_url(); ?>template/front/assets/js/custom/contact.js"></script>





<!-- ==============================End Contact us============================= -->
   
   <script>
    function set_loggers(){
        var state = check_login_stat('state');
        var name = check_login_stat('username');
        var contc = check_login_stat('carted');
        state.success(function (data) {
            if(data == 'hypass'){
                name.success(function (data) {
                    document.getElementById('loginsets').innerHTML = ''
                    +'    <li>'
                    +'        <a class="point" href="<?php echo base_url(); ?>index.php/home/profile/">'+data+'</a>'
                    +'    </li>'
                    +' <li class="dropdown ">'
                    +'  <a class="point dropdown-toggle" data-toggle="dropdown"><?php echo translate('Settings');?><span class="caret"></span></a>'
                    +'<div class="dropdown-content " style="z-index: 9999;width: 100px;height: 100px;left: auto;">'
                    +'<ul style="float:left;">'
                    +'<li style="color:#007AFF;float: none;list-style: none;"><a class="" href="<?php echo base_url(); ?>index.php/home/profile/"><?php echo translate('profile');?></a></li>'
                    +'<li style="color:#007AFF;float: none;list-style: none;"><a class="" href="<?php echo base_url(); ?>index.php/home/logout/"><?php echo translate('logout');?></a></li>'
                    +'</ul></div></li>'
                    +'';
                });
                if($('body').find('.shopping-cart').length){
                    set_cart_form();
                    $(".guest").remove();
                }

                contc.success(function (data) {
                  document.getElementById('counter').innerHTML =data;
                });
                
                ajax_load(base_url+'index.php/home/cart/added_list/','added_list');

            } else {
                document.getElementById('loginsets').innerHTML = ''
				<?php
					if($vendor_system == 'ok'){
				?>
                +'    <li>'
                +'        <a data-toggle="modal" data-target="#v_registration" class="dropdown-toggle">Sell With Us</a>'
                +'    </li>'
				<?php
					}
				?>
                +'    <li>'
                +'        <a data-toggle="modal" data-target="#login" class="dropdown-toggle" data-backdrop="static" data-keyboard="false">Login / Register</a>'
                +'    </li>'
                +'    <li>'
                +'';
            }
        });  
        //onclick="ajax_load('+"'<?php echo base_url(); ?>index.php/home/login_set/login','login')"+';"
        var cart = '';
        if($('body').find('.shopping-cart').length){
            cart = 'cart';
        }
         ajax_load('<?php echo base_url(); ?>index.php/home/registration/','ajvlup');
        ajax_load('<?php echo base_url(); ?>index.php/home/vendor_logup/registration/','ajvlup');
        ajax_load('<?php echo base_url(); ?>index.php/home/login_set/registration/'+cart,'ajlup');
        ajax_load('<?php echo base_url(); ?>index.php/home/login_set/login/'+cart,'ajlin');
		
    }

    function check_login_stat(thing){
        return $.ajax({
            url: '<?php echo base_url(); ?>index.php/home/check_login/'+thing
        });
    }


    function set_cart_form(){
        check_login_stat('langlat').success(function (data) { $('#langlat').val(data); });
        check_login_stat('username').success(function (data) { $('#name').val(data); });
        check_login_stat('email').success(function (data) { $('#email').val(data); });
        check_login_stat('surname').success(function (data) { $('#surname').val(data); });
        check_login_stat('phone').success(function (data) { $('#phone').val(data); });
        check_login_stat('address1').success(function (data) { $('#address_1').val(data); });
        check_login_stat('address2').success(function (data) { $('#address_2').val(data); });
        check_login_stat('city').success(function (data) { $('#city').val(data); });
        check_login_stat('zip').success(function (data) { $('#zip').val(data); });
    }
	
    $( document ).ready(function() {
        set_loggers();
		<?php 
			$a = $this->session->flashdata('alert');
			if(isset($a)){ 
		?>
			<?php if($this->session->flashdata('alert') == 'successful_signup'){ ?>
                setTimeout(function(){ sound('successful_logup');}, 800);  
				setTimeout(function(){ notify('<?php echo translate('you_are_registered_successfully'); ?>','success','bottom','right');}, 800);
			<?php } ?>
			<?php if($this->session->flashdata('alert') == 'successful_signin'){ ?>
				setTimeout(function(){ sound('successful_login');}, 800);  
                setTimeout(function(){ notify('<?php echo translate('you_logged_in_successfully'); ?>','success','bottom','right');}, 800);
			<?php } ?>
            <?php if($this->session->flashdata('alert') == 'successful_signout'){ ?>
                setTimeout(function(){ sound('successful_logout');}, 800);  
                setTimeout(function(){ notify('<?php echo translate('you_logged_out_successfully'); ?>','success','bottom','right');}, 800);
            <?php } ?>
            <?php if($this->session->flashdata('alert') == 'unsuccessful_stripe'){ ?>
                setTimeout(function(){ sound('successful_login');}, 800);  
                setTimeout(function(){ notify('<?php echo translate('something_wrong_with_stripe,_try_again!'); ?>','success','bottom','right');}, 800);
            <?php } ?>
		<?php } ?>
    });

    var base_url = '<?php echo base_url(); ?>';
    function register(){
        setTimeout( function(){ 
            $('#regiss').click();
        }
        , 400 );

        $("#fail").hide();
    }

    function signin(){
        setTimeout( function(){ 
            $('#loginss').click();
        }
        , 400 );
    }

    function vend_logup(){
        setTimeout( function(){ 
            $('#v_regiss').click();
        }
        , 5000 );
    }

</script>

<form id="cart_form_singl">
<input type="hidden" name="color" value="">
<input type="hidden" name="qty" value="1">
</form>

<!-- JS Global Compulsory -->
<script src="<?php echo base_url(); ?>template/front/assets/plugins/jquery/jquery-migrate.min.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- JS Implementing Plugins -->
<script src="<?php echo base_url(); ?>template/front/assets/plugins/back-to-top.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/owl-carousel/owl-carousel/owl.carousel.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/scrollbar/src/jquery.mousewheel.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/scrollbar/src/perfect-scrollbar.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/noUiSlider/jquery.nouislider.full.min.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/jquery.parallax.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/jquery-steps/build/jquery.steps.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/sky-forms/version-2.0.1/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/sky-forms/version-2.0.1/js/jquery-ui.min.js"></script>


<script src="<?php echo base_url(); ?>template/front/assets/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<!-- JS Customization -->
<script src="<?php echo base_url(); ?>template/front/assets/js/custom.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/js/plugins/stepWizard.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/js/forms/page_login.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/js/forms/product-quantity.js"></script>

<!-- JS Page Level -->
<script src="<?php echo base_url(); ?>template/front/assets/js/shop.app.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/js/app.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/js/plugins/owl-carousel.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/js/plugins/revolution-slider.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/js/plugins/datepicker.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/counter/waypoints.min.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/counter/jquery.counterup.min.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/js/pages/page_contacts.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/flexslider/jquery.flexslider-min.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/js/plugins/parallax-slider.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/parallax-slider/js/modernizr.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/parallax-slider/js/jquery.cslider.js"></script>

<script src="<?php echo base_url(); ?>template/front/assets/plugins/ionrangeslider/js/ion.rangeSlider.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/js/plugins/bootstrap-notify.min.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/js/plugins/fancy-box.js"></script>

<script src="<?php echo base_url(); ?>template/front/assets/js/ajax_method.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/image-hover/js/modernizr.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/image-hover/js/touch.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/dropdown/js/modernizr.custom.63321.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/dropdown/js/jquery.dropdown.js"></script>
<!--Chosen [ OPTIONAL ]-->
<script src="<?php echo base_url(); ?>template/back/plugins/chosen/chosen.jquery.min.js"></script>

<script>
	$('html, body').css({
		'overflow': 'hidden',
		'height': '100%'
	});
	
    jQuery(document).ready(function() {
        App.init();  
        App.initParallaxBg();
        OwlCarousel.initOwlCarousel();
        RevolutionSlider.initRSfullWidth();
        ParallaxSlider.initParallaxSlider(); 
        FancyBox.initFancybox(); 
    });
	
    $(document).ready(function() {
        ajax_load('<?php echo base_url(); ?>index.php/home/cart/added_list/','added_list');
    	<?php
			if($this->session->userdata('user_login') == 'yes'){
		?>
		setInterval(session_check, 6000);
		function session_check(){
			$.ajax({
				url: '<?php echo base_url(); ?>index.php/home/is_logged/',
				success: function(data) {
					if(data == 'yah!good'){}
					else if (data == 'nope!bad') {
						location.replace('<?php echo base_url(); ?>');
					}
				},
				error: function(e) {
					console.log(e)
				}
			});
		}
		<?php
			}
		?>
		// Hide it after 3 seconds
        setTimeout(function(){
            $('html, body').css({
                'overflow': 'auto',
                'height': 'auto'
            });
            $('#preloader').fadeOut("slow");
        }, 1200);
        setTimeout(function(){
            if($('#layerslider').length){
                start_slider();
            }
            //$('#chatContainer').show('slow');
        }, 800);
		
		$("#content-2").mCustomScrollbar({
			theme:"rounded-dots",
			scrollInertia:400
		});
    });

    <?php
        $volume = $this->crud_model->get_type_name_by_id('general_settings','50','value');
        if($this->crud_model->get_type_name_by_id('general_settings','49','value') == 'ok'){
    ?>
        function sound(type){
            document.getElementById(type).volume = <?php if($volume == '10'){ echo 1 ; }else{echo '0.'.round($volume); } ?>;
            document.getElementById(type).play();
        }
    <?php
        } else {
    ?>
        function sound(type){}
    <?php
        }
    ?>
</script>
<?php
    $audios = scandir('uploads/audio/home/');
    foreach ($audios as $row) {
        if($row !== '' && $row !== '.' && $row !== '..'){
            $row = str_replace('.mp3', '', $row);
?>
<audio style='display:none;' id='<?php echo $row; ?>' ><source type="audio/mpeg" src="<?php echo base_url(); ?>uploads/audio/home/<?php echo $row; ?>.mp3"></audio>
<?php
        }
    }
?>
<!--[if lt IE 9]>
    <script src="<?php echo base_url(); ?>template/front/assets/plugins/respond.js"></script>
    <script src="<?php echo base_url(); ?>template/front/assets/plugins/html5shiv.js"></script>
    <script src="<?php echo base_url(); ?>template/front/assets/js/plugins/placeholder-IE-fixes.js"></script>
<![endif]-->

<script type="text/javascript">
//product id to quote form
       $('.req_fr_prdct').click(function()
        {
         
         var product= $(this).data('pid');
          
         $("#quote_pid").val(product);

          });
   
  </script>
</body>
</html> 