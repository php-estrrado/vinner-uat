<?php
	

	$trd=$_GET["trcno"];
	//echo $trd;

	require_once('library/fedex/fedex-common.php');
	$path_to_wsdl = "library/fedex/TrackService_v12.wsdl";
	ini_set("soap.wsdl_cache_enabled", "0");
	$client = new SoapClient($path_to_wsdl, array('trace' => 1));

		$fedexlabels_key = 'gaiwH2Bam3HGqvGC'; //Fedex Key
		$fedexlabels_password = 'toNZb8dT6PCv8wJ4hZwUqk2fa'; 	//Fedex Password
		$fedexlabels_account  = '510087461';
		$fedexlabels_meter_id = '100300801';

		$request['WebAuthenticationDetail'] = array(
		'UserCredential' =>array(
		'Key' => $fedexlabels_key , 
		'Password' =>$fedexlabels_password 
			)
		);

		$request['ClientDetail'] = array(
		'AccountNumber' =>$fedexlabels_account, 
		'MeterNumber' =>$fedexlabels_meter_id  
		);

		$request['TransactionDetail'] = array('CustomerTransactionId' => '*** Track Request using PHP ***');
		$request['Version'] = array(
		'ServiceId' => 'trck', 
		'Major' => '12', 
		'Intermediate' => '0', 
		'Minor' => '0'
		);

		$request['SelectionDetails'] = array(
		'PackageIdentifier' => array(
		'Type' => 'TRACKING_NUMBER_OR_DOORTAG',
		'Value' => 11111111111111 //$trd			
		)
		);


		try 
		{
			if(setEndpoint('changeEndpoint'))
			{
				$newLocation = $client->__setLocation(setEndpoint('endpoint'));
			}
			$response = $client ->track($request);
    		if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR')
    		{
				if($response->HighestSeverity != 'SUCCESS')
				{
					echo $jsonformat=json_encode($response->Notifications);
				}
				else
				{
	    			if ($response->CompletedTrackDetails->HighestSeverity != 'SUCCESS')
	    			{
	    				 echo $jsonformat=json_encode($response->CompletedTrackDetails);
	    				//echo $jsonformat;
 
	    				/*$jsondecode=json_decode($jsonformat);

	    				foreach ($jsondecode as $key) 
	    				{
	    					echo json_decode($key["Notification"]);
	    					
	    				}
*/

					}
					else
					{
						$jsonformat =json_encode($response->CompletedTrackDetails->TrackDetails);
				echo '<table border="1">';
			    echo '<tr><th>Package Level Tracking Details</th><th>&nbsp;</th></tr>';
			    trackDetailsr($response->CompletedTrackDetails->TrackDetails, '');
				echo '</table>';


					}
				}
        	//printSuccess($client, $response);
    		}
    		else
    		{
       	 		//printError($client, $response);
    		} 
    
 		  writeToLog($client);    // Write to log file   
		} 
		catch (SoapFault $exception) 
		{
    		//printFault($exception, $client);
		}



function trackDetailsr($details, $spacer)
{
	foreach($details as $key => $value)
	{
		if(is_array($value) || is_object($value))
		{
        	$newSpacer = $spacer. '&nbsp;&nbsp;&nbsp;&nbsp;';
    		echo '<tr><td>'. $spacer . $key.'</td><td>&nbsp;</td></tr>';
    		trackDetails($value, $newSpacer);
    	}
    	elseif(empty($value))
    	{
    		echo '<tr><td>'.$spacer. $key .'</td><td>&nbsp;</td></tr>';
    	}
    	else
    	{
    		echo '<tr><td>'.$spacer. $key .'</td><td>'.$value.'</td></tr>';
    	}
    }

}


?>	