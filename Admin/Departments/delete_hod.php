<?php
include('../../include/dbconnection.php');
session_start();
$id=$_GET['id'];

mysql_query("delete from hod_tb where id='$id'") or die(mysql_error());

header('location:view-hod-departments.php');

?>