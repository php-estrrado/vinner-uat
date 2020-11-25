   

    <div class="ps-breadcrumb">
      <div class="ps-container">
        <ul class="breadcrumb">
          <li><a href="<?php echo base_url(); ?>"><?php echo translate('home');?></a></li>
          <?php
          //  if($cur_brand>0){
                ?>
              <li><?php // echo $this->db->get_where('brand',['brand_id'=>$cur_brand])->row()->name;?></li><?php
         //   }
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
              <h4 class="widget-title"><?php echo translate('industries');?></h4>
              <ul class="ps-list--categories">
                <?php 
                  foreach($all_brands as $row){
                    $br_active=($cur_brand==$row->brand_id)?'active':'';
                    ?>
                    <li class="menu-item-has-children <?php echo $br_active; ?>">
					  <?php 
					  	if($br_active)
						{
							echo translate($row->name);
						}
					  	else
						{
							?>
							<a href="<?php echo base_url('home/industry/'.$row->brand_id); ?>" >
                        		<?php echo translate($row->name); ?>
                      		</a>	
							<?php
						}
					  ?>
                  
                    </li>
                    <?php
                  }
                ?>
              </ul>
            </aside>
           
          </div>

          <div class="ps-layout__right">
            <div class="ps-shopping ps-tab-root">
              <!-- <a class="ps-shop__filter-mb" href="#" id="filter-sidebar"><i class="icon-menu"></i> Show Filter
              </a> -->
				
              <div id="result_scroll" class="ps-shopping__header">
				
                <p><strong id='cunt_str'><?php echo $totalRec; ?></strong> Products found</p>
                <?php  $totPages; ?>
<!--                <div class="ps-shopping__actions">
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
                </div>-->
              </div>

              <input type="hidden" id="cur_cat" value="<?php echo $cur_brand;?>">
              <?php
              //  echo form_open(base_url('home/listed/brand'), array
              //    ('method' => 'post','enctype' => 'multipart/form-data','id' => 'plistform'));
                  ?>
                  <input type="hidden" name="category" id="categoryaa" value="">
                  <input type="hidden" name="sub_category" id="sub_categoryaa">
                  <input type="hidden" name="brand" id="brandaa" value="<?php echo $cur_brand?>">
                  <input type="hidden" name="vendor" id="vendoraa">
                  <input type="hidden" name="featured" id="featuredaa">
                  <input type="hidden" name="range" id="rangeaa">
                  <input type="hidden" name="text" id="search_text">
                  <input type="hidden" name="view_type" id="view_type" value="grid">
                  <input type="hidden" name="sort" id="sorter" value="">
                  <?php
             //   echo form_close();
              ?>
              <input type="hidden" class="first_load_check" value="no">

              <div class="ps-tabs" id="result">
                  <?php   //      echo '<pre>'; print_r($products); echo '</pre>'; ?>
                <?php         include('brand_listed.php'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


  <script type="text/javascript">
//  
//    var range               = ';';
//    var cur_sub_category    = '';
    var cur_brand           = '<?php echo $cur_brand;?>';
//    var cur_category        = '';
//    var search_text         = '';
//    var url_text            = '';
    $(document).ready(function(){

		
        $('#cur_brand').val(cur_brand);
	var pgUrl      =   '<?php echo base_url('home/ajaxPaginationData/'.$cur_brand)?>';
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>'; 
	$.ajax({
                type: 'POST',
                url: pgUrl,
                dataType: 'html',
                data: {'[csrfName]': csrfHash,url: pgUrl,totPage: '<?php echo $totalpage?>',currPage:1,viewType:'grid'},
                success: function (data) { 
                    $('#result').html(data);
                }
        });
        
        $('body').on('click','.pagination li a',function(){
            var loader  =   '<div style="text-align:center;width:100%;pading:30px"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>';
            $('#result').html(loader);
            $.ajax({
                type: 'POST',
                url: pgUrl,
                dataType: 'html',
                data: {'[csrfName]': csrfHash,url: pgUrl,totPage: '<?php echo $totalpage?>',currPage:this.id},
                success: function (data) { 
                    $('#result').html(data);
                }
            });
        });
    });
    
    

   
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
 