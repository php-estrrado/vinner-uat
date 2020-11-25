
		<?php
			$tax        = 0;
	        $shipping   = 0;
	        $grand      = 0; 
			if(count($carted) > 0)
			{ 	
				?>
				<div class="ps-cart__content">
					<?php
						foreach ($carted as $items)
						{
							$prdlink=$this->crud_model->product_link($items['id']);
							?>
				            <div class="ps-product--cart-mobile" data-pid="<?php echo $items['id']; ?>">
				              <div class="ps-product__thumbnail">
				              	<a href="<?php echo $prdlink; ?>">
									<img src="<?php echo $items['image']; ?>" alt="">
			                    </a>
				              </div>
				              <div class="ps-product__content">
				              	<button class="ps-product__remove close remove_from_cart" data-rowid="<?php echo $items['rowid']; ?>" data-pid="<?php echo $items['id']; ?>">
										<i class="icon-cross"></i>
			                      	</button>
				              	<a href="<?php echo $prdlink; ?>"><?php echo $items['name']; ?></a>
				                <p>
				                	<strong>Sold by:</strong>
										<?php 
                                      		echo $this->crud_model->product_by($items['id']); 
                                    	?>
				                </p>
				                <small>
				                	<?php 
				                		echo $this->cart->format_number($items['qty']); ?> x <?php echo currency()." ".$this->cart->format_number($items['price']); 
				                	?>
				                </small>
				              </div>
				            </div>
				         	<?php
				        }
				    ?>
		        </div>
		        <div class="ps-cart__footer">
		            <h3>Sub Total:<strong class="subtotal-cost scroll_grand" id="m_scroll_grand" ></strong></h3>
		            <figure>
		              <a class="ps-btn" href="<?php echo base_url('home/cart_checkout');?>">View Cart</a>
		              <a class="ps-btn" href="<?php echo base_url('home/checkout');?>">Checkout</a>
		            </figure>
		        </div>
		        <?php
		    }
		?>
<script src="<?php echo base_url(); ?>template/front/assets/js/custom/added_list.js"></script>