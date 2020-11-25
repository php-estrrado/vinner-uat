<?php 
    $vendor         =   $this->crud_model->get_vendor_by_id($sale[0]['vendor_id']);
    if($vendor){        $vCurrency      =   $vendor->currency.' '; }else{ $vCurrency = currency(); }
?>
<div class="panel-heading">
    <div class="panel-control" style="float: left;">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#full" onclick="setInvoice('full')"><?php echo translate('full_invoice'); ?></a>
            </li><?php if($this->crud_model->is_admin_in_sale($sale[0]['sale_id'])){ ?>
            <li>
                <a data-toggle="tab" href="#quart" onclick="setInvoice('quart')">
					<?php echo translate('invoice_for'); ?>: <?php echo translate('admin'); ?>
				</a>
            </li><?php } 
            $vendors = $this->crud_model->vendors_in_sale($sale[0]['sale_id']);
            foreach ($vendors as $ven) { ?>
                <li>
                    <a data-toggle="tab" href="#half_<?php echo $ven; ?>"  onclick="setInvoice('half_<?php echo $ven; ?>')">
                        <?php echo translate('invoice_for'); ?>: 
                        <?php echo $this->crud_model->get_type_name_by_id('vendor', $ven, 'display_name'); ?> (<?php echo translate('vendor'); ?>)
                    </a>
                </li><?php
            } ?>
        </ul>
    </div>
</div>
 <hr>
<div class="panel-body ">
    <div class="tab-base"> <?php
        foreach($sale as $row){
            $info = json_decode($row['shipping_address'],true);
            if(!file_exists('uploads/vendor/logo_'.$row['vendor_id'].'.png')){ $vimage=base_url('uploads/vendor/logo_0.png'); }
            else{ $vimage=base_url('uploads/vendor/logo_'.$row['vendor_id'].'.png'); } ?>
            <div class="col-md-2"></div>
                <div class="col-md-12 bordered print">
                    <div class="tab-content">
                        <div id="full" class="tab-pane fade active in">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-lg-4 col-md-4 col-sm-12 pad-all">
                                        <img src="<?php echo $vimage; ?>" style="height: 70px;" />
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-12 pad-all">
                                        <b class="pull-right">
                                            <?php echo translate('invoice_no');?> : <?php echo $row['sale_code']; ?>  
                                        </b><br>
                                        <b class="pull-right">
                                            <?php echo translate('date_:');?> <?php echo date('d M, Y',strtotime($row['sale_datetime']) );?>
                                        </b>
                                    </div>
                                </div>
                                <div class="col-md-12 pad-top">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                    <!--Panel heading-->
                                        <div class="panel panel-bordered-grey shadow-none">
                                            <div class="panel-heading">
                                                <h1 class="panel-title"><?php echo translate('billing_address');?></h1>
                                            </div>
                                            <!--List group-->
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <b><?php echo $info['firstname'].' '.$info['lastname'];?></b><br />
                                                            <?php echo $info['email']?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b><?php echo translate('Address')?></b>
                                                            <div class="address">
																<?php
                                                                echo $info['address1'].', ';
                                                                echo $info['address2'].'<br />'; 
                                                                echo '<i>'.translate('city').'</i> : '.$info['city'].'<br />'; 
						$bcntry=$info['country'];$bstat=$info['state'];
						$cntryname  = $this->db->get_where('fed_country',array('country_id'=>$bcntry))->row()->name;
                        $st_name= $this->db->get_where('fed_zone',array('code'=>$bstat,'country_id'=>$bcntry))->row()->name;
                                                                echo '<i>'.translate('state').'</i> : '.$st_name.'<br />';
                                                                echo '<i>'.translate('Country').'</i> : '.$cntryname.'<br />'; 
                                                                echo '<i>'.translate('zip_code').'</i> : '.$info['zip']; ?>
                                                            </div>
                                                            <b><i><?php echo translate('Phone')?></i></b> : <?php echo $info['mobile']; ?>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>    
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                    <!--Panel heading-->
                                        <div class="panel panel-bordered-grey shadow-none">
                                            <div class="panel-heading">
                                                <h1 class="panel-title"><?php echo translate('shipping_address');?></h1>
                                            </div>
                                            <!--List group-->
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <b>
															<?php 
																echo ucfirst($info['s_firstname']).' '.$info['s_lastname']; 
															?>
															</b><br/>
															<?php echo $info['s_email']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b><?php echo translate('Address')?></b>
                                                            <div class="address">
															<?php
																echo $info['s_address1'].'<br />';
																echo ($info['s_address2'])?$info['s_address2'].'<br/>':'';	
                                                                echo '<i>'.translate('city').'</i> : '.$info['s_city'].'<br />'; 
                            $bcntry=$info['s_country'];$bstat=$info['s_state'];
							$cntryname  = $this->db->get_where('fed_country',array('country_id'=>$bcntry))->row()->name;
                            $st_name=$this->db->get_where('fed_zone',array('code'=>$bstat,'country_id'=>$bcntry))->row()->name;            
		   echo '<i>'.translate('state').'</i> : '.$st_name.'<br />';
           echo '<i>'.translate('Country').'</i> : '.$cntryname.'<br />'; 
           echo '<i>'.translate('zip_code').'</i> : '.$info['s_zip']; ?>
                                                            </div>
                                                            <b><i><?php echo translate('Phone')?></i></b> : <?php echo $info['s_mobile']; ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>    
                                        </div>
                                    </div>
                                </div>
								<?php /*
                                <div class="col-md-12 pad-top">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="panel panel-bordered-grey shadow-none">
                                            <div class="panel-heading">
                                                <h1 class="panel-title"><?php echo translate('shipping_method');?></h1>
                                            </div>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <b><?php echo translate($info['ship_method'])?></b><br />
                                                            <?php echo translate($info['fed_method'])?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>    
										</div >
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="panel panel-bordered-grey shadow-none">
                                            <div class="panel-heading">
                                                <h1 class="panel-title"><?php echo translate('payment_method');?></h1>
                                            </div>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <b><?php echo translate($info['payment_type'])?></b><br /><?php 
                                                            echo '<i>'.translate('Payment_status').'</i> : '.translate($this->crud_model->sale_payment_status($row['sale_id'])).'<br />';
                                                            echo '<i>'.translate('payment_date').'</i> : '.date('d M, Y',$row['sale_datetime'] ).'<br />';
                                                            if($row['payment_details'] != ''){
                                                            echo '<i>'.translate('payment_detail').'</i> : '.$row['payment_details']; } ?> 
                                                        </td>
                                                    </tr>
                                                   
                                                </tbody>
                                            </table>    
                                        </div>
                                    </div>
                                </div> */?>
                        </div>
									
                        <div class="panel-body" id="demo_s">
                            <div class="fff panel panel-bordered panel-dark shadow-none">
                                <div class="panel-heading">
                                    <h1 class="panel-title"><?php echo translate('items_invoiced');?></h1>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th><?php echo translate('no');?></th>
                                                <th><?php echo translate('item');?></th>
                                               <!-- <th><?php echo translate('options');?></th> -->
                                                <th><?php echo translate('quantity');?></th>
                                                <th><?php echo translate('unit_cost');?></th>
                                                <th><?php echo translate('total');?></th>
                                            </tr>
                                        </thead>
                                        <tbody> <?php
                                            $product_details = json_decode($row['product_details'], true);
                                            $i =0; $total = 0;
                                            foreach ($product_details as $row1) { 
                                                $i++; ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td>
                                                        <div class="title"><?php echo $row1['name']; ?></div>
                                                        <span><?php //echo $this->crud_model->getProductDescription($row1['id']); ?></span>
                                                    </td>
                                                   <!-- <td><?php /*
                                                        $all_o = json_decode($row1['option'],true);
                                                        $color = $all_o['color']['value'];
                                                        if($color){  ?>
                                                            <div style="background:<?php echo $color; ?>; height:25px; width:25px;" ></div><?php
                                                        } 
                                                        foreach ($all_o as $l => $op) {
                                                            if($l !== 'color' && $op['value'] !== '' && $op['value'] !== NULL){
                                                                echo $op['title'].' : ';
                                                                if(is_array($va = $op['value'])){ echo $va = join(', ',$va); } else { echo $va;  }
                                                                echo '<br>';
                                                            }

                                                        }*/ ?>
                                                    </td> -->
                                                    <td><?php echo $row1['qty']; ?></td>
                                                    <td><?php echo $vCurrency.$this->cart->format_number($row1['price']); ?></td>
                                                    <td><?php echo $vCurrency.$this->cart->format_number($row1['subtotal']); $total += $row1['subtotal']; ?></td>
                                                </tr><?php
                                            } ?>
                                        </tbody>
                                    </table>
									
									<div class="col-lg-6 col-md-6 col-sm-6 pull-left margin-top-20">
                                        <div class="panel panel-bordered-grey shadow-none">
                                            <div class="panel-heading">
                                                <h1 class="panel-title"><?php echo translate('payment_details');?></h1>
                                            </div>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <b><?php echo '<i>'.translate('Payment_method').'</i> :'.translate($info['payment_type'])?></b><br /><?php 
                                                            echo '<i>'.translate('Payment_status').'</i> : '.translate($this->crud_model->sale_payment_status($row['sale_id'])).'<br />';
                                                            echo '<i>'.translate('payment_date').'</i> : '.date('d M, Y',strtotime($row['sale_datetime']) ).'<br />';
                                                            if($row['payment_details'] != ''){
                                                            echo '<i>'.translate('payment_detail').'</i> : '.$row['payment_details']; } ?> 
                                                        </td>
                                                    </tr>
                                                   
                                                </tbody>
                                            </table>    
                                        </div>
                                    </div>
									
                                    <div class="col-lg-6 col-md-6 col-sm-6 pull-right margin-top-20">
                                        <div class="panel panel-colorful panel-grey shadow-none">
                                            <table class="table" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td><b><?php echo translate('sub_total_amount');?></b></td>
                                                        <td><?php echo $vCurrency.$this->cart->format_number($total); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b><?php echo translate('tax');?></b></td>
                                                        <td><?php echo $vCurrency.$this->cart->format_number($row['vat']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b><?php echo translate('shipping');?></b></td>
                                                        <td>
															<?php 
																echo $vCurrency.$this->cart->format_number($row['shipping']); 
															?>
														</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b><?php echo translate('grand_total');?></b></td>
                                                        <td><?php echo $vCurrency.$this->cart->format_number($row['grand_total']); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div> 
                                    </div>  
                                </div>
                            </div>
                            
                        </div>
                    </div>
				<?php
                    foreach ($vendors as $ven){
                        if(!file_exists('uploads/vendor/logo_'.$ven.'.png')){ $vimage=base_url('uploads/vendor/logo_0.png'); }
                        else{ $vimage=base_url('uploads/vendor/logo_'.$ven.'.png'); } ?>
                        <div id="half_<?php echo $ven; ?>" class="tab-pane fade">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-lg-4 col-md-4 col-sm-12 pad-all">
                                        <img src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" style="height: 70px;" >
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-12 pad-all">
                                        <b class="pull-right">
                                            <?php echo translate('invoice_no');?> : <?php echo $row['sale_code']; ?>/<?php echo $ven; ?> 
                                        </b><br>
                                        <b class="pull-right">
                                            <?php echo translate('date_:');?> <?php echo date('d M, Y',$row['sale_datetime'] );?>
                                        </b>
                                    </div>
                                </div>
                                <div class="col-md-12 pad-top">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                    <!--Panel heading-->
                                        <div class="panel panel-bordered-grey shadow-none">
                                            <div class="panel-heading">
                                                <h1 class="panel-title"><?php echo translate('billing_address');?></h1>
                                            </div>
                                            <!--List group-->
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <b><?php echo $info['firstname'].' '.$info['lastname'];?></b><br />
                                                            <?php echo $info['email']?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b><?php echo translate('Address')?></b>
                                                            <div class="address">
																<?php
                                                                echo $info['address1'].', ';
                                                                echo $info['address2'].'<br />'; 
                                                                echo '<i>'.translate('city').'</i> : '.$info['city'].'<br />'; 
						$bcntry=$info['country'];$bstat=$info['state'];
						$cntryname  = $this->db->get_where('fed_country',array('country_id'=>$bcntry))->row()->name;
                        $st_name= $this->db->get_where('fed_zone',array('code'=>$bstat,'country_id'=>$bcntry))->row()->name;
                                                                echo '<i>'.translate('state').'</i> : '.$st_name.'<br />';
                                                                echo '<i>'.translate('Country').'</i> : '.$cntryname.'<br />'; 
                                                                echo '<i>'.translate('zip_code').'</i> : '.$info['zip']; ?>
                                                            </div>
                                                            <b><i><?php echo translate('Phone')?></i></b> : <?php echo $info['mobile']; ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>      
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                    <!--Panel heading-->
                                        <div class="panel panel-bordered-grey shadow-none">
                                            <div class="panel-heading">
                                                <h1 class="panel-title"><?php echo translate('shipping_address');?></h1>
                                            </div>
                                            <!--List group-->
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <b><?php echo $info['s_firstname'].' '.$info['s_lastname'];?></b>
															<br />
															<?php echo $info['s_email']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b><?php echo translate('Address')?></b>
                                                            <div class="address">
															<?php
																echo $info['s_address1'].'<br />';
																echo ($info['s_address2'])?$info['s_address2'].'<br/>':'';	
                                                                echo '<i>'.translate('city').'</i> : '.$info['s_city'].'<br />'; 
                            $bcntry=$info['s_country'];$bstat=$info['s_state'];
							$cntryname  = $this->db->get_where('fed_country',array('country_id'=>$bcntry))->row()->name;
                            $st_name=$this->db->get_where('fed_zone',array('code'=>$bstat,'country_id'=>$bcntry))->row()->name;            
		   echo '<i>'.translate('state').'</i> : '.$st_name.'<br />';
           echo '<i>'.translate('Country').'</i> : '.$cntryname.'<br />'; 
           echo '<i>'.translate('zip_code').'</i> : '.$info['s_zip']; ?>
                                                            </div>
                                                            <b><i><?php echo translate('Phone')?></i></b> : <?php echo $info['s_mobile']; ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>     
                                        </div>
                                    </div>
                                </div>
								<?php /*
                                <div class="col-md-12 pad-top">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="panel panel-bordered-grey shadow-none">
                                            <div class="panel-heading">
                                                <h1 class="panel-title"><?php echo translate('shipping_method');?></h1>
                                            </div>
                                            <!--List group-->
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <b><?php echo translate($info['ship_method'])?></b><br />
                                                            <?php echo translate($info['fed_method'])?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>    
                                        </div>
                                    </div>
									
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="panel panel-bordered-grey shadow-none">
                                            <div class="panel-heading">
                                                <h1 class="panel-title"><?php echo translate('payment_method');?></h1>
                                            </div>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <b><?php echo translate($info['payment_type'])?></b><br /><?php 
                                                            echo '<i>'.translate('Payment_status').'</i> : '.translate($this->crud_model->sale_payment_status($row['sale_id'])).'<br />';
                                                            echo '<i>'.translate('payment_date').'</i> : '.date('d M, Y',$row['sale_datetime'] ).'<br />';
                                                            if($row['payment_details'] != ''){
                                                            echo '<i>'.translate('payment_detail').'</i> : '.$row['payment_details']; } ?> 
                                                        </td>
                                                    </tr>
                                                   
                                                </tbody>
                                            </table>    
                                        </div>
                                    </div>
                                </div>
								*/ ?>
								
                            </div>
                            <div class="panel-body" id="demo_s">
                                <div class="panel panel-bordered panel-dark shadow-none">
                                    <div class="panel-heading">
                                        <h1 class="panel-title"><?php echo translate('item_invoiced');?></h1>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th><?php echo translate('no');?></th>
                                                    <th><?php echo translate('item');?></th>
                                                    <!-- <th><?php //echo translate('options');?></th> -->
                                                    <th><?php echo translate('quantity');?></th>
                                                    <th><?php echo translate('unit_cost');?></th>
                                                    <th><?php echo translate('total');?></th>
                                                </tr>
                                            </thead>
                                            <tbody><?php
                                                $product_details = json_decode($row['product_details'], true);

                                                $i =0;

                                                $total = 0;

                                                $vat = 0;

                                                $shipping = 0;
                                                foreach ($product_details as $row1) {
                                                    if($this->crud_model->is_added_by('product',$row1['id'],$ven)){  $i++; ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td>
                                                                <div class="title">
																	<?php echo $row1['name']; ?>
																</div>
                                                                <span>
																	<?php 
																	//echo $this->crud_model->getProductDescription($row1['id']); 
																	?>
																</span>
                                                            </td>
                                                            
                                                           <!-- <td>
															<?php /*
                                                                $all_o = json_decode($row1['option'],true);
                                                                $color = $all_o['color']['value'];
                                                                if($color){ ?>
                                                                    <div style="background:<?php echo $color; ?>; height:25px; width:25px;" ></div><?php
                                                                }
                                                                foreach ($all_o as $l => $op) {
                                                                    if($l !== 'color' && $op['value'] !== '' && $op['value'] !== NULL){
                                                                        echo $op['title'].' : '; 
                                                                        if(is_array($va = $op['value'])){ echo $va = join(', ',$va); } else { echo $va;  }
                                                                        echo '<br>';
                                                                    }
                                                                } */?>
                                                            </td>-->
                                                            <td><?php echo $row1['qty']; ?></td>
                                                            <td>
																<?php 
																echo $vCurrency.$this->cart->format_number($row1['price']); 
																?>
														  </td>
                                                           <td>
															 <?php 
																echo $vCurrency.$this->cart->format_number($row1['subtotal']); 
																$total += $row1['subtotal']; 
															   ?>
														  </td>
															<?php
                                                            $vat += $row1['tax']*$row1['qty'];
                                                            $shipping += $row1['shipping']*$row1['qty']; ?>
                                                        </tr>
														<?php
                                                    }
                                                } ?>
                                            </tbody>
                                        </table>
										
										<div class="col-lg-6 col-md-6 col-sm-6 margin-top-20">
											<div class="panel panel-bordered-grey shadow-none">
												<div class="panel-heading">
													<h1 class="panel-title"><?php echo translate('payment_details');?></h1>
												</div>
												<table class="table">
													<tbody>
														<tr>
															<td>
																<b><?php echo '<i>'.translate('Payment_method').'</i> :'. translate($info['payment_type'])?></b><br /><?php 
																echo '<i>'.translate('Payment_status').'</i> : '.translate($this->crud_model->sale_payment_status($row['sale_id'])).'<br />';
																echo '<i>'.translate('payment_date').'</i> : '.date('d M, Y',strtotime($row['sale_datetime']) ).'<br />';
																if($row['payment_details'] != ''){
																echo '<i>'.translate('payment_detail').'</i> : '.$row['payment_details']; } ?> 
															</td>
														</tr>

													</tbody>
												</table>    
											</div>
                                    	</div>
										
                                        <div class="col-lg-6 col-md-6 col-sm-6 pull-right margin-top-20">
                                            <div class="panel panel-colorful panel-grey shadow-none">
                                                <table class="table" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td><b><?php echo translate('sub_total_amount');?></b></td>
                                                            <td>
																<?php echo $vCurrency.$this->cart->format_number($total); ?>
															</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo translate('tax');?></b></td>
                                                            <td><?php echo $vCurrency.$this->cart->format_number($vat); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo translate('shipping');?></b></td>
                                                            <td>
																<?php 
					 												echo $vCurrency.$this->cart->format_number($shipping); 
																?>
															</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php echo translate('grand_total');?></b></td>
                                                            <td>
																<?php 
					 										echo $vCurrency.$this->cart->format_number($total+$vat+$shipping); 
																?>
															</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div><?php
                    } ?>
                    <div id="quart" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-lg-4 col-md-4 col-sm-12 pad-all">
                                    <img src="<?php echo $this->crud_model->logo('home_top_logo'); ?>"  style="height: 70px;" />
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-12 pad-all">
                                    <b class="pull-right">
                                        <?php echo translate('invoice_no');?> : <?php echo $row['sale_code']; ?> / A
                                    </b> <br>
                                    <b class="pull-right">
                                        <?php echo translate('date_:');?> <?php echo date('d M, Y',$row['sale_datetime'] );?>
                                    </b>
                                </div>
                            </div>
                            <div class="col-md-12 pad-top">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                <!--Panel heading-->
                                    <div class="panel panel-bordered-grey shadow-none">
                                        <div class="panel-heading">
                                            <h1 class="panel-title"><?php echo translate('client_information');?></h1>
                                        </div>
                                        <!--List group-->
                                        <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <b><?php echo $info['firstname'].' '.$info['lastname'];?></b><br />
                                                            <?php echo $info['email']?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b><?php echo translate('Address')?></b>
                                                            <div class="address"><?php
                                                                echo $info['address1'].', ';
                                                                echo $info['address2'].'<br />'; 
                                                                echo '<i>'.translate('city').'</i> : '.$info['city'].'<br />'; 
                                                                echo '<i>'.translate('state').'</i> : '.$this->crud_model->getStateName($info['bill_country1'],$info['bill_state']).'<br />';
                                                                echo '<i>'.translate('Country').'</i> : '.$this->crud_model->getCountryName($info['bill_country1'])->name.'<br />'; 
                                                                echo '<i>'.translate('zip_code').'</i> : '.$info['zip']; ?>
                                                            </div>
                                                            <b><i><?php echo translate('Phone')?></i></b> : <?php echo $info['phone']; ?>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>    
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                <!--Panel heading-->
                                    <div class="panel panel-bordered-grey shadow-none">
                                        <div class="panel-heading">
                                            <h1 class="panel-title"><?php echo translate('payment_detail');?></h1>
                                        </div>
                                        <!--List group-->
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td><b><?php echo translate('payment_status');?></b></td>
                                                    <td><i><?php echo translate($this->crud_model->sale_payment_status($row['sale_id'],'admin')); ?></i></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('payment_method');?></b></td>
                                                    <td><?php echo ucfirst(str_replace('_', ' ', $info['payment_type'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('payment_date');?></b></td>
                                                    <td><?php echo date('d M, Y',$row['sale_datetime'] );?></td>
                                                </tr>
                                            </tbody>
                                        </table>    
                                    </div>
                                </div>
                           </div>
                        </div>
                    <div class="panel-body" id="demo_s">

                        <div class="panel panel-bordered panel-dark shadow-none">

                            <div class="panel-heading">

                                <h1 class="panel-title"><?php echo translate('payment_invoice');?></h1>

                            </div>

                            <div class="table-responsive">

                                <table class="table table-bordered table-striped">

                                    <thead>

                                        <tr>

                                            <th><?php echo translate('no');?></th>

                                            <th><?php echo translate('item');?></th>

                                            <th><?php echo translate('options');?></th>

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

                                            foreach ($product_details as $row1) {

                                                if($this->crud_model->is_added_by('product',$row1['id'],0,'admin')){

                                                $i++;

                                        ?>

                                        <tr>

                                            <td><?php echo $i; ?></td>

                                            <td><?php echo $row1['name']; ?></td>

                                            <td>

                                                <?php 

                                                    $all_o = json_decode($row1['option'],true);

                                                    $color = $all_o['color']['value'];

                                                        if($color){

                                                ?>

                                                <div style="background:<?php echo $color; ?>; height:25px; width:25px;" ></div>

                                                <?php

                                                    }

                                                ?>

                                                <?php

                                                    foreach ($all_o as $l => $op) {

                                                        if($l !== 'color' && $op['value'] !== '' && $op['value'] !== NULL){

                                                ?>

                                                    <?php echo $op['title'] ?> : 

                                                    <?php 

                                                        if(is_array($va = $op['value'])){ 

                                                            echo $va = join(', ',$va); 

                                                        } else {

                                                            echo $va;

                                                        }

                                                    ?>

                                                    <br>

                                                <?php

                                                        }

                                                    }

                                                ?>

                                            </td>

                                            <td><?php echo $row1['qty']; ?></td>

                                            <td><?php echo $vCurrency.$this->cart->format_number($row1['price']); ?></td>

                                            <td>
												<?php 
													echo $vCurrency.$this->cart->format_number($row1['subtotal']); 
													$total += $row1['subtotal']; 
												?>
											</td>

                                            <?php
                                                $vat += $row1['tax']*$row1['qty'];
                                                $shipping += $row1['shipping']*$row1['qty'];
                                            ?>
                                        </tr>
                                        <?php
                                                }
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

                                                    <td><?php echo $vCurrency.$this->cart->format_number($total); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('tax');?></b></td>
                                                    <td><?php echo $vCurrency.$this->cart->format_number($vat); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('shipping');?></b></td>
                                                    <td><?php echo $vCurrency.$this->cart->format_number($shipping); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('grand_total');?></b></td>

                                                    <td>
														<?php 
															echo $vCurrency.$this->cart->format_number($total+$vat+$shipping); 
														?>
													</td>

                                                </tr>

                                            </tbody>

                                        </table>

                                    </div> 

                                </div>  

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="col-md-12">

        <div class="col-md-9"></div>

        <div class="col-md-3 print_btn">

            <a href=""><span class="btn btn-info btn-labeled fa fa-step-backward margin-top-10">
                    <?php echo translate('back');?> </span>
            </a>

            <span class="btn btn-success btn-md btn-labeled fa fa-print margin-top-10"

                onclick="printInvoice()" >

                    <?php echo translate('print');?>

            </span>
            <input type="hidden" name="inv-type" id="inv-type" value="full" />
        </div>

    </div>

</div>

<!--End Invoice Footer-->

<?php

    $position = explode(',',str_replace('(', '', str_replace(')', '',$info['langlat'])));

?>

    <script>
       function printInvoice() {
           var divName          =   document.getElementById('inv-type').value;
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
        
        function setInvoice(id){
            $('#inv-type').val(id);
        }
   </script>    

<script>

	$.getScript("http://maps.google.com/maps/api/js?v=3.exp&signed_in=true&callback=MapApiLoaded", function () {});

	function MapApiLoaded() {

		var map;

		function initialize() {

		  var mapOptions = {

			zoom: 16,

			center: {lat: <?php echo $position[0]; ?>, lng: <?php echo $position[1]; ?>}

		  };

		  map = new google.maps.Map(document.getElementById('mapa'),

			  mapOptions);

	

		  var marker = new google.maps.Marker({

			position: {lat: <?php echo $position[0]; ?>, lng: <?php echo $position[1]; ?>},

			map: map

		  });

	

		  var infowindow = new google.maps.InfoWindow({

			content: '<p><?php echo translate('marker_location'); ?>:</p><p><?php echo $info['address1']; ?> </p><p><?php echo $info['address2']; ?> </p><p><?php echo translate('city'); ?>: <?php echo $info['city']; ?> </p><p><?php echo translate('ZIP'); ?>: <?php echo $info['zip']; ?> </p>'

		  });

		  google.maps.event.addListener(marker, 'click', function() {

			infowindow.open(map, marker);

		  });

		}

		initialize();

	}

</script>



<?php

	}

?>

<style>

@media print {

	.print_btn{

		display:none;	

	}

    #navbar-container{

        display: none;

    }

    #page-title{

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

