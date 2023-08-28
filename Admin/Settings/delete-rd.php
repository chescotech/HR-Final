<?php
include('../../include/dbconnection.php');
session_start();
$id = $_GET['id'];

mysql_query("delete from recurring_deduction_types where id='$id'") or die(mysql_error());

header('location:rd-types');
