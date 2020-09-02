<?
session_start();
include("connect.php");

$sql="SELECT row_id,daterecipt FROM store WHERE daterecipt != '0000-00-00' AND daterecipt < '2500-01-01' ORDER By daterecipt ASC ";
$result = mysqli_query($con,$sql);
while ($row = mysqli_fetch_array($result) ) {

echo "<br>".$row["daterecipt"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".(substr($row["daterecipt"],0,4)+543).substr($row["daterecipt"],4);

$strSQL = "UPDATE store SET ";
$strSQL .="daterecipt = '".(substr($row["daterecipt"],0,4)+543).substr($row["daterecipt"],4)."' ";
$strSQL .="WHERE row_id = '".$row[row_id]."' ";
$objQuery = mysqli_query($con,$strSQL)or die(mysqli_error());  
}


?>