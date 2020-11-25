<div class="row">
    <div class="col-md-12">
        <?php
            echo form_open(base_url() . 'index.php/vendor/product/do_add/', array(
                'class' => 'form-horizontal',
                'method' => 'post',
                'id' => 'product_add',
                'enctype' => 'multipart/form-data'
            ));
        ?>
            <!--Panel heading-->
             <div class="panel-heading" style="background: #EFEFEF; height:60px; ">
                <div class="panel-control" style="float: left;">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#product_details"><?php echo translate('product_details'); ?></a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#business_details"><?php echo translate('data'); ?></a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#customer_choice_options"><?php echo translate('customer_choice_options'); ?></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="tab-base">
                    <div class="tab-content">
						
                        <div id="business_details" class="tab-pane fade">
                            <div class="form-group btm_border">
                           		<h4 class="text-thin text-center"><?php echo translate('data'); ?></h4>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1">
									<?php echo translate('model');?>
								</label>
                                <div class="col-sm-6">
                                    <input type="text" name="model" id="demo-hor-6.1" placeholder="<?php echo translate('model');?>" class="form-control ">
                                </div>
                            </div>                            

                            <div class="form-group btm_border" style="display:none">
                                <label class="col-sm-4 control-label" for="demo-hor-1">
									<?php echo "HS Code";?>
								</label>
                                <div class="col-sm-6">
                                    <input type="text" name="sku" id="demo-hor-6.2" placeholder="<?php echo "HS Code";?>" class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1">
									<?php echo "MPN";?>
								</label>
                                <div class="col-sm-6">
                                    <input type="text" name="mpn" id="demo-hor-6.3" placeholder="<?php echo "Manufacturer Part Number";?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group btm_border" style="display:none">
                                <label class="col-sm-4 control-label" for="demo-hor-1">
									<?php echo "DG product";?>
                                </label>
                                <div class="col-sm-6">
								  <div class="radio" id="dg" >
			  						<label><input type="radio" id="dyes" name="dgradio" value="1" >Yes</label>
	  								<label><input type="radio" id="dno" name="dgradio" checked="ckecked" value="0">No</label>
								  </div>
                                </div>
                            </div>
							
						  	<div class="form-group btm_border" style="display:none">
								<label class="col-sm-4 control-label" for="demo-hor-1">
									<?php echo "Product Location";?>
								</label>
								<div class="col-sm-6">
								  <input type="text" name="location" class="form-control " placeholder="Location">
								</div>
						  	</div>


							<div class="form-group btm_border" style="display:none">
								<label class="col-sm-4 control-label" for="demo-hor-1">
									<?php echo translate('package(group/not)');?>
								</label>
								<div class="col-sm-6">
								  <select class="form-control " name="product_group" id='pgon' onchange="">
									<option value="single" selected>Normal Product</option>
									<option value="grouped">Grouped Product</option>
								  </select>
								</div>
							</div>

							  <div class="form-group btm_border groupedp " id="groupedp1" hidden>
								<button class="btn btn-primary btn-labeled fa fa-plus-circle " 
									  onclick="ajax_modal('gp_add','<?php echo translate('add_package'); ?>','<?php echo translate('successfully_added!');?>','gp_add','')">
									<?php echo translate('add_package');?>
								</button>
							  </div>

							  <div class="form-group btm_border groupedp " hidden>
								  <table align="center" class="group-list-gp" id="group-list-gp">
									  <thead>
										<th></th>
										<th>
										  <label class="col-sm-6 control-label" for="demo-hor-3">
											  <?php echo translate('package');?></label>
										</th>
										<th><label class="col-sm-4 control-label" for="demo-hor-4">
											<?php echo translate('quantity');?></label></th>
										<th><label class="col-sm-4 control-label" for="demo-hor-4">
											<?php echo translate('Length');?></label></th>
										<th><label class="col-sm-4 control-label" for="demo-hor-4">
											<?php echo translate('width');?></label></th>
										<th><label class="col-sm-4 control-label" for="demo-hor-4">
											<?php echo translate('height');?></label></th>
										<th><label class="col-sm-4 control-label" for="demo-hor-4">
											<?php echo translate('Weight');?></label></th>
										<td></td>
									  </thead>
								  </table>
								  <input type='text'  hidden="hidden"  id='rowCnt' value='0'>
							  </div>
 
								<div id='singlep' style='display:none'>
									<div class="form-group btm_border">
												<label class="col-sm-4 control-label" for="demo-hor-1">
													Packed Dimensions (L x W x H):</label>
											<div class="col-sm-6"> 
												  <div class="col-sm-4"> 
												<input type="number" placeholder="<?php echo translate('length');?>" name="length" value="" size="4" class="form-control  singlep">
												  </div>
												  <div class="col-sm-4"> 
												<input type="number" placeholder="<?php echo translate('width');?>" name="width" value="" size="4" class="form-control  singlep">
												  </div>
												  <div class="col-sm-4"> 
												<input type="number" placeholder="<?php echo translate('height');?>" name="height" value="" size="4" class="form-control  singlep">
												  </div>
											</div>
									 </div>    

									 <div class="form-group btm_border">      
									  <label class="col-sm-4 control-label" for="demo-hor-1">Length Class:</label>
									  <div class="col-sm-6">         
									   <select id="length_class_id" name="length_class_id" class="form-control  singlep">
										<option value="1" selected="selected" class="form-control ">Centimeter</option>
										<option value="3">Inch</option>
									   </select>
									  </div>
									</div>             

									<div class="form-group btm_border">      
									  <label class="col-sm-4 control-label" for="demo-hor-1">Weight:</label>
									  <div class="col-sm-6">
									  <input type="number" name="weight" value="" class="form-control  singlep" placeholder="Weight">
									  </div>
									</div>

									<div class="form-group btm_border">      
									  <label class="col-sm-4 control-label" for="demo-hor-1">Weight Class:
									  </label>
									  <div class="col-sm-6">         
										<select id="weight_class_id" name="weight_class_id" class="form-control  singlep">
										<option value="1" selected="selected">Kilogram</option>
										<option value="5">Pound </option>
										</select>
									  </div>
								   </div>  
								</div>                    


                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-6">
									<?php echo translate('sale_price');?>
								</label>
                                <div class="col-sm-4">
                                    <input type="number" name="sale_price" id="demo-hor-6" min='0' step='.01' placeholder="<?php echo translate('sale_price');?>" class="form-control required">
                                </div>
                                <span class="btn"><?php echo currency(); ?> / </span>
                                <span class="btn unit_set"></span>
                            </div>
                            
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-7">
									<?php echo translate('purchase_price');?>
								</label>
                                <div class="col-sm-4">
                                    <input type="number" name="purchase_price" id="demo-hor-7" min='0' step='.01' placeholder="<?php echo translate('purchase_price');?>" class="form-control ">
                                </div>
                                <span class="btn"><?php echo currency(); ?> / </span>
                                <span class="btn unit_set"></span>
                            </div>
                            
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-8">
									<?php echo translate('shipping_charge');?>
								</label>
                                <div class="col-sm-4">
                                    <input type="number" name="shipping_cost" id="demo-hor-8" min='0' step='.01' placeholder="<?php echo translate('shipping_cost');?>" class="form-control">
                                </div>
                                <span class="btn"><?php echo currency(); ?> / </span>
                                <span class="btn unit_set"></span>
                            </div>
                            

  					<div class="form-group btm_border">
                      <label class="col-sm-4 control-label" for="demo-hor-9"><?php echo translate('product_tax');?></label>
                      <table align="center" class="product-list col-sm-12">
                                <tr >
                                <td class="col-sm-4"></td>
                                <td class="col-sm-2" id="product"> 
                                <?php 
                        echo $this->crud_model->select_html('tax','tax','tax_type','add','form-control p demo-chosen-select','','','','get_pro_res'); ?>
                                 <span id="msg" style="display:none;color:red;">fdfdf</span>
                                 </td> 

                                  <td class="col-sm-2">
                     <input type="number" name="tax_type" id="tax_type" min='0' step='.01' max="99" placeholder="<?php echo translate('product_tax');?>" class="form-control " onchange="limtper(this.value,this.id)" >
                    <span id="msg1" style="display:none;color:red;"></span>  
                                  </td>
                                   <td class="col-sm-1">
                                   <select class="demo-chosen-select" name="tax_amount">
                                        <option value="percent">%</option>
                                        <!--<option value="amount"><?php echo currency(); ?></option>-->
                                    </select>                                          
                                   </td>   
                    <td class="col-sm-1">
                    <div id="more_product-btn" class="btn btn-primary btn-labeled fa fa-plus" >&nbsp;
                        <?php echo translate('add_tax_type');?>
                    </div></td>
                          </tr>
                      <span class="btn unit_set"></span>                             
    <div class="form-group btm_border">  
    <label class="col-sm-4 control-label" for="demo-hor-9"><?php echo translate('');?></label>  
<!--     <table align="center" class="group-list col-sm-12" id="group-list"> -->
<table align="center" class="product-list col-sm-12 group-list" id="group-list">
        <thead>
         <th class="col-sm-4"></th>
         <th class="col-sm-2" style="text-align: center;">#</th>
         <th class="col-sm-2"><label class=" control-label" for="demo-hor-3"><?php echo translate('tax');?></label></th>
         <th class="col-sm-1"><label class=" control-label" for="demo-hor-6"><?php echo translate('rate');?></label></th>
         <td class="col-sm-1"></td>
        </thead>
        <tr id="0" hidden="hidden"></tr>
     </table>
    </div>
<script type="text/javascript">
$("#more_product-btn").click(function()
{
    var pid=$(".p").val();
    var pname=$(".chosen-single span").html();
    var rate=$("#tax_type").val();
    var quantity=$("#quantity").val();
    var total=$("#total").val();
        if(pname!='Choose one' )
        {
      if(rate>0)
          {
    var counter = $('#group-list tr:last').attr('id');           
    counter ++;
    var s=document.getElementById(counter);
    var newRow = jQuery('<tr id="'+counter+'"><td class="col-sm-4" ></td><td style="text-align: center;">'+counter+'</td><td><input  class="form-control required" type="text" name="taxcap[][taxtype]" id="p'+counter+'" value="'+pname+'"></td><td ><input type="number" min="0.01" max="99" step=".01" name="taxcap[][taxrate]" id="rate'+ counter +'" value="'+rate+'"  class="form-control " onchange="limtper(this.value,this.id)"></td>'
        + '<td class="col-md-2"><button type="button" class="close" onclick="removeRow('+counter+')"><i class="fa fa-trash"></i></button></td>'
        + '<td><input type="text" name="pid" id="pid'+counter+'" hidden="hidden" value="'+pid+'"></td>');
    jQuery('table#group-list').append(newRow);
        }
    else
        //alert("Give rate");
       { 
           $("#msg1").show();
           $("#msg1").html("Please Give Rate..");
       }      
        }
    else
        { 
          $("#msg").show();
          $("#msg").html("Please select tax type");
        }
            //alert("Please select a category");}
}); 
   $(function()
   {
        $(window).scroll(function(){
        $('#sbTwo option').prop('selected',true);
    });
    });

function removeRow(removeNum) 
{ 
    //alert(removeNum);
    jQuery('#'+removeNum).remove();
}

function totala(c)
{
  var total = Number($('#quantity'+c).val())*Number($('#rate'+c).val());
  $('#total'+c).val(total);
}

function RemoveRow(c)
{
  var i, n, pn,q,t,r,pi, len, tbl;
  //var count = parseInt(document.getElementById('rowCnt').value);
  tbl = document.getElementById('group-list');
  len = tbl.rows.length;
  n = 1; // assumes ID numbers start at zero
  for (i = 1; i <= len; i++) 
  {
    pn = document.getElementById("p" + i);
    q  = document.getElementById("rate" + i);
    t  = document.getElementById("quantity" + i);
    r  = document.getElementById("pid" + i);
    pi = document.getElementById("total" + i);
    if (cb && en && ed) {
      if (cb.checked) { 
        tbl.deleteRow(n);
        count--;
      }
      else {
        cb.id = "chkbox" + n;
        en.id = "empName" + n;
        ed.id = "empDesgn" + n;
        ++n;
      }
    }
  }
  //document.getElementById('rowCnt').value = count;  
}
</script>

<!--                             <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-9"><?php echo translate('product_tax');?></label>
                                <div class="col-sm-4">
                                    <input type="number" name="tax" id="demo-hor-9" min='0' step='.01' placeholder="<?php echo translate('product_tax');?>" class="form-control">
                                </div>
                                <div class="col-sm-1">
                                    <select class="demo-chosen-select" name="tax_type">
                                        <option value="percent">%</option>
                                        <!-- <option value="amount"><?php echo currency(); ?></option> -->
                                  <!--  </select>
                                </div>
                                <span class="btn unit_set"></span>
                            </div> -->
<!-- Regionvise tax  -->                            
                <div class="form-group btm_border" style="display:none">
                      <label class="col-sm-4 control-label" for="demo-hor-9"><?php echo translate('region_wise_tax');?></label>
                      <table align="center" class="col-sm-12 product-list">
                      <tr><td class="col-sm-4"></td>
                          <td class="col-sm-2" id="product"> 
                            <span class="p1"></span>
                            <select id="scountry1" name="scountry" class="form-control p1" onChange="loadState(this)">
                              <option value="">Select Country..</option>
                                <?php
                                  $cntry=$this->db->get_where('fed_country',array('status'=>'1'))->result_array();
                                  foreach($cntry as $cntry_details)
                                    {
                                      echo "<option value='".$cntry_details[country_id]."'>".$cntry_details[name]."</option>";
                                    }
                                ?>
                            </select>
                            <span id="msg11" style="display:none;color:red;">fdfdf</span>
                          </td> 
                          <td class="col-sm-2">
<input type="number" name="tax1" id="tax1" min='0' step='.01' max="99" placeholder="<?php echo translate('product_tax');?>" class="form-control" onchange="limtper(this.value,this.id)">
                           <span id="msg11" style="display:none;color:red;"></span>  
                            <span id="msg21" style="display:none;color:red;">fdfdf</span>           
                          </td>
                          <td class="col-sm-1">
                          <select class="demo-chosen-select" name="tax_type">
                            <option value="percent">%</option>
                            <!-- <option value="amount"><?php echo currency(); ?></option> -->
                          </select>     
                          </td>   
                          <td class="col-sm-2">
                          <div id="more_product-btn1" class="btn btn-primary btn-labeled fa fa-plus">&nbsp;
                          <?php echo translate('add_region_wise_tax');?>
                          </div>
                          </td>
                      </tr>
                        <span class="btn unit_set"></span>

                        <div class="form-group btm_border">
        <table align="center" class="group-list1 col-sm-12 " id="group-list1">
        <thead>
         <th class="col-sm-4"></th>
         <th class="col-sm-2" style="text-align: right;">#</th>
         <th class="col-sm-2"><label class=" control-label" for="demo-hor-3"><?php echo translate('country');?></label></th>
         <th class="col-sm-1"><label class=" control-label" for="demo-hor-6"><?php echo translate('rate');?></label></th>
         <td class="col-sm-1"></td>
        </thead>
        </table>
        <input type='text'  hidden="hidden"  id='rowCnt' value='0'>
                        </div>        

<script type="text/javascript">

$("#more_product-btn1").click(function()
{
    //alert("in");
    $("#msg21").hide();
    $("#msg11").hide();
    var pid =$("#scountry1").val();
    var pname=$("#scountry1 option:selected").text();
    var rate=$("#tax1").val();
    tbli= document.getElementById('group-list1');
    var rc=tbli.rows.length;
    var ain=1;
    for (var i =1 ; i<rc; i++) 
    {
        if(pid == $('#rid'+i).val())
        {
           var ain=0;
        }
    }  

  if(pname!='Select Country..' )
        {
      if(rate>0 && ain==1)
        {
    tbl = document.getElementById('group-list1');
    var counter=tbl.rows.length;
    pc=counter-1;
    $("#rmv1"+pc).hide();
    $("#rowCnt").val(counter);
    var newRow = jQuery('<tr id="c'+counter+'"><td class="col-sm-4" ></td><td  class="col-sm-2" style="text-align: right;">'+counter+'</td>' +
'<td><input readonly="readonly" class="form-control required" type="text" name="r[]" id="r'+counter+'" value="'+pname+'"></td>' +
'<td><input type="number" min="0.01" max="99" step=".01" name="trate[]" id="trate'+counter +'" value="'+rate+'"  class="form-control " onchange="limtper(this.value,this.id)"></td> '+
'<td class="col-md-2" style="float: left;padding-left: 50px;"><button type="button" id="rmv1'+counter+'" class="close" onclick="removeRow1('+counter+')"><i class="fa fa-trash"></i></button></td>'+
'<td><input type="text" name="rid[]" id="rid'+counter+'" hidden="hidden" value="'+pid+'"></td>');
    jQuery('table.group-list1').append(newRow);
        }


    else 
      { 
        if(rate==0)
        {
           $("#msg21").show();
           $("#msg21").html("Please Give Rate..");
         }
          else if(ain==0)
        { 
           $("#msg11").show();
           $("#msg11").html("country is alredy selected you can change the tax..");
           }
      }
        }
    else
        { 
        $("#msg11").show();
        $("#msg11").html("Please select a country");
        }
}); 
   $(function()
   {
    $(window).scroll(function(){
      $('#sbTwo option').prop('selected',true);
    });
    });

function removeRow1(removeNum) 
{ 
    //alert(removeNum);
    jQuery('#c'+removeNum).remove();
    pc=removeNum-1;
    $("#rmv1"+pc).show();
    tbl = document.getElementById('group-list1');
    len = tbl.rows.length;
    $("#rowCnt").val(len);
}
</script>
<!-- Regionvise tax end -->
						  
						  
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-10">
									<?php echo translate('product_discount');?>
								</label>
                                <div class="col-sm-4">
                                    <input type="number" name="discount" id="demo-hor-10" min='0' step='.01' placeholder="<?php echo translate('product_discount');?>" class="form-control per">
                                </div>
                                <div class="col-sm-2">
                                    <select class="demo-chosen-select " name="discount_type">
                                        <option value="percent">%</option>
                                        <!-- <option value="amount"><?php echo currency(); ?></option> -->
                                    </select>
                                </div>
                                <span class="btn unit_set"></span>
                           </div>
						  
                        </div>
                    
                    
                        <div id="customer_choice_options" class="tab-pane fade">
                            <div class="form-group btm_border">
                                <h4 class="text-thin text-center"><?php echo translate('customer_choice_options'); ?></h4>
                            </div>

                            <div class="form-group btm_border">
								<label class="col-sm-4 control-label" for="demo-hor-1">
									<?php echo translate('related_products');?>
								</label>
                                <div class="col-sm-6">
                  					<?php 
                        //echo $this->crud_model->select_html('product','relatedproducts','title ','add','demo-cs-multiselect'); 
                  					?>
									<select data-placeholder="<?php echo translate('choose_product');?>" name='relatedproducts[]' class="demo-cs-multiselect" multiple tabindex="2">
                                  <?php
                                      $products = $this->db->get('product')->result_array();
                                      foreach ($products as $row) 
                                      {
                                          if($this->crud_model->is_added_by('product',$row['product_id'],$this->session->userdata('vendor_id')))
                                          {
                                            ?>
                                            <option value="<?php echo $row['product_id']; ?>">
                                                <?php echo $row['title']; ?>
                                            </option>
                                             <?php
                                          }
                                      }
                                  ?>
                                </select>
                                </div>
                            </div>

                          <div class="form-group btm_border">
                            <label class="col-sm-4 control-label" for="demo-hor-13">
								<?php echo translate('Shipping_info'); ?>
							 </label>
                            <div class="col-sm-6">
                              <textarea rows="5" class="form-control" name="shipping_info" data-height="100" data-name="shipping_info" placeholder="Shipping Info"></textarea>
                            </div>
                          </div>  

                          <div class="form-group btm_border">
                            <label class="col-sm-4 control-label" for="demo-hor-13">
								<?php echo translate('More_info'); ?>
							</label>
                            <div class="col-sm-6">
                              <textarea rows="5" class="form-control" name="more_info" data-height="100" data-name="more_info" placeholder="More Info"></textarea>
                            </div>
                          </div> 

                           <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-14">
									<?php echo translate('color'); ?>
								</label>
                                <div class="col-sm-4"  id="more_colors">
                                  <!-- <div class="col-md-12" style="margin-bottom:8px;">
                                      <div class="col-md-10">
                                          <div class="input-group demo2">
                                               <input type="text" value="#ccc" name="color[]" class="form-control" />
                                               <span class="input-group-addon"><i></i></span>
                                            </div>
                                      </div>
                                      <span class="col-md-2">
                                          <span class="remove_it_v rmc btn btn-danger btn-icon icon-lg fa fa-trash" ></span>
                                      </span>
                                  </div> -->
                                </div>
                                <div class="col-sm-2">
                                    <div id="more_color_btn" class="btn btn-primary btn-labeled fa fa-plus">
                                        <?php echo translate('add_more_colors');?>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="more_additional_options"></div>
                            <div class="form-group btm_border" style="display:none">
                                <label class="col-sm-4 control-label" for="demo-hor-inputpass"></label>
                                <div class="col-sm-6">
                                    <h4 class="pull-left">
                                        <i><?php echo translate('if_you_need_more_choice_options_for_customers_of_this_product_,please_click_here.');?></i>
                                    </h4>
                                    <div id="more_option_btn" class="btn btn-mint btn-labeled fa fa-plus pull-right">
                                    <?php echo translate('add_customer_input_options');?></div>
                                </div>
                            </div>
                        </div>


                        <div id="product_details" class="tab-pane fade active in">
        
                            <div class="form-group btm_border">
                                <h4 class="text-thin text-center"><?php echo translate('product_details'); ?></h4>                            
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1">
									<?php echo translate('product_name');?>
								</label>
                                <div class="col-sm-6">
                                    <input type="text" name="title" id="demo-hor-1" placeholder="<?php echo translate('product_name');?>" class="form-control required">
                                </div>
                            </div>

                            <div class="form-group btm_border">
                              <label class="col-sm-4 control-label" for="demo-hor-1">
								  <?php echo translate('product_code');?>
							  </label>
                              <div class="col-sm-6">
                                <input type="text" name="product_code" id="product_code" placeholder="<?php echo translate('product_code');?>" class="form-control required" >
                                 <div id="email_note_pc" style="color:red"></div>
                              </div>
                            </div>

                            <div class="form-group btm_border">
                              <label class="col-sm-4 control-label" for="demo-hor-11">
								  <?php echo translate('meta_tags');?>
								</label>
                                <div class="col-sm-6">
                                    <input type="text" name="tag" data-role="tagsinput" placeholder="<?php echo translate('tags');?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-11">
									<?php echo translate('meta_description');?>
								</label>
                                <div class="col-sm-6">
                                    <textarea rows="4" class="form-control" name="meta_description" data-height="100" id="meta_descrt" data-name="meta_description" placeholder="Meta Description"></textarea>
                                </div>
                            </div>

                            <div class="form-group btm_border" style="display:none">
                              <label class="col-sm-4 control-label" for="demo-hor-26">
								  <?php echo translate('product_type');?>
                              </label>
                              <div class="col-sm-6">
                                <input type="text" name="item_type" id="demo-hor-26" placeholder="<?php echo translate('product_type'); ?>" class="form-control">
                              </div>
                            </div>

                            <div class="form-group btm_border">
                              <label class="col-sm-4 control-label" for="demo-hor-1">
								  <?php echo translate('product_condition');?></label>
                              <div class="col-sm-6">
                                <select class="form-control required" name="product_type">
                                 <option value="">Select Type</option>
                                 <option value="0">New</option>
                                 <option value="1">Refurbished</option>
                                </select>
                              </div>
                            </div>
                            
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-2">
									<?php echo translate('category');?>
								</label>
                                <div class="col-sm-6">
                                    <?php 
										echo $this->crud_model->select_html('category','category','category_name','add','demo-chosen-select required','','','','get_cat'); 
									?>
                                </div>
                            </div>
                            
                            <div class="form-group btm_border" id="sub" style="display:none;">
                                <label class="col-sm-4 control-label" for="demo-hor-3">
									<?php echo translate('sub-category');?>
								</label>
                                <div class="col-sm-6" id="sub_cat">
                                </div>
                            </div>
                            
                            <div class="form-group btm_border" id="brn" style="display:none;">
                                <label class="col-sm-4 control-label" for="demo-hor-4">
									<?php echo translate('brand');?>
								</label>
                                <div class="col-sm-6" id="brand">
                                	<?php 
									echo $this->crud_model->select_html('brand','brand','name','add','demo-chosen-select ','','','',''); 
									?>
                                </div>
                            </div>

                            <div class="form-group btm_border" style="display:none">
                              <label class="col-sm-4 control-label" for="demo-hor-2">
								  <?php echo translate('equipment');?>
							  </label>
                              <div class="col-sm-6">
                                <?php echo $this->crud_model->select_html('equipment','equipment','equipment_name','add','demo-chosen-select ','','','','get_eqi'); ?>
                              </div>
                            </div>

                            <div class="form-group btm_border" id="subeq"  style="display:none;"> 
                              <label class="col-sm-4 control-label" for="demo-hor-3">
								  <?php echo translate('sub-equipment');?>
								</label>
                                <div class="col-sm-6" id="sub_eqi">
                                </div>
                            </div>
                            
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-5">
									<?php echo translate('unit');?>
								</label>
                                <div class="col-sm-6">
								 <select  name="unit" id="demo-hor-5" class="form-control unit  " >
								  <option value="">Select unit</option>
									<?php
									  $umo=$this->db->get_where('uom')->result_array();
									  foreach($umo as $um1)
										{
							echo "<option value='".$um1['UOM_CODE']."'>".$um1['UOM_NAME']."(".$um1['UOM_CODE'].")</option>";
										}
									?>
  								</select>

                                </div>
                            </div>
              
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-12">
									<?php echo translate('images');?>
								</label>
                                <div class="col-sm-6">
                                <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file');?>
                                    <input type="file" multiple name="images[]" onchange="preview(this);" id="demo-hor-12" class="form-control required">
                                    </span>
                                    <br><br>
                                    <em>( Image size : 400 X 400 )</em>
                                    <span id="previewImg" ></span>
                                </div>
                            </div>
        
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-11">
									<?php echo translate('product_is_a_file');?> (<?php echo translate('video');?>,<?php echo translate('audio');?>,<?php echo translate('software');?> <?php echo translate('etc.');?>)
								</label>
                                <div class="col-sm-6">
                                    <input id='swp' type="checkbox" name="download" value="ok" />
                                </div>
                            </div>
                                            
                            <div class="form-group btm_border" id="product_file" style="display:none;">
                                <label class="col-sm-4 control-label" for="demo-hor-12">
									<?php echo translate('product_file');?>
								</label>
                                <div class="col-sm-6">
                                <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file');?> (<?php echo translate('compressed');?> *.zip/*.rar)
                                    <input type="file" name="product_file" onchange="details(this);" id="demo-hor-12" class="form-control"  accept='application/zip,application/rar'>
                                    </span>
                                    <br><br>
                                    <span>
                                        <?php echo translate('maximum_size').' : '.ini_get("upload_max_filesize").'B'; ?>
                                    </span>
                                    <span id="previewdetails" ></span>
                                </div>
                            </div>

                            <script>
                                new Switchery(document.getElementById('swp'), {color:'rgb(100, 189, 99)', secondaryColor: '#cc2424', jackSecondaryColor: '#c8ff77'});
                                var changeCheckbox = document.querySelector('#swp');
                                changeCheckbox.onchange = function() {
                                   if(changeCheckbox.checked){
                                        $('#product_file').show('fast');
                                   } else {
                                        $('#product_file').hide('fast');
                                   }
                               }
                               function details(now){

                               }
                            </script>

                            <div class="form-group btm_border">
                            <label class="col-sm-4 control-label" for="demo-hor-26">
								<?php echo translate('Brochure (pdf)');?></label>
                            <div class="col-sm-6">
                              <span>
                              <input type="file" name="product_brochure"  id="demo-hor-25" class="form-control"  accept='application/pdf'>
                              </span><br>
                              <span>
                                <?php echo translate('maximum_upload_size').' : '.ini_get("upload_max_filesize").'B'; ?>
                              </span>
                              <span id="previewdetails" ></span>
                            </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-13">
									<?php echo translate('short_description'); ?>
								</label>
                                <div class="col-sm-6">
                                    <textarea rows="4" class="form-control" name="short_description" data-height="100" data-name="short_description"></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-13">
									<?php echo translate('description'); ?>
								</label>
                                <div class="col-sm-6">
                                    <textarea rows="9"  class="summernotes" data-height="200" data-name="description"></textarea>
                                </div>
                            </div>
                            
                            <div id="more_additional_fields"></div>
								<div class="form-group btm_border" style="">
									<label class="col-sm-4 control-label" for="demo-hor-inputpass"></label>
									<div class="col-sm-6">
										<h4 class="pull-left">
											<i><?php echo translate('if_you_need_more_field_for_your_product_,_please_click_here_for_more...');?></i>
										</h4>
										<div id="more_btn" class="btn btn-mint btn-labeled fa fa-plus pull-right">
										<?php echo translate('add_more_fields');?></div>
									</div>
								</div>
                        </div>
                    </div>
                </div>

                <span class="btn btn-purple btn-labeled fa fa-arrow-right pull-right" onclick="next_tab()"><?php echo translate('next'); ?></span>
                <span class="btn btn-purple btn-labeled fa fa-arrow-left pull-right" onclick="previous_tab()"><?php echo translate('previous'); ?></span>
        
            </div>
            <div class="panel-footer">
            
                <div class="row">
                    <div class="col-md-11">
                        <span class="btn btn-purple btn-labeled fa fa-refresh pro_list_btn pull-right" 
                            onclick="ajax_set_full('add','<?php echo translate('add_product'); ?>','<?php echo translate('successfully_added!'); ?>','product_add',''); "><?php echo translate('reset');?>
                        </span>
                    </div>
                    
                    <div class="col-md-1">
                        <span class="btn btn-success btn-md btn-labeled fa fa-upload pull-right" onclick="form_submit('product_add','<?php echo translate('product_has_been_uploaded!'); ?>');proceed('to_add');" ><?php echo translate('upload');?></span>
                    </div>
                    
                </div>
            </div>
    
        <?php echo form_close(); ?>
    </div>
</div>

<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js">
</script>

<input type="hidden" id="option_count" value="-1">

<script>
    window.preview = function (input) {
        if (input.files && input.files[0]) {
            $("#previewImg").html('');
            $(input.files).each(function () {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function (e) {
                    $("#previewImg").append("<div style='float:left;border:4px solid #303641;padding:5px;margin:5px;'><img height='80' src='" + e.target.result + "'></div>");
                }
            });
        }
    }

    function other_forms(){}
    
    function set_summer(){
        $('.summernotes').each(function() {
            var now = $(this);
            var h = now.data('height');
            var n = now.data('name');
            now.closest('div').append('<input type="hidden" class="val" name="'+n+'">');
            now.summernote({
                height: h,
                onChange: function() {
                    now.closest('div').find('.val').val(now.code());
                }
            });
            now.closest('div').find('.val').val(now.code());
        });
    }


function set_summeradd()
{
  $('.summernotesadd').each(function() {
   var now = $(this);
   var h = $(this).data('height');
            //var n = $(this).data('name');
   var nh = "ad_field_values[]";
  if ($(this).closest('div').find('.val').length == 0)
  {
   $(this).closest('div').append('<input type="hidden" class="val" name="'+nh+'">');
  }            
  $(this).summernote({
         height: h,
         onChange: function() {
         now.closest('div').find('.val').val(now.code());
         }
       });
      now.closest('div').find('.val').val(now.code());
     });   
}

    function next_tab(){
        $('.nav-tabs li.active').next().find('a').click();                    
    }
    function previous_tab(){
        $('.nav-tabs li.active').prev().find('a').click();                     
    }

    function option_count(type){
        var count = $('#option_count').val();
        if(type == 'add'){
            count++;
        }
        if(type == 'reduce'){
            count--;
        }
        $('#option_count').val(count);
    }

    function set_select(){
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
    }
    
    $(document).ready(function() {
        set_select();
        set_summer();
        createColorpickers();
    });

    function other(){
        set_select();
        
    }
    function get_cat(id){
        //$('#brand').html('');
        $('#sub').hide('slow');
        //$('#brn').hide('slow');
        ajax_load(base_url+'index.php/vendor/product/sub_by_cat/'+id,'sub_cat','other');
        //ajax_load(base_url+'index.php/vendor/product/brand_by_cat/'+id,'brand','other');
        $('#sub').show('slow');
       // $('#brn').show('slow');
    }


    function get_eqi(id)
    {
    $('#subeq').hide('slow');
    ajax_load(base_url+'index.php/vendor/product/sub_by_equi/'+id,'sub_eqi','other');
    $('#subeq').show('slow');
    }

    function get_sub_res(id){}

/*    $(".unit").on('keyup',function(){
        $(".unit_set").html($(".unit").val());
    });*/
    
    $(".unit").on('change',function()
    {
        //console.log($( ".unit option:selected" ).val());
       $(".unit_set").html($(".unit option:selected" ).val());

    });

    function createColorpickers() {
    
        $('.demo2').colorpicker({
            format: 'rgba'
        });
        
    }
    
    $("#more_btn").click(function(){
        $("#more_additional_fields").append(''
            +'<div class="form-group">'
            +'    <div class="col-sm-4">'
            +'        <input type="text" name="ad_field_names[]" class="form-control"  placeholder="<?php echo translate('field_name'); ?>">'
            +'    </div>'
            +'    <div class="col-sm-5">'
            +'        <textarea rows="9"  class="summernotesadd" data-height="100" data-name="ad_field_values[]"></textarea>'
            +'    </div>'
            +'    <div class="col-sm-2">'
            +'        <span class="remove_it_v rms btn btn-danger btn-icon btn-circle icon-lg fa fa-times" onclick="delete_row(this)"></span>'
            +'    </div>'
            +'</div>'
        );
        //set_summer();
        set_summeradd();
    });
    
    $("#more_option_btn").click(function(){
        option_count('add');
        var co = $('#option_count').val();
        $("#more_additional_options").append(''
            +'<div class="form-group" data-no="'+co+'">'
            +'    <div class="col-sm-4">'
            +'        <input type="text" name="op_title[]" class="form-control required"  placeholder="<?php echo translate('customer_input_title'); ?>">'
            +'    </div>'
            +'    <div class="col-sm-5">'
            +'        <select class="demo-chosen-select op_type required" name="op_type[]" >'
            +'            <option value="">(none)</option>'
            +'            <option value="text">Text Input</option>'
            +'            <option value="single_select">Dropdown Single Select</option>'
            +'            <option value="multi_select">Dropdown Multi Select</option>'
            +'            <option value="radio">Radio</option>'
            +'        </select>'
            +'        <div class="col-sm-12 options">'
            +'          <input type="hidden" name="op_set'+co+'[]" value="none" >'
            +'        </div>'
            +'    </div>'
            +'    <input type="hidden" name="op_no[]" value="'+co+'" >'
            +'    <div class="col-sm-2">'
            +'        <span class="remove_it_o rmo btn btn-danger btn-icon btn-circle icon-lg fa fa-times" onclick="delete_row(this)"></span>'
            +'    </div>'
            +'</div>'
        );
        set_select();
    });
    
    $("#more_additional_options").on('change','.op_type',function(){
        var co = $(this).closest('.form-group').data('no');
        if($(this).val() !== 'text' && $(this).val() !== ''){
            $(this).closest('div').find(".options").html(''
                +'    <div class="col-sm-12">'
                +'        <div class="col-sm-12 options margin-bottom-10"></div><br>'
                +'        <div class="btn btn-mint btn-labeled fa fa-plus pull-right add_op">'
                +'        <?php echo translate('add_options_for_choice');?></div>'
                +'    </div>'
            );
        } else if ($(this).val() == 'text' || $(this).val() == ''){
            $(this).closest('div').find(".options").html(''
                +'    <input type="hidden" name="op_set'+co+'[]" value="none" >'
            );
        }
    });
    
    $("#more_additional_options").on('click','.add_op',function(){
        var co = $(this).closest('.form-group').data('no');
        $(this).closest('.col-sm-12').find(".options").append(''
            +'    <div>'
            +'        <div class="col-sm-10">'
            +'          <input type="text" name="op_set'+co+'[]" class="form-control required"  placeholder="<?php echo translate('option_name'); ?>">'
            +'        </div>'
            +'        <div class="col-sm-2">'
            +'          <span class="remove_it_n rmon btn btn-danger btn-icon btn-circle icon-sm fa fa-times" onclick="delete_row(this)"></span>'
            +'        </div>'
            +'    </div>'
        );
    });
    
    $('body').on('click', '.rmo', function(){
        $(this).parent().parent().remove();
    });

    $('body').on('click', '.rmon', function(){
        var co = $(this).closest('.form-group').data('no');
        $(this).parent().parent().remove();
        if($(this).parent().parent().parent().html() == ''){
            $(this).parent().parent().parent().html(''
                +'   <input type="hidden" name="op_set'+co+'[]" value="none" >'
            );
        }
    });

    $('body').on('click', '.rms', function(){
        $(this).parent().parent().remove();
    });

    $("#more_color_btn").click(function(){
        $("#more_colors").append(''
            +'      <div class="col-md-12" style="margin-bottom:8px;">'
            +'          <div class="col-md-10">'
            +'              <div class="input-group demo2">'
            +'                 <input type="text" value="#ccc" name="color[]" class="form-control" />'
            +'                 <span class="input-group-addon"><i></i></span>'
            +'              </div>'
            +'          </div>'
            +'          <span class="col-md-2">'
            +'              <span class="remove_it_v rmc btn btn-danger btn-icon icon-lg fa fa-trash" ></span>'
            +'          </span>'
            +'      </div>'
        );
        createColorpickers();
    });                

    $('body').on('click', '.rmc', function(){
        $(this).parent().parent().remove();
    });


    $(document).ready(function() {
        $('#length_class_id').change(function(){
            if(this.value == 1){ 
                $('#weight_class_id').find('option').each(function(i,e){
                    if($(e).val() == 1){ $('#weight_class_id').prop('selectedIndex',0); }
                });
            }else{
                $('#weight_class_id').find('option').each(function(i,e){
                    if($(e).val() == 5){ $('#weight_class_id').prop('selectedIndex',1); }
                });
            }
        });
        $('#weight_class_id').change(function(){
            if(this.value == 1){ 
                $('#length_class_id').find('option').each(function(i,e){
                    if($(e).val() == 1){ $('#length_class_id').prop('selectedIndex',0); }
                });
            }else{
                $('#length_class_id').find('option').each(function(i,e){
                    if($(e).val() == 3){ $('#length_class_id').prop('selectedIndex',1); }
                });
            }
        });
        $("form").submit(function(e){
            return false;
        });
    });


//limit percentage

$(".per").change(function()
{
  var a=$(this).val();
  if (a >= 100) 
  {
  var pp=$('select[name="discount_type"]  option:selected').val();
  if(pp=='percent')
    {
  $(this).val("99");
    }
  }
});

/*$(".tper").change(function()
{
  var a=$(this).val();
  if (a >= 100) 
  {
  $(this).val("99");
  }
});*/

function limtper(x,idt)
{
  //alert(x);
  if (x >= 100) 
  {
  $("#"+idt).val("99");
  }
  else if(x <= 0)
  {
    $("#"+idt).val("0.1");
  }
}

//product code existing checking

$("#product_code").blur(function()
{
  prod_codeexi();
});

  
function prod_codeexi()
{
  var email = $("#product_code").val();
    $.post("<?php echo base_url(); ?>index.php/admin/pcode_exists",
    {
      <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
      p_code: email ,
    },
    function(data, status){
      if(data == 'yes')
      {
        $("#email_note_pc").html('*<?php echo translate('This_productcode_already_used..'); ?>');
         $("#product_code").focus();
         $('.btn-success').attr('disabled',true);
      } else if(data == 'no')
      {
        //alert(data);
        $("#email_note_pc").html('');
       $(".btn-success").removeAttr("disabled");
      }
    });
}



$("#pgon").change(function()
{
    var pgon=$("#pgon").val();
    if(pgon=='single')
    {
      $(".groupedp").hide();
      $("#singlep").show();
      $(".singlep").addClass("required");
    }
    else
    {
      $(".singlep").removeClass("required");
      //$(".singlep").val("");
      $("#singlep").hide();
      $(".groupedp").show();
    }
});

function removeRowgp(removeNum) 
{ 
  $.post("<?php echo base_url(); ?>index.php/vendor/gp_product/delete",
    {
      <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
      gp_id: removeNum 
    },
    function(data, status){
      if(data)
      {
        jQuery('#'+removeNum).remove();
      } else 
      {
      }
    });
}  


</script>

<style>
    .btm_border{
        border-bottom: 1px solid #ebebeb;
        padding-bottom: 15px;   
    }
</style>


<!--Bootstrap Tags Input [ OPTIONAL ]-->

