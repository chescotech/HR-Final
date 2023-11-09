<?php
include('../../../../include/dbconnection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM talent_pool WHERE id ='$id'";
    $result = mysqli_query($link, $query, $link) or die(mysqli_error($link));

    echo "<script> window.location='pool' </script>";
}
