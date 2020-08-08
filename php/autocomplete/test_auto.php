<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Autocomplete - Remote JSONP datasource</title>
  <link rel="stylesheet" href="../../css/jquery-ui-1.12.1.css">
  <style>
  .ui-autocomplete-loading {
    background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
  }
  </style>
  <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="../../js/jquery-1.11.1.js"></script>
  <script src="../../js/jquery-ui-1.12.1.js"></script>
  <script>
     $(function(){
    $("#birds").autocomplete({
        source: function(request,response){
            $.getJSON("autocomplete_search.php?submit=stock_product&keyword=" + request.term,function(data){
                if(data!=null){
                    response($.map(data, function(item){
                        return {
                            label: item.detail + " - " + item.pcs,
                            value: item.barcode,
                            //id: item.barcode
                        };
                    }));
                }
            });
        },
        select: function(event,ui){
            $("#log").html(ui.item.value);
        }
    });
});

  </script>
</head>
<body>
 
<div class="ui-widget">
  <label for="birds">Birds: </label>
  <input id="birds">
</div>
<input type="text" id="datebill">
 
<div class="ui-widget" style="margin-top:2em; font-family:Arial">
  Result:
  <div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
</div>
 
 <script type="text/javascript">
  $("#datebill").datepicker({ dateFormat: 'dd-mm-yy', isBuddhist: 'true', defaultDate: 'toDay',
              dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
 </script>
 
</body>
</html>