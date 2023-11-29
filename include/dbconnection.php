<?php
// if session not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// $dbhost = "localhost";
// $dbname = "hr_fab";
// $dbuser = "root";
$dbhost = $_SESSION['DB_SERVER'];
$dbname = $_SESSION['DB_NAME'];
$dbuser = $_SESSION['DB_USER'];
$dbpasswd = "";

$link = mysqli_connect($dbhost, $dbuser, $dbpasswd, $dbname) or die(mysqli_connect_error());

//echo "Connected Successfully to ". $dbname.'<br>';
