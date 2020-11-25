<?php
	foreach($sale as $row)
	{
	   // print_r($row);
        // if($this->crud_model->is_sale_of_vendor($row['sale_id'],$this->session->userdata('vendor_id')))
        // {
            
        $info = json_decode($row['shipping_address'],true);
        ?>
        <div class="col-md-2"></div>
        <div class="col-md-12 nopad bordered print">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-lg-4 col-md-4 col-sm-12 pad-all">
                        <img src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="" >
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 pad-all">
                        <b class="pull-right">
            				<?php echo translate('invoice_no:');?> :<?php echo $row['sale_code']; ?>/<?php echo $this->session->userdata('vendor_id'); ?>  
                        </b>
                        <br>
            			<b class="pull-right">
            				<?php echo translate('date_:');?> <?php echo date('d M, Y',strtotime($row['sale_datetime']));?>
                        </b>
                    </div>
                </div>
                
            	<div class="col-md-12 pad-top">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="panel panel-bordered-grey shadow-none">
                            <div class="panel-heading">
                                <h1 class="panel-title"><?php echo translate('bill_to');?></h1>
                            </div>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <b><?php echo ucfirst($info['firstname']).' '.$info['lastname']; ?></b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
            								<?php 
            									echo $info['address1'];
            									echo ($info['address2'])?' ,'.$info['address2']:'';
            									echo ($info['city'])?','.$info['city']:'';
            									$bcntry=$info['country'];$bstat=$info['state'];
            									$cntryname  = $this->db->get_where('fed_country',array('country_id'=>$bcntry))->row()->name;
                                                $st_name= 
            									  $this->db->get_where('fed_zone',array('code'=>$bstat,'country_id'=>$bcntry))->row()->name;
            								?>
            								<br/>
            								<?php 
            									echo ($bstat)?$st_name:'';
            									echo ($cntryname)?','.$cntryname:'';
            									echo ($info['zip'])?' - '.$info['zip']:'';
            								?>  
            								<br/>
            								<?php 
            									echo 'Mobile: '.$info['mobile'];
            								?> 
            							</td>
                                    </tr>
                                    
                                </tbody>
                            </table>	
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="panel panel-bordered-grey shadow-none">
                            <div class="panel-heading">
                                <h1 class="panel-title"><?php echo translate('ship_to');?></h1>
                            </div>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><b><?php echo ucfirst($info['s_firstname']).' '.$info['s_lastname']; ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>
            								<?php 
            									echo $info['s_address1'];
            									echo ($info['s_address2'])?' ,'.$info['s_address2']:'';
            									echo ($info['s_city'])?','.$info['s_city']:'';
            									$bcntry=$info['s_country'];$bstat=$info['s_state'];
            									$cntryname  = $this->db->get_where('fed_country',array('country_id'=>$bcntry))->row()->name;
                                                $st_name= 
            									  $this->db->get_where('fed_zone',array('code'=>$bstat,'country_id'=>$bcntry))->row()->name;
            								?>
            								<br/>
            								<?php 
            									echo ($bstat)?$st_name:'';
            									echo ($cntryname)?','.$cntryname:'';
            									echo ($info['s_zip'])?' - '.$info['s_zip']:'';
            								?>  
            								<br/>
            								<?php 
            									echo 'Mobile: '.$info['s_mobile'];
            								?> 
            							</td>
                                    </tr>
                                </tbody>
                            </table>	
                        </div>
                    </div>
               </div>
            </div>

            <div class="panel-body" id="demo_s">
                <div class="panel panel-bordered panel-dark shadow-none">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo translate('no');?></th>
                                    <th><?php echo translate('product');?></th>
                                    <th><?php echo translate('colour');?></th> 
                                    <th><?php echo translate('quantity');?></th>
                                    <th><?php echo translate('unit_cost');?></th>
                                    <th><?php echo translate('total');?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $product_details = json_decode($row['product_details'], true);
                                    $i =0;
                                    $total = 0;
                                    $vat = 0;
                                    $shipping = 0;
                                    foreach ($product_details as $row1) 
            						{
                                        // if($this->crud_model->is_added_by('product',$row1['id'],$this->session->userdata('vendor_id'))){
                                        $i++;
                                	    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row1['name']; ?></td>
                    						<td>
                                                <?php 
                                                    $all_o = json_decode($row1['option'],true);
                                                    $color = $all_o['color']['value'];
                                                    if($color)
                    								{
                    									?>
                    									<div style="background:<?php echo $color; ?>; height:15px; width:15px;border-radius: 50%;" ></div>
                    									<?php
                                                    }
                                                ?>
                                            </td> 
                                            <td><?php echo $row1['qty']; ?></td>
                                            <td><?php echo $this->session->userdata('vendor')->currency.' '.$this->cart->format_number($row1['price']); ?></td>
                                            <td>
                    							<?php 
                    								echo $this->session->userdata('vendor')->currency.' '.$this->cart->format_number($row1['subtotal']); $total += $row1['subtotal']; 
                    							?>
                    						</td>
                                            <?php
                                                $vat += $row1['tax']*$row1['qty'];
                                                $shipping += $row1['shipping']*$row1['qty'];
                                            ?>
                                        </tr>
                                         <?php
                                        //}
                                    }
                                ?>
                            </tbody>
                        </table>
                        <div class="col-lg-6 col-md-6 col-sm-6 pull-right margin-top-20">
                        	<div class="panel panel-colorful panel-grey shadow-none">
                                <table class="table" border="0">
                                    <tbody>
                                        <tr>
                                            <td><b><?php echo translate('sub_total_amount');?></b></td>
                                            <td><?php echo $this->session->userdata('vendor')->currency.' '.$this->cart->format_number($total); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b><?php echo translate('tax');?></b></td>
                                            <td><?php echo $this->session->userdata('vendor')->currency.' '.$this->cart->format_number($vat); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b><?php echo translate('shipping');?></b></td>
                                            <td><?php echo $this->session->userdata('vendor')->currency.' '.$this->cart->format_number($shipping); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b><?php echo translate('grand_total');?></b></td>
                                            <td><?php echo $this->session->userdata('vendor')->currency.' '.$this->cart->format_number($total+$vat+$shipping); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> 
                        </div>  
                    </div>
            	</div>
            </div>

        </div>

        <div class="col-md-12 nopad" id='ng-btns'>
        	<div class="row">
        		<div class="col-md-6">
        			<a  class="btn btn-success btn-md btn-labeled fa fa-reply"  href="<?php echo base_url('vendor/sales/'); ?>">Back</a>
        		</div>
        		<div class="col-md-6 print_btn text-right">
        			<span class="btn btn-success btn-md btn-labeled fa fa-reply" onclick="print()" >
        					<?php echo translate('print');?>
        			</span>
        		</div>
        	</div>
        </div>

        <!--End Invoice Footer-->
        <?php
            $position = explode(',',str_replace('(', '', str_replace(')', '',$info['langlat'])));

        // }
	}
?>
<style type="text/css">
.bordered.print {
	border-radius: 4px !important;
    background: #fff;
	padding-bottom:15px;
}
#ng-btns {
	margin-top: 10px;
}
@media print {
	.print_btn{
		display:none;	
	}
	#footer
	{
		display:none;
	}
	#navbar
	{
		display:none;
	}
    #navbar-container{
        display: none;
    }
    #page-title{
        display: none;
    }
	#ng-btns
	{
		display: none;
	}
    .print{
        width: 100%;
    }
    .col-md-6{
        width: 50%;
        float: left;
    }
}
</style>


