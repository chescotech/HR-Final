<?php

class RecurringDeductions
{
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

    public function createRecurringDeduction($empno, $deduction_amount, $monthly_deduction, $duration, $LoanDate, $deadLine, $companyId, $status, $deduction_type)
    {
        $createQuery = mysql_query("INSERT INTO emp_recurring_deductions(employee_id, employee_no, deduction_total, monthly_deduct, duration, deduction_date, date_completion, company_ID, status, deduction_type) VALUES('$empno','$empno', '$deduction_amount', '$monthly_deduction', '$duration', '$LoanDate','$deadLine', '$companyId', '$status', '$deduction_type')") or die(mysql_error());

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
