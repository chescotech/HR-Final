<div id="sdi-header">
    <div class="wrap">
        <?php
        $companyType = $_SESSION['username'];
        if ($companyType == "Crystaline") {

            echo '
                <div id="logo">
                <img src="src/images/logo.png" width="321" height="98" />        
                </div>
                <div id="top-nav">
                    <br></br><strong>E-mail: sales@crystaline.co.zm | Tel:0211 260 269 483</strong>
                </div></div>';
        } else {
            echo '
                <div id="logo">
                <img src="src/images/lso_logo.png" width="321" height="98" />        
                </div>
                <div id="top-nav">
                    <br></br><strong>E-mail: sales@crystaline.co.zm | Tel:0211 260 269 483</strong>
                </div></div>';
        }
        ?> 
    </div>
    <center>
        <div id="sdi-nav">
            <div class="wrap">
                <a  href="entry.php" >Home<img src="links/main3.png" height="25"></a>
                <a href="entry.php" >Payslip Entry<img src="links/entry.png" height="25"></a>
                <a href="add.php" >Add Employee<img src="links/edit.png" height="25"></a>
                <a href="search.php" >Search<img src="links/2.PNG" height="25"></a>
                <a href="loan.php" >Loan<img src="links/edit.PNG" height="25"></a>
                <a href="reporthome.php" >Reports<img src="links/edit.PNG" height="25"></a>
                <a href="logout.php" >Logout</a>
            </div>
        </div>
    </center>

