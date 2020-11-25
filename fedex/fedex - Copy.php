<?php


		require_once('library/fedex/fedex-common.php');
                require_once('library/marine.php');
		$order_id = $_POST['orderId'];

		$path_to_wsdl = "library/fedex/ShipService_v10.wsdl";
		
		//$this->log->write(print_r($this->request->post,true));
		ini_set("soap.wsdl_cache_enabled", "0");
		
		$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information
                $marine     =   new Marine;
		
		//$this->load->model('sale/order');
		//$order_info =  $this->model_sale_order->getOrder($order_id);
		
		//$this->log->write(print_r($order_info,true));
		
		//Fedex Key
		$fedexlabels_key = "gaiwH2Bam3HGqvGC";
	
			
		//Fedex Password
		$fedexlabels_password = "toNZb8dT6PCv8wJ4hZwUqk2fa";
                
		$fedexlabels_account = "510087461";

		$fedexlabels_meter_id = "100300801";	
                
                

		$request['WebAuthenticationDetail'] = array('UserCredential' =>
			 array('Key' => $fedexlabels_key, 'Password' => $fedexlabels_password)); 
		$request['ClientDetail'] = array(
			'AccountNumber' => $fedexlabels_account, 
			'MeterNumber' => $fedexlabels_meter_id
		);
                
                $orderData      =   $marine->getProductDetails($_POST['orderId']);
                $products       =   json_decode($orderData->product_details);
                $shipAddress    =   json_decode($orderData->shipping_address);
                $productCount   =   count((array) $products);
                $prdIds         =   array();
                foreach ($products as $product){
                    $prdIds[]   =   $product->product_id;
                print_r($product); 
                }
                die;
                if($_POST['vendor'] > 0){
                    $marine->getVendor($_POST['vendor']);
                } else{
                    $vandor = array(
                                    'vendor_id'     => 0, 
                                    'name'          => 'Admin', 
                                    'company'       => 'Marine Cart', 
                                    'address1'      => 'Emphor Fzco, P.O. Box : 61232', 
                                    'address2'      => 'Jebel Ali free Zone', 
                                    'city'          => 'Dubai', 
                                    'zone_id'       =>  'DU',
                                    'country_code'  => 'AE',
                                    'zip_code'      => '61232',
                                    'phone'         => '+97148830233' 
                                    );
                    $vandor =   (object) $vandor;
                
                }
                
		
		$fedexlabels_addr = $vandor->address1;
			
		$fedexlabels_addr2 = $vandor->address2;
		
		$fedexlabels_city = $vandor->city;
			
		$fedexlabels_state = $vandor->zone_id;
			
		$fedexlabels_zip = $vandor->zip_code;
			
		$fedexlabels_country = $vandor->country_code;
				
		//TBD
		$fedexlabels_shipper_name = $vandor->name;
		$fedexlabels_shipper_company = $vandor->company;
		$fedexlabels_shipper_phone = $vandor->phone;
		$fedexlabels_residential = true;
		
	/*	if ( $this->request->post['fedex_residential'] == 'YES' ) {
		
			$fedexlabels_residential = true;
		
		}else{
		
			$fedexlabels_residential = false;
		
		}*/



		//$request['TransactionDetail'] = array('CustomerTransactionId' => '*** Ground Domestic Shipping Request v10 using PHP ***');		
		$request['TransactionDetail'] = array('CustomerTransactionId' => $order_id);
		$request['Version'] = array('ServiceId' => 'ship', 'Major' => '10', 'Intermediate' => '0', 'Minor' => '0');

		$request['RequestedShipment']['ShipTimestamp'] = date('c');
		$request['RequestedShipment']['DropoffType'] = 'REGULAR_PICKUP';
		//$this->log->write( 'SHIPPING METHOD:' . $order_info['shipping_method']);
		$request['RequestedShipment']['ServiceType'] = 'INTERNATIONAL_PRIORITY';
		$request['RequestedShipment']['PackagingType'] = 'YOUR_PACKAGING';
		$request['RequestedShipment']['Shipper'] = array(
														
														'Contact' => array(
															'PersonName' => $fedexlabels_shipper_name ,
															'CompanyName' => $fedexlabels_shipper_company,
															'PhoneNumber' => $fedexlabels_shipper_phone
															),
														
														'Address' => array(
														   'StreetLines' => array($fedexlabels_addr,$fedexlabels_addr2), // Origin details
														  'City' => $fedexlabels_city,
														  'StateOrProvinceCode' => $fedexlabels_state,
														  'PostalCode' => $fedexlabels_zip,
														  'CountryCode' => $fedexlabels_country
															)
														  
														  );
		$request['RequestedShipment']['Recipient'] = array(

														'Contact' => array(
															'PersonName' => $shipAddress->sfirstname.' '.$shipAddress->slastname,
															'CompanyName' => '',
															'PhoneNumber' => $shipAddress->sphone
															),		
														'Address' => array(
															'StreetLines' => array($shipAddress->saddress1.' '.$shipAddress->saddress2),
															'City' => $shipAddress->scity,
															'StateOrProvinceCode' => $shipAddress->sstate,
															'PostalCode' => $shipAddress->szip,
															'CountryCode' => $shipAddress->country_code,
															'Residential' => $fedexlabels_residential)
														);	
		
		/*if( strlen($order_info['fedex_acct'] > 1) ){
			$request['RequestedShipment']['ShippingChargesPayment'] = array('PaymentType' => 'RECIPIENT',
																		'Payor' => array('AccountNumber' => $order_info['fedex_acct'],
																					 'CountryCode' => $fedexlabels_country));
		}else{	*/
		
			$request['RequestedShipment']['ShippingChargesPayment'] = array('PaymentType' => 'SENDER',
																		'Payor' => array('AccountNumber' => $fedexlabels_account,
																					 'CountryCode' => $fedexlabels_country));
		/*}																			 
		*/
		$request['RequestedShipment']['LabelSpecification'] = 	array(
															'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
															'ImageType' => 'PDF',  // valid values DPL, EPL2, PDF, ZPLII and PNG
															'LabelStockType' => 'PAPER_7X4.75');
		
		$request['RequestedShipment']['RateRequestTypes'] = 'ACCOUNT';
		//$request['RequestedShipment']['PackageDetail'] = 'INDIVIDUAL_PACKAGES';
		$request['RequestedShipment']['PackageDetail'] = 'YOUR_PACKAGING';


/*--------------------------------------- New Code for Generating the Airway Bill label -------------------------------- */
		
//$url = 'https://gateway.fedex.com/web-services/';
$url = 'https://gatewaybeta.fedex.com/web-services/';		// URL to Test Environment
//$url = 'https://wsbeta.fedex.com:443/web-services';

define('SHIP_LABEL', 'shipexpresslabel.pdf');  // PNG label file. Change to file-extension .pdf for creating a PDF label (e.g. shiplabel.pdf)
define('SHIP_CODLABEL', 'CODexpressreturnlabel.pdf');  // PNG label file. Change to file-extension .pdf for creating a PDF label (e.g. CODexpressreturnlabel.pdf)

$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v13="http://fedex.com/ws/ship/v13">';
$xml .= '<soapenv:Header/>';
$xml .= '   <soapenv:Body>';
$xml .= '      <v13:ProcessShipmentRequest>';
$xml .= '         <v13:WebAuthenticationDetail>';
$xml .= '            <v13:UserCredential>';
$xml .= '               <v13:Key>'. $fedexlabels_key.'</v13:Key>';
$xml .= '               <v13:Password>'.$fedexlabels_password.'</v13:Password>';
$xml .= '            </v13:UserCredential>';
$xml .= '         </v13:WebAuthenticationDetail>';
$xml .= '         <v13:ClientDetail>';
$xml .= '            <v13:AccountNumber>'.$fedexlabels_account.'</v13:AccountNumber>';
$xml .= '            <v13:MeterNumber>'.$fedexlabels_meter_id.'</v13:MeterNumber>';
$xml .= '         </v13:ClientDetail>';
$xml .= '         <v13:TransactionDetail>';
$xml .= '            <v13:CustomerTransactionId>'.$order_id.'</v13:CustomerTransactionId>';
$xml .= '         </v13:TransactionDetail>';
$xml .= '         <v13:Version>';
$xml .= '            <v13:ServiceId>ship</v13:ServiceId>';
$xml .= '            <v13:Major>13</v13:Major>';
$xml .= '            <v13:Intermediate>0</v13:Intermediate>';
$xml .= '            <v13:Minor>0</v13:Minor>';
$xml .= '         </v13:Version>';





		//getOrderProducts
		//$order_info = $this->model_sale_order->getOrder($order_id);
		//$order_products = $this->model_sale_order->getOrderShippableProducts($order_id);
		
		$seq = 0;
		$total_quantity = 0;
		$packageLineItem =array();	
		
		//$this->load->model('catalog/product');
		
		//Lets get all product details in linear array
		$ship_products = array();
		$product_total = 0;
		$total_weight = 0;
		$tmpxml = '';
		
		//$this->log->write("Shippable Products:".count($order_products));

		
			//$product_info = $this->model_catalog_product->getProduct($order_product['product_id']);

			$product_quantity = 1;
			
			//$product_weight = $this->weight->convert($product_info['weight'], $product_info['weight_class_id'], $this->config->get('config_weight_class_id'));
			//$product_wunits = $this->weight->format($product_info['weight'] * $order_product['quantity'],$this->config->get('config_weight_class_id'));	
			//$sunits = strtoupper(substr($product_wunits,-2)) ;
			//$product_lunits =  $this->length->format($product_info['length'],$this->config->get('config_length_class_id'));		
			//$slength = strtoupper(substr($product_lunits,-2));
			//$weight = $product_weight;
            $amt = 232;

			//$total_weight += $weight;
    $total_weight = 10;
			$product_total	  = $amt;
			$tmpxml .= '               <v13:Commodities>';
			$tmpxml .= '                  <v13:NumberOfPieces>1</v13:NumberOfPieces>';
			$tmpxml .= '                  <v13:Description>SAMPLE NAME</v13:Description>';
			$tmpxml .= '                  <v13:CountryOfManufacture>US</v13:CountryOfManufacture>';
			$tmpxml .= '                  <v13:Weight>';
			$tmpxml .= '                     <v13:Units>LB</v13:Units>';
			$tmpxml .= '                     <v13:Value>10</v13:Value>';
			$tmpxml .= '                  </v13:Weight>';
			$tmpxml .= '                  <v13:Quantity>1</v13:Quantity>';
			$tmpxml .= '                  <v13:QuantityUnits>EA</v13:QuantityUnits>';
			$tmpxml .= '                  <v13:UnitPrice>';
			$tmpxml .= '                     <v13:Currency>USD</v13:Currency>';
			$tmpxml .= '                     <v13:Amount>'.number_format($amt,2,'.','').'</v13:Amount>';
			$tmpxml .= '                  </v13:UnitPrice>';
			$tmpxml .= '                  <v13:CustomsValue>';
			$tmpxml .= '                     <v13:Currency>USD</v13:Currency>';
			$tmpxml .= '                     <v13:Amount>'.number_format($amt,2,'.','').'</v13:Amount>';
			$tmpxml .= '                  </v13:CustomsValue>';
			$tmpxml .= '               </v13:Commodities>';			

			if ($product_quantity > 1 ) 
			{
				//$total_quantity = $total_quantity + $product_quantity;
				for($i=0 ; $i < $product_quantity ; $i++)
				{
					
					$ship_products[] = array(
							'product_id' => 100,
							'weight' => 10,
							'height' => 5,
							'length' =>  5,
							'width' => 5,
							'sunits' => 'LB',
							'slength' => 'IN',
							'order_id' => $order_id,
							'invoice_prefix' => 'INV'
							);
				}			
			} 
			else 
			{
				$total_quantity = 1;
					
				$ship_products[] = array(
						'product_id' => 100,
						'weight' => 10,
						'height' => 5,
						'length' =>  5,
						'width' => 5,
						'sunits' => 'LB',
						'slength' => 'IN',
						'order_id' => $order_id,
						'invoice_prefix' => 'INV'
						);
			
			}
			// End of for




$ship_timestamp = date("c");

$xml .= '         <v13:RequestedShipment>';
$xml .= '            <v13:ShipTimestamp>'.$ship_timestamp.'</v13:ShipTimestamp>';
$xml .= '            <v13:DropoffType>REGULAR_PICKUP</v13:DropoffType>';
$xml .= '            <v13:ServiceType>INTERNATIONAL_PRIORITY</v13:ServiceType>';
$xml .= '            <v13:PackagingType>YOUR_PACKAGING</v13:PackagingType>';
$xml .= '            <v13:TotalWeight>';
$xml .= '       	     <v13:Units>LB</v13:Units>';
$xml .= '            	<v13:Value>'.$total_weight.'</v13:Value>';
$xml .= '            </v13:TotalWeight>';							
$xml .= '            <v13:PreferredCurrency>USD</v13:PreferredCurrency>';
$xml .= '            <v13:Shipper>';
$xml .= '               <v13:Contact>';
$xml .= '                  <v13:PersonName>'.$fedexlabels_shipper_name.'</v13:PersonName>';
$xml .= '                  <v13:CompanyName>'.$fedexlabels_shipper_company.'</v13:CompanyName>';
$xml .= '                  <v13:PhoneNumber>'.$fedexlabels_shipper_phone.'</v13:PhoneNumber>';
$xml .= '                  <v13:EMailAddress>info@atlabme.com</v13:EMailAddress>';	// TO DO
$xml .= '               </v13:Contact>';
$xml .= '               <v13:Address>';
$xml .= '                  <v13:StreetLines>'.$fedexlabels_addr.'</v13:StreetLines>';
$xml .= '                  <v13:StreetLines>'.$fedexlabels_addr2.'</v13:StreetLines>';
$xml .= '                  <v13:City>'.$fedexlabels_city.' City</v13:City>';
$xml .= '                  <v13:StateOrProvinceCode>AR</v13:StateOrProvinceCode>';
$xml .= '                  <v13:PostalCode>72601</v13:PostalCode>';
$xml .= '                  <v13:CountryCode>'.$fedexlabels_country.'</v13:CountryCode>';
$xml .= '               </v13:Address>';
$xml .= '            </v13:Shipper>';

$recipient_addr = '13450 Farmcrest Ct'.' '.'Farmcrest';

$addr_lin1 = substr($recipient_addr,0,35);
$addr_lin2 = substr($recipient_addr,35);

$xml .= '            <v13:Recipient>';
$xml .= '               <v13:Contact>';
$xml .= '                  <v13:PersonName>'.$shipAddress->sfirstname.' '.$shipAddress->slastname.'</v13:PersonName>';
$xml .= '                  <v13:CompanyName></v13:CompanyName>';
$xml .= '                  <v13:PhoneNumber>'.$shipAddress->sphone.'</v13:PhoneNumber>';
$xml .= '                  <v13:EMailAddress>'.$shipAddress->semail.'</v13:EMailAddress>';	// TO DO
$xml .= '               </v13:Contact>';
$xml .= '               <v13:Address>';
$xml .= '                  <v13:StreetLines>'.$shipAddress->saddress1.' '.$shipAddress->saddress2.'</v13:StreetLines>';
//$xml .= '                  <v13:StreetLines1>'.$shipAddress->saddress2.'</v13:StreetLines1>';
$xml .= '                  <v13:City>'.$shipAddress->scity.'</v13:City>';
$xml .= '                  <v13:StateOrProvinceCode>'.$shipAddress->sstate.'</v13:StateOrProvinceCode>';
$xml .= '                  <v13:PostalCode>'.$shipAddress->szip.'</v13:PostalCode>';
$xml .= '                  <v13:CountryCode>'.$shipAddress->country_code.'</v13:CountryCode>';
$xml .= '               </v13:Address>';
$xml .= '            </v13:Recipient>';
$xml .= '            <v13:ShippingChargesPayment>';
$xml .= '               <v13:PaymentType>SENDER</v13:PaymentType>';
$xml .= '               <v13:Payor>';
$xml .= '                  <v13:ResponsibleParty>';
$xml .= '                     <v13:AccountNumber>'.$fedexlabels_account.'</v13:AccountNumber>';
$xml .= '               		<v13:Contact>';
$xml .= '                  			<v13:PersonName>'.$fedexlabels_shipper_name.'</v13:PersonName>';
$xml .= '                  			<v13:CompanyName>'.$fedexlabels_shipper_company.'</v13:CompanyName>';
$xml .= '                  			<v13:PhoneNumber>'.$fedexlabels_shipper_phone.'</v13:PhoneNumber>';
$xml .= '                  			<v13:EMailAddress>webstore@atlabme.com</v13:EMailAddress>';	// TO DO
$xml .= '               		</v13:Contact>';
$xml .= '               		<v13:Address>';
$xml .= '                  			<v13:StreetLines>'.$fedexlabels_addr.'</v13:StreetLines>';
$xml .= '                  			<v13:StreetLines>'.$fedexlabels_addr2.'</v13:StreetLines>';
$xml .= '                  			<v13:City>'.$fedexlabels_city.' City</v13:City>';
$xml .= '                  			<v13:PostalCode>72601</v13:PostalCode>';
$xml .= '                  			<v13:CountryCode>'.$fedexlabels_country.'</v13:CountryCode>';
$xml .= '               		</v13:Address>';
$xml .= '                  </v13:ResponsibleParty>';
$xml .= '               </v13:Payor>';
$xml .= '            </v13:ShippingChargesPayment>';


$xml .= '            <v13:CustomsClearanceDetail>';
//$xml .= '               <v13:DocumentContent>DOCUMENTS_ONLY</v13:DocumentContent>';

$xml .= '            <v13:DutiesPayment>';
$xml .= '            	<v13:PaymentType>SENDER</v13:PaymentType>';
$xml .= '            	<v13:Payor>';
$xml .= '            	<v13:ResponsibleParty>';
$xml .= '            	<v13:AccountNumber>'.$fedexlabels_account.'</v13:AccountNumber>';
$xml .= '               <v13:Contact>';
$xml .= '                  <v13:PersonName>'.$fedexlabels_shipper_name.'</v13:PersonName>';
$xml .= '                  <v13:CompanyName>'.$fedexlabels_shipper_company.'</v13:CompanyName>';
$xml .= '                  <v13:PhoneNumber>'.$fedexlabels_shipper_phone.'</v13:PhoneNumber>';
$xml .= '                  <v13:EMailAddress>info@atlabme.com</v13:EMailAddress>';	// TO DO
$xml .= '               </v13:Contact>';
$xml .= '               <v13:Address>';
$xml .= '                  <v13:StreetLines>'.$fedexlabels_addr.'</v13:StreetLines>';
$xml .= '                  <v13:StreetLines>'.$fedexlabels_addr2.'</v13:StreetLines>';
$xml .= '                  <v13:City>'.$fedexlabels_city.' City</v13:City>';
$xml .= '                  <v13:CountryCode>'.$fedexlabels_country.'</v13:CountryCode>';
$xml .= '               </v13:Address>';
$xml .= '            	</v13:ResponsibleParty>';
$xml .= '            	</v13:Payor>';
$xml .= '            </v13:DutiesPayment>';

$xml .= '               <v13:DocumentContent>NON_DOCUMENTS</v13:DocumentContent>';



		$xml .= '               <v13:CustomsValue>';
		$xml .= '                  <v13:Currency>USD</v13:Currency>';
		$xml .= '                  <v13:Amount>'.$product_total.'</v13:Amount>';
		$xml .= '               </v13:CustomsValue>';

		$xml .= '               <v13:CommercialInvoice>';
		$xml .= '                  <v13:TermsOfSale>DDP</v13:TermsOfSale>';
		$xml .= '               </v13:CommercialInvoice>';

		$xml .= $tmpxml;

		$xml .= '               <v13:ExportDetail>';
		$xml .= '                  <v13:ExportComplianceStatement>30.37(f)</v13:ExportComplianceStatement>';
		$xml .= '               </v13:ExportDetail>';
		$xml .= '            </v13:CustomsClearanceDetail>';

		$xml .= '            <v13:LabelSpecification>';
		$xml .= '               <v13:LabelFormatType>COMMON2D</v13:LabelFormatType>';
		$xml .= '               <v13:ImageType>PDF</v13:ImageType>';
		$xml .= '               <v13:LabelStockType>PAPER_7X4.75</v13:LabelStockType>';
		$xml .= '            </v13:LabelSpecification>';
		$xml .= '            <v13:RateRequestTypes>ACCOUNT</v13:RateRequestTypes>';

		
		//$this->log->write(print_r($ship_products,TRUE));
		$json = array();
		$fed_onebox='YES';
        if ($fed_onebox == 'YES')
        {
			
			//Just generate one label 
			$seq = 1;
			$net_weight = 10;
			/*foreach($ship_products as $ship_product)
			{
					$net_weight = $net_weight + $ship_product['weight'];
			}*/	

			$xml .= '            <v13:PackageCount>1</v13:PackageCount>';
			$xml .= '            <v13:RequestedPackageLineItems>';
			$xml .= '               <v13:SequenceNumber>1</v13:SequenceNumber>';
			$xml .= '               <v13:Weight>';
			$xml .= '                  <v13:Units>LB</v13:Units>';
			$xml .= '                  <v13:Value>'.$total_weight.'</v13:Value>';
			$xml .= '               </v13:Weight>';
			$xml .= '               <v13:Dimensions>';
			$xml .= '                  <v13:Length>5</v13:Length>';
			$xml .= '                  <v13:Width>5</v13:Width>';
			$xml .= '                  <v13:Height>5</v13:Height>';
			$xml .= '                  <v13:Units>IN</v13:Units>';
			$xml .= '               </v13:Dimensions>';
			$xml .= '               <v13:ItemDescription>LEGO Products</v13:ItemDescription>';
			$xml .= '               <v13:CustomerReferences>';
			$xml .= '                  <v13:CustomerReferenceType>CUSTOMER_REFERENCE</v13:CustomerReferenceType>';
			$xml .= '                  <v13:Value>'.$order_id.'</v13:Value>';
			$xml .= '               </v13:CustomerReferences>';
			$xml .= '            </v13:RequestedPackageLineItems>';
			$xml .= '         </v13:RequestedShipment>';
			$xml .= '      </v13:ProcessShipmentRequest>';
			$xml .= '   </soapenv:Body>';
			$xml .= '</soapenv:Envelope>';

			/*==============================================================*/

			$curl = curl_init($url);
			//$this->log->write($xml);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

			$response = curl_exec($curl);
			//$this->log->write($response);
			echo $response;
			curl_close($curl);

			$dom = new DOMDocument('1.0', 'UTF-8');
			$dom->loadXml($response); 

			if ($dom->getElementsByTagName('HighestSeverity')->item(0)->nodeValue == 'FAILURE' || $dom->getElementsByTagName('HighestSeverity')->item(0)->nodeValue == 'ERROR') 
			{
			        $errorNotice = $dom->getElementsByTagName('Notifications')->item(0)->nodeValue;
			        $json['error'] = $errorNotice;
			        //$this->log->write('FEDEX in One Box:: ' . $response);
			}
			else
			{
				$tracking_no =  $dom->getElementsByTagName('TrackingNumber')->item(0)->nodeValue;

				$pdf_label = $order_id . "_" . $tracking_no . ".pdf";
				$shipping_label ="labels/" . $pdf_label;

				$fp = fopen($shipping_label, 'wb');   
				fwrite($fp, base64_decode($dom->getElementsByTagName('Image')->item(0)->nodeValue));
				fclose($fp);

				//Add Label
				//$this->load->model('label/fedexlabels');
				//$tracking_type = $this->getTrackingType('STANDARD_OVERNIGHT');
				$ship_timestamp = $request['RequestedShipment']['ShipTimestamp'];

				$shipmentDetails = $dom->getElementsByTagName('ShipmentRateDetails');
				foreach ($shipmentDetails as $shipmentDetail)
				{
					if($shipmentDetail->getElementsByTagName('RateType')->item(0)->nodeValue == 'PAYOR_ACCOUNT_SHIPMENT')
					{
						$fedex_charge = $shipmentDetail->getElementsByTagName('TotalNetCharge')->item(0)->getElementsByTagName('Amount')->item(0)->nodeValue;
					}
				}

				$data = array(
					'order_id' => $order_id,
					'tracking_no' => $tracking_no,
					'pdf_label' => $pdf_label,
					'net_charge' => $fedex_charge,
					'tracking_type' => 	'INTERNATIONAL_PRIORITY',
					'ship_timestamp' =>  $ship_timestamp 
				);
				var_dump($data);
				//$this->model_label_fedexlabels->addLabel($data);
			}
			
			if (isset($dom->getElementsByTagName('Image')->item(0)->nodeValue)) 
			{
				$json['fedexlabel'] ='Label Generated : <a href="labels/' .  $order_id . "_" . $tracking_no . '.pdf"' . '> ' . $tracking_no . '</a>';
                echo "<a href='labels/".$order_id . "_" . $tracking_no .".pdf' target='_blank'>Download </a>";
			} 		
			
		} 
		else 		// If MPS required
		{
		
			if ( $total_quantity == 1 )			// IF MPS is selected but there is only one product
			{

				$xml .= '            <v13:PackageCount>1</v13:PackageCount>';
				$xml .= '            <v13:RequestedPackageLineItems>';
				$xml .= '               <v13:SequenceNumber>1</v13:SequenceNumber>';
				$xml .= '               <v13:Weight>';
				$xml .= '                  <v13:Units>LB</v13:Units>';
				$xml .= '                  <v13:Value>'.number_format($ship_product['weight'],3).'</v13:Value>';
				$xml .= '               </v13:Weight>';
				$xml .= '               <v13:Dimensions>';
				$xml .= '                  <v13:Length>'.number_format($ship_product['length'],0).'</v13:Length>';
				$xml .= '                  <v13:Width>'.number_format($ship_product['width'],0).'</v13:Width>';
				$xml .= '                  <v13:Height>'.number_format($ship_product['height'],0).'</v13:Height>';
				$xml .= '                  <v13:Units>IN</v13:Units>';
				$xml .= '               </v13:Dimensions>';
				$xml .= '               <v13:ItemDescription>LEGO Products</v13:ItemDescription>';				
				$xml .= '               <v13:CustomerReferences>';
				$xml .= '                  <v13:CustomerReferenceType>CUSTOMER_REFERENCE</v13:CustomerReferenceType>';
				$xml .= '                  <v13:Value>'.$order_id.'</v13:Value>';
				$xml .= '               </v13:CustomerReferences>';
				$xml .= '            </v13:RequestedPackageLineItems>';
				$xml .= '         </v13:RequestedShipment>';
				$xml .= '      </v13:ProcessShipmentRequest>';
				$xml .= '   </soapenv:Body>';
				$xml .= '</soapenv:Envelope>';


				$curl = curl_init($url);
				//$this->log->write($xml);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_TIMEOUT, 30);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

				$response = curl_exec($curl);
				//$this->log->write($response);
				//echo $response;
				curl_close($curl);

				$dom = new DOMDocument('1.0', 'UTF-8');
				$dom->loadXml($response); 

				if ($dom->getElementsByTagName('HighestSeverity')->item(0)->nodeValue == 'FAILURE' || $dom->getElementsByTagName('HighestSeverity')->item(0)->nodeValue == 'ERROR') 
				{
				        $errorNotice = $dom->getElementsByTagName('Notifications')->item(0)->nodeValue;
				        $json['error'] = $errorNotice;
				        //$this->log->write('FEDEX in MPS Qty 1 :: ' . $response);
				}
				else
				{
					$tracking_no =  $dom->getElementsByTagName('TrackingNumber')->item(0)->nodeValue;

					$pdf_label = $order_id . "_" . trim($tracking_no) . ".pdf";
					$shipping_label = DIR_APPLICATION . "labels/" . $pdf_label;

					$fp = fopen($shipping_label, 'wb');   
					fwrite($fp, base64_decode($dom->getElementsByTagName('Image')->item(0)->nodeValue));
					fclose($fp);

					//Add Label
					$this->load->model('label/fedexlabels');
					$tracking_type = $this->getTrackingType('STANDARD_OVERNIGHT');
					$ship_timestamp = $request['RequestedShipment']['ShipTimestamp'];

					$shipmentDetails = $dom->getElementsByTagName('ShipmentRateDetails');
					foreach ($shipmentDetails as $shipmentDetail)
					{
						if($shipmentDetail->getElementsByTagName('RateType')->item(0)->nodeValue == 'PAYOR_ACCOUNT_SHIPMENT')
						{
							$fedex_charge = $shipmentDetail->getElementsByTagName('TotalNetCharge')->item(0)->getElementsByTagName('Amount')->item(0)->nodeValue;
						}
					}

					$data = array(
						'order_id' => $order_id,
						'tracking_no' => $tracking_no,
						'pdf_label' => $pdf_label,
						'net_charge' => $fedex_charge,
						'tracking_type' => 	$tracking_type,
						'ship_timestamp' =>  $ship_timestamp 
					);
					
					$this->model_label_fedexlabels->addLabel($data);
				}
				
				if (isset($dom->getElementsByTagName('Image')->item(0)->nodeValue)) 
				{
					$json['fedexlabel'] ='Label Generated : <a href="/labels/' .  $order_id . "_" . $tracking_no . '.pdf"' . '> ' . $tracking_no . '</a>';
				} 

			}
			else 
			{
				
					$first_item = true;
					$seq = 0;
					$MasterTrackingId  = 0;

					foreach($ship_products as $ship_product)
					{
						$seq = $seq + 1;

						$mpsxml = '';
						
						if ($first_item != true) {
							$mpsxml .= '            <v13:MasterTrackingId>';
							$mpsxml .= '                   <v13:TrackingNumber>'.$MasterTrackingId.'</v13:TrackingNumber>';
							$mpsxml .= '            </v13:MasterTrackingId>';
						}

						$mpsxml .= '            <v13:PackageCount>'.$total_quantity.'</v13:PackageCount>';
						$mpsxml .= '            <v13:RequestedPackageLineItems>';
						$mpsxml .= '               <v13:SequenceNumber>'.$seq.'</v13:SequenceNumber>';
						$mpsxml .= '               <v13:Weight>';
						$mpsxml .= '                  <v13:Units>LB</v13:Units>';
						$mpsxml .= '                  <v13:Value>'.number_format($ship_product['weight'],3).'</v13:Value>';
						$mpsxml .= '               </v13:Weight>';
						$mpsxml .= '               <v13:Dimensions>';
						$mpsxml .= '                  <v13:Length>'.number_format($ship_product['length'],0).'</v13:Length>';
						$mpsxml .= '                  <v13:Width>'.number_format($ship_product['width'],0).'</v13:Width>';
						$mpsxml .= '                  <v13:Height>'.number_format($ship_product['height'],0).'</v13:Height>';
						$mpsxml .= '                  <v13:Units>IN</v13:Units>';
						$mpsxml .= '               </v13:Dimensions>';
						$mpsxml .= '               <v13:ItemDescription>LEGO Products</v13:ItemDescription>';						
						$mpsxml .= '               <v13:CustomerReferences>';
						$mpsxml .= '                  <v13:CustomerReferenceType>CUSTOMER_REFERENCE</v13:CustomerReferenceType>';
						$mpsxml .= '                  <v13:Value>'.$order_id.'</v13:Value>';
						$mpsxml .= '               </v13:CustomerReferences>';
						$mpsxml .= '            </v13:RequestedPackageLineItems>';
						$mpsxml .= '         </v13:RequestedShipment>';
						$mpsxml .= '      </v13:ProcessShipmentRequest>';
						$mpsxml .= '   </soapenv:Body>';
						$mpsxml .= '</soapenv:Envelope>';


						if 	( $first_item == true )	
						{
							//$this->log->write('First item');
							$first_item = false;

							$requestxml = $xml.$mpsxml;

							$curl = curl_init($url);
							
							//$this->log->write("MPS FirstProduct:".$requestxml);

							curl_setopt($curl, CURLOPT_POST, true);
							curl_setopt($curl, CURLOPT_POSTFIELDS, $requestxml);
							curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($curl, CURLOPT_HEADER, false);
							curl_setopt($curl, CURLOPT_TIMEOUT, 30);
							curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

							$response = curl_exec($curl);
							//$this->log->write($response);
							//echo $response;
							curl_close($curl);

							$dom = new DOMDocument('1.0', 'UTF-8');
							$dom->loadXml($response); 

							if ($dom->getElementsByTagName('HighestSeverity')->item(0)->nodeValue == 'FAILURE' || $dom->getElementsByTagName('HighestSeverity')->item(0)->nodeValue == 'ERROR') 
							{
							        $errorNotice = $dom->getElementsByTagName('Notifications')->item(0)->nodeValue;
							        $json['error'] = $errorNotice;
							        $this->log->write('ERROR FEDEX MPS Multi First:: ' . $response);
							}
							else
							{
								$MasterTrackingId =  trim($dom->getElementsByTagName('MasterTrackingId')->item(0)->getElementsByTagName('TrackingNumber')->item(0)->nodeValue);
								$tracking_no =  $dom->getElementsByTagName('TrackingIds')->item(0)->getElementsByTagName('TrackingNumber')->item(0)->nodeValue;

								$pdf_label = $order_id . "_" . trim($tracking_no) . ".pdf";
								$shipping_label = DIR_APPLICATION . "labels/" . $pdf_label;

								$fp = fopen($shipping_label, 'wb');   
								fwrite($fp, base64_decode($dom->getElementsByTagName('Image')->item(0)->nodeValue));
								fclose($fp);

								//Add Label
								$this->load->model('label/fedexlabels');
								$tracking_type = $this->getTrackingType('STANDARD_OVERNIGHT');
								$ship_timestamp = $request['RequestedShipment']['ShipTimestamp'];

								/*$shipmentDetails = $dom->getElementsByTagName('ShipmentRateDetails');
								foreach ($shipmentDetails as $shipmentDetail)
								{
									if($shipmentDetail->getElementsByTagName('RateType')->item(0)->nodeValue == 'PAYOR_ACCOUNT_SHIPMENT')
									{
										$fedex_charge = $shipmentDetail->getElementsByTagName('TotalNetCharge')->item(0)->getElementsByTagName('Amount')->item(0)->nodeValue;
									}
								}*/
								$fedex_charge =0;
								$data = array(
									'order_id' => $order_id,
									'tracking_no' => $tracking_no,
									'pdf_label' => $pdf_label,
									'net_charge' => $fedex_charge,
									'tracking_type' => 	$tracking_type,
									'ship_timestamp' =>  $ship_timestamp 
								);
								
								$this->model_label_fedexlabels->addLabel($data);
							}

						}
						else
						{
							//$this->log->write('Not First item');
							$this->log->write("MPS Products:".$requestxml);

							$requestxml = $xml.$mpsxml;

							$curl = curl_init($url);
							
							curl_setopt($curl, CURLOPT_POST, true);
							curl_setopt($curl, CURLOPT_POSTFIELDS, $requestxml);
							curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($curl, CURLOPT_HEADER, false);
							curl_setopt($curl, CURLOPT_TIMEOUT, 30);
							curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

							$response = curl_exec($curl);
							$this->log->write($response);
							//echo $response;
							curl_close($curl);

							$dom = new DOMDocument('1.0', 'UTF-8');
							$dom->loadXml($response); 

							if ($dom->getElementsByTagName('HighestSeverity')->item(0)->nodeValue == 'FAILURE' || $dom->getElementsByTagName('HighestSeverity')->item(0)->nodeValue == 'ERROR') 
							{
							        $errorNotice = $dom->getElementsByTagName('Notifications')->item(0)->nodeValue;
							        $json['error'] = $errorNotice;
							        $this->log->write('ERROR FEDEX Multi Next:: ' . $response);
							}
							else
							{
								$tracking_no =  $dom->getElementsByTagName('TrackingIds')->item(0)->getElementsByTagName('TrackingNumber')->item(0)->nodeValue;

								$pdf_label = $order_id . "_" . trim($tracking_no) . ".pdf";
								$shipping_label = DIR_APPLICATION . "labels/" . $pdf_label;

								$fp = fopen($shipping_label, 'wb');   
								fwrite($fp, base64_decode($dom->getElementsByTagName('Image')->item(0)->nodeValue));
								fclose($fp);

								//Add Label
								$this->load->model('label/fedexlabels');
								$tracking_type = $this->getTrackingType(STANDARD_OVERNIGHT);
								$ship_timestamp = $request['RequestedShipment']['ShipTimestamp'];
								if($seq == $total_quantity)
								{
									$shipmentDetails = $dom->getElementsByTagName('ShipmentRateDetails');
									foreach ($shipmentDetails as $shipmentDetail)
									{
										if($shipmentDetail->getElementsByTagName('RateType')->item(0)->nodeValue == 'PAYOR_ACCOUNT_SHIPMENT')
										{
											$fedex_charge = $shipmentDetail->getElementsByTagName('TotalNetCharge')->item(0)->getElementsByTagName('Amount')->item(0)->nodeValue;
										}
									}
								}
								else
									$fedex_charge = 0;

								$data = array(
									'order_id' => $order_id,
									'tracking_no' => $tracking_no,
									'pdf_label' => $pdf_label,
									'net_charge' => $fedex_charge,
									'tracking_type' => 	$tracking_type,
									'ship_timestamp' =>  $ship_timestamp 
								);
								
								$this->model_label_fedexlabels->addLabel($data);
							}

						}	//  End of not the first product	
					
					}	// End of foreach loop
					
					$json['fedexlabel'] = 'Multiple labels generated.';
			}	// End of if total_quantity > 1

		} //End All in one box
		//$this->response->setOutput(json_encode($json));
   // echo json_encode($json);

?>