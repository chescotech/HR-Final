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
                if (isset($_POST['update_profile'])) {
                $compId = $_SESSION['companyID'];
                $message = "";
                $name = $_POST['name'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
                $address = $_POST['address'];

                include_once '../../Admin/Classes/Company.php';
                $CompanyObject = new Company();

                $file = rand(10000000, 10000000) . "-" . $_FILES['file']['name'];
                $file_loc = $_FILES['file']['tmp_name'];
                $file_size = $_FILES['file']['size'];
                $file_type = $_FILES['file']['type'];
                $folder = "../../Admin/company_logos/";

                // image

                $Image_size = $_FILES['file']['size'];
                $Image_type = $_FILES['file']['type'];
                $Image_folder = "../uploads/";

                // new file size in KB
                $new_size = $file_size / 1024000;
                $image_size = $file_size / 1024000;
                // new file size in KB

                $new_file_name = strtolower($file);

                $final_file = str_replace(' ', '-', $new_file_name);
                if (move_uploaded_file($file_loc, $folder . $final_file)) {
                    $checkRecods = $CompanyObject->UpdateCompanyInfo($compId, $name, $phone, $email, $address, $final_file);
                } else {
                    $checkRecods = $CompanyObject->UpdateCompanyInfoWithoutLogo($compId, $name, $phone, $email, $address);
                }

                $message = "Company Information updated sucessfully !!!";
                
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
                                    $compId = $_SESSION['companyID'];
                                    $user_query = mysql_query("SELECT * FROM company where company_ID='$compId'") or die(mysql_error());
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
                                                $result = mysql_query("SELECT * FROM company where company_ID='$compId'") or die(mysql_error());
                                                $row = mysql_fetch_array($result);
                                                $companyName = $row['name'];
                                                echo $row['name'];
                                                ?> 
                                            </b></a>
                                    </p>

                                </div><!-- /.box-body -->
                            </div>
                        </div>
                       <div class="col-md-9">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <?php
                                    if (isset($_POST['update_profile'])) {
                                        echo ' <li class="active"><a data-toggle="tab"><h4 style="color: green"><b>' . $message . '</b></h4></a></li>';
                                    } else {
                                        echo '<li style="color: green" class="active"><a data-toggle="tab"><b>Company Information</b></a></li>';
                                    }
                                    ?>

                                </ul>
                                <div class="tab-content">

                                    <div class="active tab-pane" id="activity">
                                        <?php
                                        $compId = $_SESSION['companyID'];
                                        $sql = "SELECT * FROM company where company_ID='$compId'";
                                        $result2 = mysql_query($sql);
                                        $rows = mysql_fetch_array($result2);
                                        ?>

                                        <form method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Company Name</label>
                                                <div class="col-sm-5">
                                                    <input name="name"  value="<?php echo $rows['name']; ?>" class="form-control" id="inputName" >
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Phone No</label>
                                                <div class="col-sm-5">
                                                    <input name="phone"  value="<?php echo $rows['phone']; ?>" type="text" class="form-control" id="inputName">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                                <div class="col-sm-5">
                                                    <input name="email"  value="<?php echo $rows['email']; ?>" type="text" class="form-control" id="inputEmail">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail" class="col-sm-2 control-label">Physical Address</label>
                                                <div class="col-sm-5">
                                                    <input name="address"  value="<?php echo $rows['address']; ?>" type="text" class="form-control" id="inputEmail">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail" class="col-sm-2 control-label">Update Logo</label>
                                                <div class="col-sm-10">
                                                    <input name="file" type="file"/>  
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button name="update_profile" type="submit" class="btn btn-danger">Update Record</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
