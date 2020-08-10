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
  //alert(keycode);
 if(keycode==106){
  $("#barcode").val('');
    var r = prompt("กรุณาใส่จำนวนสินค้า");
    if(r != null){
      $("input[name=pcs]").val(r);
      //$("#barcode").val("");
    }
    //  var tx = $("#barcode").val();
    // check_product(tx);
    // $("#barcode").val("");
    // $("#detail").val("");
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
                  data = data + "&order_bill="+$("#order_bill").val();
                  data = data + "&pcs="+$("#pcs").val();
                  data = data + "&barcode="+bc;
                  data = data + "&status=INV";
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
            $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=return_bill&status=INV',
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
                  tr = tr +  "<td style='text-align:center;' class='border_bt'><input type='text' id='price"+r+"' value='"+val["price"]+"' style='width:98%;border:0px solid #000000;text-align:center;' onkeyup=\"set_value('"+val["row_id"]+"','price','"+r+"',this.value)\"></td>";
                  tr = tr +  "<td style='text-align:right;' class='border_bt'>"+addCommas(val["total"].toFixed(2))+"&nbsp;&nbsp;</td>";
                  tr = tr +  "<td style='text-align:right;' class='border_bt'>"+addCommas(val["stock_total"].toFixed(2))+"&nbsp;<span style='margin-top:-20px;color:red;cursor:pointer;' onclick=\"del_row('"+val["row_id"]+"')\">&#8855;</span></td>";
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
                $("#price"+row).select();
              }else if(ty=="price"){
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
                data: 'submit=save_in&status=INV&customer_id='+$("#code_supply").val()+'&customer_name='+$("#name_supply").val()+'&persanal_id='+$("#code_persanal").val()+'&nobill='+$("#nobill").val()+'&order_bill='+$("#order_bill").val()+'&dateday='+$("#dateday").val(),
            }).success(function(result) {
              window.open("bill1_print.php?nobill="+result,'_blank');
              window.location='warehouse_in.php';
            });
          }

          function cancelbill(){
            var n = confirm("ต้องการยกเลิกบิลนี้ใช่หรือไม่?");
            if(n==true){
              $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=cancel_in&status=INV',
            }).success(function(result) {
              
              window.location='warehouse_in.php';
            });
          
            }else{
              return false
            }
          }

          function new_barocde_return(vx){
            $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=new_barocde_return&group_type='+vx,
            })
            .success(function(result) {
               // alert(result);
               $("input[name=new_barcode]").val(result);
               $("input[name=new_detail]").select();
            });  
          }

          function save_new_product(){
            var data = "&barcode="+$("input[name=new_barcode]").val();
                data = data + "&qrcode="+$("input[name=new_qrcode]").val();
                data = data + "&detail="+$("input[name=new_detail]").val();
                data = data + "&price="+$("input[name=new_price]").val();
                data = data + "&unit="+$("input[name=new_unit]").val();
                data = data + "&group_type="+$("select[name=new_group]").val();

            $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=save_new_product'+data,
            })
            .success(function(result) {
               var obj = jQuery.parseJSON(result);
              if(obj != ''){
                  $.each(obj, function(key, val) {
               // alert(result);
                //$("#new_pd").hide();
               // $("input[name=new_barcode]").val(result);
               // $("input[name=new_detail]").select();
               if(val["status"]=="true"){
                var f = confirm(val["Messenger"]+"\n ต้องการเพิ่มสินค้าในรายการรับสินค้าหรือไม่?");
                if(f == true){
                  insert_product(val["barcode"]);
                  $("#new_pd").hide();
                }else{
                  $("#new_pd").hide();
                }
                
              $("input[name=new_barcode]").val("");
             $("input[name=new_detail]").val("");
             $("input[name=new_price]").val("");
             $("input[name=new_unit]").val("");
               }else{
                alert(val["Messenger"]);
                return false;
               }

             });
          }
            }); 
          }
         
         function save_new_group(){

             var cd = $("input[name=new_code_group]").val();
             var ng = $("input[name=new_name_group]").val();

          if(cd!="" && ng!=""){

         $.ajax({
         type: "POST",
         url: "mysql_warehouse.php",
         data: "submit=new_group&code="+cd+"&name="+ng ,
          cache: false,
          success: function(data){
            $("select[name=new_group]").append("<option value='" + cd + "'' >" + ng + "</option>");  
            $("select[name=new_group]").val(cd);
        }
      });

            $("#new_gp").hide();

            }else if(cd==""){
              $("input[name=new_code_group]").css({"background-color":"rgba(255,0,0,0.3)"});
              $("input[name=new_code_group]").select();
              $("input[name=new_name_group]").css({"background-color":"#ffffff"});
            }else if(ng==""){
              $("input[name=new_code_group]").css({"background-color":"#ffffff"});
              $("input[name=new_name_group]").css({"background-color":"rgba(255,0,0,0.3)"});
              $("input[name=new_name_group]").select();
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

<fieldset style="width:870px;border:1px solid #03A9F4;margin-left: 25px;background-color: #E1F5FE;">
<legend style="color:#03A9F4;">รายการรับสินค้า </legend>
<table width="850px" >
 <tr><td colspan="3"></td><td style="text-align: right;">เลขที่ใบส่งของ :</td><td><input type="text" name="nobill" id="nobill" autofocus style="width:100px;" onkeyup="if(event.which==13){$('#code_supply').focus();}"></td></tr>
 <tr><td colspan="3"></td><td style="text-align: right;">วันที่ :</td><td><input type="text" name="dateday" id="dateday" value="<?=$dateday?>" style="width:100px;text-align: center;"></td></tr>
 <tr><td>รับจาก</td><td><input type="text" name="code_supply" id="code_supply" style="width:50px;" onkeyup="if(event.which==13){$('#code_persanal').focus();}"></td><td colspan="3"><input type="text" name="name_supply" id="name_supply" style="width:685px;"></td></tr>
 <tr><td>รหัสพนักงาน</td><td><input type="text" name="code_persanal" id="code_persanal" style="width:50px;" onkeyup="if(event.which==13){$('#order_bill').focus();}"></td><td><input type="text" name="name_persanal" id="name_persanal" style="width:400px;"></td> <td>จากใบสั่งซื้อเลขที่</td><td ><input type="text" name="order_bill" id="order_bill" style="width:100px" onkeyup="if(event.which==13){ $('#barcode').focus();}"></td></tr>

  <tr><td>รหัส/สินค้า</td><td colspan='4'><input type="text" name="barcode" id="barcode" style="width:457px;float: left;height:25px;font-size: 18px;" onkeyup="barcode_tag()">
    <input type='hidden' name='detail' id='detail' ><input type='hidden' name='pcs' id='pcs' value='1'>
    <!-- <div class="button_menu" onclick="savebill()" ><img src="../images/menu/save_icon.png" style="width:24px;vertical-align: middle;" > สินค้าใหม่ </div>  -->
    <span  class="button_menu" style="font-size: 14px;color:#3b5998;" onclick="$('#new_pd').toggle();$('select[name=new_group]').focus();"><img src="../images/menu/plus.png" style="width:18px;vertical-align: middle;" > สินค้าใหม่</span>
  </td></tr> 
 </table>
</fieldset>
<div class="detail_show" id="detail_show" >
 <table width="880px" id="detail_table">
  <thead>
  <tr><td class='topbar' style='width:30px;'>#</td><td class='topbar' style='width:120px;'>รหัสสินค้า</td><td class='topbar' style='width:300px;'>สินค้า</td><td class='topbar' style='width:50px;'>จำนวน</td><td class='topbar' style='width:60px;'>ราคา/หน่วย</td><td class='topbar' style='width:50px;'>ราคารวม</td><td class='topbar' style='width:50px;'>คงเหลือ</td></tr>
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

<div id="new_pd" style="display:none;position:fixed;z-index:5;width:900px;height:480px;top:50%;margin-top:-200px;background-color: #f7f7f7;border:1px solid #e0e0e0;border-radius: 5px;left:50%;margin-left:-450px;box-shadow: 5px 5px 5px #909090;">
  <img src="../images/new_product.png" style="position: absolute;width:360px;margin-top: 40px;" >
  <div style="width:100%height:50px;text-align: center;font-size: 20px;font-weight: bold;margin-top: 25px;color: #01840e;">..:: เพิ่มสินค้าใหม่ ::..</div>
  <div style="text-align: center;margin-top: 25px;">
    <span style="width:120px;height:20px;display: inline-block;font-size: 17px;text-align: right;">กลุ่มสินค้า :</span>  <span style="width:100px;height:50px;display: inline-block;"><select name="new_group" style="width:250px;font-size: 17px;padding:10px 5px;" onkeyup="if(event.keyCode==27){$('#new_pd').hide();}" onchange="new_barocde_return(this.value);">
      <option value=''>เลือกกลุ่มสินค้า</option>
    <?
  $sql = "SELECT * from group_type  ORDER By code  ASC";
  $result = mysql_query($sql);
  while ($tx = mysql_fetch_array($result) ) {
    print "<option value='$tx[code]'>$tx[detail]</option>";
  }
    ?>
  </select>
  <span  class="button_menu" style="position:absolute;float:middle;font-size: 16px;color:#3b5998;margin-left: 220px;margin-top: -40px;" onclick="$('#new_gp').toggle()"> <img src="../images/menu/plus.png" style="width:18px;vertical-align: middle;" > เพิ่มกลุ่มสินค้า</span>
</span><br>
  <span style="width:120px;height:20px;display: inline-block;font-size: 17px;text-align: right;">รหัสสินค้า :</span>   <span style="width:100px;height:50px;display: inline-block;"><input type="text" name="new_barcode" style="width:250px;font-size: 17px;padding:10px 5px;" onkeyup="if(event.keyCode==13){ $('input[name=new_detail]').focus();}else if(event.keyCode==27){$('#new_pd').hide();}">  <span  class="button_menu" style="position:absolute;float:middle;font-size: 16px;color:#3b5998;margin-left: 220px;margin-top: -40px;" onclick="$('#add_qrcode').toggle();$('input[name=new_qrcode]').focus();"> <img src="../images/menu/plus.png" style="width:18px;vertical-align: middle;" > เพิ่มQRCode</span> </span><br>
  <div id="add_qrcode" style="display: none;">
   <span style="width:120px;height:20px;display: inline-block;font-size: 17px;text-align: right;">QR code :</span>   <span style="width:100px;height:50px;display: inline-block;"><input type="text" name="new_qrcode" style="width:250px;font-size: 17px;padding:10px 5px;" onkeyup="if(event.keyCode==13){ $('input[name=new_detail]').focus();}else if(event.keyCode==27){$('#new_pd').hide();}"> </span></div>


  <span style="width:120px;height:20px;display: inline-block;font-size: 17px;text-align: right;">รายการสินค้า :</span>  <span style="width:100px;height:50px;display: inline-block;"><input type="text" name="new_detail" style="width:250px;font-size: 17px;padding:10px 5px;" onkeyup="if(event.keyCode==13){ $('input[name=new_price]').focus();}else if(event.keyCode==27){$('#new_pd').hide();}"></span><br>
  <span style="width:120px;height:20px;display: inline-block;font-size: 17px;text-align: right;">ราคาสินค้า :</span>    <span style="width:100px;height:50px;display: inline-block;"><input type="text" name="new_price" style="width:250px;font-size: 17px;padding:10px 5px;" onkeyup="if(event.keyCode==13){ $('input[name=new_unit]').focus();}else if(event.keyCode==27){$('#new_pd').hide();}"></span><br>
  <span style="width:120px;height:20px;display: inline-block;font-size: 17px;text-align: right;">หน่วยนับ :</span>     <span style="width:100px;height:50px;display: inline-block;"><input type="text" name="new_unit" style="width:250px;font-size: 17px;padding:10px 5px;" onkeyup="if(event.keyCode==13){save_new_product();}else if(event.keyCode==27){$('#new_pd').hide();}"></span><br>


  <span style="width:170px;height:20px;display: inline-block;font-size: 17px;text-align: right;">
<span  class="button_menu" style="float:middle;font-size: 16px;color:#3b5998;" onclick="save_new_product()"><img src="../images/menu/save_icon.png" style="width:24px;vertical-align: middle;" > บันทึกสินค้าใหม่</span>   </span>
<span style="width:100px;height:20px;display: inline-block;font-size: 17px;text-align: right;">
<span  class="button_menu" style="float:middle;font-size: 16px;color:#3b5998;" onclick="$('#new_pd').toggle()"><img src="../images/menu/close_red.png" style="width:24px;vertical-align: middle;" > ยกเลิก</span>   </span>
  </div>

<div id='new_gp' style="display:none;position:fixed;z-index:5;width:900px;height:380px;top:50%;margin-top:-200px;background-color: #f7f7f7;border:1px solid #e0e0e0;border-radius: 5px;left:50%;margin-left:-450px;box-shadow: 5px 5px 5px #909090;">
  <img src="../images/group_icon.png" style="position: absolute;width:320px;margin-top: 40px;margin-left: 30px;" >
  <div style="width:100%height:50px;text-align: center;font-size: 20px;font-weight: bold;margin-top: 25px;color: #01840e;">..:: เพิ่มกลุ่มสินค้าใหม่ ::..</div>
  <div style="text-align: center;margin-top: 25px;">
 <span style="width:120px;height:20px;display: inline-block;font-size: 17px;text-align: right;">รหัสกลุ่ม :</span>   <span style="width:100px;height:50px;display: inline-block;"><input type="text" name="new_code_group" style="width:250px;font-size: 17px;padding:10px 5px;" onkeyup="if(event.keyCode==13){ $('input[name=new_name_group]').focus();}else if(event.keyCode==27){$('#new_gp').hide();}"></span><br>
  <span style="width:120px;height:20px;display: inline-block;font-size: 17px;text-align: right;">ชื่อกลุ่ม :</span>   <span style="width:100px;height:50px;display: inline-block;"><input type="text" name="new_name_group" style="width:250px;font-size: 17px;padding:10px 5px;" onkeyup="if(event.keyCode==13){ }else if(event.keyCode==27){$('#new_gp').hide();}"></span><br>

  <span style="width:170px;height:20px;display: inline-block;font-size: 17px;text-align: right;"></span>
<span style="width:250px;height:20px;display: inline-block;font-size: 17px;text-align: right;">
<span  class="button_menu" style="float:middle;font-size: 16px;color:#3b5998;" onclick="save_new_group()"><img src="../images/menu/save_icon.png" style="width:24px;vertical-align: middle;" > บันทึก</span>   

<span  class="button_menu" style="float:middle;font-size: 16px;color:#3b5998;" onclick="$('#new_gp').toggle()"><img src="../images/menu/close_red.png" style="width:24px;vertical-align: middle;" > ยกเลิก</span>   </span>
</div>
</div>

</div>
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

