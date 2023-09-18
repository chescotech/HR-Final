<!DOCTYPE html>


<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>View Timesheet</title>
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
        include_once '../Classes/Timesheets.php';
        include_once '../Classes/EmployeeHistory.php';
        $EmpHistoryObject = new EmployeeHistory();
        $TimesheetObject = new Timesheets();

        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Timesheet Details
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#"> Timesheet Details</a></li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div style="display: flex; align-items: center; justify-content: space-between;">

                            <div class="" style="margin-bottom: 8px;">
                                <button href="" onclick="window.history.back()" class="btn btn-primary">Back</button>
                            </div>

                        </div>
                        <div class="box">
                            <?php
                            $timesheet_id = $_GET['id'];
                            $timesheet = $TimesheetObject->getTimesheetDetails($timesheet_id);
                            ?>

                            <div class="box-body">
                                <div class="">
                                    <i class="fa fa-calendar" aria-hidden="true" style="font-size: x-large;"></i>
                                    <?php
                                    // get employee details
                                    $details = $EmpHistoryObject->getEmpInfo($_GET['empno']);
                                    ?>
                                    <span class="" style="font-size: large;">Timesheet Submission for <span style="color: #f44;"><?= $details ?></span></span>
                                </div>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sequence Dates</th>
                                            <th>Day</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Hours</th>
                                            <th>
                                                Notes
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <form method="post" id="timesheet-form">
                                            <?php

                                            ?>

                                            <?php
                                            while ($row = mysql_fetch_assoc($timesheet)) {
                                                // var_dump($row);
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?= $row['start_date'] ?> to <?= $row['end_date'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['day_date'] ?>
                                                    </td>
                                                    <td>
                                                        <input type="time" name="start_time1" id="start_time1" class="form-control" readonly="true" value="<?= $row['start_time'] ?>">
                                                    </td>
                                                    <td>
                                                        <input type="time" name="end_time1" id="end_time1" class="form-control" readonly="true" value="<?= $row['end_time'] ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="hours1" id="hours1" class="form-control" readonly="true" value="<?= $row['hours'] ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="note1" id="note1" class="form-control" readonly="true" value="<?= $row['note'] ?>">
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            <tr>
                                                <p class="label label-warning"><?= $row['status'] ?></p>
                                            </tr>

                                            <div class="form-group">
                                                <input type="hidden" class="form-control" name="date" id="date" placeholder="" value="<?= $_GET['current-date'] ?>" readonly="true">
                                            </div>
                                            <tr>
                                                <td class="">
                                                    <div>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#approve<?= $row['id']; ?>">Approve</button>

                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deny<?= $row['id']; ?>">
                                                            Deny
                                                        </button>
                                                    </div>
                                                    <!-- Approve Modal -->
                                                    <div class="modal fade" id="approve<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                                        <form action="" method="post">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Approve Timesheet</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p class="alert alert-success">This timesheet will now be approved.</p>
                                                                        <input type="hidden" name="ts_id" value="<?= $row['id'] ?>">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="approve" class="btn btn-success">Confirm</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!-- Reject Modal -->
                                                    <div class="modal fade" id="deny<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                                        <form action="" method="post">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Reject Timesheet</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p class="alert alert-danger">Are you sure you want to reject this timesheet?</p>
                                                                        <input type="hidden" name="ts_id" value="<?= $row['id'] ?>">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="reject" class="btn btn-danger">Confirm</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </td>
                                            </tr>
                                        </form>
                                    </tbody>
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
    // approve timesheet
    if (isset($_POST['approve'])) {
        $approve = "Approved";
        $timesheet_id = $_GET['id'];

        $updated = $TimesheetObject->updateTimesheetStatus($approve, $timesheet_id);

        if ($updated) {
            echo '<script>window.location.href = "submissions.php";</script>';
            exit();
        }
    }
    // reject timesheet
    if (isset($_POST['reject'])) {
        $reject = "Rejected";
        $timesheet_id = $_GET['id'];

        $updated = $TimesheetObject->updateTimesheetStatus($reject, $timesheet_id);

        if ($updated) {
            echo '<script>window.location.href = "submissions.php";</script>';
            exit();
        }
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

</body>

</html>