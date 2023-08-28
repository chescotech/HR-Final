<aside class="main-sidebar">

    <section class="sidebar">

        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>

        <ul class="sidebar-menu">
            <li style="color: white" class="header">MAIN NAVIGATION</li>
            <li>
                <a href="../index">
                    <i class="fa fa-calendar"></i> <span>DashBoard</span>
                    <small class="label pull-right bg-red"></small>
                </a>

            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-clock-o"></i> <span>My Attendance</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../Attendance/log-attendance"><i class="fa fa-circle-o"></i>Log Attendance</a></li>
                    <li><a href="../Attendance/my-attendance"><i class="fa fa-circle-o"></i>My Attendance</a></li>  
                      <li><a href="../Attendance/out-office-attendance"><i class="fa fa-circle-o"></i>Out of Office Attendance</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-download"></i> <span>My Leave</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../leave/apply"><i class="fa fa-circle-o"></i>Apply for Leave</a></li>
                    <li><a href="../leave/my-leave"><i class="fa fa-circle-o"></i>Leave History</a></li>
                    <li><a href="../leave/leave-balance"><i class="fa fa-circle-o"></i>Leave Balance</a></li> 
                </ul>
            </li>
            
              <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i> <span>My Loans</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../loan/apply"><i class="fa fa-circle-o"></i>Apply for Loan</a></li>
                </ul>
            </li>


            <li>
                <a href="../Payslips/my-payslips">
                    <i class="fa fa-money"></i> <span>My Pay slips</span>
                    <small class="label pull-right bg-red"></small>
                </a>
            </li>

            <li>
                <a href="../EmployeeHistory/Education">
                    <i class="fa fa-book"></i> <span>Employment History</span>
                    <small class="label pull-right bg-red"></small>
                </a>
            </li>

            <?php
            include_once '../Classes/Leave.php';
            $leaveObject = new Leave();
            $empno = $_SESSION['employee_id'];
            $chekcIfSupervisor = $leaveObject->checkifHod($empno);

            if ($leaveObject->checkIfLeaveApprover($empno) == "true") {
                echo ' <li class="treeview">
                    <a href="#">
                        <i class="fa fa-warning"></i> <span>Leave Approval</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="../leave/people-on-leave"><i class="fa fa-circle-o"></i>People on Leave</a></li>
                        <li><a href="../leave/pending-leaves"><i class="fa fa-circle-o"></i>Pending Leaves</a></li>               
                    </ul>
                </li>';
            }

            if (mysql_num_rows($chekcIfSupervisor) != 0) {
                $row = mysql_fetch_array($chekcIfSupervisor);
                $_SESSION['supervisorDepartmentId'] = 1;


                echo '<li class="treeview">
                    <a href="#">
                        <i class="fa fa-gears"></i> <span>Performance Management</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="../Perfomance/period"><i class="fa fa-circle-o"></i>Assessment Period</a></li>
                        <li><a href="../Perfomance/factors"><i class="fa fa-circle-o"></i>Assessment Objectives</a></li>
                        <li><a href="../Perfomance/params"><i class="fa fa-circle-o"></i>Assessment Parameters</a></li>
                        <li><a href="../Perfomance/appraisal_periods"><i class="fa fa-circle-o"></i>Assessment Appraisals</a></li>
                        <li><a href="../Perfomance/assessment_groups"><i class="fa fa-circle-o"></i>Assessment Groups</a></li>
                    </ul>
                </li>';

                echo '<li class="treeview">
                    <a href="#">
                        <i class="fa fa-gears"></i> <span>Submitted Appraisals</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="../Perfomance/sup_appraisals"><i class="fa fa-circle-o"></i>Submitted Appraisals</a></li>
                        <li><a href="../Perfomance/emp_appraisals"><i class="fa fa-circle-o"></i>My Appraisals</a></li>
                    </ul>
                </li>';
                echo '<li class="treeview">
                <a href="#">
                    <i class="fa fa-gears"></i> <span>My Department</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../Attendance/attendance"><i class="fa fa-circle-o"></i>View attendance</a></li>
                      <li><a href="../Attendance/my-department"><i class="fa fa-circle-o"></i>View Employees in Department</a></li>
                </ul>
            </li>';
            } else {
                echo '
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user"></i> <span>My Appraisals</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="../Perfomance/emp_appraisals"><i class="fa fa-circle-o"></i>My Appraisals</a></li>
                    </ul>
                </li>
            ';
            }
            ?>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i> <span>Profile</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../profile/profile"><i class="fa fa-circle-o"></i>Profile Info</a></li>
                    <li><a href="../profile/change-password"><i class="fa fa-circle-o"></i>Change Password</a></li>               
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i> <span>Jobs </span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../Recruitment/postings"><i class="fa fa-circle-o"></i>Jobs Postings</a></li>
                    <!-- <li><a href="../Recruitment/my-app"><i class="fa fa-circle-o"></i>Change Password</a></li>                -->
                </ul>
            </li>

        </ul>

    </section>

</aside>
