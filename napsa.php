<?php

// Inialize session
 session_start();

// Check, if username session is NOT set then this page will jump to login page
 if (!isset($_SESSION['username'])) {
 header('Location: login page/admin.php');
 }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Crystal Pay</title>
<meta charset="utf-8" http-equiv="Content-Type" content="text/html;/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- css -->
	
<link href="src/css/bootstrap.min.css" rel="stylesheet" media="screen">

<link href="src/css/color/default.css" rel="stylesheet" media="screen">
<script src="src/css/js/modernizr.custom.js"></script>
<script type="text/javascript" src="src/js/jquery.js"></script>
<link rel="stylesheet" href="default/default.css" type="text/css" media="screen" />
<link href="src/css/main.css" rel="stylesheet"   type="text/css"/>
<link href="src/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="src/css/nivo-slider.css" type="text/css" media="screen" />
<script type="text/javascript" src="src/js/jquery.nivo.slider.pack.js"></script>
</head>
<script type="text/javascript">
 function proceed() {
  return confirm("Save this entry?");
 }
 function startTime() {
  var today=new Date();
  var h=today.getHours();
  var m=today.getMinutes();
  var s=today.getSeconds();
  // add a zero in front of numbers<10
  m=checkTime(m);
  s=checkTime(s);
  document.getElementById('txt').innerHTML=h+":"+m+":"+s;
  t=setTimeout('startTime()',500);
 }
 function checkTime(i) {
  if (i<10) {
   i="0" + i;
  }
  return i;
 }
</script>
<body>
<div id="sdi-header">
<div class="wrap"><div id="logo"><img src="src/images/Logo.png" width="221" height="58" /></div><div id="top-nav"><strong>E-mail: sales@crystaline.co.zm | Tel:0211 260 269 483</strong></div></div>
</div>
<center>
<div id="sdi-nav">
<div class="wrap">
<a  href="abc.php" >Home<img src="links/main3.png" height="25"></a>
<a href="entry.php" >Entry<img src="links/entry.png" height="25"></a>
<a href="add.php" >Add<img src="links/edit.png" height="25"></a>
<a href="search.php" >Search<img src="links/2.PNG" height="25"></a>
<a href="loan.php" >Loan<img src="links/2.PNG" height="25"></a>
</div>
</div>
<br>
<br>
<div class="profile">
<?php
// End of insert/update if there's any	 

//Initialize input fields
$insert = 1;
$id = "0";
$empno = "0";
$pay = "0";
$dayswork = "0";
$otrate = "0";
$othrs = "0";
$allow = "0";
$advances = "0";
$insurance = "0";
$bmonth0 = "selected";
$bmonth1 = "";
$bmonth2 = "";
$bmonth3 = "";
$bmonth4 = "";
$bmonth5 = "";
$bmonth6 = "";
$bmonth7 = "";
$bmonth8 = "";
$bmonth9 = "";
$bmonth10 = "";
$bmonth11 = "";
$bmonth12 = "";

$bday = "DD";
$byear = "YYYY";

$taxable ='';
$social = "";
$paid = "";
$comp_ID = $_SESSION["username"];
$company_id = $comp_ID;
//End of input field initialization

// If update then retrieve record
if (isset($_GET['empno'])) {
  $insert = 0;
  $id = $_GET['empno'];
  $query = "SELECT * FROM tax WHERE empno = '$empno'";
  include 'include/dbconnection.php';
  $result = mysql_query($query,$link) or die (mysql_error());
  if (!mysql_num_rows($result)) {
    $id = 0;
	$msg = "No record found!";
  }	
  else {
	$row = mysql_fetch_array($result,MYSQL_ASSOC);
		$id = $row['id'];

	$empno = $row['empno'];
        $social = $row['social'];
       


  }
}
?>
<?php

$msg = "";

//Save record (Insert/Update)

if (isset($_POST['insert'])) {
	
	
	
  if ($_POST['insert'])
    $insert = 1;
  else
    $insert = 0;
$empno = $_POST['empno'];
$social=$_POST['social'];
$taxable=0;
$paid=0;
 

mysql_connect("localhost", "root" , "" )or die("cannot connect to database server");  
	mysql_select_db("pay")or die("cannot select the database");
	

 if(isset($_POST['insert']))
	{	
		//check if every fields are entered
		if(!$_POST['social'])
		{
			header("location:napsa.php?err=1");
		}
	else if(!$_POST['empno'])
	       {
			header("location:napsa.php?err=2");
			}
		else
		{
		





     if ($insert)      {
  	 
	  $query = "INSERT INTO tax VALUES ($id,'$taxable','$paid','$empno','$company_id','$social')";
	
	?>
	<?php

$msg ="<center><table border='1' width='150' ><td bgcolor='#009933'><center>New record saved!</center></label></table></center>";

  }
	else	
{
    $query = "UPDATE loan SET empno=$empno,loan_amt=$loan_amt,loan_deduct=$loan_deduct,months=$months WHERE LOAN_NO = $LOAN_NO";

   $msg ="<center><table border='1' width='100' ><td bgcolor='#009933'><center>New Updated!</center></label></table></center>";

  }
  include 'include/dbconnection.php';
 
 
  

echo '<center>';
  $result=mysql_query ($query,$link) or die ("invalid query".mysql_error());
 echo '</center>';   
 
}
	}}
	   
?>  

<?php /////////////////////////////////search Area/////////////////////////////////// ?>

	
	

<?php 
if(isset($_POST['key']))
	{	
		//check if every fields are entered
		if(!$_POST['key'])
		{
			header("location:napsa.php?err=1");
		}
	}
?>
<br>
<br>
<form method="post" action="napsa.php">
<table cellpadding="">
  <tr>
   
    <td><input type="text" name="key" value="Search Employee ID" id="key" tabindex="1" onFocus="if (this.value == 'Search Employee ID') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Search Employee ID';}" class="search">

	
    <select name="field" id="field" style="background-color="#006633" border="0" class="select">
      <option value="empno">
	 	
	  </option>
	  
      </select>
	  &nbsp;<input type="submit" name="save" id="save" value="Search" tabindex=""/></td>

  

</form>

</table>
<center><?php
	if(isset($_GET['err']))
if($_GET['err']==2)
				echo '<div class="error"><center>No ID selected search first to select employee ID!</center></div>';
				?>
        </center>
</form>
<br/>
</div>
<div class="body">
<div class="entry">

<table border="0" cellspacing="0" class="en" >  
 
<?php 
if (isset($_POST["field"])) {
  $key = strtoupper($_POST["key"]);
  $field = $_POST["field"];
  if (!empty($_POST["key"]))
    if ($field == "empno")
      if (($key))
        $query = "SELECT * FROM emp_info WHERE empno = '$key'";
     else
	
      $query = "SELECT * FROM emp_info WHERE UPPER($field) like '$key%'";
  else
    $query = "SELECT * FROM emp_info";
include 'include/dbconnection.php'; 
$result = mysql_query($query,$link) or die (mysql_error());
while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
	echo '<label>';
  echo '<tr><tr><td bordercolor="#FFFFFF">Id no<td>:</td><td width="20"></td></td><td>'.$row['empno'].'</td></tr>';
  
  echo '<td>Last name<td>:</td><td></td></td><td>'.$row['lname'].'</td>';
 
  echo '<tr><td>First name<td>:</td><td></td></td><td>'.$row['fname'].'</td></tr>';
   
  echo '<tr><td>Middle I<td>:</td><td></td></td><td>'.$row['init'].'</td></tr>';
   
 echo '<tr><td colspan="3">

 </td></tr>';
echo '</label>';
 // echo "<td><a href='search.php?empno=".$row['empno']."'>Delete</td>";
}
}

echo'</table>';

?>

<?php /////////////////////////////////end search Area/////////////////////////////////// ?>

</div>
<div class="entry1">
<div class="head1">


</div>
  <div class="body1">
<?php
		if(isset($_GET['err']))
		{
			if($_GET['err']==1)
				echo '<div class="error_pop"><div class="error"><center>Please input data in fields<a href="napsa.php"><h6>Close</h6></a></center></div></div>
		';
			
			else if($_GET['err']==3)
				echo '<div class="error">Username already exists, please use another one!</div>';
		}
		?>
         <style type="text/css">
.a{
	width:auto;
    
    
	input[class=id_empno], input.id_empno{
		background:#CCC;}
	}
</style>  <fieldset class="a" > <legend>Loan Entry</legend>
<?php echo '<strong>'.$msg.'</strong>'; ?>
<form method="post" action="napsa.php" onSubmit="return proceed()" class="form">

<table border="0" cellspacing="0" align="center"  " class="form" >
  
    <?php 
	$result="";
if (isset($_POST["field"])) {
  $key = strtoupper($_POST["key"]);
  $field = $_POST["field"];
  if (!empty($_POST["key"]))
    if ($field == "empno")
      if (($key))
        $query = "SELECT * FROM emp_info WHERE empno = '$key'";
     
     else
      $query = "SELECT * FROM emp_info WHERE UPPER($field) like '$key%'";
  else
    $query = "SELECT * FROM emp_info";
include 'include/dbconnection.php'; 
$result = mysql_query($query,$link) or die (mysql_error( ));
while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
	echo ' <tr>';
    echo '<td width="174">Employee ID</td>';
	echo '<td>';
	echo ' ';
  
echo '<input type="text" name="empno" class="id_empno" value='.$row['empno'].' readonly>';

  echo '</td>';
}
}
   ?>
   
    
  <tr>
    <td>Social Security Number:</td>
    <td><input type="text" name="social" value="<?php echo $social; ?>" tabindex="14" title="Enter Number"onFocus="if (this.value == '0') {this.value = '';}" onBlur="if (this.value == '0')" {this.value = '0';} /></td>
  </tr>
    
  <tr>
   <td colspan="2" align="center">
   
	<input type="submit" name="save" id="save" value="Save" tabindex="19"/>
	<input type="reset" value="Reset"></td>
	</td>
  </tr>
</table>

<input type="hidden" name="insert" value="<?php echo $insert; ?>" />
</form>

</div>
<div class="foot1"></div>
</div>
</div>


<div class="footer"></div>
</div>
</body>
<footer>
 <!-- js -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.smooth-scroll.min.js"></script>
	<script src="js/jquery.dlmenu.js"></script>
	<script src="js/wow.min.js"></script>
	<script src="js/custom.js"></script>
</footer>
</html>
