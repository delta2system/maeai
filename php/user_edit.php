<?
session_start();
include("connect.inc");


  $strSQL = "SELECT * FROM user_account WHERE row_id = '".$_GET["id"]."' ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
    }
  }


?><!DOCTYPE html>
<html>
<head>
	<title></title>
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
		function checkbox_val(tbl,val){
			var id = $("input[name=id]").val();

		    $.ajax({ 
                url: "mysql_edituser.php" ,
                type: "POST",
                data: 'submit=checkbox_edit&row_id='+id+"&tbl="+tbl+"&val="+val.value+"&status="+val.checked,
            }).success(
            //function(result) {alert(result)}
            );

		}
		function showpass(rx){

	 var x = document.getElementById(""+rx);
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
	}

		function save(){
			var data = "&username="+$("input[name=username]").val();
				data = data + "&passwd="+$("input[name=new_password]").val();
				data = data + "&email="+$("input[name=email]").val();
				data = data + "&fullname="+$("input[name=fullname]").val();
				data = data + "&position="+$("select[name=position_x]").val();
				data = data + "&row_id="+$("input[name=id]").val();

		    $.ajax({ 
                url: "mysql_edituser.php" ,
                type: "POST",
                data: 'submit=save_user'+data,
            }).success(function(result) {
			var obj = jQuery.parseJSON(result);
              if(obj != ''){
                  $.each(obj, function(key, val) {
               if(val["status"]=="true"){
               	alert(val["msg"]);
               	$("#user_x").hide();
               }else{
               	alert(val["msg"]);
               }
           });
              }
          });
		}

		function del_user(){
			var personal = confirm("ต้องการลบชื่อผู้ใช้งานนี้ใช่หรือไม่?","");
			if(personal==true){
		    $.ajax({ 
                url: "mysql_edituser.php" ,
                type: "POST",
                data: 'submit=del_user&id='+$("input[name=id]").val(),
            }).success(
            	function(result) {
            		window.parent.location.reload()
            	}
            );
			}
		}

		function new_user(){
			var r = $("input[name=row_menu]").val();
			var menu = "";
			for(i=1;i<=r;i++){
				var ds = document.getElementById("mux"+i);
				if(ds.checked==true){
					menu = menu + "," + ds.value;
				}
			}
			
			var data = "";
				data = data + "&username="+$("input[name=username]").val();
				data = data + "&passwd="+$("input[name=new_password]").val();
				data = data + "&email="+$("input[name=email]").val();
				data = data + "&fullname="+$("input[name=fullname]").val();
				data = data + "&position="+$("select[name=position_x]").val();
				data = data + "&edit_stock="+document.getElementById("edit_stock").checked;
				data = data + "&menu_code="+menu;
		    $.ajax({ 
                url: "mysql_edituser.php" ,
                type: "POST",
                data: 'submit=add_user'+data,
            }).success(
            	function(result) {
            		//alert(result);
            		window.parent.location.reload()
            	}
            );


		}


	</script>
</head>
<body>
<table id="user_x">
	<tr><td colspan="2" style="margin-top:20px;color:#3385ff;"><i class="fa fa-braille"></i> | ข้อมูลส่วนตัว</td> <input type="hidden" name="id" value="<?=$_GET["id"]?>"></tr>
	<tr><td style="margin-top:20px;color:#3385ff; "><i class="fa fa-user"></i> User :</td><td><input type="text" name="username" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;" value="<?=$arrCol[username]?>"></td></tr>
	<tr><td style="margin-top:20px;color:#3385ff; "><i class="fa fa-envelope-o"></i> รหัสผ่าน :</td><td><input type="password" name="new_password" id="new_password" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;" value="<?=$arrCol[passwd]?>"> <i class="fa fa-eye" onclick="showpass('new_password')" style="cursor: pointer;color:#999999;"></i></td></tr>
	<tr><td style="margin-top:20px;color:#3385ff; "><i class="fa fa-envelope-o"></i> อีเมลล์ :</td><td><input type="text" name="email" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;" value="<?=$arrCol[email]?>"></td></tr>
	<tr><td style="margin-top:20px;color:#3385ff; "><i class="fa fa-address-card-o"></i> ชื่อ-สกุล :</td><td><input type="text" name="fullname" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;" value="<?=$arrCol[fullname]?>"></td></tr>
	<tr><td style="margin-top:20px;color:#3385ff; "><i class="fa fa-address-card-o"></i> ตำแหน่ง :</td><td><select name="position_x" style="width:300px;font-size: 15px;padding: 5px 5px;color:#555555;">
				<?
				$sql_o = "SELECT * FROM position_personal ORDER By row_id ASC";
				$result = mysql_query($sql_o);
				while ($data = mysql_fetch_assoc($result)) {
				if($arrCol[position]==$data[code]){
				print "<option value='$data[code]' selected >$data[position_detail]</option>";	
			}else{
				print "<option value='$data[code]'>$data[position_detail]</option>";
			}
				}
				?>
			</select></td></tr>

	<tr><td style="margin-top:20px;color:#3385ff;border-bottom: 1px solid #a0a0a0;padding: 5px 0px; ">แก้ไข สต็อก :</td><td style="border-bottom: 1px solid #a0a0a0;"><div style='padding:3px 10px;'><input type="checkbox" name="edit_stock" id="edit_stock" <?if($arrCol[stock_edit]=="1"){ echo "checked";}?> onclick="checkbox_val('edit_stock',this)" ></div></td></tr>

	<tr><td style="margin-top:20px;color:#3385ff;border-bottom: 1px solid #a0a0a0;padding: 5px 0px; ">แก้ไข สต็อกแผนก :</td><td style="border-bottom: 1px solid #a0a0a0;"><div style='padding:3px 10px;'><input type="checkbox" name="substock_edit" id="substock_edit" <?if($arrCol[substock_edit]=="1"){ echo "checked";}?> onclick="checkbox_val('substock_edit',this)" ></div></td></tr>

	<tr><td style="margin-top:20px;color:#3385ff;border-bottom: 1px solid #a0a0a0;padding: 5px 0px; ">อนุญาติจ่ายพัสดุ :</td>
		<td style="border-bottom: 1px solid #a0a0a0;"><div style='padding:3px 10px;'>
			<input type="checkbox" name="bill_out_edit" id="bill_out_edit" <?if($arrCol[bill_out_edit]=="1"){ echo "checked";}?> onclick="checkbox_val('bill_out_edit',this)" >
		</div></td></tr>

	<tr><td style="margin-top:20px;color:#3385ff;border-bottom: 1px solid #a0a0a0;padding: 5px 0px; ">อนุญาติคืนพัสดุ :</td>
		<td style="border-bottom: 1px solid #a0a0a0;"><div style='padding:3px 10px;'>
			<input type="checkbox" name="bill_in_edit" id="bill_in_edit" <?if($arrCol[bill_in_edit]=="1"){ echo "checked";}?> onclick="checkbox_val('bill_in_edit',this)" >
		</div></td></tr>
	<tr><td style="margin-top:20px;color:#3385ff;border-bottom: 1px solid #a0a0a0;padding: 5px 0px; ">กระดานข่าว :</td>
		<td style="border-bottom: 1px solid #a0a0a0;"><div style='padding:3px 10px;'>

			<!-- <input type="checkbox" name="bill_in_edit" id="bill_in_edit" <?if($arrCol[bill_in_edit]=="1"){ echo "checked";}?> onclick="checkbox_val('bill_in_edit',this)" > -->
			<?
			$dashboard_code = explode(",", $arrCol["dashboard_code"]);
			?>
			<div style='padding:3px 10px;'><input type='checkbox'  id='dashboard1' value='1'  onclick="checkbox_val('dashboard',this)" <?if(array_search("1", $dashboard_code)){ echo "checked";}?>>รายการรอเบิกพัสดุ</div>
			<div style='padding:3px 10px;'><input type='checkbox'  id='dashboard1' value='2'  onclick="checkbox_val('dashboard',this)" <?if(array_search("2", $dashboard_code)){ echo "checked";}?>>รายการรอคืนพัสดุ</div>
			<div style='padding:3px 10px;'><input type='checkbox'  id='dashboard1' value='3'  onclick="checkbox_val('dashboard',this)" <?if(array_search("3", $dashboard_code)){ echo "checked";}?>>รายการรอรับเข้าพัสดุ</div>
			<div style='padding:3px 10px;'><input type='checkbox'  id='dashboard1' value='4'  onclick="checkbox_val('dashboard',this)" <?if(array_search("4", $dashboard_code)){ echo "checked";}?>>สินค้าคงคลังต่ำกว่ากำหนด</div>
			<div style='padding:3px 10px;'><input type='checkbox'  id='dashboard1' value='5'  onclick="checkbox_val('dashboard',this)" <?if(array_search("5", $dashboard_code)){ echo "checked";}?>>พัสดุใกล้หมดอายุ</div>
			<div style='padding:3px 10px;'><input type='checkbox'  id='dashboard1' value='6'  onclick="checkbox_val('dashboard',this)" <?if(array_search("6", $dashboard_code)){ echo "checked";}?>>ทะเบียนแจ้งซ่อม</div>

		</div></td></tr>


	<tr><td style="margin-top:20px;color:#3385ff;vertical-align: top;text-align: right;border-bottom: 1px solid #a0a0a0; ">เมนู :</td><td style="border-bottom: 1px solid #a0a0a0;">
	<?
		if($arrCol[menu_code]==""){$arrCol[menu_code]=",43,44,45";}

		$mu=explode(",",$arrCol[menu_code]);
		$sql_o = "SELECT * FROM menu_lst ORDER By menu_group ASC,menu_position ASC";
		$result = mysql_query($sql_o);
		while ($data = mysql_fetch_assoc($result)) {
			$o++;
			if(array_search($data[row_id],$mu)){
			echo "<div style='padding:3px 10px;'><input type='checkbox' name='mux$o' id='mux$o' value='$data[row_id]' checked onclick=\"checkbox_val('menu_code',this)\"> ".$data["menu_name"]."</div>";
			}else{
			echo "<div style='padding:3px 10px;'><input type='checkbox' name='mux$o' id='mux$o' value='$data[row_id]' onclick=\"checkbox_val('menu_code',this)\"> ".$data["menu_name"]."</div>";	
			}

		}
		echo "<input type='hidden' name='row_menu' value='$o'>";
	?>

	</td></tr>

	<tr><td colspan="2" style="height: 40px;">
		<?if(empty($_GET["id"])){?>
		<div style="margin-top:10px;width:120px;padding:5px;font-size:14px;border-radius: 4px;background-color:#2ebd2e;color:#ffffff;text-align: center;border:1px solid #009900;box-shadow:1px 2px 2px rgba(0,0,0,0.3);cursor: pointer;" onclick="new_user()"> + เพิ่ม ผู้ใช้งาน</div>
		<?}else{?>
		<span class="menu_bt" onclick="save()">บันทึก</span>
		<span class="menu_bt" onclick="del_user()">ลบ</span>
		<?}?>
	 </td></tr>
</table>
</body>
</html>