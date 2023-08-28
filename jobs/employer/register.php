<?php
ob_start();
session_start();

$pageTitle = "Employer Registration - Jana";
include('../includes/headers.php');
include('../includes/dbconnection.php');
include('../includes/License.php');
include('../email.php');

$License = new License();
?>
<html>

<?php
if (isset($_POST['register'])) {
    $comp_name = mysql_real_escape_string($_POST['cname']);
    $description = mysql_real_escape_string($_POST['description']);
    $email = mysql_real_escape_string($_POST['email']);
    $phone = mysql_real_escape_string($_POST['phone']);
    $reg_num = mysql_real_escape_string($_POST['reg_number']);
    $username = mysql_real_escape_string($_POST['username']);
    $web_url = mysql_real_escape_string($_POST['web_url']);
    $fb_url = mysql_real_escape_string($_POST['fb_url']);
    
    
     $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "JANA SOLUTIONS";
    $mail->addAddress('info@janazm.com');
    $mail->Body = "New Employer Registration login here to Approve. <a href='https://janazm.com/jobs/login.php'> Admin login </a>";
        
        

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

    if (mysql_num_rows($ck_q) > 0) {
        echo "<script> alert('The Email and Username Used Already Exist! please try with different credentials') </script>";
        echo "<script> window.location='register' </script>";
        return;
    } else {
        // if ($reg_num <= 0) {
        //     echo "<script> alert('Registration Number should be greater than zero') </script>";
        //     echo "<script> window.location='register' </script>";
        //     return;
        // }

        // $check_query = mysql_query("SELECT * FROM employer WHERE reg_number = '$reg_num'") or die(mysql_error());
        // if (mysql_num_rows($check_query) > 0) {
        //     echo 'here';
        //     echo "<script> alert('The Registration Number is linked to another company! please use your unique registration number.') </script>";
        //     echo "<script> window.location='register' </script>";
        //     return;
        // }

        if (in_array($imgExt, $valid_extensions)) {
            if (move_uploaded_file($file_loc, $folder . $Certificate)) {
                mysql_query("INSERT INTO employer (comp_name, reg_number, username, email, phone, web_url, fb_url,ref_id, password, comp_description)
    VALUES ('$comp_name', '$reg_num', '$username', '$email', '$phone', '$web_url', '$fb_url','$Certificate','$password', '$description')")
                    or die("Error Inserting: " . mysql_error());

                $comp_id = mysql_insert_id();

                // $_SESSION['comp_name'] = $comp_name;
                // $_SESSION['reg_num'] = $reg_num;
                // $_SESSION['comp_username'] = $username;
                // $_SESSION['empl_email'] = $email;
                // $_SESSION['empl_phone'] = $phone;
                // $_SESSION['empl_id'] = $comp_id;
                // $_SESSION['empl_logo'] = $Certificate;
                
                $mail->send();
                echo "<script> alert('You have successfully registered, you will be notified once your registration is approved.') </script>";
                echo "<script> window.location='../login.php' </script>";
            } else {
                echo "<script> alert('Registration Failed Because Your Logo Could Not Be Uploaded.') </script>";
                echo "<script> window.location='register' </script>";
                return;
            }
        } else {
            echo "<script> alert('Registration Failed Because Your Logo Could Not Be Uploaded.') </script>";
            echo "<script> window.location='register' </script>";
            return;
        }
    }
}
?>

<body>
    <?php include "../includes/navigation/navigation_menu.php" ?>
    <section class="">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block my-auto">
                                <img src="../assets/images/logo4.jpeg" style="width:20rem; margin-left:5rem;" alt="login form" class="img-fluid" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form method="post" enctype="multipart/form-data">
                                        <h1>Jana Solutions Employer Registration</h1>
                                        <?php
                                        // if (isset($_POST['register'])) {
                                        //     echo $message;
                                        // }
                                        ?>
                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">All fields are required.</h5>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="cname">Company Name</label>
                                            <input id="cname" name="cname" type="text" required="required" class="form-control" placeholder="Company Name">
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="3" required class="form-control" placeholder="Description"></textarea>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="email">Contact Email</label>
                                            <input name="email" type="email" required="required" class="form-control" placeholder="Contact Email">
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="phone">Contact Number</label>
                                            <input name="phone" type="text" required="required" class="form-control" placeholder="Contact Number">
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="reg_number">Registration Number</label>
                                            <input name="reg_number" type="text" required="required" class="form-control" placeholder="Registration Number">
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="web_url">Company Website URL (optional)</label>
                                            <input name="web_url" type="text" class="form-control" placeholder="Company Website URL">
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="fb_url">Facebook Page URL (optional)</label>
                                            <input name="fb_url" type="text" class="form-control" placeholder="Facebook Page URL">
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="file">Upload Logo</label>
                                            <input name="file" type="file" required="required" class="form-control">
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="username">User Name</label>
                                            <input name="username" type="text" required="required" class="form-control" placeholder="User Name">
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="pass1">Password</label>
                                            <input name="pass1" type="password" required="required" class="form-control" placeholder="Password" oninput="checkPasswordLength()">
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="pass2">Confirm Password</label>
                                            <input name="pass2" type="password" required="required" class="form-control" placeholder="Confirm Password" oninput="checkPasswordLength()">
                                        </div>

                                        <div>
                                            <p id="passMsg" class="text-danger">

                                            </p>
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button id="registerBtn" name="register" onclick="error_message()" class="btn btn-dark btn-lg btn-block" type="submit" disabled>Register</button>
                                        </div>

                                        <p class="pb-lg-2" style="color: #393f81;">Already have an account? <a href="../login" style="color: #393f81;">Sign in here</a></p>
                                        <p class="pb-lg-2" style="color: #393f81;">Do you want to apply for jobs? <a href="../register" style="color: #393f81;">User Registration</a></p>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.login-box -->

    <?php include('../includes/scripts.php') ?>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
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