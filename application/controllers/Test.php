<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
use FedEx\RateService,FedEx\RateService\ComplexType,FedEx\RateService\SimpleType;
class Test extends CI_Controller
{
    

    function __construct()
    {
        parent::__construct();
         $this->load->helper('text');
        $this->load->database();
        $this->load->library('image_lib');
        $this->load->helper('captcha');
        $this->load->library('paypal');
        $this->load->model('myapp_model');
        
        /*cache control*/
		//ini_set("user_agent","My-Great-Marketplace-App");
		$cache_time	 =  $this->db->get_where('general_settings',array('type' => 'cache_time'))->row()->value;
		if(!$this->input->is_ajax_request()){
			$this->output->set_header('HTTP/1.0 200 OK');
			$this->output->set_header('HTTP/1.1 200 OK');
			$this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
			$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
			$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
			$this->output->set_header('Pragma: no-cache');
            if($this->router->fetch_method() == 'index' || 
                $this->router->fetch_method() == 'featured_item' || 
                    $this->router->fetch_method() == 'product_view' || 
                        $this->router->fetch_method() == 'blog' || 
                            $this->router->fetch_method() == 'blog_view' || 
                                $this->router->fetch_method() == 'vendor' || 
                                    $this->router->fetch_method() == 'category'){
                $this->output->cache($cache_time);
            }
		}
		$this->config->cache_query();
        $this->crud_model->ip_data();
    }
    
    
   
    
    /* FUNCTION: Loads Homepage*/
    public function index()
    {
        $page_data['min'] = $this->get_range_lvl('product_id !=', '', "min");
        $page_data['max'] = $this->get_range_lvl('product_id !=', '', "max");
        $this->db->order_by('product_id', 'desc');
        $page_data['featured_data'] = $this->db->get_where('product', array(
            'featured' => "ok",
            'status' => 'ok'
        ))->result_array();
        $page_data['page_name']     = "home";
        $page_data['page_title']    = translate('home');
        $this->load->view('front/test', $page_data);
    }
    
    
    public function remail()
    {
        // $config = Array(
        //                 'protocol' => 'smtp',
        //                 'smtp_host' => 'smtp.elasticemail.com',
        //                 'smtp_port' => '2525',
        //                 'smtp_user' => 'admin@vinshopify.com',
        //                 'smtp_pass' => '1345355B13192050B54A78FE6A0C1213749D',
        //                 'mailtype'  => 'html', 
        //                 'charset'   => 'iso-8859-1'
        //             );
        // $this->load->library('email', $config);
        // $this->email->to('dsajith@mailinator.com');
        // $this->email->subject('Test email from CI and Gmail');
        // $this->email->message('This is a test.');
        // echo $this->email->send();
       
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'developer.estrrado@gmail.com',
            'smtp_pass' => 'Dev@Est#Aries2020',
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1'
        );
        $this->load->library('email', $config);
        //$this->email->from($this->config->item('smtp_user'));
        $this->email->to('ajith@estrrado.com');
        $this->email->subject('Test email from CI and Gmail');
        $this->email->message('This is a test.');
        $this->email->send();
        //echo $this->config->item('smtp_user');
        
        
    }
    
 public function fedexCalculate($adrs,$city,$country,$state,$zip)
  {
    $from = array(array('zipcode'=>38115,'state'=>'TN','address_l1'=>'10 Fed Ex Pkwy','city'=>'Memphis','country'=>'US'));
    $to=array('to_adrs'=>"$adrs",'to_city'=>"$city",'to_country'=>"$country",'to_state'=>"$state",'to_zip'=>"$zip");
    $shopid = array(1,2);
    foreach ($from as $key => $value) {
        $resarry[] = $this->test_composer($from[$key],$to);
        //var_dump($resarry);
    }
      //echo $adrs."dfdfd";
  }  

public function test_composer($from,$to)
{
   
   
  
    
    
/*           require_once 'credentials.php';
require_once 'bootstrap.php';*/
    $to_zip     = $to['to_zip'];
    $to_state   = $to['to_state'];
    $to_country = $to['to_country'];
    $to_city    = $to['to_city'];
    $to_adrs    = $to['to_adrs'];

$zip_code = $from['zipcode'];
$state_code = $from['state'];
$address_l1 = $from['address_l1'];
$city = $from['city'];
$country = $from['country'];
//$sam=38115;
//$sam_city="Memphis";
//echo $state_code;
define('FEDEX_ACCOUNT_NUMBER', '510087461');
define('FEDEX_METER_NUMBER', '100300801');
define('FEDEX_KEY', 'gaiwH2Bam3HGqvGC');
define('FEDEX_PASSWORD', 'toNZb8dT6PCv8wJ4hZwUqk2fa');



$rateRequest = new ComplexType\RateRequest();
//echo "Welcome111";
        
//WebAuthenticationDetail
$userCredential = new ComplexType\WebAuthenticationCredential();
$userCredential
    ->setKey(FEDEX_KEY)
    ->setPassword(FEDEX_PASSWORD);

$webAuthenticationDetail = new ComplexType\WebAuthenticationDetail();
$webAuthenticationDetail->setUserCredential($userCredential);

$rateRequest->setWebAuthenticationDetail($webAuthenticationDetail);

//ClientDetail
$clientDetail = new ComplexType\ClientDetail();
$clientDetail
    ->setAccountNumber(FEDEX_ACCOUNT_NUMBER)
    ->setMeterNumber(FEDEX_METER_NUMBER);

$rateRequest->setClientDetail($clientDetail);

//TransactionDetail
$transactionDetail = new ComplexType\TransactionDetail();
$transactionDetail->setCustomerTransactionId(' *** Rate Available Services Request v10 using PHP ***');

$rateRequest->setTransactionDetail($transactionDetail);


//Version
$version = new ComplexType\VersionId();
$version
    ->setServiceId('crs')
    ->setMajor(10)
    ->setIntermediate(0)
    ->setMinor(0);

$rateRequest->setVersion($version);

//ReturnTransitAndCommit
$rateRequest->setReturnTransitAndCommit(true);

//RequestedShipment
$requestedShipment = new ComplexType\RequestedShipment();

//RequestedShipment/DropoffType
$requestedShipment->setDropoffType(SimpleType\DropoffType::_REGULAR_PICKUP);

//RequestedShipment/Shiptimestamp
$requestedShipment->setShipTimestamp(date('c'));

//RequestedShipment/Shipper
$shipperAddress = new ComplexType\Address();
$shipperAddress
    ->setStreetLines(array("$address_l1"))
    ->setCity("$city")
    ->setStateOrProvinceCode("$state_code")
    ->setPostalCode($zip_code)
    ->setCountryCode("$country");

$shipper = new ComplexType\Party();
$shipper->setAddress($shipperAddress);

$requestedShipment->setShipper($shipper);

//RequestedShipment/Recipient
$recipientAddress = new ComplexType\Address();
$recipientAddress
    ->setStreetLines(array("$to_adrs"))
    ->setCity($to_city)
    ->setStateOrProvinceCode("$to_state")
    ->setPostalCode($to_zip)
    ->setCountryCode("$to_country");

$recipient = new ComplexType\Party();
$recipient->setAddress($recipientAddress);

$requestedShipment->setRecipient($recipient);

//RequestedShipment/ShippingChargesPayment

$shippingChargesPayment = new ComplexType\Payment();
$shippingChargesPayment->setPaymentType(new SimpleType\PaymentType(SimpleType\PaymentType::_SENDER));

$payor = new ComplexType\Payor();
$payor->setAccountNumber(FEDEX_ACCOUNT_NUMBER);
$payor->setCountryCode('US');

$shippingChargesPayment->setPayor($payor);

$requestedShipment->setShippingChargesPayment($shippingChargesPayment);

//RequestedShipment\RateRequestTypes
$requestedShipment->setRateRequestTypes(array(
    new SimpleType\RateRequestType(SimpleType\RateRequestType::_ACCOUNT),
    new SimpleType\RateRequestType(SimpleType\RateRequestType::_LIST)
));

//RequestedShipment\PackageCount
$requestedShipment->setPackageCount(1);

//RequestedShipment\RequestedPackageLineItems
$lineItems = array();

$item1Weight = new ComplexType\Weight();
$item1Weight
    ->setUnits(new SimpleType\WeightUnits(SimpleType\WeightUnits::_LB))
    ->setValue(2.0);

$item1Dimensions = new ComplexType\Dimensions();
$item1Dimensions
    ->setLength(0)
    ->setWidth(0)
    ->setHeight(0)
    ->setUnits(new SimpleType\LinearUnits(SimpleType\LinearUnits::_IN));

$item1 = new ComplexType\RequestedPackageLineItem();
$item1->setWeight($item1Weight);
$item1->setDimensions($item1Dimensions);
$item1->setGroupPackageCount(1);

/*$item2Weight = new ComplexType\Weight();
$item2Weight
    ->setUnits(new SimpleType\WeightUnits(SimpleType\WeightUnits::_LB))
    ->setValue(5.0);

$item2Dimensions = new ComplexType\Dimensions();
$item2Dimensions
    ->setLength(5)
    ->setWidth(5)
    ->setHeight(3)
    ->setUnits(new SimpleType\LinearUnits(SimpleType\LinearUnits::_IN));

$item2 = new ComplexType\RequestedPackageLineItem();
$item2->setWeight($item2Weight);
$item2->setDimensions($item2Dimensions);
$item2->setGroupPackageCount(1);*/

$lineItems[] = $item1;
/*$lineItems[] = $item2;*/
$requestedShipment->setRequestedPackageLineItems($lineItems);

$rateRequest->setRequestedShipment($requestedShipment);

//print_r($rateRequest->toArray());

//echo "<hr />";

$validateShipmentRequest = new RateService\Request();



//$request->getSoapClient()->__setLocation('https://ws.fedex.com:443/web-services/rate');


$rateservice = $validateShipmentRequest->getGetRatesReply($rateRequest);
//print_r($rateservice->RateReplyDetails);
$shippingType = $rateservice->RateReplyDetails;

foreach($shippingType as $shipingmethod){

    //print_r($shipingmethod);
    //echo "</br>";

    //echo $shipingmethod->ServiceType;

    //echo "</br>";
    //echo "Details";
    //echo "</br>";

        $netcharge = $shipingmethod->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetChargeWithDutiesAndTaxes->Amount;
        $surcharge = $shipingmethod->RatedShipmentDetails[0]->ShipmentRateDetail->Surcharges->Amount->Amount;

        $total = $surcharge+$netcharge;
        //$total = currency() . $total;
        $total = $this->currency_convert($total);
        //echo "price = ".$total;

    /*
    foreach($shipingmethod->RatedShipmentDetails as $shipingsingle){
        echo $shipingsingle->ShipmentRateDetail->RateType;
        
        //print_r($shipingsingle->ShipmentRateDetail);

        $netcharge = $shipingsingle->ShipmentRateDetail->TotalNetChargeWithDutiesAndTaxes->Amount;
        $surcharge = $shipingsingle->ShipmentRateDetail->Surcharges->Amount->Amount;

        $total = $surcharge+$netcharge;
        echo "price = ".$total;
        echo "</br>";
        echo "</br>";
    }
    */

    $shipData[] = array(
        'method'=>$shipingmethod->ServiceType,
        'price'=>$total
    );

}

echo json_encode($shipData);
//print_r($validateShipmentRequest->getSoapClient()->__getLastRequest());
//print_r($validateShipmentRequest->getSoapClient()->__getLastRequestHeaders());

//print_r($validateShipmentRequest->getSoapClient()->__getFunctions()); 
         
         
         
    }
function currency_convert($val)
{
   
    $currency_ex =  $this->db->get_where('business_settings',array('type' => 'exchange'))->row()->value;
    $aed    = $val * $currency_ex;
    $aed    = round($aed, 2);
    //$aed    = currency() . $aed;
    return $aed;
}



    
    
    function vendor($vendor_id){
		$vendor_system	 =  $this->db->get_where('general_settings',array('type' => 'vendor_system'))->row()->value;
        if($vendor_system	 == 'ok' && 
			$this->db->get_where('vendor',array('vendor_id'=>$vendor_id))->row()->status == 'approved'){
            $min = $this->get_range_lvl('added_by', '{"type":"vendor","id":"'.$vendor_id.'"}', "min");
            $max = $this->get_range_lvl('added_by', '{"type":"vendor","id":"'.$vendor_id.'"}', "max");
            $this->db->order_by('product_id', 'desc');
            $page_data['featured_data'] = $this->db->get_where('product', array(
                'featured' => "ok",
                'status' => 'ok',
                'added_by' => '{"type":"vendor","id":"'.$vendor_id.'"}'
            ))->result_array();
            $page_data['range']             = $min . ';' . $max;
            $page_data['all_category']      = $this->db->get('category')->result_array();
            $page_data['all_sub_category']  = $this->db->get('sub_category')->result_array();
            $page_data['page_name']         = 'vendor_home';
            $page_data['vendor']            = $vendor_id;
            $page_data['page_title']        = $this->db->get_where('vendor',array('vendor_id'=>$vendor_id))->row()->display_name;
            $this->load->view('front/index', $page_data); 
        } else {
             redirect(base_url(), 'refresh');
        }
    }

    /* FUNCTION: Loads Customer Profile Page */
    function profile()
    {
        if ($this->session->userdata('user_login') != "yes") {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']    = "profile";
        $page_data['page_title']   = translate('my_profile');
        $page_data['all_products'] = $this->db->get_where('user', array(
            'user_id' => $this->session->userdata('user_id')
        ))->result_array();
        $page_data['user_info']    = $this->db->get_where('user', array(
            'user_id' => $this->session->userdata('user_id')
        ))->result_array();
        
        $this->load->view('front/index', $page_data);
    }

    /* FUNCTION: Loads Customer Download */
    function download($id)
    {
        if ($this->session->userdata('user_login') != "yes") {
            redirect(base_url(), 'refresh');
        }
        $this->crud_model->download_product($id);
    }
	
    /* FUNCTION: Loads Customer Download Permission */
    function can_download($id)
    {
        if ($this->session->userdata('user_login') != "yes") {
            redirect(base_url(), 'refresh');
        }
        if($this->crud_model->can_download($id)){
            echo 'ok';
        } else {
            echo 'not';
        }
    }
    
    /* FUNCTION: Loads Category filter page */
  function category($para1 = "", $para2 = "", $min = "", $max = "", $text ='')
    {
        
        if ($para2 == "") {
            $page_data['all_products'] = $this->db->get_where('product', array(
                'category' => $para1
            ))->result_array();
        } else if ($para2 != "") {
            $page_data['all_products'] = $this->db->get_where('product', array(
                'sub_category' => $para2
            ))->result_array();
        }
        $page_data['range']            = $min . ';' . $max;
        $page_data['page_name']        = "product_list";
        $page_data['page_title']       = translate('products');
        $page_data['all_category']     = $this->db->get('category')->result_array();
        $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
        $page_data['cur_sub_category'] = $para2;
        $page_data['cur_category']     = $para1;
        $page_data['text']             = $text;
        $page_data['category_data']    = $this->db->get_where('category', array(
            'category_id' => $para1
        ))->result_array();
        $this->load->view('front/index', $page_data);
    }
    
    /* FUNCTION: Search Products */
    function home_search($param = '')
    {
        $category = $this->input->post('category');
        $this->session->set_userdata('searched_cat', $category);
        if ($param !== 'top') {
            $sub_category = $this->input->post('sub_category');
            $range        = $this->input->post('range');
            $p            = explode(';', $range);
            redirect(base_url() . 'index.php/home/category/' . $category . '/' . $sub_category . '/' . $p[0] . '/' . $p[1], 'refresh');
        } else if ($param == 'top') {
            redirect(base_url() . 'index.php/home/category/' . $category, 'refresh');
        }
    }

    function text_search(){
        $type = $this->input->post('type');
        $search = $this->input->post('query');
        $this->crud_model->search_terms($search);
        if($type == 'vendor'){
            redirect(base_url() . 'index.php/home/store_locator/'.$search, 'refresh');
        } else if($type == 'product'){
            redirect(base_url() . 'index.php/home/category/0/0/0/0/'.$search, 'refresh');
        }
    }
    
   function main_search(){
        $type = $this->input->post('category');
        $search = $this->input->post('query');
        $search = str_replace(',', '%2C', $search);
        //$search = urlencode(string $search);
        $this->crud_model->search_terms($search);
        if($type=='brand'){
            $brand_id =  $this->db->get_where('brand',array('name' => "$search"))->row()->brand_id;
            redirect(base_url() . 'index.php/home/brand/'.$brand_id, 'refresh');
        }
        else{
            if($type == '0'){
                redirect(base_url() . 'index.php/home/category/0/0/0/0/'.$search, 'refresh');
            } else if($type > 0){
                redirect(base_url() . 'index.php/home/category/'.$type.'/0/0/0/'.$search, 'refresh');
            }
        }
    }
    /*Function Advanced Search redirect*/
     function adv_search(){ 
        $type = $this->input->post('category');
        $search = $this->input->post('query');
        $search = str_replace(',', '%2C', $search);
        if($type=='brand'){
            $brand_id =  $this->db->get_where('brand',array('name' => "$search"))->row()->brand_id;
            redirect(base_url() . 'index.php/home/brand/'.$brand_id, 'refresh');
        }
        else{    
            if($type == '0'){
                redirect(base_url() . 'index.php/home/advance_search/0/0/0/0/'.$search, 'refresh');
            } else if($type > 0){
                redirect(base_url() . 'index.php/home/advance_search/'.$type.'/0/0/0/'.$search, 'refresh');
            }
        }
    }
    /*Function Advanced Search redirect*/




/*Quote_request*/
    
     function quote($para1 = "")

    {

        //$this->load->library('recaptcha');

        $this->load->library('form_validation');

        if ($para1 == 'send1') {

            $safe = 'yes';

            $char = '';

            foreach($_POST as $row){

                if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row,$match))

                {

                    $safe = 'no';

                    $char = $match[0];

                }

            }



            $this->form_validation->set_rules('name', 'Name', 'required');
           
            $this->form_validation->set_rules('subject', 'Subject', 'required');

            $this->form_validation->set_rules('message', 'Message', 'required');

            $this->form_validation->set_rules('email', 'Email', 'required');



            if ($this->form_validation->run() == FALSE)

            {

                echo validation_errors();

            }

            else

            {

                if($safe == 'yes'){

                   // $this->recaptcha->recaptcha_check_answer();
                

                        $data['name']      = $this->input->post('name',true);

                        $data['subject']   = $this->input->post('subject');

                        $data['email']     = $this->input->post('email');

                        //$data['organization']     = $this->input->post('org');
                        $data['product_id']  = $this->input->post('p_id');

                        $data['mobile']     = $this->input->post('conv_time');

                        $data['message']   = $this->security->xss_clean(($this->input->post('message')));

                        $data['view']      = 'no';

                        $data['timestamp'] = time();

                        
            if (count($a = $this->db->get_where('quote_message', array('email' => $data['email'],'product_id' => $data['product_id'], 'view'=> "no" ))->result_array()) <= 0) 
            { 
                      
                        $this->db->insert('quote_message', $data); echo 'sent';
                        /*email to multiple mails*/
                     //$this->email_model->account_opening('vendor', 'anuraji@estrrado.com', 'password');
                      $users       =  $this->db->get('quote_mail')->result_array();


                        $email_msg=$data['message'];
                        $email_sub=$data['subject'] ; 
                      // $this->email_model->do_email($email_msg, $email_sub, $email_to, $from);
                     
                       foreach ($users as $key => $user) {
                            if ($user !== '') {
                                $mail=$user['quote_email'];
                               // $this->email_model->do_email($email_msg, $email_sub, $mail, $from);
                                $mob=$data['mobile'];
                                $fr_nm= $data['name'];
                                $fr_email=$data['email'];
                                $this->crud_model->quote_template($email_sub,$mail,$email_msg,$mob,$fr_nm,$fr_email);
                              //quote_template($sub = '', $email = '', $msg = '',$phone='',$from_name='')  
                            }
                            else{
                                $this->email_model->do_mail('pani pali', 'error', 'anuraji@estrrado.com', $from);
                            }
                        }
            }else{ echo "You already quote this product..!"; }
           
                      /*end email to multiple*/


                        

                     
                } else {

                    echo 'Disallowed charecter : " '.$char.' " in the POST';

                }

            }

        } else {

            $page_data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();

            $page_data['page_name']      = "Request a Quote";

            $page_data['page_title']     = translate('request a Quote');

            $this->load->view('front/index', $page_data);

        }

    }

    /*/Quote_request*/



    
    /* FUNCTION: Check if user logged in */
    function is_logged()
    {
        if ($this->session->userdata('user_login') == 'yes') {
            echo 'yah!good';
        } else {
            echo 'nope!bad';
        }
    }
    
    /* FUNCTION: Loads Product List */
    function listed($para1 = "", $para2 = "", $para3 = "")
    { 
     //   echo '<pre>'; print_r($this->input->post()); echo '</pre>'; die;
        $this->load->library('Ajax_pagination');
        if ($para1 == "click") {
            if ($this->input->post('range')) {
                $range = $this->input->post('range');
            }
            if ($this->input->post('text')) {
                $text = $this->input->post('text');
            }
            $category     = $this->input->post('category');
            $category     = explode(',', $category);
            $sub_category = $this->input->post('sub_category');
            $sub_category = explode(',', $sub_category);
            $featured     = $this->input->post('featured');
            $fltr_flg     = $this->input->post('fltr_txt');
            $name         = '';
            $cat          = '';
            $setter       = '';
            $vendors      = array();
            $approved_users = $this->db->get_where('vendor',array('status'=>'approved'))->result_array();
            foreach ($approved_users as $row) {
                $vendors[] = $row['vendor_id'];

            }
            
            $brand_llst=array();
             $brands_list = $this->db->get('brand')->result_array();
            foreach ($brands_list as $row1) {
                $brand_llst[] = $row1['brand_id'];
              
            }
            
            if(isset($text)){
                if($text !== ''){
                    $this->db->like('title', $text, 'both');
                //    $this->db->or_like('description', $text, 'both');
               //     $this->db->or_like('tag', $text, 'both');
                }
            }

            if($vendor = $this->input->post('vendor')){
               // var_dump($vendor);
                if(in_array($vendor, $vendors)){
                    $this->db->where('added_by', '{"type":"vendor","id":"'.$vendor.'"}');
                } else {
                    $this->db->where('product_id','');
                }                
            }

if($vendor3 = $this->input->post('brnd_txt')){
   // var_dump('vendor3');
                if(in_array($vendor3, $brand_llst)){
                    $this->db->where('brand', $vendor3);
                } else {
                    $this->db->where('brand','');
                }                
            }



            $this->db->where('status', 'ok');
            if ($featured == 'ok') {
                $this->db->where('featured', 'ok');
            }
            
            if (isset($range)) {
                $p = explode(';', $range);
                $this->db->where('sale_price >=', $p[0]);
                $this->db->where('sale_price <=', $p[1]);
            }
            
            $query = array();
            if (count($sub_category) > 0) {
                $i = 0;
                foreach ($sub_category as $row) {
                    $i++;
                    if ($row !== "") {
                        if ($row !== "0") {
                            $query[] = $row;
                            $setter  = 'get';
                        } else {
                            $this->db->where('sub_category !=', '0');
                        }
                    }
                }
                if ($setter == 'get') {
                    $this->db->where_in('sub_category', $query);
                }
            }
            
            if (count($category) > 0 && $setter !== 'get') {
                $i = 0;
                foreach ($category as $row) {
                    $i++;
                    if ($row !== "") {
                        if ($row !== "0") {
                            if ($i == 1) {
                                $this->db->where('category', $row);
                            } else {
                                $this->db->or_where('category', $row);
                            }
                        } else {
                            $this->db->where('category !=', '0');
                        }
                    }
                }
            }
            $this->db->order_by('current_stock', 'desc');
            
            // pagination
            $config['total_rows'] = $this->db->count_all_results('product');
            $config['base_url']   = base_url() . 'index.php?home/listed/';
            if ($featured !== 'ok') {
                $config['per_page'] = 9;
            } else if ($featured == 'ok') {
                $config['per_page'] = 9;
            }
            $config['uri_segment']  = 5;
            $config['cur_page_giv'] = $para2;
            
            $function                  = "filter('click','none','none','0')";
            $config['first_link']      = '&laquo;';
            $config['first_tag_open']  = '<a rel="grow" class="btn-u btn-u-sea grow" onClick="' . $function . '">';
            $config['first_tag_close'] = '</a>';
            
            $rr                       = ($config['total_rows'] - 1) / $config['per_page'];
            $last_start               = floor($rr) * $config['per_page'];
            $function                 = "filter('click','none','none','" . $last_start . "')";
            $config['last_link']      = '&raquo;';
            $config['last_tag_open']  = '<a rel="grow" class="btn-u btn-u-sea grow" onClick="' . $function . '">';
            $config['last_tag_close'] = '</a>';
            
            $function                 = "filter('click','none','none','" . ($para2 - $config['per_page']) . "')";
            $config['prev_tag_open']  = '<a rel="grow" class="btn-u btn-u-sea grow" onClick="' . $function . '">';
            $config['prev_tag_close'] = '</a>';
            
            $function                 = "filter('click','none','none','" . ($para2 + $config['per_page']) . "')";
            $config['next_link']      = '&rsaquo;';
            $config['next_tag_open']  = '<a rel="grow" class="btn-u btn-u-sea grow" onClick="' . $function . '">';
            $config['next_tag_close'] = '</a>';
            
            $config['full_tag_open']  = '<ul class="pagination pagination-v2">';
            $config['full_tag_close'] = '</ul>';
            
            $config['cur_tag_open']  = '<a rel="grow" class="btn-u btn-u-red grow" class="active">';
            $config['cur_tag_close'] = '</a>';
            
            $function                = "filter('click','none','none',((this.innerHTML-1)*" . $config['per_page'] . "))";
            $config['num_tag_open']  = '<a rel="grow" class="btn-u btn-u-sea grow" onClick="' . $function . '">';
            $config['num_tag_close'] = '</a>';
            $this->ajax_pagination->initialize($config);
            
            
            $this->db->where('status', 'ok');
            if ($featured == 'ok') {
                $this->db->where('featured', 'ok');
                $grid_items_per_row = 3;
                $name               = 'Featured';
            } else {
                $grid_items_per_row = 3;
            }
            $this->db->order_by('current_stock', 'desc');
            if(isset($text)){
                if($text !== ''){
                    $this->db->like('title', $text, 'both');
                //    $this->db->or_like('description', $text, 'both');
                //    $this->db->or_like('tag', $text, 'both');
                }
            }
$this->db->order_by('current_stock', 'desc');
            if($vendor = $this->input->post('vendor')){
                if(in_array($vendor, $vendors)){
                    $this->db->where('added_by', '{"type":"vendor","id":"'.$vendor.'"}');
                } else {
                    $this->db->where('product_id','');
                }                
            }
$this->db->order_by('current_stock', 'desc');
             if($vendor3 = $this->input->post('brnd_txt')){

                if(in_array($vendor3, $brand_llst)){
                    $this->db->where('brand',$vendor3);
                } else {
                    $this->db->where('brand','');
                }                            
            }
            $this->db->order_by('current_stock', 'desc');
            if (isset($range)) {
                $p = explode(';', $range);
                $this->db->where('sale_price >=', $p[0]);
                $this->db->where('sale_price <=', $p[1]);
            }
            $this->db->order_by('current_stock', 'desc');
            $query = array();
            if (count($sub_category) > 0) {
                $i = 0;
                foreach ($sub_category as $row) {
                    $i++;
                    if ($row !== "") {
                        if ($row !== "0") {
                            $query[] = $row;
                            $setter  = 'get';
                        } else {
                            $this->db->where('sub_category !=', '0');
                        }
                    }
                }$this->db->order_by('current_stock', 'desc');
                if ($setter == 'get') {
                    $this->db->where_in('sub_category', $query);$this->db->order_by('current_stock', 'desc');
                     $this->db->order_by('current_stock', 'desc');
                }
            }
            
            if (count($category) > 0 && $setter !== 'get') {
                $i = 0;
                foreach ($category as $rowc) {
                    $i++;
                    if ($rowc !== "") {
                        if ($rowc !== "0") {
                            if ($i == 1) {
                                $this->db->where('category', $rowc);

                            } else {
                                $this->db->or_where('category', $rowc);
                            }
                        } else {
                            $this->db->where('category !=', '0');
                        }
                         $this->db->order_by('current_stock', 'desc');
                    }
                }
            }
            /*mark*/
            if($fltr_flg==1)
            {
               $this->db->order_by('title', 'asc'); 
            }
            elseif($fltr_flg==2){
                $this->db->order_by('title', 'desc'); 
            }
            elseif($fltr_flg==3){
                $this->db->order_by('sale_price', 'desc'); 
            }
            elseif($fltr_flg==4){
                $this->db->order_by('sale_price', 'asc'); 
            }
            else{
                $this->db->order_by('product_id', 'desc');
            }
            
            $page_data['all_products'] = $this->db->get('product', $config['per_page'], $para2)->result_array();
          //  echo '<pre>'; print_r($page_data['all_products']); echo '</pre>';
            //die;
            if ($name != '') {
                $name .= ' : ';
            }
            if (isset($rowc)) {
                $cat = $rowc;
            } else {
                if ($setter == 'get') {
                    $cat = $this->crud_model->get_type_name_by_id('sub_category', $sub_category[0], 'category');
                }
            }
            if ($cat !== '') {
                if ($cat !== '0') {
                    $name .= $this->crud_model->get_type_name_by_id('category', $cat, 'category_name');
                } else {
                    $name = 'All Products';
                }
            } else {
                $name = 'All Products';
            }
            
        } elseif ($para1 == "load") {
            $page_data['all_products'] = $this->db->get('product')->result_array();
        }
        $page_data['vendor_system'] 	 = $this->db->get_where('general_settings',array('type' => 'vendor_system'))->row()->value;
        $page_data['category_data']      = $category;
        $page_data['viewtype']           = $para3;
        $page_data['name']               = $name;
        $page_data['count']              = $config['total_rows'];
        $page_data['grid_items_per_row'] = $grid_items_per_row;
        $this->load->view('front/listed', $page_data);
    }
    
   
    /* FUNCTION: Loads Custom Pages */
    function store_locator($parmalink = '')
    {
        $page_data['page_name']  = 'store_locator';
        $page_data['page_title'] = translate("store_locator");
        $page_data['text'] = $parmalink;
        $page_data['vendors'] = $this->db->get_where('vendor',array('status'=>'approved'))->result_array();
        $this->load->view('front/index', $page_data);
    }
    
    
    /* FUNCTION: Loads Featured Product Page */
    function featured_item($min = '', $max = '')
    {
        $page_data['page_name']        = "featured_list";
        $page_data['page_title']       = translate('featured_products');
        $page_data['range']            = $min . ';' . $max;
        $page_data['all_category']     = $this->db->get('category')->result_array();
        $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
        $page_data['all_products']     = $this->db->get_where('product', array(
            'featured' => "ok",
            'status' => 'ok'
        ))->result_array();
        $this->load->view('front/index', $page_data);
    }
    
    /* FUNCTION: Loads Custom Pages */
    function page($parmalink = '')
    {
        $pagef                   = $this->db->get_where('page', array(
            'parmalink' => $parmalink
        ));
        $page_data['page_name']  = "page";
        $page_data['page_title'] = $parmalink;
        $page_data['page_items'] = $pagef->result_array();
        if ($this->session->userdata('admin_login') !== 'yes' && $pagef->row()->status !== 'ok') {
            redirect(base_url() . 'index.php/home/', 'refresh');
        }
        $this->load->view('front/index', $page_data);
    }
    
    
    /* FUNCTION: Loads Product View Page */
    function product_view($para1 = "")
    {
        $page_data['page_name']    = "product_view";
        $product_data              = $this->db->get_where('product', array(
            'product_id' => $para1,
            'status' => 'ok'
        ));
		
/*        $this->db->where('product_id', $para1);
        $this->db->update('product', array(
            'number_of_view' => 'number_of_view'+1
        ));*/
		
        $page_data['product_data'] = $product_data->result_array();
        $page_data['page_title']   = $product_data->row()->title;
        $page_data['product_tags'] = $product_data->row()->tag;

        $nov=$product_data->row()->number_of_view +1;
        $this->db->where('product_id', $para1);
        $this->db->update('product', array('number_of_view' => $nov));        
        $this->load->view('front/index', $page_data);
    }
	
    /* FUNCTION: Loads Product View Page */
   function quick_view($para1 = "")
    {
        $product_data              = $this->db->get_where('product', array(
            'product_id' => $para1,
            'status' => 'ok'
        ));
        $page_data['product_data'] = $product_data->result_array();
        $page_data['page_title']   = $product_data->row()->title;
        $page_data['product_tags'] = $product_data->row()->tag;
        
        $this->load->view('front/quick_view', $page_data);
    }
    
    /* FUNCTION: Setting Frontend Language */
    /*function set_language($lang)
    {
        $this->session->set_userdata('language', $lang);
        $page_data['page_name'] = "home";
        redirect(base_url() . 'index.php/home/', 'refresh');
    }*/
    
    /* FUNCTION: Loads Contact Page */
    function contact($para1 = "")
    {
        $this->load->library('recaptcha');
        $this->load->library('form_validation');
        if ($para1 == 'send') {
            $safe = 'yes';
            $char = '';
            foreach($_POST as $row){
                if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row,$match))
                {
                    $safe = 'no';
                    $char = $match[0];
                }
            }

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('subject', 'Subject', 'required');
            $this->form_validation->set_rules('message', 'Message', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('captcha', 'Captcha', 'callback_validate_captcha');

            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                if($safe == 'yes'){
                   // $this->recaptcha->recaptcha_check_answer();
                    
                        $data['name']      = $this->input->post('name',true);
                        $data['subject']   = $this->input->post('subject');
                        $data['email']     = $this->input->post('email');
                        $data['organization']     = $this->input->post('org');
                        $data['time_to_call']     = $this->input->post('conv_time');
                        $data['message']   = $this->security->xss_clean(($this->input->post('message')));
                        
                        $data['view']      = 'no';
                        $data['timestamp'] = time();
                        $this->db->insert('contact_message', $data);
                        echo 'sent';
                     
                } else {
                    echo 'Disallowed charecter : " '.$char.' " in the POST';
                }
            }
        } else {
            $page_data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
            $page_data['page_name']      = "contact";
            $page_data['page_title']     = translate('contact');
            $this->load->view('front/index', $page_data);
        }
    }
    



/*request for service*/
    function request_service($para1 = "")
    {
        //$this->load->library('recaptcha');
        $this->load->library('form_validation');
        if ($para1 == 'send') {
            $safe = 'yes';
            $char = '';
            foreach($_POST as $row){
                if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row,$match))
                {
                    $safe = 'no';
                    $char = $match[0];
                }
            }

            
            $this->form_validation->set_rules('vessel_name', 'vessel name', 'required');
            $this->form_validation->set_rules('equipment_make', 'equipment make', 'required');
            $this->form_validation->set_rules('equipment_model', 'equipment model', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('serial_no', 'serial no', 'required');
            $this->form_validation->set_rules('port_of_call', 'port of call', 'required');
            $this->form_validation->set_rules('eta', 'eta', 'required');
            $this->form_validation->set_rules('agent_details', 'agent details', 'required');
            $this->form_validation->set_rules('invoice_address', 'invoice address', 'required');
            $this->form_validation->set_rules('contact_name', 'contact name', 'required');
            $this->form_validation->set_rules('tel', 'contact number', 'required');
            $this->form_validation->set_rules('captcha', 'Captcha', 'callback_validate_captcha');

            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                if($safe == 'yes'){
                   // $this->recaptcha->recaptcha_check_answer();
    
                    
                        $data['vessel_name']      = $this->input->post('vessel_name');
                        $data['equipment_make']   = $this->input->post('equipment_make');
                        $data['equipment_model']   = $this->input->post('equipment_model');
                        $data['serial_no']   = $this->input->post('serial_no');
                        $data['port_of_call']   = $this->input->post('port_of_call');
                        $data['eta']   = $this->input->post('eta');
                        $data['agent_details']   = $this->input->post('agent_details');
                        $data['invoice_address']   = $this->input->post('invoice_address');
                        $data['email']     = $this->input->post('email');
                        $data['contact_name']     = $this->input->post('contact_name');
                        $data['tel']     = $this->input->post('tel');
                        $data['description']   = $this->security->xss_clean(($this->input->post('description')));
                        $data['view']      = 'no';
                        $data['time'] = time();
                        $this->db->insert('request_service', $data);
            
                        $page_data['page_name']      = "request_service";
                        $page_data['page_title']     = translate('request_for_service');
                        echo "sent";
                        //$this->load->view('front/index', $page_data);



 /*email to multiple mails*/
                     //$this->email_model->account_opening('vendor', 'anuraji@estrrado.com', 'password');
                      $users       =  $this->db->get('request_mail')->result_array();

                        $vs_name=$data['vessel_name'] ;
                      $eq_make=  $data['equipment_make'] ;
                       $eq_model=  $data['equipment_model'];
                       $sl_no=  $data['serial_no'] ;
                       $po_of_cal=  $data['port_of_call'] ;
                        $eta= $data['eta'] ;
                         $agnt_detail=$data['agent_details'];
                        $invc_add=$data['invoice_address'] ;
                        $email23=$data['email'];
                        $con_name=$data['contact_name'];
                        $tel_co=$data['tel'];
                        $pr_dec=$data['description'];
                        $tm= $data['time'];
                       //$vs_name $eq_make $eq_model $sl_no $po_of_cal $eta $agnt_detail $invc_add $email23 $con_name $tel_co $pr_dec $tm
                      // $this->email_model->do_email($email_msg, $email_sub, $email_to, $from);
                     
                       foreach ($users as $key => $user) {
                if ($user !== '') {
                    $mail=$user['request_email'];
                   // $this->email_model->do_email($email_msg, $email_sub, $mail, $from);
                  
                    $this->crud_model->service_template($vs_name ,$eq_make ,$eq_model ,$sl_no, $po_of_cal, $eta ,$agnt_detail, $invc_add, $email23, $con_name, $tel_co, $pr_dec, $mail);
                  //quote_template($sub = '', $email = '', $msg = '',$phone='',$from_name='')  
                }
               
            }
           
                      /*end email to multiple*/


                     
                } else {
                    echo 'Disallowed charecter : " '.$char.' " in the POST';
                }
            }
        } else {
            
            $page_data['page_name']      = "request_service";
            $page_data['page_title']     = translate('request_for_service');
            $this->load->view('front/index', $page_data);
        }
    }
    /*/request for service*/
    function test_mail()
{
    $email_msg='Message';
    $email_sub='Sample Subject'; 
    $email_to='rahulr@estrrado.com';
    $this->email_model->do_email($email_msg, $email_sub, $email_to, $from);

    $users       =  $this->db->get('request_mail')->result_array();
//$this->email_model->do_email($email_msg, $email_sub, $email_to, $from);
var_dump($users);
                        $email_msg='Message';
                        $email_sub='Sample Subject'; 
                        $email_to='rahulr@estrrado.com';
                        //$this->email_model->do_email($email_msg, $email_sub, $email_to, $from);
                     
                       foreach ($users as $key => $user) {
                if ($user !== '') {
                    $mail=$user['request_email'];
                    echo $mail;
                    //$this->email_model->do_email($email_msg, $email_sub, $mail, $from);
                }
                else{
                   echo "nop";
                }
            }
}




    
    /* FUNCTION: Concerning Login */
    function vendor_logup($para1 = "", $para2 = "")
    {
        if ($para1 == "add_info") {
            $this->load->library('form_validation');
            $safe = 'yes';
            $char = '';
            foreach($_POST as $k=>$row){
                if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row,$match))
                {
                    if($k !== 'password1' && $k !== 'password2')
                    {
                        $safe = 'no';
                        $char = $match[0];
                    }
                }
            }

            $this->form_validation->set_rules('name', 'Your First Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'valid_email|required|is_unique[vendor.email]',array('required' => 'You have not provided %s.', 'is_unique' => 'This %s already exists.'));
            $this->form_validation->set_rules('password1', 'Password', 'required|matches[password2]');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'required');
            $this->form_validation->set_rules('address1', 'Address Line 1', 'required');
            $this->form_validation->set_rules('address2', 'Address Line 2', 'required');
            $this->form_validation->set_rules('display_name', 'Your Display Name', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                if($safe == 'yes'){
                    $data['name']               = $this->input->post('name');
                    $data['email']              = $this->input->post('email');
                    $data['address1']           = $this->input->post('address1');
                    $data['address2']           = $this->input->post('address2');
                    $data['company']            = $this->input->post('company');
                    $data['display_name']       = $this->input->post('display_name');
                    $data['create_timestamp']   = time();
                    $data['approve_timestamp']  = 0;
                    $data['approve_timestamp']  = 0;
                    $data['membership']         = 0;
                    $data['status']             = 'pending';
                    
                    if ($this->input->post('password1') == $this->input->post('password2')) {
                        $password         = $this->input->post('password1');
                        $data['password'] = sha1($password);
                        $this->db->insert('vendor', $data);
                        $this->email_model->account_opening('vendor', $data['email'], $password);
                        echo 'done';
                    }
                } else {
                    echo 'Disallowed charecter : " '.$char.' " in the POST';
                }
            }
        } else if($para1 == 'registration') {
            $this->load->view('front/vendor_logup');
        }

    }
    /* FUNCTION: Concerning Login */
    function login($para1 = "", $para2 = "")
    {
        $page_data['page_name'] = "login";
        $this->load->library('form_validation');
        if ($para1 == "do_login") {
			$this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
				$signin_data = $this->db->get_where('user', array(
					'email' => $this->input->post('email'),
					'password' => sha1($this->input->post('password'))
				));
				if ($signin_data->num_rows() > 0) {
                    if($signin_data->row()->status == 'approved'){
					foreach ($signin_data->result_array() as $row) {
						$this->session->set_userdata('user_login', 'yes');
						$this->session->set_userdata('user_id', $row['user_id']);
						$this->session->set_userdata('user_name', $row['username']);
						$this->session->set_flashdata('alert', 'successful_signin');
						$this->db->where('user_id', $row['user_id']);
						$this->db->update('user', array(
							'last_login' => time()
						));


                        $cart_list=json_decode($row['carted'],true);
                        $this->session->set_userdata('cart_cont',count($cart_list) );
                                if(count($cart_list)>0)
                                {

                                foreach ($cart_list as $rowcart) 
                                 {
                                    $datact = array(
                                    'id' => $rowcart['id'],
                                    'qty' =>$rowcart['qty'],
                                    'option' => json_decode($rowcart['option']),
                                    'price' => $this->crud_model->get_product_price($rowcart['id']),
                                    'name' => url_title($this->crud_model->get_type_name_by_id('product',$rowcart['id'], 'title')),
                                            //'shipping' => $this->crud_model->get_shipping_cost($rowcart['id']),
                                     'tax' => $this->crud_model->get_product_tax($rowcart['id']),
                                    'image' => $this->crud_model->file_view('product',$rowcart['id'], '', '', 'thumb', 'src', 'multi', 'one'),
                                    'coupon' => ''
                                        );
                                    $this->cart->insert($datact);

                                 }
                                 $page_data['carted'] = $this->cart->contents();
                                         
                                }

                        $datas['id']=session_id();
                        $datas['user_id']=$row['user_id'];
                        $datas['ip']=$_SERVER["REMOTE_ADDR"] ;                   
                        $this->db->insert('sessiondb',$datas);
                        
						echo 'done';
					}
                    }else {
                        
                     echo 'Account Not Varified, Please Varify your email address..';    
                    }
				} else {
					echo 'failed';
				}
			}
        } else if ($para1 == 'forget') {
        	$this->load->library('form_validation');
			$this->form_validation->set_rules('email', 'Email', 'required');
			
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
				$query = $this->db->get_where('user', array(
					'email' => $this->input->post('email')
				));
				if ($query->num_rows() > 0) {
					$user_id          = $query->row()->user_id;
					$password         = substr(hash('sha512', rand()), 0, 12);
					$data['password'] = sha1($password);
					$this->db->where('user_id', $user_id);
					$this->db->update('user', $data);
					if ($this->email_model->password_reset_email('user', $user_id, $password)) {
						echo 'email_sent';
					} else {
						echo 'email_not_sent';
					}
				} else {
					echo 'email_nay';
				}
			}
        }
    }

function set_currency($curr)
    {
        if($curr=='USD' || $curr=='AED')
        {
       
         $this->session->set_userdata(array(

                            'currency'       => $curr
                      

                    ));  
           
        }
        else
        { 
            
            redirect(base_url() .'index.php/home');
            
        }
             
        redirect(base_url() .'index.php/home');

    }

    
    /* FUNCTION: Setting login page with facebook and google */
    function login_set($para1 = '', $para2 = '')
    {
        $fb_login_set = $this->crud_model->get_type_name_by_id('general_settings', '51', 'value');
        $g_login_set  = $this->crud_model->get_type_name_by_id('general_settings', '52', 'value');
        $page_data    = array();
        $appid        = $this->db->get_where('general_settings', array(
            'type' => 'fb_appid'
        ))->row()->value;
        $secret       = $this->db->get_where('general_settings', array(
            'type' => 'fb_secret'
        ))->row()->value;
        $config       = array(
            'appId' => $appid,
            'secret' => $secret
        );
        $this->load->library('Facebook', $config);
        
        if ($fb_login_set == 'ok') {
            // Try to get the user's id on Facebook
            $userId = $this->facebook->getUser();
            
            // If user is not yet authenticated, the id will be zero
            if ($userId == 0) {
                // Generate a login url
                //$page_data['url'] = $this->facebook->getLoginUrl(array('scope'=>'email')); 
                $page_data['url'] = $this->facebook->getLoginUrl(array(
                    'redirect_uri' => site_url('home/login_set/back/' . $para2),
                    'scope' => array(
                        "email"
                    ) // permissions here
                ));
                //redirect($data['url']);
            } else {
                // Get user's data and print it
                $page_data['user'] = $this->facebook->api('/me');
                $page_data['url']  = site_url('home/login_set/back/' . $para2); // Logs off application
                //print_r($user);
            }
            if ($para1 == 'back') {
                $user = $this->facebook->api('/me');
                if ($user_id = $this->crud_model->exists_in_table('user', 'fb_id', $user['id'])) {
                    
                } else {
                    $data['username']      = $user['name'];
                    $data['email']         = $user['email'];
                    $data['fb_id']         = $user['id'];
                    $data['wishlist']      = '[]';
                    $data['creation_date'] = time();
                    $data['password']      = substr(hash('sha512', rand()), 0, 12);
                    
                    $this->db->insert('user', $data);
                    $user_id = $this->db->insert_id();
                }
                $this->session->set_userdata('user_login', 'yes');
                $this->session->set_userdata('user_id', $user_id);
                $this->session->set_userdata('user_name', $this->db->get_where('user', array(
                    'user_id' => $user_id
                ))->row()->username);
                $this->session->set_flashdata('alert', 'successful_signin');
                
                $this->db->where('user_id', $user_id);
                $this->db->update('user', array(
                    'last_login' => time()
                ));
                
                if ($para2 == 'cart') {
                    redirect(base_url() . 'index.php/home/cart_checkout', 'refresh');
                } else {
                    redirect(base_url() . 'index.php/home', 'refresh');
                }
            }
        }
        
        
        if ($g_login_set == 'ok') {
            $this->load->library('googleplus');
            if (isset($_GET['code'])) { //just_logged in
                $this->googleplus->client->authenticate();
                $_SESSION['token'] = $this->googleplus->client->getAccessToken();
                $g_user            = $this->googleplus->people->get('me');
                if ($user_id = $this->crud_model->exists_in_table('user', 'g_id', $g_user['id'])) {
                    
                } else {
                    $data['username']      = $g_user['displayName'];
                    $data['email']         = 'required';
                    $data['wishlist']      = '[]';
                    $data['g_id']          = $g_user['id'];
                    $data['g_photo']       = $g_user['image']['url'];
                    $data['creation_date'] = time();
                    $data['password']      = substr(hash('sha512', rand()), 0, 12);
                    $this->db->insert('user', $data);
                    $user_id = $this->db->insert_id();
                }
                $this->session->set_userdata('user_login', 'yes');
                $this->session->set_userdata('user_id', $user_id);
                $this->session->set_userdata('user_name', $this->db->get_where('user', array(
                    'user_id' => $user_id
                ))->row()->username);
                $this->session->set_flashdata('alert', 'successful_signin');
                
                $this->db->where('user_id', $user_id);
                $this->db->update('user', array(
                    'last_login' => time()
                ));
                
                if ($para2 == 'cart') {
                    redirect(base_url() . 'index.php/home/cart_checkout', 'refresh');
                } else {
                    redirect(base_url() . 'index.php/home', 'refresh');
                }
            }
            if (@$_SESSION['token']) {
                $this->googleplus->client->setAccessToken($_SESSION['token']);
            }
            if ($this->googleplus->client->getAccessToken()) //already_logged_in
                {
                $page_data['g_user'] = $this->googleplus->people->get('me');
                $page_data['g_url']  = $this->googleplus->client->createAuthUrl();
                $_SESSION['token']   = $this->googleplus->client->getAccessToken();
            } else {
                $page_data['g_url'] = $this->googleplus->client->createAuthUrl();
            }
        }
        
        if ($para1 == 'login') {
            $this->load->view('front/login', $page_data);
        } elseif ($para1 == 'registration') {
            $this->load->view('front/logup', $page_data);
        }
    }
    function getLoggedInUser(){
        echo $this->session->userdata('user_id'); die;
    }
    
    /* FUNCTION: Logout set */
    function logout()
    {
        $appid  = $this->db->get_where('general_settings', array(
            'type' => 'fb_appid'
        ))->row()->value;
        $secret = $this->db->get_where('general_settings', array(
            'type' => 'fb_secret'
        ))->row()->value;
        $config = array(
            'appId' => $appid,
            'secret' => $secret
        );
        $this->load->library('Facebook', $config);
        
        $this->facebook->destroySession();

        $sid=session_id();
        $this->db->where('id',$sid );
        $this->db->delete('sessiondb');

                $carted = $this->cart->contents();
                                    
                    foreach ($carted as $items) 
                        {                                       
                             $cartlist[] =array(
                                        'id' => $items['id'],
                                        'qty' => $items['qty'],
                                        'option'=>$items['option']
                                                );
                         }

                         $datac['carted']  = json_encode($cartlist);
                         $user_idc=$this->session->userdata('user_id');
                         $this->db->where('user_id',$user_idc);
                         $this->db->update('user', $datac);

        $this->session->sess_destroy();
        redirect(base_url() . '/home/logged_out', 'refresh');
    }
    
    /* FUNCTION: Logout */
    function logged_out()
    {
        $this->session->set_flashdata('alert', 'successful_signout');
        redirect(base_url() . '/home/', 'refresh');
    }
    
    /* FUNCTION: Check if Email user exists */
    function exists()
    {
        $email  = $this->input->post('email');
        $user   = $this->db->get('user')->result_array();
        $exists = 'no';
        foreach ($user as $row) {
            if ($row['email'] == $email) {
                $exists = 'yes';
            }
        }
        echo $exists;
    }
    
    /* FUNCTION: Newsletter Subscription */
    function subscribe()
    {
        $safe = 'yes';
        $char = '';
        foreach($_POST as $row){
            if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row,$match))
            {
                $safe = 'no';
                $char = $match[0];
            }
        }

        $this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
            if($safe == 'yes'){
    			$subscribe_num = $this->session->userdata('subscriber');
    			$email         = $this->input->post('email');
    			$subscriber    = $this->db->get('subscribe')->result_array();
    			$exists        = 'no';
    			foreach ($subscriber as $row) {
    				if ($row['email'] == $email) {
    					$exists = 'yes';
    				}
    			}
    			if ($exists == 'yes') {
    				echo 'already';
    			} else if ($subscribe_num >= 3) {
    				echo 'already_session';
    			} else if ($exists == 'no') {
    				$subscribe_num = $subscribe_num + 1;
    				$this->session->set_userdata('subscriber', $subscribe_num);
    				$data['email'] = $email;
    				$this->db->insert('subscribe', $data);
    				echo 'done';
    			}
            } else {
                echo 'Disallowed charecter : " '.$char.' " in the POST';
            }
		}
    }
    
    /* FUNCTION: Customer Registration*/
     function registration($para1 = "", $para2 = "")
    {
        $safe = 'yes';
        $char = '';
        foreach($_POST as $k=>$row){
            if (preg_match('/[\'^":()}{#~><>|=¬]/', $row,$match))
            {
                if($k !== 'password1' && $k !== 'password2')
                {
                    $safe = 'no';
                    $char = $match[0];
                }
            }
        }

        $this->load->library('form_validation');
        $page_data['page_name'] = "registration";
        if ($para1 == "add_info") {
            $this->form_validation->set_rules('username', 'Your First Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email]|valid_email',array('required' => 'You have not provided %s.', 'is_unique' => 'This %s already exists.'));
            $this->form_validation->set_rules('password1', 'Password', 'required|matches[password2]');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'required');
            $this->form_validation->set_rules('address1', 'Address Line 1', 'required');
        //    $this->form_validation->set_rules('address2', 'Address Line 2', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            $this->form_validation->set_rules('surname', 'Your Last Name', 'required');
            $this->form_validation->set_rules('zip', 'ZIP', 'required');
            $this->form_validation->set_rules('city', 'City', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                if($safe == 'yes'){
                    $data['username']      = $this->input->post('us ername');
                    $data['email']         = $this->input->post('email');
                    $data['address1']      = $this->input->post('address1');
                    $data['address2']      = $this->input->post('address2');
                    $data['country_id']      = $this->input->post('scountry');
                    $data['state_code']      = $this->input->post('sstate');
                    $data['phone']         = $this->input->post('phone');
                    $data['surname']       = $this->input->post('surname');
                    $data['zip']           = $this->input->post('zip');
                    $data['city']          = $this->input->post('city');
                    $data['langlat']       = '';
                    $data['wishlist']      = '[]';
                    $data['creation_date'] = time();
                    $data['status']        = sha1($this->input->post('email'));
                    
                    if ($this->input->post('password1') == $this->input->post('password2')) {
                        $password         = $this->input->post('password1');
                        $data['password'] = sha1($password);
                        $this->db->insert('user', $data);
                        //$approve= sha1($data['email']);
                        $this->crud_model->account_opening('user', $data['email'], $password,$data['status'], $data['username']);
                        echo 'done';
                    }
                } else {
                    echo 'Disallowed charecter : " '.$char.' " in the POST';
                }
            }
        }
        else if ($para1 == "update_info") {
            $id                  = $this->session->userdata('user_id');
            $data['username']    = $this->input->post('username');
            $data['surname']     = $this->input->post('surname');
            $data['email']       = $this->input->post('email');
            $data['address1']    = $this->input->post('address1');
            $data['address2']    = $this->input->post('address2');
            $data['phone']       = $this->input->post('phone');
            $data['city']        = $this->input->post('city');
            $data['skype']       = $this->input->post('skype');
            $data['google_plus'] = $this->input->post('google_plus');
            $data['facebook']    = $this->input->post('facebook');
            $data['zip']         = $this->input->post('zip');
            
            $this->crud_model->file_up('image', 'user', $id);
            
            $this->db->where('user_id', $id);
            $this->db->update('user', $data);
            redirect(base_url() . 'index.php/home/profile/', 'refresh');
        }
        else if ($para1 == "update_password") {
            $user_data['password'] = $this->input->post('password');
            $account_data          = $this->db->get_where('user', array(
                'user_id' => $this->session->userdata('user_id')
            ))->result_array();
            foreach ($account_data as $row) {
                if (sha1($user_data['password']) == $row['password']) {
                    if ($this->input->post('password1') == $this->input->post('password2')) {
                        $data['password'] = sha1($this->input->post('password1'));
                        $this->db->where('user_id', $this->session->userdata('user_id'));
                        $this->db->update('user', $data);
                        $this->crud_model->changePasswordEmail();

$sid=session_id();
$sesson_data = $this->db->get_where('sessiondb', array('user_id' => $this->session->userdata('user_id') ));
foreach ($sesson_data->result_array() as $rowss) 
{
if ($rowss['id'] != $sid ) 
{
session_id($rowss['id']);
session_start();
session_destroy();
$this->db->where('id',$rowss['id'] );
$this->db->delete('sessiondb');
}
}
session_id($sid);
session_start();

                        //redirect(base_url() . 'index.php/home/profile/', 'refresh');

                         header(base_url() . 'index.php/home/profile/');
                    }
                } else {
                    echo 'pass_prb';
                }
            }
            redirect(base_url() . 'index.php/home/', 'refresh');
        } else {
            $this->load->view('front/registration', $page_data);
        }
    }
    /* FUNCTION: EMAIL APPROVAL*/
    function email_approve($key)
    {
        $login_key = $this->db->get_where('user', array(
                    'status' => $key
                    ));
        if ($login_key->num_rows() > 0) {
            $data['status']="approved";
            $this->db->where('status', $key);
            $this->db->update('user', $data);
            $this->load->view('front/email_approve', $page_data);
        }
        else{
        redirect(base_url() . 'index.php/home/', 'refresh');
        }
    }
    /* FUNCTION: EMAIL APPROVAL*/
    
    function error()
    {
        $this->load->view('front/error');
    }
    

/*todays deal*/
    function  daily_deals($para1 = '', $para2 = '')
    {
 
          $para1="list";
        if ($para1 == 'list') 
        {
            $this->db->order_by('product_id', 'desc');
            $page_data['all_deals'] =  $this->db->get_where('product',array('deal'=>'ok'))->result_array();
            $this->load->view('front/daily_deals', $page_data);
        }

    }
/*todays deal*/
     /*track order*/
    function  track_order($para1 = '', $para2 = '')
    {
 
      
            $this->load->view('front/track_order');


    }
    /*track order*/


    
    /* FUNCTION: Product rating*/
    function rating($product_id, $rating)
    {
        if ($this->session->userdata('user_login') != "yes") {
            redirect(base_url() . 'index.php/home/login/', 'refresh');
        }
        if ($rating <= 5) {
            if ($this->crud_model->set_rating($product_id, $rating) == 'yes') {
                echo 'success';
            } else if ($this->crud_model->set_rating($product_id, $rating) == 'no') {
                echo 'already';
            }
        } else {
            echo 'failure';
        }
    }
    
     /* FUNCTION: Product Review + Rating*/
    function review($product_id, $rating, $title, $review)
    {
        $title=urldecode($title);
        $review=urldecode($review);
         /*$product_id = $this->input->post('product');
         $rating = $this->input->post('rating');
         $title = $this->input->post('title');
         $review = $this->input->post('review');*/
        if ($this->session->userdata('user_login') != "yes") {
            redirect(base_url() . 'index.php/home/login/', 'refresh');
        }
        if ($rating <= 5) {
            if ($this->crud_model->set_review($product_id, $rating) == 'yes') {
                //$review=mysql_real_escape_string($review);
                $data1['user_id']=$this->session->userdata('user_id');
                $data1['product_id']=$product_id;
                $data1['review_title']=$title;
                $data1['review']=$review;
                $data1['rating']=$rating;
                $this->db->insert('reviews', $data1);
               echo 'success';
            } else if ($this->crud_model->set_review($product_id, $rating) == 'no') {
                echo '$review';
            }
        } else {
            echo 'failure';
        }
    }
    
    /* FUNCTION: Concerning Compare*/
    function compare($para1 = "", $para2 = "")
    {
        if ($para1 == 'add') {
            $this->crud_model->add_compare($para2);
        } else if ($para1 == 'remove') {
            $this->crud_model->remove_compare($para2);
        } else if ($para1 == 'num') {
            echo $this->crud_model->compared_num();
        } else if ($para1 == 'clear') {
            $this->session->set_userdata('compare','');
            redirect(base_url().'index.php/home', 'refresh');
        } else if ($para1 == 'get_detail') {
            $product = $this->db->get_where('product',array('product_id'=>$para2));
            $return = array();
            $return += array('image' => '<img src="'.$this->crud_model->file_view('product',$para2,'','','thumb','src','multi','one').'" width="100" />');
            $return += array('price' => currency().$product->row()->sale_price);
            $return += array('description' => $product->row()->description);

            if($product->row()->product_type=='0'){
                $return += array('type' => "New");
            }
             else{
                $return += array('type' => "Refurbished");
            }


            if($product->row()->brand){
                $return += array('brand' => $this->db->get_where('brand',array('brand_id'=>$product->row()->brand))->row()->name);
            }


            if($product->row()->sub_category){
                $return += array('sub' => $this->db->get_where('sub_category',array('sub_category_id'=>$product->row()->sub_category))->row()->sub_category_name);
            }
            echo json_encode($return);
        } else {
            if($this->session->userdata('compare') == '[]'){
                redirect(base_url() . 'index.php/home/', 'refresh');
            }
            $page_data['page_name']  = "compare";
            $page_data['page_title'] = 'compare';
            $this->load->view('front/index', $page_data);
        }
        
    }
/* Function : check function*/
public function cartCheck($adrs,$city,$country,$state,$zip)
{
  //  $this->load->library('fedex');
   
    
    $to_zip     = $zip;
    $to_state   = $state;
    $to_country = $country;
    $to_city    = $city;
    $to_adrs    = $adrs;
    $carted = $this->cart->contents();
    $tL =$tW=$tH=$tWh = 0; $incId = 0;
    foreach($carted as  $key=>$item){
        if($incId == 0){ $fedRowId  =  $item['rowid'];  $incId++; }
         $item_id   = $item['id'];
         $rowId     = $item['rowid'];
        $item_name  = $item['name'];
        $i_name= "$item_name <br>";
        $i_controls="";
         $products  = $this->db->get_where('product', array('product_id' => $item_id))->result_array();
         if($row['download'] != 'ok'){ 
            foreach ($products as $row){
                $l_class_id= $row['length_class_id'];
                $w_class_id= $row['weight_class_id'];
                $length= $row['length'];
                $width= $row['width'];
                $height= $row['height'];
                $weight= $row['weight'];

                //$this->db->select("restricted_country");
                $lenth_unit = $this->db->get_where('fed_length_class_description', array(
                                       'length_class_id' => $l_class_id
                                   ))->row()->unit;
                $weight_unit = $this->db->get_where('fed_weight_class_description', array(
                                       'weight_class_id' => $w_class_id
                                   ))->row()->unit;
                /*  Starts : Length conversion to inch*/
                if($lenth_unit=='cm'){
                    $l=$length/ 2.54;
                    $l    = round($l, 2);
                    $w=$width/ 2.54;
                    $w    = round($w, 2);
                    $h=$height/ 2.54;
                    $h    = round($h, 2);
                }
                elseif($lenth_unit=='mm'){
                    $l=$length/ 25.4;
                    $l    = round($l, 2);
                    $w=$width/ 25.4;
                    $w    = round($w, 2);
                    $h=$height/ 25.4;
                    $h    = round($h, 2);
                }
                elseif($lenth_unit=='in'){
                //    echo "Sample";
                   $l=$length;
                   $l    = round($l, 2);
                   $w=$width;
                   $w    = round($w, 2);
                   $h=$height;
                   $h    = round($h, 2);
                }
                elseif($lenth_unit=='m')
                {
                   $l=$length*39.3701;
                   $l    = round($l, 2);
                   $w=$width*39.3701;
                   $w    = round($w, 2);
                   $h=$height*39.3701;
                   $h    = round($h, 2); 
                }
                /*  Ends   : Length conversion to inch*/
                /*  Start  : Weight conversion to Pound*/
                if($weight_unit=='kg'){
                    $wh=$weight*2.2;
                }elseif($weight_unit=='g'){
                    $wh= $weight / 453.59237;
                }elseif($weight_unit=='lb'){
                    $wh= $weight;
                }elseif($weight_unit=='oz'){
                    $wh= $weight / 16;
                }
                /*  Ends   : Weight conversion to Pound*/
                /*
                echo "Weight :	$weight $weight_unit or  $wh lb<br />";
                echo "length : $length ,Width : $width, Height : $height / $lenth_unit <br />";
                echo "$l X $w X $h <br />";
                */
            }
            $tL    =   $tL+$l;
            $tW    =   $tW+$w;
            $tH    =   $tH+$h;
            $tWh    =   $tWh+$wh;
        }
    }
                
/*           require_once 'credentials.php';
require_once 'bootstrap.php';*/
    

$zip_code = 61232;
$state_code = 'DU';
$address_l1 = 'Emphor Fzco, P.O. Box : 61232';
$city = 'Dubai';
$country = 'AE';
//$sam=38115;
//$sam_city="Memphis";
//echo $state_code;
define('FEDEX_ACCOUNT_NUMBER', '510087461');
define('FEDEX_METER_NUMBER', '100300801');
define('FEDEX_KEY', 'gaiwH2Bam3HGqvGC');
define('FEDEX_PASSWORD', 'toNZb8dT6PCv8wJ4hZwUqk2fa');



$rateRequest = new ComplexType\RateRequest();
//echo "Welcome111";
        
//WebAuthenticationDetail
$userCredential = new ComplexType\WebAuthenticationCredential();
$userCredential
    ->setKey(FEDEX_KEY)
    ->setPassword(FEDEX_PASSWORD);

$webAuthenticationDetail = new ComplexType\WebAuthenticationDetail();
$webAuthenticationDetail->setUserCredential($userCredential);

$rateRequest->setWebAuthenticationDetail($webAuthenticationDetail);

//ClientDetail
$clientDetail = new ComplexType\ClientDetail();
$clientDetail
    ->setAccountNumber(FEDEX_ACCOUNT_NUMBER)
    ->setMeterNumber(FEDEX_METER_NUMBER);

$rateRequest->setClientDetail($clientDetail);

//TransactionDetail
$transactionDetail = new ComplexType\TransactionDetail();
$transactionDetail->setCustomerTransactionId(' *** Rate Available Services Request v10 using PHP ***');

$rateRequest->setTransactionDetail($transactionDetail);


//Version
$version = new ComplexType\VersionId();
$version
    ->setServiceId('crs')
    ->setMajor(10)
    ->setIntermediate(0)
    ->setMinor(0);

$rateRequest->setVersion($version);

//ReturnTransitAndCommit
$rateRequest->setReturnTransitAndCommit(true);

//RequestedShipment
$requestedShipment = new ComplexType\RequestedShipment();

//RequestedShipment/DropoffType
$requestedShipment->setDropoffType(SimpleType\DropoffType::_REGULAR_PICKUP);

//RequestedShipment/Shiptimestamp
$requestedShipment->setShipTimestamp(date('c'));

//RequestedShipment/Shipper
$shipperAddress = new ComplexType\Address();
$shipperAddress
    ->setStreetLines(array("$address_l1"))
    ->setCity("$city")
    ->setStateOrProvinceCode("$state_code")
    ->setPostalCode($zip_code)
    ->setCountryCode("$country");

$shipper = new ComplexType\Party();
$shipper->setAddress($shipperAddress);

$requestedShipment->setShipper($shipper);

//RequestedShipment/Recipient
$recipientAddress = new ComplexType\Address();
$recipientAddress
    ->setStreetLines(array("$to_adrs"))
    ->setCity($to_city)
    ->setStateOrProvinceCode("$to_state")
    ->setPostalCode($to_zip)
    ->setCountryCode("$to_country");

$recipient = new ComplexType\Party();
$recipient->setAddress($recipientAddress);

$requestedShipment->setRecipient($recipient);

//RequestedShipment/ShippingChargesPayment

$shippingChargesPayment = new ComplexType\Payment();
$shippingChargesPayment->setPaymentType(new SimpleType\PaymentType(SimpleType\PaymentType::_SENDER));

$payor = new ComplexType\Payor();
$payor->setAccountNumber(FEDEX_ACCOUNT_NUMBER);
$payor->setCountryCode('AE');

$shippingChargesPayment->setPayor($payor);

$requestedShipment->setShippingChargesPayment($shippingChargesPayment);

//RequestedShipment\RateRequestTypes
$requestedShipment->setRateRequestTypes(array(
    new SimpleType\RateRequestType(SimpleType\RateRequestType::_ACCOUNT),
    new SimpleType\RateRequestType(SimpleType\RateRequestType::_LIST)
));

//RequestedShipment\PackageCount
$requestedShipment->setPackageCount(1);

//RequestedShipment\RequestedPackageLineItems
$lineItems = array();

$item1Weight = new ComplexType\Weight();
$item1Weight
    ->setUnits(new SimpleType\WeightUnits(SimpleType\WeightUnits::_LB))
    ->setValue($tWh);

$item1Dimensions = new ComplexType\Dimensions();
$item1Dimensions
    ->setLength($tL)
    ->setWidth($tW)
    ->setHeight($tH)
    ->setUnits(new SimpleType\LinearUnits(SimpleType\LinearUnits::_IN));

$item1 = new ComplexType\RequestedPackageLineItem();
$item1->setWeight($item1Weight);
$item1->setDimensions($item1Dimensions);
$item1->setGroupPackageCount(1);

/*$item2Weight = new ComplexType\Weight();
$item2Weight
    ->setUnits(new SimpleType\WeightUnits(SimpleType\WeightUnits::_LB))
    ->setValue(5.0);

$item2Dimensions = new ComplexType\Dimensions();
$item2Dimensions
    ->setLength(5)
    ->setWidth(5)
    ->setHeight(3)
    ->setUnits(new SimpleType\LinearUnits(SimpleType\LinearUnits::_IN));

$item2 = new ComplexType\RequestedPackageLineItem();
$item2->setWeight($item2Weight);
$item2->setDimensions($item2Dimensions);
$item2->setGroupPackageCount(1);*/

$lineItems[] = $item1;
/*$lineItems[] = $item2;*/
$requestedShipment->setRequestedPackageLineItems($lineItems);

$rateRequest->setRequestedShipment($requestedShipment);

//print_r($rateRequest->toArray());

//echo "<hr />";

$validateShipmentRequest = new RateService\Request();



//$request->getSoapClient()->__setLocation('https://ws.fedex.com:443/web-services/rate');


$rateservice = $validateShipmentRequest->getGetRatesReply($rateRequest);
 
if($rateservice->HighestSeverity == 'ERROR'){
    echo 'error';
    echo '<div class="error">';
    echo  '<div>'.$rateservice->HighestSeverity.': </div>';
    foreach($rateservice->Notifications as $notifivation){
        if($notifivation->Severity == 'ERROR'){
            echo '<div>'.$notifivation->LocalizedMessage.'</div>'; 
        }
    }
    echo '</div>';
    
}else{
//print_r($rateservice->RateReplyDetails);
$shippingType = $rateservice->RateReplyDetails;
    if(count($shippingType) > 1){
        foreach($shippingType as $shipingmethod){

                $netcharge  =   $shipingmethod->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetChargeWithDutiesAndTaxes->Amount;
                $surcharge  =   $shipingmethod->RatedShipmentDetails[0]->ShipmentRateDetail->Surcharges->Amount->Amount;
                $tax        =   $shipingmethod->RatedShipmentDetails[0]->ShipmentRateDetail->Taxes->Amount->Amount;

                $total = $surcharge+$netcharge;
             //   if($total == 0) $total = 20;
                //$total = currency() . $total;
                $total = $this->currency_convert($total);
                //echo "price = ".$total;
        $row_id=$item['rowid'];
        
            $shipData[$fedRowId][] = array(
                'method'=>$shipingmethod->ServiceType,
                'price'=>$total,
            );
        $method= $shipingmethod->ServiceType;
        $price=$total;
            if($method != ''){
                $i_controls .='<p><input onChange="checkState(this.value,this.id,this.name)" class="fed_in" id="'.$method.'" required type="radio" value="'.$price.'" name="f_'.$row_id.'" /><span id="fed_m">' .translate($method).'('.$price.')</span></p>';
            }
         }
    }else{
        $netcharge  =   $shippingType->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetChargeWithDutiesAndTaxes->Amount;
        $surcharge  =   $shippingType->RatedShipmentDetails[0]->ShipmentRateDetail->Surcharges->Amount->Amount;
        $tax        =   $shippingType->RatedShipmentDetails[0]->ShipmentRateDetail->Taxes->Amount->Amount;
        $price      =   $this->currency_convert($netcharge+$surcharge);
        $shipData[$fedRowId][] = array(
            'method'=>$shippingType->ServiceType,
            'price'=>$price,
        );
        if($shippingType->ServiceType != ''){
            $i_controls .='<p><input onChange="checkState(this.value,this.id,this.name)" class="fed_in" id="'.$shippingType->ServiceType.'" required type="radio" value="'.$price.'" name="f_'.$fedRowId.'" /><span id="fed_m">' .translate($shippingType->ServiceType).'('.$price.')</span></p>';
        }
   //     echo '<pre>'; print_r($shippingType); echo '</pre>';
    }
       //      echo "$i_name $i_controls";
             echo $i_controls;
             /*echo $row_id."<br>";
*/
}
    		//	}
        
      /*  $data = array(
                'rowid' =>$item['rowid'],
                'shipping' => 12,
                'shipping_method'=>'fedex'
                
            );
        $this->cart->update($data);*/
       
  //  }
    //echo "HAi";
     //echo json_encode($shipData);
//echo $adrs."dfdfd";
}
/* Function : check function */
    
    /* FUNCTION: Concering Add, Remove and Updating Cart Items*/
    function cart($para1 = '', $para2 = '', $para3 = '', $para4 = '')
    {
        
        if ($para1 == "add") {
            $qty = $this->input->post('qty');
            $color = $this->input->post('color');
            $option = array('color'=>array('title'=>'Color','value'=>$color));
            $all_op = json_decode($this->crud_model->get_type_name_by_id('product',$para2,'options'),true);
            if($all_op){
                foreach ($all_op as $ro) {
                    $name = $ro['name'];
                    $title = $ro['title'];
                    $option[$name] = array('title'=>$title,'value'=>$this->input->post($name));
                }
            }

            if($para3 == 'pp') {
                $carted = $this->cart->contents();
                foreach ($carted as $items) {
                    if ($items['id'] == $para2) {
                        $data = array(
                            'rowid' => $items['rowid'],
                            'qty' => 0
                        );
                    } else {
                        $data = array(
                            'rowid' => $items['rowid'],
                            'qty' => $items['qty']
                        );
                    }
                    $this->cart->update($data);
                }
            }

            $data = array(
                'id' => $para2,
                'qty' => $qty,
                'option' => json_encode($option),
                'price' => $this->crud_model->get_product_price($para2),
                'name' => url_title($this->crud_model->get_type_name_by_id('product', $para2, 'title')),
                'shipping' => $this->crud_model->get_shipping_cost($para2),
                'tax' => $this->crud_model->get_product_tax($para2),
                'image' => $this->crud_model->file_view('product', $para2, '', '', 'thumb', 'src', 'multi', 'one'),
                'coupon' => ''
            );
            
            $stock = $this->crud_model->get_type_name_by_id('product', $para2, 'current_stock');
            
            if (!$this->crud_model->is_added_to_cart($para2) || $para3 == 'pp') {
                if ($stock >= $qty || $this->crud_model->is_digital($para2)) {
                    $this->cart->insert($data);
                    echo 'added';
                } else {
                    echo 'shortage';
                }
            } else {
                echo 'already';
            }
            //var_dump($this->cart->contents());
        }
        
        if ($para1 == "added_list") {
            $page_data['carted'] = $this->cart->contents();
            $this->load->view('front/added_list', $page_data);
        }
        
        if ($para1 == "empty") {
            $this->cart->destroy();
            $this->session->set_userdata('couponer','');
        }
        
        if ($para1 == "quantity_update") {
            
            $carted = $this->cart->contents();
            foreach ($carted as $items) {
                if ($items['rowid'] == $para2) {
                    $product = $items['id'];
                }
            }
            $current_quantity = $this->crud_model->get_type_name_by_id('product', $product, 'current_stock');
            $msg              = 'not_limit';
            
            foreach ($carted as $items) {
                if ($items['rowid'] == $para2) {
                    if ($current_quantity >= $para3) {
                        $data = array(
                            'rowid' => $items['rowid'],
                            'qty' => $para3
                        );
                    } else {
                        $msg  = $current_quantity;
                        $data = array(
                            'rowid' => $items['rowid'],
                            'qty' => $current_quantity
                        );
                    }
                } else {
                    $data = array(
                        'rowid' => $items['rowid'],
                        'qty' => $items['qty']
                    );
                }
                $this->cart->update($data);
            }
            $return = '';
            $carted = $this->cart->contents();
            foreach ($carted as $items) {
                if ($items['rowid'] == $para2) {
                    $return = currency() . $items['subtotal'];
                }
            }
            $return .= '---' . $msg;
            echo $return;
        }

        if ($para1 == "remove_one") {
            $carted = $this->cart->contents();
            foreach ($carted as $items) {
                if ($items['rowid'] == $para2) {
                    $data = array(
                        'rowid' => $items['rowid'],
                        'qty' => 0
                    );
                } else {
                    $data = array(
                        'rowid' => $items['rowid'],
                        'qty' => $items['qty']
                    );
                }
                $this->cart->update($data);
            }
        }
        
        if ($para1 == 'calcs') {
            $discount   =   $this->session->userdata()['cart_contents']['total_discount'];
            $total = $this->cart->total();
           /* if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
                $shipping = $this->crud_model->cart_total_it('shipping');
            } elseif ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'fixed') {
                $shipping = $this->crud_model->get_type_name_by_id('business_settings', '2', 'value');
            }*/
            $shipping=$this->session->userdata('ship_cost');
            $tax   = $this->crud_model->cart_total_it('tax');
            $grand = $total + $shipping + $tax;
            $total = $total+$discount;
            if ($para2 == 'full') {
                $total = $this->cart->format_number($total);
                $ship  = $this->cart->format_number($shipping);
                $tax   = $this->cart->format_number($tax);
                $grand = $this->cart->format_number($grand);
                $count = count($this->cart->contents());
                
                if ($total == '') {
                    $total = 0;
                }
                if ($ship == '') {
                    $ship = 0;
                }
                if ($tax == '') {
                    $tax = 0;
                }
                if ($grand == '') {
                    $grand = 0;
                }
                $total = currency() . ($total);
                $ship  = currency() . $shipping;
                $tax   = currency() . $tax;
                $grand = currency() . $grand;
                
                echo $total . '-' . $ship . '-' . $tax . '-' . $grand . '-' . $count;
            }

            if ($para2 == 'prices') {
                $carted = $this->cart->contents();
                $return = array();
                foreach ($carted as $row) {
                    $return[] = array('id'=>$row['rowid'],'price'=>currency().$this->cart->format_number($row['price']),'subtotal'=>currency().$this->cart->format_number($row['subtotal']));
                }
                echo json_encode($return);
            }
        }
        
    }
      /* FUNCTION: Set Shipping Cost*/
    function ship_cost($cost,$method,$name)
    { 
    $row_id=substr($name, 2); 
    $tot_ship=0;
    $carted = $this->cart->contents();
    foreach($carted as  $item){ 
        if($item['rowid']==$row_id) 
        {
          $data = array(
                'rowid' =>$item['rowid'],
                'shipping' => $cost,
                'shipping_method'=>"$method"
                
            );  
            $this->cart->update($data);
        }
        //$tot_ship=$tot_ship+$item['shipping'];
       
    }
        $carted1 = $this->cart->contents();
        foreach($carted1 as  $item1){
       
      //  $tot_ship=$tot_ship+$item1['shipping'];
        $tot_ship=$cost;
       
    }
        $this->session->set_userdata(array(
                            'ship_cost'       => $tot_ship,
                    ));
        echo $tot_ship;
       }
    /* END FUNCTION: Set Shipping Cost*/
    
    function clear_ship_cost()
    {
   
    $tot_ship=0;
    $carted = $this->cart->contents();
    foreach($carted as  $item){
        
          $data = array(
                'rowid' =>$item['rowid'],
                'shipping' => 0,
                'shipping_method'=>"default"
                
            );  
            $this->cart->update($data);
       
        //$tot_ship=$tot_ship+$item['shipping'];
       
    }
        $carted1 = $this->cart->contents();
        foreach($carted1 as  $item1){
       
        $tot_ship=$tot_ship+$item1['shipping'];
       
    }
        $this->session->set_userdata(array(
                            'ship_cost'       => $tot_ship,
                    ));
        echo $tot_ship;
       }
    
    
    /* FUNCTION: Loads Cart Checkout Page*/
    function cart_checkout($para1 = "")
    {
        $carted = $this->cart->contents();
        if (count($carted) <= 0) {
            redirect(base_url() . 'index.php/home/', 'refresh');
        }
        $page_data['logger']     = $para1;
        $page_data['page_name']  = "cart";
        $page_data['page_title'] = translate('my_cart');
        $page_data['carted']     = $this->cart->contents();  
        $this->load->view('front/index', $page_data);
    }
    
    
   /* FUNCTION: Loads Cart Checkout Page*/
   function coupon_check()
    {
        $para1 = $this->input->post('code');
        $carted = $this->cart->contents();
        if (count($carted) > 0) {
            $discount=0;
            $p = $this->session->userdata('coupon_apply')+1;
            $this->session->set_userdata('coupon_apply',$p);
            $p = $this->session->userdata('coupon_apply');
            if($p < 10){
                $c = $this->db->get_where('coupon',array('code'=>$para1));
                $coupon = $c->result_array();
                //echo $c->num_rows();
                //,'till <= '=>date('Y-m-d')
                if($c->num_rows() > 0){
                    foreach ($coupon as $row) {
                        $spec = json_decode($row['spec'],true);
                        $coupon_id = $row['coupon_id'];
                        $till = strtotime($row['till']);
                    }
                    if($till > time()){
                        $ro = $spec;
                        $type = $ro['discount_type'];
                        $value = $ro['discount_value'];
                        $set_type = $ro['set_type'];
                        $set = json_decode($ro['set']);
                        if($set_type !== 'total_amount'){
                            $dis_pro = array();
                            $set_ra = array();
                            if($set_type == 'all_products'){
                                $set_ra[] = $this->db->get('product')->result_array();
                            } else {
                                foreach ($set as $p) {
                                    if($set_type == 'product'){
                                        $set_ra[] = $this->db->get_where('product',array('product_id'=>$p))->result_array();
                                    } else {
                                        $set_ra[] = $this->db->get_where('product',array($set_type=>$p))->result_array();
                                    }
                                }
                            }
                            foreach ($set_ra as $set) {
                                foreach ($set as $n) {
                                    $dis_pro[] = $n['product_id'];
                                }
                            }
                            $kj=0; 
                            foreach ($carted as $items) {
                                if (in_array($items['id'], $dis_pro)) {
                                    $base_price = $this->crud_model->get_product_price($items['id']);
                                 //   echo ' // '.$items['id'].' // '.$base_price.' -- ';
                                    if($type == 'percent'){
                                        $cst    =   ($base_price*$items['qty']);
                                        $discount = $discount+($cst*$value/100); 
                                    } else if($type == 'amount') {
                                        if($base_price >$value){
                                            $discount = $discount+($value*$items['qty']);
                                        }
                                    }
                                    $data = array(
                                        'rowid' => $items['rowid'],
                                    //    'price' => $base_price-$discount,
                                        'price' => $items['price'],
                                        'coupon' => $coupon_id
                                    );

                                    $kj=1;
                                } else {
                                    $data = array(
                                        'rowid' => $items['rowid'],
                                        'price' => $items['price'],
                                        'coupon' => $items['coupon']
                                    );
                                }
                                $this->cart->update($data);
                            }
                            if ($kj==1) {
                            echo 'wise:-:-:'.translate('coupon_discount_activated').':-:-:'.currency().$discount;
                                }
                                else
                                {
                                        echo 'nope';
                                }
                        } 

                        else {
                            $this->cart->set_discount($value);
                            echo 'total:-:-:'.translate('coupon_discount_activated').':-:-:'.currency().$value;
                        }
                        $this->cart->set_coupon($coupon_id);
                        $this->cart->set_discount($discount);
                        $this->session->set_userdata('couponer','done');
                        $this->session->set_userdata('coupon_apply',0);
                    } else {
                        echo 'nope';
                    }
                } else {
                    echo 'nope';
                }
            } else {
                echo 'Too many coupon request!';
            }
        }
    }
    function guest_check()
    {
        $gst = $this->input->post('guest_chk1');
        if($gst==1){
       $this->session->set_userdata(array(
                            'user_login'       => "yes",
                            'user_id'      => "0",
                            'user_name'       => "Guest"
                          
                    ));  
        echo "success";
        }
        else{
             $this->session->unset_userdata(array('user_login','user_id','user_name'));  
            echo "lgn";
        }
        
    }
function payfort_response($sale_id){
    if ($this->session->userdata('user_login') == 'yes') {
        $carted   = $this->cart->contents();
        foreach ($carted as $value) {
                                $this->crud_model->decrease_quantity($value['id'], $value['qty']);
                                $data1['type']         = 'destroy';
                                $data1['category']     = $this->db->get_where('product', array(
                                    'product_id' => $value['id']
                                ))->row()->category;
                                $data1['sub_category'] = $this->db->get_where('product', array(
                                    'product_id' => $value['id']
                                ))->row()->sub_category;
                                $data1['product']      = $value['id'];
                                $data1['quantity']     = $value['qty'];
                                $data1['total']        = 0;
                                $data1['reason_note']  = 'sale';
                                $data1['sale_id']      = $sale_id;
                                $data1['datetime']     = time();
                                $this->db->insert('stock', $data1);
                            }
                            $this->crud_model->digital_to_customer($sale_id);
                            $this->crud_model->email_invoice($sale_id, $this->session->userdata('payfort_email'));
                            $this->cart->destroy();
                            $this->session->set_userdata('couponer','');
                            redirect(base_url() . 'index.php/home/invoice/' . $sale_id, 'refresh');
        
        
        
        
    
    }else {
            //echo 'nope';
            redirect(base_url() . 'index.php/home/cart_checkout/need_login', 'refresh');
        }
    
}
    
    /* FUNCTION: Finalising Purchase*/
  function cart_finish($para1 = "", $para2 = "")
    { 
        if ($this->session->userdata('user_login') == 'yes') {
            $carted   = $this->cart->contents();
            $total    = $this->cart->total();
            $discount   =   $this->session->userdata()['cart_contents']['total_discount'];
            $exchange = $this->crud_model->get_type_name_by_id('business_settings', '8', 'value');
            $vat_per  = '';
            $vat      = $this->crud_model->cart_total_it('tax');
            if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
                $shipping = $this->crud_model->cart_total_it('shipping');
            } else {
                $shipping = $this->crud_model->get_type_name_by_id('business_settings', '2', 'value');
            } 
            if($shipping == 0){ $shipping = $this->session->userdata('ship_cost'); }
            $grand_total     = $total + $vat + $shipping;
            $product_details = json_encode($carted);
            
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->update('user', array(
                'langlat' => $this->input->post('langlat')
            ));
            
            /*if ($this->input->post('payment_type') == 'paypal') {
                if ($para1 == 'go') {
                    
                    $data['buyer']             = $this->session->userdata('user_id');
                    $data['product_details']   = $product_details;
                    $data['shipping_address']  = json_encode($_POST);
                    $data['vat']               = $vat;
                    $data['vat_percent']       = $vat_per;
                    $data['shipping']          = $shipping;
                    $data['delivery_status']   = '[]';
                    $data['payment_type']      = $para1;
                    $data['payment_status']    = '[]';
                    $data['payment_details']   = 'none';
                    $data['grand_total']       = $grand_total;
                    $data['sale_datetime']     = time();
                    $data['delivary_datetime'] = '';
                    $paypal_email              = $this->crud_model->get_type_name_by_id('business_settings', '1', 'value');
                    
                    $this->db->insert('sale', $data);
                    $sale_id           = $this->db->insert_id();
                    $vendors = $this->crud_model->vendors_in_sale($sale_id);
                    $delivery_status = array();
                    $payment_status = array();
                    foreach ($vendors as $p) {
                        $delivery_status[] = array('vendor'=>$p,'status'=>'pending','delivery_time'=>'');
                        $payment_status[] = array('vendor'=>$p,'status'=>'due');
                    }
                    if($this->crud_model->is_admin_in_sale($sale_id)){
                        $delivery_status[] = array('admin'=>'','status'=>'pending','delivery_time'=>'');
                        $payment_status[] = array('admin'=>'','status'=>'due');
                    }
                    $data['sale_code'] = date('Ym', $data['sale_datetime']) . $sale_id;
                    $data['delivery_status'] = json_encode($delivery_status);
                    $data['payment_status'] = json_encode($payment_status);
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sale', $data);
                    
                    $this->session->set_userdata('sale_id', $sale_id);
                    
                    ***TRANSFERRING USER TO PAYPAL TERMINAL***
                    $this->paypal->add_field('rm', 2);
                    $this->paypal->add_field('no_note', 0);
                    $this->paypal->add_field('cmd', '_cart');
                    $this->paypal->add_field('upload', '1');
                    $i = 1;
                    
                    foreach ($carted as $val) {
                        $this->paypal->add_field('item_number_' . $i, $i);
                        $this->paypal->add_field('item_name_' . $i, $val['name']);
                        $this->paypal->add_field('amount_' . $i, $this->cart->format_number(($val['price'] / $exchange)));
                        if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
                            $this->paypal->add_field('shipping_' . $i, $this->cart->format_number((($val['shipping'] / $exchange) * $val['qty'])));
                        }
                        $this->paypal->add_field('tax_' . $i, $this->cart->format_number(($val['tax'] / $exchange)));
                        $this->paypal->add_field('quantity_' . $i, $val['qty']);
                        $i++;
                    }
                    if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'fixed') {
                        $this->paypal->add_field('shipping_1', $this->cart->format_number(($this->crud_model->get_type_name_by_id('business_settings', '2', 'value') / $exchange)));
                    }
                    //$this->paypal->add_field('amount', $grand_total);
                    $this->paypal->add_field('custom', $sale_id);
                    $this->paypal->add_field('business', $paypal_email);
                    $this->paypal->add_field('notify_url', base_url() . 'index.php/home/paypal_ipn');
                    $this->paypal->add_field('cancel_return', base_url() . 'index.php/home/paypal_cancel');
                    $this->paypal->add_field('return', base_url() . 'index.php/home/paypal_success');
                    
                    $this->paypal->submit_paypal_post();
                    // submit the fields to paypal
                }
                
            } else */ if ($this->input->post('payment_type') == 'cash_on_delivery') {
                if ($para1 == 'go') {
                    $data['buyer']             = $this->session->userdata('user_id');
                    $data['product_details']   = $product_details;
                    $data['shipping_address']  = json_encode($_POST);
                    $data['vat']               = $vat;
                    $data['vat_percent']       = $vat_per;
                    $data['shipping']          = $shipping;
                    $data['delivery_status']   = '[]';
                    $data['payment_type']      = 'cash_on_delivery';
                    $data['payment_status']    = '[]';
                    $data['payment_details']   = '';
                    $data['discount']          = $discount;
                    $data['grand_total']       = $grand_total;
                    $data['sale_datetime']     = time();
                    $data['delivary_datetime'] = '';
                    $adrs_flag = $this->input->post('add_address');
                    if($adrs_flag=="on")
                    {
                        $adrs['user_id']        = $this->session->userdata('user_id');
                        $adrs['fname']          = $this->input->post('sfirstname');
                        $adrs['lname']          = $this->input->post('slastname');
                        $adrs['city']           = $this->input->post('scity');
                        $adrs['address1']       = $this->input->post('saddress1');
                        $adrs['address2']       = $this->input->post('saddress2');
                        $adrs['country_code']   = $this->input->post('scountry');
                        $adrs['state_code']     = $this->input->post('sstate');
                        $adrs['zip']            = $this->input->post('szip');
                        $adrs['phone']          = $this->input->post('sphone');
                        $adrs['email']          = $this->input->post('semail');
                        $this->db->insert('user_address', $adrs);
                    }
                    $this->db->insert('sale', $data);
                    $sale_id           = $this->db->insert_id();
                    $vendors = $this->crud_model->vendors_in_sale($sale_id);
                    $delivery_status = array();
                    $payment_status = array();
                    foreach ($vendors as $p) {
                        $delivery_status[] = array('vendor'=>$p,'status'=>'pending','delivery_time'=>'');
                        $payment_status[] = array('vendor'=>$p,'status'=>'due');
                    }
                    if($this->crud_model->is_admin_in_sale($sale_id)){
                        $delivery_status[] = array('admin'=>'','status'=>'pending','delivery_time'=>'');
                        $payment_status[] = array('admin'=>'','status'=>'due');
                    }
                    $data['sale_code'] = date('Ym', $data['sale_datetime']) . $sale_id;
                    $data['delivery_status'] = json_encode($delivery_status);
                    $data['payment_status'] = json_encode($payment_status);
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sale', $data);
                    
                    foreach ($carted as $value) {
                        $this->crud_model->decrease_quantity($value['id'], $value['qty']);
                        $data1['type']         = 'destroy';
                        $data1['category']     = $this->db->get_where('product', array(
                            'product_id' => $value['id']
                        ))->row()->category;
                        $data1['sub_category'] = $this->db->get_where('product', array(
                            'product_id' => $value['id']
                        ))->row()->sub_category;
                        $data1['product']      = $value['id'];
                        $data1['quantity']     = $value['qty'];
                        $data1['total']        = 0;
                        $data1['reason_note']  = 'sale';
                        $data1['sale_id']      = $sale_id;
                        $data1['datetime']     = time();
                        $this->db->insert('stock', $data1);
                    }
                    $this->crud_model->digital_to_customer($sale_id);
                    $this->crud_model->email_invoice($sale_id, $this->input->post('email'));
                    $this->cart->destroy();
                    $this->session->set_userdata('couponer','');
                    //echo $sale_id;
                    redirect(base_url() . 'index.php/home/invoice/' . $sale_id, 'refresh');
                }
            } 
             else if ($this->input->post('payment_type') == 'payfort') {
                if ($para1 == 'go') {
                    $data['buyer']             = $this->session->userdata('user_id');
                    $data['product_details']   = $product_details;
                    $data['shipping_address']  = json_encode($_POST);
                    $data['vat']               = $vat;
                    $data['vat_percent']       = $vat_per;
                    $data['shipping']          = $shipping;
                    $data['delivery_status']   = '[]';
                    $data['payment_type']      = 'payfort';
                    $data['payment_status']    = '[]';
                    $data['payment_details']   = '';
                    $data['discount']          = $discount;
                    $data['grand_total']       = $grand_total;
                    $data['sale_datetime']     = time();
                    $data['delivary_datetime'] = '';
                    $adrs_flag = $this->input->post('add_address');
                    if($adrs_flag=="on")
                    {
                        $adrs['user_id']        = $this->session->userdata('user_id');
                        $adrs['fname']          = $this->input->post('sfirstname');
                        $adrs['lname']          = $this->input->post('slastname');
                        $adrs['city']           = $this->input->post('scity');
                        $adrs['address1']       = $this->input->post('saddress1');
                        $adrs['address2']       = $this->input->post('saddress2');
                        $adrs['country_code']   = $this->input->post('scountry');
                        $adrs['state_code']     = $this->input->post('sstate');
                        $adrs['zip']            = $this->input->post('szip');
                        $adrs['phone']          = $this->input->post('sphone');
                        $adrs['email']          = $this->input->post('semail');
                        $this->db->insert('user_address', $adrs);
                    }
                    
                    $this->db->insert('sale', $data);
                    $sale_id           = $this->db->insert_id();
                    $vendors = $this->crud_model->vendors_in_sale($sale_id);
                    $delivery_status = array();
                    $payment_status = array();
                    foreach ($vendors as $p) {
                        $delivery_status[] = array('vendor'=>$p,'status'=>'pending','delivery_time'=>'');
                        $payment_status[] = array('vendor'=>$p,'status'=>'due');
                    }
                    if($this->crud_model->is_admin_in_sale($sale_id)){
                        $delivery_status[] = array('admin'=>'','status'=>'pending','delivery_time'=>'');
                        $payment_status[] = array('admin'=>'','status'=>'due');
                    }
                    $data['sale_code'] = date('Ym', $data['sale_datetime']) . $sale_id;
                    $data['delivery_status'] = json_encode($delivery_status);
                    $data['payment_status'] = json_encode($payment_status);
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sale', $data); 
                    $this->session->set_userdata('payfort_email', $this->input->post('email'));
                    redirect(base_url() .'payfort/?sl='.base64_encode($sale_id));
                }
             }
            
          /*  else if ($this->input->post('payment_type') == 'stripe') {
                if ($para1 == 'go') {
                    if(isset($_POST['stripeToken'])) {
						
                        require_once(APPPATH . 'libraries/stripe-php/init.php');
                        $stripe_api_key = $this->db->get_where('business_settings' , array('type' => 'stripe_secret'))->row()->value;
                        \Stripe\Stripe::setApiKey($stripe_api_key); //system payment settings
                        $customer_email = $this->db->get_where('user' , array('user_id' => $this->session->userdata('user_id')))->row()->email;
                        
                        $customer = \Stripe\Customer::create(array(
                            'email' => $customer_email, // customer email id
                            'card'  => $_POST['stripeToken']
                        ));

                        $charge = \Stripe\Charge::create(array(
                            'customer'  => $customer->id,
                            'amount'    => ceil($grand_total*100/$exchange),
                            'currency'  => 'USD'
                        ));

                        if($charge->paid == true){
                            $customer = (array) $customer;
                            $charge = (array) $charge; 

                            $data['buyer']             = $this->session->userdata('user_id');
                            $data['product_details']   = $product_details;
                            $data['shipping_address']  = json_encode($_POST);
                            $data['vat']               = $vat;
                            $data['vat_percent']       = $vat_per;
                            $data['shipping']          = $shipping;
                            $data['delivery_status']   = 'pending';
                            $data['payment_type']      = 'stripe';
                            $data['payment_status']    = 'paid';
                            $data['payment_details']   = "Customer Info: \n".json_encode($customer,true)."\n \n Charge Info: \n".json_encode($charge,true);
                            $data['grand_total']       = $grand_total;
                            $data['sale_datetime']     = time();
                            $data['delivary_datetime'] = '';
                            
                            $this->db->insert('sale', $data);
                            $sale_id           = $this->db->insert_id();
                            $vendors = $this->crud_model->vendors_in_sale($sale_id);
                            $delivery_status = array();
                            $payment_status = array();
                            foreach ($vendors as $p) {
                                $delivery_status[] = array('vendor'=>$p,'status'=>'pending','delivery_time'=>'');
                                $payment_status[] = array('vendor'=>$p,'status'=>'paid');
                            }
                            if($this->crud_model->is_admin_in_sale($sale_id)){
                                $delivery_status[] = array('admin'=>'','status'=>'pending','delivery_time'=>'');
                                $payment_status[] = array('admin'=>'','status'=>'paid');
                            }
                            $data['sale_code'] = date('Ym', $data['sale_datetime']) . $sale_id;
                            $data['delivery_status'] = json_encode($delivery_status);
                            $data['payment_status'] = json_encode($payment_status);
                            $this->db->where('sale_id', $sale_id);
                            $this->db->update('sale', $data);
                            
                            foreach ($carted as $value) {
                                $this->crud_model->decrease_quantity($value['id'], $value['qty']);
                                $data1['type']         = 'destroy';
                                $data1['category']     = $this->db->get_where('product', array(
                                    'product_id' => $value['id']
                                ))->row()->category;
                                $data1['sub_category'] = $this->db->get_where('product', array(
                                    'product_id' => $value['id']
                                ))->row()->sub_category;
                                $data1['product']      = $value['id'];
                                $data1['quantity']     = $value['qty'];
                                $data1['total']        = 0;
                                $data1['reason_note']  = 'sale';
                                $data1['sale_id']      = $sale_id;
                                $data1['datetime']     = time();
                                $this->db->insert('stock', $data1);
                            }
                            $this->crud_model->digital_to_customer($sale_id);
                            $this->crud_model->email_invoice($sale_id, $this->input->post('email'));
                            $this->cart->destroy();
                            $this->session->set_userdata('couponer','');
                            redirect(base_url() . 'index.php/home/invoice/' . $sale_id, 'refresh');
                        } else {
                            $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                            redirect(base_url() . 'index.php/home/cart_checkout/', 'refresh');
                        }
                        
                    } else{
                        $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                        redirect(base_url() . 'index.php/home/cart_checkout/', 'refresh');
                    }
                }
            } else if ($this->input->post('payment_type') == 'ccavenue') {
                if ($para1 == 'go') {
                    //CCAvenue Access code : AVDR05CG72BR76RDRB
                    //Working Key :  CF939418BB6847E03D0D4DEAD5CBC19B
                    require_once(APPPATH . 'libraries/ccavenue/adler32.php');
                    require_once(APPPATH . 'libraries/ccavenue/Aes.php');
                    
                    error_reporting(0);

                    $merchant_id=$_POST['Merchant_Id'];  // Merchant id(also User_Id) 
                    $amount=$_POST['Amount'];            // your script should substitute the amount here in the quotes provided here
                    $order_id=$_POST['Order_Id'];        //your script should substitute the order description here in the quotes provided here
                    $url=$_POST['Redirect_Url'];         //your redirect URL where your customer will be redirected after authorisation from CCAvenue
                    $billing_cust_name=$_POST['billing_cust_name'];
                    $billing_cust_address=$_POST['billing_cust_address'];
                    $billing_cust_country=$_POST['billing_cust_country'];
                    $billing_cust_state=$_POST['billing_cust_state'];
                    $billing_city=$_POST['billing_city'];
                    $billing_zip=$_POST['billing_zip'];
                    $billing_cust_tel=$_POST['billing_cust_tel'];
                    $billing_cust_email=$_POST['billing_cust_email'];
                    $delivery_cust_name=$_POST['delivery_cust_name'];
                    $delivery_cust_address=$_POST['delivery_cust_address'];
                    $delivery_cust_country=$_POST['delivery_cust_country'];
                    $delivery_cust_state=$_POST['delivery_cust_state'];
                    $delivery_city=$_POST['delivery_city'];
                    $delivery_zip=$_POST['delivery_zip'];
                    $delivery_cust_tel=$_POST['delivery_cust_tel'];
                    $delivery_cust_notes=$_POST['delivery_cust_notes'];


                    $working_key='CF939418BB6847E03D0D4DEAD5CBC19B';    //Put in the 32 bit alphanumeric key in the quotes provided here.


                    $checksum=getchecksum($merchant_id,$amount,$order_id,$url,$working_key); // Method to generate checksum

                    $merchant_data= 'Merchant_Id='.$merchant_id.'&Amount='.$amount.'&Order_Id='.$order_id.'&Redirect_Url='.$url.'&billing_cust_name='.$billing_cust_name.'&billing_cust_address='.$billing_cust_address.'&billing_cust_country='.$billing_cust_country.'&billing_cust_state='.$billing_cust_state.'&billing_cust_city='.$billing_city.'&billing_zip_code='.$billing_zip.'&billing_cust_tel='.$billing_cust_tel.'&billing_cust_email='.$billing_cust_email.'&delivery_cust_name='.$delivery_cust_name.'&delivery_cust_address='.$delivery_cust_address.'&delivery_cust_country='.$delivery_cust_country.'&delivery_cust_state='.$delivery_cust_state.'&delivery_cust_city='.$delivery_city.'&delivery_zip_code='.$delivery_zip.'&delivery_cust_tel='.$delivery_cust_tel.'&billing_cust_notes='.$delivery_cust_notes.'&Checksum='.$checksum  ;

                    $encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.
                }
            }*/
            
        } else {
            //echo 'nope';
            redirect(base_url() . 'home/cart_checkout/need_login', 'refresh');
        }
        
    }
    
    
    
       /*Brand list on home page*/
     function brand_list($para1 = '', $para2 = '')
    {
          $para1="list";
     
       if ($para1 == 'list') {
            $this->db->order_by('brand_id', 'desc');
            $page_data['all_brands'] = $this->db->get('brand')->result_array();
            $this->load->view('front/brand_list', $page_data);
        }
    }
 /*Brand list on home page*/



/*Brand wise product listing*/
    /* function brand($para1 = '', $para2 = '')
    {
         $para1 = "get_detail"; 
        
         if ($para1 == 'get_detail') 
         {
             
            $page_data['brand_data'] = $this->db->get_where('brand',array('brand'=>$para2));
            $this->load->view('front/brand', $page_data);   
             
         }

    }
    */



    function brand($para1 = '')
    {
        
            $page_data['brand_data'] = $this->db->get_where('product',array('brand'=>$para1))->result_array();
            //var_dump($page_data['brand_data']);
            $page_data['page_name']  = 'brand';
            $page_data['page_title']  = translate($this->db->get_where('brand',array('brand_id'=>$para1))->row()->name);
            $this->load->view('front/brand', $page_data);   
             
        

    }
 
    /*//Brand wise product listing*/
    
    /*Advanced Search*/
    function advance_search($para1 = "", $para2 = "", $min = "", $max = "", $text ='')
    {
   if ($para2 == "") {
            $page_data['all_products'] = $this->db->get_where('product', array(
                'category' => $para1
            ))->result_array();
        } else if ($para2 != "") {
            $page_data['all_products'] = $this->db->get_where('product', array(
                'sub_category' => $para2
            ))->result_array();
        }
        $page_data['range']            = $min . ';' . $max;
        $page_data['page_name']        = "product_list";
        $page_data['page_title']       = translate('products');
        $page_data['all_category']     = $this->db->get('category')->result_array();
        $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
        $page_data['cur_sub_category'] = $para2;
        $page_data['cur_category']     = $para1;
        $page_data['text']             = $text;
        $page_data['category_data']    = $this->db->get_where('category', array(
            'category_id' => $para1
        ))->result_array();
          $this->load->view('front/advance_search', $page_data);
        }
       /*if ($para1 == 'list') {
            $this->db->order_by('brand_id', 'desc');
            $page_data['all_brands'] = $this->db->get('brand')->result_array();
            $this->load->view('front/advance_search', $page_data);
        }*/
    /*Advanced Search*/
    
    
    
    /* FUNCTION: Verify paypal payment by IPN*/
   /* function paypal_ipn()
    {
        if ($this->paypal->validate_ipn() == true) {
            
            $data['payment_details']   = json_encode($_POST);
            $data['payment_timestamp'] = strtotime(date("m/d/Y"));
            $data['payment_type']      = 'paypal';
            $sale_id                   = $_POST['custom'];
            $vendors = $this->crud_model->vendors_in_sale($sale_id);
            $payment_status = array();
            foreach ($vendors as $p) {
                $payment_status[] = array('vendor'=>$p,'status'=>'paid');
            }
            if($this->crud_model->is_admin_in_sale($sale_id)){
                $payment_status[] = array('admin'=>'','status'=>'paid');
            }
            $data['payment_status'] = json_encode($payment_status);
            $this->db->where('sale_id', $sale_id);
            $this->db->update('sale', $data);
        }
    }*/
    
    /* FUNCTION: Loads after cancelling paypal*/
    /*function paypal_cancel()
    {
        $sale_id = $this->session->userdata('sale_id');
        $this->db->where('sale_id', $sale_id);
        $this->db->delete('sale');
        $this->session->set_userdata('sale_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel');
        redirect(base_url() . 'index.php/home/cart_checkout/', 'refresh');
    }*/
    
    /* FUNCTION: Loads after successful paypal payment*/
    /*function paypal_success()
    {
        $carted  = $this->cart->contents();
        $sale_id = $this->session->userdata('sale_id');
        foreach ($carted as $value) {
            $this->crud_model->decrease_quantity($value['id'], $value['qty']);
            $data1['type']         = 'destroy';
            $data1['category']     = $this->db->get_where('product', array(
                'product_id' => $value['id']
            ))->row()->category;
            $data1['sub_category'] = $this->db->get_where('product', array(
                'product_id' => $value['id']
            ))->row()->sub_category;
            $data1['product']      = $value['id'];
            $data1['quantity']     = $value['qty'];
            $data1['total']        = 0;
            $data1['reason_note']  = 'sale';
            $data1['sale_id']      = $sale_id;
            $data1['datetime']     = time();
            $this->db->insert('stock', $data1);
        }
        $this->crud_model->digital_to_customer($sale_id);
        $this->cart->destroy();
        $this->session->set_userdata('couponer','');
        $this->crud_model->email_invoice($sale_id, $this->input->post('email'));
        $this->session->set_userdata('sale_id', '');
        redirect(base_url() . 'index.php/home/invoice/' . $sale_id, 'refresh');
    }*/
    
    
    /* FUNCTION: Concerning wishlist*/
   function wishlist($para1 = "", $para2 = "")
    {
        if ($para1 == 'add') {
            $this->crud_model->add_wish($para2);
        } else if ($para1 == 'remove') {
            $this->crud_model->remove_wish($para2);
        } else if ($para1 == 'num') {
            echo $this->crud_model->wished_num();
        }
        
    }
    
    /* FUNCTION: Loads Contact Page */
  function blog($para1 = "")
    {
        $f_o        = '<ul class="pagination pagination-v2">';
        $f_c        = '</ul>';
        $other      = '<li>#</li>';
        $current    = '<li class="active"><a>#</a></li>';
        if($para1 == 'all'){
            $page_data['blogs'] = $this->crud_model->pagination('blog','6','index.php/home/blog/'.$para1.'/',$f_o,$f_c,$other,$current,'4','desc');
        } else {
            $page_data['blogs'] = $this->crud_model->pagination('blog','6','index.php/home/blog/'.$para1.'/',$f_o,$f_c,$other,$current,'4','desc',array('blog_category'=>$para1));
        }
        $page_data['page_name']   = 'blog';
        $page_data['page_title']  = translate('blog');
        $this->load->view('front/index.php', $page_data);   
    }
    
    /* FUNCTION: Loads Contact Page */
   function blog_view($para1 = "")
    {
        $page_data['blog']  = $this->db->get_where('blog',array('blog_id'=>$para1))->result_array();	
		
        $this->db->where('blog_id', $para1);
        $this->db->update('blog', array(
            'number_of_view' => 'number_of_view' + 1
        ));
        $page_data['page_name']  = 'blog_view';
        $page_data['page_title']  = $this->db->get_where('blog',array('blog_id'=>$para1))->row()->title;
        $this->load->view('front/index.php', $page_data);   
    }
    
    /* FUNCTION: Concerning wishlist*/
    function chat($para1 = "", $para2 = "")
    {
        
    }
    
    /* FUNCTION: Check if Customer is logged in*/
    function check_login($para1 = "")
    {
        if ($para1 == 'state') {
            if ($this->session->userdata('user_login') == 'yes') {
                echo 'hypass';
            }
            if ($this->session->userdata('user_login') !== 'yes') {
                echo 'nypose';
            }
        } else if ($para1 == 'id') {
            echo $this->session->userdata('user_id');
        } 
        else if ($para1 == 'carted') {
            echo $this->session->userdata('cart_cont');
        }

        else {
            echo $this->crud_model->get_type_name_by_id('user', $this->session->userdata('user_id'), $para1);
        }
    }
    
    /* FUNCTION: Invoice showing*/
   function invoice($para1 = "", $para2 = "")
    {
        if ($this->session->userdata('user_login') != "yes"
             || $this->crud_model->get_type_name_by_id('sale', $para1, 'buyer') !==  $this->session->userdata('user_id'))
        {
            redirect(base_url(), 'refresh');
        }

        $page_data['sale_id']    = $para1;
        $page_data['page_name']  = "invoice";
        $page_data['page_title'] = translate('invoice');
        if($para2 == 'email'){
            $this->load->view('front/invoice_email', $page_data);
        } else {
            $this->load->view('front/index', $page_data);
        }
    }
    
    /* FUNCTION: Legal pages load - terms & conditions / privacy policy*/
    function legal($type = "")
    {
        $page_data['type']       = $type;
        $page_data['page_name']  = "legal";
        $page_data['page_title'] = translate($type);
        $this->load->view('front/index', $page_data);
    }
    
    /* FUNCTION: Price Range Load by AJAX*/
    function get_ranger($by = "", $id = "", $start = '', $end = '')
    {
        $min = $this->get_range_lvl($by, $id, "min");
        $max = $this->get_range_lvl($by, $id, "max");
        if ($start == '') {
            $start = $min;
        }
        if ($end == '') {
            $end = $max;
        }
        
        $return = '' . '<input type="text" id="rangelvl" value="" name="range" />' . '<script>' . '	$("#rangelvl").ionRangeSlider({' . '		hide_min_max: false,' . '		keyboard: true,' . '		min:' . $min . ',' . '		max:' . $max . ',' . '		from:' . $start . ',' . '		to:' . $end . ',' . '		type: "double",' . '		step: 1,' . '		prefix: "'.currency().'",' . '		grid: true,' . '		onFinish: function (data) {' . "			filter('click','none','none','0');" . '		}' . '	});' . '</script>';
        return $return;
    }
    
    /* FUNCTION: Price Range Load by AJAX*/
    function get_range_lvl($by = "", $id = "", $type = "")
    {
        if ($type == "min") {
            $set = 'asc';
        } elseif ($type == "max") {
            $set = 'desc';
        }
        $this->db->limit(1);
        $this->db->order_by('sale_price', $set);
        if (count($a = $this->db->get_where('product', array(
            $by => $id
        ))->result_array()) > 0) {
            foreach ($a as $r) {
                return $r['sale_price'];
            }
        } else {
            return 0;
        }
    }
    
    /* FUNCTION: AJAX loadable scripts*/
    function others($para1 = "", $para2 = "", $para3 = "", $para4 = "")
    {
        if ($para1 == "get_sub_by_cat") {
            $return = '';
            $subs   = $this->db->get_where('sub_category', array(
                'category' => $para2
            ))->result_array();
            foreach ($subs as $row) {
                $return .= '<option  value="' . $row['sub_category_id'] . '">' . ucfirst($row['sub_category_name']) . '</option>' . "\n\r";
            }
            echo $return;
        } else if ($para1 == "get_range_by_cat") {
            if ($para2 == 0) {
                echo $this->get_ranger("product_id !=", "", $para3, $para4);
            } else {
                echo $this->get_ranger("category", $para2, $para3, $para4);
            }
        } else if ($para1 == "get_range_by_sub") {
            echo $this->get_ranger("sub_category", $para2);
        } else if($para1 == 'text_db'){
            echo $this->db->set_update('front/index', $para2);
        } else if ($para1 == "get_home_range_by_cat") {
            echo round($this->get_range_lvl("category", $para2, "min"));
            echo '-';
            echo round($this->get_range_lvl("category", $para2, "max"));
        } else if ($para1 == "get_home_range_by_sub") {
            echo round($this->get_range_lvl("sub_category", $para2, "min"));
            echo '-';
            echo round($this->get_range_lvl("sub_category", $para2, "max"));
        }
    }


/*otp */
    
    function gt_otp($email){
     
 // generate OTP
        $email= urldecode($email);
     $otp_to_mail=mt_rand(10000,1000000);
  // create database entry for mail and OTP
      
        $data['email']=$email;
        $data['otp_in']=$otp_to_mail;
        $data['status']='inactive';
        if($data['email'] && $data['otp_in']){
      
        $this->db->insert('otp_data', $data);
           echo "inserted"; 
        
        }
        else
        {
          echo "nil";  
        }
        $subject="OTP -Service Request Mail verififcation";
        $text="<br><br>


Thank you for using Marinecart Service Request System 

        <br><br>Your Mail verification OTP: ".$otp_to_mail;
         
    // send OTP to user  
    
    
//$this->form_validation->set_rules('email', 'Email', 'valid_email|required|is_unique[vendor.email]',array('required' => 'You have not provided %s.', 'is_unique' => 'This %s already exists.'));

        
 $this->email_model->do_email($text, $subject, $email, $from);        
        
        
        //echo "nop";
        
        
    }
    
    /*end otp */
    
    
   function check_otp($otp_test){
       
       $entered_otp=$otp_test;
       
       if($entered_otp){
          
           
           $this->db->select('otp_in,otp_id,status');
        $this->db->from('otp_data');
        $this->db->where('otp_in = '.$entered_otp);
        $query = $this->db->get();
        $otp_db= $query->result_array();
           foreach($otp_db as $otp_name)
                                        {
                                            $cname=$otp_name['otp_in'];
                                            $cid=$otp_name['otp_id'];
                                            
                                        }
    
           if($cname==$entered_otp)
              {
     /*      $updateData = array('status' => 'active');

$this->db->where('otp_id', $cid);
$this->db->('otp_data', $updateData);
               */
               
               
               echo "match";
             
  $this->db->where('otp_id', $cid);
          $this -> db -> delete('otp_data');
               
           }
               
           
           else
               echo "mismatch";
          
       }

       
   }
    
/*compare count*/


function compareCount(){

   $count= $this->crud_model->compared_num();
echo $count;
      
}
/*end compare count*/




public function getUserEmail()
    {

if ( !isset($_GET['term']) )
    exit;
    $term = $_REQUEST['term'];
    $cat = $_REQUEST['cate'];
        $data = array();
        $rows = $this->myapp_model->getUser($term,$cat);
            foreach( $rows as $row )
            {
                $data[] = array(
                    'label' => $row->title,
                    'value' => $row->title);   // here i am taking name as value so it will display name in text field, you can change it as per your choice.
            }
        echo json_encode($data);
        flush();

}

/* Check Country Restriction */
    function check_resriction($cid)
    {
        $flag=0;
        $carted = $this->cart->contents();
        //var_dump($carted);
        foreach ($carted as $row) {
        $pid=$row['id'];
        $this->db->select("restricted_country");
        $this->db->from('product');
        $this->db->where('product_id = '.$pid);
        $query = $this->db->get();
        $country_db= $query->result_array();
            $r_contries=$country_db[0]['restricted_country'];
            if($r_contries!="")
            {
            $array=json_decode($r_contries,true);
            if (in_array("$cid", $array)) {
                $flag=1;
            }
            }
        }
        if($flag==1)
        {
            echo "nop";
        }
        else{
            echo "yep";
        }

    }
    /* Check Country Restriction */

    //GET CITIES
    function get_cities($cr_id){
        
 $this->db->select("fed_country.iso_code_2,fed_zone.*");
  $this->db->from('fed_zone');
  $this->db->join('fed_country', 'fed_country.country_id = fed_zone.country_id');
 $this->db->where('fed_zone.country_id = '.$cr_id);
  $query = $this->db->get();
  $states_db= $query->result_array();
        
        //$states_db = $this->db->get_where('fed_zone',array('country_id'=>$cr_id))->result_array();
        echo json_encode($states_db);
        
    }
    //ENDS GET CITIES
    //SITEMAP
    /*function sitemap(){
        $otherurls = array(
                        base_url().'index.php/home/contact/',
                        base_url().'index.php/home/legal/terms_conditions',
                        base_url().'index.php/home/legal/privacy_policy'
                    );
        $producturls = array();
        $products = $this->db->get_where('product',array('status'=>'ok'))->result_array();
        foreach ($products as $row) {
            $producturls[] = $this->crud_model->product_link($row['product_id']);
        }
        $vendorurls = array();
        $vendors = $this->db->get_where('vendor',array('status'=>'approved'))->result_array();
        foreach ($vendors as $row) {
            $vendorurls[] = $this->crud_model->vendor_link($row['vendor_id']);
        }
        $page_data['otherurls']  = $otherurls;
        $page_data['producturls']  = $producturls;
        $page_data['vendorurls']  = $vendorurls;
        $this->load->view('front/sitemap', $page_data);
    }*/

//captcha VALIDATION

     function captcha_refresh()
    {
        // Captcha configuration
        $config = array(
            'img_path'      => 'captcha_images/',
            'img_url'       => base_url().'captcha_images/',
            'img_width'     => '150',
            'img_height'    => 50,
            'word_length'   => 5,
            'font_path'  => 'uploads/product_image/Dink.ttf',
            'font_size'     =>20,
            'expiration'    =>1800,
            'colors'        => array(
                //'background' => array(0, 0, 0),
                'border' => array(0, 122, 255),#007BFF
                'text' => array(50, 50, 50),
                'grid' => array(255, 40, 40)
                )
        );
        $captcha = create_captcha($config);
        
        // Unset previous captcha and store new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode',$captcha['word']);
        
        // Display captcha image
        echo $captcha['image'];
    }

    public function validate_captcha()
    {
        if($this->input->post('captcha') != $this->session->userdata['captchaCode'])
        {

            $this->form_validation->set_message('validate_captcha', 'Wrong captcha code');
            return false;
        }else{
            return true;
        }
    }
    public function saveTag($tag,$pid){
        $productTag     =   str_replace('%20',' ',$tag);
        $productTag     = trim($productTag);
        $count  =   $this->db->get_where('product_tags',array('tag_name' => $productTag))->num_rows();
        if($count > 0){
            $prdTags    =   $this->db->get_where('product_tags',array('tag_name' => $productTag))->row();
            $prdIds     = explode(',', $prdTags->product_ids);
            if (in_array($pid, $prdIds)){ echo '<b style="color: #008bff">This tag name already exist</b>'; die; }
            $this->db->where('tag_name',$productTag)->update('product_tags',array('product_ids'=>$prdTags->product_ids.','.$pid));
            echo '<b style="color: green">Tag added successfully!</b>';
        }else{
            $this->db->insert('product_tags', array('product_id'=>$pid,'tag_name'=>$productTag,'product_ids'=>$pid,'addes_by'=>$this->session->userdata('user_id')));
            echo '<b style="color: green">Tag added successfully!</b>';
        }
         die;
    }


}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
