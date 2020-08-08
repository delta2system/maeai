<?
session_start();

//print_r($_SERVER);

include("connect.inc");

    $sql = "SELECT tbl_value from tbl_company WHERE tbl_title='company_name' ";
    list($company) = Mysql_fetch_row(Mysql_Query($sql));



?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>

  <style type="text/css">
        .button_menu{
      float: left;
      padding:5px 10px;
      border:1px solid #e0e0e0;
      cursor: pointer;
    }
     .button_menu:hover{
      background-color: #e0e0e0;
     }
     table{
      border-collapse: collapse;

     }
     td{
      padding: 5px;
     }
  </style>
</head>
<body>
  <center>
    <div style="width:350px;height:20px;color:#0066ff;font-size: 18px;padding:10px 0px;">เบิกจ่ายพัสดุ <?=$company?></div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;แผนก <select id="department" style="padding:10px;border:1px solid #a0a0a0;border-radius: 5px;font-size: 16px;text-align: center;" >
      <?
      $sql = "SELECT * from department where 1";
      $result = mysql_query($sql);
      while ($row = mysql_fetch_array($result) ) {
      echo "<option value='$row[code]'>$row[name]</option>";
}
      ?>
    </select><br>
    <!-- <div style="width:350px;height:40px;padding:10px;" id="display_status"></div> -->
    รหัสสินค้า <input type="text" id="barcode" autofocus onkeyup="if(event.keyCode==13){$('#pcs').focus();}" style="padding:10px;border:1px solid #a0a0a0;border-radius: 5px;font-size: 16px;text-align: center;" >
<br>
   &nbsp;&nbsp;&nbsp;&nbsp; จำนวน <input type="number" id="pcs" onkeyup="if(event.keyCode==13){handle_qrcode();}" style="padding:10px;border:1px solid #a0a0a0;border-radius: 5px;font-size: 16px;text-align: center;" >
   <table id="show_detail">
      <thead>
        <td style='text-align:center;border:1px solid #808080;background-color:#42f4a4;'>รายการ</td>
        <td style='text-align:center;border:1px solid #808080;background-color:#42f4a4;'>จำนวนเบิก</td>
        <td style='text-align:center;border:1px solid #808080;background-color:#42f4a4;'>จำนวนคงเหลือ</td>
        <td style='text-align:center;border:1px solid #808080;background-color:#42f4a4;'>วันหมดอายุ</td>
      </thead>
     <tbody></tbody>
   </table>
   </center>

</body>
</html>
<script type="text/javascript">
function del_subout(rd,dp,xs){

 

    $.ajax({
      type: "POST",
      url: "mysql_decode_substock.php",
      data: 'submit=del_sub_stock&row_id='+rd+'&department='+dp,
      cache: false,
      success: function(data)
        {
          $("#row_table"+xs).remove();
        }
      });


}

function handle_qrcode(){


    $.ajax({
      type: "POST",
      url: "mysql_decode_substock.php",
      data: 'submit=handle_qrcode&barcode='+$("#barcode").val()+'&pcs='+$("#pcs").val()+'&department='+$("#department").val(),
      cache: false,
      success: function(data)
        {
        var obj = jQuery.parseJSON(data);
        var x = document.getElementById("show_detail").rows.length;
        $.each(obj, function(key, val) {
          if(val["status"]=="1"){
                        var tr = "<tr  id='row_table"+x+"'>";
                        tr = tr + "<td style='border:1px solid #e0e0e0;'>"+val["detail"]+"</td>";
                        tr = tr + "<td style='border:1px solid #e0e0e0;text-align:center;'>"+val["pcs"]+"</td>";
                        tr = tr + "<td style='border:1px solid #e0e0e0;text-align:center;'>"+val["pcs_stock"]+" "+val["unit"]+"</td>";
                        tr = tr + "<td style='border:1px solid #e0e0e0;text-align:center;'> "+val["expire"]+"<span style='position:absolute;color:red;font-weight:bold;margin-left:5px;cursor:pointer;' onclick=\"del_subout('"+val["row_id"]+"','"+val["department"]+"','"+x+"')\" >&#10006;</span></td>";
                        tr = tr + "</tr>";
                         $('#show_detail > tbody:last').append(tr);
                        }else{
                          alert("พัสดุไม่มีในสต็อก");
                        }


                        });

                        // $('#show_detail').append(tr);
        // var obj = jQuery.parseJSON(data);
        // $.each(obj, function(key, val) {
          $("#barcode").val('');
          $("#pcs").val('');
          $("#barcode").focus();
        // });
      }

    });
//     $.ajax({
//       type: "POST",
//       url: "mysql_decode_substock.php",
//       data: 'submit=handle_qrcode&barcode='+$("#barcode").val()+'&pcs='+$("#pcs").val()+'&department='+$("#department").val();
//       cache: false,
//       success: function(data)
//         {
//           alert(data);
//         var obj = jQuery.parseJSON(data);
//         $.each(obj, function(key, val) {

//           // if(val["status"]=="Y"){
//           //   var status = "<input type='checkbox' checked onclick=\"checkpersonnel(this,'"+val["id"]+"')\" style='width:20px;height:20px;'>";
//           // }else{
//           //   var status = "<input type='checkbox' onclick=\"checkpersonnel(this,'"+val["id"]+"')\" style='width:20px;height:20px;'>";
//           // }
//         });

//   // $.ajax({
//   //     url: "mysql_decode_substock.php",
//   //     type: "POST",
//   //     data: 'submit=handle_qrcode&barcode='+$("#barcode").val()+'&pcs='+$("#pcs").val()+'&department='+$("#department").val();
//   //   })
//   //   .done(function(result) {
//   //       alert(result);
//   //      //console.log(json);
//   //     // ส่วนของการแสดงผลลัพธ์ที่ได้ เมื่อการทำงานถูกต้อง
//   //     var obj = jQuery.parseJSON(result);
//   //             if(obj != ''){
//   //               //$("#display_popup").show();
//   //                 $.each(obj, function(key, val) {
//   //                   // $("#display_status").html("<span style='color:#00b33c;'>"+val["detail"]+" คงเหลือ "+val["pcs_stock"]+" "+val["unit"]+"<br> <span style='color:red;'>หมดอายุ "+val["expire"]+"</span></span>");
//   //                   // $("#pcs").val('');
//   //                       var tr = "<tr>";
//   //                       tr = tr + "<td style='text-align:center;border:1px solid #808080;background-color:#42f4a4;'>"+val["detail"]+"</td>";
//   //                       tr = tr + "<td style='text-align:center;border:1px solid #808080;background-color:#42f4a4;'>"+val["pcs_stock"]+val["unit"]+"</td>";
//   //                       tr = tr + "<td style='text-align:center;border:1px solid #808080;background-color:#42f4a4;'> หมดอายุ "+val["expire"]+"</td>";
//   //                       tr = tr + "</tr>";
//   //     $('#show_detail').append(tr);
//   //                 });
//   //               }
//   //   })
//   //   .fail(function(error) {
   
//   //   //console.log("error", error);
//   //   // ในส่วนนี้จะทำงานเมื่อ มีการส่งค่าไปแล้ว มีข้อผิดพลาดเกิดขึ้น
//   //   });
//   }
// });
  }

</script>
