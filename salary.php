<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
session_start();?>
<head>
<meta charset="utf-8" http-equiv="Content-Type" content="text/html;/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- css -->
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
 <div  style="padding:15px;border:1px solid #CCC; background-color: #FFFFFF;">
          <form action="addEarning.php" method="post" id="addDept">
		  <h4>Add Earning</h4>
            <ol>
              <li><h2>Name</h2></li>
              <li>
                <input id="name" name="name"  type="text" class="form-control"  size="30" type="text" value="" autocomplete="off"/>
              </li>
              <br>
              </ol>
			  <br>
			  <input type="submit" class="btn btn-lg btn-warning" value="Add" />
				<input type='hidden' name='dept' value=''>
			  </form>
			  </div>
			  <br>
			   <div  style="padding:15px;border:1px solid #CCC; background-color: #FFFFFF; align">
          <form action="addDed.php" method="post" id="addDept">
		  <h4>Add Deduction</h4>
            <ol>
              <li><h2>Name</h2></li>
              <li>
                <input id="name" name="name"  type="text" class="form-control"  size="30" type="text" value="" autocomplete="off"/>
              </li>
              <br>
              </ol>
			  <br>
			  <input type="submit" class="btn btn-lg btn-warning" value="Add" />
			  </form>
			  </div>
			  <h2><a href="company.php">Back</a></h2> <h2><a href="paye.php">Next</a></h2>
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