<?php 
    foreach($message_data as $row)
    { 
?>
    <h4 class="modal-title text-center padd-all">
    	<?php echo translate('message_from');?> <?php echo $row['name'];?>

        <a href=""><span class="btn btn-info btn-labeled fa fa-step-backward pull-right">
                    <?php echo translate('back');?> </span>
            </a>
    </h4>
    <hr style="margin-top: 10px !important;">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center pad-all">
                <div class="col-md-12"> 
                    <table class="table table-striped" style="border-radius:3px;">
                        <tr>
                            <th class="custom_td"><?php echo translate('name');?></th>
                            <td class="custom_td"><?php echo $row['name']?></td>
                        </tr>

                        <tr>
                            <th class="custom_td"><?php echo translate('subject');?></th>
                            <td class="custom_td">
                                <?php echo $row['subject']?>
                            </td>
                        </tr>

                        <tr>
                            <th class="custom_td"><?php echo translate('Product');?></th>
                            <td class="custom_td">
                                <?php echo $this->crud_model->get_type_name_by_id('product',$row['product_id'],'title'); ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="custom_td"><?php echo translate('message');?></th>
                            <td class="custom_td">
                                <?php echo $row['message']?>
                            </td>
                        </tr>
                        <tr>
                            <th class="custom_td"><?php echo translate('date_&_time');?></th>
                            <td class="custom_td">
                                <?php echo date('d M,Y h:i:s',$row['timestamp']); ?>
                            </td>
                        </tr>
                        <?php if($row['reply'] != ''){ ?>
                        <tr>
                            <th class="custom_td"><?php echo translate('reply');?></th>
                            <td class="custom_td">
                                <?php echo $row['reply']; ?>
                            </td>
                        </tr>
                        <?php } else { ?>
                        <tr>
                            <th class="custom_td"></th>
                            <td class="custom_td">
                               
                                <!--
                                   reply  code commented - requirement
                                   
                                   <a class="btn btn-success btn-xs btn-labeled fa fa-reply" data-toggle="tooltip"
                                    onclick="ajax_set_full('reply_form','<?php //echo translate('reply_contact_message'); ?>','<?php //echo translate('successfully_replied!'); ?>','contact_message_reply','<?php //echo $row['contact_message_id']; ?>');"
                                        data-original-title="Edit" data-container="body">
                                            <?php //echo translate('reply');?>
                                </a>-->
                                
                                
                                <a class="btn btn-success btn-xs btn-labeled fa fa-reply" data-toggle="tooltip" href="<?php echo base_url(); ?>index.php/admin/quote_message"  data-original-title="Edit" data-container="body">
                                            <?php //echo translate('reply');?>
                                </a>
                                
                                
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
                <hr>
            </div>
        </div>
    </div>    
<?php 
	}
?>        
<style>
	.custom_td{
		border-left: 1px solid #ddd;
		border-right: 1px solid #ddd;
		border-bottom: 1px solid #ddd;
	}
</style>

<script>
    $(document).ready(function(e) {
        proceed('to_list');
    });
</script>