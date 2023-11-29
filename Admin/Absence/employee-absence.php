<?php
session_start()
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Absence List</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css" />

    <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Employee.php';
        $EmployeeObject = new Employee();
        include_once '../Classes/Leave.php';
        $leaveObject = new Leave();

        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    echo $_SESSION['name'] . ' Employee Absence List';
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
                                                <td>Firstname</td>
                                                <td>Lastname</td>
                                                <td>Department</td>
                                                <td>Absence Reason</td>
                                                <td>Duration</td>
                                                <td>From</td>
                                                <td>To</td>
                                            </tr>
                                        </thead>
                                        <?php
                                        $compID = $_SESSION['company_ID'];
                                        $AbsentQuery = $leaveObject->getPeopleAbsent($compID);
                                        if (mysqli_num_rows($AbsentQuery) > 0) {
                                            while ($row = mysqli_fetch_array($AbsentQuery)) {
                                                if ($leaveObject->checkForActiveLeaves($row['leave_end_date']) == "false") {

                                                    $LeaveStartdate = $row['leave_start_date'];
                                                    $leaveEndDate = $row['leave_end_date'];
                                                    $startDate = strtotime($LeaveStartdate);
                                                    $startDateConverted = date('Y-m-d', $startDate);

                                                    $EndDate = strtotime($leaveEndDate);
                                                    $EndDateConverted = date('Y-m-d', $EndDate);

                                                    $start = new DateTime($startDateConverted);
                                                    $end = new DateTime($EndDateConverted);

                                                    $end->modify('+1 day');

                                                    $interval = $end->diff($start);

                                                    $days = $interval->days;

                                                    $period = new DatePeriod($start, new DateInterval('P1D'), $end);

                                                    foreach ($period as $dt) {
                                                        $curr = $dt->format('D');
                                                        // substract if Saturday or Sunday
                                                        if ($curr == 'Sat' || $curr == 'Sun') {
                                                            $days--;
                                                        }
                                                    }

                                                    $leaveStart = $row["leave_start_date"];
                                                    $mydate2 = strtoTime($leaveStart);
                                                    $printdate2 = date('F d, Y', $mydate2);

                                                    $leaveEndDate = $row["leave_end_date"];
                                                    $mydate = strtoTime($leaveEndDate);
                                                    $printdate = date('F d, Y', $mydate);

                                                    echo '  
                                                <tr>  
                                                <td>' . $row["empno"] . '</td>  
                                                <td>' . $row["fname"] . '</td> 
                                                <td>' . $row["lname"] . '</td>                                    
                                                <td>' . $row["position"] . '</td>
                                                <td>' . $row["leave_type"] . '</td> 
                                                <td>' . $days . ' Working Days</td>
                                                <td>' . $printdate2 . '</td>
                                                <td>' . $printdate . '</td>                                    
                                                </tr>                                       
                                                 ';
                                                }
                                            }
                                        } else {
                                            // echo "No Data";
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
                    'csv', 'excel', 'print'
                ]
            });

            $("#datepicker").datepicker();
            $("#datepicker2").datepicker();
        });
    </script>
</body>

</html>