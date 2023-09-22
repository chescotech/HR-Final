<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Workflow Approvers</title>
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
        include_once '../Classes/Department.php';
        $DepartmentObject = new Department();
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    $compID = $_SESSION['company_ID'];
                    echo $_GET['name'] . ' Workflow Approver List';
                    ?>
                </h1>
            </section>


            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <a href="add-workflow-members?id=<?php echo $_GET['id']; ?>">
                            <h3> Add</h3>
                        </a>
                        <div class="col-md-4">
                        </div>
                        <div class="box">
                            <div class="box-body">
                                <table id="employee_data" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Work flow Name</th>
                                            <th>Employee Name</th>
                                            <th>Level</th>
                                            <th>Remove</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $assnId = $_GET['id'];
                                        $result = mysql_query("SELECT workflows.name,appover_groups.level,emp_info.fname,emp_info.lname,appover_groups.id FROM `appover_groups` inner JOIN workflows on workflows.id=appover_groups.work_flow_id
                                                INNER join emp_info on emp_info.empno=appover_groups.empno WHERE workflows.id='$assnId'  ");
                                        // $Departments = $DepartmentObject->getDepartmentByCompany($compID);
                                        while ($row = mysql_fetch_array($result)) {
                                            $id_ = $row['id'];
                                            $names =  $row['fname'] . ' ' . $row['lname'];

                                            echo '  
                                                        <tr>  
                                                            <td>' . $row['name'] . '</td>                                                                                                                                                                              
                                                            <td>' . $names . '</td>    
                                                            <td>' . $row['level'] . '</td>    
                                                            <td><a href=' . "delete-approver.php?id=" . $id_ . '>Remove</a></td>                                                            
                                                          
                                                        </tr>  

                                                        ';
                                        }
                                        ?>


                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
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