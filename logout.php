<?php
// include db
include_once './include/dbconnection.php';
// Inialize session
session_start();

// if emplyee
if (isset($_SESSION['empno'])) {
    // get session variables
    $empnum = $_SESSION['empno'];
    $companyId = $_SESSION['company_ID'];

    // log
    $action = "LOGOUT";
    $log_logout = mysql_query("INSERT INTO login_log(empno, action, company_id) VALUES('$empnum', '$action', '$companyId')") or die(mysql_error());
}

// Delete certain session
unset($_SESSION['username']);
// Delete all session variables
session_destroy();

// Jump to login page
header('Location:login.php');
