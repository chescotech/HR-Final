<?php 
include('../../../../include/dbconnection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $pool = $_GET['pool'];

    $query = "UPDATE `jobs_user_applications` SET talent_pool_id='0' WHERE user_id='$id'";
    $result = mysql_query($query, $link) or die(mysql_error());

    echo "<script> window.location='talent-pool-candidates.php?pool_id=$pool' </script>";
}
