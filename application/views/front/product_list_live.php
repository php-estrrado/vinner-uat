   

    <div class="ps-breadcrumb">
      <div class="ps-container">
        <ul class="breadcrumb">
          <li><a href="<?php echo base_url(); ?>">Home</a></li>
          <?php
            if($cur_category>0)
            { 
              $category_name=$this->crud_model->get_type_name_by_id('category',$cur_category,'category_name');
              ?>
              <li>
                <a href="<?php echo base_url('home/category/'.$cur_category); ?>">
                  <?php echo ucfirst($category_name); ?>
                </a>
              </li>
              <?php
            }
            else
            {
              $cur_category=0;
            }
            if($cur_sub_category>0)
            { 
              $sub_category_name=$this->crud_model->get_type_name_by_id('sub_category',$cur_sub_category,'sub_category_name');
              ?>
              <li>
                <a href="<?php echo base_url('home/category/'.$cur_category.'/'.$cur_sub_category); ?>">
                  <?php echo ucfirst($sub_category_name); ?>
                </a>
              </li>
              <?php
            }
            else
            {
              $cur_sub_category=0;
            }
          ?>
        </ul>
      </div>
    </div>
    <div class="ps-page--shop">
      <div class="ps-container">
        <div class="mt-5 mb-5">

        </div>
        <div class="ps-layout--shop">
          <div class="ps-layout__left">
            <aside class="widget widget_shop">
              <h4 class="widget-title">Categories</h4>
              <ul class="ps-list--categories">
                <?php 
                  foreach($all_category as $row)
                  {
                    ?>
                    <li class="menu-item-has-children">
                      <a href="<?php echo base_url('home/category/'.$row['category_id']); ?>">
                        <?php echo ucfirst($row['category_name']); ?>
                      </a>
                      <?php
                        $sub_category_qry = $this->db->get_where('sub_category',array('category'=>$row['category_id']));
                        if($sub_category_qry->num_rows()>0)
                          {
                            $cat_active='';$sub_dis='';
                            $cat_active=($cur_category==$row['category_id'])?'active':'';
                            $sub_dis=($cur_category==$row['category_id'])?'display: block':'';
                            $sub_categories=$sub_category_qry->result_array();
                            ?>
                            <span class="sub-toggle <?php echo $cat_active; ?>">
                              <i class="fa fa-angle-down"></i>
                            </span>
                            <ul class="sub-menu" style="<?php echo $sub_dis; ?>">
                              <?php
                                foreach($sub_categories as $sub_cats)
                                {
                                  ?>
                                  <li class="">
                                    <?php
                                      if($cur_sub_category==$sub_cats['sub_category_id'])
                                      {
                                        echo ucfirst($sub_cats['sub_category_name']);
                                      }
                                      else
                                      {
                                        ?>
                                        <a href="<?php echo base_url('home/category/'.$row['category_id'].'/'.$sub_cats['sub_category_id']); ?>">
                                          <?php echo ucfirst($sub_cats['sub_category_name']);?>
                                        </a>
                                        <?php
                                      }  
                                      ?>
                                  </li>
                                  <?php
                                } 
                              ?>
                            </ul>
                            <?php
                          }
                      ?>
                    </li>
                    <?php
                  }
                ?>
              </ul>
            </aside>
            <aside class="widget widget_shop">
              <h4 class="widget-title">BY BRANDS</h4>
              <figure class="ps-custom-scrollbar" data-height="250">
                <div class="ps-checkbox">
                  <input class="form-control" type="checkbox" id="brand-1" name="brand"/>
                  <label for="brand-1">Adidas (3)</label>
                </div>
                <div class="ps-checkbox">
                  <input class="form-control" type="checkbox" id="brand-2" name="brand"/>
                  <label for="brand-2">Amcrest (1)</label>
                </div>
              </figure>
              <figure>
                <h4 class="widget-title">By Price</h4>
                <div class="ps-slider" data-default-min="13" data-default-max="1300" data-max="1311" data-step="100" data-unit="$"></div>
                <p class="ps-slider__meta">Price:<span class="ps-slider__value ps-slider__min"></span>-<span class="ps-slider__value ps-slider__max"></span></p>
              </figure>
            </aside> 
          </div>
          <div class="ps-layout__right">
            <div class="ps-shopping ps-tab-root">
              <!-- <a class="ps-shop__filter-mb" href="#" id="filter-sidebar"><i class="icon-menu"></i> Show Filter
              </a> -->

              <div class="ps-shopping__header">
                <p><strong><?php echo count($all_products); ?></strong> Products found</p>
                <div class="ps-shopping__actions">
                  <select class="ps-select" data-placeholder="Sort Items">
                    <option>Sort by latest</option>
                    <option>Sort by popularity</option>
                    <option>Sort by price: low to high</option>
                    <option>Sort by price: high to low</option>
                  </select>
                  <div class="ps-shopping__view">
                    <p>View</p>
                    <ul class="ps-tab-list">
                      <li class="active"><a href="#tab-1"><i class="icon-grid"></i></a></li>
                      <li><a href="#tab-2"><i class="icon-list4"></i></a></li>
                    </ul>
                  </div>
                </div>
              </div>

              <?php
                //print_r($all_products);
              ?>
              <div class="ps-tabs">
                <div class="ps-tab active" id="tab-1">
                  <div class="row">
                    <?php 
                      $fl=1;
                      foreach($all_products as $row2) 
                        {
                          if($fl>16) 
                          { 
                            break;  
                          }
                          $fl++;
                          ?>
                          <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                            <div class="ps-product">
                              <div class="ps-product__thumbnail">
                                  <a href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>">
                                    <?php 
                                      if ($this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one'))
                                  {   
                                    ?>
                                        <img src="<?php echo $this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one'); ?>" alt=""/>
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
                                      <li>
                                        <a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="icon-eye"></i>
                                        </a>
                                      </li>
                                      <li>
                                        <a href="#" data-toggle="tooltip" data-placement="top" data-pid="<?php echo $row2['product_id']; ?>" <?php if($wish == 'yes'){ ?> class="btn_wished" title="Remove from Whishlist" <?php } else {?>class="btn_wish" title="Add to Whishlist" <?php } ?> onclick="return false;">
                                          <i class="fa fa-heart"></i>
                                        </a>
                                      </li>
                                      <li>
                                        <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i>
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
                                                $amount_final=exchangeCurrency($currency_value,$exchange,$pr_price);
                                                echo "$".convertNumber($amount_final); 
                                                if($row2['current_stock'] > 0 && $row2['discount'] > 0)
                                                  { 
                                                    $pr_price=$row2['sale_price'];
                                                    $amount_final=exchangeCurrency($currency_value,$exchange,$pr_price);
                                                    echo " <del>$".convertNumber($amount_final)." </del>"; 
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
                                                $amount_final=exchangeCurrency($currency_value,$exchange,$pr_price);
                                                echo "$".convertNumber($amount_final); 
                                                if($row2['current_stock'] > 0 && $row2['discount'] > 0)
                                                  { 
                                                    $pr_price=$row2['sale_price'];
                                                    $amount_final=exchangeCurrency($currency_value,$exchange,$pr_price);
                                                    echo " <del>$".convertNumber($amount_final)." </del>"; 
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
                  <div class="ps-pagination">
                    <ul class="pagination">
                      <li class="active"><a href="#">1</a></li>
                      <li><a href="#">2</a></li>
                      <li><a href="#">3</a></li>
                      <li><a href="#">Next Page<i class="icon-chevron-right"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="ps-tab" id="tab-2">
                  <?php
                    $fl2=1;
                    foreach($all_products as $row2) 
                    {
                      if($fl2>6) 
                      { 
                        break;  
                      }
                      $fl2++;
                      ?>
                          <div class="ps-product ps-product--wide">
                            <div class="ps-product__thumbnail">
                                <a href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>">
                                  <?php 
                                    if ($this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one'))
                                    {   
                                       ?>
                                      <img src="<?php echo $this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one'); ?>" alt=""/>
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
                                        $amount_final=exchangeCurrency($currency_value,$exchange,$pr_price);
                                        echo " $".convertNumber($amount_final); 
                                        if($row2['current_stock'] > 0 && $row2['discount'] > 0)
                                          { 
                                            $pr_price=$row2['sale_price'];
                                            $amount_final=exchangeCurrency($currency_value,$exchange,$pr_price);
                                            echo " <del>$".convertNumber($amount_final)." </del>"; 
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
                                      $wish = $this->crud_model->is_wished($row2['product_id']); 
                                  ?>
                                  
                                  <ul class="ps-product__actions">
                                    <li>
                                      <a href="#" data-toggle="tooltip" data-placement="top" data-pid="<?php echo $row2['product_id']; ?>" <?php if($wish == 'yes'){ ?> class="btn_wished" title="Remove from Whishlist" <?php } else {?>class="btn_wish" title="Add to Whishlist" <?php } ?> onclick="return false;">
                                          <i class="fa fa-heart"></i>
                                      </a>
                                    </li>
                                    <li>
                                      <a data-toggle="tooltip" data-placement="top" data-pid="<?php echo $row2['product_id']; ?>" href="#" title="Compare" >
                                            <i class="fa fa-bar-chart"></i> 
                                      </a>
                                    </li>
                                  </ul>
                              </div>
                            </div>
                          </div>
                      <?php
                    }
                  ?>     
                  
                  <div class="ps-pagination">
                    <ul class="pagination">
                      <li class="active"><a href="#">1</a></li>
                      <li><a href="#">2</a></li>
                      <li><a href="#">3</a></li>
                      <li><a href="#">Next Page<i class="icon-chevron-right"></i></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>