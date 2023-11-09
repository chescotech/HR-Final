<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Job Postings</title>
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
                    echo ' My Applications';
                    ?>
                </h1>
            </section>

            <section>
                <hr>
                <br>
                <div class="container">

                    <div class="row container">
                        <div class="col-md-12">
                            <?php
                            $user_id = $_SESSION['job_user_id'];
                            $query = "SELECT * FROM jobs_user_applications
                                INNER JOIN jobs_postings ON jobs_postings.id = jobs_user_applications.jobs_job_id
                            LEFT JOIN department ON department.dep_id = jobs_postings.dep_id
                            WHERE user_id = '$user_id' 
                            ";
                            $result = mysqli_query($link, $query) or die(mysqli_error($link));
                            while ($row = mysqli_fetch_array($result)) {
                                $id_ = $row['id'];
                                $title = $row['title'];
                                $department = $row['department'];
                                $vacancies = $row['vacancies'];
                                $type = $row['type'];
                                $experience = $row['experience'];
                                $salary = $row['salary_min'] . " - " . $row['salary_max'];
                                $info = $row['description'];
                                $qualifications = $row['qualifications'];
                                $status = $row['job_status'];
                                $rawdate = $row['date'];
                                $date = date("d M, Y", strtotime($rawdate));
                                $rawExpires = $row['expires'];
                                $expires = date("d M, Y", strtotime($rawExpires));

                                if ($status == "Unread") {
                                    $st_color = "#667372";
                                } elseif ($status == "Denied") {
                                    $st_color = "red";
                                } elseif ($status == "Acceppted") {
                                    $st_color = "#1c782b";
                                } elseif ($status == "Pending") {
                                    $st_color = "#fc6603";
                                }

                            ?>

                                <div class="col-md-4" style=" border-style: inset;">
                                    <div class="panel ">
                                        <div class="panel-heading panel-primary">
                                            <strong><?php echo $title; ?> <span style="float: right; color:<?php echo $st_color ?>">
                                                    <i class="fa fa-circle" aria-hidden="true"></i> <?php echo $status; ?> </span> </strong>
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

                                    <a href="job_details.php?job=<?php echo $id_ ?>" class="btn btn-primary btn-block">
                                        View Job
                                    </a>
                                </div>
                            <?php }
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
        $(document).ready(function() {
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