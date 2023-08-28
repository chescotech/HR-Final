<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Edit Company</title>
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

        <script>
            $(function () {
                $("#datepicker").datepicker();              
            });
        </script>

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
            if (isset($_POST['save'])) {
                $companyObject = new Company();
                $Id = $_GET['id'];
                $stateMessage = "";
               
                $companyName = $_POST['name'];
                $address = $_POST['address'];
                $phone = $_POST['phone'];                
                $email = $_POST['email'];
                
                $date_registration = $_POST['date_registration'];
                
                $file = rand(10000000, 10000000) . "-" . $_FILES['file']['name'];
                $file_loc = $_FILES['file']['tmp_name'];
                $file_size = $_FILES['file']['size'];
                $file_type = $_FILES['file']['type'];
                $folder = "../../Admin/company_logos/";

                // image

                $Image_size = $_FILES['file']['size'];
                $Image_type = $_FILES['file']['type'];
                $Image_folder = "../../Admin/company_logos/";

                // new file size in KB
                $new_size = $file_size / 1024000;
                $image_size = $file_size / 1024000;
                // new file size in KB

                $new_file_name = strtolower($file);

                $final_file = str_replace(' ', '-', $new_file_name);
                if (move_uploaded_file($file_loc, $folder . $final_file)) {
                     $companyObject->updateCompanyRecordWithLogo($companyName, $address, $phone, $email, $date_registration, $Id,$final_file);
                } else {
                    $companyObject->updateCompanyRecord($companyName, $address, $phone, $email, $date_registration, $Id);
                }
               
                $stateMessage = "Record Successully Updated !!";
                
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
                                    <?php
                                    $id = $_GET['id'];
                                    $user_query = mysql_query("SELECT * FROM company where company_ID='$id'") or die(mysql_error());
                                    while ($row = mysql_fetch_array($user_query)) {
                                        $id = $row['company_ID'];
                                        ?>
                                        <?php
                                        $photo = "../../Admin/company_logos/" . $row['logo'];
                                        $check_pic = $row['logo'];
                                        if (!file_exists($photo) || $check_pic == false) {
                                            $photo = "../../Admin/company_logos/logo.png";
                                        }
                                        ?>
                                        <img src="<?php echo $photo; ?>" width="100%">

                                        <?php
                                    }
                                    ?>
                                    <br> </br> 
                                    <p class="text-muted text-center">
                                        <a class="btn btn-primary btn-block"><b>

                                                <?php
                                                $result = mysql_query("SELECT * FROM company where company_ID='$id'") or die(mysql_error());
                                                $row = mysql_fetch_array($result);
                                                $companyName = $row['name'];
                                                echo $row['name'];
                                                ?> 
                                            </b></a>
                                    </p>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <div class="col-md-5">
                            <form enctype="multipart/form-data" method="post" >
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <center>
                                            <?php
                                            $query = mysql_query(" SELECT * FROM company WHERE company_ID = '$id'");
                                            $row = mysql_fetch_array($query);

                                            if (isset($_POST['save'])) {
                                                echo '<h3 style="color: green" class="box-title"><b>' . $stateMessage . '</b></h3> ';
                                            } else {
                                                echo '<h3 style="color: black" class="box-title"><b>Edit Record</b></h3> ';
                                            }
                                            ?>                                               
                                        </center>
                                    </div>
                                    <div class="box-body">
                                        <label>Company Name:</label>
                                        <div class="form-group">                                             
                                            <input value="<?php echo $row['name']; ?>" name="name" class="form-control" >
                                        </div>                                        
                                    </div>

                                    <div class="box-body">
                                        <label>Address:</label>
                                        <div class="form-group">                                           
                                            <input name="address" value="<?php echo $row['address']; ?>" class="form-control" >
                                        </div>                                        
                                    </div>

                                    <div class="box-body">
                                        <label>Phone Number:</label>
                                        <div class="form-group">                                           
                                            <input name="phone" value="<?php echo $row['phone']; ?>" class="form-control" >
                                        </div>                                        
                                    </div>

                                    <div class="box-body">
                                        <label>Email address:</label>
                                        <div class="form-group">                                            
                                            <input name="email" value="<?php echo $row['email']; ?>" class="form-control" >
                                        </div>                                        
                                    </div>

                                    <div class="box-body">
                                        <label>Date Of Registration:</label>
                                        <div class="form-group">                                            
                                            <input name="date_registration" id="datepicker" value="<?php echo $row['date_registration']; ?>" class="form-control" >
                                        </div>                                        
                                    </div>

                                    <div class="box-body">
                                        <label>Update Logo:</label>
                                        <div class="form-group">                                            
                                            <input name="file" type="file">
                                        </div>                                        
                                    </div>

                                    <div class="box-footer">
                                        <div class="pull-right">                                            
                                            <button name="save" type="submit"  class="btn btn-danger"></i>Update Record</button>
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
        
        <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    </body>
</html>
