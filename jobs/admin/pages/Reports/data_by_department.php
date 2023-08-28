<?php

header('Content-Type: application/json');

session_start();

$conn = mysqli_connect("localhost", "root", "", "chescote_lendmepay_db");
if ($_SESSION['fromdate']=="today") {

$sqlQuery = "SELECT COUNT(*) as number,department FROM `jobs_user_applications`
inner join jobs_postings on jobs_postings.id=jobs_user_applications.jobs_job_id
inner join department on department.dep_id=jobs_postings.dep_id 
GROUP BY department.department";

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
        $sqlQuery = "SELECT COUNT(*) as number,department FROM `jobs_user_applications`
        inner join jobs_postings on jobs_postings.id=jobs_user_applications.jobs_job_id
        inner join department on department.dep_id=jobs_postings.dep_id 
        WHERE DATE(jobs_user_applications.date) BETWEEN '$year-$month-$day'  AND  '$year2-$month2-$day2' 
        GROUP BY department.department";
    }else
    {
        $sqlQuery = "SELECT COUNT(*) as number,department FROM `jobs_user_applications`
        inner join jobs_postings on jobs_postings.id=jobs_user_applications.jobs_job_id
        inner join department on department.dep_id=jobs_postings.dep_id 
        WHERE jobs_postings.id='$filter' AND DATE(jobs_user_applications.date) BETWEEN '$year-$month-$day'  AND  '$year2-$month2-$day2' 
        GROUP BY department.department";

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