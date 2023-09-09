<?php

class Payslips
{

    function __construct()
    {
        $conn = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die('db connection problem' . mysql_error());
        mysql_select_db(DB_NAME, $conn);
    }

    public function addLoan($empno, $loan_amount, $monthly_deduction, $duration, $companyId, $principle, $interest_rate, $intrest)
    {
        $result = mysql_query("INSERT INTO loan(empno,loan_amt,"
            . " monthly_deduct,duration,company_ID,principle"
            . ",interest_rate,interest) VALUES('$empno','$loan_amount','$monthly_deduction'"
            . ",'$duration','$companyId', '$principle','$interest_rate','$intrest')");
        return $result;
    }

    function addDisplineRecord($empno, $date_charged, $charged_til, $offense_commited, $case_status, $punishment, $charged_by, $file)
    {
        $result = mysql_query("INSERT INTO employee_discplinary_records(empno,date_charged,charged_til,"
            . " offence_commited,case_status,punishment,charged_by,file) VALUES('$empno','$date_charged','$charged_til','$offense_commited'"
            . ",'$case_status','$punishment', '$charged_by','$file')");
        return $result;
    }

    function updateDiscplineRecord($empno, $date_charged, $offense_commited, $case_status, $punishment, $charged_by, $id)
    {
        $result = mysql_query("UPDATE employee_discplinary_records SET empno = '$empno', "
            . "date_charged = '$date_charged',offence_commited = '$offense_commited', "
            . "case_status = '$case_status', punishment='$punishment',charged_by = '$charged_by'  WHERE id= '$id'");
        return $result;
    }

    public function checkIfRecordExsists($empno, $date)
    {
        $status = "";
        $query = mysql_query(" SELECT * FROM employee WHERE empno = '$empno' AND time = '$date' ");
        if (mysql_num_rows($query) != 0) {
            $status = "true";
        } else {
            $status = "false";
        }
        return $status;
    }

    public function checkNhimaStatus()
    {
        $status = "";
        $query = mysql_query(" SELECT * FROM nhima_tb");
        $row = mysql_fetch_array($query);
        $nhema_status = $row['status'];
        if (mysql_num_rows($query) == 0 || $nhema_status != "Active") {
            $status = "false";
        } else if (mysql_num_rows($query) > 0 && $nhema_status == "Active") {
            $status = "true";
        }
        return $status;
    }

    public function getNhimaSettings()
    {
        $query = mysql_query(" SELECT * FROM nhima_tb");
        $row = mysql_fetch_array($query);
        $nhema_percentage = $row['amount'];
        return $nhema_percentage;
    }

    public function getBasicPay($empno)
    {
        $result = mysql_query("SELECT * FROM emp_info WHERE empno='$empno'");
        $grossRows = mysql_fetch_array($result);
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
        $query = mysql_query(" SELECT * FROM pensions_tb");
        $row = mysql_fetch_array($query);
        $nhema_status = $row['status'];
        if (mysql_num_rows($query) == 0 || $nhema_status != "Active") {
            $status = "false";
        } else if (mysql_num_rows($query) > 0 && $nhema_status == "Active") {
            $status = "true";
        }
        return $status;
    }

    function getEmployeeAllowance($empno, $type)
    {
        $result = mysql_query("SELECT basic_pay FROM emp_info WHERE empno='$empno'  ");
        $row = mysql_fetch_array($result);
        $allowance_types = $row['basic_pay'];
        return $allowance_types;
    }

    function getEmployeePensionShareCal($empno, $type)
    {
        $result = mysql_query("SELECT employee_share FROM pensions_tb ");
        $row = mysql_fetch_array($result);
        $employee_shares = $row['employee_share'];
        return $employee_shares;
    }

    function getEmployerPensionShareCal($empno, $type)
    {
        $result = mysql_query("SELECT employer_share FROM pensions_tb ");
        $row = mysql_fetch_array($result);
        $employer_share = $row['employer_share'];
        return $employer_share;
    }

    public function pensionCalculations($empno)
    {
        $query = mysql_query(" SELECT * FROM pensions_tb");
        $row = mysql_fetch_array($query);
        $allowance_types = $row['allowance_type'];
        $employee_share = $row['employee_share'];
        $employer_share = $row['employer_share'];

        $allowance = $this->getEmployeeAllowance($empno, 'basic_pay');

        $pension = (($employee_share + $employer_share) / 100) * $allowance;

        return $pension;
    }

    public function addEmpPayslipInfo($empno, $pay, $dayswork, $otrate, $othrs, $allow, $advances, $insurance, $time, $comission, $company_id, $earnings_id_arg, $deductions_id_arg)
    {
        $result = "";
        $pension = 0;
        $employer_share = 0;
        $employee_share = 0;

        if ($this->checkNhimaStatus() == "true") {
            $nhima = $this->CalclucateNhima($this->getBasicPay($empno), $this->getNhimaSettings());
            //$pay = $this->getBasicPay($empno);//$pay -$nhima;
            if ($empno != "") {

                if ($this->checkPensionStatus() == "true") {
                    $pension = $this->pensionCalculations($empno);
                    $employee_share = ($this->getEmployeePensionShareCal() / 100) * $this->getBasicPay($empno);
                    $employer_share = ($this->getEmployerPensionShareCal() / 100) * $this->getBasicPay($empno);
                }

                // return var_dump($empno, $pay, $dayswork, $otrate, $othrs, $allow, $advances, $insurance, $time, $comission, $company_id, $deductions_id_arg, $earnings_id_arg);
                $result = mysql_query("INSERT INTO employee(empno,pay,
                     dayswork,otrate,othrs
                    ,allow,advances,insurance,time,comission,company_id,health_insurance,pension,employer_share,employee_share, earnings_id, deductions_id) VALUES('$empno','$pay','$dayswork'
                    ,'$otrate','$othrs', '$allow','$advances','$insurance', '$time','$comission','$company_id','$nhima','$pension','$employer_share' ,'$employee_share', '$earnings_id_arg', '$deductions_id_arg'  )") or die(mysql_error());
            }
            return $result;
        } else {
            if ($empno != "") {

                if ($this->checkPensionStatus() == "true") {
                    $pension = $this->pensionCalculations($empno);
                    $employee_share = $this->getEmployeePensionShareCal();
                    $employer_share = $this->getEmployerPensionShareCal();
                }

                $result = mysql_query("INSERT INTO employee(empno,pay,
                     dayswork,otrate,othrs
                    ,allow,advances,insurance,time,comission,company_id,pension,employer_share,employee_share) VALUES('$empno','$pay','$dayswork'
                    ,'$otrate','$othrs', '$allow','$advances','$insurance', '$time','$comission','$company_id','$pension','$employer_share','$employee_share'   )") or die(mysql_error());
            }
            return $result;
        }
    }

    public function checkIfUploadExsists($empno, $date)
    {
        $state = "";
        $result = mysql_query("SELECT * FROM payslip_uploads WHERE empno = '$empno' AND date_period = '$date' ");
        if (mysql_num_rows($result) == 0) {
            $state = "false";
        } else {
            $state = "true";
        }
        return $state;
    }

    public function getPdfPayslip($empno, $date)
    {
        $query = "SELECT * FROM payslip_uploads WHERE empno = '$empno' AND date_period = '$date'";
        $result = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_array($result);
        $pdfPayslip = "../uploads/" . $row['payslip'];
        return $pdfPayslip;
    }

    public function addTax($taxable, $total_tax_paid, $empno, $comp_ID, $date)
    {
        $socialSecNo = 0;
        $result = mysql_query("INSERT INTO tax(taxable_to_date,tax_paid_to_date,empno,company_id,social,date) VALUES($taxable,$total_tax_paid,'$empno'"
            . ",'$comp_ID',$socialSecNo,'$date')");
        return $result;
    }

    public function updateTax($taxable, $total_tax_paid, $empno)
    {
        $result = mysql_query("UPDATE tax SET taxable_to_date = taxable_to_date + $taxable,tax_paid_to_date = tax_paid_to_date + $total_tax_paid WHERE empno= '$empno'");
        return $result;
    }

    public function addLeave($empno)
    {
        $available = 2;
        $result = mysql_query("INSERT INTO leave_days(available,empno) VALUES('$available' ,'$empno')");
        return $result;
    }

    public function editPayslip($days_worked, $overtime_rate_hour, $overtime, $allowance, $advances, $insurance, $commision, $id, $time)
    {
        $res = mysql_query("UPDATE employee SET dayswork = "
            . " '$days_worked',otrate = '$overtime_rate_hour',"
            . "othrs='$overtime',allow='$allowance',advances='$advances',"
            . "insurance='$insurance',comission='$commision',time='$time'  WHERE id= '$id'");

        return $res;
    }

    public function getEditInfo($id)
    {
        $result = mysql_query("SELECT * FROM employee WHERE id = '$id'");
        return $result;
    }

    public function PayslipEditDetails($empno)
    {
        $result = mysql_query("SELECT * FROM emp_info WHERE empno = '$empno'");
        $DetalsRows = mysql_fetch_array($result);
        $fname = $DetalsRows['fname'];
        $lname = $DetalsRows['lname'];
        $payDetails = $fname . " " . $lname;
        return $payDetails;
    }

    public function updateLeave($empno, $companyId)
    {
        // get the employees monthly leave days based on there grade .... 
        $result2 = mysql_query("SELECT * FROM leave_ratings_tb "
            . "WHERE grade_id IN ( SELECT employee_grade FROM emp_info WHERE empno = '$empno' AND company_id = '$companyId' )");
        $DetalsRows = mysql_fetch_array($result2);
        $monthly_leave_days = $DetalsRows['monthly_leave_days'];
        // update the employees leave days.. 
        $result = mysql_query("UPDATE leave_days SET available = available + '$monthly_leave_days' WHERE empno = '$empno' ");
        return $result;
    }

    public function deductLeave($empno, $companyId)
    {
        // get the employees monthly leave days based on there grade .... 
        $result2 = mysql_query("SELECT * FROM leave_ratings_tb "
            . "WHERE grade_id = ( SELECT employee_grade FROM emp_info WHERE empno = '$empno' AND company_id = '$companyId' )");
        $DetalsRows = mysql_fetch_array($result2);
        $monthly_leave_days = $DetalsRows['monthly_leave_days'];
        // update the employees leave days.. 
        $result = mysql_query("UPDATE leave_days SET available = available - '$monthly_leave_days' WHERE empno = '$empno' ");
        return $result;
    }

    public function updateLoans($empno, $interest, $principle)
    {
        $query4 = "UPDATE loan  SET duration  = duration - 1 , interest =  $interest, loan_amt = $principle, principle = $principle  WHERE empno = '$empno'";
        $result = mysql_query($query4);
        return $result;
    }

    public function getDeductionValue($salary, $deducArray)
    {
        // var_dump(mysql_fetch_assoc($deducArray));
        $type = $deducArray['type'];
        // if type is fixed
        if ($type == 'fixed') {
            return $deducArray['emp_fixed'];
        } else
        // otherwise, calculate
        {
            $deductAmount = $salary * ($deducArray['emp_calc_num'] / $deducArray['emp_calc_deno']);
            // check if deduction amount is greater than max
            if ($deductAmount > $deducArray['emp_upper_bound']) {
                $deductAmount = $deducArray['emp_upper_bound_amnt'];
            } else if ($deductAmount > $deducArray['emp_lower_bound']) {
                $deductAmount = $deducArray['emp_lower_bound_amnt'];
            }
            // check if deduction amount is less than minimum
            return $deductAmount;
        }
    }

    public function getEmployeeEarnings($emp_earn_id_arg)
    {
        $query = mysql_query("SELECT * FROM employee_earnings WHERE id = '$emp_earn_id_arg'") or die(mysql_error());
        $sum = 0;
        $data = mysql_fetch_assoc($query);

        $sum = 0;
        $sliced = array_slice($data, 4);

        foreach ($sliced as $key => $value) {
            if ($key === "company_id" || $key === "employee_id" || $key === "id" || $key === "employee_no") {
                $add = false; // Stop adding when 'company_id' is reached
            } elseif (is_numeric($value)) {
                $sum += (float)$value; // Convert to float and add if it's numeric
            }
        }
        // var_dump($sum);
        return $sum;
    }

    public function getEmployeeDeductions($salary_arg, $emp_num_arg, $emp_ded_id_arg)
    {
        $query = mysql_query("SELECT * FROM employee_deductions WHERE id = '$emp_ded_id_arg'") or die(mysql_error());
        $sum = 0;
        $data = mysql_fetch_assoc($query);


        foreach ($data as $key => $value) {
            // key is the column name
            $dQuery = mysql_query("SELECT * FROM deductions WHERE name LIKE '$key'");
            $ded = mysql_fetch_assoc($dQuery);

            if ($value === '1') {
                $ded_value = $this->getDeductionValue($salary_arg, $ded);
                $sum += $ded_value;
            }
        }

        // recurring
        $rdQuery = mysql_query("SELECT * FROM emp_recurring_deductions WHERE employee_no = '$emp_num_arg' && status = 'Pending'") or die(mysql_error());
        $rdRow = mysql_fetch_assoc($rdQuery);

        $sum += $rdRow['monthly_deduct'];

        return $sum;
    }
}
