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
$date = $_POST['search_date'];
$mydate = strtoTime($date);
$companyId = $_POST['company_name'];
$mydate2 = strtoTime($date);
$printdate = date('F d, Y', $mydate2);

$reportDate = $date;
$arr = explode("/", $reportDate);
list($Getmonth, $Getday, $GetYear) = $arr;

$year = $GetYear;
$month = $Getmonth;
$day = $Getday;

$image = '<img src="' . $TaxObject->getCompanyLogo($companyId) . '"class="img-thumbnail" />';

$query = "SELECT * FROM employee WHERE time = '$year-$month-$day' AND company_id='$companyId'  ";
$result = mysql_query($query, $link) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {

    $id_ = $row['id'];
    $empNo = $row['empno'];
    $query2 = "SELECT * FROM emp_info WHERE empno= '$empNo' ";
    $result2 = mysql_query($query2, $link) or die(mysql_error());
    $row2 = mysql_fetch_array($result2);
    $em = new email();

    $idEncryp = base64_encode($row['id']);
    $empEncrypted = base64_encode($row['empno']);
    $companyEncrypt = base64_encode($companyId);

    $fname = $row2['fname'];
    $lname = $row2['lname'];
    $email = $row2['email'];
    $payslipLink = "";

    $message = " Dear " . $fname . " " . $lname . " , " . "<br>" . "<br>"
            . "A new payslip has been loaded , please login your account to access your pay slip for " . "$printdate" . "." . "<br>" . "<br>"
            . "$payslipLink" . "<br>" . "<br>" . "<br>" . "<br>"
            . $image;

    $Subject = "PAYSLIP FOR " . strtoupper($printdate);

    $message2 = " Dear " . $fname . " " . $lname . " , " . "<br>" . "<br>"
            . " Please find attached your Payslip for " . "$printdate" . "." . "<br>" . "<br>"
            . "<br>" . "<br>" . "<br>" . "<br>"
            . $image;

    if ($PaySlipsObject->checkIfUploadExsists($empNo, $date) == "true") {
        $slip = $PaySlipsObject->getPdfPayslip($empNo, $date);
        $em->sendEmailWithAttachment($email, $message2, $Subject, $slip);
    } else {
        $em->send_mail($email, $message, $Subject);
    }
}

echo "<script>window.close();</script>";
?>