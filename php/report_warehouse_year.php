<?
session_start();
include("connect.inc");
if($_SESSION["xusername"]==""){
  echo("<script>alert('กรุณาทำการล็อกอินก่อนใช้งาน');window.location='login.php'</script>");
}
if(empty($_GET["year"])){
  echo ("<script>window.location='report_warehouse_year.php?year=".(date("Y")+543)."'</script>");
}

function thai_month($mm) {
switch($mm) {
case '01' : $month = "ม.ค."; break;
case '02' : $month = "ก.พ.";break;
case '03' : $month = "มี.ค.";break;
case '04' : $month = "เม.ย.";break;
case '05' : $month = "พ.ค";break;
case '06' : $month = "มิ.ย.";break;
case '07' : $month = "กใค.";break;
case '08' : $month = "ส.ค.";break;
case '09' : $month = "ก.ย.";break;
case '10' : $month = "ต.ค.";break;
case '11' : $month = "พ.ย.";break;
case '12' : $month = "ธ.ค.";break;
}
return $month;
}

function decimon($str){
  if($str!="" || $str!=0){
    $str= number_format($str,2);
  }else{
    $str = "";
  }
  return $str;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title> รายงานการเบิกจ่ายพัสดุ</title>
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
      font-size: 12px;
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
     input[type=text]{
      width:60px;
      border:0px solid #a0a0a0;
      font-size: 12px;
      text-align: right;

     }
	</style>
  <script type="text/javascript">
    
    function addCommas(nStr)
      {
        if(nStr!=null){
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
        }else{
          return nStr;
        }
      }


  </script>
</head>
<body>
  <img id="img_print" src="../images/menu/Printer.png" style="position:fixed;width:50px;right:10px;top:5px;cursor: pointer;" onclick="print_review('detail')">

  <div id="detail">
<table style="width:29.5cm;margin:0px auto;">
  <thead>
  	<tr><td colspan="15" style="text-align: center;font-size: 18px;font-weight: bold;">ยอดพัสดุที่จ่ายและคงเหลือประจำปีงบประมาณ&nbsp;<?=$_GET["year"]?></td>
  	 <tr><td class="topbar" style="width:60px;border:1px solid #909090;">ลำดับ</td>
     <td class="topbar" style="width:200px;border:1px solid #909090;">หน่วยเบิก</td>
    <td class="topbar" style="border:1px solid #909090;">ต.ค. <?=substr($_GET["year"],2,2)-1?></td>
		<td class="topbar" style="border:1px solid #909090;">พ.ย. <?=substr($_GET["year"],2,2)-1?></td>
		<td class="topbar" style="border:1px solid #909090;">ธ.ค. <?=substr($_GET["year"],2,2)-1?></td>
    <td class="topbar" style="border:1px solid #909090;">ม.ค. <?=substr($_GET["year"],2,2)?></td>
    <td class="topbar" style="border:1px solid #909090;">ก.พ. <?=substr($_GET["year"],2,2)?></td>
     <td class="topbar" style="border:1px solid #909090;">มี.ค. <?=substr($_GET["year"],2,2)?></td>
    <td class="topbar" style="border:1px solid #909090;">เม.ย. <?=substr($_GET["year"],2,2)?></td>
    <td class="topbar" style="border:1px solid #909090;">พ.ค. <?=substr($_GET["year"],2,2)?></td>
    <td class="topbar" style="border:1px solid #909090;">มิ.ย. <?=substr($_GET["year"],2,2)?></td>
    <td class="topbar" style="border:1px solid #909090;">ก.ค. <?=substr($_GET["year"],2,2)?></td>
    <td class="topbar" style="border:1px solid #909090;">ส.ค. <?=substr($_GET["year"],2,2)?></td>
    <td class="topbar" style="border:1px solid #909090;">ก.ย. <?=substr($_GET["year"],2,2)?></td>
		 <td class="topbar" style="border:1px solid #909090;">รวมเป็น</td>
    <!-- <td class="topbar" style="border:1px solid #909090;">อัพเดทล่าสุด</td> -->
  </thead>
  <tbody>
    <?
$sum_out[1]=array();
$sum_out[2]=array();
$sum_out[3]=array();
$sum_out[4]=array();
$sum_out[5]=array();
$sum_out[6]=array();
$sum_out[7]=array();
$sum_out[8]=array();
$sum_out[9]=array();
$sum_out[10]=array();
$sum_out[11]=array();
$sum_out[12]=array();
$sql = "SELECT * FROM department WHERE group_location = '1' OR group_location = '2' ORDER By code ASC";
$result = mysql_query($sql);
$total_money=array();
while($data = mysql_fetch_array($result)){

          $i++;
                  $sum_total=array();
                  print "<tr ><td style='text-align:center;' class='border_bt'>$i</td>";
                  print "<td style='text-align:left;' class='border_bt'>$data[name]</td>";

                  for($m=10;$m<=12;$m++){
                    $year=$_GET["year"]-1;
                    $sql_c = "SELECT sum(pcs*price) from bill where nobill_system like 'OWH%'  AND customer_id = '$data[code]' AND dateday like '".$year."-$m-%'    ";
                  list($owh_pcs) = Mysql_fetch_row(Mysql_Query($sql_c));
                  print "<td style='text-align:right;padding-right:5px;' class='border_bt'>".decimon($owh_pcs)."</td>";
                  array_push($sum_total,$owh_pcs);
                  array_push($sum_out[$m],$owh_pcs);

                  }
                  for($m=1;$m<=9;$m++){
                    $year=$_GET["year"];

                    $sql_c = "SELECT sum(pcs*price) from bill where nobill_system like 'OWH%'  AND customer_id = '$data[code]' AND dateday like '".$year."-".str_pad($m,2,'0',STR_PAD_LEFT)."-%'    ";
                  list($owh_pcs) = Mysql_fetch_row(Mysql_Query($sql_c));
                  print "<td style='text-align:right;padding-right:5px;' class='border_bt'>".decimon($owh_pcs)."</td>";
                  array_push($sum_total,$owh_pcs);
                  array_push($sum_out[$m],$owh_pcs);
                  }

                  print "<td style='text-align:right;padding-right:5px;' class='border_bt'>".decimon(array_sum($sum_total))."</td>";


//                   print "<td class='border_bt'>&nbsp;&nbsp;$data[detail]</td>";
//                   print "<td style='text-align:center;' class='border_bt'>$group_name</td>";
//                   print "<td style='text-align:right;' class='border_bt'>$data[price_in]&nbsp;</td>";
//                   print "<td style='text-align:center;' class='border_bt'>$data[unit]</td>";
//                   print "<td style='text-align:center;' class='border_bt'>".(($data[pcs]+$owh_pcs)-$inv_pcs)."</td>";
//                   print "<td style='text-align:center;' class='border_bt'>".$inv_pcs."</td>";
//                   print "<td style='text-align:center;' class='border_bt'>".$owh_pcs."</td>";
//                   print "<td style='text-align:center;' class='border_bt'>".$data[pcs]."</td>";
                  
//                   print "<td style='text-align:right;' class='border_bt'>".number_format(($data[price_in]*$data[pcs]),2)." ฿&nbsp;</td>";
//                   //print "<td style='text-align:center;' class='border_bt'>$data[lastupdate]</td>";
//                   print"</tr>";
//                   array_push($total_money, ($data[price_in]*$data[pcs]));
// }
 }
// $sql = "SELECT sum(pcs) from stock_product WHERE pcs > '0'  ";
// list($pcsls) = Mysql_fetch_row(Mysql_Query($sql));

// print "<td colspan='10' style='text-align:right;'>จำนวนพัสดุคงเหลือ ".number_format($pcsls)." ชิ้น &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รวมจำนวนเงิน</td>";
// print "<td colspan='10' style='text-align:right;'></td>";
// print "<td style='text-align:right;'>".number_format(array_sum($total_money),2)." ฿&nbsp</td>";
 print "<tr><td style='height:30px;' colspan='15'></td>";
 print "<tr>".
       "<td class='border_bt'></td><td class='border_bt'>รายจ่ายพัสดุ</td>";
for ($i=10; $i <=12 ; $i++) { 
print "<td style='text-align:right;padding-right:5px;' class='border_bt'>".decimon(array_sum($sum_out[$i]))."</td>";
}
for ($i=1; $i <=9 ; $i++) { 
print "<td style='text-align:right;padding-right:5px;' class='border_bt'>".decimon(array_sum($sum_out[$i]))."</td>";
}
print "<td class='border_bt' style='text-align:right;'>".decimon(array_sum($sum_out))."&nbsp;&nbsp;</td>";
 print "<tr>".
       "<td class='border_bt'></td><td class='border_bt'>รวมคงคลัง</td>";
for ($i=10; $i <=12 ; $i++) { 
   $sql_a = "SELECT value FROM data_pcstotal where year = '".($_GET["year"]-1)."' AND month = '".$i."' AND title_code = '1'";
  list($value) = Mysql_fetch_row(Mysql_Query($sql_a));
  $total_krong[$i]=$value;
print "<td style='text-align:right;padding-right:5px;' class='border_bt'>".decimon($value)."</td>";
}
for ($i=1; $i <=9 ; $i++) { 
   $sql_a = "SELECT value FROM data_pcstotal where year = '".$_GET["year"]."' AND month = '".str_pad($i,2,'0',STR_PAD_LEFT)."' AND title_code = '1'";
  list($value) = Mysql_fetch_row(Mysql_Query($sql_a));
  $total_krong[$i]=$value;
print "<td style='text-align:right;padding-right:5px;' class='border_bt'>".decimon($value)."</td>";
}
print "<td class='border_bt' style='text-align:right;'>".decimon(array_sum($total_krong))."&nbsp;&nbsp;</td>";


 print "<tr>".
       "<td class='border_bt'></td><td class='border_bt'>คิดค่าเฉลี่ยการเบิก</td>";
       for ($i=0; $i <=12 ; $i++) {
 print "<td class='border_bt'></td>"; 
       }
 print "<tr>".
       "<td class='border_bt'></td><td class='border_bt'>อัตราการยืมพัสดุ</td>";
       for ($i=0; $i <=12 ; $i++) {
 print "<td class='border_bt'></td>"; 
       }
 print "<tr>".
       "<td class='border_bt'></td><td class='border_bt'>อัตราคงคลัง</td>";
       "<td class='border_bt'></td><td class='border_bt'>รวมคงคลัง</td>";
for ($i=10; $i <=12 ; $i++) { 
  
print "<td style='text-align:right;padding-right:5px;' class='border_bt'>".decimon(($total_krong[$i]/array_sum($sum_out[$i])))."</td>";
}
for ($i=1; $i <=9 ; $i++) { 
  if(array_sum($sum_out[$i])>0){
$sums = $total_krong[$i]/array_sum($sum_out[$i]);
if($sums<0){
$sums=decimon($sums);
}
}


print "<td style='text-align:right;padding-right:5px;' class='border_bt'>".$sums."</td>";
}
 print "<td class='border_bt'></td>";
 print "<tr>".
       "<td class='border_bt'></td><td class='border_bt'>จำนวนโรเนียว</td>";
for ($i=10; $i <=12 ; $i++) { 
   $sql_b = "SELECT sum(total) FROM copy_sheet where dateday like '".($_GET["year"]-1)."-$i%'";
  list($value_copy) = Mysql_fetch_row(Mysql_Query($sql_b));
  $copy_v[$i]=$value_copy;
print "<td style='text-align:right;padding-right:5px;' class='border_bt'>".decimon($value_copy)."</td>";
}
for ($i=1; $i <=9 ; $i++) { 
   $sql_b = "SELECT sum(total) FROM copy_sheet where dateday like '".$_GET["year"]."-".str_pad($i,2,'0',STR_PAD_LEFT)."%'";
  list($value_copy) = Mysql_fetch_row(Mysql_Query($sql_b));
  $copy_v[$i]=$value_copy;
print "<td style='text-align:right;padding-right:5px;' class='border_bt'>".decimon($value_copy)."</td>";
}
print "<td class='border_bt' style='text-align:right;'>".decimon(array_sum($copy_v))."&nbsp;&nbsp;</td>";

 print "<tr>".
       "<td class='border_bt'></td><td class='border_bt'>ค่าจ่ายน้ำมันสำรองคลัง</td>";
for ($i=10; $i <=12 ; $i++) { 
   $sql_b = "SELECT sum(total) FROM fuel_tank where dateday like '".($_GET["year"]-1)."-$i%' AND bill like 'OLP%'";
  list($value_fuel) = Mysql_fetch_row(Mysql_Query($sql_b));
  $fuel_v[$i]=$value_fuel;
print "<td style='text-align:right;padding-right:5px;' class='border_bt'>".decimon($value_fuel)."</td>";
}
for ($i=1; $i <=9 ; $i++) { 
   $sql_b = "SELECT sum(total) FROM fuel_tank where dateday like '".$_GET["year"]."-".str_pad($i,2,'0',STR_PAD_LEFT)."%' AND bill like 'OLP%'";
  list($value_fuel) = Mysql_fetch_row(Mysql_Query($sql_b));
  $fuel_v[$i]=$value_fuel;
print "<td style='text-align:right;padding-right:5px;' class='border_bt'>".decimon($value_fuel)."</td>";
}
print "<td class='border_bt' style='text-align:right;'>".decimon(array_sum($fuel_v))."&nbsp;&nbsp;</td>";

 print "<tr>".
       "<td class='border_bt'></td><td class='border_bt'>น้ำมันสำรองคงคลัง</td>";
 print "<td style='text-align:center;' class='border_bt'><input type='text' name='fuelt10' onkeyup=\"fuel_set('10','".($_GET["year"]-1)."',this.value)\" onblur=\"fuel_return('".$_GET["year"]."')\" ></td>";
 print "<td style='text-align:center;' class='border_bt'><input type='text' name='fuelt11' onkeyup=\"fuel_set('11','".($_GET["year"]-1)."',this.value)\" onblur=\"fuel_return('".$_GET["year"]."')\" ></td>";
 print "<td style='text-align:center;' class='border_bt'><input type='text' name='fuelt12' onkeyup=\"fuel_set('12','".($_GET["year"]-1)."',this.value)\" onblur=\"fuel_return('".$_GET["year"]."')\"></td>";
 print "<td style='text-align:center;' class='border_bt'><input type='text' name='fuelt1' onkeyup=\"fuel_set('1','".$_GET["year"]."',this.value)\" onblur=\"fuel_return('".$_GET["year"]."')\"></td>";
 print "<td style='text-align:center;' class='border_bt'><input type='text' name='fuelt2' onkeyup=\"fuel_set('2','".$_GET["year"]."',this.value)\" onblur=\"fuel_return('".$_GET["year"]."')\"></td>";
 print "<td style='text-align:center;' class='border_bt'><input type='text' name='fuelt3' onkeyup=\"fuel_set('3','".$_GET["year"]."',this.value)\" onblur=\"fuel_return('".$_GET["year"]."')\"></td>";
 print "<td style='text-align:center;' class='border_bt'><input type='text' name='fuelt4' onkeyup=\"fuel_set('4','".$_GET["year"]."',this.value)\" onblur=\"fuel_return('".$_GET["year"]."')\"></td>";
 print "<td style='text-align:center;' class='border_bt'><input type='text' name='fuelt5' onkeyup=\"fuel_set('5','".$_GET["year"]."',this.value)\" onblur=\"fuel_return('".$_GET["year"]."')\"></td>";
 print "<td style='text-align:center;' class='border_bt'><input type='text' name='fuelt6' onkeyup=\"fuel_set('6','".$_GET["year"]."',this.value)\" onblur=\"fuel_return('".$_GET["year"]."')\"></td>";
 print "<td style='text-align:center;' class='border_bt'><input type='text' name='fuelt7' onkeyup=\"fuel_set('7','".$_GET["year"]."',this.value)\" onblur=\"fuel_return('".$_GET["year"]."')\"></td>";
 print "<td style='text-align:center;' class='border_bt'><input type='text' name='fuelt8' onkeyup=\"fuel_set('8','".$_GET["year"]."',this.value)\" onblur=\"fuel_return('".$_GET["year"]."')\"></td>";
 print "<td style='text-align:center;' class='border_bt'><input type='text' name='fuelt9' onkeyup=\"fuel_set('9','".$_GET["year"]."',this.value)\" onblur=\"fuel_return('".$_GET["year"]."')\"></td>";
 print "<td style='text-align:right;padding-right:5px' class='border_bt' id='krong_fuel'></td>";
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

// function getmonth(){
//     var d = new Date();
//     var n = d.getMonth();
//     n=n+1
//     if(n<'10'){
//       n = '0'+n;
//     }
//     $("select[name=m_start]").val(n);
//     $("select[name=m_end]").val(n);
//     $("select[name=d_end]").val("31");
// }

function fuel_set(m,y,v){

    $.ajax({ 
                url: "report_month_mysql.php" ,
                type: "POST",
                data: 'submit=fuel_set&m='+m+'&y='+y+'&data='+v,
            })
            .success(function(result) { 


      });


}


      function cal_fuel(){
        $("#krong_fuel").html();
      }

function fuel_return(y){

    $.ajax({ 
                url: "report_month_mysql.php" ,
                type: "POST",
                data: 'submit=fuel_t_return&y='+y,
            })
            .success(function(result) { 

                var obj = jQuery.parseJSON(result);
        if(obj != ''){
          $.each(obj, function(key, val) {

            $("input[name=fuelt10").val(val["fuelt10"]);
            $("input[name=fuelt11").val(val["fuelt11"]);
            $("input[name=fuelt12").val(val["fuelt12"]);
            $("input[name=fuelt1").val(val["fuelt1"]);
            $("input[name=fuelt2").val(val["fuelt2"]);
            $("input[name=fuelt3").val(val["fuelt3"]);
            $("input[name=fuelt4").val(val["fuelt4"]);
            $("input[name=fuelt5").val(val["fuelt5"]);
            $("input[name=fuelt6").val(val["fuelt6"]);
            $("input[name=fuelt7").val(val["fuelt7"]);
            $("input[name=fuelt8").val(val["fuelt8"]);
            $("input[name=fuelt9").val(val["fuelt9"]);
            $("#krong_fuel").html(val["fuelttotal"]);

      });
        }
      });


}
fuel_return(<?PHP echo $_GET["year"];?>);
//getmonth();
</script>
