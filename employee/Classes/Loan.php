<?php

include_once 'DBClass.php';

class Loan
{
    function __construct()
    {
        $conn = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die('db connection problem' . mysql_error());
        mysql_select_db(DB_NAME, $conn);
    }

    public function applyLoan($amount, $loanType, $empNo, $loanDuration, $loanInstallment, $loanStartDate, $loanEndDate, $compID)
    {
        $status = "Pending";
        $today = date("Y-m-d");
        $res = mysql_query("INSERT INTO loan_applications(loan_amt,loan_type,"
            . "empno,status,loan_date,monthly_deduct,duration,interest, date_completion, company_ID, level)"
            . " VALUES('$amount','$loanType','$empNo','$status','$today','$loanInstallment'"
            . ",'$loanDuration','', '$loanEndDate', '$compID', '1')") or die(mysql_error());
        return $res;
    }

    public function getLoanTypes($companyId)
    {
        $result = mysql_query("SELECT * FROM loan_tb WHERE company_ID = '$companyId' ");
        return $result;
    }
}
