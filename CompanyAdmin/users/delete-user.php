<?php
include('../../include/dbconnection.php');
$id=$_GET['id'];
mysqli_query($link,"delete from users_tb where id='$id'") or die(mysqli_error($link));
header('location:user-list');
