<?php

include('../../include/dbconnection.php');
include('../../PHPmailer/sendmail.php');

$id = $_GET['id'];
$status = "Approved";

echo $id;

$Query_ = mysqli_query($link, "SELECT * FROM `loan_applications` WHERE LOAN_NO='$id'") or die(mysqli_error($link));

$loan = mysqli_fetch_array($Query_);

$empno = $loan['empno'];
echo $empno;

if ($loan) {
        //        retrieve the values
        // Insert the loan into loan_tb
        $insertQuery = "INSERT INTO loan (empno, loan_amt, loan_type, monthly_deduct, duration, company_ID, loan_date, date_completion, status) 
                    VALUES ('" . $empno . "', " . ($loan['loan_amt']) . ", 
                            '" . ($loan['loan_type']) . "', '" . ($loan['monthly_deduct']) . "', 
                            " . ($loan['duration']) . ", '" . ($loan['company_ID']) . "', 
                            '" . ($loan['loan_date']) . "', '" . ($loan['date_completion']) . "', 
                            '$status')";

        // Execute the insert statement
        $insertResult = mysqli_query($link, $insertQuery);
        if (!$insertResult) {
                die("Insert failed: " . mysqli_error($link));
        }

        //       send email to employee
        $emp_query = mysqli_query($link, "SELECT * FROM `emp_info` WHERE empno = '$empno'");
        $employee = mysqli_fetch_array($emp_query);
        $EmployeeEmail = $employee['email'];


        $em = new email();

        $message = "Greetings." . "<br>" . "<br>"
                . "Your loan application has been approved."
                . "  Please login to your account for more information";

        $Subject = "Loan Status";

        $em->send_mail($EmployeeEmail, $message, $Subject);

        // Delete the loan from loan_applications_tb
        $deleteQuery = "DELETE FROM loan_applications WHERE LOAN_NO = '" . ($loan['LOAN_NO']) . "'";
        $deleteResult = mysqli_query($link, $deleteQuery);
        if (!$deleteResult) {
                die("Delete failed: " . mysqli_error($link));
        }

        // Redirect the user back to the loan applications page
        header('Location: view-applications.php');
        exit;
} else {
        echo "Loan Application not found!";
}
