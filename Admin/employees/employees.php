<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employees</title>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        error_reporting(0);
        include_once '../Classes/Employee.php';
        $EmployeeObject = new Employee();
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    echo $_SESSION['name'] . ' Employee List';
                    ?>
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-17">

                        <div class="box">

                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="employee_data" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <td>Image</td>
                                                <td>Employee No</td>

                                                <td>Names</td>
                                                <td>Department</td>
                                                <td>Position</td>
                                                <td>Work Email</td>
                                                <td>Mobile</td>
                                                <td>Next Of Kin Mobile</td>
                                                <td>Suspend / Exit</td>
                                                <td>Actions</td>
                                            </tr>
                                        </thead>
                                        <?php
                                        $compID = $_SESSION['company_ID'];
                                        $query = "SELECT * FROM emp_info WHERE company_id ='$compID' ";
                                        $result = mysqli_query($link, $query);
                                        while ($row = mysqli_fetch_array($result)) {
                                            $deptId = $row['dept'];
                                            $id_ = $row['id'];
                                            $dept = $EmployeeObject->getDepartmentDetails($deptId);
                                            $status = $row['status'];
                                            $probationDeadline = $row['probation_deadline'];
                                            $today = date("Y-m-d");
                                            $today_time = strtotime($today);
                                            $expire_time = strtotime($probationDeadline);
                                            $exitStatus = "";
                                            $suspendStatus = "";
                                            if ($status == "exited") {
                                                $exitStatus = "";
                                            } else {
                                                $exitStatus = " / Exit";
                                            }

                                            if ($status == "suspended") {
                                                $suspendStatus = '<a href=' . "activate-employee.php?id=" . $id_ . '>Activate</a>';
                                            } else if ($status != 'exited') {
                                                $suspendStatus = '<a href=' . "suspend-employee.php?id=" . $id_ . ' onclick="return confirmF()">Suspend</a>';
                                        ?>
                                        <?php }

                                            if ($status == "active") {
                                                $status = '<span class="label label-success arrowed-in arrowed-in-right">' . $status . '</span>';
                                            } elseif ($today_time < $expire_time) {
                                                $status = '<span class="label label-warning">On Probation</span>';
                                            } else {
                                                $status = '<span class="label label-warning">' . $status . '</span>';
                                            }

                                            // return var_dump($row['photo']);

                                            if ($row["photo"] != "") {
                                                $profile_img = $row["photo"];
                                            } else {
                                                $profile_img = 'default.png';
                                            }

                                            $empNo = $row["empno"];
                                            echo '  
                                                    <tr>  
                                                    <td> <img src="../../images/employees/' . $profile_img . '" alt="image" height="100" width="100" /> </td>  
                                                    <td>' . $row["empno"] . '</td>  
                                                      
                                                    <td>' . $row["fname"] . " " . $row["lname"] . '</td>                                                                      
                                                    <td>' . $dept . '</td> 
                                                    <td>' . $row["position"] . '</td>
                                                    <td>' . $row["email"] . '</td>
                                                    <td>' . $row["phone"] . '</td>
                                                    <td>' . $row["nok_phone"] . '</td>
                                                    <td>' . $suspendStatus . '<a href=' . "exit-details.php?id=" . $id_ . '&empno=' . "$empNo" . '>' . $exitStatus . '</a></td>
                                                    <td><a href=' . "edit-employee.php?id=" . $id_ . '>Edit</a>
                                                    | <a href=' . "delete-employee.php?id=" . $id_ . '>Delete</a>
                                                    | <a href=' . "view_employee.php?id=" . $id_ . '>View</a></td>
                                                    </tr>  

                                                    ';
                                        }
                                        ?>

                                    </table>
                                </div>
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div>
        <?php include '../footer/footer.php'; ?>
        <div class="control-sidebar-bg"></div>
    </div>

    <script>
        function confirmF() {
            confirm("Are You Sure?");
        }
    </script>

    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <script src="../dist/js/app.min.js"></script>
    <script src="../dist/js/demo.js"></script>
    <script>
        $(document).ready(function() {
            $('#employee_data').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>

</html>