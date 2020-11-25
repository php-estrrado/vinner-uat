<?php 
	$userid=$this->session->userdata('user_id'); 
?>



    <script>
      var add_to_cart = '<?php echo translate('add_to_cart'); ?>';
      var valid_email = '<?php echo translate('must_be_a_valid_email_address'); ?>';
      var required = '<?php echo translate('required'); ?>';
      var sent = '<?php echo translate('message_sent!'); ?>';
      var incor = '<?php echo translate('incorrect_captcha!'); ?>';
      var required = '<?php echo translate('required'); ?>';
      //var address = '<?php echo $contact_address; ?>';
      var base_url = '<?php echo base_url(); ?>';
    </script>

    <script>
      function set_loggers()
      {   
          var state   = check_login_stat('state');
          var name    = check_login_stat('username');
          var contc   = check_login_stat('carted');
          state.success(function (data) 
          {
              if(data == 'hypass')
              {
                  name.success(function (data) 
                  {
					  $(".loginsets").html('<a href="<?php echo base_url('home/profile/');?>">Profile</a>'
										   +'<a href="<?php echo base_url('home/logout/');?>">Logout</a>');
                      
                  });
                  
                  var wished = check_login_stat('wished');
                  wished.success(function (data)
                  {
                      if(data>0)
                      {
                          $(".count_wished").html(data);
                      }
                  });
                  /*
                  if($('body').find('.shopping-cart').length)
                  {
                      if ($("#signedin").val()=="") 
                        { location.reload(); }
                      else { set_cart_form();}
                      $(".guest").remove();
                  }
                  */
                  
				  ajax_load(base_url+'home/cart/added_list/','added_list');
				  ajax_load(base_url+'home/cart/added_list_mobile/','mobile_added_list');
              } 
              else 
              {
				  $(".loginsets").html('<a href="#" data-toggle="modal" data-target="#login" data-backdrop="static" data-keyboard="false">Login</a>'
                  +'<a href="#" data-dismiss="modal" onclick="register()">Register</a>');
              }
          });  
          
          var cart = '';
          if($('body').find('.shopping-cart').length)
          {
              cart = 'cart';
          }
          
          ajax_load('<?php echo base_url(); ?>index.php/home/login_set/registration/'+cart,'ajlup');
          ajax_load('<?php echo base_url(); ?>index.php/home/login_set/login/'+cart,'ajlin');
      }

      function check_login_stat(thing)
      {
          return $.ajax({
              url: '<?php echo base_url(); ?>home/check_login/'+thing
          });
      }


      function set_cart_form()
      {
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

      

    
      $(document).ready(function() 
      {
          set_loggers();
          <?php 
            $a = $this->session->flashdata('alert');
            if(isset($a))
            { 
             if($this->session->flashdata('alert') == 'successful_signup')
              { 
                ?>
                //setTimeout(function(){ sound('successful_logup');}, 800);  
                setTimeout(function(){ notify('<?php echo translate('you_are_registered_successfully'); ?>','success','bottom','right');}, 800);
                <?php 
              } 
              if($this->session->flashdata('alert') == 'successful_signin')
              { ?>
                //setTimeout(function(){ sound('successful_login');}, 800);  
                setTimeout(function(){ notify('<?php echo translate('you_logged_in_successfully'); ?>','success','bottom','right');}, 800);
                <?php 
              }  
              if($this->session->flashdata('alert') == 'successful_signout')
              { ?>
                //setTimeout(function(){ sound('successful_logout');}, 800);  
                setTimeout(function(){ notify('<?php echo translate('you_logged_out_successfully'); ?>','success','bottom','right');}, 800);
                <?php 
              } 
              if($this->session->flashdata('alert') == 'unsuccessful_stripe')
              { ?>
                //setTimeout(function(){ sound('successful_login');}, 800);  
                setTimeout(function(){ notify('<?php echo translate('something_wrong_with_stripe,_try_again!'); ?>','success','bottom','right');}, 800);
                <?php 
              } 
			  if($this->session->flashdata('alert') == 'compare_remove')
              { ?>
                setTimeout(function(){ notify(compare_remove,'info','bottom','right');}, 800);
                <?php 
              } 
		  	  if($this->session->flashdata('alert') == 'compare_add')
              { ?>
                setTimeout(function(){ notify(compare_add,'info','bottom','right');}, 800);
                <?php 
              } 
		  	  ?>
              <?php 
            } 
          ?>
      });

      function register()
      {
          setTimeout( function(){ 
              $('#regiss').click();
          }
          , 400 );
		  $("#re").click();
          $("#email_note").html('');
		  $(".require_alert").remove();
		  $(".required").removeAttr('style');
		  $(".reg_btn").removeAttr("disabled");	
          $("#fail").hide();
      }

      function signin()
      {
          setTimeout( function(){ 
              $('#loginss').click();
          }
          , 400 );
      }

    </script>



<form id="cart_form_singl">
    <input type="hidden" name="color" value="">
    <input type="hidden" name="qty" value="1">
</form>

    <!-- JS Global Compulsory -->

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>template/drsnew/plugins/owl-carousel/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>template/drsnew/plugins/bootstrap4/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>template/drsnew/plugins/imagesloaded.pkgd.js"></script>
    <script src="<?php echo base_url(); ?>template/drsnew/plugins/masonry.pkgd.min.js"></script>
    <script src="<?php echo base_url(); ?>template/drsnew/plugins/isotope.pkgd.min.js"></script>
    <script src="<?php echo base_url(); ?>template/drsnew/plugins/jquery.matchHeight-min.js"></script>
    <script src="<?php echo base_url(); ?>template/drsnew/plugins/slick/slick/slick.min.js"></script>
    <script src="<?php echo base_url(); ?>template/drsnew/plugins/jquery-bar-rating/dist/jquery.barrating.min.js"></script>
    <script src="<?php echo base_url(); ?>template/drsnew/plugins/slick-animation.min.js"></script>
    <script src="<?php echo base_url(); ?>template/drsnew/plugins/lightGallery-master/dist/js/lightgallery-all.min.js"></script>
    <script src="<?php echo base_url(); ?>template/drsnew/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>template/drsnew/plugins/sticky-sidebar/dist/sticky-sidebar.min.js"></script>
    <script src="<?php echo base_url(); ?>template/drsnew/plugins/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>template/drsnew/plugins/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>template/drsnew/plugins/gmap3.min.js"></script>
    <script src="<?php echo base_url(); ?>template/drsnew/js/main.js"></script>
	<script src="<?php echo base_url(); ?>template/drsnew/js/bootstrap.js"></script>
	<!--<script src="<?php //echo base_url(); ?>template/drsnew/js/datatable.bs4.min.js"></script>-->
	<script src="<?php echo base_url(); ?>template/drsnew/js/datatable.min.js"></script>

	<!-- JS Customization -->
    <script src="<?php echo base_url(); ?>template/front/assets/js/forms/product-quantity.js"></script>
    <script src="<?php echo base_url(); ?>template/front/assets/js/share/jquery.share.js"></script>
	<script src="<?php echo base_url(); ?>template/front/assets/js/plugins/bootstrap-notify.min.js"></script>
    <script src="<?php echo base_url(); ?>template/front/assets/js/ajax_method.js"></script>
        <script src="<?php echo base_url('template/front/assets/plugins/bootbox/bootbox.min.js'); ?>"></script>


<script>
	
	
    // jQuery(document).ready(function() 
    // {
    //     App.init();  
    //     App.initParallaxBg();
    //     OwlCarousel.initOwlCarousel();
    //     RevolutionSlider.initRSfullWidth();
    //     ParallaxSlider.initParallaxSlider(); 
    //     FancyBox.initFancybox(); 
    // });
	

	$(document).ready(function() 
    {
	  $("i.icon-eye").parents('li').css("display", "none");	
      ajax_load('<?php echo base_url(); ?>home/cart/added_list/','added_list');
	  ajax_load('<?php echo base_url(); ?>home/cart/added_list_mobile/','mobile_added_list');
    	<?php
			 if($this->session->userdata('user_login') == 'yes')
             {
		      ?>
        		setInterval(session_check, 6000);
        		function session_check()
            	{
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
		

             setTimeout(function()
			 {
                   /*$('html, body').css({
                     'overflow': 'auto',
                     'height': 'auto'
                  });*/
                 $('#preloader').fadeOut("slow");
               }, 1200);
    });
    
</script>


</body>
</html> 