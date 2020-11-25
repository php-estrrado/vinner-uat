
    <div class="ps-page--single" id="contact-us">
	    
	    <div class="ps-breadcrumb">
	        <div class="container">
	          <ul class="breadcrumb">
	            <li><a href="<?php base_url(); ?>"><?php echo translate('home'); ?></a></li>
	            <li><?php echo $page_title; ?></li>
	          </ul>
	        </div>
	    </div>
	    
	    <div class="ps-contact-form">
	        <div class="container">
	         	<?php
	      			echo form_open(base_url() . 'home/demorequest/send', array(
	      				'class' => 'ps-form--contact-us',
	      				'method' => 'post',
	      				'enctype' => 'multipart/form-data',
                        'id' => 'drequest_frm',
                        'onsubmit'=>"return validateDrForm()"  
		      			));
		    		    ?>    
		            	<h3><?php echo $page_title;?></h3>

						<div class="row">
                           
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" name="dr_customer" id="dr_cname" type="text" required placeholder="Customer Name *">
                                </div>
                            </div>
                           
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="form-control" name="dr_cemail" id="dr_cemail" required type="email" placeholder="Email *">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input class="form-control" name="dr_phone" id="dr_phone" required type="text" placeholder="Phone number *" onchange="cntnumb()" required>
                                    <span class='drfrm_error' id='dr_phone_error'></span>
                                </div>
                            </div>
                            <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input class="form-control" name="dr_address" id="dr_address" type="text" required placeholder="Address*">
                                </div>
                            </div> -->
                            
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Country</label>
                                    <?php
                                       echo form_dropdown('dr_country',$dr_country_list,'','class="form-control"');
                                    ?>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>City</label>
                                    <input class="form-control" name="dr_city" id="dr_city" required type="text" placeholder="City *">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Date & Time</label>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                        <input class="form-control " min="<?php echo date('Y-m-d'); ?>" name="dr_date" id="dr_date" required type="date" placeholder="Date *" required>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                        <input class="form-control "  name="dr_time" id="dr_time" required type="time"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Product</label>
                                    <?php
                                       echo form_dropdown('dr_product', $dr_product_list,'','class="form-control" ');
                                    ?>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Remark/ Pain Area</label>
                                    <textarea class="form-control"  name="dr_remark" id="dr_remark" rows="3" placeholder="Remark/Pain Area"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group submit">
                            <button class="ps-btn" type="submit"><?php echo translate('Submit');?></button>
                        </div>
		          		<?php
				    echo form_close();
			     ?>
				
	        </div>
      	</div>
	</div>

	<style>
        .drfrm_error
        {
            color: red;
        }
	</style>

<script>
	$(document).ready(function() 
      {
            $(".drfrm_error").text("");
			<?php 
            	$rva = $this->session->flashdata('demorequest_alert');
            	if(isset($rva))
            	{ 
                	?>
		  			setTimeout(function(){ notify('<?php echo translate($rva); ?>','success','bottom','right');}, 800);
                	<?php 
              	} 
			?>
			<?php 
            	$rva2 = $this->session->flashdata('demorequest_warning');
            	if(isset($rva2))
            	{ 
                	?>
		  			setTimeout(function(){ notify('<?php echo $rva2; ?>','danger','bottom','right');}, 800);
                	<?php 
              	} 
			?>
      });

        function validateDrForm ()
        {
            if(!cntnumb())  
            {
                return false;
            } 
            else
            {
                return true;
            } 

        }

        function cntnumb()
        {
            if(!$('#dr_phone').val().match('[0-9]{8,11}'))  {
                $("#dr_phone_error").text("Please enter a valid Phone number");
                return false;
            } 
            else
            {
                $("#dr_phone_error").text("");
                return true;
            }
        }
</script>