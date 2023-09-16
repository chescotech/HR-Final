<?php

include_once './Classes/Tax.php';
include_once './Classes/Loans.php';
// include_once './Classes/Payslips.php';

class Loans
{
    public function getAllEmpLoans($companyId)
    {
        $result = mysql_query("SELECT * FROM loan WHERE company_ID = '$companyId' ");
        return $result;
    }
    public function getLoanApplications($companyId)
    {
        $result = mysql_query("SELECT * from loan_applications WHERE company_ID = '$companyId'");

        return $result;
    }

    function getPAYEExpenseSummary($compId, $year, $month, $day)
    {
        $TaxObject = new Tax();
        $query = "SELECT *
                                                        FROM employee em
                                                        INNER JOIN emp_info n ON em.empno = n.empno                                                     
                                                        WHERE em.company_id =  '$compId' and em.time = '$year-$month-$day'";

        $result = mysql_query($query);
        $sum = 0;
        $GrossTotal = 0;
        $chargableEmTotal = 0;
        $taxPaidTotal = 0;

        while ($row = mysql_fetch_array($result)) {
            $empno = $row['empno'];
            $ssNo = "";
            $fname = $row['fname'];
            $lname = $row['lname'];
            $natureEmployement = $row['employment_type'];
            $gross = ($row['pay']) + ($row['otrate'] * $row['othrs']) + $row['allow'] + $row['comission'];
            $empoyeeNo = $row['empno'];
            $napsa = $gross * 0.05;
            if ($napsa >= 843)
                $napsa = 843;

            $napsa_calc = "";
            if ($napsa >= 255)
                $napsa_calc = 255;

            $band1_top = $TaxObject->getTopBand1($compId);
            $band2_top = $TaxObject->getTopBand2($compId);
            $band3_top = $TaxObject->getTopBand3($compId);

            $band1_rate = $TaxObject->getBandRate1($compId) / 100;
            $band2_rate = $TaxObject->getBandRate2($compId) / 100;
            $band3_rate = $TaxObject->getBandRate3($compId) / 100;
            $band4_rate = $TaxObject->getBandRate4($compId) / 100;

            $starting_income = $income = $gross - $napsa;

            $band1 = $band2 = $band3 = $band4 = 0;

            if ($income > $band3_top) {
                $band4 = ($income - $band3_top) * $band4_rate;
                $income = $band3_top;
            }

            if ($income > $band2_top) {
                $band3 = ($income - $band2_top) * $band3_rate;
                $income = $band2_top;
            }

            if ($income > $band1_top) {
                $band2 = ($income - $band1_top) * $band2_rate;
                $income = $band1_top;
            }

            $band1 = $income * $band1_rate;
            $total_tax_paid = $band1 + $band2 + $band3 + $band4;
            $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa;

            $chargbleEmTaxPeriod = $row['pay'] - ($row['pay'] * 0.05);

            $GrossTotal += $row['pay'];
            $chargableEmTotal += $chargbleEmTaxPeriod;
            $taxPaidTotal += $total_tax_paid;
        }
        return $taxPaidTotal;
    }

    public function addLoanType($loanType, $maxRepaymentTime, $approver_email, $companyID)
    {
        $result = mysql_query("INSERT INTO loan_tb(loan_type,max_repayment,approver_email,company_ID) "
            . "VALUES('$loanType','$maxRepaymentTime','$approver_email' ,'$companyID')");
        return $result;
    }

    function getNAPSAExpenseSummary($compId, $year, $month, $day)
    {

        $TaxObject = new Tax();

        $query = "SELECT *
                                                        FROM employee em
                                                        INNER JOIN emp_info n ON em.empno = n.empno                                                     
                                                        WHERE em.company_id =  '$compId' and em.time = '$year-$month-$day'";

        $result = mysql_query($query);
        $sum = 0;
        while ($row = mysql_fetch_array($result)) {
            $empno = $row['empno'];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $ssNo = "";

            $gross = ($row['pay']) + ($row['otrate'] * $row['othrs']) + $row['allow'];

            $napsa = $gross * 0.05;
            if ($napsa >= 843)
                $napsa = 843;

            $napsa_calc = "";
            if ($napsa >= 255)
                $napsa_calc = 255;

            $band1_top = $TaxObject->getTopBand1($compId);
            $band2_top = $TaxObject->getTopBand2($compId);
            $band3_top = $TaxObject->getTopBand3($compId);

            $band1_rate = $TaxObject->getBandRate1($compId) / 100;
            $band2_rate = $TaxObject->getBandRate2($compId) / 100;
            $band3_rate = $TaxObject->getBandRate3($compId) / 100;
            $band4_rate = $TaxObject->getBandRate4($compId) / 100;

            $starting_income = $income = $gross - $napsa_calc;

            $band1 = $band2 = $band3 = $band4 = 0;

            if ($income > $band3_top) {
                $band4 = ($income - $band3_top) * $band4_rate;
                $income = $band3_top;
            }

            if ($income > $band2_top) {
                $band3 = ($income - $band2_top) * $band3_rate;
                $income = $band2_top;
            }

            if ($income > $band1_top) {
                $band2 = ($income - $band1_top) * $band2_rate;
                $income = $band1_top;
            }

            $band1 = $income * $band1_rate;

            $total_tax_paid = $band1 + $band2 + $band3 + $band4;

            $total = $napsa + $napsa;

            $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa;
            $netpay = $gross - $totdeduct;

            $sum += $total;
        }
        return $sum;
    }

    function getTotalPayrollByYear($compId, $year, $month, $day)
    {

        $TaxObject = new Tax();
        $sum = 0;

        $query = "SELECT * FROM loan where company_ID =  '$compId' AND status='Pending' ";
        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());

        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $balance = $row['loan_amt'];
        $interest = $row['interest'];
        $months = $row['duration'];
        $deduct = $row['monthly_deduct'];

        $band1_top = "";
        $band1_rate = "";
        $band2_top = "";
        $band2_rate = "";
        $band3_top = "";
        $band3_rate = "";
        $band4_rate = "";

        $query = "SELECT *
                                                        FROM employee em
                                                        INNER JOIN emp_info n ON em.empno = n.empno                                                     
                                                        WHERE em.company_id =  '$compId' and em.time = '$year-$month-$day'";

        $result2 = mysql_query($query) or die(mysql_error());

        $sum = 0;
        while ($row = mysql_fetch_array($result2)) {

            $gross = ($row['pay']) + ($row['otrate'] * $row['othrs']) + $row['allow'] + $row['comission'];
            $empoyeeNo = $row['empno'];

            $result = mysql_query("SELECT * FROM loan WHERE empno='$empoyeeNo' AND status='Pending'  ");
            $LoanRows = mysql_fetch_array($result);
            $loanAmount = $LoanRows['monthly_deduct'];

            $napsa = $gross * 0.05;
            if ($napsa >= 843)
                $napsa = 843;

            $napsa_calc = "";
            if ($napsa >= 255)
                $napsa_calc = 255;

            $band1_top = $TaxObject->getTopBand1($compId);
            $band2_top = $TaxObject->getTopBand2($compId);
            $band3_top = $TaxObject->getTopBand3($compId);

            $band1_rate = $TaxObject->getBandRate1($compId) / 100;
            $band2_rate = $TaxObject->getBandRate2($compId) / 100;
            $band3_rate = $TaxObject->getBandRate3($compId) / 100;
            $band4_rate = $TaxObject->getBandRate4($compId) / 100;

            $starting_income = $income = $gross - $napsa;

            $band1 = $band2 = $band3 = $band4 = 0;

            if ($income > $band3_top) {
                $band4 = ($income - $band3_top) * $band4_rate;
                $income = $band3_top;
            }

            if ($income > $band2_top) {
                $band3 = ($income - $band2_top) * $band3_rate;
                $income = $band2_top;
            }

            if ($income > $band1_top) {
                $band2 = ($income - $band1_top) * $band2_rate;
                $income = $band1_top;
            }

            if ($loanAmount == "") {
                $lAmount = 0;
            } else {
                $lAmount = $loanAmount;
            }

            $band1 = $income * $band1_rate;
            $total_tax_paid = $band1 + $band2 + $band3 + $band4;
            $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa + $lAmount;
            $netpay = ($gross - $totdeduct);

            $sum += $netpay;
        }
        return $sum;
    }

    function getPayrollTotalByDepartment($departmentId, $compId)
    {
        $loanObj = new Loans();
        $TaxObject = new Tax();
        $total = 0;
        $query = "SELECT * FROM loan where company_ID =  '$compId' AND status='Pending'";
        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());

        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $balance = $row['loan_amt'];
        $interest = $row['interest'];
        $months = $row['duration'];
        $deduct = $row['monthly_deduct'];
        $band1_top = "";
        $band1_rate = "";
        $band2_top = "";
        $band2_rate = "";
        $band3_top = "";
        $band3_rate = "";
        $band4_rate = "";

        $query2 = "SELECT *
                                                        FROM employee em
                                                        INNER JOIN emp_info n ON em.empno = n.empno                                                     
                                                        WHERE em.company_id =  '$compId' AND n.dept = '$departmentId' ";

        $result2 = mysql_query($query2) or die(mysql_error());

        $sum = 0;
        while ($row = mysql_fetch_array($result2)) {

            $gross = ($row['pay']) + ($row['otrate'] * $row['othrs']) + $row['allow'] + $row['comission'];
            $empoyeeNo = $row['empno'];
            $napsa = $gross * 0.05;
            if ($TaxObject->getEmployeeAge($empoyeeNo) < 55) {
                $napsa = $gross * 0.05;
                if ($napsa >= $TaxObject->getNapsaCeiling($compId))
                    $napsa = $TaxObject->getNapsaCeiling($compId);

                $napsa_calc = "";
                if ($napsa >= 255)
                    $napsa_calc = 255;
            } else {
                $napsa = 0;
            }

            $band1_top = $TaxObject->getTopBand1($compId);
            $band2_top = $TaxObject->getTopBand2($compId);
            $band3_top = $TaxObject->getTopBand3($compId);

            $band1_rate = $TaxObject->getBandRate1($compId) / 100;
            $band2_rate = $TaxObject->getBandRate2($compId) / 100;
            $band3_rate = $TaxObject->getBandRate3($compId) / 100;
            $band4_rate = $TaxObject->getBandRate4($compId) / 100;

            $starting_income = $income = $gross - $napsa;

            $band1 = $band2 = $band3 = $band4 = 0;

            if ($income > $band3_top) {
                $band4 = ($income - $band3_top) * $band4_rate;
                $income = $band3_top;
            }

            if ($income > $band2_top) {
                $band3 = ($income - $band2_top) * $band3_rate;
                $income = $band2_top;
            }

            if ($income > $band1_top) {
                $band2 = ($income - $band1_top) * $band2_rate;
                $income = $band1_top;
            }

            $band1 = $income * $band1_rate;
            $total_tax_paid = $band1 + $band2 + $band3 + $band4;
            $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa + $row['health_insurance'];

            if ($loanObj->getLoanMonthDedeductAmount($empoyeeNo) == "") {
                $lAmount = 0;
            } else {
                $lAmount = $loanObj->getLoanMonthDedeductAmount($empoyeeNo);
            }

            $netpay = ($gross - $totdeduct) - $lAmount;
            $total += $netpay;
        }
        return $total;
    }

    function getDepartmentById($depId)
    {
        $result = mysql_query("SELECT * FROM department WHERE dep_id = '$depId' ");
        $rows = mysql_fetch_array($result);
        $departmentName = $rows['department'];
        return $departmentName;
    }

    function getEmployeeCountByDepartment($department)
    {
        $result = mysql_query("SELECT * FROM emp_info WHERE dept = '$department' ");

        $count = mysql_num_rows($result);
        return $count;
    }

    public function getSocialSecurityNo($empno)
    {
        $result = mysql_query("SELECT social FROM tax WHERE empno = '$empno' ");
        $row = mysql_fetch_array($result);
        $socialNo = $row['social'];
        return $socialNo;
    }

    public function getLoanMonthDedeductAmount($empno)
    {
        $result = mysql_query("SELECT * FROM loan WHERE empno='$empno' AND status='Pending'");
        $rows = mysql_fetch_array($result);
        $loanAmount = $rows['monthly_deduct'];
        return $loanAmount;
    }

    public function getLoanMonthDedeductAmounts($empno, $date)
    {
        $result = mysql_query("SELECT * FROM loan WHERE empno='$empno' AND '$date' BETWEEN loan_date AND date_completion  ");
        $rows = mysql_fetch_array($result);
        $loanAmount = $rows['monthly_deduct'];
        return $loanAmount;
    }

    public function getTopBand1($company_ID)
    {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        $row = mysql_fetch_array($query);
        $bandTop1 = $row['band_top1'];
        return $bandTop1;
    }

    public function getTopBand2($company_ID)
    {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        $row = mysql_fetch_array($query);
        $bandTop1 = $row['band_top2'];
        return $bandTop1;
    }

    public function getTopBand3($company_ID)
    {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        $row = mysql_fetch_array($query);
        $bandTop1 = $row['band_top3'];
        return $bandTop1;
    }

    public function getBandRate1($company_ID)
    {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        $row = mysql_fetch_array($query);
        $band_rate1 = $row['band_rate1'];
        return $band_rate1;
    }

    public function getBandRate2($company_ID)
    {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        $row = mysql_fetch_array($query);
        $band_rate2 = $row['band_rate2'];
        return $band_rate2;
    }

    public function getCompanyLogo($companyId)
    {
        $user_query = mysql_query("SELECT * FROM company where company_ID='$companyId'") or die(mysql_error());
        $row = mysql_fetch_array($user_query);

        $photo = "../company_logos/" . $row['logo'];
        $check_pic = $row['logo'];
        if (!file_exists($photo) || $check_pic == false) {
            $photo = "../company_logos/logo.png";
        }
        return $photo;
    }

    public function getEmployeeAge($empno)
    {
        $query = mysql_query("SELECT bdate FROM emp_info WHERE empno = '$empno'");
        $row = mysql_fetch_array($query);
        $dob = $row['bdate'];
        $from = new DateTime($dob);
        $to = new DateTime('today');
        $age = $from->diff($to)->y;
        return $age;
    }

    public function getBandRate3($company_ID)
    {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        $row = mysql_fetch_array($query);
        $band_rate3 = $row['band_rate3'];
        return $band_rate3;
    }

    public function getBandRate4($company_ID)
    {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        $row = mysql_fetch_array($query);
        $band_rate4 = $row['band_rate4'];
        return $band_rate4;
    }

    public function getEmployeeAnnualtax($companyId, $fromDate, $toDate, $empno, $compId)
    {

        // $PayslipsObject = new Payslips();

        $arr = explode("/", $fromDate);
        list($Getmonth, $Getday, $GetYear) = $arr;

        $year = $GetYear;
        $month = $Getmonth;
        $day = $Getday;

        // to date .. 

        $arr2 = explode("/", $toDate);
        list($Getmonth2, $Getday2, $GetYear2) = $arr2;

        $year2 = $GetYear2;
        $month2 = $Getmonth2;
        $day2 = $Getday2;

        $query = "SELECT * FROM loan where company_id =  '$companyId' AND status='Pending'";
        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());

        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $balance = $row['loan_amt'];
        $interest = $row['interest'];
        $months = $row['duration'];
        $deduct = $row['monthly_deduct'];

        $band1_top = "";
        $band1_rate = "";
        $band2_top = "";
        $band2_rate = "";
        $band3_top = "";
        $band3_rate = "";
        $band4_rate = "";

        $query = "SELECT *
                FROM employee em
                INNER JOIN emp_info n ON em.empno = n.empno                                                     
                WHERE em.company_id =  '$companyId' and em.time BETWEEN '$year-$month-$day'  AND  '$year2-$month2-$day2' AND em.empno = '$empno' ";

        $result2 = mysql_query($query) or die(mysql_error());

        $sum = 0;
        while ($row = mysql_fetch_array($result2)) {
            // $earnings = $PayslipsObject->getEmployeeEarnings($row['earnings_id']);

            $gross = $row['basic_pay'] + ($row['otrate'] * $row['othrs']) + $row['allow'] + $row['comission'];
            $empoyeeNo = $row['empno'];
            $napsa = $gross * 0.05;
            if ($this->getEmployeeAge($empno) < 55) {
                $napsa = $gross * 0.05;
                if ($napsa >= $this->getNapsaCeiling($compId))
                    $napsa = $this->getNapsaCeiling($compId);

                $napsa_calc = "";
                if ($napsa >= 255)
                    $napsa_calc = 255;
            } else {
                $napsa = 0;
            }

            $band1_top = $this->getTopBand1($compId);
            $band2_top = $this->getTopBand2($compId);
            $band3_top = $this->getTopBand3($compId);

            $band1_rate = $this->getBandRate1($compId) / 100;
            $band2_rate = $this->getBandRate2($compId) / 100;
            $band3_rate = $this->getBandRate3($compId) / 100;
            $band4_rate = $this->getBandRate4($compId) / 100;

            $starting_income = $income = $gross - $napsa;

            $band1 = $band2 = $band3 = $band4 = 0;

            if ($income > $band3_top) {
                $band4 = ($income - $band3_top) * $band4_rate;
                $income = $band3_top;
            }

            if ($income > $band2_top) {
                $band3 = ($income - $band2_top) * $band3_rate;
                $income = $band2_top;
            }

            if ($income > $band1_top) {
                $band2 = ($income - $band1_top) * $band2_rate;
                $income = $band1_top;
            }

            $band1 = $income * $band1_rate;
            $total_tax_paid = $band1 + $band2 + $band3 + $band4;
            $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa;

            if ($this->getLoanMonthDedeductAmount($empoyeeNo) == "") {
                $lAmount = 0;
            } else {
                $lAmount = $this->getLoanMonthDedeductAmount($empoyeeNo);
            }

            $netpay = ($gross - $totdeduct) - $lAmount;

            $sum += $totdeduct;
        }

        return number_format($sum);
    }

    public function getNapsaCeiling($company_ID)
    {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        $row = mysql_fetch_array($query);
        $napsa_ceiling = $row['napsa_ceiling'];
        return $napsa_ceiling;
    }

    public function calNoMonthsWorked($empno)
    {
        $query = "SELECT COUNT(*) AS no_months FROM `employee` WHERE empno='$empno'";
        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $no_months = $row['no_months'];
        return $no_months;
    }

    function getGratuityRating()
    {
        $query = "SELECT rating FROM `gratuity_settings_tb` ";
        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $rating = ($row['rating'] / 100);
        return $rating;
    }

    public function getEmployeeGratuity($emp_no)
    {
        $query = "SELECT gatuity_amount FROM `emp_info` WHERE empno='$emp_no' ";
        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $rating = ($row['gatuity_amount'] / 100);
        return $rating;
    }

    public function empHasGratuity($emp_no)
    {
        $query = "SELECT empno FROM `emp_info` WHERE empno='$emp_no' AND has_gratuity='Yes' AND gatuity_amount > '0' ";
        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $total_gratuity = ($row['empno']);
        return $total_gratuity;
    }

    public function getEmployeeCurrentGratuity($emp_no)
    {
        $query = "SELECT total_gratuity FROM `emp_info` WHERE empno='$emp_no' AND has_gratuity='Yes' AND gatuity_amount > '0' ";
        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $total_gratuity = ($row['total_gratuity']);
        return intval($total_gratuity);
    }

    public function updateEmployeeCurrentGratuity($emp_no, $new_grat)
    {
        $query = "UPDATE emp_info SET total_gratuity ='$new_grat' WHERE empno='$emp_no' ";
        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());
        return $result;
    }

    public function getPensions($companyId, $empno)
    {
        $TaxObject = new Tax();

        $query = "SELECT * FROM loan where company_id =  '$companyId' AND status='Pending'";
        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());

        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $balance = $row['loan_amt'];
        $interest = $row['interest'];
        $months = $row['duration'];
        $deduct = $row['monthly_deduct'];

        $band1_top = "";
        $band1_rate = "";
        $band2_top = "";
        $band2_rate = "";
        $band3_top = "";
        $band3_rate = "";
        $band4_rate = "";

        $query = "SELECT *
                FROM employee em
                INNER JOIN emp_info n ON em.empno = n.empno                                                     
                WHERE em.company_id =  '$companyId' AND em.empno = '$empno' ";

        $result2 = mysql_query($query) or die(mysql_error());

        $sum = 0;
        while ($row = mysql_fetch_array($result2)) {

            $gross = ($row['pay']) + ($row['otrate'] * $row['othrs']) + $row['allow'] + $row['comission'];
            $empoyeeNo = $row['empno'];
            $napsa = $gross * 0.05;
            if ($TaxObject->getEmployeeAge($row['empno']) < 55) {
                $napsa = $gross * 0.05;
                if ($napsa >= $TaxObject->getNapsaCeiling($compId))
                    $napsa = $TaxObject->getNapsaCeiling($compId);

                $napsa_calc = "";
                if ($napsa >= 255)
                    $napsa_calc = 255;
            } else {
                $napsa = 0;
            }

            $band1_top = $TaxObject->getTopBand1($companyId);
            $band2_top = $TaxObject->getTopBand2($companyId);
            $band3_top = $TaxObject->getTopBand3($companyId);

            $band1_rate = $TaxObject->getBandRate1($companyId) / 100;
            $band2_rate = $TaxObject->getBandRate2($companyId) / 100;
            $band3_rate = $TaxObject->getBandRate3($companyId) / 100;
            $band4_rate = $TaxObject->getBandRate4($companyId) / 100;

            $starting_income = $income = $gross - $napsa;

            $band1 = $band2 = $band3 = $band4 = 0;

            if ($income > $band3_top) {
                $band4 = ($income - $band3_top) * $band4_rate;
                $income = $band3_top;
            }

            if ($income > $band2_top) {
                $band3 = ($income - $band2_top) * $band3_rate;
                $income = $band2_top;
            }

            if ($income > $band1_top) {
                $band2 = ($income - $band1_top) * $band2_rate;
                $income = $band1_top;
            }

            $band1 = $income * $band1_rate;
            $total_tax_paid = $band1 + $band2 + $band3 + $band4;
            $totdeduct = $napsa + $napsa;

            if ($this->getLoanMonthDedeductAmount($empoyeeNo) == "") {
                $lAmount = 0;
            } else {
                $lAmount = $this->getLoanMonthDedeductAmount($empoyeeNo);
            }

            $netpay = ($gross - $totdeduct) - $lAmount;

            $sum += $totdeduct;
        }

        return number_format($sum);
    }

    public function getPensionsTotal($empno)
    {
        $TaxObject = new Tax();

        $query = "SELECT SUM(pension) AS pension  FROM `employee` where empno='$empno' ";
        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());

        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $pension = $row['pension'];

        return $pension;
    }

    public function getEmployeePensionTotal($empno)
    {
        $TaxObject = new Tax();

        $query = "SELECT SUM(employer_share) AS employer_share  FROM `employee` where empno='$empno' ";
        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());

        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $employer_share = $row['employer_share'];

        return $employer_share;
    }

    public function getEmployerPensionTotal($empno)
    {
        $TaxObject = new Tax();

        $query = "SELECT SUM(employee_share) AS employee_share  FROM `employee` where empno='$empno' ";
        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());

        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $employee_share = $row['employee_share'];

        return $employee_share;
    }


    public function getEmployeePension($companyId, $empno)
    {

        $query = "SELECT * FROM loan where company_id =  '$companyId' AND status='Pending'";
        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());

        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $balance = $row['loan_amt'];
        $interest = $row['interest'];
        $months = $row['duration'];
        $deduct = $row['monthly_deduct'];

        $band1_top = "";
        $band1_rate = "";
        $band2_top = "";
        $band2_rate = "";
        $band3_top = "";
        $band3_rate = "";
        $band4_rate = "";

        $query = "SELECT *
                FROM employee em
                INNER JOIN emp_info n ON em.empno = n.empno                                                     
                WHERE em.company_id =  '$companyId' AND em.empno = '$empno' ";

        $result2 = mysql_query($query) or die(mysql_error());

        $sum = 0;
        while ($row = mysql_fetch_array($result2)) {

            $gross = ($row['pay']) + ($row['otrate'] * $row['othrs']) + $row['allow'] + $row['comission'];
            $empoyeeNo = $row['empno'];
            $napsa = $gross * 0.05;
            if ($napsa >= 843)
                $napsa = 843;

            $napsa_calc = "";
            if ($napsa >= 255)
                $napsa_calc = 255;

            $band1_top = 3000;
            $band2_top = 3800;
            $band3_top = 5900;

            $band1_rate = 0;
            $band2_rate = 0.25;
            $band3_rate = 0.30;
            $band4_rate = 0.35;

            $starting_income = $income = $gross - $napsa;

            $band1 = $band2 = $band3 = $band4 = 0;

            if ($income > $band3_top) {
                $band4 = ($income - $band3_top) * $band4_rate;
                $income = $band3_top;
            }

            if ($income > $band2_top) {
                $band3 = ($income - $band2_top) * $band3_rate;
                $income = $band2_top;
            }

            if ($income > $band1_top) {
                $band2 = ($income - $band1_top) * $band2_rate;
                $income = $band1_top;
            }

            $band1 = $income * $band1_rate;
            $total_tax_paid = $band1 + $band2 + $band3 + $band4;
            $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa;

            if ($this->getLoanMonthDedeductAmount($empoyeeNo) == "") {
                $lAmount = 0;
            } else {
                $lAmount = $this->getLoanMonthDedeductAmount($empoyeeNo);
            }

            $sum += $totdeduct;
        }

        return number_format($sum);
    }

    public function getTotalpension($companyId, $empno)
    {
        $query = "SELECT * FROM loan where company_id =  '$companyId' AND status='Pending'";
        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());

        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $balance = $row['loan_amt'];
        $interest = $row['interest'];
        $months = $row['duration'];
        $deduct = $row['monthly_deduct'];

        $band1_top = "";
        $band1_rate = "";
        $band2_top = "";
        $band2_rate = "";
        $band3_top = "";
        $band3_rate = "";
        $band4_rate = "";

        $query = "SELECT *
                FROM employee em
                INNER JOIN emp_info n ON em.empno = n.empno                                                     
                WHERE em.company_id =  '$companyId' AND em.empno = '$empno' ";

        $result2 = mysql_query($query) or die(mysql_error());

        $sum = 0;
        while ($row = mysql_fetch_array($result2)) {

            $gross = ($row['pay']) + ($row['otrate'] * $row['othrs']) + $row['allow'] + $row['comission'];
            $empoyeeNo = $row['empno'];
            $napsa = $gross * 0.05;
            if ($napsa >= 843)
                $napsa = 843;

            $napsa_calc = "";
            if ($napsa >= 255)
                $napsa_calc = 255;

            $band1_top = 3000;
            $band2_top = 3800;
            $band3_top = 5900;

            $band1_rate = 0;
            $band2_rate = 0.25;
            $band3_rate = 0.30;
            $band4_rate = 0.35;

            $starting_income = $income = $gross - $napsa;

            $band1 = $band2 = $band3 = $band4 = 0;

            if ($income > $band3_top) {
                $band4 = ($income - $band3_top) * $band4_rate;
                $income = $band3_top;
            }

            if ($income > $band2_top) {
                $band3 = ($income - $band2_top) * $band3_rate;
                $income = $band2_top;
            }

            if ($income > $band1_top) {
                $band2 = ($income - $band1_top) * $band2_rate;
                $income = $band1_top;
            }

            $band1 = $income * $band1_rate;
            $total_tax_paid = $band1 + $band2 + $band3 + $band4;
            $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa;

            if ($this->getLoanMonthDedeductAmount($empoyeeNo) == "") {
                $lAmount = 0;
            } else {
                $lAmount = $this->getLoanMonthDedeductAmount($empoyeeNo);
            }

            $sum += $totdeduct;
        }

        return $sum;
    }

    public function getTotalAnnualSum($companyId, $fromDate, $toDate, $empno, $compId)
    {

        $arr = explode("/", $fromDate);
        list($Getmonth, $Getday, $GetYear) = $arr;

        $year = $GetYear;
        $month = $Getmonth;
        $day = $Getday;

        // to date .. 

        $arr2 = explode("/", $toDate);
        list($Getmonth2, $Getday2, $GetYear2) = $arr2;

        $year2 = $GetYear2;
        $month2 = $Getmonth2;
        $day2 = $Getday2;

        $query = "SELECT * FROM loan where company_id =  '$companyId' AND status='Pending'";
        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());

        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $balance = $row['loan_amt'];
        $interest = $row['interest'];
        $months = $row['duration'];
        $deduct = $row['monthly_deduct'];

        $band1_top = "";
        $band1_rate = "";
        $band2_top = "";
        $band2_rate = "";
        $band3_top = "";
        $band3_rate = "";
        $band4_rate = "";

        $query = "SELECT *
                FROM employee em
                INNER JOIN emp_info n ON em.empno = n.empno                                                     
                WHERE em.company_id =  '$companyId' and em.time BETWEEN '$year-$month-$day'  AND  '$year2-$month2-$day2' AND em.empno = '$empno' ";

        $result2 = mysql_query($query) or die(mysql_error());

        $sum = 0;
        while ($row = mysql_fetch_array($result2)) {

            $gross = ($row['pay']) + ($row['otrate'] * $row['othrs']) + $row['allow'] + $row['comission'];
            $empoyeeNo = $row['empno'];
            $napsa = $gross * 0.05;
            if ($napsa >= 843)
                $napsa = 843;

            $napsa_calc = "";
            if ($napsa >= 255)
                $napsa_calc = 255;

            $band1_top = $this->getTopBand1($compId);
            $band2_top = $this->getTopBand2($compId);
            $band3_top = $this->getTopBand3($compId);

            $band1_rate = $this->getBandRate1($compId) / 100;
            $band2_rate = $this->getBandRate2($compId) / 100;
            $band3_rate = $this->getBandRate3($compId) / 100;
            $band4_rate = $this->getBandRate4($compId) / 100;

            $starting_income = $income = $gross - $napsa;

            $band1 = $band2 = $band3 = $band4 = 0;

            if ($income > $band3_top) {
                $band4 = ($income - $band3_top) * $band4_rate;
                $income = $band3_top;
            }

            if ($income > $band2_top) {
                $band3 = ($income - $band2_top) * $band3_rate;
                $income = $band2_top;
            }

            if ($income > $band1_top) {
                $band2 = ($income - $band1_top) * $band2_rate;
                $income = $band1_top;
            }

            $band1 = $income * $band1_rate;
            $total_tax_paid = $band1 + $band2 + $band3 + $band4;
            $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa;

            if ($this->getLoanMonthDedeductAmount($empoyeeNo) == "") {
                $lAmount = 0;
            } else {
                $lAmount = $this->getLoanMonthDedeductAmount($empoyeeNo);
            }

            $netpay = ($gross - $totdeduct) - $lAmount;

            $sum += $totdeduct;
        }

        return $sum;
    }

    public function getEmpDetails($empno)
    {
        $result = mysql_query("SELECT * FROM emp_info WHERE empno='$empno' ");
        return $result;
    }

    public function getEmpDetailsByID($emp_id)
    {
        $result = mysql_query("SELECT * FROM emp_info WHERE id='$emp_id' ");
        return $result;
    }

    public function addLoan($empno, $loan_amount, $monthly_deduction, $duration, $companyId, $principle, $interest_rate, $intrest, $LoanDate, $deadLine, $status, $loan_type)
    {
        $result = mysql_query("INSERT INTO loan(empno,loan_amt,"
            . " monthly_deduct,duration,company_ID,principle"
            . ",interest_rate,interest,loan_date,date_completion,status, loan_type"
            . ") VALUES('$empno','$loan_amount','$monthly_deduction'"
            . ",'$duration','$companyId', '$principle','$interest_rate',"
            . "'$intrest','$LoanDate','$deadLine','$status', '$loan_type')");
        return $result;
    }

    public function editLoan($id, $loan_amount, $monthly_deduction, $duration, $principle, $intrest_rate, $interest)
    {
        $result = mysql_query("UPDATE loan SET loan_amt ='$loan_amount',monthly_deduct='$monthly_deduction',"
            . "duration='$duration',principle='$principle',interest_rate='$intrest_rate',interest='$interest' "
            . "  WHERE LOAN_NO= '$id'");
        return $result;
    }

    public function getEmployeeToEdit($id)
    {
        $result = mysql_query("SELECT * FROM loan WHERE  LOAN_NO='$id' ");
        return $result;
    }

    public function getEmployeeDet($id)
    {
        $result = mysql_query("SELECT * FROM emp_info WHERE empno= ( SELECT empno FROM loan WHERE LOAN_NO = '$id') ");
        $rows = mysql_fetch_array($result);
        $fname = $rows['fname'];
        $lname = $rows['lname'];
        $empDetals = $fname . " " . $lname;
        return $empDetals;
    }

    public function checkIfEmpHasLoan($empno)
    {
        $count = 0;
        $result = mysql_query("SELECT * FROM loan WHERE  empno = '$empno' ");
        $noRows = mysql_num_rows($result);
        if ($noRows == 0) {
            $count = 0;
        } else {
            $count = 1;
        }
        return $count;
    }

    function getBasicPaySummary($date)
    {
    }

    public function getEmpLoanStatus($empno)
    {
        $result = mysql_query("SELECT * FROM loan WHERE  empno = '$empno'");
        $rows = mysql_fetch_array($result);
        $status = $rows['status'];
        return $status;
    }

    public function updateLoanInfo($empno)
    {
        $result = mysql_query("SELECT * FROM loan WHERE  empno = '$empno'");
        $rows = mysql_fetch_array($result);
        $duration = $rows['duration'];
        if ($duration == 1) {
            $result2 = mysql_query("UPDATE loan  SET duration  = duration - 1, status='Cleared' WHERE empno ='$empno'");
        } else {
            $result2 = mysql_query("UPDATE loan  SET duration  = duration - 1 WHERE empno ='$empno'");
        }
        return $result2;
    }
}
