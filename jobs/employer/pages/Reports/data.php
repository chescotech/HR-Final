<?php

header('Content-Type: application/json');

session_start();

$servername = "cloud204";
$username = "janazm_hr_fab";
$password = "c28T@xJ)))hR";
$dbname = "janazm_hr_fab";

// Create connection
$conn = mysql_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_error($link));
}

mysql_select_db($dbname, $conn);

$comp_id = $_SESSION['comp_id'];

if ($_SESSION['fromdate'] == "today") {

    $sqlQuery = "SELECT COUNT(*) AS number, job_status FROM `jobs_user_applications` WHERE emp_id = '$comp_id' GROUP BY job_status";
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
        $sqlQuery = "SELECT COUNT(*) AS number, job_status FROM `jobs_user_applications`
        WHERE emp_id = '$comp_id' AND DATE(jobs_user_applications.date) BETWEEN '$year-$month-$day'  AND  '$year2-$month2-$day2'
        GROUP BY job_status";
    } else {
        $sqlQuery = "SELECT COUNT(*) AS number, job_status FROM `jobs_user_applications`
        WHERE emp_id = '$comp_id' AND DATE(jobs_user_applications.date) BETWEEN '$year-$month-$day'  AND  '$year2-$month2-$day2'
        AND jobs_job_id='$filter'
        GROUP BY job_status";
    }
}

$result = mysqli_query($link, $sqlQuery, $conn);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

mysql_close($conn);

echo json_encode($data);
