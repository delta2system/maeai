<?
session_start();

include("connect.inc");

$result = mysql_query("SELECT name FROM customer_supply where name = '".trim($_POST["name"])."'");
$num = mysql_num_rows($result);

if($num==0){
$strSQL = "INSERT INTO customer_supply SET ";
$strSQL .="name = '".trim($_POST["nameltd"])."' ";
$strSQL .=",address = '".trim($_POST["address"])."' ";
$strSQL .=",phone = '".trim($_POST["phone"])."' ";
$strSQL .=",fax = '".trim($_POST["fax"])."' ";
$objQuery = mysql_query($strSQL)or die(mysql_error());
}
echo $_POST["nameltd"];
?>
