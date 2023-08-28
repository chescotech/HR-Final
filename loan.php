
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Crystal Pay</title>
        <meta charset="utf-8" http-equiv="Content-Type" content="text/html;/>
              <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <!-- css -->
            <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
                <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
                <link href="src/css/bootstrap.min.css" rel="stylesheet" media="screen">
                    <link href="src/css/style.css" rel="stylesheet" media="screen">
                        <link href="src/css/color/default.css" rel="stylesheet" media="screen">
                            <script type="text/javascript" src="src/js/jquery.js"></script>
                            <link href="src/css/main.css" rel="stylesheet"   type="text/css"/>
                            <link href="src/css/bootstrap.css" rel="stylesheet">
                                <link rel="stylesheet" href="src/css/nivo-slider.css" type="text/css" media="screen" />
                                <script type="text/javascript" src="src/js/jquery.nivo.slider.pack.js"></script>
                                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

                                    <style>
                                        tr {
                                            height:40px;
                                        }
                                    </style> 
                                    </head>
                                    <script type="text/javascript">
                                        function proceed() {
                                            return confirm("Save this entry?");
                                        }
                                        function startTime() {
                                            var today = new Date();
                                            var h = today.getHours();
                                            var m = today.getMinutes();
                                            var s = today.getSeconds();
                                            // add a zero in front of numbers<10
                                            m = checkTime(m);
                                            s = checkTime(s);
                                            document.getElementById('txt').innerHTML = h + ":" + m + ":" + s;
                                            t = setTimeout('startTime()', 500);
                                        }
                                        function checkTime(i) {
                                            if (i < 10) {
                                                i = "0" + i;
                                            }
                                            return i;
                                        }
                                    </script>
                                    <body>
                                        <?php
                                        include 'include/dbconnection.php';
                                        session_start();
                                        include 'site_menu/navigation-menu.php';
                                        ?>

                                        <div class="profile">
                                            <?php
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
                                            $loan_amt = "";
                                            $loan_deduct = "";
                                            $months = "";
                                            $LOAN_NO = "";
                                            $comp_ID = $_SESSION["username"];
                                            $company_id = $comp_ID;
                                            $interest_rate = "";

                                            if (isset($_GET['empno'])) {
                                                $insert = 0;
                                                $id = $_GET['empno'];
                                                $query = "SELECT * FROM loan WHERE empno = $empno";                                                
                                                $result = mysql_query($query, $link) or die(mysql_error());
                                                if (!mysql_num_rows($result)) {
                                                    $id = 0;
                                                    $msg = "No record found!";
                                                } else {
                                                    $row = mysql_fetch_array($result, MYSQL_ASSOC);
                                                    $id = $row['LOAN_NO'];
                                                    $empno = $row['empno'];
                                                    $loan_amt = $row['loan_amt'];
                                                    $loan_deduct = $row['monthly_deduct'];
                                                    $months = $row['duration'];
                                                    $interest = $row['interest'];
                                                    $principle = $row['principle'];
                                                    $interest_rate = $row['interest_rate'];
                                                }
                                            }
                                            ?>
                                            <?php
                                            $msg = "";

                                            if (isset($_POST['insert'])) {
                                                if ($_POST['insert'])
                                                    $insert = 1;
                                                else
                                                    $insert = 0;
                                                //$LOAN_NO = $_POST['LOAN_NO'];
                                                $empno = $_POST['empno'];
                                                $loan_amt = $_POST['loan_amt'];
                                                $loan_deduct = $_POST['loan_deduct'];
                                                $months = $_POST['months'];
                                                $interest_rate = $_POST['interest_rate'];
                                                ?>
                                                <?php
                                              
                                                if (isset($_POST['insert'])) {
                                                    //check if every fields are entered
                                                    if (!$_POST['loan_amt']) {
                                                        header("location:loan.php?err=1");
                                                    } else if (!$_POST['empno']) {
                                                        header("location:loan.php?err=2");
                                                    } else {
                                                        // $LOAN_NO = $_POST['LOAN_NO'];
                                                        $empno = $_POST['empno'];
                                                        $LOAN_NO = '';
                                                        $empno = $_POST['empno'];
                                                        $loan_amt = $_POST['loan_amt'];
                                                        $loan_deduct = $_POST['loan_deduct'];
                                                        $months = $_POST['months'];
                                                        $interest_rate = $_POST['interest_rate'];
                                                        $interest = $interest_rate * $loan_amt;
                                                        $principle = $loan_amt - ($loan_deduct - $interest);

                                                        if ($insert) {
                                                            $query = "INSERT INTO loan VALUES ('$LOAN_NO','$empno','$loan_amt','$loan_deduct','$months','$company_id','$principle','$interest_rate','$interest')";
                                                            ?>
                                                            <?php
                                                            $msg = "<center><table border='1' width='150' ><td bgcolor='#009933'><center>New record saved!</center></label></table></center>";
                                                        } else {
                                                            $query = "UPDATE loan SET empno=$empno,loan_amt=$loan_amt,loan_deduct=$loan_deduct,months=$months WHERE LOAN_NO = $LOAN_NO";
                                                            $msg = "<center><table border='1' width='100' ><td bgcolor='#009933'><center>New Updated!</center></label></table></center>";
                                                        }
                                                       
                                                        echo '<center>';
                                                        $result = mysql_query($query, $link) or die("invalid query" . mysql_error());
                                                        echo '</center>';
                                                    }
                                                }
                                            }
                                            ?>  
                                            <?php /////////////////////////////////search Area/////////////////////////////////// ?>
                                            <?php
                                            if (isset($_POST['key'])) {
                                                //check if every fields are entered
                                                if (!$_POST['key']) {
                                                    header("location:loan.php?err=1");
                                                }
                                            }
                                            ?>
                                            <br>
                                                <br>
                                                    <form method="post" action="loan.php">
                                                        <table cellpadding="" align="center" >
                                                            <tr>
                                                                <td><input class="form-control"  type="text" name="key" value="Search Employee ID" id="key" tabindex="1" onFocus="if (this.value == 'Search Employee ID') {
                                                                            this.value = '';
                                                                        }" onBlur="if (this.value == '') {
                                                                                    this.value = 'Search Employee ID';
                                                                                }" class="search">
                                                                        <select  hidden="hidden" name="field" id="field" style="background-color="#006633" border="0" class="select">
                                                                            <option value="empno">

                                                                            </option>

                                                                        </select>
                                                                    </input></td>
                                                                <td>

                                                                    <button type="submit"  name="save" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                    </form>
                                                    </table>
                                                    <center><?php
                                                        if (isset($_GET['err']))
                                                            if ($_GET['err'] == 2)
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
                                                                            if (is_numeric($key))
                                                                                $query = "SELECT * FROM emp_info WHERE empno = $key";
                                                                            else
                                                                                $query = "SELECT * FROM emp_info WHERE UPPER($field) like '$key%'";
                                                                        else
                                                                            $query = "SELECT * FROM loan";
                                                                   
                                                                    $result = mysql_query($query, $link) or die(mysql_error());
                                                                    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                                                                        echo '<label>';
                                                                        echo '<tr><tr><td bordercolor="#FFFFFF">Id no<td>:</td><td width="20"></td></td><td>' . $row['empno'] . '</td></tr>';
                                                                        echo '<td>Last name<td>:</td><td></td></td><td>' . $row['lname'] . '</td>';
                                                                        echo '<tr><td>First name<td>:</td><td></td></td><td>' . $row['fname'] . '</td></tr>';
                                                                        echo '<tr><td>Middle I<td>:</td><td></td></td><td>' . $row['init'] . '</td></tr>';
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
                                                                if (isset($_GET['err'])) {
                                                                    if ($_GET['err'] == 1)
                                                                        echo '<div class="error_pop"><div class="error"><center>Please input data in fields<a href="loan.php"><h6>Close</h6></a></center></div></div>
		';
                                                                    else if ($_GET['err'] == 3)
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
                                                                    <?php echo '<strong>' . $msg . '</strong>'; ?>
                                                                    <form method="post" action="loan.php" onSubmit="return proceed()" class="form">
                                                                        <table border="0" cellspacing="0" align="center"  " class="form" >
                                                                            <?php
                                                                            $result = "";
                                                                            if (isset($_POST["field"])) {
                                                                                $key = strtoupper($_POST["key"]);
                                                                                $field = $_POST["field"];
                                                                                if (!empty($_POST["key"]))
                                                                                    if ($field == "empno")
                                                                                        if (is_numeric($key))
                                                                                            $query = "SELECT * FROM emp_info WHERE empno = $key";
                                                                                        else
                                                                                            $query = "SELECT * FROM emp_info WHERE UPPER($field) like '$key%'";
                                                                                    else
                                                                                        $query = "SELECT * FROM emp_info";
                                                                                
                                                                                $result = mysql_query($query, $link) or die(mysql_error());
                                                                                while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                                                                                    echo ' <tr>';
                                                                                    echo '<td width="174">Employee ID</td>';
                                                                                    echo '<td>';
                                                                                    echo ' ';
                                                                                    echo '<input class="form-control" type="text" name="empno" class="id_empno" value=' . $row['empno'] . ' readonly>';
                                                                                    echo '</td>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <tr>
                                                                                <td>Loan Amount</td>
                                                                                <td><input type="text" class="form-control" name="loan_amt" value="<?php echo $loan_amt; ?>" tabindex="14" title="Enter Number"onFocus="if (this.value == '0') {
                                                                                            this.value = '';
                                                                                        }" onBlur="if (this.value == '0')" {this.value = '0';} /></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Months</td>
                                                                                <td><input type="text" class="form-control" name="months" value="<?php echo $months; ?>" tabindex="16" title="Enter Number"onFocus="if (this.value == '0') {
                                                                                            this.value = '';
                                                                                        }" onBlur="if (this.value == '0')" {this.value = '0';} /></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Monthly Deduction</td>
                                                                                <td><input type="text" class="form-control" name="loan_deduct" value="<?php echo $loan_deduct; ?>" tabindex="16" title="Enter Number"onFocus="if (this.value == '0') {
                                                                                            this.value = '';
                                                                                        }" onBlur="if (this.value == '0')" {this.value = '0';} /></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Interest Rate</td>
                                                                                <td><input type="text" class="form-control" name="interest_rate" value="<?php echo $interest_rate; ?>"  title="Enter Number"onFocus="if (this.value == '0') {
                                                                                            this.value = '';
                                                                                        }" onBlur="if (this.value == '0')" {this.value = '0';} /></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" align="center">
                                                                                    <button type="submit"  name="save" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-save"></span> Save
                                                                                    </button>
                                                                                    <button type="reset"  name="save" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span>Reset
                                                                                    </button></td>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <input type="hidden" name="insert" value="<?php echo $insert; ?>" />
                                                                    </form>
                                                            </div>
                                                            <div class="foot1"></div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                        Loan Calculator<br>
                                                            <script language="JavaScript">
                                                                <!--
                                                            function showpay() {
                                                                    if ((document.calc.loan.value == null || document.calc.loan.value.length == 0) ||
                                                                            (document.calc.months.value == null || document.calc.months.value.length == 0)
                                                                            ||
                                                                            (document.calc.rate.value == null || document.calc.rate.value.length == 0))
                                                                    {
                                                                        document.calc.pay.value = "Incomplete data";
                                                                    }
                                                                    else
                                                                    {
                                                                        var princ = document.calc.loan.value;
                                                                        var term = document.calc.months.value;
                                                                        var intr = document.calc.rate.value / 1200;
                                                                        document.calc.pay.value = princ * intr / (1 - (Math.pow(1 / (1 + intr), term)));
                                                                    }
                                                                    // payment = principle * monthly interest/(1 - (1/(1+MonthlyInterest)*Months))
                                                                }
                                                                // -->
                                                            </script>
                                                            <p>
                                                                <center>
                                                                    <form name=calc method=POST>
                                                                        <table width="60%" border="1">
                                                                            <tr><th  width=50%><font color=blue>Description</font></th>
                                                                                <th  width=50%><font color=blue>Amount</font></th></tr>
                                                                            <tr><td >Loan Amount</td><td  align=right><input  class="form-control" type=text name=loan size=10></td></tr>
                                                                            <tr><td >Loan Length in Months</td><td align=right>
                                                                                    <input class="form-control" type=text name=months size=10></td></tr>
                                                                            <tr><td >Interest Rate</td><td  align=right><input class="form-control"
                                                                                                                               type=text name=rate
                                                                                                                               size=10></td></tr>
                                                                            <tr><td >Monthly Payment</td>
                                                                                <td align=right>
                                                                                    <input class="form-control" type=text name=pay size=10></td></tr>
                                                                            <tr><td  align=center>
                                                                                    <button  onClick='showpay()' type="button" class="btn btn-default"><span class="glyphicon glyphicon-send"></span> Calculate
                                                                                    </button>    
                                                                                </td>
                                                                                <td  align=center> <button type="reset"  name="save" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span>Reset
                                                                                    </button></td></tr>
                                                                        </table>
                                                                    </form>
                                                                    <font size=1>Enter only numeric values (no commas), using decimal points
                                                                        where needed.<br>
                                                                            Non-numeric values will cause errors.</font>
                                                                </center>
                                                                <div class="footer"></div>
                                                                </div>
                                                                </body>
                                                                <br>
                                                                    <?php include 'site_menu/footer.php'; ?> 
                                                                    </html>

