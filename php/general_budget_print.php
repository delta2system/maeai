
<? 
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

// function pcs_return($str,$ye){
// 		include("connect.php");
// 		  $sql = "SELECT pcs from cal_budget_year WHERE barcode = '$str' AND year = '".$ye."'  ";
//  		 list($pcs) = Mysqli_fetch_row(Mysqli_Query($con,$sql));
//  		 if($pcs>0){
//  		 return $pcs;
//  		 echo "<script>cal_price_new('$str')</script>";
//  		}else{
//  			return "";
//  		}
// }



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
		body{
			
		}
		td{
			padding-right:5px;
			border:1px solid #e0e0e0;
			font-size: 12px;
		}
		.head_table{
			text-align: center;
			font-size: 12px;
			border:1px solid #666666;
			background-color:#c0c0c0;
		}
		input[type="text"]{
			font-size: 12px;
		}
	</style>


</head>
<body>

<table style="width:780px;">
<tr>
	<th colspan="5" style="text-align: center;font-size:24px;">แผนการจัดซื้อ/จัดจ้างของวัสดุสำนักงานทั่วไป ปีงบประมาณ <?=$year?></th>
</tr>
<tr>
	<td class="head_table">รายการวัสดุ</td>
	<td class="head_table">แผนการจัดซื้อ<br>ปี <?=$year-1?></td>
	<td class="head_table">ยอดจัดซื้อ/จัดจ้างปี <?=$year-1?> <br>ณ วันที่ <?=date("d/m/").(date("Y")+543)?></td>
	<td class="head_table">ประมาณการ<br>แผนจัดซื้อปี <?=$year?></td>
	<td class="head_table">หมายเหตุ</td>
</tr>
	<?
$n=0;
$strSql="SELECT * FROM asset_name WHERE year = '$year' ORDER by id ASC";
$result=mysqli_query($con,$strSql);
$total_old=array();
$total_new=array();
$total_true=array();
while ($data = mysqli_fetch_assoc($result)) {

		  $sqls = "SELECT budget,budget_true FROM asset_name WHERE year = '".($year-1)."' AND id = '".$data["id"]."'  ";
 		 list($budget_old,$budget_true) = Mysqli_fetch_row(Mysqli_Query($con,$sqls));
 		 array_push($total_old, $budget_old);
 		 array_push($total_new, $data["budget"]);
 		 array_push($total_true,$budget_true);
	print "<tr><td >".$data["id"].".".$data["name"]."</td>"
		  ."<td style='text-align:right;padding-right:10px;text-align:right;'>".number_format($budget_old)."</td>"
		  ."<td style='text-align:right;padding-right:10px;text-align:right;'>".number_format($budget_true)."</td>"
		  ."<td style='text-align:right;padding-right:10px;text-align:right;'>".number_format($data["budget"])."</td>"
		  ."<td>".$data["other"]."</td></tr>";

}
print "<tr><td style='text-align:center;font-weight:bold;'>รวมมูลค่า</td>"
	  ."<td style='text-align:right;padding-right:10px;font-weight:bold;'>".number_format(array_sum($total_old))."</td>"
	  ."<td style='text-align:right;padding-right:10px;font-weight:bold;'>".number_format(array_sum($total_true))."</td>"
	  ."<td style='text-align:right;padding-right:10px;font-weight:bold;'>".number_format(array_sum($total_new))."</td>"
	  ."<td style='text-align:right;padding-right:10px;font-weight:bold;'></td></tr>";


	?>

</body>
</html>
<script type="text/javascript">window.print();</script>