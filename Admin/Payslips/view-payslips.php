<?php
error_reporting(0);
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pay Slips</title>
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
        include_once '../Classes/Payslips.php';
        include_once '../Classes/Loans.php';
        include_once '../Classes/Tax.php';

        $LoanObject = new Loans();
        $DepartmentObject = new Department();
        $PaySlipsObject = new Payslips();
        $TaxObject = new Tax();

        include '../navigation_panel/authenticated_user_header.php';

        $compId = $_SESSION['company_ID'];

        if (isset($_POST['save'])) {
            $date_period = $_POST['date_period'];

            $date_timestamp = strtotime($date_period);
            $time = date('Y-m-d', $date_timestamp);

            echo "<script> window.location='delete_payslip.php?time=$time' </script>";
        }
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    if (isset($_POST['empno'])) {
                        $empno = $_POST['empno'];
                        $empDetails = $PaySlipsObject->PayslipEditDetails($empno);
                        echo 'Pay slip results for ' . $empDetails;
                    } else {
                        echo ' Search for a Pay slip';
                    }
                    ?>
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-4">
                        <form action="view-payslips.php" method="post">
                            <table cellpadding="" border="0" class="se">
                                <tr>
                                    <td>
                                        <select name="empno" class="form-control">
                                            <option value="all"> All Employees </option>
                                            <?php
                                            $departmentquery = $DepartmentObject->getAllEmployeesByCompany($compId);
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
                                        <button type="submit" name="" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span> Bulk Delete
                                        </button>
                                    </td>
                                </tr>
                            </table>

                        </form>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Delete In Bulk</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form enctype="multipart/form-data" method="post">
                                            <div class="box box-primary">
                                                <div class="box-body">
                                                    <label>Select Date Period:</label>
                                                    <div class="form-horizontal">
                                                        <input required="required" type="date" name="date_period" class="form-control" placeholder="Date Period:" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="box-footer">
                                                    <div class="pull-right">
                                                        <button name="save" type="submit" class="btn btn-primary"></i>Next</button>
                                                    </div>
                                                </div>

                                            </div>

                                        </form>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <br></br>

                    <div class="row">
                        <div class="col-xs-15">
                            <div class="box">
                                <div class="box-body">
                                    <div class="table-responsive">

                                        <?php
                                        // Function to clean column names
                                        function cleanColumnName($columnName)
                                        {
                                            // Replace underscores with spaces, then remove other special characters
                                            $cleanedName = preg_replace('/_/', ' ', $columnName);
                                            $cleanedName = preg_replace('/[^A-Za-z0-9\s]/', '', $cleanedName);
                                            return $cleanedName;
                                        }

                                        $query = "DESCRIBE employee_earnings";
                                        $result = mysql_query($query);
                                        $columns = array();

                                        if (mysql_num_rows($result) > 0) {
                                            while ($row = mysql_fetch_assoc($result)) {
                                                $columns[] = cleanColumnName($row['Field']); // Clean and add to the array
                                            }
                                        } else {
                                            echo "No columns found in the table.";
                                        }
                                        ?>



                                        <table id="employee_data" class="table table-bordered table-fixed">
                                            <thead>

                                                <tr>
                                                    <th>ID</th>
                                                    <th>Date</th>
                                                    <!-- <th>Days</th> -->
                                                    <!-- <?php //for ($i = 3; $i < count($columns); $i++) {
                                                            //$column = $columns[$i];
                                                            //echo "<th>" . $column . "</th>";
                                                            //} 
                                                            ?>

                                                    <script>
                                                        const col = <?php echo json_encode($columns); ?>;
                                                        console.log(col);
                                                    </script> -->
                                                    <!-- <th>Overtime</th>
                                                    <th>Napsa</th>
                                                    <th>Advances</th>
                                                    <th>Insurance</th>
                                                    <th>NHIMA</th>
                                                    <th>PAYE</th>
                                                    <th>Loan</th>
                                                    <th>Total Deduction</th>
                                                    <th>Net Pay</th> -->
                                                    <th>Print</th>
                                                    <!-- <th>Edit</th> -->
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                if (isset($_POST['empno'])) {

                                                    $empno = $_POST['empno'];
                                                    if ($empno == "all") {
                                                        $query3 = "SELECT * FROM employee WHERE company_id='$compId'";
                                                    } else {
                                                        $query3 = "SELECT * FROM employee WHERE company_id='$compId' AND empno='$empno'";
                                                    }

                                                    // $result = mysql_query($query, $link) or die(mysql_error());
                                                    // $result2 = mysql_query($query2, $link) or die(mysql_error());
                                                    $result3 = mysql_query($query3, $link) or die(mysql_error());

                                                    $sum = 0;
                                                    $row2 = '';

                                                    while ($row = mysql_fetch_array($result3)) {

                                                        $id_ = $row['id'];
                                                        $employeeId = $row['empno'];

                                                ?>

                                                    <?php
                                                        $emp_nom = $row['empno'];

                                                        $nPay = number_format("$netpay", 2);


                                                        echo '<tr>';
                                                        echo '  <td>' . $row["empno"] . '</td>';
                                                        echo '  <td>' . $row['time'] . '</td>';
                                                        // echo '  <td></td>';

                                                        echo '  <td><a target="_blank" href=' . "print-payslip.php?id=" . $id_ . '&empno=' . $row["empno"] . '>Print</a></td>';
                                                        // echo '  <td><a href=' . "edit-payslip.php?id=" . $id_ . '>Edit</a></td>';
                                                        echo '  <td><a href=' . "delete-payslip.php?id=" . $id_ . '&date=' . $time . '&empno=' . $row["empno"] . '>Delete</a></td>';

                                                        echo '</tr>';
                                                        // }
                                                    }
                                                    ?>
                                                <?php
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
    </div>
    <script>
        function toggle(source) {
            checkboxes = document.getElementsByName('staffer[]');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
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
        });
    </script>

</body>

</html>