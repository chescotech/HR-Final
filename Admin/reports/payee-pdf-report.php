<?php

include_once '../Classes/Department.php';

require('../fpdf/fpdf.php');
include_once '../Classes/Tax.php';
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
$userId =  $_SESSION['user_id'];

// date printed ..
$datePrinted = strtoTime(date("Y/m/d"));
$datePrint = date('F d, Y', $datePrinted);

$year = $GetYear;
$month = $Getmonth;
$day = $Getday;
$image = "logo.png";

$pdf = new FPDF();
$pdf->AddPage('L', 'A4');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln();

$pdf->SetTitle("NPAYE REPORT");

$pdf->Image($TaxObject->getCompanyLogo($compId), 35, 2, 150, 40, "JPG");

$pdf->Cell(450, 35, " ");
$pdf->Ln();
$pdf->MultiCell(0, 10, $printCompanyName . "  PAYE REPORT FOR  " . strtoupper($printdate), 0, 'C');
$pdf->Cell(450, 7, "________________________________________________________________________________________________________________________________________________");
$pdf->Ln();

$pdf->Cell(20, 9, "Id Type");
$pdf->Cell(22, 9, "Id Number");
$pdf->Cell(35, 9, "Names");
$pdf->Cell(37, 9, "Employment Type");
$pdf->Cell(30, 9, "Gross Pay");
$pdf->Cell(45, 9, "Chargeable emoluments");
$pdf->Cell(35, 9, "Total tax for year");
$pdf->Cell(40, 9, "Tax Deducted on TDR");
$pdf->Cell(40, 9, "Tax Adjusted");

$pdf->Ln();
$pdf->Cell(450, 2, "________________________________________________________________________________________________________________________________________________");
$pdf->Ln();


$query = "SELECT *
                                                        FROM employee em
                                                        INNER JOIN emp_info n ON em.empno = n.empno                                                     
                                                        WHERE em.company_id =  '$compId' and em.time = '$year-$month-$day'";

$result = mysqli_query($link,$query);
$sum = 0;
$GrossTotal = 0;
$chargableEmTotal = 0;
$taxPaidTotal = 0;

while ($row = mysqli_fetch_array($result)) {
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
    $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa;

    if ($DepartmentObject->getSocialSSNO($row['empno']) == "") {
        $ssNo = "0";
    } else {
        $ssNo = $DepartmentObject->getSocialSSNO($row['empno']);
    }
    if ($DepartmentObject->getEmployeeNrc($row['empno']) == "") {
        $NRC = "0";
    } else {
        $NRC = $DepartmentObject->getEmployeeNrc($row['empno']);
    }

    $chargbleEmTaxPeriod = $gross - ($gross * 0.05);

    $GrossTotal += $row['pay'];
    $chargableEmTotal += $chargbleEmTaxPeriod;
    $taxPaidTotal +=$total_tax_paid;

    $pdf->Cell(20, 7, "NRC");
    $pdf->Cell(22, 7, $NRC);
    $pdf->Cell(43, 7, $row['fname'] . " " . $row['lname']);
    $pdf->Cell(34, 7, $natureEmployement);
    $pdf->Cell(30, 7, number_format($gross,2));
    $pdf->Cell(45, 7, number_format($chargbleEmTaxPeriod,2));
    $pdf->Cell(35, 7, "0.00");
    $pdf->Cell(40, 7, number_format($total_tax_paid,2));
    $pdf->Cell(40, 7, "0.00");

    $pdf->Ln();
}

$pdf->Cell(450, 7, "________________________________________________________________________________________________________________________________________________");
$pdf->Ln();

$pdf->Cell(20, 9, "Total");
$pdf->Cell(22, 9, "");
$pdf->Cell(43, 9, "");
$pdf->Cell(34, 9, "");
$pdf->Cell(30, 9, number_format($GrossTotal,2));
$pdf->Cell(45, 9, number_format($chargableEmTotal,2));
$pdf->Cell(35, 9, "");
$pdf->Cell(40, 9, number_format($taxPaidTotal,2));
$pdf->Cell(40, 9, "");

$pdf->Ln();
$pdf->Cell(450, 7, "________________________________________________________________________________________________________________________________________________");
$pdf->Ln();
$totalNoRecords = mysqli_num_rows($result);

$pdf->Cell(420, 5, "Printed On : " . $datePrint . " By ".$CompanyObject->getUserDetails($userId));

$pdf->Ln();

$pdf->Output();
