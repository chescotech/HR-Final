<?php 
error_reporting(0);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
    <title>Payslip</title>
</head>
<style type="text/css">
    body {
        background-color: #999;
    }

    .wrapper {
        background-color: #FFF;
        width: 900px;
        height: 600px;
        margin: auto;
    }

    .name {
        background-color: #fff;
        height: 40px;
        width: 900px;
        float: left;
    }

    .name_ {
        background-color: #fff;
        height: 90px;
        width: 450px;
        float: left;
    }

    .payslip {
        background-color: #fff;
        height: 90px;
        width: 450px;
        float: left;
    }

    .payslip2 {
        background-color: #fff;
        width: 900px;
        float: left;
    }

    .payslip2_ {
        padding-left: 25px;
    }

    td {
        font-size: 10px;
    }

    .box {
        font-family: Tahoma, Geneva, sans-serif;
    }

    .box1 {
        font-weight: bold;
        opacity: 0;
        font-size: 1px;
    }
</style>

<body onload="window.print()">
    <div class="wrapper" title="Right click to print payslip">
        <?php
        session_start();
        include('../../include/dbconnection.php');
        include_once '../Classes/Tax.php';
        include_once '../Classes/Company.php';
        include_once '../Classes/Department.php';
        include_once '../Classes/Loans.php';
        include_once '../Classes/Payslips.php';
        $LoanObject = new Loans();
        $TaxObject = new Tax();
        $PayslipObject = new Payslips();
        $companyObject = new Company();
        $companyType = $_SESSION['name'];
        $DepartmentObject = new Department();
        $compId = $_SESSION['company_ID'];
        $emp_id = $_GET['id'];
        ?>
        <div class="body"><img src="<?php echo $companyObject->getCompanyLogo2($compId); ?>" width="100px" height="100px"></div>
        <div class="body">
            <div class="name"></div>
            <div class="name_">
                <?php
                if (isset($_POST["field"])) {
                    $key = strtoupper($_POST["key"]);
                    $field = $_POST["field"];
                    if (!empty($_POST["key"]))
                        if ($field == "id")
                            if (is_numeric($key))
                                $query = "SELECT * FROM employee WHERE id = $key";
                            else
                                exit('<h6><br/><table border="0"><td bgcolor="red"><center>Please enter a numeric value!</center></td></table></h6>');
                        else
                            $query = "SELECT * FROM employee WHERE UPPER($field) like '$key%'";
                    else
                        $query = "SELECT * FROM employee";
                } else
                    $query = "SELECT * FROM employee";

                $empno = $_GET['empno'];
                $PayslipQuery = "SELECT * FROM employee WHERE id = '$emp_id' AND empno ='$empno' ";
                $result = mysql_query($PayslipQuery, $link) or die(mysql_error());
                while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                }

                $msg = "";

                if (isset($_POST['insert'])) {
                    if ($_POST['insert'])
                        $insert = 1;
                    else
                        $insert = 0;

                    $empno = $_POST['empno'];

                    $dept = $_POST['dept'];
                    $lname = $_POST['lname'];
                    $fname = $_POST['fname'];
                    $init = $_POST['init'];
                    $position = $_POST['position'];

                    if ($insert) {
                        $query = "INSERT INTO employee VALUES ('$empno','$lname','$fname','$init','$position','$pay','$dayswork','$otrate','$othrs','$allow','$advances','$insurance')";
                        $msg = "New record saved!";
                    } else {
                        $query = "UPDATE employee SET empno='$empno',lname='$lname',fname='$fname',init= '$init',position='$position' WHERE id = '$emp_id'";
                        $msg = "Record updated!";
                    }
                    include 'include/dbconnection.php';
                    $result = mysql_query($query, $link) or die("invalid query" . mysql_error());
                }

                $insert = 1;

                $empno = "";
                $dept = "";
                $lname = "";
                $fname = "";
                $init = "";
                $position = "";

                $insert = 0;
                $empno = $_GET['empno'];
                $query = "SELECT * FROM emp_info WHERE empno= '$empno'";
                $result = mysql_query($query, $link) or die(mysql_error());
                if (!mysql_num_rows($result)) {
                    $empno = 0;
                    $msg = "No record found!";
                } else {
                    $row = mysql_fetch_array($result, MYSQL_ASSOC);
                    //$id = $row['id'];
                    $empno = $row['empno'];
                    $dpId = $row['dept'];
                    $checkDepartmentQuery = mysql_query("SELECT * FROM department WHERE dep_id='$dpId' ");
                    $departmentName = mysql_fetch_array($checkDepartmentQuery);
                    $dept = $departmentName['department'];
                    $lname = $row['lname'];
                    $fname = $row['fname'];
                    $dateJoined = $row['date_joined'];
                    $init = $row['init'];
                    $paymentsMethod = $row['payment_method'];
                }

                $position = $row['position'];

                $query8 = "SELECT * FROM loan where empno = '$empno' ";
                $result = mysql_query($query8) or die($query . "<br/><br/>" . mysql_error());
                $row = mysql_fetch_array($result, MYSQL_ASSOC);
                $balance = $row['loan_amt'];
                $interest = $row['interest'];
                $months = $row['duration'];
                $deduct = $row['monthly_deduct'];

                $query = "SELECT * FROM tax where empno = '$empno' ";

                $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());

                $row = mysql_fetch_array($result, MYSQL_ASSOC);
                $taxable_todate = $row['taxable_to_date'];
                $paid_todate = $row['tax_paid_to_date'];
                $social = $row['social'];

                $query2 = "SELECT * FROM leave_days where empno = '$empno'";
                $result = mysql_query($query2) or die($query . "<br/><br/>" . mysql_error());
                $row = mysql_fetch_array($result, MYSQL_ASSOC);
                if (mysql_num_rows($result) <= 0) {
                    $leave_days = "No leave Days available";
                } else {
                    $leave_days = $row['available'];
                }
                ?>
                <style type="text/css">
                    .top1 {
                        margin-left: 25px;
                    }
                </style>
                <form method="post" action="entry.php" onSubmit="return proceed()">
                    <table border="0" align="left" width="300" class="top1">
                        <tr>
                            <td class="box" width="">Employee Number:</td>
                            <td>: <?php echo $empno; ?></td>
                        </tr>
                        <tr>
                            <td class="box">Department:</td>
                            <td>: <?php echo $dept; ?></td>
                        </tr>
                        <tr>
                        <tr>
                            <td class="box">Position:</td>
                            <td>: <?php echo $position; ?></td>
                        </tr>
                        <tr>
                            <td class="box" width="">Payment Method:</td>
                            <td>: <?php echo $paymentsMethod; ?></td>
                        </tr>
                        <tr>
                            <td class="box" width="">Date Issued:</td>
                            <td>:
                                <?php
                                $query = mysql_query("SELECT * FROM employee WHERE empno='$empno'");
                                $row = mysql_fetch_array($query);
                                // return var_dump($row);
                                $dateIssued = $row['time'];
                                $dayswork_ = 26;
                                $mydate = strtoTime($dateIssued);
                                $printdate = date('F d, Y', $mydate);
                                echo $printdate;
                                ?>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="insert" value="<?php echo $insert; ?>" />
            </div>
            <div class="payslip">
                <table border="0" align="left" width="300" cellspacing="0">
                    <tr>
                        <td class="box">Lastname:</td>
                        <td>:<?php echo $lname; ?></td>
                    </tr>
                    <tr>
                        <td class="box">Firstname:</td>
                        <td>:<?php echo $fname; ?></td>
                    </tr>
                    <tr>
                        <td class="box">Initial:</td>
                        <td>:<?php echo $init; ?></td>
                    </tr>

                    <tr>
                        <td class="box">Leave Days Accrued:</td>
                        <td>:<?php echo $leave_days; ?></td>
                    </tr>
                    <tr>
                        <td class="box">Date Joined:</td>
                        <td>:<?php echo $dateJoined; ?></td>
                    </tr>
                    <tr>
                        <td class="box">No Days Worked:</td>
                        <td>:<?php echo $dayswork_; ?></td>
                    </tr>
                </table>
            </div>
            </form>
            <br>
            <div class="payslip2">
                <div class="payslip2_">
                    <?php
                    $insert = 1;
                    $id = 0;
                    $empno = 0;
                    $pay = 0;
                    $dayswork = 0;
                    $otrate = 0;
                    $othrs = 0;
                    $allow = 0;
                    $advances = 0;
                    $insurance = 0;
                    $comission = 0;

                    if (isset($_GET['id'])) {
                        $insert = 0;
                        $id = $_GET['id'];
                        $query = "SELECT * FROM emp_info WHERE id=$id";

                        $result = mysql_query($query, $link) or die(mysql_error());
                        if (!mysql_num_rows($result)) {
                            $id = 0;
                            $msg = "No record found!";
                        } else {
                            $row = mysql_fetch_array($result, MYSQL_ASSOC);
                            $empno = $row['empno'];

                            // get the total NHIMA paid to date..
                            $query_ = "SELECT SUM(health_insurance) AS totalNhima FROM `employee` where  empno='$empno' ";
                            $result_ = mysql_query($query_, $link) or die(mysql_error());
                            $row_ = mysql_fetch_array($result_, MYSQL_ASSOC);
                            $totalNhima = $row_['totalNhima'];

                            // $dayswork = 16;
                            $otrate = $row['otrate'];
                            $othrs = $row['othrs'];
                            // $allow = $row['allow'];
                            // $advances = $row['advances'];
                            // $insurance = $row['insurance'];
                            // $nhema = $row['health_insurance'];
                            // $pension = $row['pension'];
                            // $comission = $row['comission'];

                            $overtime = $otrate * $othrs;

                            $pay = $row['pay'] + $row['allow'] + $overtime + $comission;
                        }
                    }
                    ?>
                    <form method="post" action="entry.php" onSubmit="return proceed()">
                        <table width="" border="0">
                            <?php
                            $msg = "";

                            if (isset($_POST['insert'])) {

                                if ($_POST['insert'])
                                    $insert = 1;
                                else
                                    $insert = 0;

                                $empno = $_POST['empno'];

                                $pay = $_POST['pay'];
                                $dayswork = $_POST['dayswork'];
                                $otrate = $_POST['otrate'];
                                $othrs = $_POST['othrs'];
                                $allow = $_POST['allow'];
                                $advances = $_POST['advances'];
                                $insurance = $_POST['insurance'];
                                $comission = $_POST['comission'];
                                $nhema = $row['health_insurance'];
                                if ($insert) {

                                    $query = "INSERT INTO employee VALUES ($id,'$empno',',$pay,$dayswork,$otrate,$othrs,$allow,$advances,$insurance,$comission)";
                                    $query2 = "UPDATE tax SET taxable_to_date = taxable_to_date + $taxable , tax_paid_to_date = tax_paid_to_date + $total_tax_paid WHERE empno = '$empno'";
                                    $msg = "<center><table border='1' width='431'  ><td bgcolor='#009933'><center>New record saved!</center></label></table></center>";
                                } else {
                                    $query = "UPDATE employee SET id=$id,empno=$empno,',pay=$pay,dayswork=$dayswork,otrate=$otrate,othrs=$othrs,allow=$allow,advances=$advances,insurance=$insurance,comission=$comission WHERE empno = $empno";

                                    $msg = "<center><table border='1' width='431'  ><td bgcolor='#009933'><center>Record updated!</center></table></center>";
                                }

                                echo '<center>';
                                $result = mysql_query($query, $link) or die("invalid query" . mysql_error());
                                $result2 = mysql_query($query2, $link) or die("invalid query" . mysql_error());
                                echo '</center>';
                            }
                            ?>
                            <style type="">
                                .align{
                                            word-spacing:285px;}.align1{
                                            word-spacing:300px;}.align3{
                                            float:right;}.net{
                                            margin-right:31px;}
                                        </style>
                            <br>
                            <br>
                            <?php
                            // Function to clean column names
                            function cleanColumnName($columnName)
                            {
                                // Replace underscores with spaces, then remove other special characters
                                $cleanedName = preg_replace('/_/', ' ', $columnName);
                                $cleanedName = preg_replace('/[^A-Za-z0-9\s]/', '', $cleanedName);
                                return $cleanedName;
                            }

                            $query = "SELECT * FROM employee_earnings WHERE employee_id = $id";
                            $result = mysql_query($query);

                            if (mysql_num_rows($result) > 0) {
                                $row = mysql_fetch_assoc($result);
                                $columns = array();

                                foreach ($row as $columnName => $value) {
                                    if (!empty($value)) {
                                        $columns[] = cleanColumnName($columnName);
                                    }
                                }

                                // Now $columns will contain cleaned column names with non-empty values for the specified empno
                            } else {
                                echo "No data found for the specified empno.";
                            }

                            ?>



                            <table border="1" cellspacing="0">
                                <tr>
                                    <td align="left" class="align1"><b>Earnings Amount</b></td>
                                    <td class="align"><b>Deductions Amount</b></td>
                                </tr>
                                <tr>
                                    <td>
                                        <table border="0" width="417" style="margin-top: -6rem;">
                                            <tr>
                                                <td class="box1"></td>
                                                <td class="box1"><?php echo $id; ?></td>
                                            </tr>

                                            <?php
                                            $query2 = "SELECT * FROM employee_earnings WHERE employee_id =$id";
                                            $result2 = mysql_query($query2, $link) or die(mysql_error());

                                            $rows = array();
                                            while ($row2 = mysql_fetch_assoc($result2)) {
                                                $rows[] = $row2;
                                            }

                                            foreach (array_slice($columns, 3) as $columnName) {
                                                echo "<tr>";
                                                echo "<td align='left' style='text-transform: capitalize;'>" . $columnName . "</td>";

                                                foreach ($rows as $row) {
                                                    $columnNameWithUnderscores = str_replace(' ', '_', $columnName);
                                                    echo "<td align='right'>" . (isset($row[$columnNameWithUnderscores]) ? number_format("$row[$columnNameWithUnderscores]", 2) : "0") . "</td>";
                                                    echo "</tr>"; // Close the row after each value
                                                }
                                            }

                                            ?>

                                </tr>
                                <?php

                                ?>

                                <?php
                                ?>

                                <?php
                                $gross = ($DepartmentObject->TotalGrossPay($empno));




                                if ($TaxObject->getEmployeeAge($empno) < 55) {
                                    $napsa = $gross * 0.05;
                                    if ($napsa >= $TaxObject->getNapsaCeiling($compId))
                                        $napsa = $TaxObject->getNapsaCeiling($compId);

                                    $napsa_calc = "";
                                    if ($napsa >= 255)
                                        $napsa_calc = 255;
                                } else {
                                    $napsa = 0;
                                }

                                $band1_top = $TaxObject->getTopBand1($compId);
                                $band2_top = $TaxObject->getTopBand2($compId);
                                $band3_top = $TaxObject->getTopBand3($compId);

                                $band1_rate = $TaxObject->getBandRate1($compId) / 100;
                                $band2_rate = $TaxObject->getBandRate2($compId) / 100;
                                $band3_rate = $TaxObject->getBandRate3($compId) / 100;
                                $band4_rate = $TaxObject->getBandRate4($compId) / 100;

                                $starting_income = $income = $gross - $napsa;

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

                                $total_tax_paid = $TaxObject->TaxCal($gross, $compId);

                                $taxable = $gross - $income;

                                $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa;
                                $netpay = $gross - $totdeduct;
                                $date_timestamp = strtotime($row['time']);

                                $date_compare = date('Y-m-d', $date_timestamp);
                                if ($LoanObject->getLoanMonthDedeductAmounts($empno, $date_compare) == "") {
                                    $loanAmnt = "0.0";
                                } else {
                                    $loanAmnt = $LoanObject->getLoanMonthDedeductAmounts($row["empno"], $date_compare);
                                }
                                ?>
                                <script>
                                    console.log(<?php json_encode($gross); ?>);
                                </script>
                                <tr>
                                    <td class="box"></td>
                                    <td align="right">
                                    </td>
                            </table>
                            </td>
                            <td width="">
                                <table border="0" width="417" cellspacing="0">

                                    <tr>
                                        <td class="box">PAYE</td>
                                        <td align="right"><?php echo number_format("$total_tax_paid", 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="box">NAPSA</td>
                                        <td align="right"><?php echo number_format("$napsa", 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="box">Insurance</td>
                                        <td align="right"><?php echo number_format("$insurance", 2); ?></td>
                                    </tr>
                                    <?php
                                    // echo $emp_id;s
                                    $deductQuery = mysql_query("SELECT * FROM employee_deductions WHERE company_id='$compId' AND employee_id='$emp_id'");
                                    $row = mysql_fetch_array($deductQuery);
                                    // Get the column names from the query result
                                    $columnNames = array();
                                    while ($fieldName = mysql_fetch_field($deductQuery)) {
                                        $columnName = $fieldName->name;
                                        // Exclude unwanted column names
                                        if ($columnName !== 'id' && $columnName !== 'employee_id' && $columnName !== 'company_id') {
                                            $columnNames[] = $columnName;
                                        }
                                    }
                                    // Fetch deduction details from `deductions` table using JOIN
                                    $deductionDetailsQuery = "SELECT * FROM deductions WHERE name IN ('" . implode("', '", $columnNames) . "')";
                                    $deductionDetailsResult = mysql_query($deductionDetailsQuery);

                                    $deductionsTotal = 0;

                                    // Loop through each deduction detail and add a row for it if value is 1
                                    while ($deductionDetailRow = mysql_fetch_array($deductionDetailsResult)) {
                                        $deductionColumnName = strtolower($deductionDetailRow['name']); // Transform name to uppercase
                                        $deductionValue = isset($row[$deductionColumnName]) ? $row[$deductionColumnName] : 0;
                                        // if ($deductionValue == 1) {
                                        $deductionsTotal += $PayslipObject->getDeductionValue($gross, $deductionDetailRow);
                                    ?>
                                        <tr>
                                            <td class="box"><?php echo $deductionDetailRow['name']; ?></td>
                                            <td align="right"><?php echo number_format($PayslipObject->getDeductionValue($gross, $deductionDetailRow), 2); ?></td>
                                        </tr>
                                    <?php
                                        // }
                                    }
                                    ?>

                                    <?php
                                    $recurringDeductQuery = mysql_query("SELECT * FROM emp_recurring_deductions WHERE company_ID='$compId' AND employee_id='$emp_id'");
                                    $recurringDeductTotal = 0;
                                    // Loop through each recurring deduction detail
                                    $recurringDeductRows = array();
                                    while ($row = mysql_fetch_array($recurringDeductQuery)) {
                                        $recurringDeductRows[] = $row;
                                    }

                                    foreach ($recurringDeductRows as $recurringDeductRow) {
                                        $deductionTypeId = $recurringDeductRow['deduction_type'];

                                        // Get deduction details from `recurring_deductions` table
                                        $deductionTypeQuery = mysql_query("SELECT * FROM recurring_deduction_types WHERE id='$deductionTypeId'");
                                        $deductionTypeRow = mysql_fetch_array($deductionTypeQuery);

                                        $deductionName = $deductionTypeRow['name'];
                                        $deductionValue = $recurringDeductRow['monthly_deduct'];
                                        $recurringDeductTotal += $deductionValue;
                                    ?>
                                        <tr>
                                            <td class="box"><?php echo $deductionName; ?></td>
                                            <td align="right"><?php echo number_format($deductionValue, 2); ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                    <tr>
                                        <td class="box">Advances</td>
                                        <td align="right"><?php echo number_format("$advances", 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="box">Loan</td>
                                        <td align="right"><?php
                                                            echo $loanAmnt;
                                                            ?></td>
                                    </tr>

                                    <tr>
                                        <td class="box">National Health Insurance</td>
                                        <td align="right">
                                            <?php
                                            echo $nhema;
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="box">Pension</td>
                                        <td align="right">
                                            <?php
                                            echo $pension;
                                            ?>
                                        </td>
                                    </tr>
                                    </tr>
                                    <tr>
                                        <td class="box"></td>
                                        <td height="40" width=""></td>
                                    </tr>

                                </table>

                            </td>
                            </tr>
                            </tr>
                            <tr>
                                <td class="align2"><b>Gross Pay <div class="align3"><?php echo number_format($gross, 2); ?></div></b>

                                </td>
                                <td><b>Total Deductions <div class="align3"> <?php
                                                                                $totalDeductions = $total_tax_paid + $napsa +
                                                                                    $advances + $insurance + $loanAmnt + $nhema + $pension + $recurringDeductTotal + $deductionsTotal;
                                                                                echo number_format("$totalDeductions", 2);
                                                                                ?></div></b></td>
                            </tr>
                        </table>
                        </br>
                        <table border="1" width="422" align="right" class="net" cellspacing="0">
                            <tr>
                                <td align="left"><b> Net Pay <div class="align3"><?php
                                                                                    $net = ($gross - $totalDeductions);
                                                                                    echo number_format($net, 2);
                                                                                    ?></div></b></td>
                            </tr>
                        </table>

                        <input type="hidden" name="insert" disabled value="<?php echo $insert; ?>" />
                        <br><br>
                        <?php
                        $query = "SELECT * FROM loan where empno = '$empno' ";

                        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());

                        $row = mysql_fetch_array($result, MYSQL_ASSOC);
                        $balance = $row['loan_amt'];
                        $interest = $row['interest'];
                        $months = $row['duration'];
                        $deduct = $row['monthly_deduct'];
                        ?>
                        Outstanding Payments
                        <table border="1" width="850" cellspacing="0">
                            <tr>
                                <td></td>
                                <td>Amount</td>
                                <td>Interest</td>
                                <td>Months Left</td>
                            </tr>
                            <tr>
                                <td>Personal Loans</td>
                                <td><?php
                                    if ($balance == "") {
                                        echo "0.0";
                                    } else {
                                        echo $loanAmnt;
                                    }
                                    ?></td>
                                <td><?php
                                    if ($interest == "") {
                                        echo "0.0";
                                    } else {
                                        echo number_format("$interest", 2);
                                    }
                                    ?></td>
                                <td><?php
                                    if ($months == "") {
                                        echo "0";
                                    } else {
                                        echo $months;
                                    }
                                    ?></td>
                            </tr>
                            <tr>
                                <td>Car Loans</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Educational Loans</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <?php
                                // return var_dump($recurringDeductRows);
                                foreach ($recurringDeductRows as $recurringDeductRow) {
                                    $deductionTypeId = $recurringDeductRow['deduction_type'];
                                    $deductionEndDate = $recurringDeductRow['date_completion'];

                                    // Get deduction details from `recurring_deductions` table
                                    $deductionTypeQuery2 = mysql_query("SELECT * FROM recurring_deduction_types WHERE id='$deductionTypeId'");
                                    $deductionTypeRow2 = mysql_fetch_array($deductionTypeQuery2);

                                    $deductionName = $deductionTypeRow2['name'];
                                    $deductionValue = $recurringDeductRow['monthly_deduct'];

                                    $DI = new DateTime($dateIssued);
                                    $DED = new DateTime($deductionEndDate);

                                    if ($DI < $DED) {
                                ?>
                                        <td><?= $deductionName ?></td>
                                        <td><?php

                                            $interval = $DI->diff($DED);
                                            $months = ($interval->y * 12) + $interval->m;

                                            echo number_format($deductionValue, 2) * $months;
                                            ?></td>
                                        <td>N/A</td>
                                        <td>
                                            <?php

                                            $interval = $DI->diff($DED);
                                            $months = ($interval->y * 12) + $interval->m;

                                            echo $months;
                                            ?>
                                        </td>
                                <?php
                                    }
                                }
                                ?>
                            </tr>
                        </table><br>
                        Total Contributions<br>
                        <table border="1" width="850" cellspacing="0">
                            <tr>
                                <td>Total Tax Paid To Date</td>
                                <td><?php echo number_format($paid_todate, 2); ?></td>

                            </tr>
                            <tr>
                                <td>NAPSA</td>
                                <td><?php echo number_format($napsa, 2); ?></td>

                            </tr>
                            <tr>
                                <td>Tax Paid This Month:</td>
                                <td><?php echo number_format($total_tax_paid, 2); ?></td>
                            </tr>

                            <tr>
                                <td>Total NHIMA paid to Date:</td>
                                <td><?php echo number_format($totalNhima, 2); ?></td>
                            </tr>

                        </table>
                        </table>
                        </table>
                    </form>
                </div>
                <br></br>
            </div>
        </div>

    </div>
</body>

</html>