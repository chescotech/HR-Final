<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Users</title>
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
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Department.php';
        include_once '../Classes/Group.php';
        $GroupObject = new Group();
        $DepartmentObject = new Department();
        ?>

        <?php
        include '../navigation_panel/side_navigation_bar.php';

        if (isset($_POST['update'])) {
            return var_dump($_POST);

            $user_name = $_POST['user_name'];
            $password = md5($_POST['password']);
            $repassword = md5($_POST['repassword']);
            $group_id = $_POST['group_update'];
            $status = $_POST['status'];

            $id = $_POST['id'];

            if ($password == $repassword) {
                if ($status == "") {
                    $add_q = mysqli_query($link, "UPDATE users_tb SET user_name = '$user_name',"
                        . "password='$password' WHERE id = '$id' ") or die(mysqli_error($link));
                } else if (strlen($group_id) > 0) {
                    $add_q = mysqli_query($link, "
                    UPDATE users_tb SET user_name = '$user_name',"
                        . "password='$password', group_id = '$group_id' WHERE id = '$id'");
                } else {
                    $add_q = mysqli_query($link, "UPDATE users_tb SET user_name = '$user_name',"
                        . "password='$password',status='$status' WHERE id = '$id' ") or die(mysqli_error($link));
                }


                if ($add_q) {
                    echo "<script> alert('Updated Successfuly') </script>";
                    echo "<script> window.location='users' </script>";
                }
            } else {
                echo "<script> alert('Eror, passwords do not match!!') </script>";
                echo "<script> window.location='users' </script>";
            }
        }

        // if (isset($_POST['group_update'])) {
        //     return var_dump($_POST);
        //     $user_id = $_POST['user_id'];
        //     $newGroup = $_POST['group_update'];

        //     $update = $GroupObject->updateUserGroup($newGroup, $user_id);

        //     echo "<script> window.location='users' </script>";
        // }
        ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    $compID = $_SESSION['company_ID'];
                    echo $_SESSION['name'] . ' User List';
                    ?>
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-4">
                        <form action="add-users">
                            <table cellpadding="" border="0" class="se">
                                <tr>
                                    <td>
                                        <button type="submit" name="save" id="save" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add User</button>
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
                                            <th>Names</th>
                                            <th>User Name</th>
                                            <th>User Type</th>
                                            <th>Email</th>
                                            <th> Status</th>
                                            <th>Group</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $Departments = $DepartmentObject->getUsersByCompany($compID);
                                        while ($row = mysqli_fetch_array($Departments)) {
                                            $user_id = $row['id'];

                                        ?>
                                            <tr>
                                                <td><?php echo $row['firstname'] . ' ' . $row['lastname'];
                                                    ?></td>
                                                <td><?php echo $row['user_name'];
                                                    ?></td>
                                                <td><?php echo $row['user_type'];
                                                    ?></td>
                                                <td><?php echo $row['email_address'];
                                                    ?></td>
                                                <td><?php
                                                    if ($row['status'] != "Not Active") {
                                                        echo 'Active';
                                                    } else {
                                                        echo 'Not Active';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <div>
                                                        <form action="" method="post" id="group-form">
                                                            <span>
                                                                <?php
                                                                $current_group = $GroupObject->getGroupById($row['group_id']);
                                                                $row = mysqli_fetch_array($current_group);

                                                                echo '<h5 class="fw-bold p-2"> ' . $row['name'] . ' </h5>';
                                                                ?>
                                                            </span>
                                                            <select hidden name="group_update" class="dropdown" style="border: 0px; padding: 8px; " onchange="handleSelection()">
                                                                <option value=""><span>---Select an Option---</span></option>
                                                                <?php
                                                                $groupList = $GroupObject->getGroups($_SESSION['company_ID']);


                                                                while ($group_row = mysqli_fetch_array($groupList)) {
                                                                ?>
                                                                    <option name="group_update" class="list-menu-item" value="<?= $group_row['id'] ?>"><?= $group_row['name'] ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="edit-user.php?id=<?php echo $user_id; ?>" class="btn btn-primary btn-sm">Edit</i></a>
                                                </td>
                                            </tr>


                                        <?php } ?>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div>
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
    <script>
        function handleSelection() {
            event.preventDefault();
            let parent_form = document.getElementById('group-form');
            parent_form.submit();
        }
    </script>
</body>

</html>