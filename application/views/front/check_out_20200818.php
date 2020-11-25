

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
            echo form_open(base_url('home/sale_place'), array('class' => 'ps-form--checkout','method' => 'post','enctype' => 'multipart/form-data','id' => 'cart_check_form','onsubmit' =>'return saleformvalid(); ' ));
              ?>
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12  ">
                  
                  <div class="ps-form__billing-info">

                    <h3 class="ps-form__heading"><?php echo translate('billing_details');?></h3>

                    <div class="form-group">
                      <label>
                        <?php echo translate('first_name'); ?><sup>*</sup>
                      </label>
                      <div class="form-group__content">
                        <input class="form-control required bill-data" name="firstname" type="text" placeholder="<?php echo translate('first_name'); ?>" value="<?php echo trim($user_data->username); ?>">
                      </div>
                    </div>

                    <div class="form-group">
                      <label>
                        <?php echo translate('last_name'); ?>
                      </label>
                      <div class="form-group__content">
                        <input placeholder="<?php echo translate('last_name'); ?>" name="lastname" class="form-control bill-data" type="text" value="<?php echo trim($user_data->surname); ?>">
                      </div>
                    </div>

                    <div class="form-group">
                      <label>
                        <?php echo translate('email_id'); ?><sup>*</sup>
                      </label>
                      <div class="form-group__content">
                        <input placeholder="<?php echo translate('email_id'); ?>" class="form-control required bill-data" value="<?php echo trim($user_data->email); ?>" name="email" type="email">
                      </div>
                    </div>

                    <div class="form-group">
                      <label>
                        <?php echo translate('mobile'); ?><sup>*</sup>
                      </label>
                      <div class="form-group__content">
                        <input placeholder="<?php echo translate('mobile'); ?>" class="form-control required bill-data" type="text" value="<?php echo trim($user_data->mobile); ?>" name="mobile" >
                      </div>
                    </div>
                
                    <div class="form-group">
                      <label>
                        <?php echo translate('address_line_1'); ?><sup>*</sup>
                      </label>
                      <div class="form-group__content">
                        <input placeholder="<?php echo translate('address_line_1'); ?>" class="form-control required bill-data" type="text" value="<?php echo trim($user_data->address1); ?>" name="address1" >
                      </div>
                    </div>
            
                    <div class="form-group">
                      <label>
                        <?php echo translate('address_line_2'); ?>
                      </label>
                      <div class="form-group__content">
                        <input placeholder="<?php echo translate('address_line_2'); ?>" class="form-control bill-data" type="text" value="<?php echo trim($user_data->address2); ?>" name="address2" >
                      </div>
                    </div>
            
                    <div class="form-group">
                      <label>
                        <?php echo translate('country'); ?><sup>*</sup>
                      </label>
                        <div class="form-group__content">
                          <select id="bill_country" name="country" class="form-control required bill-data" onChange="cartloadstate('bill_country','bill_state')">
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
                        <select id="bill_state" name="state" class="form-control required bill-data" onChange="">
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
                        <input placeholder="<?php echo translate('city'); ?>" class="form-control bill-data" type="text" value="<?php echo trim($user_data->city); ?>" name="city" >
                      </div>
                    </div>
            
                    <div class="form-group">
                      <label>
                        <?php echo translate('zip'); ?><sup>*</sup>
                      </label>
                      <div class="form-group__content">
                        <input placeholder="<?php echo translate('zip'); ?>" class="form-control required bill-data" type="text" value="<?php echo trim($user_data->zip); ?>" name="zip" >
                      </div>
                    </div>  
                    
                    <div class="form-group">
                      <div class="ps-checkbox">
                        <input class="form-control" name='new_ship_add' type="checkbox" id="shipd" onclick="checkship(this)">
                        <label for="shipd">Ship to a different address?</label>
                      </div>
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
									  <th>Product</th><th>Price</th><th>Tax</th><th>Shipping</th><th>Discount</th><th>Total</th>
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
										  			$itm_ship=$items['shipping']*$pr_qty;
										  			echo currency().' '.$itm_ship; 
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
                              </table>
                              <h4 class="ps-block__title"><span>Total</span>
                                  <?php 
                                  	echo '  '.currency().' '.$this->cart->format_number($vend_total); 
                                  ?>
                              </h4>
                              <div class='bank_info'>
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
									 <input class='recept-file' data-key="<?php echo $key;?>" id="recept-upload_<?php echo $key;?>" required name='receipt_<?php echo $key;?>' type="file" accept="image/jpeg,image/gif,image/png,application/pdf,application/msword" />
									 
								</div>
                              </div>
                            </div>
                            <?php
                          }
                        ?>
                        
                      </div>
					  <input type="text" name="payment_type" value="offline" hidden>
                      <button type="submit" class="ps-btn ps-btn--fullwidth" >Place Order</button>
						<span id="check-form-alert" class="col-md-4 offset-md-4"></span>
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

<script>
  
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
	{
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
		else
		{return true;}
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
