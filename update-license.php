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
        <link rel="stylesheet" href="Admin/bootstrap/css/bootstrap.min.css">
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

        //   $em = new email();
        $key = $_POST['key'];
        include('include/dbconnection.php');

        mysql_query("UPDATE company SET _key = '$key' ");

        //echo "<script> alert('Recovery Password sent via email.') </script>";
        echo "<script type='text/javascript'>alert('License Key has been updated !');
	  document.location='login.php'</script>";
    }
    ?>

    <body style="background-color: wheat">
        <div class="login-box">
            <div hidden="hidden" id="error_block" class="login-logo">

            </div>
            <div class="login-box-body">
                <center><img src="img/my-logo.PNG" class="img-responsive" alt="" /></center>
                <?php
                if (isset($_POST['sign_in'])) {
                    echo $message;
                }
                ?>
                <center>
                    <h>Enter your License Key to activate the system. </h>
                </center>
                <br>
                <form method="post">
                    <div class="form-group has-feedback">
                        <input id="empno" name="key" type="text" required="required" class="form-control" placeholder="Enter License Key" autocomplete="off">
                    </div>

                    <div class="row">
                        <div class="col-xs-4">
                            <center><button name="sign_in" onclick="error_message()" type="submit" class="btn btn-primary btn-block btn-flat">Update</button></center>
                            <right><a href="login.php">Login</a></right>
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
                                $(function () {
                                    $('input').iCheck({
                                        checkboxClass: 'icheckbox_square-blue',
                                        radioClass: 'iradio_square-blue',
                                        increaseArea: '20%' // optional
                                    });
                                });
        </script>
    </body>

</html>