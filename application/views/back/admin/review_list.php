<div class="panel-body" id="list">
    <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" >
        <thead>
            <tr>
               <th><?php echo translate('no');?></th>
               <th><?php echo translate('product');?></th> 
               <th><?php echo translate('review_title');?></th> 
               <th><?php echo translate('Review_date');?></th>
               <th><?php echo translate('status');?></th>
                <th class="text-right"><?php echo translate('options');?></th>
            </tr>
        </thead>				
        <tbody >
        <?php
            $i = 0;
            foreach($all_reviews as $row){
                $i++;
        ?>                
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $this->crud_model->get_type_name_by_id('product',$row['product_id'],'title'); ?></td>
            <td><?php echo $row['review_title']; ?></td>
            <td><?php echo date('d M,y',strtotime($row['review_date'])); ?></td>
            <?php if($row['status']==1) 
            {
                $stat="Approved";
            }
            else if ($row['status']==0) 
            {
                $stat="Rejected";
            }
            else 
            {
                $stat="Pending";
            }
            ?>
            <td>
            	<div class="label label-<?php 
                if($row['status'] == '1')
                { 
                ?>purple
                <?php
                } 
                else if($row['status'] == '0')
                { 
                ?>danger
                <?php 
                } 
                else 
                { 
                ?>pending
                <?php 
                } 
                ?>">
                	<?php echo $stat; ?>
                </div>
            </td>
         
            <td class="text-right">
                <a class="btn btn-dark btn-xs btn-labeled fa fa-user" data-toggle="tooltip" 
                    onclick="ajax_modal('view','<?php echo translate('view_review'); ?>','<?php echo translate('successfully_viewed!'); ?>','review_view','<?php echo $row['review_id']; ?>')" data-original-title="View" data-container="body">
                        <?php echo translate('view_review');?>
                </a>
             
                <a class="btn btn-success btn-xs btn-labeled fa fa-check" data-toggle="tooltip" 
                    onclick="ajax_modal('approval','<?php echo translate('Review_approval'); ?>','<?php echo translate('successfully_viewed!'); ?>','vendor_approval','<?php echo $row['review_id']; ?>')" data-original-title="View" data-container="body">
                        <?php echo translate('approval');?>
                </a>
               
                <a onclick="delete_confirm('<?php echo $row['review_id']; ?>','<?php echo translate('really_want_to_delete_this?'); ?>')" class="btn btn-xs btn-danger btn-labeled fa fa-trash" data-toggle="tooltip" 
                    data-original-title="Delete" data-container="body">
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
    <div id="vendr"></div>
    <div id='export-div' style="padding:40px;">
        <h1 id ='export-title' style="display:none;"><?php echo translate('Review List'); ?></h1>
        <table id="export-table" class="table" data-name='Review List' data-orientation='p' data-width='1500' style="display:none;">
                <colgroup>
                    <col width="50">
                    <col width="175">

                    <col width="150">
                    <col width="150">
                    <col width="150">
                </colgroup>
                <thead>
                    <tr>
                        <th><?php echo translate('no');?></th>
                        <th><?php echo translate('Product name');?></th>
                        <th><?php echo translate('Review');?></th>
                        <th><?php echo translate('Review_date');?></th>
                    </tr>
                </thead>



                <tbody >
                <?php
                $i = 0;
                    foreach($all_reviews as $row){
                $i++;
        ?>                
        <tr>
           <td><?php echo $i ?></td>
           <td><?php
             echo $this->crud_model->get_type_name_by_id('product', $row['product_id'], 'title'); ?></td>
            <td><?php echo $row['review_title']; ?></td>
            <td><?php echo $row['review_date']; ?></td>
            <?php if($row['status']==1) $stat="Enabled";else $stat="Disabled" ?>
           
            </tr>
            <?php
            }
            ?>
                </tbody>
        </table>
    </div>
    
    <style>
    .label-pending {
    background-color: #8754b0;
   }
</style>
           