<? include("database.php");?>
<? include("jersey.php");?>
<?$ID=$_GET['ID'];?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>TechniArt - Marketing The Future</title>

<meta name="robots" content="index,follow" />
<meta name="author" content="TechniArt" />
<meta name="publisher" content="techniart.com" />
<meta name="copyright" content="Copyright 2008 TechniArt. All Rights Reserved" />
<meta http-equiv="content-language" content="EN" />
<meta name="content-language" content="EN" />
<meta name="rating" content="All" />
<meta name="audience" content="General" />
<meta name="distribution" content="Global" />
<meta name="keywords" content="" />
<meta name="description" content="" />

<link rel="STYLESHEET" type="text/css" href="stylesheet.css">
<script type="text/javascript" language="JavaScript1.2" src="script/stmenu.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>

<script type="text/javascript" src="js/shadowbox-2.0.js"></script>
<script type="text/javascript">

Shadowbox.loadSkin('classic', 'src/skin');
Shadowbox.loadLanguage('en', 'src/lang');
Shadowbox.loadPlayer(['flv', 'html', 'iframe', 'img', 'qt', 'swf', 'wmp'], 'src/player');

window.onload = function(){

    Shadowbox.init();

};

</script>
</head>

<BODY>
<div align="center">
<!-- ------------------------------begin header------------------------------ -->
<? include("header.php"); ?>
<!-- ------------------------------end header------------------------------ -->

<!-- ------------------------------begin body------------------------------ -->
<table width="906" border="0" cellspacing="0" cellpadding="0" align="center"><tr valign="top">
<td width="906" class="title_bkg"><div id="title_spacer" align="left"><span class="title_main">Energy Saving Outlet</span></div></td>
</tr></table>

<table width="906" border="0" cellspacing="0" cellpadding="0" align="center" class="bkg_body-main"><tr valign="top">
<td width="1" bgcolor="#c8e1ea"><img src="pix/pix_c8e1ea.gif" alt="" width="1" height="300" border="0"></td>
<td width="904"><div id="main_content_ip" align="left">

<? include("zip.php");?>
<!-- ------------------------------begin products -detail------------------------------ -->
<?
$sqlp="select * from tblProducts where productID='$ID'";
$resultp=db_query($sqlp);
while($rowp=mysql_fetch_array($resultp)){
	$productID=$rowp['productID'];
	$productName=$rowp['productName'];
	$imageLoc=$rowp['imageLoc'];
	$modelNumber=$rowp['modelNumber'];
	$category=$rowp['category'];
	$subcat1=$rowp['subcat1'];
	$subcat2=$rowp['subcat2'];
	$subcat3=$rowp['subcat3'];
	$class=$rowp['class'];
	$MOL=$rowp['MOL'];
	$watts_used=$rowp['watts_used'];
	$replacement_wattage=$rowp['replacement_wattage'];
	$MSRP=number_format($rowp['MSRP'], 2, '.', ',');
	$disct_price_nj=number_format($rowp['disct_price_nj'], 2, '.', ',');
	$disct_price=number_format($rowp['disct_price'], 2, '.', ',');
	$light_output=$rowp['light_output'];
	$color_temp=$rowp['color_temp'];
	$color_rendering=$rowp['color_rendering'];
	$rated_lifetime=$rowp['rated_lifetime'];
	$min_start_temp=$rowp['min_start_temp'];
	$electrical_spec=$rowp['electrical_spec'];
	$descrip=$rowp['descrip'];
	$recommended=$rowp['recommended'];
	$disclaimer=$rowp['disclaimer'];
	$subtitle=$rowp['subtitle'];
	$manuf=$rowp['manuf'];
	$base=$rowp['base'];
	$ceiling=$rowp['ceiling'];
	$pendant=$rowp['pendant'];
	$table_floor=$rowp['table_floor'];
	$extra=stripslashes($rowp['extra']);
	$ceiling_fans=$rowp['ceiling_fans'];
	$wallsconce=$rowp['wallsconce'];
	$recessedcans=$rowp['recessedcans'];
	$free_ship=$rowp['free_ship'];
	$replacement_bulb=$rowp['replacement_bulb'];
	$tracklighting=$rowp['tracklighting'];
	$outdoorcovering=$rowp['outdoorcovering'];
	$outdoorexposed=$rowp['outdoorexposed'];
	$manuf_warranty=$rowp['manuf_warranty'];
	$energy_star=$rowp['energy_star'];
	$productPub=$rowp['productPub'];
			$loc=$rootDir."pix/products/".$imageLoc;
			if(!file_exists($loc)){
				$loc="pix/products/soon.jpg";
				$folder="pix/products/";
				$imageLoc="soon.jpg";
			}
			if(file_exists($loc)){
			list($width, $height, $type, $attr) = getimagesize($loc);
				if($width>158){
					$newwidth_divisor=158/$width;
					$height=$height*$newwidth_divisor;
					$width=$width*$newwidth_divisor;
				}else{
					$width=$width;
					$height=$height;
				}
			}
}
?>
<table width="853" border="0" cellspacing="0" cellpadding="0"><tr valign="top">
<form method="post" action="cart.php">
<input type="hidden" name="action" value="add">
<input type="hidden" name="productID" value="<? echo($productID);?>">
<td width="170"><a rel="shadowbox;" href="pix/products/<? echo($imageLoc);?>" class="option" title="<? echo($productName);?>"><img src="pix/products/<? echo($imageLoc);?>" alt="<? echo($productName);?>" width="<? echo($width);?>" height="<? echo($height);?>" border="0" class="img_stroke"></a><br>
<? 
if($energy_star=='Yes'){
	print("<img src=\"pix/ES_Logo.gif\" width=\"60\" height=\"60\">");
}
?>
</td>
<td width="14"><img src="pix/pix_trans.gif" alt="" width="14" height="1" border="0"></td>
<td width="369"><span class="product_title_lg"><? echo($productName);?></span><br>
<? if($subtitle && $watts_used){?>
<span class="product_title_sm"><i><? echo(ucfirst($subtitle));?> <? echo($watts_used);?> watts</i></span><br>
<?}?>
<?
#check for discounts
	if(strlen($_SESSION['zip_qualify'])>0){
		if($_SESSION['st']=='alt'){
			$sqlprice="select * from tblProductDiscounts LEFT OUTER JOIN tblTerritory on tblProductDiscounts.vendorID=tblTerritory.vendor where tblProductDiscounts.itemNo='$modelNumber' && tblTerritory.zip='$_SESSION[zip]'";
		#	print($sqlprice);
			$resultprice=db_query($sqlprice);
			$countprice=mysql_num_rows($resultprice);
			if($countprice<1){
				$price=number_format($rowp['MSRP'], 2, '.', ',');
			}else{
				while($rowprice=mysql_fetch_array($resultprice)){
					$price=number_format($rowprice['disct_price'], 2, '.', ',');
				}
			}
		}else{
			if($_SESSION['st']=='NJ'){
				$price=number_format($rowp['disct_price_nj'], 2, '.', ',');
			}else{
				if($_SESSION['clp']=='yes'){
					$price=number_format($rowp['disct_price'], 2, '.', ',');
				}else{
					$price=number_format($rowp['MSRP'], 2, '.', ',');
				}
			}
		}
	}else{
		$price=number_format($rowp['MSRP'], 2, '.', ',');
	}


/*if($_SESSION['zip']){
	$z=$_SESSION['zip'];
	$sqlz="select * from tblDiscounts where item_no='$modelNumber' && zip='$z'";
	$resultz=db_query($sqlz);
	$countz=mysql_num_rows($resultz);
	if($countz>0){
		$disct="Yes";
		if($_SESSION['st']=='NJ'){
			$price=$disct_price_nj;
		}else{
			$price=$disct_price;
		}
	}else{
		$price=$MSRP;
	}
}else{
	$price=$MSRP;
}*/
?>
<span class="product_price"><span style="color:#2ebf1e;">
<!--<?	if(strlen($_SESSION['zip_qualify'])>0 && $_SESSION['clp']=='no'){?>
<strike><b>Price:</b></span> $<? echo($MSRP);?></strike>
<?}?>-->
<?	if(strlen($_SESSION['zip_qualify'])>0){?>
<strike><b>Price:</b></span> $<? echo($MSRP);?></strike><br><span style="color:#2ebf1e;"><b>Price:</b></span>$<? echo($price);?>
<?}else{?>
<?$price=$MSRP;?>
<br><span style="color:#2ebf1e;"><b>Price:</b></span> $<? echo($MSRP);?>
<?}?></span><br><br>
<span class="product_number">#<? echo($modelNumber);?></span><br><br>
<span class="body_content_style1">
<? if($watts_used){?>
<b>Wattage:</b> <? echo($watts_used);?><br>
<?}?>
<? if($replacement_wattage){?>
<b>Replaces:</b> <? echo($replacement_wattage);?><br>
<?}?>
<? if($light_output){?>
<b>Light Output:</b> <? echo($light_output);?><br>
<?}?>
<? if($rated_lifetime){?>
<b>Rated Lifetime:</b> <? echo($rated_lifetime);?><br>
<?}?>
<? if($color_temp){?>
<b>Color Temperature:</b> <? echo($color_temp);?><br>
<?}?>
<? if($MOL){?>
<b>MOL:</b> <? echo($MOL);?><br>
<?}?>
<? if($base){?>
<b>Base:</b> <? echo($base);?><br>
<?}?>
<? if($color_rendering){?>
<b>Color Rendering:</b> <? echo($color_rendering);?><br>
<?}?>
<? if($min_start_temp){?>
<b>Minimum Start Temperature:</b> <? echo($min_start_temp);?><br>
<?}?>
<? if($electrical_spec){?>
<b>Electrical Specifications:</b> <? echo($electrical_spec);?><br>
<?}?>
<? if($manuf){?>
<b>Manufacturer:</b> <? echo($manuf);?><br>
<?}?>
<? if($manuf_warranty){?>
<b>Manufacturer Warranty:</b> <? echo($manuf_warranty);?><br><br>
<?}?>
<? if($extra){?>
<b>Description:</b> <? echo($extra);?><br><br>
<?}?>

<? if($free_ship=='Yes'){?>
<i>* This product qualifies for free shipping</i><br><br>
<?}?>
<? if(!$_SESSION['noshop']){?>
<input type="hidden" name="modelNumber" value="<? echo($modelNumber);?>">
<input type="hidden" name="qty" value="1">
<input type="hidden" name="price" value="<? echo($price);?>">
<input type="hidden" name="productName" value="<? echo($productName);?>">
<input type="image" src="pix/b_buy-now_lg.gif" alt="Buy now" width="83" height="27" border="0" onClick="this.form.submit();">
<?}?>
<br></span></td>
<td width="300" valign="top"><img src="pix/pix_trans.gif" width="1" height="60"><br>
<span class="body_content_style1">
<? if($descrip){?>
<span class="product_title_lg">Description:</span><br>
<? echo($descrip);?>
<br><br>
<?}?>
<? echo($disclaimer);?>
<br><br>
<b><? echo($recommended);?></b><br>
<?
if($table_floor=='x'){
	print("<img src=\"pix/applications/table-floor.jpg\">&nbsp;\n");
}	
if($pendant=='x'){
	print("<img src=\"pix/applications/pendant.jpg\">&nbsp;\n");
}
if($ceiling=='x'){
	print("<img src=\"pix/applications/ceiling.jpg\">&nbsp;\n");
}
if($ceilingfans=='x'){
print("<img src=\"pix/applications/ceilingfans.jpg\">&nbsp;\n");
}
if($wallsconce=='x'){
	print("<img src=\"pix/applications/wallsconces.jpg\">&nbsp;\n");
}
if($recessedcans=='x'){
	print("<img src=\"pix/applications/recessed-cans.jpg\">&nbsp;\n");
}	
if($tracklighting=='x'){
	print("<img src=\"pix/applications/track-lighting.jpg\">&nbsp;\n");
}
if($outdorcovering=='x'){
	print("<img src=\"pix/applications/outdoor-covered.jpg\">&nbsp;\n");
}	
if($outdoorexposed=='x'){
	print("<img src=\"pix/applications/outdoor-exposed.jpg\">&nbsp;\n");
}	

#replacement bulbs for fixtures
if($replacement_bulb){
	print("<br><br>");
	print("<b>Replacement Bulbs:</b> (Click to see details)<br>");
	$split=explode(", ",$replacement_bulb);
	for($r=0;$r<count($split);$r++){
			$loc1=$rootDir."pix/products/".$split[$r];
			$mf_nbr=str_replace(".jpg","",$split[$r]);
			$sqlnum="select productID,productName from tblProducts where modelNumber='$mf_nbr'";
			$resultnum=db_query($sqlnum);
			while($rownum=mysql_fetch_array($resultnum)){
				$productTitle=$rownum['productName'];
				$productID=$rownum['productID'];
			}
				if(file_exists($loc1)){
				list($width, $height, $type, $attr) = getimagesize($loc1);
					if($width>65){
						$newwidth_divisor1=65/$width;
						$height1=$height*$newwidth_divisor1;
						$width1=$width*$newwidth_divisor1;
					}else{
						$width1=$width;
						$height1=$height;
					}
				}

		print("<a href=\"store-detail.php?ID=".$productID."\"><img src=\"pix/products/".$split[$r]."\" width=\"".$width1."\" height=\"".$height1."\" class=\"img_stroke\"></a>&nbsp;\n");
	}
}

?>

</span>
</td>
</tr></form></table><br><br>
<!-- ------------------------------end products - row 3------------------------------ -->

</div></td>
<td width="1" bgcolor="#c8e1ea"><img src="pix/pix_c8e1ea.gif" alt="" width="1" height="1" border="0"></td>
</tr></table>

</div></td>
</tr></table>

<table width="906" border="0" cellspacing="0" cellpadding="0" align="center"><tr valign="top">
<td width="906"><img src="pix/g_body_bot.gif" alt="" width="906" height="12" border="0"></td>
</tr></table>
<!-- ------------------------------end body------------------------------ -->

<!-- ------------------------------begin footer------------------------------ -->
<? include("footer.php"); ?>
<!-- ------------------------------end footer------------------------------ -->
</div>
</body>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7592070-3");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>

