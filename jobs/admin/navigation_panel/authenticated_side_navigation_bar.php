
<?php 
require_once("../../../logs.php");
error_reporting(0);
$create_log = new Logs();
?>

<ul class="sidebar-menu">

    <li style="color: white" class="header">MAIN NAVIGATION</li>
    <li class="<?php if ($_SESSION['activeLink'] == 'jobs') echo 'active'; ?>">
        <a href="../jobs/job-list">
            <i class="fa fa-briefcase"></i> <span>Jobs Menu</span>
            <small class="label pull-right bg-red"></small>
        </a>
    </li>

    <li>
        <a href="../applicants/applicant-list">
            <i class="fa fa-graduation-cap"></i> <span>Candidates</span>
        </a>
    </li>

    <li>
        <a href="../talent-pool/pool">
            <i class="fa fa-check"></i> <span>Talent Pool</span>
        </a>
    </li>

 
    <li class="treeview">
        <a href="#">
            <i class="fa fa-pie-chart"></i><span>Administration</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="../administration/users"><i class="fa fa-user"></i>Manage Users</a></li>

        </ul>
    </li>

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
    <input hidden value="<?php echo $_SESSION['job_email'] ?>" name="email" type="text">
    <input hidden value="<?php echo $_SESSION['jobs_passport'] ?>" name="password" type="password">
</form>

<script>
    function sendLogin(event) {
        document.getElementById('loginForm').submit();
    }
</script>