<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Payee Report</title>
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
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">
        <?php
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Employee.php';
        include_once '../Classes/Tax.php';
        include_once '../Classes/Payslips.php';
        $PayslipsObject = new Payslips();
        $EmployeeObject = new Employee();
        $TaxObject = new Tax();


        $compId = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    if (isset($_POST['search_date'])) {
                        $date = $_POST['search_date'];
                        $mydate = strtoTime($date);
                        $printdate = date('F d, Y', $mydate);
                        echo 'PAYE Report for ' . $printdate;
                    } else {
                        echo 'PAYE Monthly Report';
                    }
                    ?>
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-4">
                        <form action="payee-report" method="post">

                            <table cellpadding="" border="0" class="se">
                                <tr>
                                    <td>
                                        <input required="required" id="datepicker" name="search_date" class="form-control" placeholder="Select Date" autocomplete="off">
                                    </td>
                                    <td>
                                        <button type="submit" name="save" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span>Generate
                                        </button>
                                    </td>
                                </tr>
                            </table>

                        </form>
                    </div>

                    <div class="col-md-4">

                        <table cellpadding="" border="0" class="se">
                            <tr>
                                <td>
                                    <form target="_blank" action="payee-pdf-report" method="post">
                                        <input hidden="hidden" name="search_date" value="<?php
                                                                                            if (isset($_POST['search_date'])) {
                                                                                                echo $_POST['search_date'];
                                                                                            }
                                                                                            ?>">

                                        <?php
                                        if (isset($_POST['search_date'])) {
                                            echo ' <button type="submit"  name="save" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-print"></span> Pdf
                                            </button>';
                                        }
                                        ?>

                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <br></br>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body">
                                    <table id="employee_data" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Identity Type</th>
                                                <th>TPIN</th>
                                                <th>Identity Number</th>
                                                <th>Name Of Employee</th>
                                                <th>Nature Of Employment</th>
                                                <th>Gross emoluments for tax period</th>
                                                <th>Chargeable emoluments for tax period</th>
                                                <th>Total tax for year or period</th>
                                                <th>Tax Deducted as shown on the TRD</th>
                                                <th>Tax Adjusted in the tax period</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            if (isset($_POST['search_date'])) {

                                                $reportDate = $_POST['search_date'];
                                                $arr = explode("/", $reportDate);
                                                list($Getmonth, $Getday, $GetYear) = $arr;

                                                $year = $GetYear;
                                                $month = $Getmonth;
                                                $day = $Getday;
                                                $ssNo = "";
                                                $query = "SELECT *
                                                        FROM employee em
                                                        INNER JOIN emp_info n ON em.empno = n.empno                                                     
                                                        WHERE em.company_id =  '$compId' and em.time = '$year-$month-$day'";

                                                $result = mysqli_query($link, $query) or die(mysqli_error($link));

                                                $sum = 0;
                                                while ($row = mysqli_fetch_array($result)) {
                                                    $earnings = $PayslipsObject->getEmployeeEarnings($row['earnings_id']);
                                                    $formatDate = $year . '-' . $month . '-' . $day;
                                                    $gross = $PayslipsObject->getEmployeeGrossPay($row['empno'], $formatDate);

                                                    $empoyeeNo = $row['empno'];
                                                    $natureEmployement = $row['employment_type'];

                                                    if ($TaxObject->getEmployeeAge($row['empno']) < 55) {
                                                        $napsa = $gross * 0.05;
                                                        if ($napsa >= $TaxObject->getNapsaCeiling($compId))
                                                            $napsa = $TaxObject->getNapsaCeiling($compId);

                                                        $napsa_calc = "";
                                                        if ($napsa >= 255)
                                                            $napsa_calc = 255;
                                                    } else {
                                                        $napsa = 0;
                                                    }

                                                    $band1_top = $TaxObject->getTopBand1($compId);
                                                    $band2_top = $TaxObject->getTopBand2($compId);
                                                    $band3_top = $TaxObject->getTopBand3($compId);

                                                    $band1_rate = $TaxObject->getBandRate1($compId) / 100;
                                                    $band2_rate = $TaxObject->getBandRate2($compId) / 100;
                                                    $band3_rate = $TaxObject->getBandRate3($compId) / 100;
                                                    $band4_rate = $TaxObject->getBandRate4($compId) / 100;

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
                                                    $total_tax_paid = $TaxObject->TaxCal($starting_income, $compId); //$band1 + $band2 + $band3 + $band4;


                                                    $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa;

                                                    if ($EmployeeObject->getSocialSSNO($row['empno']) == "") {
                                                        $ssNo = "0";
                                                    } else {
                                                        $ssNo = $EmployeeObject->getSocialSSNO($row['empno']);
                                                    }
                                                    if ($EmployeeObject->getEmployeeNrc($row['empno']) == "") {
                                                        $NRC = "0";
                                                    } else {
                                                        $NRC = $EmployeeObject->getEmployeeNrc($row['empno']);
                                                    }

                                                    $chargbleEmTaxPeriod = $gross - $napsa;

                                                    echo '  
                                                    <tr>  
                                                            <td>NRC</td> 
                                                            <td>' . $row['tpin'] . '</td>
                                                            <td>' . $NRC . '</td>                                                            
                                                            <td>' . $row['fname'] . " " . $row['lname'] . '</td>
                                                            <td>' . $natureEmployement . '</td>
                                                            <td>' . number_format($gross, 2) . '</td>
                                                            <td>' . number_format($chargbleEmTaxPeriod, 2) . '</td>
                                                            <td>0.00</td>
                                                            <td>' . number_format($total_tax_paid, 2) . '</td>
                                                            <td>0.00</td>
                                                        </tr>  
                                                        ';
                                                }
                                            }
                                            ?>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                    </div><!-- /.row -->
            </section><!-- /.content -->
        </div>
        <?php include '../footer/footer.php'; ?>
        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

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
        });
    </script>
</body>

</html>