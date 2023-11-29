<?php include_once '../../dbconnection.php';

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
        $result = mysqli_query($this->link, "SELECT * FROM loan WHERE empno='$empno' AND status='Pending' AND '$date' BETWEEN loan_date AND date_completion  ");
        $rows = mysqli_fetch_array($result);
        $loanAmount = $rows['monthly_deduct'];
        return $loanAmount;
    }
}
