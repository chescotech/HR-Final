<?php
ob_start();
session_start();
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PLease Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../Admin/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../Admin/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../Admin/plugins/iCheck/square/blue.css">
    <script src="../java_script_files/jquery-2.1.4.min.js"></script>

</head>

<?php
include('../include/dbconnection.php');
include('../License.php');

$License = new License();
?>

<?php
if (isset($_POST['sign_in'])) {

    $password = md5($_POST['password']);
    $username = mysql_real_escape_string($_POST['username']);
    $ck_q = mysql_query("SELECT * FROM jobs_users WHERE username = '$username' AND password = '$password' ") or die(mysql_error());

    // return var_dump(mysql_num_rows($ck_q));

    if (mysql_num_rows($ck_q) == 1) {
        while ($row = mysql_fetch_array($ck_q)) {
            $fname = $row['fname'];
            $lname = $row['lname'];
            $username = $row['username'];
            $email = $row['email'];
            $dob = $row['dob'];
            $gender = $row['gender'];
            $user_id = $row['id'];
            $user_type = $row['user_type'];
            $phone = $row['phone'];
            // create sessions
            $_SESSION['jobs_passport'] = $_POST['password'];
            $_SESSION['job_fname'] = $fname;
            $_SESSION['job_lname'] = $lname;
            $_SESSION['job_username'] = $username;
            $_SESSION['job_email'] = $email;
            $_SESSION['job_dob'] = $dob;
            $_SESSION['job_phone'] = $phone;
            $_SESSION['job_gender'] = $gender;
            $_SESSION['job_user_id'] = $user_id;
            $_SESSION['job_user_type'] = $user_type;

            if ($user_type == "admin") {
                echo "<script> window.location='../jobs/admin/pages/jobs/job-list' </script>";
            } else {
                echo "<script> window.location='index' </script>";
            }
        }
    } else {
        $message = '<div class="alert alert-danger">
                        Wrong username or password
                    </div>';
        // return;
    }
}

/*
     */
?>

<body background="../img/sapamahrm_banner.png">
    <div class="login-box">
        <div hidden="hidden" id="error_block" class="login-logo">
            <center>
                <img src="../img/sapamahrm_banner.png">
            </center>
        </div>
        <div class="login-box-body">
            <center><img src="../img/my-logo.PNG" class="img-responsive" alt="" /></center>
            <?php
            if (isset($_POST['sign_in'])) {
                echo $message;
            }
            ?>
            <h3 style="color:#00548b; font-weight:bolder">
                <center> HR Careers Log In </center>
            </h3>
            <hr>
            <form method="post">
                <div class="form-group has-feedback">
                    <input id="username" name="username" type="text" required="required" class="form-control" placeholder="Username">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input name="password" type="password" required="required" class="form-control" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <u> <a href="../recover-password">Forgot password?</a> </u>
                    </div>
                    <div class="col-xs-8">
                        <u> <a href="register">Create New Account</a> </u>
                    </div>
                    <div class="col-xs-4">
                        <center><button name="sign_in" onclick="error_message()" type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button></center>
                    </div><!-- /.col -->
                </div>
            </form>
        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="../Admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../Admin/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="../Admin/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

</html>