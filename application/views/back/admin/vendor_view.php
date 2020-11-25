<?php 
    foreach($vendor_data as $row)
    { 
        ?>

        <div id="content-container" style="padding-top:0px !important;">

            <div class="text-center pad-all">
                <div class="pad-ver">
                    <img <?php if(file_exists('uploads/vendor/logo_'.$row['vendor_id'].'.png')){ ?>  src="<?php echo base_url(); ?>uploads/vendor/logo_<?php echo $row['vendor_id']; ?>.png" <?php } 
                        else { ?>  src="<?php echo base_url('uploads/vendor/logo_0.png'); ?>" <?php } ?>
                    class="img-md img-border img-circle" alt="Profile Picture" />
                </div>
                <div class="pad-ver btn-group" style="margin-top: 10px;">
                     <h4 class="text-lg text-overflow mar-no"><?php echo ucfirst($row['name']);?></h4>
                     <p class="text-sm"><?php echo translate('warehouse');?></p>
                </div>
            </div>

            <div class="row">

                <div class="col-sm-12">
                    <div class="panel-body">
                        <table class="table table-striped" style="border-radius:3px;">
                            <tr>
                                <th class="custom_td"><?php echo translate('display_name');?></th>
                                <td class="custom_td"><?php echo $row['display_name'];?></td>
                            </tr>
							
							<!--<tr>-->
       <!--                         <th class="custom_td"><?php// echo translate('drs_Id');?></th>-->
       <!--                         <td class="custom_td"><?php// echo $row['drs_id'];?></td>-->
       <!--                     </tr>-->
							
                            <tr>
                                <th class="custom_td"><?php echo translate('name');?></th>
                                <td class="custom_td"><?php echo $row['name'];?></td>
                            </tr>

                            <!--<tr>-->
                            <!--    <th class="custom_td"><?php// echo translate('company');?></th>-->
                            <!--    <td class="custom_td"><?php// echo $row['company'];?></td>-->
                            <!--</tr>-->
                            <tr>

                            <th class="custom_td"><?php echo translate('country');?></th>
                                <td class="custom_td">
                                    <?php echo $this->crud_model->get_type_name_by_ids('countries',$row['country_code'],'name');?>
                                </td>
                            </tr>
                            <tr>
                                <th class="custom_td"><?php echo translate('email');?></th>
                                <td class="custom_td"><?php echo $row['email'];?></td>
                            </tr>

							<tr>
                                <th class="custom_td"><?php echo translate('Mobile');?></th>
                                <td class="custom_td"><?php echo $row['mobile']?></td>
                            </tr>
							
                            <tr>
                                <th class="custom_td"><?php echo translate('address');?></th>
                                <td class="custom_td">
                                    <?php echo $row['address1']?><br>
                                    <?php echo $row['address2']?>
                                </td>
                            </tr>
							
                            <!--<tr>-->
                            <!--    <th class="custom_td"><?php // echo translate('creation_date');?></th>-->
                            <!--    <td class="custom_td">-->
                            <!--        <?php // echo date('d M,Y',$row['create_timestamp']);?>-->
                            <!--    </td>-->
                            <!--</tr>-->

                            <?php 
                                // if($row['membership'] != 0)
                                // { ?>

                                     <!--<tr>-->
                                     <!--    <th class="custom_td"><?php// echo translate('membership');?></th>-->
                                     <!--    <td class="custom_td"><?php //echo $this->crud_model->get_type_name_by_id('membership', $row['membership'], 'title')?></td>-->
                                     <!--</tr>-->
                                     <?php 
                                // } 
                            ?>
							<!--<tr>-->
       <!--                         <th class="custom_td"><?php echo translate('bank_details');?></th>-->
       <!--                         <td class="custom_td">-->
       <!--                             <address style="margin-bottom: auto;">-->
							<!--			<?php //echo translate('account_no : ').$row['account_number'];?><br/>-->
										<?php //echo translate('acunt_no : ').$row['account_number'];?>
							<!--			<?php// echo translate('bank_name: ').$row['bank_name'];?><br/>-->
							<!--			<?php// echo translate('branch   : ').$row['bank_branch'];?><br/>-->
							<!--			<?php// echo translate('swift_code: ').$row['swift_code'];?><br/>-->
							<!--		</address>-->
       <!--                         </td>-->
       <!--                     </tr>-->
							
							<!--<tr>-->
       <!--                         <th class="custom_td"><?php // echo translate('shipping_method');?></th>-->
       <!--                         <td class="custom_td">-->
       <!--                             <?php // echo $row['ship_method'];?>-->
       <!--                         </td>-->
       <!--                     </tr>-->
							
							<!--<tr>-->
       <!--                         <th class="custom_td"><?php // echo translate('shipping_region');?></th>-->
       <!--                         <td class="custom_td">-->
       <!--                             <?php // echo $row['ship_region'];?>-->
       <!--                         </td>-->
       <!--                     </tr>-->
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
	.modal-footer
	{
		display:none;
	}
</style>