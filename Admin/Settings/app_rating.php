<?php
session_start();
?>
<!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Appraisal Rating</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    </head>

    <body class="hold-transition skin-green-light sidebar-mini">
        <div class="wrapper">

            <?php
            include '../navigation_panel/authenticated_user_header.php';
            ?>

            <?php include '../navigation_panel/side_navigation_bar.php'; ?>

            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        <?php
                        $compID = $_SESSION['company_ID'];
                        echo $_SESSION['name'] . ' Appraisal Ratings';
                        ?>
                    </h1>
                </section>

                <?php
                if (isset($_POST['add_'])) {
                    $from_ = $_POST['from_'];
                    $to_ = $_POST['to_'];
                    $rank = $_POST['rank'];
                    $recommendation = $_POST['recommendation'];

                    $add_q = mysqli_query($link, "INSERT INTO app_rating (from_,to_, rank, recommendation)
                        VALUES('$from_','$to_','$rank', '$recommendation')") or die(mysqli_error($link));

                    if ($add_q) {
                        echo "<script> alert('Added Successfuly') </script>";
                        echo "<script> window.location='app_rating' </script>";
                    }
                }
                if (isset($_POST['update'])) {
                    $from_ = $_POST['from_'];
                    $to_ = $_POST['to_'];
                    $rank = $_POST['rank'];
                    $recommendation = $_POST['recommendation'];
                    $id = $_POST['id'];

                    $add_q = mysqli_query($link, "UPDATE app_rating SET from_ = '$from_',to_='$to_',
                        rank = '$rank', recommendation = '$recommendation' WHERE id = '$id' ") or die(mysqli_error($link));

                    if ($add_q) {
                        echo "<script> alert('Updated Successfuly') </script>";
                        echo "<script> window.location='app_rating' </script>";
                    }
                }
                if (isset($_POST['delete'])) {
                    $id = $_POST['id'];

                    $add_q = mysqli_query($link, "DELETE FROM app_rating WHERE id = '$id' ") or die(mysqli_error($link));

                    if ($add_q) {
                        echo "<script> alert('Deleted Successfuly') </script>";
                        echo "<script> window.location='app_rating' </script>";
                    }
                }
                ?>

                <section class="content container">
                    <div class="row center">
                        <div class="col-xs-9 col-md-7 col-md-offset-1">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <!-- <h3 class="box-title">General Expenses</h3> -->
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Rating</th>
                                                <th>Ranking</th>
                                                <th>Recomendation</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($link, "SELECT * FROM app_rating") or die(mysqli_error($link));
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['from_'] . "-" . $row['to_']; ?></td>
                                                    <td><?php echo $row['rank']; ?></td>
                                                    <td><?php echo $row['recommendation']; ?></td>
                                                    <td>
                                                        <a href="#updateordinance<?php echo $row['id']; ?>" data-target="#updateordinance<?php echo $row['id']; ?>" data-toggle="modal" style="color:#fff;" class="btn btn-primary btn-sm">Edit</i></a>
                                                    </td>
                                                    <td>
                                                        <a href="#delete<?php echo $row['id']; ?>" data-target="#delete<?php echo $row['id']; ?>" data-toggle="modal" style="color:#fff;" class="btn btn-danger btn-sm">Delete</a>
                                                    </td>
                                                </tr>
                                                <div id="updateordinance<?php echo $row['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content" style="height:auto">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span></button>
                                                                <h4 class="modal-title">Update </h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="form-horizontal" method="post" action="#update" enctype='multipart/form-data'>

                                                                    <div class="form-group">
                                                                        <label>Rating From</label>
                                                                        <div class="input-group col-md-12">
                                                                            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" required>
                                                                            <input type="text" class="form-control pull-right" name="from_" value="<?php echo $row['from_'] ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Rating To</label>
                                                                        <div class="input-group col-md-12">
                                                                            <input type="text" class="form-control pull-right" name="to_" value="<?php echo $row['to_'] ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Ranking</label>
                                                                        <div class="input-group col-md-12">
                                                                            <input type="text" class="form-control" name="rank" value="<?php echo $row['rank']; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Recomendation</label>
                                                                        <div class="input-group col-md-12">
                                                                            <textarea class="form-control pull-right" name="recommendation" id="" cols="20" rows="6"><?php echo $row['recommendation']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary" name="update">Save changes</button>
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                    <!--end of modal-dialog-->
                                                </div>

                                                <div id="delete<?php echo $row['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content" style="height:auto">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span></button>
                                                                <h4 class="modal-title">Are u sure you want to delete this field ??
                                                                </h4>
                                                            </div>
                                                            <div class="modal-body" hidden="">
                                                                <form class="form-horizontal" method="post" action="#delete" enctype='multipart/form-data'>
                                                                    <div class="form-group">
                                                                        <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" required>
                                                                            <input type="text" class="form-control" id="name" name="id" value="<?php echo $row['id']; ?>" required>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <hr>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary" name="delete">Delete</button>
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                    <!--end of modal-dialog-->
                                                </div>

                                                <!--end of modal-->
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->

                            </div><!-- /.col -->


                        </div><!-- /.row -->
                        <div class="col-md-3">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Create New</h3>
                                </div>
                                <div class="box-body">
                                    <!-- Date range -->
                                    <form method="post" action="#add_holiday" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="date">Rating From</label>
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control pull-right" name="from_" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="date">Rating To</label>
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control pull-right" name="to_" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="date">Ranking</label>
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control pull-right" name="rank" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="date">Recomendation</label>
                                            <div class="input-group col-md-12">
                                                <textarea class="form-control pull-right" name="recommendation" id="" cols="20" rows="6"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <button class="btn btn-primary" id="daterange-btn" name="add_">
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
                        </div><!-- /.col (right) -->

                </section>

            </div>
            <?php include '../footer/footer.php'; ?>
            <div class="control-sidebar-bg"></div>
        </div><!-- ./wrapper -->

        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <!-- DataTables -->
        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>

        <!-- SlimScroll -->
        <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="../plugins/fastclick/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="../dist/js/demo.js"></script>
        <!-- page script -->
        <script>
            $(document).ready(function() {
                $('#employee_data').DataTable();
            });
        </script>
    </body>

    </html>