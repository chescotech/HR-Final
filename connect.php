<?php
$host = "localhost";
$user  = "root";
$pass = "";
$database = "pay";

$connection=mysqli_connect($host,$user,$pass) or die("error in connection");

mysqli_select_db($connection, "pay");
?>