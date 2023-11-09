<?php
$dbms = "mysql";
$dbhost = "localhost";
$dbname = "lso_pricing_db";
$dbuser = "root";
$dbpasswd = "";

$link = mysqli_connect($dbhost, $dbuser, $dbpasswd, $dbname)
    or die(mysqli_connect_error());

//echo "Connected Successfully to ". $dbname.'<br>';
