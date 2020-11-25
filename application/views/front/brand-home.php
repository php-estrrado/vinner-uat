<?php
    $homeBrands =   $this->crud_model->getHomeBrands();
    if($homeBrands){ ?>
        <div class="container" style="margin-bottom: -40px;">
            <div class=" margin-bottom-20">
               <div class="tab-v2 margin-bottom-30" style="background:#fff;">
                    <ul class="navp nav-tabs full theme_4" >
                        <li class="pull-left"> <h2><?php echo translate('shop_by_brands');?></h2></li>
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
                    <div class="tab-pane fade in active" id="brand_id">
                        <div class="row">
                            <div class="illustration-v2 margin-bottom-20">
                                <ul class="list-inline owl-slider-v2"><?php
                                    foreach($homeBrands as $brand){
                                        $i++; ?>
                                        <li class="item <?php if($i==1){ ?>first-child<?php } ?>">
                                            <a href="<?php echo base_url()."index.php/home/brand/".$brand['brand_id']?>" >
                                                <img src="<?php echo base_url().'uploads/brand_image/brand_'.$brand['brand_id'].'.png' ?>" alt="">
                                            </a>
                                        </li><?php
                                    }  ?>
                                </ul><!--/end owl-carousel-->
                            </div>

                        </div>
                    </div>
                </div>
        </div><?php
    }?>

<!-- end brand-->









</div>