<? include("database.php"); ?>
<?
$ID=$_GET['ID'];
$sql="delete from tblotsdetail_entrust where otsdetailID='$ID'";
$result=db_query($sql);
header("location: cart.php"); ?>