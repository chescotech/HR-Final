<?php
include('../../include/dbconnection.php');
$id=$_GET['id'];
mysql_query("delete from users_tb where id='$id'") or die(mysql_error());
header('location:user-list');
?>