<?php
error_reporting(0);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>National Health Insurance Report</title>
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
        include_once '../Classes/Payslips.php';
        $PayslipsObject = new Payslips();
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
                    if (isset($_POST['search_date'])) {
                        $date = $_POST['search_date'];
                        $mydate = strtoTime($date);
                        $printdate = date('F d, Y', $mydate);
                        // to date..
                        $toDate = $_POST['to_date'];
                        $mydate2 = strtoTime($toDate);
                        $printdate2 = date('F d, Y', $mydate2);

                        echo 'National Health Insurance Report for period ' . $printdate . ' to ' . $printdate2;
                    } else {
                        echo 'National Health Insurance Report';
                    }
                    ?>
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-4">
                        <form action="nhema-report" method="post">
                            <table cellpadding="" border="0" class="se">
                                <tr>
                                    <td>
                                        <input required="required" id="datepicker" name="search_date" class="form-control" placeholder="From" autocomplete="off">
                                    </td>
                                    <td>
                                        <input required="required" id="datepicker2" name="to_date" class="form-control" placeholder="To" autocomplete="off">
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
                                    <form target="_blank" action="nhema-report" method="post">
                                        <input hidden="hidden" name="search_date" value="<?php
                                                                                            if (isset($_POST['search_date'])) {
                                                                                                echo $_POST['search_date'];
                                                                                            }
                                                                                            ?>">

                                        <input hidden="hidden" name="to_date" value="<?php
                                                                                        if (isset($_POST['to_date'])) {
                                                                                            echo $_POST['to_date'];
                                                                                        }
                                                                                        ?>">

                                        <?php
                                        if (isset($_POST['search_date'])) {
                                            //echo '<button type="submit"  name="save" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-print"></span> Pdf
                                            // </button>';
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
                                    <div class="table-responsive">
                                        <table id="employee_data" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Employee Number</th>
                                                    <th>NHIMA Number</th>
                                                    <th>Basic Pay</th>
                                                    <th>NRC</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Date of Contribution.</th>
                                                    <th>Date of Birth.</th>
                                                    <th>Total Contribution</th>
                                                </tr>
                                            </thead>

                                            <?php
                                            if (isset($_POST['search_date'])) {

                                                $reportDate = $_POST['search_date'];
                                                $arr = explode("/", $reportDate);
                                                list($Getmonth, $Getday, $GetYear) = $arr;

                                                $year = $GetYear;
                                                $month = $Getmonth;
                                                $day = $Getday;

                                                // to date.. 
                                                $toDate = $_POST['to_date'];
                                                $arr2 = explode("/", $toDate);
                                                list($Getmonth2, $Getday2, $GetYear2) = $arr2;
                                                $year2 = $GetYear2;
                                                $month2 = $Getmonth2;
                                                $day2 = $Getday2;

                                                $query = "SELECT emp_info.nhima,employee.empno,emp_info.nrc,emp_info.bdate,health_insurance,emp_info.fname,emp_info.lname,employee.time,emp_info.basic_pay, employee.earnings_id, employee.deductions_id FROM `employee` INNER JOIN emp_info on emp_info.empno=employee.empno
                                                    WHERE employee.time BETWEEN '$year-$month-$day'  AND  '$year2-$month2-$day2' ";

                                                $result2 = mysql_query($query, $link) or die(mysql_error());

                                                $sum = 0;
                                                while ($row = mysql_fetch_array($result2)) {
                                                    $empno = $row['empno'];
                                                    $basic_pay = $PayslipsObject->getEmployeeEarnings($row['earnings_id']);

                                                    //$AnnualTax = $loanObj->getEmployeeAnnualtax($compId, $reportDate, $toDate, $empno,$compId);

                                                    echo '  
                                                        <tr>  
                                                            <td>' . $row['empno'] . '</td>  
                                                                 <td>' . $row['nhima'] . '</td>  
                                                            <td>' . $basic_pay . '</td>       
                                                                 <td>' . $row['nrc'] . '</td>
                                                            <td>' . $row['fname'] . '</td>
                                                            <td>' . $row['lname'] . '</td> 
                                                            <td>' . $row['time'] . '</td> 
                                                                 <td>' . $row['bdate'] . '</td> 
                                                            <td>' . $row['health_insurance'] . '</td>                                                          
                                                        </tr>  
                                                        ';
                                                }
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