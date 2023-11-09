<?php
$dbms="mysql";
$dbhost="localhost";
$dbname="pay";
$dbuser="root";
$dbpasswd="";

//Establish connection
$link=mysqli_connect($dbhost, $dbuser, $dbpasswd, $dbname) 
or die (mysqli_connect_error());
//echo "Connected Successfully to ". $dbname.'<br>';
