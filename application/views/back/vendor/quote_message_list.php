    <div class="panel-body" id="demo_s">
        <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-ignorecol="0,2" data-show-toggle="true" data-show-columns="false" data-search="true" >

            <thead>
                <tr>
                    <th><?php echo translate('no');?></th>
                    <th><?php echo translate('product');?></th>
                    <th><?php echo translate('From');?></th> 
                    <th><?php echo translate('date');?></th>                   
                    <th><?php echo translate('mobile_number');?></th>
                    <th class="text-right"><?php echo translate('options');?></th>
                </tr>
            </thead>
                
            <tbody >
            <?php
                $i = 0;
                foreach($quote_messages as $row){
                 if($this->crud_model->is_added_by('product',$row['product_id'],$this->session->userdata('vendor_id')))
                 {
                    $i++;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $this->crud_model->get_type_name_by_id('product',$row['product_id'],'title'); ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo date('d M,Y h:i:s',$row['timestamp']); ?></td>
                <td><?php echo $row['mobile']; ?></td>
                <td class="text-right">
                    <a class="btn btn-info btn-xs btn-labeled fa fa-location-arrow" data-toggle="tooltip" 
                        onclick="ajax_set_full('view','<?php echo translate('view_quote_message'); ?>','<?php echo translate('successfully_viewed!'); ?>','quote_message_view','<?php echo $row['quote_message_id']; ?>');"
                            data-original-title="Edit" data-container="body">
                                <?php echo translate('view_message');?>
                    </a>
                    
                </td>
            </tr>
            <?php
                }
                }
            ?>
            </tbody>
        </table>
    </div>
           
    <div id='export-div'>
        <h1 style="display:none;"><?php echo translate('quote_messages'); ?></h1>
        <table id="export-table" class="table" data-name='quote_messages' data-orientation='p' data-width='1500' style="display:none;">
                 <colgroup>
                    <col width="50">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                </colgroup>
                <thead>
                    <tr>
                        <th><?php echo translate('no');?></th>
                        <th><?php echo translate('product');?></th>
                        <th><?php echo translate('From');?></th>
                        <th><?php echo translate('subject');?></th>
                        <th><?php echo translate('message');?></th>
                        <th><?php echo translate('date');?></th>
                        <!--<th><?php //echo translate('reply');?></th>-->
                    </tr>
                </thead>
                    
                <tbody >
                <?php
                    $i = 0;
                    foreach($quote_messages as $row){
                    if($this->crud_model->is_added_by('product',$row['product_id'],$this->session->userdata('vendor_id')))
                        {
                        $i++;
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $this->crud_model->get_type_name_by_id('product',$row['product_id'],'title'); ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['subject']; ?></td>
                    <td><?php echo $row['message']; ?></td>
                    <td><?php echo date('d M,Y ',$row['timestamp']); ?></td>
                   <!-- <td><?php //echo $row['reply']; ?></td>-->
                </tr>
                <?php
                    }
                    }
                ?>
                </tbody>
        </table>
    </div>

