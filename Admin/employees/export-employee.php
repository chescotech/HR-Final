<?php

include_once '../Classes/Department.php';
include('../../include/dbconnection.php');
require('../fpdf/fpdf.php');

include_once '../Classes/Tax.php';
$pdf = new FPDF();

$pdf = new FPDF();
$pdf->AddPage('L', 'A6');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial', '', 11);
$pdf->SetTitle("Employee Card");

$pdf->Cell(450, 35, " ");
$pdf->Ln();
$pdf->MultiCell(0, 10, 'Employee Information For ', 0, 'C');


$pdf->Cell(30, 9, "Name");

$pdf->Ln();
$pdf->Cell(25, 9, "Employee Number");
$pdf->Ln();
$pdf->Cell(25, 9, "Gender");
$pdf->Ln();
$pdf->Cell(25, 9, "ID Number(NRC or Passport)");
$pdf->Ln();
$pdf->Cell(25, 9, "Title");
$pdf->Ln();
$pdf->Cell(25, 9, "Mobile");
$pdf->Ln();
$pdf->Cell(25, 9, "Work Email");
$pdf->Ln();
$pdf->Cell(25, 9, "Personal Email");
$pdf->Ln();
$pdf->Cell(35, 9, "Physical Address");
$pdf->Ln();
$pdf->Cell(30, 9, "Employer Share");
$pdf->Ln();
$pdf->Cell(30, 9, "Available Leave Days");


$pdf->Ln();
$pdf->Cell(30, 9, "Bank");

$pdf->Ln();
$pdf->Cell(30, 9, "Branch Code");

$pdf->Ln();
$pdf->Cell(30, 9, "Account Number");


$pdf->Cell(30, 9, "Payment Method");


$pdf->Cell(30, 9, "Employee Grade");


$pdf->Cell(30, 9, "");


$pdf->Cell(30, 9, "Available Leave Days");

$pdf->Ln();
$pdf->Cell(30, 9, "Available Leave Days");

$pdf->Ln();
$pdf->Cell(30, 9, "Available Leave Days");

$pdf->Ln();

$pdf->Output();
?>
