<div>

                            <?php
                            			echo form_open(base_url() . 'index.php/admin/abandon_group/do_add/', array(
                            				'class' => 'form-horizontal',
                            				'method' => 'post',
                            				'id' => 'abandon_group_add',
                            				'enctype' => 'multipart/form-data'
                            			));
                            		    ?>

                                        <div class="panel-body">

                                            <div class="form-group product">
                                                <label class="col-sm-4 control-label"><?php echo translate('product');?></label>
                                                <div class="col-sm-6">

                                                    <?php 
                                                        //print_r($product_list);
                                                        echo form_dropdown('product', $product_list,'','class="form-control demo-chosen-select required" id=cart_product required onchange=getcustomer()');
                                                        
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label " for="from_cart"><?php echo translate('cart_date_range');?></label>
                                                
                                                    <div class="col-sm-3 ">
                                                        <input type="text" name="from_cart" id="from_cart" value="" class="form-control required" placeholder="From date" >
                                                    </div>
                                                    <div class="col-sm-3 ">
                                                        <input type="text" name="to_cart" id="to_cart" value="" class="form-control required" placeholder="To date" >
                                                    </div>
                                                
                                            </div>

                                            <div class="form-group product">
                                                <label class="col-sm-4 control-label"><?php echo translate('Customer');?></label>
                                                <div class="col-sm-6" id='customer_drop'>
                                                    <?php 
                                                         echo form_dropdown('group_customer[]', array(),'','class="form-control demo-chosen-multiselect required" id=group_customer required multiple placeholder="Select Customer" ');  
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('abandon_group_title');?></label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="title" id="demo-hor-1"  placeholder="<?php echo translate('title'); ?>" class="form-control required">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('coupon_code');?></label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="code" id="demo-hor-1"  placeholder="<?php echo translate('code'); ?>" class="form-control required">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label"><?php echo translate('discount_type');?></label>
                                                <div class="col-sm-6">
                                                    <?php
                                                        $array = array('percent','amount');
                                                        echo $this->crud_model->select_html($array,'discount_type','','edit','demo-chosen-select required',''); 
                                                    ?>
                                                </div>
                                            </div>
                            
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('discount_value');?></label>
                                                <div class="col-sm-6">
                                                    <input type="number" name="discount_value" id="demo-hor-1"  value="" placeholder="<?php echo translate('discount_value'); ?>" class="form-control required">
                            
                                                </div>
                            
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('valid_till');?></label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="till" id="till" value="" class="form-control" placeholder="Validity Date">
                                                </div>
                                            </div>
                                            
                                        </div>
                                <?php 
                                        echo form_close();
                                ?>

</div>

<script src="<?php echo base_url(); ?>template/back/js/custom/brand_form.js"></script>
<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>'
    $('#till').datepicker({
    dayOfWeekStart : 1,
    lang:'en',
    timepicker:false,
    format:'yyyy-mm-dd',
    startDate:  '2017/01/05',
    });

    $('#from_cart').datepicker({
    dayOfWeekStart : 1,
    lang:'en',
    timepicker:false,
    format:'yyyy-mm-dd',
    startDate:  '2020/01/01',
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#to_cart').datepicker('setStartDate', minDate);
        getcustomer();
    });
    
    

    $('#to_cart').datepicker({
    dayOfWeekStart : 1,
    lang:'en',
    timepicker:false,
    format:'yyyy-mm-dd',
    startDate:  '2020/01/01',
    }).on('changeDate', getcustomer);

    function getcustomer()
    {
        $('#customer_drop').html('');
        var prid=$('#cart_product').val();
        var fromdata=$('#from_cart').val();
        var todate=$('#to_cart').val();
        // if(prid && fromdata && todate)
        // {
            $.get(base_url+'admin/cart_customerdrop?prid='+prid+'&frmdate='+fromdata+'&todat='+todate, function(data, status)
            {

                $("#customer_drop").html(data);
                $("#group_customer").chosen();
                
            });
            console.log(base_url+'admin/cart_customerdrop?prid='+prid+'&frmdate='+fromdata+'&todat='+todate);
        // }
        
    }

</script>

