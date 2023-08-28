<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Loan</title>
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
</head>

<script>
    $(function() {
        $("#datepicker").datepicker();
        $("#datepicker2").datepicker();
    });
</script>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/Department.php';

        require_once('../../PHPmailer/sendmail.php');
        include_once '../Classes/Loans.php';

        $LoanObject = new Loans();
        $DepartmentObject = new Department();

        include '../navigation_panel/authenticated_user_header.php';

        $compID = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['save'])) {

            $message = "";
            $empno = $_POST['empno'];
            // $loan_type = $_POST['loan_type'];
            $loan_amount = $_POST['loan_amount'];
            $duration = $_POST['months'];
            $monthly_deduction = $_POST['monthly_deduction'];
            $intrest_rate = $_POST['intrest_rate'];
            $companyId = $_SESSION['company_ID'];
            $interest = (($intrest_rate / 100) * $loan_amount);
            $principle = $loan_amount - ($monthly_deduction - $interest);

            $LoanDate = date('Y-m-d', strtotime($_POST['date_start']));
            $months = "+" . $duration . "month";
            $newdate = strtotime($months, strtotime($LoanDate));
            $deadLine = date('Y-m-d', strtotime($_POST['date_end']));
            $status = "Pending";

            $LoanObject->addLoan($empno, $loan_amount, $monthly_deduction, $duration, $companyId, $principle, $intrest_rate, $interest, $LoanDate, $deadLine, $status);

            $message = "Loan Entry sucess!!"
        ?>

        <?php
        }
        ?>

        <div class="content-wrapper">

            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <a href="employees.php" class="btn btn-primary btn-block margin-bottom">Back</a>
                    </div>
                    <div class="col-md-5">
                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <?php
                                    if (isset($_POST['save'])) {
                                        echo ' <center>
                                            <h3 style="color: green" class="box-title"><b>' . $message . '</b></h3>
                                        </center>';
                                    } else {
                                        echo ' <center>
                                            <h3 style="color: black" class="box-title"><b>Add Loan</b></h3>
                                        </center>';
                                    }
                                    ?> </div>
                                <div class="box-body">
                                    <label>Employee Name:</label>

                                    <div class="form-group">

                                        <select name="empno" class="form-control">
                                            <option>-- Select Employee to Add Loan --</option>
                                            <?php
                                            $departmentquery = $DepartmentObject->getAllEmployeesByCompany($compID);
                                            while ($row = mysql_fetch_array($departmentquery)) {

                                                $fname = $row['fname'];
                                                $lname = $row['lname'];
                                                $position = $row['position'];
                                            ?>
                                                <option value="<?php echo $row['empno']; ?>"> <?php echo $row['empno'] . " - " . $fname . " " . $lname . " - " . $position ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>




                                <div class="box-body">
                                    <label>Loan Amount:</label>
                                    <div class="form-group">
                                        <input required="required" name="loan_amount" class="form-control" placeholder="Amount :">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Months:</label>
                                    <div class="form-group">
                                        <input required="required" name="months" class="form-control" placeholder="Repayment Duration in Months:">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Monthly Deduction:</label>
                                    <div class="form-group">
                                        <input required="required" name="monthly_deduction" class="form-control" placeholder="Monthly Deduction:">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Month and Date when Repayment Starts:</label>
                                    <div class="form-horizontal">
                                        <input required="required" id="datepicker" name="date_start" class="form-control" placeholder="Month when Repayment Starts:">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Month and Date when Repayment Ends:</label>
                                    <div class="form-horizontal">
                                        <input required="required" id="datepicker2" name="date_end" class="form-control" placeholder="Month when Repayment Starts:">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Interest Rate:</label>
                                    <div class="form-horizontal">
                                        <input required="required" name="intrest_rate" class="form-control" placeholder="Interest Rate:">
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
        $(function() {

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

</body>

</html>
