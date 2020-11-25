    
  <?php

    //print_r($brand_detail);

  ?>



    <div class="ps-breadcrumb">
      <div class="ps-container">
        <ul class="breadcrumb">
          <li>
              <a href="<?php echo base_url(); ?>">Home</a>
          </li>
          <li>
            <a href="<?php echo base_url('home/brands'); ?>">Brands</a>
          </li>
          <li>
            <?php echo ucfirst($brand_detail->name); ?>
          </li>
        </ul>
      </div>
    </div>
    <div class="ps-page--shop">
      <div class="ps-container">
        <div class="ps-shop-banner">
          <div class="brand-banner">
            <?php  
              if($this->crud_model->file_view('brand_banner',$b_id,'','','no','src','','','.png')) 
                {  
                  ?>
                  
                    <img src="<?php echo $this->crud_model->file_view('brand_banner',$b_id,'','','no','src','','','.png'); ?>" alt="<?php echo ucfirst($brand_detail->banner_alt); ?>" title="<?php echo ucfirst($brand_detail->name); ?>">
                  
                  <?php
                }
              else 
                {
                  ?>
                  
                    <img src="<?php echo base_url()?>uploads/brand_banner_image/brand_banner_default.png" title="<?php echo ucfirst($brand_detail->name); ?>">
                  
                  <?php
                }
            ?>
            
          </div>
        </div>
      

        <div class="ps-layout--shop">
          
          <!-- <div class="ps-layout__left">
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
              <?php
                //print_r($all_brands);
              ?>
             <figure class="ps-custom-scrollbar" data-height="250">
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
              </figure>

              <figure>
                <h4 class="widget-title">By Price</h4>
                <div class="ps-slider ps-plist-slider" data-default-min="0" data-default-max="<?php echo $range_max; ?>" data-max="<?php echo $range_max; ?>" data-step="50" data-unit="$">
                </div>
                <p class="ps-slider__meta">
                  Price:<span class="ps-slider__value ps-slider__min"></span>-
                  <span class="ps-slider__value ps-slider__max"></span>
                  <input type="" class="" id="pr-slider__min" value="0" />
                  <input type="" class="" id="pr-slider__max" value="<?php echo $range_max; ?>" />
                </p>
              </figure> 
            </aside> 
          </div> ps-layout__right-->

          
          <div class="">
              <div class="ps-shopping ps-tab-root">
                <div class="ps-shopping__header">
                    <p>
						<strong id="brnd_pr_cnt"></strong> <strong> Products found </strong>
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

 <script type="text/javascript">
  
    var range               = ';';
    var cur_sub_category    = '';
    var cur_brand           = '0';
    var cur_category        = '';
    var search_text         = '';
    var url_text            = '';

    var jbrand           = '<?php echo $b_id; ?>';
   
    $(document).ready(function()
    {
        //console.log(base_url);
        var title_page      = $('title').html();
        var curr_url        = window.location.href;
        var newHREF         = curr_url.replace(url_text,search_text);
        history.pushState('', title_page, newHREF);
        set_view('grid');
        //var univ_max = $('#univ_max').val(); 

        
        $('#brandaa').val(jbrand);
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
              $("#brnd_pr_cnt").html(data.value2);
            },
            error: function(e) 
            {
                console.log(e)
            }
        });
		
        $('html, body').animate({scrollTop:$('.ps-shop-banner').offset().top}, 'slow');
		
		//console.log($('#result_scroll').offset().top);
        setTimeout(function(){ $(".first_load_check").val('done'); }, 300);
    }
   
</script>

<style>
	.brand-banner img
	{
		width: 100%;
	}
</style>