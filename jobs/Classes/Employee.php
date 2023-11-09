<?php

include 'DBClass.php';

class Employee
{

    function __construct()
    {
        $conn = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die('db connection problem' . mysqli_error($link));
        mysql_select_db(DB_NAME, $conn);
    }

    public function updateProfileInfo($fname, $lname, $city)
    {
        $res = mysqli_query($link, "INSERT leave(first_name,last_name,user_city) VALUES('$fname','$lname','$city')");
        return $res;
    }

    public function getProfileInfo($employeeId)
    {
        $res = mysqli_query($link, "INSERT leave(first_name,last_name,user_city) VALUES('$fname','$lname','$city')");
        return $res;
    }

    public function getApproverList()
    {
        $user_query = mysqli_query($link, "SELECT * FROM `workflows`") or die(mysqli_error($link));
        return $user_query;
    }
}
