<?session_start();
include("connect.inc");
 if($_POST["submit"]=="return_data"){

  $strSQL = "SELECT sum(total),department,row_id FROM copy_sheet WHERE dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%' GROUP By department";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  $total_copy=array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      if(mysql_field_name($objQuery,$i)=="department"){
        $sql = "SELECT name from department where code = '$obResult[$i]'  limit 1  ";
        list($name) = Mysql_fetch_row(Mysql_Query($sql));
        $arrCol["department_name"] = $name;
      }
    }

    array_push($total_copy, $arrCol["sum(total)"]);
    $arrCol["total_copy"]=array_sum($total_copy);
    array_push($resultArray,$arrCol);
  }
  
  //mysql_close($Conn);
  
  echo json_encode($resultArray);

}else if($_POST["submit"]=="save_data"){

  $sql = "SELECT nobill from copy_sheet order by nobill desc  limit 1  ";
list($bill) = Mysql_fetch_row(Mysql_Query($sql));

$mr = substr($bill,4,2);
if(str_pad($mr,2,'0',STR_PAD_LEFT)!=date("m")){
  $nobill="CO".(date("y")+43).date("m")."001";
}else{
 $nobill="CO".(date("y")+43).date("m").str_pad(substr($bill,6,3)+1, 3,'0',STR_PAD_LEFT);
}

$strSQL = "INSERT INTO copy_sheet SET ";
$strSQL .="dateday = '".$_POST["dateday"]."' ";
$strSQL .=",nobill = '".$nobill."' ";
$strSQL .=",department = '".$_POST["department"]."' ";
$strSQL .=",meter_start = '".$_POST["meter_start"]."' ";
$strSQL .=",meter_end = '".$_POST["meter_end"]."' ";
$strSQL .=",total = '".$_POST["total"]."' ";
$objQuery = mysql_query($strSQL);


}else if($_POST["submit"]=="return_month"){

  $strSQL = "SELECT * FROM copy_sheet WHERE dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%' order by dateday asc";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();

  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      if(mysql_field_name($objQuery,$i)=="department"){
        $sql = "SELECT name from department where code = '$obResult[$i]'  limit 1  ";
        list($name) = Mysql_fetch_row(Mysql_Query($sql));
        $arrCol["department_name"] = $name;
      }
    }

    array_push($resultArray,$arrCol);
  }
  
  //mysql_close($Conn);
  
  echo json_encode($resultArray);

}else if($_POST["submit"]=="del_data"){


    $sql_del = "DELETE FROM copy_sheet WHERE row_id = '".$_POST["row_id"]."' ";
  $query = mysql_query($sql_del);
}

?>
