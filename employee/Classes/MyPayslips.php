<?php

class MyPayslips
{
    private $link;

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
        $result = mysqli_query($this->link, "SELECT * FROM loan WHERE empno='$empno' AND '$date' BETWEEN loan_date AND date_completion  ") or die(mysqli_error($this->link));
        if (mysqli_num_rows($result) == 0) {
            return 0;
        } else {
            $rows = mysqli_fetch_array($result);
            $loanAmount = $rows['monthly_deduct'];
            return $loanAmount;
        }
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

    public function getRecurringDeductionValue()
    {
        echo "Recurring";
    }

    public function getMyDeductions($salary_arg, $emp_num_arg, $emp_ded_data)
    {
        $deductions = json_decode($emp_ded_data, true);
        $sum = 0;

        foreach ($deductions[0] as $key => $value) {
            if ($value == '1') {
                $ded_value = $this->getDeductionValue($salary_arg, $key);
                $sum += $ded_value;
            }
        }

        $rdQuery = mysqli_query($this->link, "SELECT * FROM emp_recurring_deductions WHERE employee_no = '$emp_num_arg' && status = 'Pending'") or die(mysqli_error($this->link));
        if (mysqli_num_rows($rdQuery) > 0) {
            $rdRow = mysqli_fetch_assoc($rdQuery);
            $sum += $rdRow['monthly_deduct'];
        }

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

    public function getEmployeeCurrentEarnings($employeeEarningsJson)
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

    public function getEmployeeGrossPay($emp_no_arg, $date_arg)
    {
        // Get the month payslip from `employee` table
        $payslipQuery = "SELECT * FROM employee WHERE empno = '$emp_no_arg' AND time = '$date_arg'";

        $payslipResult = mysqli_query($this->link, $payslipQuery) or die("invalid query" . mysqli_error($this->link));
        $payslipRow = mysqli_fetch_array($payslipResult);

        $payslip = $payslipRow['pay'] + ($payslipRow['otrate'] * $payslipRow['othrs']) + $payslipRow['allow'] + $payslipRow['comission'];

        // $earn_id = $payslipRow['earnings_data'];
        // Get earnings from `getEmployeeEarnings` function
        $earnings = $this->getEmployeeCurrentEarnings($payslipRow['earnings_data']);

        // Add them up
        $gross = $payslip + $earnings;

        return $gross;
    }
}
