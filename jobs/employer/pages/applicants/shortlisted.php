<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Shortlisted Candidates</title>
    </title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="../../bootstrap-5.1.3-dist/css/bootstrap-grid.css"> -->
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
    <link rel="stylesheet" href="https://ziscoerp.com/assets/css/datepicker.min.css">

    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- <a href="" class="logo"> -->
            <span class="logo-lg"><b>

                    <?php
                    // error_reporting(0);
                    session_start();
                    $_SESSION['activeLink'] = 'jobs';

                    if (isset($_SESSION['name'])) {
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
            <section class="sidebar">
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

        <script>
            $(function() {
                $("#datepicker").datepicker();
                $("#datepicker_").datepicker();
                $("#birthday_picker").datepicker();
            });
        </script>
        <?php
        /**
         * calculating average scores if expected is outta proper range;
         * basically, the further apart the aquired is frm the required, the smaller the score..
         */
        function gt_diff_fiq_perc($sm_figure, $lg_figure)
        {
            if ($lg_figure == 0) {
                return 0;
            }
            for ($i = $lg_figure; $i > 1; $i--) {
                if (($sm_figure % $i) == 0 && ($lg_figure % $i) == 0) {
                    $sm_figure = $sm_figure / $i;
                    $lg_figure = $lg_figure / $i;
                }
            }
            return ($sm_figure / $lg_figure) * 100;
        }
        function candidateMach($candidate_id, $job_id)
        {

            $experienceQuery = mysql_query("SELECT * FROM jobs_user_experience WHERE user_id = '$candidate_id' ") or die(mysql_error());
            while ($experienceRow = mysql_fetch_array($experienceQuery)) {
                $position = $experienceRow['position'];
                $starts[] = $experienceRow['starts'];
                $ends[] =  $experienceRow['ends'];
            }
            $skillsQuery = mysql_query("SELECT name FROM jobs_user_skills WHERE user_id = '$candidate_id' ") or die(mysql_error());
            while ($skillsRow = mysql_fetch_array($skillsQuery)) {
                $skills_aquired[] = $skillsRow['name'];
            }

            $oiQuery = mysql_query("SELECT * FROM jobs_user_info WHERE user_id = '$candidate_id' ") or die(mysql_error());
            while ($oiRow = mysql_fetch_array($oiQuery)) {
                $ex_salary_period = $oiRow['ex_salary_period'];
                $ex_salary = intval($oiRow['ex_salary']);
            }
            $qualificationsQuery = mysql_query("SELECT qualification FROM jobs_user_qualifications WHERE user_id = '$candidate_id' ") or die(mysql_error());
            while ($qualificationsRow = mysql_fetch_array($qualificationsQuery)) {
                $qualification_aquired[] = $qualificationsRow['qualification'];
                // $award = $qualificationsRow['award'];
            }
            if (isset($skills_aquired) && isset($qualification_aquired)) {
                $applicant_qltys = array_merge($skills_aquired, $qualification_aquired);
            } elseif (isset($skills_aquired)) {
                $applicant_qltys = $skills_aquired;
            } elseif (isset($qualification_aquired)) {
                $applicant_qltys = $qualification_aquired;
            } elseif (isset($skills_aquired) && isset($qualification_aquired)) {
                // Applicant has not finished creating their profile...
            }

            // Get job related stuff
            $job_id = 4;
            $experience_required = '';
            $salary_min = 0;
            $salary_max = 0;
            $expectedQuery = mysql_query("SELECT * FROM jobs_postings WHERE id = '$job_id' ") or die(mysql_error());
            while ($row = mysql_fetch_array($expectedQuery)) {
                $title = $row['title'];
                $experience_required = intval($row['experience']);
                $salary_min = intval($row['salary_min']);
                $salary_max = intval($row['salary_max']);
            }
            $qualQuery = mysql_query("SELECT * FROM jobs_posting_qualifications WHERE job_posting_id = '$job_id' ") or die(mysql_error());
            while ($qualRow = mysql_fetch_array($qualQuery)) {
                $qualifications_required[] = $qualRow['qualification'];
            }
            $reqQuery = mysql_query("SELECT * FROM jobs_posting_requirements WHERE job_posting_id = '$job_id' ") or die(mysql_error());
            while ($reqRow = mysql_fetch_array($reqQuery)) {
                $requirements_required[] = $reqRow['requirement'];
            }

            if (isset($requirements_required) && isset($qualifications_required)) {
                $expected_qltys = array_merge($requirements_required, $qualifications_required);
            } elseif (isset($requirements_required)) {
                $expected_qltys = $requirements_required;
            } elseif (isset($qualifications_required)) {
                $expected_qltys = $qualifications_required;
            } elseif (isset($requirements_required) && isset($qualifications_required)) {
                // This job profile is incomplete...
            }
            $expected_qltys = array_merge($requirements_required, $qualifications_required);
            // $expected_qltys_vals = array_count_values($expected_qltys);
            $expected_qltys_total = count($expected_qltys);
            // print_r($expected_qltys);



            // Get the scores
            // Skillz Score Starts...
            $skill_score = '';
            if (isset($expected_qltys) && isset($applicant_qltys)) {
                $intersect_qltys = array_intersect($applicant_qltys, $expected_qltys);
                // print_r($expected_qltys);
                $intersect_qltys_total = count($intersect_qltys);
                if ($intersect_qltys_total == $expected_qltys_total) {
                    $skill_score = 100;
                } elseif ($intersect_qltys_total < $expected_qltys_total) {
                    $skill_score = gt_diff_fiq_perc(intval($intersect_qltys_total), intval($expected_qltys_total));
                } elseif ($intersect_qltys_total > $expected_qltys_total) {
                    $skill_score = gt_diff_fiq_perc(intval($expected_qltys_total), intval($intersect_qltys_total));
                }
                // return $expected_qltys_total . $intersect_qltys_total;
            } else {
                $skill_score = 20;
                // Something is incomplete somewhere
            }
            // Skillz Score Ends...

            // Experience Score ...
            $experience_score = "";
            if (isset($starts) && isset($ends)) {
                $exp_from_str = min($starts);
                $exp_to_str = max($ends);
                $exp_from_dt = new DateTime($exp_from_str);
                $exp_to_dt = new DateTime($exp_to_str);
                $date_diff = $exp_from_dt->diff($exp_to_dt);
                $experience_aquired = intval($date_diff->format('%y'));
                if ($experience_aquired > $experience_required) {
                    if (abs($experience_aquired - $experience_required) > 4) {
                        $experience_score = 100;
                    } else {
                        $experience_score = 90;
                    }
                } else {
                    $experience_score = gt_diff_fiq_perc($experience_aquired, $experience_required);
                }
            } else {
                // Candidate has no experience
                $experience_score = 5;
            }
            // Experience Score Ends...

            // Salary Score 20pts..
            $salary_score = "";
            if ($ex_salary >= $salary_min && $ex_salary <= $salary_max) {
                $salary_score = 100;
            } else {
                $av_set_salary = ($salary_min + $salary_max) / 2;
                if ($av_set_salary < $ex_salary) {
                    $salary_score = gt_diff_fiq_perc($av_set_salary, $ex_salary);
                } elseif ($av_set_salary > $ex_salary) {
                    $salary_score = gt_diff_fiq_perc($ex_salary, $av_set_salary);
                }
            }
            //  Salary Score Ends

            // Overall score
            $total_score = ($skill_score + $experience_score + $salary_score) / 3;

            if (is_int($total_score)) {
                return $total_score;
            } else {
                // return $skill_score . " - " . $experience_score . " - " . $salary_score;
                // return $total_score;
                // return intval($total_score);
                return number_format($total_score, 3);
            }


            // return var_dump(intval($ex_salary), intval($salary_min), intval($salary_max));
        }

        ?>

        <div class="content-wrapper">
            <div>
                <ol class="breadcrumb">
                    <li><a href="#">Applicant</a></li>
                    <li class="active">Shortlisted Candidates List</li>
                </ol>
            </div>
            <div class="panel panel-default">
                <div class="panel-body" style="font-size:14px;">
                    <div style="padding-bottom:10px">
                        <form action="#here" method="POST">
                            <table cellpadding="" border="0" class="se">
                                <tr>
                                    <td>Date From:
                                        <input id="datepicker" name="from" class="form-control btn btn-primary" type="date">
                                    </td>
                                    <td>Date To:
                                        <input id="datepicker_" name="to" class="form-control btn btn-primary" type="date">
                                    </td>
                                    <div class="form-group  col-md-3">
                                        Job Title:
                                        <select name="job" class="form-control btn btn-primary" required>
                                            <option value=""> Filter By Job </option>
                                            <option value="all"> All Jobs </option>
                                            <?php
                                            $job_id = $_GET['job'];
                                            $comp_id = $_SESSION['comp_id'];
                                            $qq1 = mysql_query("SELECT * FROM jobs_postings WHERE emp_id='$comp_id'");
                                            while ($rr1 = mysql_fetch_array($qq1)) {
                                            ?>
                                                <option value="<?php echo $rr1['id']; ?>"> <?php echo $rr1['title']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <td>
                                        <div>Search:</div>
                                        : <button type="submit" name="search" id="save" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span>
                                            Search
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <br>
                    </div>
                    <form action="#min-score" method="post">
                        <div>
                            Set the minimum matching score(%) :
                            <input type="text" name="min_score" placeholder="">

                            <button type="submit" name="">Go. </button>
                        </div>
                        <br>
                    </form>
                    <table id="maintable" class="display compact cell-border" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th for="all"> All <br /> <input id="all" type="checkbox" /> </th>
                                <th>Applicants Names</th>
                                <th>Matching %</th>
                                <th>Job Applied For</th>
                                <th>Date Applied</th>
                                <th>Stage</th>
                                <th>Talent Pool</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form method="POST" action="#save">
                                <?php

                                $filter_by_job = ""; // Default condition to select all jobs.
                                $sort_by_date = "";
                                $filter_shortlisted = "jobs_user_applications.job_status=`Shortlisted`";

                                $filter_by_employer = " emp_id = '$comp_id'";
                                if (isset($_POST['job'])) {
                                    $from = $_POST['from'];
                                    $to = $_POST['to'];
                                    $job_id = $_POST['job'];


                                    // Update $filter_by_job based on the value of $job_id.
                                    if ($job_id != "all") {
                                        $filter_by_job = " jobs_postings.id='$job_id' ";
                                    }

                                    // Construct $sort_by_date based on $from and $to.
                                    if ($from != '' && isset($to)) {
                                        $sort_by_date = " AND jobs_user_applications.date BETWEEN '$from' AND '$to' ";
                                    }
                                }

                                $quer = mysql_query("SELECT jobs_user_applications.jobs_job_id AS job_id,jobs_user_applications.emp_id,talent_pool.title,fname,lname, jobs_postings.title as job,
                                jobs_user_applications.date AS date_applied,job_status,jobs_user_applications.id as job_applied_id, 
                                jobs_user_applications.user_id AS appcant_user_id FROM `jobs_user_applications`
                                INNER JOIN jobs_users on jobs_users.id=jobs_user_applications.user_id
                                INNER JOIN jobs_postings on jobs_postings.id=jobs_user_applications.jobs_job_id 
                                LEFT JOIN talent_pool on talent_pool.id=talent_pool_id            
                                WHERE jobs_postings.emp_id=jobs_user_applications.emp_id AND jobs_user_applications.job_status='Shortlisted' AND jobs_postings.emp_id = '$comp_id'
                                $sort_by_date            
                                
                                ") or die(mysql_error());
                                // $quer = "SELECT * FROM `jobs_user_applications`";

                                while ($row = mysql_fetch_array($quer)) {
                                    $id = $row['job_applied_id'];
                                    $appcant_user_id = $row['appcant_user_id'];
                                    $title = $row['job'];
                                    $talent_pool = $row['title'];
                                    $job_id = $row['job_id'];
                                    $names = $row['fname'] . ' ' . $row['lname'];
                                    // $vacancies = $row['vacancies'];
                                    // $experience = $row['experience'];
                                    $date_applied = $row['date_applied'];
                                    $job_status = $row['job_status'];
                                    // $date = $row['date'];
                                    //$expires = $row['expires'];

                                    if ($job_status == "Disqualified") {
                                        $statusDisplay = '
                                <button type="button" class="btn btn-danger label" data-toggle="modal" data-target="#exampleModal' . $id . '">
                                    ' . $job_status . '
                                </button>';
                                    } else {
                                        $statusDisplay = '' . $job_status . '<br>
                                <button type="button" class="btn btn-primary label" data-toggle="modal" data-target="#exampleModal' . $id . '">
                                    Status
                                </button>';
                                    }

                                    $min_score = 47;
                                    if (isset($_POST['min_score'])) {
                                        $min_score = $_POST['min_score'];
                                    }

                                    if (candidateMach($appcant_user_id, $job_id) > $min_score) {
                                        $cls = "";
                                    } else {
                                        $cls = "hidden";
                                    }
                                ?>

                                    <tr class="<?php echo $cls ?>">
                                        <input hidden="" name="job[]" value="<?php echo $id; ?>">
                                        <?php

                                        echo '
                                        <td> <input name="app_id[]" type="checkbox" value="' . $appcant_user_id . '" /> </td>
                                            <td>' . $names . '</td>
                                            <td>' . candidateMach($appcant_user_id, $job_id) . '</td>
                                            <td>' . $title . '</td>
                                            <td>' . $date_applied . '</td>
                                            <td>
                                                ' . $statusDisplay . '
                                            </td>
                                            <td>' . $talent_pool . '
                                            <button type="button" class="btn btn-primary label" data-toggle="modal" data-target="#pool' . $id . '">
                                                Assign
                                            </button>
                                            
                                            </td>
                                            <td>
                                                <a class="btn btn-primary label" href="preview.php?user_id=' . $appcant_user_id . '">View Applicant</a>
                                            </td>
                                        </tr>';
                                        ?>

                                    <?php
                                }
                                    ?>
                                    <form method="POST" action="">
                                        What to do with selected :
                                        <select name="status" class="form-">
                                            <option value="Phone Interview">Phone Interview</option>
                                            <option value="Onsite Interview">Onsite Interview</option>
                                            <option value="Evaluation">Evaluation</option>
                                            <option value="Offer">Offer</option>
                                            <option value="Hired">Hired</option>
                                        </select>

                                        <input hidden="" name="app_id" value="<?php echo $appcant_user_id ?>">
                                        <input hidden="" name="job" value="<?php echo $id; ?>">
                                        <input hidden="" name="app_id[]" type="checkbox" value="<?= $appcant_user_id ?>" />
                                        <button type="submit" name="multiple_status">Go. </button>
                                    </form>
                                    <br>
                            </form>

                        </tbody>


                    </table>
                </div>


                <?php
                if (isset($_POST["multiple_status"])) {
                    $status = $_POST["status"];
                    // arrays
                    $job_ids = $_POST['job'];
                    $app_ids = $_POST["app_id[]"];
                    //return var_dump($job_id,$app_id);
                    array_map(function ($job_id, $app_id) {
                        global $status, $create_log;

                        mysql_query("UPDATE jobs_user_applications SET job_status = '$status' WHERE  id='$job_id' ")
                            or die("Err11 " . mysql_error());

                        $trans_name = $status;
                        $trans_by = $_SESSION['job_user_id'];
                        $trans_on = "";

                        $create_log->createLog($trans_name, $trans_by, $trans_on);
                    }, $job_ids, $app_ids);


                    echo "<script> document.location='applicant-list.php' </script>";
                }

                if (isset($_POST["update_pool"])) {
                    $pool_id = $_POST["pool_id"];
                    $app_id = $_POST["app_id"];
                    $job_id = $_POST['job'];
                    //return var_dump($job_id,$app_id);

                    mysql_query("UPDATE jobs_user_applications SET talent_pool_id = '$pool_id' WHERE  user_id='$app_id' ")
                        or die("Err11 " . mysql_error());

                    echo "<script> document.location='applicant-list.php' </script>";
                }
                if (isset($_POST["dis"])) {
                    $disqualify_reason = $_POST['disqualify_reason'];
                    $app_id = $_POST["app_id"];
                    $job_id = $_POST['job'];
                    //return var_dump($job_id,$app_id);

                    mysql_query("UPDATE jobs_user_applications SET disqualify_reason = '$disqualify_reason',job_status='Disqualified'  WHERE  user_id='$app_id' AND jobs_job_id='$job_id' ")
                        or die("Err11 " . mysql_error());

                    echo "<script> document.location='applicant-list.php' </script>";
                }
                if (isset($_POST["update_status"])) {
                    $status = $_POST["status"];
                    $app_id = $_POST["app_id"];
                    $job_id = $_POST['job'];
                    //return var_dump($job_id,$app_id);

                    mysql_query("UPDATE jobs_user_applications SET job_status = '$status' WHERE  id='$job_id' ")
                        or die("Err11 " . mysql_error());

                    echo "<script> document.location='applicant-list.php' </script>";
                }
                ?>


            </div>
        </div>

        <script>
            // Get reference to the "All" checkbox and all the checkboxes in the table
            var allCheckbox = document.getElementById("all");
            var checkboxes = document.getElementsByName("app_id[]");

            // Add an event listener to the "All" checkbox
            allCheckbox.addEventListener("change", function() {
                // Iterate through all checkboxes and set their checked property based on the "All" checkbox
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].checked = allCheckbox.checked;
                }
            });
        </script>
        <script type="text/javascript" src="../../js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="../../js/jszip.min.js"></script>
        <script type="text/javascript" src="../../js/pdfmake.min.js"></script>
        <script type="text/javascript" src="../../js/vfs_fonts.js"></script>
        <script type="text/javascript" src="../../js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="../../js/buttons.print.min.js"></script>
        <script type="text/javascript" src="../../js/app.js"></script>
        <script type="text/javascript" src="../../js/jquery.mark.min.js"></script>
        <script type="text/javascript" src="../../js/datatables.mark.js"></script>
        <script type="text/javascript" src="../../js/buttons.colVis.min.js"></script>
        <!-- Form data ends -->

        <?php include '../../../footer/footer.php'; ?>

        <div class="control-sidebar-bg"></div>
    </div>

    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
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
    <script>
        $(document).ready(function() {
            $('#maintable').DataTable({
                searching: true
            });
        });
    </script>
</body>

</html>