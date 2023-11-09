<!DOCTYPE html>


<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Sequence</title>
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
<?php


include '../navigation_panel/authenticated_user_header.php';
$empno = $_SESSION['employee_id'];
$companyId = $_SESSION['company_ID'];
?>
<?php
include_once '../Classes/Timesheets.php';

$TimesheetObject = new Timesheets($link);
?>

<?php
$message = '';
if (isset($_POST['save'])) {
    // collect values
    $startDay = $_POST['start_day'];
    $endDay = $_POST['end_day'];

    // check if overlapping timesheet already exists

    // insert into DB
    $result = $TimesheetObject->createTimesheet($empno, $companyId, $startDay, $endDay);

    if ($result) {
        $start_date = new DateTime($startDay);
        $end_date = new DateTime($endDay);


        $interval = $start_date->diff($end_date);
        $num_days = $interval->days;
        // Create a session variable to store the number of days
        $_SESSION["num_days"] = $num_days;
        $_SESSION["ts_current_date"] = $start_date;
        $tmid = mysqli_insert_id($link);
        $_SESSION["timesheet_id"] = mysqli_insert_id($link);

        // return var_dump($tmid);
        echo '<script>window.location.assign("create-timesheet?page=1&current-date=' . $startDay . '");</script>';
    } else {
        $message = '<p class="alert alert-danger">Something went wrong. Please try again.</p>';
    }
}
?>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    New Sequence
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#"> New Sequence</a></li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="" style="margin-bottom: 8px;">
                            <button href="" onclick="history.back()" class="btn btn-primary">Back</button>
                        </div>
                        <div class="box">

                            <div class="box-body">
                                <div>
                                    <?php
                                    echo strlen($message) > 0 ? $message : '';
                                    ?>
                                </div>
                                <div class="">
                                    <i class="fa fa-calendar" aria-hidden="true" style="font-size: x-large;"></i>
                                    <span class="" style="font-size: large;">Sequence Entry</span>
                                </div>

                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="start_day">Start Date</label>
                                        <input type="date" name="start_day" id="start_day" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="end_day">End Day</label>
                                        <input type="date" name="end_day" id="end_day" class="form-control" required>
                                    </div>
                                    <button type="submit" name="save" class="btn btn-primary">
                                        Next
                                    </button>
                                </form>

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
</body>

</html>