<?session_start();
include("connect.inc");

 if($_POST["submit"]=="return_data"){
 $resultArray = array();	
 $arrCol = array();

  $sql = "SELECT last_pcs,last_total,pcs,total,bill from fuel_tank WHERE fuel = '95' AND dateday < '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-01' ORDER By dateday DESC  limit 1  ";
  list($last_pcs,$last_total,$pcs,$total,$bill) = Mysql_fetch_row(Mysql_Query($sql));
  if(substr_count($bill,"OLP")){
    $arrCol[pcs_95] = $last_pcs - $pcs;
    $arrCol[total_95] = $last_total - $total;
  }else if(substr_count($bill,"REV")){
    $arrCol[pcs_95] = $last_pcs + $pcs;
    $arrCol[total_95] = $last_total + $total;
  }


  $sql = "SELECT last_pcs,last_total,pcs,total,bill from fuel_tank WHERE fuel = '91' AND dateday < '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-01' ORDER By dateday DESC  limit 1  ";
  list($last_pcs,$last_total,$pcs,$total,$bill) = Mysql_fetch_row(Mysql_Query($sql));
  if(substr_count($bill,"OLP")){
    $arrCol[pcs_91] = $last_pcs - $pcs;
    $arrCol[total_91] = $last_total - $total;
  }else if(substr_count($bill,"REV")){
    $arrCol[pcs_91] = $last_pcs + $pcs;
    $arrCol[total_91] = $last_total + $total;
  }

 $sql = "SELECT last_pcs,last_total,pcs,total,bill from fuel_tank WHERE fuel = 'diesel' AND dateday < '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-01' ORDER By dateday DESC  limit 1  ";
  list($last_pcs,$last_total,$pcs,$total,$bill) = Mysql_fetch_row(Mysql_Query($sql));
  if(substr_count($bill,"OLP")){
    $arrCol[pcs_diesel] = $last_pcs - $pcs;
    $arrCol[total_diesel] = $last_total - $total;
  }else if(substr_count($bill,"REV")){
    $arrCol[pcs_diesel] = $last_pcs + $pcs;
    $arrCol[total_diesel] = $last_total + $total;
  }

 $sql = "SELECT last_pcs,last_total,pcs,total,bill from fuel_tank WHERE fuel = 'brake' AND dateday < '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-01' ORDER By dateday DESC  limit 1  ";
  list($last_pcs,$last_total,$pcs,$total,$bill) = Mysql_fetch_row(Mysql_Query($sql));
  if(substr_count($bill,"OLP")){
    $arrCol[pcs_brake] = $last_pcs - $pcs;
    $arrCol[total_brake] = $last_total - $total;
  }else if(substr_count($bill,"REV")){
    $arrCol[pcs_brake] = $last_pcs + $pcs;
    $arrCol[total_brake] = $last_total + $total;
  }


 $sql = "SELECT last_pcs,last_total,pcs,total,bill from fuel_tank WHERE fuel = 'engine' AND dateday < '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-01' ORDER By dateday DESC  limit 1  ";
  list($last_pcs,$last_total,$pcs,$total,$bill) = Mysql_fetch_row(Mysql_Query($sql));
  if(substr_count($bill,"OLP")){
    $arrCol[pcs_engine] = $last_pcs - $pcs;
    $arrCol[total_engine] = $last_total - $total;
  }else if(substr_count($bill,"REV")){
    $arrCol[pcs_engine] = $last_pcs + $pcs;
    $arrCol[total_engine] = $last_total + $total;
  }

  $sql = "SELECT last_pcs,last_total,pcs,total,bill from fuel_tank WHERE fuel = 'oilmix' AND dateday < '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-01' ORDER By dateday DESC  limit 1  ";
  list($last_pcs,$last_total,$pcs,$total,$bill) = Mysql_fetch_row(Mysql_Query($sql));
  if(substr_count($bill,"OLP")){
    $arrCol[pcs_oilmix] = $last_pcs - $pcs;
    $arrCol[total_oilmix] = $last_total - $total;
  }else if(substr_count($bill,"REV")){
    $arrCol[pcs_oilmix] = $last_pcs + $pcs;
    $arrCol[total_oilmix] = $last_total + $total;
  }

  $sql = "SELECT last_pcs,last_total,pcs,total,bill from fuel_tank WHERE fuel = 'water' AND dateday < '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-01' ORDER By dateday DESC  limit 1  ";
  list($last_pcs,$last_total,$pcs,$total,$bill) = Mysql_fetch_row(Mysql_Query($sql));
  if(substr_count($bill,"OLP")){
    $arrCol[pcs_water] = $last_pcs - $pcs;
    $arrCol[total_water] = $last_total - $total;
  }else if(substr_count($bill,"REV")){
    $arrCol[pcs_water] = $last_pcs + $pcs;
    $arrCol[total_water] = $last_total + $total;
  }

  $sql = "SELECT SUM(pcs),SUM(total) from fuel_tank WHERE fuel = '91' AND bill like 'REV%' AND dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%' GROUP By fuel   ";
  list($revpcs91,$revtotal91) = Mysql_fetch_row(Mysql_Query($sql));
  $arrCol[revpcs_91]= $revpcs91; 	$arrCol[revtotal_91]=$revtotal91;

  $sql = "SELECT SUM(pcs),SUM(total) from fuel_tank WHERE fuel = '95' AND bill like 'REV%' AND dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%' GROUP By fuel   ";
  list($revpcs91,$revtotal95) = Mysql_fetch_row(Mysql_Query($sql));
  $arrCol[revpcs_95]= $revpcs95; 	$arrCol[revtotal_95]=$revtotal95;

  $sql = "SELECT SUM(pcs),SUM(total) from fuel_tank WHERE fuel = 'diesel' AND bill like 'REV%' AND dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%' GROUP By fuel   ";
  list($revpcsdiesel,$revtotaldiesel) = Mysql_fetch_row(Mysql_Query($sql));
  $arrCol[revpcs_diesel]= $revpcsdiesel; 	$arrCol[revtotal_diesel]=$revtotaldiesel;

  $sql = "SELECT SUM(pcs),SUM(total) from fuel_tank WHERE fuel = 'brake' AND bill like 'REV%' AND dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%' GROUP By fuel   ";
  list($revpcsbrake,$revtotalbrake) = Mysql_fetch_row(Mysql_Query($sql));
  $arrCol[revpcs_brake]= $revpcsbrake; 	$arrCol[revtotal_brake]=$revtotalbrake;

   $sql = "SELECT SUM(pcs),SUM(total) from fuel_tank WHERE fuel = 'engine' AND bill like 'REV%' AND dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%' GROUP By fuel   ";
  list($revpcsengine,$revtotalengine) = Mysql_fetch_row(Mysql_Query($sql));
  $arrCol[revpcs_engine]= $revpcsengine; 	$arrCol[revtotal_engine]=$revtotalengine;

    $sql = "SELECT SUM(pcs),SUM(total) from fuel_tank WHERE fuel = 'oilmix' AND bill like 'REV%' AND dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%' GROUP By fuel   ";
  list($revpcsoilmix,$revtotaloilmix) = Mysql_fetch_row(Mysql_Query($sql));
  $arrCol[revpcs_oilmix]= $revpcsoilmix; 	$arrCol[revtotal_oilmix]=$revtotaloilmix;

    $sql = "SELECT SUM(pcs),SUM(total) from fuel_tank WHERE fuel = 'water' AND bill like 'REV%' AND dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%' GROUP By fuel   ";
  list($revpcswater,$revtotalwater) = Mysql_fetch_row(Mysql_Query($sql));
  $arrCol[revpcs_water]= $revpcswater; 	$arrCol[revtotal_water]=$revtotalwater;



  $sql = "SELECT SUM(pcs),SUM(total) from fuel_tank WHERE fuel = '91' AND bill like 'OLP%' AND dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%' GROUP By fuel   ";
  list($olppcs91,$olptotal91) = Mysql_fetch_row(Mysql_Query($sql));
  $arrCol[olppcs_91]= $olppcs91; 	$arrCol[olptotal_91]=$olptotal91;

  $sql = "SELECT SUM(pcs),SUM(total) from fuel_tank WHERE fuel = '95' AND bill like 'OLP%' AND dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%' GROUP By fuel   ";
  list($olppcs91,$olptotal95) = Mysql_fetch_row(Mysql_Query($sql));
  $arrCol[olppcs_95]= $olppcs95; 	$arrCol[olptotal_95]=$olptotal95;

  $sql = "SELECT SUM(pcs),SUM(total) from fuel_tank WHERE fuel = 'diesel' AND bill like 'OLP%' AND dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%' GROUP By fuel   ";
  list($olppcsdiesel,$olptotaldiesel) = Mysql_fetch_row(Mysql_Query($sql));
  $arrCol[olppcs_diesel]= $olppcsdiesel; 	$arrCol[olptotal_diesel]=$olptotaldiesel;

  $sql = "SELECT SUM(pcs),SUM(total) from fuel_tank WHERE fuel = 'brake' AND bill like 'OLP%' AND dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%' GROUP By fuel   ";
  list($olppcsbrake,$olptotalbrake) = Mysql_fetch_row(Mysql_Query($sql));
  $arrCol[olppcs_brake]= $olppcsbrake; 	$arrCol[olptotal_brake]=$olptotalbrake;

   $sql = "SELECT SUM(pcs),SUM(total) from fuel_tank WHERE fuel = 'engine' AND bill like 'OLP%' AND dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%' GROUP By fuel   ";
  list($olppcsengine,$olptotalengine) = Mysql_fetch_row(Mysql_Query($sql));
  $arrCol[olppcs_engine]= $olppcsengine; 	$arrCol[olptotal_engine]=$olptotalengine;

    $sql = "SELECT SUM(pcs),SUM(total) from fuel_tank WHERE fuel = 'oilmix' AND bill like 'OLP%' AND dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%' GROUP By fuel   ";
  list($olppcsoilmix,$olptotaloilmix) = Mysql_fetch_row(Mysql_Query($sql));
  $arrCol[olppcs_oilmix]= $olppcsoilmix; 	$arrCol[olptotal_oilmix]=$olptotaloilmix;

    $sql = "SELECT SUM(pcs),SUM(total) from fuel_tank WHERE fuel = 'water' AND bill like 'OLP%' AND dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%' GROUP By fuel   ";
  list($olppcswater,$olptotalwater) = Mysql_fetch_row(Mysql_Query($sql));
  $arrCol[olppcs_water]= $olppcswater; 	$arrCol[olptotal_water]=$olptotalwater;

$arrCol[lastpcs_91]= ($arrCol[revpcs_91]+$arrCol[pcs_91])-$arrCol[olppcs_91];
$arrCol[lasttotal_91]= ($arrCol[revtotal_91]+$arrCol[total_91])-$arrCol[olptotal_91];
$arrCol[lastpcs_95]= ($arrCol[revpcs_95]+$arrCol[pcs_95])-$arrCol[olppcs_95];
$arrCol[lasttotal_95]= ($arrCol[revtotal_95]+$arrCol[total_95])-$arrCol[olptotal_95];
$arrCol[lastpcs_diesel]= ($arrCol[revpcs_diesel]+$arrCol[pcs_diesel])-$arrCol[olppcs_diesel];
$arrCol[lasttotal_diesel]= ($arrCol[revtotal_diesel]+$arrCol[total_diesel])-$arrCol[olptotal_diesel];
$arrCol[lastpcs_brake]= ($arrCol[revpcs_brake]+$arrCol[pcs_brake])-$arrCol[olppcs_brake];
$arrCol[lasttotal_brake]= ($arrCol[revtotal_brake]+$arrCol[total_brake])-$arrCol[olptotal_brake];
$arrCol[lastpcs_engine]= ($arrCol[revpcs_engine]+$arrCol[pcs_engine])-$arrCol[olppcs_engine];
$arrCol[lasttotal_engine]=($arrCol[revtotal_engine]+$arrCol[total_engine])- $arrCol[olptotal_engine];
$arrCol[lastpcs_oilmix]= ($arrCol[revpcs_oilmix]+$arrCol[pcs_oilmix])-$arrCol[olppcs_oilmix];
$arrCol[lasttotal_oilmix]= ($arrCol[revtotal_oilmix]+$arrCol[total_oilmix])-$arrCol[olptotal_oilmix];
$arrCol[lastpcs_water]= ($arrCol[revpcs_water]+$arrCol[pcs_water])-$arrCol[olppcs_water];
$arrCol[lasttotal_water]= ($arrCol[revtotal_water]+$arrCol[total_water])-$arrCol[olptotal_water];


array_push($resultArray,$arrCol);
echo json_encode($resultArray);
}else if($_POST["submit"]=="return_revdata"){

  $strSQL = "SELECT * FROM fuel_tank WHERE bill like 'REV%' AND dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%'";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
    }
    array_push($resultArray,$arrCol);
  }
  
  //mysql_close($Conn);
  
  echo json_encode($resultArray);

}else if($_POST["submit"]=="return_olpdata"){

  $strSQL = "SELECT * FROM fuel_tank WHERE bill like 'OLP%' AND dateday like '".$_POST["y"]."-".str_pad($_POST["m"],2,'0',STR_PAD_LEFT)."-%'";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
    }
    array_push($resultArray,$arrCol);
  }
  
  //mysql_close($Conn);
  
  echo json_encode($resultArray);

}else if($_POST["submit"]=="addrev"){

$sql = "SELECT bill from fuel_tank where bill like 'REV%' order by bill desc  limit 1  ";
list($bill) = Mysql_fetch_row(Mysql_Query($sql));

$sql2 = "SELECT last_pcs,last_total from fuel_tank where fuel = '".$_POST["fuel"]."' order by bill desc  limit 1  ";
list($last_pcs,$last_total) = Mysql_fetch_row(Mysql_Query($sql2));

$mr = substr($bill,5,2);
if(str_pad($mr,2,'0',STR_PAD_LEFT)!=date("m")){
  $nobill="REV".(date("y")+43).date("m")."001";
}else{
  echo $nobill="REV".(date("y")+43).date("m").str_pad(substr($bill,7,3)+1, 3,'0',STR_PAD_LEFT);
}

switch($_POST["fuel"])
{
case "91": $fuel_name = "น้ำมัน 91"; break;
case "95": $fuel_name = "น้ำมัน 95"; break;
case "diesel": $fuel_name = "น้ำมัน ดีเซล"; break;
case "brake": $fuel_name = "น้ำมัน เบรค"; break;
case "engine": $fuel_name = "น้ำมัน เครื่อง"; break;
case "oilmix": $fuel_name = "น้ำมัน ผสม"; break;
case "water": $fuel_name = "น้ำกลั่น"; break;
}


$strSQL = "INSERT INTO fuel_tank SET ";
$strSQL .="dateday = '".$_POST["dateday"]."' ";
$strSQL .=",fuel = '".$_POST["fuel"]."' ";
$strSQL .=",fuel_name = '".$fuel_name."' ";
$strSQL .=",last_pcs = '".$last_pcs."' ";
$strSQL .=",last_total = '".$last_total."' ";
$strSQL .=",bill = '".$nobill."' ";
$strSQL .=",theorder = '".$_POST["theorder"]."' ";
$strSQL .=",pcs = '".$_POST["pcs"]."' ";
$strSQL .=",total = '".$_POST["total"]."' ";
$objQuery = mysql_query($strSQL);

}else if($_POST["submit"]=="addolp"){

$sql = "SELECT bill from fuel_tank where bill like 'OLP%' order by bill desc  limit 1  ";
list($bill) = Mysql_fetch_row(Mysql_Query($sql));

$sql2 = "SELECT last_pcs,last_total from fuel_tank where fuel = '".$_POST["fuel"]."' order by bill desc  limit 1  ";
list($last_pcs,$last_total) = Mysql_fetch_row(Mysql_Query($sql2));

$mr = substr($bill,5,2);
if(str_pad($mr,2,'0',STR_PAD_LEFT)!=date("m")){
  $nobill="OLP".(date("y")+43).date("m")."001";
}else{
  echo $nobill="OLP".(date("y")+43).date("m").str_pad(substr($bill,7,3)+1, 3,'0',STR_PAD_LEFT);
}

switch($_POST["fuel"])
{
case "91": $fuel_name = "น้ำมัน 91"; break;
case "95": $fuel_name = "น้ำมัน 95"; break;
case "diesel": $fuel_name = "น้ำมัน ดีเซล"; break;
case "brake": $fuel_name = "น้ำมัน เบรค"; break;
case "engine": $fuel_name = "น้ำมัน เครื่อง"; break;
case "oilmix": $fuel_name = "น้ำมัน ผสม"; break;
case "water": $fuel_name = "น้ำกลั่น"; break;
}


$strSQL = "INSERT INTO fuel_tank SET ";
$strSQL .="dateday = '".$_POST["dateday"]."' ";
$strSQL .=",fuel = '".$_POST["fuel"]."' ";
$strSQL .=",fuel_name = '".$fuel_name."' ";
$strSQL .=",last_pcs = '".$last_pcs."' ";
$strSQL .=",last_total = '".$last_total."' ";
$strSQL .=",bill = '".$nobill."' ";
$strSQL .=",theorder = '".$_POST["theorder"]."' ";
$strSQL .=",pcs = '".$_POST["pcs"]."' ";
$strSQL .=",total = '".$_POST["total"]."' ";
$objQuery = mysql_query($strSQL);

}

?>
