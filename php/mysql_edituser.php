<?
session_start();
include("connect.inc");
if($_POST["submit"]=="checkbox_edit"){
//&row_id='+id+"&tbl="+tbl+"&val="+val.value+"&status="+val.checked

	if($_POST["tbl"]=="edit_stock"){
		if($_POST["status"]=="true"){
		$sql_update = "UPDATE user_account SET stock_edit='1' WHERE row_id='".$_POST["row_id"]."' ";
		$result_update= mysql_query($sql_update) or die(mysql_error());
		}else if($_POST["status"]=="false"){
		$sql_update = "UPDATE user_account SET stock_edit='0' WHERE row_id='".$_POST["row_id"]."' ";
		$result_update= mysql_query($sql_update) or die(mysql_error());
		}
	}else if($_POST["tbl"]=="menu_code"){

		$sql = "SELECT menu_code from user_account where row_id='".$_POST["row_id"]."'  ";
		list($menu_code) = Mysql_fetch_row(Mysql_Query($sql));
		$f_val="";

		if($_POST["status"]=="true"){
			$f_val=$menu_code.",".$_POST["val"];

		}else if($_POST["status"]=="false"){
			$vx = explode(",",$menu_code);
			
			for($i=1;$i<count($vx);$i++){
				if($_POST["val"]!=$vx[$i]){
					$f_val.=",".$vx[$i];
				}
			}
		}
		$sql_update = "UPDATE user_account SET menu_code='$f_val' WHERE row_id='".$_POST["row_id"]."' ";
		$result_update= mysql_query($sql_update) or die(mysql_error());

	}
}else if($_POST["submit"]=="save_user"){

$resultArray = array();
$arrCol = array();
$strSQL = "UPDATE user_account SET ";
$strSQL .="username = '".$_POST["username"]."' ";
$strSQL .=",passwd = '".$_POST["passwd"]."' ";
$strSQL .=",email = '".$_POST["email"]."' ";
$strSQL .=",fullname = '".$_POST["fullname"]."' ";
$strSQL .=",position = '".$_POST["position"]."' ";
$strSQL .="WHERE row_id = '".$_POST["row_id"]."' ";
$objQuery = mysql_query($strSQL); 

 if($objQuery){
$arrCol["status"]="true";
$arrCol["msg"]="บันทึกเรียบร้อย";
}else{
$arrCol["status"]="false";
$arrCol["msg"]="ไม่สามารถบันทึกได้";
}
array_push($resultArray,$arrCol);
echo json_encode($resultArray);
}else if($_POST["submit"]=="del_user"){

  $sql_del = "DELETE FROM user_account WHERE row_id = '".$_POST["id"]."' "; 
  $query = mysql_query($sql_del);

}else if($_POST["submit"]=="status_user"){
	print_r($_POST);
	if($_POST["check"]=="true"){
		$st=1;
	}else{
		$st=0;
	}
		$sql_update = "UPDATE user_account SET status='$st' WHERE row_id='".$_POST["id"]."' ";
		$result_update= mysql_query($sql_update) or die(mysql_error());

}else if($_POST["submit"]=="add_user"){

$strSQL = "INSERT INTO user_account SET "; 
$strSQL .="username = '".$_POST["username"]."' ";
$strSQL .=",passwd = '".$_POST["passwd"]."' ";
$strSQL .=",email = '".$_POST["email"]."' ";
$strSQL .=",fullname = '".$_POST["fullname"]."' ";
$strSQL .=",position = '".$_POST["position"]."' ";
$strSQL .=",menu_code = '".$_POST["menu_code"]."' ";
$strSQL .=",status = '1' ";
$strSQL .=",regis_start = '".date("Y-m-d H:i:s")."' ";
if($_POST["edit_stock"]=="true"){
$strSQL .=",stock_edit = '1' ";
}
//echo $strSQL;
$objQuery = mysql_query($strSQL);

}
?>