<?php

header('Content-Type: application/json');

session_start();

$conn = mysqli_connect("localhost", "root", "", "chescote_lendmepay_db");
if ($_SESSION['fromdate']=="today") {

$sqlQuery = "SELECT COUNT(*) AS number,job_status FROM `jobs_user_applications` GROUP BY job_status";

}else{

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

    if($filter=="all"){
        $sqlQuery = "SELECT COUNT(*) AS number,job_status FROM `jobs_user_applications`
        WHERE DATE(jobs_user_applications.date) BETWEEN '$year-$month-$day'  AND  '$year2-$month2-$day2'
        GROUP BY job_status";
    }else
    {
        $sqlQuery = "SELECT COUNT(*) AS number,job_status FROM `jobs_user_applications`
        WHERE DATE(jobs_user_applications.date) BETWEEN '$year-$month-$day'  AND  '$year2-$month2-$day2'
        AND jobs_job_id='$filter'
        GROUP BY job_status";

    }
    
}

$result = mysqli_query($conn, $sqlQuery);

$data = array();
foreach ($result as $row) {
    $data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>