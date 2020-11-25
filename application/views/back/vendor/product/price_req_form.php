<?php
    $prdId          =   ($product)? $product->product_id : 0;
    $title          =   ($product)? $product->title : '';
    $bPrice         =   ($product)? $product->sale_price : '';
    $cPrice         =   ($product)? $product->price : '';
    $retUrl         =   ($product)? 'vendor/product' : 'warehouse/product/priceChange';
    $vndrId         =   $this->session->userdata('vendor_id');
    ?>
<div><?php
   // echo '<pre>'; print_r($products); echo '</pre>'; die;
    echo form_open(base_url() . 'vendor/product/saveReqPrice/', array( 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'request_form', 'enctype' => 'multipart/form-data' ));  ?>
        <div class="panel-body">
            <div class="form-group">
                <input type="hidden" name="vendor_id" value="<?php echo $vndrId?>" /><input type="hidden" id="prd_id" name="prd_id" value="<?php echo $prdId?>" />
                <input type="hidden" id="returnUrl" name="returnUrl" value="<?php echo $retUrl?>" //>
                <label class="col-sm-4 control-label" for="title"><?php echo translate('product_name');?></label><?php
                if($prdId > 0){ ?>
                    <div class="col-sm-6">
                        <input type="text" name="product" id="product" class="form-control" value="<?php echo $title?>" readonly="" />
                    </div><?php 
                }else{ ?>
                <div class="col-sm-6">
                    <select name="product" id="product" class="form-control required">
                        <option value="" data-sprice="" data-cprice="">Select Product</option><?php
                        if($products){ foreach($products as $row){ 
                            echo '<option value="'.$row->product_id.'" data-id="'.$row->product_id.'" data-sprice="'.$row->sale_price.'" data-cprice="'.$row->price.'">'.$row->title.'</option>';
                        } } ?>
                    </select>
                    <span id='error_product' class="error_msg"></span>
                </div>
                <?php } ?>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="base_price"><?php echo translate('base_price');?></label>
                <div class="col-sm-6">
                    <input type="text" name="base_price" id="base_price" class="form-control" value="<?php echo $bPrice?>" readonly="" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="current_price"><?php echo translate('current_price');?></label>
                <div class="col-sm-6">
                    <input type="text" name="current_price" id="current_price" class="form-control " value="<?php echo $cPrice?>" readonly="" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="req_price"><?php echo translate('request_price');?></label>
                <div class="col-sm-6">
                    <input type="text" name="req_price" id="req_price" class="form-control number" value="" />
                    <span id='error_req_price' class="error_msg"></span>
                </div>
            </div>
            
        </div>
        <div id="btn-area" style="">
                <button id="saveRequest" data-bb-handler="success" type="button" class="btn btn-purple">Submit</button>
        </div>
	<?php echo form_close(); ?>

</div>



<script type="text/javascript">
    
    $(document).ready(function(){
        
    });

</script>
