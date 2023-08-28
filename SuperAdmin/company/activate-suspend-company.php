<?php

include('../../include/dbconnection.php');

$id = $_GET['id'];
$status = $_GET['status'];
if($status == "Suspend"){
    $set_status = "Suspended";
}else{
     $set_status = "active";
}
mysql_query("UPDATE company SET status = '$set_status' where company_ID='$id'") or die(mysql_error());

header('location:company-list.php');

?>