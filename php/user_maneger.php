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
		.cursor{
			cursor: pointer;
			color:#606060;
		}
		.cursor:hover{
			background-color: #ffffa3;
			color:#000000;
		}
		table{
			border-collapse: collapse;
		}
		input[type=checkbox]{
			cursor: pointer;
			width:18px;
			height:18px;

		}
	</style>
	<script type="text/javascript">
		function edit_user(rx){
			window.open("user_edit.php?id="+rx,"user_edit");
		}
		function status(rx,vl){
		    $.ajax({ 
                url: "mysql_edituser.php" ,
                type: "POST",
                data: 'submit=status_user&id='+rx+"&check="+vl.checked,
            }).success(
            //function(result) {alert(result);}
            );
		}
	</script>
</head>
<body>
<div style="width:100%;height:30px;left:0px;top:0px;font-size: 21px;border-bottom:1px solid #d0d0d0;">จัดการพนักงาน <span style="font-size:12px;color:#909090;">User Manager</span></div>
<div style="width:100%;height:30px;">
	<div style="margin-top:10px;width:120px;padding:5px;font-size:14px;border-radius: 4px;background-color:#2ebd2e;color:#ffffff;text-align: center;border:1px solid #009900;box-shadow:1px 2px 2px rgba(0,0,0,0.3);cursor: pointer;" onclick="edit_user('')"> + เพิ่ม ผู้ใช้งาน</div>
</div>
<div style="float: left;width:50%;height:400px;">
		<table style="width:100%;border-collapse: collapse;margin-top: 20px;">
		<thead>
			<td style="font-size:14px;text-align: center;border-top:1px solid #c0c0c0;border-bottom:2px solid #c0c0c0;padding:8px 0px;font-weight: bold;">Username</td>
			<td style="font-size:14px;text-align: center;border-top:1px solid #c0c0c0;border-bottom:2px solid #c0c0c0;padding:8px 0px;font-weight: bold;">ชือ-นามสกุล</td>
			<td style="font-size:14px;text-align: center;border-top:1px solid #c0c0c0;border-bottom:2px solid #c0c0c0;padding:8px 0px;font-weight: bold;">ตำแหน่ง/แผนก</td>
			<td style="font-size:14px;text-align: center;border-top:1px solid #c0c0c0;border-bottom:2px solid #c0c0c0;padding:8px 0px;font-weight: bold;">เริ่มใช้งาน</td>
			<td style="font-size:14px;text-align: center;border-top:1px solid #c0c0c0;border-bottom:2px solid #c0c0c0;padding:8px 0px;font-weight: bold;">ใช้งานล่าสุด</td>
			<td style="font-size:14px;text-align: center;border-top:1px solid #c0c0c0;border-bottom:2px solid #c0c0c0;padding:8px 0px;font-weight: bold;">สถานะ</td>
		</thead>
		<tbody>
<!-- 	<div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-braille"></i></div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-envelope-o"></i> ชื่อหน่วยงาน : <input type="text" name="email" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;" value="<?=$email?>"></div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-address-card-o"></i> ที่อยู่ : <input type="text" name="fullname" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;" value="<?=$fullname?>"></div>
		<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-address-card-o"></i> เบอร์โทรศัพท์ : <input type="text" name="fullname" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;" value="<?=$fullname?>">
			
			</div>
        <div style="width:300px;text-align: center;padding-top:30px;"><span class="menu_bt" onclick="save_profile()">บันทึก</span></div>
	</div> --><?
	//$date=;echo ;
$sql = "SELECT * from user_account ";
$result = mysql_query($sql);
$arrCol=array();
while ($row = mysql_fetch_array($result) ) {
	//$arrCol["$row[tbl_title]"]=$row["tbl_value"];
	$l++;

	if($row[image_profile]!=""){
	  $str_img = "../images/img_profile/".$row[image_profile];
      if (!file_exists($str_img)){
      	$str_img = "../images/img_profile/no-image.png";
      }
  }else{
  		$str_img = "../images/img_profile/no-image.png";
      //echo $str_img ;
  }

	if($row[status]==1){ $status="checked";}else{$status="";}
print "<tr class='cursor'><td style='border-bottom:1px solid #c0c0c0;text-align:left;font-size:14;padding:8px 0px;' onclick=\"edit_user('$row[row_id]')\"><img src='$str_img' style='width:30px;border-radius:15px;vertical-align: middle;' > $row[username]</td>".
	  "<td style='border-bottom:1px solid #c0c0c0;font-size:14;padding:8px 0px;' onclick=\"edit_user('$row[row_id]')\">&nbsp;&nbsp;$row[fullname]</td>".
	  "<td style='border-bottom:1px solid #c0c0c0;text-align:center;font-size:14;padding:8px 0px;' onclick=\"edit_user('$row[row_id]')\">$row[position]</td>".
	  "<td style='border-bottom:1px solid #c0c0c0;text-align:center;font-size:14;padding:8px 0px;' onclick=\"edit_user('$row[row_id]')\">".date_format(date_create($row[regis_start]),"d/m/Y H:i:s")."</td>".
	  "<td style='border-bottom:1px solid #c0c0c0;text-align:center;font-size:14;padding:8px 0px;' onclick=\"edit_user('$row[row_id]')\">".date_format(date_create($row[last_login]),"d/m/Y H:i:s")."</td>".
	  "<td style='border-bottom:1px solid #c0c0c0;text-align:center;font-size:14;padding:8px 0px;'><input type='checkbox' name='checkid' $status onclick=\"status('$row[row_id]',this)\" style='cursor:pointer;'></td></tr>";

}?>
</tbody>
	</table>
</div>
<!-- <div id="display_user" style="position:absolute;right:0px;width:48%;height:400px;margin-top: -30px"> -->
<iframe src="" name="user_edit" id="user_edit" style="position:absolute;right:0px;width:48%;height:90%;margin-top: -30px;border:1px solid #e0e0e0;"></iframe>

	

<!-- </div> -->

</body>
</html>