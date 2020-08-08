<?
session_start();
include("connect.inc");
function recheck_num($str){
	if($str!=""){
		return number_format($str,2);
	}else{
		return "0.00";
	}
}

$month=$_GET["month"];
if($_GET["year"]){
$year=$_GET["year"];
$year2=substr($_GET["year"], 2,2);
}else{
$year=date("Y");
$year2=date("y");
}

$sql = "SELECT tbl_value from tbl_company where row_id = '1'  limit 1  ";
list($company) = Mysql_fetch_row(Mysql_Query($sql));
function mount_full($str){
switch($str)
{
case "01": $str = "มกราคม"; break;
case "02": $str = "กุมภาพันธ์"; break;
case "03": $str = "มีนาคม"; break;
case "04": $str = "เมษายน"; break;
case "05": $str = "พฤษภาคม"; break;
case "06": $str = "มิถุนายน"; break;
case "07": $str = "กรกฏาคม"; break;
case "08": $str = "สิงหาคม"; break;
case "09": $str = "กันยายน"; break;
case "10": $str = "ตุลาคม"; break;
case "11": $str = "พฤศจิกายน"; break;
case "12": $str = "ธันวาคม"; break;
}
return $str;
}

function mount($str){
switch($str)
{
case "01": $str = "ม.ค."; break;
case "02": $str = "ก.พ."; break;
case "03": $str = "มี.ค."; break;
case "04": $str = "เม.ย."; break;
case "05": $str = "พ.ค."; break;
case "06": $str = "มิ.ย."; break;
case "07": $str = "ก.ค."; break;
case "08": $str = "ส.ค."; break;
case "09": $str = "ก.ย."; break;
case "10": $str = "ต.ค."; break;
case "11": $str = "พ.ย."; break;
case "12": $str = "ธ.ค."; break;
}
return $str;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		td{
			border:1px solid #a2a2a2;

		}
		table{
			border-collapse: collapse;
		}
	</style>
</head>
<body>
<table style="width:295mm;">
	<td colspan="6" style="text-align: center;border:0px solid #a2a2a2;font-size: 21px;">ค่าเสื่อมราคาครุภัณฑ์และสิ่งก่อสร้างประจำ เดือน <?=mount_full($month)." ".$year?> 	</td>
	<tr>
	<td style="text-align: center;background-color: #c2c2c2;">รายการ</td>	
	<td style="text-align: center;background-color: #c2c2c2;">ยกมา <?if($month<12 && $month>=9){echo mount($month-1)." ".$year2;}else if($month==1){echo mount(12)." ".($year2-1);}else{echo mount($month-1)." ".($year2);}?> </td>	
	<td style="text-align: center;background-color: #c2c2c2;"><?=mount($month)." ".$year2?> </td>	
	<td style="text-align: center;background-color: #c2c2c2;">รวม</td>	
	<td style="text-align: center;background-color: #c2c2c2;">ค่าเสื่อมราคาครุภัณฑ์</td>	
	<td style="text-align: center;background-color: #c2c2c2;">ค่าเสื่อมสะสมครุภัณฑ์</td>				
	 <?
$sql = "SELECT * from store_type  ORDER By code  ASC";
$result = mysql_query($sql);
$sum_last=array();
$sum_month=array();
while ($row = mysql_fetch_array($result) ) {
	print "<tr>".
		  "<td>&nbsp;&nbsp;$row[detail]</td>";

  
  $sql = "SELECT SUM(last_depreciate),SUM(oct),SUM(nov),SUM(dece),SUM(jan),SUM(feb),SUM(mar),SUM(api),SUM(may),SUM(Jun),SUM(Jul),SUM(aug),SUM(sep) from store WHERE store_type = '$row[code]' AND status = 1 GROUP By store_type  ";
  list($sum_dep,$sum[10],$sum[11],$sum[12],$sum[1],$sum[2],$sum[3],$sum[4],$sum[5],$sum[6],$sum[7],$sum[8],$sum[9]) = Mysql_fetch_row(Mysql_Query($sql));
//echo $sum_dep."<br>";
$sum_now=$sum_dep;

if($month<=12 && $month>=10){

for($i=10;$i<=$month;$i++){
$sum_now=$sum_now+$sum[$i];
}

}else if($month<=9 && $month>=1){

for($i=10;$i<=12;$i++){
$sum_now=$sum_now+$sum[$i];
}
for($i=1;$i<=$month;$i++){
$sum_now=$sum_now+$sum[$i];
}

}

  echo "<td style='text-align:right;'>".recheck_num($sum_now)."&nbsp;&nbsp;</td>";
  echo "<td style='text-align:right;'>".recheck_num($sum[$month])."&nbsp;&nbsp;</td>";
  echo "<td style='text-align:right;'>".recheck_num($sum[$month]+$sum_now)."&nbsp;&nbsp;</td>";
  echo "<td style='text-align:right;'></td>";
  echo "<td style='text-align:right;'></td>";

  array_push($sum_last, $sum_now);
  array_push($sum_month, $sum[$month]);
}
  echo "<tr><td style='border:0px solid #a2a2a2;'></td>".
  		    "<td style='text-align:right;'>".recheck_num(array_sum($sum_last))."&nbsp;&nbsp;</td>".
  		    "<td style='text-align:right;'>".recheck_num(array_sum($sum_month))."&nbsp;&nbsp;</td>".
  		    "<td style='text-align:right;'>".recheck_num(array_sum($sum_last)+array_sum($sum_month))."&nbsp;&nbsp;</td>";

	  	?>		
	  <tr><td style="height: 50px;border:0px solid #a2a2a2;"></td>
	  <tr><td style="text-align: center;border:0px solid #a2a2a2;">(..............................................)</td>
	  	  <td colspan="3" style="text-align: center;border:0px solid #a2a2a2;">(..............................................)</td>
	  	  <td colspan="2" style="text-align: center;border:0px solid #a2a2a2;">(..............................................)</td>
	  <tr><td style="text-align: center;border:0px solid #a2a2a2;">เจ้าพนักงานการเงินและบัญชี</td>
	  	  <td colspan="3" style="text-align: center;border:0px solid #a2a2a2;">เจ้าพนักงานธุรการชำนาญงาน</td>
	  	  <td colspan="2" style="text-align: center;border:0px solid #a2a2a2;">นายแพทย์ชำนาญพิเศษ(ด้านเวชกรรม)<br>ผู้อำนวยการ<?=$company?></td>

</table>
</body>
</html>
<script type="text/javascript">
	window.print();
</script>