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
  	var y = $("select[name=year]").val();
  	var m = $("select[name=month]").val();
  	var t = $("select[name=trimas]").val();
    var left = (screen.width/2)-(800/2);
     var top = (screen.height/2)-(600/2);
   //alert(y+"-"+m+"-"+t);

  	if(y!="" && m!="" && t!=""){
  		//alert("OK1");
 	 window.open("report_warehouse_out.php?year="+y+"&month="+m+"&trimas="+t,"_blank","toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=1100,height=600");	
  	}else if(y!="" && m!="" ){
  		//alert("OK2");
  	 window.open("report_warehouse_out.php?year="+y+"&month="+m,"_blank","toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=1100,height=600");
  	}else if(y!="" && t!="" ){
  		//alert("OK2");
  	 window.open("report_warehouse_out.php?year="+y+"&trimas="+t,"_blank","toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=1100,height=600");
  	}else if(y!="" ){
  		//alert("OK3");
     window.open("report_warehouse_out.php?year="+y,"_blank","toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=1100,height=600");
  	}

  }
</script>
</head>
<body>
  <center>


<fieldset style="width:870px;margin-left: 25px;border:1px solid #E65100;background-color: #FFF3E0;">
<legend style="color:#E65100;">รายงานวัสดุคลังนอก </legend>

<table>
	<td>รายงานซื้อวัสดุนอกคลัง</td><td>ปีงบประมาณ</td><td><select name="year">
		<option><?=date("Y")+543?></option>
		<option><?=date("Y")+542?></option>
		<option><?=date("Y")+541?></option>
		<option><?=date("Y")+540?></option>
		<option><?=date("Y")+539?></option>
	</select></td>
	<tr><td></td><td>ประจำเดือน</td><td>	<select name="month">
		<option></option>
	<?
	for ($i=1; $i<=12 ; $i++) { 
		print "<option value='$i'>".Month($i)."</option>";
	}
	?>
	</select></td></tr>
	<tr><td></td><td>ไตรมาส</td><td>	<select name="trimas">
		<option></option>
		<option value="all">ทังหมด</option>
	<?
	for ($i=1; $i<=4 ; $i++) { 
		print "<option value='$i'>ที่ ".$i."</option>";
	}
	?>
	</select></td></tr>
	<tr><td colspan="3" style="text-align: center;"><button style="font-size: 16px;padding:3px 50px;" onclick="search1()">ค้นหา</button></td></tr>
</table>

</fieldset>


</body>
</html>
<script type="text/javascript">

  function product_autocom(autoObj,showObj){
  var mkAutoObj=autoObj; 
  var mkSerValObj=showObj; 
  new Autocomplete(mkAutoObj, function() {
    this.setValue = function(id) {    
      document.getElementById(mkSerValObj).value = id;
      if(id!=""){
     var tx = $("#barcode").val();
      check_product(tx);
      $("#barcode").val("");
      $("#detail").val("");
      }
    }
    if ( this.isModified )
      this.setValue("");
   // if ( this.value.length < 1 && this.isNotClick ) 
   if ( this.value.length < 1 ) 
      return ;  
    return "auto/gdata.php?product=" +encodeURIComponent(this.value);
    }); 
}




// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");

product_autocom("barcode","detail");




</script>



        <script type="text/javascript" src="../js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
        <link type="text/css" href="../css/jquery-ui-1.8.10.custom.css" rel="stylesheet" /> 
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
       </script>

