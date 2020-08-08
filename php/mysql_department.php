<?
session_start();
include("connect.inc");

 if($_POST["submit"]=="return_department"){

  if($_POST["row_id"]){
    $search = "row_id = '".$_POST["row_id"]."'";
  }else if($_POST["search"]){
    $search = "name like '%".$_POST["search"]."%'";
  }else{
    $search = "row_id like '%'";
  }

   $strSQL = "SELECT * FROM department where $search ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
        $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
        if(mysql_field_name($objQuery,$i)=="group_location"){
          if($obResult[$i]==1){
            $arrCol["name_location"]="แม่ข่าย (รพ.)";
          }else if($obResult[$i]==2){
            $arrCol["name_location"]="ลูกข่าย";
          }
        }
    }

    array_push($resultArray,$arrCol);
  }
    echo json_encode($resultArray);

}else if($_POST["submit"]=="save_department"){

$sql="SELECT * FROM department where row_id = '".$_POST["row_id"]."'";
$result = mysql_query($sql);
if(mysql_num_rows($result)){
$strSQL = "UPDATE department SET ";
$strSQL .="name = '".$_POST["detail"]."' ";
$strSQL .=",group_location = '".$_POST["group_location"]."' ";
$strSQL .="WHERE row_id = '".$_POST["row_id"]."' ";
$objQuery = mysql_query($strSQL);    
}else{

$sqll = "SELECT code from department ORDER by row_id DESC limit 1  ";
list($code) = Mysql_fetch_row(Mysql_Query($sqll));
$code++;

$strSQL = "INSERT INTO department SET "; 
$strSQL .="row_id = '".$_POST["row_id"]."' ";
$strSQL .=",code = '".$code."' ";
$strSQL .=",name = '".$_POST["detail"]."' ";
$strSQL .=",group_location = '".$_POST["group_location"]."' ";
$objQuery = mysql_query($strSQL);
}

if($objQuery){
	echo "true";
}else{
	echo "false";
}


}else if($_POST["submit"]=="return_department_no"){

$sql = "SELECT row_id from department ORDER by row_id DESC limit 1  ";
list($row_id) = Mysql_fetch_row(Mysql_Query($sql));
echo $row_id+1;
}else if($_POST["submit"]=="del_department"){

  $sql_del = "DELETE FROM department WHERE row_id = '".$_POST["row_id"]."' "; 
  $query = mysql_query($sql_del);

}
?>