<?php

class Company {

    function updateCompanyRecord($companyName, $address, $phone, $email, $date_registration, $Id) {
        $result = mysql_query("UPDATE company SET name='$companyName',address='$address',"
                . "phone='$phone',email='$email',date_registration='$date_registration'"
                . "WHERE company_ID= '$Id'");
        return $result;
    }

    function updateCompanyRecordWithLogo($companyName, $address, $phone, $email, $date_registration, $Id, $file) {
        $result = mysql_query("UPDATE company SET name='$companyName',address='$address',"
                . "phone='$phone',email='$email',date_registration='$date_registration', logo='$file'"
                . "WHERE company_ID= '$Id'");
        return $result;
    }

    function addCompany($companyName, $address, $phone, $email, $date_registration, $file) {
        $res = mysql_query("INSERT INTO company(name,address,phone,"
                . "email,date_registration,logo,status) "
                . "VALUES('$companyName','$address','$phone','$email','$date_registration',"
                . "'$file','active')");
        return $res;
    }

    function getCompnayNameById($id) {
        $query = mysql_query("SELECT * FROM company WHERE company_ID= '$id'");
        $row = mysql_fetch_array($query);
        $companyName = $row['name'];
        return $companyName;
    }

    function adduser($username, $password, $companyId, $usertype, $firstname, $lastname, $email) {
        $encryptedPassword = md5($password);
        $res = mysql_query("INSERT INTO users_tb(user_name,password,company_id,user_type,firstname,lastname,email_address) "
                . "VALUES('$username','$encryptedPassword','$companyId','$usertype','$firstname','$lastname','$email')")or mysql_error();
        return $res;
    }

    function updateUserDetails($companyId, $usertype, $firstname, $lastname, $email,$Id) {
        $result = mysql_query("UPDATE users_tb SET company_id='$companyId',user_type='$usertype',"
                . "firstname='$firstname',lastname='$lastname',email_address='$email'"
                . "WHERE id= '$Id'");
        return $result;
    }

    function getCompanyLists() {
        $query = mysql_query("SELECT * FROM company");
        return $query;
    }

}
