<?php 
        $sale_details   =   $this->db->get_where('sale',array('sale_id'=>$sale_id))->row();
        $info           =   json_decode($sale_details->shipping_address,true);
        $products       =   json_decode($sale_details->product_details, true);
        $billCountry    =   $this->crud_model->getCountryName($info['bill_country1']);
        $shipCountry    =   $this->crud_model->getCountryName($info['scountry']);
        $billState      =   $this->crud_model->getStateName($billCountry->country_id, $info['bill_state']);
        $shipState      =   $this->crud_model->getStateName($shipCountry->country_id, $info['sstate']);
    $local_freightdata = $this->db->get_where('business_settings', array('type' => 'shipment_method'))->row()->value;
    $own_freight_agent =$this->db->get_where('business_settings', array('type' => 'shipment_info'))->row()->value; 
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" id="m_-1223698502415711451background-table">
    <tbody>
        <tr>
            <td align="center" bgcolor="#f0f0f0">
                <table width="700" cellpadding="0" cellspacing="0" border="0" style="width:700px;padding:0px;margin:0px">
                    <tbody>
                        <tr>
                            <td width="700" height="25" bgcolor="#f0f0f0" valign="top" style="width:700px;height:25px;font-size:0px;padding:0px;margin:0px">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="m_-1223698502415711451header" bgcolor="#27ab4a" width="700" height="66" align="center" valign="top" style="width:700px;height:66px;font-size:0px;padding:0px;margin:0px">
                                <table width="700" cellpadding="0" cellspacing="0" border="0" style="width:700px;padding:0px;margin:0px">
                                    <tbody>
                                        <tr>
                                            <td width="700" height="68" bgcolor="#f0f0f0" valign="top" style="width:700px;height:68px;font-size:0px;padding:0px;margin:0px; background: #007aff;">
                                            <div style="width: 100%; float: left; padding: 6px;">
                                                <center> 
                                            <a class="navbar-brand" href="<?php echo base_url(); ?>">
                                             <img id="logo-header" class="img-responsive" src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="Logo" height="45">
                                            </a> </center>
                                            </div>
                                            <!--<div style="width: 45%; float: right; padding: 2% 6px;">
                                                    <img style="display:block; float: right; margin: 7px;" src="<?php //echo base_url(); ?>uploads/others/sales_invoice.png" alt="iphone">
                                            </div> -->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr> 
                        <tr>
                            <td width="700" bgcolor="#FFFFFF" align="left" valign="top" style="width:700px;font-size:0px;padding:0px;margin:0px">
                                <table width="700" cellpadding="0" cellspacing="0" border="0" style="width:700px;padding:0px;margin:0px">
                                    <tbody>
                                        <tr>
                                            <td width="31" bgcolor="#FFFFFF" valign="top" style="width:31px;font-size:0px;padding:0px;margin:0px">&nbsp;</td> 
                                            <td width="638" bgcolor="#FFFFFF" valign="top" style="width:638px;font-size:0px;padding:0px;margin:0px">
                                                <table width="638" border="0" cellspacing="0" cellpadding="0" style="width:638px;padding:0px;margin:0px">
                                                    <tbody>
                                                        <tr>
                                                            <td width="638" height="27" valign="top" style="width:638px;height:15px;font-size:0px;padding:0px;margin:0px">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="270" valign="top" style="color:#717171;font-family:Arial,Helvetica,sans-serif;font-size:20px;text-align:right;line-height:20px;padding:0px;margin:0px;font-weight:bold">
                                                                <div style="text-align:center;">
                                                                    <div style="text-align: center; padding-right: 7px;">INVOICE</div>
                                                                </div>
                                                            </td>
                                                        </tr> 
                                                        <tr>

                                                        <tr>
                                                            <td width="638" height="15" valign="top" style="width:638px;height:15px;font-size:0px;padding:0px;margin:0px">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="" valign="top" style=" float: left;color:#717171;font-family:Arial,Helvetica,sans-serif;font-size:12px;text-align:justify;line-height:20px;padding:0px;margin:0px">
                                                                <b>Dear <?php echo $info['firstname']; ?>,</b>
                                                            <br><br>
                                                                Thanks for your order from Marine Cart store. You can check the status of your order by logging into your account.
                                                                
                                                            </td>
                                                           
                                                        </tr>
                                                        <tr>
                                                            <td width="638" height="27" valign="top" style="width:638px;height:27px;font-size:0px;padding:0px;margin:0px">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                        <td width="" valign="top" style=" float: left;color:#000;font-family:Arial,Helvetica,sans-serif;font-size:15px;text-align:justify;line-height:20px;padding:0px 15px;margin:0px">
                                                            Customer Name: <?php echo ucfirst($info['firstname']); ?>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        <td width="638" height="5" valign="top" style="width:638px;padding:0px;margin:0px;">
                                                                <table style="width: 100%;">
                                                                <!-- <thead style="background: rgba(0,122,255,0.75); height: 34px; padding: 7px; color: #ffffff; font-size: 14px;">
                                                                    <tr>
                                                                    <td style=" padding: 7px; width: 50%;"><b>Billing Info.</b></td>
                                                                    <td style=" padding: 7px;"><b>Shipping Info.</b></td>
                                                                    </tr>
                                                                    </thead> -->
                                                                <tbody>
                                                                <tr>
                                                       <td valign="top" style="padding: 7px 12px;font-size: 15px;text-align:justify;line-height:20px;">
                                                       <div style="border: 1px solid;border-radius: 4px;padding: 5px 10px;width: 300px;"> 
                                                        <u><b>Invoice Address</b></u><br/>
                                                        <font style="font-size: small;"">
                                                        <?php echo $info['firstname'].' '.$info['lastname']; ?><br/>
                                                        <?php echo $info['address1']; ?><br />
                                                        <?php if($info['address2'] != ''){ echo $info['address2']; echo '<br />'; } ?>
                                                        <?php echo $info['city'].', '.$billState.', '.$info['zip']; ?><br />
                                                        <?php echo $billCountry->name?>
                                                        </font>
                                                        </div>
                                                            </td>
                                                        <td style="padding: 7px 12px; font-size: small; color: #000;">
                                                        <div style="border: 1px solid;border-radius: 4px;padding: 5px 10px;width: 250px;"> 
                                                            <table>
                                                             <tr><td>Invoice No</td><td>&nbsp; &nbsp; &nbsp;</td>
                                                                <td>Invoice Date</td></tr>
                                                             <tr><td><?php echo $sale_details->sale_code; ?></td><td>&nbsp;&nbsp;&nbsp;</td>
                                                                <td><?php echo date('d M, Y',$sale_details->sale_datetime); ?>
                                                                </td></tr>
                                                            </table>
                                                        </div>
                                                        </td>
                                                                </tr>
                                                                    </tbody>
                                                            </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="638" height="5" valign="top" style="width:638px;padding:0px;margin:0px;">
                                                                <table style="width: 100%;">
                                                                   <!--  <thead style="background: rgba(0,122,255,0.75); height: 34px; padding: 7px; color: #ffffff; font-size: 14px;">
                                                                        <tr>
                                                                            <td style=" padding: 7px; width: 50%;"><b>Shipping Method</b></td>
                                                                            <td style=" padding: 7px;"><b>Payment Method</b></td>
                                                                        </tr> 
                                                                    </thead> -->
                                                                    <tbody>
                                                                <tr>
                                                    <td valign="top" style="padding: 7px 12px;font-size: 15px;text-align:justify;line-height:20px;">
                                                    <div style="border: 1px solid;border-radius: 4px;padding: 5px 10px;width: 300px;"> 
                                                        <u><b>Shipping Address</b></u><br/>
                                                    <font style="font-size: small;">
                                                    <?php
                                        if(isset($info['ship_method'])){ 
                                        /*if($info['ship_method'] == 'fedex_shiping'){  
                                        echo ' ( '.translate($info['fed_method']).' )';} 
                                         echo "<br/>";*/
                                        //if($info['ship_method']=="fedex_shiping"){        
                                        echo $info['sfirstname'].' '.$info['slastname']; ?><br/>
                                        <?php echo $info['saddress1']; ?><br />
                                        <?php if($info['saddress2'] != ''){ echo $info['saddress2']; echo '<br />'; } ?>
                                        <?php echo $info['scity'].', '.$shipState; ?><br />
                                        <?php echo $shipCountry->name.', '.$info['szip']."<br/>";
                                       // }
                                echo 'Shipping method:'.translate($info['ship_method']);
                                if($info['ship_method'] == 'fedex_shiping'){ echo '( '.translate($info['fed_method']).' )';}
                        else if($info['ship_method']=="own_freight_agent" || $info['ship_method'] == 'local_freight_agent')
                        {
                        if($info['freight_address'] != '')
                           { 
                             echo '<br/><b>'.translate('freight_agent_detail').'</b><br/>';
                             echo '<p style="padding-left: 5px;">'.$info['freight_address'].'</p>';
                           }
                        else
                           {
                            echo '<br/><b>We will revert with local freight agent details.</b>';
                           }
                        }
                            }
                                                    else{ echo 'Not required'; } ?>
                                                    </font>  
                                                    </div>          
                                                    </td>
                                                    <td style="padding: 7px 12px; font-size: small; color: #000;">
                                                    <div style="border: 1px solid;border-radius: 4px;padding: 5px 10px;width: 250px;"> 
                                                       <table>
                                                        <tr><td>Invoice Currency:</td>
                                                                <td>USD</td>
                                                        </tr>
                                                        <tr><td>Payment Method:</td>
                                                        <td> <?php echo translate($sale_details->payment_type); ?>
                                                        </td></tr>
                                                       </table>
                                                    </div>
                                                    </td>
                                                                </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="638" height="5" valign="top" style="width:638px;padding:0px;margin:0px;">
                                                        <table style="width: 100%;">
                                                         <tbody>
                                                    <tr>
                                                        <td style="font-size: small; color: #717171;">
                                                                <table style="width: 100%;">
                                                                <thead style="background: rgba(128,128,128,0.30); font-size: 14px;">
                                                            <tr>
                                                            <td style="padding: 5px;">Sl.No</td>
                                                            <td style="padding: 5px; text-align: ;">Product Name</td>
                                                            <td style="padding: 5px; text-align: ;">Product Code</td>
                                                            <td style="padding: 5px; text-align: ;">UOM</td>
                                                            <td style="padding: 5px; text-align: right;">Qty.</td>
                                                            <td style="padding: 5px; text-align: right;">Unit Price</td>
                                                            <td style="padding: 5px; text-align: right;">Total</td>
                                                            </tr>
                                                            </thead>
                                                            <tbody style="color: #717171;font-size: small;"><?php
                                                            $i =0; $total = 0;
                                                                foreach ($products as $row1) { $i++; 
                    $pr_code =$this->crud_model->get_type_name_by_id('product',$row1['id'],'product_code');
                    $pr_umo =$this->crud_model->get_type_name_by_id('product',$row1['id'],'unit');

                                                                    ?>
                                                            <tr>
                                                            <td style="padding: 5px;border-bottom: 1px solid rgba(128,128,128,0.30);"><?php echo $i; ?></td>
                                                            <td style="padding: 5px;border-bottom: 1px solid rgba(128,128,128,0.30);"><?php echo $row1['name']; ?></td>
                                                            <td style="padding: 5px;border-bottom: 1px solid rgba(128,128,128,0.30);"><?php echo $pr_code; ?></td>
                                                            <td style="padding: 5px;border-bottom: 1px solid rgba(128,128,128,0.30);"><?php echo $pr_umo; ?></td>
                                                            <td style="padding: 5px;border-bottom: 1px solid rgba(128,128,128,0.30);text-align: right;"><?php echo $row1['qty']; ?></td>
                                                            <td style="padding: 5px;border-bottom: 1px solid rgba(128,128,128,0.30);text-align: right;"><?php echo currency().$this->cart->format_number($row1['price']); ?></td>
                                                            <td style="padding: 5px;border-bottom: 1px solid rgba(128,128,128,0.30);text-align: right;"><?php echo currency().$this->cart->format_number($row1['subtotal']); $total += $row1['subtotal']; ?></td>
                                                                                            
                                                            </tr>
                                                    <?php } ?>
                                                    <tr style="font-weight: bold;">
                                                        <td colspan="5" style="padding: 7px 5px;text-align: right;">Gross Total</td>
                                                        <td colspan="3" style="padding: 7px 5px;text-align: right;"><?php echo currency().$this->cart->format_number($total);?></td>
                                                    </tr>
                                                    <?php
                                                        if($sale_details->discount > 0){ ?>
                                                    <tr style="font-weight: bold;">
                                                        <td colspan="5" style="padding: 7px 5px;text-align: right;">Discount</td>
                                                        <td colspan="3" style="padding: 7px 5px;text-align: right;"><?php echo currency().$this->cart->format_number($sale_details->discount);?></td>
                                                    </tr><?php
                                                        }?>
                                                    <tr style="font-weight: bold;">
                                                        <td colspan="5" style="padding: 7px 5px;text-align: right;">Tax</td>
                                                        <td colspan="3" style="padding: 7px 5px;text-align: right;"><?php echo currency().$this->cart->format_number($sale_details->vat);?></td>
                                                    </tr>

                                                    <tr style="font-weight: bold;">
                                                        <td colspan="5" style="padding: 7px 5px;text-align: right;">Shipping Charges
                                                        </td>
                                                        <td colspan="3" style="padding: 7px 5px;text-align: right;"><?php echo currency().$this->cart->format_number($sale_details->shipping);?></td>
                                                    </tr>    
                                                    <tr style="font-weight: bold;">
                                                      <td colspan="5" style="padding: 7px 5px;text-align: right;">Shipping Tax</td>
                                                      <td colspan="3" style="padding: 7px 5px;text-align: right;"><?php echo currency().$this->cart->format_number($sale_details->shipp_tax);?></td>
                                                    </tr>   
                                                    <tr style="font-weight: bold; font-size: 16px;">
                                                        <td colspan="5" style="padding: 7px 5px;border-bottom: 1px solid rgba(128,128,128,0.30);text-align: right;">Grand Total</td>
                                                        <td colspan="3" style="padding: 7px 5px;border-bottom: 1px solid rgba(128,128,128,0.30);text-align: right;"><?php echo currency().$this->cart->format_number($sale_details->grand_total);?></td>
                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <!-- <td width="638" height="27" valign="top" style="width:638px;height:27px;font-size:0px;padding:0px;margin:0px">&nbsp;</td> -->
                                                       </tr> 
                                                    </tbody>
                                                </table>

                                            </td> 
                                            <td width="31" bgcolor="#FFFFFF" valign="top" style="width:31px;font-size:0px;padding:0px;margin:0px">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </td> 
                        </tr>
                    <?php if($info['ship_method']=="own_freight_agent" || $info['ship_method'] == 'local_freight_agent')
                    { ?>
                        <tr bgcolor="#FFFFFF" >
                        <td width=""  valign="top" style="padding:1px 25px;margin:0px">
                        <?php if($info['ship_method']=="own_freight_agent" ) { echo $own_freight_agent;} else { echo $local_freightdata; } ?>
                        </td>
                        </tr>
                   <? }
                    ?>
                    <tr bgcolor="#FFFFFF" >
                        <td width=""  valign="top" style="padding:1px 25px;margin:0px">
                            Note :<br/>
                            Many merchendise in marineCart are controlled items. MarineCart reserve the right to do the required verification prior to acceptance of the order
                            and shipment of materials.
                            <br/>
                            <center><b>This Document is electronically generated and does not require a Signature</b></center>
                            <font size="1em">Products offered / supplied herewith are subjected to U.N, U.S.A. and all locally applicable Trade & Export regulations. Any delivery or export of these materials to individuals or countries should solely be in full compliance with these regulations. Both, we and our customers are obligated to comply with the restrictions on Trade & Export sanctioned by the respective country of manufacture, United States of America and United Nations.</font>
                            <hr>
                        </td>
                    </tr>

                    <tr bgcolor="#FFFFFF" >
                        <td width=""  valign="top" style="padding:0px 5px;margin:0px">
                           <ul style="list-style: none;">
                            <li>Marine Cart</li>
                            <li>P.O. Box : 61232,Jebel Ali free Zone, Dubai,UAE.</li>
                            <li>TEL:+97148830233,+97148830133</li>
                             <li>Email:<a href="#">info@marinecart.com</a>,Web:<a href="https://marinecart.com">marinecart.com</a></li>
                            </ul>
                    </tr>

                        <tr>
                        <td width="700" align="center" valign="top" style="width:700px;padding:0px;margin:0px">

                        <table width="700" cellpadding="0" cellspacing="0" border="0" style="width:700px;padding:0px;margin:0px">
                        <tbody>
                        <tr>
                        <td width="700" height="60" bgcolor="#303030" valign="top" style="width:700px;height:60px;font-size:0px;padding:0px;margin:0px">
                        <a href="<?php echo base_url(); ?>" style="border:none" target="_blank" >
                            <img style="display:block; margin: 7px auto;" src="<?php echo base_url(); ?>uploads/others/footer_url.png" alt="iphone">
                        </a>
                        </td>

                        </tr>
                        </tbody>
                        </table>
                        </td>
                        </tr> 
                        <tr>
                        <td width="700" height="20" bgcolor="#f0f0f0" valign="top" style="width:700px;height:20px;font-size:0px;padding:0px;margin:0px">&nbsp;</td>
                        </tr>
                        <tr>
                        <td width="700" bgcolor="#f0f0f0" valign="top" style="width:700px;font-size:0px;padding:0px;margin:0px">


                        <table width="700" cellpadding="0" bgcolor="#f0f0f0" cellspacing="0" border="0" style="width:700px;padding:0px;margin:0px">
                        <tbody>
                        <tr>
                        <td width="21" valign="top" style="width:33px;font-size:0px;padding:0px;margin:0px;background:#f0f0f0"></td>
                        <td width="634" valign="top" style="width:658px;padding:0px;margin:0px;background:#f0f0f0;font-family:Arial,Helvetica,sans-serif;font-size:11px;color:#666666;font-weight:normal;line-height:18px;text-align:center" align="center">
                        </td>
                        <td width="21" valign="top" style="width:33px;font-size:0px;padding:0px;margin:0px;background:#f0f0f0"></td>
                        </tr>
                        </tbody>
                        </table>
                        </td>
                        </tr> 
                        <tr>
                        <td width="700" height="20" bgcolor="#f0f0f0" valign="top" style="width:700px;height:20px;font-size:0px;padding:0px;margin:0px">&nbsp;</td>
                        </tr>
                    </tbody> 
                </table>

            </td>
        </tr>
    </tbody>
 </table>