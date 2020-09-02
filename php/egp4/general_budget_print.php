
<? 
include("../connect.php");
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

function commaa($str){
	if($str>0 || $str>'0'){
		return number_format($str);
	}
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
	<script type="text/javascript" src="../../../js/jquery-1.11.1.js"></script>
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
	<td class="head_table">แผนการจัดซื้อ<br>ปี <?=$year?></td>
	<td class="head_table">ยอดจัดซื้อ/จัดจ้างปี <?=$year?> <br>ณ วันที่ <?=date("d/m/").(date("Y")+543)?></td>

	<td class="head_table">หมายเหตุ</td>
</tr>
	<?
$n=0;
$strSql="SELECT * FROM asset_name_out WHERE year = '$year' AND budget > '0' ORDER by id ASC";
$result=mysqli_query($con,$strSql);
$total_old=array();
$total_new=array();
$total_true=array();
$total_year_now=array();
while ($data = mysqli_fetch_assoc($result)) {

		 $sqls = "SELECT budget,budget_true FROM asset_name_out WHERE year = '".$year."' AND id = '".$data["id"]."'  ";
 		 list($budget_old,$budget_true) = Mysqli_fetch_row(Mysqli_Query($con,$sqls));


 		   $sqlr = "SELECT  SUM(total) FROM egp_product WHERE store = 'out' AND group_type = '".$data["id"]."' ";
 		 list($total_group) = Mysqli_fetch_row(Mysqli_Query($con,$sqlr));
 		 array_push($total_year_now, $total_group);
 		 array_push($total_old, $budget_old);
 		 array_push($total_new, $data["budget"]);
 		 array_push($total_true,$budget_true);
	print "<tr><td >".$data["id"].".".$data["name"]."</td>"
		  ."<td style='text-align:right;padding-right:10px;text-align:right;'>".commaa($data["budget"])."</td>"
		  ."<td style='text-align:right;padding-right:10px;text-align:right;'>".commaa($total_group)."</td>"

		  ."<td>".$data["other"]."</td></tr>";

}
print "<tr><td style='text-align:center;font-weight:bold;'>รวมมูลค่า</td>"
	  ."<td style='text-align:right;padding-right:10px;font-weight:bold;'>".commaa(array_sum($total_new))."</td>"
	  ."<td style='text-align:right;padding-right:10px;font-weight:bold;'>".commaa(array_sum($total_year_now))."</td>"

	  ."<td style='text-align:right;padding-right:10px;font-weight:bold;'></td></tr>";


	?>

</body>
</html>
<script type="text/javascript">window.print();</script>