<? include("database.php"); ?>
<?
$s_user=$_SESSION['s_user'];
$s_pass=$_SESSION['s_pass'];
$s_access_first=$_SESSION['s_access_first'];
$s_access_last=$_SESSION['s_access_last'];
$s_phone=$_SESSION['s_phone'];
$s_email=$_SESSION['s_email'];
?>


<link rel="STYLESHEET" type="text/css" href="stylesheet.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

<link rel="STYLESHEET" type="text/css" href="stylesheet.css">
</head>

<BODY><?php include("bluebar.php") ?><center><div class="fbwhitebox"><?php include("header-entry.php") ?>
<table width="906" border="0" cellspacing="0" cellpadding="0" align="center" class="bkg_body-main"><tr valign="top">
<td width="1"></td>
<td width="649"><div id="main_content_ip" align="left"><span class="body_content_style1">
<?
$msg=$_GET['msg'];
if($msg=='security'){
	print("<h3>The security code you entered does not match.  Please try again.</h3>\n");
}
?>
<form method="post" action="sign-up-mail.php">
<input type="hidden" name="sign-up" value="sign-up-page">
<table width="780" border="0" cellspacing="0" cellpadding="0"><tr valign="top">
<td width="205"><span class="body_content_blue"><b>Username:</b><br>
<input type="text" size="30" name="user" class="forms3" value="<? echo $s_user?>" required><br>
<img src="pix/pix_trans.gif" alt="" width="1" height="5" border="0"><br>
<b>Password:</b><br>
<div class="td">
    <input type="text" size="30" name="password" class="forms3" required>
</div>
<img src="pix/pix_trans.gif" alt="" width="1" height="5" border="0"><br>
<b>Company Name:</b><br>
<input type="text" size="30" name="access_company" class="forms3" value="<? echo $s_access_company?>" required><br>
<img src="pix/pix_trans.gif" alt="" width="1" height="5" border="0"><br>
<b>Company Address:</b><br>
<input type="text" size="30" name="company_address" class="forms3" value="<? echo $s_company_address?>" required><br>
<img src="pix/pix_trans.gif" alt="" width="1" height="5" border="0"><br>
<b>Company City:</b><br>
<input type="text" size="30" name="company_city" class="forms3" value="<? echo $s_company_city?>" required><br>
<img src="pix/pix_trans.gif" alt="" width="1" height="5" border="0"><br>
<b>Company Zip:</b><br>
<input type="text" size="30" name="company_zip" class="forms3" value="<? echo $s_company_zip?>" required><br>
<img src="pix/pix_trans.gif" alt="" width="1" height="5" border="0"><br>
<b>Company Owner Name:</b><br>
<input type="text" size="30" name="company_owner" class="forms3" value="<? echo $s_company_owner?>" required><br>
<img src="pix/pix_trans.gif" alt="" width="1" height="5" border="0"><br>
<b>Owner Phone:</b><br>
<input type="text" size="30" name="owner_phone" class="forms3" value="<? echo $s_owner_phone?>" required><br>
<img src="pix/pix_trans.gif" alt="" width="1" height="5" border="0"><br>
<b>Owner Email:</b><br>
<input type="text" size="30" name="owner_email" class="forms3" value="<? echo $s_owner_email?>" required><br>
<img src="pix/pix_trans.gif" alt="" width="1" height="5" border="0"><br>
<b>Administrator/Purchaser Name:</b><br>
<input type="text" size="30" name="admin_name" class="forms3" value="<? echo $s_admin_name?>" required><br>
<b>Admin Phone Number:</b><br>
<input type="text" size="30" name="admin_phone" class="forms3" value="<? echo $s_admin_phone?>" required><br>
<b>Admin Email:</b><br>
<input type="text" size="30" name="admin_email" class="forms3" value="<? echo $s_admin_email?>" required><br>

<img src="pix/pix_trans.gif" alt="" width="1" height="5" border="0"><br></span></td>
<td width="20"><img src="pix/pix_trans.gif" alt="" width="20" height="1" border="0"></td>
<td width="365"><span class="body_content_blue">
<img src="pix/pix_trans.gif" alt="" width="1" height="5" border="0"><br>
<br>
<b>Security</b><br>
<!--security-->
<?
$days=array("1","2","3","4","5","6","7");
$chosen=array_rand($days,1);
?>
<input type="hidden" name="chosen" value="<? echo($days[$chosen]); ?>">
<img src="pix/security/<? echo("cv".$days[$chosen].".gif");?>">
<br>
<b>Please enter the characters you<br>
see above in the box below:<br>
(case sensitive)
</b><br></span>
<input type="text" name="security" size="8" class="forms2" required>
<br><br>
<!--end security-->
<img src="pix/pix_trans.gif" alt="" width="1" height="5" border="0"><br>
<input type="submit" class="btn1" value="Sign-Up">
</form></td>
</tr></table>


</span>

<br><br></td>
<td width="256">

<!-- ------------------------------begin callouts------------------------------ -->

<!-- ------------------------------end callouts------------------------------ -->

</td>
<td width="1"></td>
</tr></table>

</td>
</tr></table>

<!-- ------------------------------end body------------------------------ -->

<!-- ------------------------------begin footer------------------------------ -->
<? include("footer.php"); ?>
<!-- ------------------------------end footer------------------------------ -->
</div></div>
</body>

</html>
