    <div class="panel-body" id="demo_s">
           
        <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-ignorecol="0,4" data-show-toggle="true" data-show-columns="false" data-search="true" >



            <thead>

                <tr>

                    <th><?php echo translate('no');?></th>

                    <th><?php echo translate('Product_name');?></th>

                    <th><?php echo translate('Product_code');?></th>

                    <th><?php echo translate('vendor');?></th>

                    <th ><?php echo translate('Last Update');?></th>
                    <th><?php echo translate('Publish');?></th>

                    <!-- <th class="text-right"><?php echo translate('options');?></th> -->

                </tr>

            </thead>
             <?php
          
            ?>
                
<div class="pull-left ">
<select class="form-control col-sm-4" id="vendor_fl" placeholder="Select vendor" onchange="get_vendorprodct(this.value);" >
<!-- ajax_set_full('list','','','vendor_product',this.value);//"> -->

<option selected="" value=""> Select Vendor</option>
    <?php  foreach($all_vendor as $rowv)
            { ?>
               <option value="<?php echo $rowv['vendor_id'];?>" > <?php echo $rowv['name']; ?></option>
    <?php } ?>
</select>

</div>
            <tbody >

           <?php

           
                $i=0;

                foreach($all_products as $row){

                    $i++;

            ?>

                <tr>

                    <td><?php echo $i; ?></td>

                    <td><?php echo $row['title']; ?></td>

                    <td><?php echo $row['product_code']; ?></td>

                    <td>

                        <?php

                            $by = json_decode($row['added_by'],true);

                            $name = $this->crud_model->get_type_name_by_id($by['type'],$by['id'],'name'); 

                        ?>

                        <?php echo $name; ?> 

                    </td>

                     <td><?php echo date('d/m/Y ', $row['update_time']); ?></td>
                    
                    <td>

                        <input id="pub_<?php echo $row['product_id']; ?>" class='sw1' type="checkbox" data-id='<?php echo $row['product_id']; ?>' <?php if($row['status'] == 'ok'){ ?>checked<?php } ?> />


                    </td>


                </tr>

            <?php

                }

            ?>

            </tbody>

        </table>

    </div>

    <div id="coupn"></div>

    <div id='export-div'>

        <h1 style="display:none;"><?php echo translate('Products'); ?></h1>

        <table id="export-table" data-name='vendor products' data-orientation='p' style="display:none;">

                <thead>

                    <tr>

                    <th><?php echo translate('no');?></th>

                    <th><?php echo translate('Product_name');?></th>

                    <th><?php echo translate('Product_code');?></th>

                    <th><?php echo translate('vendor');?></th>

                    </tr>

                </thead>

                    

                <tbody >

                <?php

                    $i = 0;

                    foreach($all_products as $row){


                        $i++;

                ?>

                <tr>

                     <td><?php echo $i; ?></td>

                    <td><?php echo $row['title']; ?></td>

                    <td><?php echo $row['product_code']; ?></td>

                    <td>

                        <?php

                            $by = json_decode($row['added_by'],true);

                            $name = $this->crud_model->get_type_name_by_id($by['type'],$by['id'],'name'); 

                        ?>

                        <?php echo $name; ?> 

                    </td>
                </tr>

                <?php

                    }

                ?>

                </tbody>

        </table>

    </div>



<style>

    .highlight{

        background-color: #E7F4FA;

    }

</style>






<script type="text/javascript">
    
function get_vendorprodct(listid) 
{
    window.location.replace(base_url+'index.php/'+user_type+'/'+'vendor_product'+'/'+listid);
}


</script>








           