 <?
session_start();

include("../connect.inc");

  // $sql = "SELECT position,bill_in_edit,bill_out_edit,limitstock from user_account WHERE username = '".$_SESSION["xusername"]."' ";
  // list($position,$bill_in_edit,$bill_out_edit,$limitstock) = Mysql_fetch_row(Mysql_Query($sql));
  $sql = "SELECT position from user_account WHERE username = '".$_SESSION["xusername"]."' ";
  list($position) = Mysql_fetch_row(Mysql_Query($sql));
  
function department_return($str){
    $sql = "SELECT name from department WHERE code = '$str' ";
  list($name) = Mysql_fetch_row(Mysql_Query($sql));
  return $name;
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
   <title>รายงานแจ้งซ่อม</title>
     <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../dashboard/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../dashboard/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../dashboard/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dashboard/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dashboard/dist/css/skins/_all-skins.min.css">
    <!-- DataTables -->
  <link rel="stylesheet" href="../dashboard/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">
    .xhover:hover{
      cursor: pointer;
      background-color: #85e0ff;
    }
  </style>
 </head>
 <body>
 
 <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">ทะเบียนแจ้งซ่อม</h3>
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
                case "1": $str = "รับแจ้งซ่อมแล้ว"; break;
                case "2": $str = "ซ่อมแล้ว"; break;

              }
              return $str;
            }

            function status_return($str){
              switch ($str) {
                case "1": $str = "ใช้งานปกติ"; break;
                case "2": $str = "ไม่สามารถซ่อมได้"; break;
                case "3": $str = "รอจำหน่าย"; break;
                case "4": $str = "รออะไหล่"; break;

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
                     "<th>$fix[officer]</th>".
                     "<th style='background-color:".status_color($fix[type_status_fix]).";'>".status_txt($fix[status])."</th>";
                    if($position=="011"){
                    echo "<th style='width:130px;'>".
                         "<button class='btn btn-success' onclick=\"window.location='hire_fix.php?row_id=".$fix[row_id]."'\"><li class='fa fa-edit'></li></button> ".
                         "<button class='btn btn-info' onclick=\"window.location='hire_fix_recipt.php?row_id=".$fix[row_id]."'\"><li class='fa fa-gear'></li></button> ".
                         "<button class='btn btn-danger' onclick=\"del_fix('$fix[row_id]','$fix[product]')\"><li class='fa fa-trash'></li></button>".
                         "</th>";    
                    }else if($fix[userid]==$_SESSION["xid"]){
                    echo "<th style='width:80px;'>".
                         "<button class='btn btn-success' onclick=\"window.location='hire_fix.php?row_id=".$fix[row_id]."'\"><li class='fa fa-edit'></li></button> ".
                         "<button class='btn btn-danger' onclick=\"del_fix('$fix[row_id]','$fix[product]')\"><li class='fa fa-trash'></li></button>".
                         "</th>";
                    }else if($position=='012'){
                    echo "<th style='width:80px;'>".
                         "<button class='btn btn-info' onclick=\"window.location='hire_fix_recipt.php?row_id=".$fix[row_id]."'\"><li class='fa fa-gear'></li></button> ".
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
          </div><br><br>



 <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">รายงานซ่อม</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>วันที่ส่งคืน</th>
                  <th>แผนก</th>
                  <th>อุปกรณ์/วัสดุ</th>
                  <th>อาการ</th>
                  <th>ผู้แจ้ง</th>
                  <th style="width:90px;">สถานะ</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <?
                 $sqls = "SELECT * from hirefix WHERE status >= '9' ORDER By date_return ASC,times ASC ";
                 $results = mysql_query($sqls);
                 while ($fix = mysql_fetch_array($results) ) {
                echo "<tr><th>".substr($fix[date_return],8,2)." ".mount(substr($fix[date_return],5,2))." ".substr($fix[date_return],0,4)."</th>".
                     "<th>".department_return($fix[department])."</th>".
                     "<th>$fix[product]</th>".
                     "<th>$fix[other]</th>".
                     "<th>$fix[officer_recipt]</th>".
                     "<th>".status_return($fix[type_status_return])."</th>";
                    if($position=="Admin"){
                    echo "<th style='width:130px;'>".
                         "<button class='btn btn-danger' onclick=\"del_fix('$fix[row_id]','$fix[product]')\"><li class='fa fa-trash'></li></button>".
                         "</th>";    
                    }else if(substr_count($position,'ช่าง')>=1){
                    echo "<th style='width:80px;'>".
                         "<button class='btn btn-danger' onclick=\"del_fix('$fix[row_id]','$fix[product]')\"><li class='fa fa-trash'></li></button>".
                         "</th>";                      
                    }
                 }
                ?>
                </tbody>

              </table>
            </div>
            <!-- /.box-body -->
          </div>

           </body>
 </html>
 <!-- jQuery 3 -->
<script src="../dashboard/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../dashboard/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
 // $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="../dashboard/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="../dashboard/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../dashboard/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
</body>
</html>
  <script type="text/javascript">
    function del_fix(rd,tl){
        var r = confirm("ต้องการยกเลิกใบแจ้งซ่อม "+tl+" ใช่หรือไม่");
        if(r==true){
          $.ajax({type: "POST",url: "mysql_fix.php",data:"submit=del_fix&row_id="+rd });
          location.reload();
        }

    }
  </script>
  <script>
  $(function () {
    $('#example1').DataTable();
     $('#example2').DataTable();
  })
</script>