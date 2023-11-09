<?php
include('../../include/dbconnection.php');
session_start();
$id=$_GET['id'];

mysqli_query($link,"delete from company where company_ID='$id'") or die(mysqli_error($link));

header('location:company-list.php');
