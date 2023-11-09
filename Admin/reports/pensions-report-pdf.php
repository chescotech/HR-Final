<?php

include_once '../Classes/Employee.php';
include_once '../Classes/Loans.php';
include_once '../Classes/Tax.php';
$TaxObject = new Tax();
$EmployeeObject = new Employee();
$loanObj = new Loans();

include('../../include/dbconnection.php');
require('../fpdf/fpdf.php');

$loanObj = new Loans();

session_start();

$companyId = $_SESSION['name'];
$compId = $_SESSION['company_ID'];
$printCompanyName = strtoupper($companyId);

$image = "logo.png";

$pdf = new FPDF();
$pdf->AddPage('P', 'A4');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial', '', 10);
$pdf->SetTitle("Annual Tax Report");

//$pdf->Image($TaxObject->getCompanyLogo($compId), 35, 2, 150, 40, "JPG");

$pdf->Cell(450, 35, " ");
$pdf->Ln();
$pdf->MultiCell(0, 10, " EMPLOYEE PENSIONS REPORT ", 0, 'C');
$pdf->Cell(450, 7, "___________________________________________________________________________________________________");
$pdf->Ln();


$pdf->Cell(25, 9, "Employee ID");
$pdf->Cell(30, 9, "Social Security");
$pdf->Cell(40, 9, "Employee Name");
$pdf->Cell(40, 9, "Duration Worked");
$pdf->Cell(40, 9, "Gross Wage");
$pdf->Cell(50, 9, "Total Pension");

$pdf->Ln();
$pdf->Cell(450, 2, "___________________________________________________________________________________________________");
$pdf->Ln();

$query = "SELECT * FROM `emp_info` where employment_type='Permanent' ";

$result2 = mysqli_query($link, $query) or die(mysqli_error($link));
$sum = 0;
while ($row = mysqli_fetch_array($result2)) {

    $empno = $row['empno'];
    $SNo = $loanObj->getSocialSecurityNo($empno);

    $pensionAmount = $loanObj->getPensions($compId, $empno);

    $result = mysqli_query($link, "SELECT * FROM emp_info WHERE empno='$empno'");
    $grossRows = mysqli_fetch_array($result);
    $grossPay = $grossRows['gross_pay'];
    $dateJoined = $grossRows['date_joined'];

    $ts1 = strtotime($dateJoined);
    $ts2 = strtotime(date("Y/m/d"));

    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);

    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);
    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

    $sum += $loanObj->getTotalpension($compId, $empno);

    $pdf->Cell(25, 9, $row['empno']);
    $pdf->Cell(30, 9, $SNo);
    $pdf->Cell(40, 9, $row['fname'] . " " . $row['lname']);
    $pdf->Cell(40, 9, $diff . " Months");
    $pdf->Cell(40, 9, $grossPay);
    $pdf->Cell(50, 9, $pensionAmount);
    $pdf->Ln();
}

$pdf->Cell(450, 2, "___________________________________________________________________________________________________");
$pdf->Ln();

$datePrinted = strtoTime(date("Y/m/d"));
$datePrint = date('F d, Y', $datePrinted);

$pdf->Cell(25, 9, "");
$pdf->Cell(30, 9, "");
$pdf->Cell(40, 9, "");
$pdf->Cell(40, 9, "");
$pdf->Cell(40, 9, "Total");
$pdf->Cell(50, 9, number_format($sum, 2));
$pdf->Ln();

$pdf->Cell(450, 2, "___________________________________________________________________________________________________");
$pdf->Ln();
$totalNoRecords = mysqli_num_rows($result2);
$pdf->Cell(420, 7, "Printed On : " . $datePrint . " By Monica Okpara");
$pdf->Ln();

$pdf->Output();
