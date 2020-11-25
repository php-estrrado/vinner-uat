
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
	      			echo form_open(base_url() . 'home/servicerequest/send', array(
	      				'class' => 'ps-form--contact-us',
	      				'method' => 'post',
	      				'enctype' => 'multipart/form-data',
                        'id' => 'srequest_frm',
                        'onsubmit'=>"return validateSrForm()"  
		      			));
		    		    ?>    
		            	<h3><?php echo $page_title;?></h3>

						<div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Service Category</label>
                                    <?php
                                       echo form_dropdown('sr_category', $sr_category_list,'','class="form-control" required');
                                    ?>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Type of Service</label>
                                    <?php
                                       echo form_dropdown('sr_type', $sr_type_list,'','class="form-control" required id="sr_type"  onchange="typeshow()"');
                                    ?>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 " id='vehidiv' style='display:none'>
                                <div class="form-group">
                                    <label>Type</label>
                                      <input class="form-control" name="sr_vehicle_service" id="sr_vehicle_service" type="text"  placeholder="Type of vehicle service *" >
                                </div>
                            </div>
                            
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Customer Name</label>
                                    <input class="form-control" name="sr_customer" id="sr_cname" type="text" required placeholder="Customer Name *">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input class="form-control" name="sr_address" id="sr_address" type="text" required placeholder="Address*">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Country</label>
                                    <?php
                                       echo form_dropdown('sr_country',$sr_country_list,'','class="form-control"');
                                    ?>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>City</label>
                                    <input class="form-control" name="sr_city" id="sr_city" required type="text" placeholder="City *">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" name="sr_cemail" id="sr_cemail" required type="email" placeholder="Email *">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input class="form-control" name="sr_phone" id="sr_phone" required type="text" placeholder="Contact number *" onchange="cntnumb()" required>
                                    <span class='srfrm_error' id='sr_phone_error'></span>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Date & Time</label>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                        <input class="form-control " min="<?php echo date('Y-m-d'); ?>" name="sr_date" id="sr_date" required type="date" placeholder="Date *" required>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                        <input class="form-control "  name="sr_time" id="sr_time" required type="time"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea class="form-control"  name="sr_remark" id="sr_remark" rows="3" placeholder="Remarks"></textarea>
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
        .srfrm_error
        {
            color: red;
        }
	</style>

<script>
	$(document).ready(function() 
      {
            $(".srfrm_error").text("");
			<?php 
            	$rva = $this->session->flashdata('servicerequest_alert');
            	if(isset($rva))
            	{ 
                	?>
		  			setTimeout(function(){ notify('<?php echo translate($rva); ?>','success','bottom','right');}, 800);
                	<?php 
              	} 
			?>
			<?php 
            	$rva2 = $this->session->flashdata('servicerequest_warning');
            	if(isset($rva2))
            	{ 
                	?>
		  			setTimeout(function(){ notify('<?php echo $rva2; ?>','danger','bottom','right');}, 800);
                	<?php 
              	} 
			?>
      });

        function validateSrForm ()
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
            if(!$('#sr_phone').val().match('[0-9]{8,11}'))  {
                $("#sr_phone_error").text("Please enter a valid Contact Number");
                return false;
            } 
            else
            {
                $("#sr_phone_error").text("");
                return true;
            }
        }
        
        function typeshow()
        {
             
            if($('#sr_type').val()=='3')
            {
                $("#sr_vehicle_service").prop('required',true);
                $('#vehidiv').css('display','block');
                
            }
            else
            {
                $("#sr_vehicle_service").val('');
                $("#sr_vehicle_service").prop('required',false);
                $('#vehidiv').css('display','none');
            }
            
            
        }
</script>