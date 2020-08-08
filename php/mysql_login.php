<?php
session_start();
include("connect.inc");

if($_POST["submit"]=="login"){
$arrCol=array();
$resultArray=array();

$result = mysql_query("SELECT * FROM user_account where username = '".$_POST["user"]."'");
if(mysql_num_rows($result)){

$result_passwd = mysql_query("SELECT username,email,fullname,menu_code,position,row_id FROM user_account where username = '".$_POST["user"]."' AND passwd = '".$_POST["password"]."' AND status = '1'");
if(mysql_num_rows($result_passwd)){

$arrCol["status"]="true";
$arrCol["msg"]="";

list($username,$email,$fullname,$menu_code,$position,$row_id) = Mysql_fetch_row($result_passwd);
$_SESSION["xusername"]=$username;
$_SESSION["xfullname"]=$fullname;
$_SESSION["xemail"]=$email;
$_SESSION["xmenu_code"]=$menu_code;
$_SESSION["xposition"]=$position;
$_SESSION["xid"]=$row_id;


		$sql_update = "UPDATE user_account SET last_login='".date("Y-m-d H:i:s")."' WHERE row_id='".$row_id."' ";
		$result_update= mysql_query($sql_update) or die(mysql_error());


}else{
$arrCol["status"]="false";
$arrCol["msg"]="รหัสผ่านไม่ถูกต้อง";
}


}else{
$arrCol["status"]="false";
$arrCol["msg"]="ชื่อผู้ใช้ไม่ถูกต้อง";
}

array_push($resultArray,$arrCol);
echo json_encode($resultArray);

}
?>