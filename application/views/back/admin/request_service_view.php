<?php 
	foreach($servicerequest_data as $row)
	{ 
?>
    <div id="content-container" style="padding-top:0px !important;">
  
    
    
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-body">
       
                <table class="table table-striped" style="border-radius:3px;">
                    <tr>
                        <th class="custom_td"><?php echo translate('name');?></th>
                        <td class="custom_td"><?php  echo $row['name'];?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('email');?></th>
                        <td class="custom_td"><?php echo $row['email'];?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('mobile');?></th>
                        <td class="custom_td"><?php echo $row['mobile'];?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('city');?></th>
                        <td class="custom_td"><?php echo $row['city'];?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('country');?></th>
                        <td class="custom_td">
                            <?php echo $this->crud_model->get_type_name_by_ids('countries',$row['country'],'name'); ?>
                            </td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('date');?></th>
                        <td class="custom_td"><?php echo date('d F Y', strtotime($row['date'])); ?></td>
                    </tr>
                     <tr>
                        <th class="custom_td"><?php echo translate('time');?></th>
                        <td class="custom_td"><?php echo date('g:i A', strtotime($row['time'])); ?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('service_category');?></th>
                        <td class="custom_td"><?php echo $this->crud_model->get_type_name_by_id('service_category',$row['service_category'],'name'); ?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('service_type');?></th>
                        <td class="custom_td"><?php echo $this->crud_model->get_type_name_by_id('service_type',$row['service_type'],'type'); ?></td>
                    </tr>
                    <?php
                    if($row['service_type'] == 3)
                    {
                     ?>
                     <tr>
                        <th class="custom_td"><?php echo translate('type_detail');?></th>
                        <td class="custom_td"><?php echo $row['type_detail'];?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('Remarks');?></th>
                        <td class="custom_td"><?php echo $row['remark'];?></td>
                    </tr>
                </table>
              </div>
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
