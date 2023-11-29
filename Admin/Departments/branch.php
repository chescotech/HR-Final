<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Company Branches</title>
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
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #DDD;
        }
    </style>

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">
        <?php
        // include_once '../Classes/Department.php';
        // $DepartmentObject = new Department();
        include '../navigation_panel/authenticated_user_header.php';
        ?>


        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['new_name'])) {
            $message = "";
            $name = ($_POST['new_name']);
            $longi = ($_POST['longi']);
            $lati = ($_POST['lati']);

            $insert = mysqli_query($link, "INSERT INTO branch SET name = '$name', lati = '$lati', longi = '$longi' ") or die(mysqli_error($link));

            if ($insert) {
                // $message = "";
                echo "<script> alert('Record Added sucessfully') </script>";
                echo "<script> window.location='branch.php' </script>";
            }
        }

        if (isset($_GET['del'])) {
            $message = "";
            $id = ($_GET['del']);

            $delete = mysqli_query($link, "DELETE FROM branch WHERE id = '$id' ") or die(mysqli_error($link));

            if ($delete) {
                echo "<script> alert('Record Deleted sucessfully') </script>";
                echo "<script> window.location='branch.php' </script>";
            }
        }
        ?>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">

            </section>
            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <!-- <a href="../index.php" class="btn btn-primary btn-block margin-bottom">Back</a> -->
                        <div class="box box-solid" style="padding:10px">
                            <form action="#" method="POST">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="new_name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Latitude</label>
                                    <input type="text" name="lati" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Longitude</label>
                                    <input type="text" name="longi" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button class="form-control btn btn-primary" type="submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="box box-primary">
                            <div class="box-header with-border">

                                <table>
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <!-- <th>Update</th> -->
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $res_q = mysqli_query($link, "SELECT * FROM branch ");
                                        if (mysqli_num_rows($res_q) == 0) {
                                            echo "No Records Found";
                                        } else {
                                            while ($rows = mysqli_fetch_array($res_q)) {
                                                $b_name = $rows['name'];
                                                $b_id = $rows['id'];
                                                $lati = $rows['lati'];
                                                $longi = $rows['longi'];
                                        ?>
                                                <tr>
                                                    <td><?php echo $b_name ?></td>
                                                    <td><?php echo $lati ?></td>
                                                    <td><?php echo $longi ?></td>
                                                    <!-- <td>Update</td> -->
                                                    <td>
                                                        <a href="?del=<?php echo $b_id ?>" class="label label-danger"> Delete </a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>



                            </div><!-- /.box-footer -->
                        </div><!-- /. box -->


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