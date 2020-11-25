<div id="content-container">

    <div id="page-title">

        <h1 class="page-header text-overflow"><?php echo translate(' Low Stock Report');?></h1>

    </div>

   
    <div class="tab-base">

        <div class="panel">

            <div class="panel-body">

                <div class="tab-content" id="list" >

                <!-- LIST -->

                  <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true"  data-show-toggle="true" data-show-columns="true" data-search="true" >

        <thead>
            <tr>
                <th style="width:4ex"><?php echo translate('sl no'); ?></th>
                <th><?php echo translate('product_name');?></th>
               <!-- <th><?php //echo translate('model');?></th>-->
                <th><?php echo translate('stock_status');?></th>
               
            </tr>
        </thead>
            
        <tbody>
        <?php
            $i = 0;
        
            foreach($report_stock as $row)
            {
                 if($this->crud_model->is_added_by('product',$row['product_id'],$this->session->userdata('vendor_id')))
                 {
                $i++; 
        ?>
        <tr class="<?php if($row['quantity'] !== 'ok'){ echo 'pending'; } ?>" >
            <td><?php echo $i; ?></td>
            <td><?php echo $row['title']; ?></td>
            <?php if($row['current_stock']<=0) { ?>
            <td><font style="color:red;"><?php  echo translate('OUT OF STOCK') ?></font></td>
            <?php } else { ?>
            <td><?php echo $row['current_stock']; ?></td>
     <?php 
            }
            
      ?>
        </tr>
        <?php
            }
            }
        ?>
        </tbody>
    </table>
                    
                    
                    

                </div>

            </div>

            <!--Panel body-->

        </div>

    </div>







<script>

    var base_url = '<?php echo base_url(); ?>'

    var user_type = 'vendor';

    var module = 'report_stock';

    var list_cont_func = 'list';

    var dlt_cont_func = 'delete';

    var loading = '<div>loading...<div>';
    </script>
</div>

<div id='export-div'>
        <h1 style="display:none;"><?php echo translate('Low Stock Report'); ?></h1>
        <table id="export-table" data-name='Low Stock Report' data-orientation='p' style="display:none;">
        <col width="50">
        <col width="500">
        <col width="200">
                <thead>
                    <tr>
                        <th style="width:4ex"><?php echo translate('no');?></th>
                        <th style="width:4ex"><?php echo translate('product_name');?></th>
                        <th style="width:4ex"><?php echo translate('stock_status');?></th>
                        
                    </tr>
                </thead>
                    
                <tbody >
               <?php
            $i = 0;
        
            foreach($report_stock as $row)
            {
                if($this->crud_model->is_added_by('product',$row['product_id'],$this->session->userdata('vendor_id')))
                 {
                $i++; 
        ?>
        <tr class="<?php if($row['quantity'] !== 'ok'){ echo 'pending'; } ?>" >
            <td><?php echo $i; ?></td>
            <td><?php echo $row['title']; ?></td>          
            <?php if($row['current_stock']<=0) { ?>
            <td><font style="color:red;"><?php  echo translate('OUT OF STOCK') ?></font></td>
            <?php } else { ?>
            <td><?php echo $row['current_stock']; ?></td>
     <?php } ?>
        </tr>
        <?php
            }
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