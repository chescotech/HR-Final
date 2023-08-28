<?
session_start();
?>

<head>
    <link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">

</head>

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
        // Handle the division by zero error
        return 0; // or any other appropriate value
    }

    for ($i = $lg_figure; $i > 1; $i--) {
        if (($sm_figure % $i) == 0 && ($lg_figure % $i) == 0) {
            $sm_figure = $sm_figure / $i;
            $lg_figure = $lg_figure / $i;
        }
    }
    return ($sm_figure / $lg_figure) * 100;
}

function candidateMatch($candidate_id, $job_id)
{

    $experienceQuery = mysql_query("SELECT * FROM jobs_user_experience WHERE user_id = '$candidate_id' ") or die(mysql_error());
    while ($experienceRow = mysql_fetch_array($experienceQuery)) {
        $position = $experienceRow['position'];
        $starts[] = $experienceRow['starts'];
        $ends[] = $experienceRow['ends'];
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
    // $job_id = 4;
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
            if (abs($experience_aquired - $experience_required) > 10) {
                $experience_score = 100;
            } elseif (abs($experience_aquired - $experience_required) > 6) {
                $experience_score = 80;
            } elseif (abs($experience_aquired - $experience_required) > 2) {
                $experience_score = 60;
            } else {
                $experience_score = 40;
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
    // echo $skill_score;
    $total_score = ($skill_score + $experience_score + $salary_score) / 3;

    if (is_int($total_score)) {
        return $total_score;
    } else {
        return number_format($total_score, 3);
    }


    // return var_dump(intval($ex_salary), intval($salary_min), intval($salary_max));
}
?>





<div class="content-wrapper">
    <div>
        <ol class="breadcrumb">
            <li><a href="#">Applicant</a></li>
            <li class="active">List</li>
        </ol>
    </div>
    <div class="panel panel-default" style="overflow-x: auto;">
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
                                    $reg_num = $_SESSION['reg_num'];
                                    $comp_id = $_SESSION['comp_id'];

                                    $qq1 = mysql_query("SELECT * FROM `jobs_postings` where emp_id = '$comp_id'");
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
            <div>

                <a href="shortlisted" class="btn btn-primary">Shortlisted Candidates</a>
                <br>
            </div>

            <table id="maintable" class="display compact cell-border" cellspacing="0" width="100%">
                <thead>
                    <tr>
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
                    <?php
                    $filter_by_job = " ";
                    $sort_by_date = " ";

                    if (isset($_POST['job'])) {
                        $from = $_POST['from'];
                        $to = $_POST['to'];
                        $job_id = $_POST['job'];

                        $filter_by_job = " WHERE jobs_postings.id != '' ";
                        if ($job_id != "all") {
                            $filter_by_job = " WHERE jobs_postings.id='$job_id' ";
                        }

                        if ($from != '' && isset($to)) {
                            $sort_by_date = " AND jobs_user_applications.date BETWEEN '$from' AND '$to' ";
                        } else {
                            $sort_by_date = " ";
                        }
                    }

                    if (isset($_GET['job'])) {
                        $job_id = $_GET['job'];
                        $job_rn = $_SESSION['reg_num'];

                        $filter_by_job = " WHERE jobs_postings.emp_id != '' ";
                        if ($job_rn != "all") {
                            $filter_by_job = " WHERE jobs_postings.emp_id=jobs_user_applications.emp_id";
                        }
                    }

                    $user_q = mysql_query("SELECT jobs_user_applications.jobs_job_id AS job_id,jobs_user_applications.emp_id,talent_pool.title,fname,lname, jobs_postings.title as job,
                        jobs_user_applications.date AS date_applied,job_status,jobs_user_applications.id as job_applied_id, 
                        jobs_user_applications.user_id AS appcant_user_id FROM `jobs_user_applications`
                        INNER JOIN jobs_users on jobs_users.id=jobs_user_applications.user_id
                        INNER JOIN jobs_postings on jobs_postings.id=jobs_user_applications.jobs_job_id 
                        LEFT JOIN talent_pool on talent_pool.id=talent_pool_id            
                        WHERE jobs_postings.emp_id=jobs_user_applications.emp_id AND jobs_postings.emp_id = '$comp_id'
                        $sort_by_date            
                        
                        ") or die(mysql_error());


                    while ($row = mysql_fetch_array($user_q)) {
                        $id = $row['job_applied_id'];
                        $appcant_user_id = $row['appcant_user_id'];
                        $title = $row['job'];
                        $talent_pool = $row['title'];
                        $regno = $row['reg_number'];
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
                    ?>

                        <tr class="<?php echo $cls ?>">
                            <?php
                            echo '
                                <td>' . $names . ' </td>
                                <td>' . candidateMatch($appcant_user_id, $job_id) . '</td>
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
                                    <a class="btn btn-primary" style="padding:2px; padding-left: 10px; padding-right:10px;" target="_blank" href="preview.php?user_id=' . $appcant_user_id . '&job_id=' . $id . '">View Applicant</a>
                                   


                                <button type="button" class="btn btn-primary label" data-toggle="modal" data-target="#dis' . $id . '">
                                    Disqualify
                                </button>
                                </td>
                            </tr>';
                            ?>

                            <div class="modal fade" id="exampleModal<?php echo $id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Update Applicant Status</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="#save">
                                                <div class="form-group">
                                                    <label for="pwd">Update Applicant Status:</label>
                                                    <select name="status" class="form-control">
                                                        <option value="Shortlisted">Shortlisted</option>
                                                        <option value="Phone Interview">Phone Interview</option>
                                                        <option value="Onsite Interview">Onsite Interview</option>
                                                        <option value="Evaluation">Evaluation</option>
                                                        <option value="Offer">Offer</option>
                                                        <option value="Hired">Hired</option>
                                                    </select>
                                                </div>

                                                <input hidden="" name="app_id" value="<?php echo $appcant_user_id ?>">
                                                <input hidden="" name="job" value="<?php echo $id; ?>">

                                                <button type="submit" name="update_status" class="btn btn-default">Update</button>
                                            </form>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                                                        $departmentquery = mysql_query("SELECT * FROM talent_pool WHERE emp_id = $comp_id");
                                                        while ($row = mysql_fetch_array($departmentquery)) {
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

                            <div class="modal fade" id="meeting<?php echo $id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">New Meeting</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="#save">
                                                <div class="form-group">
                                                    <label for="pwd">Update Applicant Status:</label>
                                                    <select name="status" class="form-control">
                                                        <option value="Shortlisted">Shortlisted</option>
                                                        <option value="Phone Interview">Phone Interview</option>
                                                        <option value="Onsite Interview">Onsite Interview</option>
                                                        <option value="Evaluation">Evaluation</option>
                                                        <option value="Offer">Offer</option>
                                                        <option value="Hired">Hired</option>
                                                    </select>
                                                </div>

                                                <input hidden="" name="app_id" value="<?php echo $appcant_user_id ?>">
                                                <input hidden="" name="job" value="<?php echo $id; ?>">

                                                <button type="submit" name="update_status" class="btn btn-default">Update</button>
                                            </form>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        <?php
                    }
                        ?>

                </tbody>


                <?php
                if (isset($_POST["update_pool"])) {
                    $pool_id = $_POST["pool_id"];
                    $app_id = $_POST["app_id"];
                    $job_id = $_POST['job'];
                    echo $job_id;
                    //return var_dump($job_id,$app_id);

                    mysql_query("UPDATE jobs_user_applications SET talent_pool_id = '$pool_id' WHERE  user_id='$app_id' AND jobs_user_applications.id='$job_id' ")
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

                    // Add To Logs
                    $trans_name = $status;
                    $trans_by = $_SESSION['job_user_id'];
                    $trans_on = "";
                    $create_log->createLog($trans_name, $trans_by, $trans_on);

                    echo "<script> document.location='applicant-list.php' </script>";
                }
                ?>
                <!-- <tfoot style="background-color: #c0c0c0; color: #ffffff; font-size: 0.9em; ">
                    <tr>
                        <th>Applicants Names</th>
                        <th>Matching %</th>
                        <th>Job Applied For</th>
                        <th>Date Applied</th>
                        <th>Stage</th>
                        <th>Actions</th>
                    </tr>
                </tfoot> -->
            </table>
        </div>




    </div>
</div>
<script>
    function toggle(source) {
        checkboxes = document.getElementsByName('empno[]');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>
<script type="text/javascript" src="../../js/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
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