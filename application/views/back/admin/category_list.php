	<div class="panel-body" id="demo_s">

		<table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-ignorecol="0,2" data-show-toggle="true" data-show-columns="false" data-search="true" >



			<thead>

				<tr>

					<th><?php echo translate('no');?></th>

					<th><?php echo translate('name');?></th>

					<th class="text-right"><?php echo translate('options');?></th>

				</tr>

			</thead>

				

			<tbody >

			<?php

				$i = 0;

            	foreach($all_categories as $row){

            		$i++;

			?>

			<tr>

				<td><?php echo $i; ?></td>

				<td><?php echo $row['category_name']; ?></td>

				<td class="text-right">

					<a class="btn btn-success btn-xs btn-labeled fa fa-wrench" data-toggle="tooltip" 

                    	onclick="ajax_modal('edit','<?php echo translate('edit_category'); ?>','<?php echo translate('successfully_edited!'); ?>','category_edit','<?php echo $row['category_id']; ?>')" 

                        	data-original-title="Edit" data-container="body">

                            	<?php echo translate('edit');?>

                    </a>

					<!--<a onclick="delete_confirm('<?php //echo $row['category_id']; ?>','<?php //echo translate('really_want_to_delete_this?'); ?>') <!--" class="btn btn-danger btn-xs btn-labeled fa fa-trash" data-toggle="tooltip" 
                    	data-original-title="Delete" data-container="body">
                        	<?php/// echo translate('delete');?>
                  <!--  </a> -->

                <?php 
                  $ex=0; $ex2=0; $ex5=0;
                  $ex2=$this->db->get_where('sub_category',array('category'=>$row['category_id']))->num_rows();
                  $ex=$this->db->get_where('product',array('category'=>$row['category_id']))->num_rows();
                  $ex5=$ex+$ex2;
              	  //echo $ex."and".$ex2."and".$ex5;
                ?>			
                 <a class="btn btn-danger btn-xs btn-labeled fa fa-trash" data-toggle="tooltip" data-original-title="Delete" data-container="body" onclick="<?php if ($ex5==0) { ?>
                  delete_confirm('<?php echo $row['category_id']; ?>','<?php echo translate('really_want_to_delete_this?'); ?>') <?php } else { ?> delete_reject('Warning it has Sub Categories/Products.');   <?php } ?> " >
                    <?php echo translate('delete');?>
                 </a>

				</td>

			</tr>

            <?php

            	}

			?>

			</tbody>

		</table>

	</div>

           

	<div id='export-div'>

		<h1 style="display:none;"><?php echo translate('category'); ?></h1>

		<table id="export-table" data-name='category' data-orientation='p' style="display:none;">

				<thead>

					<tr>

						<th><?php echo translate('no');?></th>

						<th><?php echo translate('name');?></th>

					</tr>

				</thead>

					

				<tbody >

				<?php

					$i = 0;

	            	foreach($all_categories as $row){

	            		$i++;

				?>

				<tr>

					<td><?php echo $i; ?></td>

					<td><?php echo $row['category_name']; ?></td>

				</tr>

	            <?php

	            	}

				?>

				</tbody>

		</table>

	</div>



<script type="text/javascript">
	
function delete_reject(msg)
{ 
	$.activeitNoty({
			type: 'danger',
			icon : 'fa fa-warning',
			message : msg , // "You can not delete this data now.This data used in other records now..",
			container : 'floating',
			timer : 3000
			});
}

</script>