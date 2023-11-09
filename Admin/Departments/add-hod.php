<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Department</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.print.css" media="print">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <script src="../../js/jquery.min.js"></script>

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">
        <?php
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Department.php';

        $DepartmentObject = new Department();

        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        $comp_ID = $_SESSION['company_ID'];
        if (isset($_POST['save_post'])) {

            $savemessage = "";
            $department = $_POST['department'];
            $hod = $_POST['hod'];
            $superior = $_POST['superior'];
            $DepartmentObject->AddHOD($hod, $department, $comp_ID, $superior);
            $savemessage = "Record added sucessfully!!";

        ?>

        <?php
        }
        ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">

            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <a href="view-departments.php" class="btn btn-primary btn-block margin-bottom">Back</a>
                    </div>
                    <div class="col-md-5">
                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">

                                    <?php
                                    if (isset($_POST['save_post'])) {
                                        echo ' <center>
                                            <h3 style="color: green" class="box-title"><b>' . $savemessage . '</b></h3>
                                        </center>';
                                    } else {
                                        echo ' <center>
                                            <h3 style="color: black" class="box-title"><b>Add  Head Of Department</b></h3>
                                        </center>';
                                    }
                                    ?>

                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <h5 style="color: black"><b>Select a department</b></h5>
                                        <select name="department" class="form-control">
                                            <option>--Select Department--</option>
                                            <?php
                                            $AllDepartments = $DepartmentObject->getDepartmentByCompany($comp_ID);
                                            while ($row = mysqli_fetch_array($AllDepartments)) {
                                            ?>
                                                <option value="<?php echo $row['dep_id'] ?>"> <?php echo $row['department']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Select the person heading the department</b></h5>
                                        <select name="hod" class="form-control">
                                            <option>--Select Employee to head Department--</option>
                                            <?php

                                            $EmployeeQuery = $DepartmentObject->getAllEmployees();
                                            while ($row = mysqli_fetch_array($EmployeeQuery)) {
                                            ?>
                                                <option value="<?php echo $row['empno']; ?>"> <?php echo $row['fname'] . "-" . $row['lname'] . "-" . $row['position']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Select the Supervisor to the person selected above</b></h5>
                                        <select name="superior" class="form-control">
                                            <option>--Select superior to person selected above--</option>
                                            <?php
                                            $EmployeeQuery = $DepartmentObject->getAllEmployees();
                                            while ($row = mysqli_fetch_array($EmployeeQuery)) {
                                            ?>
                                                <option value="<?php echo $row['empno']; ?>"> <?php echo $row['fname'] . "-" . $row['lname'] . "-" . $row['position']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button name="save_post" type="submit" class="btn btn-primary"></i>Save</button>
                                    </div>
                                    <button onclick="window.history.back();" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                </div>
                            </div><!-- /. box -->

                        </form>

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <?php include '../footer/footer.php'; ?>

        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
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
    <!-- Page Script -->
    <script>
        $(function() {
            //Add text editor
            $("#compose-textarea").wysihtml5();
        });
    </script>
</body>

</html>