<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Education Info</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include '../navigation_panel/authenticated_user_header.php';

        include_once '../Classes/Leave.php';
        $leaveObject = new Leave();

        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['upload'])) {
            $mssge = "";
            $date = date("Y-m-d");
            $employeeId = $_SESSION['employee_id'];
            $file = $employeeId . "-" . $_FILES['file']['name'];
            $file_loc = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $file_type = $_FILES['file']['type'];
            $folder = "../uploads/";

            $Image_size = $_FILES['file']['size'];
            $Image_type = $_FILES['file']['type'];
            $Image_folder = "../uploads/";

            $new_size = $file_size / 1024000;
            $image_size = $file_size / 1024000;

            $new_file_name = strtolower($file);

            $CV = str_replace(' ', '-', $new_file_name);

            // certificate ... 

            $file2 = $employeeId . "-" . $_FILES['certificate']['name'];
            $file_loc2 = $_FILES['certificate']['tmp_name'];
            $file_size2 = $_FILES['certificate']['size'];
            $file_type2 = $_FILES['certificate']['type'];
            $folder2 = "../uploads/";

            $Image_size2 = $_FILES['certificate']['size'];
            $Image_type2 = $_FILES['certificate']['type'];
            $Image_folder2 = "../uploads/";

            $new_size2 = $file_size / 1024000;
            $image_size2 = $file_size / 1024000;

            $new_file_name2 = strtolower($file2);

            $Certificate = str_replace(' ', '-', $new_file_name2);
            $imgExt = strtolower(pathinfo($new_file_name, PATHINFO_EXTENSION));
            $valid_extensions = array('pdf'); // valid extensions

            $imgExt2 = strtolower(pathinfo($new_file_name2, PATHINFO_EXTENSION));
            $valid_extensions2 = array('pdf'); // valid extensions

            if (in_array($imgExt, $valid_extensions) && in_array($imgExt2, $valid_extensions2)) {

                if (move_uploaded_file($file_loc, $folder . $CV) && move_uploaded_file($file_loc2, $folder2 . $Certificate)) {

                    mysqli_query($link, "INSERT INTO certificates_tb (cv,qualifications,date_uploaded,status,empno)"
                        . "VALUES ('$CV','$Certificate','$date','pending' ,'$employeeId')") or die(mysqli_error($link));
                    $mssge = "Upload Sucess";
        ?>
                <?php
                }
            } else {
                $mssge = "Only pdf uploads accepted !!";
                ?>
        <?php
            }
        }
        ?>

        <div class="content-wrapper">
            <section class="content-header">
            </section>
            <section class="content">
                <div class="row">
                    <?php include 'employee-workhist-menu.php'; ?>
                    <div class="col-md-9">
                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">

                                    <?php
                                    if (isset($_POST['upload'])) {
                                        if ($mssge == "Upload Sucess") {
                                            echo ' <center>
                                               <h3 style="color: green" class="box-title"><b>' . $mssge . '</b></h3>
                                               </center>';
                                        } else {
                                            echo ' <center>
                                                <h3 style="color: red" class="box-title"><b>' . $mssge . '</b></h3>
                                                </center>';
                                        }
                                    } else {
                                        echo ' <center>
                                            <h3 style="color: black" class="box-title"><b>Upload Nessecary Documents</b></h3>
                                        </center>';
                                    }
                                    ?>
                                </div>
                                <div class="box-body">
                                    <?php
                                    $employeeId = $_SESSION['employee_id'];
                                    $cv = "../uploads/" . $leaveObject->checkIfCvExsists($employeeId);

                                    if (file_exists($cv) && $leaveObject->checkIfCvExsists($employeeId) != "") {

                                        echo ' <embed src="' . $cv . '" width="100%"  />';
                                    } else {
                                        echo 'No CV Found<br>';
                                    }

                                    ?>

                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <h5 style="color: black"><b>Upload CV</b></h5>
                                        <input required="required" type="file" name="file">
                                    </div>
                                    <div class="box-body">
                                        <?php

                                        $certificate = "../uploads/" . $leaveObject->checkIfCertificateExsists($employeeId);

                                        if (file_exists($certificate) && $leaveObject->checkIfCertificateExsists($employeeId) != "") {

                                            echo ' <embed src="' . $certificate . '" width="100%"  />';
                                        } else {
                                            echo 'No Certificate Found<br>';
                                        }
                                        ?>

                                    </div>
                                    <div class="form-group">
                                        <h5 style="color: black"><b>Upload Certificate</b></h5>
                                        <input required="required" type="file" name="certificate">
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>
                                        <button name="upload" type="submit" class="btn btn-primary"></i>Upload</button>
                                    </div>
                                    <button class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <?php include '../footer/footer.php'; ?>

        <div class="control-sidebar-bg"></div>
    </div>

    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>

</body>

</html>