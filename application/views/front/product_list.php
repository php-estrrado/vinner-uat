   

    <div class="ps-breadcrumb">
      <div class="ps-container">
        <ul class="breadcrumb">
          <li><a href="<?php echo base_url(); ?>"><?php echo translate('home');?></a></li>
          <?php
            if($cur_category>0)
            { 
              $category_name=$this->crud_model->get_type_name_by_id('category',$cur_category,'category_name');
              ?>
              <li>
                <a href="<?php echo base_url('home/category/'.$cur_category); ?>">
                  <?php echo translate($category_name); ?>
                </a>
              </li>
              <?php
            }
            else
            {
              $cur_category=0;
			  if($search_text)
              {
                ?>
                <li>
                  <?php echo translate('search_result'); ?>
                </li>
              <?php
              }
            }
            if($cur_sub_category>0 && $cur_category>0)
            { 
              $sub_category_name=$this->crud_model->get_type_name_by_id('sub_category',$cur_sub_category,'sub_category_name');
              ?>
              <li>
                <a href="<?php echo base_url('home/category/'.$cur_category.'/'.$cur_sub_category); ?>">
                  <?php echo translate($sub_category_name); ?>
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
              <h4 class="widget-title"><?php echo translate('categories');?></h4>
              <ul class="ps-list--categories">
                <?php 
                  foreach($all_category as $row)
                  {
					$cat_active='';$sub_dis='';
                    $cat_active=($cur_category==$row['category_id'])?'active':'';
                    $sub_dis=($cur_category==$row['category_id'])?'display: block':'';  
                    ?>
                    <li class="menu-item-has-children <?php echo $cat_active; ?>">
					  <?php 
					  	if($cat_active)
						{
							echo translate($row['category_name']);
						}
					  	else
						{
							?>
							<a href="<?php echo base_url('home/category/'.$row['category_id']); ?>" >
                        		<?php echo translate($row['category_name']); ?>
                      		</a>	
							<?php
						}
					  ?>
                      
						
                      <?php
                        $sub_category_qry = $this->db->order_by('sub_category_name')->get_where('sub_category',array('category'=>0));
                        if($sub_category_qry->num_rows()>0)
                          {
                            $sub_categories=$sub_category_qry->result_array();
                            ?>
                            <span class="sub-toggle <?php echo $cat_active; ?>">
                              <i class="fa fa-angle-down"></i>
                            </span>
                            <ul class="sub-menu" style="<?php echo $sub_dis; ?>">
                              <?php
                                foreach($sub_categories as $sub_cats)
                                {
									$sub_active='';
									if($cur_sub_category==$sub_cats['sub_category_id'])
                                      {
                                        $sub_active='sub-active';
                                      }
                                  ?>
                                  <li class="<?php echo $sub_active;?>">
                                    <?php
                                      if($cur_sub_category==$sub_cats['sub_category_id'])
                                      {
                                        echo translate($sub_cats['sub_category_name']);
                                      }
                                      else
                                      {
                                        ?>
                                        <a href="<?php echo base_url('home/category/'.$row['category_id'].'/'.$sub_cats['sub_category_id']); ?>">
                                          <?php echo translate($sub_cats['sub_category_name']);?>
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
             <?php /* 
             <figure class="ps-custom-scrollbar" data-height="250">
				 <h4 class="widget-title"><?php echo translate('BY BRANDS');?></h4>
                <?php
                  foreach ($all_brands as $b_key) 
                  {
                    ?>
                    <div class="ps-checkbox">
                      <input value="<?php echo $b_key['brand_id']; ?>" class="form-control search_brand" type="checkbox" id="brand-<?php echo $b_key['brand_id']; ?>" name="brand-select-<?php echo $b_key['brand_id'];?>" onChange="delayed_search()"/>
                      <label for="brand-<?php echo $b_key['brand_id']; ?>"><?php echo ucfirst($b_key['name']); ?></label>
                    </div>
                    <?php
                  }
                ?>
              </figure> */ ?>

              <figure>
                <h4 class="widget-title"><?php echo translate('By Price')?></h4>
                <div class="ps-slider ps-plist-slider" data-default-min="0" data-default-max="<?php echo $range_max; ?>" data-max="<?php echo $range_max; ?>" data-step="50" data-unit="$">
                </div>
                <p class="ps-slider__meta">
                  Price:<span class="ps-slider__value ps-slider__min"></span>-
                  <span class="ps-slider__value ps-slider__max"></span>
                  <input type="hidden" class="" id="pr-slider__min" value="0" />
                  <input type="hidden" class="" id="pr-slider__max" value="<?php echo $range_max; ?>" />
                </p>
              </figure> 

            </aside> 
          </div>

          <div class="ps-layout__right">
            <div class="ps-shopping ps-tab-root">
              <!-- <a class="ps-shop__filter-mb" href="#" id="filter-sidebar"><i class="icon-menu"></i> Show Filter
              </a> -->
				
              <div id="result_scroll" class="ps-shopping__header">
				<?php 
					if($search_text)
					{
					  $search_text2=(strlen($search_text)>20)?substr($search_text,0,19).'...':$search_text;
					  echo "<p>Showing results for <strong>".$search_text2."</strong></p>";
					}
                ?>
                <p><strong id='cunt_str'><?php echo count($all_products); ?></strong> Products found</p>
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

              <input type="hidden" id="univ_max" value="<?php echo $range_max; ?>">
              <input type="hidden" id="cur_cat" value="<?php echo $cur_category;?>">
              <input type="hidden" id="sub_cur_cat" value="<?php echo $cur_sub_category;?>">
              <?php
                echo form_open(base_url('home/listed/click'), array
                  ('method' => 'post','enctype' => 'multipart/form-data','id' => 'plistform'));
                  ?>
                  <input type="hidden" name="category" id="categoryaa" value="">
                  <input type="hidden" name="sub_category" id="sub_categoryaa">
                  <input type="hidden" name="brand" id="brandaa">
                  <input type="hidden" name="vendor" id="vendoraa">
                  <input type="hidden" name="featured" id="featuredaa">
                  <input type="hidden" name="range" id="rangeaa">
                  <input type="hidden" name="text" id="search_text">
                  <input type="hidden" name="view_type" id="view_type" value="grid">
                  <input type="hidden" name="sort" id="sorter" value="">
                  <?php
                echo form_close();
              ?>
              <input type="hidden" class="first_load_check" value="no">

              <div class="ps-tabs" id="result">
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


  <script type="text/javascript">
  
    var range               = ';';
    var cur_sub_category    = '<?php echo $cur_sub_category;?>';
    var cur_brand           = '0';
    var cur_category        = '<?php echo $cur_category;?>';
    var search_text         = '<?php echo $search_text;?>';
    var url_text            = '';

    $(document).ready(function()
    {
        //console.log(base_url);
        var title_page      = $('title').html();
        var curr_url        = window.location.href;
		//console.log(curr_url.url_text);
        //var newHREF         = curr_url.replace(url_text,search_text);
        //history.pushState('', title_page, newHREF);
        set_view('grid');
        var univ_max = $('#univ_max').val(); 

        
		
        $('#cur_cat').val(cur_category);
		$('#sub_cur_cat').val(cur_sub_category);
		$('.query-search-id').val(search_text);
        $('#category-search-id').val(cur_category);
		
        if(range == '0;0')
        {
            //set_price_slider(0,univ_max,0,univ_max);
        } 
        else 
        {
            var new_range = range.split(';');
        }
		list_categories()
        filter_price_Slider();
		
        if(cur_category == '' || cur_category == '0')
        {
            do_product_search('0');
        }
    });
    
    
    
    function check(now)
    {
        if($(now).find('input[type="checkbox"]').prop('checked') == true){
            $(now).find('.cr-icon').removeClass('remove');
            $(now).find('.cr-icon').addClass('add');
        }else{
            $(now).find('.cr-icon').removeClass('add');
            $(now).find('.cr-icon').addClass('remove');
        }
    }
    
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
        setTimeout(function(){ do_product_search('0'); }, 500);
    }
    
    
    function delayed_search()
    {
        setTimeout(function(){ do_product_search('0'); }, 500);
    };
    
    function do_product_search(page)
    {

        $('#categoryaa').val($('#cur_cat').val());
        $('#sub_categoryaa').val($('#sub_cur_cat').val());
        $('#search_text').val($('.query-search-id').val());
        $('#vendoraa').val($('.set_vendor').find('.vendor_search').val());
        $('#brandaa').val($('.search_brand:checked').map(function() {return this.value;}).get().join(','));
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
			  $("#cunt_str").html(data.value2);
            },
            error: function(e) 
            {
                console.log(e)
            }
        });
        $('html, body').animate({scrollTop:0}, 'slow');
        setTimeout(function(){ $(".first_load_check").val('done'); }, 300);
    }


    function filter_price_Slider() 
    {
        var el = $('.ps-plist-slider');
        var min = el.siblings().find('.ps-slider__min');
        var max = el.siblings().find('.ps-slider__max');
        var defaultMinValue = el.data('default-min');
        var defaultMaxValue = el.data('default-max');
        var maxValue = el.data('max');
        var step = el.data('step');
        var currency = '<?php echo currency()?>';
        if (el.length > 0) {
            el.slider({
                min: 0,
                max: maxValue,
                step: step,
                range: true,
                values: [defaultMinValue, defaultMaxValue],
                slide: function(event, ui) 
                {
                    var values = ui.values;
                    min.text(currency+ values[0]);
                    max.text(currency+ values[1]);
                    $("#pr-slider__min").val(values[0]);
                    $("#pr-slider__max").val(values[1]);
                    $("#rangeaa").val(values[0]+';'+values[1]);
                    
                    delayed_search();
                }
            });
            var values = el.slider("option", "values");
            
            min.text(currency+ values[0]);
            max.text(currency+ values[1]);
        } else {
            // return false;
        }
    }
	  
	function list_categories() 
    {
        var listCategories = $('.ps-list--categories');
        if (listCategories.length > 0) 
        {
            $('.ps-list--categories .menu-item-has-children > .sub-toggle').on('click', function(e) {
                console.log(true);
                e.preventDefault();
                var current = $(this).parent('.menu-item-has-children')
                $(this).toggleClass('active');
                current.siblings().find('.sub-toggle').removeClass('active');
                current.children('.sub-menu').slideToggle(350);
                current.siblings().find('.sub-menu').slideUp(350);
                if (current.hasClass('has-mega-menu')) {
                    current.children('.mega-menu').slideToggle(350);
                    current.siblings('.has-mega-menu').find('.mega-menu').slideUp(350);
                }

            });
        }
    }
  </script>

 <style>
	.ps-list--categories .active 
	 {
		 color: #e22626 !important;
	 }
	 li .sub-active
	 {
		 color: #fcb800 !important;
	 }
 </style>
 