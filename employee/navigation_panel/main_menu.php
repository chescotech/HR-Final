<?php

session_start();
include('../include/dbconnection.php');

include_once '../Admin/Classes/Company.php';
$CompanyObject = new Company();
$companyId = $_SESSION['company_ID'];
$employeeId = $_SESSION['employee_id'];

$result = mysqli_query($link, "SELECT * FROM emp_info where empno='$employeeId'") or die(mysqli_error($link));
$row = mysqli_fetch_array($result);
$full_names = $row['fname'] . "-" . $row['lname'];
?>
<!-- <nav class="navbar navbar-static-top" role="navigation">
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    </a>
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                    <?php
                    $employeeId = $_SESSION['employee_id'];
                    $user_query = mysqli_query($link, "select * from emp_info where id='$employeeId'") or die(mysqli_error($link));
                    while ($row = mysqli_fetch_array($user_query)) {
                        $id = $row['id'];
                    ?>

                        <?php
                        $photo = "uploads/" . $row['photo'];
                        $check_pic = $row['photo'];
                        if (!file_exists($photo) || $check_pic == false) {
                            $photo = "Images/icon.png";
                        }
                        ?>

                        <img src="<?php echo $photo; ?>" class="user-image">

                    <?php } ?>

                    <span class="hidden-xs">
                        <?php
                        $result = mysqli_query($link, "SELECT * FROM emp_info where empno='$employeeId' ") or die(mysqli_error($link));
                        $row = mysqli_fetch_array($result);
                        echo 'Welcome  ' . $row['fname'] . "-" . $row['lname'];
                        ?>
                    </span>

                </a>
                <ul class="dropdown-menu">
                    <li class="user-header">
                        <?php

                        $user_query = mysqli_query($link, "select * from emp_info where empno='$employeeId'") or die(mysqli_error($link));
                        while ($row = mysqli_fetch_array($user_query)) {
                            $id = $row['id'];
                        ?>

                            <?php
                            $photo = "uploads/" . $row['photo'];
                            $check_pic = $row['photo'];
                            if (!file_exists($photo) || $check_pic == false) {
                                $photo = "Images/icon.png";
                            }
                            ?>

                            <img src="<?php echo $photo;  ?>" class="user-image">

                        <?php } ?>
                        <p>

                            <?php
                            $result = mysqli_query($link, "SELECT * FROM emp_info where empno='$employeeId'") or die(mysqli_error($link));
                            $row = mysqli_fetch_array($result);
                            echo 'Welcome  ' . $row['fname'] . "-" . $row['lname'];
                            ?>
                        </p>

                    </li>

                    <li class="user-footer">
                        <div class="pull-right">
                            <a href="../logout.php" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                    </li>

                </ul>

            </li>

        </ul>
    </div>
</nav> -->

<nav class="navbar navbar-static-top" role="navigation">

    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    </a>


    <!-- <nav class="navbar navbar-inverse"> -->
    <div class="container-fluid">
        <div class="navbar-header" style="height:66px">
            <a class="navbar-brand" href="#" style="border-radius:100px">
                <?php
                echo '<img style="margin-top:-10px;border-radius:100px" src="../Admin/' . $CompanyObject->getCompanyLogo($companyId) . '" height="58" >';
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