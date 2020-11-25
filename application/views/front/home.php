

<div id="homepage-1">

      <div class="ps-home-banner ps-home-banner--1">
        <div class="ps-container">
          <div class="ps-section__left">
            <div class="ps-carousel--nav-inside owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on">
              
              <?php
                $i = 0;
                $slides = $this->db->get('slides')->result_array();
                foreach ($slides as $row) 
                  { 
                    $i++;  
                    ?>  
                      <div class="ps-banner">
                        <a href="<?php echo $row['sl_link']; ?>">
                          <img src="<?php echo $this->crud_model->file_view('slides',$row['slides_id'],'','','no','src','','','.jpg') ?>" alt="<?php echo $row['alt_text']; ?>" title="<?php echo $row['name']; ?>" alt="<?php echo $row['alt_text']; ?>">
                        </a>
                      </div>
                    <?php                   
                  }
              ?>

            </div>
          </div>

          <div class="ps-section__right ml-5">
			<?php
			  $place = 'after_slider';
              $query = $this->db->get_where('banner',array('page'=>'home', 'place'=>$place, 'status' => 'ok'));
              $banners = $query->result_array();
              if($query->num_rows() > 0)
			  {
                  $r = 12/$query->num_rows();
              }
			  foreach($banners as $row)
			  {
			  	?>
					<a class="ps-collection" href="<?php echo $row['link']; ?>">
					  <img src="<?php echo $this->crud_model->file_view('banner',$row['banner_id'],'','','no','src') ?>" alt="">
					</a>
			  	<?php
			  }
			?>
          </div>
        </div>
      </div>

      <div class="ps-site-features">
        <div class="ps-container">
          <div class="ps-block--site-features">
            <div class="ps-block__item">
              <div class="ps-block__left"><i class="icon-rocket"></i></div>
              <div class="ps-block__right">
                <h4>Free Delivery</h4>
                <p>For all orders over 1000 AED</p>
              </div>
            </div>
            <div class="ps-block__item">
              <div class="ps-block__left"><i class="icon-sync"></i></div>
              <div class="ps-block__right">
                <h4>90 Days Return</h4>
                <p>If goods have problems</p>
              </div>
            </div>
            <div class="ps-block__item">
              <div class="ps-block__left"><i class="icon-credit-card"></i></div>
              <div class="ps-block__right">
                <h4>Secure Payment</h4>
                <p>100% secure payment</p>
              </div>
            </div>
            <div class="ps-block__item">
              <div class="ps-block__left"><i class="icon-bubbles"></i></div>
              <div class="ps-block__right">
                <h4>24/7 Support</h4>
                <p>Dedicated support</p>
              </div>
            </div>
            <div class="ps-block__item ps-block__item_last">
              <div class="ps-block__left"><i class="icon-gift"></i></div>
              <div class="ps-block__right">
                <h4>Gift Service</h4>
                <p>Support gift service</p>
              </div>
            </div>
          </div>
        </div>
      </div>


      <?php
        include 'latest_products.php';
      ?>
      

      <div class="ps-home-ads">
        <div class="ps-container">
          <div class="row">

            <?php
              $place = 'after_latest';
              $query = $this->db->get_where('banner',array('page'=>'home', 'place'=>$place, 'status' => 'ok'));
              $banners = $query->result_array();
              if($query->num_rows() > 0){
                  $r = 12/$query->num_rows();
              }
              foreach($banners as $row)
                {
                  ?>
                  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">
                    <a class="ps-collection" target="_blank" href="<?php echo $row['link']; ?>">
                      <img src="<?php echo $this->crud_model->file_view('banner',$row['banner_id'],'','','no','src') ?>" alt="">
                    </a>
                  </div>
                  <?php
                }
            ?>

          </div>
        </div>
      </div>


      <?php
        include 'featured_products.php';
      ?>
      

      <div class="ps-home-ads">
        <div class="ps-container">
          <div class="row">
            <?php
              $place = 'after_featured';
              $query = $this->db->get_where('banner',array('page'=>'home', 'place'=>$place, 'status' => 'ok'));
              $banners = $query->result_array();
              if($query->num_rows() > 0)
              {
                  $r = 12/$query->num_rows();
              }
              foreach($banners as $row)
                { 
                  ?>
                  <div class="col-xl-<?php echo $r; ?> col-lg-<?php echo $r; ?> col-md-12 col-sm-12 col-12 ">
                    <a class="ps-collection" href="<?php echo $row['link']; ?>">
                      <img src="<?php echo $this->crud_model->file_view('banner',$row['banner_id'],'','','no','src') ?>" alt="">
                    </a>
                  </div>
                  <?php
                } 
            ?>
          </div>
        </div>
      </div>


</div>