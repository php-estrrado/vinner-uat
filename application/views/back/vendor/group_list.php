    <div class="panel-body" id="demo_s">
        <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-ignorecol="0,4" data-show-toggle="true" data-show-columns="false" data-search="true" >

            <thead>
                <tr>
                    <th><?php echo translate('no');?></th>
                    <th><?php echo translate('group_name');?></th>
                    <th><?php echo translate('current_quantity');?></th>
                    <th><?php echo translate('publish');?></th>
                     <th><?php echo translate('Admin_Status');?></th>
                    <th class="text-right"><?php echo translate('options');?></th>
                </tr>
            </thead>
                
            <tbody >
            <?php // echo '<pre>'; print_r($all_products); echo '</pre>'; die;
                $i=0;
                foreach($all_products as $row){
                if($this->crud_model->is_added_by('product',$row['product_id'],$this->session->userdata('vendor_id'))){    
                    $i++;
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td>
                    <?php echo $row['current_stock']; ?> <?php //echo '('.$row['unit'].'(s))'; ?>
                    </td>
        
                    <td> 
                      <?php 

                if($row['vendor_approved'] == '1')
                {
                    echo '<input id="pub_'.$row['product_id'].'" class="sw1" type="checkbox" data-id="'.$row['product_id'].'" checked />';
                } 
                else 
                {
                    echo '<input id="pub_'.$row['product_id'].'" class="sw1" type="checkbox" data-id="'.$row['product_id'].'" />';
                } ?>
                    </td>

                    <td>
                   <?php 

                if($row['status'] == 'ok')
                { ?>
                    <div class='label label-purple'>
                        Approved</div>
                <?php } 
                else 
                {
                   echo "<div class='label label-danger'>Pending</div>";
                } ?>
                    </td>


                    <td class="text-right">

                        <a class="btn btn-info btn-xs btn-labeled fa fa-location-arrow" data-toggle="tooltip"  data-original-title="View" data-container="body" onclick="ajax_set_full('view','<?php echo translate('view_product'); ?>','<?php echo translate('successfully_viewed!'); ?>' , 'product_view','<?php echo $row['product_id']; ?>');proceed('to_list');">
                            <?php echo translate('view'); ?>
                        </a>

                        <a class="btn btn-success btn-xs btn-labeled fa fa-wrench" data-toggle="tooltip"  data-original-title="Edit" data-container="body" onclick="proceed('to_list');ajax_set_full('edit','<?php echo translate('edit_group'); ?>','<?php echo translate('successfully_edited!'); ?>','group_edit','<?php echo $row['product_id']; ?>')"  >
                            <?php echo translate('edit');?>
                        </a>

                        <a class="btn btn-mint btn-xs btn-labeled fa fa-plus-square" data-toggle="tooltip" data-original-title="Edit" data-container="body" onclick="ajax_modal('add_stock','<?php echo translate('add_product_quantity'); ?>','<?php echo translate('quantity_added!');?>','stock_add','<?php echo $row['product_id']; ?>')" >
                         <?php echo translate('stock'); ?>
                        </a>

                        <a class="btn btn-dark btn-xs btn-labeled fa fa-minus-square" data-toggle="tooltip" data-original-title="Edit" data-container="body"  onclick="ajax_modal('destroy_stock','<?php echo translate('reduce_product_quantity'); ?>','<?php echo translate('quantity_reduced!'); ?>','destroy_stock','<?php echo $row['product_id']; ?>')" >
                             <?php echo translate('stock'); ?>
                        </a> 
                        
                        <a class="btn btn-danger btn-xs btn-labeled fa fa-trash" data-toggle="tooltip" data-original-title="Delete" data-container="body" onclick="delete_confirm('<?php echo $row['product_id']; ?>','<?php echo translate('really_want_to_delete_this?'); ?>')" >
                            <?php echo translate('delete'); ?>
                        </a>
                        
                    </td>
                </tr>
            <?php
                }
                }
            ?>
            </tbody>
        </table>
    </div>
    <div id="coupn"></div>
    <div id='export-div'>
        <h1 style="display:none;"><?php echo translate('Product Group'); ?></h1>
        <table id="export-table" class="" data-name='Product Groups' data-orientation='p' style="display:none;">
        <col width="50">
        <col width="200">
        <col width="500">
                <thead>
                    <tr>
                        <th><?php echo translate('no');?></th>
                        <th><?php echo translate('title');?></th>
                        <th><?php echo translate('product_list');?></th>
                    </tr>
                </thead>
                    
                <tbody >
                <?php
                $i=0;
                foreach($all_products as $row)
                {
                    $i++;
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td>
                        
                        <?php
                            $plist="";
                            foreach ($products as $product) 
                            {

                            $name = $product['title']; 
                            $qty=$product['qty'];
                            $plist=$name."(".$qty."),".$plist;
                            }
                        ?>
                        <?php echo $plist;
                        ?> 

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


    $(document).ready(function() {
       // set_switchery();
    });
     
   /* $(".sw2").each(function(){
                        new Switchery(document.getElementById('fet_'+$(this).data('id')), {color:'rgb(100, 189, 99)', secondaryColor: '#cc2424', jackSecondaryColor: '#c8ff77'});

                var changeCheckbox = document.querySelector('#fet_'+$(this).data('id'));

                changeCheckbox.onchange = function() {

                  //alert($(this).data('id'));

                  ajax_load(base_url+'index.php/'+user_type+'/'+module+'/product_featured_set/'+$(this).data('id')+'/'+changeCheckbox.checked,'prod','others');

                  if(changeCheckbox.checked == true){

                    $.activeitNoty({

                        type: 'success',

                        icon : 'fa fa-check',

                        message : pfe,

                        container : 'floating',

                        timer : 3000

                    });

                    sound('featured');

                  } else {

                    $.activeitNoty({

                        type: 'danger',

                        icon : 'fa fa-check',

                        message : pufe,

                        container : 'floating',

                        timer : 3000

                    });

                    sound('unfeatured');

                  }

                  //alert(changeCheckbox.checked);

                };
        });*/

</script>

