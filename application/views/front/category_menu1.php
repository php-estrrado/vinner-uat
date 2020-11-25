<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/front/assets/plugins/menu/amazonmenu.css">

<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

<script src="<?php echo base_url(); ?>template/front/assets/plugins/menu/amazonmenu.js"></script>


<?php 
 
$currency_value=currency();
$exchange = $this->db->get_where('business_settings', array('type' => 'exchange'))->row()->value; 

?>
<div class="container">

<div class="row">

            <div class="col-lg-10 col-sm-10 nopadding-right" style="margin-top:10px;">

                <?php

                    echo form_open(base_url() . 'index.php/home/main_search', array(

                        'method' => 'post',

                        'role' => 'search'

                    ));

                ?>   

                

                   <!--<input type="text" id="txtinput" size="20" />-->

 

                    <div class="input-group input-group-lg">

                        <input type="text" name="query" id="txtinput" class="form-control tryu" placeholder="<?php echo translate('What are you looking for ?') ?>">

                        <span class="input-group-btn">

                            <button class="btn btn-input_type custom" type="submit"><span class="glyphicon glyphicon-search"></span></button>

                        </span>

                        <label class="category_drop nav_catgy-drop">

                        <select name='category' id='category' ><!--class="drops cd-select"-->

                            <option value="0"   class=""><?php echo translate('all_products');?></option>

                            <?php

                                $this->db->order_by('sort_order','asc');
                            	$categories = $this->db->get('category')->result_array();

								foreach($categories as $row){

							?>

                            	<option value="<?php echo $row['category_id']; ?>"  class=""><?php echo ucfirst($row['category_name']); ?></option>

                            <?php

								}

							?>
                            <option value="brand"   class=""><?php echo 'BRANDS';?></option>

                        </select>

                        <i></i>

                        </label>

                        <!--<span class="input-group-btn">

                            <button type="button" class="btn btn-input_type dropdown-toggle custom ppy" data-toggle="dropdown"><?php/* echo translate('product');*/?> <span class="caret"></span></button>

                            <div class="dropdown-menu pull-right" style="min-width:102px;">

                                <div class="btn custom srt" data-val="product" style="display:block;" ><a href="#"><?php /*echo translate('product'); */?></a></div>

                                <div class="btn custom srt" data-val="vendor" style="display:block;" ><a href="#"><?php/* echo translate('vendor'); */?></a></div>

                                

                            </div>

                            <input type="text" id="tryp" name="type" value="vendor">

                            <script>

                                $('.srt').click(function(){

                                    var ty = $(this).data('val');

                                    var ny = $(this).html();

                                    $('#tryp').val(ty);

                                    $('.ppy').html(ny+' <span class="caret"></span>');

                                    if(ty == 'vendor'){

                                        $('.tryu').attr('placeholder','<?php/* echo translate('search_vendor_by_title,_location,_address_etc.') */?>');

                                    } else if(ty == 'product'){

                                        $('.tryu').attr('placeholder','<?php/* echo translate('search_product_by_title,_description_etc.') */?>');

                                    }

                                });

                            </script>

                        </span>-->

                    </div>

                </form>

            </div>

            <div class="col-sm-2 nopadding-left"><a href="<?php echo base_url(); ?>index.php/home/advance_search"> <div class="adv_srch ">ADVANCE SEARCH</div></a></div>

        </div>







       <!--  <div class="prdct_cmpr_msg fade-in" id="comparetab1">

                    <a href="#" class="close1 pull-right" >&times;</a>

               <strong>You have added products to compare !</strong>   <a href="<?php echo base_url(); ?>index.php/home/compare">  

                 Click here to view.</a>

        </div>
 -->






    <div class="col-md-10">

        



        <div class="row">

            <div class="col-md-3" style="padding-left: 0px;padding-right: 0px;">

                <nav id="mysidebarmenu" class="amazonmenu">

                    <ul>

                    <li class="sidemenu_head"><i class="fa fa-tasks" aria-hidden="true"></i>CATEGORIES</li>

                    <?php
                        $this->db->order_by('sort_order','asc');
                        $categories = $this->db->get('category')->result_array();

                        foreach($categories as $row){

                    ?>



                    <li><a href="#"><?php echo $row['category_name']; ?></a>

                        <div>

                        <div class="col-md-12">

                            <?php

                                $subs = $this->db->get_where('sub_category',array('category'=>$row['category_id']))->result_array();

                                foreach($subs as $row1){

                                    $this->db->limit(4);

                                    $this->db->order_by('product_id','desc');

                                    $products = $this->db->get_where('product',array('sub_category'=>$row1['sub_category_id']))->result_array();

                            ?>

                                <div class="col-md-12"><h3 class="text-center" style="background:#EAEAEA;"><?php echo $row1['sub_category_name']; ?></h3></div>

                                <?php

                                    foreach($products as $row2){

                                        if($this->crud_model->is_publishable($row2['product_id'])){

                                ?>

                                    <div class="col-md-3">

                                        <div class="menu_box">

                                       <a style="display:block"  href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>">

                                            <div class="img_menu_box" style="background:url('<?php echo $this->crud_model->file_view('product',$row2['product_id'],'','','no','src','multi','one') ?>') no-repeat center center; background-size: 100% auto;">

                                            </div>

                                     </a>

                                        <a class="prdct_id" href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>">

                                            <?php echo $row2['title']; ?>

                                        </a>

                                        <a href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>">

                                            <?php

                                     echo currency().$this->crud_model->get_product_price($row2['product_id']);
                                           /* $pr_price=$this->crud_model->get_product_price($row2['product_id']);
$amount_final=exchangeCurrency($currency_value,$exchange,$pr_price); 
echo currency()." ".convertNumber($amount_final);*/

                                             ?>

                                        </a>

                                        </div>

                                    </div>

                                <?php

                                        }

                                    }

                                ?>

                            <?php

                                }

                            ?>

                        </div>

                        </div>

                    </li>

                    <?php

                        }

                    ?>

                    </ul>

                </nav>

            </div>

            <div class="col-md-9" style="margin-top:10px;">

                <div class="timeline-heading">

                    <div class="carousel slide carousel-v1" id="myCarousel">

                        <div class="carousel-inner">

                            <?php

                                $i = 0;

                                $slides = $this->db->get('slides')->result_array();

                                foreach ($slides as $row) {

                                    $i++;

                            ?>

                            <div class="item <?php if($i == 1){ ?>active<?php } ?>">
<a href="<?php echo $row['sl_link']; ?>" >
                                <img class="img-responsive" src="<?php echo $this->crud_model->file_view('slides',$row['slides_id'],'','','no','src','','','.jpg') ?>" alt=""/>      
                                </a>                          

                            </div>

                            <?php

                                }

                            ?>

                        </div>

                        

                        <div class="carousel-arrow">

                            <a data-slide="prev" href="#myCarousel" class="left carousel-control">

                                <i class="fa fa-angle-left"></i>

                            </a>

                            <a data-slide="next" href="#myCarousel" class="right carousel-control">

                                <i class="fa fa-angle-right"></i>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    

    <div class="col-md-2 " data-mcs-theme="minimal-dark" style="background: #F5F5F5; margin-top:10px;border-radius:3px;padding-top: 3px;">

    <a data-toggle="modal" data-target="#v_registration" style="cursor:pointer;"><img src="<?php echo base_url(); ?>uploads/slider_right/OPEN_STORE.png" 

                            width="100%"  > </a>

    </div>

    <div class="col-md-2 content mCustomScrollbar light" data-mcs-theme="minimal-dark" id="content-4"  style="background: #F5F5F5; margin-top:10px;border-radius:3px;padding-top: 3px;">

        

        <h3 class="heading heading-v1"><?php echo translate('todays_deal'); ?></h3>

        <div style="height:376px; overflow:auto; margin-top:10px;">

        <?php

            $i = 0;

                $this->db->limit(4);

                $most_popular = $this->db->get_where('product',array('deal'=>'ok'))->result_array();

                foreach ($most_popular as $row2){

                         

        ?>

        <div class="thumbnail ">

            <a class="product-review zoomer various fancybox.ajax" data-fancybox-type="ajax" href="<?php echo $this->crud_model->product_link($row2['product_id'],'quick'); ?>">

                <span class="overlay-zoom">  

                    <img class="img-responsive thumb-product-img" src="<?php echo $this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one'); ?>" alt=""/>

                    <span class="zoom-icon"></span>                   

                </span>                                              

            </a>                    

            <div class="caption">

                <h3 class="text-center"><a class="hover-effect" href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>"><?php echo $row2['title']; ?></a></h3>                        

            </div>

        </div>

        <?php  

            }

        ?>

        </div>

    </div>

</div>

                 

                 

                 



<script>



jQuery(function(){

    amazonmenu.init({

        menuid: 'mysidebarmenu'

    })

});



// compare message alert



/*$(document).ready(function(){

    $("#comparetab").hide();

    $(".close1").click(function(){

        $("#comparetab").hide();

    });  

});

         function cmp() {

        $("#comparetab").show();

        $("html, body").animate({

            scrollTop: 0

        }, 1000);

        

    }*/

// end compare message alert







</script>

