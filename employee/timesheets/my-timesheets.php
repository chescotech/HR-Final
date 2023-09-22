<!DOCTYPE html>


<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>My Timesheets</title>
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
        include_once '../Classes/Timesheets.php';

        $Timesheets = new Timesheets();
        $empno = $_SESSION['employee_id'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    My Timesheets
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#"> My Timesheets</a></li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="" style="margin-bottom: 8px;">
                            <a href="select-days" class="btn btn-primary">New Timesheet</a>
                        </div>
                        <div class="box">

                            <div class="box-body">
                                <div class="">
                                    <i class="fa fa-calendar" aria-hidden="true" style="font-size: x-large;"></i>
                                    <span class="" style="font-size: large;">Active Timesheets</span>
                                </div>
                                <table id="employee_data" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sequence Date</th>
                                            <th>Total Hours</th>
                                            <th>Status</th>
                                            <th>Last Updated</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php
                                            $MyTimesheets = $Timesheets->getTimesheets($empno);
                                            if (mysql_num_rows($MyTimesheets) == 0) {
                                                echo '<tr>
                                                    <td style="vertical-align:middle" align="left">No timesheet records found.</td>
                                                    </tr>';
                                            }
                                            while ($row = mysql_fetch_array($MyTimesheets)) {
                                                $id_ = $row['id'];
                                                $Status = $row['status'];
                                                if ($Status == "Approved") {
                                                    $status = '<span class="label label-success arrowed-in arrowed-in-right">' . $Status . '    </span>';
                                                    $disabled = "disabled";
                                                } else if ($Status == "Pending Approval") {
                                                    $status = '<span class="label label-warning">' . $Status . '</span>';
                                                    $disabled = " ";
                                                } else {
                                                    $status = '<h5 class="label label-danger">' . $Status . '<h5>';
                                                    $disabled = " ";
                                                }
                                            ?>
                                        <tr class="del<?php echo $id_ ?>">
                                            <td style="vertical-align:middle" align="left">
                                                <?php
                                                $datePrinted = strtoTime($row['start_date']);
                                                $datePrinted2 = strtoTime($row['end_date']);
                                                $datePrint = date('F d, Y', $datePrinted);
                                                $datePrint2 = date('F d, Y', $datePrinted2);
                                                echo $datePrint . " to " . $datePrint2;
                                                ?>
                                            </td>

                                            <td style="vertical-align:middle" align="left"><?php echo $row['hours'];  ?></td>

                                            <td style="vertical-align:middle" align="left"><?php echo $status ?></td>
                                            <td style="vertical-align:middle" align="left">
                                                <?php
                                                // $dateUpdated = strtoTime($row['updated_at']);
                                                // $upDate = date('F d, Y', $dateUpdated);
                                                echo $row['updated_at'];
                                                ?>
                                            </td>
                                            <td style="vertical-align:middle" align="center" width="100">
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#delete<?= $row['id'] ?>" <?php echo $row['status'] == "Approved" ? "disabled" : "" ?>>
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="delete<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form action="" method="post">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Delete a Timesheet</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="timesheet_id" value="<?= $row['id'] ?>">
                                                                    <div class="container-fluid">
                                                                        <p class="alert alert-danger">Are you sure you want to delete this timesheet?</p>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" name="delete-button" id="delete-button" class="btn btn-danger">Confirm</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>


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
    <?php
    // delete this timesheet
    if (isset($_POST['delete-button'])) {
        $timesheet_id = $_POST['timesheet_id'];

        $deleted = $Timesheets->deleteTimesheet($timesheet_id);

        echo '<script>window.location.href = "my-timesheets"</script>';
        exit();
    }
    ?>

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