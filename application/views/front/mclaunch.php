<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MarineCart</title>
    <!-- <link rel="shortcut icon" type="image/png" href="<?php //echo base_url(); ?>"/> -->
    <!-- <link rel="stylesheet" href="countstyle.css" type="text/css"/> -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/front/assets/css/countstyle.css" />
</head>
<body style="background-image:url(<?php echo base_url();?>uploads/banner_image/countdown.jpg);background-repeat:no-repeat;background-size:cover;height:100vh;">
<div id="jquery-script-menu">
<div class="jquery-script-center">
<div class="jquery-script-clear"></div>
<center>
</center>
</div>
</div>
<div class="container" >
<!--     <div class="clear-loading spinner">
        <span></span>
    </div> -->
</div>
<div class="wrapper">
<!-- <img id="logo-header" src="<?php echo base_url(); ?>uploads/logo_image/logo_18.png" alt="Logo" class="img-responsive">
 -->       
        <?php 
        date_default_timezone_set('Asia/Dubai');
        $now = new DateTime();
        $d1   = $now->format('Y-m-d H:i:s');
        $dtwo = new DateTime('2017-11-03 15:00:00');
        $d2 = $dtwo->format('Y-m-d H:i:s');
        $interval = $now->diff($dtwo);
        $diffSeconds = $dtwo->getTimestamp() - $now->getTimestamp() ;
      
        ?>


    <!-- <h1>We'll be live soon!</h1>
    <h2>We are busy improving our website, <span class="sub-message">and should be online in:</span></h2> -->

    <div class="clock" style="float:right;margin-top:30%;">
        <div class="column days">
            <div class="timer" id="days"></div>
            <div class="text">DAYS</div>
        </div>
        <div class="timer days">:</div>
        <div class="column">
            <div class="timer" id="hours"></div>
            <div class="text">HOURS</div>
        </div>
        <div class="timer">:</div>
        <div class="column">
            <div class="timer" id="minutes"></div>
            <div class="text">MINUTES</div>
        </div>
        <div class="timer">:</div>
        <div class="column">
            <div class="timer" id="seconds"></div>
            <div class="text">SECONDS</div>
        </div>
    </div>
</div>
<!-- <script  src="https://code.jquery.com/jquery-1.12.3.min.js" integrity="sha256-aaODHAgvwQW1bFOGXMeX+pC4PZIPsvn2h1sArYOhgXQ="crossorigin="anonymous"></script> -->
<script src="<?php echo base_url(); ?>template/front/assets/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.4/moment-timezone-with-data.js"></script>
<!-- <script type="text/javascript" src="counttimer.js"></script> -->
<script src="<?php echo base_url(); ?>template/front/assets/js/counttimer.js">
    </script>
</body>
</html>