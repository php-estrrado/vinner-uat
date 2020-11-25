<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// How to calculate request signature
$shaString  = '';
// array request
$arrData    = array(
'command'            =>'AUTHORIZATION',
'access_code'        =>'WGG6Avj6KSL4SX4zfWGQ',
'merchant_identifier'=>'879b45fb',
'merchant_reference' =>'XYZ9239-0001',
'language'           =>'en',
'amount'             =>'1',
'currency'           =>'AED',
'customer_email'     =>'test@payfort.com',
'order_description'  =>'iPhone',
'expiry_date'           => '0922',
'card_number'           => '4005550000000001',
'card_security_code'    => '123',
'card_holder_name'      => 'Merlin',
);
// sort an array by key
ksort($arrData);
foreach ($arrData as $key => $value) {
    $shaString .= "$key=$value";
}
// make sure to fill your sha request pass phrase
$shaString = "27aVEaXzC8qDf5aHJhze6o?}" . $shaString . "27aVEaXzC8qDf5aHJhze6o?}";
$signature = hash("sha256", $shaString);
// your request signature
echo $signature;


$url = 'https://sbpaymentservices.payfort.com/FortAPI/paymentApi';
$arrData = array(
'command'       =>'AUTHORIZATION',
'access_code'           =>'WGG6Avj6KSL4SX4zfWGQ',
'merchant_identifier'   =>'879b45fb',
'merchant_reference'    =>'XYZ9239-0001',
'language'              =>'en',
'amount'             =>'1',
'currency'           =>'AED',
'customer_email'     =>'test@payfort.com',
'order_description'  =>'iPhone',
'signature' => $signature,
'expiry_date'           => '0922',
'card_number'           => '4005550000000001',
'card_security_code'    => '123',
'card_holder_name'      => 'Merlin',
);

$ch = curl_init( $url );
# Setup request to send json via POST.
$data = json_encode($arrData);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
# Send request.
$result = curl_exec($ch);
curl_close($ch);
# Print response.
echo "<pre>$result</pre>";