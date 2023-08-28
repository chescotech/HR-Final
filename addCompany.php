<?php
session_start();?>
<html>
<head>
</head>
<body onload="load()">
<?php
$name=$_POST['name'];
$address=$_POST['address'];
$phone = $_POST['phone'];
$email=$_POST['email'];
$username=$_POST['username'];
$password=$_POST['password'];
//$_SESSION["username"]= $usename;
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
   $query = "INSERT INTO company VALUES ('$id','$name','$address','$phone','$email','$username','$password')";
   //$query = "INSERT INTO employee VALUES ($id,$empno,$pay,$dayswork,$otrate,$othrs,$allow,$advances,$insurance,'$time')";
 $result=mysql_query ($query,$connection) or die ("invalid query".mysql_error());
} else {  
   exit ("Connect Error " . mysql_error);
} 
	  ?>
        <script type='text/javascript'>
		alert('Company Added!')
		window.location.assign('company.php')
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
