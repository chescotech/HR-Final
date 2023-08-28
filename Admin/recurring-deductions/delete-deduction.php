<?php
include('../../include/dbconnection.php');
session_start();
$id = $_GET['id'];

mysql_query("delete from emp_recurring_deductions where id='$id'") or die(mysql_error());

header('location:view');
