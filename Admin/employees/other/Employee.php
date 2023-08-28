<?php

include 'DBClass.php';

class Employee {

    function __construct() {
        $conn = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die('db connection problem' . mysql_error());
        mysql_select_db(DB_NAME, $conn);
    }

    public function updateProfileInfo($fname, $lname, $email, $phone, $residentialAddress, $empno) {
        $result = mysql_query("UPDATE emp_info SET fname ='$fname',lname='$lname',email='$email',phone='$phone',address='$residentialAddress' WHERE empno= '$empno'");
        return $result;
    }

    function getEmployeeAllowances($empno) {
        $result = mysql_query("SELECT * FROM allowances_tb WHERE empno='$empno' ");
        return $result;
    }

    public function getAllEmployeesByCompany($companyId) {
        $result = mysql_query("SELECT * FROM emp_info WHERE company_id = '$companyId' ");
        return $result;
    }

    public function updateEmpInfo($fname, $lname, $init, $bdate, $position, $bank, $account, $date_joined, $date_left, $basic_pay, $payment_method, $id, $gross_pay) {
        $result = mysql_query("UPDATE emp_info SET fname ='$fname',lname='$lname',"
                . "init='$init',bdate='$bdate',position='$position', bank='$bank',"
                . "account='$account',date_joined='$date_joined',date_left='$date_left'"
                . ",basic_pay='$basic_pay',payment_method='$payment_method',gross_pay ='$gross_pay' WHERE id= '$id'");
        return $result;
    }

    public function getProfileInfo($employeeId) {
        $res = mysql_query("INSERT leave(first_name,last_name,user_city) VALUES('$fname','$lname','$city')");
        return $res;
    }

    public function getCompanyNameById($companyId) {
        $res = mysql_query(" SELECT * FROM company WHERE company_id = '$companyId' ");
        $row = mysql_fetch_array($res);
        $companyName = $row['name'];
        return $companyName;
    }

    public function getAllEmployees() {
        $result = mysql_query("SELECT * FROM emp_info");
        return $result;
    }

    public function getDepartmentDetails($deptId) {
        $result = mysql_query("SELECT * FROM department WHERE dep_id='$deptId' ");
        $row = mysql_fetch_array($result);
        $departmentName = $row['department'];
        return $departmentName;
    }

    public function changePasssword($pass, $empno) {
        $password = md5($pass);
        $result = mysql_query("UPDATE emp_info SET password ='$password' WHERE empno= '$empno'");
        return $result;
    }

    public function checkIfEmployeeExsists($pass, $empId) {
        $password = md5($pass);
        $result = mysql_query("SELECT * FROM emp_info WHERE password='$password' AND empno='$empId'");
        return $result;
    }

    public function getEmployeeById($id) {
        $result = mysql_query("SELECT * FROM emp_info WHERE id='$id' ");
        return $result;
    }

    public function getDepartments() {
        $result = mysql_query("SELECT * FROM department ");
        return $result;
    }

    public function getSocialSSNO($empno) {
        $result = mysql_query("SELECT * FROM tax WHERE empno='$empno'");
        $row = mysql_fetch_array($result);
        $ssNo = $row['social'];
        return $ssNo;
    }

    public function getEmployeeNrc($empno) {
        $result = mysql_query("SELECT * FROM emp_info WHERE empno='$empno'");
        $row = mysql_fetch_array($result);
        $NRC = $row['NRC'];
        return $NRC;
    }

}
