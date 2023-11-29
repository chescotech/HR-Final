<?php

class Company
{
    private $link;

    function __construct()
    {
        $this->link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('db connection problem' . mysqli_connect_error());
    }

    public function getCompanies()
    {
        $result = mysqli_query($this->link, "SELECT * FROM company ");
        return $result;
    }

    public function UpdateCompanyInfo($company_ID, $name, $phone, $email, $address, $file)
    {

        $result = mysqli_query($this->link, "UPDATE company SET name ='$name',logo='$file',phone='$phone',email='$email'"
            . ",address='$address' WHERE company_ID= '$company_ID'");
        return $result;
    }

    function getUserDetails($empno)
    {
        $query = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno = '$empno'");
        $rows = mysqli_fetch_array($query);
        $userdetails = $rows['fname'] . " - " . $rows['lname'];
        return $userdetails;
    }

    function getLeaveApplicationDate($empno)
    {
        $query = mysqli_query($this->link, "SELECT * FROM leave_applications_tb WHERE empno = '$empno' ");
        $rows = mysqli_fetch_array($query);
        $leaveApplicationDate = $rows['application_date'];
        return $leaveApplicationDate;
    }

    public function UpdateCompanyInfoWithoutLogo($company_ID, $name, $phone, $email, $address)
    {
        $result = mysqli_query($this->link, "UPDATE company SET name ='$name',phone='$phone',email='$email'"
            . ",address='$address' WHERE company_ID= '$company_ID'");
        return $result;
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

    public function getSupervisorParentId($supId)
    {

        $hodQuery = mysqli_query($this->link, "SELECT * FROM hod_tb WHERE empno='$supId'");
        $hodRows = mysqli_fetch_array($hodQuery);
        $hodsEmpno = $hodRows['id'];

        return $hodsEmpno;
    }

    public function getHodParentId($dept, $empno)
    {
        $hodQuery = mysqli_query($this->link, "SELECT hod_tb.id FROM `hod_tb` where empno IN ( SELECT emp_info.empno FROM emp_info where emp_info.dept='$dept')");
        $hodRows = mysqli_fetch_array($hodQuery);
        $hodsEmpno = $hodRows['id'];

        return $hodsEmpno;
    }

    public function createHodStrucures($empno, $otherInfo, $hod_id)
    {

        $result = mysqli_query($this->link, "INSERT INTO comp_structure(empno,otherInfo,hod_id) VALUES('$empno','$otherInfo','$hod_id')");
        return $result;
    }

    public function trancateStructure()
    {
        $result = mysqli_query($this->link, "TRUNCATE TABLE comp_structure");
    }

    public function createEmployeeStructure($empno, $otherInfo, $hod_id)
    {
        $result = mysqli_query($this->link, "INSERT INTO comp_structure(empno,otherInfo,hod_id) VALUES('$empno','$otherInfo','0')");
        return $result;
    }

    function checkLeaveStatus($empno)
    {
        $status = "";
        $query = mysqli_query($this->link, "SELECT * FROM leave_applications_tb WHERE empno = '$empno' AND status = 'Pending Approval' ");
        if (mysqli_num_rows($query) > 0) {
            $status = "true";
        } else {
            $status = "false";
        }
        return $status;
    }

    public function changePassword($user_ID, $password)
    {
        $result = mysqli_query($this->link, "UPDATE users_tb SET password ='$password ' WHERE id = '$user_ID' ");
        return $result;
    }

    public function checkIfPasswordExsists($userId, $password)
    {
        $status = "";
        $result = mysqli_query($this->link, "SELECT * FROM users_tb WHERE password = '$password' AND id = '$userId'");
        if (mysqli_num_rows($result) == 0) {
            $status = "false";
        } else {
            $status = "true";
        }
        return $status;
    }

    public function getCompanyLogo($companyId)
    {
        $user_query = mysqli_query($this->link, "SELECT * FROM company where company_ID='$companyId'") or die(mysqli_error($this->link));
        $row = mysqli_fetch_array($user_query);

        $photo = "company_logos/" . $row['logo'];

        return $photo;
    }

    public function checkExpiryDate($_key)
    {

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

    public function checkNousers($_key)
    {
        $no_users_allowed = substr($_key, 15, 4);
        return $no_users_allowed;
    }

    public function getNoUsersInCompany()
    {
        $user_query = mysqli_query($this->link, "SELECT COUNT(*) AS noemployees FROM `emp_info`") or die(mysqli_error($this->link));
        $row = mysqli_fetch_array($user_query);
        $noemployees = $row['noemployees'];
        return $noemployees;
    }

    public function getCompanyLogo2($companyId)
    {
        $user_query = mysqli_query($this->link, "SELECT * FROM company where company_ID='$companyId'") or die(mysqli_error($this->link));
        $row = mysqli_fetch_array($user_query);

        $photo = "../company_logos/" . $row['logo'];
        $check_pic = $row['logo'];
        if (!file_exists($photo) || $check_pic == false) {
            $photo = "../company_logos/logo.png";
        }
        return $photo;
    }

    public function getCompanyLogo3($companyId)
    {
        $user_query = mysqli_query($this->link, "SELECT * FROM company where company_ID='$companyId'") or die(mysqli_error($this->link));
        $row = mysqli_fetch_array($user_query);

        $photo = "../Admin/company_logos/" . $row['logo'];
        $check_pic = $row['logo'];
        if (!file_exists($photo) || $check_pic == false) {
            $photo = "../Admin/company_logos/logo.png";
        }
        return $photo;
    }

    public function getCompanyLogo4($companyId)
    {
        $user_query = mysqli_query($this->link, "SELECT * FROM company where company_ID='$companyId'") or die(mysqli_error($this->link));
        $row = mysqli_fetch_array($user_query);

        $photo = "../../Admin/company_logos/" . $row['logo'];
        $check_pic = $row['logo'];
        if (!file_exists($photo) || $check_pic == false) {
            $photo = "../../Admin/company_logos/logo.png";
        }
        return $photo;
    }

    public function getEmployeGrade($companyId)
    {
        $user_query = mysqli_query($this->link, "SELECT grade FROM grade where company_ID='$companyId'") or die(mysqli_error($this->link));
        return $user_query;
    }

    public function getApproverList()
    {
        $user_query = mysqli_query($this->link, "SELECT * FROM `workflows`") or die(mysqli_error($this->link));
        return $user_query;
    }

    public function getApproverByID($id)
    {
        $user_query = mysqli_query($this->link, "SELECT * FROM `workflows` WHERE id='$id'  ") or die(mysqli_error($this->link));
        $row = mysqli_fetch_array($user_query);
        $name = $row['name'];
        return $name;
    }

    public function getCompanyPrefix($companyId)
    {
        $user_query = mysqli_query($this->link, "SELECT prefix FROM prefix where company_ID='$companyId'") or die(mysqli_error($this->link));
        $row = mysqli_fetch_array($user_query);
        $prefix = $row['prefix'];
        return $prefix;
    }

    function getCompanyList()
    {
        $user_query = mysqli_query($this->link, "SELECT prefix FROM prefix where company_ID='$companyId'") or die(mysqli_error($this->link));
        $row = mysqli_fetch_array($user_query);
        return $user_query;
    }
}
