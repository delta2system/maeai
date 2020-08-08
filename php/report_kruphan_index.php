<?
session_start();
include("connect.inc");
if($_SESSION["xusername"]==""){
  echo("<script>alert('กรุณาทำการล็อกอินก่อนใช้งาน');window.location='login.php'</script>");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>..::รายงานครุภัณฑ์::..</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script src="../js/jquery-1.8.0.min.js"></script>

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
</head>
<body>
  <center>


<fieldset style="width:870px;margin-left: 25px;border:1px solid #E65100;background-color: #FFF3E0;">
<legend style="color:#E65100;">รายงานค่าเสื่อมราคาครุภัณฑ์ประจำเดือน </legend>
<table>
  <td>เดือน</td><td>
    <select name="month" style="font-size: 16px;">
  <option value='1' <?if(date("m")=="01"){echo "selected";}?>>มกราคม</option>
 <option value='2' <?if(date("m")=="02"){echo "selected";}?>>กุมภาพันธ์</option>
 <option value='3' <?if(date("m")=="03"){echo "selected";}?>>มีนาคม</option>
 <option value='4' <?if(date("m")=="04"){echo "selected";}?>>เมษายน</option>
 <option value='5' <?if(date("m")=="05"){echo "selected";}?>>พฤษภาคม</option>
 <option value='6' <?if(date("m")=="06"){echo "selected";}?>>มิถุนายน</option>
 <option value='7' <?if(date("m")=="07"){echo "selected";}?>>กรกฏาคม</option>
 <option value='8' <?if(date("m")=="08"){echo "selected";}?>>สิงหาคม</option>
 <option value='9' <?if(date("m")=="09"){echo "selected";}?>>กันยายน</option>
 <option value='10' <?if(date("m")=="10"){echo "selected";}?>>ตุลาคม</option>
 <option value='11' <?if(date("m")=="11"){echo "selected";}?>>พฤศจิกายน</option>
 <option value='12' <?if(date("m")=="12"){echo "selected";}?>>ธันวาคม</option>
    </select>
  </td><td>ปี</td><td><input type="text" name="year" style="width:80px;text-align: center;font-size: 16px;" value="<?=date('Y')+543?>"></td>
  <td><button onclick="sent_m()">ค้นหา</button></td>
</table>
</fieldset>

<fieldset style="width:870px;margin-left: 25px;border:1px solid #E65100;background-color: #FFF3E0;">
<legend style="color:#E65100;">รายงานครุภัณฑ์จากการได้มา</legend>
<table>
  </td><td>ปี</td><td><input type="text" name="yearp" style="width:80px;text-align: center;font-size: 16px;" value="<?=date('Y')+543?>"></td>
  <td><button onclick="sent_r()">ค้นหา</button></td>
</table>
</fieldset>
</body>
</html>
<script type="text/javascript">
  function sent_m(){
    window.location='report_kharuphanth_month.php?month='+$("select[name=month]").val();+'&year='+$("input[name=year]").val();
  }
  function sent_r(){
    window.open('report_storem.php?year='+$("input[name=yearp]").val(),'_blank');
  }
</script>