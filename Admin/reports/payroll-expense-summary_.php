<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Payroll Expense Summary Report</title>
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
        include_once '../Classes/Department.php';
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Loans.php';
        include_once '../Classes/Tax.php';
        $DepartmentObject = new Department();
        $TaxObject = new Tax();
        $LoanObject = new Loans();
        $compId = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">

            <section class="content-header">
                <h1>
                    <?php
                    if (isset($_POST['search'])) {
                        $date = $_POST['search_date'];
                        $mydate = strtoTime($date);
                        $printdate = date('F d, Y', $mydate);
                        echo 'Payroll expense summary for ' . $printdate;
                    } else {
                        $CurrentFinanancialyear = date("Y");
                        echo 'Payroll expense summary ' . $CurrentFinanancialyear;
                    }
                    ?>
                </h1>
            </section>
            <br>
            <div class="col-md-4">
                <form action="payroll-expense-summary_" method="post">
                    <table cellpadding="" border="0" class="se">
                        <tr>
                            <td>
                            <td>
                                <input required="required" id="datepicker" name="search_date" class="form-control" placeholder="Select Date">
                            </td>
                            </td>
                            <td>
                                <button type="submit" name="search" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span>Generate
                                </button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div><br></br>
            <section class="content">
                <div class="row">

                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="employee_data" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Expense Description</th>
                                                <th>Debit</th>
                                                <th>Credit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($_POST['search'])) {
                                                $ssNo = "";
                                                $reportDate = $_POST['search_date'];
                                                $arr = explode("/", $reportDate);
                                                list($Getmonth, $Getday, $GetYear) = $arr;

                                                $year = $GetYear;
                                                $month = $Getmonth;
                                                $day = $Getday;
                                                $BTotal = 0;
                                                $overtimeTotal = 0;
                                                $napsaTotal = 0;
                                                $payeTotal = 0;
                                                $salaryAdvanceTotal = 0;
                                                $loanTotal = 0;
                                                $total = 0;
                                                $creditTotal = 0;
                                                $netPayTotal = 0;
                                                $monthName = date('F', mktime(0, 0, 0, $month, 10));

                                                $_SESSION['report-date'] = $date;

                                                $query = "SELECT *
                                                        FROM employee em
                                                        INNER JOIN emp_info n ON em.empno = n.empno                                                     
                                                        WHERE em.company_id =  '$compId' and em.time = '$year-$month-$day'";

                                                $result = mysql_query($query, $link) or die(mysql_error());

                                                $sum = 0;
                                                while ($row = mysql_fetch_array($result)) {

                                                    $gross = ($row['pay']) + ($row['otrate'] * $row['othrs']) + $row['allow'];

                                                    $napsa = $gross * 0.05;

                                                    if ($napsa >= $TaxObject->getNapsaCeiling($compId))
                                                        $napsa = $TaxObject->getNapsaCeiling($compId);

                                                    $napsa_calc = "";
                                                    if ($napsa >= 255)
                                                        $napsa_calc = 255;

                                                    $band1_top = $TaxObject->getTopBand1($compId);
                                                    $band2_top = $TaxObject->getTopBand2($compId);
                                                    $band3_top = $TaxObject->getTopBand3($compId);

                                                    $band1_rate = $TaxObject->getBandRate1($compId) / 100;
                                                    $band2_rate = $TaxObject->getBandRate2($compId) / 100;
                                                    $band3_rate = $TaxObject->getBandRate3($compId) / 100;
                                                    $band4_rate = $TaxObject->getBandRate4($compId) / 100;

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

                                                    $total_tax_paid = $band1 + $band2 + $band3 + $band4;

                                                    $total = $napsa + $napsa;

                                                    $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa;
                                                    $netpay = $gross - $totdeduct;

                                                    if ($LoanObject->getLoanMonthDedeductAmount($row['empno']) == "") {
                                                        $lAmount = 0;
                                                    } else {
                                                        $lAmount = $LoanObject->getLoanMonthDedeductAmount($row['empno']);
                                                    }
                                                    $netPayTotal += $netpay;
                                                    $BasicPayTotal = $DepartmentObject->getGrossPay($row['empno']);
                                                    $BTotal += $BasicPayTotal;
                                                    $overtimeTotal += $row['otrate'];
                                                    $napsaTotal += $napsa;
                                                    $payeTotal = $LoanObject->getPAYEExpenseSummary($compId, $year, $month, $day);
                                                    $salaryAdvanceTotal += $row['advances'];
                                                    $loanTotal +=  $lAmount;
                                                    $total = $BTotal + $overtimeTotal + $napsaTotal + $payeTotal + $salaryAdvanceTotal + $loanTotal + $napsaTotal;
                                                }

                                                echo '  
                                                        <tr>  
                                                            <td>Basic Pay</td>  
                                                            <td>' . number_format($BTotal, 2) . '</td>
                                                            <td></td>                                                    
                                                        </tr> 
                                                        ';
                                                echo '  
                                                        <tr>  
                                                            <td>Transport Allowance</td>  
                                                            <td>0.00</td>
                                                            <td></td>                                                    
                                                        </tr> 
                                                        ';
                                                echo '  
                                                        <tr>  
                                                            <td>House Allowance</td>  
                                                            <td>0.00</td>
                                                            <td></td>                                                    
                                                        </tr> 
                                                        ';
                                                echo '  
                                                        <tr>  
                                                            <td>Lunch Allowance</td>  
                                                            <td>0.00</td>
                                                            <td></td>                                                    
                                                        </tr> 
                                                        ';
                                                echo '  
                                                        <tr>  
                                                            <td>Overtime</td>  
                                                            <td>' . number_format($overtimeTotal) . '</td>
                                                            <td></td>                                                    
                                                        </tr> 
                                                        ';
                                                echo '  
                                                        <tr>  
                                                            <td>Gratuity</td>  
                                                            <td>0.00</td>
                                                            <td></td>                                                    
                                                        </tr> 
                                                        ';
                                                echo '  
                                                        <tr>  
                                                            <td>Leave Pay</td>  
                                                            <td>0.00</td>
                                                            <td></td>                                                    
                                                        </tr> 
                                                        ';
                                                echo '  
                                                        <tr>  
                                                            <td>Employee  NAPSA</td>  
                                                            <td>' . number_format($napsaTotal, 2) . '</td>
                                                            <td></td>                                                    
                                                        </tr> 
                                                        ';
                                                echo '  
                                                        <tr>  
                                                            <td>PAYE</td>  
                                                            <td></td>
                                                            <td>' . number_format($payeTotal) . '</td>                                                    
                                                        </tr> 
                                                        ';
                                                echo '  
                                                        <tr>  
                                                            <td>Life Assurance</td>  
                                                            <td></td>
                                                            <td>0.00</td>                                                    
                                                        </tr> 
                                                        ';
                                                echo '  
                                                        <tr>  
                                                            <td>Salary Advance</td>  
                                                            <td></td>
                                                            <td>' .  number_format($salaryAdvanceTotal) . '</td>                                                    
                                                        </tr> 
                                                        ';
                                                echo '  
                                                        <tr>  
                                                            <td>Net Pay</td>  
                                                            <td></td>
                                                            <td>' .  number_format($netPayTotal) . '</td>                                                    
                                                        </tr> 
                                                        ';
                                                echo '  
                                                        <tr>  
                                                            <td>Loans</td>  
                                                            <td></td>
                                                            <td>' .  number_format($loanTotal, 2) . '</td>                                                    
                                                        </tr> 
                                                        ';
                                                echo '  
                                                        <tr>  
                                                            <td>Employer NAPSA</td>  
                                                            <td></td>
                                                            <td>' .  number_format($napsaTotal) . '</td>                                                    
                                                        </tr> 
                                                        ';
                                                $creditTotal = $payeTotal +  $salaryAdvanceTotal + $loanTotal + $napsaTotal + $netPayTotal;
                                                echo '  
                                                        <tr>  
                                                            <td>Totals</td>  
                                                            <td>' . number_format($total) . '</td>
                                                            <td>' .  number_format($creditTotal) . '</td>                                                    
                                                        </tr> 
                                                        ';
                                            }
                                            ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
                "paging": false,
                "bSort": false,
                buttons: [
                    'csv', 'excel', 'print'
                ]
            });

            $("#datepicker").datepicker();
        });
    </script>
</body>

</html>