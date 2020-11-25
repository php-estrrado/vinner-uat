<?php
$con = mysqli_connect("localhost","estrrado_vinner","vinner@4321#","estrrado_vinner");
function busSet($field)
{
global $con;
$set_sql="select * from business_settings where type='$field'";
$set_ex=mysqli_query($con,$set_sql);
$set_res=mysqli_fetch_array($set_ex);
return $set_res['value'];
}

function getData($sl)
{
global $con;
$sql="select * from sale where sale_id=$sl";
$ex=mysqli_query($con,$sql);
$res=mysqli_fetch_array($ex);

$data['amt']=$res['grand_total'];
$data['sale_id']=$res['sale_id'];
$data['access_code']=busSet("payfort_accesscode");
$data['shaIn']=busSet("payfort_sha_request");
$data['shaOut']=busSet("payfort_sha_response");
$data['currency']=busSet("currency");
$data['hashAlgorith']=busSet("payfort_sha_type");
$data['merchantReference']=$res['sale_code'];
//$data['cart_details']= json_encode($prdData);
//var_dump($data);
return $data;
}
function getSaleid($ref)
{
    global $con;
    $sql    ="select sale_id from sale where sale_code=$ref";
    $ex     =mysqli_query($con,$sql);
    $res    =mysqli_fetch_array($ex);
    $sale_id=$res['sale_id'];
    return $sale_id;
    
}
function getDecimalPoints($currency){
    $decimalPoint  = 2;
    $arrCurrencies = array('JOD' => 3,'KWD' => 3,'OMR' => 3,'TND' => 3,'BHD' => 3,'LYD' => 3,'IQD' => 3);
    if (isset($arrCurrencies[$currency])) {
        $decimalPoint = $arrCurrencies[$currency];
    }
    return $decimalPoint;
}
function getProductDetails($id)
{
    global $con;
    $sql="select * from `sale` where `sale_id`=$id";
    $ex=mysqli_query($con,$sql);
    if(mysqli_num_rows($ex) >0){
        $res=mysqli_fetch_array($ex);

        $prdDetails  =   array(); $prdData = array(); $subTotal = 0;
        $products   =  json_decode($res['product_details']);
        foreach($products as $product){
            $prdDetails['item_name'] = $product->name;
            $prdDetails['item_description'] = $product->id;
            $prdDetails['item_quantity'] = $product->qty;
            $prdDetails['item_price'] = $product->price;
            $prdDetails['item_image'] = $product->image;
            $subTotal   =   ($subTotal+$product->subtotal);
            $prdData['cart_items'][]  =   $prdDetails;
        }
        $decimalPoints  =   getDecimalPoints(busSet("currency"));
        $prdData['sub_total'] =   round($subTotal,$decimalPoints);
        return json_encode($prdData);
    }
}
//getData(55);
?>