<?php 
// Turn TRUE when working in CSS and JS files
    $css_development = TRUE;
    // Trun TRUE once worked with CSS and JS. 
    // Again turn FALSE to rebuiled minified faster loading CSS and JS
    $rebuild         =  FALSE;
    $vendor_system   =  $this->db->get_where('general_settings',array('type' => 'vendor_system'))->row()->value;
    $description     =  $this->db->get_where('general_settings',array('type' => 'meta_description'))->row()->value;
    $keywords        =  $this->db->get_where('general_settings',array('type' => 'meta_keywords'))->row()->value;
    $author          =  $this->db->get_where('general_settings',array('type' => 'meta_author'))->row()->value;
    $system_name     =  $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;
    $system_title    =  $this->db->get_where('general_settings',array('type' => 'system_title'))->row()->value;
    $revisit_after   =  $this->db->get_where('general_settings',array('type' => 'revisit_after'))->row()->value;
    $slider  =  $this->db->get_where('general_settings',array('type' => 'slider'))->row()->value;
    $slides  =  $this->db->get_where('general_settings',array('type' => 'slides'))->row()->value;
    $page_title      =  ucfirst(str_replace('_',' ','DailyDeals'));
    $this->crud_model->check_vendor_mambership();
 
if($css_development == TRUE){
        include 'includes_top.php';
    } else {
        include 'includes_top_n.php';
    }
    include 'preloader.php';
    include 'header.php';

    if($page_name=="home" && $slider == 'ok')
    {
        include 'slider.php';
    }
    if($page_name=="home" && $slides == 'ok')
    {
        include 'category_menu.php';
    }
 
$currency_value=currency();
$exchange = $this->db->get_where('business_settings', array('type' => 'exchange'))->row()->value; 
$b_id= $this->uri->segment('3');

?>
    
    


<div class="container deals "><!-- content -->
   <div  class="heading margin-bottom-10 margin-top-20">
    </div>
        <div class="row">
        <div class="col-md-12" style="margin-top: 125px;"">
        <div class="tab-v2 margin-bottom-30" style="background:#fff;">
    <div class="dailydeal_banner_box col-sm-12 " style="padding: 0"> 
<div class="col-sm-12" style="padding: 0"> 
<div id="myCarousel" class="carousel slide" data-ride="carousel">

    <div class="carousel-inner dailydeal_innr_slide" role="listbox">
    <?php
     $place = 'daily_deals';
     $query = $this->db->get_where('banner',array('page'=>'home', 'place'=>$place, 'status' => 'ok'));
     $banners = $query->result_array();
     if($query->num_rows() > 0){
        $r = 12/$query->num_rows();
        }
    foreach($banners as $row)
        { ?>
    <div class="item active">
    <img src="<?php echo $this->crud_model->file_view('banner',$row['banner_id'],'','','no','src') ?>"/>
    </div>
    <?php
        } ?>
    </div>
</div></div></div> 

        <div class="tab-content">
            <div class="tab-pane fade in active daily_deal_product" id="sub_CAT">
                <div class="row">
                <div class="illustration-v2 ">
            <?php
    $brand_data= $this->db->get_where('product',array('status'=>'ok','deal'=>'ok','current_stock >=' =>'1'))->result_array();
                    foreach ($brand_data as $row2){
    if($this->crud_model->check_sndpd($row2['product_id'])=='0'){
            ?>
    <div class="col-md-2" id="list" style="padding:15px 0;">
    <div class="item custom_item" >
        <div class="product-img">
            <a target="_blank" href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>">
                <?php  if ($this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one'))
                { ?>
                    <div class="shadow" style="background:url('<?php echo $this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one'); ?>') no-repeat center center; background-size: 100% auto;"></div>
            <?php } else { ?>
            <div class="shadow" style="background:url('<?php echo base_url().'uploads/product_image/default_product_thumb.jpg'; ?>') no-repeat center center; background-size: 100% auto;">
            </div>
            <?php } ?>
            </a><?php 
                if($row2['current_stock'] > 0  )
                {  ?>
                    <a class="add-to-cart add_to_cart" data-type='text' data-pid='<?php echo $row2['product_id']; ?>'  style="width: 48%;">
                    <?php 
                    if($this->crud_model->is_added_to_cart($row2['product_id'])){ 
                        echo translate('added_to_cart');
                    } else {
                        echo translate('add_to_cart');
                    } ?>
                    </a>
                    <a class=" COM-STYLE" data-type="text" style="width: 48%;">
            <?php
                if($row2['current_stock'] > 0 && $row2['discount'] > 0){ ?>
                 <div class="col-md-12  text-center">
                <?php
                    $pr_price=$this->crud_model->get_product_price($row2['product_id']);
                    $pr_price=$this->crud_model->uae_product_price($row2['product_id'],$pr_price);
                    $amount_final=exchangeCurrency($currency_value,$exchange,$pr_price);
                    echo currency()." ".convertNumber($amount_final); ?>
                    </div>
                <?php 
                } else { 
                ?>
                 <div class="col-md-12  text-center">
                <?php 
                    $pr_price=$row2['sale_price'];
                    $pr_price=$this->crud_model->uae_product_price($row2['product_id'],$pr_price);
                    $amount_final=exchangeCurrency($currency_value,$exchange,$pr_price);
                    echo currency()." ".convertNumber($amount_final); ?>
                    </div>
                <?php  }  ?>
                    </a>   
                <?php } else {?>
                    <a data-hover="dropdown" data-close-others="true" data-toggle="modal" class="dropdown-toggle active req_fr_prdct" href="#addClientPop" data-type='text' data-pid='<?php echo $row2['product_id']; ?>' data-pcode='<?php echo $row2['product_code']; ?>' >
                    Request quote<span class="arrow"></span>
                    <i class=""></i>
                    </a><?php
                }  if($row2['product_type'] == 1){?>
                    <div class="shop-rgba-red  refur" style="border-top-left-radius: 4px !important;"><?php echo translate('refurbished');?></div><?php
                    }
                    if($row2['current_stock'] <= 0 && $row2['download'] != 'ok'){ ?>
                    <div class="shop-rgba-red rgba-banner" style="border-top-right-radius: 4px !important;"><?php echo translate('out_of_stock');?></div><?php
                    } else if($row2['discount'] > 0){ ?>
                    <div class="shop-bg-green rgba-banner" style="border-top-right-radius:4px !important;">
                <?php 
                    if($row2['discount_type'] == 'percent'){  echo $row2['discount'].'%';} 
                    else if($row2['discount_type'] == 'amount'){ echo currency().$row2['discount'];  }
                        echo ' '.translate('off');  ?>
                    </div><?php 
                    } ?>
                </div>
    <div class="product-description product-description-brd">
    <div class="overflow-h margin-bottom-5 ">
<h4 class=" text-center product_name"><a target="_blank" href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>"><?php echo $row2['title'] ?></a></h4> 
    <?php 
        $content=trim(strip_tags($row2['short_description']));
        $words = explode(" ",$content);
        $dis=array_slice($words,0,25);
        $re= implode(" ",$dis)."...";
        if (trim($re)!="...") 
        {
    ?>
        <div class="tooltiptexts3" >
    <?php echo trim($re); ?>
        </div>
    <?php
         }
    ?>
    </div>

    <div class="col-md-12 text-center margin-bottom-5 gender"> 
        <?php echo translate('product_code').' : '.$row2['product_code']; ?>
    </div>
    <div class="col-md-12 text-center margin-bottom-5 gender"> 
        <?php echo translate('product_type').' : '.$row2['item_type']; ?>
    </div>
    <div class="col-md-12 text-center margin-bottom-5 gender"> 
        <?php echo translate('vendor').' : '.$this->crud_model->product_by($row2['product_id'],'with_link'); ?>
    </div>
    <div class="col-md-12 text-center margin-bottom-5 gender"> 
        <?php echo translate('brand').' : '.ucfirst($this->crud_model->get_type_name_by_id('brand',$row2['brand'],'name')); ?>
    </div>
    <div class="col-md-12 text-center margin-bottom-5 gender"> 
        <i class="fa fa-map-marker" aria-hidden="true"></i>  <?php echo ' : '.$row2['location']; ?>
    </div>
        <hr>
    <div class="col-md-6" >
        <a onclick="cmp()"  class="btn-u btn-u-cust float-shadow <?php if($this->crud_model->is_compared($row2['product_id'])=='yes'){ ?>disabled<?php } else { ?>btn_compare<?php } ?>"  type="button" style="padding:2px 13px !important;" data-pid='<?php echo $row2['product_id']; ?>' ><?php 
        if($this->crud_model->is_compared($row2['product_id'])=='yes'){ echo translate('compared'); } 
         else { echo translate('compare'); } ?>
        </a>
    </div>
<?php 
    $wish = $this->crud_model->is_wished($row2['product_id']);  
?>
    <div class="col-md-6" >
        <a rel="outline-outward" class="btn-u btn-u-cust float-shadow pull-right <?php if($wish == 'yes'){ ?>btn_wished<?php } else {?>btn_wish<?php } ?>" style="padding:2px 13px !important;" data-pid='<?php echo $row2['product_id']; ?>'><?php 
        if($wish == 'yes'){ echo translate('wished');} 
            else { echo translate('wish'); } ?>
        </a>
    </div>
</div>
    </div> 
    </div>
<?php
 } }
?>
        </div>
    </div>
    </div>
    </div>
</div>
<!-- End Tab v1 -->  
        </div>
    </div>
</div>




<?php
    include 'footer.php';
    include 'script_texts.php';
    
    if($css_development == TRUE){
        include 'includes_bottom.php';
    } else {
        include 'includes_bottom_n.php';
    }

?>
<style type="text/css">
#list .item.custom_item {
   min-height: 402px !important;
}
.container {
    width: 96%;
}
@media screen and (max-width: 996px) {
.container {
    width: 100%;
}
    }
</style>

<style type="text/css">

.product-description:hover .tooltiptexts3 {
    visibility: visible;
}
.product-description .tooltiptexts3 {
    visibility: hidden;
    width: 170px;
    height: 100px;
    background-color: #E2E2E2;
    text-align: center;
    /*padding: 5px 0;*/
    border-radius: 6px;
    position: absolute;
    z-index: 55;
}


.product-description:hover .tooltiptexts4 {
    visibility: visible;
}
.product-description .tooltiptexts4 {
    visibility: hidden;
    width: 175px;
    height: 100px;
    background-color: #E2E2E2;
    text-align: center;
    /*padding: 5px 0;*/
    border-radius: 6px;
    position: absolute;
    z-index: 55;
}
.COM-STYLE{
        border: none;
    display: inline-block;
    padding: 6px 16px;
    vertical-align: middle;
    overflow: hidden;
    text-decoration: none!important;
    color: #fff;
    background-color: #0588bc;
    text-align: center;
    cursor: pointer;
    white-space: nowrap;
    width: 48%;
    cursor: pointer;
    padding-left: 0px;
}

</style>