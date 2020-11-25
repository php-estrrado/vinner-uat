<?php 
	foreach($guest_data as $row)
	{ 
        
      if($row['buyer']==0) 
      {
?>
    <div id="content-container" style="padding-top:0px !important;">
       
    
    
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-body">
                <table class="table table-striped" style="border-radius:3px;">
                    <tr>
                        <th class="custom_td"><?php echo translate('name');?></th>
                        <td class="custom_td"><?php echo $row['username'].' '.$row['surname']; ?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('address');?></th>
                        <td class="custom_td">
                            <?php echo $row['address1']?><br>
                            <?php echo $row['address2']?><br>
                            <?php echo $row['city']?>-<?php echo $row['zip']?>
                        </td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('email');?></th>
                        <td class="custom_td"><?php echo $row['email']?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('phone_number');?></th>
                        <td class="custom_td"><?php echo $row['phone']?></td>
                    </tr>
                    <?php if($row['skype'] != ''){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('skype');?></th>
                        <td class="custom_td"><?php echo $row['skype']?></td>
                    </tr>
                    <?php } if($row['facebook'] != ''){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('facebook');?></th>
                        <td class="custom_td"><?php echo $row['facebook']?></td>
                    </tr>
                    <?php } if($row['google_plus'] != ''){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('google_plus');?></th>
                        <td class="custom_td"><?php echo $row['google_plus']?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('creation_date');?></th>
                        <td class="custom_td"><?php echo date('d M,Y',$row['creation_date']);?></td>
                    </tr>
                </table>
              </div>
            </div>
        </div>					
    </div>					
<?php 
      }
	}
?>
            
<style>
.custom_td{
border-left: 1px solid #ddd;
border-right: 1px solid #ddd;
border-bottom: 1px solid #ddd;
}
</style>