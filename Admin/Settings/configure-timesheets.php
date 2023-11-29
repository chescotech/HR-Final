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
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Department.php';
        include_once '../Classes/Timesheet.php';

        $DepartmentObject = new Department();
        $TimesheetObject = new Timesheet();


        $compId = $_SESSION['company_ID'];

        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">

            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <button onclick="window.history.back()" class="btn btn-primary btn-block margin-bottom">Back</button>
                    </div>
                    <div class="col-md-5 box">
                        <div>
                            <h2>
                                Set Employee Timesheets
                            </h2>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <th>Employee No.</th>
                                <th>Timesheets Status</th>
                                <th>Actions</th>
                            </thead>

                            <tbody>
                                <?php
                                $departmentquery = $DepartmentObject->getAllEmployeesByCompany($compId);
                                $counter = 1;
                                while ($row = mysqli_fetch_array($departmentquery)) {

                                    $empno = $row['empno'];
                                    $status = $row['has_timesheets'];

                                    if ($status == "true") {
                                        $Status = '<span class="label label-success">enabled</span>';
                                    } else {
                                        $Status = '<span class="label label-danger">disabled</span>';
                                    }
                                ?>
                                    <tr>
                                        <td><?= $empno ?></td>
                                        <td><?= $Status ?></td>
                                        <td>
                                            <form action="" method="post" id="status-form<?= $counter; ?>">
                                                <select name="status" class="form-control" id="status-select<?= $counter; ?>">
                                                    <option value="">Select an Option</option>
                                                    <option value="true"><button type="submit">Enable</button></option>
                                                    <option value="false"><button type="submit">Disable</button></option>
                                                </select>
                                                <input type="hidden" name="emp_id" value="<?= $empno ?>">
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                                    $counter++;
                                }
                                ?>
                            </tbody>

                        </table>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        <?php include '../footer/footer.php'; ?>
        <div class="control-sidebar-bg"></div>
    </div>
    <?php
    if (isset($_POST['status'])) {
        $new_status = $_POST['status'];
        $emp_id = $_POST['emp_id'];

        $TimesheetObject->setEmployeeTimesheets($emp_id, $new_status);

        echo '<script>window.location.href = "configure-timesheets.php"</script>';
        exit();
    }
    ?>
    <script>
        $(document).ready(function() {
            $('[id^="status-select"]').on('change', function() {
                // Submit the form when an option is selected
                $(this).closest('form').submit();
            });
        })
    </script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>

    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>

    <script src="../plugins/fastclick/fastclick.min.js"></script>

    <script src="../dist/js/app.min.js"></script>

    <script src="../dist/js/demo.js"></script>



</body>

</html>