<?
session_start();
include("connect.inc");
if($_POST["submit"]=="update_barcode"){

print_r($_POST);
$result = mysql_query("SELECT * FROM cal_budget_department where barcode = '".$_POST["barcode"]."' AND year = '".($_POST["year"]-543)."'");
$num = mysql_num_rows($result);

if(empty($num)){
$strSQL = "INSERT INTO cal_budget_department SET "; 
$strSQL .="department = '".$_POST["department"]."' ";
$strSQL .=",barcode = '".$_POST["barcode"]."' ";
$strSQL .=",m".$_POST["month"]." = '".$_POST["value"]."' ";
$strSQL .=",year = '".($_POST["year"]-543)."' ";
$objQuery = mysql_query($strSQL) or die(mysql_error());	

}else{

$sql_update = "UPDATE cal_budget_department SET ";
$sql_update .= "m".$_POST["month"]." = '".$_POST["value"]."' ";
$sql_update .="WHERE barcode = '".$_POST["barcode"]."' AND year = '".($_POST["year"]-543)."' AND department = '".$_POST["department"]."'";
$result_update= mysql_query($sql_update) or die(mysql_error());	
}

}else if($_POST["submit"]=="return_data"){
  $strSQL = "SELECT * FROM cal_budget_department WHERE year = '".(trim($_POST["year"])-543)."' AND department = '".$_POST["department"]."' ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_assoc($objQuery))
  {
    $arrCol = array();
    $obResult["total"]=$obResult["m1"]+$obResult["m2"]+$obResult["m3"]+$obResult["m4"]+$obResult["m5"]+$obResult["m6"]+$obResult["m7"]+$obResult["m8"]+$obResult["m9"]+$obResult["m10"]+$obResult["m11"]+$obResult["m12"];
    $arrCol = $obResult;
    array_push($resultArray,$arrCol);
  } 
  echo json_encode($resultArray);
}
?>