<?php

include('../../include/dbconnection.php');

$empid=$_GET['id'];

mysqli_query($link,"UPDATE emp_edu_info_tb SET status='Approved' WHERE emp_id='$empid'") or die(mysqli_error($link));

$CheckQuery = mysqli_query($link,"SELECT * FROM emp_history_tb WHERE emp_id='$empid' ");
if(mysqli_num_rows($CheckQuery) > 0){
    mysqli_query($link,"UPDATE emp_history_tb SET status='Approved' WHERE emp_id='$empid'") or die(mysqli_error($link));
}

header('location:employee-documents');
