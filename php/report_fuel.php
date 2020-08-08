<?
session_start();
include("connect.inc");
if($_SESSION["xusername"]==""){
  echo("<script>alert('กรุณาทำการล็อกอินก่อนใช้งาน');window.location='login.php'</script>");
}

function thai_month($mm) {
switch($mm) {
case "01": $str = "มกราคม"; break;
case "02": $str = "กุมภาพันธ์"; break;
case "03": $str = "มีนาคม"; break;
case "04": $str = "เมษายน"; break;
case "05": $str = "พฤษภาคม"; break;
case "06": $str = "มิถุนายน"; break;
case "07": $str = "กรกฏาคม"; break;
case "08": $str = "สิงหาคม"; break;
case "09": $str = "กันยายน"; break;
case "10": $str = "ตุลาคม"; break;
case "11": $str = "พฤศจิกายน"; break;
case "12": $str = "ธันวาคม"; break;
}
return $str;
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

    function year_thai(th){
         var str = th.value;
         var res = parseFloat(str.substring(0, 4))+543;
         th.value = res+str.substring(4, 10);
    }
  </script>
</head>
<body>
  <img id="img_print" src="../images/menu/Printer.png" style="position:fixed;width:50px;right:10px;top:5px;cursor: pointer;" onclick="print_review('detail')">

  <div id="detail">
<table style="width:21cm;margin:0px auto;">
  <thead>
  	<tr><td colspan="15" style="text-align: center;font-size: 18px;font-weight: bold;">รายงานน้ำมันสำรอง ประจำเดือน 
      <select name="month" style="font-size: 17px;border:0px solid #000000;" onchange="return_dataall()">
      <?
      for ($i=1; $i <= 12 ; $i++) { 
      print "<option value='".str_pad($i, 2,'0',STR_PAD_LEFT)."'>".thai_month(str_pad($i, 2,'0',STR_PAD_LEFT))."</option>";
      }
      ?>
    </select>
      พ.ศ.&nbsp;
      <select name="year" style="font-size: 17px;border:0px solid #000000;" onchange="return_dataall()">
    <?for ($i=(date("Y")+543); $i > (date("Y")+538) ; $i--) { 
      print "<option>$i</option>";
    }
    ?>
    </td>
  	 <tr><td class="topbar" style="border:1px solid #909090;" rowspan="2">รายการ</td>
        <td colspan="2" class="topbar" style="border:1px solid #909090;text-align: center;">ยอดยกมา</td>
        <td colspan="2" class="topbar" style="border:1px solid #909090;text-align: center;">จำนวนรับ</td>
        <td colspan="2" class="topbar" style="border:1px solid #909090;text-align: center;">จำนวนจ่าย</td>
        <td colspan="2" class="topbar" style="border:1px solid #909090;text-align: center;">จำนวนคงเหลือ</td>
    <tr><td class="topbar" style="border:1px solid #909090;text-align: center;">จำนวน</td><td class="topbar" style="border:1px solid #909090;text-align: center;">จำนวนเงิน</td>
        <td class="topbar" style="border:1px solid #909090;text-align: center;">จำนวน</td><td class="topbar" style="border:1px solid #909090;text-align: center;">จำนวนเงิน</td>
        <td class="topbar" style="border:1px solid #909090;text-align: center;">จำนวน</td><td class="topbar" style="border:1px solid #909090;text-align: center;">จำนวนเงิน</td>
        <td class="topbar" style="border:1px solid #909090;text-align: center;">จำนวน</td><td class="topbar" style="border:1px solid #909090;text-align: center;">จำนวนเงิน</td>
    <!-- <td class="topbar" style="border:1px solid #909090;">อัพเดทล่าสุด</td> -->
  </thead>
  <tbody>
<tr><td class='border_bt' style="height:40px;padding-left: 10px;">น้ำมัน 91</td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="pcs_91"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="total_91"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="revpcs_91"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="revtotal_91"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="olppcs_91"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="olptotal_91"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="lastpcs_91"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="lasttotal_91"></td>
<tr><td class='border_bt' style="height:40px;padding-left: 10px;">น้ำมัน 95</td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="pcs_95"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="total_95"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="revpcs_95"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="revtotal_95"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="olppcs_95"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="olptotal_95"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="lastpcs_95"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="lasttotal_95"></td>
  <tr><td class='border_bt' style="height:40px;padding-left: 10px;">น้ำมัน ดีเซล</td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="pcs_diesel"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="total_diesel"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="revpcs_diesel"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="revtotal_diesel"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="olppcs_diesel"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="olptotal_diesel"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="lastpcs_diesel"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="lasttotal_diesel"></td>
    <tr><td class='border_bt' style="height:40px;padding-left: 10px;">น้ำมัน เบรค</td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="pcs_brake"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="total_brake"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="revpcs_brake"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="revtotal_brake"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="olppcs_brake"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="olptotal_brake"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="lastpcs_brake"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="lasttotal_brake"></td>
      <tr><td class='border_bt' style="height:40px;padding-left: 10px;">น้ำมัน เครื่อง</td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="pcs_engine"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="total_engine"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="revpcs_engine"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="revtotal_engine"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="olppcs_engine"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="olptotal_engine"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="lastpcs_engine"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="lasttotal_engine"></td>
        <tr><td class='border_bt' style="height:40px;padding-left: 10px;">น้ำมัน ผสม</td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="pcs_oilmix"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="total_oilmix"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="revpcs_oilmix"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="revtotal_oilmix"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="olppcs_oilmix"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="olptotal_oilmix"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="lastpcs_oilmix"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="lasttotal_oilmix"></td>
          <tr><td class='border_bt' style="height:40px;padding-left: 10px;">น้ำกลั่น</td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="pcs_water"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="total_water"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="revpcs_water"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="revtotal_water"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="olppcs_water"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="olptotal_water"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="lastpcs_water"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" id="lasttotal_water"></td>
  <tr><td colspan="5"></td>
    <td colspan="4" style="text-align: center;height:30px;">(ลงชื่อ).........................................................</td>
  <tr><td colspan="5"></td>
    <td colspan="4" style="text-align: center;height:30px;">(นายบัญญัติ รัตนัง)</td>
  <tr><td colspan="5"></td>
    <td colspan="4" style="text-align: center;height:30px;">ตำแหน่ง พนักงานบริการเอกสารทั่วไป บ.2</td>
  </tbody>
</table>
</div>

<div id="recive_fuel" style="margin-top: 100px;">
  <table id="rev_data" style="width:21cm;margin:0px auto;">
    <thead>
    <td class="topbar" colspan="5" style="text-align: center;border:1px solid #909090;">ยอดรับน้ำมันประจำเดือน <span id="month2"></span></td>
    <tr><td class="topbar" style="border:1px solid #909090;">ว.ด.ป.</td>
    <td class="topbar" style="border:1px solid #909090;">ใบสั่งซื้อ</td>
    <td class="topbar" style="border:1px solid #909090;">ชนิดน้ำมัน</td>
    <td class="topbar" style="border:1px solid #909090;">จำนวน</td>
    <td class="topbar" style="border:1px solid #909090;">จำนวนเงิน</td>
    </thead>
    <tbody>
      
    </tbody>
    <tfoot>
      <td><input type="date" name="dateday" style='width:90%;' onchange="year_thai(this)"></td>
      <td><input type="text" name="theorder" style='width:100%;'></td>
      <td><select name="fuel" style="font-size: 16px;width:100%" >
        <option value="91">น้ำมัน 91</option>
        <option value="95">น้ำมัน 95</option>
        <option value="diesel">น้ำมัน ดีเซล</option>
        <option value="brake">น้ำมัน เบรค</option>
        <option value="engine">น้ำมัน เครื่อง</option>
        <option value="oilmix">น้ำมัน ผสม</option>
        <option value="water">น้ำกลั่น</option>
      </td>
      <td><input type="text" name="pcs" style='width:100%;'></td>
      <td><input type="text" name="total" style='width:100%;'></td>
      <tr><td colspan="5" style="text-align: right;">
        <button style="font-size: 17px;" onclick="rev_save()">บันทึก</button>
        <button style="font-size: 17px;">ยกเลิก</button>
      </td>
    </tfoot>
  </table>
</div>

<div id="fuel" style="margin-top: 100px;">
  <table id="olp_data" style="width:21cm;margin:0px auto;">
    <thead>
    <td class="topbar" colspan="5" style="text-align: center;border:1px solid #909090;">ยอดจ่ายน้ำมันประจำเดือน <span id="month3"></span></td>
    <tr><td class="topbar" style="border:1px solid #909090;" >ว.ด.ป.</td>
    <td class="topbar" style="border:1px solid #909090;">ใบจ่าย</td>
    <td class="topbar" style="border:1px solid #909090;">ชนิดน้ำมัน</td>
    <td class="topbar" style="border:1px solid #909090;">จำนวน</td>
    <td class="topbar" style="border:1px solid #909090;">จำนวนเงิน</td>
    </thead>
    <tbody>
      
    </tbody>
    <tfoot>
      <td><input type="date" name="dateday2"  style='width:90%;' onchange="year_thai(this)"></td>
      <td><input type="text" name="theorder2" style='width:100%;'></td>
      <td><select name="fuel2" style="font-size: 16px;width:100%;">
        <option value="91">น้ำมัน 91</option>
        <option value="95">น้ำมัน 95</option>
        <option value="diesel">น้ำมัน ดีเซล</option>
        <option value="brake">น้ำมัน เบรค</option>
        <option value="engine">น้ำมัน เครื่อง</option>
        <option value="oilmix">น้ำมัน ผสม</option>
        <option value="water">น้ำกลั่น</option>
      </td>
      <td><input type="text" name="pcs2" style='width:100%;'></td>
      <td><input type="text" name="total2" style='width:100%;'></td>
      <tr><td colspan="5" style="text-align: right;">
        <button style="font-size: 17px;"  onclick="olp_save()">บันทึก</button>
        <button style="font-size: 17px;">ยกเลิก</button>
      </td>
    </tfoot>
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

function return_data(m,y){
  $("select[name=month]").val(m);
  $("select[name=year]").val(y);
  rev_data();
  olp_data();
    var thmonth = new Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฏาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

  $("#month2").html(thmonth[m]+" "+y);
  $("#month3").html(thmonth[m]+" "+y);

  $.ajax({ 
                url: "fuel_mysql.php" ,
                type: "POST",
                data: 'submit=return_data&m='+m+'&y='+y,
            })
            .success(function(result) { 
              //alert(result);
                var obj = jQuery.parseJSON(result);
                    if(obj != '')
                          $.each(obj, function(key, val) {
                            $("#pcs_diesel").html(addCommas(val["pcs_diesel"]));
                            $("#total_diesel").html(addCommas(val["total_diesel"]));
                            $("#pcs_91").html(addCommas(val["pcs_91"]));
                            $("#total_91").html(addCommas(val["total_91"]));
                            $("#pcs_95").html(addCommas(val["pcs_95"]));
                            $("#total_95").html(addCommas(val["total_95"]));
                            $("#pcs_brake").html(addCommas(val["pcs_brake"]));
                            $("#total_brake").html(addCommas(val["total_brake"]));
                            $("#pcs_engine").html(addCommas(val["pcs_engine"]));
                            $("#total_engine").html(addCommas(val["total_engine"]));
                            $("#pcs_oilmix").html(addCommas(val["pcs_oilmix"]));
                            $("#total_oilmix").html(addCommas(val["total_oilmix"]));
                            $("#pcs_water").html(addCommas(val["pcs_water"]));
                            $("#total_water").html(addCommas(val["total_water"]));

                            $("#revpcs_diesel").html(addCommas(val["revpcs_diesel"]));
                            $("#revtotal_diesel").html(addCommas(val["revtotal_diesel"]));
                            $("#revpcs_91").html(addCommas(val["revpcs_91"]));
                            $("#revtotal_91").html(addCommas(val["revtotal_91"]));
                            $("#revpcs_95").html(addCommas(val["revpcs_95"]));
                            $("#revtotal_95").html(addCommas(val["revtotal_95"]));
                            $("#revpcs_brake").html(addCommas(val["revpcs_brake"]));
                            $("#revtotal_brake").html(addCommas(val["revtotal_brake"]));
                            $("#revpcs_engine").html(addCommas(val["revpcs_engine"]));
                            $("#revtotal_engine").html(addCommas(val["revtotal_engine"]));
                            $("#revpcs_oilmix").html(addCommas(val["revpcs_oilmix"]));
                            $("#revtotal_oilmix").html(addCommas(val["revtotal_oilmix"]));
                            $("#revpcs_water").html(addCommas(val["revpcs_water"]));
                            $("#revtotal_water").html(addCommas(val["revtotal_water"]));

                            $("#olppcs_diesel").html(addCommas(val["olppcs_diesel"]));
                            $("#olptotal_diesel").html(addCommas(val["olptotal_diesel"]));
                            $("#olppcs_91").html(addCommas(val["olppcs_91"]));
                            $("#olptotal_91").html(addCommas(val["olptotal_91"]));
                            $("#olppcs_95").html(addCommas(val["olppcs_95"]));
                            $("#olptotal_95").html(addCommas(val["olptotal_95"]));
                            $("#olppcs_brake").html(addCommas(val["olppcs_brake"]));
                            $("#olptotal_brake").html(addCommas(val["olptotal_brake"]));
                            $("#olppcs_engine").html(addCommas(val["olppcs_engine"]));
                            $("#olptotal_engine").html(addCommas(val["olptotal_engine"]));
                            $("#olppcs_oilmix").html(addCommas(val["olppcs_oilmix"]));
                            $("#olptotal_oilmix").html(addCommas(val["olptotal_oilmix"]));
                            $("#olppcs_water").html(addCommas(val["olppcs_water"]));
                            $("#olptotal_water").html(addCommas(val["olptotal_water"]));

                            $("#lastpcs_diesel").html(addCommas(val["lastpcs_diesel"]));
                            $("#lasttotal_diesel").html(addCommas(val["lasttotal_diesel"]));
                            $("#lastpcs_91").html(addCommas(val["lastpcs_91"]));
                            $("#lasttotal_91").html(addCommas(val["lasttotal_91"]));
                            $("#lastpcs_95").html(addCommas(val["lastpcs_95"]));
                            $("#lasttotal_95").html(addCommas(val["lasttotal_95"]));
                            $("#lastpcs_brake").html(addCommas(val["lastpcs_brake"]));
                            $("#lasttotal_brake").html(addCommas(val["lasttotal_brake"]));
                            $("#lastpcs_engine").html(addCommas(val["lastpcs_engine"]));
                            $("#lasttotal_engine").html(addCommas(val["lasttotal_engine"]));
                            $("#lastpcs_oilmix").html(addCommas(val["lastpcs_oilmix"]));
                            $("#lasttotal_oilmix").html(addCommas(val["lasttotal_oilmix"]));
                            $("#lastpcs_water").html(addCommas(val["lastpcs_water"]));
                            $("#lasttotal_water").html(addCommas(val["lasttotal_water"]));
                          });
                    });
            }


return_data(<?PHP echo date("m");?>,<?PHP echo date("Y")+543;?>);

function return_dataall(){

  var m = $("select[name=month]").val();
  var y = $("select[name=year]").val();

  return_data(m,y);

}

function rev_data(){
  var m = $("select[name=month]").val();
  var y = $("select[name=year]").val();

  $.ajax({ 
                url: "fuel_mysql.php" ,
                type: "POST",
                data: 'submit=return_revdata&m='+m+'&y='+y,
            })
            .success(function(result) { 
              //alert(result);
              $("#rev_data tbody tr").remove();
                var obj = jQuery.parseJSON(result);
                    if(obj != '')
                          $.each(obj, function(key, val) {
    var tr = "<tr>";
        tr = tr + "<td class='border_bt' ><input type='date' value='"+val["dateday"]+"' style='border:0px solid #e0e0e0;font-size:14px;text-align:center;' readonly ></td>";
        tr = tr + "<td class='border_bt' style='text-align: center;'>"+val["theorder"]+"</td>";
        tr = tr + "<td class='border_bt' style='text-align: center;'>"+val["fuel_name"]+"</td>";
        tr = tr + "<td class='border_bt' style='text-align: right;padding-right: 10px;'>"+addCommas(val["pcs"])+"</td>";
        tr = tr + "<td class='border_bt' style='text-align: right;padding-right: 10px;'>"+addCommas(val["total"])+"</td>";
        tr = tr + "</tr>";
      $('#rev_data > tbody:last').append(tr);

                          });
                      });
}

function olp_data(){
  var m = $("select[name=month]").val();
  var y = $("select[name=year]").val();

  $.ajax({ 
                url: "fuel_mysql.php" ,
                type: "POST",
                data: 'submit=return_olpdata&m='+m+'&y='+y,
            })
            .success(function(result) { 
              //alert(result);
              $("#olp_data tbody tr").remove();
                var obj = jQuery.parseJSON(result);
                    if(obj != '')
                          $.each(obj, function(key, val) {
    var tr = "<tr>";
        tr = tr + "<td class='border_bt' ><input type='date' value='"+val["dateday"]+"' style='border:0px solid #e0e0e0;font-size:14px;text-align:center;' readonly ></td>";
        tr = tr + "<td class='border_bt' style='text-align: center;'>"+val["theorder"]+"</td>";
        tr = tr + "<td class='border_bt' style='text-align: center;'>"+val["fuel_name"]+"</td>";
        tr = tr + "<td class='border_bt' style='text-align: right;padding-right: 10px;'>"+addCommas(val["pcs"])+"</td>";
        tr = tr + "<td class='border_bt' style='text-align: right;padding-right: 10px;'>"+addCommas(val["total"])+"</td>";
        tr = tr + "</tr>";
      $('#olp_data > tbody:last').append(tr);

                          });
                      });
}

function rev_save(){
  var data = "&dateday="+$("input[name=dateday]").val();
      data = data + "&theorder="+$("input[name=theorder]").val();
      data = data + "&fuel="+$("select[name=fuel]").val();
      data = data + "&pcs="+$("input[name=pcs]").val();
      data = data + "&total="+$("input[name=total]").val();
        $.ajax({ 
                url: "fuel_mysql.php" ,
                type: "POST",
                data: 'submit=addrev'+data,
            })
            .success(function(result) { 
      $("input[name=dateday]").val("");
      $("input[name=theorder]").val("");
      $("select[name=fuel]").val("");
      $("input[name=pcs]").val("");
      $("input[name=total]").val("");
              return_dataall();
              rev_data();
            });
}

function olp_save(){
  var data = "&dateday="+$("input[name=dateday2]").val();
      data = data + "&theorder="+$("input[name=theorder2]").val();
      data = data + "&fuel="+$("select[name=fuel2]").val();
      data = data + "&pcs="+$("input[name=pcs2]").val();
      data = data + "&total="+$("input[name=total2]").val();
        $.ajax({ 
                url: "fuel_mysql.php" ,
                type: "POST",
                data: 'submit=addolp'+data,
            })
            .success(function(result) { 
      $("input[name=dateday2]").val("");
      $("input[name=theorder2]").val("");
      $("select[name=fuel2]").val("");
      $("input[name=pcs2]").val("");
      $("input[name=total2]").val("");
              return_dataall();
              olp_data();
            });
}
</script>
