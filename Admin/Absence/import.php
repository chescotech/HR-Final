<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Attendance Log</title>
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
    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker();
        });
    </script>
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/Leave.php';
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Employee.php';
        $compID = $_SESSION['company_ID'];
        $EmployeeObject = new Employee();
        $leaveObject = new Leave();
        ?>

        <?php
        if (isset($_POST["import"])) {
            echo $filename = $_FILES["file"]["tmp_name"];
            if ($_FILES["file"]["size"] > 0) {
                $file = fopen($filename, "r");
                while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {

                    if ($emapData[0] !== "") {
                        $sql = "INSERT into mobile_content_subscriptions (Subscription_date, Timestamp,Subscriber,Product_id,
                            First_subscription_date,Last_subscription_date,
                            Next_renewal_date, Cycle_Count, Auto_renew, Channel_id,
                            Unsubscription_Date, Sync_Confirm,Last_Sync_date,Status) 
	            	values('2017-05-23 10:15:22','2017-05-23 10:15:22','$emapData[0]','26001220000004412'"
                            . ",'2017-05-23 10:15:22','2017-05-23 10:15:22',"
                            . "'2017-05-23 10:15:22','1','1','1',"
                            . "'2017-05-23 10:15:22','0','2017-05-23 10:15:22','ACTIVE' )";
                        //we are using mysql_query function. it returns a resource on true else False on error
                        $result = mysql_query($sql);
                    }

                    if (!$result) {
                    }
                }
                fclose($file);
            }
        }
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    echo $_SESSION['name'] . ' Employee Attendance Log';
                    ?>
                </h1>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-xs-20">
                        <form action="import" enctype="multipart/form-data" method="post">
                            <table cellpadding="" border="0" class="se">
                                <tr>
                                    <td>
                                        <input required="required" name="file" type="file" class="form-control">
                                    </td>
                                    <td>
                                        <button type="submit" name="import" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-import"></span> Import Attendance (CSV)
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>


                    </div>

                    <br>
                    <div class="col-xs-17">
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="employee_data" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <td>Employee Name</td>
                                                <td>Log Date</td>
                                                <td>Check In Time</td>
                                                <td>Check Out Time</td>
                                                <td>Input Device</td>
                                                <td>Total Time Worked</td>
                                            </tr>
                                        </thead>
                                        <?php
                                        if (isset($_POST['search'])) {
                                            $logDate = strtotime($_POST['search_month']);
                                            $convertedDate = date('m/d/Y', $logDate);
                                            $lTime = "";
                                            $LogoutTime = "";
                                            $timeWorked = "";

                                            $empno = $_POST['empno'];
                                            $AbsentQuery = $leaveObject->getAttendanceLogList($convertedDate, $empno);

                                            while ($row = mysql_fetch_array($AbsentQuery)) {
                                                $EmployeeName = $leaveObject->getEmployeeDetails($row['empno']);
                                                $LogDate = $row['log_date'];
                                                $id = $row['id'];
                                                $LoginTime = $row['log_time'];

                                                $logStatus = $row['status'];

                                                if ($logStatus == "in") {
                                                    $lTime = $leaveObject->getCheckInTime($id);
                                                } else if ($logStatus == "out") {
                                                    $LogoutTime = $leaveObject->getCheckOutTime($id);
                                                }

                                                if ($lTime != "" && $LogoutTime != "") {
                                                    $timeWorked = $leaveObject->timeDiff($lTime, $LogoutTime);
                                                }

                                                $date = date('F jS Y', strtotime($LogDate));

                                                echo '  
                                                        <tr>  
                                                        <td>' . $EmployeeName . '</td>  
                                                        <td>' . $date . '</td> 
                                                        <td>' . $lTime . '</td>                                    
                                                        <td>' . $LogoutTime . '</td>
                                                        <td>Biometric</td>            
                                                        <td>' . $timeWorked . '</td>                                                                              
                                                        </tr>          
                                                         ';
                                            }
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