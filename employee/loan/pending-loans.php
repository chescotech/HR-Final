<!DOCTYPE html>


<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pending Loans</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Loan.php';
        $leaveObject = new Loan();
        $empno = $_SESSION['employee_id'];
        $companyId = $_SESSION['company_name'];
        $supervisorDepartmentId = $_SESSION['supervisorDepartmentId'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Pending Loan Applications
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">Pending Loans</a></li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">

                        <div class="box">

                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>First name</th>
                                            <th>Last name</th>
                                            <th>Position</th>
                                            <th>Start Date</th>
                                            <th>End Date </th>
                                            <th>Loan Type</th>
                                            <th>Status</th>
                                            <th>Approve</th>
                                            <th>Decline</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                            <?php
                                            if ($empno == "LSO09") {
                                            } else {
                                                //$MyLeave = $leaveObject->getPendingApprovals($supervisorDepartmentId);
                                            }
                                            $MyLeave = mysqli_query($link, "SELECT * FROM `loan_applications`  AS lvapp
                                            INNER JOIN emp_info AS empin on empin.empno=lvapp.empno
                                            where empin.empno IN ( SELECT empno from emp_info where  leaveworkflow_id IN (SELECT work_flow_id FROM `appover_groups` WHERE empno IN ('$empno')) 
                                                      AND  lvapp.level IN ( SELECT level FROM `appover_groups` WHERE empno IN ('$empno') ) )
                                                      AND lvapp.status !='Approved' AND lvapp.status!='Declined'  ");
                                            if (mysqli_num_rows($MyLeave) == 0) {
                                                echo '<tr>
                                                    <td style="vertical-align:middle" align="left">You have no pending loan applications to respond to.</td>
                                                    </tr>';
                                            }
                                            while ($row = mysqli_fetch_array($MyLeave)) {
                                                $id_ = $row['LOAN_NO'];
                                                $employeeEmail = $row['email'];

                                                // = date_diff($date1, $date2);

                                                $date1 = new DateTime();
                                                $date2 = new DateTime();
                                                //= () - ();

                                                $days = round(abs(strtotime($row['date_completion']) - strtotime($row['loan_date'])) / 86400);

                                                //echo 'days' . $days;
                                                $empNO = $row['empno'];
                                                $currentlevel = $row['level'];
                                            ?>
                                        <tr class="del<?php echo $id_ ?>">
                                            <td style="vertical-align:middle" align="left"><?php echo $row['fname']; ?></td>
                                            <td style="vertical-align:middle" align="left"><?php echo $row['lname']; ?></td>
                                            <td style="vertical-align:middle" align="left"><?php echo $row['position']; ?></td>
                                            <td style="vertical-align:middle" align="left"><?php echo $row['loan_date']; ?></td>
                                            <td style="vertical-align:middle" align="left"><?php echo $row['date_completion']; ?></td>
                                            <td style="vertical-align:middle" align="left"><?php echo $row['loan_type']; ?></td>

                                            <?php
                                            ?>
                                            <td style="vertical-align:middle" align="left"><?php
                                                                                            $status = $row['status'];

                                                                                            echo '<span class="label label-warning">Pending Approval</span>';
                                                                                            ?></td>


                                            <td style="vertical-align:middle" align="center" width="100">
                                                <a rel="tooltip" onclick="return confirm('Are you sure you want to appove this loan?')" title="Approve" id="v<?php echo $id_; ?>" <a href="approve-loan.php<?php echo '?id=' . $id_ . "&empEmail=" . $employeeEmail . "&level=" . $currentlevel . " &empno=" . $empNO ?>" class="btn btn-info btn-lg">
                                                    <span class="glyphicon glyphicon-ok-sign"></span>
                                                </a>
                                            </td>
                                            <td style="vertical-align:middle" align="center" width="100">
                                                <a rel="tooltip" onclick="return confirm('Are you sure you want to decline this loan?')" title="Decline" id="v<?php echo $id_; ?>" <a href="decline-loan.php<?php echo '?id=' . $id_ . "&empEmail=" . $employeeEmail . "&empno=" . $empNO ?> " class="btn btn-info btn-lg">
                                                    <span class="glyphicon glyphicon-remove-circle"></span></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        <?php include '../footer/footer.php'; ?>
        <div class="control-sidebar-bg"></div>
    </div>
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- page script -->
    <script>
        $(function() {
            //$("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>
</body>

</html>