<?php

include('../../include/dbconnection.php');
include('../../PHPmailer/sendmail.php');
include_once '../Classes/Leave.php';
$leaveObject = new Leave();

$id = $_GET['id'];
$EmployeeEmail = $_GET['empEmail'];
$status = "Approved";
$empno = $_GET['empno'];


$Query_ = mysql_query("SELECT * FROM `leave_applications_tb` WHERE empno='$empno' AND application_id='$id'") or die(mysql_error());
$row = mysql_fetch_array($Query_);
$leaveType = $row['days'];

$leave_days = $leaveType;

$level = $_GET['level'] + 1;

// check if the approver is the final on the levels..
//echo 'level final ' . $_GET['level'];

if (intval($leaveObject->getEmployeeFinalLevelApprovals($empno)) == intval($_GET['level'])) {
    //echo 'in 1';
    // subtract leave days from Balanace based on type of leave.. 
    $Query = mysql_query(" SELECT leave_type FROM leave_applications_tb WHERE application_id= '$id'") or die(mysql_error());
    $row = mysql_fetch_array($Query);
    $leaveType = $row['leave_type'];

    if ($leaveObject->getDeductStatus($leaveType) == "Yes") {

        mysql_query("UPDATE leave_days SET available = available - '$leave_days' WHERE empno= '$empno'") or die(mysql_error());
        mysql_query("UPDATE leave_applications_tb SET status ='$status' WHERE application_id= '$id'") or die(mysql_error());

        //echo '$leave Days' . $leave_days;

        $em = new email();

        $message = "Greetings." . "<br>" . "<br>"
                . "Your leave application has been approved."
                . "  Please login to your account for more information";

        $Subject = "Leave Approval";

        $em->send_mail($EmployeeEmail, $message, $Subject);
    } else {
        mysql_query("UPDATE leave_applications_tb SET status ='$status' WHERE application_id= '$id'") or die(mysql_error());

         if ($leaveObject->getDeductStatus($leaveType) == "Yes") {
            mysql_query("UPDATE leave_days SET available = available - '$leave_days' WHERE empno= '$empno'") or die(mysql_error());
        }

        $em = new email();

        $message = "Greetings, ." . "<br>" . "<br>"
                . "Your leave application has been approved."
                . "  Please login to your account for more information";

        $Subject = "Leave Approval";

        $em->send_mail($EmployeeEmail, $message, $Subject);
    }
} else {

    //echo 'in 2';
    mysql_query("UPDATE leave_applications_tb SET level ='$level' WHERE application_id= '$id'") or die(mysql_error());
}

header('location:pending-leaves.php');
?>