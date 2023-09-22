<?php
error_reporting(0);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);

        include('../../include/dbconnection.php');
        include_once '../../Admin/Classes/Company.php';
        include_once '../../Admin/Classes/Tax.php';
        include_once '../Classes/MyPayslips.php';
        include_once '../../Admin/Classes/Department.php';
        $CompanyObject = new Company();
        $TaxObject = new Tax();
        $PayslipObject = new MyPayslips();
        $companyType = $_SESSION['company_name'];
        $companyId = $_SESSION['company_ID'];
        $compId = $companyId;

        $DepartmentObject = new Department();

        echo '<div class="body"><img src="' . $CompanyObject->getCompanyLogo4($companyId) . '"></div>';
        ?>
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
                include('../../include/dbconnection.php');
                $id = $_GET['id'];
                $empno = $_GET['empno'];
                $PayslipQuery = "SELECT * FROM employee WHERE id = '$id' AND empno ='$empno' ";
                $result = mysql_query($PayslipQuery, $link) or die(mysql_error());
                while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                    //$gross = ($row['pay'] * $row['dayswork']) + ($row['otrate'] * $row['othrs']) + $row['allow'];
                    $gross = $row['pay']; //($DepartmentObject->getBasicPay($empno) + $DepartmentObject->getTransportAllowance($empno) + $DepartmentObject->gethousingAllowance($empno) + $DepartmentObject->getLunchAllowance($empno) ) + ($row['otrate'] * $row['othrs']) + $row['allow'] + $row['comission'];

                    $date_timestamp = strtotime($row['time']);
                    $date = date('m-d-Y', $date_timestamp);

                    if ($gross >= 5900.01)
                        $tax = $gross * .15;
                    if ($gross >= 3800.01 && $gross <= 5900)
                        $tax = $gross * .05;
                    if ($gross >= 3000 && $gross <= 3800)
                        $tax = $gross * .03;
                    if ($gross < 3000)
                        $tax = 0;

                    $totdeduct = $tax + $row['advances'] + $row['insurance'];
                    $netpay = $gross - $totdeduct;
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
                        $query = "INSERT INTO employee VALUES ('$empno','$lname','$fname','$init','$position',$pay,$dayswork,$otrate,$othrs,$allow,$advances,$insurance)";
                        $msg = "New record saved!";
                    } else {
                        $query = "UPDATE employee SET empno=$empno,lname='$lname',fname='$fname',init= '$init',position='$position' WHERE id = $id";
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
                }

                $position = $row['position'];

                $query8 = "SELECT * FROM loan where empno = '$empno' AND status = 'Pending' ";
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
                            <td>:<?php echo $empno; ?></td>
                        </tr>
                        <tr>
                            <td class="box">Department:</td>
                            <td>:<?php echo $dept; ?></td>
                        </tr>
                        <tr>
                        <tr>
                            <td class="box">Position:</td>
                            <td>:<?php echo $position; ?></td>
                        </tr>
                        <tr>
                            <td class="box" width="">Payment Method:</td>
                            <td>Bank</td>
                        </tr>
                        <tr>
                            <td class="box" width="">Date Issued:</td>
                            <td>:<?php echo $date; ?></td>
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
                        $query = "SELECT * FROM employee WHERE id=$id";

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

                            $pay = $row['pay'];
                            $dayswork = $row['dayswork'];
                            $otrate = $row['otrate'];
                            $othrs = $row['othrs'];
                            $allow = $row['allow'];
                            $advances = $row['advances'];
                            $insurance = $row['insurance'];
                            $comission = $row['comission'];
                            $overtime = $otrate * $othrs;
                            $nhema = $row['health_insurance'];
                            $pension = $row['pension'];
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
                                    word-spacing:332px;
                                }
                                .align1{
                                    word-spacing:342px;
                                }
                                .align3{
                                    float:right;
                                }
                                .net{
                                    margin-right:31px;
                                }
                            </style>

                            <br>
                            <table border="1" cellspacing="0" style="height: 100%;">
                                <tbody style="vertical-align: top;
                                align-items: stretch;
                                display: flex;
                                flex-direction: column;">
                                    <tr>
                                        <td align="left" class="align1"><b>Earnings Amount</b></td>
                                        <td class="align"><b>Deductions Amount</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table border="0" width="417">

                                                <?php
                                                // Function to clean column names
                                                function cleanColumnName($columnName)
                                                {
                                                    // Replace underscores with spaces, then remove other special characters
                                                    $cleanedName = preg_replace('/_/', ' ', $columnName);
                                                    $cleanedName = preg_replace('/[^A-Za-z0-9\s]/', '', $cleanedName);
                                                    return $cleanedName;
                                                }

                                                $query = "SELECT * FROM employee_earnings WHERE employee_no = '$empno'";
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
                                                <?php
                                                $query2 = "SELECT * FROM employee_earnings WHERE employee_no ='$empno'";
                                                $result2 = mysql_query($query2, $link) or die(mysql_error());
                                                $totalEarnings = 0;
                                                $rows = array();
                                                while ($row2 = mysql_fetch_assoc($result2)) {
                                                    $rows[] = $row2;
                                                }

                                                foreach (array_slice($columns, 4) as $columnName) {
                                                    echo "<tr>";
                                                    echo "<td align='left' style='text-transform: capitalize;'>" . $columnName . "</td>";

                                                    foreach ($rows as $row) {
                                                        $columnNameWithUnderscores = str_replace(' ', '_', $columnName);
                                                        echo "<td align='right'>" . (isset($row[$columnNameWithUnderscores]) ? number_format("$row[$columnNameWithUnderscores]", 2) : "0") . "</td>";
                                                        echo "</tr>"; // Close the row after each value

                                                        $totalEarnings += $row[$columnNameWithUnderscores];
                                                    }
                                                }

                                                ?>
                                                <tr>
                                                    <td align="left">
                                                        Overtime
                                                    </td>
                                                    <td align="right"><?= $overtime ?></td>
                                                </tr>
                                                <tr style="height: 0px;">
                                                    <td class="box1"></td>
                                                    <td class="box1"><?php echo $id; ?></td>
                                                </tr>
                                    </tr>
                                    <?php

                                    $gross = ($row['pay']) + $overtime + $row['allow'] + $row['comission'] + $totalEarnings;

                                    if ($TaxObject->getEmployeeAge($row['empno']) < 55) {
                                        $napsa = $gross * 0.05;
                                        if ($napsa >= $TaxObject->getNapsaCeiling($compId))
                                            $napsa = $TaxObject->getNapsaCeiling($compId);

                                        $napsa_calc = "";
                                        if ($napsa >= 255)
                                            $napsa_calc = 255;
                                    } else {
                                        $napsa = 0;
                                    }

                                    //the tops of each tax band
                                    $band1_top = $TaxObject->getTopBand1($companyId);
                                    $band2_top = $TaxObject->getTopBand2($companyId);
                                    $band3_top = $TaxObject->getTopBand3($companyId);

                                    $band1_rate = $TaxObject->getBandRate1($companyId) / 100;
                                    $band2_rate = $TaxObject->getBandRate2($companyId) / 100;
                                    $band3_rate = $TaxObject->getBandRate3($companyId) / 100;
                                    $band4_rate = $TaxObject->getBandRate4($companyId) / 100;


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

                                    $date_compare = date('Y-m-d', strtotime($row['time']));

                                    if ($PayslipObject->getLoanMonthDedeductAmounts($row["empno"], $date_compare) == "") {
                                        $loanAmnt = "0.0";
                                    } else {
                                        $loanAmnt = $PayslipObject->getLoanMonthDedeductAmounts($row["empno"], $date_compare);
                                    }

                                    $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa + $loanAmnt;
                                    $netpay = $gross - $totdeduct;
                                    ?>
                                    <tr>
                                        <td class="box"></td>
                                        <td align="right">
                                        </td>
                                    </tr>
                                </tbody>
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
                                    $deductQuery = mysql_query("SELECT * FROM employee_deductions WHERE company_id='$compId' AND employee_no='$empno'")  or die(mysql_error());
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
                                        if ($deductionValue == "1") {
                                            $deductionsTotal += $PayslipObject->getDeductionValue($gross, $deductionDetailRow);
                                    ?>
                                            <tr>
                                                <td class="box"><?php echo $deductionDetailRow['name']; ?></td>
                                                <td align="right"><?php echo number_format($PayslipObject->getDeductionValue($gross, $deductionDetailRow), 2); ?></td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>

                                    <?php
                                    $recurringDeductQuery = mysql_query("SELECT * FROM emp_recurring_deductions WHERE company_ID='$compId' AND employee_no='$empno' AND status='Pending'") or die(mysql_error());
                                    $recurringDeductTotal = 0;
                                    // Loop through each recurring deduction detail
                                    $recurringDeductRows = array();
                                    while ($row = mysql_fetch_array($recurringDeductQuery)) {
                                        $recurringDeductRows[] = $row;
                                    }

                                    foreach ($recurringDeductRows as $recurringDeductRow) {
                                        $deductionTypeId = $recurringDeductRow['deduction_type'];

                                        // Get deduction details from `recurring_deductions` table
                                        $deductionTypeQuery = mysql_query("SELECT * FROM recurring_deduction_types WHERE id='$deductionTypeId'")  or die(mysql_error());
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
                                    <?php
                                    $query = "SELECT * FROM loan where empno = '$empno' AND status='Pending' ";

                                    $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());

                                    while ($row = mysql_fetch_array($result)) {
                                        // return var_dump($row);
                                        $balance = $row['loan_amt'];
                                        $loanAmnt = $row['monthly_deduct'];
                                        $deadLine = new DateTime($row['date_completion']);
                                        $DI = new DateTime($dateIssued);
                                    ?>
                                        <tr>
                                            <td class="box">Loan</td>
                                            <td align="right">
                                                <?php
                                                echo $loanAmnt;
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

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
                            <tr style="display: flex; justify-content: space-between;">
                                <td class="align2"><b style="margin-right: 20px;">Gross Pay <div class="align3"> <?php

                                                                                                                    echo number_format("$gross", 2); ?></div></b>

                                </td>
                                <td><b style="margin-right: 20px;">Total Deductions <div class="align3"> <?php
                                                                                                            $totalDeductions = $total_tax_paid + $napsa +
                                                                                                                $advances + $insurance + $loanAmnt + $nhema + $recurringDeductTotal + $deductionsTotal;
                                                                                                            echo number_format("$totalDeductions", 2);
                                                                                                            ?></div></b></td>
                            </tr>
                        </table>
                        </br>
                        <table border="1" width="422" align="right" class="net" cellspacing="0">
                            <tr>
                                <td align="left"><b style="margin-right: 10px;"> Net Pay <div class="align3"><?php
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
                        Closing Balances
                        <table border="1" width="850" cellspacing="0">
                            <tr>
                                <td></td>
                                <td>Outstanding Amount</td>
                                <td>Interest</td>
                                <td>Months Left</td>
                            </tr>
                            <?php
                            $query = "SELECT * FROM loan where empno = '$empno' AND status='Pending' ";

                            $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());

                            while ($row = mysql_fetch_array($result)) {
                                // return var_dump($row);
                                $balance = $row['loan_amt'];
                                $interest = $row['interest'];
                                $months = $row['duration'];
                                $deduct = $row['monthly_deduct'];
                                $deadLine = new DateTime($row['date_completion']);
                                $DI = new DateTime($dateIssued);
                            ?>
                                <tr>
                                    <td>Personal Loans</td>
                                    <td><?php

                                        $balance = $deduct * $months;

                                        echo number_format($balance, 2);
                                        ?></td>
                                    <td><?php
                                        if ($interest == "") {
                                            echo "0.0";
                                        } else {
                                            echo number_format("$interest", 2);
                                        }
                                        ?></td>
                                    <td><?php

                                        echo $months;
                                        ?></td>
                                </tr>
                            <?php
                            }
                            ?>
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
                                    $monthsLeft = $recurringDeductRow['duration'];


                                    if ($status == 'Pending') {
                                ?>
                                        <td><?= $deductionName ?></td>
                                        <td><?php

                                            echo number_format($deductionValue * $monthsLeft, 2);
                                            ?></td>
                                        <td>N/A</td>
                                        <td>
                                            <?php

                                            echo $monthsLeft;
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