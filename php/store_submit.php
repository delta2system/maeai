<?
session_start();
include("connect.inc");
//print_r($_POST);
// print_r($_FILES);

if($_POST["xSubmit"]=="new_store"){


print_r($_FILES);

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
    ImageJPEG($images_fin,"../images/store/".$new_images);
    //ImageDestroy($images_orig);
    ImageDestroy($images_fin);
    chmod("../images/store/".$new_images, 0777);

    $array_image.="#".$new_images;
    }
    //echo "Copy/Upload Complete";
}




$strSQL = "INSERT INTO store SET "; 
$strSQL .="code = '".$_POST["code"]."'";
$strSQL .=",store_type = '".$_POST["store_type"]."'";
$strSQL .=",gfmis = '".$_POST["gfmis"]."'";
$strSQL .=",attribute = '".$_POST["attribute"]."'";
$strSQL .=",model = '".$_POST["model"]."'";
$strSQL .=",serial = '".$_POST["serial"]."'";
$strSQL .=",other = '".$_POST["other"]."'";
$strSQL .=",installation = '".$_POST["installation"]."'";
$strSQL .=",responsible = '".$_POST["responsible"]."'";
$strSQL .=",seller = '".$_POST["seller"]."'";
$strSQL .=",telephone = '".$_POST["telephone"]."'";
$strSQL .=",address = '".$_POST["address"]."'";
$strSQL .=",typeofmoney = '".$_POST["typeofmoney"]."'";
$strSQL .=",acquisition = '".$_POST["acquisition"]."'";
$strSQL .=",donor = '".$_POST["donor"]."'";
$strSQL .=",nodocument = '".$_POST["nodocument"]."'";
$strSQL .=",daterecipt = '".substr($_POST["daterecipt"],6,4)."-".substr($_POST["daterecipt"],3,2)."-".substr($_POST["daterecipt"],0,2)."'";
$strSQL .=",numberofsets = '".$_POST["numberofsets"]."'";
$strSQL .=",priceofsets = '".$_POST["priceofsets"]."'";
$strSQL .=",depreciation = '".$_POST["depreciation"]."'";
$strSQL .=",how_cal = '".$_POST["how_cal"]."'"; 
$strSQL .=",lifetime = '".$_POST["lifetime"]."'";
$strSQL .=",address_store = '".$_POST["address_store"]."'";
if(isset($_FILES["fileupload"])){
$strSQL .=",images = '".$array_image."' ";
}
$strSQL .=",lastupdate = '".date("Y-m-d H:i:s")."' ";
$strSQL .=",status = '1' ";
$strSQL .=",officer = '".$_SESSION["xusername"]."' ";
$objQuery = mysql_query($strSQL)or die(mysql_error());

if($objQuery){
	echo"<div style='width:200px;height:30px;text-align:center;font-size:21px;color:#00cc00;margin:0px auto;'>บันทึกเรียบร้อย</div>";
}else{
	echo"<div style='width:200px;height:30px;text-align:center;font-size:21px;color:#ff0000;'>ไม่สามารถบันทึกได้</div>";
}

}else if($_POST["xSubmit"]=="update_store"){

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
    ImageJPEG($images_fin,"../images/store/".$new_images);
    //ImageDestroy($images_orig);
    ImageDestroy($images_fin);
    chmod("../images/store/".$new_images, 0777);

    $array_image.="#".$new_images;
    }
    //echo "Copy/Upload Complete";
}

$strSQL = "UPDATE store SET "; 
$strSQL .="code = '".$_POST["code"]."'";
$strSQL .=",store_type = '".$_POST["store_type"]."'";
$strSQL .=",gfmis = '".$_POST["gfmis"]."'";
$strSQL .=",attribute = '".$_POST["attribute"]."'";
$strSQL .=",model = '".$_POST["model"]."'";
$strSQL .=",serial = '".$_POST["serial"]."'";
$strSQL .=",other = '".$_POST["other"]."'";
$strSQL .=",installation = '".$_POST["installation"]."'";
$strSQL .=",responsible = '".$_POST["responsible"]."'";
$strSQL .=",seller = '".$_POST["seller"]."'";
$strSQL .=",telephone = '".$_POST["telephone"]."'";
$strSQL .=",address = '".$_POST["address"]."'";
$strSQL .=",typeofmoney = '".$_POST["typeofmoney"]."'";
$strSQL .=",acquisition = '".$_POST["acquisition"]."'";
$strSQL .=",donor = '".$_POST["donor"]."'";
$strSQL .=",nodocument = '".$_POST["nodocument"]."'";
$strSQL .=",daterecipt = '".substr($_POST["daterecipt"],6,4)."-".substr($_POST["daterecipt"],3,2)."-".substr($_POST["daterecipt"],0,2)."'";
$strSQL .=",numberofsets = '".$_POST["numberofsets"]."'";
$strSQL .=",priceofsets = '".$_POST["priceofsets"]."'";
$strSQL .=",depreciation = '".$_POST["depreciation"]."'";
$strSQL .=",how_cal = '".$_POST["how_cal"]."'"; 
$strSQL .=",lifetime = '".$_POST["lifetime"]."'";
$strSQL .=",address_store = '".$_POST["address_store"]."'";
if(isset($_FILES["fileupload"])){
$strSQL .=",images = '".$array_image."' ";
}
$strSQL .=",lastupdate = '".date("Y-m-d H:i:s")."' ";
//$strSQL .=",status = '1' ";
$strSQL .=",officer = '".$_SESSION["xusername"]."' ";
$strSQL .="WHERE row_id = '".$_POST["xrow_id"]."'";
$objQuery = mysql_query($strSQL)or die(mysql_error());

if($objQuery){

echo("<script> alert('บันทึกเรียบร้อย');window.parent.location='khruphanth_edit.php?row_id=".$_POST["xrow_id"]."'</script>");

}

}
?>