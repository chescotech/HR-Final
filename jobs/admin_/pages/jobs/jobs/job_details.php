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
                        <li><a style="color: #eee!important" href="job-list">All Postings</a></li>
                        <!-- <li class="pull-right"><a style="color: #eee!important" href="login">Login</a></li> -->
                    </ul>
            </nav>
            <!-- END Top Navbar-->
        </header> <!-- Main section-->

        <?php
        include_once("../../../../include/dbconnection.php");
        $id_ = $_GET['job'];
        $query = "SELECT * FROM jobs_postings 
            LEFT JOIN department ON department.dep_id = jobs_postings.dep_id
            WHERE id = $id_ ";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        while ($row = mysqli_fetch_array($result)) {
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
        ?>

        <section>
            <!-- Page content-->
            <div class="content-wrapper">

                <div class="row">
                    <div class="col-lg-12">

                        <div class="panel panel-custom">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <strong>Job Details</strong>
                                </div>
                            </div>
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
                                            <textarea style="padding:10px; allig-text:justify" readonly id="" cols="80" rows="15"><?php echo $description; ?></textarea>
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

                                <div class="col-md-4">
                                    <div class="panel " style="border-style: inset;">
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
                                                <strong>Salary Range: <?php echo $salary_min . ' to ' . $salary_max; ?></strong>

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
                                    <!-- <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
                                        Apply Now
                                    </button> -->

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
                                                        <div class="panel-heading">
                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                                            <div class="panel-title">
                                                                <strong><?php echo $title ?> </strong>
                                                            </div>
                                                        </div>
                                                        <div class="panel-body form-horizontal">
                                                            <form method="post" action="#apply" class="form-horizontal" enctype="multipart/form-data">
                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label">Name <span class="required"> *</span></label>
                                                                    <div class="col-sm-8">
                                                                        <div class="input-group">
                                                                            <!-- <span class="input-group-addon" id=""><i class="fa fa-user"></i></span> -->
                                                                            <input required="" type="text" name="name" class="form-control" placeholder="Enter Full Name">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label">Email <span class="required"> *</span></label>
                                                                    <div class="col-sm-8">
                                                                        <div class="input-group">
                                                                            <!-- <span class="input-group-addon" id=""><i class="fa fa-envelope"></i></span> -->
                                                                            <input required="" type="text" data-parsley-type="email" name="email" class="form-control" placeholder="Enter Email Address">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label">Mobile <span class="required"> *</span></label>
                                                                    <div class="col-sm-8">
                                                                        <div class="input-group">
                                                                            <!-- <span class="input-group-addon" id=""><i class="fa fa-phone"></i></span> -->
                                                                            <input required="" type="text" data-parsley-type="number" name="mobile" class="form-control" placeholder="Enter Mobile Number ">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label">Cover Letter </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span>
                                                                                <span class="fileinput-exists">Change</span>
                                                                                <input required="" type="file" name="cover">
                                                                            </span>
                                                                            <span class="fileinput-filename"></span>
                                                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none;">×</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label">Resume <span class="required"> *</span></label>
                                                                    <div class="col-sm-9">
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span>
                                                                                <span class="fileinput-exists">Change</span>
                                                                                <input required="" type="file" name="cv">
                                                                            </span>
                                                                            <span class="fileinput-filename"></span>
                                                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none;">×</a>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="margin pull-right">
                                                                    <button name="apply" type="submit" class="btn btn-primary btn-block"> Save</button>
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
        </section>
        <!-- Page footer-->

        <?php
        // Apply Logic
        if (isset($_POST['apply'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $cover = $_FILES["cover"]["name"];
            $cv = $_FILES["cv"]["name"];
            // return var_dump($cv);
            // upload cover letter
            $target_dir = "files/covers/";
            $target_file = $target_dir . basename($cover);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (move_uploaded_file($_FILES["cover"]["tmp_name"], $target_file)) {
                echo "Cover Letter has been uploaded.";
            } else {
                return "Sorry, there was an error uploading your file.";
            }
            // upload CV
            $target_dir = "files/cv/";
            $target_file = $target_dir . basename($cv);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file)) {
                echo "CV has been uploaded.";
            } else {
                return "Sorry, there was an error uploading your file.";
            }

            $q = mysqli_query($link, "INSERT INTO applications (`posting_id`, `name`, `email`, `mobile`, `cover`, `cv`,`status`) 
                                VALUES ('$id_', '$name', '$email', '$mobile', '$cover', '$cv','Unread')") or die("Err. " . mysqli_error($link));
        }
        ?>

    </div>
    <script type="text/javascript">
        $(window).load(function() {
            $('#loader-wrapper').delay(250).fadeOut(function() {
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
    $(document).ready(function() {
        $('.complete input[type="checkbox"]').change(function() {
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
                success: function(res) {
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
    $(document).ready(function() {
        $('#permission_user_1').hide();
        $("div.action_1").hide();
        $("input[name$='permission']").on("click", function() {
            $("#permission_user_1").removeClass('show');
            if ($(this).attr("value") == "custom_permission") {
                $("#permission_user_1").show();
            } else {
                $("#permission_user_1").hide();
            }
        });
        $("input[name$='assigned_to[]']").on("click", function() {
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

<script type="text/javascript">
    $('#myModal_lg').on('loaded.bs.modal', function() {
        $(function() {
            $('.selectpicker').selectpicker({});
            $('[data-toggle="tooltip"]').tooltip();

            $('.select_box').select2({
                theme: 'bootstrap',
            });
            $('.select_multi').select2({
                theme: 'bootstrap',
            });
            $('.start_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayBtn: "linked"
                // update "toDate" defaults whenever "fromDate" changes
            }).on('changeDate', function() {
                // set the "toDate" start to not be later than "fromDate" ends:
                $('.end_date').datepicker('setStartDate', new Date($(this).val()));
            });

            $('.end_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayBtn: "linked"
                // update "fromDate" defaults whenever "toDate" changes
            }).on('changeDate', function() {
                // set the "fromDate" end to not be later than "toDate" starts:
                $('.start_date').datepicker('setEndDate', new Date($(this).val()));
            });
            $('.datepicker').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayBtn: "linked",
            });
            $('.monthyear').datepicker({
                autoclose: true,
                startView: 1,
                format: 'yyyy-mm',
                minViewMode: 1,
            });
            $('.timepicker').timepicker();

            $('.timepicker2').timepicker({
                minuteStep: 1,
                showSeconds: false,
                showMeridian: false,
                defaultTime: false
            });
            $('.textarea').summernote({
                codemirror: { // codemirror options
                    theme: 'monokai'
                }
            });
            $('.textarea_2').summernote({
                height: 100,
                codemirror: { // codemirror options
                    theme: 'monokai'
                }
            });
            $('.note-toolbar .note-fontsize,.note-toolbar .note-help,.note-toolbar .note-fontname,.note-toolbar .note-height,.note-toolbar .note-table').remove();

            $('input.select_one').on('change', function() {
                $('input.select_one').not(this).prop('checked', false);
            });
        });
        $(document).ready(function() {
            $('#permission_user').hide();
            $("div.action").hide();
            $("input[name$='permission']").on("click", function() {
                $("#permission_user").removeClass('show');
                if ($(this).attr("value") == "custom_permission") {
                    $("#permission_user").show();
                } else {
                    $("#permission_user").hide();
                }
            });

            $("input[name$='assigned_to[]']").on("click", function() {
                var user_id = $(this).val();
                $("#action_" + user_id).removeClass('show');
                if (this.checked) {
                    $("#action_" + user_id).show();
                } else {
                    $("#action_" + user_id).hide();
                }

            });
        });
    });
    //abort ajax request on modal close.
    $(document).on('hide.bs.modal', '#myModal_lg', function() {
        $('#myModal_lg').removeData('bs.modal');
    });
</script>