<?php
include('../../include/dbconnection.php');
session_start();
$id=$_GET['id'];

mysql_query("delete from loan_tb where id='$id'") or die(mysql_error());

header('location:loan-types');

?>