<?
session_start();
include("../../php/connect.inc");
function num_convertbric($str){
$numthai = array("๑","๒","๓","๔","๕","๖","๗","๘","๙","๐");
$numarabic = array("1","2","3","4","5","6","7","8","9","0");
return str_replace($numthai,$numarabic,$str);
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
case "กรกฏาคม": $str = "07"; break;
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

echo("<script> alert('บันทึกเรียบร้อย'); </script>");
}
else
{
	echo "File can not write";
	echo("<script> alert('ไม่สามารถบันทึกได้'); </script>");
}

fclose($objFopen);

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
  echo("ลบสำเร็จ");
  }




}else if($_POST["submit"]=="ทำใบจัดซื้อจัดจ้าง"){

$strSQL = "UPDATE egp_title SET ";
//$strSQL = "INSERT INTO egp_title SET "; 
$strSQL .="no = '".$_POST["no"]."' ";
$strSQL .=",no_requat = '".$_POST["no_requat"]."' ";
$strSQL .=",dateday1 = '".$_POST["dateday1"]."' ";
$strSQL .=",dateday2 = '".$_POST["dateday2"]."' ";
$strSQL .=",pcs_detail = '".$_POST["pcs_detail"]."' ";
$strSQL .=",product = '".str_ireplace("\n","<br>",$_POST["product"])."' ";
$strSQL .=",total_bath = '".$_POST["total_bath"]."' ";
$strSQL .=",total_bath_word = '".$_POST["total_bath_word"]."' ";
$strSQL .=",office01 = '".str_ireplace("\n","<br>",$_POST["office01"])."' ";
$strSQL .=",office02 = '".str_ireplace("\n","<br>",$_POST["office02"])."' ";
$strSQL .=",director = '".str_ireplace("\n","<br>",$_POST["director"])."' ";
$strSQL .=",supply_name = '".$_POST["supply_name"]."' ";
$strSQL .=",supply_addres = '".$_POST["supply_addres"]."' ";
$strSQL .=",supply_phone = '".$_POST["supply_phone"]."' ";
$strSQL .=",supply_tax = '".$_POST["supply_tax"]."' ";
$strSQL .="WHERE row_id = '1' ";
$objQuery = mysql_query($strSQL);

echo ("<script> window.open('egp.php?')</script>");
echo ("<script> window.location='display.php'</script>");
}
?>