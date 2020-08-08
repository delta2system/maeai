<?
include("connect.inc");


//INSERT INTO `tbl_import2_excel`(`row_id`, `dateday`, `daterecipt`, `nobill_recipt`, `company`, `detail`, `pcs`, `price`, `total_money`, `type_hire`, `department`, `maikai`, `trimas`, `other`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],[value-13],[value-14])
mysql_query("SET character_set_results=tis620");
mysql_query("SET character_set_client=tis620");
mysql_query("SET character_set_connection=tis620");
?>

<html>
<head>
<title>ThaiCreate.Com PHP & CSV To MySQL</title>

  <meta http-equiv=Content-Type content="text/html; charset=tis-620">
</head>
<body>
<form action="" method="post" enctype="multipart/form-data" name="form1">
  <input name="fileCSV" type="file" id="fileCSV">
  <input name="btnSubmit" type="submit" id="btnSubmit" value="Submit">
</form>
</body>
</html>

<?

if($_FILES["fileCSV"]["tmp_name"]){

move_uploaded_file($_FILES["fileCSV"]["tmp_name"],"test.csv"); // Copy/Upload CSV
chmod("test.csv",0777);
// $objConnect = mysql_connect("localhost","root","root") or die("Error Connect to Database"); // Conect to MySQL
// $objDB = mysql_select_db("mydatabase");

$objCSV = fopen("test.csv", "r");
while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	$i++;
	if($objArr[5]!="" && $i>1){

		if($objArr[0]!=""){
		$dateday=explode("/", $objArr[0]);
		if($dateday[2]!=""){$dateday[2]="25".$dateday[2];}else{$dateday[2]="";}
		}
		
		if($objArr[1]!=""){

		$daterecipt=explode("/", $objArr[1]);
		if($daterecipt[2]!=""){$daterecipt[2]="25".$daterecipt[2];}else{$daterecipt[2]="";}
		}
	$strSQL = "INSERT INTO tbl_import2_excel ";
	$strSQL .="( dateday, daterecipt, nobill_recipt, company, detail, pcs, price, total_money, type_hire, department, maikai, trimas, other) ";
	$strSQL .="VALUES ";
	$strSQL .="('".$dateday[2]."-".$dateday[1]."-".$dateday[0]."','".$daterecipt[2]."-".$daterecipt[1]."-".$daterecipt[0]."','".$objArr[2]."' ";
	$strSQL .=",'".$objArr[3]."','".$objArr[4]."','".str_replace(",", "",$objArr[5])."' ";
	$strSQL .=",'".str_replace(",", "",$objArr[6])."','".str_replace(",", "",$objArr[7])."','".$objArr[8]."' ";
	$strSQL .=",'".$objArr[9]."','".$objArr[10]."','".$objArr[11]."','".$objArr[12]."') ";
	$objQuery = mysql_query($strSQL) or die(mysql_error());
	//echo $strSQL."<br>";
}
}
fclose($objCSV);



$sql = "SELECT * from tbl_import2_excel WHERE nobill_recipt != '' GROUP By nobill_recipt ";
$result = mysql_query($sql);
while ($data = mysql_fetch_array($result) ) {
//detail, pcs, price,type_hire, department

	$sql_rowbill = "SELECT row_bill from tbl_import2_head  ORDER By row_bill DESC  limit 1  ";
    list($row_bill) = Mysql_fetch_row(Mysql_Query($sql_rowbill));


	$sql2 = "SELECT * from tbl_import2_excel WHERE nobill_recipt = '".$data[nobill_recipt]."'  ";
	$result2 = mysql_query($sql2);
	$sumtotal=array("");
	while ($row = mysql_fetch_array($result2) ) {
    $strSQL = "INSERT INTO tbl_import2_body ";
	$strSQL .="(row_bill,detail,pcs,price) ";
	$strSQL .="VALUES ";
	$strSQL .="('".($row_bill+1)."','".$row[detail]."','".$row[pcs]."' ";
	$strSQL .=",'".$row[price]."') ";
	$objQuery = mysql_query($strSQL) or die(mysql_error());
	array_push($sumtotal,$row[total_money]);
	}



	$sql_hire = "SELECT row_id from hire_type WHERE detail  = '".$data[type_hire]."'  limit 1  ";
    list($type_hire) = Mysql_fetch_row(Mysql_Query($sql_hire));
    if(empty($type_hire)){$type_hire=$data[type_hire];}

 	$sql_depart = "SELECT code from department WHERE name = '".$data[department]."'   limit 1  ";
    list($department) = Mysql_fetch_row(Mysql_Query($sql_depart));
    if(empty($department)){$department=$data[department];}

    $strSQL = "INSERT INTO tbl_import2_head ";
	$strSQL .="( dateday, daterecipt, nobill_recipt, company, total_money, type_hire, department, other,row_bill) ";
	$strSQL .="VALUES ";
	$strSQL .="('".$data[dateday]."','".$data[daterecipt]."','".$data[nobill_recipt]."' ";
	$strSQL .=",'".$data[company]."','".array_sum($sumtotal)."','".$type_hire."' ";
	$strSQL .=",'".$department."','".$data[other]."','".($row_bill+1)."') ";
	$objQuery = mysql_query($strSQL) or die(mysql_error());

}
echo "Upload & Import Done.";
    $sql="TRUNCATE TABLE tbl_import2_excel";
    mysql_query($sql);
}
?>
</table>