<?
session_start();
include("../connect.inc");

function expdate($startdate,$datenum){
 $startdatec=strtotime($startdate); // ทำให้ข้อความเป็นวินาที
 $tod=$datenum*86400; // รับจำนวนวันมาคูณกับวินาทีต่อวัน
 $ndate=$startdatec+$tod; // นับบวกไปอีกตามจำนวนวันที่รับมา
 return $ndate; // ส่งค่ากลับ
}

function convert_dateday($str){
  
$sr=explode(" ",$str);

switch($sr[1])
{
case "ม.ค.": $sr[1] = "01"; break;
case "ก.พ.": $sr[1] = "02"; break;
case "มี.ค.": $sr[1] = "03"; break;
case "เม.ย.": $sr[1] = "04"; break;
case "พ.ค.": $sr[1] = "05"; break;
case "มิ.ย.": $sr[1] = "06"; break;
case "ก.ค.": $sr[1] = "07"; break;
case "ส.ค.": $sr[1] = "08"; break;
case "ก.ย.": $sr[1] = "09"; break;
case "ต.ค.": $sr[1] = "10"; break;
case "พ.ย.": $sr[1] = "11"; break;
case "ธ.ค.": $sr[1] = "12"; break;
}

return $sr[2]."-".$sr[1]."-".$sr[0];

}

function mount($str){
switch($str)
{
case "01": $str = "ม.ค."; break;
case "02": $str = "ก.พ."; break;
case "03": $str = "มี.ค."; break;
case "04": $str = "เม.ย."; break;
case "05": $str = "พ.ค."; break;
case "06": $str = "มิ.ย."; break;
case "07": $str = "ก.ค."; break;
case "08": $str = "ส.ค."; break;
case "09": $str = "ก.ย."; break;
case "10": $str = "ต.ค."; break;
case "11": $str = "พ.ย."; break;
case "12": $str = "ธ.ค."; break;
}
return $str;
}

function convert_redatday($str){

$sb=explode("-",$str);


return $sb[2]." ".mount($sb[1])." ".$sb[0];

}

if($_POST["submit"]=="save_fix"){

$array_image="";
if(isset($_FILES["fileupload"]))
{
    foreach($_FILES['fileupload']['tmp_name'] as $key => $val)
    {

            //$new_barcode = date("y").str_pad(($barcode_new+$i),6,"0",STR_PAD_LEFT);
    $images = $_FILES["fileupload"]["tmp_name"][$key];
    $new_images = date("ymdHis").$key.".jpg";
    //copy($_FILES["product"]["tmp_name"],"../images/send_product/".$_FILES["product"]["name"]);
    $width=640; //*** Fix Width & Heigh (Autu caculate) ***//
    $size=GetimageSize($images);
    $height=round($width*$size[1]/$size[0]);
    $images_orig = ImageCreateFromJPEG($images);
    $photoX = ImagesX($images_orig);
    $photoY = ImagesY($images_orig);
    $images_fin = ImageCreateTrueColor($width, $height);
    ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
    ImageJPEG($images_fin,"../../images/fix/".$new_images);
    //ImageDestroy($images_orig);
    ImageDestroy($images_fin);
    chmod("../../images/fix/".$new_images, 0777);

    $array_image.="#".$new_images;
    }
    //echo "Copy/Upload Complete";
}


//$resultArray=array();
//$arrCol=array();
//INSERT SQL
$strSQL = "INSERT INTO hirefix SET "; 
$strSQL .="dateday = '".convert_dateday($_POST["dateday"])."' ";
$strSQL .=",times = '".$_POST["times"]."' ";
$strSQL .=",department = '".$_POST["department"]."' ";
$strSQL .=",product = '".$_POST["product"]."' ";
$strSQL .=",model = '".$_POST["model"]."' ";
$strSQL .=",serial = '".$_POST["serial"]."' ";
$strSQL .=",no = '".$_POST["no"]."' ";
$strSQL .=",type_fix = '".$_POST["type_fix"]."' ";
$strSQL .=",type = '".$_POST["type"]."' ";
$strSQL .=",datefix = '".$_POST["datefix"]."' ";
if($array_image){
  $strSQL .=",images = '".$array_image."' ";
}
$strSQL .=",other = '".$_POST["other"]."' ";
$strSQL .=",officer = '".$_POST["officer"]."' ";
$strSQL .=",userid = '".$_SESSION["xid"]."' ";
$objQuery = mysql_query($strSQL);


if($objQuery){
// 	$arrCol["status"]="true";
// 	$arrCol["msg"]="บันทึกใบแจ้งซ่อมเรียบร้อย...";
  echo "<div style='padding:100px;100px;text-align:center;width:600px;height:300px;position:fixed;top:50%;left:50%;margin-left:-300px;margin-top:-150px;font-size:40px;color:green;'>บันทึกใบแจ้งซ่อมเรียบร้อย...</div>";
  echo "<Script Language='JavaScript'> function CloseWindowsInTime(t){t = t*1000;setTimeout(function(){ window.location='hire_fix.php';},t);}CloseWindowsInTime(3); </Script>";
 }else{
// 	$arrCol["status"]="error";
// 	$arrCol["msg"]=mysql_error();
    echo "<div style='padding:100px;100px;text-align:center;width:600px;height:300px;position:fixed;top:50%;left:50%;margin-left:-300px;margin-top:-150px;font-size:40px;color:red;'>ไม่สามารถบันทึกใบแจ้งซ่อมเรียบร้อย...</div>";
  echo "<Script Language='JavaScript'> function CloseWindowsInTime(t){t = t*1000;setTimeout(function(){ window.history.back();},t);}CloseWindowsInTime(3); </Script>";
 }

  
//   array_push($resultArray,$arrCol);
  
//   echo json_encode($resultArray);



}else if($_POST["submit"]=="return_data"){

  $strSQL = "SELECT * FROM hirefix WHERE row_id = '".$_POST["row_id"]."' ";
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

    $arrCol["date_convert"]=convert_redatday($obResult["dateday"]);
    if($obResult["date_recipt"]!="0000-00-00"){
    $arrCol["date_recipt_convert"]=convert_redatday($obResult["date_recipt"]);
    }

      $arrCol["blah"]="";
      $ims=explode("#",$arrCol["images"]);
      if($arrCol["images"]){
        if(count($ims)>0){
          for ($r=1; $r < count($ims) ; $r++) { 

            $arrCol["blah"].= "<img src=\"../../images/fix/$ims[$r]\" style=\"height:200px;cursor:pointer;\" onclick=\"window.open('../../images/fix/$ims[$r]','_blank')\">";
          }
        }else{
          $arrCol["blah"].= "<img src=\"../../images/fix/".$arrCol["images"]." style=\"height:200px;cursor:pointer;\" onclick=\"window.open('../images/store/".$arrCol["images"]."','_blank')\">";
        }
      }

      $arrCol["blah2"]="";
       $ims=explode("#",$arrCol["images_recipt"]);
      if($arrCol["images_recipt"]){
        if(count($ims)>0){
          for ($r=1; $r < count($ims) ; $r++) { 
            $arrCol["blah2"].= "<img src=\"../../images/fix/$ims[$r]\" style=\"height:200px;cursor:pointer;\" onclick=\"window.open('../../images/fix/$ims[$r]','_blank')\">";
          }
        }else{
          $arrCol["blah2"].= "<img src=\"../../images/fix/".$arrCol["images_recipt"]." style=\"height:200px;cursor:pointer;\" onclick=\"window.open('../../images/fix/$ims[$r]','_blank')\">";
        }
      }

      $arrCol["blah3"]="";
      $ims=explode("#",$arrCol["image_return"]);
      if($arrCol["image_return"]){
        if(count($ims)>0){
          for ($r=1; $r < count($ims) ; $r++) { 
            $arrCol["blah3"].= "<img src=\"../../images/fix/$ims[$r]\" style=\"height:200px;cursor:pointer;\" onclick=\"window.open('../../images/fix/$ims[$r]','_blank')\">";
          }
        }else{
          $arrCol["blah3"].= "<img src=\"../../images/fix/".$arrCol["image_return"]." style=\"height:200px;cursor:pointer;\" onclick=\"window.open('../../images/fix/$ims[$r]','_blank')\">";
        }
      }

    array_push($resultArray,$arrCol);
  }
  
  //mysql_close($Conn);
  
  echo json_encode($resultArray);


}else if($_POST["submit"]=="update_fix"){

// $resultArray=array();
// $arrCol=array();
$array_image="";
if(isset($_FILES["fileupload"]))
{
    foreach($_FILES['fileupload']['tmp_name'] as $key => $val)
    {

            //$new_barcode = date("y").str_pad(($barcode_new+$i),6,"0",STR_PAD_LEFT);
    $images = $_FILES["fileupload"]["tmp_name"][$key];
    $new_images = date("ymdHis").$key.".jpg";
    //copy($_FILES["product"]["tmp_name"],"../images/send_product/".$_FILES["product"]["name"]);
    $width=640; //*** Fix Width & Heigh (Autu caculate) ***//
    $size=GetimageSize($images);
    $height=round($width*$size[1]/$size[0]);
    $images_orig = ImageCreateFromJPEG($images);
    $photoX = ImagesX($images_orig);
    $photoY = ImagesY($images_orig);
    $images_fin = ImageCreateTrueColor($width, $height);
    ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
    ImageJPEG($images_fin,"../../images/fix/".$new_images);
    //ImageDestroy($images_orig);
    ImageDestroy($images_fin);
    chmod("../../images/fix/".$new_images, 0777);

    $array_image.="#".$new_images;
    }
    //echo "Copy/Upload Complete";
}

$strSQL = "UPDATE hirefix SET ";
$strSQL .="dateday = '".convert_dateday($_POST["dateday"])."' ";
$strSQL .=",times = '".$_POST["times"]."' ";
$strSQL .=",department = '".$_POST["department"]."' ";
$strSQL .=",product = '".$_POST["product"]."' ";
$strSQL .=",model = '".$_POST["model"]."' ";
$strSQL .=",serial = '".$_POST["serial"]."' ";
$strSQL .=",no = '".$_POST["no"]."' ";
$strSQL .=",type_fix = '".$_POST["type_fix"]."' ";
$strSQL .=",type = '".$_POST["type"]."' ";
$strSQL .=",other = '".$_POST["other"]."' ";
if($array_image){
$strSQL .=",images = '".$array_image."' ";
}
$strSQL .=",officer = '".$_POST["officer"]."' ";
$strSQL .=",userid = '".$_SESSION["xid"]."' ";
$strSQL .=",status = '0' ";
$strSQL .="WHERE row_id = '".$_POST["row_id"]."' ";
$objQuery = mysql_query($strSQL);

// if($objQuery){
// 	$arrCol["status"]="true";
// 	$arrCol["msg"]="บันทึกใบแจ้งซ่อมเรียบร้อย...";
// }else{
// 	$arrCol["status"]="error";
// 	$arrCol["msg"]=mysql_error();
// }


if($objQuery){
//  $arrCol["status"]="true";
//  $arrCol["msg"]="บันทึกใบแจ้งซ่อมเรียบร้อย...";
  echo "<div style='padding:100px;100px;text-align:center;width:600px;height:300px;position:fixed;top:50%;left:50%;margin-left:-300px;margin-top:-150px;font-size:40px;color:green;'>บันทึกใบแจ้งซ่อมเรียบร้อย...</div>";
  echo "<Script Language='JavaScript'> function CloseWindowsInTime(t){t = t*1000;setTimeout(function(){ window.location='hire_fix.php';},t);}CloseWindowsInTime(3); </Script>";
 }else{
//  $arrCol["status"]="error";
//  $arrCol["msg"]=mysql_error();
    echo "<div style='padding:100px;100px;text-align:center;width:600px;height:300px;position:fixed;top:50%;left:50%;margin-left:-300px;margin-top:-150px;font-size:40px;color:red;'>ไม่สามารถบันทึกใบแจ้งซ่อมเรียบร้อย...</div>";
  echo "<Script Language='JavaScript'> function CloseWindowsInTime(t){t = t*1000;setTimeout(function(){ window.history.back();},t);}CloseWindowsInTime(3); </Script>";
 }
  
  // array_push($resultArray,$arrCol);
  
  // echo json_encode($resultArray);
}else if($_POST["submit"]=="del_fix"){

  $sql_del = "DELETE FROM hirefix WHERE row_id = '".$_POST["row_id"]."'"; 
  $query = mysql_query($sql_del);

}else if($_POST["submit"]=="update_reciptfix"){



if(isset($_FILES["fileupload"]))
{
    foreach($_FILES['fileupload']['tmp_name'] as $key => $val)
    {

            //$new_barcode = date("y").str_pad(($barcode_new+$i),6,"0",STR_PAD_LEFT);
    $images = $_FILES["fileupload"]["tmp_name"][$key];
    $new_images = date("ymdHis").$key.".jpg";
    //copy($_FILES["product"]["tmp_name"],"../images/send_product/".$_FILES["product"]["name"]);
    $width=640; //*** Fix Width & Heigh (Autu caculate) ***//
    $size=GetimageSize($images);
    $height=round($width*$size[1]/$size[0]);
    $images_orig = ImageCreateFromJPEG($images);
    $photoX = ImagesX($images_orig);
    $photoY = ImagesY($images_orig);
    $images_fin = ImageCreateTrueColor($width, $height);
    ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
    ImageJPEG($images_fin,"../../images/fix/".$new_images);
    //ImageDestroy($images_orig);
    ImageDestroy($images_fin);
    chmod("../../images/fix/".$new_images, 0777);

    $array_image.="#".$new_images;
    }
    //echo "Copy/Upload Complete";
}

$resultArray=array();
$arrCol=array();

$strSQL = "UPDATE hirefix SET ";
$strSQL .="dateday = '".convert_dateday($_POST["dateday"])."' ";
$strSQL .=",times = '".$_POST["times"]."' ";
$strSQL .=",department = '".$_POST["department"]."' ";
$strSQL .=",product = '".$_POST["product"]."' ";
$strSQL .=",model = '".$_POST["model"]."' ";
$strSQL .=",serial = '".$_POST["serial"]."' ";
$strSQL .=",no = '".$_POST["no"]."' ";
$strSQL .=",type_fix = '".$_POST["type_fix"]."' ";
$strSQL .=",type = '".$_POST["type"]."' ";
$strSQL .=",other = '".$_POST["other"]."' ";
$strSQL .=",officer = '".$_POST["officer"]."' ";
$strSQL .=",userid = '".$_SESSION["xid"]."' ";
$strSQL .=",status = '1' ";
$strSQL .=",datefix = '".$_POST["datefix"]."' ";
if($array_image){
$strSQL .=",images_recipt = '".$array_image."' ";
}
$strSQL .=",date_recipt = '".convert_dateday($_POST["date_recipt"])."' ";
$strSQL .=",time_recipt = '".$_POST["time_recipt"]."' ";
$strSQL .=",other_fix = '".$_POST["other_fix"]."' ";
$strSQL .=",officer_recipt = '".$_POST["officer_recipt"]."' ";
$strSQL .=",officer_fix = '".$_POST["officer_fix"]."' ";
$strSQL .=",group_fix = '".$_POST["group_fix"]."' ";
$strSQL .=",type_status_fix = '".$_POST["type_status_fix"]."' ";
$strSQL .="WHERE row_id = '".$_POST["row_id"]."' ";

$objQuery = mysql_query($strSQL)or die(mysql_error());

if($objQuery){
  $arrCol["status"]="true";
  $arrCol["msg"]="บันทึกใบแจ้งซ่อมเรียบร้อย...";
}else{
  $arrCol["status"]="error";
  $arrCol["msg"]=mysql_error();
}

  array_push($resultArray,$arrCol);
  
  echo json_encode($resultArray);

}else if($_POST["submit"]=="update_return_fix"){


if(isset($_FILES["filefixupload"]))
{
    foreach($_FILES['filefixupload']['tmp_name'] as $key => $val)
    {
            //$new_barcode = date("y").str_pad(($barcode_new+$i),6,"0",STR_PAD_LEFT);
    $images = $_FILES["filefixupload"]["tmp_name"][$key];
    $new_images = date("ymdHis").$key.".jpg";
    //copy($_FILES["product"]["tmp_name"],"../images/send_product/".$_FILES["product"]["name"]);
    $width=640; //*** Fix Width & Heigh (Autu caculate) ***//
    $size=GetimageSize($images);
    $height=round($width*$size[1]/$size[0]);
    $images_orig = ImageCreateFromJPEG($images);
    $photoX = ImagesX($images_orig);
    $photoY = ImagesY($images_orig);
    $images_fin = ImageCreateTrueColor($width, $height);
    ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
    ImageJPEG($images_fin,"../../images/fix/".$new_images);
    //ImageDestroy($images_orig);
    ImageDestroy($images_fin);
    chmod("../../images/fix/".$new_images, 0777);

    $array_image.="#".$new_images;
    }
    //echo "Copy/Upload Complete";
}


$resultArray=array();
$arrCol=array();

$strSQL = "UPDATE hirefix SET ";
$strSQL .="date_return = '".convert_dateday($_POST["date_return"])."' ";
$strSQL .=",type_status_return = '".$_POST["type_status_return"]."' ";
$strSQL .=",other_return = '".$_POST["other_return"]."' ";
$strSQL .=",nobill_recipt = '".$_POST["nobill_recipt"]."' ";
$strSQL .=",money_recipt = '".$_POST["money_recipt"]."' ";
$strSQL .=",officer_fix = '".$_POST["officer_fix"]."' ";
if($array_image){
$strSQL .=",image_return = '".$array_image."' ";
}
$strSQL .=",status = '9' ";
$strSQL .="WHERE row_id = '".$_POST["row_id"]."' ";
$objQuery = mysql_query($strSQL)or die(mysql_error());


  $sql = "SELECT row_id,attribute,model from store WHERE code = '".$_POST["no"]."' limit 1  ";
  $result = Mysql_Query($sql);
  $num = mysql_num_rows($result);
  if($num){
  list($rRow_id,$rAttribute,$model) = Mysql_fetch_row($result);  
  $df=explode("-",convert_dateday($_POST["date_return"]));
$strSQL = "INSERT INTO tbl_repair SET "; 
$strSQL .="row_store = '".$rRow_id."' ";
$strSQL .=",code_store = '".$_POST["no"]."' ";
$strSQL .=",dateday = '".convert_dateday($_POST["date_return"])."' ";
$strSQL .=",no_bill = '".$_POST["row_id"].str_replace("-", "", convert_dateday($_POST["date_return"]))."' ";
$strSQL .=",detail = '".$rAttribute." ".$model."' ";
// $strSQL .=",pcs = '' ";
if($_POST["nobill_recipt"]!=""){
    $nobill_recipt=" เอกสารแนบเลขที่ ".$_POST["nobill_recipt"];
}else{
      $nobill_recipt="";
}
$strSQL .=",total_money = '".$_POST["money_recipt"].$nobill_recipt."' ";
$strSQL .=",other = '".$_POST["other_return"]."' ";
$strSQL .=",fix_finished = '".$df[2]."-".$df[1]."-".$df[0]."' ";
$strSQL .=",status = '2' ";
$strSQL .=",officer = '".$_POST["officer_fix"]."' ";
$objQuery = mysql_query($strSQL);  


  }

if($objQuery){
  $arrCol["status"]="true";
  $arrCol["msg"]="บันทึกใบสถานะซ่อมเรียบร้อย...";
}else{
  $arrCol["status"]="error";
  $arrCol["msg"]=mysql_error();
}

  array_push($resultArray,$arrCol);
  
  echo json_encode($resultArray);


}else if($_POST["submit"]=="return_store"){


  $strSQL = "SELECT store_type,code,attribute,model,serial,model,responsible FROM store WHERE row_id = '".$_POST["row_id"]."' ";
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




}else if($_POST["submit"]=="del_image_fix"){


  $sql = "SELECT images FROM hirefix WHERE row_id = '".$_POST["row_id"]."'";
  list($images) = Mysql_fetch_row(Mysql_Query($sql));


     $ims=explode("#",$images);
      if($images){
        if(count($ims)>0){
          for ($r=1; $r < count($ims) ; $r++) { 
            $flgDelete = unlink("../../images/fix/".$ims[$r]);
          //  $arrCol["blah"].= "<img src=\"../../images/fix/$ims[$r]\" style=\"height:200px;\">";
          }
        }else{
          //$arrCol["blah"].= "<img src=\"../../images/fix/".$arrCol["images"]." style=\"height:200px;\">";
            $flgDelete = unlink("../../images/fix/".$images);
        }
      }

$sql_update = "UPDATE hirefix SET images='' WHERE row_id = '".$_POST["row_id"]."' ";
$result_update= mysql_query($sql_update) or die(mysql_error());


}else if($_POST["submit"]=="del_image_fixrecipt"){


  $sql = "SELECT images_recipt FROM hirefix WHERE row_id = '".$_POST["row_id"]."'";
  list($images) = Mysql_fetch_row(Mysql_Query($sql));


     $ims=explode("#",$images);
      if($images){
        if(count($ims)>0){
          for ($r=1; $r < count($ims) ; $r++) { 
            $flgDelete = unlink("../../images/fix/".$ims[$r]);
          //  $arrCol["blah"].= "<img src=\"../../images/fix/$ims[$r]\" style=\"height:200px;\">";
          }
        }else{
          //$arrCol["blah"].= "<img src=\"../../images/fix/".$arrCol["images"]." style=\"height:200px;\">";
            $flgDelete = unlink("../../images/fix/".$images);
        }
      }

$sql_update = "UPDATE hirefix SET images_recipt='' WHERE row_id = '".$_POST["row_id"]."' ";
$result_update= mysql_query($sql_update) or die(mysql_error());



}else if($_POST["submit"]=="cal_datefix"){



$dateday=convert_dateday($_POST["dateday"]);
$dateday=(substr($dateday,0,4)-543).substr($dateday,5);
//$dd=date("H:i:s",time()); //กำหนดวันที่ปัจจุบัน
$dr=expdate($dateday,$_POST["datefix"]); //ส่งค่าให้ฟังก์ชั่น วันที่ปัจจุบัน พร้อมจำนวนวัน
$df=date("d/m/Y",$dr); //จัดรูปแบบวันที่ก่อนแสดง
echo substr($df,0,2)."/".substr($df,3,2)."/".(substr($df,6,4)+543); //แสดงวันที่ออกมา

}
?>