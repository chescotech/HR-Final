<?php

class Company {

    public function getCompanies() {
        $result = mysql_query("SELECT * FROM company ");
        return $result;
    }

    public function UpdateCompanyInfo($company_ID, $name, $phone, $email, $address, $file) {

        $result = mysql_query("UPDATE company SET name ='$name',logo='$file',phone='$phone',email='$email'"
                . ",address='$address' WHERE company_ID= '$company_ID'");
        return $result;
    }

    function getUserDetails($empno) {
        $query = mysql_query("SELECT * FROM emp_info WHERE empno = '$empno'");
        $rows = mysql_fetch_array($query);
        $userdetails = $rows['fname'] . " - " . $rows['lname'];
        return $userdetails;
    }

    function getLeaveApplicationDate($empno) {
        $query = mysql_query("SELECT * FROM leave_applications_tb WHERE empno = '$empno' ");
        $rows = mysql_fetch_array($query);
        $leaveApplicationDate = $rows['application_date'];
        return $leaveApplicationDate;
    }

    public function UpdateCompanyInfoWithoutLogo($company_ID, $name, $phone, $email, $address) {
        $result = mysql_query("UPDATE company SET name ='$name',phone='$phone',email='$email'"
                . ",address='$address' WHERE company_ID= '$company_ID'");
        return $result;
    }

    public function getHodSupervisor($employeeId) {
        $res = mysql_query("SELECT * FROM emp_info WHERE empno='$employeeId'");
        $rows = mysql_fetch_array($res);
        $department = $rows['dept'];

        $hodQuery = mysql_query("SELECT * FROM hod_tb WHERE departmentId='$department'");
        $hodRows = mysql_fetch_array($hodQuery);
        $hodsEmpno = $hodRows['parent_supervisor'];

        $getHodDataQuery = mysql_query("SELECT * FROM emp_info WHERE empno='$hodsEmpno'");
        $hodsInfoRows = mysql_fetch_array($getHodDataQuery);
        $hodsEmail = $hodsInfoRows['email'];
        return $hodsEmail;
    }

    public function getSupervisorParentId($supId) {

        $hodQuery = mysql_query("SELECT * FROM hod_tb WHERE empno='$supId'");
        $hodRows = mysql_fetch_array($hodQuery);
        $hodsEmpno = $hodRows['id'];

        return $hodsEmpno;
    }

    public function getHodParentId($dept, $empno) {
        $hodQuery = mysql_query("SELECT hod_tb.id FROM `hod_tb` where empno IN ( SELECT emp_info.empno FROM emp_info where emp_info.dept='$dept')");
        $hodRows = mysql_fetch_array($hodQuery);
        $hodsEmpno = $hodRows['id'];

        return $hodsEmpno;
    }

    public function createHodStrucures($empno, $otherInfo, $hod_id) {

        $result = mysql_query("INSERT INTO comp_structure(empno,otherInfo,hod_id) VALUES('$empno','$otherInfo','$hod_id')");
        return $result;
    }

    public function trancateStructure() {
        $result = mysql_query("TRUNCATE TABLE comp_structure");
    }

    public function createEmployeeStructure($empno, $otherInfo, $hod_id) {
        $result = mysql_query("INSERT INTO comp_structure(empno,otherInfo,hod_id) VALUES('$empno','$otherInfo','0')");
        return $result;
    }

    function checkLeaveStatus($empno) {
        $status = "";
        $query = mysql_query("SELECT * FROM leave_applications_tb WHERE empno = '$empno' AND status = 'Pending Approval' ");
        if (mysql_num_rows($query) > 0) {
            $status = "true";
        } else {
            $status = "false";
        }
        return $status;
    }

    public function changePassword($user_ID, $password) {
        $result = mysql_query("UPDATE users_tb SET password ='$password ' WHERE id = '$user_ID' ");
        return $result;
    }

    public function checkIfPasswordExsists($userId, $password) {
        $status = "";
        $result = mysql_query("SELECT * FROM users_tb WHERE password = '$password' AND id = '$userId'");
        if (mysql_num_rows($result) == 0) {
            $status = "false";
        } else {
            $status = "true";
        }
        return $status;
    }

    public function getCompanyLogo($companyId) {
        $user_query = mysql_query("SELECT * FROM company where company_ID='$companyId'") or die(mysql_error());
        $row = mysql_fetch_array($user_query);

        $photo = "company_logos/" . $row['logo'];

        return $photo;
    }

    public function checkExpiryDate($_key) {

        $duration = substr($_key, 12, 2);
        $no_users_allowed = substr($_key, 15, 4);
        $date = substr($_key, 20, 4);
        $year = substr($_key, 25, 4);
        $no_months = intval($duration);
        $date_created = substr($date, 0, 2) . "-" . substr($date, 2, 2) . "-" . $year;
        // echo $date_created = date('Y-m-d', strtotime($date_created_str));
        // $expiry_date = $date_created;
        $expiry_date = date('d M Y', strtotime($date_created . "+ $no_months Month"));

        //echo "<hr/>." . date('d M Y') . ". exp date = " . $expiry_date . "<br>";
        if (strtotime(date('d M Y')) > strtotime($expiry_date)) {
            //$fatal_error = "Your license is valid";
            $fatal_error = "expired";
        }
        if (isset($fatal_error)) {
            return $fatal_error;
        } else {
            return $expiry_date;
        }
    }

    public function checkNousers($_key) {
        $no_users_allowed = substr($_key, 15, 4);
        return $no_users_allowed;
    }

    public function getNoUsersInCompany() {
        $user_query = mysql_query("SELECT COUNT(*) AS noemployees FROM `emp_info`") or die(mysql_error());
        $row = mysql_fetch_array($user_query);
        $noemployees = $row['noemployees'];
        return $noemployees;
    }

    public function getCompanyLogo2($companyId) {
        $user_query = mysql_query("SELECT * FROM company where company_ID='$companyId'") or die(mysql_error());
        $row = mysql_fetch_array($user_query);

        $photo = "../company_logos/" . $row['logo'];
        $check_pic = $row['logo'];
        if (!file_exists($photo) || $check_pic == false) {
            $photo = "../company_logos/logo.png";
        }
        return $photo;
    }

    public function getCompanyLogo3($companyId) {
        $user_query = mysql_query("SELECT * FROM company where company_ID='$companyId'") or die(mysql_error());
        $row = mysql_fetch_array($user_query);

        $photo = "../Admin/company_logos/" . $row['logo'];
        $check_pic = $row['logo'];
        if (!file_exists($photo) || $check_pic == false) {
            $photo = "../Admin/company_logos/logo.png";
        }
        return $photo;
    }

    public function getCompanyLogo4($companyId) {
        $user_query = mysql_query("SELECT * FROM company where company_ID='$companyId'") or die(mysql_error());
        $row = mysql_fetch_array($user_query);

        $photo = "../../Admin/company_logos/" . $row['logo'];
        $check_pic = $row['logo'];
        if (!file_exists($photo) || $check_pic == false) {
            $photo = "../../Admin/company_logos/logo.png";
        }
        return $photo;
    }

    public function getEmployeGrade($companyId) {
        $user_query = mysql_query("SELECT grade FROM grade where company_ID='$companyId'") or die(mysql_error());
        return $user_query;
    }

    public function getApproverList() {
        $user_query = mysql_query("SELECT * FROM `workflows`") or die(mysql_error());
        return $user_query;
    }

    public function getApproverByID($id) {
        $user_query = mysql_query("SELECT * FROM `workflows` WHERE id='$id'  ") or die(mysql_error());
        $row = mysql_fetch_array($user_query);
        $name = $row['name'];
        return $name;
    }

    public function getCompanyPrefix($companyId) {
        $user_query = mysql_query("SELECT prefix FROM prefix where company_ID='$companyId'") or die(mysql_error());
        $row = mysql_fetch_array($user_query);
        $prefix = $row['prefix'];
        return $prefix;
    }

    function getCompanyList() {
        $user_query = mysql_query("SELECT prefix FROM prefix where company_ID='$companyId'") or die(mysql_error());
        $row = mysql_fetch_array($user_query);
        return $user_query;
    }

}
