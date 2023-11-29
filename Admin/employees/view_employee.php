<?php
session_start();
?>
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
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php
        include_once '../Classes/Employee.php';
        include_once '../Classes/Payslips.php';
        include_once '../Classes/Asset.php';
        $AssetObject = new Asset();
        $PayslipsObject = new Payslips();
        $EmployeeObject = new Employee();
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

                            $result = mysqli_query($link, $query) or die(mysqli_error($link));
                            $count = 1;
                            $available_leave_days = 0;
                            if (mysqli_num_rows($result) > 0) {
                                // $images_dir = "../../../utils/images/students/";

                                while ($row = mysqli_fetch_assoc($result)) {
                                    if ($row["photo"] != "") {
                                        $picname = $row["photo"];
                                    } else {
                                        $picname = 'default.png';
                                    }
                                    $empno = $row['empno'];
                                    $nrc_file = $row['nrc_file'];
                                    $MyLeave = mysqli_query($link, "SELECT * FROM leave_days WHERE empno='$empno'");
                                    while ($leaverow = mysqli_fetch_array($MyLeave)) {
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
                                                                    echo $row['basic_pay']; ?></p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Gross Salary</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p>
                                                                    <?php
                                                                    $empEarnings = $PayslipsObject->getEmployeeEarningsTotal($empno);
                                                                    echo $row['basic_pay'] + $empEarnings;
                                                                    ?>
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Assets</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <?php
                                                                $assetsResult = $EmployeeObject->getEmployeeAssets($empno);

                                                                if (mysqli_num_rows($assetsResult) > 0) {
                                                                ?>
                                                                    <ul>
                                                                        <?php
                                                                        while ($assetsRow = mysqli_fetch_array($assetsResult)) {
                                                                        ?>
                                                                            <li><?php echo $assetsRow['name'] . ", " . $assetsRow['identifier']; ?><button class="btn btn-warning" style="float: right;" data-toggle="modal" data-target="#returnAssetModal">Return</button></li>
                                                                            <div class="modal fade" id="returnAssetModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog" role="document">
                                                                                    <div class="modal-content">
                                                                                        <form action="" method="post">
                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title" id="deleteAssetModalLabel">Return Asset</h5>
                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                    <span aria-hidden="true">&times;</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <p class="alert alert-danger">Are you sure you want to return this asset?</p>
                                                                                                <div class="form-group">
                                                                                                    <label htmlFor="comments">Comments</label>
                                                                                                    <textarea class="form-control" name="comments" id="comments" required></textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                            <input type="hidden" name="asset_id" value="<?= $assetsRow['id']; ?>">
                                                                                            <input type="hidden" name="company_id" value="<?= $companyId ?>">

                                                                                            <div class="modal-footer">
                                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                                <button type="submit" class="btn btn-danger" name="return">Return</button>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                <?php
                                                                } else {
                                                                    echo 'No Assets Assigned to this Employee';
                                                                    echo '<button class="btn btn-success" data-toggle="modal" data-target="#assignAssetModal" style="float: right;">Assign</button>';
                                                                    echo '
                                                                        <div class="modal fade" id="assignAssetModal" tabindex="-1" role="dialog" aria-labelledby="returnAssetModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                    <form method="post" action="">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="assignAssetModalLabel">Add Asset</h5>
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="form-group">
                                                                                                <label for="asset_select">Select Employee</label>
                                                                                                <select name="asset_select" class="form-control" id="asset_select" required>
                                                                                                    <option value="" style="text-transform: capitalize;">--- Select an Asset ---</option>';

                                                                    $allAssetsResult = $AssetObject->getAssets($companyId);
                                                                    while ($allAssetsRow = mysqli_fetch_assoc($allAssetsResult)) {
                                                                        echo '
                                                                                                                                                                    <option value="' . $allAssetsRow['id'] . '">
                                                                                                                                                                        ' . $allAssetsRow['identifier'] . ' ' . $allAssetsRow['name'] . '
                                                                                                                                                                    </option>';
                                                                    }

                                                                    echo '
                                                                                                </select>
                                                                                            </div>
                                                                                            <input type="hidden" name="company_id" value="' . $companyId . '">
                                                                                            <input type="hidden" name="asset_id" value="' . $row['id'] . '">
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                            <button type="submit" class="btn btn-primary" name="return">Save</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        ';
                                                                }
                                                                ?>
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
                                                                $res_dept = mysqli_query($link, $q_dept);
                                                                $r_dept = mysqli_fetch_assoc($res_dept);
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
                if (isset($row['nrc_file'])) {
                    $file = $row['nrc_file'];
                    echo '<a href="../../images/employees/' . $nrc_file . '">Click here to view</a>';
                } else {
                    echo '<span href="">No File Found</span>';
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
                $perf_q = mysqli_query($link, "SELECT date FROM ass_periods GROUP BY YEAR(date)
                            ") or die(mysqli_error($link));
                while ($perf_r = mysqli_fetch_array($perf_q)) {
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

<?php
if (isset($_POST['return'])) {
    $asset_id = $_POST['asset_id'];
    $comments = $_POST['comments'];
    $admin_id = $_SESSION['user_session'];
    $company_id = $_POST['company_id'];

    $result = $AssetObject->returnAsset($admin_id, $asset_id, $comments, $company_id);

    if (!$result) {
        echo '<script>alert("Something went wrong. Please try again.")</script>';
    }

    echo '<script>window.location = "view-employee.php"</script>';
}
?>

</html>