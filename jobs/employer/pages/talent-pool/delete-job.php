<?php
include('../../navigation_panel/dbconnection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // clear any applications added to this talent pool
    $updateQuery = "UPDATE `jobs_user_applications` SET talent_pool_id = 0 WHERE talent_pool_id = ' $id '";
    // delete the talent pool
    $query = "DELETE FROM `talent_pool` WHERE id = ' $id '";

    $resultUpdate = mysqli_query($link, $updateQuery) or die(mysqli_error($link));
    $resultDelete = mysqli_query($link, $query) or die(mysqli_error($link));

    // Redirect to the desired page after successful execution
    // Redirect back to the previous page
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
