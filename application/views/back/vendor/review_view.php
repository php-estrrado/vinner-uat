<?php 
	foreach($review_data as $row)
	{ 
        
    $user_id=$row['user_id'];
    $product_id=$row['product_id'];
    $uname = $this->db->get_where('user', array('user_id' =>$user_id))->result_array();
    $pname = $this->db->get_where('product', array('product_id' =>$product_id))->result_array();
?>
    <div id="content-container" style="padding-top:0px !important;">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-body">
       
                <table class="table table-striped" style="border-radius:3px;">
                    <tr>
                        <th class="custom_td"><?php echo translate('Customer_name');?></th>
                        <td class="custom_td"><?php  echo $uname[0]['username'];?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('Product');?></th>
                        <td class="custom_td"><?php echo $pname[0]['title'];?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('review_title');?></th>
                        <td class="custom_td"><?php echo $row['review_title'];?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('review');?></th>
                        <td class="custom_td"><?php echo $row['review'];?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('rating');?></th>
                        <td class="custom_td">
                            <?php echo $row['rating']?>
                            
                        </td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('review_date');?></th>
                        <td class="custom_td"><?php echo $row['review_date']?></td>
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

<script type="text/javascript">
    
$(".modal-footer").hide();

</script>