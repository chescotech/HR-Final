<?php

include('../../include/dbconnection.php');
include('../../PHPmailer/sendmail.php');

$id = $_GET['id'];
$status = "Denied";

echo $id;

$Query_ = mysqli_query($link, "SELECT * FROM `loan_applications` WHERE LOAN_NO='$id'") or die(mysqli_error($link));

$loan = mysqli_fetch_array($Query_);

$empno = $loan['empno'];
echo $empno;

if ($loan) {
        // Delete the loan from loan_applications_tb
        $updateQuery = "UPDATE loan_applications 
                SET status = '" . $status . "' 
                WHERE LOAN_NO = '" . ($loan['LOAN_NO']) . "'";

        $updateResult = mysqli_query($link, $updateQuery);
        if (!$updateResult) {
                die("Update failed: " . mysqli_error($link));
        }

        //       send email to employee
        $emp_query = mysqli_query($link, "SELECT * FROM `emp_info` WHERE empno = '$empno'");
        $employee = mysqli_fetch_array($emp_query);
        $EmployeeEmail = $employee['email'];

        $em = new email();

        $message = "Greetings." . "<br>" . "<br>"
                . "Your loan application has been declined."
                . "  Please consult your supervisor for more information.";

        $Subject = "Loan Status";

        $em->send_mail($EmployeeEmail, $message, $Subject);

        // Redirect the user back to the loan applications page
        header('Location: view-applications.php');
        exit;
} else {
        echo "Loan Application not found!";
}
