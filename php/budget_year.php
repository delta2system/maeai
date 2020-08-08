
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

function group_name($str){
	if(isset($str)){
		// $strSql="SELECT detail FROM group_type WHERE code = '$str'";
		// $result=mysqli_query($strSql);
		// list($detail)=mysqli_fetch_row($result);
		// return $detail;
		include("connect.php");
		  $sql = "SELECT detail from group_type WHERE code = '$str'  ";
 		 list($detail) = Mysqli_fetch_row(Mysqli_Query($con,$sql));
 		 return $detail;

	}
}
function total_thisyear($barcode,$year){
		include("connect.php");
		$year_old=$year-2;
		  $sql = "SELECT SUM(pcs) from bill WHERE barcode = '$barcode' AND status = 'OWH' AND dateday between '".$year_old."-10-01' AND '".($year-1)."-09-30'  ";
 		 list($sumpcs) = Mysqli_fetch_row(Mysqli_Query($con,$sql));
 		 return $sumpcs;
}
function price_new($barcode){

		include("connect.php");
		$sql = "SELECT price_in from stock_product Where barcode = '$barcode' ORDER By price_in DESC limit 1";
		$result = mysqli_query($con,$sql);
		$i=0; $new_price = 0;

		while ($data = mysqli_fetch_assoc($result)) {
			//$i++;
			$new_price = $new_price + $data["price_in"];

		}
		return  round($new_price);

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
		body{
			font-size: 12px;
		}
		td{
			padding-right:5px;
			border:1px solid #e0e0e0;
		}
		.head_table{
			text-align: center;
			font-size:10px;
			border:1px solid #666666;
			background-color:#c0c0c0;
		}
	</style>
	<script type="text/javascript">
		function addCommas(nStr)
      {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
      }

      function save_cal(str){
      	var id = str.id.replace("new_pcs","");
      	var val = str.value;
      	var year = $("#year").html();
      	var price = parseFloat(document.getElementById("new_price"+id).value);
      	//alert(year);
      	 	$.ajax({ 
                url: "mysql_budget_year.php" ,
                type: "POST",
                data: 'submit=save_cal&id='+id+'&value='+val+'&year='+year+'&price='+price,
            })
            .success(function(result) {
            	//alert(result);
            });
      }

      function save_calprice(str){
       	var id = str.id.replace("new_price","");
      	var val = str.value;
      	var year = $("#year").html();
      	var pcs = parseFloat(document.getElementById("new_pcs"+id).value);
      	//alert(year);
      	 	$.ajax({ 
                url: "mysql_budget_year.php" ,
                type: "POST",
                data: 'submit=save_cal&id='+id+'&value='+pcs+'&year='+year+'&price='+val,
            })
            .success(function(result) {
            	//alert(result);
            });     	
      }

		function cal_price_new(val,name){
			var price = parseFloat(document.getElementById("new_price"+name).value);
			document.getElementById("total_price"+name).innerHTML = addCommas(price*val);

			document.getElementById("1_quarter"+name).innerHTML =  addCommas(val/4);
			document.getElementById("1_charges"+name).innerHTML =  addCommas((val/4)*price);
			document.getElementById("2_quarter"+name).innerHTML =  addCommas(val/4);
			document.getElementById("2_charges"+name).innerHTML =  addCommas((val/4)*price);
			document.getElementById("3_quarter"+name).innerHTML =  addCommas(val/4);
			document.getElementById("3_charges"+name).innerHTML =  addCommas((val/4)*price);
			document.getElementById("4_quarter"+name).innerHTML =  addCommas(val/4);
			document.getElementById("4_charges"+name).innerHTML =  addCommas((val/4)*price);
				qua_cal();

		}

		function qua_cal(){
			var a = parseFloat(calculatesum('qu_a'));
			var b = parseFloat(calculatesum('qu_b'));
			var c = parseFloat(calculatesum('qu_c'));
			var d = parseFloat(calculatesum('qu_d'));

			$("#qua_a").html(addCommas(a));
			$("#qua_b").html(addCommas(b));
			$("#qua_c").html(addCommas(c));
			$("#qua_d").html(addCommas(d));
			$("#total_qua").html(addCommas((a+b+c+d).toFixed(2)));
		}


function calculatesum(es){
var sum = 0;

 $("."+es).each(function(){
 	var rs = parseFloat(this.innerHTML.replace(",",""));
 	if(!isNaN(rs) && rs.length!=0){
 		sum += parseFloat(rs);
 	}
 	//alert(rs);
 }); 
 		return sum.toFixed(2);

}
	</script>

</head>
<body>
	<img id="print_show" src="../images/menu/Printer.png" style="position: fixed;width:30px;right: 20px;top:20px;" onclick="window.open('budget_year_print.php?year=<?=$year?>')">
<table style="width:1754px;">
	<tr><th colspan="29" style="text-align: center;">แผนปฏิบัติการจัดซื้อวัสดุสำรองคลัง</th></tr>
	<tr><th colspan="29" style="text-align: center;">หน่วยงาน พัสดุ <?=$hp["company_name"]?> จังหวัดเชียงใหม่</th></tr>
	<tr><th colspan="29" style="text-align: center;">ประจำปีงบประมาณ <span id="year"><?=$year?></span></th></tr>
	<tr>
		<td rowspan="2" class="head_table">ลำดับ</td>
		<td class="head_table">รหัสสินค้า</td>
		<td rowspan="2" class="head_table">รายการวัสดุสำรองคลัง</td>
		<td class="head_table">ประเภท</td>
		<td rowspan="2" class="head_table">หน่วยบรรจุ</td>
		<td rowspan="2" class="head_table">หน่วยนับ</td>
		<td  class="head_table">อัตราการใช้</td>
		<td rowspan="2" class="head_table">ประมาณการใช้ปี <br><?=$year?></td>
		<td rowspan="2" class="head_table">ปริมาณคงคลังยกมา </td>
		<td rowspan="2" class="head_table">ปริมาณการจัดซื้อปี <br><?=$year?></td>
		<td rowspan="2" class="head_table">ราคาต่อหน่วย</td>
		<td class="head_table">ไตรมาศที่ 1</td>
		<td rowspan="2" class="head_table">มูลค่า</td>
		<td class="head_table">ไตรมาศที่ 2</td>
		<td rowspan="2" class="head_table">มูลค่า</td>
		<td class="head_table">ไตรมาศที่ 3</td>
		<td rowspan="2" class="head_table">มูลค่า</td>
		<td class="head_table">ไตรมาศที่ 4</td>
		<td rowspan="2" class="head_table">มูลค่า</td>
		<td colspan='4' class="head_table">ซื้อจริง</td>
		<td colspan='4' class="head_table">มูลค่าซื้อจริง</td>
		<td colspan="2" class="head_table">ยอดรวมจัดซื้อจริง</td>

	</tr>
	<tr>
		<td class="head_table"></td>
		<td class="head_table"></td>
		<td class="head_table">ปี <?=$year-1?></td>
				<td class="head_table"></td>
		<td class="head_table"></td>
				<td class="head_table"></td>
		<td class="head_table"></td>
		<td class="head_table">ไตรมาศที่ 1</td>
		<td class="head_table">ไตรมาศที่ 2</td>
		<td class="head_table">ไตรมาศที่ 3</td>
		<td class="head_table">ไตรมาศที่ 4</td>
		<td class="head_table">ไตรมาศที่ 1</td>
		<td class="head_table">ไตรมาศที่ 2</td>
		<td class="head_table">ไตรมาศที่ 3</td>
		<td class="head_table">ไตรมาศที่ 4</td>
		<td class="head_table">จำนวน</td>
		<td class="head_table">มูลค่า</td>

	</tr>
<?
$n=0;
$strSql="SELECT * FROM stock_product WHERE 1 GROUP By barcode ORDER by group_type ASC,barcode ASC ";
$result=mysqli_query($con,$strSql);
while ($data = mysqli_fetch_assoc($result)) {
	$n++;

	  $sqls = "SELECT pcs,price from cal_budget_year WHERE barcode = '".$data["barcode"]."' AND year = '".$year."'  ";
 		 list($pcs_budget,$price_budget) = Mysqli_fetch_row(Mysqli_Query($con,$sqls));

	echo "<tr >"
		 ."<td style='text-align:center;'>$n</td>"
		 ."<td style='text-align:center'>$data[barcode]</td>"
		 ."<td style=''>$data[detail]</td>"
		 ."<td style=''>".group_name($data["group_type"])."</td>"
		 ."<td style='text-align:center';>1</td>"
		 ."<td style='text-align:center'>$data[unit]</td>"
		 ."<td style='text-align:center'>".total_thisyear($data["barcode"],$year)."</td>"
		 ."<td style='text-align:center;'><input type='number' id='new_pcs".$data["barcode"]."' value='".$pcs_budget."' style='width:50px;border:1px solid #c0c0c0;border-radius:3px;text-align:center;' onkeyup=\"cal_price_new(this.value,'".$data["barcode"]."');save_cal(this);\"></td>"
		 ."<td style='text-align:right;'>".$data["pcs"]."</td>"
		 ."<td id='total_price".$data["barcode"]."' style='text-align:right;'></td>";
	if($price_budget){
		 echo "<td style='text-align:right;' ><input type='text' id='new_price".$data["barcode"]."' value='".$price_budget."' style='width:50px;border:1px solid #c0c0c0;border-radius:3px;text-align:center;' onkeyup=\"cal_price_new('$pcs_budget','".$data["barcode"]."');save_calprice(this);\"></td>";
		}else{
		echo "<td style='text-align:right;' ><input type='text' id='new_price".$data["barcode"]."' value='".price_new($data["barcode"])."' style='width:50px;border:1px solid #c0c0c0;border-radius:3px;text-align:center;' onkeyup=\"cal_price_new('$pcs_budget','".$data["barcode"]."');save_calprice(this);\"></td>";
		}
	echo "<td id='1_quarter".$data["barcode"]."' style='text-align:right;'></td>"
		 ."<td id='1_charges".$data["barcode"]."' class='qu_a' style='text-align:right;'></td>"
		 ."<td id='2_quarter".$data["barcode"]."' style='text-align:right;'></td>"
		 ."<td id='2_charges".$data["barcode"]."' class='qu_b' style='text-align:right;'></td>"
		 ."<td id='3_quarter".$data["barcode"]."' style='text-align:right;'></td>"
		 ."<td id='3_charges".$data["barcode"]."' class='qu_c'style='text-align:right;'></td>"
		 ."<td id='4_quarter".$data["barcode"]."' style='text-align:right;'></td>"
		 ."<td id='4_charges".$data["barcode"]."' class='qu_d' style='text-align:right;'></td>";

		 if($pcs_budget>0){
 		 	echo ("<script>cal_price_new('".$pcs_budget."','".$data["barcode"]."');</script>");
 		 }
}


?>
<tr><td colspan="10" style="text-align: right;padding-right: 10px">รวมมูลค่าการสั่งซื้อแต่ละไตรมาส</td>
<td colspan="2"></td>
<td style="border: 1px solid #e0e0e0;text-align: center;" id="qua_a" ></td>
<td ></td>
<td style="border: 1px solid #e0e0e0;text-align: center;" id="qua_b"></td>
<td ></td>
<td style="border: 1px solid #e0e0e0;text-align: center;" id="qua_c"></td>
<td ></td>
<td style="border: 1px solid #e0e0e0;text-align: center;" id="qua_d"></td>
</tr>
<tr><td colspan="10" style="text-align: right;padding-right: 10px">รวมมูลค่าจัดซื้อทั้งปี</td>
<td colspan="3" style="text-align: center;" id="total_qua"></td></tr>
</table>
</body>
</html>
<script type="text/javascript">
	qua_cal();
</script>