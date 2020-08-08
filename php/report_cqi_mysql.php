<?session_start();
include("connect.inc");
 if($_POST["submit"]=="return_data"){

function rangweek ( $year, $month ) {
    $last_month_day_num = cal_days_in_month(CAL_GREGORIAN, $month, $year); 

    $first_month_day_timestamp = strtotime($year.'-'.$month.'-01');
    $last_month_daty_timestamp = strtotime($year.'-'.$month.'-'.$last_month_day_num );

    $first_month_week = date('W', $first_month_day_timestamp);
    $last_month_week = date('W', $last_month_daty_timestamp);

    $mweek = array();
    for( $week = $first_month_week; $week <= $last_month_week; $week ++ ) {
        #echo sprintf('%d-%02d-1', $year, $week ), "\n <br>";
        array_push( $mweek, array(  
            date("Y-m-d", strtotime( sprintf('%dW%02d-1', $year, $week ) ) ),
            date("Y-m-d", strtotime( sprintf('%dW%02d-7', $year, $week ) ) ),
        ) );
    }
    return $mweek;
}

$mweek = rangweek(($_POST["y"]-543),$_POST["m"]);
$cm = count($mweek);


// for($i=0;$i<=$cm-1;$i++){
//   echo $i.". ".$mweek[$i][0]." - ".$mweek[$i][1]."<hr>";
// }





$sql_d = "SELECT code,name from department  ";
$result_d = mysql_query($sql_d);
$resultArray = array();
while ($dep = mysql_fetch_array($result_d) ) {
$arrCol = array();

$strSQL = "SELECT sum(pcs) FROM bill WHERE nobill_system like 'OWH%' AND dateday like '".$_POST["y"]."-".$_POST["m"]."%' AND customer_id = '$dep[code]' ";
list($sumpcs) = Mysql_fetch_row(Mysql_Query($strSQL));

if($sumpcs==null){
  $sumpcs = "0";
}


$arrCol["customer_name"] = $dep["name"];
$arrCol["sumpcs"] = $sumpcs;

 for($i=0;$i<$cm;$i++){
//   echo $i.". ".$mweek[$i][0]." - ".$mweek[$i][1]."<hr>";
if($i==0){
$strSQL = "SELECT sum(pcs) FROM bill WHERE nobill_system like 'OWH%' AND customer_id = '$dep[code]' AND  dateday BETWEEN '".(substr($mweek[$i][1],0,4)+543).substr($mweek[$i][1],4,4)."01' AND '".(substr($mweek[$i][1],0,4)+543).substr($mweek[$i][1],4,6)."' ";
}else{
$strSQL = "SELECT sum(pcs) FROM bill WHERE nobill_system like 'OWH%' AND customer_id = '$dep[code]' AND  dateday BETWEEN '".(substr($mweek[$i][0],0,4)+543).substr($mweek[$i][0],4,6)."' AND '".(substr($mweek[$i][1],0,4)+543).substr($mweek[$i][1],4,6)."'  ";
}

list($sumpcsx) = Mysql_fetch_row(Mysql_Query($strSQL));

if($sumpcsx==null){
  $sumpcsx = "";
}
$arrCol["pcs$i"]=$sumpcsx;


 }




array_push($resultArray,$arrCol);
}





  // $strSQL = "SELECT *,sum(pcs),sum(pcs*price) FROM bill WHERE nobill_system like 'OWH%' AND dateday like '".$_POST["y"]."-".$_POST["m"]."%' GROUP By customer_id";
  // $objQuery = mysql_query($strSQL) or die (mysql_error());
  // $intNumField = mysql_num_fields($objQuery);
  // $resultArray = array();
  // $total_warehouse=array();
  // while($obResult = mysql_fetch_array($objQuery))
  // {
  //   $arrCol = array();
  //   for($i=0;$i<$intNumField;$i++)
  //   {
  //     $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
  //   }
  //   array_push($total_warehouse, $arrCol["sum(pcs*price)"]);
  //   $arrCol["sum_warehouse"]= array_sum($total_warehouse);
    //array_push($resultArray,$arrCol);
  // }
  
  // //mysql_close($Conn);
  
   echo json_encode($resultArray);

}
?>
