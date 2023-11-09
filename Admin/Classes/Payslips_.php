<?php include_once '../../dbconnection.php';

class Payslips
{

    function __construct()
    {
        $this->link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('db connection problem' . mysqli_connect_error());
    }

    public function addLoan($empno, $loan_amount, $monthly_deduction, $duration, $companyId, $principle, $interest_rate, $intrest)
    {
        $result = mysqli_query($this->link, "INSERT INTO loan(empno,loan_amt,"
            . " monthly_deduct,duration,company_ID,principle"
            . ",interest_rate,interest) VALUES('$empno','$loan_amount','$monthly_deduction'"
            . ",'$duration','$companyId', '$principle','$interest_rate','$intrest')");
        return $result;
    }

    function addDisplineRecord($empno, $date_charged, $offense_commited, $case_status, $punishment, $charged_by)
    {
        $result = mysqli_query($this->link, "INSERT INTO employee_discplinary_records(empno,date_charged,"
            . " offence_commited,case_status,punishment,charged_by) VALUES('$empno','$date_charged','$offense_commited'"
            . ",'$case_status','$punishment', '$charged_by')");
        return $result;
    }

    function updateDiscplineRecord($empno, $date_charged, $offense_commited, $case_status, $punishment, $charged_by, $id)
    {
        $result = mysqli_query($this->link, "UPDATE employee_discplinary_records SET empno = '$empno', "
            . "date_charged = '$date_charged',offence_commited = '$offense_commited', "
            . "case_status = '$case_status', punishment='$punishment',charged_by = '$charged_by'  WHERE id= '$id'");
        return $result;
    }

    public function checkIfRecordExsists($empno, $date)
    {
        $status = "";
        $query = mysqli_query($this->link, " SELECT * FROM employee WHERE empno = '$empno' AND time = '$date' ");
        if (mysqli_num_rows($query) != 0) {
            $status = "true";
        } else {
            $status = "false";
        }
        return $status;
    }

    public function checkNhimaStatus()
    {
        $status = "";
        $query = mysqli_query($this->link, " SELECT * FROM nhima_tb");
        $row = mysqli_fetch_array($query);
        $nhema_status = $row['status'];
        if (mysqli_num_rows($query) == 0 || $nhema_status != "Active") {
            $status = "false";
        } else if (mysqli_num_rows($query) > 0 && $nhema_status == "Active") {
            $status = "true";
        }
        return $status;
    }

    public function checkPensionStatus()
    {
        $status = "";
        $query = mysqli_query($this->link, " SELECT * FROM pensions_tb");
        $row = mysqli_fetch_array($query);
        $nhema_status = $row['status'];
        if (mysqli_num_rows($query) == 0 || $nhema_status != "Active") {
            $status = "false";
        } else if (mysqli_num_rows($query) > 0 && $nhema_status == "Active") {
            $status = "true";
        }
        return $status;
    }

    public function getNhimaSettings()
    {
        $query = mysqli_query($this->link, " SELECT * FROM nhima_tb");
        $row = mysqli_fetch_array($query);
        $nhema_percentage = $row['amount'];
        return $nhema_percentage;
    }

    public function getBasicPay($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$empno'");
        $grossRows = mysqli_fetch_array($result);
        $basic_pay = $grossRows['basic_pay'];
        return $basic_pay;
    }

    public function CalclucateNhima($basicPay, $nhimaSetings)
    {
        $nhima = ($nhimaSetings / 100) * $basicPay;
        return $nhima;
    }

    function getEmployeeAllowance($empno, $type)
    {
        $result = mysqli_query($this->link, "SELECT basic_pay FROM emp_info WHERE empno='$empno'  ");
        $row = mysqli_fetch_array($query);
        $allowance_types = $row['basic_pay'];
        return $allowance_types;
    }

    public function pensionCalculations($empno)
    {
        $query = mysqli_query($this->link, " SELECT * FROM pensions_tb");
        $row = mysqli_fetch_array($query);
        $allowance_types = $row['allowance_type'];
        $employee_share = $row['employee_share'];
        $employer_share = $row['employer_share'];

        $allowance = getEmployeeAllowance($empno, 'basic_pay');

        $pension = (($employee_share + $employer_share) / 100) * $allowance;

        return $pension;
    }

    public function addEmpPayslipInfo($empno, $pay, $dayswork, $otrate, $othrs, $allow, $advances, $insurance, $time, $comission, $company_id)
    {
        $pension = 0;
        if ($this->checkNhimaStatus() == "true") {

            if ($this->checkPensionStatus() == "true") {
                $pension = $this->pensionCalculations($empno);
            }

            $nhima = $this->CalclucateNhima($this->getBasicPay($empno), $this->getNhimaSettings());
            //$pay = $this->getBasicPay($empno);//$pay -$nhima;
            $result = mysqli_query($this->link, "INSERT INTO employee(empno,pay,"
                . " dayswork,otrate,othrs"
                . ",allow,advances,insurance,time,comission,company_id,health_insurance,pension) VALUES('$empno','$pay','$dayswork'"
                . ",'$otrate','$othrs', '$allow','$advances','$insurance', '$time','$comission','$company_id','$nhima','$pension)");
            return $result;
        } else {

            if ($this->checkPensionStatus() == "true") {
                $pension = $this->pensionCalculations($empno);
            }

            $result = mysqli_query($this->link, "INSERT INTO employee(empno,pay,"
                . " dayswork,otrate,othrs"
                . ",allow,advances,insurance,time,comission,company_id,pension) VALUES('$empno','$pay','$dayswork'"
                . ",'$otrate','$othrs', '$allow','$advances','$insurance', '$time','$comission','$company_id','$pension')");
            return $result;
        }
    }

    public function checkIfUploadExsists($empno, $date)
    {
        $state = "";
        $result = mysqli_query($this->link, "SELECT * FROM payslip_uploads WHERE empno = '$empno' AND date_period = '$date' ");
        if (mysqli_num_rows($result) == 0) {
            $state = "false";
        } else {
            $state = "true";
        }
        return $state;
    }

    public function getPdfPayslip($empno, $date)
    {
        $query = "SELECT * FROM payslip_uploads WHERE empno = '$empno' AND date_period = '$date'";
        $result = mysqli_query($this->link, $query) or die(mysqli_error($this->link));
        $row = mysqli_fetch_array($result);
        $pdfPayslip = "../uploads/" . $row['payslip'];
        return $pdfPayslip;
    }

    public function addTax($taxable, $total_tax_paid, $empno, $comp_ID)
    {
        $socialSecNo = 0;
        $result = mysqli_query($this->link, "INSERT INTO tax(taxable_to_date,tax_paid_to_date,empno,company_id,social) VALUES($taxable,$total_tax_paid,'$empno'"
            . ",'$comp_ID',$socialSecNo)");
        return $result;
    }

    public function updateTax($taxable, $total_tax_paid, $empno)
    {
        $result = mysqli_query($this->link, "UPDATE tax SET taxable_to_date = taxable_to_date + $taxable,tax_paid_to_date = tax_paid_to_date + $total_tax_paid WHERE empno= '$empno'");
        return $result;
    }

    public function addLeave($empno)
    {
        $available = 2;
        $result = mysqli_query($this->link, "INSERT INTO leave_days(available,empno) VALUES('$available' ,'$empno')");
        return $result;
    }

    public function editPayslip($days_worked, $overtime_rate_hour, $overtime, $allowance, $advances, $insurance, $commision, $id, $time)
    {
        $res = mysqli_query($this->link, "UPDATE employee SET dayswork = "
            . " '$days_worked',otrate = '$overtime_rate_hour',"
            . "othrs='$overtime',allow='$allowance',advances='$advances',"
            . "insurance='$insurance',comission='$commision',time='$time'  WHERE id= '$id'");

        return $res;
    }

    public function getEditInfo($id)
    {
        $result = mysqli_query($this->link, "SELECT * FROM employee WHERE id = '$id'");
        return $result;
    }

    public function PayslipEditDetails($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno = '$empno'");
        $DetalsRows = mysqli_fetch_array($result);
        $fname = $DetalsRows['fname'];
        $lname = $DetalsRows['lname'];
        $payDetails = $fname . " " . $lname;
        return $payDetails;
    }

    public function updateLeave($empno, $companyId)
    {
        // get the employees monthly leave days based on there grade .... 
        $result2 = mysqli_query($this->link, "SELECT * FROM leave_ratings_tb "
            . "WHERE grade_id = ( SELECT employee_grade FROM emp_info WHERE empno = '$empno' AND company_id = '$companyId' )");
        $DetalsRows = mysqli_fetch_array($result2);
        $monthly_leave_days = $DetalsRows['monthly_leave_days'];
        // update the employees leave days.. 
        $result = mysqli_query($this->link, "UPDATE leave_days SET available = available + '$monthly_leave_days' WHERE empno = '$empno' ");
        return $result;
    }

    public function updateLoans($empno, $interest, $principle)
    {
        $query4 = "UPDATE loan  SET duration  = duration - 1 , interest =  $interest, loan_amt = $principle, principle = $principle  WHERE empno = '$empno'";
        $result = mysqli_query($this->link, $query4);
        return $result;
    }
}
