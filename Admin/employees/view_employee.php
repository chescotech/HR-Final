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

    <style>
        table,
        th,
        td {
            padding-left: 20px;
        }
    </style>
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        error_reporting(0);
        include_once '../Classes/Employee.php';
        include_once '../Classes/Payslips.php';
        $PayslipsObject = new Payslips();
        $EmployeeObject = new Employee();
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>


        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    // echo $_SESSION['name'] . ' View Employee';
                    ?>
                </h1>
            </section>

            <div style="padding-left: 70px; padding-top: 20px;">
                <button class="btn btn-sm btn-primary" onclick="javascript:printDiv('printablediv')">Print</button>
            </div>

            <section class="content" id="printablediv">
                <div class="row">
                    <div class="col-xs-17">

                        <div class="box">

                            <?php
                            $emp_id = $_GET['id'];
                            $query = "SELECT  * from emp_info where id = '$emp_id' ";

                            $result = mysql_query($query) or die(mysql_error());
                            $count = 1;
                            $available_leave_days = 0;
                            if (mysql_num_rows($result) > 0) {
                                // $images_dir = "../../../utils/images/students/";

                                while ($row = mysql_fetch_assoc($result)) {
                                    if ($row["photo"] != "") {
                                        $picname = $row["photo"];
                                    } else {
                                        $picname = 'default.png';
                                    }
                                    $empno = $row['empno'];
                                    $nrc_file = $row['nrc_file'];
                                    $MyLeave = mysql_query("SELECT * FROM leave_days WHERE empno='$empno'");
                                    while ($leaverow = mysql_fetch_array($MyLeave)) {
                                        $available_leave_days = $leaverow['available'];
                                    }
                            ?>
                                    <div class="container-fluid col-12 row" style="padding: 15px">
                                        <div class="col-2">
                                            <div class="row" style="padding: 10px;">
                                                <div class="col-lg-2" style="padding: 10px;">
                                                    <?php echo "<img src='../../images/employees/" . $picname . "' alt='" . $picname . "' width='140' height='140'> " ?>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <p>Full name</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row["fname"] . " " . $row["lname"]; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Employee Number</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $empno; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Gender</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['gender']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>ID Number(NRC or Passport)</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['NRC']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Title</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['position']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Mobile</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['phone']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Work Email</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['email']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Personal Email</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['personal_email']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Physical Address</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['address']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Available Leave Days</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $available_leave_days; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Bank</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['bank']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Branch Code</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['branch_code']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Account Number</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['account']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Payment Method</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['payment_method']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Employee Grade</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['employee_grade']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Basic Salary</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php
                                                                    echo $row['basic_pay']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Gross Salary</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['gross_pay']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Employment Type</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['employment_type']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Gratuity</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['gatuity_amount']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Department</p>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <?php
                                                                $dept = $row['dept'];
                                                                $q_dept = "SELECT department, dep_id FROM department WHERE dep_id = '$dept' ";
                                                                $res_dept = mysql_query($q_dept);
                                                                $r_dept = mysql_fetch_assoc($res_dept);
                                                                ?>
                                                                <p><?php echo $r_dept['department']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Next Of Kin (Name)</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['nok_name']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Next Of Kin (Relationship)</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['nok_relationship']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Next Of Kin (Email)</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['nok_email']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Next Of Kin (Physical Address)</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p><?php echo $row['nok_address']; ?>.</p>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo 'Invalid ID';
                            }
                            ?>

                        </div>
                    </div>
                </div><!-- /.row -->
            </section><!-- /.content -->

        </div>
    </div>
    <div>
        <div class="col-lg-6">
            <div class=" text-right">
                <p>Download / View NRC / ID or Passport</p>
            </div>
        </div>
        <div> </div>
        <div class="col-lg-5">
            <div class="">
                <?php
                if ($nrc_file != "") {
                    $file = $row['nrc_file'];
                    echo '<a href="../../images/employees/' . $nrc_file . '">Click here to view</a>';
                } else {
                    echo '<a href="">No File Found</a>';
                }
                ?>
            </div>
            <br>
        </div>

        <div class="col-lg-6">
            <div class=" text-right">
                <label>Employees Qualifications and Education Documentation </label>
            </div>
        </div>
        <div> </div>
        <div class="col-lg-5">
            <div class="">
                <a href="../Qualifications/view-qualifications.php?empid=<?php echo $emp_id; ?>">Click here to view Employees Qualifications and Education Documentation.</a>
            </div>
            <br>
        </div>

        <div class="col-lg-6">
            <div class=" text-right">
                <p>Employee Perfomance (By year)</p>
            </div>
        </div>
        <div> </div>
        <div class="col-lg-5">
            <div class="">

                <?php
                $perf_q = mysql_query("SELECT date FROM ass_periods GROUP BY YEAR(date)
                            ") or die(mysql_error());
                while ($perf_r = mysql_fetch_array($perf_q)) {
                    $date = $perf_r['date'];
                    $year = date("Y", strtotime($date));
                ?>
                    <ul>
                        <li>
                            <a href="../perfomance/appraisals.php?empno=<?php echo $empno; ?>&year=<?php echo $year; ?>" style="color:#fff;" class="btn btn-primary btn-sm"><?php echo $year ?></i></a>
                        </li>
                    </ul>
                <?php } ?>


            </div>
        </div>

        <div class="col-lg-6">
            <div class=" text-right">
                <label>Employees Timesheets </label>
            </div>
        </div>
        <div> </div>
        <div class="col-lg-5">
            <div class="">
                <a href="../Settings/timesheets.php?empid=<?php echo $empno; ?>">Click here to view timesheets.</a>
            </div>
            <br>
        </div>
        <div class="col-lg-12 col-md-12">
            <?php include '../footer/footer.php'; ?>
            <div class="control-sidebar-bg"></div>
        </div>
    </div>
    <br>

    <script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
                "<html><head><title></title></head><body>" +
                divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;


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