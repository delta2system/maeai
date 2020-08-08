<?
session_start();
     // if (empty($_SESSION["xUser"])){echo "<script>alert('กรุณา ลงทะเบียนก่อนการใช้งาน!!!!')</script>";
     //  echo "<script> window.location='../index.php'</script>";};
include("connect.inc");

$sql = "SELECT * from tbl_company ";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {
$hp[$row["tbl_title"]]=$row["tbl_value"];

}

if($hp[phone]){
    $hp[phone]= " โทรศัพท์ ".$hp[phone];
}
$company_full = $hp[fullname].$hp[address].$hp[phone];
$company=$hp[fullname];

if($_GET["row_no"]){
$numberno=$_GET["row_no"];
}else{
$numberno=$_SESSION["row_no"];
}
if($numberno){
  $strSQL = "SELECT * FROM  tbl_order_head where row_id = '$numberno' ";
  $rownum = mysql_num_rows(mysql_query($strSQL));
  $strSQL.="ORDER by row_id ASC limit 1";
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

function thai_month($mm) {
$r_month= array( "01" => 'มกราคม',
"02" => 'กุมภาพันธ์',
"03" => 'มีนาคม',
"04" => 'เมษายน',
"05" => 'พฤษภาคม',
"06" => 'มิถุนายน',
"07" => 'กรกฎาคม',
"08" => 'สิงหาคม',
"09" => 'กันยายน',
"10" => 'ตุลาคม',
"11" => 'พฤศจิกายน',
"12" => 'ธันวาคม' );
return $r_month[$mm];
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
   if(isset($num_decimal[1]) && $num_decimal[1]!=0){
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


$dx=explode("/",$arrCol[dateday]);

    function name_sup($str){
    $sql_ns = "select row_id,nameltd from dealer where status = 'Y' ORDER By row_id ASC ";
    $result_ns = mysql_query($sql_ns);
    while ($ns = mysql_fetch_array($result_ns) ) {
      $n=$ns[row_id];
    $name_sup[$n]=$ns[nameltd];
    }
    return $name_sup[$str];
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
    min-height:100%;
    overflow:auto;
    
    font-family: 'THSarabunNew',tahoma;
    font-size:13px;

}
        .layer-body{
            position: relative;
            border-radius: 10px;
            width:21cm;
            height:700px auto;
            margin: 0px auto;
            background-color:#ffffff; 
            margin-top: -25px;
           /* box-shadow: 4px 4px 15px #aaa;*/
        }
        .layer-contact{
            position: relative;
            width:890px;
            height:100px auto;
            margin: 0px auto;
            /*background-color:rgba(255,255,255,0.6); */
        }

        .tx_detail{
            width:21cm;
            height:29.7cm;
            margin:0px auto;
        }

          @media print {
    .page_breck {page-break-after: always;}
}

input[type="text"]{

    border:0px solid #000;
    border-bottom: 1px dashed #909090;
    text-align: center;
    font-family: 'THSarabunNew',Tahoma;
    font-weight: bold;

   /* font-size: 15px;*/

   /* background-color: rgba(100,255,0,0.3);*/

}
table{
    border-collapse: collapse;
}
textarea{
    font-family: 'THSarabunNew',Tahoma;
    /*font-size: 16px;*/
    border:0px solid #999;
    text-align:center;
    /*background-color: rgba(100,255,0,0.3);*/
}

      </style>
      <script type="text/javascript">
          function sent_pad(rx){
    var left = (screen.width/2)-(1200/2);
    var top = (screen.height/2)-(600/2);
          window.open("theorder_pad.php?row_no="+rx,"_blank","toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=870,height=600");
          }
      </script>
    </head>
    <body >
    <div class="layer-body">
    <div class="layer-contact">
    <div style="position:absolute;left:-10px;top:40px;z-index:5;"><img src="../images/thai_government.png" width="60px"></div>
    <br>

 <table style="width:830px;margin-left: -10px;margin-top: 25px;">
    <thead>
        <td colspan="10" style="text-align:center;font-size:26px;font-weight:bold;">บันทึกข้อความ</td><tr>
        <td colspan="10">ส่วนราชการ <?=$company_full?></td><tr>
        <td colspan="5">ที่ <input type="text" name="location" value="<?=$arrCol[location].'/'.$arrCol[nobill_location]?>"></td><td colspan="5">วันที่ &nbsp;&nbsp;<?=substr($arrCol[dateday],8,2)." ".thai_month(substr($arrCol[dateday],5,2))." ".substr($arrCol[dateday],0,4);?></td><tr>
        <td colspan="10">เรื่อง <input type="text" name="list_warehouse" style="width:725px;text-align:left;padding-left:15px;" value="<?=$arrCol[list_warehouse]?>"></td><tr>
        <td colspan="10"><hr></td><tr>
        <td colspan="10">เรียน <input type="text" name="heading" style="width:80%;text-align:left;padding-left:15px;" value='ผู้อำนวยการ<?=$company?>'></td><tr>
        <td colspan="10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ด้วยฝ่าย <input type="text" name="department" value="<?=$arrCol[department]?>" style="width:270px;"> มีความประสงค์ขออนุมัติซื้อ <input type="text" name="list_warehouse" style="width:270px;" value="<?=$arrCol[list_warehouse]?>">
        <br> เพื่อใช้ใน <input type="text" name="idea" style="width:280px;" value="<?=$arrCol[idea]?>">ดังรายการต่อไปนี้
        </td>
        <tr align="center" >
        <td rowspan="2" style="border:1px solid #000;width:40px;">ลำดับ</td>
        <td rowspan="2" style="border:1px solid #000;width:200px;">รายการ</td>
        <td rowspan="2" colspan="2" style="border:1px solid #000;width:100px;">จำนวน</td>
        <td rowspan="2" style="border:1px solid #000;width:100px;"><div style='font-size:12px;margin-top: 0px;'>ราคาหน่วยละ</div><div style="width:100%;text-align: center;font-size: 14px;">(บาท)</div></td>
        <td rowspan="2" style="border:1px solid #000;width:100px;">เป็นเงิน<br>(บาท)</td>
        <td style="border:1px solid #000;font-size: 12px;width:60px;">ราคา<br>มาตราฐาน</td>
        <td style="border:1px solid #000;font-size: 12px;width:60px;">ราคา<br>หลังสุดท้าย</td>
        <td rowspan="2" style="border:1px solid #000;font-size: 10px;width:100px;">กำหนดเวลาที่<br>ต้องการใช้หรือ<br>แล้วเสร็จ</td>
        </tr>
        <tr align="center">
        <td colspan="2" style="border:1px solid #000;">หน่วยละ</td>

        <tr>
        <?
        $strSQL = "SELECT * FROM  tbl_order_body where bill_row = '$numberno' ";
        $row_w = mysql_num_rows(mysql_query($strSQL));
        $strSQL.="ORDER by row_id ASC ";
        $objQuery = mysql_query($strSQL) or die (mysql_error());
        if($row_w<=6){
        while($obResult = mysql_fetch_array($objQuery))
        {
         $e++;
        print "<tr>";
        print "<td style='border:1px solid #000;text-align:center;height:27px;'>$e</td>";
        print "<td style='border:1px solid #000;'>&nbsp;$obResult[detail]</td>";
        print "<td style='border:1px solid #000;text-align:center;'>&nbsp;$obResult[pcs]</td>";
        print "<td style='border:1px solid #000;'>&nbsp;$obResult[unit]</td>";
        print "<td style='border:1px solid #000;text-align:center;'>&nbsp;$obResult[use_rate]</td>";
        print "<td style='border:1px solid #000;text-align:center;'>&nbsp;$obResult[total_price]</td>";
        print "<td style='border:1px solid #000;text-align:center;'>&nbsp;$obResult[medium_price]</td>";
        print "<td style='border:1px solid #000;text-align:center;'>&nbsp;$obResult[last_price]</td>";
        print "<td style='border:1px solid #000;text-align:center;'>&nbsp;$obResult[balance_forward]</td>";

         }  
        }else{
            $e++;
        print "<tr>";
        print "<td style='border:1px solid #000;height:27px;'></td>";
        print "<td style='border:1px solid #000;'>&nbsp;ดังรายการแนบท้ายนี้</td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";


          

          //echo("<script> sent_pad('$numberno');</script>");

        }
         $sql = "SELECT sum(pcs*use_rate) from tbl_order_body WHERE bill_row = '$numberno'  ";
          list($tx_price) = Mysql_fetch_row(Mysql_Query($sql));
        // $sql = "SELECT * FROM  order_pending where numberno = '$numberno' AND status = 'W' ORDER By row_id ASC";
        // $result = mysql_query($sql);
        // $tx_price=0;
        // while ($row = mysql_fetch_array($result) ) {
        // $e++;
        // if($row[row]){
        // $r++;
        // }
        // print "<tr>";
        // print "<td style='border:1px solid #000;text-align:center;'>$row[row]</td>";
        // print "<td style='border:1px solid #000;'>&nbsp;$row[detail]</td>";
        // print "<td style='border:1px solid #000;width:70px;text-align:center;'>$row[pcs]</td>";
        // print "<td style='border:1px solid #000;width:30px;text-align:center;'>$row[unit]</td>";
        // if(empty($row[use_rate])){
        //     $ur="";
        // }else{
        //     $ur=number_format($row[use_rate],2);
        // }
        // print "<td style='border:1px solid #000;text-align:right;'>".$ur."&nbsp;&nbsp;</td>";
        // if(empty($row[total_price])){
        //     $tp="";
        // }else{
        //     $tp=number_format($row[total_price],2);
        // }
        // print "<td style='border:1px solid #000;width:80px;text-align:right;'>".$tp."&nbsp;&nbsp;</td>";
        // if(empty($row[medium_price])){
        //     $mp="";
        // }else{
        //     $mp=number_format($row[medium_price],2);
        // }
        // print "<td style='border:1px solid #000;text-align:center;'>".$mp."&nbsp;&nbsp;</td>";
        // if(empty($row[last_price])){
        //     $lp="";
        // }else{
        //     $lp=number_format($row[last_price],2);
        // }
        // print "<td style='border:1px solid #000;text-align:right;'>".$lp."&nbsp;&nbsp;</td>";
        // print "<td style='border:1px solid #000;text-align:center;'>$row[balance_forward]</td>";
        // $tx_price=$tx_price+$row[total_price];
        // }


        for($e++;$e<=6;$e++){
        print "<tr>";
        print "<td style='border:1px solid #000;height:27px;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        }

// detail,pcs,use_rate,unit,pcs,total_price,medium_price,last_price,balance_forward
//$tx_price = "54586.00";
        ?>
        <tr>
        <td colspan="5" style="text-align:left;"></td>
        <td style="border:1px solid #000;"><div id='tx_price' style="text-align: right;font-weight: bold;"><?=number_format($tx_price,2)?>&nbsp;&nbsp;</div></td><tr>
<!--         <td colspan="10">และขออนุมัติแต่งตั้งคณะกรรมการตรวจรับพัสดุ / ผู้ตรวจรับพัสดุ ประกอบด้วย</td><tr> -->
        <td colspan="10">จำนวน <input type="text" name="" value="<?=$row_w?>" style="width:30px;"> รายการ รวมเป็นเงิน<input type="text" name="" value="<?=number_format($tx_price,2)?>" style="width:100px;"> บาท (- <?=num2wordsThai($tx_price);?> -) ปีงบประมาณ <input type="text" name="year_budgets" style="width:50px;" value="<?=$arrCol[year_budgets]?>"></td><tr>
        <td colspan="2"> 
        <div><span style="font-size: 20px;position: absolute;margin-top: -5px;">&#9645;</span><?if($arrCol[type_order]==1){ echo "&nbsp;<span>&#10004;<span>";}?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; หมวดวัสดุสำนักงาน </div>
        <div><span style="font-size: 20px;position: absolute;margin-top: -5px;">&#9645;</span><?if($arrCol[type_order]==2){ echo "&nbsp;<span>&#10004;<span>";}?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ค่าจ้างเหมา </div></td>
        <td colspan="4">
        <div><span style="font-size: 20px;position: absolute;margin-top: -5px;">&#9645;</span><?if($arrCol[type_order]==3){ echo "&nbsp;<span>&#10004;<span>";}?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; หมวดวัสดุงานบ้าน </div>
        <div><span style="font-size: 20px;position: absolute;margin-top: -5px;">&#9645;</span><?if($arrCol[type_order]==4){ echo "&nbsp;<span>&#10004;<span>";}?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ครุภัณฑ์<input type='text' name='' style='width:140px;' value="<?=$arrCol[choice_kp]?>"> </div>
        </td>
        <td colspan="3">
        <div><span style="font-size: 20px;position: absolute;margin-top: -5px;">&#9645;</span><?if($arrCol[type_order]==5){ echo "&nbsp;<span>&#10004;<span>";}?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; หมวดวัสดุคอมพิวเตอร์ </div>
        <div><span style="font-size: 20px;position: absolute;margin-top: -5px;">&#9645;</span><?if($arrCol[type_order]==6){ echo "&nbsp;<span>&#10004;<span>";}?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; อื่นๆ <input type='text' name='' value="<?=$arrCol[choice_condition]?>" style='width:140px;'> </div>
        </td><tr>
        <td style="text-align:left;" colspan="10">ยอดเงินคงเหลือ<input type="text" name="budgets_total" value="<?=$arrCol[budgets_total]?>">บาท เบิกจ่ายครั้งนี้<input type="text" name="use_budgets" value="<?=$arrCol[use_budgets]?>">บาท คงเหลือ<input type="text" name="use_budgets_total" value="<?=$arrCol[use_budgets_total]?>">บาท</td><tr>
        <td style="text-align:left;" colspan="10">และจะดำเนินการจัดซื้อจัดจ้าง(6),(7) โดยวิธีตกลงราคา เนื่องจากเป็นการจัดซื้อจัดจ้างครึ่งหนึ่งซึ่งไม่เกิน 100,000 บาท</td><tr>
        <td style="text-align:left;" colspan="10">ตามระเบียบฯพัสดุ2535(ฉบับที่ 2) พ.ศ.2538 (7) และที่แก้ไขเพิ่มเติมทุกฉบับ และคำสั่งปฏิบัติราชการแทนผู้่าราชการจังหวัดที่ 4392/2558 ลว.12 ตุลาคม พ.ศ.2558 จึงขอแต่งตั้งผู้ตรวจรับ/คณะกรรมการตรวจรับดังนี้</td><tr>
        <td style="text-align:left;" colspan="10">

        1. <input type="text" name="cob" id="cob" class="cob" style="width:300px;" value="<?=$arrCol[cob]?>"><!--<div id="cob_list" style="margin-top:-30px;margin-left:40px;"></div>-->ตำแหน่ง<input type="text" name="cob_po" id="cob_po" style="width:230px;" value="<?=$arrCol[cob_po]?>"> ประธานกรรมการตรวจรับพัสดุ <br>
        2. <input type="text" name="cmt_1" id="cmt_1" class="cmt_1" style="width:300px;" value="<?=$arrCol[cmt_1]?>"><!--<div id="cmt_1_list" style="margin-top:-30px;margin-left:40px;"></div>-->ตำแหน่ง<input type="text" name="cmt_po1" id="cmt_po1" style="width:230px;" value="<?=$arrCol[cmt_po1]?>"> กรรมการ   <br>
        3. <input type="text" name="cmt_2" id="cmt_2" class="cmt_2" style="width:300px;" value="<?=$arrCol[cmt_2]?>"><!--<div id="cmt_2_list" style="margin-top:-30px;margin-left:40px;"></div>-->ตำแหน่ง<input type="text" name="cmt_po2" id="cmt_po2"style="width:230px;" value="<?=$arrCol[cmt_po2]?>"> กรรมการ   <br>
        </td><tr>
        <td colspan="10" style="">
        ซึ่งเจ้าหน้าที่พัสดุได้ดำเนินการสืบราคาและต่อรองราคาแล้ว เห็นควรจัดซื้อจัดจ้างจาก <input type="hidden" name="companyltd" id="companyltd" style="width:350px;"><input type="text" name="nameltd" id="nameltd" style="width:250px;" value="<?=$arrCol[nameltd]?>"> 
        </td>
        <tr>
          <td></td><td colspan="8">จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติ</td><tr>
       


        <td colspan="5" style="text-align:left;">
        <div>เรียน ผู้อำนวยการ<?=$hp[fullname]?></div>
        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เผื่อโปรดพิจารณาอนุมัติ</div>
        <div style="height:22px;"></div>
        <div>ลงชื่อ..............................................หัวหน้าเจ้าหน้าที่พัสดุ</div>
        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<input type="text" name="cmt_3" style="width:180px;" value='<?=$arrCol[cmt_3]?>'>)</div>
        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text"  name="cmt_po3" style="width:180px;" value='<?=$arrCol[cmt_po3]?>'></div>
        <div style="height:22px;"></div>
        <div style="padding-left:22px;font-weight: bold;">โดยใช้เงินจากงบ</div>
        <div style="padding-left:22px;"><span style="font-size: 20px;position: absolute;margin-top: -5px;">&#9645;</span><?if($arrCol[type_money]==1){ echo "&nbsp;<span>&#10004;<span>";}?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บำรุง</div>
        <div style="padding-left:22px;"><span style="font-size: 20px;position: absolute;margin-top: -5px;">&#9645;</span><?if($arrCol[type_money]==2){ echo "&nbsp;<span>&#10004;<span>";}?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;งบประมาณ</div>
        <div style="padding-left:22px;"><span style="font-size: 20px;position: absolute;margin-top: -5px;">&#9645;</span><?if($arrCol[type_money]==3){ echo "&nbsp;<span>&#10004;<span>";}?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เงินอุดหนุนผู้มีปัญหาสถานะและสิทธิ์</div>
        <div style="padding-left:22px;"><span style="font-size: 20px;position: absolute;margin-top: -5px;">&#9645;</span><?if($arrCol[type_money]==4){ echo "&nbsp;<span>&#10004;<span>";}?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;งบประกันสุขภาพ (UC.)</div>
        </td>
        <td colspan="5" style="text-align:center;">
        <div>ลงชื่อ..................................................เจ้าหน้าที่พัสดุ</div>
        <div>(<input type="text" name="cmt_4" style="width:230px;" value='<?=$arrCol[cmt_4]?>'>)</div>
        <div><input type="text" name="cmt_po4" style="width:230px;" value='<?=$arrCol[cmt_po4]?>'></div>
        <div>อนุมัติ</div>
        <div style="height:30px;"></div>
        <div>(ลงชื่อ)..............................................................</div>
        <div >(<input type="text" name="cmt_5" style="width:230px;" value='<?=$arrCol[cmt_5]?>'>)</div>
        <div style="text-align: center;"><?=nl2br($arrCol[cmt_po5])?></div>

        <div><input type="text" name="date_pass2" style="width:150px;text-align: center;" value='<?=substr($arrCol[date_pass2],8,2)." ".thai_month(substr($arrCol[date_pass2],5,2))." ".substr($arrCol[date_pass2],0,4)?>' placeholder="<?=date("d/m/").(date("Y")+543);?>"></div>
        </td><tr>


        <tr> 
            </thead>
    </table>

 
     </div>    
     </div>
     <div class="page_breck"></div>

<?
if($row_w>6){

$page_count=explode(".",($row_w/35));

if($page_count[1]>0.1){
$page = $page_count[0]+1;
}

$r=0;
for($p=0;$p<$page;$p++){

    $start=$p+$r;
    $end=$r+33;
?>


<table id="tbl_detail" style="margin:0px auto;margin-top: 20px">

        <tr>
        <td colspan="8"></td><td style="text-align: right;color:red;">แผ่นต่อที่ <?=$p+1?> </td>
        </tr>
    <tr align="center" >
        <td rowspan="2" style="border:1px solid #000;width:40px;">ลำดับ</td>
        <td rowspan="2" style="border:1px solid #000;width:200px;">รายการ</td>
        <td rowspan="2" colspan="2" style="border:1px solid #000;width:100px;">จำนวน</td>
        <td rowspan="2" style="border:1px solid #000;width:100px;"><div style='font-size:12px;margin-top: -10px;'>ราคาหน่วยละ</div><div style="width:100%;text-align: center;font-size: 14px;">(บาท)</div></td>
        <td rowspan="2" style="border:1px solid #000;width:100px;">เป็นเงิน<br>(บาท)</td>
        <td style="border:1px solid #000;font-size: 12px;width:60px;">ราคา<br>มาตราฐาน</td>
        <td style="border:1px solid #000;font-size: 12px;width:60px;">ราคา<br>หลังสุดท้าย</td>
        <td rowspan="2" style="border:1px solid #000;font-size: 10px;width:100px;">กำหนดเวลาที่<br>ต้องการใช้หรือ<br>แล้วเสร็จ</td>
        </tr>
        <tr align="center">
        <td colspan="2" style="border:1px solid #000;">หน่วยละ</td>
        </tr>

<?
$sql = "SELECT * from tbl_order_body where bill_row = '$numberno' ORDER By row_id  ASC limit $start,$end";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {
$j++;
        print "<tr>";
        print "<td style='border:1px solid #000;text-align:center;'>$j</td>";
        print "<td style='border:1px solid #000;'>&nbsp;".html_entity_decode($row[detail])."</td>";
        print "<td style='border:1px solid #000;text-align:right;'>".number_format($row[pcs])." &nbsp;</td>";
        print "<td style='border:1px solid #000;text-align:right;'>$row[unit] &nbsp;</td>";
        print "<td style='border:1px solid #000;text-align:right;'>".number_format($row[use_rate],2)." &nbsp;</td>";
        print "<td style='border:1px solid #000;text-align:right;'>".number_format($row[total_price],2)." &nbsp;</td>";
        print "<td style='border:1px solid #000;text-align:right;'>$row[medium_price] &nbsp;</td>";
        print "<td style='border:1px solid #000;text-align:right;'>".number_format($row[last_price],2)." &nbsp;</td>";
        print "<td style='border:1px solid #000;text-align:center;'>$row[balance_forward]</td>";
        print "</tr>";
        }


        for($j++;$j<=33;$j++){
        print "<tr>";
        print "<td style='border:1px solid #000;height:27px;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        }
            ?>
            <tr>
                <td colspan="5" style="text-align: right;">รวมยอดเป็น&nbsp;</td><td style='border:1px solid #000;text-align:right;'><?=number_format($tx_price,2)?>&nbsp;</td>
            </tr>
                <tr><td colspan="4"></td><td colspan="5" style="text-align: center;height:80px;vertical-align: bottom;"> (ลงชื่อ) ..................................................... เจ้าหน้าที่พัสดุ</td></tr>
                <tr><td colspan="4"></td><td colspan="5" style="text-align: center;">(<?=$arrCol[cmt_4]?>)</td></tr>
                <tr><td colspan="4"></td><td colspan="5" style="text-align: center;"> <?=$arrCol[cmt_po4]?></td></tr>

</table>
 <div class="page_breck"></div>

<?}

}?>


    </body>
</html>

<?






if(empty($_GET["review"])){
echo "<script>window.print();</script>";
echo "<Script language='JavaScript'> function CloseWindowsInTime(t){t = t*1000;setTimeout('window.close()',t);} CloseWindowsInTime(2); </Script>";
}
//unset($_SESSION["numberno"]);
?>