<?php

include('../../include/dbconnection.php');
session_start();
$id = $_GET['id'];
$todaysDate = date("Y-m-d");
mysql_query("UPDATE employee_discplinary_records SET case_status ='closed', close_date = '$todaysDate' where id='$id'") or die(mysql_error());

echo "<script>
window.location.href = 'view-disciplinary-records.php';
</script>";

?>