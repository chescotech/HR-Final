<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Loans</title>
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
        include_once '../Classes/Leave.php';
        include_once '../Classes/Loans.php';

        $LoanObject = new Loans();
        $LeaveObject = new Leave();
        $companyId = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">

            <section class="content-header">
                <h1>
                    Leave Approver
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
                                                <th>Leave Type</th>
                                                <th>Leave Start Date</th>
                                                <th>Date Completion</th>
                                                <th>Status</th>
                                                <th>Level</th>
                                                <th>Reassign Leave</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $Leave = $LeaveObject->veiwPendingLeave();
                                            while ($row = mysql_fetch_array($Leave)) {
                                                $id_ = $row['application_id'];
                                                $empno = $row['empno'];
                                                $employees = $LoanObject->getEmpDetails($empno);
                                                $empRows = mysql_fetch_array($employees);

                                                if ($row['status'] == "Cleared") {
                                                    $status = '<span class="label label-success arrowed-in arrowed-in-right">' . $row['status'] . '</span>';
                                                } else {
                                                    $status = '<span class="label label-warning">' . $row['status'] . '</span>';
                                                }

                                                echo '  
                                                        <tr>  
                                                            <td>' . $empRows['fname'] . '</td>  
                                                            <td>' . $empRows['lname'] . '</td>                                                            
                                                            <td>' . $row['leave_type'] . '</td>
                                                            <td>' . $row['leave_start_date'] . '</td> 
                                                            <td>' . $row['leave_end_date'] . '</td>  
                                                            <td>' . $status . '</td>
                                                            <td>' . $row['level'] . '</td>
                                                            <td><a href="reassign?id=' . $row['application_id']  . '">Reassign</a></td>
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