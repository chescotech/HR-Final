<?php

include_once '../Classes/Department.php';

require('../fpdf/fpdf.php');
include_once '../Classes/Tax.php';
include_once '../Classes/Loans.php';
include_once '../Classes/Tax.php';

$LoanObject = new Loans();
$DepartmentObject = new Department();
$TaxObject = new Tax();
session_start();

$searchDate = $_POST['search_date'];
$compId = $_SESSION['company_ID'];

$CompanyName = $_SESSION['name'];
$printCompanyName = strtoupper($CompanyName);

$mydate = strtoTime($searchDate);
$printdate = date('F d, Y', $mydate);

$reportDate = $searchDate;
$arr = explode("/", $reportDate);
list($Getmonth, $Getday, $GetYear) = $arr;

include_once '../Classes/Company.php';
$CompanyObject = new Company();
$userId = $_SESSION['user_id'];

// date printed ..
$datePrinted = strtoTime(date("Y/m/d"));
$datePrint = date('F d, Y', $datePrinted);

$year = $GetYear;
$month = $Getmonth;
$day = $Getday;
$image = "logo.png";

$BTotal = 0;
$overtimeTotal = 0;
$napsaTotal = 0;
$payeTotal = 0;
$salaryAdvanceTotal = 0;
$loanTotal = 0;
$total = 0;
$creditTotal = 0;
$netPayTotal = 0;

$pdf = new FPDF();
$pdf->AddPage('P', 'A4');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln();

$pdf->SetTitle("PAYROLL EXPENSE SUMMARY");

$pdf->Image($TaxObject->getCompanyLogo($compId), 35, 2, 150, 40, "JPG");

$pdf->Cell(450, 35, " ");
$pdf->Ln();
$pdf->MultiCell(0, 10, $printCompanyName . "  PAYROLL EXPENSE SUMMARY FOR  " . strtoupper($printdate), 0, 'C');
$pdf->Cell(450, 7, "________________________________________________________________________________________________________________________________________________");
$pdf->Ln();

$pdf->Cell(80, 9, "Expense Description");
$pdf->Cell(60, 9, "Debit");
$pdf->Cell(85, 9, "Credit");


$pdf->Ln();
$pdf->Cell(450, 2, "________________________________________________________________________________________________________________________________________________");
$pdf->Ln();


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
    $gross = ($row['pay'] ) + ($row['otrate'] * $row['othrs']) + $row['allow'] + $row['comission'];
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

    $chargbleEmTaxPeriod = $row['pay'] - ($row['pay'] * 0.05);

    $GrossTotal += $row['pay'];
    $chargableEmTotal += $chargbleEmTaxPeriod;
    $taxPaidTotal +=$total_tax_paid;

    $date = $row['time'];
    $res = mysql_query("SELECT * FROM loan WHERE empno='$empoyeeNo' AND '$date' BETWEEN loan_date AND date_completion ");
    $LoanRows = mysql_fetch_array($res);
    $lAmount = $LoanRows['monthly_deduct'];

    $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa + $lAmount;

    $netpay = $gross - $totdeduct;
    $netPayTotal += $netpay;
   
    $BTotal += $gross;
    $overtimeTotal += $row['otrate'];
    $napsaTotal += $napsa;
    $payeTotal = $LoanObject->getPAYEExpenseSummary($compId, $year, $month, $day);
    $salaryAdvanceTotal += $row['advances'];
    $loanTotal += $lAmount;
    $total = $BTotal + $overtimeTotal + $napsaTotal;
}

$pdf->Cell(80, 7, "Basic Pay");
$pdf->Cell(60, 7, number_format($BTotal, 2));
$pdf->Cell(85, 7, "");
$pdf->Ln();

$pdf->Cell(80, 7, "Transport Allowance");
$pdf->Cell(60, 7, "0.00");
$pdf->Cell(85, 7, "");
$pdf->Ln();

$pdf->Cell(80, 7, "House Allowance");
$pdf->Cell(60, 7, "0.00");
$pdf->Cell(85, 7, "");
$pdf->Ln();

$pdf->Cell(80, 7, "Lunch Allowance");
$pdf->Cell(60, 7, "0.00");
$pdf->Cell(85, 7, "");
$pdf->Ln();

$pdf->Cell(80, 7, "Overtime");
$pdf->Cell(60, 7, number_format($overtimeTotal, 2));
$pdf->Cell(85, 7, "");
$pdf->Ln();


$pdf->Cell(80, 7, "Gratuity");
$pdf->Cell(60, 7, "0.00");
$pdf->Cell(85, 7, "");
$pdf->Ln();

$pdf->Cell(80, 7, "Leave Pay");
$pdf->Cell(60, 7, "0.00");
$pdf->Cell(85, 7, "");
$pdf->Ln();

$pdf->Cell(80, 7, "Employer NAPSA");
$pdf->Cell(60, 7, number_format($napsaTotal, 2));
$pdf->Cell(85, 7, "");
$pdf->Ln();

$pdf->Cell(80, 7, "PAYE");
$pdf->Cell(60, 7, "");
$pdf->Cell(85, 7, number_format($payeTotal, 2));
$pdf->Ln();

$pdf->Cell(80, 7, "NAPSA");
$pdf->Cell(60, 7, "");
$pdf->Cell(85, 7, number_format($napsaTotal, 2));
$pdf->Ln();

$pdf->Cell(80, 7, "Life Assurance");
$pdf->Cell(60, 7, "");
$pdf->Cell(85, 7, "0.00");
$pdf->Ln();

$pdf->Cell(80, 7, "Salary Advance");
$pdf->Cell(60, 7, "");
$pdf->Cell(85, 7, number_format($salaryAdvanceTotal, 2));
$pdf->Ln();

$pdf->Cell(80, 7, "Net Pay");
$pdf->Cell(60, 7, "");
$pdf->Cell(85, 7, number_format($netPayTotal, 2));
$pdf->Ln();

$pdf->Cell(80, 7, "Loans");
$pdf->Cell(60, 7, "");
$pdf->Cell(85, 7, number_format($loanTotal, 2));
$pdf->Ln();

$pdf->Cell(80, 7, "Employee NAPSA");
$pdf->Cell(60, 7, "");
$pdf->Cell(85, 7, number_format($napsaTotal, 2));
$pdf->Ln();

$pdf->Cell(450, 7, "________________________________________________________________________________________________________________________________________________");
$pdf->Ln();
$creditTotal = $payeTotal + $salaryAdvanceTotal + $loanTotal + $napsaTotal + $netPayTotal + $napsaTotal;
$pdf->Cell(80, 9, "Total");
$pdf->Cell(60, 9, number_format($total,2));
$pdf->Cell(85, 9, number_format($creditTotal,2));

$pdf->Ln();
$pdf->Cell(450, 7, "________________________________________________________________________________________________________________________________________________");
$pdf->Ln();
$totalNoRecords = mysql_num_rows($result);

$pdf->Cell(420, 5, "Printed On : " . $datePrint . " By " . $CompanyObject->getUserDetails($userId));

$pdf->Ln();

$pdf->Output();
?>
