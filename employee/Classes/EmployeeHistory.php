<?php

include 'DBClass.php';

class EmployeeHistory {

    function __construct() {
        $conn = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die('db connection problem' . mysql_error());
        mysql_select_db(DB_NAME, $conn);
    }

    public function addEduInfo($employeeId, $highest_qualification, $qualifications, $university, $secondary_school) {
        $res = mysql_query("INSERT INTO emp_edu_info_tb (emp_id,highest_qualifications,qualifications,university,secondary_school) "
                . "VALUES('$employeeId','$highest_qualification','$qualifications','$university','$secondary_school')");
        return $res;
    }

    public function updateEduInfo($employeeId, $highest_qualification, $qualifications, $university, $secondary_school) {
        $result = mysql_query("UPDATE emp_edu_info_tb SET highest_qualifications ='$highest_qualification',"
                . "qualifications='$highest_qualification',qualifications='$qualifications',university='$university'"
                . ",secondary_school='$secondary_school' WHERE emp_id= '$employeeId'");
        return $result;
    }
    
     public function updateEduInfoByID($id, $highest_qualification, $qualifications, $university, $secondary_school) {
        $result = mysql_query("UPDATE emp_edu_info_tb SET highest_qualifications ='$highest_qualification',"
                . "qualifications='$highest_qualification',qualifications='$qualifications',university='$university'"
                . ",secondary_school='$secondary_school' WHERE id= '$id'");
        return $result;
    }

    public function getEduInfo($empno) {
        $res = mysql_query("SELECT * FROM emp_edu_info_tb where emp_id='$empno'");
        return $res;
    }

    public function checkCertificates($empno) {
        $res = mysql_query("SELECT * FROM certificates_tb where empno='$empno'");
        return $res;
    }

    public function getHistoryInfo($empno) {
        $res = mysql_query("SELECT * FROM emp_history_tb where emp_id='$empno'");
        return $res;
    }

    public function addEmpHistInfo($emp_id, $employer_one, $position_one, $date_start_one, $date_end_one, 
        $employer_two, $position_two, $date_start_two, $date_end_two, 
        $employer_three, $position_three, $date_start_three, $date_end_three,
        $employer_four, $position_four, $date_start_four, $date_end_four,
        $employer_five, $position_five, $date_start_five, $date_end_five
        ) {

        $res = mysql_query("INSERT INTO emp_history_tb (emp_id,
                employer_one, position_one, date_start_one, date_end_one,
                employer_two, position_two, date_start_two, date_end_two,
                employer_three, position_three, date_start_three, date_end_three,
                employer_four, position_four, date_start_four, date_end_four,
                employer_five, position_five, date_start_five, date_end_five,
                status) VALUES('$emp_id',
                '$employer_one','$position_one','$date_start_one','$date_end_one', 
                '$employer_two','$position_two','$date_start_two','$date_end_two',
                '$employer_three','$position_three','$date_start_three' ,'$date_end_three',
                '$employer_four','$position_four','$date_start_four','$date_end_four',
                '$employer_five','$position_five','$date_start_five' ,'$date_end_five',
                'Pending')")or die("error adding: ".mysql_error());

        return $res;
    }

    public function updateEmpHistInfo($emp_id, $employer_one, $position_one, $date_start_one, $date_end_one, 
        $employer_two, $position_two, $date_start_two, $date_end_two, 
        $employer_three, $position_three, $date_start_three, $date_end_three,
        $employer_four, $position_four, $date_start_four, $date_end_four,
        $employer_five, $position_five, $date_start_five, $date_end_five
        ) {

        $result = mysql_query("UPDATE emp_history_tb SET 
                employer_one ='$employer_one', position_one='$position_one',date_start_one='$date_start_one',date_end_one='$date_end_one',
                employer_two='$employer_two',position_two='$position_two',date_start_two='$date_start_two',date_end_two='$date_end_two',
                employer_three='$employer_three',position_three='$position_three',date_start_three='$date_start_three',date_end_three='$date_end_three',
                employer_four='$employer_four',position_four='$position_four',date_start_four='$date_start_four',date_end_four='$date_end_four',
                employer_five='$employer_five',position_five='$position_five',date_start_five='$date_start_five',date_end_five='$date_end_five'
                 WHERE emp_id= '$emp_id'");

        return $result;
    }

    public function updateCertificate($empno, $CV, $Qualification) {

        $result = mysql_query("UPDATE certificates_tb SET cv ='$CV',"
                . "qualifications='$Qualification' WHERE empno= '$empno'");

        return $result;
    }

    public function uploadDocs($employeeId) {
        $res = mysql_query("INSERT leave(first_name,last_name,user_city) VALUES('$fname','$lname','$city')");
        return $res;
    }

    public function getEmpInfo($empno) {
        $res = mysql_query("SELECT * FROM emp_info where empno='$empno'");
        $rows = mysql_fetch_array($res);
        $fname = $rows['fname'];
        $lname = $rows['lname'];
        $details = $fname . " " . $lname;
        return $details;
    }

    public function getCerttificates($empno) {
        $res = mysql_query(" SELECT * FROM certificates_tb where empno='$empno' ");
        $rows = mysql_fetch_array($res);
        $cert = $rows['qualifications'];
        return $cert;
    }

    public function getCv($empno) {
        $res = mysql_query(" SELECT * FROM certificates_tb where empno='$empno' ");
        $rows = mysql_fetch_array($res);
        $cv = $rows['cv'];
        return $cv;
    }
    
    public function getLeaveAttachment($empno) {
        $res = mysql_query(" SELECT * FROM leave_applications_tb where application_id='$empno' ");
        $rows = mysql_fetch_array($res);
        $cv = $rows['file_proof'];
        return $cv;
    }

}
