<?php
//    $client = new Client();
// //   $smsapi = "http://119.235.1.63:4050/Sms.svc/SendSms?phoneNumber=" . $phone . "&smsMessage=" . $smscontent . "&companyId=" . $companyid . "&pword=" . $password . "";
//    $smsapi = "https://api.smsglobal.com/http-api.php?action=sendsms& user=ax6kxp7m&password=7AXr3Nsu&from=Vinner&to=918973732732";
//    $response = $client->request("GET", $smsapi);
//    $statuscode = $response->getStatusCode();
//    $body = $response->getBody();
//    $bodycontents = $body->getContents();
//
//    if ($statuscode == 200) {
//        return $bodycontents;
//    } else {
//        return false;
//    }
    
    $curl                   =   curl_init();
    $otp = 4365;
    $message                =   urlencode('[#] Vinner OTP:'.$otp);//ZFALNc+3wue
    curl_setopt_array($curl, array(
        CURLOPT_URL         => "https://api.smsglobal.com/http-api.php?action=sendsms&user=ax6kxp7m&password=7AXr3Nsu&from=Vinner&to=918973732732&text=$message",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING    =>  "",
        CURLOPT_MAXREDIRS   =>  10,
        CURLOPT_TIMEOUT     =>  30,
        CURLOPT_HTTP_VERSION=>  CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST=> "GET",
    ));
    $response               =   curl_exec($curl);
    $err                    =   curl_error($curl);
    echo ' success<pre>'; print_r($response); echo '</pre>';
    echo 'error <pre>'; print_r($err); echo '</pre>';
    curl_close($curl);