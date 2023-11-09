<?php
include('../../include/dbconnection.php');
session_start();
$id=$_GET['id'];

mysqli_query($link,"UPDATE emp_info SET status = 'exited' where id='$id'") or die(mysqli_error($link));

header('location:employees.php');
