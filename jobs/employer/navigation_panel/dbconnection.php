<?php
$dbhost = "localhost";
$dbname = "hr_fab";
$dbuser = "root";
$dbpasswd = "";

$link = mysql_connect($dbhost, $dbuser, $dbpasswd)
    or die(mysqli_error($link));

$status = mysql_select_db($dbname, $link) or die(mysqli_error($link));

//echo "Connected Successfully to ". $dbname.'<br>';
