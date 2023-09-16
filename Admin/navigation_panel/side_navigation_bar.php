<?php
include_once('../Classes/Group.php');

$GroupObject = new Group();
$groupID = $_SESSION['group_id'];

$userGroup = $GroupObject->getGroupPermissions($groupID);
$permissions = mysql_fetch_assoc($userGroup);

?>

<style>
    ul li a {
        color: black !important;
    }
</style>
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
            <li style="color: black" class="header">MAIN NAVIGATION</li>
            <li>
                <a href="../index">
                    <i class="fa fa-calendar"></i> <span>DashBoard</span>
                    <small class="label pull-right bg-red"></small>
                </a>
            </li>

            <li class="treeview" <?php echo $permissions['company_setup'] == 'false' ? 'hidden' : '' ?>>
                <a href="#">
                    <i class="fa fa-users"></i> <span>Company Setup</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../Company/view-company-record.php"><i class="fa fa-user-plus"></i>Company Setup</a></li>
                    <li><a href="../Departments/add-department"><i class="fa fa-user-plus"></i>Add Department</a></li>
                    <li><a href="../Gradings/employee-gradings"><i class="fa fa-users"></i>Employee Grading</a></li>
                    <li><a href="../employees/add-employee"><i class="fa fa-user-plus"></i>Add Employee</a></li>
                    <li><a href="../Departments/add-hod"><i class="fa fa-user-plus"></i>Add HOD</a></li>
                    <li><a href="../leave/workflow-groups"><i class="fa fa-user-plus"></i>Leave Work flow Groups</a></li>
                    <li><a href="../employees/employees"><i class="fa fa-users"></i>View Employees</a></li>
                    <li><a href="../Departments/view-departments"><i class="fa fa-users"></i>View Departments</a></li>
                    <li><a href="../Departments/view-hod-departments"><i class="fa fa-users"></i>View HOD's</a></li>
                    <li><a href="../Departments/branch"><i class="fa fa-users"></i> Manage Branch </a></li>
                    <li><a href="../Company/comp-structure"><i class="fa fa-users"></i>Company Structure</a></li>
                    <li><a href="../Company/change-password"><i class="fa fa-user-plus"></i>Change Password</a></li>
                    <li><a href="../Company/earnings"><i class="fa fa-user-plus"></i>Employee Earnings</a></li>
                    <li><a href="../Company/deductions"><i class="fa fa-user-plus"></i>Employee Deductions</a></li>
                </ul>
            </li>

            <li class="treeview" <?php echo $permissions['employee'] == 'false' ? 'hidden' : '' ?>>
                <a href="#">
                    <i class="fa fa-info"></i> <span>Employee</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../Qualifications/employee-documents"><i class="fa fa-circle-o"></i>Qualifications</a></li>
                    <li><a href="../Absence/Attendance"><i class="fa fa-circle-o"></i>Attendance Log</a></li>
                    <li><a href="../Absence/todays_attendance"><i class="fa fa-circle-o"></i>Todays Attendance</a></li>
                    <li><a href="../Absence/employee-absence"><i class="fa fa-circle-o"></i>Absence List</a></li>
                    <li><a href="../Disciplinary/view-disciplinary-records"><i class="fa fa-circle-o"></i>Disciplinary Records</a></li>
                </ul>
            </li>

            <li class="treeview" <?php echo $permissions['hr_reports'] == 'false' ? 'hidden' : '' ?>>
                <a href="#">
                    <i class="fa fa-pie-chart"></i><span>HR Reports</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../Graphs/employee-graph"><i class="fa fa-circle-o"></i>Employee Report</a></li>
                    <li><a href="../Graphs/employee-leave-balance"><i class="fa fa-circle-o"></i>Employee Leave Balance</a></li>
                    <li><a href="../Graphs/employee-on-leave"><i class="fa fa-circle-o"></i>Employees On Leave Report</a></li>
                    <li><a href="../Graphs/leave-report"><i class="fa fa-circle-o"></i> Leave Report</a></li>
                    <li><a href="../Graphs/employee-exitsby-reason"><i class="fa fa-circle-o"></i>Employee Exits</a></li>
                    <li><a href="../Graphs/displinary-report"><i class="fa fa-circle-o"></i>Disciplinary Report</a></li>
                </ul>
            </li>

            <li class="treeview" <?php echo $permissions['payroll'] == 'false' ? 'hidden' : '' ?>>
                <a href="#">
                    <i class="fa fa-download"></i> <span>Payroll</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li><a href="../Payslips/pay-slip-entry"><i class="fa fa-circle-o"></i>Add Pay Slip</a></li>
                    <li><a href="../Payslips/view-payslips"><i class="fa fa-circle-o"></i>View Pay Slips</a></li>
                    <li><a href="../Payslips/deduct-leave"><i class="fa fa-circle-o"></i>Deduct Leave Days</a></li>

                    <li><a href="../loans/add-loan"><i class="fa fa-circle-o"></i>Add Loan</a></li>
                    <li><a href="../loans/view-loans"><i class="fa fa-circle-o"></i>View Loans</a></li>
                    <li><a href="../recurring-deductions/create"><i class="fa fa-circle-o"></i>New Recurring Deduction</a></li>
                    <li><a href="../recurring-deductions/view"><i class="fa fa-circle-o"></i>View Recurring Deductions</a></li>
                    <li><a href="../Payslips/payslip-distribution"><i class="fa fa-circle-o"></i>Email Pay Slips</a></li>
                    <li><a href="../Payslips/upload-pay-slip.php"><i class="fa fa-circle-o"></i>Upload Pay Slip</a></li>

                </ul>
            </li>

            <li class="treeview" <?php echo $permissions['reports'] == 'false' ? 'hidden' : '' ?>>
                <a href="#">
                    <i class="fa fa-download"></i> <span>Payroll Reports</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../reports/napsa-report"><i class="fa fa-circle-o"></i>NAPSA Report</a></li>
                    <li><a href="../reports/payee-report"><i class="fa fa-circle-o"></i>PAYE Report</a></li>
                    <li><a href="../reports/whole-report"><i class="fa fa-circle-o"></i>Payroll Report</a></li>


                    <li><a href="../reports/annual-tax-report"><i class="fa fa-circle-o"></i>Annual Tax Report</a></li>
                    <li><a href="../reports/pension-report"><i class="fa fa-circle-o"></i>Pension Report</a></li>
                    <li><a href="../reports/gratuity-report"><i class="fa fa-circle-o"></i>Gratuity Report</a></li>
                    <li><a href="../reports/nhema-report"><i class="fa fa-circle-o"></i>NHIMA Report</a></li>
                </ul>
            </li>
            <li class="treeview" <?php echo $permissions['settings'] == 'false' ? 'hidden' : '' ?>>
                <a href="#">
                    <i class="fa fa-gears"></i> <span>Settings</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../Settings/tax-bands"><i class="fa fa-circle-o"></i>Tax Bands</a></li>
                    <li><a href="../Settings/national-health-insurance"><i class="fa fa-circle-o"></i>National Health Insurance</a></li>
                    <li><a href="../Settings/private-pension"><i class="fa fa-circle-o"></i>Private Pension</a></li>
                    <li><a href="../Settings/leave-settings"><i class="fa fa-circle-o"></i>Leave Ratings</a></li>
                    <li><a href="../Settings/leave-types"><i class="fa fa-circle-o"></i>Leave Types</a></li>
                    <li><a href="../Settings/gratuity_ratings"><i class="fa fa-circle-o"></i>Gratuity Rates</a></li>
                    <li><a href="../Company/holidays"><i class="fa fa-circle-o"></i>Holidays</a></li>
                    <li><a href="../Settings/app_rating"><i class="fa fa-circle-o"></i>Appraisal Ratings</a></li>
                    <li><a href="../Settings/loan-types"><i class="fa fa-circle-o"></i>Loan Types</a></li>
                    <li><a href="../Settings/rd-types"><i class="fa fa-circle-o"></i>Recurring Deduction Types</a></li>
                    <li><a href="../Settings/configure-timesheets"><i class="fa fa-circle-o" aria-hidden="true"></i>Set Timesheets</a></li>
                    <li><a href="../Settings/timesheets"><i class="fa fa-circle-o" aria-hidden="true"></i>View Timesheets</a></li>
                </ul>
            </li>

            <li class="treeview" <?php echo $permissions['recruitment'] == 'false' ? 'hidden' : '' ?>>
                <a href="#">
                    <i class="fa fa-user"></i> <span>Recruitment </span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../Recruitment/postings"><i class="fa fa-circle-o"></i>Postings</a></li>
                    <li><a href="../Recruitment/applications"><i class="fa fa-circle-o"></i>Applications</a></li>
                </ul>
            </li>

            <li class="treeview" <?php echo $permissions['users'] == 'false' ? 'hidden' : '' ?>>
                <a href="#">
                    <i class="fa fa-user"></i> <span>Users </span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../Users/users"><i class="fa fa-circle-o"></i>System users</a></li>

                </ul>
            </li>
            <li class="treeview" <?php echo $permissions['groups'] == 'false' ? 'hidden' : '' ?>>
                <a href="#">
                    <i class="fa fa-group">
                        <span>
                            Groups
                        </span>
                    </i>
                    <i class="fa fa-angle-left pull-right">

                    </i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../Groups/groups"><i class="fa fa-circle-o"></i>User Groups</a></li>
                </ul>
            </li>
            <li class="treeview" <?php echo $permissions['groups'] == 'false' ? 'hidden' : '' ?>>
                <a href="#">
                    <i class="fa fa-group">
                        <span>
                            Publications
                        </span>
                    </i>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../publications/publication.php"> <i class="fa fa-circle-o"></i>Create Publications</a></li>
                    <li><a href="../publications/edit.php"> <i class="fa fa-circle-o"></i> Edit Publications</a></li>
                </ul>
            </li>
        </ul>

    </section>

</aside>