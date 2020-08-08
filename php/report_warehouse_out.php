<?php
session_start();
include("connect.inc");

if(isset($_GET["year"]) || isset($_GET["m"]) || $_GET["trimas"]){
$_SESSION["vYear"] =  $_GET["year"];
$_SESSION["vMonth"] = $_GET["month"];
$_SESSION["vTrimas"] = $_GET["trimas"];
header('Location: report_warehouse_out.php');
}
//print_r($_SESSION);
// function grouptype($str){
// $sql = "SELECT group_type.detail from stock_product INNER Join group_type on stock_product.group_type = group_type.code where barcode = '$str'  limit 1  ";
// list($grouptype) = Mysql_fetch_row(Mysql_Query($sql));
// return $grouptype;
// }

function material($str){
$sql = "SELECT detail from material_type where row_id = '$str'  limit 1  ";
list($detail) = Mysql_fetch_row(Mysql_Query($sql));
return $detail;	
}

function recheck_vl($str){
	if($str!=0 || $str!=""){
		$str = number_format($str,2);
	}else{
		$str = "";
	}
	return $str;
}

function thai_month($mm) {
switch($mm) {
case '01' : $month = "ม.ค."; break;
case '02' : $month = "ก.พ.";break;
case '03' : $month = "มี.ค.";break;
case '04' : $month = "เม.ย.";break;
case '05' : $month = "พ.ค.";break;
case '06' : $month = "มิ.ย.";break;
case '07' : $month = "ก.ค.";break;
case '08' : $month = "ส.ค.";break;
case '09' : $month = "ก.ย.";break;
case '10' : $month = "ต.ค.";break;
case '11' : $month = "พ.ย.";break;
case '12' : $month = "ธ.ค.";break;
}
return $month;
}

function thai_month_full($mm) {
switch($mm) {
case '01' : $month = "มกราคม"; break;
case '02' : $month = "กุมภาพันธ์";break;
case '03' : $month = "มีนาคม";break;
case '04' : $month = "เมษายน";break;
case '05' : $month = "พฤษภาคม";break;
case '06' : $month = "มิถุนายน";break;
case '07' : $month = "กรกฏาคม";break;
case '08' : $month = "สิงหาคม";break;
case '09' : $month = "กันยายน";break;
case '10' : $month = "ตุลาคม";break;
case '11' : $month = "พฤศจิกายน";break;
case '12' : $month = "ธันวาคม";break;
}
return $month;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="dashboard/bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../fonts/thsarabunnew.css">
	<style type="text/css">
		  @media print {
    .page_breck {page-break-after: always;}
	}
	.topbar{
		text-align: center;
		background-color:#b3e6ff ;
		border:1px solid #909090;
		height:50px;
		font-weight: bold;
		font-size: 15px;
	}
	td{
		font-family: 'THSarabunNew', sans-serif;
	}
	table{
		border-collapse: collapse;
	}
	</style>
</head>
<body>

<?
// if($_SESSION["d_department"]){
// 	$r = "customer_id = '".$_SESSION["d_department"]."' AND status = 'OWH' AND dateday between '".$_SESSION["d_day"]."' AND '".$_SESSION["d_to"]."' GROUP By customer_id";
// 	//$q = "customer_id = '".$g[customer_id]."' AND status = 'OWH' AND dateday between '".$_SESSION["d_day"]."' AND '".$_SESSION["d_to"]."' ";
// }else{
// 	$r = "status = 'OWH' AND dateday between '".$_SESSION["d_day"]."' AND '".$_SESSION["d_to"]."' GROUP By customer_id ORDER By customer_id ASC ";
// 	//$q = "customer_id = '".$g[customer_id]."' AND status = 'OWH' AND dateday between '".$_SESSION["d_day"]."' AND '".$_SESSION["d_to"]."' ORDER By dateday ASC";
// }
// $d1=explode("-", $_SESSION["d_day"]);
// $d2=explode("-", $_SESSION["d_to"]);
// $dday=$d1[2]." ".thai_month($d1[1])." ".$d1[0];
// $dto=$d2[2]." ".thai_month($d2[1])." ".$d2[0];
//     $str_group = "SELECT customer_id,customer_name from bill where $r ";
//     $result_group = mysql_query($str_group) or die(mysql_error());
//     while( $g = mysql_fetch_array($result_group)){

    //print "<div class='page_breck'>";
if($_SESSION["vYear"]!="" && $_SESSION["vTrimas"]=="" && $_SESSION["vMonth"]==""){
    print "<table style='width:100%;'>";
	print "<thead>";
	print "<tr><td colspan='14' style='height:50px;font-size:20px;font-weight:bold;color:#3366ff;'>รายงานซื้อวัสดุนอกคลัง ปีงบประมาณ ".$_SESSION["vYear"]." </td>";
	// print "<tr><td colspan='4' style='font-weight:bold;height:50px;'>รหัสแผนก $g[customer_id] : $g[customer_name]</td>";
	 //print "<td colspan='3' style='text-align:right;color:#3366ff;'></td></tr>";
	print "<tr>";
	print "<td class='topbar'>หมวด</td>";
	print "<td class='topbar'>ประเภท</td>";
	print "<td class='topbar'>ต.ค.-".(substr($_SESSION["vYear"],2,2)-1)."</td>";
	print "<td class='topbar'>พ.ย.-".(substr($_SESSION["vYear"],2,2)-1)."</td>";
	print "<td class='topbar'>ธ.ค.-".(substr($_SESSION["vYear"],2,2)-1)."</td>";
	print "<td class='topbar'>ม.ค.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "<td class='topbar'>ก.พ.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "<td class='topbar'>มี.ค.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "<td class='topbar'>เม.ย.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "<td class='topbar'>พ.ค.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "<td class='topbar'>มิ.ย.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "<td class='topbar'>ก.ค.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "<td class='topbar'>ส.ค.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "<td class='topbar'>ก.ย.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "</tr></thead><tbody>";

	//$strSQL="SELECT opcard.hn, opcard.ampur, opcard.tambol FROM hire_type INNER JOIN materail_type ON opcard.hn=opday.hn WHERE thidate like '2017-06%'";
	$sumtotal[10]=array("");
	$sumtotal[11]=array("");
	$sumtotal[12]=array("");
	$sumtotal[1]=array("");
	$sumtotal[2]=array("");
	$sumtotal[3]=array("");
	$sumtotal[4]=array("");
	$sumtotal[5]=array("");
	$sumtotal[6]=array("");
	$sumtotal[7]=array("");
	$sumtotal[8]=array("");
	$sumtotal[9]=array("");

    $strSQL = "SELECT * from hire_type  ORDER By detail ASC ";
    $resultSQL = mysql_query($strSQL) or die(mysql_error());
    while( $data = mysql_fetch_array($resultSQL)){
     	print "<tr>";
     	print "<td style='text-align:left;font-size:13px;padding:5px 0px;border:1px solid #a2a2a2;'>&nbsp;&nbsp;$data[detail]</td>";
     	print "<td style='text-align:left;font-size:13px;padding:5px 0px;padding:5px 0px;border:1px solid #a2a2a2;'>&nbsp;&nbsp;".material($data[material_type])."</td>";


     	  $sql10 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data[row_id]' AND dateday like '".($_SESSION["vYear"]-1)."-10%'   ";
  		  list($sumtotal10) = Mysql_fetch_row(Mysql_Query($sql10));
  		  print "<td style='text-align:right;border:1px solid #a2a2a2;font-size:13px;'>";if($sumtotal10){echo number_format($sumtotal10,2);array_push($sumtotal[10], $sumtotal10);}print "&nbsp;</td>";

  		  $sql11 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data[row_id]' AND dateday like '".($_SESSION["vYear"]-1)."-11%'   ";
  		  list($sumtotal11) = Mysql_fetch_row(Mysql_Query($sql11));
  		  print "<td style='text-align:right;border:1px solid #a2a2a2;font-size:13px;'>";if($sumtotal11){echo number_format($sumtotal11,2);array_push($sumtotal[11], $sumtotal11);}print "&nbsp;</td>";

  		  $sql12 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data[row_id]' AND dateday like '".($_SESSION["vYear"]-1)."-12%'   ";
  		  list($sumtotal12) = Mysql_fetch_row(Mysql_Query($sql12));
  		  print "<td style='text-align:right;border:1px solid #a2a2a2;font-size:13px;'>";if($sumtotal12){echo number_format($sumtotal12,2);array_push($sumtotal[12], $sumtotal12);}print "&nbsp;</td>";

  		  $sql1 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data[row_id]' AND dateday like '".$_SESSION["vYear"]."-01%'   ";
  		  list($sumtotal1) = Mysql_fetch_row(Mysql_Query($sql1));
  		  print "<td style='text-align:right;border:1px solid #a2a2a2;font-size:13px;'>";if($sumtotal1){echo number_format($sumtotal1,2);array_push($sumtotal[1], $sumtotal1);}print "&nbsp;</td>";
     
  		  $sql2 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data[row_id]' AND dateday like '".$_SESSION["vYear"]."-02%'   ";
  		  list($sumtotal2) = Mysql_fetch_row(Mysql_Query($sql2));
  		  print "<td style='text-align:right;border:1px solid #a2a2a2;font-size:13px;'>";if($sumtotal2){echo number_format($sumtotal2,2);array_push($sumtotal[2], $sumtotal2);}print "&nbsp;</td>";

 		  $sql3 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data[row_id]' AND dateday like '".$_SESSION["vYear"]."-03%'   ";
  		  list($sumtotal3) = Mysql_fetch_row(Mysql_Query($sql3));
  		  print "<td style='text-align:right;border:1px solid #a2a2a2;font-size:13px;'>";if($sumtotal3){echo number_format($sumtotal3,2);array_push($sumtotal[3], $sumtotal3);}print "&nbsp;</td>";

 		  $sql4 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data[row_id]' AND dateday like '".$_SESSION["vYear"]."-04%'   ";
  		  list($sumtotal4) = Mysql_fetch_row(Mysql_Query($sql4));
  		  print "<td style='text-align:right;border:1px solid #a2a2a2;font-size:13px;'>";if($sumtotal4){echo number_format($sumtotal4,2);array_push($sumtotal[4], $sumtotal4);}print "&nbsp;</td>";

 		  $sql5 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data[row_id]' AND dateday like '".$_SESSION["vYear"]."-05%'   ";
  		  list($sumtotal5) = Mysql_fetch_row(Mysql_Query($sql5));
  		  print "<td style='text-align:right;border:1px solid #a2a2a2;font-size:13px;'>";if($sumtotal5){echo number_format($sumtotal5,2);array_push($sumtotal[5], $sumtotal5);}print "&nbsp;</td>";
 
 		  $sql6 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data[row_id]' AND dateday like '".$_SESSION["vYear"]."-06%'   ";
  		  list($sumtotal6) = Mysql_fetch_row(Mysql_Query($sql6));
  		  print "<td style='text-align:right;border:1px solid #a2a2a2;font-size:13px;'>";if($sumtotal6){echo number_format($sumtotal6,2);array_push($sumtotal[6], $sumtotal6);}print "&nbsp;</td>";

 		  $sql7 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data[row_id]' AND dateday like '".$_SESSION["vYear"]."-07%'   ";
  		  list($sumtotal7) = Mysql_fetch_row(Mysql_Query($sql7));
  		  print "<td style='text-align:right;border:1px solid #a2a2a2;font-size:13px;'>";if($sumtotal7){echo number_format($sumtotal7,2);array_push($sumtotal[7], $sumtotal7);}print "&nbsp;</td>";
  
 		  $sql8 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data[row_id]' AND dateday like '".$_SESSION["vYear"]."-08%'   ";
  		  list($sumtotal8) = Mysql_fetch_row(Mysql_Query($sql8));
  		  print "<td style='text-align:right;border:1px solid #a2a2a2;font-size:13px;'>";if($sumtotal8){echo number_format($sumtotal8,2);array_push($sumtotal[8], $sumtotal8);}print "&nbsp;</td>";

 		  $sql9 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data[row_id]' AND dateday like '".$_SESSION["vYear"]."-09%'   ";
  		  list($sumtotal9) = Mysql_fetch_row(Mysql_Query($sql9));
  		  print "<td style='text-align:right;border:1px solid #a2a2a2;font-size:13px;'>";if($sumtotal9){echo number_format($sumtotal9,2);array_push($sumtotal[9], $sumtotal9);}print "&nbsp;</td>";

     }

     	$sum = array_sum($sumtotal[10])+array_sum($sumtotal[11])+array_sum($sumtotal[12])+array_sum($sumtotal[1])+array_sum($sumtotal[2])+array_sum($sumtotal[3])+array_sum($sumtotal[4])+array_sum($sumtotal[5])+array_sum($sumtotal[6])+array_sum($sumtotal[7])+array_sum($sumtotal[8])+array_sum($sumtotal[9]);
     	print "<tr><td colspan='2' style='text-align:right;'>รวมทั้งหมด <span style='color:red;font-weight:bold;'>".recheck_vl($sum)."</span> &nbsp;&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sumtotal[10]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sumtotal[11]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sumtotal[12]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sumtotal[1]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sumtotal[2]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sumtotal[3]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sumtotal[4]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sumtotal[5]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sumtotal[6]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sumtotal[7]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sumtotal[8]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sumtotal[9]))."&nbsp;</td></tr>";
		print "</tbody>";
//     //print "<tfoot style='border-top:1px solid #909090;'>";
//     print "<td colspan='3' style='height:30px;border-top:1px solid #909090;'></td><td style='border-top:1px solid #909090;text-align:right;font-weight:bold;font-size:12px;'>จำนวนที่ใช้ไป</td><td style='border-top:1px solid #909090;text-align:center;border-bottom-style:double;font-weight:bold;'>".number_format(array_sum($pcs_department))."</td>";
//     print "<td style='text-align:right;font-weight:bold;border-top:1px solid #909090;font-size:12px;'>เป็นจำนวนเงิน</td><td style='text-align:right;border-bottom-style:double;font-weight:bold;border-top:1px solid #909090;'>".number_format(array_sum($total_department),2)." ฿ </td>";
//     print "</tbody></table></div>";
// }

?>
</table>
<div class="page_breck"></div>
<?
  print "<table style='width:100%;'>";
	print "<thead>";
	print "<tr>";
	print "<td class='topbar'>ประเภท</td>";
	print "<td class='topbar'>รวม</td>";
	print "<td class='topbar'>ต.ค.-".(substr($_SESSION["vYear"],2,2)-1)."</td>";
	print "<td class='topbar'>พ.ย.-".(substr($_SESSION["vYear"],2,2)-1)."</td>";
	print "<td class='topbar'>ธ.ค.-".(substr($_SESSION["vYear"],2,2)-1)."</td>";
	print "<td class='topbar'>ม.ค.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "<td class='topbar'>ก.พ.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "<td class='topbar'>มี.ค.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "<td class='topbar'>เม.ย.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "<td class='topbar'>พ.ค.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "<td class='topbar'>มิ.ย.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "<td class='topbar'>ก.ค.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "<td class='topbar'>ส.ค.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "<td class='topbar'>ก.ย.-".substr($_SESSION["vYear"],2,2)."</td>";
	print "</tr></thead><tbody>";

	//$strSQL="SELECT opcard.hn, opcard.ampur, opcard.tambol FROM hire_type INNER JOIN materail_type ON opcard.hn=opday.hn WHERE thidate like '2017-06%'";
    $strSQL = "SELECT * from material_type  ORDER By row_id ASC ";
    $resultSQL = mysql_query($strSQL) or die(mysql_error());
    $sum_sx=array("");
    while( $data = mysql_fetch_array($resultSQL)){
     	$o++;
//      	$dr=explode("-", $data[dateday]);
     	print "<tr>";
     	print "<td style='text-align:left;font-size:13px;padding:5px 0px;border:1px solid #a2a2a2;'>&nbsp;&nbsp;$data[detail]</td>";

    $strSQL2 = "SELECT * from hire_type  WHERE material_type = '$data[row_id]' ";
    $resultSQL2 = mysql_query($strSQL2) or die(mysql_error());
    $sx1[$o]=array("");
    $sx2[$o]=array("");
    $sx3[$o]=array("");
    $sx4[$o]=array("");
    $sx5[$o]=array("");
    $sx6[$o]=array("");
    $sx7[$o]=array("");
    $sx8[$o]=array("");
    $sx9[$o]=array("");
    $sx10[$o]=array("");
    $sx11[$o]=array("");
    $sx12[$o]=array("");
    while( $data2 = mysql_fetch_array($resultSQL2)){

 		  $sqls10 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data2[row_id]' AND dateday like '".($_SESSION["vYear"]-1)."-10%'   ";
  		  list($sumtotals10) = Mysql_fetch_row(Mysql_Query($sqls10));
  		  array_push($sx10[$o], $sumtotals10);

 		  $sqls11 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data2[row_id]' AND dateday like '".($_SESSION["vYear"]-1)."-11%'   ";
  		  list($sumtotals11) = Mysql_fetch_row(Mysql_Query($sqls11));
  		  array_push($sx11[$o], $sumtotals11);

  		  $sqls12 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data2[row_id]' AND dateday like '".($_SESSION["vYear"]-1)."-12%'   ";
  		  list($sumtotals12) = Mysql_fetch_row(Mysql_Query($sqls12));
  		  array_push($sx12[$o], $sumtotals12);

  		  $sqls1 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data2[row_id]' AND dateday like '".$_SESSION["vYear"]."-01%'   ";
  		  list($sumtotals1) = Mysql_fetch_row(Mysql_Query($sqls1));
  		  array_push($sx1[$o], $sumtotals1);

  		  $sqls2 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data2[row_id]' AND dateday like '".$_SESSION["vYear"]."-02%'   ";
  		  list($sumtotals2) = Mysql_fetch_row(Mysql_Query($sqls2));
  		  array_push($sx2[$o], $sumtotals2);

  		  $sqls3 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data2[row_id]' AND dateday like '".$_SESSION["vYear"]."-03%'   ";
  		  list($sumtotals3) = Mysql_fetch_row(Mysql_Query($sqls2));
  		  array_push($sx3[$o], $sumtotals3);

  		  $sqls4 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data2[row_id]' AND dateday like '".$_SESSION["vYear"]."-04%'   ";
  		  list($sumtotals4) = Mysql_fetch_row(Mysql_Query($sqls4));
  		  array_push($sx4[$o], $sumtotals4);

  		  $sqls5 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data2[row_id]' AND dateday like '".$_SESSION["vYear"]."-05%'   ";
  		  list($sumtotals5) = Mysql_fetch_row(Mysql_Query($sqls5));
  		  array_push($sx5[$o], $sumtotals5);

  		  $sqls6 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data2[row_id]' AND dateday like '".$_SESSION["vYear"]."-06%'   ";
  		  list($sumtotals6) = Mysql_fetch_row(Mysql_Query($sqls6));
  		  array_push($sx6[$o], $sumtotals6);

  		  $sqls7 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data2[row_id]' AND dateday like '".$_SESSION["vYear"]."-07%'   ";
  		  list($sumtotals7) = Mysql_fetch_row(Mysql_Query($sqls7));
  		  array_push($sx7[$o], $sumtotals7);

  		  $sqls8 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data2[row_id]' AND dateday like '".$_SESSION["vYear"]."-08%'   ";
  		  list($sumtotals8) = Mysql_fetch_row(Mysql_Query($sqls8));
  		  array_push($sx8[$o], $sumtotals8);

  		  $sqls9 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data2[row_id]' AND dateday like '".$_SESSION["vYear"]."-09%'   ";
  		  list($sumtotals9) = Mysql_fetch_row(Mysql_Query($sqls9));
  		  array_push($sx9[$o], $sumtotals9);
    }


    $sum_sx[$o] = array_sum($sx1[$o])+array_sum($sx2[$o])+array_sum($sx3[$o])+array_sum($sx4[$o])+array_sum($sx5[$o])+array_sum($sx6[$o])+array_sum($sx7[$o])+array_sum($sx8[$o])+array_sum($sx9[$o])+array_sum($sx10[$o])+array_sum($sx11[$o])+array_sum($sx12[$o]);
    //echo $sum_sx."<br>";

         	print "<td  style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl($sum_sx[$o])."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sx10[$o]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sx11[$o]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sx12[$o]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sx1[$o]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sx2[$o]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sx3[$o]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sx4[$o]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sx5[$o]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sx6[$o]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sx7[$o]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sx8[$o]))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sx9[$o]))."&nbsp;</td></tr>";

     		  $sxs10=$sxs10+array_sum($sx10[$o]);
     		  $sxs11=$sxs11+array_sum($sx11[$o]);
     		  $sxs12=$sxs12+array_sum($sx12[$o]);
     		  $sxs1=$sxs1+array_sum($sx1[$o]);
     		  $sxs2=$sxs2+array_sum($sx2[$o]);
     		  $sxs3=$sxs3+array_sum($sx3[$o]);
     		  $sxs4=$sxs4+array_sum($sx4[$o]);
     		  $sxs5=$sxs5+array_sum($sx5[$o]);
     		  $sxs6=$sxs6+array_sum($sx6[$o]);
     		  $sxs7=$sxs7+array_sum($sx7[$o]);
     		  $sxs8=$sxs8+array_sum($sx8[$o]);
     		  $sxs9=$sxs9+array_sum($sx9[$o]);


//print_r($sx);
     }
            print "<tr><td></td><td  style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl(array_sum($sum_sx))."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl($sxs10)."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl($sxs11)."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl($sxs12)."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl($sxs1)."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl($sxs2)."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl($sxs3)."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl($sxs4)."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl($sxs5)."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl($sxs6)."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl($sxs7)."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl($sxs8)."&nbsp;</td>".
     		  "<td style='border:1px solid #a2a2a2;text-align:rihgt;font-size:13px;font-weight:bold;'>".recheck_vl($sxs9)."&nbsp;</td></tr>";

print "</table>";





}else if($_SESSION["vYear"]!="" && $_SESSION["vTrimas"]!="" && $_SESSION["vMonth"]==""){
    print "<table style='width:100%;'>";
	print "<thead>";
	print "<tr><td colspan='14' style='height:50px;font-size:20px;font-weight:bold;color:#3366ff;'>รายงานซื้อวัสดุนอกคลัง ปีงบประมาณ ".$_SESSION["vYear"]." </td>";
	// print "<tr><td colspan='4' style='font-weight:bold;height:50px;'>รหัสแผนก $g[customer_id] : $g[customer_name]</td>";
	 //print "<td colspan='3' style='text-align:right;color:#3366ff;'></td></tr>";
	print "<tr>";
	print "<td class='topbar' rowspan='3'>หมวด</td>";
	print "<td class='topbar' rowspan='3'>ประเภท</td>";
	print "<td class='topbar' colspan='2' style='text-align:center;'>ไตรมาสที่ 1</td>";
	print "<td class='topbar' colspan='2' style='text-align:center;'>ไตรมาสที่ 2</td>";
	print "<td class='topbar' colspan='2' style='text-align:center;'>ไตรมาสที่ 3</td>";
	print "<td class='topbar' colspan='2' style='text-align:center;'>ไตรมาสที่ 4</td>";
	print "<tr><td class='topbar' style='font-size:9px;'>ตามแผน</td>";
	print "<td class='topbar' style='font-size:9px;'>นอกแผน</td>";
	print "<td class='topbar' style='font-size:9px;'>ตามแผน</td>";
	print "<td class='topbar' style='font-size:9px;'>นอกแผน</td>";
	print "<td class='topbar' style='font-size:9px;'>ตามแผน</td>";
	print "<td class='topbar' style='font-size:9px;'>นอกแผน</td>";
	print "<td class='topbar' style='font-size:9px;'>ตามแผน</td>";
	print "<td class='topbar' style='font-size:9px;'>นอกแผน</td>";

	print "</tr></thead><tbody>";

	//$strSQL="SELECT opcard.hn, opcard.ampur, opcard.tambol FROM hire_type INNER JOIN materail_type ON opcard.hn=opday.hn WHERE thidate like '2017-06%'";
    $strSQL = "SELECT * from hire_type  ORDER By detail ASC ";
    $resultSQL = mysql_query($strSQL) or die(mysql_error());
    while( $data = mysql_fetch_array($resultSQL)){
     	
//      	$dr=explode("-", $data[dateday]);

     	print "<tr>";
     	print "<td style='text-align:left;font-size:13px;padding:5px 0px;border:1px solid #a2a2a2;'>&nbsp;&nbsp;$data[detail]</td>";

     	print "<td style='text-align:left;font-size:13px;padding:5px 0px;padding:5px 0px;border:1px solid #a2a2a2;'>&nbsp;&nbsp;".material($data[material_type])."</td>";
//     	print "<td style='text-align:center;font-size:13px;padding:5px 0px;'>".grouptype($data[barcode])."</td>";
//     	print "<td style='font-size:13px;padding:5px 0px;'>&nbsp;&nbsp;$data[detail]</td>";
//     	print "<td style='font-size:13px;padding:5px 0px;text-align:center;'>$data[pcs]</td>";
//     	print "<td style='font-size:13px;padding:5px 0px;padding:5px 0px;text-align:right;'>$data[price] ฿ &nbsp;</td>";
//     	print "<td style='font-size:13px;padding:5px 0px;text-align:right;'>".number_format(($data[pcs]*$data[price]),2)." ฿ &nbsp;</td>";
//     	print "</tr>";
//     	array_push($pcs_department,$data[pcs]);
//     	array_push($total_department,($data[pcs]*$data[price]));

     }



  print "<table style='width:100%;'>";
	print "<thead>";
	print "<tr>";
	print "<td class='topbar' rowspan='3'>ประเภท</td>";
	print "<td class='topbar'  rowspan='3'>รวม</td>";
	print "<td class='topbar' colspan='2' style='text-align:center;'>ไตรมาสที่ 1</td>";
	print "<td class='topbar' colspan='2' style='text-align:center;'>ไตรมาสที่ 2</td>";
	print "<td class='topbar' colspan='2' style='text-align:center;'>ไตรมาสที่ 3</td>";
	print "<td class='topbar' colspan='2' style='text-align:center;'>ไตรมาสที่ 4</td>";
	print "<tr><td class='topbar' style='font-size:9px;'>ตามแผน</td>";
	print "<td class='topbar' style='font-size:9px;'>นอกแผน</td>";
	print "<td class='topbar' style='font-size:9px;'>ตามแผน</td>";
	print "<td class='topbar' style='font-size:9px;'>นอกแผน</td>";
	print "<td class='topbar' style='font-size:9px;'>ตามแผน</td>";
	print "<td class='topbar' style='font-size:9px;'>นอกแผน</td>";
	print "<td class='topbar' style='font-size:9px;'>ตามแผน</td>";
	print "<td class='topbar' style='font-size:9px;'>นอกแผน</td>";
	print "</tr></thead><tbody>";

	//$strSQL="SELECT opcard.hn, opcard.ampur, opcard.tambol FROM hire_type INNER JOIN materail_type ON opcard.hn=opday.hn WHERE thidate like '2017-06%'";
    $strSQL = "SELECT * from material_type  ORDER By detail ASC ";
    $resultSQL = mysql_query($strSQL) or die(mysql_error());
    while( $data = mysql_fetch_array($resultSQL)){
     	
//      	$dr=explode("-", $data[dateday]);
     	print "<tr>";
     	print "<td style='text-align:left;font-size:13px;padding:5px 0px;border:1px solid #a2a2a2;'>&nbsp;&nbsp;$data[detail]</td>";
     }


}else if($_SESSION["vYear"]!="" && $_SESSION["vTrimas"]=="" && $_SESSION["vMonth"]!=""){


  print "<table style='width:100%;'>";
	print "<thead>";
	print "<tr>";
	print "<td class='topbar' colspan='4' style='text-align:center;'>รายงานวัสดุนอกคลัง ปีงบประมาณ ".$_SESSION["vYear"]."</td>";
	print "<tr><td class='topbar' colspan='4' style='text-align:center;'>ประจำเดือน ".thai_month_full($_SESSION["vMonth"])."</td>";
	print "<tr><td class='topbar'>หมวด</td>".
		  "<td class='topbar'>ยอดซื้อ</td>".
		  "<td class='topbar'>โอนให้ รพ.สต, สสช.</td>".
		  "<td class='topbar'>ยอดคงเหลือ</td>";
	print "</tr></thead><tbody>";

	if($_SESSION["vMonth"]==10 || $_SESSION["vMonth"]==11 || $_SESSION["vMonth"]==12 ){
		$mx=($_SESSION["vYear"]-1)."-".$_SESSION["vMonth"];
	}else{
		$mx=$_SESSION["vYear"]."-".$_SESSION["vMonth"];
	}

    $strSQL = "SELECT * from hire_type WHERE detail like '%วัสดุ%' ORDER By detail ASC ";
    $resultSQL = mysql_query($strSQL) or die(mysql_error());
    $sumtotal=array("");
    while( $data = mysql_fetch_array($resultSQL)){
     	
//      	$dr=explode("-", $data[dateday]);

     	print "<tr>";
     	print "<td style='text-align:left;font-size:13px;padding:5px 0px;border:1px solid #a2a2a2;'>&nbsp;&nbsp;$data[detail]</td>";

     	  $sql10 = "SELECT SUM(total_money) from tbl_import2_head WHERE type_hire = '$data[row_id]' AND dateday like '$mx%'   ";
  		  list($sumtotal10) = Mysql_fetch_row(Mysql_Query($sql10));
  		  print "<td style='text-align:right;border:1px solid #a2a2a2;font-size:13px;'>".recheck_vl($sumtotal10)."&nbsp;</td>";
  		  array_push($sumtotal, $sumtotal10);
  		  print "<td style='text-align:right;border:1px solid #a2a2a2;font-size:13px;'></td>";
  		  print "<td style='text-align:right;border:1px solid #a2a2a2;font-size:13px;'>".recheck_vl($sumtotal10)."&nbsp;</td>";

     }
     print "<tr><td style='text-align:center;border:1px solid #a2a2a2;'>รวม</td>".
     		"<td style='text-align:center;border:1px solid #a2a2a2;'>".recheck_vl(array_sum($sumtotal))."</td>".
     		"<td style='text-align:center;border:1px solid #a2a2a2;'></td>".
     		"<td style='text-align:center;border:1px solid #a2a2a2;'>".recheck_vl(array_sum($sumtotal))."</td>";

}



?>





</body>
</html>