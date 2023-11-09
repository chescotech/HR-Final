<?php include_once '../../dbconnection.php';

class Leave
{
    private $link;


    function __construct()
    {
        $this->link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('db connection problem' . mysqli_connect_error());
    }

    public function applyLeave($startLeave, $endLeave, $leaveType, $empNo, $reasonLeave)
    {
        $status = "Pending Approval";
        $res = mysqli_query($this->link, "INSERT INTO leave_applications_tb(leave_start_date,leave_end_date,leave_type,empno,status,reason_leave,level)"
            . " VALUES('$startLeave','$endLeave','$leaveType','$empNo','$status','$reasonLeave','1')");
        return $res;
    }

    public function getLeaveTypes($companyId)
    {
        $result = mysqli_query($this->link, "SELECT * FROM leave_tb WHERE companyID = '$companyId' ");
        return $result;
    }

    public function getEmployeeDepartment($id)
    {
        $res = mysqli_query($this->link, "SELECT department FROM department
            INNER JOIN emp_info ON emp_info.dept = department.dep_id
            WHERE emp_info.empno = '$id'");
        $rows = mysqli_fetch_array($res);
        $department = $rows['department'];
        return $department;
    }

    public function veiwLeave($empno)
    {
        $res = mysqli_query($this->link, "SELECT * FROM leave_applications_tb WHERE empno='$empno' ");
        return $res;
    }

    public function GetAllDepartmentsByCompany($companyID)
    {
        $result = mysqli_query($this->link, "SELECT * FROM department WHERE company_ID='$companyID'");
        return $result;
    }

    public function veiwPendingLeave($empno)
    {
        $res = mysqli_query($this->link, "SELECT * FROM leave_applications_tb  ");
        return $res;
    }

    public function checkifHod($empno)
    {
        $res = mysqli_query($this->link, "SELECT * FROM hod_tb WHERE empno='$empno'");
        return $res;
    }

    public function veiwLeaveBalance($empno)
    {
        $res = mysqli_query($this->link, "SELECT * FROM leave_applications_tb WHERE empno='$empno' AND status ='Approved' ORDER BY application_id DESC ");
        return $res;
    }

    public function checkLeaveDays($empono)
    {
        $res = mysqli_query($this->link, "SELECT * FROM leave_days WHERE empno='$empono'");
        return $res;
    }

    public function getEmployeeLeaveBal($empono)
    {
        $res = mysqli_query($this->link, "SELECT * FROM leave_days WHERE empno='$empono'");
        $rows = mysqli_fetch_array($res);
        $leave_days = $rows['available'];
        return $leave_days;
    }

    public function getEmployeeSupervisor($employeeId)
    {
        $res = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$employeeId'");
        $rows = mysqli_fetch_array($res);
        $department = $rows['dept'];

        $hodQuery = mysqli_query($this->link, "SELECT * FROM hod_tb WHERE departmentId='$department'");
        $hodRows = mysqli_fetch_array($hodQuery);
        $hodsEmpno = $hodRows['empno'];

        $getHodDataQuery = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$hodsEmpno'");
        $hodsInfoRows = mysqli_fetch_array($getHodDataQuery);
        $hodsEmail = $hodsInfoRows['email'];
        return $hodsEmail;
    }

    public function getHodSupervisor($employeeId)
    {
        $res = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$employeeId'");
        $rows = mysqli_fetch_array($res);
        $department = $rows['dept'];

        $hodQuery = mysqli_query($this->link, "SELECT * FROM hod_tb WHERE departmentId='$department'");
        $hodRows = mysqli_fetch_array($hodQuery);
        $hodsEmpno = $hodRows['parent_supervisor'];

        $getHodDataQuery = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$hodsEmpno'");
        $hodsInfoRows = mysqli_fetch_array($getHodDataQuery);
        $hodsEmail = $hodsInfoRows['email'];
        return $hodsEmail;
    }

    public function checkIfEmployeeIsSupervisor($empno)
    {
        $status = "";
        $hodQuery = mysqli_query($this->link, "SELECT * FROM hod_tb WHERE parent_supervisor='$empno'");
        if (mysqli_num_rows($hodQuery) != 0) {
            $status = "true";
        } else {
            $status = "false";
        }
        return $status;
    }

    public function getLeaveApplicantDetails($empono)
    {
        $res = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$empono'");
        return $res;
    }

    public function getPendingApprovals($supervisorsDeptId)
    {
        $res = mysqli_query($this->link, "SELECT * FROM leave_applications_tb lv, emp_info em WHERE lv.empno IN "
            . "(SELECT em.empno FROM emp_info WHERE dept='$supervisorsDeptId') AND lv.status !='Approved' AND lv.status!='Declined';");
        return $res;
    }

    public function peopleOnleave($supervisorsDeptId)
    {
        $res = mysqli_query($this->link, "SELECT * FROM leave_applications_tb lv, emp_info em WHERE lv.empno IN "
            . "(SELECT em.empno FROM emp_info WHERE dept='$supervisorsDeptId') AND lv.status ='Approved' ;");
        return $res;
    }

    public function getPeopleAbsent($companyId)
    {
        $res = mysqli_query($this->link, "SELECT * FROM leave_applications_tb lv, emp_info em WHERE lv.empno IN "
            . "(SELECT em.empno FROM emp_info WHERE company_id='$companyId') AND lv.status ='Approved' ;")
            or die("Error 102: " . mysqli_error($this->link));
        return $res;
    }

    public function getAttendanceLogList($logDate, $companyId, $empno)
    {

        $arr = explode("/", $logDate);
        list($Getmonth, $Getday, $GetYear) = $arr;

        $year = $GetYear;
        $month = $Getmonth;
        $day = $Getday;

        $firstDate = $year . "/" . $month . "/" . "01";
        $endDate = $year . "/" . $month . "/" . "31";

        $res = mysqli_query($this->link, "SELECT * FROM attendance_logs WHERE log_date BETWEEN '$firstDate' AND '$endDate'  "
            . "AND  empno = '$empno'");
        return $res;
    }

    public function getEmployeeDetails($empno)
    {
        $res = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno = '$empno'");
        $rows = mysqli_fetch_array($res);
        $fname = $rows['fname'];
        $lname = $rows['lname'];
        $details = $fname . " " . $lname;
        return $details;
    }

    function timeDiff($firstTime, $lastTime)
    {
        $firstTime = strtotime($firstTime);
        $lastTime = strtotime($lastTime);

        $timeDiff = $lastTime - $firstTime;

        $years = abs(floor($timeDiff / 31536000));
        $days = abs(floor(($timeDiff - ($years * 31536000)) / 86400));
        $hours = abs(floor(($timeDiff - ($years * 31536000) - ($days * 86400)) / 3600));
        $mins = abs(floor(($timeDiff - ($years * 31536000) - ($days * 86400) - ($hours * 3600)) / 60)); #floor($difference / 60);
        $timeworked = $hours . " Hours, " . $mins . " Minutes";

        return $timeworked;
    }

    public function getDeptLeaveName($supervisorsDeptId)
    {
        $res = mysqli_query($this->link, "SELECT * FROM department WHERE dep_id='$supervisorsDeptId'");
        $row = mysqli_fetch_array($res);
        $deptname = $row['department'];
        return $deptname;
    }

    public function checkForActiveLeaves($LeaveEndDate)
    {
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

    public function checkIfCvExsists($empno)
    {
        $res = mysqli_query($this->link, " SELECT * FROM certificates_tb where empno='$empno' AND id = ( SELECT MAX(id) FROM certificates_tb WHERE empno='$empno' ) ");
        $rows = mysqli_fetch_array($res);
        if (mysqli_num_rows($res) != 0) {
            $cv = $rows['cv'];
            return $cv;
        }
    }

    public function checkIfCertificateExsists($empno)
    {
        $res = mysqli_query($this->link, " SELECT * FROM certificates_tb where empno='$empno' AND id = ( SELECT MAX(id) FROM certificates_tb WHERE empno='$empno' ) ");
        $rows = mysqli_fetch_array($res);
        if (mysqli_num_rows($res) != 0) {
            $qualifications = $rows['qualifications'];
            return $qualifications;
        }
    }
}
