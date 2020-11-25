<div class="panel-body" id="demo_s">		
<table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" >
	<thead>
			<tr>
                <th data-field="image" data-align="left" data-sortable="true" >
                    <?php echo translate('image');?>
                </th>
                <th data-field="title" data-align="center" data-sortable="true">
                    <?php echo translate('title');?>
                </th>
<!--                <th data-field="stock_qty." data-sortable="true">
                    <?php echo translate('stock_qty.');?>
                </th>-->
                <th data-field="base_price" data-sortable="true">
                    <?php echo translate('base_price');?>
                </th>
                <th data-field="price" data-sortable="true">
                    <?php echo translate('price');?>
                </th>
<!--                <th data-field="publish" data-sortable="false">
                    <?php // echo translate('publish');?>
                </th>-->
                <th data-field="admin_status" data-sortable="false">
                    <?php echo translate('status');?>
                </th>
                <th data-field="options" data-sortable="false" class="text-right">
                    <?php echo translate('options');?>
                </th>
            </tr>
			</thead>

			<tbody>
			<?php //echo '<pre>'; print_r($all_product); echo '</pre>';
            	foreach($all_product as $row)
				{
//            		if($this->crud_model->is_added_by('product',$row['product_id'],$this->session->userdata('vendor_id')))
//					{
				?>
			<tr>
				<td>

				<img class="img-sm" style="height:auto !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;"  src="<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one'); ?>"

				>
                                            

				</td>

				<td><?php echo $row['title'] ; ?></td>

<!--				<td>

				<?php  
//                                if($row['current_stock'] > 0){ 
//                   echo $row['current_stock'].$row['unit'].'(s)';                     
//                } 
//                else if($row['download'] == 'ok')
//                {
//                    echo '<span class="label label-info">'.translate('digital_product').'</span>';
//                } 
//                else {
//                   echo '<span class="label label-danger">'.translate('out_of_stock').'</span>';
//                } 

                ?>
                	

                </td>-->
                <td><?php echo currency().$row['sale_price']?></td>
                <td><?php echo $vendor->currency. ' ' . $row['price']?></td>

				
<!--                <td class="text-center"><?php 

//                if($row['vendor_approved'] == '1')
//                {
//                    echo '<input id="pub_'.$row['product_id'].'" class="sw1" type="checkbox" data-id="'.$row['product_id'].'" checked />';
//                } 
//                else 
//                {
//                    echo '<input id="pub_'.$row['product_id'].'" class="sw1" type="checkbox" data-id="'.$row['product_id'].'" />';
//                }
                ?>
                    
                </td>-->

                <td><?php 

                if($row['status'] == 'ok')
                { ?>
                    <span class='label label-purple'>
                        Approved</span>
                <?php } 
                else 
                {
                   echo "<span class='label label-danger'>Pending</span>";
                } ?>
                    
                </td>

				<td class="text-right">

				<?php $prdId = $row['product_id'];
                                $where = ['vendor_id'=>$row['vendor_id'],'prd_id'=>$row['product_id'],'status'=>0];
                                if($this->db->get_where('product_price_request',$where)->num_rows() > 0){ $disabled = 'disabled=""'; $title = 'Request Pending'; }else{ $disabled = $title = ''; }
				echo "<a id=\"edit_$prdId\" class=\"btn btn-purple btn-xs btn-labeled fa fa-tag\" data-toggle=\"tooltip\"
                                onclick=\"ajax_modal('changePrice','".translate('price_change_request')."','".translate('request_submitted_successfully!')."','price_change_request','".$row['product_id']."');\" data-original-title=\"$title\" data-container=\"body\" $disabled >
                                    ".translate('change_price')."
                            </a>
                            <a class=\"btn btn-info btn-xs btn-labeled fa fa-location-arrow\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_set_full('view','".translate('view_product')."','".translate('successfully_viewed!')."','product_view','".$row['product_id']."');proceed('to_list');\" data-original-title=\"View\" data-container=\"body\">
                                    ".translate('view')."
                            </a>
                          <!--   <a class=\"btn btn-purple btn-xs btn-labeled fa fa-tag\" data-toggle=\"tooltip\"
                                onclick=\"ajax_modal('add_discount','".translate('view_discount')."','".translate('viewing_discount!')."','add_discount','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('discount')."
                            </a> -->
                         <!--    <a class=\"btn btn-mint btn-xs btn-labeled fa fa-plus-square\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_modal('add_stock','".translate('add_product_quantity')."','".translate('quantity_added!')."','stock_add','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('stock')."
                            </a>
                            <a class=\"btn btn-dark btn-xs btn-labeled fa fa-minus-square\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_modal('destroy_stock','".translate('reduce_product_quantity')."','".translate('quantity_reduced!')."','destroy_stock','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('destroy')."
                            </a>
                            
                            <a class=\"btn btn-success btn-xs btn-labeled fa fa-wrench\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_set_full('edit','".translate('edit_product')."','".translate('successfully_edited!')."','product_edit','".$row['product_id']."');proceed('to_list');\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('edit')."
                            </a>
                            
                            <a onclick=\"delete_confirm('".$row['product_id']."','".translate('really_want_to_delete_this?')."')\" 
                                class=\"btn btn-danger btn-xs btn-labeled fa fa-trash\" data-toggle=\"tooltip\" data-original-title=\"Delete\" data-container=\"body\">
                                    ".translate('delete')."
                            </a> -->
                            "; 

				?>
					

				</td>
				
			</tr>
            <?php
            	//	}
            	}
			?>
			</tbody>
		</table>
	</div>    
    <div id='export-div' style="padding:40px;">
		<h1 id ='export-title' style="display:none;"><?php echo translate('product_list'); ?></h1>
		<table id="export-table" class="table" data-name='product_list' data-orientation='p' data-width='1500' style="display:none;">
				<colgroup>
					<col width="50">
					<col width="150">
					<col width="150">
					<col width="150">
					<col width="150">
				</colgroup>
				<thead>
					<tr>
						<th><?php echo translate('No');?></th>
                        <th><?php echo translate('product_title');?></th>
                        <th><?php echo translate('current_stock');?></th>
                        
					</tr>
				</thead>



				<tbody >
				<?php
					$i = 0;
	            	foreach($all_product as $row){
            		if($this->crud_model->is_added_by('product',$row['product_id'],$this->session->userdata('vendor_id'))){
	            		$i++;
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $row['category'].' - '.$row['title'] ; ?></td>
					<td><?php  if($row['current_stock'] > 0)
				{ 
                   echo $row['current_stock'].$row['unit'].'(s)';                     
                } 
                else if($row['download'] == 'ok')
                {
                    echo '<span class="label label-info">'.translate('digital_product').'</span>';
                } 
                else {
                   echo '<span class="label label-danger">'.translate('out_of_stock').'</span>';
                } 

                ?></td>
                	
				</tr>
	            <?php
	            		}
	            	}
				?>
				</tbody>
		</table>
	</div>