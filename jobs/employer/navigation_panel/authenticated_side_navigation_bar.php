<?php
require_once("../../../logs.php");

$create_log = new Logs();
?>



<style>
.sidebar-menu{
margin-top: 4rem;
background: white !important;

}

.main-sidebar{
    background: white;
}

ul li a:hover {
    background: #2ecc71 !important;
}

ul li a {
    color: black !important;
}

.main-sidebar .sidebar,
            .sidebar-form {
                background: white !important;
            }

            .skin-blue .sidebar-menu>li.header {
                color: black !important;
                background: #fff !important;

            }

            .skin-blue .wrapper,
            .skin-blue .main-sidebar,
            .skin-blue .left-side {
                background-color: #fff !important;
            }

            .skin-blue .sidebar-form input[type="text"],
            .skin-blue .sidebar-form .btn {

                background-color: #fff !important;

            }

</style>



<ul class="sidebar-menu" style="margin-top:-2rem;">

    <li style="color: white" class="header">MAIN NAVIGATION</li>
    <li>
        <a href="../jobs/job-list">
            <i class="fa fa-briefcase"></i> <span>Jobs Menu</span>
            <small class="label pull-right bg-red"></small>
        </a>
    </li>

    <li >
        <a href="../applicants/applicant-list">
            <i class="fa fa-graduation-cap"></i> <span>Candidates</span>
        </a>
    </li>

    <li>
        <a href="../talent-pool/pool">
            <i class="fa fa-check"></i> <span>Talent Pool</span>
        </a>
    </li>

    <!-- <li>
        <a href="../departments/index">
            <i class="fa fa-check"></i> <span>Departments</span>
        </a>
    </li> -->

    <!-- <li class="treeview">
        <a href="#">
            <i class="fa fa-pie-chart"></i><span>Administration</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="../administration/users"><i class="fa fa-user"></i>Manage Users</a></li>
            <li><button style="
                                padding: 5px 5px 5px 15px;
                                background-color: transparent;
                                outline: none;
                                border: none;
                                color: #fff;
                                display: block;
                                font-size: 14px;" onclick="sendLogin(this)">
                    <i class="fa fa-circle-o"></i>Evaluation Forms</button></li>
        </ul>
    </li> -->

    <li class="treeview">
        <a href="#">
            <i class="fa fa-pie-chart"></i><span>Reports</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="../Reports/candidate-overview.php"><i class="fa fa-circle-o"></i>Candidate Overview Report</a></li>
            <li><a href="../Reports/job-insights"><i class="fa fa-circle-o"></i>Job Status Insights</a></li>


        </ul>
    </li>

</ul>


<form id="loginForm" method="post" action="http://localhost/interview/index.php/login/verifylogin">
    <input hidden value="<?php echo $_SESSION['comp_username'] ?>" name="email" type="text">
    <input hidden value="<?php echo $_SESSION['jobs_passport'] ?>" name="password" type="password">
</form>

<script>
    function sendLogin(event) {
        document.getElementById('loginForm').submit();
    }
</script>