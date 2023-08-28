<?php
error_reporting(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Crystal Pay</title>
        <link href="login.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div class="wrapper">
            <div class="header"></div>
            <div class="head2"></div>
            <div class="body">
                <br/><br/>
                </body>
                </html>
                <?php
                ob_start();
                session_start();
                include('include/dbconnection.php');
                $login2 = mysql_query("SELECT * FROM company WHERE (username = '" . mysql_real_escape_string($_POST['username']) . "') and (password = '" . mysql_real_escape_string($_POST['password']) . "')");
                // $usersQuery = mysql_query("SELECT * FROM users_tb WHERE (user_name = '" . mysql_real_escape_string($_POST['username']) . "') and (password = '" . md5(mysql_real_escape_string($_POST['password'])) . "')");
                $EmployeeQuery = mysql_query("SELECT * FROM emp_info WHERE (empno = '" . mysql_real_escape_string($_POST['username']) . "') and (password = '" . md5(mysql_real_escape_string($_POST['password'])) . "')");
                $employeeRows = mysql_fetch_array($EmployeeQuery);
                // user query..
                $UserQuery = mysql_query("SELECT * FROM users_tb WHERE (user_name = '" . mysql_real_escape_string($_POST['username']) . "') and (password = '" . md5(mysql_real_escape_string($_POST['password'])) . "')");
                $UserRows = mysql_fetch_array($UserQuery);

                if (mysql_num_rows($EmployeeQuery) == 1) {
                    $_SESSION['employee_id'] = $_POST['username'];
                    $companyId = $employeeRows['company_id'];
                    $CompanyQuery = mysql_query("SELECT name from company WHERE company_ID = '$companyId' ");
                    $compRow = mysql_fetch_array($CompanyQuery);
                    $companyName = $compRow['name'];
                    $_SESSION['company_name'] = $companyName;
                    $_SESSION['company_ID'] = $companyId;
                    
                    ?>
                <script>
                    window.location.href = 'employee/index.php';
                </script>
                <?php
                    
                    exit();
                }
                if (mysql_num_rows($UserQuery) == 1) {
                    $userType = $UserRows['user_type'];
                    if ($userType == "superadmin") {
                        $_SESSION['employee_id'] = $UserRows['empno'];
                        $_SESSION['firstname'] = $UserRows['firstname'];
                        $_SESSION['lastname'] = $UserRows['lastname'];
                       
                          ?>
                <script>
                    window.location.href = 'SuperAdmin/company-list.php';
                </script>
                <?php
                        exit();
                    } else if ($userType == "admin") {
                        $_SESSION['user_id'] = $UserRows['id'];
                        $_SESSION['employee_id'] = $UserRows['empno'];
                        $_SESSION['firstname'] = $UserRows['firstname'];
                        $_SESSION['lastname'] = $UserRows['lastname'];
                        $_SESSION['companyID'] = $UserRows['company_id'];
                       
                             ?>
                <script>
                    window.location.href = 'CompanyAdmin/index.php';
                </script>
                <?php
                        
                        exit();
                    } else {
                        $Companyrow = mysql_fetch_array($login2);
                        $_SESSION['company_ID'] = $UserRows['company_id'];
                        $compId = $UserRows['company_id'];       
                        $_SESSION['user_id'] =$UserRows['empno'];
                        $query = mysql_query("SELECT name FROM company where company_ID = '$compId'");
                        $rows = mysql_fetch_array($query);                        
                        $_SESSION['name'] = $rows['name'];
                       
                                ?>
                <script>
                    window.location.href = 'Admin/index.php';
                </script>
                <?php
                        
                        exit();
                    }
                }
                if (mysql_num_rows($EmployeeQuery) == 0 && mysql_num_rows($UserQuery) == 0){
                    
                                 ?>
                <script>
                    window.location.href = ' error.php';
                </script>
                <?php
                    exit();
                }
                ?>
            </div>
            <div class="footer"></div>
        </div>>