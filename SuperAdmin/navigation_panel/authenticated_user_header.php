
<?php
session_start();

if (!isset($_SESSION['employee_id'])) {
    header('Location:../../logout.php');
}

include('../../include/dbconnection.php');
?>

<header class="main-header">
 
    <nav class="navbar navbar-static-top" role="navigation">        
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs">
                            <?php
                            $fname = $_SESSION['firstname'];
                            $lname = $_SESSION['lastname'];
                            
                            echo "Welcome : ". $fname." ".$lname;
                            ?> 
                        </span>
                    </a>
                    <ul class="dropdown-menu">

                        <li class="user-header">                         
                            <p>
                                <?php
                                echo "Welcome : ". $fname." ".$lname;
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
    </nav>
</header>

