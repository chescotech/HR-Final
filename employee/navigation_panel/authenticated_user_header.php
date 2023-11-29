<?php
error_reporting(0);
ini_set('display_errors', 1);

include('../../include/dbconnection.php');

if (!isset($_SESSION['employee_id'])) {
    header('Location:../../login.php');
}
include_once '../../Admin/Classes/Company.php';
include_once '../../Admin/Classes/DBClass.php';
$CompanyObject = new Company();
$companyId = $_SESSION['company_ID'];
$employeeId = $_SESSION['employee_id'];

$result = mysqli_query($link, "SELECT * FROM emp_info where empno='$employeeId'") or die(mysqli_error($link));
$row = mysqli_fetch_array($result);
$full_names = $row['fname'] . "-" . $row['lname'];
?>

<header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
        <span class="logo-mini"><b></b></span>
        <span class="logo-lg">
            <b style="color: black;">
                <?php
                $companyName = $_SESSION['company_name'];
                //echo $companyName;
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
                    echo '<img style="margin-top:-10px;border-radius:100px" src="../../Admin/' . $CompanyObject->getCompanyLogo($companyId) . '" height="58" >';
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
                <li class="header"> <a style="color: black;"> <?php echo ' Welcome ' . $full_names; ?> </a></li>
                <li class="header"> <a class="fa fa-power-off" style="color: black;" href="../logout.php"> <?php  ?></a></li>
            </ul>
        </div>
    </nav>
</header>