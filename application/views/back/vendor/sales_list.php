<div class="panel-body" id="demo_s">
    <table id="sales-table" class="table table-striped"  data-pagination="true" data-show-refresh="true"  data-show-toggle="true" data-show-columns="true" data-search="true" data-state-save="true" data-state-save-id-table="whateverIdYouLike">

        <thead>
            <tr>
                <th style="width:4ex"><?php echo translate('ID');?></th>
                <th><?php echo translate('sale_code');?></th>
                <th><?php echo translate('buyer');?></th>
                <th><?php echo translate('date');?></th>
                <th><?php echo translate('total');?></th>
                <th><?php echo translate('delivery_status');?></th>
                <th><?php echo translate('payment_status');?></th>
                <th class="text-right"><?php echo translate('options');?></th>
            </tr>
        </thead>
            
        <tbody>
        <?php
            $i = 0;
            
            foreach($all_sales as $row)
            {
                //print_r($row);
                // if($this->crud_model->is_sale_of_vendor($row['sale_id'],$this->session->userdata('vendor_id'))){
                $i++;
                ?>
                <tr class="<?php if($row['viewed'] !== 'ok'){ echo 'pending'; } ?>" >
                    <td><?php echo $i; ?></td>
                    <td>#<?php echo $row['sale_code']; ?></td>
                    <td><?php echo $this->crud_model->get_type_name_by_id('user',$row['buyer'],'username'); ?></td>
                    <td><?php echo date('d-m-Y',strtotime($row['sale_datetime'])); ?></td>
                    <td class="text-left"><?php echo $this->session->userdata('vendor')->currency.$this->cart->format_number($row['grand_total']); ?></td>
                    <td>
                        <a class="label label-<?php if($row['delivery_status'] == 'delivered'){ ?>purple<?php }else if($row['delivery_status'] == 'on_delivery'){ ?>info<?php } else { ?>danger<?php } ?>"
                            onclick="ajax_modal('delivery_payment','<?php echo translate('delivery_status_update'); ?>','<?php echo translate('successfully_edited!'); ?>','delivery_payment','<?php echo $row['sale_id'].'/d'; ?>')">
                            <?php echo translate($row['delivery_status']);?>
                         </a>
                    </td>
                    <td>
                        <?php 
                            $payment_status = json_decode($row['payment_status'],true); 
                            foreach ($payment_status as $dev) 
        					{
        						if(isset($dev['vendor']))
        						{
                                	if($dev['vendor'] == $this->session->userdata('vendor_id'))
        							{
                        			 ?>
        								<a class="label label-<?php if($dev['status'] == 'paid'){ ?>purple<?php }else if($dev['status'] == 'processing'){ ?>info<?php } else { ?>danger<?php } ?>"
                                                                           onclick="ajax_modal('delivery_payment','<?php echo translate('payment_status_update'); ?>','<?php echo translate('successfully_edited!'); ?>','delivery_payment','<?php echo $row['sale_id'].'/p'; ?>')">
        									<?php
        										if($dev['status']=='due'){$dev['status']='pending';}
        										echo  translate($dev['status']); 
        									?>
        								</a>
                       				  <?php
                                 	}
                               }
                            }
                        ?>
                    </td>
                    <td class="text-right">
                        <!--
        				<a class="btn btn-purple btn-xs  " data-toggle="tooltip" 
                            onclick="ajax_modal('sale_shipping','<?php echo translate('shipping_receipt'); ?>','<?php echo translate('successfully_added!'); ?>','sale_shipping','<?php echo $row['sale_id']; ?>')" 
                                data-original-title="Edit" data-container="body">
                                    <?php echo translate('shipping_receipt'); ?>
                        </a>
        				<a class="btn btn-mint btn-xs " data-toggle="tooltip" 
                            onclick="ajax_modal('sale_receipt','<?php echo translate('payment_receipt'); ?>','<?php echo translate('successfully_added!'); ?>','sale_receipt','<?php echo $row['sale_id']; ?>')"  data-original-title="Receipt" data-container="body"> <?php echo translate('payment_receipt'); ?>
                        </a>
        				-->
                        <a class="btn btn-info btn-xs " data-toggle="tooltip" 
                            onclick="ajax_set_full('view','<?php echo translate('title'); ?>','','sales_view','<?php echo $row['sale_id']; ?>')" data-original-title="Edit" data-container="body"><?php echo translate('full_invoice'); ?>
                        </a>
                        
                        <!--<a class="btn btn-success btn-xs  " data-toggle="tooltip" -->
                        <!--    onclick="ajax_modal('delivery_payment','<?php echo translate('delivery_&_payment_status'); ?>','<?php echo translate('successfully_edited!'); ?>','delivery_payment','<?php echo $row['sale_id']; ?>')" -->
                        <!--        data-original-title="Edit" data-container="body">-->
                        <!--            <?php echo translate('status_edit'); ?>-->
                        <!--</a>-->
                    </td>
                </tr>
                <?php
                // }
            }
        ?>
        </tbody>
    </table>
</div>  



    <div id='export-div' style="">
        <h1 id ='export-title' style="display:none;"><?php echo translate('sales'); ?></h1>
        <table id="export-table" class="table" data-name='sales' data-orientation='l' data-width='1500' style="display:none;">
                <colgroup>
                    <col width="50">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="250">
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
                        if($this->crud_model->is_sale_of_vendor($row['sale_id'],$this->session->userdata('vendor_id'))){
                        $i++;
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>#<?php echo $row['sale_code']; ?></td>
                    <td><?php echo $this->crud_model->get_type_name_by_id('user',$row['buyer'],'username'); ?></td>
                    <td><?php echo date('d-m-Y',Strtotime($row['sale_datetime'])); ?></td>
                    <td><?php echo currency().$this->cart->format_number($row['grand_total']); ?></td>               
                </tr>
                <?php
                        }
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

<script>
	$(document).ready(function() 
	{
		$('#sales-table').bootstrapTable({
    	});
	});
</script>

           