<html>
<head>
<style>
div{
  	background: url(img_dog.jpg);
    background-repeat: no-repeat, repeat;
    padding: 15px;


background-color:
    width: 900px;
    padding: 25px;
    border: 25px solid navy;
    margin: 25px;
}
</style>
</head>

<body>

<a href="email.php">Notifications</a>

<center>
<div>
	<h2>REPUBLIC OF ZAMBIA</h2>
	<h3> Department of veterinary services</h3>
    <h1> RABIES VACCINATION CERTIFICATE</h1>

<form action="certificate.php" method="post">

property of:<input type="text" name="property of"><br />
Address:<input type="text" name = "address"><br />
descriptions:<br />
markings:<input type="text" name = "markings"> age: <input type="text" name = "age"><br />
previous vaccination:<br />
date:<input type="text" name="date">
Signature:<input type="text" name="signature">

  
 <div class="form-actions">
                          <button type="submit" class="btn btn-success">generate certificate</button>
                          
                        </div>
						
</form>
</div>


<?php
error_reporting(1);
$property_of= $_POST['property_of'];
$Address = $_POST['Address'];
$markings = $_POST['markings'];
$previous_vaccination = $_POST['previous_vaccination'];
$date= $_POST['date'];
$signature= $_POST['signature'];

echo "<h2>your rabies certificate:</h2>";
echo $property_of;
echo "<br>";
echo $Address;
echo "<br>";
echo $markings;
echo "<br>";
echo $previous_vaccination;
echo "<br>";
echo $date;
echo "<br>";
echo $signature;
?>

</body>
</html> 





