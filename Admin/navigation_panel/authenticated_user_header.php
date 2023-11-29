<?php
$companyId = $_SESSION['company_ID'];
include_once '../../include/dbconnection.php';
include_once '../Classes/DBClass.php';
include_once '../Classes/Reminders.php';
include_once '../Classes/Company.php';
include_once '../Classes/Group.php';
$GroupObject = new Group();
$ReminderObject = new Reminders();
$CompanyObject = new Company();
$userId = $_SESSION['user_id'];
$compName = $_SESSION['name'];
$username = ""; //$_SESSION['lastname'];

$hasPermission = $GroupObject->checkUserPermission($_SESSION['group_id'], $_SERVER['PHP_SELF']);
if (!isset($_SESSION['company_ID'])) {
    header('Location:../../logout.php');
    exit;
}

if ($hasPermission == 'false') {
    header('Location:../index.php');
    exit;
}

?>

<header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
        <span class="logo-mini"><b></b></span>
        <span class="logo-lg" style="color: black;"><b>
                <?php
                $name = $_SESSION['name'];
                ?>
            </b></span>
    </a>
    <!-- <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-danger"><?php
                                                            //                            echo $ReminderObject->checkForReminders($companyId);
                                                            ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"> <a class="fa fa-bell-o" href="../reminders/show-reminders"> You have
    <?php
    //                          echo $ReminderObject->checkForReminders($companyId);
    ?>
                                notifications</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown user user-menu">
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

                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="../../logout.php" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav> -->
    <nav class="navbar navbar-static-top" role="navigation">
        <div class="container-fluid">
            <a style="color: black;" href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
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
                <li class="header"> <a style="color: black;"> Welcome Admin</a></li>
                <li class="header"> <a style="color: black;" class="fa fa-power-off" href="../logout.php"> <?php ?></a></li>
            </ul>
        </div>
    </nav>
</header>