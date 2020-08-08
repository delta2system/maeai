<?php
// header("Content-type:text/html; charset=UTF-8");        
// header("Cache-Control: no-store, no-cache, must-revalidate");       
// header("Cache-Control: post-check=0, pre-check=0", false);       
// เชื่อมต่อฐานข้อมูล
/*$link=mysql_connect("localhost","root","1234") or die("error".mysql_error());
mysql_select_db("rssupply",$link);
mysql_query("set character set utf8");*/
include("../connect.inc");

if(isset($_GET["q"])){
$q = urldecode($_GET["q"]);
$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db="customer_supply"; // ตารางที่ต้องการค้นหา
$find_field="name"; // ฟิลที่ต้องการค้นหา

//$sql = "SELECT * from $table_db  where locate('$q', $find_field) > 0 order by locate('$q', $find_field), $find_field limit $pagesize";
$sql = "SELECT * from $table_db  where name like '%$q%' OR code like '%$q%'  limit $pagesize";
$results = mysql_query($sql);
if(mysql_num_rows($results)){
while ($row = mysql_fetch_array( $results )) {
	$id = $row["code"]; // ฟิลที่ต้องการส่งค่ากลับ
	 $name = ucwords( strtolower( $row["name"] ) ); // ฟิลที่ต้องการแสดงค่า
	 $name.= " ".ucwords( strtolower( $row["address"] ) );
	// $name =  $row["name"]." ".$row["address"];
	// ป้องกันเครื่องหมาย '
	$name = str_replace("'", "'", $name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	//$display_name = preg_replace("/(" . $q . ")/i", "<b>$1</b>", $name);
	$display_name=$name;
	echo "<li onselect=\"this.setText('$id').setValue('$name');\" style='font-size:16px;'>$display_name</li>";
}}
}else if(isset($_GET["r"])){

$r = urldecode($_GET["r"]);
$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db="personal"; // ตารางที่ต้องการค้นหา
$find_field="name"; // ฟิลที่ต้องการค้นหา

//$sql = "SELECT * from $table_db  where locate('$q', $find_field) > 0 order by locate('$q', $find_field), $find_field limit $pagesize";
$sql = "SELECT * from $table_db  where name like '%$r%' OR code like '%$r%'  limit $pagesize";
$results = mysql_query($sql);
if(mysql_num_rows($results)){
while ($row = mysql_fetch_array( $results )) {
	$id = $row["code"]; // ฟิลที่ต้องการส่งค่ากลับ
	//$name = ucwords( strtolower( $row["name"] ) ); // ฟิลที่ต้องการแสดงค่า

	$name = $row["name"];
	// ป้องกันเครื่องหมาย '
	//$name = str_replace("'", "'", $name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	//$display_name = preg_replace("/(" . $q . ")/i", "<b>$1</b>", $name);
	$display_name =$name;
	echo "<li onselect=\"this.setText('$id').setValue('$name');\" style='font-size:16px;'>$display_name</li>";
}

}


}else if(isset($_GET["product"])){

$q = urldecode($_GET["product"]);
$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db="stock_product"; // ตารางที่ต้องการค้นหา
$find_field="detail"; // ฟิลที่ต้องการค้นหา

//$sql = "SELECT * from $table_db  where locate('$q', $find_field) > 0 order by locate('$q', $find_field), $find_field limit $pagesize";
$sql = "SELECT * from $table_db  where detail like '%$q%' OR barcode like '%$q%'   order by pcs desc limit $pagesize";
$results = mysql_query($sql);
if(mysql_num_rows($results)){
while ($row = mysql_fetch_array( $results )) {
	$id = $row["barcode"]; // ฟิลที่ต้องการส่งค่ากลับ
	$name = ucwords( strtolower( $row["detail"] ) ); // ฟิลที่ต้องการแสดงค่า
	// ป้องกันเครื่องหมาย '
	$name = str_replace("'", "'", $name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	//$display_name = preg_replace("/(" . $q . ")/i", "<b>$1</b>", $name);
	$display_name=$name." ราคา ".$row["price_in"]." : ".$row["pcs"]." ".$row["unit"];
	echo "<li onselect=\"this.setText('$id').setValue('$name');\" style='font-size:16px;'>$display_name</li>";
}

}


}else if(isset($_GET["department"])){

$q = urldecode($_GET["department"]);
$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db="department"; // ตารางที่ต้องการค้นหา
//$find_field="detail"; // ฟิลที่ต้องการค้นหา

//$sql = "SELECT * from $table_db  where locate('$q', $find_field) > 0 order by locate('$q', $find_field), $find_field limit $pagesize";
$sql = "SELECT * from $table_db  where code like '%$q%' OR name like '%$q%'  limit $pagesize";
$results = mysql_query($sql);
if(mysql_num_rows($results)){
while ($row = mysql_fetch_array( $results )) {
	$id = $row["code"]; // ฟิลที่ต้องการส่งค่ากลับ
	$name = ucwords( strtolower( $row["name"] ) ); // ฟิลที่ต้องการแสดงค่า
	// ป้องกันเครื่องหมาย '
	$name = str_replace("'", "'", $name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	//$display_name = preg_replace("/(" . $q . ")/i", "<b>$1</b>", $name);
	$display_name=$name;
	echo "<li onselect=\"this.setText('$id').setValue('$name');\" style='font-size:16px;'>$display_name</li>";
}

}
}


//mysql_close();
?>
