<?php

include('../../include/dbconnection.php');

$id = $_GET['id'];
$status = $_GET['status'];
if($status == "Suspend"){
    $set_status = "Suspended";
}else{
     $set_status = "active";
}
mysqli_query($link,"UPDATE company SET status = '$set_status' where company_ID='$id'") or die(mysqli_error($link));

header('location:company-list.php');
