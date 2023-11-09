<?php
include '../../include/dbconnection.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
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

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">
        <?php
        include_once '../Classes/Department.php';
        $DepartmentObject = new Department();
        include '../navigation_panel/authenticated_user_header.php';
        ?>


        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['update_post'])) {
            $message = "";
            $name = $_POST['name'];
            $id = $_GET['id'];
            $DepartmentObject->updateWorkFlow($name, $id);


            $message = "Record updated sucessfully";
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
                        <a href="../index.php" class="btn btn-primary btn-block margin-bottom">Back</a>
                    </div>
                    <div class="col-md-9">
                        <?php
                        $id = $_GET['id'];
                        $EditQuery = $DepartmentObject->EditApprovers($id);
                        while ($rows = mysqli_fetch_array($EditQuery)) {
                        ?>

                            <form enctype="multipart/form-data" method="post">
                                <div class="box box-primary">
                                    <div class="box-header with-border">

                                        <?php
                                        if (isset($_POST['update_post'])) {
                                            echo ' <center>
                                            <h3 style="color: green" class="box-title"><b>' . $message . '</b></h3>
                                        </center>';
                                        } else {
                                            echo ' <center>
                                            <h3 style="color: black" class="box-title"><b>Edit Work Flow Name</b></h3>
                                        </center>';
                                        }
                                        ?>
                                    </div>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <h5>Work Flow Name:</h5><input name="name" value="<?php echo $rows['name']; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="box-body">

                                    </div>
                                    <div class="box-footer">
                                        <div class="pull-right">
                                            <button name="update_post" type="submit" class="btn btn-primary"></i>Update</button>
                                        </div>
                                        <button class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                    </div><!-- /.box-footer -->
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
<?php
                        }
