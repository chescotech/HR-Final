<?php

include('../../include/dbconnection.php');
session_start();
$id = $_GET['id'];

mysqli_query($link,"delete from employee_discplinary_records where id='$id'") or die(mysqli_error($link));

echo "<script>
    window.location.href = 'view-disciplinary-records';
    </script>";
