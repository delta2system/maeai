<?
session_start();
include("connect.inc");
?>
<!DOCTYPE html>
<html>
<head>
	<title>รายการสต็อก</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
</head>
<body>
<table style="width:21cm;margin:0px auto;">
  <thead>
  	<tr><td colspan="7" style="text-align: center;font-size: 22px;font-weight: bold;">..::รายการพัสดุ::..</td>
  		<tr><td class="topbar" style="width:60px;border:1px solid #909090;">ลำดับ</td>
		<td class="topbar" style="width:100px;border:1px solid #909090;">กลุ่มสินค้า</td>
		<td class="topbar" style="width:80px;border:1px solid #909090;">รหัส</td>
		<td class="topbar" style="border:1px solid #909090;">รายการ</td>
		<td class="topbar" style="border:1px solid #909090;">หน่วยนับ</td>
		<td class="topbar" style="border:1px solid #909090;">จำนวน</td>
		<td class="topbar" style="border:1px solid #909090;">ราคา</td>
    <!-- <td class="topbar" style="border:1px solid #909090;">อัพเดทล่าสุด</td> -->
  </thead>
  <tbody>
    <?
  if($_GET["group_type"]!='all' && $_GET["group_type"]!=""){
    $search = "WHERE group_type = '".$_GET["group_type"]."' AND ( detail like '%".$_GET["search"]."%' OR barcode like '%".$_GET["search"]."%')";
  }else if($_GET["group_type"]=='' && $_GET["search"]!=""){
    $search = "WHERE  detail like '%".$_GET["search"]."%' OR barcode like '%".$_GET["search"]."%'";
  }else if($_GET["group_type"]=='all' && $_GET["search"]==""){
    $search = "";
  }else{
    $search = "";
  }

$sql = "SELECT * FROM stock_product $search ORDER By barcode ASC";
$result = mysql_query($sql);
while($data = mysql_fetch_array($result)){
$i++;
	        $sql = "SELECT detail from group_type where code = '$data[group_type]'  limit 1  ";
        	list($group_name) = Mysql_fetch_row(Mysql_Query($sql));

                  print "<tr ><td style='text-align:center;' class='border_bt'>$i</td>";
                  print "<td style='text-align:center;' class='border_bt'>$group_name</td>";
                  print "<td style='text-align:center;' class='border_bt'>$data[barcode]</td>";
                  print "<td class='border_bt'>&nbsp;&nbsp;$data[detail]</td>";
                  print "<td style='text-align:center;' class='border_bt'>$data[unit]</td>";
                  print "<td style='text-align:center;' class='border_bt'>$data[pcs]</td>";
                  print "<td style='text-align:right;' class='border_bt'>$data[price_in]&nbsp;</td>";
                  //print "<td style='text-align:center;' class='border_bt'>$data[lastupdate]</td>";
                  print"</tr>";
}



    ?>
  </tbody>
</table>
</body>
</html>
<script type="text/javascript">
	print();
</script>