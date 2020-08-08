<?
session_start();
include("connect.inc");

 $sql="SELECT *,department.name FROM test_1 INNER JOIN department ON test_1.customer_id = department.code  ORDER By test_1.dateday ASC ";

// $sql="SELECT * FROM test_1 ";
$result = mysql_query($sql);
$yx=date("y");
while ($row = mysql_fetch_array($result) ) {
$j++;
echo "<span style='color:red;'>$j</span><br> ";

// $sql_r="SELECT * FROM test_2 WHERE nobill = '".$row[nobill]."'";

$i++;
if($yx!=(substr($row[dateday],2,2)-43)){

$new_nobill_system="OWH-".(substr($row[dateday],2,2)-43).substr($row[dateday],5,2)."00001";
$yx=(substr($row[dateday],2,2)-43);
$no=1;
}else{
$new_nobill_system="OWH-".(substr($row[dateday],2,2)-43).substr($row[dateday],5,2).str_pad($no+$i, 5,"0",STR_PAD_LEFT);	
$yx=(substr($row[dateday],2,2)-43);
}

$sql_r="SELECT test_2.*,stock_product.group_type,stock_product.detail,stock_product.price_in FROM test_2 INNER JOIN stock_product ON test_2.barcode=stock_product.barcode WHERE nobill = '".$row[nobill]."'" ;
$result_r = mysql_query($sql_r);
$no="0";

while ($data = mysql_fetch_array($result_r) ) {



$strSQL = "INSERT INTO bill SET "; 
$strSQL .="nobill_system = '".$new_nobill_system."' ";
$strSQL .=",nobill = '".$row["nobill"]."' ";
$strSQL .=",nobill_recipt = '".$row["order_bill"]."' ";
$strSQL .=",dateday = '".$row[dateday]."' ";
$strSQL .=",lasttime = '".date("H:i:s")."' ";
$strSQL .=",customer_id = '".$row["customer_id"]."' ";
$strSQL .=",customer_name = '".$row["name"]."' ";
$strSQL .=",persanal = '".$row["personal_id"]."' ";
$strSQL .=",group_type = '".$data["group_type"]."' ";
$strSQL .=",barcode = '".$data["barcode"]."' ";
$strSQL .=",detail = '".$data["detail"]."' ";
//$strSQL .=",laststock = '".$data["pcs"]."' ";
$strSQL .=",pcs = '".$data["pcs"]."' ";
$strSQL .=",price = '".$data["price_in"]."' ";
//$strSQL .=",pcs_stock = '0' ";
$strSQL .=",other = '".$data["other"]."' ";
$strSQL .=",status = 'OWH' ";
$strSQL .=",officer = '".$_SESSION["xusername"]."' ";
$objQuery = mysql_query($strSQL);



}
}



// //ทำการเปิดไฟล์ CSV เพื่อนำข้อมูลไปใส่ใน MySQL
// $objCSV = fopen("book1.csv", "r");
// while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
//         //นำข้อมูลใส่ในตาราง member
// $i++;
// if($i>1){
//  $strSQL = "INSERT INTO test_1 ";

//         //ข้อมูลใส่ใน field ข้อมูลดังนี้
//  $strSQL .="(nobill,dateday,customer_id,personal_id,order_bill) ";
//  $strSQL .="VALUES ";
        
//         //ข้อมูลตามที่อ่านได้จากไฟล์ลงฐานข้อมูล
//  $strSQL .="('".$objArr[0]."','".$objArr[1]."','".$objArr[2]."' ";
//  $strSQL .=",'".$objArr[3]."','".$objArr[4]."') ";
 
//  //ให้ข้อมูลอยู่ในรูปแบบที่อ่านได้ใน phpmyadmin (By.SlayerBUU Credits พี่ไผ่)
//  //mysql_query("SET NAMES UTF8");
// echo $strSQL."<br>";
//  //เพิ่มข้อมูลลงฐานข้อมูล
//  $objQuery = mysql_query($strSQL)or die(mysql_error());
// }
// }
// fclose($objCSV);


?>