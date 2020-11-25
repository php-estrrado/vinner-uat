<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
	body {
		margin:0 0 0 0;
		padding:0 0 0 0 !important;
		background-color: #ffffff !important;
		font-size:10pt;
		font-family:'Lucida Grande',Verdana,Arial,sans-serif;
		line-height:14px;
		color:#303030; }
	table td {border-collapse: collapse;}
	td {margin:0;}
	td img {display:block;}
	a {color:#865827;text-decoration:underline;}
	a:hover {text-decoration: underline;color:#865827;}
	a img {text-decoration:none;}
	a:visited {color: #865827;}
	a:active {color: #865827;}
	h1 {font-size: 18pt; color:#865827; line-height: 20px;}
	h3 {font-size: 14pt; color:#865827; line-height: 20px;}
	h4 {font-size: 10pt; color:#58585a;}  
	p {font-size: 10pt;}  
  </style>
</head>

<body>

<p style="text-align: center; font-size:7pt;"><span style="color: #777777;"> <b>Service Request</b>  </span></p>
<table width="600" border="0" cellpadding="5" cellspacing="0" style="margin: auto;">
	<tr>
		<td style="padding-bottom:15px;" align="left">
			<a href="http://YOURCOMPANY.COM"><img src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="YOURCOMPANYNAME" border="0" width="150" height="100"></a>
		</td>		
		<td style="padding-bottom:15px; font-size:10px; color:#777;" align="right">
			<!--	Technical Support is available from <strong>8am - 8pm (EST) Mon-Fri</strong><br>
				Toll free: <strong>1.800.345.9876</strong>  email: <strong>helpdesk@marinecart.com</strong></font>--> 
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center" style="border-top: solid 3px #eee; padding-top: 15px;"><b>Service Request</b></td>
	</tr>
</table>
	
<table width="600" border="0" cellpadding="5" cellspacing="0" style="margin: auto;">
	<tr>
		<td style="padding-bottom:25px;">
    	You have a Service request  from <?php echo $q_con_name; ?>( <?php echo $q_email23; ?> ).
    	<br>
    	Details
    	<br><br>
    
    	Senders name  : <?php echo $q_con_name; ?><br>
        Senders mail  : <?php echo $q_email23; ?><br>
        Senders Phone : <?php echo $q_tel_co; ?><br><br><p>
        Vessel name : <?php echo $q_vs_name; ?><br>
          

          Equipment Make : : <?php echo $q_eq_make; ?><br>
          Equipment Model : : <?php echo $q_eq_model; ?><br>
          Serial No : : <?php echo $q_sl_no; ?><br>
          Port Of Call : : <?php echo $q_po_of_cal; ?><br>
          ETA : : <?php echo $q_eta; ?><br>
          Agent Details : : <?php echo $q_agnt_detail; ?><br>
          Invoicing Address: : : <?php echo $q_invc_add; ?><br>
          Equipment Make : : <?php echo $q_vs_name; ?><br>
           <br><p>
           Description : <?php echo $q_pr_dec; ?>



    	</td>
	</tr>
</table>
		
<table width="600" border="0" cellpadding="5" cellspacing="0" style="margin: auto;">
	<tr>
		<td colspan="2" align="center" style="padding-top:7px; padding-bottom:7px; border-top: 3px solid #777; border-bottom: 1px dotted #777;">	
			<span style="font-size: 12px; line-height: 14px;" face="'Lucida Grande',Verdana,Arial,sans-serif">
				Be a part of the Community:&nbsp;&nbsp;
				<a href="http://YOURDOMAIN.COM/blog">Blog</a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<a href="https://YOURDOMAIN.COM/forums">Help & Forums</a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<a href="http://twitter.com/YOURTWITTER">
				<img src="./social-twitter.png" style="display: inline;" alt="Twitter" align="absmiddle" border="0" height="24" width="24"></a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<a href="http://www.facebook.com/YOURFACEBOOK">
				<img src="./social-facebook.png" style="display: inline;" alt="Facebook" align="absmiddle" border="0" height="24" width="24"></a>
			</span>
		</td>
	</tr>
		
	<tr>
		<td align="left"><br>
			<p style="font-size: 12px; line-height: 14px; color: #777;">You have been sent this message because you recently opened a help request with YOURCOMPANYNAME.</p>
		</td>
	</tr>
</table>

</body>
</html>