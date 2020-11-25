<style>
    .wizard > .content > .body select.invalid {
    color: #8a1f11;
    font-weight: 400;
    border: 1px solid #eec5c7 !important;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}
.button.limit{ background: #eee none repeat scroll 0 0;padding: 10px 17px; position: relative; top: -2px; left: -1px; }
</style>
<!--=== Content Medium Part ===-->
    <?php $userid=$this->session->userdata('user_id'); ?>
    <div class="content-md " style="padding-bottom: 30px;">
        <div class="container">
            <?php echo form_open(base_url() . 'index.php/home/cart_finish/go', array('class' => 'shopping-cart','method' => 'post','enctype' => 'multipart/form-data','id' => 'cart_form'));?>    
            <div>
                <div class="btns pull-right" style="float:right">
                    <ul class="list-inline right-topbar pull-right" ><li> <a  class=" btn  btn-success"  href="<?php echo base_url()."index.php/home/category"; ?>"><i class="fa fa-shopping-cart"></i> Continue Shopping</a></li></ul>
                </div>
                <div class="header-tags">
                    <div class="overflow-h">
                        <h2><?php echo translate('shopping_cart');?></h2><p><?php echo translate('review_&_edit_your_product');?></p><i class="rounded-x fa fa-check"></i>
                    </div>    
                </div>
                <section>
    <input id='signedin' hidden type="text" value="<?php echo $userid; ?>">                    <div class="table-responsive cart_list">
                        <table class="table" style="border: 1px solid #ddd;">
                            <thead><tr>
                                <td style="width: 40%"><?php echo translate('product');?></td>
                                <!--<td><?php echo translate('choices');?></td> -->
                                <td class="text-center"><?php echo translate('price');?></td>
                                <td class="text-center"><?php echo translate('quantity');?></td>
                                <td class="text-center"><?php echo translate('total');?></td>
                                <td style="text-align:right !important;"><?php echo translate('option');?></td>
                            </tr></thead>
                            <tbody><?php $allDigital = true;
                                foreach ($carted as $items){  
				    if($this->db->select('download')->get_where('product',array('product_id'=>$items['id']))->row()->download != 'ok'){ $allDigital = false; }
                                    $options        =   json_decode($items['option'],true);
                                    $optionColors   =   $options['color'];?>
                                    <tr data-rowid="<?php echo $items['rowid']; ?>" >
                                        <td class="product-in-table">
                                            <img class="img-responsive" src="<?php echo $items['image']; ?>" alt="">
                                            <div class="product-it-in"><h3><?php echo $items['name']; ?></h3></div>    
                                        </td>
                                      <!--  <td class="shop-product"><?php 
                                            if($optionColors['value'] != ''){ ?>
                                                <div style="background:<?php echo $optionColors['value']; ?>; height:25px; width:25px;" ></div>
                                                <?php }
                                            $all_o = json_decode($items['option'],true);
                                            foreach ($all_o as $l => $op) {
                                                if($l !== 'color' && $op['value'] !== '' && $op['value'] !== NULL){ echo $op['title'].' : ';
                                                    if(is_array($va = $op['value'])){ echo $va = join(', ',$va); } else { echo $va; } echo '<br />'; 
                                                }
                                            } ?>
                                            <a href="<?php echo $this->crud_model->product_link($items['id']); ?>"><?php echo translate('change_choices'); ?></a>
                                        </td> -->
                                        <td class="pric"><?php echo currency().$this->cart->format_number($items['price']); ?></td>
                                        <td><?php
                                            if(!$this->crud_model->is_digital($items['id'])){ ?>
                                                <button type='button' class="quantity-button minus" value='minus'>-</button>
                                                <input type='text' disabled step='1' class="quantity-field quantity_field" data-rowid="<?php echo $items['rowid']; ?>" data-limit='no' value="<?php echo $items['qty']; ?>" id='qty1' onblur="check_ok(this);" />
                                                <button type='button' class="quantity-button plus" value='plus'>+</button><span class="button limit" style="display:none;"></span><?php
                                            } ?>
                                        </td>
                                        <td class="shop-red sub_total"><?php echo currency().$this->cart->format_number($items['subtotal']); ?></td>
                                        <td class="text-center"><button type="button" class="close"><i class="fa fa-trash"></i></button></td>
                                    </tr><?php 
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </section>
                <script> var add_to_cart = '<?php echo translate('add_to_cart'); ?>'; var base_url = '<?php echo base_url(); ?>'; //set_cart_form();</script>
                <script src="<?php echo base_url(); ?>template/front/assets/js/custom/cart.js"></script>
                <div class="header-tags">
                    <div class="overflow-h">
                        <h2><?php echo translate('billing_info'); ?></h2>
                        <p><?php echo translate('shipping_and_address_info'); ?></p>
                        <i class="rounded-x fa fa-home"></i>
                    </div>    
                </div>
                <section class="billing-info">
                    <div class="row">
                        <div class="col-md-6 md-margin-bottom-40">
                            <h2 class="title-type"><?php echo translate('billing_address');
                                //if($userid>0){ ?>
                                    <button type="button" style="float:right;" class="btn btn-info " data-toggle="modal" id="myaddressadd" data-target="#myaddress">My Address</button>
                                <?php// } ?>
                            </h2>
                             <div class="clear"></div>
                                <div class="billing-info-inputs checkbox-list">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input id="name" type="text" placeholder="<?php echo translate('first_name'); ?>" name="firstname" class="form-control required" readonly>
                                            <!-- <input id="email" type="text" placeholder="<?php echo translate('email'); ?>" name="email" class="form-control  email required"> -->
                                        </div>
                                        <div class="col-sm-6">
                                            <input id="surname" type="text" placeholder="<?php echo translate('last_name'); ?>" name="lastname" class="form-control required" readonly>
                                            <!-- <input id="phone" type="tel" placeholder="<?php echo translate('phone'); ?>" name="phone" class="form-control required"> -->
                                        </div>
                                    </div>
                                    <input id="email" type="text" placeholder="<?php echo translate('email'); ?>" name="email" class="form-control  email required" readonly>
                                    <input id="phone" type="tel" placeholder="<?php echo translate('phone'); ?>" name="phone" class="form-control required" readonly  >
                                    <!-- onclick="cuph()" -->
                                    <div class="row phca" hidden="hidden">
                                        <div class="col col-sm-4">  
                                            <select id="phcountry_code" name="phcountryc" class="form-control required  col-sm-4" required="requried"  onchange="crtph()">
                                                <option value="">Country Code</option><?php
                                                $cntryp=$this->db->get_where('country')->result_array();
                                                foreach($cntryp as $cntryp_details){
                                                    echo "<option data-dialcode=".$cntryp_details[id]." data-countrycode=".$cntryp_details[iso]." value='".$cntryp_details[phonecode]."'>".$cntryp_details[name]."</option>";
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col col-sm-2">
                                            <input type="text" class=" form-control " id="d_co" readonly="readonly" value="+XX">
                                        </div>
                                    <!-- </div> -->
                                        <div class=" col col-sm-2"  ><input type="text" placeholder="XX" maxlength="2" name="pharcode" id="telacrt" class="form-control required numbers-only " required="requried" readonly="readonly" onchange="cpry();"></div>
                                        <div class="col col-sm-4" ><input type="text" placeholder="XXXXXXX" maxlength="7" name="ph" id="telncrt" class="form-control required numbers-only " required="required" readonly="readonly" onblur="cpppy();"></div>
                                    </div>
                                    <div class="row phca">
                                    <div class=" col col-sm-4" ></div>
                                    <div class=" col col-sm-4" style=" color:red; " id='phno_note1crt'></div>
                                    <div class="col col-sm-4" style="color:red; " id='phno_note2crt'></div>
                                    </div>
                                    <input id="address_1" type="text" placeholder="<?php echo translate('address_line_1'); ?>" name="address1" class="form-control address required" readonly>
                                    <input id="address_2"  type="text" placeholder="<?php echo translate('address_line_2'); ?>" name="address2" class="form-control address required" readonly>
<div class="row" style="margin-bottom:10px">
    <div class="col-sm-6">
        <!-- <select id="bill_country1" name="bill_country1" class="form-control required" onChange="bill_loadState(this)">
        <option value="">Select Country..</option><?php
        $user_cntry=$this->db->get_where('user',array('user_id'=>"$userid"))->row();
        $cn_id=$user_cntry->country_id;
        $st_id=$user_cntry->state_code;
        echo "<option value=''>$cn_id</option>";
        $cntry=$this->db->get_where('fed_country',array('status'=>'1'))->result_array();
        foreach($cntry as $cntry_details){?>
        <option <?php if($cn_id==$cntry_details[country_id]) { echo "selected";  }?> value='<?php echo $cntry_details[country_id];?>'><?php echo $cntry_details[name]; ?></option><?php 
                                                }?>
        </select> 
        <input type="hidden" value="" required name="bill_country_code" id="bill_country_code">-->
<?php
$user_cntry=$this->db->get_where('user',array('user_id'=>"$userid"))->row();
$cn_id=$user_cntry->country_id;
$st_id=$user_cntry->state_code; 
$cntryname=$this->db->get_where('fed_country',array('country_id'=>$cn_id))->row();
$st_name=$this->db->get_where('fed_zone',array('code'=>$st_id,'country_id'=>$cn_id))->row();
?>        
<input id="bill_country1" type="text" name="bill_country1" class="form-control address required" value="<?php echo $cn_id; ?>" hidden />
<input id="b_countryname" type="text" name="b_countryname" class="form-control address required" value="<?php echo $cntryname->name; ?>" readonly />
<input type="hidden" value="<?php echo $cntryname->iso_code_2; ?>" required name="bill_country_code" id="bill_country_code" />        
    </div>
    <div class="col-sm-6">
        <!-- <select id="bill_states" name="bill_state" class="form-control address required" onChange="">
        <option value=""><?php echo translate('State/Province'); ?></option><?php
        $init_state=$this->db->get_where('fed_zone',array('country_id	'=>"$cn_id"))->result_array();
        foreach($init_state as $state_details){?>
        <option <?php if($st_id==$state_details[code]) { echo "selected";  }?> value='<?php echo $state_details[code];?>'><?php echo $state_details[name]; ?></option><?php 
            } ?>
        </select> -->
<input type="text"  id="bill_states" name="bill_state" class="form-control address required" value="<?php echo $st_id; ?>" hidden>
<input type="text"  id="b_statename" name="b_statename" class="form-control address required" value="<?php echo $st_name->name; ?>" readonly>    
    </div>
</div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input id="city" type="text" placeholder="<?php echo translate('city'); ?>" name="city" class="form-control address required" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <input id="zip" type="text" placeholder="<?php echo translate('zip/postal_code'); ?>" name="zip" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="row" id="lnlat" style="display:none;" >
                                        <div class="col-sm-12">
                                            <input id="langlat" type="text" placeholder="langitude - latitude" name="langlat" class="form-control required" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 md-margin-bottom-40"><?php
                            if($allDigital == false){ ?>
                                <h2 class="title-type"><?php echo translate('shipping_address');
                                    //if($userid>0){ ?>
                                        <span style="float:right;text-transform: none;" id="adrs_span"><input type="checkbox" name="add_address" id="add_address">Add to Address Book
                                        </span><?php 
                                    //} ?>
                                </h2>
                                <input type="checkbox" name="billingtoo" onclick="FillBilling(this.form)"><em>Check this box if Billing Address and Shipping Address are the same.</em>
                               <input id="country_res" style="visibility: hidden;width:5px;height:5px;" type="text" placeholder="<?php echo translate('city'); ?>" name="country_res" class="form-control address required">
                                <div class="billing-info-inputs checkbox-list">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input id="sname" type="text" placeholder="<?php echo translate('first_name'); ?>" name="sfirstname" class="form-control required sadd">
                                        </div>
                                        <div class="col-sm-6">
                                            <input id="ssurname" type="text" placeholder="<?php echo translate('last_name'); ?>" name="slastname" class="form-control required sadd">
                                        </div>
                                    </div>
                                    <input id="semail" type="text" placeholder="<?php echo translate('email'); ?>" name="semail" class="form-control  email required sadd">
                                    <input id="sphone" type="tel" placeholder="<?php echo translate('phone'); ?>" name="sphone" class="form-control required sadd"  hidden >  
                                    <!--onclick="scuph()" hidden="hidden"-->  
                                    <div class="row sphca" >
                                         <div class="col col-sm-4">  
                                            <select id="scountry_code" name="sphcountryc" class="form-control required  col-sm-4" required="requried"  onchange="scrtph()">
                                                <option value="">Country Code</option><?php
                                                $cntryp=$this->db->get_where('country')->result_array();
                                                foreach($cntryp as $cntryp_details){
                                                    echo "<option data-dialcode=".$cntryp_details[id]." data-countrycode=".$cntryp_details[iso]." value='".$cntryp_details[phonecode]."'>".$cntryp_details[name]."</option>";
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col col-sm-2">
                                        <input type="text" class=" form-control " id="sd_co" readonly="readonly" value="+XX" placeholder='+XX' ></div>
                                        <div class=" col col-sm-2"  ><input type="text" placeholder="XX" maxlength="2" name="spharcode" id="stelacrt" class="form-control required numbers-only " required="requried" readonly="readonly" onchange="scpry();"></div>
                                        <div class="col col-sm-4" ><input type="text" placeholder="XXXXXXX" maxlength="7" name="sph" id="stelncrt" class="form-control required numbers-only " required="required" readonly="readonly" onblur="scpppy();" ></div>
                                    </div>
                                    <div class="row sphca">
                                        <div class=" col col-sm-4" ></div>
                                        <div class=" col col-sm-4" style=" color:red; " id='sphno_note1crt'></div>
                                        <div class="col col-sm-4" style="color:red; " id='sphno_note2crt'></div>
                                    </div>
                                    <input id="saddress_1" type="text" placeholder="<?php echo translate('address_line_1'); ?>" name="saddress1" class="form-control address required sadd">
                                    <input id="saddress_2"  type="text" placeholder="<?php echo translate('address_line_2'); ?>" name="saddress2" class="form-control address required sadd">
                                        <div class="row" style="margin-bottom:10px">
<div class="col-sm-6 ssdrp" hidden>
<input id="s_countryname" type="text" name="s_countryname" class="form-control address required"  readonly />
</div>
<div class="col-sm-6 ssdrp" hidden>
<input id="s_statename" type="text" name="s_statename" class="form-control address required"  readonly />                                        
</div>
                                            <div class="col-sm-6 hsdrp">
                                               <select id="country1" name="scountry" class="form-control required sadd" onChange="loadState(this)">
                                                   <option value="">Select Country..</option><?php
                                                    $cntry=$this->db->get_where('fed_country',array('status'=>'1'))->result_array();
                                                    foreach($cntry as $cntry_details){
                                                        echo "<option value='".$cntry_details[country_id]."'>".$cntry_details[name]."</option>";
                                                    } ?>
                                               </select>
                                               <input type="hidden" value="" required name="country_code" id="country_code">
                                            </div>
                                            <div class="col-sm-6 hsdrp">
                                                <select id="states" name="sstate" class="form-control address required sadd" onChange="">
                                                   <option value=""><?php echo translate('State/Province'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                       <div class="row">
                                            <div class="col-sm-6">
                                                <input id="scity" type="text" placeholder="<?php echo translate('city'); ?>" name="scity" class="form-control address required sadd">
                                            </div>
                                            <div class="col-sm-6">
                                                <input id="szip" type="text" placeholder="<?php echo translate('zip/postal_code'); ?>" name="szip" class="form-control address required sadd">
                                            </div>
                                        </div>
                                        <div class="row" id="lnlat" style="display:none;" >
                                            <div class="col-sm-12">
                                                <input id="langlat" type="text" placeholder="langitude - latitude" name="langlat" class="form-control required" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div><?php
                            } ?>
                            </div> 
                        </section>
                        <div class="header-tags">
                            <div class="overflow-h"><?php // $cContent = $this->cart->contents(); echo '<pre>'; print_r($cContent); echo '</pre>'; ?>
                                <h2><?php echo translate('shipping_method'); ?></h2>
                                <p><?php echo translate('shipping_method_info'); ?></p>
                                <i class="rounded-x fa fa-truck"></i>
                            </div>    
                        </div>
                        <section class="shipping-info">
                            <div class="row">
                                <div class="col-md-6 md-margin-bottom-40">
                                    <h2 class="title-type"><?php echo translate('select_shipping_method');?></h2><?php
                                    if($allDigital == false){ ?>
                                    <div class="billing-info-inputs checkbox-list ship-options">
                                        <div class="row">
                                            <input id="fed_radio" value="fedex_shiping" type="radio" name="ship_method" class="fed_in" required><label for="fed_shiping" class="ship-label" id="fed_m">Fedex Shipping</label>
                                            <input type="hidden" name="selected-fed-type" id="selected-fed-type" value="" class="required" />
                                        </div>
                                <!--        <div class="row">
                                            <input id="pic_radio" value="pickup" type="radio" name="ship_method" class="fed_in" required><span id="fed_m">Pickup from store</span>
                                        </div> -->
                                        <div class="row rowp" hidden="hidden">
                                            <div class="col-sm-6">
                                                 <span class="  col-sm-6" ><b> Pickup Day </b></span>
                                        <?php  /*         <input type="text" class="fed_in  required  form-control col-sm-6 " name="pickup_date" id="pickup_date" value="<?php echo date('Y-m-d'); ?>" > */?>
                                            </div>
                                            <div class="col-sm-6">
                                                <span class="  col-sm-6 "> <b> Pickup Time </b></span>
                                        <?php  /*        <input type="text" class="fed_in required  form-control col-sm-6" name="pickup_time" id="pickup_time" >  */?>
                                            </div>
                                         </div>
                                        <div class="row">
                                        <input id="other_shiping" value="other_shiping" type="radio" name="ship_method" class="fed_in" required data-target="#shippinginfo" data-toggle="modal" >
                                            <label for="other_shiping" class="ship-label" id="other_m">Other Shipping</label>
                                        </div>
                                    </div><?php
                                    }else{ echo '<div class="billing-info-inputs checkbox-list"><div class="row">'.translate('shipping_not_required').'</div></div>'; } ?>
                                </div>
                                <div class="col-md-6 md-margin-bottom-40">
        <button type="button" style="float:right;" class="btn btn-info fa fa-question-circle" data-toggle="modal" id="shiphlep" data-target="#shippinginfo"> Help</button>                         
                                  <h2 style="visibility: hidden;" class="title-type"><?php echo translate('select_shipping_method');?></h2> 
                                    <div class="billing-info-inputs checkbox-list" id="fedex_row" style="display:none;">
                                        <div class="row">
                                            <div class="col-sm-9">
                                               <input id="fed_adrs1" type="hidden" name="fedex_adrs1" class="form-control address required">
                                            </div>
                                        </div>
                                        <div class="row">
                                           <!-- <div class="col-sm-3">
                                               Address Line 2
                                            </div>-->
                                            <div class="col-sm-9">
                                              <!--<span id="fed_adrs21"></span>-->
                                               <input id="fed_adrs2" type="hidden" name="fedex_adrs2" class="form-control address required">
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-9">
                                               <input id="fed_country" type="hidden" name="fedex_country" class="form-control address required">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-9">
                                               <input id="fed_state" type="hidden" name="fedex_state" class="form-control address required">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-9">
                                               <input id="fed_city" type="hidden" name="fedex_city" class="form-control address required">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-9">
                                               <input id="fed_zip" type="hidden" name="fedex_zip" class="form-control address required">
                                            </div>
                                        </div> 
                                        <div id="loading-image" style="display:none">Loading...</div>
                                        <div id="target">ss</div>  
                                    </div>
                                <!--Pickup Details Starts-->
                                    <div class="billing-info-inputs checkbox-list" id="pic_row" style="display:none;"><?php
                                        function getCountry($contry_id){

                                           $cntry=$this->db->get_where('fed_country',array('country_id'=>$contry_id))->result_array();
                                            foreach($cntry as $cntry_name)
                                            {
                                                $cname=$cntry_name['name'];
                                            }
                                            return $cname;
                                        }
                                        foreach ($carted as $items_ship){ 
                                            $item_name  =$items_ship['name']; $item_id    =$items_ship['id'];
                                            $prdts=$this->db->get_where('product',array('product_id'=>$item_id))->result_array();
                                            foreach($prdts as $prdts_details){
                                                $vendors_array= $prdts_details['added_by'];
                                                $vendors= json_decode($vendors_array,true);
                                                $v_type = $vendors['type'];
                                                $v_id   = $vendors['id'];
                                                if($v_type=='vendor'){
                                                    $vndr=$this->db->get_where('vendor',array('vendor_id'=>$v_id))->result_array();
                                                    foreach($vndr as $vndr_details){
                                                        $vndr_name      = $vndr_details['company'];
                                                        $vndr_adrs1     = $vndr_details['address1'];
                                                        $vndr_adrs2     = $vndr_details['address2'];
                                                        $vndr_contry_code    = $vndr_details['country_code'];
                                                        $cntry=$this->db->get_where('fed_country',array('iso_code_2'=>$vndr_contry_code))->result_array();
                                                        foreach($cntry as $cntry_name){
                                                            $cname=$cntry_name['name'];
                                                        }
                                                        $vndr_state_id     = $vndr_details['zone_id'];
                                                        $zone=$this->db->get_where('fed_zone',array('zone_id'=>$vndr_state_id))->result_array();
                                                        foreach($zone as $zone_name){
                                                            $vndr_state=$zone_name['name'];
                                                        }
                                                        $vndr_city      = $vndr_details['city']; 
                                                        $vndr_zip       = $vndr_details['zip_code'];
                                                        $lat=''; $long=''; $latlong='';
                                                        $latlong        = $vndr_details['lat_lang'];
                                                        $latlong = substr($latlong, 1, -1);
                                                        $latlong = (explode(",",$latlong));
                                                        $lat    = $latlong[0];
                                                        $long   = $latlong[1];
                                                    }?>
                                                    <div class="row">
                                                        <div class="col-sm-12"><b>Pickup Address for <?php echo $item_name; ?></b></div>
                                                         <div class="col-sm-12"><?php echo $vndr_name; ?></div>
                                                         <div class="col-sm-12"><?php //echo $vndr_adrs1; ?></div>
                                                         <div class="col-sm-12"><?php //echo $vndr_adrs2; ?></div>
                                                         <div class="col-sm-12"><?php echo $vndr_city; ?></div>
                                                         <div class="col-sm-12"><?php //echo $vndr_state; ?></div>
                                                         <div class="col-sm-12"><?php echo $cname; ?></div>
                                                         <div class="col-sm-12"><?php //echo $vndr_zip; ?></div>
                                                         <?php /*if($lat) { ?>
                                                         <div class="col-sm-12">GPS Coordinates:- Latitude: <?php echo substr($lat, 0, ((strpos($lat, '.')+1)+6));  ?> | Longitude:
                                                         <?php echo substr($long, 0, ((strpos($long, '.')+1)+6)); ?>
                                                         </div> <?php }*/ ?>
                                                    </div><?php
                                                } else if($v_type=='admin'){
                                                    $vndr=$this->db->get_where('admin_store_details',array('status'=>1))->result_array();
                                                    foreach($vndr as $admn_details){
                                                        $admn_name      = $admn_details['store_name'];
                                                        $admn_adrs1     = $admn_details['store_adrs1'];
                                                        $admn_adrs2     = $admn_details['store_adrs2'];
                                                        $admn_contry_code    = $admn_details['country_code'];
                                                        $cntry=$this->db->get_where('fed_country',array('country_id'=>$admn_contry_code))->result_array();
                                                        foreach($cntry as $cntry_name){ $cname=$cntry_name['name'];}
                                                        $admn_state_id     = $admn_details['zone_id'];
                                                        $zone=$this->db->get_where('fed_zone',array('zone_id'=>$admn_state_id))->result_array();
                                                        foreach($zone as $zone_name){ $admn_state=$zone_name['name']; }
                                                        $admn_city      = $admn_details['city'];
                                                        $admn_zip       = $admn_details['zip_code'];
                                                        $lat=''; $long=''; $latlong='';
                                                        $latlong = $admn_details['lat_lang'];
                                                        $latlong = substr($latlong, 1, -1);
                                                        $latlong = (explode(",",$latlong));
                                                        $lat    = $latlong[0];
                                                        $long   = $latlong[1];
                                                    }?>
                                                    <div class="row">
                                                        <div class="col-sm-12"><b>Pickup Address for <?php echo $item_name; ?></b></div>
                                                        <div class="col-sm-12"><?php echo $admn_name; ?></div>
                                                        <div class="col-sm-12"><?php echo $admn_adrs1; ?></div>
                                                        <div class="col-sm-12"> <?php echo $admn_adrs2; ?></div>
                                                        <div class="col-sm-12"><?php echo $admn_city; ?></div>
                                                        <div class="col-sm-12"><?php echo $admn_state; ?></div>
                                                        <div class="col-sm-12"><?php echo $cname; ?></div>
                                                        <div class="col-sm-12"><?php echo $admn_zip; ?></div>
                                                        <?php if($lat) { ?>
                                                        <div class="col-sm-12">GPS Coordinates:- Latitude: <?php echo substr($lat, 0, ((strpos($lat, '.')+1)+6));  ?> | Longitude:
                                                         <?php echo substr($long, 0, ((strpos($long, '.')+1)+6)); ?>
                                                        </div> <?php } ?>

                                                    </div><?php
                                                }
                                            }
                                        }?>
                                    </div><!--Pickup Details Ends-->
                                    <!-- Other shipments -->
                                    <div class="billing-info-inputs checkbox-list" id="oth_ship_row" style="display: none;">
                                        <div class="row">
                                            <input id="own_freight_agent" value="own_freight_agent" name="freight_agent" class="fed_in" required="" type="radio">
                                            <label for="own_freight_agent">Own Freight agent</label>
                                            <div id="own_freight_details" class="billing-info-inputs checkbox-list" style="display: none;">
                                                <label for="freight_address"><strong>Enter freight agent's detail</strong></label>
                                                <textarea class="form-control required" name="freight_address" id="freight_address" placeholder="Agent Name\nContact Phone Number\n"></textarea>
                                            </div>
                                        </div>
                                        <div class="clr"></div>
                                        <div class="row">
                                            <input id="local_freight_agent" value="local_freight_agent" name="freight_agent" class="fed_in" required="" type="radio">
                                            <label for="local_freight_agent">Check for local freight agents</label>
                                            <div id="local_freight_details" class="billing-info-inputs checkbox-list" style="display: none;">
                                                <div class="local-freight-content">
                                                    Marine cart will revert back with different freight options
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Other Shipment ends -->
                                </div>
                            </div> 
                        </section>
                        <script>

function FillBilling(f) 
{
    clearShip();
    if(f.billingtoo.checked == true) 
    {
        f.sfirstname.value  = f.firstname.value;
        f.semail.value      = f.email.value;
        f.slastname.value   = f.lastname.value;
        f.sphone.value      = f.phone.value;
        f.saddress1.value   = f.address1.value;
        f.saddress2.value   = f.address2.value;
        f.scountry.value    = f.bill_country1.value;
        loadState();
    /*window.action = loadState;
    window.action = null;*/
    //window.action2 = action2Func;
        
        //console.log(f.bill_state.value);
        window.stat     = f.bill_state.value;
        f.scity.value   = f.city.value;
        f.szip.value    = f.zip.value;
        $("#s_statename").val($("#b_statename ").val());
        $("#s_countryname").val($("#country1 option:selected").text());
        $('.hsdrp').hide();
        $('.ssdrp').show();
        $('.sadd').attr("readonly", true); 

         /* document.getElementById('add_address').style.display = "hidden";*/
        $('#adrs_span').show();
        $("#add_address").prop('checked', false);
        $("input[name=adrs_book]:radio").prop('checked', false);
        $('.sphca').hide();
        $('#sphone').show();

    }
    if(f.billingtoo.checked == false) 
    {
        $('.sadd').attr("readonly", false);
        $('.hsdrp').show();
        $('.ssdrp').hide();
        $("#s_statename").val('');
        $("#s_countryname").val('');  
        f.sfirstname.value  = "";
        f.semail.value      = "";
        f.slastname.value   = "";
        f.sphone.value      = "";
        f.saddress1.value   = "";
        f.saddress2.value   = "";
        f.scity.value       = "";
        f.szip.value        = "";
        f.scountry.value    = "";
        loadState();
              //$('#adrs_span').show();
            
            $("#add_address").prop('checked', false);
            $('.sphca').show();
            $("#scountry_code").val("");
            $("#sd_co").val( "");
            $("#stelacrt").val("");
            $("#stelncrt").val("");
            $("#sphone").val("");
            $('#sphone').hide();
    }
}

                            $("input[name=adrs_book]:radio").change(function () {
                                $('#adrs_span').hide();
                                var fname_id="fname_"+this.id;
                                var fname=document.getElementById(fname_id).innerHTML;
                                var lname_id="lname_"+this.id;
                                var lname=document.getElementById(lname_id).innerHTML;
                                var adrs1_id="adrs1_"+this.id;
                                var adrs1=document.getElementById(adrs1_id).innerHTML;
                                var adrs2_id="adrs2_"+this.id;
                                var adrs2=document.getElementById(adrs2_id).innerHTML;
                                var country_id="country_"+this.id;
                                var country=document.getElementById(country_id).innerHTML;
                                var state_id="state_"+this.id;
                                var state=document.getElementById(state_id).innerHTML;
                                window.globalState = state;

                                var city_id="city_"+this.id;
                                var city=document.getElementById(city_id).innerHTML;
                                var zip_id="zip_"+this.id;
                                var zip=document.getElementById(zip_id).innerHTML;
                                var phone_id="phone_"+this.id;
                                var phone=document.getElementById(phone_id).innerHTML;
                                var email_id="email_"+this.id;
                                var email=document.getElementById(email_id).innerHTML;
                                //alert(state);
                                $("#country1").val(country);
                                loadState();
                                $("input[name=billingtoo]:checkbox").prop('checked', false);
                                 $("#sname").val(fname);
                                 $("#ssurname").val(lname);
                                 $("#semail").val(email);
                                 $("#sphone").val(phone);
                                 $("#saddress_1").val(adrs1);
                                 $("#saddress_2").val(adrs2);
                                 $("#scity").val(city);
                                 $("#szip").val(zip);
                                 //alert($("#states").html());
                                 $("#states").val(state);
                                clearShip();


                            });

                        $('#myaddress').on('hidden.bs.modal', function (){
                            state=globalState.replace(/\s/g, '');
                            //console.log(state);
                            $("#states").val(state);
                            clearShip();
                            //$("#states option:selected").val('KE');
                        });

                        $("#states").change(function () {
                           clearShip();
                        });
                        $("#szip").change(function () {
                           clearShip();
                        });
                        $("#fed_radio").change(function () {
                            $("#selected-fed-type").val('');
                            $('#fedex_row').show();  $('#oth_ship_row').hide();
                            $('#payfort').show(); $('#cash_on_delivery').show(); $('#manual').hide(); 
                            $('#pic_row').hide();
                            $('.rowp').hide();
                            $('#pickup_date').val("");
                            $('#pickup_time').val("");  
                            $('#mastercard').removeAttr('checked'); $('#manual_invoice').removeAttr('checked'); $('#visa').attr('checked', 'checked');
                            $('#cash_on_delivery').hide();
                            var adrs1   =$("#saddress_1").val();
                            var adrs2   =$("#saddress_2").val();
                            var country =$("#country1").val();
                            var country_code =$("#country_code").val();
                            var state   =$("#states").val();
                            var city    =$("#scity").val();
                            var zip     =$("#szip").val();
                            var cname   =$("#country1 option[value='"+country+"']").text();
                            var sname   =$("#states option[value='"+state+"']").text();
                            $("#fed_adrs1").val(adrs1);
                            $("#fed_adrs11").text(adrs1);
                            $("#fed_adrs2").val(adrs2);
                            $("#fed_adrs21").text(adrs2);
                            $("#fed_country").val(country_code);
                            $("#fed_country1").text(cname);
                            $("#fed_state").val(state);
                            $("#fed_state1").text(sname);
                            $("#fed_city").val(city);
                            $("#fed_city1").text(city);
                            $("#fed_zip").val(zip);
                            $("#fed_zip1").text(zip);
                            $('#target').html("");
                            var uradrs1=encodeURIComponent(adrs1);
                            var urcity=encodeURIComponent(city);
                            $.ajax({
                            //type: "POST",
                            url: "<?php echo base_url(); ?>index.php/home/cartCheck/"+uradrs1+"/"+urcity+"/"+country_code+"/"+state+"/"+zip+"/", 
                            dataType:"html",
                            cache       : false,
                            contentType : false,
                            beforeSend: function() {
                                $("#loading-image").show();
                            },
                            //processData : false,//return type expected as json
                            success: function(datas){
                                $("#loading-image").hide();
                                //console.log(datas);
                                var cntrls=$('<span>'+datas+'</span>');
                                textBox=$('<input type="hidden" name="fed_method" id="fed_method"><input type="hidden" name="fed_rate" id="fed_rate">');
                                textBox.appendTo('#target');
                                //$('#target').html=datas;
                                cntrls.appendTo('#target');
                            /*    $.each (datas, function (bb) {
                                    var method  = (datas[bb].method);
                                    var price   = (datas[bb].price);
                                    console.log(datas[bb]);
                                    var radioBtn = $('<p><input onChange="checkState(this.value,this.id)" class="fed_in" id="'+method+'" required type="radio" value="'+price+'" name="fedex_ship_method" /><span id="fed_m">' +method+'('+price+')</span></p>');
                                    radioBtn.appendTo('#target');
                                });*/


                                },
                            });

                        });
                        $("#pic_radio").change(function () {
                            $("#selected-fed-type").val(1);
                            $('#fedex_row').hide(); $('#oth_ship_row').hide();
                            $('#payfort').show(); $('#cash_on_delivery').show(); $('#manual').hide();
                           // $('.rowp').show();
                            $('#cash_on_delivery').show();
                            clearShip();

                        });
                            $("#steps-uid-0-t-0").click(function () {
                                clearShip();
                            });
                        function checkState(val,method,name)  
                        {
                            var shipcounty=$("#country1").val();
                            $("#fed_method").val(method);
                            $("#selected-fed-type").val(1);
                            //$("#fed_rate").val(val);
                            //$('#shipping').html(val);
                            //console.log(name);
                            $.ajax({
                            //type: "POST",
                            url: "<?php echo base_url(); ?>index.php/home/ship_cost/"+val+"/"+method+"/"+name+"/"+shipcounty+"/",
                            dataType:"html",
                            cache       : false,
                            contentType : false,

                            //processData : false,//return type expected as json
                            success: function(data){
                                region_tax();
                                update_prices();
                                update_calc_cart();
                                //console.log(data);
                                $('#shipping').html(data);

                                },
                            });
                        }

                        function region_tax(val,method,name)  
                        {
                            var shipcount_code=$("#country1").val();
                             $.ajax({
                             url: "<?php echo base_url(); ?>index.php/home/region_tax/"+shipcount_code+"/", 
                            dataType:"html",
                            cache   : false,
                            contentType : false,
                            success: function(data)
                            {
                            //alert(data);
                            },
                            });
                        }


                            function clearShip()
                            {
                                $('#fedex_row').hide();
                                //$('#oth_ship_row').hide();
                                $("input[id=fed_radio]:radio").prop('checked', false);
                                //$("input[id=other_shiping]:radio").prop('checked', false);
                                $("input[id=local_freight_agent]:radio").prop('checked', false);
                                $("input[id=own_freight_agent]:radio").prop('checked', false);
                                $.ajax({
                                //type: "POST",
                                url: "<?php echo base_url(); ?>index.php/home/clear_ship_cost/", 
                                dataType:"html",
                                cache       : false,
                                contentType : false,

                                //processData : false,//return type expected as json
                                success: function(){
                                    region_tax();
                                    update_prices();
                                    update_calc_cart();
                                    },
                                });
                            }



                        </script>
                    
                    
                    
                    <div class="header-tags">
                        <div class="overflow-h">
                            <h2><?php echo translate('payment');?></h2>
                            <p><?php echo translate('select_payment_method');?></p>
                            <i class="rounded-x fa fa-credit-card"></i>
                        </div>    
                    </div>
                    <section>
                        <div class="row">
                            <div class="col-md-6 md-margin-bottom-50">
                                <h2 class="title-type"><?php echo translate('choose_a_payment_method');?></h2>
                                <div class="cc-selector">
                                    <?php
                                    $f_set="ok";
                                        $p_set = $this->db->get_where('business_settings',array('type'=>'paypal_set'))->row()->value;
                                        $c_set = $this->db->get_where('business_settings',array('type'=>'cash_set'))->row()->value;
                                        $s_set = $this->db->get_where('business_settings',array('type'=>'stripe_set'))->row()->value;
                                       /* $f_set = $this->db->get_where('business_settings',array('type'=>'payfort_set'))->row()->value;*/
                                        if($p_set == 'ok'){
                                    ?>
                                  <div id="paypal" class="col-sm-4">    <input id="visa" type="radio" name="payment_type" value="paypal" />
                                      <label class="drinkcard-cc visa" for="visa"></label></div>
                                    <?php
                                    } 
                                    if($f_set == 'ok'){
                                    ?>
                                    <div id="payfort" class="col-sm-4">    <input id="visa" type="radio" name="payment_type" value="payfort" />
                                      <label class="drinkcard-cc visa" for="visa"></label></div>
                                    <?php
                                    }
                                    if($s_set == 'ok'){
                                    ?>
                                <div id="stripe" class="col-sm-4">        <input id="mastercardd" type="radio" name="payment_type" value="stripe" />
                                    <label class="drinkcard-cc stripe" id="customButton" for="mastercardd"></label></div>
                                    <script src="https://checkout.stripe.com/checkout.js"></script>
                                    <script>
                                      var handler = StripeCheckout.configure({
                                        key: '<?php echo $this->db->get_where('business_settings' , array('type' => 'stripe_publishable'))->row()->value; ?>',
                                        image: '<?php echo base_url(); ?>template/front/assets/img/stripe.png',
                                        token: function(token) {
                                          // Use the token to create the charge with a server-side script.
                                          // You can access the token ID with `token.id`
                                          
                                          $('#cart_form').append("<input type='hidden' name='stripeToken' value='" + token.id + "' />");
                                          if($( "#visa" ).length){
                                            $( "#visa" ).prop( "checked", false );
                                          }
                                          if($( "#mastercard" ).length){
                                            $( "#mastercard" ).prop( "checked", false );
                                          }
                                          $( "#mastercardd" ).prop( "checked", true );
                                          notify('<?php echo translate('your_card_details_verified!'); ?>','success','bottom','right');
                                          setTimeout(function(){ $('#cart_form').submit(); }, 500); 
                                        }
                                      });

                                      $('#customButton').on('click', function(e) {
                                        // Open Checkout with further options
                                        var total = $('#grand').html();
                                        total = total.replace("<?php echo currency(); ?>", '');
                                        total = parseFloat(total.replace(",", ''));
                                        total = total/parseFloat(<?php echo $this->crud_model->get_type_name_by_id('business_settings', '8', 'value'); ?>);
                                        total = total*100;
                                        handler.open({
                                          name: '<?php echo $system_title; ?>',
                                          description: '<?php echo translate('pay_with_stripe'); ?>',
                                          amount: total
                                        });
                                        e.preventDefault();
                                      });

                                      // Close Checkout on page navigation
                                      $(window).on('popstate', function() {
                                        handler.close();
                                      });
                                    </script>
                                    <?php
                                    } if($c_set == 'ok'){?>
                                    
                                        <div id="cash_on_delivery" class="col-sm-4">   
                                            <input id="mastercard" type="radio" name="payment_type" value="cash_on_delivery" checked />
                                         <label class="drinkcard-cc mastercard"for="mastercard"></label>
                                         </div><?php
                                        } ?>
                                        <div id="manual" class="col-sm-4">   
                                            <input id="manual_invoice" type="radio" name="payment_type" value="manual_invoice" checked="checked" />
                                            <label class="drinkcard-cc manual_invoice" for="manual_invoice"></label>
                                         </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>

                    </section>
                    <div class="coupon-code">
                        <div class="row">
                            <div class="col-sm-8 sm-margin-bottom-30 col-md-4">
<?php $cput =  $this->db->get_where('ui_settings',array('type' => 'coupon_set'))->row()->value;
 if ($cput ==1) {
     ?>                     <div id='couptext'>
                                <h3>Discount Code</h3>
                                <span id="coupon_report">
                                    <?php if($this->cart->total_discount() <= 0 && $this->session->userdata('couponer') !== 'done' && $this->cart->get_coupon() == 0){ ?>
                                        <p>Enter your coupon code</p>
                                        <input class="form-control margin-bottom-10 coupon_code" type="text">
                                        <button type="button" class="btn-u btn-u-sea-shop coupon_btn"><?php echo translate('apply_coupon'); ?></button>
                                    <?php } else { ?>
                                        <h3><?php echo translate('coupon_already_activated'); ?></h3>  
                                    <?php } ?>
                                </span>
                            </div>
<?php
 }
?>                            
                            </div>
                            <script type="text/javascript">
                                $('.coupon_btn').on('click',function(){
                                    var txt = $(this).html();
                                    var code = $('.coupon_code').val();
                                    $('#coup_frm').val(code);
                                    var form = $('#coupon_set');
                                    var formdata = false;
                                    if (window.FormData){
                                        formdata = new FormData(form[0]);
                                    }
                                    var datas = formdata ? formdata : form.serialize();
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>index.php/home/coupon_check/',
                                        type        : 'POST', // form submit method get/post
                                        dataType    : 'html', // request type html/json/xml
                                        data        : datas, // serialize form data 
                                        cache       : false,
                                        contentType : false,
                                        processData : false,
                                        beforeSend: function() {
                                            $(this).html("<?php echo translate('applying..'); ?>");
                                        },
                                        success: function(result){
                                            //console.log(result);
                                            if(result == 'nope'){
                                                notify("<?php echo translate('coupon_not_valid'); ?>",'warning','bottom','right');
                                            } else {
                                                var re = result.split(':-:-:');
                                                var ty = re[0];
                                                var ts = re[1];
                                                
                                                $("#coupon_report").fadeOut();
                                                notify("<?php echo translate('coupon_discount_successful'); ?>",'success','bottom','right');
                                                if(ty == 'total'){
                                                    $(".coupon_disp").show();
                                                    $("#disco").html(re[2]);
                                                }
                                                $(".coupon_disp").show();
                                                $("#disco").html(re[2]);
                                                $("#coupon_report").html('<h3>'+ts+'</h3>');
                                                $("#coupon_report").fadeIn();
                                                update_calc_cart();
                                                update_prices();
                                            }
                                        }
                                    });
                                });
         

                                
                                
                                
                            </script>
                            <div class="col-sm-8 col-sm-offset-4 col-md-4" style="padding-right: 0;">
                                <div class="table-responsive cart_list">
                                    <table class="table" style="border: 1px solid #ddd;">
                                        <tr><td><?php echo translate('subtotal');?></td><td><span class="text-right" id="total"></span></td></tr>
                                        <tr><td><?php echo translate('tax');?></td><td><span class="text-right" id="tax"></span></td></tr>
                                        <tr><td><?php echo translate('shipping');?></td><td><span class="text-right" id="shipping"></span></td>
                                        </tr>
                                        <tr><td><?php echo translate('shipping_Vat');?></td><td><span class="text-right" id="rvat"></span></td>
                                        </tr>
                                        <tr <?php if($this->cart->total_discount() <= 0){ ?>style="display:none;"<?php } ?> class="coupon_disp">
                                            <td><?php echo translate('coupon_discount');?></td><td><span class="text-right" id="disco"><?php echo currency().$this->cart->total_discount(); ?></span></td>
                                        </tr>
                                        <tr><td><?php echo translate('total');?></td><td class="total-result-in"><span class="grand_total" id="grand"></span></td></tr>
                                    </table>
                                </div>
                                <div></div>
                            </div>
                        </div>
                    </div> <?php
                    /*if($userid<=0) { ?>
                        <div class="guest"><input type="checkbox" class="guest_chk">Guest Check out</div><br/><br/>
                    <?php } */ ?>
                    <script type="text/javascript">
                        $('.guest_chk').on('click',function(){
                            var txt = $(this).html();

                            if($(this).prop("checked") == true){

                                code=1;
                                $('.phca').show();
                                $('#phone').hide();
                                $('#adrs_span').hide();
                                $('#myaddressadd').hide();
                            }
                            else if($(this).prop("checked") == false){
                                $('.phca').hide();
                                $('#phone').show();
                                code=0;
                            }


                            $('#grp_frm').val(code);

                            var form = $('#guest_set');
                            var formdata = false;
                            if (window.FormData){
                                formdata = new FormData(form[0]);
                            }
                            var datas = formdata ? formdata : form.serialize();
                            $.ajax({
                                url: '<?php echo base_url(); ?>index.php/home/guest_check/',
                                type        : 'POST', // form submit method get/post
                                dataType    : 'html', // request type html/json/xml
                                data        : datas, // serialize form data 
                                cache       : false,
                                contentType : false,
                                processData : false,
                                beforeSend: function() {
                                    $(this).html("<?php echo translate('applying..'); ?>");
                                },
                                success: function(result){
                                    //console.log(result);
                                    if(result == 'success'){
                                        //console.log(result);
                                        notify("<?php echo translate('Guest_Checkout_Activated'); ?>",'success','bottom','right');
                                    }
                                     else if(result == 'lgn'){
                                        //console.log(result);
                                        notify("<?php echo translate('Guest_Checkout_Deactivated'); ?>",'success','bottom','right');
                                    } 
                                }
                            });
                        });
                    </script>

<!-- terms and condition check box  -->

        <div class="row"  id="term3" hidden >
        <div style="float:right;" class="radio col-md-4">
        <label style="color: #007aff; " >
        <input type="checkbox" data-toggle="tooltip" title="Check this!"  name="agree" value="check" id="agree"  class="" /> I have read and agree to the <a style="background: none !important;outline: none !important;text-decoration: none;color: #e54f50;" target="_blank" href='<?php echo base_url()."home/legal/terms_conditions";?>' >Terms and Conditions</a>.
        <br/>Many merchandise in Marine Cart are controlled items. Marine Cart reserves the right to do the required verification prior to acceptance of the order and shipment of materials. </label>
        </div>
        </div>

<!-- End terms and condition check box -->


            </div><?php
            echo form_close()?>
        </div><!--/end container-->
    </div>
    <input type="hidden" id="first" value="yes" />
    <!--=== End Content Medium Part ===-->  
    <!--Address MOdal-->
    <!-- Modal -->
    <div class="modal fade" id="myaddress" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="float: left;width: 100%;">
                <div class="modal-header">
                     <button type="button" class="close1" data-dismiss="modal">&times;</button>
                     <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body body_div"><?php
                    $adrs_dtls=$this->db->get_where('user_address',array('user_id'=>"$userid"))->result_array();
                    if (!empty($adrs_dtls)){
                        foreach($adrs_dtls as $adrs_details){ ?>
                            <div class="address_box col-sm-6">
                                <div  class="addrs" >
                                    <div><b><?php echo "<span id='fname_".$adrs_details['adrs_id']."'>".$adrs_details['fname']. "</span> <span id='lname_".$adrs_details['adrs_id']."'>" .$adrs_details['lname']."</span>"; ?> </b></div>
                                    <div id="adrs1_<?php echo $adrs_details['adrs_id']; ?>"><?php echo $adrs_details['address1'];?></div>
                                    <div id="adrs2_<?php echo $adrs_details['adrs_id']; ?>"><?php echo $adrs_details['address2'];?></div>
                                    <div id="country_<?php echo $adrs_details['adrs_id']; ?>"><?php echo $adrs_details['country_code'];?></div>
                                    <div id="state_<?php echo $adrs_details['adrs_id']; ?>"><?php echo $adrs_details['state_code'];?> </div>
                                    <div id="city_<?php echo $adrs_details['adrs_id']; ?>"><?php echo $adrs_details['city'];?></div>
                                    <div id="zip_<?php echo $adrs_details['adrs_id']; ?>"><?php echo $adrs_details['zip'];?></div>
                                    <div id="phone_<?php echo $adrs_details['adrs_id']; ?>"><?php echo $adrs_details['phone'];?></div>
                                    <div id="email_<?php echo $adrs_details['adrs_id']; ?>"><?php echo $adrs_details['email'];?></div>
                                    <div>
                                        <input id="<?php echo $adrs_details['adrs_id']; ?>" type="radio" name="adrs_book" onclick="">
                                        <span style="color: red">Set as Shipping Address</span>
                                    </div>
                                </div>
                            </div><?php 
                        }
                    }else{?>
                        <div class="address_box col-sm-6">
                                                <div  class="addrs" >
                        No Address found on your address book..
                        </div>
                        </div><?php 
                    } ?>
                </div>
            </div>
     </div> 
</div> <!-- Modal -->
    <!--Address MOdal-->

<!--Shipping info Modal-->
    <div class="modal fade" id="shippinginfo" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="">
                <div class="modal-header" style="padding: 6px 10px 0;">
                    <span style="float: left;color: white;font-size: medium;">Shipping Method Informations</span>
                    <a type="button"  href="" style="float:right" data-dismiss="modal"><i class="fa fa-times-circle" style="font-size: large;" aria-hidden="true"></i></a>
                </div>
                <div class="modal-body body_div" style="padding: 15px 35px;">
                <?php 
                echo $this->db->get_where('business_settings', array('type' => 'shipment_info'))->row()->value."<br/>"; 
                echo $this->db->get_where('business_settings', array('type' => 'shipment_method'))->row()->value; 
                ?>
                </div>
            </div>
        </div>
    </div>
<!-- End Shipping info Modal-->

<script>
    jQuery(document).ready(function() {
        App.init();
        StepWizard.initStepWizard();
        $('#freight_address').placeholder();
    });

    $(document).ready(function() {
        //update_calc_cart();
        clearShip();
        /*update_prices();
        update_calc_cart();*/

        $('#pickup_date').datepicker({
        lang:'en',
        format:'yyyy-m-d',
        startDate:  '2017/01/05',
        });
        $('#pickup_time').timepicker();
        $('.quantity-button').on('click', function(){
            $('#fed_radio').prop('checked',false);
            $('#fedex_row').hide();
        });
        $('.steps .first').click(function(){
            $('#fed_radio').prop('checked',false);
            $('#fedex_row').hide();
        });
        $('#other_shiping').on('click', function(){
            $("#selected-fed-type").val(1);
            $('#pic_row').hide(); $('#fedex_row').hide();
            $('#payfort').show(); $('#cash_on_delivery').show(); $('#manual').hide();
            $('#visa').attr('checked', 'checked');
      //$('#mastercard').removeAttr('checked'); $('#visa').removeAttr('checked'); $('#manual_invoice').attr('checked', 'checked');
            $('#oth_ship_row').show();
            var shipAddress =   $('#shippingAddress').html();
            clearShip();
        });
        $('#own_freight_agent').on('click', function()
        {
          //  $('#own_freight_details .ph-format').html('');
          $('#local_freight_details').hide('slow');
          $('#own_freight_details').show('slow');
          region_tax();
          update_prices();
          update_calc_cart();
        })
        $('#local_freight_agent').on('click', function()
        {
            $('#own_freight_details').hide('slow');
            $('#local_freight_details').show('slow');
            region_tax();
            update_prices();
            update_calc_cart();

        })
    });

    
    function FillBilling(f) {
  if(f.billingtoo.checked == true) {
    f.billingname.value = f.shippingname.value;
    f.billingcity.value = f.shippingcity.value;
      
  }
}
    function checkCountry()
    {
        var x = document.getElementById("country1").value;
        var country_id=x;
        $.ajax({
        //type: "POST",
        url: "<?php echo base_url(); ?>index.php/home/check_resriction/"+country_id+"/", 
        data:country_id,
        dataType:"html",
        cache       : false,
        contentType : false,
        //processData : false,//return type expected as json
        success: function(states){
             if(states == 'nop'){
                 var flg=1;
                 $('#country_res').show();
                 $('#country_res').val("");
                 //$('#states').prop('disabled', 'disabled');
                 //$('#states').empty().append('whatever');
                 //$('#states option').remove();
            /*  $('#states')
                .find('option')
                .remove()
                .end()
                .append('<option value="">State/Province</option>')
               
            ;*/
                 notify("<?php echo translate('cannot_ship_carted_products_to_selected_country'); ?>",'warning','bottom','right');
                }
            else
                {
                    $('#country_res').hide();
                }
            
           //console.log(states);
        },
    });
        
        
    }
    
    function loadState()
    {
        var x = document.getElementById("country1").value;
        var country_id=x;
        checkCountry();
   
        $.ajax({
        //type: "POST",
        url: "<?php echo base_url(); ?>index.php/home/get_cities/"+country_id+"/", 
        data:country_id,
        dataType:"json",
        cache       : false,
        contentType : false,
        //processData : false,//return type expected as json
        success: function(states){
            $('#states')
                .find('option')
                .remove()
                .end()
                .append('<option value="">State/Province</option>')
               
            ;
           
            var opt = $('<option />'); 
                   /* opt.val(states);
                    opt.text(states);
                    $('#states').append(opt);*/
               
               $.each(states,function(idx,valu){
                    var opt = $('<option />'); 
                    opt.val(valu.code);
                    opt.text(valu.name);
                    $('#states').append(opt);
                    var cCode=valu.iso_code_2;
                   //console.log(cCode);
                    $('#country_code').val(cCode);
                });
            if (stat != null){
                //console.log("in");
               $("#states").val(stat);
                stat = "";
                //$('#states').value = stat;
                //f.sstate.value = f.bill_state.value;
            }
           
        },
    });
        //alert(cr_id);
    }
/*$("#fed_radio").click(function(){
    alert("clicked");
    });*/
function bill_loadState()
    {
        var x = document.getElementById("bill_country1").value;
        var country_id=x;
        checkCountry();
   
        $.ajax({
        //type: "POST",
        url: "<?php echo base_url(); ?>index.php/home/get_cities/"+country_id+"/", 
        data:country_id,
        dataType:"json",
        cache       : false,
        contentType : false,
        //processData : false,//return type expected as json
        success: function(states){
            $('#bill_states')
                .find('option')
                .remove()
                .end()
                .append('<option value="">State/Province</option>')
               
            ;
           
            var opt = $('<option />'); 
                   /* opt.val(states);
                    opt.text(states);
                    $('#states').append(opt);*/
               
               $.each(states,function(idx,valu){
                    var opt = $('<option />'); 
                    opt.val(valu.code);
                    opt.text(valu.name);
                    $('#bill_states').append(opt);
                    var cCode=valu.iso_code_2;
                   //console.log(cCode);
                    $('#bill_country_code').val(cCode);
                });
           //console.log(states);
        },
    });
        //alert(cr_id);
    }
</script>
<script>
          function   cuph()   
          {
            $('.phca').show();
            $('#phone').hide();
          }         
    function crtph()
    {

    $("#phcountry_code").live("change", function() {
        var a = $(this).find("option:selected").attr("value");
        $("#d_co").val( '+' + a);

        $("#telacrt").val("");
        $("#telncrt").val("");
        $("#phone").val("");
        $("#phno_note1crt").html('');
        $("#phno_note2crt").html('');
        $(".reg_btn").removeAttr("disabled");

        $("#telacrt").prop("readonly",false);
        $("#telncrt").prop("readonly",false);
        var n = a.length;
        //alert(n);
        if(n == 2)
        {
            $("#telncrt").prop("maxlength",8);
        }
        else
        {
            $("#telncrt").prop("maxlength",7);
        }

    });
}

function cpppy()
{
   // $("#telncrt").blur(function() {
        var a = $("#telncrt").val();
        //alert(a);
        var phoneno =/^[0-9]{3,10}$/;
        if(a.match(phoneno))
        {
            var cc=$("#phcountry_code").val();
            var ac=$("#telacrt").val();
            $("#phone").val('+'+cc+ac+a);
            $("#phno_note2crt").html('');
            $(".reg_btn").removeAttr("disabled");

        } 
        else 
        {
            $("#phno_note2crt").html( '<?php echo translate('Enter_valid_Ph.No(000)'); ?>' );
            $(".reg_btn").attr("disabled", "disabled");
        }

   // });
}

function cpry()
{
        //$("#telacrt").change(function() {
        var a = $("#telacrt").val();
        //alert(a);
        var phoneno =/^[0-9]{1,3}$/;
        if(a.match(phoneno))
        {
            var cc=$("#phcountry_code").val();
            var ac=$("#telncrt").val();
            $("#phone").val('+'+cc+a+ac);
            $("#phno_note1crt").html('');
            $(".reg_btn").removeAttr("disabled");

    var maxLength = $("#telacrt").attr('maxlength');
    if($("#telacrt").val().length == maxLength) 
    {
         $("#telncrt").focus();
    }
        } 
        else 
        {
            $("#phno_note1crt").html( '<?php echo translate('Enter_valid_Area.code(00)'); ?>' );
            $(".reg_btn").attr("disabled", "disabled");
        }

  //  });
}         

    function scuph()   
    {
      $('.sphca').show();
      $('#sphone').hide();
    }         
    function scrtph()
    {

    $("#scountry_code").live("change", function() {
        var a = $(this).find("option:selected").attr("value");
        $("#sd_co").val( '+' + a);

        $("#stelacrt").val("");
        $("#stelncrt").val("");
        $("#sphone").val("");
        $("#sphno_note1crt").html('');
        $("#sphno_note2crt").html('');
        $(".sreg_btn").removeAttr("disabled");

        $("#stelacrt").prop("readonly",false);
        $("#stelncrt").prop("readonly",false);
        var n = a.length;
        //alert(n);
        if(n == 2)
        {
            $("#stelncrt").prop("maxlength",8);
        }
        else
        {
            $("#stelncrt").prop("maxlength",7);
        }

    });
}

function scpppy()
    {
    //$("#stelncrt").blur(function() {
        var a = $("#stelncrt").val();
        //alert(a);
        var phoneno =/^[0-9]{3,10}$/;
        if(a.match(phoneno))
        {
            var cc=$("#scountry_code").val();
            var ac=$("#stelacrt").val();
            $("#sphone").val('+'+cc+ac+a);
            $("#sphno_note2crt").html('');
            $(".sreg_btn").removeAttr("disabled");

        } 
        else 
        {
            $("#sphno_note2crt").html( '<?php echo translate('Enter_valid_Ph.No(000)'); ?>' );
            $(".sreg_btn").attr("disabled", "disabled");
        }

    //});
    }

function scpry()
{
        //$("#stelacrt").change(function() {
        var a = $("#stelacrt").val();
        //alert(a);
        var phoneno =/^[0-9]{1,3}$/;
        if(a.match(phoneno))
        {
            var cc=$("#scountry_code").val();
            var ac=$("#stelncrt").val();
            $("#sphone").val('+'+cc+a+ac);
            $("#sphno_note1crt").html('');
            $(".sreg_btn").removeAttr("disabled");

    var maxLength = $("#stelacrt").attr('maxlength');
    if($("#stelacrt").val().length == maxLength) {
                                                $("#stelncrt").focus();
                                             }
        } 
        else 
        {
            $("#sphno_note1crt").html( '<?php echo translate('Enter_valid_Area.code(00)'); ?>' );
            $(".sreg_btn").attr("disabled", "disabled");
        }

    //});
}

/*document.getElementById("country").onchange = function(){
    //document.getElementById("box2").value = this.value;
    console.log("Yes");
};*/
</script>

<?php
    echo form_open('', array(
        'method' => 'post',
        'id' => 'coupon_set'
    ));
?>
<input type="hidden" id="coup_frm" name="code">
</form>

<?php
     echo form_open('', array(
        'method' => 'post',
        'id' => 'guest_set'
    ));
?>
<input type="hidden" id="grp_frm" name="guest_chk1">
</form>



<!-- ...............Recommended Products ..............-->

<!-- <div class="container">
  <div class="col-sm-12" style="padding: 0">  
  
<div class="sdbar posts margin-bottom-20 Recomd_prdct_bar">
                <h4 class="text_color center_text mr_top_0 Recomd_prdct_title"><?php echo translate('Recommended products'); ?></h4>
                <?php
//                    $i = 0;
//                        $most_popular = $this->crud_model->most_sold_products();
//                        foreach ($most_popular as $row2){
//                            $i++;
//                            if($i <= 6){
//                                if(!empty($most_popular[$i])){
//                                    $now = $this->db->get_where('product',array('product_id'=>$most_popular[$i]['id']))->row();
                                 
                ?>
                <div class="col-sm-2">
                <dl class="dl-horizontal Recomd_prdct">
                    <dt>
                        <a href="<?php // echo $this->crud_model->product_link($now->product_id); ?>">
                            <img src="<?php // echo $this->crud_model->file_view('product',$now->product_id,'','','thumb','src','multi','one'); ?>" alt="" />
                        </a>
                    </dt>
                    <dd>
                        <p style="float: left;">
                            <a class="rec_pdt_name" href="<?php // echo $this->crud_model->product_link($now->product_id); ?>">
                                <?php // echo $now->title; ?>
                            </a>
                        </p>
                        <p>
                        <?php // if($this->crud_model->get_type_name_by_id('product',$now->product_id,'discount') > 0){ ?>
                            <span >
                                <?php 
                                //echo currency().$this->crud_model->get_product_price($now->product_id); 
 
//                                        $rel_sale=$this->crud_model->get_product_price($now->product_id);
//                                        $rel_sale_amount=exchangeCurrency($currency_value,$exchange,$rel_sale);
//                                        echo currency()." ".convertNumber($rel_sale_amount);


                                ?>
                            </span><br>
                            <span style=" text-decoration: line-through;color:#c9253c;">
                                <?php //echo currency().$now->sale_price;

//                                    $rel_sale1=$now->sale_price;
//                                    $rel_sale_amount1=exchangeCurrency($currency_value,$exchange,$rel_sale1);
//                                    echo currency()." ".convertNumber($rel_sale_amount1);

 

                                 ?>
                            </span>
                        <?php // } else { ?>
                            <span class="price">
                                <?php //echo currency().$now->sale_price; 
// $rel_sale1=$now->sale_price;
//                                    $rel_sale_amount1=exchangeCurrency($currency_value,$exchange,$rel_sale1);
//                                    echo currency()." ".convertNumber($rel_sale_amount1);
                                ?>
                            </span>
                        <?php // } ?>
                        </p>
                    </dd>
                </dl></div>
                <?php       
//                            }
//                        }
//                    }
                ?>
            </div>





  </div>
  
</div> -->

<!-- ...............Recommended Products ..............-->