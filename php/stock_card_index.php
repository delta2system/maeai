<?
session_start();
include("connect.inc");
if($_SESSION["xusername"]==""){
  echo("<script>alert('กรุณาทำการล็อกอินก่อนใช้งาน');window.location='login.php'</script>");
}
// if($_GET["dateday"]){
//   $dateday=$_GET["dateday"];
// }else{
//   $dateday=date("d-m-").(date("Y")+543);
// }
// unset($_SESSION["d_day"]);
// unset($_SESSION["d_department"]);
// unset($_SESSION["d_to"]);


function Month($str){
switch($str)
{
case "01": $str = "มกราคม"; break;
case "02": $str = "กุมภาพันธ์"; break;
case "03": $str = "มีนาคม"; break;
case "04": $str = "เมษายน"; break;
case "05": $str = "พฤษภาคม"; break;
case "06": $str = "มิถุนายน"; break;
case "07": $str = "กรกฏาคม"; break;
case "08": $str = "สิงหาคม"; break;
case "09": $str = "กันยายน"; break;
case "10": $str = "ตุลาคม"; break;
case "11": $str = "พฤศจิกายน"; break;
case "12": $str = "ธันวาคม"; break;
}
return $str;
}

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

     select{
     	font-size: 18px;
     }
  </style>
  <script type="text/javascript">
    function search1(){
      var year =  parseFloat(document.getElementById("year").value);
      //var month = document.getElementById("month").value;
      var barcode = document.getElementById("barcode").value;

      var date1 = (year-1)+"-10-01";
      var date2 = year+"-09-30";
      //alert(date1);
     //window.location='stock_card_print.php?date1='+date1+'&date2='+date2;
      //  window.open('stock_card_print.php?date1='+date1+'&date2='+date2);
       window.open("stock_card_print.php?date1="+date1+"&date2="+date2+"&barcode="+barcode,"_blank","toolbar=no,scrollbars=yes,resizable=yes,width=950,height=600");

    }

  </script>

</head>
<body>
  <center>


<fieldset style="width:870px;margin-left: 25px;border:1px solid #E65100;background-color: #FFF3E0;">
<legend style="color:#E65100;">รายงานสต็อกการ์ด</legend>

<table>
	<td>รายงานสต็อกการ์ด</td><td>ปีงบประมาณ</td><td><select id="year">
		<option><?=date("Y")+543?></option>
		<option><?=date("Y")+542?></option>
		<option><?=date("Y")+541?></option>
		<option><?=date("Y")+540?></option>
		<option><?=date("Y")+539?></option>
	</select></td>
	<!-- <tr><td></td><td>ประจำเดือน</td><td>	<select id="month">
		<option></option>
	<?
	for ($i=1; $i<=12 ; $i++) { 
		print "<option value='$i'>".Month($i)."</option>";
	}
	?>
	</select></td></tr> -->
  <tr><td></td><td>พัสดุ</td><td><input type="hidden" id="barcode" value=""><input type="text" id="detail" onkeyup="if(this.value==''){$('#barcode').val('');}" style="font-size: 16px;padding:5px;border:1px solid #c0c0c0;border-radius: 5px;"></td></tr>
	<tr><td colspan="3" style="text-align: center;"><button style="font-size: 16px;padding:3px 50px;" onclick="search1()">ค้นหา</button></td></tr>
</table>

</fieldset>


</body>
</html>



<?



$states="";
$sql = "SELECT detail,barcode from stock_product  where 1 GROUP By barcode ";
$results = mysql_query($sql);
while ($row = mysql_fetch_array( $results )) {

  $s++;
  if($s>1){  $states.=",";  }
  $states.="{value:\"".str_ireplace("&#39;","'",$row[detail])."\",detail:\"$row[detail]\",barcode:\"$row[barcode]\"}";
}
$states.="";


?>
  <link rel="stylesheet" href="../bootstrap/datepick/jquery-ui.css">
<script src="../bootstrap/datepick/jquery-ui.js"></script>
<script type="text/javascript">

            $(function () {

document.onkeydown = chkEvent 
function chkEvent(e) {
  var keycode;
  if (window.event) keycode = window.event.keyCode; //*** for IE ***//
  else if (e) keycode = e.which; //*** for Firefox ***//
  if(keycode==13)
  {
    return false;
  }
}

                $("#detail").autocomplete({
                    source: [<?echo $states;?>],
                    select: function( event, ui ) {
                      $("#detail").val(ui.item.detail.replace("&#39;", "'"));
                      //$("#pcs").focus();
                      $("#barcode").val(ui.item.barcode);


                      
                    }
                }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
        .append( "<div style='border-bottom:1px solid #a0a0a0;'><span style='color:#909090;'> รหัส : " + item.barcode + "</span><br>ชื่อ : " + item.detail + "</div>" )
        .appendTo( ul );
    };


                });



        </script>



   
