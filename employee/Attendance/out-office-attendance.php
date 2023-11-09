<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Leave Application</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js">
    </script>

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Leave.php';
        $leaveObject = new Leave();
        include_once '../../Admin/Classes/Company.php';
        $CompanyObject = new Company();
        require_once('../../PHPmailer/sendmail.php');
        $companyId = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        // Get all hollidays from db


        // echo number_of_working_days("2020-01-01", "2020-12-30");

        if (isset($_POST['apply'])) {
            include_once '../Classes/Attendance.php';
            $empno = $_SESSION['employee_id'];
            $AttendanceObject = new Attendance();
            $company_id = $_SESSION['company_ID'];
            $mssage = "";

            $timestamp = strtotime($_POST['start_date']);
            $new_date_format = date('Y-m-d H:i:s', $timestamp);

            $timestamp_ = strtotime($_POST['end_date']);
            $new_date_format_ = date('Y-m-d H:i:s', $timestamp_);

            $checkLoginDate = date('Y-m-d', $timestamp);
            $checklogoutDate =  date('Y-m-d', $timestamp_);


            $login_time = $new_date_format;;
            $logout_time = $new_date_format_;;
            $comment = $_POST['comment'];

            //echo 'end'.$leaveEndDate;
            $log_date = date("Y/m/d");


            echo 'checkLoginDate' . $checkLoginDate;

            // check if the date has already been checked in...

            $log_q = mysqli_query($link, "SELECT * FROM attendance_logs WHERE empno = '$empno' AND DATE(login_time) = '$checkLoginDate'  AND DATE(logout_time)='$checklogoutDate'
            ") or die(mysqli_error($link));
            if (mysqli_num_rows($log_q) > 0) {
                // if records already exsist then show errors, 

                echo '<center><h3 style="color: red" class="box-title"><b>                                                    
              Error, there is already a record of your attendance for ' . $log_date . ' date                                     
             </b></h3></center>';
            } else if ($checkLoginDate > date("Y-m-d") || $checklogoutDate > date("Y-m-d")) {
                echo '<center><h3 style="color: red" class="box-title"><b>                                                    
                Error, can not check in a future date. Please select a valid date.                                  
               </b></h3></center>';
            } else {
                // else.. log attendance...
                $AttendanceObject->outOfficeCheckin($empno, $company_id, $log_date, $login_time, $logout_time, $comment);

                echo '<center><h3 style="color: green" class="box-title"><b>                                                    
                Successfully logged your attendance                                      
                </b></h3></center>';
            }
        }
        // echo 'super '.$supervisorsEmial;

        ?>

        <div class="content-wrapper">
            <section class="content-header">
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <a href="../index.php" class="btn btn-primary btn-block margin-bottom">Back</a>
                        <div class="box box-solid">


                            <div class="box-header with-border">
                                <span style="color: black" id="leave_period"><b>
                                        Log your Out of office Attendance
                                    </b></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <center>
                                        <?php
                                        if (isset($_POST['apply'])) {
                                            if ($mssage == "success, please wait for your supervisor to respond to your request.") {
                                                echo '<h3 style="color: green" class="box-title"><b>                                                    
                                                    ' . $mssage . '                                               
                                                </b></h3>';
                                            } else {
                                                echo '<h3 style="color: red" class="box-title"><b>                                                    
                                                    ' . $mssage . '                                               
                                                </b></h3>';
                                            }
                                        } else {
                                            echo '<h3 style="color: black" class="box-title"><b>                                                    
                                                    PLease Fill in details below.                                                
                                                </b></h3>';
                                        }
                                        ?>

                                    </center>
                                </div>
                                <div class="box-body">

                                    <div class="form-group">
                                        <label>Date and Time Logged in:</label>
                                        <input type="text" required="required" id="datepicker" name="start_date" class="form-control" placeholder="Date and Time Logged in:" autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label>Date and Time Logged Out:</label>
                                        <input type="text" required="required" id="datepicker_" name="end_date" class="form-control" placeholder="Date and Time Logged Out:" autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label>Add a Comment:</label>
                                        <textarea type="text" required="required" name="comment" class="form-control" placeholder="Add a Comment" autocomplete="off"></textarea>
                                    </div>

                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>
                                        <button name="apply" type="submit" class="btn btn-primary"></i>Save</button>
                                    </div>
                                    <button class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                </div>
                            </div>
                        </form>

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <?php include '../footer/footer.php'; ?>

        <div class="control-sidebar-bg"></div>
    </div>

    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>

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

            $("#datepicker").datetimepicker();
            $("#datepicker_").datetimepicker();
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
                            // $("#leave_period").css('color', 'green');
                            // $("#leave_period").html("Applying for " + diffDays + " Days " + $checkLeaveType);
                        } else {
                            // $("#leave_period").css('color', 'red');
                            // $("#leave_period").html("Cannot apply for " + diffDays + " days Leave");
                        }
                    } else {
                        // $("#leave_period").css('color', 'green');
                        //$("#leave_period").html("Applying for " + diffDays + " Days " + $checkLeaveType);
                    }
                });

            });
        });
    </script>

</body>

</html>