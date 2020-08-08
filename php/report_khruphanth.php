<?
session_start();
include("connect.inc");
?>
<!DOCTYPE html>
<html>
<head>
	<title>เพิ่ม ครุภัณฑ์</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
	<style type="text/css">
		select{
			padding: 5px;
			font-size: 14px;
		}
		input[type=text]{
			padding: 5px;
			font-size: 14px;
		}
		table{
			border-collapse: collapse;
		}
		#left_contact{
			overflow-x: hidden;
			overflow-y: auto;
			border:1px solid #909090;
			float: left;
		}
		#right_contact{
			overflow-x: hidden;
			overflow-y: auto;
			border:1px solid #909090;
			float: right;
		}
		.cursor_tbl:hover{
			background-color: rgba(0, 102, 255,0.5);
			cursor: pointer;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function (e) {
			var w=window.innerWidth;
			var h=window.innerHeight;
			document.getElementById("iframe_url").style.height = (h-25)+"px";

		});

		function store_edit(rd){
			window.open("khruphanth_edit.php?row_id="+rd , "iframe_url");
		}

		function return_store(){
			var data = "&search=" + $("input[name=search]").val();
			 	data = data + "&type_store=" + $("select[name=type_store]").val();
				data = data + "&order=" + $("select[name=order]").val();
				data = data + "&search_order=" + $("select[name=search_order]").val();
				
 			$.ajax({ 
                url: "mysql_fix.php" ,
                type: "POST",
                data: 'submit=return_store'+data,
            })
            .success(function(result) {
            	 $("#search_table tbody tr").empty();
              var obj = jQuery.parseJSON(result);
              if(obj != ''){
                  $.each(obj, function(key, val) {
    		var tr = "<tr  class='cursor_tbl' onclick=\"store_edit('"+val["row_id"]+"')\">";
				tr = tr +  "<td style='border:1px solid #a2a2a2;text-align: left;'>&nbsp;&nbsp;"+val["code"]+"</td>";
				tr = tr +  "<td style='border:1px solid #a2a2a2;text-align: left;'>&nbsp;&nbsp;"+val["attribute"]+"</td>";
    			tr = tr + "</tr>";
                  $('#search_table > tbody:last').append(tr);
                 });
            }
          });
		}
	</script>
</head>
<body>
<table style="width:100%;">
	<td style="width: 30%;height:100%;vertical-align: top;border:1px solid #a0a0a0;">
<table style="width:100%;" >
		<thead>
			<tr>
		<td style="background-color: #e6e6e6;border:1px solid #e6e6e6;">&nbsp;&nbsp;เลือกประเภท
			<select name="type_store" style="width:160px" onchange="return_store()">
			<option value="%">ทั้งหมด</option>
			<?
			$sql = "SELECT * from store_type ORDER By row_id  ASC";
			$result = mysql_query($sql);
			while ($row = mysql_fetch_array($result) ) {
				print "<option value='$row[code]'>$row[detail]</option>";
			}
			?>

		</select></td>
		<td style="background-color: #e6e6e6;border:1px solid #e6e6e6;">เรียงตาม
			<select name="order" onchange="return_store()">
			<option value="code ASC">รหัสวัสดุ/ครุภัณฑ์</option>
			<option value="attribute ASC">ชื่อวัสดุ/ครุภัณฑ์</option>
			<option value="dateday ASC">การรับวัสดุ/ครุภัณฑ์</option>
		</select>
		</td></tr>
				<tr>
				<td colspan="2" style="text-align: left;background-color: #e6e6e6;">ค้นหา <select name='search_order' style="width:60px;">
					<option value="attribute">ชื่อ</option>
					<option value="code">รหัส</option>
					<option value="address_store">แผนก</option>
					<option value="model">ยี้ห้อ</option>
					<option value="serial">ซีเรียล</option>
					<option value="seller">ผู้จำหน่าย</option>
				</select>
			<input type="text" name="search" onkeyup="return_store()"></td>
		</tr>
	</thead>
</table>
<div id="main_frame" style="width:100%;overflow: auto;">
<table style="width:140%;" id="search_table">
		<thead>
		<tr>
		<td style="border:1px solid #a0a0a0;text-align:center;background-color: #a2a2a2;width:170px;">รหัส</td>
		<td style="border:1px solid #a0a0a0;text-align:center;background-color: #a2a2a2;">ชื่อพัสดุ/ครุภัณฑ์</td>	
		</tr>
		</thead>
		<tbody>
		<?
		// $sql = "SELECT row_id,code,attribute from store where store_type = '1' ORDER By code  ASC";
		// $result = mysql_query($sql);
		// while ($data = mysql_fetch_array($result) ) {
  // 		print (" <tr class='cursor_tbl' onclick=\"store_edit('$data[row_id]')\">\n".
  //      "  <td style='font-size:12px;border:1px solid #a2a2a2;' >$data[code]</td>\n".
  //      "  <td style='border:1px solid #a2a2a2;' >$data[attribute]</td>\n".
  //      " </tr>\n");
		// }
		?>
		</tbody>
	</table>
</div>
	</td>


	<td style="width:70%;height:100%;vertical-align: top;">
	<iframe name="iframe_url" id="iframe_url" src="khruphanth_edit.php" style="width:100%;border:1px solid #a0a0a0;overflow-y: auto;overflow-x:hidden; "></iframe>
	</td>
	
</table>

</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
	var yx = $(window).height();
   // var wx = $(window).width();
    $("#main_frame").css({"height": (yx-110)+"px"}); 
  $(window).resize(function(){
    var yx = $(window).height();
   // var wx = $(window).width();
    $("#main_frame").css({"height": (yx-100)+"px"}); 
    // if(wx<768){
    //   $("#main_frame").css({"margin-left":"-170px"}); 
    // }
    //$("#log").text($(document).width());
  });
});
</script>