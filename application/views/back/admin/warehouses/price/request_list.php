
<div class="panel-body" id="demo_s">
    <table id="operators-table" class="table table-striped"  data-url="<?php echo base_url('admins/shipping/operators/list')?>"  data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-search="true" data-show-export="true" >
        <thead>
            <tr>
                <th><?php echo translate('Sr. No');?></th>
                <th><?php echo translate('warehouse');?></th>
                <th><?php echo translate('product');?></th>
                <th><?php echo translate('base_price');?></th>
                <th><?php  echo translate('current_price');?></th>
                <th><?php  echo translate('requested_price');?></th>
                <th><?php echo translate('requested_on');?></th>
                <th><?php echo translate('action');?></th>
            </tr>
        </thead>                
        <tbody><?php $n = 0;
            if($products){ foreach($products as $row){ $n++; ?>
            <tr id="row_<?php echo $n?>">
                <td><?php echo $n?></td>
                <td><?php echo $row->name?></td>
                <td><?php echo $row->title?><br /><span class="prd-codw"><?php echo $row->product_code?></span></td>
                <td><?php echo $row->base_price?></td>
                <td><?php echo $row->current_price?></td>
                <td><?php echo $row->req_price?></td>
                <td><?php echo date('d M Y',strtotime($row->created))?></td>
                <td><?php 
                    if($row->status == 0){ ?>
                        <button id="ap_<?php echo $row->id?>" class="btn btn-success btn-xs btn-labeled fa fa-check apBtn " data-toggle="tooltip" 
                                 data-original-title="Approve" data-container="body">
                                   <i class="fa fa-check" aria-hidden="true"></i> <?php echo translate('approve')?>
                        </button>
                        <button id="dn_<?php echo $row->id?>" class="btn btn-danger btn-xs btn-labeled fa fa-check dnBtn " data-toggle="tooltip" 
                                 data-original-title="Approve" data-container="body">
                                    <?php echo translate('reject')?>
                        </button><?php
                        }else if($row->status == 1){ ?> <span class="approved"><?php echo translate('approved')?></span><?php
                        }else{ ?><span class="rejected"><?php echo translate('rejected')?></span><?php } ?>
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