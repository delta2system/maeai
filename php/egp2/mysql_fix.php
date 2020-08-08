<?
session_start();
include("../connect.inc");

function convert_dateday($str){
  
$sr=explode(" ",$str);

switch($sr[1])
{
case "ม.ค.": $sr[1] = "01"; break;
case "ก.พ.": $sr[1] = "02"; break;
case "มี.ค.": $sr[1] = "03"; break;
case "เม.ย.": $sr[1] = "04"; break;
case "พ.ค.": $sr[1] = "05"; break;
case "มิ.ย.": $sr[1] = "06"; break;
case "ก.ค.": $sr[1] = "07"; break;
case "ส.ค.": $sr[1] = "08"; break;
case "ก.ย.": $sr[1] = "09"; break;
case "ต.ค.": $sr[1] = "10"; break;
case "พ.ย.": $sr[1] = "11"; break;
case "ธ.ค.": $sr[1] = "12"; break;
}

return $sr[2]."-".$sr[1]."-".$sr[0];

}

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

function convert_redatday($str){

$sb=explode("-",$str);


return $sb[2]." ".mount($sb[1])." ".$sb[0];

}

if($_POST["submit"]=="save_fix"){

$resultArray=array();
$arrCol=array();
//INSERT SQL
$strSQL = "INSERT INTO hirefix SET "; 
$strSQL .="dateday = '".convert_dateday($_POST["dateday"])."' ";
$strSQL .=",times = '".$_POST["times"]."' ";
$strSQL .=",department = '".$_POST["department"]."' ";
$strSQL .=",product = '".$_POST["product"]."' ";
$strSQL .=",model = '".$_POST["model"]."' ";
$strSQL .=",serial = '".$_POST["serial"]."' ";
$strSQL .=",no = '".$_POST["no"]."' ";
$strSQL .=",type_fix = '".$_POST["type_fix"]."' ";
$strSQL .=",type = '".$_POST["type"]."' ";
$strSQL .=",other = '".$_POST["other"]."' ";
$strSQL .=",officer = '".$_POST["officer"]."' ";
$strSQL .=",userid = '".$_SESSION["xid"]."' ";
$objQuery = mysql_query($strSQL);

if($objQuery){
	$arrCol["status"]="true";
	$arrCol["msg"]="บันทึกใบแจ้งซ่อมเรียบร้อย...";
}else{
	$arrCol["status"]="error";
	$arrCol["msg"]=mysql_error();
}

  
  array_push($resultArray,$arrCol);
  
  echo json_encode($resultArray);



}else if($_POST["submit"]=="return_data"){

  $strSQL = "SELECT * FROM hirefix WHERE row_id = '".$_POST["row_id"]."' ";
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

    $arrCol["date_convert"]=convert_redatday($obResult["dateday"]);
    if($obResult["date_recipt"]!="0000-00-00"){
    $arrCol["date_recipt_convert"]=convert_redatday($obResult["date_recipt"]);
    }
    array_push($resultArray,$arrCol);
  }
  
  //mysql_close($Conn);
  
  echo json_encode($resultArray);


}else if($_POST["submit"]=="update_fix"){

$resultArray=array();
$arrCol=array();

$strSQL = "UPDATE hirefix SET ";
$strSQL .="dateday = '".convert_dateday($_POST["dateday"])."' ";
$strSQL .=",times = '".$_POST["times"]."' ";
$strSQL .=",department = '".$_POST["department"]."' ";
$strSQL .=",product = '".$_POST["product"]."' ";
$strSQL .=",model = '".$_POST["model"]."' ";
$strSQL .=",serial = '".$_POST["serial"]."' ";
$strSQL .=",no = '".$_POST["no"]."' ";
$strSQL .=",type_fix = '".$_POST["type_fix"]."' ";
$strSQL .=",type = '".$_POST["type"]."' ";
$strSQL .=",other = '".$_POST["other"]."' ";
$strSQL .=",officer = '".$_POST["officer"]."' ";
$strSQL .=",userid = '".$_SESSION["xid"]."' ";
$strSQL .=",status = '0' ";
$strSQL .="WHERE row_id = '".$_POST["row_id"]."' ";
$objQuery = mysql_query($strSQL);

if($objQuery){
	$arrCol["status"]="true";
	$arrCol["msg"]="บันทึกใบแจ้งซ่อมเรียบร้อย...";
}else{
	$arrCol["status"]="error";
	$arrCol["msg"]=mysql_error();
}

  
  array_push($resultArray,$arrCol);
  
  echo json_encode($resultArray);
}else if($_POST["submit"]=="del_fix"){

  $sql_del = "DELETE FROM hirefix WHERE row_id = '".$_POST["row_id"]."'"; 
  $query = mysql_query($sql_del);

}else if($_POST["submit"]=="update_reciptfix"){


$resultArray=array();
$arrCol=array();

$strSQL = "UPDATE hirefix SET ";
$strSQL .="dateday = '".convert_dateday($_POST["dateday"])."' ";
$strSQL .=",times = '".$_POST["times"]."' ";
$strSQL .=",department = '".$_POST["department"]."' ";
$strSQL .=",product = '".$_POST["product"]."' ";
$strSQL .=",model = '".$_POST["model"]."' ";
$strSQL .=",serial = '".$_POST["serial"]."' ";
$strSQL .=",no = '".$_POST["no"]."' ";
$strSQL .=",type_fix = '".$_POST["type_fix"]."' ";
$strSQL .=",type = '".$_POST["type"]."' ";
$strSQL .=",other = '".$_POST["other"]."' ";
$strSQL .=",officer = '".$_POST["officer"]."' ";
$strSQL .=",userid = '".$_SESSION["xid"]."' ";
$strSQL .=",status = '1' ";
$strSQL .=",date_recipt = '".convert_dateday($_POST["date_recipt"])."' ";
$strSQL .=",time_recipt = '".$_POST["time_recipt"]."' ";
$strSQL .=",other_fix = '".$_POST["other_fix"]."' ";
$strSQL .=",officer_recipt = '".$_POST["officer_recipt"]."' ";
$strSQL .=",officer_fix = '".$_POST["officer_fix"]."' ";
$strSQL .=",group_fix = '".$_POST["group_fix"]."' ";
$strSQL .=",type_status_fix = '".$_POST["type_status_fix"]."' ";
$strSQL .="WHERE row_id = '".$_POST["row_id"]."' ";

$objQuery = mysql_query($strSQL)or die(mysql_error());

if($objQuery){
  $arrCol["status"]="true";
  $arrCol["msg"]="บันทึกใบแจ้งซ่อมเรียบร้อย...";
}else{
  $arrCol["status"]="error";
  $arrCol["msg"]=mysql_error();
}

  array_push($resultArray,$arrCol);
  
  echo json_encode($resultArray);

}else if($_POST["submit"]=="update_return_fix"){

$resultArray=array();
$arrCol=array();

$strSQL = "UPDATE hirefix SET ";
$strSQL .="date_return = '".convert_dateday($_POST["date_return"])."' ";
$strSQL .=",type_status_return = '".$_POST["type_status_return"]."' ";
$strSQL .=",other_return = '".$_POST["other_return"]."' ";
$strSQL .=",nobill_recipt = '".$_POST["nobill_recipt"]."' ";
$strSQL .=",money_recipt = '".$_POST["money_recipt"]."' ";
$strSQL .=",officer_fix = '".$_POST["officer_fix"]."' ";
$strSQL .=",status = '9' ";
$strSQL .="WHERE row_id = '".$_POST["row_id"]."' ";
$objQuery = mysql_query($strSQL)or die(mysql_error());


  $sql = "SELECT row_id,attribute,model from store WHERE code = '".$_POST["no"]."' limit 1  ";
  $result = Mysql_Query($sql);
  $num = mysql_num_rows($result);
  if($num){
  list($rRow_id,$rAttribute,$model) = Mysql_fetch_row($result);  
  $df=explode("-",convert_dateday($_POST["date_return"]));
$strSQL = "INSERT INTO tbl_repair SET "; 
$strSQL .="row_store = '".$rRow_id."' ";
$strSQL .=",code_store = '".$_POST["no"]."' ";
$strSQL .=",dateday = '".convert_dateday($_POST["date_return"])."' ";
$strSQL .=",no_bill = '".$_POST["row_id"].str_replace("-", "", convert_dateday($_POST["date_return"]))."' ";
$strSQL .=",detail = '".$rAttribute." ".$model."' ";
// $strSQL .=",pcs = '' ";
if($_POST["nobill_recipt"]!=""){
    $nobill_recipt=" เอกสารแนบเลขที่ ".$_POST["nobill_recipt"];
}else{
      $nobill_recipt="";
}
$strSQL .=",total_money = '".$_POST["money_recipt"].$nobill_recipt."' ";
$strSQL .=",other = '".$_POST["other_return"]."' ";
$strSQL .=",fix_finished = '".$df[2]."-".$df[1]."-".$df[0]."' ";
$strSQL .=",status = '2' ";
$strSQL .=",officer = '".$_POST["officer_fix"]."' ";
$objQuery = mysql_query($strSQL);  


  }

if($objQuery){
  $arrCol["status"]="true";
  $arrCol["msg"]="บันทึกใบสถานะซ่อมเรียบร้อย...";
}else{
  $arrCol["status"]="error";
  $arrCol["msg"]=mysql_error();
}

  array_push($resultArray,$arrCol);
  
  echo json_encode($resultArray);


}else if($_POST["submit"]=="return_store"){


  $strSQL = "SELECT store_type,code,attribute,model,serial,model,responsible FROM store WHERE row_id = '".$_POST["row_id"]."' ";
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
  
  //mysql_close($Conn);
  
  echo json_encode($resultArray);




}
?>