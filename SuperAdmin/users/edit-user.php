<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Edit User</title>
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
            if (isset($_POST['save'])) {
                $companyObject = new Company();
                $stateMessage = "";
                $id = $_GET['id'];
                $company = $_POST['company'];
                $user_type = $_POST['user_type'];
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $email = $_POST['email'];

                $companyObject->updateUserDetails($company, $user_type, $fname, $lname, $email,$id);

                 $stateMessage = "record updated successfully";
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
                                                Edit User
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
                                            $id = $_GET['id'];
                                            $Query = mysql_query(" SELECT * FROM users_tb WHERE id = '$id' ");
                                            $rows = mysql_fetch_array($Query);
                                            if (isset($_POST['save'])) {
                                                echo '<h3 style="color: green" class="box-title"><b>' . $stateMessage . '</b></h3> ';
                                            } else {
                                                echo '<h3 style="color: black" class="box-title"><b> Add User</b></h3> ';
                                            }
                                            ?>                                               
                                        </center>
                                    </div>
                                 
                                    <div class="box-body">
                                        <label>Company:</label>                                       
                                        <div class="form-group">
                                            <select name="company" class="form-control">
                                                <option value="<?php echo $rows['company_id']; ?>" ><?php 
                                                $compnayId= $rows['company_id'];
                                                $companyQuery = mysql_query("SELECT * FROM company where company_ID = '$compnayId'");
                                                $companyRow = mysql_fetch_array($companyQuery);
                                                echo $companyRow['name']; 
                                                
                                                ?></option>
                                                <?php
                                                $query = $companyObject->getCompanyLists();
                                                while ($row = mysql_fetch_array($query)) {
                                                    ?>                                               
                                                    <option value="<?php echo $row['company_ID']; ?>"> <?php echo $row['name']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>                                        
                                    </div>

                                    <div class="box-body">
                                        <label>User Type:</label>
                                        <div class="form-group">
                                            <select name="user_type" class="form-control">
                                                <option value="<?php echo $rows['user_type']; ?>"><?php echo $rows['user_type']; ?></option>
                                                <option value="superadmin">Super Admin</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>                                        
                                    </div>

                                    <div class="box-body">
                                        <label>First name:</label>
                                        <div class="form-group">                                            
                                            <input name="fname" value="<?php echo $rows['firstname']; ?>" placeholder="Enter users first name" class="form-control" >
                                        </div>                                        
                                    </div>

                                    <div class="box-body">
                                        <label>Last name:</label>
                                        <div class="form-group">                                            
                                            <input name="lname" value="<?php echo $rows['lastname']; ?>"placeholder="Enter Last name" class="form-control" >
                                        </div>                                         
                                    </div>

                                    <div class="box-body">
                                        <label>Email address:</label>
                                        <div class="form-group">                                            
                                            <input name="email" value="<?php echo $rows['email_address']; ?>" placeholder="Enter users email" id="datepicker" class="form-control" >
                                        </div>                                       
                                    </div>

                                    <div class="box-footer">
                                        <div class="pull-right">                                            
                                            <button name="save" type="submit"  class="btn btn-primary"></i>Update Record</button>
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
