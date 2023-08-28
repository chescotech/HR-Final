<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Delete Pay Slips</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.print.css" media="print">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script>
        $(function() {
            $("#datepicker").datepicker();
            $(document).ready(function() {
                // numeric validation.. 
                $("#numeric").keydown(function(event) {
                    if (event.keyCode == 46 || event.keyCode == 8) {
                        // let it happen, don't do anything
                    } else {
                        if (event.keyCode < 48 || event.keyCode > 57) {
                            event.preventDefault();
                        }
                    }
                });

                $("#numeric2").keydown(function(event) {
                    if (event.keyCode == 46 || event.keyCode == 8) {
                        // let it happen, don't do anything
                    } else {
                        if (event.keyCode < 48 || event.keyCode > 57) {
                            event.preventDefault();
                        }
                    }
                });

                $("#numeric3").keydown(function(event) {
                    if (event.keyCode == 46 || event.keyCode == 8) {
                        // let it happen, don't do anything
                    } else {
                        if (event.keyCode < 48 || event.keyCode > 57) {
                            event.preventDefault();
                        }
                    }
                });

                $("#numeric4").keydown(function(event) {
                    if (event.keyCode == 46 || event.keyCode == 8) {
                        // let it happen, don't do anything
                    } else {
                        if (event.keyCode < 48 || event.keyCode > 57) {
                            event.preventDefault();
                        }
                    }
                });


            });

        });
    </script>
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/Department.php';
        include_once '../Classes/Payslips.php';
        include_once '../Classes/Loans.php';
        include_once '../Classes/Tax.php';
        $LoanObject = new Loans();
        $DepartmentObject = new Department();
        $PaySlipsObject = new Payslips();
        $TaxObject = new Tax();

        include '../navigation_panel/authenticated_user_header.php';
        //$companyId = $_SESSION['username'];
        $compId = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        $time = $_GET['time'];

        if (isset($_POST['save'])) {
            $message = "";
            $empno = $_POST['empno'];
            $insurance = $_POST['insurance'];
            $advances = $_POST['advances'];
            $commision = $_POST['commision'];
            $allowance = $_POST['allowance'];
            $overtime = $_POST['overtime'];
            $overtime_rate_hour = $_POST['overtime_rate_hour'];
            $days_worked = $_POST['days_worked'];

            // $staffer = $_POST['staffer'];
            $no_of_emps = count($empno);
            // return var_dump($empno);
            // $id_ = $_POST['id_'];
            if ($no_of_emps > 0) {
                // while ($no_of_emps > 1) {

                array_map(function ($empno1, $days_worked1, $overtime_rate_hour1, $overtime1, $allowance1, $advances1, $insurance1, $commision1) {
                    // return var_dump($staffer1);
                    global $DepartmentObject, $TaxObject, $compId, $PaySlipsObject, $LoanObject, $time;

                    $Grosspay = $DepartmentObject->getBasicPay($empno1) + $DepartmentObject->getAllowances($empno1);
                    // Hide
                    //echo '$Grosspay'.$Grosspay;
                    $totalpay = ($Grosspay / 26) * $days_worked1;
                    $pay = $totalpay;

                    $gross = ($pay) + ($overtime_rate_hour1 * $overtime1) + $allowance1 + $commision1;
                    $napsa = $gross * 0.05;
                    if ($napsa >= $TaxObject->getNapsaCeiling($compId))
                        $napsa = $TaxObject->getNapsaCeiling($compId);
                    $napsa_calc = "";

                    if ($napsa >= 255)
                        $napsa_calc = 255;

                    $band1_top = $TaxObject->getTopBand1($compId);
                    $band2_top = $TaxObject->getTopBand2($compId);
                    $band3_top = $TaxObject->getTopBand3($compId);

                    $band1_rate = $TaxObject->getBandRate1($compId) / 100;
                    $band2_rate = $TaxObject->getBandRate2($compId) / 100;
                    $band3_rate = $TaxObject->getBandRate3($compId) / 100;
                    $band4_rate = $TaxObject->getBandRate4($compId) / 100;

                    $starting_income = $income = $gross - $napsa_calc;

                    $band1 = $band2 = $band3 = $band4 = 0;
                    if ($income > $band3_top) {
                        $band4 = ($income - $band3_top) * $band4_rate;
                        $income = $band3_top;
                    }
                    if ($income > $band2_top) {
                        $band3 = ($income - $band2_top) * $band3_rate;
                        $income = $band2_top;
                    }
                    if ($income > $band1_top) {
                        $band2 = ($income - $band1_top) * $band2_rate;
                        $income = $band1_top;
                    }

                    $band1 = $income * $band1_rate;
                    $taxable = $gross - $income;
                    $total_tax_paid = $band1 + $band2 + $band3 + $band4;

                    $totdeduct = $total_tax_paid + $advances1 + $insurance1 + $napsa;
                    $netpay = $gross - $totdeduct;
                    // hide
                    if ($PaySlipsObject->checkIfRecordExsists($empno1, $time) != "true") {

                        // if (isset($staffer1)) {
                        // return $pay;
                        $PaySlipsObject->addEmpPayslipInfo($empno1, $pay, $days_worked1, $overtime_rate_hour1, $overtime1, $allowance1, $advances1, $insurance1, $time, $commision1, $compId);
                        // }
                        // $PaySlipsObject->addEmpPayslipInfo($empno, $pay, $days_worked, $overtime_rate_hour, $overtime, $allowance, $advances, $insurance, $time, $commision, $compId);

                        $checkQuery = "SELECT * FROM tax where empno='$empno1'";
                        $checkIfEmployeeExsist = mysql_query($checkQuery) or die("invalid query" . mysql_error());

                        if (mysql_num_rows($checkIfEmployeeExsist) == 0) {
                            $PaySlipsObject->addTax($taxable, $total_tax_paid, $empno1, $compId, $time);
                        } else {
                            $PaySlipsObject->updateTax($taxable, $total_tax_paid, $empno1);
                        }

                        $checkForLeave = "SELECT * FROM leave_days where empno='$empno1'";
                        $checkIfEmployeeLeaveExsist = mysql_query($checkForLeave) or die("invalid query" . mysql_error());

                        if (mysql_num_rows($checkIfEmployeeLeaveExsist) == 0) {
                            $PaySlipsObject->addLeave($empno1);
                        } else {
                            // $empno = $_POST['empno'];
                            $PaySlipsObject->updateLeave($empno1, $compId);
                        }

                        if ($LoanObject->checkIfEmpHasLoan($empno1) == 1 && $LoanObject->getEmpLoanStatus($empno1) == "Pending") {
                            $LoanObject->updateLoanInfo($empno1);
                        }

                        // echo "<script> alert('Record added successfully" . $staffer1 . $empno1 .  $pay . "') </script>";
                    } else {
                        // echo "<script> alert('failed, record already exsists." . $staffer1 . $empno1 . "') </script>";
                    }
                }, $empno, $days_worked, $overtime_rate_hour, $overtime, $allowance, $advances, $insurance, $commision);

                // }
                echo ' <center> <h3 style="color:green"> Record added successfully. </h3> </center>';
            } else {
                echo ' <center> <h3 style="color:red"> Error! No Employees Selected! </h3> </center>';
            }
        }

        if (isset($_POST['bulk_del'])) {
            $empnos = $_POST['staffer'];
            // return var_dump($month);
            array_map(function ($empno) {
                global $time;
                mysql_query("DELETE FROM employee where empno='$empno' AND DATE(time) ='$time' ") or die(mysql_error());
            }, $empnos);

            echo "<script> alert('Deleted') </script>";
            echo "<script> window.location='view-payslips.php?deleted' </script>";
        }
        ?>

        <div class="content-wrapper">

            <section class="content">
                <div class="row">
                    <div class="col-md-1">
                        <a href="pay-slip-entry" class="btn btn-primary btn-block margin-bottom">Back</a>
                    </div>
                    <div class="col-md-10">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <?php

                                $payday = date("M d, Y", strtotime($time));
                                echo '<center>
                                                <h3 style="color: black" class="box-title"><b>Delete Payslips For ' . $payday . ' </b></h3>
                                            </center>';
                                ?>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">

                                    <form action="#" method="post">
                                        <div class="table-responsive">
                                            <table id="employeedata" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td> All <br /> <input type="checkbox" onClick="toggle(this)" /> </td>
                                                        <td>Names</td>
                                                        <td>Employee Number</td>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $compID = $_SESSION['company_ID'];
                                                $query = "SELECT * FROM emp_info WHERE company_id ='$compID' ";
                                                $result = mysql_query($query);
                                                while ($row = mysql_fetch_array($result)) {
                                                    $deptId = $row['dept'];
                                                    $id_ = $row['id'];
                                                    $empno = $row["empno"];
                                                ?>
                                                    <tr>
                                                        <td> <input name="staffer[]" type="checkbox" value="<?php echo $empno; ?>" /> </td>
                                                        <td> <?php echo $row["fname"] . " " . $row["lname"]; ?> </td>
                                                        <td> <?php echo $empno; ?> </td>
                                                    </tr>

                                                <?php
                                                }
                                                ?>

                                            </table>
                                        </div>

                                        <br>
                                        <button type="submit" name="bulk_del" class="btn btn-default -btn-sm"> Delete</button>
                                    </form>

                                </div>
                            </div>
                        </div>


                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <?php include '../footer/footer.php'; ?>

        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
    <script>
        function toggle(source) {
            checkboxes = document.getElementsByName('staffer[]');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>

    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- Slimscroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- iCheck -->
    <script src="../plugins/iCheck/icheck.min.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
</body>

</html>