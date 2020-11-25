

<!--================    QUOTE POP UP     ======================================-->

<div class="modal fade" id="addClientPop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <!--  <h4 class="modal-title" id="myModalLabel">Modal title</h4> -->
      </div>
      <div class="modal-body">
        <div class="reg-header">
                    <h2>Request for Product</h2>
                </div>
        <form style="padding: 5px 0px 22px 0 !important;">
        <section>
            <label class="input login-input">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" placeholder="Name" name="name" id="quoteid" class="form-control">
                    </div>
            </label>
        </section>

        <section>
            <label class="input login-input">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        <input type="tel" placeholder="Contact Number" name="tel" id="quotetel" class="form-control">
                </div>
            </label>
        </section>

        <section>
            <label class="input login-input">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="email" placeholder="Email Address" id="quotemail" name="email" class="form-control">
                </div>
            </label>
        </section>

        <section>
            <label class="input login-input">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <textarea class="qudesc form-control" id="quotetext" rows="3"></textarea>
                </div>
            </label>
        </section>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="qut" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
                                $('#qut').on('click',function(){
                                    var txt = $(this).html();
                                    var qid = $('#quoteid').val();
                                    var qtel=$('#quotetel').val();
                                    var qmail=$('#quotemail').val();
                                    var qtext=$('#quotetext').val();
                                    $('#qt_id').val(qid);
                                     $('#qt_tel').val(qtel);
                                     $('#qt_mail').val(qmail);
                                     $('#qt_text').val(qtext);
                                    
                                    var form = $('#quote_set');
                                    var formdata = false;
                                    if (window.FormData){
                                        formdata = new FormData(form[0]);
                                    }
                                    var datas = formdata ? formdata : form.serialize();
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>index.php/home/quote_submit/',
                                        type        : 'POST', // form submit method get/post
                                        dataType    : 'html', // request type html/json/xml
                                        data        : datas, // serialize form data 
                                        cache       : false,
                                        contentType : false,
                                        processData : false,
                                        beforeSend: function() {
                                            $(this).html("<?php echo translate('submiting..'); ?>");
                                        },
                                        success: function(result){
                                            if(result == 'nope'){
                                                notify("<?php echo translate('try_again'); ?>",'warning','bottom','right');
                                            } else {
                                                var re = result.split(':-:-:');
                                                var ty = re[0];
                                                var ts = re[1];
                                                $("#coupon_report").fadeOut();
                                                notify("<?php echo translate('request_received!_will_get_back_to_you_shortly'); ?>",'success','bottom','right');
                                                if(ty == 'total'){
                                                    $(".coupon_disp").show();
                                                    $("#disco").html(re[2]);
                                                }
                                                $("#coupon_report").html('<h3>'+ts+'</h3>');
                                                $("#coupon_report").fadeIn();
                                                /*update_calc_cart();
                                                update_prices();*/
                                            }
                                        }
                                    });
                                });
      
                                
                            </script>
                            
<?php
    echo form_open('', array(
        'method' => 'post',
        'id' => 'quote_set'
    ));
?>
<input type="hidden" id="qt_id" name="quote_id">
<input type="hidden" id="qt_tel" name="quote_tel">
<input type="hidden" id="qt_mail" name="quote_mail">
<input type="hidden" id="qt_text" name="quote_text">
</form>
<!--=====================/QUOTE POP UP=====================================-->
   

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
      
        
        <footer>
            <span class="button submittertt" data-ing='<?php echo translate('sending..'); ?>' ><?php echo translate('send_message');?></span>
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
        state.success(function (data) {
            if(data == 'hypass'){
                name.success(function (data) {
                    document.getElementById('loginsets').innerHTML = ''
                    +'    <li>'
                    +'        <a class="point" href="<?php echo base_url(); ?>index.php/home/profile/">'+data+'</a>'
                    +'    </li>'
                    +'    <li>'
                    +'       <a class="point" href="<?php echo base_url(); ?>index.php/home/logout/"><?php echo translate('logout');?></a>'
                    +'    </li>'
                    +'';
                });
                if($('body').find('.shopping-cart').length){
                    set_cart_form();
                    $(".guest").remove();
                }
            } else {
                document.getElementById('loginsets').innerHTML = ''
				<?php
					if($vendor_system == 'ok'){
				?>
                +'    <li>'
                +'        <a data-toggle="modal" data-target="#v_registration" class="point">Sell With Us</a>'
                +'    </li>'
				<?php
					}
				?>
                +'    <li>'
                +'        <a data-toggle="modal" data-target="#login" class="point">Login / Register</a>'
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

</body>
</html> 