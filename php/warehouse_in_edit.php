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


    $sql_del = "DELETE FROM bill_real_edit WHERE ipaddress = '".$_SERVER['REMOTE_ADDR']."' "; 
    $query = mysql_query($sql_del) or die(mysql_error());
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
      background-color:#f0f0f0;
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
     .cursor_p{
      cursor:pointer;
     }
     .cursor_p:hover{
      background-color:#8b9dc3; 
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
  // window.onbeforeunload = confirmExit;
  // function confirmExit()
  // {
  //   return "คุณต้องการปิดหน้าต่างนี้ ใช่ไหม";
  //  // return "คุณต้องการปิดหน้าต่างนี้ ใช่ไหม";
  // }

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
  if(keycode==123){
    var r = prompt("กรุณาใส่จำนวนสินค้า");
    if(r != null){
      $("input[name=pcs]").val(r);
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
                  data = data + "&nobill_system="+$("input[name=nobill_system]").val();
                  var rx = $("input[name=nobill_system]").val();  
            $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=insert_product_edit'+data,
            })
            .success(function(result) {
                return_bill(rx);
            });  
            }

          //   function return_bill(){
          //   $.ajax({ 
          //       url: "mysql_warehouse.php" ,
          //       type: "POST",
          //       data: 'submit=return_bill&status=INV',
          //   })
          //   .success(function(result) {
          //     //alert(result);
          //      $("#detail_table tbody tr").remove();
          //     var obj = jQuery.parseJSON(result);
          //     if(obj != ''){
          //     var r=0;
          //     var F_total=0;
          //         $.each(obj, function(key, val) {
          //         r++; 
          //         var tr = "<tr><td style='text-align:center;' class='border_bt'>"+r+"</td>";
          //         tr = tr +  "<td style='text-align:center;' class='border_bt'>"+val["barcode"]+"</td>";
          //         tr = tr +  "<td class='border_bt'>"+val["detail"]+"</td>";
          //         tr = tr +  "<td style='text-align:center;' class='border_bt'><input type='text' id='pcs"+r+"' value='"+val["pcs"]+"' style='width:98%;border:0px solid #000000;text-align:right;' onkeyup=\"set_value('"+val["row_id"]+"','pcs','"+r+"',this.value)\" onclick=\"this.select();\"></td>";
          //         tr = tr +  "<td style='text-align:center;' class='border_bt'><input type='text' id='price"+r+"' value='"+val["price"]+"' style='width:98%;border:0px solid #000000;text-align:center;' onkeyup=\"set_value('"+val["row_id"]+"','price','"+r+"',this.value)\"></td>";
          //         tr = tr +  "<td style='text-align:right;' class='border_bt'>"+addCommas(val["total"].toFixed(2))+"&nbsp;&nbsp;</td>";
          //         tr = tr +  "<td style='text-align:right;' class='border_bt'>"+addCommas(val["stock_total"].toFixed(2))+"&nbsp;<span style='margin-top:-20px;color:red;cursor:pointer;' onclick=\"del_row('"+val["row_id"]+"')\">&#8855;</span></td>";
          //         tr = tr + "</tr>";
          //                            //alert(tr);
          //         $('#detail_table tbody').append(tr);
          //         $('#code_supply').val(val["code_supply"]);
          //         $('#code_persanal').val(val["code_persanal"]);
          //         $('#name_supply').val(val["name_supply"]);
          //         $('#name_persanal').val(val["name_persanal"]);
          //         $('#nobill').val(val["nobill"]);
          //         $('#order_bill').val(val["creditor_bill"]);
                  
          //         F_total = parseFloat(F_total) + parseFloat(val["total"]);
                  
          //        });
          //         //alert(F_total);
          //                 var objDiv = document.getElementById("detail_show");
          //                 objDiv.scrollTop = objDiv.scrollHeight;
          //           //alert(objDiv.scrollHeight);

          //         $("#Ftotal").html(addCommas(F_total.toFixed(2)));
          //   }else{
          //         $("#Ftotal").html("");
          //   }
          // });

          //   }
            function del_row(id){
              var rx = $("input[name=nobill_system]").val();  
              $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=del_billreal_rowedit&row_id='+id,
            }).success(return_bill(rx));
            }

            function set_value(row_id,ty,row,value){
              var rx = $("input[name=nobill_system]").val();  
               var keycode;
               if (window.event) keycode = window.event.keyCode; //*** for IE ***//
               else if (e) keycode = e.which; //*** for Firefox ***//
              
              if(keycode==13){
              if(ty=="pcs"){
                $("#price"+row).select();
              }else if(ty=="price"){
                $("#barcode").focus();
                return_bill(rx);
              }
              //else{
                //$("#barcode").focus();
                //return_bill(rx);
              //}
              
            }
          $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=set_value_edit&row_id='+row_id+"&tbl="+ty+"&value="+value,
            })
            .success(function(result) {});
                
            }




          function savebill(){
          $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=save_in_edit&status=INV&customer_id='+$("#code_supply").val()+'&customer_name='+$("#name_supply").val()+'&persanal_id='+$("#code_persanal").val()+'&nobill='+$("#nobill").val()+'&order_bill='+$("#order_bill").val()+'&dateday='+$("#dateday").val()+'&nobill_system='+$("input[name=nobill_system]").val(),
            }).success(function(result) {
              //  alert(result);
              window.open("bill1_print.php?nobill="+$("input[name=nobill_system]").val(),'_blank');
             window.location='warehouse_in_edit.php';
            });
          }

           function cancelbill(){
             var n = confirm("ต้องการยกเลิกบิลนี้ใช่หรือไม่?");
          if(n==true){
              $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=cancel_bill_in&status=INV&nobill_system='+$("input[name=nobill_system]").val(),
            }).success(function(result) {
              window.location='warehouse_in_edit.php';
            });
          
            }else{
          //     return false
            }
          }

            
// start edit zone

function switch_ch(tx){
    
    if(tx=="dateday"){
      $("#search_in").html("<input type='text' name='tbl_search' id='tbl_search' style='font-size: 16px;padding:10px 5px;width:300px;' onkeyup=\"keyx(event)\">"); 
      $("#tbl_search").datepicker({ dateFormat: 'dd-mm-yy', isBuddhist: 'true', defaultDate: 'toDay',
              dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
    }else{
      $("#search_in").html("<input type='text' name='tbl_search'  style='font-size: 16px;padding:10px 5px;width:300px;' onkeyup=\"keyx(event)\">");
    }
  }

  function keyx(e) {
  var keycode;
  if (window.event) keycode = window.event.keyCode; //*** for IE ***//
  else if (e) keycode = e.which; //*** for Firefox ***//
  if(keycode==13)
  {
    search1();
  }
}

   function search1(){
   $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=warehousein_edit&tbltable='+$("select[name=tbl_data]").val()+"&tbldata="+$("input[name=tbl_search]").val(),
            })
            .success(function(result) {
                //alert(result);
              $("#detail_table_edit tbody tr").remove();
             var obj = jQuery.parseJSON(result);
              if(obj != ''){
                   $.each(obj, function(key, val) {
                  var tr = "<tr class='cursor_p' onclick=\"edit('"+val["nobill_system"]+"')\">";
                  tr = tr +  "<td style='text-align:center;' class='border_bt'>"+val["nobill"]+"</td>";
                  tr = tr +  "<td class='border_bt' style='text-align:center;'>"+val["nobill_recipt"]+"</td>";
                  tr = tr +  "<td class='border_bt' style='text-align:center;'>"+val["dateday"]+"</td>";
                  tr = tr +  "<td class='border_bt'>&nbsp;&nbsp;"+val["customer_name"]+"</td>";
                  tr = tr +  "<td class='border_bt' style='text-align:center;'>"+val["barcode"]+"</td>";
                  tr = tr +  "<td class='border_bt'>&nbsp;&nbsp;"+val["detail"]+"</td>";
                  tr = tr +  "<td class='border_bt' style='text-align:right;'>"+val["pcs"]+"&nbsp;&nbsp;</td>";
                  tr = tr +  "<td class='border_bt' style='text-align:right;'>"+val["price"]+" ฿&nbsp;</td>";
                  tr = tr + "</tr>";
                                    // alert(tr);
                   $('#detail_table_edit tbody').append(tr);

                  
                });

            }else{
                    var tr = "<tr><td colspan='8' style='text-align:center;color:red;font-weight:bold;'>.::::::::::ไม่มีข้อมูล::::::::::.</td>";
                   $('#detail_table_edit tbody').append(tr);
            }
         });



}

          function return_bill(nr){
            $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=return_bill_edit&status=INV&bill='+nr,
            })
            .success(function(result) {
             // alert(result);
              var r=0;
              var F_total=0;
              
            $("#detail_table tbody tr").remove();
               var obj = jQuery.parseJSON(result);
               if(obj != ''){
              var r=0;
              var F_total=0;
                  $.each(obj, function(key, val) {

               r++; 
                   var tr = "<tr><td style='text-align:center;' class='border_bt'>"+r+"</td>";
                   tr = tr +  "<td style='text-align:center;' class='border_bt'>"+val["barcode"]+"</td>";
                   tr = tr +  "<td class='border_bt'>&nbsp;&nbsp;"+val["detail"]+"</td>";
                   tr = tr +  "<td style='text-align:center;' class='border_bt'><input type='text' id='pcs"+r+"' value='"+val["pcs"]+"' style='padding-right:10px;width:85%;border:0px solid #000000;text-align:right;' onkeyup=\"set_value('"+val["row_id"]+"','pcs','"+r+"',this.value)\" onclick=\"this.select();\" ></td>";
                  tr = tr +  "<td style='text-align:center;' class='border_bt'><input type='text' id='price"+r+"' value='"+val["price"]+"' style='padding-right:10px;width:85%;border:0px solid #000000;text-align:right;' onkeyup=\"set_value('"+val["row_id"]+"','price','"+r+"',this.value)\" ></td>";
                  tr = tr +  "<td style='text-align:right;' class='border_bt'><span id='total_x"+r+"'>"+addCommas((val["pcs"]*val["price"]).toFixed(2))+"</span>&nbsp;&nbsp;&nbsp;<span style='margin-top:-20px;color:red;cursor:pointer;' onclick=\"del_row('"+val["row_id"]+"')\">&#8855;</span></td>";
                  //tr = tr +  "<td style='text-align:right;' class='border_bt'>"+addCommas(val["pcs_stock"])+"&nbsp;</td>";
                   tr = tr + "</tr>";
            // //                          //alert(tr);
                $('#detail_table tbody').append(tr);
                $('#display_search').hide();
                  $('input[name=nobill_system]').val(val["nobill_system"]);
                  $('#code_supply').val(val["code_supply"]);
                  $('#code_persanal').val(val["code_persanal"]);
                  $('#name_supply').val(val["name_supply"]);
                  $('#name_persanal').val(val["name_persanal"]);
                  $('#nobill').val(val["nobill"]);
                  $('#order_bill').val(val["nobill_recipt"]);
                  $('#dateday').val(val["dateday"]);
                  
                  F_total = parseFloat(F_total) + parseFloat(val["total"]);

                  });
                   $("#Ftotal").html(addCommas(F_total.toFixed(2)));
             }else{
                   $("#Ftotal").html("");
            }
          //});
               // }
            });
          }

          function edit(rx){
      // var px = $("input[name=permit_edit]").val();
      // if(px==1){
      $("input[name=edit_row]").val(rx);  
      $( "#detail_show_edit" ).on( "click", function( event ) {
        //$( "#log" ).text( "pageX: " + event.pageX + ", pageY: " + event.pageY );
        $("#small_menu").css({"left": event.pageX+"px","top": event.pageY+"px"});
        $("#small_menu").show();
      });
      //}
    }

    function edit_show(){
      var rx = $("input[name=edit_row]").val();  
      $.ajax({ 
                url: "mysql_warehouse.php" ,
                type: "POST",
                data: 'submit=return_billreal_edit&status=INV&bill='+rx,
            })
      .success(function(result) {
      return_bill(rx);
      });
    
      $("#small_menu").hide();
      $("#display_show_edit").show();
    }
//end EditZone

  </script>
</head>
<body>
  <div id="small_menu" style="display:none;position: absolute;width:100px;">
    <div class="button_menu" style="width:80px;padding:3px 20px;" onclick="edit_show()">แก้ไข <input type="hidden" name="edit_row"></div>
<!--     <div class="button_menu" style="width:80px;padding:3px 20px;" onclick="delproduct_show()">ลบ</div> -->
    <div class="button_menu" style="width:80px;padding:3px 20px;background-color: #fcb3b3;" onclick="$('#small_menu').toggle()">ปิด</div>
  </div>
  <center>

<div id="display_search" style="display">
<fieldset style="width:870px;margin-left: 25px;border:1px solid #6600ff;background-color: #e0ccff;">
<legend style="color:#6600ff;font-size: 21px;background-color: #ffffff">แก้ไขรายการรับพัสดุ </legend>
<table>
 <tr><td><select name='tbl_data' style='font-size: 16px;padding:10px 20px;' onchange="switch_ch(this.value)">
   <option value='nobill'>เลขที่ใบส่งของ</option>
   <option value='nobill_recipt'>เลขที่ใบสั่งซื้อ</option>
   <option value='dateday'>วันที่</option>
   <option value='customer_name'>ร้านค้า</option>
   <option value='barcode'>รหัสสินค้า</option>
   <option value='detail'>สินค้า</option>
 </select></td><td>
  <span id='search_in'>
   <input type="text" name="tbl_search" style='font-size: 16px;padding:10px 5px;width:300px;' onkeyup="keyx(event)">
 </span>
 </td>

   <td><button class="button_menu" style="font-size:16px;padding:10px 20px;" onclick="search1()">ค้นหา</button></td>
 </table>
</fieldset>
<div id="detail_show_edit" style="width:100%;">
<table style="width:98%;" id="detail_table_edit">
  <thead>
  <td class="topbar">เลขที่ใบส่งของ</td>
  <td class="topbar">เลขที่ใบสั่งซื้อ</td>
  <td class="topbar">วันที่</td>
  <td class="topbar">ร้านค้า</td>
  <td class="topbar">รหัสสินค้า</td>
  <td class="topbar">รายการสินค้า</td>
  <td class="topbar">จำนวน</td>
<!--   <td class="topbar">หน่วยนับ</td> -->
  <td class="topbar">ราคา</td>
  </thead>
  <tbody>
    
  </tbody>
</table>
</div>
</div>



  <div id="display_show_edit" style="display:none;">
  <center>
  <div id="menu_bar" style="width:850px;height:20px;">
  <div class="button_menu" onclick="savebill()"><img src="../images/menu/save_icon.png" style="width:24px;vertical-align: middle;" > บันทึก </div> 
  <div class="button_menu" onclick="cancelbill()"><img src="../images/menu/close_red.png" style="width:24px;vertical-align: middle;" > ยกเลิก </div>  </div>
<br>

<fieldset style="width:870px;border:1px solid #03A9F4;margin-left: 25px;background-color: #E1F5FE;">
<legend style="color:#03A9F4;">แก้ไขรายการรับสินค้า </legend>
<table width="850px" >
 <tr><td colspan="3"><input type="hidden" name="nobill_system"></td><td style="text-align: right;">เลขที่ใบส่งของ :</td><td><input type="text" name="nobill" id="nobill" autofocus style="width:100px;text-align:center;" onkeyup="if(event.which==13){$('#code_supply').focus();}"></td></tr>
 <tr><td colspan="3"></td><td style="text-align: right;">วันที่ :</td><td><input type="text" name="dateday" id="dateday" value="" style="width:100px;text-align: center;"></td></tr>
 <tr><td>รับจาก</td><td><input type="text" name="code_supply" id="code_supply" style="width:50px;" onkeyup="if(event.which==13){$('#code_persanal').focus();}"></td><td colspan="3"><input type="text" name="name_supply" id="name_supply" style="width:685px;"></td></tr>
 <tr><td>รหัสพนักงาน</td><td><input type="text" name="code_persanal" id="code_persanal" style="width:50px;" onkeyup="if(event.which==13){$('#order_bill').focus();}"></td><td><input type="text" name="name_persanal" id="name_persanal" style="width:400px;"></td> <td>จากใบสั่งซื้อเลขที่</td><td ><input type="text" name="order_bill" id="order_bill" style="width:100px" onkeyup="if(event.which==13){ $('#barcode').focus();}"></td></tr>

  <tr><td>รหัส/สินค้า</td><td colspan='4'><input type="text" name="barcode" id="barcode" style="width:457px;float: left;height:25px;font-size: 18px;" onkeyup="barcode_tag()">
    <input type='hidden' name='detail' id='detail' ><input type='hidden' name='pcs' id='pcs' value='1'>
  </td></tr> 
 </table>
</fieldset>
<div class="detail_show" id="detail_show" >
 <table width="880px" id="detail_table">
  <thead>
  <tr><td class='topbar' style='width:30px;'>#</td><td class='topbar' style='width:120px;'>รหัสสินค้า</td><td class='topbar' style='width:300px;'>สินค้า</td><td class='topbar' style='width:50px;'>จำนวน</td><td class='topbar' style='width:60px;'>ราคา/หน่วย</td><td class='topbar' style='width:50px;'>ราคารวม</td></tr>
</thead>
<tbody></tbody>
 </table>

 </div>
 <div style="width:850px;padding-top:10px;">
 <div style="width:700px;height:30px;text-align: right;float: left;border-bottom:0px solid #a0a0a0;">รวมเป็นเงิน &nbsp;&nbsp;</div>
 <div style="width:140px;height:30px;text-align: right;padding-right:10px;float: left;border-bottom:2px double #a0a0a0;font-weight: bold;" id="Ftotal"></div>
</div>
</center>


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
//return_bill();
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

