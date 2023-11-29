<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Employees On Leave Report</title>
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
        include_once '../Classes/Department.php';
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Loans.php';
        $LoanObject = new Loans();
        $companyId = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">

            <section class="content-header">
                <h1>
                    Employees On Leave Report
                </h1>
            </section>

            <section class="content col-md-10">
                <form action="#filter" method="post">
                    <div class="box-body row">
                        <div class="form-group  col-md-3">
                            <select name="emp_fillter" class="form-control">
                                <option value="all">-- All Employees --</option>
                                <?php
                                $qq1 = mysqli_query($link, "SELECT fname, lname,empno FROM emp_info");
                                while ($rr1 = mysqli_fetch_array($qq1)) {
                                ?>
                                    <option value="<?php echo $rr1['empno']; ?>"> <?php echo $rr1['fname'] . " " . $rr1['lname'] . "-" . $rr1['empno']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select name="dept_fillter" class="form-control">
                                <option value="all">-- All Departments --</option>
                                <?php
                                $qq2 = mysqli_query($link, "SELECT dep_id, department FROM department");
                                while ($rr2 = mysqli_fetch_array($qq2)) {
                                ?>
                                    <option value="<?php echo $rr2['dep_id']; ?>"> <?php echo $rr2['department']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <button class="btn btn-primary" name="filter" type="submit">Filter By Employee And/Or Department</button>
                    </div>
                </form>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body">
                                <table id="employee_data" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Employee Name </th>
                                            <th>Employee # </th>
                                            <th>Department </th>
                                            <th>Leave Status</th>
                                            <th>Leave Start On</th>
                                            <th>Leave Ends On</th>
                                            <th>Number of Days Taken</th>
                                            <th>Leave Type </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $filter_by_dept = " ";
                                        $filter_by_empno = " ";

                                        if (isset($_POST['filter'])) {
                                            $emp_fillter = $_POST['emp_fillter'];
                                            $dept_fillter = $_POST['dept_fillter'];

                                            if ($emp_fillter == "all") {
                                                $filter_by_empno = " ";
                                            } else {
                                                $filter_by_empno = " AND emp_info.empno = '$emp_fillter' ";
                                            }

                                            if ($dept_fillter == "all") {
                                                $filter_by_dept = " ";
                                            } else {
                                                $filter_by_dept = " AND emp_info.dept = '$dept_fillter' ";
                                            }
                                        }

                                        $query = mysqli_query($link, " SELECT days,fname, lname, emp_info.empno, position, dept,
                                                        leave_applications_tb.status AS leave_status,leave_start_date, leave_end_date,leave_type
                                                    FROM emp_info
                                                    LEFT JOIN leave_applications_tb ON leave_applications_tb.empno = emp_info.empno
                                                    WHERE DATE(leave_start_date) < DATE(NOW()) AND DATE(leave_end_date) > DATE(NOW())
                                                    AND leave_applications_tb.status = 'Approved'
                                                    $filter_by_dept
                                                    $filter_by_empno
                                                    ") or die(mysqli_error($link));
                                        $sum = 0;
                                        while ($row = mysqli_fetch_array($query)) {
                                            $emp_name = $row['fname'] . " " . $row['lname'];
                                            $empno = $row['empno'];
                                            $leave_status = $row['leave_status'];
                                            $leave_start_date = $row['leave_start_date'];
                                            $leave_end_date = $row['leave_end_date'];
                                            $leave_type = $row['leave_type'];
                                            $departmentId = $row['dept'];
                                            $departmentName = $LoanObject->getDepartmentById($departmentId);
                                            $empCount = $LoanObject->getEmployeeCountByDepartment($departmentId);
                                            $taken = $row['days'];
                                            $sum += $empCount;
                                            echo '  
                                                <tr>  
                                                    <td>' . $emp_name . '</td>  
                                                    <td>' . $empno . '</td>  
                                                    <td>' . $departmentName . '</td>  
                                                    <td>' . $leave_status . '</td>  
                                                    <td>' . $leave_start_date . '</td>  
                                                    <td>' . $leave_end_date . '</td>  
                                                    <td>' . $taken . '</td>  
                                                    <td>' . $leave_type . '</td>  
                                                </tr>  
                                                ';
                                        }
                                        ?>
                                </table>

                            </div>
                        </div>
                    </div>

                </div><!-- /.row -->
            </section><!-- /.content -->
        </div>
        <?php include '../footer/footer.php'; ?>
        <div class="control-sidebar-bg"></div>
    </div>

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