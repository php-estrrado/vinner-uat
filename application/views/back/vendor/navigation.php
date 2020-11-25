<?php
    $class      =   $this->router->fetch_class();
    $method     =   $this->router->fetch_method();
?>
<nav id="mainnav-container">
    <div id="mainnav">
        <!--Menu-->
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content">
                    <ul id="mainnav-menu" class="list-group">
                        <!--Category name-->
                        <li class="list-header"></li>
            
                        <!--Menu list item-->
                        <li <?php if($page_name=="dashboard"){?> class="active-link active-sub" <?php } ?> 
                        	style="border-top:1px solid rgba(69, 74, 84, 0.7);">
                            <a href="<?php echo base_url(); ?>warehouse/">
                                <i class="fa fa-dashboard"></i>
                                <span class="menu-title">
									<?php echo translate('dashboard');?>
                                </span>
                            </a>
                        </li>
                        
            			<?php
                        	if( $this->crud_model->vendor_permission('product') || $this->crud_model->vendor_permission('stock')
							   ||$page_name=="group" )
							{
								?>
                        
								<li <?php if( $page_name=="product" || $page_name=="stock" ){?> class="active-sub" <?php } ?> >
									<a href="#">
										<i class="fa fa-shopping-cart"></i>
											<span class="menu-title">
												<?php echo translate('products');?>
											</span>
											<i class="fa arrow"></i>
									</a>
                            		<ul class="collapse <?php if( $page_name=="product" || $class=="product" ){?> in<?php } ?> " >
										<?php
											if($this->crud_model->vendor_permission('product'))
											{
												?>
												<li <?php if($page_name=="product"){?> class="active-link" <?php } ?> >
													<a href="<?php echo base_url(); ?>vendor/product">
														<i class="fa fa-circle fs_i"></i>
															<?php echo translate('product_list');?>
													</a>
												</li>
												<li <?php if($method=="priceChange"){?> class="active-link" <?php } ?> >
													<a href="<?php echo base_url('warehouse/product/priceChange'); ?>">
														<i class="fa fa-circle fs_i"></i>
															<?php echo translate('price_change_requests');?>
													</a>
												</li>
												<?php
											} 
											if($this->crud_model->vendor_permission('stock'))
											{
												?>
												<!--<li <?php if($page_name=="stock"){?> class="active-link" <?php } ?> >-->
												<!--	<a href="<?php echo base_url(); ?>vendor/stock">-->
												<!--		<i class="fa fa-circle fs_i"></i>-->
												<!--			<?php echo translate('product_stock');?>-->
												<!--	</a>-->
												<!--</li>-->
                                				<?php
                                    	  } 
										/*if($this->crud_model->vendor_permission('product'))
										{
                                			?>
											<li <?php if($page_name=="group"){?> class="active-link" <?php } ?> >
												<a href="<?php echo base_url(); ?>index.php/vendor/product_group">
													<i class="fa fa-circle fs_i"></i>
														<?php echo translate('product_group');?>
												</a>
											</li>
                                			<?php
                                    	}*/
                                	?>
                            	</ul>
                        	</li>
                      
            				<?php
						  }
						?>  
                        
                        

                        <!--SALE-->
                        <?php
                            if($this->crud_model->vendor_permission('sale'))
							{
                        		?>
                        		<li <?php if($page_name=="sales" || $page_name=="report_sale" || $page_name=="total_sales" ) {
									?> class="active-sub" <?php } ?> >
									<a href="#"><i class="fa fa-usd"></i><span class="menu-title"><?php echo 
									translate('sales');?></span><i class="fa arrow"></i>
									</a>
                         			<ul class="collapse <?php if($page_name=="sales" ||  $page_name=="report_sale" || 
																 $page_name=="total_sales" ){?>in<?php } ?>" >
										<li <?php if($page_name=="sales"){?> class="active-link" <?php } ?>>
											<a href="<?php echo base_url(); ?>vendor/sales/">
												<i class="fa fa-circle fs_i"></i>
													<span class="menu-title">
														<?php echo translate('orders');?>
													</span>
											</a>
										</li>
    
                        				<?php
                         					if($this->crud_model->vendor_permission('sale'))
                            				{
                        						?>
												<!--<li <?php if($page_name=="report_sale" || $page_name=="total_sales"){?> -->
												<!--	class=" active-link" <?php } ?>>-->
												<!--	<a href="<?php echo base_url(); ?>vendor/report_sale/">-->
												<!--	<i class="fa fa-circle fs_i "></i><span class="menu-title">-->
												<!--		<?php echo translate('total sales invoice');?>-->
												<!--	</span>-->
												<!--	</a>-->
												<!--</li>-->
                        						<?php
                           					}
                        				?>
                       				 </ul>
                        		</li>
                        		<?php
                            }
                        ?>
                  
                        
                       

                                  
                        <?php
                            if($this->crud_model->vendor_permission('site_settings'))
							{
                        		?>
								<li <?php if($page_name=="site_settings"){?> class="active-link active-sub" <?php } ?> >
									<a href="<?php echo base_url(); ?>vendor/site_settings/general_settings/">
										<i class="fa fa-wrench"></i>
											<span class="menu-title">
												<?php  echo translate('settings');?>
											</span>
									</a>
								</li>
                        		<?php
                            }
                        ?>
                        
                        <?php /*
                            if($this->crud_model->vendor_permission('business_settings'))
							{
                        		?>
								<li <?php if($page_name=="business_settings"){?> class="active-link active-sub" <?php } ?> >
									<a href="<?php echo base_url(); ?>vendor/business_settings/">
										<i class="fa fa-dollar"></i>
										<span class="menu-title">
											<?php echo translate('payment_settings');?>
										</span>
									</a>
								</li>
                        		<?php
                            }*/
                        ?>
                        
                        
                        
                        <!--<li <?php if($page_name=="manage_vendor"){?> class="active-link active-sub" <?php } ?> >-->
                        <!--    <a href="<?php echo base_url(); ?>vendor/manage_vendor/">-->
                        <!--        <i class="fa fa-lock"></i>-->
                        <!--        <span class="menu-title">-->
                        <!--        	<?php echo translate('manage_vendor_profile');?>-->
                        <!--        </span>-->
                        <!--    </a>-->
                        <!--</li>-->
                </div>
            </div>
        </div>
    </div>
</nav>
	
	<style>
		.no-counter
		{
			color: #fff !important;
			float: right;
			background-color: red;
			font-weight: bold;
			border-radius: 50%;
			padding: 2px 4px 0px 4px !important
		}
		.no-counter-fa
		{
			color: red !important;
			float: right;
		}
	</style>