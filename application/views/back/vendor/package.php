<div id="content-container"> 

    <div id="page-title">

        <h1 class="page-header text-overflow"><?php echo translate('upgrade_membership');?></h1>

    </div>

    <div class="tab-base">

        <div class="tab-base tab-stacked-left">

            <div class="col-sm-12">

            <div class="panel panel-bordered-dark">

                <?php

                    $membership    = $this->db->get_where('vendor', array(

                        'vendor_id' => $this->session->userdata('vendor_id')

                    ))->row()->membership;

                    echo form_open(base_url() . 'index.php/vendor/package/upgrade/', array(

                        'class'     => 'form-horizontal',

                        'method'    => 'post',

                        'id'        => 'upgrade_form',

                        'enctype'   => 'multipart/form-data'

                    ));

                ?>

                    <div class="panel-body">



                        <div class="form-group">

                            <label class="col-sm-4 control-label"><?php echo translate('Vendorship Type');?></label>

                            <div class="col-sm-6">

                                <select name="membership" id="type" class="demo-chosen-select" onchange="get_membership_info(this.value)">

                                    <option value="0" 

                                        <?php

                                            $e_match = $membership;

                                            if ($e_match == 0) {

                                                $e_match = 'free';

                                            }

                                            if ($e_match == 0) {

                                                echo 'selected="selected"';

                                            } 

                                        ?> >

                                        <?php echo translate('default');?>

                                    </option> 

                                    <?php

                                        $memberships = $this->db->get('membership')->result_array();

                                        foreach ($memberships as $row1) {

                                    ?>

                                    <option value="<?php echo $row1['membership_id']; ?>" 

                                        <?php if ($row1['membership_id'] == $e_match) {

                                            echo 'selected="selected"';

                                        } ?> >

                                        <?php echo $row1['title']; ?>

                                    </option>

                                    <?php

                                        }

                                    ?>

                                </select>

                            </div>

                        </div>



                        <div class="form-group">

                            <label class="col-sm-4 control-label"><?php echo translate('details');?></label>

                            <div class="col-sm-6" id="mem_info">



                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-sm-4 control-label"><?php echo translate('payment_method');?></label>

                            <div class="col-sm-6">

                                <select name="method" class="demo-chosen-select" onchange="get_stripe(this.value)">

                                <?php if($this->db->get_where('business_settings',array('type'=>'paypal_set'))->row()->value == 'ok'){ ?>

                                    <option value="paypal" >PayPal</option>

                                <?php } if($this->db->get_where('business_settings',array('type'=>'stripe_set'))->row()->value == 'ok'){ ?>

                                    <option value="stripe" >Stripe</option>

                                <?php } ?>

                                    <option value="cash" >Cash</option>

                                </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-sm-4 control-label"></label>

                            <div class="col-sm-6">

                                <span id='verify'></span>

                            </div>

                        </div>

                        <script src="https://checkout.stripe.com/checkout.js"></script>

                        <script type="text/javascript">

                            var handler = StripeCheckout.configure({

                                key: '<?php echo $this->db->get_where('business_settings' , array('type' => 'stripe_publishable'))->row()->value;  ?>',

                                image: '',

                                token: function(token) {

                                  // Use the token to create the charge with a server-side script.

                                  // You can access the token ID with `token.id`

                                    $('#upgrade_form').append("<input type='hidden' name='stripeToken' value='" + token.id + "' />");

                                    $.activeitNoty({

                                        type: 'success',

                                        icon : 'fa fa-check',

                                        message : '<?php echo translate('your_card_details_verified!'); ?>',

                                        container : 'floating',

                                        timer : 3000

                                    });

                                    $('#verify').html('<?php echo translate('your_card_details_verified!'); ?>');

                                }

                            });



                            function get_stripe(type){

                                var typea = $('#type').val();

                                if(type == 'stripe'){

                                    $.ajax({

                                        url: "<?php echo base_url(); ?>index.php/vendor/business_settings/membership_price/"+typea, 

                                        success: function(total){

                                            total = total/parseFloat(<?php echo $this->crud_model->get_type_name_by_id('business_settings', '8', 'value'); ?>);

                                            total = total*100;

                                            handler.open({

                                                name: '<?php echo $system_title; ?>',

                                                description: '<?php echo translate('pay_with_stripe'); ?>',

                                                amount: total

                                            });

                                        }

                                    });



                                }

                            }

                            // Close Checkout on page navigation

                            $(window).on('popstate', function() {

                                handler.close();

                            });

                        </script>

                    <div class="panel-footer text-right">


                     <?php 
                $ex2=0; 
                $ex2=$this->db->get_where('membership_payment',array('vendor'=>$this->session->userdata('vendor_id'),'membership'=>$membership,'status'=>'due'))->num_rows();
            
                   // echo $ex2;
                  if($ex2==0)
                  {
                ?>  
                    <span class="btn btn-success btn-labeled fa fa-check submitter" type="submit"  data-ing='<?php echo translate('upgradeing'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                        <?php echo translate('upgrade');?></span>

                <?php  } elseif ($ex2>0) { ?>
                    <span class="btn btn-success btn-labeled fa fa-check " type="" onclick="delete_reject('You already send request for upgrade !');" >
                        <?php echo translate('upgrade');?></span>
                <?php   } ?>

                        <!-- <button class="btn btn-info" >

                            <?php //echo translate('upgrade');?>

                        </button>
 -->
                    </div>

                <?php
						echo form_close();
				?>

            </div>

            </div>

        </div>

    </div>

</div>

<div style="display:none;" id="business"></div>

<script>

	var base_url = '<?php echo base_url(); ?>';

	var user_type = 'vendor';

	var module = 'logo_settings';

	var list_cont_func = 'show_all';

	var dlt_cont_func = 'delete_logo';



    function get_membership_info(id){

        $('#mem_info').load('<?php echo base_url(); ?>index.php/vendor/business_settings/membership_info/'+id);

    }

    $(document).ready(function(){

        get_membership_info(<?php echo $membership; ?>);

    });



</script>

<script src="<?php echo base_url(); ?>template/back/js/custom/business.js"></script>

<script type="text/javascript">
    
function delete_reject(msg)
{ 
    $.activeitNoty({
            type: 'danger',
            icon : 'fa fa-warning',
            message : msg , // "You can not delete this data now.This data used in other records now..",
            container : 'floating',
            timer : 3000
            });
}

</script>