<?php


class Qualifications {

    function __construct() {
        $conn = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die('db connection problem' . mysql_error());
        mysql_select_db(DB_NAME, $conn);
    }

    public function updateProfileInfo($fname, $lname, $email, $phone, $residentialAddress, $empno) {
        $result = mysql_query("UPDATE emp_info SET fname ='$fname',lname='$lname',email='$email',phone='$phone',address='$residentialAddress' WHERE empno= '$empno'");
        return $result;
    }

    public function getEmployeeQualifications($company_id) {
        $result = mysql_query("SELECT * FROM emp_info WHERE empno IN ( SELECT emp_id FROM  emp_edu_info_tb) AND company_id = '$company_id'  ");
        return $result;
    }
    
    public function checkApprovalStatus($empno){        
        $result = mysql_query("SELECT status FROM emp_edu_info_tb WHERE emp_id ='$empno'");
        $rows = mysql_fetch_array($result);
        $status = $rows['status'];
        return $status;        
    }

}
