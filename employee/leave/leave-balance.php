<?php
session_start();
?>
<!DOCTYPE html>


<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Leave Balance</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">

    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

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
                    Your Leave balances
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#"> Leave Balance</a></li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">

                        <div class="box">

                            <div class="box-body">
                                <?php
                                $MyLeave = $leaveObject->checkLeaveDays($empno);

                                while ($row = mysqli_fetch_array($MyLeave)) {
                                    $available = $row['available'];
                                    echo "<span class='center h4'><u>You have " . $available . " days available </u> </span>";
                                }
                                ?>

                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Leave Start Date</th>
                                            <th>Leave End Date </th>
                                            <th>Days of Leave</th>
                                            <th>No. Of Available Leave Days</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php
                                            $MyLeave = $leaveObject->veiwLeaveBalance($empno);
                                            if (mysqli_num_rows($MyLeave) == 0) {
                                                echo '<tr>
                                                    <td style="vertical-align:middle" align="left">No records have been found for your leave</td>
                                                    </tr>';
                                            }
                                            // echo $empno;
                                            while ($row = mysqli_fetch_array($MyLeave)) {
                                                $id_ = $row['application_id'];
                                                $LeaveStartdate = $row['leave_start_date'];
                                                $leaveEndDate = $row['leave_end_date'];
                                                $startDate = strtotime($LeaveStartdate);
                                                $startDateConverted = date('Y-m-d', $startDate);

                                                $EndDate = strtotime($leaveEndDate);
                                                $EndDateConverted = date('Y-m-d', $EndDate);

                                                $start = new DateTime($startDateConverted);
                                                $end = new DateTime($EndDateConverted);
                                                $todaysDate = date("Y-m-d");

                                                $end->modify('+1 day');

                                                $interval = $end->diff($start);

                                                $days = $interval->days;

                                                $period = new DatePeriod($start, new DateInterval('P1D'), $end);
                                                $end = new DateTime($EndDateConverted);

                                                $start = new DateTime($todaysDate);
                                            ?>

                                        <tr class="del<?php echo $id_ ?>">
                                            <td style="vertical-align:middle" align="left"><?php
                                                                                            $datePrinted = strtoTime($row['leave_start_date']);
                                                                                            $datePrint = date('F d, Y', $datePrinted);
                                                                                            echo $datePrint;
                                                                                            ?></td>
                                            <td style="vertical-align:middle" align="left"><?php
                                                                                            $datePrinted2 = strtoTime($row['leave_end_date']);
                                                                                            $datePrint2 = date('F d, Y', $datePrinted2);
                                                                                            echo $datePrint2;
                                                                                            ?></td>
                                            <td style="vertical-align:middle" align="left">
                                                <?php
                                                foreach ($period as $dt) {
                                                    $curr = $dt->format('D');
                                                    // substract if Saturday or Sunday
                                                    if ($curr == 'Sat' || $curr == 'Sun') {
                                                        $days--;
                                                    }
                                                }
                                                echo $days . " Days Leave ";
                                                ?>
                                            </td>
                                            <td style="vertical-align:middle" align="left"><?php
                                                                                            if ($start <= $end) {
                                                                                                $end->modify('+1 day');

                                                                                                $interval = $end->diff($start);

                                                                                                $days = $interval->days;

                                                                                                $period = new DatePeriod($start, new DateInterval('P1D'), $end);

                                                                                                echo $available . " Days";
                                                                                            } else {
                                                                                                echo '<h6 style="color:red">' . "No Balance" . '<h6>';
                                                                                            }
                                                                                            ?></td>
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