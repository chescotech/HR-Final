<?php

include 'DBClass.php';

class Employee 
{
    
 function __construct()
 {
  $conn = mysql_connect(DB_SERVER,DB_USER,DB_PASS) or die('db connection problem'.mysql_error());
  mysql_select_db(DB_NAME, $conn);
 }
 
 public function updateProfileInfo($fname,$lname,$city)
 {
  $res = mysql_query("INSERT leave(first_name,last_name,user_city) VALUES('$fname','$lname','$city')");
  return $res;
 }
 
 public function getProfileInfo($employeeId)
 {
  $res = mysql_query("INSERT leave(first_name,last_name,user_city) VALUES('$fname','$lname','$city')");
  return $res;
 }
 
 public function getApproverList(){
     $user_query = mysql_query("SELECT * FROM `workflows`") or die(mysql_error());
        return $user_query;
 }

 
 
}

