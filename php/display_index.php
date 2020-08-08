<?
session_start();
include("connect.inc");
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
