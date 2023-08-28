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

        if (isset($_POST['remove'])) {
            $groupid = 0;
            $userid = $_POST['user_id'];

            $updated = $GroupObject->updateUserGroup($groupid, $userid);

            header('Location:groups.php');
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
                        <table cellpadding="" border="0" class="se">
                            <tr>
                                <td>
                                    <button name="save" id="save" type="button" class="btn btn-primary" onclick="history.back()"><span class="glyphicon glyphicon-left"></span> Back</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <br></br>
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body">
                                <table id="employee_data" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>
                                                Last Name
                                            </th>

                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $GroupMembers = $GroupObject->getGroupMembers($_GET['group'], $_SESSION['company_ID']);
                                        while ($row = mysql_fetch_array($GroupMembers)) {
                                            $id = $row['id'];
                                        ?>
                                            <tr>
                                                <td><?php echo $row['firstname'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['lastname']; ?>
                                                </td>
                                                <td>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="user_id" value="<?= $id ?>">
                                                        <input type="hidden" name="group_id" value="<?= $_GET['group'] ?>">
                                                        <button name="remove" class="btn btn-danger" style="background: #f56;" type="submit">Remove</button>
                                                    </form>
                                                </td>
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
                                                            <form method="post">
                                                                <div class="box box-primary">

                                                                    <div class="box-body">

                                                                        <div class="form-group">
                                                                            <h5 style="color: black"><b>Name</b></h5>
                                                                            <input required="required" name="group_name" class="form-control" placeholder="Name:">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5>
                                                                                Permissions
                                                                            </h5>
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
                                                        </div>

                                                    </div>
                                                    <!--end of modal-dialog-->
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