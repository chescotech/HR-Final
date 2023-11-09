<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Assessment Group</title>
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

    <!-- Multiselect -->

    <!-- <script type="text/javascript" src="docs/js/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="docs/js/bootstrap.bundle-4.5.2.min.js"></script>
    <script type="text/javascript" src="docs/js/prettify.min.js"></script> -->

    <link rel="stylesheet" href="dist/css/bootstrap-multiselect.css" type="text/css">
    <script type="text/javascript" src="dist/js/bootstrap-multiselect.js"></script>

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>
        <?php
        // get boss department.
        $emp_no = $_SESSION['empno'];
        $gt_dep = mysqli_query($link, "SELECT dept FROM emp_info WHERE empno = '$emp_no' ") or die(mysqli_error($link));
        $gt_dep_r = mysqli_fetch_array($gt_dep);
        $dep_id = $gt_dep_r['dept'];

        if (isset($_GET['grp_name'])) {
            $grp_name = $_GET['grp_name'];
        ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        <?php
                        $compID = $_SESSION['company_ID'];
                        $dept = $_SESSION['dept'];
                        echo $_SESSION['company_name'] . ' Assessment Group';
                        ?>
                    </h1>
                </section>

                <?php
                $bossno = $_SESSION['empno'];
                //$dept = $_SESSION['dept'];
                if (isset($_POST['create_grp'])) {
                    $name = $_POST['name'];
                    $empnos = $_POST['empnos'];
                    $dept = $_SESSION['dept'];
                    foreach ($empnos as $key => $value) {
                        $empno = $empnos[$key];
                        mysqli_query($link, "INSERT INTO ass_group (name,empno, bossno,dept )
                        VALUES('$name','$empno','$bossno','$dept' )") or die(mysqli_error($link));
                    }
                    echo "<script> alert('Added Successfuly') </script>";
                    echo "<script> window.location='assessment_group?grp_name=" . $name . "' </script>";
                }
                if (isset($_POST['update'])) {
                    $name = $_POST['name'];
                    $date = $_POST['date'];
                    $date_from = $_POST['date_from'];
                    $status = $_POST['status'];
                    $id = $_POST['id'];

                    $add_q = mysqli_query($link, "UPDATE ass_periods SET name = '$name',status='$status',
                        date = '$date', date_from = '$date_from' WHERE id = '$id' ") or die(mysqli_error($link));

                    if ($add_q) {
                        echo "<script> alert('Updated Successfuly') </script>";
                        //echo "<script> window.location='period' </script>";
                    }
                }
                if (isset($_POST['delete'])) {
                    $empno = $_POST['empno'];

                    $add_q = mysqli_query($link, "DELETE FROM ass_group WHERE empno = '$empno' ") or die(mysqli_error($link));

                    if ($add_q) {
                        echo "<script> alert('Deleted Successfuly') </script>";
                        echo "<script> window.location='assessment_group?grp_name=" . $grp_name . "' </script>";
                    }
                }
                ?>

                <div class="example">
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#milti_s').multiselect({
                                enableCaseInsensitiveFiltering: true,
                                buttonWidth: '400px',
                                maxHeight: 500
                            });
                        });
                    </script>
                </div>
                <section class="content container">
                    <div class="row center">
                        <div class="col-md-6">
                            <div class="box box-primary">
                                <br>
                                <a href="assessment_groups.php" class="btn btn-primary btn-sm"> Back </a>
                                <div class="box-header">
                                    <h3 class="box-title">Create Assessment Group</h3>
                                </div>
                                <div class="box-body">

                                    <form method="post" action="#">
                                        <div class="form-group">
                                            <label for="date">Group Name</label>
                                            <div class="input-group">
                                                <input readonly value="<?php echo $_GET['grp_name'] ?>" type="text" name="name" required />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="date">Select Employees</label>
                                            <div class="custom-select" style="width:200px;">
                                                <select id="milti_s" multiple="multiple" name="empnos[]" style="width:600px!important" required>
                                                    <?php
                                                    // $dept = $_GET['quote_id'];
                                                    // if employee logged in has no supervisior but has people reporting to him.., 

                                                    $checkifParentSupervisor = mysqli_query($link, "SELECT * FROM `hod_tb` where parent_supervisor='$emp_no'") or die(mysqli_error($link));
                                                    if (mysqli_num_rows($checkifParentSupervisor) > 0) {
                                                        $query2 = mysqli_query($link, "select * FROM emp_info WHERE emp_info.empno IN (  SELECT empno FROM `hod_tb` where parent_supervisor='$emp_no')") or die(mysqli_error($link));
                                                    } else {
                                                        $query2 = mysqli_query($link, "select * FROM emp_info WHERE dept = '$dep_id' ") or die(mysqli_error($link));
                                                    }

                                                    while ($row = mysqli_fetch_array($query2)) {
                                                    ?>
                                                        <option value="<?php echo $row['empno']; ?>"><?php echo $row['fname'] . " " . $row['lname']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="date"></label>
                                            <div class="input-group">
                                                <button class="btn btn-sm btn-primary" type="submit" tabindex="3" name="create_grp">Create</button>
                                            </div>
                                        </div>
                                    </form>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>

                        <div class="col-xs-9 col-md-6 ">
                            <div class="box box-primary">

                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Employee #</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($link, "SELECT fname, lname, emp_info.empno FROM emp_info 
                                                    INNER JOIN ass_group ON emp_info.empno = ass_group.empno
                                                    WHERE name = '$grp_name' AND bossno = '$bossno'
                                                    ") or die(mysqli_error($link));
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
                                                    <td><?php echo $row['empno']; ?></td>
                                                    <td>
                                                        <a href="#delete<?php echo $row['id']; ?>" data-target="#delete<?php echo $row['empno']; ?>" data-toggle="modal" style="color:#fff;" class="btn btn-danger btn-sm">Remove</a>
                                                    </td>
                                                </tr>
                                                <div id="delete<?php echo $row['empno']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content" style="height:auto">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span></button>
                                                                <h4 class="modal-title">Are you sure you want to remove employee ??
                                                                </h4>
                                                            </div>
                                                            <form class="form-horizontal" method="post" action="#delete" enctype='multipart/form-data'>
                                                                <div class="modal-body" hidden="">
                                                                    <div class="form-group">
                                                                        <div class="col-lg-9">
                                                                            <input type="text" class="form-control" name="empno" value="<?php echo $row['empno']; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary" name="delete">Remove</button>
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
                </section>

            </div>
        <?php
        } else {
        ?>


            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        <?php
                        $compID = $_SESSION['company_ID'];
                        echo $_SESSION['company_name'] . ' Assessment Group';
                        ?>
                    </h1>
                </section>

                <?php
                $dept = $_SESSION['dept'];
                // echo '$dept' . $dept;
                $bossno = $_SESSION['empno'];
                if (isset($_POST['create_grp'])) {
                    $name = $_POST['name'];
                    $empnos = $_POST['empnos'];

                    foreach ($empnos as $key => $value) {
                        $empno = $empnos[$key];
                        mysqli_query($link, "INSERT INTO ass_group (name,empno, bossno,dept )
                        VALUES('$name','$empno','$bossno','$dept' )") or die(mysqli_error($link));
                    }
                    echo "<script> alert('Added Successfuly') </script>";
                    echo "<script> window.location='assessment_group?grp_name=" . $name . "' </script>";
                }
                if (isset($_POST['update'])) {
                    $name = $_POST['name'];
                    $date = $_POST['date'];
                    $date_from = $_POST['date_from'];
                    $status = $_POST['status'];
                    $id = $_POST['id'];

                    $add_q = mysqli_query($link, "UPDATE ass_periods SET name = '$name',status='$status',
                        date = '$date', date_from = '$date_from' WHERE id = '$id' ") or die(mysqli_error($link));

                    if ($add_q) {
                        echo "<script> alert('Updated Successfuly') </script>";
                        //echo "<script> window.location='period' </script>";
                    }
                }
                if (isset($_POST['delete'])) {
                    $empno = $_POST['empno'];

                    $add_q = mysqli_query($link, "DELETE FROM ass_group WHERE empno = '$empno' ") or die(mysqli_error($link));

                    if ($add_q) {
                        echo "<script> alert('Deleted Successfuly') </script>";
                        echo "<script> window.location='assessment_group?grp_name=" . $name . "' </script>";
                    }
                }
                ?>

                <div class="example">
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#milti_s2').multiselect({
                                enableCaseInsensitiveFiltering: true,
                                buttonWidth: '400px',
                                maxHeight: 500
                            });
                        });
                    </script>
                </div>
                <section class="content container">
                    <div class="row center">
                        <div class="col-md-6">
                            <div class="box box-primary">
                                <br>
                                <a href="assessment_groups.php" class="btn btn-primary btn-sm"> Back </a>
                                <div class="box-header">
                                    <h3 class="box-title">Create Assessment Group</h3>
                                </div>
                                <div class="box-body">

                                    <form method="post" action="#">
                                        <div class="form-group">
                                            <label for="date">Group Name</label>
                                            <div class="input-group">
                                                <input class="" type="text" name="name" required />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="date">Select Employees</label>
                                            <div class="custom-select" style="width:200px;">
                                                <select id="milti_s2" multiple="multiple" name="empnos[]" style="width:600px!important" required>
                                                    <?php
                                                    // $dept = $_GET['quote_id'];
                                                    $checkifParentSupervisor = mysqli_query($link, "SELECT * FROM `hod_tb` where parent_supervisor='$emp_no'") or die(mysqli_error($link));
                                                    if (mysqli_num_rows($checkifParentSupervisor) > 0) {
                                                        $query2 = mysqli_query($link, "select * FROM emp_info WHERE emp_info.empno IN (  SELECT empno FROM `hod_tb` where parent_supervisor='$emp_no')") or die(mysqli_error($link));
                                                    } else {
                                                        $query2 = mysqli_query($link, "select * FROM emp_info WHERE dept = '$dep_id' ") or die(mysqli_error($link));
                                                    }

                                                    while ($row = mysqli_fetch_array($query2)) {
                                                    ?>
                                                        <option value="<?php echo $row['empno']; ?>"><?php echo $row['fname'] . " " . $row['lname']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="date"></label>
                                            <div class="input-group">
                                                <button class="btn btn-sm btn-primary" type="submit" tabindex="3" name="create_grp">Create</button>
                                            </div>
                                        </div>
                                    </form>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>

                        <div class="col-xs-9 col-md-6 ">
                            <div class="box box-primary">

                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Employee #</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($link, "SELECT fname, lname, emp_info.empno FROM emp_info 
                                                    INNER JOIN ass_group ON emp_info.empno = ass_group.empno
                                                    WHERE name = '' AND bossno = ''
                                                    ") or die(mysqli_error($link));
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
                                                    <td><?php echo $row['empno']; ?></td>
                                                    <td>
                                                        <a href="#delete<?php echo $row['id']; ?>" data-target="#delete<?php echo $row['empno']; ?>" data-toggle="modal" style="color:#fff;" class="btn btn-danger btn-sm">Remove</a>
                                                    </td>
                                                </tr>
                                                <div id="delete<?php echo $row['empno']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content" style="height:auto">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span></button>
                                                                <h4 class="modal-title">Are you sure you want to remove employee ??
                                                                </h4>
                                                            </div>
                                                            <form class="form-horizontal" method="post" action="#delete" enctype='multipart/form-data'>
                                                                <div class="modal-body" hidden="">
                                                                    <div class="form-group">
                                                                        <div class="col-lg-9">
                                                                            <input type="text" class="form-control" name="empno" value="<?php echo $row['empno']; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary" name="delete">Remove</button>
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
                </section>

            </div>
        <?php
        }
        ?>


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