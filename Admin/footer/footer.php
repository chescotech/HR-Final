<footer class="main-footer">       
    <center>
        <?php
        $yr = date("Y");
        $companyName = $_SESSION['name'];
        echo '<center>'
        . '<strong>Copyright &copy; '.$yr.' <a href="">' . $companyName . '</a>.</strong> All rights reserved.';
        ?>
    </center>
</footer>




