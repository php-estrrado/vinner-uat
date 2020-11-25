

	<?php  
    	$featured  =   $this->crud_model->getFeaturedProduct();
    ?>

	<div class="ps-product-list ps-clothings mt-5">
        <div class="ps-container">
          <div class="ps-section__header">
            <h3><?php echo translate('our_categories');?></h3>
          </div>
          <div class="ps-section__content" id="category">
            <div class="ps-carousel--nav owl-slider" data-owl-auto="false" data-owl-loop="false" data-owl-speed="10000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="7" data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="6" data-owl-duration="1000" data-owl-mousedrag="on">
            	<?php
            		if($categories)
            		{
                       foreach ($categories as $row) 
                       {
						  if($row['image'] != NULL || $row['image'] != ''){ $image = 'uploads/category_image/'.$row['image']; }else{ $image = 'uploads/others/photo_default.png'; } ?>
				            <div class="ps-product mt-4">
				              <div class="ps-product__thumbnail">
				              	  <a href="<?php echo base_url('home/category/'.$row['category_id'])?>">
                                <img src="<?php echo $image?>" alt="<?php echo $row['category_name']?>" />
                            </a>
				            
				              </div>
				              <h4><?php echo $row['category_name']?></h4>
				            </div>
				            <?php
				       }
				    }
				?>
              
            </div>
          </div>
        </div>
     </div>
     
     
     <div class="ps-product-list ps-clothings mt-5 mb-5">
        <div class="ps-container">
          <div class="ps-section__header">
            <h3><?php echo translate('our_industries');?></h3>
            </div>
            <div class="col-md-12">
                <div class="row"><?php
                    if($brands){ foreach($brands as $row){ 
                    if(file_exists(FCPATH.'uploads/brand_image/brand_'.$row->brand_id.'.png')){ $image = 'uploads/brand_image/brand_'.$row->brand_id.'.png'; }
                    else{ $image = 'uploads/others/photo_default.png'; } ?>
                    <div class="col-6 col-md-2">
                        <div class="indus_box">
                            <div>
                                <a href="<?php echo base_url('home/industry/'.$row->brand_id)?>">
                                    <img src="<?php echo base_url($image)?>" alt="<?php echo $row->name?>" />
                                </a>
                            </div>
                            <h4><a href="<?php echo base_url('home/industry/'.$row->brand_id)?>"><?php echo $row->name?></a></h4>
                        </div>
                    </div><?php
                } } ?>
                </div>
            </div>
        </div>
    </div>