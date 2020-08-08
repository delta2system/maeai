<?php
session_start();
include("connect.inc");

if($_POST["submit"]=="save_fix"){


  $sql = "SELECT code from store WHERE row_id = '".$_POST["row_store"]."'  ";
  list($code_store) = Mysql_fetch_row(Mysql_Query($sql));

$strSQL = "INSERT INTO tbl_repair SET "; 
$strSQL .="row_store = '".$_POST["row_store"]."' ";
$strSQL .=",code_store = '".$code_store."' ";
$strSQL .=",dateday = '".substr($_POST["dateday"],6,4)."-".substr($_POST["dateday"],3,2)."-".substr($_POST["dateday"],0,2)."'";
$strSQL .=",no_bill= '".$_POST["no_bill"]."'";
$strSQL .=",detail= '".$_POST["detail"]."'";
$strSQL .=",pcs= '".$_POST["pcs"]."'";
$strSQL .=",total_money= '".$_POST["total"]."'";
$strSQL .=",other= '".$_POST["other"]."'";
$strSQL .=",fix_finished= '".$_POST["fix_finished"]."'";
$strSQL .=",status= '2'";
$strSQL .=",officer= '".$_SESSION["xusername"]."'";
$objQuery = mysql_query($strSQL);


}else if($_POST["submit"]=="return_fix"){

  $strSQL = "SELECT * FROM tbl_repair WHERE row_store = '".$_POST["row"]."' ORDER By row_id DESC";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      if(mysql_field_name($objQuery,$i)=="dateday"){
        $arrCol["dateday"]=date_format(date_create($obResult[$i]),"d/m/Y");
      }
    }
    array_push($resultArray,$arrCol);
  }
  
  echo json_encode($resultArray);


}else if($_POST["submit"]=="return_store"){

  $strSQL = "SELECT * FROM store WHERE store_type like '".$_POST["type_store"]."' AND ".$_POST["search_order"]." like '%".$_POST["search"]."%' ORDER By ".$_POST["order"];
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

}else if($_POST["submit"]=="edit_fix"){

  $strSQL = "SELECT * FROM tbl_repair WHERE row_id = '".$_POST["row_id"]."' ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      if(mysql_field_name($objQuery,$i)=="dateday"){
        $arrCol["dateday"]=date_format(date_create($obResult[$i]),"d-m-Y");
      }
    }
    array_push($resultArray,$arrCol);
  }
  
  echo json_encode($resultArray);
}else if($_POST["submit"]=="update_fix"){



$strSQL = "UPDATE tbl_repair SET ";
$strSQL .="dateday = '".substr($_POST["dateday"],6,4)."-".substr($_POST["dateday"],3,2)."-".substr($_POST["dateday"],0,2)."'";
$strSQL .=",no_bill= '".$_POST["no_bill"]."'";
$strSQL .=",detail= '".$_POST["detail"]."'";
$strSQL .=",pcs= '".$_POST["pcs"]."'";
$strSQL .=",total_money= '".$_POST["total"]."'";
$strSQL .=",other= '".$_POST["other"]."'";
$strSQL .=",fix_finished= '".$_POST["fix_finished"]."'";
$strSQL .=",status= '2'";
$strSQL .=",officer= '".$_SESSION["xusername"]."'";
$strSQL .="WHERE row_id = '".$_POST["row_store"]."' ";
$objQuery = mysql_query($strSQL);

  $sql = "SELECT row_store from tbl_repair WHERE row_id = '".$_POST["row_store"]."'  ";
  list($row_store) = Mysql_fetch_row(Mysql_Query($sql));
  echo $row_store;
}else if($_POST["submit"]=="del_store"){
  $sql_del = "DELETE FROM store WHERE row_id = '".$_POST["row_tbl"]."' "; 
  $query = mysql_query($sql_del);

  $sql_del = "DELETE FROM tbl_repair WHERE row_store = '".$_POST["row_tbl"]."' "; 
  $query = mysql_query($sql_del);  

}
?>

    