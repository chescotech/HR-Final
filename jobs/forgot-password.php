<?php
ob_start();
session_start();
?>
<html>
<?php
$pageTitle = "Reset Password - Jana Solutions"; // Set the dynamic title here
include('./includes/headers.php');
?>



<?php
include('./includes/dbconnection.php');
include('./includes/License.php');
include('./email.php');

$License = new License();
?>

<?php
if (isset($_POST['reset'])) {
    $user_email = $_POST['email'];

    // generate random password
    $length = 6;
    $new_pass = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);

    // update user db entry with hash of new password
    $password = md5($new_pass);

    $user_query = mysql_query("SELECT * from jobs_user WHERE email='$user_email'");

    $emp_query = mysql_query("SELECT * from employer WHERE email='$user_email'");

    if (mysql_num_rows($user_query) <= 0 && mysql_num_rows($emp_query) <= 0) {
        echo "<script> alert('Something went wrong. Please check your email.')</script>";
        echo "<script> window.location='forgot-password' </script>";
        return;
    }

    if (mysql_num_rows($user_query) > 0) {
        $query = mysql_query("
        UPDATE jobs_users
        SET password = '$password'
        WHERE email = '$user_email'
        ") or die(mysql_error());
    } else {
        $query = mysql_query("
        UPDATE employer
        SET password = '$password'
        WHERE email = '$user_email'
        ") or die(mysql_error());
    }

    // email user random password
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "JANA SOLUTIONS";
    $mail->addAddress($user_email);
    $mail->Body = "Dear " . 'User' . ",\n\n"
        . "Your request to reset your password has been received and processed.\n\n"
        . "Your new password is $new_pass. Please keep this in a safe place and do not share it with anyone else.\n\n"
        . "Regards,\n\n"
        . "Jana Solutions Team";

    $mail->send();

    echo "<script> alert('Your request has been processed. Please check your email for your updated password.') </script>";
    echo "<script> window.location='login' </script>";
    return;
}

?>

<body background="">
    <?php include "includes/navigation/navigation_menu.php" ?>

    <section class="">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block my-auto">
                                <img src="assets/images/logo4.jpeg" style="width:20rem; margin-left:5rem;" alt="login form" class="img-fluid" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form method="post">


                                        <h1>
                                            Reset Password
                                        </h1>
                                        <?php
                                        if (isset($_POST['reset'])) {
                                            echo $message;
                                        }
                                        ?>

                                        <!-- <div class="form-outline mb-4">
                                            <label class="form-label" for="pass1">Password</label>
                                            <input name="pass1" type="password" required="required" class="form-control" placeholder="Password" oninput="checkPasswordLength()">
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="pass2">Confirm Password</label>
                                            <input name="pass2" type="password" required="required" class="form-control" placeholder="Confirm Password" oninput="checkPasswordLength()">
                                        </div> -->

                                        <div class="form-group has-feedback mb-4">
                                            <label class="form-label" for="email">Email</label>
                                            <input id="email" name="email" type="email" required="required" class="form-control" placeholder="Email">
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button name="reset" onclick="error_message()" class="btn btn-dark btn-lg btn-block" type="submit">Reset Password</button>
                                        </div>
                                        <div class="col-xs-8">
                                            <a href="login">Sign in instead?</a>
                                        </div><!-- /.col -->
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include('includes/scripts.php'); ?>
    <script>
        function checkPasswordLength() {
            const pass1 = document.querySelector('input[name="pass1"]');
            const pass2 = document.querySelector('input[name="pass2"]');
            const msg = document.getElementById('passMsg');
            const registerBtn = document.getElementById('registerBtn');

            if (pass1.value.length >= 6 && pass1.value === pass2.value) {
                registerBtn.disabled = false;
                msg.textContent = "";
            } else {
                msg.textContent = "Password must be at least 6 characters";
                registerBtn.disabled = true;
            }
        }
    </script>
</body>

</html>