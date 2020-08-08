<?
session_start();
include("connect.inc");
if($_SESSION["xusername"]==""){
  echo("<script>alert('กรุณาทำการล็อกอินก่อนใช้งาน');window.location='login.php'</script>");
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
	<title> รายงานพัสดุคงเหลือ</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script src="../js/jquery-1.8.0.min.js"></script>
	<style type="text/css">
		body{
			/*background-color: 	#f7f7f7;*/
		}
		table{
			border-collapse: collapse;
		}
		    .topbar{
      background-color: #a0a0a0;
      text-align: center;
      padding:5px 0px;
    }
    .border_bt{
      border: 1px solid #a0a0a0;
    }
    .button_menu{
      /*float: left;*/
      padding:5px 10px;
      border:1px solid #e0e0e0;
      cursor: pointer;
    }
     .button_menu:hover{
      background-color: #e0e0e0;
     }
          .detail_show{
      width:100%;
      border:1px solid #555555;
      overflow-x: hidden;
      overflow-y: auto;
     }
     .cursor_p{
     	cursor:pointer;
     }
     .cursor_p:hover{
     	background-color:#8b9dc3; 
     }
	</style>
</head>
<body>
  <img id="img_print" src="../images/menu/Printer.png" style="position:fixed;width:50px;right:10px;top:5px;cursor: pointer;" onclick="print_review('detail')">
  <div id="detail">
<table style="width:21cm;margin:0px auto;">
  <thead>
  	<tr><td colspan="6" style="text-align: center;font-size: 22px;font-weight: bold;">..::รายงานพัสดุคงเหลือ:..</td><td colspan="2"  style="text-align: right;">ณ วันที่ <?=date("d")." ".thai_month(date("m"))." ".(date("Y")+543)?></td>
    <!-- <td class="topbar" style="border:1px solid #909090;">อัพเดทล่าสุด</td> -->
    <?
  print "<tr><td class='topbar' style='width:60px;border:1px solid #909090;'>ลำดับ</td>"
        ."<td class='topbar' style='width:80px;border:1px solid #909090;'>รหัส</td>"
        ."<td class='topbar' style='border:1px solid #909090;'>รายการ</td>"
        ."<td class='topbar' style='width:100px;border:1px solid #909090;'>กลุ่มสินค้า</td>"
        ."<td class='topbar' style='border:1px solid #909090;'>ราคา</td>"
        ."<td class='topbar' style='border:1px solid #909090;'>จำนวน</td>"
        ."<td class='topbar' style='border:1px solid #909090;'>หน่วยนับ</td>"
        ."<td class='topbar' style='border:1px solid #909090;'>รวมจำนวนเงิน</td><tr>";
    ?>
  </thead>
  <tbody>
    <?

$sqla = "SELECT * FROM group_type WHERE code !='C0' GROUP by c_group ORDER By c_group ASC ";
$resulta = mysql_query($sqla);
$total_money=array();
while($d = mysql_fetch_array($resulta)){


$head_title=$d[c_group];
$sqlb = "SELECT * FROM group_type WHERE  code !='C0' AND c_group = '$d[c_group]'";
$resultb = mysql_query($sqlb);
$total_g=array("");
while($b = mysql_fetch_array($resultb)){

$sql = "SELECT * FROM stock_product WHERE group_type = '$b[code]' AND pcs > '0' ORDER By barcode ASC";
$result = mysql_query($sql);
$numb = mysql_num_rows($result);

if($numb){


while($data = mysql_fetch_array($result)){
$i++;
          // if($data["group_name"]==""){
          $sql = "SELECT detail from group_type where code = '$data[group_type]'  limit 1  ";
          list($group_name) = Mysql_fetch_row(Mysql_Query($sql));  

          // $sql_update = "UPDATE stock_product SET group_name='$group_name' WHERE row_id='$data[row_id]' ";
          // $result_update= mysql_query($sql_update) or die(mysql_error());

          // }else{
          //   $group_name=$data["group_name"];
          // }



                  print "<tr ><td style='text-align:center;' class='border_bt'>$i</td>";
                  print "<td style='text-align:center;' class='border_bt'>$data[barcode]</td>";
                  print "<td class='border_bt'>&nbsp;&nbsp;$data[detail]</td>";
                  print "<td style='text-align:center;' class='border_bt'>$group_name</td>";
                  print "<td style='text-align:right;' class='border_bt'>$data[price_in]&nbsp;</td>";
                  print "<td style='text-align:center;' class='border_bt'>$data[pcs]</td>";
                  print "<td style='text-align:center;' class='border_bt'>$data[unit]</td>";
                  print "<td style='text-align:right;' class='border_bt'>".number_format(($data[price_in]*$data[pcs]),2)." ฿&nbsp;</td>";
                  //print "<td style='text-align:center;' class='border_bt'>$data[lastupdate]</td>";
                  print"</tr>";
                  array_push($total_money, ($data[price_in]*$data[pcs]));
                  $total_gb["$d[c_group]"]=$total_gb["$d[c_group]"]+($data[price_in]*$data[pcs]);
}

}
}
if($numb){
print "<tr><td colspan='6' style='background-color:#a0a0a0;text-align:right;'>รวมจำนวนเงิน</td>";
print "<td colspan='2' style='text-align:right;color:blue;'>".number_format($total_gb["$d[c_group]"],2)." ฿&nbsp</td></tr>";
}
}


$sql = "SELECT sum(pcs) from stock_product WHERE pcs > '0'  ";
list($pcsls) = Mysql_fetch_row(Mysql_Query($sql));

print "<td colspan='6' style='text-align:right;'>จำนวนพัสดุ ".number_format($pcsls)." ชิ้น &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รวมจำนวนเงิน</td>";
print "<td colspan='2' style='text-align:right;'>".number_format(array_sum($total_money),2)." ฿&nbsp</td>";
    ?>
  </tbody>
</table>
</div>
</body>
</html>
<script type="text/javascript">
    function print_review(el){
    $("#img_print").hide();
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
    $("#img_print").show();
}
</script>
