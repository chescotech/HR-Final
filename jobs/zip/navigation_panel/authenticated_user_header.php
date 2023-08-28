<?php
session_start();
include('../includes/dbconnection.php');

if (!isset($_SESSION['job_username'])) {
    header('Location:../login.php');
}

$full_names = $_SESSION['comp_name'] . "-" . $_SESSION['job_lname'];

?>

<header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
        <span class="logo-mini"><b></b></span>
        <span class="logo-lg">
            <b>
                <?php
                ?>
            </b>
        </span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        </a>


        <!-- <nav class="navbar navbar-inverse"> -->
        <div class="container-fluid">
            <div class="navbar-header" style="height:66px">
                <a class="navbar-brand" href="#" style="border-radius:100px">
                    <?php
                    // echo '<img style="margin-top:-10px;border-radius:100px" src="../../Admin/' . $CompanyObject->getCompanyLogo($companyId) . '" height="58" >';
                    echo '<img style="margin-top:-10px;border-radius:100px" src="../../Admin/company_logos/logo.png" height="58" >';

                    ?>
                </a>
            </div>
            <ul class="nav navbar-nav">
                <li class="header">
                    <?php //echo ' Welcome to ' . $compName . ' ' . $username; 
                    ?>
                </li>

            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="header"> <a> <?php echo ' Welcome ' . $full_names; ?> </a></li>
                <li class="header"> <a class="fa fa-power-off" href="../logout.php"> <?php  ?></a></li>
            </ul>
        </div>
    </nav>
</header>