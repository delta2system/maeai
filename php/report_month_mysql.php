<?session_start();
include("connect.inc");
 if($_POST["submit"]=="return_data"){

  $strSQL = "SELECT *,sum(pcs),sum(pcs*price) FROM bill WHERE nobill_system like 'OWH%' AND dateday like '".$_POST["y"]."-".$_POST["m"]."%' GROUP By customer_id";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  $total_warehouse=array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
    }
    array_push($total_warehouse, $arrCol["sum(pcs*price)"]);
    $arrCol["sum_warehouse"]= array_sum($total_warehouse);
    array_push($resultArray,$arrCol);
  }
  
  //mysql_close($Conn);
  
  echo json_encode($resultArray);

}else if($_POST["submit"]=="return_copysheet"){


$sql = "SELECT sum(total) from copy_sheet where dateday like '".$_POST["y"]."-".$_POST["m"]."%'  ";
list($sumtotal) = Mysql_fetch_row(Mysql_Query($sql));

echo $sumtotal;


}else if($_POST["submit"]=="return_fule"){

$sql = "SELECT sum(total) from fuel_tank where dateday like '".$_POST["y"]."-".$_POST["m"]."%' AND bill like 'OLP%' ";
list($sumtotal) = Mysql_fetch_row(Mysql_Query($sql));

echo $sumtotal;
}else if($_POST["submit"]=="update_pcstotal"){

$result = mysql_query("SELECT * FROM data_pcstotal where year = '".$_POST["y"]."' AND month = '".$_POST["m"]."' AND title_code = '1' ");
$num = mysql_num_rows($result);

if($num==0){

$strSQL = "INSERT INTO data_pcstotal SET ";
$strSQL .="year = '".$_POST["y"]."' ";
$strSQL .=",month = '".$_POST["m"]."' ";
$strSQL .=",title_code = '1' ";
$strSQL .=",title = 'รวมคงคลัง' ";
$strSQL .=",value = '".str_replace(",","",$_POST["data"])."' ";
$objQuery = mysql_query($strSQL);

}else{

$strSQL = "UPDATE data_pcstotal SET ";
$strSQL .="value = '".str_replace(",","",$_POST["data"])."' ";
$strSQL .="WHERE year = '".$_POST["y"]."' ";
$strSQL .="AND month = '".$_POST["m"]."' ";
$strSQL .="AND title_code = '1' ";
$objQuery = mysql_query($strSQL);  


}


}else if($_POST["submit"]=="return_pcstotal"){

$sql = "SELECT value FROM data_pcstotal where year = '".$_POST["y"]."' AND month = '".$_POST["m"]."' AND title_code = '1' ";
list($sumtotal) = Mysql_fetch_row(Mysql_Query($sql));

if($sumtotal!=null){
  echo number_format($sumtotal,2);
}


}else if($_POST["submit"]=="fuel_set"){

$result = mysql_query("SELECT * FROM data_pcstotal where year = '".$_POST["y"]."' AND month = '".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."' AND title_code = '2' ");
$num = mysql_num_rows($result);

if($num==0){

$strSQL = "INSERT INTO data_pcstotal SET ";
$strSQL .="year = '".$_POST["y"]."' ";
$strSQL .=",month = '".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."' ";
$strSQL .=",title_code = '2' ";
$strSQL .=",title = 'น้ำมันสำรองคงคลัง' ";
$strSQL .=",value = '".str_replace(",","",$_POST["data"])."' ";
$objQuery = mysql_query($strSQL);

}else{

$strSQL = "UPDATE data_pcstotal SET ";
$strSQL .="value = '".str_replace(",","",$_POST["data"])."' ";
$strSQL .="WHERE year = '".$_POST["y"]."' ";
$strSQL .="AND month = '".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."' ";
$strSQL .="AND title_code = '2' ";
$objQuery = mysql_query($strSQL);  


}


}else if($_POST["submit"]=="fuel_t_return"){
function decimon($str){
  if($str!="" || $str!=0){
    $str= number_format($str,2);
  }else{
    $str = "";
  }
  return $str;
}


  $resultArray = array();
  $arrCol = array();
  $fuelttotal = array();
for($i=10;$i<=12;$i++){

$sql = "SELECT value from data_pcstotal where year = '".($_POST["y"]-1)."' AND month = '".str_pad($i,2,'0',STR_PAD_LEFT)."' AND title_code = '2'";
list($value) = Mysql_fetch_row(Mysql_Query($sql));
  $arrCol["fuelt$i"]=decimon($value);
  array_push($fuelttotal,$value);
}
for($i=1;$i<=9;$i++){

$sql = "SELECT value from data_pcstotal where year = '".$_POST["y"]."' AND month = '".str_pad($i,2,'0',STR_PAD_LEFT)."' AND title_code = '2'";
list($value) = Mysql_fetch_row(Mysql_Query($sql));
  $arrCol["fuelt$i"]=decimon($value);
  array_push($fuelttotal,$value);
}

  $arrCol["fuelttotal"]=decimon(array_sum($fuelttotal));


    array_push($resultArray,$arrCol);
  //mysql_close($Conn);
  
  echo json_encode($resultArray);

}
?>
