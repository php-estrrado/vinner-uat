<?php

/**
 * @copyright Copyright PayFort 2012-2016 
 */

if(!isset($_REQUEST['r'])) {
    echo 'Page Not Found!';
    exit;
}
require_once 'functions.php';
require_once 'PayfortIntegration.php';
//$sl = $_REQUEST['sl'];
/*
$sl = 55;
$datas=getData($sl);
$amount=100;
$accessCode         = 'X0RKysT4ngz9bJ1KZzOQ';
$shaIn              = '$$marinecart123SHAIN$$';
$shaOut             = '$$marinecart123SHAIN$$';
$hashAlgorith       = 'sha256';
$currency       	= 'AED';
*/
$itemName="Marine Cart Products";
$sl = $_REQUEST['merchant_reference'];
$datas=getData($sl);
$amount=$datas['amt'];
$accessCode         = $datas['access_code'];
$shaIn              = $datas['shaIn'];
$shaOut             = $datas['shaOut'];
$hashAlgorith       = $datas['hashAlgorith'];
$currency       	= $datas['currency'];
$merchantReference  = $datas['merchantReference'];
$objFort = new PayfortIntegration($accessCode,$shaIn,$shaOut,$hashAlgorith,$itemName,$merchantReference,$amount,$currency);

if($_REQUEST['r'] == 'getPaymentPage') {
	//print_r($_REQUEST);
    $objFort->processRequest($_REQUEST['paymentMethod'],$amount,$currency);
}
elseif($_REQUEST['r'] == 'merchantPageReturn') {
    $objFort->processMerchantPageResponse();
}
elseif($_REQUEST['r'] == 'processResponse') {
    $objFort->processResponse();
}
else{
    echo 'Page Not Found!';
    exit;
}
?>

