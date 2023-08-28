<?php

include_once '../Classes/Employee.php';
include_once '../Classes/Loans.php';
$EmployeeObject = new Employee();
$loanObj = new Loans();
session_start();

include('../../include/dbconnection.php');
require('../fpdf/fpdf.php');
include_once '../Classes/Tax.php';

include_once '../Classes/Company.php';
$CompanyObject = new Company();
$userId =  $_SESSION['user_id'];

$TaxObject = new Tax();
$loanObj = new Loans();


$datePrinted = strtoTime(date("Y/m/d") );
$datePrint = date('F d, Y', $datePrinted);
$searchDate = $_POST['search_date'];
$compId = $_SESSION['company_ID'];
$to_date = $_POST['to_date'];

$CompanyName =  $_SESSION['name'];
$printCompanyName = strtoupper($CompanyName);

$arr2 = explode("/", $to_date);
list($Getmonth2, $Getday2, $GetYear2) = $arr2;
$year2 = $GetYear2;
$month2 = $Getmonth2;
$day2 = $Getday2;

$mydate = strtoTime($searchDate);
$printdate = date('F d, Y', $mydate);

// to date.. 
$mydate2 = strtoTime($to_date);
$printdate2 = date('F d, Y', $mydate2);

$reportDate = $searchDate;
$arr = explode("/", $reportDate);
list($Getmonth, $Getday, $GetYear) = $arr;

$year = $GetYear;
$month = $Getmonth;
$day = $Getday;
$image = "logo.png";

$pdf = new FPDF();
$pdf->AddPage('P', 'A4');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial', '', 10);
$pdf->SetTitle("Annual Tax Report");

$pdf->Image($TaxObject->getCompanyLogo($compId), 35, 2, 150, 40, "JPG");

$pdf->Cell(450, 35, " ");
$pdf->Ln();
$pdf->MultiCell(0, 10, "ANNUAL TAX REPORT FOR PERIOD " . strtoupper($printdate) . " TO " . strtoupper($printdate2), 0, 'C');
$pdf->Cell(450, 7, "___________________________________________________________________________________________________");
$pdf->Ln();

$pdf->Cell(25, 9, "Employee ID");
$pdf->Cell(30, 9, "Social Security");
$pdf->Cell(40, 9, "First Name");
$pdf->Cell(40, 9, "Last Name");
$pdf->Cell(50, 9, "Employee Contribution");

$pdf->Ln();
$pdf->Cell(450, 2, "___________________________________________________________________________________________________");
$pdf->Ln();

$query = "  SELECT * FROM emp_info WHERE empno IN (  SELECT empno FROM employee WHERE time BETWEEN '$year-$month-$day'  AND  '$year2-$month2-$day2'  )  AND company_id = '$compId' ";

$result2 = mysql_query($query, $link) or die(mysql_error());

$sum = 0;

while ($row = mysql_fetch_array($result2)) {
    
    $empno = $row['empno'];
    $fname = $row['fname'];
    $lname = $row['lname'];
    $SNo = $loanObj->getSocialSecurityNo($empno);

    $AnnualTax = $loanObj->getEmployeeAnnualtax($compId, $reportDate, $to_date, $empno,$compId);

    $sum += $loanObj->getTotalAnnualSum($compId, $reportDate, $to_date, $empno,$compId);

    $pdf->Cell(25, 7, $empno);
    $pdf->Cell(30, 7, $SNo);
    $pdf->Cell(40, 7, $fname);
    $pdf->Cell(40, 7, $lname);

    $pdf->Cell(50, 7, number_format($AnnualTax,2));

    $pdf->Ln();
    
}

$pdf->Cell(450, 2, "___________________________________________________________________________________________________");
$pdf->Ln();

$pdf->Cell(25, 7, "");
$pdf->Cell(30, 7, "");
$pdf->Cell(40, 7, "");

$pdf->Cell(40, 7, "Total");
$pdf->Cell(50, 7, number_format($sum,2));

$pdf->Ln();

$totalNoRecords = mysql_num_rows($result2);
$pdf->Cell(450, 2, "___________________________________________________________________________________________________");
$pdf->Ln();
$pdf->Cell(420,7, "Printed On : ".$datePrint." By ".$CompanyObject->getUserDetails($userId));
$pdf->Ln();

$pdf->Output();
?>
