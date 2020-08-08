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
    if($str!="" && $str!=0){
        $nuc=number_format($str,2);
    }else{
        $nuc="";
    }
    return $nuc;
}

$sql = "SELECT tbl_value from tbl_company where row_id = '1'  limit 1  ";
list($company) = Mysql_fetch_row(Mysql_Query($sql));

// $resultsr = mysql_query("SELECT * FROM bill_of_year where dateday = '".$_GET['year']."-".$_GET["month"]."-01'");
// $numr = mysql_num_rows($resultsr);
// if($numr>0){
//   header('Location: report_productsum_re.php');
// }



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
  <script src="../js/jquery-1.8.0.min.js"></script>
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
        padding:5px 0px;
    }
    .btn{
      font-size: 18px;
      cursor: pointer;
    }
    input[type='text']{
      background-color:transparent
    }
    .cal_sum{
      font-size:14px;
      width:98%;
      text-align:right;
      border:0px;
    }
	</style>
</head>
<body>
<form role="form"   name="a1" id="a1" method="post" enctype="multipart/form-data"  action="" >
<table style="width:100%;">
<td colspan="12" style="text-align: center;">สรุปรายงานวัสดุ ประจำเดือน <?=thai_month($_GET["month"])?> <?=$_GET["year"]?>  <?=$company?>
<input type="hidden" name="month" value="<?=$_GET["month"]?>">
<input type="hidden" name="year" value="<?=$_GET["year"]?>">
<input type="hidden" name="data" value="<?=$_GET["data"]?>">
 </td>
<tr>
<td style="text-align: center;border:1px solid #a2a2a2;width:200px;" rowspan="2">ประเภทวัสดุ</td>
<td style="text-align: center;border:1px solid #a2a2a2;" rowspan="2">คงเหลือ</td>
<td style="text-align: center;border:1px solid #a2a2a2;" rowspan="2">รับนอกคลัง</td>
<td style="text-align: center;border:1px solid #a2a2a2;" rowspan="2">รับในคลัง</td>
<td style="text-align: center;border:1px solid #a2a2a2;" rowspan="2">รวมรับเข้าคลัง</td>
<td style="text-align: center;border:1px solid #a2a2a2;" colspan="2">จ่ายนอกคลัง</td>
<td style="text-align: center;border:1px solid #a2a2a2;" colspan="2">จ่ายในคลัง</td>
<td style="text-align: center;border:1px solid #a2a2a2;" rowspan="2">รวมจ่ายออกคลัง</td>
<td style="text-align: center;border:1px solid #a2a2a2;" colspan="2">คงเหลือ</td>
<tr><td style="text-align: center;border:1px solid #a2a2a2;" >แม่ข่าย (รพ.)</td>
<td style="text-align: center;border:1px solid #a2a2a2;" >ลูกข่าย </td>
<td style="text-align: center;border:1px solid #a2a2a2;" >แม่ข่าย (รพ.)</td>
<td style="text-align: center;border:1px solid #a2a2a2;" >ลูกข่าย </td>
<td style="text-align: center;border:1px solid #a2a2a2;" >นอกคลัง</td>
<td style="text-align: center;border:1px solid #a2a2a2;" >ในคลัง </td>
<tr>
    <?
    $rowx=explode(",",$_GET["data"]);
    $sum_total=array();

    for($t=1;$t<count($rowx);$t++){
  $sql = "SELECT detail from group_type where row_id = '".$rowx[$t]."' ";
  list($detail_group) = Mysql_fetch_row(Mysql_Query($sql));
  echo "<tr><td style='border:1px solid #a2a2a2;'>&nbsp;&nbsp;$detail_group</td>";

// $search = "";
// $search2 = "";
// $p=0;
// $code_group="";
// $sql_s = "SELECT code from group_type where detail = '".$detail_group."' ";
// $result_sx = mysql_query($sql_s);
// while ($rc = mysql_fetch_array($result_sx) ) {
// //     $p++;
// //     if($p==1){
// //     $search.="group_type = '".$rc[code]."' ";
// //     $search2.="bill.group_type = '".$rc[code]."' ";
// //     }else{
// //     $search.="OR group_type = '".$rc[code]."' ";
// //     $search2.="OR bill.group_type = '".$rc[code]."' ";
// // }
// $code_group=$rc[code];
// }
  $sql = "SELECT code from group_type where detail = '".$detail_group."' ORDER By row_id DESC ";
  list($code_group) = Mysql_fetch_row(Mysql_Query($sql));

// echo $code_group;
  // $sql = "SELECT row_id from hire_type where detail = '".$detail_group."' ";
  // list($hire_type) = Mysql_fetch_row(Mysql_Query($sql));




//echo $search;
  echo "<td style='border:1px solid #a2a2a2;'><input type='text' name='col_1_".$code_group."' value='".recheck_num(0)."' style='font-size:14px;width:98%;text-align:right;border:0px;'></td>";
  //array_push($sum_a, var)

$sql_t = "SELECT * from bill_of_year where group_type = '".$code_group."' AND dateday = '".$_GET["year"]."-".$_GET["month"]."-01' ORDER By row_id ASC ";
$result_st = mysql_query($sql_t);
$o=1;
while ($arr = mysql_fetch_array($result_st) ) {
$o++;
echo "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' name='".$arr["title"]."' value='".recheck_num($arr["money"])."' style='font-size:14px;width:98%;text-align:right;border:0px;'></td>";
$sum_total[$o]=$sum_total[$o]+$arr["money"];
}



// //รับนอกคลัง
// $strSQL = "SELECT sum(total_money) from tbl_import2_head where type_hire='$hire_type' AND  dateday like '".$_GET["year"]."-".$_GET["month"]."%'  ";
// list($total_outstore) = Mysql_fetch_row(Mysql_Query($strSQL));
// echo "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' name='col_2_".$code_group."' value='".recheck_num($total_outstore)."' style='font-size:14px;width:98%;text-align:right;border:0px;'></td>";
// array_push($sum_b, $total_outstore);



// $strSQL1 = "SELECT sum(pcs*price) from bill where status = 'INV' AND dateday like '".$_GET["year"]."-".$_GET["month"]."%' AND (".$search.")  ";
// list($sum_INV) = Mysql_fetch_row(Mysql_Query($strSQL1));
// echo "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' name='col_3_".$code_group."' value='".recheck_num($sum_INV)."' style='font-size:14px;width:98%;text-align:right;border:0px;'></td>";
// array_push($sum_c, $sum_INV);

// //รวมรับเข้า
// echo "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' name='col_4_".$code_group."' value='".recheck_num($total_outstore+$sum_INV)."' style='font-size:14px;width:98%;text-align:right;border:0px;'></td>";
// array_push($sum_d, ($total_outstore+$sum_INV));
// //จ่ายคลังนอก รพ

// //$strSQL = "SELECT sum(total_money) from tbl_import2_head where type_hire='$hire_type' AND  dateday like '".$_GET["year"]."-".$_GET["month"]."%'  ";
// $strSQL4="SELECT SUM(tbl_import2_head.total_money) FROM tbl_import2_head INNER JOIN department ON tbl_import2_head.department=department.code WHERE tbl_import2_head.type_hire='$hire_type' AND  tbl_import2_head.dateday like '".$_GET["year"]."-".$_GET["month"]."%'  AND department.group_location = '1'  ";
// list($sum_out1) = Mysql_fetch_row(Mysql_Query($strSQL4));
// echo "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' name='col_5_".$code_group."' value='".recheck_num($sum_out1)."' style='font-size:14px;width:98%;text-align:right;border:0px;'></td>";
// array_push($sum_e, $sum_out1);
// //จ่ายคลังนอก ข่าย
// $strSQL5="SELECT SUM(tbl_import2_head.total_money) FROM tbl_import2_head INNER JOIN department ON tbl_import2_head.department=department.code WHERE tbl_import2_head.type_hire='$hire_type' AND  tbl_import2_head.dateday like '".$_GET["year"]."-".$_GET["month"]."%'  AND department.group_location = '2'  ";
// list($sum_out2) = Mysql_fetch_row(Mysql_Query($strSQL5));
// echo "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' name='col_6_".$code_group."' value='".recheck_num($sum_out2)."' style='font-size:14px;width:98%;text-align:right;border:0px;'></td>";
// array_push($sum_f, $sum_out2);
// //$strSQL2 = "SELECT sum(pcs*price) from bill where status = 'OWH' AND dateday like '".$_GET["year"]."-".$_GET["month"]."%' AND (".$search.")  ";
// $strSQL2="SELECT SUM(bill.price*bill.pcs) FROM bill INNER JOIN department ON bill.customer_id=department.code WHERE bill.status = 'OWH' AND bill.dateday like '".$_GET["year"]."-".$_GET["month"]."%' AND department.group_location = '1' AND (".$search2.")  ";
// list($sum_OWH) = Mysql_fetch_row(Mysql_Query($strSQL2));
// echo "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' name='col_7_".$code_group."' value='".recheck_num($sum_OWH)."' style='font-size:14px;width:98%;text-align:right;border:0px;'></td>";
// array_push($sum_g, $sum_OWH);

// $strSQL2="SELECT SUM(bill.price*bill.pcs) FROM bill INNER JOIN department ON bill.customer_id=department.code WHERE bill.status = 'OWH' AND bill.dateday like '".$_GET["year"]."-".$_GET["month"]."%' AND department.group_location = '2' AND (".$search2.")  ";
// list($sum_OWH2) = Mysql_fetch_row(Mysql_Query($strSQL2));
// echo "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' name='col_8_".$code_group."' value='".recheck_num($sum_OWH2)."' style='font-size:14px;width:98%;text-align:right;border:0px;'></td>";
// array_push($sum_h, $sum_OWH2);
// //รวมจ่ายออกคลัง
// $total_store=$sum_out1+$sum_out2+$sum_OWH+$sum_OWH2;
// echo "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' name='col_9_".$code_group."' value='".recheck_num($total_store)."' style='font-size:14px;width:98%;text-align:right;border:0px;'></td>";
// array_push($sum_i, $total_store);
// //คงเหลือนอกคลัง
// echo "<td style='text-align: center;border:1px solid #a2a2a2;'><input type='text' name='col_10_".$code_group."' value='-' style='font-size:14px;width:98%;text-align:right;border:0px;'></td>";
// //คงเหลือในคลัง
// $strSQL = "SELECT sum(pcs*price_in) from stock_product where ".$search."  ";
// list($total_stock) = Mysql_fetch_row(Mysql_Query($strSQL));
// echo "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' name='col_11_".$code_group."' value='".recheck_num($total_stock)."' style='font-size:14px;width:98%;text-align:right;border:0px;'></td>";
// array_push($sum_j, $total_stock);

}
print "<tr><td style='text-align: center;border:1px solid #a2a2a2;'></td>".
      "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' value='".recheck_num($sum_total[1])."' class='cal_sum'></td>".
      "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' value='".recheck_num($sum_total[2])."' class='cal_sum'></td>".
      "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' value='".recheck_num($sum_total[3])."' class='cal_sum'></td>".
      "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' value='".recheck_num($sum_total[4])."' class='cal_sum'></td>".
      "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' value='".recheck_num($sum_total[5])."' class='cal_sum'></td>".
      "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' value='".recheck_num($sum_total[6])."' class='cal_sum'></td>".
      "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' value='".recheck_num($sum_total[7])."' class='cal_sum'></td>".
      "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' value='".recheck_num($sum_total[8])."' class='cal_sum'></td>".
      "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' value='".recheck_num($sum_total[9])."' class='cal_sum'></td>".
      "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' value='".recheck_num($sum_total[10])."' class='cal_sum'></td>".
      "<td style='text-align: right;border:1px solid #a2a2a2;'><input type='text' value='".recheck_num($sum_total[11])."' class='cal_sum'></td>";


?>

<tr><td></td><td colspan="5" style="text-align: center;">
    ผู้จัดทำ<br><br>
    ................................................<br>
    (................................................)<br>
    พนักงานพัสดุ

</td>
    <td colspan="4" style="text-align: center;">
            ผู้ตรวจสอบ<br><br>
    ................................................<br>
    (................................................)<br>
    เจ้าพนักงานธุรการชำนาญงาน

    </td><td></td>
</table>
</form>
<div>
  <button class='btn' onclick="save_stock_m()">แก้ไขข้อมูล</button>
  <!-- <button class='btn' >Excel Export</button> -->
  <button class='btn' onclick="$('.btn').hide();window.print();">Print</button>
</div>
</body>
</html>
<script type="text/javascript">
  function save_stock_m(){

    $("#a1").submit();


  }
</script>

<?
if($_POST){
$rowx=explode(",",$_POST["data"]);
  $sql_del = "DELETE FROM bill_of_year WHERE dateday = '".$_POST["year"]."-".$_POST["month"]."-01' "; 
  $query = mysql_query($sql_del);
    for($t=1;$t<count($rowx);$t++){
  $sql = "SELECT detail from group_type where row_id = '".$rowx[$t]."' ";
  list($detail_group) = Mysql_fetch_row(Mysql_Query($sql));

$sql_s = "SELECT code from group_type where detail = '".$detail_group."' order by row_id DESC limit 1";
$result_sx = mysql_query($sql_s);
list($code) = Mysql_fetch_row($result_sx);




//echo $detail_group.$code;
for($u=2;$u<=12;$u++){
//INSERT SQL
$names="col_".$u."_".$code;

$strSQL = "INSERT INTO bill_of_year SET "; 
$strSQL .="dateday = '".$_POST["year"]."-".$_POST["month"]."-01' ";
$strSQL .=",group_type = '".$code."' ";
$strSQL .=",title = 'col_".$u."_".$code."' ";
$strSQL .=",money = '".str_replace(",","",$_POST["$names"])."' ";
//echo $strSQL;
$objQuery = mysql_query($strSQL)or die(mysql_error());
}


}

  echo("<script>alert('บันทึกเรียบร้อยแล้ว');$('.btn').hide();window.print();</script>");

}
?>