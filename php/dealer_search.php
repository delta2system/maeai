<?
session_start();
     //if (empty($xUser)){echo "<script>alert('กรุณา ลงทะเบียนก่อนการใช้งาน!!!!')</script>";
      //echo "<script> window.location='../index.php'</script>";};
include("connect.inc");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>.::Ware House::.</title>
        <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
        <style type="text/css">

     @import url(../fonts/thsarabunnew.css);
    body{
    font-family: 'THSarabunNew', tahoma;
    font-weight: bold;
    font-size: 14px;
    }
        select,input[type="text"]{
    font-family: 'THSarabunNew', tahoma;
    font-weight: bold;
    font-size: 14px;
    width:190px;
    padding-left:10px; 
    border:1px solid #aaa;
    }
    input[type="submit"],button{
    font-family: 'THSarabunNew', tahoma;
    font-weight: bold;
    font-size: 14px;
    width:200px;
    cursor: pointer;
    }
        .top_bar{
        border-style: solid;
        border-width: 1px;
        border-color: #909090;
        background-color:#e0e0e0;
        padding: 5px 0px 5px 0px;
        box-shadow: 0 1px 0 rgba(0, 0, 0, .3),
              0 2px 2px -1px rgba(0, 0, 0, .5),
              0 1px 0 rgba(255, 255, 255, .3) inset;
    }
    table{
    	border-collapse: collapse;
    }
    	.choise{
    		cursor: pointer;
    	}
     	.choise:hover{
    		background-color: rgba(180,255,100,0.5);
    	}   	
        </style>
        <script type="text/javascript">
		function select (ex) {

			var bc=document.getElementById("row_id"+ex).value;
			var dt=document.getElementById("nameltd"+ex).value;
            //alert(dt);

			window.opener.document.getElementById("companyltd").value = bc;
  			window.opener.document.getElementById("nameltd").value = dt;
  			window.close();
		}
    function add_supplier(){
        document.getElementById("add_pro").style.display='';
    }
    function close_popup(){
        document.getElementById("add_pro").style.display='none';
    }
    function add_p2(){

        var nx2=document.getElementById("nameltd").value;
        var ax1=document.getElementById("address").value;
        var px3=document.getElementById("phone").value;
        var fx1=document.getElementById("fax").value;

    $.ajax({
    type: "POST",
    url: "add_supplier_json.php",
    data: "nameltd="+nx2+"&address="+ax1+"&phone="+px3+"&fax="+fx1,
    cache: false,
    success: function(html)
    {
          window.opener.document.getElementById("nameltd").value = nx2;
          window.opener.document.getElementById("companyltd").value = html;
          window.close();
    }
    });


    }
        </script>
        </head>
        <body>
        <form name="b1" method="POST" action="">
        	<fieldset style="width:1150px;"><legend>.::ค้นหาชื่อบริษัท::.</legend>
        	<center>
        	<table>
        		<td>ชื่อบริษัท</td><td><input type="text" name="nameltd" autofocus></td><tr>
        		<td></td><td><input type="submit" name="submit" value="ค้นหา" style="padding:5px 15px;"></td><tr>
                <td></td><td align="center"><span style='color:blue;cursor:pointer;' onclick='add_supplier()'>เพิ่ม บริษัทห้างร้าน++</span></td>
        	</table><br><br>
        	<?
        	if($_POST["submit"]){
        		$search="1";
        		if($_POST["nameltd"]){
        		$search.=" AND name like '%".$_POST["nameltd"]."%'";	
        		}

        		print "<table width='100%'>";
        		print "<tr align='center'>";
        		print "<td class='top_bar'>ลำดับ</td>";
        		print "<td class='top_bar'>ชื่อบริษัท</td>";
        		// print "<td class='top_bar'>ชื่อผู้ติดต่อ</td>";
        		print "<td class='top_bar'>ที่อยู่</td>";
        		print "<td class='top_bar'>โทรศัพท์ </td>";
        		print "<td class='top_bar'>แฟกซ์</td>";


			$sql = "SELECT * from customer_supply where $search ORDER By row_id DESC  ";
			$result = mysql_query($sql);
			while ($row = mysql_fetch_array($result) ) {
				$t++;
        		print "<tr align='center' class='choise'>";
        		print "<td class='top_bar'>$t <input type='hidden' name='row_id$t' id='row_id$t' value='$row[row_id]'></td>";
        		print "<td class='choise' align='left' onclick='select(\"$t\")'>&nbsp;&nbsp; $row[name] <input type='hidden' name='nameltd$t' id='nameltd$t' value='$row[name]'></td>";
        		// print "<td class='choise' align='left' onclick='select(\"$t\")'>$row[name_att] </td>";
        		print "<td class='choise' onclick='select(\"$t\")' style='text-align:left;'>&nbsp;&nbsp; $row[address] </td>";
        		print "<td class='choise' onclick='select(\"$t\")' style='text-align:left;'>&nbsp;&nbsp; $row[phone]</td>";
        		print "<td class='choise' onclick='select(\"$t\")' style='text-align:left;'>&nbsp;&nbsp; $row[fax]</td>";
      
			}

        	}
        	?>
        	</table>
        	</fieldset>
        	</form>
        </body>
        </html>

    <div id="add_pro" style='position:absolute;width:100%;height:100%;left:0px;top:0px;background:rgba(0,0,0,0.6);display:none;'>
    <div style='position:absolute;width:400px;height:70%;background-color:#fff;left:50%;margin-left:-220px;top:5%;border-radius:25px;padding:50px;'>
        <div style="position:absolute;margin-top:-60px;left:470px;"><img src="../images/box_close.png" width="30px" style="cursor:pointer;" onclick="close_popup()"></div>
        <table width="100%">

            <td colspan="2" style="font-size:36px;background-color:#96ceb4;text-align:center;font-weight:bold;color:#fff;">เพิ่มบริษัท/ห้างร้าน</td><tr>
            <td style="text-align:right;">ชื่อบริษัท/ห้างร้าน :</td><td><input type="text" name="nameltd" id="nameltd"></td><tr>
            <td style="text-align:right;">ที่อยู่ :</td><td><textarea style="width:200px;"  rows="6" name="address" id="address"></textarea></td><tr>
            <td style="text-align:right;">โทรศัพท์ :</td><td><input type="text" name="phone" id="phone"></td><tr>
            <td style="text-align:right;">แฟกซ์ :</td><td><input type="text" name="fax" id="fax"></td><tr>
            <td style="height:50px;" colspan="2" align="center"><button onclick="add_p2()">เพิ่ม</button></td>
            </table>
    </div>
</div>