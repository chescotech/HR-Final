<?php

include_once 'DBClass.php';

class Employee
{

    private $link;

    function __construct()
    {
        $this->link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('db connection problem' . mysqli_connect_error());
    }

    public function updateProfileInfo($fname, $lname, $email, $phone, $residentialAddress, $empno)
    {
        $result = mysqli_query($this->link, "UPDATE emp_info SET fname ='$fname',lname='$lname',email='$email',phone='$phone',address='$residentialAddress' WHERE empno= '$empno'");
        return $result;
    }

    public function updateEmpInfo($fname, $lname, $init, $bdate, $position, $bank, $account, $date_joined, $date_left, $gross_pay, $payment_method, $id, $social)
    {
        $result = mysqli_query($this->link, "UPDATE emp_info SET fname ='$fname',lname='$lname',"
            . "init='$init',bdate='$bdate',position='$position', bank='$bank',"
            . "account='$account',date_joined='$date_joined',date_left='$date_left'"
            . ",gross_pay='$gross_pay',payment_method='$payment_method',social='$social' WHERE id= '$id'");
        return $result;
    }

    public function getProfileInfo($employeeId)
    {
        $res = mysqli_query($this->link, "INSERT leave(first_name,last_name,user_city) VALUES('$fname','$lname','$city')");
        return $res;
    }

    public function getAllEmployees()
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info");
        return $result;
    }
    public function getDepartmentDetails($deptId)
    {
        $result = mysqli_query($this->link, "SELECT * FROM department WHERE dep_id='$deptId' ");
        $row = mysqli_fetch_array($result);
        $departmentName = $row['department'];
        return $departmentName;
    }

    public function changePasssword($pass, $empno)
    {
        $password = md5($pass);
        $result = mysqli_query($this->link, "UPDATE emp_info SET password ='$password' WHERE empno= '$empno'");
        return $result;
    }

    public function checkIfEmployeeExsists($pass, $empId)
    {
        $password = md5($pass);
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE password='$password' AND empno='$empId'");
        return $result;
    }

    public function getEmployeeById($id)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE id='$id' ");
        return $result;
    }

    public function getDepartments()
    {
        $result = mysqli_query($this->link, "SELECT * FROM department ");
        return $result;
    }

    public function getSocialSecurityNo($empno)
    {
        $result = mysqli_query($this->link, "SELECT social FROM tax WHERE empno = '$empno' ");
        $row = mysqli_fetch_array($result);
        $socialNo = $row['social'];
        return $socialNo;
    }

    public function getDepartmentDetails2($deptId)
    {
        $result = mysqli_query($this->link, "SELECT * FROM department WHERE dep_id='$deptId' ");
        $row = mysqli_fetch_array($result);
        $departmentName = $row['department'];
        return $departmentName;
    }
}
