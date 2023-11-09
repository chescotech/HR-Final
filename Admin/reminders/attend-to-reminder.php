<?php
include('../../include/dbconnection.php');
$reminderType = $_GET['reminder_type'];
$id = $_GET['id'];

if($reminderType == "Contract Reminder"){
    mysqli_query($link,"UPDATE emp_info SET date_left ='' WHERE id= '$id'");    
}else{
    mysqli_query($link,"UPDATE emp_info SET probation_deadline ='' WHERE id= '$id'");
}

header('location:show-reminders');




