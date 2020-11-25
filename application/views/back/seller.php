<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="300">
	<title><?php echo translate('login');?> | <?php echo $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;?></title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,700,300,500" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>template/back/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>template/back/css/activeit.min.css" rel="stylesheet">	
	<!--Font Awesome [ OPTIONAL ]-->
	<link href="<?php echo base_url(); ?>template/back/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!--Demo [ DEMONSTRATION ]-->
	<link href="<?php echo base_url(); ?>template/back/css/demo/activeit-demo.min.css" rel="stylesheet">
	<!--SCRIPT-->
	<!--Page Load Progress Bar [ OPTIONAL ]-->
	<link href="<?php echo base_url(); ?>template/back/plugins/pace/pace.min.css" rel="stylesheet">
	<script src="<?php echo base_url(); ?>template/back/plugins/pace/pace.min.js"></script>
	<?php $ext =  $this->db->get_where('ui_settings',array('type' => 'fav_ext'))->row()->value; $this->benchmark->mark_time();?>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>uploads/others/favicon.<?php echo $ext; ?>">
	
	<style>
		@import url('https://fonts.googleapis.com/css?family=Work+Sans:400,500&display=swap');
	</style>
</head>

<body >
<div id="container" class="" style="">
		<div id="bg-overlay"></div>

<div class="row navbar container-fluid " >
  	 <img src="<?php echo $this->crud_model->logo('admin_login_logo'); ?>" class="log_iconvr" style="margin: 10px;">
    <div class="log_iconvrs"><h3>Sellers</h3></div>
</div>

<?php if ($vmsg=='valemail')
 {
?>
<div class="row container-fluid" style="margin-left: 25%;margin-top: 25px;">
<center>
 <div class="col-md-6 alert alert-success alert-dismissable fade in " style="">
 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
 <strong><?php echo translate('Success! Your email has been verified successfully ..! '); ?> </strong> 
</div>
</center>
</div>
<?php } ?>

<div class="content ">
    <div class="col-sm-6 seller-block"> 
      	<div class="columns small-24 medium-12 large-15" >
      	<div class="new-seller-block"><h2 >New Seller?</h2>
      	<h3 class="show-for-medium-up ">Start selling where millions of customers are shopping every day.</h3>
      	<p class="show-for-medium-up ">You’re just a few steps away from becoming a seller on mydrsasia.com</p>
      	<div class="registration-button-block"><span>it's free</span> 
      	<a class="" href="<?php echo base_url(); ?>vendor/sell/add">Register Now</a>
			<div class="clear"></div>
      	</div>
      	</div>
      	</div>
      
    </div>
    <div class="col-sm-6  login-block"> 
     	<div class=" panel panel-colorful panel-login reg">
		 <div class="panel-body">
		 <h5> Login </h5>
		 	<?php
					echo form_open(base_url() .$control.'/login/', array(
					'method' => 'post',
					'id' => 'login'
						));
			?>

			<div class="form-group">
				<div class="input-group">
				<!-- <div class="input-group-addon"><i class="fa fa-user" style="color:#FFF !important"></i></div> -->
				<input type="text" name="email" class="form-control" placeholder="<?php echo translate('email id'); ?>">
				</div>
			</div><!-- close form-group -->

			<div class="form-group">
				<div class="input-group">
				<!--<div class="input-group-addon"><i class="fa fa-key" style="color:#FFF !important"></i></div> -->
				<input id="id_admin_login" type="password" name="password" class="form-control" placeholder="<?php echo translate('password'); ?>">
				</div>
			</div><!-- close form-group -->

			<div class="row">
				<div class="col-xs-6 text-left">
                	<div class="pad-ver">
					<a  href="#" onclick="ajax_modal('forget_form','<?php echo translate('forget_password'); ?>','<?php echo translate('email_sent_with_new_password!'); ?>','forget','')" class="btn-link mar-rgt" style="color:#000 !important;"><?php echo translate('forgot_password');?> ?</a>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="form-group text-right formgroupsubmit">
					<span id="btn_login" class="btn btn-login btn-labeled fa fa-unlock-alt snbtn" onclick="form_submit('login')">
                    <?php echo translate('sign_in');?>
                	</span>
					</div>
				</div>
			</div>
		</form>
		 </div>
		</div>
	</div>

<?php if ($vmsg=='chekemail') {
?>
<div class="row">
 <div class="col-md-6 alert alert-success alert-dismissable fade in " style="float:right;margin-right: 50px;">
 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
 <strong><?php echo translate('registration_successful !'); ?> </strong> <?php echo translate('please_check_your_email_inbox_to_confirm_your account..!'); ?>
</div>
</div>
<?php } ?>
</div>
</div>
	<!--jQuery [ REQUIRED ]-->

	<script src="<?php echo base_url(); ?>template/back/js/jquery-2.1.1.min.js"></script>
	<!--BootstrapJS [ RECOMMENDED ]-->
	<script src="<?php echo base_url(); ?>template/back/js/bootstrap.min.js"></script>
	<!--Activeit Admin [ RECOMMENDED ]-->
	<script src="<?php echo base_url(); ?>template/back/js/activeit.min.js"></script>
	<!--Background Image [ DEMONSTRATION ]-->
	<script src="<?php echo base_url(); ?>template/back/js/demo/bg-images.js"></script>
	<!--Bootbox Modals [ OPTIONAL ]-->
	<script src="<?php echo base_url(); ?>template/back/plugins/bootbox/bootbox.min.js"></script>
	<!--Demo script [ DEMONSTRATION ]-->
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
</body>
</html>

<style>
	body {
		font-family: 'Work Sans', sans-serif;
	}
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
      background-color: #000;
    }
    .navbar-inverse
	{
	background-color: #458FD2;
    border-color: #458FD2;
	}
    .navbar-brand
	{
		padding: 15px 44px 44px;
		background-color: #458FD2;
	}
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    /*.row.content {height: 450px}*/
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
	.input-group {
		width: 100%;
	}
	.panel-login {
		max-width: 500px;
		width:90%;
		min-height: 265px;
		margin-top:140px;
	}
	.panel-login .panel-body {
		padding: 20px;
	}
	.panel-login .panel-body h5 {
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
    
      

.log_iconvr {
    width: 120px;
    float: left;
}
.log_iconvrs {
	float: left;
    margin-left: 0;
    margin-top: 2px;
    color: #fff;
}
.new-seller-block {
    position: relative;
    z-index: 20;
    text-align: center;
    margin-top: 140px;
    background: #fff;
    padding: 20px;
    max-width: 500px;
    float: right;
	min-height: 265px;
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
 .new-seller-block .registration-button-block a {
    width: 48%;
    background: #262834;
    border-top-right-radius: 3px;
    border-bottom-right-radius: 3px;
    font-size: 16px;
    float: right;
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
	.log_iconvrs h3 {
	margin-top:12px;
}
	/* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {
		  height:auto;
		} 
	   .new-seller-block .registration-button-block span,
	   .new-seller-block .registration-button-block a{
			width: 100%;
		}
		.new-seller-block .registration-button-block span {
			margin-bottom: 10px;
		}
		.col-sm-6.login-block {
			float:left;
			margin-top: 15px;
		}
		.panel-login {
			max-width: 500px;
			width: 100%;
			min-height: 265px;
			margin-top: 0;
		}
		#forget .label-danger {
			background: none;
			color: #fff;
		}
		#login .pad-ver .btn-link { 
			margin-top: 0;
		}
		.new-seller-block,
		.panel-login {
			max-width: 100%;
		}
		
    }
	@media only screen and (max-width:40em) {
	 .new-seller-block {
		margin-top: 20px;
	  }
}
</style>