<?php

class Attendance
{

    public function checkInUser($empno, $company_id, $log_date, $login_time, $logout_time)
    {
        $res = mysqli_query($link, "INSERT INTO attendance_logs(log_date,logout_time,empno,company_id,login_time) "
            . "VALUES('$log_date','$logout_time','$empno','$company_id','$login_time')");
        return $res;
    }

    public function checkOutUser($empno, $company_id, $logout_time, $log_date)
    {
        $res = mysqli_query($link, "UPDATE attendance_logs SET  logout_time = '$logout_time'  WHERE empno = '$empno'"
            . " AND company_id = '$company_id' AND log_date='$log_date'");
        return $res;
    }

    public function getAllEmployeesByCompany($companyId)
    {
        $result = mysqli_query($link, "SELECT * FROM emp_info WHERE company_id = '$companyId' ");
        return $result;
    }

    public function getCompanyLocation($company_id)
    {
        $result = mysqli_query($link, "SELECT * FROM company WHERE company_ID = '$company_id' ");
        $row = mysqli_fetch_array($result);
        $companyLocation = $row['address'];
        return $companyLocation;
    }

    public function updateEmpInfo($fname, $lname, $init, $bdate, $position, $bank, $account, $date_joined, $date_left, $gross_pay, $payment_method, $id)
    {
        $result = mysqli_query($link, "UPDATE emp_info SET fname ='$fname',lname='$lname',"
            . "init='$init',bdate='$bdate',position='$position', bank='$bank',"
            . "account='$account',date_joined='$date_joined',date_left='$date_left'"
            . ",gross_pay='$gross_pay',payment_method='$payment_method' WHERE id= '$id'");
        return $result;
    }

    public function getAttendanceLogList($logDate, $companyId, $empno)
    {

        $arr = explode("/", $logDate);
        list($Getmonth, $Getday, $GetYear) = $arr;

        $year = $GetYear;
        $month = $Getmonth;
        $day = $Getday;

        $firstDate = $year . "/" . $month . "/" . "01";
        $endDate = $year . "/" . $month . "/" . "31";

        $res = mysqli_query($link, "SELECT * FROM attendance_logs WHERE log_date BETWEEN '$firstDate' AND '$endDate' AND "
            . "company_id = '$companyId' AND  empno = '$empno'");
        return $res;
    }

    public function getEmployeeDetails($empno)
    {
        $res = mysqli_query($link, "SELECT * FROM emp_info WHERE empno = '$empno'");
        $rows = mysqli_fetch_array($res);
        $fname = $rows['fname'];
        $lname = $rows['lname'];
        $details = $fname . " " . $lname;
        return $details;
    }

    function timeDiff($firstTime, $lastTime)
    {
        $firstTime = strtotime($firstTime);
        $lastTime = strtotime($lastTime);

        $timeDiff = $lastTime - $firstTime;

        $years = abs(floor($timeDiff / 31536000));
        $days = abs(floor(($timeDiff - ($years * 31536000)) / 86400));
        $hours = abs(floor(($timeDiff - ($years * 31536000) - ($days * 86400)) / 3600));
        $mins = abs(floor(($timeDiff - ($years * 31536000) - ($days * 86400) - ($hours * 3600)) / 60)); #floor($difference / 60);
        $timeworked = $hours . " Hours, " . $mins . " Minutes";

        return $timeworked;
    }
}
