<div class="content container">

	<div class="row">

		<div class="col-md-12">

        	<div class="col-md-6 pull-right">

            	<div class="row">

                    <a class="btn-u btn-u-dark btn-labeled fa fa-repeat pull-right" href="<?php echo base_url(); ?>index.php/home/compare/clear">

                        <?php echo translate('reset_compare_list'); ?>

                    </a>

                </div>

            </div>

            <div class="col-md-6 pull-left">

            	<div class="row">

                    <a class="btn-u btn-u-blue btn-labeled fa fa-chevron-circle-left pull-left" href="<?php echo base_url();?>">

                        <?php echo translate('back_to_home'); ?>

                    </a>

                </div>

            </div>

		</div>

		<?php

			$full = $this->crud_model->compared_shower();

			foreach ($full as $row) {

		?>

        <form class="sky-form">

			<div class="col-md-12">

			<div class="row margin-bottom-5">

				<div class="col-md-12">

	                <center><h3><?php echo $this->db->get_where('category',array('category_id'=>$row['category']))->row()->category_name; ?></h3></center>
<div class="table-responsive">
	                <table class="table table-sm" data-cat="<?php echo $row['category']; ?>">

	                    <tbody>

	                        <tr class="cat_<?php echo $row['category']; ?>">

	                            <th><?php echo translate('name');?></th>  

	                            <?php

	                            	$i = 0;

	                            	$products = $row['products'];

	                            	foreach ($products as $p) {

	                            		$i++;

	                            ?>

	                            <td class="colm_<?php echo $row['category']; ?>_<?php echo $i; ?>_name col-md-3" >

                                    <label style="width:100%;">

                                        <select data-placeholder="<?php echo translate('choose_a_product'); ?>" class="searcher chosen-select col-md-12" data-col="<?php echo $i; ?>" tabindex="2">

                                            <option value="0"><?php echo translate('choose_a_product'); ?></option>

                                            <?php

                                                $cat_pro = $this->db->get_where('product',array('category'=>$row['category']))->result_array();

                                                foreach ($cat_pro as $ty) {

                                            ?>

                                            <option value="<?php echo $ty['product_id']; ?>" <?php if($ty['product_id'] == $p){ echo 'selected'; } ?> ><?php echo $ty['title']; ?></option>

                                            <?php

                                                }

                                            ?>

                                        </select>

                                    </label>

	                            </td>    

	                            <?php

	                            	}

	                            	while($i < 3){

	                            		$i++;

	                            ?>

	                            <td class="colm_<?php echo $row['category']; ?>_<?php echo $i; ?>_name col-md-3" >

                                    <label style="width:100%;">

                                        <select data-placeholder="<?php echo translate('choose_a_product'); ?>" class="searcher chosen-select col-md-12" data-col="<?php echo $i; ?>" tabindex="2">

                                            <option value="0"><?php echo translate('choose_a_product'); ?></option>

                                            <?php

                                                $cat_pro = $this->db->get_where('product',array('category'=>$row['category']))->result_array();

                                                foreach ($cat_pro as $ty) {

                                            ?>

                                            <option value="<?php echo $ty['product_id']; ?>"><?php echo $ty['title']; ?></option>

                                            <?php

                                                }

                                            ?>

                                        </select>

                                    </label>

	                            </td>

	                            <?php

	                            	}

	                            ?>



	                        </tr>

	                        <tr class="cat_<?php echo $row['category']; ?>">

	                            <th><?php echo translate('image');?></th>  

	                            <?php

	                            	$i = 0;

	                            	$products = $row['products'];

	                            	foreach ($products as $p) {

	                            		$i++;

	                            ?>

	                            <td class="colm_<?php echo $row['category']; ?>_<?php echo $i; ?>_image col-md-3" >

	                            	<img src="<?php echo $this->crud_model->file_view('product',$p,'','','thumb','src','multi','one'); ?>" width="100" />

	                            </td>    

	                            <?php

	                            	}

	                            	while($i < 3){

	                            		$i++;

	                            ?>

	                            <td class="colm_<?php echo $row['category']; ?>_<?php echo $i; ?>_image col-md-3" ></td>

	                            <?php

	                            	}

	                            ?>

	                        </tr>



	                        <tr class="cat_<?php echo $row['category']; ?>">

	                            <th><?php echo translate('price');?></th>  

	                            <?php

	                            	$i = 0;

	                            	$products = $row['products'];

	                            	foreach ($products as $p) {

	                            		$i++;

	                            ?>

	                            <td class="colm_<?php echo $row['category']; ?>_<?php echo $i; ?>_price col-md-3" >

	                            	<?php echo currency().$this->db->get_where('product',array('product_id'=>$p))->row()->sale_price; ?>

	                            </td>    

	                            <?php

	                            	}

	                            	while($i < 3){

	                            		$i++;

	                            ?>

	                            <td class="colm_<?php echo $row['category']; ?>_<?php echo $i; ?>_price col-md-3" ></td>

	                            <?php

	                            	}

	                            ?>



	                        </tr>

	                        <tr class="cat_<?php echo $row['category']; ?>">

	                            <th><?php echo translate('brand');?></th>  

	                            <?php

	                            	$i = 0;

	                            	$products = $row['products'];

	                            	foreach ($products as $p) {

	                            		$i++;

	                            ?>

	                            <td class="colm_<?php echo $row['category']; ?>_<?php echo $i; ?>_brand col-md-3" >

	                            	<?php echo $this->crud_model->get_type_name_by_id('brand', $this->db->get_where('product',array('product_id'=>$p))->row()->brand, 'name'); ?>

	                            </td>

	                            <?php

	                            	}

	                            	while($i < 3){

	                            		$i++;

	                            ?>

	                            <td class="colm_<?php echo $row['category']; ?>_<?php echo $i; ?>_brand col-md-3" ></td>

	                            <?php

	                            	}

	                            ?>



	                        </tr>



	                         <tr class="cat_<?php echo $row['category']; ?>">
	                            <th><?php echo translate('type');?></th>  
	                            <?php
	                            	$i = 0;
	                            	$products = $row['products'];
	                            	foreach ($products as $p) {
	                            		$i++;
	                            ?>
	                            <td class="colm_<?php echo $row['category']; ?>_<?php echo $i; ?>_type col-md-3" >

	                            	<?php /*echo $this->crud_model->get_type_name_by_id('brand', $this->db->get_where('product',array('product_id'=>$p))->row()->brand, 'name');*/ ?>

	                            	<?php 

	                            	$typee=	$this->db->get_where('product',array('product_id'=>$p))->row()->product_type;

	                            	if($typee=='0')
                                    {
                                        echo "New";
                                    } 
                                    else
                                    {
                                        echo "Refurbished";
                                    }

                                    ?>

	                            
	                            </td>
	                            <?php
	                            	}
	                            	while($i < 3){
	                            		$i++;
	                            ?>
	                            <td class="colm_<?php echo $row['category']; ?>_<?php echo $i; ?>_type col-md-3" ></td>
	                            <?php
	                            	}
	                            ?>

	                        </tr>




	                        <tr class="cat_<?php echo $row['category']; ?>">

	                            <th><?php echo translate('sub_category');?></th>  

	                            <?php

	                            	$i = 0;

	                            	$products = $row['products'];

	                            	foreach ($products as $p) {

	                            		$i++;

	                            ?>

	                            <td class="colm_<?php echo $row['category']; ?>_<?php echo $i; ?>_sub col-md-3" >

	                            	<?php echo $this->crud_model->get_type_name_by_id('sub_category', $this->db->get_where('product',array('product_id'=>$p))->row()->sub_category, 'sub_category_name'); ?>

	                            </td>

	                            <?php

	                            	}

	                            	while($i < 3){

	                            		$i++;

	                            ?>

	                            <td class="colm_<?php echo $row['category']; ?>_<?php echo $i; ?>_sub col-md-3" ></td>

	                            <?php

	                            	}

	                            ?>

	                        </tr>



	                        <tr class="cat_<?php echo $row['category']; ?>">

	                            <th><?php echo translate('description');?></th>  

	                            <?php

	                            	$i = 0;

	                            	$products = $row['products'];

	                            	foreach ($products as $p) {

	                            		$i++;

	                            ?>

	                            <td class="colm_<?php echo $row['category']; ?>_<?php echo $i; ?>_description col-md-3" >

	                            	<?php echo $this->db->get_where('product',array('product_id'=>$p))->row()->description; ?>

	                            </td>

	                            <?php

	                            	}

	                            	while($i < 3){

	                            		$i++;

	                            ?>

	                            <td class="colm_<?php echo $row['category']; ?>_<?php echo $i; ?>_description col-md-3" ></td>

	                            <?php

	                            	}

	                            ?>



	                        </tr>



	                    </tbody>

	                </table>
	                </div>

	            </div>

                    

			</div>

		</div>

        </form>

		<?php

			}

		?>

		

	</div><!--/end row-->

</div><!--/end container-->    

<!--=== End Content Part ===-->

<script>

	$(document).ready(function(){

		$('.chosen-select').chosen();

	});



	$('.searcher').on('change',function(){

		var cat = $(this).closest('.table').data('cat');

		var col = $(this).data('col');

		var pro = $(this).val();

		$.getJSON("<?php echo base_url(); ?>index.php/home/compare/get_detail/"+pro,

			function(result){

		        $.each(result, function(i, field){

		            $('.colm_'+cat+'_'+col+'_'+i).html(field);

		        }

	        );

	    });

	});

</script>

<?php

	echo form_open(base_url() . 'index.php/home/compare/add', array(

		'method' => 'post',

		'id' => 'plistform',

        'enctype' => 'multipart/form-data'

	));

?>

<input type="hidden" name="category" id="categoryaa">

<input type="hidden" name="sub_category" id="sub_categoryaa">

<input type="hidden" name="featured" id="featuredaa">

<input type="hidden" name="range" id="rangeaa">

<input type="hidden" name="vendor" id="vendora">

</form>

<style>

.sub_cat{

padding-left:30px !important;

}

</style>

