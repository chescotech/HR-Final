<?php

include('../../include/dbconnection.php');
$result = mysqli_query($link, "SELECT * FROM emp_info  ");
$months = 0;
while ($rows = mysqli_fetch_array($result)) {

    $fname = $rows['fname'];
    $lname = $rows['lname'];
    $reminderType = "Contract Expire Reminder";
    $datePrinted = strtoTime($rows['date_left']);
    $expiryDate = date('F d, Y', $datePrinted);
    $dateEnd = $rows['date_left'];
    $probationDate = $rows['probation_deadline'];

    $todaysDate = date("Y-m-d");

    $date1 = date_create($probationDate);
    $date2 = date_create($todaysDate);

    $interval = date_diff($date1, $date2);
    $difference = $interval->format('%m');

    $d1 = new DateTime($todaysDate);
    $d2 = new DateTime($probationDate);
    $probationDuration = $d1->diff($d2)->days;
    $d11 = new DateTime($todaysDate);
    $d22 = new DateTime($dateEnd);
    $contractDuration = $d11->diff($d22)->days;
    if ($rows['id'] == 175) {
        echo $contractDuration;
    }


    // echo $numberOfMonths;
}
