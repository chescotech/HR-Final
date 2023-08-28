<?php
include('../../include/dbconnection.php');
session_start();
$id=$_GET['id'];

mysql_query("delete from loan where LOAN_NO='$id'") or die(mysql_error());

header('location:view-loans.php');

?>