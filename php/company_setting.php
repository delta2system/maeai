<?php
session_start();
include("connect.inc");
if($_SESSION["xusername"]==""){
  echo("<script>alert('กรุณาทำการล็อกอินก่อนใช้งาน');window.location='login.php'</script>");
}

?>
<!DOCTYPE html>
<html>
<head>
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
	</style>
	<script type="text/javascript">
		function upload() {
			$("#display_upload").show();
		}

		function save_company(){
			var data = "&company_name="+$("input[name=company_name]").val();
				data = data + "&address=" + $("input[name=address]").val();
				data = data + "&phone=" + $("input[name=phone]").val();
				data = data + "&fax=" + $("input[name=fax]").val();
				data = data + "&web=" + $("input[name=web]").val();

          $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=edit_company'+data,
            })
            .success(function(result) {
            	//alert(result);
       //        var obj = jQuery.parseJSON(result);
       //        if(obj != ''){$.each(obj, function(key, val) {
       //        	alert(val["status"]);
   				if(result=="true"){
   					alert("บันทึกเรียบร้อยแล้ว");
   				}else{
   					alert("ไม่สามารถบันทึกข้อมูลได้");
   				}

       //        });}
              });
		}
	</script>
</head>
<body>
<div style="width:100%;height:100px;left:0px;top:0px;background-color:#26A69A;"><br><br>
	<div style="margin:0px auto;width:400px;height:50px;font-size: 30px;color:#ffffff;text-align: center;">ข้อมูลหน่วยงาน</div>
</div>
<div style="float: left;width:30%;height:400px;">
<?
$sql = "SELECT tbl_value from tbl_company where tbl_title = 'logo'  limit 1  ";
list($tbl_logo) = Mysql_fetch_row(Mysql_Query($sql));
if(empty($tbl_logo)){
$logo='';
}else{
$logo="../images/".$tbl_logo;
}


print "<div style='border-radius:100px;width:200px;height:200px;border:1px solid #99d6ff;margin-top:10px;overflow: hidden;' onclick='upload()' onmouseover=\"$(this).css({'box-shadow': '0px 0px 20px #0099ff'})\" onmouseout=\"$(this).css({'box-shadow': 'none'})\"'>";
print "<img id='image_logo' src='".$logo."' style='cursor:pointer;height:200px;' >";
print "</div>";

?>
<div class="menu_bt" onclick="$('#display_upload').hide()" style="color:#737373;margin-top: 50px;"> <i class="fa fa-user " ></i> | ข้อมูลหน่วยงาน <span style="float: right;">></span></div>
</div>

<div id="display_user" style="position:absolute;right:0px;width:70%;height:400px;">
<!-- 	<div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-braille"></i></div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-envelope-o"></i> ชื่อหน่วยงาน : <input type="text" name="email" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;" value="<?=$email?>"></div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-address-card-o"></i> ที่อยู่ : <input type="text" name="fullname" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;" value="<?=$fullname?>"></div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-address-card-o"></i> เบอร์โทรศัพท์ : <input type="text" name="fullname" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;" value="<?=$fullname?>">
			
			</div>
        <div style="width:300px;text-align: center;padding-top:30px;"><span class="menu_bt" onclick="save_profile()">บันทึก</span></div>
	</div> --><?
$sql = "SELECT * from tbl_company ";
$result = mysql_query($sql);
$arrCol=array();
while ($row = mysql_fetch_array($result) ) {
	$arrCol["$row[tbl_title]"]=$row["tbl_value"];
}

	?>
	<table style="width:100%;border-collapse: collapse;margin-top: 30px;">
		<!-- <td colspan="2" style="text-align: center;"></td> -->
		<tr><td style="text-align: right;width: 150px;padding:10px 0px;color:#3385ff;">ชื่อหน่วยงาน : </td><td><input type="text" name="company_name"  value="<?=$arrCol[company_name]?>" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;"></td></tr>
		<tr><td style="text-align: right;width: 150px;padding:10px 0px;color:#3385ff;">ที่อยู่ : </td><td><input type="text" name="address" value="<?=$arrCol[address]?>"style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;"></td></tr>
		<tr><td style="text-align: right;width: 150px;padding:10px 0px;color:#3385ff;">เบอร์โทรศัพท์ : </td><td><input type="text" name="phone" value="<?=$arrCol[phone]?>" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;"></td></tr>
		<tr><td style="text-align: right;width: 150px;padding:10px 0px;color:#3385ff;">แฟกซ์ : </td><td><input type="text" name="fax" value="<?=$arrCol[fax]?>" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;"></td></tr>
		<tr><td style="text-align: right;width: 150px;padding:10px 0px;color:#3385ff;">เว็บไซค์ : </td><td><input type="text" name="web" value="<?=$arrCol[web]?>" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;"></td></tr>
		<tr><td colspan="2">
			<span class="menu_bt" onclick="save_company()">บันทึก</span>
		</td></tr>
	</table>	
</div>
<div id="display_upload" style="display:none;width:70%;height:400px;background-color: #ffffff;position: fixed;right: 0px;margin-top: 20px;">
	<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-desktop"></i> | เปลี่ยนรูปโลโก้ </div><br>
	<form id="uploadimage" action="upload_img_profile.php?" method="post" enctype="multipart/form-data" target="iframe_upload" onclick="imagesupdate()">
	<div style="border-radius:100px;width:200px;height:200px;border:1px solid #99d6ff;overflow: hidden;"><img src="<?=$image_profile?>" id="imagepreview" style="height:200px;"></div><br>
	<div><input type="file" name="fileUploadLogo" onchange="imagespreview(this)"></div>
	<div style="width:300px;text-align: center;padding-top:30px;"><input type="submit" name="submit" class="menu_bt" value="อัพโหลดรูปโปรไฟล์" style="font-size: 16px;" ></div>
</form>
<iframe src="" id="iframe_upload" name="iframe_upload"  style="border:0px solid #000000;"></iframe>
</div>
</body>
</html>
<script type="text/javascript">
		       function imagespreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imagepreview')
                        .attr('src', e.target.result);
                    //    imagesupdate();
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
                function imagesupdate() {
        	//var input = $("input[name=fileUpload]").files
            if ($("input[name=fileUploadLogo]").files && $("input[name=fileUploadLogo]").files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image_logo')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL($("input[name=fileUploadLogo]").files[0]);
            }
        }
</script>