<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/front/assets/plugins/menu/amazonmenu.css">
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>template/front/assets/plugins/menu/amazonmenu.js"></script>
<?php 
    $currency_value=currency();
    $exchange = $this->db->get_where('business_settings', array('type' => 'exchange'))->row()->value; 
?>
<div class="container-fluid">
    
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-12" style="margin-top:10px; padding-left: 0;">
                <div class="timeline-heading">
                    <div class="carousel slide carousel-v1" id="myCarousel">
                        <div class="carousel-inner">
                        <?php
                          $i = 0;
                          $slides = $this->db->get('slides')->result_array();
                          foreach ($slides as $row) { 
                          $i++;  ?>
                              <div class="item <?php if($i == 1){ ?>active<?php } ?>">
                                <?php if($row['type']=='Video') { ?>
                              <iframe id="video" src="<?php echo $row['vl_link']; ?>" frameborder="0" allowfullscreen>
                              </iframe> <?php } else { ?>
                                <a href="<?php echo $row['sl_link']; ?>" >
                                  <img class="img-responsive" src="<?php echo $this->crud_model->file_view('slides',$row['slides_id'],'','','no','src','','','.jpg') ?>" alt="<?php echo $row['alt_text']; ?>" title="<?php echo $row['name']; ?>"/>      
                                </a>      <?php } ?>                       
                              </div>
                        <?php } ?>
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
    <div class="col-md-3 display " data-mcs-theme="minimal-dark" style="background: #F5F5F5; margin-top:10px;padding: 0px;padding-left:19px;height: 155px;">
       <!--  <a data-toggle="modal" data-target="#v_registration" style="cursor:pointer;"><img src="<?php echo base_url(); ?>template/front/assets/img/buy-sel.png" width="100%"  > </a> -->
        <a target="_blank" href="<?php echo base_url(); ?>index.php/vendor/sell" style="cursor:pointer;"><img src="<?php echo base_url(); ?>template/front/assets/img/buy-sel.png" width="100%"  > </a>
    </div>
    <div class="col-md-3 display" data-mcs-theme="minimal-dark" id="content-4"  style="padding: 0;padding-left:10px;">
<!--        <h3 class="heading heading-v1"><?php // echo translate('todays_deal'); ?></h3>-->
        <div id="carousel-demo" class="carousel vertical slide todaysdeal" data-ride="carousel" data-interval="15000">
            <div style="height:376px; margin-top: 55px; padding-left: 10px;
">
  <!-- Sliding images statring here --> 
                <div class="carousel-inner"><?php
                    $i = 0; $s=0;
                    $this->db->limit(4);
                    $most_popular = $this->db->get_where('product',array('deal'=>'ok'))->result_array();
                    foreach ($most_popular as $row2){ ?>
                        <div class="item <?php if($s==0){ echo "active";} ?>"> 
                            <a target="_blank" class="product-review zoomer various fancybox.ajax" data-fancybox-type="ajax" href="<?php echo $this->crud_model->product_link($row2['product_id'],'quick'); ?>">
                                <span class="overlay-zoom">  
                                    <img src="<?php echo base_url(); ?>template/front/assets/img/big-sale.png" title="Today's Deal"> 
                                    <span class="zoom-icon"></span>                   
                                </span>                                              
                            </a> 
<!--                            <div class="caption">
                                  <h3 class="text-center"><a target="_blank" class="hover-effect" href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>"><?php // echo $row2['title']; ?></a></h3>                        
                            </div>-->
                        </div> <?php  $s++; 
                    }  ?>
                </div> 
                <div></div> 
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(function(){  amazonmenu.init({ menuid: 'mysidebarmenu'  }) });
    $("#txtinput").keyup(function(event){ if(event.keyCode == 13){ $("#id_search").click();  } });
</script>

<style>
h3{
    font-size: 20px;
    font-family:Verdana;
    color: #515151;
}

.clear{
    clear: both;
}
.overlay-zoom img{
        width: 100%; 
    }
#content-4 div#mCSB_1_scrollbar_vertical {
    display: none !important;
}
.caption h3 a {
    color: #585f69;
    font-size: 15px;
}
.todaysdeal .item{
    padding: 4px;
    margin-bottom: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    }
.carousel-caption {
      font-size: 2em;
      right: 10%;
      left: 60%;
      top: 30%;
      bottom: 30%;
      text-align: left;
      text-shadow: none;
     }
.carousel-indicators{
      font-size: 2em;
      bottom: -1%;
      text-align: left;
      text-shadow: none;
        }

.carousel.vertical .carousel-inner {
  height: 100%;
}
.carousel.vertical .item {
  -webkit-transition: 0.6s ease-in-out top;
  -moz-transition:    0.6s ease-in-out top;
  -ms-transition:     0.6s ease-in-out top;
  -o-transition:      0.6s ease-in-out top;
  left:               0;
}
.carousel.vertical .active,
.carousel.vertical .next.left,
.carousel.vertical .prev.right    { top:     0; }
.carousel.vertical .next,
.carousel.vertical .active.right  { top:  100%; }
.carousel.vertical .prev,
.carousel.vertical .active.left   { top: -100%; } 
 
#myCarousel .carousel-inner>.item{
  height: 420px;
}   
#myCarousel .carousel-inner>.item iframe{
  height: 100%;
  width: 100%;
  object-fit: fill;
}      
</style>
<script>
    $( document ).ready(function() {
    
        $('#carousel-demo').carousel({
  interval: 2000,
  cycle: true
}); 
});

</script>