<!DOCTYPE html>


<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>My Payslips</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">
        <?php
        include '../navigation_panel/authenticated_user_header.php';

        include_once '../Classes/MyPayslips.php';
        include_once '../../Admin/Classes/Tax.php';
        $PayslipObject = new MyPayslips();
        $TaxObject = new Tax();

        $EmployeeId = $_SESSION['employee_id'];
        $companyId = $_SESSION['company_ID'];
        $compId = $companyId;
        ?>
        <?php include '../navigation_panel/side_navigation_bar.php'; ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="row">

                    <div class="col-xs-15">
                        <div class="box-header with-border">
                            <center>
                                <h3 style="color: black" class="box-title"><b>Your Pay slips to date </b></h3>
                            </center>
                        </div>
                        <div class="form-group">
                        </div>
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="employee_data" cellspacing="0" class="table table-bordered table-fixed">
                                        <thead>

                                            <tr>
                                                <th>Date Issued</th>

                                                <th>Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $PaySlips = $PayslipObject->getPaySlipRecord($EmployeeId, $companyId);
                                            while ($row = mysql_fetch_array($PaySlips)) {
                                                $id = $row['id'];
                                                $employeeId = $row['empno'];
                                                $datePeriod = $row['time'];
                                                $basicPay = $row['pay'];
                                                $dateWorked = $row['dayswork'];
                                                $overtimeRateHour = $row['otrate'];
                                                $overTimeHrs = $row['othrs'];
                                                $allowance = $row['allow'];
                                                $commison = $row['comission'];

                                                $gross = ($row['pay']) + ($row['otrate'] * $row['othrs']) + $row['allow'] + $row['comission'];
                                                $napsa = 0;
                                                if ($TaxObject->getEmployeeAge($row['empno']) < 55) {
                                                    $napsa = $gross * 0.05;
                                                    if ($napsa >= $TaxObject->getNapsaCeiling($compId))
                                                        $napsa = $TaxObject->getNapsaCeiling($compId);

                                                    $napsa_calc = "";
                                                    if ($napsa >= 255)
                                                        $napsa_calc = 255;
                                                } else {
                                                    $napsa;
                                                }

                                                //the tops of each tax band
                                                $band1_top = $TaxObject->getTopBand1($companyId);
                                                $band2_top = $TaxObject->getTopBand2($companyId);
                                                $band3_top = $TaxObject->getTopBand3($companyId);

                                                $band1_rate = $TaxObject->getBandRate1($companyId) / 100;
                                                $band2_rate = $TaxObject->getBandRate2($companyId) / 100;
                                                $band3_rate = $TaxObject->getBandRate3($companyId) / 100;
                                                $band4_rate = $TaxObject->getBandRate4($companyId) / 100;

                                                $starting_income = $income = $gross - $napsa;

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

                                                $total_tax_paid = $TaxObject->TaxCal($gross, $compId);

                                                $date_compare = date('Y-m-d', strtotime($row['time']));

                                                if ($PayslipObject->getLoanMonthDedeductAmounts($row["empno"], $date_compare) == "") {
                                                    $loanAmnt = "0.0";
                                                } else {
                                                    $loanAmnt = $PayslipObject->getLoanMonthDedeductAmounts($row["empno"], $date_compare);
                                                }

                                                $totdeduct = $total_tax_paid + $row['advances'] + $row['pension'] + $row['insurance'] + $napsa + $loanAmnt + $row['health_insurance'];
                                                $netpay = $gross - $totdeduct;

                                                echo '  
                                                        <tr>  
                                                            <td>' . $datePeriod . '</td>  
                                                          
                                                            <td><a target="_blank" href=' . "print.php?id=" . $id . "&empno=" . $employeeId . "&date=" . $datePeriod . '>Print</a></td>
                                                        </tr>  

                                                        ';
                                            }
                                            ?>

                                    </table>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <?php include '../footer/footer.php'; ?>

        <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>

    <!-- SlimScroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- page script -->
    <script>
        $(document).ready(function() {
            $('#employee_data').DataTable();
        });
    </script>
</body>

</html>