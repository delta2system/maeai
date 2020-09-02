<?
session_start();
include("connect.inc");

if($_POST["submit"]=="updatetime"){


		$sql_update = "UPDATE tbl_warehousetime SET ";
		if($_POST["status"]==1){
		$sql_update .= "time1='".$_POST["t1"]."',time2='".$_POST["t2"]."', ";
		}
		$sql_update .= "status='".$_POST["status"]."' WHERE row='".$_POST["row"]."' ";
		$result_update= mysql_query($sql_update) or die(mysql_error());

		if($_POST["status"]==1){
		$sql_update = "UPDATE tbl_warehousetime SET ";
		$sql_update .="status='0' WHERE row='8' ";
		$result_update= mysql_query($sql_update) or die(mysql_error());
		}

}else if($_POST["submit"]=="update_date"){
		$sql_update = "UPDATE tbl_warehousetime SET ";
		if($_POST["status"]==1){
		$sql_update .="date1='".$_POST["d1"]."',date2='".$_POST["d2"]."', ";
		}
		$sql_update .="status='".$_POST["status"]."' WHERE row='".$_POST["row"]."' ";
		$result_update= mysql_query($sql_update) or die(mysql_error());

		if($_POST["status"]==1){
			for ($n=1; $n <= 7 ; $n++) { 
		$sql_update = "UPDATE tbl_warehousetime SET ";
		$sql_update .="status='0' WHERE row='".$n."' ";
		$result_update= mysql_query($sql_update) or die(mysql_error());
			}
		}

}else if($_POST["submit"]=="update_time1now"){

		 $sql_update = "UPDATE tbl_warehousetime SET time1='".$_POST["t1"]."' WHERE row='".$_POST["row"]."' ";
		$result_update= mysql_query($sql_update) or die(mysql_error());

}else if($_POST["submit"]=="update_time2now"){

		 $sql_update = "UPDATE tbl_warehousetime SET time2='".$_POST["t2"]."' WHERE row='".$_POST["row"]."' ";
		$result_update= mysql_query($sql_update) or die(mysql_error());

}else if($_POST["submit"]=="update_datenow1"){
	if($_POST["d1"]){
 $sql_update = "UPDATE tbl_warehousetime SET date1='".$_POST["d1"]."' WHERE row='".$_POST["row"]."' ";
		$result_update= mysql_query($sql_update) or die(mysql_error());
	}else if($_POST["d2"]){
 $sql_update = "UPDATE tbl_warehousetime SET date2='".$_POST["d2"]."' WHERE row='".$_POST["row"]."' ";
		$result_update= mysql_query($sql_update) or die(mysql_error());	
	}
}else if($_POST["submit"]=="save_text"){

 		$sql_update = "UPDATE tbl_warehousetime SET ";
 		if($_POST["text"]){
 		$sql_update.= "other='".$_POST["text"]."', ";
 		}
 		$sql_update.= "status='".$_POST["status"]."' WHERE row='9' ";
		$result_update= mysql_query($sql_update) or die(mysql_error());	


}else if($_POST["submit"]=="return_data"){

  $strSQL = "SELECT * FROM tbl_warehousetime ";
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
}
?>