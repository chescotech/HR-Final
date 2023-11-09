<?php
// Inialize session
session_start();

// retrieve client name
$client = $_SESSION['CLIENT_NAME'];


// Delete certain session
unset($_SESSION['username']);
// Delete all session variables
session_destroy();
// Jump to login page
header("Location: ../../{$client}");
