<?php
include_once '../include/dbconnection.php';

session_start();
// if emplyee
if (isset($_SESSION['empno'])) {
    // get session variables
    $empnum = $_SESSION['empno'];
    $companyId = $_SESSION['company_ID'];

    // log
    $action = "LOGOUT";
    $log_logout = mysql_query("INSERT INTO login_log(empno, action, company_id) VALUES('$empnum', '$action', '$companyId')") or die(mysql_error());
}
// here is reset all the sessions so that the system contains no session .. 
session_unset();
session_destroy();

?>
<script>
    window.location.href = '../index.php';
</script>
<?php

?>