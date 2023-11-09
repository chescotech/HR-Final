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

if (isset($_GET['id'])) {
    $from_user_id = $_GET['id'];

    $user_q = mysqli_query($link, "SELECT * FROM jobs_users WHERE id=$from_user_id ") or die(mysqli_error($link));
    while ($row = mysqli_fetch_array($user_q)) {
        $fname = $row['fname'];
        $lname = $row['lname'];
        $username = $row['username'];
        $email = $row['email'];
        $dob = $row['dob'];
        $gender = $row['gender'];
        $user_id = $row['id'];
        $phone = $row['phone'];
        $user_type = $row['user_type'];
    }
} else {
    echo "<script> window.location='users' </script>";
}

if (isset($_POST['register'])) {

    $fname = ($_POST['fname']);
    $lname = ($_POST['lname']);
    $username = ($_POST['username']);
    $email = ($_POST['email']);
    $dob = ($_POST['dob']);
    $gender = ($_POST['gender']);
    $user_type = ($_POST['user_type']);
    $phone = ($_POST['phone']);
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

    mysqli_query($link, "UPDATE jobs_users SET fname='$fname', lname='$lname', username='$username', email='$email',
     phone='$phone', dob='$dob', gender='$gender', password='$password' WHERE id='$from_user_id'") or die("Error Inserting: " . mysqli_error($link));

    // mysqli_query($link,"UPDATE jobs_users (fname,lname,username,email,phone,dob,gender,user_type,password)
    //             VALUES ('$fname','$lname', '$username', '$email','$phone','$dob','$gender', '$user_type', '$password')
    //             ") or die("Error Inserting: " . mysqli_error($link));
    echo "<script> window.location='users' </script>";
}

?>

<div class="content-wrapper">
    <div>
        <ol class="breadcrumb">
            <li><a href="#">Administration</a></li>
            <li class="active">Edit user</li>
        </ol>
    </div>
    <div class="panel panel-default">
        <div class="panel-body form-user-admin" style="font-size:14px;">

            <form method="post" class="row g-3">
                <div class="col-md-6">
                    <label class="">First Name</label>
                    <input value='<?php echo $fname; ?>' name="fname" type="text" required="required" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="">Last Name</label>
                    <input value='<?php echo $lname; ?>' name="lname" type="text" required="required" class="form-control">
                </div>
                <div class="col-6">
                    <label class="">User Name</label>
                    <input value='<?php echo $username; ?>' name="username" type="text" required="required" class="form-control">
                </div>
                <div class="col-6">
                    <label class="">Email</label>
                    <input value='<?php echo $email; ?>' name="email" type="email" required="required" class="form-control">
                </div>
                <div class="col-6">
                    <label class="">Phone Number</label>
                    <input value='<?php echo $phone; ?>' name="phone" type="text" required="required" class="form-control">
                </div>
                <div class="col-6">
                    <label class="">Date of Birth</label>
                    <input value='<?php echo $dob; ?>' name="dob" type="date" required="required" class="form-control">
                </div>
                <div class="col-6">
                    <label class="">Gender</label>
                    <select value='<?php echo $gender; ?>' name="gender" class="form-control">
                        <option value="">--Select Gender--</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
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
                    <button name="register" onclick="error_message()" type="submit" class="btn btn-primary btn-block btn-flat">Update</button>
                </div>
            </form>

        </div>
    </div>
</div>