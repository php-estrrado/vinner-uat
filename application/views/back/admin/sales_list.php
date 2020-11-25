<div class="panel-body" id="demo_s">
    <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true"  data-show-toggle="true" data-show-columns="true" data-search="true" >

        <thead>
            <tr>
                <th style="width:4ex"><?php echo translate('ID');?></th>
                <th><?php echo translate('order_id');?></th>
                <th><?php echo translate('customer');?></th>
                <th><?php echo translate('delivery_status');?></th>
                <th><?php echo translate('payment_status');?></th>
                 <th><?php echo translate('total');?></th>
                <th><?php echo translate('date_added');?></th>
                <th class="text-center"><?php echo translate('Action');?></th>
            </tr>
        </thead>
            
        <tbody>
        <?php
            $i = 0;
            foreach($all_sales as $row){
                $i++; 
               $vendor         =   $this->db->join('countries as C','V.country_code = C.id')->get_where('vendor as V',['V.vendor_id'=>$row['vendor_id']])->row(); 
        ?>
        <tr class="<?php if($row['viewed'] !== 'ok'){ echo 'pending'; } ?>" >
            <td><?php echo $i; ?></td>
            <td>#<?php echo $row['sale_code']; ?></td>
            <td><?php echo $this->crud_model->get_type_name_by_id('user',$row['buyer'],'username'); ?></td>
            <td>
				 <a class="label label-<?php if($row['delivery_status'] == 'delivered'){ ?>purple<?php }else if($row['delivery_status'] == 'on_delivery'){ ?>info<?php } else { ?>danger<?php } ?>" data-toggle="tooltip" 
                    onclick="ajax_modal('delivery_payment','<?php echo translate('delivery_status_update'); ?>','<?php echo translate('successfully_edited!'); ?>','delivery_payment','<?php echo $row['sale_id'].'/d'; ?>')" 
                        data-original-title="Edit" data-container="body">
                            <?php echo translate($row['delivery_status']); ?>
                </a> 
            </td>
             <td>

                <?php 
                    $payment_status = json_decode($row['payment_status'],true); 
                    foreach ($payment_status as $dev) 
					{
                		?>
						<a class="label label-<?php if($dev['status'] == 'paid'){ ?>purple<?php }else if($dev['status'] == 'processing'){ ?>info<?php } else { ?>danger<?php } ?>"
                                                   onclick="ajax_modal('delivery_payment','<?php echo translate('payment_status_update'); ?>','<?php echo translate('successfully_edited!'); ?>','delivery_payment','<?php echo $row['sale_id'].'/p'; ?>')">
						<?php
								if($dev['status']=='due'){$dev['status']='pending';}
								if(isset($dev['vendor']))
								{
									echo translate($dev['status']);
								} 
								else if(isset($dev['admin'])) 
								{
									echo translate($dev['status']);
								}
						?>
						</a>
                		<?php
                    }
                ?>
            </td>
            <td class=""><?php echo $vendor->currency.' '.$this->cart->format_number($row['grand_total']); ?></td>
            <td><?php echo date('d-m-Y',strtotime($row['sale_datetime'])); ?></td>
            <td class="text-right">
               <a class="btn btn-info btn-xs btn-labeled fa" data-toggle="tooltip" 
                    onclick="ajax_set_full('order_home','<?php echo translate('title'); ?>','<?php echo translate('successfully_edited!'); ?>','sales_view','<?php echo $row['sale_id']; ?>')" 
                        data-original-title="Edit" data-container="body"><?php echo translate('view'); ?>
                </a>

                <a class="btn btn-purple btn-xs btn-labeled fa " data-toggle="tooltip" 
                    onclick="ajax_set_full('view','<?php echo translate('title'); ?>','<?php echo translate('successfully_edited!'); ?>','sales_view','<?php echo $row['sale_id']; ?>')" 
                        data-original-title="Edit" data-container="body"><?php echo translate('full_invoice'); ?>
                </a>
                <?php /*
                <a class="btn btn-success btn-xs btn-labeled fa fa-usd" data-toggle="tooltip" 
                    onclick="ajax_modal('delivery_payment','<?php echo translate('delivery_payment'); ?>','<?php echo translate('successfully_edited!'); ?>','delivery_payment','<?php echo $row['sale_id']; ?>')" 
                        data-original-title="Edit" data-container="body">
                            <?php echo translate('status'); ?>
                </a>*/ ?>
                
                <a onclick="delete_confirm('<?php echo $row['sale_id']; ?>','<?php echo translate('really_want_to_delete_this?'); ?>')" 
                    class="btn btn-danger btn-xs btn-labeled fa fa-trash" data-toggle="tooltip" 
                        data-original-title="Delete" data-container="body"><?php echo translate('delete'); ?>
                </a>
            </td>
        </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</div>  
    <div id='export-div' style="">
		<h1 id ='export-title' style="display:none;"><?php echo translate('sales'); ?></h1>
		<table id="export-table" class="table" data-name='sales' data-orientation='p' data-width='1500' style="display:none;">
				<colgroup>
					<col width="50">
					<col width="150">
					<col width="150">
					<col width="150">
					<col width="150">
				</colgroup>
				<thead>
					<tr>
                        <th>#</th>
                        <th>Sale Code</th>
                        <th>Buyer</th>
                        <th>Date</th>
                        <th>Total</th>
					</tr>
				</thead>

				<tbody >
				<?php
					$i = 0;
	            	foreach($all_sales as $row){
	            		$i++;
				?>
				<tr>
					<td><?php echo $i; ?></td>
                    <td>#<?php echo $row['sale_code']; ?></td>
                    <td><?php echo $this->crud_model->get_type_name_by_id('user',$row['buyer'],'username'); ?></td>
                    <td><?php echo date('d-m-Y',$row['sale_datetime']); ?></td>
                    <td><?php echo currency().$this->cart->format_number($row['grand_total']); ?></td>              	
				</tr>
	            <?php
	            	}
				?>
				</tbody>
		</table>
	</div>
    
<style type="text/css">
	.pending{
		background: #D2F3FF  !important;
	}
	.pending:hover{
		background: #9BD8F7 !important;
	}
</style>



           