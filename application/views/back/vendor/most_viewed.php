<div id="content-container">
	<div id="page-title">
		<h1 class="page-header text-overflow" ><?php echo translate('Most viewed');?></h1>
	</div>
	<div class="tab-base">
		<div class="panel">
			<div class="panel-body">
                <!-- LIST -->
                <div class="tab-pane fade active in" id="list">
                <div class="panel-body" id="demo_s">
    <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true"  data-show-toggle="true" data-show-columns="true" data-search="true" >

        <thead>
            <tr>
                <th style="width:4ex"><?php echo translate('sl no'); ?></th>
                <th><?php echo translate('product_name');?></th>
                <th><?php echo translate('viewed');?></th>
               
            </tr>
        </thead>
            
        <tbody>
        <?php
            $i = 0;
            foreach($most_viewed as $row)
            {
                if($this->crud_model->is_added_by('product',$row['product_id'],$this->session->userdata('vendor_id')))
                {
                    $i++; 
        ?>
        <tr class="<?php if($row['viewed'] !== 'ok'){ echo 'pending'; } ?>" >
            <td><?php echo $i; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['number_of_view']; ?></td>
        </tr>
        <?php
            }
            }
        ?>
        </tbody>
    </table>
</div>  
    
    
<style type="text/css">
	/*.pending{
		background: #D2F3FF  !important;
	}
	.pending:hover{
		background: #9BD8F7 !important;
	}*/
</style>

           
                </div>
			</div>
        </div>
	</div>
</div>

<script>
	var base_url = '<?php echo base_url(); ?>'
	var user_type = 'vendor';
	var module = 'most_viewed';
	var list_cont_func = 'list';
	var dlt_cont_func = 'delete';
</script>

<div id='export-div'>
        <h1 style="display:none;"><?php echo translate('Most Viewed Report'); ?></h1>
        <table id="export-table" data-name='Mostviewed Report' data-orientation='p' style="display:none;">
        <col width="50">
        <col width="500">
        <col width="200">
                <thead>
                    <tr>
                        <th style="width:4ex"><?php echo translate('no');?></th>
                        <th style="width:4ex"><?php echo translate('product_name');?></th>
                        <th style="width:6ex"><?php echo translate('viewed');?></th>
                    </tr>
                </thead>
                    
                <tbody >
            <?php
            $i = 0;
            foreach($most_viewed as $row)
            {
            if($this->crud_model->is_added_by('product',$row['product_id'],$this->session->userdata('vendor_id')))
                {
                $i++; 
            ?>
        <tr class="<?php if($row['viewed'] !== 'ok'){ echo 'pending'; } ?>" >
            <td><?php echo $i; ?></td>
            <td><?php echo $row['title']; ?></td>

            <td><?php echo $row['number_of_view']; ?></td>
     
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