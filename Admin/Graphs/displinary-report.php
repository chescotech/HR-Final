<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Disciplinary Report</title>
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
        $DepartmentObject = new Department();
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">

            <section class="content-header">
                <h1>
                    Disciplinary Report
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body">
                                <center><img src="get-employee-disciplinary-reocrds.php" /></center>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <form action="displinary-report" method="post">
                            <table cellpadding="" border="0" class="se">
                                <tr>
                                    <td>
                                        <select name="empno" class="form-control">
                                            <option>-- Select Employee --</option>
                                            <?php
                                            $departmentquery = $DepartmentObject->getAllEmployeesByCompany($companyId);
                                            while ($row = mysql_fetch_array($departmentquery)) {

                                                $fname = $row['fname'];
                                                $lname = $row['lname'];
                                                $position = $row['position'];
                                            ?>
                                                <option value="<?php echo $row['empno']; ?>"> <?php echo $fname . " " . $lname . " - " . $position ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <button type="submit" name="search" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <br>
                    </div>
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body">
                                <div style="background-color: white">
                                    <center>
                                        <h5 style="color: black"><b>Employee Disciplinary Report</b></h5>
                                    </center>
                                </div>
                                <table id="employee_data" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Empno</th>
                                            <th>Names</th>
                                            <th>Date Charged</th>
                                            <th>Offence Commited</th>
                                            <th>Case Status</th>
                                            <th>Punishment Given</th>
                                            <th>Charged By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_POST['search'])) {
                                            $empno = $_POST['empno'];
                                            $query = "SELECT * FROM employee_discplinary_records WHERE empno = '$empno'  ";

                                            $result = mysql_query($query, $link) or die(mysql_error());

                                            $sum = 0;
                                            $closeStatus = "";
                                            while ($row = mysql_fetch_array($result)) {
                                                $id = $row['id'];
                                                $datePrinted = strtoTime($row['date_charged']);
                                                $datePrint = date('F d, Y', $datePrinted);
                                                $caseStatus = $row['case_status'];
                                                if ($caseStatus == "closed") {
                                                    $closeStatus = "";
                                                } else {
                                                    $closeStatus = "Close Case";
                                                }

                                                if ($caseStatus == "closed") {
                                                    $status = '<span class="label label-success arrowed-in arrowed-in-right">' . $caseStatus . '</span>';
                                                } else {
                                                    $status = '<span class="label label-warning">' . $caseStatus . '</span>';
                                                }

                                                echo '  
                                                        <tr>  
                                                            <td>' . $row['empno'] . '</td>  
                                                            <td>' . $DepartmentObject->getEmployeeDetailsById($row['empno']) . '</td>
                                                            <td>' . $datePrint . '</td>                                                              
                                                            <td>' . $row['offence_commited'] . '</td>                                                          
                                                            <td>' . $status . '</td>                                                    
                                                            <td>' . $row['punishment'] . '</td>
                                                            <td>' . $row['charged_by'] . '</td>                                                           
                                                        </tr>  
                                                        ';
                                            }
                                        }
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