<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Log Attendance</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
</head>
<style type="text/css">
    span.label {
        font-weight: bold;
        color: #000;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showLocation);
        } else {
            $('#location').html('Geolocation is not supported by this browser.');
        }
    });

    function showLocation(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        $.ajax({
            type: 'POST',
            url: 'getLocation.php',
            data: 'latitude=' + latitude + '&longitude=' + longitude,
            success: function(msg) {
                $("#computing").html('Computing Location ....');
                if (msg) {
                    document.getElementById('location').setAttribute('value', msg);
                    $("#computing").html('Done ....');
                } else {
                    $("#location").html('Not Available');
                }
            }
        });
    }
</script>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Attendance.php';
        $AttendanceObject = new Attendance();
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        date_default_timezone_set('Africa/Lusaka');
        $company_id = $_SESSION['company_ID'];
        $empno = $_SESSION['employee_id'];

        // Check if user is logged in or not and do stuff
        $today = date("Y/m/d");
        $log_q = mysql_query("SELECT * FROM attendance_logs WHERE empno = '$empno' AND log_date = '$today' 
                 ") or die(mysql_error());
        if (mysql_num_rows($log_q) > 0) {
            while ($log_r = mysql_fetch_array($log_q)) {
                $login_time = $log_r['login_time'];
                $logout_time = $log_r['logout_time'];
                if ($login_time != '' && $logout_time == "") {
                    $log_msg = "<strong style='color: green'><b> You're checked in. Remember to checkout </b></strong>";
                    $checkin_btn = '<span  class="disabled btn btn-primary">Checked In</span>';
                    $checkout_btn = '<button name="check-out" type="submit" class="btn btn-danger">Check Out</button>';
                } elseif ($logout_time != "") {
                    $log_msg = "<strong style='color: orange'><b> You've checked out for the day. </b></strong>";
                    $checkin_btn = '<span  class="disabled btn btn-primary">Checked In</span>';
                    $checkout_btn = '<span class="disabled btn btn-danger">Check Out</span>';
                } else {
                    $checkin_btn = '<span  class="disabled btn btn-primary">Checked In</span>';
                    $checkout_btn = '<span class="disabled btn btn-danger">Check Out</span>';
                }
            }
        } else {
            $checkin_btn = '<button name="check-in" type="submit" class="btn btn-success">Check In</button>';
            $checkout_btn = '<span class="disabled btn btn-danger">Check Out</span>';
            $log_msg = "Log your Attendance Here";
        }
        // return var_dump($login_time, $logout_time);

        if (isset($_POST['check-in'])) {
            $company_id = $_SESSION['company_ID'];

            $message = "";
            $dt = new DateTime();
            $log_date = date("Y/m/d");
            $company_id = $_SESSION['company_ID'];
            $login_time = $dt->format('Y-m-d H:i:s');
            $logout_time = "";

            $AttendanceObject->checkInUser($empno, $company_id, $log_date, $login_time, $logout_time);
            $message = "You have checked in sucessfully, please remember to check out !!";
            echo "<script> window.location='log-attendance' </script>";
        } else if (isset($_POST['check-out'])) {
            $message = "";
            $dt = new DateTime();
            $empno = $_SESSION['employee_id'];
            $company_id = $_SESSION['company_ID'];
            $log_date = date("Y/m/d");
            $logout_time = $dt->format('Y-m-d H:i:s');
            $AttendanceObject->checkOutUser($empno, $company_id, $logout_time, $log_date);
            $message = "You have checked out sucessfully !!";
            echo "<script> window.location='log-attendance' </script>";
        }
        ?>

        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                <?php

                                $result = mysql_query("SELECT * FROM emp_info where empno='$employeeId' ") or die(mysql_error());
                                $row = mysql_fetch_array($result);
                                $position = $row['position'];
                                if ($row["photo"] != "") {
                                    $picname = $row["photo"];
                                } else {
                                    $picname = 'default.png';
                                }
                                $emp_name  = $row['fname'] . "-" . $row['lname'];
                                echo '<img src="../../images/employees/' . $picname . '" width="250px" style="border-radius:30px">';
                                ?>

                                <h3 style="color: black" class="profile-username text-center"><b>

                                        <?php

                                        echo $emp_name;

                                        ?>
                                    </b>
                                </h3>

                                <p class="text-muted text-center">
                                    <strong style="color: black"><b><?php echo $position; ?></b></strong>
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#activity" data-toggle="tab">
                                        <?php
                                        if (isset($_POST['check-in']) || isset($_POST['check-out'])) {
                                            echo '<strong style="color: green"><b>' . $message . '</b></strong>';
                                        } else {
                                            echo $log_msg;
                                        }
                                        ?>
                                    </a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal">
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <center>
                                                    <strong>
                                                        <?php
                                                        $dateToday = date("Y/m/d");
                                                        $mydate = strtoTime($dateToday);
                                                        $printdate = date('F d, Y', $mydate);
                                                        echo ' Today ' . $printdate;
                                                        ?></strong>
                                                    <br></br>
                                                    <span style="color: black" id="date_time"><b></b></span>
                                                    <br></br>
                                                    <span id="computing" style="color: black"><b></b></span>
                                                    <input type="hidden" id="location" name="location" value="" class="form-control">
                                                </center>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <?php echo $checkin_btn ?>
                                                <?php echo $checkout_btn ?>
                                                <!-- <button name="check-out" type="submit" class="btn btn-danger">Check Out</button> -->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include '../footer/footer.php'; ?>
    </div>

    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>

    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <script src="../plugins/fastclick/fastclick.min.js"></script>

    <script src="../dist/js/app.min.js"></script>

    <script src="../dist/js/demo.js"></script>
    <script>
        function date_time(id) {
            date = new Date;
            year = date.getFullYear();
            month = date.getMonth();
            months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December');
            d = date.getDate();
            day = date.getDay();
            days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
            h = date.getHours();
            if (h < 10) {
                h = "0" + h;
            }
            m = date.getMinutes();
            if (m < 10) {
                m = "0" + m;
            }
            s = date.getSeconds();
            if (s < 10) {
                s = "0" + s;
            }
            result = h + ':' + m + ':' + s;
            document.getElementById(id).innerHTML = result;
            setTimeout('date_time("' + id + '");', '1000');
            return true;
        }
    </script>

    <script type="text/javascript">
        window.onload = date_time('date_time');
    </script>

</body>

</html>