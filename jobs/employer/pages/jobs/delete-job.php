<?php
include('../../navigation_panel/dbconnection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM jobs_postings WHERE id ='$id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    echo "<script> window.location='job-list' </script>";
}
