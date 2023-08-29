<?php 
error_reporting(0);
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Pay Slips</title>
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

    <script>
        $(function() {
            $("#datepicker").datepicker();
            $(document).ready(function() {
                // numeric validation.. 
                $("#numeric").keydown(function(event) {
                    if (event.keyCode == 46 || event.keyCode == 8) {
                        // let it happen, don't do anything
                    } else {
                        if (event.keyCode < 48 || event.keyCode > 57) {
                            event.preventDefault();
                        }
                    }
                });

                $("#numeric2").keydown(function(event) {
                    if (event.keyCode == 46 || event.keyCode == 8) {
                        // let it happen, don't do anything
                    } else {
                        if (event.keyCode < 48 || event.keyCode > 57) {
                            event.preventDefault();
                        }
                    }
                });

                $("#numeric3").keydown(function(event) {
                    if (event.keyCode == 46 || event.keyCode == 8) {
                        // let it happen, don't do anything
                    } else {
                        if (event.keyCode < 48 || event.keyCode > 57) {
                            event.preventDefault();
                        }
                    }
                });

                $("#numeric4").keydown(function(event) {
                    if (event.keyCode == 46 || event.keyCode == 8) {
                        // let it happen, don't do anything
                    } else {
                        if (event.keyCode < 48 || event.keyCode > 57) {
                            event.preventDefault();
                        }
                    }
                });


            });

        });
    </script>
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/Department.php';
        include_once '../Classes/Payslips.php';
        include_once '../Classes/Loans.php';
        include_once '../Classes/Tax.php';
        $LoanObject = new Loans();
        $DepartmentObject = new Department();
        $PaySlipsObject = new Payslips();
        $TaxObject = new Tax();

        include '../navigation_panel/authenticated_user_header.php';
        //$companyId = $_SESSION['username'];
        $compId = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['save'])) {
            $date_period = $_POST['date_period'];

            $date_timestamp = strtotime($date_period);
            $time = date('Y-m-d', $date_timestamp);

            echo "<script> window.location='pay-slip-entry-finish.php?time=$time' </script>";
        }
        ?>

        <div class="content-wrapper">

            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <a href="" class="btn btn-primary btn-block margin-bottom">Back</a>
                    </div>
                    <div class="col-md-5">
                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <label>Select Date Period:</label>
                                    <div class="form-horizontal">
                                        <input required="required" id="datepicker" name="date_period" class="form-control" placeholder="Date Period:" autocomplete="off">
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button name="save" type="submit" class="btn btn-primary"></i>Next</button>
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
    </div><!-- ./wrapper -->

    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- Slimscroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- iCheck -->
    <script src="../plugins/iCheck/icheck.min.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
</body>

</html>