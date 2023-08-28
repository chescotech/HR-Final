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
include('License.php');

$License = new License();
?>

<?php
if (isset($_POST['sign_in'])) {

    $message = "";
    include('include/dbconnection.php');
    $login2 = mysql_query("SELECT * FROM company WHERE (username = '" . mysql_real_escape_string($_POST['username']) . "') and (password = '" . mysql_real_escape_string($_POST['password']) . "')");
    // $usersQuery = mysql_query("SELECT * FROM users_tb WHERE (user_name = '" . mysql_real_escape_string($_POST['username']) . "') and (password = '" . md5(mysql_real_escape_string($_POST['password'])) . "')");
    $EmployeeQuery = mysql_query("SELECT * FROM emp_info WHERE (empno = '" . mysql_real_escape_string($_POST['username']) . "') and (password = '" . md5(mysql_real_escape_string($_POST['password'])) . "')");
    $employeeRows = mysql_fetch_array($EmployeeQuery);
    // user query..
    $UserQuery = mysql_query("SELECT * FROM users_tb WHERE (user_name = '" . mysql_real_escape_string($_POST['username']) . "') and (password = '" . md5(mysql_real_escape_string($_POST['password'])) . "')");
    $UserRows = mysql_fetch_array($UserQuery);

    // check the keys for license first..
    $login2_ = mysql_query("SELECT * FROM company ");

    $Companyrow_ = mysql_fetch_array($login2_);

    $_key = $Companyrow_['_key'];
    $name = $Companyrow_['name'];
    $_SESSION['_key'] = $_key;
    //echo '$_key' . $name;
    // check if license is valid...

    if ($License->checkExpiryDate($_key) == "valid") {
        if (mysql_num_rows($EmployeeQuery) == 1) {
            $_SESSION['employee_id'] = $_POST['username'];
            $_SESSION['empno'] = $employeeRows['empno'];
            // log the log in
            $empnum = $_SESSION['empno'];
            $companyId = $employeeRows['company_id'];
            $CompanyQuery = mysql_query("SELECT name from company WHERE company_ID = '$companyId' ");
            $compRow = mysql_fetch_array($CompanyQuery);
            $companyName = $compRow['name'];
            $_SESSION['company_name'] = $companyName;
            $_SESSION['dept'] = $employeeRows['dept'];
            $_SESSION['company_ID'] = $companyId;

            // log
            $action = "LOGIN";
            $log_login = mysql_query("INSERT INTO login_log(empno, action, company_id) VALUES('$empnum', '$action', '$companyId')");

            header('Location:employee/index.php');
            exit();
        }
        if (mysql_num_rows($UserQuery) == 1) {
            $userType = $UserRows['user_type'];
            if ($userType == "superadmin") {
                $_SESSION['employee_id'] = $UserRows['empno'];
                $_SESSION['firstname'] = $UserRows['firstname'];
                $_SESSION['lastname'] = $UserRows['lastname'];
                header('Location:SuperAdmin/company-list.php');
                exit();
            } else if ($userType == "admin") {
                $_SESSION['user_id'] = $UserRows['id'];
                $_SESSION['employee_id'] = $UserRows['empno'];
                $_SESSION['firstname'] = $UserRows['firstname'];
                $_SESSION['lastname'] = $UserRows['lastname'];
                $_SESSION['companyID'] = $UserRows['company_id'];
                header('Location:CompanyAdmin/index.php');
                exit();
            } else {
                $Companyrow = mysql_fetch_array($login2);
                $_SESSION['company_ID'] = $UserRows['company_id'];
                $compId = $UserRows['company_id'];
                $_SESSION['user_id'] = $UserRows['empno'];
                $_SESSION['firstname'] = $UserRows['firstname'];
                $_SESSION['user_session'] = $UserRows['id'];
                $_SESSION['group_id'] = $UserRows['group_id'];
                $query = mysql_query("SELECT name FROM company where company_ID = '$compId'");
                $rows = mysql_fetch_array($query);
                $_SESSION['name'] = $rows['name'];
                header('Location:Admin/index.php');
                exit();
            }
        } else if (mysql_num_rows($EmployeeQuery) == 0 && mysql_num_rows($UserQuery) == 0) {
            $message = '<div class="alert alert-danger">
                        Wrong username or password
                        </div>';
        }
    } else {
        echo "<script type='text/javascript'>alert('Invalid License Key Detected !');
	  document.location='update-license.php'</script>";
    }
}

/*
     */
?>

<body background="img/sapamahrm_banner.png">
    <div class="login-box">
        <div hidden="hidden" id="error_block" class="login-logo">
            <center>
                <img src="img/sapamahrm_banner.png">
            </center>
        </div>
        <div class="login-box-body">
            <center><img src="img/my-logo.PNG" class="img-responsive" alt="" /></center>
            <?php
            if (isset($_POST['sign_in'])) {
                echo $message;
            }
            ?>
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
                        <a href="recover-password">Forgot password?</a>
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        <center><button name="sign_in" onclick="error_message()" type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button></center>
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