<?php
include('../../include/dbconnection.php');
session_start();
$id=$_GET['id'];

mysql_query("delete from grade where grade_id='$id'") or die(mysql_error());

header('location:employee-gradings');

?>