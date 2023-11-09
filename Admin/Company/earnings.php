<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Earnings</title>
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
        include_once '../Classes/Department.php';
        $DepartmentObject = new Department();
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    $compID = $_SESSION['company_ID'];
                    echo $_SESSION['name'] . ' Employee Earnings';
                    ?>
                </h1>
            </section>

            <?php
            if (isset($_POST['add_'])) {
                $name = $_POST['name'];
                $slug = $_POST['slug'];
                $company_id = $_POST['company_id'];


                $add_q = mysqli_query($link, "INSERT INTO earnings (name,slug, company_ID)
                        VALUES('$name','$slug', '$company_id')") or die(mysqli_error($link));

                if ($add_q) {
                    // add column to employee_earnings table
                    $sanitized_name = str_replace(" ", "_", strtolower($name));
                    $update_table = mysqli_query($link, "ALTER TABLE `employee_earnings` ADD `$sanitized_name` INT(10) NULL");
                    echo "<script> alert('Added Successfuly') </script>";
                    echo "<script> window.location.href='earnings' </script>";
                }
            }
            if (isset($_POST['update'])) {
                // return var_dump($_POST);
                $name = $_POST['name'];
                $slug = $_POST['slug'];
                $original_name = $_POST['orig_name'];
                $id = $_POST['id'];

                $add_q = mysqli_query($link, "UPDATE earnings SET name = '$name',slug='$slug'
                        WHERE id = '$id' ") or die(mysqli_error($link));

                // update employee earnings rename column
                $sanitized_name =  str_replace(" ", "_", strtolower($name));
                $original_sanitized = str_replace(" ", "_", strtolower($original_name));
                $upd_query = "ALTER TABLE `employee_earnings` CHANGE `$original_sanitized` `$sanitized_name` INT(10) NULL DEFAULT NULL";
                var_dump($upd_query);
                $update_earn = mysqli_query($link, $upd_query) or die(mysqli_error($link));

                if ($add_q) {
                    echo "<script> alert('Updated Successfuly') </script>";
                    echo "<script> window.location.href='earnings' </script>";
                }
            }
            if (isset($_POST['delete'])) {
                $id = $_POST['id'];
                $name = $_POST['name'];

                $add_q = mysqli_query($link, "DELETE FROM earnings WHERE id = '$id' ") or die(mysqli_error($link));

                if ($add_q) {
                    $sanitized_name = str_replace(" ", "_", strtolower($name));
                    $update_table = mysqli_query($link, "ALTER TABLE `employee_earnings` DROP `$sanitized_name`;");
                    echo "<script> alert('Deleted Successfuly') </script>";
                    echo "<script> window.location.href='earnings' </script>";
                }
            }
            ?>

            <section class="content container">
                <div class="row center">
                    <div class="col-xs-9 col-md-7 col-md-offset-1">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Earnings List</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Short Name</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($link, "SELECT * FROM earnings WHERE company_ID='$compID'") or die(mysqli_error($link));
                                        while ($row = mysqli_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['slug']; ?></td>
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
                                                            <h4 class="modal-title">Update Earnings</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="form-horizontal" method="post" action="#update" enctype='multipart/form-data'>

                                                                <div class="form-group">
                                                                    <label for="name">Name</label>
                                                                    <div class="input-group col-md-12">
                                                                        <input type="text" class="form-control pull-right" id="date" name="name" value="<?php echo $row['name'] ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="date">Short Name</label>
                                                                    <div class="input-group col-md-12">
                                                                        <input type="text" class="form-control" name="slug" value="<?php echo $row['slug']; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" required>
                                                                <input type="hidden" class="form-control pull-right" id="orig_name" name="orig_name" value="<?php echo $row['name'] ?>">
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
                                                            <h4 class="modal-title">Are you sure you want to delete this field ??
                                                            </h4>
                                                        </div>
                                                        <div class="modal-body" hidden="">
                                                            <form class="form-horizontal" method="post" action="#delete" enctype='multipart/form-data'>
                                                                <div class="form-group">
                                                                    <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" required>
                                                                        <input type="text" class="form-control" id="name" name="id" value="<?php echo $row['id']; ?>" required>
                                                                    </div>
                                                                    <input type="hidden" name="name" value="<?= $row['name'] ?>">
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
                                <h3 class="box-title">Add New Earnings</h3>
                            </div>
                            <div class="box-body">
                                <!-- Date range -->
                                <form method="post" action="#add_" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="date">Name</label>
                                        <div class="input-group col-md-12">
                                            <input type="text" class="form-control pull-right" id="date" name="name" placeholder="E.g Basic Pay" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Short Name <small class="text-danger">must have no spaces or special charecter</small> </label>
                                        <div class="input-group col-md-12">
                                            <input type="text" class="form-control pull-right" name="slug" placeholder="E.g BasicPay" required>
                                        </div>
                                    </div>
                                    <input type="hidden" name="company_id" value="<?= $compID ?>">
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