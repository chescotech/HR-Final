<?php
include('../../include/dbconnection.php');
include('../../PHPmailer/sendmail.php');
$id = $_GET['id'];
$empEmail = $_GET['empEmail'];
$status = "Declined";

$em = new email();

$message = "Greetings ,." . "<br>" . "<br>"
        . "Your loan application has been declined by Your Supervisor."
        . "  Please login to your account for more information";

$Subject = "Loan Request";

$em->send_mail($empEmail, $message, $Subject);

mysqli_query($link, "UPDATE loan_applications SET status ='$status' WHERE LOAN_NO = '$id'") or die(mysqli_error($link));
header('location:pending-loans.php');
