<?php
session_start();

if (!isset($_SESSION['company_ID'])) {
    header('Location:../../logout.php');
}
$companyId = $_SESSION['company_ID'];
include('../../includes/dbconnection.php');
include_once '../Classes/Reminders.php';
include_once '../Classes/Company.php';
$ReminderObject = new Reminders();
$CompanyObject = new Company();
$userId =  $_SESSION['comp_id'];
$compName = $_SESSION['comp_name'];
$username =  ""; //$_SESSION['lastname'];
?>

<header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
        <span class="logo-mini"><b></b></span>
        <span class="logo-lg"><b>
                <?php

                $name = $_SESSION['name'];

                echo $name;
                ?>
            </b></span>
    </a>
    <!--                 <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs">
                            <?php
                            echo 'Welcome  ' . $CompanyObject->getUserDetails($userId);
                            ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu">

                        <li class="user-header">
                            <p>
                                <?php
                                echo 'Welcome  ' . $CompanyObject->getUserDetails($userId);
                                ?>
                            </p>
                        </li>
-->
    <nav class="navbar navbar-static-top" role="navigation">
        <div class="container-fluid">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            </a>

            <!-- <div class="navbar-header">
            
            <a class="navbar-brand" href="#">
                <?php
                echo '<img src="../' . $CompanyObject->getCompanyLogo($companyId) . '" height="100px" >';
                ?>
            </a>
        </div> -->
            <div class="navbar-header" style="height:66px">
                <a class="navbar-brand" href="../index.php" style="border-radius:100px">
                    <?php
                    echo '<img style="margin-top:-10px;border-radius:100px" src="../' . $CompanyObject->getCompanyLogo($companyId) . '" height="58px" >';
                    ?>
                </a>
            </div>
            <ul class="nav navbar-nav">
                <li class="header">
                    <?php //echo ' Welcome to ' . $compName . ' ' . $username; 
                    ?>
                </li>
                <li class="header"> <a> <?php //echo $compName . ' ' . $username; 
                                        ?> </a></li>

            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="header"> <a> Welcome Admin</a></li>
                <li class="header"> <a class="fa fa-bell-o" href="../reminders/show-reminders"> Notifications</a></li>
                <li class="header"> <a class="fa fa-power-off" href="../../logout.php"> <?php  ?></a></li>
            </ul>
        </div>
    </nav>
</header>