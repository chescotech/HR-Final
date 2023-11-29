<?php

class Loan
{
    private $link;
    function __construct()
    {
        $this->link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('db connection problem' . mysqli_connect_error());
    }

    public function applyLoan($amount, $loanType, $empNo, $loanDuration, $loanInstallment, $loanStartDate, $loanEndDate, $compID)
    {
        $status = "Pending";
        $today = date("Y-m-d");
        $res = mysqli_query($this->link, "INSERT INTO loan_applications(loan_amt,loan_type,"
            . "empno,status,loan_date,monthly_deduct,duration,interest, date_completion, company_ID, level)"
            . " VALUES('$amount','$loanType','$empNo','$status','$today','$loanInstallment'"
            . ",'$loanDuration','', '$loanEndDate', '$compID', '1')") or die(mysqli_error($this->link));
        return $res;
    }

    public function getLoanTypes($companyId)
    {
        $result = mysqli_query($this->link, "SELECT * FROM loan_tb WHERE company_ID = '$companyId' ");
        return $result;
    }
}
