	<div class="panel-body" id="demo_s">
		<table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-ignorecol="0,4" data-show-toggle="true" data-show-columns="false" data-search="true" >

			<thead> 
				<tr>
					<th><?php echo translate('no');?></th> 
					<th><?php echo translate('name');?></th>
					<th><?php echo translate('email');?></th>
					<th><?php echo translate('mobile');?></th>
					<th><?php echo translate('city');?></th>
					<th><?php echo translate('country');?></th>  
					<th><?php echo translate('date');?></th>
				    <th><?php echo translate('service_category');?></th>
				    <th><?php echo translate('service_type');?></th>
					<th class="text-right"><?php echo translate('options');?></th>
				</tr>
			</thead>
				
			<tbody >
			<?php
				$i=0;
            	foreach($all_request_service as $row){ 
            		$i++;
			?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['name']; ?></td>
                     <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                    <td><?php echo $row['city']; ?></td>
                    <!--<td><?php // echo $this->crud_model->get_type_name_by_ids('cities',$row['city'],'name'); ?></td>   -->
                    <td><?php echo $this->crud_model->get_type_name_by_ids('countries',$row['country'],'name'); ?></td>  
                    <td><?php echo date('d F Y', strtotime($row['date'])); ?></td>
                    <td><?php echo $this->crud_model->get_type_name_by_id('service_category',$row['service_category'],'name'); ?></td> 
                    <td><?php echo $this->crud_model->get_type_name_by_id('service_type',$row['service_type'],'type'); ?></td>     
 
                    <td class="text-right">
                          <a class="btn btn-dark btn-xs btn-labeled fa fa-user" data-toggle="tooltip" 
                    onclick="ajax_modal('view','<?php echo translate('view_service_request'); ?>','<?php echo translate('successfully_viewed!'); ?>','request_service_view','<?php echo $row['request_id']; ?>')" data-original-title="View" data-container="body">
                        <?php echo translate('view');?>
                       </a>
                        
                        <!--<a onclick="delete_confirm('<?php //echo $row['request_id']; ?>','<?php //echo translate('really_want_to_delete_this?'); ?>')" -->
                        <!--    class="btn btn-danger btn-xs btn-labeled fa fa-trash" -->
                        <!--        data-toggle="tooltip" data-original-title="Delete" -->
                        <!--            data-container="body"><?php //echo translate('delete');?>-->
                        <!--</a>-->
                        
                    </td>
                </tr>
            <?php
            	}
			?>
			</tbody>
		</table>
	</div>
	
      
     <div id="vendr"></div>
    <div id='export-div' style="padding:40px;">
		<h1 id ='export-title' style="display:none;"><?php echo translate('users'); ?></h1>
		<table id="export-table" class="table" data-name='users' data-orientation='p' data-width='1500' style="display:none;">
				<colgroup>
					<col width="50">
					<col width="100">
					<col width="150">
					<col width="100">
					<col width="100">
                    <col width="120">
				</colgroup>
				<thead>
					<tr>
						<th><?php echo translate('no');?></th>
                        <th><?php echo translate('name');?></th>
    					<th><?php echo translate('mobile');?></th>
    					<th><?php echo translate('country');?></th>  
    				    <th><?php echo translate('category');?></th>
    				    <th><?php echo translate('type');?></th>
				</thead>



				<tbody >
				<?php
                $i = 0;
                    foreach($all_request_service as $row){
                $i++;
	        ?>                
	        <tr>
	            <td><?php echo $i; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['mobile']; ?></td>
                <td><?php echo $this->crud_model->get_type_name_by_ids('countries',$row['country'],'name'); ?></td>  
                <td><?php echo $this->crud_model->get_type_name_by_id('service_category',$row['service_category'],'name'); ?></td> 
                <td><?php echo $this->crud_model->get_type_name_by_id('service_type',$row['service_type'],'type'); ?></td>  	
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







           