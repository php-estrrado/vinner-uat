    

   <!-- <div class="ps-newsletter">
      <div class="container">
        <?php
       //    echo form_open(base_url().'home/subscribe', array('method' => 'post','id' => 'news_letter_form','class' => 'ps-form--newsletter'));
           ?> 
          <div class="row">
            <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12 ">
              <div class="ps-form__left">
                <h3>Newsletter</h3>
                <p>Subscribe to get information about products and coupons</p>
              </div>
            </div>
            <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12 ">
                 
                  <div class="ps-form__right">
                    <div class="form-group--nest">
                      <input class="form-control" type="email" name="email" id="news_letter_email" placeholder="<?php echo translate('email_address'); ?>">
                      <button class="ps-btn " id="news_letter_add" onclick="return false;">Subscribe</button>
                    </div>
                  </div>
            </div>
          </div>
        	<?php
     //   echo form_close();
       ?>
      </div>
    </div> -->

    <?php 
	  $contact_company =  $this->db->get_where('general_settings',array('type' => 'contact_company'))->row()->value;
      $contact_address =  $this->db->get_where('general_settings',array('type' => 'contact_address'))->row()->value;
      $contact_address_2 =  $this->db->get_where('general_settings',array('type' => 'contact_address_2'))->row()->value;
      $contact_address_3 =  $this->db->get_where('general_settings',array('type' => 'contact_address_3'))->row()->value;
      $reg_no =  $this->db->get_where('general_settings',array('type' => 'registration_number'))->row()->value;
      $contact_phone =  $this->db->get_where('general_settings',array('type' => 'contact_phone'))->row()->value;
      $contact_email =  $this->db->get_where('general_settings',array('type' => 'contact_email'))->row()->value;
      $contact_website =  $this->db->get_where('general_settings',array('type' => 'contact_website'))->row()->value;
      $contact_about =  $this->db->get_where('general_settings',array('type' => 'contact_about'))->row()->value;
      $facebook =  $this->db->get_where('social_links',array('type' => 'facebook'))->row()->value;
      $twitter =  $this->db->get_where('social_links',array('type' => 'twitter'))->row()->value;
      //$skype =  $this->db->get_where('social_links',array('type' => 'skype'))->row()->value;
      //$youtube =  $this->db->get_where('social_links',array('type' => 'youtube'))->row()->value;
      //$pinterest =  $this->db->get_where('social_links',array('type' => 'pinterest'))->row()->value;
      //$footer_text =  $this->db->get_where('general_settings',array('type' => 'footer_text'))->row()->value;
      //$footer_category =  json_decode($this->db->get_where('general_settings',array('type' => 'footer_category'))->row()->value);

    ?>

    <!--old -->
    <div class="modal fade" id="v_registration" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div id='ajvlup'></div>

    </div>

    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div id='ajlin'></div>

    </div>

    <div class="modal fade" id="registration" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div id='ajlup'></div> 

    </div>

    <div class="modal fade" id="quick_view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:70%;">

      <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button aria-hidden="true" data-dismiss="modal" id="v_close_logup_modal" class="close" type="button">×</button>

                    <br>

                </div>

                <div class="modal-body">

                </div>

                <div class="modal-footer">

                    <button data-dismiss="modal" class="btn-u btn-u-default" type="button" id="v_clsreg" >
						<?php echo translate('close');?>
					</button>

                </div>

            </div>

        </div>

    </div>
    <a data-toggle="modal" data-target="#login" id="loginss" data-backdrop="static" data-keyboard="false" ></a>
    <a data-toggle="modal" data-target="#registration" id="regiss" ></a>
    <a data-toggle="modal" data-target="#v_registration" id="v_regiss" ></a>

    <!-- end old -->


    <footer class="ps-footer" style="background: #4e963d;">
      <!--<div class="ps-container">-->
		<div class="container">
        <div class="ps-footer__widgets">
          <aside class="widget widget_footer widget_contact-us">
            <h4 class="widget-title">Contact us</h4>
            <div class="widget_content">
              <!-- <p>Call us 24/7</p> -->
              <!--<h3><?php echo $contact_phone; ?></h3>-->
			  <p>
				 		  <?php echo $contact_address; ?><br>
                          <?php echo $contact_address_2; ?><br>
                         <?php echo $contact_address_3; ?><br>
				  	     <?php echo 'Contact: '.$contact_phone; ?><br>
					     <a href="mailto:<?php echo $contact_email; ?>">
					     <span class="__cf_email__" ><?php echo $contact_email; ?></span>
					</a>
              </p>
              <ul class="ps-list--social">
                <!-- <li>
                  <a target="_blank" class="facebook" href="<?php echo $facebook; ?>">
                    <i class="fa fa-facebook"></i>
                  </a>
                </li>
                <li>
                  <a target="_blank" class="twitter" href="<?php echo $twitter; ?>">
                    <i class="fa fa-twitter"></i>
                  </a>
                </li> -->

              </ul>
            </div>
          </aside>
          <aside class="widget widget_footer">
            <h4 class="widget-title">Quick links</h4>
            <ul class="ps-list--link">
                <li>
    			    <a href="<?php echo base_url(); ?>home/legal/terms_conditions">
    				  <?php echo translate('terms & conditions'); ?>
    			    </a>
    			</li>
                <li>
				    <a href="<?php echo base_url()."home/legal/privacy_policy"; ?>"><?php echo translate('privacy_policy');?></a>
			    </li>
                <li>
				    <a href="<?php echo base_url()."home/legal/shipping_handling"; ?>">
					  <?php echo translate('shipping & handling');?>
				    </a>
			    </li>
			    <li>
				    <a href="<?php echo base_url()."home/legal/refund_cancellation_policy"; ?>">
					  <?php echo translate('Refund & Cancellation Policy');?>
				    </a>
			    </li>
			    <li>
				    <a href="<?php echo base_url()."home/legal/cancellation_replacement_policy"; ?>">
					  <?php echo translate('Cancellation & Replacement Policy');?>
				    </a>
			    </li>
            </ul>
          </aside>
          <aside class="widget widget_footer">
            <h4 class="widget-title">Company</h4>
            <ul class="ps-list--link">
              <li><a href="<?php echo base_url(); ?>home/about"><?php echo translate('about_us'); ?></a></li>
              <!-- <li><a href="<?php echo base_url(); ?>home/contact"><?php echo translate('contact_us'); ?></a></li> -->
            </ul>
          </aside>
          <aside class="widget widget_footer widget widget_footer_last">
            <h4 class="widget-title">Business</h4>
            <ul class="ps-list--link">
    <!--          	<li><a href="https://mydrsasia.com/vendor">Merchant Sign In</a></li>-->
				<!--<li><a href="https://mydrsasia.com/vendor/sell/add">Sign Up as Merchant</a></li>-->
				<li><a href="<?php echo base_url('home/cart_checkout'); ?>">Checkout</a></li>
              <li><a href="<?php echo base_url('home/profile'); ?>">My account</a></li>
              <!-- <li><a href="<?php echo base_url(''); ?>home/profile">Shop</a></li> -->
            </ul>
          </aside>
        </div>
        
        <div class="ps-footer__copyright">
          <p>© <?php echo date('Y'); ?> <a target="_blank" href="<?php echo base_url(); ?>"><?php echo $system_title; ?></a>. <?php echo translate('all_rights_reserved'); ?></p>
          <!--<p>-->
          <!--  <span>Powered by <a href="http://estrrado.com" target="_blank">Estrrado Technologies</a></span>-->
          <!--</p>-->
          <p>
            <span>We Using Safe Payment For:</span>
            <a href="#">
              <img src="<?php echo base_url(); ?>template/drsnew/img/payment-method/1.jpg" alt="">
            </a>
            <a href="#">
              <img src="<?php echo base_url(); ?>template/drsnew/img/payment-method/2.jpg" alt="">
            </a>
          <!--  <a href="#">-->
          <!--    <img src="<?php echo base_url(); ?>template/drsnew/img/payment-method/3.jpg" alt="">-->
          <!--  </a>-->
          <!--  <a href="#">-->
          <!--    <img src="<?php echo base_url(); ?>template/drsnew/img/payment-method/4.jpg" alt="">-->
          <!--  </a>-->
          <!--  <a href="#">-->
          <!--    <img src="<?php echo base_url(); ?>template/drsnew/img/payment-method/5.jpg" alt="">-->
          <!--  </a>-->
          <!--</p>-->
        </div>
      </div>
    </footer>
	<?php
			$this->db->limit(0,1);
			$this->db->order_by('popup_id','desc');
			$pops = $this->db->where('status','1')->get('promo_popup');
			if($pops->num_rows()==1)
			{ 
				$proimg=$pops->row();
				?>
				<div class="ps-popup" id="subscribe" data-time="500">
				  <div class="ps-popup__content bg--cover" data-background="">
					  <a class="ps-popup__close" href="#"><i class="icon-cross"></i></a>
						<div class="ps-form--subscribe-popup">
						  <div class="ps-form__content">
							<span>
								<img src="<?php echo base_url('uploads/popup_image/popup_').$proimg->popup_id.'.jpg'; ?>"/>
							</span>
						  </div>
						</div>
				  </div>
				</div>
				<?php
			}
		?>

    <div id="back2top"><i class="pe-7s-angle-up"></i></div>

    <div class="ps-site-overlay"></div>

    <!--<div id="loader-wrapper">-->
    <!--  <div class="loader-section section-left"></div>-->
    <!--  <div class="loader-section section-right"></div>-->
    <!--</div>-->
    
    
    <div class="ps-search" id="site-search"><a class="ps-btn--close" href="#"></a>
      <div class="ps-search__content">
        <form class="ps-form--primary-search" action="" method="post">
          <input class="form-control" type="text" placeholder="Search for...">
          <button><i class="aroma-magnifying-glass"></i></button>
        </form>
      </div>
    </div>

	<script>
		$('#news_letter_add').on('click', function()
    	{
			  var here = $(this); 
			  var text = here.html(); 
			  var form = here.closest('form');
			  var email = form.find('#news_letter_email').val();
		  	  //console.log(email);
			  if(isValidEmailAddress(email))
			  {
				  var formdata = false;
				  if (window.FormData){ formdata = new FormData(form[0]); }
				  $.ajax(
				  {
					url: form.attr('action'), 
					type: 'POST', 
					dataType: 'html', 
					data: formdata ? formdata : form.serialize(), 
					cache       : false,
					contentType : false,

					processData : false,
					beforeSend: function() 
					{
					  here.addClass('disabled');
					  here.html(working); 
					},
					success: function(data) 
					{
					  here.fadeIn();
					  here.html(text);
					  here.removeClass('disabled');
					  if(data == 'done')
					  {
						notify(subscribe_success,'info','bottom','right');
						$('#news_letter_email').val('');
					  } 
					  else if(data == 'already')
					  {
						notify(subscribe_already,'warning','bottom','right');
					  } 
					  else if(data == 'already_session')
					  {
						notify(subscribe_sess,'warning','bottom','right');
						$('#news_letter_email').val('');
					  } 
					  else 
					  {
						notify(data,'warning','bottom','right');
					  }
					},
					error: function(e) 
					{
					  console.log(e)
					}
				  });
			  }
			  else 
    		  {
      			notify(mbe,'danger','bottom','right');
    		  }
    	});
	</script>	

<style>
#subscribe .ps-form--subscribe-popup {
    padding: 15px 15px;
    background: #fff;
	min-height: 300px;
}
#subscribe .ps-popup__content {
	max-width: 684px;
}
#subscribe .ps-form--subscribe-popup .ps-form__content {
    max-width: 100%;
    text-align: center;
    margin: 0 auto;
}
#subscribe .ps-form--subscribe-popup .ps-form__content span {
	display: block;
    text-align: center;
    width: 100%;
}
#subscribe .ps-form--subscribe-popup .ps-form__content span img {
	margin: 0 auto;
	width: 100%;
    height: 100%;
}
</style>