<?
session_start();
include("connect.inc");
if($_GET["row_id"]){
  $strSQL = "SELECT * FROM store WHERE row_id = '".$_GET["row_id"]."' limit 1 ";
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
		.button {
  background-color: #ffffff; /* Green */
  border: none;
 font-weight: bold;
 border:1px solid #000000;
  padding: 2px 6px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 12px;
  font-family: tahoma;
  top:-185px;
  margin-left: -25px;
  cursor: pointer;
  position: relative;
  border-radius: 10px;
}
	</style>
	<script type="text/javascript">
		       function imagespreview(input) {
		       //	alert($('#blah').attr('src'));
		 for(i=0;i<input.files.length;i++){

            if (input.files && input.files[i]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                  // $('#blah').attr('src', e.target.result);
                   
                    var img = $("<img />");
                        img.attr("style", "height:200px;");
                        img.attr("src", e.target.result);
                        $("#blah").append(img);
                        $("#blah").css({"background-color":"#000000"});
                //  $("#blah").append("<img src='"+e.target.result+"' style='height:200px;'>");
                };

                reader.readAsDataURL(input.files[i]);
            }
        	}
        }

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

        function submit_frame(){

        	$("#form1").submit();
        	//document.getElementById("form1").submit();
        	//alert("OK");
        }
        function total_cal(){
        	var pcs = parseFloat($("input[name=numberofsets]").val());if ( isNaN(pcs)){pcs = 0;}
        	var price = parseFloat($("input[name=priceofsets]").val());if ( isNaN(price)){price = 0;}
        	$("#total_money").html(addCommas(pcs*price));
        }

        function del_img(str,img,na){
        	$(str).hide();
        	$("#"+img).hide();
  			var na_img = $("input[name=images_row]").val();
  			$("input[name=images_row]").val(na_img.replace("#"+na, ""));


  			$.ajax({ 
                url: "store_submit.php" ,
                type: "POST",
                data: 'submit=del_images&img_del='+na+'&value='+na_img.replace("#"+na, "")+'&row_id='+$('input[name=xrow_id]').val(),
            })
            .success(function(result) {
            	//alert(result);
            });


        }

	</script>
</head>
<body> 
	<fieldset style="width:850px;border-color: #4286f4;">
		<form name="form1" id="form1" method="POST" enctype="multipart/form-data" action="store_submit.php" target="iframe_submit">
		<div style="color: #619bf9;margin-left:120px ;">เพิ่ม/แก้ไขรายละเอียดครุภัณฑ์</div>
<table style="margin:0px auto;">
	<tr>
		<td colspan="6" style="vertical-align: top;border-bottom: 1px solid #a0a0a0;">

		<div style="width:100%;height: 220px;border:1px solid #909090;overflow-y:scroll;background-color: #000000; " id="blah">
			<?
				$ims=explode("#",$arrCol["images"]);
			if($arrCol["images"]){
				if(count($ims)>0){
					for ($r=1; $r < count($ims) ; $r++) { 
						list($width, $height, $type, $attr) = getimagesize("../images/store/$ims[$r]");
						$ha = $height / 200 ; 
						$wa = $width / $ha ;
					echo "<img src=\"../images/store/$ims[$r]\" id=\"img_$r\" style=\"height:200px;\"><span class='button' onclick=\"del_img(this,'img_$r','$ims[$r]')\">X</span>";
					}
				}else{
					echo "<img src=\"../images/store/".$arrCol["images"]." style=\"height:200px;\">";
				}
			}
			?>
				<!-- <img id="blah" src="../images/store/<?=$arrCol["images"]?>" style="height:250px;"> -->
			</div>
			
		</td>
		<tr>
			<td colspan="6"><input type="file" name="fileupload[]" style="font-size: 18px;" multiple="multiple"  onchange="imagespreview(this)">
			<input type="hidden" name="images_row" value="<?=$arrCol["images"]?>"></td>
		<tr>
		<td >ประเภท</td>
		<td><select name="store_type" style="width:200px;">
			<?
			$sql = "SELECT * from store_type ORDER By row_id  ASC";
			$result = mysql_query($sql);
			while ($row = mysql_fetch_array($result) ) {
				if($arrCol["store_type"]==$row[code]){ $ed = "selected";}else{$ed="";}
				print "<option $ed value='$row[code]'>$row[detail]</option>";
			}
			?>

		</select></td>
		<td>รหัสครุภัณฑ์</td><td><input type="text" name="code" value="<?=$arrCol['code']?>" style="width:80%;"></td>
		<td>GFMIS</td><td><input type="text" name="gfmis" value="<?=$arrCol['gfmis']?>" style="width:80%;"></td></tr>
	<tr><td>คุณลักษณะ/ชื่อ</td><td  colspan="3"><input type="text" name="attribute" value="<?=$arrCol['attribute']?>"style="width:80%;"></td>
		<td>รุ่นแบบ</td><td><input type="text" name="model" value="<?=$arrCol['model']?>" style="width:80%;"></td></tr>
<tr><td style="width:100px;">Serial number</td><td><input type="text" name="serial" value="<?=$arrCol['serial']?>" style="width:80%;"></td>
		<td >หมายเหตุ</td><td colspan="3"><input type="text" name="other" value="<?=$arrCol['other']?>" style="width:90%;"></td></tr>

	<tr><td >สถานที่ติดตั้ง</td><td colspan="5"><input type="text" name="installation" value="<?=$arrCol['installation']?>" style="width:95%;"></td>
	<tr><td >หน่วยรับผิดชอบ</td><td>
			<select name="responsible" >
			<?
			$sql = "SELECT * from department ORDER By row_id  ASC";
			$result = mysql_query($sql);
			while ($row = mysql_fetch_array($result) ) {
				if($arrCol["responsible"]==$row[row_id]){ $ed = "selected";}else{$ed="";}
				print "<option $ed value='$row[row_id]'>$row[name]</option>";
			}
			?>
			</select>
		</td></tr>
	<tr><td >ชื่อผู้ขาย</td><td colspan="3"><input type="text" name="seller" value="<?=$arrCol['seller']?>" style="width:400px;"></td>
		<td>โทรศัพท์</td><td><input type="text" name="telephone" value="<?=$arrCol['telephone']?>" style="width:160px;"></td></tr>
	<tr><td>ที่อยู่</td><td colspan="5"><input type="text" name="address" value="<?=$arrCol['address']?>" style="width:95%;"></td></tr>
	<tr><td colspan="6"><hr></td></tr>
	<tr><td>ประเภทเงิน</td>
		<td ><select name="typeofmoney" style="width:200px;">
			<?
			$sql = "SELECT * from tbl_typeofmoney ORDER By row_id  ASC";
			$result = mysql_query($sql);
			while ($row = mysql_fetch_array($result) ) {
				if($arrCol["typeofmoney"]==$row[row_id]){ $ed = "selected";}else{$ed="";}
				print "<option $ed value='$row[row_id]'>$row[detail]</option>";
			}
			?>
		</select> </td>
		<td>การได้มา</td><td colspan="2">
			<select name="acquisition">
			<?
			$sql = "SELECT * from tbl_acquisition ORDER By row_id  ASC";
			$result = mysql_query($sql);
			while ($row = mysql_fetch_array($result) ) {
				if($arrCol["acquisition"]==$row[row_id]){ $ed = "selected";}else{$ed="";}
				print "<option $ed value='$row[row_id]'>$row[detail]</option>";
			}
			?>
			</select>
		</td></tr>
	<tr><td>ที่เอกสาร</td><td><input type="text" name="nodocument" value="<?=$arrCol['nodocument']?>" style="width:90%;"></td>
		<td>วันที่ได้มา</td><td>
			<?
			$dater=explode("-",$arrCol['daterecipt']);
			?>
			<input type="text" name="daterecipt" id="daterecipt" value="<?=$dater[2].'-'.$dater[1].'-'.$dater[0];?>" style="width:90%;"></td></tr>
	<tr><td>จำนวนชุด</td><td><input type="text" name="numberofsets" id="numberofsets" value="<?=$arrCol['numberofsets']?>" style="width:90%;" onkeyup="total_cal()"></td>
		<td>ราคาต่อชุด</td><td><input type="text" name="priceofsets" id="priceofsets" value="<?=$arrCol['priceofsets']?>" style="width:100px;"  onkeyup="total_cal()"></td><td>ราคารวม</td><td><span id="total_money" ><?=number_format($arrCol['numberofsets']*$arrCol['priceofsets']);?></span> บาท</td></tr>
	<tr><td>อัตราค่าเสื่อม</td><td><input type="text" name="depreciation" value="<?=$arrCol['depreciation']?>" style="width:40px;"> <span style="font-size: 12px;">(ไม่คิดใส่ 0%)</span></td>
		<td>วิธีคำนวณ</td><td>
			<select name="how_cal">
			<?
			$sql = "SELECT * from tbl_cal ORDER By row_id  ASC";
			$result = mysql_query($sql);
			while ($row = mysql_fetch_array($result) ) {
				if($arrCol["how_cal"]==$row[row_id]){ $ed = "selected";}else{$ed="";}
				print "<option $ed value='$row[row_id]'>$row[detail]</option>";
			}
			?>
			</select>
		</td><td colspan='2' >อายุการใช้งาน <input type="text" name="lifetime" value="<?=$arrCol['lifetime']?>" style="width:30px;text-align: center;"> ปี</td></tr>
	<tr><td>ที่อยู่</td><td colspan="6"><input type="text" name="address_store" value="<?=$arrCol['address_store']?>" style="width:95%;"></td></tr>
<!-- 	<tr><td colspan="6" style="background-color: #4286f4;"></td></tr> -->
</table>
</fieldset>
	<?if($_GET["row_id"]){?>
	<input type="hidden" name="xrow_id" value="<?=$_GET["row_id"]?>">
	<input type="hidden" name="xSubmit" value="update_store">
	<?}else{?>
	<input type="hidden" name="xSubmit" value="new_store">
	<?}?>
</form>
<div style="background-color: #4286f4;text-align: right;width:870px;padding:5px;margin-left: 2px;">
	<?if($_GET["row_id"]){?>
	<input type="hidden" name="xrow_id" value="<?=$_GET["row_id"]?>">
	<input type="hidden" name="xSubmit" value="update_store">
	<button style="padding:5px 15px;cursor: pointer;border-radius: 15px;" onclick="submit_frame()">แก้ไข</button> 
	<?}else{?>
	<input type="hidden" name="xSubmit" value="new_store">
	<button style="padding:5px 15px;cursor: pointer;border-radius: 15px;" onclick="submit_frame()">Save</button> 	
	<?}?>
	<!-- <button onclick="window.close();" style="padding:5px 15px;cursor: pointer;border-radius: 15px;">Close</button> -->
</div>
<iframe id="iframe_submit" name="iframe_submit" src="" style="width:1100px;height:60px;border:0px solid #e2e2e2;"></iframe>
</body>
</html>

        <script type="text/javascript" src="../js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
        <link type="text/css" href="../css/jquery-ui-1.8.10.custom.css" rel="stylesheet" /> 
       <script type="text/javascript">
         $("#daterecipt").datepicker({ dateFormat: 'dd-mm-yy', isBuddhist: 'true', defaultDate: 'toDay',
              dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
       </script>

