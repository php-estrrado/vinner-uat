<div class="panel-body" id="demo_s">
    <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" >
        <thead>
            <tr>
                <th><?php echo translate('no');?></th>
                <th><?php echo translate('Sale id');?></th>
                <th><?php echo translate('Salecode');?></th>
                <th ><?php echo translate('Firstname');?></th>
                <th ><?php echo translate('payment_type');?></th>
                <th><?php echo translate('payment_date');?>  </th>
                 <th><?php echo translate('payment_status');?></th>
                <th ><?php echo translate('Options');?></th>
            </tr>
        </thead>				
        <tbody >
        <?php
            $i = 0;
            foreach($all_users as $row){
                $i++;
                if($row['buyer']==0)
                {
                      $info = json_decode($row['shipping_address'],true);
        ?>                
        <tr>
            <td><?php echo $i-1; ?></td>
            <td><?php echo $row['sale_id']; ?></td>
            <td ><?php echo $row['sale_code'] ; ?></td>
            <td ><?php echo $info['firstname']; ?></td>
            <td> <?php echo translate($row['payment_type']); ?></td>
            <td><?php echo date('d M, Y',$row['sale_datetime'] );?></td>
            <td><?php echo translate($this->crud_model->sale_payment_status($row['sale_id'])); ?></td>
           
            <td>
                <a class="btn btn-mint btn-xs btn-labeled fa fa-location-arrow" data-toggle="tooltip" 
                    onclick="ajax_modal('view','<?php echo translate('view_address'); ?>','<?php echo translate('successfully_viewed!'); ?>','user_view','<?php echo $row['user_id']; ?>')" data-original-title="View" data-container="body">
                        <?php echo translate('address');?>
                </a>
                <a onclick="delete_confirm('<?php echo $row['sale_id']; ?>','<?php echo translate('really_want_to_delete_this?'); ?>')" class="btn btn-xs btn-danger btn-labeled fa fa-trash" data-toggle="tooltip" 
                    data-original-title="Delete" data-container="body">
                        <?php echo translate('delete');?>
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
    
    <div id='export-div' style="padding:40px;">
		<h1 id ='export-title' style="display:none;"><?php echo translate('users'); ?></h1>
		<table id="export-table" class="table" data-name='users' data-orientation='p' data-width='1500' style="display:none;">
				<colgroup>
					<col width="50">
					<col width="150">
					<col width="150">
					<col width="150">
				</colgroup>
				<thead>
					<tr>
						<th><?php echo translate('no');?></th>
                        <th><?php echo translate('name');?></th>
                        <th><?php echo translate('e-mail');?></th>
					<th><?php echo translate('total_purchase');?></th>
					</tr>
				</thead>



				<tbody >
				<?php
					$i = 0;
	            	foreach($all_users as $row){
	            		$i++;
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $row['username']; ?> <?php echo $row['surname']; ?></td>
					<td><?php echo $row['email']; ?></td>
					<td><?php echo currency().$this->crud_model->total_purchase($row['user_id']); ?></td>            	
				</tr>
	            <?php
	            	}
				?>
				</tbody>
		</table>
	</div>
           