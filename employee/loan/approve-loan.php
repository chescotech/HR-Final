<?php

include('../../include/dbconnection.php');
include('../../PHPmailer/sendmail.php');
include_once '../Classes/Leave.php';
$leaveObject = new Leave();

$id = $_GET['id'];
$EmployeeEmail = $_GET['empEmail'];
$status = "Approved";
$empno = $_GET['empno'];


$Query_ = mysql_query("SELECT * FROM `loan_applications` WHERE empno='$empno' AND LOAN_NO='$id'") or die(mysql_error());
$row = mysql_fetch_array($Query_);
$loanType = $row['loan_type'];

$level = $_GET['level'] + 1;

// check if the approver is the final on the levels..
//echo 'level final ' . $_GET['level'];

if (intval($leaveObject->getEmployeeFinalLevelApprovals($empno)) == intval($_GET['level'])) {

    mysql_query("UPDATE loan_applications SET status ='$status' WHERE LOAN_NO = '$id'") or die(mysql_error());

    //echo '$loan Days' . $loan_days;

    $em = new email();

    $message = "Greetings." . "<br>" . "<br>"
        . "Your loan application has been approved."
        . "  Please login to your account for more information";

    $Subject = "Loan Approval";

    $em->send_mail($EmployeeEmail, $message, $Subject);
} else {
    //echo 'in 2';
    mysql_query("UPDATE loan_applications SET level ='$level' WHERE LOAN_NO = '$id'") or die(mysql_error());
}

header('location:pending-loans.php');
