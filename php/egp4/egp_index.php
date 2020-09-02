<?
session_start();
include("../connect.inc");
$sql = "SELECT * from tbl_company WHERE 1";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {
$co[$row["tbl_title"]]=$row["tbl_value"];
}

//print_r($co);
function num_convertthai($str){
$numthai = array("๑","๒","๓","๔","๕","๖","๗","๘","๙","๐");
$numarabic = array("1","2","3","4","5","6","7","8","9","0");
return str_replace($numarabic,$numthai,$str);
}

function num_convertbric($str){
$numthai = array("๑","๒","๓","๔","๕","๖","๗","๘","๙","๐");
$numarabic = array("1","2","3","4","5","6","7","8","9","0");
return str_replace($numthai,$numarabic,$str);
}

$sql = "SELECT * from egp_title WHERE row_id = '1'";
$result = mysql_query($sql);
$data = mysql_fetch_assoc($result);

// $data["supply_name"] = "ร้านฝางธุรกิจ";
// $data["supply_addres"] = "เลขที่ ๔๕ หมู่ ๓ ตําบลเวียง อําเภอฝาง จังหวัดเชียงใหม่ ๕๐๑๑๐" ;
// $data["supply_phone"] = "๐๕๓๔๕๑๒๘๗";
// $data["supply_tax"] = "๓๕๐๐๙๐๐๘๕๙๒๔๕";

// $data["product"] = "๑.ดินน้ำมัน จำนวน ๒๐ ก้อนๆละ ๖ บาท <br>
//     ๒.ซองสีน้ำตาลขนาด A๔ จำนวน ๓๐๐ ซองๆละ ๕ บาท <br>
//     ๓. สติกเกอร์ใส จำนวน ๕๐ แผ่นๆละ ๒๐ บาท <br>
//     ๔.เทปตีเส้น จำนวน ๑๐ ม้วนๆละ ๑๕ บาท <br>
//     ๕.กระดาษ FAX จำนวน ๔ ม้วนๆละ ๖๐ บาท <br>
//     ๖.เทปใส ๑/๒ นิ้ว จำนวน ๖๐ ม้วนๆะ ๒๕ บาท <br>
//     ๗. กระดาษการ์ดสี ขนาด A๔ จำนวน ๓๐ รีมๆละ ๑๑๐ บาท <br>
//     ๘.แผ่นเคลือบ A๔ ขนาด ๑๐๐ แผ่นๆละ ๔.๕๐ บาท <br>
//     ๙.เทปกาว ๒ หน้าแบบหนา จำนวน ๒ ม้วนๆละ ๒๘๐ บาท <br>";

// $data["no"] ="ชม.๐๐๓๒.๓๐๑/๖๒๐๒๑๘";
// $data["no_requat"] ="๙๘๖/๒๕๖๒";
// $data["dateday1"] = "๑๔ พฤษภาคม ๒๕๖๒";
// $data["dateday2"] = "๑๕ พฤษภาคม ๒๕๖๒";
// $data["pcs_detail"] = "จัดซื้อวัสดุสำนักงาน ๙ รายการ";
// $data["total_bath"] = "๕,๕๐๐.๐๐";
// $data["total_bath_word"] = "ห้าพันห้าร้อยบาทถ้วน";

// $data["office01"] = "(นางบุษบา ว่องไว)<br>เจ้าหน้าที่";
// $data["office02"] = "(นางสาวเสงี่ยม ทรงวัย)<br>หัวหน้าเจ้าหน้าที่";
// $data["director"] = "(นายวิชญ์ สิริโรจย์พร)<br>ผู้อำนวยการโรงพยาบาลฝาง<br>ปฏิบัติราชการแทนผู้ว่าราชการจังหวัดเชียงใหม่";

// $data["supply_name"];
// $data["supply_addres"];
// $data["supply_phone"];
// $data["supply_tax"];
// $data["product"];
// $data["no"];
// $data["no_requat"];
// $data["dateday1"];
// $data["dateday2"];
// $data["pcs_detail"];
// $data["total_bath"];
// $data["total_bath_word"];

// $data["office01"];
// $data["office02"];
// $data["director"];

?>
<!DOCTYPE html>
<html>
<head>
	<title>ใบสั่งซื้อสั่งจ้าง</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link type="text/css" href="../../fonts/thsarabumnew.css" rel="stylesheet" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../dashboard/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../dashboard/bower_components/font-awesome/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<style type="text/css">
	@import url(../../fonts/thsarabunnew.css);
  body{ font-family: 'THSarabunNew', sans-serif; font-size: 14px; line-height: 2.1em; background: #e1e1e1; }
  .div_hover:hover{
    background-color: rgba(0, 102, 255,0.5);
    cursor: pointer;
  }
  .top_bar{
    border:1px solid #c0c0c0;
    text-align: center;
    background-color:#f0f0f0;
  }
  .cal_1{
    padding:2px;
    border:1px solid #c0c0c0;
    border-radius: 5px;
    width:100%;
  }
</style>
<script type="text/javascript">

function thaiNumber(num){
 var array = {"1":"๑", "2":"๒", "3":"๓", "4" : "๔", "5" : "๕", "6" : "๖", "7" : "๗", "8" : "๘", "9" : "๙", "0" : "๐"};
 var str = num.toString();
 for (var val in array) {
  str = str.split(val).join(array[val]);
 }
 return str;
}


  function search_old(){
    var search = $("#search").val();

  $.ajax({
      type: "POST",
      url: "mysql_egp.php",
      data: "submit=search&search="+$("#search").val()+"&type="+$("#type_colum").val() ,
      cache: false,
      success: function(data)
        {
         // alert(data);
         $("#search_detail").append(data);
        }         
     });


  }

  function del_table(str){
   $("#row_table"+str).remove();
  }

  function plus_detail(){
        var x = document.getElementById("product_table").rows.length;
    var td = "<tr id='row_table"+x+"'>";
        td = td + "<td><input type='text' name='num[]' class='form-control' value='" + $("#num").val() + "'></td>";
        td = td + "<td><input type='hidden' name='barcode[]' class='form-control' value='" + $("#barcode").val() + "'>";
        td = td + "<input type='text' name='detail[]' class='form-control' value='" + $("#detail").val() + "'></td>";
        td = td + "<td><input type='text' name='pcs[]' class='form-control' value='" + $("#pcs").val() + "'</td>";
        td = td + "<td><input type='text' name='unit[]' class='form-control' value='" + $("#unit").val() + "'></td>";
        td = td + "<td><input type='text' name='price[]' class='form-control' value='" + $("#price").val() + "'></td>";
        td = td + "<td><input type='text' name='total[]' class='cal_1'  style='text-align:center;' value='" + $("#total").val() + "'>";
        td = td + "<span style='position:absolute;color:red;font-weight:bold;margin-left:5px;cursor:pointer;' onclick=\"del_table("+x+")\">&#10006;</span></td>";

        $('#product_table > thead:last').append(td);

       //  document.getElementById("product_table").deleteRow(0);
       
       // document.getElementById("demo").innerHTML = "Found " + x + " cells in the first tr element.";
      // alert(x);
        if($("#num").val()){
          $("#num").val(parseFloat($("#num").val())+1);
        }
        
        $("#barcode").val("");
        $("#detail").val("");
        $("#pcs").val("");
        $("#unit").val("");
        $("#price").val("");
        $("#total").val("");
        $("#detail").focus();



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

  function cal_pcs(){
    var x1 = parseFloat($("#pcs").val());   if ( isNaN(x1)){x1 = 0;}
    var x2 = parseFloat($("#price").val());   if ( isNaN(x2)){x2 = 0;}
    $("#total").val((x1*x2).toFixed(2));
    var t1 = (parseFloat(calculateSum('cal_1'))+parseFloat(x1*x2)).toFixed(2);
    var tot = thaiNumber(addCommas(t1));
    $("input[name=total_bath_word]").val(ThaiBaht(t1));
    $("input[name=total_bath]").val(tot);
   }

     function calculateSum(cl) {

    var sum = 0;
    //iterate through each textboxes and add the values
    $("."+cl).each(function() {

      //add only if the value is number
      if(!isNaN(this.value) && this.value.length!=0) {
        sum += parseFloat(this.value);
      }

    });
    //.toFixed() method will roundoff the final sum to 2 decimal places
    //$("#sum").html(sum.toFixed(2));
    return sum.toFixed(2);
  }


  function ThaiBaht(Number)
{
  //ตัดสิ่งที่ไม่ต้องการทิ้งลงโถส้วม
  for (var i = 0; i < Number.length; i++)
  {
    Number = Number.replace (",", ""); //ไม่ต้องการเครื่องหมายคอมมาร์
    Number = Number.replace (" ", ""); //ไม่ต้องการช่องว่าง
    Number = Number.replace ("บาท", ""); //ไม่ต้องการตัวหนังสือ บาท
    Number = Number.replace ("฿", ""); //ไม่ต้องการสัญลักษณ์สกุลเงินบาท
  }
  //สร้างอะเรย์เก็บค่าที่ต้องการใช้เอาไว้
  var TxtNumArr = new Array ("ศูนย์", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า", "สิบ");
  var TxtDigitArr = new Array ("", "สิบ", "ร้อย", "พัน", "หมื่น", "แสน", "ล้าน");
  var BahtText = "";
  //ตรวจสอบดูซะหน่อยว่าใช่ตัวเลขที่ถูกต้องหรือเปล่า ด้วย isNaN == true ถ้าเป็นข้อความ == false ถ้าเป็นตัวเลข
  if (isNaN(Number))
  {
    return "ข้อมูลนำเข้าไม่ถูกต้อง";
  } else
  {
    //ตรวสอบอีกสักครั้งว่าตัวเลขมากเกินความต้องการหรือเปล่า
    if ((Number - 0) > 9999999.9999)
    {
      return "ข้อมูลนำเข้าเกินขอบเขตที่ตั้งไว้";
    } else
    {
      //พรากทศนิยม กับจำนวนเต็มออกจากกัน (บาปหรือเปล่าหนอเรา พรากคู่เขา)
      Number = Number.split (".");
      //ขั้นตอนต่อไปนี้เป็นการประมวลผลดูกันเอาเองครับ แบบว่าขี้เกียจจะจิ้มดีดแล้ว อิอิอิ
      if (Number[1].length > 0)
      {
        Number[1] = Number[1].substring(0, 2);
      }
      var NumberLen = Number[0].length - 0;
      for(var i = 0; i < NumberLen; i++)
      {
        var tmp = Number[0].substring(i, i + 1) - 0;
        if (tmp != 0)
        {
          if ((i == (NumberLen - 1)) && (tmp == 1))
          {
            BahtText += "เอ็ด";
          } else
          if ((i == (NumberLen - 2)) && (tmp == 2))
          {
            BahtText += "ยี่";
          } else
          if ((i == (NumberLen - 2)) && (tmp == 1))
          {
            BahtText += "";
          } else
          {
            BahtText += TxtNumArr[tmp];
          }
          BahtText += TxtDigitArr[NumberLen - i - 1];
        }
      }
      BahtText += "บาท";
      if ((Number[1] == "0") || (Number[1] == "00"))
      {
        BahtText += "ถ้วน";
      } else
      {
        DecimalLen = Number[1].length - 0;
        for (var i = 0; i < DecimalLen; i++)
        {
          var tmp = Number[1].substring(i, i + 1) - 0;
          if (tmp != 0)
          {
            if ((i == (DecimalLen - 1)) && (tmp == 1))
            {
              BahtText += "เอ็ด";
            } else
            if ((i == (DecimalLen - 2)) && (tmp == 2))
            {
              BahtText += "ยี่";
            } else
            if ((i == (DecimalLen - 2)) && (tmp == 1))
            {
              BahtText += "";
            } else
            {
              BahtText += TxtNumArr[tmp];
            }
            BahtText += TxtDigitArr[DecimalLen - i - 1];
          }
        }
        BahtText += "สตางค์";
      }
      return BahtText;
    }
  }
}
</script>
</head>
<body>
<!--   <div id="body">
  <section class="content" style="margin:0px auto;width:210mm;background-color: #ffffff;">

      <div class="row">


<div style="margin:0px auto;width:210mm;background-color: #ffffff;" class="page_breck">
</div>
</div>
</section>

</div>
 -->
 <div style="margin:0px auto;width:210mm;background-color: #ffffff;padding: 20px;" class="page_breck">
<div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">PROCUREMENT ใบจัดซื้อจัดจ้าง นอกคลัง</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form"   name="a1" id="a1" method="post" enctype="multipart/form-data"  action="mysql_egp.php" >
                <!-- text input -->
                <div class="form-group">
                  <label>ที่</label>
                  <input type="text" name="no" class="form-control" value="<?=$data[no]?>">
                </div>
                <div class="form-group">
                  <label>เลขที่คำสั่ง</label>
                  <input type="text" name="no_requat" class="form-control" value="<?=$data[no_requat]?>">
                </div>
                <div class="form-group">
                  <label>วันที่ 1</label>
                  <input type="text" name="dateday1" class="form-control" value="<?=$data[dateday1]?>">
                </div>
                <div class="form-group">
                  <label>วันที่ 2</label>
                  <input type="text" name="dateday2" class="form-control" value="<?=$data[dateday2]?>">
                </div>
                <div class="form-group">
                  <label>ประเภทการจัดซื้อ/จัดจ้าง</label>
                  <!-- <input type="text" name="dateday2" class="form-control" value="<?=$data[dateday2]?>"> -->
                  <select class="form-control" name="group_type">
                    <?
                    $strSQL_store="SELECT * FROM hire_type WHERE 1";
                    $result_store=mysql_query($strSQL_store);
                    while ($sty = mysql_fetch_array($result_store)) {
                      echo "<option value='$sty[row_id]'>$sty[detail]</option>";
                    }
                    // $strSQL_store="SELECT * FROM store_type WHERE 1";
                    // $result_store=mysql_query($strSQL_store);
                    // while ($sty = mysql_fetch_array($result_store)) {
                    //   echo "<option value='$sty[code]'>$sty[detail]</option>";
                    // }


                    ?>
                  </select>
                </div>
                                <div class="form-group">
                  <label>แผนก</label>
                  <!-- <input type="text" name="dateday2" class="form-control" value="<?=$data[dateday2]?>"> -->
                  <select class="form-control" name="department">
                    <option></option>
                    <?
                    $strSQL_store="SELECT * FROM department WHERE 1";
                    $result_store=mysql_query($strSQL_store);
                    while ($sty = mysql_fetch_array($result_store)) {
                      echo "<option value='$sty[row_id]'>$sty[name]</option>";
                    }

                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>จำนวนรายการสินค้า</label>
                  <input type="text" name="pcs_detail" class="form-control" value="<?=$data[pcs_detail]?>">
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>สินค้า</label>

                  <!-- <textarea name="product" class="form-control" rows="3" ><?=str_ireplace("<br>","", $data[product])?></textarea> -->
                  <table style="width:100%;" id="product_table">
                    <thead>
                      <th class="top_bar" style="width:40px;">ลำดับ</th>
                      <th class="top_bar">รายการ</th>
                      <th class="top_bar" style="width:100px;">จำนวน</th>
                      <th class="top_bar" style="width:60px;">หน่วย</th>
                      <th class="top_bar" style="width:100px;">ราคา</th>
                      <th class="top_bar" style="width:100px;">รวมเงิน</th>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                      <td><input type="text" id="num" value='1' class="form-control"></td>
                      <td><input type="hidden" id="barcode" class="form-control">
                          <input type="text" id="detail" class="form-control"  onkeyup="if(event.keyCode==13){$('#pcs').select();}">
                      </td>
                      <td><input type="text" id="pcs" class="form-control" onkeyup="cal_pcs();if(event.keyCode==13){$('#price').select();}"></td>
                      <td><input type="text" id="unit" class="form-control"></td>
                      <td><input type="text" id="price" class="form-control" onkeyup="cal_pcs();if(event.keyCode==13){plus_detail();}"></td>
                      <td><input type="text" id="total" class="form-control"></td>
                      <tr>
                      <td colspan="6" style="text-align:right;"><div class="btn btn-success" onclick="plus_detail()">+</div></td>
                    </tfoot>
                  </table>
                </div>
                <div class="form-group">
                  <label>จำนวนเงิน</label>
                  <input type="text" name="total_bath" class="form-control" value="<?=$data[total_bath]?>">
                </div>
                <div class="form-group">
                  <label>จำนวนเงิน(ตัวหนังสือ)</label>
                  <input type="text" name="total_bath_word" class="form-control" value="<?=$data[total_bath_word]?>">
                </div>
                <div class="form-group">
                  <label>ร้านค้า</label>
                  <input type="hidden" name="supply_code" value="<?=$data[supply_id]?>">
                  <input type="text" name="supply_name" class="form-control" value="<?=$data[supply_name]?>">
                </div>
                <div class="form-group">
                  <label>ที่อยู่:ร้านค้า</label>
                  <input type="text" name="supply_addres" class="form-control" value="<?=$data[supply_addres]?>">
                </div>
                <div class="form-group">
                  <label>โทรศัพท์:ร้านค้า</label>
                  <input type="text" name="supply_phone" class="form-control" value="<?=$data[supply_phone]?>">
                </div>
                <div class="form-group">
                  <label>เลขที่ผู้เสียภาษี:ร้านค้า</label>
                  <input type="text" name="supply_tax" class="form-control" value="<?=$data[supply_tax]?>">
                </div>
                <div class="form-group">
                  <label>เจ้าหน้าที่</label>
                  <br>
                  <select style="border:1px solid #d0d0d0;border-radius: 5px;width:100%;" onchange="$('textarea[name=office01]').val(this.value+'\nเจ้าหน้าที่')" >
                      <option></option>
                      <?
                      $sql = "SELECT name from personal where position = '012' ORDER By row_id  ASC";
                      $result = mysql_query($sql);
                      while ($row = mysql_fetch_array($result) ) {
                        echo "<option value='$row[name]'>$row[name]</option>";
                      }
                      ?>
                  </select>
                   <textarea name="office01" class="form-control" rows="3" ><?=str_ireplace("<br>","\n", $data[office01])?></textarea>
                </div>
                <div class="form-group">
                  <label>หัวหน้าเจ้าหน้าที่</label>
                  <br>
                  <select style="border:1px solid #d0d0d0;border-radius: 5px;width:100%;" onchange="$('textarea[name=office02]').val(this.value+'\nหัวหน้าเจ้าหน้าที่')" >
                      <option></option>
                      <?
                      $sql = "SELECT name from personal where position = '013' ORDER By row_id  ASC";
                      $result = mysql_query($sql);
                      while ($row = mysql_fetch_array($result) ) {
                        echo "<option value='$row[name]'>$row[name]</option>";
                      }
                      ?>
                  </select>
                   <textarea name="office02" class="form-control" rows="3" ><?=str_ireplace("<br>","\n", $data[office02])?></textarea>
                </div>
                <div class="form-group">
                  <label>ผู้อำนวยการ</label>
                  <br>
                  <select style="border:1px solid #d0d0d0;border-radius: 5px;width:100%;" onchange="$('textarea[name=director]').val(this.value+'\nผู้อำนวยการ<?=$co[company_name]?>\nปฏิบัติราชการแทนผู้ว่าราชการจังหวัด')" >
                      <option></option>
                      <?
                      $sql = "SELECT name from personal where position = '014' ORDER By row_id  ASC";
                      $result = mysql_query($sql);
                      while ($row = mysql_fetch_array($result) ) {
                        echo "<option value='$row[name]'>$row[name]</option>";
                      }
                      ?>
                  </select>
                   <textarea name="director" class="form-control" rows="3" ><?=str_ireplace("<br>","\n", $data[director])?></textarea>
                </div>
                <div class="form-group" >
                    <input type="submit" name="submit" class="btn btn-success" value="ทำใบจัดซื้อจัดจ้าง">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<li  class="btn btn-info" onclick="$('#search_popup').show()">ค้นหาจัดซื้อจัดจ้างเดิม</li>
                </div>
              </form>
              <input type="file" name="fileupload" id="fileupload" onchange="imagespreview(this)"> <li class="btn btn-success" onclick="upload_publish()">Upload</li>
              <br>
              <img id="blah" src="../../images/<?=$data[publish]?>" style="height:400px;" onclick="window.open('../../images/<?=$data[publish]?>');">
             
            </div>
            <!-- /.box-body -->
          </div>
        </div>


<div id="search_popup" style="display:none;width:100%;height:100%;position: fixed;top:0px;left:0px;background-color: rgba(0,0,0,0.6);">
    <div style="width:600px;height:300px;background-color:#ffffff;position: fixed;top:50%;left:50%;margin-top: -150px;margin-left: -300px;padding:15px;text-align: center;">
      <fieldset style="font-size: 20px;">ค้นหาจัดซื้อจัดจ้างเดิม</fieldset><div style="position: absolute;margin-left: 423px;margin-top: -45px;" class="btn btn-danger" onclick="$('#search_popup').hide()">X</div>
      <select id="type_colum" style="padding:3px;">
        <option value="no">ที่</option>
        <option value="datebill">วันที่</option>
        <option value="detail">รายการ</option>
        <option value="total">ราคา</option>
      </select>
      <input type="text" id="search" style="width:180px;" placeholder="ค้นหา...." onkeyup="if(event.keyCode==13){search_old()}" > <li class="btn btn-success" onclick="search_old()">ค้นหา</li>
      <br>
      <div id="search_detail" style="width:570px;height:200px;border:1px solid #909090;margin-top: 10px;overflow: auto;">
        
      </div>
    </div>
</div>
  
  <!-- <iframe id="ifream_target" name="ifream_target" src="" style="width:0px;height:0px;border:0px solid #e0e0e0;"></iframe> -->

</body>
</html>

<?



$states="";
$sql = "SELECT detail,barcode,unit,pcs,price from egp_product  where store = 'out' GROUP By barcode ";
$results = mysql_query($sql);
while ($row = mysql_fetch_array( $results )) {

  $s++;
  if($s>1){  $states.=",";  }
  $states.="{value:\"".str_ireplace("&#39;","'",$row[detail])."\",detail:\"$row[detail]\",unit:\"$row[unit]\",id:\"$row[barcode]\",pcs:\"$row[pcs]\",price:\"$row[price]\"}";
}

$sql = "SELECT detail,barcode,unit,pcs,price_in from stock_product  where 1 GROUP By barcode ";
$results = mysql_query($sql);
while ($row = mysql_fetch_array( $results )) {

  $s++;
  if($s>1){  $states.=",";  }
  $states.="{value:\"".str_ireplace("&#39;","'",$row[detail])."\",detail:\"$row[detail]\",unit:\"$row[unit]\",id:\"$row[barcode]\",pcs:\"$row[pcs]\",price:\"$row[price_in]\"}";
}


$states.="";


$company="";
$sql_c = "SELECT code,name,address,phone,fax,tax from customer_supply  where 1";
$results_c = mysql_query($sql_c);
while ($roc = mysql_fetch_array( $results_c )) {

  $c++;
  if($c>1){  $company.=",";  }
  $company.="{value:\"".str_ireplace("&#39;","'",$roc[name])."\",address:\"$roc[address]\",phone:\"$roc[phone]\",fax:\"$roc[fax]\",tax:\"$roc[tax]\",code:\"$roc[code]\"}";
}
$company.="";

?>
  <link rel="stylesheet" href="../../bootstrap/datepick/jquery-ui.css">
<script src="../../bootstrap/datepick/jquery-ui.js"></script>
<script type="text/javascript">

function upload_publish(){

          var fd = new FormData();
          var files = $('#fileupload')[0].files[0];
          fd.append('file',files);
      
          fd.append('submit','fileupload_publish');
        $.ajax({
            url: 'mysql_egp.php?',
            type: 'post',
            data: fd,
            //cache: false,
            contentType: false,
            processData: false,
            success: function(response){
                    alert(response);
            },
        });


}

       function imagespreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
            //input.src = new_i;
        }

$(function () {

document.onkeydown = chkEvent 
function chkEvent(e) {
  var keycode;
  if (window.event) keycode = window.event.keyCode; //*** for IE ***//
  else if (e) keycode = e.which; //*** for Firefox ***//
  if(keycode==13)
  {
    return false;
  }
}

                $("#detail").autocomplete({
                    source: [<?echo $states;?>],
                    select: function( event, ui ) {
                      $("#detail").val(ui.item.detail.replace("&#39;", "'"));
                      //$("#pcs").focus();
                      $("#barcode").val(ui.item.id);
                      //$("#pcs").val(ui.item.pcs);
                      $("#unit").val(ui.item.unit);
                      $("#price").val(ui.item.price);

                      
                    }
                }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
        .append( "<div style='border-bottom:1px solid #a0a0a0;'><span style='color:#909090;'> รหัส : " + item.id + "</span><br>ชื่อ : " + item.detail + "</div>" )
        .appendTo( ul );
    };


                $("input[name=supply_name]").autocomplete({
                    source: [<?echo $company;?>],
                    select: function( event, ui ) {
                      $("input[name=supply_name]").val(ui.item.value.replace("&#39;", "'"));
                      //$("#pcs").focus();
                      $("input[name=supply_code]").val(ui.item.code);
                      //$("#pcs").val(ui.item.pcs);
                      $("input[name=supply_addres]").val(thaiNumber(ui.item.address));
                      $("input[name=supply_phone]").val(thaiNumber(ui.item.phone));
                      $("input[name=supply_tax").val(thaiNumber(ui.item.tax));

                      
                    }
                })
                .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<div style='border-bottom:1px solid #a0a0a0;'><span style='color:#909090;'> รหัส : " + item.code + "</span><br>ชื่อ : " + item.value + "</div>" )
        .appendTo( ul );
    };
            });



        </script>