<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<title>Crystal Pay</title>
<link href="src/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="src/css/style.css" rel="stylesheet" media="screen">
<link href="src/css/color/default.css" rel="stylesheet" media="screen">
<script src="src/css/js/modernizr.custom.js"></script>
<script type="text/javascript" src="src/js/jquery.js"></script>
<link rel="stylesheet" href="default/default.css" type="text/css" media="screen" />
<link href="src/css/main.css" rel="stylesheet"   type="text/css"/>
<link href="src/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="src/css/nivo-slider.css" type="text/css" media="screen" />
<script type="text/javascript" src="src/js/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript">
$(window).load(function() {
$('#slider').nivoSlider();
});
</script>
</head>

<body class="home">
<div id="sdi-header">
<div class="wrap"><div id="logo"><img src="src/images/Logo.png" width="221" height="58" /></div><div id="top-nav"><strong>E-mail: sales@crystaline.co.zm | Tel:0211 260 269 483</strong></div></div>
</div>
<div id="sdi-nav">
<div class="wrap">
<a  href="abc.php" >Home<img src="links/main3.png" height="25"></a>
<a href="entry.php" >Entry<img src="links/entry.png" height="25"></a>
<a href="add.php" >Add<img src="links/edit.png" height="25"></a>
<a href="search.php" >Search<img src="links/2.PNG" height="25"></a>
<a href="logout.php" >Logout</a>
</div>
</div>
<body>
<br>
						Search
					<form name="Search" method="get" action="search.php"> 
					<input name="txtKeyword" type="text" id="txtKeyword" > 
					<input type="submit" value="Search" >
					</form>
					<br>
 <table  cellspacing="2" border='3'>
              <thead>
                    <th><h4>Employee Number</h4></th>
                    <th><h4>First Name</h4></th>
					<th><h4>Last Name</h4></th>
					<th><h4>Phone Number</h4></th>
					<th><h4>Email Address</h4></th>
					<th><h4>Address</h4></th>
					<th><h4>Bank Name</h4></th>
					<th><h4>Account Number</h4></th>
					<th><h4>Date Joined</h4></th>
					<th><h4>Employee Grade</h4></th>
					<th><h4>Marital Status</h4></th>
					<th><h4>Payment Method</h4></th>
					</thead>
                <tbody>
                <?php
session_start();
$comp_ID = $_SESSION["username"];
  include 'include/dbconnection.php';
     $query = "SELECT * FROM emp_info WHERE company_id = '$comp_ID'";
  include 'include/dbconnection.php';
  $result = mysql_query($query,$link) or die (mysql_error());
  if (!mysql_num_rows($result)) {
    $id = 0;
	$msg = "No record found!";
  }	
  else {
	$row = mysql_fetch_array($result,MYSQL_ASSOC);
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
  $id = $row['id'];
  $empno = $row['empno'];
  $photo = $row['photo'];
  $lname = $row['lname'];
  $fname = $row['fname'];
  $init = $row['init'];
  $phone= $row['phone'];
  $email = $row['email'];
  $address =$row['address'];
  $bank= $row['bank'];
  $account= $row['account'];
  $date_joined =$row['date_joined'];
  $date_left= $row['date_left'];
  $employee_grade = $row['employee_grade'];
  $marital_status = $row['marital_status'];
  $leave_days = $row['leave_days'];
  $payment_method = $row['payment_method'];
	}	
                    echo "<td>".$empno."</td>\n";
					echo "<td>".$fname."</td>\n";
					echo "<td>".$lname."</td>\n";
					echo "<td>".$phone."</td>\n";
					echo "<td>".$email."</td>\n";
					echo "<td>".$address."</td>\n";
					echo "<td>".$bank."</td>\n";
					echo "<td>".$account."</td>\n";
					echo "<td>".$date_joined."</td>\n";
					echo "<td>".$employee_grade."</td>\n";
					echo "<td>".$marital_status."</td>\n";
					echo "<td>".$payment_method."</td>\n";
					echo " </tbody>";
					echo "</table>";
                ?>
        </div>
</body>
<footer>
 <!-- js -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.smooth-scroll.min.js"></script>
	<script src="js/jquery.dlmenu.js"></script>
	<script src="js/wow.min.js"></script>
<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="assets/js/template.js"></script>
	<script src="js/custom.js"></script>
</footer>
</html><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<title>Crystal Pay</title>
<link href="src/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="src/css/style.css" rel="stylesheet" media="screen">
<link href="src/css/color/default.css" rel="stylesheet" media="screen">
<script src="src/css/js/modernizr.custom.js"></script>
<script type="text/javascript" src="src/js/jquery.js"></script>
<link rel="stylesheet" href="default/default.css" type="text/css" media="screen" />
<link href="src/css/main.css" rel="stylesheet"   type="text/css"/>
<link href="src/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="src/css/nivo-slider.css" type="text/css" media="screen" />
<script type="text/javascript" src="src/js/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript">
$(window).load(function() {
$('#slider').nivoSlider();
});
</script>
</head>
>
</head>
<body class="home">
<div id="sdi-header">
<div class="wrap"><div id="logo"><img src="src/images/Logo.png" width="221" height="58" /></div><div id="top-nav"><strong>E-mail: sales@crystaline.co.zm | Tel:0211 260 269 483</strong></div></div>
</div>
<div id="sdi-nav">
<div class="wrap">
<a  href="abc.php" >Home<img src="links/main3.png" height="25"></a>
<a href="entry.php" >Entry<img src="links/entry.png" height="25"></a>
<a href="add.php" >Add<img src="links/edit.png" height="25"></a>
<a href="search.php" >Search<img src="links/2.PNG" height="25"></a>
<a href="logout.php" >Logout</a>
</div>
</div>
<body>
<br>
						Search
					<form name="Search" method="get" action="search.php"> 
					<input name="txtKeyword" type="text" id="txtKeyword" > 
					<input type="submit" value="Search" >
					</form>
					<br>
 <table  cellspacing="2" border='3'>
              <thead>
                    <th><h4>Employee Number</h4></th>
                    <th><h4>First Name</h4></th>
					<th><h4>Last Name</h4></th>
					<th><h4>Phone Number</h4></th>
					<th><h4>Email Address</h4></th>
					<th><h4>Address</h4></th>
					<th><h4>Bank Name</h4></th>
					<th><h4>Account Number</h4></th>
					<th><h4>Date Joined</h4></th>
					<th><h4>Employee Grade</h4></th>
					<th><h4>Marital Status</h4></th>
					<th><h4>Payment Method</h4></th>
					</thead>
                <tbody>
                <?php
session_start();
$comp_ID = $_SESSION["username"];
  include 'include/dbconnection.php';
     $query = "SELECT * FROM emp_info WHERE company_id = '$comp_ID'";
  include 'include/dbconnection.php';
  $result = mysql_query($query,$link) or die (mysql_error());
  if (!mysql_num_rows($result)) {
    $id = 0;
	$msg = "No record found!";
  }	
  else {
	$row = mysql_fetch_array($result,MYSQL_ASSOC);
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
  $id = $row['id'];
  $empno = $row['empno'];
  $photo = $row['photo'];
  $lname = $row['lname'];
  $fname = $row['fname'];
  $init = $row['init'];
  $phone= $row['phone'];
  $email = $row['email'];
  $address =$row['address'];
  $bank= $row['bank'];
  $account= $row['account'];
  $date_joined =$row['date_joined'];
  $date_left= $row['date_left'];
  $employee_grade = $row['employee_grade'];
  $marital_status = $row['marital_status'];
  $leave_days = $row['leave_days'];
  $payment_method = $row['payment_method'];
	}	
                    echo "<td>".$empno."</td>\n";
					echo "<td>".$fname."</td>\n";
					echo "<td>".$lname."</td>\n";
					echo "<td>".$phone."</td>\n";
					echo "<td>".$email."</td>\n";
					echo "<td>".$address."</td>\n";
					echo "<td>".$bank."</td>\n";
					echo "<td>".$account."</td>\n";
					echo "<td>".$date_joined."</td>\n";
					echo "<td>".$employee_grade."</td>\n";
					echo "<td>".$marital_status."</td>\n";
					echo "<td>".$payment_method."</td>\n";
					echo " </tbody>";
					echo "</table>";
                ?>
        </div>
</body>
<footer>
 <!-- js -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.smooth-scroll.min.js"></script>
	<script src="js/jquery.dlmenu.js"></script>
	<script src="js/wow.min.js"></script>
<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="assets/js/template.js"></script>
	<script src="js/custom.js"></script>
</footer>
</html>