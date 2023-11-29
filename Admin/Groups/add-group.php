<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Group</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.print.css" media="print">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <script src="../../js/jquery.min.js"></script>

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <!-- Left side column. contains the logo and sidebar -->
        <?php
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Group.php';
        $GroupObject = new Group();
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['save_group'])) {
            // return var_dump($_POST);
            $stateMessage = "";
            $group_name = $_POST['group_name'];
            $comp_setup = $_POST['comp_setup'] ? "true" : "false";
            $employee = $_POST['employee'] ? "true" : "false";
            $hr_reports = $_POST['hr_reports'] ? "true" : "false";
            $payroll = $_POST['payroll'] ? "true" : "false";
            $payroll_reports = $_POST['payroll_reports'] ? "true" : "false";
            $settings = $_POST['settings'] ? "true" : "false";
            $recruitment = $_POST['recruitment'] ? "true" : "false";
            $users = $_POST['users'] ? "true" : "false";
            $groups = $_POST['groups'] ? "true" : "false";
            $companyId = $_SESSION['company_ID'];

            $query_result = $GroupObject->createGroup($group_name, $companyId, $comp_setup, $employee, $hr_reports, $payroll, $payroll_reports, $settings, $recruitment, $users, $groups);


            if ($query_result) {
                $stateMessage = "Group created successfully. You may now add users to this group.";
            } else {
                $stateMessage = "Group creation failed. Please try again.";
            }
            // return var_dump($stateMessage);
            header("Location:add-group.php");
        ?>
        <?php
        }
        ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">

            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <a href="groups" class="btn btn-primary btn-block margin-bottom">Back</a>
                        <div class="box box-solid">
                        </div><!-- /. box -->

                    </div><!-- /.col -->
                    <div class="col-md-5">
                        <form method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <?php
                                    if (isset($_POST['save_post']) && $stateMessage == "Group created successfully. You may now add users to this group.") {
                                        echo ' <center>
                                            <h3 style="color: green" class="box-title"><b>' . $stateMessage . '</b></h3>
                                        </center>';
                                    } else if (isset($_POST['save_post']) && $stateMessage != "Group creation failed. Please try again.") {
                                        echo ' <center>
                                            <h3 style="color: red" class="box-title"><b>' . $stateMessage . '</b></h3>
                                        </center>';
                                    } else {
                                        echo ' <center>
                                            <h3 style="color: black" class="box-title"><b>Create New Group</b></h3>
                                        </center>';
                                    }
                                    ?>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Name</b></h5>
                                        <input required="required" name="group_name" class="form-control" placeholder="Name:">
                                    </div>
                                    <div class="form-group">
                                        <h3>
                                            Permissions
                                        </h3>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input name="comp_setup" type="checkbox" aria-label="...">
                                                    </span>
                                                    <input type="text" class="form-control" aria-label="..." value="Company Setup" disabled>
                                                </div><!-- /input-group -->
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input name="employee" type="checkbox" aria-label="...">
                                                    </span>
                                                    <input type="text" class="form-control" aria-label="..." value="Employee" disabled>
                                                </div><!-- /input-group -->
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input name="hr_reports" type="checkbox" aria-label="...">
                                                    </span>
                                                    <input type="text" class="form-control" aria-label="..." value="HR Reports" disabled>
                                                </div><!-- /input-group -->
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input name="payroll" type="checkbox" aria-label="...">
                                                    </span>
                                                    <input type="text" class="form-control" aria-label="..." value="Payroll" disabled>
                                                </div><!-- /input-group -->
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input name="payroll_reports" type="checkbox" aria-label="...">
                                                    </span>
                                                    <input type="text" class="form-control" aria-label="..." value="Payroll Reports" disabled>
                                                </div><!-- /input-group -->
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input name="settings" type="checkbox" aria-label="...">
                                                    </span>
                                                    <input type="text" class="form-control" aria-label="..." value="Settings" disabled>
                                                </div><!-- /input-group -->
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input name="recruitment" type="checkbox" aria-label="...">
                                                    </span>
                                                    <input type="text" class="form-control" aria-label="..." value="Recruitment" disabled>
                                                </div><!-- /input-group -->
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input name="users" type="checkbox" aria-label="...">
                                                    </span>
                                                    <input type="text" class="form-control" aria-label="..." value="Users" disabled>
                                                </div><!-- /input-group -->
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input name="groups" type="checkbox" aria-label="...">
                                                    </span>
                                                    <input type="text" class="form-control" aria-label="..." value="Groups" disabled>
                                                </div><!-- /input-group -->
                                            </div </div>
                                        </div>


                                    </div>
                                    <div class="box-footer">
                                        <div class="pull-right">
                                            <button name="save_group" type="submit" class="btn btn-primary"></i>Save</button>
                                        </div>
                                        <button onclick="window.history.back();" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                    </div><!-- /.box-footer -->
                                </div><!-- /. box -->

                        </form>

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <?php include '../footer/footer.php'; ?>

        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- Slimscroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- iCheck -->
    <script src="../plugins/iCheck/icheck.min.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Page Script -->
    <script>
        $(function() {
            //Add text editor
            $("#compose-textarea").wysihtml5();
        });
    </script>
</body>

</html>