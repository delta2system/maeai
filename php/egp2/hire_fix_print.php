<?
session_start();
include("../../php/connect.inc");
$sql = "SELECT * from tbl_company WHERE 1";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {
$co[$row["tbl_title"]]=$row["tbl_value"];
}
function num_convertthai($str){
$numthai = array("๑","๒","๓","๔","๕","๖","๗","๘","๙","๐");
$numarabic = array("1","2","3","4","5","6","7","8","9","0");
return str_replace($numarabic,$numthai,$str);
}

function num_convertbric($str){
$numthai = array("๑","๒","๓","๔","๕","๖","๗","๘","๙","๐");
$numarabic = array("1","2","3","4","5","6","7","8","9","0");
return str_replace($numthai,$numarabic,$str);
}

function type_hire_return($str){
  $sql = "SELECT detail from hire_type WHERE row_id = '$str' limit 1  ";
  list($name) = Mysql_fetch_row(Mysql_Query($sql));
  return $name;

}

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

function convert_redatday($str){

$sb=explode("-",$str);


return str_ireplace("0","",$sb[2])." ".mount($sb[1])." ".$sb[0];

}

function department_return($str){
  $sql = "SELECT name from department WHERE code = '$str' limit 1  ";
  list($name) = Mysql_fetch_row(Mysql_Query($sql));
  return $name;
}

$sql = "SELECT * from hirefix WHERE row_id = '".$_GET["row_id"]."'";
$result = mysql_query($sql);
$data = mysql_fetch_assoc($result);





// $_SESSION["supply_name"] = "ร้านฝางธุรกิจ";
// $_SESSION["supply_addres"] = "เลขที่ ๔๕ หมู่ ๓ ตําบลเวียง อําเภอฝาง จังหวัดเชียงใหม่ ๕๐๑๑๐" ;
// $_SESSION["supply_phone"] = "๐๕๓๔๕๑๒๘๗";
// $_SESSION["supply_tax"] = "๓๕๐๐๙๐๐๘๕๙๒๔๕";

// $_SESSION["product"] = "๑.ดินน้ำมัน จำนวน ๒๐ ก้อนๆละ ๖ บาท <br>
//     ๒.ซองสีน้ำตาลขนาด A๔ จำนวน ๓๐๐ ซองๆละ ๕ บาท <br>
//     ๓. สติกเกอร์ใส จำนวน ๕๐ แผ่นๆละ ๒๐ บาท <br>
//     ๔.เทปตีเส้น จำนวน ๑๐ ม้วนๆละ ๑๕ บาท <br>
//     ๕.กระดาษ FAX จำนวน ๔ ม้วนๆละ ๖๐ บาท <br>
//     ๖.เทปใส ๑/๒ นิ้ว จำนวน ๖๐ ม้วนๆะ ๒๕ บาท <br>
//     ๗. กระดาษการ์ดสี ขนาด A๔ จำนวน ๓๐ รีมๆละ ๑๑๐ บาท <br>
//     ๘.แผ่นเคลือบ A๔ ขนาด ๑๐๐ แผ่นๆละ ๔.๕๐ บาท <br>
//     ๙.เทปกาว ๒ หน้าแบบหนา จำนวน ๒ ม้วนๆละ ๒๘๐ บาท <br>";

// $_SESSION["no"] ="ชม.๐๐๓๒.๓๐๑/๖๒๐๒๑๘";
// $_SESSION["no_requat"] = "๙๘๖/๒๕๖๒";

// $_SESSION["dateday1"] = "๑๔ พฤษภาคม ๒๕๖๒";
// $_SESSION["dateday2"] = "๑๕ พฤษภาคม ๒๕๖๒";
// $_SESSION["pcs_detail"] = "จัดซื้อวัสดุสำนักงาน ๙ รายการ";
// $_SESSION["total_bath"] = "๕,๕๐๐.๐๐";
// $_SESSION["total_bath_word"] = "ห้าพันห้าร้อยบาทถ้วน";

// $_SESSION["office01"] = "(นางบุษบา ว่องไว)<br>เจ้าหน้าที่";
 //$_SESSION["office02"] = "นางสาวเสงี่ยม ทรงวัย";
// $_SESSION["director"] = "(นายวิชญ์ สิริโรจย์พร)<br>ผู้อำนวยการโรงพยาบาลฝาง<br>ปฏิบัติราชการแทนผู้ว่าราชการจังหวัดเชียงใหม่";




// $supply_name = $data["supply_name"];
// $supply_addres = $data["supply_addres"];
// $supply_phone = $data["supply_phone"];
// $supply_tax = $data["supply_tax"];

// $product = $data["product"];
// $no = $data["no"];
// $no_requat = $data["no_requat"];

// $dateday1 = $data["dateday1"];
// $dateday2 = $data["dateday2"];
// $pcs_detail = $data["pcs_detail"];
// $total_bath = $data["total_bath"];
// $total_bath_word = $data["total_bath_word"];

// $total_bath_af_vat = number_format((100/107)*num_convertbric(str_replace(",","",$data["total_bath"])),2);
// $total_bath_bf_vat = str_replace(",","",num_convertbric($total_bath))-str_replace(",","",$total_bath_af_vat);
// $total_bath_af_vat = num_convertthai($total_bath_af_vat);
// $total_bath_bf_vat = num_convertthai($total_bath_bf_vat);

// $office01 = $data["office01"];
  $co[leader_parcel] = "นางสาวเสงี่ยม ทรงวัย";
  $co[director] = "นายวิชญ์ สิริโรจย์พร";

?>
<!DOCTYPE html>
<html>
<head>
	<title>ใบสั่งซื้อสั่งจ้าง</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link type="text/css" href="../../fonts/thsarabumnew.css" rel="stylesheet" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../dashboard/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../dashboard/bower_components/font-awesome/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<style type="text/css">
	@import url(../../fonts/thsarabunnew.css);
  body{ font-family: 'THSarabunNew', sans-serif; font-size: 12px; line-height: 2em; background: #e1e1e1; }
  @media print {
    .page_breck {page-break-after: always;}
  }
.div_edit:hover{
  cursor: pointer;
  background-color: #b3ffff;
}
input[type="text"]{
   border-style:none;
  border-bottom: 1px dotted #909090;
  padding-left:10px; 
  height: 20px;
  font-weight: bold;
}
input[type="text"]:hover{
  cursor: pointer;
  background-color: #b3ffff;  
}
input[type="checkbox"]{
  width:18px;
  height:18px;
  vertical-align: middle;
  cursor: pointer;
}
</style>
<script type="text/javascript">
  function nl2br (str, replaceMode, isXhtml) {

  var breakTag = (isXhtml) ? '<br />' : '<br>';
  var replaceStr = (replaceMode) ? '$1'+ breakTag : '$1'+ breakTag +'$2';
  return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, replaceStr);
}

function br2nl (str, replaceMode) {   
  
  var replaceStr = (replaceMode) ? "\n" : '';
  // Includes <br>, <BR>, <br />, </br>
  // var str = str.split("&nbsp;"," ");
  return str.replace("<br>", replaceStr);
}

function save_text(){
  var id = $("#edit_text_id").val();
  var txt = $("#edit_text").val();

      var wordspac = txt.split(" ");
      for(t=1;t<=wordspac.length;t++){
        txt = txt.replace(" ",'&nbsp;');
      }

      var words = txt.split("\n");
      for(t=1;t<=words.length;t++){
        txt = txt.replace("\n",'<br>');
      }

  $("#popup_textedit").hide();
  //$("#div_edit2").html(txt);
  //alert(id);
  document.getElementById(""+id).innerHTML = nl2br(txt);
  $("#edit_text").val('');
  $("#edit_text_id").empty();
}

function toggle_true(th){
  var htmlstr = th.innerHTML;
  if(htmlstr=="<div style=\"margin-top: -5px;\">✔</div>"){
    th.innerHTML = "";
  }else{
    th.innerHTML = "<div style=\"margin-top: -5px;\">✔</div>";
  }
}

$(document).ready(function(){
    // body...
$( ".div_edit" ).dblclick(function(e) {
  var htmlString = $( this ).html();
      //htmlString = trim(htmlString);
      var words = htmlString.split("<br>");
      for(t=1;t<=words.length;t++){
        htmlString = htmlString.replace("<br>",'');
      }

      var wordspac = htmlString.split("&nbsp;");
      for(t=1;t<=wordspac.length;t++){
        htmlString = htmlString.replace("&nbsp;",' ');
      }
      //htmlString = br2nl(htmlString);


 $("#popup_textedit").show();
 $("#edit_text").val(htmlString);
  $("#edit_text_id").val(this.id);
});

  });


function save_text_final(){
//var restorepage = document.body.innerHTML;
var restorepage = $("#body").html();
$("#edit_text").val(restorepage);
$("#no").val($("#div_edit2").html());
$("#datebill").val($("#div_edit3").html());
$("#detail").val($("#div_edit10").html());
$("#total").val($("#div_edit11").html());

$("form").submit();
setTimeout('print_page()', 3000);
}

function print_page(){
$('.btn').hide();
window.print();
}


</script>

</head>
<body>
  <div id="body">

<div style="margin:0px auto;width:210mm;background-color: #ffffff;" class="page_breck">
<div style="width:300px;height:30px;text-align: center;margin:0px auto;font-weight: bold;padding-top: 30px;font-weight: bold;">ใบแจ้งซ่อม<?=$co[company_name]?>  </div>
<div style="margin-left:560px;margin-top:-10px;border:1px solid #000000;width:200px;height:80px;padding:10px;line-height: 1.5em; ">
  <span style="font-weight: bold;text-decoration: underline">งานซ่อมบำรุง</span><br>
  เลขที่รับ <input type="text" name="input[]" style="width:120px;"><br>
  วันที่ <input type="text" name="input[]" style="width:140px;">
</div>


<div style="margin-left:60px;margin-top:10px;">หน่วยงาน <input type="text" name="input[]" value="<?=department_return($data[department])?>" style="width:230px;"> โทร <input type="text" name="input[]" > วันที่ <input type="text" name="input[]" value="<?=num_convertthai(convert_redatday($data[dateday]))?>"> </div>
<div style="margin-left:60px;">เรื่อง <input type="text" name="input[]" style="margin-left:20px;width:230px;border-style: none;" value="ขออนุมัติส่งซ่อมวัสดุ-ครุภัณฑ์"> </div>
<div style="margin-left:60px;">เรียน <input type="text" name="input[]" style="margin-left:20px;width:230px;border-style: none;" value="ผู้อำนวยการ<?=$co[company_name]?>"> </div>
<?if(empty($data[type_fix])){?>
<div style="width:18px;height: 18px;border:1px solid #000000;border-radius: 12px;position: absolute;margin-left: 390px;margin-top:3px;font-size:20px;cursor: pointer;" onclick="toggle_true(this)"></div>
<div style="width:18px;height: 18px;border:1px solid #000000;border-radius: 12px;position: absolute;margin-left: 450px;margin-top:3px;font-size:20px;cursor: pointer;" onclick="toggle_true(this)"></div>
<div style="width:18px;height: 18px;border:1px solid #000000;border-radius: 12px;position: absolute;margin-left: 535px;margin-top:3px;font-size:20px;cursor: pointer;" onclick="toggle_true(this)"></div>
<?}?>
<div style="margin-left:120px;">เนื่องจากทางหน่วยงาน มีความประสงค์ที่จะดำเนินการ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?if(empty($data[type_fix])){?>ซ่อม &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; บำรุงรักษา &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ปรับปรุง/สร้างใหม่ <?}else{ echo "<span style='font-weight:bold;'>"; if($data[type_fix]==1){ echo "ซ่อม";}else if($data[type_fix]==2){ echo "บำรุงรักษา";}else if($data[type_fix]==3){ echo "ปรับปรุง/สร้างใหม่";} echo "</span>";   }?> </div>
<div style="margin-left:60px;">รายการคือ<input type="text" name="input[]" style="width:620px;" value="<?=$data[product]?>"></div>
<?if(empty($data[type])){?>
<div style="width:18px;height: 18px;border:1px solid #000000;border-radius: 12px;position: absolute;margin-left: 130px;margin-top:3px;font-size:20px;cursor: pointer;" onclick="toggle_true(this)"></div>
<div style="width:18px;height: 18px;border:1px solid #000000;border-radius: 12px;position: absolute;margin-left: 265px;margin-top:3px;font-size:20px;cursor: pointer;" onclick="toggle_true(this)"></div>
<div style="width:18px;height: 18px;border:1px solid #000000;border-radius: 12px;position: absolute;margin-left: 375px;margin-top:3px;font-size:20px;cursor: pointer;" onclick="toggle_true(this)"></div>
<div style="width:18px;height: 18px;border:1px solid #000000;border-radius: 12px;position: absolute;margin-left: 525px;margin-top:3px;font-size:20px;cursor: pointer;" onclick="toggle_true(this)"></div>
<?}?>
<div style="margin-left:60px;">ประเภทงาน <?if(empty($data[type])){?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ไฟฟ้า-อิเล็กทรอนิกส์ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; เครื่องมือแพทย์ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ประปา-น้ำเสีย-สุขภัณฑ์ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; อาคารสถานที่-ครุภัณฑ์ <?}else{ echo "<span style='font-weight:bold;'>".type_hire_return($data[type])."</span>";}?></div>

<div style="margin-left:60px;">ยี้ห้อ / รุ่น <input type="text" name="input[]" style="width:240px;" value="<?=$data[model]?>"> หมายเลขครุภัณฑ์ <input type="text" name="input[]" style="width:270px;" value="<?=$data[no]?>"> </div>
<div style="margin-left:60px;">อาการเสีย <input type="text" name="input[]" style="width:280px;" value="<?=$data[other]?>"> สาเหตุ <input type="text" name="input[]" style="width:290px;" value=""> </div>

<div style="margin-left:450px;margin-top:10px;width:300px;height:50px;padding:10px;text-align: center;">
  เขียนชื่อ.......<?if(empty($data[officer])){?>...............................<?}else{ echo $data[officer];}?>..........(ตัวบรรจง)<br>
  ผู้ขออนุมัติซ่อม
</div>
<div style="margin-left:60px;font-weight: bold;margin-top: -20px;">การดำเนินการของช่าง </div>
<?if(empty($data[group_fix])){?>
<div style="width:18px;height: 18px;border:1px solid #000000;border-radius: 12px;position: absolute;margin-left: 360px;margin-top:3px;font-size:20px;cursor: pointer;" onclick="toggle_true(this)"></div>
<div style="width:18px;height: 18px;border:1px solid #000000;border-radius: 12px;position: absolute;margin-left: 450px;margin-top:3px;font-size:20px;cursor: pointer;" onclick="toggle_true(this)"></div>
<div style="width:18px;height: 18px;border:1px solid #000000;border-radius: 12px;position: absolute;margin-left: 540px;margin-top:3px;font-size:20px;cursor: pointer;" onclick="toggle_true(this)"></div>
<div style="width:18px;height: 18px;border:1px solid #000000;border-radius: 12px;position: absolute;margin-left: 630px;margin-top:3px;font-size:20px;cursor: pointer;" onclick="toggle_true(this)"></div>
<?}?>
<div style="margin-left:60px;">ได้ดำเนินการตรวจสอบและซ่อมบำรุงตามแจ้ง พบว่า เป็นงาน &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ซ่อมกลุ่ม <?if(empty($data[group_fix])){?>A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ซ่อมกลุ่ม B &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ซ่อมกลุ่ม C &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ซ่อมกลุ่ม D<?}else{ echo $data[group_fix];}?>
</select></div>
<div style="margin-left:60px;width:680px;">
  <input type="text" name="input[]" style="width:100%;" value="<?=$data[other_fix]?>">
  <input type="text" name="input[]" style="width:100%;">
</div>
<div style="margin-left:120px;">รายการวัสดุ ที่ใช้แนบท้ายบันทึกการแจ้งซ่อมนี้ </div>
<div style="margin-left:450px;width:300px;height:50px;text-align: center;">
  ลงชื่อ......<?if(empty($data[officer_recipt])){?>...............................<?}else{ echo $data[officer_recipt];}?>....<br>
  ช่างผู้ตรวจสอบ/ซ่อม
</div>
<div style="margin-left:60px;font-weight: bold;margin-top: -20px;">ความเห็นหัวหน้างานซ่อมบำรุง </div>
<div style="margin-left:60px;width:680px;">
  <input type="text" name="input[]" style="width:100%;">
  <input type="text" name="input[]" style="width:100%;">
  <!-- <textarea name="input[]" style="width:100%;"></textarea> -->
</div>
<div style="margin-left:450px;margin-top:15px;width:300px;height:50px;text-align: center;">
  ลงชื่อ.....................................หัวหน้างานซ่อมบำรุง<br>
  ............./............./.............
</div>
<div style="margin-left:60px;font-weight: bold;">การส่งมอบงาน </div>
<div style="width:18px;height: 18px;border:1px solid #000000;border-radius: 12px;position: absolute;margin-left: 350px;margin-top:3px;font-size:20px;cursor: pointer;" onclick="toggle_true(this)"></div>
<div style="width:18px;height: 18px;border:1px solid #000000;border-radius: 12px;position: absolute;margin-left: 450px;margin-top:3px;font-size:20px;cursor: pointer;" onclick="toggle_true(this)"></div>
<div style="margin-left:60px;">หน่วยงานได้รับมอบงานที่เจ้าหน้าที่ช่างดำเนินการในสภาพ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ใช้ได้ตามปกติ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ไม่สามารถใช้ได้ควรส่งคืนพัสดุจัดหาทกแทน</div>

<div style="margin-left:450px;margin-top:15px;width:300px;height:50px;text-align: center;">
  ลงชื่อ.....................................ผู้รับมอบงานคืน<br>
  ............./............./.............
</div>

<div style="margin-left:60px;margin-top:-10px;width:300px;height:180px;border:0px solid #e0e0e0;">
  <span style="font-weight: bold;">ความเห็นหัวหน้างานพัสดุ</span>
  <input type="text" name="input[]" style="width:100%;">
  <input type="text" name="input[]" style="width:100%;">
  <input type="text" name="input[]" style="width:100%;">
  <div style="text-align: right;margin-left: 50px;margin-top: 10px;">
  ลงชื่อ..........................................<br>
  (............................................)<br>
   หัวหน้าพัสดุ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>
</div>

<div style="margin-left:440px;margin-top:-180px;width:300px;height:180px;border:0px solid #e0e0e0;">
  <span style="font-weight: bold;">ความเห็นหัวหน้ากลุ่มอำนวนการ</span>
  <input type="text" name="input[]" style="width:100%;">
  <input type="text" name="input[]" style="width:100%;">
  <input type="text" name="input[]" style="width:100%;">
  <div style="text-align: right;margin-left: 50px;margin-top: 10px;">
  ลงชื่อ..........................................<br>
  ( <?=$co[leader_parcel]?> )<br>
   หัวหน้ากลุ่มผู้อำนวยการ&nbsp;&nbsp;
</div>
</div>
<div style="margin-left:60px;font-weight: bold;">ความเห็นผู้อำนวยการโรงพยาบาลฝาง </div>
<div style="width:18px;height: 18px;border:1px solid #000000;border-radius: 12px;position: absolute;margin-left: 60px;margin-top:3px;font-size:20px;cursor: pointer;" onclick="toggle_true(this)"></div>
<div style="width:18px;height: 18px;border:1px solid #000000;border-radius: 12px;position: absolute;margin-left:130px;margin-top:3px;font-size:20px;cursor: pointer;" onclick="toggle_true(this)"></div>
<div style="margin-left:60px;width:680px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; อนุมัติ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ไม่อนุมัติ <input type="text" name="input[]" style="width:500px;">
  <input type="text" name="input[]" style="width:100%;">
  <input type="text" name="input[]" style="width:100%;">
</div>

<div style="margin-left:450px;margin-top:15px;width:300px;height:80px;text-align: center;">
  ลงชื่อ.....................................<br>
  <?=
  $co[director];
  ?><br>ผู้อำนวนการ<?=$co[company_name]?>
</div>

<!-- <div style="position: fixed;width:150px;height:60px;top:10px;right:20px;text-align: center;">
  <li class="btn btn-success" onclick="save_text_final()">บันทึก</li>&nbsp;&nbsp;&nbsp;<li class="btn btn-info" onclick="print_page()">print</li>
  <iframe id="ifream_target" name="ifream_target" src="" style="width:0px;height:0px;border:0px solid #e0e0e0;"></iframe>
</div> -->
</body>
</html>
<script type="text/javascript">
    function next_page(){
    window.location='../display_index.php';
  }
  window.print();
  function CloseWindowsInTime(t){t = t*1000;setTimeout('next_page()',t);}CloseWindowsInTime(3);

</script>
