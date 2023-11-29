<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="attendance, client management, finance, freelance, freelancer, goal tracking, Income Managment, lead management, payroll, project management, project manager, support ticket, task management, timecard">
    <meta name="keywords" content="	attendance, client management, finance, freelance, freelancer, goal tracking, Income Managment, lead management, payroll, project management, project manager, support ticket, task management, timecard">
    <title>Job Details</title>
    <!-- =============== VENDOR STYLES ===============-->
    <!-- FONT AWESOME-->
    <link rel="stylesheet" href="https://ziscoerp.com/assets/plugins/fontawesome/css/font-awesome.min.css">

    <!-- =============== PAGE VENDOR STYLES ===============-->

    <!-- =============== APP STYLES ===============-->
    <!-- =============== BOOTSTRAP STYLES ===============-->
    <link rel="stylesheet" href="https://ziscoerp.com/assets/css/bootstrap.min.css" id="bscss">
    <link rel="stylesheet" href="https://ziscoerp.com/assets/css/app.css" id="maincss">
    <link id="autoloaded-stylesheet" rel="stylesheet" href="https://ziscoerp.com/assets/css/bg-white.css">

    <!-- 

    <link rel="stylesheet" href="https://ziscoerp.com/assets/css/timepicker.min.css">

    <link href="https://ziscoerp.com/assets/plugins/summernote/summernote.min.css" rel="stylesheet" type="text/css"> -->

    <script data-require="jquery@*" data-semver="2.2.0" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script data-require="bootstrap@*" data-semver="3.3.6" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link data-require="bootstrap-css@3.3.6" data-semver="3.3.6" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" />

</head>

<body class="layout-h">
    <div class="wrapper">
        <!-- top navbar-->
        <style type="text/css">
            .topnavbar .navbar-header {
                background-image: none;
                background-color: transparent;
                background-repeat: no-repeat;
                filter: none;
            }
        </style>
        <header class="topnavbar-wrapper">
            <!-- START Top Navbar-->
            <nav role="navigation" class="navbar topnavbar" style="background-color:#3c8dbc;">
                <!-- START navbar header-->
                <div class="navbar-header">

                </div>
                <!-- END navbar header-->
                <!-- START Nav wrapper-->
                <div class="navbar-collapse collapse">
                    <!-- START Left navbar-->
                    <ul class="nav navbar-nav" style=" font-family: Arial, Helvetica, sans-serif, solaimanlipi;">
                        <li><a style="color: #eee!important" href="jobs.php">All Postings</a></li>
                        <li class="pull-right"><a style="color: #eee!important" href="jobs/login">Login</a></li>
                    </ul>
            </nav>
            <!-- END Top Navbar-->
        </header> <!-- Main section-->

        <?php

        include_once("include/dbconnection.php");
        $id_ = $_GET['job'];
        $query = "SELECT * FROM postings 
            LEFT JOIN department ON department.dep_id = postings.dep_id
            WHERE id = '$id_' ";
        // return var_dump($query);
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        while ($row = mysqli_fetch_array($result)) {
            $title = $row['title'];
            $department = $row['department'];
            $vacancies = $row['vacancies'];
            $type = $row['type'];
            $experience = $row['experience'];

            $info =  $row['info'];
            $qualifications = $row['qualifications'];
            $status = $row['status'];
            $rawdate = $row['date'];
            $date = date("d M, Y", strtotime($rawdate));
            $rawExpires = $row['expires'];
            $expires = date("d M, Y", strtotime($rawExpires));
        }
        ?>

        <section>
            <!-- Page content-->
            <div class="content-wrapper">

                <div class="row">
                    <div class="col-lg-12">

                        <div class="panel panel-custom">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <strong>Job Details</strong>
                                </div>
                            </div>
                            <div class="panel-body form-horizontal">
                                <p>
                                    <strong style="font-size: 20px;"><?php echo $title . " (" . $department . ")"; ?></strong>
                                </p>
                                <div class="col-sm-8">
                                    <p class="m0">
                                        <strong>Experience: <?php echo $experience; ?></strong>

                                    </p>


                                    <p class="m0">
                                        <strong>Vacancy: <?php echo $vacancies; ?></strong>

                                    </p>
                                    <p class="m0">
                                        <strong>Job Type : <?php echo $type; ?></strong>

                                    </p>
                                    <p class="m0">
                                        <strong> Posted Date : <?php echo $date; ?></strong>
                                    </p>
                                    <p>

                                        <strong> Last Date : <?php echo $expires; ?> </strong>
                                    </p>

                                    <!-- <div style="width:300px"> -->
                                    <div class="job_des" style="color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif, solaimanlipi;">
                                        <h5 style="font-weight: bold; color: rgb(92, 92, 92); margin: 20px 0px 6px;">Job Description</h5>
                                        <!-- <?php echo $info; ?> -->
                                        <div class=""> <textarea readonly style="padding:10px" cols="35" rows="15"><?php echo $info; ?></textarea> </div>

                                    </div>
                                    <div class="job_nat" style="color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif, solaimanlipi;">
                                        <h5 style="font-weight: bold; color: rgb(92, 92, 92); margin: 20px 0px 6px;">Job Type</h5>
                                        <p style="margin-bottom: 0px; padding: 0px 0px 0px 20px; line-height: 24px; color: rgb(92, 92, 92);"><?php echo $type; ?></p>
                                    </div>
                                    <div class="edu_req" style="color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif, solaimanlipi;">
                                        <h5 style="font-weight: bold; color: rgb(92, 92, 92); margin: 20px 0px 6px;">Qualifications</h5>
                                        <ul style="margin-right: 0px; margin-bottom: 0px; margin-left: 40px; padding: 0px;"><?php echo $qualifications; ?></ul>
                                    </div>
                                    <div class="edu_req" style="color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif, solaimanlipi;">
                                        <h5 style="font-weight: bold; color: rgb(92, 92, 92); margin: 20px 0px 6px;">Experience Requirements</h5>
                                        <ul style="margin-right: 0px; margin-bottom: 0px; margin-left: 40px; padding: 0px;">
                                            <li style="color: rgb(92, 92, 92); line-height: 24px; padding-bottom: 5px;"><?php echo $experience; ?> </li>
                                        </ul>
                                    </div>
                                    <div class="job_req" style="color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif, solaimanlipi;">
                                        <h5 style="font-weight: bold; color: rgb(92, 92, 92); margin: 20px 0px 6px;">Job Requirements</h5>
                                        <div class=""> <textarea readonly style="padding:10px" cols="35" rows="15"><?php echo $info; ?></textarea> </div>
                                    </div>
                                    <!-- </div> -->
                                </div>

                                <div class="col-md-4">
                                    <div class="panel " style="border: none">
                                        <div class="panel-heading m0 job_summery">
                                            <strong>Job Summery</strong>
                                        </div>
                                        <div class="panel-body" style="background-color: #f5f5f5;">
                                            <p class="m0">
                                                <strong>Job Title: <?php echo $title; ?></strong>

                                            </p>
                                            <p class="m0">
                                                <strong>Department: <?php echo $department; ?></strong>

                                            </p>
                                            <p class="m0">
                                                <strong>Experience: <?php echo $experience; ?></strong>

                                            </p>

                                            <p class="m0">
                                                <strong>No. of Vacancies: <?php echo $vacancies; ?></strong>
                                            </p>
                                            <p class="m0">
                                                <strong>Job Type : <?php echo $type ?></strong>

                                            </p>
                                            <p class="m0">
                                                <strong> Posted Date : <?php echo $date; ?> </strong>
                                            </p>
                                            <p>

                                                <strong> Last Date : <?php echo $expires; ?> </strong>
                                            </p>

                                        </div>

                                    </div>

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
                                        Apply Now
                                    </button>
                                    <!-- <a class="btn btn-primary btn-block" href="jobs/login">Apply Now</a> -->

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">

                                                <div class="modal-body">

                                                    <div class="panel panel-custom">
                                                        <div class="panel-heading">
                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                                            <div class="panel-title">
                                                                <strong>Apply for <?php echo $title ?> </strong>
                                                            </div>
                                                        </div>
                                                        <div class="panel-body form-horizontal">
                                                            <form method="post" action="#apply" class="form-horizontal" enctype="multipart/form-data">
                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label">Name <span class="required"> *</span></label>
                                                                    <div class="col-sm-8">
                                                                        <div class="input-group">
                                                                            <!-- <span class="input-group-addon" id=""><i class="fa fa-user"></i></span> -->
                                                                            <input required="" type="text" name="name" class="form-control" placeholder="Enter Full Name">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label">Email <span class="required"> *</span></label>
                                                                    <div class="col-sm-8">
                                                                        <div class="input-group">
                                                                            <!-- <span class="input-group-addon" id=""><i class="fa fa-envelope"></i></span> -->
                                                                            <input required="" type="text" data-parsley-type="email" name="email" class="form-control" placeholder="Enter Email Address">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label">Mobile <span class="required"> *</span></label>
                                                                    <div class="col-sm-8">
                                                                        <div class="input-group">
                                                                            <!-- <span class="input-group-addon" id=""><i class="fa fa-phone"></i></span> -->
                                                                            <input required="" type="text" data-parsley-type="number" name="mobile" class="form-control" placeholder="Enter Mobile Number ">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label">Cover Letter </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <span class="">
                                                                                <span class="fileinput-exists">Change</span>
                                                                                <input required="" type="file" name="cover">
                                                                            </span>
                                                                            <span class="fileinput-filename"></span>
                                                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none;">×</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label">Resume <span class="required"> *</span></label>
                                                                    <div class="col-sm-9">
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <span class="">
                                                                                <span class="fileinput-exists">Change</span>
                                                                                <input required="" type="file" name="cv">
                                                                            </span>
                                                                            <span class="fileinput-filename"></span>
                                                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none;">×</a>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="margin pull-right">
                                                                    <button name="apply" type="submit" class="btn btn-primary btn-block"> Save</button>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Page footer-->

        <?php
        // Apply Logic
        if (isset($_POST['apply'])) {
            $name = ($_POST['name']);
            $email = ($_POST['email']);
            $mobile = ($_POST['mobile']);
            $cover = $_FILES["cover"]["name"];
            $cv = $_FILES["cv"]["name"];
            // return var_dump($cv);
            // upload cover letter
            $target_dir = "files/covers/";
            $target_file = $target_dir . basename($cover);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (move_uploaded_file($_FILES["cover"]["tmp_name"], $target_file)) {
                echo "Cover Letter has been uploaded.";
            } else {
                return "Sorry, there was an error uploading your file.";
            }
            // upload CV
            $target_dir = "files/cv/";
            $target_file = $target_dir . basename($cv);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file)) {
                echo "CV has been uploaded.";
            } else {
                return "Sorry, there was an error uploading your file.";
            }

            $q = mysqli_query($link, "INSERT INTO applications (`posting_id`, `name`, `email`, `mobile`, `cover`, `cv`,`status`) 
                                VALUES ('$id_', '$name', '$email', '$mobile', '$cover', '$cv','Unread')") or die("Err. " . mysqli_error($link));

            echo "<script> alert('Application sent successfully.')</script>";
        }
        ?>

    </div>


    <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
    <script>
        $('.modal-content').resizable({
            //alsoResize: ".modal-dialog",
            minHeight: 300,
            minWidth: 300
        });
        $('.modal-dialog').draggable();

        $('#myModal').on('show.bs.modal', function() {
            $(this).find('.modal-body').css({
                'max-height': '100%'
            });
        });
    </script>
</body>

</html>