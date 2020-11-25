<?php if($this->session->flashdata('success')){?>
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
    <?php echo $this->session->flashdata('success')?>
</div>
<?php }if($this->session->flashdata('warning')){?>
<div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
    <?php echo $this->session->flashdata('warning')?>
</div>
<?php }if($this->session->flashdata('error')){?>
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
    <?php echo $this->session->flashdata('error')?>
</div>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function () {
        setTimeout(function () {
            $('.alert:not(.noanim)').hide('slow');
        }, 4000);

    });
</script>
<style>.alert{ position: fixed; right: 0; z-index: 9999; margin: 7px; max-width: 450px;} </style>
<header id="navbar">

    <div id="navbar-container" class="boxed">

        <!--Brand logo & name-->

        <div class="navbar-header">

            <a href="<?php echo base_url(); ?><?php echo $this->session->userdata('title'); ?>" class="navbar-brand">

                <img src="<?php echo $this->crud_model->logo('admin_login_logo'); ?>" alt="<?php echo $system_name;?>" class="brand-icon" style="">

                <div class="brand-title">

                    <span class="brand-text"><?php echo $system_name;?></span>

                </div>

            </a>

        </div>

        <!--End brand logo & name-->



        <!--Navbar Dropdown-->

        <div class="navbar-content clearfix">

            <ul class="nav navbar-top-links pull-left">

                <!--Navigation toogle button-->

                <li class="tgl-menu-btn">

                    <a class="mainnav-toggle">

                        <i class="fa fa-navicon fa-lg"></i>

                    </a>

                </li>

                <!--End Navigation toogle button-->

            </ul>

            

            <ul class="nav navbar-top-links pull-right">

                <li>

                    <div class="lang-selected" style="">

                            <?php

                                if($this->session->userdata('title') == 'admin'){

                            ?>

                                <a href="<?php echo base_url(); ?>" target="_blank" class="btn btn-info">

                                    <i class="fa fa-desktop"></i>  <?php echo translate('visit_home_page');?>

                                </a>

                            <?php

                                } elseif ($this->session->userdata('title') == 'vendor') {

                            ?>

                                <a href="<?php echo $this->crud_model->vendor_link($this->session->userdata('vendor_id')); ?>" target="_blank" class="btn-lg btn-info">

                                    <!--<i class="fa fa-desktop"> </i>-->  <?php echo translate('My Product Preview');?>

                                </a>

                            <?php

                                }

                            ?>

                    </div>

                </li>
				
				<?php
                    if($this->session->userdata('title') == 'vendor')
                    { ?>
                        <li>
							<a id='head-msg-a' href="<?php echo base_url('vendor/chat'); ?>">
								<i class="fa fa-envelope fa-2x"></i>
								<span>
									<i id='head-msg-cnt'>0</i>
								</span>
							</a>
                        </li>
                      <?php
                    }
                ?>

                <li id="dropdown-user" class="dropdown">

                    <a href="<?php echo base_url(); ?>" data-toggle="dropdown" class="dropdown-toggle text-right">

                        <span class="pull-right">
                            <?php
                              if($this->session->userdata('title') == 'admin')
								{
									?>
                                	<img class="img-circle img-user media-object" src="<?php echo base_url(); ?>template/back/img/av1.png" alt="" />
                            		<?php

                                }
							else if ($this->session->userdata('title') == 'vendor') 
								{
									$v_logo=base_url('uploads/vendor/logo_0.png');
									if(file_exists('uploads/vendor/logo_'.$this->session->userdata('vendor_id').'.png'))
									{
										$v_logo=base_url('uploads/vendor/logo_'.$this->session->userdata('vendor_id').'.png');
									}
									?>
									<img class="img-circle img-user media-object" src="<?php echo $v_logo; ?>" alt="Profile Picture" />
									<?php

                             	}
                         ?>

                        </span>

                        <div class="username hidden-xs">

							<?php 

								if($this->session->userdata('title') == 'admin'){

									echo $this->session->userdata('admin_name');

								} elseif ($this->session->userdata('title') == 'vendor') {

									echo $this->session->userdata('vendor_name');	

								}

							?>

                        </div>

                    </a>

                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow panel-default">

                        <!-- User dropdown menu -->

                        <ul class="head-list">

                            <li>
                            <?php
                                if($this->session->userdata('title') == 'admin'){
                            ?>
                                <a href="<?php echo base_url(); ?>admin/manage_admin/">
                                    <i class="fa fa-user fa-fw fa-lg"></i> <?php echo translate('profile');?>
                                </a>
                                <?php
                                } elseif ($this->session->userdata('title') == 'vendor') {
                            ?>

                                 <a href="<?php echo base_url(); ?>vendor/manage_vendor/">
                                    <i class="fa fa-user fa-fw fa-lg"></i> <?php echo translate('profile');?>
                                </a>
                                 <?php
                                }
                            ?>

                            </li>

                        </ul>



                        <!-- Dropdown footer -->

                        <div class="pad-all text-right">

                            <a href="<?php echo base_url(); ?><?php echo $this->session->userdata('title'); ?>/logout/" class="btn btn-primary">

                                <i class="fa fa-sign-out fa-fw"></i> <?php echo translate('logout');?>

                            </a>

                        </div>

                    </div>

                </li>

                <!--End user dropdown-->

            </ul>

        </div>

    </div>

</header>

				<?php
                    if($this->session->userdata('title') == 'vendor')
                    { 
						?>
						<script>
							$(document).ready(function() 
    						{
								hchat_count();
							});
							function hchat_count()
							{
								$.get(base_url+'vendor/ChatCount',
									  function (data) 
									  {
    									//console.log(data);
										$("#head-msg-cnt").html(data);
									   }
									 );
								setTimeout(function () {hchat_count();}, 8000);
							}
							
							
						</script>
						<?php
					}
				?>