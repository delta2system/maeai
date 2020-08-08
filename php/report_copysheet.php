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
     .bt_cancel{
      display: block;
      padding:2px 5px;
      border-radius: 2px;
      color:#ffffff;
      font-family: tahoma;
      background-color: #ff6666;
     }
    .bt_cancel:hover{
      background-color: #ff4d4d;
      cursor: pointer;
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

    function cal(){
        var a = parseFloat($("input[name=meter_start]").val().replace(",",""));
                if ( isNaN(a)){a = 0;}
        var b = parseFloat($("input[name=meter_end]").val().replace(",",""));
                if ( isNaN(b)){b = 0;}

                $("input[name=total]").val(addCommas(b-a));
    }
  </script>
</head>
<body>
  <img id="img_print" src="../images/menu/Printer.png" style="position:fixed;width:50px;right:10px;top:5px;cursor: pointer;" onclick="print_review('detail')">

  <div id="detail">
<table id="table_detail" style="width:21cm;margin:0px auto;">
  <thead>
    <tr><td colspan="15" style="text-align: center;">รายงานสรุปยอดโรเนียวประจำเดือน</td></tr>
    <tr><td colspan="15" style="text-align: center;">หน่วยงาน : งานพัสดุโรงพยาบาลแม่อาย อ.แม่อาย จ.เชียงใหม่</td></tr>
  	<tr><td colspan="15" style="text-align: center;font-size: 18px;font-weight: bold;"> ประจำเดือน 
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
  	 <tr>
        <td class="topbar" style="height:30px;border:1px solid #909090;text-align: center;">ลำดับ</td>
        <td class="topbar" style="height:30px;border:1px solid #909090;text-align: center;">แผนก</td>
        <td class="topbar" style="height:30px;border:1px solid #909090;text-align: center;">จำนวนแผ่น</td>
        
    <!-- <td class="topbar" style="border:1px solid #909090;">อัพเดทล่าสุด</td> -->
  </thead>
  <tbody>
<!-- <tr>
  <td class='border_bt' style="height:30px;padding-left: 10px;"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" ></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" ></td> -->


  </tbody>
  <tfoot>
    <td colspan="2" style="text-align: right;font-weight: bold;border-bottom: 1px solid #909090;">รวมทั้งหมด</td>
    <td style="text-align: right;font-weight: bold;padding-right: 10px;border-bottom: 1px solid #909090;" id="total_copy"></td>
  </tfoot>
</table>
</div>

<div id="copysheet" style="margin-top: 100px;">
  <table id="copy_sheet" style="width:21cm;margin:0px auto;">
    <thead>
    <td class="topbar" colspan="5" style="text-align: center;border:1px solid #909090;">การโรเนียวของแผนกต่างๆ ประจำเดือน <span id="month2"></span></td>
    <tr><td class="topbar" style="border:1px solid #909090;">ว.ด.ป.</td>
    <td class="topbar" style="border:1px solid #909090;">แผนก</td>
    <td class="topbar" style="border:1px solid #909090;">มิเตอร์เริ่ม</td>
    <td class="topbar" style="border:1px solid #909090;">มิเตอร์เสร็จ</td>
    <td class="topbar" style="border:1px solid #909090;">รวมจำนวน</td>
    </thead>
    <tbody>
      
    </tbody>
    <tfoot>
      <td><input type="date" name="dateday" style='width:90%;font-size: 15px;' onchange="year_thai(this)" value="<?=(date("Y")+543).date("-m-d")?>"></td>
      <td><select name="department" style="font-size: 16px;width:100%" >
        <option></option>
        <?
    $sql = "SELECT * from department where group_location = '1' ORDER By row_id  ASC";
    $result = mysql_query($sql);
    while ($dep = mysql_fetch_array($result) ) {
        print "<option value='$dep[code]'>$dep[name]</option>";
    }
        ?>
          </select>
      </td>
      <td><input type="text" name="meter_start" style='width:100%;text-align:center;' onkeyup="cal()"></td>
      <td><input type="text" name="meter_end" style='width:100%;text-align:center;' onkeyup="cal()"></td>
      <td><input type="text" name="total" style='text-align:center;width:100%;'></td>
      <tr><td colspan="5" style="text-align: right;">
        <button style="font-size: 17px;" onclick="data_save()">บันทึก</button>
        <button style="font-size: 17px;">ยกเลิก</button>
      </td>
    </tfoot>
  </table>
</div>
<!-- 
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
</div> -->

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

   var thmonth = new Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฏาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

  $("#month2").html(thmonth[parseFloat(m)]+" "+y);
  // $("#month3").html(thmonth[m]+" "+y);
  return_month();

  $.ajax({ 
                url: "copysheet_mysql.php" ,
                type: "POST",
                data: 'submit=return_data&m='+m+'&y='+y,
            })
            .success(function(result) { 
              $("#table_detail tbody tr").remove();
                var obj = jQuery.parseJSON(result);
                var t = 0;
        if(obj != ''){
          $.each(obj, function(key, val) {
                            t++;

    var tr = "<tr>";
        tr = tr + "<td class='border_bt' style='text-align:center;'>"+t+"</td>";
        tr = tr + "<td class='border_bt' style='text-align: center;'>"+val["department_name"]+"</td>";
        tr = tr + "<td class='border_bt' style='text-align: center;'>"+addCommas(val["sum(total)"])+"</td>";
        tr = tr + "</tr>";

      $('#table_detail > tbody:last').append(tr);
      $('#total_copy').html(addCommas(val["total_copy"])+' แผ่น');

                          });
        }else{
        $('#total_copy').html('0 แผ่น');   
        }
                    });
            }


return_data(<?PHP echo date("m");?>,<?PHP echo date("Y")+543;?>);

function return_dataall(){

  var m = $("select[name=month]").val();
  var y = $("select[name=year]").val();

  return_data(m,y);

}

function data_save(){
  var data = "&dateday="+$("input[name=dateday]").val();
      data = data + "&department="+$("select[name=department]").val();
      data = data + "&meter_start="+$("input[name=meter_start]").val();
      data = data + "&meter_end="+$("input[name=meter_end]").val();
      data = data + "&total="+$("input[name=total]").val();

  $.ajax({ 
                url: "copysheet_mysql.php" ,
                type: "POST",
                data: 'submit=save_data'+data,
            })
            .success(function(result) { 
             // alert(result);
      return_dataall();
              
      $("input[name=dateday]").val("");
      $("select[name=department]").val("");
      $("input[name=meter_start]").val("");
      $("input[name=meter_end]").val("");
      $("input[name=total]").val("");
        });



}

function return_month(){

  var m = $("select[name=month]").val();
  var y = $("select[name=year]").val();

    $.ajax({ 
                url: "copysheet_mysql.php" ,
                type: "POST",
                data: 'submit=return_month&m='+m+'&y='+y,
            })
            .success(function(result) { 
              $("#copy_sheet tbody tr").remove();
                var obj = jQuery.parseJSON(result);
              
        if(obj != ''){
          $.each(obj, function(key, val) {
                            

    var tr = "<tr>";
        tr = tr + "<td class='border_bt' style='text-align:center;'><input type='date' value='"+val["dateday"]+"' style='border:0px solid #000000;font-size:15px;'></td>";
        tr = tr + "<td class='border_bt' style='text-align: center;'>"+val["department_name"]+"</td>";
        tr = tr + "<td class='border_bt' style='text-align: center;'>"+val["meter_start"]+"</td>";
        tr = tr + "<td class='border_bt' style='text-align: center;'>"+val["meter_end"]+"</td>";
        tr = tr + "<td class='border_bt' style='text-align: center;'>"+val["total"]+"</td>";
        tr = tr + "<td><span class='bt_cancel' onclick=\"cancel_t('"+val["row_id"]+"')\">x</span></td>";
        tr = tr + "</tr>";

      $('#copy_sheet > tbody:last').append(tr);


                          });
        }
});
          }

          function cancel_t(rd){

            var r = confirm("คุณต้องการลบรานการนี้ใช่หรือไม่");
            if(r== true){
            $.ajax({ 
                url: "copysheet_mysql.php" ,
                type: "POST",
                data: 'submit=del_data&row_id='+rd,
            })
            .success(function(result) { 
             // alert(result);
      return_dataall();
              
      $("input[name=dateday]").val("");
      $("select[name=department]").val("");
      $("input[name=meter_start]").val("");
      $("input[name=meter_end]").val("");
      $("input[name=total]").val("");
        });

}
          }
</script>