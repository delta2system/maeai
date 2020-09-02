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

$sql = "SELECT * from egp_title WHERE row_id = '2'";
$result = mysql_query($sql);
$data = mysql_fetch_assoc($result);


?>
<!DOCTYPE html>
<html>
<head>
  <title>ใบสั่งซื้อสั่งจ้าง</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link type="text/css" href="../dashboard/fonts/thsarabumnew.css" rel="stylesheet" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../dashboard/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../dashboard/bower_components/font-awesome/css/font-awesome.min.css">

  <link rel="stylesheet" href="../dashboard/dist/css/AdminLTE.min.css">

<!--   <link rel="stylesheet" href="../dashboard/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> -->

  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>



<style type="text/css">
  @import url(../../fonts/thsarabunnew.css);
  body{ font-family: 'THSarabunNew', sans-serif; font-size: 14px; line-height: 2.1em; background: #e1e1e1; }
  textarea{
      font-family: 'THSarabunNew', sans-serif;
      font-size: 14px;
  }
  @media print {
    .page_breck {page-break-after: always;}
  }

input[type='text']{
  border-style: none;

  height:22px;
}
</style>
<script type="text/javascript">



</script>

</head>
<body>
  <div id="body">
    <form  name="a1" id="a1" method="post" enctype="multipart/form-data"  action="mysql_memo.php" >
<div style="margin:0px auto;width:210mm;background-color: #ffffff;" class="page_breck">
<img src="../../images/thai_government.jpg" style="width:21mm;margin-top: 20px;margin-left: 60px;" >
<div style="font-size: 22px;font-weight:bold;width:350px;margin-left:350px;margin-top: -30px;">บันทึกข้อความ</div>
<div style="margin-left:60px;margin-top: 20px;">ส่วนราชการ  <div style="width:580px;height:30px;margin-left: 90px;margin-top:-28px;"> <input type="text" name="head" value="งานพัสดุ กลุ่มอำนวยการ<?=$co[company_name]?>" style="width:580px;"></div> </div>
<div style="margin-left:60px;margin-top: 3px;">ที่ <div style="width:300px;height:30px;margin-left: 40px;margin-top:-28px;"> <input type="text" name="no" value="<?=$no?>" style="width:300px;"> </div> 
<div style="margin-left: 340px;margin-top: -28px;"> วันที่  <input type="text" name="dateday" value="<?=$dateday1?>" style="width:300px;text-align: center;"></div> </div>
<div style="margin-left:60px;">เรื่อง  <div style="width:630px;height:30px;margin-left: 40px;margin-top:-28px;"> <input type="text" name="detail" value="ขออนุมัติ................." style="width:630px;"></div> </div>
<div style="margin-left:35px;margin-top:5px;width:720px;border-bottom: 1px solid #000000;"></div>
<div style="margin-left:35px;margin-top:5px;width:720px;overflow: auto;" id="textarea_edit">
  <?
  include($_GET["no"].".txt");
  ?>
          </div>
</div>

</form>
</div>




</body>
</html>

<!-- <script src="../dashboard/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> -->
<!-- <script>
  $(function () {
    $('.textarea').wysihtml5()
  })
</script> -->