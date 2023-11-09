<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Applicant's CV</title>
    </title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <!-- <link rel="stylesheet" href="/jobs/assets/bootstrap-5.0.2-dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <!-- <link rel="stylesheet" type="text/css" href="/jobs/bootstrap/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="../../../bootstrap-5.1.3-dist/css/bootstrap-grid.css"> -->
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
            <!-- <a href="" class="logo"> -->
            <span class="logo-lg"><b>

                    <?php
                    // error_reporting(0);
                    session_start();
                    // $_SESSION['activeLink'] = 'jobs';

                    if (isset($_SESSION['comp_username'])) {
                    } else {
                        echo "<script> window.location='../../../login.php' </script>";
                    }
                    ?>


                </b></span>
            </a>
            <?php include '../../navigation_panel/main_menu.php'; ?>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar" style="margin-top: 64px;">
                <!-- <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form> -->

                <?php include '../../navigation_panel/authenticated_side_navigation_bar.php'; ?>

            </section>
        </aside>

        <?php //include 'form-list.php'; 
        ?>




        <div class="content-wrapper">


            <?php
            // Get applicant's info
            $user_id = $_GET['user_id'];
            $job_id = $_GET['job_id'];
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
            if (isset($_POST["update_pool"])) {
                $pool_id = $_POST["pool_id"];
                $app_id = $_POST["app_id"];
                $job_id = $_POST['job'];
                // echo $job_id;
                //return var_dump($job_id,$app_id);

                mysqli_query($link, "UPDATE jobs_user_applications SET talent_pool_id = '$pool_id' WHERE  user_id='$app_id' AND jobs_user_applications.id='$job_id' ")
                    or die("Err11 " . mysqli_error($link));

                echo "<script> document.location='preview.php?user_id=' . $app_id . '&job_id=' . $job_id . ' </script>";
            }
            if (isset($_POST["update_status"])) {
                // var_dump($_POST);
                $status = $_POST["status"];
                $app_id = $_POST["app_id"];
                $job_id = $_POST['job'];
                //return var_dump($job_id,$app_id);

                mysqli_query($link, "UPDATE jobs_user_applications SET job_status = '$status' WHERE  id='$job_id' ")
                    or die("Err11 " . mysqli_error($link));

                // Add To Logs
                $trans_name = $status;
                $trans_by = $_SESSION['comp_id'];
                $trans_on = $app_id;
                $create_log->createLog($trans_name, $trans_by, $trans_on);

                echo "<script> document.location='preview.php?user_id=' . $app_id . '&job_id=' . $job_id . ' </script>";
            }
            if (isset($_POST["dis_btn"])) {
                $disqualify_reason = $_POST['disqualify_reason'];
                $app_id = $_POST["app_id"];
                $job_id = $_POST['job'];
                // return var_dump($_POST);

                mysqli_query($link, "UPDATE jobs_user_applications SET disqualify_reason = '$disqualify_reason',job_status='Disqualified'  WHERE  user_id='$app_id' AND jobs_job_id='$job_id' ")
                    or die("Err11 " . mysqli_error($link));

                echo "<script> document.location='preview.php?user_id=' . $app_id . '&job_id=' . $job_id . ' </script>";
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
                                    <div class="w3-white w3-text-grey w3-card-4" style="padding-bottom: 8px;">
                                        <div class="w3-display-container">
                                            <!-- <img src="/w3images/avatar_hat.jpg" style="width:100%" alt="Avatar"> -->
                                            <div class="w3-display-bottomleft w3-container w3-text-black">
                                                <h2 style="text-transform: capitalize;"><?php echo $full_names ?>'s CV</h2>
                                            </div>

                                        </div>
                                        <div class="w3-container">
                                            <br>

                                            <?php
                                            $empQuery = mysqli_query($link, "SELECT *
                                            FROM jobs_user_info
                                            INNER JOIN jobs_user_applications ON jobs_user_info.user_id = jobs_user_applications.user_id AND jobs_user_applications.id = '$job_id'
                                            LEFT JOIN talent_pool ON talent_pool.id = jobs_user_applications.talent_pool_id
                                            WHERE jobs_user_info.user_id = '$user_id'
                                            ") or die(mysqli_error($link));                                            // echo mysqli_num_rows($empQuery);
                                            while ($empRows = mysqli_fetch_array($empQuery)) {
                                                // Other Info
                                                // var_dump($empRows);
                                                $location = $empRows['location'];
                                                $lang1 = $empRows['lang1'];
                                                $lang2 = $empRows['lang2'];
                                                $lang3 = $empRows['lang3'];
                                                $talent_pool_id = $empRows['talent_pool_id'] > 0 ? $empRows['talent_pool_id'] : null;
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
                                                $poolTitle = $empRows['title'];
                                                $job_stat = $empRows['job_status'];
                                            }
                                            // var_dump($talent_pool_id);
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
                                            <p class="w3-large"><b><i class="fa fa-edit fa-fw w3-margin-right w3-text-blue"></i>Actions</b></p>

                                            <div>
                                                <form method="POST" action="#save">
                                                    <div class="form-group">
                                                        <label for="pwd">Assign Talent Pool: <?= $poolTitle ?></label>
                                                        <select name="pool_id" class="form-control" value="<?= $poolTitle ?>" required>
                                                            <?php if (isset($poolTitle)) { ?>
                                                                <option value="<?= $poolTitle ?>" class="option active"><?= $poolTitle ? $poolTitle : 'N/A' ?></option>
                                                            <?php } else { ?>
                                                                <option value="">---Select Talent Pool---</option>
                                                            <?php } ?> <!-- <option>--Select Talent Pool--</option> -->
                                                            <?php
                                                            $comp_id = $_SESSION['comp_id'];
                                                            $poolQuery = mysqli_query($link, "SELECT * FROM talent_pool WHERE emp_id = $comp_id");
                                                            while ($row = mysqli_fetch_array($poolQuery)) {
                                                            ?>
                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <input hidden="" name="app_id" value="<?php echo $user_id ?>">
                                                    <input hidden="" name="job" value="<?php echo $job_id; ?>">

                                                    <button type="submit" name="update_pool" class="btn btn-primary">Assign</button>
                                                </form>

                                                <form method="POST" action="#save">
                                                    <div class="form-group">
                                                        <label for="pwd">Update Applicant Status:
                                                            <?php if ($job_stat == 'Disqualified') { ?>
                                                                <button type="button" class="btn btn-danger label <?= $id ?>">
                                                                    <?= $job_stat ?>
                                                                </button>
                                                            <?php } else { ?>
                                                                <span><?= $job_stat ?></span>
                                                            <?php } ?>
                                                        </label>
                                                        <select name="status" class="form-control">
                                                            <option value="Shortlisted">Shortlisted</option>
                                                            <option value="Phone Interview">Phone Interview</option>
                                                            <option value="Onsite Interview">Onsite Interview</option>
                                                            <option value="Evaluation">Evaluation</option>
                                                            <option value="Offer">Offer</option>
                                                            <option value="Hired">Hired</option>
                                                        </select>
                                                    </div>
                                                    <input hidden="" name="app_id" value="<?php echo $user_id ?>">
                                                    <input hidden="" name="job" value="<?php echo $job_id; ?>">
                                                    <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
                                                </form>
                                            </div>
                                            <div>
                                                <div>
                                                    <button onclick="showInput()" class="btn btn-danger" style="margin-top: 12px;">
                                                        Disqualify
                                                    </button>
                                                </div>
                                                <form method="POST" action="#save">
                                                    <div class="form-group" id="dis_input">
                                                        <label hidden id="dq_label" for="pwd">Reason to Disqualify:</label>
                                                        <textarea hidden name="disqualify_reason" id="dq_reason" value="<?php echo $user_id ?>"> </textarea>
                                                    </div>

                                                    <input hidden="" name="app_id" value="<?php echo $user_id ?>">
                                                    <input hidden="" name="job" value="<?php echo $job_id; ?>">

                                                    <button hidden type="submit" id="dq_btn" name="dis_btn" class="btn btn-danger">Confirm</button>
                                                    <div hidden onclick="hideInput()" id="dq_cancel" class="btn btn-primary ">
                                                        Cancel
                                                    </div>
                                                </form>
                                            </div>
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
                                <!-- modals -->
                            </div>
                            <div class="modal fade" id="pool<?php echo $id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Assign Talent Pool</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="#save">
                                                <div class="form-group">
                                                    <label for="pwd">Assign Talent Pool:</label>
                                                    <select name="pool_id" class="form-control" required>
                                                        <option>--Select Talent Pool--</option>
                                                        <?php
                                                        $comp_id = $_SESSION['emp_id'];
                                                        $departmentquery = mysqli_query($link, "SELECT * FROM talent_pool WHERE emp_id = $comp_id");
                                                        while ($row = mysqli_fetch_array($departmentquery)) {
                                                        ?>
                                                            <option value="<?php echo $row['id']; ?>"> <?php echo $row['title']; ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <input hidden="" name="app_id" value="<?php echo $appcant_user_id ?>">
                                                <input hidden="" name="job" value="<?php echo $id; ?>">

                                                <button type="submit" name="update_pool" class="btn btn-default">Assign</button>
                                            </form>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end talent pool modal -->
                            <!-- start disqualify modal -->
                            <div class="modal fade" id="dis<?php echo $id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Disqualify Applicant</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="#save">
                                                <div class="form-group">
                                                    <label for="pwd">Reason to Disqualify:</label>
                                                    <textarea name="disqualify_reason" value="<?php echo $appcant_user_id ?>"> </textarea>
                                                </div>

                                                <input hidden="" name="app_id" value="<?php echo $appcant_user_id ?>">
                                                <input hidden="" name="job" value="<?php echo $job_id; ?>">

                                                <button type="submit" name="dis" class="btn btn-default">Update</button>
                                            </form>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end disqualify modal -->

                            <!-- End Page Container -->
                        </div>


                    </div>

            </section>

        </div>



        <?php include '../../../footer/footer.php'; ?>

        <div class="control-sidebar-bg"></div>
    </div>
    <!-- <script src="/jobs/plugins/jQuery/jQuery-2.1.4.min.js"></script> -->
    <script>
        function showInput() {
            const label = document.getElementById('dq_label');
            const textArea = document.getElementById('dq_reason');
            const dqButton = document.getElementById('dq_btn');
            const dqCancel = document.getElementById('dq_cancel');

            label.hidden = false;
            textArea.hidden = false;
            dqButton.hidden = false;
            dqCancel.hidden = false;
        }
    </script>
    <script>
        function hideInput() {
            const label = document.getElementById('dq_label');
            const textArea = document.getElementById('dq_reason');
            const dqButton = document.getElementById('dq_btn');
            const dqCancel = document.getElementById('dq_cancel');

            label.hidden = true;
            textArea.hidden = true;
            dqButton.hidden = true;
            dqCancel.hidden = true;
        }
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- <script src="/jobs/assets/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script> -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- <script src="/jobs/bootstrap/js/bootstrap.min.js"></script> -->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../../../dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../../dist/js/demo.js"></script>
</body>

</html>