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



if($_GET["row_id"]){
//     $ordernumber=$_GET["ordernumber"];
  $strSQL = "SELECT * FROM  tbl_order_head where row_id = '".$_GET["row_id"]."'   ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = "";
  $arrCol = "";
  while($obResult = mysql_fetch_array($objQuery))
  {
    for($i=1;$i<$intNumField;$i++)
    {
      //$resultArray = mysql_field_name($objQuery,$i);
     
      if(mysql_field_name($objQuery,$i)=="dateday"){
        $arrCol[dateday]= date_format(date_create($obResult[$i]),"d/m/Y");
      }else if(mysql_field_name($objQuery,$i)=="date_pass2"){
        $arrCol[date_pass2]= date_format(date_create($obResult[$i]),"d/m/Y");
      }else{
         $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
      }
      
    }

}

//         $sql = "SELECT barcode,pcs FROM  hire where order_number = '$ordernumber' AND status='W' ORDER By numrow ASC";
//         $result = mysql_query($sql);
//         $pcs_total = mysql_num_rows($result);
//         while ($row = mysql_fetch_array($result) ) {
//         $sql_barcode = "select price_in from stock_product where barcode = '".$row[barcode]."'  limit 1  ";
//         list($price_in) = Mysql_fetch_row(Mysql_Query($sql_barcode));
//         $rx_price=$rx_price+($row[pcs]*$price_in);
//         }

// $sqlx = "SELECT order_number from hire ORDER By order_number DESC ";
// list($order_number) = Mysql_fetch_row(Mysql_Query($sqlx));

// $order_number-1;



}

function num2wordsThai($num){   
   $num=str_replace(",","",$num);
   $num_decimal=explode(".",$num);
   $num=$num_decimal[0];
    $returnNumWord;   
    $lenNumber=strlen($num);   
    $lenNumber2=$lenNumber-1;   
    $kaGroup=array("","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน");   
    $kaDigit=array("","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ด","แปด","เก้า");   
    $kaDigitDecimal=array("ศูนย์","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ด","แปด","เก้า");   
    $ii=0;   
    for($i=$lenNumber2;$i>=0;$i--){   
        $kaNumWord[$i]=substr($num,$ii,1);   
        $ii++;   
    }   
    $ii=0;   
    for($i=$lenNumber2;$i>=0;$i--){   
        if(($kaNumWord[$i]==2 && $i==1) || ($kaNumWord[$i]==2 && $i==7)){   
            $kaDigit[$kaNumWord[$i]]="ยี่";   
        }else{   
            if($kaNumWord[$i]==2){   
                $kaDigit[$kaNumWord[$i]]="สอง";        
            }   
            if(($kaNumWord[$i]==1 && $i<=2 && $i==0) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==6)){   
                if($kaNumWord[$i+1]==0){   
                    $kaDigit[$kaNumWord[$i]]="หนึ่ง";      
                }else{   
                    $kaDigit[$kaNumWord[$i]]="เอ็ด";       
                }   
            }elseif(($kaNumWord[$i]==1 && $i<=2 && $i==1) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==7)){   
                $kaDigit[$kaNumWord[$i]]="";   
            }else{   
                if($kaNumWord[$i]==1){   
                    $kaDigit[$kaNumWord[$i]]="หนึ่ง";   
                }   
            }   
        }   
        if($kaNumWord[$i]==0){   
         if($i!=6){
               $kaGroup[$i]="";   
         }
        }   
        $kaNumWord[$i]=substr($num,$ii,1);   
        $ii++;   
        $returnNumWord.=$kaDigit[$kaNumWord[$i]].$kaGroup[$i];   
    }      
   if(isset($num_decimal[1]) && $num_decimal[1]!=0){
      $returnNumWord.="บาท";
      for($i=0;$i<strlen($num_decimal[1]);$i++){
            $returnNumWord.=$kaDigitDecimal[substr($num_decimal[1],$i,1)];   
      }
            $returnNumWord.="สตางค์";
   }else{
            $returnNumWord.="บาทถ้วน";
   }      
    return $returnNumWord;   
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>.::Ware House::.</title>

        <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
        <script type="text/javascript" src="../js/dropdown_hire.js"></script>
        <style type="text/css">
        @import url(../fonts/thsarabunnew.css);
        body{
    min-height:100%;
    overflow:auto;
   /* background:#0096ff;*/
    font-family: 'THSarabunNew',tahoma;
    font-size:14px;
   /* background-image: url("https://s-media-cache-ak0.pinimg.com/736x/5d/5d/79/5d5d79ab40f17440b11dfdf9cd0f1f08.jpg");*/
   	/*background: -webkit-linear-gradient(180deg, #8b5eb5,#f3eafd, #fff); *//* For Safari 5.1 to 6.0 */
    /*background: -o-linear-gradient(180deg, #8b5eb5,#f3eafd, #fff);*/ /* For Opera 11.1 to 12.0 */
    /*background: -moz-linear-gradient(180deg, #8b5eb5,#f3eafd, #fff);*/ /* For Firefox 3.6 to 15 */
    /*background: linear-gradient(180deg, #8b5eb5,#f3eafd, #fff);*/ /* Standard syntax (must be last) */
    /*background-repeat: no-repeat;*/
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
            width:880px;
            height:700px auto;
            margin: 0px auto;
            background-color:#ffffff; 
            box-shadow: 4px 4px 15px #aaa;
        }
        .layer-contact{
            position: relative;
            width:830px;
            height:100px auto;
            margin: 0px auto;
            background-color:rgba(255,255,255,0.6); 
        }
        .bt_green{width:120px;cursor: pointer;
border:1px solid #8bcf54; -webkit-border-radius: 3px; -moz-border-radius: 3px;border-radius: 3px;font-size:12px;font-family:arial, helvetica, sans-serif; padding: 10px 10px 10px 10px; text-decoration:none; display:inline-block;

font-weight:bold;
color: #444444;
 background-color: #a9db80; background-image: -webkit-gradient(linear, left top, left bottom, from(#a9db80), to(#96c56f));
 background-image: -webkit-linear-gradient(top, #a9db80, #96c56f);
 background-image: -moz-linear-gradient(top, #a9db80, #96c56f);
 background-image: -ms-linear-gradient(top, #a9db80, #96c56f);
 background-image: -o-linear-gradient(top, #a9db80, #96c56f);
 background-image: linear-gradient(to bottom, #a9db80, #96c56f);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#a9db80, endColorstr=#96c56f);
}

.bt_green:hover{
 border:1px solid #74bf36;
 background-color: #8ed058; background-image: -webkit-gradient(linear, left top, left bottom, from(#8ed058), to(#7bb64b));
 background-image: -webkit-linear-gradient(top, #8ed058, #7bb64b);
 background-image: -moz-linear-gradient(top, #8ed058, #7bb64b);
 background-image: -ms-linear-gradient(top, #8ed058, #7bb64b);
 background-image: -o-linear-gradient(top, #8ed058, #7bb64b);
 background-image: linear-gradient(to bottom, #8ed058, #7bb64b);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#8ed058, endColorstr=#7bb64b);
}
.bt_blue{
    width:120px;cursor: pointer;
border:1px solid #15aeec; -webkit-border-radius: 3px; -moz-border-radius: 3px;border-radius: 3px;font-size:12px;font-family:arial, helvetica, sans-serif; padding: 10px 10px 10px 10px; text-decoration:none; display:inline-block;font-weight:bold; color: #444444;
 background-color: #49c0f0; background-image: -webkit-gradient(linear, left top, left bottom, from(#49c0f0), to(#2CAFE3));
 background-image: -webkit-linear-gradient(top, #49c0f0, #2CAFE3);
 background-image: -moz-linear-gradient(top, #49c0f0, #2CAFE3);
 background-image: -ms-linear-gradient(top, #49c0f0, #2CAFE3);
 background-image: -o-linear-gradient(top, #49c0f0, #2CAFE3);
 background-image: linear-gradient(to bottom, #49c0f0, #2CAFE3);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#49c0f0, endColorstr=#2CAFE3);
}

.bt_blue:hover{
 border:1px solid #1090c3;
 background-color: #1ab0ec; background-image: -webkit-gradient(linear, left top, left bottom, from(#1ab0ec), to(#1a92c2));
 background-image: -webkit-linear-gradient(top, #1ab0ec, #1a92c2);
 background-image: -moz-linear-gradient(top, #1ab0ec, #1a92c2);
 background-image: -ms-linear-gradient(top, #1ab0ec, #1a92c2);
 background-image: -o-linear-gradient(top, #1ab0ec, #1a92c2);
 background-image: linear-gradient(to bottom, #1ab0ec, #1a92c2);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#1ab0ec, endColorstr=#1a92c2);
}

.bt_red {
  -moz-box-shadow:inset 0px 39px 0px -24px #e67a73;
  -webkit-box-shadow:inset 0px 39px 0px -24px #e67a73;
  box-shadow:inset 0px 39px 0px -24px #e67a73;
  background-color:#e4685d;
  -moz-border-radius:4px;
  -webkit-border-radius:4px;
  border-radius:4px;
  border:1px solid #ffffff;
  display:inline-block;
  cursor:pointer;
  color:#ffffff;
  font-family:Arial;
  font-size:15px;
  padding: 10px 10px 10px 10px;
  text-decoration:none;
  text-shadow:0px 1px 0px #b23e35;
}
.bt_red:hover {
  background-color:#eb675e;
}
.bt_red:active {
  position:relative;
  top:1px;
}


input[type="text"]{

    border:0px solid #000;
    /*border-bottom: 1px dashed #000;*/
    text-align: center;
    font-family: 'THSarabunNew',Tahoma;
    font-size: 15px;
    background-color: rgba(100,255,0,0.3);
}
input[type="checkbox"]{
    width:16px;
    height:16px;
    cursor: pointer;
}
table{
    border-collapse: collapse;
}
textarea{
    font-family: 'THSarabunNew',Tahoma;
    border:0px solid #999;
    text-align:center;
    background-color: rgba(100,255,0,0.3);
}

      </style>
      <script type="text/javascript">
       //document.onkeydown = chkEvent
       //function chkEvent(e) {
        // var keycode;
  //if (window.event) keycode = window.event.keyCode; //*** for IE ***//
  //else if (e) keycode = e.which; //*** for Firefox ***//
  //alert(keycode);
  //if(keycode==13)
  //{
  //  return false;
  //}
//}
 function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 

document.onkeypress = stopRKey;


function next_ip(na){
    var keycode;
  if (window.event) keycode = window.event.keyCode; //*** for IE ***//
   else if (e) keycode = e.which; //*** for Firefox ***//
   //alert(na);
    if(keycode==13)
  {
    //return false
    $("input[name="+na+"]").focus();

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
// function chkNum(ele)
//             {
//                 var num = parseFloat(ele.value);
//                 ele.value = addCommas(num.toFixed(2));
//             }
// function click_dropdown(tx,rx){
//     document.getElementById(""+tx).value = rx;
// }
// function click_2dropdown(tx,rx,px,ex){
//     document.getElementById(""+tx).value = rx;
//     document.getElementById(""+px).value = ex;    
// }


function calpcs(rx){
    var px1 = $("input:text[name=pcs"+rx+"]").val();
    var px2 = parseFloat($("input:text[name=use_rate"+rx+"]").val().replace(",",""));if( isNaN(px2)){px2 = 0;}
    var tx =addCommas((px1*px2).toFixed(2));
    $("input:text[name=total_price"+rx+"]").val(tx);

    //var psx1 =  parseFloat(document.getElementById("pcs"+rx).value.replace(",",""));if( isNaN(psx1)){psx1 = 0;}
    //var psx2 =  parseFloat(document.getElementById("price"+rx).value.replace(",",""));if( isNaN(psx2)){psx2 = 0;}
    //document.getElementById("total"+rx).value = psx1*psx2;
    cal_total();

}

function cal_total(){
    var sum_arry=[];
   
    //var x = document.getElementById("show_detail").rows.length-4;
    //alert(x);
    re = document.getElementById("show_detail").rows.length-4;
   var nu = 0;
    for(j=1;j<=re;j++){
            if($("input:text[name=total_price"+j+"]").val()!=""){
                    nu = parseFloat(nu)+1;
            }
    }

    $("#row_detail").val(nu);
    $("#total_pcs").val(nu);


    var rd = $("#row_detail").val();


    for(i=1;i<=rd;i++){
        //var psx1 =  parseFloat(document.getElementById("total_price"+i).value.replace(",",""));if( isNaN(psx1)){psx1 = 0;}
        var psx1 = parseFloat($("input:text[name=total_price"+i+"]").val().replace(",",""));if( isNaN(psx1)){psx1 = 0;}
        sum_arry.push(psx1);
    }

    var total_f =sum_arry.reduce(getSum);
    var fanal_total = addCommas(total_f.toFixed(2));
    document.getElementById("tx_price").innerHTML = fanal_total;
    $("input:text[name=sumtotal]").val(fanal_total);
    //$("input:text[name=money_total]").val(fanal_total);
    numtext(fanal_total);

    // var tx1=parseFloat($("input:text[name=budgets_total]").val().replace(",",""));if( isNaN(tx1)){tx1 = 0;}
    // var tx2=parseFloat($("input:text[name=use_budgets_total]").val().replace(",",""));if( isNaN(tx2)){tx2 = 0;}
    // var ftx=tx1-(total_f+tx2);

    // $("input:text[name=budgets_balance]").val(addCommas(ftx.toFixed(2)));

   // $("input:text[name=textmoney]").val();

    //document.getElementById("tx_price2").innerHTML = num2wordsThai(total_f);
}
function getSum(total, num) {
    return total + num;
}
// function year_bu(ex){
//     var rx=ex.value;
//     document.getElementById("year_budgets").value = rx;
//     document.getElementById("year_budgets2").value = rx;
// }
function dealer(){
    var left = (screen.width/2)-(1200/2);
    var top = (screen.height/2)-(600/2);
    window.open("dealer_search.php","_blank","toolbar=no,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=1200,height=600");
}
function clear_text(rx){
    $("input:text[name=row"+rx+"]").val('');
    $("input:text[name=barcode"+rx+"]").val('');
    $("input:text[name=detail"+rx+"]").val('');
    $("input:text[name=balance_forward"+rx+"]").val('');
    $("input:text[name=use_rate"+rx+"]").val('');
    $("input:text[name=unit"+rx+"]").val('');
    $("input:text[name=pcs"+rx+"]").val('');
    $("input:text[name=price"+rx+"]").val('');
    $("input:text[name=total_price"+rx+"]").val('');
    $("input:text[name=medium_price"+rx+"]").val('');
    $("input:text[name=last_price"+rx+"]").val('');
    var px = $("#total_pcs").val();
    var tpx = px-1;
    $("#total_pcs").val(tpx);
cal_total();
}

function numtext(str){
    
           $.ajax({
            type: "POST",
            url: "return_numtothaitext.php",
            data: "number="+str,
            cache: false,
            success: function(html){
                //$("input:text[name=textmoney]").val(html);   
                $("#textmoney").html(html);            
            }
            });
           $("input[name=total_money]").val(addCommas(str));

}

function detailsearch(ex){
    var de = $("#detail"+ex);
    var position = de.position();
    var wx = de.width();
    var hx = de.height();
    //alert("left: " + position.left + ", top: " + position.top + ", width: " + wx + ", height: " + hx );
    $("#detail_ch").fadeIn();
    $("#detail_ch").css({"left": position.left+"px","top": (position.top+hx)+"px","width": wx+"px"});

            $.ajax({
            type: "POST",
            url: "return_detail.php",
            data: "xTable=search_product&data="+de.val(),
            cache: false,
            success: function(html){
                //$("input:text[name=textmoney]").val(html);   
                //$("#textmoney").html(html); 
               //alert(html);
                $("#detail_ch").empty(); 
        var obj = jQuery.parseJSON(html);
        if(obj!=''){
        $.each(obj, function(key, val) {
                var ux = "<div style='width:"+wx+"px;cursor:pointer;' onmouseover=\"$(this).css({'background-color':'rgba(255,0,0,0.3)'})\" onmouseout=\"$(this).css({'background-color':'#ffffff'})\" onclick=\"click_detail('"+ex+"','"+val["detail"]+"','"+val["unit"]+"','"+val["price_in"]+"','"+val["barcode"]+"');$('#detail_ch').fadeOut();\">";
                ux = ux + "&nbsp;&nbsp;"+val["detail"];
                ux = ux + "</div>";
                 $('#detail_ch').append(ux);
        });
        }    
                        
            }
            });


}

function click_detail(r,de,ux,px,bc){
    $("#row"+r).val(r);
    $("#detail"+r).val(de);
    $("#unit"+r).val(ux);
    $("#use_rate"+r).val(px);
    $("#barcode"+r).val(bc);
    $("#last_price"+r).val(px);
    $("#pcs"+r).focus();

}

function submit_ck(){
    $('input[name=submit]').val('ตกลง');
    document.getElementById("form_order").submit();

}

function addrow(){
        var t = $("#show_detail > tbody:last tr").length+1;
        var tr =  "<tr>";
        tr = tr + "<td style='border:1px solid #000;'><input type='text' name='row"+t+"' id='row"+t+"' style='border:0px solid #000;width:100%;'></td>";
        tr = tr + "<td style='border:1px solid #000;'><input type='hidden' name='barcode"+t+"' id='barcode"+t+"' value='' ><input type='text' name='detail"+t+"' id='detail"+t+"' style='border:0px solid #000;width:100%;' onkeyup=\"detailsearch("+t+");next_ip('pcs"+t+"');\" onfocusout=\"$('#detail_ch').fadeOut();\"></td>";
        tr = tr + "<td style='border:1px solid #000;width:70px;'><input type='text' name='pcs"+t+"' id='pcs"+t+"' style='border:0px solid #000;width:100%;' onkeyup=\"calpcs('"+t+"');next_ip('unit"+t+"');\"></td>";
        tr = tr + "<td style='border:1px solid #000;width:30px;'><input type='text' name='unit"+t+"' id='unit"+t+"' style='border:0px solid #000;width:100%;' onkeyup=\"next_ip('use_rate"+t+"');\"></td>";
        tr = tr + "<td style='border:1px solid #000;'><input type='text' name='use_rate"+t+"' id='use_rate"+t+"' style='border:0px solid #000;width:100%;' onkeyup=\"calpcs('"+t+"');next_ip('total_price"+t+"');$('input:text[name=last_price"+t+"]').val(this.value);\"></td>";
        tr = tr + "<td style='border:1px solid #000;width:80px;'><input type='text' name='total_price"+t+"' style='border:0px solid #000;width:100%;' onkeyup=\"next_ip('medium_price"+t+"');\"></td>";
        tr = tr + "<td style='border:1px solid #000;'><input type='text' name='medium_price"+t+"' style='border:0px solid #000;width:100%;' onkeyup=\"next_ip('last_price"+t+"');\"></td>";
        tr = tr + "<td style='border:1px solid #000;'><input type='text' name='last_price"+t+"' id='last_price"+t+"'style='border:0px solid #000;width:100%;' onkeyup=\"next_ip('balance_forward"+t+"');\"></td>";
        tr = tr + "<td style='border:1px solid #000;'><input type='text' name='balance_forward"+t+"' style='border:0px solid #000;width:100%;'></td>";
        tr = tr + "</tr>";
        $('#show_detail > tbody:last').append(tr);
        $("#row_detail").val(t);
        //$("#total_pcs").val(t);
}


     function search_hire1(ex){
 $("#show_hire thead tr").remove();
            var td ="<tr>";
                td = td + "<td style='text-align:center;height:40px;' class='top_bar'>#</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>วันที่</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>เลขที่</td>";
                 td = td + "<td style='text-align:center;' class='top_bar'>หน่วยงานเบิก</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>ร้านค้า</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>รายการ</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>จำนวน</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>ราคา</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>จำนวนเงิน</td>";
                td = td + "</tr>";
            $('#show_hire > thead:last').append(td);


      $.ajax({ 
                url: "return_detail.php" ,
                type: "POST", 
                data: 'xTable=search_theorder&data='+ex,
            })
            .success(function(result) { 
               // alert(result);
                var obj = jQuery.parseJSON(result);
                    if(obj != '')
                    {
                          //$("#myTable tbody tr:not(:first-child)").remove();
                          $("#show_hire tbody tr").remove();
                          var r=0;
                          $.each(obj, function(key, val) {
                            r++;
                            
                                   var tr = "<tr class='link_data' onclick=\"billoldorder('"+val["row_id"]+"')\">";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+r+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+val["dateday"]+"</td>";
                                     tr = tr +  "<td style='text-align:center;' class='td_border'>"+val["location"]+"/"+val["nobill_location"]+"</td>";
                                    tr = tr +  "<td style='text-align:left;' class='td_border'>&nbsp;&nbsp;"+val["department"]+"</td>";
                                    tr = tr +  "<td style='text-align:left;' class='td_border'>&nbsp;&nbsp;"+val["nameltd"]+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+val["detail"]+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+addCommas(val["pcs"])+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+addCommas(val["use_rate"])+"</td>";
                                    tr = tr +  "<td style='text-align:right;' class='td_border'>"+addCommas(val["total_price"])+"&nbsp;&nbsp;</td>";
                                    tr = tr + "</tr>";
                                    $('#show_hire > tbody:last').append(tr);
                          });
                    }

            });    
        }

                function billoldorder(rd){
            window.location='theorder_V1.php?row_id='+rd;
        }

        function delbill(rd){

              var r = confirm("ต้องการลบ"+$('input[name=location]').val()+"ใช่หรือไม่?");
              if(r==true){
                $.ajax({ 
                url: "return_detail.php" ,
                type: "POST", 
                data: 'xTable=theorder_del&data='+rd,
            })
            .success(function(result) { 
              window.location='theorder_V1.php';
            });
        }
      }
      </script>
    </head>
    <body>
    <div class="layer-body" style="margin-top:-30px;padding-bottom:20px;">
    <div class="layer-contact">
    <div style="position:absolute;left:12px;top:20px;z-index:5;"><img src="../images/thai_government.png" width="60px"></div>
    <br>
    <form name="form_order" id="form_order" method="POST" action="#" >
<div id="detail_ch" style='display:none;overflow:auto;position:absolute;height: 200px;border:1px solid #999999;background-color:#ffffff;'></div>
    <table width="830px">
        <td colspan="10" style="text-align:center;font-size:26px;font-weight:bold;">บันทึกข้อความ</td><tr>
        <td colspan="10">ส่วนราชการ <?=$company_full?></td><tr>
        <td colspan="5">ที่ <input type="text" name="location" value="<?=$arrCol[location].'/'.$arrCol[nobill_location];?>"></td><td colspan="5">วันที่ <input type="text" name="dateday" id="datepick1" value="<?=$arrCol[dateday]?>"></td><tr>
        <td colspan="10">เรื่อง <input type="text" name="list_warehouse" style="width:725px;text-align:left;padding-left:15px;" value="ขออนุมัติจัดซื้อ <?=$arrCol[list_warehouse]?>" onkeyup="$('#show_listwarehouse').html(this.value)"></td><tr>
        <td colspan="10"><hr></td><tr>
        <td colspan="10">เรียน <input type="text" name="heading" style="width:760px;text-align:left;padding-left:15px;" value='ผู้อำนวยการ<?=$company?>'></td><tr>
        <td colspan="10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ด้วยฝ่าย <input type="text" name="department" value="<?=$arrCol[department]?>" style="width:270px;"> มีความประสงค์ขออนุมัติ <span id="show_listwarehouse"></span>
        <br> เพื่อใช้ใน <input type="text" name="idea" style="width:280px;" value="<?=$arrCol[idea]?>">
        ดังรายการต่อไปนี้
        </td><tr>

        </table>
        <table id="show_detail">
            <thead>
        <tr align="center" >
        <td rowspan="2" style="border:1px solid #000;width:40px;">ลำดับ</td>
        <td rowspan="2" style="border:1px solid #000;width:200px;">รายการ</td>
        <td rowspan="2" colspan="2" style="border:1px solid #000;width:100px;">จำนวน</td>
        <td rowspan="2" style="border:1px solid #000;width:100px;"><div style='font-size:12px;margin-top: 0px;'>ราคาหน่วยละ</div><div style="width:100%;text-align: center;font-size: 14px;">(บาท)</div></td>
        <td rowspan="2" style="border:1px solid #000;width:100px;">เป็นเงิน<br>(บาท)</td>
        <td style="border:1px solid #000;font-size: 12px;width:60px;">ราคา<br>มาตราฐาน</td>
        <td style="border:1px solid #000;font-size: 12px;width:60px;">ราคา<br>หลังสุดท้าย</td>
        <td rowspan="2" style="border:1px solid #000;font-size: 10px;width:100px;">กำหนดเวลาที่<br>ต้องการใช้หรือ<br>แล้วเสร็จ</td>
        </tr>
        <tr align="center">
        <td colspan="2" style="border:1px solid #000;">หน่วยละ</td>
        </thead>
        <tbody>
           <?
        
        if($_GET["row_id"]){
        $sql = "SELECT * FROM  tbl_order_body where bill_row = '".$_GET["row_id"]."'  ORDER By row_id ASC";
        $result = mysql_query($sql);
        while ($row = mysql_fetch_array($result) ) {
            $e++;
        print "<tr>";
        print "<td style='border:1px solid #000;'><input type='text' name='row$e' id='row$e' style='border:0px solid #000;width:50px;' value='$e'  onkeyup=\"next_ip('detail$e')\"></td>";
        print "<td style='border:1px solid #000;'><input type='hidden' name='barcode$e' id='barcode$e' value='$row[barcode]'><input type='text' name='detail$e' style='border:0px solid #000;width:200px;text-align:left;' value='$row[detail]' onkeyup=\"next_ip('pcs$e')\"></td>";
        print "<td style='border:1px solid #000;'><input type='text' name='pcs$e' id='pcs$e' style='border:0px solid #000;width:100%;'value='$row[pcs]' onkeyup=\"next_ip('unit$e')\"></td>";
        print "<td style='border:1px solid #000;'><input type='text' name='unit$e' id='unit$e' style='border:0px solid #000;width:100%;' value='$row[unit]' onkeyup=\"next_ip('use_rate$e')\"></td>";
        print "<td style='border:1px solid #000;'><input type='text' name='use_rate$e' id='use_rate$e' value='$row[use_rate]' onfocus='this.select()' onkeyup=\"calpcs($e);next_ip('total_price$e');\" style='border:0px solid #000;width:100%;' ></td>";
        //print "<td style='border:1px solid #000;'><input type='text' name='price$e' id='price$e' onfocus='this.select()' onkeyup='calpcs($e)' style='border:0px solid #000;width:100%' value='".$row[pcs]*$row[use_rate]."'></td>";
        print "<td style='border:1px solid #000;'><input type='text' name='total_price$e' id='total_price$e'  style='border:0px solid #000;width:100%;text-align:center;' value='".$row[pcs]*$row[use_rate]."' onkeyup=\"next_ip('medium_price$e')\"></td>";

        print "<td style='border:1px solid #000;'><input type='text' name='medium_price$e' id='medium_price$e' style='border:0px solid #000;width:100%;' value='$row[medium_price]' onkeyup=\"next_ip('last_price$e')\"></td>";
        print "<td style='border:1px solid #000;'><input type='text' name='last_price$e' id='last_price$e' style='border:0px solid #000;width:100%;' value='$row[last_price]' onkeyup=\"next_ip('balance_forward$e')\"></td>"; 
        print "<td style='border:1px solid #000;'><input type='text' name='balance_forward$e' id='balance_forward$e' style='border:0px solid #000;width:100%;' value='$row[balance_forward]'><span style='position:absolute;margin-left:5px;'><img src='../images/box_close.png' width='24px' style='cursor:pointer;' onclick='clear_text($e)'></span></td>";
        $arrCol[total_money]=$arrCol[total_money]+($row[pcs]*$row[use_rate]);
        }
        $arrCol[total_pcs]=$e;
        
    }
        
        for($e++;$e<=6;$e++){
        print "<tr>";
        print "<td style='border:1px solid #000;'><input type='text' name='row$e' id='row$e' style='border:0px solid #000;width:100%;' onkeyup=\"next_ip('detail$e')\"></td>";
        print "<td style='border:1px solid #000;'>
            <input type='hidden' name='barcode$e' id='barcode$e' value='' >
            <input type='text' name='detail$e' id='detail$e' style='border:0px solid #000;width:100%;' onkeyup=\"detailsearch($e);next_ip('pcs$e');\" onfocusout=\"$('#detail_ch').fadeOut();\"></td>";
        print "<td style='border:1px solid #000;width:70px;'><input type='text' name='pcs$e' id='pcs$e' style='border:0px solid #000;width:100%;' onkeyup=\"next_ip('unit$e');calpcs('$e');\"></td>";
        print "<td style='border:1px solid #000;width:30px;'><input type='text' name='unit$e' id='unit$e' style='border:0px solid #000;width:100%;' onkeyup=\"next_ip('use_rate$e')\"></td>";
        print "<td style='border:1px solid #000;'><input type='text' name='use_rate$e' id='use_rate$e' style='border:0px solid #000;width:100%;' onkeyup=\"next_ip('total_price$e');calpcs('$e');$('input:text[name=last_price$e]').val(this.value);\"></td>";
        print "<td style='border:1px solid #000;width:80px;'><input type='text' name='total_price$e' style='border:0px solid #000;width:100%;' onkeyup=\"next_ip('medium_price$e')\"></td>";
        print "<td style='border:1px solid #000;'><input type='text' name='medium_price$e' style='border:0px solid #000;width:100%;' onkeyup=\"next_ip('last_price$e')\"></td>";
        print "<td style='border:1px solid #000;'><input type='text' name='last_price$e' id='last_price$e'style='border:0px solid #000;width:100%;' onkeyup=\"next_ip('balance_forward$e')\"></td>";
        print "<td style='border:1px solid #000;'><input type='text' name='balance_forward$e' style='border:0px solid #000;width:100%;'></td>";
        print "</tr>";
        }

// detail,pcs,use_rate,unit,pcs,total_price,medium_price,last_price,balance_forward
//$tx_price = "54586.00";
        if(empty($arrCol[total_pcs]) && $_GET["row_id"]){
            $arrCol[total_pcs]=$e;
        }
        ?>
        </tbody>
        <tfoot>
        <tr>
        <td colspan="5" style="text-align:left;"><input type="hidden" name="row_detail" id="row_detail" value="<?=$arrCol[total_pcs]?>"></td>
        <td style="border:1px solid #000;"><div id='tx_price' style="text-align: right;"><?=number_format($arrCol[total_money],2)?></div></td><td style="text-align: center;"><div style="cursor: pointer;padding:0px 6px;border:1px solid #00a328;background-color:#00bc2e;color:#ffffff;border-radius:5px;" onclick="addrow()">เพิ่ม</div></td><tr>
        </tfoot>
        <table>
       <!--  <td colspan="10">และขออนุมัติแต่งตั้งคณะกรรมการตรวจรับพัสดุ / ผู้ตรวจรับพัสดุ ประกอบด้วย</td><tr> -->
        <td colspan="10">จำนวน <input type="text" name="total_pcs" id="total_pcs"  value="<?=$arrCol[total_pcs]?>" style="width:30px;"> รายการ รวมเป็นเงิน<input type="text" name="total_money"  value="<?=$arrCol[total_money]?>" style="width:100px;"> บาท ( <span  id="textmoney"><?=num2wordsThai(number_format($arrCol[total_money],2))?></span> ) ปีงบประมาณ <input type="text" name="year_budgets" style="width:50px;" value="<?=$arrCol[year_budgets]?>"></td><tr>
        <td colspan="2"> 
        <div><span style="font-size: 20px;position: absolute;margin-top: -5px;"><input type="checkbox" name="type_order" value="1" <?if($arrCol[type_order]==1){ echo "checked";}?>></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; หมวดวัสดุสำนักงาน </div>
        <div><span style="font-size: 20px;position: absolute;margin-top: -5px;"><input type="checkbox" name="type_order" value="2" <?if($arrCol[type_order]==2){ echo "checked";}?>></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ค่าจ้างเหมา </div></td>
        <td colspan="4">
        <div><span style="font-size: 20px;position: absolute;margin-top: -5px;"><input type="checkbox" name="type_order" value="3" <?if($arrCol[type_order]==3){ echo "checked";}?>></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; หมวดวัสดุงานบ้าน </div>
        <div><span style="font-size: 20px;position: absolute;margin-top: -5px;"><input type="checkbox" name="type_order" value="4" <?if($arrCol[type_order]==4){ echo "checked";}?>></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ครุภัณฑ์<input type='text' name='choice_kp' value="<?=$arrCol[choice_kp]?>" style='width:140px;border:0px solid #000000;border-bottom: 1px dotted #000000;' > </div>
        </td>
        <td colspan="3">
        <div><span style="font-size: 20px;position: absolute;margin-top: -5px;"><input type="checkbox" name="type_order" value="5" <?if($arrCol[type_order]==5){ echo "checked";}?>></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; หมวดวัสดุคอมพิวเตอร์ </div>
        <div><span style="font-size: 20px;position: absolute;margin-top: -5px;"><input type="checkbox" name="type_order" value="6" <?if($arrCol[type_order]==6){ echo "checked";}?>></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; อื่นๆ <input type='text' name='choice_condition' value="<?=$arrCol[choice_condition]?>" style='width:140px;border:0px solid #000000;border-bottom: 1px dotted #000000;'> </div>
        </td><tr>
        <td style="text-align:left;" colspan="10">ยอดเงินคงเหลือ<input type="text" name="budgets_total" value="<?=$arrCol[budgets_total]?>">บาท เบิกจ่ายครั้งนี้<input type="text" name="use_budgets" value="<?=$arrCol[use_budgets]?>">บาท คงเหลือ<input type="text" name="use_budgets_total" value="<?=$arrCol[use_budgets_total]?>">บาท</td><tr>
        <td style="text-align:left;" colspan="10">และจะดำเนินการจัดซื้อจัดจ้าง(6),(7) โดยวิธีตกลงราคา เนื่องจากเป็นการจัดซื้อจัดจ้างครึ่งหนึ่งซึ่งไม่เกิน 100,000 บาท</td><tr>
        <td style="text-align:left;" colspan="10">ตามระเบียบฯพัสดุ2535(ฉบับที่ 2) พ.ศ.2538 (7) และที่แก้ไขเพิ่มเติมทุกฉบับ และคำสั่งปฏิบัติราชการแทนผู้่าราชการจังหวัดที่ 4392/2558 ลว.12 ตุลาคม พ.ศ.2558 จึงขอแต่งตั้งผู้ตรวจรับ/คณะกรรมการตรวจรับดังนี้</td><tr>
        <td style="text-align:left;" colspan="10">
        <?
        if(empty($_GET["row_id"])){
        $strSQL="SELECT * from tbl_order_head ORDER By row_id DESC limit 1 ";
        $objQuery = mysql_query($strSQL) or die (mysql_error());
        $intNumField = mysql_num_fields($objQuery);
        $resultArray = array();
        while($obResult = mysql_fetch_array($objQuery)){
        $arrCol = array();
       for($i=0;$i<$intNumField;$i++){
             $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
            }
          }

          $arrCol[date_pass2]="";
          $arrCol[type_money]="";
        }
        ?>
        1. <input type="text" name="cob" id="cob" class="cob" style="width:300px;" value="<?=$arrCol[cob]?>"><!--<div id="cob_list" style="margin-top:-30px;margin-left:40px;"></div>-->ตำแหน่ง<input type="text" name="cob_po" id="cob_po" style="width:230px;" value="<?=$arrCol[cob_po]?>"> ประธานกรรมการตรวจรับพัสดุ <br>
        2. <input type="text" name="cmt_1" id="cmt_1" class="cmt_1" style="width:300px;" value="<?=$arrCol[cmt_1]?>"><!--<div id="cmt_1_list" style="margin-top:-30px;margin-left:40px;"></div>-->ตำแหน่ง<input type="text" name="cmt_po1" id="cmt_po1" style="width:230px;" value="<?=$arrCol[cmt_po1]?>"> กรรมการ   <br>
        3. <input type="text" name="cmt_2" id="cmt_2" class="cmt_2" style="width:300px;" value="<?=$arrCol[cmt_2]?>"><!--<div id="cmt_2_list" style="margin-top:-30px;margin-left:40px;"></div>-->ตำแหน่ง<input type="text" name="cmt_po2" id="cmt_po2"style="width:230px;" value="<?=$arrCol[cmt_po2]?>"> กรรมการ   <br>
        </td><tr>
        <td colspan="10" style="">
        ซึ่งเจ้าหน้าที่พัสดุได้ดำเนินการสืบราคาและต่อรองราคาแล้ว เห็นควรจัดซื้อจัดจ้างจาก <input type="hidden" name="companyltd" id="companyltd" style="width:350px;" value="<?=$arrCol[companyltd]?>"><input type="text" name="nameltd" id="nameltd"  value="<?=$arrCol[nameltd]?>"style="width:250px;" readonly> <img src="../images/menu/search.png" width="21px" style="cursor:pointer;position:absolute;margin-top: 5px;margin-left: 5px;" onclick="dealer()">
        </td>
        <tr>
          <td></td><td colspan="8">จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติ</td><tr>
       


        <td colspan="5" style="text-align:left;">
        <div>เรียน ผู้อำนวยการ<?=$hp[company_name]?></div>
        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เผื่อโปรดพิจารณาอนุมัติ</div>
        <div style="height:22px;"></div>
        <div>ลงชื่อ..............................................หัวหน้าเจ้าหน้าที่พัสดุ</div>
        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<input type="text" name="cmt_3" style="width:180px;" value='<?=$arrCol[cmt_3]?>'>)</div>
        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text"  name="cmt_po3" style="width:200px;" value='<?=$arrCol[cmt_po3]?>'></div>
        <div style="height:22px;"></div>
        <div style="padding-left:22px;font-weight: bold;">โดยใช้เงินจากงบ</div>
        <div style="padding-left:22px;"><span style="font-size: 20px;position: absolute;margin-top: -5px;"><input type="checkbox" name="type_money" value="1" <?if($arrCol[type_money]==1){ echo "checked";}?>></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บำรุง</div>
        <div style="padding-left:22px;"><span style="font-size: 20px;position: absolute;margin-top: -5px;"><input type="checkbox" name="type_money" value="2" <?if($arrCol[type_money]==2){ echo "checked";}?>></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;งบประมาณ</div>
        <div style="padding-left:22px;"><span style="font-size: 20px;position: absolute;margin-top: -5px;"><input type="checkbox" name="type_money" value="3" <?if($arrCol[type_money]==3){ echo "checked";}?>></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เงินอุดหนุนผู้มีปัญหาสถานะและสิทธิ์</div>
        <div style="padding-left:22px;"><span style="font-size: 20px;position: absolute;margin-top: -5px;"><input type="checkbox" name="type_money" value="4" <?if($arrCol[type_money]==4){ echo "checked";}?>></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;งบประกันสุขภาพ (UC.)</div>
        </td>
        <td colspan="5" style="text-align:center;">
        <div>ลงชื่อ..................................................เจ้าหน้าที่พัสดุ</div>
        <div>(<input type="text" name="cmt_4" style="width:230px;" value='<?=$arrCol[cmt_4]?>'>)</div>
        <div><input type="text" name="cmt_po4" style="width:230px;" value='<?=$arrCol[cmt_po4]?>'></div>
        <div>อนุมัติ</div>
        <div style="height:30px;"></div>
        <div>(ลงชื่อ)..............................................................</div>
        <div>(<input type="text" name="cmt_5" style="width:230px;" value='<?=$arrCol[cmt_5]?>'>)</div>
        <div><textarea rows="3" name="cmt_po5" style="width:300px;" ><?=str_replace("<br />","",$arrCol[cmt_po5])?></textarea></div>

        <div><input type="text" name="date_pass2" id="date_pass2" style="width:230px;text-align: center;" value='<?=$arrCol[date_pass2]?>' placeholder="<?=date("d/m/").(date("Y")+543);?>"></div>
        </td><tr>


        <tr> 
        <td style="height:20px;text-align:center;" colspan="10">
            <!-- <input type="hidden" name="submit"> -->
           <!--  <span class="bt_green" onclick="submit_ck()">บันทึก</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="bt_blue">ค้นหา</span> -->
           <input type="submit" name="submit" value="ตกลง" class="bt_green">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <?if($_GET["row_id"]){
            echo "<span class=\"bt_red\" onclick=\"delbill('".$_GET["row_id"]."')\">ลบบันทึกข้อความ</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
           }?>
           <span class="bt_blue" onclick="$('#popup_search').show()">ค้นหา</span>
<!--             <span onclick="window.location='dashboard.php'" style="padding:0px 30px;background-color:#e0e0e0;border:1px solid #999;cursor:pointer;" >ย้อนกลับ</span> -->
        </td><tr>

    </table>

    </form>
     </div>    
     </div>
          <!-- <center><span style="color:#666;font-size:14px;"><?=$hp[licen]?></span></center> -->
    </body>
</html>
        <script type="text/javascript" src="../js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
        <link type="text/css" href="../css/jquery-ui-1.8.10.custom.css" rel="stylesheet" /> 
       <script type="text/javascript">
         $("#datepick1").datepicker({ dateFormat: 'dd-mm-yy', isBuddhist: 'true', defaultDate: 'toDay',
              dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
         $("#date_pass2").datepicker({ dateFormat: 'dd-mm-yy', isBuddhist: 'true', defaultDate: 'toDay',
              dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
        
       </script>

                 <div id="popup_search" style="display: none;position:fixed;z-index:5;top:10%;left:10%;width: 80%;height:80%;border:1px solid #e0e0e0;border-radius: 5px;box-shadow: 5px 5px 5px rgba(0,0,0,0.3);background-color: #ffffff;">
           

<fieldset style="border-color:#0090ff;"><legend style='font-size:24px;color:#3995ff;'>.::ค้นหาบันทึกข้อความ::.</legend>
<form name="B1" method="POST" action="">
    <table width="100%">
        <td>ที่</td><td><input type="text" name="search_hire" autofocus onkeyup="search_hire1(this.value)"><input type='hidden' name='focus_row2' id='focus_row'></td>
        <td align="left"></td>
        <td style="width:50%;text-align: right;">
        <img src="../images/box_close.png" style='cursor: pointer;z-index:6;position: absolute;margin-left: -12px;margin-top: -83px;' onclick='$("#popup_search").hide();'>
       </td>
    </table>
</form>
</fieldset>
<div style="width:100%;height:72%;overflow: auto;">
<table id="show_hire" style='margin: 0px auto;width:70%;'>
    <thead>

    </thead>
    <tbody>
        
    </tbody>
</table>
</div>
  </div>

<?


if($_POST["submit"]=="ตกลง" && $_POST["location"]){
$wq=explode("/",$_POST["location"]);
if(empty($_GET["row_id"])){
//print_r($wq);
$strSQL = "INSERT INTO tbl_order_head SET "; 
$strSQL .="location = '".$wq[0]."' ";
$strSQL .=",nobill_location = '".$wq[1]."' ";
$strSQL .=",dateday = '".substr($_POST["dateday"],6,4)."-".substr($_POST["dateday"],3,2)."-".substr($_POST["dateday"],0,2)."' ";
$strSQL .=",heading = '".$_POST["heading"]."' ";
$strSQL .=",list_warehouse = '".$_POST["list_warehouse"]."' ";
$strSQL .=",department = '".$_POST["department"]."' ";
$strSQL .=",idea = '".$_POST["idea"]."' ";
$strSQL .=",year_budgets = '".$_POST["year_budgets"]."' ";
$strSQL .=",choice_kp = '".$_POST["choice_kp"]."' ";
$strSQL .=",choice_condition = '".$_POST["choice_condition"]."' ";
$strSQL .=",budgets_total = '".str_replace(",", "",$_POST["budgets_total"])."' ";
$strSQL .=",use_budgets = '".str_replace(",", "",$_POST["use_budgets"])."' ";
$strSQL .=",use_budgets_total = '".str_replace(",", "",$_POST["use_budgets_total"])."' ";
$strSQL .=",cob = '".$_POST["cob"]."' ";
$strSQL .=",cob_po = '".$_POST["cob_po"]."' ";
$strSQL .=",cmt_1 = '".$_POST["cmt_1"]."' ";
$strSQL .=",cmt_po1 = '".$_POST["cmt_po1"]."' ";
$strSQL .=",cmt_2 = '".$_POST["cmt_2"]."' ";
$strSQL .=",cmt_po2 = '".$_POST["cmt_po2"]."' ";
$strSQL .=",cmt_3 = '".$_POST["cmt_3"]."' ";
$strSQL .=",cmt_po3 = '".$_POST["cmt_po3"]."' ";
$strSQL .=",cmt_4 = '".$_POST["cmt_4"]."' ";
$strSQL .=",cmt_po4 = '".$_POST["cmt_po4"]."' ";
$strSQL .=",cmt_5 = '".$_POST["cmt_5"]."' ";
$strSQL .=",cmt_po5 = '".$_POST["cmt_po5"]."' ";
$strSQL .=",type_money = '".$_POST["type_money"]."' ";
$strSQL .=",type_order = '".$_POST["type_order"]."' ";
$strSQL .=",companyltd = '".$_POST["companyltd"]."' ";
$strSQL .=",nameltd = '".$_POST["nameltd"]."' ";
$strSQL .=",date_pass2 = '".substr($_POST["date_pass2"],6,4)."-".substr($_POST["date_pass2"],3,2)."-".substr($_POST["date_pass2"],0,2)."' ";
$strSQL .=",officer = '".$_SESSION["xusername"]."' ";
$strSQL .=",datedo = '".date("Y-m-d H:i:s")."' ";
$objQuery = mysql_query($strSQL) or die(mysql_error());

$sql = "SELECT row_id from tbl_order_head WHERE location = '".$wq[0]."' AND nobill_location = '".$wq[1]."' limit 0,1 ";
list($row_id) = Mysql_fetch_row(Mysql_Query($sql));

for($r=1;$r<=$_POST["row_detail"];$r++){
    if($_POST["detail$r"]){
$strSQL = "INSERT INTO tbl_order_body SET "; 
$strSQL .="location='".$_POST["location"]."'";
$strSQL .=",bill_row='".$row_id."'";
$strSQL .=",row='".$_POST["row$r"]."'";
$strSQL .=",barcode='".$_POST["barcode$r"]."'";
$strSQL .=",detail='".htmlentities($_POST["detail$r"])."'";
$strSQL .=",pcs='".str_replace(",","",$_POST["pcs$r"])."'";
$strSQL .=",unit='".$_POST["unit$r"]."'";
$strSQL .=",use_rate='".str_replace(",","",$_POST["use_rate$r"])."'";
$strSQL .=",total_price='".str_replace(",","",$_POST["total_price$r"])."'";
$strSQL .=",medium_price='".str_replace(",","",$_POST["medium_price$r"])."'";
$strSQL .=",last_price='".str_replace(",","",$_POST["last_price$r"])."'";
$strSQL .=",balance_forward='".str_replace(",","",$_POST["balance_forward$r"])."'";
$objQuery = mysql_query($strSQL) or die(mysql_error());

    }
}
 if($objQuery){

 echo("<script> window.location='theorder_V1_print.php?row_no=$row_id';</script>");

}
}else{

$strSQL = "UPDATE tbl_order_head SET ";
$strSQL .="location = '".$wq[0]."' ";
$strSQL .=",nobill_location = '".$wq[1]."' ";
$strSQL .=",dateday = '".substr($_POST["dateday"],6,4)."-".substr($_POST["dateday"],3,2)."-".substr($_POST["dateday"],0,2)."' ";
$strSQL .=",heading = '".$_POST["heading"]."' ";
$strSQL .=",list_warehouse = '".$_POST["list_warehouse"]."' ";
$strSQL .=",department = '".$_POST["department"]."' ";
$strSQL .=",idea = '".$_POST["idea"]."' ";
$strSQL .=",year_budgets = '".$_POST["year_budgets"]."' ";
$strSQL .=",choice_kp = '".$_POST["choice_kp"]."' ";
$strSQL .=",choice_condition = '".$_POST["choice_condition"]."' ";
$strSQL .=",budgets_total = '".str_replace(",", "",$_POST["budgets_total"])."' ";
$strSQL .=",use_budgets = '".str_replace(",", "",$_POST["use_budgets"])."' ";
$strSQL .=",use_budgets_total = '".str_replace(",", "",$_POST["use_budgets_total"])."' ";
$strSQL .=",cob = '".$_POST["cob"]."' ";
$strSQL .=",cob_po = '".$_POST["cob_po"]."' ";
$strSQL .=",cmt_1 = '".$_POST["cmt_1"]."' ";
$strSQL .=",cmt_po1 = '".$_POST["cmt_po1"]."' ";
$strSQL .=",cmt_2 = '".$_POST["cmt_2"]."' ";
$strSQL .=",cmt_po2 = '".$_POST["cmt_po2"]."' ";
$strSQL .=",cmt_3 = '".$_POST["cmt_3"]."' ";
$strSQL .=",cmt_po3 = '".$_POST["cmt_po3"]."' ";
$strSQL .=",cmt_4 = '".$_POST["cmt_4"]."' ";
$strSQL .=",cmt_po4 = '".$_POST["cmt_po4"]."' ";
$strSQL .=",cmt_5 = '".$_POST["cmt_5"]."' ";
$strSQL .=",cmt_po5 = '".$_POST["cmt_po5"]."' ";
$strSQL .=",type_money = '".$_POST["type_money"]."' ";
$strSQL .=",type_order = '".$_POST["type_order"]."' ";
$strSQL .=",companyltd = '".$_POST["companyltd"]."' ";
$strSQL .=",nameltd = '".$_POST["nameltd"]."' ";
$strSQL .=",date_pass2 = '".substr($_POST["date_pass2"],6,4)."-".substr($_POST["date_pass2"],3,2)."-".substr($_POST["date_pass2"],0,2)."' ";
$strSQL .=",officer = '".$_SESSION["xusername"]."' ";
$strSQL .=",datedo = '".date("Y-m-d H:i:s")."' ";
$strSQL .="WHERE row_id = '".$_GET["row_id"]."' ";
$objQuery = mysql_query($strSQL)or die(mysql_error());  

  $sql = "SELECT row from tbl_order_body WHERE bill_row = '".$_GET["row_id"]."' ";
  $row_num = mysql_num_rows(mysql_query($sql));
if($row_num<$_POST["row_detail"]){
    $row_num = $_POST["row_detail"];
}

for($r=1;$r<=$row_num;$r++){
    if($_POST["detail$r"]){

  $sql = mysql_query("SELECT row from tbl_order_body WHERE bill_row = '".$_GET["row_id"]."' AND row = '".$_POST["row$r"]."' ");
  if( mysql_num_rows($sql)){

$strSQL = "UPDATE tbl_order_body SET "; 
$strSQL .="location='".$_POST["location"]."'";
$strSQL .=",barcode='".$_POST["barcode$r"]."'";
$strSQL .=",detail='".htmlentities($_POST["detail$r"])."'";
$strSQL .=",pcs='".str_replace(",","",$_POST["pcs$r"])."'";
$strSQL .=",unit='".$_POST["unit$r"]."'";
$strSQL .=",use_rate='".str_replace(",","",$_POST["use_rate$r"])."'";
$strSQL .=",total_price='".str_replace(",","",$_POST["total_price$r"])."'";
$strSQL .=",medium_price='".str_replace(",","",$_POST["medium_price$r"])."'";
$strSQL .=",last_price='".str_replace(",","",$_POST["last_price$r"])."'";
$strSQL .=",balance_forward='".str_replace(",","",$_POST["balance_forward$r"])."'";
$strSQL .="WHERE row = '".$_POST["row$r"]."' AND bill_row = '".$_GET["row_id"]."'";
$objQuery = mysql_query($strSQL) or die(mysql_error());
}else{
$strSQL = "INSERT INTO tbl_order_body SET "; 
$strSQL .="location='".$_POST["location"]."'";
$strSQL .=",bill_row='".$_GET["row_id"]."'";
$strSQL .=",row='".$_POST["row$r"]."'";
$strSQL .=",barcode='".$_POST["barcode$r"]."'";
$strSQL .=",detail='".htmlentities($_POST["detail$r"])."'";
$strSQL .=",pcs='".str_replace(",","",$_POST["pcs$r"])."'";
$strSQL .=",unit='".$_POST["unit$r"]."'";
$strSQL .=",use_rate='".str_replace(",","",$_POST["use_rate$r"])."'";
$strSQL .=",total_price='".str_replace(",","",$_POST["total_price$r"])."'";
$strSQL .=",medium_price='".str_replace(",","",$_POST["medium_price$r"])."'";
$strSQL .=",last_price='".str_replace(",","",$_POST["last_price$r"])."'";
$strSQL .=",balance_forward='".str_replace(",","",$_POST["balance_forward$r"])."'";
$objQuery = mysql_query($strSQL) or die(mysql_error());
}



    }else{
  $sql_del = "DELETE FROM tbl_order_body WHERE row = '".$r."' AND bill_row = '".$_GET["row_id"]."'"; 
  $query = mysql_query($sql_del);
    }
}
 if($objQuery){

 echo("<script> window.location='theorder_V1_print.php?row_no=".$_GET["row_id"]."';</script>");

}

}
}






// $sql = "SELECT numberno from order_pending ORDER By numberno DESC ";
// list($numberno) = Mysql_fetch_row(Mysql_Query($sql));
// $numberno++;

// for($r=1;$r<=6;$r++){
// if($_POST["detail$r"]){
// $strSQL = "INSERT INTO order_pending SET ";
// $strSQL .="numberno='".$numberno."'";
// $strSQL .=",location='".$_POST["location"]."'";
// $datedayx=explode("/",$_POST["dateday"]);
// $strSQL .=",dateday='".$datedayx[2]."/".str_pad($datedayx[1],2,"0",STR_PAD_LEFT)."/".str_pad($datedayx[0],2,"0",STR_PAD_LEFT)."'";
// // $strSQL .=",dateday='".$_POST["dateday"]."'";
// $strSQL .=",list_warehouse='".$_POST["list_warehouse"]."'";
// $strSQL .=",heading='".$_POST["heading"]."'";
// $strSQL .=",department='".$_POST["department"]."'";
// // $strSQL .=",money_total='".str_replace(",","",$_POST["money_total"])."'";
//  $strSQL .=",year_budgets='".$_POST["year_budgets"]."'";
// // $strSQL .=",choice_money='".$_POST["choice_money"]."'";
// $strSQL .=",choice_condition ='".$_POST["choice_condition"]."'";
// $strSQL .=",choice_kp ='".$_POST["choice_kp"]."'";
// $strSQL .=",companyltd='".$_POST["companyltd"]."'";
// $strSQL .=",nameltd='".$_POST["nameltd"]."'";
// $strSQL .=",row='".$_POST["row$r"]."'";
// $strSQL .=",barcode='".$_POST["barcode$r"]."'";
// $strSQL .=",detail='".$_POST["detail$r"]."'";
// $strSQL .=",balance_forward='".str_replace(",","",$_POST["balance_forward$r"])."'";
// $strSQL .=",use_rate='".str_replace(",","",$_POST["use_rate$r"])."'";
// $strSQL .=",unit='".$_POST["unit$r"]."'";
// $strSQL .=",pcs='".str_replace(",","",$_POST["pcs$r"])."'";
//  // $strSQL .=",price='".str_replace(",","",$_POST["price$r"])."'";
// $strSQL .=",total_price='".str_replace(",","",$_POST["total_price$r"])."'";
// $strSQL .=",medium_price='".str_replace(",","",$_POST["medium_price$r"])."'";
// $strSQL .=",last_price='".str_replace(",","",$_POST["last_price$r"])."'";
// $strSQL .=",cob='".$_POST["cob"]."'";
// $strSQL .=",cob_po='".$_POST["cob_po"]."'";
// $strSQL .=",cmt_1='".$_POST["cmt_1"]."'";
// $strSQL .=",cmt_po1='".$_POST["cmt_po1"]."'";
// $strSQL .=",cmt_2='".$_POST["cmt_2"]."'";
// $strSQL .=",cmt_po2='".$_POST["cmt_po2"]."'";
// // $strSQL .=",budgets_total='".str_replace(",","",$_POST["budgets_total"])."'";
// // $strSQL .=",use_budgets='".str_replace(",","",$_POST["use_budgets"])."'";
// // $strSQL .=",use_budgets_total='".str_replace(",","",$_POST["use_budgets_total"])."'";
// // $strSQL .=",budgets_balance='".str_replace(",","",$_POST["budgets_balance"])."'";
// $strSQL .=",idea='".$_POST["idea"]."'";
// $strSQL .=",cmt_3='".$_POST["cmt_3"]."'";
// $strSQL .=",cmt_po3='".$_POST["cmt_po3"]."'";
// // $dxpas=explode("/",$_POST["datepass1"]);
// // $strSQL .=",datepass1='".$dxpas[2]."/".str_pad($dxpas[1],2,"2",STR_PAD_LEFT)."/".str_pad($dxpas[0],2,"2",STR_PAD_LEFT)."'";
// $strSQL .=",cmt_4='".$_POST["cmt_4"]."'";
// $strSQL .=",cmt_po4='".$_POST["cmt_po4"]."'";
// $strSQL .=",cmt_5='".$_POST["cmt_5"]."'";
// $strSQL .=",cmt_po5='".$_POST["cmt_po5"]."'";
// $dxpass=explode($_POST["date_pass2"]);
// $strSQL .=",date_pass2='".$dxpass[2]."/".str_pad($dxpass[1],2,"0",STR_PAD_LEFT)."/".str_pad($dxpass[0],2,"0",STR_PAD_LEFT)."'";
// $strSQL .=",status='W'";
// $strSQL .=",officer = '".$_SESSION["xUser"]."' ";
// $objQuery = mysql_query($strSQL) or die(mysql_error());

//     // $update_price = "UPDATE stock_product SET price_in='".str_replace(",","",$_POST["price$r"])."',unit='".$_POST["unit$r"]."' WHERE barcode='".$_POST["barcode$r"]."' ";
//     // $result_price= mysql_query($update_price); 

//     // $sql_update = "UPDATE hire SET status='Y' WHERE order_number='$ordernumber' AND barcode='".$_POST["barcode$r"]."' ";
//     // $result_update= mysql_query($sql_update);
// }
// }
// if($objQuery){

// //     session_register("numberno");
// //     //session_register("nobook_order");
//     $_SESSION["numberno"]=$numberno;
//     //$_SESSION["nobook_order"]=$_POST["nobook"];
//  echo("<script> window.location='theoder1_print.php?';</script>");

// }
// }


?>