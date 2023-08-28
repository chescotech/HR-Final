<?php
$companyType = $companyType = $_SESSION['username'];
if ($companyType == "Crystaline") {
echo ' 
<div id="sdi-header">
    <div class="wrap"><div id="logo"><img src="src/images/Logo.png" width="321" height="98" /></div><div id="top-nav"></div></div>                                    
</div>';
} else {
echo ' 
<div id="sdi-header">
    <div class="wrap"><div id="logo"><img src="src/images/lso_logo.png" width="321" height="98" /></div><div id="top-nav"></div></div>                                    
</div>';
}
?>