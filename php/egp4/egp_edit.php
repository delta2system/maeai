<?
session_start();
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
setTimeout('print_page()', 2000);
}

function print_page(){
$('.btn').hide();
window.print();
}

function del_text_final(no){
  $.ajax({
      type: "POST",
      url: "mysql_egp.php",
      data: "submit=del_egp&no="+no ,
      cache: false,
      success: function(data)
        {
          alert(data);
          window.close();
        }         
     });
}

</script>

</head>
<body>
  <div id="body">
<?
if($_GET["no"]){
include($_GET["no"].".txt");
}
?>
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
  <li class="btn btn-success" onclick="save_text_final()">แก้ไข</li>&nbsp;&nbsp;&nbsp;<li class="btn btn-danger" onclick="del_text_final('<?=$_GET["no"]?>')">ลบ</li>&nbsp;&nbsp;&nbsp;<li class="btn btn-info" onclick="$('.btn').hide();window.print();">print</li>
 
</div>
 <iframe id="ifream_target" name="ifream_target" src="" style="position:absolute;width:0px;height:0px;border:0px solid #000000;"></iframe>
</body>
</html>
