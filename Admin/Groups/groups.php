<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Groups</title>
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
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/Group.php';
        $GroupObject = new Group();
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php
        include '../navigation_panel/side_navigation_bar.php';

        if (isset($_POST['update_group'])) {
            $group_id = $_POST['group_id'];
            $group_name = $_POST['name'];
            $comp_setup = $_POST['comp_setup'] ? "true" : "false";
            $employee = $_POST['employee'] ? "true" : "false";
            $hr_reports = $_POST['hr_reports'] ? "true" : "false";
            $payroll = $_POST['payroll'] ? "true" : "false";
            $payroll_reports = $_POST['payroll_reports'] ? "true" : "false";
            $settings = $_POST['settings'] ? "true" : "false";
            $recruitment = $_POST['recruitment'] ? "true" : "false";
            $users = $_POST['users'] ? "true" : "false";

            $query_result = $GroupObject->updateGroup($group_id, $comp_setup, $employee, $hr_reports, $payroll, $payroll_reports, $settings, $recruitment, $users);


            echo '<script>window.location.assign("groups")</script>';
        }

        if (isset($_POST['delete_group'])) {
            // return var_dump($_POST);
            $group_id = $_POST['group_id'];

            $query_result = $GroupObject->deleteGroup($group_id);

            header("Location:groups.php");
        }
        ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    $compID = $_SESSION['company_ID'];
                    echo $_SESSION['name'] . ' Group List';
                    ?>
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-4">
                        <form action="add-group">
                            <table cellpadding="" border="0" class="se">
                                <tr>
                                    <td>
                                        <button type="submit" name="save" id="save" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Create Group</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <br></br>
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body">
                                <table id="employee_data" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Members</th>
                                            <th>Members List</th>
                                            <!-- <th>Email</th>
                                            <th> Status</th>
                                            <th>Group</th> -->
                                            <th>Groups</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $Groups = $GroupObject->getGroups($_SESSION['company_ID']);
                                        while ($row = mysql_fetch_array($Groups)) {
                                            $id = $row['id'];
                                            $grp_name = $row['name'];
                                        ?>
                                            <tr>
                                                <td><?php echo $grp_name;
                                                    ?></td>
                                                <td>
                                                    <?php
                                                    $memberCount = $GroupObject->getGroupMemberCount($id, $_SESSION['company_ID']);
                                                    echo $memberCount;
                                                    ?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-default" href="members?group=<?= $id ?>">View Members</a>
                                                </td>
                                                <td>
                                                    <a href="#updateordinance<?php echo $id; ?>" data-target="#updateordinance<?php echo $id; ?>" data-toggle="modal" style="color:#fff;" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span> Manage Permissions</i></a>
                                                    <a href="#deleteordinance<?php echo $id; ?>" data-target="#deleteordinance<?php echo $id; ?>" data-toggle="modal" style="color:#000; background: #f01" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> Delete</i></a>

                                                </td>
                                                <!-- <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            Select an Option
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="#">Group 1</a></li>
                                                            <li><a href="#">Group 2</a></li>
                                                            <li><a href="#">Group 3</a></li>

                                                        </ul>
                                                    </div>
                                                </td> -->

                                            </tr>
                                            <div id="updateordinance<?php echo $id ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content" style="height:auto">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span></button>
                                                            <h4 class="modal-title">Update Group Permissions </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php
                                                            // TODO: Get group permissions
                                                            $permissions = $GroupObject->getGroupPermissions($id);

                                                            $perm_row = mysql_fetch_array($permissions);
                                                            //  company_setup	employee	hr_reports	payroll	payroll_reports	settings	recruitment	users
                                                            $comp_setup_perm = $perm_row['company_setup'];
                                                            $employee_perm = $perm_row['employee'];
                                                            $hr_rep_perm = $perm_row['hr_reports'];
                                                            $pay_perm = $perm_row['payroll'];
                                                            $pay_rep_perm = $perm_row['reports'];
                                                            $settings_perm = $perm_row['settings'];
                                                            $rec_perm = $perm_row['recruitment'];
                                                            $users_perm = $perm_row['users'];
                                                            $groups_perm = $perm_row['groups'];
                                                            ?>
                                                            <form method="post">
                                                                <div class="box box-primary">

                                                                    <div class="box-body">

                                                                        <div class="form-group">
                                                                            <h5 style="color: black"><b>Name</b></h5>
                                                                            <input required name="group_name" class="form-control" placeholder="Name:" value="<?= $grp_name ?>">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5>
                                                                                Permissions
                                                                            </h5>
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-addon">
                                                                                            <input name="comp_setup" type="checkbox" aria-label="..." <?php echo $comp_setup_perm == 'true' ? "checked" : '' ?>>
                                                                                        </span>
                                                                                        <input type="text" class="form-control" aria-label="..." value="Company Setup" disabled>
                                                                                    </div><!-- /input-group -->
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-addon">
                                                                                            <input name="employee" type="checkbox" aria-label="..." <?php echo $employee_perm == 'true' ? "checked" : '' ?>>
                                                                                        </span>
                                                                                        <input type="text" class="form-control" aria-label="..." value="Employee" disabled>
                                                                                    </div><!-- /input-group -->
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-addon">
                                                                                            <input name="hr_reports" type="checkbox" aria-label="..." <?php echo $hr_rep_perm == 'true' ? "checked" : '' ?>>
                                                                                        </span>
                                                                                        <input type="text" class="form-control" aria-label="..." value="HR Reports" disabled>
                                                                                    </div><!-- /input-group -->
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-addon">
                                                                                            <input name="payroll" type="checkbox" aria-label="..." <?php echo $pay_perm == 'true' ? "checked" : '' ?>>
                                                                                        </span>
                                                                                        <input type="text" class="form-control" aria-label="..." value="Payroll" disabled>
                                                                                    </div><!-- /input-group -->
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-addon">
                                                                                            <input name="payroll_reports" type="checkbox" aria-label="..." <?php echo $pay_rep_perm == 'true' ? "checked" : '' ?>>
                                                                                        </span>
                                                                                        <input type="text" class="form-control" aria-label="..." value="Payroll Reports" disabled>
                                                                                    </div><!-- /input-group -->
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-addon">
                                                                                            <input name="settings" type="checkbox" aria-label="..." <?php echo $settings_perm == 'true' ? "checked" : '' ?>>
                                                                                        </span>
                                                                                        <input type="text" class="form-control" aria-label="..." value="Settings" disabled>
                                                                                    </div><!-- /input-group -->
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-addon">
                                                                                            <input name="recruitment" type="checkbox" aria-label="..." <?php echo $rec_perm == 'true' ? "checked" : '' ?>>
                                                                                        </span>
                                                                                        <input type="text" class="form-control" aria-label="..." value="Recruitment" disabled>
                                                                                    </div><!-- /input-group -->
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-addon">
                                                                                            <input name="users" type="checkbox" aria-label="..." <?php echo $users_perm == 'true' ? "checked" : '' ?>>
                                                                                        </span>
                                                                                        <input type="text" class="form-control" aria-label="..." value="Users" disabled>
                                                                                    </div><!-- /input-group -->
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-addon">
                                                                                            <input name="groups" type="checkbox" aria-label="..." <?php echo $groups_perm == 'true' ? "checked" : '' ?>>
                                                                                        </span>
                                                                                        <input type="text" class="form-control" aria-label="..." value="Groups" disabled>
                                                                                    </div><!-- /input-group -->
                                                                                    <input type="hidden" name="group_id" value="<?= $id ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                    <div class="box-footer">
                                                                        <div class="pull-right">
                                                                            <button name="update_group" type="submit" class="btn btn-primary"></i>Save</button>
                                                                        </div>
                                                                        <button data-dismiss="modal" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                                                    </div><!-- /.box-footer -->
                                                                </div><!-- /. box -->

                                                            </form>
                                                        </div>

                                                    </div>
                                                    <!--end of modal-dialog-->

                                                </div>
                                            </div>
                                            <!-- delete confirmation modal -->
                                            <div id="deleteordinance<?php echo $id ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content" style="height:auto">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span></button>
                                                            <h4 class="modal-title">Delete Group Confirmation </h4>
                                                        </div>
                                                        <div class="modal-body">

                                                            <form method="post">
                                                                <div class="box box-primary">

                                                                    <div class="box-body">

                                                                        <p>
                                                                            Are you sure you want to delete this group?
                                                                        </p>

                                                                        <input type="hidden" name="group_id" value="<?= $id ?>">
                                                                    </div>
                                                                    <div class="box-footer">
                                                                        <div class="pull-right">
                                                                            <button name="delete_group" type="submit" class="btn btn-danger" style="background: #f01;"></i>Delete</button>
                                                                        </div>
                                                                        <button data-dismiss="modal" class="btn btn-default"><i class="fa fa-times"></i>Cancel</button>
                                                                    </div><!-- /.box-footer -->
                                                                </div><!-- /. box -->

                                                            </form>
                                                        </div>

                                                    </div>
                                                    <!--end of modal-dialog-->

                                                </div>
                                            </div>
                                        <?php } ?>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div>
        <?php include '../footer/footer.php'; ?>
        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>

    <!-- SlimScroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- page script -->
    <script>
        $(document).ready(function() {
            $('#employee_data').DataTable();
        });
    </script>
</body>

</html>