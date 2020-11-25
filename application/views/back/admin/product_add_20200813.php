<div class="row">

    <div class="col-md-12">

    <?php
        echo form_open(base_url() . 'index.php/admin/product/do_add/', array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'product_add',
            'enctype' => 'multipart/form-data'
            ));

        ?>

                        <!--Panel heading-->
            <div class="panel-heading">
                <div class="panel-control" style="float: left;">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#product_details"><?php echo translate('general'); ?></a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#business_details"><?php echo translate('data'); ?></a>
                        </li>
<!--                        <li>
                            <a data-toggle="tab" href="#customer_choice_options"><?php echo translate('attribute'); ?></a>
                        </li>-->
                        <li>
                            <a data-toggle="tab" href="#vendor_prices"><?php echo translate('warehouse_prices'); ?></a>
                        </li>
                        
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-base">
                    <!--Tabs Content-->                    
                    <div class="tab-content">
                        <div id="product_details" class="tab-pane fade active in">
                             <div class="form-group btm_border">
                                <h4 class="text-thin text-center"><?php echo translate('product_details'); ?></h4>                            
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1">
                                    <?php echo translate('product_name');?>
                                        </label>
                                <div class="col-sm-6">
                                    <input type="text" name="title" id="demo-hor-1" value="" placeholder="<?php echo translate('product_title');?>" class="form-control required">
                                </div>
                            </div>

                             <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1">
                                    <?php echo translate('product_code');?>
                                        </label>
                                <div class="col-sm-6">
                                    <input type="text" name="product_code" id="product_code" value="" placeholder="<?php echo translate('product_code');?>" class="form-control required">
                                    <div id="email_note" style="color:red"></div>
                                </div>
                                <input type="text" id="d_prod_code" style="visibility: hidden;" value="" >
                            </div>

                            <div class="form-group btm_border" style="display: none;">
                              <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('product_type');?>
                              </label>
                              <div class="col-sm-6">
                                <input type="text" name="item_type" id="demo-hor-5" placeholder="<?php echo translate('product_type'); ?>" class="form-control unit" value="0">
                              </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-11"><?php echo translate('tags');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="tag" data-role="tagsinput" placeholder="<?php echo translate('tags');?>" value="" class="form-control">
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-11"><?php echo translate('meta_description');?></label>
                                <div class="col-sm-6">
                                    <textarea rows="4" class="form-control" name="meta_description" data-height="100" id="meta_descrt" data-name="meta_description" placeholder="Meta Description"></textarea>
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-11">
                                Publish</label>
                                <div class="col-sm-6">
                                <label>
                                <input value='ok' class="sw89" type="checkbox" name="status" data-id=""  />
                                </label>
                                </div>
                            </div> 

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-11">
                                Request for Quote</label>
                                <div class="col-sm-6">
                                <label>
                                <input value='ok' class="sw89" type="checkbox" name="request_quote" data-id=""  />
                                </label>
                                </div>
                            </div>                             

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('product_condition');?>
                                </label>
                                <div class="col-sm-6">
                                    <select id="product_type" name="product_type"  class="demo-chosen-select" >
                                        <option value="New">New</option>
                                        <option value="Refurbished">Refurbished</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('category');?></label>
                                <div class="col-sm-6">
                                    <?php echo $this->crud_model->select_html('category','category','category_name','add','demo-chosen-select required','','','','get_cat'); ?>
                                </div>
                            </div>
                            <div class="form-group btm_border" id="sub" >
                                <label class="col-sm-4 control-label" for="demo-hor-3"><?php echo translate('sub-category');?></label>
                                <div class="col-sm-6" id="sub_cat">
                                    <?php echo $this->crud_model->select_html('sub_category','sub_category','sub_category_name','edit','demo-chosen-select required','','category',''); ?>
                                </div>
                            </div>
                            
                             <div class="form-group btm_border">

                                <label class="col-sm-4 control-label" for="demo-hor-5"><?php echo translate('unit');?></label>

                                <div class="col-sm-6">

                                    <!-- <input type="text" name="unit" id="demo-hor-5" placeholder="<?php //echo translate('unit_(e.g._kg,_pc_etc.)'); ?>" class="form-control unit required"> -->

                    <select  name="unit" id="demo-hor-5" class="form-control unit required " >
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
                                <label class="col-sm-4 control-label" for="demo-hor-12"><?php echo translate('images');?></label>
                                <div class="col-sm-6">
                                    <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file');?>
                                        <input type="file" multiple name="images[]" onchange="preview(this);" id="demo-hor-inputpass" class="form-control">
                                    </span>
                                    <br><br>
                                    <em>( Image size : 400 X 400 )</em>
                                    <span id="previewImg" ></span>
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-13"></label>
                                <div class="col-sm-6">
                                        <div class="delete-div-wrap">
                                            <span class="close">&times;</span>
                                            <div class="inner-div">
                                                <img style="display: none;" class="img-responsive" width="100" src="<?php // echo $row1; ?>" data-id="<?php // echo $i.'_'.$p; ?>" alt="User_Image" >
                                            </div>
                                        </div>
                                </div>
                            </div>

                            <div class="form-group btm_border" style="display: none;">
                                <label class="col-sm-4 control-label" for="alt_text"><?php echo translate('image alt_text'); ?></label>
                                <div class="col-sm-6">
                                 <input type="text" name="alt_text" id="alt_text" class="form-control totals" placeholder="Alt Text" value="">   
                                </div>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-13"><?php echo translate('short_description')."(Max.500 text)"; ?></label>
                                <div class="col-sm-6">
                                    <textarea rows="4" class="form-control" name="short_description" data-height="100" id="short_descrt" data-name="short_description" placeholder="Short description"></textarea>
                                </div>
                                <p id='reman'></p>
                            </div>


                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-13"><?php echo translate('description'); ?></label>
                                <div class="col-sm-6">
                                    <textarea rows="9"  class="summernotes" data-height="200" data-name="description" ></textarea>
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
    <input type="text" name="model" id="demo-hor-6.1" placeholder="<?php echo translate('model');?>" class="form-control required" value="">
    </div>
    </div>

    <div class="form-group btm_border">
    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo "HS Code";?></label>
    <div class="col-sm-6">
    <input type="text" name="sku" id="demo-hor-6.2" placeholder="<?php echo "HS code";?>" class="form-control" value="">
    </div>
    </div>

    <div class="form-group btm_border">
    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo "MPN";?></label>
    <div class="col-sm-6">
    <input type="text" name="mpn" id="demo-hor-6.3" placeholder="<?php echo "MPN";?>" class="form-control"   value="">
    </div>
    </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="req_demo">
                                Request for Demo</label>
                                <div class="col-sm-6">
                                <label>
                                <input value='1' class="sw89" type="checkbox" name="req_demo" id="req_demo" />
                                </label>
                                </div>
                            </div>  
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="return_policy">
                                Return Policy</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="return_policy" id="return_policy" rows="7"></textarea>
                                </div>
                            </div> 

                            <div class="form-group btm_border" style="display: none;">
    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo "DG product";?></label>
    <div class="col-sm-6">
    <div class="radio" id="dg" >
    <label><input type="radio" id="dyes" name="dgradio" value="1"" >Yes</label>
    <label><input type="radio" id="dno" name="dgradio"  value="0" checked="checked">">No</label>
    </div>
    </div>
    </div>
                            
                    
                            
    <div class="form-group btm_border" style="display: none;">
    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo "Requires Shipping";?></label>
    <div class="col-sm-6">
    <div class="radio" id="req_ship" >
    <label><input type="radio" id="syes" name="optradio" value="1" >Yes</label>
    <label><input type="radio" id="sno" name="optradio" value="0" checked="checked">No</label>
    </div>
    </div>
    </div>
    
    <div class="form-group btm_border" style="display: none;">
     <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo "Product Location";?>
     </label>
     <div class="col-sm-6">
      <input type="text" name="location" class="form-control" placeholder="Location" value="0">
     </div>
    </div>

<div class="form-group btm_border"style="display: none;">
                            <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('package(group/not)');?></label>
                            <div class="col-sm-6">
                             
                             <select class="form-control required" name="product_group" id='pgon' onchange="">
                                    <option value="single">Normal Product</option>
                                    <option value="grouped">Grouped Product</option>
                              </select>
                            </div>
                    </div>
<?php //if($row['type']=='grouped')  { ?>
        <div class="form-group btm_border groupedp " id="groupedp1" style="display: none;">
            <button class="btn btn-primary btn-labeled fa fa-plus-circle " 
                  onclick="ajax_modal('gp_add','<?php echo translate('add_package'); ?>','<?php echo translate('successfully_added!');?>','gp_add','')">
                <?php echo translate('add_package');?>
            </button>
         </div>
         
<div class="cart_list groupedp">   

        <div class="form-group btm_border">
        <table align="center" class="group-list " id="group-list">
            <thead>
            <th ></th><th><label class="col-sm-6 control-label" for="demo-hor-3"><?php echo translate('package');?></label></th>
            <th><label class="col-sm-4 control-label" for="demo-hor-4"><?php echo translate('quantity');?></label></th>
            <th><label class="col-sm-4 control-label" for="demo-hor-4"><?php echo translate('Length');?></label></th>
            <th><label class="col-sm-4 control-label" for="demo-hor-4"><?php echo translate('width');?></label></th>
            <th><label class="col-sm-4 control-label" for="demo-hor-4"><?php echo translate('height');?></label></th>
            <th><label class="col-sm-4 control-label" for="demo-hor-4"><?php echo translate('Weight');?></label></th>
            <td></td>

            <td></td>
            </thead>
            <!-- <tr id="0" hidden="hidden"></tr> -->

        </table>
      <input type='text'  hidden="hidden"  id='rowCnt' value='0'>
    </div>
    </div>
<script type="text/javascript">

function removeRowgp(removeNum) 
{ 
    jQuery('#'+removeNum).remove();
    tbl = document.getElementById('group-list');
    len = tbl.rows.length;
    $("#rowCnt").val(len);
    $.post("<?php echo base_url(); ?>index.php/admin/gp_product/deletegroup",
    {
      <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
      gp_id: removeNum 
    },
    function(data, status){
      if(data)
      {
      } else 
      {
      }
    });

}


</script>

<?php //} else { ?>
<div id='singlep' >
    <div class="form-group btm_border">
    <label class="col-sm-4 control-label" for="demo-hor-1">Packed Dimensions (L x W x H):</label>
    <div class="col-sm-6">                    
    <div class="col-sm-4">  
    <input type="number"  name="length" size="4" class="form-control required singlep" value="" placeholder="<?php echo translate('length');?>">                
    </div>
    <div class="col-sm-4"> 
    <input type="number"  name="width" size="4" class="form-control required singlep" value=""  placeholder="<?php echo translate('width');?>">
    </div>
    <div class="col-sm-4"> 
    <input type="number"  name="height" size="4" class="form-control required singlep" value="" placeholder="<?php echo translate('height');?>" >
    </div>
    </div>
    </div>    
                                       
                        <div class="form-group btm_border">      
                        <label class="col-sm-4 control-label" for="demo-hor-1">   Length Class:</label>
                        <div class="col-sm-6">   
                        <select id="length_class_id" name="length_class_id" class="form-control required">
                        <option value="1" > Centimeter
                        </option>
                        <option value="3">Inch</option>
                        </select>
                        </div>
                        </div>             
                            
                        <div class="form-group btm_border">      
                        <label class="col-sm-4 control-label" for="demo-hor-1">   Weight:</label> 
                        <div class="col-sm-6">
                        <input type="number" name="weight" size="4" class="form-control required singlep" value="" placeholder="<?php echo translate('weight');?>"> 
                        </div>
                        </div>
    
                            <div class="form-group btm_border">      
                            <label class="col-sm-4 control-label" for="demo-hor-1">   Weight Class:</label>
                            <div class="col-sm-6">         
                            <select id="weight_class_id" name="weight_class_id" class="form-control required">
                            <option value="1" >Kilogram</option>
                            
                            <option value="5" >Pound </option>
                            
                            </select>
                            </div>
                            </div>  
 </div> 
<?php //} ?>  
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-6"><?php echo translate('sale_price');?></label>
                                <div class="col-sm-4">
                                    <input type="number" name="sale_price" id="demo-hor-6" min='0' step='.01' value="" placeholder="<?php echo translate('sale_price');?>" class="form-control required">
                                </div>
                                <span class="btn"><?php echo currency(); ?> / </span>
                                <span class="btn unit_set"></span>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-7"><?php echo translate('purchase_price');?></label>
                                <div class="col-sm-4">
                                    <input type="number" name="purchase_price" id="demo-hor-7" min='0' step='.01' value="" placeholder="<?php echo translate('purchase_price');?>" class="form-control required">
                                </div>
                                <span class="btn"><?php echo currency(); ?> / </span>
                                <span class="btn unit_set"></span>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-8"><?php echo translate('shipping_cost');?></label>
                                <div class="col-sm-4">
                                    <input type="number" name="shipping_cost" min='0' id="demo-hor-8" min='0' step='.01' value="" placeholder="<?php echo translate('shipping_cost');?>" class="form-control">
                                </div>
                                <span class="btn"><?php echo currency(); ?> / </span>
                                <span class="btn unit_set"></span>
                            </div>
                            
                            <!--tAX mULTIPLE-->
                <div class="form-group btm_border" style="display: none;">
                   <!-- <div class="col-sm-4" > </div> -->
<label class="col-sm-4 control-label" for="demo-hor-9"><?php echo translate('product_tax');?></label>
                      <table align="center" class=" col-sm-12 product-list">
                                <tr >
                                <td class="col-sm-4" > </td>
                                <td class="col-sm-2" id="product"> 
                                <?php 
                        echo $this->crud_model->select_html('tax','tax','tax_type','add','form-control p demo-chosen-select','','','','get_pro_res'); ?>
                                 <span id="msg" style="display:none;color:red;"></span>
                                 </td> 
                                  <td class="col-sm-2">
                     <input type="number" name="tax_type" id="tax_type" min='0' step='.01' max='99' onchange="limtper(this.value,this.id)" placeholder="<?php echo translate('product_tax');?>" class="form-control" >
                    <span id="msg1" style="display:none;color:red;"></span>  
                                  </td>
                                
                                   <td class="col-sm-1">
                                       
                                   <select class="demo-chosen-select" name="tax_amount">
                                        <option value="percent">%</option>
                                        <!--<option value="amount"><?php echo currency(); ?></option>-->
                                    </select>     
                                     
                                   </td>   
                                   <td class="col-sm-2"><div id="more_product-btn" class="btn btn-primary btn-labeled fa fa-plus">&nbsp;
                                        <?php echo translate('add_tax_type');?>
                    </div></td>
                                    </tr>
                      </table>      
                     
                                <span class="btn unit_set"></span>
                                
                           <div class="form-group btm_border">     
                                                                  
        
         </div>
                             

                    </div>
                </div>
                    <div id="vendor_prices" class="tab-pane fade"><?php   include('vendor_prices.php')?></div>
                <span class="btn btn-purple btn-labeled fa fa-hand-o-right pull-right" onclick="next_tab()"><?php echo translate('next'); ?></span>
                <span class="btn btn-purple btn-labeled fa fa-hand-o-left pull-right" onclick="previous_tab()"><?php echo translate('previous'); ?></span>
        
            </div>
            <div class="panel-footer">
                <div class="row">

                  <div class="col-md-11">

                        <span class="btn btn-purple btn-labeled fa fa-refresh pro_list_btn pull-right" 

                            onclick="ajax_set_full('add','<?php echo translate('add_product'); ?>','<?php echo translate('successfully_added!'); ?>','product_add',''); "><?php echo translate('reset');?>

                        </span>

                    </div>

                    

                    <div class="col-md-1">

                        <span class="btn btn-success btn-md btn-labeled fa fa-upload pull-right" onclick="form_submit('product_add','<?php echo translate('product_has_been_uploaded!'); ?>');proceed('to_add');" ><?php echo translate('Submit');?></span>

                    </div>

                    

                </div>
            </div>
        </form>

    </div>

</div>
    </div>
</div>


<script src="<?php $this->benchmark->mark_time(); echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js">

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

function set_summeradd(){

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
        set_summer();;

    createColorpickers();
    

    });



    function other(){

        set_select();
        
    }

    function get_cat(id){

        $('#brand').html('');

        $('#sub').hide('slow');

        $('#brn').hide('slow');

        ajax_load(base_url+'index.php/admin/product/sub_by_cat/'+id,'sub_cat','other');

        ajax_load(base_url+'index.php/admin/product/brand_by_cat/'+id,'brand','other');

        $('#sub').show('slow');
        $('#brn').show('slow');

    }

    function get_sub_res(id){}

function get_eqi(id)
 {
    $('#subeq').hide('slow');
    ajax_load(base_url+'index.php/admin/product/sub_by_equi/'+id,'sub_eqi','other');
    $('#subeq').show('slow');
  } 




/*
    $(".unit").on('keyup',function(){

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

            +'        <textarea rows="9"  class="summernotesadd" data-height="100" data-name="ad_field_val[]"></textarea>'

            +'    </div>'

            +'    <div class="col-sm-2">'

            +'        <span class="remove_it_v rms btn btn-danger btn-icon btn-circle icon-lg fa fa-times" onclick="delete_row(this)"></span>'

            +'    </div>'

            +'</div>'

        );

        //set_summer();
        set_summeradd();

    });

    

    function next_tab(){

        $('.nav-tabs li.active').next().find('a').click();                    

    }

    function previous_tab(){

        $('.nav-tabs li.active').prev().find('a').click();                     

    }

    

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

      +'             <input type="text" value="#ccc" name="color[]" class="form-control" />'

      +'             <span class="input-group-addon"><i></i></span>'

      +'            </div>'

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

    $("form").submit(function(e){

      return false;

    });

  });





  /*restricted country item select*/

    

            $(function () {

            function moveItems(origin, dest) {

                $(origin).find(':selected').appendTo(dest);

            }



            function moveAllItems(origin, dest) {

                $(origin).children().appendTo(dest);

            }



            $('#left').click(function () {

                moveItems('#sbTwo', '#sbOne');

            });



            $('#right').on('click', function () {

                moveItems('#sbOne', '#sbTwo');

            });



            $('#leftall').on('click', function () {

                moveAllItems('#sbTwo', '#sbOne');

            });



            $('#rightall').on('click', function () {

                moveAllItems('#sbOne', '#sbTwo');

            });

        });

    /*/// end country*/


//limit percentage

$(".per").change(function()
{
  var a=$(this).val();
  var pp=$('select[name="discount_type"]  option:selected').val();
  if(pp=='percent')
  {
    if (a >= 100) 
    {
    $(this).val("99");
    }
    else if (a <= 0) 
    {
    $(this).val("1");
    }
  }
});

function limtper(x,idt)
{
  //alert(x);
  if(x >= 100) 
  {
  $("#"+idt).val("99");
  }
  else if(x <= 0)
  {
  $("#"+idt).val("0.1");
  }
}



$("#product_code").blur(function()
{
  prod_codeexi();
});

/*$("select[name='category']" ).change(function(){
subcatexi();
});*/
    
  
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
</script>


<style>

  .btm_border{

    border-bottom: 1px solid #ebebeb;

    padding-bottom: 15px; 

  }






</style>


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

function removeRowgp(removeNum) 
{ 

  $.post("<?php echo base_url(); ?>index.php/admin/gp_product/delete",
    {
      <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
      gp_id: removeNum 
    },
    function(data, status){
      if(data)
      {
      } else 
      {
      }
    });

  //alert(removeNum);
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


$('#short_descrt').keypress(function(e) {
    var tval = $('#short_descrt').val(),
        tlength = tval.length,
        set = 500,
        remain = parseInt(set - tlength);
    $('#reman').text(remain);
    if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
        $('#short_descrt').val((tval).substring(0, tlength - 1));
        return false;
    }
});

</script>



<!--Bootstrap Tags Input [ OPTIONAL ]-->



