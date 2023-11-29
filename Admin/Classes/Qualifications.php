<?php


class Qualifications
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

    public function getEmployeeQualifications($company_id)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info WHERE empno IN ( SELECT emp_id FROM  emp_edu_info_tb) AND company_id = '$company_id'  ");
        return $result;
    }

    public function checkApprovalStatus($empno)
    {
        $result = mysqli_query($this->link, "SELECT status FROM emp_edu_info_tb WHERE emp_id ='$empno'");
        $rows = mysqli_fetch_array($result);
        $status = $rows['status'];
        return $status;
    }
}
