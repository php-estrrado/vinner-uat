

    <div class="ps-page--simple">
      <div class="ps-breadcrumb">
        <div class="container">
          <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><?php echo translate('home');?></a></li>
            <li><?php echo translate('shopping_cart');?></li>
          </ul>
        </div>
      </div>

      <div class="ps-section--shopping ps-shopping-cart">
        <div class="container">
          <div class="ps-section__header">
            <h1><?php echo translate('shopping_cart');?></h1>
          </div>

          <div class="ps-section__content">
            		<?php // echo '<pre>'; print_r($this->cart->contents()); echo '</pre>';  ?>	  

            <div class="table-responsive shoppingcart-web">
              <table class="table ps-table--shopping-cart">
                <thead>
                  <tr>
                    <th><?php echo translate('product');?></th>
                    <th><?php echo translate('price');?></th>
                    <th><?php echo translate('quantity');?></th>
                    <th><?php echo translate('total');?></th>
                    <th class="txtrgt"><?php echo translate('remove');?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $allDigital = true;
                    foreach ($carted as $items)
                      {  
                        if($this->db->select('download')->get_where('product',array('product_id'=>$items['id']))->row()->download != 'ok')
                        { $allDigital = false; }
						  $pr_colour='';	
                          $options        =   json_decode($items['option'],true);
                          $optionColors   =   $options['color'];
							if(count($optionColors))
							{
								$pr_colour=$optionColors['value'];
							}
                          ?>
                          <tr data-rowid="<?php echo $items['rowid']; ?>" id="wb-pr-tr-<?php echo $items['rowid']; ?>">
                            <td>
                              <div class="ps-product--cart">
                              <div class="ps-product__thumbnail">
								  <a href="<?php echo $this->crud_model->product_link($items['id']); ?>">
									  <img src="<?php echo $items['image']; ?>" alt="">
								  </a>
							  </div>
                              <div class="ps-product__content">
								<a href="<?php echo $this->crud_model->product_link($items['id']); ?>">
                                  <?php echo $items['name']; ?>
                                </a>
								<?php 
								 if($pr_colour)
								 {?>
									<br/><label style="float:left">Colour : </label><span style="background:<?php echo $pr_colour; ?>; height:15px; width:15px;border-radius: 50%;display: inline-block;float: left;margin-top: 4px;margin-left: 2px;" ></span>
								  <?php
								 }
								?>
                                <p style="display: block;clear: both;">
                                  <?php echo translate('sold_by:');?><strong> 
                                    <?php 
                                      echo $this->crud_model->product_by($items['id']); 
                                    ?>
                                  </strong>
                                </p>
								
                              </div>
                              </div>
                            </td>
                            <td class="price pric txtrgt"><?php echo currency().$this->cart->format_number($items['price']); ?>
                            </td>
                            <td>
                              <?php
                                if(!$this->crud_model->is_digital($items['id']))
                                { ?>
                                  <div class="form-group--number">
									  <button id="wb-qplus-<?php echo $items['rowid']; ?>" data-rowid="<?php echo $items['rowid']; ?>" class="quantity-button up" value='plus' >+</button>
									  <button id="wb-qminus-<?php echo $items['rowid']; ?>" data-rowid="<?php echo $items['rowid']; ?>" class="quantity-button down" value='minus'>-</button>
									  <input id="wb-qvalue-<?php echo $items['rowid']; ?>" type="text" disabled class="form-control quantity-field" data-rowid="<?php echo $items['rowid']; ?>" data-limit="no" value="<?php echo $items['qty']; ?>" />
                                  </div>
                                  <?php
                                }
                              ?>
                            </td>
                            <td class="shop-red sub_total txtrgt">
                              <?php echo currency().$this->cart->format_number($items['subtotal']); ?>
                            </td>
                            <td>
                              <button data-rowid="<?php echo $items['rowid']; ?>" type="button" class="close">
								  <i class="fa fa-trash"></i>
							  </button>
                            </td>
                          </tr>
                          <?php
                      }
                  ?>
                </tbody>
              </table>
            </div>
			  
			<!-- product list mobile -->
			 <?php //print_r($carted = $this->cart->contents()); ?> 
			<div class="table ps-table--shopping-cart shopping-cart-new shoppingcart-mob">
                <?php
					foreach ($carted as $mbitems)
                      {  
if($this->db->select('download')->get_where('product',array('product_id'=>$mbitems['id']))->row()->download != 'ok')
                        	{ $allDigital = false; }
                          $options        =   json_decode($mbitems['option'],true);
                          $optionColors   =   $options['color'];
						  $mbpr_link=$this->crud_model->product_link($mbitems['id']);	
						  if(count($optionColors))
							{
								$pr_colour=$optionColors['value'];
							}	
						
						  ?>
							<div class="td_btn_deladd col-md-12" data-rowid="<?php echo $mbitems['rowid']; ?>" id="mb-pr-div-<?php echo $mbitems['rowid']; ?>">
								<div class="ps-product--cart mb-4 row">
									<div class="float-left btn_deladd col-lg-1 col-md-1 col-sm-12 col-xs-12">
										   <button type="button" data-rowid="<?php echo $mbitems['rowid']; ?>" class="close" onclick='return false;'>
											   <i class="fa fa-minus-circle"></i>
										   </button>
									</div>
									<div class="ps-product__thumbnail col-lg-4 col-md-4 col-sm-12 col-xs-12">
										 <a href="<?php echo $mbpr_link; ?>">
											 <img src="<?php echo $mbitems['image']; ?>" >
										</a>
									</div>
										<div class="ps-product__content col-lg-7 col-md-7 col-sm-12 col-xs-12">
											<a href="<?php echo $mbpr_link; ?>"><?php echo $mbitems['name']; ?></a>
											<?php 
												 if($pr_colour)
												 {?>
													<br/>
													<label style="">Colour : </label>
													<span style="background:<?php echo $pr_colour; ?>; height:15px; width:15px;border-radius: 50%;display: inline-block;margin-left: 2px;" ></span>
												  <?php
												 }
											?>
											<p style="display: block;clear: both;">
												<?php 
													echo translate('sold_by : ').$this->crud_model->product_by($mbitems['id']); 
                                    			?>
											</p>
											<strong class="price">
												<?php echo currency().$this->cart->format_number($mbitems['price']); ?>
											</strong>
											<div class="pro_countbx">
												<!-- <span>Sample : 50</span> -->
												<div class="form-group--number">
												   <button id="mb-qplus-<?php echo $mbitems['rowid']; ?>" data-rowid="<?php echo $mbitems['rowid']; ?>" class="quantity-button up" value='plus' >+</button>
												   <button id="mb-qminus-<?php echo $mbitems['rowid']; ?>" data-rowid="<?php echo $mbitems['rowid']; ?>" class="quantity-button down" value='minus'>-</button>
												   <input id="mb-qvalue-<?php echo $mbitems['rowid']; ?>" class="form-control quantity-field" data-limit='no' data-rowid="<?php echo $mbitems['rowid']; ?>" disabled type="text" value="<?php echo $mbitems['qty']; ?>">
												</div>
											</div>
									   </div>
								</div>
							</div>
							<?php
					}
				?>
            </div>

            <div class="ps-section__cart-actions">
              <a class="ps-btn" href="<?php echo base_url('home/category');?>">
                <i class="icon-arrow-left"></i> Continue Shopping
              </a>
              <!-- <a class="ps-btn ps-btn--outline" href="shop-default.html"><i class="icon-sync"></i> Update cart</a> -->
            </div>
          </div>
          <div class="ps-section__footer">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 " id="coupon_report">
                    <?php 
                      $cput =  $this->db->get_where('ui_settings',array('type' => 'coupon_set'))->row()->value;
                      if ($cput ==1) 
                        { 
    						  	$cup_frm=$cup_msg='';
    					  		if($this->cart->total_discount() <= 0 && $this->session->userdata('couponer') !== 'done' && $this->cart->get_coupon() == 0)
                          		{
    								$cup_msg='copna-hide';
    							}
    					  		else
    							{
    								$cup_frm='copna-hide';
    							}
    					  		
    						  	?>
    				  			<figure class="frm-coup <?php echo $cup_frm;?>">
    								<figcaption >
    									<?php echo translate('apply_discount_coupon'); ?>
    								</figcaption>	
    								<div class="form-group frm-coup <?php echo $cup_frm;?>">
    								  <input class="form-control coupon_code" type="text" placeholder="<?php echo translate('enter_coupon_code'); ?>">
    								</div>
    								<div class="form-group frm-coup <?php echo $cup_frm;?>">
    								  <button class="ps-btn ps-btn--outline coupon_btn"><?php echo translate('apply');?></button>
    								</div>
    							</figure>
    				  			<h3 class="alert-coup <?php echo $cup_msg;?>">
    								<?php echo translate('discount_coupon_applied'); ?>
    				  			</h3>
    							<?php
    					 
                        }
                    ?>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                    <figure class="frm-shipopt">
						<figcaption >
							<?php echo translate('select_shipping_operator'); ?>
						</figcaption>	
						<div class="form-group ">
							<?php
								echo form_dropdown('shipping_operator',$shpping_operators,'','class="form-control"  id="shipping_operator" onchange="shippingcalc()"')
							?>
						</div>
						<div class="form-group shipping_msg">
							
						</div>
					</figure>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                    <div class="ps-block--shopping-total">
    				  <div class="ps-block__header">
                        <p><?php echo translate('sub_total');?><span id="total"></span></p>
                      </div>
    				  <div class="ps-block__header">
                        <p><?php echo translate('shipping_charge');?><span id="shipping"></span></p>
                      </div>
    				  <div class="ps-block__header" style="display:none;">
                        <p><?php echo translate('tax');?><span id="tax"></span></p>
                      </div>
    				  <div class="ps-block__header">
                        <p>
    						<?php echo translate('coupon_discount');?>
    						<span id="disco"><?php echo currency().$this->cart->total_discount(); ?></span>
    					</p>
                      </div>
                      <div class="ps-block__content">
                        <h3><?php echo translate('total');?> <span class="grand_total" id="grand"></span></h3>
                      </div>
                    </div>
    				<a class="ps-btn ps-btn--fullwidth" href="<?php echo base_url('home/checkout');?>">
    					<?php echo translate('proceed_to_checkout');?>
    				</a>
                </div>
            </div>
          </div>

        </div>
      </div>
    </div>
	<?php
		echo form_open('', array(
			'method' => 'post',
			'id' => 'coupon_set'
		));
		echo form_input(array('type'=>"hidden",'id'=>"coup_frm",'name'=>"code"));
		echo form_close();	
	?>

	<script src="<?php echo base_url(); ?>template/front/assets/js/custom/cart.js"></script>
<style>
	.copna-hide
	{
		display:none;
	}
	figcaption:after {
    content: '' !important;
	}
</style>