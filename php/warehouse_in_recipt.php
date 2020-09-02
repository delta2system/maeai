<?
session_start();
include("connect.inc");
if($_SESSION["xusername"]==""){
  echo("<script>alert('กรุณาทำการล็อกอินก่อนใช้งาน');window.location='login.php'</script>");
}

if($_GET["dateday"]){
  $dateday=$_GET["dateday"];
}else{
  $dateday=date("d-m-").(date("Y")+543);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>..::รายการรับสินค้า::..</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script src="../js/jquery-1.8.0.min.js"></script>
   <script type="text/javascript" src="auto/autocomplete.js"></script>
  <link rel="stylesheet" href="auto/autocomplete.css"  type="text/css"/>

  <style type="text/css">
  table{
    border-collapse: collapse;
  }
    .topbar{
      background-color: #9E9E9E;
      text-align: center;
      padding:5px 0px;
    }
    .border_bt{
      border: 1px solid #a0a0a0;
    }
    .button_menu{
      float: left;
      padding:5px 10px;
      border:1px solid #e0e0e0;
      cursor: pointer;
    }
     .button_menu:hover{
      background-color: #e0e0e0;
     }

     .detail_show{
      width:900px;
      border:1px solid #555555;
      overflow-x: hidden;
      overflow-y: auto;
      margin-left:25px;
     }
     input{
      padding:5px 10px;font-size: 14px;
     }


  </style>
  <script type="text/javascript">
        document.onkeydown = chkEvent 
function chkEvent(e) {
  var keycode;
  if (window.event) keycode = window.event.keyCode; //*** for IE ***//
  else if (e) keycode = e.which; //*** for Firefox ***//
  if(keycode==123)
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


            function del_row(r){

               var i = r.parentNode.parentNode.rowIndex;
              document.getElementById("detail_table").deleteRow(i);

            }


          function savebill(){

            var fd = new FormData();
            $("input").each(function(){
              fd.append($(this).attr('name'),$(this).val());
              
            });
              fd.append('submit','save_warehouse_recipt');

      $.ajax({
            url: 'mysql_warehouse.php?',
            type: 'post',
            data: fd,
            //cache: false,
            contentType: false,
            processData: false,
            success: function(response){
                 // alert(response);
                 var obj = jQuery.parseJSON(response);      
                $.each(obj, function(key, val) {
                  if(val["status"]=="true"){
                    alert(val["msg"]);
                    window.location='display_index.php?';
                   window.open("bill1_print.php?nobill="+val["nobill"],'_blank');

                  }else{
                    alert(val["msg"]);
                  }
                });
            },
        });



          }


            function set_value(row_id,ty,row,value){

              var pcs = $("#pcs"+row).val();if ( isNaN(pcs)){pcs = 0;}
              var price = $("#price"+row).val(); if ( isNaN(price)){price = 0;}
              var ls = parseFloat(value); if ( isNaN(ls)){ls = 0;}

              $("#total_dis"+row).html(addCommas((pcs*price).toFixed(2)));
              $("#stock_total_dis"+row).html(addCommas((ls+parseFloat(pcs)).toFixed(2)));

              var x = document.getElementById("detail_table").rows.length;
              var total=0;
              for (var i = 1; i < x; i++) {
                var ds = parseFloat($("#total_dis"+i).html().replace(',','')); if ( isNaN(ds)){ds = 0;}
                  total = total + ds;
              }
     
              $("#Ftotal").html(addCommas(total.toFixed(2)));
            //   $("input").each(function(){
            //   fd.append($(this).attr('name'),$(this).val());
              
            // });



            }




  </script>
</head>
<body>
  <div id="ins"></div>
  <center>
  <div id="menu_bar" style="width:850px;height:20px;">
  <div class="button_menu" onclick="savebill()"><img src="../images/menu/save_icon.png" style="width:24px;vertical-align: middle;" > บันทึก </div> 
    </div>
<br>

<fieldset style="width:870px;border:1px solid #03A9F4;margin-left: 25px;background-color: #E1F5FE;">
<legend style="color:#03A9F4;">รายการรับสินค้า </legend>
<table width="850px" >
 <tr><td colspan="3">จากใบสั่งซื้อเลขที่ <input type="text" readonly name="order_bill" id="order_bill" style="width:150px; " onkeyup="if(event.which==13){ $('#barcode').focus();}" ></td><td style="text-align: right;">เลขที่ใบส่งของ :</td><td><input type="text" name="nobill" id="nobill" autofocus style="width:100px;" onkeyup="if(event.which==13){$('#code_supply').focus();}"></td></tr>
 <tr><td colspan="3"></td><td style="text-align: right;">วันที่ :</td><td><input type="text" name="dateday" id="dateday" value="<?=$dateday?>" style="width:100px;text-align: center;"></td></tr>
 <tr><td>รับจาก</td><td><input type="text" name="code_supply" id="code_supply" style="width:50px;" onkeyup="if(event.which==13){$('#code_persanal').focus();}"></td><td colspan="3"><input type="text" name="name_supply" id="name_supply" style="width:600px;"></td></tr>
 <tr><td>รหัสพนักงาน</td><td><input type="text" name="code_persanal" id="code_persanal" style="width:50px;" onkeyup="if(event.which==13){$('#order_bill').focus();}"></td><td><input type="text" name="name_persanal" id="name_persanal" value="<?=$_SESSION[xfullname]?>" style="width:400px;"></td> </tr>

 </table>
</fieldset>
<div class="detail_show" id="detail_show" >
 <table width="880px" id="detail_table">
  <thead>
  <tr><td class='topbar' style='width:30px;'>#</td><td class='topbar' style='width:120px;'>รหัสสินค้า</td><td class='topbar' style='width:300px;'>สินค้า</td><td class='topbar' style='width:50px;'>จำนวน</td><td class='topbar' style='width:60px;'>ราคา/หน่วย</td><td class='topbar' style='width:50px;'>ราคารวม</td><td class='topbar' style='width:50px;'>คงเหลือ</td></tr>
</thead>
<tbody></tbody>

 </table>

 </div>
 <div style="width:850px;padding-top:10px;">
 <div style="width:700px;height:30px;text-align: right;float: left;border-bottom:0px solid #a0a0a0;">รวมเป็นเงิน &nbsp;&nbsp;</div>
 <div style="width:140px;height:30px;text-align: right;padding-right:10px;float: left;border-bottom:2px double #a0a0a0;font-weight: bold;" id="Ftotal"></div>
</div>
</center>
</body>
</html>

<script src="../js/tableHeadFixer.js"></script>
<script type="text/javascript">

  function make_autocom(autoObj,showObj){
  var mkAutoObj=autoObj; 
  var mkSerValObj=showObj; 
  new Autocomplete(mkAutoObj, function() {
    this.setValue = function(id) {    
      document.getElementById(mkSerValObj).value = id;
    }
    if ( this.isModified )
      this.setValue("");

    //if ( this.value.length < 1 && this.isNotClick ) 
     if ( this.value.length < 1 && this.isNotClick) 
      return ;  
    return "auto/gdata.php?q=" +encodeURIComponent(this.value);
    }); 
} 

  function per_autocom(autoObj,showObj){
  var mkAutoObj=autoObj; 
  var mkSerValObj=showObj; 
  new Autocomplete(mkAutoObj, function() {
    this.setValue = function(id) {    
      document.getElementById(mkSerValObj).value = id;

    }
    if ( this.isModified )
      this.setValue("");
    //if ( this.value.length < 1 && this.isNotClick ) 
    if ( this.value.length < 1 && this.isNotClick) 
      return ;  
    return "auto/gdata.php?r=" +encodeURIComponent(this.value);
    }); 
}

  function product_autocom(autoObj,showObj){
  var mkAutoObj=autoObj; 
  var mkSerValObj=showObj; 
  new Autocomplete(mkAutoObj, function() {
    this.setValue = function(id) {    
      document.getElementById(mkSerValObj).value = id;
      if(id!=""){
     var tx = $("#barcode_search").val();
      check_product(tx);
      $("#barcode_search").val("");
      $("#detail").val("");
      }
    }
    if ( this.isModified )
      this.setValue("");
   // if ( this.value.length < 1 && this.isNotClick ) 
   if ( this.value.length < 1 && this.isNotClick) 
      return ;  
    return "auto/gdata.php?product=" +encodeURIComponent(this.value);
    }); 
}

function set_detail_show(){
  var x = $(window).height();

  $(".detail_show").css({"height":(x-260)+"px"});
}

function retrun_no(no){

        $("#order_bill").val(no);
    $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=return_bill_egp&no='+no,
            })
            .success(function(result) {
              
               $("#detail_table tbody tr").remove();
              var obj = jQuery.parseJSON(result);
              if(obj != ''){
              var r=0;
              var F_total=0;
                  $.each(obj, function(key, val) {
                  r++; 
                  var tr = "<tr id='tr_row"+r+"'><td style='text-align:center;' class='border_bt'>"+r+"</td>";
                  tr = tr +  "<td style='text-align:center;' class='border_bt'><input type='hidden' name='barcode["+r+"]' id='barcode"+r+"' value='"+val["barcode"]+"' >"+val["barcode"]+"</td>";
                  tr = tr +  "<td class='border_bt'>"+val["detail"]+"</td>";
                  tr = tr +  "<td style='text-align:center;padding:0px 5px;' class='border_bt'><input type='text' name='pcs["+r+"]' id='pcs"+r+"' value='"+val["pcs"]+"' style='width:90%;border:0px solid #000000;text-align:right;' onkeyup=\"set_value('"+val["row_id"]+"','pcs','"+r+"','"+val["laststock"]+"')\" onclick=\"this.select();\"></td>";
                  tr = tr +  "<td style='text-align:center;padding:0px 5px;' class='border_bt'><input type='text' name='price["+r+"]' id='price"+r+"' value='"+val["price"]+"' style='width:90%;border:0px solid #000000;text-align:center;' onkeyup=\"set_value('"+val["row_id"]+"','price','"+r+"','"+val["laststock"]+"')\"></td>";
                  tr = tr +  "<td style='text-align:right;padding-right:10px;' class='border_bt' id='total_dis"+r+"'>"+addCommas(val["total"].toFixed(2))+"</td>";
                  tr = tr +  "<td style='text-align:right;padding-right:10px;' class='border_bt' ><span id='stock_total_dis"+r+"'>"+addCommas(val["stock_total"].toFixed(2))+"</span><span style='margin-top:-20px;color:red;cursor:pointer;' onclick=\"del_row(this)\">&#8855;</span></td>";
                  tr = tr + "</tr>";
                                     //alert(tr);
                  $('#detail_table tbody').append(tr);
                   $('#code_supply').val(val["supply_id"]);
                  // $('#code_persanal').val(val["code_persanal"]);
                   $('#name_supply').val(val["name_supply"]);
                  // $('#name_persanal').val(val["name_persanal"]);
                  // $('#nobill').val(val["nobill"]);
                  // $('#order_bill').val(val["creditor_bill"]);
                  
                  F_total = parseFloat(F_total) + parseFloat(val["total"]);
                  
                 });
                  //alert(F_total);
                          var objDiv = document.getElementById("detail_show");
                          objDiv.scrollTop = objDiv.scrollHeight;
                    //alert(objDiv.scrollHeight);

                  $("#Ftotal").html(addCommas(F_total.toFixed(2)));
            }else{
                  $("#Ftotal").html("");
            }
               });
}


// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("code_supply","name_supply");
per_autocom("code_persanal","name_persanal");
product_autocom("barcode","detail");
set_detail_show();

    $(document).ready(function() {
       $("#detail_table").tableHeadFixer(); 
       //$("#detail_show").onscroll(fixedhead());
      });
</script>

        <script type="text/javascript" src="../js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
        <link type="text/css" href="../css/jquery-ui-1.8.10.custom.css" rel="stylesheet" /> 
       <script type="text/javascript">
         $("#dateday").datepicker({ dateFormat: 'dd-mm-yy', isBuddhist: 'true', defaultDate: 'toDay',
              dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
       </script>
<?
if(!empty($_GET["no"])){

echo("<script>retrun_no('".$_GET["no"]."')</script>");

}

?>
