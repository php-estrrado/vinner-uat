<?php  
$latestPrd  =   $this->crud_model->getRecentProduct();?>
<div class="container" style="margin-bottom: -40px;">
    <div class=" margin-bottom-20">
       <div class="tab-v2 margin-bottom-30" style="background:#fff;">
            <ul class="navp nav-tabs full theme_4" >
                <li class="pull-left"> <h2><?php echo translate('you_recently_viewed');?></h2></li>
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
                        <div class="illustration-v2 margin-bottom-20">
                            <ul class="list-inline owl-slider-v2">
                            <?php

                                if($latestPrd){

$itco1 = array_reverse($_SESSION["lastviewed"]);
foreach ($itco1 as $itco)
{                                                                
                                    foreach ($latestPrd as $row2){ 

if($itco==$row2['product_id'])
        {
                                        ?>
                                        <li class="item custom_item">
                                            <div class="product-img">
<a target="_blank" href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>">
                                                    <div class="shadow" style="background:url('<?php echo base_url() .'uploads/product_image/product_'. $row2['product_id'] .'_1_thumb.jpg'; ?>') no-repeat center center; background-size: 100% auto;"></div>
                                                </a><?php 
                                                if($row2['current_stock'] > 0  )
                                                {  ?>
                                                    <a class="add-to-cart add_to_cart" data-type='text' data-pid='<?php echo $row2['product_id']; ?>' >
                                                        <i class="fa fa-shopping-cart"></i> <?php 
                                                        if($this->crud_model->is_added_to_cart($row2['product_id'])){ 
                                                            echo translate('added_to_cart');
                                                        } else {
                                                            echo translate('add_to_cart');
                                                        } ?>
                                                    </a><?php 
                                                } else {?>
                                                    <a data-hover="dropdown" data-close-others="true" data-toggle="modal" class="dropdown-toggle active req_fr_prdct" href="#addClientPop" data-type='text' data-pid='<?php echo $row2['product_id']; ?>'>
                                                        Request quote<span class="arrow"></span>
                                                        <i class=""></i>
                                                    </a><?php
                                                }
                                                if($row2['product_type'] == 1){?>
                                                    <div class="shop-rgba-red  refur" style="border-top-left-radius: 4px !important;"><?php echo translate('refurbished');?></div><?php
                                                }
                                                if($row2['current_stock'] <= 0 && $row2['download'] != 'ok'){ ?>
                                                    <div class="shop-rgba-red rgba-banner" style="border-top-right-radius: 4px !important;"><?php echo translate('out_of_stock');?></div><?php
                                                } else if($row2['discount'] > 0){ ?>
                                                    <div class="shop-bg-green rgba-banner" style="border-top-right-radius:4px !important;"><?php 
                                                        if($row2['discount_type'] == 'percent'){  echo $row2['discount'].'%';} 
                                                        else if($row2['discount_type'] == 'amount'){ echo currency().$row2['discount'];  }
                                                        echo ' '.translate('off');  ?>
                                                    </div><?php 
                                                } ?>
                                            </div>
                                            <div class="product-description product-description-brd">
                                                <div class="overflow-h margin-bottom-5 ">
 <h4 class=" text-center product_name"><a target="_blank" href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>" ><?php echo $row2['title'] ?></a></h4> 
                                                    <div class="col-md-12 latest_prdct"> 
                                                        <div class="product-price"><?php  
                                                            if($row2['current_stock'] > 0 && $row2['discount'] > 0){ ?>
                                                                <div class="col-md-12  text-center"><?php
                                                                    $pr_price=$this->crud_model->get_product_price($row2['product_id']);
                                                                    $amount_final=exchangeCurrency($currency_value,$exchange,$pr_price);
                                                                    echo currency()." ".convertNumber($amount_final); ?>
                                                                </div>
                                                                <div class="col-md-12 line-through text-center"><?php echo currency().$row2['sale_price']; ?></div><?php 

                                                            } else { ?>

                                                                <div class="col-md-12  text-center"><?php 
                                                                    $pr_price=$row2['sale_price'];
                                                                    $amount_final=exchangeCurrency($currency_value,$exchange,$pr_price);
                                                                    echo currency()." ".convertNumber($amount_final); ?>
                                                                </div><?php 
                                                            }  ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12"> 
                                                    <ul class="list-inline product-ratings col-md-12 col-sm-12 col-xs-12 tooltips text-center" data-original-title="<?php echo $rating = $this->crud_model->rating($row2['product_id']); ?>" data-toggle="tooltip" data-placement="top" > <?php
                                                        $rating = $this->crud_model->rating($row2['product_id']);
                                                        $r = $rating; $i = 0;
                                                        while($i<5){
                                                            $i++; ?>
                                                            <li>
                                                                <i class="rating<?php if($i<=$rating){ echo '-selected'; } $r--; ?> fa fa-star<?php if($r < 1 && $r > 0){ echo '-half';} ?>"></i>
                                                            </li><?php
                                                        } ?>
                                                    </ul>
                                                </div>
                                                <div class="col-md-12 text-center margin-bottom-5 gender"> 
                                                    <?php echo translate('vendor').' : '.$this->crud_model->product_by($row2['product_id'],'with_link'); ?>
                                                </div>
                                                 <div class="col-md-12 text-center margin-bottom-5 gender"> <?php 
                                                    echo translate('brand').' : '.$row2['name']; ?>
                                                </div>
                                                <hr>
                                                <div class="col-md-6" >
                                                    <a onclick="cmp()"  class="btn-u btn-u-cust float-shadow <?php if($this->crud_model->is_compared($row2['product_id'])=='yes'){ ?>disabled<?php } else { ?>btn_compare<?php } ?>"  type="button" style="padding:2px 13px !important;" data-pid='<?php echo $row2['product_id']; ?>' ><?php 
                                                        if($this->crud_model->is_compared($row2['product_id'])=='yes'){ echo translate('compared'); } 
                                                        else { echo translate('compare'); } ?>
                                                    </a>
                                                </div><?php 
                                                $wish = $this->crud_model->is_wished($row2['product_id']);  ?>
                                                <div class="col-md-6" >
                                                    <a rel="outline-outward" class="btn-u btn-u-cust float-shadow pull-right <?php if($wish == 'yes'){ ?>btn_wished<?php } else {?>btn_wish<?php } ?>" style="padding:2px 13px !important;" data-pid='<?php echo $row2['product_id']; ?>'><?php 
                                                        if($wish == 'yes'){ echo translate('wished');} 
                                                        else { echo translate('wish'); } ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                    }
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