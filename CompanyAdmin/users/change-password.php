<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Change Password</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.min.css">
        <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.print.css" media="print">
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
        <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <a href="" class="logo">    
                    <span class="logo-lg"><b></b></span>
                </a>
                <?php include '../navigation_panel/authenticated_user_header.php'; ?>        
                </nav>
            </header>

            <aside class="main-sidebar">        
                <section class="sidebar">         
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <?php include '../navigation_panel/side_navigation_bar.php'; ?>
                </section>
            </aside>

            <?php
            include_once '../Classes/Company.php';
            $companyObject = new Company();
            $companyId = $_SESSION['companyID'];
            if (isset($_POST['save'])) {

                $message = "";
                include_once '../../Admin/Classes/Employees.php';
                $EmployeeObject = new Employee();
                $empId = $_SESSION['employee_id'];
                $oldPassword = $_POST['old_password'];
                $newPassword = $_POST['new_password'];
                $reEnterPassword = $_POST['re_new_password'];
                $Id = $_SESSION['user_id'];
                $checkRecods = $companyObject->checkIfEmployeeExsists($oldPassword, $Id);
                if (mysql_num_rows($checkRecods) > 0 && $newPassword == $reEnterPassword) {
                    $companyObject->changePasssword($newPassword, $Id);
                    $message = "Your Password has been changed Sucessfully!!";
                    ?>                  
                    <?php
                }
                if (mysql_num_rows($checkRecods) == 0) {
                    $message = "Invalid Old Password Entered!!";
                    ?>                    
                    <?php
                } else if ($newPassword != $reEnterPassword) {
                    $message = "Passwords Do not Match, Please re-enter the passwords!";
                    ?>                  
                    <?php
                }
            }
            ?>

            <div class="content-wrapper">             
                <section class="content">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="box box-primary">
                                <div class="box-body box-profile">                                 
                                    <p class="text-muted text-center">
                                        <a class="btn btn-primary btn-block">
                                            <b>
                                                Change Password
                                            </b>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <form enctype="multipart/form-data" method="post" >
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <center>
                                            <?php
                                            if (isset($_POST['save'])) {
                                            if($message == "Your Password has been changed Sucessfully!!"){
                                                 echo '<strong style="color: green"><b>'.$message.'</b></strong>';    
                                            }  else {
                                                 echo '<strong style="color: red"><b>'.$message.'</b></strong>';    
                                            }                                                                                                                          
                                        }  else {
                                            echo 'Change Your Account Password';
                                        } 
                                            ?>                                               
                                        </center>
                                    </div>
                                    <div class="box-body">
                                        <label>Old Password:</label>
                                        <div class="form-group">                                             
                                            <input name="old_password" required="required" placeholder="Enter old password" class="form-control" >
                                        </div>                                        
                                    </div>

                                    <div class="box-body">
                                        <label>New Password:</label>
                                        <div class="form-group">                                           
                                            <input name="new_password" required="required" type="password" placeholder="Enter New password" class="form-control" >
                                        </div>                                        
                                    </div>

                                    <div class="box-body">
                                        <label>Re enter New Password:</label>
                                        <div class="form-group">                                           
                                            <input name="re_new_password" required="required" type="password" placeholder="Re enter new password" class="form-control" >
                                        </div>                                        
                                    </div>

                                    <div class="box-footer">
                                        <div class="pull-right">                                            
                                            <button name="save" type="submit"  class="btn btn-success"></i>Change Password</button>
                                        </div>
                                        <button onclick="window.history.back();" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
            <?php include '../footer/footer.php'; ?>
            <div class="control-sidebar-bg"></div>
        </div>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <!-- Slimscroll -->
        <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="../plugins/fastclick/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="../dist/js/demo.js"></script>
        <!-- iCheck -->
        <script src="../plugins/iCheck/icheck.min.js"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

    </body>
</html>
