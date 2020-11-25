<!--CONTENT CONTAINER-->

<?php 

	foreach($product_data as $row){

?>



<h4 class="modal-title text-center padd-all"><?php echo translate('details_of');?> <?php echo $row['title'];?></h4>

	<hr style="margin: 10px 0 !important;">

    <div class="row">

    <div class="col-md-12">

        <div class="text-center pad-all">

            <div class="col-md-3">

                <div class="col-md-12"><div class="row">

                    <img class="img-responsive thumbnail" alt="Profile Picture" 

                        src="<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one'); ?>">

                </div></div>

                <div class="col-md-12" style="text-align:justify;"><div class="row">

                    <p><?php echo $row['short_description'];?></p>

                </div></div>

            </div>

            <div class="col-md-9">   

                <table class="table table-striped" style="border-radius:3px; width: 100%; text-align: left;">

                    <tr>
                        <th class="custom_td"><?php echo translate('name');?></th>
                        <td class="custom_td"><?php echo $row['title']?></td>
                    </tr>

                    <tr>
                        <th class="custom_td"><?php echo translate('code');?></th>
                        <td class="custom_td"><?php echo $row['product_code']?></td>
                    </tr>


                    <tr>

                        <th class="custom_td"><?php echo translate('category');?></th>

                        <td class="custom_td">

                            <?php echo $this->crud_model->get_type_name_by_id('category',$row['category'],'category_name');?>

                        </td>

                    </tr>

                    <tr>

                        <th class="custom_td"><?php echo translate('industries');?></th>

                        <td class="custom_td"><?php
                            $brands     =   explode(',',$row['brand']);
                            foreach($brands as $brandId){ 
                            echo $this->crud_model->get_type_name_by_id('brand',$brandId).', '; } ?>

                        </td>

                    </tr>

                    <tr>

                        <th class="custom_td"><?php echo translate('unit');?></th>

                        <td class="custom_td"><?php echo $row['unit']; ?></td>

                    </tr>

                    <tr>

                        <th class="custom_td"><?php echo translate('base_price');?></th>

                        <td class="custom_td"><?php echo $row['sale_price']; ?> / <?php echo $row['unit']; ?></td>

                    </tr>

                    <tr>

                        <th class="custom_td"><?php echo $vendor->display_name.' '.translate('price');?></th>

                        <td class="custom_td"><?php echo $row['price']; ?> / <?php echo $row['unit']; ?></td>

                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('tag');?></th>
                        <td class="custom_td">
                            <?php foreach(explode(',',$row['tag']) as $tag){ ?>

                                <?php echo $tag; ?>

                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('description');?></th>
                        <td class="custom_td"><?php echo $row['description']; ?></td>
                    </tr>
                    <?php

                        $all_af = $this->crud_model->get_additional_fields($row['product_id']);

                        $all_c = json_decode($row['color']);

                    ?>

                    <tr style="display: none;">

                        <th class="custom_td"><?php echo translate('colors');?></th>

                        <td class="custom_td">

                            <?php 

                                if($all_c){

                                    foreach($all_c as $p){

                            ?>

                                <div style="background-color:<?php echo $p; ?>; width:30px; height:30px; margin:5px; border: 1px solid grey; float:left;"></div>

                            <?php

                                    }

                                }

                            ?>

                        </td>

                    </tr>

                    

                    <?php

                        if(!empty($all_af)){

                            foreach($all_af as $row1){

                    ?>

                    <tr>

                        <th class="custom_td"><?php echo $row1['name']; ?></th>

                        <td class="custom_td"><?php echo $row1['value']; ?></td>

                    </tr>

                    <?php

                            }

                        }

                    ?>

                </table>

            </div>

            <hr>

        </div>

    </div>

</div>				



<?php 

	}

?>

            

<style>

.custom_td{

border-left: 1px solid #ddd;

border-right: 1px solid #ddd;

border-bottom: 1px solid #ddd;

}

</style>



<script>

	$(document).ready(function(e) {

		proceed('to_list');

	});

</script>