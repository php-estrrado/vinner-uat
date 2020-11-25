<?php

    /*$contact_address =  $this->db->get_where('general_settings',array('type' => 'contact_address'))->row()->value;
    $contact_phone =  $this->db->get_where('general_settings',array('type' => 'contact_phone'))->row()->value;
    $contact_email =  $this->db->get_where('general_settings',array('type' => 'contact_email'))->row()->value;
    $contact_website =  $this->db->get_where('general_settings',array('type' => 'contact_website'))->row()->value;
    $contact_about =  $this->db->get_where('general_settings',array('type' => 'contact_about'))->row()->value;
*/
?>

<?php $userid=$this->session->userdata('user_id'); ?>
<?PHP 




?>
<div class="container content">     

 <header class="headtrack"><?php echo translate('track_order');?></header>

    <!-- Contact form Start -->  
       
                       <!--  <div class="emapp"> -->
                 <div class='login_html col-sm-6 col-md-offset-3 mee'>
                <?php
                    echo form_open(base_url() . 'index.php/home/login/do_login/', array(
                        'class' => 'log-reg-v3 sky-form',
                        'method' => 'post',
                        'style' => 'padding:30px 10px !important;',
                        'id' => 'login_form'
                    ));
                    $fb_login_set = $this->crud_model->get_type_name_by_id('general_settings','51','value');
                    $g_login_set = $this->crud_model->get_type_name_by_id('general_settings','52','value');
                ?>

                    <div class="reg-block-header">
                    <h2><?php echo translate('sign_in');?></h2>
                    <p style="font-weight:300 !important;"><?php echo translate('do_not_have_account_?_click_');?><span class="color-purple" style="cursor:pointer" data-dismiss="modal" onclick="register()" ><?php echo translate('sign_up');?></span> <?php echo translate('to_registration_.');?></p> 
                    </div>
                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input  type="email" placeholder="<?php echo translate('email_address'); ?>" name="email" class="form-control  lgin">
                            </div>
                        </label>
                    </section>
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input id="id_of_textbox" type="password" placeholder="<?php echo translate('password'); ?>" name="password" class="form-control  lgin">
                            </div>    
                        </label>
                    </section>
                <section>
                 <div class="alert alert-danger logfail" id="fail" style="display:none">
                    <strong>Login Failed!</strong> Try Again...! 
                 </div>
                </section>
                    <div class="row margin-bottom-5">
                        <div class="col-xs-8">
                            <span style="cursor:pointer;" onClick="set_html('login_html','forget_html')">
                                <?php echo translate('forget_your_password_?');?>
                            </span>
                        </div>
                        <div class="col-xs-4 text-right">
                            <span id="id_of_button" class="btn-u btn-u-cust btn-block margin-bottom-20 btn-labeled fa  login_btn" type="submit">
                                <?php echo translate('log_in');?>
                            </span>
                        </div>
                    </div>
                    <?php if($fb_login_set == 'ok' || $g_login_set == 'ok'){ ?>
                    <div class="border-wings">
                        <span>or</span>
                    </div>
                    <div class="row columns-space-removes">
                    <?php if($fb_login_set == 'ok'){ ?>
                        <div class="col-lg-6 <?php if($g_login_set !== 'ok'){ ?>mr_log<?php } ?> margin-bottom-10">
                        <?php if (@$user): ?>
                            <a href="<?= $url ?>" >
                                <div class="fb-icon-bg"></div>
                                <div class="fb-bg"></div>
                            </a>
                        <?php else: ?>
                            <a href="<?= $url ?>" >
                                <div class="fb-icon-bg"></div>
                                    <div class="fb-bg"></div>
                            </a>
                        <?php endif; ?>
                        </div>
                        <?php } if($g_login_set == 'ok'){ ?>     
                        <div class="col-lg-6 <?php if($fb_login_set !== 'ok'){ ?>mr_log<?php } ?>">
                        <?php if (@$g_user): ?>
                            <a href="<?= $g_url ?>" >
                                <div class="g-icon-bg"></div>
                                    <div class="g-bg"></div>
                            </a>                            
                        <?php else: ?>
                            <a href="<?= $g_url ?>">
                                <div class="g-icon-bg"></div>
                                    <div class="g-bg"></div>
                            </a>
                        <?php endif; ?>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </form> 
            </div>


            <div class='forget_html col-sm-6 col-md-offset-3' style="display:none;">
                <?php
                    echo form_open(base_url() . 'index.php/home/login/forget/', array(
                        'class' => 'log-reg-v3 sky-form',
                        'method' => 'post',
                        'style' => 'padding:30px !important;',
                        'id' => 'forget_form'
                    ));
                ?>    
                    <h2><?php echo translate('forgot_password');?></h2>
                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="email" placeholder="<?php echo translate('email_address'); ?>" name="email" class="form-control">
                            </div>
                        </label>
                    </section>  
                    <div class="row margin-bottom-5">
                        <div class="col-xs-8">
                            <span style="cursor:pointer;" onClick="set_html('forget_html','login_html')">
                                <?php echo translate('login');?>
                            </span>
                        </div>
                        <div class="col-xs-4 text-right">
                            <span class="btn-u btn-u-cust btn-block margin-bottom-20 forget_btn" type="submit">
                                <?php echo translate('submit');?>
                            </span>
                        </div>
                    </div>
                </form>
<input hidden type="text" name="tracklog" id="tracklog" value="tracklog">
            </div>
<!-- <input hidden type="text" name="emap" id="emap" value="welcome">-->


<div class="row ctrack">

<?php
        echo form_open(base_url() . 'index.php/home/track_order', array(
            'class' => 'sky-form',
            'method' => 'post',
            'enctype' => 'multipart/form-data',
            'id' => 'sky-form31'
        ));
?>  
<fieldset>   
    <div class="row">
        <section class="col-md-4" style="float:right">
        <label class="input" >
            <div class="input-group">
            <input type="text" name="srch_orid" class="form-control " id="srch_orid"  placeholder="Search by Order Id" value="<?php echo $srchkey; ?>"> 
            <span  class="input-group-addon btn btn-default" ><button type="submit"><i class="fa fa-search"></i></button></span> 
            </div>
        </label>
        </section>
    </div>
</fieldset>


    <?php
    //echo $userid;
      /* $i = 0;
       $this->db->order_by('sale_id','desc');
       $sales = $this->db->get_where('sale',array('buyer'=>$userid))->result_array();
       foreach ($sales as $row1) 
       { */   ?>
<?php
       $i = 0;
 if ($no == 0 || $no =='') 
{
//echo  $srchkey;  ?> 
<div class=" row container content">
           <div class="noorder" >  <?php if ($srchkey !="" || $srchkey !=0) { ?>
           Order id <?php echo  "<font color='blue'>".$srchkey."</font>";  ?> not found....
        <?php   }  else { ?> You have not placed any orders.... <?php }?> </div>
</div>
<?php }
else
{
     foreach($orders as $row1)
       { ?>
            <div class="container-fluid table-back">
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-6">
                     <h4> Order Details  </h4>
                     <div class="col-xs-12">
                         <div class="col-xs-5 name text-left"> Order ID </div>  
                         <div class="col-xs-1 name text-center"> : </div>
                         <div class="col-xs-6 name"> 
                         <?php echo $row1['sale_code']; ?>
                         </div>

                     </div>

                      <div class="col-xs-12">
                         <div class="col-xs-5 name text-left"> Order placed </div>  
                         <div class="col-xs-1 name text-center"> : </div>
                         <div class="col-xs-6 name"> <?php  echo date('d M Y',$row1['sale_datetime']);?></div>

                     </div>

                      <div class="col-xs-12">
                         <div class="col-xs-5 name text-left"> Payment Method </div>  
                         <div class="col-xs-1 name text-center"> : </div>
                         <div class="col-xs-6 name"> <?php echo translate($row1['payment_type']); ?> </div>

                     </div>

                      <div class="col-xs-12">
                         <div class="col-xs-5 name text-left"> Total Amount </div>  
                         <div class="col-xs-1 name text-center"> : </div>
                         <div class="col-xs-6 name"><?php echo currency().$row1['grand_total']; ?></div>

                     </div>
                   </div>

<!-- Shipping Details -->

                   <div class="col-xs-6">
                     <h4> Shipping Details  </h4>

        <?php 
        $sp=$row1['shipping_address'];
        $spdata = json_decode($sp,true);
        $shipping_method= $spdata['ship_method']; 
        if ($shipping_method=='pickup')
        {
          $shipping_method='pick_up_from_store';
        ?>
                     <div class="col-xs-12">
                         <div class="col-xs-5 name text-left"> Shipping Method </div>  
                         <div class="col-xs-1 name text-center"> : </div>
                         <div class="col-xs-6 name"><?php echo translate($shipping_method); ?></div>
                     </div>
                     <div class="col-xs-12">
                         <div class="col-xs-5 name text-left"> PickUp Date</div>  
                         <div class="col-xs-1 name text-center"> : </div>
                         <div class="col-xs-6 name"> 
                         <?php 
                         echo  $pdat= $spdata['pickup_date'];
                         /*$pdate=date_create($pdat);
                         echo date('d M Y',$pdate);*/ ?> 
                         </div>
                     </div>

                <?php 
                 $delivery_status = json_decode($row1['delivery_status'],true);
                
                ?>
                    <div class="col-xs-12">
                         <div class="col-xs-5 name text-left"> Delivery Status</div>  
                         <div class="col-xs-1 name text-center"> : </div>
                            <?php foreach ($delivery_status as $dev) 
                            { ?>
                         <div class="col-xs-6 name">
                               <?php  if(isset($dev['vendor']))
                                {
echo $this->crud_model->get_type_name_by_id('vendor', $dev['vendor'], 'display_name').' ('.translate('vendor').') :'.translate($dev['status']);
                                }
                                else
                                {
                                    echo translate($dev['status']);
                                    if($dev['status'] =='delivered')
                                    {
                                    echo ("(".$dev['delivery_time'].")");
                                    }
                                }
                                ?>
                         </div>
                            <?php
                                }
                            ?>
                    </div>
        <?php  
        } 
        else if($shipping_method=='fedex_shiping')
        {
        ?>             
                     <div class="col-xs-12">
                         <div class="col-xs-5 name text-left"> Shipping Method </div>  
                         <div class="col-xs-1 name text-center"> : </div>
                         <div class="col-xs-6 name"><?php echo translate($shipping_method); ?></div>
                     </div>
            <?php 
            $fedex_track = $this->db->get_where('fed_labels',array('order_id'=>$row1['sale_code']))->result_array();
             if ($fedex_track) 
            {
             foreach ($fedex_track as $rowfed)
             {
               $mtrackid =trim($rowfed['master_track_id']);
             }
            ?>
             <input hidden type="text" id="mtrac" value="<?php echo $mtrackid  ?>"  />
                     <div class="col-xs-12">
                         <div class="col-xs-5 name text-left"> Fedex Tracking Number </div>  
                         <div class="col-xs-1 name text-center"> : </div>
                         <div class="col-xs-6 name"><?php echo $mtrackid; ?></div>
                     </div>
                     
                    <!--  <div class="col-xs-12">
                         <div class="col-xs-5 name text-left"> Shipping Status </div>  
                         <div class="col-xs-1 name text-center"> : </div>
                         <div class="col-xs-6 name"> Shipped</div>

                     </div> -->

                     <div id="fedx_dt">
                    </div>

            <?php }  else{ ?>
                     <div class="col-xs-12">
                         <div class="col-xs-5 name text-left">Status</div>  
                         <div class="col-xs-1 name text-center"> : </div>
                         <div class="col-xs-6 name"> On Process </div>
                     </div>
                <?php } ?>
            <?php
            } ?>        

                   </div>
                   <!-- end of Shipping Details -->

               </div>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="margin-top ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Product Details</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table table-striped" border="0">
                            <thead>
                                <tr>
                                    
                                    <td class="text-center" colspan="1"><strong>No</strong></td>
                                    <td class="text-center" colspan="4"><strong>Product</strong></td>
                                    <td class="text-center" colspan="3"><strong>Price</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                              <?php 
                                $pr=$row1['product_details'];
                                $data = json_decode($pr,true);
                                $i++;
                                $s=0;   
                                foreach($data as $datum)
                                 {
                                $product_id=$datum['id'];
                                $s++;
                                ?>  
                                <tr> 
                                     <td class="text-center" colspan="1"><?php echo $s; ?></td>
                                    <td class="text-center" colspan="4"> <?php echo $datum['name']; ?> </td>
                                    <td class="text-right" colspan="3"><?php echo currency().$datum['subtotal']; ?></td>
                                </tr>
                                <?php 
                                }
                                ?>
                                <tr>
                                   <!--<td class="no-line" colspan="1"></td>
                                    <td class="no-line" colspan="1"></td> -->
                                    <td class="no-line text-right" colspan="5"><strong>Total</strong></td>
                                    <td class="no-line text-right" colspan="3"><?php echo currency().$row1['grand_total']; ?></td>
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

    <?php 
        }
}
?>
</div>
  
</div>  



<script>
    var base_url = '<?php echo base_url(); ?>';
        $(document).ready(function()
        {                       
        var state = check_login_stat('state');
        state.success(function (data) 
            {
             if(data == 'hypass')
                {
                  //  alert("hai");
                  $(".mee").hide();
                  $(".ctrack").show();
                } 
            else 
                {
                    // alert("bye");
                    $(".ctrack").hide();
                    $(".mee").show();
                }
            });
        });

</script>  
<!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=false"></script>-->
<!--<script src="<?php echo base_url(); ?>template/front/assets/js/custom/contact.js"></script>-->

<style type="text/css">
    
.headtrack {
/*  color: inherit;*/
  display: block;
  font-size: 25px;
  background: #fff;
  font-weight: 300;
  padding: 8px 30px;
    border-bottom: 1px solid rgba(0,0,0,.1);
    color: #232323;
}



.noorder
{
    border: 1px solid #c2c2c2;
    box-shadow: 0 0 3px #d7d7d7;
    margin: 0% 25% 10%;;
    background-color: #fff;
    width: 50%;
    color: red;
    padding: 25px 25px 25px;
    font-size: medium;
    text-align: center;
}
@media (min-width: 1200px)
{
    .container {
    width: 1170px;
}

}

@media (min-width: 992px)
{
.container {
    width: 970px;
}
}
@media (min-width: 768px)
{
.container {
    width: 750px;
}
}

.container {
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}
.container {
    width: 1200px !important;
}
.name{
    padding-top: 5px;
    padding-bottom: 5px;
}
.table-back{
        background-color: #f3f3f3;
    padding-top: 30px;
    padding-bottom: 30px;
}
.margin-top{
    margin-top: 40px;
}
</style>

<script type="text/javascript">

$(document).ready(function()
{
    var mtrack= $("#mtrac").val();
 //var mtrack=11111111111111;
    $.ajax({
            url: base_url+'fedex/trackorder.php?trcno='+mtrack,
            success: function(data) 
            {
              $('#fedx_dt').html(data);
            },
            error: function(e) 
            {
                console.log(e)
            }
        });

});

</script>

