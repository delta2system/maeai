<?php
session_start();
include("connect.inc");

if(isset($_GET["dateday"]) && isset($_GET["today"])){
$_SESSION["d_day"] =  substr($_GET["dateday"],6,4)."-".substr($_GET["dateday"],3,2)."-".substr($_GET["dateday"],0,2);
$_SESSION["d_to"] = substr($_GET["today"],6,4)."-".substr($_GET["today"],3,2)."-".substr($_GET["today"],0,2);
$_SESSION["d_department"] = $_GET["department"];
if($_GET["group_type"]){

  $sql = "SELECT code from group_type WHERE row_id = '".$_GET["group_type"]."'";
  list($code) = Mysql_fetch_row(Mysql_Query($sql));

	$_SESSION["d_group_type"] = $code;
}
header('Location: report_department.php');
}


function grouptype($str){
$sql = "SELECT group_type.detail from stock_product INNER Join group_type on stock_product.group_type = group_type.code where barcode = '$str'  limit 1  ";
list($grouptype) = Mysql_fetch_row(Mysql_Query($sql));
return $grouptype;
}

function thai_month($mm) {
switch($mm) {
case '01' : $month = "ม.ค."; break;
case '02' : $month = "ก.พ.";break;
case '03' : $month = "มี.ค.";break;
case '04' : $month = "เม.ย.";break;
case '05' : $month = "พ.ค";break;
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
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="dashboard/bower_components/font-awesome/css/font-awesome.min.css">
	<style type="text/css">
		  @media print {
    .page_breck {page-break-after: always;}
	}
	.topbar{
		text-align: center;
		background-color:#b3e6ff ;
		border:1px solid #909090;
	}
	table{
		border-collapse: collapse;
	}
	</style>
</head>
<body>

<?
if($_SESSION["d_department"]){
	$r = "customer_id = '".$_SESSION["d_department"]."' AND status = 'OWH' AND dateday between '".$_SESSION["d_day"]."' AND '".$_SESSION["d_to"]."' ";
	if($_SESSION["d_group_type"]){
	$r .= "AND group_type='".$_SESSION["d_group_type"]."' ";
	}
	$r .= "GROUP By customer_id";
	//$q = "customer_id = '".$g[customer_id]."' AND status = 'OWH' AND dateday between '".$_SESSION["d_day"]."' AND '".$_SESSION["d_to"]."' ";
}else{
	$r = "status = 'OWH' AND dateday between '".$_SESSION["d_day"]."' AND '".$_SESSION["d_to"]."' GROUP By customer_id ORDER By customer_id ASC ";
	//$q = "customer_id = '".$g[customer_id]."' AND status = 'OWH' AND dateday between '".$_SESSION["d_day"]."' AND '".$_SESSION["d_to"]."' ORDER By dateday ASC";
}
$d1=explode("-", $_SESSION["d_day"]);
$d2=explode("-", $_SESSION["d_to"]);
$dday=$d1[2]." ".thai_month($d1[1])." ".$d1[0];
$dto=$d2[2]." ".thai_month($d2[1])." ".$d2[0];
    $str_group = "SELECT customer_id,customer_name from bill where $r ";
    $result_group = mysql_query($str_group) or die(mysql_error());
    while( $g = mysql_fetch_array($result_group)){

    print "<div class='page_breck'>";
    print "<table style='width:100%;'>";
	print "<thead>";
	print "<tr><td colspan='4' style='height:50px;font-size:20px;font-weight:bold;color:#3366ff;'>สรุปยอดเบิกจ่าย/แผนก <span style='color:#606060;'>$g[customer_id] : $g[customer_name]</span></td>";
	// print "<tr><td colspan='4' style='font-weight:bold;height:50px;'>รหัสแผนก $g[customer_id] : $g[customer_name]</td>";
	 print "<td colspan='3' style='text-align:right;color:#3366ff;'>ระหว่างวันที่ ".$dday." ถึงวันที่ ".$dto." </td></tr>";
	print "<td class='topbar'>รหัสสินค้า</td>";
	print "<td class='topbar'>วันที่</td>";
	print "<td class='topbar'>ประเภทวัสดุ</td>";
	print "<td class='topbar'>สินค้า</td>";
	print "<td class='topbar'>จำนวน</td>";
	print "<td class='topbar'>ราคาทุน</td>";
	print "<td class='topbar'>ราคารวม</td>";
	print "</tr></thead><tbody>";


    $strSQL = "SELECT * from bill where customer_id = '".$g[customer_id]."' ";
    if($_SESSION["d_group_type"]){
	$strSQL .= "AND group_type='".$_SESSION["d_group_type"]."' ";
	}
	$strSQL .= "AND status = 'OWH' AND dateday between '".$_SESSION["d_day"]."' AND '".$_SESSION["d_to"]."' ";
	if($_SESSION["d_group_type"]){
	$strSQL .="ORDER By dateday ASC";
	}else{
	$strSQL .="ORDER By barcode ASC , dateday ASC";
	}
    $resultSQL = mysql_query($strSQL) or die(mysql_error());
    $pcs_department=array();
    $total_department=array();
    while( $data = mysql_fetch_array($resultSQL)){
     	
     	$dr=explode("-", $data[dateday]);

    	print "<tr style='border-bottom:1px solid #d2d2d2;'>";
    	print "<td style='text-align:center;font-size:13px;padding:5px 0px;'>$data[barcode]</td>";
    	print "<td style='text-align:center;font-size:13px;padding:5px 0px;padding:5px 0px;'>".$dr[2]." ".thai_month($dr[1])." ".$dr[0]."</td>";
    	print "<td style='text-align:center;font-size:13px;padding:5px 0px;'>".grouptype($data[barcode])."</td>";
    	print "<td style='font-size:13px;padding:5px 0px;'>&nbsp;&nbsp;$data[detail]</td>";
    	print "<td style='font-size:13px;padding:5px 0px;text-align:center;'>$data[pcs]</td>";
    	print "<td style='font-size:13px;padding:5px 0px;padding:5px 0px;text-align:right;'>$data[price] ฿ &nbsp;</td>";
    	print "<td style='font-size:13px;padding:5px 0px;text-align:right;'>".number_format(($data[pcs]*$data[price]),2)." ฿ &nbsp;</td>";
    	print "</tr>";
    	array_push($pcs_department,$data[pcs]);
    	array_push($total_department,($data[pcs]*$data[price]));

    }
    //print "</tbody>";
    //print "<tfoot style='border-top:1px solid #909090;'>";
    print "<td colspan='3' style='height:30px;border-top:1px solid #909090;'></td><td style='border-top:1px solid #909090;text-align:right;font-weight:bold;font-size:12px;'>จำนวนที่ใช้ไป</td><td style='border-top:1px solid #909090;text-align:center;border-bottom-style:double;font-weight:bold;'>".number_format(array_sum($pcs_department))."</td>";
    print "<td style='text-align:right;font-weight:bold;border-top:1px solid #909090;font-size:12px;'>เป็นจำนวนเงิน</td><td style='text-align:right;border-bottom-style:double;font-weight:bold;border-top:1px solid #909090;'>".number_format(array_sum($total_department),2)." ฿ </td>";
    print "</tbody></table></div>";
}

?>
</table>
</body>
</html>