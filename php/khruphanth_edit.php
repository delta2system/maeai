<?
session_start();
include("connect.inc");
if($_GET["row_id"]){
  $strSQL="SELECT * from store WHERE row_id = '".$_GET["row_id"]."' ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
    }
    
  }
}

function number_convert($str){
	if($str>0){
		return number_format($str);
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title> ครุภัณฑ์</title>
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
		td{
			color:#1a1a1a;
		}
		.cursor_tbl:hover{
			background-color: rgba(0, 102, 255,0.5);
			cursor: pointer;
		}
	</style>
	<script type="text/javascript">
		function addCommas(nStr)
      {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
      }
		function return_fix(rd){
 			$.ajax({ 
                url: "mysql_fix.php" ,
                type: "POST",
                data: 'submit=return_fix&row='+rd,
            })
            .success(function(result) {
              var obj = jQuery.parseJSON(result);
              if(obj != ''){
              	 $("#show_fix tbody tr").empty();
                  $.each(obj, function(key, row) {

    var tr = "<tr>";
	tr = tr +  "<td style='border:1px solid #a2a2a2;text-align: center;'>"+row["dateday"]+"</td>";
	tr = tr +  "<td style='border:1px solid #a2a2a2;text-align: center;'>"+row["no_bill"]+"</td>";
	tr = tr +  "<td style='border:1px solid #a2a2a2;text-align: left;'>"+row["detail"]+"</td>";
	tr = tr +  "<td style='border:1px solid #a2a2a2;text-align: center;'>"+row["pcs"]+"</td>";
	tr = tr +  "<td style='border:1px solid #a2a2a2;text-align: center;'>"+addCommas(row["total_money"])+"</td>";
	tr = tr +  "<td style='border:1px solid #a2a2a2;text-align: center;'>"+row["fix_finished"]+"</td>";
	tr = tr +  "<td style='border:1px solid #a2a2a2;text-align: left;'>"+row["other"]+"</td>";
    tr = tr + "</tr>";
                  $('#show_fix > tbody:last').append(tr);
                 });
            }
          });
		}

		function img_review(img){
			$("#images_review").show();
			$('#imgview').attr('src', "../images/store/"+img);
			//<img src="../images/store/<?=$arrCol['images']?>">
		}
		function kruphan_control(id){
			
			window.open("kruphan_control_print.php?row_id="+id , '_blank');
		}

		function hirefix(rd){
			//	window.open("egp2/hire_fix.php?row_id_store="+rd , '_blank');
			window.location='egp2/hire_fix.php?row_id_store='+rd;
		}
	</script>
</head>
<body>

	<fieldset style="border-color: #4286f4;">
		<legend style="color: #619bf9;">รายละเอียดครุภัณฑ์</legend>
<table style="width:100%;">
	<tr>
<!--  		<td rowspan="12" style="width:150px;vertical-align: middle;">
 		<div style="border:1px solid #4da6ff;padding:3px 0px;">
		<img id="blah" src="../images/store/<?=$arrCol['images']?>" style="height:120px;">
		</div>
		</td> -->
		<td style="width:100px;">ประเภท</td><td colspan='2'>
			<?
  		$sql = "SELECT detail from store_type WHERE code = '".$arrCol["store_type"]."'  ";
  		list($detail) = Mysql_fetch_row(Mysql_Query($sql));
  		echo "<span style='color:#0066ff;'>$detail</span>";
			?>
		</td><td>GFMIS</td><td colspan="3"><span style='color:#0066ff;'><?=$arrCol["gfmis"]?></span></td>



	</tr>
	<tr><td>รหัสครุภัณฑ์</td><td colspan='2'> <span style='color:#0066ff;'><?=$arrCol["code"]?></span></td>
	<tr><td>คุณลักษณะ/ชื่อ</td><td  ><span style='color:#0066ff;'><?=$arrCol["attribute"]?></span></td>
		<td>รุ่นแบบ</td><td><span style='color:#0066ff;'><?=$arrCol["model"]?></span></td></tr>
<tr><td style="width:100px;">Serial number</td><td><span style='color:#0066ff;'><?=$arrCol["serial"]?></span></td>
		<td >หมายเหตุ</td><td colspan="3"><span style='color:#0066ff;'><?=$arrCol["other"]?></span></td></tr>

	<tr><td >สถานที่ติดตั้ง</td><td colspan="3"><span style='color:#0066ff;'><?=$arrCol["installation"]?></span></td>

  		<td rowspan="5" colspan="3" style="width:80px;vertical-align: top;">
 		
 			<?

 			//if($arrCol['images']){
 		//$str_text = "../images/store/".$arrCol['images'];
      	//if (file_exists($str_text)){
      	//$img = $ch[$i];
 			?>
 			<div style="border:1px solid #4da6ff;padding:3px 0px;width:100%;height:90px;overflow: auto;">
		<!-- <img id="blah" src="../images/store/<?=$arrCol['images']?>" style="width:100px;" onclick="img_review('<?=$arrCol['images']?>')"> -->
		
		<?
		//}}

			$ims=explode("#",$arrCol["images"]);
			if($arrCol["images"]){
				if(count($ims)>0){
					for ($r=1; $r < count($ims) ; $r++) { 
					      $str_text = "../images/store/$ims[$r]";
      				      if (file_exists($str_text)){
      				      echo "<img src=\"../images/store/$ims[$r]\" style=\"height:80px;cursor:pointer;\" onclick=\"window.open('../images/store/$ims[$r]','_blank')\">";
      				      }
					}
				}else{
					$str_text = "../images/store/".$arrCol["images"];
					if (file_exists($str_text)){
      				      echo "<img src=\"../images/store/".$arrCol["images"]."\" style=\"height:80px;cursor:pointer;\" onclick=\"window.open('../images/store/".$arrCol["images"]."','_blank')\">";
      				      }
				}
			}

		?>
		</div>
		</td> 

	</tr>
		<tr><td>หน่วยรับผิดชอบ</td><td>
			<?
  		$sql = "SELECT name from department WHERE row_id = '".$arrCol["responsible"]."'  ";
  		list($name) = Mysql_fetch_row(Mysql_Query($sql));
  		echo "<span style='color:#0066ff;'>$name</span>";
			?>
		</td>
	<tr><td >ชื่อผู้ขาย</td><td colspan="3"><span style='color:#0066ff;'><?=$arrCol["seller"]?></span></td>
	<tr><td>โทรศัพท์</td><td><span style='color:#0066ff;'><?=$arrCol["telephone"]?></span></td></tr>
	<tr><td>ที่อยู่</td><td colspan="5"><span style='color:#0066ff;'><?=$arrCol["address"]?></span></td></tr>
	<tr><td colspan="6"><hr></td></tr>
	<tr><td>ประเภทเงิน</td><td>
			<?
  		$sql = "SELECT detail from tbl_typeofmoney WHERE row_id = '".$arrCol["typeofmoney"]."'  ";
  		list($detail) = Mysql_fetch_row(Mysql_Query($sql));
  		echo "<span style='color:#0066ff;'>$detail</span>";
			?>
	
	</td>
		<td>การได้มา</td><td colspan="3">
						<?
  		$sql = "SELECT detail from tbl_acquisition WHERE row_id = '".$arrCol["acquisition"]."'  ";
  		list($detail) = Mysql_fetch_row(Mysql_Query($sql));
  		echo "<span style='color:#0066ff;'>$detail</span>";
			?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?if($arrCol["donor"]!=""){echo "ผู้บริจาค <span style='color:#0066ff;'>$arrCol[donor]</span>";}?></td></tr>
	<tr><td>ที่เอกสาร</td><td><span style='color:#0066ff;'><?=$arrCol["nodocument"]?></span></td>
		<td>วันที่ได้มา</td><td><span style='color:#0066ff;'><?=date_format(date_create($arrCol["daterecipt"]),"d/m/Y")?></span></td></tr>
	<tr><td>จำนวนชุด</td><td><span style='color:#0066ff;'><?=$arrCol["numberofsets"]?></span></td>
		<td>ราคาต่อชุด</td><td><span style='color:#0066ff;'><?=number_convert($arrCol["priceofsets"])?></span></td>
		<td>ราคารวม</td><td><span style='color:#ff3300;'><?=number_convert($arrCol["numberofsets"]*$arrCol["priceofsets"]);?></span> บาท</td></tr>
	<tr><td>อัตราค่าเสื่อม</td><td><span style='color:#0066ff;'><?=$arrCol["depreciation"]?></span><span style="font-size: 12px;">&nbsp;&nbsp;</span></td>
		<td>วิธีคำนวณ</td><td>
		<?
  		$sql = "SELECT detail from tbl_cal WHERE row_id = '".$arrCol["how_cal"]."'  ";
  		list($detail) = Mysql_fetch_row(Mysql_Query($sql));
  		echo "<span style='color:#0066ff;'>$detail</span>";
			?>

		</td><td>อายุการใช้งาน</td><td><span style='color:#0066ff;'><?=$arrCol["lifetime"]?></span> ปี</td></tr>
	<tr><td>ที่อยู่</td><td colspan="6"><span style='color:#0066ff;'><?=$arrCol["address_store"]?></span></td></tr>
	<tr><td>
	<?


	$DateStart = substr($arrCol["daterecipt"],8,2);	//วันเริ่มต้น
	$MonthStart = substr($arrCol["daterecipt"],5,2);	//เดือนเริ่มต้น
	$YearStart = substr($arrCol["daterecipt"],0,4)-543;	//ปีเริ่มต้น

	$DateEnd = date("d");	//วันสิ้นสุด
	$MonthEnd = date("m");	//เดือนสิ้นสุด
	$YearEnd = date("Y");	//ปีสิ้นสุด

	$End = mktime(0,0,0,$MonthEnd,$DateEnd,$YearEnd);
	$Start = mktime(0,0,0,$MonthStart ,$DateStart ,$YearStart);

	$DateNum=ceil(($End -$Start)/86400)+1; // 28




	if($arrCol["depreciation"] > 0 && $arrCol["how_cal"]==1){
		$depreciation_total=(($arrCol["depreciation"]/100)*(($arrCol["numberofsets"]*$arrCol["priceofsets"])-1))/$DateNum;
	}else if($arrCol["how_cal"]==2){
		$depreciation_total=((($arrCol["numberofsets"]*$arrCol["priceofsets"])-1)/(356*$arrCol["lifetime"]))*$DateNum;
	}else if($arrCol["how_cal"]==3){
		$daycal=(356*$arrCol["lifetime"])-$DateNum;
		$depreciation_total=($arrCol["numberofsets"]*$arrCol["priceofsets"])-(($daycal/(356*$arrCol["lifetime"]))*(($arrCol["numberofsets"]*$arrCol["priceofsets"])-1));

	}else if($arrCol["how_cal"]==4){
		$depreciation_total=2*((($arrCol["depreciation"]/100)*(($arrCol["numberofsets"]*$arrCol["priceofsets"])-1))/$DateNum);
	}
	?>
	ค่าเสื่อมสะสม</td><td style="color:red;text-align: center;"><?=number_convert($depreciation_total)?></td><td colspan="5">
		<?
			//print_r($_SESSION);
		  $sql = "SELECT khruphan_edit from user_account WHERE row_id = '".$_SESSION["xid"]."'";
  		  list($khruphan_edit) = Mysql_fetch_row(Mysql_Query($sql));
		if($_GET["row_id"] && $khruphan_edit==1){?>
		<button style="font-size: 14px;" onclick="window.location='new_khruphanth.php?row_id=<?=$_GET["row_id"]?>'">แก้ไข ครุภัณฑ์</button>&nbsp;&nbsp;
		<button style="font-size: 14px;" onclick="cancel_store('<?=$_GET["row_id"]?>','<?=$arrCol["attribute"]?>')">ยกเลิก ครุภัณฑ์</button>&nbsp;&nbsp;
		
		<button style="font-size: 14px;" onclick="fix_reprot('<?=$_GET["row_id"]?>')">บันทึกการซ่อมบำรุง ครุภัณฑ์</button>&nbsp;&nbsp;
		<button style="font-size: 14px;" onclick="hirefix('<?=$_GET["row_id"]?>')">แจ้งซ่อม ครุภัณฑ์</button>
		<?}
		if($_GET["row_id"]){
		?>
		<button style="font-size: 14px;" onclick="kruphan_control('<?=$_GET["row_id"]?>')">ทะเบียนคุมทรัพย์สิน</button>&nbsp;&nbsp;
		<?}?>
	</td></tr>
</table>
</fieldset>
<table style="width:100%;" id="show_fix">
	<thead>
	<td colspan="5" style="color:#0066ff;">บันทึกการแจ้งซ่อม</td>
	<tr>	
	<td style="background-color: #e6e6e6;border:1px solid #a2a2a2;text-align: center;">วันที่</td>
	<td style="background-color: #e6e6e6;border:1px solid #a2a2a2;text-align: center;">เอกสาร</td>
	<td style="background-color: #e6e6e6;border:1px solid #a2a2a2;text-align: center;">รายการ</td>
<!-- 	<td style="background-color: #e6e6e6;border:1px solid #a2a2a2;text-align: center;">จำนวน</td> -->
	<td style="background-color: #e6e6e6;border:1px solid #a2a2a2;text-align: center;">จำนวนเงิน</td>
	<td style="background-color: #e6e6e6;border:1px solid #a2a2a2;text-align: center;">กำหนดซ่อมเสร็จ</td>
	<td style="background-color: #e6e6e6;border:1px solid #a2a2a2;text-align: center;">หมายเหตุ</td>
	</thead>
	<tbody>
	<?
	$sql = "SELECT * from tbl_repair WHERE row_store = '".$_GET["row_id"]."' ORDER By row_id  DESC";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result) ) {

	print "<tr class='cursor_tbl' onclick=\"fix_edit('$row[row_id]')\">
	<td style='border:1px solid #a2a2a2;text-align: center;'>".date_format(date_create($row[dateday]),"d/m/Y")."</td>
	<td style='border:1px solid #a2a2a2;text-align: center;'>$row[no_bill]</td>
	<td style='border:1px solid #a2a2a2;text-align: left;'>$row[detail]</td>
	
	<td style='border:1px solid #a2a2a2;text-align: center;'>".number_convert($row[total_money])."</td>
	<td style='border:1px solid #a2a2a2;text-align: center;'>$row[fix_finished]</td>
	<td style='border:1px solid #a2a2a2;text-align: left;'>$row[other]</td></tr>";
	}
	?>
	</tbody>

</table>
<div id="create_fix" style="display:none;width:100%;height:100%;background-color: rgba(0,0,0,0.6);top:0px;left:0px;position: fixed;">
<div style="width:350px;height:550px;background-color: #ffffff;border:1px solid #a2a2a2;border-radius: 5px;position: fixed;top:50px;left: 50%;margin-left: -175px;box-shadow: 5px 5px 5px rgba(0,0,0,0.3);padding: 10px;">
	<fieldset style="border-color:#4286f4;">
		<legend>บันทึกการแจ้งซ่อม</legend>
	<table style="width:100%">
		<tr><td>วันที่</td><td><input type="text" name="dater_fix" id="dater_fix" style="width:90%;"><input type="hidden" name="row_code"></td></tr>
		<tr><td>เอกสาร</td><td><input type="text" name="no_bill" style="width:90%;"></td></tr>
		<tr><td>รายการ</td><td><input type="text" name="detail" style="width:90%;"></td></tr>
		<tr><td>จำนวน</td><td><input type="text" name="pcs" style="width:90%;"></td></tr>
		<tr><td>จำนวนเงิน</td><td><input type="text" name="total" style="width:90%;"></td></tr>
		<tr><td>กำหนดเสร็จ</td><td><input type="text" name="fix_finished" style="width:90%;"></td></tr>
		<tr><td>หมายเหตุ</td><td><input type="text" name="other" style="width:90%;"></td></tr>
		<tr><td colspan="2" style="text-align: center;"><button id='sv_fix' style="font-size: 16px;cursor: pointer;" onclick="save_fix()">บันทึก</button><button id='up_fix' style="font-size: 16px;cursor: pointer;display:none;" onclick="update_fix()">แก้ไข</button>&nbsp;&nbsp;<button style="font-size: 16px;cursor: pointer;" onclick="close_fix()">ปิด</button></td></tr>
	</table>
	</fieldset>
</div>
</div>

<div id="images_review" style="display:none;width:100%;height:100%;background-color: rgba(0,0,0,0.6);top:0px;left:0px;position: fixed;">
<div style="width:350px;height:350px;background-color: #ffffff;border:1px solid #a2a2a2;border-radius: 5px;position: fixed;top:50%;margin-top:-175px;left: 50%;margin-left: -175px;box-shadow: 5px 5px 5px rgba(0,0,0,0.3);padding: 10px;" onclick="$('#images_review').hide()">
	<img id="imgview" src="" style="margin:0px auto;">
</div>
</div>
</body>
</html>
		<script type="text/javascript">
			function fix_reprot(rx){
				$('#create_fix').show();
				$("input[name=row_code]").val(rx);
				$("#sv_fix").show();
				$("#up_fix").hide();
			}

			function save_fix(){
			var data = "&row_store="+$("input[name=row_code]").val();
				data = data + "&dateday="+$("input[name=dater_fix]").val();
				data = data + "&no_bill="+$("input[name=no_bill]").val();
				data = data + "&detail="+$("input[name=detail]").val();
				data = data + "&pcs="+$("input[name=pcs]").val();
				data = data + "&total="+$("input[name=total]").val();
				data = data + "&other="+$("input[name=other]").val();
				data = data + "&fix_finished="+$("input[name=fix_finished]").val();

			if($("input[name=detail]").val()!=""){
          $.ajax({ 
                url: "mysql_fix.php" ,
                type: "POST",
                data: 'submit=save_fix'+data,
            })
            .success(function(result) {
              //alert(result);
              var td = $("input[name=row_code]").val();
              return_fix(td);
              $('#create_fix').hide();
              $('input[name=row_code]').val('');
              $("input[name=dater_fix]").val('');
			  $("input[name=no_bill]").val('');
			  $("input[name=detail]").val('');
			  $("input[name=pcs]").val('');
			  $("input[name=total]").val('');
			  $("input[name=other]").val('');
			  alert("บันทึกเรียบร้อย");
			});
         }
		}

		function fix_edit(rd){
			$("#create_fix").show();
			$("#sv_fix").hide();
			$("#up_fix").show();

 			$.ajax({ 
                url: "mysql_fix.php" ,
                type: "POST",
                data: 'submit=edit_fix&row_id='+rd,
            })
            .success(function(result) {
              var obj = jQuery.parseJSON(result);
              if(obj != ''){
              	// $("#show_fix tbody tr").empty();
                  $.each(obj, function(key, val) {
              $('input[name=row_code]').val(rd);
              $("input[name=dater_fix]").val(val["dateday"]);
			  $("input[name=no_bill]").val(val["no_bill"]);
			  $("input[name=detail]").val(val["detail"]);
			  $("input[name=pcs]").val(val["pcs"]);
			  $("input[name=total]").val(val["total_money"]);
			  $("input[name=other]").val(val["other"]);
                 // $('#show_fix > tbody:last').append(tr);
                 });
            }
          });
		}

		function close_fix(){
			$('#create_fix').hide();
              $('input[name=row_code]').val('');
              $("input[name=dater_fix]").val('');
			  $("input[name=no_bill]").val('');
			  $("input[name=detail]").val('');
			  $("input[name=pcs]").val('');
			  $("input[name=total]").val('');
			  $("input[name=other]").val('');
		}


			function update_fix(){
			var data = "&row_store="+$("input[name=row_code]").val();
				data = data + "&dateday="+$("input[name=dater_fix]").val();
				data = data + "&no_bill="+$("input[name=no_bill]").val();
				data = data + "&detail="+$("input[name=detail]").val();
				data = data + "&pcs="+$("input[name=pcs]").val();
				data = data + "&total="+$("input[name=total]").val();
				data = data + "&other="+$("input[name=other]").val();
				data = data + "&fix_finished="+$("input[name=fix_finished]").val();

			if($("input[name=detail]").val()!=""){
          $.ajax({ 
                url: "mysql_fix.php" ,
                type: "POST",
                data: 'submit=update_fix'+data,
            })
            .success(function(result) {
              //alert(result);
              return_fix(result);
              $('#create_fix').hide();
              $('input[name=row_code]').val('');
              $("input[name=dater_fix]").val('');
			  $("input[name=no_bill]").val('');
			  $("input[name=detail]").val('');
			  $("input[name=pcs]").val('');
			  $("input[name=total]").val('');
			  $("input[name=other]").val('');
			  alert("บันทึกเรียบร้อย");
			});
         }
		}

		function cancel_store(rd,att){
			var r = confirm("คุณต้องการยกเลิก/ลบ วัสดุ/ครุภัณฑ์ "+att+" ใช่หรือไม่?\nคำเตือน : การยกเลิก/ลบ จะไม่สามารถเรียกคืนได้ใยภายหลัง");
			if(r==true){
          $.ajax({ 
                url: "mysql_fix.php" ,
                type: "POST",
                data: 'submit=del_store&row_tbl='+rd,
            })
            .success(function(result) {	
            			window.location='khruphanth_edit.php?';
			});
			}
		}
		</script>
        <script type="text/javascript" src="../js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
        <link type="text/css" href="../css/jquery-ui-1.8.10.custom.css" rel="stylesheet" /> 
       <script type="text/javascript">
         $("#dater_fix").datepicker({ dateFormat: 'dd-mm-yy', isBuddhist: 'true', defaultDate: 'toDay',
              dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
       </script>