<?php
include('../../include/dbconnection.php');
session_start();
$id=$_GET['id'];

mysqli_query($link,"delete from leave_applications_tb where application_id='$id'") or die(mysqli_error($link));

header('location:my-leave.php');
