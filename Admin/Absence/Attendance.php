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
                    <div class="col-xs-17">
                        <form action="Attendance" method="post">
                            <table cellpadding="" border="0" class="se">
                                <tr>
                                    <td>
                                        <select name="empno" class="form-control">
                                            <option value="all">Select All Employees</option>
                                            <?php
                                            $Query = $EmployeeObject->getAllEmployeesByCompany($compID);
                                            while ($row = mysql_fetch_array($Query)) {
                                                $fname = $row['fname'];
                                                $lname = $row['lname'];
                                            ?>
                                                <option value="<?php echo $row['empno']; ?>"> <?php echo $fname . " " . $lname ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>

                                    <div class="form-group col-md-3">
                                        <select name="dept_fillter" class="form-control">
                                            <option value="all">-- All Departments --</option>
                                            <?php
                                            $qq2 = mysql_query("SELECT dep_id, department FROM department");
                                            while ($rr2 = mysql_fetch_array($qq2)) {
                                            ?>
                                                <option value="<?php echo $rr2['dep_id']; ?>"> <?php echo $rr2['department']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <td>
                                        <input autocomplete="off" required="required" id="datepicker" name="search_month" class="form-control" placeholder="Attendance Month">
                                    </td>
                                    <td>
                                        <button type="submit" name="search" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span>Generate
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <br>
                    <div class="col-xs-17">
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="employee_data" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <td>Name</td>
                                                <td>Dept</td>
                                                <td>Log Date</td>
                                                <td>Check In Time</td>
                                                <td>Check Out Time</td>
                                                <td>Total Time Worked</td>
                                                <td> Comment </td>
                                            </tr>
                                        </thead>
                                        <?php
                                        if (isset($_POST['search'])) {

                                            $compID = $_SESSION['company_ID'];
                                            $logDate = strtotime($_POST['search_month']);
                                            $convertedDate = date('m/d/Y', $logDate);
                                            $dept_fillter = $_POST['dept_fillter'];

                                            if ($dept_fillter == "all") {
                                                $filter_by_dept = " ";
                                            } else {
                                                $filter_by_dept = " AND emp_info.dept = '$dept_fillter' ";
                                            }

                                            $empno = $_POST['empno'];
                                            if ($empno == "all") {

                                                $arr = explode("/", $convertedDate);
                                                //echo '$logDate'.$logDate;
                                                list($Getmonth, $Getday, $GetYear) = $arr;

                                                $year = $GetYear;
                                                $month = $Getmonth;
                                                $day = $Getday;

                                                $firstDate = $year . "/" . $month . "/" . "01";
                                                $endDate = $year . "/" . $month . "/" . "31";
                                                $AbsentQuery = mysql_query("SELECT * FROM attendance_logs
                                                    inner join emp_info on emp_info.empno=attendance_logs.empno     
                                                    WHERE
                                                    emp_info.company_id = '$compID' AND log_date BETWEEN '$firstDate' AND '$endDate'     $filter_by_dept ") or die(mysql_error());

                                                echo "SELECT * FROM attendance_logs
                                                    inner join emp_info on emp_info.empno=attendance_logs.empno     
                                                    WHERE
                                                    emp_info.company_id = '$compID' AND log_date BETWEEN '$firstDate' AND '$endDate'     $filter_by_dept ";
                                            } else {

                                                $arr = explode("/", $convertedDate);
                                                //echo '$logDate'.$logDate;
                                                list($Getmonth, $Getday, $GetYear) = $arr;

                                                $year = $GetYear;
                                                $month = $Getmonth;
                                                $day = $Getday;

                                                $firstDate = $year . "/" . $month . "/" . "01";
                                                $endDate = $year . "/" . $month . "/" . "31";
                                                $AbsentQuery = mysql_query("SELECT * FROM attendance_logs
                                                    inner join emp_info on emp_info.empno=attendance_logs.empno     
                                                    WHERE
                                                     emp_info.company_id  = '$compID' AND log_date BETWEEN '$firstDate' AND '$endDate'  AND  emp_info.empno = '$empno'   $filter_by_dept ") or die(mysql_error());
                                                //$AbsentQuery = $leaveObject->getAttendanceLogList($convertedDate, $compID, $empno);
                                            }


                                            while ($row = mysql_fetch_array($AbsentQuery)) {

                                                $EmployeeName = $leaveObject->getEmployeeDetails($row['empno']);
                                                $dep_name = $leaveObject->getEmployeeDepartment($row['empno']);

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
                                                        <td>' . $dep_name . '</td> 
                                                        <td>' . $LogDate . '</td> 
                                                        <td>' . $LoginTime . '</td>                                    
                                                        <td>' . $LogoutTime . '</td>                                               
                                                        <td>' . $timeWorked . '</td>                                                                              
                                                        <td>' . $comment . '</td>                                                                              
                                                        </tr>          
                                                         ';
                                            }
                                        } else {

                                            $AbsentQuery = mysql_query("SELECT * FROM `attendance_logs` WHERE DATE(log_date) = DATE(NOW()) AND  company_id = '$compID' ") or die(mysql_error());

                                            while ($row = mysql_fetch_array($AbsentQuery)) {

                                                $EmployeeName = $leaveObject->getEmployeeDetails($row['empno']);
                                                $dep_name = $leaveObject->getEmployeeDepartment($row['empno']);

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
                                                        <td>' . $dep_name . '</td>  
                                                        <td>' . $LogDate . '</td> 
                                                        <td>' . $LoginTime . '</td>                                    
                                                        <td>' . $LogoutTime . '</td>                                               
                                                        <td>' . $timeWorked . '</td>   
                                                        <td>' . $comment . '</td>                                                                                                                                                         
                                                        </tr>          
                                                         ';
                                            }
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