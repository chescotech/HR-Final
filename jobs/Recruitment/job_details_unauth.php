<?php
error_reporting(0);
ini_set('display_errors', 0);

?>

<!DOCTYPE html>
<html>

<?php $pageTitle = 'Job Details'; ?>
<?php include '../includes/oldheaders.php' ?>

<body class="hold-transition skin-blue sidebar-mini">

    <div class="">

        <?php include '../navigation_panel/jobsnav.php'; ?>

        <div class="">

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
                $result = mysqli_query($link, "SELECT * FROM jobs_postings 
                                                LEFT JOIN department ON department.dep_id = jobs_postings.dep_id
                                                WHERE status = 'Published'
                                                AND DATE(expires) > DATE(NOW())
                                                ") or die(mysqli_error($link));
                $view_details = "";
                while ($row = mysqli_fetch_array($result)) {
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
                <div class="">

                    <div class="row container">
                        <div class="col-md-12">
                            <?php
                            require_once('../classes.php');
                            $Classes = new Classes();

                            $id_ = $_GET['job'];
                            $query = "SELECT jobs_postings.*, department.dep_id, employer.comp_description, employer.web_url, employer.ref_id, employer.id, employer.comp_name, department.department FROM jobs_postings 
                            LEFT JOIN department ON department.dep_id = jobs_postings.dep_id
                            LEFT JOIN employer ON employer.id = jobs_postings.emp_id
                            WHERE jobs_postings.id = $id_ ";
                            $result = mysqli_query($link, $query) or die(mysqli_error($link));
                            while ($row = mysqli_fetch_array($result)) {
                                $title = $row['title'];
                                $department = $row['department'];
                                $vacancies = $row['vacancies'];
                                $comp = $row['comp_description'];
                                $compname = $row['comp_name'];
                                $complogo = $row['ref_id'];
                                $website = $row['web_url'];
                                $type = $row['type'];
                                $regno = $row['reg_number'];
                                $experience = $row['experience'];
                                $salary_min = $row['salary_min'];
                                $salary_max = $row['salary_max'];
                                $show_salary = $row['show_salary'];
                                $description = $row['description'];
                                $requirements = $row['requirements'];
                                $qualifications = $row['qualifications'];
                                $poster_reg = $row['reg_number'];
                                $status = $row['status'];
                                $rawdate = $row['date'];
                                $date = date("d M, Y", strtotime($rawdate));
                                $rawExpires = $row['expires'];
                                $expires = date("d M, Y", strtotime($rawExpires));
                            }
                            // Check if we done applied this before
                            $ck_q = mysqli_query($link, "SELECT id FROM jobs_user_applications WHERE jobs_job_id = '$id_'
                                                AND user_id = '$user_id' ") or die(mysqli_error($link));

                            if (mysqli_num_rows($ck_q) > 0) {
                                $apply_txt = "Already Applied";
                                $apply_class = "disabled";
                                $apply_color = "style='background-color:#fc6603'";
                            } else {
                                $apply_txt = "Login to Apply";
                                $apply_class = "apply";
                                $apply_color = "";
                            }

                            $logo_ref = '../employer/company_logo/' . $complogo;

                            if (file_exists($logo_ref)) {
                                // Logo is found, continue with the existing $logo_ref value
                            } else {
                                // Logo is not found, use a default logo path
                                $logo_ref = '../employer/company_logo/nologo.png';
                            }

                            ?>


                            <!-- Page content-->
                            <div class="">
                                <div class="container btn btn-primary" style="width: 14em; list-style:none; text-decoration:none; margin-left:3rem; margin-bottom:-3rem;"> <a style="list-style:none; text-decoration:none; color:WHITE;" href="unauthenticated_postings.php?department=&search=<?php echo $department ?>">View Similar Jobs</a></div>
                                <div class="row">
                                    <div class="col-lg-20">
                                        <div class="panel panel-custom">
                                            <div class="panel-heading panel-primary" style=" margin:5rem; padding:2rem ; position:relative;">
                                                <div class="navbar-header" style="height:7rem">
                                                    <a class="navbar-brand" href="#" style="border-radius:100px">
                                                        <?php
                                                        echo '<img style="margin:-1.5rem;border-radius:100px; height:6.8rem; width:7rem;" src="' . $logo_ref . '">';
                                                        ?>
                                                    </a>
                                                </div>
                                                <br>
                                                <strong style="margin:1.5rem;"><?php echo $compname; ?>: <span style="margin:0.5rem;"><?php echo $title; ?> </span> <span style="float: right; color:<?php echo "red" ?>">



                                                        <button id="loginBtn" <?php echo $apply_class ?> <?php echo $apply_color ?> type="button" class="btn btn-primary btn-block" style="width:20rem;" data-toggle="modal" data-target="#exampleModal">
                                                            <?php echo $apply_txt ?>
                                                        </button></span>
                                                </strong>
                                                <br><br>
                                            </div>

                                            <?php
                                            if (!empty($website)) {
                                                $site = $website;
                                            } else {
                                                $site = 'N/A';
                                            }
                                            ?>

                                            <div class="panel-body form-horizontal">
                                                <div class="col-20 " style=" margin:5rem; padding:2rem ; position:relative;">

                                                    <div class="panel">
                                                        <div class="panel-heading m0 ">
                                                            <strong>Company Description</strong>
                                                            x
                                                        </div>
                                                        <div class="panel-body" style="height:20rem">
                                                            <div class="">
                                                                <textarea style="padding:10px; align-text:justify; width:100%; height:20rem;" readonly id=""> <?php echo $comp; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Button trigger modal -->

                                                </div>
                                                <br>

                                                <div class="col" style="margin:5rem; padding:2rem; position:relative;">
                                                    <p>
                                                        <strong style="font-size: 20px;"><?php echo $title ?> ( <?php echo $department ?>) </strong>
                                                    </p>
                                                    <p class="m0">
                                                        <strong>Experience: <?php echo $experience; ?></strong>

                                                    </p>
                                                    <p class="m0">
                                                        <strong>Salary Range: <?php echo $show_salary == 'false' ? 'N/A'  : $salary_min . ' to ' . $salary_max; ?></strong>
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

                                                    <div class="job_des" style="color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif, solaimanlipi;">
                                                        <h5 style="font-weight: bold; color: rgb(92, 92, 92); margin: 20px 0px 6px;">Job Description</h5>
                                                        <div class="">
                                                            <textarea style="padding:10px; align-text:justify; width:100%; height:20rem;" readonly id=""><?php echo $description; ?></textarea>
                                                        </div>
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
                                                        <div class="">
                                                            <div class=""> <textarea readonly style="padding:10px; align-text:justify; width:100%; height:20rem;"><?php echo $requirements; ?></textarea> </div>
                                                        </div>
                                                    </div>

                                                    <!-- <button id="loginBtn" <?php // echo $apply_class 
                                                                                ?> <?php // echo $apply_color 
                                                                                    ?> type="button" class="btn btn-primary btn-block" style="width:20rem;" data-toggle="modal" data-target="#exampleModal">
                                                        <?php // echo $apply_txt 
                                                        ?>
                                                    </button> -->
                                                </div>


                                                <br>

                                            </div>
                                        </div>
                                    </div>
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
    <script>
        $(document).ready(function() {
            $('#loginBtn').click(function() {
                alert('Login And Fill in details to apply for job');
                window.location.href = '../login.php'; // Replace with your login page URL
            });
        });
    </script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <script src="../dist/js/app.min.js"></script>
    <script src="../dist/js/demo.js"></script>

</body>

</html>