<?php
session_start();
include("connect.inc");

// if(isset($_GET["dateday"]) && isset($_GET["today"])){
// $_SESSION["d_day"] =  substr($_GET["dateday"],6,4)."-".substr($_GET["dateday"],3,2)."-".substr($_GET["dateday"],0,2);
// $_SESSION["d_to"] = substr($_GET["today"],6,4)."-".substr($_GET["today"],3,2)."-".substr($_GET["today"],0,2);
// $_SESSION["d_barcode"] = $_GET["barcode"];
// header('Location: report_product.php');
// }
function recheck_num($str){
    if($str!="" && $str!="0"){
        $nuc=number_format($str,2);
    }else{
        $nuc="-";
    }
    return $nuc;
}

$sql = "SELECT tbl_value from tbl_company where row_id = '1'  limit 1  ";
list($company) = Mysql_fetch_row(Mysql_Query($sql));


function grouptype($str){
$sql = "SELECT group_type.detail from stock_product INNER Join group_type on stock_product.group_type = group_type.code where barcode = '$str'  limit 1  ";
list($grouptype) = Mysql_fetch_row(Mysql_Query($sql));
return $grouptype;
}

function detailproduct($str){
$sql = "SELECT detail from stock_product where barcode = '$str'  limit 1  ";
list($detail) = Mysql_fetch_row(Mysql_Query($sql));
return $detail;
}
function persanal_name($str){
$sql = "SELECT name from personal where code = '$str'  limit 1  ";
list($name) = Mysql_fetch_row(Mysql_Query($sql));
return $name;
}





function thai_month($mm) {
switch($mm) {
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
    td{
        font-size: 10px;
        padding:2px 0px;
    }
	</style>
</head>
<body>
    <?
    $rowx=explode(",",$_GET["data"]);
    
    ?>
<table style="width:100%;">
<thead>
<tr>
<td style="text-align: center;border:1px solid #a2a2a2;" rowspan="2">รหัสแผนก</td>
<td style="text-align: center;border:1px solid #a2a2a2;" rowspan="2">รายงานวัสดุใช้ไป<br><?=thai_month($_GET["month"])?> <?=$_GET["year"]?></td>
<?
for($t=1;$t<count($rowx);$t++){
print "<td style='text-align: center;border:1px solid #a2a2a2;' ></td>";
}
?>

<td style="text-align: center;border:1px solid #a2a2a2;" rowspan="2">รวม</td>

<tr>
    <?
//    $rowx=explode(",",$_GET["data"]);
    for($t=1;$t<count($rowx);$t++){
  $sql = "SELECT detail from group_type where row_id = '".$rowx[$t]."' ";
  list($detail_group) = Mysql_fetch_row(Mysql_Query($sql));
  echo "<td style='border:1px solid #a2a2a2;text-align:center;'>$detail_group</td>";

}
print "</thead><tbody>";
$sum_x=array("");
$sum_y=array("");
$sql = "SELECT * from department where group_location = '1' ORDER By code  ASC";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {
$i++;

 echo "<tr>".
      "<td style='border:1px solid #a2a2a2;text-align:center;'>$row[code]</td>".
      "<td style='border:1px solid #a2a2a2;'>&nbsp;$row[name]</td>";

  for($t=1;$t<count($rowx);$t++){
 $sql = "SELECT detail from group_type where row_id = '".$rowx[$t]."' ";
  list($detail_group) = Mysql_fetch_row(Mysql_Query($sql));
$search = "";
$p=0;
$sql_s = "SELECT code from group_type where detail = '".$detail_group."' ";
$result_sx = mysql_query($sql_s);
while ($rc = mysql_fetch_array($result_sx) ) {
    $p++;
    if($p==1){
    $search.="group_type = '".$rc[code]."' ";
    }else{
    $search.="OR group_type = '".$rc[code]."' ";
}
}
  $sql = "SELECT row_id from hire_type where detail = '".$detail_group."' ";
  list($hire_type) = Mysql_fetch_row(Mysql_Query($sql));

// $strSQL = "SELECT sum(total_money) from tbl_import2_head where type_hire='$hire_type' AND department = '$row[code]' AND dateday like '".$_GET["year"]."-".$_GET["month"]."%'  ";
// list($total_outstore) = Mysql_fetch_row(Mysql_Query($strSQL));

$strSQL2="SELECT SUM(price*pcs) FROM bill  WHERE status = 'OWH' AND customer_id = '$row[code]' AND dateday like '".$_GET["year"]."-".$_GET["month"]."%' AND (".$search.")  ";
list($sum_OWH) = Mysql_fetch_row(Mysql_Query($strSQL2));



echo "<td style='text-align: right;border:1px solid #a2a2a2;'><a href='report_department.php?dateday=01-".$_GET["month"]."-".$_GET["year"]."&today=31-".$_GET["month"]."-".$_GET["year"]."&department=".$row["code"]."&group_type=".$rowx[$t]."' target='_blank'>".recheck_num($sum_OWH)."</a>&nbsp;&nbsp;</td>";
$sum_x[$i]=$sum_x[$i]+$sum_OWH;
$sum_y[$t]=$sum_y[$t]+$sum_OWH;
}
echo "<td style='text-align: right;border:1px solid #a2a2a2;'>".recheck_num($sum_x[$i])."&nbsp;&nbsp;</td>";

}

echo "<tr><td style='text-align: right;border:1px solid #a2a2a2;'>&nbsp;&nbsp;</td>";
echo "<td style='text-align: right;border:1px solid #a2a2a2;'>&nbsp;&nbsp;</td>";

      for ($a=1; $a < count($sum_y); $a++) { 
          echo "<td style='text-align: right;border:1px solid #a2a2a2;'>".recheck_num($sum_y[$a])."&nbsp;&nbsp;</td>";
      }
echo "<td style='text-align: right;border:1px solid #a2a2a2;'>".recheck_num(array_sum($sum_x))."&nbsp;&nbsp;</td>";
    ?>

</table>
<br>
<table style="width:100%;">
<td  style="text-align: center;">
    <br><br>
    ผู้จัดทำ................................................<br>
    (................................................)<br>
    พนักงานพัสดุ

</td>

    </tbody>
</table>
</body>
</html>