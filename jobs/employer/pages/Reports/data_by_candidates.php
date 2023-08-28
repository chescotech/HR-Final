<?php

header('Content-Type: application/json');

session_start();

$conn = mysql_connect("cloud204", "janazm_hr_fab", "c28T@xJ)))hR");
if (!$conn) {
    die("Connection failed: " . mysql_error());
}

mysql_select_db("janazm_hr_fab", $conn);

$comp_id = $_SESSION['comp_id'];

if ($_SESSION['fromdate'] == "today") {
    $sqlQuery = "SELECT COUNT(*) as number, jobs_postings.title as job FROM `jobs_user_applications`
                 INNER JOIN jobs_postings ON jobs_postings.id = jobs_user_applications.jobs_job_id
                 INNER JOIN department ON department.dep_id = jobs_postings.dep_id 
                 WHERE jobs_user_applications.emp_id = '$comp_id'
                 GROUP BY jobs_postings.title";
} else {
    $reportDate = $_SESSION['fromdate'];
    $arr = explode("/", $reportDate);
    list($Getmonth, $Getday, $GetYear) = $arr;

    $year = $GetYear;
    $month = $Getmonth;
    $day = $Getday;

    // to date.. 
    $toDate = $_SESSION['todate'];
    $arr2 = explode("/", $toDate);
    list($Getmonth2, $Getday2, $GetYear2) = $arr2;
    $year2 = $GetYear2;
    $month2 = $Getmonth2;
    $day2 = $Getday2;
    $filter = $_SESSION['filter'];

    if ($filter == "all") {
        $sqlQuery = "SELECT COUNT(*) as number, jobs_postings.title as job FROM `jobs_user_applications`
                     INNER JOIN jobs_postings ON jobs_postings.id = jobs_user_applications.jobs_job_id
                     INNER JOIN department ON department.dep_id = jobs_postings.dep_id 
                     WHERE jobs_user_applications.emp_id = '$comp_id' AND DATE(jobs_user_applications.date) BETWEEN '$year-$month-$day' AND '$year2-$month2-$day2'
                     GROUP BY jobs_postings.title";
    } else {
        $sqlQuery = "SELECT COUNT(*) as number, jobs_postings.title as job FROM `jobs_user_applications`
                     INNER JOIN jobs_postings ON jobs_postings.id = jobs_user_applications.jobs_job_id
                     INNER JOIN department ON department.dep_id = jobs_postings.dep_id 
                     WHERE jobs_user_applications.emp_id = '$comp_id' AND jobs_postings.id = '$filter'
                     AND DATE(jobs_user_applications.date) BETWEEN '$year-$month-$day' AND '$year2-$month2-$day2'
                     GROUP BY jobs_postings.title";
    }
}

$result = mysql_query($sqlQuery, $conn);

$data = array();
while ($row = mysql_fetch_assoc($result)) {
    $data[] = $row;
}

mysql_close($conn);

echo json_encode($data);
