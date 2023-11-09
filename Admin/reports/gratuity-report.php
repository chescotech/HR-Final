<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pensions Report</title>
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
        include_once '../Classes/Employee.php';
        include_once '../Classes/Loans.php';
        $EmployeeObject = new Employee();
        $loanObj = new Loans();
        include '../navigation_panel/authenticated_user_header.php';
        $compId = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    echo 'Employee Gratuity Report';
                    ?>
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-4">

                    </div>

                    <br></br>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="employee_data" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Employee ID</th>
                                                    <th>Social Security</th>
                                                    <th>Employee Name</th>
                                                    <th>Duration Worked</th>
                                                    <th>Basic Wage</th>
                                                    <th>Gratuity Rating</th>
                                                    <th>Total Gratuity</th>
                                                </tr>
                                            </thead>

                                            <?php
                                            $query = "  SELECT * FROM emp_info WHERE company_id = '$compId' AND has_gratuity='Yes' ";

                                            $result2 = mysqli_query($link, $query) or die(mysqli_error($link));
                                            $sum = 0;
                                            while ($row = mysqli_fetch_array($result2)) {

                                                $empno = $row['empno'];
                                                $SNo = $loanObj->getSocialSecurityNo($empno);

                                                $pensionAmount = $loanObj->getPensions($compId, $empno);

                                                $result = mysqli_query($link, "SELECT * FROM emp_info WHERE empno='$empno'");
                                                $grossRows = mysqli_fetch_array($result);
                                                $grossPay = $grossRows['basic_pay'];
                                                $dateJoined = $grossRows['date_joined'];

                                                $ts1 = strtotime($dateJoined);
                                                $ts2 = strtotime(date("Y/m/d"));

                                                $year1 = date('Y', $ts1);
                                                $year2 = date('Y', $ts2);

                                                $month1 = date('m', $ts1);
                                                $month2 = date('m', $ts2);
                                                $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
                                                // $gratuity = ($grossPay * $loanObj->getEmployeeGratuity($empno)) * $loanObj->calNoMonthsWorked($empno);
                                                // Get gratuity from fixed figure in db insted of cmultiplying by no. of months worked
                                                // $gratuity = ($grossPay * $loanObj->getEmployeeGratuity($empno)) + $loanObj->getEmployeeCurrentGratuity($empno);
                                                // Now just get the fixed figure from db

                                                $gratuity = $loanObj->getEmployeeCurrentGratuity($empno);

                                                echo '  
                                                        <tr>  
                                                            <td>' . $row['empno'] . '</td>  
                                                            <td>' . $row['social'] . '</td>                                                            
                                                            <td>' . $row['fname'] . " " . $row['lname'] . '</td>
                                                            <td>' . $loanObj->calNoMonthsWorked($empno) . ' Months</td>
                                                            <td>' . $grossPay . '</td> 
                                                            <td>' . $loanObj->getEmployeeGratuity($empno) * 100 . ' % </td>         
                                                            <td>' . number_format($gratuity, 2) . '</td>                                                          
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
            $("#datepicker2").datepicker();
        });
    </script>
</body>

</html>