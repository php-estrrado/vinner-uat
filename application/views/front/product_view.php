  
  <?php
    $currency_value = currency();
    $exchange     =   $this->db->get_where('business_settings', array('type' => 'exchange'))->row()->value; 
    $row        = $product_data[0];
    //print_r($row);
//     $result =   $this->db->join('vendor_prices as V','P.product_id = V.prd_id')->group_by('P.product_id')->order_by('P.product_id','desc')->get('product as P')->result();
//     if($result){ foreach($result as $row){ echo $row->title.' // '; } }
//     echo '<br />';
//  echo  $query   = "SELECT * "
//             . "FROM `product` as `P` "
//             . "JOIN `vendor_prices` as `VP` ON `P`.`product_id` = `VP`.`prd_id` "
//             . "LEFT JOIN `vendor` as `V` ON `VP`.`vendor_id` = `V`.`vendor_id` "
//             . "WHERE `P`.`status` = 'ok' "
//             . "GROUP BY `P`.`product_id` ORDER BY `P`.`product_id` DESC, `V`.`vendor_id` DESC";
//     echo $this->db->query($query)->num_rows();

  ?>
<style> .ps-product__variants .slick-list .item.slick-slide img{ max-height: 80px; }</style>

    <div class="ps-breadcrumb">
      <div class="ps-container">
        <ul class="breadcrumb">
          <li>
            <a href="<?php echo base_url(); ?>">Home</a>
          </li>
          <li>
            <a href="<?php echo base_url('home/category/'.$row['category']); ?>">
              <?php 
                $category_name=$this->crud_model->get_type_name_by_id('category',$row['category'],'category_name');
                echo $category_name; 
              ?>
            </a>
          </li>
          <?php
            $sub_category_name=$this->crud_model->get_type_name_by_id('sub_category',$row['sub_category'],'sub_category_name'); ?>
           
          <li>
            <?php echo ucfirst($row['title']); ?>
          </li>
        </ul>
      </div>
    </div>

    <div class="ps-page--product">
      <div class="ps-container">
        <div class="ps-page__container">
          <div class="ps-page__left">
            <div class="ps-product--detail ps-product--fullwidth">
              <div class="ps-product__header">
                
                <div class="ps-product__thumbnail" data-vertical="true">
                  <?php
                        if ($this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','all'))
                         {
                            $thumbs = $this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','all');
                            $mains = $this->crud_model->file_view('product',$row['product_id'],'','','no','src','multi','all');
                         } 
                         else
                          {
                            $thumbs =array('0' => base_url().'uploads/product_image/default_product_thumb.jpg' );
                            $mains =array('0' => base_url().'uploads/product_image/default_product.jpg' );
                          }
                    ?>
                  <figure>
                    <div class="ps-wrapper">
                      <div class="ps-product__gallery" data-arrow="true">
                        <?php
                          foreach ($mains as $row1) 
                          { ?>
                            <div class="item">
                              <a href="<?php echo $row1; ?>">
                                <img src="<?php echo $row1; ?>" alt="">
                              </a>
                            </div>
                           <?php
                        }
                    ?>
                      </div>
                    </div>
                  </figure>
                  <div class="ps-product__variants" data-item="4" data-md="4" data-sm="4" data-arrow="false">
                      <?php
                          foreach ($thumbs as $rowt) 
                          { ?>
                            <div class="item">
                              <img src="<?php echo $rowt; ?>" alt="">
                            </div>
                           <?php
                        }
                    ?>  
                  </div>
                </div>

                <div class="ps-product__info">
                  <h1><?php echo ucfirst($row['title']); ?></h1>
                  <div class="ps-product__meta">
           
                    <?php 
                        if (file_exists('uploads/product_brochure/brochure_'.$row['product_id'].'.pdf' ) )
                         {
                        	?>
                        	<a download="<?php echo md5($row['product_id']).'.pdf';?>" href="<?php echo base_url().'uploads/product_brochure/brochure_'.$row['product_id'].'.pdf';?>"> 
								<i class="fa fa-download"></i> Download Brochure 
					  		</a>
                        	<?php
                        }
                    ?>
                    <?php
                        $rating = $this->crud_model->rating($row['product_id']);
                        $r = $rating; $i = 0;
                        if($r>0)
                        {
                          ?>
                          <div class="ps-product__rating">
                          <select class="ps-rating" data-read-only="true">
                            <?php
                              while($i<5)
                              {
                                  $i++;
                                  ?>
                                  <option value="<?php if($i<=$r){echo '1';}else{echo '2';}?>"></option>
                                  <?php
                              }
                           ?>
                            </select><span>(<?php echo $row['rating_num']; ?> review)</span> 
                        </div>
                        <?php
                        }
                    ?>
                  </div>

                  <?php 
                    $s_p=$this->crud_model->get_product_price($row['product_id']);
                    $sale_price=exchangeCurrency($currency_value,$exchange,$s_p);
                  ?>
                  <h4 class="ps-product__price sale">
                    <?php 
                      if($sale_price > 0){ echo currency().convertNumber($sale_price);  
                      if($row['current_stock'] > 0 && $row['discount'] > 0)
                        { 
                            $pr_price=$row['sale_price'];
                            $amount_final=exchangeCurrency($currency_value,$exchange,$pr_price);
                            echo " <del>".currency().convertNumber($amount_final)." </del>"; 
                        }
                      }
                    ?>
                  </h4>
                  <div class="ps-product__desc">
      <!--              <p>Sold By:-->
      <!--                <a href="<?php echo $this->crud_model->product_by($row['product_id'],'link_only'); ?>">-->
      <!--                  <strong> -->
      <!--                    <//?php -->
      <!--                      echo $this->//crud_model->product_by($row['product_id']); -->
      <!--                    ?>-->
      <!--                  </strong>-->
      <!--                </a>-->
						<!--<a class='chat_prd_view' href="<?php echo base_url('home/chat/new').'/'.$this->crud_model->product_by($row['product_id'],'id'); ?>"-->
						<!-- >-->
						<!--  Chat with seller-->
      <!--                </a>-->
      <!--              </p>-->
                    <ul class="ps-list--dot">
                      <?php echo $row['short_description'];?>
                    </ul>
                  </div>

                  <?php
                    echo form_open('', array('method' => ''));
                    ?>
                    <div class="ps-product__variations">
                      <?php
                        $all_op = json_decode($row['options'],true);
                        $all_c  = json_decode($row['color']);
                        if(count($all_c)>0)
                        {
                            ?>
                            <figure class="prd-option-color">
                              <figcaption>Color</figcaption>
                              <?php
                                  $n = 0;
                                  foreach($all_c as $i => $p)
                                  {
                                      $c = ''; $n++;
                                      if($a = $this->crud_model->is_added_to_cart($row['product_id'],'option','color'))
                                      {
                                          if($a == $p){  $c = 'checked';  }
                                      } 
                                      else 
                                      {
                                          if($n == 1){  $c = 'checked'; }
                                      } 
                                      ?>
                                      <input type="radio" id="c_<?php echo $i; ?>" name="color" value="<?php echo $p; ?>" <?php echo $c; ?>>
  									  <label style="background:<?php echo $p; ?>;" for="c_<?php echo $i; ?>" class="ps-variant ps-variant--color" ></label>
                                	<?php
                            		}
                          	  ?>
                            </figure>
                            <?php
                        }
                       
                      ?>
                    </div> <?php
                    if($sale_price > 0){ ?>
                    <div class="ps-product__shopping">
                      <?php
                        $stockStatus ='in-stock';
                        if($row['download'] != 'ok' && $row['current_stock'] > 0 ) 
                        { 
                          ?>
                          <figure>
                            <figcaption>Quantity</figcaption>
                            <div class="form-group--number">
							  
                             <span class="down quantity-button" name='subtract' onclick='javascript: quantity_down();'>
                                <i class="fa fa-minus"></i>
                              </span> 
								<input data-max="<?php echo $row['current_stock'];?>" class="form-control quantity-field cart_quantity" type="text" placeholder="1" readonly name='qty' id='qty' value='<?php if($k = $this->crud_model->is_added_to_cart($row['product_id'],'qty')){echo $k;} 
                                 else {echo '1';} ?>' />
							  <span class="up quantity-button" name='add' onclick='quantity_up()' ><i class="fa fa-plus"></i>
							 </span>
                              
                            </div>
                          </figure>
                          <?php
                        }
                        else if($row['download'] != 'ok' && $row['current_stock'] <=0)
                        {
                          $stockStatus = 'out-of-stock';
                          echo '<div class="ps-btn out-stock">Out Of Stock</div>';
                        }
                        else
                        {
                          echo "<input type='hidden' name='qty' value='1' id='qty'/>";
                        }

                        if($row['download'] == 'ok' || $row['current_stock']>0)
                        {
                          $crt_clr='';
                          $crt_text=translate('add_to_cart'); 
                          if($this->crud_model->is_added_to_cart($row['product_id']))
                          { 
                            $crt_text=translate('added_to_cart');
                            $crt_clr='crt-black';
                          }
                          ?>
                          <span class="ps-btn add_to_cart ps-btn--gray <?php echo $stockStatus; echo ' '.$crt_clr;?> "  data-type="text" data-pid="<?php echo $row['product_id']; ?>">
                            <?php echo $crt_text; ?>
                          </span>
                          <span class="ps-btn buy_now <?php echo $stockStatus?>" data-pid='<?php echo $row['product_id']; ?>' data-type="text" >Buy Now</span>
                          <?php
                        }
                        $wish = $this->crud_model->is_wished($row['product_id']); 
                      ?>  
                      <div class="ps-product__actions">
                        <a href data-pid="<?php echo $row['product_id']; ?>" class="<?php if($wish == 'yes'){ ?>btn_wished<?php } else {?>btn_wish<?php } ?>" onclick="return false;">
                          <i class="fa fa-heart"></i>
                        </a>
                        <!-- <a href="#">
                          <i class="icon-chart-bars"></i>
                        </a> -->
                      </div>
                    </div>
                    <?php
                    }
                    echo form_close();
                  ?>
                  <?php 
                    if($this->crud_model->is_added_to_cart($row['product_id']))
                    { ?>
                        <div id="pnopoi"></div>
                        <input type="text" value="1" id="pnval" hidden/>
                        <?php 
                    } 
                    else 
                    { ?> 
                        <div id="pnopo"></div>
                        <input type="text" value="0" id="pnval" hidden/>
                    <?php 
                    } 
                  ?>

                  <div class="ps-product__specification">
                    <!-- <a class="report" href="#">Report Abuse</a> -->
                    <?php
                      if($row['sku'])
                      {
                        ?>
                        <p><strong>SKU:</strong><?php echo $row['sku']; ?></p>
                        <?php
                      }
                    ?>
                    <p class="categories">
                      <strong> Category:</strong>
                      <a href="<?php echo base_url('home/category/'.$row['category']); ?>">
                        <?php echo $category_name;?>
                      </a>
                      
                    </p>
                    <!-- <p class="tags">
                      <strong> Tags</strong>
                      <a href="#">sofa</a>,<a href="#">technologies</a>,<a href="#">wireless</a>
                    </p> -->
                  </div>

                  <div class="" id="share">
                  </div>

                </div>
              </div>

				<?php
					$revactive='';$defactive='active';
					$rva = $this->session->flashdata('review_alert');
            		if(isset($rva))
            		{
						$revactive='active';
						$defactive='';
					}
				?>
              <div class="ps-product__content ps-tab-root">
                <ul class="ps-tab-list">
                  <li class="<?php echo $defactive; ?>"><a href="#tab-1">Description</a></li>
                  <li><a href="#tab-2">Specification</a></li>
                  <li><a href="#tab-3">More Info</a></li>
				  <li><a href="#tab-5">Shipping Info</a></li>
                  <li class="<?php echo $revactive; ?>"><a href="#tab-4">Reviews</a></li>
                  <?php if($row['return_policy'] != ''){ ?><li><a href="#tab-6">Return Policy</a></li><?php } ?>
                </ul>
                <div class="ps-tabs">
                  <div class="ps-tab <?php echo $defactive; ?>" id="tab-1">
                    <div class="ps-document">
                      <?php echo $row['description'];?>
                    </div>
                  </div>
                  <div class="ps-tab" id="tab-2">
                    <?php 
                        $a = $this->crud_model->get_additional_fields($row['product_id']);
                        if(count($a)>0)
                        { ?>
                        <div class="table-responsive">
                          <table class="table table-bordered ps-table ps-table--specification">
                            <tbody>
                              <?php
                                        foreach ($a as $val) 
                                        { 
                                          ?>
                                          <tr>
                                               <td style="text-align:center;">
                                                  <?php echo $val['name']; ?>
                                                </td>
                                                <td style="vertical-align:bottom">
                                                  <?php echo $val['value']; ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                            </tbody>
                          </table>
                        </div>
                      <?php
                    }
                ?>
                  </div>

                  <div class="ps-tab" id="tab-3">
                    <p><?php echo $row['moreinfo'];?></p>
                  </div>

                  <div class="ps-tab <?php echo $revactive; ?>" id="tab-4">
                    <div class="row">
                      <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12 ">
                        <div class="ps-block--average-rating">
                          <div class="ps-block__header">
                            <?php 
                              if($r>0)
                            { 
                              ?>
                                <h3><?php echo $r?></h3>
                                <select class="ps-rating" data-read-only="true">
                                  <?php
                                    $i = 0;
                                  while($i<5)
                                  {
                                      $i++;
                                      ?>
                                      <option value="<?php if($i<=$r){echo '1';}else{echo '2';}?>"></option>
                                      <?php
                                  }
                               ?>
                                </select>
                                <?php
                            }
                        ?>    
                            <span><?php echo $row['rating_num']; ?> Review</span>

                          </div>

                          <!-- <div class="ps-block__star"><span>5 Star</span>
                            <div class="ps-progress" data-value="100"><span></span></div><span>100%</span>
                          </div>
                          <div class="ps-block__star"><span>4 Star</span>
                            <div class="ps-progress" data-value="0"><span></span></div><span>0</span>
                          </div>
                          <div class="ps-block__star"><span>3 Star</span>
                            <div class="ps-progress" data-value="0"><span></span></div><span>0</span>
                          </div>
                          <div class="ps-block__star"><span>2 Star</span>
                            <div class="ps-progress" data-value="0"><span></span></div><span>0</span>
                          </div>
                          <div class="ps-block__star"><span>1 Star</span>
                            <div class="ps-progress" data-value="0"><span></span></div><span>0</span>
                          </div> -->

                        </div>
                      </div>
                      <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12 ">
                        <?php
							include 'product_review.php';  
						?>
                      </div>
                    </div>
                  </div>
                  <div class="ps-tab" id="tab-6">
                        <p><?php if($row['return_policy'] != ''){ echo $row['return_policy']; }?></p>
                  </div>
                  <div class="ps-tab" id="tab-5">
                    <p><?php echo $row['shipping_info'];?></p>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <div class="ps-page__right">
            <?php include 'related_products.php'; ?>
          </div>

        </div>
      </div>
    </div>

    <script type="text/javascript">
	  $('body').on('click', '.quantity-button', function()
      {
        if ($('#pnval').val()==1) 
		{
        	$('#pnopo').attr('id', 'pnopoi'); 
		}
     });
     $('body').on('change', '.optional', function()
     {
        $('.add_to_cart').html(add_to_cart);
     });

       function quantity_up()
	   {
		  var cusck=$("#qty").data('max');
		  var cuqty=$("#qty").val();
		  //console.log(cuqty);
		  if(Number(cuqty)+1 <= Number(cusck))
		  {
			  document.getElementById("qty").value++;
			  if($('.add_to_cart').hasClass("crt-black")) 
				{
					$('.add_to_cart').removeClass("crt-black");
				}  
			  $('.add_to_cart').html(add_to_cart);
		  }
		  else
		  {
			   notify(quantity_exceeds,'warning','bottom','right');
		  }
	   }
	   function quantity_down()
	   {
    		if(document.getElementById("qty").value - 1 <= 0)
        		return;
    		else
        		document.getElementById("qty").value--;
		   		if($('.add_to_cart').hasClass("crt-black")) 
				{
					$('.add_to_cart').removeClass("crt-black");
				}  
			   $('.add_to_cart').html(add_to_cart);
	   }

		
      $(document).ready(function() 
      {
       	$('#share').share({
              networks: ['facebook','twitter','linkedin'],//,'googleplus','tumblr','in1','stumbleupon','digg','email'
              theme: 'square'
          });
			<?php 
            	$rva = $this->session->flashdata('review_alert');
            	if(isset($rva))
            	{ 
             		if($rva == 'review_added')
              		{ 
                	?>
		  				setTimeout(function(){ notify('<?php echo translate('review_added'); ?>','success','bottom','right');}, 800);
                	<?php 
              		} 
					if($rva == 'review_updated')
					{
						?>
		  				setTimeout(function(){ notify('<?php echo translate('review_updated'); ?>','success','bottom','right');}, 800);
		  				<?php
					}
				}
			?>
      });
	 
		
		
    </script>
    <style>
      .crt-black
      {
        background-color: black !important;
      }
	    .prd-option-color input[type="radio"]
		{
			display: none; 
    		cursor: pointer;
		}
		
		.prd-option-color input[type="radio"]:checked+label
		{
			 border: 4px solid #b6baba;
		}	
    </style>
     