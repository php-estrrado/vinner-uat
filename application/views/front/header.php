  <?php
	$carted = $this->cart->contents();
    $categories = $this->db->order_by('category_name')->get('category')->result_array();
    $ctrl_function=$this->router->fetch_method();
    if($ctrl_function!="cart_checkout" && $ctrl_function!="checkout")
    {
        $userid=$this->session->userdata('user_id');
        if($userid==0)
        {
            $this->session->unset_userdata('user_login');
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('user_name');
        }
    }

  ?>

<body>
    <header class="header header--1" data-sticky="true">
      <div class="header__top">
        <div class="ps-container">

          <div class="header__left">
            <div class="menu--product-categories">
              <!--<div class="menu__toggle">-->
              <!--  <i class="icon-menu"></i><span> <?php echo translate('shop by_category');?></span>-->
              <!--</div>-->
              <div class="menu__content">
                <ul class="menu--dropdown">
                  <?php
                  
                    //$categories = $this->db->get('category')->result_array();
                    foreach($categories as $row)
                      {
                        ?>
                        <li class="menu-item-has-children has-mega-menu">
                          <a href="<?php echo base_url('home/category/'.$row['category_id']); ?>">
                            <!-- <i class="icon-car-siren"></i> -->
                            <?php echo ucfirst($row['category_name']); ?>
                          </a>
                          <?php
                            $sub_category_qry = $this->db->get_where('sub_category',array('category'=>0));
                            if($sub_category_qry->num_rows()>0)
                            {
                              $sub_categories=$sub_category_qry->result_array();
                              ?>
                              <div class="mega-menu">
                                <div class="mega-menu__column">
                                  <!-- <h4>Electronic<span class="sub-toggle"></span></h4> -->
                                  <ul class="mega-menu__list">
                                    <?php
                                    foreach($sub_categories as $sub_cats)
                                    {
                                      ?>
                                      <li>
                                        <a href="<?php echo base_url('home/category/'.$row['category_id'].'/'.$sub_cats['sub_category_id']); ?>">
                                          <?php echo ucfirst($sub_cats['sub_category_name']);?>
                                        </a>
                                      </li>
                                      <?php
                                    }
                                    ?>
                                  </ul>
                                </div>
                              </div>
                              <?php
                            }
                          ?>
                        </li>
                        <?php
                      }
                  ?>
                </ul>
              </div>
            </div>
              <a class="ps-logo" href="<?php echo base_url(); ?>">
                <img src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="">
              </a>
          </div>

          <div class="header__center">
            <?php 
              echo form_open(base_url().'home/main_search', array('method' => 'post','role' => 'search','id'=>'search-form','class'=>'ps-form--quick-search mt-4')); ?> 
                <input name="query" class="form-control query-search-id" type="text" placeholder="I'm shopping for...">
                <button type="submit">Search</button>
                <?php
              echo form_close();
            ?>
          </div>
		 
		  <div class="header__right">
            <div class="header__actions mt-4">
              <!--<a class="header__extra" href="<?php echo base_url('home/compare'); ?>" title="Compare">-->
              <!--  <i class="icon-chart-bars"></i><span><i id="compare_num"><?php if($this->session->userdata('compare')){ echo count($this->session->userdata('compare')); } ?></i></span>-->
              <!--</a>-->
              <a class="header__extra" href="<?php echo base_url('home/profile/wishlist');?>" title="Wish List">
                <i class="icon-heart"></i>
				  <span class="count_wished">0</span>
              </a>
              <div class="ps-cart--mini">
				<a class="header__extra" href="<?php echo base_url('home/cart_checkout');?>" title="Product Cart">
					<i class="icon-bag2"></i><span id="counter"><?php echo count($carted); ?></span>
				</a>
				<?php 
				  if($ctrl_function != 'cart_checkout' && $ctrl_function !="checkout")
				  { 
				  	?>  
					<div class="ps-cart__content" id='added_list'>
					</div>
				  	<?php
				  }
				?>
              </div>
              <div class="ps-block--user-header">
                <div class="ps-block__left"><i class="icon-user"></i></div>
                <div class="ps-block__right loginsets" id="loginsets">
                  <!-- <a href="my-account.html">Login</a>
                  <a href="my-account.html">Register</a> -->
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>

      <nav class="navigation">
        <div class="ps-container">
          <div class="navigation__right" style="padding-left:0;">
            <ul class="menu">
              <li class="menu-item">
                <a href="<?php echo base_url(); ?>"><?php echo translate('home');?></a>               
              </li>  
               <li class="menu-item">
                <a href="<?php echo base_url('home/about'); ?>"><?php echo translate('about');?></a>         
              </li>  
              <!-- 
                <li class="urrent-menu-item menu-item-has-children">
                    <a href="blog-small-thumb.html">Blog</a><span class="sub-toggle"></span>
                    <ul class="sub-menu">
                        <li><a href="blog-small-thumb.html">bloglist</a>
                        </li>
                        <li><a href="blog-small-thumb.html">bloglist</a>
                        </li>                 
                    </ul>
                </li>
              -->
			 <!--
              <li class="menu-item-has-children has-mega-menu">               
                <a href="<?php echo base_url('home/brands');?>">Brands</a><span class="sub-toggle"></span>
                <div class="mega-menu">
                  <div class="mega-menu__column">
                    <ul class="mega-menu__list">
                      <?php
                        $brand_qry= $this->db->order_by('brand_id', 'desc')->limit('6')->get('brand');
                        if($brand_qry->num_rows()>0)
                        { 
                          $brand_data= $brand_qry->result_array();
                          foreach($brand_data as $brnds)
                          { 
                            ?>
                            <li>
                              <a href="<?php echo base_url(); ?>home/brand/<?php echo $brnds['brand_id'];?>">
                                <?php echo ucfirst($brnds['name']);?>
                              </a>
                            </li>
                            <?php
                          }
                        }
                      ?>
                      <li>
                        <a href="<?php echo base_url(); ?>home/brands">ALL BRANDS</a>
                      </li>                      
                    </ul>
                  </div>

                </div>
              </li>   -->
            </ul>
            <ul class="navigation__extra">
              <!-- <li><a href="<?php echo base_url('vendor/sell'); ?>">Sell with us</a></li> -->
              <li><a href="<?php echo base_url('home/servicerequest'); ?>">Request For Service</a></li>
              <li><a href="<?php echo base_url('home/demorequest'); ?>">Request For Demo</a></li>
              <li><a href="<?php echo base_url('home/trackorder'); ?>"><?php echo translate('track_order');?></a></li>
              <li>
                  <?php if(wh_currency() == ''){ 
                            $whCurrency = 'AED'; 
                            $cntry['code'] = 'AE'; $cntry['name'] = 'United Arab Emirates'; 
                            $whCountry  =   (object)$cntry;
                        }else{ $whCurrency = wh_currency(); $whCountry = wh_country(); } ?>
                <div class="ps-dropdown"><a href=""><?php echo $whCurrency?></a>
                  <!-- <ul class="ps-dropdown-menu">
                    <li><a href="#">Us Dollar</a></li>
                    <li><a href="#">Euro</a></li>
                  </ul> -->
                </div>
              </li>
              <li>
                <div class="ps-dropdown language">
					<a href="#"><img src="<?php echo base_url('template/drsnew/img/countries/flags/'.$whCountry->code.'.png'); ?>" alt=""><?php echo $whCountry->name ?></a><?php
                    if(countries()){ ?>
                        <ul class="ps-dropdown-menu"><?php 
                            foreach(countries() as $row){ 
                                if($whCountry->code == $row->sortname){ continue; }?>
                            <li><a id="<?php echo $row->sortname?>" class="wh-region">
                                    <img src="<?php echo base_url('template/drsnew/img/countries/flags/'.$row->sortname.'.png')?>" class="ps-dropdown-img" alt=""><?php echo $row->sortname?>
                                </a></li><?php
                            } ?>
                         <!--<li><a href="#"><img src="img/flag/fr.png" alt=""> France</a></li>-->
                       </ul><?php
                    } ?>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <header class="header header--mobile" data-sticky="true">
      <div class="header__top">
        <!-- <div class="header__left">
          <p>Welcome to Multicommerce Online Shopping Store !</p>
        </div> -->
        <div class="header__right">
          <ul class="navigation__extra">
            <li>
              <div class="ps-dropdown"><a href=""><?php echo wh_currency()?></a>
                <!-- <ul class="ps-dropdown-menu">
                  <li><a href="#">Us Dollar</a></li>
                  <li><a href="#">Euro</a></li>
                </ul> -->
              </div>
            </li>
            <li>
              <div class="ps-dropdown language">
					<a href="#"><img src="<?php echo base_url('template/drsnew/img/countries/flags/'.wh_country()->code.'.png'); ?>" alt=""><?php echo wh_country()->name ?></a><?php
                    if(countries()){ ?>
                        <ul class="ps-dropdown-menu"><?php 
                            foreach(countries() as $row){
                                if(wh_country()->code == $row->sortname){ continue; }?>
                            <li><a id="<?php echo $row->sortname?>" class="wh-region">
                                    <img src="<?php echo base_url('template/drsnew/img/countries/flags/'.$row->sortname.'.png')?>" class="ps-dropdown-img" alt=""><?php echo $row->name?>
                                </a>
                            </li><?php
                            } ?>
                         <!--<li><a href="#"><img src="img/flag/fr.png" alt=""> France</a></li>-->
                       </ul><?php
                    } ?>
              </div>
            </li>
          </ul>
        </div>
      </div>

      <div class="navigation--mobile">
        <div class="navigation__left">
          <a class="ps-logo" href="<?php echo base_url(); ?>">
            <img src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="">
          </a>
        </div>
        <div class="navigation__right">
          <div class="header__actions">
            <div class="ps-block--user-header">
              <div class="ps-block__left"><i class="icon-user"></i></div>
              <div class="ps-block__right loginsets" >
        	  </div>
            </div>
          </div>
        </div>
      </div>


      <div class="ps-search--mobile">
        <?php 
          echo form_open(base_url().'home/main_search', array('method' => 'post','role' => 'search','id'=>'ms-search-form','class'=>'ps-form--search-mobile')); ?>
            <div class="form-group--nest">
        	  <input id="" name="category" value='0' hidden />  
              <input name="query" class="form-control query-search-id" type="text" placeholder="Search something...">
              <button type="submit"><i class="icon-magnifier"></i></button>
            </div>
            <?php
          echo form_close();
        ?>
      </div>

    </header>

    <div class="ps-panel--sidebar" id="cart-mobile">
      <div class="ps-panel__header">
        <h3>Shopping Cart</h3>
      </div>
      <div class="navigation__content">
        <div class="ps-cart--mobile" id="mobile_added_list">
          
        </div>
      </div>
    </div>

    <div class="ps-panel--sidebar" id="navigation-mobile">
      <div class="ps-panel__header">
        <h3>Categories</h3>
      </div>
      <div class="ps-panel__content">
        <ul class="menu--mobile">
          <!-- <li>
            <a href="#">Hot Promotions</a>
          </li> -->
          <?php
            foreach($categories as $row)
              {
                ?>
                <li class="menu-item-has-children has-mega-menu">
                  <a href="<?php echo base_url('home/category/'.$row['category_id']); ?>">
                    <?php echo ucfirst($row['category_name']); ?>
                  </a>
                  <?php
                    $sub_category_qry = $this->db->get_where('sub_category',array('category'=>0));
                    if($sub_category_qry->num_rows()>0)
                      {
                        $sub_categories=$sub_category_qry->result_array();
                        ?>
                        <span class="sub-toggle"></span>
                        <div class="mega-menu">
                          <div class="mega-menu__column">
                            <!-- <h4>Electronic<span class="sub-toggle active"></span></h4> -->
                            <ul class="mega-menu__list" style="display: block;">
                              <?php
                                foreach($sub_categories as $sub_cats)
                                {
                                  ?>
                                  <li>
                                    <a href="<?php echo base_url('home/category/'.$row['category_id'].'/'.$sub_cats['sub_category_id']); ?>">
                                      <?php echo ucfirst($sub_cats['sub_category_name']);?>
                                    </a>
                                  </li>
                                  <?php
                                }
                              ?>
                            </ul>
                          </div>
                        </div>
                        <?php
                      }
                  ?>
                </li>
                <?php
              }
          ?>
        </ul>
      </div>
    </div>
    <div class="navigation--list">
      <div class="navigation__content">
        <a class="navigation__item ps-toggle--sidebar" href="#menu-mobile">
          <i class="icon-menu"></i><span> Menu</span>
        </a>
        <a class="navigation__item ps-toggle--sidebar" href="#navigation-mobile">
          <i class="icon-list4"></i><span> Categories</span>
        </a>
        <a class="navigation__item ps-toggle--sidebar" href="#search-sidebar">
          <i class="icon-magnifier"></i><span> Search</span>
        </a>
        <a class="navigation__item  <?php if($ctrl_function == 'cart_checkout' || $ctrl_function =="checkout"){ echo ' active" '; } else{ ?> ps-toggle--sidebar" href="#cart-mobile" <?php } ?>>
          <i class="icon-bag2"></i><span> Cart</span>
        </a>
      </div>
    </div>
<?php // print_r( $this->session->userdata() ); ?>
    <div class="ps-panel--sidebar" id="search-sidebar">
      <div class="ps-panel__header">
        <?php 
          echo form_open(base_url().'home/main_search', array('method' => 'post','role' => 'search','id'=>'m-search-form','class'=>'ps-form--search-mobile')); ?>
            <div class="form-group--nest">
        <input name="category" value='0' hidden />
              <input name="query" class="form-control query-search-id" type="text" placeholder="Search something...">
              <button type="submit"><i class="icon-magnifier"></i></button>
            </div>
            <?php
          echo form_close();
        ?>
      </div>
      <div class="navigation__content"></div>
    </div>

    <div class="ps-panel--sidebar" id="menu-mobile">
      <div class="ps-panel__header">
        <h3>Menu</h3>
      </div>
      <div class="ps-panel__content">
        <ul class="menu--mobile">
          <li class="current-menu-item menu-item-has-children">
            <a href="<?php echo base_url(); ?>">Home</a>
          </li>
		 <?php /*
          <li class="menu-item-has-children has-mega-menu">
            <a href="<?php echo base_url(); ?>home/brands">Brands</a>
            <span class="sub-toggle"></span>
            <div class="mega-menu">
              <div class="mega-menu__column">
                <ul class="mega-menu__list" style="display: block;">
                  <?php
                    if($brand_qry->num_rows()>0)
                      { 
                        $brand_data= $brand_qry->result_array();
                        foreach($brand_data as $brnds)
                        { 
                          ?>
                          <li>
                            <a href="<?php echo base_url(); ?>home/brand/<?php echo $brnds['brand_id'];?>">
                              <?php echo ucfirst($brnds['name']);?>
                            </a>
                          </li>
                          <?php
                        }
                      }
                  ?>
                  <li>
                    <a href="<?php echo base_url(); ?>home/brands">ALL BRANDS</a>
                  </li>
                </ul>
              </div>
            </div>
          </li>  */ ?>
        </ul>
      </div>
    </div>

    <?php 
      function exchangeCurrency($currency_value,$exchange,$pr_price)
      {
          if($currency_value=='USD')
            { $amount_final=$pr_price/$exchange; } else{ $amount_final=$pr_price; }
          return($amount_final);
      }
      function convertNumber($number) 
      {
          $number=round($number);
          return str_replace('.00', '', number_format($number, $decimals=2, $dec_point='.', $thousands_sep=','));
      }
   ?>
   
<script type="text/javascript">
    $(document).ready(function(){ 
        $('.wh-region').on('click',function(){ 
            var id      =   this.id; 
            msg = 'If you change Region, Your cart items will be removed.';
            bootbox.confirm(msg, function(result) {
                if (result) { 
                    $.ajax({
                       type: "GET",
                       url: '<?php echo base_url('home/change/region/')?>'+id,
                       success: function (data) {
                           window.location.reload();
                       }
                     }); 
                }; 
            }); 
                  
                  
            
        });
    });
</script>