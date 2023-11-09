<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Attendance Log</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css" />

    <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker();
        });
    </script>
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        // include_once '../Classes/Leave.php';
        include '../navigation_panel/authenticated_user_header.php';
        // include_once '../Classes/Employee.php';
        $compID = $_SESSION['company_ID'];
        // get boss department.
        $emp_no = $_SESSION['empno'];
        $gt_dep = mysqli_query($link, "SELECT dept FROM emp_info WHERE empno = '$emp_no' ") or die(mysqli_error($link));
        $gt_dep_r = mysqli_fetch_array($gt_dep);
        $dep_id = $gt_dep_r['dept'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    echo ' Employee Attendance Log';
                    ?>
                </h1>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-xs-17">
                        <a href="attendance.php">
                            <button id="save" type="button" class="btn btn-primary"></span>Back to Department Attendance
                            </button>
                        </a>
                        <br> <br>
                        <!-- /.box-body
                            <a href="nill-attendance.php?full=true"> 
                                <button   id="save" type="button" class="btn btn-primary"></span> Full Report of employees not Logged in Department 
                                </button>
                            </a>
                             -->
                    </div>
                    <br>
                    <div class="col-xs-17">
                        <div class="box">
                            <span style="color: black" id="leave_period"><b>
                                    <?php
                                    if (isset($_GET['full'])) {
                                        echo '<center><h3>Full Report of employees not logged  in Department </h3> </center>';
                                    } else {
                                        echo '<center><h3>Employees Not Logged in Today </h3> </center>';
                                    }
                                    ?>
                                </b></span>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="employee_data" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <td>Name</td>
                                                <td>Date</td>
                                                <td>Employee Number </td>
                                                <td>Position </td>
                                            </tr>
                                        </thead>
                                        <?php
                                        if (isset($_GET['full'])) {
                                            $AbsentQuery = mysqli_query($link, "SELECT * FROM `emp_info`
                                                                    WHERE empno NOT IN (SELECT empno FROM `attendance_logs` WHERE  login_time != ''    )  AND dept='$dep_id'
                                                                    ") or die(mysqli_error($link));
                                        } else {
                                            // $AbsentQuery = mysqli_query($link,"SELECT * FROM `attendance_logs` WHERE DATE(log_date) = DATE(NOW()) AND  company_id = '$compID' ") or die(mysqli_error($link));
                                            $AbsentQuery = mysqli_query($link, "SELECT * FROM `emp_info`
                                                                    WHERE empno NOT IN (SELECT empno FROM `attendance_logs` WHERE DATE(log_date) = DATE(NOW()) 
                                                                    AND  company_id = '$compID' AND login_time != '' AND logout_time = ''   )  AND dept='$dep_id'
                                                                    ") or die(mysqli_error($link));
                                        }


                                        while ($row = mysqli_fetch_array($AbsentQuery)) {

                                            $empno = $row['empno'];
                                            $fname = $row['fname'];
                                            $lname = $row['lname'];
                                            $EmployeeName = $fname . " " . $lname;
                                            $position = $row['position'];

                                            echo '  
                                                        <tr>  
                                                        <td>' . $EmployeeName . '</td>  
                                                     <td>' . date("l jS \of F Y ") . '</td>
                                                        <td>' . $empno . '</td>                                    
                                                        <td>' . $position . '</td>                                              
                                                                                                                                                                                                           
                                                        </tr>          
                                                         ';
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div>
        <?php include '../footer/footer.php'; ?>
        <div class="control-sidebar-bg"></div>
    </div>
    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>

    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>

    <script src="../plugins/fastclick/fastclick.min.js"></script>

    <script src="../dist/js/app.min.js"></script>

    <script src="../dist/js/demo.js"></script>
    <script>
        $(document).ready(function() {
            $('#employee_data').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'print'
                ]
            });

            $("#datepicker").datepicker();
            $("#datepicker2").datepicker();
        });
    </script>
</body>

</html>