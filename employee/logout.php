<?php
include_once '../include/dbconnection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// retrieve client name
$client = $_SESSION['CLIENT_NAME'];

// if emplyee
if (isset($_SESSION['empno'])) {
    // get session variables
    $empnum = $_SESSION['empno'];
    $companyId = $_SESSION['company_ID'];

    // log
    $action = "LOGOUT";
    $log_logout = mysqli_query($link, "INSERT INTO login_log(empno, action, company_id) VALUES('$empnum', '$action', '$companyId')") or die(mysqli_error($link));
}
// here is reset all the sessions so that the system contains no session .. 
session_unset();
session_destroy();

header("Location: ../../{$client}");
exit();
