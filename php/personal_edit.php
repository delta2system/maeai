<?
session_start();
include("connect.inc");

function ps_detail($str){
$sql = "SELECT position_detail from position_personal where code = '$str'  limit 1  ";
list($position_detail) = Mysql_fetch_row(Mysql_Query($sql));
return $position_detail;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Profile</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script src="../js/jquery-1.8.0.min.js"></script>
	<link rel="stylesheet" href="dashboard/bower_components/font-awesome/css/font-awesome.min.css">
	<style type="text/css">
		.menu_bt{
			border: 1px solid #aeaeae;padding:3px 15px;width:160px;background-color: #f0f0f0;cursor: pointer;
		}
		.menu_bt:hover{
			color:#4d94ff;
			background-color: #cce0ff;

		}
		table{
			border-collapse: collapse;
		}
	</style>
	<script type="text/javascript">
		function edit_d(rx){
			

		 $.ajax({ 
                url: "mysql_maneger.php" ,
                type: "POST",
                data: 'submit=return_personal&row_id='+rx,
            })
            .success(function(result) {
            	//alert(result);
            var obj = jQuery.parseJSON(result);
           if(obj != ''){$.each(obj, function(key, val) {

           	$("input[name=persanal_code]").val(val["code"]);
           	$("input[name=persanal_name]").val(val["name"]);
           	$("select[name=position_x]").val(val["position"]);

           	$("input[name=persanal_code]").css({"border":"0px"});
           	$("input[name=persanal_code]").attr('readonly', true);
           });}
              });

            $("#display_edit").show();
            $('#display_user').hide();
		}

		function add_personal(){
			$("input[name=persanal_code]").css({"border":"1px solid #a0a0a0"});
			$("input[name=persanal_code]").removeAttr('readonly');
			$("input[name=persanal_code]").val("");
           	$("input[name=persanal_name]").val("");
           	$("select[name=position_x]").val("");
           	$("#display_edit").show();
           	$('#display_user').hide();
		}


		function save_personal(){
			var data = "&code="+$("input[name=persanal_code]").val();
				data = data + "&name=" + $("input[name=persanal_name]").val();
				data = data + "&position=" + $("select[name=position_x]").val();

          $.ajax({ 
                url: "mysql_maneger.php" ,
                type: "POST",
                data: 'submit=save_personal'+data,
            })
            .success(function(result) {
            	//alert(result);
       //        var obj = jQuery.parseJSON(result);
       //        if(obj != ''){$.each(obj, function(key, val) {
       //        	alert(val["status"]);
   				if(result=="true"){
   					alert("บันทึกเรียบร้อยแล้ว");
   					//$("#display_edit").hide();
   					location.reload();
   				}else{
   					alert("ไม่สามารถบันทึกข้อมูลได้");
   				}

       //        });}
              });
		}

		function del_personal(){

			var r = confirm("คุณต้องารลบรหัส/ชื่อพนักงาน ใช่หรือไม่ \n *หมายเหตุ การลบรหัสพนักงานไปแล้วจะไม่สามารถเรียกคืนมาได้");
			if(r==true){
			var data = "&code="+$("input[name=persanal_code]").val();

   			$.ajax({ 
                url: "mysql_maneger.php" ,
                type: "POST",
                data: 'submit=del_personal'+data,
            })
            .success(function(result) {
            	location.reload();
              });

		}
}


	</script>
</head>
<body>
<div style="width:100%;height:100px;left:0px;top:0px;background-color:#0080ff;"><br><br>
	<div style="margin:0px auto;width:400px;height:80px;font-size: 30px;color:#ffffff;text-align: center;"> <i class="fa fa-braille"></i>  | เพิ่มรายชื่อพนักงาน</div>
</div>
<img src="../images/personal_icon.png" style="width:300px;">

<div id="display_user" style="position:absolute;top:140px;right:0px;margin:0px auto;width:70%;height:400px;">
	<div>
			<table style="width:600px;">
				<thead style="background-color:#00ff80;">
					<td style="text-align: center;padding:7px 20px;border:1px solid #2eb82e;">รหัส</td>
					<td style="text-align: center;padding:7px 20px;border:1px solid #2eb82e;">ชื่อ-สกุล</td>
					<td style="text-align: center;padding:7px 20px;border:1px solid #2eb82e;">ตำแหน่ง</td>
				</thead>
				<tbody>
				<?
				$sql_o = "SELECT * FROM personal ORDER By code ASC";
				$result = mysql_query($sql_o);
				while ($data = mysql_fetch_assoc($result)) {

				print "<tr>".
					  "<td style='text-align:center;border:1px solid #a0a0a0;padding:5px 0px;'>$data[code]</td>".
					  "<td style='border:1px solid #a0a0a0;padding:5px 0px;'>&nbsp;&nbsp;$data[name]</td>".
					  "<td style='border:1px solid #a0a0a0;padding:5px 0px;'>&nbsp;&nbsp;".ps_detail($data[position])."</td>".
					  "<td style='padding:5px 0px;'>&nbsp;&nbsp;<span class='menu_bt' onclick=\"edit_d('$data[row_id]')\">แก้ไข</span></td>";
				}
				?>	
				</tbody>
			</table>
       <div style="width:500px;text-align: center;padding-top:30px;"><span class="menu_bt" onclick="add_personal()">เพิ่ม</span></div>
	</div>
</div>


<div id="display_edit" style="display:none;width:70%;height:400px;background-color: #ffffff;position: absolute;top:120px;right: 0px;">
	<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-desktop"></i> | แก้ไข </div>
	<div style="margin-top:20px;color:#3385ff; "> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รหัส : <input type="text" name="persanal_code" style="width:285px;font-size: 15px;padding: 5px 5px;color:#555555;"></div>
	<div style="margin-top:20px;color:#3385ff; "> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ชื่อ : <input type="text" name="persanal_name" style="width:285px;font-size: 15px;padding: 5px 5px;color:#555555;"></div>
	<div style="margin-top:20px;color:#3385ff; "> ตำแหน่ง : 
			<select name="position_x" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;">
				<?
				$sql_o = "SELECT * FROM position_personal ORDER By row_id ASC";
				$result = mysql_query($sql_o);
				while ($data = mysql_fetch_assoc($result)) {
				print "<option value='$data[code]' >$data[position_detail]</option>";	
				}
				?>
			</select>

	</div>

	<div style="width:500px;text-align: center;padding-top:30px;">
		<span class="menu_bt" onclick="save_personal()">บันทึก</span>
		<span class="menu_bt" onclick="del_personal()">ลบ</span>
		<span class="menu_bt" onclick="$('#display_edit').hide();$('#display_user').show();">ยกเลิก</span>
	</div>


</div>
</body>
</html>
