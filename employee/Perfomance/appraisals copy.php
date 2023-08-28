<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Perfomance Factors</title>
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
                    echo $_SESSION['company_name'] . ' Perfomance Appraisal';
                    ?>
                </h1>
            </section>

            <?php
            if (isset($_POST['add_'])) {

                $empno = $_POST['empno'];
                $params_id = $_POST['params'];
                $period_id = $_POST['period'];
                $factor_id = $_POST['factor'];
                $own_score = $_POST['own_score'];
                $boss_score = $_POST['boss_score'];
                $total_score = $_POST['total_score'];
                $comment = $_POST['comment'];

                $add_q = mysql_query("INSERT INTO ass_appraisals (empno,params_id, period_id, factor_id, own_score, boss_score, total_score, comment)
                        VALUES('$empno', '$params_id', '$period_id', '$factor_id', '$own_score', '$boss_score', '$total_score', '$comment')") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Added Successfuly') </script>";
                    echo "<script> window.location='appraisals' </script>";
                }
            }
            if (isset($_POST['update'])) {
                $name = $_POST['name'];
                $target = $_POST['target'];
                $id = $_POST['id'];

                $add_q = mysql_query("UPDATE ass_appraisals SET name = '$name',target='$target'
                        WHERE id = '$id' ") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Updated Successfuly') </script>";
                    echo "<script> window.location='appraisals' </script>";
                }
            }
            if (isset($_POST['delete'])) {
                $id = $_POST['id'];

                $add_q = mysql_query("DELETE FROM ass_appraisals WHERE id = '$id' ") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Deleted Successfuly') </script>";
                    echo "<script> window.location='appraisals' </script>";
                }
            }
            ?>

            <section class="content container">


                <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal">Create New</button>
                <br>
                <hr>

                <div class="row center">
                    <div class="col-xs-10 col-md-12 ">
                        <div class="box box-primary">
                            <div class="box-header">
                                <!-- <h3 class="box-title">General Expenses</h3> -->
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Period</th>
                                            <th>Parameter</th>
                                            <th>Factor / Objective</th>
                                            <th>Own Score</th>
                                            <th>Supervisor Score</th>
                                            <th>Agreed Score</th>
                                            <th>Appraisee's Comment</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysql_query("SELECT own_score, boss_score, total_score, comment, ass_appraisals.date, ass_appraisals.id,
                                                        emp_info.fname AS fname , emp_info.lname AS lname, emp_info.position AS position, emp_info.empno AS empno,
                                                        ass_params.name AS params, ass_params.id AS params_id, ass_periods.name AS periods,
                                                        ass_periods.id AS periods_id, ass_factors.name AS factors, ass_factors.id AS factors_id
                                                    FROM ass_appraisals
                                                    INNER JOIN emp_info ON emp_info.empno = ass_appraisals.empno 
                                                    left JOIN ass_params ON ass_params.id = ass_appraisals.params_id 
                                                    left JOIN ass_periods ON ass_periods.id = ass_appraisals.period_id 
                                                    left JOIN ass_factors ON ass_factors.id = ass_appraisals.factor_id 
                                                    ") or die("Error Getting Data " . mysql_error());
                                        while ($row = mysql_fetch_array($query)) {
                                            $emp_name = $row['fname'] . " " . $row['lname'];
                                            $period = $row['periods'];
                                            $params = $row['params'];
                                            $factor = $row['factors'];
                                            $own_score = $row['own_score'];
                                            $boss_score = $row['boss_score'];
                                            $total_score = $row['total_score'];
                                            $comment = $row['comment'];
                                        ?>
                                            <tr>
                                                <td><?php echo $emp_name; ?></td>
                                                <td><?php echo $period; ?></td>
                                                <td><?php echo $params; ?></td>
                                                <td><?php echo $factor; ?></td>
                                                <td><?php echo $own_score; ?></td>
                                                <td><?php echo $boss_score; ?></td>
                                                <td><?php echo $total_score; ?></td>
                                                <td><?php echo $comment; ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="view_appraisal?app_id=<?php echo $row['id']; ?>" style="color:#fff;" class="btn btn-primary btn-sm">View</i></a>
                                                        <!-- <a href="#updateordinance<?php echo $row['id']; ?>" data-target="#updateordinance<?php echo $row['id']; ?>" data-toggle="modal" style="color:#fff;" class="btn btn-primary btn-sm">Edit</i></a> -->
                                                        <a href="#delete<?php echo $row['id']; ?>" data-target="#delete<?php echo $row['id']; ?>" data-toggle="modal" style="color:#fff;" class="btn btn-danger btn-sm">Delete</a>
                                                    </div>
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
                                                                    <label for="name">Factor / Objective</label>
                                                                    <div class="input-group col-md-12">
                                                                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" required>
                                                                        <input type="text" class="form-control pull-right" id="date" name="name" value="<?php echo $row['name'] ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="date">Target Score</label>
                                                                    <div class="input-group col-md-12">
                                                                        <input type="text" class="form-control" id="name" name="target" value="<?php echo $row['target']; ?>" required>
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

                    <!-- Modal -->
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Create New</h4>
                                </div>
                                <div class="modal-body">

                                    <form method="post" action="#add_holiday" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="date">Employee</label>
                                            <div class="input-group col-md-12">
                                                <select name="empno" class="form-control">
                                                    <option>-- Select Employee --</option>
                                                    <?php
                                                    $EmployeeQuery = mysql_query("SELECT * FROM emp_info ") or die(mysql_error());
                                                    while ($row = mysql_fetch_array($EmployeeQuery)) {
                                                    ?>
                                                        <option value="<?php echo $row['empno']; ?>"> <?php echo $row['fname'] . "-" . $row['lname'] . "-" . $row['position']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="date">Parameters</label>
                                            <div class="input-group col-md-12">
                                                <select name="params" class="form-control">
                                                    <option>-- Select Parameters --</option>
                                                    <?php
                                                    $Query = mysql_query("SELECT * FROM ass_params ") or die(mysql_error());
                                                    while ($row1 = mysql_fetch_array($Query)) {
                                                    ?>
                                                        <option value="<?php echo $row1['id']; ?>"> <?php echo $row1['name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="date">Factors</label>
                                            <div class="input-group col-md-12">
                                                <select name="factor" class="form-control">
                                                    <option>-- Select Factor / Objective --</option>
                                                    <?php
                                                    $Query2 = mysql_query("SELECT * FROM ass_factors ") or die(mysql_error());
                                                    while ($row2 = mysql_fetch_array($Query2)) {
                                                    ?>
                                                        <option value="<?php echo $row2['id']; ?>"> <?php echo $row2['name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="date">Period</label>
                                            <div class="input-group col-md-12">
                                                <select name="period" class="form-control">
                                                    <option>-- Select Period --</option>
                                                    <?php
                                                    $Query2 = mysql_query("SELECT * FROM ass_periods ") or die(mysql_error());
                                                    while ($row2 = mysql_fetch_array($Query2)) {
                                                    ?>
                                                        <option value="<?php echo $row2['id']; ?>"> <?php echo $row2['name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="date">Own Score</label>
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control pull-right" name="own_score" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="date">Supervisor Score</label>
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control pull-right" name="boss_score" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="date">Total Score</label>
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control pull-right" name="total_score" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="date">Appraisee’s Comments</label>
                                            <div class="input-group col-md-12">
                                                <textarea name="comment" class="form-control" rows="3"></textarea>

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

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>

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