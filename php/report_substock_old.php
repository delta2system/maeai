<?
session_start();
include("connect.inc");
if($_SESSION["xusername"]==""){
  echo("<script>alert('กรุณาทำการล็อกอินก่อนใช้งาน');window.location='login.php'</script>");
}

$sql = "SELECT tbl_value from tbl_company where row_id = '1'  limit 1  ";
list($company) = Mysql_fetch_row(Mysql_Query($sql));

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

function commaa($str){
  if($str>0 && $str!=""){
    return number_format($str);
  }else{
    return '0';
  }
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
    select{
      font-size: 16px;
      padding:5px;
      border:1px solid #c0c0c0;
      border-radius: 5px;
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
          @media print {
    .page_breck {page-break-after: always;}
     pre, blockquote {page-break-inside: avoid;}
}
	</style>
</head>
<body>
<!--   <img id="img_print" src="../images/menu/Printer.png" style="position:fixed;width:50px;right:10px;top:5px;cursor: pointer;" onclick="print_review('detail')"> -->
  <?if(empty($_POST["search"])){?>
  <form name="B1" method="post" action="<?=$PHP_SELF?>">
  <table>
    <td colspan="2" style="text-align: center;">รายงานการเบิกจ่ายพัสดุ</td>
    <tr>
    <td>วันที่
    <select name='d_start'>
      <?
      for ($i=1; $i <=31 ; $i++) { 
        print "<option>".str_pad($i, 2,"0",STR_PAD_LEFT)."</option>";
      }
      ?>
    </select>
    <select name='m_start'>
       <?
      for ($i=1; $i <12 ; $i++) { 
        print "<option value='".str_pad($i, 2,"0",STR_PAD_LEFT)."'>".thai_month(str_pad($i, 2,"0",STR_PAD_LEFT))."</option>";
      }
      ?>     
    </select>
    <select name='y_start'>
      <?
        print "<option>".(date("Y")+542)."</option>";
        print "<option>".(date("Y")+541)."</option>";
        print "<option>".(date("Y")+540)."</option>";
        print "<option>".(date("Y")+539)."</option>";

      ?>
    </select></td>
    <td>
      ถึง
    <select name='d_end'>
      <?
      for ($i=1; $i <=31 ; $i++) { 
        print "<option>".str_pad($i, 2,"0",STR_PAD_LEFT)."</option>";
      }
      ?>
    </select>
    <select name='m_end'>
       <?
      for ($i=1; $i <12 ; $i++) { 
        print "<option value='".str_pad($i, 2,"0",STR_PAD_LEFT)."'>".thai_month(str_pad($i, 2,"0",STR_PAD_LEFT))."</option>";
      }
      ?>     
    </select>
    <select name='y_end'>
      <?
        print "<option>".(date("Y")+543)."</option>";
        print "<option>".(date("Y")+542)."</option>";
        print "<option>".(date("Y")+541)."</option>";
        print "<option>".(date("Y")+540)."</option>";
        print "<option>".(date("Y")+539)."</option>";

      ?>
    </select>
    </td>
    <tr>
      <td colspan="2" style="text-align: center"><input type="submit" name="search" value="Search" style="padding: 7px 15px;font-size:18px;"></td>
  </table>
</form>

  <?}else if(isset($_POST["search"])){

function group_name($str){
$sqls = "SELECT code,detail from group_type ";
$result = mysql_query($sqls);
while ($row = mysql_fetch_array($result) ) {
  $sr[$row["code"]]=$row["detail"];
}
return $sr[$str];
}

$date_start = $_POST["y_start"]."-".$_POST["m_start"]."-".$_POST["d_start"];
$date_end = $_POST["y_end"]."-".$_POST["m_end"]."-".$_POST["d_end"];


$ser[0]="01";
$ser[1]="06";
$ser[2]="A0";
$ser[3]="02";
$ser[4]="B0";
$ser[5]="05";
$total_final=array();
for($g=0;$g<=5;$g++){

$sql="SELECT stock_product.barcode,stock_product.detail,stock_product.unit,stock_product.group_type FROM stock_product INNER JOIN bill ON stock_product.barcode=bill.barcode WHERE  (bill.pcs > 0 OR stock_product.pcs > 0 ) AND stock_product.group_type = '".$ser[$g]."' AND bill.dateday BETWEEN '$date_start' AND '$date_end' GROUP by bill.barcode ORDER By bill.group_type ASC";
//$sql="SELECT barcode,detail,unit,group_type FROM stock_product WHERE pcs > 0 GROUP by barcode ORDER By group_type ASC";
//SELECT Student_Fname, Student_Lname FROM Student WHERE Age=   (SELECT Age FROM Student  WHERE Student_Fname='เยาวภา');
// $num = mysql_num_rows(mysql_query($sql));
$result = mysql_query($sql);
$arrBar=array();
$acchk=array("");
$i=0;
while ($dar = mysql_fetch_assoc($result) ) {
  $arrCol=array();
  array_push($acchk,trim($dar[barcode]));
  $arrCol["barcode"]=$dar[barcode];
  $arrCol["detail"]=$dar[detail];
  $arrCol["unit"]=$dar[unit];
  $arrCol["group_type"]=$dar[group_type];
  array_push($arrBar, $arrCol);
    $i++;
}

$sqle="SELECT barcode,detail,unit,group_type FROM stock_product WHERE group_type = '".$ser[$g]."' AND pcs > '0' GROUP by barcode ";
$resulte = mysql_query($sqle);
while ($daw = mysql_fetch_assoc($resulte) ) {
  $ts=array_search($daw[barcode],$acchk);
  if(empty($ts)){
  $arrCol=array();
  $arrCol["barcode"]=$daw[barcode];
  $arrCol["detail"]=$daw[detail];
  $arrCol["unit"]=$daw[unit];
  $arrCol["group_type"]=$daw[group_type];
  array_push($arrBar,$arrCol);
    $i++;
}
} 

$page=ceil(count($arrBar)/20);

// $star_limit = 0;
// $end_limit = 19;  


$end_line=0;

 while ( $end_line< count($arrBar)) {
  $p++;
    ?>
  <div id="detail">
<table style="width:29.5cm;margin:0px auto;" class="page_breck">
  <thead>
  	<tr><td colspan="11" style="text-align: center;font-size: 22px;">รายงานการตรวจสอบการรับ-จ่ายพัสดุ ประจำปี <?=$_POST["y_end"]?> (ตั้งแต่ <?=$_POST["d_start"]." ".thai_month($_POST["m_start"])." ".$_POST["y_start"]?> - <?=$_POST["d_end"]." ".thai_month($_POST["m_end"])." ".$_POST["y_end"]?>)</td>
      <tr><td></td><td colspan="9"  style="text-align: center;padding:10px;"><?=$company?> </td><td style="text-align: right;"><div style="margin-top:-50px;">หน้าที่ <?=$p?></div></td>
  	 <tr><td class="topbar" style="width:60px;border:1px solid #909090;">ลำดับ</td>
     <td class="topbar" style="width:80px;border:1px solid #909090;">รหัส</td>
    <td class="topbar" style="border:1px solid #909090;">รายการ</td>
		<td class="topbar" style="width:150px;border:1px solid #909090;">กลุ่มสินค้า</td>
		<td class="topbar" style="border:1px solid #909090;">ราคา</td>
		<td class="topbar" style="border:1px solid #909090;">หน่วยนับ</td>
    <td class="topbar" style="border:1px solid #909090;">ยกยอด</td>
    <td class="topbar" style="border:1px solid #909090;">รับ</td>
     <td class="topbar" style="border:1px solid #909090;">จ่าย</td>
    <td class="topbar" style="border:1px solid #909090;">คงเหลือ</td>
		 <td class="topbar" style="border:1px solid #909090;">รวม(บาท)</td>
    <!-- <td class="topbar" style="border:1px solid #909090;">อัพเดทล่าสุด</td> -->
  </thead>
  <tbody>
    <?

$pcs_dx=0;$stock_dx=0;$total_dx=0;
// $result = mysql_query($sql);
// while ($data = mysql_fetch_assoc($result) ) {
$tr=$end_line+19;
for($j=$end_line;$j<=$tr;$j++){
$end_line++;

if($arrBar[$j][barcode]){

$sql_r = "SELECT pcs from stock_product_es where barcode = '".$arrBar[$j][barcode]."' AND dateday = '".substr($_POST["y_start"],0,4)."-09-30' ";
list($pcs_stock_old) = Mysql_fetch_row(Mysql_Query($sql_r));

if(empty($pcs_stock_old)){
  $pcs_stock_old=0;
}

$sql_b = "SELECT sum(pcs) from bill where nobill_system like 'INV%'  AND barcode = '".$arrBar[$j][barcode]."' AND dateday BETWEEN '$date_start' AND '$date_end' GROUP by barcode   ";
list($inv_pcs) = Mysql_fetch_row(Mysql_Query($sql_b));

$sql_c = "SELECT sum(pcs) from bill where nobill_system like 'OWH%'  AND barcode = '".$arrBar[$j][barcode]."'  AND dateday BETWEEN '$date_start' AND '$date_end' GROUP by barcode   ";
list($owh_pcs) = Mysql_fetch_row(Mysql_Query($sql_c));

$sql_px = "SELECT pcs,price_in FROM stock_product WHERE barcode = '".$arrBar[$j][barcode]."'";
$result_px = mysql_query($sql_px);
$total_m_barcode=0;$pcsx=0;$r=0;$pricex=0;

while($cas = mysql_fetch_array($result_px)){
$r++;
$total_m_barcode=$total_m_barcode+($cas[pcs]*$cas[price_in]);
$pcsx=$pcsx+$cas[pcs];
$pricex=$pricex+$cas[price_in];
}


if($pricex>0){ $price_in=$pricex/$r; }else{ $price_in="";}
          
          $k++;
          $pcs_old=($pcsx+$inv_pcs)-$owh_pcs;
         if($pcs_old<0){
          $inv_pcs=$inv_pcs+substr($pcs_old,1);
          $pcs_old="0";
         }

         $pcs_a=($pcs_old+$inv_pcs)-$owh_pcs;

          if($pcs_a!=$pcsx){
       //    $pcs_b = $pcs_a-$pcsx;
           if($pcs_a > $pcsx){
            $owh_pcs=$owh_pcs+($pcs_a-$pcsx);
           }else{
            $inv_pcs=$inv_pcs+($pcsx-$pcs_a);
           }
       //    $inv_pcs=$inv_pcs+$pcs_b;
       //    }else{
       //    $owh_pcs=$owh_pcs+substr($pcs_b,1);
       //   }
       }


                  print "<tr ><td style='text-align:center;' class='border_bt'>$k</td>";
                  print "<td style='text-align:center;' class='border_bt'>".$arrBar[$j][barcode]."</td>";
                  print "<td class='border_bt'>&nbsp;&nbsp;".$arrBar[$j][detail]."</td>";
                  print "<td style='text-align:center;' class='border_bt'>".group_name($arrBar[$j][group_type])."</td>";
                  print "<td style='text-align:right;' class='border_bt'>".commaa($price_in)."&nbsp;</td>";
                  print "<td style='text-align:center;' class='border_bt'>".$arrBar[$j][unit]."</td>";
                  print "<td style='text-align:center;' class='border_bt'>".$pcs_old."</td>";
                  print "<td style='text-align:center;' class='border_bt'>".commaa($inv_pcs)."</td>";
                  print "<td style='text-align:center;' class='border_bt'>".commaa($owh_pcs)."</td>";
                  print "<td style='text-align:center;' class='border_bt'>".commaa($pcsx)."</td>";
                  
                  print "<td style='text-align:right;' class='border_bt'>".number_format($total_m_barcode,2)." ฿&nbsp;</td>";
                  //print "<td style='text-align:center;' class='border_bt'>$data[lastupdate]</td>";
                  print"</tr>";
                  array_push($total_final, $total_m_barcode);

                  $pcsls=$pcsls+$pcsx;
                  $pcs_dx=$pcs_dx+$owh_pcs;
                  $stock_dx= $stock_dx+$pcsx;
                  $total_dx=$total_dx+$total_m_barcode;

 if($arrBar[$j][barcode]){
// $strSQL = "INSERT INTO stock_product_es SET "; 
// $strSQL .="dateday = '2562-09-30' ";
// $strSQL .=",group_type = '".$arrBar[$j][group_type]."' ";
// $strSQL .=",barcode = '".$arrBar[$j][barcode]."' ";
// $strSQL .=",pcs = '".$pcs_old."' ";
// $strSQL .=",pcs_stock = '".$pcsx."' ";
// $strSQL .=",price = '".$price_in."' ";
// $strSQL .=",officer = 'admin' ";
// $objQuery = mysql_query($strSQL) or die(mysql_error());

// $strSQL = "UPDATE stock_product_es SET ";
// $strSQL .="pcs_stock = '".$pcs_old."' ";
// $strSQL .="WHERE barcode = '".$arrBar[$j][barcode]."' AND dateday = '2561-09-30' ";
// $objQuery = mysql_query($strSQL);    

 }


}else{
                  print "<tr ><td style='text-align:center;height:20px;' class='border_bt'></td>";
                  print "<td style='text-align:center;' class='border_bt'></td>";
                  print "<td class='border_bt'></td>";
                  print "<td style='text-align:center;' class='border_bt'></td>";
                  print "<td style='text-align:right;' class='border_bt'></td>";
                  print "<td style='text-align:center;' class='border_bt'></td>";
                  print "<td style='text-align:center;' class='border_bt'></td>";
                  print "<td style='text-align:center;' class='border_bt'></td>";
                  print "<td style='text-align:center;' class='border_bt'></td>";
                  print "<td style='text-align:center;' class='border_bt'></td>";
                  print "<td style='text-align:right;' class='border_bt'></td>";
}
}

print "<tr><td colspan='8' style='text-align:right;'>รวมจ่าย&nbsp;&nbsp;</td>"
      ."<td style='text-align:center;' class='border_bt'>".number_format($pcs_dx)."</td>"
      ."<td style='text-align:center;' class='border_bt'>".number_format($stock_dx)."</td>"
      ."<td style='text-align:right;' class='border_bt'>".number_format($total_dx,2)." ฿&nbsp;</td></tr>";
      if($g==5){
      print "<tr><td colspan='10' style='text-align:right;'>รวมเป็นเงินทั้งสิ้น&nbsp;&nbsp;</td>";
      print "<td style='text-align:right;border-bottom:1px double #909090;'>".number_format(array_sum($total_final),2)." ฿&nbsp</td></tr>";
      }
print "<tr><td colspan='11' style='height:50px;'></td></tr>";
print "<tr><td colspan='11' style='padding:10px;text-align:center;'> <div style='width:100%;'>"
      ."<div style='float:left;text-align:center;width:33%;'>ลงชื่อ.........................ประธานกรรมการ<br> (นางจันทนา  นุเทพสุ)<br>พยาบาลวิชาชีพชำนาญการ</div>"
      ."<div style='float:left;text-align:center;width:33%;'>ลงชื่อ.........................กรรมการ<br>  (นางจิราพร  นวลดี)<br>พยาบาลวิชาชีพชำนาญการ</div>"
      ."<div style='float:left;text-align:center;width:33%;'>ลงชื่อ.........................กรรมการ<br>  (นางสาวชญานิษฐ์  ชัยชนะ)<br>นักวิชาการเงินและบัญชี</div>"
      ."</div> </td></tr>";
// if($end_limit>=$num){
//    $end_line=1020;
// }else{
//   $end_line++;
// $star_limit = $end_limit;
// $end_limit = $end_limit+20;
// }
}

}

// $sql = "SELECT * FROM stock_product GROUP By barcode ORDER By barcode ASC";
// $result = mysql_query($sql);
// $total_money=array();
// while($data = mysql_fetch_array($result)){

// $sql_b = "SELECT sum(pcs) from bill where nobill_system like 'INV%'  AND barcode = '$data[barcode]' AND group_type='$data[group_type]' AND dateday BETWEEN '$date_start' AND '$date_end' GROUP by barcode   ";
// list($inv_pcs) = Mysql_fetch_row(Mysql_Query($sql_b));

// $sql_c = "SELECT sum(pcs) from bill where nobill_system like 'OWH%'  AND barcode = '$data[barcode]' AND group_type='$data[group_type]' AND dateday BETWEEN '$date_start' AND '$date_end' GROUP by barcode   ";
// list($owh_pcs) = Mysql_fetch_row(Mysql_Query($sql_c));

// $sql_r = "SELECT pcs from stock_product_es where barcode = '$data[barcode]' AND dateday = '".substr($_POST["y_start"],0,4)."-09-30' ";
// list($pcs_stock_old) = Mysql_fetch_row(Mysql_Query($sql_r));

// if(empty($pcs_stock_old)){
//   $pcs_stock_old=0;
// }


//           if($inv_pcs > 0 || $owh_pcs > 0 || $data[pcs] > 0){
//           $i++;
//           $sql_a = "SELECT detail from group_type where code = '$data[group_type]'  limit 1  ";
//           list($group_name) = Mysql_fetch_row(Mysql_Query($sql_a));

//                   print "<tr ><td style='text-align:center;' class='border_bt'>$i</td>";
//                   print "<td style='text-align:center;' class='border_bt'>$data[barcode]</td>";
//                   print "<td class='border_bt'>&nbsp;&nbsp;$data[detail]</td>";
//                   print "<td style='text-align:center;' class='border_bt'>$group_name</td>";
//                   print "<td style='text-align:right;' class='border_bt'>$data[price_in]&nbsp;</td>";
//                   print "<td style='text-align:center;' class='border_bt'>$data[unit]</td>";
//                   print "<td style='text-align:center;' class='border_bt'>".$pcs_stock_old."</td>";
//                   print "<td style='text-align:center;' class='border_bt'>".$inv_pcs."</td>";
//                   print "<td style='text-align:center;' class='border_bt'>".$owh_pcs."</td>";
//                   print "<td style='text-align:center;' class='border_bt'>".(($pcs_stock_old+$inv_pcs)-$owh_pcs)."</td>";
                  
//                   print "<td style='text-align:right;' class='border_bt'>".number_format(($data[price_in]*$data[pcs]),2)." ฿&nbsp;</td>";
//                   //print "<td style='text-align:center;' class='border_bt'>$data[lastupdate]</td>";
//                   print"</tr>";
//                   array_push($total_money, ($data[price_in]*$data[pcs]));
// }
// }
// $sql = "SELECT sum(pcs) from stock_product WHERE pcs > '0'  ";
// list($pcsls) = Mysql_fetch_row(Mysql_Query($sql));

// print "<tr><td colspan='10' style='text-align:right;'>จำนวนพัสดุคงเหลือ ".number_format($pcsls)." ชิ้น &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รวมจำนวนเงิน</td>";
// //print "<td colspan='10' style='text-align:right;'></td>";
// print "<td style='text-align:right;'>".number_format(array_sum($total_final),2)." ฿&nbsp</td>";
    ?>
  </tbody>
</table>
</div>
<?}?>
</body>
</html>
<script type="text/javascript">


function getmonth(){
    var d = new Date();
    var n = d.getMonth();
    n=n+1
    if(n<'10'){
      n = '0'+n;
    }
    $("select[name=m_start]").val(n);
    $("select[name=m_end]").val(n);
    $("select[name=d_end]").val("31");
}
getmonth();
</script>
