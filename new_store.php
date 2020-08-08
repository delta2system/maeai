<?
//include("php/connect.inc");


$con = mysqli_connect("localhost","root_maeai","11501150","tbl_maeai");
//$sql="SELECT opcard.hn, opcard.ampur, opcard.tambol FROM opcard INNER JOIN opday ON opcard.hn=opday.hn WHERE thidate like '2017-06%'";
//$sql="SELECT store_bk.code FROM store_bk INNER JOIN store ON store_bk.code!=store.code WHERE 1 ";
$sql = "SELECT * from store WHERE 1";
$result = mysqli_query($con,$sql);
while ($row = mysqli_fetch_array($result) ) {

// $results = mysqli_query($con,"SELECT * FROM store where code = '".$row["code"]."'");
// $nums = mysqli_num_rows($results);

// if(empty($nums)){
	$t++;
echo $t." ".$row["code"]."<br>";
//}
// if(empty($row["daterecipt"])){
// $dr=explode("/","00/00/0000");	
// }else{
// $dr=explode("/",$row["daterecipt"]);
// }
  $sql = "SELECT lifetime,depreciation from store_type WHERE code = '".$row["store_type"]."'";
  list($lifetime,$depreciation) = Mysqli_fetch_row(Mysqli_Query($con,$sql));

$strSQL = "UPDATE store SET ";

// $strSQL .="numberofsets = '".$row["unit"]."' ";
// if($row["company"]){
// 	$strSQL .=",company = '".$code."' ";
// }
// $strSQL .=",seller = '".$name."' ";
// $strSQL .=",telephone = '".$phone."' ";
// $strSQL .=",address = '".$address."' ";
// $strSQL .=",daterecipt = '".$dr[2]."-".str_pad($dr[1],2,'0',STR_PAD_LEFT)."-".str_pad($dr[0],2,'0',STR_PAD_LEFT)."' ";
// $strSQL .=",address_store = '".iroom($row["responsible"])."' ";
$strSQL .="depreciation = '".$depreciation."' ";
$strSQL .=",lifetime = '".$lifetime."' ";
$strSQL .=",how_cal = '1' ";
// $strSQL .=",officer = 'admin' ";
$strSQL .="WHERE row_id = '".$row["row_id"]."' ";
$objQuery = mysqli_query($con,$strSQL);  



}



?>