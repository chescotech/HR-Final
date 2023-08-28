<?php

class Employee {

  

    public function updateProfileInfo($fname, $lname, $email, $phone, $residentialAddress, $empno) {
        $result = mysql_query("UPDATE emp_info SET fname ='$fname',lname='$lname',email='$email',phone='$phone',address='$residentialAddress' WHERE empno= '$empno'");
        return $result;
    }

    public function updateEmpInfo($fname, $lname, $init, $bdate, $position, $bank, $account, $date_joined, $date_left, $gross_pay, $payment_method,$id,$social) {
        $result = mysql_query("UPDATE emp_info SET fname ='$fname',lname='$lname',"
                . "init='$init',bdate='$bdate',position='$position', bank='$bank',"
                . "account='$account',date_joined='$date_joined',date_left='$date_left'"
                . ",gross_pay='$gross_pay',payment_method='$payment_method',social='$social' WHERE id= '$id'");
        return $result;
    }

    public function getProfileInfo($employeeId) {
        $res = mysql_query("INSERT leave(first_name,last_name,user_city) VALUES('$fname','$lname','$city')");
        return $res;
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

    public function getSocialSecurityNo($empno) {
        $result = mysql_query("SELECT social FROM tax WHERE empno = '$empno' ");
        $row = mysql_fetch_array($result);
        $socialNo = $row['social'];
        return $socialNo;
    }

    public function getDepartmentDetails2($deptId) {
        $result = mysql_query("SELECT * FROM department WHERE dep_id='$deptId' ");
        $row = mysql_fetch_array($result);
        $departmentName = $row['department'];
        return $departmentName;
    }

}
