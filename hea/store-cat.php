<? include("database.php");?>
<?
session_start();
$action=$_GET['action'];
$keyword=$_GET['keyword'];
$sort1=$_GET['sort'];
if(!$sort1){
	$sort="productID";
}else{
	$sort="".$sort1.",productID";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>PSE - Philips Limited Time Offer</title>

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
<link rel="STYLESHEET" type="text/css" href="menu.css">
<script type="text/javascript" language="JavaScript1.2" src="script/stmenu.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>

<script type="text/javascript">
function loadContent(elementSelector, sourceUrl) {
	$(""+elementSelector+"").load(sourceUrl);
	
}
</script>
</head>

<BODY>
<div align="center">
<!-- ------------------------------begin header------------------------------ -->
<? include("header.php"); ?>
<!-- ------------------------------end header------------------------------ -->

<!-- ------------------------------begin body------------------------------ -->
<table width="906" border="0" cellspacing="0" cellpadding="0" align="center"><tr valign="top">
<td width="906" class="title_bkg"><div id="title_spacer" align="left"><span class="title_main">PSE - Philips Limited Time Offer<br>
</span></div></td>
</tr></table>

<table width="906" border="0" cellspacing="0" cellpadding="0" align="center" class="bkg_body-main"><tr valign="top">
<td width="1" bgcolor="#f7921e"></td>
<td width="904"><div id="main_content_ip" align="left">
<?
$subcat=$_GET['subcat'];
$subcat1=$_GET['subcat1'];
$sqlp.="select * from tblProducts where category='$cat' ";
if($subcat){
$sqlp.="&& subcat1='$subcat'";
	}
	if($subcat1){
		$sqlp.="&& subcat2='$subcat1'";
	}
	$sqlp.=" && productPub='Yes' order by $sort asc";

#print($sqlp);
$resultp=db_query($sqlp);
$countp=mysql_num_rows($resultp);
if($countp==1){
	$label="result";
}else{
	$label="results";
}
$i=1;

	print("<br><a class=\"title_main\" href=\"store-cat.php?cat=".$cat."\"><b>".$cat." </a>");
	if($subcat){
		print(" - <a class=\"title_main\" href=\"store-cat.php?cat=".$cat."&subcat=".$subcat."\">".$subcat."</a>");
	}
	if($subcat1){
		print(" - <a class=\"title_main\" href=\"store-cat.php?cat=".$cat."&subcat=".$subcat."&subcat1=".$subcat1."\">".$subcat1."</a>");
	}
	print("</b></span><br>");
	if(!$subcat){
		$sqlsubs="select distinct subcat1 from tblProducts where category='$cat' && subcat1!='' order by $sort asc";
		$resultsubs=db_query($sqlsubs);
		$countsubs=mysql_num_rows($resultsubs);
		$subs=1;
		while($rowsubs=mysql_fetch_array($resultsubs)){
			$subcat1=$rowsubs['subcat1'];
			print("<a class=\"product_title\" href=\"store-cat.php?cat=".$cat."&subcat=".$subcat1."\">".$subcat1."</a>");
			if($subs<$countsubs){
				print("&nbsp;&nbsp;|&nbsp;&nbsp;");
			}
			$subs++;
		}
		if($countsubs>0){
			print("<br>");
		}
	}else{
		$sqlsubs="select distinct subcat2 from tblProducts where subcat1='$subcat' && category='$cat' && subcat2!='' order by subcat2 asc";
		$resultsubs=db_query($sqlsubs);
		$countsubs=mysql_num_rows($resultsubs);
		$subs=1;
		while($rowsubs=mysql_fetch_array($resultsubs)){
			$subcat2=$rowsubs['subcat2'];
			print("<a class=\"product_title\" href=\"store-cat.php?cat=".$cat."&subcat=".$subcat."&subcat1=".$subcat2."\">".$subcat2."</a>");
			if($subs<$countsubs){
				print("&nbsp;&nbsp;|&nbsp;&nbsp;");
			}
			$subs++;
		}
		if($countsubs>0){
			print("<br><br>");
		}
	}
	print("<br>\n");

?>
<!-- ------------------------------begin products - row <? echo($i);?>------------------------------ -->
<table width="853" border="0" cellspacing="0" cellpadding="0"><tr valign="top">
<?
#	print("state:".$_SESSION['st']."<br>");
while($rowp=mysql_fetch_array($resultp)){
	$productID=$rowp['productID'];
	$productName=$rowp['productName'];
	$modelNumber=$rowp['modelNumber'];
	$MSRP=number_format($rowp['MSRP'], 2, '.', ',');
	$nomsrp="";
	if(strlen($_SESSION['zip_qualify'])>0){
 		if($_SESSION['st']=='alt'){
			$sqlprice="select * from tblProductDiscounts LEFT OUTER JOIN tblTerritory on tblProductDiscounts.vendorID=tblTerritory.vendor where tblProductDiscounts.itemNo='$modelNumber' && tblTerritory.zip='$_SESSION[zip]' && tblTerritory.vendor!='13'";
		#	print($sqlprice);
			$resultprice=db_query($sqlprice);
			$countprice=mysql_num_rows($resultprice);
			if($countprice<1){
				$price=number_format($rowp['MSRP'], 2, '.', ',');
				$nomsrp="No";
			}else{
				while($rowprice=mysql_fetch_array($resultprice)){
					$price=number_format($rowprice['disct_price'], 2, '.', ',');
					if($rowp['disct_price']!==$rowp['MSRP']){
						$nomsrp="Yes";
						$show="Yes";
					}else{
						$nomsrp="No";
						$show="No";
					}
				}
			}
		}else{
			if($_SESSION['st']=='NJ'){
				$price=number_format($rowp['disct_price_nj'], 2, '.', ',');
				if($rowp['disct_price']!==$rowp['MSRP']){
						$nomsrp="Yes";
						$show="Yes";
					}else{
						$nomsrp="No";
						$show="No";
					}
			}else{
				#print("clp:".$_SESSION['clp']."<br>");
				if($_SESSION['clp']=='yes'){
					$price=number_format($rowp['disct_price'], 2, '.', ',');
					if($rowp['disct_price']!==$rowp['MSRP']){
						$nomsrp="Yes";
						$show="Yes";
					}else{
						$nomsrp="No";
						$show="No";
					}
				}else{
					$price=number_format($rowp['MSRP'], 2, '.', ',');
					$nomsrp="No";
				}
			}
		}
	}else{
		$price=number_format($rowp['MSRP'], 2, '.', ',');
		$nomsrp="No";
	}
	$imageLoc=$rowp['imageLoc'];
	$modelNumber=$rowp['modelNumber'];
			$loc=$rootDir."pse/pix/products/thumbnails/".$imageLoc;
			if(!file_exists($loc)){
				$loc=$rootDir."pse/pix/products/".$imageLoc;
				$folder="pix/products/";
			}else{
				$folder="pix/products/thumbnails/";
			}
			if(!file_exists($loc)){
				$loc="pix/products/soon.jpg";
				$folder="pix/products/";
				$imageLoc="soon.jpg";
			}
			list($width, $height, $type, $attr) = getimagesize($loc);
				if($width>106){
					$newwidth_divisor=106/$width;
					$height=$height*$newwidth_divisor;
					$width=$width*$newwidth_divisor;
				}else{
					$width=$width;
					$height=$height;
				}

?>
<td width="275">
<form method="post" action="https://www.techniart.com/pse/cart.php">
<input type="hidden" name="action" value="add">
<table width="275" border="0" cellspacing="0" cellpadding="0"><tr valign="top">
<td width="106"><a href="store-detail.php?ID=<? echo($productID);?>&show=<? echo($show);?>"><img src="<? echo($folder);?><? echo($imageLoc);?>" alt="<? echo($productName);?>" width="<? echo($width);?>" height="<? echo($height);?>" border="0" class="img_stroke"></a></td>
<td width="123"><img src="pix/pix_trans.gif" width="123" height="1"><br><span class="product_title"><? echo($productName);?></span><br>
<span class="product_number">#<? echo($modelNumber);?></span><br><br>
<? if($nomsrp=='Yes'){?>
<span class="product_price"><strike>$<? echo($MSRP);?></strike></span><br>
<?}?>
<span class="product_price">$<? echo($price);?></span><br>
<? if(!$_SESSION['']){?>
<input type="hidden" name="productID" value="<? echo($productID);?>">
<input type="hidden" name="modelNumber" value="<? echo($modelNumber);?>">
<input type="hidden" name="qty" value="1">
<input type="hidden" name="price" value="<? echo($price);?>">
<input type="hidden" name="productName" value="<? echo($productName);?>">
<input type="image" src="pix/b_buy-now_sm.gif" alt="Buy now" width="55" height="19" border="0" onClick="this.form.submit();"><br>
<?}?>
<a href="store-detail.php?ID=<? echo($productID);?>&show=<? echo($show);?>"><img src="pix/b_more-info_sm.gif" alt="Learn more" width="55" height="19" border="0"></a></td>
</tr></form><br></table>

</td>
<? if($i>1 && $i%2!==0){?>
<!--<td width="14"><img src="pix/pix_trans.gif" alt="" width="14" height="1" border="0"></td>-->
<?}?>
<? if($i>1 && $i%3==0){?>
<?$j=$i+1;?>
</tr></table>
<!-- ------------------------------end products - row <? echo($i);?>------------------------------ -->

<!-- ------------------------------begin products - row <? echo($j);?>------------------------------ -->
<table width="853" border="0" cellspacing="0" cellpadding="0"><tr valign="top">
<?}?>
<?$i++;?>
<?}?>
<?
$eval=$i-1;
$num=3-$eval;
for($ee=0;$ee<$num;$ee++){
	print("<td width=\"275\"><img src=\"pix/pix_trans.gif\" width=\"275\" height=\"1\"></td>\n");
}
?>
</td>
</tr></table><br><br>
<!-- ------------------------------end products - row 3------------------------------ -->

</div></td>
<td width="1" bgcolor="#f7921e"></td>
</tr></table>

</div></td>
</tr></table>

<table width="906" border="0" cellspacing="0" cellpadding="0" align="center"><tr valign="top">
<td width="906"><img src="pix/bot-orange.gif" alt="" width="906" height="1" border="0"></td>
</tr></table>
<!-- ------------------------------end body------------------------------ -->

<!-- ------------------------------begin footer------------------------------ -->
<? include("footer.php"); ?>
<!-- ------------------------------end footer------------------------------ -->
</div>
</body>
</html>
