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
  <title>..::รายการเบิกสินค้า::..</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script src="../js/jquery-1.8.0.min.js"></script>
   <script type="text/javascript" src="auto/autocomplete.js"></script>
  <link rel="stylesheet" href="auto/autocomplete.css"  type="text/css"/>

  <style type="text/css">
  table{
    border-collapse: collapse;
  }
    .topbar{
      background-color: #a0a0a0;
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


  </style>
  <script type="text/javascript">
  //   function return_supply(th){
  //             var x=  $(th).position();
  //             var x1 = x.left;
  //             var y1 = x.top;
  //             var h1 = $( th ).height();

  //     var sa = th.value;
  //         $.ajax({ 
  //               url: "mysql_return.php" ,
  //               type: "POST",
  //               data: 'submit=return_customer&search'+sa,
  //           })
  //           .success(function(result) {
  //             //alert(result);

  //      var obj = jQuery.parseJSON(result);
  //      if(obj != ''){
  //     $.each(obj, function(key, val) {
  //     //$("#name_supply").val(val["name"]+" "+val["address"]);

  //   });
  // }
  // });
  //   }
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

  function barcode_tag(){
  var keycode;
  if (window.event) keycode = window.event.keyCode; //*** for IE ***//
  else if (e) keycode = e.which; //*** for Firefox ***//

  if(keycode==13){
    //  var tx = $("#barcode").val();
    // check_product(tx);
    // $("#barcode").val("");
    // $("#detail").val("");
  }else if(keycode==106){
    $("#barcode").val('');
  var person = prompt("ใส่จำนวนสินค้า", "");

if (person != null) {
  $("#pcs").val(person);
  $("#barcode").focus();
}else{
  $("#pcs").val('1');
  $("#barcode").focus();
}

  }

  }

     function check_product(th){
          $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=check_product&barcode='+th,
            })
            .success(function(result) {

              var obj = jQuery.parseJSON(result);
              if(obj != ''){
              $.each(obj, function(key, val) {
              if(val["status"]=="true"){
              insert_product(val["barcode"]);
              }else{
              alert(val["Messenger"]);
              }
              });
              }
              });
            }
            function insert_product(bc){
              var data = "&nobill="+$("#nobill").val();
                  data = data + "&dateday="+$("#dateday").val();
                  data = data + "&code_supply="+$("#code_supply").val();
                  data = data + "&code_persanal="+$("#code_persanal").val();
                 // data = data + "&order_bill="+$("#order_bill").val();
                  data = data + "&pcs="+$("#pcs").val();
                  data = data + "&barcode="+bc;
                  data = data + "&status=OWH";

            $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=insert_product'+data,
            })
            .success(function(result) {
                return_bill();
            });  
            }

            function return_bill(){
              $("#pcs").val('1');
            $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=return_bill&status=OWH',
            })
            .success(function(result) {
              //alert(result);
               $("#detail_table tbody tr").remove();
              var obj = jQuery.parseJSON(result);
              if(obj != ''){
              var r=0;
              var F_total=0;
                  $.each(obj, function(key, val) {
                  r++; 
                  var tr = "<tr><td style='text-align:center;' class='border_bt'>"+r+"</td>";
                  tr = tr +  "<td style='text-align:center;' class='border_bt'>"+val["barcode"]+"</td>";
                  tr = tr +  "<td class='border_bt'>"+val["detail"]+"</td>";
                  tr = tr +  "<td style='text-align:center;' class='border_bt'><input type='text' id='pcs"+r+"' value='"+val["pcs"]+"' style='width:98%;border:0px solid #000000;text-align:right;' onkeyup=\"set_value('"+val["row_id"]+"','pcs','"+r+"',this.value)\" onclick=\"this.select();\"></td>";
                  // tr = tr +  "<td style='text-align:center;' class='border_bt'><input type='text' id='price"+r+"' value='"+val["price"]+"' style='width:98%;border:0px solid #000000;text-align:center;' onkeyup=\"set_value('"+val["row_id"]+"','price','"+r+"',this.value)\"></td>";
                  tr = tr +  "<td style='text-align:center;' class='border_bt'>"+val["unit"]+"</td>";
                  tr = tr +  "<td style='text-align:center;' class='border_bt'>"+val["price"]+"</td>";
                  tr = tr +  "<td style='text-align:right;' class='border_bt'>"+addCommas(val["stock_total"].toFixed(2))+"&nbsp;&nbsp;</td>";
                  tr = tr +  "<td style='text-align:right;' class='border_bt'><input type='text' name='other' style='width:80%;border:0px solid #000000;' onkeyup=\"set_other(this.value,'"+val["row_id"]+"')\" value='"+val["other"]+"'> <span style='margin-top:-20px;margin-left:-20px;color:red;cursor:pointer;' onclick=\"del_row('"+val["row_id"]+"')\">&#8855;</span></td>";
                  tr = tr + "</tr>";
                                     //alert(tr);

                  $('#detail_table tbody').append(tr);
                  $('#code_supply').val(val["code_supply"]);
                  $('#code_persanal').val(val["code_persanal"]);
                  $('#name_supply').val(val["name_supply"]);
                  $('#name_persanal').val(val["name_persanal"]);
                  $('#nobill').val(val["nobill"]);
                  $('#order_bill').val(val["creditor_bill"]);
                  
                  F_total = parseFloat(F_total) + parseFloat(val["total"]);

                  if(val["stock_total"] < 0){
                    alert('พัสดุ'+val["detail"]+'คงเหลือ '+val["laststock"]+'  ไม่พอเบิก');
                    del_row(val["row_id"]);
                  }
                  
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
            function del_row(id){
              $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=del_billreal_row&row_id='+id,
            }).success(return_bill());
            }

            function set_value(row_id,ty,row,value){
               var keycode;
               if (window.event) keycode = window.event.keyCode; //*** for IE ***//
               else if (e) keycode = e.which; //*** for Firefox ***//
               if(keycode==13){
          $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=set_value&row_id='+row_id+"&tbl="+ty+"&value="+value,
            })
            .success(function(result) {
              if(ty=="pcs"){
                $("#barcode").focus();
                
                return_bill();
              }else{
                $("#barcode").focus();
             
                return_bill();
              }
              

              });
                }
            }

          function savebill(){
          $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=save_take&status=OWH&customer_id='+$("#code_supply").val()+'&customer_name='+$("#name_supply").val()+'&persanal_id='+$("#code_persanal").val()+'&nobill='+$("#nobill").val()+'&dateday='+$("#dateday").val(),
            }).success(function(result) {
              //alert(result);
              window.open("bill2_print.php?nobill="+result,'_blank');
              window.location='warehouse_take.php';
            });
          }

          function cancelbill(){
            var n = confirm("ต้องการยกเลิกบิลนี้ใช่หรือไม่?");
            if(n==true){
              $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=cancel_in&status=OWH',
            }).success(function(result) {
              
              window.location='warehouse_take.php';
            });
          
            }else{
              return false
            }
          }

          function set_other(vl,ri){

            if(event.which==13){
              $('#barcode').focus();
            }else{


              $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=update_other&value='+vl+"&row_id="+ri,
            }).success(function(result) {
              
              //window.location='warehouse_take.php';
            });

          }

          }
            


  </script>

</head>
<body>
  <center>
  <div id="menu_bar" style="width:850px;height:20px;">
  <div class="button_menu" onclick="savebill()"><img src="../images/menu/save_icon.png" style="width:24px;vertical-align: middle;" > บันทึก </div> 
  <div class="button_menu" onclick="cancelbill()"><img src="../images/menu/close_red.png" style="width:24px;vertical-align: middle;" > ยกเลิก </div>  </div>
<br>

<fieldset style="width:870px;margin-left: 25px;border:1px solid #E65100;background-color: #FFF3E0;">
<legend style="color:#E65100;">เบิกพัสดุ </legend>
<table width="850px" >
 <tr><td colspan="3"></td><td style="text-align: right;">เลขที่ใบเบิกพัสดุ :</td><td><input type="text" name="nobill" id="nobill" autofocus style="width:100px;" onkeyup="if(event.which==13){$('#code_supply').focus();}"></td></tr>
 <tr><td colspan="3"></td><td style="text-align: right;">วันที่ :</td><td><input type="text" name="dateday" id="dateday" value="<?=$dateday?>" style="width:100px;text-align: center;"></td></tr>
 <tr><td>หน่วยงาน</td><td><input type="text" name="code_supply" id="code_supply" style="width:50px;" onkeyup="if(event.which==13){$('#code_persanal').focus();}"> </td><td colspan="3"><input type="text" name="name_supply" id="name_supply" style="width:665px;"></td></tr>
 <tr><td>รหัสพนักงาน</td><td><input type="text" name="code_persanal" id="code_persanal" style="width:50px;" onkeyup="if(event.which==13){$('#barcode').focus();}"></td><td><input type="text" name="name_persanal" id="name_persanal" style="width:400px;"></td> </tr>

  <tr><td>รหัส/สินค้า</td><td colspan='4'><input type="text" name="barcode" id="barcode" style="width:457px;float: left;height:25px;font-size: 18px;" onkeyup="barcode_tag()">
    <input type='hidden' name='detail' id='detail' ><input type='hidden' name='pcs' id='pcs' value='1'>

  </td></tr> 
 </table>
</fieldset>
<div class="detail_show" id="detail_show" >
 <table width="880px" id="detail_table">
  <thead>
  <tr><td class='topbar' style='width:30px;'>#</td><td class='topbar' style='width:120px;'>รหัสสินค้า</td><td class='topbar' style='width:300px;'>สินค้า</td><td class='topbar' style='width:50px;'>จำนวน</td>
    <td class='topbar' style='width:60px;'>หน่วย</td>
    <td class='topbar' style='width:50px;'>ราคา/หน่วย</td>
    <td class='topbar' style='width:50px;'>คงเหลือ</td>
    <td class='topbar' style='width:100px;'>หมายเหตุ</td>

  </tr>
</thead>
<tbody></tbody>
<!--   <tfoot>
  <tr><td style="text-align: center;">1</td>
    <td style="text-align: center;"><input type="text" name="barcode" id="barcode" style='width:100%;text-align: center;' onkeyup="if(event.which==13){$('#pcs').select();}"></td>
    <td style="text-align: center;"><input type="text" name="detail" id="detail" style='width:100%'></td>
    <td style="text-align: center;"><input type="text" name="pcs" id="pcs" style='width:100%;text-align: center;' onkeyup="if(event.which==13){$('#price').select();}"></td>
    <td style="text-align: center;"><input type="text" name="price" id="price" style='width:100%;text-align: center;' onkeyup="if(event.which==13){$('#total').select();}"></td>
    <td style="text-align: center;"><input type="text" name="total" id="total" style='width:100%;text-align: center;' onkeyup="if(event.which==13){$('#stock').select();}"></td>
    <td style="text-align: center;"><input type="text" name="stock" id="stock" style='width:100%;text-align: center;' ></td></tr>
</tfoot> -->
<!-- <tfoot>
  <td colspan="5" style="text-align: right;">รวมเป็นเงิน &nbsp;&nbsp;</td>
  <td></td>
  </tfoot> -->
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
    return "auto/gdata.php?department=" +encodeURIComponent(this.value);
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
    if ( this.value.length < 1 && this.isNotClick ) 
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
     var tx = $("#barcode").val();
      check_product(tx);
      $("#barcode").val("");
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


// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("code_supply","name_supply");
per_autocom("code_persanal","name_persanal");
product_autocom("barcode","detail");
return_bill();
set_detail_show();

    $(document).ready(function() {
       $("#detail_table").tableHeadFixer(); 
       //$("#detail_show").onscroll(fixedhead());
      });
    // function fixedhead(){
    //   $("#detail_table").tableHeadFixer(); 
    //   //alert("OK");
    // }


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

