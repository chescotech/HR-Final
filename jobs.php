<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="attendance, client management, finance, freelance, freelancer, goal tracking, Income Managment, lead management, payroll, project management, project manager, support ticket, task management, timecard">
        <meta name="keywords" content="	attendance, client management, finance, freelance, freelancer, goal tracking, Income Managment, lead management, payroll, project management, project manager, support ticket, task management, timecard">
        <title>Job Details</title>
        <!-- =============== VENDOR STYLES ===============-->
        <!-- FONT AWESOME-->
        <link rel="stylesheet" href="https://ziscoerp.com/assets/plugins/fontawesome/css/font-awesome.min.css">
        <!-- SIMPLE LINE ICONS-->
        <link rel="stylesheet" href="https://ziscoerp.com/assets/plugins/simple-line-icons/css/simple-line-icons.css">
        <!-- ANIMATE.CSS-->
        <link rel="stylesheet" href="https://ziscoerp.com/assets/plugins/animate.css/animate.min.css">
        <!-- =============== PAGE VENDOR STYLES ===============-->

        <!-- =============== APP STYLES ===============-->
        <!-- =============== BOOTSTRAP STYLES ===============-->
        <link rel="stylesheet" href="https://ziscoerp.com/assets/css/bootstrap.min.css" id="bscss">
        <link rel="stylesheet" href="https://ziscoerp.com/assets/css/app.css" id="maincss">
        <link id="autoloaded-stylesheet" rel="stylesheet" href="https://ziscoerp.com/assets/css/bg-white.css">



        <link rel="stylesheet" href="https://ziscoerp.com/assets/css/timepicker.min.css">

        <link href="https://ziscoerp.com/assets/plugins/summernote/summernote.min.css" rel="stylesheet" type="text/css">

        <!-- bootstrap-slider -->
        <link href="https://ziscoerp.com/assets/plugins/bootstrap-slider/bootstrap-slider.min.css" rel="stylesheet">
        <!-- chartist -->
        <link href="https://ziscoerp.com/assets/plugins/morris/morris.min.css" rel="stylesheet">

        <link href="https://ziscoerp.com/modules/mailbox/assets/css/styles.css" rel="stylesheet" type="text/css">
        <!--- bootstrap-select ---->
        <link href="https://ziscoerp.com/assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
        <link href="https://ziscoerp.com/assets/plugins/chat/chat.min.css" rel="stylesheet">

        <!-- JQUERY-->
        <script src="https://ziscoerp.com/assets/js/jquery.min.js"></script>

        <link href="https://ziscoerp.com/asset/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://ziscoerp.com/asset/js/bootstrap-toggle.min.js"></script>

    </head>

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
            </style>
            <header class="topnavbar-wrapper">
                <!-- START Top Navbar-->
                <nav role="navigation" class="navbar topnavbar" style="background-color:#3c8dbc;">
                    <!-- START navbar header-->
                    <div class="navbar-header">

                    </div>
                    <!-- END navbar header-->
                    <!-- START Nav wrapper-->
                    <div class="navbar-collapse collapse">
                        <!-- START Left navbar-->
                        <ul class="nav navbar-nav" style=" font-family: Arial, Helvetica, sans-serif, solaimanlipi;">
                            <li><span style="color: #eee!important">Job Postings</span></li>
                            <li class="pull-right"><a style="color: #eee!important" href="login">Login</a></li>
                        </ul>
                </nav>
                <!-- END Top Navbar-->
            </header> <!-- Main section-->

            <?php include_once("include/dbconnection.php"); ?>


            <section>
                <!-- Page content-->
                <div class="content-wrapper">

                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            $query = "SELECT * FROM jobs_postings 
                           LEFT JOIN department ON department.dep_id = jobs_postings.dep_id  WHERE NOW()<= expires ";
                            $result = mysql_query($query) or die(mysql_error());
                            while ($row = mysql_fetch_array($result)) {
                                $id_ = $row['id'];
                                $title = $row['title'];
                                $department = $row['department'];
                                $vacancies = $row['vacancies'];
                                $type = $row['type'];
                                $experience = $row['experience'];
                                //  $salary = $row['salary'];
                                //$info = $row['info'];
                                $qualifications = $row['qualifications'];
                                $status = $row['status'];
                                $rawdate = $row['date'];
                                $date = date("d M, Y", strtotime($rawdate));
                                $rawExpires = $row['expires'];
                                $expires = date("d M, Y", strtotime($rawExpires));
                                ?>

                                <div class="col-md-4">
                                    <div class="panel " style="border: none">
                                        <div class="panel-heading m0 job_summery">
                                            <strong><?php echo $title; ?></strong>
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
            <!-- Page footer-->




        </div>
        <script type="text/javascript">
            $(window).load(function () {
                $('#loader-wrapper').delay(250).fadeOut(function () {
                    $('#loader-wrapper').remove();
                });
            });
        </script>
        <div class="pusher"></div>
        <!-- ===============  SCRIPTS ===============-->
        <!-- MODERNIZR-->
        <script src="https://ziscoerp.com/assets/plugins/modernizr/modernizr.custom.js"></script>
        <!-- BOOTSTRAP-->
        <script src="https://ziscoerp.com/assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- STORAGE API-->
        <script src="https://ziscoerp.com/assets/plugins/jQuery-Storage-API/jquery.storageapi.min.js"></script>
        <!-- ANIMO-->
        <script src="https://ziscoerp.com/assets/plugins/animo.js/animo.min.js"></script>
        <!-- SELECT2-->
        <script src="https://ziscoerp.com/assets/plugins/select2/dist/js/select2.min.js"></script>
        <!-- Data Table -->
        <script src="https://ziscoerp.com/assets/plugins/dataTables/js/dataTables.buttons.min.js"></script>
        <script src="https://ziscoerp.com/assets/plugins/dataTables/js/buttons.print.min.js"></script>
        <script src="https://ziscoerp.com/assets/plugins/dataTables/js/buttons.colVis.min.js"></script>
        <script src="https://ziscoerp.com/assets/plugins/dataTables/js/jszip.min.js"></script>
        <script src="https://ziscoerp.com/assets/plugins/dataTables/js/pdfmake.min.js"></script>
        <script src="https://ziscoerp.com/assets/plugins/dataTables/js/vfs_fonts.js"></script>
        <script src="https://ziscoerp.com/assets/plugins/dataTables/js/buttons.html5.min.js"></script>
        <script src="https://ziscoerp.com/assets/plugins/dataTables/js/dataTables.select.min.js"></script>
        <script src="https://ziscoerp.com/assets/plugins/dataTables/js/dataTables.responsive.min.js"></script>
        <script src="https://ziscoerp.com/assets/plugins/dataTables/js/dataTables.bootstrap.min.js"></script>
        <script src="https://ziscoerp.com/assets/plugins/dataTables/js/dataTables.bootstrapPagination.js"></script>
        <!-- summernote Editor -->
        <script src="https://ziscoerp.com/assets/plugins/summernote/summernote.min.js"></script>

        <script src="https://ziscoerp.com/assets/js/timepicker.min.js"></script>
        <!-- bootstrap-slider -->
        <script src="https://ziscoerp.com/assets/plugins/bootstrap-slider/bootstrap-slider.min.js"></script>
        <!-- bootstrap-editable -->
        <script src="https://ziscoerp.com/assets/plugins/bootstrap-editable/bootstrap-editable.min.js"></script>
        <!-- jquery-classyloader -->
        <script src="https://ziscoerp.com/assets/plugins/jquery-classyloader/jquery.classyloader.min.js"></script>
        <!-- =============== Toastr ===============-->
        <script src="https://ziscoerp.com/assets/js/toastr.min.js"></script>
        <!-- =============== Toastr ===============-->
        <script src="https://ziscoerp.com/assets/js/jasny-bootstrap.min.js"></script>
        <!-- EASY PIE CHART-->
        <script src="https://ziscoerp.com/assets/plugins/easy-pie-chart/jquery.easypiechart.min.js"></script>

        <!-- sparkline CHART-->
        <script src="https://ziscoerp.com/assets/plugins/sparkline/index.min.js"></script>

        <script src="https://ziscoerp.com/assets/plugins/parsleyjs/parsley.min.js"></script>

        <!--- bootstrap-select ---->
        <link href="https://ziscoerp.com/assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
        <script src="https://ziscoerp.com/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
        <!--- push_notification ---->
        <script src="https://ziscoerp.com/assets/plugins/push_notification/push_notification.min.js"></script>

        <script src='https://ziscoerp.com/assets/plugins/jquery-validation/jquery.validate.min.js'></script>
        <script src='https://ziscoerp.com/assets/plugins/jquery-validation/jquery.form.min.js'></script>
        <!--- dropzone ---->
        <!--- malihu-custom-scrollbar ---->
        <link rel="stylesheet" type="text/css" href="https://ziscoerp.com/assets/plugins/malihu-custom-scrollbar/jquery.mCustomScrollbar.min.css">
        <script type="text/javascript" src="https://ziscoerp.com/assets/plugins/malihu-custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
        <!-- =============== APP SCRIPTS ===============-->
        <script src="https://ziscoerp.com/assets/js/app.js"></script>

    </body>

</html>
<script type="text/javascript">
            $(document).ready(function () {
                $('.complete input[type="checkbox"]').change(function () {
                    var task_id = $(this).data().id;
                    var task_complete = $(this).is(":checked");

                    var formData = {
                        'task_id': task_id,
                        'task_progress': 100,
                        'task_status': 'completed'
                    };
                    $.ajax({
                        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                        url: 'https://ziscoerp.com/admin/tasks/completed_tasks/' + task_id, // the url where we want to POST
                        data: formData, // our data object
                        dataType: 'json', // what type of data do we expect back from the server
                        encode: true,
                        success: function (res) {
                            console.log(res);
                            if (res) {
                                location.reload();
                            } else {
                                alert('There was a problem with AJAX');
                            }
                        }
                    })

                });

            });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#permission_user_1').hide();
        $("div.action_1").hide();
        $("input[name$='permission']").on("click", function () {
            $("#permission_user_1").removeClass('show');
            if ($(this).attr("value") == "custom_permission") {
                $("#permission_user_1").show();
            } else {
                $("#permission_user_1").hide();
            }
        });
        $("input[name$='assigned_to[]']").on("click", function () {
            var user_id = $(this).val();
            $("#action_1" + user_id).removeClass('show');
            if (this.checked) {
                $("#action_1" + user_id).show();
            } else {
                $("#action_1" + user_id).hide();
            }

        });
    });
</script>
<!-- Modal -->
<style type="text/css">
    .bootstrap-timepicker-widget.dropdown-menu.open {
        display: inline-block;
        z-index: 99999 !important;
    }
</style>
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>
<link rel="stylesheet" href="https://ziscoerp.com/assets/plugins/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="https://ziscoerp.com/assets/plugins/select2/dist/css/select2-bootstrap.min.css">
<script src="https://ziscoerp.com/assets/plugins/select2/dist/js/select2.min.js"></script>
<!-- =============== Datepicker ===============-->
<link rel="stylesheet" href="https://ziscoerp.com/assets/css/datepicker.min.css">
<!-- =============== timepicker ===============-->
<link rel="stylesheet" href="https://ziscoerp.com/assets/css/timepicker.min.css">
<script src="https://ziscoerp.com/assets/js/timepicker.min.js"></script>



<link rel="stylesheet" href="https://ziscoerp.com/assets/plugins/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="https://ziscoerp.com/assets/plugins/select2/dist/css/select2-bootstrap.min.css">
<script src="https://ziscoerp.com/assets/plugins/select2/dist/js/select2.min.js"></script>
<!-- =============== Datepicker ===============-->
<link rel="stylesheet" href="https://ziscoerp.com/assets/css/datepicker.min.css">

<!-- =============== timepicker ===============-->
<link rel="stylesheet" href="https://ziscoerp.com/assets/css/timepicker.min.css">
<script src="https://ziscoerp.com/assets/js/timepicker.min.js"></script>


<script src="https://ziscoerp.com/assets/plugins/parsleyjs/parsley.min.js"></script>