<?
session_start();
include("connect.inc");

function mount($str){
switch($str)
{
case "01": $str = "ม.ค."; break;
case "02": $str = "ก.พ."; break;
case "03": $str = "มี.ค."; break;
case "04": $str = "เม.ย."; break;
case "05": $str = "พ.ค."; break;
case "06": $str = "มิ.ย."; break;
case "07": $str = "ก.ค."; break;
case "08": $str = "ส.ค."; break;
case "09": $str = "ก.ย."; break;
case "10": $str = "ต.ค."; break;
case "11": $str = "พ.ย."; break;
case "12": $str = "ธ.ค."; break;
}
return $str;
}


if($_POST["submit"]=="handle_qrcode"){

  $resultArray = array();
  $arrCol = array();
  if($_POST["pcs"]!=""){
  $pcs = $_POST["pcs"];
}else{
  $pcs = 1;
}
  // $row=explode("@",$_POST["qrcode"]);

  $sql = "SELECT * from substock WHERE barcode = '".$_POST["barcode"]."' AND department = '".$_POST["department"]."' ";
  $obj= mysql_fetch_assoc(Mysql_Query($sql));

  if($obj[pcs]>0){

  $sql = "SELECT unit from stock_product WHERE barcode = '".$_POST["barcode"]."' limit 1  ";
  list($unit) = Mysql_fetch_row(Mysql_Query($sql));

  $sql_update = "UPDATE substock SET pcs='".($obj[pcs]-$pcs)."' WHERE barcode = '".$_POST["barcode"]."' AND department = '".$_POST["department"]."' ";
  $result_update= mysql_query($sql_update) or die(mysql_error());


$strSQL = "INSERT INTO substock_out SET "; 
$strSQL .="dateday = '".date("Y-m-d")."' ";
$strSQL .=",department = '".$_POST["department"]."' ";
$strSQL .=",barcode = '".$_POST["barcode"]."' ";
$strSQL .=",pcs = '".$pcs."' ";
$strSQL .=",pcs_old = '".$obj[pcs]."' ";
$strSQL .=",officer = '".$_SESSION["xfullname"]."' ";
$objQuery = mysql_query($strSQL);

  $sql = "SELECT row_id from substock_out WHERE barcode = '".$_POST["barcode"]."' AND department = '".$_POST["department"]."' ORDER By row_id DESC limit 1 ";
  list($row_id) = Mysql_fetch_row(Mysql_Query($sql));


  $arrCol["pcs"]=$pcs;
  $arrCol["pcs_stock"]=$obj[pcs]-$pcs;
  $arrCol["detail"]=$obj[detail];
  $arrCol["expire"]= substr($obj["expire"],8,2)." ".mount(substr($obj["expire"],5,2))." ".substr($obj["expire"],0,4);
  $arrCol["unit"]=$unit;
  $arrCol["row_id"]=$row_id;
  $arrCol["department"]=$_POST["department"];

  $arrCol["status"]="1";
  }else{
  $arrCol["status"]="0";

  }
  array_push($resultArray,$arrCol);
  
  echo json_encode($resultArray);

}else if($_POST["submit"]=="del_sub_stock"){


$sql = "SELECT * from substock_out WHERE row_id = '".$_POST["row_id"]."' ";
$obj= mysql_fetch_assoc(Mysql_Query($sql));

$sql = "SELECT * from substock WHERE barcode = '".$obj["barcode"]."' AND department = '".$obj["department"]."' ";
$ost= mysql_fetch_assoc(Mysql_Query($sql));

$sql_update = "UPDATE substock SET pcs='".($ost["pcs"]+$obj["pcs"])."' WHERE barcode = '".$obj["barcode"]."' AND department = '".$obj["department"]."' ";
$result_update= mysql_query($sql_update) or die(mysql_error());

$sql_del = "DELETE FROM substock_out WHERE row_id = '".$_POST["row_id"]."' "; 
$query = mysql_query($sql_del);

}

?>