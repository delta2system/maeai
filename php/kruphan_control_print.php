<?
session_start();
include("connect.inc");
$sql = "SELECT tbl_value from tbl_company where row_id = '1'  ";
list($company) = Mysql_fetch_row(Mysql_Query($sql));

function adcomma($str){
  if($str){
    return number_format($str,2);
  }else{
    return "";
  }
}

function expdate($startdate,$datenum){
 $startdatec=strtotime($startdate); // ทำให้ข้อความเป็นวินาที
 $tod=$datenum*86400; // รับจำนวนวันมาคูณกับวินาทีต่อวัน
 $ndate=$startdatec+$tod; // นับบวกไปอีกตามจำนวนวันที่รับมา
 return date("Y-m-d",$ndate); // ส่งค่ากลับ
}

function expdate_year($startdate,$datenum){
 // $startdatec=strtotime($startdate); // ทำให้ข้อความเป็นวินาที
 // $tod=$datenum*86400; // รับจำนวนวันมาคูณกับวินาทีต่อวัน
 // $ndate=$startdatec+$tod; // นับบวกไปอีกตามจำนวนวันที่รับมา
 // return date("Y-m-d",$ndate); // ส่งค่ากลับ
    $t = strtotime("$startdate +$datenum year");
    return date('Y-m-d', $t) . PHP_EOL;
}


function diffDateTime($date1,$date2){
    $diff =abs(strtotime($date1)-strtotime($date2));
    $years = floor($diff / 31536000);
    $months = floor(($diff % 31536000) / 2592000);
   // return "ตั้งแต่วันที่  $date2  ถึงวันที่ $date1   เท่ากับ  $years ปี $months เดือน <br>";
     return ($years*12)+$months;
}


    function mn_count($str){
      switch ($str){
        case "10": $str = "12";break;
        case "11": $str = "11";break;
        case "12": $str = "10";break;
        case "1": $str = "9";break;
        case "2": $str = "8";break;
        case "3": $str = "7";break;
        case "4": $str = "6";break;
        case "5": $str = "5";break;
        case "6": $str = "4";break;
        case "7": $str = "3";break;
        case "8": $str = "2";break;
        case "9": $str = "1";break;
      }
      return $str;
    }
        function mn_en_count($str){
      switch ($str){
        case "10": $str = "1";break;
        case "11": $str = "2";break;
        case "12": $str = "3";break;
        case "1": $str = "4";break;
        case "2": $str = "5";break;
        case "3": $str = "6";break;
        case "4": $str = "7";break;
        case "5": $str = "8";break;
        case "6": $str = "9";break;
        case "7": $str = "10";break;
        case "8": $str = "11";break;
        case "9": $str = "12";break;
      }
      return $str;
    }

if($_GET["row_id"]){

  $strSQL="SELECT * from store where row_id = '".$_GET["row_id"]."' ";
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
    
  }

    $sql = "SELECT detail from store_type WHERE code = '".$arrCol["store_type"]."'  ";
    list($store_type) = Mysql_fetch_row(Mysql_Query($sql));

}

function resposible($str){
    $sql = "SELECT name from department WHERE row_id = '".$str."'  ";
    list($detail) = Mysql_fetch_row(Mysql_Query($sql)); 
    return $detail;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>.::ทะเบียนคุมทรัพย์สิน::.</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
        <!-- <link type="text/css" href="../font/style.css" rel="stylesheet" /> -->
        <link type="text/css" href="../fonts/thsarabunnew.css" rel="stylesheet" />
        <style type="text/css">
          body{
            font-family: 'THSarabunNew', sans-serif;
            font-size: 14px;
          }
          .pageA4{
            width:29cm;
          
          }
          table{
            border-collapse: collapse;
          }
          div{
            padding-top: 3px;
            padding-bottom: 3px;
          }
        </style>
</head>
<body>
<div class="pageA4">
<div style="width:100%;height: 30px;text-align: center;font-weight: bold;font-size: 18px;">ทะเบียนคุมทรัพย์สิน</div>
<div style="width:10cm;height:30px;margin-left: 19.5cm;">ส่วนราชการ &nbsp;&nbsp;&nbsp;<?=$company?></div>
<div style="width:10cm;height:30px;margin-left: 19.5cm;">หน่วยงาน &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$arrCol["installation"]?></div>
<div style="overflow: hidden;">ประเภท...<span style=""><?=$store_type?></span>..  รหัสครุภัณฑ์ ...<span><?=$arrCol["code"]?></span>....
ลักษณะ/คุณสมบัติ&nbsp;...<span ><?=$arrCol["attribute"]?>...</span>  
รุ่นแบบ&nbsp;...<span style="background-color: #ffffff;"><?=$arrCol["model"]?></span>  
</div>
<div>

  สถานที่ตั้ง/หน่วยงานผู้รับผิดชอบ..........................................................................................................<span style="position: absolute;margin-left: -240px;background-color: #ffffff;">&nbsp;&nbsp;<?=resposible($arrCol["responsible"]);?></span>  ผู้ขาย/ผู้รับจ้าง/ผู้บริจาค ...................................................................................................................<span style="position: absolute;margin-left: -240px;background-color: #ffffff;"><?=$arrCol["seller"]?></span>  
</div>
<div>
  ที่อยู่ .............................................................................................................................................................................................................<span style="position: absolute;margin-left: -570px;background-color: #ffffff;"><?=$arrCol["address"]?></span>  โทร. .............................................................................................<span style="position: absolute;margin-left: -270px;background-color: #ffffff;"><?=$arrCol["telephone"]?></span>  
</div>
<div>
  <table style="width:100%;">
    <td>ประเภทเงิน</td>
    <?
    $sql = "SELECT * from tbl_typeofmoney ORDER By row_id  ASC";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result) ) {
        if($arrCol["typeofmoney"]==$row["row_id"]){
   echo "<td><div style='width:18px;height:18px;border:1px solid; #a2a2a2;float:left;padding:0px;text-align:center;'>&#10004;</div> &nbsp;&nbsp;".substr($row[detail],0)."</td>";
        }else{
      echo "<td><div style='width:18px;height:18px;border:1px solid; #a2a2a2;float:left;padding:0px;'></div> &nbsp;&nbsp;".substr($row[detail],0)."</td>";
    }
    }
    ?>

  </table>
</div>
<div>
  <table style="width:100%;">
    <td>วิธีการได้มา</td>
    <?
    $sql = "SELECT * from tbl_acquisition ORDER By row_id  ASC";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result) ) {
      if($arrCol["acquisition"]==$row["row_id"]){
      echo "<td><div style='width:18px;height:18px;border:1px solid; #a2a2a2;float:left;padding:0px;text-align:center;'>&#10004;</div> &nbsp;&nbsp;".substr($row[detail],2)."</td>";
      }else{
      echo "<td><div style='width:18px;height:18px;border:1px solid; #a2a2a2;float:left;padding:0px;'></div> &nbsp;&nbsp;".substr($row[detail],2)."</td>";
    }
    }
    ?>

  </table>
</div>
<div>
  
<table style='width:100%;height:450px;overflow: hide;border:1px solid #a2a2a2;'> 
<td style="border:1px solid #a2a2a2;text-align: center;width:80px;">วดป</td>
<td style="border:1px solid #a2a2a2;text-align: center;">ที่เอกสาร</td>
<td style="border:1px solid #a2a2a2;text-align: center;">รายการ</td>  
<td style="border:1px solid #a2a2a2;text-align: center;">จำนวนหน่วย</td>
<td style="border:1px solid #a2a2a2;text-align: center;">ราคาต่อ หน่วย</td>
<td style="border:1px solid #a2a2a2;text-align: center;">มูลค่ารวม</td>
<td style="border:1px solid #a2a2a2;text-align: center;">อายุการใช้งาน</td>
<td style="border:1px solid #a2a2a2;text-align: center;">อัตราค่าเสื่อมราคา</td>
<td style="border:1px solid #a2a2a2;text-align: center;">ค่าเสื่อมราคาประจำปี</td>
<td style="border:1px solid #a2a2a2;text-align: center;">ค่าเสื่อมสะสม</td> 
<td style="border:1px solid #a2a2a2;text-align: center;">มูลค่าสุทธิ</td>
<td style="border:1px solid #a2a2a2;text-align: center;">หมายเหตุ</td>          
<?
if(substr($arrCol["daterecipt"],0,4) < "2500"){
  $arrCol["daterecipt"]=(substr($arrCol["daterecipt"],0,4)+543).substr($arrCol["daterecipt"],4);
}
print "<tr><td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;height:26px;text-align:center;'>".date_format(date_create($arrCol["daterecipt"]),"d-m-Y")."</td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;text-align:center;'>".$arrCol["nodocument"]."</td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'>".$arrCol["attribute"]."</td>".  
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;text-align:center;'>".$arrCol["numberofsets"]."</td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;text-align:center;'>".number_format($arrCol["priceofsets"])."</td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;text-align:center;'>".number_format($arrCol["numberofsets"]*$arrCol["priceofsets"])."</td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;text-align:center;'>".$arrCol["lifetime"]."</td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;text-align:center;'>".$arrCol["depreciation"]."</td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".  
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'>".number_format($arrCol["numberofsets"]*$arrCol["priceofsets"])."</td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>";
$i=0;

 $ds=explode("-", $arrCol["daterecipt"]);
 $date_ori=($ds[0]-543)."-".$ds[1]."-".$ds[2];
 $dateend = expdate_year($date_ori,$arrCol["lifetime"]);


if($dateend > date("Y-m-d")){
  $dateend = date("Y-m-d");
  $status_ux=1;

    $diffr =abs(strtotime($date_ori)-strtotime($dateend));
    $yearsr = ceil($diffr / 31536000);
  $lifetime = $yearsr;
}else{
   $status_ux=0;
   $lifetime = $arrCol["lifetime"];
}




    $dx=explode("-", $dateend);

    $diffr =abs(strtotime($date_ori)-strtotime($dateend));
    $yearsr = floor($diffr / 31536000);
    $monthsr = floor(($diffr % 31536000) / 2592000);

   // echo "ตั้งแต่วันที่  $date_ori  ถึงวันที่ $dateend   เท่ากับ  $yearsr ปี $monthsr เดือน <br>";

    if($ds[2] > "15"){
    $date = substr($date_ori,0,8).cal_days_in_month(CAL_GREGORIAN,$ds[1],($ds[0]-543));
    $date = date_create($date);
    date_modify($date, '+1 day');
    $date_ori_cal = date_format($date,'Y').date_format($date, '-m-d');

    $date = substr($dateend,0,8).cal_days_in_month(CAL_GREGORIAN,$dx[1],($dx[0]));
    $date = date_create($date); 
    $dateend_cal =  date_format($date,'Y').date_format($date, '-m-d');

    }else{
    $date_ori_cal = substr($date_ori,0,8)."01";    
    $date = $dateend;
    $date = date_create($date); 
    date_modify($date, '-1 day');
    $dateend_cal =  date_format($date,'Y').date_format($date, '-m-d');

    //$dateend_cal =  substr($dateend,0,8).cal_days_in_month(CAL_GREGORIAN,$dx[1],($dx[0]));
    }

    if(substr($date_ori_cal, 5)!="10-01"){
      $lifetime++;
    }


    for ($l=1; $l <=$lifetime ; $l++) { 
      if($l==1){
        $cal_m[$l]=mn_count(substr($date_ori_cal,5,2));
        if($cal_m[$l]<12){
        $cal_display[$l] = $cal_m[$l]." เดือน";
        }else{
        $cal_display[$l] = " 1 ปี";
        }
        $date_dis[$l]=$date_ori_cal;
      }else if($l ==$lifetime){
        

        if($ds[2]<16 && $ds[2]!=1){
          $cal_m[$l]=mn_en_count(substr($dateend_cal,5,2))-1;
        }else{
          $cal_m[$l]=mn_en_count(substr($dateend_cal,5,2));
        }

        if($cal_m[$l]<12){
        $cal_display[$l] = $cal_m[$l]." เดือน";
        }else{
        $cal_display[$l] = " 1 ปี";
        }
        $date_dis[$l]=$dateend_cal;
        
      }else{
        $cal_m[$l]=12;
        $cal_display[$l] = " 1 ปี";

        $date_dis[$l]=(substr($date_ori_cal,0,4)+$l)."-09-30";
      }
    }



//     if($ds[1]<10){
//      for($m=0;$m<=$lifetime;$m++){
//       if($m==0){
//         $mon["$m"]=$date_ori_cal;
//         $eon["$m"]=substr($date_ori_cal,0,4)."-09-30";
//         $date_ori_cal_real = date_create($mon["$m"]);
//         //date_modify($date_ori_cal_real, '+1 year');
//         $date_ori_cal_real=date_format($date_ori_cal_real,'Y').date_format($date_ori_cal_real, '-m-d');
//       }else if($m==$lifetime){
//         $mon["$m"]=$date_ori_cal_real;
//         if($ds[2]<15){
//         $eon["$m"]=(substr($dateend_cal,0,8))."01";
//         }else{
//          $eon["$m"]=(substr($dateend_cal,0,8))."30"; 
//         }
//       }else{
//         $mon["$m"]=$date_ori_cal_real;
//         $eon["$m"]=(substr($date_ori_cal,0,4)+$m)."-09-30";
//         $date_ori_cal_real = date_create($eon["$m"]);
//         date_modify($date_ori_cal_real, '+1 day');
//         $date_ori_cal_real=date_format($date_ori_cal_real,'Y').date_format($date_ori_cal_real, '-m-d');
//       }
//      }
//     }else{
//      for($m=0;$m<=$lifetime;$m++){
//        if($m==0){
//         $mon["$m"]=$date_ori_cal;
//         $eon["$m"]=(substr($date_ori_cal,0,4)+1)."-09-30";
//         $date_ori_cal_real = date_create($eon["$m"]);
//         date_modify($date_ori_cal_real, '+1 day');
//         $date_ori_cal_real=date_format($date_ori_cal_real,'Y').date_format($date_ori_cal_real, '-m-d');
//        }else if($m==$lifetime){
//         $mon["$m"]=$date_ori_cal_real;
//        if($ds[2]<15){
//         $eon["$m"]=(substr($dateend_cal,0,8))."01";
//         }else{
//          $eon["$m"]=(substr($dateend_cal,0,8))."30"; 
//         }
//       }else{
//         $mon["$m"]=$date_ori_cal_real;
//         $eon["$m"]=(substr($date_ori_cal,0,4)+$m+1)."-09-30";
//         $date_ori_cal_real = date_create($eon["$m"]);
//         date_modify($date_ori_cal_real, '+1 day');
//         $date_ori_cal_real=date_format($date_ori_cal_real,'Y').date_format($date_ori_cal_real, '-m-d');
//       }
//      }

//     }

// //echo $ds[2]."<br>";
// if($ds[1]==9 && $ds[2]>15){
//   $edit_mon = count($mon)-1;
// }else {
//   $edit_mon = count($mon);
// }

$edit_mon = count($cal_m);

$price_month = ($arrCol["numberofsets"]*$arrCol["priceofsets"])/($arrCol["lifetime"]*12);

$total_detail = $arrCol["numberofsets"]*$arrCol["priceofsets"];

$i=0;


 for ($i=0; $i < $edit_mon; $i++) { 
   $j++;
//     $diffr =abs(strtotime($mon["$i"])-strtotime($eon["$i"]));
//     $yearsr = floor($diffr / 31536000);
//     $monthsr = floor(($diffr % 31536000) / 2592000);


//     if($monthsr=="12"){
//       $cal_display = "1 ปี";
//       $cal_month = 12;
//     }else if($yearsr>=1){
//       $cal_display = $yearsr." ปี";
//       $cal_month = $yearsr*12;
//     }else if($monthsr=="0"){
//       $cal_display ="1 เดือน";
//       $cal_month = 1;
//     }else{
//       $cal_display = $monthsr." เดือน";
//       $cal_month = $monthsr;
//     }
//     // $date_orin[1]=$date_en[1];

    if($edit_mon==$j && $status_ux==0){
     $per_m = ($price_month*$cal_m[$i+1])-1;
     $total_detail =  $total_detail - $per_m;
    }else{
    $per_m = ($price_month*$cal_m[$i+1]);
    $total_detail =  $total_detail - $per_m;
    }


//   if($edit_mon==$j){
//     $date_dis = date_create($dateend);  date_modify($date_dis, '-1 day');
//     $date_dis=date_format($date_dis,'d-m-').(date_format($date_dis, 'Y')+543);
//   }else{
//     $date_dis = substr($eon["$i"],8,2)."-".substr($eon["$i"],5,2)."-".(substr($eon["$i"],0,4)+543); 
//   }
print "<tr><td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;height:26px;text-align:center;'>".substr($date_dis[($i+1)],8,2)."-".substr($date_dis[($i+1)],5,2)."-".(substr($date_dis[($i+1)],0,4)+543)."</td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'>คำนวณ ".$cal_display[($i+1)]."</td>".  
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;text-align:right;'>".number_format($per_m,2)."&nbsp;&nbsp;</td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;text-align:right;'>".number_format($total_detail,2)."&nbsp;&nbsp;</td>".  
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>";

 }
 



for ($i; $i < 14; $i++) { 
print "<tr><td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;height:26px;'></td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>";
if($i==13){
print "<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'><span style='position:absolute;margin-top:-15px;background-color: #ffffff'> หมายเหตุ ".$arrCol["other"]."</span></td>";
}else{
  print "<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>";  
}
print "<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".  
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>".
"<td style='border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'></td>";
}
?>
<!-- <tr><td colspan="12" style="text-align: right;">หน้า 1</td>     -->  
</table>
<div style="right:100px;">หน้าที่ 1</div>
</div>
</div>
<div class="pageA4">
<div>ประเภทครุภัณฑ์ &nbsp;&nbsp;<?=$store_type?></div>
<div>รหัสครุภัณฑ์ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$arrCol["code"]?></div>

<table style="width:100%;">
 <td style="text-align: center;" colspan="5">ประวัติการซ่อมบำรุงรักษาทรัพย์</td>
  <tr><td style="border:1px solid #a2a2a2;text-align: center;">ครั้งที่</td>
  <td style="border:1px solid #a2a2a2;text-align: center;">วันเดือนปี</td>
   <td style="border:1px solid #a2a2a2;text-align: center;">รายการ</td>
    <td  style="border:1px solid #a2a2a2;text-align: center;">จำนวนเงิน</td>
     <td  style="border:1px solid #a2a2a2;text-align: center;">หมายเหตุ</td>
     <?
  $strSQL="SELECT * from hirefix where no = '".$arrCol["code"]."' ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $t=0; $total_moneyfix=0;
  while($ob = mysql_fetch_array($objQuery))
  {
    $t++;
    print "<tr>"
          ."<td style='text-align:center;border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'>$t</td>"
          ."<td style='text-align:center;border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'>".date_format(date_create($ob[date_return]),"d-m-Y")."</td>"
          ."<td style='text-align:left;padding-left:10px;border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'>$ob[other_fix]</td>"
          ."<td style='text-align:center;border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'>".adcomma($ob[money_recipt])."</td>"
          ."<td style='text-align:center;border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'>$ob[other_return]</td>";

          $total_moneyfix=$total_moneyfix + str_replace(",","", $ob[money_recipt]);
    
  }


  $strSQL="SELECT * from tbl_repair where code_store = '".$arrCol["code"]."' ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $t=0; $total_moneyfix=0;
  while($ob = mysql_fetch_array($objQuery))
  {
    $t++;
    print "<tr>"
          ."<td style='text-align:center;border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'>$t</td>"
          ."<td style='text-align:center;border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'>".date_format(date_create($ob[date_return]),"d-m-Y")."</td>"
          ."<td style='text-align:left;padding-left:10px;border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'>$ob[detail]</td>"
          ."<td style='text-align:center;border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'>".adcomma($ob[total_money])."</td>"
          ."<td style='text-align:center;border-left:1px solid #a2a2a2;border-right:1px solid #a2a2a2;'>$ob[other]</td>";

          $total_moneyfix=$total_moneyfix + str_replace(",","", $ob[total_money]);
    
  }
  



     ?>
     <tr><td colspan='3' style="text-align: right;border-top:1px solid #a2a2a2;">รวมเงิน&nbsp;&nbsp;</td><td style="border:1px solid #a2a2a2;text-align: center;"><?=adcomma($total_moneyfix)?></td><td style="border-top:1px solid #a2a2a2;"></td>
</table>
</div>
</body>
</html>
<?//echo("<script>window.print();</script>")?>