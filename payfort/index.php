<?php include('header.php') ?>

<?php

require_once 'functions.php';

require_once 'PayfortIntegration.php';

/*$accessCode         = 'X0RKysT4ngz9bJ1KZzOQ';

$shaIn              = '$$marinecart123SHAIN$$';

$shaOut             = '$$marinecart123SHAIN$$';

$hashAlgorith       = 'sha256';*/





$itemName="Grand Total";

//$amount = 75;
    
//$currency = 'AED';

$sl = base64_decode($_REQUEST['sl']);
//$sl = 3;
$datas=getData($sl);
// echo '<pre>'; print_r($datas); echo '</pre>'; 
$amount             =$datas['amt'];
$amount             =round($amount);

$accessCode         = $datas['access_code'];

$shaIn              = $datas['shaIn'];

$shaOut             = $datas['shaOut'];

$hashAlgorith       = $datas['hashAlgorith'];

$currency           = $datas['currency'];

//$currency           = $currency;

$merchantReference  = $datas['merchantReference'];
$cart_details       =   getProductDetails($sl);
$objFort = new PayfortIntegration($accessCode,$shaIn,$shaOut,$hashAlgorith,$itemName,$merchantReference,$amount,$currency,$cart_details);
$signtData  =   array(
                        'access_code' => $accessCode, 
                        'currency' => $currency, 
                        'merchant_reference'=>$merchantReference,
                        'amount' =>$amount,
                        'command' =>'PURCHASE',
                        'language' =>'en',
                        'merchant_identifier' => 'BmGnrDHc',
                        'customer_email' => 'test@payfort.com',
                        'digital_wallet' => 'MASTERPASS',
                        'cart_details' => '{"cart_items":[{"item_name":"Xbox360","item_description":"Xbox","item_quantity":"3","item_price":"300","item_image":"http://image.com"},{"item_name":"Xbox1","item_description":"Xbox","item_quantity":"2","item_price":"500","item_image":"http://image.com"}],"sub_total":"800"}',
                        'return_url' => 'https://estrradodemo.com/vinner/payfort/route.php?r=processResponse'
                    );
$signature = $objFort->calculateSignature($signtData, 'request');
//var_dump($datas);

?>
<style>
    .fo-root, .fo-close-xyz, .sgsefvhued, .fo-root.fo-close-xyz.sgsefvhuedc{ display: none !important; }
.aGoPf3OoOw0caWuGTZzMFeXOVF { display: none !important; }
</style>
    <section class="nav">

        <ul>

            <li class="active lead"> Payment Method</li>

            <li class="lead"> Pay</li>

            <li class="lead"> Done</li>

        </ul>

    </section>



    <section class="order-info">

        <ul class="items">

            <span>

                <i class="icon icon-bag"></i>

                <label class="lead" for="">Your Order</label>

            </span>

            <li><?php echo $objFort->itemName ?></li>

            <!-- <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ex magni delectus aliquam debitis</li> -->

        </ul>

        <ul>

            <li>

                <div class="v-seperator"></div>

            </li>

        </ul>

        <ul class="price">

            <span>

                <i class="icon icon-tag"></i>

                <label class="lead" for="">price</label>

            </span>



            <li><span class="curreny"><?php echo $currency?></span> <?php echo sprintf("%.2f",$amount);?>    </li>

        </ul>

    </section>



    <div class="h-seperator"></div>



    <section class="payment-method">

        <label class="lead" for="">

            Choose a Payment Method <small>(click one of the options below)</small>

        </label>

        <ul>

           <li>

                <input id="po_creditcard" type="radio" name="payment_option" value="creditcard" checked="checked" style="display: none">

                <label class="payment-option active" for="po_creditcard">

                    <img src="assets/img/cc.png" alt="">

                    <span class="name">Pay with credit cards (Redirection)</span>

                    <em class="seperator hidden"></em>

                    <div class="demo-container hidden"> 

                        <iframe src="" frameborder="0"></iframe>

                    </div>



                </label>

            </li>
            <li>
                <input id="VISA_CHECKOUT" type="radio" name="payment_option" value="VISA_CHECKOUT" style="display: none">
                <label class="payment-option" for="VISA_CHECKOUT">
                    <img src="assets/img/visa_checkout.png" alt="VISA_CHECKOUT">
                    <span class="name">Pay with Visa Checkout</span>
                    <em class="seperator hidden"></em>
                    <div class="demo-container hidden"> 
                        <iframe src="" frameborder="0"></iframe>
                    </div>
                </label>
            </li>
            <li>
                <input id="MASTERPASS" type="radio" name="payment_option" value="MASTERPASS" style="display: none">
                <label class="payment-option" for="MASTERPASS">
                    <img src="assets/img/masterpass.jpg" alt="MASTERPASS">
                    <span class="name">Pay with Masterpass </span>
                    <em class="seperator hidden"></em>
                    <div class="demo-container hidden"> 
                        <iframe src="" frameborder="0"></iframe>
                    </div>
                </label>
            </li>
             

             <!--<li>

                <input id="po_cc_merchantpage" type="radio" name="payment_option" value="cc_merchantpage" style="display: none">

                <label class="payment-option" for="po_cc_merchantpage">

                    <img src="assets/img/cc.png" alt="">

                    <span class="name">Pay with credit cards (Merchant Page)</span>

                    <em class="seperator hidden"></em>

                    <div class="demo-container hidden"> 

                        <iframe src="" frameborder="0"></iframe>

                    </div>



                </label>

            </li>
                <li>

                <input id="po_cc_merchantpage" type="radio" name="payment_option" value="cc_merchantpage" style="display: none">

                <label class="payment-option" for="po_cc_merchantpage">

                    <img src="assets/img/cc.png" alt="">

                    <span class="name">Pay with credit cards (Merchant Page)</span>

                    <em class="seperator hidden"></em>

                    <div class="demo-container hidden"> 

                        <iframe src="" frameborder="0"></iframe>

                    </div>



                </label>

            </li>

            <li>

                <input id="po_installments" type="radio" name="payment_option" value="installments" style="display: none">

                <label class="payment-option" for="po_installments">

                    <img src="assets/img/installment.png" alt="">

                    <span class="name"> Pay with installments</span>

                    <em class="seperator hidden"></em>

                </label>

            </li>

            <li>

                <input id="po_naps" type="radio" name="payment_option" value="naps" style="display: none">

                <label class="payment-option" for="po_naps">

                    <img src="assets/img/naps.png" alt="">

                    <span class="name">Pay with NAPS</span>

                    <em class="seperator hidden"></em>

                </label>

            </li>

            <li>

                <input id="po_sadad" type="radio" name="payment_option" value="sadad" style="display: none">

                <label class="payment-option" for="po_sadad">

                    <img src="assets/img/sadaad.png" alt="">

                    <span class="name">Pay with SADAD</span>

                    <em class="seperator hidden"></em>

                </label>

            </li> -->

        </ul>

    </section>



    <div class="h-seperator"></div>


       <!-- ======================= MASTER PASS ===================================================== -->
  
   
   <!-- ======================= MASTER PASS END ===================================================== -->
    

    <section class="actions">

        <a class="back" href="custom_error.php?sl=<?php echo $_REQUEST['sl']; ?>">Back</a>

        <a class="continue" id="btn_continue" href="javascript:void(0)">Continue</a>

    </section>

    <script type="text/javascript" src="vendors/jquery.min.js"></script>

        <script type="text/javascript" src="assets/js/checkout.js"></script>

        <script type="text/javascript">

            $(document).ready(function () {

                $('#btn_continue').click(function () {

                    var paymentMethod = $('input:radio[name=payment_option]:checked').val();

                    if(paymentMethod == '' || paymentMethod === undefined || paymentMethod === null) {

                        alert('Pelase Select Payment Method!');

                        return;

                    }

                    if(paymentMethod == 'cc_merchantpage') {

                        //alert("haiiiiiiiiiii");

                        window.location.href = 'confirm-order.php?payment_method='+paymentMethod;

                    }

                    else{

                        //alert("haiiii 12233");

                        getPaymentPage(paymentMethod,<?php echo $sl;?>);

                    }

                });

            });

        </script>

<?php include('footer.php') ?>