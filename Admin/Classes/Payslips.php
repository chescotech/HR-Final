<?php

class Payslips
{
    private $link;


    function __construct()
    {
        $this->link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('db connection problem' . mysqli_connect_error());
    }

    public function addLoan($empno, $loan_amount, $monthly_deduction, $duration, $companyId, $principle, $interest_rate, $intrest)
    {
        $result = mysqli_query($this->link, "INSERT INTO loan(empno,loan_amt,"
            . " monthly_deduct,duration,company_ID,principle"
            . ",interest_rate,interest) VALUES('$empno','$loan_amount','$monthly_deduction'"
            . ",'$duration','$companyId', '$principle','$interest_rate','$intrest')");
        return $result;
    }

    function addDisplineRecord($empno, $date_charged, $charged_til, $offense_commited, $case_status, $punishment, $charged_by, $file)
    {
        $result = mysqli_query($this->link, "INSERT INTO employee_discplinary_records(empno,date_charged,charged_til,"
            . " offence_commited,case_status,punishment,charged_by,file) VALUES('$empno','$date_charged','$charged_til','$offense_commited'"
            . ",'$case_status','$punishment', '$charged_by','$file')");
        return $result;
    }

    function updateDiscplineRecord($empno, $date_charged, $offense_commited, $case_status, $punishment, $charged_by, $id)
    {
        $result = mysqli_query($this->link, "UPDATE employee_discplinary_records SET empno = '$empno', "
            . "date_charged = '$date_charged',offence_commited = '$offense_commited', "
            . "case_status = '$case_status', punishment='$punishment',charged_by = '$charged_by'  WHERE id= '$id'");
        return $result;
    }

    public function checkIfRecordExsists($empno, $date)
    {
        $status = "";
        $query = mysqli_query($this->link, " SELECT * FROM employee WHERE empno = '$empno' AND time = '$date' ");
        if (mysqli_num_rows($query) != 0) {
            $status = "true";
        } else {
            $status = "false";
        }
        return $status;
    }

    public function checkNhimaStatus()
    {
        $status = "";
        $query = mysqli_query($this->link, " SELECT * FROM nhima_tb");
        $row = mysqli_fetch_array($query);
        $nhema_status = $row['status'];
        if (mysqli_num_rows($query) == 0 || $nhema_status != "Active") {
            $status = "false";
        } else if (mysqli_num_rows($query) > 0 && $nhema_status == "Active") {
            $status = "true";
        }
        return $status;
    }

    public function getNhimaSettings()
    {
        $query = mysqli_query($this->link, " SELECT * FROM nhima_tb");
        $row = mysqli_fetch_array($query);
        $nhema_percentage = $row['amount'];
        return $nhema_percentage;
    }

    public function getBasicPay($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$empno'");
        $grossRows = mysqli_fetch_array($result);
        $basic_pay = $grossRows['basic_pay'];
        return $basic_pay;
    }

    public function CalclucateNhima($basicPay, $nhimaSetings)
    {
        $nhima = ($nhimaSetings / 100) * $basicPay;
        return $nhima;
    }

    public function checkPensionStatus()
    {
        $status = "";
        $query = mysqli_query($this->link, " SELECT * FROM pensions_tb");
        $row = mysqli_fetch_array($query);
        $nhema_status = $row['status'];
        if (mysqli_num_rows($query) == 0 || $nhema_status != "Active") {
            $status = "false";
        } else if (mysqli_num_rows($query) > 0 && $nhema_status == "Active") {
            $status = "true";
        }
        return $status;
    }

    function getEmployeeAllowance($empno, $type)
    {
        $result = mysqli_query($this->link, "SELECT basic_pay FROM emp_info WHERE empno='$empno'  ");
        $row = mysqli_fetch_array($result);
        $allowance_types = $row['basic_pay'];
        return $allowance_types;
    }

    function getEmployeePensionShareCal()
    {
        $result = mysqli_query($this->link, "SELECT employee_share FROM pensions_tb ");
        $row = mysqli_fetch_array($result);
        $employee_shares = $row['employee_share'];
        return $employee_shares;
    }

    function getEmployerPensionShareCal()
    {
        $result = mysqli_query($this->link, "SELECT employer_share FROM pensions_tb ");
        $row = mysqli_fetch_array($result);
        $employer_share = $row['employer_share'];
        return $employer_share;
    }

    public function getEmployeeGrossPay($emp_no_arg, $date_arg)
    {
        // Get the month payslip from `employee` table
        $payslipQuery = "SELECT * FROM employee WHERE empno = '$emp_no_arg' AND time = '$date_arg'";

        $payslipResult = mysqli_query($this->link, $payslipQuery) or die("invalid query" . mysqli_error($this->link));
        $payslipRow = mysqli_fetch_array($payslipResult);

        $payslip = $payslipRow['pay'] + ($payslipRow['otrate'] * $payslipRow['othrs']) + $payslipRow['allow'] + $payslipRow['comission'];
        // Get earnings from `getEmployeeEarnings` function
        $earnings = $this->getEmployeeEarnings($payslipRow['earnings_data']);

        // Add them up
        $gross = $payslip + $earnings;

        return $gross;
    }

    public function pensionCalculations($empno)
    {
        $query = mysqli_query($this->link, " SELECT * FROM pensions_tb");
        $row = mysqli_fetch_array($query);
        $allowance_types = $row['allowance_type'];
        $employee_share = $row['employee_share'];
        $employer_share = $row['employer_share'];

        $allowance = $this->getEmployeeAllowance($empno, 'basic_pay');

        // $pension = (($employee_share + $employer_share) / 100) * $allowance;
        $pension = (($employee_share) / 100) * $allowance;

        return $pension;
    }

    public function addEmpPayslipInfo($empno, $pay, $dayswork, $otrate, $othrs, $allow, $advances, $insurance, $time, $comission, $payee, $napsa, $company_id, $earnings_arg, $deductions_arg)
    {
        $result = "";
        $pension = 0;
        $employer_share = 0;
        $employee_share = 0;
        $basic_pay = $this->getBasicPay($empno);

        if ($this->checkNhimaStatus() == "true") {
            $nhima = $this->CalclucateNhima($basic_pay, $this->getNhimaSettings());
            //$pay = $this->getBasicPay($empno);//$pay -$nhima;
            if ($empno != "") {

                if ($this->checkPensionStatus() == "true") {
                    $pension = $this->pensionCalculations($empno);
                    $employee_share = ($this->getEmployeePensionShareCal() / 100) * $basic_pay;
                    $employer_share = ($this->getEmployerPensionShareCal() / 100) * $basic_pay;
                }

                $result = mysqli_query($this->link, "INSERT INTO employee(empno,pay,
                     dayswork,otrate,othrs
                    ,allow,advances,insurance,time,comission,company_id,health_insurance,pension,employer_share,employee_share, payee, napsa, earnings_data, deductions_data) VALUES('$empno','$basic_pay','$dayswork'
                    ,'$otrate','$othrs', '$allow','$advances','$insurance', '$time','$comission','$company_id','$nhima','$pension','$employer_share' ,'$employee_share', '$payee','$napsa', '$earnings_arg', '$deductions_arg'  )") or die(mysqli_error($this->link));
            }
            return $result;
        } else {
            if ($empno != "") {

                if ($this->checkPensionStatus() == "true") {
                    $pension = $this->pensionCalculations($empno);
                    $employee_share = $this->getEmployeePensionShareCal();
                    $employer_share = $this->getEmployerPensionShareCal();
                }

                $result = mysqli_query($this->link, "INSERT INTO employee(empno,pay,
                     dayswork,otrate,othrs
                    ,allow,advances,insurance,time,comission,company_id,pension,employer_share,employee_share) VALUES('$empno','$pay','$dayswork'
                    ,'$otrate','$othrs', '$allow','$advances','$insurance', '$time','$comission','$company_id','$pension','$employer_share','$employee_share'   )") or die(mysqli_error($this->link));
            }
            return $result;
        }
    }

    public function checkIfUploadExsists($empno, $date)
    {
        $state = "";
        $result = mysqli_query($this->link, "SELECT * FROM payslip_uploads WHERE empno = '$empno' AND date_period = '$date' ");
        if (mysqli_num_rows($result) == 0) {
            $state = "false";
        } else {
            $state = "true";
        }
        return $state;
    }

    public function getPdfPayslip($empno, $date)
    {
        $query = "SELECT * FROM payslip_uploads WHERE empno = '$empno' AND date_period = '$date'";
        $result = mysqli_query($this->link, $query) or die(mysqli_error($this->link));
        $row = mysqli_fetch_array($result);
        $pdfPayslip = "../uploads/" . $row['payslip'];
        return $pdfPayslip;
    }

    public function addTax($taxable, $total_tax_paid, $empno, $comp_ID, $date)
    {
        $socialSecNo = 0;
        $result = mysqli_query($this->link, "INSERT INTO tax(taxable_to_date,tax_paid_to_date,empno,company_id,social,date) VALUES($taxable,$total_tax_paid,'$empno'"
            . ",'$comp_ID',$socialSecNo,'$date')");
        return $result;
    }

    public function updateTax($taxable, $total_tax_paid, $empno)
    {
        $result = mysqli_query($this->link, "UPDATE tax SET taxable_to_date = taxable_to_date + $taxable,tax_paid_to_date = tax_paid_to_date + $total_tax_paid WHERE empno= '$empno'");
        return $result;
    }

    public function addLeave($empno)
    {
        $available = 2;
        $result = mysqli_query($this->link, "INSERT INTO leave_days(available,empno) VALUES('$available' ,'$empno')");
        return $result;
    }

    public function editPayslip($days_worked, $overtime_rate_hour, $overtime, $allowance, $advances, $insurance, $commision, $id, $time)
    {
        $res = mysqli_query($this->link, "UPDATE employee SET dayswork = "
            . " '$days_worked',otrate = '$overtime_rate_hour',"
            . "othrs='$overtime',allow='$allowance',advances='$advances',"
            . "insurance='$insurance',comission='$commision',time='$time'  WHERE id= '$id'");

        return $res;
    }

    public function getEditInfo($id)
    {
        $result = mysqli_query($this->link, "SELECT * FROM employee WHERE id = '$id'");
        return $result;
    }

    public function PayslipEditDetails($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno = '$empno'");
        $DetalsRows = mysqli_fetch_assoc($result);
        $fname = $DetalsRows['fname'];
        $lname = $DetalsRows['lname'];
        $payDetails = $fname . " " . $lname;
        return $payDetails;
    }

    public function updateLeave($empno, $companyId)
    {
        // get the employees monthly leave days based on there grade .... 
        $result2 = mysqli_query($this->link, "SELECT * FROM leave_ratings_tb "
            . "WHERE grade_id IN ( SELECT employee_grade FROM emp_info WHERE empno = '$empno' AND company_id = '$companyId' )");
        $DetalsRows = mysqli_fetch_array($result2);
        $monthly_leave_days = $DetalsRows['monthly_leave_days'];
        // update the employees leave days.. 
        $result = mysqli_query($this->link, "UPDATE leave_days SET available = available + '$monthly_leave_days' WHERE empno = '$empno' ");
        return $result;
    }

    public function deductLeave($empno, $companyId)
    {
        // get the employees monthly leave days based on there grade .... 
        $result2 = mysqli_query($this->link, "SELECT * FROM leave_ratings_tb "
            . "WHERE grade_id = ( SELECT employee_grade FROM emp_info WHERE empno = '$empno' AND company_id = '$companyId' )") or die(mysqli_error($this->link));
        $DetalsRows = mysqli_fetch_array($result2);
        $monthly_leave_days = $DetalsRows['monthly_leave_days'];
        // update the employees leave days.. 
        $result = mysqli_query($this->link, "UPDATE leave_days SET available = available - '$monthly_leave_days' WHERE empno = '$empno' ") or die(mysqli_error($this->link));
        return $result;
    }

    public function updateLoans($empno, $interest, $principle)
    {
        $query4 = "UPDATE loan  SET duration  = duration - 1 , interest =  $interest, loan_amt = $principle, principle = $principle  WHERE empno = '$empno'";
        $result = mysqli_query($this->link, $query4) or die($this->link);
        return $result;
    }

    public function getDeductionValue($salary, $deducName)
    {
        $deductionValue = 0;

        $deductionRow = $this->getDeductionRow($deducName);

        if ($deductionRow) {
            $type = $deductionRow['type'];

            if ($type == 'fixed') {
                return $deductionRow['emp_fixed'];
            } else {
                $deductAmount = $salary * ($deductionRow['emp_calc_num'] / $deductionRow['emp_calc_deno']);

                if ($deductAmount > $deductionRow['emp_upper_bound']) {
                    $deductAmount = $deductionRow['emp_upper_bound_amnt'];
                } else if ($deductAmount > $deductionRow['emp_lower_bound']) {
                    $deductAmount = $deductionRow['emp_lower_bound_amnt'];
                }

                return $deductAmount;
            }
        }

        return $deductionValue;
    }

    private function getDeductionRow($deduction)
    {
        // Replace this with your database query to fetch the deduction row
        $query = "SELECT * FROM deductions WHERE name = '$deduction'";
        $deductionRow = mysqli_query($this->link, $query);

        return mysqli_fetch_assoc($deductionRow);
    }

    public function getEmployeeEarnings($employeeEarningsJson)
    {
        $employeeEarnings = json_decode($employeeEarningsJson, true);
        $sum = 0;
        if (!empty($employeeEarnings)) {
            foreach ($employeeEarnings[0] as $key => $value) {
                if (!empty($value)) {
                    $sum += intval($value);
                }
            }
        }

        return $sum;
    }

    public function getEmployeeEarningsId($emp_no_arg)
    {
        $query = mysqli_query($this->link, "SELECT id FROM employee_earnings WHERE employee_no='$emp_no_arg'");

        $value = mysqli_fetch_assoc($query);

        return $value;
    }


    public function getEmployeeDeductionsId($emp_no_arg)
    {
        $query = mysqli_query($this->link, "SELECT id FROM employee_deductions WHERE employee_no='$emp_no_arg'");

        $value = mysqli_fetch_assoc($query);

        return $value;
    }

    public function getEmployeeBasicPay($emp_no_arg)
    {
        $query = mysqli_query($this->link, "SELECT basic_pay FROM emp_info WHERE empno = '$emp_no_arg'") or die(mysqli_error($this->link));

        $data = mysqli_fetch_assoc($query);

        return $data;
    }

    public function getEmployeeEarningsTotal($emp_earn_id_arg)
    {
        $query = mysqli_query($this->link, "SELECT * FROM employee_earnings WHERE employee_no = '$emp_earn_id_arg'") or die(mysqli_error($this->link));

        if (mysqli_num_rows($query) > 0) {

            $data = mysqli_fetch_assoc($query);

            $sliced = array_slice($data, 4);

            $sum = 0;

            foreach ($sliced as $key => $value) {
                if ($key === "company_id" || $key === "employee_id" || $key === "id" || $key === "employee_no") {
                    $add = false; // Stop adding when 'company_id' is reached
                } elseif (is_numeric($value)) {
                    $sum += (float)$value; // Convert to float and add if it's numeric
                }
            }
        } else {
            $sum = 0;
        }

        return $sum;
    }

    public function getEmployeeDeductions($salary_arg, $emp_num_arg, $emp_ded_id_arg, $date_arg)
    {
        $deductions = json_decode($emp_ded_id_arg, true);
        $sum = 0;

        foreach ($deductions[0] as $deduction => $value) {
            if ($value == '1') {
                $ded_value = $this->getDeductionValue($salary_arg, $deduction);

                $sum += intval($ded_value);
            }
        }

        $rdQuery = mysqli_query($this->link, "SELECT * FROM emp_recurring_deductions WHERE employee_no = '$emp_num_arg' AND '$date_arg' BETWEEN deduction_date AND date_completion") or die(mysqli_error($this->link));

        if (mysqli_num_rows($rdQuery) > 0) {
            $rdRow = mysqli_fetch_assoc($rdQuery);
            $sum += $rdRow['monthly_deduct'];
        }

        return $sum;
    }

    public function checkEmployeeTax($emp_no_arg)
    {
        $checkQuery = "SELECT * FROM tax where empno='$emp_no_arg'";

        $checkResult = mysqli_query($this->link, $checkQuery) or die("invalid query" . mysqli_error($this->link));

        return $checkResult;
    }

    // function savePayrollSnapshot($snapshotData, $employeeEarningsData, $employeeDeductionsData)
    // {
    //     $employeeNo = mysqli_real_escape_string($this->link, $snapshotData['employee_no']);
    //     $pay = mysqli_real_escape_string($this->link, $snapshotData['pay']);
    //     $daysWorked = mysqli_real_escape_string($this->link, $snapshotData['days_worked']);
    //     $overtimeRateHour = mysqli_real_escape_string($this->link, $snapshotData['overtime_rate_hour']);
    //     $overtime = mysqli_real_escape_string($this->link, $snapshotData['overtime']);
    //     $allowance = mysqli_real_escape_string($this->link, $snapshotData['allowance']);
    //     $advances = mysqli_real_escape_string($this->link, $snapshotData['advances']);
    //     $insurance = mysqli_real_escape_string($this->link, $snapshotData['insurance']);
    //     $commission = mysqli_real_escape_string($this->link, $snapshotData['commission']);
    //     $grossPay = mysqli_real_escape_string($this->link, $snapshotData['gross_pay']);
    //     $napsa = mysqli_real_escape_string($this->link, $snapshotData['napsa']);
    //     $payrollDate = mysqli_real_escape_string($this->link, $snapshotData['payroll_date']);
    //     $totalTaxPaid = mysqli_real_escape_string($this->link, $snapshotData['total_tax_paid']);

    //     // Fetch relevant employee_earnings and employee_deductions data
    //     $earningsData = $this->getRelevantEmployeeEarningsData($employeeNo, $employeeEarningsData);
    //     $deductionsData = $this->getRelevantEmployeeDeductionsData($employeeNo, $employeeDeductionsData);

    //     // Convert arrays to JSON for storage in the snapshot table
    //     $earningsJson = json_encode($earningsData);
    //     $deductionsJson = json_encode($deductionsData);

    //     // Assuming payroll_snapshots table has columns like employee_no, pay, days_worked, etc.
    //     $query = "INSERT INTO payroll_snapshots (employee_no, pay, days_worked, overtime_rate_hour, overtime, allowance, advances, insurance, commission, gross_pay, napsa, payroll_date, total_tax_paid, earnings_data, deductions_data) 
    //               VALUES ('$employeeNo', '$pay', '$daysWorked', '$overtimeRateHour', '$overtime', '$allowance', '$advances', '$insurance', '$commission', '$grossPay', '$napsa', $payrollDate, '$totalTaxPaid', '$earningsJson', '$deductionsJson')";

    //     $result = mysqli_query($this->link, $query);

    //     if ($result) {
    //         // Successful insertion
    //         return true;
    //     } else {
    //         // Failed insertion
    //         echo "Error: " . mysqli_error($this->link);
    //         return false;
    //     }
    // }

    // function getRelevantEmployeeEarningsData($employeeNo, $employeeEarningsData)
    // {
    //     // Fetch only the relevant earnings data where the value is not null
    //     $relevantEarningsData = array();
    //     foreach ($employeeEarningsData as $columnName => $value) {
    //         if ($value !== null) {
    //             $relevantEarningsData[$columnName] = $value;
    //         }
    //     }
    //     return $relevantEarningsData;
    // }

    // function getRelevantEmployeeDeductionsData($employeeNo, $employeeDeductionsData)
    // {
    //     // Fetch only the relevant deductions data where the value is 1
    //     $relevantDeductionsData = array();
    //     foreach ($employeeDeductionsData as $columnName => $value) {
    //         if ($value == 1) {
    //             $relevantDeductionsData[$columnName] = $value;
    //         }
    //     }
    //     return $relevantDeductionsData;
    // }
}
