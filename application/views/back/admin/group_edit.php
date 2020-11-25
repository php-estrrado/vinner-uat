<?php
    foreach($product_data as $row){
?>
<div class="row">
    <div class="col-md-12">
        <?php
            echo form_open(base_url() . 'index.php/admin/product_group/update/' . $row['product_id'], array(
                'class' => 'form-horizontal',
                'method' => 'post',
                'id' => 'group_edit',
                'enctype' => 'multipart/form-data'
            ));
        ?>

        <!--Panel heading-->
        <div class="panel-heading">
            <div class="panel-control" style="float: left;">
                <ul class="nav nav-tabs">
                    <li class="active">
                      <a data-toggle="tab" href="#product_details"><?php echo translate('general'); ?>
                      </a>
                    </li>
                    <li>
                      <a data-toggle="tab" href="#business_details"><?php echo translate('data'); ?>
                      </a>
                    </li>
                    <li>
                      <a data-toggle="tab" href="#customer_choice_options"><?php echo translate('attributes'); ?></a>
                    </li>
                </ul>
            </div>
        </div>

        <!--Panel body-->
        <div class="panel-body">
         <div class="tab-base">
        <!--Tabs Content-->                    
         <div class="tab-content">

                        <div id="customer_choice_options" class="tab-pane fade">

                        <div class="form-group btm_border">
                            <h4 class="text-thin text-center"><?php echo translate('customer_choice_options'); ?></h4>                            
                        </div>

                        <div class="form-group btm_border">
                            <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('Related_products');?>
                            </label>
                            <div class="col-sm-6">
                            <?php 
                    echo $this->crud_model->select_html('product','relatedproducts','product_code','edit','demo-cs-multiselect',$row['related_products']); 
                  ?>
                            </div>
                        </div> 
                        <div id="more_additional_options">
                            <?php
                            $all_op = json_decode($row['options'],true);
                                //var_dump($all_op);
                                $r = 0;
                                if(!empty($all_op)){
                                    foreach($all_op as $i=>$row1){
                                        $r = 1;
                            ?> 
                                <div class="form-group" data-no="<?php echo $row1['no']; ?>">
                                    <div class="col-sm-4">
                                        <input type="text" name="op_title[]" value="<?php echo $row1['title']; ?>" class="form-control required"  placeholder="<?php echo translate('customer_input_title'); ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <select class="demo-chosen-select op_type required" name="op_type[]" >
                                            <option value="" <?php if($row1['type'] == ''){ echo 'selected'; } ?> >(none)</option>
                                            <option value="text" <?php if($row1['type'] == 'text'){ echo 'selected'; } ?> >Text Input</option>
                                            <option value="single_select" <?php if($row1['type'] == 'single_select'){ echo 'selected'; } ?> >Dropdown Single Select</option>
                                            <option value="multi_select" <?php if($row1['type'] == 'multi_select'){ echo 'selected'; } ?> >Dropdown Multi Select</option>
                                            <option value="radio" <?php if($row1['type'] == 'radio'){ echo 'selected'; } ?> >Radio</option>
                                        </select>
                                        <div class="col-sm-12 options">
                                        <?php
                                            if($row1['type'] == 'text' || $row1['type'] == ''){
                                        ?>
                                            <input type="hidden" name="op_set<?php echo $row1['no']; ?>[]" value="none" >
                                        <?php
                                            } else {
                                        ?>
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 options margin-bottom-10">
                                                <?php foreach ($row1['option'] as $key => $row2) { ?>
                                                    <div>
                                                        <div class="col-sm-10">
                                                          <input type="text" name="op_set<?php echo $row1['no']; ?>[]" value="<?php echo $row2; ?>" class="form-control required"  placeholder="<?php echo translate('option_name'); ?>">
                                                        </div>
                                                        <div class="col-sm-2">
                                                          <span class="remove_it_n rmon btn btn-danger btn-icon btn-circle icon-sm fa fa-times" onclick="delete_row(this)"></span>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                </div>
                                                <br>
                                            <div class="btn btn-mint btn-labeled fa fa-plus pull-right add_op">
                                            <?php echo translate('add_options_for_choice');?></div>
                                            </div>

                                        <?php
                                            }
                                        ?>
                                        </div>
                                    </div>
                                    <input type="hidden" name="op_no[]" value="<?php echo $row1['no']; ?>" >
                                    <div class="col-sm-2">
                                        <span class="remove_it_o rmo btn btn-danger btn-icon btn-circle icon-lg fa fa-times" onclick="delete_row(this)"></span>
                                    </div>
                                </div>
                            <?php
                                    }
                                }
                            ?> 
                         </div>
                          <div class="form-group btm_border">
                            <label class="col-sm-4 control-label" for="demo-hor-inputpass"></label>
                             <div class="col-sm-6">
                                <h4 class="pull-left">
                                <i><?php echo translate('if_you_need_more_choice_options_for_customers_of_this_product_,please_click_here.');?></i>
                                </h4>
                                <div id="more_option_btn" class="btn btn-mint btn-labeled fa fa-plus pull-right">
                                <?php echo translate('add_customer_input_options');?>
                                </div>
                             </div>
                          </div>
                        </div>

<div id="business_details" class="tab-pane fade">

    <div class="form-group btm_border">
        <h4 class="text-thin text-center"><?php echo translate('data'); ?></h4>
    </div>                       
                           
    <div class="form-group btm_border">
    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('model');?></label>
    <div class="col-sm-6">
    <input type="text" name="model" id="demo-hor-6.1" class="form-control required" placeholder="<?php echo translate('model');?>"  value="<?php echo $row['model']; ?>">
    </div>
    </div>

    <div class="form-group btm_border">
    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo "HS Code";?></label>
    <div class="col-sm-6">
    <input type="text" name="sku" id="demo-hor-6.2" placeholder="<?php echo "HS code";?>" class="form-control" value="<?php echo $row['sku']; ?>">
    </div>
    </div>

    <div class="form-group btm_border">
    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo "MPN";?></label>
    <div class="col-sm-6">
    <input type="text" name="mpn" id="demo-hor-6.3" placeholder="<?php echo "MPN";?>" class="form-control"   value="<?php echo $row['mpn']; ?>">
    </div>
    </div>
    <div class="form-group btm_border">
    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo "DG product";?></label>
    <div class="col-sm-6">
    <div class="radio" id="dg" >
    <label><input type="radio" id="dyes" name="dgradio" value="1" <?php if($row['dg']==1){?> checked=" <?php echo "checked";}?>" >Yes</label>
    <label><input type="radio" id="dno" name="dgradio"  value="0" <?php if($row['dg']==0){?> checked=" <?php echo "checked";}?>">No</label>
    </div>
    </div>
    </div>
                            
    <div class="form-group btm_border">
        <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo "Requires Shipping";?>
        </label>
        <div class="col-sm-6">
            <div class="radio" id="req_ship" >
             <label><input type="radio" id="syes" name="optradio" <?php if($row['shipping_status']==1){ echo 'checked="checked"'; }?>" value="1" checked="ckecked">Yes</label>
             <label><input type="radio" id="sno" name="optradio" <?php if($row['shipping_status']==0){ echo 'checked="checked"'; }?> value="0">No
             </label>
            </div>
        </div>
    </div>
    
    <div class="form-group btm_border">
     <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo "Product Location";?>
     </label>
     <div class="col-sm-6">
      <input type="text" name="location" class="form-control required" placeholder="Location" value="<?php echo $row['location']; ?>">
     </div>
    </div>

    <div class="form-group btm_border">
       <label class="col-sm-4 control-label" for="demo-hor-11"><?php echo translate('tags');?></label>
        <div class="col-sm-6">
         <input type="text" name="tag" data-role="tagsinput" placeholder="<?php echo translate('tags');?>" value="<?php echo $row['tag']; ?>" class="form-control">
        </div>
    </div>

    <div class="form-group btm_border">
     <label class="col-sm-4 control-label" for="demo-hor-9"><?php echo translate('product_tax');?>
     </label>
     <table align="center" class="product-list col-sm-12">
        <tr>
            <td class="col-sm-4"></td>
            <td class="col-sm-2" id="tax"> 
            <?php 
                echo $this->crud_model->select_html('tax','tax','tax_type','add','form-control  demo-chosen-select','','','','get_pro_res'); ?>
                <span id="msg" style="display:none;color:red;">fdfdf</span>
            </td> 
            <td class="col-sm-2">
                <input type="number" name="tax_type-t" id="tax_type-t" min='0' step='.01' placeholder="<?php echo translate('product_tax');?>" class="form-control" style="margin-top: -15px;" >
                <span id="msg1" style="display:none;color:red;"></span>  
            </td>
            <td class="col-sm-1">
                <select class="demo-chosen-select" name="tax_amount">
                <option value="percent">%</option>
                </select>     
            </td>   
            <td class="col-sm-1"><div id="more_tax-btn" class="btn btn-primary btn-labeled fa fa-plus" >&nbsp;
            <?php echo translate('add_tax_type');?> </div>
            </td>
        </tr>
        <span class="btn unit_set"></span>
     </table>                       
     <table align="center" class="group-list col-sm-12" id="group-list-t">
                            <thead>
                            <th class="col-sm-4"></th>
                            <th class="col-sm-2" style="text-align: center;">#</th><th class="col-sm-2"><label class=" control-label" for="demo-hor-3"><?php echo translate('tax');?></label></th>
                            <th class="col-sm-1"><label class=" control-label" for="demo-hor-6"><?php echo translate('rate');?></label></th>
                            <td></td>
                            </thead>

                            <tr id="0" hidden="hidden"></tr><?php 
                                $prid=$row['product_id'];
                                $this->db->select("tax_info");
                                $this->db->from('product');
                                $this->db->where('product_id = '.$prid);
                                $query = $this->db->get();
                                $tax_db= $query->result_array();
                                $json=$tax_db[0]['tax_info'];
                                $tax_type=json_decode($json,true);
                                $tot_rate=0;
                                $i=0;
                                $j=0;
                                foreach($tax_type as $type)
                                {
                                    $tot_type= $type['taxtype'];
                                    $tot_rate=$type['taxrate'];
                                    if($tot_type!="")
                                    {
                                        $ar[$i]['taxtype']=$type['taxtype'];
                                        $i++;
                                    }
                                    elseif($tot_rate!="")
                                    {
                                        $ar[$j]['tot_rate']=$type['taxrate'];
                                        $j++; 
                                    }
                                }
                            $fl=1;
                            foreach($ar as $final_rate)
                            {
                                ?>
                            <tr id="<?php echo $fl; ?>">
                            <td class="col-sm-4"></td>
                            <td class="tac"><?php echo $fl; ?></td>
                            <td><input class="form-control required" type="text" name="taxcap[][taxtype]" id="p<?php echo $fl; ?>" value="<?php echo $final_rate['taxtype']; ?>"></td>
                            <td><input type="number" name="taxcap[][taxrate]" id="rate<?php echo $fl; ?>" value="<?php echo $final_rate['tot_rate']; ?>" class="form-control"></td>
                            <td><input type="text" name="pid" id="pid<?php echo $fl; ?>" hidden="hidden" value="<?php echo $final_rate['tot_rate']; ?>"></td>
                            <td class="text-center"><button type="button" class="close" onclick="removeRow(<?php echo $fl; ?>)"><i class="fa fa-trash"></i></button></td></tr>

                            <?php
                                $fl++;
                            }

                                ?>
     </table>
    </div>


<!--Region wise tax-->
 <div class="form-group btm_border">
    <label class="col-sm-4 control-label" for="demo-hor-9"><?php echo translate('region_wise_tax');?>
    </label>
    <table align="center" class="col-sm-12 product-list">
        <tr>
        <td class="col-sm-4"></td>
        <td class="col-sm-2" id="product"> 
        <span class="p1"></span>
        <select id="scountry1" name="scountry" class="form-control p1  demo-chosen-select" onChange="loadState(this)">
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
        <input type="number"  name="tax1" id="tax1" min='0' step='.01' max='99' onchange="limtper(this.value,this.id);" class="form-control" placeholder="<?php echo translate('product_tax');?>"  >
        <span id="msg11" style="display:none;color:red;"></span>  
        <span id="msg21" style="display:none;color:red;">fdfdf</span>           
        </td>
        <td class="col-sm-1">
        <select class="demo-chosen-select" name="tax_type">
        <option value="percent">%</option>
        </select>     
        </td>   
        <td class="col-sm-2"><div id="more_product-btn1" class="btn btn-primary btn-labeled fa fa-plus">&nbsp;
        <?php echo translate('add_region_wise_tax');?>
       </div></td>
        </tr>
        <span class="btn unit_set"></span>
    <div class="form-group btm_border">     
        <table align="" class="group-list1 col-sm-12 t1" id="group-list1">
            <thead>
            <th class="col-sm-4"></th>
            <th class='col-sm-1' style="text-align: center;">#</th>
            <th class="col-sm-2"><label class="col-sm-6 control-label" for="demo-hor-3"><?php echo translate('tax');?></label></th>
            <th class="col-sm-2"><label class="col-sm-3 control-label" for="demo-hor-6"><?php echo translate('rate');?></label></th>
            <td></td>
            </thead>
            <?php
            $prid=$row['product_id'];
            $reg_tax = $this->db->get_where('region_tax', array('product_id' => $prid ))->result_array();    
            $plist="";
            $counter=1;
                foreach ($reg_tax  as $row2) 
                {   
                    $cid=$row2['country_id'];
                    $trate= $row2['tax_amount'];
            $this->db->select('name');
            $this->db->from('fed_country');
            $this->db->where('country_id = '.$cid);
            $query = $this->db->get();
            $c_na= $query->result_array();
            $cname=$c_na[0]['name'];
                $plist="<tr id='c".$counter."'><td class='col-sm-4'></td><td class='col-sm-1' style='text-align: center;' ><div id='sl".$counter."' value=''>".$counter."</div></td><td><input readonly='readonly' class='form-control ' type='text' name='r[]' id='r".$counter."' value='".$cname."'></td><td><input type='number' step='.01' min='0.01' max='99' onchange='limtper(this.value,this.id);' name='trate[]'' id='trate".$counter."' value='".$trate."''  class='form-control'></td>
                <td class='col-md-2'>
                <button type='button' style='float: none !important;' id='rmv1".$counter."' class='close' onclick='removeRow1(".$counter.")'><i class='fa fa-trash'></i></button>
                </td>
                <td><input type='text' name='rid[]'' id='rid".$counter."' hidden='hidden' value='".$cid."'></td></tr>";
                            
                echo $plist;
                $counter=$counter+1;

                }
            ?>
        </table> <input type='text'  hidden="hidden"  id='rowCnt' value='0'>
    </div>

<script type="text/javascript">

$(document).ready(function() 
{
    tbli= document.getElementById('group-list1');
    var rc=tbli.rows.length;
    $("#rowCnt").val(rc);
    rc=rc-1;
    for (var i =1 ; i<rc; i++) 
    {
       
            $("#rmv1"+i).hide();
    }  
    });

$("#more_product-btn1").click(function()
{
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

    var newRow = jQuery('<tr id="c'+counter+'"><td class="col-sm-4"></td><td class="col-sm-1" style="text-align: center;"><div id="sl'+counter+'" value="">'+counter+'</div></td>' +
'<td><input readonly="readonly" class="form-control " type="text" name="r[]" id="r'+counter+'" value="'+pname+'"></td>' +
'<td><input type="number" name="trate[]" id="trate'+counter +'" value="'+rate+'"  class="form-control"></td> '+
'<td class="md-2"><button style="float: none !important;" type="button" id="rmv1'+counter+'" class="close" onclick="removeRow1('+counter+')"><i class="fa fa-trash" style="padding-left: 25px;"></i></button></td>/tr>'+
'<td><input type="text" name="rid[]" id="rid'+counter+'" hidden="hidden" value="'+pid+'"></td>');

    jQuery('table.group-list1').append(newRow);
        }
    else 
      { 
        if(rate==0){
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
   $(function(){
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
 <!--/Region wise tax--> 



</div>

            <div id="product_details" class="tab-pane fade active in">
                <div class="form-group btm_border">
                    <h4 class="text-thin text-center"><?php echo translate('Group_details'); ?></h4>
                </div>

                <div class="form-group btm_border">
                    <label class="col-sm-4 control-label" for="demo-hor-1">
                        <?php echo translate('group_name');?>
                    </label>
                    <div class="col-sm-6">
                    <input type="text" name="title" id="demo-hor-1" class="form-control required" value="<?php echo $row['title']; ?>" placeholder="<?php echo translate('group_title');?>" >
                    </div>
                </div>     

                <div class="form-group btm_border">
                    <label class="col-sm-4 control-label" for="demo-hor-1">
                        <?php echo translate('product_code');?>
                    </label>
                    <div class="col-sm-6">
                        <input type="text" name="product_code" id="product_code" value="<?php echo $row['product_code']; ?>" placeholder="<?php echo translate('product_code');?>" class="form-control required">
                        <div id="email_note" style="color:red">
                        </div>
                    </div>
                    <input type="text" id="d_prod_code" style="visibility: hidden;" value="<?php echo $row['product_code']; ?>" >
                </div>

                <div class="form-group btm_border">
                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('product_type');?>
                    </label>
                    <div class="col-sm-6">
                     <input type="text" name="item_type" id="demo-hor-5" placeholder="<?php echo translate('product_type'); ?>" class="form-control required" value="<?php echo $row['item_type']; ?>">
                    </div>
                </div>

                <div class="form-group btm_border">
                  <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('product_condition');?>
                  </label>
                  <div class="col-sm-6">
                        <input type="text" class="form-control " readonly="readonly" name="product_type" id="product_type" value="<?php if($row['product_type']=='0')
                        {
                            echo "New";
                        } 
                        else
                        {
                            echo "Refurbished";
                        }?>" placeholder="<?php echo translate('product_type');?>" >
                  </div>
                </div>

                <div> 
                 <?php /* <h5 class="text-thin text-center"><?php //echo translate('Add_Products'); ?></h5> */ ?>
                 <button class="btn btn-primary btn-labeled fa fa-plus-circle " 
                  onclick="ajax_modal('gp_add','<?php echo translate('add_product'); ?>','<?php echo translate('successfully_added!');?>','gp_add','')">
                 <?php echo translate('add_Products');?>
                 </button>
                </div>

        <div class="cart_list">   

        <div class="form-group btm_border">
        <table align="center" class="group-list " id="group-list">
            <thead>
            <th ></th><th><label class="col-sm-6 control-label" for="demo-hor-3"><?php echo translate('product');?></label></th>
            <th><label class="col-sm-4 control-label" for="demo-hor-4"><?php echo translate('quantity');?></label></th>
            <td></td>

            <td></td>
            </thead>
            <!-- <tr id="0" hidden="hidden"></tr> -->
        <?php
                $products = $this->crud_model->get_groupProucts_by_id($row['product_id']);
                $plist="";
                $counter=1;
                $totalc=0;
                $tcount= count($products);
                foreach ($products as $row2) 
                {   
                    $name = $row2['product_name']; 
                    $qty=$row2['qty'];
                    $rate= $this->crud_model->get_type_name_by_id('product', $row2['product_id'], 'sale_price');
                    $total=$rate*$qty;
                    $plist="<tr id=".$row2['product_id'].">
<td><div id=".$counter." value=''><input type='hidden' name='prd-id[]' value='".$row2['product_id']."' /></div></td>
<td><input readonly='readonly' class='form-control required' type='text' name='p[]'' id='pcounter' value='".$name."'></td>
<td><input type='number' name='quantity[]' id='quantity".$counter."' class='form-control required' onchange='totala(".$counter.")' value='".$qty."'  min='1' ></td><td><input type='text' name='pid[]'' id='pid".$counter."' hidden='hidden' value='".$row2['product_id']."'></td>
<td class='text-center'>";

if($tcount==$counter)
{ 
$plist.="<button type='button' id='rmv".$counter."' class='close' onclick='removeRowgp(".$row2['product_id'].")'><i class='fa fa-trash'></i></button>";
}
else
{
    $plist.="<button type='button' id='rmv".$counter."' class='close' onclick='removeRowgp(".$row2['product_id'].")' style='display: none;' ><i class='fa fa-trash'></i></button>";
}
$plist.="</td></tr>";
                            
echo $plist;
$counter=$counter+1;
$totalc=$totalc+$total;
                }
     ?>
        </table>
      <input type='text'  hidden="hidden"  id='rowCnt' value='0'>
    </div>
    </div>
        

<script type="text/javascript">

function removeRowgp(removeNum) 
{ 
    jQuery('#'+removeNum).remove();
    pc=removeNum-1;
    $("#rmv"+pc).show();
    tbl = document.getElementById('group-list');
    len = tbl.rows.length;
    $("#rowCnt").val(len);
    grouptotal();
}

function totala(c)
{
        var total = Number($('#quantity'+c).val())*Number($('#rate'+c).val());
        $('#total'+c).val(total);
        grouptotal();
}

</script>

       <?php /*    <div class="form-group btm_border">
                <label class="col-sm-4 control-label" for="demo-hor-gt"><?php //echo translate('total');?></label>
                <div class="col-sm-6">
                    <input type="number" name="gt" readonly="readonly" id="gt" class="form-control" value="<?php //echo $totalc; ?>" >
                </div>
            </div> */ ?>   

<script type="text/javascript">
//    total price of group products
function grouptotal()
{
    tbl = document.getElementById('group-list');
    var counter=tbl.rows.length;
   
    $('#gt').val(0);
        for (var i =1 ; i < counter; i++) 
        {
           var gt = Number($('#gt').val())+Number($('#total'+i).val());
           $('#gt').val(gt.toFixed(2));
        }
}
</script>


<div class="form-group btm_border">
        <label class="col-sm-4 control-label" for="demo-hor-5"><?php echo translate('unit');?></label>
        <div class="col-sm-6">
    <select  name="unit" id="demo-hor-5" class="form-control unit required " >
    <option value="">Select unit</option>
        <?php
        $umo=$this->db->get_where('uom')->result_array();
        foreach($umo as $um1)
        {
            if($row['unit']==$um1['UOM_CODE'])
            {
    echo "<option value='".$um1['UOM_CODE']."' selected='selected'>".$um1['UOM_NAME']."(".$um1['UOM_CODE'].")</option>";
            }
            else
            {
    echo "<option value='".$um1['UOM_CODE']."'>".$um1['UOM_NAME']."(".$um1['UOM_CODE'].")</option>";
            }
        }
        ?>
  </select>
        </div>
</div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-6"><?php echo translate('sale_price');?></label>
                        <div class="col-sm-4">
                            <input type="number" name="sale_price" id="demo-hor-6" min='0' step='.01' placeholder="<?php echo translate('sale_price');?>" class="form-control required" value="<?php echo $row['sale_price']?>">
                        </div>
                        <span class="btn"><?php // echo currency(); ?> </span>
                    </div>

                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-10"><?php echo translate('group_discount');?></label>
                        <div class="col-sm-4">
                            <input type="number" name="discount" id="demo-hor-10" min='0' step='.01' value="<?php echo $row['discount']; ?>" placeholder="Product Discount" class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <select class="demo-chosen-select" name="discount_type">
                                <option value="percent" <?php if($row['discount_type'] == 'percent'){ echo 'selected'; } ?> >%</option>
                                <option value="amount" <?php if($row['discount_type'] == 'amount'){ echo 'selected'; } ?> >$</option>
                            </select>
                        </div>
                    </div> 

                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('category');?></label>
                        <div class="col-sm-6">
                            <?php echo $this->crud_model->select_html('category','category','category_name','edit','demo-chosen-select required',$row['category'],'','','get_cat'); ?>
                        </div>
                    </div>
                    <div class="form-group btm_border" id="sub" >
                        <label class="col-sm-4 control-label" for="demo-hor-3"><?php echo translate('sub-category');?></label>
                        <div class="col-sm-6" id="sub_cat">
                            <?php echo $this->crud_model->select_html('sub_category','sub_category','sub_category_name','edit','demo-chosen-select required',$row['sub_category'],'category',$row['category']); ?>
                        </div>
                    </div>

                    <div class="form-group btm_border" id="brn" >
                        <label class="col-sm-4 control-label" for="demo-hor-4"><?php echo translate('brand');?></label>
                        <div class="col-sm-6" id="brand" >
                            <?php echo $this->crud_model->select_html('brand','brand','name','edit','demo-chosen-select',$row['brand'],'',''); ?>
                        </div>
                    </div>

                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('equipment');?></label>
                        <div class="col-sm-6">
                         <?php echo $this->crud_model->select_html('equipment','equipment','equipment_name','edit','demo-chosen-select required',$row['equipment'],'','','get_eqi'); ?>
                        </div>
                    </div>

                    <div class="form-group btm_border" id="subeq"  style=""> 
                        <label class="col-sm-4 control-label" for="demo-hor-3"><?php echo translate('sub-equipment');?></label>
                        <div class="col-sm-6" id="sub_eqi">
                         <?php echo $this->crud_model->select_html('sub_equipment','sub_equipment','sub_equipment_name','edit','demo-chosen-select ',$row['sub_equipment'],'equipment',$row['equipment']); ?>
                        </div>
                    </div>
                       
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-12"><?php echo translate('images');?></label>
                        <div class="col-sm-6">
                            <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file');?>
                             <input type="file" multiple name="images[]" onchange="preview(this);" id="demo-hor-inputpass" class="form-control">
                            </span>
                            <br><br>
                            <span id="previewImg" ></span>
                        </div>
                    </div>

                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-13"></label>
                        <div class="col-sm-6">
                            <?php 
                                $images = $this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','all');
                                if($images)
                                {
                                foreach ($images as $row1)
                                    {
                                    $a = explode('.', $row1);
                                    $a = $a[(count($a)-2)];
                                    $a = explode('_', $a);
                                    $p = $a[(count($a)-2)];
                                    $i = $a[(count($a)-3)];
                            ?>
                                    <div class="delete-div-wrap">
                                     <span class="close">&times;</span>
                                     <div class="inner-div">
                                        <img class="img-responsive" width="100" src="<?php echo $row1; ?>" data-id="<?php echo $i.'_'.$p; ?>" alt="User_Image" >
                                      </div>
                                    </div>
                            <?php 
                                    }
                                } 
                            ?>
                        </div>
                    </div>

                        <div class="form-group btm_border">
                            <label class="col-sm-4 control-label" for="demo-hor-13"><?php echo translate('short_description'); ?></label>
                            <div class="col-sm-6">
                                <textarea rows="4" class="form-control" name="short_description" data-height="100" data-name="short_description"
                                     placeholder="Short description" ><?php echo trim($row['short_description']); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group btm_border">
                            <label class="col-sm-4 control-label" for="demo-hor-14">
                                    <?php echo translate('description');?>
                            </label>
                            <div class="col-sm-6">
                              <textarea rows="9" class="summernotes" data-height="200" data-name="description"><?php echo $row['description']; ?></textarea>
                            </div>
                        </div>

                        <?php
                            $all_af = $this->crud_model->get_additional_fields($row['product_id']);
                            $all_c = json_decode($row['color']);
                        ?>
                            <div id="more_additional_fields">
                            <?php
                                if(!empty($all_af)){
                                    foreach($all_af as $row1){
                            ?> 
                            <div class="form-group btm_border">
                                <div class="col-sm-4">
                                    <input type="text" name="ad_field_names[]" value="<?php echo $row1['name']; ?>" placeholder="Field Name" class="form-control" >
                                </div>
                                <div class="col-sm-5">
                                 <textarea rows="9"  class="summernotes" data-height="100" data-name="ad_field_values[]"><?php echo $row1['value']; ?></textarea>
                                </div>
                                <div class="col-sm-2">
                                        <span class="remove_it_v btn btn-primary" onclick="delete_row(this)">X</span>
                                </div>
                            </div>
                            <?php
                                    }
                                }
                            ?> 
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-17"></label>
                                <div class="col-sm-6">
                                    <h4 class="pull-left">
                                        <i><?php echo translate('if_you_need_more_field_for_your_product_,_please_click_here_for_more...');?></i>
                                    </h4>
                                    <div id="more_btn" class="btn btn-primary btn-labeled fa fa-plus pull-right">
                                    <?php echo translate('add_more_fields');?></div>
                                </div>
                            </div>
</div>
</div>
    <span class="btn btn-purple btn-labeled fa fa-hand-o-right pull-right" onclick="next_tab()">
        <?php echo translate('next'); ?>
    </span>
    <span class="btn btn-purple btn-labeled fa fa-hand-o-left pull-right" onclick="previous_tab()">
        <?php echo translate('previous'); ?>
    </span>
    </div>  
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-11">
                        <span class="btn btn-purple btn-labeled fa fa-refresh pro_list_btn pull-right" onclick="ajax_set_full('edit','<?php echo translate('edit_group'); ?>','<?php echo translate('successfully_edited!'); ?>','group_edit','<?php echo $row['group_id']; ?>') "><?php echo translate('reset');?>
                        </span>
                    </div>
                    <div class="col-md-1">
                        <span class="btn btn-success btn-md btn-labeled fa fa-wrench pull-right" onclick="form_submit('group_edit','<?php echo translate('successfully_edited!'); ?>');proceed('to_add');" ><?php echo translate('update');?>
                        </span> 
                    </div>
                </div>
            </div>
        
    <?php echo Form_close (); ?>
    </div>
    </div>
<?php
    }
?>
<!--Bootstrap Tags Input [ OPTIONAL ]-->
<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<input type="hidden" id="option_count" value="<?php if($r == 1){ echo $row1['no']; } else { echo '0'; } ?>">
<script type="text/javascript">
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

     $('.delete-div-wrap .close').on('click', function() { 
        var pid = $(this).closest('.delete-div-wrap').find('img').data('id'); 
        var here = $(this); 
        msg = 'Really want to delete this Image?'; 
        bootbox.confirm(msg, function(result) {
            if (result) { 
                 $.ajax({ 
                    url: base_url+'index.php/'+user_type+'/'+module+'/dlt_img/'+pid, 
                    cache: false, 
                    success: function(data) { 
                        $.activeitNoty({ 
                            type: 'success', 
                            icon : 'fa fa-check', 
                            message : 'Deleted Successfully', 
                            container : 'floating', 
                            timer : 3000 
                        }); 
                        here.closest('.delete-div-wrap').remove(); 
                    } 
                }); 
            }else{ 
                $.activeitNoty({ 
                    type: 'danger', 
                    icon : 'fa fa-minus', 
                    message : 'Cancelled', 
                    container : 'floating', 
                    timer : 3000 
                }); 
            }; 
          }); 
        });

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
        $('.summernotesadd ').each(function() {
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
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
        $('#sub').show('slow');
        $('#brn').show('slow');
    }


    function get_sub_res(id){}

    $(".unit").on('keyup',function(){
        $(".unit_set").html($(".unit").val());
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

    function next_tab(){
        $('.nav-tabs li.active').next().find('a').click();                    
    }
    function previous_tab(){
        $('.nav-tabs li.active').prev().find('a').click();                     
    }
    
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
            +'          <div class="col-md-8">'
            +'              <div class="input-group demo2">'
            +'                 <input type="text" value="#ccc" name="color[]" class="form-control" />'
            +'                 <span class="input-group-addon"><i></i></span>'
            +'              </div>'
            +'          </div>'
            +'          <span class="col-md-4">'
            +'              <span class="remove_it_v rmc btn btn-danger btn-icon btn-circle icon-lg fa fa-times" ></span>'
            +'          </span>'
            +'      </div>'
        );
        createColorpickers();
    });                

    $('body').on('click', '.rmc', function(){
        $(this).parent().parent().remove();
    });

    
    function delete_row(e)
    {
        e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
    }    
    
    
    $(document).ready(function() {
        $("form").submit(function(e){
            return false;
        });
    });
</script>
<style>
    .btm_border{
        border-bottom: 1px solid #ebebeb;
        padding-bottom: 15px;   
    }
</style>
<script type="text/javascript">

    $(document).ready(function() {
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
        $("#more_tax-btn").click(function()
        {
            var pid=$(".p").val();
            var pname=$("#tax option:selected").text();;
            var rate=$("#tax_type-t").val();
            var quantity=$("#quantity").val();
            var total=$("#total").val();
            $("#msg").hide(); $("#msg1").hide();
            if(pname!='Choose one' )
            {
                $("#msg").hide();
                if(rate>0)
                {
                    $("#msg1").hide();
                    var counter = $('#group-list-t tr:last').attr('id');
                    counter ++;
                    var s=document.getElementById(counter);
                    var newRow = jQuery('<tr id="'+counter+'"><td class="col-sm-4"></td><td class="tac">'+counter+'</td><td><input  class="form-control required" type="text" name="taxcap[][taxtype]" id="p'+counter+'" value="'+pname+'"></td><td ><input type="number" name="taxcap[][taxrate]" id="rate'+ counter +'" value="'+rate+'"  class="form-control"></td>'
                    +   '<td><input type="text" name="pid" id="pid'+counter+'" hidden="hidden" value="'+pid+'"></td>'
                    +   '<td class="text-center"><button type="button" class="close" onclick="removeRow('+counter+')"><i class="fa fa-trash"></i></button></td>');
                    jQuery('table#group-list-t').append(newRow);
                }
                else
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
    });

    function other(){
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
        $('#reserve').hide();
        $('#pname').hide();
        $('#rate').val($('#reserve').html());
        $('#ptitle').val($('#pname').html());
        total();
    }

    function get_cat(id){
        //$('#brand').html('');
        $('#sub').hide('1');
        ajax_load(base_url+'index.php/admin/product/sub_by_cat/'+id,'sub_cat','other');
        $('#sub').show('slow');
        //$('#brn').hide('slow');
        total();
    }

    function get_sub_res(id){
       // $('#brn').hide('1');
        $('#additional_fields').hide('1');
        ajax_load(base_url+'index.php/admin/product/product_by_sub/'+id,'product','other');
        $('#brn').show('slow');
        $('#additional_fields').show('slow');
        total();
    }
    
    function get_pro_res(id)
    {
        ajax_load(base_url+'index.php/admin/product/sale_by_pro/'+id,'reserve','other');
        ajax_load(base_url+'index.php/admin/product/name_by_pro/'+id,'pname','other');
    }

    function total(){
        var total = Number($('#quantity').val())*Number($('#rate').val());
        $('#total').val(total);
    }
    $(".totals").change(function(){
        total();
    });


    $(document).ready(function() {
       
        $("form").submit(function(e){
            return false;
        });
    });


$("#product_code").blur(function()
{
  var defprdcode=$("#d_prod_code").val();
  var email = $("#product_code").val();
  if (defprdcode != email) 
  {
  prod_codeexi();
  }
  else
  {
    $("#email_note").html('');
    $(".btn-success").removeAttr("disabled");
  }
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
       // alert("hi");
        $("#email_note").html('*<?php echo translate('This_productcode_already_used..'); ?>');
         $("#product_code").focus();
         $('.btn-success').attr('disabled',true);
      } else if(data == 'no')
      {
        //alert(data);
       $("#email_note").html('');
       $(".btn-success").removeAttr("disabled");
      }
    });
}


    function get_eqi(id)
     {
        $('#subeq').hide('slow');
        ajax_load(base_url+'index.php/admin/product/sub_by_equi/'+id,'sub_eqi','other');
        $('#subeq').show('slow');
     }

</script>
<div id="reserve"></div>
<div id="pname"></div>
<input type="text" id="ptitle" name="title" hidden="hidden">
