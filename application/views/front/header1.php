<style>
    .right-topbar .last{ padding-right: 15px;}
.right-topbar .first{ padding-left: 15px;}
#loginsets li{ padding-right: 20px;}
#loginsets li a{ cursor: pointer;}
.nav-menu-outer{ background: #007aff none repeat scroll 0 0; padding: 5px 0; position: relative;}
.nav-menu{ text-align: center; padding:5px; margin-bottom: 0;}
.nav-menu li a{ color: #fff; font-size: 12px; text-transform: uppercase; font-weight: bold;}
.search-input{ width: 93% !important;} .input-group-btn{ float: left;}
.full-width{ width: 100%; }
.cat-drop{ width: 40% !important; float: left;}
.adv-search{width: 60%; float: left; margin-top:-10px;}
.cat-drop select{ width: 100%; }
#id_search{ padding: 9px 12px;}
#ui-id-1{ z-index: 999 !important; }

@media only screen and (min-width: 1000px)  {
    .search-input{ height: 40px;} #id_search{ padding: 12px 12px;}
}
@media only screen and (min-width: 1200px)  {
    .sel-cat{ margin: auto -15px;}
}
</style>

<?php
$ctrl_function=$this->router->fetch_method();
if($ctrl_function!="cart_checkout")
{
    $userid=$this->session->userdata('user_id');
        if($userid==0)
        {
            $this->session->unset_userdata('user_login');
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('user_name');
        }
 
   // $this->session->sess_destroy();
}
?>
<body  onLoad="popup(1,1)"   class="header-fixed">

<!-- BEGIN JIVOSITE CODE {literal} -->
<!-- <script type='text/javascript'>
(function(){ var widget_id = 'dZRvqAwJN6';var d=document;var w=window;function l(){
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script> -->
<!-- {/literal} END JIVOSITE CODE -->

<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?4EaF0YmF6ho23rRlxhtyyJdXCxt2V9C3";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zopim Live Chat Script-->



<div class="wrapper">
    <div class="header-<?php echo $theme_color; ?> header-sticky header-fixed">
        <div class="topbar-v3">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <!-- Topbar Navigation-->
                        <ul class="left-topbar">
                        </ul><!--/end left-topbar-->
                    </div>
                    <div class="col-sm-8 pull-right" >
                        <ul class="list-inline right-topbar pull-right">
                            <li><a href="<?php echo $facebook; ?>" data-original-title="<?php echo translate('facebook'); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="<?php echo $twitter; ?>" data-original-title="<?php echo translate('twitter'); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="<?php echo $googleplus; ?>" data-original-title="<?php echo translate('google_plus'); ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                        </ul>
                        <ul class="list-inline right-topbar pull-right" id="loginsets"></ul>
                        <ul class="list-inline right-topbar pull-right"><?php
                            $pages = $this->db->get_where('page',array('status'=>'ok'))->result_array();
                            foreach($pages as $row1){?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/home/page/<?php echo $row1['parmalink']; ?>" class="dropdown-toggle" >
                                        <?php echo translate($row1['page_name']); ?>
                                    </a>
                                </li>|<?php
                            
                            }?>
                            <li><a href="<?php echo base_url(); ?>index.php/home/blog">BLOG</a></li> |
                            <li><a href="#contactus" id="cont_us" data-hover="dropdown" data-close-others="true" data-toggle="modal" class="dropdown-toggle active last">CONTACT US</a></li>
                        </ul>
                    </div>
                    
                </div>
            </div><!--/container-->
        </div>
        <!-- End Topbar v3 -->

        <!-- Navbar -->
        <div class="navbar navbar-default mega-menu" role="navigation" style="height:110px;">
            <div class="container">
                <div class="col-sm-2 col-xs-12">
                    <a class="navbar-brand" href="<?php echo base_url(); ?>index.php/home/">
                        <img id="logo-header" src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="Logo" class="img-responsive" style="width:130px;">
                    </a>
                </div>
                <div class="col-sm-9  col-xs-9" style="margin: 3% auto;">
                    <?php include 'search.php'; ?>
                </div>
                <div class="col-sm-1 col-xs-3" style="margin: 2.5% auto;"><?php 
                    if($ctrl_function != 'cart_checkout'){ ?>
                        <ul class="list-inline shop-badge badge-lists badge-icons pull-right" id="added_list"></ul><?php 
                    } ?>
                </div>
            </div>    
        </div> 
             
        <!-- End Navbar -->
        <div class="topbar-v3 nav-menu-outer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                                <span class="sr-only"><?php echo translate('toggle_navigation');?></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                        </div>
                        <ul class="list-inline right-topbar nav-menu">
                            <li>
                                <a style="color:red;font-size:15px;" href="<?php echo base_url(); ?>home/" class="dropdown-toggle" >
                                   <i class="glyphicon glyphicon-home"></i>
                                </a>
                            </li>
                            <!-- End Home -->
                            <!-- Equipment -->
                             <li>
                                <a href="<?php echo base_url(); ?>index.php/home/category/22" class="dropdown-toggle" >
                                    <?php echo translate('Equipment'); ?>
                                </a>
                            </li>
                            <!-- End Equipment -->

                            <!-- Accessories -->
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/home/category/21" class="dropdown-toggle" >
                                    <?php echo translate('Accessories'); ?>
                                </a>
                            </li>

                            <li>
                                <a href="<?php echo base_url(); ?>index.php/home/category/20" class="dropdown-toggle" >
                                    <?php echo translate('spare_parts'); ?>
                                </a>
                            </li>
                            <li class="brand_drpdwn dropdown">
                                <a  class="dropdown-toggle" > <!-- href="<?php echo base_url(); ?>index.php/home/brand_list" -->
                                    <?php echo translate('Brands'); ?>
                                </a>
                                
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/home/daily_deals" class="dropdown-toggle" >
                                    <?php echo translate('Daily Deals'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/home/track_order" class="dropdown-toggle" >
                                    <?php echo translate('Track Order'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/home/request_service" class="dropdown-toggle" >
                                    <?php echo translate('Request For Service'); ?>
                                </a>
                            </li>
			    <div class=" dropdown-content brandhome">
                                    <div class="box_margin"><?php 
                                        $page_data= $this->db->order_by('brand_id', 'desc')->get('brand')->result_array();
                                        foreach($page_data as $brnds){ ?>
                                            <a href="<?php echo base_url(); ?>index.php/home/brand/<?php echo $brnds['brand_id'];?>">
                                                <div class="brandpg_box"><?php 
                                                    $var= $this->crud_model->file_view('brand',$brnds['brand_id'],'','','no','src','','','.png'); 
                                                    if($var){ ?>
                                                        <img align="center" src="<?php echo $this->crud_model->file_view('brand',$brnds['brand_id'],'','','no','src','','','.png'); ?>" alt=""><?php 
                                                    } else {?>
                                                        <img align="center" src="http://marinecart.com/marine_test/uploads/brand_image/brand_default.png" alt=""><?php 
                                                    } ?>
                                                </div>
                                            </a><?php
                                        } ?>
                                    </div>
                                </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    
    <!--=== End Header style1 ===-->

<SCRIPT TYPE="text/javascript"> 
function popup(stat,clicks) {  if(clicks==1 && stat=='1' ){ $('#myModal').modal('show'); } } 
$(function() { 
   	$(".brand_drpdwn").hover(function(){ 
	    $(".dropdown-content.brandhome").css('height', '275');
              $(".dropdown-content.brandhome").css('z-index', '999');
              $(".dropdown-content.brandhome").css('overflow', 'auto');
              $(".dropdown-content.brandhome").show();
           }, function(){
            var id   = this.id; 
            $(".dropdown-content.brandhome").hide(); 
        });
           
        $(".dropdown-content.brandhome").hover(function(){
               $(this).show();
           }, function(){
            $(this).hide(); 
        });

    });
</SCRIPT>
<?php 
    function exchangeCurrency($currency_value,$exchange,$pr_price){
        if($currency_value=='USD'){ $amount_final=$pr_price/$exchange; } else{ $amount_final=$pr_price; }
        return($amount_final);
    }
function convertNumber($number) {
    return str_replace('.00', '', number_format($number, $decimals=2, $dec_point='.', $thousands_sep=','));
}?>