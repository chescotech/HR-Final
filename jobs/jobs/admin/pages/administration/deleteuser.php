<?php
include('../../../../include/dbconnection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM jobs_users WHERE id ='$id'";
    $result = mysqli_query($link, $querye(mysqli_error($link));

    echo "<script> window.location='users' </script>";
}
