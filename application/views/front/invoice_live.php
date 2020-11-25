
    

        
    <div class="ps-page--simple">
        <div class="ps-breadcrumb">
            <div class="container">
              <ul class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li>Invoice</li>
              </ul>
            </div>
        </div>

        <div class="ps-section--shopping ps-shopping-cart invoice_div">
            <div class="container">
                <div class="ps-section__header invoice-header">
                    <!-- <img class="" style="width: 30%;" src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="" /> -->
                    <h1>Invoice</h1>
                </div>
                <?php
                    $sale_details = $this->db->get_where('sale',array('sale_id'=>$sale_id))->row();
                    $info    = json_decode($sale_details->shipping_address,true);
                ?> 
                <div class="ps-section__footer">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 " >
                            <div class="ps-block">
                                <h4><?php echo translate('billing_address');?></h4>
                                <address>
									<?php echo translate($info['firstname'])." ".$info['lastname']; ?> <br/>
                                    <?php echo $info['address1']; ?> <br/>
                                    <?php echo $info['address2']; ?> <br/>
                                    <?php echo $info['city']; ?> <br/>
                                    <?php echo translate('zip');?> : <?php echo $info['zip']; ?> <br/>
                                    <?php echo translate('phone');?> : <?php echo $info['mobile']; ?> <br/>
                                    <?php echo translate('e-mail');?> : <a href=""><?php echo $info['email']; ?></a>
                                </address>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                            <div class="ps-block">
                                <h4><?php echo translate('shipping_address');?></h4>
                                <address>
                                    <?php echo translate($info['s_firstname'])." ".$info['s_lastname']; ?> <br/>
                                    <?php echo $info['s_address1']; ?> <br/>
                                    <?php echo $info['s_address2']; ?> <br/>
                                    <?php echo $info['s_city']; ?> <br/>
                                    <?php echo translate('zip');?> : <?php echo $info['s_zip']; ?> <br/>
                                    <?php echo translate('phone');?> : <?php echo $info['s_mobile']; ?> <br/>
                                    <?php echo translate('e-mail');?> : <a href=""><?php echo $info['s_email']; ?></a>
                                </address>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                            <div class="ps-block">
                                <?php 
                                    echo translate('invoice_no')." : ".$sale_details->sale_code;
                                    echo "<br/>";
                                    echo translate('sale_date')." : ".date('d M, Y',$sale_details->sale_datetime);
                                ?>
                            </div>
                        </div>  
                      
                    </div>
                </div>
                <div class="ps-section__content">
                    <div class="table-responsive">
                      <table class="table ps-table--shopping-cart">
                        <thead>
                          <tr>
                            <th><?php echo translate('sl_no');?></th>
                            <th><?php echo translate('product_name');?></th>
                            <th><?php echo translate('price');?></th>
                            <th><?php echo translate('quantity');?></th>
                            <th><?php echo translate('total');?></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $allDigital = true;
                            $i++;
                            $total = 0;
                            $product_details = json_decode($sale_details->product_details, true);
                            foreach ($product_details as $items) 
                              {
                                if($this->db->select('download')->get_where('product',array('product_id'=>$items['id']))->row()->download != 'ok')
                                    { $allDigital = false; }
                                  ?>
                                  <tr align="center">
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                    <td>
                                      <div class="ps-product--cart">
                                          <!-- <div class="ps-product__thumbnail">
                                            <img src="<?php echo $items['image']; ?>" alt="">
                                          </div> -->
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
                                    <td style="text-align:center">
                                      <?php 
                                        echo currency().$this->cart->format_number($items['subtotal']); 
                                        $total+=$items['subtotal'];
                                      ?>
                                    </td>
                                  </tr>
                                  <?php
                              }
                          ?>
                        </tbody>
                      </table>
                    </div>
                </div>

                <div class="ps-section__footer">
                    <div class="row">
                      <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 " >
                      </div>
                      <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                      </div>
                      <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                        <div class="ps-block--shopping-total">
                          <div class="ps-block__header">
                            <p>
                                <?php echo translate('gross_total');?>
                                <span>
                                    <?php echo currency().$this->cart->format_number($total);?>
                                </span>
                            </p>
                          </div>
                          <div class="ps-block__header">
                            <p>
                                <?php echo translate('tax');?>
                                <span>
                                    <?php 
                                        echo currency().$this->cart->format_number($sale_details->vat);
                                    ?>
                                </span>
                            </p>
                          </div>
                          <div class="ps-block__header">
                            <p>
                                <?php echo translate('shipping_charges');?>
                                <span>
                                    <?php 
                                        echo currency().$this->cart->format_number($sale_details->shipping);
                                    ?>
                                </span>
                            </p>
                          </div>
                          <div class="ps-block__header">
                            <p>
                               <?php echo translate('discount');?>
                               <span>
                                    <?php 
                                        echo currency().$this->cart->format_number($sale_details->discount); 
                                    ?>
                               </span>
                            </p>
                          </div>
                          <div class="ps-block__content">
                            <h3>
                                <?php echo translate('net_payable');?>
                                <span class="grand_total">
                                    <?php 
                                        echo currency().$this->cart->format_number($sale_details->grand_total);
                                    ?>
                                </span>
                            </h3>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="ps-section__cart-actions psdiv">
                  <a class="ps-btn psdiv" href="<?php echo base_url('home/category');?>">
                    <i class="icon-arrow-left"></i> Continue Shopping
                  </a>
                  <a class="ps-btn ps-btn--outline psdiv" onclick="javascript:window.print();">
                    <i class="fa fa-print"></i> <?php echo translate('print');?>
                  </a>
                </div>

            </div>
        </div>
    </div>

        
        <style type="text/css">
            @media print 
            {
                .ps-breadcrumb
                {
                    display: none;
                }
                .ps-footer
                {
                    display: none;
                }
                .ps-newsletter
                {
                    display: none;
                }
                .psdiv
                {
                    display: none;
                }
                .header
                {
                    display: none;
                }
                .navigation--list
                {
                    display: none;
                }
                .navigation__item
                {
                    display: none;
                }
                .ps-block--user-header
                {
                    display: none;
                }
                .navigation__content
                {
                    display: none;
                }
                .invoice_div
                {
                    display: block;
                }
            }
        </style>