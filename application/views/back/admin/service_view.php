<?php 
	foreach($request_data as $row)
	{ 
        
    $vessel_name=$row['vessel_name'];
     $equipment_make=$row['equipment_make'];  
        $tel=$row['tel'];
        $email=$row['email'];
        $contact_name=$row['contact_name'];
               $eta=$row['eta'];
        $equipment_model=$row['equipment_model'];
        $serial_no=$row['serial_no'];
        $port_of_call=$row['port_of_call'];
        $agent_details=$row['agent_details'];
        $invoice_address=$row['invoice_address'];
        $contact_name=$row['contact_name'];
        $description=$row['description'];

        $item_purchase   = $row['item_purchase'];
       /* $uname = $this->db->get_where('user', array('user_id' =>$user_id))->result_array();
         $pname = $this->db->get_where('product', array('product_id' =>$product_id))->result_array();
       */
?>
    <div id="content-container" style="padding-top:0px !important;">
  
    
    
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-body">
       
                <table class="table table-striped" style="border-radius:3px;">
                    <tr>
                        <th class="custom_td"><?php echo translate('vessel_name');?></th>
                        <td class="custom_td"><?php  echo $vessel_name;?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('equipment_make');?></th>
                        <td class="custom_td"><?php echo $equipment_make;?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('equipment_model');?></th>
                        <td class="custom_td"><?php echo $row['equipment_model'];?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('serial_no');?></th>
                        <td class="custom_td"><?php echo $row['serial_no'];?></td>
                    </tr>

                    <tr>
                        <th class="custom_td"><?php echo translate('purchased_from');?></th>
                        <td class="custom_td"><?php echo $row['item_purchase'];?></td>
                    </tr>

                    <tr>
                        <th class="custom_td"><?php echo translate('eta');?></th>
                        <td class="custom_td"><?php echo $row['eta'];?></td>
                    </tr>
                       <tr>
                        <th class="custom_td"><?php echo translate('port_of_call');?></th>
                        <td class="custom_td"><?php echo $row['port_of_call'];?></td>
                    </tr> 
                        <tr>
                        <th class="custom_td"><?php echo translate('contact_name');?></th>
                        <td class="custom_td"><?php echo $row['contact_name'];?></td>
                    </tr>
                    
                    
                   
                        <tr>
                        <th class="custom_td"><?php echo translate('tel');?></th>
                        <td class="custom_td"><?php echo $row['tel'];?></td>
                    </tr>
                    
                     <tr>
                        <th class="custom_td"><?php echo translate('email');?></th>
                        <td class="custom_td"><?php echo $row['email'];?></td>
                    </tr>
                    
                    
                     <tr>
                        <th class="custom_td"><?php echo translate('agent_details');?></th>
                        <td class="custom_td"><?php echo $row['agent_details'];?></td>
                    </tr>
                    
                    
                     <tr>
                        <th class="custom_td"><?php echo translate('invoice_address');?></th>
                        <td class="custom_td"><?php echo $row['invoice_address'];?></td>
                    </tr>
                    
                    
                     <tr>
                        <th class="custom_td"><?php echo translate('description');?></th>
                        <td class="custom_td"><?php echo $row['description'];?></td>
                    </tr>
                    
                    
                    
                    
                    
                    
                    
                    <!--<tr>
                        <th class="custom_td"><?php //echo translate('rating');?></th>
                        <td class="custom_td">
                            <?php //echo $row['rating']?>
                            
                        </td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php //echo translate('review_date');?></th>
                        <td class="custom_td"><?php //echo $row['review_date']?></td>
                    </tr>-->
                    
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