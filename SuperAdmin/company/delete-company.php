<?php
include('../../include/dbconnection.php');
session_start();
$id=$_GET['id'];

mysql_query("delete from company where company_ID='$id'") or die(mysql_error());

header('location:company-list.php');

?>