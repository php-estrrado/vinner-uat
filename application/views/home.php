
		<?php

            $i = 0;

			$this->benchmark->mark_time();

            $brands = json_decode($this->crud_model->get_type_name_by_id('ui_settings','13','value'));

            if($brands){

		?>

        <!--=== Sponsors ===-->

        <div class="container">

            <div  class="brands margin-bottom-10 margin-top-20">

               
                <ul class="navp nav-tabs full theme_4" >

                       
                       <li class="pull-left"> <h2><?php echo translate('our_available_brands'); ?></h2></li>
                       
                        <li class="pull-right">

                            <div class="owl-btn next tab_hov" style="padding:5px 13px !important;">

                                <i class="fa fa-angle-right"></i>

                            </div>

                        </li>

                        <li class="pull-right">

                            <div class="owl-btn prev tab_hov" style="padding:5px 13px !important;">

                                <i class="fa fa-angle-left"></i>

                            </div>

                        </li>

                    </ul>            

            </div>
<div class="tab-content">

                        
                        <div class="tab-pane fade in active" id="brand_id">

                            <div class="row">
    

            <ul class="list-inline owl-sponsor">

            	<?php

					foreach($brands as $row1)

					{

						$brand = $this->db->get_where('brand',array('brand_id'=>$row1))->result_array();

						foreach($brand as $row1)

						{

						$i++;

				?>

                        <li class="item <?php if($i==1){ ?>first-child<?php } ?>">

                            <img src="<?php echo $this->crud_model->file_view('brand',$row1['brand_id'],'','','no','src','','','.png') ?>" alt="">

                        </li>

                <?php

							}

						}

					}

				?>

            </ul><!--/end owl-carousel-->

        </div>
    </div></div></div>
<!--=== Latest products ===-->

<div class="container "><!-- content -->
  <div  class="heading margin-bottom-10 margin-top-20">

               <!-- <h2><?php //echo translate('latest_products'); ?></h2>-->

            </div>
   
   
   
   
    <div class="row">

    	<div class="col-md-12">

            <!-- Owl Carousel v2 -->

            

                <!-- Tab v1 -->               

                <div class="tab-v2 margin-bottom-30" style="background:#fff;">

                    <ul class="navp nav-tabs full theme_4" >

                       
                       <li class="pull-left"> <h2><?php echo translate('latest_products'); ?></h2></li>
                       
                        <li class="pull-right">

                            <div class="owl-btn next tab_hov" style="padding:5px 13px !important;">

                                <i class="fa fa-angle-right"></i>

                            </div>

                        </li>

                        <li class="pull-right">

                            <div class="owl-btn prev tab_hov" style="padding:5px 13px !important;">

                                <i class="fa fa-angle-left"></i>

                            </div>

                        </li>

                    </ul>            

                    <div class="tab-content">

                        
                        <div class="tab-pane fade in active" id="sub_CAT">

                            <div class="row">

                                <div class="illustration-v2 ">

                                    <ul class="list-inline owl-slider-v2">
                                         <?php

					$this->db->order_by('product_id','desc');

					$this->db->where('status','ok');

					$latest = $this->db->get('product')->result_array();

                    $i = 0;

					foreach ($latest as $row2){

                        if($this->crud_model->is_publishable($row2['product_id'])){

                            $i++;

                            if($i <= 9){



                ?>
                                        

                                        <li class="item custom_item">

                                            <div class="product-img">

                                                <a href="#">

                                                    <div class="shadow" 

                                                        style="background:url('<?php echo $this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one'); ?>') no-repeat center center; background-size: 100% auto;">

                                                    </div>

                                                </a>

                                               <!-- <a class=" product-review various fancybox.ajax" data-fancybox-type="ajax" href="#"><?php echo translate('quick_view');?></a>
-->
                                                <a class="add-to-cart add_to_cart" data-type='text' data-pid='' >

                                                    <i class="fa fa-shopping-cart"></i>

                                                </a>
                                                
                                      <!-- <a class="product-review various fancybox.ajax" data-fancybox-type="ajax" href="<?php //echo $this->crud_model->product_link($row2['product_id'],'quick'); ?>"><?php //echo translate('quick_view');?></a>-->

                    <a class="add-to-cart add_to_cart" data-type='text' data-pid='<?php echo $row2['product_id']; ?>' >

                        <i class="fa fa-shopping-cart"></i>

                        <?php if($this->crud_model->is_added_to_cart($row2['product_id'])){ ?>

                            <?php echo translate('added_to_cart');?>

                        <?php } else { ?>

                            <?php echo translate('add_to_cart');?>

                        <?php } ?>

                    </a>
          
                                                
                                                

    <?php

                        if($this->crud_model->get_type_name_by_id('product',$row2['product_id'],'current_stock') <= 0 && !$this->crud_model->is_digital($row2['product_id'])){

                    ?>

                    <div class="shop-rgba-red rgba-banner" style="border-top-right-radius: 4px !important;"><?php echo translate('out_of_stock');?></div>

                    <?php

                        } else {

                            if($this->crud_model->get_type_name_by_id('product',$row2['product_id'],'discount') > 0){ 

                    ?>

                        <div class="shop-bg-green rgba-banner" style="border-top-right-radius:4px !important;">

                            <?php 

                                if($row2['discount_type'] == 'percent'){

                                    echo $row2['discount'].'%';

                                } else if($row2['discount_type'] == 'amount'){

                                    echo currency().$row2['discount'];

                                }

                            ?>

                            <?php echo ' '.translate('off'); ?>

                        </div>

                    <?php 

                            } 

                        }

                    ?>                    


                                                

                                               
                                            </div>

                                            <div class="product-description product-description-brd">
                    <div class="overflow-h margin-bottom-5">
                       <!--title-price--> <h4 class=" text-center"><a href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>"><?php echo $row2['title'] ?></a></h4> 
                        <div class="col-md-12"> 
                            <div class="product-price">
								<?php if($this->crud_model->get_type_name_by_id('product',$row2['product_id'],'discount') > 0){ ?>
                                 <!--title-price-->       <div class="col-md-12  text-center"><?php echo currency().$this->crud_model->get_product_price($row2['product_id']); ?></div>
                                    <!--<div class="col-md-6 title-price line-through text-center"><?php //echo currency().$row2['sale_price']; ?></div>-->
                                <?php } else { ?>
                               <!--title-price-->     <div class="col-md-12  text-center"><?php echo currency().$row2['sale_price']; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12"> 
                        <ul class="list-inline product-ratings col-md-12 col-sm-12 col-xs-12 tooltips text-center"
                            data-original-title="<?php echo $rating = $this->crud_model->rating($row2['product_id']); ?>"	
                                data-toggle="tooltip" data-placement="top" >
                            <?php
                                $rating = $this->crud_model->rating($row2['product_id']);
                                $r = $rating;
                                $i = 0;
                                while($i<5){
                                    $i++;
                            ?>
                            <li>
                                <i class="rating<?php if($i<=$rating){ echo '-selected'; } $r--; ?> fa fa-star<?php if($r < 1 && $r > 0){ echo '-half';} ?>"></i>
                            </li>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                    <div class="col-md-12 text-center margin-bottom-5 gender"> 
                        <?php echo translate('vendor').' : '.$this->crud_model->product_by($row2['product_id'],'with_link'); ?>
                    </div>
                    <hr>
                    
                    <div class="col-md-6" style="margin-top:-10px;">
                        <a class="btn-u btn-u-cust float-shadow <?php if($this->crud_model->is_compared($row2['product_id'])=='yes'){ ?>disabled<?php } else { ?>btn_compare<?php } ?>" type="button" style="padding:2px 13px !important;" data-pid='<?php echo $row2['product_id']; ?>' >
                            <?php if($this->crud_model->is_compared($row2['product_id'])=='yes'){ ?>
                                <?php echo translate('compared');?>
                            <?php } else {?>
                                <?php echo translate('compare');?>
                            <?php } ?>
                         </a>
                    </div>
                    <?php 
                        $wish = $this->crud_model->is_wished($row2['product_id']); 
                    ?>
                    <div class="col-md-6" style="margin-top:-10px;">
                        <a rel="outline-outward" class="btn-u btn-u-cust float-shadow pull-right <?php if($wish == 'yes'){ ?>btn_wished<?php } else {?>btn_wish<?php } ?>" style="padding:2px 13px !important;" data-pid='<?php echo $row2['product_id']; ?>'>
                            <?php if($wish == 'yes'){ ?>
                                <?php echo translate('wished');?>
                            <?php } else {?>
                                <?php echo translate('wish');?>
                            <?php } ?>
                        </a>
                    </div>
                </div>

                                        </li>
<?php
                            }
                                                   
                                                }
                                            }
                                                ?>
                                      
                                    </ul>

                                 </div>

                            </div>

                        </div>

                       

                        

                    </div>

                </div>

                <!-- End Tab v1 -->  

             

        </div>

	</div>

</div>



              

<!--=== Category wise products ===-->




 





<!--===  banner ===-->
<div class="container margin-bottom-20 margin-top-20">
	<?php
		$place = 'after_slider';
        $query = $this->db->get_where('banner',array('page'=>'home', 'place'=>$place, 'status' => 'ok'));
        $banners = $query->result_array();
        if($query->num_rows() > 0){
            $r = 12/$query->num_rows();
        }
        foreach($banners as $row){
    ?>
        <a href="<?php echo $row['link']; ?>" >
            <div class="col-md-<?php echo $r; ?> md-margin-bottom-30">
                <div class="overflow-h">
                    <div class="illustration-v1 illustration-img1">
                        <div class="illustration-bg banner_<?php echo $query->num_rows(); ?>" 
                            style="background:url('<?php echo $this->crud_model->file_view('banner',$row['banner_id'],'','','no','src') ?>') no-repeat center center; background-size: 100% auto;" >
                        </div>    
                    </div>
                </div>    
            </div>
        </a>
    <?php
        }
    ?>
</div>
<!--===  banner ===-->


<!--===-featured products-->
<!--=== Category wise products ===-->
<div class="container" style="margin-bottom: -40px;">
    <div class=" margin-bottom-20">
       
        <div class="tab-v2 margin-bottom-30" style="background:#fff;">

         <ul class="navp nav-tabs full theme_4" >

                       
                       <li class="pull-left"> <h2><?php echo translate('featured_product');?></h2></li>
                       
                        <li class="pull-right">

                            <div class="owl-btn next tab_hov" style="padding:5px 13px !important;">

                                <i class="fa fa-angle-right"></i>

                            </div>

                        </li>

                        <li class="pull-right">

                            <div class="owl-btn prev tab_hov" style="padding:5px 13px !important;">

                                <i class="fa fa-angle-left"></i>

                            </div>

                        </li>

                    </ul>            
        <div class="tab-content">

                        
                        <div class="tab-pane fade in active" id="sub_CAT">

                            <div class="row">
    <div class="illustration-v2 margin-bottom-60">
        <ul class="list-inline owl-slider-v2">
        <?php
            foreach($featured_data as $row1)
            {
                if($this->crud_model->is_publishable($row1['product_id'])){
        ?>
        	<li class="item custom_item">
                <div class="product-img">
                    <a href="<?php echo $this->crud_model->product_link($row1['product_id']); ?>">
                        <div class="shadow" 
                            style="background: url('<?php echo $this->crud_model->file_view('product',$row1['product_id'],'','','thumb','src','multi','one'); ?>') no-repeat center center; 
                                background-size: 100% auto;">
                        </div>
                    </a>
                    <!--<a class="product-review various fancybox.ajax" data-fancybox-type="ajax" href="<?php //echo $this->crud_model->product_link($row1['product_id'],'quick'); ?>"><?php // echo translate('quick_view');?></a>-->
                    <a class="add-to-cart add_to_cart" data-type='text' data-pid='<?php echo $row1['product_id']; ?>' >
                        <i class="fa fa-shopping-cart"></i>
                        <?php if($this->crud_model->is_added_to_cart($row1['product_id'])){ ?>
                            <?php echo translate('added_to_cart');?>
                        <?php } else { ?>
                            <?php echo translate('add_to_cart');?>
                        <?php } ?>
                    </a>
					<?php
                        if($this->crud_model->get_type_name_by_id('product',$row1['product_id'],'current_stock') <= 0 && !$this->crud_model->is_digital($row1['product_id'])){
                    ?>
                    <div class="shop-rgba-red rgba-banner" style="border-top-right-radius: 4px !important;"><?php echo translate('out_of_stock');?></div>
                    <?php
                        } else {
                            if($this->crud_model->get_type_name_by_id('product',$row1['product_id'],'discount') > 0){ 
                    ?>
                        <div class="shop-bg-green rgba-banner" style="border-top-right-radius:4px !important;">
                            <?php 
                                if($row1['discount_type'] == 'percent'){
                                    echo $row1['discount'].'%';
                                } else if($row1['discount_type'] == 'amount'){
                                    echo currency().$row1['discount'];
                                }
                            ?>
                            <?php echo ' '.translate('off'); ?>
                        </div>
                    <?php 
                            } 
                        }
                    ?>                    
                </div>
                <div class="product-description product-description-brd">
                    <div class="overflow-h margin-bottom-5">
                        <h4 class="title-price text-center"><a href="<?php echo $this->crud_model->product_link($row1['product_id']); ?>"><?php echo $row1['title'] ?></a></h4> 
                        <div class="col-md-12"> 
                            <div class="product-price">
								<?php if($this->crud_model->get_type_name_by_id('product',$row1['product_id'],'discount') > 0){ ?>
                                  <!--title-price -->  <div class="col-md-6 text-center"><?php echo currency().$this->crud_model->get_product_price($row1['product_id']); ?></div>
                                 <!--title-price-->   <div class="col-md-6  line-through text-center"><?php echo currency().$row1['sale_price']; ?></div>
                                <?php } else { ?>
                                   <!--title-price --> <div class="col-md-12 text-center"><?php echo currency().$row1['sale_price']; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12"> 
                        <ul class="list-inline product-ratings col-md-12 col-sm-12 col-xs-12 tooltips text-center"
                            data-original-title="<?php echo $rating = $this->crud_model->rating($row1['product_id']); ?>"	
                                data-toggle="tooltip" data-placement="top" >
                            <?php
                                $rating = $this->crud_model->rating($row1['product_id']);
                                $r = $rating;
                                $i = 0;
                                while($i<5){
                                    $i++;
                            ?>
                            <li>
                                <i class="rating<?php if($i<=$rating){ echo '-selected'; } $r--; ?> fa fa-star<?php if($r < 1 && $r > 0){ echo '-half';} ?>"></i>
                            </li>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                    <div class="col-md-12 text-center margin-bottom-5 gender"> 
                        <?php echo translate('vendor').' : '.$this->crud_model->product_by($row1['product_id'],'with_link'); ?>
                    </div>
                    <hr>
                    
                    <div class="col-md-6" style="margin-top:-10px;">
                        <a class="btn-u btn-u-cust float-shadow <?php if($this->crud_model->is_compared($row1['product_id'])=='yes'){ ?>disabled<?php } else { ?>btn_compare<?php } ?>" type="button" style="padding:2px 13px !important;" data-pid='<?php echo $row1['product_id']; ?>' >
                            <?php if($this->crud_model->is_compared($row1['product_id'])=='yes'){ ?>
                                <?php echo translate('compared');?>
                            <?php } else {?>
                                <?php echo translate('compare');?>
                            <?php } ?>
                         </a>
                    </div>
                    <?php 
                        $wish = $this->crud_model->is_wished($row1['product_id']); 
                    ?>
                    <div class="col-md-6" style="margin-top:-10px;">
                        <a rel="outline-outward" class="btn-u btn-u-cust float-shadow pull-right <?php if($wish == 'yes'){ ?>btn_wished<?php } else {?>btn_wish<?php } ?>" style="padding:2px 13px !important;" data-pid='<?php echo $row1['product_id']; ?>'>
                            <?php if($wish == 'yes'){ ?>
                                <?php echo translate('wished');?>
                            <?php } else {?>
                                <?php echo translate('wish');?>
                            <?php } ?>
                        </a>
                    </div>
                </div>
            </li>              
        <?php
                }
            }
        ?>
        </ul>
        </div>
                            </div>
            </div>
            </div>
        </div>
        
    </div>
</div>


<!--===Ends Featured products-->

<!--===  banner ===-->
<div class="container margin-bottom-20 margin-top-20">
    <?php
        $place = 'after_featured';
        $query = $this->db->get_where('banner',array('page'=>'home', 'place'=>$place, 'status' => 'ok'));
        $banners = $query->result_array();
        if($query->num_rows() > 0){
            $r = 12/$query->num_rows();
        }
        foreach($banners as $row){
    ?>
        <a href="<?php echo $row['link']; ?>" >
            <div class="col-md-<?php echo $r; ?> md-margin-bottom-30">
                <div class="overflow-h">
                    <div class="illustration-v1 illustration-img1">
                        <div class="illustration-bg banner_<?php echo $query->num_rows(); ?>" 
                            style="background:url('<?php echo $this->crud_model->file_view('banner',$row['banner_id'],'','','no','src') ?>') no-repeat center center; background-size: 100% auto;" >
                        </div>    
                    </div>
                </div>    
            </div>
        </a>
    <?php
        }
    ?>
</div>
<!--===  banner ===-->


<!-- Blog Space -->
<!-- <div class="parallaxBg twitter-block margin-bottom-20" style="background:url(<?php echo base_url();?>template/front/assets/img/twitter-bg.jpg)">
    <div class="container">
        <div class="heading heading-v1 margin-bottom-20">
            <h2><?php echo translate('latest_blogs'); ?></h2>
        </div>

        <div id="carousel-example-generic-v5" class="carousel slide" data-ride="carousel"> -->
            <!-- Indicators -->
           <!--  <ol class="carousel-indicators">
            	<?php
					$i = 0;
					$this->db->limit(5);
					$this->db->order_by('blog_id','desc');
					$blogs = $this->db->get('blog')->result_array();
                	foreach($blogs as $row){
				?>
                <li class="<?php if($i == 0){ ?>active<?php } ?> rounded-x" data-target="#carousel-example-generic-v5" data-slide-to="<?php echo $i; ?>"></li>
            	<?php
						$i++;
					}
				?>
            </ol>

            <div class="carousel-inner" style="height:150px !important;">
            	<?php
					$i = 0;
                	foreach($blogs as $row){
				?>
                <div class="item <?php if($i == 0){ ?>active<?php } ?>">
                    <h2>
                    	<a href="<?php echo $this->crud_model->blog_link($row['blog_id']); ?>" style="color:white !important;">
                        	<?php echo $row['title']; ?>
                        </a>
                    <h2>
                    <p>
                    	<a href="<?php echo $this->crud_model->blog_link($row['blog_id']); ?>" style="color:white !important;">
                        	<?php echo $row['summery']; ?>
                        </a>
                    </p>
                </div>
                <?php
						$i++;
					}
				?>
            </div>
            
            <div class="carousel-arrow">
                <a class="left carousel-control" href="#carousel-example-generic-v5" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic-v5" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>                        
    </div>    
</div> -->
 <div class="container">
<div class="row tab-v2 margin-bottom-30">
        <ul class="navp nav-tabs full theme_4" >

                       
                       <li class="pull-left"> <h2><?php echo translate('the blog');?></h2></li>
                       
                        <li class="pull-right">

                            <div class="owl-btn next tab_hov" style="padding:5px 13px !important;">

                                <i class="fa fa-angle-right"></i>

                            </div>

                        </li>

                        <li class="pull-right">

                            <div class="owl-btn prev tab_hov" style="padding:5px 13px !important;">

                                <i class="fa fa-angle-left"></i>

                            </div>

                        </li>

                    </ul>   

          <div class="col-sm-4">
          <img src="/marine_test/uploads/blog_image/blog_d.jpg">
              <p>2016-08-26 04:53:02</p>
              <h4 style="font-weight: 400;">VERTICAL AMPLIFIER PCB (V:2) </h4>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget maximus mi, ac molestie tortor. Vestibulum ac eleifend felis, ut tincidunt lacus. Curabitur consequat ex non tincidunt consequat. Vivamus mi turpis, rutrum vitae velit tristique, laoreet suscipit leo. Sed sagittis ante a augue ultricies, quis ullamcorper tellus laoreet</p><span><a href="#">read more<i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
          </div>
          <div class="col-sm-4">
               <img src="/marine_test/uploads/blog_image/blog_d.jpg">
              <p>2016-08-26 04:53:02</p>
              <h4 style="font-weight: 400;">VERTICAL AMPLIFIER PCB (V:2) </h4>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget maximus mi, ac molestie tortor. Vestibulum ac eleifend felis, ut tincidunt lacus. Curabitur consequat ex non tincidunt consequat. Vivamus mi turpis, rutrum vitae velit tristique, laoreet suscipit leo. Sed sagittis ante a augue ultricies, quis ullamcorper tellus laoreet</p><span><a href="#">read more<i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
          </div>
          <div class="col-sm-4">
               <img src="/marine_test/uploads/blog_image/blog_d.jpg">
              <p>2016-08-26 04:53:02</p>
              <h4 style="font-weight: 400;">VERTICAL AMPLIFIER PCB (V:2) </h4>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget maximus mi, ac molestie tortor. Vestibulum ac eleifend felis, ut tincidunt lacus. Curabitur consequat ex non tincidunt consequat. Vivamus mi turpis, rutrum vitae velit tristique, laoreet suscipit leo. Sed sagittis ante a augue ultricies, quis ullamcorper tellus laoreet</p><span><a href="#">read more<i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
          </div>
</div>
</div>
<!-- Ends Blog Space -->



             

<script>

	$(document).ready(function() {

		$('.drops').dropdown();

		$('.dropss').dropdown();

	});



	$('body').on('click','.category_drop .cd-dropdown li', function(){

		var category = $(this).data('value');

		var list1 = $('.sub_category_drop');

		$.ajax({

			url: '<?php echo base_url(); ?>index.php/home/others/get_sub_by_cat/'+category,

			beforeSend: function() {

				list1.html('');

			},

			success: function(data) {

				var res = ""

					+" <select name='sub_category' onchange='get_pricerange(this.value)' class='dropss cd-select'  id='sub_category'>"

					+" 	<option value='0'><?php echo translate('choose_sub_category');?></option>"

					+ data

					+" </select>"

				list1.html(res);

				$('body .dropss').dropdown();

			},

			error: function(e) {

				console.log(e)

			}

		});

		$.ajax({

			url: '<?php echo base_url(); ?>index.php/home/others/get_home_range_by_cat/'+category,

			beforeSend: function() {

			},

			success: function(data) {

				var myarr = data.split("-");

				var res = 	''

							+'<div class="nstSlider" '

							+'	data-range_min="'+myarr[0]+'" data-range_max="'+myarr[1]+'" '  

							+'	data-cur_min="'+myarr[0]+'"  data-cur_max="'+myarr[1]+'">'

							+'<div class="highlightPanel"></div> '

							+'<div class="bar"></div>   '               

							+'<div class="leftGrip"></div> '

							+'<div class="rightGrip"></div>' 

							+'</div>';

				$('.nstSlider').remove();

				$('#ranog').html(res);

				take_range(myarr[0],myarr[1]);

			},

			error: function(e) {

				console.log(e)

			}

		});

	});

	$('body').on('click','.sub_category_drop .cd-dropdown li', function(){

		var sub_category = $(this).data('value');

		var list2 = $('#range');

		$.ajax({

			url: '<?php echo base_url(); ?>index.php/home/others/get_home_range_by_sub/'+sub_category,

			beforeSend: function() {

			},

			success: function(data) {

				var myarr = data.split("-");

				var res = 	''

							+'<div class="nstSlider" '

							+'	data-range_min="'+myarr[0]+'" data-range_max="'+myarr[1]+'" '  

							+'	data-cur_min="'+myarr[0]+'"  data-cur_max="'+myarr[1]+'">'

							+'<div class="highlightPanel"></div> '

							+'<div class="bar"></div>   '               

							+'<div class="leftGrip"></div> '

							+'<div class="rightGrip"></div>' 

							+'</div>';

				$('.nstSlider').remove();

				$('#ranog').html(res);

				take_range(myarr[0],myarr[1]);

			},

			error: function(e) {

				console.log(e)

			}

		});

	});

	function filter(){}

</script>

<style type="text/css">
    .owl-item {
    width: 228px !important;
}
</style>