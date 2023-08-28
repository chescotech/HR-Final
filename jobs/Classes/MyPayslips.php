<?php

include_once 'DBClass.php';

class MyPayslips {

    function __construct() {
        $conn = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die('db connection problem' . mysql_error());
        mysql_select_db(DB_NAME, $conn);
    }

    public function getPaySlipRecord($empno, $companyId) {
        $res = mysql_query("SELECT * FROM employee WHERE empno = '$empno' AND company_id='$companyId' ORDER BY id DESC");
        return $res;
    }

    public function getLoanMonthDedeductAmounts($empno, $date) {
// $dateFormated = date_format(strtotime($date), "Y/m/d");
        $result = mysql_query("SELECT * FROM loan WHERE empno='$empno' AND status='Pending' AND '$date' BETWEEN loan_date AND date_completion  ");
        $rows = mysql_fetch_array($result);
        $loanAmount = $rows['monthly_deduct'];
        return $loanAmount;
    }

}
