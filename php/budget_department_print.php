
<? 
session_start();
include("connect.php");
if(isset($_GET["year"])){
	$year = $_GET["year"];
}else{
$year = date("Y")+544;
}

$sql = "SELECT * from tbl_company ";
$result = mysqli_query($con,$sql);
while ($row = mysqli_fetch_array($result) ) {
$hp[$row["tbl_title"]]=$row["tbl_value"];

}


function group_name($str){
	if(isset($str)){
		include("connect.php");
		 $sql = "SELECT detail from group_type WHERE code = '$str'  ";
 		 list($detail) = Mysqli_fetch_row(Mysqli_Query($con,$sql));
 		 return $detail;

	}
}


function cal_number($str){
	if($str){
		return number_format($str);
	}else{
		return "";
	}
}

function department($str){
			
		include("connect.php");
		 $sql = "SELECT name FROM department WHERE code = '$str'  ";
 		 list($name) = Mysqli_fetch_row(Mysqli_Query($con,$sql));
 		 return $name;
		}



?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
	<script type="text/javascript" src="../js/jquery-1.11.1.js"></script>
	<style type="text/css">
		table{
			border-collapse: collapse;
		}
		body,select{
			font-family: tahoma;
			font-size: 16px;
		}
		input{
			border:1px solid #797979;
			border-radius:3px;
		}
		td{
			padding:5px 5px;
			border:1px solid #e0e0e0;
		}
		.head_table{
			text-align: center;
			font-size:16px;
			border:1px solid #666666;
			background-color:#c0c0c0;
		}

	</style>

</head>
<body>
<table >
	<thead>
	<tr><th colspan="18" style="text-align: center;">แผนปฏิบัติการจัดซื้อวัสดุสำรองคลัง ประจำปีงบประมาณ <span id="year"><?=$year?></th></tr>
	<tr><th colspan="18" style="text-align: center;">หน่วยงาน พัสดุ <?=$hp["company_name"]?> จังหวัดเชียงใหม่</th></tr>
	<tr><th colspan="18" style="text-align: center;">แผนก<?=department($_GET["department"])?> </th></tr>

		
	</th></tr>
	<tr>
		<td class="head_table">ลำดับ</td>
		<td class="head_table">ประเภท</td>
		<td class="head_table">รหัสสินค้า</td>
		<td class="head_table">รายการ</td>
		
		<td class="head_table">ม.ค.</td>
		<td class="head_table">ก.พ.</td>
		<td class="head_table">มี.ค.</td>
		<td class="head_table">เม.ย.</td>
		<td class="head_table">พ.ค.</td>
		<td class="head_table">มิ.ย.</td>
		<td class="head_table">ก.ค.</td>
		<td class="head_table">ส.ค.</td>
		<td class="head_table">ก.ย.</td>
		<td class="head_table">ต.ค.</td>
		<td class="head_table">พ.ย.</td>
		<td class="head_table">ธ.ค.</td>
		<td class="head_table">รวมจำนวน</td>
		<td class="head_table">หน่วยบรรจุ</td>
</thead>
<tbody>

<?
// $n=0;
$strSql="SELECT * FROM cal_budget_department WHERE department = '".$_GET["department"]."' AND year = '".$_GET["year"]."' ORDER By barcode ASC";
$result=mysqli_query($con,$strSql);
while ($data = mysqli_fetch_assoc($result)) {

	 $total = $data[m1]+$data[m2]+$data[m3]+$data[m4]+$data[m5]+$data[m6]+$data[m7]+$data[m8]+$data[m9]+$data[m10]+$data[m11]+$data[m12];
	if($total>0){
	$n++;
	  $sqls = "SELECT detail,group_type,unit from stock_product WHERE barcode = '".$data["barcode"]."' ";
 	  $row = mysqli_fetch_assoc(mysqli_query($con,$sqls));

 	 
 	echo "<tr class='hover_'>"
 		 ."<td style='text-align:center;'>$n</td>"
 		 ."<td style='font-size:14px;'>".group_name($row["group_type"])."</td>"
 		 ."<td style='text-align:center'>$data[barcode]</td>"
 		 ."<td style=''>$row[detail]</td>"
// 		 
// 		 ."<td style='text-align:center';>1</td>"
 		 
 		 ."<td style='text-align:center;'>".cal_number($data[m1])."</td>"
 		 ."<td style='text-align:center;'>".cal_number($data[m2])."</td>"
 		 ."<td style='text-align:center;'>".cal_number($data[m3])."</td>"
 		 ."<td style='text-align:center;'>".cal_number($data[m4])."</td>"
 		 ."<td style='text-align:center;'>".cal_number($data[m5])."</td>"
 		 ."<td style='text-align:center;'>".cal_number($data[m6])."</td>"
 		 ."<td style='text-align:center;'>".cal_number($data[m7])."</td>"
 		 ."<td style='text-align:center;'>".cal_number($data[m8])."</td>"
 		 ."<td style='text-align:center;'>".cal_number($data[m9])."</td>"
 		 ."<td style='text-align:center;'>".cal_number($data[m10])."</td>"
 		 ."<td style='text-align:center;'>".cal_number($data[m11])."</td>"
 		 ."<td style='text-align:center;'>".cal_number($data[m12])."</td>"
 		 ."<td style='text-align:right;padding-right:10px;'>".cal_number($total)."</td>"
 		 ."<td style='text-align:center'>$row[unit]</td>";

 		 }
 
}

?>

</tbody>
</table>
</body>
</html>
