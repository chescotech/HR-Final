<?php
$dbms="mysql";
$dbhost="localhost";
$dbname="lso_pricing_db";
$dbuser="root";
$dbpasswd="";

$link=mysql_connect($dbhost, $dbuser, $dbpasswd) 
or die (mysql_error());

$status = mysql_select_db($dbname, $link) or die (mysql_error());

//echo "Connected Successfully to ". $dbname.'<br>';

?>