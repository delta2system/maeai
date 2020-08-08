<?
session_start();
include("connect.inc");

if($_POST["submit"]=="return_personal"){

function ps_detail($str){
$sql = "SELECT position_detail from position_personal where code = '$str'  limit 1  ";
list($position_detail) = Mysql_fetch_row(Mysql_Query($sql));
return $position_detail;
}

	if($_POST["row_id"]){
		$search = $_POST["row_id"];
	}else{
		$search = "%";
	}

   $strSQL = "SELECT * FROM personal where row_id like '".$search."'";
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

    $arrCol["position_detail"] =ps_detail($obResult[position]);

    array_push($resultArray,$arrCol);
  }
    echo json_encode($resultArray);
}else if($_POST["submit"]=="save_personal"){

$sql="SELECT * FROM personal where code = '".$_POST["code"]."'";
$result = mysql_query($sql);
if(mysql_num_rows($result)){
$strSQL = "UPDATE personal SET ";
$strSQL .="name = '".$_POST["name"]."' ";
$strSQL .=",position = '".$_POST["position"]."' ";
$strSQL .="WHERE code = '".$_POST["code"]."' ";
$objQuery = mysql_query($strSQL);    
}else{
$strSQL = "INSERT INTO personal SET "; 
$strSQL .="code = '".$_POST["code"]."' ";
$strSQL .=",name = '".$_POST["name"]."' ";
$strSQL .=",position = '".$_POST["position"]."' ";
$objQuery = mysql_query($strSQL);
}

if($objQuery){
	echo "true";
}else{
	echo "false";
}


}else if($_POST["submit"]=="del_personal"){

  $sql_del = "DELETE FROM personal WHERE code = '".$_POST["code"]."' "; 
  $query = mysql_query($sql_del);

}else if($_POST["submit"]=="return_position_personal"){

   $strSQL = "SELECT * FROM position_personal where row_id like '".$_POST["row_id"]."'";
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

}else if($_POST["submit"]=="del_position"){

  $sql_del = "DELETE FROM position_personal WHERE code = '".$_POST["code"]."' "; 
  $query = mysql_query($sql_del);

}else if($_POST["submit"]=="save_position"){

$sql="SELECT * FROM position_personal where code = '".$_POST["code"]."'";
$result = mysql_query($sql);
if(mysql_num_rows($result)){
$strSQL = "UPDATE position_personal SET ";
$strSQL .="position_detail = '".$_POST["name"]."' ";
$strSQL .="WHERE code = '".$_POST["code"]."' ";
$objQuery = mysql_query($strSQL);    
}else{
$strSQL = "INSERT INTO position_personal SET "; 
$strSQL .="code = '".$_POST["code"]."' ";
$strSQL .=",position_detail = '".$_POST["name"]."' ";
$objQuery = mysql_query($strSQL);
}

if($objQuery){
	echo "true";
}else{
	echo "false";
}


}else if($_POST["submit"]=="return_customer"){

	// if($_POST["row_id"]){
	// 	$search = $_POST["row_id"];
	// }else{
	// 	$search = "%";
	// }

  if($_POST["row_id"]){
    $search = "row_id = '".$_POST["row_id"]."'";
  }else if($_POST["search"]){
    $search = "name like '%".$_POST["search"]."%'";
  }else{
    $search = "row_id like '%'";
  }

   $strSQL = "SELECT * FROM customer_supply where $search ";
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

}else if($_POST["submit"]=="save_customer"){

$sql="SELECT * FROM customer_supply where code = '".$_POST["code"]."'";
$result = mysql_query($sql);
if(mysql_num_rows($result)){
$strSQL = "UPDATE customer_supply SET ";
$strSQL .="name = '".$_POST["name"]."' ";
$strSQL .=",address = '".$_POST["address"]."' ";
$strSQL .=",phone = '".$_POST["phone"]."' ";
$strSQL .=",fax = '".$_POST["fax"]."' ";
$strSQL .=",tax = '".$_POST["tax"]."' ";
$strSQL .="WHERE code = '".$_POST["code"]."' ";
$objQuery = mysql_query($strSQL);    
}else{
$strSQL = "INSERT INTO customer_supply SET "; 
$strSQL .="code = '".$_POST["code"]."' ";
$strSQL .=",name = '".$_POST["name"]."' ";
$strSQL .=",address = '".$_POST["address"]."' ";
$strSQL .=",phone = '".$_POST["phone"]."' ";
$strSQL .=",fax = '".$_POST["fax"]."' ";
$strSQL .=",tax = '".$_POST["tax"]."' ";
$objQuery = mysql_query($strSQL);
}

if($objQuery){
	echo "true";
}else{
	echo "false";
}


}else if($_POST["submit"]=="return_customer_no"){

$sql = "SELECT code from customer_supply ORDER by code DESC limit 1  ";
list($code) = Mysql_fetch_row(Mysql_Query($sql));
echo str_pad($code+1,3,"0",STR_PAD_LEFT);
}else if($_POST["submit"]=="del_customer_supply"){

  $sql_del = "DELETE FROM customer_supply WHERE code = '".$_POST["code"]."' "; 
  $query = mysql_query($sql_del);

}else if($_POST["submit"]=="return_type_group"){

	if($_POST["row_id"]){
		$search = $_POST["row_id"];
	}else{
		$search = "%";
	}

   $strSQL = "SELECT * FROM group_type where row_id like '".$search."'";
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

}else if($_POST["submit"]=="del_group_type"){
  $sql_del = "DELETE FROM group_type WHERE code = '".$_POST["code"]."' "; 
  $query = mysql_query($sql_del);
}else if($_POST["submit"]=="save_group_type"){
$sql="SELECT * FROM group_type where code = '".$_POST["code"]."'";
$result = mysql_query($sql);
if(mysql_num_rows($result)){

$strSQL = "UPDATE group_type SET ";
$strSQL .="detail = '".$_POST["detail"]."' ";
$strSQL .="WHERE code = '".$_POST["code"]."' ";
$objQuery = mysql_query($strSQL);    

}else{

$strSQL = "INSERT INTO group_type SET "; 
$strSQL .="code = '".$_POST["code"]."' ";
$strSQL .=",detail = '".$_POST["detail"]."' ";
$objQuery = mysql_query($strSQL);
}

if($objQuery){
	echo "true";
}else{
	echo "false";
}

}
?>