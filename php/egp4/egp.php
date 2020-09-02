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

$sql = "SELECT * from egp_title WHERE row_id = '1'";
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
// $_SESSION["office02"] = "(นางสาวเสงี่ยม ทรงวัย)<br>หัวหน้าเจ้าหน้าที่";
// $_SESSION["director"] = "(นายวิชญ์ สิริโรจย์พร)<br>ผู้อำนวยการโรงพยาบาลฝาง<br>ปฏิบัติราชการแทนผู้ว่าราชการจังหวัดเชียงใหม่";




$supply_name = $data["supply_name"];
$supply_addres = $data["supply_addres"];
$supply_phone = $data["supply_phone"];
$supply_tax = $data["supply_tax"];

$product = num_convertthai($data["product"]);
$no = $data["no"];
$no_requat = $data["no_requat"];

$dateday1 = $data["dateday1"];
$dateday2 = $data["dateday2"];
$pcs_detail = $data["pcs_detail"];
$total_bath = $data["total_bath"];
$total_bath_word = $data["total_bath_word"];

$total_bath_af_vat = number_format((100/107)*num_convertbric(str_replace(",","",$data["total_bath"])),2);
$total_bath_bf_vat = str_replace(",","",num_convertbric($total_bath))-str_replace(",","",$total_bath_af_vat);
$total_bath_af_vat = num_convertthai($total_bath_af_vat);
$total_bath_bf_vat = num_convertthai($total_bath_bf_vat);

$office01 = $data["office01"];
$office02 = $data["office02"];
$director = $data["director"];

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
  body{ font-family: 'THSarabunNew', sans-serif; font-size: 16px; line-height: 2.1em; background: #e1e1e1; }
  @media print {
    .page_breck {page-break-after: always;}
  }
.div_edit:hover{
  cursor: pointer;
  background-color: #b3ffff;
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
  if(htmlstr=="☑"){
    th.innerHTML = "&#9744;";
  }else{
    th.innerHTML = "&#9745;";
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
$('.btn').show();
}


</script>

</head>
<body>
  <div id="body">

<div style="margin:0px auto;width:210mm;background-color: #ffffff;" class="page_breck">
<img src="../../images/thai_government.jpg" style="width:21mm;margin-top: 60px;margin-left: 60px;" >
<div style="font-size: 22px;font-weight:bold;width:350px;margin-left:350px;margin-top: -30px;">บันทึกข้อความ</div>
<div style="margin-left:60px;margin-top: 50px;">ส่วนราชการ  <div class="div_edit" id="div_edit1" style="width:580px;height:30px;border-bottom:1px solid #000000;margin-left: 90px;margin-top:-28px;"> งานพัสดุ กลุ่มอำนวยการ<?=$co[company_name]?></div> </div>
<div style="margin-left:60px;margin-top: 3px;">ที่ <div class="div_edit" id="div_edit2" style="width:300px;height:30px;border-bottom:1px solid #000000;margin-left: 40px;margin-top:-28px;"> <?=$no?> </div> 
<div style="margin-left: 340px;margin-top: -28px;"> วันที่  <div class="div_edit" id="div_edit3" style="width:300px;height:30px;border-bottom:1px solid #000000;margin-left: 30px;margin-top:-28px;text-align: center;"> <?=$dateday1?></div> </div> </div>
<div style="margin-left:60px;">เรื่อง  <div class="div_edit" id="div_edit4" style="width:630px;height:30px;border-bottom:1px solid #000000;margin-left: 40px;margin-top:-28px;"> รายงานขอซื้อ/ขอจ้าง</div> </div>

<div style="margin-left:60px;margin-top:20px;">เรียน  <div class="div_edit" id="div_edit5" style="width:630px;height:30px;margin-left: 40px;margin-top:-28px;"> ผู้ว่าราชการจังหวัดเชียงใหม่ (ผู้อำนวยการ<?=$co[company_name]?>ปฏิบัติรายการแทนผู้ว่าราชการจังหวัดเชียงใหม่)</div> 
</div>

<div class="div_edit" id="div_edit6" style="margin-left:60px;margin-top:20px;width:660px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ด้วย งานพัสดุ กลุ่มผู้อำนวยการ <?=$co[company_name]?>มีความประสงค์จะ <?=$pcs_detail?>โดย
วิธีเฉพาะเจาะจง ซึ่งมีรายละเอียด ดังต่อไปนี้  
</div>

   <div class="div_edit" id="div_edit7" style="margin-left: 134px;">๑. เหตุผลความจำเป็นที่ต้องซื้อ/จ้าง</div>
   <div class="div_edit" id="div_edit8" style="margin-left: 154px;">เพื่อใช้ภายในหน่วยงาน และสำรองคลัง<?=$co[company_name]?></div>
   <div class="div_edit" id="div_edit9" style="margin-left: 134px;">๒. รายละเอียดของ<?=str_replace("จัดซื้อ", "", $pcs_detail);?> คือ</div>
   <div class="div_edit" id="div_edit10" style="margin-left: 154px;">
    <?=$product?>
   </div>
   <div class="div_edit" id="div_edit11" style="margin-left: 134px;">๓. ราคากลางของพัสดุที่จะซื้อ/จ้างจำนวน <?=$total_bath?> บาท (<?=$total_bath_word?>)</div>

   <div class="div_edit" id="div_edit12" style="margin-left: 134px;">๔. วงเงินที่จะซื้อ/จ้าง</div>
   <div class="div_edit" id="div_edit13" style="margin-left: 154px;">
   เงินนอกงบประมาณจาก จำนวน <?=$total_bath?> บาท (<?=$total_bath_word?>)
   </div>

   <div class="div_edit" id="div_edit14" style="margin-left: 134px;">๕. กำหนดเวลาที่ต้องการใช้พัสดุ หรือให้งานแล้วเสร็จภายใน ๓๐ วัน นับจากวันที่ลงนามในสัญญา</div>
   <div class="div_edit" id="div_edit15" style="margin-left: 154px;">
   เงินนอกงบประมาณจาก <?=$total_bath?> บาท (<?=$total_bath_word?>)
   </div>
   <div class="div_edit" id="div_edit16" style="margin-left: 134px;">๖. วิธีที่จะซื้อ/จ้าง และเหตุผลที่ต้องซื้อ/จ้าง</div>
   <div class="div_edit" id="div_edit17" style="margin-left: 154px;">
   ดำเนินการโดยวิธีเฉพาะเจาะจงเนื่องจากการจัดซื้อจัดจ้างพัสดุที่มีการผลิต จำหน่าย ก่อสร้าง หรือให้บริการทั่วไป &nbsp;&nbsp;และมีวงเงินในการจัดซื้อจัดจ้างครั้งหนึ่งไม่เกินวงเงินตามที่กำหนดในกฏกระทรวง
   </div>
   <div class="div_edit" id="div_edit18" style="margin-left: 134px;">๗. หลักเกณฑ์การพิจารณาคัดเลือกข้อเสนอ</div>
   <div class="div_edit" id="div_edit19" style="margin-left: 154px;">
   การพิจารณาคัดเลือกข้อเสนอโดยใช้เกณฑ์ราคา
   </div>
   <div class="div_edit" id="div_edit20" style="margin-left: 134px;">๘. การขออนุมัติแต่งตั้งคณะกรรมการต่างๆ</div>
   <div class="div_edit" id="div_edit21" style="margin-left: 154px;">
   ผู้แต่งตั้งผู้ตรวจรับพัสดุ
   </div>
   <div class="div_edit" id="div_edit22" style="margin-left: 134px;">๙.  อำนาจในการอนุมัติให้ดำเนินการในครั้งนี้ เป็นอำนาจของผู้อำนวยการ<?=$co[company_name]?> ตามคำสั่งจังหวัดเชียงใหม่ ที่ ๔๕๘๕/๒๕๖๒ ลงวันที่ ๑ ตุลาคม ๒๕๖๒</div>

   <div class="div_edit" id="div_edit23" style="margin-left: 134px;margin-top: 30px;">จึงเรียนมาเพื่อโปรดพิจารณา หากเห็นชอบขอได้โปรด</div>
   <div class="div_edit" id="div_edit24" style="margin-left: 154px;">๑. อนุมัติให้ดำเนินการ ตามรายละเอียดในรายงานขอซื้อ/ขอจ้างดังกล่าวข้างต้น</div>
   <div class="div_edit" id="div_edit25" style="margin-left: 154px;">๒. ลงนามในคำสั่งแต่งตั้งผู้ตรวจรับพัสดุ
 </div> 



<div class="div_edit" id="div_edit26" style="width:300px;height:80px;text-align: center;border:0px solid #ffee00;margin-left: 420px;margin-top: 40px;padding-top: 70px">
  <?=$office01?>
</div>

<div class="div_edit" id="div_edit27" style="width:300px;height:80px;text-align: center;border:0px solid #ffee00;margin-top: 50px;margin-left: 50px;">
  <br>
 <?=$office02?>
</div>

<div class="div_edit" id="div_edit28" style="width:300px;height:120px;text-align: center;border:0px solid #ffee00;margin-left: 420px;">
  <br>
<?=$director?>
</div>
</div>




<div style="margin:0px auto;width:210mm;background-color: #ffffff;" class="page_breck">
<img src="../../images/thai_government.jpg" style="width:24mm;margin-left:95mm;margin-top: 40px;" >
<div class="div_edit" id="div_edit29" style="width:350px;height:25px;text-align: center;margin:0px auto;">คำสั่ง <?=$co[company_name]?></div>
<div class="div_edit" id="div_edit30" style="width:350px;height:25px;text-align: center;margin:0px auto;">ที่ <?=$no_requat?></div>
<div class="div_edit" id="div_edit31" style="width:700px;height:25px;text-align: center;margin:0px auto;">เรื่อง แต่งตั้ง ผู้ตรวจรับพัสดุ สำหรับการ<?=str_replace("จัด", "", $pcs_detail);?> โดยวิธีเฉพาะเจาะจง</div>

<div class="div_edit" id="div_edit32" style="margin-left:60px;margin-top:40px;width:660px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  ด้วย <?=$co[company_name]?> มีความประสงค์จะ <?=$pcs_detail?> คือ <?=str_replace("<br>"," ",$product)?></div>

 <div class="div_edit" id="div_edit33" style="margin-left:60px;width:660px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;โดยวิธีเฉพาะเจาะจง และเพื่อให้เป็นไปตามระเบียบกระทรวงการคลังว่าด้วยการจัดซื้อจัดจ้างและการบริหารพัสดุภาครัฐ พ.ศ. ๒๕๖๐ จึงขอแต่งตั้งรายชื่อต่อไปนี้เป็นผู้ตรวจรับพัสุ สำหรับการ<?=str_replace("จัด", "", $pcs_detail);?> โดยวิธีเฉพาะเจาะจง
 </div> 



<div class="div_edit" id="div_edit34" style="width:600px;text-align: left;border:0px solid #ffee00;margin-left: 140px;margin-top: 10px;">
  ผู้ตรวจรับพัสดุ<br>
   &nbsp;&nbsp;นางกนกกร ไลไส่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้ตรวจรับพัสดุ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
</div>
<div class="div_edit" id="div_edit35" style="width:600px;height:80px;text-align: left;border:0px solid #ffee00;margin-left: 140px;margin-top: 5px;">
  พยาบาลวิชาชีพชำนาญการ<br>
  อำนาจหน้าที่ <br>
  ทำการตรวจรับพัสดุให้เป็นไปตามเงื่อนไขของสัญญาหรือข้อตกลงนั้น
</div>

<div class="div_edit" id="div_edit36" style="margin-top:20px;width:270px;height:30px;text-align: center;border:0px solid #ffee00;margin-left: 280px;">
  สั่งวันที่ <?=$dateday1?><br>
</div>
<div class="div_edit" id="div_edit37" style="width:270px;height:300px;text-align: center;border:0px solid #ffee00;margin-left: 280px;">
  <br><br><br>
<?=$director?>
</div>
</div>



<div style="margin:0px auto;width:210mm;height:295mm;background-color: #ffffff;overflow: hidden" class="page_breck">
<img src="../../images/<?=$data[publish]?>" style="width:205mm;" ;>
</div>
<!-- แสดงความบริสุทธิ์-->
<div style="margin:0px auto;width:210mm;height:295mm;background-color: #ffffff;" class="page_breck">
<div class="div_edit" id="div_edit38" style="position:absolute;width:470px;height:25px;text-align: left;border:0px solid #ffee00;margin-left: 300px;margin-top: 280mm;">
แนบเอกสาร ที่ <?=$no?> ลงวันที่ <?=$dateday1?>
</div>
<div style="width:700px;height:80px;"></div>
<div class="div_edit" id="div_edit39" style="width:700px;height:37px;font-weight:normal;text-align: center;margin:0px auto;">แบบแสดงความบริสุทธิ์ใจในการจัดซื้อจัดจ้างทุกวิธีของหน่วยงาน (วงเงินเล็กน้อยไม่เกิน ๑๐๐,๐๐๐ บาท)</div>
<div class="div_edit" id="div_edit40" style="width:700px;height:37px;font-weight:normal;text-align: center;margin:0px auto;">ในการเปิดเผยข้อมูลความขัดแย้งทางผลประโยชน์</div>
<div class="div_edit" id="div_edit41" style="width:700px;height:37px;font-weight:normal;text-align: center;margin:0px auto;">ของหัวหน้าเจ้าหน้าที่ เจ้าหน้าที่พัสดุ และคณะกรรมการตรวจรับพัสดุ</div>
<div class="div_edit" id="div_edit42" style="width:700px;height:37px;text-align: center;margin:0px auto;">-------------------------------------</div>

<div class="div_edit" id="div_edit43" style="width:700px;text-align: left;margin-left:60px;margin-top: 20px;">ข้าวเจ้า&nbsp;&nbsp;นางสาวเสงี่ยม&nbsp;&nbsp;ทรงวัย&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(หัวหน้าเจ้าหน้าที่)<br>
ข้าวเจ้า&nbsp;&nbsp;นางบุษบา&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ว่องไว&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(เจ้าหน้าที่)<br>
ข้าวเจ้า&nbsp;&nbsp;นางกนกกร&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ไลไส่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(คณะกรรมการตรวจรับพัสดุ)
</div>
<!-- <div class="div_edit" id="div_edit44" style="width:700px;height:37px;text-align: left;margin-left:60px;">ข้าวเจ้า&nbsp;&nbsp;นางบุษบา&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ว่องไว&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(เจ้าหน้าที่)</div>
<div class="div_edit" id="div_edit45" style="width:700px;height:37px;text-align: left;margin-left:60px;">ข้าวเจ้า&nbsp;&nbsp;นางกนกกร&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ไลไส่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(คณะกรรมการตรวจรับพัสดุ)</div> -->

<div class="div_edit" id="div_edit46" style="margin-left:60px;margin-top:10px;width:660px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  ขอให้คำรับรองว่าไม่มีความเกี่ยวข้องหรือมีส่วนได้ส่วนเสียไม่ว่าโดยตรงหรือโดยอ้อม หรือผลประโยชน์ใดๆ ที่ก่อให้เกิดความขัดแย้งทงผลประโยชน์กับผ้ขายผู้รับจ้าง ผู้เสนองาน หรือผู้ชนะประมูล หรือผู้มีส่วนเกี่ยวข้องที่เข้ามามีนิติสัมพันธ์ และวางตัวเป็นกลางในการดพเนินการเกี่ยวกับการพัสดุ ปฏิบัติหน้าที่ด้วยจิตสำนึก ด้วยความโปร่งใส สามารถให้มีผู้เกี่ยวข้องตรวจสอบได้ทุกเวลา มุ่งประโยชน์ส่วนรวมเป็นสำคัญ ตามที่ระบุไว้ในประกาศสำนักงานปลัดกระทรวงสาธารณสุขว่าด้วยแนวทางในการปฏิบัติในหน่วยงานด้านการจัดซื้อจัดจ้าง พ.ศ. ๒๕๖๐
 </div> 

<div class="div_edit" id="div_edit47" style="margin-left:60px;margin-top:10px;width:660px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  หากปรากฏว่าเกิดความขัดแย้งทางผลประโยชน์ระหว่างข้าพเจ้ากับผู้ขาย ผู้รับจ้าง ผู้เสนองาน หรือ ผู้ชนะประมูล หรือผู้มีส่วนเกี่ยวข้องที่เข้ามามีนิติสัมพันธ์ ข้าพเจ้าจะรายงานให้ทราบโดยทันที
   </div>


<div class="div_edit" id="div_edit48" style="width:300px;height:80px;text-align: center;border:0px solid #ffee00;margin-left: 60px;margin-top: 70px;">
  ลงนาม................................................................<br>
  <?=$office02?>
</div>

<div class="div_edit" id="div_edit49" style="width:300px;height:80px;text-align: center;border:0px solid #ffee00;margin-left: 420px;margin-top: -80px;">
  ลงนาม................................................................<br>
  <?=$office01?>
</div>
<div class="div_edit" id="div_edit50" style="width:300px;height:80px;text-align: center;border:0px solid #ffee00;margin-left: 60px;margin-top: 50px;">
  ลงนาม................................................................<br>
  นางกนกกร ไลไส่ <br> คณะกรรมการตรวจรับพัสดุ
</div>

</div>




<div style="margin:0px auto;width:210mm;background-color: #ffffff;" class="page_breck">
<img src="../../images/thai_government.jpg" style="width:21mm;margin-top: 60px;margin-left: 60px;" >
<div style="font-size: 22px;font-weight:bold;width:350px;margin-left:350px;margin-top: -30px;">บันทึกข้อความ</div>
<div style="margin-left:60px;margin-top: 50px;">ส่วนราชการ  <div class="div_edit" id="div_edit51" style="width:580px;height:30px;border-bottom:1px solid #000000;margin-left: 90px;margin-top:-28px;"> งานพัสดุ กลุ่มอำนวยการ<?=$co[company_name]?></div> </div>
<div style="margin-left:60px;margin-top: 3px;">ที่ <div class="div_edit" id="div_edit52" style="width:300px;height:30px;border-bottom:1px solid #000000;margin-left: 40px;margin-top:-28px;"> <?=$no?></div> 
<div style="margin-left: 340px;margin-top: -28px;"> วันที่  <div class="div_edit" id="div_edit53" style="width:300px;height:30px;border-bottom:1px solid #000000;margin-left: 30px;margin-top:-28px;text-align: center;"> <?=$dateday2?></div> </div> </div>
<div style="margin-left:60px;">เรื่อง  <div class="div_edit" id="div_edit54" style="width:630px;height:30px;border-bottom:1px solid #000000;margin-left: 40px;margin-top:-28px;"> รายงานขอซื้อ/ขอจ้าง</div> </div>

<div style="margin-left:60px;margin-top:20px;">เรียน  <div class="div_edit" id="div_edit55" style="width:630px;height:60px;margin-left: 40px;margin-top:-32px;"> ผู้ว่าราชการจังหวัดเชียงใหม่ (ผู้อำนวยการ<?=$co[company_name]?>ปฏิบัติรายการแทนผู้ว่าราชการจังหวัดเชียงใหม่)</div>
</div>
<div class="div_edit" id="div_edit56" style="margin-left:130px;">ขอรายงานผลการพิจารณา<?=str_replace("จัด", "", $pcs_detail);?> โดยวิธีเฉพาะเจาะจง ดังนี้</div>

<div style="margin-left: 60px;width:680px;border: 0px solid #000000;text-align: center;">
<table style="width:100%;">
  <tr><td style="text-align: center;border:1px solid #000000;">รายการพิจารณา</td>
  <td style="text-align: center;border:1px solid #000000;width:150px;">รายชื่อผู้ยื่นข้อเสนอ</td>
  <td style="text-align: center;border:1px solid #000000;width:100px;">ราคาที่เสนอ*</td>
  <td style="text-align: center;border:1px solid #000000;width:150px;">ราคาที่ตกลงซื้อหรือจ้าง*</td></tr>
<tr>
  <td style="text-align: left;border:1px solid #000000;padding-left: 5px;padding-right: 5px;" valign="top" class="div_edit" id="div_edit57" ><?=str_replace("จัดซื้อ", "", $pcs_detail);?>คือ <?=str_replace("<br>"," ",$product)?></td>
  <td style="text-align: center;border:1px solid #000000;width:150px;" valign="top" class="div_edit" id="div_edit58" ><?=$supply_name?></td>
  <td style="text-align: center;border:1px solid #000000;width:100px;" valign="top" class="div_edit" id="div_edit59" ><?=$total_bath?></td>
  <td style="text-align: center;border:1px solid #000000;width:150px;" valign="top" class="div_edit" id="div_edit60" ><?=$total_bath?></td>
</tr>
<td colspan="3" style="border:1px solid #000000;text-align: right;">รวม&nbsp;</td><td style="border:1px solid #000000;text-align: right;padding-right: 10px;" class="div_edit" id="div_edit61" ><?=$total_bath?></td>
</table>
</div>
<div style="margin-left:60px;font-size: 12px;" class="div_edit" id="div_edit62" >* ราคาที่เสนอ และราคาที่ตกลงซื้อหรือจ้าง เป็นราคารวมภาษีมูลค่าเพิ่มและภาษีอื่น ค่าขนส่ง ค่าจดทะเบียน และค่าใช้จ่ายอื่นๆ ทั้งปวง</div>
<div style="margin-left:60px;margin-top: 30px;" class="div_edit" id="div_edit63" >โดยเกณฑ์การพิจารณาผลการยื่นข้อเสนอครั้งนี้ จะพิจารณาตัดสินโดยใช้หลักเกณฑ์ราคา</div>
<div style="margin-left:130px;" class="div_edit" id="div_edit64" ><?=$co[company_name]?>พิจารณาแล้ว เห็นสมควรจัดซื้อจากผู้เสนอราคาดังกล่าว</div>
<div style="margin-left:130px;" class="div_edit" id="div_edit65" >จึงเรียนมาเพื่อโปรดพิจารณา หากเห็นชอบขอได้โปรดอนุมัติให้สั่งซื้อสั่งจ้างจากผู้เสนอราคาดังกล่าว</div>

<div style="width:300px;height:80px;text-align: center;border:0px solid #ffee00;margin-left: 420px;margin-top: -10px;padding-top: 100px;" class="div_edit" id="div_edit66" >
<?=$office01?>
</div>

<div style="margin-left:60px;width:380px;height:80px;text-align: left;border:0px solid #ffee00;margin-top: -40px;padding-top: 100px;" class="div_edit" id="div_edit67" >
เรียน ผู้อำนวนการ<?=$co[company_name]?><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เห็นสมควรอนุมัติให้ดำเนินการจัดซื้อ<br>
ด้วยวิธีเฉพาะเจาะจง และลงนามในประกาศ,คำสั่ง ต่อไปนี้
</div>

<div class="div_edit" id="div_edit68"  style="margin-left:60px;width:300px;height:80px;text-align: center;border:0px solid #ffee00;margin-top: 90px;padding-top:80px;">
  <?=$office02?>
</div>

<div class="div_edit" id="div_edit69"  style="width:300px;height:120px;text-align: center;border:0px solid #ffee00;margin-left: 420px;margin-top: -30px;">
  <br>
<?=$director?>
</div>
</div>



<div style="margin:0px auto;width:210mm;background-color: #ffffff;" class="page_breck">
<img src="../../images/thai_government.jpg" style="width:24mm;margin-left:95mm;margin-top: 40px;" >
<div style="width:350px;height:25px;text-align: center;margin:0px auto;">ประกาศ<?=$co[company_name]?></div>
<div style="width:700px;height:25px;text-align: center;margin:0px auto;" class="div_edit" id="div_edit70" >เรื่อง ประกาศผู้ชนะการเสนอราคา <?=str_replace("จัด", "", $pcs_detail);?> โดยวิธีเฉพาะเจาะจง</div>
<div style="width:700px;height:25px;text-align: center;margin:0px auto;">-------------------------------------------------------------------------------------------------</div>

<div class="div_edit" id="div_edit71" style="margin-left:60px;margin-top:10px;width:660px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  ตามที่ <?=$co[company_name]?> ได้มีโครงการ <?=$pcs_detail?> คือ <?=str_replace("<br>"," ",$product)?> โดยวิธีเฉพาะเจาะจงนั้น 
 </div> 
<div class="div_edit" id="div_edit72" style="margin-left:60px;margin-top:10px;width:660px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 ผู้ได้รับการคัดเลือก ได้แก่ <?=$supply_name?> (ส่งออก,ขายส่ง,ขายปลีก,ให้บริการ,ผู้ผลิต) โดยเสนอราคา เป็นเงินทั้งสิ้น <?=$total_bath?> บาท (<?=$total_bath_word?>) รวมภาษีมูลค่าเพิ่มและภาษีอื่น ค่าขนส่ง ค่าจดทะเบียน และค่าใช้จ่ายอื่นๆ ทั้งปวง
 </div> 

<div class="div_edit" id="div_edit73" style="width:270px;height:60px;text-align: center;border:0px solid #ffee00;margin-left: 310px;margin-top: 60px;">
  ประกาศ ณ วันที่ <?=$dateday2?><br>
</div>
<div class="div_edit" id="div_edit74" style="width:350px;height:120px;text-align: center;border:0px solid #ffee00;margin-left: 270px;">
  <br>
<?=$director?>
</div>
</div>


<div style="margin:0px auto;width:210mm;background-color: #ffffff;" class="page_breck">
<img src="../../images/thai_government.jpg" style="width:24mm;margin-left:92mm;margin-top: 40px;" >
<div style="width:350px;height:25px;text-align: center;margin:0px auto;font-size: 16px;padding: 15px;font-weight: bold;">ใบสั่งซื้อ/สั่งจ้าง</div>

<div class="div_edit" id="div_edit75" style="margin-top:40px;margin-left:60px;width:300px;height:180px;border: 0px solid #e0e0e0">
  ผู้ขาย <?=$supply_name?> <br>
  ที่อยู่ เลขที่ <?=$supply_addres?><br>
  โทรศัพท์ <?=$supply_phone?><br>
  เลขประจำตัวผู้เสียภาษี <?=$supply_tax?><br>
</div>

<div class="div_edit" id="div_edit76" style="width:270px;height:180px;border: 0px solid #e0e0e0;margin-left:430px;margin-top: -180px;">
  ใบสั่งซื้อเลขที่ <?=$no?> <br>
  วันที่ <?=$dateday2?><br>
  ส่วนราชการ <?=$co[company_name]?><br>
  ที่อยู่ <?=$co[address]?><br>
  โทรศัพท์ <?=$co[phone]?><br>
</div>



<div class="div_edit" id="div_edit77" style="margin-left:60px;margin-top:50px;width:660px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  ตามที่ <?=$supply_name?> ได้เสนอราคา ไว้ต่อ <?=$co[company_name]?> ซึ่งได้รับราคาและตกลงซื้อ ตามรายการดังต่อไปนี้ </div> 

<div style="margin-left: 60px;width:680px;border: 0px solid #000000;text-align: center;">
<table style="width:100%;">
  <tr>
<td style="text-align: center;border:1px solid #000000;width:50px;">ลำดับ</td>
  <td style="text-align: center;border:1px solid #000000;">รายการ</td>
  <td style="text-align: center;border:1px solid #000000;width:80px;">จำนวน</td>
  <td style="text-align: center;border:1px solid #000000;width:100px;">หน่วย</td>
  <td style="text-align: center;border:1px solid #000000;width:100px;">ราคาต่อหน่อย<br>(บาท)</td>
<td style="text-align: center;border:1px solid #000000;width:100px;" >จำนวนเงิน<br>(บาท)</td>
</tr>
<tr>
  <td class="div_edit" id="div_edit78" style="text-align: center;border:1px solid #000000;" valign="top">๑</td>
  <td class="div_edit" id="div_edit79" style="text-align: left;border:1px solid #000000;padding-left: 5px;padding-right: 5px;" valign="top"><?=str_replace("จัดซื้อ", "", $pcs_detail);?>คือ <br> <?=$product?></td>
  <td class="div_edit" id="div_edit80" style="text-align: center;border:1px solid #000000;" valign="top">๑</td>
  <td class="div_edit" id="div_edit81" style="text-align: center;border:1px solid #000000;" valign="top">ครั้ง</td>
  <td class="div_edit" id="div_edit82" style="text-align: center;border:1px solid #000000;" valign="top"><?=$total_bath?></td>
  <td class="div_edit" id="div_edit83" style="text-align: center;border:1px solid #000000;" valign="top"><?=$total_bath?></td>
</tr>
<td class="div_edit" id="div_edit84" colspan="3" rowspan="3" style="border:1px solid #000000;text-align: center;">(<?=$total_bath_word?>)</td>
<td colspan="2"style="border:1px solid #000000;text-align: right;padding-right: 10px;">รวมเป็นเงิน</td>
<td class="div_edit" id="div_edit85" style="border:1px solid #000000;text-align: right;padding-right: 10px;"><?=$total_bath_af_vat?></td>
<tr>
<td colspan="2"style="border:1px solid #000000;text-align: right;padding-right: 10px;">ภาษีมูลค่าเพิ่ม</td>
<td class="div_edit" id="div_edit86" style="border:1px solid #000000;text-align: right;padding-right: 10px;"><?=$total_bath_bf_vat?></td>
<tr>
<td colspan="2"style="border:1px solid #000000;text-align: right;padding-right: 10px;">รวทเป็นเงินทั้งสิ้น</td>
<td class="div_edit" id="div_edit87" style="border:1px solid #000000;text-align: right;padding-right: 10px;"><?=$total_bath?></td>
</table>
</div>


<div style="margin-left:60px;margin-top:10px;width:660px;">การซื้อ อยู่ภายใต้เงื่อนไขต่อไปนี้ </div> 
<div class="div_edit" id="div_edit88" style="margin-left:60px;width:660px;">๑. กำหนดส่งมอบภายใน ๑๕ วัน นับถัดจากวันที่ผู้รับจ้างได้รับใบสั่งซื้อ </div> 
<div class="div_edit" id="div_edit89" style="margin-left:60px;width:660px;">๒. ครบกำหนดส่งมอบวันที่................................. </div> 
<div class="div_edit" id="div_edit90" style="margin-left:60px;width:660px;">๓. สถานที่ส่งมอบ <?=$co[company_name]?> <?=$co[address]?></div> 
<div class="div_edit" id="div_edit91" style="margin-left:60px;width:660px;">๔. ระยะเวลารับประกัน - </div> 
<div class="div_edit" id="div_edit92" style="margin-left:60px;width:660px;">๕. สงวนสิทธิ์ค่าปรับกรณีส่งมอบเกินกำหนด โดยคิดค่าปรับเป็นรายวันในอัตราร้อยละ ๐.๑๐ ของราคาสื่งของที่ยังไม่ได้ &nbsp;&nbsp;&nbsp;&nbsp;รับมอบแต่จะต้องไม่ต่ำกว่าวันละ ๑๐๐.๐๐ บาท </div> 
<div class="div_edit" id="div_edit93" style="margin-left:60px;width:660px;">๖. ส่วนราชการสงวนสิทธิ์ที่จะไม่รับมอบถ้าปรากฏว่าสินค้านั้นมีลักษณะไม่ตรงตามรายการที่ระบุไว้ในใบสั่งซื้อ กรณีนี้ &nbsp;&nbsp;&nbsp;&nbsp;ผู้ซื้อ จะต้องดำเนินการเปลี่ยนใหม่ให้ถูกต้องตามใบสั่งซื้อทุกประการ </div> 
<div class="div_edit" id="div_edit94" style="margin-left:60px;width:660px;">๗. การประเมินผลการปฏิบัติงานของผู้ประกอบการ หน่วยรัฐสามารถนำผลการปฏิบัติงานแล้วเสร็จตามสัญญาหรือข้อ &nbsp;&nbsp;&nbsp;&nbsp;ตกลงของคู่สัญญา </div> 

<div class="div_edit" id="table_8" style="margin-left:60px;width:660px;">๘. การประเมินผลการปฏิบติงานของผู้ประกอบการ หน่วยงานของรัฐสามารถนำผลการปฏิบัติงานแล้วเสร็จตามสัญญา &nbsp;&nbsp;&nbsp;&nbsp;หรือข้อตกลงของสัญญา </div> 

<div class="div_edit" id="div_edit95" style="margin-left:80px;margin-top:10px;width:660px;">เพื่อนำมาประเมินผลการปฏิบัติงานของผู้ประกอบการ</div> 
<div  style="margin-left:80px;text-decoration: underline;">หมายเหตุ :</div> 
<div class="div_edit" id="div_edit96" style="margin-left:150px;width:580px;">๑. การติดอากรแสตมป์ให้เป็นไปตามประมวลกฏหมายรัษฎากร หากต้องการให้ใบสั่งซื้อมีผลตามกฏหมาย</div> 
<div class="div_edit" id="div_edit97" style="margin-left:150px;width:580px;">๒. ใบสั่งซื้อสั่งจ้างนี้อ้างอิงตามเลขที่โครงการ ๖๒๐๕๗๔๙๒๘๓๑ <?=str_replace("จัด", "", $pcs_detail);?> &nbsp;&nbsp;&nbsp;&nbsp;โดยวิธีเฉพาะเจาะจง</div> 

<div class="div_edit" id="div_edit98" style="width:370px;height:120px;text-align: center;border:0px solid #ffee00;margin-left: 340px;padding-top:30px;">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อ..................................................ผู้สั่งซื้อ/สั่งจ้าง
  <br>
<?=$director?>
</div>
<div class="div_edit" id="div_edit99"  style="width:300px;height:80px;text-align: center;border:0px solid #ffee00;margin-left: 60px;margin-top: -50px;">
  <br>
  <?=$office02?>
</div>
<div style="margin-left: 430px;margin-top:5px;">วันที <div class="div_edit" id="div_edit100" style="margin-left: 50px;margin-top: -35px;"><?=$dateday2?></div></div> 
<div class="div_edit" id="div_edit101" style="margin-top:28px;width:370px;height:80px;text-align: center;border:0px solid #ffee00;margin-left: 380px;padding-top:20px;">
  ลงชื่อ..................................................ผู้รับใบสั่งซื้อ/สั่งจ้าง
  <br>
  (..................................................)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
  ..................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
  วันที่ ..................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>

<div class="div_edit" id="div_edit102" style="width:300px;height:80px;text-align: left;border:0px solid #ffee00;margin-left: 60px;margin-top: 30px;">

</div>
</div>

<div style="margin:0px auto;width:210mm;height:295mm;background-color: #ffffff;" class="page_breck">

<div style="width:700px;height:80px;"></div>
<div style="width:700px;height:37px;font-weight:normal;text-align: center;margin:0px auto;font-weight: bold;">ใบตรวจรับการจัดซื้อ/จัดจ้าง</div>
<div class="div_edit" id="div_edit103" style="width:300px;height:37px;font-weight:normal;text-align: center;margin-left:320px;">วันที่ <?=$dateday2?></div>


<div class="div_edit" id="div_edit104" style="margin-left:60px;margin-top:10px;width:660px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
ตามใบสั่งซื้อสั่งจ้าง เลขที่ <?=$no?> ลงวันที่ <?=$dateday2?> <?=$co[company_name]?> ได้ตกลง ซื้อ กับ<?=$supply_name?> สำหรับโครงการ <?=str_replace("จัด", "", $pcs_detail);?> โดยวิธีเฉพาะเจาะจง เป็นจำนวนเงินทั้งสิ้น <?=$total_bath?> บาท (<?=$total_bath_word?>)
 </div> 
<div style="margin-left:60px;width:660px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
ผู้ตรวจรับพัสดุ ได้ตรวจรับงาน แล้ว ผลปรากฏ ดังนี้
 </div> 

<div style="margin-left:140px;margin-top:40px;width:660px;">๑.ผลการตรวจรับ</div> 
<div style="margin-left:145px;width:300px;"><span onclick="toggle_true(this)" style="cursor: pointer;">&#9745;</span> ถูกต้อง</div> 
<div style="margin-left:165px;width:300px;"><span onclick="toggle_true(this)" style="cursor: pointer;">&#9745;</span> ครบถ้วนถูกต้อง</div> 
<div style="margin-left:165px;width:300px;"><span onclick="toggle_true(this)" style="cursor: pointer;">&#9744;</span> ไม่ครบถ้วนตามสัญญา</div> 

<div style="margin-left:140px;margin-top:40px;width:660px;">๒.ค่าปรับ</div> 
<div style="margin-left:165px;width:300px;"><span onclick="toggle_true(this)" style="cursor: pointer;">&#9745;</span> มีค่าปรับ</div> 
<div style="margin-left:165px;width:300px;"><span onclick="toggle_true(this)" style="cursor: pointer;">&#9744;</span> ไม่มีค่าปรับ</div> 

<div style="margin-left:140px;margin-top:40px;width:660px;">๓.การเบิกจ่าย</div> 
<div style="margin-left:165px;width:20px;"><span onclick="toggle_true(this)" style="cursor: pointer;">&#9745;</span></div>
<div style="margin-left:185px;width:300px;margin-top: -30px;" class="div_edit" id="div_edit105"> เบิกจ่ายเงิน เป็นจำนวนเงินทั้งสิ้น <?=$total_bath?> บาท</div> 




<div class="div_edit" id="div_edit106" style="width:300px;height:150px;text-align: center;border:0px solid #ffee00;margin-left: 340px;margin-top:0px;padding-top: 80px;">
ลงชื่อ..............................................ผู้ตรวจรับพัสดุ<br>
  นางกนกกร ไลไส่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>
<div style="width:100px;height:30px;text-align: left;border:0px solid #ffee00;margin-left: 140px;margin-top: 0px;">

</div>
<div class="div_edit" id="div_edit107" style="width:300px;height:80px;text-align: left;border:0px solid #ffee00;margin-left: 220px;margin-top:-30px;">

</div>

<div style="width:300px;height:120px;text-align: center;border:0px solid #ffee00;margin-left: 420px;margin-top: 30px;">
  <span style="font-size: 16px;font-weight: bold;">ทราบ</span>
  <br>
  <br>
  <br>
<?=$director?>
</div>
</div>


</div>
<div id="popup_textedit" style="display:none;width:100%;height:100%;position: fixed;top:0px;left:0px;background-color: rgba(0,0,0,0.6);">
  <form name="a1" id="a1" method="post" enctype="multipart/form-data"  action="mysql_egp.php" target="ifream_target">
  ?>">
  <div style="width:700px;height:380px;top:50%;margin-top:-175px;left:50%;margin-left:-350px;position: fixed;background-color: #ffffff;padding:10px;text-align: center;">
    <textarea name="edit_text" id="edit_text" style="width:100%;height:300px;">
      
    </textarea>
    <input type="hidden" name="edit_text_id" id="edit_text_id">
    <input type="hidden" name="no" id="no">
    <input type="hidden" name="datebill" id="datebill">
    <input type="hidden" name="detail" id="detail">
    <input type="hidden" name="total" id="total">
    </form>
    <li class="btn btn-success" onclick="save_text()">บันทึก</li> <li class="btn btn-danger" onclick="$('#popup_textedit').hide()" >ปิด</li>
    
  </div>
</div>
<div style="position: fixed;width:200px;height:60px;top:10px;right:20px;text-align: center;">
  <li class="btn btn-success" onclick="save_text_final()">บันทึก</li>&nbsp;&nbsp;&nbsp;<li class="btn btn-info" onclick="print_page()">print</li>&nbsp;&nbsp;&nbsp;<li class="btn btn-info" onclick="$('#table_8').toggle()">ปิดสั่งจ้าง</li>
  <iframe id="ifream_target" name="ifream_target" src="" style="width:0px;height:0px;border:0px solid #e0e0e0;"></iframe>
</div>
</body>
</html>

