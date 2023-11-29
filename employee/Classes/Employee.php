<?php

class Employee
{
    private $link;

    function __construct()
    {
        $this->link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('db connection problem' . mysqli_connect_error());
    }

    public function updateProfileInfo($fname, $lname, $city)
    {
        $res = mysqli_query($this->link, "INSERT leave(first_name,last_name,user_city) VALUES('$fname','$lname','$city')");
        return $res;
    }

    public function getProfileInfo($employeeId)
    {
        $res = mysqli_query($this->link, "SELECT * FROM employee WHERE id='$employeeId'");
        return $res;
    }

    public function getApproverList()
    {
        $user_query = mysqli_query($this->link, "SELECT * FROM `workflows`") or die(mysqli_error($this->link));
        return $user_query;
    }
}
