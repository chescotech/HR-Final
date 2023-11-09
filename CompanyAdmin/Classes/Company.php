<?php

class Company
{

    function updateCompanyRecord($companyName, $address, $phone, $email, $date_registration, $Id)
    {
        $result = mysqli_query($link, "UPDATE company SET name='$companyName',address='$address',"
            . "phone='$phone',email='$email',date_registration='$date_registration'"
            . "WHERE company_ID= '$Id'");
        return $result;
    }

    function updateCompanyRecordWithLogo($companyName, $address, $phone, $email, $date_registration, $Id, $file)
    {
        $result = mysqli_query($link, "UPDATE company SET name='$companyName',address='$address',"
            . "phone='$phone',email='$email',date_registration='$date_registration', logo='$file'"
            . "WHERE company_ID= '$Id'");
        return $result;
    }

    public function checkIfEmployeeExsists($pass, $Id)
    {
        $password = md5($pass);
        $result = mysqli_query($link, "SELECT * FROM users_tb WHERE password='$password' AND id='$Id'");
        return $result;
    }

    public function changePasssword($pass, $Id)
    {
        $password = md5($pass);
        $result = mysqli_query($link, "UPDATE users_tb SET password ='$password' WHERE id= '$Id'");
        return $result;
    }

    function getFirstname($empno)
    {
        $query = mysqli_query($link, "SELECT * FROM emp_info WHERE empno = '$empno'");
        $rows = mysqli_fetch_array($query);
        $fname = $rows['fname'];
        return $fname;
    }

    function getLastname($empno)
    {
        $query = mysqli_query($link, "SELECT * FROM emp_info WHERE empno = '$empno'");
        $rows = mysqli_fetch_array($query);
        $lname = $rows['lname'];
        return $lname;
    }

    function getEmployeeEmail($empno)
    {
        $query = mysqli_query($link, "SELECT * FROM emp_info WHERE empno = '$empno'");
        $rows = mysqli_fetch_array($query);
        $email = $rows['email'];
        return $email;
    }

    function getEmpPosition($empno)
    {
        $query = mysqli_query($link, "SELECT * FROM emp_info WHERE empno = '$empno'");
        $rows = mysqli_fetch_array($query);
        $position = $rows['position'];
        return $position;
    }

    function addCompany($companyName, $address, $phone, $email, $date_registration, $file)
    {
        $res = mysqli_query($link, "INSERT INTO company(name,address,phone,"
            . "email,date_registration,logo,status) "
            . "VALUES('$companyName','$address','$phone','$email','$date_registration',"
            . "'$file','active')");
        return $res;
    }

    function getCompnayNameById($id)
    {
        $query = mysqli_query($link, "SELECT * FROM company WHERE company_ID= '$id'");
        $row = mysqli_fetch_array($query);
        $companyName = $row['name'];
        return $companyName;
    }

    function adduser($username, $password, $companyId, $usertype, $empno)
    {
        $encryptedPassword = md5($password);
        $res = mysqli_query($link, "INSERT INTO users_tb(user_name,password,company_id,user_type,empno) "
            . "VALUES('$username','$encryptedPassword','$companyId','$usertype','$empno')") or mysqli_error($link);
        return $res;
    }

    function updateUserDetails($companyId, $usertype, $firstname, $lastname, $email, $Id)
    {
        $result = mysqli_query($link, "UPDATE users_tb SET company_id='$companyId',user_type='$usertype',"
            . "firstname='$firstname',lastname='$lastname',email_address='$email'"
            . "WHERE id= '$Id'");
        return $result;
    }

    function getCompanyLists()
    {
        $query = mysqli_query($link, "SELECT * FROM company");
        return $query;
    }

    function getEmployeeListByCompany($companyId)
    {
        $query = mysqli_query($link, "SELECT * FROM emp_info WHERE company_id = '$companyId' ");
        return $query;
    }
}
