<? include("database.php"); ?>

<? 	$sql="select * from tblOrdersCompleted where otsID='$otsID'";
	#print($sql);
	$result=db_query($sql);
	$count=mysql_num_rows($result);
	if($count>'0'){
	echo "<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Order ID already exists.')
		window.location.href='http://www.techniart.us/pge-old'
        </SCRIPT>";
		die();	}

?>
<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<head>
<title>PG&E Simple Savings Kit - Order Processed</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="boilerplate.css" rel="stylesheet" type="text/css">
<link href="mobile.css" rel="stylesheet" type="text/css">
</head>
<BODY><!-- Google Tag Manager -->
<noscript><iframesrc="//www.googletagmanager.com/ns.html?id=GTM-5R82RN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5R82RN');</script>
<!-- End Google Tag Manager -->
<?php include_once("analyticstracking.php") ?>
<center><div class="gridContainer clearfix">
  <div id="LayoutDiv1"><? include("header.php")?></div>
</div></center>
<center><div class="gridContainer clearfix">
  <div id="LayoutDiv1">
    <table width="100%" border="0">
        <tr>
          <td align="center">
<?
print("<div style=\"padding-left:55px;\"><p class=\"body_content_style1\">");
if($amount=='8.00'){
	print("There appears to be an issue with your order. It has timed out due to inactivity in your browsing session (a security feature to protect you). Please <a class=\"body_content_style1\" href=\"https://www.techniart.us/pge-old/cart.php\">click here</a> to return to your cart.<br>");
}else{
#ini_set('display_errors','On');

/*************************************************
// Program: PHPAUTHNET AIM
// Version: 2.0
// Author: Hasan Robinson 
// Copyright (c) 2002,2003 AuthnetScripts.com
// All rights reserved.
//
//
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
// "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
// LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
// FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
// REGENTS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
// INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
// (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
// SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
// HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
// STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
// ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
// OF THE POSSIBILITY OF SUCH DAMAGE.
//
//------------------------------------------------------------------------

Description: 
Checks the response code from Authorizenet sets the results of the 
authorization  request into the message variable.

$authnet_results[x_response_code] / 1=approved 2=declined 3=error

/*********************************************************************/

include_once('./phpauthnet_aim.php');


//CHECK MD5 HASH VALUE
if($authnet['md5hash'] != "") { 
	if($authnet_results['md5'] != $authnet_results['x_md5_hash']) {   
		$authnet_results['x_response_code']='3';$authnet_results['x_response_reason_text']='MD5 HASH mis-match'; 
	}  
}
#print("Error code:".$authnet_results["x_response_code"]);
#print("<br>");
#print("Error Text:".$authnet_results["x_response_reason_text"]);

switch($authnet_results["x_response_code"]) {
	case 1:
	//document the order in the database
	$stamp=mktime();
#	$date=date("m-d-Y H:m:s");
	$date=mktime();
	$otsID=$authnet['md2'];
	$ship_fname=$_POST['ship_fname'];
	$ship_lname=$_POST['ship_lname'];
	$ship_address1=$_POST['ship_address1'];
	$ship_address2=$_POST['ship_address2'];
	$ship_city=$_POST['ship_city'];
	$ship_state=$_POST['ship_state'];
	$ship_zip=$_POST['ship_zip'];
	$email=$_POST['email'];
	$email_opt=$_POST['email_opt'];
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$address1=$_POST['address1'];
	$address2=$_POST['address2'];
	$city=$_POST['city'];
	$state=$_POST['state'];
	$zip=$_POST['zip'];
	$tax=$_POST['tax'];
	$amount=$_POST['amount'];
	$instr=$_POST['instr'];
	$sql="insert into tblOrdersCompleted(otsID, stamp, ship_firstname, ship_lastname, ship_address, ship_address2, ship_city, ship_state, ship_zip, instructions, bill_firstname, bill_lastname, bill_address, bill_address2, bill_city, bill_state, bill_zip,  email, email_opt, tax, amount, status)	values('$otsID',  '$date', '$ship_fname', '$ship_lname', '$ship_address1', '$ship_address2', '$ship_city', '$ship_state', '$ship_zip','$instr','$fname', '$lname', '$address1','$address2','$city', '$state', '$zip', '$email','$email_opt','$tax','$amount','Closed')";
	$result=db_query($sql);
	$next=mysql_insert_id();

	$sql2="update tblorderstosend set status='Closed' where otsID='$otsID'";
	$result2=db_query($sql2);

#fulfillment e-mail
$to="pge-orders@techniart.com";
$from="sales@techniart.com";
$subject="PGE Simple Savings Kit Order - techniart.com";

#grab today's date
$today=strtotime(date("m/d/Y"));
$tomorrow=$today+86400;
$tomorrow_display=strftime("%D",$tomorrow);


//			$body.="Sent on: ".date("m/d/Y H:i:s")."\n\n";
			$body.="Thank you for participating in PG&E's special offer. Your order was received on ".date("m/d/Y H:i:s").". Please find the details of your order below.\n\n";
			$body.="BILLING INFO:\n";
			$body.="Name: ".$fname." ".$lname."\n";
			$body.="Address: ".$address1." ".$address2."\n";
			$body.="".$city.", ".$state." ".$zip."\n\n";
			
			$body.="SHIPPING INFO:\n";
			$body.="Name: ".$ship_fname." ".$ship_lname."\n";
			$body.="Address: ".$ship_address1." ".$ship_address2."\n";
			$body.="".$ship_city.", ".$ship_state." ".$ship_zip."\n\n";
						
			$body.="Email: ".$email."\n\n";

			$body.="Order Contents:\n";
			
			#customer receipt
			$to1=$email;
			$from1="sales@techniart.com";
			$subject1="Mass Save Embertec Order - techniart.com";

		
			#end customer receipt
			$sql="select * from tblotsdetail where otsID='$otsID' order by otsdetailID desc";
			#print($sql);
			$result=db_query($sql);
			$count=mysql_num_rows($result);
			if($count){
				$ia=1;
				while($row=mysql_fetch_array($result)){
					$otsdetailID=$row['otsdetailID'];
					$qty=$row['qty'];
					$itemNo=$row['itemNo'];
					$price=$row['price'];
					$productDesc=$row['productDesc'];
					$productDesc=str_replace("�", "&trade;",$productDesc);
					$sizeDesc=$row['sizeDesc'];
					$sizesku=$row['sizesku'];
					$tot=$price*$qty;
					$sumtot+=$tot;
					$extra=$row['extra'];
					$extra_amt=$row['extra_amt'];
					$productID=$row['productID'];}


						$body.="".$qty." - ".$productDesc." - $".number_format($price, 2, '.', ',')."\n";

					//	$body.="------------------------------------------------------------------------------\n";
				
			
					$totfin=$sumtot+$ship_price+$tax;
					$body."\n\n\n";
									$body.="\nSubtotal: $".number_format($sumtot, 2, '.', ',')."\n";
									$body.="Tax: $".number_format($tax, 2, '.', ',')."\n";
									$body.="Total: $".number_format($totfin, 2, '.', ',')."\n";
									$body.="\n";
									#if($ship_state=='CT'){
									#	$body.="Energize CT Discount Applied: ($".number_format($diff1, 2, '.', ',').")\n";			
									$body.="Order Processing Info
									
Pacific Gas and Electric Company's offer is available from Thursday, November 19th 2015 through April 30th, 2016. Your order will be delivered within 2 weeks.

We will notify you by email if any item in your order will be delayed or if it is backordered. 

Thank you for your order. We appreciate your business and we're here to help! If you need any assistance concerning your order please feel free to email us at customerservice@techniart.com or call us at 888-285-7290.
  
Sincerely,

TechniArt & PG&E\n";
					
		
		mail($to,$subject,$body,"From:".$from."");
		mail($to=$email,$subject="Thank you for your Simple Savings Kit order from techniart.com",$body,"From:".$from."");
	}
				
			

	session_unset();

	//Show Thank You Page
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><br><script type="text/javascript">
<!--
function Redirect()
{
    window.location="http://www.techniart.us/pge-old/thankyou/";
}
document.write("<center><img src=\"animation_processing.gif\" width=\"100\" height=\"100\"></center>");
setTimeout('Redirect()', 1500);
//-->
</script></td>
  </tr>
</table>

<? break;

case 2:
break;

case 3:
//Show Declined Page with reason
?>
<table width="75%" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td><span class="cart">We're Sorry your credit card was declined for the following reason: <br><br>
      <font color="ff0000"><?php echo $authnet_results['x_response_reason_text']; ?></font> <br>
      <br>
<?
		$startdate=date("m-d-Y H:m:s");
		$a=$_POST['a'];
		$companyName=$_POST['companyName'];
		$membertype=$_POST['membertype'];
		$firstname=$authnet_results['firstname'];
		$lastname=$authnet_results['lastname'];
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$address=$_POST['address'];
		$price=$_POST['price'];
		$address2=$_POST['address2'];
		$phone=$_POST['phone'];
		$fax=$_POST['fax'];
		$url=$_POST['url'];
		$city=$_POST['city'];
		$state=$_POST['state'];
		$zip=$_POST['zip'];
		$email=$_POST['email'];
		$user=$_POST['user'];
		$pass=$_POST['pass'];
		$optin=$_POST['optin'];
		$optin_stamp=$date;

?>
	  <form method="post" action="orderform.php">
	  <input type="hidden" name="reason" value="Y">
	  <input type="hidden" name="fname" value="<? echo($fname); ?>">
	  <input type="hidden" name="lname" value="<? echo($lname); ?>">
	  <input type="hidden" name="address" value="<? echo($address); ?>">
	  <input type="hidden" name="address2" value="<? echo($address2); ?>">
	  <input type="hidden" name="city" value="<? echo($city); ?>">
	  <input type="hidden" name="price" value="<? echo($price); ?>">
	  <input type="hidden" name="state" value="<? echo($state); ?>">
  	  <input type="hidden" name="zip" value="<? echo($zip); ?>">
	  <input type="hidden" name="email" value="<? echo($email); ?>">
	  <input type="submit" value="click here to submit your transaction again"></form> </td>
  </tr>
</table>

<?
break;

default:

echo "<center><font face='verdana' size='1'><font color='ff0000'><b>Error:</b></font> cURL program is not setup correctly. <br> 
Please contact <a href='mailto:support@authnetscripts.com'>support@authnetscripts.com</a> for assistance.</font></center>"; 

}
}
?>
</td>
  </tr>
</table>
<!-- ------------------------------end body------------------------------ -->

<!-- ------------------------------begin footer------------------------------ -->
<? include("footer.php"); ?>
<!-- ------------------------------end footer------------------------------ -->
</div>
</body>

</html>

