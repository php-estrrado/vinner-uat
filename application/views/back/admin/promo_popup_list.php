	<div class="panel-body" id="demo_s">
		<table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-ignorecol="0,4" data-show-toggle="true" data-show-columns="false" data-search="true" >
			<thead>
				<tr>
					<th><?php echo translate('no');?></th>
					<th><?php echo translate('image');?></th>
					<th class="text-right"><?php echo translate('options');?></th>
				</tr>
			</thead>
				
			<tbody >
			<?php
                
           
				$i=0;
            	foreach($all_popups as $row){
            		$i++;
			?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td >
                        <img class="img-md"
                            src="<?php echo $this->crud_model->file_view('popup',$row['popup_id'],'100','','thumb','src','','','.jpg') ?>"  style="width:120px;"/>
                    </td>
                    <td class="text-right">
                        <!--<a class="btn btn-success btn-xs btn-labeled fa fa-wrench" data-toggle="tooltip" 
                            onclick="ajax_modal('edit','<?php echo translate('edit_popup'); ?>','<?php echo translate('successfully_edited!'); ?>','promo_popup_edit','<?php echo $row['popup_id']; ?>')" 
                                data-original-title="Edit" 
                                    data-container="body"><?php echo translate('edit');?>
                        </a>-->
                        
                        
                         <a class="btn btn-success btn-xs btn-labeled fa fa-check" data-toggle="tooltip" 
                    onclick="ajax_modal('approval','<?php echo translate('popup_approval'); ?>','<?php echo translate('successfully_updated!'); ?>','vendor_approval1','<?php echo $row['popup_id']; ?>')" data-original-title="View" data-container="body">
                        <?php echo translate('approval');?>
                </a>
                        
                        <a onclick="delete_confirm('<?php echo $row['popup_id']; ?>','<?php echo translate('really_want_to_delete_this?'); ?>')" 
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
           
	<!--<div id='export-div'>
		<h1 style="display:none;"><?php echo translate('promotional_popup'); ?></h1>
		<table id="export-table" data-name='slides' data-orientation='p' style="display:none;">
				<thead>
					<tr>
						<th><?php echo translate('no');?></th>
						<th><?php echo translate('name');?></th>
						<th><?php echo translate('category');?></th>
					</tr>
				</thead>
					
				<tbody >
				<?php
					$i = 0;
	            	foreach($all_popups as $row){
	            		$i++;
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $this->crud_model->get_type_name_by_id('category',$row['category'],'category_name'); ?></td>
				</tr>
	            <?php
	            	}
				?>
				</tbody>
		</table>
	</div>-->

<style>
	.highlight{
		background-color: #E7F4FA;
	}
</style>







           