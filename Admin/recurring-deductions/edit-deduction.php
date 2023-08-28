<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit Recurring Payment</title>
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
        include_once '../Classes/RecurringDeductions.php';
        require_once('../../PHPmailer/sendmail.php');
        include_once '../Classes/Loans.php';

        $LoanObject = new Loans();
        $DepartmentObject = new Department();
        $RecurringDeductionsObject = new RecurringDeductions();

        include '../navigation_panel/authenticated_user_header.php';

        $compID = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['update'])) {

            $message = "";
            $empno = $_POST['empno'];
            $deduction_type = $_POST['deduction_type'];
            $deduction_amount = $_POST['deduction_amount'];
            $duration = $_POST['months'];
            $monthly_deduction = $_POST['monthly_deduction'];
            $companyId = $_SESSION['company_ID'];

            $LoanDate = date('Y-m-d', strtotime($_POST['date_start']));
            $months = "+" . $duration . "month";
            $newdate = strtotime($months, strtotime($LoanDate));
            $deadLine = date('Y-m-d', strtotime($_POST['date_end']));
            $status = "Pending";

            $RecurringDeductionsObject->createRecurringDeduction($empno, $deduction_amount, $monthly_deduction, $duration, $LoanDate, $deadLine, $companyId, $status, $deduction_type);

            $message = "Recurring Deduction Successfully Created!!"
        }
        ?>

        <div class="content-wrapper">

            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <a href="view.php" class="btn btn-primary btn-block margin-bottom">Back</a>
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
                                            <h3 style="color: black" class="box-title"><b>Recurring Payment</b></h3>
                                        </center>';
                                    }
                                    ?> </div>
                                <?php
                                $deduct = mysql_fetch_array($RecurringDeductionsObject->getRecurringDeductionByID($_GET['id']));
                                ?>
                                <div class="box-body">
                                    <label>Deduction Amount:</label>
                                    <div class="form-group">
                                        <input required="required" name="deduction_amount" class="form-control" placeholder="Amount :" value="<?= $deduct['deduction_total'] ?>">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Months:</label>
                                    <div class="form-group">
                                        <input required="required" name="months" class="form-control" placeholder="Repayment Duration in Months:" value="<?= $deduct['duration'] ?>">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Monthly Deduction:</label>
                                    <div class="form-group">
                                        <input required="required" name="monthly_deduction" class="form-control" placeholder="Monthly Deduction:" value="<?= $deduct['monthly_deduct'] ?>">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Month and Date when Repayment Starts:</label>
                                    <div class="form-horizontal">
                                        <input required="required" id="datepicker" name="date_start" class="form-control" placeholder="Month when Repayment Starts:" value="<?= $deduct['deduction_date'] ?>">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Month and Date when Repayment Ends:</label>
                                    <div class="form-horizontal">
                                        <input required="required" id="datepicker2" name="date_end" class="form-control" placeholder="Month when Repayment Ends:" value="<?= $deduct['date_completion'] ?>">
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
</body>

</html>