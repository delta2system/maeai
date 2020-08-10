<?
session_start();
include("connect.inc");

if(empty($_SESSION["xusername"]) OR $_SESSION["xusername"]==""){
echo("<script>alert('กรุณาลงชื่อเข้าใช้!!!');window.location='login.php';</script>");
}else{

$sql = "SELECT image_profile,email,fullname,menu_code from user_account where username = '".$_SESSION["xusername"]."'  limit 1  ";
list($image_profile,$email,$fullname,$menu_code) = Mysql_fetch_row(Mysql_Query($sql));
if(empty($image_profile)){
$img='../images/img_profile/no-image.png';
}else{
$img="../images/img_profile/".$image_profile;

}


}

?>
<!DOCTYPE html>
<html>
<head>
  <title>.::หน้าหลัก::.</title>
  <meta charset="UTF-8">
    <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<!-- <meta name="apple-mobile-web-app-title" content="CodePen"> -->
<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" />
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


  <style type="text/css">
    body{
   /*background-image: url("../images/<?=$resultArray[3]["title"]?>");*/
   background-color: #ffffff;
   background-repeat: no-repeat;
   background-size: auto 100%;
   font-family: Microsoft Sans Serif,Tahoma;
    }
        /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    .topbar{
      background-color:#1fbf37;
      text-align: center;
      color:#ffffff;
      padding: 10px;
      border-right:1px solid #ffffff;
    }
    .barblue{
      background-color:#43aed1;
    }
    .barsoftgreen{
      background-color:#a3cf53;
      color:#000000;
    }
    table{
      border-collapse: collapse;
    }
    
        /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
       /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
  </style>
</head>
<body>

<!--<div style="width:80px;height:20px;background-color: #ffffff;position: fixed;bottom:0px;left:0px;text-align: center;" id="show_screen"></div>-->
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php" ><i class="fa fa-home" aria-hidden="true"></i> RS PRODUCT SUPPLY</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li>  <a href="login.php"> <?=$acc["fullname"]?> &nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid" >    
  <div class="row content" style="overflow-y: auto;">
    <section id="container-fluid">
      <!-- Info boxes -->
      <?
$cmenu=explode(",",$menu_code); 
$gx=array("");
for($t=1;$t<=count($cmenu);$t++){

$menu1 = "SELECT menu_group FROM menu_lst where row_id = '".$cmenu[$t]."'  ";
$result = mysql_query($menu1);
//$num = mysql_num_rows($result);
list($menu_group) = Mysql_fetch_row($result);

if(empty(array_search($menu_group,$gx))){
array_push($gx, $menu_group);
}

}

      ?>
<div class="row">
    <? if(array_search("1",$gx)){ ?>
            <div class="small-box bg-yellow" onclick="$('#display1').toggle()">
            <div class="inner">
                <p></p>
                <h2>ฟอร์ม</h2>
            </div>
            <div class="icon">
                <i class="fa fa-print"></i>
            </div>
               <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i>
            </a>
        
          <div id="display1" style="display: none;">
            <?
$sql = "SELECT * from menu_lst where menu_group = '1' ORDER By menu_position ASC";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {
if(array_search($row[row_id], $cmenu)){
  echo "<li class='btn btn-default' style='width:100%;font-size:24px;'><a href='$row[menu_link]' target=\"main_frame\">$row[menu_name]</a></li>";
}
}
?>
          </div>
            </div>
          <?
            }
          ?>

    <? if(array_search("5",$gx)){ ?>
            <div class="small-box bg-green" onclick="$('#display5').toggle()">
            <div class="inner">
                <p></p>
                <h2>บันทึกข้อความ</h2>
            </div>
            <div class="icon">
                <i class="fa fa-print"></i>
            </div>
               <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i>
            </a>
            <div id="display5" style="display: none;">
            <?
              $sql = "SELECT * from menu_lst where menu_group = '5' ORDER By menu_position ASC";
              $result = mysql_query($sql);
              while ($row = mysql_fetch_array($result) ) {
              if(array_search($row[row_id], $cmenu)){
                echo "<li class='btn btn-default' style='width:100%;font-size:24px;'><a href='$row[menu_link]' target=\"main_frame\">$row[menu_name]</a></li>";
              }
              }
              ?>
          </div>
          </div>
          <?
            }
          ?>

    <? if(array_search("2",$gx)){ ?>
            <div class="small-box bg-blue" onclick="$('#display2').toggle()">
            <div class="inner">
                <p></p>
                <h2>รายงาน</h2>
            </div>
            <div class="icon">
                <i class="fa fa-print"></i>
            </div>
               <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i>
            </a>
            <div id="display2" style="display: none;">
            <?
              $sql = "SELECT * from menu_lst where menu_group = '2' ORDER By menu_position ASC";
              $result = mysql_query($sql);
              while ($row = mysql_fetch_array($result) ) {
              if(array_search($row[row_id], $cmenu)){
                echo "<li class='btn btn-default' style='width:100%;font-size:24px;'><a href='$row[menu_link]' target=\"main_frame\">$row[menu_name]</a></li>";
              }
              }
              ?>
          </div>
          </div>
          <?
            }
          ?>

    <? if(array_search("3",$gx)){ ?>
            <div class="small-box bg-red" onclick="$('#display3').toggle()">
            <div class="inner">
                <p></p>
                <h2>การจัดการทั่วไป</h2>
            </div>
            <div class="icon">
                <i class="fa fa-print"></i>
            </div>
               <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i>
            </a>
            <div id="display3" style="display: none;">
            <?
              $sql = "SELECT * from menu_lst where menu_group = '3' ORDER By menu_position ASC";
              $result = mysql_query($sql);
              while ($row = mysql_fetch_array($result) ) {
              if(array_search($row[row_id], $cmenu)){
                echo "<li class='btn btn-default' style='width:100%;font-size:24px;'><a href='$row[menu_link]' target=\"main_frame\">$row[menu_name]</a></li>";
              }
              }
              ?>
          </div>
          </div>
          <?
            }
          ?>

    <? if(array_search("6",$gx)){ ?>
            <div class="small-box bg-purple" onclick="$('#display6').toggle()">
            <div class="inner">
                <p></p>
                <h2>ครุภัณฑ์</h2>
            </div>
            <div class="icon">
                <i class="fa fa-print"></i>
            </div>
               <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i>
            </a>
            <div id="display6" style="display: none;">
            <?
              $sql = "SELECT * from menu_lst where menu_group = '6' ORDER By menu_position ASC";
              $result = mysql_query($sql);
              while ($row = mysql_fetch_array($result) ) {
              if(array_search($row[row_id], $cmenu)){
                echo "<li class='btn btn-default' style='width:100%;font-size:24px;'><a href='$row[menu_link]' target=\"main_frame\">$row[menu_name]</a></li>";
              }
              }
              ?>
          </div>
          </div>
          <?
            }
          ?>

      <? if(array_search("4",$gx)){ ?>
            <div class="small-box bg-aqua" onclick="$('#display4').toggle()">
            <div class="inner">
                <p></p>
                <h2>ตั้งค่า</h2>
            </div>
            <div class="icon">
                <i class="fa fa-print"></i>
            </div>
               <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i>
            </a>
            <div id="display4" style="display: none;">
            <?
              $sql = "SELECT * from menu_lst where menu_group = '4' ORDER By menu_position ASC";
              $result = mysql_query($sql);
              while ($row = mysql_fetch_array($result) ) {
              if(array_search($row[row_id], $cmenu)){
                echo "<li class='btn btn-default' style='width:100%;font-size:24px;'><a href='$row[menu_link]' target=\"main_frame\">$row[menu_name]</a></li>";
              }
              }
              ?>
          </div>
          </div>
          <?
            }
          ?>
    
    </section>
</div>

</div>
<footer class="container-fluid text-center">
  
  <?

 //print_r($_SERVER["HTTP_USER_AGENT"]);?>
  หจก.อาร์เอสโปรดักส์ ซัพพลาย 124/300 หมู่ 7 ต.หนองป่าครั่ง อ.เมือง จ.เชียงใหม่ 50000
TEL. 053-851049-50 E:mail rs_product2003@hotmail.com
</footer>

</body>
</html>
<?// include("dashboard.php");?>
<script src="dashboard/bower_components/jquery/dist/jquery.min.js"></script>
<script src="dashboard/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dashboard/dist/js/adminlte.min.js"></script>

<script type="text/javascript">
  $(function() {
    $(window).bind("load resize", function() {
        var topOffset = 121;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
            $(".content").css({"height": height + "px"});
            $("#show_screen").html(width+"x"+height);
           // alert(height);
     });

});

</script>
