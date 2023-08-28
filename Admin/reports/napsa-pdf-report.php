<?php

include_once '../Classes/Department.php';
include('../../include/dbconnection.php');
require('../fpdf/fpdf.php');

include_once '../Classes/Tax.php';
$TaxObject = new Tax();

$DepartmentObject = new Department();
session_start();

$compId = $_SESSION['company_ID'];

$searchDate = $_POST['search_date'];
$CompanyName = $_SESSION['name'];
include_once '../Classes/Company.php';
$CompanyObject = new Company();
$userId = $_SESSION['user_id'];
$printCompanyName = strtoupper($CompanyName);

$mydate = strtoTime($searchDate);
$printdate = date('F d, Y', $mydate);

// date printed ..
$datePrinted = strtoTime(date("Y/m/d"));
$datePrint = date('F d, Y', $datePrinted);

$reportDate = $searchDate;
$arr = explode("/", $reportDate);
list($Getmonth, $Getday, $GetYear) = $arr;

$year = $GetYear;
$month = $Getmonth;
$day = $Getday;
$image = "logo.png";
$monthName = date('F', mktime(0, 0, 0, $month, 10));

$pdf = new FPDF();
$pdf->AddPage('P', 'A4');

$pdf->SetFont('Arial', 'B', 11);
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial', '', 11);
$pdf->SetTitle("NAPSA REPORT");

//$pdf->Image($TaxObject->getCompanyLogo($compId), 35, 2, 150, 40, "JPG");

$pdf->Cell(450, 35, " ");
$pdf->Ln();
$pdf->MultiCell(0, 10, $printCompanyName . "  NAPSA REPORT FOR  " . strtoupper($printdate), 0, 'C');
$pdf->Cell(450, 7, "_______________________________________________________________________________________________________________________________________________");
$pdf->Ln();

$pdf->Cell(30, 9, "Account No");
$pdf->Cell(25, 9, "Year");
$pdf->Cell(25, 9, "Month");
$pdf->Cell(25, 9, "SSNo");
$pdf->Cell(25, 9, "Surname");
$pdf->Cell(25, 9, "Firstame");
$pdf->Cell(25, 9, "Otherame");
$pdf->Cell(25, 9, "Date of Birth");
$pdf->Cell(35, 9, "Employee Share");
$pdf->Cell(30, 9, "Employer Share");
$pdf->Cell(30, 9, "Total");

$pdf->Ln();
$pdf->Cell(450, 2, "_______________________________________________________________________________________________________________________________________________");
$pdf->Ln();


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

    $gross = ($row['pay'] ) + ($row['otrate'] * $row['othrs']) + $row['allow'] + $row['comission'];


    if ($TaxObject->getEmployeeAge($row['empno']) < 55) {
        $napsa = $gross * 0.05;
        if ($napsa >= 843)
            $napsa = 843;
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

    $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa + $row['comission'];
    $netpay = $gross - $totdeduct;

    $sum += $total;

    if ($DepartmentObject->getSocialSSNO($row['empno']) == "") {
        $ssNo = "0";
    } else {
        $ssNo = $DepartmentObject->getSocialSSNO($row['empno']);
    }

    $pdf->Cell(30, 9, $DepartmentObject->getEmployeeAccountNo($row['empno']));
    $pdf->Cell(25, 9, $year);
    $pdf->Cell(25, 9, $monthName);
    $pdf->Cell(25, 9, $ssNo);
    $pdf->Cell(25, 9, $lname);
    $pdf->Cell(25, 9, $fname);
    $pdf->Cell(25, 9, "");
    $pdf->Cell(25, 9, $DepartmentObject->getDOB($row['empno']));
    $pdf->Cell(35, 9, number_format($napsa, 2));
    $pdf->Cell(30, 9, number_format($napsa, 2));
    $pdf->Cell(30, 9, number_format("$total", 2));

    $pdf->Ln();
}

$pdf->Cell(450, 2, "_______________________________________________________________________________________________________________________________________________");
$pdf->Ln();


$pdf->Cell(30, 9, "");
$pdf->Cell(25, 9, "");
$pdf->Cell(25, 9, "");
$pdf->Cell(25, 9, "");
$pdf->Cell(25, 9, "");
$pdf->Cell(25, 9, "");
$pdf->Cell(25, 9, "");
$pdf->Cell(25, 9, "");
$pdf->Cell(35, 9, "");
$pdf->Cell(25, 9, "Total");
$pdf->Cell(25, 9, number_format("$sum", 2));

$pdf->Ln();

$pdf->Cell(420, 5, "Printed On : " . $datePrint . " By " . $CompanyObject->getUserDetails($userId));

$pdf->Ln();

$pdf->Output();
?>
