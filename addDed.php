<?php
session_start(); ?>
<html>

<head>
</head>

<body onload="load()">
	<?php
	$name = $_POST['name'];


	$comp_ID = $_SESSION["username"];

	$posted = false;
	if (count($_POST) > 0) {
		$posted = true;

		$host = "localhost";
		$user  = "root";
		$pass = "";
		$database = "pay";

		var_dump($_POST);
		/* Checking connection */
		if ($connection = mysql_connect($host, $user, $pass) or die("error in connection")) {

			mysql_select_db($database);

			$query = "INSERT INTO deductions VALUES ('$id','$name','$comp_ID')";
			//$query = "INSERT INTO employee VALUES ($id,$empno,$pay,$dayswork,$otrate,$othrs,$allow,$advances,$insurance,'$time')";

			$result = mysql_query($query, $connection) or die("invalid query" . mysqli_error($link));
		} else {
			exit("Connect Error " . mysqli_error($link));
		}

	?>
		<script type='text/javascript'>
			alert('Deduction Added!')
			window.location.assign('salary.php')
		</script>
	<?php
		//header('Location:claims.php?');
	} else {

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