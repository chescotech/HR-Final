<?php include_once '../../dbconnection.php';

include 'DBClass.php';

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

    public function getAllEmployeesByCompany($companyId)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE company_id = '$companyId' ") or die(mysqli_error($this->link));
        return $result;
    }

    public function updateEmpInfos(
        $fname,
        $lname,
        $init,
        $bdate,
        $position,
        $bank,
        $account,
        $date_joined,
        $date_left,
        $nok_name,
        $nok_relationship,
        $nok_email,
        $nok_address,
        $nok_phone,
        $basic_pay,
        $gross_pay,
        $payment_method,
        $id,
        $social,
        $branch_code,
        $leaveworkflow_id,
        $img,
        $gatuity_amount,
        $phone,
        $nrc_file,
        $department,
        $p_address,
        $email,
        $emp_grade,
        $employee_type,
        $employment_type,
        $nhima,
        $tpin,
        $nrc
    ) {
        if ($leaveworkflow_id == "") {
            $result = mysqli_query($this->link, "UPDATE emp_info SET fname ='$fname',lname='$lname',
            init='$init',bdate='$bdate',position='$position', bank='$bank',
            account='$account',date_joined='$date_joined',date_left='$date_left'
            ,gross_pay='$gross_pay',payment_method='$payment_method',basic_pay='$basic_pay',
            social='$social',branch_code='$branch_code',photo = '$img',
            nok_name='$nok_name', nok_relationship='$nok_relationship', nok_email='$nok_email', nok_address='$nok_address', nok_phone='$nok_phone',
            gatuity_amount='$gatuity_amount',phone='$phone',nrc_file='$nrc_file',
            dept = '$department', address = '$p_address', email='$email', employee_grade='$emp_grade',
            employee_type = '$employee_type', employment_type = '$employment_type',nhima='$nhima' ,tpin='$tpin',NRC='$nrc' WHERE id= '$id'") or die("Error.." . mysqli_error($this->link));
            return $result;
        } else {
            $result = mysqli_query($this->link, "UPDATE emp_info SET fname ='$fname',lname='$lname',
            init='$init',bdate='$bdate',position='$position', bank='$bank',
            account='$account',date_joined='$date_joined',date_left='$date_left'
            ,gross_pay='$gross_pay',payment_method='$payment_method',basic_pay='$basic_pay',
            social='$social',branch_code='$branch_code',leaveworkflow_id='$leaveworkflow_id',
            nok_name='$nok_name', nok_relationship='$nok_relationship', nok_email='$nok_email', nok_address='$nok_address', nok_phone='$nok_phone',
            photo = '$img', gatuity_amount='$gatuity_amount',phone='$phone',nrc_file='$nrc_file',
            dept = '$department', address = '$p_address', email='$email', employee_grade='$emp_grade',
            employee_type = '$employee_type', employment_type = '$employment_type',nhima='$nhima' ,tpin='$tpin',NRC='$nrc' WHERE id= '$id'") or die("Error.." . mysqli_error($this->link));
            return $result;
        }
    }

    public function getProfileInfo($employeeId)
    {
        $res = mysqli_query($this->link, "SELECT * FROM emp_info WHERE id = '$employeeId' ");
        return $res;
    }

    public function getEmployeeProfileByEmpNo($empno)
    {
        $query = "SELECT * FROM emp_info WHERE empno = '$empno'";

        $result = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        return $result;
    }

    public function getCompanyNameById($companyId)
    {
        $res = mysqli_query($this->link, " SELECT * FROM company WHERE company_id = '$companyId' ");
        $row = mysqli_fetch_array($res);
        $companyName = $row['name'];
        return $companyName;
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

    public function getEmployeeGrade($deptId)
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

    public function getSocialSSNO($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM tax WHERE empno='$empno'");
        $row = mysqli_fetch_array($result);
        $ssNo = $row['social'];
        return $ssNo;
    }

    public function getEmployeeNrc($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$empno'");
        $row = mysqli_fetch_array($result);
        $NRC = $row['NRC'];
        return $NRC;
    }


    public function getEmployeeAssets($emp_no_arg)
    {
        $query = "SELECT * FROM assets WHERE assigned_to = '$emp_no_arg'";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        return $queryResult;
    }
}
