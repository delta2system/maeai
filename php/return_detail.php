<?
include("connect.inc");

if($_POST["xTable"]=="search_product"){

  $strSQL = "SELECT * FROM stock_product WHERE detail like '%".$_POST["data"]."%' OR barcode like '%".$_POST["data"]."%' ";
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

    array_push($resultArray,$arrCol);
  }
  
  //mysql_close($Conn);
  
  echo json_encode($resultArray);



}else if($_POST["xTable"]=="search_theorder"){


 // $strSQL = "SELECT * FROM tbl_order_head WHERE nobill_location like '%".$_POST["data"]."%' OR department like '%".$_POST["data"]."%' OR nameltd like '%".$_POST["data"]."%' ORDER By row_id DESC ";
  $strSQL="SELECT tbl_order_body.detail, tbl_order_body.pcs,tbl_order_body.use_rate,tbl_order_body.total_price,tbl_order_head.* ";
  $strSQL.="FROM tbl_order_head INNER JOIN tbl_order_body ON tbl_order_head.row_id=tbl_order_body.bill_row ";
  $strSQL.="WHERE tbl_order_head.companyltd like '%".$_POST["data"]."%' OR tbl_order_body.detail like '%".$_POST["data"]."%' ";
  $strSQL.="OR tbl_order_head.nobill_location like '%".$_POST["data"]."%' limit 0,50";

  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      if(mysql_field_name($objQuery,$i)=="dateday"){
        if($obResult[$i]!="0000-00-00"){
        $arrCol[dateday]= date_format(date_create($obResult[$i]),"d/m/Y");
      }else{
        $arrCol[dateday]="";
      }
      }
    }

  // $sql = "SELECT SUM(total_price) from tbl_order_body WHERE bill_row = '".$arrCol['row_id']."' GROUP By bill_row   ";
  // list($total) = Mysql_fetch_row(Mysql_Query($sql));
 
  //  $arrCol[total_money]=number_format($total,2);

     array_push($resultArray,$arrCol);
  }
  

  //mysql_close($Conn);
  
  echo json_encode($resultArray);



}else if($_POST["xTable"]=="search_hire1"){


  $strSQL = "SELECT * FROM tbl_hire WHERE theorderno like '%".$_POST["data"]."%' OR department like '%".$_POST["data"]."%'  GROUP by order_number ORDER By row_id DESC ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      if(mysql_field_name($objQuery,$i)=="dateday"){
        if($obResult[$i]!="0000-00-00"){
        $arrCol[dateday]= date_format(date_create($obResult[$i]),"d/m/Y");
      }else{
        $arrCol[dateday]="";
      }
      }
    }

  $sql = "SELECT SUM(total) from tbl_hire WHERE order_number = '".$arrCol['order_number']."' GROUP By order_number   ";
  list($total) = Mysql_fetch_row(Mysql_Query($sql));
 
   $arrCol[total_money]=number_format($total,2);

     array_push($resultArray,$arrCol);
  }
  

  //mysql_close($Conn);
  
  echo json_encode($resultArray);



}else if($_POST["xTable"]=="search_hire"){

  $strSQL = "SELECT * FROM tbl_hire WHERE department like '%".$_POST["data"]."%'  ORDER By row_id DESC ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      if(mysql_field_name($objQuery,$i)=="dateday"){
        if($obResult[$i]!="0000-00-00"){
        $arrCol[dateday]= date_format(date_create($obResult[$i]),"d/m/Y");
      }else{
        $arrCol[dateday]="";
      }
      }
    }

  // $sql = "SELECT SUM(total) from tbl_hire WHERE order_number = '".$arrCol[order_number]."' GROUP By order_number   ";
  // list($total_money) = Mysql_fetch_row(Mysql_Query($sql));
 
  //  $arrCol[total_money]=number_format($total_money,2);

     array_push($resultArray,$arrCol);
  }
  

  //mysql_close($Conn);
  
  echo json_encode($resultArray);

}else if($_POST["xTable"]=="search_import"){

  //$strSQL = "SELECT * FROM tbl_import_head WHERE company like '%".$_POST["data"]."%'   ORDER By row_id DESC ";
  $strSQL="SELECT tbl_import_body.detail, tbl_import_body.pcs,tbl_import_body.unit,tbl_import_head.* ";
$strSQL.="FROM tbl_import_head INNER JOIN tbl_import_body ON tbl_import_head.row_bill=tbl_import_body.row_bill ";
$strSQL.="WHERE tbl_import_head.company like '%".$_POST["data"]."%' OR tbl_import_body.detail like '%".$_POST["data"]."%' limit 0,50";

  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      if(mysql_field_name($objQuery,$i)=="dateday"){
        if($obResult[$i]!="0000-00-00"){
      	$arrCol[dateday]= date_format(date_create($obResult[$i]),"d/m/Y");
      }else{
        $arrCol[dateday]="";
      }
      }
    }

  // $sql = "SELECT SUM(total) from tbl_hire WHERE order_number = '".$arrCol[order_number]."' GROUP By order_number   ";
  // list($total_money) = Mysql_fetch_row(Mysql_Query($sql));
 
  //  $arrCol[total_money]=number_format($total_money,2);

     array_push($resultArray,$arrCol);
  }
  

  //mysql_close($Conn);
  
  echo json_encode($resultArray);

}else if($_POST["xTable"]=="search_import2"){

  $strSQL="SELECT tbl_import2_body.detail, tbl_import2_body.pcs,tbl_import2_body.price,tbl_import2_head.* ";
$strSQL.="FROM tbl_import2_head INNER JOIN tbl_import2_body ON tbl_import2_head.row_bill=tbl_import2_body.row_bill ";
$strSQL.="WHERE tbl_import2_head.company like '%".$_POST["data"]."%' OR tbl_import2_body.detail like '%".$_POST["data"]."%' limit 0,50";
  //$strSQL = "SELECT * FROM tbl_import2_head WHERE company like '%".$_POST["data"]."%'   ORDER By row_id DESC ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      if(mysql_field_name($objQuery,$i)=="dateday"){
        if($obResult[$i]!="0000-00-00"){
        $arrCol[dateday]= date_format(date_create($obResult[$i]),"d/m/Y");
      }else{
        $arrCol[dateday]="";
      }
      }else if(mysql_field_name($objQuery,$i)=="daterecipt"){
        if($obResult[$i]!="0000-00-00"){
        $arrCol[daterecipt]= date_format(date_create($obResult[$i]),"d/m/Y");
      }else{
        $arrCol[daterecipt]="";
      }
      }

    }

  // $sql = "SELECT SUM(total) from tbl_hire WHERE order_number = '".$arrCol[order_number]."' GROUP By order_number   ";
  // list($total_money) = Mysql_fetch_row(Mysql_Query($sql));
 
  //  $arrCol[total_money]=number_format($total_money,2);

     array_push($resultArray,$arrCol);
  }
  

  //mysql_close($Conn);
  
  echo json_encode($resultArray);

}else if($_POST["xTable"]=="search_import2_report"){

$strSQL="SELECT tbl_import2_body.detail, tbl_import2_body.pcs,tbl_import2_body.price,tbl_import2_head.* ";
$strSQL.="FROM tbl_import2_head INNER JOIN tbl_import2_body ON tbl_import2_head.row_bill=tbl_import2_body.row_bill ";
$strSQL.="WHERE tbl_import2_head.company like '%".$_POST["data"]."%' OR tbl_import2_body.detail like '%".$_POST["data"]."%' ";
$strSQL.="ORDER By tbl_import2_head.dateday DESC  limit 0,50";
 //$strSQL = "SELECT * FROM tbl_import2_head WHERE company like '%".$_POST["data"]."%'   ORDER By row_id DESC ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
    
      if(mysql_field_name($objQuery,$i)=="dateday"){
        if($obResult[$i]!="0000-00-00"){
        $arrCol[dateday]= date_format(date_create($obResult[$i]),"d/m/Y");
        }else{
        $arrCol[dateday]=""; 
        }
      }else if(mysql_field_name($objQuery,$i)=="datesend"){
        if($obResult[$i]!="0000-00-00"){
        $arrCol[datesend]= date_format(date_create($obResult[$i]),"d/m/Y");
        }else{$arrCol[datesend]="";}
      }else if(mysql_field_name($objQuery,$i)=="type_hire"){
         $sql = "SELECT detail from hire_type WHERE row_id = '".$obResult[$i]."'  ";
         list($type_hire) = Mysql_fetch_row(Mysql_Query($sql));
        $arrCol[type_hire]= $type_hire;
      }else if(mysql_field_name($objQuery,$i)=="department"){
         $sql = "SELECT name from department WHERE code = '".$obResult[$i]."'  ";
         list($name) = Mysql_fetch_row(Mysql_Query($sql));
        $arrCol[department]= $name;
      }else {
          $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      }



    }
     array_push($resultArray,$arrCol);
  }
  echo json_encode($resultArray);

}else if($_POST["xTable"]=="theorder_del"){

  $sql_del = "DELETE FROM tbl_order_head WHERE row_id = '".$_POST["data"]."'  "; 
  $query = mysql_query($sql_del);

  $sql_del = "DELETE FROM tbl_order_body WHERE bill_row = '".$_POST["data"]."'  "; 
  $query = mysql_query($sql_del);

}else if($_POST["xTable"]=="hire_del"){

  $sql_del = "DELETE FROM tbl_hire WHERE order_number = '".$_POST["data"]."'  "; 
  $query = mysql_query($sql_del);

}else{
?>
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<title>.::ค้นหารายการ::.</title>
<style type="text/css">
	@import url(../fonts/thsarabunnew.css);
    body{
    font-family: 'THSarabunNew', tahoma;
	font-weight: bold;
	font-size: 14px;
	}

	.td_border{
		border:1px solid #999;
	}
	.top_bar{
		border:1px solid #999;
		background-color: rgba(0,0,0,0.3);
	}
	table{
		border-collapse: collapse;
	}
	.link_data:hover{
		background-color: rgba(255,0,0,0.3);
		cursor: pointer;
	}
	#layer-contrant{
		margin: 0px auto;
		width:800px;
		height: 300px auto;
	}
	select,input[type="text"]{
	font-family: 'THSarabunNew', tahoma;
	font-weight: bold;
	font-size: 14px;
	width:180px;
	padding-left:20px; 
	}
	button{
	font-family: 'THSarabunNew', tahoma;
	font-weight: bold;
	font-size: 14px;
	width:150px;
	cursor: pointer;
	}
</style>
<script type="text/javascript">
	function return_code(rx){
		var b1=document.getElementById("barcode"+rx).value;
		var d1=document.getElementById("detail"+rx).value;
		var u1=document.getElementById("unit"+rx).value;
		var r1=<?=$row?>;

		  window.opener.document.getElementById("row"+r1).value = r1;
		  window.opener.document.getElementById("barcode"+r1).value = b1;
		  window.opener.document.getElementById("detail"+r1).value = d1;
		  window.opener.document.getElementById("unit"+r1).value = u1;
		  window.opener.document.getElementById("pcs"+r1).focus();
		  window.close();
	}
	function add_product(){
		document.getElementById("add_pro").style.display='';
	}
	function type_p(rx){
		if(rx=="add"){
			//document.getElementById("add_plus").innerHTML = "<input type='text' name='plus' id='plus' >";
			document.getElementById("add_plus").style.display='';
			document.getElementById("plus").style.borderColor="red";
			document.getElementById("plus").focus();
		}
	}
	function close_popup(){
		document.getElementById("add_pro").style.display='none';
	}
	function add_p2(){
		var tx1=document.getElementById("type_product").value;
		var px1=document.getElementById("plus").value;
		var dx1=document.getElementById("detail_add").value;
		var ux1=document.getElementById("unit_add").value;


	$.ajax({
    type: "POST",
    url: "add_product_json.php",
    data: "type_product="+tx1+"&plus="+px1+"&detail_add="+dx1+"&unit_add="+ux1,
    cache: false,
    success: function(html)
    {
    	  var r1=<?=$row?>;
		  window.opener.document.getElementById("row"+r1).value = r1;
		  window.opener.document.getElementById("barcode"+r1).value = html;
		  //$("#ceo_list").html(html).show();
		  window.opener.document.getElementById("unit"+r1).value = ux1;
		  window.opener.document.getElementById("detail"+r1).value = dx1;
		  window.opener.document.getElementById("pcs"+r1).focus();
		  window.close();
    }
    });


	}
</script>
<div id="layer-contrant">
<fieldset><legend style='font-size:24px;'>.::ค้นหาสินค้า::.</legend>
<form name="B1" method="POST" action="">
	<table >
		<td>ค้นหา</td><td><input type="text" name="search" autofocus></td><tr>
		<td colspan="2" align="center"><input type="submit" name="submit" value="ค้นหา" style="padding:3px 40px;font-family: 'THSarabunNew', tahoma;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:blue;font-size:12px;font-weight:bold;cursor:pointer;' onclick='add_product()'>เพิ่มพัสดุใหม่</span></td>
	</table>
</form>
</fieldset>
<br>
<?
if($_POST["submit"]){
print "<table width='100%'>";
print "<td style='text-align:center;height:40px;' class='top_bar'>#</td>";
print "<td style='text-align:center;' class='top_bar'>Barcode</td>";
print "<td style='text-align:center;' class='top_bar'>รายการ</td>";
print "<td style='text-align:center;' class='top_bar'>ราคา</td>";
$sql = "select * from stock_product where detail like '%".$_POST[search]."%' ORDER By barcode ASC  ";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {
$i++;
print "<tr class='link_data' onclick='return_code($i)'>";
print "<td style='text-align:center;' class='top_bar' >$i</td>";
print "<td style='text-align:center;' class='td_border'>$row[barcode] <input type='hidden' id='barcode$i' value='$row[barcode]'></td>";
print "<td style='text-align:left;padding-left:15px;' class='td_border'>$row[detail] <input type='hidden' id='detail$i' value='$row[detail]'></td>";
print "<td style='text-align:right;padding-right:15px;' class='td_border'>$row[price_in]/$row[unit]<input type='hidden' id='unit$i' value='$row[unit]'></td>";
}
}
?>
</table>
</div>

<div id="add_pro" style='position:absolute;width:100%;height:100%;left:0px;top:0px;background:rgba(0,0,0,0.6);display:none;'>
	<div style='position:absolute;width:400px;height:70%;background-color:#fff;left:50%;margin-left:-200px;top:5%;border-radius:25px;padding:50px;'>
		<div style="position:absolute;margin-top:-60px;left:470px;"><img src="../images/box_close.png" width="40px" style="cursor:pointer;" onclick="close_popup()"></div>
		<table width="100%">
			<td colspan="2" style="font-size:36px;background-color:#96ceb4;text-align:center;font-weight:bold;color:#fff;">เพิ่มสินค้า</td><tr>
			<td style="height:50px;">ประเภท</td><td>
			<select name="type_product" id="type_product" onchange="type_p(this.value)">
			<?
			$sql = "select * from type_product ORDER By row_id ASC  ";
			$result = mysql_query($sql);
			while ($row = mysql_fetch_array($result) ) {
			    print "<option value='$row[row_id]'>$row[name]</option>";
			    }
			?>
				<option value="add">เพิ่ม++</option>
			</select>
			</td><tr>
			<td></td><td>
			<div id="add_plus" style="display:none;"><input type='text' name='plus' id='plus' ></div>
			</td><tr>
			<td style="height:50px;">สินค้า</td><td><input type="text" name="detail_add" id="detail_add"></td><tr>
			<td style="height:50px;">หน่วยนับ</td><td><input type="text" name="unit_add" id="unit_add"></td><tr>
			<td style="height:50px;" colspan="2" align="center"><button onclick="add_p2()">เพิ่ม</button></td>
			</table>
	</div>
</div>
<?}?>
