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
	<title>Position</title>
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
                data: 'submit=return_type_group&row_id='+rx,
            })
            .success(function(result) {
            	//alert(result);
            var obj = jQuery.parseJSON(result);
           if(obj != ''){$.each(obj, function(key, val) {

           	$("input[name=type_code]").val(val["code"]);
           	$("input[name=type_detail]").val(val["detail"]);
           	$("input[name=type_code]").css({"border":"0px"});
           	$("input[name=type_code]").attr('readonly', true);
           });}
              });

            $("#display_edit").show();
            $("#display_user").hide();
		}

		function add_group(){
			$("input[name=type_code]").css({"border":"1px solid #a0a0a0"});
			$("input[name=type_code]").removeAttr('readonly');
			$("input[name=type_code]").val("");
           	$("input[name=type_detail]").val("");
           	$("#display_edit").show();
           	$("#display_user").hide();
		}


		function save_group_type(){
			var data = "&code="+$("input[name=type_code]").val();
				data = data + "&detail=" + $("input[name=type_detail]").val();
          $.ajax({ 
                url: "mysql_maneger.php" ,
                type: "POST",
                data: 'submit=save_group_type'+data,
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

		function del_group(){

			var r = confirm("คุณต้องารลบประเภทสินค้า ใช่หรือไม่ \n *หมายเหตุ การลบจะไม่สามารถเรียกคืนมาได้");
			if(r==true){
			var data = "&code="+$("input[name=type_code]").val();

   			$.ajax({ 
                url: "mysql_maneger.php" ,
                type: "POST",
                data: 'submit=del_group_type'+data,
            })
            .success(function(result) {
            	//alert(result);
            	location.reload();
              });

		}
}


	</script>
</head>
<body>
<div style="width:100%;height:100px;left:0px;top:0px;background-color:#0080ff;"><br><br>
	<div style="margin:0px auto;width:400px;height:80px;font-size: 30px;color:#ffffff;text-align: center;"> <i class="fa fa-braille"></i>  | เพิ่ม/แก้ไขประเภทสินค้า</div>
</div>
<img src="../images/group_type_icon.png" style="width:300px;">

<div id="display_user" style="position:absolute;top:140px;right:0px;margin:0px auto;width:70%;height:400px;">
	<div>
			<table style="width:600px;">
				<thead style="background-color:#ff80bf;">
					<td style="text-align: center;padding:7px 20px;border:1px solid #ff1a8c;">รหัส</td>
					<td style="text-align: center;padding:7px 20px;border:1px solid #ff1a8c;">ประเภทสินค้า</td>
				</thead>
				<tbody>
				<?
				$sql_o = "SELECT * FROM group_type ORDER By code ASC";
				$result = mysql_query($sql_o);
				while ($data = mysql_fetch_assoc($result)) {

				print "<tr>".
					  "<td style='text-align:center;border:1px solid #a0a0a0;padding:5px 0px;'>$data[code]</td>".
					  "<td style='border:1px solid #a0a0a0;padding:5px 0px;'>&nbsp;&nbsp;".$data[detail]."</td>".
					  "<td style='padding:5px 0px;'>&nbsp;&nbsp;<span class='menu_bt' onclick=\"edit_d('$data[row_id]')\">แก้ไข</span></td>";
				}
				?>	
				</tbody>
			</table>
       <div style="width:500px;text-align: center;padding-top:30px;"><span class="menu_bt" onclick="add_group()">เพิ่ม</span></div>
	</div>
</div>


<div id="display_edit" style="display:none;width:70%;height:400px;background-color: #ffffff;position: absolute;top:120px;right: 0px;">
	<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-desktop"></i> | เพิ่ม/แก้ไข </div>
	<div style="margin-top:20px;color:#3385ff; "> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รหัส : <input type="text" name="type_code" style="width:285px;font-size: 15px;padding: 5px 5px;color:#555555;"></div>
	<div style="margin-top:20px;color:#3385ff; "> ประเภทพัสดุ : <input type="text" name="type_detail" style="width:285px;font-size: 15px;padding: 5px 5px;color:#555555;"></div>


	<div style="width:500px;text-align: center;padding-top:30px;">
		<span class="menu_bt" onclick="save_group_type()">บันทึก</span>
		<span class="menu_bt" onclick="del_group()">ลบ</span>
		<span class="menu_bt" onclick="$('#display_edit').hide();$('#display_user').show();">ยกเลิก</span>
	</div>


</div>
</body>
</html>
