<div id="new-label-form" class="modal-content" style="">
    <div class="modal-header">
        <h4 class="modal-title"><?php echo translate('create_label'); ?></h4>
    </div>
    <div class="clr"></div>
    <div class="form-group" style="margin-top: 15px;">
        <label class="col-sm-2 control-label">Pakage Type</label>  
        <div class="col-sm-4">
            <select name="pakage-type" id="pakage-type" class="form-control" onchange="changeType(this)" data-placeholder="Select Pakage" >                                        
                <option value="YES" data="one">All in one box</option>
                <option value="NO" data="multiple">Multiple box</option>
            </select>
        </div>
        <div class="col-sm-4">
            <button type="button" name="add-pack" id="add-pack" class="btn btn-primary fr" style="display: none;" onclick="addPack()"><?php echo translate('add_package'); ?></button>
        </div>
        <div class="clr"></div>
    </div>
  
    <form action="#" class="form-horizontal" method="post" id="fedex-form" name="fedex-form" accept-charset="utf-8" >
        <input type="hidden" name="pack-count" id="pack-count" value="1" />
        <input type="hidden" name="index" id="index" value="0" /><?php $i = 0; $prdId= array();
        foreach ($prds as $prd){
	    $prdId = array();
            $prdId[] = $prd->id; 
            $orderedProducts    =   $this->crud_model->getOrderedPrdDetails($prdId);
            $orderedProduct     =   $orderedProducts[0]?>
        <span id="qty-row_<?php echo $i?>" data-id="<?php echo $orderedProduct['product_id']?>" class="qty-row">
            <input type="hidden" name="order[]" id="order_<?php echo $orderedProduct['product_id']?>" value="<?php echo $prdQtys[$i]?>" />
            <input type="hidden" name="pack[]" id="pack_<?php echo $orderedProduct['product_id']?>" class="sel-count" value="0" />
        </span><?php $i++;
        } ?>
        <div class="modal-body">
            <div class="bootbox-body">
                <div id="form">
                    <div id="fed-panel" class="panel-body">
                        <div id="row0" class="pack-row">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label class="control-label" for="fed-weight_0"><?php echo translate('weight'); ?></label><br />
                                    <input value="<?php echo number_format($prdDetails->weight,0)?>" name="fed-weight[0]" id="fed-weight_0" class="form-control required" type="text">
                                </div>
                                
                                <div class="col-sm-2">
                                    <label class=" control-label"><?php echo translate('weight_class'); ?></label>
                                    <select name="fed-weight-class[]" id="fed-weight-class" onchange="(this.value)" class="form-control" data-placeholder="Choose a category" ><?php
//                                        foreach ($weightClass as $weightCls)
//                                        {
//                                            if($prdDetails->weight_class_id == $weightCls['weight_class_id']){ $selected = 'selected="selected"'; } else{ $selected = ''; }
//                                            echo '<option value="'.$weightCls['weight_class_id'].'" '.$selected.' data="'.$weightCls['unit'].'">'.$weightCls['title'].'</option>';  
//                                        } 
                                        if($prdDetails->length_class_id == '1'){ $kgSelect  =   'selected="selected"'; } else{ $lbSelect    =   'selected="selected"'; }
                                        ?>
                                        <option value="1" data="kg" <?php echo $kgSelect?> >Kilogram</option>
                                        <option value="5" selected="selected" data="lb" <?php echo $lbSelect?> >Pound </option>
                                    </select>
                                </div>
                                <div class="col-sm-4 dim">
                                    <label class="control-label" for=""><?php echo translate('diamension'); ?> (L x W x H)</label><br />
                                    <input value="<?php echo number_format($prdDetails->length,0)?>" name="fed-length[0]" id="fed-length0" class="form-control required" type="number" placeholder="Lenght">
                                    <input value="<?php echo number_format($prdDetails->width,0)?>" name="fed-width[0]" id="fed-width0" class="form-control required" type="number" placeholder="Width">
                                    <input value="<?php echo number_format($prdDetails->height,0)?>" name="fed-height[0]" id="fed-height0" class="form-control required" type="number" placeholder="Hight">
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label"><?php echo translate('diamension_class'); ?></label> <br />
                                    <select name="fed-dim-class" id="fed-dim-class" onchange="(this.value)" class="form-control" data-placeholder="Choose a category" ><?php
//                                        foreach ($dimClass as $dimCls){ 
//                                            if($prdDetails->length_class_id == $dimCls['length_class_id']){ $selected = 'selected="selected"'; } else{ $selected = ''; }
//                                            echo '<option value="'.$dimCls['length_class_id'].'" '.$selected.' data="'.$dimCls['unit'].'">'.$dimCls['title'].'</option>';  
//                                        } 
                                    //    if($prdDetails->length_class_id == '1'){ $cmSelect  =   'selected="selected"'; } else{ $inSelect    =   'selected="selected"'; }
                                        ?>
                                        <option value="3" data="lb" <?php // echo $inSelect?> >Inch</option>
                                        <option value="1" data="kg" <?php // echo $cmSelect?> >Centimeter</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">&nbsp;</label><br />
                                    <button type="button" name="add-prd-btn0" id="add-prd-btn0" class="btn btn-primary fr" style="display: none;" onclick="addPrdRow(0)"><?php echo translate('add'); ?> / <?php echo translate('edit_product'); ?></button>
                                </div>
                            </div>
                            <div id="row-prd0" style="display: none;"> 
                                <div class="col-sm-12 prd-row title">
                                    <div class="col-sm-6">Select products to add</div>
                                    <div class="col-sm-6">
                                        <button type="button" name="add-sel-prd-btn0" id="add-sel-prd-btn0" class="btn btn-primary fr" style="display: none;" onclick="addselPrdToPack(0)"><?php echo translate('add_selected_product_to_package'); ?></button>
                                    </div>
                                </div>
                                <div class="col-sm-12 prd-row head">
                                    <div class="col-sm-6">Name</div>
                                    <div class="col-sm-2">Weight</div>
                                    <div class="col-sm-2">Ordered Qty.</div>
                                    <div class="col-sm-2">Qty.</div>
                                </div><?php $i = 0;  $prdId= array();

                                foreach ($prds as $prd){ 
				    $prdId = array();
                                    $prdId[] = $prd->id; 
                                    $orderedProducts    =   $this->crud_model->getOrderedPrdDetails($prdId);
                                    $orderedProduct     =   $orderedProducts[0]?>
                                    <div id="prd-row_0_<?php echo $i?>" class="col-sm-12 prd-row prd-row0">
                                        <div class="col-sm-6"><?php echo $orderedProduct['title']?></div>
                                        <div class="col-sm-2"><?php echo $orderedProduct['weight']?></div>
                                        <div class="col-sm-2"><?php echo $prdQtys[$i]?></div>
                                        <div class="col-sm-2">
                                            <input type="number" class="form-control input numbers-only row-qty0" id="pack-qty_0_<?php echo $i?>" name="pack-qty[][<?php echo $i?>]" value="<?php echo $prdQtys[$i]?>" />
                                            <input type="checkbox"class="checkbox row-check0" id="pack-select_0_<?php echo $i?>" name="pack-select[][<?php echo $i?>]" data-wegtht="<?php echo $orderedProduct['weight']?>"  data-length="<?php echo $orderedProduct['length']?>"  data-width="<?php echo $orderedProduct['width']?>"  data-height="<?php echo $orderedProduct['height']?>" value="<?php echo $orderedProduct['product_id']?>" />
                                        </div>
                                    </div><?php $i++;
                                } ?>
                            </div>
                            <div class="clr"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button data-bb-handler="success" id="fed-submit-btn" type="submit" class="btn btn-primary" onclick="createLabel()"><?php echo translate('create'); ?></button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function(){  
       $('#pakage-type').change(function(){ 
           if(this.value == 'NO'){ 
               $('#add-pack').show(); $('#add-prd-btn0').show();
               $('#fed-submit-btn').hide(); $('#pack-count').val(1);
           }
           else if(this.value == 'YES'){ 
               $('#add-pack').hide();  $('#add-prd-btn0').hide(); $('#row-prd0').hide();
               $('#row0').removeClass('pack-row'); $('.pack-row').html(''); $('.pack-row').hide(); $('#row0').addClass('pack-row'); $('.sel-count').val(0);
               $('#row-prd0 .checkbox').each(function(){
                   $(this).removeAttr('checked');
               });
               $('#fed-submit-btn').show(); $('#pack-count').val(1);
               $('#fed-weight_0').val('<?php echo number_format($prdDetails->weight,0)?>'); $('#fed-length0').val('<?php echo number_format($prdDetails->length,0)?>'); $('#fed-width0').val('<?php echo number_format($prdDetails->width,0)?>'); $('#fed-height0').val('<?php echo number_format($prdDetails->height,0)?>');
           }
        }); 
        $(".numbers-only").keydown(function (e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 && e.keyCode <= 40)) { return; }
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) { e.preventDefault(); }
        });
//        $('#add-pack').on('click', function(){
//            var html; var index = (parseInt($('#index').val())+1);
//            html    =   getHtml(index);
//            $('#index').val(index);
//            $("#fed-panel").append(html);
//            $('#pack-count').val(parseInt($('#pack-count').val())+1);
//        });
    });
    function changeType(data){
        if(data.value == 'NO'){ 
            $('#add-pack').show(); $('#add-prd-btn0').show();
            $('#fed-submit-btn').hide(); $('#pack-count').val(1);
        }
        else if(data.value == 'YES'){ 
            $('#add-pack').hide();  $('#add-prd-btn0').hide(); $('#row-prd0').hide();
            $('#row0').removeClass('pack-row'); $('.pack-row').html(''); $('.pack-row').hide(); $('#row0').addClass('pack-row'); $('.sel-count').val(0);
            $('#row-prd0 .checkbox').each(function(){
                $(this).removeAttr('checked');
            });
            $('#fed-submit-btn').show(); $('#pack-count').val(1);
            $('#fed-weight_0').val('<?php echo $prdDetails->weight?>'); $('#fed-length0').val('<?php echo $prdDetails->length?>'); $('#fed-width0').val('<?php echo $prdDetails->width?>'); $('#fed-height0').val('<?php echo $prdDetails->height?>');
        }
    }
    function addPack(){
        var html; var index = (parseInt($('#index').val())+1);
        html    =   getHtml(index);
        $('#index').val(index);
        $("#fed-panel").append(html);
        $('#pack-count').val(parseInt($('#pack-count').val())+1);
    }
    function addPrdRow(id){
        $('#row-prd'+id).show(); $('#add-sel-prd-btn'+id).show(); $('#add-prd-btn'+id).hide();
        $('.prd-row'+id).show();  $('#del-pack-btn'+id).show();
        $('#row-prd'+id+' .checkbox').each(function(){
            var crowId  =   this.id;
            var rowId   =   crowId.replace("pack-select", ""); 
            $('#pack-qty'+rowId).removeAttr('disabled'); $('#pack-select'+rowId).removeAttr('disabled');
            if($(this). prop("checked") == true){
                if($('#pack_'+this.value).val() == 0){ var totalQty = 0; }
                else{ 
                    var qty         =   parseInt($('#pack_'+this.value).val());
                    var selQty      =   parseInt($('#pack-qty'+rowId).val());
                    var totalQty    =   (qty-selQty);
                }
                $('#pack_'+this.value).val(totalQty);
            }
        });
        $('#fed-submit-btn').hide();
    }
    function addselPrdToPack(id){
        var weight = parseFloat(0.00); var weight1 = parseFloat(0.00); var result = 'true';
        var length = parseFloat(0.00); var length1 = parseFloat(0.00); var width = parseFloat(0.00); var width1 = parseFloat(0.00);
        var height = parseFloat(0.00); var height1 = parseFloat(0.00)
        $('#row-prd'+id+' .checkbox').each(function(){
            var crowId  =   this.id;
            var rowId   =   crowId.replace("pack-select", "")
            if($(this). prop("checked") == true){
                var qty         =   parseInt($('#pack_'+this.value).val()); // alert(this.value); alert(qty);
                var selQty      =   parseInt($('#pack-qty'+rowId).val());
                var totalQty    =   (qty+selQty);
                weight          =   (parseFloat($('#'+crowId).attr('data-wegtht'))*selQty);
                weight1         =   (weight1+weight);
                length          =   (parseFloat($('#'+crowId).attr('data-length'))*selQty);
                length1         =   (length1+length);
                width           =   (parseFloat($('#'+crowId).attr('data-width'))*selQty);
                width1          =   (width1+width);
                height          =   (parseFloat($('#'+crowId).attr('data-height'))*selQty);
                height1         =   (height1+height);
            //    alert($('#'+crowId).attr('data-wegtht')); alert(selQty); alert(weight1);
                if(totalQty > $('#order_'+this.value).val()){ 
                    alert('Product qty.exceeded than order qty.'); 
                    $('#'+this.id).removeAttr('checked'); result  =   'false'; }
                else{
                    $('#'+crowId).attr('disabled', true); $('#pack-qty'+rowId).attr('disabled', true);
                    $('#pack_'+this.value).val(totalQty);
                }
            }else{
                $('#prd-row'+rowId).hide();
            }
        });
        if(result == 'true'){ 
            $('#add-prd-btn'+id).show();  $('#add-sel-prd-btn'+id).hide(); $('#fed-weight_'+id).val(weight1);  $('#del-pack-btn'+id).hide(); 
            $('#fed-length'+id).val(length1); $('#fed-width'+id).val(width1); $('#fed-height'+id).val(height);
        } 
        else{
            $('#row-prd'+id+' .checkbox').each(function(){
                var crowId  =   this.id; 
                var rowId   =   crowId.replace("pack-select", "")
                if($(this). prop("checked") == true){ 
                    var qty         =   parseInt($('#pack_'+this.value).val()); // alert(this.value); alert(qty);
                    var selQty      =   parseInt($('#pack-qty'+rowId).val());
                    $('#pack_'+this.value).val(qty-selQty);
                }
            });
        }
        $('.qty-row').each(function(){
            var dataId          =   $('#'+this.id).attr('data-id');
            if($('#pack_'+dataId).val() != $('#order_'+dataId).val()){
                result  =   'false';
            }
        }); 
        if(result == 'true'){  $('#fed-submit-btn').show(); $('#add-pack').hide(); } else{ $('#fed-submit-btn').hide();  $('#add-pack').show();}
    }
    function deletePack(id){ 
        var cnt =   parseInt($('#pack-count').val()); cnt = (cnt-1); $('#pack-count').val(cnt); 
        var result = 'true';
        $('.qty-row').each(function(){
            var dataId          =   $('#'+this.id).attr('data-id');
            if($('#pack_'+dataId).val() != $('#order_'+dataId).val()){
                result  =   'false';
            }
        }); 
        if(result == 'true'){ $('#fed-submit-btn').show(); $('#add-pack').hide(); } else{ $('#fed-submit-btn').hide();  $('#add-pack').show();}
        $('#row'+id).html(''); $('#row'+id).hide();
    }
    
    function getHtml(index)
    {
     //   return '<div id="row0" class="pack-row"><div class="form-group">Pakage added</div></div>';
        var html    =   '';
        html  +='<div id="row'+index+'" class="pack-row">';
            html  +='<div class="form-group">';
                html  +='<div class="col-sm-2"><label class="control-label" for="fed-weight_'+index+'"><?php echo translate('weight'); ?></label><br />';
                    html  +='<input value="" name="fed-weight['+index+']" id="fed-weight_'+index+'" class="form-control required" type="text">';
                html  +='</div>';
                html  +='<div class="col-sm-2"><label class=" control-label"><?php echo translate('weight_class'); ?></label>';
                    html  +='<select name="fed-weight-class[]" id="fed-weight-class'+index+'" onchange="(this.value)" class="form-control" data-placeholder="Choose a category">';
                        html  +='<option value="1" data="kg" >Kilogram</option><option value="5" selected="selected" data="lb" >Pound </option>';
                    html  +='</select>';
                html  +='</div>';
                html  +='<div class="col-sm-4 dim"><label class="control-label" for=""><?php echo translate('diamension'); ?> (L x W x H)</label><br />';
                    html  +='<input value="<?php echo $total->weight?>" name="fed-length['+index+']" id="fed-length'+index+'" class="form-control required" type="number" placeholder="Lenght">';
                    html  +='<input value="<?php echo $total->weight?>" name="fed-width['+index+']" id="fed-width'+index+'" class="form-control required" type="number" placeholder="Width">';
                    html  +='<input value="<?php echo $total->weight?>" name="fed-height['+index+']" id="fed-height'+index+'" class="form-control required" type="number" placeholder="Hight">';
                html  +='</div>';
                html  +='<div class="col-sm-2"><label class="control-label"><?php echo translate('diamension_class'); ?></label> <br />';
                    html  +='<select name="fed-dim-class[]" id="fed-dim-class'+index+'" onchange="(this.value)" class="form-control" data-placeholder="Choose a category">';
                        html  +='<option value="3" data="lb" >Inch</option><option value="1" data="kg" >Centimeter</option>';
                    html  +='</select>';
                html  +='</div>';
                html  +='<div class="col-sm-2"><label class="control-label">&nbsp;</label><br />';
                    html  +='<button type="button" name="add-prd-btn'+index+'" id="add-prd-btn'+index+'" class="btn btn-primary fr" onclick="addPrdRow('+index+')"><?php echo translate('add'); ?> / <?php echo translate('edit_product'); ?></button>';
                    html  +='<button type="button" name="del-pack-btn'+index+'" id="del-pack-btn'+index+'" class="btn btn-primary fr" style="display: none;" onclick="deletePack('+index+')"><?php echo translate('delete_pakage'); ?></button>'
                html  +='</div>';
            html  +='</div>';
            html  +='<div id="row-prd'+index+'" style="display: none;"> ';
                html  +='<div class="col-sm-12 prd-row title">';
                    html  +='<div class="col-sm-6">Select products to add</div>';
                    html  +='<div class="col-sm-6">';
                        html  +='<button type="button" name="add-sel-prd-btn'+index+'" id="add-sel-prd-btn'+index+'" class="btn btn-primary fr" style="display: none;" onclick="addselPrdToPack('+index+')"><?php echo translate('add_selected_product_to_package'); ?></button>';
                    html  +='</div>';
                html  +='</div>';
                html  +='<div class="col-sm-12 prd-row head">';
                    html  +='<div class="col-sm-6">Name</div><div class="col-sm-2">Weight</div><div class="col-sm-2">Ordered Qty.</div><div class="col-sm-2">Qty.</div>';
                html  +='</div><?php $i = 0;$prdId= array(); foreach ($prds as $prd){ $prdId = array(); $prdId[] = $prd->id; $orderedProducts    =   $this->crud_model->getOrderedPrdDetails($prdId); $orderedProduct     =   $orderedProducts[0] ?>';
                if(parseInt($('#pack_<?php  echo $orderedProduct["product_id"]?>').val()) < parseInt('<?php  echo $prdQtys[$i]?>')){ 
                    var packQty =   (parseInt('<?php echo $prdQtys[$i]?>') - parseInt($('#pack_<?php echo $orderedProduct["product_id"]?>').val()));
                    html  +='<div id="prd-row_'+index+'_<?php echo $i?>" class="col-sm-12 prd-row prd-row'+index+'">';
                        html  +='<div class="col-sm-6"><?php echo $orderedProduct['title']?></div>';
                        html  +='<div class="col-sm-2"><?php echo $orderedProduct['weight']?></div>';
                        html  +='<div class="col-sm-2"><?php echo $prdQtys[$i]?></div>';
                        html  +='<div class="col-sm-2">';
                            html  +='<input type="number" class="form-control input numbers-only row-qty'+index+'" id="pack-qty_'+index+'_<?php echo $i?>" name="pack-qty[][<?php echo $i?>]" value="'+packQty+'" />';
                            html  +='<input type="checkbox"class="checkbox row-check0" id="pack-select_'+index+'_<?php echo $i?>" name="pack-select[][<?php echo $i?>]" data-wegtht="<?php echo $orderedProduct['weight']?>"  data-length="<?php echo $orderedProduct['length']?>"  data-width="<?php echo $orderedProduct['width']?>"  data-height="<?php echo $orderedProduct['height']?>" value="<?php echo $orderedProduct['product_id']?>" />';
                        html  +='</div>';
                    html  +='</div>';
                }
            html  +='<?php $i++; } ?><div>';
            html  +='<div class="clr"></div>';
        html  +='</div>';
    html  +='</div>';
html  +='</div>';

return html;
    }
</script>


