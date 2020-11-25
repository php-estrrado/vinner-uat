<?php
    if(isset($row['product_id'])){ $prdId = $row['product_id']; }else{ $prdId = 0; }
    if(isset($row['sale_price'])){ $salePrice = $row['sale_price']; $unit = $row['unit']; }else{ $salePrice = 0; $unit = ''; }
if($prdId > 0){	 $query			=	$this->db->where('status',1)->where('prd_id',$prdId)->get('vendor_prices')->result(); $prices = [];
	 if($query){ foreach($query as $rw){ $prices[$rw->vendor_id] = $rw->price; } }else{ $prices = false; } } else{ $prices = false; }
	$vendors		=	$this->db->get('vendor')->result();
?>
<div class="form-group btm_border">
	<h4 class="text-thin text-center"><?php echo translate('warehouse_prices'); ?></h4>                            
</div>
<div class="form-group btm_border">
	<label class="col-sm-4 control-label" for="base_price_vendor"><?php echo translate('base_price');?>
	</label>
	<div class="col-sm-4">
	<input type="text" id="base_price_vendor" disabled value="<?php echo $salePrice?>" placeholder="Price"  class="form-control" />
	</div>
	<span class="btn"><?php echo currency(); ?> / </span><span class="btn unit_set"><?php echo $unit; ?></span>
</div><?php 
	if($prices){  }else{ $price = 0; }
if($vendors){ foreach($vendors as $k=>$vrow){ 
if($prices){  $price =  	$prices[$vrow->vendor_id]; }else{ $price = 0; }   ?>    
	<div class="form-group btm_border">
		<label class="col-sm-4 control-label" for="price_vendor_<?php echo $vrow->vendor_id?>"><?php echo $vrow->name;?></label>
		<div class="col-sm-4">
			<input type="number" name="price_vendor[<?php echo $vrow->vendor_id?>]" id="price_vendor_<?php echo $vrow->vendor_id?>" min='0' step='.01' value="<?php  echo $price?>" placeholder="<?php echo translate('price');?>" class="form-control">
		</div>
                <span class="btn"><?php echo currency();?>  </span><?php  if(isset($row['unit'])){ ?>/<span class="btn unit_set"><?php echo $row['unit']; ?></span><?php } ?>
</div><?php } } ?>
  