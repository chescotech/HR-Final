<head>
    <link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">

</head>

<div class="content-wrapper">
    <div>
        <ol class="breadcrumb">
            <li><a href="#">Applicant</a></li>
            <li class="active">List</li>
        </ol>
    </div>
    <div class="panel panel-default">
        <div class="panel-body" style="font-size:14px;">

            <div style="padding-bottom:10px">
                <form action="employee-exitsby-reason" method="post">
                    <table cellpadding="" border="0" class="se">
                        <tr>
                            <td>
                                <input required="required" id="datepicker" name="search_month" class="form-control" placeholder="Select Month">
                            </td>
                            <td>
                                <button type="submit" name="search" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search
                                </button>
                            </td>
                        </tr>
                    </table>
                </form>
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

                    if (isset($_GET['job'])) {
                        $job_id = $_GET['job'];
                        $user_q = mysqli_query($link, "SELECT talent_pool.title,fname,lname, jobs_postings.title as job,
                        jobs_user_applications.date AS date_applied,job_status,jobs_user_applications.id as job_applied_id, 
                        jobs_user_applications.user_id AS appcant_user_id FROM `jobs_user_applications`
                        INNER JOIN jobs_users on jobs_users.id=jobs_user_applications.user_id
                        INNER JOIN jobs_postings on jobs_postings.id=jobs_user_applications.jobs_job_id 
                        LEFT JOIN talent_pool on talent_pool.id=talent_pool_id
                    WHERE jobs_postings.id='$job_id'
                    ") or die(mysqli_error($link));
                    } else {
                        $user_q = mysqli_query($link, "SELECT talent_pool.title,fname,lname, jobs_postings.title as job,
                        jobs_user_applications.date AS date_applied,job_status,jobs_user_applications.id as job_applied_id, 
                        jobs_user_applications.user_id AS appcant_user_id FROM `jobs_user_applications`
                        INNER JOIN jobs_users on jobs_users.id=jobs_user_applications.user_id
                        INNER JOIN jobs_postings on jobs_postings.id=jobs_user_applications.jobs_job_id 
                        LEFT JOIN talent_pool on talent_pool.id=talent_pool_id") or die(mysqli_error($link));
                    }


                    while ($row = mysqli_fetch_array($user_q)) {
                        $id = $row['job_applied_id'];
                        $appcant_user_id = $row['appcant_user_id'];
                        $title = $row['job'];
                        $talent_pool = $row['title'];
                        $names = $row['fname'] . ' ' . $row['lname'];
                        // $vacancies = $row['vacancies'];
                        // $experience = $row['experience'];
                        $date_applied = $row['date_applied'];
                        $job_status = $row['job_status'];
                        // $date = $row['date'];
                        //$expires = $row['expires'];

                        echo '
                            <tr>
                                <td>' . $names . '</td>
                                <td>70 %</td>
                                <td>' . $title . '</td>
                                <td>' . $date_applied . '</td>
                                <td>' . $job_status . '
                             
                                <button type="button" class="btn btn-primary label" data-toggle="modal" data-target="#exampleModal' . $id . '">
                                Status
                            </button>

                                </td>
                                <td>' . $talent_pool . '
                                <button type="button" class="btn btn-primary label" data-toggle="modal" data-target="#pool' . $id . '">
                                Assign
                            </button>
                                
                                </td>
                                <td>
                                    <a class="btn btn-primary" style="padding:2px; padding-left: 10px; padding-right:10px;" href="candidate-profile.php?user_id=' . $appcant_user_id . '">View Applicant</a>
                                  
                                    <button type="button" class="btn btn-primary label" data-toggle="modal" data-target="#meeting' . $id . '">
                                    Meeting
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
                                                    $departmentquery = mysqli_query($link, "SELECT * FROM talent_pool ");
                                                    while ($row = mysqli_fetch_array($departmentquery)) {
                                                    ?>
                                                        <option value="<?php echo $row['id']; ?>"> <?php echo $row['title']; ?></option>
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
                    //return var_dump($job_id,$app_id);

                    mysqli_query($link, "UPDATE jobs_user_applications SET talent_pool_id = '$pool_id' WHERE  user_id='$app_id' ")
                        or die("Err11 " . mysqli_error($link));

                    echo "<script> document.location='applicant-list.php' </script>";
                }
                if (isset($_POST["update_status"])) {
                    $status = $_POST["status"];
                    $app_id = $_POST["app_id"];
                    $job_id = $_POST['job'];
                    //return var_dump($job_id,$app_id);

                    mysqli_query($link, "UPDATE jobs_user_applications SET job_status = '$status' WHERE  id='$job_id' ")
                        or die("Err11 " . mysqli_error($link));

                    echo "<script> document.location='applicant-list.php' </script>";
                }
                ?>
                <tfoot style="background-color: #c0c0c0; color: #ffffff; font-size: 0.9em; ">
                    <tr>
                        <th>Applicants Names</th>
                        <th>Matching %</th>
                        <th>Job Applied For</th>
                        <th>Date Applied</th>
                        <th>Stage</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

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