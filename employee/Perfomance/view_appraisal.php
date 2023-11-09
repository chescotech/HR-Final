<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Perfomance Appraisal</title>
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

    <style>
        table,
        th,
        td {
            border: 1px solid;
        }
    </style>
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">

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

                $add_q = mysqli_query($link, "INSERT INTO ass_appraisals (empno,params_id, period_id, factor_id, own_score, boss_score, total_score, comment)
                        VALUES('$empno', '$params_id', '$period_id', '$factor_id', '$own_score', '$boss_score', '$total_score', '$comment')") or die(mysqli_error($link));

                if ($add_q) {
                    echo "<script> alert('Added Successfuly') </script>";
                    echo "<script> window.location='appraisals' </script>";
                }
            }
            if (isset($_POST['update'])) {
                $name = $_POST['name'];
                $target = $_POST['target'];
                $id = $_POST['id'];

                $add_q = mysqli_query($link, "UPDATE ass_appraisals SET name = '$name',target='$target'
                        WHERE id = '$id' ") or die(mysqli_error($link));

                if ($add_q) {
                    echo "<script> alert('Updated Successfuly') </script>";
                    echo "<script> window.location='appraisals' </script>";
                }
            }
            if (isset($_POST['delete'])) {
                $id = $_POST['id'];

                $add_q = mysqli_query($link, "DELETE FROM ass_appraisals WHERE id = '$id' ") or die(mysqli_error($link));

                if ($add_q) {
                    echo "<script> alert('Deleted Successfuly') </script>";
                    echo "<script> window.location='appraisals' </script>";
                }
            }

            $app_id = $_GET['app_id'];
            ?>

            <section class="content container">

                <br>
                <hr>

                <div class="row center">
                    <div class="col-xs-10 col-md-12 ">
                        <div class="box box-primary">
                            <div class="box-header">
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <?php
                                    $query1 = mysqli_query($link, "SELECT emp_info.fname AS fname , emp_info.lname AS lname, emp_info.position AS position, emp_info.empno AS empno,
                                                    department.department, ass_periods.name AS periods, ass_appraisals.date AS app_date,
                                                    ass_periods.id AS periods_id
                                                FROM ass_appraisals
                                                LEFT JOIN emp_info ON emp_info.empno = ass_appraisals.empno 
                                                LEFT JOIN department ON department.dep_id = emp_info.dept 
                                                LEFT JOIN ass_periods ON ass_periods.id = ass_appraisals.period_id 
                                                WHERE ass_appraisals.id = '$app_id'
                                                ") or die("Error Getting Data " . mysqli_error($link));
                                    while ($row1 = mysqli_fetch_array($query1)) {
                                        $emp_name = $row1['fname'] . " " . $row1['lname'];
                                        $period = $row1['periods'];
                                        $app_date = $row1['app_date'];
                                        $department = $row1['department'];
                                        $empno = $row1['empno'];
                                        $position = $row1['position'];
                                    }
                                    ?>
                                    <tr>
                                        <td>Employee Name: <b> <?php echo $emp_name ?></b> </td>
                                        <td>Job Title: <b> <?php echo $position ?></b> </td>
                                        <td>Employee#: <b> <?php echo $empno ?></b> </td>
                                        <td>Department: <b> <?php echo $department ?></b> </td>
                                    </tr>
                                    <tr>
                                        <td>Immediate Supervisor: <b> <?php echo " " ?> </b> </td>
                                        <td>Head of Department: <b> <?php echo " " ?> </b> </td>
                                        <td>Date: <b> <?php echo $app_date ?></b> </td>
                                        <td>Appraisal Period: <b> <?php echo $period ?></b> </td>
                                    </tr>
                                </table>
                            </div><!-- /.box-body -->

                        </div><!-- /.col -->
                    </div><!-- /.row -->
            </section>

            <section class="content container">
                <br>
                <br>
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
                                            <th>Parameter </th>
                                            <th>Weight </th>
                                            <th>Objective </th>
                                            <th>Target Score</th>
                                            <th>Own Score</th>
                                            <th>Supervisor Score</th>
                                            <th>Agreed Score</th>
                                            <th>Appraisee's Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($link, "SELECT own_score, boss_score, total_score, comment, ass_appraisals.id,
                                                        ass_params.name AS params, ass_params.id AS params_id, ass_params.weight AS weight,
                                                        ass_factors.name AS objective, ass_factors.target AS target,
                                                        ass_periods.name, emp_info.empno
                                                    FROM ass_appraisals
                                                    INNER JOIN emp_info ON emp_info.empno = ass_appraisals.empno 
                                                    LEFT JOIN ass_params ON ass_params.id = ass_appraisals.params_id 
                                                    LEFT JOIN ass_factors ON ass_factors.id = ass_appraisals.factor_id
                                                    LEFT JOIN ass_periods ON ass_periods.id = ass_appraisals.period_id 
                                                    WHERE ass_periods.name = '$period' AND emp_info.empno = '$empno'
                                                    ") or die("Error Getting Data " . mysqli_error($link));
                                        while ($row = mysqli_fetch_array($query)) {
                                            $params = $row['params'];
                                            $weight = $row['weight'];
                                            $objective = $row['objective'];
                                            $target = $row['target'];
                                            $own_score = $row['own_score'];
                                            $boss_score = $row['boss_score'];
                                            $total_score = $row['total_score'];
                                            $comment = $row['comment'];
                                        ?>
                                            <tr>
                                                <td><?php echo $params; ?></td>
                                                <td><?php echo $weight; ?></td>
                                                <td><?php echo $objective; ?></td>
                                                <td><?php echo $target; ?></td>
                                                <td><?php echo $own_score; ?></td>
                                                <td><?php echo $boss_score; ?></td>
                                                <td><?php echo $total_score; ?></td>
                                                <td><?php echo $comment; ?></td>
                                            </tr>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->

                        </div><!-- /.col -->
                    </div><!-- /.row -->
            </section>

            <section class="content container">
                <br>
                <br>
                <div class="row center">
                    <div class="col-xs-6 col-md-6 ">
                        <div class="box box-primary">
                            <div class="box-header">

                            </div>
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Rating </th>
                                            <th>Ranking </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo "80 - 100" ?></td>
                                            <td><?php echo "Exceptional"; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo "70 - 79" ?></td>
                                            <td><?php echo "Effective"; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo "60 - 69" ?></td>
                                            <td><?php echo "Good"; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo "50 - 59" ?></td>
                                            <td><?php echo "Fair"; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo "0 - 49" ?></td>
                                            <td><?php echo "Poor"; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="col-xs-6 col-md-6 ">
                        <div class="box box-primary">
                            <div class="box-header">
                                <!-- <h3 class="box-title">General Expenses</h3> -->
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Rating </th>
                                            <th>Ranking </th>
                                            <th>Objective </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($link, "SELECT own_score, boss_score, total_score, comment, ass_appraisals.id,
                                                        ass_params.name AS params, ass_params.id AS params_id, ass_params.weight AS weight,
                                                        ass_factors.name AS objective, ass_factors.target AS target,
                                                        ass_periods.name, emp_info.empno
                                                    FROM ass_appraisals
                                                    INNER JOIN emp_info ON emp_info.empno = ass_appraisals.empno 
                                                    LEFT JOIN ass_params ON ass_params.id = ass_appraisals.params_id 
                                                    LEFT JOIN ass_factors ON ass_factors.id = ass_appraisals.factor_id
                                                    LEFT JOIN ass_periods ON ass_periods.id = ass_appraisals.period_id 
                                                    WHERE ass_periods.name = '$period' AND emp_info.empno = '$empno'
                                                    ") or die("Error Getting Data " . mysqli_error($link));
                                        while ($row = mysqli_fetch_array($query)) {
                                            $params = $row['params'];
                                            $weight = $row['weight'];
                                            $objective = $row['objective'];
                                            $target = $row['target'];
                                            $own_score = $row['own_score'];
                                            $boss_score = $row['boss_score'];
                                            $total_score = $row['total_score'];
                                            $comment = $row['comment'];
                                        ?>
                                            <tr>
                                                <td><?php echo $params; ?></td>
                                                <td><?php echo $weight; ?></td>
                                                <td><?php echo $objective; ?></td>
                                                <td><?php echo $target; ?></td>
                                                <td><?php echo $own_score; ?></td>
                                                <td><?php echo $boss_score; ?></td>
                                                <td><?php echo $total_score; ?></td>
                                                <td><?php echo $comment; ?></td>
                                            </tr>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->

                        </div><!-- /.col -->
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