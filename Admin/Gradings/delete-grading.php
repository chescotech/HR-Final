<?php
include('../../include/dbconnection.php');
session_start();
$id=$_GET['id'];

mysqli_query($link,"delete from grade where grade_id='$id'") or die(mysqli_error($link));

header('location:employee-gradings');
