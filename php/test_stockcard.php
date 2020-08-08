<?
session_start();
include("connect.inc");
?>
<style type="text/css">
	td{
		border-bottom:1px solid #606060;
	}
</style>
<?
	echo "<table>";
	echo "<td>row_id</td>"
		."<td>nobill_system</td>"
		."<td>dateday</td>"
		."<td>lasttime</td>"
		."<td>barcode</td>"
		."<td>detail</td>"
		."<td>laststock</td>"
		."<td>pcs</td>"
		."<td>pcs_stock</td>";
		if($_GET["barcode"]){
	$sql_x = "SELECT barcode,detail from bill where barcode = '".$_GET["barcode"]."' GROUP By barcode ORDER By barcode ASC ";		
		}else if($_GET["limit"]){
	$sql_x = "SELECT barcode,detail from bill where 1 GROUP By barcode ORDER By barcode ASC limit ".$_GET["limit"];		
		}else{
    $sql_x = "SELECT barcode,detail from bill where 1 GROUP By barcode ORDER By barcode ASC limit 0,20 ";
    	}
	$result_x = mysql_query($sql_x);
	while ($data = mysql_fetch_array($result_x) ) {	
		echo "<tr><td colspan='9'> $data[barcode] $data[detail]</td>";

	$sql = "SELECT SUM(pcs) from stock_product WHERE barcode = '$data[barcode]'  GROUP By barcode ";
    list($pcs_stock) = Mysql_fetch_row(Mysql_Query($sql));	


   $sql_s = "SELECT row_id,nobill_system,dateday,lasttime,barcode,detail,laststock,pcs,pcs_stock,status from bill where barcode = '$data[barcode]' ORDER By barcode ASC,dateday ASC,lasttime ASC ";
	$result_s = mysql_query($sql_s);

	while ($row = mysql_fetch_array($result_s) ) {	
		if($row[status]=="INV"){
			$bgr="#ffb3b3";
		}else{
			$bgr="#ffffff";
		}
		print "<tr style='background-color:$bgr;'>"
			."<td>$row[row_id]</td>"
			."<td>$row[nobill_system]</td>"
			."<td>$row[dateday]</td>"
			."<td>$row[lasttime]</td>"
			."<td>$row[barcode]</td>"
			."<td>$row[detail]</td>"
			."<td>$row[laststock]</td>"
			."<td>$row[pcs]</td>"
			."<td>$row[pcs_stock]</td>";

	}
	echo "<tr><td colspan='9'> คงเหลือ $pcs_stock</td>";
	

	   $sql_w = "SELECT row_id,nobill_system,dateday,lasttime,barcode,detail,laststock,pcs,pcs_stock,status from bill where barcode = '$data[barcode]' ORDER By barcode ASC,dateday DESC,lasttime DESC ";
	$result_w = mysql_query($sql_w);
	$laststock="0";
	$i=0;
	while ($rowp = mysql_fetch_array($result_w) ) {	
		$i++;
		if($i==1){
		$stock_old = $pcs_stock;
		if($rowp[status]=="INV"){
		$laststock=$pcs_stock-$rowp[pcs];	
		}else{
		$laststock=$rowp[pcs]+$pcs_stock;
		}

		$sql_update = "UPDATE bill SET pcs_stock='$stock_old',laststock='".$laststock."' WHERE row_id='$rowp[row_id]' ";
	    $result_update= mysql_query($sql_update) or die(mysql_error());

		}else{
		$stock_old = $laststock;
		if($rowp[status]=="INV"){
		$laststock=$rowp[pcs]-$laststock;	
		}else{
		$laststock=$rowp[pcs]+$laststock;
		}

		$sql_update = "UPDATE bill SET pcs_stock='$stock_old',laststock='".$laststock."' WHERE row_id='$rowp[row_id]' ";
	    $result_update= mysql_query($sql_update) or die(mysql_error());

	}
		// $sql_update = "UPDATE bill SET pcs_stock='$pcs_laststock',laststock='$pcs_stock' WHERE row_id='$rowp[row_id]' ";
	 //    $result_update= mysql_query($sql_update) or die(mysql_error());

		print "<tr style='background-color:$bgr;'>"
			."<td>$rowp[row_id]</td>"
			."<td>$rowp[nobill_system]</td>"
			."<td>$rowp[dateday]</td>"
			."<td>$rowp[lasttime]</td>"
			."<td>$rowp[barcode]</td>"
			."<td>$rowp[detail]</td>"
			."<td>$rowp[laststock]</td>"
			."<td>$rowp[pcs]</td>"
			."<td>$rowp[pcs_stock]</td>";

	}
}


?>