<?php 
include('../../../../include/dbconnection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM jobs_postings WHERE id ='$id'";
    $result = mysql_query($query, $link) or die(mysql_error());

    echo "<script> window.location='job-list' </script>";
}
