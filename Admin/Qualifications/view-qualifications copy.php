<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Education Info</title>
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

                        if (isset($_GET['empid'])) {
                            $empno = $_GET['empid'];
                            $_SESSION['employee_id'] = $empno;
                        } else {
                            $empno = $_SESSION['employee_id'];
                        }

                        $sql = $EmployeeHistoryObject->getEduInfo($empno);
                        $rows = mysqli_fetch_array($sql);

                        ?>

                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <center>
                                        <h3 style="color: black" class="box-title">
                                            <b>
                                                Education Information for <?php echo $EmployeeHistoryObject->getEmpInfo($empno) ?>
                                            </b>
                                        </h3>
                                    </center>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <h5 style="color: black"><b>Highest Qualification</b></h5>
                                        <input readonly="readonly" value="<?php echo $rows['highest_qualifications']; ?>" name="qualifications" class="form-control" placeholder="Enter qualifications, e.g Bachelor Computer Science, Bachelor of English:">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Qualifications</b></h5>
                                        <input readonly="readonly" value="<?php echo $rows['qualifications']; ?>" name="qualifications" class="form-control" placeholder="Enter qualifications, e.g Bachelor Computer Science, Bachelor of English:">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>University / Tertiary Attended</b></h5>
                                        <input readonly="readonly" value="<?php echo $rows['university']; ?>" name="university" class="form-control" placeholder="University / Tertiary Attended:">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Secondary School Attended</b></h5>
                                        <input readonly="readonly" value="<?php echo $rows['secondary_school']; ?>" name="secondary_school" class="form-control" placeholder="Secondary School Attended:">
                                    </div>
                                </div>

                            </div>
                        </form>

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
<?php
