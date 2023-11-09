<?php

include_once '../Classes/Department.php';
include_once '../Classes/Payslips.php';
include_once '../Classes/Loans.php';

$LoanObject = new Loans();
$DepartmentObject = new Department();
$PaySlipsObject = new Payslips();

include('../../include/dbconnection.php');
require_once('../../PHPmailer/sendmail.php');
include_once '../Classes/Tax.php';
$TaxObject = new Tax();
$id = $_GET['id'];
$empno = $_GET['empno'];
$date = $_GET['date'];
$email = $_GET['email'];
$companyId = $_GET['companyId'];

$mydate = strtoTime($date);
$printdate = date('F d, Y', $mydate);

$em = new email();

$query = mysqli_query($link,"SELECT * FROM emp_info WHERE empno = '$empno'");
$employeeRows = mysqli_fetch_array($query);
$fname = $employeeRows['fname'];
$lname = $employeeRows['lname'];

$image = '<img src="'.$TaxObject->getCompanyLogo($companyId).'" width="100%" height="290" class="img-thumbnail" />';

$idEncryp = base64_encode($id);
$empEncrypted = base64_encode($empno);
$companyEncrypt = base64_encode($companyId);

$payslipLink = "";

$message = " Dear " . $fname . " " . $lname . " , " . "<br>" . "<br>"
        . "A new payslip has been loaded , please login your account to access your pay slip for  " . "$printdate" . "." . "<br>" . "<br>"
        . "$payslipLink" . "<br>" . "<br>" . "<br>" . "<br>"
        . $image;

$Subject = " PAYSLIP FOR " . strtoupper($printdate);

$message2 = " Dear " . $fname . " " . $lname . " , " . "<br>" . "<br>"
        . " Please find attached your Payslip for " . "$printdate" . "." . "<br>" . "<br>"
        . "<br>" . "<br>" . "<br>" . "<br>"
        . $image;

if ($PaySlipsObject->checkIfUploadExsists($empno, $date) == "true") {
    $slip = $PaySlipsObject->getPdfPayslip($empno, $date);
    $em->sendEmailWithAttachment($email, $message2, $Subject, $slip);
} else {
    $em->send_mail($email, $message, $Subject);
}

echo "<script>window.close();</script>";
