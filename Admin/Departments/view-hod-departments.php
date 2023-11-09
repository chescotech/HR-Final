<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Heads of Departments</title>
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
                    echo $_SESSION['name'] . ' Head Of Department List';
                    ?>

                </h1>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body">
                                <table id="employee_data" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Employee Id</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Position</th>
                                            <th>Heading Department</th>
                                            <th>Reports to</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $HODS = $DepartmentObject->getHODS($compID);
                                        while ($row = mysqli_fetch_array($HODS)) {
                                            $id_ = $row['id'];
                                            $employeeId = $row['empno'];
                                            $superiorId = $row['parent_supervisor'];
                                            $departmentID = $row['departmentId'];
                                            $HODIffo = $DepartmentObject->getHODInfo($employeeId);
                                            $HODInforow = mysqli_fetch_array($HODIffo);
                                            $HeadingQuery = $DepartmentObject->getHeadingDepartment($departmentID);
                                            $HodData = mysqli_fetch_array($HeadingQuery);

                                            echo '  
                                                        <tr>  
                                                            <td>' . $row["empno"] . '</td>  
                                                            <td>' . $HODInforow['fname'] . '</td> 
                                                            <td>' . $HODInforow['lname'] . '</td> 
                                                            <td>' . $HODInforow['position'] . '</td> 
                                                            <td>' . $HodData['department'] . '</td>
                                                            <td>' . $DepartmentObject->getSuperiorDetails($superiorId) . '</td> 
                                                            <td><a href=' . "delete_hod.php?id=" . $id_ . '>Delete</a></td>
                                                        </tr>  
                                                    ';
                                        }
                                        ?>

                                        </tfoot>
                                </table>
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