<?
session_start();
include("connect.inc");
?>
<!DOCTYPE html>
<html>
<head>
	<title>..::แผ่นต่อ::..</title>
	<style type="text/css">
		table{
			border-collapse: collapse;
		}
		.tx_detail{
			width:21cm;
			height:29.7cm;
		}
	</style>
</head>
<body>
<div class="tx_detail">
<table id="tbl_detail">
	<thead>
		<tr>
		<td colspan="8"></td><td style="text-align: right;color:red;">แผ่นต่อที่ 1 </td>
		</tr>
	<tr align="center" >
        <td rowspan="2" style="border:1px solid #000;width:40px;">ลำดับ</td>
        <td rowspan="2" style="border:1px solid #000;width:200px;">รายการ</td>
        <td rowspan="2" colspan="2" style="border:1px solid #000;width:100px;">จำนวน</td>
        <td rowspan="2" style="border:1px solid #000;width:100px;"><div style='font-size:14px;margin-top: -10px;'>ราคา<br>หนว่ยละ</div><div style="width:80px;position:absolute;margin-top:-5px;text-align: center;font-size: 14px;">(บาท)</div></td>
        <td rowspan="2" style="border:1px solid #000;width:100px;">เป็นเงิน<br>(บาท)</td>
        <td style="border:1px solid #000;font-size: 12px;width:60px;">ราคา<br>มาตราฐาน</td>
        <td style="border:1px solid #000;font-size: 12px;width:60px;">ราคา<br>หลังสุดท้าย</td>
        <td rowspan="2" style="border:1px solid #000;font-size: 10px;width:100px;">กำหนดเวลาที่<br>ต้องการใช้หรือ<br>แล้วเสร็จ</td>
        </tr>
        <tr align="center">
        <td colspan="2" style="border:1px solid #000;">หน่วยละ</td>
    	</tr>
</thead>
<tbody>
<?
        for($e=1;$e<=62;$e++){
        print "<tr>";
        print "<td style='border:1px solid #000;text-align:center;'>$e</td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "</tr>";
        }
        	?>
        	</tbody>
        	<tfoot>
        		<tr><td colspan="4"></td><td colspan="5" style="text-align: center;height:80px;vertical-align: bottom;"> (ลงชื่อ) ..................................................... เจ้าหน้าที่พัสดุ</td></tr>
        		<tr><td colspan="4"></td><td colspan="5" style="text-align: center;">(นางสุรัตนวดี  ดวงคำ)</td></tr>
        		<tr><td colspan="4"></td><td colspan="5" style="text-align: center;"> เจ้าพนักงานธุรการชำนาญงาน</td></tr>
        	</tfoot>
</table>
</div>
</body>
</html>