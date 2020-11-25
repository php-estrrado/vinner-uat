<?php
ob_start();
include('header.php');
require_once 'functions.php';
?>
   
    <section class="nav">
        <ul>
            <li class="lead" > Payment Method</li>
            <li class="lead" > Pay</li>
            <li class="active lead" > Done</li>
        </ul>
    </section>
    <section class="confirmation">
        <label class="success" for="" >Success</label>
        <!-- <label class="failed" for="" >Failed</label> -->
        <small>Thank You For Your Order</small>
    </section>

    <section class="order-confirmation">
        <label for="" class="lead">Order ID : <?php echo $_REQUEST['fort_id'];?></label>
    </section>
    <div class="h-seperator"></div>
    <?php
        $status=$_REQUEST['response_message'];
        $merchant_reference=$_REQUEST['merchant_reference'];
        $saleid= getSaleid($merchant_reference);
        $prm    = http_build_query($_REQUEST);
    //    echo '<pre>'; print_r($_REQUEST); echo '</pre>'; die;
          if($status=='00' || $status == '01'){
            header("Location:http://".$_SERVER['SERVER_NAME']."/payfort/error.php?".$prm);
            exit;
        }
 else if($status=='Success')
        {
        $fort_id=$_REQUEST['fort_id'];
        
        $payment_option=$_REQUEST['payment_option'];
        $merchant_reference=$_REQUEST['merchant_reference'];
        $saleid= getSaleid($merchant_reference);
       
        $sel_qry="select * from sale where sale_id='$saleid'";
        $sel_ex=mysqli_query($con,$sel_qry);
        $res=mysqli_fetch_array($sel_ex);
        $payment_status =$res['payment_status'];
        $payment_status=json_decode($payment_status,true);
        //if($payment_status==)
            $new_payment_status = array();
            foreach ($payment_status as $row) {
                if(isset($row['admin'])) {
                    $new_payment_status[] = array('admin'=>'','status'=>'paid');
                }else {
                    $new_payment_status[] = array('vendor'=>$row['vendor'],'status'=>'paid');
                }
            }
        $payment_status =json_encode($new_payment_status);
        $payment_details="Payfort ID:".$fort_id."\n \n Payment Option: ".$payment_option;
        $upd_qry="UPDATE sale SET payment_status='$payment_status',payment_details='$payment_details' where sale_id=$saleid";
        $upd_ex=mysqli_query($con,$upd_qry);
        header("Location:http://".$_SERVER['SERVER_NAME']."/home/payfort_response/$saleid");
        }
       
else{
    $del_query ="delete from sale where sale_id='$saleid'";
    $del_ex = mysqli_query($con,$del_query);
    header("Location:custom_error.php");
}
        //$payment_details="Payfort ID:".$fort_id;
        //print_r($new_payment_status);
        /*$data['payment_status']    = 'paid';
        $data['payment_details']   = "Customer Info: \n".json_encode($customer,true)."\n \n Charge Info: \n".json_encode($charge,true);
            */                
    ?>
    <section class="details">
        <h3>Response Details</h3>
        <br/>
        <table>
            <tr>
                <th>
                    Parameter Name
                </th>
                <th>
                    Parameter Value
                </th>
            </tr>
        <?php
           foreach($_REQUEST as $k => $v) {
               echo "<tr>";
               echo "<td>$k</td><td>$v</td>";
               echo "</tr>";
           } 
        ?>
        </table>
    </section>
    
    <div class="h-seperator"></div>
    
    <!--<div class="actions" style="float:left;">
        <a class='btm' href='<?php/* echo "http://" . $_SERVER['SERVER_NAME'] .'/marine_test/index.php/home/invoice/'.$saleid*/ ?>'>View Invoice</a>
    </div>
    <div class="actions">
        <a class="btm" href='<?php /*echo "http://" . $_SERVER['SERVER_NAME'] .'/marine' */?>'>Continue Shopping</a>
    </div>-->
<?php include('footer.php') ?>