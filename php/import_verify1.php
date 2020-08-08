<?
session_start();

     //if (empty($_SESSION["xUser"])){echo "<script>alert('กรุณา ลงทะเบียนก่อนการใช้งาน!!!!')</script>";
      //echo "<script> window.location='../index.php'</script>";};
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
$company_full = $hp[company_name].$hp[address].$hp[phone];
$company=$hp[company_name];

$nonumber=$_GET["nonumber"];
if($nonumber){

  $strSQL = "SELECT * FROM  tbl_hire where order_number = '$nonumber' limit 1 ";
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



$strSQL_num = "SELECT total FROM  tbl_hire where order_number = '$nonumber' ";
$objQuery_num = mysql_query($strSQL_num) or die (mysql_error());
$num_nonumber = mysql_num_rows($objQuery_num);

$strSQL_total = "SELECT SUM(total) FROM  tbl_hire where order_number = '$nonumber' ";
$objQuery_total = mysql_query($strSQL_total) or die (mysql_error());
list($total_money) = Mysql_fetch_row($objQuery_total);

}

if($_GET["nobill"]){

  $strSQL = "SELECT * FROM  tbl_import_head where row_bill = '".$_GET["nobill"]."' limit 1 ";
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
      if($arrCol[nobill_location]){
      $arrCol[theorderno]=$arrCol[nobill_location];
      }
      if($arrCol[pcs_recipt]){
        $num_nonumber=$arrCol[pcs_recipt];
      }
      if($arrCol[total_money]){
        $total_money=$arrCol[total_money];
      }
      if($arrCol[company]){
        $arrCol[department]=$arrCol[company];
      }
    }

}
if($arrCol["dateday"]!="0000-00-00"){$dateday=explode("-",$arrCol["dateday"]);}
if($arrCol["datesend"]!="0000-00-00"){$datesend=explode("-",$arrCol["datesend"]);}
if($arrCol["daterecipt"]!="0000-00-00"){$daterecipt=explode("-",$arrCol["daterecipt"]);}
if($arrCol["date_recipt3"]!="0000-00-00"){$date_recipt3=explode("-",$arrCol["date_recipt3"]);}
if($arrCol["date_recipt4"]!="0000-00-00"){$date_recipt4=explode("-",$arrCol["date_recipt4"]);}


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

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>.::Ware House::.</title>
         <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
        <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
        
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

            .top_bar{
        border:1px solid #999;
        background-color: rgba(0,0,0,0.3);
    }
        .link_data:hover{
        background-color: rgba(255,0,0,0.3);
        cursor: pointer;
    }

table{
    border-collapse: collapse;
}

  @media print {
    .page_breck {page-break-after: always;}
}
span{
   /* background-color: rgba(150,250,110,0.3);*/
   font-weight: bold;
   margin-top: -5px;
}
input[type=text],select{
    background-color: rgba(150,250,110,0.3);
    border:none;
    border-bottom: 1px dotted #000000;
    font-size: 14px;
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
     function search_theorder(ex){
            $("#show_theorder thead tr").remove();
            var td ="<tr>";
                td = td + "<td style='text-align:center;height:40px;' class='top_bar'>#</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>วันที่</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>ร้านค้า</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>รายการ</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>จำนวนเงิน</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>ราคา</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>จำนวนเงิน</td>";
                td = td + "</tr>";
            $('#show_theorder > thead:last').append(td);


      $.ajax({ 
                url: "return_detail.php" ,
                type: "POST",
                data: 'xTable=search_hire&data='+ex,
            })
            .success(function(result) { 
                //alert(result);
                var obj = jQuery.parseJSON(result);
                    if(obj != '')
                    {
                          //$("#myTable tbody tr:not(:first-child)").remove();
                          $("#show_theorder tbody tr").remove();
                          var r=0;
                          $.each(obj, function(key, val) {
                            r++;
                            
                                   var tr = "<tr class='link_data' onclick=\"billorder('"+val["order_number"]+"')\">";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+r+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+val["dateday"]+"</td>";
                                    tr = tr +  "<td style='text-align:left;' class='td_border'>&nbsp;&nbsp;"+val["department"]+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+val["detail"]+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+addCommas(val["pcs"])+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+addCommas(val["price"])+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+addCommas(val["total"])+"</td>";
                                    tr = tr + "</tr>";
                                    $('#show_theorder > tbody:last').append(tr);
                          });
                    }

            });
        }

        function billorder(rd){
            window.location='import_verify1.php?nonumber='+rd;
        }
           function search_import(ex){
            $("#show_import thead tr").remove();
            var td ="<tr>";
                td = td + "<td style='text-align:center;height:40px;' class='top_bar'>#</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>วันที่</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>ร้านค้า</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>รายการ</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>จำนวน</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>ยอดเงินในบิล</td>";
                td = td + "</tr>";
            $('#show_import > thead:last').append(td);


      $.ajax({ 
                url: "return_detail.php" ,
                type: "POST",
                data: 'xTable=search_import&data='+ex,
            })
            .success(function(result) { 
                //alert(result);
                var obj = jQuery.parseJSON(result);
                    if(obj != '')
                    {
                          //$("#myTable tbody tr:not(:first-child)").remove();
                          $("#show_import tbody tr").remove();
                          var r=0;
                          $.each(obj, function(key, val) {
                            r++;
                            
                                   var tr = "<tr class='link_data' onclick=\"billimport('"+val["row_bill"]+"')\">";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+r+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+val["dateday"]+"</td>";
                                    tr = tr +  "<td style='text-align:left;' class='td_border'>&nbsp;&nbsp;"+val["company"]+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+val["detail"]+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+val["pcs"]+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+addCommas(val["total_money"])+"&nbsp;&nbsp;</td>";
                                    tr = tr + "</tr>";
                                    $('#show_import > tbody:last').append(tr);
                          });
                    }

            });
        }
                function billimport(rd){
            window.location='import_verify1.php?nobill='+rd;
        }

        function addrow(){
          /*tbl_rowdetail*/
        var r = document.getElementById("tbl_rowdetail").rows.length;
            r = r+1;
        var t1 = (r*2)-1;
        var t2 = r*2;
        var tr = "<tr><td style=\"text-align: left;\">"+t1+".........................................................................................<span style=\"width:300px;position: absolute;margin-left:-300px;text-align: left;\"><nl  style=\"background-color: #ffffff;\"><input type=\"text\" name=\"detail[]\" style=\"width:100%;\" ></nl></span></td>";
            tr = tr + "<td style=\"text-align: right;\">"+t2+".........................................................................................<span style=\"width:300px;position: absolute;margin-left:-300px;text-align: left;\"><nl  style=\"background-color: #ffffff;\"><input type=\"text\" name=\"detail[]\" style=\"width:100%;\" ></nl></span></td></tr>";
         $('#tbl_rowdetail').append(tr);
        }
</script>
    </head>
    <body>
        <?
        $ox = explode("/",$arrCol[theorderno]);
        ?>
        <form name="B1" id="B1" method="POST" action="<?=$PHP_SELF?>"><input type="hidden" name="row_bill" value="<?=$arrCol[row_bill]?>">
        <table style="width:680px;margin:0px auto;">
            <tr><td style="text-align: center;font-weight: bold;font-size: 21px;" colspan="2">รายงานผลการตรวจรับพัสดุ</td></tr>
            <tr><td style="height:10px;"></td></tr>
            <tr><td style="text-align: right;" colspan="2">ตามคำสั่ง<?=$company?>  ที่  ............................<span style="position: absolute;margin-left: -100px;width:100px;text-align: center;"><nl style="background-color:#ffffff; "><input type="text" name="nobill_location1" value="<?=$ox[0]?>" style="width:80%;"></nl></span>/.....................<span style="position: absolute;margin-left: -70px;width:70px;text-align: center;"><nl style="background-color:#ffffff; "><input type="text" name="nobill_location2" style="width:80%;" value="<?=$ox[1]?>"></nl></span>ลงวันที่...........เดือน.........................พ.ศ……….......
                <span style="position: absolute;margin-left: -230px;width: 30px;"><input type="text" name="today1" value="<?=$dateday[2]?>" style="width:80%;" maxlength="2"></span>
                <span style="position: absolute;margin-left: -176px;width:100px;"><!-- <input type="text" name="today2" style="width:80%;"> -->
                  <select name="today2" style="width:80px;">
                    <option value="0"></option>
                    <option value="1" <?if($dateday[1]=="1"){echo "selected";}?>><?=mount("1")?></option>
                    <option value="2" <?if($dateday[1]=="2"){echo "selected";}?>><?=mount("2")?></option>
                    <option value="3" <?if($dateday[1]=="3"){echo "selected";}?>><?=mount("3")?></option>
                    <option value="4" <?if($dateday[1]=="4"){echo "selected";}?>><?=mount("4")?></option>
                    <option value="5" <?if($dateday[1]=="5"){echo "selected";}?>><?=mount("5")?></option>
                    <option value="6" <?if($dateday[1]=="6"){echo "selected";}?>><?=mount("6")?></option>
                    <option value="7" <?if($dateday[1]=="7"){echo "selected";}?>><?=mount("7")?></option>
                    <option value="8" <?if($dateday[1]=="8"){echo "selected";}?>><?=mount("8")?></option>
                    <option value="9" <?if($dateday[1]=="9"){echo "selected";}?>><?=mount("9")?></option>
                    <option value="10" <?if($dateday[1]=="10"){echo "selected";}?>><?=mount("10")?></option>
                    <option value="11" <?if($dateday[1]=="11"){echo "selected";}?>><?=mount("11")?></option>
                    <option value="12" <?if($dateday[1]=="12"){echo "selected";}?>><?=mount("12")?></option>
                  </select>
                </span>
                <span style="position: absolute;margin-left: -65px;width:70px;"><input type="text" name="today3" value="<?=$dateday[0]?>" style="width:80%;" maxlength="4"></span>
            </td></tr>
            <tr><td colspan="2">ได้แต่งตั้งข้าพเจ้าผู้มีรายนามข้างท้ายนี้ เป็นกรรมการตรวจรับ..............................................<span style="position: absolute;margin-left: -160px;width:160px;text-align: center;"><nl style="background-color:#ffffff; "><input type="text" name="title" value="<?=$arrCol[title]?>" style="width:80%;"></nl></span>จำนวน....................<span style="position: absolute;margin-left: -70px;width:70px;text-align: center;"><nl style="background-color:#ffffff; "><input type="text" name="pcs_recipt"  style="width:80%;" value='<?=$num_nonumber?>'></nl></span>รายการ</td></tr>
            <tr><td colspan="2">ในวงเงินทั้งสิ้น...............................................<span style="position: absolute;margin-left: -160px;width:160px;text-align: center;"><nl style="background-color:#ffffff; "><input type="text" name="total_money" style="width:80%;text-align: center;" value="<?=$total_money?>"></nl></span>บาท (.........................................................................................................)<span style="position: absolute;margin-left: -365px;width:360px;text-align: center;"><nl style="background-color:#ffffff; "><input type="text" name="total_money_text" style="width:80%;text-align: center;" value="<?=num2wordsThai($total_money)?>"></nl></span></td></tr>
            <tr><td colspan="2">ที่ได้สั่งซื้อจาก..........................................................................................................................................................................<span style="position: absolute;width:580px;margin-left: -580px;text-align: center;"><nl style="background-color: #ffffff;"><input type="text" name="company" style="width:90%;" value="<?=$arrCol[department]?>"></nl></span></td></tr>
            <tr><td style="height:10px;"></td></tr>
            <tr><td colspan="2" style="text-align: right;">บัดนี้ ผู้ขายได้นำสิ่งของต่อไปนี้มาส่งมอบ  เมื่อวันที่..................เดือน.......................................พ.ศ.....................
                <span style="position: absolute;margin-left: -300px;width: 30px"><nl><input type="text" name="date" value="<?=$datesend[2]?>" style="width:80%;" maxlength="2" onkeyup="if(event.which==13 || event.keyCode==13){ $('input[name=month]').focus();}"></nl></span>
                <span style="position: absolute;margin-left: -230px;width: 130px;text-align: center;"><nl style="background-color: #ffffff;">
                  <select name="month" style="width:80px;">
                    <option value="0"></option>
                    <option value="1" <?if($datesend[1]=="1"){echo "selected";}?>><?=mount("1")?></option>
                    <option value="2" <?if($datesend[1]=="2"){echo "selected";}?>><?=mount("2")?></option>
                    <option value="3" <?if($datesend[1]=="3"){echo "selected";}?>><?=mount("3")?></option>
                    <option value="4" <?if($datesend[1]=="4"){echo "selected";}?>><?=mount("4")?></option>
                    <option value="5" <?if($datesend[1]=="5"){echo "selected";}?>><?=mount("5")?></option>
                    <option value="6" <?if($datesend[1]=="6"){echo "selected";}?>><?=mount("6")?></option>
                    <option value="7" <?if($datesend[1]=="7"){echo "selected";}?>><?=mount("7")?></option>
                    <option value="8" <?if($datesend[1]=="8"){echo "selected";}?>><?=mount("8")?></option>
                    <option value="9" <?if($datesend[1]=="9"){echo "selected";}?>><?=mount("9")?></option>
                    <option value="10" <?if($datesend[1]=="10"){echo "selected";}?>><?=mount("10")?></option>
                    <option value="11" <?if($datesend[1]=="11"){echo "selected";}?>><?=mount("11")?></option>
                    <option value="12" <?if($datesend[1]=="12"){echo "selected";}?>><?=mount("12")?></option>
                  </select>
                </nl>
                </span>
                <span style="position: absolute;margin-left: -80px;width:70px;"><nl><input type="text" name="year"  value="<?=$datesend[0]?>" maxlength="4" style="width:80%;"></nl></span></td></tr>
            <tr><td>ดังมีรายการต่อไปนี้</td></tr>
            <td colspan="2">
              <table id="tbl_rowdetail" style="width:100%;">
            <?if(empty($_GET["nonumber"]) AND empty($_GET["nobill"])){?>
            <tr> 

            <td style="text-align: left;">1.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"><input type="text" name="detail[]" style="width:100%;"></nl></span></td>
            <td style="text-align: right;">2.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"><input type="text" name="detail[]" style="width:100%;"></nl></span></td></tr>
            <tr> 
            <td style="text-align: left;">3.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"><input type="text" name="detail[]" style="width:100%;"></nl></span></td>
            <td style="text-align: right;">4.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"><input type="text" name="detail[]" style="width:100%;"></nl></span></td></tr>
            <tr>
            <td style="text-align: left;">5.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"><input type="text" name="detail[]" style="width:100%;"></nl></span></td>
            <td style="text-align: right;">6.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"><input type="text" name="detail[]" style="width:100%;"></nl></span></td></tr>
            <tr>
            <td style="text-align: left;">7.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"><input type="text" name="detail[]" style="width:100%;"></nl></span></td>
            <td style="text-align: right;">8.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"><input type="text" name="detail[]" style="width:100%;"></nl></span></td></tr>
            <tr>
            <td style="text-align: left;">9.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"><input type="text" name="detail[]" style="width:100%;"></nl></span></td>
            <td style="text-align: right;">10.........................................................................................<span style="width:300px;position: absolute;margin-left:-300px;text-align: left;"><nl  style="background-color: #ffffff;"><input type="text" name="detail[]" style="width:100%;"></nl></span></td></tr>
            <?}else if($nonumber){
              $strSQL = "SELECT * FROM  tbl_hire where order_number = '$nonumber'  ";
              $objQuery = mysql_query($strSQL) or die (mysql_error());
             while($data = mysql_fetch_array($objQuery))
            {
                $t++;
                print "<td style=\"text-align: left;\">$t.........................................................................................<span style=\"width:300px;position: absolute;margin-left:-300px;text-align: left;\"><nl  style=\"background-color: #ffffff;\"><input type=\"text\" name=\"detail[]\" style=\"width:100%;\" value='$data[detail] จำนวน $data[pcs] $data[unit]'> <input type='hidden' name='barcode[$t]' value='$data[barcode]'></nl></span></td>";

                if($t%2==0){
                    print "<tr>";
                }

            }
          }else if($_GET["nobill"]){
              $strSQL = "SELECT * FROM  tbl_import_body where row_bill = '".$_GET["nobill"]."'  ";
              $objQuery = mysql_query($strSQL) or die (mysql_error());
             while($data = mysql_fetch_array($objQuery))
            {
                $t++;
                print "<td style=\"text-align: left;\">$t.........................................................................................<span style=\"width:300px;position: absolute;margin-left:-300px;text-align: left;\"><nl  style=\"background-color: #ffffff;\"><input type='hidden' name='row_id[]' value='$data[row_id]'><input type=\"text\" name=\"detail[]\" style=\"width:100%;\" value='$data[detail] จำนวน $data[pcs] $data[unit]'><input type='hidden' name='barcode[$t]' value='$data[barcode]'></nl></span></td>";

                if($t%2==0){
                    print "<tr>";
                }

            }




          }
          if($_GET["nonumber"] || $_GET["nobill"]){
            for($t++;$t<=10;$t++){
                print "<td style=\"text-align: left;\">$t.........................................................................................<span style=\"width:300px;position: absolute;margin-left:-300px;text-align: left;\"><nl  style=\"background-color: #ffffff;\"><input type=\"text\" name=\"detail[]\" style=\"width:100%;\" ></nl></span></td>";

                if($t%2==0){
                    print "<tr>";
                } 
            }
           }?>
         </table>
           </td>
            <tr><td style="height:15px;"><div style="color:blue;cursor: pointer;font-weight: bold;" onclick="addrow()">เพิ่ม++</div></td></tr>
            <tr><td colspan="2" style="text-align: right;">คณะกรรมการได้ทำการตรวจรับสิ่งของ ในวันที่ ..................เดือน..................................พ.ศ……….
                <span style="position: absolute;margin-left: -260px;width:50px;"><nl><input type="text" name="date1" value="<?=$daterecipt[2]?>" style="width:100%;" maxlength="2" onkeyup="if(event.which==13 || event.keyCode==13){ $('input[name=month1]').focus();}"></nl></span>
                <span style="position: absolute;margin-left: -170px;width:110px;text-align: center;"><nl style="background-color: #ffffff;">
                  <!-- <input type="text" name="month1" style="width:100%;" onkeyup="if(event.which==13 || event.keyCode==13){ $('input[name=year1]').select();}"> -->
                    <select name="month1" style="width:80px;">
                    <option value="0"></option>
                    <option value="1" <?if($daterecipt[1]=="1"){echo "selected";}?>><?=mount("1")?></option>
                    <option value="2" <?if($daterecipt[1]=="2"){echo "selected";}?>><?=mount("2")?></option>
                    <option value="3" <?if($daterecipt[1]=="3"){echo "selected";}?>><?=mount("3")?></option>
                    <option value="4" <?if($daterecipt[1]=="4"){echo "selected";}?>><?=mount("4")?></option>
                    <option value="5" <?if($daterecipt[1]=="5"){echo "selected";}?>><?=mount("5")?></option>
                    <option value="6" <?if($daterecipt[1]=="6"){echo "selected";}?>><?=mount("6")?></option>
                    <option value="7" <?if($daterecipt[1]=="7"){echo "selected";}?>><?=mount("7")?></option>
                    <option value="8" <?if($daterecipt[1]=="8"){echo "selected";}?>><?=mount("8")?></option>
                    <option value="9" <?if($daterecipt[1]=="9"){echo "selected";}?>><?=mount("9")?></option>
                    <option value="10" <?if($daterecipt[1]=="10"){echo "selected";}?>><?=mount("10")?></option>
                    <option value="11" <?if($daterecipt[1]=="11"){echo "selected";}?>><?=mount("11")?></option>
                    <option value="12" <?if($daterecipt[1]=="12"){echo "selected";}?>><?=mount("12")?></option>
                  </select>
                </nl></span>
                <span style="position: absolute;margin-left: -30px;width:50px;"><nl><input type="text" name="year1" value="<?=$daterecipt[0]?>" maxlength="4" style="width:100%;" ></nl></span></td></tr>
            <tr><td colspan="2" style="text-align: right;">ปรากฏว่าสิ่งของในรายการที่..........................................................................<span style="position: absolute;margin-left: -250px;text-align: center;width:250px;"><nl style="background-color: #ffffff;"><input type="text" name="pcs_recipt2" value="<?=$arrCol[pcs_recipt2]?>" style="width:100%;"></nl></span>ถูกต้องและครบถ้วน  ส่วนสิ่งของไม่ถูกต้องคือ</td></tr>
            <tr><td colspan="2" style="text-align: left;">......................................................................<span style="position: absolute;margin-left: -240px;width:240px;text-align: center;"><nl style="background-color: #ffffff;"><input type="text" name="pcs_no" value="<?=$arrCol[pcs_no]?>"style="width:100%;"></nl></span>จึงไม่รับไว้</td></tr>
            <tr><td colspan="2" style="text-align: right;padding-top: 40px;">จึงบันทึก ณ วันที่..................เดือน..................................พ.ศ……...... 
            <span style="position: absolute;margin-left: -265px;width: 50px"><nl><input type="text" name="date2" maxlength="2" style="width:100%;" value="<?=$date_recipt3[2]?>"></nl></span>
            <span style="position: absolute;margin-left: -175px;width:110px;text-align: center;"><nl style="background-color: #ffffff;">
              <!-- <input type="text" name="month2" style="width:100%;" value="<?=mount(date('m'))?>"> -->
                 <select name="month2" style="width:80px;">
                    <option value="0"></option>
                    <option value="1" <?if($date_recipt3[1]=="1"){ echo "selected";}?>><?=mount("1")?></option>
                    <option value="2" <?if($date_recipt3[1]=="2"){ echo "selected";}?>><?=mount("2")?></option>
                    <option value="3" <?if($date_recipt3[1]=="3"){ echo "selected";}?>><?=mount("3")?></option>
                    <option value="4" <?if($date_recipt3[1]=="4"){ echo "selected";}?>><?=mount("4")?></option>
                    <option value="5" <?if($date_recipt3[1]=="5"){ echo "selected";}?>><?=mount("5")?></option>
                    <option value="6" <?if($date_recipt3[1]=="6"){ echo "selected";}?>><?=mount("6")?></option>
                    <option value="7" <?if($date_recipt3[1]=="7"){ echo "selected";}?>><?=mount("7")?></option>
                    <option value="8" <?if($date_recipt3[1]=="8"){ echo "selected";}?>><?=mount("8")?></option>
                    <option value="9" <?if($date_recipt3[1]=="9"){ echo "selected";}?>><?=mount("9")?></option>
                    <option value="10" <?if($date_recipt3[1]=="10"){ echo "selected";}?>><?=mount("10")?></option>
                    <option value="11" <?if($date_recipt3[1]=="11"){ echo "selected";}?>><?=mount("11")?></option>
                    <option value="12" <?if($date_recipt3[1]=="12"){ echo "selected";}?>><?=mount("12")?></option>
                  </select>
            </nl></span>
            <span style="position: absolute;margin-left: -35px;width:50px;"><nl><input type="text" name="year2" maxlength="4" style="width:100%;" value="<?=$date_recipt3[0]?>"></nl></span</td></tr>
            <tr><td colspan="2" style="text-align: right;padding-top: 40px;">(ลงชื่อ)..................................................................ประธานกรรมการ
            <div style="margin-right: 100px">(.................................................................)<span style="position: absolute;margin-left: -230px;width:225px;text-align: center;"><nl style="background-color:#ffffff; "><input type="text" name="ceo1" value="<?=$arrCol[ceo1]?>" style="width:100%;"></nl></span></div>
</td></tr>
            <tr><td colspan="2" style="text-align: right;padding-top: 30px;">(ลงชื่อ)..................................................................กรรมการ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div style="margin-right: 100px">(.................................................................)<span style="position: absolute;margin-left: -230px;width:225px;text-align: center;"><nl style="background-color:#ffffff; "><input type="text" name="ceo2" value="<?=$arrCol[ceo2]?>"style="width:100%;"></nl></span></div>
</td></tr>
            <tr><td colspan="2" style="text-align: right;padding-top: 30px;">(ลงชื่อ)..................................................................กรรมการ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div style="margin-right: 100px">(.................................................................)<span style="position: absolute;margin-left: -230px;width:225px;text-align: center;"><nl style="background-color:#ffffff; "><input type="text" name="ceo3" value="<?=$arrCol[ceo3]?>"style="width:100%;"></nl></span></div>
</td></tr>

            <tr><td colspan="2" style="text-align: right;padding-top: 20px;">ข้าพเจ้า.....................................................................................ได้รับมอบพัสดุ          จำนวน............................<span style="width:80px;position: absolute;margin-left:-85px;text-align: center;"><nl style="background-color: #ffffff;"><input type="text" name="pcs_recipt3" style="width:100%;" value='<?=$num_nonumber?>'></nl></span>รายการ
                <span style="width:260px;position:absolute;margin-left: -550px;text-align:center;"><nl style="background-color: #ffffff;"><input type="text" name="ceo_recipt" value="<?=$arrCol[ceo_recipt]?>" style="width:100%;"></nl></span></td></tr>
            <tr><td>จากคณะกรรมการฯ ไว้เรียบร้อยแล้ว</td></tr>
            <tr><td colspan="2" style="text-align: right;padding-top: 20px;">(ลงชื่อ)..................................................................เจ้าหน้าที่พัสดุ
    <div style="margin-right: 60px;padding-top: 10px;">วันที่............เดือน.........................พ.ศ....................
                <span style="position: absolute;margin-left: -245px;width:40px;"><nl><input type="text" name="date3" maxlength="2" style="width:100%;" value='<?=$date_recipt3[2]?>'></nl></span>
                <span style="position: absolute;margin-left: -169px;width:70px;"><nl>
                  <!-- <input type="text" name="month3" style="width:100%;" value='<?=mount(date("m"))?>'> -->
                    <select name="month3" style="width:80px;">
                    <option value="0"></option>
                    <option value="1" <?if($date_recipt4[1]=="1"){ echo "selected";}?>><?=mount("1")?></option>
                    <option value="2" <?if($date_recipt4[1]=="2"){ echo "selected";}?>><?=mount("2")?></option>
                    <option value="3" <?if($date_recipt4[1]=="3"){ echo "selected";}?>><?=mount("3")?></option>
                    <option value="4" <?if($date_recipt4[1]=="4"){ echo "selected";}?>><?=mount("4")?></option>
                    <option value="5" <?if($date_recipt4[1]=="5"){ echo "selected";}?>><?=mount("5")?></option>
                    <option value="6" <?if($date_recipt4[1]=="6"){ echo "selected";}?>><?=mount("6")?></option>
                    <option value="7" <?if($date_recipt4[1]=="7"){ echo "selected";}?>><?=mount("7")?></option>
                    <option value="8" <?if($date_recipt4[1]=="8"){ echo "selected";}?>><?=mount("8")?></option>
                    <option value="9" <?if($date_recipt4[1]=="9"){ echo "selected";}?>><?=mount("9")?></option>
                    <option value="10" <?if($date_recipt4[1]=="10"){ echo "selected";}?>><?=mount("10")?></option>
                    <option value="11" <?if($date_recipt4[1]=="11"){ echo "selected";}?>><?=mount("11")?></option>
                    <option value="12" <?if($date_recipt4[1]=="12"){ echo "selected";}?>><?=mount("12")?></option>
                  </select>
                </nl></span>
                <span style="position: absolute;margin-left: -60px;width:50px;"><nl><input type="text" name="year3" maxlength="4" style="width:100%;" value='<?=$date_recipt3[0]?>'></nl></span>
    </div>
</td></tr>
</table>
</form>
<div style="width:100%;text-align: center;margin-top: 50px;">
    <button style="font-size: 14px;cursor: pointer;padding: 5px 15px;" onclick="document.getElementById('B1').submit();">พิมพ์ </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button style="font-size: 14px;cursor: pointer;padding: 5px 15px;" onclick="$('#popup_searchthorder').show()">ค้นหาใบสั่งซื้อ/สั่งจ้าง </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button style="font-size: 14px;cursor: pointer;padding: 5px 15px;" onclick="$('#popup_searchimport').show()">ค้นหาใบตรวจรับ </button>
        </div>
<div class="page_breck"></div>



        <div id="popup_searchthorder" style="display:none;position:fixed;z-index:5;top:10%;left:10%;width: 80%;height:80%;border:1px solid #e0e0e0;border-radius: 5px;box-shadow: 5px 5px 5px rgba(0,0,0,0.3);background-color: #ffffff;">
           

<fieldset><legend style='font-size:24px;'>.::ค้นหา บันทึกข้อความใบสั่งซื้อ/สั่งจ้าง::.</legend>
<form name="B1" method="POST" action="">
    <table width="100%">
        <td>ร้านค้า</td><td><input type="text" name="search" autofocus onkeyup="search_theorder(this.value)"><input type='hidden' name='focus_row' id='focus_row'></td>
        <td align="left"></td>
        <td style="width:50%;text-align: right;">
        <img src="../images/box_close.png" style='cursor: pointer;z-index:6;position: absolute;margin-left: -12px;margin-top: -48px;' onclick='$("#popup_searchthorder").hide();'>
       </td>
    </table>
</form>
</fieldset>
<div style="width:100%;height:72%;overflow: auto;">
<table id="show_theorder" style='margin: 0px auto;width:70%;'>
    <thead>

    </thead>
    <tbody>
        
    </tbody>
</table>
</div>
</div>



        <div id="popup_searchimport" style="display:none;position:fixed;z-index:5;top:10%;left:10%;width: 80%;height:80%;border:1px solid #e0e0e0;border-radius: 5px;box-shadow: 5px 5px 5px rgba(0,0,0,0.3);background-color: #ffffff;">
           

<fieldset><legend style='font-size:24px;'>.::ค้นหา ตรวจรับ::.</legend>
<form name="B1" method="POST" action="">
    <table width="100%">
        <td>ร้านค้า</td><td><input type="text" name="search1" autofocus onkeyup="search_import(this.value)"><input type='hidden' name='focus_row' id='focus_row'></td>
        <td align="left"></td>
        <td style="width:50%;text-align: right;">
        <img src="../images/box_close.png" style='cursor: pointer;z-index:6;position: absolute;margin-left: -12px;margin-top: -48px;' onclick='$("#popup_searchimport").hide();'>
       </td>
    </table>
</form>
</fieldset>
<div style="width:100%;height:72%;overflow: auto;">
<table id="show_import" style='margin: 0px auto;width:70%;'>
    <thead>

    </thead>
    <tbody>
        
    </tbody>
</table>
</div>
</div>
<!--
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
// $sql = "SELECT * from tbl_order_body where bill_row = '$numberno' ORDER By row_id  ASC limit $start,$end";
// $result = mysql_query($sql);
// while ($row = mysql_fetch_array($result) ) {
// $j++;
//         print "<tr>";
//         print "<td style='border:1px solid #000;text-align:center;'>$j</td>";
//         print "<td style='border:1px solid #000;'>&nbsp;".html_entity_decode($row[detail])."</td>";
//         print "<td style='border:1px solid #000;text-align:right;'>".number_format($row[pcs])." &nbsp;</td>";
//         print "<td style='border:1px solid #000;text-align:right;'>$row[unit] &nbsp;</td>";
//         print "<td style='border:1px solid #000;text-align:right;'>".number_format($row[use_rate],2)." &nbsp;</td>";
//         print "<td style='border:1px solid #000;text-align:right;'>".number_format($row[total_price],2)." &nbsp;</td>";
//         print "<td style='border:1px solid #000;text-align:right;'>$row[medium_price] &nbsp;</td>";
//         print "<td style='border:1px solid #000;text-align:right;'>".number_format($row[last_price],2)." &nbsp;</td>";
//         print "<td style='border:1px solid #000;text-align:center;'>$row[balance_forward]</td>";
//         print "</tr>";
//         }


        for($j++;$j<=25;$j++){
        print "<tr>";
        print "<td style='border:1px solid #000;text-align:center;height:27px;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "<td style='border:1px solid #000;'></td>";
        print "</tr>";

        }
            ?>


            <tr><td colspan="3" style="text-align: right;padding-top: 20px;">ข้าพเจ้า.....................................................................................ได้รับมอบพัสดุ          จำนวน............................<span style="width:100px;position: absolute;margin-left:-100px;text-align: center;"><nl style="background-color: #ffffff;">?></nl></span>รายการ
                <span style="width:260px;position:absolute;margin-left: -550px;text-align:center;"><nl style="background-color: #ffffff;">นางสุรัตนวดี ดวงคำ</nl></span></td></tr>
            <tr><td colspan="3">จากคณะกรรมการฯ ไว้เรียบร้อยแล้ว</td></tr>
            <tr><td colspan="3" style="text-align: right;padding-top: 20px;">(ลงชื่อ)..................................................................เจ้าหน้าที่พัสดุ
    <div style="margin-right: 60px;padding-top: 10px;">วันที่............เดือน.........................พ.ศ....................
                <span style="position: absolute;margin-left: -235px;"><?=date("d")?></span>
                <span style="position: absolute;margin-left: -169px;"><?=mount(date("m"))?></span>
                <span style="position: absolute;margin-left: -50px;"><?=date("Y")+543?></span>
    </div>
</td></tr>


</table>
 <div class="page_breck"></div>-->
 

    </body>
    </html>

 <?
//print_r($_POST);

// $strSQL = "INSERT INTO bill SET "; 
// $strSQL .="nobill_system = '".$new_nobill_system."' ";
// $strSQL .=",nobill = '".$_POST["nobill"]."' ";
// $strSQL .=",nobill_recipt = '".$_POST["order_bill"]."' ";
// $strSQL .=",dateday = '".date("Y-m-d")."' ";
// $strSQL .=",lasttime = '".date("H:i:s")."' ";
// $strSQL .=",customer_id = '".$_POST["customer_id"]."' ";
// $strSQL .=",customer_name = '".$_POST["customer_name"]."' ";
// $strSQL .=",persanal = '".$_POST["persanal_id"]."' ";
// $strSQL .=",barcode = '".$obResult["barcode"]."' ";
// $strSQL .=",detail = '".$obResult["detail"]."' ";
// $strSQL .=",laststock = '".$laststock."' ";
// $strSQL .=",pcs = '".$obResult["pcs"]."' ";
// $strSQL .=",price = '".$obResult["price"]."' ";
// $strSQL .=",pcs_stock = '".($laststock+$obResult["pcs"])."' ";
// $strSQL .=",status = '".$_POST["status"]."' ";
// $strSQL .=",officer = '".$_SESSION["xusername"]."' ";
// $objQuery = mysql_query($strSQL);
if(empty($_POST["row_bill"]) && $_POST){

  $sql = "SELECT row_bill from tbl_import_head ORDER By row_bill DESC  limit 1  ";
  list($row_bill) = Mysql_fetch_row(Mysql_Query($sql));

  $strSQL = "INSERT INTO tbl_import_head SET "; 
  $strSQL .="row_bill= '".($row_bill+1)."'"; 
  $strSQL .=",nobill_location = '".$_POST["nobill_location1"]."/".$_POST["nobill_location2"]."'"; 
  $strSQL .=",dateday= '".$_POST["today3"]."-".$_POST["today2"]."-".$_POST["today1"]."'"; 
  $strSQL .=",title= '".$_POST["title"]."'"; 
  $strSQL .=",pcs_recipt= '".$_POST["pcs_recipt"]."'"; 
  $strSQL .=",total_money= '".$_POST["total_money"]."'"; 
  $strSQL .=",company= '".$_POST["company"]."'";  
  $strSQL .=",datesend= '".$_POST["year"]."-".$_POST["month"]."-".$_POST["date"]."'"; 
  $strSQL .=",daterecipt= '".$_POST["year1"]."-".$_POST["month1"]."-".$_POST["date1"]."'"; 
  $strSQL .=",pcs_recipt2= '".$_POST["pcs_recipt2"]."'"; 
  $strSQL .=",pcs_no= '".$_POST["pcs_no"]."'"; 
  $strSQL .=",date_recipt3= '".$_POST["year2"]."-".$_POST["month2"]."-".$_POST["date2"]."'"; 
  $strSQL .=",ceo1= '".$_POST["ceo1"]."'";  
  $strSQL .=",ceo2= '".$_POST["ceo2"]."'";  
  $strSQL .=",ceo3= '".$_POST["ceo3"]."'";  
  $strSQL .=",ceo_recipt= '".$_POST["ceo_recipt"]."'";  
  $strSQL .=",pcs_recipt3= '".$_POST["pcs_recipt3"]."'";  
  $strSQL .=",date_recipt4= '".$_POST["year3"]."-".$_POST["month3"]."-".$_POST["date3"]."'"; 
  $strSQL .=",officer = '".$_SESSION["xusername"]."'";
  $objQuery = mysql_query($strSQL)or die(mysql_error());
  //[detail] => Array ( [0] => [1] => [2] => [3] => [4] => [5] => [6] => [7] => [8] => [9] => ) 

  for ($i=0; $i < count($_POST["detail"]); $i++) { 
    if($_POST["detail"][$i]){
   $de=explode("จำนวน", $_POST["detail"][$i]);
   $ps=explode(" ", $de[1]);
  $strSQL = "INSERT INTO tbl_import_body SET "; 
  $strSQL .="row_bill= '".($row_bill+1)."'"; 
  $strSQL .=",barcode = '".$_POST["barcode"][($i+1)]."'"; 
  $strSQL .=",detail = '".$de[0]."'"; 
  $strSQL .=",pcs= '".$ps[1]."'"; 
  $strSQL .=",unit= '".$ps[2]."'"; 
  $objQuery = mysql_query($strSQL)or die(mysql_error());
  }
}
echo ("<script> window.location='import_verify1_print.php?row_bill=".($row_bill+1)."'</script>");
}else if($_POST["row_bill"]){

  //$strSQL = "INSERT INTO tbl_import_head SET "; 
  $strSQL = "UPDATE tbl_import_head SET ";
  $strSQL .="nobill_location = '".$_POST["nobill_location1"]."/".$_POST["nobill_location2"]."'"; 
  $strSQL .=",dateday= '".$_POST["today3"]."-".$_POST["today2"]."-".$_POST["today1"]."'"; 
  $strSQL .=",title= '".$_POST["title"]."'"; 
  $strSQL .=",pcs_recipt= '".$_POST["pcs_recipt"]."'"; 
  $strSQL .=",total_money= '".$_POST["total_money"]."'"; 
  $strSQL .=",company= '".$_POST["company"]."'";  
  $strSQL .=",datesend= '".$_POST["year"]."-".$_POST["month"]."-".$_POST["date"]."'"; 
  $strSQL .=",daterecipt= '".$_POST["year1"]."-".$_POST["month1"]."-".$_POST["date1"]."'"; 
  $strSQL .=",pcs_recipt2= '".$_POST["pcs_recipt2"]."'"; 
  $strSQL .=",pcs_no= '".$_POST["pcs_no"]."'"; 
  $strSQL .=",date_recipt3= '".$_POST["year2"]."-".$_POST["month2"]."-".$_POST["date2"]."'"; 
  $strSQL .=",ceo1= '".$_POST["ceo1"]."'";  
  $strSQL .=",ceo2= '".$_POST["ceo2"]."'";  
  $strSQL .=",ceo3= '".$_POST["ceo3"]."'";  
  $strSQL .=",ceo_recipt= '".$_POST["ceo_recipt"]."'";  
  $strSQL .=",pcs_recipt3= '".$_POST["pcs_recipt3"]."'";  
  $strSQL .=",date_recipt4= '".$_POST["year3"]."-".$_POST["month3"]."-".$_POST["date3"]."'"; 
  $strSQL .=",officer = '".$_SESSION["xusername"]."'";
  $strSQL .="WHERE row_bill = '".$_POST["row_bill"]."' ";
  $objQuery = mysql_query($strSQL)or die(mysql_error());


  for ($i=0; $i < count($_POST["row_id"]); $i++) { 

  if($_POST["detail"][$i]){
  $de=explode("จำนวน", $_POST["detail"][$i]);
  $ps=explode(" ", $de[1]);

  //$strSQL = "INSERT INTO tbl_import_body SET "; 
  $strSQL = "UPDATE tbl_import_body SET ";
  $strSQL .="detail = '".$de[0]."'"; 
  $strSQL .=",pcs= '".$ps[1]."'"; 
  $strSQL .=",unit= '".$ps[2]."'"; 
  $strSQL .="WHERE row_id = '".$_POST["row_id"][$i]."' ";  
  $objQuery = mysql_query($strSQL)or die(mysql_error());
  }else{
  $sql_del = "DELETE FROM tbl_import_body WHERE row_id = '".$_POST["row_id"][$i]."'"; 
  $query = mysql_query($sql_del);
  }
}
  for ($i; $i < count($_POST["detail"]); $i++) { 
    if($_POST["detail"][$i]){
   $de=explode("จำนวน", $_POST["detail"][$i]);
   $ps=explode(" ", $de[1]);
  $strSQL = "INSERT INTO tbl_import_body SET "; 
  $strSQL .="row_bill= '".$_POST["row_bill"]."'"; 
  $strSQL .=",detail = '".$de[0]."'"; 
  $strSQL .=",pcs= '".$ps[1]."'"; 
  $strSQL .=",unit= '".$ps[2]."'"; 
  $objQuery = mysql_query($strSQL)or die(mysql_error());
  }
}

echo ("<script> window.location='import_verify1_print.php?row_bill=".$_POST["row_bill"]."'</script>");
}
 ?>
