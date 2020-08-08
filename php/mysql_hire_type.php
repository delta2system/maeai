<?
session_start();
include("connect.inc");

 if($_POST["submit"]=="return_hire_type"){

  if($_POST["row_id"]){
    $search = "row_id = '".$_POST["row_id"]."'";
  }else if($_POST["search"]){
    $search = "detail like '%".$_POST["search"]."%'";
  }else{
    $search = "row_id like '%'";
  }

   $strSQL = "SELECT * FROM hire_type where $search ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      
        $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
        if(mysql_field_name($objQuery,$i)=="material_type"){
          $sql = "SELECT detail from material_type WHERE row_id ='".$obResult[$i]."' ";
          list($material_type) = Mysql_fetch_row(Mysql_Query($sql));
          if(empty($material_type)){$material_type="";}
          $arrCol["material"]=$material_type;
        }
    }

    array_push($resultArray,$arrCol);
  }
    echo json_encode($resultArray);

}else if($_POST["submit"]=="save_hire_type"){

$sql="SELECT * FROM hire_type where row_id = '".$_POST["row_id"]."'";
$result = mysql_query($sql);
if(mysql_num_rows($result)){
$strSQL = "UPDATE hire_type SET ";
$strSQL .="detail = '".$_POST["detail"]."' ";
$strSQL .=",material_type = '".$_POST["material_type"]."' ";
$strSQL .="WHERE row_id = '".$_POST["row_id"]."' ";
$objQuery = mysql_query($strSQL);    
}else{
$strSQL = "INSERT INTO hire_type SET "; 
$strSQL .="row_id = '".$_POST["row_id"]."' ";
$strSQL .=",detail = '".$_POST["detail"]."' ";
$strSQL .=",material_type = '".$_POST["material_type"]."' ";
$objQuery = mysql_query($strSQL);
}

if($objQuery){
	echo "true";
}else{
	echo "false";
}


}else if($_POST["submit"]=="return_hire_type_no"){

$sql = "SELECT row_id from hire_type ORDER by row_id DESC limit 1  ";
list($row_id) = Mysql_fetch_row(Mysql_Query($sql));
echo $row_id+1;
}else if($_POST["submit"]=="del_hire_type"){

  $sql_del = "DELETE FROM hire_type WHERE row_id = '".$_POST["row_id"]."' "; 
  $query = mysql_query($sql_del);

}
?>