



        <?php  
         	 $relatedprds='';
			 $relProduct     =   json_decode($row['related_products']);
			 //print_r($relProduct);
			 $rel_Products=implode(",",$relProduct);
			 //echo count($relProduct);
			 if(count($relProduct)>0)
			 {
				$this->db->where_in('product_id',$relProduct);
			 	$this->db->where(array('status'=>'ok','admin_approved'=>'1','vendor_approved'=>'1'));
			 	$query =  $this->db->get('product');
				//print_r($query->result_array());	
			 	$relatedprds=$query->result_array();
			 }
			 $singlewid='';
			if($relatedprds)
			{
				if(count($relatedprds)==1)
				{
					$singlewid='single-related';
				}
        		?>

            <div class="ps-section__header related-product-header text-center">
                <h3><?php echo translate('related_products');?></h3>
            </div>
            <div class="ps-section__content mb-5" style="border:1px solid #ccc;">
              <div class="  <?php echo $singlewid; ?>" data-owl-auto="false" data-owl-loop="false" data-owl-speed="10000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="7" data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="6" data-owl-duration="1000" data-owl-mousedrag="on"> 
                <?php
                    if($relatedprds)
                    { $n = 0;
                       foreach ($relatedprds as $row2) 
                       { $n++; if($n > 5)     continue;
                           $wish = $this->crud_model->is_wished($row2['product_id']); 
                           $compared = $this->crud_model->is_compared($row2['product_id']);
                           $fpimg=$this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one');
                            ?>
                            <div class="ps-product" id="related" style="margin:15px;">
                              <div class="ps-product__thumbnail">
                                <a href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>">
                                    <?php 
                                        if ($fpimg)
                                        {   
                                            ?>
                                            <img src="<?php echo $fpimg; ?>" />
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <img src="<?php echo base_url().'uploads/product_image/default_product_thumb.jpg'; ?>" /> 
                                            <?php
                                        }
                                    ?>
                                </a>
                                <?php
                                    if($row2['current_stock'] <= 0 && $row2['download'] != 'ok')
                                    { 
                                      ?>
                                      <div class="ps-product__badge out-stock">Out Of Stock</div>
                                      <?php
                                    }
                                    else if($row2['discount'] > 0)
                                    {
                                        ?>
                                            <div class="ps-product__badge">
                                                <?php 
                                                    if($row2['discount_type'] == 'percent')
                                                    {  
                                                        echo '-'.$row2['discount'].'%';
                                                    } 
                                                    else if($row2['discount_type'] == 'amount')
                                                    { 
                                                        echo '-'.currency().$row2['discount'];  
                                                    }
                                                     //echo ' '.translate('off');  
                                                  ?>
                                            </div>
                                        <?php
                                    }
                                ?>
                                <ul class="ps-product__actions">
                                    <li>
                                        <a href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>" data-toggle="tooltip" data-placement="top" title="Read More"><i class="icon-bag2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="icon-eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-toggle="tooltip" data-placement="top" data-pid="<?php echo $row2['product_id']; ?>" <?php if($wish == 'yes'){ ?> class="btn_wished" title="Remove from Wishlist" <?php } else {?>class="btn_wish" title="Add to Wishlist" <?php } ?> onclick="return false;">
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a <?php if($compared == 'yes'){ ?> class="btn_compared" title="Remove from Compare" <?php } else {?> class="btn_compare" title="Compare" <?php } ?> data-toggle="tooltip" data-placement="top" data-pid="<?php echo $row2['product_id']; ?>" href="#"  onclick="return false;">
                                            <i class="icon-chart-bars"></i> 
                                       </a>
                                    </li>
                                </ul>
                              </div>
                              <div class="ps-product__container">
                                <a class="ps-product__vendor" href="<?php echo $this->crud_model->product_by($row2['product_id'],'link_only'); ?>">
                                    <?php 
                                        echo $this->crud_model->product_by($row2['product_id']); 
                                    ?>
                                </a>
                                <div class="ps-product__content">
                                    <a class="ps-product__title" href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>">
                                        <?php 
                                            $str = trim(strip_tags($row2['title']));
                                            if (strlen($str) > 30) $str = substr($str, 0, 30).'..';
                                            echo $str; 
                                        ?>
                                    </a>
                                    

                                    <p class="ps-product__price sale">
                                        <?php 
                                            $pr_price=$this->crud_model->get_product_price($row2['product_id']);
                                            $amount_final=exchangeCurrency($currency_value,$exchange,$pr_price);
                                            echo currency().convertNumber($amount_final); 
                                            if($row2['current_stock'] > 0 && $row2['discount'] > 0)
                                            { 
                                                $pr_price=$row2['sale_price'];
                                                $amount_final=exchangeCurrency($currency_value,$exchange,$pr_price);
                                                echo " <del>".currency().convertNumber($amount_final)." </del>"; 
                                            }
                                        ?>
                                    </p>
                                </div>
                              </div>
                                                  <div class="clr"></div>

                            </div>
                            <?php
                       }
                    }
                ?>
              
                </div>
		</div>
			 
		<?php	
} 
?>
