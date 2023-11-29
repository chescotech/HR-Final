<?php
include('../../include/dbconnection.php');

$id = $_GET['id'];

mysqli_query($link, "UPDATE emp_info SET status = 'active' where id='$id'") or die(mysqli_error($link));

header('location:employees.php');
exit();
