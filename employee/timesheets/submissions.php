<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Timesheets</title>
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
        include_once '../../Admin/Classes/Department.php';
        include_once '../Classes/Timesheets.php';


        include '../navigation_panel/authenticated_user_header.php';
        $DepartmentObject = new Department();
        $TimesheetObject = new Timesheets($link);

        $compId = $_SESSION['company_ID'];
        $dept_id = $_SESSION['dept'];

        include '../navigation_panel/side_navigation_bar.php';
        ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    if (isset($_POST['empno'])) {
                        $empno = $_POST['empno'];
                        // $empDetails = $PaySlipsObject->PayslipEditDetails($empno);
                        echo 'Timesheet results for ' . $empno;
                    } else {
                        echo ' Search for a Timesheet';
                    }
                    ?>
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-4">
                        <form action="submissions.php" method="post">
                            <table cellpadding="" border="0" class="se">
                                <tr>
                                    <td>
                                        <select name="empno" class="form-control">
                                            <option value="all"> All Employees </option>
                                            <?php
                                            $departmentquery = $DepartmentObject->getEmployeeByDepartment($dept_id);
                                            while ($row = mysqli_fetch_array($departmentquery)) {

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
                                        <table id="employee_data" class="table table-bordered table-fixed">
                                            <thead>

                                                <tr>
                                                    <th>Employee ID</th>
                                                    <th>Period</th>
                                                    <th>Status</th>
                                                    <th>Detailed View</th>
                                                    <th>Decision</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $timesheets_results;
                                                if (isset($_POST['empno'])) {
                                                    $empnum = $_POST['empno'];
                                                    if ($empnum == 'all') {
                                                        $timesheets_results = $TimesheetObject->getTimeSheetsByDepartment($dept_id);
                                                    } else {
                                                        $timesheets_results = $TimesheetObject->getTimesheets($empnum);
                                                    }
                                                }

                                                while ($row = mysqli_fetch_assoc($timesheets_results)) {
                                                    $id_ = $row['id'];
                                                    $employee_no = $row['employee_no'];

                                                    $Status = $row['status'];
                                                    if ($Status == "Approved") {
                                                        $status = '<span class="label label-success arrowed-in arrowed-in-right">' . $Status . '    </span>';
                                                        $disabled = "disabled";
                                                    } else if ($Status == "Pending Approval") {
                                                        $status = '<span class="label label-warning">' . $Status . '</span>';
                                                        $disabled = " ";
                                                    } else {
                                                        $status = '<h5 class="label label-danger" style="color:red">' . $Status . '<h5>';
                                                        $disabled = " ";
                                                    }

                                                ?>

                                                    <tr>
                                                        <td><?= $employee_no ?></td>
                                                        <td><?= $status ?></td>
                                                        <td><?= $row['start_date'] ?> to <?= $row['end_date'] ?></td>

                                                        <td><a target="_blank" href="view-timesheet.php?id=<?= $id_ ?>&empno=<?= $employee_no ?>">View</a></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#approve<?= $row['id']; ?>">Approve</button>

                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deny<?= $row['id']; ?>">
                                                                Deny
                                                            </button>
                                                        </td>
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
                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                            </tbody>

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
    <?php
    $updated = "true";
    // approve timesheet
    if (isset($_POST['approve'])) {
        $approve = "Approved";
        $timesheet_id = $_POST['ts_id'];

        $updated = $TimesheetObject->updateTimesheetStatus($approve, $timesheet_id);

        if ($updated) {
            '<script>window.location("submissions.php")</script>';
        }
    }
    // reject timesheet
    if (isset($_POST['reject'])) {
        $reject = "Rejected";
        $timesheet_id = $_POST['ts_id'];

        $updated = $TimesheetObject->updateTimesheetStatus($reject, $timesheet_id);

        if ($updated) {
            '<script>window.location("submissions.php")</script>';
        }
    }
    ?>
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