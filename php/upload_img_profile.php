<?php
session_start();
include ("connect.inc");

	if($_FILES["fileUpload"]){
	if(trim($_FILES["fileUpload"]["tmp_name"]) != "")
	{
		$images = $_FILES["fileUpload"]["tmp_name"];
		$new_images = "profile_".$_SESSION["xusername"].".jpg";
		//copy($_FILES["fileUpload"]["tmp_name"],"../images/img_profile/".$_FILES["fileUpload"]["name"]);
		$width=200; //*** Fix Width & Heigh (Autu caculate) ***//
		$size=GetimageSize($images);
		//$height=round($width*$size[1]/$size[0]);
		$height=200;

		$images_orig = ImageCreateFromJPEG($images);
		$photoX = ImagesY($images_orig);
		$photoY = ImagesY($images_orig);
		$images_fin = ImageCreateTrueColor($width, $height);
		ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
		ImageJPEG($images_fin,"../images/img_profile/".$new_images);
		//ImageDestroy($images_orig);
		ImageDestroy($images_fin);

		echo "<span style='color:#00ff00;'>Upload Successful.</span>";
		echo "<img src='../images/img_profile/".$new_images."' style='display:none;'>";

		$sql_update = "UPDATE user_account SET image_profile='$new_images' WHERE username='".$_SESSION["xusername"]."' ";
		$result_update= mysql_query($sql_update) or die(mysql_error());

	}
		}else if($_FILES["fileUploadLogo"]){

	if(trim($_FILES["fileUploadLogo"]["tmp_name"]) != ""){

		$images = $_FILES["fileUploadLogo"]["tmp_name"];
		$new_images = "logo.jpg";
		//copy($_FILES["fileUploadLogo"]["tmp_name"],"../images/img_profile/".$_FILES["fileUploadLogo"]["name"]);
		$width=200; //*** Fix Width & Heigh (Autu caculate) ***//
		$size=GetimageSize($images);
		//$height=round($width*$size[1]/$size[0]);
		$height=200;

		$images_orig = ImageCreateFromJPEG($images);
		$photoX = ImagesY($images_orig);
		$photoY = ImagesY($images_orig);
		$images_fin = ImageCreateTrueColor($width, $height);
		ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
		ImageJPEG($images_fin,"../images/".$new_images);
		//ImageDestroy($images_orig);
		ImageDestroy($images_fin);

		echo "<span style='color:#00ff00;'>Upload Successful.</span>";
		echo "<img src='../images/".$new_images."' style='display:none'>";

		// //*** Insert Record ***//
		// $objConnect = mysql_connect("localhost","root","root") or die("Error Connect to Database");
		// $objDB = mysql_select_db("mydatabase");
		// $sql_update = "UPDATE user_account SET image_profile='$new_images' WHERE username='".$_SESSION["xusername"]."' ";
		// $result_update= mysql_query($sql_update) or die(mysql_error());
	}
}

?>