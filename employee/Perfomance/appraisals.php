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

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" /> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />

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
                    $bossno = $_SESSION['employee_id'];
                    $dept = $_SESSION['dept'];
                    $period_id = $_GET['period_id'];
                    // Get period id and name
                    $p_q = mysql_query("SELECT name FROM ass_periods WHERE id = '$period_id' ");
                    $p_r = mysql_fetch_array($p_q);
                    $period_name = $p_r['name'];
                    // Get Department ID
                    $d_q = mysql_query("SELECT * FROM emp_info WHERE empno = '$bossno' ") or die(mysql_error());
                    $d_r = mysql_fetch_array($d_q);
                    $dept_id = $d_r['dept'];
                    // var_dump($dept_id);

                    echo 'Perfomance Appraisal for <i><u>' . $period_name . '</u></i>';
                    ?>
                </h1>
            </section>

            <?php
            if (isset($_POST['add_'])) {

                $bossno = $_POST['bossno'];
                $params_id = $_POST['params'];
                $factor_id = $_POST['factor'];
                $dept_id = $_POST['dept_id'];
                $ass_group = $_POST['ass_group'];

                $add_q = mysql_query("INSERT INTO ass_appraisals (bossno,params_id, period_id, factor_id, dept_id, ass_group)
                        VALUES('$bossno', '$params_id', '$period_id', '$factor_id', '$dept_id', '$ass_group' )") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Added Successfuly') </script>";
                    echo "<script> window.location='appraisals?period_id=" . $period_id . "' </script>";
                }
            }
            if (isset($_POST['update'])) {
                $params_id = $_POST['params'];
                $factor_id = $_POST['factor'];
                $id = $_POST['id'];

                $add_q = mysql_query("UPDATE ass_appraisals SET params_id = '$params_id',factor_id='$factor_id'
                        WHERE id = '$id' ") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Updated Successfuly') </script>";
                    echo "<script> window.location='appraisals?period_id=" . $period_id . "' </script>";
                }
            }
            if (isset($_POST['delete'])) {
                $id = $_POST['id'];

                $add_q = mysql_query("DELETE FROM ass_appraisals WHERE id = '$id' ") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Deleted Successfuly') </script>";
                    echo "<script> window.location='appraisals?period_id=" . $period_id . "' </script>";
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
                                            <th>Parameter</th>
                                            <th>Factor / Objective</th>
                                            <th>Group</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysql_query("SELECT emp_info.empno AS bossno, emp_info.dept AS dept_id, ass_appraisals.id AS id,
                                                        ass_params.name AS params, ass_params.id AS params_id, ass_periods.name AS periods,
                                                        ass_periods.id AS periods_id, ass_factors.name AS factors, ass_factors.id AS factors_id,
                                                        ass_appraisals.ass_group
                                                    FROM ass_appraisals
                                                    INNER JOIN emp_info ON emp_info.empno = ass_appraisals.bossno 
                                                    left JOIN ass_params ON ass_params.id = ass_appraisals.params_id 
                                                    left JOIN ass_periods ON ass_periods.id = ass_appraisals.period_id 
                                                    left JOIN ass_factors ON ass_factors.id = ass_appraisals.factor_id 
                                                    WHERE ass_appraisals.period_id = '$period_id' AND ass_params.dept='$dept'
                                                    ") or die("Error Getting Data " . mysql_error());
                                        while ($row = mysql_fetch_array($query)) {
                                            // $boss_name = $row['fname'] . " " . $row['lname'];
                                            $params = $row['params'];
                                            $params_id = $row['params_id'];
                                            $factor = $row['factors'];
                                            $ass_group = $row['ass_group'];
                                            $factor_id = $row['factors_id'];
                                            $dept_id = $row['dept_id'];
                                        ?>
                                            <tr>
                                                <td><?php echo $params; ?></td>
                                                <td><?php echo $factor; ?></td>
                                                <td><?php echo $ass_group; ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="#updateordinance<?php echo $row['id']; ?>" data-target="#updateordinance<?php echo $row['id']; ?>" data-toggle="modal" style="color:#fff;" class="btn btn-primary btn-sm">Edit</i></a>
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
                                                                    <label for="date">Parameters</label>
                                                                    <div class="input-group col-md-12">
                                                                        <select name="params" class="form-control">
                                                                            <option value="<?php echo $params_id; ?>"> <?php echo $params; ?></option>
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
                                                                            <option value="<?php echo $factor_id; ?>"> <?php echo $factor; ?></option>
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
                                                                <!-- Hidden -->
                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>" required>
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
                                            <label for="date">Parameters</label>
                                            <div class="input-group col-md-12">
                                                <select name="params" class="form-control">
                                                    <option>-- Select Parameters --</option>
                                                    <?php
                                                    $Query = mysql_query("SELECT * FROM ass_params WHERE dept='$dept' ") or die(mysql_error());
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
                                                <select id="myDropdown" name="factor" class="form-control selectpicker" data-live-search="true">
                                                    <option value="">-- Select Factor / Objective --</option>
                                                    <?php
                                                    $Query2 = mysql_query("SELECT * FROM ass_factors  WHERE dept='$dept'") or die(mysql_error());
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
                                            <label for="date">Assessment Group</label>
                                            <div class="input-group col-md-12">
                                                <select id="myDropdown" name="ass_group" class="form-control selectpicker" data-live-search="true">
                                                    <option value="">-- Select Assessment Group --</option>
                                                    <?php
                                                    $Query3 = mysql_query("SELECT * FROM ass_group  WHERE dept='$dept' GROUP BY name ") or die(mysql_error());
                                                    while ($row3 = mysql_fetch_array($Query3)) {
                                                    ?>
                                                        <option value="<?php echo $row3['name']; ?>"> <?php echo $row3['name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <input type="hidden" name="dept_id" value="<?php echo $dept_id ?>">
                                        <input type="hidden" name="bossno" value="<?php echo $bossno ?>">

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

    <script>
        $(function() {
            $('.selectpicker').selectpicker();
        });
    </script>

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