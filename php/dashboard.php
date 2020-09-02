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

if($dashboard_show==1){

  header('Location: dashboard_icon.php');
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
    data: "submit=update_dashboard&value=1&row_id="+xid,
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
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo dashboard_icon.php <ul class="fa fa-th-large"></ul>-->
    <a href="dashboard.php"  class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <!-- <span class="logo-mini"><b>A</b>LT</span> -->
      <span class="logo-mini"><b></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><ul class="fa fa-home"></ul> </b>หน้าหลัก&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

<!--       
          <span class="logo-mini" style="color:#ffffff;" onclick="change_dashboard()">
      <ul class="fa fa-th-large" style="font-size: 18px"></ul>&nbsp;&nbsp; Menu Icon</span>
 -->



      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown" >
            <a href="#" class="dropdown" onclick="change_dashboard()">
              <i class="fa fa-th-large"></i> Menu Icon
             
            </a>
          </li>



          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <input type="hidden" id="xid" value="<?=$_SESSION["xid"]?>">
              <img id='imgprofile1' src="<?=$image_profile?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION[xfullname]?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img id='imgprofile2' src="<?=$image_profile?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION[xfullname]?> - <?php
               $sql = "SELECT position_detail from position_personal where row_id = '".$_SESSION[xposition]."'  limit 1  ";
                  list($position) = Mysql_fetch_row(Mysql_Query($sql));
                   echo $position;?>
                  <?php

                  //print "<small>Member since $regis_start</small>";
                  ?>
                  
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
   <!--              <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div> -->
                <!-- /.row -->
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
          <!-- Control Sidebar Toggle Button -->
<!--           <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=$image_profile?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION[xfullname]?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
<!--       <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div> -->
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->


      <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>

<?
$cmenu=explode(",",$menu_code); 

$gx=array("");
for($t=1;$t<=count($cmenu);$t++){

 $menu1 = "SELECT menu_group FROM menu_lst where row_id = '".$cmenu[$t]."' AND status = '1'  ";
 $result = mysql_query($menu1);
//$num = mysql_num_rows($result);
 list($menu_group) = Mysql_fetch_row($result);

 //if(array_search($menu_group,$cmenu)){
 array_push($gx, $menu_group);
 //}

 }


if(array_search("1", $gx)){

?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>แผนการจัดซื้อประจำปี</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
<?
$sql = "SELECT * from menu_lst where menu_group = '1' AND status = '1' ORDER By menu_position ASC";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {
if(array_search($row[row_id], $cmenu)){
  echo "<li><a href='$row[menu_link]' target=\"main_frame\"><i class=\"fa fa-circle-o\"></i>$row[menu_name]</a></li>";
}
}
?>
<!--        <li><a href="warehouse_in.php" target="main_frame"><i class="fa fa-circle-o"></i>รับพัสดุ</a></li>
            <li><a href="warehouse_take.php" target="main_frame"><i class="fa fa-circle-o"></i> เบิกพัสดุ</a></li>
            <li><a href="warehouse_in_edit.php" target="main_frame"><i class="fa fa-circle-o"></i> แก้ไขใบรับพัสดุ</a></li>
            <li><a href="warehouse_out_edit.php" target="main_frame"><i class="fa fa-circle-o"></i> แก้ไขใบเบิกพัสดุ</a></li> -->


          </ul>
        </li>

<?
}
if(array_search("2", $gx)){

?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>จัดซื้อ/รับเข้าพัสดุ</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
<?
$sql = "SELECT * from menu_lst where menu_group = '2' AND status = '1' ORDER By menu_position ASC";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {
if(array_search($row[row_id], $cmenu)){
  echo "<li><a href='$row[menu_link]' target=\"main_frame\"><i class=\"fa fa-circle-o\"></i>$row[menu_name]</a></li>";
}
}
?>
<!--             <li><a href="warehouse_in.php" target="main_frame"><i class="fa fa-circle-o"></i>รับพัสดุ</a></li>
            <li><a href="warehouse_take.php" target="main_frame"><i class="fa fa-circle-o"></i> เบิกพัสดุ</a></li>
            <li><a href="warehouse_in_edit.php" target="main_frame"><i class="fa fa-circle-o"></i> แก้ไขใบรับพัสดุ</a></li>
            <li><a href="warehouse_out_edit.php" target="main_frame"><i class="fa fa-circle-o"></i> แก้ไขใบเบิกพัสดุ</a></li> -->


          </ul>
        </li>

<?
}

if(array_search("3", $gx)){
?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>เบิก/จ่าย พัสดุ</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
<!--             <li><a href="warehouse_stock.php" target="main_frame"><i class="fa fa-circle-o"></i> คลังพัสดุ</a></li>
            <li><a href="report_warehousein.php" target="main_frame"><i class="fa fa-circle-o"></i> รายงานรับพัสดุ</a></li>
            <li><a href="report_search.php" target="main_frame"><i class="fa fa-circle-o"></i> รายงานเบิกพัสดุ</a></li>
            <li><a href="report_warehouse.php" target="main_frame"><i class="fa fa-circle-o"></i> รายงานพัสดุคงเหลือ</a></li> -->
          <?


          $sql = "SELECT * from menu_lst where menu_group = '3' AND status = '1' ORDER By menu_position ASC"; 
         $result = mysql_query($sql);
          while ($row = mysql_fetch_array($result) ) {
          if(array_search($row[row_id], $cmenu)){


            if($row["row_id"]==43){

            $stre = "SELECT * FROM tbl_warehousetime";
            $resulte = mysql_query($stre);
            while ($datae = mysql_fetch_assoc($resulte)){
              if($datae[row]==date(w) && $datae[status]==1){
            echo "<li><a href='$row[menu_link]' target=\"main_frame\"><i class=\"fa fa-circle-o\"></i>$row[menu_name]</a></li>";
            }else if($datae[row]==8 && $datae[status]==1){
            if(date("Y-m-d")>=$datae[date1] && date("Y-m-d")<=$datae[date2]){
             echo "<li><a href='$row[menu_link]' target=\"main_frame\"><i class=\"fa fa-circle-o\"></i>$row[menu_name]</a></li>"; 
            }

          }
}
            }else{
            echo "<li><a href='$row[menu_link]' target=\"main_frame\"><i class=\"fa fa-circle-o\"></i>$row[menu_name]</a></li>";
          }
          }
          }
          ?>
          </ul>
        </li>
<?
}
if(array_search("4", $gx)){
?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>คลังพัสดุ</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?
          $sql = "SELECT * from menu_lst where menu_group = '4' AND status = '1' ORDER By menu_position ASC";
          $result = mysql_query($sql);
          while ($row = mysql_fetch_array($result) ) {
          if(array_search($row[row_id], $cmenu)){
            echo "<li><a href='$row[menu_link]' target=\"main_frame\"><i class=\"fa fa-circle-o\"></i>$row[menu_name]</a></li>";
          }
          }
          ?>
<!--              <li><a href="position_edit.php" target="main_frame"><i class="fa fa-circle-o"></i> เพิ่มตำแหน่งพนักงาน</a></li>
            <li><a href="personal_edit.php" target="main_frame"><i class="fa fa-circle-o"></i> เพิ่มรายชื่อพนักงาน</a></li>
            <li><a href="company_edit.php" target="main_frame"><i class="fa fa-circle-o"></i> เพิ่มรายชื่อบริษัทคู่ค้า</a></li>
            <li><a href="group_type_edit.php" target="main_frame"><i class="fa fa-circle-o"></i> เพิ่มประเภทสินค้า</a></li> -->

          </ul>
        </li>
<?
}
if(array_search("13", $gx)){
?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>คลังนอก</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?
          $sql = "SELECT * from menu_lst where menu_group = '13' AND status = '1' ORDER By menu_position ASC";
          $result = mysql_query($sql);
          while ($row = mysql_fetch_array($result) ) {
          if(array_search($row[row_id], $cmenu)){
            echo "<li><a href='$row[menu_link]' target=\"main_frame\"><i class=\"fa fa-circle-o\"></i>$row[menu_name]</a></li>";
          }
          }
          ?>
<!--              <li><a href="position_edit.php" target="main_frame"><i class="fa fa-circle-o"></i> เพิ่มตำแหน่งพนักงาน</a></li>
            <li><a href="personal_edit.php" target="main_frame"><i class="fa fa-circle-o"></i> เพิ่มรายชื่อพนักงาน</a></li>
            <li><a href="company_edit.php" target="main_frame"><i class="fa fa-circle-o"></i> เพิ่มรายชื่อบริษัทคู่ค้า</a></li>
            <li><a href="group_type_edit.php" target="main_frame"><i class="fa fa-circle-o"></i> เพิ่มประเภทสินค้า</a></li> -->

          </ul>
        </li>
<?
}
if(array_search("6", $gx)){
?>
<li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>คลังย่อย</span>
            <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
             <!--  <span class="label label-primary pull-right">4</span> -->
            </span>
          </a>

          <ul class="treeview-menu">
<!--               <li><a href='new_khruphanth.php' target="main_frame"><i class="fa fa-circle-o"></i>เพิ่ม ครุภัณฑ์</a></li>
               <li><a href='report_khruphanth.php' target="main_frame"><i class="fa fa-circle-o"></i>รายงาน ครุภัณฑ์</a></li> -->
          <?
          $sql = "SELECT * from menu_lst where menu_group = '6' AND status = '1' ORDER By menu_position ASC";
          $result = mysql_query($sql);
          while ($row = mysql_fetch_array($result) ) {
          if(array_search($row[row_id], $cmenu)){
            echo "<li><a href='$row[menu_link]' target=\"main_frame\"><i class=\"fa fa-circle-o\"></i>$row[menu_name]</a></li>";
          }
          }
          ?>
          </ul>
        </li>


<?
}
if(array_search("7", $gx)){
?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>ครุภัณฑ์</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
             <!--  <span class="label label-primary pull-right">4</span> -->
            </span>
          </a>
          <ul class="treeview-menu">
          <?
          $sql = "SELECT * from menu_lst where menu_group = '7' AND status = '1' ORDER By menu_position ASC";
          $result = mysql_query($sql);
          while ($row = mysql_fetch_array($result) ) {
          if(array_search($row[row_id], $cmenu)){
            echo "<li><a href='$row[menu_link]' target=\"main_frame\"><i class=\"fa fa-circle-o\"></i>$row[menu_name]</a></li>";
          }
          }
          ?>



          
<!--             <li><a href="company_setting.php" target="main_frame"><i class="fa fa-circle-o"></i> ชื่อหน่วยงาน</a></li>
            <li><a href="user_maneger.php" target="main_frame"><i class="fa fa-circle-o"></i> จัดการพนักงาน</a></li> -->

          </ul>
        </li>

<?}if(array_search("8", $gx)){
?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>บันทึกการซ่อมบำรุง</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
             <!--  <span class="label label-primary pull-right">4</span> -->
            </span>
          </a>
          <ul class="treeview-menu">
          <?
          $sql = "SELECT * from menu_lst where menu_group = '8' AND status = '1' ORDER By menu_position ASC";
          $result = mysql_query($sql);
          while ($row = mysql_fetch_array($result) ) {
          if(array_search($row[row_id], $cmenu)){
            echo "<li><a href='$row[menu_link]' target=\"main_frame\"><i class=\"fa fa-circle-o\"></i>$row[menu_name]</a></li>";
          }
          }
          ?>



          
<!--             <li><a href="company_setting.php" target="main_frame"><i class="fa fa-circle-o"></i> ชื่อหน่วยงาน</a></li>
            <li><a href="user_maneger.php" target="main_frame"><i class="fa fa-circle-o"></i> จัดการพนักงาน</a></li> -->

          </ul>
        </li>

<?}if(array_search("10", $gx)){
?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>รายงาน</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
             <!--  <span class="label label-primary pull-right">4</span> -->
            </span>
          </a>
          <ul class="treeview-menu">
          <?
          $sql = "SELECT * from menu_lst where menu_group = '10' AND status = '1' ORDER By menu_position ASC";
          $result = mysql_query($sql);
          while ($row = mysql_fetch_array($result) ) {
          if(array_search($row[row_id], $cmenu)){
            echo "<li><a href='$row[menu_link]' target=\"main_frame\"><i class=\"fa fa-circle-o\"></i>$row[menu_name]</a></li>";
          }
          }
          ?>



          
<!--             <li><a href="company_setting.php" target="main_frame"><i class="fa fa-circle-o"></i> ชื่อหน่วยงาน</a></li>
            <li><a href="user_maneger.php" target="main_frame"><i class="fa fa-circle-o"></i> จัดการพนักงาน</a></li> -->

          </ul>
        </li>

<?}if(array_search("11", $gx)){
?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>จัดการทั่วไป</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
             <!--  <span class="label label-primary pull-right">4</span> -->
            </span>
          </a>
          <ul class="treeview-menu">
          <?
          $sql = "SELECT * from menu_lst where menu_group = '11' AND status = '1' ORDER By menu_position ASC";
          $result = mysql_query($sql);
          while ($row = mysql_fetch_array($result) ) {
          if(array_search($row[row_id], $cmenu)){
            echo "<li><a href='$row[menu_link]' target=\"main_frame\"><i class=\"fa fa-circle-o\"></i>$row[menu_name]</a></li>";
          }
          }
          ?>



          
<!--             <li><a href="company_setting.php" target="main_frame"><i class="fa fa-circle-o"></i> ชื่อหน่วยงาน</a></li>
            <li><a href="user_maneger.php" target="main_frame"><i class="fa fa-circle-o"></i> จัดการพนักงาน</a></li> -->

          </ul>
        </li>

<?}if(array_search("12", $gx)){
?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>ตั้งค่าระบบ</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
             <!--  <span class="label label-primary pull-right">4</span> -->
            </span>
          </a>
          <ul class="treeview-menu">
          <?
          $sql = "SELECT * from menu_lst where menu_group = '12' AND status = '1' ORDER By menu_position ASC";
          $result = mysql_query($sql);
          while ($row = mysql_fetch_array($result) ) {
          if(array_search($row[row_id], $cmenu)){
            echo "<li><a href='$row[menu_link]' target=\"main_frame\"><i class=\"fa fa-circle-o\"></i>$row[menu_name]</a></li>";
          }
          }
          ?>



          
<!--             <li><a href="company_setting.php" target="main_frame"><i class="fa fa-circle-o"></i> ชื่อหน่วยงาน</a></li>
            <li><a href="user_maneger.php" target="main_frame"><i class="fa fa-circle-o"></i> จัดการพนักงาน</a></li> -->

          </ul>
        </li>

<?}?>

        
        <!--<li>
          <a href="pages/widgets.html">
            <i class="fa fa-th"></i> <span>Widgets</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li>
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>UI Elements</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
            <li><a href="pages/UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
            <li><a href="pages/UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
            <li><a href="pages/UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
            <li><a href="pages/UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
            <li><a href="pages/UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Forms</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
            <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
            <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Tables</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
            <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
          </ul>
        </li>
        <li>
          <a href="pages/calendar.html">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>
        <li>
          <a href="pages/mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Examples</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
            <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
            <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
            <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
            <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
            <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
            <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
            <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
          </ul>
        </li>
        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>-->
      </ul> 
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="content-wrapper" style="background-color: #ffffff;padding:0px;">
    <!-- Content Header (Page header) -->
  <iframe name="main_frame" id="main_frame" class="main_frame_left" src="display_index.php" style="border:0px solid #000000;padding:0px;overflow: auto;background-color: #ffffff;">
    
  </iframe>
    <!-- Main content -->
 </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      
      <b>Version</b> 1.1.0
    </div>
    <strong>Copyright © 2017 <a href="https://www.rsproductsupply.com">Rs Product Supply</a>.</strong> All rights
    reserved.
  </footer>

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
   //  $(document).ready(function (e) {

//       var yx = $("#content-wrapper").height();
//      var wx = $("#content-wrapper").width();
//      $("#main_frame").css({"width":(wx-80)+"px","height": (yx-108)+"px"}); 
//          if(wx<768){
//       $("#main_frame").css({"margin-left":"-170px"}); 
//     }
//    // });

// var x=0;
// $(document).ready(function(){
//   $(window).resize(function(){
//     var yx = $("#content-wrapper").height();
//     var wx = $("#content-wrapper").width();
//     $("#main_frame").css({"width":(wx-100)+"px","height": (yx-20)+"px"}); 
//     if(wx<768){
//       $("#main_frame").css({"margin-left":"-170px"}); 
//     }
//     //$("#log").text($(document).width());
//   });
// });

  $(function() {
    $(window).bind("load resize", function() {
      //  var wrapper = $("#wrapper").height();
        var topOffset = 60;
        var sd = $(".sidebar").width();
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        width = width - sd - 70;
        

             $("#main_frame").css({"width":width+"px","height": height+"px"}); 
          //  $("#show_screen").html(width+"x"+height);
           // alert(height);
     });

});

  </script>
