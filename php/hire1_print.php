<?
session_start();
     // if (empty($_SESSION["xUser"])){echo "<script>alert('กรุณา ลงทะเบียนก่อนการใช้งาน!!!!')</script>";
     //  echo "<script> window.location='../index.php'</script>";};
//include("../login_menu.php");
include("connect.inc");
//include("hospital.inc");

$sql = "SELECT * from tbl_company ";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {
$hp[$row["tbl_title"]]=$row["tbl_value"];

}

if($hp[phone]){
    $hp[phone]= " โทรศัพท์ ".$hp[phone];
}
$company_full = $hp[company_name]." ".$hp[address];
$company=$hp[company_name];

$ordernumber=$_GET["ordernumber"];

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

      if($ordernumber){

  $strSQL = "SELECT * FROM  tbl_hire where order_number = '$ordernumber' ";
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


}

function num2wordsThai($num){   
   $num=str_replace(",","",$num);
   $num_decimal=explode(".",$num);
   $num=$num_decimal[0];
    $returnNumWord;   
    $lenNumber=strlen($num);   
    $lenNumber2=$lenNumber-1;   
    $kaGroup=array("","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน");   
    $kaDigit=array("","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ด","แปด","เก้า");   
   $kaDigitDecimal=array("ศูนย์","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ด","แปด","เก้า");   
    $ii=0;   
    for($i=$lenNumber2;$i>=0;$i--){   
        $kaNumWord[$i]=substr($num,$ii,1);   
        $ii++;   
    }   
    $ii=0;   
    for($i=$lenNumber2;$i>=0;$i--){   
        if(($kaNumWord[$i]==2 && $i==1) || ($kaNumWord[$i]==2 && $i==7)){   
            $kaDigit[$kaNumWord[$i]]="ยี่";   
        }else{   
            if($kaNumWord[$i]==2){   
                $kaDigit[$kaNumWord[$i]]="สอง";        
            }   
            if(($kaNumWord[$i]==1 && $i<=2 && $i==0) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==6)){   
                if($kaNumWord[$i+1]==0){   
                    $kaDigit[$kaNumWord[$i]]="หนึ่ง";      
                }else{   
                    $kaDigit[$kaNumWord[$i]]="เอ็ด";       
                }   
            }elseif(($kaNumWord[$i]==1 && $i<=2 && $i==1) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==7)){   
                $kaDigit[$kaNumWord[$i]]="";   
            }else{   
                if($kaNumWord[$i]==1){   
                    $kaDigit[$kaNumWord[$i]]="หนึ่ง";   
                }   
            }   
        }   
        if($kaNumWord[$i]==0){   
         if($i!=6){
               $kaGroup[$i]="";   
         }
        }   
        $kaNumWord[$i]=substr($num,$ii,1);   
        $ii++;   
        $returnNumWord.=$kaDigit[$kaNumWord[$i]].$kaGroup[$i];   
    }      
   if(isset($num_decimal[1])){
      $returnNumWord.="บาท";
      for($i=0;$i<strlen($num_decimal[1]);$i++){
            $returnNumWord.=$kaDigitDecimal[substr($num_decimal[1],$i,1)];   
      }
      $returnNumWord.="สตางค์";
   }else{
     $returnNumWord.="บาทถ้วน";   
   }      
    return $returnNumWord;   
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>.::Ware House::.</title>
         <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
        <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
        <script type="text/javascript" src="../js/dropdown_hire.js"></script>
        <style type="text/css">
     @import url(../fonts/thsarabunnew.css);
    body{
   font-family: 'THSarabunNew', tahoma;
   font-weight: bold;
    min-height:100%;
    overflow:auto;
    font-size: 12px;

}
        .layer-body{
            position: relative;
            border-radius: 10px;
            width:768px;
            height:700px auto;
            margin: 0px auto;
            background-color:#ffffff; 
            overflow: hidden;
            /*box-shadow: 4px 4px 15px #aaa;*/
            page-break-after: always;
        }
        .layer-contact{
            position: relative;
            width:768px;
            height:100px auto;
            margin: 0px auto;
            background-color:rgba(255,255,255,0.6); 
        }

.div_menu 
{

color: rgb(97, 97, 97);
font-size: 50px;
/*background-color: rgb(233, 233, 233);
border:1px solid #dcdcdc;*/
text-shadow: rgb(224, 224, 224) 1px 1px 0px;
text-align: center;
}
input[type="text"]{
    font-family: 'THSarabunNew', tahoma;
    border:0px solid #000;
    /*border-bottom: 1px dashed #000;*/
    text-align: center;
    font-size: 14px;
    font-weight: bold;
    /*background-color: rgba(100,255,0,0.3);*/
    border-bottom: 2px dotted #000000;

}
table{
    border-collapse: collapse;
}
textarea{
    font-family: 'THSarabunNew', tahoma;
    font-size: 14px;
    border:0px solid #999;
    text-align:center;
    /*background-color: rgba(100,255,0,0.3);*/
}
td{
  padding-top: 3px;
}

      </style>
      <?
      if($ordernumber){

  $strSQL = "SELECT * FROM  tbl_hire where order_number = '$ordernumber' ";
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


}
if(empty($_GET["review"])){
    echo "<Script Language='JavaScript'>window.print();</Script>";
}
?>
    </head>
    <body>

    <div class="layer-body" style="margin-top:0px;padding-bottom:20px;">

    <div style="position:absolute;left:12px;margin-top:40px;z-index:5;"><img src="../images/thai_government.png" width="60px"></div>
    <table width="99%">
       <td colspan="10" style="text-align: center;"><?=$company_full?></td> <tr>
       <td colspan="10" style="text-align: center;">ใบสั่งซื้อ/จ้าง</td> <tr>
       <td colspan="10" style="text-align: center;">เรียน.................................................................................................
         <!-- <input type="text" name="department" style="width:300px;" value='<?=$arrCol[department]?>'> -->
         <span style="position:absolute;width:350px;margin-left: -350px;"><nl style="background-color: #ffffff;"><?=$arrCol[department]?></nl></span>
       </td> <tr>
       <td colspan="10" style="text-align: center;"><?=$hp[fullname]." ".$hp[shotaddress]?> ขอซื้อ/จ้าง ตามรายการต่อไปนี้.</td><tr>

        <tr style="text-align:center;">
        <td rowspan="2" style="border:1px solid #999;width:40px;font-size:14px;">ลำดับ</td>
        <td rowspan="2" style="border:1px solid #999;width:380px;font-size:14px;">รายการ</td>
        <td rowspan="2" style="border:1px solid #999;width:80px;font-size:14px;">ราคา<br>หน่วยละ</td>
        <td rowspan="2" style="border:1px solid #999;width:70px;font-size:14px;">จำนวน<br>สิ่งของ</td>
        <td rowspan="2" style="border:1px solid #999;width:70px;font-size:14px;">หน่วยนับ</td>
        <td rowspan="2" style="border:1px solid #999;width:100px;font-size:14px;">จำนวนเงิน<br>(บาท)</td>
        <td rowspan="2" style="border:1px solid #999;width:100px;font-size:14px;">หมายเหตุ</td> <tr>

<?
$sql = "SELECT * FROM  tbl_hire where order_number = '$ordernumber' ";
$result = mysql_query($sql);
$sum_total=0;
while ($row = mysql_fetch_array($result) ) {
$e++;
print "<tr>";
print "<td style='text-align:center;border:1px solid #999;'>$e</td>";
print "<td style='text-align:left;border:1px solid #999;'>&nbsp;&nbsp;$row[detail]</td>";
print "<td style='text-align:right;border:1px solid #999;'>".number_format($row[price],2)."&nbsp;&nbsp;</td>";
print "<td style='text-align:center;border:1px solid #999;'>$row[pcs]</td>";
print "<td style='text-align:center;border:1px solid #999;'>$row[unit]</td>";

print "<td style='text-align:right;border:1px solid #999;'>".number_format($row[total],2)."&nbsp;&nbsp;</td>";
print "<td style='text-align:center;border:1px solid #999;'>$row[other]</td>";
$sum_total=$sum_total+$row[total];
}
for($i=$e;$i<=20;$i++){?>
        <tr>
        <td style="text-align:center;border:1px solid #999;height:27px;"></td>
        <td style="text-align:center;border:1px solid #999;"></td>
        <td style="text-align:center;border:1px solid #999;"></td>
        <td style="text-align:center;border:1px solid #999;"></td>
        <td style="text-align:center;border:1px solid #999;"></td>
        <td style="text-align:center;border:1px solid #999;"></td>
        <td style="text-align:center;border:1px solid #999;"></td>
<?}?> 

        <tr>
        <td colspan="2">
        การสั่งซื้อ/จ้าง อยู่ภายใต้เงื่อนไขดังต่อไปนี้
        </td>
        <td style="border:1px solid #999;"></td>
        <td style="border:1px solid #999;"></td>
        <td style="border:1px solid #999;"></td>
        <td style="border:1px solid #999;text-align: right;" > <span id="sumtotal"><?=number_format($sum_total,2)?></span>&nbsp;&nbsp;</td>
        <td style="border:1px solid #999;"></td>
        <tr>
        <td colspan="4">
            1. กำหนดส่งมอบภายใน....................<span style="position:absolute;width:70px;margin-left: -70px;text-align: center;"><nl style="background-color: #ffffff;"><?=$arrCol[exdate]?></nl></span><!-- <input type="text" name="exdate" value="<?=$arrCol[exdate]?>" style="width:60px;"> -->วันทำการ</td><tr>
        <td colspan="2">
            2. สถานที่ส่งมอบ..................................................
            <span style="position:absolute;width:185px;margin-left: -185px;text-align: center;"><nl style="background-color: #ffffff;"><?=$arrCol[book_mark]?></nl></span>
            <!-- <input type="text" name="book_mark" value="<?=$arrCol[book_mark]?>" style="width:150px;"> -->
        </td><td  style="text-align: left;">ตัวอักษร </td><td colspan="8" style="text-align: center;"> -<?=num2wordsThai($sum_total)?>-</td><tr>
        <td colspan="4">
            3. ระยะเวลารับประกัน.....................
            <span style="position:absolute;width:70px;margin-left: -70px;text-align: center;"><nl style="background-color: #ffffff;"><?=$arrCol[date_license]?></nl></span>
          <!--   <input type="text" name="date_license" value="<?=$arrCol[date_license]?>" style="width:70px;"> -->
            เดือน
        </td><tr>
        <td colspan="4">
            4. สงวนสิทธิค่าปรับกรณีส่งมอบเกินกำหนดเวลาโดย
        </td><td colspan="6">(ลงชื่อ)..........................................ผู้สั่งซื้อ/จ้าง </td><tr>
        <td colspan="4">
        &nbsp;&nbsp;&nbsp;&nbsp;ปรับรายวันดังนี้
        </td><tr>
        <td colspan="4">
        &nbsp;&nbsp;&nbsp;&nbsp;- ซื้อ/จ้างในอัตราร้อยะ 0.01 - 0.20 ของราคาพัสดุที่ยังไม่ได้รับมอบ
        </td><td colspan="6">(ลงชื่อ)..........................................ผู้รับใบสั่ง </td><tr>
        <td colspan="4">
        &nbsp;&nbsp;&nbsp;&nbsp;- จึงเรียนมาเพื่อโปรดพิจาณณาอนุมัติ
        </td><tr>
        <td colspan="4">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ไม่ต่ำกว่าวันละ 100 บาท
        </td><td colspan="6" style="text-align: center;">
        <?
        if($arrCol[dateday]!="//"){
          echo "วันที่ ".substr($arrCol[dateday],8,2)."&nbsp;&nbsp;".mount(substr($arrCol[dateday],5,2))."&nbsp;&nbsp;พ.ศ.&nbsp;".substr($arrCol[dateday],0,4);
          }else{
          echo "วันที่...........เดือน........................พ.ศ...................";
        }
        ?>
        


        </td><tr>
    </table>
    </form>
     </div>    

    </body>
</html>
<?
if(empty($_GET["view"])){
//echo "<Script Language='JavaScript'> function CloseWindowsInTime(t){t = t*1000;setTimeout('window.close()',t);}CloseWindowsInTime(1); </Script>";
}
?>