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
if (isset($_POST['register'])) {

    $fname = mysql_real_escape_string($_POST['fname']);
    $lname = mysql_real_escape_string($_POST['lname']);
    $username = mysql_real_escape_string($_POST['username']);
    $email = mysql_real_escape_string($_POST['email']);
    $dob = mysql_real_escape_string($_POST['dob']);
    $gender = mysql_real_escape_string($_POST['gender']);
    $phone = mysql_real_escape_string($_POST['phone']);
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    // check if pass matches
    if ($pass1 === $pass2) {
        $password = md5($pass1);
    } else {
        echo "<script> alert('Passwords Do Not Match') </script>";
        echo "<script> window.location='register' </script>";
        return;
    }
    $message = "";
    $ck_q = mysql_query("SELECT * FROM jobs_users WHERE username = '$username' AND email = 'email' ") or die(mysql_error());

    if (mysql_num_rows($ck_q) > 1) {
        echo "<script> alert('The Email and Username Used Already Exists') </script>";
        echo "<script> window.location='register' </script>";
        return;
    } else {
        mysql_query("INSERT INTO jobs_users (fname,lname,username,email,phone,dob,gender,password)
                VALUES ('$fname','$lname', '$username', '$email','$phone','$dob','$gender', '$password')
                ") or die("Error Inserting: ".mysql_error());
            
        $user_id = mysql_insert_id();
        mysql_query("INSERT INTO jobs_user_info (user_id)
                VALUES ('$user_id') ") or die("Error Inserting: ".mysql_error());

        $_SESSION['job_fname'] = $fname;
        $_SESSION['job_lname'] = $lname;
        $_SESSION['job_username'] = $username;
        $_SESSION['job_email'] = $email;
        $_SESSION['job_dob'] = $dob;
        $_SESSION['job_gender'] = $gender;
        $_SESSION['job_phone'] = $phone;
        $_SESSION['job_user_id'] = mysql_insert_id();
        echo "<script> window.location='index' </script>";
    }
}

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
            // if (isset($_POST['register'])) {
            //     echo $message;
            // }
            ?>
            <h3 style="color:#00548b; font-weight:bolder">
                <center> HR Careers User Registration </center>
            </h3>
            <p>
                <center style="color:orange;"> All fields are required. </center>
            </p>
            <hr>
            <form method="post">
                <div class="form-group has-feedback">
                    <label class="">First Name</label>
                    <input name="fname" type="text" required="required" class="form-control">
                </div>
                <div class="form-group has-feedback">
                    <label class="">Last Name</label>
                    <input name="lname" type="text" required="required" class="form-control">
                </div>
                <div class="form-group has-feedback">
                    <label class="">User Name</label>
                    <input name="username" type="text" required="required" class="form-control">
                </div>
                <div class="form-group has-feedback">
                    <label class="">Email</label>
                    <input name="email" type="email" required="required" class="form-control">
                </div>
                <div class="form-group has-feedback">
                    <label class="">Phone Number</label>
                    <input name="phone" type="text" required="required" class="form-control">
                </div>
                <div class="form-group has-feedback">
                    <label class="">Date of Birth</label>
                    <input name="dob" type="date" required="required" class="form-control">
                </div>
                <div class="form-group has-feedback">
                    <label class="">Gender</label>
                    <select name="gender" class="form-control">
                        <option value="">--Select Gender--</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group has-feedback">
                    <label class="">Password</label>
                    <input name="pass1" type="password" required="required" class="form-control">
                </div>
                <div class="form-group has-feedback">
                    <label class="">Confirm Password</label>
                    <input name="pass2" type="password" required="required" class="form-control">
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <a href="login">Sign in instead?</a>
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        <center><button name="register" onclick="error_message()" type="submit" class="btn btn-primary btn-block btn-flat">Register</button></center>
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