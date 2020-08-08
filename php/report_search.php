<?
session_start();
include("connect.inc");
if($_SESSION["xusername"]==""){
  echo("<script>alert('กรุณาทำการล็อกอินก่อนใช้งาน');window.location='login.php'</script>");
}
if($_GET["dateday"]){
  $dateday=$_GET["dateday"];
}else{
  $dateday=date("d-m-").(date("Y")+543);
}
unset($_SESSION["d_day"]);
unset($_SESSION["d_department"]);
unset($_SESSION["d_to"]);


?>
<!DOCTYPE html>
<html>
<head>
  <title>..::รายการเบิกสินค้า::..</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script src="../js/jquery-1.8.0.min.js"></script>
   <script type="text/javascript" src="auto/autocomplete.js"></script>
  <link rel="stylesheet" href="auto/autocomplete.css"  type="text/css"/>

  <style type="text/css">
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
      float: left;
      padding:5px 10px;
      border:1px solid #e0e0e0;
      cursor: pointer;
    }
     .button_menu:hover{
      background-color: #e0e0e0;
     }

     .detail_show{
      width:900px;
      border:1px solid #555555;
      overflow-x: hidden;
      overflow-y: auto;
      margin-left:25px;
     }


  </style>
<script type="text/javascript">
  function search1(){
   // window.open("report_department.php?dateday=today=department=")
    var left = (screen.width/2)-(800/2);
    var top = (screen.height/2)-(600/2);
    var v1 = $("#dateday").val();
    var v2 = $("#today").val();
    var v3 = $("#department").val();
    window.open("report_department.php?dateday="+v1+"&today="+v2+"&department="+v3,"_blank","toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=800,height=600");
  }

    function search2(){
   // window.open("report_department.php?dateday=today=department=")
    var left = (screen.width/2)-(800/2);
    var top = (screen.height/2)-(600/2);
    var v1 = $("#barcode").val();
    var v2 = $("#dateday_p").val();
    var v3 = $("#today_p").val();
    if(v1!=""){
    window.open("report_product.php?barcode="+v1+"&dateday="+v2+"&today="+v3,"_blank","toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=800,height=600");
  }
  }

  function sum_search(){
    var r = $("input[name=row_group]").val();
    var id = "";
    var y1 = $("select[name=sum_year]").val();
    var m1 = $("select[name=sum_month]").val();
        var left = (screen.width/2)-(1000/2);
    var top = (screen.height/2)-(600/2);

    for(e=1;e<=r;e++){
      $("#rowgroup"+e).val();
    if(document.getElementById("rowgroup"+e).checked==true){
      id = id + "," + $("#rowgroup"+e).val();
    }
    }

    window.open("report_productsum.php?year="+y1+"&month="+m1+"&data="+id , "_blank" ,"toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=1000,height=600");

    
  }

  function sum_searchall(){
    var data = "&year1="+$("select[name=sum_yearall1]").val();
        data = data +"&month1="+$("select[name=sum_monthall1]").val();
        data = data + "&year2="+$("select[name=sum_yearall2]").val();
        data = data +"&month2="+$("select[name=sum_monthall2]").val();
        var r = $("input[name=row_group3]").val();
        var left = (screen.width/2)-(1000/2);
        var top = (screen.height/2)-(600/2);
        var id = "";
    for(e=1;e<=r;e++){
      $("#rowgroup2"+e).val();
    if(document.getElementById("rowgroup2"+e).checked==true){
      id = id + "," + $("#rowgroup2"+e).val();
    }
    }
          window.open("report_productsum5.php?"+data+"&data="+id , "_blank" ,"toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=1000,height=600");
                    window.open("report_productsum6.php?"+data+"&data="+id , "_blank" ,"toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=1000,height=600");
                              window.open("report_productsum7.php?"+data+"&data="+id , "_blank" ,"toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=1000,height=600");
  }

    function sum_search2(){
    var r = $("input[name=row_group2]").val();
    var id = "";
    var y1 = $("select[name=sum_year2]").val();
    var m1 = $("select[name=sum_month2]").val();
    //     var left = (screen.width/2)-(1000/2);
    // var top = (screen.height/2)-(600/2);

    for(e=1;e<=r;e++){
      $("#rowgroup2"+e).val();
    if(document.getElementById("rowgroup2"+e).checked==true){
      id = id + "," + $("#rowgroup2"+e).val();
    }
    }

    window.open("report_productsum2.php?year="+y1+"&month="+m1+"&data="+id , "_blank" ,"toolbar=no,scrollbars=yes,resizable=yes,width=1000,height=600");

    window.open("report_productsum3.php?year="+y1+"&month="+m1+"&data="+id , "_blank" ,"toolbar=no,scrollbars=yes,resizable=yes,width=1000,height=600");
    
    window.open("report_productsum4.php?year="+y1+"&month="+m1+"&data="+id , "_blank" ,"toolbar=no,scrollbars=yes,resizable=yes,width=1000,height=600");
  }
</script>
</head>
<body>
  <center>


<fieldset style="width:870px;margin-left: 25px;border:1px solid #E65100;background-color: #FFF3E0;">
<legend style="color:#E65100;">รายการเบิกพัสดุ </legend>
<div style="width: 50%;float: left;">
<table width="850px" >
 <!-- <tr><td><input type="checkbox" name="all" checked> ทั้งหมด</td> -->
 <tr><td>ตั้งแต่วันที่ <input type="text" name="dateday" id="dateday" value="<?="01-10-".(date("Y")+542)?>"></td>
  <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ถึงวันที่ <input type="text" name="today" id="today" value="<?=date("d-m-").(date("Y")+543)?>"></td>
    <tr><td>หน่วยงาน
      <select name="department" id="department">
        <option value="">ทั้งหมด</option>
    <?
  $sql = "SELECT * from department  ORDER By code  ASC";
  $result = mysql_query($sql);
  while ($tx = mysql_fetch_array($result) ) {
    print "<option value='$tx[code]'>$tx[name]</option>";
  }
    ?>
      </select>
    </td>
    <tr><td><button class="button_menu" onclick="search1()">ค้นหา</button></td>
 </table>
</div>
<div style="float: right;width:49%;">
  <table>
  <tr><td>รหัส/พัสดุ <input type="text" name="barcode" id="barcode" style="width:80px;" >
    <input type='text' name='detail' id='detail' style="width:200px;"></td>
   <tr><td>ตั้งแต่วันที่ <input type="text" name="dateday_p" id="dateday_p" value="<?="01-10-".(date("Y")+542)?>"></td>
  <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ถึงวันที่ <input type="text" name="today_p" id="today_p" value="<?=date("d-m-").(date("Y")+543)?>"></td>
    <tr><td><button class="button_menu" onclick="search2()">ค้นหา</button></td>
</table>
</div>
</fieldset>
<br><br>
<fieldset>
  <legend>..::สรุปรายงานวัสดุ ประจำเดือน::..</legend>
  <table style="width:100%;">
    <td colspan="4">สรุปประจำเดือน &nbsp;&nbsp;&nbsp;
      <select name="sum_month">
        <option value="01">มกราคม</option>
        <option value="02">กุมภาพันธ์</option>
        <option value="03">มีนาคม</option>
        <option value="04">เมษายน</option>
        <option value="05">พฤษภาคม</option>
        <option value="06">มิถุนายน</option>
        <option value="07">กรกฏาคม</option>
        <option value="08">สิงหาคม</option>
        <option value="09">กันยายน</option>
        <option value="10">ตุลาคม</option>
        <option value="11">พฤศจิกายน</option>
        <option value="12">ธันวาคม</option>
      </select>
      <select name="sum_year">
        <option><?=date("Y")+543?></option>
        <option><?=date("Y")+542?></option>
        <option><?=date("Y")+541?></option>
      </select>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button onclick='sum_search()'>ค้นหา</button>
    </td>
    <tr>
      <?
$sql = "SELECT * from group_type GROUP By detail ORDER By row_id  ASC";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {
  $r++;
 echo "<td><input type='checkbox' id='rowgroup".$r."' value='".$row[row_id]."'> $row[detail] </td>";
 if($r%4==0){
  echo "<tr>";
 }
}
      ?>
      <input name="row_group" type="hidden" value="<?=$r?>">
    </td>
  </table>
</fieldset>
<br><br>


<fieldset>
  <legend>..::รายงานวัสดุ ใช้ไป::..</legend>
  <table style="width:100%;">
    <td colspan="4">สรุปประจำเดือน &nbsp;&nbsp;&nbsp;
      <select name="sum_month2">
        <option value="01">มกราคม</option>
        <option value="02">กุมภาพันธ์</option>
        <option value="03">มีนาคม</option>
        <option value="04">เมษายน</option>
        <option value="05">พฤษภาคม</option>
        <option value="06">มิถุนายน</option>
        <option value="07">กรกฏาคม</option>
        <option value="08">สิงหาคม</option>
        <option value="09">กันยายน</option>
        <option value="10">ตุลาคม</option>
        <option value="11">พฤศจิกายน</option>
        <option value="12">ธันวาคม</option>
      </select>
      <select name="sum_year2">
        <option><?=date("Y")+543?></option>
        <option><?=date("Y")+542?></option>
        <option><?=date("Y")+541?></option>
      </select>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button onclick='sum_search2()'>ค้นหา</button>
    </td>
    <tr>
      <?
$sql = "SELECT * from group_type GROUP By detail ORDER By row_id  ASC";
$result = mysql_query($sql);
$r=0;
while ($row = mysql_fetch_array($result) ) {
  $r++;
 echo "<td><input type='checkbox' id='rowgroup2".$r."' value='".$row[row_id]."'> $row[detail] </td>";
 if($r%4==0){
  echo "<tr>";
 }
}
      ?>
      <input name="row_group2" type="hidden" value="<?=$r?>">
    </td>
  </table>
</fieldset>
<br><br>
<fieldset>
  <legend>..::สรุปรายงานวัสดุ ประจำเดือน::..</legend>
  <table style="width:100%;">
    <td colspan="4">สรุปประจำเดือน &nbsp;&nbsp;&nbsp;
      <select name="sum_monthall1">
        <option value="01">มกราคม</option>
        <option value="02">กุมภาพันธ์</option>
        <option value="03">มีนาคม</option>
        <option value="04">เมษายน</option>
        <option value="05">พฤษภาคม</option>
        <option value="06">มิถุนายน</option>
        <option value="07">กรกฏาคม</option>
        <option value="08">สิงหาคม</option>
        <option value="09">กันยายน</option>
        <option value="10">ตุลาคม</option>
        <option value="11">พฤศจิกายน</option>
        <option value="12">ธันวาคม</option>
      </select>
      <select name="sum_yearall1">
        <option><?=date("Y")+543?></option>
        <option><?=date("Y")+542?></option>
        <option><?=date("Y")+541?></option>
      </select> ถึง       <select name="sum_monthall2">
        <option value="01">มกราคม</option>
        <option value="02">กุมภาพันธ์</option>
        <option value="03">มีนาคม</option>
        <option value="04">เมษายน</option>
        <option value="05">พฤษภาคม</option>
        <option value="06">มิถุนายน</option>
        <option value="07">กรกฏาคม</option>
        <option value="08">สิงหาคม</option>
        <option value="09">กันยายน</option>
        <option value="10">ตุลาคม</option>
        <option value="11">พฤศจิกายน</option>
        <option value="12">ธันวาคม</option>
      </select>
      <select name="sum_yearall2">
        <option><?=date("Y")+543?></option>
        <option><?=date("Y")+542?></option>
        <option><?=date("Y")+541?></option>
      </select>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button onclick='sum_searchall()'>ค้นหา</button>
    </td>
    <tr>
      <?
$sql = "SELECT * from group_type GROUP By detail ORDER By row_id  ASC";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {
  $r++;
 echo "<td><input type='checkbox' id='rowgroup2".$r."' value='".$row[row_id]."'> $row[detail] </td>";
 if($r%4==0){
  echo "<tr>";
 }
}
      ?>
      <input name="row_group3" type="hidden" value="<?=$r?>">
    </td>
  </table>
</fieldset>
<br><br>
</body>
</html>
<script type="text/javascript">

  function product_autocom(autoObj,showObj){
  var mkAutoObj=autoObj; 
  var mkSerValObj=showObj; 
  new Autocomplete(mkAutoObj, function() {
    this.setValue = function(id) {    
      document.getElementById(mkSerValObj).value = id;
      if(id!=""){
     var tx = $("#barcode").val();
      check_product(tx);
      $("#barcode").val("");
      $("#detail").val("");
      }
    }
    if ( this.isModified )
      this.setValue("");
   // if ( this.value.length < 1 && this.isNotClick ) 
   if ( this.value.length < 1 ) 
      return ;  
    return "auto/gdata.php?product=" +encodeURIComponent(this.value);
    }); 
}




// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");

product_autocom("barcode","detail");




</script>



        <script type="text/javascript" src="../js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
        <link type="text/css" href="../css/jquery-ui-1.8.10.custom.css" rel="stylesheet" /> 
       <script type="text/javascript">
         $("#dateday").datepicker({ dateFormat: 'dd-mm-yy', isBuddhist: 'true', defaultDate: 'toDay',
              dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
                  $("#today").datepicker({ dateFormat: 'dd-mm-yy', isBuddhist: 'true', defaultDate: 'toDay',
              dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
       </script>

