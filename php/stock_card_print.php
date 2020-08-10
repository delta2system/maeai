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
			border:1px solid #e2e2e2;
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
$arrcol=array();
if($_GET["group_type"]!=""){

$sql = "SELECT barcode,detail from bill where group_type = '".$_GET["group_type"]."' AND dateday between '$date_start' AND '$date_end' GROUP By barcode order By barcode ASC";
$result = mysql_query($sql);

while ($data = mysql_fetch_assoc($result)){
array_push($arrcol, $data);
}

}else if(empty($_GET["barcode"])){
$sql = "SELECT barcode,detail from bill where dateday between '$date_start' AND '$date_end' GROUP By barcode order By barcode ASC";
$result = mysql_query($sql);

while ($data = mysql_fetch_assoc($result)){
array_push($arrcol, $data);
}
}else if($_GET["barcode"]=="00000"){
	$data[barcode]="";
	$data[detail]="";
	array_push($arrcol, $data);
}else{
$sql_r = "SELECT detail from stock_product where barcode = '".$_GET["barcode"]."'";
list($detail) = Mysql_fetch_row(Mysql_Query($sql_r));

	$data[barcode]=$_GET["barcode"];
	$data[detail]=$detail;
	array_push($arrcol, $data);
}
//$data[barcode]="05006";
for($i=0;$i<count($arrcol);$i++){


$sql_r = "SELECT pcs from stock_product_es where barcode = '".$arrcol[$i][barcode]."' AND dateday = '".substr($_GET["date1"],0,4)."-09-30' ";
list($pcs_stock_old) = Mysql_fetch_row(Mysql_Query($sql_r));

if(empty($pcs_stock_old)){
	$pcs_stock_old=0;
}
$sql_r = "SELECT pcs_stock from bill where barcode = '".$arrcol[$i][barcode]."' AND dateday between '".substr($_GET["date1"],0,4)."-09-30' AND '$date_end' ";
$num = mysql_num_rows(mysql_query($sql_r));
// $sql_r.=" ORDER By dateday DESC limit 1";
// list($pcs_stock_old) = Mysql_fetch_row(Mysql_Query($sql_r));


// $sql_r = "SELECT sum(pcs) from stock_product where barcode = '$data[barcode]' ";
// $num = mysql_num_rows(mysql_query($sql_r));
// // $sql_r.=" ORDER By dateday DESC limit 1";
// list($pcs_stock_old) = Mysql_fetch_row(Mysql_Query($sql_r));


// $sql_m = "SELECT sum(pcs) from bill where barcode = '$data[barcode]' AND nobill_system like 'OWH%' AND dateday between '$date_start' AND '$date_end' GROUP By barcode";
// list($pcs_out_old) = Mysql_fetch_row(Mysql_Query($sql_m));

// $sql_m = "SELECT sum(pcs) from bill where barcode = '$data[barcode]' AND nobill_system like 'INV%' AND dateday between '$date_start' AND '$date_end' GROUP By barcode";
// list($pcs_in_old) = Mysql_fetch_row(Mysql_Query($sql_m));


// if($num>1){
//  $pcs_stock_old=$pcs_out_old-$pcs_in_old;
// }



// $sql_m = "SELECT sum(pcs) from bill where barcode = '$data[barcode]' AND nobill_system like 'INV%' AND dateday between '$date_start' AND '$date_end' GROUP By barcode";
// list($pcs_in_old) = Mysql_fetch_row(Mysql_Query($sql_m) or die(mysql_error()));

// //$chk_pcs=($pcs_stock_old+$pcs_out_old)-$pcs_in_old;
//  if($pcs_stock_old<=0){
// $pcs_stock_old=$pcs_out_old-$pcs_in_old;
//  }
// echo $pcs_stock_old;

$page=$num/12;
if(ceil($page)==1){
$star_limit = 0;
$end_limit = $num;
}else{
$star_limit = 0;
$end_limit = 12;	
}
$laststock=$pcs_stock_old;
$end_line=1;
while ( $end_line<= 15) {

?>
<!-- <div class="page_breck" style="width:215mm;height:150mm;border:0px solid #e0e0e0;margin:0px auto;padding: 20px 10px;"> -->
<table class="page_breck" style="width:215mm;height:150mm;border:0px solid #e0e0e0;margin:0px auto;padding: 20px 10px;">
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
		if($star_limit == 0){
			echo "<tr><td style='border:1px solid #e0e0e0;height:30px;text-align:center;'></td>".
				 "<td style='border:1px solid #e0e0e0;'>&nbsp;ยกยอดมาปี ".substr($_GET["date1"],0,4)." </td>".
				 "<td style='border:1px solid #e0e0e0;'></td>".
				 "<td style='border:1px solid #e0e0e0;text-align:center;'>".$pcs_stock_old."</td>".
				 "<td style='border:1px solid #e0e0e0;text-align:center;'></td>".
				 "<td style='border:1px solid #e0e0e0;text-align:center;'></td>".
				 "<td style='border:1px solid #e0e0e0;text-align:right'></td>".
				 "<td style='border:1px solid #e0e0e0;'></td>".
				 "<td style='border:1px solid #e0e0e0;'></td></tr>";
		}


// $sql_sr = "SELECT sum(pcs) from stock_product where barcode = '$data[barcode]' ";
// list($laststock) = Mysql_fetch_row(Mysql_Query($sql_sr));	
 //$laststock=$pcs_stock_old;

	$sql_s = "SELECT nobill_system,dateday,customer_name,nobill,pcs,price,pcs_stock,laststock from bill where barcode = '".$arrcol[$i][barcode]."' AND dateday between '".(substr($_GET["date1"],0,4)-1)."-09-30' AND '$date_end' ORDER By dateday ASC limit 12 OFFSET $star_limit ";
	//echo mysql_num_rows(mysql_query($sql_s));
	$result_s = mysql_query($sql_s);
	$l=0;
	while ($row = mysql_fetch_array($result_s) ) {	
		$l++;
		if(substr($row["nobill_system"],0,3)=="INV"){
			$pcs_in=$row["pcs"];
			$pcs_out="";
			$laststock=$laststock+$pcs_in;
			//$laststock=$laststock+$pcs_in;
		}else{
			$pcs_out=$row["pcs"];
			$pcs_in="";
			//$pcs_stock_old=$laststock-$pcs_out;
			$laststock=$laststock-$pcs_out;
		}
		// if($num>1){
		// $pcs_stock_old=($pcs_stock_old-$pcs_out)+$pcs_in;
		// }else{
		// $pcs_stock_old=$row["laststock"]-$pcs_out+$pcs_in;
		// }

			echo "<tr><td style='border:1px solid #e0e0e0;height:30px;text-align:center;'>".substr($row["dateday"],8,2)."/".substr($row["dateday"],5,2)."/".substr($row["dateday"],0,4)."</td>".
				 "<td style='border:1px solid #e0e0e0;'>&nbsp;".$row["customer_name"]."</td>".
				 "<td style='border:1px solid #e0e0e0;'>&nbsp;".$row["nobill"]."</td>".
				 "<td style='border:1px solid #e0e0e0;text-align:center;'>".$pcs_in."</td>".
				 "<td style='border:1px solid #e0e0e0;text-align:center;'>".$pcs_out."</td>".
				 "<td style='border:1px solid #e0e0e0;text-align:center;'>".$laststock."</td>".
				 "<td style='border:1px solid #e0e0e0;text-align:right'>".comma($row["price"])."&nbsp;&nbsp;</td>".
				 "<td style='border:1px solid #e0e0e0;'></td>".
				 "<td style='border:1px solid #e0e0e0;'></td></tr>";
		}



	
		//$l=1;
		for($li=$l;$li<12;$li++){
			echo "<tr><td style='border:1px solid #e0e0e0;height:30px;'></td>".
				 "<td style='border:1px solid #e0e0e0;'></td>".
				 "<td style='border:1px solid #e0e0e0;'></td>".
				 "<td style='border:1px solid #e0e0e0;'></td>".
				 "<td style='border:1px solid #e0e0e0;'></td>".
				 "<td style='border:1px solid #e0e0e0;'></td>".
				 "<td style='border:1px solid #e0e0e0;'></td>".
				 "<td style='border:1px solid #e0e0e0;'></td>".
				 "<td style='border:1px solid #e0e0e0;'></td></tr>";
		}
		?>
	</tbody>
	<tfoot>
		<td style="height: 10px;"></td>
		<tr><td colspan="9" style="height: 40px;">รหัสพัสดุ <span style="font-weight: bold;border-bottom: 1px dotted #e0e0e0;padding:0px 20px;"><?=$arrcol[$i][barcode]?></span> พัสดุ <span style="font-weight: bold;border-bottom: 1px dotted #e0e0e0;padding:0px 20px;"><?=$arrcol[$i][detail]?> </span>ขนาด/ลักษณะ......<td>		
	</tfoot>
</table>
<!-- </div> -->
<?
if($end_limit>=$num){
	 $end_line=20;
}else{
	$end_line++;
$star_limit = $end_limit;
$end_limit = $end_limit+12;
}

}
}
?>


</body>
</html>