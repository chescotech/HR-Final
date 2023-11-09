<?php

include_once 'DBClass.php';

class MyPayslips
{

    function __construct()
    {
        $this->link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('db connection problem' . mysqli_connect_error());
    }

    public function getPaySlipRecord($empno, $companyId)
    {
        $res = mysqli_query($this->link, "SELECT * FROM employee WHERE empno = '$empno' AND company_id='$companyId' ORDER BY id DESC");
        return $res;
    }

    public function getLoanMonthDedeductAmounts($empno, $date)
    {
        // $dateFormated = date_format(strtotime($date), "Y/m/d");
        $result = mysqli_query($this->link, "SELECT * FROM loan WHERE empno='$empno' AND status='Pending' AND '$date' BETWEEN loan_date AND date_completion  ") or die(mysqli_error($this->link));
        $rows = mysqli_fetch_array($result);
        $loanAmount = $rows['monthly_deduct'];
        return $loanAmount;
    }
    public function getDeductionValue($salary, $deducArray)
    {
        // var_dump(mysqli_fetch_assoc($deducArray));
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

    public function getRecurringDeductionValue()
    {
        echo "Recurring";
    }

    public function getMyDeductions($salary_arg, $emp_num_arg, $emp_ded_id_arg)
    {
        $query = mysqli_query($this->link, "SELECT * FROM employee_deductions WHERE id = '$emp_ded_id_arg'") or die(mysqli_error($this->link));
        $sum = 0;
        $data = mysqli_fetch_assoc($query);


        foreach ($data as $key => $value) {
            // key is the column name
            $dQuery = mysqli_query($this->link, "SELECT * FROM deductions WHERE name LIKE '$key'");
            $ded = mysqli_fetch_assoc($dQuery);

            if ($value === '1') {
                $ded_value = $this->getDeductionValue($salary_arg, $ded);
                $sum += $ded_value;
            }
        }

        // recurring
        $rdQuery = mysqli_query($this->link, "SELECT * FROM emp_recurring_deductions WHERE employee_no = '$emp_num_arg' && status = 'Pending'") or die(mysqli_error($this->link));
        $rdRow = mysqli_fetch_assoc($rdQuery);

        $sum += $rdRow['monthly_deduct'];

        return $sum;
    }

    public function getEmployeeEarnings($emp_no_arg)
    {
        $query = mysqli_query($this->link, "SELECT * FROM employee_earnings WHERE employee_no = '$emp_no_arg'") or die(mysqli_error($this->link));
        $sum = 0;
        $data = mysqli_fetch_assoc($query);

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

    public function getEmployeeGrossPay($emp_no_arg, $date_arg)
    {
        // Get the month payslip from `employee` table
        $payslipQuery = "SELECT * FROM employee WHERE empno = '$emp_no_arg' AND time = '$date_arg'";

        $payslipResult = mysqli_query($this->link, $payslipQuery) or die("invalid query" . mysqli_error($this->link));
        $payslipRow = mysqli_fetch_array($payslipResult);

        $payslip = $payslipRow['pay'] + ($payslipRow['otrate'] * $payslipRow['othrs']) + $payslipRow['allow'] + $payslipRow['advances'] + $payslipRow['comission'];

        $earn_id = $payslipRow['earnings_id'];
        // Get earnings from `getEmployeeEarnings` function
        $earnings = $this->getEmployeeEarnings($emp_no_arg);

        // Add them up
        $gross = $payslip + $earnings;

        return $gross;
    }
}
