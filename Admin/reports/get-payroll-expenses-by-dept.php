<?php

session_start();
require_once('../graph-libs/src/jpgraph.php');
require_once('../graph-libs/src/jpgraph_pie.php');
include('../../include/dbconnection.php');
include_once '../Classes/Loans.php';

$LoanObject = new Loans();
$dataArray = array();
$labeslArray = array();
$companyId = $_SESSION['company_ID'];

$query = mysqli_query($link, " SELECT DISTINCT dept FROM emp_info WHERE company_id ='$companyId' ");
$sum = 0;
$payrollAmountByDept = 0;

while ($row = mysqli_fetch_array($query)) {
    $departmentId = $row['dept'];
    $departmentName = $LoanObject->getDepartmentById($departmentId);
    $payrollAmountByDept = $LoanObject->getPayrollTotalByDepartment($departmentId, $companyId);

    array_push($dataArray, $payrollAmountByDept);
    array_push($labeslArray, $departmentName . "\n%.1f%%");
}

$graph = new PieGraph(650, 650, 'auto');

$graph->SetFrame(false);

$graph->title->Set("Payroll expense by Department ");
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 18);
$graph->title->SetMargin(8); // Add a little bit more margin from the top
// Create the pie plot
$p1 = new PiePlotC($dataArray);

// Set size of pie
$p1->SetSize(0.35);

// Label font and color setup
$p1->value->SetFont(FF_ARIAL, FS_BOLD, 12);
$p1->value->SetColor('white');

$p1->value->Show();

// Setup the title on the center circle
$p1->midtitle->Set("Payroll Expense\n by Department ");
$p1->midtitle->SetFont(FF_ARIAL, FS_NORMAL, 14);

// Set color for mid circle
$p1->SetMidColor('yellow');

// Use percentage values in the legends values (This is also the default)
$p1->SetLabelType(PIE_VALUE_PER);

$p1->SetLabels($labeslArray);

$p1->SetShadow();

$p1->ExplodeAll(15);

$graph->Add($p1);

$graph->Stroke();
