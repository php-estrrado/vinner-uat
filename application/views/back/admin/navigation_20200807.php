<?php
    $class      =   $this->router->fetch_class();
    $method     =   $this->router->fetch_method();
?>
<nav id="mainnav-container">
    <div id="mainnav">
        <!--Menu-->
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content" style="overflow-x:auto;">
                    <ul id="mainnav-menu" class="list-group">
                        <!--Category name-->
                        <li class="list-header"></li>
                        <!--Menu list item-->
                        <li <?php if($page_name=="dashboard"){?> class="active-link" <?php } ?> 
                        	style="border-top:1px solid rgba(69, 74, 84, 0.7);">
                            <a href="<?php echo base_url(); ?>admin/">
                                <i class="fa fa-tachometer"></i>
                                <span class="menu-title">
									<?php echo translate('dashboard');?>
                                </span>
                            </a>
                        </li>
                        
            			<?php
                        	if($this->crud_model->admin_permission('category') ||
								$this->crud_model->admin_permission('sub_category') || 
									$this->crud_model->admin_permission('product') || 
										$this->crud_model->admin_permission('stock') ){
						?>
                        <!--Menu list item-->
                        <li <?php if($page_name=="category" || 
                                        $page_name=="sub_category" || 
                                        $page_name=="product" || 
                                        $page_name=="stock" ||
                                        $page_name=="product_group" ||
                                        $page_name=="sub_equipment" ||
                                        $page_name=="equipment" ||
                                        $page_name=="vendor_product"

                                                ){?>
                                                     class="active-sub" 
                                                        <?php } ?> >
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i>
                                    <span class="menu-title">
                                        <?php echo translate('products');?>
                                    </span>
                                	<i class="fa arrow"></i>
                            </a>
            
                            <!--PRODUCT-->
                            <ul class="collapse <?php if($page_name=="category" || 
                                                        $page_name=="sub_category" ||  
                                                        $page_name=="product" || 
                                                        $page_name=="brand" ||
                                                        $page_name=="stock" ||
                                                        $page_name=="group" ||
                                                        $page_name=="sub_equipment" ||
                                                        $page_name=="equipment" ||
                                                        $page_name=="vendor_product"

                                                                        ){?>
                                                                             in
                                                                                <?php } ?> >" >
                                
								<?php
                                    if($this->crud_model->admin_permission('category')){
                                ?>                                            
                                    <li <?php if($page_name=="category"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>admin/category">
                                        	<i class="fa fa-circle fs_i"></i>
                                        		<?php echo translate('category');?>
                                        </a>
                                    </li>
								<?php
									} if($this->crud_model->admin_permission('sub_category')){
                                ?>
                                    <li <?php if($page_name=="sub_category"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>admin/sub_category">
                                            <i class="fa fa-circle fs_i"></i>
                                            	<?php echo translate('sub-category');?>
                                        </a>
                                    </li>
								<?php
									} if($this->crud_model->admin_permission('brand')){
                                ?>
                                    <li <?php if($page_name=="brand"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>admin/brand">
                                        	<i class="fa fa-circle fs_i"></i>
                                            	<?php echo translate('brands');?>
                                        </a>
                                    </li>
								<?php
									} if($this->crud_model->admin_permission('product')){
                                ?>
                                    <li <?php if($page_name=="product"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>admin/product">
                                        	<i class="fa fa-circle fs_i"></i>
                                            	<?php echo translate('all_products');?>
                                        </a>
                                    </li>
                                    <?php
                                    } if($this->crud_model->admin_permission('product')){
                                ?>
                                    <li <?php if($page_name=="vendor_product"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>admin/vendor_product">
                                            <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('vendor_products');?>
                                        </a>
                                    </li>
                                    <?php
                                    } /*if($this->crud_model->admin_permission('product')){
                                ?>
                                    <li <?php if($page_name=="equipment"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>admin/equipment">
                                            <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('equipment');?>
                                        </a>
                                    </li>
                                <?php
                                    }
									if($this->crud_model->admin_permission('product')){
                                ?>
                                    <li <?php if($page_name=="sub_equipment"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>admin/sub_equipment">
                                            <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('sub_equipment');?>
                                        </a>
                                    </li>
								<?php
									} */
									if($this->crud_model->admin_permission('stock')){
                                ?>
                                    <li <?php if($page_name=="stock"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>admin/stock">
                                        	<i class="fa fa-circle fs_i"></i>
                                        		<?php echo translate('product_stock');?>
                                        </a>
                                    </li>
                                    <?php
                                    } /*if($this->crud_model->admin_permission('product')){
                                ?>
                                    <li <?php if($page_name=="group"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>admin/product_group">
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
                        
                        <?php
							/*
                            if($this->crud_model->admin_permission('blog') ){
                        	?>
                        <li <?php if($page_name=="blog" || $page_name=="blog_category" ){?>
                                     class="active-sub" <?php } ?> >
                            <a href="#">
                                <i class="fa fa-user"></i>
                                <span class="menu-title">
                                    <?php echo translate('blog');?>
                                </span>
                                <i class="fa arrow"></i>
                            </a>
                            <ul class="collapse <?php if($page_name=="blog" || $page_name=="blog_category"){?> in<?php } ?>" >
                                <?php
                                    if($this->crud_model->admin_permission('blog'))
									{
                                		?>
										<li <?php if($page_name=="blog"){ ?> class="active-link" <?php } ?> >
											<a href="<?php echo base_url(); ?>admin/blog/">
												<i class="fa fa-circle fs_i"></i>
													<?php echo translate('all_blogs');?>
											</a>
										</li>
										<?php
                                    }
                                ?>
                                <?php
                                    if($this->crud_model->admin_permission('blog')){
                                ?>
                                <li <?php if($page_name=="blog_category"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/blog_category/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('all_blog_categories');?>
                                    </a>
                                </li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </li>
                        <?php
                            } */
                        ?>
                        
                        <!--Sale-------------------->
						<?php
							if($this->crud_model->admin_permission('sale')){
						?>
                        
                             <li <?php if($page_name=="sales" || $page_name=="sales_list" || $page_name=="sales_view" ){?>
                                     class="active-sub" 
                                        <?php } ?> >
                            <a href="#">
                                <i class="fa fa-usd"></i>
                                <span class="menu-title">
                                    <?php echo translate('sale');?>
                                </span>
                                <i class="fa arrow"></i>
                            </a>
            
                            <ul class="collapse <?php if($page_name=="sales" || $page_name=="sales_list" || $page_name=="report_sale" || $page_name=="total_sales" ){?>in<?php } ?>" >
                                
                                <?php
                                    if($this->crud_model->admin_permission('sale')){
                                ?>
                                <li <?php if($page_name=="sales"){?> class=" active-link" <?php } ?>>
                            <a href="<?php echo base_url(); ?>admin/sales/">
                                <i class="fa fa-circle fs_i "></i>
                                    <span class="menu-title">
                                		<?php echo translate('orders');?>
                                    </span>
                            </a>
                        </li>
                                <?php
                                    }
                                ?>

                                <?php
                                    if($this->crud_model->admin_permission('sale')){
                                ?>
                                <li <?php if($page_name=="report_sale" || $page_name=="total_sales"){?> class=" active-link" <?php } ?>>
                            <a href="<?php echo base_url(); ?>admin/report_sale/">
                                <i class="fa fa-circle fs_i "></i>
                                    <span class="menu-title">
                                        <?php echo translate('total sales invoice');?>
                                    </span>
                            </a>
                        </li>
                                <?php
                                    }
                                ?>

                                <?php
                                  //  if($this->crud_model->admin_permission('sale')){
                                ?>
                              
                             <li <?php if($page_name=="sales"){?> class="active-link" <?php } ?> >
                           <!-- <a href="<?php echo base_url(); ?>admin/sales_view/">
                                <i class="fa fa-circle fs_i"></i>
                                    <span class="menu-title">
                                        <?php echo translate('');?>
                                    </span>
                            </a>-->
                        </li>
                                <?php
                                  //  }
                                ?>
                            </ul>
                        </li>
                        

                        <?php
							}
						?>
						
                        <?php
							if($this->crud_model->admin_permission('report')){
						?>
                        <!--Menu list item-->
                        <li <?php if($page_name=="mostviewed" || 
                                        $page_name=="report_stock" ||
                                            $page_name=="report_wish" ){?>
                                                     class="active-sub" 
                                                        <?php } ?>>
                            <a href="#">
                                <i class="fa fa-file-text"></i>
                                    <span class="menu-title">
                                		<?php echo translate('reports');?>
                                    </span>
                                		<i class="fa arrow"></i>
                            </a>
                            
                          
                           <!-- REPORTs-  -->
                            <ul class="collapse <?php if($page_name=="mostviewed" || 
                                                            $page_name=="report_stock" ||
                                                                $page_name=="report_wish" ||
                                                                $page_name=="report_review" ||
                                                                $page_name=="report_coupon" ||
                                                                $page_name=="report_products" ||
                                                                $page_name=="report_searchterm"   
                                                                                         ) { ?>
                                                                         in   <?php } ?> " > 
                                    
                                 
                                <li <?php if($page_name=="mostviewed"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/most_viewed/">
                                        <i class="fa fa-circle fs_i"></i>
                                        <span class="menu-title">
                                            <?php echo translate('most_viewed');?>
                                                
                                            </span>
                                    </a>

                                </li>

                                   
                                
                                <li <?php if($page_name=="report_stock"){ ?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/report_stock/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('Stock Report');?>
                                    </a>
                                </li>

                                <li <?php if($page_name=="report_review"){ ?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/report_review/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('Review Report');?>
                                    </a>
                                </li>

                                <li <?php if($page_name=="report_coupon"){ ?> class="active-link " <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/report_coupon/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('Coupon Report');?>
                                    </a>
                                </li>

                                <li <?php if($page_name=="report_products"){ ?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/report_products/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('Best Purchased Products');?>
                                    </a>
                                </li>

                                <li <?php if($page_name=="report_searchterm"){ ?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/report_searchterm/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('Search_Terms_Report');?>
                                    </a>
                                </li>
                                

                                
                                
                            </ul>
                        </li>
                        <?php
                            }
                        ?>
                       
                       
                       
                       <?php
                              if($this->crud_model->admin_permission('user')){
                        ?>
                        <li <?php if($page_name=="user" || $page_name=="guest"  || $page_name=="customer_group" ){?>
                                     class="active-sub" 
                                        <?php } ?> >
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span class="menu-title">
                                    <?php echo translate('Users');?>
                                </span>
                                <i class="fa arrow"></i>
                            </a>
            
                            <ul class="collapse <?php if($page_name=="user" || $page_name=="guest"  || $page_name=="customer_group" ){?>in<?php } ?>" >
                                
                                <?php
                                    if($this->crud_model->admin_permission('user'))
									{
										?>
										<li <?php if($page_name=="user"){?> class="active-link" <?php } ?> >
											<a href="<?php echo base_url(); ?>admin/user/">
												<i class="fa fa-circle fs_i"></i>
													<span class="menu-title">
														<?php echo translate('customers');?>
													</span>
											</a>
										</li>
										<?php
                                    }
                                ?>
                                <?php
								  /*
                                    if($this->crud_model->admin_permission('user')){
                                ?>
                               
                                <li <?php if($page_name=="guest"){?> class="active-link" <?php } ?> >
									<a href="<?php echo base_url(); ?>index.php/admin/guest/">
										<i class="fa fa-circle fs_i"></i>
											<span class="menu-title">
												<?php echo translate('Guest users');?>
											</span>
									</a>
                       			 </li>
                                <?php
                                    } */
                                ?>

                                 <?php
                                    /*if($this->crud_model->admin_permission('user'))
									{
										?>

										<li <?php if($page_name=="customer_group"){?> class="active-link" <?php } ?> >
												<a href="<?php echo base_url(); ?>admin/customer_group/">
													<i class="fa fa-circle fs_i"></i>
														<span class="menu-title">
															<?php echo translate('customer_groups');?>
														</span>
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
                        
                        <?php
                            //if($this->crud_model->admin_permission('user')){
                        ?>
                        <!--Menu list item-->
                        <!--<li <?php //if($page_name=="user"){?> class="active-link" <?php //} ?> >
                            <a href="<?php //echo base_url(); ?>index.php/admin/user/">
                                <i class="fa fa-users"></i>
                                    <span class="menu-title">
                                        <?php //echo translate('customers');?>
                                    </span>
                            </a>
                        </li>-->
                        <!--Menu list item-->
                        <?php
                           // }
                        ?>
                        
                        
                        <!--Guest user-->
                        
                         <!--<li <?php //if($page_name=="guest"){?> class="active-link" <?php //} ?> >
                            <a href="<?php //echo base_url(); ?>index.php/admin/guest/">
                                <i class="fa fa-users"></i>
                                    <span class="menu-title">
                                        <?php //echo translate('Guest users');?>
                                    </span>
                            </a>
                        </li>-->
                        
                        <!--/Guest user-->
                        

                        <?php
                            if($this->crud_model->admin_permission('coupon')){
                        ?>
                        <!--Menu list item-->
                        <li <?php if($page_name=="coupon"){?> class="active-link active-sub" <?php } ?> >
                            <a href="<?php echo base_url(); ?>admin/coupon/">
                                <i class="fa fa-tag"></i>
                                    <span class="menu-title">
                                        <?php echo translate('discount_coupon');?>
                                    </span>
                            </a>
                        </li>
                        <!--Menu list item-->
                        <?php
                            }
                        ?>
                        
                        
                        <?php
                            if($this->crud_model->admin_permission('vendor') ||
                                $this->crud_model->admin_permission('membership_payment') ||
                                    $this->crud_model->admin_permission('membership'))
							{
                        ?>
                        <!--Menu list item-->
                        <li <?php if($page_name=="vendor" || $page_name=="membership_payment" || $page_name=="membership" ){?>
                                                     class="active-sub" <?php } ?>>
                            <a href="#">
                                <i class="fa fa-user-plus"></i>
                                    <span class="menu-title">
                                        <?php echo translate('vendors');?>
                                    </span>
                                        <i class="fa arrow"></i>
                            </a>
                            
                            <ul class="collapse <?php if($page_name=="vendor" || $page_name=="membership_payment" || 
														 $page_name=="membership" ){?>  in  <?php } ?> ">
                                <li <?php if($page_name=="vendor"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/vendor/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('vendor_list');?>
                                    </a>
                                </li>
                                <li <?php if($page_name=="membership_payment"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/membership_payment/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('vendor_payments');?>
                                    </a>
                                </li>
                                <li <?php if($page_name=="membership"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/membership/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('vendor_packages');?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                            }
                        ?>

                        <!--Review approval-->
                        
                        <!--Menu list item-->
                         <li <?php if($page_name=="reviews" || $page_name=="review_approval" || $page_name=="review_view" ){?> 
							 class="active-sub" <?php } ?>>
                            <a href="#">
                                <i class="fa fa-user-plus"></i>
                                    <span class="menu-title">
                                        <?php echo translate('Reviews');?>
                                    </span>
                                        <i class="fa arrow"></i>
                            </a>
                            
                            <ul class="collapse <?php if($page_name=="reviews" ||  $page_name=="review_approval" || $page_name=="review_view" ){?> in<?php } ?> ">
                                <li <?php if($page_name=="reviews"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/reviews/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('review_list');?>
                                    </a>
                                </li>
                        	</ul>
						</li>
                        
					<?php /*
                        
  						<li <?php if($page_name=="service" || $page_name=="service_list" ||$page_name=="service_view" ){?>
                                                     class="active-sub" <?php } ?>>
                            <a href="#">
                                <i class="fa fa-pencil-square-o"></i>
                                    <span class="menu-title">
                                        <?php echo translate('Service Request');?>
                                    </span>
                                        <i class="fa arrow"></i>
                            </a>
                            <ul class="collapse <?php if($page_name=="service" ||  $page_name=="service_list" || $page_name=="service_view" ){?>in<?php } ?> ">
                                <li <?php if($page_name=="service"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/service/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('service_list');?>
                                    </a>
                                </li>
                        	</ul>
						</li>
						*/ ?>


                      
                        
                        <?php
                            if($this->crud_model->admin_permission('page')){
                        ?>                      
                            <li <?php if($page_name=="page"){?> class="active-link" <?php } ?> >
                                <a href="<?php echo base_url(); ?>admin/page/">
                                    <i class="fa fa-file-text"></i>
                                    <span class="menu-title">
                                        <?php echo translate('create_new_page');?>
                                    </span>
                                </a>
                            </li>
                        <?php
                            }
                        ?>


                        
                        <?php
                             
                           if($this->crud_model->admin_permission('slider') ||$this->crud_model->admin_permission('slides')){
                                
                        		?>
                        <!--Menu list item-->
                        <li <?php if($page_name=="slider" ||$page_name=="slides"){?>class="active-sub" <?php } ?>>
                            <a href="#">
                                <i class="fa fa-sliders"></i>
                                    <span class="menu-title">
                                        <?php echo translate('slider_settings');?>
                                    </span>
                                        <i class="fa arrow"></i>
                            </a>
                            
                            
                            <ul class="collapse <?php if($page_name=="slider" || $page_name=="slides" ){?> in <?php } ?> ">
                               
                                <li <?php if($page_name=="slides"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/slides/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('top_slides');?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                            }
                        ?>

            			<?php
                        	if($this->crud_model->admin_permission('site_settings') || $this->crud_model->admin_permission('banner'))
						{
							?>
                        <li <?php if($page_name=="banner" || $page_name=="site_settings" ){?> class="active-sub" 
                                            <?php } ?> >
                            <a href="#">
                                <i class="fa fa-desktop"></i>
                                    <span class="menu-title">
                                		<?php echo translate('front_settings');?>
                                    </span>
                                		<i class="fa arrow"></i>
                            </a>
            
                            <ul class="collapse <?php if($page_name=="banner" || $page_name=="site_settings" ){?>in <?php } ?>" >
 
                                <?php
                                    if($this->crud_model->admin_permission('banner')){
                                ?>
                                    <!--Menu list item-->
                                    <li <?php if($page_name=="banner"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>admin/banner/">
                                            <i class="fa fa-circle fs_i"></i>
                                            	<?php echo translate('banner_settings');?>
                                        </a>
                                    </li>
                                    
                                <?php
                                    }
                                ?>
								<?php
                                    if($this->crud_model->admin_permission('site_settings')){
                                ?>                      
                                    <li <?php if($page_name=="site_settings"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>admin/site_settings/general_settings/">
                                            <i class="fa fa-circle fs_i"></i>
                                            	<?php echo translate('site_settings');?>
                                        </a>
                                    </li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </li>
						<?php
                            }
                        ?>
                        
                        <li <?php if($class=="shipping"){?> class="active-sub" 
                                            <?php } ?> >
                            <a href="#">
                                <i class="fa fa-truck"></i>
                                    <span class="menu-title">
                                		<?php echo translate('delivery_settings');?>
                                    </span>
                                		<i class="fa arrow"></i>
                            </a>
            
                            <ul class="collapse <?php if($class=="shipping" ){?>in <?php } ?>" >
                                    <!--Menu list item-->
                                    <li <?php if($method == "operators"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url('admin/shipping/operators/'); ?>">
                                            <i class="fa fa-circle fs_i"></i>
                                            	<?php echo translate('shipping_operators');?>
                                        </a>
                                    </li>
                                    <li <?php if($method=="zones"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url('admin/shipping/zones/'); ?>">
                                            <i class="fa fa-circle fs_i"></i>
                                            	<?php echo translate('shipping_zones');?>
                                        </a>
                                    </li>
                            </ul>
                        </li>
                        
                        <?php
							if($this->crud_model->admin_permission('business_settings')){
						?>
<!--                        <li <?php if($page_name=="activation" || 
                                        $page_name=="payment_method" ||
                                                $page_name=="curency_method" ||
                                                        $page_name=="faq_settings" ){?>
                                                     class="active-sub" 
                                                        <?php } ?>>
                            <a href="#">
                                <i class="fa fa-briefcase"></i>
                                    <span class="menu-title">
                                		<?php echo translate('business_settings');?>
                                    </span>
                                		<i class="fa arrow"></i>
                            </a>
                            
                            REPORT------------------
                            <ul class="collapse <?php if($page_name=="activation" || 
                                                            $page_name=="payment_method" ||
																$page_name=="curency_method" ||
                                                                	$page_name=="faq_settings" ){?>
                                                                             in
                                                                                <?php } ?> ">
                                <li <?php if($page_name=="activation"){?> class="active-link" <?php } ?> >
                                	<a href="<?php echo base_url(); ?>admin/activation/">
                                    	<i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('activation');?>
                                    </a>
                                </li>
                                <li <?php if($page_name=="payment_method"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/payment_method/">
                                    	<i class="fa fa-circle fs_i"></i>
                                        	<?php echo translate('payment_method');?>
                                    </a>
                                </li>
                                <li <?php if($page_name=="curency_method"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/curency_method/">
                                    	<i class="fa fa-circle fs_i"></i>
                                        	<?php echo translate('currency_')?>
                                    </a>
                                </li>
                                <li <?php if($page_name=="faq_settings"){?> class="active-link" <?php } ?> >
                                	<a href="<?php echo base_url(); ?>admin/faqs/">
                                    	<i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('faqs');?>
                                    </a>
                                </li>
                            </ul>
                        </li>-->
                            <?php
                                                        } ?>



 <!--marketing tools-->
                                <?php
                        //  if($this->crud_model->admin_permission('admin') ){
                        ?>
                        <li <?php 
                            //var_dump($page_name);
                            
                            if($page_name=="promo_popup"  ){?>class="active-sub" 
							<?php } ?> >
                            <a href="#">
                                <i class="fa fa-user"></i>
                                <span class="menu-title">
                                    <?php echo translate('Marketing tools');?>
                                </span>
                                <i class="fa arrow"></i>
                            </a>
            
                            <ul class="collapse <?php if($page_name=="promo_popup"){?>in <?php } ?>" >
                                
                                <?php
                                    if($this->crud_model->admin_permission('admin')){
                                ?>
                                <li <?php if($page_name=="admin"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/promo_popup/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('Promotional pop up');?>
                                    </a>
                                </li>
                                <?php
                                    }
                                ?>
                                
                                
                            </ul>
                        </li>
                        
                        <!--/marketing tools-->


                        
            			<?php
                        	if($this->crud_model->admin_permission('role') ||
								$this->crud_model->admin_permission('admin') ){
						?>
                        <li <?php if($page_name=="role" || $page_name=="admin" ){?> class="active-sub" <?php } ?> >
                            <a href="#">
                                <i class="fa fa-user"></i>
                                <span class="menu-title">
                                	<?php echo translate('staffs');?>
                                </span>
                                <i class="fa arrow"></i>
                            </a>
            
                            <ul class="collapse <?php if($page_name=="admin" || $page_name=="role"){?>in <?php } ?>" >
                                
								<?php
                                    if($this->crud_model->admin_permission('admin')){
                                ?>
                                <li <?php if($page_name=="admin"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/admins/">
                                        <i class="fa fa-circle fs_i"></i>
                                        	<?php echo translate('all_staffs');?>
                                    </a>
                                </li>
                                <?php
                                    }
                                ?>
                                <?php
                                    if($this->crud_model->admin_permission('role')){
                                ?>
                                <!--Menu list item-->
                                <li <?php if($page_name=="role"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/role/">
                                        <i class="fa fa-circle fs_i"></i>
                                        	<?php echo translate('staff_permissions');?>
                                    </a>
                                </li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </li>
						<?php
                            }
                        ?>
                        
            			<?php
                        	if($this->crud_model->admin_permission('newsletter') ||
								$this->crud_model->admin_permission('contact_message') ){
						?>
                        <li <?php if($page_name=="newsletter" || 
                                        $page_name=="contact_message" ){?>
                                             class="active-sub" 
                                                <?php } ?> >
                            <a href="#">
                                <i class="fa fa-envelope"></i>
                                <span class="menu-title">
                                	<?php echo translate('messaging');?>
                                </span>
                                <i class="fa arrow"></i>
                            </a>
                            
                         
                            <ul class="collapse <?php if($page_name=="newsletter" || $page_name=="contact_message" || $page_name=="quote_message"){?> in<?php } ?>" >
                                
                               <?php /* <li <?php if($page_name=="quote_message"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/quote_message">
                                        <i class="fa fa-circle fs_i"></i>
                                        	<?php echo translate('quote_messages');?>
                                    </a>
                                </li> */?>

								<?php
                                    if($this->crud_model->admin_permission('newsletter')){
                                ?>
                                <li <?php if($page_name=="newsletter"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/newsletter">
                                        <i class="fa fa-circle fs_i"></i>
                                        	<?php echo translate('newsletters');?>
                                    </a>
                                </li>
                                <?php
                                    }
                                ?>
                                
                                <?php
                                    if($this->crud_model->admin_permission('contact_message')){
                                ?>
                                <li <?php if($page_name=="contact_message"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>admin/contact_message">
                                        <i class="fa fa-circle fs_i"></i>
                                        	<?php echo translate('contact_messages');?>
                                    </a>
                                </li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </li>
						<?php
                            }
                        ?>



					<?php /*
                        <li <?php if($page_name=="quote_recepients" ){?>class="active-sub" <?php } ?> >
                            <a href="#">
                                <i class="fa fa-cog"></i>
                                <span class="menu-title">
                                    <?php echo translate('Mail_settings');?>
                                </span>
                                <i class="fa arrow"></i>
                            </a>
                            <ul class="collapse <?php if($page_name=="quote_recepients"   ){?>in<?php } ?>" >
                                
                                <li <?php if($page_name=="quote_recepients"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/quote_recepients">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('quote/service_recepients');?>
                                    </a>
                                </li>
                            </ul>
                        </li> */?>
                        
                        



                        

                        <?php
                            if($this->crud_model->admin_permission('seo')){
                        ?>
                        <li <?php if($page_name=="seo_settings"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>admin/seo_settings">
                                <i class="fa fa-search-plus"></i>
                                <span class="menu-title">
                                    SEO
                                </span>
                            </a>
                        </li>
                        <?php
                            }
                        ?>
                        
                        <?php /*
                            if($this->crud_model->admin_permission('language')){
                        ?> 
                        <li <?php if($page_name=="language"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>admin/language_settings">
                                <i class="fa fa-language"></i>
                                <span class="menu-title">
                                    <?php echo translate('language');?>
                                </span>
                            </a>
                        </li>
                        <?php
                            }*/
                        ?>
                        
                        
                        <?php
							/*if($this->crud_model->admin_permission('business_settings'))
                            {
						?>
                        <li <?php if($page_name=="business_settings" || 
                                    $page_name=="countries") {?> class="active-sub" <?php } ?> >
                        <a href="#">
                            <i class="fa fa-briefcase"></i>
                            <span class="menu-title">
                                <?php echo translate('business_settings');?>
                            </span>
                            <i class="fa arrow"></i>
                        </a>
                            <ul class="collapse <?php if($page_name=="business_settings" || 
                                                            $page_name=="countries"){?>
                                                                 in <?php } ?>" >
                            <?php
                            if($this->crud_model->admin_permission('business_settings'))
                            {
                            ?>    
                            <li <?php if($page_name=="business_settings") {?> class="active-link" <?php } ?> >                                    
                            <a href="<?php echo base_url(); ?>admin/business_settings/">
                                <i class="fa fa-money"></i>
                                <span class="menu-title">
                                    <?php echo translate('Payfort_settings');?>
                                </span>
                            </a>
                            </li>
                            <?php } ?>

                            <li <?php if($page_name=="countries") {?> class="active-link" <?php } ?>>                                    
                            <a href="<?php echo base_url(); ?>admin/countries/">
                                <i class="fa fa-globe"></i>
                                <span class="menu-title">
                                    <?php echo translate('manage_countries');?>
                                </span>
                            </a>
                            </li>
                            </ul>
                        </li>
                        <?php
							} */
						?>
                        

 <!-- <li <?php //if($page_name=="inventory"){?> class="active-link" <?php// } ?> >
                            <a href="<?php// echo base_url(); ?>index.php/admin/inventory/">
                                <i class="fa fa-briefcase"></i>
                                <span class="menu-title">
                                    <?php //echo translate('inventory_management');?>
                                </span>
                            </a>
                        </li> -->
<!--tax addition-->

                <li <?php if($page_name=="tax" || $page_name=="stax") {?> class="active-sub" <?php } ?> >
                    <a href="#">
                        <i class="fa fa-money"></i>
                            <span class="menu-title">
                                <?php echo translate('tax_management');?>
                            </span>
                            <i class="fa arrow"></i>
                        </a>
                    <ul class="collapse <?php if($page_name=="tax" || $page_name=="stax"){?>in <?php } ?>" >
                        <li <?php if($page_name=="tax") {?> class="active-link" <?php } ?> >                                    
                            <a href="<?php echo base_url(); ?>admin/tax/">
                                <i class="fa fa-money"></i>
                                <span class="menu-title">
                                    <?php echo translate('Tax_types');?>
                                </span>
                            </a>
                        </li>
						<!-- 
                        <li <?php if($page_name=="stax") {?> class="active-link" <?php } ?>>                                    
                            <a href="<?php echo base_url(); ?>admin/stax/">
                                <i class="fa fa-globe"></i>
                                <span class="menu-title">
                                    <?php echo translate('shipping_tax');?>
                                </span>
                            </a>
                        </li> -->
                    </ul>
                </li>                        
                        <?php /* <li <?php if($page_name=="tax"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>admin/tax/">
                                <i class="fa fa-money"></i>
                                <span class="menu-title">
                                    <?php echo translate('tax_management');?>
                                </span>
                            </a>
                        </li> */?>
                        
                        <?php
                            if($this->crud_model->admin_permission('req_demo')){
                        ?> 
                        <!--Menu list item-->
                        <li <?php if($page_name=="demo_request"){?> class="active-link active-sub" <?php } ?> >
                            <a href="<?php echo base_url(); ?>admin/demo_request/">
                                <i class="fa fa-pencil fa-fw"></i>
                                    <span class="menu-title">
                                        <?php echo translate('request_demo');?>
                                    </span>
                            </a>
                        </li>
                        <!--Menu list item-->
                        <?php
                            }
                        ?>

                       <?php
                            if($this->crud_model->admin_permission('service_request')){
                        ?> 
                        <!--Menu list item-->
                        <li <?php if($page_name=="request_service"){?> class="active-link active-sub" <?php } ?> >
                            <a href="<?php echo base_url(); ?>admin/request_service/">
                                <i class="fa fa-street-view fa-fw"></i>
                                    <span class="menu-title">
                                        <?php echo translate('request_service');?>
                                    </span>
                            </a>
                        </li>
                        <!--Menu list item-->
                        <?php
                            }
                        ?>
                        
                        <li <?php if($page_name=="manage_admin"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>admin/manage_admin/">
                                <i class="fa fa-lock"></i>
                                <span class="menu-title">
                                	<?php echo translate('manage_admin_profile');?>
                                </span>
                            </a>
                        </li>
                        
                </div>
            </div>
        </div>
    </div>
</nav>
<style>
.activate_bar{
border-left: 3px solid #1ACFFC;	
transition: all .6s ease-in-out;
}
.activate_bar:hover{
border-bottom: 3px solid #1ACFFC;
transition: all .6s ease-in-out;
background:#1ACFFC !important;
color:#000 !important;	
}
</style>