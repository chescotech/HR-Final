<?php
include('../../include/dbconnection.php');
session_start();
$id=$_GET['id'];

mysqli_query($link,"delete from leave_tb where id='$id'") or die(mysqli_error($link));

header('location:leave-types');
