<?php
session_start();
include("connect.inc");
function grouptype($str){
$sql = "SELECT group_type from stock_product where barcode = '$str'  limit 1  ";
list($grouptype) = Mysql_fetch_row(Mysql_Query($sql));
return $grouptype;
}

function thai_month($mm) {
switch($mm) {
case '01' : $month = "ม.ค."; break;
case '02' : $month = "ก.พ.";break;
case '03' : $month = "มี.ค.";break;
case '04' : $month = "เม.ย.";break;
case '05' : $month = "พ.ค";break;
case '06' : $month = "มิ.ย.";break;
case '07' : $month = "ก.ค.";break;
case '08' : $month = "ส.ค.";break;
case '09' : $month = "ก.ย.";break;
case '10' : $month = "ต.ค.";break;
case '11' : $month = "พ.ย.";break;
case '12' : $month = "ธ.ค.";break;
}
return $month;
}

function comma_price($str){
  if($str!=""){
  $str_new1 = number_format($str,2);
  $str_new2 = str_replace(",","",$str_new1);
  return $str_new2;
  }else{
    return "0.00";
  }
}
if($_POST["submit"]=="check_product"){


$result = mysql_query("SELECT * FROM stock_product where barcode = '".$_POST["barcode"]."'");
$num = mysql_num_rows($result);
$resultArray = array();
$arrCol = array();

   if($num){
   	$arrCol["status"] = "true";
   	$arrCol["Messenger"] = "มีสินค้าในสต็อก";
   	$arrCol["barcode"] = $_POST["barcode"];
   }else{
   	$arrCol["status"] = "false";
   	$arrCol["Messenger"] = "ไม่มีสินค้าในสต็อก";
   	$arrCol["barcode"] = $_POST["barcode"];
   }
   array_push($resultArray,$arrCol);
   echo json_encode($resultArray);
}else if($_POST["submit"]=="insert_product"){



$result = mysql_query("SELECT * FROM bill_real where barcode = '".$_POST["barcode"]."' AND status = '".$_POST["status"]."' AND ipaddress = '".$_SERVER['REMOTE_ADDR']."'");
$num = mysql_num_rows($result);

if(empty($num)){

  // $strSQL = "SELECT detail,SUM(pcs),price_in FROM stock_product where barcode = '".$_POST["barcode"]."' GROUP By barcode ORDER By row_id DESC limit 1 ";
  // $objQuery = mysql_query($strSQL) or die (mysql_error());
  // $intNumField = mysql_num_fields($objQuery);
  // while($obResult = mysql_fetch_array($objQuery))
  // {
  //   $arrCol = array();
  //   for($i=0;$i<$intNumField;$i++)
  //   {
  //     $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
  //   }
  // }
   $sql = "SELECT detail,SUM(pcs),price_in FROM stock_product where barcode = '".$_POST["barcode"]."' GROUP By barcode ORDER By row_id DESC limit 1 ";
   list($detail,$pcs,$price_in) = Mysql_fetch_row(Mysql_Query($sql));

$dateday=substr($_POST["dateday"],6,4)."-".substr($_POST["dateday"],3,2)."-".substr($_POST["dateday"],0,2);

$strSQL = "INSERT INTO bill_real SET "; 
$strSQL .="nobill = '".$_POST["nobill"]."' ";
$strSQL .=",code_supply = '".$_POST["code_supply"]."' ";
$strSQL .=",code_persanal = '".$_POST["code_persanal"]."' ";
$strSQL .=",creditor_bill = '".$_POST["order_bill"]."' ";
$strSQL .=",dateday = '".$dateday."' ";
$strSQL .=",timelast = '".date("H:i:s")."' ";
$strSQL .=",barcode = '".$_POST["barcode"]."' ";
$strSQL .=",detail = '".$detail."' ";
$strSQL .=",pcs = '".$_POST["pcs"]."' ";
$strSQL .=",laststock = '".$pcs."' ";
$strSQL .=",price = '".comma_price($price_in)."' ";
$strSQL .=",ipaddress = '".$_SERVER['REMOTE_ADDR']."' ";
$strSQL .=",status = '".$_POST["status"]."' ";
$strSQL .=",officer = '".$_SESSION["xusername"]."' ";
$objQuery = mysql_query($strSQL);
}else{


$sql = "SELECT pcs  FROM bill_real where barcode = '".$_POST["barcode"]."' AND ipaddress = '".$_SERVER['REMOTE_ADDR']."' AND status = '".$_POST["status"]."' limit 1  ";
list($pcs) = Mysql_fetch_row(Mysql_Query($sql));


$sql_update = "UPDATE bill_real SET pcs='".($pcs+$_POST["pcs"])."' where barcode = '".$_POST["barcode"]."' AND status = '".$_POST["status"]."' AND ipaddress = '".$_SERVER['REMOTE_ADDR']."' ";
$result_update= mysql_query($sql_update) or die(mysql_error());


}

}else if($_POST["submit"]=="return_bill"){



  $strSQL = "SELECT * FROM bill_real WHERE status = '".$_POST["status"]."' AND ipaddress = '".$_SERVER['REMOTE_ADDR']."' ";
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
    $arrCol["total"]=($arrCol["price"]*$arrCol["pcs"]);
    if($_POST["status"]=="INV"){
    $arrCol["stock_total"]=$arrCol["laststock"]+$arrCol["pcs"];
  }else if($_POST["status"]=="OWH"){
    $arrCol["stock_total"]=$arrCol["laststock"]-$arrCol["pcs"];
  }

    if($_POST["status"]=="INV"){
    $sql_supply = "SELECT name from customer_supply where code = '".$arrCol[code_supply]."'  limit 1  ";
    list($name_supply) = Mysql_fetch_row(Mysql_Query($sql_supply));
  }else{
    $sql_supply = "SELECT name from department where code = '".$arrCol[code_supply]."'  limit 1  ";
    list($name_supply) = Mysql_fetch_row(Mysql_Query($sql_supply)); 
  }
    $sql_persanal = "SELECT name from personal where code = '".$arrCol[code_persanal]."'  limit 1  ";
    list($name_persanal) = Mysql_fetch_row(Mysql_Query($sql_persanal));

    $sql_unit = "SELECT unit from stock_product where barcode = '".$arrCol[barcode]."'  limit 1  ";
    list($unit) = Mysql_fetch_row(Mysql_Query($sql_unit));

    $arrCol["unit"]=$unit;
    $arrCol["name_supply"]=$name_supply;
    $arrCol["name_persanal"]=$name_persanal;

    array_push($resultArray,$arrCol);
  }
  
  echo json_encode($resultArray);


}else if($_POST["submit"]=="del_billreal_row"){

  $sql_del = "DELETE FROM bill_real WHERE row_id = '".$_POST["row_id"]."' "; 
  $query = mysql_query($sql_del);

}else if($_POST["submit"]=="set_value"){
  $sql_update = "UPDATE bill_real SET ".$_POST["tbl"]." ='".$_POST["value"]."' where row_id = '".$_POST["row_id"]."'  ";
$result_update= mysql_query($sql_update) or die(mysql_error());
}else if($_POST["submit"]=="update_other"){

$sql_update = "UPDATE bill_real SET other ='".$_POST["value"]."' where row_id = '".$_POST["row_id"]."'  ";
$result_update= mysql_query($sql_update) or die(mysql_error());

}else if($_POST["submit"]=="save_in"){

  $sql = "SELECT nobill_system from bill WHERE status = 'INV' ORDER By nobill_system DESC  limit 1  ";
  list($nobill_system) = Mysql_fetch_row(Mysql_Query($sql));
  if(empty($nobill_system) || substr($nobill_system,4,4)!=((date("y")+43).date("m"))){
  $new_nobill_system ="INV-".(date("y")+43).date("m")."00001"; 
  }else{
  $new_bill=substr($nobill_system,8)+1;
  $new_nobill_system = "INV-".(date("y")+43).date("m").str_pad($new_bill, 5,"0",STR_PAD_LEFT);
  }


  $strSQL_qu = "SELECT * FROM bill_real WHERE status = '".$_POST["status"]."' AND ipaddress = '".$_SERVER['REMOTE_ADDR']."' ";
  $objQuery_qu = mysql_query($strSQL_qu) or die (mysql_error());
  while($obResult = mysql_fetch_array($objQuery_qu))
  {
   
$sql_pcs = "SELECT pcs from stock_product where barcode = '".$obResult["barcode"]."' AND price_in = '".comma_price($obResult["price"])."'  limit 1  ";
$num_pcs = mysql_num_rows(Mysql_Query($sql_pcs));
if($num_pcs){
list($laststock) = Mysql_fetch_row(Mysql_Query($sql_pcs));


$sql_update = "UPDATE stock_product SET pcs='".($laststock+$obResult["pcs"])."',lastin = '".date("Y-m-d H:s:i")."' WHERE barcode = '".$obResult["barcode"]."' AND price_in = '".comma_price($obResult["price"])."'";
$result_update= mysql_query($sql_update) or die(mysql_error());

}else{
  $laststock=0;

$sql_pcs = "SELECT group_type,unit from stock_product where barcode = '".$obResult["barcode"]."' limit 1  ";
list($re_group_type,$re_unit) = Mysql_fetch_row(Mysql_Query($sql_pcs));

$strSQL = "INSERT INTO stock_product SET "; 
$strSQL .="barcode = '".$obResult["barcode"]."' ";
$strSQL .=",detail = '".$obResult["detail"]."' ";
$strSQL .=",price_in = '".comma_price($obResult["price"])."' ";
$strSQL .=",group_type = '".$re_group_type."' ";
$strSQL .=",pcs = '".$obResult["pcs"]."' ";
$strSQL .=",unit = '".$re_unit."' ";
$strSQL .=",lastin = '".date("Y-m-d H:i:s")."' ";
$strSQL .=",lastupdate = '".date("Y-m-d H:i:s")."' ";
$objQuery = mysql_query($strSQL);

}

$dateday=substr($_POST["dateday"],6,4)."-".substr($_POST["dateday"],3,2)."-".substr($_POST["dateday"],0,2);

$strSQL = "INSERT INTO bill SET "; 
$strSQL .="nobill_system = '".$new_nobill_system."' ";
$strSQL .=",nobill = '".$_POST["nobill"]."' ";
$strSQL .=",nobill_recipt = '".$_POST["order_bill"]."' ";
$strSQL .=",dateday = '".$dateday."' ";
$strSQL .=",lasttime = '".date("H:i:s")."' ";
$strSQL .=",customer_id = '".$_POST["customer_id"]."' ";
$strSQL .=",customer_name = '".$_POST["customer_name"]."' ";
$strSQL .=",persanal = '".$_POST["persanal_id"]."' ";
$strSQL .=",group_type = '".grouptype($obResult["barcode"])."' ";
$strSQL .=",barcode = '".$obResult["barcode"]."' ";
$strSQL .=",detail = '".$obResult["detail"]."' ";
$strSQL .=",laststock = '".$laststock."' ";
$strSQL .=",pcs = '".$obResult["pcs"]."' ";
$strSQL .=",price = '".comma_price($obResult["price"])."' ";
$strSQL .=",pcs_stock = '".($laststock+$obResult["pcs"])."' ";
//$strSQL .=",other = '".$obResult["other"]."' ";
$strSQL .=",status = '".$_POST["status"]."' ";
$strSQL .=",officer = '".$_SESSION["xusername"]."' ";
$objQuery = mysql_query($strSQL);


  }

  $sql_del = "DELETE FROM bill_real WHERE status = '".$_POST["status"]."' AND ipaddress = '".$_SERVER['REMOTE_ADDR']."' "; 
  $query = mysql_query($sql_del);
  echo $new_nobill_system;

}else if($_POST["submit"]=="cancel_in"){
  $sql_del = "DELETE FROM bill_real WHERE status = '".$_POST["status"]."' AND ipaddress = '".$_SERVER['REMOTE_ADDR']."' "; 
  $query = mysql_query($sql_del);
}else if($_POST["submit"]=="new_barocde_return"){


$sql = "SELECT barcode from stock_product where group_type = '".$_POST["group_type"]."'  ORDER By barcode DESC limit 1  ";
list($barcode) = Mysql_fetch_row(Mysql_Query($sql));
$nu='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
if(substr_count($nu, substr($barcode,0,1))){
  $deci=strlen($barcode)-1;
  $newx=substr($barcode,0,1);
  $xbarcode=substr($barcode,1)+1;
  echo $newx.str_pad($xbarcode,$deci,"0",STR_PAD_LEFT); 
}else{
  $deci=strlen($barcode);
  $xbarcode=$barcode+1;
  echo $newx.str_pad($xbarcode,$deci,"0",STR_PAD_LEFT);

}
//echo $barcode;
}else if($_POST["submit"]=="save_new_product"){

$strSQL = "INSERT INTO stock_product SET "; 
$strSQL .="barcode = '".$_POST["barcode"]."' ";
$strSQL .=",qrcode = '".$_POST["qrcode"]."' ";
$strSQL .=",detail = '".$_POST["detail"]."' ";
$strSQL .=",price_in = '".comma_price($_POST["price"])."' ";
$strSQL .=",group_type = '".$_POST["group_type"]."' ";
$strSQL .=",unit = '".$_POST["unit"]."' ";
$strSQL .=",pcs = '0' ";
$strSQL .=",lastin = '".date("Y-m-d H:i:s")."' ";
$objQuery = mysql_query($strSQL);

$resultArray = array();
$arrCol = array();

   if($objQuery){
    $arrCol["status"] = "true";
    $arrCol["Messenger"] = "บันทึกสำเร็จ";
    $arrCol["barcode"] = $_POST["barcode"];
   }else{
    $arrCol["status"] = "false";
    $arrCol["Messenger"] = "ไม่สามารถบันทึกได้";
    $arrCol["barcode"] = $_POST["barcode"];
   }
   array_push($resultArray,$arrCol);
   echo json_encode($resultArray);

}else if($_POST["submit"]=="new_group"){

$strSQL = "INSERT INTO group_type SET "; 
$strSQL .="code = '".$_POST["code"]."' ";
$strSQL .=",detail = '".$_POST["name"]."' ";
$objQuery = mysql_query($strSQL);

}else if($_POST["submit"]=="stock_search"){

  if($_POST["group_type"]!='all' && $_POST["group_type"]!=""){
    $search = "WHERE group_type = '".$_POST["group_type"]."' AND ( detail like '%".$_POST["search"]."%' OR barcode like '%".$_POST["search"]."%' OR qrcode like '%".$_POST["search"]."%')";
  }else if($_POST["group_type"]=='' && $_POST["search"]!=""){
    $search = "WHERE  detail like '%".$_POST["search"]."%' OR barcode like '%".$_POST["search"]."%' OR qrcode like '%".$_POST["search"]."%'";
  }else if($_POST["group_type"]=='all' && $_POST["search"]==""){
    $search = "";
  }else{
    $search = "";
  }

  $strSQL = "SELECT * FROM stock_product $search ORDER By barcode ASC";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      
      if(mysql_field_name($objQuery,$i)=="group_type"){
        $sql = "SELECT detail from group_type where code = '$obResult[$i]'  limit 1  ";
        list($detail) = Mysql_fetch_row(Mysql_Query($sql));
        $arrCol["group_name"]=$detail;
      }else if(mysql_field_name($objQuery,$i)=="lastupdate"){

        $arrCol[mysql_field_name($objQuery,$i)] = date_format(date_create($obResult[$i]),"d-m-Y H:i:s");
      }else{
        $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      }
    }

    array_push($resultArray,$arrCol);
  }
    echo json_encode($resultArray);
}else if ($_POST["submit"]=="product_rowid_edit") {
 $strSQL = "SELECT * FROM stock_product WHERE row_id = '".$_POST["row_id"]."' ORDER By barcode ASC";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      
      if(mysql_field_name($objQuery,$i)=="group_type"){
        $sql = "SELECT detail from group_type where code = '$obResult[$i]'  limit 1  ";
        list($detail) = Mysql_fetch_row(Mysql_Query($sql));
        $arrCol["group_name"]=$detail;
        $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      }else if(mysql_field_name($objQuery,$i)=="lastupdate"){

        $arrCol[mysql_field_name($objQuery,$i)] = date_format(date_create($obResult[$i]),"d-m-Y H:i:s");
      }else{
        $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      }
    }

    array_push($resultArray,$arrCol);
  }
    echo json_encode($resultArray);
}else if($_POST["submit"]=="save_edit_product"){

$strSQL = "UPDATE stock_product SET ";
$strSQL .="barcode = '".$_POST["barcode"]."' ";
$strSQL .=",detail = '".$_POST["detail"]."' ";
$strSQL .=",price_in = '".comma_price($_POST["price"])."' ";
$strSQL .=",group_type = '".$_POST["group_type"]."' ";
$strSQL .=",unit = '".$_POST["unit"]."' ";
$strSQL .=",pcs = '".$_POST["pcs"]."' ";
$strSQL .=",limit_stock = '".$_POST["limit_stock"]."' ";
$strSQL .=",lastupdate = '".date("Y-m-d H:i:s")."' ";
$strSQL .=",officer_last = '".$_SESSION["xusername"]."' ";
$strSQL .="WHERE row_id = '".$_POST["row_id"]."' ";
$objQuery = mysql_query($strSQL);

$resultArray = array();
$arrCol = array();

   if($objQuery){
    $arrCol["status"] = "true";
    $arrCol["Messenger"] = "บันทึกสำเร็จ";
    $arrCol["barcode"] = $_POST["barcode"];
   }else{
    $arrCol["status"] = "false";
    $arrCol["Messenger"] = "ไม่สามารถบันทึกได้";
    $arrCol["barcode"] = $_POST["barcode"];
   }
   array_push($resultArray,$arrCol);
   echo json_encode($resultArray);

}else if($_POST["submit"]=="save_take"){

  $sql = "SELECT nobill_system from bill WHERE status = 'OWH' ORDER By nobill_system DESC  limit 1  ";
  list($nobill_system) = Mysql_fetch_row(Mysql_Query($sql));
  if(empty($nobill_system) ){
  $new_nobill_system ="OWH-".(date("y")+43).date("m")."00001"; 
  }else if(substr($nobill_system,4,4)!= (date("y")+43).date("m")){
    $new_nobill_system ="OWH-".(date("y")+43).date("m")."00001"; 
  
  }else{
  $new_bill=substr($nobill_system,8)+1;
  $new_nobill_system = "OWH-".(date("y")+43).date("m").str_pad($new_bill, 5,"0",STR_PAD_LEFT);
  }


  $strSQL_qu = "SELECT * FROM bill_real WHERE status = '".$_POST["status"]."' AND officer = '".$_SESSION['xusername']."' ";
  $objQuery_qu = mysql_query($strSQL_qu) or die (mysql_error());
  while($obResult = mysql_fetch_array($objQuery_qu))
  {
   
// $sql_pcs = "SELECT pcs from stock_product where barcode = '".$obResult["barcode"]."' AND price_in = '".$obResult["price"]."'  limit 1  ";
// $num_pcs = mysql_num_rows(Mysql_Query($sql_pcs));
// if($num_pcs){
// list($laststock) = Mysql_fetch_row(Mysql_Query($sql_pcs));
// $laststock_new=$laststock-$obResult["pcs"];

// $sql_update = "UPDATE stock_product SET pcs='".$laststock_new."',lastupdate = '".date("Y-m-d H:s:i")."' ,officer_last = '".$_SESSION["xusername"]."' WHERE barcode = '".$obResult["barcode"]."' AND price_in = '".$obResult["price"]."'";
// $result_update= mysql_query($sql_update) or die(mysql_error());

// }
$out = $obResult["pcs"];
$dateday=substr($_POST["dateday"],6,4)."-".substr($_POST["dateday"],3,2)."-".substr($_POST["dateday"],0,2);
$sql="SELECT * FROM stock_product where barcode = '".$obResult["barcode"]."' AND pcs > '0' ORDER By lastin ASC";
$result = mysql_query($sql);
while($data = mysql_fetch_array($result)){
  $i++;
  if($out <= $data[pcs] && $i==1 && $out !="0"){
    $lastpcs=$data[pcs]-$out;



$strSQL = "INSERT INTO bill SET "; 
$strSQL .="nobill_system = '".$new_nobill_system."' ";
$strSQL .=",nobill = '".$_POST["nobill"]."' ";
$strSQL .=",dateday = '".$dateday."' ";
$strSQL .=",lasttime = '".date("H:i:s")."' ";
$strSQL .=",customer_id = '".$_POST["customer_id"]."' ";
$strSQL .=",customer_name = '".$_POST["customer_name"]."' ";
$strSQL .=",persanal = '".$_POST["persanal_id"]."' ";
$strSQL .=",group_type = '".grouptype($data["barcode"])."' ";
$strSQL .=",barcode = '".$data["barcode"]."' ";
$strSQL .=",detail = '".$data["detail"]."' ";
$strSQL .=",laststock = '".$data["pcs"]."' ";
$strSQL .=",pcs = '".$out."' ";
$strSQL .=",price = '".comma_price($data["price_in"])."' ";
$strSQL .=",pcs_stock = '".$lastpcs."' ";
$strSQL .=",other = '".$obResult["other"]."' ";
$strSQL .=",status = '".$_POST["status"]."' ";
$strSQL .=",officer = '".$_SESSION["xusername"]."' ";
$objQuery = mysql_query($strSQL);

    $sql_update = "UPDATE stock_product SET pcs='".$lastpcs."',lastupdate='".date("Y-m-d H:s:i")."',officer_last='".$_SESSION["xusername"]."' where row_id = '$data[row_id]' ";
    $result_update= mysql_query($sql_update) or die(mysql_error());

  $out = 0;
  }else if($out > $data[pcs] && $i==1 && $out !="0"){
    $lastpcs=$out-$data[pcs];
    $out = $lastpcs;

$strSQL = "INSERT INTO bill SET "; 
$strSQL .="nobill_system = '".$new_nobill_system."' ";
$strSQL .=",nobill = '".$_POST["nobill"]."' ";
$strSQL .=",dateday = '".$dateday."' ";
$strSQL .=",lasttime = '".date("H:i:s")."' ";
$strSQL .=",customer_id = '".$_POST["customer_id"]."' ";
$strSQL .=",customer_name = '".$_POST["customer_name"]."' ";
$strSQL .=",persanal = '".$_POST["persanal_id"]."' ";
$strSQL .=",group_type = '".grouptype($data["barcode"])."' ";
$strSQL .=",barcode = '".$data["barcode"]."' ";
$strSQL .=",detail = '".$data["detail"]."' ";
$strSQL .=",laststock = '".$data["pcs"]."' ";
$strSQL .=",pcs = '".$data["pcs"]."' ";
$strSQL .=",price = '".comma_price($data["price_in"])."' ";
$strSQL .=",pcs_stock = '0' ";
$strSQL .=",other = '".$obResult["other"]."' ";
$strSQL .=",status = '".$_POST["status"]."' ";
$strSQL .=",officer = '".$_SESSION["xusername"]."' ";
$objQuery = mysql_query($strSQL);

    $sql_update = "UPDATE stock_product SET pcs='0',lastupdate='".date("Y-m-d H:s:i")."',officer_last='".$_SESSION["xusername"]."' where row_id = '$data[row_id]' ";
    $result_update= mysql_query($sql_update) or die(mysql_error());
    //print "<br>";
  }else if($out > $data[pcs] && $i>1 && $out !="0"){
    $lastpcs=$out-$data[pcs];
    $out = $lastpcs;
    $strSQL = "INSERT INTO bill SET "; 
$strSQL .="nobill_system = '".$new_nobill_system."' ";
$strSQL .=",nobill = '".$_POST["nobill"]."' ";
$strSQL .=",dateday = '".$dateday."' ";
$strSQL .=",lasttime = '".date("H:i:s")."' ";
$strSQL .=",customer_id = '".$_POST["customer_id"]."' ";
$strSQL .=",customer_name = '".$_POST["customer_name"]."' ";
$strSQL .=",persanal = '".$_POST["persanal_id"]."' ";
$strSQL .=",group_type = '".grouptype($data["barcode"])."' ";
$strSQL .=",barcode = '".$data["barcode"]."' ";
$strSQL .=",detail = '".$data["detail"]."' ";
$strSQL .=",laststock = '".$data["pcs"]."' ";
$strSQL .=",pcs = '".$data["pcs"]."' ";
$strSQL .=",price = '".comma_price($data["price_in"])."' ";
$strSQL .=",pcs_stock = '0' ";
$strSQL .=",other = '".$obResult["other"]."' ";
$strSQL .=",status = '".$_POST["status"]."' ";
$strSQL .=",officer = '".$_SESSION["xusername"]."' ";
$objQuery = mysql_query($strSQL);

    $sql_update = "UPDATE stock_product SET pcs='0',lastupdate='".date("Y-m-d H:s:i")."',officer_last='".$_SESSION["xusername"]."' where row_id = '$data[row_id]' ";    
    $result_update= mysql_query($sql_update) or die(mysql_error());
    //print "<br>";
  }else if($out <= $data[pcs] && $i>1 && $out !="0"){
    $lastpcs=$data[pcs]-$out;
    

    $strSQL = "INSERT INTO bill SET "; 
$strSQL .="nobill_system = '".$new_nobill_system."' ";
$strSQL .=",nobill = '".$_POST["nobill"]."' ";
$strSQL .=",dateday = '".$dateday."' ";
$strSQL .=",lasttime = '".date("H:i:s")."' ";
$strSQL .=",customer_id = '".$_POST["customer_id"]."' ";
$strSQL .=",customer_name = '".$_POST["customer_name"]."' ";
$strSQL .=",persanal = '".$_POST["persanal_id"]."' ";
$strSQL .=",group_type = '".grouptype($data["barcode"])."' ";
$strSQL .=",barcode = '".$data["barcode"]."' ";
$strSQL .=",detail = '".$data["detail"]."' ";
$strSQL .=",laststock = '".$data["pcs"]."' ";
$strSQL .=",pcs = '".$out."' ";
$strSQL .=",price = '".comma_price($data["price_in"])."' ";
$strSQL .=",pcs_stock = '".$lastpcs."' ";
$strSQL .=",other = '".$obResult["other"]."' ";
$strSQL .=",status = '".$_POST["status"]."' ";
$strSQL .=",officer = '".$_SESSION["xusername"]."' ";
$objQuery = mysql_query($strSQL);

      $sql_update = "UPDATE stock_product SET pcs='$lastpcs',lastupdate='".date("Y-m-d H:s:i")."',officer_last='".$_SESSION["xusername"]."' where row_id = '$data[row_id]' "; 
    $result_update= mysql_query($sql_update) or die(mysql_error());
    $out=0;
    //print "<br>";
  }

}

  }

  $sql_del = "DELETE FROM bill_real WHERE status = '".$_POST["status"]."' AND ipaddress = '".$_SERVER['REMOTE_ADDR']."' "; 
  $query = mysql_query($sql_del);
  echo $new_nobill_system;

}else if($_POST["submit"]=="edit_profile"){

$strSQL = "UPDATE user_account SET ";
$strSQL .="email = '".$_POST["email"]."' ";
$strSQL .=",fullname = '".$_POST["fullname"]."' ";
$strSQL .=",position = '".$_POST["position"]."' ";
$strSQL .="WHERE username = '".$_SESSION["xusername"]."' ";
$objQuery = mysql_query($strSQL); 

   if($objQuery){
   echo "true";
  }else{
    echo "false";
  }


}else if($_POST["submit"]=="edit_password"){

$resultArray = array();
$arrCol = array();

$SQL = "SELECT * FROM user_account where username = '".$_SESSION["xusername"]."' AND passwd = '".$_POST["old_password"]."'";
$result = mysql_query($SQL);
if(mysql_num_rows($result)){


$strSQL = "UPDATE user_account SET ";
$strSQL .="passwd = '".$_POST["new_password"]."' ";
$strSQL .="WHERE username = '".$_SESSION["xusername"]."' ";
$objQuery = mysql_query($strSQL); 

    $arrCol["status"] = "true";
    $arrCol["Messenger"] = "บันทึกสำเร็จ";
    //$arrCol["barcode"] = $_POST["barcode"];

}else{
    $arrCol["status"] = "false";
    $arrCol["Messenger"] = "รหัสผ่านเดิม ไม่ถูกต้อง";
   // $arrCol["barcode"] = $_POST["barcode"];
}

   array_push($resultArray,$arrCol);
   echo json_encode($resultArray);


}else if($_POST["submit"]=="edit_company"){


$sql_update = "UPDATE tbl_company SET tbl_value='".$_POST["company_name"]."' WHERE tbl_title='company_name' ";
$result_update= mysql_query($sql_update) or die(mysql_error());

$sql_update = "UPDATE tbl_company SET tbl_value='".$_POST["address"]."' WHERE tbl_title='address' ";
$result_update= mysql_query($sql_update) or die(mysql_error());

$sql_update = "UPDATE tbl_company SET tbl_value='".$_POST["phone"]."' WHERE tbl_title='phone' ";
$result_update= mysql_query($sql_update) or die(mysql_error());

$sql_update = "UPDATE tbl_company SET tbl_value='".$_POST["fax"]."' WHERE tbl_title='fax' ";
$result_update= mysql_query($sql_update) or die(mysql_error());

$sql_update = "UPDATE tbl_company SET tbl_value='".$_POST["web"]."' WHERE tbl_title='web' ";
$result_update= mysql_query($sql_update) or die(mysql_error());


   if($result_update){
   echo "true";
  }else{
    echo "false";
  }

}else if($_POST["submit"]=="del_product"){

$sql_del = "DELETE FROM stock_product WHERE row_id = '".$_POST["row_id"]."'"; 
$query = mysql_query($sql_del);

}else if($_POST["submit"]=="warehousein_edit"){

  if($_POST["tbltable"]=="dateday"){
    $tbldata=substr($_POST["tbldata"],6,4)."-".substr($_POST["tbldata"],3,2)."-".substr($_POST["tbldata"],0,2);
  }else{
    $tbldata=$_POST["tbldata"];
  }

  $strSQL = "SELECT * FROM bill WHERE ".$_POST["tbltable"]." like '%".$tbldata."%' AND status = 'INV' ORDER By dateday DESC limit 1000";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      
      if(mysql_field_name($objQuery,$i)=="dateday"){

       // $arrCol[mysql_field_name($objQuery,$i)] = date_format(date_create($obResult[$i]),"d-m-Y");
      $arrCol[mysql_field_name($objQuery,$i)] = substr($obResult[$i],8,2)." ".thai_month(substr($obResult[$i],5,2))." ".substr($obResult[$i],0,4);
      }else{
        $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      
    }
  }

    array_push($resultArray,$arrCol);
  }
    echo json_encode($resultArray);



}else if($_POST["submit"]=="return_bill_edit"){

  $strSQL = "SELECT * FROM bill_real_edit WHERE status = '".$_POST["status"]."' AND nobill_system = '".$_POST["bill"]."' ";
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
    $arrCol["total"]=($arrCol["price"]*$arrCol["pcs"]);
    
  //   if($_POST["status"]=="INV"){
  //   $arrCol["stock_total"]=$arrCol["laststock"]+$arrCol["pcs"];
  // }else if($_POST["status"]=="OWH"){
  //   $arrCol["stock_total"]=$arrCol["laststock"]-$arrCol["pcs"];
  // }

    $dc=explode("-",$arrCol["dateday"]);
    $arrCol["dateday"]=$dc[2]."-".$dc[1]."-".$dc[0];

    if($_POST["status"]=="INV"){
    $sql_supply = "SELECT name from customer_supply where code = '".$arrCol[code_supply]."'  limit 1  ";
    list($name_supply) = Mysql_fetch_row(Mysql_Query($sql_supply));
  }else{
    $sql_supply = "SELECT name from department where code = '".$arrCol[code_supply]."'  limit 1  ";
    list($name_supply) = Mysql_fetch_row(Mysql_Query($sql_supply)); 
  }
    $sql_persanal = "SELECT name from personal where code = '".$arrCol[code_persanal]."'  limit 1  ";
    list($name_persanal) = Mysql_fetch_row(Mysql_Query($sql_persanal));

    $sql_unit = "SELECT unit from stock_product where barcode = '".$arrCol[barcode]."'  limit 1  ";
    list($unit) = Mysql_fetch_row(Mysql_Query($sql_unit));

    $arrCol["unit"]=$unit;
    $arrCol["name_supply"]=$name_supply;
    $arrCol["name_persanal"]=$name_persanal;

    array_push($resultArray,$arrCol);
  }
  
  echo json_encode($resultArray);
}else if($_POST["submit"]=="return_billreal_edit"){


  $sql_del = "DELETE FROM bill_real_edit WHERE ipaddress = '".$_SERVER['REMOTE_ADDR']."' "; 
  $query = mysql_query($sql_del);

  $strSQLe = "SELECT * FROM bill WHERE status = '".$_POST["status"]."' AND nobill_system = '".$_POST["bill"]."' ";
  $objQuerye = mysql_query($strSQLe) or die (mysql_error());
  // $intNumField = mysql_num_fields($objQuery);
  // $resultArray = array();
  while($obResult = mysql_fetch_array($objQuerye))
  {


$strSQL = "INSERT INTO bill_real_edit SET "; 
$strSQL .="nobill_system = '".$obResult["nobill_system"]."' ";
$strSQL .=",nobill = '".$obResult["nobill"]."' ";
$strSQL .=",code_supply = '".$obResult["customer_id"]."' ";
$strSQL .=",code_persanal = '".$obResult["persanal"]."' ";
$strSQL .=",creditor_bill = '".$obResult["nobill_recipt"]."' ";
$strSQL .=",dateday = '".$obResult["dateday"]."' ";
$strSQL .=",timelast = '".$obResult["lasttime"]."' ";
$strSQL .=",barcode = '".$obResult["barcode"]."' ";
$strSQL .=",detail = '".$obResult["detail"]."' ";
$strSQL .=",pcs = '".$obResult["pcs"]."' ";
$strSQL .=",laststock = '".$obResult["laststock"]."' ";
$strSQL .=",price = '".comma_price($obResult["price"])."' ";
$strSQL .=",ipaddress = '".$_SERVER['REMOTE_ADDR']."' ";
$strSQL .=",status = '".$obResult["status"]."' ";
$strSQL .=",officer = '".$_SESSION["xusername"]."' ";
$objQuery = mysql_query($strSQL);



}


}else if($_POST["submit"]=="del_billreal_rowedit"){

 $sql_del = "DELETE FROM bill_real_edit WHERE row_id = '".$_POST["row_id"]."' "; 
 $query = mysql_query($sql_del);
 
}else if($_POST["submit"]=="set_value_edit"){

if($_POST["tbl"]=="price"){
  $_POST["value"] = comma_price($_POST["value"]);
}
$sql_update = "UPDATE bill_real_edit SET ".$_POST["tbl"]." ='".$_POST["value"]."' where row_id = '".$_POST["row_id"]."'  ";
$result_update= mysql_query($sql_update) or die(mysql_error());
}else if($_POST["submit"]=="insert_product_edit"){



$result = mysql_query("SELECT * FROM bill_real_edit where barcode = '".$_POST["barcode"]."' AND status = '".$_POST["status"]."' AND ipaddress = '".$_SERVER['REMOTE_ADDR']."'");
$num = mysql_num_rows($result);

if(empty($num)){

  // $strSQL = "SELECT detail,SUM(pcs),price_in FROM stock_product where barcode = '".$_POST["barcode"]."' GROUP By barcode ORDER By row_id DESC limit 1 ";
  // $objQuery = mysql_query($strSQL) or die (mysql_error());
  // $intNumField = mysql_num_fields($objQuery);
  // while($obResult = mysql_fetch_array($objQuery))
  // {
  //   $arrCol = array();
  //   for($i=0;$i<$intNumField;$i++)
  //   {
  //     $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
  //   }
  // }
   $sql = "SELECT detail,SUM(pcs),price_in FROM stock_product where barcode = '".$_POST["barcode"]."' GROUP By barcode ORDER By row_id DESC limit 1 ";
   list($detail,$pcs,$price_in) = Mysql_fetch_row(Mysql_Query($sql));

$dateday=substr($_POST["dateday"],6,4)."-".substr($_POST["dateday"],3,2)."-".substr($_POST["dateday"],0,2);

$strSQL = "INSERT INTO bill_real_edit SET "; 
$strSQL .="nobill_system = '".$_POST["nobill_system"]."' ";
$strSQL .=",nobill = '".$_POST["nobill"]."' ";
$strSQL .=",code_supply = '".$_POST["code_supply"]."' ";
$strSQL .=",code_persanal = '".$_POST["code_persanal"]."' ";
$strSQL .=",creditor_bill = '".$_POST["order_bill"]."' ";
$strSQL .=",dateday = '".$dateday."' ";
$strSQL .=",timelast = '".date("H:i:s")."' ";
$strSQL .=",barcode = '".$_POST["barcode"]."' ";
$strSQL .=",detail = '".$detail."' ";
$strSQL .=",pcs = '".$_POST["pcs"]."' ";
$strSQL .=",laststock = '".$pcs."' ";
$strSQL .=",price = '".comma_price($price_in)."' ";
$strSQL .=",ipaddress = '".$_SERVER['REMOTE_ADDR']."' ";
$strSQL .=",status = '".$_POST["status"]."' ";
$strSQL .=",officer = '".$_SESSION["xusername"]."' ";
$objQuery = mysql_query($strSQL);
}else{


$sql = "SELECT pcs  FROM bill_real_edit where barcode = '".$_POST["barcode"]."' AND ipaddress = '".$_SERVER['REMOTE_ADDR']."' AND status = '".$_POST["status"]."' limit 1  ";
list($pcs) = Mysql_fetch_row(Mysql_Query($sql));


$sql_update = "UPDATE bill_real_edit SET pcs='".($pcs+$_POST["pcs"])."' where barcode = '".$_POST["barcode"]."' AND status = '".$_POST["status"]."' AND ipaddress = '".$_SERVER['REMOTE_ADDR']."' ";
$result_update= mysql_query($sql_update) or die(mysql_error());


}

}else if($_POST["submit"]=="save_in_edit"){


  $strSQL_qu = "SELECT * FROM bill_real_edit WHERE nobill_system = '".$_POST["nobill_system"]."' AND status = '".$_POST["status"]."' AND ipaddress = '".$_SERVER['REMOTE_ADDR']."' ";
  $objQuery_qu = mysql_query($strSQL_qu) or die (mysql_error());
  while($ob_edit = mysql_fetch_array($objQuery_qu))
  {

    $sql = "SELECT * from bill where nobill_system = '".$ob_edit["nobill_system"]."' AND barcode = '".$ob_edit["barcode"]."'";
    $result = mysql_query($sql);
    if(mysql_num_rows($result)!= 0){
    while ($ob_old = mysql_fetch_array($result) ) {


      if($ob_edit["pcs"]!=$ob_old["pcs"] && comma_price($ob_edit["price"])!=comma_price($ob_old["price_in"])){
    //------>
    $savetodb = serialize($ob_old);
    //$toarray = unserialize($savetodb);
    $strSQLq = "INSERT INTO bill_edit_record SET "; 
    $strSQLq .="tbl_cancel = '".$savetodb."' ";
    $strSQLq .=",timedo = '".date("Y-m-d H:i:s")."' ";
    $strSQLq .=",officer = '".$_SESSION["xusername"]."' ";
    $objQueryq = mysql_query($strSQLq);
    //<------

      $sql_s1 = "SELECT pcs from stock_product where barcode = '".$ob_edit["barcode"]."' AND price_in = '".comma_price($ob_edit["price"])."' limit 1  ";
      
      //ตรวจเช็คสินค้าและรหัสสสินค้า
      if(mysql_num_rows(mysql_query($sql_s1))!= 0){
        list($pcs) = Mysql_fetch_row(Mysql_Query($sql_s1));

        if($ob_edit["pcs"]>$ob_old["pcs"]){
        $t_pcs= $ob_edit["pcs"]-$ob_old["pcs"];
     $sql_update = "UPDATE stock_product SET pcs='".($pcs+$t_pcs)."' where barcode = '".$ob_edit["barcode"]."' AND price_in = '".comma_price($ob_edit["price"])."' ";
    $result_update= mysql_query($sql_update) or die(mysql_error());
        }else if($ob_edit["pcs"]<$ob_old["pcs"]){
        $t_pcs= $ob_old["pcs"]-$ob_edit["pcs"];
     $sql_update = "UPDATE stock_product SET pcs='".($pcs-$t_pcs)."' where barcode = '".$ob_edit["barcode"]."' AND price_in = '".comma_price($ob_edit["price"])."' ";
    $result_update= mysql_query($sql_update) or die(mysql_error());
        }

      $strSQL = "UPDATE bill SET "; 
      $strSQL .="price = '".comma_price($ob_edit["price"])."' ";
      $strSQL .=",pcs = '".$ob_edit["pcs"]."' ";
      $strSQL .="WHERE row_id = '".$ob_old[row_id]."' ";
      $objQuery = mysql_query($strSQL);

      }else{
        $sql_s1 = "SELECT pcs from stock_product where barcode = '".$ob_old["barcode"]."' AND price_in = '".comma_price($ob_old["price"])."' limit 1  ";
        list($pcs) = Mysql_fetch_row(Mysql_Query($sql_s1));

        $sql_pcs = "SELECT group_type,unit from stock_product where barcode = '".$ob_old["barcode"]."' limit 1  ";
        list($re_group_type,$re_unit) = Mysql_fetch_row(Mysql_Query($sql_pcs));

        $strSQL = "INSERT INTO stock_product SET "; 
        $strSQL .="barcode = '".$ob_old["barcode"]."' ";
        $strSQL .=",detail = '".$ob_old["detail"]."' ";
        $strSQL .=",price_in = '".comma_price($ob_edit["price"])."' ";
        $strSQL .=",group_type = '".$re_group_type."' ";
        $strSQL .=",pcs = '".$ob_edit["pcs"]."' ";
        $strSQL .=",unit = '".$re_unit."' ";
        $strSQL .=",lastin = '".date("Y-m-d H:i:s")."' ";
        $strSQL .=",lastupdate = '".date("Y-m-d H:i:s")."' ";
        $objQuery = mysql_query($strSQL);


        //$t_pcs= $ob_old["pcs"]-$ob_edit["pcs"];
        $sql_update = "UPDATE stock_product SET pcs='".($pcs-$ob_old["pcs"])."' where barcode = '".$ob_old["barcode"]."' AND price_in = '".comma_price($ob_old["price"])."' ";
        $result_update= mysql_query($sql_update) or die(mysql_error());

          $sql_update1 = "UPDATE stock_product SET pcs='".$ob_edit["pcs"]."' where barcode = '".$ob_edit["barcode"]."' AND price_in = '".comma_price($ob_edit["price"])."' ";
        $result_update= mysql_query($sql_update1) or die(mysql_error());

      $strSQL = "UPDATE bill SET "; 
      $strSQL .="price = '".comma_price($ob_edit["price"])."' ";
      $strSQL .=",pcs = '".$ob_edit["pcs"]."' ";
      $strSQL .="WHERE row_id = '".$ob_old[row_id]."' ";
      $objQuery = mysql_query($strSQL);

      }

      }else if($ob_edit["pcs"]!=$ob_old["pcs"]){
            //------>
    $savetodb = serialize($ob_old);
    //$toarray = unserialize($savetodb);
    $strSQLq = "INSERT INTO bill_edit_record SET "; 
    $strSQLq .="tbl_cancel = '".$savetodb."' ";
    $strSQLq .=",timedo = '".date("Y-m-d H:i:s")."' ";
    $strSQLq .=",officer = '".$_SESSION["xusername"]."' ";
    $objQueryq = mysql_query($strSQLq);
    //<------
      $sql_s1 = "SELECT pcs from stock_product where barcode = '".$ob_edit["barcode"]."' AND price_in = '".comma_price($ob_edit["price"])."' limit 1  ";
      list($pcs) = Mysql_fetch_row(Mysql_Query($sql_s1));

        if($ob_edit["pcs"] > $ob_old["pcs"]){
        $t_pcs= $ob_edit["pcs"]-$ob_old["pcs"];
  $sql_update = "UPDATE stock_product SET pcs='".($pcs+$t_pcs)."' where barcode = '".$ob_edit["barcode"]."' AND price_in = '".comma_price($ob_edit["price"])."' ";
  $result_update= mysql_query($sql_update) or die(mysql_error());
        }else if($ob_edit["pcs"] < $ob_old["pcs"]){
        $t_pcs= $ob_old["pcs"]-$ob_edit["pcs"];
  $sql_update = "UPDATE stock_product SET pcs='".($pcs-$t_pcs)."' where barcode = '".$ob_edit["barcode"]."' AND price_in = '".comma_price($ob_edit["price"])."' ";
  $result_update= mysql_query($sql_update) or die(mysql_error());
        }

      $strSQL = "UPDATE bill SET "; 
      $strSQL .="price = '".comma_price($ob_edit["price"])."' ";
      $strSQL .=",pcs = '".$ob_edit["pcs"]."' ";
      $strSQL .="WHERE row_id = '".$ob_old[row_id]."' ";
      $objQuery = mysql_query($strSQL);

      }else if(comma_price($ob_edit["price"])!=comma_price($ob_old["price"])){
    //------>
    $savetodb = serialize($ob_old);
    //$toarray = unserialize($savetodb);
    $strSQLq = "INSERT INTO bill_edit_record SET "; 
    $strSQLq .="tbl_cancel = '".$savetodb."' ";
    $strSQLq .=",timedo = '".date("Y-m-d H:i:s")."' ";
    $strSQLq .=",officer = '".$_SESSION["xusername"]."' ";
    $objQueryq = mysql_query($strSQLq);
    //<------
        $sql_s1 = "SELECT pcs from stock_product where barcode = '".$ob_old["barcode"]."' AND price_in = '".comma_price($ob_old["price"])."' limit 1  ";
        list($pcs) = Mysql_fetch_row(Mysql_Query($sql_s1));

        $sql_pcs = "SELECT group_type,unit from stock_product where barcode = '".$ob_old["barcode"]."' limit 1  ";
        list($re_group_type,$re_unit) = Mysql_fetch_row(Mysql_Query($sql_pcs));

        $strSQL = "INSERT INTO stock_product SET "; 
        $strSQL .="barcode = '".$ob_old["barcode"]."' ";
        $strSQL .=",detail = '".$ob_old["detail"]."' ";
        $strSQL .=",price_in = '".comma_price($ob_edit["price"])."' ";
        $strSQL .=",group_type = '".$re_group_type."' ";
        $strSQL .=",pcs = '".$ob_edit["pcs"]."' ";
        $strSQL .=",unit = '".$re_unit."' ";
        $strSQL .=",lastin = '".date("Y-m-d H:i:s")."' ";
        $strSQL .=",lastupdate = '".date("Y-m-d H:i:s")."' ";
        $objQuery = mysql_query($strSQL);


        //$t_pcs= $ob_old["pcs"]-$ob_edit["pcs"];
        $sql_update = "UPDATE stock_product SET pcs='".($pcs-$ob_old["pcs"])."' where barcode = '".$ob_old["barcode"]."' AND price_in = '".comma_price($ob_old["price"])."' ";
        $result_update= mysql_query($sql_update) or die(mysql_error());

        $sql_update1 = "UPDATE stock_product SET pcs='".$ob_edit["pcs"]."' where barcode = '".$ob_edit["barcode"]."' AND price_in = '".comma_price($ob_edit["price"])."' ";
        $result_update= mysql_query($sql_update1) or die(mysql_error());

      $strSQL = "UPDATE bill SET "; 
      $strSQL .="price = '".comma_price($ob_edit["price"])."' ";
      $strSQL .=",pcs = '".$ob_edit["pcs"]."' ";
      $strSQL .="WHERE row_id = '".$ob_old[row_id]."' ";
      $objQuery = mysql_query($strSQL);
     }
    }

  }else{

$dateday=substr($_POST["dateday"],6,4)."-".substr($_POST["dateday"],3,2)."-".substr($_POST["dateday"],0,2);

$strSQL = "INSERT INTO bill SET "; 
$strSQL .="nobill_system = '".$ob_edit["nobill_system"]."' ";
$strSQL .=",nobill = '".$_POST["nobill"]."' ";
$strSQL .=",nobill_recipt = '".$ob_edit["creditor_bill"]."' ";
$strSQL .=",dateday = '".$dateday."' ";
$strSQL .=",lasttime = '".$ob_edit["timelast"]."' ";
$strSQL .=",customer_id = '".$_POST["customer_id"]."' ";
$strSQL .=",customer_name = '".$_POST["customer_name"]."' ";
$strSQL .=",persanal = '".$_POST["persanal_id"]."' ";
$strSQL .=",group_type = '".grouptype($ob_edit["barcode"])."' ";
$strSQL .=",barcode = '".$ob_edit["barcode"]."' ";
$strSQL .=",detail = '".$ob_edit["detail"]."' ";
$strSQL .=",laststock = '".$ob_edit["laststock"]."' ";
$strSQL .=",pcs = '".$ob_edit["pcs"]."' ";
$strSQL .=",price = '".comma_price($ob_edit["price"])."' ";
$strSQL .=",pcs_stock = '".($ob_edit["laststock"]+$obResult["pcs"])."' ";
//$strSQL .=",other = '".$obResult["other"]."' ";
$strSQL .=",status = '".$ob_edit["status"]."' ";
$strSQL .=",officer = '".$_SESSION["xusername"]."' ";
$objQuery = mysql_query($strSQL);

$sql_q = "SELECT pcs from stock_product where barcode = '".$ob_edit["barcode"]."' AND price_in = '".comma_price($ob_edit["price"])."' limit 1  ";
list($pcs) = Mysql_fetch_row(Mysql_Query($sql_q));


$sql_update1 = "UPDATE stock_product SET pcs='".($pcs+$ob_edit["pcs"])."' where barcode = '".$ob_edit["barcode"]."' AND price_in = '".comma_price($ob_edit["price"])."' ";
$result_update= mysql_query($sql_update1) or die(mysql_error());



  }

}


  //กรุณีลบสินค้าออก

    $sql = "SELECT * from bill where nobill_system = '".$_POST["nobill_system"]."' AND status = '".$_POST["status"]."'";
    $result = mysql_query($sql);
    while ($ob_oldck = mysql_fetch_array($result) ) {

  $strSQL_qu = "SELECT * FROM bill_real_edit WHERE nobill_system = '".$_POST["nobill_system"]."' AND status = '".$_POST["status"]."' AND ipaddress = '".$_SERVER['REMOTE_ADDR']."' AND barcode = '".$ob_oldck["barcode"]."' ";
  if(mysql_num_rows(mysql_query($strSQL_qu))==0){

    //การคืนสินค้าออกจากสต็อก
    $sql_q = "SELECT pcs from stock_product where barcode = '".$ob_oldck["barcode"]."' AND price_in = '".comma_price($ob_oldck["price"])."' limit 1  ";
    list($pcs) = Mysql_fetch_row(Mysql_Query($sql_q));

    $sql_update = "UPDATE stock_product SET pcs='".($pcs-$ob_oldck["pcs"])."' where barcode = '".$ob_oldck["barcode"]."' AND price_in = '".scomma_price($ob_oldck["price"])."' ";
    $result_update= mysql_query($sql_update) or die(mysql_error());

    $sql_ob = "SELECT * from bill where nobill_system = '".$ob_oldck["nobill_system"]."' AND barcode = '".$ob_oldck["barcode"]."' limit 1";
    $result_ob = mysql_query($sql_ob);
    while ($strResult = mysql_fetch_assoc($result_ob) ) {

    $savetodb = serialize($strResult);
    //$toarray = unserialize($savetodb);
    }

    $strSQLq = "INSERT INTO bill_edit_record SET "; 
    $strSQLq .="tbl_cancel = '".$savetodb."' ";
    $strSQLq .=",timedo = '".date("Y-m-d H:i:s")."' ";
    $strSQLq .=",officer = '".$_SESSION["xusername"]."' ";
    $objQueryq = mysql_query($strSQLq);

    $sql_del = "DELETE FROM bill WHERE row_id = '".$ob_oldck["row_id"]."' "; 
    $query = mysql_query($sql_del) or die(mysql_error());

  }



}

  

}else if($_POST["submit"]=="cancel_bill_in"){


    $sql = "SELECT * from bill where nobill_system = '".$_POST["nobill_system"]."' AND status = '".$_POST["status"]."'";
    $result = mysql_query($sql);
    while ($ob_oldck = mysql_fetch_array($result) ) {

  //การคืนสินค้าออกจากสต็อก
    $sql_q = "SELECT pcs from stock_product where barcode = '".$ob_oldck["barcode"]."' AND price_in = '".comma_price($ob_oldck["price"])."' limit 1  ";
    list($pcs) = Mysql_fetch_row(Mysql_Query($sql_q));

    $sql_update = "UPDATE stock_product SET pcs='".($pcs-$ob_oldck["pcs"])."' where barcode = '".$ob_oldck["barcode"]."' AND price_in = '".comma_price($ob_oldck["price"])."' ";
    $result_update= mysql_query($sql_update) or die(mysql_error());

    $savetodb = serialize($ob_oldck);

    $strSQLq = "INSERT INTO bill_edit_record SET "; 
    $strSQLq .="tbl_cancel = '".$savetodb."' ";
    $strSQLq .=",timedo = '".date("Y-m-d H:i:s")."' ";
    $strSQLq .=",officer = '".$_SESSION["xusername"]."' ";
    $objQueryq = mysql_query($strSQLq);

    $sql_del = "DELETE FROM bill WHERE row_id = '".$ob_oldck["row_id"]."' "; 
    $query = mysql_query($sql_del) or die(mysql_error());

}



}else if($_POST["submit"]=="warehouseout_edit"){

  if($_POST["tbltable"]=="dateday"){
    $tbldata=substr($_POST["tbldata"],6,4)."-".substr($_POST["tbldata"],3,2)."-".substr($_POST["tbldata"],0,2);
  }else{
    $tbldata=$_POST["tbldata"];
  }

  $strSQL = "SELECT * FROM bill WHERE ".$_POST["tbltable"]." like '%".$tbldata."%' AND status = 'OWH' ORDER By dateday DESC limit 1000";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      
      if(mysql_field_name($objQuery,$i)=="dateday"){

        $arrCol[mysql_field_name($objQuery,$i)] = substr($obResult[$i],8,2)." ".thai_month(substr($obResult[$i],5,2))." ".substr($obResult[$i],0,4);
      }else{
        $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      
    }
  }

    array_push($resultArray,$arrCol);
  }
    echo json_encode($resultArray);



}else if ($_POST["submit"]=="save_out_edit") {

$dateday=substr($_POST["dateday"],6,4)."-".substr($_POST["dateday"],3,2)."-".substr($_POST["dateday"],0,2);

  $strSQL_qu = "SELECT * FROM bill_real_edit WHERE nobill_system = '".$_POST["nobill_system"]."' AND status = '".$_POST["status"]."' AND ipaddress = '".$_SERVER['REMOTE_ADDR']."' ";
  $objQuery_qu = mysql_query($strSQL_qu) or die (mysql_error());
  while($ob_edit = mysql_fetch_array($objQuery_qu))
  {

    $sql = "SELECT * from bill where nobill_system = '".$ob_edit["nobill_system"]."' AND barcode = '".$ob_edit["barcode"]."'";
    $result = mysql_query($sql);
    if(mysql_num_rows($result)!= 0){
    while ($ob_old = mysql_fetch_array($result) ) {
      
      $strSQL = "UPDATE bill SET ";
      $strSQL .="dateday = '".$dateday."' ";
      $strSQL .=",persanal = '".$_POST["persanal_id"]."' ";
      $strSQL .="WHERE row_id = '".$ob_old[row_id]."' ";
      $objQuery = mysql_query($strSQL);

   if($ob_edit["pcs"]!=$ob_old["pcs"]){
            //------>
    $savetodb = serialize($ob_old);
    //$toarray = unserialize($savetodb);
    $strSQLq = "INSERT INTO bill_edit_record SET "; 
    $strSQLq .="tbl_cancel = '".$savetodb."' ";
    $strSQLq .=",timedo = '".date("Y-m-d H:i:s")."' ";
    $strSQLq .=",officer = '".$_SESSION["xusername"]."' ";
    $objQueryq = mysql_query($strSQLq);
    //<------
      $sql_s1 = "SELECT pcs from stock_product where barcode = '".$ob_edit["barcode"]."' AND price_in = '".comma_price($ob_edit["price"])."' limit 1  ";
      list($pcs) = Mysql_fetch_row(Mysql_Query($sql_s1));

        if($ob_edit["pcs"] > $ob_old["pcs"]){
        $t_pcs= $ob_edit["pcs"]-$ob_old["pcs"];
  $sql_update = "UPDATE stock_product SET pcs='".($pcs-$t_pcs)."' where barcode = '".$ob_edit["barcode"]."' AND price_in = '".comma_price($ob_edit["price"])."' ";
  $result_update= mysql_query($sql_update) or die(mysql_error());
        }else if($ob_edit["pcs"] < $ob_old["pcs"]){
  $t_pcs= $ob_old["pcs"]-$ob_edit["pcs"];
  $sql_update = "UPDATE stock_product SET pcs='".($pcs+$t_pcs)."' where barcode = '".$ob_edit["barcode"]."' AND price_in = '".comma_price($ob_edit["price"])."' ";
  $result_update= mysql_query($sql_update) or die(mysql_error());
        }

      $strSQL = "UPDATE bill SET "; 
      $strSQL .="pcs = '".$ob_edit["pcs"]."' ";
      $strSQL .="WHERE row_id = '".$ob_old[row_id]."' ";
      $objQuery = mysql_query($strSQL);

      }
    }
  


  }else{

$strSQL = "INSERT INTO bill SET "; 
$strSQL .="nobill_system = '".$ob_edit["nobill_system"]."' ";
$strSQL .=",nobill = '".$_POST["nobill"]."' ";
$strSQL .=",nobill_recipt = '".$ob_edit["creditor_bill"]."' ";
$strSQL .=",dateday = '".$_POST["dateday"]."' ";
$strSQL .=",lasttime = '".$ob_edit["timelast"]."' ";
$strSQL .=",customer_id = '".$_POST["customer_id"]."' ";
$strSQL .=",customer_name = '".$_POST["customer_name"]."' ";
$strSQL .=",persanal = '".$_POST["persanal_id"]."' ";
$strSQL .=",group_type = '".grouptype($ob_edit["barcode"])."' ";
$strSQL .=",barcode = '".$ob_edit["barcode"]."' ";
$strSQL .=",detail = '".$ob_edit["detail"]."' ";
$strSQL .=",laststock = '".$ob_edit["laststock"]."' ";
$strSQL .=",pcs = '".$ob_edit["pcs"]."' ";
$strSQL .=",price = '".comma_price($ob_edit["price"])."' ";
$strSQL .=",pcs_stock = '".($ob_edit["laststock"]+$obResult["pcs"])."' ";
//$strSQL .=",other = '".$obResult["other"]."' ";
$strSQL .=",status = '".$ob_edit["status"]."' ";
$strSQL .=",officer = '".$_SESSION["xusername"]."' ";
$objQuery = mysql_query($strSQL);

$sql_q = "SELECT pcs from stock_product where barcode = '".$ob_edit["barcode"]."' AND price_in = '".comma_price($ob_edit["price"])."' limit 1  ";
list($pcs) = Mysql_fetch_row(Mysql_Query($sql_q));


$sql_update1 = "UPDATE stock_product SET pcs='".($pcs-$ob_edit["pcs"])."' where barcode = '".$ob_edit["barcode"]."' AND price_in = '".comma_price($ob_edit["price"])."' ";
$result_update= mysql_query($sql_update1) or die(mysql_error());



  }

}


  //กรุณีลบสินค้าออก

    $sql = "SELECT * from bill where nobill_system = '".$_POST["nobill_system"]."' AND status = '".$_POST["status"]."'";
    $result = mysql_query($sql);
    while ($ob_oldck = mysql_fetch_array($result) ) {

  $strSQL_qu = "SELECT * FROM bill_real_edit WHERE nobill_system = '".$_POST["nobill_system"]."' AND status = '".$_POST["status"]."' AND ipaddress = '".$_SERVER['REMOTE_ADDR']."' AND barcode = '".$ob_oldck["barcode"]."' ";
  if(mysql_num_rows(mysql_query($strSQL_qu))==0){

    //การคืนสินค้าออกจากสต็อก
    $sql_q = "SELECT pcs from stock_product where barcode = '".$ob_oldck["barcode"]."' AND price_in = '".comma_price($ob_oldck["price"])."' limit 1  ";
    list($pcs) = Mysql_fetch_row(Mysql_Query($sql_q));

    $sql_update = "UPDATE stock_product SET pcs='".($pcs+$ob_oldck["pcs"])."' where barcode = '".$ob_oldck["barcode"]."' AND price_in = '".comma_price($ob_oldck["price"])."' ";
    $result_update= mysql_query($sql_update) or die(mysql_error());

    $sql_ob = "SELECT * from bill where nobill_system = '".$ob_oldck["nobill_system"]."' AND barcode = '".$ob_oldck["barcode"]."' limit 1";
    $result_ob = mysql_query($sql_ob);
    while ($strResult = mysql_fetch_assoc($result_ob) ) {

    $savetodb = serialize($strResult);
    //$toarray = unserialize($savetodb);
    }

    $strSQLq = "INSERT INTO bill_edit_record SET "; 
    $strSQLq .="tbl_cancel = '".$savetodb."' ";
    $strSQLq .=",timedo = '".date("Y-m-d H:i:s")."' ";
    $strSQLq .=",officer = '".$_SESSION["xusername"]."' ";
    $objQueryq = mysql_query($strSQLq);

    $sql_del = "DELETE FROM bill WHERE row_id = '".$ob_oldck["row_id"]."' "; 
    $query = mysql_query($sql_del) or die(mysql_error());

  }



}

  

}else if($_POST["submit"]=="cancel_bill_in"){


    $sql = "SELECT * from bill where nobill_system = '".$_POST["nobill_system"]."' AND status = '".$_POST["status"]."'";
    $result = mysql_query($sql);
    while ($ob_oldck = mysql_fetch_array($result) ) {

  //การคืนสินค้าออกจากสต็อก
    $sql_q = "SELECT pcs from stock_product where barcode = '".$ob_oldck["barcode"]."' AND price_in = '".comma_price($ob_oldck["price"])."' limit 1  ";
    list($pcs) = Mysql_fetch_row(Mysql_Query($sql_q));

    $sql_update = "UPDATE stock_product SET pcs='".($pcs-$ob_oldck["pcs"])."' where barcode = '".$ob_oldck["barcode"]."' AND price_in = '".comma_price($ob_oldck["price"])."' ";
    $result_update= mysql_query($sql_update) or die(mysql_error());

    $savetodb = serialize($ob_oldck);

    $strSQLq = "INSERT INTO bill_edit_record SET "; 
    $strSQLq .="tbl_cancel = '".$savetodb."' ";
    $strSQLq .=",timedo = '".date("Y-m-d H:i:s")."' ";
    $strSQLq .=",officer = '".$_SESSION["xusername"]."' ";
    $objQueryq = mysql_query($strSQLq);

    $sql_del = "DELETE FROM bill WHERE row_id = '".$ob_oldck["row_id"]."' "; 
    $query = mysql_query($sql_del) or die(mysql_error());

}





}

mysql_close($Conn);
?>