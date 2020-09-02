<?
session_start();
include("../../php/connect.inc");
function num_convertbric($str){
$numthai = array("๑","๒","๓","๔","๕","๖","๗","๘","๙","๐");
$numarabic = array("1","2","3","4","5","6","7","8","9","0");
return str_replace($numthai,$numarabic,$str);
}

function commaa($str){
  if($str>0 || $str>'0'){
    return number_format($str);
  }
}

function mount_full($str){
switch($str)
{
case "มกราคม": $str = "01"; break;
case "กุมภาพันธ์": $str = "02"; break;
case "มีนาคม": $str = "03"; break;
case "เมษายน": $str = "04"; break;
case "พฤษภาคม": $str = "05"; break;
case "มิถุนายน": $str = "06"; break;
case "กรกฎาคม": $str = "07"; break;
case "สิงหาคม": $str = "08"; break;
case "กันยายน": $str = "09"; break;
case "ตุลาคม": $str = "10"; break;
case "พฤศจิกายน": $str = "11"; break;
case "ธันวาคม": $str = "12"; break;
}
return $str;
} 

  function remove_word($str){
  $word="0123456789.";
  $new_str="";
  for($s=0;$s<strlen($str);$s++){

    if(substr_count($word,substr($str, $s,1))){
      $new_str.=substr($str, $s,1);
    }
  }
  return $new_str;
  }

  function br2nl($string)
{
    return preg_replace('/\<br(\s*)?\/?\>/i', "", $string);
}

	function date_return($str){

		$str=num_convertbric(trim($str));
		$str=str_replace("พ.ศ. ", "" , $str);
		$sth=explode(" ",$str);
		return $sth[2]."-".mount_full($sth[1])."-".$sth[0];
    //return count($sth);
	}




if($_POST["edit_text"]){

$strFileName = trim(str_replace("/","-",num_convertbric($_POST["no"]))).".txt";
$objFopen = fopen($strFileName, 'w');
$strText1 = $_POST["edit_text"];
fwrite($objFopen, $strText1);
if($objFopen)
{

echo "File writed.";

$result = mysql_query("SELECT * FROM egp where no = '".trim(str_replace("/","-",num_convertbric($_POST["no"])))."'");
$num = mysql_num_rows($result);

if($num){
$strSQL = "UPDATE egp SET "; 
$strSQL .="datebill = '".date_return($_POST["datebill"])."' ";
$strSQL .=",detail = '".trim(num_convertbric(br2nl($_POST["detail"])))."' ";
$strSQL .=",total = '".trim(remove_word(num_convertbric(substr($_POST["total"],10))))."' ";
$strSQL .=",dateday = '".date("Y-m-d H:i:s")."' ";
$strSQL .=",officer = '".$_SESSION["xfullname"]."' ";
$strSQL .="WHERE no = '".trim(str_replace("/","-",num_convertbric($_POST["no"])))."' ";
$objQuery = mysql_query($strSQL);
echo $strSQL;
}else{
$strSQL = "INSERT INTO egp SET "; 
$strSQL .="no = '".trim(str_replace("/","-",num_convertbric($_POST["no"])))."' ";
$strSQL .=",datebill = '".date_return($_POST["datebill"])."' ";
$strSQL .=",detail = '".trim(num_convertbric(br2nl($_POST["detail"])))."' ";
$strSQL .=",total = '".trim(remove_word(num_convertbric(substr($_POST["total"],10))))."' ";
$strSQL .=",dateday = '".date("Y-m-d H:i:s")."' ";
$strSQL .=",officer = '".$_SESSION["xfullname"]."' ";
$objQuery = mysql_query($strSQL);	
}


$strSQL = "UPDATE egp_product SET "; 
$strSQL .="status = '1' ";
$strSQL .="WHERE no = '".trim(str_replace("/","-",num_convertbric($_POST["no"])))."' ";
$objQuery = mysql_query($strSQL)or die(mysql_error());

echo("<script> alert('บันทึกเรียบร้อย'); </script>");
}
else
{
	echo "File can not write";
	echo("<script> alert('ไม่สามารถบันทึกได้'); </script>");
}

fclose($objFopen);
chmod($strFileName , 0777);
}else if($_POST["submit"]=="del_egp"){


$file = trim(str_replace("/","-",num_convertbric($_POST["no"]))).".txt";
if (!unlink($file))
  {
  	echo("Error deleting $file");
  }
else
  {
   $sql_del = "DELETE FROM egp WHERE no = '".str_replace(".txt","",$file)."' "; 
  $query = mysql_query($sql_del);
   $sql_del = "DELETE FROM egp_product WHERE no = '".str_replace(".txt","",$file)."' "; 
  $query = mysql_query($sql_del);
  
  echo("ลบสำเร็จ");
  }




}else if($_POST["submit"]=="ทำใบจัดซื้อจัดจ้าง"){
  //print_r($_POST);
$product="";
for($t=0;$t<count($_POST["num"]);$t++){

  //print $_POST["num"][$t];
$product.=$_POST["num"][$t].".".$_POST["detail"][$t]." จำนวน ".commaa($_POST["pcs"][$t])." ".$_POST["unit"][$t]."ๆละ ".commaa($_POST["price"][$t])." บาท\n";


if($_POST["barcode"][$t]){
   $barcode_random = $_POST["barcode"][$t];

}else{
   $barcode_random = date("ymdHis");
}

$strSQL = "INSERT INTO egp_product SET "; 
$strSQL .="no = '".trim(str_replace("/","-",num_convertbric($_POST["no"])))."' ";
$strSQL .=",store = 'out' ";
$strSQL .=",group_type = '".$_POST["group_type"]."' ";
$strSQL .=",supply_id = '".$_POST["supply_code"]."' ";
$strSQL .=",department = '".$_POST["department"]."' ";
$strSQL .=",row_num = '".$_POST["num"][$t]."' ";
$strSQL .=",barcode = '".$barcode_random."' ";
$strSQL .=",detail = '".$_POST["detail"][$t]."' ";
$strSQL .=",pcs = '".$_POST["pcs"][$t]."' ";
$strSQL .=",unit = '".$_POST["unit"][$t]."' ";
$strSQL .=",price = '".$_POST["price"][$t]."' ";
$strSQL .=",total = '".$_POST["total"][$t]."' ";
$objQuery = mysql_query($strSQL)or die(mysql_error()); 

}


$strSQL = "UPDATE egp_title SET ";
//$strSQL = "INSERT INTO egp_title SET "; 
$strSQL .="no = '".$_POST["no"]."' ";
$strSQL .=",no_requat = '".$_POST["no_requat"]."' ";
$strSQL .=",dateday1 = '".$_POST["dateday1"]."' ";
$strSQL .=",dateday2 = '".$_POST["dateday2"]."' ";
$strSQL .=",pcs_detail = '".$_POST["pcs_detail"]."' ";
$strSQL .=",product = '".str_ireplace("\n","<br>",$product)."' ";
$strSQL .=",total_bath = '".$_POST["total_bath"]."' ";
$strSQL .=",total_bath_word = '".$_POST["total_bath_word"]."' ";
$strSQL .=",office01 = '".str_ireplace("\n","<br>",$_POST["office01"])."' ";
$strSQL .=",office02 = '".str_ireplace("\n","<br>",$_POST["office02"])."' ";
$strSQL .=",director = '".str_ireplace("\n","<br>",$_POST["director"])."' ";
$strSQL .=",supply_id = '".$_POST["supply_code"]."' ";
$strSQL .=",supply_name = '".$_POST["supply_name"]."' ";
$strSQL .=",supply_addres = '".$_POST["supply_addres"]."' ";
$strSQL .=",supply_phone = '".$_POST["supply_phone"]."' ";
$strSQL .=",supply_tax = '".$_POST["supply_tax"]."' ";
$strSQL .="WHERE row_id = '1' ";
$objQuery = mysql_query($strSQL)or die(mysql_error());


$strSQL = "INSERT INTO  tbl_import2_head SET "; 
// $strSQL .="no = '".trim(str_replace("/","-",num_convertbric($_POST["no"])))."' ";
// $strSQL .=",store = 'out' ";
// $strSQL .=",group_type = '".$_POST["group_type"]."' ";
// $strSQL .=",supply_id = '".$_POST["supply_code"]."' ";
// $strSQL .=",department = '".$_POST["department"]."' ";
// $strSQL .=",row_num = '".$_POST["num"][$t]."' ";
// $strSQL .=",barcode = '".$barcode_random."' ";
// $strSQL .=",detail = '".$_POST["detail"][$t]."' ";
// $strSQL .=",pcs = '".$_POST["pcs"][$t]."' ";
// $strSQL .=",unit = '".$_POST["unit"][$t]."' ";
// $strSQL .=",price = '".$_POST["price"][$t]."' ";
// $strSQL .=",total = '".$_POST["total"][$t]."' ";
// $objQuery = mysql_query($strSQL)or die(mysql_error()); 

$strSQL .="nobill_location   =  '".$_POST["no"]."' ";
$strSQL .=",dateday = '".date_return($_POST["dateday1"])."'";
$strSQL .=",total_money = '".num_convertbric(str_ireplace(",","",$_POST["total_bath"]))."' ";
$strSQL .=",company = '".$_POST["supply_code"]."'";
//$strSQL .=",nobill_recipt = nobill(bill)";
$strSQL .=",type_hire = '".$_POST["group_type"]."' ";
$strSQL .=",department =  '".$_POST["department"]."' ";
$strSQL .=",daterecipt = '".date_return($_POST["dateday2"])."' ";
$objQuery = mysql_query($strSQL)or die(mysql_error()); 


echo ("<script> window.open('egp.php?')</script>");
echo ("<script> window.location='../display_index.php'</script>");
}else if($_POST["submit"]=="search"){


$sql = "SELECT * from egp where ".$_POST["type"]." like '%".$_POST["search"]."%' ";
$result = mysql_query($sql);
echo "<table style='width:550px;'>";
while ($row = mysql_fetch_array($result) ) {

echo "<tr class='div_hover' ondblclick=\"window.open('egp_edit.php?no=$row[no]')\">"
	."<td valign='top' style='border-bottom:1px solid #a0a0a0;width:200px;'>$row[no] <br> ".substr($row[datebill],8,2)."-".substr($row[datebill],5,2)."-".substr($row[datebill],0,4)."</td>"
	."<td valign='top' style='border-bottom:1px solid #a0a0a0;width:300px;text-align:left;'>$row[detail]</td>"
	."<td valign='top' style='border-bottom:1px solid #a0a0a0;width:80px;'>".number_format($row[total])."</td>"
	."</tr>";

}

echo "</table>";


}else if($_POST["submit"]=="return_product_egp"){

  $strSQL = "SELECT * FROM egp_product WHERE no = '".trim(str_replace("/","-",num_convertbric($_POST["no"])))."' AND store = 'out' ";
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

}else if($_POST["submit"]=="fileupload_publish"){

function password_generate($chars) 
{
  $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
  return substr(str_shuffle($data), 0, $chars);
}
  $num = password_generate(4);


   if (move_uploaded_file($_FILES["file"]["tmp_name"], "../../images/publish".$num.".jpg")) {
    chmod("../../images/publish.jpg",0777);
      print "Uploaded successfully!";

      $strSQL = "UPDATE egp_title SET "; 
        $strSQL .="publish = 'publish".$num.".jpg' ";
        $strSQL .="WHERE row_id = '1' ";
        $objQuery = mysql_query($strSQL)or die(mysql_error());
      
   } else {
      print "Upload failed!";
   }


}
?>