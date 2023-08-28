<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jobs - HR and Payroll.</title>
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

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <a href="" class="logo">
                <span class="logo-lg"><b>

                        <?php
                        // error_reporting(0);
                        session_start();
                        $_SESSION['activeLink'] = 'jobs';

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

        <head>
            <link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.min.css">
            <link rel="stylesheet" type="text/css" href="../../css/dataTables.bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="../../css/buttons.dataTables.min.css">
            <link rel="stylesheet" type="text/css" href="../../css/style.css">

        </head>

        <div class="content-wrapper">
            <div>
                <ol class="breadcrumb">
                    <li><a href="#">Talent</a></li>
                    <li class="active">List</li>
                </ol>
            </div>
            <div class="panel panel-default">
                <div class="panel-body" style="font-size:14px;">


                    <table id="maintable" class="display compact cell-border" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Applicant Names</th>
                                <th>Job Assigned</th>
                                <th>Stage</th>
                                <th>Talent Pool</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php


                            $pool_id = $_GET['pool_id'];
                            $user_q = mysql_query("SELECT talent_pool.title,fname,lname, jobs_postings.title as job,
                        jobs_user_applications.date AS date_applied,job_status,jobs_user_applications.id as job_applied_id, 
                        jobs_user_applications.user_id AS appcant_user_id FROM `jobs_user_applications`
                        INNER JOIN jobs_users on jobs_users.id=jobs_user_applications.user_id
                        INNER JOIN jobs_postings on jobs_postings.id=jobs_user_applications.jobs_job_id 
                        LEFT JOIN talent_pool on talent_pool.id=talent_pool_id
                        WHERE talent_pool.id='$pool_id'");



                            while ($row = mysql_fetch_array($user_q)) {
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
                                <td>' . $title . '</td>
                                <td>' . $job_status . '</td>
                                <td>' . $talent_pool . '</td>
                                <td>
        
                                <a class="btn btn-danger" style="padding:2px; padding-left: 10px; padding-right:10px;" href="remove-talent.php?id=' . $appcant_user_id . '&pool=' . $pool_id . '">Remove</a>
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
                        <tfoot style="background-color: #c0c0c0; color: #ffffff; font-size: 0.9em; ">
                            <tr>
                                <th>Talent Pool Name</th>
                                <th>Talent Description</th>
                                <th>Date Created</th>
                                <th>No Candidates</th>
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