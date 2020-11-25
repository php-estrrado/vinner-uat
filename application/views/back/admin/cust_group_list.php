	<div class="panel-body" id="demo_s">
		<table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-ignorecol="0,4" data-show-toggle="true" data-show-columns="false" data-search="true" >

			<thead>
				<tr>
					<th><?php echo translate('no');?></th>
					<th><?php echo translate('title');?></th>
					<th><?php echo translate('customer_list');?></th>
					<th><?php echo translate('added_by');?></th>
					<th><?php echo translate('status');?></th>
					<th><?php echo translate('discount');?></th>
					<th class="text-right"><?php echo translate('options');?></th>
				</tr>
			</thead>
				
			<tbody >
			<?php
				$i=0;
            	foreach($all_customer_group as $row){
            		$i++;
			?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td>
						<?php
                    		$by = json_decode($row['customer_list'],true);
                    		$plist="";
                    		$c=1;
                    		foreach ($by as $row2) 
                    		{

                    		$name =	$this->crud_model->get_type_name_by_id('user', $row2['cid'],'username'); 
                    		//$qty=$row2['qty'];
                    		$plist.="(".$c.").".$name."<br/>";
                    			$c+=1;
                    		}
                    	?>
                    	<?php echo $plist; ?> 
                    </td>
                    <td>
                    	<?php
                    		$by = json_decode($row['added_by'],true);
                    		$name = $this->crud_model->get_type_name_by_id($by['type'],$by['id'],'name'); 
                    	?>
                    	<?php echo $name; ?> (<?php echo $by['type']; ?>)
                    </td>

                    

		            <td>
		                <input id="pub_<?php echo $row['group_id']; ?>" class='sw1' type="checkbox" data-id='<?php echo $row['group_id']; ?>' <?php if($row['status'] == 'ok'){ ?>checked<?php } ?> />
		            </td>

		            <td>
                    	
                    	<?php echo $row['discount']; ?> (<?php echo $row['discount_type']; ?>)
                    </td>

                    
                    <td class="text-right">
                        <a class="btn btn-success btn-xs btn-labeled fa fa-wrench" data-toggle="tooltip" 
                            onclick="proceed('to_list');ajax_set_full('edit','<?php echo translate('edit_Customer_Group'); ?>','<?php echo translate('successfully_edited!'); ?>','cust_group_edit','<?php echo $row['group_id']; ?>')" 
                                data-original-title="Edit" 
                                    data-container="body"><?php echo translate('edit');?>
                        </a>
                        
                        <a onclick="delete_confirm('<?php echo $row['group_id']; ?>','<?php echo translate('really_want_to_delete_this?'); ?>')" 
                            class="btn btn-danger btn-xs btn-labeled fa fa-trash" 
                                data-toggle="tooltip" data-original-title="Delete" 
                                    data-container="body"><?php echo translate('delete');?>
                        </a>
                        
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
		<h1 style="display:none;"><?php echo translate('customer_groups'); ?></h1>
		<table id="export-table" data-name='customer_groups' data-orientation='p' style="display:none;">
		<col width="50">
        <col width="200">
        <col width="600">
        <col width="450">
        <col width="300">
				<thead>
					<tr>
					<th><?php echo translate('no');?></th>
					<th><?php echo translate('title');?></th>
					<th><?php echo translate('customer_list');?></th>
					<th><?php echo translate('added_by');?></th>
					<th><?php echo translate('discount');?></th>
					</tr>
				</thead>
					
				<tbody >
				<?php
				$i=0;
            	foreach($all_customer_group as $row){
            		$i++;
			?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td>
						<?php
                    		$by = json_decode($row['customer_list'],true);
                    		$plist="";
                    		$c=1;
                    		foreach ($by as $row2) 
                    		{

                    		$name =	$this->crud_model->get_type_name_by_id('user', $row2['cid'],'username'); 
                    		//$qty=$row2['qty'];
                    		$plist.="(".$c.").".$name.",";
                    			$c+=1;
                    		}
                    	?>
                    	<?php echo $plist; ?> 
                    </td>
                    <td>
                    	<?php
                    		$by = json_decode($row['added_by'],true);
                    		$name = $this->crud_model->get_type_name_by_id($by['type'],$by['id'],'name'); 
                    	?>
                    	<?php echo $name."(". $by['type'].")"; ?>
                    </td>

		            <td>
                    	<?php echo $row['discount']."(".$row['discount_type'].")"; ?>
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







           