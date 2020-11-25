	<?php 
        $sale_details   =   $this->db->get_where('sale',array('sale_id'=>$sale_id))->row();
        $info           =   json_decode($sale_details->shipping_address,true);
        $product_details =   json_decode($sale_details->product_details, true);
		$billCountry    =   $this->crud_model->getCountryName($info['country']);
		$shipCountry    =   $this->crud_model->getCountryName($info['s_country']);
        $billState      =   $this->crud_model->getStateName($billCountry->country_id, $info['state']);
        $shipState      =   $this->crud_model->getStateName($shipCountry->country_id, $info['s_state']);
		
	?>

       <table style="width: 800px;margin: 0 auto; border: 1px solid black;">
        <tr style="height: 15px;width: 100%;margin: 20px 0; background: #222;text-align: center;color: white;font: bold 15px Helvetica, Sans-Serif;text-decoration: none;letter-spacing: 20px;padding: 8px 0px;height: 30px;text-transform:uppercase;border-spacing:0px">
            <td colspan="2" >
                INVOICE
            </td>
            <td>
                <img src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" style="height: 35px;width: 112px;" />
            </td>
        </tr>
        <tr style="clear:both">
            <td colspan="3" style="clear:both">
            </td>
        </tr>
        <tr style="clear:both">
        </tr>
        <tr style="clear:both">
        </tr>
       
        <tr style="">
            <td style="vertical-align: bottom;width: 33.333%;">
                <b>Billing Address</b>
            </td>
            <td style="vertical-align: bottom;width: 33.333%;">
                <b>Shipping Address</b>
            </td>
            <td  style="width: 33.333%;">
				<?php 
                  echo translate('invoice_no')." : ".$sale_details->sale_code;
                  echo "<br/>";
                  echo translate('sale_date')." : ".date('d M, Y',strtotime($sale_details->sale_datetime));
               ?>
            </td>
        </tr>

        <tr>
            <td style="width: 33.333%;">
                <address>
                    <?php echo ucfirst($info['firstname'])." ".$info['lastname']; ?>
                    <br/>
                    <?php echo $info['address1']; ?> <br/>
                    <?php echo $info['address2']; ?> <br/>
                    <?php echo $info['city'].','.$billState; ?> <br/>
                    <?php echo $billCountry->name.' - '.$info['zip']; ?> <br/>
                    <?php echo translate('phone');?> : <?php echo $info['mobile']; ?> 
                    <br/>
                    <?php echo translate('e-mail');?> :<?php echo $info['email']; ?>                       
                </address>
            </td>
            <td style="width: 33.333%;">
                <address>
                    <?php echo ucfirst($info['s_firstname'])." ".$info['s_lastname']; ?> 
                   	<br/>
                   	<?php echo $info['s_address1']; ?> <br/>
                   	<?php echo $info['s_address2']; ?> <br/>
                   	<?php echo $info['s_city'].' ,'.$shipState; ?> <br/>
                    <?php echo $shipCountry->name.' - '.$info['s_zip']; ?> <br/>
                    <?php 
                        echo translate('phone');?> : <?php echo $info['s_mobile'];
                    ?> 
                    <br/>
                    <?php 
                        echo translate('e-mail');?> : <?php echo $info['s_email']; 
                    ?>                                
                </address>
            </td>
            <td>
            </td>
        </tr>

        <tr style="clear:both">
        </tr>
        <tr style="clear:both">
        </tr>

        <tr>
            <td colspan="3">
                <table style="clear: both;width: 100%;margin: 30px 0 0 0;border: 1px solid black; border-spacing:0px">
                    <tr style="background: #eee;">
                        <th style="border-bottom: 1px solid black;">Sl No</th>
                        <th style="border-bottom: 1px solid black;">Product Name</th>
                        <th style="border-bottom: 1px solid black;">Price</th>
                        <th style="border-bottom: 1px solid black;">Quantity</th>
                        <th style="border-bottom: 1px solid black;">Total</th>
                    </tr>
					<?php
						$allDigital = true;
						$total =$i= 0;
						foreach ($product_details as $items) 
                		{
							$i++;
				       if($this->db->select('download')->get_where('product',array('product_id'=>$items['id']))->row()->download != 'ok')
							{ $allDigital = false; }
                    		?>
							<tr align="center" style="border-bottom: 1px solid black;">
								<td style="border-bottom: 1px solid black;"><?php echo $i; ?></td>
								<td style="border-bottom: 1px solid black;">
									<?php echo $items['name']; ?>      
									<br/>Sold By:
									<strong>
											<?php 
                                                echo $this->crud_model->product_by($items['id']); 
                                            ?>
									</strong>
								</td>
								<td style="border-bottom: 1px solid black;">
									<?php
                                		echo currency().$this->cart->format_number($items['price']);
                            		?>
								</td>
								<td style="border-bottom: 1px solid black;"><?php echo $items['qty']; ?></td>
								<td style="border-bottom: 1px solid black;">
									<?php 
										echo currency().$this->cart->format_number($items['subtotal']); 
										$total+=$items['subtotal'];
                            		?>
								</td>
							</tr>
							<?php
						}
					?>
							

                    <tr>
                        <td colspan="2" > </td>
                        <td colspan="2" style="border-bottom: 1px solid black;border-left: 1px solid black;">
                            Gross Total                
                        </td>
                        <td class="" style="border-bottom: 1px solid black;border-left: 1px solid black;">
                            <?php echo currency().$this->cart->format_number($total);?>               
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" ></td>
                        <td colspan="2" style="border-bottom: 1px solid black;border-left: 1px solid black;">Tax</td>
                        <td class="total-value" style="border-bottom: 1px solid black;border-left: 1px solid black;">
                           <?php 
                        		echo currency().$this->cart->format_number($sale_details->vat);
                      		?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2" style="border-bottom: 1px solid black;border-left: 1px solid black;">
                            Shipping Charges 
                        </td>
                        <td style="border-bottom: 1px solid black;border-left: 1px solid black;">
                            <?php 
                        		echo currency().$this->cart->format_number($sale_details->shipping);
                      		?>         
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2" style="border-bottom: 1px solid black;border-left: 1px solid black;">Discount</td>
                        <td style="border-bottom: 1px solid black;border-left: 1px solid black;">
							<?php 
							echo currency().$this->cart->format_number($sale_details->discount); 
							?>
						</td>
                    </tr>

                    <tr>
                        <td colspan="2" > </td>
                        <td colspan="2" style="background: #eee; border-left: 1px solid black;" >Net Payable</td>
                        <td style="background: #eee; border-left: 1px solid black;"> 
							<b>
								<?php 
                      				echo currency().$this->cart->format_number($sale_details->grand_total);
                    			?>
							</b> 
						</td>
                    </tr>
                </table>
            </td>

        </tr>
              
    </table>