<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Applicant's CV</title>
    </title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../bootstrap-5.1.3-dist/css/bootstrap-grid.css">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../../../dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../../plugins/iCheck/flat/blue.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../../DataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>

    <!-- Morris chart -->
    <link rel="stylesheet" href="../../../plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../../../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="../../../plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../../plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="previe-style.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <a href="" class="logo">
                <span class="logo-lg"><b>

                        <?php
                        // error_reporting(0);
                        session_start();
                        // $_SESSION['activeLink'] = 'jobs';

                        if (isset($_SESSION['job_username'])) {
                        } else {
                            echo "<script> window.location='../jobs/login.php' </script>";
                        }
                        ?>


                    </b></span>
            </a>
            <?php include '../../navigation_panel/main_menu.php'; ?>
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

                <?php include '../../navigation_panel/authenticated_side_navigation_bar.php'; ?>

            </section>
        </aside>

        <?php //include 'form-list.php'; 
        ?>




        <div class="content-wrapper">


            <?php
            // Get applicant's info
            $user_id = $_GET['user_id'];
            $gt_app_q = mysqli_query($link, "SELECT * FROM jobs_users WHERE id = '$user_id' ") or die(mysqli_error($link));
            $gt_app_r = mysqli_fetch_array($gt_app_q);

            $fname = $gt_app_r['fname'];
            $lname = $gt_app_r['lname'];
            $username = $gt_app_r['username'];
            $email = $gt_app_r['email'];
            $phone = $gt_app_r['phone'];
            $dob = $gt_app_r['dob'];
            $gender = $gt_app_r['gender'];

            $full_names = $fname . " " . $lname;
            if (isset($_POST['add_skill'])) {
                $category = $_POST['category'];
                $name = $_POST['name'];
                $level = $_POST['level'];

                $add_q = mysqli_query($link, "INSERT INTO jobs_user_skills (category, name,level,user_id)
            VALUES('$category', '$name','$level','$user_id')") or die(mysqli_error($link));

                if ($add_q) {
                    echo "<script> alert('Added Successfuly') </script>";
                    echo "<script> window.location='skills' </script>";
                }
            }
            if (isset($_POST['update'])) {
                $category = $_POST['category'];
                $name = $_POST['name'];
                $level = $_POST['level'];

                $id = $_POST['id'];

                $add_q = mysqli_query($link, "UPDATE jobs_user_skills SET category = '$category', name = '$name',level='$level'
            WHERE id = '$id' ") or die(mysqli_error($link));

                if ($add_q) {
                    echo "<script> alert('Updated Successfuly') </script>";
                    echo "<script> window.location='skills' </script>";
                }
            }
            if (isset($_POST['delete'])) {
                $id = $_POST['id'];

                $add_q = mysqli_query($link, "DELETE FROM jobs_user_skills WHERE id = '$id' ") or die(mysqli_error($link));

                if ($add_q) {
                    echo "<script> alert('Deleted Successfuly') </script>";
                    echo "<script> window.location='skills' </script>";
                }
            }
            ?>

            <section class="content container">
                <div class="row center">
                    <div class="col-md-11">
                        <!-- Page Container -->
                        <div class="w3-content" style="max-width:1400px; margin-top:56px">
                            <!-- The Grid -->
                            <div class="w3-row-padding">
                                <!-- Left Column -->
                                <div class="w3-third">
                                    <div class="w3-white w3-text-grey w3-card-4">
                                        <div class="w3-display-container">
                                            <!-- <img src="/w3images/avatar_hat.jpg" style="width:100%" alt="Avatar"> -->
                                            <div class="w3-display-bottomleft w3-container w3-text-black">
                                                <h2><?php echo $full_names ?>'s CV</h2>
                                            </div>
                                        </div>
                                        <div class="w3-container">
                                            <br>

                                            <?php
                                            $empQuery = mysqli_query($link, "SELECT * FROM jobs_user_info where user_id='$user_id' ") or die(mysqli_error($link));
                                            // echo mysqli_num_rows($empQuery);
                                            while ($empRows = mysqli_fetch_array($empQuery)) {
                                                // Other Info
                                                $location = $empRows['location'];
                                                $lang1 = $empRows['lang1'];
                                                $lang2 = $empRows['lang2'];
                                                $lang3 = $empRows['lang3'];
                                                $marital_status = $empRows['marital_status'];
                                                $disabilities = $empRows['disabilities'];
                                                $memberships = $empRows['memberships'];
                                                $awards = $empRows['awards'];
                                                $links = $empRows['links'];
                                                $salary = $empRows['salary'];
                                                $currency = $empRows['currency'];
                                                $expected_benefits = $empRows['expected_benefits'];
                                                $notice_period = $empRows['notice_period'];
                                                $can_relocate = $empRows['can_relocate'];
                                                $can_travel = $empRows['can_travel'];
                                            }
                                            ?>
                                            <!-- <p><i class="fa fa-briefcase fa-fw w3-margin-right w3-large w3-text-blue"></i>Designer</p> -->
                                            <p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-blue"></i> <?php echo $location ?> </p>
                                            <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-blue"></i> <?php echo $email ?> </p>
                                            <p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-blue"></i> <?php echo $phone ?> </p>
                                            <p><i class="fa fa-calendar-minus-o fa-fw w3-margin-right w3-large w3-text-blue"></i> <?php echo $dob ?> </p>
                                            <p><i class="fa fa-venus-mars fa-fw w3-margin-right w3-large w3-text-blue"></i> <?php echo $gender ?> </p>
                                            <hr>

                                            <p class="w3-large w3-text-theme"><b><i class="fa fa-globe fa-fw w3-margin-right w3-text-blue"></i>Languages</b></p>
                                            <p></p>
                                            <div class="w3-light-grey w3-round-xlarge">
                                                <div class="w3-round-xlarge w3-center w3-blue" style="height:24px;width:90%"><?php echo $lang1 ?></div>
                                            </div>
                                            <p></p>
                                            <div class="w3-light-grey w3-round-xlarge">
                                                <div class="w3-round-xlarge w3-center w3-blue" style="height:24px;width:90%"><?php echo $lang2 ?></div>
                                            </div>
                                            <p></p>
                                            <div class="w3-light-grey w3-round-xlarge">
                                                <div class="w3-round-xlarge w3-center w3-blue" style="height:24px;width:90%"><?php echo $lang3 ?></div>
                                            </div>
                                            <br>

                                            <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-blue"></i>Skills</b></p>

                                            <?php
                                            // Skillz
                                            $skillsQuery = mysqli_query($link, "SELECT * FROM jobs_user_skills WHERE user_id = '$user_id' ") or die(mysqli_error($link));
                                            while ($skillsRow = mysqli_fetch_array($skillsQuery)) {
                                                $category = $skillsRow['category'];
                                                $name = $skillsRow['name'];
                                                $level = $skillsRow['level'];

                                                $lvl = '';
                                                if ($level == 'Expert') {
                                                    $lvl = "width:100%";
                                                } elseif ($level == 'Intermediate') {
                                                    $lvl = "width:55%";
                                                } elseif ($level == 'Beginner') {
                                                    $lvl = "width:20%";
                                                }
                                            ?>
                                                <p><?php echo $name . " - " . $category ?></p>
                                                <div class="w3-light-grey w3-round-xlarge w3-small">
                                                    <div class="w3-container w3-center w3-round-xlarge w3-blue" style="<?php echo $lvl ?>"><?php echo $level ?></div>
                                                </div>
                                            <?php } ?>
                                            <br>

                                            <p class="w3-large"><b><i class="fa fa-paperclip fa-fw w3-margin-right w3-text-blue"></i>Attachments</b></p>

                                            <?php
                                            // Skillz
                                            $attachQuery = mysqli_query($link, "SELECT * FROM jobs_user_attachments WHERE user_id = '$user_id' ") or die(mysqli_error($link));
                                            while ($attachRow = mysqli_fetch_array($attachQuery)) {
                                                $name = $attachRow['name'];
                                                $file = $attachRow['file'];
                                            ?>
                                                <p><?php //echo $name . " - " . $category 
                                                    ?></p>
                                                <p>
                                                    <a href="../../../attachments/<?php echo $file ?>">
                                                        <i class="fa fa-download fa-fw w3-margin-right w3-large w3-text-blue"></i>
                                                    </a>
                                                    <?php echo $name ?>
                                                </p>

                                                <!-- <div class="w3-light-grey w3-round-xlarge w3-small">
                                                    <div class="w3-container w3-center w3-round-xlarge w3-blue" style="<?php echo $lvl ?>"><?php echo $level ?></div>
                                                </div> -->
                                            <?php } ?>
                                            <br>

                                        </div>
                                    </div><br>

                                    <!-- End Left Column -->
                                </div>

                                <!-- Right Column -->
                                <div class="w3-twothird">

                                    <div class="w3-container w3-card w3-white w3-margin-bottom">
                                        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-blue"></i>Work Experience</h2>

                                        <?php
                                        // Work Xperience
                                        $experienceQuery = mysqli_query($link, "SELECT * FROM jobs_user_experience WHERE user_id = '$user_id' ") or die(mysqli_error($link));
                                        while ($experienceRow = mysqli_fetch_array($experienceQuery)) {
                                            $employer = $experienceRow['employer'];
                                            $comp_name = $experienceRow['comp_name'];
                                            $phone = $experienceRow['phone'];
                                            $position = $experienceRow['position'];
                                            $starts = date("d M, Y", strtotime($experienceRow['starts']));
                                            $ends = date("d M, Y", strtotime($experienceRow['ends']));
                                            $reasons_for_leavng = $experienceRow['reasons_for_leavng'];
                                            $duties = $experienceRow['duties'];
                                            $achievement = $experienceRow['achievement'];
                                        ?>
                                            <div class="w3-container">
                                                <h5 class="w3-opacity"><b><?php echo $position ?> at <?php echo $comp_name ?></b></h5>
                                                <h6 class="w3-text-blue"><i class="fa fa-calendar fa-fw w3-margin-right"></i><?php echo $starts ?> - <?php echo $ends ?> </h6>

                                                <p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-blue"></i> <?php echo $phone ?> </p>

                                                <p>My duties here includes: <u> <?php echo $duties ?> </u> </p>
                                                <p>My achievements while working here included: <u> <?php echo $achievement ?> </u> </p>
                                                <p>Why I left this job: <u> <?php echo $reasons_for_leavng ?> </u> </p>
                                                <hr>
                                            </div>
                                        <?php } ?>
                                        <br>

                                    </div>
                                    <div class="w3-container w3-card w3-white">
                                        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-graduation-cap fa-fw w3-margin-right w3-xxlarge w3-text-blue"></i>Education</h2>
                                        <div class="w3-container">
                                            <?php
                                            // names - Accademic stuff
                                            $qualificationsQuery = mysqli_query($link, "SELECT * FROM jobs_user_qualifications WHERE user_id = '$user_id' ") or die(mysqli_error($link));
                                            while ($qualificationsRow = mysqli_fetch_array($qualificationsQuery)) {
                                                $school = $qualificationsRow['school'];
                                                $qualification = $qualificationsRow['qualification'];
                                                $award = $qualificationsRow['award'];
                                                $q_starts = date("d M, Y", strtotime($qualificationsRow['starts']));
                                                $q_ends = date("d M, Y", strtotime($qualificationsRow['ends']));
                                            ?>
                                                <div class="w3-container">
                                                    <h5 class="w3-opacity"><b><?php echo $qualification ?> at <?php echo $school ?></b></h5>
                                                    <h6 class="w3-text-blue"><i class="fa fa-calendar fa-fw w3-margin-right"></i><?php echo $q_starts ?> - <?php echo $q_ends ?> </h6>

                                                    <p><i class="fa fa-trophy fa-fw w3-margin-right w3-large w3-text-blue"></i> <?php echo $award ?> </p>

                                                    <hr>
                                                </div>
                                            <?php } ?>
                                            <br>
                                            <hr>
                                        </div>
                                    </div>

                                    <div class="w3-container w3-card w3-white">
                                        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-external-link fa-fw w3-margin-right w3-xxlarge w3-text-blue"></i>References</h2>
                                        <div class="w3-container">
                                            <?php
                                            // Qualifications - Accademic stuff
                                            $refsQuery = mysqli_query($link, "SELECT * FROM jobs_user_refs WHERE user_id = '$user_id' ") or die(mysqli_error($link));
                                            while ($refsRow = mysqli_fetch_array($refsQuery)) {
                                                $ref_name = $refsRow['name'];
                                                $ref_gender = $refsRow['gender'];
                                                $ref_position = $refsRow['position'];
                                                $ref_company = $refsRow['company'];
                                                $ref_country = $refsRow['country'];
                                                $ref_province = $refsRow['province'];
                                                $ref_town = $refsRow['town'];
                                                $ref_phone = $refsRow['phone'];
                                                $ref_email = $refsRow['email'];
                                                $ref_address = $refsRow['address'];
                                            ?>
                                                <div class="w3-container">
                                                    <h5 class="w3-opacity"><b><?php echo $ref_name ?> - <?php echo $ref_position ?> at <?php echo $ref_company ?> </b></h5>

                                                    <p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-blue"></i> <?php echo $ref_phone ?> </p>
                                                    <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-blue"></i> <?php echo $ref_email ?> </p>
                                                    <p><i class="fa fa-map-marker fa-fw w3-margin-right w3-large w3-text-blue"></i> <?php echo $ref_address . ", " . $ref_town ?> </p>
                                                    <p><i class="fa fa-globe fa-fw w3-margin-right w3-large w3-text-blue"></i> <?php echo $ref_country ?> </p>
                                                    <!-- <p><i class="fa fa-trophy fa-fw w3-margin-right w3-large w3-text-blue"></i> <?php echo $ref_province ?> </p> -->

                                                    <hr>
                                                </div>
                                            <?php } ?>
                                            <br>
                                            <hr>
                                        </div>
                                    </div>


                                    <!-- End Right Column -->
                                </div>

                                <!-- End Grid -->
                            </div>

                            <!-- End Page Container -->
                        </div>


                    </div>

            </section>

        </div>



        <?php include '../../../footer/footer.php'; ?>

        <div class="control-sidebar-bg"></div>
    </div>
    <!-- <script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script> -->

    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../../bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="../../../plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="../../../plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="../../../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="../../../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../../../plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="../../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="../../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="../../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="../../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../../../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../../../dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../../dist/js/demo.js"></script>
</body>

</html>