<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employee Exits</title>
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

    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker();
        });
    </script>

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
                    Employee exits by reason
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body">
                                <center><img src="get-employee-exits-records.php" /></center>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <form action="employee-exitsby-reason" method="post">
                            <table cellpadding="" border="0" class="se">
                                <tr>
                                    <td>
                                        <input required="required" id="datepicker" name="search_month" class="form-control" placeholder="Select Month">
                                    </td>
                                    <td>
                                        <button type="submit" name="search" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <br>
                        <div class="box">
                            <div style="background-color: white">
                                <center>
                                    <h5 style="color: black"><b>Exits By Month</b></h5>
                                </center>
                            </div>
                            <div class="box-body">
                                <table id="employee_data2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Emp No</th>
                                            <th>Names</th>
                                            <th>Department</th>
                                            <th>Reason for Leaving</th>
                                            <th>Date Of Exit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_POST['search'])) {
                                            $searchMonth = $_POST['search_month'];
                                            $query = mysqli_query($link, "SELECT * FROM employee_exits_tb WHERE date_of_exit = '$searchMonth' AND empno IN ( SELECT empno FROM emp_info WHERE company_id = '$companyId' )");
                                            $sum = 0;
                                            while ($row = mysqli_fetch_array($query)) {
                                                $reason_for_exit = $row["reason_for_exit"];
                                                $dateOfExit = $row['date_of_exit'];
                                                $datePrinted = strtoTime($dateOfExit);
                                                $datePrint = date('F d, Y', $datePrinted);

                                                $empNO = $row['empno'];
                                                $employeQuery = $LoanObject->getEmpDetails($empNO);
                                                $rows = mysqli_fetch_array($employeQuery);
                                                $fname = $rows['fname'];
                                                $lname = $rows['lname'];
                                                $department = $rows['dept'];
                                                $departmentName = $LoanObject->getDepartmentById($department);

                                                echo '  
                                                <tr>                                                     
                                                    <td>' . $empNO . '</td>
                                                    <td>' . $fname . " " . $lname . '</td>
                                                    <td>' . $departmentName . '</td>  
                                                    <td>' . $reason_for_exit . '</td>
                                                    <td>' . $datePrint . '</td>      
                                                </tr>  
                                                ';
                                            }
                                        }
                                        ?>

                                </table>

                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12">

                        <div class="box">
                            <div class="box-body">
                                <div style="background-color: white">
                                    <center>
                                        <h5 style="color: black"><b>Total Exits by Reason</b></h5>
                                    </center>
                                </div>
                                <table id="employee_data" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Reason for Exit</th>
                                            <th>Number of Exits</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($link, "SELECT reason_for_exit, COUNT(*) AS 'count' FROM employee_exits_tb WHERE empno IN ( SELECT empno FROM emp_info WHERE company_id = '$companyId' ) GROUP BY reason_for_exit");
                                        $sum = 0;
                                        while ($row = mysqli_fetch_array($query)) {
                                            $reason_for_exit = $row["reason_for_exit"];
                                            $count = $row["count"];
                                            $sum += $count;
                                            echo '  
                                                <tr>                                                     
                                                    <td>' . $reason_for_exit . '</td>
                                                    <td>' . $count . '</td>  
                                                </tr>  
                                                ';
                                        }
                                        ?>
                                        <?php
                                        echo '  
                                                <tr>  
                                                    <td>Total Number of Employees Exited:</td>  
                                                    <td>' . $sum . '</td>                                                          
                                                </tr>  
                                                ';
                                        ?>
                                </table>

                            </div>
                        </div>
                    </div>

                </div><!-- /.row -->
            </section><!-- /.content -->
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
                buttons: [
                    'csv', 'excel', 'pdf', 'print'
                ]
            });
            $('#employee_data2').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

</body>

</html>