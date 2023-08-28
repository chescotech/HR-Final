<?php
include 'include/dbconnection.php';
// Inialize session
session_start();
// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
    header('Location:index.html');
}
//echo $_SESSION['username'];
$comp_ID = $_SESSION["username"]; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Crystal Pay</title>
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
                            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                                <link rel="stylesheet" href="/resources/demos/style.css">
                                    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                                    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                                        <script>
                                            $(function () {
                                                $("#datepicker").datepicker();
                                                $("#datepicker_").datepicker();
                                                $("#birthday_picker").datepicker();
                                            });
                                        </script>
                                        <style>
                                            tr {
                                                height:40px;
                                            }
                                        </style>  
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
                                        </head>

                                        <body>
                                            <?php include 'site_menu/navigation-menu.php'; ?>

                                            <?php
// End of insert/update if there's any	 
//Initialize input fields
                                            $insert = 1;
                                            $id = 0;
                                            $empno = 0;
                                            $photo = 0;
                                            $lname = "";
                                            $fname = "";
                                            $init = "";
                                            $gendermale = "checked";
                                            $genderfemale = "";
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
                                            $dept = "";
                                            $dept0 = "selected";
                                            $dept1 = "";
                                            $dept2 = "";
                                            $dept3 = "";
                                            $dept4 = "";
                                            $dept5 = "";
                                            $dept6 = "";
                                            $position = "";
                                            $account = "";
                                            $phone = "";
                                            $address = "";
                                            $email = "";
                                            $bank = "";
                                            $date_joined = "";
                                            $date_left = "";
                                            $employee_grade = "";
                                            $marital_status = "";
                                            $leave_days = "";
                                            $payment_method = "";
                                            $company_id = $comp_ID;
//End of input field initialization

                                            $sql = "SELECT * FROM prefix WHERE company_id= '$company_id'";
                                            $resource = mysql_query($sql) or die("username heck error");
                                            $row = mysql_fetch_array($resource, MYSQL_ASSOC);
                                            $prefix = $row['prefix'];
// If update then retrieve record
                                            if (isset($_GET['empno'])) {
                                                $insert = 0;
                                                $empno = $_GET['empno'];
                                                $query = "SELECT * FROM emp_info WHERE empno = $empno";

                                                $result = mysql_query($query, $link) or die(mysql_error());
                                                if (!mysql_num_rows($result)) {
                                                    $empno = 0;
                                                    $msg = "No record found!";
                                                } else {
                                                    $row = mysql_fetch_array($result, MYSQL_ASSOC);
                                                    $id = $row['id'];
                                                    $empno = $row['empno'];
                                                    $photo = $row['photo'];
                                                    $lname = $row['lname'];
                                                    $fname = $row['fname'];
                                                    $init = $row['init'];
                                                    $phone = $row['phone'];
                                                    $email = $row['email'];
                                                    $address = $row['address'];
                                                    $bank = $row['bank'];
                                                    $account = $row['account'];
                                                    $date_joined = $row['date_joined'];
                                                    $date_left = $row['date_left'];
                                                    $employee_grade = $row['grade'];
                                                    $marital_status = $row['marital_status'];
                                                    $leave_days = $row['leave_days'];
                                                    $payment_method = $row['payment_method'];
                                                    if ($row['gender'] == 'Male') {
                                                        $gendermale = "checked";
                                                        $genderfemale = "";
                                                    } else {
                                                        $gendermale = "";
                                                        $genderfemale = "checked";
                                                    }
                                                    switch (substr($row['bdate'], 8, 2)) {
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
                                                    $bday = substr($row['bdate'], 8, 2);
                                                    $byear = substr($row['bdate'], 0, 4);
                                                    $position = $row['position'];
                                                }
                                            }
                                            ?>
                                            <form method="post" action="add.php" onSubmit="return proceed()">
                                                <?php
                                                $msg = "";
//Save record (Insert/Update)
                                                if (isset($_POST['insert'])) {
                                                    if ($_POST['insert'])
                                                        $insert = 1;
                                                    else
                                                        $insert = 0;
                                                    // $id= $_POST['id'];
                                                    $empno = $prefix . $_POST['empno'];
//$photo = $_POST['photo'];
                                                    $lname = $_POST['lname'];
                                                    $fname = $_POST['fname'];
                                                    $init = $_POST['init'];
                                                    $gender = $_POST['gender'];
                                                    $bday = $_POST['birthday'];
                                                    $bdate = $bday;
                                                    $dept = $_POST['department'];
                                                    $position = $_POST['position'];
                                                    $phone = $_POST['phone'];
                                                    $email = $_POST['email'];
                                                    $address = $_POST['address'];
                                                    $bank = $_POST['bank'];
                                                    $account = $_POST['account'];
                                                    $date_joined = $_POST['date_joined'];
                                                    $date_left = $_POST['date_left'];
                                                    $employee_grade = $_POST['employee_grade'];
                                                    $marital_status = $_POST['marital_status'];
                                                    //$leave_days = $_POST['leave_days'];
                                                    $payment_method = $_POST['payment_method'];
                                                    
                                                    
                                                    ?>
                                                    <?php
                                                    $sql = "SELECT empno FROM emp_info WHERE  empno='" . $empno . "'";
                                                    $resource = mysql_query($sql) or die("username check error");
                                                    if (isset($_POST['insert'])) {
                                                        //check if every fields are entered
                                                        if (!$_POST['empno'] | !$_POST['lname'] | !$_POST['fname'] | !$_POST['init'] | !$_POST['gender'] | !$_POST['position'] | !$_POST['phone'] | !$_POST['address'] | !$_POST['email'] | !$_POST['bank'] | !$_POST['account'] | !$_POST['date_joined'] | !$_POST['date_left'] | !$_POST['employee_grade'] | !$_POST['marital_status']) {
                                                            header("location:add.php?err=1");
                                                        } else {
                                                            $empno = $prefix . $_POST['empno'];
                                                            $lname = $_POST['lname'];
                                                            $fname = $_POST['fname'];
                                                            $init = $_POST['init'];
                                                            $gender = $_POST['gender'];
                                                            $bday = $_POST['birthday'];
                                                            $position = $_POST['position'];
                                                            $phone = $_POST['phone'];
                                                            $email = $_POST['email'];
                                                            $address = $_POST['address'];
                                                            $bank = $_POST['bank'];
                                                            $account = $_POST['account'];
                                                            $date_joined_timestamp = strtotime($_POST['date_joined']);
                                                            $date_joined = date('Y-m-d', $date_joined_timestamp);
                                                            $date_left_timestamp = strtotime($_POST['date_left']);
                                                            $date_left = date('Y-m-d', $date_joined_timestamp);
                                                            $employee_grade = $_POST['employee_grade'];
                                                            $marital_status = $_POST['marital_status'];
                                                            //$leave_days = $_POST['leave_days'];
                                                            $payment_method = $_POST['payment_method'];
                                                            $timestamp = strtotime($_POST['birthday']);
                                                            $new_date = date('d-m-Y', $timestamp);
                                                            $bdate = date('d-m-Y', $timestamp);
                                                            $check = mysql_num_rows($resource);
                                                            if ($check == 1) {
                                                                header("location:add.php?err=3");
                                                            } else {
                                                                $password= md5("ctl@2020");
                                                                $query = "INSERT INTO emp_info VALUES ($id,'$empno','$photo','$lname','$fname','$init','$gender','$bdate','$dept','$position','$phone','$address','$email','$bank','$account','$date_joined','$date_left','$employee_grade','$marital_status','$payment_method','$leave_days','$company_id','$password');";
                                                                ?>
                                                                <?php
                                                                $msg = "<center><table border='1' width='200'><td  bgcolor='FFFFF'><center>New record saved!</center></label></table>
</center><br/>";
                                                            }

                                                            echo '<center>';
                                                            $result = mysql_query($query, $link) or die("invalid query" . mysql_error());
                                                            echo '</center>';
                                                        }
                                                    }
                                                }
                                                ?>  
                                                <p>
                                                    <?php echo '<strong>' . $msg . '</strong>'; ?>
                                                </p>
                                                </br>
                                                <?php
                                                if (isset($_GET['err'])) {
                                                    if ($_GET['err'] == 1)
                                                        echo '<div class="err"><center>Please input data in fields.</center></br><a href="add.php"><h6>Close</h6></a></div>';
                                                    else if ($_GET['err'] == 2)
                                                        echo '<div class="error">Passwords didn\'t match</div>';
                                                    else if ($_GET['err'] == 3)
                                                        echo '<div class="err"><center>Employee ID already exists, please use another one!<a href="add.php"><h6>Close</h6></a><center></div>';
                                                }
                                                ?>		  
                                                <div class="addform"></div>
                                                <div class="head1">
                                                    <div class="new">
                                                        Add New Record</div>
                                                </div>
                                                <style type="text/css">
                                                    .a{
                                                        position: center;
                                                        input[class=id_empno], input.id_empno{
                                                            background:#CCC;}
                                                    }
                                                </style>
                                                <center>	  
                                                    <fieldset class="a" > <legend>Add New Employee</legend>
                                                        <table  cellspacing="10"> 
                                                            <tr>
                                                                <td width="174" class="">ID:</td>
                                                                <td width="238" align="center"><input class="form-control" type="text" name="empno" class="style2" value="<?php echo $empno; ?>" tabindex="1" onFocus="if (this.value == '0') {
                                                                            this.value = '';
                                                                        }" onBlur="if (this.value == '0')" {this.value = '0';} readonly="readonly"></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="174">Employee ID</td>
                                                                <td width="238" align="center"><input class="form-control" type="text" name="empno" class="style1" value="<?php echo $empno; ?>" tabindex="1" onFocus="if (this.value == '0') {
                                                                            this.value = '';
                                                                        }" onBlur="if (this.value == '0')" {this.value = '0';}></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Lastname</td>
                                                                <td align="center"><input class="form-control" type="text" class="style1" name="lname" id="lname" value="<?php echo $lname; ?>" tabindex="2"/></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Firstname</td>
                                                                <td align="center"><input class="form-control" type="text" class="style1" name="fname" value="<?php echo $fname; ?>" tabindex="3"/></td></tr>
                                                            <tr>
                                                                <td>Initial</td>
                                                                <td align="center"><input class="form-control" name="init" class="style1" type="text" value="<?php echo $init; ?>" tabindex="4" size="1" maxlength="1"/></td>
                                                            </tr>
                                                            <tr>
                                                                <td> Gender</td>
                                                                <td>&nbsp;&nbsp;&nbsp; <input  type="radio" name="gender" value="Male" <?php echo $gendermale; ?> tabindex="5"/>Male
                                                                    <input type="radio" name="gender" value="Female" <?php echo $genderfemale; ?> tabindex="6"/>Female</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Birthday</td>
                                                                <td align="center"><input id="birthday_picker" class="form-control" type="text" class="style1" name="birthday" value="<?php echo $position; ?>"tabindex="11"/></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Department</td>
                                                                <td align="center">
                                                                    <select name="department" class="form-control">

                                                                        <option>--Select Department--</option>

                                                                        <?php
                                                                        $query = mysql_query("select * from department ") or die(mysql_error());
                                                                        while ($row = mysql_fetch_array($query)) {
                                                                            ?>

                                                                            <option value="<?php echo $row['department']; ?>"> <?php echo $row['department']; ?></option>

                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Position</td>
                                                                <td align="center"><input class="form-control" type="text" class="style1" name="position" value="<?php echo $position; ?>"tabindex="11"/></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Phone</td>
                                                                <td align="center"><input class="form-control" type="text" class="style1" name="phone" value="<?php echo $phone; ?>"tabindex="11"/></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Email</td>
                                                                <td align="center"><input class="form-control" type="text" class="style1" name="email" value="<?php echo $email; ?>"tabindex="11"/></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Address</td>
                                                                <td align="center"><input class="form-control" type="text" class="style1" name="address" value="<?php echo $address; ?>"tabindex="11"/></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Bank</td>
                                                                <td align="center"><input  class="form-control" type="text" class="style1" name="bank" value="<?php echo $bank; ?>"tabindex="11"/></td>
                                                            </tr><tr>
                                                                <td>Account Number</td>
                                                                <td align="center"><input class="form-control" type="text" class="style1" name="account" value="<?php echo $account; ?>"tabindex="11"/></td>
                                                            </tr><tr>
                                                                <td>Date Joined</td>
                                                                <td align="center"><input id="datepicker" class="form-control" type="text" class="style1" name="date_joined" value="<?php echo $date_joined; ?>"tabindex="11"/></td>
                                                            </tr><tr>
                                                                <td>Date Left</td>
                                                                <td align="center"><input id="datepicker_" class="form-control" type="text" class="style1" name="date_left" value="<?php echo $date_left; ?>"tabindex="11"/></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Employee Grade</td>
                                                                <td align="center">

                                                                    <select name="employee_grade" class="form-control">

                                                                        <option>--Select Grade--</option>

                                                                        <?php
                                                                        $query = mysql_query("SELECT grade FROM grade where company_ID = '$comp_ID' ") or die(mysql_error());
                                                                        while ($row = mysql_fetch_array($query)) {
                                                                            ?>

                                                                            <option value="<?php echo $row['grade']; ?>"> <?php echo $row['grade']; ?></option>

                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>                                                            
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Marital Status</td>
                                                                <td align="center">

                                                                    <select name="marital_status" class="form-control">

                                                                        <option>--Select Marital Status--</option>
                                                                        <option value="Single">Single</option>
                                                                        <option value="Married">Married</option>
                                                                    </select>                                                            
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>Payment Method</td>
                                                                <td align="center"><input class="form-control" type="text" class="style1" name="payment_method" value="<?php echo $payment_method; ?>"tabindex="11"/></td>
                                                            </tr>
                                                            <td colspan="" align="center">

                                                                </tr>
                                                        </table>
                                                        <input type="hidden" name="insert" value="<?php echo $insert; ?>" />
                                                    </fieldset>
                                                    <br>
                                                        <center>                                              <button name="save" id="save" type="submit" class="btn btn-default"><span class="glyphicon glyphicon-saved"></span> Submit
                                                            </button></td>                                                 <button name="save" id="save" type="reset" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Reset
                                                            </button></td></center>
                                                        </form>
                                                </center>

                                        </body>

                                        </html>
                                        <br></br>
                                        <?php include 'site_menu/footer.php'; ?> 