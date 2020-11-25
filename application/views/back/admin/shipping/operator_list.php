
<div class="panel-body" id="demo_s">
    <table id="operators-table" class="table table-striped"  data-url="<?php echo base_url('admins/shipping/operators/list')?>"  data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-search="true" data-show-export="true" >
        <thead>
            <tr>
                <th><?php echo translate('ID');?></th>
                <th><?php echo translate('operator');?></th>
                <th><?php echo translate('phone');?></th>
                <th><?php echo translate('email');?></th>
                <th><?php echo translate('country');?></th>
             <!--    <th><?php // echo translate('state');?></th>
                <th><?php // echo translate('city');?></th>-->
                <th><?php echo translate('website');?></th>
                <th><?php echo translate('status');?></th>
                <th class="text-right"><?php echo translate('options');?></th>
            </tr>
        </thead>                
        <tbody><?php
            if($Operators){ foreach($Operators as $row){ 
                if($row->status == 1){
                    $status = '<input id="status_'.$row->id.'" class="sw2" type="checkbox" data-id="'.$row->id.'" checked />';
                }else{
                    $status = '<input id="status_'.$row->id.'" class="sw2" type="checkbox" data-id="'.$row->id.'" />';
                }?>
            <tr id="row_<?php echo $row->id?>">
                <td><?php echo $row->id?></td>
                <td><?php echo $row->operator?></td>
                <td><?php echo $row->phone?></td>
                <td><?php echo $row->email?></td>
               <td><?php echo $row->country?></td>
            <!--     <td><?php //echo $row->state?></td>
                <td><?php// echo $row->city?></td>-->
                <td><?php echo $row->website?></td>
                <td><?php
                    if($row->status == 1){ echo '<div class="label label-purple">'.translate('active').'</div>'; }
                    else{ echo '<div class="label label-danger">'.translate('inactive').'</div>'; } ?>
                </td>
                <td>
<!--                    <a class="btn btn-success btn-xs btn-labeled fa fa-wrench" data-toggle="tooltip" onclick="ajax_modal('edit',<?php echo translate('edit_operator')?>,<?php echo translate('operator_updated_successfully')?>,'operator_detail',<?php echo $row->id?>)" data-original-title="Edit" data-container="body">Edit
                        </a>-->
                            <?php  ?>
                        <a id="edit_<?php echo $row->id?>" class="btn btn-info btn-xs btn-labeled fa fa-plus-square editBtn" data-toggle="tooltip" 
                                    onclick="ajax_modal('edit','<?php echo translate('edit_operator')?>','<?php echo translate('operator_updated!')?>','operator_detail','<?php echo $row->id?>')" data-original-title="Edit" data-container="body">
                                        <?php echo translate('Edit')?>
                        </a>
                    <a onclick="del_confirm(<?php echo $row->id?>, <?php echo "'".translate('really_want_to_delete_this?')."'"?>,'admins/shipping/','operators','delete')" 
                        class="btn btn-red btn-xs btn-labeled fa fa-trash" data-toggle="tooltip" data-original-title="Delete" data-container="body">
                            <?php echo translate('delete')?>
                    </a>
                </td>
            </tr><?php
            } }?>
            
        </tbody>
    </table>
</div>

    <div id="vendr"></div>
    <script type="text/javascript">
      $(document).ready(function(){
          $('#operators-table').bootstrapTable({
              
          })
      });
        
    </script>

<style>
	.btn-red
	{
		background-color: #e22626;
    	border-color: #e22626;
	}
	.btn-red:hover
	{
		color:#fff;
	}
</style>