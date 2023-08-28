<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Add User</title>
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
            if (isset($_POST['save'])){
                
                $companyObject = new Company();
                $stateMessage = "";

                $username = $_POST['username'];
                $password = $_POST['password'];
                $company = $_SESSION['companyID'];
                $user_type = $_POST['user_type'];
                $empno = $_POST['empno'];
              
                $companyObject->adduser($username, $password, $company, $user_type, $empno);

                $stateMessage = "user added successfully";
                                
                ?>

                <?php
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
                                                Add User
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
                                                echo '<h3 style="color: green" class="box-title"><b>' . $stateMessage . '</b></h3> ';
                                            } else {
                                                echo '<h3 style="color: black" class="box-title"><b> Add User</b></h3> ';
                                            }
                                            ?>                                               
                                        </center>
                                    </div>
                                    <div class="box-body">
                                        <label>User Name:</label>
                                        <div class="form-group">                                             
                                            <input name="username" placeholder="Enter username for user" class="form-control" >
                                        </div>                                        
                                    </div>

                                    <div class="box-body">
                                        <label>Password:</label>
                                        <div class="form-group">                                           
                                            <input name="password" type="password" placeholder="Enter password" class="form-control" >
                                        </div>                                        
                                    </div>
                                    <div class="box-body">
                                        <label>User Type:</label>
                                        <div class="form-group">
                                            <select name="user_type" class="form-control">
                                                <option>--Select User Type--</option>
                                                <option value="Admin">Company Admin</option>
                                                <option value="HR Admin">HR Admin</option>
                                                <option value="Payroll Admin">Payroll Admin</option>
                                            </select>
                                        </div>                                        
                                    </div>

                                    <div class="box-body">
                                        <label>Employees Details:</label>
                                        <div class="form-group">
                                            <select name="empno" class="form-control">
                                                <option>--Select Employee--</option>
                                                <?php
                                                $query = $companyObject->getEmployeeListByCompany($companyId);
                                                while ($row = mysql_fetch_array($query)) {
                                                    ?>                                               
                                                    <option value="<?php echo $row['empno']; ?>"> <?php echo $row['fname']." ".$row['lname']." - ".$row['position']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>                                        
                                    </div>

                                    <div class="box-footer">
                                        <div class="pull-right">                                            
                                            <button name="save" type="submit"  class="btn btn-primary"></i>Save</button>
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
        </div><!-- ./wrapper -->


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
