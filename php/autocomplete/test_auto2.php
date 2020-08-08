<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/jquery-ui-1.12.1.css">
  <link rel="stylesheet" href="autocomplete.v.1.css">

 <script src="../../js/jquery-1.8.0.min.js"></script>
  <script src="../../js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
  <script src="autocomplete.v.1.js"></script>


<style>
* {
  box-sizing: border-box;
}

body {
  font: 16px Arial;  
}



input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}

input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}

</style>
</head>     
<body>

<h2>Autocomplete</h2>

<p>Start typing:</p>

<!--Make sure the form has the autocomplete function switched off:-->
<form autocomplete="off" action="/action_page.php">
  <div class="autocomplete" style="width:700px;">
    <input id="myInput" type="text" name="myCountry" placeholder="Country">
  </div>
  <input type="submit">
</form>
<input type="text" id="datebill">

<script>
function select_p(bc,th){
  $("#"+th).val(bc);
}
/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("myInput"),'submit=stock_product');





</script>

</body>
</html>
 <script type="text/javascript">

  $("#datebill").datepicker({ dateFormat: 'dd-mm-yy', isBuddhist: 'true', defaultDate: 'toDay',
              dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
 </script>