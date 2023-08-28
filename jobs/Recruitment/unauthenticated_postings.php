<!DOCTYPE html>
<html lang="en">

<?php
$pageTitle = 'Job Details';
include '../includes/oldheaders.php';
?>

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

            @media (max-width: 600px) {
                .con {
                    align-items: center;
                    flex-direction: column;
                }

                .canvas {
                    margin: 1em;
                }

                .alert .alert-success {
                    width: 20em !important;
                }
            }

            @media (min-width: 1200px) {
                .container {
                    width: 95%;
                }

            }

            body {

                font-size: 1.3em;

            }

            .panel-body {
                padding: 15px;
                height: 20em;
            }

            .row {
                margin-left: 0;
                margin-right: 0;
            }

            @media (max-width: 767px) {
                .nav>li {
                    display: contents !important;
                }

                .container .alert-success {
                    margin: 3rem;
                    width: 45em;
                    font-size: 1em;
                }

            }

            @media (max-width: 644px) {

                .container .alert-success {
                    width: 40em;

                }

            }

            @media (max-width: 575px) {

                .container .alert-success {
                    margin-left: auto;
                    margin-right: auto;
                    width: 23em;

                }

            }

            @media (min-width: 992px) {
                .container .alert-success {
                    width: 50em;

                }

            }

            @media (min-width: 992px) {
                .col-md-4 {
                    width: 33.3333%;
                    min-height: 40rem;
                }
            }

            .layout-h .wrapper>section {
                max-width: 100% !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
            
            .topnavbar .navbar-nav > li > a, .topnavbar .navbar-nav > .open > a {
    color: White;
    font-weight: 800;
    font-size:13px;
}

@media only screen and (min-width: 768px){
.topnavbar .navbar-nav > li > a, .topnavbar .navbar-nav > .open > a {
    color: white;
    font-weight: 800;
}}
        </style>
        <header class="topnavbar-wrapper">
            <!-- START Top Navbar-->
            <nav role="navigation" class="navbar topnavbar" style="background: linear-gradient(to right, #02B9FD, #2ECC71) !important;">
                <!-- START navbar header-->
                <!-- END navbar header-->
                <!-- START Nav wrapper-->
                <div class="navbar-collapse">
                    <center>

                        <div class="navbar-header" style="height:66px ; margin-top:1.7rem;">
                            <a class="navbar-brand" href="#" style="border-radius:100px">
                                <?php
                                // echo '<img style="margin-top:-10px;border-radius:100px" src="../../Admin/' . $CompanyObject->getCompanyLogo($companyId) . '" height="58" >';
                                echo '<img style="margin-top:-10px;border-radius:100px" src="/jobs/assets/images/logo45.jpeg" height="58" width="59rem" >';

                                ?>
                            </a>

                        </div>
                        <ul class="nav navbar-nav" style=" font-family: 'Heebo', 'Inter', sans-serif !important; margin-top:1.7rem;">
                            <li><a  href="/index.php">Home</a></li>
                            <li><a  href="unauthenticated_postings.php">All Postings</a></li>
                            <li class="pull-right"><a href="../login.php">Login / Post Listing</a></li>
                        </ul>
                    </center>
                    <!-- START Left navbar-->
                </div>

            </nav>
            <!-- END Top Navbar-->
        </header> <!-- Main section-->

        <?php

        include_once("../includes/dbconnection.php");

        $result = mysql_query("SELECT * FROM jobs_postings 
                                        LEFT JOIN department ON department.dep_id = jobs_postings.dep_id
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
        }
        ?>
        <section>
            <!-- Page content-->
            <hr>
            <br>
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-10">
                            <form action="" method="GET" class="form-inline">
                                <label sty> choose category</label><br>
                                <div class="form-group">
                                    <select name="department" class="form-control">
                                        <option></option>
                                        <?php
                                        $departmentquery = mysql_query("SELECT department,dep_id FROM  department");
                                        while ($row = mysql_fetch_array($departmentquery)) {
                                            $depid = $row["dep_id"];
                                        ?>
                                            <option value="<?php echo $row['department']; ?>"> <?php echo $row['department']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="search" placeholder="Search All">
                                </div>
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a class="btn btn-primary" href="unauthenticated_postings.php">All Jobs</a>
                            </form>

                        </div>
                    </div>
                </div>
            </section>
            <section>
                <!-- Page content-->
                <hr>
                <br>

                <?php
                $searchshow = '';
                $search2 = isset($_GET['search']) ? $_GET['search'] : '';
                $search3 = isset($_GET['department']) ? $_GET['department'] : '';

                if (!empty($search2)) {
                    $searchshow = "You are now viewing search results for $search2";
                }

                if (!empty($search3)) {
                    $searchshow = "You are now viewing results for Category $search3";
                }

                ?>

                <div class="container">
                    <?php if (!empty($searchshow)) : ?>
                        <strong>
                            <p class="alert alert-success"><?php echo $searchshow; ?></p>
                        </strong>
                    <?php endif; ?>
                    <div class="row container">
                        <div class="col-md-18">
                            <?php
                            // Calculate the total number of job postings
                            $queryCount = "SELECT COUNT(*) as total FROM jobs_postings, department 
                            WHERE department.dep_id = jobs_postings.dep_id
                            AND DATE(NOW()) <= expires";
                            $resultCount = mysql_query($queryCount) or die(mysql_error());
                            $rowCount = mysql_fetch_assoc($resultCount);
                            $totalJobs = $rowCount['total'];

                            // Number of job postings to display per page
                            $perPage = 9;

                            // Current page number
                            $currentpage = isset($_GET['page']) ? $_GET['page'] : 1;

                            // Calculate the offset for the query
                            $offset = ($currentpage - 1) * $perPage;

                            // Check if 'search' index exists, otherwise set it to an empty string
                            $search = isset($_GET['search']) ? $_GET['search'] : '';

                            // Check if 'department' index exists, otherwise set it to an empty string
                            $dep = isset($_GET['department']) ? $_GET['department'] : '';

                            // Base query
                            $query = "SELECT jobs_postings.*, employer.comp_name, employer.comp_description, employer.ref_id, department.dep_id, department.department
                            FROM jobs_postings
                            LEFT JOIN department ON department.dep_id = jobs_postings.dep_id
                            LEFT JOIN employer ON employer.id = jobs_postings.emp_id
                            WHERE DATE(NOW()) <= jobs_postings.expires";


                            if (!empty($search)) {
                                $search = mysql_real_escape_string($search);
                                $query .= " AND (jobs_postings.title LIKE '%$search%' OR department.department LIKE '%$search%')";
                            }

                            if (!empty($dep)) {
                                $dep = mysql_real_escape_string($dep);
                                $query .= " AND department.department = '$dep' ";
                            }
                            
                            $query .= " ORDER BY jobs_postings.date DESC";

                            $query .= " LIMIT $offset, $perPage";


                            $result = mysql_query($query) or die(mysql_error());

                            if (mysql_num_rows($result) < 1) {
                                $errorMessage = 'SORRY NO RESULTS FOUND!';
                                echo "<p class='alert alert-danger' style='text-align:center;'>$errorMessage</p>";
                            }

                            while ($row = mysql_fetch_array($result)) {
                                $comp_description = $row['description'];
                                $id_ = $row['id'];
                                $comp = $row['comp_name'];
                                $complogo = $row['ref_id'];
                                $title = $row['title'];
                                $department = $row['department'];
                                $vacancies = $row['vacancies'];
                                $type = $row['type'];
                                $experience = $row['experience'];
                                $salary = $row['salary_min'] . " - " . $row['salary_max'];
                                $info = $row['description'];
                                $qualifications = $row['qualifications'];
                                $status = $row['status'];
                                $rawdate = $row['date'];
                                $date = date("d M, Y", strtotime($rawdate));
                                $rawExpires = $row['expires'];
                                $expires = date("d M, Y", strtotime($rawExpires));
                                $location = $row['city'] . ", " . $row['region'] . ", " . $row['country'];

                                $ck_q = mysql_query("SELECT id FROM jobs_user_applications WHERE jobs_job_id = '$id_'
                                ") or die(mysql_error());

                                if (mysql_num_rows($ck_q) > 0) {
                                    $applied = '
                                        <div class="canvas canvas6">
                                            <div class="spinner6 p1"></div>
                                            <div class="spinner6 p2"></div>
                                            <div class="spinner6 p3"></div>
                                            <div class="spinner6 p4"></div>
                                        </div>
                                        ';
                                } else {
                                    $applied = "";
                                }

                                $logo_ref = '../employer/company_logo/' . $complogo;

                                if (file_exists($logo_ref)) {
                                    // Logo is found, continue with the existing $logo_ref value
                                } else {
                                    // Logo is not found, use a default logo path
                                    $logo_ref = '../employer/company_logo/nologo.png';
                                }


                            ?>

                                <div class="col-md-4">
                                    <div class="panel ">
                                        <div class="panel-heading panel-primary" style="height:11rem">
                                            
                                            <strong><span style="float: right; color:<?php echo "red" ?>">
                                                    <?php echo $applied; ?> </span>
                                            </strong>
                                        </div>
                                        <strong Style="margin:4.8rem; line-height:4rem;"><?php echo $comp; ?> </strong>
                                        <br><br>
                                        <div class="panel-body" style="background-color: #f5f5f5;">
                                            <p class="m0">
                                                <strong>Job Title: <?php echo $title; ?> </strong>
                                            </p>
                                            <p class="m0">
                                                <strong>Job Location: <?php echo $location; ?> </strong>
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

                                    <a href="job_details_unauth?job=<?php echo $id_ ?>" class="btn btn-primary btn-block" style=" margin-bottom:2em;">
                                        View Job
                                    </a>
                                </div>
                            <?php }
                            ?>
                            <?php
                            // Generate pagination links
                            $totalPages = ceil($totalJobs / $perPage);
                            $pagination = '';
                            if ($totalPages > 1) {
                                $pagination .= '<ul class="pagination">';

                                if ($currentpage > 1) {
                                    $pagination .= '<li><a href="?page=' . ($currentpage - 1);
                                    if (!empty($search)) {
                                        $pagination .= '&search=' . urlencode($search);
                                    }
                                    if (!empty($dep)) {
                                        $pagination .= '&department=' . urlencode($dep);
                                    }
                                    $pagination .= '">Previous</a></li>';
                                }
                                echo $dep;

                                for ($i = 1; $i <= $totalPages; $i++) {
                                    $pagination .= '<li ';
                                    if ($i == $currentpage) {
                                        $pagination .= 'class="active"';
                                    }
                                    $pagination .= '><a href="?page=' . $i;
                                    if (!empty($search)) {
                                        $pagination .= '&search=' . urlencode($search);
                                    }
                                    if (!empty($dep)) {
                                        $pagination .= '&department=' . urlencode($dep);
                                    }
                                    $pagination .= '">' . $i . '</a></li>';
                                }

                                if ($currentpage < $totalPages) {
                                    $pagination .= '<li><a href="?page=' . ($currentpage + 1);
                                    if (!empty($search)) {
                                        $pagination .= '&search=' . urlencode($search);
                                    }
                                    if (!empty($dep)) {
                                        $pagination .= '&department=' . urlencode($dep);
                                    }
                                    $pagination .= '">Next</a></li>';
                                }

                                $pagination .= '</ul>';
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </section>

            <center>
                <!-- Display the pagination links -->
                <div class="pagination-container" style="">
                    <?php echo $totalPages > 1 ? $pagination : ''; ?>
                </div>
            </center>
    </div>

    <?php include '../footer/footer.php'; ?>
    <div class="control-sidebar-bg"></div>
    </div>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <script src="../dist/js/app.min.js"></script>
    <script src="../dist/js/demo.js"></script>
</body>

</html>