<?
session_start();
include("connect.php");
?>	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
  <link rel="stylesheet" href="../css/loader.css">
<style type="text/css">
	table{
		border-collapse: collapse;
		
	}
	td{
		border:1px solid #a2a2a2;
		font-size: 9px;
	}
	  @media print {
    .page_breck {page-break-after: always;}
}
</style>
         <div class="display_loader" style="width:100%;height:100%;position: fixed;top:0px;left:0px;background-color: rgba(0,0,0,0.7);z-index: 99;">
              <div style="width:120px;height:150px;position: fixed;left:50%;top:50%;margin-left: -60px;margin-top: -75px;">
            <div class="loader"></div>
            <div style="font-size: 20px;width:120px;text-align:center;color:#c0c0c0;margin-top:5px;font-family: Tahoma;">Loading....</div>
            </div>
            </div>
<?

function recheck_bath($str){
	if($str!=null && $str!==""){
		$new_str=number_format($str,2);
		
	}else{
		$new_str = "";
	}
	return $new_str;
}

if($_GET["year"]){
	$now_year=$_GET["year"];
	if($now_year>"2500"){
		$now_year=$now_year-543;
	}
}else{
	$now_year=date("Y");
}

$sql_t="SELECT code,detail FROM store_type ORDER By code ";
$result_t = mysqli_query($con,$sql_t);
while ($data = mysqli_fetch_array($result_t) ) {
$t=0;
$total_1=array("");
$total_2=array("");
$total[10]=array("");
$total[11]=array("");
$total[12]=array("");
$total[1]=array("");
$total[2]=array("");
$total[3]=array("");
$total[4]=array("");
$total[5]=array("");
$total[6]=array("");
$total[7]=array("");
$total[8]=array("");
$total[9]=array("");
$total_3=array("");
$total_4=array("");
$sql="SELECT * FROM store WHERE store_type = '$data[code]' AND ( (daterecipt < '2563-01-01' AND priceofsets < 5000) OR (priceofsets < 10000 AND daterecipt > '2563-01-01')) ORDER By daterecipt ASC ";
$result = mysqli_query($con,$sql);
$num_r = mysqli_num_rows($result);
if($num_r){
print "<table style='width:1100px;'>";
echo "<thead>".
	 "<tr>".
	 "<td colspan='22' style='text-align:center;border:1px solid #a2a2a2;font-size:18px;font-weight:bold;'>ค่าเสื่อมราคาครุภัณฑ์ $data[detail] ปี ".($now_year+543)."</td>".
	 "<tr><td style='text-align:center;background-color:#e2e2e2;'>#</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>วันที่รับ</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>รหัส</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>รายการ</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>อายุใช้งาน</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>อัตราค่าเสื่อม</td>".
	// "<td style='text-align:center;background-color:#e2e2e2;'>คส/เดือน</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>ราคาครุภัณฑ์</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>ปีงบ2560</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>ต.ค.</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>พ.ย.</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>ธ.ค.</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>ม.ค.</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>ก.พ.</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>มี.ค.</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>เม.ย.</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>พ.ค.</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>มิ.ย.</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>ก.ค.</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>ส.ค.</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>ก.ย.</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>ค่าเสื่อมสะสม 61</td>".
	 "<td style='text-align:center;background-color:#e2e2e2;'>คส/สะสม</td>";
	 //"<td style='text-align:center;background-color:#e2e2e2;'>เดือน/สะสม</td>";\
	 echo "</thead><tbody>";
	 $sum_dis2=array();
while ($row = mysqli_fetch_array($result) ) {
$m=0;
for($nl=1;$nl<=12;$nl++){
$mon[$nl]="";
}
$last_dy=0;
$d1=(substr($row[daterecipt], 0,4)+$row[lifetime]).substr($row[daterecipt], 5,2).substr($row[daterecipt], 8,2);
$d2=($now_year+543).date("m").date("d");

if($d1>=$d2){
	$t++;
	if($t%2==0){$cel="#ffffff";}else{$cel="#f2f2f2";}
echo "<tr style='background-color:$cel;'><td style='text-align:center;'>$t  </td><td>".substr($row[daterecipt], 8,2)."-".substr($row[daterecipt], 5,2)."-".substr($row[daterecipt], 0,4)."&nbsp;&nbsp;&nbsp;</td>".
	"<td >&nbsp;&nbsp;".$row[code]."&nbsp;&nbsp;&nbsp;</td>".
	"<td>&nbsp;&nbsp;".$row[attribute]."&nbsp;&nbsp;&nbsp;</td>".
	"<td style='text-align:center;'> ".$row[lifetime]." ปี</td>".
    "<td style='text-align:center;'> ".$row[depreciation]."</td>";

	//echo "<td style='text-align:center;'> ".($row[lifetime]*12)." ด. </td> ";
	if($row[priceofsets]!=0 && $row[priceofsets]!=""){
		 $cal=(($row[numberofsets]*$row[priceofsets]))/($row[lifetime]*12);
		}else{
			$cal=0;
		}
		//echo "<td style='text-align:right;'>".recheck_bath($cal)."&nbsp;&nbsp;</td>";

	if(substr($row[daterecipt], 8,2)>=15){
		$m_start=str_pad(substr($row[daterecipt], 5,2)+1,2,"0",STR_PAD_LEFT);
		if($m_start==13){
		$y_start=(substr($row[daterecipt], 0,4)+1)."01";
		}else{
		$y_start=substr($row[daterecipt], 0,4).$m_start;	
		}
	}else{
		$m_start=substr($row[daterecipt], 5,2);
		$y_start=substr($row[daterecipt], 0,4).$m_start;
	}
	
	//$y_end=substr($row[daterecipt], 0,4)+$row[lifetime];
	$y_end=($now_year+543).date("m");

	//echo "<td>".$y_start."==>".$y_end."</td>";
	//echo "<td style='text-align:center;'> ".$row[depreciation]."</td>";
	echo "<td style='text-align:right;'>".recheck_bath(($row[numberofsets]*$row[priceofsets]),2)."&nbsp;&nbsp;</td>";
	echo "<td style='text-align:right;background-color:#ffdbdb;'>";
	while($y_start<=$y_end){
		//echo $y_start."<br>";
		if(substr($y_start,4,2)==12){
			$y_start=(substr($y_start,0,4)+1)."01";
			$m++;
		}else{
			$y_start=substr($y_start,0,4).str_pad(substr($y_start, 4,2)+1,2,"0",STR_PAD_LEFT);
			$m++;
		}

		
	}
	//ค่าเสื่อมปัจจุบัน
	if($m>=12){
		$last_dy= ($m-(date("m")+3))*$cal;
		echo recheck_bath($last_dy);

	}else if($m<12){

		
		if(substr($row[daterecipt], 0,4).substr($row[daterecipt], 5,2).substr($row[daterecipt], 8,2)<substr($row[daterecipt], 0,4)."0915" && substr($row[daterecipt], 0,4)!=($now_year+543)){
			if(substr($row[daterecipt], 8,2)<15){
			$sum_dis=($m-($m-1))*$cal;
			}else{
			$sum_dis=($m-(date("m")+3))*$cal;	
			}



			echo recheck_bath($sum_dis);
		}else if(substr($row[daterecipt], 0,4).substr($row[daterecipt], 5,2).substr($row[daterecipt], 8,2)>substr($row[daterecipt], 0,4)."0914"){
		 	echo $sum_dis="0.00";
		 }else {

		 	echo $sum_dis="0.00";
		 }


	}
	
	if((substr($row[daterecipt], 0,4)+$row[lifetime]).substr($row[daterecipt], 5,2).substr($row[daterecipt], 8,2)>($now_year+543)."0930"){

	 		 for($r=10;$r<=12;$r++){
	 		 	$d1=substr($row[daterecipt], 0,4).substr($row[daterecipt], 5,2);
	 		 	$d2=(substr($row[daterecipt], 0,4)+$row[lifetime]).substr($row[daterecipt], 5,2);
	 		 	if(($now_year+542).str_pad($r,2,"0",STR_PAD_LEFT) >= $d1 && ($now_year+542).str_pad($r,2,"0",STR_PAD_LEFT) < $d2 ){
	 		 		if($d1.substr($row[daterecipt], 8,2) > ($now_year+542).str_pad($r,2,"0",STR_PAD_LEFT)."14" ){

	 		 			$mon[$r]="";
	 		 		}else{
	 		 			$mon[$r]=$cal;
	 		 		}
	    	 	}else{
	 		 	$mon[$r]="";	
	 		 	}
			 }

	 		 for($r=1;$r<=9;$r++){
	 		 	//if((substr($row[daterecipt], 0,4)+$row[lifetime]).substr($row[daterecipt], 5,2)>($now_year+543).str_pad($r,2,"0",STR_PAD_LEFT)){
	 		 	$d1=substr($row[daterecipt], 0,4).substr($row[daterecipt], 5,2);
	 		 	$d2=(substr($row[daterecipt], 0,4)+$row[lifetime]).substr($row[daterecipt], 5,2);
	 		 	if(($now_year+543).str_pad($r,2,"0",STR_PAD_LEFT) >= $d1 && ($now_year+543).str_pad($r,2,"0",STR_PAD_LEFT) < $d2 ){
	 		 		if($d1.substr($row[daterecipt], 8,2) > ($now_year+543).str_pad($r,2,"0",STR_PAD_LEFT)."14" ){
	 		 			$mon[$r]="";
	 		 		}else{
	 		 		$mon[$r]=$cal;	
	 		 		}
	 		 		}else{
	 		 	$mon[$r]="";	
	 		 	}
			 }
	
	}else{
		if(substr($row[daterecipt], 5,2)<=9){

	 		 for($r=1;$r<=9;$r++){
	 		 	//if((substr($row[daterecipt], 0,4)+$row[lifetime]).substr($row[daterecipt], 5,2)>($now_year+543).str_pad($r,2,"0",STR_PAD_LEFT)){
	 		 	$d1=substr($row[daterecipt], 0,4).substr($row[daterecipt], 5,2);
	 		 	$d2=(substr($row[daterecipt], 0,4)+$row[lifetime]).substr($row[daterecipt], 5,2);
	 		 	if(($now_year+543).str_pad($r,2,"0",STR_PAD_LEFT) >= $d1 && ($now_year+543).str_pad($r,2,"0",STR_PAD_LEFT) <= $d2 ){
	 		 		if($d2.substr($row[daterecipt], 8,2) < ($now_year+543).str_pad($r,2,"0",STR_PAD_LEFT)."15" ){
	 		 			$mon[$r]="";	
	 		 			//$mon[$r+1]=$cal;	
	 		 		}else{
	 		 		$mon[$r]=$cal;	
	 		 		}
	 		 		}else{
	 		 	$mon[$r]="";	
	 		 	}
			 }

	 		 for($r=10;$r<=12;$r++){
	 		 	$mon[$r]=$cal;
	 		 }

		}else{

		}
	} 
		array_push($sum_dis2,$last_dy);
	echo "&nbsp;&nbsp;</td>";

	echo "<td style='text-align:right;'>".recheck_bath($mon[10])."&nbsp;</td>";
	echo "<td style='text-align:right;'>".recheck_bath($mon[11])."&nbsp;</td>";
	echo "<td style='text-align:right;'>".recheck_bath($mon[12])."&nbsp;</td>";
	echo "<td style='text-align:right;'>".recheck_bath($mon[1])."&nbsp;</td>";
	echo "<td style='text-align:right;'>".recheck_bath($mon[2])."&nbsp;</td>";
	echo "<td style='text-align:right;'>".recheck_bath($mon[3])."&nbsp;</td>";
	echo "<td style='text-align:right;'>".recheck_bath($mon[4])."&nbsp;</td>";
	echo "<td style='text-align:right;'>".recheck_bath($mon[5])."&nbsp;</td>";
	echo "<td style='text-align:right;'>".recheck_bath($mon[6])."&nbsp;</td>";
	echo "<td style='text-align:right;'>".recheck_bath($mon[7])."&nbsp;</td>";
	echo "<td style='text-align:right;'>".recheck_bath($mon[8])."&nbsp;</td>";
	echo "<td style='text-align:right;'>".recheck_bath($mon[9])."&nbsp;</td>";
//recheck_bath($cal*$m)
	
	echo "<td style='text-align:right;'>".recheck_bath(array_sum($mon))."&nbsp;</td>";
	echo "<td style='text-align:right;'>&nbsp;";
	echo recheck_bath(array_sum($mon)+$last_dy);
	echo "</td>";
	//echo "<td style='text-align:center;'>".$m." ด.</td>";
//echo $d2-$d1."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row[lifetime];
// if($row[lifetime]>=($d2-$d1)){
// 	echo $row[code];
// }

array_push($total_1,($row[numberofsets]*$row[priceofsets]));
array_push($total_2,$last_dy);
array_push($total[10],$mon[10]);
array_push($total[11],$mon[11]);
array_push($total[12],$mon[12]);
array_push($total[1],$mon[1]);
array_push($total[2],$mon[2]);
array_push($total[3],$mon[3]);
array_push($total[4],$mon[4]);
array_push($total[5],$mon[5]);
array_push($total[6],$mon[6]);
array_push($total[7],$mon[7]);
array_push($total[8],$mon[8]);
array_push($total[9],$mon[9]);
array_push($total_3,array_sum($mon));
array_push($total_4,(array_sum($mon)+$last_dy));
	}else{
$t++;
	if($t%2==0){$cel="#ffffff";}else{$cel="#f2f2f2";}
echo "<tr style='background-color:$cel;'><td style='text-align:center;'>$t  </td><td>".substr($row[daterecipt], 8,2)."-".substr($row[daterecipt], 5,2)."-".substr($row[daterecipt], 0,4).
	"&nbsp;&nbsp;&nbsp;</td><td >&nbsp;&nbsp;".$row[code].
	"&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;".$row[attribute].
	"&nbsp;&nbsp;&nbsp;</td><td style='text-align:center;'> ".$row[lifetime]." ปี</td>".
 	"<td style='text-align:center;'> ".$row[depreciation]."</td>";
	//echo "<td style='text-align:center;'> ".($row[lifetime]*12)." ด. </td> ";
	 if($row[priceofsets]!=0 && $row[priceofsets]!=""){
	 	 $cal=($row[numberofsets]*$row[priceofsets]);
	 	 $last_dy=($row[numberofsets]*$row[priceofsets])-1;
	 	}else{
	 	 $cal=0;
	 	 $last_dy=0;
	 	}

	//echo "<td>".$y_start."==>".$y_end."</td>";
	echo "<td style='text-align:right;'>".recheck_bath($cal)."&nbsp;&nbsp;</td>";
	echo "<td style='text-align:right;background-color:#ffdbdb;'>".recheck_bath($last_dy)."</td>";


	//ค่าเสื่อมปัจจุบัน

	echo "<td style='text-align:right;'>&nbsp;</td>";
	echo "<td style='text-align:right;'>&nbsp;</td>";
	echo "<td style='text-align:right;'>&nbsp;</td>";
	echo "<td style='text-align:right;'>&nbsp;</td>";
	echo "<td style='text-align:right;'>&nbsp;</td>";
	echo "<td style='text-align:right;'>&nbsp;</td>";
	echo "<td style='text-align:right;'>&nbsp;</td>";
	echo "<td style='text-align:right;'>&nbsp;</td>";
	echo "<td style='text-align:right;'>&nbsp;</td>";
	echo "<td style='text-align:right;'>&nbsp;</td>";
	echo "<td style='text-align:right;'>&nbsp;</td>";
	echo "<td style='text-align:right;'>&nbsp;</td>";
//recheck_bath($cal*$m)
	echo "<td style='text-align:right;'>".recheck_bath($last_dy)."</td>";
	echo "<td style='text-align:right;'>".recheck_bath(($row[numberofsets]*$row[priceofsets])-$last_dy)."</td>";

array_push($total_1,($row[numberofsets]*$row[priceofsets]));
array_push($total_2,$last_dy);
array_push($total[10],"0");
array_push($total[11],"0");
array_push($total[12],"0");
array_push($total[1],"0");
array_push($total[2],"0");
array_push($total[3],"0");
array_push($total[4],"0");
array_push($total[5],"0");
array_push($total[6],"0");
array_push($total[7],"0");
array_push($total[8],"0");
array_push($total[9],"0");
array_push($total_3,"0");
array_push($total_4,$last_dy);

}

$strSQL = "UPDATE store SET ";
$strSQL .="year_depreciate = '".($now_year+543)."' ";
$strSQL .=",last_depreciate  = '".$last_dy."' ";
$strSQL .=",jan  = '".$mon[1]."' ";
$strSQL .=",feb  = '".$mon[2]."' ";
$strSQL .=",mar  = '".$mon[3]."' ";
$strSQL .=",api  = '".$mon[4]."' ";
$strSQL .=",may  = '".$mon[5]."' ";
$strSQL .=",jun  = '".$mon[6]."' ";
$strSQL .=",jul  = '".$mon[7]."' ";
$strSQL .=",aug  = '".$mon[8]."' ";
$strSQL .=",sep  = '".$mon[9]."' ";
$strSQL .=",oct  = '".$mon[10]."' ";
$strSQL .=",nov  = '".$mon[11]."' ";
$strSQL .=",dece  = '".$mon[12]."' ";
$strSQL .=",sum_depreciate  = '".(array_sum($mon)+$last_dy)."' ";
$strSQL .=",lastupdate ='".date("Y-m-d H:s:i")."'";
$strSQL .=",officer = '".$_SESSION["xusername"]."'";
$strSQL .="WHERE row_id = '".$row[row_id]."' ";
$objQuery = mysqli_query($con,$strSQL)or die(mysqli_error());  


}
echo "<tr><td colspan='5'></td>".
		"<td style='text-align:right;'>".recheck_bath(array_sum($total_1))."</td>".
		"<td style='text-align:right;'>".recheck_bath(array_sum($total_2))."</td>".
		"<td style='text-align:right;'>".recheck_bath(array_sum($total[10]))."</td>".
		"<td style='text-align:right;'>".recheck_bath(array_sum($total[11]))."</td>".
		"<td style='text-align:right;'>".recheck_bath(array_sum($total[12]))."</td>".
		"<td style='text-align:right;'>".recheck_bath(array_sum($total[1]))."</td>".
		"<td style='text-align:right;'>".recheck_bath(array_sum($total[2]))."</td>".
		"<td style='text-align:right;'>".recheck_bath(array_sum($total[3]))."</td>".
		"<td style='text-align:right;'>".recheck_bath(array_sum($total[4]))."</td>".
		"<td style='text-align:right;'>".recheck_bath(array_sum($total[5]))."</td>".
		"<td style='text-align:right;'>".recheck_bath(array_sum($total[6]))."</td>".
		"<td style='text-align:right;'>".recheck_bath(array_sum($total[7]))."</td>".
		"<td style='text-align:right;'>".recheck_bath(array_sum($total[8]))."</td>".
		"<td style='text-align:right;'>".recheck_bath(array_sum($total[9]))."</td>".
		"<td style='text-align:right;'>".recheck_bath(array_sum($total_3))."</td>".
		"<td style='text-align:right;'>".recheck_bath(array_sum($total_4))."</td>";
echo "</tbody>";
echo "</table>";
echo "<div class='page_breck'></div>";
}
}
?>
<script type="text/javascript">
	 $(".display_loader").fadeOut();
</script>