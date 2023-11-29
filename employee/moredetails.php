<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HR and Payroll.</title>
    </title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

</head>

<body>



    <?php include 'navigation_panel/main_menu.php'; ?>





    <div class="content">

        <section class="content-header">
            <h1>

                <?php

                require_once('../PHPmailer/sendmail.php');
                $companyName = $_SESSION['company_name'];

                // echo $companyName . ", employee self service portal";
                ?>


            </h1>
        </section>
        <br>


        <style>
            .publishes {
                border: 2px solid black;
                margin: 1em;
                padding: 1em;
                color: black;
                width: 60%;
            }

            .bg-light-green {
                background-color: #8CC63F;
            }

            .container-fluid {
                max-height: 500px;
                /* Adjust this value to control the height of the container */
                overflow-y: scroll;
            }

            textarea {
                width: 100%;
                height: 100%;

            }

            .text {
                height: 12rem;
                position: relative;
                overflow: none;
            }
        </style>

        <div class="container-fluid" style="margin-top: -6rem;">
            <?php
            $id_ = $_GET["id"];

            $query = mysqli_query($link, "SELECT * FROM publications WHERE id = '$id_' ORDER BY date DESC") or die(mysqli_error($link));
            $rowCount = 0; // To keep track of the displayed rows

            while ($row = mysqli_fetch_array($query)) {
                $date = $row['date'];
                $subject = $row['subject'];
                $message = $row['message'];
                $files = $row['file'];
                $category = $row['category'];

                $color = '';
                if ($category == 'policy') {
                    $color = 'brown';
                } else if ($category == 'memo') {
                    $color = 'Green';
                } else {
                    $color = 'Blue';
                }

            ?>

            <?php  }   ?>

            <a class="btn btn-primary" style="list-style:none; text-decoration:none; color:WHITE; margin-left:0rem; margin-bottom:3rem;" href="./index.php">Back</a>
            <div class="row">
                <div class="col-lg-20">
                    <div class="panel panel-custom">
                        <div class="panel-heading panel-primary" style=" margin:5rem; padding:2rem ; position:relative;">
                            <strong style="margin:1.5rem;"> Catgory : <?php echo $category; ?> </strong> <br><br>
                            <strong style="margin:1.5rem;"> Date : <?php echo $date; ?> </strong> <br><br>
                            <strong style="margin:1.5rem;"> Subject : <?php echo $subject; ?> </strong>


                        </div>

                        <div class="spanel-body form-horizontal">
                            <div class="col-20 " style="margin:5rem; padding:2rem ; position:relative;">
                                <div class="panel">
                                    <div class="panel-heading m0 ">
                                        <strong>Category Details</strong>
                                        <div class="panel-body" style="height:20rem">
                                            <div class="">
                                                <textarea style="padding:10px; align-text:justify; width:100%; height:20rem;" readonly id=""> <?php echo $message; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <a class="btn btn-primary" style="list-style:none; text-decoration:none; color:WHITE; margin-left:3rem; margin-bottom:3rem; width:25rem;" href="../files/<?php echo $files ?>">View Attachment</a>
                                </div>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>

        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.5 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- Morris.js charts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="plugins/morris/morris.min.js"></script>
        <!-- Sparkline -->
        <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="plugins/knob/jquery.knob.js"></script>
        <!-- daterangepicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
        <script src="plugins/daterangepicker/daterangepicker.js"></script>
        <!-- datepicker -->
        <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <!-- Slimscroll -->
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="plugins/fastclick/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="dist/js/pages/dashboard.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>


</body>