<?
include("connect.inc");

function plug_stock($barcode,$out){
//$barcode="01001";
//$out=4;

$sql="SELECT * FROM stock_product where barcode = '$barcode' AND pcs > '0' ORDER By lastin ASC";
$result = mysql_query($sql);
while($data = mysql_fetch_array($result)){
	$i++;
	if($out <= $data[pcs] && $i==1 && $out !="0"){
		$data[pcs]-$out;
	}else if($out > $data[pcs] && $i==1 && $out !="0"){
		$lastpcs=$out-$data[pcs];
		$out = $lastpcs;
		$sql_update = "UPDATE stock_product SET pcs='0',lastupdate='".date("Y-m-d H:s:i")."',officer_last='".$_SESSION["xusername"]."' where row_id = '$data[row_id]' ";
		$result_update= mysql_query($sql_update) or die(mysql_error());
		//print "<br>";
	}else if($out >= $data[pcs] && $i>1 && $out !="0"){
		$lastpcs=$out-$data[pcs];
		$out = $lastpcs;
		$sql_update = "UPDATE stock_product SET pcs='0',lastupdate='".date("Y-m-d H:s:i")."',officer_last='".$_SESSION["xusername"]."' where row_id = '$data[row_id]' ";		
		$result_update= mysql_query($sql_update) or die(mysql_error());
		//print "<br>";
	}else if($out <= $data[pcs] && $i>1 && $out !="0"){
		$lastpcs=$data[pcs]-$out;
		$out=0;
	    $sql_update = "UPDATE stock_product SET pcs='$lastpcs',lastupdate='".date("Y-m-d H:s:i")."',officer_last='".$_SESSION["xusername"]."' where row_id = '$data[row_id]' ";	
		$result_update= mysql_query($sql_update) or die(mysql_error());
		//print "<br>";
	}

}
//return $lastpcs;
}
plug_stock('01001','5');

?>