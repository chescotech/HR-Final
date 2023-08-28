<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Perfomance Periods</title>
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
                    $dept = $_SESSION['dept'];
                    echo $_SESSION['company_name'] . ' Perfomance Period';
                    ?>
                </h1>
            </section>

            <?php
            if (isset($_POST['add_'])) {
                $name = $_POST['name'];
                $status = $_POST['status'];
                $date = $_POST['date'];
                $date_from = $_POST['date_from'];

                $add_q = mysql_query("INSERT INTO ass_periods (name,status, date, date_from,dept)
                        VALUES('$name','$status','$date','$date_from','$dept')") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Added Successfuly') </script>";
                    echo "<script> window.location='period' </script>";
                }
            }
            if (isset($_POST['update'])) {
                $name = $_POST['name'];
                $date = $_POST['date'];
                $date_from = $_POST['date_from'];
                $status = $_POST['status'];
                $id = $_POST['id'];

                $add_q = mysql_query("UPDATE ass_periods SET name = '$name',status='$status',
                        date = '$date', date_from = '$date_from' WHERE id = '$id' ") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Updated Successfuly') </script>";
                    //echo "<script> window.location='period' </script>";
                }
            }
            if (isset($_POST['delete'])) {
                $id = $_POST['id'];

                $add_q = mysql_query("DELETE FROM ass_periods WHERE id = '$id' ") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Deleted Successfuly') </script>";
                    echo "<script> window.location='period' </script>";
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
                                            <th>Name of Period</th>
                                            <th>Status</th>
                                            <th>Period of Appraisal</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysql_query("SELECT * FROM ass_periods WHERE dept='$dept'") or die(mysql_error());
                                        while ($row = mysql_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['status']; ?></td>
                                                <td><?php echo $row['date_from'] . " - " . $row['date']; ?></td>
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
                                                                    <label for="name">Name</label>
                                                                    <div class="input-group col-md-12">
                                                                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" required>
                                                                        <input type="text" class="form-control pull-right" id="date" name="name" value="<?php echo $row['name'] ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="date">Status</label>
                                                                    <div class="input-group col-md-12">
                                                                        <select name="status" class="form-control">
                                                                            <option value="<?php echo $row['status']; ?>"><?php echo $row['status']; ?></option>
                                                                            <option value="Open">Open</option>
                                                                            <option value="Closed">Closed</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="date">Period From</label>
                                                                    <div class="input-group col-md-12">
                                                                        <input type="date" class="form-control" name="date_from" value="<?php echo $row['date_from']; ?>" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="date">Period To</label>
                                                                    <div class="input-group col-md-12">
                                                                        <input type="date" class="form-control" name="date" value="<?php echo $row['date']; ?>" required>
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
                                        <label for="date">Name</label>
                                        <div class="input-group col-md-12">
                                            <input type="text" class="form-control pull-right" id="date" name="name" placeholder="Name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Status</label>
                                        <div class="input-group col-md-12">
                                            <select name="status" class="form-control">
                                                <option value="Open">Open</option>
                                                <option value="Closed">Closed</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="date">Period From</label>
                                        <div class="input-group col-md-12">
                                            <input type="date" class="form-control pull-right" id="date" name="date_from" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="date">Period To</label>
                                        <div class="input-group col-md-12">
                                            <input type="date" class="form-control pull-right" id="date" name="date" required>
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