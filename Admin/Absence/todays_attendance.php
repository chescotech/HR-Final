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
        include_once '../Classes/Leave.php';
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Employee.php';
        $compID = $_SESSION['company_ID'];
        $EmployeeObject = new Employee();
        $leaveObject = new Leave();
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    echo $_SESSION['name'] . ' Employee Attendance Log';
                    ?>
                </h1>
            </section>
            <section class="content">
                <div class="row">
                    <div class="container">

                        <ul class="nav nav-pills">
                            <li class="active"><a data-toggle="pill" href="#home">Logged in</a></li>
                            <li><a data-toggle="pill" href="#menu1">Not logged in</a></li>
                        </ul>
                        <hr>
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">


                                <div class="col-xs-17">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table id="employee_data" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>Name</td>
                                                            <td>Check In Time</td>
                                                            <!-- <td>Check Out Time</td> -->
                                                            <!-- <td>Total Time Worked</td> -->
                                                            <!-- <td> Comment </td> -->
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $AbsentQuery = mysql_query("SELECT * FROM `attendance_logs` WHERE DATE(log_date) = DATE(NOW()) 
                                                                AND  company_id = '$compID' AND login_time != '' AND logout_time = '' ") or die(mysql_error());

                                                    while ($row = mysql_fetch_array($AbsentQuery)) {

                                                        $EmployeeName = $leaveObject->getEmployeeDetails($row['empno']);

                                                        $LogDate = $row['log_date'];
                                                        $LoginTime = $row['login_time'];
                                                        $LogoutTime = $row['logout_time'];
                                                        $comment = $row['comment'];

                                                        if ($LogoutTime == "") {
                                                            $LogoutTime = "Not Logged out";
                                                        } else {
                                                            $LogoutTime = $row['logout_time'];
                                                        }
                                                        if ($row['logout_time'] == "") {
                                                            $timeWorked = "";
                                                        } else {
                                                            $timeWorked = $leaveObject->timeDiff($LoginTime, $LogoutTime);
                                                        }

                                                        echo '  
                                                        <tr>  
                                                        <td>' . $EmployeeName . '</td>  
                                                        <td>' . $LoginTime . '</td>                                                                                                                                                                                      
                                                        </tr>          
                                                         ';
                                                    }
                                                    // }
                                                    ?>
                                                </table>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </div>
                            </div>

                            <div id="menu1" class="tab-pane fade">
                                <div class="col-xs-17">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table id="employee_data2" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>Name</td>
                                                            <td>Employee Number</td>
                                                            <td>Date</td>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $AbsentQuery = mysql_query("SELECT * FROM `emp_info`
                                                                    WHERE empno NOT IN (SELECT empno FROM `attendance_logs` WHERE DATE(log_date) = DATE(NOW()) 
                                                                    AND  company_id = '$compID' AND login_time != '' AND logout_time = '' )
                                                                    ") or die(mysql_error());

                                                    while ($row = mysql_fetch_array($AbsentQuery)) {

                                                        $EmployeeName = $leaveObject->getEmployeeDetails($row['empno']);

                                                        $empno = $row['empno'];
                                                        $fname = $row['fname'];

                                                        echo '  
                                                            <tr>  
                                                            <td>' . $EmployeeName . '</td>                                                                                                                                                      
                                                            <td>' . $empno . '</td>
                                                                 <td>' . date("l jS \of F Y ") . '</td>
                                                            </tr>          
                                                             ';
                                                    }
                                                    ?>
                                                </table>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
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
            $('#employee_data2').DataTable({
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