<?
session_start();
include("connect.inc"); 

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
            if($i==0){
            $returnNumWord.="สิบ";
            }
      }
      $returnNumWord.="สตางค์";
   }else{
      $returnNumWord.="บาทถ้วน";
   }      
    return $returnNumWord;   
}

$sql="SELECT bill.nobill,bill.nobill_recipt,bill.dateday,bill.persanal,department.name FROM bill INNER JOIN department ON bill.customer_id=department.code WHERE nobill_system = '".$_GET["nobill"]."'";
list($nobill,$nobill_recipt,$dateday,$persanal,$name,$address,$phone,$fax) = Mysql_fetch_row(Mysql_Query($sql));

$sql_yx = "SELECT name from personal where code = '$persanal'  limit 1  ";
list($name_personer) = Mysql_fetch_row(Mysql_Query($sql_yx));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"&gt;
<html xmlns="http://www.w3.org/1999/xhtml"&gt;
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>..::ใบเบิกพัสดุ::..</title>
<style type="text/css">
    body {
  /*background: rgb(204,204,204); */
}

table{
border-collapse: collapse;
}
  </style>
</head>
<body >
<table style="width:21cm;margin:0px auto;">
  <thead>
<!--     <tr><td colspan="6" style="text-align: center;">
      <img src="../images/logo_rs.png" width="620px" height="140px"> 
    </td></tr>
    <tr><td colspan="6" style="padding: 10px;font-size: 20px;">
     รายการหนี้ค้างชำระ &nbsp;&nbsp;<span style='color:#0055ff;'><?=$name_customer?>
    </td></tr> -->
    <tr><td colspan="7" style="text-align: center;font-size: 20px;font-weight: bold;color:#E65100;">ใบเบิกพัสดุ</td>
    <tr><td colspan="4"></td><td style="text-align: right;color:#E65100;" colspan="3" >เลขที่ใบเบิกพัสดุ :<div style="float:right;width:100px;height:20px;text-align: center;padding-top: 3px;color:#000000;"><?=$nobill?></div></td></tr>
    <tr><td colspan="4"></td><td style="text-align: right;color:#E65100;" colspan="3">วันที่ :<div style="float:right;width:100px;height:20px;text-align: center;padding-top: 3px;color:#000000;"><?echo date_format(date_create($dateday),"d/m/Y");?></div></td></tr>
    <tr><td colspan="7"><div style="float:left;height:50px;width:100px;margin-top:-3px;color:#E65100;">หน่วยงาน : </div><?=" ".$name?></td>
    <tr><td colspan="4"><div style="float:left;height:30px;width:100px;margin-top:0px;color:#E65100;">รหัสพนักงาน</div> <?=$persanal." : ".$name_personer?></td><td colspan="3" style="text-align: right;color:#E65100;"></td>

  </thead>
  <tbody>
    <tr>
    <td style="text-align: center;background-color: #FB8C00;padding:5px;border:1px solid #909090;color:#ffffff;">ลำดับ</td>
    <td style="text-align: center;background-color: #FB8C00;padding:5px;border:1px solid #909090;color:#ffffff;">รหัสสินค้า</td>
    <td style="text-align: center;background-color: #FB8C00;padding:5px;border:1px solid #909090;color:#ffffff;">สินค้า</td>
    <td style="text-align: center;background-color: #FB8C00;padding:5px;border:1px solid #909090;color:#ffffff;">จำนวน</td>
    <td style="text-align: center;background-color: #FB8C00;padding:5px;border:1px solid #909090;color:#ffffff;">ราคา/หน่วย</td>
    <td style="text-align: center;background-color: #FB8C00;padding:5px;border:1px solid #909090;color:#ffffff;">ราคารวม</td>
    <td style="text-align: center;background-color: #FB8C00;padding:5px;border:1px solid #909090;color:#ffffff;">คงเหลือ</td>
    <td style="text-align: center;background-color: #FB8C00;padding:5px;border:1px solid #909090;color:#ffffff;">หมายเหตุ</td>
</tr>
    <?
$totalmoney=array();


for($a=0;$a<=count($date01);$a++){
//$search4="AND openbill = '".$openx[$a]."'";
$openbillO=explode("-", $date01[$a]);


$sql = "SELECT * from bill where nobill_system = '".$_GET["nobill"]."' ";
$result = mysql_query($sql);
while($data = mysql_fetch_array($result)){
$i++;

if($i%2==0){$bgc="#f7f7f7";}else{$bgc="#ffffff";}
print "<tr style='background-color:$bgc;'>";
print "<td style='text-align:center;border:1px solid #909090;padding:10px;'>$i</td>";
print "<td style='text-align:center;border:1px solid #909090;padding:10px;'>$data[barcode]</td>";
print "<td style='text-align:center;border:1px solid #909090;padding:10px;'>$data[detail]</td>";
print "<td style='text-align:center;border:1px solid #909090;padding:10px;'>$data[pcs]</td>";
print "<td style='text-align:center;border:1px solid #909090;padding:10px;'>$data[price]</td>";
print "<td style='text-align:right;border:1px solid #909090;padding:10px;'>".number_format($data[pcs]*$data[price],2)."&nbsp;&nbsp;</td>";
print "<td style='text-align:center;border:1px solid #909090;padding:10px;'>$data[pcs_stock]</td>";
print "<td style='text-align:center;border:1px solid #909090;padding:10px;font-size:12px;'>$data[other]</td>";
array_push($totalmoney,($data[pcs]*$data[price]));
}
}


print "<tr>";
print "<td colspan='5' style='border:1px solid #909090;padding:10px;background-color:#f0f0f0;'> <span style='font-size:12px;'>ยอดเงินรวมเป็นตัวอักษร</span> ( <span style='font-weight:bold;color:#ff0000;'>".num2wordsThai(array_sum($totalmoney))."</span> )</td>";
print "<td style='text-align:right;border:1px solid #909090;padding:10px;background-color:#FB8C00;color:#ffffff;'>รวมเป็นเงินทั้งสิน</td>";
print "<td style='text-align:right;border:1px solid #909090;padding:10px;' colspan='2'>".number_format(array_sum($totalmoney),2)."&nbsp;฿&nbsp;</td>";

    ?>
  </tbody>
</table>
 </page>
</body>
</html>
<?
echo("<script>print();</script>");
?>



