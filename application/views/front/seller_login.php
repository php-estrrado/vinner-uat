

	<link href="<?php echo base_url(); ?>template/back/css/activeit.min.css" rel="stylesheet">
	
	<div class="ps-page--single">
      <div class="ps-breadcrumb">
        <div class="container">
          <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><?php echo translate('home'); ?></a></li>
            <li><?php echo translate('seller_login'); ?></li>
          </ul>
        </div>
      </div>
      <!-- <div class="ps-vendor-banner bg--cover" data-background="img/bg/vendor.jpg" style="background: url(&quot;img/bg/vendor.jpg&quot;);">
        <div class="container">
          <h2>Millions Of Shoppers Can’t Wait To See What You Have In Store</h2><a class="ps-btn ps-btn--lg" href="#">Start Selling</a>
        </div>
      </div> -->

      	<div class="ps-section--vendor ps-vendor-faqs">
	        <div class="container ">
	          <!-- <div class="ps-section__header">
	            <p>FREQUENTLY ASKED QUESTIONS</p>
	            <h4>Here are some common questions about selling on Martfury</h4>
	          </div> -->
		        <div class="ps-section__content">
		          	<?php 
						//$vmsg= 'valemail';
						if ($vmsg=='valemail')
				 		{
							?>
				          	<center>
							 	<div class="col-md-6 alert alert-success alert-dismissable  " style="">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;
									</a>
									<strong>
									 	<?php echo translate('Success! Your email has been verified successfully ..! '); ?> 
									</strong> 
								</div>
							</center>
							<?php 
						} 
					?>	
		            <div class="row">

			            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
			                <div class="columns small-24 medium-12 large-15" >
						      	<div class="new-seller-block">
						      		<h2 >New Seller?</h2>
							      	<h3 class="show-for-medium-up ">Start selling where millions of customers are shopping every day.</h3>
							      	<p class="show-for-medium-up ">
							      		You’re just a few steps away from becoming a seller on mydrsasia.
							      	</p>
							      	<div class="registration-button-block"><span>it's free</span> 
							      		<a class="" href="<?php echo base_url('home/sellwithus/register'); ?>">Register Now</a>
										<div class="clear"></div>
							      	</div>
						      	</div>
		      				</div>
			            </div>

			            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
			                <div class=" panel panel-colorful panel-login reg">
								<div class="panel-body">
									<h5> Login </h5>
									<?php
										echo form_open(base_url() .$control.'/login/', array(
											'method' => 'post','id' => 'login'));
										?>

										<div class="form-group">
											<div class="input-group">
												<input type="text" name="email" class="form-control" placeholder="<?php echo translate('email id'); ?>">
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<input id="id_admin_login" type="password" name="password" class="form-control" placeholder="<?php echo translate('password'); ?>">
											</div>
										</div>

										<div class="row">
											<div class="col-xs-6 text-left">
							                	<div class="pad-ver">
													<a  href="#" onclick="ajax_modal('forget_form','<?php echo translate('forget_password'); ?>','<?php echo translate('email_sent_with_new_password!'); ?>','forget','')" class="btn-link mar-rgt" style="color:#000 !important;">
														<?php echo translate('forgot_password');?> ?
													</a>
												</div>
											</div>
											<div class="col-xs-6 ">
												<div class="form-group text-right formgroupsubmit" >
													<span id="btn_login" class="btn btn-login btn-labeled fa fa-unlock-alt snbtn" onclick="form_submit('login')">
														<?php echo translate('sign_in');?>
								                	</span>
												</div>
											</div>
										</div>
										<?php 
										echo form_close(); 
									?>
				 				</div>
							</div>
			            </div>
		            </div>
		            <?php 
		            	//$vmsg= 'chekemail';
		            	if ($vmsg=='chekemail') 
						{
							?>
							<center>
							 	<div class="col-md-6 alert alert-success alert-dismissable  " style="margin-right: 50px;">
								 	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								 	<strong>
								 		<?php echo translate('registration_successful !'); ?> 
								 	</strong> 
							 		<?php echo translate('please_check_your_email_inbox_to_confirm_your account..!'); ?>
								</div>
							</center>
							<?php 
						} 
					?>
		        </div>
	        </div>
      	</div>

    </div>

    <script src="<?php echo base_url(); ?>template/back/js/activeit.min.js"></script>
    <script src="<?php echo base_url(); ?>template/back/plugins/bootbox/bootbox.min.js"></script>
	<script src="<?php echo base_url(); ?>template/back/js/ajax_login.js"></script>
	<script>
        var base_url = '<?php echo base_url(); ?>'
        var cancdd = '<?php echo translate('cancelled'); ?>'
        var req = '<?php echo translate('this_field_is_required'); ?>'
		var sing = '<?php echo translate('signing_in...'); ?>';
		var nps = '<?php echo translate('new_password_sent_to_your_email'); ?>';
		var lfil = '<?php echo translate('login_failed!'); ?>';
		var wrem = '<?php echo translate('wrong_e-mail_address!_try_again'); ?>';
		var lss = '<?php echo translate('login_successful!'); ?>';
		var sucss = '<?php echo translate('SUCCESS!'); ?>';
		var rpss = "<?php echo translate('reset_password'); ?>";
        var user_type = '<?php echo $control; ?>';
        var module = 'login';
		var unapproved = '<?php echo translate('account_not_approved._wait_for_approval.'); ?>';
		$("#id_admin_login").keyup(function(event){
		    if(event.keyCode == 13){
		        $("#btn_login").click();
		    }
		});
    </script>
<style type="text/css">
body .ps-section__content
{
	font-family: 'Work Sans', sans-serif;
	
}
.new-seller-block 
{
    position: relative;
    z-index: 20;
    text-align: center;
    /*margin-top: 140px;*/
    background: #fff;
    padding: 20px;
    max-width: 500px;
    float: right;
	min-height: 265px;
}
@media only screen and (max-width:40em) {
 .new-seller-block {
    margin-top: 20px;
  }
}
.new-seller-block h2 {
    font-size: 22px;
    color: #e22626;
    font-weight: 400;
    margin-top: 0;
}
.new-seller-block h3 {
  font-size: 18px;
  color: #262933;
  font-weight: lighter;
}
.new-seller-block p {
  font-size: 15px;
  color: #262933;
  margin: 0;
  font-weight: lighter;
}
.new-seller-block .registration-button-block {
    margin: 20px auto 0;
    max-width: 440px;
    width: 90%;
}
.new-seller-block .registration-button-block a,
.new-seller-block .registration-button-block span {
  display: inline-block;
  text-align: center;
  padding: 10px;
  color: #fff;
  min-height: 45px;
}
.new-seller-block .registration-button-block span {
   	width: 50%;
    background: #e22626;
    float: left;
    border-top-left-radius: 3px;
    border-bottom-left-radius: 3px;
    font-size: 16px;
}
.new-seller-block .registration-button-block a 
{
    width: 48%;
    background: #262834;
    border-top-right-radius: 3px;
    border-bottom-right-radius: 3px;
    font-size: 16px;
    float: right;
}


	.input-group 
	{
		width: 100%;
	}
	.panel-login 
	{
		max-width: 500px;
		width:90%;
		min-height: 265px;
		color: #fff !important;
    	background-color: #fff;
    	border: none;
	}
	.panel-login .panel-body 
	{
		padding: 20px;
	}
	.panel-login .panel-body h5 
	{
		color: #e22626;
		margin-top: 0;
		font-size: 22px;
		font-weight: 400;
	}
	.panel-login .panel-body input[type="text"],
	.panel-login .panel-body input[type="password"]{
		height: 50px;
	}
	.ps-btn, button.ps-btn {
		display: inline-block;
		padding: 12px 20px;
		font-size: 16px;
		font-weight: 600;
		line-height: 20px;
		color: #000;
		border: none;
		font-weight: 600;
		border-radius: 4px;
		background-color: #e22626;
		-webkit-transition: all .4s ease;
		-o-transition: all .4s ease;
		transition: all .4s ease;
		cursor: pointer;
	}


.formgroupsubmit {
	margin-bottom: 0;
}
.formgroupsubmit span {
	padding: 10px 20px !important;
    display: block;
    background: #e22626;
    color: #fff;
    font-size: 16px !important;
    border-radius: 4px;
}
.pad-ver .btn-link {
	margin-top: 12px;
    display: block;
}
.clear {
	clear:both;
}
.btn-login:hover {
	background: #000;
	border:1px solid #000;
	color: #fff;
}
.log_iconvrs h3 
{
	margin-top:12px;
}

#btn_login
{
	background: #e12626;
    height: 38px;
    width: 120px;
    line-height: 36px !important;
    padding: 0 !important;
    float: right;
    font-size: 16px !important;
    color: #fff;
    border-radius: 5px;
} 
</style>