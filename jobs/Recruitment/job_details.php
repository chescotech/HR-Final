<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Job Details</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css" />
        <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <?php
            include '../navigation_panel/authenticated_user_header.php';
            ?>

            <?php include '../navigation_panel/side_navigation_bar.php'; ?>

            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        <?php
                        echo ' Job Details';
                        ?>
                    </h1>
                </section>

            <!-- <section class="content">
                <div class="row">
                    <div class="col-xs-17">

                        <div class="box">
                            <div class="box-body">

                                <div class="table-responsive">
                                    <table id="employee_data" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <td>Job Title</td>
                                                <td>Department</td>
                                                <td>Vacancies</td>
                                                <td>Date Posted</td>
                                                <td>Status</td>
                                                <td>Actions</td>
                                            </tr>
                                        </thead>
                <?php
                $result = mysql_query("SELECT * FROM postings 
                                                LEFT JOIN department ON department.dep_id = postings.dep_id
                                                WHERE status = 'Published'
                                                AND DATE(expires) > DATE(NOW())
                                                ") or die(mysql_error());
                $view_details = "";
                while ($row = mysql_fetch_array($result)) {
                    $id_ = $row['id'];
                    $title = $row['title'];
                    $department = $row['department'];
                    $vacancies = $row['vacancies'];
                    $status = $row['status'];
                    $rawdate = $row['date'];

                    $date = date("d M, Y", strtotime($rawdate));

                    if ($status == 'Published') {
                        $view_details = '<a target="_blank" href="../../job_details?job=' . $id_ . '" title="View Details &amp; Apply Now" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip"><i class="fa fa-paper-plane"></i></a>';
                    } elseif ($status == 'Unpublished') {
                        $view_details = '<a title="Publish To View Details &amp Apply" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip"><i class="fa fa-paper-plane"></i></a>';
                    }

                    // echo '  
                    //     <tr>
                    //         <td>' . $title . '</td>  
                    //         <td>' . $department . '</td>                                                                      
                    //         <td>' . $vacancies . '</td> 
                    //         <td>' . $date . '</td>
                    //         <td>' . $status . '</td>
                    //         <td>' . $view_details . '</td>
                    //     </tr>  
                    //     ';
                }
                ?>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->


                <section>
                    <!-- Page content-->
                    <hr>
                    <br>
                    <div class="container">

                        <div class="row container">
                            <div class="col-md-12">
                                <?php
                                require_once('../classes.php');
                                $Classes = new Classes();
                                $user_id = $_SESSION['job_user_id'];
                                $id_ = $_GET['job'];
                                $query = "SELECT * FROM jobs_postings 
                            LEFT JOIN department ON department.dep_id = jobs_postings.dep_id
                            WHERE id = $id_ ";
                                $result = mysql_query($query) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                    $title = $row['title'];
                                    $department = $row['department'];
                                    $vacancies = $row['vacancies'];
                                    $type = $row['type'];
                                    $experience = $row['experience'];
                                    $salary_min = $row['salary_min'];
                                    $salary_max = $row['salary_max'];
                                    $description = $row['description'];
                                    $requirements = $row['requirements'];
                                    $qualifications = $row['qualifications'];
                                    $status = $row['status'];
                                    $rawdate = $row['date'];
                                    $date = date("d M, Y", strtotime($rawdate));
                                    $rawExpires = $row['expires'];
                                    $expires = date("d M, Y", strtotime($rawExpires));
                                }
                                // Check if we done applied this before
                                $ck_q = mysql_query("SELECT id FROM jobs_user_applications WHERE jobs_job_id = '$id_'
                                                AND user_id = '$user_id' ") or die(mysql_error());

                                if (mysql_num_rows($ck_q) > 0) {
                                    $apply_txt = "Already Applied";
                                    $apply_class = "disabled";
                                    $apply_color = "style='background-color:#fc6603'";
                                } else {
                                    if ($Classes->profileStatus($user_id) < 50) {
                                        $apply_txt = "Complete Profile To Apply";
                                        $apply_class = "disabled";
                                        $apply_color = "style='background-color:#fc6603'";
                                    } else {
                                        $apply_txt = "Apply Now";
                                        $apply_class = "";
                                        $apply_color = "";
                                    }
                                }
                                ?>


                                <!-- Page content-->
                                <div class="content">

                                    <div class="row">
                                        <div class="col-lg-12">

                                            <div class="panel panel-custom">
                                                <div class="panel-body form-horizontal">
                                                    <p>
                                                        <strong style="font-size: 20px;"><?php echo $title . " (" . $department . ")"; ?></strong>
                                                    </p>
                                                    <div class="col-sm-8">
                                                        <p class="m0">
                                                            <strong>Experience: <?php echo $experience; ?></strong>

                                                        </p>
                                                        <p class="m0">
                                                            <strong>Salary Range: <?php echo $salary_min . ' to ' . $salary_max; ?></strong>

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

                                                        <blockquote style="font-size: 12px">
                                                            <div class="job_des" style="color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif, solaimanlipi;">
                                                                <h5 style="font-weight: bold; color: rgb(92, 92, 92); margin: 20px 0px 6px;">Job Description</h5>
                                                                <div class=""> <textarea readonly style="padding:10px" cols="80" rows="15"><?php echo $description; ?></textarea> </div>
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
                                                                <div class=""> <textarea readonly style="padding:10px" cols="80" rows="15"><?php echo $requirements; ?></textarea> </div>
                                                            </div>
                                                        </blockquote>
                                                    </div>

                                                    <div class="col-md-4" style="border-style: inset;">
                                                        <div class="panel">
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
                                                        <button <?php echo $apply_class ?> <?php echo $apply_color ?> type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
                                                            <?php echo $apply_txt ?>
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Apply</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">

                                                                        <div class="panel panel-custom">
                                                                            <div class="panel-body form-horizontal">
                                                                                <form method="post" action="#apply" class="form-horizontal" enctype="multipart/form-data">

                                                                                    <label for="">Are you sure you want to apply for this possition as a <?php echo $title ?> </label>
                                                                                    <div class="margin pull-right">
                                                                                        <button name="apply" type="submit" class="btn btn-primary btn-block"> Yes, I'm sure</button>
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

                                <!-- Page footer-->

                                <?php
                                // Apply Logic
                                require_once('../classes.php');
                                $Classes = new Classes();
                                if (isset($_POST['apply'])) {

                                    if ($Classes->profileStatus($user_id) < 90) {
                                        $message = "Your account is " . $Classes->profileStatus($user_id) . "% done. Please complete 
                        your account to increase your chances of success.";
                                        
                                         
                                        echo "<script> alert('.$message.') </script>";
                                        echo "<script> window.location='job_details.php?job=" . $id_ . "' </script>";
                                    }
                                        
                                     else {
                                           $q = mysql_query("INSERT INTO jobs_user_applications (`jobs_job_id`, `user_id`,`job_status`) 
                                VALUES ('$id_', '$user_id','Applied')") or die("Err. " . mysql_error());

                                    if ($q) {
                                        echo "<script> alert('Application sent successfully') </script>";
                                        echo "<script> window.location='job_details.php?job=" . $id_ . "' </script>";
                                    }
                                    }

                                 
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </section>

            </div>

            <?php include '../footer/footer.php'; ?>
            <div class="control-sidebar-bg"></div>
        </div>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="../plugins/fastclick/fastclick.min.js"></script>
        <script src="../dist/js/app.min.js"></script>
        <script src="../dist/js/demo.js"></script>
        <script>
            $(document).ready(function () {
                $('#employee_data').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'csv', 'excel', 'pdf', 'print'
                    ]
                });
            });
        </script>
    </body>

</html>