<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employees Qualifications</title>
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
        include_once '../Classes/Employee.php';
        include_once '../Classes/Qualifications.php';

        $EmployeeObject = new Employee();
        $qualificationsObject = new Qualifications();

        $companyId = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">

                <h1>
                    <?php
                    echo $_SESSION['name'] . ' Employee Qualifications ';
                    ?>
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-17">
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="employee_data" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <td>Emp No</td>
                                                <td>First name</td>
                                                <td>Last name</td>
                                                <td>Status</td>
                                                <td>Approve</td>
                                                <td>Decline</td>
                                                <td>View</td>
                                            </tr>
                                        </thead>
                                        <?php

                                        $query = $qualificationsObject->getEmployeeQualifications($companyId);
                                        while ($row = mysqli_fetch_array($query)) {

                                            $id_ = $row['id'];
                                            $empno = $row["empno"];
                                            $fname = $row["fname"];
                                            $lname = $row['lname'];

                                            if ($qualificationsObject->checkApprovalStatus($empno) != "Pending") {
                                                $status = '<td><h5 style="color:green"><b>' . $qualificationsObject->checkApprovalStatus($empno) . '</b></h5></td> ';
                                            } else {
                                                $status = '<td><h5 style="color:red"><b>' . $qualificationsObject->checkApprovalStatus($empno) . '</b></h5></td> ';
                                            }

                                            if ($qualificationsObject->checkApprovalStatus($empno) == "Approved") {
                                                $approveStatus = "";
                                            } else {
                                                $approveStatus = "Approve";
                                            }

                                            echo '  
                                                <tr>  
                                                <td>' . $empno . '</td>  
                                                <td>' . $lname . '</td> 
                                                <td>' . $lname . '</td>
                                                ' . $status . '                                              
                                                <td><a href=' . "approve-qualifications.php?id=" . $empno . '>' . $approveStatus . '</a></td>
                                                <td><a href=' . "decline-qualifications?id=" . $empno . '>Decline</a></td>
                                                <td><a target="_blank" href=' . "view-qualifications.php?empid=" . $empno . '>View / Download</a></td>
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
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>

    <!-- SlimScroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
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