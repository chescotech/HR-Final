<?php

class RecurringDeductions
{
    private $link;

    function __construct()
    {
        $this->link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('db connection problem' . mysqli_connect_error());
    }

    public function checkIfEmpHasRD($empno)
    {
        $count = 0;
        $result = mysqli_query($this->link, "SELECT * FROM emp_recurring_deductions WHERE  employee_no = '$empno' ");
        $noRows = mysqli_num_rows($result);
        if ($noRows == 0) {
            $count = 0;
        } else {
            $count = 1;
        }
        return $count;
    }
    public function getEmpDeductionStatus($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_recurring_deductions WHERE  employee_no = '$empno'");
        if (mysqli_num_rows($result) > 0) {
            $rows = mysqli_fetch_array($result);
            $status = $rows['status'];
            return $status;
        } else {
            return "None";
        }
    }
    public function updateDeductInfo($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_recurring_deductions WHERE  employee_no = '$empno'");

        while ($rows = mysqli_fetch_array($result)) {
            $duration = $rows['duration'];
            if ($duration == 1)
            // duration is 1 - set to cleared
            {
                $result2 = mysqli_query($this->link, "UPDATE emp_recurring_deductions  SET duration  = duration - 1, status='Cleared' WHERE employee_no ='$empno'") or die(mysqli_error($this->link));
            } else if ($duration > 1)
            // duration still greater than 1
            {
                $result2 = mysqli_query($this->link, "UPDATE emp_recurring_deductions  SET duration  = duration - 1 WHERE employee_no ='$empno'") or die(mysqli_error($this->link));
            } else
            // duration is 0, no change needed
            {
                return $duration;
            }
        }
    }

    public function addRDeductionType($name_arg, $short_name_arg, $comp_id_arg)
    {
        $result = mysqli_query($this->link, "INSERT INTO recurring_deduction_types(name, short_name, company_id) VALUES('$name_arg', '$short_name_arg', '$comp_id_arg')");

        return $result;
    }

    public function getRecurringDeductionTypes($company_id)
    {
        $result = mysqli_query($this->link, "SELECT * FROM recurring_deduction_types WHERE company_id='$company_id'");
        // $types = mysqli_fetch_array($result);
        return $result;
    }

    public function createRecurringDeduction($emp_id, $empno, $deduction_amount, $monthly_deduction, $duration, $LoanDate, $deadLine, $companyId, $status, $deduction_type)
    {
        $createQuery = mysqli_query($this->link, "INSERT INTO emp_recurring_deductions(employee_id, employee_no, deduction_total, monthly_deduct, duration, deduction_date, date_completion, company_ID, status, deduction_type) VALUES('$emp_id', '$empno', '$deduction_amount', '$monthly_deduction', '$duration', '$LoanDate','$deadLine', '$companyId', '$status', '$deduction_type')") or die(mysqli_error($this->link));

        return $createQuery;
    }
    public function updateRecurringDeduction($empno, $deduction_amount, $monthly_deduction, $duration, $LoanDate, $deadLine, $companyId, $status, $deduction_type)
    {
        $updateQuery = mysqli_query($this->link, "UPDATE emp_recurring_deductions SET 
        deduction_total = '$deduction_amount',
        monthly_deduct = '$monthly_deduction',
        duration = '$duration',
        deduction_date = '$LoanDate',
        date_completion = '$deadLine',
        status = '$status',
        deduction_type = '$deduction_type'
        WHERE AND employee_no = '$empno' AND company_ID = '$companyId'
    ") or die(mysqli_error($this->link));

        return $updateQuery;
    }
    public function getRecurringDeductions($comp_id_arg)
    {
        $fetchQuery = mysqli_query($this->link, "SELECT * FROM emp_recurring_deductions WHERE company_id='$comp_id_arg'");

        return $fetchQuery;
    }
    public function getRecurringDeductionByID($ded_id)
    {
        $fetchQuery = mysqli_query($this->link, "SELECT * FROM emp_recurring_deductions WHERE id='$ded_id'");

        return $fetchQuery;
    }

    function getRecurringDeductionForDateAndEmpno($empno, $dateIssued)
    {
        $deductionAmount = 0;

        // Check if any recurring deductions exist for the employee with state "Pending"
        $recurringDeductQuery = mysqli_query($this->link, "SELECT * FROM emp_recurring_deductions WHERE employee_no='$empno' AND '$dateIssued' BETWEEN deduction_date AND date_completion");

        if (mysqli_num_rows($recurringDeductQuery) > 0) {
            $recurringDeductRows = mysqli_fetch_all($recurringDeductQuery, MYSQLI_ASSOC);

            $deduction_amount = $recurringDeductRows['monthly_deduct'];

            return $deductionAmount;
        } else {
            return 0;
        }
    }
}
