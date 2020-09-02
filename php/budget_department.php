
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

//       function save_cal(str){
//       	var id = str.id.replace("new_pcs","");
//       	var val = str.value;
//       	var year = $("#year").html();
//       	var price = parseFloat(document.getElementById("new_price"+id).value);
//       	//alert(year);
//       	 	$.ajax({ 
//                 url: "mysql_budget_year.php" ,
//                 type: "POST",
//                 data: 'submit=save_cal&id='+id+'&value='+val+'&year='+year+'&price='+price,
//             })
//             .success(function(result) {
//             	//alert(result);
//             });
//       }

//       function save_calprice(str){
//        	var id = str.id.replace("new_price","");
//       	var val = str.value;
//       	var year = $("#year").html();
//       	var pcs = parseFloat(document.getElementById("new_pcs"+id).value);
//       	//alert(year);
//       	 	$.ajax({ 
//                 url: "mysql_budget_year.php" ,
//                 type: "POST",
//                 data: 'submit=save_cal&id='+id+'&value='+pcs+'&year='+year+'&price='+val,
//             })
//             .success(function(result) {
//             	//alert(result);
//             });     	
//       }

// 		function cal_price_new(val,name){
// 			var price = parseFloat(document.getElementById("new_price"+name).value);
// 			document.getElementById("total_price"+name).innerHTML = addCommas(price*val);

// 			document.getElementById("1_quarter"+name).innerHTML =  addCommas(val/4);
// 			document.getElementById("1_charges"+name).innerHTML =  addCommas((val/4)*price);
// 			document.getElementById("2_quarter"+name).innerHTML =  addCommas(val/4);
// 			document.getElementById("2_charges"+name).innerHTML =  addCommas((val/4)*price);
// 			document.getElementById("3_quarter"+name).innerHTML =  addCommas(val/4);
// 			document.getElementById("3_charges"+name).innerHTML =  addCommas((val/4)*price);
// 			document.getElementById("4_quarter"+name).innerHTML =  addCommas(val/4);
// 			document.getElementById("4_charges"+name).innerHTML =  addCommas((val/4)*price);
// 				qua_cal();

// 		}

// 		function qua_cal(){
// 			var a = parseFloat(calculatesum('qu_a'));
// 			var b = parseFloat(calculatesum('qu_b'));
// 			var c = parseFloat(calculatesum('qu_c'));
// 			var d = parseFloat(calculatesum('qu_d'));

// 			$("#qua_a").html(addCommas(a));
// 			$("#qua_b").html(addCommas(b));
// 			$("#qua_c").html(addCommas(c));
// 			$("#qua_d").html(addCommas(d));
// 			$("#total_qua").html(addCommas((a+b+c+d).toFixed(2)));
// 		}


// function calculatesum(es){
// var sum = 0;

//  $("."+es).each(function(){
//  	var rs = parseFloat(this.innerHTML.replace(",",""));
//  	if(!isNaN(rs) && rs.length!=0){
//  		sum += parseFloat(rs);
//  	}
//  	//alert(rs);
//  }); 
//  		return sum.toFixed(2);

// }
	</script>

</head>
<body>
	<!-- <img id="print_show" src="../images/menu/Printer.png" style="position: fixed;width:30px;right: 20px;top:20px;" onclick="window.open('budget_year_print.php?year=<?=$year?>')"> -->
	<img id="print_show" src="../images/menu/Printer.png" style="position: fixed;width:30px;right: 20px;top:20px;" onclick="print_page()">

<table >
	<thead>
	<tr><th colspan="18" style="text-align: center;">แผนปฏิบัติการจัดซื้อวัสดุสำรองคลัง ประจำปีงบประมาณ <span id="year"><?=$year?></th></tr>
	<tr><th colspan="18" style="text-align: center;">หน่วยงาน พัสดุ <?=$hp["company_name"]?> จังหวัดเชียงใหม่</th></tr>
	<tr><th colspan="2"><select style="padding:5px 5px;font-size: 18px;border:0px solid #e0e0e0" id="department" onchange="return_data()">  
			<option></option>
			<?
			$strSqld="SELECT code,name FROM department WHERE 1";
			$resultd=mysqli_query($con,$strSqld);
			while ($de = mysqli_fetch_assoc($resultd)) {
				if($_SESSION["xdepartment"]==$de[code]){
					echo "<option value='$de[code]' selected>$de[name]</option>";
				}else{
				echo "<option value='$de[code]'>$de[name]</option>";
			}
		}
			?>
		</select></th><th colspan="16" style="text-align: center;"></span> 
		
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
<!-- 		<td  class="head_table">อัตราการใช้</td>
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
		<td colspan="2" class="head_table">ยอดรวมจัดซื้อจริง</td> -->

	</tr>
<!-- 	<tr>
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

	</tr> -->
<?
// $n=0;
$strSql="SELECT * FROM stock_product WHERE 1 GROUP By barcode ORDER by group_type ASC,barcode ASC ";
$result=mysqli_query($con,$strSql);
while ($data = mysqli_fetch_assoc($result)) {
	$n++;

// 	  $sqls = "SELECT pcs,price from cal_budget_year WHERE barcode = '".$data["barcode"]."' AND year = '".$year."'  ";
//  		 list($pcs_budget,$price_budget) = Mysqli_fetch_row(Mysqli_Query($con,$sqls));

 	echo "<tr class='hover_'>"
 		 ."<td style='text-align:center;'>$n</td>"
 		 ."<td style='font-size:14px;'>".group_name($data["group_type"])."</td>"
 		 ."<td style='text-align:center'>$data[barcode]</td>"
 		 ."<td style=''>$data[detail]</td>"
// 		 
// 		 ."<td style='text-align:center';>1</td>"
 		 
 		 ."<td style='padding:0px 0px;'><input type='text' id='m1_".$data[barcode]."' style='width:50px;text-align:center;'></td>"
 		 ."<td style='padding:0px 0px;'><input type='text' id='m2_".$data[barcode]."' style='width:50px;text-align:center;'></td>"
 		 ."<td style='padding:0px 0px;'><input type='text' id='m3_".$data[barcode]."' style='width:50px;text-align:center;'></td>"
 		 ."<td style='padding:0px 0px;'><input type='text' id='m4_".$data[barcode]."' style='width:50px;text-align:center;'></td>"
 		 ."<td style='padding:0px 0px;'><input type='text' id='m5_".$data[barcode]."' style='width:50px;text-align:center;'></td>"
 		 ."<td style='padding:0px 0px;'><input type='text' id='m6_".$data[barcode]."' style='width:50px;text-align:center;'></td>"
 		 ."<td style='padding:0px 0px;'><input type='text' id='m7_".$data[barcode]."' style='width:50px;text-align:center;'></td>"
 		 ."<td style='padding:0px 0px;'><input type='text' id='m8_".$data[barcode]."' style='width:50px;text-align:center;'></td>"
 		 ."<td style='padding:0px 0px;'><input type='text' id='m9_".$data[barcode]."' style='width:50px;text-align:center;'></td>"
 		 ."<td style='padding:0px 0px;'><input type='text' id='m10_".$data[barcode]."' style='width:50px;text-align:center;'></td>"
 		 ."<td style='padding:0px 0px;'><input type='text' id='m11_".$data[barcode]."' style='width:50px;text-align:center;'></td>"
 		 ."<td style='padding:0px 0px;'><input type='text' id='m12_".$data[barcode]."' style='width:50px;text-align:center;'></td>"
 		 ."<td><div id='total_".$data[barcode]."' style='width:100%;text-align:center;'></div></td>"
 		 ."<td style='text-align:center'>$data[unit]</td>";
// 		 ."<td style='text-align:center'>".total_thisyear($data["barcode"],$year)."</td>"
// 		 ."<td style='text-align:center;'><input type='number' id='new_pcs".$data["barcode"]."' value='".$pcs_budget."' style='width:50px;border:1px solid #c0c0c0;border-radius:3px;text-align:center;' onkeyup=\"cal_price_new(this.value,'".$data["barcode"]."');save_cal(this);\"></td>"
// 		 ."<td style='text-align:right;'>".$data["pcs"]."</td>"
// 		 ."<td id='total_price".$data["barcode"]."' style='text-align:right;'></td>";
// 	if($price_budget){
// 		 echo "<td style='text-align:right;' ><input type='text' id='new_price".$data["barcode"]."' value='".$price_budget."' style='width:50px;border:1px solid #c0c0c0;border-radius:3px;text-align:center;' onkeyup=\"cal_price_new('$pcs_budget','".$data["barcode"]."');save_calprice(this);\"></td>";
// 		}else{
// 		echo "<td style='text-align:right;' ><input type='text' id='new_price".$data["barcode"]."' value='".price_new($data["barcode"])."' style='width:50px;border:1px solid #c0c0c0;border-radius:3px;text-align:center;' onkeyup=\"cal_price_new('$pcs_budget','".$data["barcode"]."');save_calprice(this);\"></td>";
// 		}
// 	echo "<td id='1_quarter".$data["barcode"]."' style='text-align:right;'></td>"
// 		 ."<td id='1_charges".$data["barcode"]."' class='qu_a' style='text-align:right;'></td>"
// 		 ."<td id='2_quarter".$data["barcode"]."' style='text-align:right;'></td>"
// 		 ."<td id='2_charges".$data["barcode"]."' class='qu_b' style='text-align:right;'></td>"
// 		 ."<td id='3_quarter".$data["barcode"]."' style='text-align:right;'></td>"
// 		 ."<td id='3_charges".$data["barcode"]."' class='qu_c'style='text-align:right;'></td>"
// 		 ."<td id='4_quarter".$data["barcode"]."' style='text-align:right;'></td>"
// 		 ."<td id='4_charges".$data["barcode"]."' class='qu_d' style='text-align:right;'></td>";

// 		 if($pcs_budget>0){
//  		 	echo ("<script>cal_price_new('".$pcs_budget."','".$data["barcode"]."');</script>");
 		 }
 


?>
<!-- <tr><td colspan="10" style="text-align: right;padding-right: 10px">รวมมูลค่าการสั่งซื้อแต่ละไตรมาส</td>
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
<td colspan="3" style="text-align: center;" id="total_qua"></td></tr> -->
</tbody>
</table>
</body>
</html>
<script type="text/javascript">

 $( function() {
$("input").keyup(function(e){
  var ids = this.id;
  	  barcode = (ids.slice(3));
  	  barcode = barcode.replace("_", "");
  	  if(this.value>0){
  	  	$(this).css("background-color", "pink");
  	  }else{
  	  	$(this).css("background-color", "#ffffff");
  	  }
  	  
  	  var total=0;
  	  for(var i = 1;i<=12;i++){
  	  	var pcs = parseFloat($("#m"+i+"_"+barcode).val());if ( isNaN(pcs)){pcs = 0;}
  	  	  	total = total + pcs;
  	  }
  	  	if(total==0){total="";}
  		$("#total_"+barcode).html(total);

  		var month = ids.slice(1,3);

  		var data = "&barcode="+barcode;
  			data = data + "&month="+month.replace("_", "");
  			data = data + "&year="+$("#year").html();
  			data = data + "&value="+this.value;
  			data = data + "&department="+$("#department").val();
  		$.ajax({
  		type: "POST",
      	url: "budget_department_mysql.php",
      	data: "submit=update_barcode"+data,
      	cache: false,
            success: function(result)
        {
            	//alert(result);
                //  var obj = jQuery.parseJSON(result);      
                // $.each(obj, function(key, val) {
                //   if(val["status"]=="true"){
                //     alert(val["msg"]);
                //      window.location='hire_fix_print.php?row_id='+$("#row_id").val();

                //   }else{
                //     alert(val["msg"]);
                //   }
                // });
            },
        });
});
});

 function print_page(){
 	var year = $("#year").html();
 		year = parseFloat(year)-543;
 	var department = $("#department").val();
 	window.open('budget_department_print.php?year='+year+'&department='+department);

 	$("input").css("border","0px solid #000000");
 	$("input").css("background-color", "#ffffff");
 	$("img").hide();
 	window.print();
 	$("input").css("border","1px solid #606060");

 	$("img").show();
 	
 }



function return_data(){

	$("input").css("background-color", "#ffffff");
	$("input").val("");
	$("div").html("");

var	data = "&year="+$("#year").html();
	data = data + "&department="+$("#department").val();
	  $.ajax({
  		type: "POST",
      	url: "budget_department_mysql.php",
      	data: "submit=return_data"+data,
      	cache: false,
            success: function(result)
        {

                 var obj = jQuery.parseJSON(result);      
                 $.each(obj, function(key, val) {
                 	if(val["m1"]>0){$("#m1_"+val["barcode"]).val(val["m1"]);$("#m1_"+val["barcode"]).css("background-color", "pink"); }
                 	if(val["m2"]>0){$("#m2_"+val["barcode"]).val(val["m2"]);$("#m2_"+val["barcode"]).css("background-color", "pink");}
                 	if(val["m3"]>0){$("#m3_"+val["barcode"]).val(val["m3"]);$("#m3_"+val["barcode"]).css("background-color", "pink");}
                 	if(val["m4"]>0){$("#m4_"+val["barcode"]).val(val["m4"]);$("#m4_"+val["barcode"]).css("background-color", "pink");}
                 	if(val["m5"]>0){$("#m5_"+val["barcode"]).val(val["m5"]);$("#m5_"+val["barcode"]).css("background-color", "pink");}
                 	if(val["m6"]>0){$("#m6_"+val["barcode"]).val(val["m6"]);$("#m6_"+val["barcode"]).css("background-color", "pink");}
                 	if(val["m7"]>0){$("#m7_"+val["barcode"]).val(val["m7"]);$("#m7_"+val["barcode"]).css("background-color", "pink");}
                 	if(val["m8"]>0){$("#m8_"+val["barcode"]).val(val["m8"]);$("#m8_"+val["barcode"]).css("background-color", "pink");}
                 	if(val["m9"]>0){$("#m9_"+val["barcode"]).val(val["m9"]);$("#m9_"+val["barcode"]).css("background-color", "pink");}
                 	if(val["m10"]>0){$("#m10_"+val["barcode"]).val(val["m10"]);$("#m10_"+val["barcode"]).css("background-color", "pink");}
                 	if(val["m11"]>0){$("#m11_"+val["barcode"]).val(val["m11"]);$("#m11_"+val["barcode"]).css("background-color", "pink");}
                 	if(val["m12"]>0){$("#m12_"+val["barcode"]).val(val["m12"]);$("#m12_"+val["barcode"]).css("background-color", "pink");}
                 	if(val["total"]>0){$("#total_"+val["barcode"]).html(val["total"]);}
                 });
            },
        });
}

return_data();
</script>