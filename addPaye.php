
<?php
session_start();?>
<html>
<head>
</head>

<body onload="load()">
<?php
$top1=$_POST['top1'];
$rate1=$_POST['rate1'];
$top2=$_POST['top2'];
$rate2=$_POST['rate2'];
$top3=$_POST['top3'];
$rate3=$_POST['rate3'];
$rate4=$_POST['rate4'];
$date2=$_POST['date2'];
$date1=$_POST['date1'];


$comp_ID = $_SESSION["username"];

				$posted = false; 
  if(count($_POST)>0) {
    $posted = true;

$host = "localhost";
$user  = "root";
$pass = "";
$database = "pay";

var_dump($_POST);
/* Checking connection */
if ($connection=mysql_connect($host,$user,$pass) or die("error in connection")) {  
   
mysql_select_db($database);

   $query = "INSERT INTO paye VALUES ('$id','$top1','$rate1','$top2','$rate2','$top3','$rate3','$rate4','$date1','$date2','$comp_ID')";
   //$query = "INSERT INTO employee VALUES ($id,$empno,$pay,$dayswork,$otrate,$othrs,$allow,$advances,$insurance,'$time')";
 
 $result=mysql_query ($query,$connection) or die ("invalid query".mysql_error());
} else {  
   exit ("Connect Error " . mysql_error);
} 
      
	  ?>
        <script type='text/javascript'>
		alert('Deduction Added!')
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
						window.location.assign('salary.php')
						</script>
						<?php
    
    }
 
?> 
</body>
<?php
?>
</html>
