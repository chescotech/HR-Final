<?php
include('../../include/dbconnection.php');
session_start();
$id=$_GET['id'];

mysql_query("UPDATE emp_info SET status = 'active' where id='$id'") or die(mysql_error());

header('location:employees.php');

?>