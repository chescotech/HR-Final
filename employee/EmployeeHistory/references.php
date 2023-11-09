<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>References</title>
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

    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker();
            $("#datepicker2").datepicker();
            $("#datepicker3").datepicker();
            $("#datepicker4").datepicker();
            $("#datepicker5").datepicker();
            $("#datepicker6").datepicker();
        });
    </script>

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/EmployeeHistory.php';
        $EmployeeHistoryObject = new EmployeeHistory();
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['save'])) {

            $employer_one = $_POST['employer_one'];
            $position_one = $_POST['position_one'];
            $date_start_one = $_POST['date_start_one'];
            $date_end_one = $_POST['date_end_one'];
            //employeer number two 

            $employer_two = $_POST['employer_two'];
            $position_two = $_POST['position_two'];
            $date_start_two = $_POST['date_start_two'];
            $date_end_two = $_POST['date_end_two'];

            // employer three ..

            $employer_three = $_POST['employer_three'];
            $position_three = $_POST['position_three'];
            $date_start_three = $_POST['date_start_three'];
            $date_end_three = $_POST['date_end_three'];

            $emp_id = $_SESSION['employee_id'];

            $sql = $EmployeeHistoryObject->getHistoryInfo($empno);

            if (mysqli_num_rows($sql) == 0) {
                $EmployeeHistoryObject->addEmpHistInfo(
                    $emp_id,
                    $employer_one,
                    $position_one,
                    $date_start_one,
                    $date_end_one,
                    $employer_two,
                    $position_two,
                    $date_start_two,
                    $date_end_two,
                    $employer_three,
                    $position_three,
                    $position_three,
                    $date_start_three,
                    $date_start_three,
                    $date_end_three
                );
            } else {
                $EmployeeHistoryObject->updateEmpHistInfo($emp_id, $employer_one, $position_one, $date_start_one, $date_end_one, $employer_two, $position_two, $date_start_two, $date_end_two, $employer_three, $position_three, $date_start_three, $date_end_three);
            }
        ?>
            <script>
                alert('Your employment history has been successfully inserted!!');
            </script>
        <?php
        }
        ?>

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

                        $rows = mysqli_fetch_array($sql);

                        ?>

                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <center>
                                        <h3 style="color: black" class="box-title"><b>Tell us Your Referees</b></h3>
                                    </center>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <h5 style="color: black"><b>Referees Company ( 1 )</b></h5>
                                        <input required="required" value="<?php echo $rows['employer_one']; ?>" id="end_datepicker" name="employer_one" class="form-control" placeholder="Enter Company of previous Employment">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Referees Email</b></h5>
                                        <input required="required" value="<?php echo $rows['position_one']; ?>" name="position_one" class="form-control" placeholder="Position, E.g . Sales Manager. Etc:">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Referees Phone</b></h5>
                                        <input required="required" value="<?php echo $rows['position_one']; ?>" name="position_one" class="form-control" placeholder="Position, E.g . Sales Manager. Etc:">
                                    </div>
                                </div>

                                <div class="box-body">

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Previous Employer ( 2 )</b></h5>
                                        <input value="<?php echo $rows['employer_two']; ?>" name="employer_two" class="form-control" placeholder="Enter Company of previous Employment">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Position</b></h5>
                                        <input value="<?php echo $rows['position_two']; ?>" name="position_two" class="form-control" placeholder="Position, E.g . Sales Manager. Etc:">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Working Period</b></h5>
                                        <input value="<?php echo $rows['date_start_two']; ?>" id="datepicker3" name="date_start_two" class="form-control-static" placeholder="From:"> To : <input value="<?php echo $rows['date_end_two']; ?>" id="datepicker4" name="date_end_two" class="form-control-static" placeholder="To:">
                                    </div>
                                </div>

                                <div class="box-body">

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Previous Employer ( 3 ) </b></h5>
                                        <input value="<?php echo $rows['employer_three']; ?>" name="employer_three" class="form-control" placeholder="Enter Company of previous Employment:">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Position</b></h5>
                                        <input value="<?php echo $rows['position_three']; ?>" name="position_three" class="form-control" placeholder="Position, E.g . Sales Manager. Etc:">
                                    </div>
                                    <div class="form-group">
                                        <h5 style="color: black"><b>Working Period</b></h5>
                                        <input value="<?php echo $rows['date_start_three']; ?>" id="datepicker5" name="date_start_three" class="form-control-static" placeholder="From:"> To : <input value="<?php echo $rows['date_end_three']; ?>" id="datepicker6" name="date_end_three" class="form-control-static" placeholder="To:">
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>
                                        <button name="save" type="submit" class="btn btn-primary"></i>Save</button>
                                    </div>
                                    <button class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                </div>
                            </div>
                        </form </div><!-- /.col -->
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