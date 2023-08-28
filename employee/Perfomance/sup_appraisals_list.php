<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Supervisor Perfomance Period</title>
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
                    $empno = $_SESSION['empno'];
                    $e1 = mysql_query("SELECT dept FROM emp_info WHERE empno = '$empno' ") or die(mysql_error());
                    $er = mysql_fetch_array($e1);
                    $dept_id = $er['dept'];
                    $compID = $_SESSION['company_ID'];
                    // $dept_id = $_SESSION['dept_id'];
                    // return var_dump($dept_id);
                    echo $_SESSION['company_name'] . ' Perfomance Appraisal List';
                    ?>
                </h1>
            </section>

            <section class="content container">
                <div class="row center">
                    <div class="col-xs-9 col-md-7 col-md-offset-1">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Select Employee</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Employee Number</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $app_id = $_GET['period'];
                                        $query = mysql_query("SELECT emp_info.fname AS fname, emp_info.lname AS lname,
                                            total_score,emp_info.empno AS empno,boss_score
                                            ,
                                                ass_appraisals.id AS ass_app_id,ass_emp_appraisals.ass_app_id AS uid FROM ass_emp_appraisals
                                                INNER JOIN ass_appraisals ON ass_appraisals.id = ass_emp_appraisals.ass_app_id
                                                INNER JOIN emp_info ON emp_info.empno = ass_emp_appraisals.empno
                                                WHERE ass_appraisals.dept_id = '$dept_id' 
                                                GROUP BY empno
                                                    ") or die(mysql_error());
                                        while ($row = mysql_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
                                                <td><?php echo $row['empno']; ?></td>
                                                <td><?php
                                                    if ($row['total_score'] == "" || $row['boss_score'] == "") {
                                                        echo '<span class="label label-warning">Pending Completion</span>';
                                                    } else {
                                                        echo '<span class="label label-success">Completed</span>';
                                                    }
                                                    ?></td>
                                                <td>
                                                    <a href="view_sup_appraisal.php?empno=<?php echo $row['empno']; ?>&app_id=<?php echo $app_id; ?>" style="color:#fff;" class="btn btn-primary btn-sm">Select</i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->

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