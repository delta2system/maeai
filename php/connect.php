<?PHP
//Connect Mysqli
$hostDB="localhost";
$userDB="root";
$passDB="";
$nameDB="tbl_maeai";
$con = mysqli_connect($hostDB,$userDB,$passDB,$nameDB);
mysqli_set_charset($con, "utf8");
mysqli_select_db($con,$nameDB);



if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

?>