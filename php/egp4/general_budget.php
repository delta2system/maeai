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

function commaa($str){
	if($str>0 || $str>'0'){
		return number_format($str);
	}
}

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
<script type="text/javascript">
	function other_future(val,typ,id,year){
			$.ajax({ 
                url: "mysql_budget_general.php" ,
                type: "POST",
                data: 'submit=save_real&id='+id+'&val='+val+'&year='+year+'&type='+typ,
            })
            .success(function(result) {
            	//alert(result);
            });   

		}
</script>

</head>
<body>
<img id="print_show" src="../../../images/menu/Printer.png" style="position: fixed;width:30px;right: 20px;top:20px;" onclick="window.open('general_budget_print.php?year=<?=$year?>')">
<table style="width:980px;">
<tr>
	<th colspan="5" style="text-align: center;font-size:24px;">แผนการจัดซื้อ/จัดจ้างของวัสดุสำนักงานทั่วไป ปีงบประมาณ <?=$year?></th>
</tr>
<tr>
	<td class="head_table">รายการวัสดุ</td>
	<td class="head_table">แผนการจัดซื้อ<br>ปี <?=$year-1?></td>
	<td class="head_table">ยอดจัดซื้อ/จัดจ้างปี <?=$year-1?> <br> ถึง <?=$year?></td>
	<td class="head_table">ยอดจัดซื้อ/จัดจ้างปี <?=$year?> <br>ณ วันที่ <?=date("d/m/").(date("Y")+544)?></td>
	<td class="head_table">ประมาณการ<br>แผนจัดซื้อปี <?=$year?></td>
	<td class="head_table">หมายเหตุ</td>
</tr>
	<?
$n=0;
$strSql="SELECT * FROM hire_type ORDER by row_id ASC";
$result=mysqli_query($con,$strSql);
$total_old=array();
$total_new=array();
$total_true=array();
$total_year_now=array();
while ($data = mysqli_fetch_assoc($result)) {

		  $sqls = "SELECT budget,budget_true FROM asset_name_out WHERE year = '".($year-1)."' AND id = '".$data["row_id"]."'  ";
 		 list($budget_old,$budget_true) = Mysqli_fetch_row(Mysqli_Query($con,$sqls));

 		 $sqls = "SELECT budget FROM asset_name_out WHERE year = '".$year."' AND id = '".$data["row_id"]."'  ";
 		 list($budget_f) = Mysqli_fetch_row(Mysqli_Query($con,$sqls));

 		   $sqlr = "SELECT  SUM(total) FROM egp_product WHERE store = 'out' AND group_type = '".$data["row_id"]."' ";
 		 list($total_group) = Mysqli_fetch_row(Mysqli_Query($con,$sqlr));
 		 array_push($total_year_now, $total_group);
 		 array_push($total_old, $budget_old);
 		 array_push($total_new, $budget_f);
 		 array_push($total_true, $budget_true);
	print "<tr><td >".$data["row_id"].".".$data["detail"]."</td>"
		  ."<td style='text-align:center;padding-right:10px;'><input type='text' value='".commaa($budget_old)."' style='border:0px solid #e0e0e0;width:70%;border-radius:5px;padding:5px;text-align:right;'></td>"
		  ."<td style='text-align:right;padding-right:10px;'><input type='text' value='$budget_true' style='border:1px solid #e0e0e0;width:70%;border-radius:5px;padding:5px;text-align:right;' onkeyup=\"other_future(this.value,'budget_old','".$data["row_id"]."','".($year-1)."')\"></td>"
		  		  ."<td style='text-align:right;padding-right:10px;'>".commaa($total_group)."</td>"
		  ."<td style='text-align:center;padding-right:10px;text-align:right;'><input type='text' value='".commaa($data["budget"])."' style='border:1px solid #e0e0e0;width:70%;border-radius:5px;padding:5px;text-align:right;' onkeyup=\"other_future(this.value,'budget_new','".$data["row_id"]."','".$year."')\"></td>"
		  ."<td><input type='text' value='".$data["other"]."' onkeyup=\"other_future(this.value,'other','".$data["row_id"]."','".$year."')\" style='border:1px solid #e0e0e0;width:90%;border-radius:5px;padding:5px;'></td></tr>";

}
print "<tr><td style='text-align:center;font-weight:bold;'>รวมมูลค่า</td>"
	  ."<td style='text-align:right;padding-right:10px;font-weight:bold;'>".commaa(array_sum($total_old))."</td>"
	  ."<td style='text-align:right;padding-right:10px;font-weight:bold;'>".commaa(array_sum($total_true))."</td>"
	  ."<td style='text-align:right;padding-right:10px;font-weight:bold;'>".commaa(array_sum($total_year_now))."</td>"
	  ."<td style='text-align:right;padding-right:10px;font-weight:bold;'>".commaa(array_sum($total_new))."</td>"
	  ."<td style='text-align:right;padding-right:10px;font-weight:bold;'></td></tr>";


	?>

</body>
</html>
