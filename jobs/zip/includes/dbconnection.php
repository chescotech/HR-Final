<?php
$dbhost="localhost";
$dbname="hr_fab";
$dbuser="root";
$dbpasswd="";

$link=mysqli_connect($dbhost, $dbuser, $dbpasswd, $dbname) 
or die (mysqli_connect_error($link));
//echo "Connected Successfully to ". $dbname.'<br>';
