<?php
include("connect.php");



if($_POST["submit"]=="save_cal"){

$sql="SELECT * FROM cal_budget_year WHERE barcode = '".$_POST["id"]."' AND year = '".$_POST["year"]."'";
$result=mysqli_query($con,$sql)or die(mysqli_error());
//echo mysqli_affected_rows($result);
$rowcount=mysqli_num_rows($result);
if(!empty($rowcount)){
$strSQL="UPDATE cal_budget_year SET ";
$strSQL.="pcs='".$_POST["value"]."' ";
$strSQL.=",price='".$_POST["price"]."' ";
$strSQL.="WHERE barcode = '".$_POST["id"]."' AND year = '".$_POST["year"]."' ";
$objQuary = mysqli_query($con,$strSQL)or die(mysqli_error());
}else if($_POST["value"]>"0"){
$strSQL="INSERT INTO cal_budget_year SET ";
$strSQL.="pcs='".$_POST["value"]."' ";
$strSQL.=",barcode = '".$_POST["id"]."' ";
$strSQL.=",year = '".$_POST["year"]."' ";
$strSQL.=",price='".$_POST["price"]."' ";
$objQuary = mysqli_query($con,$strSQL)or die(mysqli_error());
}
//echo $strSQL;
}

?>