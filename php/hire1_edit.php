<?
session_start();
//include("../login_menu.php");
include("connect.inc");
//include("hospital.inc");

$sql = "SELECT * from tbl_company ";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {
$hp[$row["tbl_title"]]=$row["tbl_value"];

}

if($hp[phone]){
    $hp[phone]= " โทรศัพท์ ".$hp[phone];
}
$company_full = $hp[company_name].$hp[address].$hp[phone];
$company=$hp[company_name];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>.::Ware House::.</title>
         <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
        <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
        <script type="text/javascript" src="../js/dropdown_hire.js"></script>
        <style type="text/css">
     @import url(../fonts/thsarabunnew.css);
    body{
   font-family: 'THSarabunNew', tahoma;
   font-weight: bold;
    min-height:100%;
    overflow:auto;

}
        .td_border{
        border:1px solid #999;
    }
    .top_bar{
        border:1px solid #999;
        background-color: rgba(0,0,0,0.3);
    }
        .link_data:hover{
        background-color: rgba(255,0,0,0.3);
        cursor: pointer;
    }
        .layer-body{
            position: relative;
            border-radius: 10px;
            width:1200px;
            height:700px auto;
            margin: 0px auto;
            background-color:#ffffff; 
            
        }
        .layer-contact{
            position: relative;
            width:768px;
            height:100px auto;
            margin: 0px auto;
            background-color:rgba(255,255,255,0.6); 
        }
 .buttonmenu {
    -moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
    -webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
    box-shadow:inset 0px 1px 0px 0px #ffffff;
    background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #dfdfdf));
    background:-moz-linear-gradient(top, #ededed 5%, #dfdfdf 100%);
    background:-webkit-linear-gradient(top, #ededed 5%, #dfdfdf 100%);
    background:-o-linear-gradient(top, #ededed 5%, #dfdfdf 100%);
    background:-ms-linear-gradient(top, #ededed 5%, #dfdfdf 100%);
    background:linear-gradient(to bottom, #ededed 5%, #dfdfdf 100%);
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf',GradientType=0);
    background-color:#ededed;
    border:1px solid #dcdcdc;
    display:inline-block;
    cursor:pointer;
    color:#444444;
    font-family: 'THSarabunNew', tahoma;
    font-weight:bold;
    /*padding:10px;*/
    width: 250px;
    height:100px;
    text-decoration:none;
    /*text-align:center;*/
    /*text-shadow:0px 1px 0px #ffffff;*/
position:relative;
}

.buttonmenu:hover {
    background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed));
    background:-moz-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
    background:-webkit-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
    background:-o-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
    background:-ms-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
    background:linear-gradient(to bottom, #dfdfdf 5%, #ededed 100%);
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed',GradientType=0);
    background-color:#dfdfdf;

}
.buttonmenu:active {
    background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed));
    background:-moz-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
    background:-webkit-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
    background:-o-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
    background:-ms-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
    background:linear-gradient(to bottom, #dfdfdf 5%, #ededed 100%);
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed',GradientType=0);
    background-color:#dfdfdf;
}
.div_menu 
{

color: rgb(97, 97, 97);
font-size: 50px;
/*background-color: rgb(233, 233, 233);
border:1px solid #dcdcdc;*/
text-shadow: rgb(224, 224, 224) 1px 1px 0px;
text-align: center;
}
input[type="text"]{
    font-family: 'THSarabunNew', tahoma;
    border:0px solid #000;
    /*border-bottom: 1px dashed #000;*/
    text-align: center;
    font-size: 16px;
    font-weight: bold;
    background-color: rgba(100,255,0,0.3);

}
table{
    border-collapse: collapse;
}
textarea{
    font-family: 'THSarabunNew', tahoma;
    font-size: 14px;
    border:0px solid #999;
    text-align:center;
    background-color: rgba(100,255,0,0.3);
}
    #ceo_list,#procurement_officer_list,#cmt_1_list,#cmt_2_list,#cmt_3_list,#cmt_4_list,#cob_list{
    position: absolute;
    margin: 0px auto;
    z-index: 5;
}
      </style>
      <script type="text/javascript">
      //ป้องกัน Enter
document.onkeydown = chkEvent 
function chkEvent(e) {
  var keycode;
  if (window.event) keycode = window.event.keyCode; //*** for IE ***//
  else if (e) keycode = e.which; //*** for Firefox ***//
  if(keycode==13)
  {
    return false;
  }
}

function addCommas(nStr)
      {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
      }

function click_dropdown(tx,rx){
    document.getElementById(""+tx).value = rx;
}
function click_2dropdown(tx,rx,px,ex){
    document.getElementById(""+tx).value = rx;

    if(px=="ceo_po"){
       $.ajax({
    type: "POST",
    url: "return_cmt_3.php",
    data: "ceo_po="+ex,
    cache: false,
    success: function(html)
    {
    //$("#cmt_3_list").html(html);
    var x1 = html.indexOf("<span>");
    var x2 = html.indexOf("</span>");
    var x3 = html.substring((x1+6),x2);
    document.getElementById(""+px).innerHTML = x3;  
    }
    });

    
    }else{
    document.getElementById(""+px).value = ex;    
    }
}

function getSum(total, num) {
    return total + num;
}

function division_pats(rx){
    document.getElementById("division").value=rx;
}
function search_detail(dx){
    $("#popup_detail").show();
    $("#focus_row").val(dx);
    // var left = (screen.width/2)-(1200/2);
    // var top = (screen.height/2)-(600/2);
    // window.open("return_detail.php?row="+dx,"_blank","toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=1200,height=600");
}

function next_td(nx,ix){
   var keycode;
  if (window.event) keycode = window.event.keyCode; //*** for IE ***//
  else if (e) keycode = e.which; //*** for Firefox ***//
  if(keycode==13)
  {
    document.getElementById(""+nx).focus();
  }
  var px = document.getElementById("pcs"+ix).value;
  var pc = document.getElementById("price"+ix).value;

  document.getElementById("total"+ix).value= addCommas((px*pc).toFixed(2)) ;
    totals();
}

function totals(){

  var t2 = 0;
  for(i=1;i<=20;i++){
  var t1 = parseFloat(document.getElementById("total"+i).value.replace(",",""));if ( isNaN(t1)){t1 = 0;}
  t2 = t2+t1;
  }
  document.getElementById("sumtotal").innerHTML = addCommas((t2).toFixed(2));
}




      </script>
    </head>
    <body>
    <div class="layer-body" style="margin-top:-30px;padding-bottom:20px;">
    <div class="layer-contact">
    <div style="position:absolute;left:12px;top:20px;z-index:5;"><img src="../images/thai_government.png" width="60px"></div>
    <br>
    <form name="b1" method="POST" action="">
    <?
    if($_GET["ordernumber"]){
    $sql = "SELECT department,dateday from hire where order_number = '".$_GET["ordernumber"]."' limit 1  ";
    list($nameltd,$dateday) = Mysql_fetch_row(Mysql_Query($sql));
    }
    ?>
    <table width="100%">
       <td colspan="10" style="text-align: center;"><?=$hp[fullname]." ".$hp[shotaddress]?></td> <tr>
       <td colspan="10" style="text-align: center;">ใบสั่งซื้อ/จ้าง</td> <tr>
       <td colspan="10" style="text-align: center;">เรียน  <input type="text" name="department" value="<?=$nameltd?>" style="width:300px;" ></td> <tr>
       <td colspan="10" style="text-align: center;"><?=$hp[fullname]." ".$hp[shotaddress]?> ขอซื้อ/จ้าง ตามรายการต่อไปนี้.</td><tr>
        </table>
        <table width="800px">
        <tr style="text-align:center;">
        <td rowspan="2" style="border:1px solid #999;width:40px;font-size:14px;">ลำดับ</td>
        <td rowspan="2" style="border:1px solid #999;width:250px;font-size:14px;">รายการ</td>
        <td rowspan="2" style="border:1px solid #999;width:50px;font-size:14px;">ราคา<br>หน่วยละ</td>
        <td rowspan="2" style="border:1px solid #999;width:50px;font-size:14px;">จำนวน<br>สิ่งของ</td>
        <td rowspan="2" style="border:1px solid #999;width:70px;font-size:14px;">หน่วยนับ</td>
        <td colspan="2" style="border:1px solid #999;width:150px;font-size:14px;">จำนวนเงิน</td>
        <td rowspan="2" style="border:1px solid #999;width:100px;font-size:14px;width:100px;">หมายเหตุ</td> <tr>
        <td colspan="2" style="text-align:center;border:1px solid #999;font-size:14px;width:125px;">บาท</td>
<?
if($_GET["ordernumber"]){

$sql = "SELECT * from hire where order_number = '".$_GET["ordernumber"]."'  ORDER By numrow  ASC";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {
$e++;
 print "<tr>
        <td style='text-align:center;border:1px solid #999;'><input type='text' name='row$e' id='row$e' value='$row[numrow]' style='width:100%;'></td>
        <td style='text-align:center;border:1px solid #999;'><input type='hidden' name='barcode$e' id='barcode$e' value='$row[barcode]'><input type='text' name='detail$e' id='detail$e' value='$row[detail]' style='width:100%;text-align:left;' ></td>
        <td style='text-align:center;border:1px solid #999;'><input type='text' name='price$e' id='price$e' value='$row[price]' style='width:100%;'></td>
        <td style='text-align:center;border:1px solid #999;'><input type='text' name='pcs$e' id='pcs$e' value='$row[pcs]' style='width:100%;' onkeyup='next_td('other$e','$e')'>
        </td>
        <td style='text-align:center;border:1px solid #999;'><input type='text' name='unit$e' id='unit$e' style='width:100%;' value='$row[unit]'></td>
        <td colspan='2' style='text-align:center;border:1px solid #999;'><input type='text' name='total$e' id='total$e' style='width:100%;' value='".number_format($row[total],2)."'></td>
        <td style='text-align:center;border:1px solid #999;'><input type='text' name='other$e' id='other$e' value='$row[other]' style='width:100%;'></td>";
$sumtotal=$sumtotal+$row[total_price];
}


}

for($i=($e+1);$i<=20;$i++){

    ?>
        <tr>
        <td style="text-align:center;border:1px solid #999;"><input type="text" name="row<?=$i?>" id="row<?=$i?>"  style="width:100%;"></td>
        <td style="text-align:center;border:1px solid #999;"><input type="hidden" name="barcode<?=$i?>" id="barcode<?=$i?>"><input type="text" name="detail<?=$i?>" id="detail<?=$i?>" style="width:90%;text-align:left;" readonly><img src="../images/menu/search.png" width="10%" style="cursor:pointer;" onclick="search_detail(<?=$i?>)"></td>
        <td style="text-align:center;border:1px solid #999;"><input type="text" name="price<?=$i?>" id="price<?=$i?>" style="width:100%;"></td>
        <td style="text-align:center;border:1px solid #999;"><input type="text" name="pcs<?=$i?>" id="pcs<?=$i?>" style="width:100%;" onkeyup="next_td('other<?=$i?>','<?=$i?>')">
        </td>
        <td style="text-align:center;border:1px solid #999;"><input type="text" name="unit<?=$i?>" id="unit<?=$i?>" style="width:100%;"></td>
        <td colspan="2" style="text-align:center;border:1px solid #999;"><input type="text" name="total<?=$i?>" id="total<?=$i?>" style="width:100%;"></td>
        <td style="text-align:center;border:1px solid #999;"><input type="text" name="other<?=$i?>" id="other<?=$i?>" style="width:100%;"></td>
<?}?> 

        <tr>
        <td colspan="2">
        การสั่งซื้อ/จ้าง อยู่ภายใต้เงื่อนไขดังต่อไปนี้
        </td>
        <td style="border:1px solid #999;"></td>
        <td style="border:1px solid #999;"></td>
        <td style="border:1px solid #999;"></td>
        <td style="border:1px solid #999;text-align: right;" colspan="2"> <span id="sumtotal"><?if($sumtotal){ echo number_format($sumtotal,2);}else{ echo "0.00";}?></span>&nbsp;&nbsp;</td>
        <td style="border:1px solid #999;"></td>
        <tr>
        <td colspan="4">
            1. กำหนดส่งมอบภายใน<input type="text" name="exdate" style="width:60px;" value="30">วันทำการ</td><tr>
        <td colspan="4">
            2. สถานที่ส่งมอบ<input type="text" name="book_mark" style="width:180px;" value="<?=$company?>">
        </td><td colspan="6">ตัวอักษร </td><tr>
        <td colspan="4">
            3. ระยะเวลารับประกัน<input type="text" name="date_license" style="width:70px;">เดือน
        </td><td colspan="6">(ลงชื่อ)..........................................ผู้สั่งซื้อ/จ้าง </td><tr>
        <td colspan="4">
            4. สงวนสิทธิค่าปรับกรณีส่งมอบเกินกำหนดเวลาโดย
        </td><td colspan="6">(ลงชื่อ)..........................................ผู้รับใบสั่ง </td><tr>
        <td colspan="4">
        &nbsp;&nbsp;&nbsp;&nbsp;ปรับรายวันดังนี้
        </td><td colspan="6">วันที่ <input type="text" name="dateday" id="dateday" value="<?=substr($dateday,8,2)."/".substr($dateday,5,2)."/".substr($dateday,0,4)?>"></td><tr>
        <td colspan="4">
        &nbsp;&nbsp;&nbsp;&nbsp;- ซื้อ/จ้างในอัตราร้อยะ 0.01 - 0.20 ของราคาพัสดุที่ยังไม่ได้รับมอบ
        </td><tr>
        <td colspan="4">
        &nbsp;&nbsp;&nbsp;&nbsp;- จึงเรียนมาเพื่อโปรดพิจาณณาอนุมัติ
        </td><tr>
        <td colspan="4">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ไม่ต่ำกว่าวันละ 100 บาท
        </td><tr>

        <tr>
        <td style="height:20px;text-align:center;" colspan="8"><input type="submit" name="submit" value="ตกลง" style="padding:0px 40px;font-size:16px;font-family:THsarabunnew;font-weight: bold;cursor:pointer;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onclick="window.location='index.php'" style="padding:0px 30px;background-color:#e0e0e0;border:1px solid #999;cursor:pointer;" >ย้อนกลับ</span></td><tr>
    </table>
    </form>
     </div>    
     </div>
          <center><span style="color:#666;font-size:14px;"><?=$hp[licen]?></span></center>
    </body>
</html>
        <script type="text/javascript" src="../js/datepickr.js"></script>
        <link type="text/css" href="../css/datepickr.css" rel="stylesheet" /> 
        <script type="text/javascript">
            new datepickr('dateday', {'dateFormat': 'd/m/Y'});
            

         function search_product(ex){
            $("#show_product thead tr").remove();
            var td ="<tr>";
                td = td + "<td style='text-align:center;height:40px;' class='top_bar'>#</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>Barcode</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>รายการ</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>ราคา</td>";
                td = td + "</tr>";
            $('#show_product > thead:last').append(td);


      $.ajax({ 
                url: "return_detail.php" ,
                type: "POST",
                data: 'xTable=search_product&data='+ex,
            })
            .success(function(result) { 
                var obj = jQuery.parseJSON(result);
                    if(obj != '')
                    {
                          //$("#myTable tbody tr:not(:first-child)").remove();
                          $("#show_product tbody tr").remove();
                          var r=0;
                          $.each(obj, function(key, val) {
                            r++;
                            
                                   var tr = "<tr class='link_data' onclick=\"return_code('"+val["barcode"]+"','"+val["detail"]+"','"+val["unit"]+"','"+val["price_in"]+"')\">";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+r+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+val["barcode"]+"</td>";
                                    tr = tr +  "<td style='text-align:left;' class='td_border'>&nbsp;&nbsp;"+val["detail"]+"</td>";
                                    tr = tr +  "<td style='text-align:right;' class='td_border'>"+val["price_in"]+"/"+val["unit"]+"&nbsp;&nbsp;</td>";
                                    tr = tr + "</tr>";
                                    $('#show_product > tbody:last').append(tr);
                          });
                    }

            });

         }   
        function return_code(barcode,detail,unit,price){
            var row = $("#focus_row").val();
            $("#row"+row).val(row);
            $("#barcode"+row).val(barcode);
            $("#detail"+row).val(detail);
            $("#unit"+row).val(unit);
            $("#price"+row).val(price);
            $("#popup_detail").hide();
            $("#pcs"+row).focus();
        }
        function add_product(){
            $("#show_product thead tr").remove();
            $("#show_product tbody tr").remove();
            var addpro = $("#new_product").html();
            $('#show_product > tbody:last').append(addpro);
        }

        function add_p2(){
        var tx1=document.getElementById("type_product").value;
        var px1=document.getElementById("plus").value;
        var dx1=document.getElementById("detail_add").value;
        var ux1=document.getElementById("unit_add").value;


    $.ajax({
    type: "POST",
    url: "add_product_json.php",
    data: "type_product="+tx1+"&plus="+px1+"&detail_add="+dx1+"&unit_add="+ux1,
    cache: false,
    success: function(html)
    {
            var row = $("#focus_row").val();
            $("#row"+row).val(row);
            $("#barcode"+row).val(html);
            $("#detail"+row).val(dx1);
            $("#unit"+row).val(ux1);
            $("#popup_detail").hide();
            $("#pcs"+row).focus();
    }
    });


    }

    function type_p(rx){
        if(rx=="add"){
            document.getElementById("add_plus").style.display='';
            document.getElementById("plus").style.borderColor="red";
            document.getElementById("plus").focus();
        }
    }
       </script>
<div id="popup_detail" style="display:none;position:fixed;z-index:5;top:10%;left:10%;width: 80%;height:80%;border:1px solid #e0e0e0;border-radius: 5px;box-shadow: 5px 5px 5px rgba(0,0,0,0.3);background-color: #ffffff;">

<fieldset><legend style='font-size:24px;'>.::ค้นหาสินค้า::.</legend>
<form name="B1" method="POST" action="">
    <table width="100%">
        <td>ค้นหา</td><td><input type="text" name="search" autofocus onkeyup="search_product(this.value)"><input type='hidden' name='focus_row' id='focus_row'></td>
        <td align="left"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:blue;font-size:12px;font-weight:bold;cursor:pointer;' onclick='add_product()'>เพิ่มพัสดุใหม่</span></td>
        <td style="width:70%;text-align: right;">
        <img src="../images/box_close.png" style='cursor: pointer;z-index:6;position: absolute;margin-left: -12px;margin-top: -48px;' onclick='$("#popup_detail").hide();'>
       </td>
    </table>
</form>
</fieldset>
<div style="width:100%;height:72%;overflow: auto;">
<table id="show_product" style='margin: 0px auto;width:70%;'>
    <thead>

    </thead>
    <tbody>
        
    </tbody>
</table>
</div>

</div>

        
            <div id="new_product" style="display: none;">
            <table style="margin:0px auto;">
            <td colspan="2" style="font-size:36px;background-color:#96ceb4;text-align:center;font-weight:bold;color:#fff;">เพิ่มสินค้า</td><tr>
            <td style="height:50px;">ประเภท</td><td>
            <select name="type_product" id="type_product" onchange="type_p(this.value)">
            <?
            $sql = "select * from type_product ORDER By row_id ASC  ";
            $result = mysql_query($sql);
            while ($row = mysql_fetch_array($result) ) {
                print "<option value='$row[row_id]'>$row[name]</option>";
                }
            ?>
                <option value="add">เพิ่ม++</option>
            </select>
            </td><tr>
            <td></td><td>
            <div id="add_plus" style="display:none;"><input type='text' name='plus' id='plus' ></div>
            </td><tr>
            <td style="height:50px;">สินค้า</td><td><input type="text" name="detail_add" id="detail_add"></td><tr>
            <td style="height:50px;">หน่วยนับ</td><td><input type="text" name="unit_add" id="unit_add"></td><tr>
            <td style="height:50px;" colspan="2" align="center"><button onclick="add_p2()">เพิ่ม</button></td>
            </table>
            </div>
<?
//print $_POST["row"];
//echo substr_count($_POST["row"],"/n");
//print "<br>";
//print nl2br($_POST["row"]);

//$row_enter=substr_count($_POST["row"],"\n");
//print_r($_POST);

function extract_text($str){

  $nu='0123456789';
  $cx=strlen($str);
  $newStr='';
  for($te=0;$te<$cx;$te++){
    if(substr_count($nu,substr($str,$te,1))==0) {
     $newStr.=substr($str,$te,1);
    }
  }
  return $newStr;
}

function extract_int($str){

  $nu='0123456789';
  $cx=strlen($str);
  $newStr='';
  for($te=0;$te<$cx;$te++){
    if(substr_count($nu,substr($str,$te,1))) {
      $newStr.=substr($str,$te,1);
    }
  }
  return $newStr;
}


if($_POST["submit"]=="ตกลง" && $_POST["department"]!=''){

// $sql = "SELECT order_number from hire ORDER By order_number DESC ";
// list($order_number) = Mysql_fetch_row(Mysql_Query($sql));
// $order_number++;

$sql = "SELECT theorderno from hire where order_number='".$_GET["ordernumber"]."' limit 1 ";
list($oldtheorderno) = Mysql_fetch_row(Mysql_Query($sql));


  $sql_del = "DELETE FROM hire WHERE order_number='".$_GET["ordernumber"]."' ";
  $query = mysql_query($sql_del);


for($r=1;$r<=20;$r++){

if($_POST["detail$r"]){
$strSQL = "INSERT INTO hire SET ";
$strSQL.="order_number='".$_GET["ordernumber"]."'";
$strSQL.=",department='".$_POST["department"]."'";
$strSQL.=",book_mark='".$_POST["book_mark"]."'";
$strSQL.=",dateday='".substr($_POST["dateday"],6,4)."/".substr($_POST["dateday"],3,2)."/".substr($_POST["dateday"],0,2)."'";
$strSQL.=",date_license='".$_POST["date_license"]."'";
$strSQL.=",numrow='".$_POST["row$r"]."'";
$strSQL.=",barcode='".$_POST["barcode$r"]."'";
$strSQL.=",detail='".$_POST["detail$r"]."'";
$strSQL.=",unit='".extract_text($_POST["unit$r"])."'";
$strSQL.=",price_last='".$_POST["price_last$r"]."'";
$strSQL.=",price='".$_POST["price$r"]."'";
$strSQL.=",pcs='".str_ireplace(",","",$_POST["pcs$r"])."'";
$strSQL.=",total='".str_ireplace(",","",$_POST["total$r"])."'";
$strSQL.=",other='".$_POST["other$r"]."'";
$strSQL.=",exdate='".$_POST["exdate"]."'";
$strSQL.=",timelast='".date("d/m/Y H:i:s")."'";
$strSQL.=",status='W'";
$strSQL.=",officer='".$_SESSION[xUser]."'";
$strSQL.=",theorderno='".$oldtheorderno."'";
$objQuery = mysql_query($strSQL) or die(mysql_error());

}
}


if($objQuery){
 echo ("<script> alert('บันทึกเรียบร้อยแล้ว!!!'); window.location='hire1_print.php?ordernumber=".$_GET["ordernumber"]."'</script>");
}

}

?>