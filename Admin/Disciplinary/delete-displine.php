<?php

include('../../include/dbconnection.php');
session_start();
$id = $_GET['id'];

mysql_query("delete from employee_discplinary_records where id='$id'") or die(mysql_error());

echo "<script>
    window.location.href = 'view-disciplinary-records';
    </script>";
?>