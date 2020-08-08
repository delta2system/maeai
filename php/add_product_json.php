<?
session_start();

include("../connect.inc");
if($_POST["plus"]!="" && $_POST["type_product"]=="add"){
$strSQL = "INSERT INTO group_type SET ";
$strSQL .="detail = '".$_POST["plus"]."' ";
$objQuery = mysql_query($strSQL);
}

if($_POST["type_product"]=="add"){
$sqlx = "SELECT code from group_type where name = '".$_POST["plus"]."'  limit 1  ";
list($id_type) = Mysql_fetch_row(Mysql_Query($sqlx));
$type_product=$id_type;
}else{
$type_product=$_POST["type_product"];
}


$sqlx = "SELECT barcode from stock_product where group_type = '".$type_product."' ORDER By barcode DESC limit 1  ";
list($barcodeOld) = Mysql_fetch_row(Mysql_Query($sqlx));
if($barcodeOld){
$txOld=substr($barcodeOld,0,2);
$bcOld=substr($barcodeOld,2);
$barcodeNew=$txOld.str_pad($bcOld+1,4,"0",STR_PAD_LEFT);
}else{
while($t<=0){
$randomString = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1);
$barcodeNew=$randomString.str_pad(1,4,"0",STR_PAD_LEFT);
$result = mysql_query("SELECT * FROM stock_product where barcode  = '$barcodeNew'");
if(mysql_num_rows($result)>=1){	$t=0;}else{$t=1;}
}
}


$strSQL = "INSERT INTO stock_product SET ";
$strSQL .="barcode = '".$barcodeNew."' ";
$strSQL .=",group_type = '".$type_product."' ";
$strSQL .=",detail = '".$_POST["detail_add"]."' ";
$strSQL .=",unit = '".$_POST["unit_add"]."' ";
//$strSQL .=",lasttime = '".date("Y/m/d H:s:i")."' ";
//$strSQL .=",status = 'Y' ";
$objQuery = mysql_query($strSQL);

// $strSQLi = "INSERT INTO stock_product_in SET ";
// $strSQLi .="barcode = '".$barcodeNew."' ";
// $strSQLi .=",group_type = '".$type_product."' ";
// $strSQLi .=",detail = '".$_POST["detail_add"]."' ";
// $strSQLi .=",unit = '".$_POST["unit_add"]."' ";
//$strSQLi .=",lasttime = '".date("Y/m/d H:s:i")."' ";
//$strSQLi .=",office = '".$_SESSION["xUser"]."' ";
//$strSQLi .=",status = 'A' ";
//$objQueryi = mysql_query($strSQLi);

echo $barcodeNew;
?>