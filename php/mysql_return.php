<?php
session_start();
include("connect.inc");

if($_POST["submit"]=="return_customer"){

  $strSQL = "SELECT * FROM customer_supply WHERE code like '%".$_POST["search"]."%' OR name like '%".$_POST["search"]."%' ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
    }
    array_push($resultArray,$arrCol);
  }
  
  echo json_encode($resultArray);


}
?>

    