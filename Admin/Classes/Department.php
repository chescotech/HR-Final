<?php include_once '../../dbconnection.php';


class Department
{
    private $link;

    function __construct()
    {
        $this->link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('db connection problem' . mysqli_connect_error());
    }

    public function addDepartment($department, $Company)
    {
        $res = mysqli_query($this->link, "INSERT INTO department(department,company_ID) VALUES('$department','$Company')");
        return $res;
    }

    public function EditDepartment($employeeId)
    {
        $res = mysqli_query($this->link, "INSERT leave(first_name,last_name,user_city) VALUES('$fname','$lname','$city')");
        return $res;
    }

    public function checkUser($username, $company_id)
    {
        $status = "";
        $result = mysqli_query($this->link, "SELECT * FROM users_tb WHERE user_name='$username' and company_id='$company_id'  ");
        if (mysqli_num_rows($result) > 0) {
            $status = "true";
        } else {
            $status = "false";
        }
        return $status;
    }

    public function getEmployeeNrc($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$empno'");
        $row = mysqli_fetch_array($result);
        $NRC = $row['NRC'];
        return $NRC;
    }

    public function getSocialSSNO($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$empno'");
        $row = mysqli_fetch_array($result);
        $ssNo = $row['social'];
        return $ssNo;
    }

    public function getEmployeeAccountNo($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$empno'");
        $row = mysqli_fetch_array($result);
        $account = $row['account'];
        if ($account == "") {
            $account = "00";
        } else {
            $account = $row['account'];
        }
        return $account;
    }

    public function addEmployeeAllowances($companyId, $house_allowance, $transport_allowance, $lunch_allowance, $empno)
    {
        $res = mysqli_query($this->link, "INSERT allowances_tb(company_id,house_allowance,transport_allowance,lunch_allowance,emp_no)"
            . " VALUES('$companyId','$house_allowance','$transport_allowance','$lunch_allowance','$empno')");
        return $res;
    }

    public function getDOB($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$empno'");
        $grossRows = mysqli_fetch_array($result);
        $bdate = $grossRows['bdate'];
        return $bdate;
    }

    public function addEmployee(
        $empno,
        $fname,
        $lname,
        $init,
        $gender,
        $bdate,
        $dept,
        $position,
        $phone,
        $address,
        $email,
        $bank,
        $account,
        $dateJoined,
        $dateLeft,
        $EmployeeGrade,
        $mStatus,
        $payMethod,
        $leaveDays,
        $companyId,
        $password,
        $basic_pay,
        $gross_pay,
        $employment_type,
        $nok_name,
        $nok_relationship,
        $nok_email,
        $nok_address,
        $nok_phone,
        $probation_deadline,
        $employee_type,
        $social,
        $branch_code,
        $has_gratuity,
        $gatuity_amount,
        $img,
        $NRC,
        $nrc_file,
        $tpin
    ) {

        $mp = trim($empno);

        $res = mysqli_query($this->link, "INSERT INTO emp_info(empno,fname,lname,init,gender
                ,bdate,dept,position,phone,address,email,bank,account,status,
                date_joined,date_left,employee_grade,marital_status
                ,payment_method,leave_days,company_id,password,gross_pay,
                nok_name, nok_relationship, nok_email, nok_address, nok_phone, 
                NRC,employment_type,probation_deadline,employee_type,basic_pay,social,branch_code,
                has_gratuity,gatuity_amount,photo,nrc_file,tpin)
                VALUES('$mp','$fname','$lname',' $init','$gender', 
                '$bdate', '$dept' , '$position','$phone', '$address', 
                '$email', '$bank','$account','Active','$dateJoined','$dateLeft'
                ,'$EmployeeGrade','$mStatus','$payMethod' ,'$leaveDays',
                '$companyId','$password','$gross_pay','$nok_name', '$nok_relationship', '$nok_email', '$nok_address', '$nok_phone','$NRC',
                '$employment_type','$probation_deadline','$employee_type','$basic_pay','$social','$branch_code','$has_gratuity','$gatuity_amount','$img','$nrc_file','$tpin' )") or die(mysqli_error($this->link));
        $new_emp_id = mysqli_insert_id($this->link);

        return $new_emp_id;
    }

    public function getEmpCount($companyID)
    {
        $result = mysqli_query($this->link, "SELECT empno FROM `emp_info`  order by id desc limit 1 ");
        $countRows = mysqli_fetch_array($result);
        $NoEmployees = preg_replace('/[^0-9]/', '', $countRows['empno']);
        return $NoEmployees;
    }

    public function AddHOD($EmployeeId, $department, $companyId, $superior)
    {
        $result = mysqli_query($this->link, "INSERT INTO hod_tb(empno,departmentId,companyID,parent_supervisor)"
            . " VALUES('$EmployeeId','$department','$companyId','$superior')");
        return $result;
    }

    public function AddWorkFlowName($name)
    {
        $result = mysqli_query($this->link, "INSERT INTO workflows(name)"
            . " VALUES('$name')");
        return $result;
    }

    public function AddApprovers($empno, $level, $workflow_id)
    {
        $result = mysqli_query($this->link, "INSERT INTO appover_groups(work_flow_id,level,empno)"
            . " VALUES('$workflow_id','$level','$empno')");
        return $result;
    }

    public function checkExsistingApprovers($empno, $level, $workflow_id)
    {
        $status = "";
        $result = mysqli_query($this->link, "SELECT * FROM appover_groups WHERE empno='$empno' AND level='$level' AND work_flow_id='$workflow_id'  ");
        if (mysqli_num_rows($result) > 0) {
            $status = "true";
        } else {
            $status = "false";
        }
        return $status;
    }

    function exitEmployee($empno, $reason_for_exit, $date_of_exit, $id)
    {
        $result = mysqli_query($this->link, "INSERT INTO employee_exits_tb(empno,reason_for_exit,date_of_exit)"
            . " VALUES('$empno','$reason_for_exit','$date_of_exit')");
        mysqli_query($this->link, "UPDATE emp_info SET status = 'exited' where id='$id'") or die(mysqli_error($this->link));
        return $result;
    }

    function getEmployeeDetailsById($empno)
    {
        $query = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno = '$empno'");
        $rows = mysqli_fetch_array($query);
        $fname = $rows['fname'];
        $lname = $rows['lname'];
        $details = $fname . " " . $lname;
        return $details;
    }

    public function addLeaveRates($employee_grade, $leave_days_per_month, $comp_ID)
    {
        $result = mysqli_query($this->link, "INSERT INTO leave_ratings_tb(grade_id,monthly_leave_days,companyID) "
            . "VALUES('$employee_grade','$leave_days_per_month','$comp_ID')");
        return $result;
    }

    public function addPension($employee_share, $employer_share, $allowance_type, $calculation_type, $status)
    {
        $result = mysqli_query($this->link, "SELECT * FROM pensions_tb");
        if (mysqli_num_rows($result) > 0) {
            $result = mysqli_query($this->link, " UPDATE pensions_tb SET employee_share='$employee_share',employer_share='$employer_share',"
                . "allowance_type='$allowance_type', calculation_type='$calculation_type',status='$status'   ");
        } else {
            $result = mysqli_query($this->link, "INSERT INTO pensions_tb(employee_share,employer_share,allowance_type,calculation_type,status) "
                . "VALUES('$employee_share','$employer_share','$allowance_type','$calculation_type','$status')");
        }

        return $result;
    }

    public function addLeave($leaveType, $maxLeaveDays, $companyID)
    {
        $result = mysqli_query($this->link, "INSERT INTO leave_tb(leave_type,max_leave_days,companyID) "
            . "VALUES('$leaveType','$maxLeaveDays','$companyID')");
        return $result;
    }

    public function addEmployeeGrade($employee_grade, $minimum_pay, $maximum_pay, $comp_ID)
    {
        $result = mysqli_query($this->link, "INSERT INTO grade(grade,maximum,minimum,company_ID) "
            . "VALUES('$employee_grade','$maximum_pay','$minimum_pay','$comp_ID')");
        return $result;
    }

    public function updateGradings($employee_grade, $minimum_pay, $maximum_pay, $grade_id)
    {
        $result = mysqli_query($this->link, "UPDATE grade SET grade ='$employee_grade',maximum='$maximum_pay',minimum='$minimum_pay' WHERE grade_id= '$grade_id'");
        return $result;
    }

    public function getGradeRatings($gradeId, $companyId)
    {
        $result = mysqli_query($this->link, "SELECT * FROM grade WHERE company_ID='$companyId' AND grade = '$gradeId' ");
        $row = mysqli_fetch_array($result);
        $min = $row['minimum'];
        $max = $row['maximum'];
        $payRange = $min . " - " . $max;
        return $payRange;
    }

    public function GetAllDepartmentsByCompany($companyID)
    {
        $result = mysqli_query($this->link, "SELECT * FROM department WHERE company_ID='$companyID'");
        return $result;
    }

    public function GetAllDepartments()
    {
        $result = mysqli_query($this->link, "SELECT * FROM department");
        return $result;
    }

    public function getDepartmentByCompany($companyId)
    {
        $result = mysqli_query($this->link, "SELECT * FROM department WHERE company_ID = '$companyId' ");
        return $result;
    }

    public function getUsersByCompany($companyId)
    {
        $result = mysqli_query($this->link, "SELECT * FROM users_tb WHERE company_ID = '$companyId' ");
        return $result;
    }

    public function getEmployeeGrade($companyId)
    {
        $result = mysqli_query($this->link, "SELECT * FROM grade WHERE company_ID = '$companyId' ");
        return $result;
    }

    public function GetAllDepartmentsById($id)
    {
        $result = mysqli_query($this->link, "SELECT * FROM department WHERE company_ID='Crystaline' AND dep_id='$id'");
        return $result;
    }

    public function getSupervisorByDepartment($departmentId)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE dept='$departmentId'");
        return $result;
    }

    public function getEmployeeByDepartment($departmentId)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE dept='$departmentId'");
        return $result;
    }

    public function EditHOD($deptId)
    {
        $result = mysqli_query($this->link, "SELECT * FROM department WHERE dep_id='$deptId'");
        return $result;
    }

    public function EditWorkFlow($Id)
    {
        $result = mysqli_query($this->link, "SELECT * FROM workflows WHERE id='$Id'");
        return $result;
    }

    public function EditApprovers($Id)
    {
        $result = mysqli_query($this->link, "SELECT * FROM appover_groups WHERE id='$Id'");
        return $result;
    }

    public function UpdateDepartment($deptName, $deptID)
    {
        $result = mysqli_query($this->link, "UPDATE department SET department ='$deptName' WHERE dep_id= '$deptID'");
        return $result;
    }

    public function updateWorkFlow($deptName, $deptID)
    {
        $result = mysqli_query($this->link, "UPDATE workflows SET name ='$deptName' WHERE id= '$deptID'");
        return $result;
    }

    public function GetCompanyDetails()
    {
        $result = mysqli_query($this->link, "SELECT * FROM company");
        return $result;
    }

    public function GetCompanyDetailsEdit()
    {
        $result = mysqli_query($this->link, "SELECT * FROM company");
        return $result;
    }

    public function getAllEmployees()
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info");
        return $result;
    }

    public function getAllEmployeesByCompany($companyId)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE company_id = '$companyId' ");
        return $result;
    }

    public function getHODS($companyID)
    {
        $result = mysqli_query($this->link, "SELECT * FROM hod_tb WHERE companyID = '$companyID' ");
        return $result;
    }

    public function getAllHODs($deptId)
    {
        $result = mysqli_query($this->link, "SELECT * FROM hod_tb WHERE ");
        return $result;
    }

    public function getHODInfo($employeeId)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$employeeId'");
        return $result;
    }

    public function getHeadingDepartment($departmentID)
    {
        $result = mysqli_query($this->link, "SELECT * FROM department WHERE dep_id='$departmentID'");
        return $result;
    }

    public function getSuperiorDetails($employeeId)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$employeeId'");
        $rows = mysqli_fetch_array($result);
        $fname = $rows['fname'];
        $lname = $rows['lname'];
        $superiorDetails = $fname . " " . $lname;
        return $superiorDetails;
    }

    public function getCompanyByEmployee($empno)
    {
        $result = mysqli_query($this->link, "SELECT company_id FROM emp_info WHERE empno='$empno'");
        $companyRows = mysqli_fetch_array($result);
        $companyname = $companyRows['company_id'];
        return $companyname;
    }

    public function getGrossPay($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$empno'");
        $grossRows = mysqli_fetch_array($result);
        $grossPay = $grossRows['gross_pay'];
        return $grossPay;
    }

    public function getTransportAllowance($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM allowances_tb WHERE emp_no='$empno'");
        $grossRows = mysqli_fetch_array($result);
        $grossPay = $grossRows['transport_allowance'];
        return $grossPay;
    }

    public function gethousingAllowance($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM allowances_tb WHERE emp_no='$empno'");
        $grossRows = mysqli_fetch_array($result);
        $grossPay = $grossRows['house_allowance'];
        return $grossPay;
    }

    public function getLunchAllowance($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM allowances_tb WHERE emp_no='$empno'");
        $grossRows = mysqli_fetch_array($result);
        $grossPay = $grossRows['lunch_allowance'];
        return $grossPay;
    }

    function getAllowances($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM allowances_tb WHERE emp_no='$empno'");
        $grossRows = mysqli_fetch_array($result);
        $grossPay = $grossRows['house_allowance'] + $grossRows['transport_allowance'] + $grossRows['lunch_allowance'];
        return $grossPay;
    }

    function getAllownceList()
    {
        $result = mysqli_query($this->link, "SELECT * FROM allowances_tb");
        return $result;
    }

    public function getBasicPay($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info INNER JOIN employee_deductions on emp_info.id=employee_deductions.employee_id WHERE empno='$empno'");
        $grossRows = mysqli_fetch_array($result);
        $basic_pay = $grossRows['basic_pay'];
        return $basic_pay;
    }

    public function getGrossPayTotal($empno)
    {
        $sum = 0;
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$empno'");
        $grossRows = mysqli_fetch_array($result);
        $grossPay = $grossRows['gross_pay'];
        $sum += $grossPay;
        return $sum;
    }

    public function TotalGrossPay($empno)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno='$empno'");
        $grossRows = mysqli_fetch_array($result);
        $grosstotal = $grossRows['gross_pay'];
        return $grosstotal;
    }
}
