<center>
<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?
$o=$_SESSION['otsID'];
$sql="select * from tblotsdetail_led LEFT OUTER JOIN tblProducts on tblotsdetail_led.itemNo=tblProducts.productID where tblotsdetail_led.otsID='$o'";
$free="select qty as FreeQuantity from tblotsdetail_led where tblotsdetail_led.itemNo='242' && tblotsdetail_led.otsID='$o'";
$combo="select qty as ComboQuantity from tblotsdetail_led where tblotsdetail_led.itemNo='243' && tblotsdetail_led.otsID='$o'";
$br="select qty as BRQuantity from tblotsdetail_led where tblotsdetail_led.itemNo='244' && tblotsdetail_led.otsID='$o'";
$freeup="update tblotsdetail_led set qty='1' where tblotsdetail_led.itemNo='242' && tblotsdetail_led.otsID='$o'";
$comboup="update tblotsdetail_led set qty='5' where tblotsdetail_led.itemNo='243' && tblotsdetail_led.otsID='$o'";
$brup="update tblotsdetail_led set qty='1' where tblotsdetail_led.itemNo='244' && tblotsdetail_led.otsID='$o'";
#print($sql);
#print($sql);
$result=db_query($sql);
$count=mysql_num_rows($result);
$resultfree=db_query($free);
$resultcombo=db_query($combo);
$resultbr=db_query($br);
while($row=mysql_fetch_array($resultfree)){
		$freelimit=$row['FreeQuantity'];
	}
while($row=mysql_fetch_array($resultcombo)){
		$combolimit=$row['ComboQuantity'];
	}
while($row=mysql_fetch_array($resultbr)){
		$brlimit=$row['BRQuantity'];
	}
if ($combolimit>5){
	$resultcombo=db_query($comboup);
	echo "<SCRIPT LANGUAGE='JavaScript'>
        window.alert('You may only purchase 5 of the LED 5-packs per household!')
		window.location.href='cart.php'
        </SCRIPT>
        ";
}
if ($brlimit>1){
	$resultbr=db_query($brup);
	echo "<SCRIPT LANGUAGE='JavaScript'>
        window.alert('You may only receive 1 Water & Energy Savings kit per house every 10 years!')
		window.location.href='cart.php'
        </SCRIPT>
        ";
}	
if ($freelimit>1){
	$resultfree=db_query($freeup);
	echo "<SCRIPT LANGUAGE='JavaScript'>
        window.alert('You may only receive 1 FREE LED 5-pack per household!')
		window.location.href='cart.php'
        </SCRIPT>
        ";
}	
if(!$count){
	print("<p class=\"cart\"><br /><br />\n");
	print("<p align=\"center\" class=\"cart\"><b>Your cart is empty.</b></p><br />\n");
	print("<p align=\"center\" class=\"cart\"><b>Click below to start over.</b></p><br />\n");
	print("<p align=\"center\"><input type=\"button\" class=\"btn\" value=\"Start Over\" onclick=\"location.href='http://www.techniart.us/led/index.php'\">\n");
	print("</tr>\n");
}else{
	print("<form method=\"post\" action=\"".$PHP_SELF."\">\n");
	print("<p class=\"cart\">");
	print("<input type=\"hidden\" name=\"action\" value=\"update\">\n");
	print("<p align=\"center\" class=\"cart\"><b>Adjust your quantities and update the cart.</b><br /></div>\n");
print("<table align=\"center\" width=\"90%\" cellpadding=\"1\" cellspacing=\"1\">\n");
	print("<tr valign=\"middle\">\n");
    print("<td><span class=\"cart-header\"><b>Qty</b></span></td>\n");
	print("<td>&nbsp;</td>\n");
	print("<td><span class=\"cart-header\"><b>Item</b></span></td>\n");
	print("<td><span class=\"cart-header\"><b>Price</b></span></td>\n");
	print("<td><span class=\"cart-header\"><b>Total</b></span></td>\n");
	print("</tr>\n");

	$shipping_products = array();



 while($row=mysql_fetch_array($result)){
		$otsdetailID=$row['otsdetailID'];
		$qty=$row['qty'];
		$type=$row['type'];
		$price=$row['price'];
	/*	if(strlen($_SESSION['zip_qualify'])>0){
			$pr=$row['disct_price'];
			if($pr!==$price){
			$sqlu="update tblotsdetail_led set price='$pr' where otsdetailID='$otsdetailID'";
			$resultu=db_query($sqlu);
		#		print("<script language=\"javascript\">document.location.href='cart.php'</script>");
			}
		}else{
			$pr=$row['MSRP'];
			if($pr!==$price){
				$sqlu="update tblotsdetail_led set price='$pr' where otsdetailID='$otsdetailID'";
				$resultu=db_query($sqlu);
			#	print("<script language=\"javascript\">document.location.href='cart.php'</script>");
			}
		}*/

		if(strlen($_SESSION['zip_qualify'])>0){
			if($_SESSION['st']=='alt'){
				$sqlprice="select * from tblProductDiscounts where itemNo='$modelNumber' && zip='$_SESSION[zip]'";
			#	print($sqlprice);
				$resultprice=db_query($sqlprice);
				$countprice=mysql_num_rows($resultprice);
				if($countprice<1){
					$pr=number_format($rowp['MSRP'], 2, '.', ',');
				}else{
					while($rowprice=mysql_fetch_array($resultprice)){
						$pr=number_format($rowprice['disct_price'], 2, '.', ',');
					}
				}
			}else{
				if($_SESSION['st']=='NJ'){
					$pr=number_format($rowp['disct_price_nj'], 2, '.', ',');
				}else{
					if($_SESSION['clp']=='yes'){
						$pr=number_format($rowp['disct_price'], 2, '.', ',');
					}else{
						$pr=number_format($rowp['MSRP'], 2, '.', ',');
					}
				}
			}
		}else{
			$pr=number_format($rowp['MSRP'], 2, '.', ',');
		}
			if($pr!==$price){
				$sqlu="update tblotsdetail_led set price='$pr' where otsdetailID='$otsdetailID'";
		#		$resultu=db_query($sqlu);
			}


		$weight=$row['weight'];
		$tot=number_format($qty*$price, 2, '.', ',');
		$tot1=$qty*$price;
		$carttot+=$tot1;
		$itemNo=$row['itemNo'];
		$productID=$row['productID'];
		$productDesc=$row['productDesc'];
		#$weight="4.0";
		$calcweight=$qty*$weight;
#		print("".$calcweight."<br>");
		$totcalcweight1+=$calcweight;
		#check for free shipping
		$sqlfreeship="select free_ship from tblProducts_led where productID='$productID'";
		$resultfreeship=db_query($sqlfreeship);
		$free_ship="";
		$lbl="";
		while($rowfreeship=mysql_fetch_array($resultfreeship)){
			$free_ship=$rowfreeship['free_ship'];
		}
		if($free_ship=='Yes'){

			$lbl="<br><span style=\"color:RED\"></span>";
		}
		print("<input type=\"hidden\" name=\"otsdetailID[]\" value=\"".$otsdetailID."\">\n");
		print("<tr valign=\"middle\" bgcolor=\"cccccc\">\n");
        print("<td><span class=\"cart\">".$qty."</span></td>\n");
		print("<td><input type=\"button\" class=\"btn2\" value=\"Remove\" onClick=\"location.href='remove.php?ID=".$otsdetailID."'\"></td>\n");
		print("<td><span class=\"cart\">".$productDesc."</span></td>\n");
		print("<td><span class=\"cart\">$".number_format($price, 2, '.', ',')."</span></td>\n");
		print("<td><span class=\"cart\">$".$tot."</span></td>\n");
		print("</tr>\n");
			print("<tr valign=\"middle\" bgcolor=\"cccccc\">\n");
        print("<td></td>\n");
		print("<td></td>\n");
		print("<td></td>\n");
		print("<td></td>\n");
		print("<td></td>\n");
		print("</tr>\n");
					print("<tr valign=\"middle\" bgcolor=\"cccccc\">\n");
        print("<td></td>\n");
		print("<td></td>\n");
		print("<td></td>\n");
		print("<td></td>\n");
		print("<td></td>\n");
		print("</tr>\n");
			$qty="";
}
	$totcalcweight=number_format($totcalcweight1, 1, '.', ',');

	print("</table>\n");
	print("<table width=\"90%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">\n");
	print("<tr valign=\"top\" bgcolor=\"#ffffff\">\n");
	print("<tr>\n");
	print("<td></td>\n");
	$totformat=number_format($carttot, 2, '.', ',');
	print("<td align=\"right\"><span class=\"cart\"><br><b>Subtotal:</b>&nbsp;$".$totformat."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>\n");
	print("</tr>\n");
			print("<td></td>\n");
#5/21
		#shipping actuals
		$sqlship="select * from tblProducts_led where productID='$itemNo'";
	//	print("".$sqlship."<br>");
		$resultship=db_query($sqlship);
		while($rowship=mysql_fetch_array($resultship)){
			$weight = $rowship['weight'];
			#$width = $rowship['width'];
			#$height = $rowship['height'];
			#$length = $rowship['length'];
			$productID=$rowship['productID'];
			$height="10";
			$width="6";
			$length="6";
			#$weight="4.00";
	
			$cart_product = array('productID'=>$productID,'length'=>$length,'width'=>$width,'height'=>$height,'weight'=>$weight);
			for($aaa=0;$aaa<$qty;$aaa++)
			{
				$shipping_products [] = $cart_product;
				
			}
		}
#	print("<tr>\n");
#	print("<tr>\n");
#	print("<td colspan=\"3\" align=\"right\"><span class=\"cart\"><b>Totals:</b>&nbsp;</span></td>\n");
#	$totfin=$carttot+$ship;
#	$totfinformat=number_format($totfin, 2, '.', ',');
#	$totformat=number_format($carttot, 2, '.', ',');
#	print("<td align=\"right\"><span class=\"cart\">$".$totfinformat."</span>&nbsp;&nbsp;&nbsp;</td>\n");
#	print("</tr>\n");

	print("<tr>\n");
	print("</tr>\n");
		print("<td></td>\n");

	print("</tr></form>\n");
	print("<td></td>\n");
	print("</tr>\n");
	print("<tr>\n");
	#if($combolimit<1){
	#print("<td colspan=\"3\" align=\"right\"><form method=\"post\" action=\"https://www.techniart.us/led/adda19.php\"><input type=\"hidden\" name=\"otsID\" value=\"".$o."\"><input type=\"submit\" value=\"Add A19 5-Pack\" class=\"btn1\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>\n");
	#print("</tr></form>\n");}
	#	if($brlimit<1){
	#print("<td colspan=\"3\" align=\"right\"><form method=\"post\" action=\"https://www.techniart.us/led/addbr30.php\"><input type=\"hidden\" name=\"otsID\" value=\"".$o."\"><input type=\"submit\" value=\"Add Water & Energy Kit\" class=\"btn1\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>\n");
	#print("</tr></form>\n");}
	#print("<tr>\n");
if($carttot>0){	
	print("<td colspan=\"3\" align=\"right\"><form method=\"post\" action=\"orderform.php\"><input type=\"hidden\" name=\"otsID\" value=\"".$o."\"><input type=\"submit\" value=\"Checkout\" class=\"btn1\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>\n");}
	else
	{	print("<td colspan=\"3\" align=\"right\"><form method=\"post\" action=\"orderform1.php\"><input type=\"hidden\" name=\"otsID\" value=\"".$o."\"><input type=\"submit\" value=\"Checkout\" class=\"btn1\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>\n");}

	print("</tr></form>\n");
	print("</table></form>\n");
}?>
</td>
  </tr>
</table>
</center>