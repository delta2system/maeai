<?
session_start();
include("connect.inc");

function ps_detail($str){
$sql = "SELECT position_detail from position_personal where code = '$str'  limit 1  ";
list($position_detail) = Mysql_fetch_row(Mysql_Query($sql));
return $position_detail;
}

$arrCol=array();
$str = "SELECT * FROM tbl_warehousetime";
$result = mysql_query($str);
while ($data = mysql_fetch_assoc($result)){
array_push($arrCol, $data);
}



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Profile</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script src="../js/jquery-1.8.0.min.js"></script>
	<link rel="stylesheet" href="dashboard/bower_components/font-awesome/css/font-awesome.min.css">
	<style type="text/css">
		.menu_bt{
			border: 1px solid #aeaeae;padding:3px 15px;width:160px;background-color: #f0f0f0;cursor: pointer;
		}
		.menu_bt:hover{
			color:#4d94ff;
			background-color: #cce0ff;

		}
		.border_bt{
			border:1px solid #a0a0a0;
			padding:5px 0px;
		}
		table{
			border-collapse: collapse;
		}
		.head_bar{
			margin:0px auto;
			width:400px;
			height:80px;
			font-size: 30px;
			color:#000000;
			text-align: center;
		}
		.top_bar{
			background-color:#00bfff;
			text-align: center;
			padding:7px 20px;
			border:1px solid #0040ff;
		}
	</style>
<script type="text/javascript">
  
  function checked_name(str){
    var id = str.name;
      if(id=="mon"){ var row = 1; }
      if(id=="tue"){ var row = 2; }
      if(id=="wed"){ var row = 3; }
      if(id=="thu"){ var row = 4; }
      if(id=="fri"){ var row = 5; }
      if(id=="sat"){ var row = 6; }
      if(id=="sun"){ var row = 7; }
    if(str.checked==true){

      var t1 = $('#'+str.name+"_time1").val();
      var t2 = $('#'+str.name+"_time2").val();
      
        $.ajax({ 
                url: "mysql_warehousetime.php" ,
                type: "POST",
                data: 'submit=updatetime&row='+row+'&t1='+t1+'&t2='+t2+'&status=1',
            })
            .success(function(result) {
              //alert(result);
               $("input[name=alldate]").prop("checked",false);
            });   

    }else{
        $.ajax({ 
                url: "mysql_warehousetime.php" ,
                type: "POST",
                data: 'submit=updatetime&row='+row+'&status=0',
            })
            .success(function(result) {
              //alert(result);
            });   


    }


  }

  function checked_date(str){

    if(str.checked==true){

      var t1 = $('#date_st').val();
      var t2 = $('#date_ed').val();
      
        $.ajax({ 
                url: "mysql_warehousetime.php" ,
                type: "POST",
                data: 'submit=update_date&row=8&d1='+t1+'&d2='+t2+'&status=1',
            })
            .success(function(result) {
              //alert(result);
              $("input[name=mon]").prop("checked",false);
              $("input[name=tue]").prop("checked",false);
              $("input[name=wed]").prop("checked",false);
              $("input[name=thu]").prop("checked",false);
              $("input[name=fre]").prop("checked",false);
              $("input[name=sat]").prop("checked",false);

            });   

    }else{
        $.ajax({ 
                url: "mysql_warehousetime.php" ,
                type: "POST",
                data: 'submit=update_date&row=8&status=0',
            })
            .success(function(result) {
            //  alert(result);
            });   


    }

  }

  function time_ch1(str){
    var id = str.id;
    var row= 0;
      if(id=="mon_time1"){  row = 1; }
      if(id=="tue_time1"){  row = 2; }
      if(id=="wed_time1"){  row = 3; }
      if(id=="thu_time1"){  row = 4; }
      if(id=="fri_time1"){  row = 5; }
      if(id=="sat_time1"){  row = 6; }
      if(id=="sun_time1"){  row = 7; }


        $.ajax({ 
                url: "mysql_warehousetime.php" ,
                type: "POST",
                data: 'submit=update_time1now&row='+row+'&t1='+str.value,
            })
            .success(function(result) {
             // alert(id);
            });   
  }

    function time_ch2(str){
    var id = str.id;
    var row= 0;
      if(id=="mon_time2"){  row = 1; }
      if(id=="tue_time2"){  row = 2; }
      if(id=="wed_time2"){  row = 3; }
      if(id=="thu_time2"){  row = 4; }
      if(id=="fri_time2"){  row = 5; }
      if(id=="sat_time2"){  row = 6; }
      if(id=="sun_time2"){  row = 7; }


        $.ajax({ 
                url: "mysql_warehousetime.php" ,
                type: "POST",
                data: 'submit=update_time2now&row='+row+'&t2='+str.value,
            })
            .success(function(result) {
              alert(result);
            });   
  }

  function date_ch1(str){
    var id = str.id;

        $.ajax({ 
                url: "mysql_warehousetime.php" ,
                type: "POST",
                data: 'submit=update_datenow1&row=8&d1='+str.value,
            })
            .success(function(result) {
              //alert(result);
            });   
  }

  function date_ch2(str){
    var id = str.id;

        $.ajax({ 
                url: "mysql_warehousetime.php" ,
                type: "POST",
                data: 'submit=update_datenow1&row=8&d2='+str.value,
            })
            .success(function(result) {
              //alert(result);
            });   
  }

  function save_text(){
    var a1 = $("#dashboard").attr("checked");
    
    if(a1=="checked"){

   $.ajax({ 
                url: "mysql_warehousetime.php" ,
                type: "POST",
                data: 'submit=save_text&status=1&text='+$('#dashboard_text').val(),
            })
            .success(function(result) {
             // alert(result);
            }); 
    }else{
         $.ajax({ 
                url: "mysql_warehousetime.php" ,
                type: "POST",
                data: 'submit=save_text&status=0',
            })
            .success(function(result) {
              //alert(result);
            }); 
    }
  }

  function return_data(){


 $.ajax({ 
                url: "mysql_warehousetime.php" ,
                type: "POST",
                data: 'submit=return_data',
            })
            .success(function(result) {
              //alert(result);
            var obj = jQuery.parseJSON(result);
           if(obj != ''){$.each(obj, function(key, val) {

                  if(val["other"]){ $("#dashboard_text").html(val["other"]);}
                  if(val["row"]==1 && val["status"]==1){
                    $("input[name=mon]").prop("checked",true);
                    $("#mon_time1").val(val["time1"]);
                    $("#mon_time2").val(val["time2"]);
                  }
                  if(val["row"]==2 && val["status"]==1){
                    $("input[name=tue]").prop("checked",true);
                    $("#tue_time1").val(val["time1"]);
                    $("#tue_time2").val(val["time2"]);
                  }
                  if(val["row"]==3 && val["status"]==1){
                    $("input[name=wed]").prop("checked",true);
                    $("#wed_time1").val(val["time1"]);
                    $("#wed_time2").val(val["time2"]);
                  }
                  if(val["row"]==4 && val["status"]==1){
                    $("input[name=thu]").prop("checked",true);
                    $("#thu_time1").val(val["time1"]);
                    $("#thu_time2").val(val["time2"]);
                  }
                  if(val["row"]==5 && val["status"]==1){
                    $("input[name=fri]").prop("checked",true);
                    $("#fri_time1").val(val["time1"]);
                    $("#fri_time2").val(val["time2"]);
                  }
                  if(val["row"]==6 && val["status"]==1){
                    $("input[name=sat]").prop("checked",true);
                    $("#sat_time1").val(val["time1"]);
                    $("#sat_time2").val(val["time2"]);
                  }
                  // if(val["row"]==7 && val["status"]==1){
                  //   $("input[name=sun]").prop("checked",true);
                  //   $("#sun_time1").val(val["time1"]);
                  //   $("#sun_time2").val(val["time2"]);
                  // }
                  if(val["row"]==8 && val["status"]==1){
                    $("input[name=alldate]").prop("checked",true);
                    $("#date_st").val(val["date1"]);
                    $("#date_ed").val(val["date2"]);
                  }
                  if(val["row"]==9 && val["status"]==1){
                    $("#dashboard").prop("checked",true);
                  }

           });}
              });

 




  }
</script>

</head>
<body>
<div style="width:100%;height:100px;left:0px;top:0px;background-color:#00ffbf;"><br><br>
	<div class="head_bar"> <i class="fa fa-braille"></i>  | วันเวลา เบิกคลังพัสดุ</div>


</div>
<!-- <img src="../images/company_icon.png" style="width:150px;"> -->

<div id="display_user" style="margin:0px auto;height:600px;">
	<div>
			<table style="" id="detail_table">
				<thead >
					<td class="top_bar">#</td>
					<td class="top_bar">วัน</td>
					<td class="top_bar">เวลา</td>
          		
				</thead>
				<tbody>
          <tr><td><input type="checkbox" name="mon" value="1" onclick="checked_name(this)"></td>
          <td>วันจันทร์</td><td><input type="time" id="mon_time1" value="08:30" onchange="time_ch1(this)"> - <input type="time" id="mon_time2" value="16:30" onchange="time_ch2(this)"></td>
          <tr><td><input type="checkbox" name="tue" value="2" onclick="checked_name(this)"></td>
          <td>วันอังคาร</td><td><input type="time" id="tue_time1" value="08:30" onchange="time_ch1(this)"> - <input type="time" id="tue_time2" value="16:30" onchange="time_ch2(this)"></td>
          <tr><td><input type="checkbox" name="wed" value="3" onclick="checked_name(this)"></td>
          <td>วันพุธ</td><td><input type="time" id="wed_time1" value="08:30" onchange="time_ch1(this)"> - <input type="time" id="wed_time2" value="16:30" onchange="time_ch2(this)"></td>
          <tr><td><input type="checkbox" name="thu" value="4" onclick="checked_name(this)"></td>
          <td>วันพฤหัสบดี</td><td><input type="time" id="thu_time1" value="08:30" onchange="time_ch1(this)"> - <input type="time" id="thu_time2" value="16:30" onchange="time_ch2(this)"></td>
          <tr><td><input type="checkbox" name="fri" value="5" onclick="checked_name(this)"></td>
          <td>วันศุกร์</td><td><input type="time" id="fri_time1" value="08:30" onchange="time_ch1(this)"> - <input type="time" id="fri_time2" value="16:30" onchange="time_ch2(this)"></td>
          <tr><td><input type="checkbox" name="sat" value="6" onclick="checked_name(this)"></td>
          <td>วันเสาร์</td><td><input type="time" id="sat_time1" value="08:30" onchange="time_ch1(this)"> - <input type="time" id="sat_time2" value="16:30" onchange="time_ch2(this)"></td>
          <!-- <tr><td><input type="checkbox" name="sun" value="7" onclick="checked_name(this)"></td>
          <td>วันอาทิตย์</td><td><input type="time" id="sun_time1" value="08:30" onchange="time_ch1(this)"> - <input type="time" id="sun_time2" value="16:30" onchange="time_ch2(this)"></td> -->
          <tr>
            <td colspan="3"><hr></td>
          <tr>
            <td><input type="checkbox" name="alldate" onclick="checked_date(this)"></td>
            <td>ระหว่างวันที่ </td><td><input type="date" id="date_st" value="<?=date('Y-m-d')?>" onchange="date_ch1(this)"> - <input type="date" id="date_ed" value="<?=date('Y-m-d')?>" onchange="date_ch2(this)">      </td>
            <tr>
            <td colspan="3"><hr></td>
            <tr>
              <td><input type="checkbox" id="dashboard" ></td>
              <td>กระดานข่าว</td>
            <td><textarea id="dashboard_text" style="width:100%;height:200px;text-align: left;"></textarea><button onclick="save_text()">บันทึก</button></td>
				</tbody>
			</table>

       
	</div>
</div>




</body>
</html>
<script src="../js/tableHeadFixer.js"></script>
<script type="text/javascript">

	   $(document).ready(function() {
	  // 	return_detail();
    return_data();
       $("#display_user").tableHeadFixer(); 
       //$("#detail_show").onscroll(fixedhead());
      //  var h = $( window ).height();
      // 	alert(h);
      // $("#display_user").css({"height" : h+"px"});
      });
</script>
