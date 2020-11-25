

  	<div class="ps-page--simple">
	    <div class="ps-breadcrumb">
	        <div class="container">
	          <ul class="breadcrumb">
	            <li><a href="<?php echo base_url();?>">Home</a></li>
	            <li>Brand Stores</li>
	          </ul>
	        </div>
	    </div>

	    <div class="ps-page--shop ps-section--shopping" >
	      	<div class="container">
	      		<div class="ps-section__header">
            		<h1>Brands</h1>
          		</div>

		        
		        <?php
					$category = $this->db->query("select DISTINCT(c.category_name),c.category_id FROM product p ,category c where p.category =c.category_id and p.status='ok' and p.admin_approved='1' and p.vendor_approved='1' ORDER BY p.category DESC")->result_array();
					foreach($category as $cat)
						{
							?>
							<div class="ps-block--categories-box">
						        <div class="ps-block__header">
						            <h3><?php echo ucfirst($cat['category_name']); ?></h3>
						        </div>
						        <div class="ps-block__content">
						        	<?php
						        		$cbrand=$this->db->query("select DISTINCT(b.name) as brand ,p.brand as brand_id,b.logo_alt FROM product p ,brand b WHERE p.brand=b.brand_id and p.category='".$cat['category_id']."' and p.status='ok' and p.admin_approved='1' and p.vendor_approved='1'")->result_array();
						        		foreach ($cbrand as $ckey) 
						        		{
						        			$prqry=$this->db->where(array('category'=>$cat['category_id'],'brand'=>$ckey['brand_id'],'status'=>'ok','admin_approved'=>'1','vendor_approved'=>'1'))->get('product');
						        			$var= $this->crud_model->file_view('brand',$ckey['brand_id'],'','','no','src','','','.png');
                                        	if(!$var) 
                                        	{
                                        		$var= base_url('uploads/brand_image/brand_default.png');
                                        	}
						        			?>
						        			<div class="ps-block__item">
								            	<a class="ps-block__overlay" href="<?php echo base_url('home/brand/'.$ckey['brand_id']); ?>">
								            	</a>
								            	<img src="<?php echo $var; ?>" alt="<?php echo $ckey['logo_alt'];?>"/>
								              	<p>
								              		<?php echo ucfirst($ckey['brand']); ?> 
								              	</p> 
								              	<span>
								              		<?php echo $prqry->num_rows(); ?> Items
								              	</span> 
						            		</div>
						        			<?php
						        			
						        		}

						        	?>
						        </div>
		        			</div>
							<?php
						}
				?>
	      	</div>
	    </div>
  	</div>