<?php
include_once '../Classes/DBClass.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../../include/dbconnection.php');
include_once '../Classes/Department.php';
include_once '../Classes/Payslips.php';

$PaySlipsObject = new Payslips();

$id = $_GET['id'];
$date = $_GET['date'];
$empno = $_GET['empno'];
$compId = $_SESSION['company_ID'];
$deleteQuery = mysqli_query($link, "DELETE FROM employee WHERE id='$id'") or die(mysqli_error($link));
//delete the taxes also, 

// mysqli_query($link,"delete from tax WHERE time='$date' AND empno='$empno' ") or die(mysqli_error($link));
// revert back the leave days...
if ($deleteQuery) {
    $PaySlipsObject->deductLeave($empno, $compId);
}

echo '<script> window.location.assign("view-payslips.php")</script>';
