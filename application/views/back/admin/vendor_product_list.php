<style> #wh_list{ position: relative; top: 10px; } </style> 
<div class="panel-body" id="demo_s">
           
        <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-ignorecol="0,4" data-show-toggle="true" data-show-columns="false" data-search="true" >



            <thead>

                <tr>

                    <th><?php echo translate('ID');?></th>

                    <th><?php echo translate('Product_name');?></th>

                    <th><?php echo translate('Product_code');?></th>

                    <th><?php echo translate('base_price');?></th>

                    <th ><?php echo translate('warehouse_price');?></th>
                    <th><?php echo translate('Publish');?></th>

                    <!-- <th class="text-right"><?php echo translate('options');?></th> -->

                </tr>

            </thead>
             <?php
          
            ?>
                
<div class="pull-left col-sm-6">
    <select id="wh_list" class="form-control" id="vendor_fl" placeholder="Select Warehouse" onchange="get_vendorprodct(this.value)" >
<!-- ajax_set_full('list','','','vendor_product',this.value);//"> -->

<option selected="" value=""> Select Warehouse</option>
    <?php  foreach($all_vendor as $rowv){
        if($vendor_id == $rowv['vendor_id']){ $selected = 'selected="selected"'; }else{ $selected = ''; } ?>
               <option value="<?php echo $rowv['vendor_id'];?>" <?php echo $selected?> > <?php echo $rowv['name']; ?></option>
    <?php } ?>
</select>
<?php $vendor         =   $this->db->join('countries as C','V.country_code = C.id')->get_where('vendor as V',['V.vendor_id'=>$vendorId])->row();  ?>
</div>
            <tbody >

           <?php

           
                $i=0;

                foreach($all_products as $row){

                    $i++;

            ?>

                <tr>

                    <td><?php echo $i; ?></td>

                    <td><?php echo $row->title; ?></td>

                    <td><?php echo $row->product_code; ?></td>
                    <td><?php echo 'AED '.$row->sale_price; ?></td>
                    <td><?php echo $vendor->currency.' '.$row->price; ?></td>
                   
                    <td>
                        <input id="pub_<?php echo $row->product_id; ?>" class='sw1' type="checkbox" data-id='<?php echo $row->product_id; ?>' <?php if($row->pStatus == 'ok'){ ?>checked<?php } ?> />
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

        <h1 style="display:none;"><?php echo translate('warehouse products'); ?></h1>

        <table id="export-table" data-name='warehouse products' data-orientation='p' style="display:none;">

                <thead>

                    <tr>

                    <th><?php echo translate('ID');?></th>

                    <th><?php echo translate('Product_name');?></th>

                    <th><?php echo translate('Product_code');?></th>

                    <th><?php echo translate('base_price');?></th>

                    <th ><?php echo translate('warehouse_price');?></th>

                    </tr>

                </thead>

                    

                <tbody >

                <?php

                    $i=0;

                foreach($all_products as $row){

                    $i++;

            ?>

                <tr>

                    <td><?php echo $i; ?></td>

                    <td><?php echo $row->title; ?></td>

                    <td><?php echo $row->product_code; ?></td>
                    <td><?php echo 'AED '.$row->sale_price; ?></td>
                    <td><?php echo $vendor->currency.' '.$row->price; ?></td>                    
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
//    
function get_vendorprodct(listid) 
{
    window.location.replace(base_url+user_type+'/'+'vendor_product'+'/'+listid);
}
//    $(document).ready(function(){
//        $('#wh_list').on('change',function(){
//           $('.wh').hide(); $('.wh-'+this.value).show(); 
//        });
//        $('body').on('click','.pagination li.page-number a',function(){
//           alert('sss'); 
//        });
//    });

</script>








           