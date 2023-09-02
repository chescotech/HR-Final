<?php
session_start();
include('../../include/dbconnection.php');
include_once '../Classes/Department.php';
include_once '../Classes/Payslips.php';

$PaySlipsObject = new Payslips();

$id = $_GET['id'];
$date = $_GET['date'];
$empno = $_GET['empno'];
$compId = $_SESSION['company_ID'];
mysql_query("delete from employee where id='$id'") or die(mysql_error());
//delete the taxes also, 

// mysql_query("delete from tax WHERE time='$date' AND empno='$empno' ") or die(mysql_error());
// revert back the leave days...
$PaySlipsObject->deductLeave($empno, $compId);
header('location:view-payslips.php');
