<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jobs - HR and Payroll.</title>
    </title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../bootstrap-5.1.3-dist/css/bootstrap-grid.css">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../../../dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../../plugins/iCheck/flat/blue.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../../DataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>

    <!-- Morris chart -->
    <link rel="stylesheet" href="../../../plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../../../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="../../../plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../../plugins/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="https://ziscoerp.com/assets/css/datepicker.min.css">

    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <a href="" class="logo">
                <span class="logo-lg"><b>

                        <?php
                        // error_reporting(0);
                        session_start();
                        $_SESSION['activeLink'] = 'jobs';

                        if (isset($_SESSION['job_username'])) {
                        } else {
                            echo "<script> window.location='../jobs/login.php' </script>";
                        }
                        ?>


                    </b></span>
            </a>
            <?php include '../../navigation_panel/main_menu.php'; ?>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>

                <?php include '../../navigation_panel/authenticated_side_navigation_bar.php'; ?>

            </section>
        </aside>


        <?php //include 'form-list.php'; ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    echo " Departments";
                    ?>
                </h1>
            </section>

            <?php
            $user_id = $_SESSION['job_user_id'];
            if (isset($_POST['add_skill'])) {
                $department = $_POST['department'];
                $dep_id = $_POST['dep_id'];

                $add_q = mysql_query("INSERT INTO department (department, dep_id)
                        VALUES('$department' ,'$dep_id')") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Added Successfuly') </script>";
                    echo "<script> window.location='index' </script>";
                }
            }
            if (isset($_POST['update'])) {
                $department = $_POST['department'];
                $name = $_POST['name'];

                $dep_id = $_POST['dep_id'];

                $add_q = mysql_query("UPDATE department SET department = '$department', name = '$name',level='$level'
                        WHERE id = '$id' ") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Updated Successfuly') </script>";
                    echo "<script> window.location='index' </script>";
                }
            }
            if (isset($_GET['delete'])) {
                $dep_id = $_GET['delete'];

                $add_q = mysql_query("DELETE FROM department WHERE dep_id = '$dep_id' ") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Deleted Successfuly') </script>";
                    echo "<script> window.location='index' </script>";
                }
            }
            ?>

            <section class="content container">
                <div class="row center">

                    <div class="col-md-3">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Add Department</h3>
                            </div>
                            <div class="box-body">
                                <!-- Date range -->
                                <form method="post" action="#add_skill" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="date">Department Name</label>
                                        <div class="input-group col-md-12">
                                            <input type="text" class="form-control pull-right" name="department" placeholder="" required>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group ">
                                        <label class="">HOD</label>
                                        <select name="level" class="form-control">
                                            <option value=""> Select </option>
                                            <option value="Beginner">Beginner</option>
                                            <option value="Intermediate">Intermediate</option>
                                            <option value="Expert">Expert</option>
                                        </select>
                                    </div> -->

                                    <div class="form-group">
                                        <div class="input-group">
                                            <button class="btn btn-primary" id="daterange-btn" name="add_skill">
                                                Save
                                            </button>
                                            <button class="btn" id="daterange-btn">
                                                Clear
                                            </button>
                                        </div>
                                    </div><!-- /.form group -->
                                </form>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>

                    <div class="col-xs-9 col-md-7 col-md-offset-1">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">My Skills</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Department Name</th>
                                            <!-- <th>Edit</th> -->
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysql_query("SELECT * FROM department ") or die(mysql_error());
                                        while ($row = mysql_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $row['department']; ?></td>
                                                <!-- <td>
                                                    <a href="#updateordinance<?php //echo $row['dep_id']; ?>" data-target="#updateordinance<?php // echo $row['id']; ?>" data-toggle="modal" style="color:#fff;" class="btn btn-primary btn-sm">Edit</i></a>
                                                </td> -->
                                                <td>
                                                    <a href="?delete=<?php echo $row['dep_id']; ?>" style="color:#fff;" class="btn btn-danger btn-sm">Delete</a>
                                                </td>
                                            </tr>
                                            <!--end of modal-->
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->

                        </div><!-- /.col -->


                    </div>

            </section>

        </div>

        <?php include '../../../footer/footer.php'; ?>

        <div class="control-sidebar-bg"></div>
    </div>
    <!-- <script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script> -->

    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../../bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="../../../plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="../../../plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="../../../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="../../../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../../../plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="../../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="../../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="../../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="../../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../../../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../../../dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../../dist/js/demo.js"></script>
</body>

</html>