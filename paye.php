<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
session_start();?>
<head>
<meta charset="utf-8" http-equiv="Content-Type" content="text/html;/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- css -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
<title>Crystal Pay</title>
</head>
<?php include_once 'connect.php';?>
<body>
<!--color palette
#F5612A: sable orange
--->
<!--Sable Document Imaging Architects--->
<!---header--->
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
<div id="sdi-content">
<div class="wrap">
          <center>
<form action="addPaye.php" method="post" id="addDept">
<h4>Pay As You Earn Setup</h4>
<table width=100% border=0>
<tr><td ><h2>Band Top 1</h2></td><td  align=right>
<input id="top1" name="top1"  type="text" class="form-control"  size="30" type="text" value="" autocomplete="off"/></td></tr><br>
<tr><td ><h2>Band Rate 1</h2></td>
<td  align=right><input id="rate1" name="rate1"  type="text" class="form-control"  size="30" type="text" value="" autocomplete="off"/></td></tr>
<tr><td ><h2>Band Top 2</h2></td>
<td  align=right><input id="top2" name="top2"  type="text" class="form-control"  size="30" type="text" value="" autocomplete="off"/></td></tr>
<tr><td ><h2>Band Rate 2</h2></td><td align=right> 
<input id="rate3" name="rate2"  type="text" class="form-control"  size="30" type="text" value="" autocomplete="off"/></td></tr>
<tr><td ><h2>Band Top 3</h2></td><td align=right> 
<input id="top3" name="top3"  type="text" class="form-control"  size="30" type="text" value="" autocomplete="off"/></td></tr>
<tr><td ><h2>Band Rate 3</h2></td><td align=right> 
<input id="rate3" name="rate3"  type="text" class="form-control"  size="30" type="text" value="" autocomplete="off"/></td></tr>
<tr><td ><h2>Band Rate 4</h2></td><td align=right>
<input id="rate4" name="rate4"  type="text" class="form-control"  size="30" type="text" value="" autocomplete="off"/></td></tr><br>
<tr><td ><h2>Start Date</h2></td><td align=right>
<input id="date1" name="date1"  type="text" class="form-control"  size="30" type="text" value="" autocomplete="off"/></td></tr><br>
<tr><td ><h2>End Date</h2></td><td align=right>
<input id="date2" name="date2"  type="text" class="form-control"  size="30" type="text" value="" autocomplete="off"/></td></tr><br>
<tr><td  align=center>
 <input type="submit" class="btn btn-lg btn-warning" value="Save" /></td>
</tr>
</table>
</form>
		  <h2><a href="salary.php">Back</a></h2><h2><a href="login.php">Next</a></h2>
</div>
</div>
<div id="sdi-footer">
<div class="wrap">
&copy; 2016 Crystaline Technologies Limited <span class="designer">Design by Innovation Team .</span>
</div>
</div>
</body>
	<script src="src/js/jquery.js"></script>
    <script src="src/js/bootstrap.min.js"></script>
	<script src="src/js/jquery.smooth-scroll.min.js"></script>
	<script src="src/js/jquery.dlmenu.js"></script>
	<script src="src/js/wow.min.js"></script>
	<script src="src/js/custom.js"></script>
</html><SCRIPT Language=VBScript>