
<div class="panel-body" id="demo_s">
    <table id="certificate-table" class="table table-striped"  data-url="<?php echo base_url('admins/shipping/operators/list')?>"  data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-search="true" data-show-export="true" >
        <thead>
            <tr>
                <th><?php echo translate('ID');?></th>
                <th><?php echo translate('certificate');?></th>
                <th><?php echo translate('title');?></th>
                <th><?php echo translate('path');?></th>
                <th><?php echo translate('status');?></th>
                <th class="text-right"><?php echo translate('action');?></th>
            </tr>
        </thead>                
        <tbody><?php
            if($certificates){ foreach($certificates as $row){ 
                $file           =   explode('.',$row->file); foreach($file as $f){ $ext = $f; }
                if($ext         ==  'doc' || $ext == 'docx'){ $icon = base_url('template/img/word.png'); }
                else if($ext    ==  'ppt' || $ext == 'pptx'){ $icon = base_url('template/img/ppt.png'); }
                else if($ext    ==  'pdf'){ $icon = base_url('template/img/pdf.png'); }
                else{ $icon     =   base_url('uploads/certificates/'.$row->file); }
                $iconUrl        =   base_url('uploads/certificates/'.$row->file);
                if($row->status == 1){
                    $status = '<input id="status_'.$row->id.'" class="sw2" type="checkbox" data-id="'.$row->id.'" checked />';
                }else{
                    $status = '<input id="status_'.$row->id.'" class="sw2" type="checkbox" data-id="'.$row->id.'" />';
                }?>
                <tr id="row_<?php echo $row->id?>">
                    <td><?php echo $row->id?></td>
                    <td><a href="<?php echo $iconUrl?>" target="_blank"><img src="<?php echo $icon?>" alt="Icon" style="height: 70px; max-width: 150px" /></a></td>
                    <td><?php echo $row->title?></td>
                    <td><?php echo $iconUrl?></td>
                    <td><?php
                        if($row->status == 1){ echo '<div class="label label-purple">'.translate('active').'</div>'; }
                        else{ echo '<div class="label label-danger">'.translate('inactive').'</div>'; } ?>
                    </td>
                    <td>
                        <a id="<?php echo $row->id?>" class="btn btn-red btn-xs btn-labeled fa fa-trash delBtn">
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
          $('#certificate-table').bootstrapTable({
              
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