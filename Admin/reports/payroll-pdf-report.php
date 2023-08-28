<?php

include('../../include/dbconnection.php');
require('../fpdf/fpdf.php');
include_once '../Classes/Tax.php';
$TaxObject = new Tax();
session_start();

include_once '../Classes/Company.php';
$CompanyObject = new Company();
$userId = $_SESSION['user_id'];

$searchDate = $_POST['search_date'];
$compId = $_SESSION['company_ID'];

$CompanyName = $_SESSION['name'];
$printCompanyName = strtoupper($CompanyName);

$mydate = strtoTime($searchDate);
$printdate = date('F d, Y', $mydate);

$reportDate = $searchDate;
$arr = explode("/", $reportDate);
list($Getmonth, $Getday, $GetYear) = $arr;

$year = $GetYear;
$month = $Getmonth;
$day = $Getday;
$image = "logo.png";

$pdf = new FPDF();
$pdf->AddPage('L', 'A4');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln();
$pdf->Ln();
$pdf->SetTitle("PAYROLL  REPORT");
// date printed ..
$datePrinted = strtoTime(date("Y/m/d"));
$datePrint = date('F d, Y', $datePrinted);


//$pdf->Image($TaxObject->getCompanyLogo($compId), 35, 2, 150, 40, "JPG");

$pdf->Cell(450, 35, " ");
$pdf->Ln();
$pdf->MultiCell(0, 10, $printCompanyName . " PAYROLL REPORT FOR  " . strtoupper($printdate), 0, 'C');
$pdf->Cell(450, 7, "________________________________________________________________________________________________________________________________________________");
$pdf->Ln();


$pdf->Cell(21, 9, "Name");
$pdf->Cell(26, 9, "Last Name");
//$pdf->Cell(22, 9, "Basic Pay");
$pdf->Cell(16, 9, "Days");
$pdf->Cell(22, 9, "Otime");
$pdf->Cell(22, 9, "Allowance");
$pdf->Cell(22, 9, "Comission");
$pdf->Cell(24, 9, "Gross Pay");
$pdf->Cell(15, 9, "Tax");
$pdf->Cell(19, 9, "NAPSA");
$pdf->Cell(19, 9, "Advances");
$pdf->Cell(15, 9, "Loan");
$pdf->Cell(16, 9, "NHIMA");
$pdf->Cell(15, 9, "Total");
$pdf->Cell(12, 9, "Net Pay");

$pdf->Ln();
$pdf->Cell(450, 2, "________________________________________________________________________________________________________________________________________________");
$pdf->Ln();

$totalTaxPaid = 0;
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
$totalGrosssPay = 0;
$totalBasicPay = 0;
$query = "SELECT *
                                                        FROM employee em
                                                        INNER JOIN emp_info n ON em.empno = n.empno                                                     
                                                        WHERE em.company_id =  '$compId' and em.time = '$year-$month-$day'";

$result2 = mysql_query($query, $link) or die(mysql_error());

$sum = 0;
while ($row = mysql_fetch_array($result2)) {
    $basicPay = $row['pay'];
    $gross = ($row['pay'] ) + ($row['otrate'] * $row['othrs']) + $row['allow'] + $row['comission'];
    $empoyeeNo = $row['empno'];
    $date = $row['time'];
    $result = mysql_query("SELECT * FROM loan WHERE empno='$empoyeeNo' AND '$date' BETWEEN loan_date AND date_completion ");
    $LoanRows = mysql_fetch_array($result);
    $loanAmount = $LoanRows['monthly_deduct'];


    if ($TaxObject->getEmployeeAge($row['empno']) < 55) {
        $napsa = $gross * 0.05;
        if ($napsa >= $TaxObject->getNapsaCeiling($compId))
        $napsa = $TaxObject->getNapsaCeiling($compId);

        $napsa_calc = "";
        if ($napsa >= 255)
            $napsa_calc = 255;
    }else {
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

    if ($loanAmount == "") {
        $lAmount = 0;
    } else {
        $lAmount = $loanAmount;
    }

    $band1 = $income * $band1_rate;
    $total_tax_paid = $TaxObject->TaxCal($gross, $compId); //$band1 + $band2 + $band3 + $band4;
    $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $row['health_insurance'] + $napsa + $lAmount;
    $netpay = ($gross - $totdeduct);

    $sum += $netpay;
    $totalGrosssPay += $gross;
    $totalBasicPay += $basicPay;
    $totalTaxPaid += $total_tax_paid;
    $nhima =  $row['health_insurance'] ;

    $pdf->Cell(21, 7, $row['fname']);
    $pdf->Cell(22, 7, $row['lname']);
    //$pdf->Cell(22, 7, number_format("$basicPay", 2));
    $pdf->Cell(16, 7, $row['dayswork']);
    $pdf->Cell(22, 7, $row['otrate']);
    $pdf->Cell(22, 7, $row['allow']);
    $pdf->Cell(22, 7, $row['comission']);
    $pdf->Cell(24, 7, number_format("$gross", 2));
    $pdf->Cell(15, 7, number_format($total_tax_paid, 2));
    $pdf->Cell(19, 7, number_format($napsa, 2));
    $pdf->Cell(19, 7, number_format($row['advances'], 2));
    $pdf->Cell(17, 7, number_format($lAmount, 2));
      $pdf->Cell(17, 7, number_format("$nhima", 2));
    $pdf->Cell(15, 7, number_format("$totdeduct", 2));
    //nhima..
   
    $pdf->Cell(13, 7, number_format("$netpay", 2));


    $pdf->Ln();
}

$pdf->Cell(450, 2, "_________________________________________________________________________________________________________________________________________________");
$pdf->Ln();

$pdf->Cell(21, 7, "");
$pdf->Cell(21, 7, "");
$pdf->Cell(22, 7, "");
//$pdf->Cell(22, 7, number_format($totalBasicPay, 2));
$pdf->Cell(16, 7, "");
$pdf->Cell(22, 7, "");
$pdf->Cell(22, 7, "");
$pdf->Cell(22, 7, "");
$pdf->Cell(24, 7, number_format($totalGrosssPay, 2));
$pdf->Cell(15, 7, number_format($totalTaxPaid, 2));
$pdf->Cell(19, 7, "");
$pdf->Cell(19, 7, "");
$pdf->Cell(15, 7, "");
$pdf->Cell(15, 7, "");
$pdf->Cell(12, 7, number_format("$sum", 2));
$pdf->Ln();

$totalNoRecords = mysql_num_rows($result2);

$pdf->Cell(420, 5, "Printed On : " . $datePrint . " By " . $CompanyObject->getUserDetails($userId));

$pdf->Ln();

$pdf->Output();
?>
