

    <div class="ps-page--simple">
      <div class="ps-breadcrumb">
        <div class="container">
          <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>"><?php echo translate('home');?></a></li>
            <li><a href="<?php echo base_url('home/cart_checkout');?>"><?php echo translate('shopping_cart');?></a></li>
            <li><?php echo translate('checkout')?></li>
          </ul>
        </div>
      </div>
      <div class="ps-checkout ps-section--shopping">
        <div class="container">
          <div class="ps-section__header">
            <h1><?php echo translate('checkout')?></h1>
          </div>
          <div class="ps-section__content">
            <?php 
                //   echo '<pre>'; print_r($this->cart->contents()); echo '</pre>';
                echo form_open(base_url('home/sale_place'), array('class' => 'ps-form--checkout','method' => 'post','enctype' => 'multipart/form-data','id' => 'cart_check_form','onsubmit' =>'return saleformvalid(); ' ));
                ?>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12  ">
                      
                      <div class="ps-form__billing-info">
    
                         <div class="row"> 
                              <div class="col-6"><h3 class="ps-form__heading"><?php echo translate('billing_details');?></h3> </div>
                              <div class="col-6 tar"><button id="addr-modal" type="button" class="ps-btn" data-toggle="modal" data-target="#addrModal"><i class="fa fa-plus"></i> Add Address</button> </div>
                            </div>
                           <div id="refresh">
                            <?php
                            if($all_address && count($all_address) >0){
                            foreach ($all_address as $key => $addr) {
                             $country_name = $this->db->where('id',$addr->country)->get('countries')->row()->name; 
                            ?>
                            <div class="form-group">
                              <div><strong><?php echo trim($addr->fname); ?></strong> </div> 
                              <div>  <?php echo trim($addr->address1); ?>,
                              <span> <?php echo trim($addr->address1); ?>,</span>
                              <span> <?php echo trim($addr->road_name); ?>,</span>
                              </div>
                              <div>
                              <?php echo trim($addr->landmark); ?>,
                              <span> <?php echo trim($addr->city); ?>,</span>
                              <span> <?php echo trim($addr->zip); ?>,</span>
                              <span> <?php echo $country_name; ?></span>
                              </div>
                            </div>
                            <?php
                              }
                            }
                            else
                              { echo '<div class="col-12 tac">No address found in this region.</div>'; 
                          }
                            ?>
                        </div>
                      </div>
                      <div class="ps-form__billing-info" id="shipping-info" style="display:none">
    
                        <h3 class="ps-form__heading">Shipping Details</h3>
    
                        <div class="form-group">
                          <label>
                            <?php echo translate('first_name'); ?><sup>*</sup>
                          </label>
                          <div class="form-group__content">
                            <input class="form-control required ship_frm ship_frm-req" name="s_firstname" type="text" placeholder="<?php echo translate('first_name'); ?>" value="<?php echo trim($user_data->username); ?>">
                          </div>
                        </div>
    
                        <div class="form-group">
                          <label>
                            <?php echo translate('last_name'); ?>
                          </label>
                          <div class="form-group__content">
                            <input placeholder="<?php echo translate('last_name'); ?>" name="s_lastname" class="form-control ship_frm" type="text" value="<?php echo trim($user_data->surname); ?>">
                          </div>
                        </div>
    
                        <div class="form-group">
                          <label>
                            <?php echo translate('email_id'); ?><sup>*</sup>
                          </label>
                          <div class="form-group__content">
                            <input class="form-control required ship_frm ship_frm-req" value="<?php echo trim($user_data->email); ?>" name="s_email" type="email" placeholder="<?php echo translate('email_id'); ?>">
                          </div>
                        </div>
    
                        <div class="form-group">
                          <label>
                            <?php echo translate('mobile'); ?><sup>*</sup>
                          </label>
                          <div class="form-group__content">
                            <input placeholder="<?php echo translate('mobile'); ?>" class="form-control required ship_frm ship_frm-req" type="text" value="<?php echo trim($user_data->mobile); ?>" name="s_mobile" >
                          </div>
                        </div>
                    
                        <div class="form-group">
                          <label>
                            <?php echo translate('address_line_1'); ?><sup>*</sup>
                          </label>
                          <div class="form-group__content">
                            <input placeholder="<?php echo translate('address_line_1'); ?>" class="form-control required ship_frm ship_frm-req" type="text" value="<?php echo trim($user_data->address1); ?>" name="s_address1" >
                          </div>
                        </div>
                
                        <div class="form-group">
                          <label>
                            <?php echo translate('address_line_2'); ?>
                          </label>
                          <div class="form-group__content">
                            <input placeholder="<?php echo translate('address_line_2'); ?>" class="form-control ship_frm" type="text" value="<?php echo trim($user_data->address2); ?>" name="s_address2" >
                          </div>
                        </div>
                
                        <div class="form-group">
                          <label>
                            <?php echo translate('country'); ?><sup>*</sup>
                          </label>
                            <div class="form-group__content">
                              <select id="ship_country" name="s_country" class="form-control required ship_frm ship_frm-req" onChange="cartloadstate('ship_country','ship_state')">
                                <option value="">Select Country..</option>
                                  <?php
                                    $cntry=$this->db->get_where('fed_country',array('status'=>'1'))->result_array();
                                    foreach($cntry as $cntry_details)
                                      {
                                        $sel='';
                                        if($cntry_details[country_id]==$user_data->country_id)
                                        {
                                          $sel=" selected";
                                        }
                                        echo "<option value='".$cntry_details[country_id]."' ".$sel.">".$cntry_details[name]."</option>";
                                      }
                                  ?>
                              </select>
                            </div>
                        </div>
                    
                        <div class="form-group">
                          <label>
                            <?php echo translate('state'); ?><sup>*</sup>
                          </label>
                          <div class="form-group__content">
                            <select id="ship_state" name="s_state" class="form-control required ship_frm ship_frm-req" >
                              <option value=""><?php echo translate('State/Province'); ?>
                              </option>
                              <?php
                                $states=$this->db->get_where('fed_zone',array('country_id'=>$user_data->country_id))->result_array();
                                foreach($states as $states_details)
                                  {
                                    $sel2='';
                                    if($states_details[code]==$user_data->state_code)
                                    {
                                      $sel2=" selected";
                                    }
                                    echo "<option value='".$states_details[code]."' ".$sel2.">".$states_details[name]."</option>";
                                  }
                              ?>
                            </select>
                          </div>
                        </div>
    
                        <div class="form-group">
                          <label>
                            <?php echo translate('city'); ?>
                          </label>
                          <div class="form-group__content">
                            <input placeholder="<?php echo translate('city'); ?>" class="form-control ship_frm" type="text" value="<?php echo trim($user_data->city); ?>" name="s_city" >
                          </div>
                        </div>
                
                        <div class="form-group">
                          <label>
                            <?php echo translate('zip'); ?><sup>*</sup>
                          </label>
                          <div class="form-group__content">
                            <input placeholder="<?php echo translate('zip'); ?>" class="form-control required ship_frm ship_frm-req" type="text" value="<?php echo trim($user_data->zip); ?>" name="s_zip" >
                          </div>
                        </div>  
                      </div>
                      
                    </div>
    
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12  ">
                      <div class="ps-form__total">
                        <h3 class="ps-form__heading">Your Order</h3>
                        <div class="content">
                          <div class="ps-block--checkout-total">
                            <?php
                              $vendors_list=array();$admins_list=array();
                              foreach ($carted as $items_ship)
                              {
                                $item_id    =$items_ship['id'];
                                $prdts=$this->db->get_where('product',array('product_id'=>$item_id))->result_array();
                                    foreach($prdts as $prdts_details)
                                    {
                                        $vendors_array= $prdts_details['added_by'];
                                        $vendors= json_decode($vendors_array,true);
                                        $v_type = $vendors['type'];
                                        $v_id   = $vendors['id'];
                                        if($v_type=='vendor')
                                        {
                                          $vendors_list[]=$v_id;
                                        }
                                        else
                                        {
                                          $admins_list[]=$v_id;
                                        }
                                    }
                              }
                              $vendors_list=array_unique($vendors_list);
                              $admins_list=array_unique($admins_list);
                              //print_r($carted);
                              //print_r($admins_list);
                              foreach ($vendors_list as $key) 
                              {   
                                $vend_total=0;
                                $vndr=$this->db->get_where('vendor',array('vendor_id'=>$key))->row();
                                $vdis_name=trim($vndr->display_name);
                                ?>
                                <div class="ps-block__header">
                                  <h4><?php echo $vdis_name; ?></h4>
                                </div>
                                <div class="ps-block__content">
                                    <table class="table ps-block__products">
                                        <thead>
                                          <tr>
        									  <th>Product</th><th>Price</th><th>Tax</th><th>Discount</th><th>Total</th>
        								 </tr>
                                        </thead>  
                                        <tbody>
                                          <?php
        							  		$vend_total=$shp_total=$tx_total=0;
                                            foreach ($carted as $items)
                                            {
        									  $itm_tx=0;$itm_ship=0;$itm_prce=0;$itm_dis=0;	
                                              $item_id    = $items['id'];
                                              $prd_row    = $this->db->get_where('product',array('product_id'=>$item_id))->row();
                                              $ven_array  = $prd_row->added_by;
                                              $ven        = json_decode($ven_array,true);
                                              $ven_id     = $ven['id'];
                                              if($key == $ven_id)
                                              {
        										  //print_r($items);
                                                ?>
                                                  <tr>
                                                    <td>
                                                      <a href="<?php echo $this->crud_model->product_link($items['id']); ?>"> 
                                                        <?php 
                                                          echo $items['name'].' × ';
                                                          if(!$this->crud_model->is_digital($items['id']))
                                                          { 
        													  echo $items['qty']; 
        													  $pr_qty=$items['qty'];
        												  }
                                                          else
                                                          { 
        													  echo '1';
        													  $pr_qty=1;
        												  }
                                                        ?>
                                                      </a>
                                                      <!-- <p>Sold By:<strong><?php //echo $vdis_name; ?></strong></p> -->
                                                    </td>
        											<td>
        												<?php 
        										  			$itm_prce=$items['price']*$pr_qty;
        										  			echo currency().' '.$itm_prce; 
        												?>
        											</td>
        											<td>
        												<?php 
        										  			$itm_tx=$items['tax']*$pr_qty;
        										  			echo currency().' '.$itm_tx; 
        												?> 
        											</td>
        											
        											 <td>
        												<?php 
        										  			$itm_dis=$items['coupon_discount'];
        										  			echo currency().' '.$itm_dis; 
        												?> 
        											</td>
                                                    <td>
                                                      <?php 
        										  		$pr_subtotl=($itm_prce+$itm_tx+$itm_ship)-$itm_dis;
                                                        $vend_total=$vend_total+$pr_subtotl; 
                                                        echo currency().$pr_subtotl;
                                                      ?>
                                                    </td>
                                                  </tr>
                                                <?php
                                              }
                                            }
                                          ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan='4' style="font-weight: bold;text-align: right;">Total</th>
                                                <th style="font-weight: bold;"><?php echo '  '.currency().' '.number_format($vend_total,2, '.', ''); ?></th>
                                            </tr>
                                            <tr>
        									  <th colspan='4' style="font-weight: bold;text-align: right;">Shipping Charge</th>
        									  <th style="font-weight: bold;"><?php echo ' '.currency().' <span id="chspc" style="font-weight: bold;">'.number_format($this->session->userdata('ship_cost'),2).'</span>'; ?></th>
        								    </tr>
        								    <tr>
        									  <th colspan='4' style="font-weight: bold;text-align: right;">Grand Total</th>
        									  <th style="font-weight: bold;"><?php echo ' '.currency().' <span id="chstotal" style="font-weight: bold;">'.number_format($vend_total+$this->session->userdata('ship_cost'),2, '.', '').'</span>'; ?></th>
        								    </tr>
                                        </tfoot>
                                    </table>
                                    <input style="display: none;" type='text' id='ventotal' value=<?php echo $vend_total ;?> />
                                    <div class="ship-operator">
                                        <h5>Shipping Operator</h5> 
                                        <div class="form-group ">
                                            <?php
                                                $shpping_operators=$this->crud_model->shipping_operators();
        								        echo form_dropdown('shipping_operator',$shpping_operators,$this->session->userdata('ship_operator'),'class="form-control col-md-6"  id="shipping_operator" required onchange="shippingcheck()"')
        							        ?>
        							        <div id='ship_alert'></div>
        							    </div>
							        </div>
							        <?php /*
                                    <h4 class="ps-block__title"><span>Grand Total</span>
                                      <?php 
                                      	echo '  '.currency().' '.$this->cart->format_number($vend_total); 
                                      ?>
                                    </h4> */ ?>
                                    <div class='bank_info' style="display: none;">
                                        <h5> <?php echo $vdis_name; ?> Bank Account Information</h5>
                                        <address>
                                          Bank Name       : <?php echo trim($vndr->bank_name); ?><br/>
                                          SWIFT BIC code  : <?php echo trim($vndr->swift_code); ?><br/>
                                          Account number  : <?php echo trim($vndr->account_number); ?><br/>
                                          Name on Account : <?php echo trim($vndr->name_account); ?><br/>
                                        </address>
        								  <input style='display:none' name="ventotal_<?php echo $key;?>" value="<?php echo $vend_total;?>" />
        								<div class="recp-div">
        									 <label for="recept-upload_<?php echo $key;?>"  class="custom-file-upload">
        										<i class="fa fa-cloud-upload"></i> Upload Bank Receipt <sup>*</sup>
        									 </label>
        									 <span class='recept-msg' id="recept-name_<?php echo $key;?>"></span>
        									 <input class='recept-file' data-key="<?php echo $key;?>" id="recept-upload_<?php echo $key;?>" name='receipt_<?php echo $key;?>' type="file" accept="image/jpeg,image/gif,image/png,application/pdf,application/msword" />
        									 
        								</div>
                                    </div>
                                  
                                    <div class="pay-methods">
                                         <h5>Payment Methods</h5> 
                                         <input type="hidden" id="pass_type" name="pass_type" value="" />
                                         <label class="col-12 form-label">
                                             <input type="radio" id="paypal" name="payment_type" value="paypal" required /> Paypal
                                         </label>
                                         <label class="col-12 form-label">
                                             <input type="radio" id="payfort" name="payment_type" value="payfort" required /> Payfort
                                         </label>
                                         <label class="col-12 form-label">
                                             <input type="radio" id="cod" name="payment_type" value="cod" required /> Cash On Delivery
                                         </label>
                                    </div>
                                </div>
                                <?php
                              }
                            ?>
                            
                        
                            <!-- <input type="text" name="payment_type" value="payfort" hidden>-->
                            <button type="submit" class="ps-btn ps-btn--fullwidth" >Place Order</button>
    						<span id="check-form-alert" class="col-md-4 offset-md-4"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                echo form_close();
            ?>
          </div>
        </div>
      </div>
    </div>

<!-- The Modal -->
<div class="modal" id="addrModal">
  <div class="modal-dialog">
    <div class="modal-content">
        <?php echo form_open(base_url('home/checkout_address/save'), ['id'=>'addr-form','method'=>'post']) ?>
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Add Address</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="col-12 mb-4">
                    <label for="fname" class="">Name</label>
                    <input id="fname" name="addr[fname]" class="form-control required" type="text" placeholder="Enter Name">
                    <span id="fname_error" class="error"></span>
                </div>
                <div class="col-12 mb-4">
                    <label for="address1" class="">Address</label>
                    <input id="address1" name="addr[address1]" class="form-control required" type="text" placeholder="Enter Address">
                    <span id="address1_error" class="error"></span>
                </div>
                <div class="col-12 mb-4">
                    <label for="road_name" class="">Road Name</label>
                    <input id="road_name" name="addr[road_name]" class="form-control required" type="text" placeholder="Enter Road Name">
                    <span id="road_name_error" class="error"></span>
                </div>
                <div class="col-12 mb-4">
                    <label for="city" class="">City</label>
                    <input id="city"  name="addr[city]" class="form-control required" type="text" placeholder="Enter City Name">
                    <span id="city_error" class="error"></span>
                </div>
                <div class="col-12 mb-4">
                    <label for="landmark" class="">Land Mark</label>
                    <input id="landmark"  name="addr[landmark]" class="form-control" type="text" placeholder="Enter Land Mark">
                    <span id="landmark_eror" class="error"></span>
                </div>
                <div class="col-12 mb-4">
                    <label for="country" class="">Country</label>
                    <select id="country" name="addr[country]" class="form-control" >
                      <?php
                      $cc_code = wh_country()->code;
                      $country = $this->db->where('sortname',$cc_code)->get('countries')->row();
                        // foreach(countries() as $rw){
                        //     if($rw->sortname == wh_country()->code )
                        //       { 
                                $selected = 'selected="selected"'; 
                              // }
                              // else
                              //   { 
                              //     $selected = ''; 
                              //   }
                            echo '<option value="'.$country->id.'" '.$selected.' >'.$country->name.'</option>';
                        // } 
                        ?>
                    </select>
                    <span id="country_error" class="error"></span>
                </div>
                <div class="col-12 mb-4">
                    <label for="zip" class="">Zip</label>
                    <input id="zip"  name="addr[zip]" class="form-control required" type="number" placeholder="Enter Zip Code">
                    <span id="zip_error" class="error"></span>
                </div>
                <div class="col-12 mb-4">
                    <label for="address" class="">Address Type</label><div class="clr"></div>
                    <div class="col-6 pl-0 fl">
                        <input id="addr_type1"  name="addr[address_label]" class="required"  type="radio" value="Home" checked="checked">
                        <label for="addr_type1" class="">Home</label>
                    </div>
                    <div class="col-6 pr-0 fl">
                        <input id="addr_type2"  name="addr[address_label]" class="required"  type="radio" value="Work">
                        <label for="addr_type2" class="">Work</label>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <input id="default_addr"  name="addr[default_addr]" class="" type="checkbox" value="1">
                    <label for="default_addr" class="">Default Address</label>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <input type="hidden" id="adrs_id" name="adrs_id" value="0" />
                <input type="hidden" id="valid" name="valid" value="0" /><input type="hidden" id="submit_label" name="submit_label" value="Save" />  
                <button type="submit" id="save-addr" class="btn-u btn-u-update">Save</button>
              <button type="button" class="btn-u btn-u-danger" data-dismiss="modal">Close</button>
            </div>
        <?php form_close()?>
    </div>
  </div>
</div>

<script>
    $(document).ready(function(){
        $('#addr-modal').on('click', function(){
            var modal   =   $(this).data('target'); $(modal).modal('show');
        });
         $('#addr-form').on('submit',function(){
            $('#valid').val(1); $('#submit_label').val('Saving...');
            $('#addr-form .required').each(function(){
                if(this.value == ''){ $('#'+this.id).closest('div').find('#'+this.id+'_error').html('This field is required'); $('#valid').val(0); $('#submit_label').val('Validating...'); }
                else{ $('#'+this.id).closest('div').find('#'+this.id+'_error').html(''); }
            });
            var formData    =   $('#addr-form').serialize();
            var action      =   $(this).attr('action'); 
        //    if{$('#valid').val() == 0){ alert('false'); }
            $.ajax({
                url: action,
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#save-addr').text($('#submit_label').val()); $('#save-addr').attr('disabled',true);
                },
                success: function(data) {
                    if(data == 'invalid'){
                        notify("Please fill all fields",'warning','bottom','right');
                        $('#save-addr').text('Save');  $('#save-addr').attr('disabled',false);
                    }else if(data == 'failed'){
                        notify("Address failed to save",'warning','bottom','right');
                        $('#save-addr').text('Save');  $('#save-addr').attr('disabled',false);
                    } else {
                        if($('#addr-form #adrs_id').val() > 0){ var msg = 'updated'; }else{ var msg = 'added'; }
                        $('#addrModal').modal('hide'); $('#save-addr').attr('disabled',false); $('#save-addr').text('Save');
                        notify("Address "+msg+" successfully!",'success','bottom','right');
                        //  $('#address').html(data); 
                        $('#refresh').load(location.href + " #refresh");
                        $("#addr-form").trigger("reset");
                    }
                },
                error: function(e) {
                    console.log(e)
                }
            });
            return false;
        });
    });
    
  function cartloadstate(cntry,stat,setval='')
    {
    //console.log(cntry);
        var x = $("#"+cntry).val();
    //console.log(x);
        var country_id=x;
        $.ajax({
                url: "<?php echo base_url(); ?>home/get_cities/"+country_id+"/", 
                data:country_id,
                dataType:"json",
                cache       : false,
                contentType : false,
                success: function(states)
                {
                    $('#'+stat)
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">State/Province</option>')
                        ;
                    var opt = $('<option />'); 
                    $.each(states,function(idx,valu)
                    {
                        var opt = $('<option />'); 
                        opt.val(valu.code);
                        opt.text(valu.name);
                        $('#'+stat).append(opt);
                        //var cCode=valu.iso_code_2;
                    });
					if(setval)
					{
						$('#'+stat).val(setval);
					}
                },
            });
    }
  
  function checkship(shipd)
  {
    //alert(shipd);
    if(shipd.checked == true)
    {
          $(".ship_frm").val("");
		  //$(".ship_frm-req").prop('required',true);
      	  $("#shipping-info").css('display','block');
    }
    else
    {
		updateshipdata();
		//$(".ship_frm-req").prop('required',false);
        $("#shipping-info").css('display','none');
    }
  }
	function updateshipdata()
	{
		$("input[name=s_firstname]").val($("input[name=firstname]").val());
		$("input[name=s_lastname]").val($("input[name=lastname]").val());
		$("input[name=s_email]").val($("input[name=email]").val());
		$("input[name=s_mobile]").val($("input[name=mobile]").val());
		$("input[name=s_address1]").val($("input[name=address1]").val());
		$("input[name=s_address2]").val($("input[name=address2]").val());
		
		var cntry=$("#bill_country").val();
		var statea=$("#bill_state").val();
		//console.log(cntry);
		$("#ship_country").val(cntry);
		cartloadstate('ship_country','ship_state',statea)
		$("input[name=s_state]").val($("input[name=state]").val());
		$("input[name=s_city]").val($("input[name=city]").val());
		$("input[name=s_zip]").val($("input[name=zip]").val());
	}
  	$(".bill-data").on('change', function() 
	{
		//console.log($("#shipd").prop("checked"));
		if($("#shipd").prop("checked") != true)
		{
			updateshipdata();
		}
  		
	});
	
	$(".recept-file").on('change ', function() 
	{
		var keyid=$(this).attr('data-key');
		
		//alert(this.files[0].name);
		var fileExtension = ['jpeg','png','jpg','pdf','docx'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1)
            {
                $('#recept-name_'+keyid).html("<font color='red'>Formats allowed :"+fileExtension.join(',')+"</font>");
                $(this).val("");
            }
			else
			{
				$('#recept-name_'+keyid).text(this.files[0].name);
			}
	});
	
	function saleformvalid()
	{   $('#pass_type').val('');
		var form =$("#cart_check_form");
		var can = '';
		var a = 0;
        var take = '';
        $("#cart_check_form").find(".required").each(function()
        {
       		var txt = '* '+required;
            a++;
            if(a == 1)
            {
                take = 'scroll';
            }
            var here = $(this);
            if(here.val() == '')
            {
                if(!here.is('select'))
                {
                    here.css({borderColor: 'red'});

                    if(here.attr('type') == 'number')
					{
                        txt = '* '+mbn;
                    }
                    if(here.closest('.form-group__content').find('.require_alert').length)
                    {
                    } 
                    else 
                    {
                        here.closest('.form-group__content').append(''
                            +'  <span id="'+take+'" class="require_alert" >'
                            +'      '+txt
                            +'  </span>'
                        );
						
                    }
                } 
                else if(here.is('select'))
                {
					here.css({borderColor: 'red'});
                    here.closest('div').find('.chosen-single').css({borderColor: 'red'});
                    if(here.closest('.form-group__content').find('.require_alert').length){
                    } 
                    else 
                    {
                        here.closest('.form-group__content').append(''
                            +'  <span id="'+take+'" class="require_alert" >'
                            +'      '+txt
                            +'  </span>'
                        );
                    }
                }
                var topp = 100;
                can = 'no';
            }
			if (here.attr('type') == 'email')
			{
				if(!isValidEmailAddress(here.val()))
				{
					here.css({borderColor: 'red'});
					if(here.closest('.form-group__content').find('.require_alert').length){
					} 
					else 
					{
						here.closest('.form-group__content').append(''
                            +'  <span id="'+take+'" class="require_alert" >'
                            +'      '+mbe
                            +'  </span>'
						);
					}
					can = 'no';
				}
			}
            take = '';
        });
		if(can=='no')
		{	
			$("#check-form-alert").html("Fill all required fileds.");
			return false;
		}
        else if($('#payfort').prop('checked') == true){ 
                    $('#pass_type').val('ajax');
                    return true;
                    //                    $.ajax({
                    //                        type: "POST",
                    //                        url: form.attr('action'),
                    //                        data: form.serialize(),
                    //                        success: function (data) {
                    //                            $('.error').html('');
                    //                            if(data == 'success'){ 
                    //                                
                    //                            }else{ 
                    //                                
                    //                            }
                    //                        }
                    //                    });
                    return false; 
                }else{}
	}
	
	$("#cart_check_form").on('change','.required',function()
	{
		$("#check-form-alert").html('');
		var here = $(this);
		if (here.attr('type') == 'email')
		{
			if(isValidEmailAddress(here.val()))
			{
				here.closest('.form-group__content').find('.require_alert').remove();
				here.css({borderColor: '#ddd'});
			}
		} 
		else 
		{
			if(here.val())
			{
				here.closest('.form-group__content').find('.require_alert').remove();
				here.css({borderColor: '#ddd'});
			}
		}
		if(here.is('select'))
		{
			here.closest('.form-group__content').find('.chosen-single').css({borderColor: '#dcdcdc'});
		}

	});
	
	            function shippingcheck()
                    {
                        $('#ship_alert').html('');
                        var opert_id=$('#shipping_operator').val();
                        var url = base_url+'home/shipping_cost/';
                        var ship = $('#shipping');
                        var r = parseFloat($('#ventotal').val());
                        $.get(url+opert_id, function(data, status)
                            {
                                //console.log("Data: " + data + "\nStatus: " + status);
                                var rest = data.split('-');
                                if(rest[0]=='1')
                                {
                                    $('#ship_alert').html('<span style="color:green">'+rest[2]+'</span>');
                                    $('#chspc').html(parseFloat(rest[3]).toFixed(2));
                                    var n1 = r + parseFloat(rest[3]);
                                    $('#chstotal').html(n1.toFixed(2));
                                    
                                }
                                else
                                {
                                    $('#ship_alert').html('<span style="color:red">'+rest[1]+'</span>');
                                    $('#chspc').html(rest[3]);
                                    $('#chstotal').html(r.toFixed(2));
                                }
                               
                            });
                            
                       
                        
                       
                        
                    }
</script>

<style>
	.recp-div
	{
		height:60px;
	}
	.recept-file
	{
		opacity: 0;
		position: absolute;
		left: 1px;
		width: 188px;
	}
	#check-form-alert
	{
		color:red;
	}
</style>
