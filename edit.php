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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
                            <link rel="stylesheet" href="src/css/nivo-slider.css" type="text/css" media="screen" />
                            <script type="text/javascript" src="src/js/jquery.nivo.slider.pack.js"></script>
                            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

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
                                    <?php include 'site_menu/navigation-menu.php'; ?>

                                    <div class="profile">
                                        Edit Entry Form

                                        <?php
// End of insert/update if there's any	 
//Initialize input fields
                                        $insert = 1;
                                        $id = 0;
                                        $empno = "";
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

                                        $bday = "";
                                        $byear = "";

                                        $dept = "";
                                        $dept0 = "selected";
                                        $dept1 = "";
                                        $dept2 = "";
                                        $dept3 = "";
                                        $dept4 = "";
                                        $dept5 = "";
                                        $dept6 = "";

                                        $position = "";
                                        $pay = 0;
                                        $dayswork = 0;
                                        $otrate = 0;
                                        $othrs = 0;
                                        $allow = 0;
                                        $advances = 0;
                                        $insurance = 0;
//End of input field initialization
// If update then retrieve record
                                        if (isset($_GET['id'])) {
                                            $insert = 0;
                                            $id = $_GET['id'];
                                            $query = "SELECT * FROM employee WHERE id = $id";
                                            include 'include/dbconnection.php';
                                            $result = mysql_query($query, $link) or die(mysql_error());
                                            if (!mysql_num_rows($result)) {
                                                $id = 0;
                                                $msg = "No record found!";
                                            } else {
                                                $row = mysql_fetch_array($result, MYSQL_ASSOC);
                                                $id = $row['id'];
                                                $empno = $row['empno'];

                                                $pay = $row['pay'];
                                                $dayswork = $row['dayswork'];
                                                $otrate = $row['otrate'];
                                                $othrs = $row['othrs'];
                                                $allow = $row['allow'];
                                                $advances = $row['advances'];
                                                $insurance = $row['insurance'];
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
                                            $empno = $_POST['empno'];
                                            $pay = $_POST['pay'];
                                            $dayswork = $_POST['dayswork'];
                                            $otrate = $_POST['otrate'];
                                            $othrs = $_POST['othrs'];
                                            $allow = $_POST['allow'];
                                            $advances = $_POST['advances'];
                                            $insurance = $_POST['insurance'];
                                            ?>

                                            <?php
                                            if ($insert) {

                                                $query = "INSERT INTO employee VALUES ($id,'$empno',$pay,$dayswork,$otrate,$othrs,$allow,$advances,$insurance)";

                                                $msg = "<center><table border='1' width='431'  ><td bgcolor='#009933'><center>New record saved!</center></label></table></center>";
                                            } else {
                                                $query = "UPDATE employee SET  id=$id,empno='$empno',pay=$pay,dayswork=$dayswork,otrate=$otrate,othrs=$othrs,allow=$allow,advances=$advances,insurance=$insurance WHERE id = $id";

                                                $msg = "<center><table border='1' width='300'  ><td bgcolor='#009933'><center>Record updated!</center></table></center>";
                                            }
                                            include 'include/dbconnection.php';



                                            echo '<center>';
                                            $result = mysql_query($query, $link) or die("invalid query" . mysql_error());
                                            echo '</center>';
                                        }
                                        ?>  <form method="post" action="edit.php" onSubmit="return proceed()">
                                            <style type="text/css">
                                                .a{
                                                    width:auto;


                                                    input[class=id_empno], input.id_empno{
                                                        background:#CCC;}
                                                }
                                            </style>
                                            <fieldset class="a"> <legend>Edit Entry</legend>
                                                <table border="0" width="auto" align="center" >
                                                    <tr>
                                                        <tr><td colspan="2"><?php echo '<strong>' . $msg . '</strong>'; ?></td></tr>
                                                        <td width="174">ID</td>
                                                        <td width="238"><input class="form-control" type="text" name="id" class="id_empno" value="<?php echo $id; ?>" tabindex="1" readonly="readonly" /></td>
                                                        <tr>
                                                            <td width="174">Employee Number</td>
                                                            <td width="238"><input class="form-control" type="text" name="empno" class="id_empno" value="<?php echo $empno; ?>" tabindex="1" readonly="readonly" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Basic Pay</td>
                                                            <td><input type="text" class="form-control" name="pay" value="<?php echo $pay; ?>" tabindex="12" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Days worked</td>
                                                            <td><input type="text" class="form-control" name="dayswork" value="<?php echo $dayswork; ?>" tabindex="13"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Overtime Rate/Hour</td>
                                                            <td><input type="text" class="form-control" name="otrate" value="<?php echo $otrate; ?>" tabindex="14"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>OT Hours</td>
                                                            <td><input type="text" class="form-control" name="othrs" value="<?php echo $othrs; ?>" tabindex="15"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Allowances</td>
                                                            <td><input type="text" class="form-control" name="allow" value="<?php echo $allow; ?>" tabindex="16"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Advances</td>
                                                            <td><input type="text" class="form-control" name="advances" value="<?php echo $advances; ?>" tabindex="17"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Insurance</td>
                                                            <td><input type="text" class="form-control" name="insurance" value="<?php echo $insurance; ?>" tabindex="18"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" align="center">
                                                                <br>
                                                                    <button type="submit"  name="save" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-save"></span>Save
                                                                    </button>                                                               
                                                                    <button type="reset"  name="save" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span>Reset
                                                                    </button></td>
                                                        </tr>
                                                </table>
                                                <input type="hidden" name="insert" value="<?php echo $insert; ?>" />
                                        </form>
                                    </div>
                                </body>
                                <br></br>
                                <?php include 'site_menu/footer.php'; ?> 
                                </html>
