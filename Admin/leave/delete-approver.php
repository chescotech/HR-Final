<?php
include('../../include/dbconnection.php');
session_start();
$id=$_GET['id'];

mysqli_query($link,"delete from appover_groups where id='$id'") or die(mysqli_error($link));
  echo "<script>document.location='assign-to-workflow.php?id=$id'</script>";
