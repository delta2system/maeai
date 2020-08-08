<?
session_start();

     //if (empty($_SESSION["xUser"])){echo "<script>alert('กรุณา ลงทะเบียนก่อนการใช้งาน!!!!')</script>";
      //echo "<script> window.location='../index.php'</script>";};
include("connect.inc");
//include("hospital.inc");

function mount($str){
switch($str)
{
case "01": $str = "มกราคม"; break;
case "02": $str = "กุมภาพันธ์"; break;
case "03": $str = "มีนาคม"; break;
case "04": $str = "เมษายน"; break;
case "05": $str = "พฤษภาคม"; break;
case "06": $str = "มิถุนายน"; break;
case "07": $str = "กรกฏาคม"; break;
case "08": $str = "สิงหาคม"; break;
case "09": $str = "กันยายน"; break;
case "10": $str = "ตุลาคม"; break;
case "11": $str = "พฤศจิกายน"; break;
case "12": $str = "ธันวาคม"; break;
}
return $str;
}

$sql = "SELECT * from tbl_company ";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {
$hp[$row["tbl_title"]]=$row["tbl_value"];

}

if($hp[phone]){
    $hp[phone]= " โทรศัพท์ ".$hp[phone];
}
$company_full = $hp[company_name].$hp[address].$hp[phone];
$company=$hp[company_name];

$row_bill=$_GET["row_bill"];
if($row_bill){

  $strSQL = "SELECT * FROM  tbl_import_head where row_bill = '$row_bill' limit 1 ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = "";
  $arrCol = "";
  while($obResult = mysql_fetch_array($objQuery))
  {
    for($i=1;$i<$intNumField;$i++)
    {

      //$resultArray = mysql_field_name($objQuery,$i);
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      
    }

}


$location_bill=explode("/",$arrCol["nobill_location"]);
$dateday=explode("-",$arrCol["dateday"]);
$datesend=explode("-",$arrCol["datesend"]);
$daterecipt=explode("-",$arrCol["daterecipt"]);
$date_recipt3=explode("-",$arrCol["date_recipt3"]);
$date_recipt4=explode("-",$arrCol["date_recipt4"]);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>.::::.</title>
         <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
        <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
        <script type="text/javascript" src="../js/dropdown_hire.js"></script>
        <style type="text/css">
        @import url(../fonts/thsarabunnew.css);
        body{
    font-family: 'THSarabunNew',tahoma;
    font-size:14px;

}
        .layer-body{
/*            position: relative;
            border-radius: 10px;*/
            width:700px;
            height:700px auto;
            margin: 0px auto;
          /*  background-color:#ffffff; */
            /*box-shadow: 4px 4px 15px #aaa;
            padding: 15px;*/
        }
/*        .layer-contact{
            position: relative;
            width:780px;
            height:600px auto;
            margin: 0px auto;
            background-color:rgba(255,255,255,0.6); 
        }*/

table{
    border-collapse: collapse;
}

  @media print {
    .page_breck {page-break-after: always;}
}
span{
   /* background-color: rgba(150,250,110,0.3);*/
   font-weight: bold;
}
      </style>
<?
if(empty($_GET["review"])){
    echo "<Script Language='JavaScript'>window.print();</Script>";
}
?>
    </head>
    <body>

        <table style="width:680px;margin:0px auto;">
            <tr><td style="text-align: center;font-weight: bold;" colspan="2">รายงานผลการตรวจรับพัสดุ</td></tr>
            <tr><td style="height:10px;"></td></tr>
            <tr><td style="text-align: right;" colspan="2">ตามคำสั่ง<?=$company?>  ที่  ............................<span style="position: absolute;margin-left: -100px;width:100px;text-align: center;"><nl style="background-color:#ffffff; "><?=$location_bill[0]?></nl></span>/.....................<span style="position: absolute;margin-left: -70px;width:70px;text-align: center;"><nl style="background-color:#ffffff; "><?=$location_bill[1]?></nl></span>ลงวันที่...........เดือน.........................พ.ศ……….......
                <span style="position: absolute;margin-left: -220px;"><?=$dateday[2]?></span>
                <span style="position: absolute;margin-left: -156px;"><?=mount($dateday[1])?></span>
                <span style="position: absolute;margin-left: -40px;"><?=$dateday[0]?></span>
            </td></tr>
            <tr><td colspan="2">ได้แต่งตั้งข้าพเจ้าผู้มีรายนามข้างท้ายนี้ เป็นกรรมการตรวจรับ..............................................<span style="position: absolute;margin-left: -160px;width:160px;text-align: center;"><nl style="background-color:#ffffff; "><?=$arrCol["title"]?></nl></span>จำนวน....................<span style="position: absolute;margin-left: -70px;width:70px;text-align: center;"><nl style="background-color:#ffffff; "><?=$arrCol["pcs_recipt"]?></nl></span>รายการ</td></tr>
            <tr><td colspan="2">ในวงเงินทั้งสิ้น...............................................<span style="position: absolute;margin-left: -160px;width:160px;text-align: center;"><nl style="background-color:#ffffff; "><?=number_format($arrCol["total_money"])?></nl></span>บาท (.........................................................................................................)<span style="position: absolute;margin-left: -365px;width:360px;text-align: center;"><nl style="background-color:#ffffff; "><?=$arrCol["total_money"]?></nl></span></td></tr>
            <tr><td colspan="2">ที่ได้สั่งซื้อจาก..........................................................................................................................................................................<span style="position: absolute;width:580px;margin-left: -580px;text-align: center;"><nl style="background-color: #ffffff;"><?=$arrCol["company"]?></nl></span></td></tr>
            <tr><td style="height:10px;"></td></tr>
            <tr><td colspan="2" style="text-align: right;">บัดนี้ ผู้ขายได้นำสิ่งของต่อไปนี้มาส่งมอบ  เมื่อวันที่..................เดือน.......................................พ.ศ.....................
                <span style="position: absolute;margin-left: -300px;background-color: #ffffff;"><?=$datesend[2]?></span>
                <span style="position: absolute;margin-left: -230px;width: 130px;text-align: center;"><nl style="background-color: #ffffff;"><?=mount($datesend[1])?></nl></span>
                <span style="position: absolute;margin-left: -60px;background-color: #ffffff;"><?=$datesend[0]?></span></td></tr>
            <tr><td>ดังมีรายการต่อไปนี้</td></tr>
            <?
            $result = mysql_query("SELECT * FROM tbl_import_body where row_bill = '$row_bill'");
            $num = mysql_num_rows($result);
            if($num>0 && $num <= 10){
            while ($data = mysql_fetch_array($result) ) {
            $r++;
                print "<td style=\"text-align: left;\">$r.........................................................................................<span style=\"width:300px;position: absolute;margin-left:-300px;text-align: left;\"><nl  style=\"background-color: #ffffff;\">".$data["detail"]." จำนวน ".$data["pcs"]." ".$data["unit"]."</nl></span></td>";

                if($r%2==0){
                    print "<tr>";
                }
            }
            for ($r=($r+1); $r <=10 ; $r++) { 
                print "<td style=\"text-align: left;\">$r.........................................................................................<span style=\"width:300px;position: absolute;margin-left:-300px;text-align: left;\"><nl  style=\"background-color: #ffffff;\"></nl></span></td>";    
                                if($r%2==0){
                    print "<tr>";
                }       
            }
            }else{
            ?>
            <tr> 
            <td style="text-align: left;">1.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;">ดังรายการแนบท้ายนี้</nl></span></td>
            <td style="text-align: right;">2.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"></nl></span></td></tr>
            <tr> 
            <td style="text-align: left;">3.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"></nl></span></td>
            <td style="text-align: right;">4.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"></nl></span></td></tr>
            <tr>
            <td style="text-align: left;">5.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"></nl></span></td>
            <td style="text-align: right;">6.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"></nl></span></td></tr>
            <tr>
            <td style="text-align: left;">7.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"></nl></span></td>
            <td style="text-align: right;">8.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"></nl></span></td></tr>
            <tr>
            <td style="text-align: left;">9.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"></nl></span></td>
            <td style="text-align: right;">10.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"></nl></span></td></tr>
            <?}?>


            <tr><td style="height:15px;"></td></tr>
            <tr><td colspan="2" style="text-align: right;">คณะกรรมการได้ทำการตรวจรับสิ่งของ ในวันที่ ..................เดือน..................................พ.ศ……….
                <span style="position: absolute;margin-left: -240px;"><?=$daterecipt[2]?></span>
                <span style="position: absolute;margin-left: -175px;width:120px;text-align: center;"><nl style="background-color: #ffffff;"><?=mount($daterecipt[1])?></nl></span>
                <span style="position: absolute;margin-left: -30px;"><?=$daterecipt[0]?></span></td></tr>
            <tr><td colspan="2" style="text-align: right;">ปรากฏว่าสิ่งของในรายการที่..........................................................................<span style="position: absolute;margin-left: -250px;text-align: center;width:250px;"><nl style="background-color: #ffffff;"><?=$arrCol[pcs_recipt2]?></nl></span>ถูกต้องและครบถ้วน  ส่วนสิ่งของไม่ถูกต้องคือ</td></tr>
            <tr><td colspan="2" style="text-align: left;">......................................................................<span style="position: absolute;margin-left: -240px;width:240px;text-align: center;"><nl style="background-color: #ffffff;"><?=$arrCol[pcs_no]?></nl></span>จึงไม่รับไว้</td></tr>
            <tr><td colspan="2" style="text-align: right;padding-top: 40px;">จึงบันทึก ณ วันที่..................เดือน..................................พ.ศ……...... 
            <span style="position: absolute;margin-left: -250px;background-color: #ffffff;"><?=$date_recipt3[2]?></span>
            <span style="position: absolute;margin-left: -175px;width:110px;text-align: center;"><nl style="background-color: #ffffff;"><?=mount($date_recipt3[1])?></nl></span>
            <span style="position: absolute;margin-left: -35px;background-color: #ffffff;"><?=$date_recipt3[0]?></span></td></tr>
            <tr><td colspan="2" style="text-align: right;padding-top: 40px;">(ลงชื่อ)..................................................................ประธานกรรมการ
            <div style="margin-right: 100px">(.................................................................)<span style="position: absolute;margin-left: -230px;width:225px;text-align: center;"><nl style="background-color:#ffffff; "><?=$arrCol[ceo1]?></nl></span></div>
</td></tr>
            <tr><td colspan="2" style="text-align: right;padding-top: 30px;">(ลงชื่อ)..................................................................กรรมการ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div style="margin-right: 100px">(.................................................................)<span style="position: absolute;margin-left: -230px;width:225px;text-align: center;"><nl style="background-color:#ffffff; "><?=$arrCol[ceo2]?></nl></span></div>
</td></tr>
            <tr><td colspan="2" style="text-align: right;padding-top: 30px;">(ลงชื่อ)..................................................................กรรมการ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div style="margin-right: 100px">(.................................................................)<span style="position: absolute;margin-left: -230px;width:225px;text-align: center;"><nl style="background-color:#ffffff; "><?=$arrCol[ceo3]?></nl></span></div>
</td></tr>

            <tr><td colspan="2" style="text-align: right;padding-top: 20px;">ข้าพเจ้า.....................................................................................ได้รับมอบพัสดุ          จำนวน............................<span style="width:100px;position: absolute;margin-left:-100px;text-align: center;"><nl style="background-color: #ffffff;"><?=$arrCol[pcs_recipt3]?></nl></span>รายการ
                <span style="width:260px;position:absolute;margin-left: -550px;text-align:center;"><nl style="background-color: #ffffff;"><?=$arrCol[ceo_recipt]?></nl></span></td></tr>
            <tr><td>จากคณะกรรมการฯ ไว้เรียบร้อยแล้ว</td></tr>
            <tr><td colspan="2" style="text-align: right;padding-top: 20px;">(ลงชื่อ)..................................................................เจ้าหน้าที่พัสดุ
    <div style="margin-right: 60px;padding-top: 10px;">วันที่............เดือน.........................พ.ศ....................
                <span style="position: absolute;margin-left: -235px;background-color: #ffffff;"><?=$date_recipt4[2]?></span>
                <span style="position: absolute;margin-left: -169px;background-color: #ffffff;"><?=mount($date_recipt4[1])?></span>
                <span style="position: absolute;margin-left: -50px;background-color: #ffffff;"><?=$date_recipt4[0]?></span>
    </div>
</td></tr>

        </table>
<div class="page_breck"></div>





<?
if($num > 10){
?>
<table style="width:680px;margin:0px auto;" >

        <tr>
        <td colspan="2"></td><td style="text-align: right;color:red;">แผ่นต่อที่ <?=$p+1?> </td>
        </tr>
    <tr align="center" >
        <td style="border:1px solid #000;width:40px;">ลำดับ</td>
        <td style="border:1px solid #000;">รายการ</td>
        <td style="border:1px solid #000;width:100px;">จำนวน</td>
        
        </tr>

<?
            $result = mysql_query("SELECT * FROM tbl_import_body where row_bill = '$row_bill'");
            while ($data = mysql_fetch_array($result) ) {
            $j++;
                //print "<td style=\"text-align: left;\">$r.........................................................................................<span style=\"width:300px;position: absolute;margin-left:-300px;text-align: left;\"><nl  style=\"background-color: #ffffff;\">".$data["detail"]." จำนวน ".$data["pcs"]." ".$data["unit"]."</nl></span></td>";
            print "<tr><td style='border:1px solid #000;text-align:center;'>$j</td><td style='border:1px solid #000;'>&nbsp;&nbsp;".$data["detail"]."</td><td style='border:1px solid #000;text-align:center;'>".$data["pcs"]." ".$data["unit"]."</td>";
            }

        for($j++;$j<=25;$j++){
        print "<tr>";
        print "<td style='border:1px solid #000;text-align:center;height:27px;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "</tr>";

        }
            ?>


            <tr><td colspan="3" style="text-align: right;padding-top: 20px;">ข้าพเจ้า.....................................................................................ได้รับมอบพัสดุ          จำนวน............................<span style="width:100px;position: absolute;margin-left:-100px;text-align: center;"><nl style="background-color: #ffffff;">25</nl></span>รายการ
                <span style="width:260px;position:absolute;margin-left: -550px;text-align:center;"><nl style="background-color: #ffffff;"><?=$arrCol[ceo_recipt]?></nl></span></td></tr>
            <tr><td colspan="3">จากคณะกรรมการฯ ไว้เรียบร้อยแล้ว</td></tr>
            <tr><td colspan="3" style="text-align: right;padding-top: 20px;">(ลงชื่อ)..................................................................เจ้าหน้าที่พัสดุ
    <div style="margin-right: 60px;padding-top: 10px;">วันที่............เดือน.........................พ.ศ....................
                <span style="position: absolute;margin-left: -235px;"><?=$date_recipt4[2]?></span>
                <span style="position: absolute;margin-left: -169px;"><?=mount($date_recipt4[1])?></span>
                <span style="position: absolute;margin-left: -50px;"><?=$date_recipt4[0]?></span>
    </div>
</td></tr>


</table>
<?}?>
 <div class="page_breck"></div>


    </body>
    </html>

 