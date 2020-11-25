
	<?php 
        $vendor_data=$this->db->get_where('vendor',array('vendor_id'=>$vendor))->row();
        $display_name=trim($vendor_data->display_name);
        $company=trim($vendor_data->company);
        $address=trim($vendor_data->address1);
        $address.=($vendor_data->address2)?', '.trim($vendor_data->address2) :'';
        $address.=($vendor_data->city)?', '.trim($vendor_data->city) :'';
        $address.=($vendor_data->country_code)?', '.trim($vendor_data->country_code) :'';
        $address.=($vendor_data->zip_code)?' - '.trim($vendor_data->zip_code) :'';
        $phone  = trim($vendor_data->phone);
        $mobile = trim($vendor_data->mobile);
    ?>
	<div class="ps-page--single">
      <div class="ps-breadcrumb">
        <div class="container">
          <ul class="breadcrumb">
            <li>
            	<a href="<?php echo base_url(); ?>"><?php echo translate('home')?></a>
            </li>
            <li>
            	<?php 
            		echo $display_name;
            	?>
            </li>
          </ul>
        </div>
      </div>

      <div class="ps-vendor-store">
        <div class="container">
          <div class="ps-section__container">
            <div class="ps-section__left">
              <div class="ps-block--vendor">
                <div class="ps-block__thumbnail">
                	<?php
                		if(!file_exists('uploads/vendor/logo_'.$vendor.'.png'))
                		{
            				?>
                			<img src="<?php echo base_url('uploads/vendor/logo_0.png'); ?>" alt="<?php echo $display_name;?>"/>
                			<?php
                		}
                		else
                		{
                			?>
                			<img src="<?php echo base_url('uploads/vendor/logo_'.$vendor.'.png'); ?>" alt="<?php echo $display_name;?>" />
                			<?php
                		}

                	?>
                </div>
                <div class="ps-block__container">
                  <div class="ps-block__header">
                    <h4><?php echo  $display_name; ?></h4>
                    <!-- <select class="ps-rating" data-read-only="true">
                      <option value="1">1</option>
                      <option value="1">2</option>
                      <option value="1">3</option>
                      <option value="1">4</option>
                      <option value="2">5</option>
                    </select>
                    <p><strong>85% Positive</strong>  (562 rating)</p> -->
                  </div>
                  <!-- <span class="ps-block__divider"></span> -->
                  <div class="ps-block__content">
                    <p>
                    	<strong><?php echo $company; ?></strong>
                    </p>
                    <span class="ps-block__divider"></span>
                    <p>
                    	<strong>Address</strong> 
                    	<?php
                    		echo $address;
                    	?>
                    </p>
                    <figure>
                      <figcaption>Follow us on social</figcaption>
                      <ul class="ps-list--social-color">
                        <li>
                        	<?php
                        		if($vendor_data->facebook)
                        		{
                        			?>
                        			<a class="facebook" target="_blank"  href="<?php echo $vendor_data->facebook; ?>">
                        				<i class="fa fa-facebook"></i>
                        			</a>
                        			<?php
                        		}
                        	?>
                        </li>
                        <li>
                        	<?php
                        		if($vendor_data->twitter)
                        		{
                        			?>

		                        	<a class="twitter" target="_blank"  href="<?php echo $vendor_data->twitter; ?>">
		                        		<i class="fa fa-twitter"></i>
		                        	</a>
		                        	<?php
                        		}
                        	?>
                        </li>
                        <li>
                        	<?php
                        		if($vendor_data->youtube)
                        		{
                        			?>

		                        	<a class="youtube" target="_blank"  href="<?php echo $vendor_data->youtube; ?>">
		                        		<i class="fa fa-youtube"></i>
		                        	</a>
		                        	<?php
                        		}
                        	?>
                        </li>
                      </ul>
                    </figure>
                  </div>
                  <div class="ps-block__footer">
                    <p>
                    	Call us directly
                    	<strong>
                    		<?php echo ($phone)?$phone:''; ?>
                    	</strong>
                    	<strong>
                    		<?php echo ($mobile)?$mobile:''; ?>
                    	</strong>
                    </p>
                    <p>Or if you have any question</p>
                    <a class="ps-btn ps-btn--fullwidth" href="<?php echo base_url('home/chat/new/'.$vendor); ?>">
                    	<?php echo 'Chat with Seller' ?>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="ps-section__right">
			  
			  <?php
                if(file_exists('uploads/vendor/banner_'.$vendor.'.jpg'))
                 {
					?>
					   <div class="vendor-banner  nopad mb-3">
							<img src="<?php echo base_url('uploads/vendor/banner_'.$vendor.'.jpg'); ?>" alt="<?php echo $display_name;?>">
					   </div>
					<?php
				}
			 ?>
              
				
              <?php
				$featured_data=0;
              	if($featured_data)
              	{
              		?>
              		<div class="ps-vendor-best-seller">
		                <div class="ps-section__header">
		                  <h3><?php echo translate('featured_product');?></h3>
		                  <div class="ps-section__nav">
		                  	<a class="ps-carousel__prev" href="#vendor-bestseller">
		                  		<i class="icon-chevron-left"></i>
		                  	</a>
		                  	<a class="ps-carousel__next" href="#vendor-bestseller">
		                  		<i class="icon-chevron-right"></i>
		                  	</a>
		                  </div>
		                </div>
		                <div class="ps-section__content">
		                  <div class="owl-slider" id="vendor-bestseller" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="false" data-owl-item="4" data-owl-item-xs="2" data-owl-item-sm="3" data-owl-item-md="3" data-owl-item-lg="4" data-owl-duration="1000" data-owl-mousedrag="on">
		                  	<?php
		                  		foreach ($featured_data as $row2) 
                       			{
									$wish = $this->crud_model->is_wished($row2['product_id']); 
									$compared = $this->crud_model->is_compared($row2['product_id']);
				    $fpimg=$this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one');
		                  			?>
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
						            </div>
				                    <?php
				                }
				            ?>
		                  </div>
		                </div>
		            </div>
              		<?php
              	}
              ?>
		            
			  <!-- <div class="ps-block--vendor-filter">
                <div class="ps-block__left">
                  <ul>
                    <li class="active"><a href="#">Products</a></li>
                     <li><a href="#">Reviews</a></li>
                    <li><a href="#">About</a></li>
                  </ul>
                </div>
              </div> -->
				
              <div class="ps-shopping ps-tab-root">
                <div class="ps-shopping__header">
                  	<p>
                  		<strong id="vend_pr_cnt"><?php  echo count($vendor_product);?></strong> Products found
                  	</p>
                  	<div class="ps-shopping__actions">
	                  <select class="ps-select sorter_search" data-placeholder="Sort Items" onChange="delayed_search()">
	                    <option value="">Sort by</option>
	                    <option value="condition_new">Sort by latest</option>
	                    <option value="price_low">Sort by price: low to high</option>
	                    <option value="price_high">Sort by price: high to low</option>
	                  </select>
	                  <div class="ps-shopping__view">
	                    <p>View</p>
	                    <ul class="ps-tab-list">
	                      <li class="grid active">
	                        <a href="#tab-1" onclick="set_view('grid')">
	                          <i class="icon-grid"></i>
	                        </a>
	                      </li>
	                      <li class="list">
	                        <a href="#tab-2" onclick="set_view('list')">
	                          <i class="icon-list4"></i>
	                        </a>
	                      </li>
	                    </ul>
	                  </div>
                	</div>
                </div>

                <?php
                	echo form_open(base_url('home/listed/click'), array
                  ('method' => 'post','enctype' => 'multipart/form-data','id' => 'plistform'));
                  		?>
	                  <input type="hidden" name="category" id="categoryaa" value="">
	                  <input type="hidden" name="sub_category" id="sub_categoryaa">
	                  <input type="hidden" name="brand" id="brandaa">
	                  <input type="hidden" name="vendor" id="vendoraa" value="<?php echo $vendor; ?>" >
	                  <input type="hidden" name="featured" id="featuredaa">
	                  <input type="hidden" name="range" id="rangeaa">
	                  <input type="hidden" name="text" id="search_text">
	                  <input type="hidden" name="view_type" id="view_type" value="grid">
	                  <input type="hidden" name="sort" id="sorter" value="">
                  	<?php
               	 	echo form_close();
              	?>
              	<input type="hidden" class="first_load_check" value="no">
                <div class="ps-tabs" id="result" style="min-height: 350px;">
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>


  <script type="text/javascript">
  
    var range               = ';';
    var cur_sub_category    = '';
    var cur_brand           = '0';
    var cur_category        = '';
    var search_text         = '';
    var url_text            = '';

    var jvedorid            = '<?php echo $vendor; ?>';
   
    $(document).ready(function()
    {
        //console.log(base_url);
        var title_page      = $('title').html();
        var curr_url        = window.location.href;
        var newHREF         = curr_url.replace(url_text,search_text);
        history.pushState('', title_page, newHREF);
        set_view('grid');
        //var univ_max = $('#univ_max').val(); 

        
        $('#vendoraa').val(jvedorid);
        $('#cur_cat').val(cur_category);

        if(range == '0;0')
        {
            //set_price_slider(0,univ_max,0,univ_max);
        } 
        else 
        {
            var new_range = range.split(';');
        }

        //filter_price_Slider();
        //list_categories();
        if(cur_category == '' || cur_category == '0')
        {
            do_product_search('0');
        }
    });
    
   
    function set_view(type)
    {
        if(type=='grid'){
            $('.ps-shopping__view').find('.list').removeClass('active');
            $('.ps-shopping__view').find('.grid').addClass('active');
        }else if(type=='list')
        {
            $('.ps-shopping__view').find('.grid').removeClass('active');
            $('.ps-shopping__view').find('.list').addClass('active');
        }
        $("#view_type").val(type);
        setTimeout(function(){ do_product_search('0'); }, 250);
    }
    
    
    function delayed_search()
    {
        setTimeout(function(){ do_product_search('0'); }, 250);
    };
    
    function do_product_search(page)
    {

        //$('#categoryaa').val($('#cur_cat').val());
        //$('#sub_categoryaa').val($('#sub_cur_cat').val());
        //$('#search_text').val($('#texted').val());
        //$('#vendoraa').val($('.set_vendor').find('.vendor_search').val());
        //$('#brandaa').val($('.search_brand:checked').map(function() {return this.value;}).get().join(','));
        $('#sorter').val($('.sorter_search').val());
        var form  = $('#plistform');
        var place = $('#result');
        //var form = $(this);
        var formdata = false;
        if (window.FormData){
            formdata = new FormData(form[0]);
        }
        
    
        $.ajax({
            url: form.attr('action')+'/'+page, // form action url
            type: 'POST', // form submit method get/post
            dataType: 'json', // request type html/json/xml
            data: formdata ? formdata : form.serialize(), // serialize form data 
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() 
            {
                var top = '200';
                place.html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) 
            {
              //console.log(data);
              place.html(data.value);
              $('#vend_pr_cnt').html(data.value2);
            },
            error: function(e) 
            {
                console.log(e)
            }
        });
        //$('html, body').animate({scrollTop:$('.ps-shopping__header').offset().top}, 'slow');
        setTimeout(function(){ $(".first_load_check").val('done'); }, 300);
    }

	
    /*$(".ps-pagination ul").on('click', function() 
	{
		console.log('page')
	});*/



  </script>