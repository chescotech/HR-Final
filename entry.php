<?php
include 'include/dbconnection.php';
// Inialize session
session_start();
// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
    header('Location:index.html');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Crystal Pay</title>
    <meta charset="utf-8" http-equiv="Content-Type" content="text/html;/>
              <meta content=" width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- css -->
    <link href="src/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="src/css/style.css" rel="stylesheet" media="screen">
    <link href="src/css/color/default.css" rel="stylesheet" media="screen">
    <script src="src/css/js/modernizr.custom.js"></script>
    <script type="text/javascript" src="src/js/jquery.js"></script>
    <link rel="stylesheet" href="default/default.css" type="text/css" media="screen" />
    <link href="src/css/main.css" rel="stylesheet" type="text/css" />
    <link href="src/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script>
        $(function() {
            $("#datepicker").datepicker();
        });
    </script>
    <style>
        tr {
            height: 40px;
        }
    </style>
</head>
<style>
    .btn_ {
        -webkit-border-radius: 28;
        -moz-border-radius: 28;
        border-radius: 28px;
        font-family: Arial;
        color: #ffffff;
        font-size: 23px;
        background: #ff7500;
        padding: 3px 9px 3px 9px;
        text-decoration: none;
    }

    .btn_:hover {
        background: #ff7500;
        text-decoration: none;
    }
</style>
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
    <?php include 'site_menu/navigation-menu.php'; ?>
    <br>
    <br>
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
        $comission = "0";
        $comp_ID = $_SESSION["username"];

        if (isset($_GET['id'])) {
            $insert = 0;
            $id = $_GET['id'];
            $query = "SELECT * FROM employee WHERE empno = '$empno'";
            include 'include/dbconnection.php';
            $result = mysqli_query($link, $query) or die(mysqli_error($link));
            if (!mysqli_num_rows($result)) {
                $id = 0;
                $msg = "No record found!";
            } else {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $id = $row['id'];
                $empno = $row['empno'];
                $totalpay = ($row['pay'] / 26) * $row['dayswork'];
                $pay = $totalpay;
                $dayswork = $row['dayswork'];
                $otrate = $row['otrate'];
                $othrs = $row['othrs'];
                $allow = $row['allow'];
                $advances = $row['advances'];
                $insurance = $row['insurance'];
                $comission = $row['comission'];
                switch (substr($row['time'], 8, 2)) {
                    case '01':
                        $bmonth1 = "selected";
                        break;
                    case '02':
                        $bmonth2 = "selected";
                        break;
                    case '03':
                        $bmonth3 = "selected";
                        break;
                    case '04':
                        $bmonth4 = "selected";
                        break;
                    case '05':
                        $bmonth5 = "selected";
                        break;
                    case '06':
                        $bmonth6 = "selected";
                        break;
                    case '07':
                        $bmonth7 = "selected";
                        break;
                    case '08':
                        $bmonth8 = "selected";
                        break;
                    case '09':
                        $bmonth9 = "selected";
                        break;
                    case '10':
                        $bmonth10 = "selected";
                        break;
                    case '11':
                        $bmonth11 = "selected";
                        break;
                    case '12':
                        $bmonth12 = "selected";
                        break;
                }
                $bday = substr($row['time'], 8, 2);
                $byear = substr($row['time'], 0, 4);
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
            $id = $_POST['id'];
            $totalpay = ($_POST['pay'] / 26) * $_POST['dayswork'];
            $pay = $totalpay;
            $dayswork = $_POST['dayswork'];
            $otrate = $_POST['otrate'];
            $othrs = $_POST['othrs'];
            $allow = $_POST['allow'];
            $advances = $_POST['advances'];
            $insurance = $_POST['insurance'];
            $comission = $_POST['comission'];

            $date_timestamp = strtotime($_POST['date']);
            $time = date('Y-m-d', $date_timestamp);
        ?>
            <?php
            if (isset($_POST['insert'])) {
                //check if every fields are entered
                if (!$_POST['pay'] | !$_POST['dayswork']) {
                    header("location:entry.php?err=1");
                } else {
                    $id = $_POST['id'];
                    $empno = $_POST['empno'];
                    $totalpay = ($_POST['pay'] / 26) * $_POST['dayswork'];
                    $pay = $totalpay;

                    $dayswork = $_POST['dayswork'];
                    $otrate = $_POST['otrate'];
                    $othrs = $_POST['othrs'];
                    $allow = $_POST['allow'];
                    $advances = $_POST['advances'];
                    $insurance = $_POST['insurance'];
                    $comission = $_POST['comission'];

                    /*
                                                                      $bmonth = $_POST['bmonth'];
                                                                      $bday = $_POST['bday'];
                                                                      $byear = $_POST['byear'];
                                                                     */

                    $date_timestamp = strtotime($_POST['date']);
                    $time = date('Y-m-d', $date_timestamp);

                    $comp_ID = $_SESSION["username"];
                    $gross = ($pay) + ($otrate * $othrs) + $allow + $comission;
                    $napsa = $gross * 0.05;
                    if ($napsa >= 843)
                        $napsa = 843;
                    $napsa_calc = "";
                    if ($napsa >= 255)
                        $napsa_calc = 255;
                    //the tops of each tax band
                    $band1_top = 3000;
                    $band2_top = 3800;
                    $band3_top = 5900;

                    $band1_rate = 0;
                    $band2_rate = 0.25;
                    $band3_rate = 0.30;
                    $band4_rate = 0.35;

                    $starting_income = $income = $gross - $napsa_calc;
                    $band1 = $band2 = $band3 = $band4 = 0;
                    if ($income > $band3_top) {
                        $band4 = ($income - $band3_top) * $band4_rate;
                        $income = $band3_top;
                    }
                    if ($income > $band2_top) {
                        $band3 = ($income - $band2_top) * $band3_rate;
                        $income = $band2_top;
                    }
                    if ($income > $band1_top) {
                        $band2 = ($income - $band1_top) * $band2_rate;
                        $income = $band1_top;
                    }
                    $band1 = $income * $band1_rate;
                    $taxable = $gross - $income;
                    $total_tax_paid = $band1 + $band2 + $band3 + $band4;
                    //echo "Tax paid on $starting_income is 
                    $totdeduct = $total_tax_paid + $advances + $insurance + $napsa;
                    $netpay = $gross - $totdeduct;

                    $query6 = "SELECT * FROM loan where empno = '$empno' ";
                    $result = mysqli_query($link, $query6) or die($query . "<br/><br/>" . mysqli_error($link));
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $loan_amt = $row['loan_amt'];
                    $months = $row['duration'];
                    $loan_deduct = $row['monthly_deduct'];
                    $interest_rate = $row['interest_rate'];
                    $interest = $interest_rate * $loan_amt;
                    $principle = $loan_amt - ($loan_deduct - $interest);
                    if ($insert) {
                        $query = "INSERT INTO employee VALUES ($id,'$empno',$pay,$dayswork,$otrate,$othrs,$allow,$advances,$insurance,'$time','$comission','$comp_ID')";

                        $checkQuery = "SELECT * FROM tax where empno='$empno'";
                        $checkIfEmployeeExsist = mysqli_query($link, $checkQuery) or die($checkQuery . "<br/><br/>" . mysqli_error($link));

                        if (mysqli_num_rows($checkIfEmployeeExsist) == 0) {
                            mysqli_query($link, "INSERT INTO tax (taxable_to_date,tax_paid_to_date,empno,company_id,social)"
                                . "VALUES ('$taxable','$total_tax_paid','$empno','$comp_ID','0') ") or die(mysqli_error($link));
                        } else {
                            mysqli_query($link, "UPDATE tax SET taxable_to_date = taxable_to_date + $taxable , tax_paid_to_date = tax_paid_to_date + $total_tax_paid WHERE empno = '$empno'") or die(mysqli_error($link));
                        }
                        $checkForLeave = "SELECT * FROM leave_days where empno='$empno'";
                        $checkIfEmployeeLeaveExsist = mysqli_query($link, $checkForLeave) or die($checkForLeave . "<br/><br/>" . mysqli_error($link));

                        if (mysqli_num_rows($checkIfEmployeeLeaveExsist) == 0) {
                            mysqli_query($link, "INSERT INTO leave_days (available,empno)"
                                . "VALUES ('2','$empno') ") or die(mysqli_error($link));
                        } else {
                            mysqli_query($link, "UPDATE leave_days SET available = available + 2 WHERE empno = '$empno'") or die(mysqli_error($link));
                        }

                        $query4 = "UPDATE loan  SET duration  = duration - 1 , interest =  $interest, loan_amt = $principle, principle = $principle  WHERE empno = '$empno'";

            ?>
        <?php
                        $msg = "<center><table border='1' width='150' ><td bgcolor='#009933'><center>New record saved!</center></label></table></center>";
                    } else {
                        $query = "UPDATE employee SET id=$id,empno='$empno',pay=$pay,dayswork=$dayswork,otrate=$otrate,othrs=$othrs,allow=$allow,advances=$advances,insurance=$insurance,'time=$time'comission=$comission WHERE id = $id";
                        $msg = "<center><table border='1' width='100' ><td bgcolor='#009933'><center>New Updated!</center></label></table></center>";
                    }
                    include 'include/dbconnection.php';
                    echo '<center>';
                    $result = mysqli_query($link, $query) or die("invalid query" . mysqli_error($link));
                    $result4 = mysqli_query($link, $query4) or die("invali query" . mysqli_error($link));
                    echo '</center>';
                }
            }
        }
        ?>
        <?php
        ?>
        <?php /////////////////////////////////search Area/////////////////////////////////// 
        ?>
        <?php
        if (isset($_POST['key'])) {
            //check if every fields are entered
            if (!$_POST['key']) {
                header("location:entry.php?err=1");
            }
        }
        ?>

    </div>
    <div class="body">
        <div class="entry">
            </center>
            <table border="0" cellspacing="0" class="en">
        </div>
        <div class="entry1">
            <div class="body1">
                <center>
                    <?php
                    if (isset($_GET['err'])) {
                        if ($_GET['err'] == 1)
                            echo '<div class="error_pop"><div class="error"><center>Please input data in fields<a href="entry.php"><h6>Close</h6></a></center></div></div>
                ';
                        else if ($_GET['err'] == 3)
                            echo '<div class="error">Username already exists, please use another one!</div>';
                    }
                    ?>
                    <style type="text/css">
                        .a {
                            width: auto;

                            input[class=id_empno],
                            input.id_empno {
                                background: #22220;
                            }
                        }
                    </style>
                    <fieldset class="a">
                        <legend>Payslip Entry</legend>
                        <?php echo '<strong>' . $msg . '</strong>'; ?><form method="post" action="entry.php" onSubmit="return proceed()" class="form">

                            <table border="0" cellspacing="0" align="center" " class=" form">
                                <input type="hidden" name="id" readonly class="id" value=<?php echo $id; ?> tabindex="12" title="" ;} />

                                <tr>
                                    <td>Employee</td>
                                    <td>
                                        <select name="empno" class="form-control">
                                            <option>--Select employee to add--</option>
                                            <?php
                                            $company_id = $_SESSION['username'];
                                            $query = mysqli_query($link, "select * from emp_info WHERE company_ID = '$company_id' ") or die(mysqli_error($link));
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>

                                                <option value="<?php echo $row['empno']; ?>"> <?php echo $row['fname'] . "  " . $row['lname'] . " - " . $row['position'] . "-" . $row['empno']; ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Basic Rate</td>
                                    <td><input class="form-control" type="text" name="pay" value="<?php echo $pay; ?>" tabindex="12" title="Enter Number" onFocus="if (this.value == '0') {
                                                                                                this.value = '';
                                                                                            }" onBlur="if (this.value == '0')" {this.value='0' ;} /></td>
                                </tr>

                                <tr>
                                    <td>Days worked</td>
                                    <td><input class="form-control" type="text" name="dayswork" value="<?php echo $dayswork; ?>" tabindex="13" title="Enter Number" onFocus="if (this.value == '0') {
                                                                                                this.value = '';
                                                                                            }" onBlur="if (this.value == '0')" {this.value='0' ;} /></td>
                                </tr>
                                <tr>
                                    <td>Overtime Rate/Hour</td>
                                    <td><input class="form-control" type="text" name="otrate" value="<?php echo $otrate; ?>" tabindex="14" title="Enter Number" onFocus="if (this.value == '0') {
                                                                                                this.value = '';
                                                                                            }" onBlur="if (this.value == '0')" {this.value='0' ;} /></td>
                                </tr>
                                <tr>
                                    <td>OT Hours</td>
                                    <td><input class="form-control" type="text" name="othrs" value="<?php echo $othrs; ?>" tabindex="15" title="Enter Number" onFocus="if (this.value == '0') {
                                                                                                this.value = '';
                                                                                            }" onBlur="if (this.value == '0')" {this.value='0' ;} /></td>
                                </tr>
                                <tr>
                                    <td>Allowances</td>
                                    <td><input class="form-control" type="text" name="allow" value="<?php echo $allow; ?>" tabindex="16" title="Enter Number" onFocus="if (this.value == '0') {
                                                                                                this.value = '';
                                                                                            }" onBlur="if (this.value == '0')" {this.value='0' ;} /></td>
                                </tr>
                                <tr>
                                    <td>Comission</td>
                                    <td><input class="form-control" type="text" name="comission" value="<?php echo $comission; ?>" tabindex="16" title="Enter Number" onFocus="if (this.value == '0') {
                                                                                                this.value = '';
                                                                                            }" onBlur="if (this.value == '0')" {this.value='0' ;} /></td>
                                </tr>
                                <tr>
                                    <td>Advances</td>
                                    <td><input class="form-control" type="text" name="advances" value="<?php echo $advances; ?>" tabindex="17" title="Enter Number" onFocus="if (this.value == '0') {
                                                                                                this.value = '';
                                                                                            }" onBlur="if (this.value == '0')" {this.value='0' ;} /></td>
                                </tr>
                                <tr>
                                    <td>Insurance</td>
                                    <td><input class="form-control" type="text" name="insurance" value="<?php echo $insurance; ?>" tabindex="18" title="Enter Number" onFocus="if (this.value == '0') {
                                                                                                this.value = '';
                                                                                            }" onBlur="if (this.value == '0')" {this.value='0' ;} /></td>
                                </tr>
                                <td>Date Period</td>
                                <td align="center"><input id="datepicker" class="form-control" type="text" class="style1" name="date" tabindex="11" /></td>

                                </tr>
                                <tr>
                                    <td colspan="2" align="center">
                                        <br>
                                        <button name="save" id="save" type="submit" class="btn btn-default"><span class="glyphicon glyphicon-saved"></span> Submit
                                        </button>
                                    </td>
                                    </td>
                                </tr>
                            </table>
                </center>
                <input type="hidden" name="insert" value="<?php echo $insert; ?>" />
                </form>
            </div>
            <div class="foot1"></div>
        </div>
    </div>
    <div class="footer"></div>
    </div>
</body>

</html>
<br></br>
<?php include 'site_menu/footer.php'; ?>