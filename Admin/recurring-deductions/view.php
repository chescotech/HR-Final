<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Recurring Deductions</title>
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
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Department.php';
        include_once '../Classes/Loans.php';
        include_once '../Classes/RecurringDeductions.php';
        $LoanObject = new Loans();
        $RecurringDeductionsObject = new RecurringDeductions();
        $companyId = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">

            <section class="content-header">
                <h1>
                    Employees with Recurring Payments
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="employee_data" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>First name</th>
                                                <th>Last name</th>
                                                <th>Total Amount</th>
                                                <th>Monthly Deduction</th>
                                                <th>Duration</th>
                                                <th>Start Date</th>
                                                <th>Date Completion</th>
                                                <th>Status</th>
                                            <!-- <th>Edit</th> -->
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $allDeductions = $RecurringDeductionsObject->getRecurringDeductions($companyId);
                                            while ($row = mysqli_fetch_array($allDeductions)) {
                                                $id_ = $row['id'];
                                                $empno = $row['employee_id'];
                                                $employees = $LoanObject->getEmpDetailsByID($empno);
                                                $empRows = mysqli_fetch_assoc($employees);

                                                if ($row['status'] == "Cleared") {
                                                    $status = '<span class="label label-success arrowed-in arrowed-in-right">' . $row['status'] . '</span>';
                                                } else {
                                                    $status = '<span class="label label-warning">' . $row['status'] . '</span>';
                                                }

                                                echo '  
                                                        <tr>  
                                                            <td>' . $empRows['fname'] . '</td>  
                                                            <td>' . $empRows['lname'] . '</td>                                                            
                                                            <td>' . $row['deduction_total'] . '</td>
                                                            <td>' . $row['monthly_deduct'] . '</td> 
                                                            <td>' . $row['duration'] . '</td>                                                                                                         
                                                            <td>' . $row['deduction_date'] . '</td> 
                                                            <td>' . $row['date_completion'] . '</td>  
                                                            <td>' . $status . '</td>
                                                            <td><a href=' . "delete-deduction.php?id=" . $id_ . '>Delete</a></td>
                                                       
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
        });
    </script>

</body>

</html>