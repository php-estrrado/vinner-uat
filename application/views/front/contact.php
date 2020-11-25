
  <?php 
    $contact_address =  $this->db->get_where('general_settings',array('type' => 'contact_address'))->row()->value;
    $contact_phone =  $this->db->get_where('general_settings',array('type' => 'contact_phone'))->row()->value;
    $contact_email =  $this->db->get_where('general_settings',array('type' => 'contact_email'))->row()->value;
    $contact_website =  $this->db->get_where('general_settings',array('type' => 'contact_website'))->row()->value;
    $contact_about =  $this->db->get_where('general_settings',array('type' => 'contact_about'))->row()->value;
	$contact_company =  $this->db->get_where('general_settings',array('type' => 'contact_company'))->row()->value;
	$reg_no =  $this->db->get_where('general_settings',array('type' => 'registration_number'))->row()->value;
  ?>
  

    <div class="ps-page--single" id="contact-us">
      <div class="ps-breadcrumb">
        <div class="container">
          <ul class="breadcrumb">
            <li><a href="<?php base_url(); ?>"><?php echo translate('home'); ?></a></li>
            <li><?php echo translate('contact_us'); ?></li>
          </ul>
        </div>
      </div>
      <!-- <div id="contact-map" data-address="17 Queen St, Southbank, Melbourne 10560, Australia" data-title="Funiture!" data-zoom="17"></div> -->
      <div class="ps-contact-info">
        <div class="container">
          <div class="ps-section__header">
            <h3>Contact Us For Any Questions</h3>
          </div>
          <div class="ps-section__content">
            <div class="row">
			   <div class="col-lg-4 col-md-4 col-sm-12 col-12 offset-md-4 offset-lg-4">
                <div class="ps-block--contact-info">
                  <h4>Contact Directly</h4>
                  <p><span><?php echo $contact_company; ?></span></p>
				  <p><span><?php echo 'Reg.No: '.$reg_no; ?></span></p>
				  <p><span><?php echo $contact_address; ?></span></p>
				  <p><span><?php echo $contact_email; ?></span></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="ps-contact-form">
        <div class="container">
          <?php
			echo form_open(base_url() . 'home/contact/send', array(
				'class' => 'ps-form--contact-us',
				'method' => 'post',
				'enctype' => 'multipart/form-data',
				'id' => ''
			));
    		?>    
            <h3><?php echo translate('get_in_touch');?></h3>
            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                <div class="form-group">
                  <input class="form-control" name="name" id="name" type="text" required placeholder="Name *">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                <div class="form-group">
                  <input class="form-control" name="email" id="email" required type="email" placeholder="Email *">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                <div class="form-group">
                  <input class="form-control" name="subject" required id="subject" type="text" placeholder="Subject *">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                <div class="form-group">
                  <textarea class="form-control" required name="message" id="message" rows="5" placeholder="Message *"></textarea>
                </div>
              </div>
            </div>
            <div class="form-group submit">
              <button class="ps-btn" type="submit"><?php echo translate('send_message');?></button>
            </div>
          	<?php
			echo form_close();
		?>
        </div>
      </div>
    </div>

<script>
	$(document).ready(function() 
      {
			<?php 
            	$rva = $this->session->flashdata('contact_alert');
            	if(isset($rva))
            	{ 
                	?>
		  			setTimeout(function(){ notify('<?php echo translate($rva); ?>','success','bottom','right');}, 800);
                	<?php 
              	} 
			?>
			<?php 
            	$rva2 = $this->session->flashdata('contact_warning');
            	if(isset($rva2))
            	{ 
                	?>
		  			setTimeout(function(){ notify('<?php echo $rva2; ?>','danger','bottom','right');}, 800);
                	<?php 
              	} 
			?>
      });
</script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxflHHc5FlDVI-J71pO7hM1QJNW1dRp4U&amp;region=GB"></script>
