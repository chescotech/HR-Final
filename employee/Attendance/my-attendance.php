<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>My Attendance</title>
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
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Attendance.php';
        $AttendanceObject = new Attendance();
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    echo 'My attendance log';
                    ?>
                </h1>
            </section>
            <section class="content container">
                <div class="row">
                    <div class="col-xs-17">
                        <h4>Get for specific month</h4>
                        <form action="my-attendance" method="post">
                            <table cellpadding="" border="0" class="se">
                                <tr>
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

                                            $empno = $_SESSION['employee_id'];

                                            $AbsentQuery = $AttendanceObject->getAttendanceLogList($convertedDate, $compID, $empno);
                                        } else {
                                            $AbsentQuery = mysql_query("SELECT * FROM attendance_logs WHERE
                                                company_id = '$companyId' AND  empno = '$empno'") or die(mysql_error());
                                        }
                                        while ($row = mysql_fetch_array($AbsentQuery)) {
                                            $EmployeeName = $AttendanceObject->getEmployeeDetails($row['empno']);
                                            $LogDate = $row['log_date'];
                                            $LoginTime = $row['login_time'];
                                            $comment = $row['comment'];
                                            $LogoutTime = $row['logout_time'];
                                            if ($LogoutTime == "") {
                                                $LogoutTime = "Not Logged out";
                                            } else {
                                                $LogoutTime = $row['logout_time'];
                                            }
                                            if ($row['logout_time'] == "") {
                                                $timeWorked = "";
                                            } else {
                                                $timeWorked = $AttendanceObject->timeDiff($LoginTime, $LogoutTime);
                                            }


                                            echo '  
                                                    <tr>  
                                                    <td>' . $EmployeeName . '</td>  
                                                    <td>' . $LogDate . '</td> 
                                                    <td>' . $LoginTime . '</td>                                    
                                                    <td>' . $LogoutTime . '</td>                                               
                                                    <td>' . $timeWorked . '</td> 
                                                    ';
                                        ?>
                                            <td>
                                                <?php echo $comment; ?>
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal<?php echo $row['id'] ?>">+</button>
                                            </td>
                                            </tr>
                                            <!-- Modal -->
                                            <div id="myModal<?php echo $row['id'] ?>" class="modal fade" role="dialog">
                                                <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Add Comment</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="" method="post">
                                                                <div class="box-body">
                                                                    <label>Add Comment:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                                                    <div class="form-group">
                                                                        <input type="hidden" name="empno" value="<?php echo $empno; ?>">
                                                                        <input type="hidden" name="LogDate" value="<?php echo $LogDate; ?>">
                                                                        <textarea required="required" name="comment" class="form-control"><?php echo $comment; ?></textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-default"> Save </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php
                                        }

                                        if (isset($_POST['comment'])) {
                                            $empno = $_POST['empno'];
                                            $LogDate = $_POST['LogDate'];
                                            $comment = $_POST['comment'];
                                            $add_c = mysql_query("UPDATE attendance_logs SET comment = '$comment'
                                                    WHERE empno = '$empno' AND log_date = '$LogDate' ") or die(mysql_error());

                                            if ($add_c) {
                                                echo "<script> window.location='my-attendance' </script>";
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