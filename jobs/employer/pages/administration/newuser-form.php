<style>
    .form-user-admin {
        width: 50%;
    }

    @media only screen and (max-width: 768px) {
        .form-user-admin {
            width: 100%;
        }

    }
</style>

<?php
if (isset($_POST['register'])) {

    $fname = mysql_real_escape_string($_POST['fname']);
    $lname = mysql_real_escape_string($_POST['lname']);
    $username = mysql_real_escape_string($_POST['username']);
    $email = mysql_real_escape_string($_POST['email']);
    $dob = mysql_real_escape_string($_POST['dob']);
    $gender = mysql_real_escape_string($_POST['gender']);
    $user_type = mysql_real_escape_string($_POST['user_type']);
    $phone = mysql_real_escape_string($_POST['phone']);
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $su = 0;

    if ($user_type === 'admin') {
        $su = 1;
    }
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
        mysql_query("INSERT INTO jobs_users (fname,lname,username,email,phone,dob,gender,user_type,password)
                VALUES ('$fname','$lname', '$username', '$email','$phone','$dob','$gender', '$user_type', '$password')
                ") or die("Error Inserting: " . mysql_error());

        mysql_query("INSERT INTO savsoft_users (password,email,first_name,last_name,contact_no,gid,su,subscription_expired,user_status)
                VALUES ('$password','$email','$fname','$lname', '$phone', '1', '$su', '2122569000', 'Active')
                ") or die("Error Inserting: " . mysql_error());

        $user_id = mysql_insert_id();
        mysql_query("INSERT INTO jobs_user_info (user_id)
                VALUES ('$user_id') ") or die("Error Inserting: " . mysql_error());

        echo "<script> window.location='users' </script>";
    }
}

?>

<div class="content-wrapper">
    <div>
        <ol class="breadcrumb">
            <li><a href="#">Administration</a></li>
            <li class="active">New user</li>
        </ol>
    </div>
    <div class="panel panel-default">
        <div class="panel-body form-user-admin" style="font-size:14px;">

            <form method="post" class="row g-3">
                <div class="col-md-6">
                    <label class="">First Name</label>
                    <input name="fname" type="text" required="required" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="">Last Name</label>
                    <input name="lname" type="text" required="required" class="form-control">
                </div>
                <div class="col-6">
                    <label class="">User Name</label>
                    <input name="username" type="text" required="required" class="form-control">
                </div>
                <div class="col-6">
                    <label class="">Email</label>
                    <input name="email" type="email" required="required" class="form-control">
                </div>
                <div class="col-6">
                    <label class="">Phone Number</label>
                    <input name="phone" type="text" required="required" class="form-control">
                </div>
                <div class="col-6">
                    <label class="">Date of Birth</label>
                    <input name="dob" type="date" required="required" class="form-control">
                </div>
                <div class="col-6">
                    <label class="">Gender</label>
                    <select name="gender" class="form-control">
                        <option value="">--Select Gender--</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="">User Privileges</label>
                    <select name="user_type" class="form-control">

                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="">Password</label>
                    <input name="pass1" type="password" required="required" class="form-control">
                </div>
                <div class="col-6">
                    <label class="">Confirm Password</label>
                    <input name="pass2" type="password" required="required" class="form-control">
                </div>
                <div class="col-12">
                    <button name="register" onclick="error_message()" type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
            </form>

        </div>
    </div>
</div>