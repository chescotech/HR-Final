<?php
$dbms="mysql";
$dbhost="localhost";
$dbname="lso_pricing_db";
$dbuser="root";
$dbpasswd="";

$link=mysql_connect($dbhost, $dbuser, $dbpasswd) 
or die (mysqli_error($link));

$status = mysql_select_db($dbname, $link) or die (mysqli_error($link));

//echo "Connected Successfully to ". $dbname.'<br>';
