<?
include("../connect.php");



if($_POST["submit"]=="save_real"){

$sql="SELECT * FROM asset_name_out WHERE id = '".$_POST["id"]."' AND year = '".$_POST["year"]."'";
$result=mysqli_query($con,$sql)or die(mysqli_error());
//echo mysqli_affected_rows($result);
if($_POST["type"]=="budget_old"){
$table = "budget_true";
$year=$_POST["year"];
}else if($_POST["type"]=="budget_new"){
$table = "budget";
$year=$_POST["year"];
}else if($_POST["type"]=="other"){
$table = "other";
$year=$_POST["year"];
}

$rowcount=mysqli_num_rows($result);
if(!empty($rowcount)){
$strSQL="UPDATE asset_name_out SET ";
$strSQL.="$table ='".$_POST["val"]."' ";
//$strSQL.=",price='".$_POST["price"]."' ";
$strSQL.="WHERE id = '".$_POST["id"]."' AND year = '".$year."' ";
$objQuary = mysqli_query($con,$strSQL)or die(mysqli_error());
}else if($_POST["value"]>"0"){
$strSQL="INSERT INTO asset_name_out SET ";
$strSQL.="$table ='".$_POST["val"]."' ";
//$strSQL.=",barcode = '".$_POST["id"]."' ";
$strSQL.=",year = '".$year."' ";
$strSQL.=",id='".$_POST["id"]."' ";
$objQuary = mysqli_query($con,$strSQL)or die(mysqli_error());
}
//echo $strSQL;
}
?>