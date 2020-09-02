<?
session_start();
include("../connect.inc");
// if($_SESSION["xusername"]==""){
//   echo("<script>alert('กรุณาทำการล็อกอินก่อนใช้งาน');window.location='login.php'</script>");
// }
// if($_GET["dateday"]){
//   $dateday=$_GET["dateday"];
// }else{
//   $dateday=date("d-m-").(date("Y")+543);
// }
// unset($_SESSION["d_day"]);
// unset($_SESSION["d_department"]);
// unset($_SESSION["d_to"]);


?>
<!DOCTYPE html>
<html>
<head>
  <title>..::รายงานการจัดซื้อจัดจ้าง::..</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../../js/jquery-1.11.1.js"></script>
  <!-- <script type="text/javascript" src="auto/autocomplete.js"></script>
  <link rel="stylesheet" href="auto/autocomplete.css"  type="text/css"/> -->
  <link rel="stylesheet" href="../../bootstrap/datepick/jquery-ui.css">
<script src="../../bootstrap/datepick/jquery-ui.js"></script>
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
     input[type='text']{
      padding:5px;
      font-size: 16px;
      border:1px solid #e0e0e0;
      border-radius: 5px;
     }

  </style>
<script type="text/javascript">
  function search1(){
    var dp = $("#department").val();
    var da = $("#dateday").val();
    var db = $("#today").val();
    var left = (screen.width/2)-(800/2);
    var top = (screen.height/2)-(600/2);

    // var v1 = $("#dateday").val();
    // var v2 = $("#today").val();
    // var v3 = $("#department").val();
    window.open("report_egpa.php?department="+dp+"&date="+da+"&today="+db,"_blank","toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=800,height=600");
  }

  function search2(){

    var dp = $("#barcode").val();
    var da = $("#dateday_p").val();
    var db = $("#today_p").val();
    var left = (screen.width/2)-(800/2);
    var top = (screen.height/2)-(600/2);
    // var v1 = $("#dateday").val();
    // var v2 = $("#today").val();
    // var v3 = $("#department").val();
    window.open("report_egpb.php?barcode="+dp+"&date="+da+"&today="+db,"_blank","toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=800,height=600");
  }

  function search3(){
    var dp = $("#company").val();
    var da = $("#dateday3").val();
    var db = $("#today3").val();
    var left = (screen.width/2)-(800/2);
    var top = (screen.height/2)-(600/2);
    // var v1 = $("#dateday").val();
    // var v2 = $("#today").val();
    // var v3 = $("#department").val();
    window.open("report_egpc.php?department="+dp+"&date="+da+"&today="+db,"_blank","toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=800,height=600");
  }

</script>
</head>
<body>
  <center>


<fieldset style="width:870px;margin-left: 25px;border:1px solid #E65100;background-color: #FFF3E0;">
<legend style="color:#E65100;">รายงานการจัดซื้อจัดจ้าง </legend>
<div style="width: 50%;float: left;">
<table width="850px" >
 <!-- <tr><td><input type="checkbox" name="all" checked> ทั้งหมด</td> -->
  <tr><td style="text-align:right;padding-right: 5px;">ประเภทการจัดซื้อ </td><td>
      <select name="department" id="department" style="font-size: 16px;padding:5px;">
        <option value="">ทั้งหมด</option>
    <?
                    $strSQL_store="SELECT * FROM hire_type WHERE 1";
                    $result_store=mysql_query($strSQL_store);
                    while ($sty = mysql_fetch_array($result_store)) {
                      echo "<option value='$sty[row_id]'>$sty[detail]</option>";
                    }

    ?>
      </select>
    </td>
 <tr><td style="text-align:right;padding-right: 5px;">ตั้งแต่วันที่ </td><td><input type="text" name="dateday" id="dateday" value="<?="01-10-".(date("Y")+542)?>"></td>
  <tr><td style="text-align:right;padding-right: 5px;">ถึงวันที่ </td><td><input type="text" name="today" id="today" value="<?=date("d-m-").(date("Y")+543)?>"></td>
   <tr><td></td><td style="text-align: center;"><button class="button_menu" onclick="search1()">ค้นหา</button></td>
  <tr><td style="height:30px;"></td>


   <tr><td style="text-align:right;padding-right: 5px;">รหัส/พัสดุ </td><td><input type="hidden" name="barcode" id="barcode" style="width:80px;" >
    <input type='text' name='detail' id='detail' style="width:200px;"></td>
   <tr><td style="text-align:right;padding-right: 5px;">ตั้งแต่วันที่ </td><td><input type="text" name="dateday_p" id="dateday_p" value="<?="01-10-".(date("Y")+542)?>"></td>
  <tr><td style="text-align:right;padding-right: 5px;">ถึงวันที่ </td><td><input type="text" name="today_p" id="today_p" value="<?=date("d-m-").(date("Y")+543)?>"></td>
  <tr><td></td><td><button class="button_menu" onclick="search2()">ค้นหา</button></td>
  <tr><td style="height: 30px;"></td>
  <tr><td style="text-align:right;padding-right: 5px;">ร้านค้า</td><td>
      <select name="company" id="company" style="font-size: 16px;padding:5px;">
        <option value=""></option>
    <?
                    $strSQL_store="SELECT * FROM customer_supply WHERE 1";
                    $result_store=mysql_query($strSQL_store);
                    while ($sty = mysql_fetch_array($result_store)) {
                      echo "<option value='$sty[code]'>$sty[name]</option>";
                    }

    ?>
      </select>
  </td>
  <tr><td style="text-align:right;padding-right: 5px;">ตั้งแต่วันที่</td><td><input type="text" name="dateday3" id="dateday3" value="<?="01-10-".(date("Y")+542)?>"></td>
  <tr><td style="text-align:right;padding-right: 5px;">ถึงวันที่</td><td><input type="text" name="today3" id="today3" value="<?=date("d-m-").(date("Y")+543)?>"></td>
    <tr><td></td><td><button class="button_menu" onclick="search3()">ค้นหา</button></td>  
 </table>
</div>

</fieldset>

</body>
</html>




<!--         <script type="text/javascript" src="../js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
        <link type="text/css" href="../css/jquery-ui-1.8.10.custom.css" rel="stylesheet" />  -->
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
        $("#dateday3").datepicker({ dateFormat: 'dd-mm-yy', isBuddhist: 'true', defaultDate: 'toDay',
              dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
        $("#today3").datepicker({ dateFormat: 'dd-mm-yy', isBuddhist: 'true', defaultDate: 'toDay',
              dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
         $("#dateday_p").datepicker({ dateFormat: 'dd-mm-yy', isBuddhist: 'true', defaultDate: 'toDay',
              dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
        $("#today_p").datepicker({ dateFormat: 'dd-mm-yy', isBuddhist: 'true', defaultDate: 'toDay',
              dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
       </script>

<?
$states="";
$sql = "SELECT detail,barcode,unit from egp_product  where store='out' GROUP By barcode ";
$results = mysql_query($sql);
while ($row = mysql_fetch_array( $results )) {

  $s++;
  if($s>1){  $states.=",";  }
  $states.="{value:\"".str_ireplace("&#39;","'",$row[barcode])." : ".str_ireplace("&#39;","'",$row[detail])."\",detail:\"$row[detail]\",unit:\"$row[unit]\",id:\"$row[barcode]\"}";
}
$states.="";


?>
<script type="text/javascript">

            $(function () {
                $("#detail").autocomplete({
                    source: [<?echo $states;?>],
                    select: function( event, ui ) {
                      $("#detail").val(ui.item.detail.replace("&#39;", "'"));
                      // $("input[name=drug_stock]").focus();
                      $("#barcode").val(ui.item.id);
                      // $("select[name=unit_be]").val(ui.item.unit);
                      // $("select[name=unit_af]").val(ui.item.unit);
                      // $("select[name=unit]").val(ui.item.unit_pack);
                      // $("input[name=pcs_af]").val(ui.item.pcs_pmed);

                      
                    }
                })
                .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<div style='border-bottom:1px solid #a0a0a0;'><span style='color:#909090;'> รหัส : " + item.id + "</span><br>ชื่อ : " + item.detail + "</div>" )
        .appendTo( ul );
    };
                ;
            });
          </script>