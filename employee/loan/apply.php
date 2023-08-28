<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Loan Application</title>
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
    <style>
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid blue;
            border-bottom: 16px solid blue;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<script>
    $(document).ready(function() {
        $('#loader_btn').submit(function() {
            $('#loaderIcon').css('visibility', 'visible');
            $('#loaderIcon').show();
        });
    })
</script>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/Loan.php';
        $loanObject = new Loan();
        include_once '../../Admin/Classes/Company.php';
        $CompanyObject = new Company();
        require_once('../../PHPmailer/sendmail.php');
        include '../navigation_panel/authenticated_user_header.php';
        $companyId = $_SESSION['company_ID'];
        $empno = $_SESSION['employee_id'];

        $result = mysql_query("SELECT * FROM emp_info where empno='$empno'") or die(mysql_error());
        $row = mysql_fetch_array($result);
        $full_names = $row['fname'] . "-" . $row['lname'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['save'])) {
            // *Check if there's a pending loan first
            $res = mysql_query("SELECT * FROM loan_applications WHERE empno='$empno' AND status = 'Pending Approval' ");
            if (mysql_num_rows($res) > 0) {
                echo "<script> alert('Error! You already have a pending loan.') </script>";
                echo "<script> window.location='apply' </script>";
                die();
            }

            $message = "";
            $loan_amount = $_POST['loan_amount'];
            $loanStartDate = $_POST['date_start'];
            $loanEndDate = $_POST['date_end'];
            $loanType = $_POST['loan_type'];
            $months = $_POST['months'];
            $monthly_deduction = $_POST['monthly_deduction'];

            //              validate Duration
            $result = mysql_query("SELECT * FROM loan_tb where loan_type='$loanType'");
            if ($result) {
                echo "<script> console.log('validating'); </script>";
                $row = mysql_fetch_assoc($result);

                $max_time = $row['max_repayment'];
                $approver_email = $row['approver_email'];

                if ($months > $max_time) {
                    //                        echo "<script> window.location='apply' </script>";
                    $errMessage = "Error! Your duration exceeds the maximum allowed by this loan type.";
                    //                        echo "<script> window.location='apply' </script>";
                } else {
                    // convert date format to y-m-d
                    $startDate = strtotime($loanStartDate);
                    $startDateConverted = date('Y-m-d', $startDate);

                    $EndDate = strtotime($loanEndDate);
                    $EndDateConverted = date('Y-m-d', $EndDate);

                    $loanObject->applyLoan($loan_amount, $loanType, $empno, $months, $monthly_deduction, $startDateConverted, $EndDateConverted, $companyId);

                    //       send email to approver
                    $emp_query = mysql_query("SELECT * FROM `emp_info` WHERE empno = '$empno'");
                    $employee = mysql_fetch_array($emp_query);
                    $fname = $employee['fname'];
                    $lname = $employee['lname'];

                    $em = new email();

                    $image = '<img src="' . $CompanyObject->getCompanyLogo4($companyId) . '" width="100%" height="290" class="img-thumbnail" />';

                    $message = "Greetings," . "<br>" . "<br>"
                        . "You have a loan application request from " . "$fname" . " " . "$lname" . ". "
                        . "Please login to your account to Approve or Decline this request."
                        . "<br>" . "<br>" . " Kind Regards."
                        . "<br>" . "<br>" . "<br>" . "<br>"
                        . $image;

                    $Subject = "Loan Aplication";

                    $em->send_mail($approver_email, $message, $Subject);

                    $message = "success, please wait for the admin to respond to your request.";
                }
            } else {
                echo "<script> alert('This loan type could not be found.') </script>";
                echo "<script> window.location='apply' </script>";
                die();
            }
        }
        ?>

        <div class="content-wrapper">
            <section class="content-header">
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <a href="../index.php" class="btn btn-primary btn-block margin-bottom">Back</a>
                        <div class="box box-solid">
                            <div hidden="hidden" id="no_leave_selected" class="box-header with-border">
                                <span style="color: green" id="leave_period"><b></b></span>
                            </div>

                            <div class="box-header with-border">
                                <span style="color: black" id="leave_period"><b>
                                    </b></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <?php
                                    if (isset($_POST['save'])) {
                                        echo $message ? '
                                                <center>
                                                    <h3 style="color: green" class="box-title"><b>' . $message . '</b></h3>
                                                </center>
                                            ' : '
                                                <center>
                                                    <h3 style="color: red" class="box-title"><b>' . $errMessage . '</b></h3>
                                                </center>';
                                    } else {
                                        echo ' <center>
                                            <h3 style="color: black" class="box-title"><b>Loan Entry</b></h3>
                                        </center>';
                                    }
                                    ?> </div>

                                <div class="box-body">
                                    <label>Loan Amount:</label>
                                    <div class="form-group">
                                        <input required="required" name="loan_amount" class="form-control" placeholder="Loan Amount :">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Select Loan Type:</label>
                                    <select id="loan_type" name="loan_type" class="form-control" required="">
                                        <option>--Select Loan Type--</option>
                                        <?php
                                        $comp_ID = $_SESSION['company_ID'];
                                        $AllLoanTypes = $loanObject->getLoanTypes($comp_ID);
                                        while ($row = mysql_fetch_array($AllLoanTypes)) {
                                        ?>
                                            <option value="<?php echo $row['loan_type'] ?>">
                                                <?php echo $row['loan_type']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="box-body">
                                    <label>Months:</label>
                                    <div class="form-group">
                                        <input required="required" name="months" class="form-control" placeholder="Loan Duration in Months:" autocomplete="off">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Monthly Deduction:</label>
                                    <div class="form-group">
                                        <input required="required" name="monthly_deduction" class="form-control" placeholder="Monthly Deduction:" autocomplete="off">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Month and Date when Loan Starts:</label>
                                    <div class="form-horizontal">
                                        <input required="required" id="datepicker" name="date_start" class="form-control" placeholder="Pick a start date" autocomplete="off">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Month and Date when Loan Ends:</label>
                                    <div class="form-horizontal">
                                        <input required="required" id="datepicker2" name="date_end" class="form-control" placeholder="Pick an end date" autocomplete="off">
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
    </div>
    <!-- jQuery UI 1.11.4 -->

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
        function loader() {
            document.getElementById("loader").classList.remove("hidden");
        }
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
            $("#datepicker2").datepicker();
            $("#end_datepicker").datepicker();
            $("#end_datepicker2").datepicker();
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