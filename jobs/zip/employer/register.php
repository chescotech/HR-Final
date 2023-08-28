<?php
ob_start();
session_start();
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Please Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/square/blue.css">
    <script src="../java_script_files/jquery-2.1.4.min.js"></script>

</head>

<?php
include('../includes/dbconnection.php');
include('../includes/License.php');

$License = new License();
?>

<?php
if (isset($_POST['register'])) {
    $comp_name = mysql_real_escape_string($_POST['cname']);
    $email = mysql_real_escape_string($_POST['email']);
    $phone = mysql_real_escape_string($_POST['phone']);
    $reg_num = mysql_real_escape_string($_POST['reg_number']);
    $username = mysql_real_escape_string($_POST['username']);
    $web_url = mysql_real_escape_string($_POST['web_url']);
    $fb_url = mysql_real_escape_string($_POST['fb_url']);

    $upload_id = round(microtime(true) * 1000);
    $file = $upload_id . "-" . $_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $folder = "company_logo/";

    $Image_size = $_FILES['file']['size'];
    $Image_type = $_FILES['file']['type'];
    $Image_folder = "company_logo/";

    $new_size = $file_size / 1024000;
    $image_size = $file_size / 1024000;

    $new_file_name = strtolower($file);

    $Certificate = str_replace(' ', '-', $new_file_name);

    echo $Certificate;

    $imgExt = strtolower(pathinfo($new_file_name, PATHINFO_EXTENSION));
    $valid_extensions = array('png', 'jpg', 'jpeg', 'gif', 'webp');

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

    $ck_q = mysql_query("
    SELECT * FROM employer 
    WHERE username = '$username' AND email = '$email' 
    UNION 
    SELECT * FROM jobs_users 
    WHERE username = '$username' AND email = '$email' ") or die(mysql_error());

    if (mysql_num_rows($ck_q) > 1) {
        echo "<script> alert('The Email and Username Used Already Exist') </script>";
        echo "<script> window.location='register' </script>";
        return;
    } else {
       
        if (in_array($imgExt, $valid_extensions)) { 
            if(move_uploaded_file($file_loc, $folder . $Certificate)) {
            mysql_query("INSERT INTO employer (comp_name, reg_number, username, email, phone, web_url, fb_url,ref_id, password)
    VALUES ('$comp_name', '$reg_num', '$username', '$email', '$phone', '$web_url', '$fb_url','$Certificate','$password')")
                or die("Error Inserting: " . mysql_error());

            $comp_id = mysql_insert_id();

            $_SESSION['comp_name'] = $comp_name;
            $_SESSION['reg_num'] = $reg_num;
            $_SESSION['comp_username'] = $username;
            $_SESSION['empl_email'] = $email;
            $_SESSION['empl_phone'] = $phone;
            $_SESSION['empl_id'] = $comp_id;
            $_SESSION['empl_logo'] = $Certificate;
            echo "<script> window.location='../employer/pages/jobs/job-list' </script>";
       } } else {
            echo "<script> alert('Registration Failed Because Your Logo Could Not Be Uploaded.') </script>";
            // echo "<script> window.location='register' </script>";
            echo $Certificate;
            return;
        }
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
            <center><img src="../img/logo4.jpeg" class="img-responsive" alt="" /></center>
            <?php
            // if (isset($_POST['register'])) {
            //     echo $message;
            // }
            ?>
            <h3 style="color:#00548b; font-weight:bolder;">
                <center>Jana Solutions Employer Registration </center>
            </h3>
            <p>
                <center style="color:orange;"> All fields are required. </center>
            </p>
            <hr>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group has-feedback">
                    <label class="">Company Name</label>
                    <input name="cname" type="text" required="required" class="form-control">
                </div>
                <div class="form-group has-feedback">
                    <label class="">Contact Email</label>
                    <input name="email" type="email" required="required" class="form-control">
                </div>
                <div class="form-group has-feedback">
                    <label class="">Contact Number</label>
                    <input name="phone" type="text" required="required" class="form-control">
                </div>
                <div class="form-group has-feedback">
                    <label class="">Registration Number</label>
                    <input name="reg_number" type="text" required="required" class="form-control">
                </div>
                <div class="form-group has-feedback">
                    <label class="">Company Website URL (optional)</label>
                    <input name="web_url" type="text" class="form-control">
                </div>
                <div class="form-group has-feedback">
                    <label class="">Facebook Page URL (optional)</label>
                    <input name="fb_url" type="text" class="form-control">
                </div>
                <div class="form-group has-feedback">
                    <label class="">Upload Logo</label>
                    <input name="file" type="file" required="required" class="form-control">
                </div>
                <div class="form-group has-feedback">
                    <label class="">User Name</label>
                    <input name="username" type="text" required="required" class="form-control">
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
                        <a href="../login">Sign in instead?</a>
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        <center><button name="register" onclick="error_message()" type="submit" class="btn btn-primary btn-block btn-flat">Register</button></center>
                    </div><!-- /.col -->
                </div>
            </form>
        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="Admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="Admin/plugins/iCheck/icheck.min.js"></script>
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