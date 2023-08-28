<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Payroll Expense by Department</title>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/Department.php';
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Loans.php';
        $LoanObject = new Loans();

        $companyId = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">

            <section class="content-header">
                <h1>
                    <?php
                    if (isset($_POST['search'])) {
                        $year = $_POST['financial_year'];
                        $CurrentFinanancialyear = $year;
                        echo 'Payroll expense summary for Year ' . $CurrentFinanancialyear;
                    } else {
                        $CurrentFinanancialyear = date("Y");
                        echo 'Payroll expense summary for Year ' . $CurrentFinanancialyear;
                    }
                    ?>
                </h1>
            </section>
            <br>
            <div class="col-md-4">
                <form action="payroll-expense-summary" method="post">
                    <table cellpadding="" border="0" class="se">
                        <tr>
                            <td>
                                <select name="financial_year" class="form-control">
                                    <option>-- Select Year --</option>
                                    <?php
                                    $startDate = 2015;
                                    $endDate = date("Y");
                                    $years = range($startDate, $endDate);
                                    foreach ($years as $year) {
                                        echo '<option value="' . $year . '">' . $year . '</option>';
                                    }
                                    ?>
                                </select>
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
                                <table id="employee_data" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Payroll Expense</th>
                                            <th>NAPSA</th>
                                            <th>PAYE</th>
                                            <th>Total Expense</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_POST['search'])) {
                                            $year = $_POST['financial_year'];
                                            $CurrentFinanancialyear = $year;
                                        } else {
                                            $CurrentFinanancialyear = date("Y");
                                        }
                                        ?>
                                        <tr>
                                            <td>January</td>
                                            <td><?php echo number_format($LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 1, 31)) ?></td>
                                            <td><?php echo number_format($LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 1, 31)) ?></td>
                                            <td><?php echo number_format($LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 1, 31)) ?></td>
                                            <td>
                                                <?php
                                                $totalExpense = $LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 1, 31) + $LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 1, 31) + $LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 1, 31);
                                                echo number_format($totalExpense);
                                                ?></td>
                                        </tr>

                                        <tr>
                                            <td>February</td>
                                            <td><?php echo number_format($LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 2, 28)) ?></td>
                                            <td><?php echo number_format($LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 2, 28)) ?></td>
                                            <td><?php echo number_format($LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 2, 28)) ?></td>
                                            <td>
                                                <?php
                                                $totalExpense2 = $LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 2, 28) + $LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 2, 28) + $LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 2, 28);
                                                echo number_format($totalExpense2);
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>March</td>
                                            <td><?php echo number_format($LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 3, 31)) ?></td>
                                            <td><?php echo number_format($LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 3, 31)) ?></td>
                                            <td><?php echo number_format($LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 3, 31)) ?></td>
                                            <td>
                                                <?php
                                                $totalExpense3 = $LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 3, 31) + $LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 3, 31) + $LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 3, 31);
                                                echo number_format($totalExpense3);
                                                ?></td>
                                        </tr>

                                        <tr>
                                            <td>April</td>
                                            <td><?php echo number_format($LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 4, 31)) ?></td>
                                            <td><?php echo number_format($LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 4, 31)) ?></td>
                                            <td><?php echo number_format($LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 4, 31)) ?></td>
                                            <td>
                                                <?php
                                                $totalExpense4 = $LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 4, 31) + $LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 4, 31) + $LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 4, 31);
                                                echo number_format($totalExpense4);
                                                ?></td>
                                        </tr>

                                        <tr>
                                            <td>May</td>
                                            <td><?php echo number_format($LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 5, 31)) ?></td>
                                            <td><?php echo number_format($LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 5, 31)) ?></td>
                                            <td><?php echo number_format($LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 5, 31)) ?></td>
                                            <td>
                                                <?php
                                                $totalExpense5 = $LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 5, 31) + $LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 5, 31) + $LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 5, 31);
                                                echo number_format($totalExpense5);
                                                ?></td>
                                        </tr>

                                        <tr>
                                            <td>June</td>
                                            <td><?php echo number_format($LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 6, 30)) ?></td>
                                            <td><?php echo number_format($LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 6, 30)) ?></td>
                                            <td><?php echo number_format($LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 6, 30)) ?></td>
                                            <td>
                                                <?php
                                                $totalExpense6 = $LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 6, 30) + $LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 6, 30) + $LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 6, 30);
                                                echo number_format($totalExpense6);
                                                ?></td>
                                        </tr>

                                        <tr>
                                            <td>July</td>
                                            <td><?php echo number_format($LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 7, 31)) ?></td>
                                            <td><?php echo number_format($LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 7, 31)) ?></td>
                                            <td><?php echo number_format($LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 7, 31)) ?></td>
                                            <td>
                                                <?php
                                                $totalExpense7 = $LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 7, 31) + $LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 7, 31) + $LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 7, 31);
                                                echo number_format($totalExpense7);
                                                ?></td>
                                        </tr>

                                        <tr>
                                            <td>August</td>
                                            <td><?php echo number_format($LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 8, 31)) ?> </td>
                                            <td><?php echo number_format($LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 8, 31)) ?></td>
                                            <td><?php echo number_format($LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 8, 31)) ?></td>
                                            <td>
                                                <?php
                                                $totalExpense8 = $LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 8, 31) + $LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 8, 31) + $LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 8, 31);
                                                echo number_format($totalExpense8);
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>September</td>
                                            <td><?php echo number_format($LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 9, 30)) ?></td>
                                            <td><?php echo number_format($LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 9, 30)) ?></td>
                                            <td><?php echo number_format($LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 9, 30)) ?></td>
                                            <td>
                                                <?php
                                                $totalExpense9 = $LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 9, 30) + $LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 9, 30) + $LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 9, 30);
                                                echo number_format($totalExpense9);
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>October</td>
                                            <td><?php echo number_format($LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 10, 31)) ?></td>
                                            <td><?php echo number_format($LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 10, 31)) ?></td>
                                            <td><?php echo number_format($LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 10, 31)) ?></td>
                                            <td>
                                                <?php
                                                $totalExpense10 = $LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 10, 31) + $LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 10, 31) + $LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 10, 31);
                                                echo number_format($totalExpense10);
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>November</td>
                                            <td><?php echo number_format($LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 11, 30)) ?></td>
                                            <td><?php echo number_format($LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 11, 30)) ?></td>
                                            <td><?php echo number_format($LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 11, 30)) ?></td>
                                            <td>
                                                <?php
                                                $totalExpense11 = $LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 11, 30) + $LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 11, 30) + $LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 11, 30);
                                                echo number_format($totalExpense11);
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>December</td>
                                            <td><?php echo number_format($LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 12, 31)) ?></td>
                                            <td><?php echo number_format($LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 12, 31)) ?></td>
                                            <td><?php echo number_format($LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 12, 31)) ?></td>
                                            <td>
                                                <?php
                                                $totalExpense12 = $LoanObject->getTotalPayrollByYear($companyId, $CurrentFinanancialyear, 12, 31) + $LoanObject->getNAPSAExpenseSummary($companyId, $CurrentFinanancialyear, 12, 31) + $LoanObject->getPAYEExpenseSummary($companyId, $CurrentFinanancialyear, 12, 31);
                                                echo number_format($totalExpense12);
                                                ?></td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total expense for Year <?php
                                                                        if (isset($_POST['search'])) {
                                                                            $year = $_POST['financial_year'];
                                                                            $CurrentFinanancialyear = $year;
                                                                        } else {
                                                                            $CurrentFinanancialyear = date("Y");
                                                                        }
                                                                        echo $CurrentFinanancialyear;
                                                                        ?></td>
                                            <td>
                                                <?php
                                                $total = $totalExpense + $totalExpense2 + $totalExpense3 + $totalExpense4 + $totalExpense5 + $totalExpense6 + $totalExpense7 + $totalExpense8 + $totalExpense9 + $totalExpense10 + $totalExpense11 + $totalExpense12;
                                                echo number_format($total);
                                                ?></td>
                                        </tr>
                                </table>
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
</body>

</html>