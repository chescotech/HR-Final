
<?php include '../../include/dbconnection.php'?>
<?php  
 if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Delete the row from the database
    $sql = "DELETE FROM publications WHERE id = '$id'";
    $result = mysql_query($sql, $link); // Make sure you have $link defined

    if ($result) {
        echo 'success';
    } else {
        echo 'error';
    }
}; 

?>