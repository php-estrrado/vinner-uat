<div id="order-products" style="">
    <div>
        <h1 class="page-header text-overflow">Products</h1>
    </div>
    <div class="bootstrap-table">
        <div class="fixed-table-container">
            <div class="fixed-table-body">
                <div class="fixed-table-loading" style="top: 37px;">Loading, please wait?</div>
                <table id="demo-table" class="table table-striped table-hover" data-pagination="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true">
                    <thead>
                        <tr>
                            <th style=""><div class="th-inner ">Sl. No</div><div class="fht-cell"></div></th>
                            <th style=""><div class="th-inner ">Product Name</div><div class="fht-cell"></div></th>
                            <th style=""><div class="th-inner ">Price</div><div class="fht-cell"></div></th>
                            <th style=""><div class="th-inner ">Quantity</div><div class="fht-cell"></div></th>
                            <th style=""><div class="th-inner ">Sub Total</div><div class="fht-cell"></div></th>
                        </tr>
                    </thead>
                    <tbody id="fedex-label-content" style="border-bottom: 1px solid;">
					  <?php 
                     
                        $n = 0; $total = 0; $shipping = 0; $tax = 0;
                        foreach ($prds as $product)
						{   
							$all_o = json_decode($product->option,true);
                            $color = $all_o['color']['value'];
                            
							?>
                            <tr data-index="<?php echo $n?>"><?php $n++;?>
                                <td class=""><?php echo $n ?></td>
                                <td class="">
									<?php 
										echo $product->name; 
										if($color)
										{
											?>
											<div style="background:<?php echo $color; ?>; height:15px; width:15px;border-radius: 50%;" ></div>
											<?php
                                		}
									?>
								</td>
                                <td class="tar"><?php echo number_format($product->price, 2) ?></td>
                                <td class="tac"><?php echo $product->qty ?></td>
                                <td class="tar"><?php echo number_format($product->subtotal, 2) ?></td>
                            </tr>
						   <?php 
                            $total      =   ($total+$product->subtotal);
                        	//    $shipping   =   ($shipping+$product->shipping);
			    			$shipping   =   $row['shipping'];
                            $tax        =   ($tax+$product->tax);
                        }
                        $grandTotal =   ($total+$shipping+$tax); ?>

                    </tbody>
                    <tfoot>
                        <tr class="no-border">
                            <th class="tar" colspan="4"><div class="th-inner ">Sub Total</div><div class="fht-cell"></div></th>
                            <th class="tar"><div class="th-inner "><?php echo number_format($total,2)?></div><div class="fht-cell"></div></th>
                        </tr>
                        <tr class="no-border">
                            <th class="tar" colspan="4"><div class="th-inner ">Shipping</div><div class="fht-cell"></div></th>
                            <th class="tar"><div class="th-inner "><?php echo number_format($shipping,2)?></div><div class="fht-cell"></div></th>
                        </tr>
                        <tr class="">
                            <th class="tar" colspan="4"><div class="th-inner ">Tax</div><div class="fht-cell"></div></th>
                            <th class="tar"><div class="th-inner "><?php echo number_format($tax,2)?></div><div class="fht-cell"></div></th>
                        </tr>
                        <tr class="grand-total">
                            <th class="tar" colspan="4"><div class="th-inner ">Grand Total</div><div class="fht-cell"></div></th>
                            <th class="tar"><div class="th-inner "><?php echo number_format($grandTotal,2)?></div><div class="fht-cell"></div></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>