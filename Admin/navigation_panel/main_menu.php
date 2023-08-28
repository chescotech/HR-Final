<?php
session_start();
if (!isset($_SESSION['company_ID'])) {
    header('Location:../logout.php');
}

include_once('../include/dbconnection.php');
include_once '../Admin/Classes/Company.php';
include_once '../Admin/Classes/Reminders.php';
$ReminderObject = new Reminders();
$CompanyObject = new Company();
$companyId = $_SESSION['company_ID'];
$userId =  $_SESSION['user_id'];
$compName = $_SESSION['name'];
$username =  $_SESSION['firstname'];

?>

<nav class="navbar navbar-static-top" role="navigation">
    <!-- <nav class="navbar navbar-inverse"> -->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    </a>

    <!-- <nav class="navbar navbar-inverse"> -->
    <div class="container-fluid">
        <div class="navbar-header" style="height:66px">
            <a class="navbar-brand" href="#" style="border-radius:100px">
                <?php
                echo '<img style="margin-top:-10px;border-radius:100px" src="' . $CompanyObject->getCompanyLogo($companyId) . '" height="60px" >';
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
            <li class="header"> <a style="color: black;"> Welcome <?php echo  $username; ?></a></li>
            <li class="header"> <a style="color: black;" class="fa fa-bell-o" href="reminders/show-reminders"> Notifications</a></li>
            <li class="header"> <a style="color: black;" class="fa fa-power-off" href="../logout.php"> <?php  ?></a></li>
        </ul>
    </div>
</nav>