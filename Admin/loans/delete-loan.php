<?php
include('../../include/dbconnection.php');
session_start();
$id=$_GET['id'];

mysqli_query($link,"delete from loan where LOAN_NO='$id'") or die(mysqli_error($link));

header('location:view-loans.php');
