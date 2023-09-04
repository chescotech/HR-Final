<?php

class RecurringDeductions
{
    public function checkIfEmpHasRD($empno)
    {
        $count = 0;
        $result = mysql_query("SELECT * FROM emp_recurring_deductions WHERE  employee_no = '$empno' ");
        $noRows = mysql_num_rows($result);
        if ($noRows == 0) {
            $count = 0;
        } else {
            $count = 1;
        }
        return $count;
    }
    public function getEmpDeductionStatus($empno)
    {
        $result = mysql_query("SELECT * FROM emp_recurring_deductions WHERE  employee_no = '$empno'");
        $rows = mysql_fetch_array($result);
        $status = $rows['status'];
        return $status;
    }
    public function updateDeductInfo($empno)
    {
        $result = mysql_query("SELECT * FROM emp_recurring_deductions WHERE  employee_no = '$empno'");

        while ($rows = mysql_fetch_array($result)) {
            $duration = $rows['duration'];
            if ($duration == 1) {
                $result2 = mysql_query("UPDATE emp_recurring_deductions  SET duration  = duration - 1, status='Cleared' WHERE employee_no ='$empno'");
            } else {
                $result2 = mysql_query("UPDATE emp_recurring_deductions  SET duration  = duration - 1 WHERE employee_no ='$empno'");
            }
        }
        return $result2;
    }
    public function addRDeductionType($name_arg, $short_name_arg, $comp_id_arg)
    {
        $result = mysql_query("INSERT INTO recurring_deduction_types(name, short_name, company_id) VALUES('$name_arg', '$short_name_arg', '$comp_id_arg')");

        return $result;
    }

    public function getRecurringDeductionTypes($company_id)
    {
        $result = mysql_query("SELECT * FROM recurring_deduction_types WHERE company_id='$company_id'");
        // $types = mysql_fetch_array($result);
        return $result;
    }

    public function createRecurringDeduction($emp_id, $empno, $deduction_amount, $monthly_deduction, $duration, $LoanDate, $deadLine, $companyId, $status, $deduction_type)
    {
        $createQuery = mysql_query("INSERT INTO emp_recurring_deductions(employee_id, employee_no, deduction_total, monthly_deduct, duration, deduction_date, date_completion, company_ID, status, deduction_type) VALUES('$emp_id', '$empno', '$deduction_amount', '$monthly_deduction', '$duration', '$LoanDate','$deadLine', '$companyId', '$status', '$deduction_type')") or die(mysql_error());

        return $createQuery;
    }
    public function getRecurringDeductions($comp_id_arg)
    {
        $fetchQuery = mysql_query("SELECT * FROM emp_recurring_deductions WHERE company_id='$comp_id_arg'");

        return $fetchQuery;
    }
    public function getRecurringDeductionByID($ded_id)
    {
        $fetchQuery = mysql_query("SELECT * FROM emp_recurring_deductions WHERE id='$ded_id'");

        return $fetchQuery;
    }
}
