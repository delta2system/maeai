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
      function search_import1(ex){
            $("#show_hire thead tr").remove();
            var td ="<tr>";
                td = td + "<td style='text-align:center;height:40px;' class='top_bar'>#</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>วดป รับเอกสาร</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>วดป เอกสาร</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>ใบเสร็จ/ใบส่งของ</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>บริษัท/ร้านค้า</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>รายการสินค้า</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>จำนวน</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>ราคา/หน่วย</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>รวม</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>หมวด</td>";
                td = td + "<td style='text-align:center;' class='top_bar'>หน่วยเบิก</td>";
                td = td + "</tr>";
            $('#show_hire > thead:last').append(td);
             $("#show_hire tbody tr").remove();
            if(ex!=""){
      $.ajax({ 
                url: "return_detail.php" ,
                type: "POST",
                data: 'xTable=search_import2_report&data='+ex,
            })
            .success(function(result) { 
               //alert(result);
                var obj = jQuery.parseJSON(result);
                    if(obj != '')
                    {
                          //$("#myTable tbody tr:not(:first-child)").remove();
                         
                          var r=0;
                          $.each(obj, function(key, val) {
                            r++;
                            
                                   var tr = "<tr class='link_data' onclick=\"billoldorder('"+val["row_bill"]+"')\">";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+r+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+val["dateday"]+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+val["datesend"]+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+val["nobill_recipt"]+"</td>";
                                    tr = tr +  "<td style='text-align:left;' class='td_border'>&nbsp;"+val["company"]+"</td>";
                                    tr = tr +  "<td style='text-align:left;' class='td_border'>"+val["detail"]+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+val["pcs"]+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+val["price"]+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+(val["pcs"]*val["price"])+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+val["type_hire"]+"</td>";
                                    tr = tr +  "<td style='text-align:center;' class='td_border'>"+val["department"]+"</td>";
                                    tr = tr + "</tr>";
                                    $('#show_hire > tbody:last').append(tr);
                          });
                    }

            });   
        }
    }

       function billoldorder(rd){
           // window.location='import_verify1_print.php?row_bill='+rd;
             window.open('import_verify2_print.php?review=1&row_bill='+rd , '_blank');
        	//alert(rd);
        }
	</script>
</head>
<body>
<fieldset style="border-color:#0090ff;"><legend style='font-size:24px;color:#3995ff;'>.::ค้นหา ใบรับพัสดุนอกคลัง::.</legend>
<form name="B1" method="POST" action="">
    <table width="100%">
        <td>ค้นหา</td><td><input type="text" name="search_import" autofocus onkeyup="search_import1(this.value)"><input type='hidden' name='focus_row2' id='focus_row'></td>
        <td align="left"></td>
        <td style="width:50%;text-align: right;">
        <img src="../images/box_close.png" style='cursor: pointer;z-index:6;position: absolute;margin-left: -12px;margin-top: -83px;' onclick='$("#popup_search").hide();'>
       </td>
    </table>
</form>
</fieldset>
<div style="width:100%;height:72%;overflow: auto;">
<table id="show_hire" style='margin: 0px auto;width:100%;'>
    <thead>

    </thead>
    <tbody>
        
    </tbody>
</table>
</div>
</body>
</html>