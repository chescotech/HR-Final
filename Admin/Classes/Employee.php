<?php

include 'DBClass.php';

class Employee
{

    function __construct()
    {
        $conn = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die('db connection problem' . mysql_error());
        mysql_select_db(DB_NAME, $conn);
    }

    public function updateProfileInfo($fname, $lname, $email, $phone, $residentialAddress, $empno)
    {
        $result = mysql_query("UPDATE emp_info SET fname ='$fname',lname='$lname',email='$email',phone='$phone',address='$residentialAddress' WHERE empno= '$empno'");
        return $result;
    }

    public function getAllEmployeesByCompany($companyId)
    {
        $result = mysql_query("SELECT * FROM emp_info WHERE company_id = '$companyId' ");
        return $result;
    }

   public function updateEmpInfos($fname, $lname, $init, $bdate, $position, $bank, $account, $date_joined, $date_left, 
    $nok_name, $nok_relationship, $nok_email, $nok_address, $nok_phone, $basic_pay, $gross_pay, $payment_method, $id,
           $social, $branch_code, $leaveworkflow_id, $img, $gatuity_amount,$phone,$nrc_file,
           $department, $p_address, $email, $emp_grade,$employee_type,
           $employment_type,$nhima,$tpin,$nrc)
    {
        if ($leaveworkflow_id == "") {
            $result = mysql_query("UPDATE emp_info SET fname ='$fname',lname='$lname',
            init='$init',bdate='$bdate',position='$position', bank='$bank',
            account='$account',date_joined='$date_joined',date_left='$date_left'
            ,gross_pay='$gross_pay',payment_method='$payment_method',basic_pay='$basic_pay',
            social='$social',branch_code='$branch_code',photo = '$img',
            nok_name='$nok_name', nok_relationship='$nok_relationship', nok_email='$nok_email', nok_address='$nok_address', nok_phone='$nok_phone',
            gatuity_amount='$gatuity_amount',phone='$phone',nrc_file='$nrc_file',
            dept = '$department', address = '$p_address', email='$email', employee_grade='$emp_grade',
            employee_type = '$employee_type', employment_type = '$employment_type',nhima='$nhima' ,tpin='$tpin',NRC='$nrc' WHERE id= '$id'") or die("Error.." . mysql_error());
            return $result;
        } else {
            $result = mysql_query("UPDATE emp_info SET fname ='$fname',lname='$lname',
            init='$init',bdate='$bdate',position='$position', bank='$bank',
            account='$account',date_joined='$date_joined',date_left='$date_left'
            ,gross_pay='$gross_pay',payment_method='$payment_method',basic_pay='$basic_pay',
            social='$social',branch_code='$branch_code',leaveworkflow_id='$leaveworkflow_id',
            nok_name='$nok_name', nok_relationship='$nok_relationship', nok_email='$nok_email', nok_address='$nok_address', nok_phone='$nok_phone',
            photo = '$img', gatuity_amount='$gatuity_amount',phone='$phone',nrc_file='$nrc_file',
            dept = '$department', address = '$p_address', email='$email', employee_grade='$emp_grade',
            employee_type = '$employee_type', employment_type = '$employment_type',nhima='$nhima' ,tpin='$tpin',NRC='$nrc' WHERE id= '$id'") or die("Error.." . mysql_error());
            return $result;
        }

    }

    public function getProfileInfo($employeeId)
    {
        $res = mysql_query("INSERT leave(first_name,last_name,user_city) VALUES('$fname','$lname','$city')");
        return $res;
    }

    public function getCompanyNameById($companyId)
    {
        $res = mysql_query(" SELECT * FROM company WHERE company_id = '$companyId' ");
        $row = mysql_fetch_array($res);
        $companyName = $row['name'];
        return $companyName;
    }

    public function getAllEmployees()
    {
        $result = mysql_query("SELECT * FROM emp_info");
        return $result;
    }

    public function getDepartmentDetails($deptId)
    {
        $result = mysql_query("SELECT * FROM department WHERE dep_id='$deptId' ");
        $row = mysql_fetch_array($result);
        $departmentName = $row['department'];
        return $departmentName;
    }
    
        public function getEmployeeGrade($deptId)
    {
        $result = mysql_query("SELECT * FROM department WHERE dep_id='$deptId' ");
        $row = mysql_fetch_array($result);
        $departmentName = $row['department'];
        return $departmentName;
    }

    public function changePasssword($pass, $empno)
    {
        $password = md5($pass);
        $result = mysql_query("UPDATE emp_info SET password ='$password' WHERE empno= '$empno'");
        return $result;
    }

    public function checkIfEmployeeExsists($pass, $empId)
    {
        $password = md5($pass);
        $result = mysql_query("SELECT * FROM emp_info WHERE password='$password' AND empno='$empId'");
        return $result;
    }

    public function getEmployeeById($id)
    {
        $result = mysql_query("SELECT * FROM emp_info WHERE id='$id' ");
        return $result;
    }

    public function getDepartments()
    {
        $result = mysql_query("SELECT * FROM department ");
        return $result;
    }

    public function getSocialSSNO($empno)
    {
        $result = mysql_query("SELECT * FROM tax WHERE empno='$empno'");
        $row = mysql_fetch_array($result);
        $ssNo = $row['social'];
        return $ssNo;
    }

    public function getEmployeeNrc($empno)
    {
        $result = mysql_query("SELECT * FROM emp_info WHERE empno='$empno'");
        $row = mysql_fetch_array($result);
        $NRC = $row['NRC'];
        return $NRC;
    }
}
