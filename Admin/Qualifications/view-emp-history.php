<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employment History</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.print.css" media="print">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../../employee/Classes/EmployeeHistory.php';
        $EmployeeHistoryObject = new EmployeeHistory();
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
            </section>

            <section class="content">
                <div class="row">
                    <?php include 'employee-workhist-menu.php'; ?>
                    <div class="col-md-9">

                        <?php
                        $empno = $_SESSION['employee_id'];
                        $sql = $EmployeeHistoryObject->getHistoryInfo($empno);
                        $rows = mysql_fetch_array($sql);
                        ?>

                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <center>
                                    <h3 style="color: black" class="box-title">

                                        <b>Employment History for
                                            <?php echo $EmployeeHistoryObject->getEmpInfo($empno);  ?>
                                        </b>

                                    </h3>
                                </center>
                            </div>
                            <div class="box-body">

                                <div class="form-group">
                                    <h5 style="color: black"><b>Previous Employer ( 1 )</b></h5>
                                    <input readonly="readonly" value="<?php echo $rows['employer_one']; ?>" id="end_datepicker" name="employer_one" class="form-control" placeholder="Enter Company of previous Employment">
                                </div>

                                <div class="form-group">
                                    <h5 style="color: black"><b>Position</b></h5>
                                    <input readonly="readonly" value="<?php echo $rows['position_one']; ?>" name="position_one" class="form-control" placeholder="Position, E.g . Sales Manager. Etc:">
                                </div>

                                <div class="form-group">
                                    <h5 style="color: black"><b>Working Period</b></h5>
                                    <input readonly="readonly" value="<?php echo $rows['date_start_one']; ?>" name="date_start_one" readonly="readonly" class="form-control-static" placeholder="From:"> To : <input readonly="readonly" value="<?php echo $rows['date_end_one']; ?>" name="date_end_one" class="form-control-static" placeholder="To:">
                                </div>

                            </div>

                            <div class="box-body">

                                <div class="form-group">
                                    <h5 style="color: black"><b>Previous Employer ( 2 )</b></h5>
                                    <input readonly="readonly" value="<?php echo $rows['employer_two']; ?>" name="employer_two" class="form-control" placeholder="Enter Company of previous Employment">
                                </div>

                                <div class="form-group">
                                    <h5 style="color: black"><b>Position</b></h5>
                                    <input readonly="readonly" value="<?php echo $rows['position_two']; ?>" name="position_two" class="form-control" placeholder="Position, E.g . Sales Manager. Etc:">
                                </div>

                                <div class="form-group">
                                    <h5 style="color: black"><b>Working Period</b></h5>
                                    <input readonly="readonly" value="<?php echo $rows['date_start_two']; ?>" name="date_start_two" class="form-control-static" placeholder="From:"> To : <input readonly="readonly" value="<?php echo $rows['date_end_two']; ?>" name="date_end_two" class="form-control-static" placeholder="To:">
                                </div>
                            </div>

                            <div class="box-body">

                                <div class="form-group">
                                    <h5 style="color: black"><b>Previous Employer ( 3 ) </b></h5>
                                    <input readonly="readonly" value="<?php echo $rows['employer_three']; ?>" name="employer_three" class="form-control" placeholder="Enter Company of previous Employment:">
                                </div>

                                <div class="form-group">
                                    <h5 style="color: black"><b>Position</b></h5>
                                    <input readonly="readonly" value="<?php echo $rows['position_three']; ?>" name="position_three" class="form-control" placeholder="Position, E.g . Sales Manager. Etc:">
                                </div>
                                <div class="form-group">
                                    <h5 style="color: black"><b>Working Period</b></h5>
                                    <input readonly="readonly" value="<?php echo $rows['date_start_three']; ?>" name="date_start_three" class="form-control-static" placeholder="From:"> To : <input readonly="readonly" value="<?php echo $rows['date_end_three']; ?>" name="date_end_three" class="form-control-static" placeholder="To:">
                                </div>
                            </div>

                        </div>

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <?php include '../footer/footer.php'; ?>

        <div class="control-sidebar-bg"></div>
    </div>

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

</body>

</html>