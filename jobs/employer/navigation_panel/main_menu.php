<?php

// session_start();
include('dbconnection.php');

$full_names = $_SESSION['name'];
?>





<style>
    .nav-container .navbar-header {
        display: flex;
        justify-content: flex-start;

    }

    .nav-container .nav {
        display: flex;
        justify-content: flex-end;

    }

    @media (max-width: 768px) {

        .nav-container .nav {
            margin-top: -5rem;

        }
    }
</style>

<nav class="navbar navbar-static-top d-flex" role="navigation" style="padding:1rem; background: linear-gradient(to right, #02B9FD, #2ECC71) !important;">

    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    </a>


    <!-- <nav class="navbar navbar-inverse"> -->
    <div class="container-fluid nav-container">
        <div class="navbar-header" style="height:66px">
            <a class="navbar-brand" href="#" style="border-radius:100px">
                <?php
                echo '<img style="margin-top:-10px;border-radius:100px" src="/jobs/assets/images/logo45.jpeg" height="58" >';
                ?>
            </a>
        </div>
        <ul class="nav navbar-nav navbar-right d-flex">
            <li class="header"> <a> <?php echo ' Welcome ' . $full_names; ?> </a></li>
            <li class="header"> <a class="fa fa-power-off" href="/jobs/logout.php"> <?php  ?></a></li>
        </ul>
    </div>
    </div>
</nav>