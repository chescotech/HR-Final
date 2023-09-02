<?php
error_reporting(0);
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit Loan</title>
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

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/Department.php';

        require_once('../../PHPmailer/sendmail.php');
        include_once '../Classes/Loans.php';

        $LoanObject = new Loans();
        $DepartmentObject = new Department();

        include '../navigation_panel/authenticated_user_header.php';
        $companyId = $_SESSION['username'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['save'])) {
            $message = "";
            $id = $_GET['id'];
            $loan_amount = $_POST['loan_amount'];
            $duration = $_POST['months'];
            $monthly_deduction = $_POST['monthly_deduction'];
            $intrest_rate = $_POST['intrest_rate'];

            $interest = $intrest_rate * $loan_amount;
            $principle = $loan_amount - ($monthly_deduction - $interest);

            $LoanObject->editLoan($id, $loan_amount, $monthly_deduction, $duration, $principle, $intrest_rate, $interest);
            $message = "Loan sucessfully updated!!"

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

                        <?php
                        $id = $_GET['id'];
                        $EditQuery = $LoanObject->getEmployeeToEdit($id);
                        $rows = mysql_fetch_array($EditQuery);
                        ?>

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
                                            <h3 style="color: black" class="box-title"><b>Edit Loan for ' . $LoanObject->getEmployeeDet($id) . '</b></h3>
                                        </center>';
                                    }
                                    ?>

                                </div>

                                <div class="box-body">
                                    <label>Loan Amount:</label>
                                    <div class="form-group">
                                        <input required="required" value="<?php echo $rows['loan_amt']; ?>" name="loan_amount" class="form-control" placeholder="Loan Amount :">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Months Of Payment:</label>
                                    <div class="form-group">
                                        <input required="required" value="<?php echo $rows['duration']; ?>" name="months" class="form-control" placeholder="Loan Duration in Months:">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Monthly Deduction:</label>
                                    <div class="form-group">
                                        <input required="required" value="<?php echo $rows['monthly_deduct']; ?>" name="monthly_deduction" class="form-control" placeholder="Monthly Deduction:">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Interest Rate:</label>
                                    <div class="form-horizontal">
                                        <input required="required" value="<?php echo $rows['interest_rate']; ?>" name="intrest_rate" class="form-control" placeholder="Interest Rate:">
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button name="save" type="submit" class="btn btn-primary"></i>UPDATE</button>
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
</body>

</html>