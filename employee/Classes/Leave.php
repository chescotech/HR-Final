<?php

include_once 'DBClass.php';

class Leave {

    function __construct() {
        $conn = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die('db connection problem' . mysql_error());
        mysql_select_db(DB_NAME, $conn);
    }

    public function applyLeave($startLeave, $endLeave, $leaveType, $empNo, $reasonLeave, $contact, $contact_person, $address_on_leave, $file, $leaveDays) {
        $status = "Pending Approval";
        $today = date("Y-m-d");
        $res = mysql_query("INSERT INTO leave_applications_tb(leave_start_date,leave_end_date,"
                . "leave_type,empno,status,reason_leave,contact,contact_person,address_on_leave,file_proof,application_date,level,days)"
                . " VALUES('$startLeave','$endLeave','$leaveType','$empNo','$status'"
                . ",'$reasonLeave','$contact','$contact_person','$address_on_leave','$file','$today','1','$leaveDays')");
        return $res;
    }

    public function getLeaveDaysAppliedFor($empno, $application_id) {
        $res = mysql_query("SELECT * FROM `leave_applications_tb` WHERE empno='$empno' AND application_id='$application_id')");
        $rows = mysql_fetch_array($res);
        $days = $rows['days'];
        return $days;
    }

    public function getEmployeeFinalLevelApprovals($empno) {
        $res = mysql_query("SELECT MAX(level) AS level FROM `appover_groups` WHERE work_flow_id ="
                . " (SELECT leaveworkflow_id FROM `emp_info` WHERE empno='$empno')");
        $rows = mysql_fetch_array($res);
        $level = $rows['level'];
        return $level;
    }

    public function getAttachementStatus($leaveType) {
        $res = mysql_query(" SELECT * FROM `leave_tb` where leave_type= '$leaveType' ");
        $rows = mysql_fetch_array($res);
        $required_atttachement = $rows['required_atttachement'];
        return $required_atttachement;
    }

    public function getMaxLeaveDaysApplicable($leaveType) {
        $res = mysql_query(" SELECT * FROM `leave_tb` where leave_type= '$leaveType' ");
        $rows = mysql_fetch_array($res);
        $max_leave_days = $rows['max_leave_days'];
        return $max_leave_days;
    }

    public function getNumberofDaysByLeaveType($leaveType, $empno) {
        $res = mysql_query(" SELECT SUM(days) AS no_days FROM `leave_applications_tb` where YEAR(application_date) = YEAR(NOW()) AND status='Approved' AND leave_type=' $leaveType'  AND  empno='$empno'  ");
        $rows = mysql_fetch_array($res);
        $no_days = $rows['no_days'];
        return $no_days;
    }

    public function getDeductStatus($leaveType) {
        $res = mysql_query(" SELECT * FROM `leave_tb` where leave_type= '$leaveType' ");
        $rows = mysql_fetch_array($res);
        $is_deductible = $rows['is_deductible'];
        return $is_deductible;
    }

    public function getAttendanceLogList($logDate, $empno) {

        $arr = explode("/", $logDate);
        list($Getmonth, $Getday, $GetYear) = $arr;

        $year = $GetYear;
        $month = $Getmonth;
        $day = $Getday;

        $firstDate = $year . "/" . $month . "/" . "01";
        $endDate = $year . "/" . $month . "/" . "31";

        $res = mysql_query("SELECT * FROM attendance_logs WHERE log_date BETWEEN '$firstDate' AND '$endDate' AND "
                . " empno = '$empno'");
        return $res;
    }

    function checkIfApplicatantisHod($empno) {
        $status = "";
        $query = mysql_query(" SELECT * FROM hod_tb WHERE empno  = '$empno' ");
        if (mysql_num_rows($query) > 0) {
            $status = "true";
        } else {
            $status = "false";
        }
        return $status;
    }

    function getCheckInTime($id) {
        $query = mysql_query("SELECT * FROM  attendance_logs WHERE status = 'in' AND id= '$id' ");
        $rows = mysql_fetch_array($query);
        $loginTime = $rows['log_time'];
        return $loginTime;
    }

    function getCheckOutTime($id) {
        $query = mysql_query("SELECT * FROM  attendance_logs WHERE status = 'out' AND id= '$id'");
        $rows = mysql_fetch_array($query);
        $loginTime = $rows['log_time'];
        return $loginTime;
    }

    public function getLeaveTypes($companyId) {
        $result = mysql_query("SELECT * FROM leave_tb WHERE companyID = '$companyId' ");
        return $result;
    }

    function timeDiff($firstTime, $lastTime) {
        $firstTime = strtotime($firstTime);
        $lastTime = strtotime($lastTime);

        $timeDiff = $lastTime - $firstTime;

        $years = abs(floor($timeDiff / 31536000));
        $days = abs(floor(($timeDiff - ($years * 31536000)) / 86400));
        $hours = abs(floor(($timeDiff - ($years * 31536000) - ($days * 86400)) / 3600));
        $mins = abs(floor(($timeDiff - ($years * 31536000) - ($days * 86400) - ($hours * 3600)) / 60));

        if ($firstTime > $lastTime) {
            $timeworked = "Time Error";
        } else {
            $timeworked = $hours . " Hours, " . $mins . " Minutes";
        }

        return $timeworked;
    }

    public function getWorkFlowApprovers($empno) {
        $res = mysql_query("SELECT * FROM `workflows` INNER JOIN appover_groups on appover_groups.work_flow_id=workflows.id
        INNER join emp_info on  emp_info.empno=appover_groups.empno
        WHERE  workflows.id IN ( SELECT emp_info.leaveworkflow_id from emp_info where empno='$empno') AND appover_groups.level=1");

        $rows = mysql_fetch_array($res);
        $email = $rows['email'];
        return $email;
    }

    public function applyLeaveWithoutAtatachments($startLeave, $endLeave, $leaveType, $empNo, $reasonLeave, $contact, $contact_person, $address_on_leave, $leaveDays) {
        $status = "Pending Approval";
        $today = date("Y-m-d");
        $res = mysql_query("INSERT INTO leave_applications_tb(leave_start_date,leave_end_date,"
                . "leave_type,empno,status,reason_leave,contact,contact_person,address_on_leave,file_proof,application_date,level,days)"
                . " VALUES('$startLeave','$endLeave','$leaveType','$empNo','$status'"
                . ",'$reasonLeave','$contact','$contact_person','$address_on_leave','','$today','1','$leaveDays')");
        return $res;
    }

    public function veiwLeave($empno) {
        $res = mysql_query("SELECT * FROM leave_applications_tb WHERE empno='$empno' ");
        return $res;
    }

    public function GetAllDepartmentsByCompany($companyID) {
        $result = mysql_query("SELECT * FROM department WHERE company_ID='$companyID'");
        return $result;
    }

    public function veiwPendingLeave($empno) {
        $res = mysql_query("SELECT * FROM leave_applications_tb  ");
        return $res;
    }

    public function checkifHod($empno) {
        $res = mysql_query("SELECT * FROM hod_tb WHERE empno='$empno'");
        return $res;
    }

    public function checkIfLeaveApprover($empno) {
        $status = "";
        $res = mysql_query("SELECT * FROM `appover_groups` WHERE empno='$empno'");
        if (mysql_num_rows($res) != 0) {
            $status = "true";
        } else {
            $status = "false";
        }
        return $status;
    }

    public function veiwLeaveBalance($empno) {
        $res = mysql_query("SELECT * FROM leave_applications_tb WHERE empno='$empno' AND status ='Approved' ORDER BY application_id DESC ");
        return $res;
    }

    public function checkLeaveDays($empono) {
        $res = mysql_query("SELECT * FROM leave_days WHERE empno='$empono'");
        return $res;
    }

    public function getEmployeeSupervisor($employeeId) {
        $res = mysql_query("SELECT * FROM emp_info WHERE empno='$employeeId'");
        $rows = mysql_fetch_array($res);
        $department = $rows['dept'];

        $hodQuery = mysql_query("SELECT * FROM hod_tb WHERE departmentId='$department'");
        $hodRows = mysql_fetch_array($hodQuery);
        $hodsEmpno = $hodRows['empno'];

        $getHodDataQuery = mysql_query("SELECT * FROM emp_info WHERE empno='$hodsEmpno'");
        $hodsInfoRows = mysql_fetch_array($getHodDataQuery);
        $hodsEmail = $hodsInfoRows['email'];
        return $hodsEmail;
    }

    public function getLeaveApplicantDetails($empono) {
        $res = mysql_query("SELECT * FROM emp_info WHERE empno='$empono'");
        return $res;
    }

    public function getPendingApprovals($supervisorsDeptId) {
        $res = mysql_query("SELECT * FROM leave_applications_tb lv, emp_info em WHERE lv.empno IN "
                . "(SELECT em.empno FROM pay.emp_info WHERE dept='$supervisorsDeptId') AND lv.status !='Approved' AND lv.status!='Declined';");
        return $res;
    }

    public function checkIfAttachmentExsists($applicationId) {
        $status = "";
        $res = mysql_query("SELECT * FROM leave_applications_tb WHERE application_id = '$applicationId'");
        $rows = mysql_fetch_array($res);
        $fileProof = $rows['file_proof'];
        if ($fileProof == "") {
            $status = "false";
        } else {
            $status = "true";
        }
        return $status;
    }

    public function peopleOnleave($supervisorsDeptId) {
        $res = mysql_query("SELECT * FROM leave_applications_tb lv, emp_info em WHERE lv.empno IN "
                . "(SELECT em.empno FROM pay.emp_info WHERE dept='$supervisorsDeptId') AND lv.status ='Approved' ;");
        return $res;
    }

    public function getPeopleAbsent($companyId) {
        $res = mysql_query("SELECT * FROM leave_applications_tb WHERE empno = (SELECT empno FROM emp_info WHERE company_id = '$companyId' ) AND status ='Approved'");
        return $res;
    }

    public function getDeptLeaveName($supervisorsDeptId) {
        $res = mysql_query("SELECT * FROM department WHERE dep_id='$supervisorsDeptId'");
        $row = mysql_fetch_array($res);
        $deptname = $row['department'];
        return $deptname;
    }

    public function checkForExpiredLeaves($LeaveEndDate) {
        $EndDateConverted = date('Y-m-d', strtotime($LeaveEndDate));
        $state = "";
        $todaysDate = date("Y-m-d");
        if ($EndDateConverted < $todaysDate) {
            $state = "true";
        } else {
            $state = "false";
        }
        return $state;
    }

    public function checkIfCvExsists($empno) {
        $res = mysql_query(" SELECT * FROM certificates_tb where empno='$empno' AND id = ( SELECT MAX(id) FROM certificates_tb WHERE empno='$empno' ) ");
        $rows = mysql_fetch_array($res);
        if (mysql_num_rows($res) != 0) {
            $cv = $rows['cv'];
            return $cv;
        }
    }

    public function checkIfCertificateExsists($empno) {
        $res = mysql_query(" SELECT * FROM certificates_tb where empno='$empno' AND id = ( SELECT MAX(id) FROM certificates_tb WHERE empno='$empno' ) ");
        $rows = mysql_fetch_array($res);
        if (mysql_num_rows($res) != 0) {
            $qualifications = $rows['qualifications'];
            return $qualifications;
        }
    }

}
