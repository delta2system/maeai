<?
// $sql = "SELECT * FROM `tracking_event` where id = 1127";
// $qy = mysql_query($sql) or die (mysql_error());

// $fs = mysql_fetch_array($qy);
include("connect.inc");

// $array["first_name"] = 'John';
// $array["last_name"] = 'Smith';
// $array["phone"] = '123456789';

    $sql_ob = "SELECT * from bill where nobill_system = 'INV-00100001' AND barcode = '01043' limit 1";
    $result_ob = mysql_query($sql_ob);
    while ($strResult = mysql_fetch_assoc($result_ob) ) {

    $savetodb = serialize($strResult);
    //$toarray = unserialize($savetodb);
    }


//$savetodb = serialize($array);
$toarray = unserialize($savetodb);

$strSQL = "INSERT INTO bill_cancel SET "; 
$strSQL .="tbl_cancel = '".$savetodb."' ";
$strSQL .=",timedo = '".date("Y-m-d H:i:s")."' ";
$strSQL .=",officer = '".$_SESSION["xusername"]."' ";
$objQuery = mysql_query($strSQL);



echo "<hr>";
echo $savetodb;
echo "<hr>";
echo "<pre>"; print_r($toarray); echo "</pre>";

?>