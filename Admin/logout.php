<?php 

// here is reset all the sessions so that the system contains no session .. 

session_start();
session_unset();
session_destroy();

?>
    <script>   
         window.location.href = '../index.php';
    </script>
    <?php
 
?>

