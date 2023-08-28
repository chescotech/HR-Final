<?php
include('../../include/dbconnection.php');
session_start();
$id=$_GET['id'];

mysql_query("delete from leave_applications_tb where application_id='$id'") or die(mysql_error());

header('location:my-leave.php');

?>