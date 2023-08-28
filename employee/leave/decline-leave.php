<?php
include('../../include/dbconnection.php');
include('../../PHPmailer/sendmail.php');
$id=$_GET['id'];
$empEmail = $_GET['empEmail'];
$status = "Declined";

$em = new email();

$message = "Greetings ,." . "<br>" . "<br>"
        . "Your leave application has been declined by Your Supervisor." 
        . "  Please login to your account for more information";

$Subject = "Leave Request";

$em->send_mail($empEmail, $message, $Subject);

mysql_query("UPDATE leave_applications_tb SET status ='$status' WHERE application_id= '$id'") or die(mysql_error());
header('location:pending-leaves.php');
?>