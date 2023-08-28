<?php

include('../../include/dbconnection.php');

$empid = $_GET['id'];

mysql_query("UPDATE emp_edu_info_tb SET status='Declined' WHERE emp_id='$empid'") or die(mysql_error());

$CheckQuery = mysql_query("SELECT * FROM emp_history_tb WHERE emp_id='$empid' ");
if(mysql_num_rows($CheckQuery) > 0){
    mysql_query("UPDATE emp_history_tb SET status='Declined' WHERE emp_id='$empid'") or die(mysql_error());
}

header('location:employee-documents');

?>