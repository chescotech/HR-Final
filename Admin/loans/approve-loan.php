<?php

include('../../include/dbconnection.php');
include('../../PHPmailer/sendmail.php');

$id = $_GET['id'];
$status = "Approved";

echo $id;

$Query_ = mysql_query("SELECT * FROM `loan_applications` WHERE LOAN_NO='$id'") or die(mysql_error());

$loan = mysql_fetch_array($Query_);

$empno = $loan['empno'];
echo $empno;

if ($loan) {
        //        retrieve the values
        // Insert the loan into loan_tb
    $insertQuery = "INSERT INTO loan (empno, loan_amt, loan_type, monthly_deduct, duration, company_ID, loan_date, date_completion, status) 
                    VALUES ('" . $empno . "', " . mysql_real_escape_string($loan['loan_amt']) . ", 
                            '" . mysql_real_escape_string($loan['loan_type']) . "', '" . mysql_real_escape_string($loan['monthly_deduct']) . "', 
                            " . mysql_real_escape_string($loan['duration']) . ", '" . mysql_real_escape_string($loan['company_ID']) . "', 
                            '" . mysql_real_escape_string($loan['loan_date']) . "', '" . mysql_real_escape_string($loan['date_completion']) . "', 
                            '$status')";

        // Execute the insert statement
        $insertResult = mysql_query($insertQuery, $link);
        if (!$insertResult) {
                die("Insert failed: " . mysql_error());
        }
        
//       send email to employee
        $emp_query = mysql_query("SELECT * FROM `emp_info` WHERE empno = '$empno'");
        $employee = mysql_fetch_array($emp_query);
        $EmployeeEmail = $employee['email'];
        
        
        $em = new email();

        $message = "Greetings." . "<br>" . "<br>"
                . "Your loan application has been approved."
                . "  Please login to your account for more information";

        $Subject = "Loan Status";

        $em->send_mail($EmployeeEmail, $message, $Subject);
        
        // Delete the loan from loan_applications_tb
    $deleteQuery = "DELETE FROM loan_applications WHERE LOAN_NO = '" . mysql_real_escape_string($loan['LOAN_NO']) . "'";
        $deleteResult = mysql_query($deleteQuery, $link);
        if (!$deleteResult) {
                die("Delete failed: " . mysql_error());
        }

        // Redirect the user back to the loan applications page
        header('Location: view-applications.php');
        exit;
} else {
        echo "Loan Application not found!";
}
?>