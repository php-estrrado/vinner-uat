<div class="panel-body" id="demo_s">
		<table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-ignorecol="0,4" data-show-toggle="false" data-show-columns="false" data-search="true" >

			<thead>
				<tr>
					<th><?php echo translate('no');?></th>
					<th><?php echo translate('group _name');?></th>
					<th><?php echo translate('product');?></th>
					<th><?php echo translate('coupon_code');?></th>
					<th><?php echo translate('valid_till');?></th>
					<th><?php echo translate('status');?></th>
					<th class="text-right"><?php echo translate('options');?></th>
				</tr>
			</thead>
				
			<tbody >
			<?php
				$i=0;
                foreach($all_coupons as $row)
                {
            		$i++;
            		
                    $spec = json_decode($row['spec'],true);
                    $spr_id=str_replace("[",'',$spec['set']);$spr_id=str_replace('"','',$spr_id);$spr_id=str_replace("]",'',$spr_id); 
                    $grprduct=$this->crud_model->get_type_name_by_id('product',$spr_id,'title');
                             
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo ucfirst($grprduct); ?></td>
                        <td><?php echo $row['code']; ?></td>
                        <td>
                            <?php
                                echo date('d-m-Y',strtotime($row['till'])); 
                            ?>
                        </td>
                        <td>
                            <input id="pub_<?php echo $row['coupon_id']; ?>" class='sw1' type="checkbox" data-id='<?php echo $row['coupon_id']; ?>' <?php if($row['status'] == 'ok'){ ?>checked<?php } ?> />
                        </td>
                        
                        <td class="text-right">
                            <a class="btn btn-success btn-xs btn-labeled fa fa-wrench" data-toggle="tooltip" 
                            onclick="ajax_modal('edit','<?php echo translate('abandon_group'); ?>','<?php echo translate('successfully_edited!'); ?>','abandon_group_edit','<?php echo $row['coupon_id']; ?>')" 
                                data-original-title="Edit" data-container="body"><?php echo translate('edit');?></a>
                            
                            <a onclick="delete_confirm('<?php echo $row['coupon_id']; ?>','<?php echo translate('really_want_to_delete_this?'); ?>')" 
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
		<h1 style="display:none;"><?php echo translate('abandon_groups'); ?></h1>
		<table id="export-table" data-name='coupon' data-orientation='p' style="display:none;">
				<thead>
					<tr>
						<th><?php echo translate('no');?></th>
						<th><?php echo translate('title');?></th>
						<th><?php echo translate('code');?></th>
					</tr>
				</thead>
					
				<tbody>
                    <?php
                        $i = 0;
                        foreach($all_coupons as $row)
                        {
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $row['code']; ?></td>
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







           