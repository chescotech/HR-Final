<?php
include('../../include/dbconnection.php');
$reminderType = $_GET['reminder_type'];
$id = $_GET['id'];

if($reminderType == "Contract Reminder"){
    mysql_query("UPDATE emp_info SET date_left ='' WHERE id= '$id'");    
}else{
    mysql_query("UPDATE emp_info SET probation_deadline ='' WHERE id= '$id'");
}

header('location:show-reminders');




