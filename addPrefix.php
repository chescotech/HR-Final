<?php
session_start();?>
<html>
<head>
</head>
<body onload="load()">
<?php
$name=$_POST['name'];
$comp_ID = $_SESSION["username"];
				$posted = false; 
  if(count($_POST)>0) {
    $posted = true;
$host = "localhost";
$user  = "root";
$pass = "";
$database = "pay";
$id="";
var_dump($_POST);
/* Checking connection */
if ($connection=mysql_connect($host,$user,$pass) or die("error in connection")) {  
mysql_select_db($database);
   $query = "INSERT INTO prefix VALUES ('$id','$name','$comp_ID')";
 $result=mysql_query ($query,$connection) or die ("invalid query".mysql_error());
} else {  
   exit ("Connect Error " . mysql_error);
} 
	  ?>
        <script type='text/javascript'>
		alert('Prefix Added!')
		window.location.assign('salary.php')
		</script>
		<?php
		//header('Location:claims.php?');
					}
					else
					{
						?>
						<script type='text/javascript'>
						alert('Please Enter Details Again')
						window.location.assign('setup.php')
						</script>
						<?php
    }
?> 
</body>
<?php
?>
</html>
