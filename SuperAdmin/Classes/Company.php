<?php

class Company
{
    private $link;

    function __construct()
    {
        $this->link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('db connection problem' . mysqli_connect_error());
    }

    function updateCompanyRecord($companyName, $address, $phone, $email, $date_registration, $Id)
    {
        $result = mysqli_query($this->link, "UPDATE company SET name='$companyName',address='$address',"
            . "phone='$phone',email='$email',date_registration='$date_registration'"
            . "WHERE company_ID= '$Id'");
        return $result;
    }

    function updateCompanyRecordWithLogo($companyName, $address, $phone, $email, $date_registration, $Id, $file)
    {
        $result = mysqli_query($this->link, "UPDATE company SET name='$companyName',address='$address',"
            . "phone='$phone',email='$email',date_registration='$date_registration', logo='$file'"
            . "WHERE company_ID= '$Id'");
        return $result;
    }

    function addCompany($companyName, $address, $phone, $email, $date_registration, $file)
    {
        $res = mysqli_query($this->link, "INSERT INTO company(name,address,phone,"
            . "email,date_registration,logo,status) "
            . "VALUES('$companyName','$address','$phone','$email','$date_registration',"
            . "'$file','active')");
        return $res;
    }

    function getCompnayNameById($id)
    {
        $query = mysqli_query($this->link, "SELECT * FROM company WHERE company_ID= '$id'");
        $row = mysqli_fetch_array($query);
        $companyName = $row['name'];
        return $companyName;
    }

    function adduser($username, $password, $companyId, $usertype, $firstname, $lastname, $email)
    {
        $encryptedPassword = md5($password);
        $res = mysqli_query($this->link, "INSERT INTO users_tb(user_name,password,company_id,user_type,firstname,lastname,email_address) "
            . "VALUES('$username','$encryptedPassword','$companyId','$usertype','$firstname','$lastname','$email')") or mysqli_error($this->link);
        return $res;
    }

    function updateUserDetails($companyId, $usertype, $firstname, $lastname, $email, $Id)
    {
        $result = mysqli_query($this->link, "UPDATE users_tb SET company_id='$companyId',user_type='$usertype',"
            . "firstname='$firstname',lastname='$lastname',email_address='$email'"
            . "WHERE id= '$Id'");
        return $result;
    }

    function getCompanyLists()
    {
        $query = mysqli_query($this->link, "SELECT * FROM company");
        return $query;
    }
}
