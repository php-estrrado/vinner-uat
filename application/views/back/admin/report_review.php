<div id="content-container">

	<div id="page-title">

		<h1 class="page-header text-overflow"><?php echo translate('Review Report');?></h1>

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
                <th><?php echo translate('review_count');?></th>
               
            </tr>
        </thead>
            
        <tbody>
        <?php
            $i = 0;
        
            foreach($report_review as $row){
                $i++; 
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php
             echo $this->crud_model->get_type_name_by_id('product', $row['product_id'], 'title'); ?></td>
            <td><?php echo $row['total']; ?></td>
             </tr>
        <?php
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

	var user_type = 'admin';

	var module = 'report_review';

	var list_cont_func = 'list';

	var dlt_cont_func = 'delete';

	var loading = '<div>loading...<div>';
    </script>
</div>


<div id='export-div'>
        <h1 style="display:none;"><?php echo translate('Review Report'); ?></h1>
        <table id="export-table" data-name='Review Report' data-orientation='p' style="display:none;">
                <thead>
                    <tr>
                        <th style="width:4ex"><?php echo translate('no');?></th>
                        <th style="width:4ex"><?php echo translate('product_name');?></th>
                        <th style="width:5ex"><?php echo translate('reviewcount');?></th>
                    </tr>
                </thead>
                    
                <tbody >
                <?php
                    $i = 0;
                    foreach($report_review as $row){
                $i++; 
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php
             echo $this->crud_model->get_type_name_by_id('product', $row['product_id'], 'title'); ?></td>
            <td><?php echo $row['total']; ?></td>
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
