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
		.border_bt{
			border:1px solid #a0a0a0;
			padding:5px 0px;
		}
		table{
			border-collapse: collapse;
		}
		.head_bar{
			margin:0px auto;
			width:400px;
			height:80px;
			font-size: 30px;
			color:#000000;
			text-align: center;
		}
		.top_bar{
			background-color:#00bfff;
			text-align: center;
			padding:7px 20px;
			border:1px solid #0040ff;
		}
	</style>

	<script type="text/javascript">

	function return_detail(){

            $.ajax({ 
                url: "mysql_department.php" ,
                type: "POST",
                data: 'submit=return_department&search='+$("input[name=search]").val(),
            })
            .success(function(result) {
             //alert(result);
               $("#detail_table tbody tr").remove();
              var obj = jQuery.parseJSON(result);
              if(obj != ''){
                $.each(obj, function(key, val) {
                  var tr = "<tr>";
                  tr = tr +  "<td style='text-align:center;' class='border_bt'>"+val["row_id"]+"</td>";
                  tr = tr +  "<td class='border_bt'>&nbsp;&nbsp;"+val["name"]+"</td>";
                  tr = tr +  "<td class='border_bt'>&nbsp;&nbsp;"+val["name_location"]+"</td>";
                  tr = tr +  "<td >&nbsp;&nbsp;<span class='menu_bt' onclick=\"edit_d('"+val["row_id"]+"')\">แก้ไข</span></td>";
                  tr = tr + "</tr>";
                                     //alert(tr);
                  $('#detail_table tbody').append(tr);
                 
                 });
                          var objDiv = document.getElementById("detail_show");
                          objDiv.scrollTop = objDiv.scrollHeight;
    
            }
          });

            


	}
		function edit_d(rx){
		 $.ajax({ 
                url: "mysql_department.php" ,
                type: "POST",
                data: 'submit=return_department&row_id='+rx,
            })
            .success(function(result) {
            	//alert(result);
            var obj = jQuery.parseJSON(result);
           if(obj != ''){$.each(obj, function(key, val) {

           	$("input[name=edit_code]").val(val["row_id"]);
            $("input[name=edit_detail]").val(val["name"]);
            $("select[name=group_location]").val(val["group_location"]);

           	$("input[name=edit_code]").css({"border":"0px"});
           	$("input[name=edit_code]").attr('readonly', true);
           });}
              });

            $("#display_edit").show();
            $('#display_user').hide();
		}

		function add_personal(){

			$.ajax({ 
                url: "mysql_department.php" ,
                type: "POST",
                data: 'submit=return_department_no',
            })
            .success(function(result) {
            	$("input[name=edit_code]").val(result);
            });



			$("input[name=edit_code]").css({"border":"1px solid #a0a0a0"});
			$("input[name=edit_code]").removeAttr('readonly');

           	
           	$("input[name=edit_detail]").val("");

           	$("#display_edit").show();
           	$('#display_user').hide();
		}


		function save_customer(){
			var data = "&row_id="+$("input[name=edit_code]").val();
				data = data + "&detail=" + $("input[name=edit_detail]").val();
        data = data + "&group_location=" + $("select[name=group_location]").val();

          $.ajax({ 
                url: "mysql_department.php" ,
                type: "POST",
                data: 'submit=save_department'+data,
            })
            .success(function(result) {
            	//alert(result);
       //        var obj = jQuery.parseJSON(result);
       //        if(obj != ''){$.each(obj, function(key, val) {
       //        	alert(val["status"]);
   				if(result=="true"){
   					alert("บันทึกเรียบร้อยแล้ว");
   					$("#display_edit").hide();
           			$('#display_user').show();
           			return_detail();
   					
   				}else{
   					alert("ไม่สามารถบันทึกข้อมูลได้");
   				}

       //        });}
              });
		}

		function del_customer(){

			var r = confirm("คุณต้องการลบ ใช่หรือไม่ \n *หมายเหตุ การลบรหัสไปแล้วจะไม่สามารถเรียกคืนมาได้");
			if(r==true){
			var data = "&row_id="+$("input[name=edit_code]").val();

   			$.ajax({ 
                url: "mysql_department.php" ,
                type: "POST",
                data: 'submit=del_department'+data,
            })
            .success(function(result) {
            	$("#display_edit").hide();
           		$('#display_user').show();
            	return_detail();
              });

		}
}
 

	</script>
</head>
<body>
<div style="width:100%;height:100px;left:0px;top:0px;background-color:#ffbf00;"><br><br>
	<div class="head_bar"> <i class="fa fa-braille"></i>  | เพิ่ม/แก้ไข หน่วยงาน</div>

	<div style="position: absolute;right:50px;margin-top: -50px;"><span class="menu_bt" onclick="add_personal()">เพิ่ม</span></div>
</div>
<!-- <img src="../images/company_icon.png" style="width:150px;"> -->

<div id="display_user" style="margin:0px auto;width:100%;height:400px;">
	<div>
			<table style="width:650px;margin:0px auto;" id="detail_table">
				<thead >
					<td class="top_bar" style="width:40px;">รหัส</td>
					<td class="top_bar">หน่วยงาน</td>
          <td class="top_bar"></td>
          			<td class="top_bar" style="width:120px;"><input type="text" name="search" onkeyup="return_detail()" style="font-size:15px;width:120px;border:1px solid #2eb82e;border-radius: 5px;"><i class="fa fa-search" style="color:#a2a2a2;margin-left: -20px;"></i></td>
				</thead>
				<tbody>

				</tbody>
			</table>
       
	</div>
</div>


<div id="display_edit" style="display:none;width:70%;height:400px;background-color: #ffffff;position: absolute;top:120px;right: 0px;">
	<div style="margin-top:20px;color:#3385ff; "> <i class="fa fa-desktop"></i> | เพิ่ม/แก้ไข </div>
	<div style="margin-top:20px;color:#3385ff; "> &nbsp;&nbsp;&nbsp;&nbsp;รหัส : <input type="text" name="edit_code" style="width:285px;font-size: 15px;padding: 5px 5px;color:#555555;"></div>
	<div style="margin-top:20px;color:#3385ff; "> หน่วยงาน : <input type="text" name="edit_detail" style="width:285px;font-size: 15px;padding: 5px 5px;color:#555555;"></div>
  <div style="margin-top:20px;color:#3385ff; "> กลุ่ม : <select name="group_location"><option value="1">แม่ข่าย (รพ.)</option><option value="2">ลูกข่าย</option></select></div>
	<div style="width:500px;text-align: center;padding-top:30px;">
		<span class="menu_bt" onclick="save_customer()">บันทึก</span>
		<span class="menu_bt" onclick="del_customer()">ลบ</span>
		<span class="menu_bt" onclick="$('#display_edit').hide();$('#display_user').show();">ยกเลิก</span>
	</div>


</div>
</body>
</html>
<script src="../js/tableHeadFixer.js"></script>
<script type="text/javascript">

	   $(document).ready(function() {
	   	return_detail();
       $("#display_user").tableHeadFixer(); 
       //$("#detail_show").onscroll(fixedhead());
      //  var h = $( window ).height();
      // 	alert(h);
      // $("#display_user").css({"height" : h+"px"});
      });
</script>
