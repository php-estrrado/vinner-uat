<?php include('header.php');
require_once 'functions.php';
if(isset($_REQUEST['sl']))
{
    $saleid = base64_decode($_REQUEST['sl']);
    $del_query ="delete from sale where sale_id='$saleid'";
    $del_ex = mysqli_query($con,$del_query);
    
} ?>

            <section class="nav">
                <ul>
                    <li class="lead" > Payment Method</li>
                    <li class="active lead" > Done</li>
                </ul>
            </section>
            <section class="confirmation">
                <label class="failed" for="" >Payment Failed</label>
                <!-- <label class="failed" for="" >Failed</label> -->
                <small>Error while processing your payment</small>
            </section>
            
            <div class="h-seperator"></div>
            
            <?php if(isset($_REQUEST['error_msg'])) : ?>
            <section>
                <div class="error"><?php echo $_REQUEST['error_msg']?></div>
            </section>
            <div class="h-seperator"></div>
            <?php endif; ?>


            <section class="actions">
                <a class="btm" href="<?php echo "https://" . $_SERVER['SERVER_NAME'] .'/vinner' ?>">Continue Shopping</a>
            </section>
