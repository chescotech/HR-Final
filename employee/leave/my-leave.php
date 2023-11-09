<!DOCTYPE html>


<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>My Leaves</title>
    <!-- Tell the browser to be responsive to screen width -->
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

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Leave.php';
        $leaveObject = new Leave();

        $empno = $_SESSION['employee_id'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Your Leave Applications
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#"> My Leaves</a></li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">

                        <div class="box">

                            <div class="box-body">
                                <table id="employee_data" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Leave Start Date</th>
                                            <th>Leave End Date </th>
                                            <th>Leave Type</th>
                                            <th>Reason for Leave</th>
                                            <th>Number of leave days applied for.</th>
                                            <th>Status</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php
                                            $MyLeave = $leaveObject->veiwLeave($empno);
                                            if (mysqli_num_rows($MyLeave) == 0) {
                                                echo '<tr>
                                                    <td style="vertical-align:middle" align="left">No records have been found for your leave</td>
                                                    </tr>';
                                            }
                                            while ($row = mysqli_fetch_array($MyLeave)) {
                                                $id_ = $row['application_id'];
                                                $Status = $row['status'];
                                                if ($Status == "Approved") {
                                                    $status = '<span class="label label-success arrowed-in arrowed-in-right">' . $Status . '    </span>';
                                                    $disabled = "disabled";
                                                } else if ($Status == "Pending Approval") {
                                                    $status = '<span class="label label-warning">' . $Status . '</span>';
                                                    $disabled = " ";
                                                } else {
                                                    $status = '<h5 style="color:red">' . $Status . '<h5>';
                                                    $disabled = " ";
                                                }
                                            ?>
                                        <tr class="del<?php echo $id_ ?>">
                                            <td style="vertical-align:middle" align="left">
                                                <?php
                                                $datePrinted = strtoTime($row['leave_start_date']);
                                                $datePrint = date('F d, Y', $datePrinted);
                                                echo $datePrint;
                                                ?>
                                            </td>
                                            <td style="vertical-align:middle" align="left">
                                                <?php
                                                $datePrinted2 = strtoTime($row['leave_end_date']);
                                                $datePrint2 = date('F d, Y', $datePrinted2);
                                                echo $datePrint2;
                                                ?>
                                            </td>
                                            <td style="vertical-align:middle" align="left"><?php echo $row['leave_type']; ?></td>
                                            <td style="vertical-align:middle" align="left"><?php echo $row['reason_leave']; ?></td>
                                            <td style="vertical-align:middle" align="left"><?php echo $row['days'] . ' Days Excluding weekends and Holidays'; ?></td>

                                            <td style="vertical-align:middle" align="left"><?php echo $status ?></td>
                                            <td style="vertical-align:middle" align="center" width="100">
                                                <a rel="tooltip" onclick="return confirm('Are you sure you want to delete this?')" title="delete post" id="v<?php echo $id_; ?>" <a href="delete_leave.php<?php echo '?id=' . $id_ ?> " class="btn btn-info btn-lg <?php echo $disabled ?>">
                                                    <span class="glyphicon glyphicon-trash"></span></a>
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
    <!-- page script -->
    <script>
        $(document).ready(function() {
            $('#employee_data').DataTable();
        });
    </script>
</body>

</html>