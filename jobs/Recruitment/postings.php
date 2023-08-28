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

    <!-- loading stuff -->
    <style>
        .con {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 0 auto;
            max-width: 650px;
            min-width: 200px;
        }

        .canvas {
            align-items: center;
            /* background: #eeeeee; */
            /* border-radius: 50%; */
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            display: flex;
            height: 2.6em;
            justify-content: center;
            margin: -0.5em 1em 1em 1em;
            width: 2.6em;
        }

        .spinner6 {
            background: #fc6603;
            border-radius: 50%;
            height: 1em;
            margin: .1em;
            width: 1em;
        }

        .p1 {
            animation: fall 1s linear .3s infinite;
        }

        .p2 {
            animation: fall 1s linear .2s infinite;
        }

        .p3 {
            animation: fall 1s linear .1s infinite;
        }

        .p4 {
            animation: fall 1s linear infinite;
        }

        @keyframes fall {
            0% {
                transform: translateY(-15px);
            }

            25%,
            75% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-15px);
            }
        }

        /* Spinner 6 ends here */

        @media (max-width: 600px) {
            .con {
                align-items: center;
                flex-direction: column;
            }

            .canvas {
                margin: 1em;
            }
        }
    </style>

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
                    echo ' Job Postings';
                    ?>
                </h1>
            </section>



            <section>
                <!-- Page content-->
                <hr>
                <br>
                <div class="container">

                    <div class="row container">
                        <div class="col-md-12">
                            <?php
                            $user_id = $_SESSION['job_user_id'];
                            $query = "SELECT * FROM jobs_postings 
                            LEFT JOIN department ON department.dep_id = jobs_postings.dep_id
                             WHERE DATE(NOW()) <= expires
                            ";
                            $result = mysql_query($query) or die(mysql_error());
                            while ($row = mysql_fetch_array($result)) {
                                $id_ = $row['id'];
                                $title = $row['title'];
                                $department = $row['department'];
                                $vacancies = $row['vacancies'];
                                $type = $row['type'];
                                $experience = $row['experience'];
                                $salary = $row['salary_min']." - ".$row['salary_max'];
                                $info = $row['description'];
                                $qualifications = $row['qualifications'];
                                $status = $row['status'];
                                $rawdate = $row['date'];
                                $date = date("d M, Y", strtotime($rawdate));
                                $rawExpires = $row['expires'];
                                $expires = date("d M, Y", strtotime($rawExpires));
                                $location = $row['city'].", ".$row['region'].", ".$row['country'];

                                $ck_q = mysql_query("SELECT id FROM jobs_user_applications WHERE jobs_job_id = '$id_'
                                            AND user_id = '$user_id' ") or die(mysql_error());

                                if (mysql_num_rows($ck_q) > 0) {
                                    $applied = '
                                        <div class="canvas canvas6">
                                            <div class="spinner6 p1"></div>
                                            <div class="spinner6 p2"></div>
                                            <div class="spinner6 p3"></div>
                                            <div class="spinner6 p4"></div>
                                        </div>
                                        ';
                                }else{
                                    $applied = "";
                                }
                            ?>

                                <div class="col-md-4" style=" border-style: inset;">
                                    <div class="panel ">
                                        <div class="panel-heading panel-primary">
                                            <strong><?php echo $title; ?> <span style="float: right; color:<?php echo "red" ?>">
                                                    <?php echo $applied; ?> </span> </strong>
                                        </div>
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

                                    <!-- Button trigger modal -->
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