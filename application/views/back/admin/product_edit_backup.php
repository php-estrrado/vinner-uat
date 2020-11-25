<?php
    foreach($product_data as $row){
        $totImgs = $this->crud_model->get_type_name_by_id('product', $row['product_id'], 'num_of_imgs');
?>
<script type="text/javascript" src="<?php echo base_url('template/back/js/ajaxupload.3.5.js')?>" ></script>
<script type="text/javascript" >
	$(function(){
		var btnUpload=$('#upload_img');
		var status=$('#status'); var prdId  =   '<?php echo $row['product_id']?>';
              //  var totImgs =   parseInt($('#tot_imgs').val()); 
		new AjaxUpload(btnUpload, {
			action: '<?php echo base_url("admin/prdImgUpload/".$row["product_id"])?>',
			name: 'uploadfile[]',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');
				//Add uploaded file to list 
                              //  alert(response);
				if(response==="success"){
                                    var totImgs =  (parseInt($('#tot_imgs').val())+1); $('#tot_imgs').val(totImgs);
                                    var imgContent  =   '<span class="close">&times;</span><div class="inner-div"><img class="img-responsive" width="100" src="<?php echo base_url('uploads/product_image/')?>product_'+prdId+'_'+totImgs+'.jpg" data-id="'+prdId+'_'+totImgs+'" alt="Product_Image" ></div>'
					$('<div class="delete-div-wrap fl"></div>').appendTo('#prd-imgs').html(imgContent).addClass('success');
				} else{
					$('<li></li>').appendTo('#files').text(file).addClass('error');
				}
			}
		});
		
	});
</script>
<div class="row">
    <div class="col-md-12">
        <?php
			echo form_open(base_url() . 'index.php/admin/product/update/' . $row['product_id'], array(
				'class' => 'form-horizontal',
				'method' => 'post',
				'id' => 'product_edit',
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
                        <li>
                            <a data-toggle="tab" href="#prd_spec"><?php echo translate('specification'); ?></a>
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

                            <input type="hidden" name="tot_imgs" id="tot_imgs" value="<?php echo $totImgs?>" />
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1">
                                    <?php echo translate('product_name');?>
                                        </label>
                                <div class="col-sm-6">
                                    <input type="text" name="title" id="demo-hor-1" value="<?php echo $row['title']; ?>" placeholder="<?php echo translate('product_title');?>" class="form-control required">
                                </div>
                            </div>

                             <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1">
                                    <?php echo translate('product_code');?>
                                        </label>
                                <div class="col-sm-6">
                                    <input type="text" name="product_code" id="product_code" value="<?php echo $row['product_code']; ?>" placeholder="<?php echo translate('product_code');?>" class="form-control required">
                                    <div id="email_note" style="color:red"></div>
                                </div>
                                <input type="text" id="d_prod_code" style="visibility: hidden;" value="<?php echo $row['product_code']; ?>" >
                            </div>

                            <div class="form-group btm_border" style="display:none;">
                              <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('product_type');?>
                              </label>
                              <div class="col-sm-6">
                                <input type="text" name="item_type" id="demo-hor-5" placeholder="<?php echo translate('product_type'); ?>" class="form-control unit required" value="<?php echo $row['item_type']; ?>">
                              </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-11"><?php echo translate('tags');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="tag" data-role="tagsinput" placeholder="<?php echo translate('tags');?>" value="<?php echo $row['tag']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-11"><?php echo translate('meta_description');?></label>
                                <div class="col-sm-6">
                                    <textarea rows="4" class="form-control" name="meta_description" data-height="100" id="meta_descrt" data-name="meta_description" placeholder="Meta Description"><?php echo trim($row['meta_description']); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-11">
                                Publish</label>
                                <div class="col-sm-6">
                                <label>
                                <?php if($row['status'] == 'ok') {  ?>
                                <input value='ok' class="sw89" type="checkbox" name="status" checked data-id="<?php echo $row['product_id']; ?>" />
                                <?php  } else { ?>
                                <input value='ok' class="sw89" type="checkbox" name="status" data-id="<?php echo $row['product_id']; ?>"  />
                                <?php } ?>
                                </label>
                                </div>
                            </div> 

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-11">
                                Request for Quote</label>
                                <div class="col-sm-6">
                                <label>
                                <?php if($row['request_quote'] == 'ok') {  ?>
                                <input value='ok' class="sw89" type="checkbox" name="request_quote" checked data-id="<?php echo $row['product_id']; ?>" />
                                <?php  } else { ?>
                                <input value='ok' class="sw89" type="checkbox" name="request_quote" data-id="<?php echo $row['product_id']; ?>"  />
                                <?php } ?>
                                </label>
                                </div>
                            </div>   
                            <div class="form-group btm_border">
                              <label class="col-sm-4 control-label" for="demo-hor-11">
                                Request for Demo</label>
                              <div class="col-sm-6">
                                <label><input type="radio" name="request_demo" <?php if($row['request_demo'] == 1){ echo 'checked="ckecked"'; } ?> value="1" >Yes
                                </label>
                                <label><input type="radio" name="request_demo" <?php if($row['request_demo'] != 1){ echo 'checked="ckecked"'; } ?>  value="0">No</label>
                              </div>
                          </div>  
                            
                            <div class="form-group btm_border">
                              <label class="col-sm-4 control-label" for="demo-hor-11"> Return Policy</label>
                              <div class="col-sm-6">
                                  <textarea name="return_policy" id="return_policy" rows="7" class="form-control"><?php echo $row['return_policy']?></textarea>
                                </div>
                          </div>  

                            <div class="form-group btm_border" style="display:none;">
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
                                    }

                                    ?>" placeholder="<?php echo translate('product_type');?>" >
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('category');?></label>
                                <div class="col-sm-6">
                                    <?php echo $this->crud_model->select_html('category','category','category_name','edit','demo-chosen-select required',$row['category'],'','',''); ?>
                                </div>
                            </div>
                            <div class="form-group btm_border" id="sub"  style="display:none;">
                                <label class="col-sm-4 control-label" for="demo-hor-3"><?php echo translate('sub-category');?></label>
                                <div class="col-sm-6" id="sub_cat">
                                    <?php echo $this->crud_model->select_html('sub_category','sub_category','sub_category_name','edit','demo-chosen-select',$row['sub_category'],'category',$row['category']); ?>
                                </div>
                            </div>
                            <div class="form-group btm_border" id="brn" >
                                <label class="col-sm-4 control-label" for="demo-hor-4"><?php echo translate('indistries');?></label>
                                <div class="col-sm-6" id="brand" >
                                    <?php echo $this->crud_model->select_html('brand','brand','name','edit','demo-cs-multiselect',json_encode(explode(',',$row['brand'])),'',''); ?>
                                </div>
                            </div>

                            <div class="form-group btm_border" style="display:none;">
                              <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('equipment');?></label>
                              <div class="col-sm-6">
                                <?php echo $this->crud_model->select_html('equipment','equipment','equipment_name','edit','demo-chosen-select',$row['equipment'],'','','get_eqi'); ?>
                              </div>

                            </div>

                            <div class="form-group btm_border" id="subeq"  style="display:none;"> 
                              <label class="col-sm-4 control-label" for="demo-hor-3"><?php echo translate('sub-equipment');?></label>
                                <div class="col-sm-6" id="sub_eqi">
                               <?php echo $this->crud_model->select_html('sub_equipment','sub_equipment','sub_equipment_name','edit','demo-chosen-select ',$row['sub_equipment'],'equipment',$row['equipment']); ?>
                                </div>
                            </div>


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
                                <label class="col-sm-4 control-label" for="demo-hor-12"><?php echo translate('images');?></label>
                                <div id="upload-imgs" class="col-sm-8">
                                    <div id="prd-imgs">
                                    <?php 
                                        $images = $this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','all');
                                        if($images){ $imgs   =   count($images);
                                            foreach ($images as $row1){
                                                $a = explode('.', $row1);
                                                $a = $a[(count($a)-2)];
                                                $a = explode('_', $a);
                                                $p = $a[(count($a)-2)];
                                                $i = $a[(count($a)-3)];
                                    ?>
                                        <div class="delete-div-wrap fl">
                                            <span class="close">&times;</span>
                                            <div class="inner-div">
                                                <img class="img-responsive" width="100" src="<?php echo $row1; ?>" data-id="<?php echo $i.'_'.$p; ?>" alt="User_Image" >
                                            </div>
                                        </div>
                                    <?php 
                                            }
                                        }else{ $imgs = 0; } 
                                  //  for($n=$imgs; $n<10; $n++){ ?>
<!--                                        <span class="pull-left btn btn-default btn-file" <?php if($imgs != $n){ echo 'style="display: none;"'; } ?> > <?php echo translate('choose_file');?>
                                            <input type="file" multiple name="images[]" onchange="preview(this);" id="prd_img_<?php echo $n?>" class="form-control">
                                        </span>-->
                                            <?php
                                   // } ?>
                                    </div>
                                    <span class="pull-left btn btn-default btn-file"> 
                                        <div id="upload_img" ><span><?php echo translate('choose_image');?></span></div>
                                    </span>
                                </div>
                                <span id="status" ></span>
                            </div>

                            <div class="form-group btm_border" style="display:none;">
                                <label class="col-sm-4 control-label" for="alt_text"><?php echo translate('image alt_text'); ?></label>
                                <div class="col-sm-6">
                                 <input type="text" name="alt_text" id="alt_text" class="form-control totals" placeholder="Alt Text" value="<?php echo $row['alt_text'];?>">   
                                </div>
                            </div>
                            
                            <?php if($row['download'] == 'ok'){ ?>  
                            <div class="form-group btm_border" id="product_file" style="display:none;" >
                                <label class="col-sm-4 control-label" for="demo-hor-12"><?php echo translate('update_product_file');?></label>
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
                            <?php
                                }
                            ?>


                            <div class="form-group btm_border" style="display:none;">
                            <label class="col-sm-4 control-label" for="demo-hor-26"><?php echo translate('Brochure');?></label>
                            <?php if (file_exists('uploads/product_brochure/brochure_'.$row['product_id'].'.pdf' ) )
                                { ?>
                            <div id="delete-br-btn"  class="btn btn-primary btn-labeled fa fa-trash" data-id="<?php echo $row['product_id']; ?>">&nbsp;Delete Brochure
                            </div>
                            <div class="col-sm-6" id="addbrosh" hidden>
                              <span>
                              <input type="file" name="product_brochure"  id="demo-hor-25" class="form-control"  accept='application/pdf'>
                              </span><br>
                              <span>
                                <?php echo translate('maximum_size').' : '.ini_get("upload_max_filesize").'B'; ?>
                              </span>
                              <span id="previewdetails" ></span>
                            </div>
                            <?php }  
                            else {
                            ?>
                            <div class="col-sm-6">
                              <span>
                              <input type="file" name="product_brochure"  id="demo-hor-25" class="form-control"  accept='application/pdf'>
                              </span><br>
                              <span>
                                <?php echo translate('maximum_size').' : '.ini_get("upload_max_filesize").'B'; ?>
                              </span>
                              <span id="previewdetails" ></span>
                            </div>
                            <?php }?>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-13"><?php echo translate('short_description')."(Max.500 text)"; ?></label>
                                <div class="col-sm-6">
                                <textarea rows="4" class="form-control" name="short_description" data-height="100" id="short_descrt" data-name="short_description" placeholder="Short description" ><?php echo trim($row['short_description']); ?></textarea>
                                </div>
                                <p id='reman'></p>
                            </div>    


                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-14">
                                    <?php echo translate('description');?>
                                        </label>
                                <div class="col-sm-6">
                                    <textarea rows="9" class="summernotes" data-height="200" data-name="description">
                                        <?php echo $row['description']; ?></textarea>
                                </div>
                            </div>
                             <div class="form-group btm_border" style="">
                                <label class="col-sm-4 control-label" for="demo-hor-13"><?php echo translate('More_info'); ?></label>
                                <div class="col-sm-6">
                                  <textarea rows="5" class="form-control" name="more_info" data-height="100" data-name="more_info" placeholder="More Info"><?php echo $row['moreinfo']; ?></textarea>
                                </div>
                            </div>              
                            <?php
                                $all_af = $this->crud_model->get_additional_fields($row['product_id']);
                                $all_c = json_decode($row['color']);
                                $all_op = json_decode($row['options'],true);
                            ?>

                            
                            
                        </div>

                        <div id="business_details" class="tab-pane fade">

    <div class="form-group btm_border">

                                <h4 class="text-thin text-center"><?php echo translate('data'); ?></h4>                            
                            </div>                       
                           
    <div class="form-group btm_border">
    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('model');?></label>
    <div class="col-sm-6">
    <input type="text" name="model" id="demo-hor-6.1" placeholder="<?php echo translate('model');?>" class="form-control required" value="<?php echo $row['model']; ?>">
    </div>
    </div>

    <div class="form-group btm_border" style="display:none;">
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
    
     <div class="form-group btm_border" style="">
        <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('Related_products');?>
        </label>
        <div class="col-sm-6">
            <?php echo $this->crud_model->select_html('product','relatedproducts','title','edit','demo-cs-multiselect',$row['related_products']); ?>
        </div>
    </div> <?php  ?>



    <div class="form-group btm_border" style="display:none;">
    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo "DG product";?></label>
    <div class="col-sm-6">
    <div class="radio" id="dg" >
    <label><input type="radio" id="dyes" name="dgradio" value="1" <?php if($row['dg']==1){?> checked=" <?php echo "checked";}?>" >Yes</label>
    <label><input type="radio" id="dno" name="dgradio"  value="0" <?php if($row['dg']==0){?> checked=" <?php echo "checked";}?>">No</label>
    </div>
    </div>
    </div>
                            
                    
                            
    <div class="form-group btm_border" style="display:none;">
    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo "Requires Shipping";?></label>
    <div class="col-sm-6">
    <div class="radio" id="req_ship" >
    <label><input type="radio" id="syes" name="optradio" value="1"  <?php if($row['shipping_status']==1){?> checked=" <?php echo "checked";}?>">Yes</label>
    <label><input type="radio" id="sno" name="optradio" value="0"  <?php if($row['shipping_status']==0){?> checked=" <?php echo "checked";}?>">No</label>
    </div>
    </div>
    </div>
    
    <div class="form-group btm_border" style="display:none;">
     <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo "Product Location";?>
     </label>
     <div class="col-sm-6">
      <input type="text" name="location" class="form-control required" placeholder="Location" value="<?php echo $row['location']; ?>">
     </div>
    </div>

<div class="form-group btm_border" style="display:none;">
                            <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('package(group/not)');?></label>
                            <div class="col-sm-6">
                               <?php if($row['type']=='grouped')  { ?>
                               <input type="text" class="form-control required" name="product_group" id='pgon' readonly value="<?php echo $row['type']; ?>" >
                            <?php    } else { ?>
                             <select class="form-control required" name="product_group" id='pgon' onchange="">
                                    <option value="single">Normal Product</option>
                                    <option value="grouped">Grouped Product</option>
                              </select>
                                <?php } ?>
                            </div>
                    </div>
<?php //if($row['type']=='grouped')  { ?>
        <div class="form-group btm_border groupedp " id="groupedp1"  style="display:none;">
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
        <?php
                $products = $this->crud_model->get_groupProucts_by_id($row['product_id']);
                $plist="";
                $counter=1;
                $totalc=0;
                $tcount= count($products);
                foreach ($products as $row2) 
                {   
                 $name = $row2['product_name']; 
                 $qty  = $row2['qty'];
                 $le=round($this->crud_model->get_type_name_by_id('product', $row2['product_id'],'length'),2);
                 $wi=round($this->crud_model->get_type_name_by_id('product', $row2['product_id'],'width'),2);
                 $hi=round($this->crud_model->get_type_name_by_id('product', $row2['product_id'],'height'),2);
                 $we=round($this->crud_model->get_type_name_by_id('product', $row2['product_id'],'weight'),2);
                 $rate= $this->crud_model->get_type_name_by_id('product', $row2['product_id'], 'sale_price');
                 $total=$rate*$qty;
                    $plist="<tr id=".$row2['product_id'].">
<td><div id=".$counter." value=''><input type='hidden' name='prd-id[]' value='".$row2['product_id']."' /></div></td>
<td><input readonly='readonly' class='form-control required' type='text' name='p[]'' id='pcounter' value='".$name."'></td>
<td><input type='number' name='quantity[]' id='quantity".$counter."' class='form-control required' onchange='totala(".$counter.")' value='".$qty."'  min='1' ></td>
<td><input readonly='readonly' class='form-control required' type='text' name='l[]'' id='l' value='".$le."'></td>
<td><input readonly='readonly' class='form-control required' type='text' name='w[]'' id='w' value='".$wi."'></td>
<td><input readonly='readonly' class='form-control required' type='text' name='h[]'' id='h' value='".$hi."'></td>
<td><input readonly='readonly' class='form-control required' type='text' name='we[]'' id='we' value='".$we."'></td>
<td><input type='text' name='pid[]'' id='pid".$counter."' hidden='hidden' value='".$row2['product_id']."'></td>
<td > <div style='width: max-content;'>";

if($tcount==$counter)
{ 
$plist.="<button type='button' id='rmv".$counter."' class='close' onclick='removeRowgp(".$row2['product_id'].")'><i class='fa fa-trash'></i></button>";
}
else
{
    $plist.="<button type='button' id='rmv".$counter."' class='close' onclick='removeRowgp(".$row2['product_id'].")' style='' ><i class='fa fa-trash'></i></button>";
}
$plist.="<button type='button'  class='close' 
onclick=ajax_modal('gp_edit','Package_Edit','successfully_edited!','gp_edit',".$row2['product_id'].")>
<i class='fa fa-pencil'></i> </button></div></td></tr>";
                            
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
    <input type="number"  name="length" size="4" class="form-control required singlep" value="<?php echo $row['length']; ?>" placeholder="<?php echo translate('length');?>">                
    </div>
    <div class="col-sm-4"> 
    <input type="number"  name="width" size="4" class="form-control required singlep" value="<?php echo $row['width']; ?>"  placeholder="<?php echo translate('width');?>">
    </div>
    <div class="col-sm-4"> 
    <input type="number"  name="height" size="4" class="form-control required singlep" value="<?php echo $row['height']; ?>" placeholder="<?php echo translate('height');?>" >
    </div>
    </div>
    </div>    
                                       
                        <div class="form-group btm_border">      
                        <label class="col-sm-4 control-label" for="demo-hor-1">   Length Class:</label>
                        <div class="col-sm-6">   
                        <select id="length_class_id" name="length_class_id" class="form-control required">
                        <option value="1" <?php if($row['length_class_id']==1){?>  selected="selected" <?php }?>> Centimeter
                        </option>
                        <option value="3" <?php if($row['length_class_id']==3){?>  selected="selected" <?php }?>>Inch</option>
                        </select>
                        </div>
                        </div>             
                            
                        <div class="form-group btm_border">      
                        <label class="col-sm-4 control-label" for="demo-hor-1">   Weight:</label> 
                        <div class="col-sm-6">
                        <input type="number" name="weight" size="4" class="form-control required singlep" value="<?php echo $row['weight']; ?>" placeholder="<?php echo translate('weight');?>"> 
                        </div>
                        </div>
    
                            <div class="form-group btm_border" style="display:none;">      
                            <label class="col-sm-4 control-label" for="demo-hor-1">   Weight Class:</label>
                            <div class="col-sm-6">         
                            <select id="weight_class_id" name="weight_class_id" class="form-control required">
                            <option value="1" <?php if($row['weight_class_id']==1){?>  selected="selected" <?php }?>>Kilogram</option>
                            
                            <option value="5"  <?php if($row['weight_class_id']==5){?>  selected="selected" <?php }?>>Pound </option>
                            
                            </select>
                            </div>
                            </div>  
 </div> 
<?php //} ?>  
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-6"><?php echo translate('sale_price');?></label>
                                <div class="col-sm-4">
                                    <input type="number" name="sale_price" id="demo-hor-6" min='0' step='.01' value="<?php echo $row['sale_price']; ?>" placeholder="<?php echo translate('sale_price');?>" class="form-control required">
                                </div>
                                <span class="btn"><?php echo currency(); ?> / </span>
                                <span class="btn unit_set"><?php echo $row['unit']; ?></span>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-7"><?php echo translate('purchase_price');?></label>
                                <div class="col-sm-4">
                                    <input type="number" name="purchase_price" id="demo-hor-7" min='0' step='.01' value="<?php echo $row['purchase_price']; ?>" placeholder="<?php echo translate('purchase_price');?>" class="form-control required">
                                </div>
                                <span class="btn"><?php echo currency(); ?> / </span>
                                <span class="btn unit_set"><?php echo $row['unit']; ?></span>
                            </div>
                            <div class="form-group btm_border" style="display:none;">
                                <label class="col-sm-4 control-label" for="demo-hor-8"><?php echo translate('shipping_cost');?></label>
                                <div class="col-sm-4">
                                    <input type="number" name="shipping_cost" min='0' id="demo-hor-8" min='0' step='.01' value="<?php echo $row['shipping_cost']; ?>" placeholder="<?php echo translate('shipping_cost');?>" class="form-control">
                                </div>
                                <span class="btn"><?php echo currency(); ?> / </span>
                                <span class="btn unit_set"><?php echo $row['unit']; ?></span>
                            </div>
                            


                             
<script type="text/javascript">
$("#more_product-btn").click(function()
{
    var pid=$(".p").val();
    var pname=$("#product .chosen-single span").html();
    var rate=$("#tax_type").val();
    var quantity=$("#quantity").val();
    var total=$("#total").val();
        if(pname!='Choose one' )
        {
      if(rate>0)
          {
    var counter = $('#group-list-t tr:last').attr('id');  
    counter ++;
    var s=document.getElementById(counter);
    var newRow = jQuery('<tr id="'+counter+'"><td class="col-sm-4"><input type="text" name="pid" id="pid'+counter+'" hidden="hidden" value="'+pid+'"></td>'
        + '<td style="text-align: center;">'+counter+'</td><td><input  class="form-control required" type="text" name="taxcap[][taxtype]" id="p'+counter+'" value="'+pname+'"></td><td ><input type="number" name="taxcap[][taxrate]" id="rate'+ counter +'" value="'+rate+'"  class="form-control" onchange="limtper(this.value,this.id)" ></td>'
        +   '<td class="col-md-2"><button style="float: none !important;" type="button" class="close" onclick="removeRow('+counter+')"><i class="fa fa-trash"></i></button></td>');

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
   $(function(){
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
        $('#brand').html('');
        $('#sub').hide('1');
        ajax_load(base_url+'index.php/admin/product/sub_by_cat/'+id,'sub_cat','other');
        $('#sub').show('slow');
        $('#brn').hide('slow');
        total();
    }

    function get_eqi(id)
    {
        $('#subeq').hide('slow');
        ajax_load(base_url+'index.php/admin/product/sub_by_equi/'+id,'sub_eqi','other');
        $('#subeq').show('slow');
    }


    function get_sub_res(id){
        $('#brn').hide('1');
        $('#additional_fields').hide('1');
        ajax_load(base_url+'index.php/admin/product/product_by_sub/'+id,'product','other');
        $('#brn').show('slow');
        $('#additional_fields').show('slow');
        total();
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
</script>                     
                           
                           
<div id="pname"></div>
<!--<input type="text" id="ptitle" name="title" hidden="hidden">     -->                     
                            
         
                            
                            <!--/tax multiple-->
                            
                            
                            
                            
                            
                          <!-- <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-9"><?php //echo translate('product_tax');?>
                               <!-- </label>
                                <div class="col-sm-4">
                                    <input type="number" name="tax" class="form-control" id="demo-hor-9" min='0' step='.01' value="<?php //echo $row['tax']; ?>" placeholder="<?php// echo translate('product_tax');?>" class="form-control">
                               <!--  </div>

                                <div class="col-sm-1">
                                    <select class="demo-chosen-select" name="tax_type">
                                        <option value="percent" <?php //if($row['tax_type'] == 'percent'){ echo 'selected'; } ?><!-- >%</option>
                                        <option value="amount" <?php //if($row['tax_type'] == 'amount'){ echo 'selected'; } ?> >$
                                      <!--  </option>
                                    </select>
                                </div>
                                <span class="btn unit_set">/<?php //echo $row['unit']; ?> <!--</span>
                            </div> -->

<!--Region wise tax-->
 <div class="form-group btm_border" style="display:none;">
                      <label class="col-sm-4 control-label" for="demo-hor-9"><?php echo translate('region_wise_tax');?></label>
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
<!--
                                        <option value="amount"><?php// echo currency(); ?> <!--</option>-->
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

$(document).ready(function() {

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











                            <div class="form-group btm_border" style="display:none;">
                                <label class="col-sm-4 control-label" for="demo-hor-10"><?php echo translate('product_discount');?></label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control per" name="discount" id="demo-hor-10" min='0' step='.01' value="<?php echo $row['discount']; ?>" placeholder="Product Discount" >
                                </div>
                                <div class="col-sm-2">
                                    <select class="demo-chosen-select" name="discount_type">
                                        <option value="percent" <?php if($row['discount_type'] == 'percent'){ echo 'selected'; } ?> >%</option>
                                        <option value="amount" <?php if($row['discount_type'] == 'amount'){ echo 'selected'; } ?> >$</option>
                                    </select>
                                </div>
                                <span class="btn unit_set">/<?php echo $row['unit']; ?></span>
                            </div> 
                        </div>         
                        <div id="customer_choice_options" class="tab-pane fade">
                            
                            <div class="form-group btm_border">

                                <h4 class="text-thin text-center"><?php echo translate('customer_choice_options'); ?></h4>                            

                            </div>

                         <?php  ?>   

                        <div class="form-group btm_border" style="display:none;">
                            <label class="col-sm-4 control-label" for="demo-hor-13"><?php echo translate('Shipping_info'); ?></label>
                            <div class="col-sm-6">
                              <textarea rows="5" class="form-control" name="shipping_info" data-height="100" data-name="shipping_info" placeholder="Shipping Info"><?php echo $row['shipping_info']; ?></textarea>
                            </div>
                        </div>

                                       
                            
                            <div class="form-group btm_border">'
                                <label class="col-sm-4 control-label" for="demo-hor-15">
                                    <?php echo translate('product_color_options');?>
                                        </label>
                                    <div class="col-sm-6"  id="more_colors">
                                        <?php 
                                            if($all_c){
                                                foreach($all_c as $p){
                                        ?>
                                            <div class="col-md-12" style="margin-bottom:8px;">
                                                <div class="col-md-8">
                                                    <div class="input-group demo2">
                                                        <input type="text" value="<?php echo $p; ?>" name="color[]" class="form-control" />
                                                        <span class="input-group-addon"><i></i></span>
                                                    </div>
                                                </div>
                                                <span class="col-md-4">
                                                    <span class="remove_it_v rmc btn btn-danger btn-icon btn-circle icon-lg fa fa-times" ></span>
                                                </span>
                                            </div>
                                        <?php 
                                                }
                                            } 
                                        ?>
                                    </div>
                            </div>
                            
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-16"></label>
                                <div class="col-sm-6">
                                        <div id="more_color_btn" class="btn btn-primary btn-labeled fa fa-plus pull-right">
                                            <?php echo translate('add_colors');?></div>
                                </div>
                            </div>
                            <div id="more_additional_options">
                            <?php
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
                                        <span  style="font-size: 11px;color: #D70000;"><?php echo translate('if_you_need_more_choice_options_for_customers_of_this_product_,please_click_here.');?></span>
                                    </h4>
                                    <div id="more_option_btn" class="btn btn-mint btn-labeled fa fa-plus pull-right">
                                    <?php echo translate('add_customer_input_options');?></div>
                                </div>
                            </div>

                        </div>
                        <div id="prd_spec" class="tab-pane fade">
                            
                            <div id="more_additional_fields">
                            <?php
                            //var_dump($all_af);
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
                        <div id="vendor_prices" class="tab-pane fade"><?php   include('vendor_prices.php')?></div>
                    </div>
                </div>

                <span class="btn btn-purple btn-labeled fa fa-hand-o-right pull-right" onclick="next_tab()"><?php echo translate('next'); ?></span>
                <span class="btn btn-purple btn-labeled fa fa-hand-o-left pull-right" onclick="previous_tab()"><?php echo translate('previous'); ?></span>
        
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-11">
                    	<span class="btn btn-purple btn-labeled fa fa-refresh pro_list_btn pull-right" 
                            onclick="ajax_set_full('edit','<?php echo translate('edit_product'); ?>','<?php echo translate('successfully_edited!'); ?>','product_edit','<?php echo $row['product_id']; ?>') "><?php echo translate('reset');?>
                        </span>
                     </div>
                     <div class="col-md-1">
                     	<span class="btn btn-success btn-md btn-labeled fa fa-wrench pull-right" onclick="form_submit('product_edit','<?php echo translate('successfully_edited!'); ?>');proceed('to_add');" ><?php echo translate('update');?></span> 
                     </div>
                </div>
            </div>
        </form>
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
    $(function(){
        $(window).scroll(function(){
        $('#sbTwo option').prop('selected',true);
    });
    });
     $('body').on('click','.delete-div-wrap .close', function() { 
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


    $('#delete-br-btn').on('click', function() 
      { 
        var bpid = $(this).data('id'); 
        msg = 'Really want to delete this Brochure?'; 
        bootbox.confirm(msg, function(result) {
            if (result) { 
               // alert(bpid);
                 $.ajax({ 
                    url: base_url+'index.php/'+user_type+'/'+module+'/dlt_bros/'+bpid, 
                    cache: false, 
                    success: function(data) { 
                        $.activeitNoty({ 
                            type: 'success', 
                            icon : 'fa fa-check', 
                            message : 'Deleted Successfully', 
                            container : 'floating', 
                            timer : 3000 
                        }); 
                        $('#delete-br-btn').remove(); 
                        $('#addbrosh').show();
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
        set_summer();
        createColorpickers();
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
    });

    function other(){
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
        $('#sub').show('slow');
        $('#brn').show('slow');
    }
    function get_cat(id){
        $('#brand').html('');
        $('#sub').hide('slow');
        $('#brn').hide('slow');
        ajax_load(base_url+'index.php/admin/product/sub_by_cat/'+id,'sub_cat','other');
        ajax_load(base_url+'index.php/admin/product/brand_by_cat/'+id,'brand','other');
    }

    function get_eqi(id)
     {
        $('#subeq').hide('slow');
        ajax_load(base_url+'index.php/admin/product/sub_by_equi/'+id,'sub_eqi','other');
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


$(document).ready(function() 
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
      $("#singlep").hide();
      $(".groupedp").show();
    }
});


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
      $("#singlep").hide();
     $(".singlep").val('');
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
<style>
	.btm_border{
		border-bottom: 1px solid #ebebeb;
		padding-bottom: 15px;	
	}
</style>

