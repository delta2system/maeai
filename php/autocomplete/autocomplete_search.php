<?
include("../connect.inc");

if($_POST["submit"]=="stock_product"){
// 	$comma = '';
//     $allEmp = '';
//     $sql="SELECT id,name,address,phone,fax  FROM customer_name WHERE name like '%".$_POST["keyword"]."%' ORDER BY row_id ASC";
//     $result=mysql_query($sql) or die(mysql_error()." [$sql]");
//     while ($row = mysql_fetch_array($result)) {
//       $allEmp .= $comma.'{value: "'.$row['id'].'",label: "'.$row['name'].'",address: "'.$row['address'].'",phone: "'.$row['phone'].'",fax: "'.$row['fax'].'"}';
//       if($comma==='') $comma = ',';
//     }
//     //การใช้งานจริง ส่วนนี้จะถูกเขียนเป็นไฟล์ .js เพื่อเรียกใช้ใน javascript
// echo     $allEmp = '['. $allEmp . ']';
  $strSQL = "SELECT * FROM stock_product WHERE detail like '%".$_POST["keyword"]."%' or barcode like '%".$_POST["keyword"]."%' ORDER BY row_id ASC ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    // for($i=0;$i<$intNumField;$i++)
    // {
    //   $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
    // }
   //$arrCol["label"] = "<div>".$obResult["detail"]." ราคา ".$obResult["price_in"]." คงเหลือ :".$obResult["pcs"]." ".$obResult["unit"];
    //$arrCol["value"] = $obResult["barcode"];
          $arrCol["label"] = "<span>";
          $arrCol["label"] .= "<span style='border:0px soild #e0e0e0;width:250px;height:30px;display:inline;overflow:hidden;'>".$obResult["detail"]."</span>";
          $arrCol["label"] .= "<span style='position:absolute;margin-left:240px;left:0px;text-align:right;width:100px;color:red;'>".$obResult["pcs"]."</span>";
          $arrCol["label"] .= "<span style='position:absolute;margin-left:350px;left:0px;text-align:left;width:40px;''>".$obResult["unit"]."</span>";
          $arrCol["label"] .= "<span style='position:absolute;margin-left:380px;left:0px;text-align:right;width:80px;''>".$obResult["price_in"].".-</span>";
          $arrCol["label"] .= "<input type='hidden' value='".$obResult["barcode"]."' onclick=\"check_product('".$obResult["barcode"]."')\">";
          $arrCol["label"] .= "</span>";
    array_push($resultArray,$arrCol);
  }
  
  //mysql_close($Conn);
  
  echo json_encode($resultArray);	
}else if($_POST["submit"]=="name_supply"){
$r = $_POST["keyword"];

  $strSQL = "SELECT * from customer_supply  where name like '%".$_POST["keyword"]."%' OR row_id like '%".$_POST["keyword"]."%' ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
          $arrCol["label"] = "<span>";
          $arrCol["label"] .= "<span style='border:0px soild #e0e0e0;width:30px;height:30px;display:inline;overflow:hidden;'>".$obResult["row_id"]."</span>";
          $arrCol["label"] .= "<span style='position:absolute;margin-left:50px;left:0px;text-align:left;'>".$obResult["name"]."</span>";
          $arrCol["label"] .= "<input type='hidden' value='".$obResult["name"]."' onclick=\"set_supply('".$obResult["row_id"]."','".$obResult["name"]."')\">";
          $arrCol["label"] .= "</span>";
    array_push($resultArray,$arrCol);
  }
  
  //mysql_close($Conn);
  
  echo json_encode($resultArray); 



}else if($_POST["submit"]=="name_persanal"){

$r = $_POST["keyword"];

  $strSQL = "SELECT * from user_account  where fullname like '%".$_POST["keyword"]."%' OR row_id like '%".$_POST["keyword"]."%' ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
          $arrCol["label"] = "<span>";
          $arrCol["label"] .= "<span style='border:0px soild #e0e0e0;width:30px;height:30px;display:inline;overflow:hidden;'>".$obResult["row_id"]."</span>";
          $arrCol["label"] .= "<span style='position:absolute;margin-left:50px;left:0px;text-align:left;'>".$obResult["fullname"]."</span>";
          $arrCol["label"] .= "<input type='hidden' value='".$obResult["fullname"]."' onclick=\"set_persanal('".$obResult["row_id"]."','".$obResult["fullname"]."')\">";
          $arrCol["label"] .= "</span>";
    array_push($resultArray,$arrCol);
  }
  
  //mysql_close($Conn);
  
  echo json_encode($resultArray); 
}

?>