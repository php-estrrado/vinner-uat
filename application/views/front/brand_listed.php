<?php
$viewtype = 'grid'; $grid_items_per_row = 3;
$currency_value=currency();
    $exchange = $this->db->get_where('business_settings', array('type' => 'exchange'))->row()->value; 

    if(count($products) == 0)
    {  ?>
        <div class="ps-section__content" style="text-align: center;">
            <img src="<?php echo base_url()?>template/front/assets/img/no-result.png">
            <div> Sorry, Your search returns no results.</div>
        </div>
        <?php 
    }
    else
    {
        ?>
        <div id="suggn"></div>
        <?php
           //echo  count($all_products);
            //print_r($all_products) ;
        ?>
        <?php
          if($viewtype == 'list')
          {
                foreach($products as $row2)
                {  
					$wish = $this->crud_model->is_wished($row2['product_id']); 
					$compared = $this->crud_model->is_compared($row2['product_id']);
				    $fpimg=$this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one');
                    ?>
                    <div class="ps-product ps-product--wide">

                        <div class="ps-product__thumbnail">
                            <a href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>">
                                <?php 
                                    if ($fpimg)
                                    {   
                                        ?>
                                        <img src="<?php echo $fpimg; ?>" alt=""/>
                                        <?php
                                    }
                                    else
                                    {
                                      ?>
                                      <img src="<?php echo base_url().'uploads/product_image/default_product_thumb.jpg'; ?>" alt=""/> 
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
                        </div>
                        
                        <div class="ps-product__container">
                            
                            <div class="ps-product__content">
                                <a class="ps-product__title" href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>">
                                  <?php 
                                    $str = trim(strip_tags($row2['title']));
                                    //if (strlen($str) > 30) $str = substr($str, 0, 30).'..';
                                    echo $str; 
                                  ?>
                                </a>
                                <div class="ps-product__rating">
                                    <select class="ps-rating" data-read-only="true">
                                        <?php
                                            $rating = $this->crud_model->rating($row2['product_id']);
                                            $r = $rating; $i = 0;
                                            if($r>0)
                                            {
                                                while($i<5)
                                                {
                                                    $i++;
                                                    ?>
                                                    <option value="<?php if($i<=$r){echo '1';}else{echo '2';}?>"></option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                  <span></span>
                                </div>
                                <p class="ps-product__vendor">
                                  Sold by:
                                  <a class="" href="<?php echo $this->crud_model->product_by($row2['product_id'],'link_only'); ?>">
                                    <?php 
                                      echo $this->crud_model->product_by($row2['product_id']); 
                                    ?>
                                  </a>
                                </p>
                                <ul class="ps-product__desc">
                                  <?php echo $row2['short_description'];?>
                                </ul>
                            </div>
                              
                            <div class="ps-product__shopping">
                                 
                                <p class="ps-product__price sale">
                                    <?php 
                                        $pr_price=$this->crud_model->get_product_price($row2['product_id']);
                                        echo " ".currency().($pr_price); 
                                        if($row2['current_stock'] > 0 && $row2['discount'] > 0)
                                        { 
                                            $pr_price=$row2['sale_price'];
                                            echo " <del>".currency().($pr_price)." </del>"; 
                                        } 
                                    
                                    ?>
                                </p> 

                                <?php
                                    $stockStatus ='in-stock';
                                    if($row2['download'] != 'ok' && $row2['current_stock'] <=0)
                                    {
                                      $stockStatus = 'out-of-stock';
                                      echo '<div class="ps-btn out-stock">Out Of Stock</div>';
                                    }
                                    if($row2['download'] == 'ok' || $row2['current_stock']>0)
                                    {
                                      $crt_clr='';
                                      $crt_text=translate('add_to_cart'); 
                                      if($this->crud_model->is_added_to_cart($row2['product_id']))
                                      { 
                                        $crt_text=translate('added_to_cart');
                                        $crt_clr='crt-black';
                                      }
                                        ?>
                                        <span class="ps-btn add_to_cart ps-btn--gray <?php echo $stockStatus; echo ' '.$crt_clr;?> "  data-type="text" data-pid="<?php echo $row2['product_id']; ?>">
                                        <?php echo $crt_text; ?>
                                      </span>
                                        <?php
                                      }  
                                ?>
                                 
                                <ul class="ps-product__actions">
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

                            
                        </div>
                    
                    </div>
                    <?php
                    
                }
          }
          else if($viewtype == 'grid')
            {
                $f_num = (12/$grid_items_per_row);
                $n = 0;
                ?>
                <div class="row">
                    <?php 
                        foreach($products as $row2)
                        {
							$wish = $this->crud_model->is_wished($row2['product_id']); 
							$compared = $this->crud_model->is_compared($row2['product_id']);
				    $fpimg=$this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one');
                            $n++;
                            ?>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                <div class="ps-product">
                                  <div class="ps-product__thumbnail">
                                      <a href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>">
                                        <?php 
                                          if ($fpimg)
                                          {   
                                            ?>
                                            <img src="<?php echo $fpimg; ?>" alt=""/>
                                            <?php
                                          }
                                          else
                                          {
                                            ?>
                                            <img src="<?php echo base_url().'uploads/product_image/default_product_thumb.jpg'; ?>" alt=""/> 
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
<!--                                          <li>
                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="icon-eye"></i>
                                            </a>
                                          </li>-->
                                          <li>
                                            <a href="#" data-toggle="tooltip" data-placement="top" data-pid="<?php echo $row2['product_id']; ?>" <?php if($wish == 'yes'){ ?> class="btn_wished" title="Remove from Wishlist" <?php } else {?>class="btn_wish" title="Add to Wishlist" <?php } ?> onclick="return false;">
                                              <i class="fa fa-heart"></i>
                                            </a>
                                          </li>
<!--                                          <li>
                                            <a <?php if($compared == 'yes'){ ?> class="btn_compared" title="Remove from Compare" <?php } else {?> class="btn_compare" title="Compare" <?php } ?> data-toggle="tooltip" data-placement="top" data-pid="<?php echo $row2['product_id']; ?>" href="#"  onclick="return false;">
                                            <i class="icon-chart-bars"></i> 
                                       		</a>
                                          </li>-->
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
                                        
                                          <div class="ps-product__rating">
                                            <select class="ps-rating" data-read-only="true">
                                              <?php
                                                $rating = $this->crud_model->rating($row2['product_id']);
                                                $r = $rating; $i = 0;
                                                if($r>0)
                                                {
                                                    while($i<5)
                                                    {
                                                        $i++;
                                                        ?>
                                                        <option value="<?php if($i<=$r){echo '1';}else{echo '2';}?>"></option>
                                                        <?php
                                                    }
                                                }
                                              ?>
                                            </select>
                                            <span></span>
                                          </div>
                                          
                                          <p class="ps-product__price sale">
                                            <?php 
                                                    $pr_price=$this->crud_model->get_product_price($row2['product_id']);
                                                    if($pr_price > 0){ echo currency().$pr_price; } 
                                                    if($row2['current_stock'] > 0 && $row2['discount'] > 0)
                                                      { 
                                                        $pr_price=$row2['sale_price'];
                                                        echo " <del>".currency().($pr_price)." </del>"; 
                                                      }
                                                ?>
                                          </p>
                                 
                                      </div>
                                      
                                      <div class="ps-product__content hover">
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
                                                if($pr_price > 0){ echo currency().$pr_price; }
                                                if($row2['current_stock'] > 0 && $row2['discount'] > 0)
                                                    { 
                                                        $pr_price=$row2['sale_price'];
                                                        echo " <del>ss".currency().$pr_price." </del>"; 
                                                    }
                                            ?>
                                        </p>
                                      </div>
                                     
                                  </div>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                </div>
              
              <?php
            }
    }   ?>

<!-- Render pagination links -->
<?php if($totalpage > 1){ ?>
<div class="ps-pagination">
    <ul class="pagination ">
        <?php echo $this->custom_pagination->create_links(base_url('home/industryProducts/?pg=1'),$currPage,$totalpage); ?>
    </ul>
</div>
<?php } ?>
<script src="<?php echo base_url(); ?>template/drsnew/js/product-list-main.js"></script>
<script type="text/javascript">
  $(document).ready(function() 
  {
      $("i.icon-eye").parents('li').css("display", "none");
	  $('[data-toggle="tooltip"]').tooltip();
  });
</script>
<style> .widget_shop{ height: 100%; }</style>
