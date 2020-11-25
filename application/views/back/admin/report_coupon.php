<div id="content-container">

	<div id="page-title">

		<h1 class="page-header text-overflow"><?php echo translate('coupon_report');?></h1>

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
                <th><?php echo translate('Title');?></th>
                <th><?php echo translate('code');?></th>
                <th><?php echo translate('number of_uses');?></th>

               
            </tr>
</thead>
            
        <tbody>
        <?php
            $i = 0;
            foreach($report_coupon as $row){
                $i++; 
        ?>
        <tr  >
            <td><?php echo $i; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['code']; ?></td>
            <td><?php echo $row['status']; ?></td>
     
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

	var module = 'report_coupon';

	var list_cont_func = 'list';

	var dlt_cont_func = 'delete';

	var loading = '<div>loading...<div>';
    </script>
</div>

<div id='export-div'>
        <h1 style="display:none;"><?php echo translate('Coupon Usage Report'); ?></h1>
        <table id="export-table" data-name='Coupon Usage Report' data-orientation='p' style="display:none;">
                <thead>
                    <tr>
                        <th><?php echo translate('no');?></th>
                        <th><?php echo translate('title');?></th>
                        <th><?php echo translate('code');?></th>
                        <th><?php echo translate('number of_uses');?></th>
                    </tr>
                </thead>
                    
                <tbody >
                <?php
                    $i = 0;
            foreach($report_coupon as $row){
                $i++; 
        ?>
        <tr  >
            <td><?php echo $i; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['code']; ?></td>
            <td><?php echo $row['status']; ?></td>
     
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