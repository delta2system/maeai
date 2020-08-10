<?PHP
session_start();
include("connect.inc");
if($_SESSION["xusername"]==""){
  echo("<script>alert('กรุณาทำการล็อกอินก่อนใช้งาน');window.location='login.php'</script>");
}

$sql = "SELECT stock_edit from user_account where username = '".$_SESSION["xusername"]."'  limit 1  ";
list($stock_edit) = Mysql_fetch_row(Mysql_Query($sql));
 
?>
<!DOCTYPE html>
<html>
<head>
	<title>.::คลังพัสดุ::.</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script src="../js/jquery-1.8.0.min.js"></script>
  <script src="../js/tableHeadFixer.js"></script>
  <!-- <link rel="stylesheet" href="../css/font-awesome.min.css"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		body{
			/*background-color: 	#f7f7f7;*/
		}
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
      /*float: left;*/
      padding:5px 10px;
      border:1px solid #e0e0e0;
      cursor: pointer;
      background-color: #ffffff;
    }
     .button_menu:hover{
      background-color: #e0e0e0;
     }
          .detail_show{
      width:100%;
      border:1px solid #555555;
      overflow-x: hidden;
      overflow-y: auto;
     }
     .cursor_p{
     	cursor:pointer;
     }
     .cursor_p:hover{
     	background-color:#8b9dc3; 
     }
	</style>
	<script type="text/javascript">
		function search_product(){
			var gp = $("select[name=new_group]").val();
			var bc = $("input[name=search]").val();
            $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=stock_search&group_type='+gp+'&search='+bc,
            })
            .success(function(result) {
              //alert(result);
               $("#detail_table tbody tr").remove();
              var obj = jQuery.parseJSON(result);
              var r=0;
              if(obj != ''){
                  $.each(obj, function(key, val) {
                  r++; 
                  var tr = "<tr class='cursor_p' onclick=\"edit('"+val["row_id"]+"')\"><td style='text-align:center;' class='border_bt'>"+r+"</td>";
                  tr = tr +  "<td style='text-align:center;' class='border_bt'>"+val["group_name"]+"</td>";
                  tr = tr +  "<td style='text-align:center;' class='border_bt'>"+val["barcode"]+"</td>";
                  tr = tr +  "<td class='border_bt' style='padding-left:10px;'>"+val["detail"];
                  if(val["qrcode"]!=""){
                  tr = tr + "<br>"+val["qrcode"];
                  }
                  tr = tr +  "</td>";
                  tr = tr +  "<td style='text-align:center;' class='border_bt'>"+val["pcs"]+"</td>";
                  tr = tr +  "<td style='text-align:center;' class='border_bt'>"+val["unit"]+"</td>";
                  tr = tr +  "<td style='text-align:center;' class='border_bt'>"+val["price_in"]+"</td>";
                  tr = tr +  "<td style='text-align:center;' class='border_bt'>"+val["limit_stock"]+"</td>";
                  tr = tr +  "<td style='text-align:center;' class='border_bt'>"+val["lastupdate"]+"</td>";
                  tr = tr + "</tr>";
                  $('#detail_table tbody').append(tr);
                 });

                  for(s=r;s<=17;s++){
                  var tr = "<tr><td></td>";
                  tr = tr +  "<td></td>";
                  tr = tr +  "<td></td>";
                  tr = tr +  "<td></td>";
                  tr = tr +  "<td></td>";
                  tr = tr +  "<td></td>";
                  tr = tr +  "<td></td>";
                  tr = tr +  "<td></td>";
                  tr = tr +  "<td></td>";
                  tr = tr + "</tr>";
                  $('#detail_table tbody').append(tr);
                  }
            }
          });
		}

		function print_stock(){
			var gp = $("select[name=new_group]").val();
			var bc = $("input[name=search]").val();
    		var left = (screen.width/2)-(1200/2);
    		var top = (screen.height/2)-(600/2);
    window.open("stock_print.php?group_type="+gp+"&search="+bc,"_blank","toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=1000,height=600");
		}

		function excelExport(){
			//Excel_stock.php
			var gp = $("select[name=new_group]").val();
			var bc = $("input[name=search]").val();
			window.location="Excel_stock.php?group_type="+gp+"&search="+bc
		}

		function edit(rx){
			var px = $("input[name=permit_edit]").val();
			if(px==1){
			$("input[name=edit_row]").val(rx);	
			$( "#detail_show" ).on( "click", function( event ) {
  			//$( "#log" ).text( "pageX: " + event.pageX + ", pageY: " + event.pageY );
  			$("#small_menu").css({"left": event.pageX+"px","top": event.pageY+"px"});
  			$("#small_menu").show();
			});
			}
		}

		function edit_show(){
			$("#small_menu").toggle();
			$.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=product_rowid_edit&row_id='+$("input[name=edit_row]").val(),
            })
            .success(function(result) {
              var obj = jQuery.parseJSON(result);

              if(obj != ''){
                  $.each(obj, function(key, val) {


                  	$("input[name=edit_barcode]").val(val["barcode"]);
                  	$("input[name=edit_detail]").val(val["detail"]);
                  	$("input[name=edit_unit]").val(val["unit"]);
                  	$("input[name=edit_pcs]").val(val["pcs"]);
                  	$("input[name=edit_price]").val(val["price_in"]);
                    $("input[name=edit_limit]").val(val["limit_stock"]);
                  	$("select[name=edit_group]").val(val["group_type"]);
                  	$("input[name=row_id_edit]").val(val["row_id"]);
                 });

            }
          });
			$("#edit_pd").show();
			$("input[name=edit_row]").val("");
		}

		function save_edit_product(){

            var data = "&barcode="+$("input[name=edit_barcode]").val();
                data = data + "&detail="+$("input[name=edit_detail]").val();
                data = data + "&price="+$("input[name=edit_price]").val();
                data = data + "&unit="+$("input[name=edit_unit]").val();
                data = data + "&pcs="+$("input[name=edit_pcs]").val();
                data = data + "&group_type="+$("select[name=edit_group]").val();
                data = data + "&limit_stock="+$("input[name=edit_limit]").val();
                data = data + "&row_id="+$("input[name=row_id_edit]").val();

            $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=save_edit_product'+data,
            })
            .success(function(result) {
               var obj = jQuery.parseJSON(result);
              if(obj != ''){
                  $.each(obj, function(key, val) {
               // alert(result);
                //$("#edit_pd").hide();
               // $("input[name=edit_barcode]").val(result);
               // $("input[name=edit_detail]").select();
               if(val["status"]=="true"){
                var f = confirm(val["Messenger"]);
                if(f == true){
             
                  $("#edit_pd").hide();
                }else{
                  $("#edit_pd").hide();
                }
                
              $("input[name=edit_barcode]").val("");
             $("input[name=edit_detail]").val("");
             $("input[name=edit_price]").val("");
             $("input[name=edit_unit]").val("");
             $("input[name=edit_pcs]").val("");
             $("input[name=row_id_edit]").val("");
             $("input[name=edit_limit]").val("");
             search_product();
               }else{
                alert(val["Messenger"]);
                return false;
               }

             });
          }
            }); 
          
		}
    function delproduct_show(ex){
      var r = confirm("ต้องการลบสินค้า\nหมายเหตุ การลบสินค้า จะไม่สามารถเรียกกลับคืนมาได้");
      if(r == true){


            $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=del_product&row_id='+$("input[name=edit_row]").val(),
            })
            .success(function(result) {
                search_product();
            });






      }
      $("#small_menu").hide();
    }

	</script>
</head>
<body>
	<div id="small_menu" style="display:none;position: absolute;">
		<div class="button_menu" style="padding:3px 20px;" onclick="edit_show()">แก้ไข <input type="hidden" name="edit_row"></div>
		<div class="button_menu" style="padding:3px 20px;" onclick="delproduct_show()">ลบ</div>
		<div class="button_menu" style="padding:3px 20px;background-color: #fcb3b3;" onclick="$('#small_menu').toggle()">ปิด</div>
	</div>
<div style="width:100%;height:50px;margin-top: 30px;text-align: center;font-weight: bold;font-size: 20px;">คลังพัสดุ</div>
<input type="hidden" name="permit_edit" value="<?=$stock_edit?>">
<fieldset >
	<legend style="font-size: 18px;">ค้นหาพัสดุ</legend>
	<table style="width:100%;">
		<tr><td style="font-size: 18px;padding:5px;width:100px;color:#333333;">รหัส/สินค้า</td><td colspan="3"><input type="text" name="search" style="width:98%;font-size: 18px;padding:5px;" onkeyup="if(event.keyCode==13){search_product()}"></td>
		<tr><td style="font-size: 18px;padding:5px;color:#333333;">กลุ่มสินค้า</td><td>
<select name="new_group" style="width:250px;font-size: 17px;padding:10px 5px;" onkeyup="if(event.keyCode==27){$('#new_pd').hide();}" >
      <option value=''>เลือกกลุ่มสินค้า</option>
      <option value='all'>เลือกทั้งหมด</option>
    <?
  $sql = "SELECT * from group_type  ORDER By code  ASC";
  $result = mysql_query($sql);
  while ($tx = mysql_fetch_array($result) ) {
    print "<option value='$tx[code]'>$tx[detail]</option>";
  }
    ?>
  </select>
<span  class="button_menu" style="font-size: 16px;color:#3b5998;padding:10px 30px;" onclick="search_product()"><i class="fa fa-search"></i> ค้นหา </span>
		</td>
		<td style="width:50px;"><img src="../images/menu/Excel.png" style="width:32px;cursor: pointer;" onclick="excelExport()"></td>
		<td style="width:50px;"><img src="../images/menu/Printer.png" style="width:32px;cursor: pointer;" onclick="print_stock()"></td>

	</table>
</fieldset>
<div class="detail_show" id="detail_show" >
<table id="detail_table" style="width:99%;height: 900px;">
	<thead>
		<td class="topbar" style="width:60px;">ลำดับ</td>
		<td class="topbar" style="width:100px;">กลุ่มสินค้า</td>
		<td class="topbar" style="width:100px;">รหัส</td>
		<td class="topbar">รายการ</td>
		<td class="topbar" style="width:150px;">จำนวน</td>
    <td class="topbar" style="width:100px;">หน่วยนับ</td>
		<td class="topbar" style="width:100px;">ราคา</td>
    <td class="topbar" style="width:100px;">ลิมิต</td>
		<td class="topbar" style="width:180px;">อัพเดทล่าสุด</td>
	</thead>
	<tbody>
		
	</tbody>
</table>
</div>
</body>
</html>
<div id="edit_pd" style="display:none;position:fixed;z-index:5;width:900px;height:500px;top:50%;margin-top:-250px;background-color: #f7f7f7;border:1px solid #e0e0e0;border-radius: 5px;left:50%;margin-left:-450px;box-shadow: 5px 5px 5px #909090;">
  <img src="../images/new_product.png" style="position: absolute;width:360px;margin-top: 40px;" >
  <div style="width:100%height:50px;text-align: center;font-size: 20px;font-weight: bold;margin-top: 25px;color: #01840e;">..:: แก้ไขสินค้า ::..</div>
  <div style="text-align: center;margin-top: 25px;">
    <span style="width:120px;height:20px;display: inline-block;font-size: 17px;text-align: right;">กลุ่มสินค้า :</span>  <span style="width:100px;height:50px;display: inline-block;"><select name="edit_group" style="width:250px;font-size: 17px;padding:10px 5px;" onkeyup="if(event.keyCode==27){$('#edit_pd').hide();}" >
      <option value=''>เลือกกลุ่มสินค้า</option>
    <?
  $sql = "SELECT * from group_type  ORDER By code  ASC";
  $result = mysql_query($sql);
  while ($tx = mysql_fetch_array($result) ) {
    print "<option value='$tx[code]'>$tx[detail]</option>";
  }
    ?>
  </select>
  <!-- <span  class="button_menu" style="position:absolute;float:middle;font-size: 16px;color:#3b5998;margin-left: 220px;margin-top: -40px;" onclick="$('#edit_gp').toggle()"> <img src="../images/menu/plus.png" style="width:18px;vertical-align: middle;" > เพิ่มกลุ่มสินค้า</span> -->
</span><br>
  <span style="width:120px;height:20px;display: inline-block;font-size: 17px;text-align: right;">รหัสสินค้า :</span>   <span style="width:100px;height:50px;display: inline-block;"><input type="text" name="edit_barcode" style="width:250px;font-size: 17px;padding:10px 5px;" onkeyup="if(event.keyCode==13){ $('input[name=edit_detail]').focus();}else if(event.keyCode==27){$('#edit_pd').hide();}"></span><br>
  <span style="width:120px;height:20px;display: inline-block;font-size: 17px;text-align: right;">รายการสินค้า :</span>  <span style="width:100px;height:50px;display: inline-block;"><input type="text" name="edit_detail" style="width:250px;font-size: 17px;padding:10px 5px;" onkeyup="if(event.keyCode==13){ $('input[name=edit_price]').focus();}else if(event.keyCode==27){$('#edit_pd').hide();}"></span><br>
  <span style="width:120px;height:20px;display: inline-block;font-size: 17px;text-align: right;">ราคาสินค้า :</span>    <span style="width:100px;height:50px;display: inline-block;"><input type="text" name="edit_price" style="width:250px;font-size: 17px;padding:10px 5px;" onkeyup="if(event.keyCode==13){ $('input[name=edit_unit]').focus();}else if(event.keyCode==27){$('#edit_pd').hide();}"></span><br>
  <span style="width:120px;height:20px;display: inline-block;font-size: 17px;text-align: right;">หน่วยนับ :</span>     <span style="width:100px;height:50px;display: inline-block;"><input type="text" name="edit_unit" style="width:250px;font-size: 17px;padding:10px 5px;" onkeyup="if(event.keyCode==13){$('input[name=edit_pcs]').focus();}else if(event.keyCode==27){$('#edit_pd').hide();}"></span><br>
  <span style="width:120px;height:20px;display: inline-block;font-size: 17px;text-align: right;">จำนวน :</span>     <span style="width:100px;height:50px;display: inline-block;"><input type="text" name="edit_pcs" style="width:125px;font-size: 17px;padding:10px 5px;" onkeyup="if(event.keyCode==13){$('input[name=edit_limit]').focus();}else if(event.keyCode==27){$('#edit_pd').hide();}"> </span><br>
  <span style="width:150px;height:20px;display: inline-block;font-size: 17px;text-align: right;">
    สินค้าคงสต็อกขั้นต่ำ :
  </span>
  <span style="width:100px;height:50px;display: inline-block;">
    <input type="text" name="edit_limit" style="width:125px;font-size: 17px;padding:10px 5px;" onkeyup="if(event.keyCode==13){save_edit_product();}else if(event.keyCode==27){$('#edit_pd').hide();}">
  </span><br>
  	<input type="hidden" name="row_id_edit">

  <span style="width:170px;height:20px;display: inline-block;font-size: 17px;text-align: right;">
<span  class="button_menu" style="float:middle;font-size: 16px;color:#3b5998;" onclick="save_edit_product()"><img src="../images/menu/save_icon.png" style="width:24px;vertical-align: middle;" > บันทีกการแก้ไข</span>   </span>
<span style="width:100px;height:20px;display: inline-block;font-size: 17px;text-align: right;">
<span  class="button_menu" style="float:middle;font-size: 16px;color:#3b5998;" onclick="$('#edit_pd').toggle()"><img src="../images/menu/close_red.png" style="width:24px;vertical-align: middle;" > ยกเลิก</span>   </span>
  </div>
<script type="text/javascript">
	set_detail_show();
	function set_detail_show(){
  var x = $(window).height();

  $(".detail_show").css({"height":(x-220)+"px"});
}
	   $(document).ready(function() {
      $("#detail_table").tableHeadFixer(); 

  // var x = $(window).height();
  // $("#detail_table").css({"height":(x-260)+"px"});


      });
</script>