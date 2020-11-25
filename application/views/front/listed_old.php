<?php

$currency_value=currency();
 $exchange = $this->db->get_where('business_settings', array('type' => 'exchange'))->row()->value; 
 
if(count($all_products) == 0){  ?>
<div class="no-item">
    <div><img src="<?php echo base_url()?>template/front/assets/img/no-result.png"</div>
    <div> Sorry, Your search returns no results.</div>
</div>
<?php }else{
?><div id="suggn"></div><?php
	if($viewtype == 'list'){

     //   foreach($all_products as $row){
    foreach($prd_data as $row){
?>



<div class="tag-box tag-box-v1">

    <div class="row">

        <div class="col-sm-3" style="border-right: solid 1px #E2E2E2 !important;">

           <a target="_blank" href="<?php echo $this->crud_model->product_link($row['product_id']); ?>">

               <?php /* ?> <div class="shadow_list" style="background: url('<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one'); ?>') no-repeat center center; background-size: 100% auto;">
                </div><?php */ ?>
             <?php
                if ($this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one'))
                { ?>
                <div class="shadow_list" style="background: url('<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one'); ?>') no-repeat center center; background-size: 100% auto;">
                </div> 
                <?php } else { ?>
                <div class="shadow_list" style="background: url('<?php echo base_url().'uploads/product_image/default_product_thumb.jpg'; ?>') no-repeat center center; background-size: 100% auto;">
                </div>
                <?php } ?>

           </a>

        </div> 

        <div class="col-sm-9 product-description">

            <div class="overflow-h margin-bottom-5">

                <div class="col-sm-12">

                    <div class="col-sm-6 pull-left">

                        <ul class="list-inline overflow-h">

                            <li>

                                <h4 class="title-price">

                                    <a target="_blank" href="<?php echo $this->crud_model->product_link($row['product_id']); ?>">

                                        <?php echo $this->crud_model->limit_chars($row['title'],40);?>

                                    </a>

                                </h4>

                            </li>


                    <div class="">
                            <span class="">
                                <?php echo translate('product_code').' : '.$row['product_code']; ?>
                            </span>
                   </div>
                   <div class="">
                            <span class="">
                               <?php echo translate('product_type').' : '.$row['item_type']; ?>
                            </span>
                   </div>

                            <?php 
                                    $content=trim(strip_tags($row['short_description']));
                                    $words = explode(" ",$content);
                                    $dis=array_slice($words,0,20);
                                    $re= implode(" ",$dis)." ...";
                                    //echo trim($re);
                                    if (trim($re)!=" ...") {
                                        # code...
                                    ?>
                                    <div class="tooltiptexts3" >
                                       <?php echo trim($re); ?>
                                    </div>
                                    <?php
                                    }
                                ?>

                        </ul>

                          

                        <div class="margin-bottom-10">

                            <?php if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'discount') > 0){ ?>

                                <span class="title-price margin-right-10">
                            <?php 
                                $dp=$this->crud_model->get_product_price($row['product_id']);
                                echo currency().round($this->crud_model->uae_product_price($row['product_id'],$dp)); 

                            /*$pr_price=$this->crud_model->get_product_price($row['product_id']);
$amount_final=exchangeCurrency($currency_value,$exchange,$pr_price); 
echo currency()." ".convertNumber($amount_final); */ 

 /*$pr_price=$this->crud_model->get_product_price($row['product_id']);

                                if($currency_value=='USD')
{

$amount_final=$pr_price/$exchange;
echo currency()." ".number_format($amount_final); 
}
 else
 {
 $amount_final=$this->crud_model->get_product_price($row['product_id']); 
 echo currency()." ".number_format($amount_final); 
 }
*/
                                ?></span>

                                <span class="title-price line-through">
                                <?php 
                                echo currency().round($this->crud_model->uae_product_price($row['product_id'],$row['sale_price']));
/* $sal_price=$row['sale_price'];
$amount_final1=exchangeCurrency($currency_value,$exchange,$sal_price); 
echo currency()." ".convertNumber($amount_final1);  

*/
/*$pr_price=$row['sale_price'];
 if($currency_value=='USD')
{
//echo "in1";
$amount_final=$pr_price/$exchange;
echo currency()." ".number_format($amount_final); 
}
 else
 {
    //echo "in2";
 $amount_final=$this->crud_model->get_product_price($row['product_id']); 
 echo currency()." ".number_format($amount_final); 
 }*/
                                 ?></span>

                            <?php } else { ?>

                                <span class="title-price margin-right-10">
                                <?php
                                    echo currency().round($this->crud_model->uae_product_price($row['product_id'],$row['sale_price']));
                                    //echo currency().round($row['sale_price']);

/*$sal_price=$row['sale_price'];
$amount_final1=exchangeCurrency($currency_value,$exchange,$sal_price); 
echo currency()." ".convertNumber($amount_final1);  */

/*$pr_price=$row['sale_price'];
 if($currency_value=='USD')
{
//echo "in1";
$amount_final=$pr_price/$exchange;
echo currency()." ".number_format($amount_final); 
}
 else
 {
    //echo "in2";
 $amount_final=$this->crud_model->get_product_price($row['product_id']); 
 echo currency()." ".number_format($amount_final); 
 }
*/

                                 ?></span>

                            <?php } ?>

                        </div>

                        <div class="margin-bottom-10 pull-left">

<?php 

 if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'product_type') == 1){ ?>





<div class="shop-rgba-red  refur" style="border-top-left-radius: 0px !important;"><?php echo translate('refurbished');?></div>



<?php } ?>





                        <?php

                            if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'current_stock') <= 0 && !$this->crud_model->is_digital($row['product_id'])){

                        ?>

                           <!-- <div class="margin-bottom-10  pull-left">

                                <span class="label label-danger pull-left" style="margin-right: 7px;"> -->


                                    <?php // echo translate('out_of_stock');?>

                             <!--   </span>

                            </div> -->

                        <?php

                            } else {

                                if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'discount') > 0){ 

                        ?>

                            <div class="margin-bottom-5  pull-left">

                                <span class="label label-green pull-left" style="margin-right: 7px;">

                                    <?php 

                                        if($row['discount_type'] == 'percent'){

                                            echo $row['discount'].'%';

                                        } else if($row['discount_type'] == 'amount'){

                                         echo currency().$row['discount'];
                                            /* $ds=$row['discount'];
 if($currency_value=='USD')
{
//echo "in1";
$dis_final=$ds/$exchange;
echo currency()." ".number_format($dis_final); 
}
 else
 {
    //echo "in2";
 $dis_final=$ds=$row['discount']; 
 echo currency()." ".number_format($dis_final); 
 }*/


                                        }

                                    ?>

                                    <?php echo ' '.translate('off'); ?>

                                </span>

                            </div>

                        <?php 

                                } 

                            }

                        ?>

                        </div>

						<?php

                            if($vendor_system == 'ok'){

                        ?>

                        <div class="margin-bottom-10">

                            <span class="gender">

                                <?php echo translate('vendor').' : '.$this->crud_model->product_by($row['product_id'],'with_link'); ?>

                            </span>

                        </div>


                        <div class="margin-bottom-10">

                            <span class="gender">

                                <?php 
   echo translate('brand').' : '.$this->crud_model->get_type_name_by_id('brand',$row['brand'],'name'); ?>

                                 

                            </span>

                        </div>
						<?php

                            }

                        ?>

                    </div>

                    

                    <div class="col-sm-6">

                        <ul class="list-inline product-ratings pull-right tooltips" style="padding:5px !important;"

                            data-original-title="<?php echo $rating = $this->crud_model->rating($row['product_id']); ?>"	

                                data-toggle="tooltip" data-placement="left" >

                            <?php

                                $rating = $this->crud_model->rating($row['product_id']);

                                $r = $rating;

                                $i = 0;

                                while($i<5){

                                    $i++;

                            ?>

                            <li>

                                <i class="rating<?php if($i<=$rating){ echo '-selected'; } $r--; ?> fa fa-star<?php if($r < 1 && $r > 0){ echo '-half';} ?>"></i>

                            </li>

                            <?php

                                }

                            ?>

                        </ul>

                        

                        <ul class="list-inline margin-bottom-20">

                            <li class="margin-bottom-10 pull-right">
 <?php
    if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'current_stock') <= 0 && !$this->crud_model->is_digital($row['product_id'])){
?>            
 <a data-hover="dropdown" data-close-others="true" data-toggle="modal" class="dropdown-toggle active req_fr_prdct" href=""  data-type='text' data-pid='<?php echo $row['product_id']; ?>' data-pcode='<?php echo $row['product_code']; ?>' >
    Request quote<span class="arrow"></span>
 <i class=""></i></a>
 <?php } 
 else if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'current_stock') > 0 && !$this->crud_model->is_digital($row['product_id']) && $this->crud_model->check_sndpd($row['product_id']) == 1 )
    {
?>            
 <a data-hover="dropdown" data-close-others="true" data-toggle="modal" class="dropdown-toggle active req_fr_prdct" href=""  data-type='text' data-pid='<?php echo $row['product_id']; ?>' data-pcode='<?php echo $row['product_code']; ?>' >
    Request quote<span class="arrow"></span>
  <i class=""></i>
</a>
 <?php }

 else {?>

                                <div rel="curl-bottom-right" class="<?php if($this->crud_model->is_added_to_cart($row['product_id'])){ ?>btn_carted<?php } else { ?>btn_cart<?php } ?> float-shadow add_to_cart"  data-type='text' data-pid='<?php echo $row['product_id']; ?>' style="padding:2px 12px;">

                                    <?php if($this->crud_model->is_added_to_cart($row['product_id'])){ ?>

                                        <i class="fa fa-shopping-cart"></i>

                                        <?php echo translate('added_to_cart');?>

                                    <?php } else { ?>

                                        <i class="fa fa-shopping-cart"></i>

                                        <?php echo translate('add_to_cart');?>

                                    <?php } ?>

                                </div>

                                 <?php } ?>

                                   

                            </li>

                            

                            <?php 

                                $wish = $this->crud_model->is_wished($row['product_id']); 

                            ?>

                            <li class="pull-right">

                                <div rel="curl-bottom-left" data-pid='<?php echo $row['product_id']; ?>'

                                    class="btn-block <?php if($wish == 'yes'){ ?>btn_wished<?php } else {?>btn_wish<?php } ?> pull-right" style="padding:2px 12px;">

                                    <?php if($wish == 'yes'){ ?>

                                        <?php echo translate('wished');?>

                                    <?php } else {?>

                                        <?php echo translate('wish');?>

                                    <?php } ?>

                                </div>

                            </li>

                        </ul>

                        <ul class="list-inline margin-bottom-20">

                            <li class="margin-bottom-10 pull-right">
                            <div id="cmp_id" >

                                <a onclick="cmp()"  class="btn-u btn-u-cust float-shadow <?php if($this->crud_model->is_compared($row['product_id'])=='yes'){ ?>disabled<?php } else { ?>btn_compare<?php } ?>"  type="button" style="padding:2px 13px !important;" data-pid='<?php echo $row['product_id']; ?>' >

									<?php if($this->crud_model->is_compared($row['product_id'])=='yes'){ ?>

                                        <?php echo translate('compared');?>

                                    <?php } else {?>

                                        <?php echo translate('compare');?>

                                    <?php } ?>

                                 </a></div>

                            </li>

                            

                            <li class="pull-right">

                                <a class="btn-u btn-u-cust float-shadow various fancybox.ajax" data-fancybox-type="ajax" href="<?php echo $this->crud_model->product_link($row['product_id'],'quick'); ?>" style="padding:2px 13px !important;"><?php echo translate('quick_view');?></a>

                            </li>

                        </ul>

                     </div>

                 </div>

            </div>    

        </div>

    </div>

</div>







<?php

       }

	} 

else if($viewtype == 'list1')
{
    //  foreach($all_products as $row){
    foreach($prd_data as $row){
?>


<div class="tag-box tag-box-v1">

    <div class="row">

        

        <div class="col-sm-12 product-description">

            <div class="overflow-h ">

                <div class="col-sm-8">

                    <div class="col-sm-6 pull-left no-padding">

                        <ul class="list-inline overflow-h">

                            <li>

                                <h4 class="title-price">

                                    <a target="_blank" href="<?php echo $this->crud_model->product_link($row['product_id']); ?>">

                                        <?php echo $this->crud_model->limit_chars($row['title'],40);?>

                                    </a>

                                </h4>

                            </li>

                        </ul></div>

                   <div class="col-sm-4 pull-left">
                            <span class="">
                                <?php echo translate('product_code').' : '.$row['product_code']; ?>
                            </span>
                   </div>
                   <div class="col-sm-4 pull-left">
                            <span class="">
                               <?php echo translate('product_type').' : '.$row['item_type']; ?>
                            </span>
                   </div>

                        <div class="col-sm-4 pull-left">

                            <?php if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'discount') > 0){ ?>
                                <span class="title-price margin-right-10">
                            <?php 
                                $dp=$this->crud_model->get_product_price($row['product_id']);
                                echo currency().round($this->crud_model->uae_product_price($row['product_id'],$dp));
                               //echo currency().$this->crud_model->get_product_price($row['product_id']); 

                            /*$pr_price=$this->crud_model->get_product_price($row['product_id']);
$amount_final=exchangeCurrency($currency_value,$exchange,$pr_price); 
echo currency()." ".convertNumber($amount_final); */ 

 /*$pr_price=$this->crud_model->get_product_price($row['product_id']);

                                if($currency_value=='USD')
{

$amount_final=$pr_price/$exchange;
echo currency()." ".number_format($amount_final); 
}
 else
 {
 $amount_final=$this->crud_model->get_product_price($row['product_id']); 
 echo currency()." ".number_format($amount_final); 
 }
*/
                                ?></span>

                                <span class="title-price line-through">
                                <?php 
                                    echo currency().round($this->crud_model->uae_product_price($row['product_id'],$row['sale_price']));
                                //echo currency().round($row['sale_price']);
/* $sal_price=$row['sale_price'];
$amount_final1=exchangeCurrency($currency_value,$exchange,$sal_price); 
echo currency()." ".convertNumber($amount_final1);  

*/
/*$pr_price=$row['sale_price'];
 if($currency_value=='USD')
{
//echo "in1";
$amount_final=$pr_price/$exchange;
echo currency()." ".number_format($amount_final); 
}
 else
 {
    //echo "in2";
 $amount_final=$this->crud_model->get_product_price($row['product_id']); 
 echo currency()." ".number_format($amount_final); 
 }*/
                                 ?></span>

                            <?php } else { ?>

                                <span class="title-price margin-right-10">
                            <?php
                                echo currency().round($this->crud_model->uae_product_price($row['product_id'],$row['sale_price']));

                               //echo currency().round($row['sale_price']);

/*$sal_price=$row['sale_price'];
$amount_final1=exchangeCurrency($currency_value,$exchange,$sal_price); 
echo currency()." ".convertNumber($amount_final1);  */

/*$pr_price=$row['sale_price'];
 if($currency_value=='USD')
{
//echo "in1";
$amount_final=$pr_price/$exchange;
echo currency()." ".number_format($amount_final); 
}
 else
 {
    //echo "in2";
 $amount_final=$this->crud_model->get_product_price($row['product_id']); 
 echo currency()." ".number_format($amount_final); 
 }
*/

                                 ?></span>

                            <?php } ?>

                        </div>

                        <div class="col-sm-3 pull-left">


<?php


 if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'product_type') == 1){?>





<div class="shop-rgba-red label label-danger refur" style="border-top-left-radius: 4px !important;"><?php echo translate('refurbished');?></div>







<?php

 }



?>                        <?php

                            if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'current_stock') <= 0 && !$this->crud_model->is_digital($row['product_id'])){

                        ?>

                          <!--  <div class="margin-bottom-10  pull-left">

                                <span class="label label-danger pull-left" style="margin-right: 7px;">-->

                                    <?php //echo translate('out_of_stock');?>

                              <!--  </span>

                            </div> -->

                        <?php

                            } else {

                                if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'discount') > 0){ 

                        ?>

                            <div class="margin-bottom-5  pull-left">

                                <span class="label label-green pull-left" style="margin-right: 7px;">

                                    <?php 

                                        if($row['discount_type'] == 'percent'){

                                            echo $row['discount'].'%';

                                        } else if($row['discount_type'] == 'amount'){

                                         echo currency().$row['discount'];
                                            /* $ds=$row['discount'];
 if($currency_value=='USD')
{
//echo "in1";
$dis_final=$ds/$exchange;
echo currency()." ".number_format($dis_final); 
}
 else
 {
    //echo "in2";
 $dis_final=$ds=$row['discount']; 
 echo currency()." ".number_format($dis_final); 
 }*/


                                        }

                                    ?>

                                    <?php echo ' '.translate('off'); ?>

                                </span>

                            </div>

                        <?php 

                                } 

                            }

                        ?>

                        </div>

                        <?php

                           // if($vendor_system == 'ok'){

                        ?>

                      <!--   <div class="margin-bottom-10">

                            <span class="gender">

                                <?php echo translate('vendor').' : '.$this->crud_model->product_by($row['product_id'],'with_link'); ?>

                            </span>

                        </div>
                        <div class="margin-bottom-10">

                            <span class="gender">

                                <?php 
                        echo translate('brand').' : '.$this->crud_model->get_type_name_by_id('brand',$row['brand'],'name'); 

                            
                                ?>

                            </span>

                        </div>
 -->
                        <?php

                            //}

                        ?>

                    </div>

                    

                    <div class="col-sm-4">

                      <!--   <ul class="list-inline product-ratings pull-right tooltips" style="padding:5px !important;"

                            data-original-title="<?php echo $rating = $this->crud_model->rating($row['product_id']); ?>"    

                                data-toggle="tooltip" data-placement="left" >

                            <?php

                                $rating = $this->crud_model->rating($row['product_id']);

                                $r = $rating;

                                $i = 0;

                                while($i<5){

                                    $i++;

                            ?>

                            <li>

                                <i class="rating<?php if($i<=$rating){ echo '-selected'; } $r--; ?> fa fa-star<?php if($r < 1 && $r > 0){ echo '-half';} ?>"></i>

                            </li>

                            <?php

                                }

                            ?>

                        </ul> -->

                        

                        <ul class="list-inline margin-bottom-20">

                            <li class="margin-bottom-10 pull-right">
<?php
    if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'current_stock') <= 0 && !$this->crud_model->is_digital($row['product_id'])){
                ?>            
 <a data-hover="dropdown" data-close-others="true" data-toggle="modal" class="dropdown-toggle active req_fr_prdct" href="" data-type='text' data-pid='<?php echo $row['product_id']; ?>' data-pcode='<?php echo $row['product_code']; ?>' >
    Request quote<span class="arrow"></span>
  <i class=""></i></a>
<?php } 
else if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'current_stock') > 0 && !$this->crud_model->is_digital($row['product_id']) && $this->crud_model->check_sndpd($row['product_id']) == 1 )
    {
?>            
 <a data-hover="dropdown" data-close-others="true" data-toggle="modal" class="dropdown-toggle active req_fr_prdct" href=""  data-type='text' data-pid='<?php echo $row['product_id']; ?>' data-pcode='<?php echo $row['product_code']; ?>' >
    Request quote<span class="arrow"></span>
  <i class=""></i>
</a>
 <?php }


else {?>
                                <div rel="curl-bottom-right" class="<?php if($this->crud_model->is_added_to_cart($row['product_id'])){ ?>btn_carted<?php } else { ?>btn_cart<?php } ?> float-shadow add_to_cart"  data-type='text' data-pid='<?php echo $row['product_id']; ?>' style="padding:2px 12px;">

                                    <?php if($this->crud_model->is_added_to_cart($row['product_id'])){ ?>

                                        <i class="fa fa-shopping-cart"></i>

                                        <?php echo translate('added_to_cart');?>

                                    <?php } else { ?>

                                        <i class="fa fa-shopping-cart"></i>

                                        <?php echo translate('add_to_cart');?>

                                    <?php } ?>

                                </div>


                                <?php } ?>

                                     

                            </li>

                            

                            <?php 

                                $wish = $this->crud_model->is_wished($row['product_id']); 

                            ?>

                            <li class="pull-right">

                                <div rel="curl-bottom-left" data-pid='<?php echo $row['product_id']; ?>'

                                    class="btn-block <?php if($wish == 'yes'){ ?>btn_wished<?php } else {?>btn_wish<?php } ?> pull-right" style="padding:2px 12px;">

                                    <?php if($wish == 'yes'){ ?>

                                        <?php echo translate('wished');?>

                                    <?php } else {?>

                                        <?php echo translate('wish');?>

                                    <?php } ?>

                                </div>

                            </li>

                        </ul>

                      <!--   <ul class="list-inline margin-bottom-20">

                            <li class="margin-bottom-10 pull-right">

                                <a class="btn-u btn-u-cust float-shadow <?php if($this->crud_model->is_compared($row['product_id'])=='yes'){ ?>disabled<?php } else { ?>btn_compare<?php } ?>" onclick="cmp()" type="button" style="padding:2px 13px !important;" data-pid='<?php echo $row['product_id']; ?>' >

                                    <?php if($this->crud_model->is_compared($row['product_id'])=='yes'){ ?>

                                        <?php echo translate('compared');?>

                                    <?php } else {?>

                                        <?php echo translate('compare');?>

                                    <?php } ?>

                                 </a>

                            </li>

                            

                            <li class="pull-right">

                                <a class="btn-u btn-u-cust float-shadow various fancybox.ajax" data-fancybox-type="ajax" href="<?php echo $this->crud_model->product_link($row['product_id'],'quick'); ?>" style="padding:2px 13px !important;"><?php echo translate('quick_view');?></a>

                            </li>

                        </ul>
 -->
                     </div>

                 </div>

            </div>    

        </div>

    </div>

</div>







<?php
}

}


    else if($viewtype == 'grid'){

		$f_num = (12/$grid_items_per_row);

?>



<div class="row illustration-v2">

<?php

	$n = 0;

 //   foreach($all_products as $row){
    foreach($prd_data as $row){
		$n++;

?> 	

        

    <div class="col-md-<?php echo $f_num; ?>" style="padding:1px;">

        <div class="item custom_item">

            <div class="product-img">

                <a target="_blank" href="<?php echo $this->crud_model->product_link($row['product_id']); ?>">

                   <?php /* ?> <div class="shadow" style="background: url('<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one'); ?>') no-repeat center center; background-size: 100% auto;">
                    </div> <?php */ ?>
               <?php
                if ($this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one'))
                { ?>
                <div class="shadow" style="background: url('<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one'); ?>') no-repeat center center; background-size: 100% auto;">
                </div> 
                <?php } else { ?>
                <div class="shadow" style="background: url('<?php echo base_url().'uploads/product_image/default_product_thumb.jpg'; ?>') no-repeat center center; background-size: 100% auto;">
                </div>
                <?php } ?>

                </a>

               <!--  <a class=" product-review various fancybox.ajax" data-fancybox-type="ajax" href="<?php echo $this->crud_model->product_link($row['product_id'],'quick'); ?>"><?php echo translate('quick_view');?></a> -->
  <?php

                    if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'current_stock') <= 0 && !$this->crud_model->is_digital($row['product_id'])){

                ?>            
 <a data-hover="dropdown" data-close-others="true" data-toggle="modal" class="dropdown-toggle active req_fr_prdct" href="" data-type='text' data-pid='<?php echo $row['product_id']; ?>' data-pcode='<?php echo $row['product_code']; ?>' >

    Request quote<span class="arrow"></span>
    <i class=""></i></a>
<?php } 
else if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'current_stock') > 0 && !$this->crud_model->is_digital($row['product_id']) && $this->crud_model->check_sndpd($row['product_id']) == 1 )
    {
?>            
 <a data-hover="dropdown" data-close-others="true" data-toggle="modal" class="dropdown-toggle active req_fr_prdct" href=""  data-type='text' data-pid='<?php echo $row['product_id']; ?>' data-pcode='<?php echo $row['product_code']; ?>' >
    Request quote<span class="arrow"></span>
  <i class=""></i>
</a>
 <?php }

else {?>
                <?php if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'discount') > 0){ $price = $this->crud_model->get_product_price($row['product_id']); } else{ $price = $row['sale_price']; } ?>
                <a class="add-to-cart <?php if($price > 0){ echo 'add_to_cart'; } ?>" data-type='text' data-pid='<?php echo $row['product_id']; ?>'  style="width: 48%;">

                   

                    <?php if($this->crud_model->is_added_to_cart($row['product_id'])){ ?>

                        <?php echo translate('added_to_cart');?>

                    <?php } else { ?>

                        <?php echo translate('add_to_cart');?>

                    <?php } ?>

                </a>


                <a class=" COM-STYLE" data-type="text" style="width: 48%;"> 

                                <?php

                                if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'discount') > 0){ ?>
                                    <div class="col-md-12  text-center">
                                        <?php
                                            $dp=$this->crud_model->get_product_price($row['product_id']);
                                            echo currency().round($this->crud_model->uae_product_price($row['product_id'],$dp));
                                            //echo currency().$this->crud_model->get_product_price($row['product_id']);                
                                            /*$pr_price=$this->crud_model->get_product_price($row['product_id']);
                                            $amount_final=exchangeCurrency($currency_value,$exchange,$pr_price);
                                            echo currency()." ".convertNumber($amount_final); */
                                            ?>
                                    </div>
                                    <?php 
                                    } else { ?>

                                    <div class="col-md-12  text-center">
                                         <?php 

                                          echo currency().round($this->crud_model->uae_product_price($row['product_id'],$row['sale_price']));
                                          //echo currency().round($row['sale_price']);
                                            /* $pr_price=$row['sale_price'];
                                            $amount_final=exchangeCurrency($currency_value,$exchange,$pr_price);
                                            echo currency()." ".convertNumber($amount_final);*/
                                         ?>
                                    </div>
                                    <?php  }  ?>
                    </a> 
                
    
       
<?php
}
 if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'product_type') == 1){?>





<div class="shop-rgba-red refur" style="border-top-left-radius: 4px !important;"><?php echo translate('refurbished');?></div>







<?php

 }

?>


                <?php

                    if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'current_stock') <= 0 && !$this->crud_model->is_digital($row['product_id']))
                    {

                ?>

               <!-- <div class="shop-rgba-red rgba-banner" style="border-top-right-radius: 4px !important;"> --><?php //echo translate('out_of_stock');?> <!-- </div> -->

                <?php

                    } else {

                        if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'discount') > 0){ 

                ?>

                    <div class="shop-bg-green rgba-banner" style="border-top-right-radius:4px !important;">

                        <?php 

                            if($row['discount_type'] == 'percent'){

                                echo $row['discount'].'%';

                            } else if($row['discount_type'] == 'amount'){

                              echo currency().$row['discount'];
                                                                      //  $ds=$row['discount'];
 /*if($currency_value=='USD')
{
//echo "in1";
$dis_final=$ds/$exchange;
echo currency()." ".number_format($dis_final); 
}
 else
 {
    //echo "in2";
 $dis_final=$ds=$row['discount']; 
 echo currency()." ".number_format($dis_final); 
 }*/

                            }

                        ?>

                        <?php echo ' '.translate('off'); ?>

                    </div>

                <?php 

                        } 

                    }

                ?>                    

            </div>

            <div class="product-description product-description-brd">

                <div class="overflow-h margin-bottom-5">

                    <h4 class="title-price text-center product_name"><a target="_blank" href="<?php echo $this->crud_model->product_link($row['product_id']); ?>"><?php echo $row['title'] ?></a></h4> 

                                    <?php 
                                    $content=trim(strip_tags($row['short_description']));
                                    $words = explode(" ",$content);
                                    $dis=array_slice($words,0,20);
                                    $re= implode(" ",$dis)."...";
                                    //echo trim($re);
                                    if (trim($re)!="...") {
                                        # code...
                                    ?>
                                    <div class="tooltiptexts3" >
                                       <?php echo trim($re); ?>
                                    </div>
                                    <?php
                                    }
                                    ?>

                    <div class="col-md-12 list_prdcts"> 
                        <div class="row">
                    <div class="col-md-12 text-center margin-bottom-5 gender"> 
                     <?php echo translate('product_code').' : '.$row['product_code']; ?>
                    </div>

                    <div class="col-md-12 text-center margin-bottom-5 gender"> 
                    <?php echo translate('product_type').' : '.$row['item_type']; ?>
                    </div>
                        </div>
                    </div>

                </div>

               <!-- <div class="col-md-12"> 

                    <ul class="list-inline product-ratings col-md-12 col-sm-12 col-xs-12 tooltips text-center"

                        data-original-title="<?php echo $rating = $this->crud_model->rating($row['product_id']); ?>"	

                            data-toggle="tooltip" data-placement="top" >

                        <?php

                            $rating = $this->crud_model->rating($row['product_id']);

                            $r = $rating;

                            $i = 0;

                            while($i<5){

                                $i++;

                        ?>

                        <li>

                            <i class="rating<?php if($i<=$rating){ echo '-selected'; } $r--; ?> fa fa-star<?php if($r < 1 && $r > 0){ echo '-half';} ?>"></i>

                        </li>

                        <?php

                            }

                        ?>

                    </ul>

                </div> -->

              

                <div class="col-md-12 text-center margin-bottom-5 gender"> 

                    <?php echo translate('vendor').' : '.$this->crud_model->product_by($row['product_id'],'with_link'); ?>

                </div>

<div class="col-md-12 text-center margin-bottom-5 gender"> 
<?php
        echo translate('brand').' : '.$this->crud_model->get_type_name_by_id('brand',$row['brand'],'name'); ?>
</div>

<div class="col-md-12 text-center margin-bottom-5 gender"> 
    <i class="fa fa-map-marker" aria-hidden="true"></i>  <?php echo ' : '.$row['location']; ?>
</div>

                <hr>

                

                <div class="col-md-6" style="margin-top:0;">
<div id="cmp_id" >
                    <a onclick="cmp()"  class="btn-u btn-u-cust float-shadow <?php if($this->crud_model->is_compared($row['product_id'])=='yes'){ ?>disabled<?php } else { ?>btn_compare<?php } ?>" type="button" style="padding:2px 13px !important;" data-pid='<?php echo $row['product_id']; ?>' >

                        <?php if($this->crud_model->is_compared($row['product_id'])=='yes'){ ?>

                            <?php echo translate('compared');?>

                        <?php } else {?>

                            <?php echo translate('compare');?>

                        <?php } ?>

                     </a></div>

                </div>

                <?php 

                    $wish = $this->crud_model->is_wished($row['product_id']); 

                ?>

                <div class="col-md-6" style="margin-top:0;">

                    <a rel="outline-outward" class="btn-u btn-u-cust float-shadow pull-right <?php if($wish == 'yes'){ ?>btn_wished<?php } else {?>btn_wish<?php } ?>" style="padding:2px 13px !important; color:white;" data-pid='<?php echo $row['product_id']; ?>'>

                        <?php if($wish == 'yes'){ ?>

                            <?php echo translate('wished');?>

                        <?php } else {?>

                            <?php echo translate('wish');?>

                        <?php } ?>

                    </a>

                </div>

            </div>

        </div>

    </div>

	<?php if($n % 4 == 0){ ?>

         </div>

         <div class="row illustration-v2">

	<?php

			}

        }

    ?>

         

</div>

<?php

	}
}

?>




<!-- <div class="wishlist " id="comparetab" >
        <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/home/compare">
           <i class="fa fa-exchange" aria-hidden="true"></i>
        </a>
    </div> -->

<div class="text-center" style="display:none;" id="pagenation_links">

    <?php echo $this->ajax_pagination->create_links(); ?>

</div><!--/end pagination-->



<script>

	$(document).ready(function() {

		$('.pg_links').html($('#pagenation_links').html());

         $('.pg_links').click(function(){
              $('html, body').animate({scrollTop: $('.header-fixed').offset().top  }, 'slow');
            });


		$('.result-category').html(''

			+'<h2 style="text-transform: none;"><?php  $bar = ucwords($name); 
                                                       $bar = ucwords(strtolower($bar)); echo $bar; //echo translate($name); ?></h2>'

			+'<div class="col-sm-2 shop-bg-red badge-results"><?php echo $count; ?> <?php echo translate('results'); ?></div>'

		);



            $("#elvText").val('<?php echo $elvText?>');

                var text = 'Showing results for <b>'+$("#elvText").val()+'</b>. Search instead for <b>'+$("#txtinput").val()+'</b>';
                if($("#elvText").val() != '' && $("#txtr").val() != $("#elvText").val()){  $('#suggn').html('<span>'+text+'</span>');   }
            // var text = 'Showing results for <b>'+$("#txtr").val()+'</b>. Search instead for <b>'+$("#txtinput").val()+'</b>';
            // if($("#txtinput").val() != '' && $("#txtr").val() != $("#txtinput").val()){  $('#suggn').html('<span>'+text+'</span>');   }


   







	});

    /*$('.req_fr_prdct').click(function()
        {
         
         var product= $(this).data('pid');
         var pcode = $(this).data('pcode');
         $("#quote_pid").val(product);
         $("#quote_pcode").val(pcode);

          });*/
//Request Quote
         $('.req_fr_prdct').click(function()
        {
         
           var state = check_login_stat('state');
            state.success(function (data) {
            if(data == 'hypass')
            {
                $("#addClientPop").modal();
            } else 
            {
                
                $('#loginss').click();
            }
             });   
         var product= $(this).data('pid');
         var pcode = $(this).data('pcode');
         $("#quote_pid").val(product);
         $("#quote_pcode").val(pcode);

        });

 /*  $("#cmp_id").click(function(e){

      ///  $("#comparetab").show();
//alert("innnn");

   $.ajax({
       
        //type: "POST",
        url: "<?php echo base_url(); ?>index.php/home/compareCount", 
        //data:mobile_nr,
        dataType:"html",
        cache       : false,
        contentType : false,
        //processData : false,//return type expected as json
        success: function(states){
            console.log(states);
        //console.log(states);
             if(states == 0){
                // console.log(states);
                 
        //  document.getElementById('alertspan').innerHTML = 'Please check your mail for OTP';   
                 $('#comparetab').hide();
                 
                }
            if(states != 0){
                         
         $('#comparetab').show();
     
                
            }
             
            
        //   console.log(states);
        },
    });




  });
*/



</script>

<style>

div.shadow_list {

    max-height:140px;

    min-height:140px;

    overflow:hidden;

	-webkit-transition: all .4s ease;

	-moz-transition: all .4s ease;

	-o-transition: all .4s ease;

	-ms-transition: all .4s ease;

	transition: all .4s ease;

}

.shadow_list:hover {

	background-size: 110% auto !important;

}

.COM-STYLE {
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



div.shadow {

    max-height:300px;

    min-height:300px;

    overflow:hidden;

	-webkit-transition: all .4s ease;

	-moz-transition: all .4s ease;

	-o-transition: all .4s ease;

	-ms-transition: all .4s ease;

	transition: all .4s ease;

}

.shadow:hover {

	background-size: 110% auto !important;

}



.custom_item{

	border: 1px solid #ccc;

	border-radius: 0px !important;

	transition: all .2s ease-in-out;

	margin-top:10px !important; 

}

.custom_item:hover{

	webkit-transform: translate3d(0, -5px, 0);

	-moz-transform: translate3d(0, -5px, 0);

	-o-transform: translate3d(0, -5px, 0);

	-ms-transform: translate3d(0, -5px, 0);

	transform: translate3d(0, -5px, 0);

	-webkit-box-shadow: 0 1px 11px rgba(0,0,0,0.25);

	box-shadow: 0 1px 11px rgba(0,0,0,0.25);

}

.btn_wish{

	/*border:1px solid #FF4981 !important;*/

	border-radius: 0px !important;
background: #FF4981;
	border: 0;
 
 color:#fff  ;

	font-size: 14px;

	cursor: pointer;

	font-weight: 400;

	padding: 4px 8px;

	position: relative;

	white-space: nowrap;

	display: inline-block;

	text-decoration: none;

	-webkit-transition: all 0.4s ease-in-out;

	-moz-transition: all 0.4s ease-in-out;

	-o-transition: all 0.4s ease-in-out;

	transition: all 0.4s ease-in-out;

}



.btn_wish:hover{  

	background: #FF4981;

	transition: all .4s ease-in-out;

	color:#fff;	

	-webkit-transition: all 0.4s ease-in-out;

	-moz-transition: all 0.4s ease-in-out;

	-o-transition: all 0.4s ease-in-out;

	transition: all 0.4s ease-in-out;

}

.btn_wished{  

	border-radius: 4px !important;  

	background: #FF4981;

	color: #fff ;

	font-size: 14px;

	cursor: pointer;

	font-weight: 400;

	padding: 4px 8px;

	position: relative;

	white-space: nowrap;

	display: inline-block;

	text-decoration: none;

	-webkit-transition: all 0.4s ease-in-out;

	-moz-transition: all 0.4s ease-in-out;

	-o-transition: all 0.4s ease-in-out;

	transition: all 0.4s ease-in-out;

}


.product-description:hover .tooltiptexts3 {
    visibility: visible;
}
.product-description .tooltiptexts3 {
    visibility: hidden;
    width: 92%;
    height: 80px;
    background-color: #E2E2E2;
    text-align: center;
   /* padding: 0 0;*/
    border-radius: 6px;
    position: absolute;
    z-index: 55;
}


</style>