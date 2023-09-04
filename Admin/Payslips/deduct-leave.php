<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Deduct Leave Days</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.print.css" media="print">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script>
        $(function() {
            $("#datepicker").datepicker();
            $(document).ready(function() {
                // numeric validation.. 
                $("#numeric").keydown(function(event) {
                    if (event.keyCode == 46 || event.keyCode == 8) {
                        // let it happen, don't do anything
                    } else {
                        if (event.keyCode < 48 || event.keyCode > 57) {
                            event.preventDefault();
                        }
                    }
                });

                $("#numeric2").keydown(function(event) {
                    if (event.keyCode == 46 || event.keyCode == 8) {
                        // let it happen, don't do anything
                    } else {
                        if (event.keyCode < 48 || event.keyCode > 57) {
                            event.preventDefault();
                        }
                    }
                });

                $("#numeric3").keydown(function(event) {
                    if (event.keyCode == 46 || event.keyCode == 8) {
                        // let it happen, don't do anything
                    } else {
                        if (event.keyCode < 48 || event.keyCode > 57) {
                            event.preventDefault();
                        }
                    }
                });

                $("#numeric4").keydown(function(event) {
                    if (event.keyCode == 46 || event.keyCode == 8) {
                        // let it happen, don't do anything
                    } else {
                        if (event.keyCode < 48 || event.keyCode > 57) {
                            event.preventDefault();
                        }
                    }
                });


            });

        });
    </script>
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/Department.php';
        include_once '../Classes/Payslips.php';
        include_once '../Classes/Loans.php';
        include_once '../Classes/Tax.php';
        $LoanObject = new Loans();
        $DepartmentObject = new Department();
        $PaySlipsObject = new Payslips();
        $TaxObject = new Tax();

        include '../navigation_panel/authenticated_user_header.php';
        //$companyId = $_SESSION['username'];
        $compId = $_SESSION['company_ID'];
        ?>

        <?php
        include '../navigation_panel/side_navigation_bar.php';
        include_once '../Classes/Leave.php';
        $leaveObject = new Leave();
        ?>

        <?php
        if (isset($_POST['save'])) {
            $message = "";
            $empno = $_POST['empno'];
            $leave_type = $_POST['leave_type'];
            $days_leave = $_POST['days_leave'];
            $LeaveStartdate = $_POST['start_date'];
            $leaveEndDate = $_POST['end_date'];

            // convert date format to y-m-d
            $startDate = strtotime($LeaveStartdate);
            $startDateConverted = date('Y-m-d', $startDate);

            $EndDate = strtotime($leaveEndDate);
            $EndDateConverted = date('Y-m-d', $EndDate);

            if ($days_leave <= $leaveObject->getEmployeeLeaveBal($empno)) {
                $message = "valid";
                $status = "Approved";
                $leaveObject->applyLeave($startDateConverted, $EndDateConverted, $leave_type, $empno, "Leave by Admin on behalf of employee", "", "", "", "");
                mysql_query("UPDATE leave_days SET available = available - '$days_leave' WHERE empno= '$empno'") or die(mysql_error());
                mysql_query("UPDATE leave_applications_tb SET status ='$status' WHERE empno= '$empno'") or die(mysql_error());
            } else {
                $message = "You do not have suffient leave days to apply for a leave!!";
            }
        ?>
        <?php
        }
        ?>

        <div class="content-wrapper">

            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <a href="" class="btn btn-primary btn-block margin-bottom">Back</a>
                    </div>
                    <div class="col-md-5">
                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <?php
                                    if (isset($_POST['save'])) {
                                        if ($message == "valid") {
                                            echo ' <center>
                                            <h3 style="color: green" class="box-title"><b>Leave was sucessfully Inputed.</b></h3>
                                        </center>';
                                        } else {
                                            echo ' <center>
                                            <h3 style="color: red" class="box-title"><b>' . $message . '</b></h3>
                                        </center>';
                                        }
                                    } else {
                                        echo ' <center>
                                            <h3 style="color: black" class="box-title"><b>Deduct Leave from Employee.</b></h3>
                                        </center>';
                                    }
                                    ?>
                                </div>
                                <div class="box-body">
                                    <label>Employee Name:</label>
                                    <div class="form-group">
                                        <select name="empno" class="form-control">
                                            <option>-- Select Employee to add --</option>
                                            <?php
                                            $result = mysql_query("SELECT * FROM emp_info  INNER JOIN leave_days on leave_days.empno=emp_info.empno WHERE company_id = '$compId'");
                                            $departmentquery = $DepartmentObject->getAllEmployeesByCompany($compId);
                                            while ($row = mysql_fetch_array($result)) {
                                                $fname = $row['fname'];
                                                $lname = $row['lname'];
                                                $position = $row['position'];
                                                $leave_days = $row['available'];
                                            ?>
                                                <option value="<?php echo $row['empno']; ?>"> <?php echo $fname . " " . $lname . " - " . $position . " - Days -" . $leave_days ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label>Leave Starting date:</label>
                                    <input type="text" required="required" id="datepicker" name="start_date" class="form-control" placeholder="Leave Starting Date:" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label>Leave Ending date:</label>
                                    <input required="required" id="end_datepicker" name="end_date" class="form-control" placeholder="Leave Ending Date:" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label>Select Leave Type:</label>
                                    <select id="leave_type" name="leave_type" class="form-control">
                                        <option>--Select Leave Type--</option>
                                        <?php
                                        $comp_ID = $_SESSION['company_ID'];
                                        $AllDepartments = $leaveObject->getLeaveTypes($comp_ID);
                                        while ($row = mysql_fetch_array($AllDepartments)) {
                                        ?>
                                            <option value="<?php echo $row['leave_type'] ?>">
                                                <?php echo $row['leave_type']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="box-body">
                                    <label>Number of Leave Days:</label>
                                    <div class="form-group">
                                        <input required="required" name="days_leave" id="numeric" class="form-control" placeholder="Number of Leave Days :">
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button name="save" type="submit" class="btn btn-primary"></i>Save</button>
                                    </div>
                                    <button onclick="window.history.back();" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                </div>

                            </div>

                        </form>

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <?php include '../footer/footer.php'; ?>

        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- Slimscroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- iCheck -->
    <script src="../plugins/iCheck/icheck.min.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

    <script>
        $(document).ready(function() {
            Date.bizdays = function(d1, d2) {
                var bd = 0,
                    dd, incr = d1.getDate();
                while (d1 < d2) {
                    d1.setDate(++incr);
                    dd = d1.getDay();
                    if (dd % 6)
                        ++bd;
                }
                return bd;
            };

            $("#datepicker").datepicker();
            $("#end_datepicker").datepicker();
            $("#leave_type").blur(function() {
                var startDate = new Date($("#datepicker").val());
                var EndDate = new Date($("#end_datepicker").val());

                console.log('date1', startDate);
                console.log('date2', EndDate);

                var timeDiff = Math.abs(startDate.getTime() - EndDate.getTime());
                var diffDays = Date.bizdays(startDate, EndDate);

                var availableDays = $("#no_days_avail").val();
                //alert('Days'+availableDays);

                $checkLeaveType = $("#leave_type").val();
                $("#no_leave_selected").slideDown("slow", function() {
                    if ($checkLeaveType === "Annual Leave" || $checkLeaveType === "Casual Leave") {
                        if (availableDays >= diffDays) {
                            $("#leave_period").css('color', 'green');
                            $("#leave_period").html("Applying for " + diffDays + " Days " + $checkLeaveType);
                        } else {
                            $("#leave_period").css('color', 'red');
                            $("#leave_period").html("Cannot apply for " + diffDays + " days Leave");
                        }
                    } else {
                        $("#leave_period").css('color', 'green');
                        $("#leave_period").html("Applying for " + diffDays + " Days " + $checkLeaveType);
                    }
                });

            });
        });
    </script>
</body>

</html>