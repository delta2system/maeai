<?
session_start();
include("connect.inc");

$sql_c= "SELECT * from tbl_company ";
$result_c = mysql_query($sql_c);
while ($tbl = mysql_fetch_array($result_c) ) {
 if($tbl["tbl_title"]=="company_name"){
 	$company=$tbl["tbl_value"];
 }
 if($tbl["tbl_title"]=="address"){
 	$address=$tbl["tbl_value"];
 }


}

//$company="โรงพยาบาลแม่อาย";
//$address="191 ม.8 ต.มะลิกา อ.แม่อาย จ.เชียงใหม่";

if($_GET["date1"]){
$date_start=$_GET["date1"];
$date_end=$_GET["date2"];
}
// else{
// $date_start=(date("Y")+543)."-".date("m")."-01";
// $date_end=(date("Y")+543)."-".date("m")."-31";
// }



function comma($str){

if($str!=""){
	return number_format($str,2);
}else{
	return "";
}

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>สต็อกการ์ด</title>
	<style type="text/css">
		.headbar{
			text-align: center;
			border:1px solid #909090;
		}
		table{
			border-collapse: collapse;
		}
		th{
			font-family: tahoma;
		}
		  @media print {
    .page_breck {page-break-after: always;}
     pre, blockquote {page-break-inside: avoid;}
}
	</style>
</head>
<body>
<?

?>
<!-- <div class="page_breck" style="width:215mm;height:150mm;border:0px solid #909090;margin:0px auto;padding: 20px 10px;"> -->
<table class="page_breck" style="width:215mm;height:150mm;border:0px solid #909090;margin:0px auto;padding: 20px 10px;">
	<thead>
		<td colspan="9" style="text-align: center;">สต็อกการ์ดพัสดุ <?=$company?> <?=$address?> <div style="position: absolute;margin-top: -18px;margin-left:720px;">แผ่นที่..<?=$end_line?>..</div></td>
		<tr><td class="headbar" style="height:30px;">ว.ด.ป</td>
			<td class="headbar">รับจาก / จ่ายให้</td>
			<td class="headbar">เลขที่ใบสำคัญ</td>
			<td class="headbar">รับ</td>
			<td class="headbar">จ่าย</td>
			<td class="headbar">คงเหลือ</td>
			<td class="headbar" style="font-size: 14px;">ราคาต่อหน่วย</td>
			<td class="headbar" style="font-size: 14px;">ราคารวม vat</td>
			<td class="headbar">หมายเหตุ</td>
	</thead>
	<tbody>
		<?	
		//$l=1;
		for($li=0;$li<12;$li++){
			echo "<tr><td style='border:1px solid #909090;height:30px;'></td>".
				 "<td style='border:1px solid #909090;'></td>".
				 "<td style='border:1px solid #909090;'></td>".
				 "<td style='border:1px solid #909090;'></td>".
				 "<td style='border:1px solid #909090;'></td>".
				 "<td style='border:1px solid #909090;'></td>".
				 "<td style='border:1px solid #909090;'></td>".
				 "<td style='border:1px solid #909090;'></td>".
				 "<td style='border:1px solid #909090;'></td></tr>";
		}
		?>
	</tbody>
	<tfoot>
		<td style="height: 10px;"></td>
		<tr><td colspan="9" style="height: 40px;">รหัสพัสดุ <span style="font-weight: bold;border-bottom: 1px dotted #909090;padding:0px 20px;width:300px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> พัสดุ <span style="font-weight: bold;border-bottom: 1px dotted #909090;padding:0px 20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>ขนาด/ลักษณะ <span style="font-weight: bold;border-bottom: 1px dotted #909090;padding:0px 20px;width:300px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><td>		
	</tfoot>
</table>

</body>
</html>