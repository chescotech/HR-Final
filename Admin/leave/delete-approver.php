<?php
include('../../include/dbconnection.php');
session_start();
$id=$_GET['id'];

mysql_query("delete from appover_groups where id='$id'") or die(mysql_error());
  echo "<script>document.location='assign-to-workflow.php?id=$id'</script>";

?>