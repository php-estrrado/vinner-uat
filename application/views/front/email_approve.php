<?php

/*$userid=0;
$userid=$this->session->userdata('user_id');
   if($userid <= 0)
   {*/
?>
    <!--=== Profile ===-->
    <div class="profile container content">
    	<div class="row emapp">
            <!--Left Sidebar-->
             
<div class="alert alert-success alert-dismissable fade in col-sm-6 col-md-offset-3">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong style="font-size: initial;">Success! Your email has been verified successfully ...! </strong>
</div>
      
               <!--  <div class="emapp"> -->
                 <div class='login_html col-sm-6 col-md-offset-3'>
                <?php
                    echo form_open(base_url() . 'index.php/home/login/do_login/', array(
                        'class' => 'log-reg-v3 sky-form',
                        'method' => 'post',
                        'style' => 'padding:30px 10px !important;',
                        'id' => 'login_form'
                    ));
                    $fb_login_set = $this->crud_model->get_type_name_by_id('general_settings','51','value');
                    $g_login_set = $this->crud_model->get_type_name_by_id('general_settings','52','value');
                ?>

                    <div class="reg-block-header">
                    <h2><?php echo translate('sign_in');?></h2>
                    <p style="font-weight:300 !important;"><?php echo translate('do_not_have_account_?_click_');?><span class="color-purple" style="cursor:pointer" data-dismiss="modal" onclick="register()" ><?php echo translate('sign_up');?></span> <?php echo translate('to_registration_.');?></p> 
                    </div>
                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input  type="email" placeholder="<?php echo translate('email_address'); ?>" name="email" class="form-control  lgin">
                            </div>
                        </label>
                    </section>
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input id="id_of_textbox" type="password" placeholder="<?php echo translate('password'); ?>" name="password" class="form-control  lgin">
                            </div>    
                        </label>
                    </section>
                <section>
                 <div class="alert alert-danger logfail" id="fail" style="display:none">
                    <strong>Login Failed!</strong> Try Again...! 
                 </div>
                </section>
                    <div class="row margin-bottom-5">
                        <div class="col-xs-8">
                            <span style="cursor:pointer;" onClick="set_html('login_html','forget_html')">
                                <?php echo translate('forget_your_password_?');?>
                            </span>
                        </div>
                        <div class="col-xs-4 text-right">
                            <span id="id_of_button" class="btn-u btn-u-cust btn-block margin-bottom-20 btn-labeled fa  login_btn" type="submit">
                                <?php echo translate('log_in');?>
                            </span>
                        </div>
                    </div>
                    <?php if($fb_login_set == 'ok' || $g_login_set == 'ok'){ ?>
                    <div class="border-wings">
                        <span>or</span>
                    </div>
                    <div class="row columns-space-removes">
                    <?php if($fb_login_set == 'ok'){ ?>
                        <div class="col-lg-6 <?php if($g_login_set !== 'ok'){ ?>mr_log<?php } ?> margin-bottom-10">
                        <?php if (@$user): ?>
                            <a href="<?= $url ?>" >
                                <div class="fb-icon-bg"></div>
                                <div class="fb-bg"></div>
                            </a>
                        <?php else: ?>
                            <a href="<?= $url ?>" >
                                <div class="fb-icon-bg"></div>
                                    <div class="fb-bg"></div>
                            </a>
                        <?php endif; ?>
                        </div>
                        <?php } if($g_login_set == 'ok'){ ?>     
                        <div class="col-lg-6 <?php if($fb_login_set !== 'ok'){ ?>mr_log<?php } ?>">
                        <?php if (@$g_user): ?>
                            <a href="<?= $g_url ?>" >
                                <div class="g-icon-bg"></div>
                                    <div class="g-bg"></div>
                            </a>                            
                        <?php else: ?>
                            <a href="<?= $g_url ?>">
                                <div class="g-icon-bg"></div>
                                    <div class="g-bg"></div>
                            </a>
                        <?php endif; ?>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </form> 
            </div>


            <div class='forget_html col-sm-6 col-md-offset-3' style="display:none;">
                <?php
                    echo form_open(base_url() . 'index.php/home/login/forget/', array(
                        'class' => 'log-reg-v3 sky-form',
                        'method' => 'post',
                        'style' => 'padding:30px !important;',
                        'id' => 'forget_form'
                    ));
                ?>    
                    <h2><?php echo translate('forgot_password');?></h2>
                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="email" placeholder="<?php echo translate('email_address'); ?>" name="email" class="form-control">
                            </div>
                        </label>
                    </section>  
                    <div class="row margin-bottom-5">
                        <div class="col-xs-8">
                            <span style="cursor:pointer;" onClick="set_html('forget_html','login_html')">
                                <?php echo translate('login');?>
                            </span>
                        </div>
                        <div class="col-xs-4 text-right">
                            <span class="btn-u btn-u-cust btn-block margin-bottom-20 forget_btn" type="submit">
                                <?php echo translate('submit');?>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
<!-- <a href="<?php echo base_url() ; ?>" > Home Page </a> -->
<input hidden type="text" name="emap" id="emap" value="welcome">
     <!--     </div> -->
<!--===  banner ===-->
<div class="container margin-bottom-10 half_width_bnr"> <?php
        $place = 'after_slider';
        $query = $this->db->get_where('banner',array('page'=>'home', 'place'=>$place, 'status' => 'ok'));
        $banners = $query->result_array();
        if($query->num_rows() > 0){
            $r = 12/$query->num_rows();
        }
        foreach($banners as $row){ ?>
    
        <a href="<?php echo $row['link']; ?>" >
            <div class="col-md-<?php echo $r; ?> md-margin-bottom-30 ">
                <div class="overflow-h">
                    <div class="illustration-v1 illustration-img1">
                        <div class="illustration-bg banner_<?php echo $query->num_rows(); ?>"  style="background:url('<?php echo $this->crud_model->file_view('banner',$row['banner_id'],'','','no','src') ?>') no-repeat center center; background-size: 100% auto;" >
                        </div>    
                    </div>
                </div>    
            </div>
        </a><?php

        } ?>
</div>
<!--===  Ends banner ===-->

        </div><!--/end row-->
    </div><!--/container-->    
    <!--=== End Profile ===-->
<?php
    
?>
<style type="text/css">
    .emapp
    {
    text-align: center;
    height: 500px;
    }
</style>

</script>