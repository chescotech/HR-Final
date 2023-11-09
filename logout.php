<?php
// include db
include_once './include/dbconnection.php';
// Inialize session
session_start();

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

// Delete certain session
unset($_SESSION['username']);
// Delete all session variables
session_destroy();
// Jump to login page
header("Location: ../{$client}");
