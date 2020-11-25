  <?php /* ?>

   <div class="sdbar posts margin-bottom-20">
        <h4 class="text_color center_text mr_top_0"><?php echo translate('related_products'); ?></h4>
           <div style="max-height:350px;overflow: scroll;">
        <?php
        $i = 0;
       // $first=substr($row['model'],0,4);
        $relProduct= json_decode($row['related_products']);
            foreach ($relProduct as $rel) 
            {
                if($this->crud_model->get_type_name_by_id('product',$rel,'status') == 'ok')
                {
            ?>

               <dl class="dl-horizontal">
                <dt>
                    <a href="<?php echo $this->crud_model->product_link($rel); ?>">
                        <img src="<?php echo base_url().'uploads/product_image/product_'.$rel.'_1_thumb.jpg'?>" />
                    </a>
                </dt>
                <dd>
                    <p>
                        <a href="<?php echo $this->crud_model->product_link($rel); ?>">
                            <?php //echo $now->title; 
                                  echo substr($this->crud_model->get_type_name_by_id('product',$rel,'title'),0,40); 
                            ?>                            
                        </a>
                    </p>
                    <p><?php 
                  
                    if($this->crud_model->get_type_name_by_id('product',$rel,'current_stock') > 0  && $this->crud_model->get_type_name_by_id('product',$rel,'download') != 'ok'){

                        if($this->crud_model->get_type_name_by_id('product',$rel,'discount') > 0){ ?>
                            <span style="font-weight: 500;"><?php 
                                $rec_price=$this->crud_model->get_product_price($rel);
                                $rec_amount=exchangeCurrency($currency_value,$exchange,$rec_price);
                                echo currency()." ".convertNumber($rec_amount);?>
                            </span>
                            <span style=" text-decoration: line-through;color:#c9253c;font-weight: 300;"><?php 
                                 $rec_sale=$this->crud_model->get_type_name_by_id('product',$rel,'sale_price');
                                 $rec_sale_amount=exchangeCurrency($currency_value,$exchange,$rec_sale);
                                echo currency()." ".convertNumber($rec_sale_amount); ?>
                            </span><?php
                        } else { ?>
                            <span style="font-weight: 500;"> <?php 
                                $rec_sale=$this->crud_model->get_type_name_by_id('product',$rel,'sale_price');
                                $rec_sale_amount=exchangeCurrency($currency_value,$exchange,$rec_sale);
                                echo currency()." ".convertNumber($rec_sale_amount); ?>
                            </span><?php 
                        }
                    } ?>
                    </p>
                </dd>
            </dl>
        <?php  
              }
            }
        ?>
        </div>
    </div> <?php */ ?>
    


    <div class="sdbar posts margin-bottom-20">
        <h4 class="text_color center_text mr_top_0"><?php echo translate('related_products'); ?></h4>
        <?php
        $i = 0;
        $first=substr($row['model'],0,4);
        $relProducts    =   $this->crud_model->getRelatedProductsrp($row['model'], $row['sub_category'], $row['product_id']);
        foreach ($relProducts as $row2) {
            $now = (object) $row2; ?>       
            <dl class="dl-horizontal">
                <dt>
                    <a href="<?php echo $this->crud_model->product_link($now->product_id); ?>">
                       <?php  if ($this->crud_model->file_view('product',$row2['product_id'],'','','no','src','multi','all'))
                             { ?>
                           <img src="<?php echo base_url().'uploads/product_image/product_'.$row2['product_id'].'_1_thumb.jpg'?>" alt="<?php echo $row2['title']?>" />
                        <?php } else {  ?>
                        <img src="<?php echo base_url().'uploads/product_image/default_product_thumb.jpg';?>" alt="<?php echo $row2['title']?>" />
                        <?php } ?>
                    </a>
                </dt>
                <dd>
                    <p>
                        <a href="<?php echo $this->crud_model->product_link($now->product_id); ?>">
                            <?php 
                            //echo $now->title;
                            echo substr($now->title,0,40); ?>
                        </a>
                    </p>
                    <p><?php 
                    /*hide sale price*/ 
                    if($now->current_stock > 0  && $now->download != 'ok'){
                    /*end*/
                        if($now->discount > 0){ ?>
                            <span style="font-weight: 500;"><?php 
                                $rec_price=$this->crud_model->get_product_price($now->product_id);
                                $rec_amount=exchangeCurrency($currency_value,$exchange,$rec_price);
                                echo currency()." ".convertNumber($rec_amount);?>
                            </span >
                            <span style="text-decoration: line-through;color:#c9253c; font-weight: 500;"><?php 
                                 $rec_sale=$now->sale_price;
                                 $rec_sale_amount=exchangeCurrency($currency_value,$exchange,$rec_sale);
                                echo currency()." ".convertNumber($rec_sale_amount); ?>
                            </span><?php
                        } else { ?>
                            <span style="font-weight: 500;"> 
                            <?php
                                $rec_sale=$now->sale_price;
                                $rec_sale_amount=exchangeCurrency($currency_value,$exchange,$rec_sale);
                                echo currency()." ".convertNumber($rec_sale_amount); 
                            ?>
                            </span>
                            <?php 
                        }
                    } ?>
                    </p>
                </dd>
            </dl><?php  
        } ?>
    </div>
