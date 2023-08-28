<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit Pay Slips</title>
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

        });
    </script>
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/Department.php';
        include_once '../Classes/Payslips.php';
        include_once '../Classes/Loans.php';

        $LoanObject = new Loans();
        $DepartmentObject = new Department();
        $PaySlipsObject = new Payslips();

        include '../navigation_panel/authenticated_user_header.php';

        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['save'])) {
            $id = $_GET['id'];
            $empno = $_POST['empno'];
            $date_period = $_POST['date_period'];
            $insurance = $_POST['insurance'];
            $advances = $_POST['advances'];
            $commision = $_POST['commision'];
            $allowance = $_POST['allowance'];
            $overtime = $_POST['overtime'];
            $overtime_rate_hour = $_POST['overtime_rate_hour'];
            $days_worked = $_POST['days_worked'];

            $Grosspay = $DepartmentObject->getGrossPay($empno);
            $totalpay = ($Grosspay / 26) * $days_worked;
            $pay = $totalpay;

            $date_timestamp = strtotime($date_period);
            $time = date('Y-m-d', $date_timestamp);

            // tax data.. 

            $gross = ($pay) + ($overtime_rate_hour * $overtime) + $allowance + $commision;
            $napsa = $gross * 0.05;
            if ($napsa >= 843)
                $napsa = 843;
            $napsa_calc = "";

            if ($napsa >= 255)
                $napsa_calc = 255;

            $band1_top = 3000;
            $band2_top = 3800;
            $band3_top = 5900;

            $band1_rate = 0;
            $band2_rate = 0.25;
            $band3_rate = 0.30;
            $band4_rate = 0.35;

            $starting_income = $income = $gross - $napsa_calc;
            $band1 = $band2 = $band3 = $band4 = 0;
            if ($income > $band3_top) {
                $band4 = ($income - $band3_top) * $band4_rate;
                $income = $band3_top;
            }
            if ($income > $band2_top) {
                $band3 = ($income - $band2_top) * $band3_rate;
                $income = $band2_top;
            }
            if ($income > $band1_top) {
                $band2 = ($income - $band1_top) * $band2_rate;
                $income = $band1_top;
            }

            $band1 = $income * $band1_rate;
            $taxable = $gross - $income;
            $total_tax_paid = $band1 + $band2 + $band3 + $band4;

            $totdeduct = $total_tax_paid + $advances + $insurance + $napsa;
            $netpay = $gross - $totdeduct;

            $PaySlipsObject->editPayslip($days_worked, $overtime_rate_hour, $overtime, $allowance, $advances, $insurance, $commision, $id, $time);

        ?>

            <script>
                alert('Successully added !!');
            </script>

        <?php
        }
        ?>

        <div class="content-wrapper">

            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <a href="view-payslips.php" class="btn btn-primary btn-block margin-bottom">Back</a>
                    </div>
                    <div class="col-md-5">

                        <?php
                        $id = $_GET['id'];
                        $EditQuery = $PaySlipsObject->getEditInfo($id);
                        while ($rows = mysql_fetch_array($EditQuery)) {
                        ?>

                            <form enctype="multipart/form-data" method="post">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <center>
                                            <h3 style="color: black" class="box-title"><b>Edit Pay Slip for <?php
                                                                                                            $empno = $rows['empno'];
                                                                                                            echo $PaySlipsObject->PayslipEditDetails($empno) ?> </b></h3>
                                        </center>
                                    </div>
                                    <div hidden="hidden" class="box-body">
                                        <label>Days Worked:</label>
                                        <div class="form-group">
                                            <input required="required" name="empno" class="form-control" value="<?php echo $rows['empno']; ?>">
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <label>Days Worked:</label>
                                        <div class="form-group">
                                            <input required="required" name="days_worked" class="form-control" value="<?php echo $rows['dayswork']; ?>">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Overtime Rate/Hour:</label>
                                        <div class="form-group">
                                            <input required="required" name="overtime_rate_hour" value="0" class="form-control" value="<?php echo $rows['otrate']; ?>">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Over Time Hours:</label>
                                        <div class="form-group">
                                            <input required="required" value="0" name="overtime" class="form-control" value="<?php echo $rows['othrs']; ?>">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Allowances:</label>
                                        <div class="form-horizontal">
                                            <input required="required" name="allowance" value="0" class="form-control" value="<?php echo $rows['allow']; ?>">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Commission:</label>
                                        <div class="form-horizontal">
                                            <input required="required" name="commision" value="0" class="form-control" value="<?php echo $rows['commision']; ?>">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Advances:</label>
                                        <div class="form-horizontal">
                                            <input required="required" name="advances" value="0" class="form-control" value="<?php echo $rows['advances']; ?>">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Insurance:</label>
                                        <div class="form-horizontal">
                                            <input required="required" name="insurance" value="0" class="form-control" value="<?php echo $rows['insurance']; ?>">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Date Period:</label>
                                        <div class="form-horizontal">
                                            <input required="required" id="datepicker" name="date_period" class="form-control" value="<?php echo $rows['time']; ?>">
                                        </div>
                                    </div>

                                    <div class="box-footer">
                                        <div class="pull-center">
                                            <button name="save" type="submit" class="btn btn-primary"></i>Update</button>
                                        </div>
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
<?php
                        }
