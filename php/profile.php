<?
session_start();
include("connect.inc");
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
	</style>
	<script type="text/javascript">
		function show1(){
			$("#display_user").show();
			$("#display_password").hide();
			$("#display_upload").hide();
		}
		function show2(){
			$("#display_user").hide();
			$("#display_password").show();
			$("#display_upload").hide();
		}
		function upload(){
			$("#display_user").hide();
			$("#display_password").hide();
			$("#display_upload").show();
		}

		function save_profile(){
			var data = "&email="+$("input[name=email]").val();
				data = data + "&fullname=" + $("input[name=fullname]").val();
				data = data + "&position=" + $("select[name=position_x]").val();

          $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=edit_profile'+data,
            })
            .success(function(result) {
            	//alert(result);
       //        var obj = jQuery.parseJSON(result);
       //        if(obj != ''){$.each(obj, function(key, val) {
       //        	alert(val["status"]);
   				if(result=="true"){
   					alert("บันทึกเรีัยบร้อยแล้ว");
   				}else{
   					alert("ไม่สามารถบันทึกข้อมูลได้");
   				}

       //        });}
              });
		}

		function check_pass(th){
			var ps1 = $("#new_password").val();
			if(th!=""){
				if(th==ps1){
					$("#chk_ps").html("<i class='fa fa-check-circle-o' style='color:#00ff00;' ></i>");
				}else{
					$("#chk_ps").html("<i class='fa fa-remove' style='color:#ff0000;' ></i>");
				}
			}else{
				$("#chk_ps").html("");
			}
		}

		function change_password(){

			var ps1 = $("#new_password").val();
			var ps2 = $("#verify_password").val();
			if(ps1==ps2){
			var data = "&old_password="+$("#old_password").val();
				data = data + "&new_password="+ps1;
            $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=edit_password'+data,
            })
            .success(function(result) {
            	//alert(result);
              var obj = jQuery.parseJSON(result);
              if(obj != ''){
              	$.each(obj, function(key, val) {

              		if(val["status"]=="true"){
              			alert(val["Messenger"]);

              			//parent.document.body.style.backgroundColor = "red";
              			//window.location='login.php?logout=Y';
              			parent.signout();
              		}else{
              			alert(val["Messenger"]);
              		}


              });
          }
              });
		}else{
			alert("รหัสผ่านยืนยันไม่ถูกต้อง");
		}
	}
	</script>
</head>
<body>
<div style="width:100%;height:150px;left:0px;top:0px;background-color:#039BE5;"><br><br><br>
	<div style="margin:0px auto;width:400px;height:80;font-size: 30px;color:#ffffff;text-align: center;">ข้อมูลส่วนตัว</div>
</div>
<div style="float: left;width:30%;height:400px;">
<?
$sql = "SELECT image_profile,email,fullname,position from user_account where username = '".$_SESSION["xusername"]."'  limit 1  ";
list($image_profile,$email,$fullname,$position) = Mysql_fetch_row(Mysql_Query($sql));
if(empty($image_profile)){
$image_profile='dashboard/dist/img/user2-160x160.jpg';
}else{
$image_profile="../images/img_profile/".$image_profile;
}

print "<div style='border-radius:100px;width:200px;height:200px;border:1px solid #99d6ff;margin-top:10px;overflow: hidden;' onclick='upload()' onmouseover=\"$(this).css({'box-shadow': '0px 0px 20px #0099ff'})\" onmouseout=\"$(this).css({'box-shadow': 'none'})\"'>";
print "<img id='image_profile' src='".$image_profile."' style='cursor:pointer;height:200px;' >";
print "</div>";

?>
<br><br>
<div class="menu_bt" onclick="show1()" style="color:#737373;"> <i class="fa fa-user " ></i> | ข้อมูลส่วนตัว <span style="float: right;">></span></div>

<div class="menu_bt" onclick="show2()" style="color:#737373;margin-top: 10px;"> <i class="fa fa-lock"></i> | เปลี่ยนรหัสผ่าน <span style="float: right;">></span></div>
</div>
<div id="display_user" style="float: right;width:70%;height:400px;">
	<div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-braille"></i> | ข้อมูลส่วนตัว </div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-user"></i> User : <span style="font-size: 15px;padding: 5px 5px;color:#555555;"><?=$_SESSION["xusername"]?></span></div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-envelope-o"></i> อีเมลล์ : <input type="text" name="email" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;" value="<?=$email?>"></div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-address-card-o"></i> ชื่อ-สกุล : <input type="text" name="fullname" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;" value="<?=$fullname?>"></div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-address-card-o"></i> ตำแหน่ง : 
			<select name="position_x" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;">
				<?
				$sql_o = "SELECT * FROM position_personal ORDER By row_id ASC";
				$result = mysql_query($sql_o);
				while ($data = mysql_fetch_assoc($result)) {
				if($position==$data[code]){
				print "<option value='$data[code]' selected >$data[position_detail]</option>";	
			}else{
				print "<option value='$data[code]'>$data[position_detail]</option>";
			}
				}
				?>
			</select>

			</div>
        <div style="width:300px;text-align: center;padding-top:30px;"><span class="menu_bt" onclick="save_profile()">บันทึก</span></div>
	</div>
</div>

<div id="display_password" style="display:none;width:70%;height:400px;background-color: #ffffff;position: fixed;right: 0px;">
	<div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-lock"></i> | เปลี่ยนรหัสผ่าน </div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-user"></i> รหัสผ่านเดิม &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <input type="password" id="old_password" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;" onkeyup="if(event.which==13){ $('#new_password').focus();}"> <i class="fa fa-eye" onclick="showpass('old_password')" style="cursor: pointer;color:#999999;"></i></div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-envelope-o"> </i> รหัสผ่านใหม่ &nbsp;&nbsp;&nbsp;&nbsp;: <input type="password" id="new_password" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;" onkeyup="if(event.which==13){ $('#verify_password').focus();}"> <i class="fa fa-eye" onclick="showpass('new_password')" style="cursor: pointer;color:#999999;"></i></div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-address-card-o"> </i> ยืนยันรหัสผ่าน &nbsp;: <input type="password" id="verify_password" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;" onkeyup="if(event.which==13){ change_password();}else{check_pass(this.value);}" > <i class="fa fa-eye" onclick="showpass('verify_password')" style="cursor: pointer;color:#999999;"></i> <span id="chk_ps"></span></div>
        <div style="width:300px;text-align: center;padding-top:30px;"><span class="menu_bt" onclick="change_password()">บันทึก</span></div>
	</div>
</div>
<div id="display_upload" style="display:none;width:70%;height:400px;background-color: #ffffff;position: fixed;right: 0px;">
	<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-desktop"></i> | เปลี่ยนรูปโปรไฟล์ </div>
	<form id="uploadimage" action="upload_img_profile.php?" method="post" enctype="multipart/form-data" target="iframe_upload" >
	<div style="border-radius:100px;width:200px;height:200px;border:1px solid #99d6ff;overflow: hidden;"><img src="<?=$image_profile?>" id="imagepreview" style="height:200px;"></div><br>
	<div><input type="file" name="fileUpload" onchange="imagespreview(this)"></div>
	<div style="width:300px;text-align: center;padding-top:30px;"><input type="submit" name="submit" class="menu_bt" value="อัพโหลดรูปโปรไฟล์" style="font-size: 16px;" ></div>
</form>
<iframe src="" id="iframe_upload" name="iframe_upload"  style="border:0px solid #000000;"></iframe>
</div>
</body>
</html>
<script type="text/javascript">
	function showpass(rx){

	 var x = document.getElementById(""+rx);
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
	}
	       function imagespreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imagepreview')
                        .attr('src', e.target.result);
                        imagesupdate();
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function imagesupdate() {
        	//var input = $("input[name=fileUpload]").files
            if ($("input[name=fileUpload]").files && $("input[name=fileUpload]").files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image_profile')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL($("input[name=fileUpload]").files[0]);
            }
        }
</script>