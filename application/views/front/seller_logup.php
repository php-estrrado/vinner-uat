

	
	
	<div class="ps-page--my-account">
      <div class="ps-breadcrumb">
        <div class="container">
          <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><?php echo translate('home'); ?></a></li>
            <li><?php echo translate('seller_register'); ?></li>
          </ul>
        </div>
      </div>

      <div class="ps-my-account">
        <div class="container login_page" >
            <?php 
                echo form_open(base_url() . 'home/login/do_login/page', array(
                        'class' => 'ps-form--account log-reg-v3',
                        'method' => 'post',
                        'style' => '',
                        'id' => 'page-login'
                        ));
                        ?>
                   	<ul class="ps-tab-list">
              			<li class="active">
              				<a href=""><?php echo translate('be_a_seller');?></a>
              			</li>
              			<p>
              				<?php 
              					echo translate('already_a_seller ?').translate(' click'); 
              				?> 
              				<a href="<?php echo base_url('home/sellwithus'); ?>" >
              					<?php echo translate('here');?>
              				</a> 
                   			<?php echo translate('to_login_your_account');?>
                		</p>
            		</ul>

            		<div class="ps-tabs">
              			<div class="ps-tab active" id="sign-in">
	                        <div class="ps-form__content">
	                           
	                            
	                            

	                            
	                        </div>
              			</div>
            		</div>
            		<?php
                echo form_close();
            ?>
        </div>    
      </div>

    </div>

    