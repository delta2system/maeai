<?
session_start();
include("connect.inc");

if($_SESSION["xusername"]==""){
  echo("<script>alert('กรุณาทำการล็อกอินก่อนใช้งาน');window.location='login.php'</script>");
}

$sql = "SELECT image_profile,email,fullname,menu_code,dashboard_show from user_account where username = '".$_SESSION["xusername"]."'  limit 1  ";
list($image_profile,$email,$fullname,$menu_code,$dashboard_show) = Mysql_fetch_row(Mysql_Query($sql));
if(empty($image_profile)){
$image_profile='../images/img_profile/no-image.png';
}else{
$image_profile="../images/img_profile/".$image_profile;

}

if($dashboard_show==0){
  
  header('Location: dashboard.php');
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Hotpital Programe By Rsproduct</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="dashboard/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="dashboard/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
<!--   <link rel="stylesheet" href="dashboard/bower_components/Ionicons/css/ionicons.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="dashboard/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dashboard/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
<!--   <link rel="stylesheet" href="dashboard/bower_components/morris.js/morris.css"> -->
  <!-- jvectormap -->
<!--   <link rel="stylesheet" href="dashboard/bower_components/jvectormap/jquery-jvectormap.css"> -->
  <!-- Date Picker -->
<!--   <link rel="stylesheet" href="dashboard/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"> -->
  <!-- Daterange picker -->
  <!-- <link rel="stylesheet" href="dashboard/bower_components/bootstrap-daterangepicker/daterangepicker.css"> -->
  <!-- bootstrap wysihtml5 - text editor -->
<!--   <link rel="stylesheet" href="dashboard/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> -->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
<!--   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
<script type="text/javascript">
    function signout(){
      window.location='login.php?logout=Y';
    }

    function change_dashboard(){
      var xid = $("#xid").val();

   $.ajax({
    type: "POST",
    url: "mysql_edituser.php",
    data: "submit=update_dashboard&value=0&row_id="+xid,
    cache: false,
    success: function(html)
    {
    
     window.location='dashboard.php?';
    }
    });



    }
    // function imgload(){
    //   var xu = "admin";
    //   document.getElementById("imgprofile1").src="../images/img_profile/profile_"+xu+".jpg";
    //   document.getElementById("imgprofile2").src="../images/img_profile/profile_"+xu+".jpg";
    // }

</script>
<style type="text/css">
	body{
		/*background-color: #72e891;
		 background-image: linear-gradient(-90deg, #72e891, #a3e8a3,#72e891);*/
      background-image: url("https://ak3.picdn.net/shutterstock/videos/30574603/thumb/1.jpg");
      background-repeat: repeat-y;
      background-size: 100%;

	}
	.social-box{
	width: 100%;
  height: 150px;
  text-align:center;
  padding: 5px 0px;
	}
	.facebook,.twitter,.linkedin,.google-plus{
		/*padding: 20px;*/
		text-align:center;
		font-size: 50px;
		color:#ffffff;
		padding:30px 5px;
		background-color:#3B5998;
	}
	.col-lg-2{
		/*border:1px solid #e0e0e0;*/
		text-align: center;
	}
	.close_button{
		z-index:6;
		background-color: #ffffff;
		font-weight: bold;
		border:2px solid #000000;
		border-radius: 15px;
		position: fixed;
		top:50%;
		left:50%;
		width:30px;
		height:30px;
		text-align: center;
		font-size: 18px;
		cursor: pointer;
		margin-top:-320px;
		margin-left:400px;
		box-shadow: 5px 3px 3px rgba(0,0,0,0.5);
	}
  .icon_menu{
    width:100%;
    height:100%;
    font-weight: bold;
  }
  .icon_menu:hover {
  transform: scale(1.2); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
}
</style>
</head>
<body >
	<div class="main-header" style="background-color:#4d7bdb;">
		
    <!-- <a href="#" onclick="change_dashboard()"> -->
      <span class="logo-lg" style="left:10px;position: absolute;top:10px;font-size: 18px;color:#ffffff;cursor: pointer;"><span  onclick="window.location='dashboard_icon.php'"><li class="fa  fa-home"></li></span> 
<!--       &nbsp;&nbsp;&nbsp;<span  onclick="change_dashboard()" ><li class="fa  fa-list"></li> Menu list</span> -->
    </span>

    <!-- </a> -->
	<nav class="navbar navbar-static-top">
	 <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">


      <li class="dropdown" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="change_dashboard()" style="color:#ffffff;">
              <i class="fa fa-list" style="color:#ffffff;"></i> Menu List
            </a>
          </li>


          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <input type="hidden" id="xid" value="<?=$_SESSION["xid"]?>">
              <img id='imgprofile1' src="<?=$image_profile?>" class="user-image" alt="User Image">
              <span class="hidden-xs" style="color:#ffffff;"><?php echo $_SESSION[xfullname]?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header" style="background-color: #4d7bdb;">
                <img id='imgprofile2' src="<?=$image_profile?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION[xfullname]?> - <?php
               $sql = "SELECT position_detail from position_personal where code = '".$_SESSION[xposition]."'  limit 1  ";
                  list($position) = Mysql_fetch_row(Mysql_Query($sql));
                   echo $position;
                  
                  ?>
                  
                </p>
              </li>

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="profile.php"  target="main_frame" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat" onclick="signout()">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
		</div>
		<div>
	</nav>
</div>
<?
$cmenu=explode(",",$menu_code); 

$gx=array("");
for($t=1;$t<=count($cmenu);$t++){

 $menu1 = "SELECT menu_group FROM menu_lst where row_id = '".$cmenu[$t]."' AND status = '1'  ";
 $result = mysql_query($menu1);
//$num = mysql_num_rows($result);
 list($menu_group) = Mysql_fetch_row($result);
//echo $menu_group; 
 //if(array_search($menu_group,$cmenu)){
 array_push($gx, $menu_group);
 //}

 }
?>
	<div class="wrapper">


<?
if(array_search("1", $gx)){
?>
    	 <div class="col-lg-2 col-md-3" >
    	 	<div style="width:150px;height:170px;padding:15px 0px;margin:0px auto;cursor: pointer;" onclick="return_menu(1,'<?=$menu_group?>')">
    	 		<div class='icon_menu' >
    	 		<img src="../images/menu/acc_chart.png" style="height:110px;padding: 10px;"><br>
    	 		แผนการจัดซื้อประจำปี</div>
    	 	</div>
    	</div>
<?
}

if(array_search("2", $gx)){
?>
    	 <div class="col-lg-2 col-md-3" >
    	 	<div style="width:150px;height:170px;padding:15px 0px;margin:0px auto;cursor: pointer;" onclick="return_menu(2,'<?=$menu_group?>')">
    	 		<div class='icon_menu' >
    	 		<img src="../images/menu/accounting.png" style="height:110px;padding: 10px;"><br>
    	 		จัดซื้อ/รับเข้าพัสดุ</div>
    	 	</div>
    	</div>
    	<?
		} if(array_search("3", $gx)){
    	?>
    	    	 <div class="col-lg-2 col-md-3" >
    	 	<div style="width:150px;height:170px;padding:15px 0px;margin:0px auto;cursor: pointer;" onclick="return_menu(3,'<?=$menu_group?>')">
    	 		<div class='icon_menu' >
    	 		<img src="../images/menu/back_store.png" style="height:110px;padding: 10px;"><br>
    	 		เบิก/จ่าย พัสดุ</div>
    	 	</div>
    	</div>
    	<?
		} if(array_search("4", $gx)){
    	?>    	
    	<div class="col-lg-2 col-md-3" >
    	 	<div style="width:150px;height:170px;padding:15px 0px;margin:0px auto;cursor: pointer;" onclick="return_menu(4,'<?=$menu_group?>')">
    	 		<div class='icon_menu' >
    	 		<img src="../images/menu/stock.png" style="height:110px;padding: 10px;"><br>
    	 		คลังพัสดุ</div>
    	 	</div>
    	</div>
    	<?
		} if(array_search("6", $gx)){
    	?>
    	    	 <div class="col-lg-2 col-md-3" >
    	 	<div style="width:150px;height:170px;padding:15px 0px;margin:0px auto;cursor: pointer;" onclick="return_menu(6,'<?=$menu_group?>')">
    	 		<div class='icon_menu' >
    	 		<img src="../images/menu/capital.png" style="height:110px;padding: 10px;"><br>
    	 		คลังย่อย</div>
    	 	</div>
    	</div>
    	<?
		} if(array_search("7", $gx)){
    	?>
    	    	 <div class="col-lg-2 col-md-3" >
    	 	<div style="width:150px;height:170px;padding:15px 0px;margin:0px auto;cursor: pointer;" onclick="return_menu(7,'<?=$menu_group?>')">
    	 		<div class='icon_menu' >
    	 		<img src="../images/menu/group_icon.png" style="height:110px;padding: 10px;"><br>
    	 		ครุภัณฑ์</div>
    	 	</div>
    	</div>
    	<?
		} if(array_search("8", $gx)){
    	?>
    	    	 <div class="col-lg-2 col-md-3" >
    	 	<div style="width:150px;height:170px;padding:15px 0px;margin:0px auto;cursor: pointer;" onclick="return_menu(8,'<?=$menu_group?>')">
    	 		<div class='icon_menu' >
    	 		<img src="../images/menu/fix-usb.png" style="height:110px;padding: 10px;"><br>
    	 		บันทึกการซ่อมบำรุง</div>
    	 	</div>
    	</div> 
    	<?
		} if(array_search("10", $gx)){
    	?>
    			<div class="col-lg-2 col-md-3" >
    	 	<div style="width:150px;height:170px;padding:15px 0px;margin:0px auto;cursor: pointer;" onclick="return_menu(10,'<?=$menu_group?>')">
    	 		<div class='icon_menu' >
    	 		<img src="../images/menu/checklist.png" style="height:110px;padding: 10px;"><br>
    	 		รายงาน</div>
    	 	</div>
    	</div>
    	<?
		} if(array_search("11", $gx)){
    	?>
    	<div class="col-lg-2 col-md-3" >
    	 	<div style="width:150px;height:170px;padding:15px 0px;margin:0px auto;cursor: pointer;" onclick="return_menu(11,'<?=$menu_group?>')">
    	 		<div class='icon_menu' >
    	 		<img src="../images/menu/register-edit.png" style="height:110px;padding: 10px;"><br>
    	 		จัดการทั่วไป</div>
    	 	</div>
    	</div>
    	<?
		} if(array_search("12", $gx)){
    	?>
    	<div class="col-lg-2 col-md-3" >
    	 	<div style="width:150px;height:170px;padding:15px 0px;margin:0px auto;cursor: pointer;" onclick="return_menu(12,'<?=$menu_group?>')">
    	 		<div class='icon_menu' >
    	 		<img src="../images/menu/product.png" style="height:110px;padding: 10px;"><br>
    	 		ตั้งค่าระบบ</div>
    	 	</div>
    	</div>
    	<?
		}
    	?>
    	</div>

<div id="content_row" >
  <iframe name="main_frame" id="main_frame" class="main_frame_left" src="display_index.php" style="border:0px solid #000000;padding:0px;overflow: auto;background-color: #ffffff;">
    
  </iframe>
</div>
<div id="sub_menu" style="display:none;position: fixed;width:100%;height: 100%;left:0px;top:0px;background-color: rgba(0,0,0,0.7);z-index: 5;">

	<div class="close_button"> <div style="margin-top: 0px;" onclick="$('#sub_menu').hide()">x</div> </div>

<div style="width:800px;height:600px;background-color: #ffffff;box-shadow: 5px 5px 5px rgba(0,0,0,0.5);position: absolute;left: 50%;top:50%;margin-left: -400px;margin-top:-300px;border-radius: 10px;padding: 0px 30px;overflow: auto;">
<div class="row" id="list_menu">
<?
// $sql = "SELECT * from menu_lst where menu_group = '6' AND status = '1' ORDER By menu_position ASC";
// $result = mysql_query($sql);
// while ($row = mysql_fetch_array($result) ) {
// if(array_search($row[row_id], $cmenu)){
//   echo "<div class='col-lg-4' style='padding-top:30px;' onclick=\"window.open('$row[menu_link]','_blank')\"><span class='btn btn-default' style='height:150px;width:100%;'><span class='fa fa-tv' style='font-size:100px;margin-top:10px;'></span> <br>$row[menu_name]</span></div>";
// }
// }
?>
</div>
</div>
</div>
<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="dashboard/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<!-- <script src="dashboard/bower_components/jquery-ui/jquery-ui.min.js"></script> -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- <script>
  $.widget.bridge('uibutton', $.ui.button);
</script> -->
<!-- Bootstrap 3.3.7 -->
<script src="dashboard/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<!-- <script src="dashboard/bower_components/raphael/raphael.min.js"></script>
<script src="dashboard/bower_components/morris.js/morris.min.js"></script> -->
<!-- Sparkline -->
<!-- <script src="dashboard/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script> -->
<!-- jvectormap -->
<!-- <script src="dashboard/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="dashboard/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> -->
<!-- jQuery Knob Chart -->
<!-- <script src="dashboard/bower_components/jquery-knob/dist/jquery.knob.min.js"></script> -->
<!-- daterangepicker -->
<!-- <script src="dashboard/bower_components/moment/min/moment.min.js"></script>
<script src="dashboard/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> -->
<!-- datepicker -->
<!-- <script src="dashboard/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> -->
<!-- Bootstrap WYSIHTML5 -->
<!-- <script src="dashboard/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> -->
<!-- Slimscroll -->
<!-- <script src="dashboard/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> -->
<!-- FastClick -->
<!-- <script src="dashboard/bower_components/fastclick/lib/fastclick.js"></script> -->
<!-- AdminLTE App -->
<script src="dashboard/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="dashboard/dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="dashboard/dist/js/demo.js"></script> -->
</body>
</html>

  <script type="text/javascript">

  	function return_menu(gx,code){
  		$("#sub_menu").show();
   url = 'dashboard_icon_mysql.php?submit=return_menu&menu_group='+gx;
    var  xmlhttp = new XMLHttpRequest();
         xmlhttp.open("GET", url, false);
         xmlhttp.send(null); 
    var hn_value = xmlhttp.responseText;

      $("#list_menu").html(hn_value);

  	}




//       var yx = $("#content_row").height();
//      var wx = $("#content_row").width();

//      $("#main_frame").css({"width":(wx-80)+"px","height": (yx-108)+"px"}); 
//          if(wx<768){
//       $("#main_frame").css({"margin-left":"-170px"}); 
//     }


// var x=0;
// $(document).ready(function(){
//   $(window).resize(function(){
//     var yx = $("#content_row").height();
//     var wx = $("#content_row").width();

//     $("#main_frame").css({"width":(wx-100)+"px","height": (yx-20)+"px"}); 
//     if(wx<768){
//       $("#main_frame").css({"margin-left":"-170px"}); 
//     }
//   });
// });


  $(function() {
    $(window).bind("load resize", function() {
      //  var wrapper = $("#wrapper").height();
        var topOffset = $(".wrapper").height();
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset-60;
             if(height<200){
              $("#main_frame").css({"width":(width-100)+"px","height": "400px"}); 
             }else{
             $("#main_frame").css({"width":(width-100)+"px","height": height+"px"}); 
          //  $("#show_screen").html(width+"x"+height);
           // alert(height);
         }
     });

});

  </script>
