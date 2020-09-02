<?
session_start();
include("connect.inc");

if($_GET["submit"]=="return_menu"){
$sql = "SELECT menu_code from user_account where username = '".$_SESSION["xusername"]."'  limit 1  ";
list($menu_code) = Mysql_fetch_row(Mysql_Query($sql));
$cmenu=explode(",",$menu_code); 

$gx=array("");
for($t=1;$t<=count($cmenu);$t++){

 $menu1 = "SELECT menu_group FROM menu_lst where row_id = '".$cmenu[$t]."' AND status = '1'  ";
 $result = mysql_query($menu1);
//$num = mysql_num_rows($result);
 list($menu_group) = Mysql_fetch_row($result);
//echo $menu_group; 
 if(array_search($menu_group,$cmenu)){
 array_push($gx, $menu_group);
 }

 }


$sql = "SELECT * from menu_lst where menu_group = '".$_GET["menu_group"]."' AND status = '1' ORDER By menu_position ASC";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {


if(array_search($row[row_id], $cmenu)){


            if($row["row_id"]==43){

            $stre = "SELECT * FROM tbl_warehousetime";
            $resulte = mysql_query($stre);
            while ($datae = mysql_fetch_assoc($resulte)){
              if($datae[row]==date(w) && $datae[status]==1){
             echo "<div class='col-lg-4' style='padding-top:15px;padding-button:15px;' onclick=\"window.open('$row[menu_link]','_blank')\"><span class='btn btn-default' style='height:150px;width:100%;'><span class='fa fa-tv' style='font-size:100px;margin-top:10px;'></span> <br>$row[menu_name]</span></div>";
            }else if($datae[row]==8 && $datae[status]==1){
            if(date("Y-m-d")>=$datae[date1] && date("Y-m-d")<=$datae[date2]){
             echo "<div class='col-lg-4' style='padding-top:15px;padding-button:15px;' onclick=\"window.open('$row[menu_link]','_blank')\"><span class='btn btn-default' style='height:150px;width:100%;'><span class='fa fa-tv' style='font-size:100px;margin-top:10px;'></span> <br>$row[menu_name]</span></div>";
            }

          }
}
            }else{
             echo "<div class='col-lg-4' style='padding-top:15px;padding-button:15px;' onclick=\"window.open('$row[menu_link]','_blank')\"><span class='btn btn-default' style='height:150px;width:100%;'><span class='fa fa-tv' style='font-size:100px;margin-top:10px;'></span> <br>$row[menu_name]</span></div>";
          }

	
 
}
}

}

?>