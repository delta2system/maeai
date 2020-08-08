<?
session_start();
include("connect.inc");
if($_SESSION["xusername"]==""){
  echo("<script>alert('กรุณาทำการล็อกอินก่อนใช้งาน');window.location='login.php'</script>");
}

function thai_month($mm) {
switch($mm) {
case '01' : $month = "ม.ค."; break;
case '02' : $month = "ก.พ.";break;
case '03' : $month = "มี.ค.";break;
case '04' : $month = "เม.ย.";break;
case '05' : $month = "พ.ค";break;
case '06' : $month = "มิ.ย.";break;
case '07' : $month = "ก.ค.";break;
case '08' : $month = "ส.ค.";break;
case '09' : $month = "ก.ย.";break;
case '10' : $month = "ต.ค.";break;
case '11' : $month = "พ.ย.";break;
case '12' : $month = "ธ.ค.";break;
}
return $month;
}

function comma_n($str){
  if($str>0){
    return number_format($str);
  }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title> รายงานครุภัณ</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script src="../js/jquery-1.8.0.min.js"></script>
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
     @media print {
  body, page {
    margin: 0;
    box-shadow: 0;
  }
}

 @media print {
    .page_breck {page-break-inside: avoid;}
    /* pre, blockquote {page-break-inside: avoid;}*/
}
	</style>
</head>
<body>
<div style="width:500px;height:50px;text-align:center;font-size: 18px;margin:0px auto;" colspan="10">รายงานครุภัณฑ์จากการได้มา</div>



    <?
    //$sqla="SELECT opcard.hn, opcard.ampur, opcard.tambol FROM tbl_typeofmoney INNER JOIN store ON tbl_typeofmoney.row_id=store.typeofmoney WHERE daterecipt between '".($_GET["year"]-1)."-10-01' AND '".$_GET["year"]."-09-30' ORDER By tbl_typeofmoney.row_id ASC,store.code";
    $sqla = "SELECT * FROM tbl_typeofmoney  ORDER By row_id ASC ";
    $resulta = mysql_query($sqla);
    while($d = mysql_fetch_array($resulta)){
    echo "<table class='page_breck' style='width:290mm;'>";
    echo "<tr><td colspan='10' style='text-align:center;font-size:20px;'>".$d['detail']."</td>";
    echo "<tr><td class='topbar'>ลำดับ</td><td class='topbar'>รายการ</td><td class='topbar'>จุดติดตั้ง</td><td class='topbar'>เลขที่เอกสาร</td><td class='topbar' style='width:180px;'>ผู้ขาย</td><td class='topbar'>วันที่รับ</td><td class='topbar' style='100px'>ราคา</td></tr>";
      $i=0;
      $total=array('');
    $sqlb = "SELECT * FROM store WHERE  typeofmoney = '".$d[row_id]."' AND daterecipt between '".($_GET["year"]-1)."-10-01' AND '".$_GET["year"]."-09-30'  ORDER By row_id ASC ";
    $resultb = mysql_query($sqlb);
    while($data = mysql_fetch_array($resultb)){
      $i++;
      echo "<tr><td valign='top' style='text-align:center;border:1px solid #606060;'>$i</td>"
            ."<td style='padding-left:10px;border:1px solid #606060;'>$data[code] <br> $data[attribute] <br> $data[model]</td>"
            ."<td valign='top' style='text-align:center;border:1px solid #606060;'>$data[installation]</td>"
            ."<td valign='top' style='text-align:center;border:1px solid #606060;width:180px;'>$data[seller]</td>"
            ."<td valign='top' style='text-align:center;border:1px solid #606060;'>$data[nodocument]</td>"
            ."<td valign='top' style='text-align:center;border:1px solid #606060;'>$data[daterecipt]</td>"
            ."<td valign='top' style='text-align:right;border:1px solid #606060;' style='100px'>".comma_n($data[priceofsets])."</td>"
            ."</tr>";
            array_push($total, $data[priceofsets]);

    }
    echo "<tr><td colspan='6' style='text-align:right;padding-right:10px;'>รวมมูลค่า</td><td style='font-size:20px;font-weight:bold;border-bottom:1px double #000000;'>".comma_n(array_sum($total) )."</td>";
      }
    echo "</table>";
    ?>


</body>
</html>
