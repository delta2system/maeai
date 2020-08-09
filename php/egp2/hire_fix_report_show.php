<?
session_start();
include("../../php/connect.inc");

function mount($str){
switch($str)
{
case "01": $str = "ม.ค."; break;
case "02": $str = "ก.พ."; break;
case "03": $str = "มี.ค."; break;
case "04": $str = "เม.ย."; break;
case "05": $str = "พ.ค."; break;
case "06": $str = "มิ.ย."; break;
case "07": $str = "ก.ค."; break;
case "08": $str = "ส.ค."; break;
case "09": $str = "ก.ย."; break;
case "10": $str = "ต.ค."; break;
case "11": $str = "พ.ย."; break;
case "12": $str = "ธ.ค."; break;
}
return $str;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>ใบจ้างซ่อม</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link type="text/css" href="../../fonts/thsarabumnew.css" rel="stylesheet" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../dashboard/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../dashboard/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../dashboard/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dashboard/dist/css/AdminLTE.min.css">

<!--   <script src="https://code.jquery.com/jquery-1.10.2.js"></script> -->
<style type="text/css">
	@import url(../../fonts/thsarabunnew.css);
  body{ font-family: 'THSarabunNew', sans-serif; font-size: 16px; line-height: 2em;}
  @media print {
    .page_breck {page-break-after: always;}
  }
  td{
    padding: 5px;
  }
</style>

<script type="text/javascript">
function return_data(id){

      $.ajax({
      type: "POST",
      url: "mysql_fix.php",
      data: "submit=return_data&row_id="+id ,
      cache: false,
      success: function(result)
        {

                var obj = jQuery.parseJSON(result);      
                $.each(obj, function(key, val) {
                    $("#dateday").val(val["date_convert"]);
                    $("#times").val(val["times"]);
                    $("#department").val(val["department"]);
                    $("#product").val(val["product"]);
                    $("#model").val(val["model"]);
                    $("#serial").val(val["serial"]);
                    $("#no").val(val["no"]);
                    $("#type").val(val["type"]);
                    $("#other").val(val["other"]);
                    $("#officer").val(val["officer"]);
                    $("#datefix").val(val["datefix"]);

                    if(val["date_recipt_convert"]){$("#date_recipt").val(val["date_recipt_convert"]);}
                    if(val["time_recipt"]!="00:00:00"){$("#time_recipt").val(val["time_recipt"]);}
                    if(val["other_fix"]){$("#other_fix").val(val["other_fix"]);}
                    if(val["officer_recipt"]){$("#officer_recipt").val(val["officer_recipt"]);}
                    if(val["officer_fix"]){$("#officer_fix").val(val["officer_fix"]);}
                    if(val["type_fix"]){$("#type_fix").val(val["type_fix"]);}
                    if(val["group_fix"]){$("#group_fix").val(val["group_fix"]);}
                    if(val["type_status_fix"]){$("#type_status_fix").val(val["type_status_fix"]);}

                    $("#blah").append(val["blah"]);
                    $("#blah2").append(val["blah2"]);
                    $("#blah3").append(val["blah3"]);            
                    dateFix(val["datefix"]);

                    // $('input').css({'border':'0px solid #e0e0e0'});
                    // $('select').css({'border':'0px solid #e0e0e0'});
                    $('input').attr('readonly', true);
                    $('select').attr('readonly', true);
                    $('textarea').attr('readonly', true);
                    

                });
        }
      });
}

function dateFix(str){

    $.ajax({
      type: "POST",
      url: "mysql_fix.php",
      data: "submit=cal_datefix"+"&dateday="+$('#date_recipt').val()+"&datefix="+str ,
      cache: false,
      success: function(result)
        {
          $("#datefixshow").html(result);
        }
      });


}
</script>

</head>
<body>

<div style="width:210mm;background-color: #ffffff;padding: 10px;box-shadow: 0px 0px 10px rgba(0,0,0,0.5);position:absolute;margin-top: 50px;left:50%;margin-left: -105mm;"  class="box box-danger">
              <div class="box-header with-border">
              <h3 class="box-title" style="font-family:'THSarabunNew', sans-serif;font-weight: bold; "><li class="fa fa-wrench"></li>  ใบแจ้งซ่อม</h3>
            </div>
  <table style="width:100%;">
      <tr><td>วันที่</td><td><input type="text" id="dateday" class="form-control" value="<?=date("d").' '.mount(date("m")).' '.(date("Y")+543);?>"></td><td style="width:120px;text-align: right;">เวลาแจ้ง</td><td><input type="text" id="times" class="form-control" value="<?=date("H:i")?>"></td></tr>
      <tr><td>หน่วยงาน</td><td>
        <select id="department" class="form-control">
        <?
        $sql = "SELECT * from department ";
        $result = mysql_query($sql);
        while ($row = mysql_fetch_assoc($result) ) {
          echo "<option value='$row[code]'>$row[name]</option>";
        }
        ?>
      </select>
      </td>      <td style="text-align: right;">ดำเนินการ </td><td>
        <select class="form-control" id="type_fix">
          <option value="1">ซ่อม</option>
          <option value="2">บำรุงรักษา</option>
          <option value="3">ปรับปรุง/สร้างใหม่</option>
        </select>

      </td></tr>
      <tr><td>อุปกรณ์ที่ส่งซ่อม</td><td colspan="3"><input type="text" id="product" class="form-control"></td></tr>
      <tr><td>ยี่ห้อ/รุ่น</td><td><input type="text" id="model" class="form-control" placeholder="ถ้ามี"></td><td>Serial Number</td><td><input type="text" id="serial" class="form-control" placeholder="ถ้ามี"></td></tr>
      <tr><td>เลขครุภัณฑ์</td><td><input type="text" id="no" class="form-control" placeholder="ถ้ามี"></td><td  style="text-align: right;">ประเภท</td><td>
        <select class="form-control" id="type">
<!--           <option value="4">ไฟฟ้า-อิเล็กทรอนิกส์ </option><option value="3">เครื่องมือแพทย์</option><option value="2">ประปา-น้ำเสีย-สุขภัณฑ์</option><option value="1">อาคารสถานที่-ครุภัณฑ์</option>
          <option value="0">อื่นๆ</option> -->
          <?
        $sql = "SELECT * from store_type ";
        $result = mysql_query($sql);
        while ($row = mysql_fetch_assoc($result) ) {
          echo "<option value='$row[row_id]'>$row[detail]</option>";
        }
          ?>
        </select>
      </td></tr>
      <tr><td valign="top">รายละเอียด อาการ ชำรุด</td><td colspan="3"><textarea class="form-control" style="height:120px;" id="other"></textarea></tr>
      <tr><td>รูปภาพ</td><td colspan="3">
      <div style="width:100%;height: 220px;border:1px solid #909090;overflow-y:scroll;background-color: #ffffff; " id="blah">

      </div> 

      </td>
      <tr><td>ผู้ส่งซ่อม</td><td colspan="3"><input type="text" id="officer" class="form-control" value="<?=$_SESSION['xfullname']?>"></td></tr>
      <tr><td colspan="4" style="color:#909090;">
        ------------------------------------------------------------------------------------------------------------------------------------------------
      </td></tr>
      <tr><td colspan="4"><li class="fa fa-television"></li> รับแจ้งซ่อม</td></tr>
      <tr><td>วันที่รับงาน</td><td><input type="text" id="date_recipt" class="form-control" value="<?=date("d").' '.mount(date("m")).' '.(date("Y")+543);?>"></td><td style="text-align: right;">เวลารับงาน</td><td><input type="text" id="time_recipt" class="form-control" value="<?=date("H:i")?>"></td></tr>
       <tr><td valign="top">ความเห็นของช่าง</td><td colspan="3"><textarea class="form-control" style="height:120px;" id="other_fix"></textarea></tr>
        <tr><td>ผู้รับใบงาน</td><td><input type="text" id="officer_recipt" class="form-control" value="<?=$_SESSION['xfullname']?>"></td><td style="text-align: right;">งานซ่อม</td><td ><select id='group_fix' class="form-control">
          <!-- <option value="A">กลุ่ม A</option><option value="B">กลุ่ม B</option><option value="C">กลุ่ม C</option><option value="D">กลุ่ม D</option> -->
          <?
          $sql="SELECT * FROM hirefix_type";
          $result = mysql_query($sql);
          while ($ht = mysql_fetch_assoc($result)) {
            echo "<option value='$ht[row_id]'>$ht[type_name]</option>";
          }
          ?>
        </select></td></tr>
        <tr>
          <td>ความเร่งด่วน</td><td>
            <select class="form-control" id="type_status_fix">
              <option value='1'>ปกติ</option>
               <option  value='2'>เร่งด่วน</option>
                <option  value='3'>ฉุกเฉิน</option>
            </select>
          </td>
          <td style="text-align: right;">ประกันวันซ่อม</td><td>
           <input type="number" name="datefix" id="datefix" onkeyup="dateFix(this.value)" style="padding:3px 10px;border:1px solid #d2d2d2;width:80px;">  วัน &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="datefixshow"></span>
          </td>

        </tr>

          <tr>
        <td>อัพรูปภาพ</td><td colspan="3">
          <div style="width:100%;height: 220px;border:1px solid #909090;overflow-y:scroll;background-color: #ffffff; " id="blah2">

      </div>
        </td>
      </tr>

      <tr><td colspan="2">


      </td>
        <input type="hidden" id="row_id" value="<?PHP echo $_GET["row_id"];?>">
      </td></tr>

      <?
      $sql = "SELECT type_status_fix from hirefix WHERE row_id = '".$_GET["row_id"]."'";
      list($type_status_fix) = Mysql_fetch_row(Mysql_Query($sql));
      if($type_status_fix){?>
      <tr><td colspan="4" style="color:#909090;">
        ------------------------------------------------------------------------------------------------------------------------------------------------
      </td></tr>
      <tr><td colspan="4"><li class="fa fa-gears"></li> สถานะงานซ่อม</td></tr>
      <tr><td>วันที่ส่งมอบ</td><td><input type="text" id="date_return" class="form-control" value="<?=date("d").' '.mount(date("m")).' '.(date("Y")+543);?>"></td><td style="text-align: right;">สถานะ</td><td>
                  <select class="form-control" id="type_status_return">
                  <option value='1'>ใช้งานปกติ</option>
                  <option  value='2'>ไม่สามารถซ่อมได้</option>
                  <option  value='3'>รอจำหน่าย</option>
                  <option  value='4'>รออะไหล่</option>
            </select></td></tr>
       <tr><td valign="top">ความเห็นของช่าง</td><td colspan="3"><textarea class="form-control" style="height:120px;" id="other_return"></textarea></tr>
       <tr><td>เลขที่เอกสารแนบ</td><td><input type="text" id="nobill_recipt" class="form-control" value=""></td> 
       <td style="text-align: right;">ค่าซ่อมบำรุง</td><td><input type="text" id="money_recipt" class="form-control" value=""></td> 
      <tr>
        <td>รูปภาพ</td><td colspan="3">
          <div style="width:100%;height: 220px;border:1px solid #909090;overflow-y:scroll;background-color: #ffffff; " id="blah3"></div>
        </td>

       <tr><td>ผู้ดำเนินการ</td><td><input type="text" id="officer_fix" class="form-control" value="<?=$_SESSION['xfullname']?>"></td>

      <?}?>
  </table>

</div>
</body>
</html>
<!-- jQuery 3 -->
<script src="../dashboard/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../dashboard/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<?
if($_GET["row_id"]){
  echo("<script>return_data(".$_GET["row_id"].")</script>");
}
?>
