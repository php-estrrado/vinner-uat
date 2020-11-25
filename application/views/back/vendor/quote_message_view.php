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
                            <th class="custom_td"><?php echo translate('From');?></th>
                            <td class="custom_td"><?php echo ucfirst($row['name']);?> (<?php echo $row['email']?>)</td>
                        </tr>

                        <tr>
                            <th class="custom_td"><?php echo translate('Product');?></th>
                            <td class="custom_td">
                                <?php echo $this->crud_model->get_type_name_by_id('product',$row['product_id'],'title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="custom_td"><?php echo translate('subject');?></th>
                            <td class="custom_td">
                                <?php echo $row['subject']?>
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