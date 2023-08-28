<?php
session_start();
require_once ('../graph-libs/src/jpgraph.php');
require_once ('../graph-libs/src/jpgraph_pie.php');
include('../../include/dbconnection.php');

$dataArray = array();
$labeslArray = array();
$companyId = $_SESSION['company_ID'];
$sql = "SELECT case_status, COUNT(*) AS 'count' FROM employee_discplinary_records WHERE empno IN ( SELECT empno FROM emp_info WHERE company_id = '$companyId' ) GROUP BY case_status ";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
if ($result) {
    while ($row = mysql_fetch_assoc($result)) {
        $reason_for_exit = $row["case_status"];
        $count = $row["count"];       
        array_push($dataArray, $count);
        array_push($labeslArray, $reason_for_exit."\n%.1f%%");
    }
}

$graph = new PieGraph(650, 600);

// Don't display the border
$graph->SetFrame(false);

$graph->title->Set("Employee Disciplinary Records report");
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
$p1->midtitle->Set("Employee \n Disciplinary \n ");
$p1->midtitle->SetFont(FF_ARIAL, FS_NORMAL, 14);

// Set color for mid circle
$p1->SetMidColor('yellow');

// Use percentage values in the legends values (This is also the default)
$p1->SetLabelType(PIE_VALUE_PER);

// The label array values may have printf() formatting in them. The argument to the
// form,at string will be the value of the slice (either the percetage or absolute
// depending on what was specified in the SetLabelType() above.

$lbl = array("adam and finance\n%.1f%%", "bertil\n%.1f%%", "johan\n%.1f%%",
    "peter\n%.1f%%", "daniel\n%.1f%%", "erik\n%.1f%%");

$p1->SetLabels($labeslArray);

// Uncomment this line to remove the borders around the slices
// $p1->ShowBorder(false);
// Add drop shadow to slices
$p1->SetShadow();

// Explode all slices 15 pixels
$p1->ExplodeAll(15);

// Add plot to pie graph
$graph->Add($p1);

// .. and send the image on it's marry way to the browser
$graph->Stroke();