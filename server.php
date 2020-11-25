<?php
function getVisIpAddr() { 
      
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
        return $_SERVER['HTTP_CLIENT_IP']; 
    } 
    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
        return $_SERVER['HTTP_X_FORWARDED_FOR']; 
    } 
    else { 
        return $_SERVER['REMOTE_ADDR']; 
    } 
} 
  
// Store the IP address 
$ip = getVisIPAddr(); 
  
// Display the IP address 
echo $ip.'<br />'; 

$ipdat = @json_decode(file_get_contents( 
    "http://www.geoplugin.net/json.gp?ip=" . $ip)); 
echo '<pre>'; print_r($ipdat); echo '</pre>'; 

echo '<br /><hr /><br />';
echo '<pre>'; print_r($_SERVER); echo '</pre>';

