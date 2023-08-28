<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>View CV</title>
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
                        $rows = mysql_fetch_array($sql);
                        ?>

                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <center>
                                        <h3 style="color: black" class="box-title">
                                            <b>
                                                Carriculum Vitae for <?php echo $EmployeeHistoryObject->getEmpInfo($empno) ?>
                                            </b>
                                        </h3>
                                    </center>
                                </div>
                                <div class="box-body">
                                    <?php
                                    $certificate = "../../employee/uploads/" . $EmployeeHistoryObject->getCv($empno);
                                    ?>
                                    <embed src="<?php echo $certificate; ?>" width="100%" height="2100px" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <?php include '../footer/footer.php'; ?>
        <div class="control-sidebar-bg"></div>
    </div>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>

    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>

    <script src="../plugins/fastclick/fastclick.min.js"></script>

    <script src="../dist/js/app.min.js"></script>

    <script src="../dist/js/demo.js"></script>

</body>

</html>
<?php
