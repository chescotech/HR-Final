<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>My Department</title>
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

        $emp_no = $_SESSION['empno'];
        $gt_dep = mysqli_query($link, "SELECT dept,department.department FROM emp_info INNER JOIN department on department.dep_id=emp_info.dept WHERE empno = '$emp_no' ") or die(mysqli_error($link));
        $gt_dep_r = mysqli_fetch_array($gt_dep);
        $dep_id = $gt_dep_r['dept'];
        $department = $gt_dep_r['department'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">

            <section class="content container">
                <div class="row">
                    <div class="col-xs-17">
                        <h4><u>My Department View (<?php echo $department; ?> ) </u></h4>
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
                                                <td>Position</td>
                                                <td>Employee Number</td>
                                            </tr>
                                        </thead>
                                        <?php
                                        $checkifParentSupervisor = mysqli_query($link, "SELECT * FROM `hod_tb` where parent_supervisor='$emp_no'") or die(mysqli_error($link));
                                        if (mysqli_num_rows($checkifParentSupervisor) > 0) {
                                            $Query = mysqli_query($link, "select * FROM emp_info WHERE emp_info.empno IN (  SELECT empno FROM `hod_tb` where parent_supervisor='$emp_no')") or die(mysqli_error($link));
                                        } else {
                                            $Query = mysqli_query($link, "select * FROM emp_info WHERE dept = '$dep_id' ") or die(mysqli_error($link));
                                        }
                                        //$Query = mysqli_query($link,"SELECT * FROM `emp_info` WHERE dept = '$dep_id' ");

                                        while ($row = mysqli_fetch_array($Query)) {
                                            $EmployeeName = $AttendanceObject->getEmployeeDetails($row['empno']);
                                            $Names = $row['fname'] . ' ' . $row['lname'];
                                            $position = $row['position'];
                                            $empno = $row['empno'];

                                            echo '  
                                                    <tr>  
                                                    <td>' . $Names . '</td>  
                                                    <td>' . $position . '</td> 
                                                    <td>' . $empno . '</td>                                    
                                                   
                                                    ';
                                        ?>

                                            </tr>
                                            <!-- Modal -->
                                            <div id="myModal" class="modal fade" role="dialog">
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
                                            $add_c = mysqli_query($link, "UPDATE attendance_logs SET comment = '$comment'
                                                    WHERE empno = '$empno' AND log_date = '$LogDate' ") or die(mysqli_error($link));

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