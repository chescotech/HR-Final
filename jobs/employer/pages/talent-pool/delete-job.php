<?php
include('../../navigation_panel/dbconnection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // clear any applications added to this talent pool
    $updateQuery = "UPDATE `jobs_user_applications` SET talent_pool_id = 0 WHERE talent_pool_id = ' $id '";
    // delete the talent pool
    $query = "DELETE FROM `talent_pool` WHERE id = ' $id '";

    $resultUpdate = mysql_query($updateQuery, $link) or die(mysql_error());
    $resultDelete = mysql_query($query, $link) or die(mysql_error());

    // Redirect to the desired page after successful execution
    // Redirect back to the previous page
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
