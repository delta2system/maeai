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
 /* function save_fix(){

    if($("#product").val()!=""){
    var data = "&dateday="+$("#dateday").val();
        data = data + "&times="+$("#times").val();
        data = data + "&department="+$("#department").val();
        data = data + "&product="+$("#product").val();
        data = data + "&model="+$("#model").val();
        data = data + "&serial="+$("#serial").val();
        data = data + "&no="+$("#no").val();
        data = data + "&type_fix="+$("#type_fix").val();
        data = data + "&type="+$("#type").val();
        data = data + "&other="+$("#other").val();
        data = data + "&officer="+$("#officer").val();
    $.ajax({
      type: "POST",
      url: "mysql_fix.php",
      data: "submit=save_fix"+data ,
      cache: false,
      success: function(result)
        {
          //alert(result);
                var obj = jQuery.parseJSON(result);      
                $.each(obj, function(key, val) {
                  if(val["status"]=="true"){
                    alert(val["msg"]);
                    window.location='../display_index.php';
                  }else{
                    alert(val["msg"]);
                  }
                });
        }
      });
  }else{
    alert("กรุณาใส่ข้อมูลอุปกรณ์ที่ส่งซ่อม");
    $("#product").focus();
  }
}
*/


function return_data(id){

      $.ajax({
      type: "POST",
      url: "mysql_fix.php",
      data: "submit=return_data&row_id="+id ,
      cache: false,
      success: function(result)
        {
          //alert(result);
          $("#save1").hide();
          $("#update1").show();
          
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
                    $("#type_fix").val(val["type_fix"]);
                    $("#other").val(val["other"]);
                    $("#officer").val(val["officer"]);
                    $("#blah").append(val["blah"]);

                    if(val["blah"]){
                      $("#btn_del_img").show();
                      $("#fileupload").hide()
                    }
                    
                });
        }
      });
}

/*
  function update_fix(){
    if($("#product").val()!=""){
    var data = "&dateday="+$("#dateday").val();
        data = data + "&times="+$("#times").val();
        data = data + "&department="+$("#department").val();
        data = data + "&product="+$("#product").val();
        data = data + "&model="+$("#model").val();
        data = data + "&serial="+$("#serial").val();
        data = data + "&no="+$("#no").val();
        data = data + "&type_fix="+$("#type_fix").val();
        data = data + "&type="+$("#type").val();
        data = data + "&other="+$("#other").val();
        data = data + "&officer="+$("#officer").val();
        data = data + "&row_id="+$("#row_id").val();
    $.ajax({
      type: "POST",
      url: "mysql_fix.php",
      data: "submit=update_fix"+data ,
      cache: false,
      success: function(result)
        {
                var obj = jQuery.parseJSON(result);      
                $.each(obj, function(key, val) {
                  if(val["status"]=="true"){
                    alert(val["msg"]);
                    window.location='../display_index.php';
                  }else{
                    alert(val["msg"]);
                  }
                });
        }
      });
  }else{
    alert("กรุณาใส่ข้อมูลอุปกรณ์ที่ส่งซ่อม");
    $("#product").focus();
  }
}
*/
    function return_store(rd){

      $.ajax({
      type: "POST",
      url: "mysql_fix.php",
      data: "submit=return_store&row_id="+rd ,
      cache: false,
      success: function(result)
        {
         // alert(result);
                var obj = jQuery.parseJSON(result);      
                $.each(obj, function(key, val) {
                    $("#department").val(val["responsible"]);
                    $("#product").val(val["attribute"]);
                    $("#model").val(val["model"]);
                    $("#serial").val(val["serial"]);
                    $("#no").val(val["code"]);
                    $("#type").val(val["store_type"]);

                   
                });
        }
      });

    }

    function del_image(){
      var rd = $("#row_id").val();

     $.ajax({
      type: "POST",
      url: "mysql_fix.php",
      data: "submit=del_image_fix&row_id="+rd ,
      cache: false,
      success: function(result)
        { 
        
          $("#blah").html('');
          $("#btn_del_img").hide();
          $("#fileupload").show();
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
          <form id="b1" name="b1" method="post" action="mysql_fix.php" enctype="multipart/form-data">
  <table style="width:100%;">
      <tr><td>วันที่</td><td><input type="text" id="dateday" name="dateday" class="form-control" value="<?=date("d").' '.mount(date("m")).' '.(date("Y")+543);?>"></td><td>เวลาแจ้ง</td><td><input type="text" id="times" name="times" class="form-control" value="<?=date("H:i")?>"></td></tr>
      <tr><td>หน่วยงาน</td><td >
        <select id="department" name="department" class="form-control">
        <?
        $sql = "SELECT * from department ";
        $result = mysql_query($sql);
        while ($row = mysql_fetch_assoc($result) ) {
          echo "<option value='$row[row_id]'>$row[name]</option>";
        }
        ?>
      </select>
      </td>
      <td>ดำเนินการ </td><td>
        <select class="form-control" id="type_fix" name="type_fix">
          <option value="1">ซ่อม</option>
          <option value="2">บำรุงรักษา</option>
          <option value="3">ปรับปรุง/สร้างใหม่</option>
        </select>

      </td>

    </tr>
      <tr><td>อุปกรณ์ที่ส่งซ่อม</td><td colspan="3"><input type="text" id="product" name="product" class="form-control"></td></tr>
      <tr><td>ยี่ห้อ/รุ่น</td><td><input type="text" id="model" name="model" class="form-control" placeholder="ถ้ามี"></td><td>Serial Number</td><td><input type="text" name="serial" id="serial" class="form-control" placeholder="ถ้ามี"></td></tr>
      <tr><td>เลขครุภัณฑ์</td><td><input type="text" id="no" name="no" class="form-control" placeholder="ถ้ามี"></td><td>ประเภท</td><td>
        <select class="form-control" id="type" name="type">
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
      <tr><td valign="top">รายละเอียด อาการ ชำรุด</td><td colspan="3"><textarea class="form-control" style="height:120px;" id="other" name="other"></textarea></tr>
      <tr><td>ผู้ส่งซ่อม</td><td colspan="3"><input type="text" id="officer" name="officer" class="form-control" value="<?=$_SESSION['xfullname']?>"></td></tr>
<!--       <tr><td colspan="4" style="color:#bcbcbc;">------------------------------------------------------------------------------------------------------------------------------------------------</td>
      <tr><td colspan="4" style="font-weight: bold;"> <i class='fa fa-spinner'></i> ช่างตรวจสอบ</td></tr>
      <tr><td>วันที่ตรวจสอบ</td><td><input type="text" id="dateday" class="form-control" value="<?=date("d").' '.mount(date("m")).' '.(date("Y")+543);?>"></td>
          <td>งานซ่อม</td><td ><select class="form-control"><option>กลุ่ม A</option><option>กลุ่ม B</option><option>กลุ่ม C</option><option>กลุ่ม D</option></select></td>
      </tr>
      <tr><td valign="top">ความเห็นช่าง</td><td colspan="3" ><textarea class="form-control" style="height:100px;"></textarea></td></tr>
      <tr><td>ช่างผู้ตรวจสอบ</td><td colspan="3"><input type="text" id="officer" class="form-control" value="<?=$_SESSION['xfullname']?>"></td></tr>
 -->

      <tr>
        <td>อัพรูปภาพ</td><td colspan="3"><input type="file" name="fileupload[]" id="fileupload"  style="font-size: 18px;" multiple="multiple"  onchange="imagespreview(this)"></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="3">
          <div style="width:100%;height: 220px;border:1px solid #909090;overflow-y:scroll;background-color: #ffffff; " id="blah">
      <?
      //   $ims=explode("#",$arrCol["images"]);
      // if($arrCol["images"]){
      //   if(count($ims)>0){
      //     for ($r=1; $r < count($ims) ; $r++) { 
      //       echo "<img src=\"../images/store/$ims[$r]\" style=\"height:200px;\">";
      //     }
      //   }else{
      //     echo "<img src=\"../images/store/".$arrCol["images"]." style=\"height:200px;\">";
      //   }
      // }
      ?>
        <!-- <img id="blah" src="../images/store/<?=$arrCol["images"]?>" style="height:250px;"> -->
      </div>
        </td>
      </tr>
      <tr><td colspan="2">
       <!-- <button id="update1" class="btn btn-info" onclick="update_fix()" style="display: none;">แก้ไขแจ้งซ่อม</button> 
        <button id="save1" class="btn btn-info" onclick="save_fix()">บันทึกแจ้งซ่อม</button></td>-->
        <input type="submit" name="update1" id="update1" value="แก้ไขแจ้งซ่อม" class="btn btn-info" style="display: none;" onclick="$('input[name=submit]').val('update_fix');">
        <input type="submit" name="save1" id="save1" value="บันทึกแจ้งซ่อม" class="btn btn-info" onclick="$('input[name=submit]').val('save_fix');">
        <li class="btn btn-danger" id="btn_del_img" style="display: none;" onclick="del_image()">ลบรูปภาพ</li>
      </td>
        <td colspan="2" style="text-align: right;"><li class="btn btn-danger" onclick="window.location='../display_index.php'">ปิด</li>
        <input type="hidden" name="row_id" id="row_id" value="<?PHP echo $_GET["row_id"];?>">
        <input type="hidden" name="submit">
      </td></tr>

  </table>
  </form>
</div>
</body>
</html>
<!-- jQuery 3 -->
<script src="../dashboard/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../dashboard/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script type="text/javascript">
             function imagespreview(input) {
           // alert($('#blah').attr('src'));
     for(i=0;i<input.files.length;i++){

            if (input.files && input.files[i]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                  // $('#blah').attr('src', e.target.result);
                   
                    var img = $("<img />");
                        img.attr("style", "width:120px;");
                        img.attr("src", e.target.result);
                        $("#blah").append(img);
                        $("#blah").css({"background-color":"#ffffff"});
                //  $("#blah").append("<img src='"+e.target.result+"' style='height:200px;'>");
                };

                reader.readAsDataURL(input.files[i]);
            }
          }
        }
</script>
<?
if($_GET["row_id"]){
  echo("<script>return_data(".$_GET["row_id"].")</script>");
}

if($_GET["row_id_store"]){

  echo("<script>return_store(".$_GET["row_id_store"].")</script>");
}

?>
