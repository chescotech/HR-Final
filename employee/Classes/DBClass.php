<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
define('DB_SERVER', $_SESSION['DB_SERVER'] ? $_SESSION['DB_SERVER'] : "localhost");
define('DB_USER', $_SESSION['DB_USER'] ? $_SESSION['DB_USER'] : "root");
define('DB_PASS', $_SESSION['DB_PASS'] ? $_SESSION['DB_PASS'] : "");
define('DB_NAME', $_SESSION['DB_NAME'] ? $_SESSION['DB_NAME'] : "hr_fab");
