
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/drsnew/css/print_style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/drsnew/css/print.css">

        <?php
          $sale_details = $this->db->get_where('sale',array('sale_id'=>$sale_id))->row();
          $info    = json_decode($sale_details->shipping_address,true);
		  //print_r($info);	
		  $billCountry    =   $this->crud_model->getCountryName($info['country']);
		  $shipCountry    =   $this->crud_model->getCountryName($info['s_country']);
          $billState      =   $this->crud_model->getStateName($billCountry->country_id, $info['state']);
          $shipState      =   $this->crud_model->getStateName($shipCountry->country_id, $info['s_state']);
		  //echo $billCountry->name.'-'.$billState.'-'.$shipState;
        ?> 
    <div class="ps-page--simple">
      <div class="ps-breadcrumb">
        <div class="container">
          <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li>Invoice</li>
          </ul>
        </div>
      </div>
    
      <div id="page-wrap">
          <p id="header">INVOICE</p>
          <div id="identity">
              <p id="address">
              </p>
              <div id="logo">
                <img id="image" src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="" style="background: #222;padding:5px 10px;" />
              </div>
          </div>
          <div style="clear:both"></div>

          <div id="customer" class="table-responsive">
              <table id="meta" class="table" style="width: 100%;">
                <tr>
                  <td class="meta-head" style="width: 33.333%;">
                    
                    <h4><?php echo translate('billing_address');?></h4>
                                    <address>
                      <?php echo translate($info['firstname'])." ".$info['lastname']; ?> <br/>
                                        <?php echo $info['address1']; ?> <br/>
                                        <?php echo $info['address2']; ?> <br/>
                                        <?php if($info['city'] != ''){ echo $info['city'].', '; } echo $billState; ?> <br/>
                                        <?php echo $billCountry->name.' - '.$info['zip']; ?> <br/>
                                        <?php echo translate('phone');?> : <?php echo $info['mobile']; ?> <br/>
                                        <?php echo translate('e-mail');?> : <a href=""><?php echo $info['email']; ?></a>
                                    </address>
                  </td>
                  <td class="meta-head" style="width: 33.333%;">
                    <h4><?php echo translate('shipping_address');?></h4>
                                    <address>
                                        <?php echo translate($info['s_firstname'])." ".$info['s_lastname']; ?> <br/>
                                        <?php echo $info['s_address1']; ?> <br/>
                                        <?php echo $info['s_address2']; ?> <br/>
                                        <?php if($info['s_city'] != ''){ echo $info['s_city'].', '; } echo $shipState; ?> <br/>
                                        <?php echo $shipCountry->name.' - '.$info['s_zip']; ?> <br/>
                                        <?php echo translate('phone');?> : <?php echo $info['s_mobile']; ?> <br/>
                                        <?php echo translate('e-mail');?> : <a href=""><?php echo $info['s_email']; ?></a>
                                    </address>
                  </td>
                  <td class="meta-head" style="width: 33.333%;">
                    <?php 
                                        echo translate('invoice_no')." : ".$sale_details->sale_code;
                                        echo "<br/>";
                                        echo translate('sale_date')." : ".date('d M, Y',strtotime($sale_details->sale_datetime));
                                    ?>
                  </td>
                </tr>
              </table>
          </div>
		  <div class="table-responsive">
          <table id="items" class="table" style="width:100%;">
              <tr>
                  <th><?php echo translate('sl_no');?></th>
                  <th><?php echo translate('product_name');?></th>
                  <th><?php echo translate('price');?></th>
                  <th><?php echo translate('quantity');?></th>
                  <th style="text-align:right;"><?php echo translate('total');?></th>
              </tr>
              
              <?php 
                $allDigital = true;
                              
                $total =$i= 0;
                $product_details = json_decode($sale_details->product_details, true);
                foreach ($product_details as $items) 
                  {
                    $i++;
                    if($this->db->select('download')->get_where('product',array('product_id'=>$items['id']))->row()->download != 'ok')
                      { $allDigital = false; }
                    ?>
                    <tr align="center" class="item-row">
                                      <td>
                                          <?php echo $i; ?>
                                      </td>
                                      <td>
                                        <div class="ps-product--cart">
                                            <div class="ps-product__content">
                                              <?php echo $items['name']; ?>
                                              <p>
                                                Sold By:<strong> 
                                                  <?php 
                                                    echo $this->crud_model->product_by($items['id']); 
                                                  ?>
                                                </strong>
                                              </p>
                                            </div>
                                        </div>
                                      </td>
                                      <td class="price">
                                          <?php
                                           echo currency().$this->cart->format_number($items['price']);
                                          ?>
                                      </td>
                                      <td>
                                        <?php echo $items['qty']; ?>
                                      </td>
                                      <td style="text-align:right">
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
                  <td colspan="2" class="blank"> </td>
                  <td colspan="2" class="total-line"><?php echo translate('gross_total');?></td>
                  <td class="total-value" style="text-align:right;">
					  <div id="subtotal">
						  <?php echo currency().$this->cart->format_number($total);?>
					  </div>
				  </td>
              </tr>
              <tr>
                  <td colspan="2" class="blank"> </td>
                  <td colspan="2" class="total-line"><?php echo translate('tax');?></td>
                  <td class="total-value" style="text-align:right;">
                    <div id="total">
                      <?php 
                        echo currency().$this->cart->format_number($sale_details->vat);
                      ?>
                    </div>
                  </td>
              </tr>
              <tr>
                  <td colspan="2" class="blank"> </td>
                  <td colspan="2" class="total-line">
                    <?php echo translate('shipping_charges');?>
                  </td>
                  <td class="total-value" style="text-align:right;">
                    <p id="paid">
                      <?php 
                        echo currency().$this->cart->format_number($sale_details->shipping);
                      ?>
                    </p>
                  </td>
              </tr>
              <tr>
                <td colspan="2" class="blank"> </td>
                <td colspan="2" class="total-line"><?php echo translate('discount');?></td>
                <td class="total-value" style="text-align:right;">
                  <p>
                    <?php 
                      echo currency().$this->cart->format_number($sale_details->discount); 
                    ?>
                  </p>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="blank"> </td>
                <td colspan="2" class="total-line balance"><?php echo translate('net_payable');?></td>
                <td class="total-value balance" style="text-align:right;">
                  <div class="due">
                    <?php 
                      echo currency().$this->cart->format_number($sale_details->grand_total);
                    ?>
                  </div>
                </td>
              </tr>
          </table>
          </div>
          <div class="ps-section__cart-actions psdiv">
            <a class="ps-btn psdiv" href="<?php echo base_url('home/category');?>">
              <i class="icon-arrow-left"></i> Continue Shopping
            </a>
            <button class="ps-btn  float-right psdiv" onclick="javascript:window.print();">
              <i class="fa fa-print"></i> <?php echo translate('print');?>
            </button>
          </div>
      </div>
        
    </div>

        
        