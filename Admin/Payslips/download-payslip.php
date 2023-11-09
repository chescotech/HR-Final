<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Download Pay Slips</title>
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
        include_once '../Classes/Payslips.php';
        include_once '../Classes/Loans.php';

        $LoanObject = new Loans();
        $DepartmentObject = new Department();
        $PaySlipsObject = new Payslips();

        include '../navigation_panel/authenticated_user_header.php';
        //$companyId = $_SESSION['username'];
        $compID = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    if (isset($_POST['empno'])) {
                        $empno = $_POST['empno'];
                        $empDetails = $PaySlipsObject->PayslipEditDetails($empno);
                        echo 'Download Pay slip for ' . $empDetails;
                    } else {
                        echo 'Search for a Pay slip to Download';
                    }
                    ?>
                </h1>
            </section>

            <section class="content">

                <div class="row">


                    <div class="col-md-4">
                        <form action="download-payslip" method="post">
                            <table cellpadding="" border="0" class="se">
                                <tr>
                                    <td>
                                        <select name="empno" class="form-control">
                                            <option>-- Select Employee --</option>
                                            <?php
                                            $departmentquery = $DepartmentObject->getAllEmployeesByCompany($compID);
                                            while ($row = mysqli_fetch_array($departmentquery)) {

                                                $fname = $row['fname'];
                                                $lname = $row['lname'];
                                                $position = $row['position'];
                                            ?>
                                                <option value="<?php echo $row['empno']; ?>"> <?php echo $fname . " " . $lname . " - " . $position ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <button type="submit" name="save" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search
                                        </button>
                                    </td>
                                </tr>
                            </table>

                        </form>
                    </div>
                    <br></br>

                    <div class="row">
                        <div class="col-xs-15">
                            <div class="box">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="employee_data" class="table table-bordered table-fixed">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>First name</th>
                                                    <th>Last name</th>
                                                    <th>Position</th>
                                                    <th>Date Period</th>
                                                    <th>Download</th>
                                                    <th>Delete Upload</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                if (isset($_POST['empno'])) {

                                                    $empno = $_POST['empno'];
                                                    $query = "SELECT * FROM payslip_uploads WHERE empno = '$empno'";

                                                    $result = mysqli_query($link, $query) or die(mysqli_error($link));

                                                    $sum = 0;
                                                    while ($row = mysqli_fetch_array($result)) {

                                                        $id_ = $row['id'];
                                                        $empId = $row['empno'];
                                                        $datePeriod = $row['date_period'];

                                                        $pdfPayslip = "../uploads/" . $row['payslip'];

                                                        $EmployeeQuery = mysqli_query($link, "SELECT * FROM emp_info WHERE empno ='$empId'");
                                                        $row2 = mysqli_fetch_array($EmployeeQuery);
                                                ?>

                                                        <?php
                                                        echo '  
                                                            <tr>  
                                                            <td>' . $empId . '</td>  
                                                            <td>' . $row2['fname'] . '</td> 
                                                            <td>' . $row2['lname'] . '</td> 
                                                            <td>' . $row2['position'] . '</td>
                                                            <td>' . $datePeriod . '</td>
                                                            <td><a  target="_blank" type="application/octet-stream" download="' . $pdfPayslip . '"  href="' . $pdfPayslip . '">Download</a></td>
                                                            <td><a href=' . "delete-payslip-upload.php?id=" . $id_ . '>Delete</a></td>                                                                
                                                            </tr>  
                                                            ';
                                                        ?>

                                                <?php
                                                    }
                                                }
                                                ?>

                                        </table>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
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