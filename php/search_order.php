<?
session_start();
include("connect.inc");
?>
<!DOCTYPE html>
<html>
<head>
    <title>..::::..</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
     <style type="text/css">
     table{
        border-collapse: collapse;
     }

            .top_bar{
        border:1px solid #999;
        background-color: rgba(0,0,0,0.3);
    }
            .link_data:hover{
        background-color: rgba(255,0,0,0.3);
        cursor: pointer;
    }
    .td_border{
        border:1px solid #999;
    }

     </style>
    <script type="text/javascript">
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
           // window.location='theorder_V1_print.php?row_no='+rd;
           window.open('theorder_V1_print.php?review=1&row_no='+rd , '_blank');
            //alert(rd);
        }
    </script>
</head>
<body>
<fieldset style="border-color:#0090ff;"><legend style='font-size:24px;color:#3995ff;'>.::ค้นหาบันทึกข้อความอนุมัติจัดซื้อ::.</legend>
<form name="B1" method="POST" action="">
    <table width="100%">
        <td>ค้นหา</td><td><input type="text" name="search_hire" autofocus onkeyup="search_hire1(this.value)"><input type='hidden' name='focus_row2' id='focus_row'></td>
        <td align="left"></td>
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
</body>
</html>