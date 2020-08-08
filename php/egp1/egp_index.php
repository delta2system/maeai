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

// $data["supply_name"] = "ร้านฝางธุรกิจ";
// $data["supply_addres"] = "เลขที่ ๔๕ หมู่ ๓ ตําบลเวียง อําเภอฝาง จังหวัดเชียงใหม่ ๕๐๑๑๐" ;
// $data["supply_phone"] = "๐๕๓๔๕๑๒๘๗";
// $data["supply_tax"] = "๓๕๐๐๙๐๐๘๕๙๒๔๕";

// $data["product"] = "๑.ดินน้ำมัน จำนวน ๒๐ ก้อนๆละ ๖ บาท <br>
//     ๒.ซองสีน้ำตาลขนาด A๔ จำนวน ๓๐๐ ซองๆละ ๕ บาท <br>
//     ๓. สติกเกอร์ใส จำนวน ๕๐ แผ่นๆละ ๒๐ บาท <br>
//     ๔.เทปตีเส้น จำนวน ๑๐ ม้วนๆละ ๑๕ บาท <br>
//     ๕.กระดาษ FAX จำนวน ๔ ม้วนๆละ ๖๐ บาท <br>
//     ๖.เทปใส ๑/๒ นิ้ว จำนวน ๖๐ ม้วนๆะ ๒๕ บาท <br>
//     ๗. กระดาษการ์ดสี ขนาด A๔ จำนวน ๓๐ รีมๆละ ๑๑๐ บาท <br>
//     ๘.แผ่นเคลือบ A๔ ขนาด ๑๐๐ แผ่นๆละ ๔.๕๐ บาท <br>
//     ๙.เทปกาว ๒ หน้าแบบหนา จำนวน ๒ ม้วนๆละ ๒๘๐ บาท <br>";

// $data["no"] ="ชม.๐๐๓๒.๓๐๑/๖๒๐๒๑๘";
// $data["no_requat"] ="๙๘๖/๒๕๖๒";
// $data["dateday1"] = "๑๔ พฤษภาคม ๒๕๖๒";
// $data["dateday2"] = "๑๕ พฤษภาคม ๒๕๖๒";
// $data["pcs_detail"] = "จัดซื้อวัสดุสำนักงาน ๙ รายการ";
// $data["total_bath"] = "๕,๕๐๐.๐๐";
// $data["total_bath_word"] = "ห้าพันห้าร้อยบาทถ้วน";

// $data["office01"] = "(นางบุษบา ว่องไว)<br>เจ้าหน้าที่";
// $data["office02"] = "(นางสาวเสงี่ยม ทรงวัย)<br>หัวหน้าเจ้าหน้าที่";
// $data["director"] = "(นายวิชญ์ สิริโรจย์พร)<br>ผู้อำนวยการโรงพยาบาลฝาง<br>ปฏิบัติราชการแทนผู้ว่าราชการจังหวัดเชียงใหม่";

// $data["supply_name"];
// $data["supply_addres"];
// $data["supply_phone"];
// $data["supply_tax"];
// $data["product"];
// $data["no"];
// $data["no_requat"];
// $data["dateday1"];
// $data["dateday2"];
// $data["pcs_detail"];
// $data["total_bath"];
// $data["total_bath_word"];

// $data["office01"];
// $data["office02"];
// $data["director"];

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
  body{ font-family: 'THSarabunNew', sans-serif; font-size: 14px; line-height: 2.1em; background: #e1e1e1; }

</style>
</head>
<body>
<!--   <div id="body">
  <section class="content" style="margin:0px auto;width:210mm;background-color: #ffffff;">

      <div class="row">


<div style="margin:0px auto;width:210mm;background-color: #ffffff;" class="page_breck">
</div>
</div>
</section>

</div>
 -->
 <div style="margin:0px auto;width:210mm;background-color: #ffffff;padding: 20px;" class="page_breck">
<div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">PROCUREMENT ใบจัดซื้อจัดจ้าง</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form"   name="a1" id="a1" method="post" enctype="multipart/form-data"  action="mysql_egp.php" >
                <!-- text input -->
                <div class="form-group">
                  <label>ที่</label>
                  <input type="text" name="no" class="form-control" value="<?=$data[no]?>">
                </div>
                <div class="form-group">
                  <label>เลขที่คำสั่ง</label>
                  <input type="text" name="no_requat" class="form-control" value="<?=$data[no_requat]?>">
                </div>
                <div class="form-group">
                  <label>วันที่ 1</label>
                  <input type="text" name="dateday1" class="form-control" value="<?=$data[dateday1]?>">
                </div>
                <div class="form-group">
                  <label>วันที่ 2</label>
                  <input type="text" name="dateday2" class="form-control" value="<?=$data[dateday2]?>">
                </div>
                <div class="form-group">
                  <label>จำนวนรายการสินค้า</label>
                  <input type="text" name="pcs_detail" class="form-control" value="<?=$data[pcs_detail]?>">
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>สินค้า</label>
                  <textarea name="product" class="form-control" rows="3" ><?=str_ireplace("<br>","", $data[product])?></textarea>
                </div>
                <div class="form-group">
                  <label>จำนวนเงิน</label>
                  <input type="text" name="total_bath" class="form-control" value="<?=$data[total_bath]?>">
                </div>
                <div class="form-group">
                  <label>จำนวนเงิน(ตัวหนังสือ)</label>
                  <input type="text" name="total_bath_word" class="form-control" value="<?=$data[total_bath_word]?>">
                </div>
                <div class="form-group">
                  <label>ร้านค้า</label>
                  <input type="text" name="supply_name" class="form-control" value="<?=$data[supply_name]?>">
                </div>
                <div class="form-group">
                  <label>ที่อยู่:ร้านค้า</label>
                  <input type="text" name="supply_addres" class="form-control" value="<?=$data[supply_addres]?>">
                </div>
                <div class="form-group">
                  <label>โทรศัพท์:ร้านค้า</label>
                  <input type="text" name="supply_phone" class="form-control" value="<?=$data[supply_phone]?>">
                </div>
                <div class="form-group">
                  <label>เลขที่ผู้เสียภาษี:ร้านค้า</label>
                  <input type="text" name="supply_tax" class="form-control" value="<?=$data[supply_tax]?>">
                </div>
                <div class="form-group">
                  <label>เจ้าหน้าที่</label>
                   <textarea name="office01" class="form-control" rows="3" ><?=str_ireplace("<br>","\n", $data[office01])?></textarea>
                </div>
                <div class="form-group">
                  <label>หัวหน้าเจ้าหน้าที่</label>
                   <textarea name="office02" class="form-control" rows="3" ><?=str_ireplace("<br>","\n", $data[office02])?></textarea>
                </div>
                <div class="form-group">
                  <label>ผู้อำนวยการ</label>
                   <textarea name="director" class="form-control" rows="3" ><?=str_ireplace("<br>","\n", $data[director])?></textarea>
                </div>
                <div class="form-group" >
                    <input type="submit" name="submit" class="btn btn-success" onclick="save_text_final()" value="ทำใบจัดซื้อจัดจ้าง">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<li  class="btn btn-info" onclick="">ค้นหาจัดซื้อจัดจ้างเดิม</li>
                </div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
        </div>



  
  <!-- <iframe id="ifream_target" name="ifream_target" src="" style="width:0px;height:0px;border:0px solid #e0e0e0;"></iframe> -->

</body>
</html>

