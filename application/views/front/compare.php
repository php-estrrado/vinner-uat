


	<div class="ps-page--simple">
      <div class="ps-breadcrumb">
        <div class="container">
          <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>"><?php echo translate('home'); ?></a></li>
            <li><?php echo translate('compare_product'); ?></li>
          </ul>
        </div>
      </div>
      <div class="ps-compare ps-section--shopping">
        <div class="container">
          <div class="ps-section__header">
            <h1><?php echo translate('compare_product'); ?></h1>
			  <div class="compare-actions">
				<a style="float:left" class="ps-btn" href="<?php echo base_url(); ?>">
					<i class="icon-arrow-left"></i> <?php echo translate('back_to_home'); ?>
			  	</a>
				<a style="float:right" class="ps-btn ps-btn--outline" href="<?php echo base_url('home/compare/clear'); ?>">
					<i class="icon-sync"></i> <?php echo translate('reset_compare_list'); ?>
			    </a>
		  	 </div>
          </div>
		  <?php
			//print_r($other_products);
		  ?>
          <div class="ps-section__content">
            <div class="table-responsive">
              <table class="table ps-table--compare">
                <tbody>
                  <tr>
                    <td class="heading" rowspan="2"><?php echo translate('product'); ?></td>
					  <?php
						  $i = 0;
						  foreach ($com_products as $row2) 
						  {
							 $i++;
							?>
							<td><a href="<?php echo base_url('home/compare/delete/'.$row2['product_id']); ?>">Remove</a></td>
							<?php
						 }
						 while($i < 3)
						 {
							 $i++;
							 ?>
							<td>
								<div class="form-group">
									<div class="form-group__content">
										<select class="form-control" onChange="add_compare(this.value)" >
											<option value="">Select Product..</option>
											<?php
							 				foreach($other_products as $prdct_c)
											{
												echo "<option value='".$prdct_c['product_id']."'>".ucfirst($prdct_c['title'])."</option>";
											}
							 			   ?>
										</select>
									</div>
                    			</div>
							 
							</td>
							 <?php
						 }
				    ?>
                  </tr>
                  <tr>
					<?php
					  $i = 0;
					 foreach ($com_products as $row2) 
					 {
						 $i++;
						 $p_img=$this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one');
						 if(!$p_img)
						 {
							 $p_img=base_url().'uploads/product_image/default_product_thumb.jpg';
						 }
						 $p_name = trim(strip_tags($row2['title']));
						 $p_link = $this->crud_model->product_link($row2['product_id']);
						?>
						<td>
						  <div class="ps-product--compare">
							<div class="ps-product__thumbnail cmpr_pr_thumb">
								<a href="<?php echo $p_link; ?>">
									<img src="<?php echo $p_img;?> " alt="<?php echo $p_name; ?>">
								</a>
							</div> 
							<div class="ps-product__content">
								<a href="<?php echo $p_link; ?>">
									<?php echo $p_name; ?>
								</a>
						    </div>
						  </div>
						</td>
					 	<?php
					 }
					 while($i < 3)
					 {
						 $i++;
					  	 ?>
					  	<td>
					  	</td>
					  	 <?php
					 }
				   ?>
                  </tr>
                  <tr>
					  <td class="heading">
						  <?php echo translate('category');?>
						  <?php echo ' & '.translate('sub_category');?>
					  </td>
					
					  <?php
					  $i = 0;
					  foreach ($com_products as $row2) 
					  {
						 $i++;
						 $p_cat=$this->crud_model->get_type_name_by_id('category',$row2['category'],'category_name');
						 $p_scat=$this->crud_model->get_type_name_by_id('sub_category',$row2['sub_category'],'sub_category_name');
						?>
						<td>
						  
							<?php 
						  		  echo $p_cat.'<br/>'; 
								  echo $p_scat;	
							?>
							
								
						</td>
					 	<?php
					 }
					 while($i < 3)
					 {
						 $i++;
					  	 ?>
					  	<td>
					  	</td>
					  	 <?php
					 }
				   ?>
                  </tr>
				  <tr>
					  <td class="heading">
						  <?php echo translate('brand');?>
					  </td>
					  <?php
						  $i = 0;
						  foreach ($com_products as $row2) 
						  {
							 $i++;
							 $p_brnd=$this->crud_model->get_type_name_by_id('brand', $row2['brand'], 'name');
							?>
							<td>
								<?php 
									  echo $p_brnd; 
								?>
							</td>
							<?php
						 }
						 while($i < 3)
						 {
							 $i++;
							 ?>
							<td>
							</td>
							 <?php
						 }
				    ?>
                  </tr>
				  <tr>
					  <td class="heading">
						  <?php echo translate('price');?>
					  </td>
					  <?php
						  $i = 0;
						  foreach ($com_products as $row2) 
						  {
							 $i++;
							 $s_p=$this->crud_model->get_product_price($row2['product_id']);
                    		 $sale_price=exchangeCurrency($currency_value,$exchange,$s_p);
							 if($row2['current_stock'] > 0 && $row2['discount'] > 0)
                        	 {  
								$pr_price=$row2['sale_price'];
                            	$amount_final=exchangeCurrency($currency_value,$exchange,$pr_price);
								$dis_t='';
								if($row2['discount_type'] == 'percent')
                                 {  
                                     $dis_t= '(-'.$row2['discount'].'%)';
                                 } 
                                else if($row2['discount_type'] == 'amount')
                                 { 
                                     $dis_t= '(-'.currency().$row2['discount'].')';  
                                 }
							 	?>
								<td>
									<h4 class="price sale">
										<?php echo currency().convertNumber($sale_price);  ?>
										<del><?php echo currency().convertNumber($amount_final);?></del> 
										<small><?php echo $dis_t;?></small>
									</h4>
								</td>
								<?php
							 }
							 else
							 {
								 ?>
					  			 <td>
                      				<h4 class="price"><?php echo "$".convertNumber($sale_price);  ?></h4>
                    			 </td>
					  			 <?php
							 }
						 }
						 while($i < 3)
						 {
							 $i++;
							 ?>
							<td>
							</td>
							 <?php
						 }
				    ?>
                  </tr>
				  <tr>
					  <td class="heading">
						  <?php echo translate('availability');?>
					  </td>
					  <?php
						  $i = 0;
						  foreach ($com_products as $row2) 
						  {
							 $i++;
							 $p_aval=($row2['current_stock']>0)?'In Stock':'Out of Stock';
							 $p_avcls=($row2['current_stock']>0)?'in-stock':'out-stock';
							?>
							<td>
								<span class="<?php  echo $p_avcls; ?>"><?php  echo $p_aval; ?></span>
							</td>
							<?php
						 }
						 while($i < 3)
						 {
							 $i++;
							 ?>
							<td>
							</td>
							 <?php
						 }
				    ?>
                  </tr>
				  <tr>
					  <td class="heading">
						  <?php echo translate('sold_by');?>
					  </td>
					  <?php
						  $i = 0;
						  foreach ($com_products as $row2) 
						  {
							 $i++;
							?>
							<td>
								<a class="sold-by" href="<?php echo $this->crud_model->product_by($row2['product_id'],'link_only'); ?>">
									<?php 
                            			echo $this->crud_model->product_by($row2['product_id']); 
                          			?>
								</a>
							</td>
							<?php
						 }
						 while($i < 3)
						 {
							 $i++;
							 ?>
							<td>
							</td>
							 <?php
						 }
				    ?>
                  </tr>
				  <tr>
					  <td class="heading">
						  <?php echo translate('description');?>
					  </td>
					  <?php
						  $i = 0;
						  foreach ($com_products as $row2) 
						  {
							 $i++;
							 $p_desc=trim($row2['description']);
							?>
							<td>
								<?php 
									  echo $p_desc; 
								?>
							</td>
							<?php
						 }
						 while($i < 3)
						 {
							 $i++;
							 ?>
							<td>
							</td>
							 <?php
						 }
				    ?>
                  </tr>
				 <?php /*
				  <tr>
					  <td class="heading">
					  </td>
					  <?php
						  $i = 0;
						  foreach ($com_products as $row2) 
						  {
							 $i++;
							 $p_desc=trim($row2['description']);
							?>
							<td>
								<a class="ps-btn" href="#">Add To Cart</a>
							</td>
							<?php
						 }
						 while($i < 3)
						 {
							 $i++;
							 ?>
							<td>
							</td>
							 <?php
						 }
				    ?>
                  </tr>
				  */
				  	?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

<script>
	function add_compare(cmprid)
	{
		
		if(cmprid>0)
		{
			window.location= base_url+'home/compare/add_web/'+cmprid;
		}
	}
</script>