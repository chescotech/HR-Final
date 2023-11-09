<?php
include('../../include/dbconnection.php');
session_start();
$id = $_GET['id'];

mysqli_query($link, "delete from recurring_deduction_types where id='$id'") or die(mysqli_error($link));

header('location:rd-types');
