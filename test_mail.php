<?php
$system_name    =   "Muzhucode";
$from           =   'merlin@merlin.me';
$to             =   'merlinsundarsingh.s@gmail.com';
$sub            =   'Test Mail';
$msg            =   'This message has been sent for just testing purpose';
$headers        =   "MIME-Version: 1.0" . "\r\n";
$headers        .=  "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers        .=  'From: ' . $system_name . '<' . $from . '>' . "\r\n";
$headers        .=  "Reply-To: " . $system_name . '<' . $from . '>' . "\r\n";
$headers        .=  "Return-Path: " . $system_name . '<' . $from . '>' . "\r\n";
$headers        .=  "X-Priority: 3\r\n";
$headers        .=  "X-Mailer: PHP" . phpversion() . "\r\n";
$headers        .=  "Organization: " . $system_name . "\r\n";
//  echo $from.' -- '.$to.' -- '.$sub.' -- '.$msg;
if(@mail($to, $sub, $msg, $headers, "-f " . $from)){ echo 'Mail sent'; }else{ echo 'Mail not sent'; }