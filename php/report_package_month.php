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
  	<tr><td colspan="15" style="text-align: center;font-size: 18px;font-weight: bold;"> รายงานสรุปยอดเบิกจ่ายพัสดุ ประจำเดือน 
      <select name="month" style="font-size: 18px;font-weight: bold;border:0px solid #000000;" onchange="return_dataall()">
      <?
      for ($i=1; $i <= 12 ; $i++) { 
      print "<option value='".str_pad($i, 2,'0',STR_PAD_LEFT)."'>".thai_month(str_pad($i, 2,'0',STR_PAD_LEFT))."</option>";
      }
      ?>
    </select>
      พ.ศ.&nbsp;
      <select name="year" style="font-size: 18px;font-weight: bold;border:0px solid #000000;" onchange="return_dataall()">
    <?for ($i=(date("Y")+543); $i > (date("Y")+538) ; $i--) { 
      print "<option>$i</option>";
    }
    ?>
    </td>
  	 <tr>
        <td class="topbar" style="height:30px;border:1px solid #909090;text-align: center;">ลำดับ</td>
        <td class="topbar" style="height:30px;border:1px solid #909090;text-align: center;">หน่วยเบิก</td>
        <td class="topbar" style="height:30px;border:1px solid #909090;text-align: center;">รวมเบิกได้</td>
        <td class="topbar" style="height:30px;border:1px solid #909090;text-align: center;">รวมเป็นเงิน</td>
        <td class="topbar" style="height:30px;border:1px solid #909090;text-align: center;">หมายเหตุ</td>
        
    <!-- <td class="topbar" style="border:1px solid #909090;">อัพเดทล่าสุด</td> -->
  </thead>
  <tbody>
<!-- <tr>
  <td class='border_bt' style="height:30px;padding-left: 10px;"></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" ></td>
  <td class='border_bt' style="text-align: right;padding-right: 10px;" ></td> -->


  </tbody>

<!-- <tfoot>
     <tr>
        <td class="border_bt" style="height:30px;"></td>
        <td class="border_bt">&nbsp;&nbsp;รวมจ่ายพัสดุ</td>
        <td class="border_bt" style='text-align: right;'></td>
        <td class="border_bt" style="text-align: right;" id="pcs_total"></td>
        <td class="border_bt"></td></tr>
       <tr>
        <td class="border_bt" style="height:30px;"></td>
        <td class="border_bt">&nbsp;&nbsp;รวมคงคลังพัสดุ</td>
        <td class="border_bt" style='text-align: right;'></td>
        <td class="border_bt" style="text-align: right;"><input type="text" name="pcs_warehouse"  style="width:100px;height:30px;font-size: 15px;text-align: center;" onkeyup="update_pcstotal(this.value)" onblur="$(this).val(addCommas($(this).val()));"></td>
        <td class="border_bt"></td></tr>
       <tr>
        <td class="border_bt" style="height:30px;"></td>
        <td class="border_bt">&nbsp;&nbsp;ค่าเฉลี่ยการเบิก</td>
        <td class="border_bt" style='text-align: right;'></td>
        <td class="border_bt" style='text-align: right;'></td>
        <td class="border_bt"></td></tr>
       <tr>
        <td class="border_bt" style="height:30px;"></td>
        <td class="border_bt">&nbsp;&nbsp;อัตราเบิกพัสดุ</td>
        <td class="border_bt" style='text-align: right;'></td>
        <td class="border_bt" style='text-align: right;' id="pcs_pertition"></td>
        <td class="border_bt"></td></tr>
       <tr>
        <td class="border_bt" style="height:30px;"></td>
        <td class="border_bt">&nbsp;&nbsp;อัตราจ่ายไม่ได้</td>
        <td class="border_bt" style='text-align: right;'></td>
        <td class="border_bt" style='text-align: right;'></td>
        <td class="border_bt"></td></tr>
       <tr>
        <td class="border_bt" style="height:30px;"></td>
        <td class="border_bt">&nbsp;&nbsp;จำนวนถ่ายเอกสาร</td>
        <td class="border_bt" style='text-align: right;' id="copysheet_pcs"></td>
        <td class="border_bt" style='text-align: right;' id="copysheet_total"></td>
        <td class="border_bt" style='text-align: right;'></td></tr>
       <tr>
        <td class="border_bt" style="height:30px;"></td>
        <td class="border_bt">&nbsp;&nbsp;ค่าจ่ายน้ำมัน</td>
        <td class="border_bt" style='text-align: right;'></td>
        <td class="border_bt"  style='text-align: right;' id="fule_total"></td>
        <td class="border_bt"></td></tr>
</tfoot> -->
</table>
</div>




</body>
</html>
<script type="text/javascript">
    function print_review(el){
    $("#img_print").hide();
    // var restorepage = document.body.innerHTML;
    // var printcontent = document.getElementById(el).innerHTML;
    // document.body.innerHTML = printcontent;
    $("input[name=pcs_warehouse]").css({"border":"0px solid #a0a0a0"});
    window.print();
    $("input[name=pcs_warehouse]").css({"border":"1px solid #a0a0a0"});
    // document.body.innerHTML = restorepage;
    $("#img_print").show();
}

function return_data(m,y){
  $("select[name=month]").val(m);
  $("select[name=year]").val(y);

   var thmonth = new Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฏาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

  $("#month2").html(thmonth[m]+" "+y);
  // $("#month3").html(thmonth[m]+" "+y);

  $.ajax({ 
                url: "report_month_mysql.php" ,
                type: "POST",
                data: 'submit=return_data&m='+m+'&y='+y,
            })
            .success(function(result) { 
              $("#table_detail tbody tr").remove();
                var obj = jQuery.parseJSON(result);
                var t = 0;
                var sum_wa = 0;
        if(obj != ''){
          $.each(obj, function(key, val) {
                            t++;

    var tr = "<tr>";
        tr = tr + "<td class='border_bt' style='text-align:center;height:30px;'>"+t+"</td>";
        tr = tr + "<td class='border_bt' style='text-align: left;'>&nbsp;&nbsp;"+val["customer_name"]+"</td>";
        tr = tr + "<td class='border_bt' style='text-align: center;'>"+addCommas(val["sum(pcs)"])+"</td>";
        tr = tr + "<td class='border_bt' style='text-align: right;'>"+addCommas(val["sum(pcs*price)"])+"&nbsp;&nbsp;</td>";
        tr = tr + "<td class='border_bt' style='text-align:center;'></td>";
        tr = tr + "</tr>";

      $('#table_detail > tbody:last').append(tr);
     sum_wa = val["sum_warehouse"];
                          });



        }
              tfoot();

      $('#pcs_total').html(addCommas(sum_wa)+"&nbsp;&nbsp;");


                    });

            

            }


return_data(<?PHP echo date("m");?>,<?PHP echo date("Y")+543;?>);

function return_dataall(){

  var m = $("select[name=month]").val();
  var y = $("select[name=year]").val();

  return_data(m,y);

}

function copy_sheet(){

  var m = $("select[name=month]").val();
  var y = $("select[name=year]").val();

  $.ajax({ 
                url: "report_month_mysql.php" ,
                type: "POST",
                data: 'submit=return_copysheet&m='+m+'&y='+y,
            })
            .success(function(result) { 

              $('#copysheet_pcs').html(addCommas(result)+" แผ่น&nbsp;&nbsp;");
              $('#copysheet_total').html(addCommas((result*0.1).toFixed(2))+" &nbsp;&nbsp;");

            });

}

function fule_total(){

  var m = $("select[name=month]").val();
  var y = $("select[name=year]").val();

  $.ajax({ 
                url: "report_month_mysql.php" ,
                type: "POST",
                data: 'submit=return_fule&m='+m+'&y='+y,
            })
            .success(function(result) { 
            // alert(result);
              //$('#copysheet_pcs').html(addCommas(result)+" แผ่น&nbsp;&nbsp;");
              $('#fule_total').html(addCommas(result)+" &nbsp;&nbsp;");

            });

}

function tfoot(){
      var td = "<tr>";
        td = td + "<td class='border_bt' style='height:30px;'></td>";
        td = td + "<td class='border_bt'>&nbsp;&nbsp;รวมจ่ายพัสดุ</td>";
        td = td + "<td class='border_bt' style='text-align: right;'></td>";
        td = td + "<td class='border_bt' style='text-align: right;' id='pcs_total'></td>";
        td = td + "<td class='border_bt'></td></tr>";
        td = td + "<tr>";
        td = td + "<td class='border_bt' style='height:30px;'></td>";
        td = td + "<td class='border_bt'>&nbsp;&nbsp;รวมคงคลังพัสดุ</td>";
        td = td + "<td class='border_bt' style='text-align: right;'></td>";
        td = td + "<td class='border_bt' style='text-align: right;'><input type='text' name='pcs_warehouse'  style='width:100px;height:30px;font-size: 15px;text-align: center;' onkeyup=\"update_pcstotal(this.value)\" onblur=\"$(this).val(addCommas($(this).val()));\"></td>";
        td = td + "<td class='border_bt'></td></tr>";
       td = td + "<tr>";
        td = td + "<td class='border_bt' style='height:30px;'></td>";
        td = td + "<td class='border_bt'>&nbsp;&nbsp;ค่าเฉลี่ยการเบิก</td>";
        td = td + "<td class='border_bt' style='text-align: right;'></td>";
        td = td + "<td class='border_bt' style='text-align: right;'></td>";
        td = td + "<td class='border_bt'></td></tr>";
       td = td + "<tr>";
        td = td + "<td class='border_bt' style='height:30px;'></td>";
        td = td + "<td class='border_bt'>&nbsp;&nbsp;อัตราเบิกพัสดุ</td>";
        td = td + "<td class='border_bt' style='text-align: right;'></td>";
        td = td + "<td class='border_bt' style='text-align: right;' id='pcs_pertition'></td>";
        td = td + "<td class='border_bt'></td></tr>";
       td = td + "<tr>";
        td = td + "<td class='border_bt' style='height:30px;'></td>";
        td = td + "<td class='border_bt'>&nbsp;&nbsp;อัตราจ่ายไม่ได้</td>";
        td = td + "<td class='border_bt' style='text-align: right;'></td>";
        td = td + "<td class='border_bt' style='text-align: right;'></td>";
        td = td + "<td class='border_bt'></td></tr>";
       td = td + "<tr>";
        td = td + "<td class='border_bt' style='height:30px;'></td>";
        td = td + "<td class='border_bt'>&nbsp;&nbsp;จำนวนถ่ายเอกสาร</td>";
        td = td + "<td class='border_bt' style='text-align: right;' id='copysheet_pcs'></td>";
        td = td + "<td class='border_bt' style='text-align: right;' id='copysheet_total'></td>";
        td = td + "<td class='border_bt' style='text-align: right;'></td></tr>";
       td = td + "<tr>";
        td = td + "<td class='border_bt' style='height:30px;'></td>";
        td = td + "<td class='border_bt'>&nbsp;&nbsp;ค่าจ่ายน้ำมัน</td>";
        td = td + "<td class='border_bt' style='text-align: right;'></td>";
        td = td + "<td class='border_bt'  style='text-align: right;' id='fule_total'></td>";
        td = td + "<td class='border_bt'></td></tr>";

        $('#table_detail > tbody:last').append(td);


  copy_sheet();
  fule_total();
  return_pcstotal();
}

function cal_tx(){
  var a = parseFloat($("#pcs_total").html().replace(",",""));
  if ( isNaN(a)){a= 0;}
  var b = $("input[name=pcs_warehouse]").val();
      b = parseFloat(b.replace(",",""));
  if ( isNaN(b)){b = 0;}

 $("#pcs_pertition").html((b/a).toFixed(2)+" &nbsp;&nbsp;");
}

function return_pcstotal(){

  var m = $("select[name=month]").val();
  var y = $("select[name=year]").val();

  $.ajax({ 
                url: "report_month_mysql.php" ,
                type: "POST",
                data: 'submit=return_pcstotal&m='+m+'&y='+y,
            })
            .success(function(result) { 
           if(result){
             $("input[name=pcs_warehouse]").val(result);
             $("input[name=pcs_warehouse]").css({"border":"0px solid #e0e0e0"});
             cal_tx();
           }else{
            $("input[name=pcs_warehouse]").val("");
            $("input[name=pcs_warehouse]").css({"border":"1px solid #e0e0e0"});
            $("#pcs_pertition").html("");
           }

            });
}




function update_pcstotal(tx){


  var m = $("select[name=month]").val();
  var y = $("select[name=year]").val();

  $.ajax({ 
                url: "report_month_mysql.php" ,
                type: "POST",
                data: 'submit=update_pcstotal&m='+m+'&y='+y+'&data='+tx,
            })
            .success(function(result) { 
              cal_tx();

            });
}

</script>