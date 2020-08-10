<?
session_start();
include("connect.inc");

  // $sql = "SELECT position,bill_in_edit,bill_out_edit,limitstock from user_account WHERE username = '".$_SESSION["xusername"]."' ";
  // list($position,$bill_in_edit,$bill_out_edit,$limitstock) = Mysql_fetch_row(Mysql_Query($sql));

function department_return($str){
    $sql = "SELECT name from department WHERE code = '$str' ";
  list($name) = Mysql_fetch_row(Mysql_Query($sql));
  return $name;
}

function supply_return($str){
   $sql = "SELECT name from customer_supply WHERE code = '$str' ";
  list($name) = Mysql_fetch_row(Mysql_Query($sql));
  return $name;

}

function expdate($startdate,$datenum){
 $startdate_new=(substr($startdate, 0,4)-543).substr($startdate,4);
 $startdatec=strtotime($startdate_new); // ทำให้ข้อความเป็นวินาที
 $tod=$datenum*86400; // รับจำนวนวันมาคูณกับวินาทีต่อวัน
 $ndate=$startdatec+$tod; // นับบวกไปอีกตามจำนวนวันที่รับมา
// $dr=expdate($dateday,$_POST["datefix"]); //ส่งค่าให้ฟังก์ชั่น วันที่ปัจจุบัน พร้อมจำนวนวัน
$df=date("d/m/Y",$ndate); //จัดรูปแบบวันที่ก่อนแสดง
$new_date = substr($df,0,2)." ".mount(substr($df,3,2))." ".(substr($df,6,4)+543); //แสดงวันที่ออกมา
 return $new_date; // ส่งค่ากลับ
}

function mount($str){
switch($str)
{
case "01": $str = "ม.ค."; break;
case "02": $str = "ก.พ."; break;
case "03": $str = "มี.ค."; break;
case "04": $str = "เม.ย."; break;
case "05": $str = "พ.ค."; break;
case "06": $str = "มิ.ย."; break;
case "07": $str = "ก.ค."; break;
case "08": $str = "ส.ค."; break;
case "09": $str = "ก.ย."; break;
case "10": $str = "ต.ค."; break;
case "11": $str = "พ.ย."; break;
case "12": $str = "ธ.ค."; break;
}
return $str;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="dashboard/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="dashboard/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="dashboard/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dashboard/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dashboard/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="dashboard/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="dashboard/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="dashboard/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="dashboard/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="dashboard/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="dashboard/https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="dashboard/https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">


  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard/#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">

<!--       <div class="row">
        <div class="col-lg-3 col-xs-6">

          <div class="small-box bg-aqua">
            <div class="inner">

  <table style="width:100%;">
    <?
    $sql = "SELECT * from stock_product WHERE limit_stock > 0 HAVING pcs <= limit_stock";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result) ) {
    print "<tr>".
          "<td>$row[detail]</td>".
          "<td>จำนวน คงเหลือ : $row[pcs]</td>";
    }
    ?>
    
  </table>
</div>
</div>
</div>
</div> -->

          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">สินค้าคงคลังต่ำกว่ากำหนด</h3>

 <!--              <div class="box-tools pull-right">
                <ul class="pagination pagination-sm inline">
                  <li><a href="dashboard/#">&laquo;</a></li>
                  <li><a href="dashboard/#">1</a></li>
                  <li><a href="dashboard/#">2</a></li>
                  <li><a href="dashboard/#">3</a></li>
                  <li><a href="dashboard/#">&raquo;</a></li>
                </ul>
              </div> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
              <ul class="todo-list">
              
<?
    $sql = "SELECT * from stock_product WHERE limit_stock > 0 HAVING pcs <= limit_stock ";
    $num_row = mysql_num_rows(mysql_query($sql));
    $sql.="limit 20";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result) ) {

                print " <li>
                  <span class='handle'>
                        <i class='fa fa-ellipsis-v'></i>
                        <i class='fa fa-ellipsis-v'></i>
                      </span>
                      <span class='text'>$row[detail] จำนวน คงเหลือ : <span style='color:red;'>$row[pcs]</span></span>
                      </li>";
    }
?>
</ul>
            </div>
            <!-- /.box-body -->
<!--             <div class="box-footer clearfix no-border">
              <button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
            </div> -->
          </div>

          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-wrench"></i> ทะเบียนแจ้งซ่อม</h3>
            </div>
            <!-- /.box-header -->
            <?
            function status_color($str){

              switch ($str) {
                case "1": $str = "#80ff80"; break;
                case "2": $str = "#ffff66"; break;
                case "3": $str = "#ff9999"; break;

              }
              return $str;
            }

            function status_txt($str){
              switch ($str) {
                case "0": $str = "แจ้งซ่อม"; break;
                //case "1": $str = "แจ้งซ่อม"; break;
                case "1": $str = "รับแจ้งซ่อมแล้ว"; break;
                case "2": $str = "ซ่อมแล้ว"; break;

              }
              return $str;
            }
            ?>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>วันที่แจ้ง</th>
                  <th>เวลา</th>
                  <th>แผนก</th>
                  <th>ส่งซ่อม</th>
                  <th>อาการ</th>
                  <th>ประกันวันซ่อม</th>
                  <th>ผู้แจ้ง</th>
                  <th style="width:90px;">สถานะ</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <?
                 $sqls = "SELECT * from hirefix WHERE status < '9' ORDER By dateday ASC,times ASC ";
                 $results = mysql_query($sqls);
                 while ($fix = mysql_fetch_array($results) ) {
                echo "<tr><th>".substr($fix[dateday],8,2)." ".mount(substr($fix[dateday],5,2))." ".substr($fix[dateday],0,4)."</th>".
                     "<th>$fix[times]</th>".
                     "<th>".department_return($fix[department])."</th>".
                     "<th>$fix[product]</th>".
                     "<th>$fix[other]</th>".
                     "<th>";
                    if($fix[datefix]){
                    echo expdate($fix[date_recipt],$fix[datefix]);
                   }

                   echo   "</th>".
                     "<th>$fix[officer]</th>".
                     
                     "<th style='background-color:".status_color($fix[type_status_fix]).";'>".status_txt($fix[status])."</th>";
                    if($position=="Admin"){
                    echo "<th style='width:130px;'>".
                         "<button class='btn btn-success' onclick=\"window.location='egp2/hire_fix.php?row_id=".$fix[row_id]."'\"><li class='fa fa-edit'></li></button> ".
                         "<button class='btn btn-info' onclick=\"window.location='egp2/hire_fix_recipt.php?row_id=".$fix[row_id]."'\"><li class='fa fa-gear'></li></button> ".
                         "<button class='btn btn-danger' onclick=\"del_fix('$fix[row_id]','$fix[product]')\"><li class='fa fa-trash'></li></button>".
                         "</th>";    
                    }else if($fix[userid]==$_SESSION["xid"]){
                    echo "<th style='width:80px;'>".
                         "<button class='btn btn-success' onclick=\"window.location='egp2/hire_fix.php?row_id=".$fix[row_id]."'\"><li class='fa fa-edit'></li></button> ".
                         "<button class='btn btn-danger' onclick=\"del_fix('$fix[row_id]','$fix[product]')\"><li class='fa fa-trash'></li></button>".
                         "</th>";
                    }else if(substr_count($position,'ช่าง')>=1){
                    echo "<th style='width:80px;'>".
                         "<button class='btn btn-info' onclick=\"window.location='egp2/hire_fix_recipt.php?row_id=".$fix[row_id]."'\"><li class='fa fa-gear'></li></button> ".
                         "<button class='btn btn-danger' onclick=\"del_fix('$fix[row_id]','$fix[product]')\"><li class='fa fa-trash'></li></button>".
                         "</th>";                      
                    }
                 }
                ?>
                </tbody>
                <tfoot>
                  <th colspan="7" style="text-align: right;"> สถานะ <span style="color:<?=status_color(1)?>">&#9607;</span> ปกติ&nbsp;&nbsp;<span style="color:<?=status_color(2)?>;">&#9607;</span> ด่วน&nbsp;&nbsp;<span style="color:<?=status_color(3)?>;">&#9607;</span> ฉุกเฉิน&nbsp;&nbsp;</th>
                </tfoot>
<!--                 <tfoot>
                <tr>
                  <th>วันที่แจ้ง</th>
                  <th>เวลา</th>
                  <th>ส่งซ่อม</th>
                  <th>อาการ</th>
                  <th>ผู้แจ้ง</th>
                  <th>สถานะ</th>
                </tr>
                </tfoot> -->
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
</section>
<!-- jQuery 3 -->
<script src="dashboard/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="dashboard/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="dashboard/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="dashboard/bower_components/raphael/raphael.min.js"></script>
<script src="dashboard/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="dashboard/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="dashboard/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="dashboard/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="dashboard/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="dashboard/bower_components/moment/min/moment.min.js"></script>
<script src="dashboard/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="dashboard/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="dashboard/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="dashboard/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="dashboard/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<!-- <script src="dashboard/dist/js/adminlte.min.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dashboard/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="dashboard/dist/js/demo.js"></script> -->
</body>
</html>
