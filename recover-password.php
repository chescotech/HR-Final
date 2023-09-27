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
    <link rel="stylesheet" href="assets/bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="Admin/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="Admin/plugins/iCheck/square/blue.css">
    <script src="java_script_files/jquery-2.1.4.min.js"></script>

</head>

<?php
include('include/dbconnection.php');

require_once('PHPmailer/sendmail.php');

?>

<?php
if (isset($_POST['sign_in'])) {

    $message = "";
    $email = mysql_real_escape_string($_POST['email']);

    $em = new email();

    $empno = $_POST['empno'];
    include('include/dbconnection.php');

    $EmployeeQuery = mysql_query("SELECT * FROM emp_info WHERE (empno = '" . mysql_real_escape_string($_POST['empno']) . "') and (email = '" . mysql_real_escape_string($_POST['email']) . "')");
    $employeeRows = mysql_fetch_array($EmployeeQuery);
    // user query..


    if (mysql_num_rows($EmployeeQuery) > 0) {

        $new_pw = $_POST['empno'] . "12ps98";

        $password = md5($new_pw);
        // return var_dump($password);

        $Subject = "Self Service Password Recovery";
        $message = " Hello, <br>
                        A password Reset was requested on your account.
                        your username is " . $_POST['empno'] . " and below is your new password. <br>
                        <br>" . $new_pw . "<br> <hr>
                        Regards.
                        ";

        $em->send_mail($email, $message, $Subject);
        mysql_query("UPDATE emp_info SET password = '$password' WHERE empno = '$empno'");

        echo "<script> alert('Recovery Password sent via email.') </script>";
        $message = '<div class="alert alert-success">
                        Email Sent. Check your inbox for a recovery password.
                        </div>';
    } else if (mysql_num_rows($EmployeeQuery) == 0) {
        $message = '<div class="alert alert-danger">
                        Employee Number Not Recognised 
                        </div>';
    }
}

?>

<body>
    <section class="d-flex flex-column align-items-center justify-content-center">
        <nav class="navbar w-100" style="background-color: #8cc63f;">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="img/my-logo.PNG" alt="Bootstrap" width="48" height="48">
                </a>
                <div class="navbar-text">
                    <a href="http://www.chesco-tech.com" class="btn btn-default">Chesco Home</a>
                </div>
            </div>
        </nav>
        <div class="login-box-body">
            <div class="container p-5 h-100" style="background-color: white;">
                <div class="row d-flex justify-content-center align-items-center h-75">
                    <div class="col col-xl-10">
                        <div class="card" style="border-radius: 1rem;">
                            <div class="row g-0">
                                <div class="col-md-6 col-lg-5 d-none d-md-block my-auto">
                                    <img src="img/my-logo.PNG" style="width:20rem; margin-left:5rem;" alt="login form" class="img-fluid" />
                                </div>
                                <div class="col-md-6 col-lg-7 d-flex align-items-center">

                                    <div class="card-body p-4 p-lg-5 text-black">
                                        <?php
                                        if (isset($_POST['sign_in'])) {
                                            echo $message;
                                        }
                                        ?>
                                        <center>
                                            <h>Enter your employee number and email address. An email with your temp password will be sent to you. </h>
                                        </center>
                                        <br>
                                        <form method="post">
                                            <div class="form-group has-feedback">
                                                <label>Select Company</label>
                                                <select name="company" required="required" class="form-control">
                                                    <option value="anita_fasion">ANITA FASHION</option>
                                                    <option value="twin_lia_farms">TWIN LIA FARMS</option>
                                                    <option value="mwatusanga_apartments">MWATUSANGA APARTMENTS</option>
                                                    <option value="cheryl_gardens">CHERYL GARDEN AND EVENTS CENTRE</option>
                                                    <option value="twin_lia_events">Twin Lia Garden and Event Centre</option>
                                                    <option value="kamwala_a_lodge">KAMWALA ANITA LODGE</option>
                                                    <option value="anita_group">Anita Group</option>
                                                </select>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="empno">Employee Number</label>
                                                <input id="empno" name="empno" type="text" required="required" class="form-control" placeholder="Employee Number">
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="email">Email</label>
                                                <input id="email" name="email" type="email" required="required" class="form-control" placeholder="Email">
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <center><button name="sign_in" onclick="error_message()" type="submit" class="btn btn-md btn-block mt-4" style="background-color: #8cc63f;">Recover</button></center>
                                                    <right><a href="login.php">Login</a></right>
                                                </div><!-- /.col -->

                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.login-box -->
    </section>


    <!-- jQuery 2.1.4 -->
    <script src="Admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="assets/bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
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